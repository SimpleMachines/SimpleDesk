<?php
###############################################################
#         Simple Desk Project - www.simpledesk.net            #
###############################################################
#       An advanced help desk modifcation built on SMF        #
###############################################################
#                                                             #
#         * Copyright 2010 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 1.0 Felidae                             #
# File Info: SimpleDesk-TopicTicketMove.php / 1.0 Felidae     #
###############################################################

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

	if (!shd_allowed_to('shd_ticket_to_topic') || !empty($modSettings['shd_helpdesk_only']) || !empty($modSettings['shd_disable_tickettotopic']))
		fatal_lang_error('shd_cannot_move_ticket', false);

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket');

	// Get ticket details - and kick it out if they shouldn't be able to see it.
	$query = shd_db_query('', '
		SELECT id_member_started, id_member_assigned, private, subject, deleted_replies
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket} AND id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);

	if ($row = $smcFunc['db_fetch_row']($query))
	{
		list($ticket_starter, $ticket_owner, $private, $subject, $deleted_replies) = $row;
		$smcFunc['db_free_result']($query);
	}
	else
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_ticket');
	}

	// Hang on... are there any deleted replies?
	if ($deleted_replies > 0)
	{
		if (shd_allowed_to('shd_access_recyclebin'))
			$context['deleted_prompt'] = true;
		else
			fatal_lang_error('shd_cannot_move_ticket_with_deleted');
	}

	// Build the linktree
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=main',
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
			$context['categories'][$row['id_cat']] = array (
				'name' => strip_tags($row['cat_name']),
				'boards' => array(),
			);

		$context['categories'][$row['id_cat']]['boards'][] = array(
			'id' => $row['id_board'],
			'name' => strip_tags($row['name']),
			'category' => strip_tags($row['cat_name']),
			'child_level' => $row['child_level'],
			'selected' => !empty($_SESSION['move_to_topic']) && $_SESSION['move_to_topic'] == $row['id_board'] && $row['id_board'] != $board,
		);
	}

	$smcFunc['db_free_result']($request);

	if (empty($context['categories']))
		fatal_lang_error('shd_moveticket_noboards', false);

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

	if (!shd_allowed_to('shd_ticket_to_topic') || !empty($modSettings['shd_helpdesk_only']) || !empty($modSettings['shd_disable_tickettotopic']))
		fatal_lang_error('shd_cannot_move_ticket', false);

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket');

	if (isset($_POST['send_pm']) && (!isset($_POST['pm_content']) || trim($_POST['pm_content']) == ''))
		fatal_lang_error('shd_move_no_pm', false);

	// Just in case, are they cancelling?
	if (isset($_REQUEST['cancel']))
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);

	require_once($sourcedir . '/Subs-Post.php');

	// The destination board must be numeric.
	$_POST['toboard'] = (int) $_POST['toboard'];

	$msg_assoc = array();

	// This is complex, very complex. Hopefully 5 minutes will be enough...
	@set_time_limit(300);

	// Make sure they can see the board they are trying to move to (and get whether posts count in the target board).
	$request = shd_db_query('', '
		SELECT b.count_posts, b.name, hdt.subject, hdt.id_member_started, hdtr.body, hdt.id_first_msg, hdtr.smileys_enabled,
		hdtr.modified_time, hdtr.modified_name, hdtr.poster_time, hdtr.id_msg, hdt.deleted_replies
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
		fatal_lang_error('no_board');
	else
		list ($pcounter, $board_name, $subject, $owner, $body, $firstmsg, $smileys_enabled, $modified_time, $modified_name, $time, $shd_id_msg, $deleted_replies) = $smcFunc['db_fetch_row']($request);

	$smcFunc['db_free_result']($request);

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
			fatal_lang_error('shd_cannot_move_ticket_with_deleted');
	}

	if (!empty($context['deleted_prompt']) && $context['deleted_prompt'] == 'abort')
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . ';recycle');

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
	{
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
	}

	// Topic created, let's dig out the replies and post them in the topic, if there are any.
	if (isset($topicOptions['id']))
	{
		$request = shd_db_query('', '
			SELECT body, id_member, poster_time, poster_name, poster_email, poster_ip, smileys_enabled,
				modified_time, modified_member, modified_name, poster_time, id_msg, message_status
			FROM {db_prefix}helpdesk_ticket_replies AS hdtr
			WHERE id_ticket = {int:ticket}
				AND id_msg > {int:ticket_msg}',
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
				{
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
		}

		// Topic: check; Replies: check; Notfiy the ticket starter, if desired.
		if (isset($_POST['send_pm']))
		{
			$request = shd_db_query('pm_find_username', '
				SELECT id_member, real_name
				FROM {db_prefix}members
				WHERE id_member = {int:user}
				LIMIT 1',
				array(
					'user' => $owner,
				)
			);
			list ($userid,$username) = $smcFunc['db_fetch_row']($request);
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
				{
					shd_db_query('', '
						UPDATE {db_prefix}attachments
						SET id_msg = {int:new_msg}
						WHERE id_attach = {int:attach}',
						array(
							'attach' => $attach['id_attach'],
							'new_msg' => $msg_assoc[$attach['id_msg']],
						)
					);
				}

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
		$log_params = array(
			'subject' => $subject,
			'board_id' => $_POST['toboard'],
			'board_name' => $board_name,
			'ticket' => $topic,
		);
		shd_log_action('tickettotopic', $log_params);

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

	}
	else
		fatal_lang_error('shd_move_topic_not_created',false);

	// Clear our cache
	shd_clear_active_tickets($owner);

	// Send them to the topic.
	redirectexit('topic=' . $topic . '.0');

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

	if (!shd_allowed_to('shd_topic_to_ticket') || !empty($modSettings['shd_helpdesk_only']) || !empty($modSettings['shd_disable_tickettotopic']))
		fatal_lang_error('shd_cannot_move_topic', false);

	if (empty($_REQUEST['topic']))
		fatal_lang_error('shd_no_topic');

	$context['topic_id'] = (int) $_REQUEST['topic'];

	// Get topic details
	$query = shd_db_query('', '
		SELECT m.subject
		FROM {db_prefix}topics AS t
			INNER JOIN {db_prefix}messages AS m ON (m.id_topic = {int:topic})
			INNER JOIN {db_prefix}boards AS b ON (t.id_board = b.id_board)
		WHERE {query_see_board} AND t.id_topic = {int:topic}',
		array(
			'topic' => $context['topic_id'],
		)
	);

	if ($row = $smcFunc['db_fetch_row']($query))
	{
		list($subject) = $row;
		$smcFunc['db_free_result']($query);
	}
	else
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_topic');
	}

	// Build the linktree
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=main',
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

	if (!shd_allowed_to('shd_topic_to_ticket') || !empty($modSettings['shd_helpdesk_only']) || !empty($modSettings['shd_disable_tickettotopic']))
		fatal_lang_error('shd_cannot_move_topic', false);

	if (empty($_REQUEST['topic']))
		fatal_lang_error('shd_no_topic');

	$context['topic_id'] = (int) $_REQUEST['topic'];

	// Just in case, are they cancelling?
	if (isset($_REQUEST['cancel']))
		redirectexit('topic=' . $context['topic_id']);

	if (isset($_POST['send_pm']) && (!isset($_POST['pm_content']) || trim($_POST['pm_content']) == ''))
		fatal_lang_error('shd_move_no_pm_topic', false);

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
		fatal_lang_error('shd_move_ticket_not_created');
	else
		list ($subject, $board, $owner, $body, $firstmsg, $smileys_enabled, $memberupdated, $numreplies, $postername, $posteremail, $posterip, $postertime, $modified_time, $modified_name, $smf_id_msg) = $smcFunc['db_fetch_row']($request);

	$smcFunc['db_free_result']($request);

	// Figure out what the status of the ticket should be.
	$status = shd_determine_status('topictoticket', $owner, $memberupdated, $numreplies);

	// Are we changing the subject?
	$old_subject = $subject;
	$subject = !empty($_POST['change_subject']) && !empty($_POST['subject']) ? $_POST['subject'] : $subject;

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
	if (isset($ticketOptions['id']))
	{
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
				SELECT id_member, real_name
				FROM {db_prefix}members
				WHERE id_member = {int:user}
				LIMIT 1',
				array(
					'user' => $owner,
				)
			);
			list ($userid,$username) = $smcFunc['db_fetch_row']($request);
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
					array(
						'id_attach' => 'int', 'id_ticket' => 'int', 'id_msg' => 'int',
					),
					$array,
					array(
						'id_attach',
					)
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
		$log_params = array(
			'subject' => $subject,
			'ticket' => $ticket,
		);
		shd_log_action('topictoticket', $log_params);

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
		{
			updateMemberData($id_member, array('posts' => 'posts - ' . $posts));
		}

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
	}
	else
		fatal_lang_error('shd_move_ticket_not_created',false);

	// Clear our cache
	shd_clear_active_tickets($owner);

	// Send them to the ticket.
	redirectexit('action=helpdesk;sa=ticket;ticket=' . $ticket);
}

?>