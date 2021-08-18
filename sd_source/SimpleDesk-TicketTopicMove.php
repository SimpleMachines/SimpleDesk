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
* File Info: SimpleDesk-TicketTopicMove.php                   *
**************************************************************/

/**
 *	This file handles displaying the user options for, and subsequently enacting, tickets being moved
 *	to/from the helpdesk, from/to forum threads.
 *
 *	@package source
 *	@since 1.0
*/
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Load the form up for asking users what board they want to go to.
 *
 *	Validates the user permission and session, then displays a list of boards the user can create new topics in.
 *
 *	Accessed through action=helpdesk;sa=tickettotopic;ticket=x;sessvar=sessid
 *
 *	@see shd_tickettotopic2()
 *	@since 1.0
*/
function shd_tickettotopic()
{
	global $smcFunc, $context, $user_info, $sourcedir, $txt, $modSettings, $scripturl;

	checkSession('get');

	if (empty($context['ticket_id']))
		shd_fatal_lang_error('shd_no_ticket');

	// Get ticket details - and kick it out if they shouldn't be able to see it.
	$query = shd_db_query('', '
		SELECT subject, deleted_replies, hdt.id_dept, hdd.dept_name
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_depts AS hdd ON (hdt.id_dept = hdd.id_dept)
		WHERE {query_see_ticket} AND id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);
	$row = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	if (empty($row))	
		shd_fatal_lang_error('shd_no_ticket');

	list($subject, $deleted_replies, $dept, $dept_name) = $row;

	if (!shd_allowed_to('shd_ticket_to_topic', $dept) || !empty($modSettings['shd_helpdesk_only']) || !empty($modSettings['shd_disable_tickettotopic']))
		shd_fatal_lang_error('shd_cannot_move_ticket', false);

	// Hang on... are there any deleted replies?
	if ($deleted_replies > 0)
	{
		if (shd_allowed_to('shd_access_recyclebin', $dept))
			$context['deleted_prompt'] = true;
		else
			shd_fatal_lang_error('shd_cannot_move_ticket_with_deleted');
	}

	// In a department, for the linktree?
	if ($context['shd_multi_dept'])
		$context['linktree'][] = array(
			'url' => $scripturl . '?' . $context['shd_home'] . ';dept=' . $dept,
			'name' => $dept_name,
		);

	// Build the linktree
	$context['linktree'][] = array(
		'url' => $scripturl . '?' . $context['shd_home'] . ($context['shd_multi_dept'] ? ';dept=' . $dept : ''),
		'name' => $txt['shd_linktree_move_ticket'],
	);
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
		'name' => $subject,
	);

	// They should only be able to move it to boards they are allowed to post in.
	$allowedboards = boardsAllowedTo('post_new');
	if ($allowedboards[0] == 0)
		$allowedboards = ''; // They can access everything.

	// All good, now figure out what board(s) they can move it to. (MoveTopic.php style 0-:D)
	$request = shd_db_query('order_by_board_order', '
		SELECT b.id_board, b.name, b.child_level, c.name AS cat_name, c.id_cat
		FROM {db_prefix}boards AS b
			LEFT JOIN {db_prefix}categories AS c ON (c.id_cat = b.id_cat)
		WHERE {query_see_board}
			AND b.redirect = {string:blank_redirect}
			' . (!empty($allowedboards) ? 'AND id_board IN({array_int:allowed_boards})' : ''),
		array(
			'blank_redirect' => '',
			'allowed_boards' => $allowedboards,
		)
	);
	$context['boards'] = array();

	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		if (!isset($context['categories'][$row['id_cat']]))
			$context['categories'][$row['id_cat']] = array(
				'name' => strip_tags($row['cat_name']),
				'boards' => array(),
			);

		$context['categories'][$row['id_cat']]['boards'][] = array(
			'id' => $row['id_board'],
			'name' => strip_tags($row['name']),
			'category' => strip_tags($row['cat_name']),
			'child_level' => $row['child_level'],
		);
	}
	$smcFunc['db_free_result']($request);

	if (empty($context['categories']))
		shd_fatal_lang_error('shd_moveticket_noboards', false);

	// OK, now we got to check for custom fields. In any case, we need to fetch the list of fields that might be applicable to this ticket.
	shd_load_language('sd_language/SimpleDeskAdmin');
	$context['field_types'] = array(
		CFIELD_TYPE_TEXT => array($txt['shd_admin_custom_fields_ui_text'], 'text'),
		CFIELD_TYPE_LARGETEXT => array($txt['shd_admin_custom_fields_ui_largetext'], 'largetext'),
		CFIELD_TYPE_INT => array($txt['shd_admin_custom_fields_ui_int'], 'int'),
		CFIELD_TYPE_FLOAT => array($txt['shd_admin_custom_fields_ui_float'], 'float'),
		CFIELD_TYPE_SELECT => array($txt['shd_admin_custom_fields_ui_select'], 'select'),
		CFIELD_TYPE_CHECKBOX => array($txt['shd_admin_custom_fields_ui_checkbox'], 'checkbox'),
		CFIELD_TYPE_RADIO => array($txt['shd_admin_custom_fields_ui_radio'], 'radio'),
		CFIELD_TYPE_MULTI => array($txt['shd_admin_custom_fields_ui_multi'], 'multi'),
	);

	$query = $smcFunc['db_query']('', '
		SELECT hdcf.id_field, hdcf.field_name, hdcf.field_order, hdcf.field_type, hdcf.can_see
		FROM {db_prefix}helpdesk_custom_fields_depts AS hdd
			INNER JOIN {db_prefix}helpdesk_custom_fields AS hdcf ON (hdd.id_field = hdcf.id_field)
		WHERE hdd.id_dept = {int:dept}
			AND hdcf.active = {int:active}
		ORDER BY hdcf.field_order',
		array(
			'dept' => $dept,
			'active' => 1,
		)
	);
	$context['custom_fields'] = array();
	$is_staff = shd_allowed_to('shd_staff', $dept);
	$is_admin = shd_allowed_to('admin_helpdesk', $dept);
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		list($user_see, $staff_see) = explode(',', $row['can_see']);
		$context['custom_fields'][$row['id_field']] = array(
			'id_field' => $row['id_field'],
			'name' => $row['field_name'],
			'type' => $row['field_type'],
			'visible' => array(
				'user' => $user_see,
				'staff' => $staff_see,
				'admin' => true,
			),
			'values' => array(),
		);
	}
	$smcFunc['db_free_result']($query);

	// Having got all the possible fields for this ticket, let's fetch the values for it. That way if we don't have any values for a field, we don't have to care about showing the user.
	// But first, we need all the message ids.
	$context['ticket_messages'] = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_msg
		FROM {db_prefix}helpdesk_ticket_replies AS hdtr
		WHERE id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);
	while ($row = $smcFunc['db_fetch_row']($query))
		$context['ticket_messages'][] = $row[0];
	$smcFunc['db_free_result']($query);

	// Now get a reference for the field values.
	$query = shd_db_query('', '
		SELECT cfv.id_post, cfv.id_field, cfv.post_type
		FROM {db_prefix}helpdesk_custom_fields_values AS cfv
		WHERE (cfv.id_post = {int:ticket} AND cfv.post_type = 1)' . (!empty($context['ticket_messages']) ? '
			OR (cfv.id_post IN ({array_int:msgs}) AND cfv.post_type = 2)' : ''),
		array(
			'ticket' => $context['ticket_id'],
			'msgs' => $context['ticket_messages'],
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		if (isset($context['custom_fields'][$row['id_field']]))
			$context['custom_fields'][$row['id_field']]['values'][$row['post_type']][$row['id_post']] = true;
	$smcFunc['db_free_result']($query);

	// Having now established what fields we do actually have values for, let's proceed to deal with them.
	foreach ($context['custom_fields'] as $field_id => $field)
	{
		// Didn't we have any values? If not, prune it, not interested.
		if (empty($field['values']))
		{
			unset($context['custom_fields'][$field_id]);
			continue;
		}

		// If the user is an administrator, they can always see the fields.
		if ($is_admin)
		{
			// But users might not be able to, in which case warn the user.
			if (!$field['visible']['user'] || !$field['visible']['staff'])
			{
				$context['custom_fields'][$field_id]['visible_warn'] = true;
				$context['custom_fields_warning'] = true;
			}
		}
		elseif ($is_staff)
		{
			// So they're staff. But the field might not be visible to them; they can't deal with it.
			if (!$field['visible']['staff'])
				shd_fatal_lang_error('cannot_shd_move_ticket_topic_hidden_cfs', false);
			elseif (!$field['visible']['user'])
			{
				// Normal mortals can't see it even if this person can, so warn them.
				$context['custom_fields'][$field_id]['visible_warn'] = true;
				$context['custom_fields_warning'] = true;
			}
		}
		else
			// Non staff aren't special. They should not be able to make this decision. If someone can't see it, they don't get to make the choice.
			if (!$field['visible']['user'] || !$field['visible']['staff'])
				shd_fatal_lang_error('cannot_shd_move_ticket_topic_hidden_cfs', false);
	}

	// Store the ticket subject for the template
	$context['ticket_subject'] = $subject;

	loadTemplate('sd_template/SimpleDesk-TicketTopicMove');
	$context['sub_template'] = 'shd_tickettotopic';
	$context['page_title'] = $txt['shd_move_ticket_to_topic'];
	checkSubmitOnce('register');
}

/**
 *	Receives the form for moving tickets to topics, and actually handles the move.
 *
 *	After checking permissions, and so on, begin to actually move posts.
 *
 *	This is done by invoking SMF's createPost function to make the new thread and repost all the ticket's posts as new thread posts
 *	using defaults for some settings.
 *
 *	Operations:
 *	- check the user can see the board they are linking to
 *	- move the ticket's text as the opening post
 *	- update the ticket row if the post was modified before
 *	- get the rest of the replies
 *	- step through and post, updating for modified details
 *	- send the notification PM if we're doing that
 *	- update the attachments table
 *	- update the action log
 *	- remove the ticket from the DB
 *
 *	@see shd_tickettotopic()
 *	@since 1.0
*/
function shd_tickettotopic2()
{
	global $smcFunc, $context, $txt, $modSettings, $scripturl, $sourcedir;

	checkSession();
	checkSubmitOnce('check');

	if (empty($context['ticket_id']))
		shd_fatal_lang_error('shd_no_ticket');
	elseif (isset($_POST['send_pm']) && (!isset($_POST['pm_content']) || trim($_POST['pm_content']) == ''))
	{
		checkSubmitOnce('free');
		shd_fatal_lang_error('shd_move_no_pm', false);
	}

	// Just in case, are they cancelling?
	if (isset($_REQUEST['cancel']))
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);

	require_once($sourcedir . '/Subs-Post.php');

	// The destination board must be numeric.
	$_POST['toboard'] = (int) $_POST['toboard'];

	$msg_assoc = array();

	// This is complex, very complex. Hopefully 5 minutes will be enough...
	if (function_exists('set_time_limit'))
		set_time_limit(300);

	// Make sure they can see the board they are trying to move to (and get whether posts count in the target board).
	$request = shd_db_query('', '
		SELECT b.count_posts, b.name, hdt.subject, hdt.id_member_started, hdtr.body, hdt.id_first_msg, hdtr.smileys_enabled,
		hdtr.modified_time, hdtr.modified_name, hdtr.poster_time, hdtr.id_msg, hdt.deleted_replies, hdt.id_dept
		FROM {db_prefix}boards AS b
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdt.id_ticket = {int:ticket})
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdtr.id_msg = hdt.id_first_msg)
		WHERE {query_see_board}
			AND {query_see_ticket}
			AND b.id_board = {int:to_board}
			AND b.redirect = {string:blank_redirect}
		LIMIT 1',
		array(
			'ticket' => $context['ticket_id'],
			'to_board' => $_POST['toboard'],
			'blank_redirect' => '',
		)
	);
	if ($smcFunc['db_num_rows']($request) == 0)
		shd_fatal_lang_error('no_board');

	list ($pcounter, $board_name, $subject, $owner, $body, $firstmsg, $smileys_enabled, $modified_time, $modified_name, $time, $shd_id_msg, $deleted_replies, $dept) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	if (!shd_allowed_to('shd_ticket_to_topic', $dept) || !empty($modSettings['shd_helpdesk_only']) || !empty($modSettings['shd_disable_tickettotopic']))
		shd_fatal_lang_error('shd_cannot_move_ticket', false);

	// Are we changing the subject?
	$old_subject = $subject;
	$subject = !empty($_POST['change_subject']) && !empty($_POST['subject']) ? $_POST['subject'] : $subject;

	$context['deleted_prompt'] = false;
	// Hang on... are there any deleted replies?
	if ($deleted_replies > 0)
	{
		if (shd_allowed_to('shd_access_recyclebin'))
		{
			$dr_opts = array('abort', 'delete', 'undelete');

			$context['deleted_prompt'] = isset($_REQUEST['deleted_replies']) && in_array($_REQUEST['deleted_replies'], $dr_opts) ? $_REQUEST['deleted_replies'] : 'abort';
		}
		else
			shd_fatal_lang_error('shd_cannot_move_ticket_with_deleted');
	}

	if (!empty($context['deleted_prompt']) && $context['deleted_prompt'] == 'abort')
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . ';recycle');

	// Now the madness that is custom fields. First, load the custom fields we might/will be using.
	$query = $smcFunc['db_query']('', '
		SELECT hdcf.id_field, hdcf.field_name, hdcf.field_order, hdcf.field_type, hdcf.can_see, hdcf.field_options, hdcf.bbc, hdcf.placement
		FROM {db_prefix}helpdesk_custom_fields_depts AS hdd
			INNER JOIN {db_prefix}helpdesk_custom_fields AS hdcf ON (hdd.id_field = hdcf.id_field)
		WHERE hdd.id_dept = {int:dept}
			AND hdcf.active = {int:active}
		ORDER BY hdcf.field_order',
		array(
			'dept' => $dept,
			'active' => 1,
		)
	);
	$context['custom_fields'] = array();
	$is_staff = shd_allowed_to('shd_staff', $dept);
	$is_admin = shd_allowed_to('admin_helpdesk', $dept);
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		list($user_see, $staff_see) = explode(',', $row['can_see']);
		$context['custom_fields'][$row['id_field']] = array(
			'id_field' => $row['id_field'],
			'name' => $row['field_name'],
			'type' => $row['field_type'],
			'bbc' => !empty($row['bbc']),
			'options' => !empty($row['field_options']) ? smf_json_decode($row['field_options'], true) : array(),
			'placement' => $row['placement'],
			'visible' => array(
				'user' => $user_see,
				'staff' => $staff_see,
				'admin' => true,
			),
			'values' => array(),
		);
	}
	$smcFunc['db_free_result']($query);

	// Having got all the possible fields for this ticket, let's fetch the values for it. That way if we don't have any values for a field, we don't have to care about showing the user.
	// But first, we need all the message ids.
	$context['ticket_messages'] = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_msg
		FROM {db_prefix}helpdesk_ticket_replies AS hdtr
		WHERE id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);
	while ($row = $smcFunc['db_fetch_row']($query))
		$context['ticket_messages'][] = $row[0];
	$smcFunc['db_free_result']($query);

	// Now get a reference for the field values.
	$query = $smcFunc['db_query']('', '
		SELECT cfv.id_post, cfv.id_field, cfv.post_type, cfv.value
		FROM {db_prefix}helpdesk_custom_fields_values AS cfv
		WHERE (cfv.id_post = {int:ticket} AND cfv.post_type = 1)' . (!empty($context['ticket_messages']) ? '
			OR (cfv.id_post IN ({array_int:msgs}) AND cfv.post_type = 2)' : ''),
		array(
			'ticket' => $context['ticket_id'],
			'msgs' => $context['ticket_messages'],
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		if (isset($context['custom_fields'][$row['id_field']]))
			$context['custom_fields'][$row['id_field']]['values'][$row['post_type']][$row['id_post']] = $row['value'];
	$smcFunc['db_free_result']($query);

	// Having now established what fields we do actually have values for, let's proceed to deal with them.
	foreach ($context['custom_fields'] as $field_id => $field)
	{
		// Didn't we have any values? If not, prune it, not interested.
		if (empty($field['values']))
			unset($context['custom_fields'][$field_id]);

		// If the user is an administrator, they can always see the fields.
		if ($is_admin)
		{
			// But users might not be able to, in which case we need to validate that actually, they did need to authorise this one.
			if (!$field['visible']['user'] || !$field['visible']['staff'])
				$context['custom_fields_warning'] = true;
		}
		elseif ($is_staff)
		{
			// So they're staff. But the field might not be visible to them; they can't deal with it whatever.
			if (!$field['visible']['staff'])
				shd_fatal_lang_error('cannot_shd_move_ticket_topic_hidden_cfs', false);
			elseif (!$field['visible']['user'])
				$context['custom_fields_warning'] = true;
		}
		else
			// Non staff aren't special. They should not be able to make this decision. If someone can't see it, they don't get to make the choice.
			if (!$field['visible']['user'] || !$field['visible']['staff'])
				shd_fatal_lang_error('cannot_shd_move_ticket_topic_hidden_cfs', false);

		// Are we ignoring this field? If so, we can now safely get rid of it at this very point.
		if (isset($_POST['field' . $field_id]) && $_POST['field' . $field_id] == 'lose')
			unset($context['custom_fields'][$field_id]);
	}

	// Were there any special fields? We need to check - and check that they ticked the right box!
	if (!empty($context['custom_fields_warning']) && empty($_POST['accept_move']))
	{
		checkSubmitOnce('free');
		shd_fatal_lang_error('shd_ticket_move_reqd_nonselected', false);
	}

	// Just before we do this, make sure we call any hooks. $context has lots of interesting things, as does $_POST.
	call_integration_hook('shd_hook_tickettotopic');

	// OK, so we have some fields, and we're doing something with them. First we need to attach the fields from the ticket to the opening post.
	shd_append_custom_fields($body, $context['ticket_id'], CFIELD_TICKET);

	// All okay, it seems. Let's go create the topic.
	$msgOptions = array(
		'subject' => $subject,
		'body' => $body,
		'icon' => 'xx',
		'smileys_enabled' => !empty($smileys_enabled) ? 1 : 0,
	);
	$topicOptions = array(
		'board' => $_POST['toboard'],
		'lock_mode' => 0,
		'mark_as_read' => false,
	);
	$posterOptions = array(
		'id' => $owner,
		'update_post_count' => empty($pcounter),
	);
	createPost($msgOptions, $topicOptions, $posterOptions);

	// Keep track of SHD msg id to SMF msg id
	$msg_assoc[$shd_id_msg] = $msgOptions['id'];

	// createPost() doesn't handle modified time and name, so we'll fix that here, along with the poster time.
	if (!empty($modified_time))
		shd_db_query('', '
			UPDATE {db_prefix}messages
			SET
				modified_time = {int:modified_time},
				modified_name = {string:modified_name},
				poster_time = {int:poster_time}
			WHERE id_msg = {int:id_msg}',
			array(
				'id_msg' => $firstmsg,
				'modified_time' => $modified_time,
				'modified_name' => $modified_name,
				'poster_time' => $time,
			)
		);

	// Topic created, let's dig out the replies and post them in the topic, if there are any.
	if (isset($topicOptions['id']))
	{
		$request = shd_db_query('', '
			SELECT body, id_member, poster_time, poster_name, poster_email, poster_ip, smileys_enabled,
				modified_time, modified_member, modified_name, poster_time, id_msg, message_status
			FROM {db_prefix}helpdesk_ticket_replies AS hdtr
			WHERE id_ticket = {int:ticket}
				AND id_msg > {int:ticket_msg}
			ORDER BY id_msg',
			array(
				'ticket' => $context['ticket_id'],
				'ticket_msg' => $firstmsg,
			)
		);

		// The ID of the topic we created
		$topic = $topicOptions['id'];

		if ($smcFunc['db_num_rows']($request) != 0)
		{
			// Now loop through each reply and post it.  Hopefully there aren't too many. *looks at clock*
			while ($row = $smcFunc['db_fetch_assoc']($request))
			{
				if ($row['message_status'] == MSG_STATUS_DELETED && !empty($context['deleted_prompt']) && $context['deleted_prompt'] == 'delete') // we don't want these replies!
					continue;

				shd_append_custom_fields($row['body'], $row['id_msg'], CFIELD_REPLY);

				$msgOptions = array(
					'subject' => $txt['response_prefix'] . $subject,
					'body' => $row['body'],
					'icon' => 'xx',
					'smileys_enabled' => !empty($row['smileys_enabled']) ? 1 : 0,
				);
				$topicOptions = array(
					'id' => $topic,
					'board' => $_POST['toboard'],
					'lock_mode' => 0,
					'mark_as_read' => false,
				);
				$posterOptions = array(
					'id' => $row['id_member'],
					'name' => !empty($row['poster_name']) ? $row['poster_name'] : '',
					'email' => !empty($row['poster_email']) ? $row['poster_email'] : '',
					'ip' => !empty($row['poster_ip']) ? $row['poster_ip'] : '',
					'update_post_count' => empty($pcounter),
				);
				createPost($msgOptions, $topicOptions, $posterOptions);

				// Don't forget to note what id
				$msg_assoc[$row['id_msg']] = $msgOptions['id'];

				// Meh, createPost() doesn't have any hooks for modified time and user. Let's fix that now.
				if (!empty($row['modified_time']))
					shd_db_query('', '
						UPDATE {db_prefix}messages
						SET
							modified_time = {int:modified_time},
							modified_name = {string:modified_name},
							poster_time = {int:poster_time}
						WHERE id_msg = {int:id_msg}',
						array(
							'id_msg' => $msgOptions['id'],
							'modified_time' => $row['modified_time'],
							'modified_name' => $row['modified_name'],
							'poster_time' => $row['poster_time'],
						)
					);
			}
		}

		// Topic: check; Replies: check; Notfiy the ticket starter, if desired.
		if (isset($_POST['send_pm']))
		{
			$request = shd_db_query('pm_find_username', '
				SELECT real_name
				FROM {db_prefix}members
				WHERE id_member = {int:user}
				LIMIT 1',
				array(
					'user' => $owner,
				)
			);
			list ($username) = $smcFunc['db_fetch_row']($request);
			$smcFunc['db_free_result']($request);

			// Fix the content
			$replacements = array(
				'{user}' => $username,
				'{subject}' => $old_subject,
				'{board}' => '[url=' . $scripturl . '?board=' . $_POST['toboard'] . '.0]' . $board_name . '[/url]',
				'{link}' => $scripturl . '?topic=' . $topic . '.0',
			);
			$message = str_replace(array_keys($replacements), array_values($replacements), $_POST['pm_content']);

			$recipients = array(
				'to' => array($owner),
				'bcc' => array()
			);

			sendpm($recipients, $txt['shd_ticket_moved_subject'], un_htmlspecialchars($message));
		}

		// Right, time to do all the attachment fussing too
		if (!empty($msg_assoc))
		{
			$attachIDs = array();
			$query = shd_db_query('', '
				SELECT id_attach, id_msg
				FROM {db_prefix}helpdesk_attachments
				WHERE id_msg IN ({array_int:msgs})',
				array(
					'msgs' => array_keys($msg_assoc),
				)
			);

			while ($row = $smcFunc['db_fetch_assoc']($query))
				$attachIDs[] = $row;

			$smcFunc['db_free_result']($query);

			if (!empty($attachIDs))
			{
				// 1. Update all the attachments in the master table; this is the bit that hurts since it can't be done without
				// a query per row :(
				foreach ($attachIDs as $attach)
					shd_db_query('', '
						UPDATE {db_prefix}attachments
						SET id_msg = {int:new_msg}
						WHERE id_attach = {int:attach}',
						array(
							'attach' => $attach['id_attach'],
							'new_msg' => $msg_assoc[$attach['id_msg']],
						)
					);

				// 2. Remove the entries from the SD table since we don't need them no more
				shd_db_query('', '
					DELETE FROM {db_prefix}helpdesk_attachments
					WHERE id_msg IN ({array_int:msgs})',
					array(
						'msgs' => array_keys($msg_assoc),
					)
				);
			}
		}

		// Well, it's possible there are some phantom attachments on deleted replies that need to disappear
		if (!empty($context['deleted_replies']) && $context['deleted_replies'] == 'delete')
		{
			$query = shd_db_query('', '
				SELECT id_msg
				FROM {db_prefix}helpdesk_attachments AS hda
					INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hda.id_msg = hdtr.id_msg)
				WHERE id_ticket = {int:ticket}
					AND hdtr.message_status = {int:deleted}',
				array(
					'ticket' => $context['ticket_id'],
					'deleted' => MSG_STATUS_DELETED,
				)
			);

			if ($smcFunc['db_num_rows']($query) > 0)
			{
				$msgs = array();
				while ($row = $smcFunc['db_fetch_row']($query))
					$msgs[] = $row[0];

				if (!empty($msgs))
				{
					// Get rid of the parents
					require_once($sourcedir . '/ManageAttachments.php');
					$attachmentQuery = array(
						'attachment_type' => 0,
						'id_msg' => 0,
						'id_attach' => $msgs,
					);
					removeAttachments($attachmentQuery);

					// Get rid of the remainder in hda table
					shd_db_query('', '
						DELETE FROM {db_prefix}helpdesk_attachments
						WHERE id_ticket = {int:ticket}',
						array(
							'ticket' => $context['ticket_id'],
						)
					);
				}
			}

			$smcFunc['db_free_result']($query);
		}

		// Now we'll add this to the log.
		shd_log_action('tickettotopic', array(
			'subject' => $subject,
			'board_id' => $_POST['toboard'],
			'board_name' => $board_name,
			'ticket' => $topic,
		));

		// Lastly, delete the ticket from the database.
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_tickets
			WHERE id_ticket = {int:ticket}
			LIMIT 1',
			array(
				'ticket' => $context['ticket_id'],
			)
		);
		// And the replies, too.
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_ticket = {int:ticket}',
			array(
				'ticket' => $context['ticket_id'],
			)
		);
		// And custom fields.
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_custom_fields_values
			WHERE (id_post = {int:ticket} AND post_type = 1)' . (!empty($context['ticket_messages']) ? '
				OR (id_post IN ({array_int:msgs}) AND post_type = 2)' : ''),
			array(
				'ticket' => $context['ticket_id'],
				'msgs' => $context['ticket_messages'],
			)
		);
	}
	else
		return shd_fatal_lang_error('shd_move_topic_not_created', false);

	// Clear our cache
	shd_clear_active_tickets($dept);

	// Send them to the topic.
	redirectexit('topic=' . $topic . '.0');
}

