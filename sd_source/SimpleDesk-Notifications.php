<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2021 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1 RC1                                 *
* File Info: SimpleDesk-Notifications.php                     *
**************************************************************/

/**
 *	@package source
 *	@since 2.0
*/

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Notification for new tickets
 *
 *	@since 2.0
 *	@param int &$msgOptions The message options, similar to the createPost in Subs-Post.php
 *	@param int &$ticketOptions The ticket options, similar to the createPost topicOptions in Subs-Post.php
 *	@param int &$posterOptions The poster options, similar to the createPost in Subs-Post.php
*/
function shd_notifications_notify_newticket(&$msgOptions, &$ticketOptions, &$posterOptions)
{
	global $smcFunc, $context, $modSettings, $scripturl;

	// Enabled?
	if (empty($modSettings['shd_notify_new_ticket']))
		return;

	// We don't always have this. But it should be available elsewhere.
	if (!isset($ticketOptions['private']))
		$ticketOptions['private'] = $context['ticket_form']['private']['setting'];
	if (empty($posterOptions['name']))
		$posterOptions['name'] = $context['user']['name'];
	if (empty($ticketOptions['subject']))
		$ticketOptions['subject'] = $context['ticket_form']['subject'];

	// So, we're getting the list of people that are being affected by this ticket being posted. Basically, that's a list of staff on new ticket, less people who've set preferences otherwise.
	$members = shd_get_visible_list($ticketOptions['dept'], $ticketOptions['private'], 0, empty($modSettings['shd_admins_not_assignable']), false);
	if (empty($members))
		return;

	// Get the default preferences
	$prefs = shd_load_user_prefs(false);
	$base_prefs = $prefs['prefs'];

	// Apply the default preference
	$members = array_flip($members);
	foreach ($members as $member => $value)
		$members[$member] = $base_prefs['notify_new_ticket']['default'];

	// Query the database for the rest.
	$query = $smcFunc['db_query']('', '
		SELECT id_member, value
		FROM {db_prefix}helpdesk_preferences
		WHERE id_member IN ({array_int:members})
			AND variable = {string:pref}',
		array(
			'members' => array_keys($members),
			'pref' => 'notify_new_ticket',
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$members[(int) $row['id_member']] = $row['value'];
	$smcFunc['db_free_result']($query);

	// OK, now figure out who we're sending to, and discard any member id's we're not sending to
	foreach ($members as $member => $value)
		if (!empty($value))
			$members[$member] = 'new_ticket';
		else
			unset($members[$member]);

	if (isset($members[$context['user']['id']]))
		unset($members[$context['user']['id']]);

	if (empty($members))
		return;

	// Build the big ol' data set
	shd_notify_users(array(
		'members' => $members,
		'ticketlink' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $ticketOptions['id'],
		'subject' => $ticketOptions['subject'],
		'ticket' => $ticketOptions['id'],
		'body' => $msgOptions['body'],
		'poster_name' => $posterOptions['name'],
	));
}

/**
 *	Notifications for new replies
 *
 *	@since 2.0
 *	@param int &$msgOptions The message options, similar to the createPost in Subs-Post.php
 *	@param int &$ticketOptions The ticket options, similar to the createPost topicOptions in Subs-Post.php
 *	@param int &$posterOptions The poster options, similar to the createPost in Subs-Post.php
*/
function shd_notifications_notify_newreply(&$msgOptions, &$ticketOptions, &$posterOptions)
{
	global $smcFunc, $context, $modSettings, $scripturl;

	// We did actually get a reply? Sometimes shd_modify_ticket_post() is called for other things, not just on reply.
	if (empty($msgOptions['body']))
		return;
	// Alternatively, they might be doing a silent update.
	elseif (!empty($_POST['silent_update']) && shd_allowed_to('shd_silent_update', $ticketOptions['dept']))
		return;

	// We're doing various things here, so grab some general details, not just what we may have been passed before.
	$ticketinfo = shd_load_ticket($ticketOptions['id']);
	// $staff is the sum total of staff + ticket starter, subject to visibility of the ticket.
	$staff = shd_get_visible_list($ticketOptions['dept'], $ticketinfo['private'], $ticketinfo['starter_id'], empty($modSettings['shd_admins_not_assignable']), false);

	// Might as well kick this off here.
	$notify_data = array(
		'members' => array(),
		'ticketlink' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $ticketOptions['id'] . '.msg' . $msgOptions['id'] . '#msg' . $msgOptions['id'],
		'subject' => $ticketinfo['subject'],
		'ticket' => $ticketOptions['id'],
		'msg' => $msgOptions['id'],
		'body' => $msgOptions['body'],
		'poster_name' => $posterOptions['name'],
	);

	$members = array(); // who should get what type of notification, preferences depending

	// Someone replied to MY ticket? And it isn't me? I might want you to tell me about it!
	if (!empty($ticketinfo['starter_id']) && !empty($modSettings['shd_notify_new_reply_own']) && $posterOptions['id'] != $ticketinfo['starter_id'] && in_array($ticketinfo['starter_id'], $staff))
		$members[$ticketinfo['starter_id']]['new_reply_own'] = true;

	// So this is a ticket I'm supposed to deal with... has someone said something I missed? (And just in case it's our ticket, don't send another)
	if (!empty($modSettings['shd_notify_new_reply_assigned']))
		if (!empty($ticketinfo['assigned_id']) && $posterOptions['id'] != $ticketinfo['assigned_id'] && in_array($ticketinfo['assigned_id'], $staff))
			$members[$ticketinfo['assigned_id']]['new_reply_assigned'] = true;

	// So, if you're staff, and you've replied to a ticket before, do you want to be notified this time?
	if (!empty($modSettings['shd_notify_new_reply_previous']))
	{
		$query = $smcFunc['db_query']('', '
			SELECT id_member
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_ticket = {int:ticket}
			GROUP BY id_member',
			array(
				'ticket' => $ticketOptions['id'],
			)
		);
		$responders = array();
		while ($row = $smcFunc['db_fetch_row']($query))
			$responders[] = $row[0]; // this shouldn't be nil, ever, because we're replying, so the topic already exists so there's at least one name in there...
		$smcFunc['db_free_result']($query);

		$responders = array_intersect($responders, $staff);
		foreach ($responders as $id)
			$members[$id]['new_reply_previous'] = true;
	}

	// Do staff just want general notifications about everything? Don't change things if they already had a notice though, this is just for the rabble at the back
	if (!empty($modSettings['shd_notify_new_reply_any']))
		foreach ($staff as $id)
			$members[$id]['new_reply_any'] = true;

	if (empty($members))
		return;

	// Get the default preferences
	$prefs = shd_load_user_prefs(false);
	$base_prefs = $prefs['prefs'];

	// Build a list of users -> default prefs
	$member_prefs = array();
	$pref_list = array();
	foreach ($members as $id => $type_list)
	{
		foreach ($type_list as $type => $value)
		{
			$member_prefs[$id][$type] = $base_prefs['notify_' . $type]['default'];
			$pref_list['notify_' . $type] = true;
		}
	}

	// Grab pref list from DB for these users and update
	$query = $smcFunc['db_query']('', '
		SELECT id_member, variable, value
		FROM {db_prefix}helpdesk_preferences
		WHERE id_member IN ({array_int:members})
			AND variable IN ({array_string:variables})',
		array(
			'members' => array_keys($members),
			'variables' => array_keys($pref_list),
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$row['id_member'] = (int) $row['id_member'];
		$variable = substr($row['variable'], 7);
		if (isset($member_prefs[$row['id_member']][$variable]))
			$member_prefs[$row['id_member']][$variable] = $row['value'];
	}
	$smcFunc['db_free_result']($query);

	// unset $members where member pref doesn't fit
	foreach ($member_prefs as $id => $value)
		foreach ($value as $pref_id => $pref_item)
			if (empty($pref_item))
				unset($members[$id][$pref_id]);

	// Lastly, get the list of people who wanted to be notified through their preferences - and anyone who wanted to be excluded.
	$overrides = shd_query_monitor_list($ticketOptions['id']);
	foreach ($overrides['always_notify'] as $member_id)
		$members[$member_id]['monitor'] = true;

	// And apply exclusions
	foreach ($overrides['never_notify'] as $member_id)
		unset($members[$member_id]);

	// And now, finally, receive the list of possible cases from the notification doodad, and verify against a list of possible people.
	if ($context['can_ping'])
	{
		if (!empty($_POST['notify']) && is_array($_POST['notify']))
		{
			$staff[] = $ticketinfo['starter_id']; // Add the ticket starter as a possible candidate.
			foreach ($_POST['notify'] as $id)
				if (in_array((int) $id, $staff))
					$members[$id]['ping'] = true;
		}
		elseif (!empty($_REQUEST['list']))
		{
			$list = explode(',', $_REQUEST['list']);
			foreach ($list as $id)
				if (in_array((int) $id, $staff))
					$members[$id]['ping'] = true;
		}
	}

	// Lastly, prevent the reply author getting notified for any reason.
	if (!empty($members[$context['user']['id']]))
		unset($members[$context['user']['id']]);

	// So, at this point, $members contains a list of the members and a sequence of the possible messages they could get. We need to make some sense of it.
	$notify_data['members'] = array();
	foreach ($members as $member_id => $notify_list)
	{
		if (empty($notify_list))
			continue; // Preferences killed all their possible choices.

		// We want the first non empty value on the list, and that's all.
		$item = '';
		foreach ($notify_list as $k => $v)
		{
			if (!empty($v))
			{
				$item = $k;
				break;
			}
		}

		if (!empty($item))
			$notify_data['members'][$member_id] = $item; // We want the first one only.
	}

	// AAAAAAAAAAAAND WE'RE OFF!
	if (!empty($notify_data['members']))
		shd_notify_users($notify_data);
}

/**
 *	Notificaiton for assignments
 *
 *	@since 2.0
 *	@param int &$ticket The ticket id
 *	@param int &$assignment Who the ticket is being assigned to.
*/
function shd_notifications_notify_assign(&$ticket, &$assignment)
{
	global $smcFunc, $context, $modSettings, $scripturl;

	if (empty($modSettings['shd_notify_assign_me']) && empty($modSettings['shd_notify_assign_own']))
		return;

	$ticketinfo = shd_load_ticket($ticket);
	// ticket starter = $ticketinfo['starter_id']
	// $assignment = user id of assignee (0 for no longer being assigned)

	$notify_data = array(
		'members' => array(),
		'ticketlink' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $ticket . '.0',
		'subject' => $ticketinfo['subject'],
		'ticket' => $ticket,
	);

	// Get the default preferences
	$prefs = shd_load_user_prefs(false);
	$base_prefs = $prefs['prefs'];

	$members = array();
	$member_prefs = array();
	// So, does the starter want to be notified if the ticket is assigned?
	if (!empty($ticketinfo['starter_id']) && !empty($modSettings['shd_notify_assign_own']))
	{
		$members[$ticketinfo['starter_id']] = 'assign_own';
		$member_prefs[$ticketinfo['starter_id']] = $base_prefs['notify_assign_own']['default'];
	}

	// Does the assignee want to be notified? This assumes it is actually a person...
	if (!empty($assignment) && !empty($modSettings['shd_notify_assign_me']))
	{
		$members[$assignment] = 'assign_me';
		$member_prefs[$assignment] = $base_prefs['notify_assign_me']['default'];
	}

	if (isset($members[$context['user']['id']]))
		unset($members[$context['user']['id']]);

	if (empty($members))
		return; // whoops

	// OK, so we've figured out what we'd send to folks. Now let's see what the users want
	$query = $smcFunc['db_query']('', '
		SELECT id_member, variable, value
		FROM {db_prefix}helpdesk_preferences
		WHERE id_member IN ({array_int:members})
			AND variable IN ({array_string:variables})',
		array(
			'members' => array_keys($members),
			'variables' => array('notify_assign_me', 'notify_assign_own'),
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$row['id_member'] = (int) $row['id_member'];
		if ($row['variable'] == 'notify_' . $members[$row['id_member']])
			$member_prefs[$row['id_member']] = $row['value'];
	}
	$smcFunc['db_free_result']($query);

	// unset $members where member pref doesn't fit
	foreach ($member_prefs as $id => $value)
		if (empty($value))
			unset($members[$id]);

	// move $members to $notify_data['members']
	$notify_data['members'] = $members;

	// AAAAAAAAAAAAND WE'RE OFF!
	if (!empty($notify_data['members']))
		shd_notify_users($notify_data);
}

/**
 *	Handle email notifications
 *
 *	@todo Finish documenting
 *	@param mixed $notify_data Array of data containing notification informationt o be sent out.
*/
function shd_notify_users($notify_data)
{
	global $context, $txt, $modSettings, $language, $smcFunc, $sourcedir;

	if (empty($notify_data['members']))
		return;

	// So, for the folks we're sending a message to, figure out what languages etc we're loading
	$notify_lang = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_member, lngfile, email_address
		FROM {db_prefix}members
		WHERE id_member IN ({array_int:members})',
		array(
			'members' => array_keys($notify_data['members']),
		)
	);

	$emails = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$needed_language = empty($row['lngfile']) || empty($modSettings['userLanguage']) ? $language : $row['lngfile'];
		if (empty($notify_lang[$needed_language]))
			$notify_lang[$needed_language] = array();

		$notify_lang[$needed_language][] = $row['id_member'];
		$emails[$row['id_member']] = $row['email_address'];
	}
	$smcFunc['db_free_result']($query);

	// So, at this point, we have our list of language files to load so we can minimise the amount of actual work going on, and let's get ready
	$replacements = array(
		'{ticket_id}' => str_pad($notify_data['ticket'], $modSettings['shd_zerofill'], '0', STR_PAD_LEFT),
		'{subject}' => $notify_data['subject'],
		'{ticketlink}' => $notify_data['ticketlink'],
	);

	if (isset($notify_data['poster_name']))
		$replacements['{poster_name}'] = $notify_data['poster_name'];
	if (isset($notify_data['body']))
		$replacements['{body}'] = trim(un_htmlspecialchars(strip_tags(strtr(shd_format_text($notify_data['body'], false), array('<br>' => "\n", '</div>' => "\n", '</li>' => "\n", '&#91;' => '[', '&#93;' => ']')))));
	$withbody = isset($notify_data['body']) && !empty($modSettings['shd_notify_with_body']) ? 'bodyfull' : 'body';

	// Also note, we may not be coming from the post code... so make sure sendmail() is available
	if (!function_exists('sendmail'))
		require_once($sourcedir . '/Subs-Post.php');

	$log = array(
		'emails' => array(),
		'auto' => true,
		'subject' => $notify_data['subject'],
		'withbody' => $withbody == 'bodyfull',
	);
	foreach ($notify_lang as $this_lang => $lang_members)
	{
		shd_load_language('sd_language/SimpleDeskNotifications', $this_lang);

		foreach ($lang_members as $member)
		{
			$email_type = $notify_data['members'][$member];

			$subject = str_replace(array_keys($replacements), array_values($replacements), $txt['template_subject_notify_' . $email_type]);

			$body = $txt['template_' . $withbody . '_notify_' . $email_type] . "\n\n" . $txt['regards_team'];
			$body = str_replace(array_keys($replacements), array_values($replacements), $body);

			if (!isset($log['emails'][$email_type]))
				$log['emails'][$email_type] = array(
					'u' => array(),
				);

			// Now then, do we have a member?
			if (!empty($member))
				$log['emails'][$email_type]['u'][] = $member;

			//function sendmail($to, $subject, $message, $from = null, $message_id = null, $send_html = false, $priority = 3, $hotmail_fix = null, $is_private = false)
			if (!empty($modSettings['shd_notify_email']))
				$modSettings['mail_from'] = $modSettings['shd_notify_email'];
			sendmail($emails[$member], $subject, $body, null, 'shd_notify_' . $email_type . '_' . $member);
		}
	}

	// Now, let's fix up the log items. In the action log, emails is an array of notify subtypes, that relate to template_subject_notify_* in the notifications language file.
	// Within the type subarray, there's u and e, u is a comma separated list of user ids, e is a comma separated list of non user id emails.
	foreach ($log['emails'] as $type => $data)
	{
		if (!empty($data['u']))
			$log['emails'][$type]['u'] = implode(',', $data['u']);
		else
			unset($log['emails'][$type]['u']);

		if (empty($log['emails'][$type]))
			unset($log['emails'][$type]);
	}

	// We're doing it manually because we're bending some of the rules. It bypasses the usual shd_logopt_* check and the last_update change.
	if (empty($modSettings['shd_disable_action_log']) && !empty($log['emails']) && !empty($modSettings['shd_notify_log']))
		$smcFunc['db_insert']('',
			'{db_prefix}helpdesk_log_action',
			array(
				'log_time' => 'int', 'id_member' => 'int', 'ip' => 'string-16', 'action' => 'string', 'id_ticket' => 'int', 'id_msg' => 'int', 'extra' => 'string-65534',
			),
			array(
				time(), 0, '', 'notify', $notify_data['ticket'], !empty($notify_data['msg']) ? $notify_data['msg'] : 0, json_encode($log),
			),
			array('id_action')
		);
}

/**
 *	Display the notice of email.
 *
 *	@todo Finish documenting
 *	@since 2.0
*/
function shd_notify_popup()
{
	global $txt, $context, $settings, $modSettings, $smcFunc, $user_profile, $user_info, $scripturl;

	// First, verify we got a log entry, that the log entry is right, and it points to a ticket we can actually see.
	$_GET['log'] = isset($_GET['log']) ? (int) $_GET['log'] : 0;

	$email_type = isset($_GET['template']) ? preg_replace('~[^a-z_]~', '', $_GET['template']) : '';

	if (empty($modSettings['shd_display_ticket_logs']) || empty($_GET['log']) || empty($email_type))
		shd_fatal_lang_error('no_access', false);

	$query = $smcFunc['db_query']('', '
		SELECT hdla.id_member, hdla.id_ticket, hdla.id_msg, hdla.extra, COALESCE(hdtr.body, {string:empty}) AS body, COALESCE(mem.real_name, hdtr.poster_name) AS poster_name
		FROM {db_prefix}helpdesk_log_action AS hdla
			LEFT JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdla.id_msg = hdtr.id_msg)
			LEFT JOIN {db_prefix}members AS mem ON (hdtr.id_member = mem.id_member)
		WHERE id_action = {int:log}
			AND action = {string:notify}',
		array(
			'log' => $_GET['log'],
			'notify' => 'notify',
			'empty' => '',
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('no_access');
	}
	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	$row['extra'] = smf_json_decode($row['extra'], true);

	// Just check we did actually log an email of that type.
	if (empty($row['extra']['emails'][$_GET['template']]))
		shd_fatal_lang_error('no_access', false);

	$ticketinfo = shd_load_ticket($row['id_ticket']);

	// OK, if we're here, we can see the ticket. Can we actually see the email log at this point?
	if (!shd_allowed_to('shd_view_ticket_logs_any', $ticketinfo['dept']) && (!shd_allowed_to('shd_view_ticket_logs_own', $ticketinfo['dept']) || !$ticketinfo['is_own']))
		shd_fatal_lang_error('no_access', false);

	// We're reusing the Help template, need its language file.
	loadLanguage('Help');
	shd_load_language('sd_language/SimpleDeskAdmin');
	shd_load_language('sd_language/SimpleDeskLogAction');
	shd_load_language('sd_language/SimpleDeskNotifications');

	// Set the page up
	loadTemplate('Help');
	$context['page_title'] = $context['forum_name'] . ' - ' . $txt['shd_log_notifications'];
	$context['template_layers'] = array();
	$context['sub_template'] = 'popup';

	$users = array();
	// First, get the list of users, and load their username etc if we haven't already attempted it before.
	if (isset($row['extra']['emails'][$email_type]['u']))
		$users = array_merge($users, explode(',', $row['extra']['emails'][$email_type]['u']));
	if (!empty($users))
	{
		$users = array_unique($users);
		if (!empty($users))
			loadMemberData($users, false, 'minimal');
	}

	// Now we have all the usernames for this instance, let's go and build this entry.
	$context['help_text'] = $txt['shd_log_notify_to'] . '<br>';

	$new_content = '';
	if (!empty($users))
	{
		$first = true;
		foreach ($users as $user)
		{
			if (empty($user_profile[$user]))
				continue;

			$new_content .= ($first ? '<img src="' . shd_image_url('user.png') . '" alt=""> ' : ', ') . shd_profile_link($user_profile[$user]['real_name'], $user);
			$first = false;
		}
	}

	if (!empty($row['extra']['emails'][$email_type]['e']))
	{
		$emails = explode(',', $row['extra']['emails'][$email_type]['e']);
		// Admins can see the actual emails.
		if (shd_allowed_to('admin_helpdesk', 0) || $user_info['is_admin'])
		{
			foreach ($emails as $key => $value)
				$emails[$key] = '<a href="mailto:' . $value . '">' . $value . '</a>';
			$new_content .= '<img src="' . shd_image_url('log_notify.png') . '" alt=""> ' . implode(', ', $emails);
		}
		// No-one else can at the moment.
		else
			$new_content .= '<img src="' . shd_image_url('log_notify.png') . '" alt=""> ' . (count($emails) == 1 ? $txt['shd_log_notify_hiddenemail_1'] : sprintf($txt['shd_log_notify_hiddenemail'], count($emails)));
	}
	if (!empty($new_content))
		$context['help_text'] .= $new_content;

	$context['help_text'] .= '<hr>';

	// So the general prep is done. Now let's rebuild the email contents.
	if (empty($row['extra']['withbody']) || empty($row['body']))
		$body = '';
	else
		$body = trim(un_htmlspecialchars(strip_tags(strtr(shd_format_text($row['body'], false), array('<br>' => "\n", '</div>' => "\n", '</li>' => "\n", '&#91;' => '[', '&#93;' => ']')))));

	$replacements = array(
		"\n" => '<br>',
		'{ticket_id}' => str_pad($row['id_ticket'], $modSettings['shd_zerofill'], '0', STR_PAD_LEFT),
		'{subject}' => empty($row['extra']['subject']) ? $txt['no_subject'] : $row['extra']['subject'],
		'{ticketlink}' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $row['id_ticket'] . (empty($row['id_msg']) ? '.0' : '.msg' . $row['id_msg'] . '#msg' . $row['id_msg']),
		'{body}' => $body,
		'{poster_name}' => $row['poster_name'],
	);

	$email_subject = str_replace(array_keys($replacements), array_values($replacements), $txt['template_subject_notify_' . $email_type]);
	$email_body = str_replace(array_keys($replacements), array_values($replacements), $txt['template_' . (empty($row['extra']['withbody']) || empty($row['body']) ? 'body' : 'bodyfull') . '_notify_' . $email_type]);

	$context['help_text'] .= '<strong>' . $txt['subject'] . ':</strong> ' . $email_subject . '<br><br>' . $email_body;
}

/**
 *	Notification ticket options..
 *
 *	@todo Finish documenting
 *	@since 2.0
*/
function shd_notify_ticket_options()
{
	global $context, $txt, $smcFunc;

	$ticketinfo = shd_load_ticket(); // This does permissions to access the ticket too.
	$ticket_starter = $ticketinfo['starter_id'] == $context['user']['id'];

	checkSession();

	if (empty($_REQUEST['notifyaction']))
		$_REQUEST['notifyaction'] = '';

	// Get any existing entry.
	$query = $smcFunc['db_query']('', '
		SELECT notify_state
		FROM {db_prefix}helpdesk_notify_override
		WHERE id_member = {int:user}
			AND id_ticket = {int:ticket}',
		array(
			'user' => $context['user']['id'],
			'ticket' => $context['ticket_id'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
		$old_state = NOTIFY_PREFS;
	else
		list($old_state) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	switch ($_REQUEST['notifyaction'])
	{
		case 'monitor_on';
			if (!shd_allowed_to('shd_monitor_ticket_any', $ticketinfo['dept']) && (!$ticket_starter || !shd_allowed_to('shd_monitor_ticket_own', $ticketinfo['dept'])))
				shd_fatal_lang_error('cannot_monitor_ticket', false);

			// Unlike turning it off, we might be turning it on from either just off, or ignored, so log that fact.
			if ($old_state == NOTIFY_ALWAYS)
				break;
			elseif ($old_state == NOTIFY_NEVER)
				// Log turning off ignore list first
				shd_log_action('unignore',
					array(
						'ticket' => $context['ticket_id'],
						'subject' => $ticketinfo['subject'],
					)
				);
			// Then add the new status.
			$smcFunc['db_insert']('replace',
				'{db_prefix}helpdesk_notify_override',
				array(
					'id_member' => 'int', 'id_ticket' => 'int', 'notify_state' => 'int',
				),
				array(
					$context['user']['id'], $context['ticket_id'], NOTIFY_ALWAYS,
				),
				array('id_member', 'id_ticket')
			);
			shd_log_action('monitor',
				array(
					'ticket' => $context['ticket_id'],
					'subject' => $ticketinfo['subject'],
				)
			);
			break;
		case 'monitor_off';
			if (!shd_allowed_to('shd_monitor_ticket_any', $ticketinfo['dept']) && (!$ticket_starter || !shd_allowed_to('shd_monitor_ticket_own', $ticketinfo['dept'])))
				shd_fatal_lang_error('cannot_unmonitor_ticket', false);
			// Just delete the old status.
			$smcFunc['db_query']('', '
				DELETE FROM {db_prefix}helpdesk_notify_override
				WHERE id_member = {int:member}
					AND id_ticket = {int:ticket}',
				array(
					'member' => $context['user']['id'],
					'ticket' => $context['ticket_id'],
				)
			);
			shd_log_action('unmonitor',
				array(
					'ticket' => $context['ticket_id'],
					'subject' => $ticketinfo['subject'],
				)
			);
			break;
		case 'ignore_on';
			if (!shd_allowed_to('shd_ignore_ticket_any', $ticketinfo['dept']) && (!$ticket_starter || !shd_allowed_to('shd_ignore_ticket_own', $ticketinfo['dept'])))
				shd_fatal_lang_error('cannot_monitor_ticket', false);

			// Unlike turning it off, we might be turning it on from either just off, or ignored, so log that fact.
			if ($old_state == NOTIFY_NEVER)
				break;
			elseif ($old_state == NOTIFY_ALWAYS)
				// Log turning off ignore list first
				shd_log_action('unmonitor',
					array(
						'ticket' => $context['ticket_id'],
						'subject' => $ticketinfo['subject'],
					)
				);

			$smcFunc['db_insert']('replace',
				'{db_prefix}helpdesk_notify_override',
				array(
					'id_member' => 'int', 'id_ticket' => 'int', 'notify_state' => 'int',
				),
				array(
					$context['user']['id'], $context['ticket_id'], NOTIFY_NEVER,
				),
				array('id_member', 'id_ticket')
			);
			shd_log_action('ignore',
				array(
					'ticket' => $context['ticket_id'],
					'subject' => $ticketinfo['subject'],
				)
			);
			break;
		case 'ignore_off';
			if (!shd_allowed_to('shd_ignore_ticket_any', $ticketinfo['dept']) && (!$ticket_starter || !shd_allowed_to('shd_ignore_ticket_own', $ticketinfo['dept'])))
				shd_fatal_lang_error('cannot_unmonitor_ticket', false);

			$smcFunc['db_query']('', '
				DELETE FROM {db_prefix}helpdesk_notify_override
				WHERE id_member = {int:member}
					AND id_ticket = {int:ticket}',
				array(
					'member' => $context['user']['id'],
					'ticket' => $context['ticket_id'],
				)
			);
			shd_log_action('unignore',
				array(
					'ticket' => $context['ticket_id'],
					'subject' => $ticketinfo['subject'],
				)
			);
			break;
		default:
			break;
	}

	redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}

/**
 *	Builds a list of who should be notified or not.
 *
 *	@todo Finish documenting
 *	@since 2.0
*/
function shd_query_monitor_list($ticket_id)
{
	global $smcFunc;

	$members = array(
		'always_notify' => array(),
		'never_notify' => array(),
	);

	$query = $smcFunc['db_query']('', '
		SELECT id_member, notify_state
		FROM {db_prefix}helpdesk_notify_override
		WHERE id_ticket = {int:ticket}',
		array(
			'ticket' => $ticket_id,
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
		if ($row['notify_state'] == NOTIFY_ALWAYS)
			$members['always_notify'][] = $row['id_member'];
		elseif ($row['notify_state'] == NOTIFY_NEVER)
			$members['never_notify'][] = $row['id_member'];
	$smcFunc['db_free_result']($query);

	return $members;
}

/**
 *	Returns a list of all the possible people that would want notification, that can see the ticket we're interested in.
 *
 *	@param int $dept The department the given ticket is in.
 *	@param bool $private Whether the given ticket is private or not.
 *	@param int $ticket_starter User id of the ticket starter.
 *	@param bool $include_admin If false, exclude forum admins from the list of possible candidates.
 *	@param bool $include_current_user If true, exclude the current user from the list of possible candidates.
 *	@return array An array of user ids of the staff members (and ticket starter) that can see tickets, matching the given criteria of department, privacy and permissions.
*/
function shd_get_visible_list($dept, $private, $ticket_starter = 0, $include_admin = true, $include_current_user = false)
{
	global $smcFunc, $context;

	// So, the list of possible people will include the staff list and the ticket starter if provided.
	$people = shd_members_allowed_to('shd_staff', $dept);
	if (!empty($ticket_starter))
		$people[] = $ticket_starter;

	// Firstly, figure out who can see tickets that aren't their own. (Or that they can see their own and this is their ticket)
	$see_tickets = shd_members_allowed_to('shd_view_ticket_any', $dept);
	if (!empty($ticket_starter) && !in_array($ticket_starter, $see_tickets))
	{
		$see_own = shd_members_allowed_to('shd_view_ticket_own', $dept);
		if (in_array($ticket_starter, $see_own))
			$see_tickets[] = $ticket_starter;
	}
	$people = array_intersect($people, $see_tickets);

	// If the ticket is private, we need to figure out who can see it. This is tricky.
	if ($private)
	{
		$private = array_merge(shd_members_allowed_to('shd_view_ticket_private_any', $dept), shd_members_allowed_to('shd_alter_privacy_any', $dept));
		// That covers for those who can see any, what about those who can see own (but not any)?
		if (!empty($ticket_starter) && !in_array($ticket_starter, $private))
		{
			$own_private = array_merge(shd_members_allowed_to('shd_view_ticket_private_own', $dept), shd_members_allowed_to('shd_alter_privacy_own', $dept));
			if (in_array($ticket_starter, $own_private))
				$private[] = $ticket_starter;
		}
		$people = array_intersect($people, $private);
	}

	if (!$include_admin)
	{
		$query = $smcFunc['db_query']('', '
			SELECT id_member
			FROM {db_prefix}members
			WHERE id_group = 1
				OR FIND_IN_SET(1, additional_groups)',
			array()
		);

		$context['list_admin_exclude'] = array();
		while ($row = $smcFunc['db_fetch_row']($query))
			$context['list_admin_exclude'][] = $row[0];

		$smcFunc['db_free_result']($query);
		$people = array_diff($people, $context['list_admin_exclude']);
	}

	if (!$include_current_user)
		$people = array_diff($people, array($context['user']['id']));

	return $people;
}