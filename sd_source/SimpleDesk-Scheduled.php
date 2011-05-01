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
# File Info: SimpleDesk-Assign.php / 1.0 Felidae              #
###############################################################

/**
 *	This file handles the scheduled tasks that can come along.
 *
 *	@package source
 *	@since 1.0
*/

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Container task for all the scheduled maintenance that SD can be asked to do.
 *
 *	- close older open tickets (if not replied to within a given number of days)
 *	- purge deleted tickets (delete their contents aftet a given number of days of being already deleted)
 *
 *	@since 1.1
*/

function shd_scheduled()
{
	global $smcFunc, $modSettings;

	shd_scheduled_close_tickets();
	shd_scheduled_purge_tickets();
	return true;
}

function shd_scheduled_close_tickets()
{
	global $modSettings, $smcFunc, $txt;

	if (empty($modSettings['shd_autoclose_tickets']) || empty($modSettings['shd_autoclose_tickets_days']))
		return;

	@set_time_limit(600); // Ten minutes. Is a big job, possibly.

	// 1. Get the list of tickets.
	$query = $smcFunc['db_query']('', '
		SELECT hdt.id_ticket, hdt.subject, hdt.id_member_started, hdt.id_member_updated, hdtr_last.poster_time
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_last ON (hdt.id_last_msg = hdtr_last.id_msg)
		WHERE hdt.status IN ({array_int:open})
			AND poster_time <= {int:old_time}',
		array(
			'open' => array(TICKET_STATUS_NEW, TICKET_STATUS_PENDING_STAFF, TICKET_STATUS_PENDING_USER),
			'old_time' => time() - 86400 * $modSettings['shd_autoclose_tickets_days'],
		)
	);
	$tickets = array();
	$subjects = array();
	$members = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$tickets[$row['id_ticket']] = $row['id_ticket'];
		$subjects[$row['id_ticket']] = $row['subject'];
		$members[] = $row['id_member_started'];
		$members[] = $row['id_member_updated'];
	}
	$smcFunc['db_free_result']($query);

	// Any to do?
	if (empty($tickets))
		return;

	// 2. Update the tickets.
	$query = $smcFunc['db_query']('', '
		UPDATE {db_prefix}helpdesk_tickets
		SET status = {int:closed}
		WHERE id_ticket IN ({array_int:tickets})',
		array(
			'closed' => TICKET_STATUS_CLOSED,
			'tickets' => $tickets,
		)
	);

	// 3. Update the log if appropriate. Normally we would call shd_log_action(), however here... we might be doing a lot, so instead, we do it manually ourselves.
	if (empty($modSettings['shd_disable_action_log']) && !empty($modSettings['shd_logopt_autoclose']))
	{
		$rows = array();
		$time = time();
		foreach ($tickets as $ticket)
		{
			$rows[] = array(
				$time, // log_time
				0, // id_member
				'', // ip
				'autoclose', // action
				$ticket, // id_ticket
				0, // id_msg
				serialize(array(
					'subject' => $subjects[$ticket],
					'auto' => true, // indicate to the action log that this is the case
				)),
			);
		}

		$smcFunc['db_insert']('',
			'{db_prefix}helpdesk_log_action',
			array(
				'log_time' => 'int', 'id_member' => 'int', 'ip' => 'string-16', 'action' => 'string', 'id_ticket' => 'int', 'id_msg' => 'int', 'extra' => 'string-65534',
			),
			$rows,
			array('id_action')
		);
	}

	// 4. If caching is enabled, make sure to purge the cache for members so their number of tickets will be recalculated.
	// No need to dump all SD cache items though, though we have to get all those whose tickets were affected, plus all staff.
	shd_clear_active_tickets();
}

function shd_scheduled_purge_tickets()
{
	global $smcFunc, $modSettings;

	if (empty($modSettings['shd_autopurge_tickets']) || empty($modSettings['shd_autopurge_tickets_days']))
		return;

	@set_time_limit(600); // Ten minutes. Is a big job, possibly.

	// 1. Get the list of deleted tickets.
	$query = $smcFunc['db_query']('', '
		SELECT hdt.id_ticket, hdt.subject
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE hdt.status = {int:deleted}',
		array(
			'deleted' => TICKET_STATUS_DELETED,
		)
	);
	$tickets = array();
	$subjects = array();
	while ($row = $smcFunc['db_fetch_row']($query))
	{
		$tickets[$row[0]] = 0;
		$subjects[$row[0]] = $row['subject'];
	}
	$smcFunc['db_free_result']($query);

	// 1b. Any to do? If not, get lost.
	if (empty($tickets))
		return;

	// 2. Get the real last post time from the real last message, not the 'last message' the ticket stores (which is the last message that isn't deleted)
	$query = $smcFunc['db_query']('', '
		SELECT id_ticket, MAX(poster_time) AS max_time
		FROM {db_prefix}helpdesk_ticket_replies
		WHERE id_ticket IN ({array_int:tickets})
		GROUP BY id_ticket',
		array(
			'tickets' => array_keys($tickets),
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$tickets[$row['id_ticket']] = $row['max_time'];
	$smcFunc['db_free_result']($query);

	// 3. Purge that list of threads too new to be deleted
	$del_time = time() - (86400 * $modSettings['shd_autopurge_tickets_days']);
	foreach ($tickets as $k => $v)
	{
		if ($v == 0 || $v > $del_time)
			unset($tickets[$k], $subjects[$k]);
	}

	// Last chance to abort!
	if (empty($tickets))
		return;

	// 4. OK, we have a nice list of tickets to purge. So, let's get to it.
	// 4.1. Delete the ticket records themselves.
	$smcFunc['db_query']('', '
		DELETE FROM {db_prefix}helpdesk_tickets
		WHERE id_ticket IN ({array_int:tickets})',
		array(
			'tickets' => array_keys($tickets),
		)
	);
	// 4.2. The replies.
	$smcFunc['db_query']('', '
		DELETE FROM {db_prefix}helpdesk_ticket_replies
		WHERE id_ticket IN ({array_int:tickets})',
		array(
			'tickets' => array_keys($tickets),
		)
	);
	// 4.3. Attachments.

	// 4.4. Relationships.
	$smcFunc['db_query']('', '
		DELETE FROM {db_prefix}helpdesk_relationships
		WHERE primary_ticket IN ({array_int:tickets})',
		array(
			'tickets' => array_keys($tickets),
		)
	);
	$smcFunc['db_query']('', '
		DELETE FROM {db_prefix}helpdesk_relationships
		WHERE secondary_ticket IN ({array_int:tickets})',
		array(
			'tickets' => array_keys($tickets),
		)
	);
	// 4.5. Read/unread log
	$smcFunc['db_query']('', '
		DELETE FROM {db_prefix}helpdesk_log_read
		WHERE id_ticket IN ({array_int:tickets})',
		array(
			'tickets' => array_keys($tickets),
		)
	);
	// 4.6. Log everything.
}

?>