/**
 *	Processes the custom fields for making them part of the body of the new post.
 *
 *	Expects $context['custom_fields'] to have been prepared already in {@link shd_tickettotopic2()}
 *
 *	@param string &$body The body of the message, to which the custom fields should be appended.
 *	@param int $id_msg The message id to consider, or in the case of the ticket's opening post, the ticket id.
 *	@param int $type Should contain either CFIELD_TICKET or CFIELD_REPLY to confirm whether we are looking at the ticket or the post.
 *	@see shd_tickettotopic2()
 *	@since 2.0
*/
function shd_append_custom_fields(&$body, $id_msg, $type)
{
	global $context, $txt;

	$content = array();
	foreach ($context['custom_fields'] as $field_id => $field)
	{
		if (empty($field['values'][$type][$id_msg]))
			continue;

		switch ($field['type'])
		{
			case CFIELD_TYPE_TEXT:
			case CFIELD_TYPE_LARGETEXT:
				// If the field was used for bbc, display bbc. Otherwise convert it to a nobbc entry.
				if ($field['bbc'])
					$item = $field['name'] . ': ' . $field['values'][$type][$id_msg];
				else
					$item = $field['name'] . ': [nobbc]' . strtr($field['values'][$type][$id_msg], array('[' => '&#91;', ']' => '&#93;', ':' => '&#58;', '@' => '&#64;')) . '[/nobbc]';
				break;
			case CFIELD_TYPE_INT:
			case CFIELD_TYPE_FLOAT:
				$item = $field['name'] . ': ' . $field['values'][$type][$id_msg];
				break;
			case CFIELD_TYPE_CHECKBOX:
				$item = $field['name'] . ': ' . (!empty($field['values'][$type][$id_msg]) ? $txt['yes'] : $txt['no']);
				break;
			case CFIELD_TYPE_SELECT:
			case CFIELD_TYPE_RADIO:
				if (isset($field['options'][$field['values'][$type][$id_msg]]))
					$item = $field['name'] . ': ' . $field['options'][$field['values'][$type][$id_msg]];
				break;
			case CFIELD_TYPE_MULTI:
				$opts = array();
				$values = explode(',', $field['values'][$type][$id_msg]);
				foreach ($values as $value)
					if (isset($field['options'][$value]))
						$opts[] = $field['options'][$value];
				if (!empty($opts))
					$item = $field['name'] . ': ' . implode(', ', $opts);
				break;
		}

		if (!empty($item))
			$content[] = $item;
		unset($item);
	}

	if (!empty($content))
		$body .= '[hr]<br>' . implode('<br>', $content);
}

