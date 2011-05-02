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
# File Info: SimpleDesk-Delete.php / 1.0 Felidae              #
###############################################################

/**
 *	This file deals with deletion/recycling of tickets and replies, subsequent restoration back to
 *	the helpdesk, and lastly, permanent deletion of the same.
 *
 *	@package source
 *	@todo Finish documenting this file.
 *	@since 1.0
*/

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Delete the given ticket, i.e move it to the recycling bin.
 *
 *	Accessed through ?action=helpdesk;sa=deleteticket;ticket=x;sessvar=sessid
 *
 *	Operations:
 *	- Session check
 *	- Check there's a ticket id
 *	- Check the ticket exists and is visible to the current user
 *	- Check permission to delete ticket matches (i.e. can delete any, or can delete own and this is one of ours)
 *	- Update the ticket's status to deleted
 *	- Log the deletion
 *	- Clear the menu's Helpdesk active items cache
 *	- return to the front page
 *
 *	@since 1.0
*/
function shd_ticket_delete()
{
	global $smcFunc, $user_info, $context;

	checkSession('get');

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket', false);

	// Check we can actually see the ticket we're deleting, and if we can only delete our own, we are the owner
	$query_ticket = shd_db_query('', '
		SELECT id_ticket, id_dept, id_member_started, subject
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);

	if ($row = $smcFunc['db_fetch_assoc']($query_ticket))
	{
		$smcFunc['db_free_result']($query_ticket);
		if (!shd_allowed_to('shd_delete_ticket_any', $row['id_dept']) && (!shd_allowed_to('shd_delete_ticket_own', $row['id_dept']) || $user_info['id'] != $row['id_member_started']))
			fatal_lang_error('shd_cannot_delete_ticket', false);
	}
	else
	{
		$smcFunc['db_free_result']($query_ticket);
		fatal_lang_error('shd_no_ticket', false);
	}

	$subject = $row['subject'];

	// Move it to deleted status
	$query_ticket = shd_db_query('', '
		UPDATE {db_prefix}helpdesk_tickets AS hdt
		SET status = {int:status_deleted},
		id_member_assigned = 0
		WHERE id_ticket = {int:current_ticket}
			AND {query_see_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
			'status_deleted' => TICKET_STATUS_DELETED, // just move it, don't bother calling merge (or shd_determine_status)
		)
	);

	shd_log_action('delete',
		array(
			'ticket' => $context['ticket_id'],
			'subject' => $subject,
		)
	);

	// Expire the cache of count(active tickets)
	shd_clear_active_tickets($row['id_dept']);

	// Go to the home
	redirectexit($context['shd_home'] . $context['shd_dept_link']);
}

