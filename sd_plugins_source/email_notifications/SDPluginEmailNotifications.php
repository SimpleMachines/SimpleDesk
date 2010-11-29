<?php
###################################################################
#           Simple Desk Project - www.simpledesk.net              #
#                  Email Notifications Plugin                     #
###################################################################
#         An advanced help desk modifcation built on SMF          #
###################################################################
#                                                                 #
#           * Copyright 2010 - SimpleDesk.net                     #
#                                                                 #
#     This file and its contents are subject to the license       #
#     included with this distribution, license.txt, which         #
#     states that this software is New BSD Licensed.              #
#     Any questions, please contact SimpleDesk.net                #
#                                                                 #
###################################################################
# SimpleDesk Version: 1.0 Felidae                                 #
# File Info: SDPluginEmailNotifications.php / 1.0 Felidae         #
###################################################################

/**
 *	@package plugin-emailnotifications
 *	@since 1.1
*/

if (!defined('SMF'))
	die('Hacking attempt...');

function shd_notifications_notify_newticket(&$msgOptions, &$ticketOptions, &$posterOptions)
{
	global $smcFunc, $context, $modSettings, $scripturl;

	// Enabled?
	if (empty($modSettings['shd_notify_new_ticket']) || !in_array('email_notifications', $context['shd_plugins']))
		return;

	// So, we're getting the list of people that are being affected by this ticket being posted. Basically, that's a list of staff on new ticket, less people who've set preferences otherwise.
	$members = shd_members_allowed_to('shd_staff');
	if (empty($members))
		return;

	$members = array_diff($members, array($context['user']['id']));

	// Get the default preference (since this is controlled by plugin, i.e. here, we could just hardcode it, but in case someone modifies the default, let's load it from here)
	$pref_groups = array();
	$base_prefs = array();
	shd_notifications_prefs($pref_groups, $base_prefs);

	// Apply the default preference
	$members = array_flip($members);
	foreach ($members as $member => $value)
		$members[$member] = $base_prefs['notify_new_ticket']['default'];

	// Grab from the database
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
	{
		$row['id_member'] = (int) $row['id_member'];
		$members[$row['id_member']] = $row['value'];
	}
	$smcFunc['db_free_result']($query);

	// OK, now figure out who we're sending to, and discard any member id's we're not sending to
	foreach ($members as $member => $value)
	{
		if (!empty($value))
			$members[$member] = 'new_ticket'; // for the type of message to send
		else
			unset($members[$member]);
	}

	// Build the big ol' data set
	$notify_data = array(
		'members' => $members,
		'ticketlink' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $ticketOptions['id'],
		'subject' => $ticketOptions['subject'],
	);

	shd_notify_users($notify_data);
}