/**
 *	Load the form up for asking users whether to send a personal message (and what message) to the topic/ticket starter or not. Most of the rest of this function is about loading the data to make the page well-rounded (like the subject for breadcrumbs)
 *
 *	Validates the user permission and session, of course.
 *
 *	Accessed through action=helpdesk;sa=topictoticket;topic=x;sessvar=sessid
 *
 *	@see shd_topictoticket2()
 *	@since 1.0
*/
function shd_topictoticket()
{
	global $smcFunc, $context, $user_info, $sourcedir, $txt, $modSettings, $scripturl;

	checkSession('get');

	if (!shd_allowed_to('shd_topic_to_ticket', 0) || !empty($modSettings['shd_helpdesk_only']) || !empty($modSettings['shd_disable_tickettotopic']))
		shd_fatal_lang_error('shd_cannot_move_topic', false);
	elseif (empty($_REQUEST['topic']))
		shd_fatal_lang_error('shd_no_topic');

	$context['topic_id'] = (int) $_REQUEST['topic'];

	// Get topic details
	$query = shd_db_query('', '
		SELECT m.subject, m.id_member
		FROM {db_prefix}topics AS t
			INNER JOIN {db_prefix}messages AS m ON (m.id_topic = {int:topic})
			INNER JOIN {db_prefix}boards AS b ON (t.id_board = b.id_board)
		WHERE {query_see_board} AND t.id_topic = {int:topic}',
		array(
			'topic' => $context['topic_id'],
		)
	);

	$row = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	if (empty($row))	
		shd_fatal_lang_error('shd_no_topic');

	list($subject, $topic_starter) = $row;
	$smcFunc['db_free_result']($query);

	// Get the department list
	$depts = shd_allowed_to('access_helpdesk', false);
	$context['dept_list'] = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_dept, dept_name
		FROM {db_prefix}helpdesk_depts
		WHERE id_dept IN ({array_int:depts})
		ORDER BY dept_order',
		array(
			'depts' => $depts,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['dept_list'][$row['id_dept']] = $row['dept_name'];
	$smcFunc['db_free_result']($query);

	// We also want to be able to indicate whether the topic starter will be able to see the message after.
	// Firstly, figure out what groups they're in, so we can establish that kind of thing.
	$groups = $depts = array();
	if (!empty($topic_starter))
	{
		// Sadly, loadMemberData only fetches additional_groups in profile mode, which also triggers other queries. We're better just getting it ourselves.
		$query = $smcFunc['db_query']('', '
			SELECT id_group, additional_groups
			FROM {db_prefix}members
			WHERE id_member = {int:member}',
			array(
				'member' => $topic_starter,
			)
		);
		if ($row = $smcFunc['db_fetch_assoc']($query))
		{
			$groups[] = (int) $row['id_group'];
			$row['additional_groups'] = explode(',', $row['additional_groups']);
			foreach ($row['additional_groups'] as $group)
				if (!empty($group))
					$groups[] = (int) $group;
		}
		$smcFunc['db_free_result']($query);
	}

	if (!empty($groups))
	{
		// OK, so we have at least one member group. Now to find if there are any roles attached to the group(s) in question, and in the departments
		// that our user can see. If there are any matches, we know that those are departments our target user can see - every role implicitly inclues access_helpdesk.
		$query = $smcFunc['db_query']('', '
			SELECT hdd.id_dept, hdd.dept_name
			FROM {db_prefix}helpdesk_role_groups AS hdrg
				INNER JOIN {db_prefix}helpdesk_dept_roles AS hddr ON (hdrg.id_role = hddr.id_role)
				INNER JOIN {db_prefix}helpdesk_depts AS hdd ON (hddr.id_dept = hdd.id_dept)
			WHERE hdrg.id_group IN ({array_int:groups})
				AND hddr.id_dept IN ({array_int:depts})',
			array(
				'groups' => $groups,
				'depts' => array_keys($context['dept_list']),
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$depts[$row['id_dept']] = $row['dept_name'];
		$smcFunc['db_free_result']($query);
	}

	// OK, so if we don't have any departments, is the person a forum administrator? If they are, they might not have any roles, just adminly powers.
	if (empty($depts) && in_array(1, $groups))
		$depts = $context['dept_list'];
	// Oh, we might need to reorder the $depts list. It came out of the DB in any old order but we want it to adhere to the depts list ordering.
	elseif (!empty($depts) && !empty($context['dept_list']))
	{
		$old_depts = $depts;
		$depts = array();
		foreach ($context['dept_list'] as $dept => $dept_name)
			if (isset($old_depts[$dept]))
				$depts[$dept] = $dept_name;
		unset($old_depts);
	}

	// Figure out what message to send to users.
	if (empty($depts))
		$context['ttm_move_dept'] = '<span class="error">' . $txt['shd_user_no_hd_access'] . '</span>'; // They can't see it.
	elseif (count($context['dept_list']) == 1)
		$context['ttm_move_dept'] = $txt['shd_user_helpdesk_access']; // They can see in, as far as we know there's only one department, so even if it's not true, pretend it is.
	else
		$context['ttm_move_dept'] = (count($depts) == 1 ? $txt['shd_user_hd_access_dept_1'] : $txt['shd_user_hd_access_dept']) . implode(', ', $depts);

	// Build the linktree
	$context['linktree'][] = array(
		'url' => $scripturl . '?' . $context['shd_home'],
		'name' => $txt['shd_linktree_move_topic'],
	);
	$context['linktree'][] = array(
		'url' => $scripturl . '?topic=' . $context['topic_id'] . '.0',
		'name' => $subject,
	);

	// Store the subject for the template
	$context['topic_subject'] = $subject;

	loadTemplate('sd_template/SimpleDesk-TicketTopicMove');
	$context['sub_template'] = 'shd_topictoticket';
	$context['page_title'] = $txt['shd_move_topic_to_ticket'];
	checkSubmitOnce('register');
}

/**
 *	Handles moving a topic into the helpdesk.
 *
 *	After checking permissions, and so on, begin to actually move posts.
 *
 *	Broadly this is done using {@link shd_create_ticket_post()}, which has hooks specifically to deal with post modification times (written in specifically to ease this function's workload)
 *
 *	Operations:
 *	- get the topic information (and checking topic access permission in the process)
 *	- identify the status of the topic (new/with staff/with user)
 *	- create the new ticket from these details
 *	- assuming there are replies, query for them
 *	- step through and repost
 *	- send the notification PM if we're doing that
 *	- update the attachments table
 *	- update the action log
 *	- remove the topic from the forum
 *
 *	@see shd_topictoticket()
 *	@since 1.0
*/
function shd_topictoticket2()
{
	global $smcFunc, $context, $txt, $modSettings, $scripturl, $sourcedir;

	checkSession();
	checkSubmitOnce('check');

	$_REQUEST['dept'] = isset($_REQUEST['dept']) ? (int) $_REQUEST['dept'] : 0;
	if (empty($_REQUEST['dept']))
		$_REQUEST['dept'] = -1; // which is never a valid department!

	if (!shd_allowed_to('shd_topic_to_ticket', $_REQUEST['dept']) || !empty($modSettings['shd_helpdesk_only']) || !empty($modSettings['shd_disable_tickettotopic']))
		shd_fatal_lang_error('shd_cannot_move_topic', false);
	elseif (empty($_REQUEST['topic']))
		shd_fatal_lang_error('shd_no_topic');

	$context['topic_id'] = (int) $_REQUEST['topic'];

	// Just in case, are they cancelling?
	if (isset($_REQUEST['cancel']))
		return redirectexit('topic=' . $context['topic_id']);
	elseif (isset($_POST['send_pm']) && (!isset($_POST['pm_content']) || trim($_POST['pm_content']) == ''))
		shd_fatal_lang_error('shd_move_no_pm_topic', false);

	require_once($sourcedir . '/sd_source/Subs-SimpleDeskPost.php');

	// Fetch the topic information.
	$request = shd_db_query('', '
		SELECT m.subject, t.id_board, t.id_member_started, m.body, t.id_first_msg, m.smileys_enabled, t.id_member_updated, t.num_replies,
		m.poster_email, m.poster_name, m.poster_ip, m.poster_time, m.modified_time, m.modified_name, m.id_msg
		FROM {db_prefix}topics AS t
			INNER JOIN {db_prefix}messages AS m ON (m.id_msg = t.id_first_msg)
			INNER JOIN {db_prefix}boards AS b ON (t.id_board = b.id_board)
		WHERE {query_see_board} AND t.id_topic = {int:topic}
		LIMIT 1',
		array(
			'topic' => $context['topic_id'],
		)
	);
	if ($smcFunc['db_num_rows']($request) == 0)
		shd_fatal_lang_error('shd_move_ticket_not_created');

	list ($subject, $board, $owner, $body, $firstmsg, $smileys_enabled, $memberupdated, $numreplies, $postername, $posteremail, $posterip, $postertime, $modified_time, $modified_name, $smf_id_msg) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	// Figure out what the status of the ticket should be.
	$status = shd_determine_status('topictoticket', $owner, $memberupdated, $numreplies, $_REQUEST['dept']);

	// Are we changing the subject?
	$old_subject = $subject;
	$subject = !empty($_POST['change_subject']) && !empty($_POST['subject']) ? $_POST['subject'] : $subject;

	// Just before we do this, make sure we call any hooks. $context and $_POST have lots of interesting things for us.
	call_integration_hook('shd_hook_topictoticket');

	// All okay, it seems. Let's go create the ticket.
	$msg_assoc = array();

	$msgOptions = array(
		'body' => $body,
		'smileys_enabled' => !empty($smileys_enabled) ? 1 : 0,
		'modified' => array(
			'time' => $modified_time,
			'name' => $modified_name,
		),
		'time' => $postertime,
	);
	$ticketOptions = array(
		'dept' => $_REQUEST['dept'],
		'subject' => $subject,
		'mark_as_read' => false,
		'private' => false,
		'status' => $status,
		'urgency' => 0,
		'assigned' => 0,
	);
	$posterOptions = array(
		'id' => $owner,
		'name' => $postername,
		'email' => $posteremail,
		'ip' => $posterip,
	);
	shd_create_ticket_post($msgOptions, $ticketOptions, $posterOptions);
	$msg_assoc[$smf_id_msg] = $msgOptions['id'];

	// Ticket created, let's dig out the replies and post them in the ticket, if there are any.
	if (!isset($ticketOptions['id']))
		shd_fatal_lang_error('shd_move_ticket_not_created', false);

	$request = shd_db_query('', '
		SELECT body, id_member, poster_time, poster_name, poster_email, poster_ip, smileys_enabled, id_msg
		FROM {db_prefix}messages
		WHERE id_topic = {int:topic}
		AND id_msg != {int:topic_msg}',
		array(
			'topic' => $context['topic_id'],
			'topic_msg' => $firstmsg,
		)
	);

	$num_replies = $smcFunc['db_num_rows']($request) + 1; // Plus one since we want to count the main ticket post as well.

	// The ID of the ticket we created
	$ticket = $ticketOptions['id'];

	if ($smcFunc['db_num_rows']($request) != 0)
	{
		// Now loop through each reply and post it.  Hopefully there aren't too many. *looks at clock*
		while ($row = $smcFunc['db_fetch_assoc']($request))
		{
			$msgOptions = array(
				'body' => $row['body'],
				'smileys_enabled' => !empty($row['smileys_enabled']) ? 1 : 0,
			);
			$ticketOptions = array(
				'id' => $ticket,
				'mark_as_read' => false,
			);
			$posterOptions = array(
				'id' => $row['id_member'],
				'name' => !empty($row['poster_name']) ? $row['poster_name'] : '',
				'email' => !empty($row['poster_email']) ? $row['poster_email'] : '',
				'ip' => !empty($row['poster_ip']) ? $row['poster_ip'] : '',
			);
			shd_create_ticket_post($msgOptions, $ticketOptions, $posterOptions);
			$msg_assoc[$row['id_msg']] = $msgOptions['id'];
		}
	}

	// Ticket: check; Replies: check; Notfiy the topic starter, if desired.
	if (isset($_POST['send_pm']))
	{
		require_once($sourcedir . '/Subs-Post.php');

		$request = shd_db_query('pm_find_username', '
			SELECT real_name
			FROM {db_prefix}members
			WHERE id_member = {int:user}
			LIMIT 1',
			array(
				'user' => $owner,
			)
		);
		list ($username) = $smcFunc['db_fetch_row']($request);
		$smcFunc['db_free_result']($request);

		// Fix the content
		$replacements = array(
			'{user}' => $username,
			'{subject}' => $old_subject,
			'{link}' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $ticket,
		);
		$message = str_replace(array_keys($replacements), array_values($replacements), $_POST['pm_content']);

		$recipients = array(
			'to' => array($owner),
			'bcc' => array()
		);

		sendpm($recipients, $txt['shd_ticket_moved_subject_topic'], un_htmlspecialchars($message));
	}

	// And now for something completely different: attachments
	if (!empty($msg_assoc))
	{
		// 1. Get all the attachments for these messages from the attachments table
		$attachIDs = array();
		$query = shd_db_query('', '
			SELECT id_attach, id_msg
			FROM {db_prefix}attachments
			WHERE id_msg IN ({array_int:smf_msgs})',
			array(
				'smf_msgs' => array_keys($msg_assoc),
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$attachIDs[] = $row;
		$smcFunc['db_free_result']($query);

		if (!empty($attachIDs))
		{
			// 2. Do the switch
			// 2.1. Add them to SD's tables
			$array = array();
			foreach ($attachIDs as $attach)
				$array[] = array($attach['id_attach'], $ticket, $msg_assoc[$attach['id_msg']]);

			$smcFunc['db_insert']('replace',
				'{db_prefix}helpdesk_attachments',
				array('id_attach' => 'int', 'id_ticket' => 'int', 'id_msg' => 'int',),
				$array,
				array('id_attach',)
			);

			// 2.2. "Remove" them from SMF's table
			shd_db_query('', '
				UPDATE {db_prefix}attachments
				SET id_msg = 0
				WHERE id_msg IN ({array_int:smf_msgs})',
				array(
					'smf_msgs' => array_keys($msg_assoc),
				)
			);
		}
	}

	// Now we'll add this to the log.
	shd_log_action('topictoticket', array(
		'subject' => $subject,
		'ticket' => $ticket,
	));

	// Update post counts.
	$request = shd_db_query('', '
		SELECT id_member
		FROM {db_prefix}messages
		WHERE id_topic = {int:topic}',
		array(
			'topic' => $context['topic_id'],
		)
	);
	$posters = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		if (!isset($posters[$row['id_member']]))
			$posters[$row['id_member']] = 0;
		$posters[$row['id_member']]++;
	}
	$smcFunc['db_free_result']($request);

	foreach ($posters as $id_member => $posts)
		updateMemberData($id_member, array('posts' => 'posts - ' . $posts));

	// Lastly, delete the topic from the database.
	shd_db_query('', '
		DELETE FROM {db_prefix}topics
		WHERE id_topic = {int:topic}
		LIMIT 1',
		array(
			'topic' => $context['topic_id'],
		)
	);
	// And the replies, too.
	shd_db_query('', '
		DELETE FROM {db_prefix}messages
		WHERE id_topic = {int:topic}',
		array(
			'topic' => $context['topic_id'],
		)
	);

	// Update the stats.
	require_once($sourcedir . '/Subs-Post.php');
	updateStats('message');
	updateStats('topic');
	updateLastMessages($board);

	// Update board post counts.
	shd_db_query('', '
		UPDATE {db_prefix}boards
		SET num_topics = num_topics - 1,
			num_posts = num_posts - {int:num_posts}
		WHERE id_board = {int:board}',
		array(
			'board' => $board,
			'num_posts' => $num_replies,
		)
	);

	// Send them to the ticket.
	redirectexit('action=helpdesk;sa=ticket;ticket=' . $ticket);
}