function shd_reply_delete()
{
	global $smcFunc, $user_info, $context, $sourcedir;

	checkSession('get');

	$_REQUEST['reply'] = !empty($_REQUEST['reply']) ? (int) $_REQUEST['reply'] : 0;

	if (empty($_REQUEST['reply']) || empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket');

	// Check we can actually see the ticket we're deleting, that this reply is in this ticket and that we can delete this reply
	$query_ticket = shd_db_query('', '
		SELECT hdt.id_ticket, hdt.id_dept, hdtr.id_member, hdt.id_member_started, subject, status
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdt.id_ticket = hdtr.id_ticket)
		WHERE {query_see_ticket}
			AND hdt.id_ticket = {int:ticket}
			AND hdtr.id_msg = {int:reply}
			AND hdt.id_first_msg != {int:reply2}',
		array(
			'ticket' => $context['ticket_id'],
			'reply' => $_REQUEST['reply'],
			'reply2' => $_REQUEST['reply'], // since we can't delete the first message through the reply interface!
		)
	);

	if ($row = $smcFunc['db_fetch_assoc']($query_ticket))
	{
		$smcFunc['db_free_result']($query_ticket);
		if (($row['status'] == TICKET_STATUS_CLOSED || $row['status'] == TICKET_STATUS_DELETED) || (!shd_allowed_to('shd_delete_reply_any', $row['id_dept']) && (!shd_allowed_to('shd_delete_reply_own', $row['id_dept']) || $user_info['id'] != $row['id_member'])))
			fatal_lang_error('shd_cannot_delete_reply', false);
	}
	else
	{
		$smcFunc['db_free_result']($query_ticket);
		fatal_lang_error('shd_no_ticket', false);
	}

	$subject = $row['subject'];

	// OK, let's clear this one, hasta la vista... ticket.
	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_ticket_replies
		SET message_status = {int:msg_status_deleted}
		WHERE id_msg = {int:reply}',
		array(
			'msg_status_deleted' => MSG_STATUS_DELETED,
			'reply' => $_REQUEST['reply'],
		)
	);

	// Logtastic!
	shd_log_action('delete_reply',
		array(
			'ticket' => $context['ticket_id'],
			'subject' => $subject,
			'msg' => $_REQUEST['reply'],
		)
	);

	// OK, last but definitely not least, update num_replies and id_last_msg on the old ticket, and fix the old ticket's status
	list($starter, $replier, $num_replies) = shd_recalc_ids($context['ticket_id']);
	$query_reply = shd_db_query('', '
		UPDATE {db_prefix}helpdesk_tickets
		SET status = {int:status}
		WHERE id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
			'status' => shd_determine_status('deletereply', $starter, $replier, $num_replies),
		)
	);

	// Expire the cache of count(active tickets)
	shd_clear_active_tickets($row['id_dept']);

	// Back to the ticket
	redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}