function shd_notifications_notify_newreply(&$msgOptions, &$ticketOptions, &$posterOptions)
{
	global $smcFunc, $context, $modSettings, $scripturl;

	// Is this mic on?
	if (!in_array('email_notifications', $context['shd_plugins']))
		return;

	// We did actually get a reply? Sometimes shd_modify_ticket_post() is called for other things, not just on reply.
	if (empty($msgOptions['body']))
		return;

	// We're doing various things here, so grab some general details, not just what we may have been passed before.
	$ticketinfo = shd_load_ticket($ticketOptions['id']);
	$staff = shd_members_allowed_to('shd_staff');

	// Might as well kick this off here.
	$notify_data = array(
		'members' => array(),
		'ticketlink' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $ticketOptions['id'] . '.msg' . $msgOptions['id'] . '#msg' . $msgOptions['id'],
		'subject' => $ticketinfo['subject'],
	);

	$members = array(); // who should get what type of notification, preferences depending

	// Someone replied to MY ticket? And it isn't me? Tell me about it!
	if (!empty($modSettings['shd_notify_new_reply_own']))
	{
		if ($posterOptions['id'] != $ticketinfo['starter_id'])
			$members[$ticketinfo['starter_id']] = 'new_reply_own';
	}

	// So this is a ticket I'm supposed to deal with... has someone said something I missed? (And just in case it's our ticket, don't send another)
	if (!empty($modSettings['shd_notify_new_reply_assigned']))
	{
		if ($posterOptions['id'] != $ticketinfo['assigned_id'] && empty($members[$ticketinfo['assigned_id']]))
			$members[$ticketinfo['assigned_id']] = 'new_reply_assigned';
	}

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
		{
			if (empty($members[$id]))
				$members[$id] = 'new_reply_previous';
		}
	}

	// Do staff just want general notifications about everything? Don't change things if they already had a notice though, this is just for the rabble at the back
	if (!empty($modSettings['shd_notify_new_reply_any']))
	{
		foreach ($staff as $id)
		{
			if (empty($members[$id]))
				$members[$id] = 'new_reply_any';
		}
	}

	if (empty($members))
		return;

	if (!empty($members[$context['user']['id']]))
		unset($members[$context['user']['id']]);

	// Get the default preference (since this is controlled by plugin, i.e. here, we could just hardcode it, but in case someone modifies the default, let's load it from here)
	$pref_groups = array();
	$base_prefs = array();
	shd_notifications_prefs($pref_groups, $base_prefs);

	// Build a list of users -> default prefs
	$member_prefs = array();
	foreach ($members as $id => $type)
		$member_prefs[$id] = $base_prefs['notify_' . $type]['default'];
	
	// Grab pref list from DB for these users and update
	$pref_list = array_unique(array_keys($members));
	$query = $smcFunc['db_query']('', '
		SELECT id_member, variable, value
		FROM {db_prefix}helpdesk_preferences
		WHERE id_member IN ({array_int:members})
			AND variable IN ({array_string:variables})',
		array(
			'members' => array_keys($members),
			'variables' => $pref_list,
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$row['id_member'] = (int) $row['id_member'];
		if ($row['variable'] == 'notify_' . $members[$row['id_member']])
			$member_prefs[$id] = $row['value'];
	}
	$smcFunc['db_free_result']($query);

	// unset $members where member pref doesn't fit
	foreach ($member_prefs as $id => $value)
	{
		if (empty($value))
			unset($members[$id]);
	}

	// move $members to $notify_data['members']
	$notify_data['members'] = $members;

	// AAAAAAAAAAAAND WE'RE OFF!
	if (!empty($notify_data['members']))
		shd_notify_users($notify_data);
}

function shd_notifications_notify_assign(&$ticket, &$assignment)
{
	global $smcFunc, $context, $modSettings, $scripturl;

	if (!in_array('email_notifications', $context['shd_plugins']) || (empty($modSettings['shd_notify_assign_me']) && empty($modSettings['shd_notify_assign_own'])))
		return;

	$ticketinfo = shd_load_ticket($ticket);
	// ticket starter = $ticketinfo['starter_id']
	// $assignment = user id of assignee (0 for no longer being assigned)

	$notify_data = array(
		'members' => array(),
		'ticketlink' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $ticket . '.0',
		'subject' => $ticketinfo['subject'],
	);

	// Get the default preference (since this is controlled by plugin, i.e. here, we could just hardcode it, but in case someone modifies the default, let's load it from here)
	$pref_groups = array();
	$base_prefs = array();
	shd_notifications_prefs($pref_groups, $base_prefs);

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
			'variables' => array('assign_me', 'assign_own'),
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$row['id_member'] = (int) $row['id_member'];
		if ($row['variable'] == 'notify_' . $members[$row['id_member']])
			$member_prefs[$id] = $row['value'];
	}
	$smcFunc['db_free_result']($query);

	// unset $members where member pref doesn't fit
	foreach ($member_prefs as $id => $value)
	{
		if (empty($value))
			unset($members[$id]);
	}

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
 *	@since 1.1
