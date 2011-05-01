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
# File Info: SimpleDesk-MergeSplit.php / 1.0 Felidae          #
###############################################################

/**
 *	This file handles merging and splitting of tickets, both handling the interface and actual processing thereof.
 *
 *	@package source
 *	@since 1.1
*/

if (!defined('SMF'))
	die('Hacking attempt...');

function shd_merge_ticket()
{
	global $smcFunc, $context, $user_info, $sourcedir, $txt, $scripturl;

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket');

	$query = shd_db_query('', '
		SELECT subject, id_member_started, id_dept
		FROM {db_prefix}helpdesk_tickets
		WHERE {query_see_ticket}
			AND id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);

	if ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$smcFunc['db_free_result']($query);
		$context['current_ticket'] = $row;

		// Now we have something to play with, let's see if we have the permissions to do it.
		if (!shd_allowed_to('shd_merge_ticket_any', $row['id_dept']) && (!shd_allowed_to('shd_merge_ticket_own', $row['id_dept']) || ($row['id_member_started'] != $context['user']['id'])))
			fatal_lang_error('shd_cannot_merge', false);
	}
	else
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_ticket');
	}

	// OK, so we can merge this ticket with something else. Let's get the other tickets that we can possibly merge this with.
	$query = shd_db_query('', '
		SELECT id_ticket, subject
		FROM {db_prefix}helpdesk_tickets
		WHERE {query_see_ticket}
			AND id_ticket != {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);

	// Are there any tickets? If not, die.
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_tickets_to_merge', false);
	}
	else
	{
		// She might have, but I KNOW I got a ticket to merge... but she don't care :P
		$context['tickets_to_merge'] = array();
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$context['tickets_to_merge'][] = $row;
	}

	// OK, we've done all the easy bits, now just the boring bits like setting up the template.
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
		'name' => $context['current_ticket']['subject'],
	);
	$context['linktree'][] = array(
		'name' => $txt['shd_ticket_merge_tickets'],
	);

	$context['page_title'] = $txt['shd_ticket_merge_tickets'];

	loadTemplate('sd_template/SimpleDesk-MergeSplit');
	$context['sub_template'] = 'shd_merge_ticket';

	checkSubmitOnce('register');
}

function shd_merge_ticket2()
{

}

function shd_split_ticket()
{
	global $smcFunc, $context, $user_info, $sourcedir, $txt, $scripturl;

	// Load the ticket from $context['ticket_id'] and die if not found
	$ticketinfo = shd_load_ticket();

	$_REQUEST['at_msg'] = isset($_REQUEST['at_msg']) ? (int) $_REQUEST['at_msg'] : 0;

	// So, are you in or out? For us to be able to split, we know we can see the ticket, but the split point must be not the first msg and not deleted
	$query = shd_db_query('', '
		SELECT id_msg
		FROM {db_prefix}helpdesk_ticket_replies
		WHERE id_ticket = {int:ticket}
			AND id_msg = {int:msg}
			AND id_msg > {int:firstmsg}
			AND message_status = {int:message_status}',
		array(
			'ticket' => $context['ticket_id'],
			'msg' => $_REQUEST['at_msg'],
			'firstmsg' => $ticketinfo['id_first_msg'],
			'message_status' => MSG_STATUS_NORMAL,
		)
	);

	$found = $smcFunc['db_num_rows']($query) > 0;
	$smcFunc['db_free_result']($query);
	if (!$found)
		fatal_lang_error('shd_no_reply', false);

	// Permission checking time
	if ($ticketinfo['id_member_started'] == $user_info['id'])
		shd_is_allowed_to('shd_split_ticket_own', $ticketinfo['dept']);
	else
		shd_is_allowed_to('shd_split_ticket_any', $ticketinfo['dept']);

	if (in_array($ticketinfo['status'], array(TICKET_STATUS_CLOSED, TICKET_STATUS_DELETED)))
		fatal_lang_error('shd_ticket_unavailable', false);

	// So, we know we can split at this point. Let's prep the items we need for the form: ticket id (check), msg id (check), current ticket title...
	$context['ticket_title'] = $ticketinfo['subject'];

	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
		'name' => $ticketinfo['subject'],
	);
	$context['linktree'][] = array(
		'name' => $txt['shd_ticket_split_ticket'],
	);

	$context['page_title'] = $txt['shd_split_ticket'];

	loadTemplate('sd_template/SimpleDesk-MergeSplit');
	$context['sub_template'] = 'shd_split_ticket';
}