// Delete the given reply or ticket from the database. This is the final deletion which cannot be undone.
function shd_perma_delete()
{
	global $smcFunc, $user_info, $context, $sourcedir;

	checkSession('get');

	// We have to have either a ticket or a reply to know what to delete (Or do you want me to drop your whole database? >:D)
	if (empty($context['ticket_id']) && empty($_REQUEST['reply']))
		fatal_lang_error('shd_no_ticket', false);

	// If we're deleting a whole ticket...
	if (!empty($context['ticket_id']) && empty($_REQUEST['reply']))
	{
		// Can we even see this ticket?
		$query_ticket = shd_db_query('', '
			SELECT id_ticket, id_dept, subject, id_member_started, status
			FROM {db_prefix}helpdesk_tickets AS hdt
			WHERE {query_see_ticket}
				AND id_ticket = {int:ticket}',
			array(
				'ticket' => $context['ticket_id'],
			)
		);

		if ($smcFunc['db_num_rows']($query_ticket) == 0)
		{
			$smcFunc['db_free_result']($query_ticket);
			fatal_lang_error('shd_no_ticket', false);
		}
		else
		{
			$row = $smcFunc['db_fetch_assoc']($query_ticket);
			shd_is_allowed_to('shd_delete_recycling', $row['id_dept']);
			$smcFunc['db_free_result']($query_ticket);
		}

		if ($row['status'] != TICKET_STATUS_DELETED)
			fatal_lang_error('shd_cannot_delete_ticket', false);

		$subject = $row['subject'];
		// Expire the cache of count(active tickets)
		shd_clear_active_tickets($row['id_dept']);

		// Start by getting all the messages in this ticket, we'll need those for custom fields values that need purging.
		$query = shd_db_query('', '
			SELECT id_msg
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_ticket = {int:current_ticket}',
			array(
				'current_ticket' => $context['ticket_id'],
			)
		);
		$msgs = array();
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$msgs[] = $row['id_msg'];
		$smcFunc['db_free_result']($query);

		if (!empty($msgs))
		{
			shd_db_query('', '
				DELETE FROM {db_prefix}helpdesk_custom_fields_values
				WHERE post_type = {int:type_reply}
					AND id_post IN ({array_int:msgs})',
				array(
					'type_reply' => CFIELD_REPLY,
					'msgs' => $msgs,
				)
			);
		}
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_custom_fields_values
			WHERE post_type = {int:type_ticket}
				AND id_post = {int:ticket}',
			array(
				'type_ticket' => CFIELD_TICKET,
				'ticket' => $context['ticket_id'],
			)
		);
		
		// Now deleting the actual ticket.
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_tickets
			WHERE id_ticket = {int:current_ticket}',
			array(
				'current_ticket' => $context['ticket_id'],
			)
		);

		// Then remove any replies associated with it.
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_ticket = {int:current_ticket}',
			array(
				'current_ticket' => $context['ticket_id'],
			)
		);

		// And attachments... work out which attachments that is
		$query = shd_db_query('', '
			SELECT id_attach
			FROM {db_prefix}helpdesk_attachments
				WHERE id_ticket = {int:ticket}',
			array(
				'ticket' => $context['ticket_id'],
			)
		);

		$attachIDs = array();
		while ($row = $smcFunc['db_fetch_row']($query))
			$attachIDs[] = $row[0];

		$smcFunc['db_free_result']($query);

		if (!empty($attachIDs))
		{
			// OK, so we have some ids
			require_once($sourcedir . '/ManageAttachments.php');
			$attachmentQuery = array(
				'attachment_type' => 0,
				'id_msg' => 0,
				'id_attach' => $attachIDs,
			);
			removeAttachments($attachmentQuery);
		}

		shd_log_action('permadelete',
			array(
				'ticket' => $context['ticket_id'],
				'subject' => $subject,
			)
		);

		redirectexit('action=helpdesk;sa=recyclebin');
	}
	// Or just a single reply...
	elseif (!empty($_REQUEST['reply']))
	{
		// Check we can actually see the ticket we're deleting, that this reply is in this ticket and that we can delete this reply
		$query_ticket = shd_db_query('', '
			SELECT hdt.id_ticket, hdt.id_dept, hdtr.id_member, hdt.subject, hdt.id_member_started, hdt.status, hdtr.message_status
			FROM {db_prefix}helpdesk_tickets AS hdt
				INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdt.id_ticket = hdtr.id_ticket)
			WHERE {query_see_ticket}
				AND hdt.id_ticket = {int:ticket}
				AND hdtr.id_msg = {int:reply}
				AND hdt.id_first_msg != {int:reply2}',
			array(
				'ticket' => $context['ticket_id'],
				'reply' => $_REQUEST['reply'],
				'reply2' => $_REQUEST['reply'], // since we can't delete the first message through the reply interface!
			)
		);

		if ($smcFunc['db_num_rows']($query_ticket) == 0)
		{
			$smcFunc['db_free_result']($query_ticket);
			fatal_lang_error('shd_no_ticket', false);
		}
		else
		{
			$row = $smcFunc['db_fetch_assoc']($query_ticket);
			shd_is_allowed_to('shd_delete_recycling', $row['id_dept']);
			$smcFunc['db_free_result']($query_ticket);
		}

		if ($row['status'] == TICKET_STATUS_DELETED || $row['message_status'] != MSG_STATUS_DELETED)
			fatal_lang_error('shd_cannot_delete_reply', false);

		$subject = $row['subject'];
		// Expire the cache of count(active tickets)
		shd_clear_active_tickets($row['id_dept']);

		// Just remove the reply.
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_msg = {int:current_reply}',
			array(
				'current_reply' => (int) $_REQUEST['reply'],
			)
		);

		// Custom fields
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_custom_fields_values
			WHERE id_post = {int:reply}
				AND post_type = {int:type_reply}',
			array(
				'reply' => (int) $_REQUEST['reply'],
				'type_reply' => CFIELD_REPLY,
			)
		);

		// Now to handle attachments
		$query = shd_db_query('', '
			SELECT id_attach
			FROM {db_prefix}helpdesk_attachments
				WHERE id_msg = {int:msg}',
			array(
				'msg' => (int) $_REQUEST['reply'],
			)
		);

		$attachIDs = array();
		while ($row = $smcFunc['db_fetch_row']($query))
			$attachIDs[] = $row[0];

		$smcFunc['db_free_result']($query);

		if (!empty($attachIDs))
		{
			// OK, so we have some ids
			require_once($sourcedir . '/ManageAttachments.php');
			$attachmentQuery = array(
				'attachment_type' => 0,
				'id_msg' => 0,
				'id_attach' => $attachIDs,
			);
			removeAttachments($attachmentQuery);
		}

		shd_log_action('permadelete_reply',
			array(
				'ticket' => $context['ticket_id'],
				'subject' => $subject,
			)
		);

		list($starter, $replier, $num_replies) = shd_recalc_ids($context['ticket_id']);
		$query_reply = shd_db_query('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET status = {int:status}
			WHERE id_ticket = {int:ticket}',
			array(
				'ticket' => $context['ticket_id'],
				'status' => shd_determine_status('deletereply', $starter, $replier, $num_replies),
			)
		);

		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
	}
	else
		fatal_lang_error('shd_no_ticket');
}