*/
function shd_notify_users($notify_data)
{
	global $context, $txt, $modSettings, $language, $smcFunc, $sourcedir;

	if (empty($notify_data['members']))
		return;

	// So, for the folks we're sending a message to, figure out what languages etc we're loading
	$notify_lang = array();
	$emails = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_member, lngfile, email_address
		FROM {db_prefix}members
		WHERE id_member IN ({array_int:members})',
		array(
			'members' => array_keys($notify_data['members']),
		)
	);

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
		'{subject}' => $notify_data['subject'],
		'{ticketlink}' => $notify_data['ticketlink'],
	);

	// Also note, we may not be coming from the post code... so make sure sendmail() is available
	if (!function_exists('sendmail'))
		require($sourcedir . '/Subs-Post.php');

	foreach ($notify_lang as $this_lang => $lang_members)
	{
		shd_load_language('SDPluginEmailNotifications', $this_lang);

		foreach ($lang_members as $member)
		{
			$email_type = $notify_data['members'][$member];

			$subject = str_replace(array_keys($replacements), array_values($replacements), $txt['template_subject_notify_' . $email_type]);

			$body = $txt['template_body_notify_' . $email_type] . "\n\n" . $txt['regards_team'];			
			$body = str_replace(array_keys($replacements), array_values($replacements), $body);

			//function sendmail($to, $subject, $message, $from = null, $message_id = null, $send_html = false, $priority = 3, $hotmail_fix = null, $is_private = false)
			sendmail($emails[$member], $subject, $body, null, 'shd_notify_' . $email_type . '_' . $member);
		}
	}
}

/**
 *	Displays notifications options within SD ACP / Options / Notifications
 *
 *	<ul>
 *	<li>'shd_notify_new_ticket' (checkbox) - if checked, staff have the option of being notified when a new ticket is posted</li>
 *	<li>'shd_notify_new_reply_own' (checkbox) - if checked, users have the option to have notifications upon reply to any ticket they started</li>
 *	<li>'shd_notify_new_reply_assigned' (checkbox) - if checked, staff have the option to select notifications upon reply to any ticket assigned to them</li>
 *	<li>'shd_notify_new_reply_previous' (checkbox) - if checked, staff have the option to select notifications upon reply to any ticket they already replied to</li>
 *	<li>'shd_notify_new_reply_any' (checkbox) - if checked, staff have the option to select notifications upon any reply to any ticket they can see</li>
 *	<li>'shd_notify_assign_me' (checkbox) - if checked, staff have the option to have notifications sent to them when tickets are assigned to them</li>
 *	<li>'shd_notify_assign_own' (checkbox) - if checked, users have the option to be notified when one of their tickets is assigned to a staff member</li>
 *	</ul>
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
*/
function shd_modify_notifications_options($return_config)
{
	global $context, $modSettings, $txt;

	$config_vars = array(
		array('check', 'shd_notify_new_ticket'),
		array('check', 'shd_notify_new_reply_own'),
		array('check', 'shd_notify_new_reply_assigned'),
		array('check', 'shd_notify_new_reply_previous'),
		array('check', 'shd_notify_new_reply_any'),
		array('check', 'shd_notify_assign_me'),
		array('check', 'shd_notify_assign_own'),
	);
	$context['settings_title'] = $txt['shd_admin_options_notifications'];
	$context['settings_icon'] = 'email.png';

	// If we're being called from admin search, just return stuff
	if ($return_config)
		return $config_vars;

	// Otherwise... this is where things get... interesting.
	$subtext = array(
		'shd_notify_new_ticket' => '',
		'shd_notify_new_reply_own' => $txt['shd_notify_send_to'] . ': ' . $txt['shd_notify_ticket_starter'],
		'shd_notify_new_reply_assigned' => '',
		'shd_notify_new_reply_previous' => '',
		'shd_notify_new_reply_any' => '',
		'shd_notify_assign_me' => '',
		'shd_notify_assign_own' => $txt['shd_notify_send_to'] . ': ' . $txt['shd_notify_ticket_starter'],
	);

	$staff = shd_members_allowed_to('shd_staff');

	foreach ($config_vars as $id => $item)
	{
		list(, $item_id) = $item;
		if (!empty($subtext[$item_id]))
			$config_vars[$id]['subtext'] = $subtext[$item_id];
	}

	return $config_vars;
}