function shd_split_ticket2()
{
	global $smcFunc, $context, $user_info, $sourcedir, $txt, $scripturl;

	checkSession();

	// Load the ticket from $context['ticket_id'] and die if not found
	$ticketinfo = shd_load_ticket();

	$_REQUEST['at_msg'] = isset($_REQUEST['at_msg']) ? (int) $_REQUEST['at_msg'] : 0;

	// So, are you in or out? For us to be able to split, we know we can see the ticket, but the split point must be not the first msg and not deleted
	$query = shd_db_query('', '
		SELECT id_msg, id_member
		FROM {db_prefix}helpdesk_ticket_replies
		WHERE id_ticket = {int:ticket}
			AND id_msg = {int:msg}
			AND id_msg > {int:firstmsg}
			AND message_status = {int:message_status}',
		array(
			'ticket' => $context['ticket_id'],
			'msg' => $_REQUEST['at_msg'],
			'firstmsg' => $ticketinfo['id_first_msg'],
			'message_status' => MSG_STATUS_NORMAL,
		)
	);

	$found = $smcFunc['db_num_rows']($query) > 0;

	if (!$found)
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_reply', false);
	}
	else
	{
		$msginfo = $smcFunc['db_fetch_assoc']($query);
		$smcFunc['db_free_result']($query);
	}

	// Permission checking time
	if ($ticketinfo['id_member_started'] == $user_info['id'])
		shd_is_allowed_to('shd_split_ticket_own', $ticketinfo['dept']);
	else
		shd_is_allowed_to('shd_split_ticket_any', $ticketinfo['dept']);

	if (in_array($ticketinfo['status'], array(TICKET_STATUS_CLOSED, TICKET_STATUS_DELETED)))
		fatal_lang_error('shd_ticket_unavailable', false);

	// Lastly, check they actually specified both a subject and a suitably splitting option
	if (!isset($_POST['new_subject']) || $smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST['new_subject'])) === '')
		fatal_lang_error('shd_split_no_title', false);
	else
		$_POST['new_subject'] = strtr($smcFunc['htmlspecialchars']($_POST['new_subject']), array("\r" => '', "\n" => '', "\t" => ''));

	if (isset($_POST['send_pm']) && (!isset($_POST['pm_content']) || trim($_POST['pm_content']) == ''))
		fatal_lang_error('shd_split_no_pm', false);

	if (empty($_REQUEST['split_type']))
		$_REQUEST['split_type'] = '';

	if (!in_array($_REQUEST['split_type'], array('onlythis', 'afterthis')))
		fatal_lang_error('shd_split_invalid_type', false);

	// Right, if we're here, we're all good to go (the ticket is valid, the post is not deleted and in ticket, we know what we're doing, so let's go do!)
	$msgs_affected = array();
	if ($_REQUEST['split_type'] == 'onlythis')
		$msg_affected[] = $_REQUEST['at_msg'];
	else
	{
		$query = shd_db_query('', '
			SELECT id_msg
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_ticket = {int:ticket}
				AND id_msg >= {int:msg}',
			array(
				'ticket' => $context['ticket_id'],
				'msg' => $_REQUEST['at_msg'],
			)
		);
		while ($row = $smcFunc['db_fetch_row']($query))
			$msg_affected[] = $row[0];
	}

	// 1. Create the new container ticket
	$smcFunc['db_insert']('insert',
		'{db_prefix}helpdesk_tickets',
		array(
			'id_first_msg' => 'int', 'id_member_started' => 'int', 'subject' => 'string', 'urgency' => 'int', 'private' => 'int',
		),
		array(
			$_REQUEST['at_msg'], $msginfo['id_member'], $_POST['new_subject'], $ticketinfo['urgency'], $ticketinfo['private'],
		),
		array('id_ticket')
	);

	$new_ticket = $smcFunc['db_insert_id']('{db_prefix}helpdesk_tickets', 'id_ticket');

	// 2. Move the message(s) to the new ticket
	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_ticket_replies
		SET id_ticket = {int:new_ticket}
		WHERE id_ticket = {int:old_ticket}
			AND id_msg IN ({array_int:msgs})',
		array(
			'new_ticket' => $new_ticket,
			'old_ticket' => $context['ticket_id'],
			'msgs' => $msg_affected,
		)
	);

	// 3. Move their attachments too
	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_attachments
		SET id_ticket = {int:new_ticket}
		WHERE id_ticket = {int:old_ticket}
			AND id_msg IN ({array_int:msgs})',
		array(
			'new_ticket' => $new_ticket,
			'old_ticket' => $context['ticket_id'],
			'msgs' => $msg_affected,
		)
	);

	// 4. Clean up ids etc
	// 4.1 Origin ticket
	list($starter, $replier, $num_replies) = shd_recalc_ids($context['ticket_id']);
	$query_reply = shd_db_query('', '
		UPDATE {db_prefix}helpdesk_tickets
		SET status = {int:status}
		WHERE id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
			'status' => shd_determine_status('mergesplit', $starter, $replier, $num_replies),
		)
	);
	$owner = $starter;

	// 4.2 New ticket
	list($starter, $replier, $num_replies) = shd_recalc_ids($new_ticket);
	$query_reply = shd_db_query('', '
		UPDATE {db_prefix}helpdesk_tickets
		SET status = {int:status}
		WHERE id_ticket = {int:ticket}',
		array(
			'ticket' => $new_ticket,
			'status' => shd_determine_status('mergesplit', $starter, $replier, $num_replies),
		)
	);

	// !!! 4.3 Custom fields!

	// 5. Log the action
	shd_log_action('split_origin',
		array(
			'ticket' => $context['ticket_id'],
			'subject' => $ticketinfo['subject'],
			'otherticket' => $new_ticket,
			'othersubject' => $_POST['new_subject'],
		)
	);
	shd_log_action('split_new',
		array(
			'ticket' => $new_ticket,
			'subject' => $_POST['new_subject'],
			'otherticket' => $context['ticket_id'],
			'othersubject' => $ticketinfo['subject'],
		)
	);

	// 6. Empty the cache
	shd_clear_active_tickets($ticketinfo['dept']);

	// 7. Spam the ticket starter
	if (isset($_POST['send_pm']))
	{
		require($sourcedir . '/Subs-Post.php');
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
			'{source}' => $ticketinfo['subject'],
			'{link}' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
			'{splitlink}' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $new_ticket,
		);
		$message = str_replace(array_keys($replacements), array_values($replacements), $_POST['pm_content']);

		$recipients = array(
			'to' => array($owner),
			'bcc' => array()
		);

		sendpm($recipients, $txt['shd_ticket_split_subject'], un_htmlspecialchars($message));
	}

	// 8. Stick a fork in me, I'm done. User, you should go. Go soon. Go NAO.
	$context['linktree'][] = array(
		'name' => $txt['shd_ticket_split_ticket'],
	);

	$context['page_title'] = $txt['shd_split_ticket'];

	loadTemplate('sd_template/SimpleDesk-MergeSplit');
	$context['sub_template'] = 'shd_split_ticket2';

	$context['split_info'] = array(
		'ticket' => $context['ticket_id'],
		'subject' => $ticketinfo['subject'],
		'otherticket' => $new_ticket,
		'othersubject' => $_POST['new_subject'],
	);
}

?>