// Delete a given attachment from the one-click interface.
function shd_attach_delete()
{
	global $smcFunc, $user_info, $context, $sourcedir;

	if (empty($context['ticket_id']) || empty($_GET['attach']) || (int) $_GET['attach'] == 0)
		fatal_lang_error('no_access', false);

	$_GET['attach'] = (int) $_GET['attach'];

	// Well, we have a ticket id. Let's figure out what department we're in so we can check permissions.
	$query = shd_db_query('', '
		SELECT hdt.id_dept, a.filename, hda.id_msg, hdt.subject
		FROM {db_prefix}attachments AS a
			INNER JOIN {db_prefix}helpdesk_attachments AS hda ON (hda.id_attach = a.id_attach)
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hda.id_ticket = hdt.id_ticket)
		WHERE {query_see_ticket}
			AND hda.id_ticket = {int:ticket}
			AND hda.id_attach = {int:attach}
			AND a.attachment_type = 0',
		array(
			'attach' => $_GET['attach'],
			'ticket' => $context['ticket_id'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('no_access');
	}

	list($dept, $filename, $id_msg, $subject) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	shd_is_allowed_to('shd_delete_attachment', $dept);

	// So, we can delete the attachment. We already know it exists, we know we have permission.
	$log_params = array(
		'subject' => $subject,
		'ticket' => $context['ticket_id'],
		'msg' => $id_msg,
		'att_removed' => array(htmlspecialchars($filename)),
	);

	shd_log_action('editticket', $log_params);

	// Now you can delete
	require_once($sourcedir . '/ManageAttachments.php');
	$attachmentQuery = array(
		'attachment_type' => 0,
		'id_msg' => 0,
		'id_attach' => array($_GET['attach']),
	);
	removeAttachments($attachmentQuery);

	redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}

// Restore the given ticket from the recycling bin.
function shd_ticket_restore()
{
	global $smcFunc, $user_info, $context;

	checkSession('get');

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket', false);

	// Does the ticket we're trying to restore exist and can we see it?
	$query_ticket = shd_db_query('', '
		SELECT id_ticket, id_dept, id_member_started, id_member_updated, subject, num_replies, status
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);

	if ($row = $smcFunc['db_fetch_assoc']($query_ticket))
	{
		$smcFunc['db_free_result']($query_ticket);
		if ($row['status'] != TICKET_STATUS_DELETED || (!shd_allowed_to('shd_restore_ticket_any', $row['id_dept']) && (!shd_allowed_to('shd_restore_ticket_own', $row['id_dept']) || $user_info['id'] != $row['id_member_started'])))
			fatal_lang_error('shd_cannot_restore_ticket', false);

		$subject = $row['subject'];
		$starter = $row['id_member_started'];
		$replier = $row['id_member_updated'];
		$num_replies = $row['num_replies'];
	}
	else
	{
		$smcFunc['db_free_result']($query_ticket);
		fatal_lang_error('shd_no_ticket', false);
	}

	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_tickets AS hdt
		SET status = {int:status_new}
		WHERE id_ticket = {int:current_ticket}
			AND {query_see_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
			'status_new' => shd_determine_status('restoreticket', $starter, $replier, $num_replies),
		)
	);

	// Expire the cache of count(active tickets)
	shd_clear_active_tickets($row['id_dept']);

	shd_log_action('restore',
		array(
			'ticket' => $context['ticket_id'],
			'subject' => $subject,
		)
	);

	// And home.
	if (isset($_REQUEST['home']))
		redirectexit($context['shd_home'] . $context['shd_dept_link']);
	else
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}