function shd_notifications_adminmenu(&$admin_areas)
{
	global $context, $modSettings, $txt;

	// Enabled?
	if (!in_array('email_notifications', $context['shd_plugins']))
		return;

	$admin_areas['helpdesk_info']['areas']['helpdesk_options']['subsections']['notifications'] = array($txt['shd_admin_options_notifications']);
}

function shd_notifications_hdadminopts()
{
	global $context, $modSettings, $txt;

	// Enabled?
	if (!in_array('email_notifications', $context['shd_plugins']))
		return;

	$context[$context['admin_menu_name']]['tab_data']['tabs']['notifications'] = array(
		'description' => $txt['shd_admin_options_notifications_desc'],
		'function' => 'shd_modify_notifications_options',
	);
}

function shd_notifications_hdadminoptssrch(&$settings_search)
{
	global $context, $modSettings;

	// Enabled?
	if (!in_array('email_notifications', $context['shd_plugins']))
		return;

	$settings_search[] = array('shd_modify_notifications_options', 'area=helpdesk_options;sa=notifications');
}

function shd_notifications_prefs(&$pref_groups, &$base_prefs)
{
	global $context, $modSettings;

	// Enabled?
	if (!in_array('email_notifications', $context['shd_plugins']))
		return;

	$pref_groups += array(
		'notify' => array(
			'icon' => 'email.png',
			'enabled' => true,
		),
	);

	$base_prefs += array(
		'notify_new_ticket' => array(
			'default' => 1,
			'type' => 'check',
			'icon' => 'log_newticket.png',
			'group' => 'notify',
			'permission' => 'shd_staff',
			'show' => !empty($modSettings['shd_notify_new_ticket']),
		),
		'notify_new_reply_own' => array(
			'default' => 1,
			'type' => 'check',
			'icon' => 'log_newreply.png',
			'group' => 'notify',
			'permission' => 'shd_new_ticket',
			'show' => !empty($modSettings['shd_notify_new_reply_own']),
		),
		'notify_new_reply_assigned' => array(
			'default' => 1,
			'type' => 'check',
			'icon' => 'log_assign.png',
			'group' => 'notify',
			'permission' => 'shd_staff',
			'show' => !empty($modSettings['shd_notify_new_reply_assigned']),
		),
		'notify_new_reply_previous' => array(
			'default' => 1,
			'type' => 'check',
			'icon' => 'log_newreply.png',
			'group' => 'notify',
			'permission' => 'shd_staff',
			'show' => !empty($modSettings['shd_notify_new_reply_previous']),
		),
		'notify_new_reply_any' => array(
			'default' => 1,
			'type' => 'check',
			'icon' => 'log_newreply.png',
			'group' => 'notify',
			'permission' => 'shd_staff',
			'show' => !empty($modSettings['shd_notify_new_reply_any']),
		),
		'notify_assign_me' => array(
			'default' => 1,
			'type' => 'check',
			'icon' => 'assign.png',
			'group' => 'notify',
			'permission' => 'shd_staff',
			'show' => !empty($modSettings['shd_notify_assign_me']),
		),
		'notify_assign_own' => array(
			'default' => 1,
			'type' => 'check',
			'icon' => 'assign.png',
			'group' => 'notify',
			'permission' => 'shd_new_ticket',
			'show' => !empty($modSettings['shd_notify_assign_own']),
		),
	);
}

?>