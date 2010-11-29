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
 *	- purge deleted tickets
 *
 *	@since 1.1
*/

function shd_scheduled()
{
	global $smcFunc, $modSettings;

	shd_scheduled_purge_tickets();
	return true;
}

function shd_scheduled_purge_tickets()
{
	global $smcFunc, $modSettings;

	if (empty($modSettings['shd_purge_tickets']) || empty($modSettings['shd_purge_tickets_days']))
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
	$del_time = time() - (86400 * $modSettings['shd_purge_tickets_days']);
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