// Restore the given reply from the recycling bin.
function shd_reply_restore()
{
	global $smcFunc, $user_info, $context, $sourcedir;

	checkSession('get');

	$_REQUEST['reply'] = empty($_REQUEST['reply']) ? 0 : (int) $_REQUEST['reply'];

	if (empty($_REQUEST['reply']))
		fatal_lang_error('shd_no_ticket', false);

	// Check we can actually see the ticket we're restoring from, and that we can restore this reply
	$query_ticket = shd_db_query('', '
		SELECT hdt.id_ticket, hdt.id_dept, hdtr.id_member, hdt.id_member_started, hdt.id_member_updated, hdt.num_replies, hdt.subject, hdt.status, hdtr.message_status
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdt.id_ticket = hdtr.id_ticket)
		WHERE {query_see_ticket}
			AND hdtr.id_msg = {int:reply}
			AND hdt.id_first_msg != {int:reply2}',
		array(
			'reply' => $_REQUEST['reply'],
			'reply2' => $_REQUEST['reply'],
		)
	);

	if ($row = $smcFunc['db_fetch_assoc']($query_ticket))
	{
		$smcFunc['db_free_result']($query_ticket);
		if (($row['status'] == TICKET_STATUS_DELETED || $row['status'] == TICKET_STATUS_CLOSED || $row['message_status'] != MSG_STATUS_DELETED) || (!shd_allowed_to('shd_restore_reply_any', $row['id_dept']) && (!shd_allowed_to('shd_restore_reply_own', $row['id_dept']) || $user_info['id'] != $row['id_member'])))
			fatal_lang_error('shd_cannot_restore_reply', false);

		$context['ticket_id'] = (int) $row['id_ticket'];
		$subject = $row['subject'];
		$starter = $row['id_member_started'];
		$replier = $row['id_member_updated'];
		$num_replies = $row['num_replies'];
	}
	else
	{
		$smcFunc['db_free_result']($query_ticket);
		fatal_lang_error('shd_no_ticket', false);
	}

	// OK, let's clear this one, hasta la vista... ticket.
	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_ticket_replies
		SET message_status = {int:msg_status_deleted}
		WHERE id_msg = {int:reply}',
		array(
			'msg_status_deleted' => MSG_STATUS_NORMAL,
			'reply' => $_REQUEST['reply'],
		)
	);

	// Captain's Log, stardate 18.3.10.1010
	shd_log_action('restore_reply',
		array(
			'ticket' => $context['ticket_id'],
			'subject' => $subject,
			'msg' => $_REQUEST['reply'],
		)
	);

	// Fix the topic data
	list($starter, $replier, $num_replies) = shd_recalc_ids($context['ticket_id']);
	$query_reply = shd_db_query('', '
		UPDATE {db_prefix}helpdesk_tickets
		SET status = {int:status}
		WHERE id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
			'status' => shd_determine_status('restorereply', $starter, $replier, $num_replies),
		)
	);

	// Expire the cache of count(active tickets)
	shd_clear_active_tickets($row['id_dept']);

	redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}

?>