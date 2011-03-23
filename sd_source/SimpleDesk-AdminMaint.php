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
# File Info: SimpleDesk-AdminMaint.php / 1.0 Felidae          #
###############################################################

/**
 *	This file handles the core of SimpleDesk's administrative maintenance.
 *
 *	@package source
 *	@since 1.1
*/
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	The start point for maintenance.
 *
 *	We're directed here from the main administration centre, after permission checks and a few dependencies loaded.
 *
 *	@since 1.1
*/
function shd_admin_maint()
{
	global $context, $txt, $db_show_debug;

	// Right, if we're here, we really, really need to turn this off. Because anything we do from this page onwards hurts the log badly.
	$db_show_debug = false;

	loadTemplate('sd_template/SimpleDesk-AdminMaint');
	loadTemplate(false, array('admin', 'helpdesk_admin'));
	loadLanguage('ManageMaintenance');

	$subactions = array(
		'main' => 'shd_admin_maint_home',
		'findrepair' => 'shd_admin_maint_findrepair',
	);

	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subactions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'main';
	$subactions[$_REQUEST['sa']]();
}

function shd_admin_maint_home()
{
	global $context, $txt;

	$context['sub_template'] = 'shd_admin_maint_home';
	$context['page_title'] = $txt['shd_admin_maint'];
}

function shd_admin_maint_findrepair()
{
	global $context, $txt;
	checkSession('request');

	$context['page_title'] = $txt['shd_admin_maint_findrepair'];

	$context['maint_steps'] = array();
	$context['maint_steps'] = array(
		array(
			'name' => 'zero_entries',
			'pc' => 5,
		),
		array(
			'name' => 'deleted',
			'pc' => 10,
		),
		array(
			'name' => 'first_last',
			'pc' => 10,
		),
		array(
			'name' => 'status',
			'pc' => 10,
		),
		array(
			'name' => 'clean_cache',
			'pc' => 5,
		),
	);

	if (isset($_GET['done']))
	{
		$context['sub_template'] = 'shd_admin_maint_findrepairdone';
		$context['maintenance_result'] = !empty($_SESSION['shd_maint']) ? $_SESSION['shd_maint'] : array();
		unset($_SESSION['shd_maint']);
		return;
	}

	$context['step'] = isset($_REQUEST['step']) ? (int) $_REQUEST['step'] : 0;
	if (!isset($context['maint_steps'][$context['step']]))
		$context['step'] = 0;

	$context['continue_countdown'] = 3;
	$context['continue_get_data'] = '?action=admin;area=helpdesk_maint;sa=findrepair;' . $context['session_var'] . '=' . $context['session_id'];
	$context['continue_post_data'] = '';
	$context['sub_template'] = 'not_done';

	$context['continue_percent'] = 0;
	for ($i = 0; $i <= $context['step']; $i++)
		$context['continue_percent'] += $context['maint_steps'][$i]['pc'];

	$function = 'shd_maint_' . $context['maint_steps'][$context['step']]['name'];
	$function();
}

// Validate that all tickets and messages have a valid id number
function shd_maint_zero_entries()
{
	global $context, $smcFunc;

	// Check for tickets with id-ticket of 0.
	$query = $smcFunc['db_query']('', '
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_tickets
		WHERE id_ticket = 0');
	list($tickets) = $smcFunc['db_fetch_row']($query);
	if (!empty($tickets))
	{
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET id_ticket = NULL
			WHERE id_ticket = 0');
		$_SESSION['shd_maint']['zero_tickets'] = $smcFunc['db_affected_rows']();
	}

	// And ticket replies with an id-msg 0
	$query = $smcFunc['db_query']('', '
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_ticket_replies
		WHERE id_msg = 0');
	list($msgs) = $smcFunc['db_fetch_row']($query);
	if (!empty($msgs))
	{
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_ticket_replies
			SET id_msg = NULL
			WHERE id_msg = 0');
		$_SESSION['shd_maint']['zero_msgs'] = $smcFunc['db_affected_rows']();
	}

	// This is a short operation, no suboperation, so just tell it to go onto the next step.
	$context['continue_post_data'] .= '<input type="hidden" name="step" value="' . ($context['step'] + 1) . '" />';
}

// Ensure that the count of number of replies/deleted replies/whether ticket contains deleted replies are all correct.
function shd_maint_deleted()
{
	global $context, $smcFunc;

	// First we need the number of tickets
	$query = $smcFunc['db_query']('', '
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_tickets');
	list($ticket_count) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	$_REQUEST['start'] = isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0;

	$step_size = 100;
	$tickets = array();
	$tickets_modify = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_ticket, num_replies, deleted_replies, withdeleted
		FROM {db_prefix}helpdesk_tickets
		ORDER BY id_ticket ASC
		LIMIT {int:start}, {int:limit}',
		array(
			'start' => $_REQUEST['start'],
			'limit' => $step_size,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$tickets[$row['id_ticket']] = $row;
	$smcFunc['db_free_result']($query);

	if (!empty($tickets))
	{
		// Firstly, let's check the numbers of replies and deleted replies, see if they're right.
		$query = $smcFunc['db_query']('', '
			SELECT id_ticket, message_status, COUNT(*) AS count
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_ticket IN ({array_int:tickets})
			GROUP BY id_ticket, message_status',
			array(
				'tickets' => array_keys($tickets),
			)
		);
		$ticket_cache = array();
		while ($row = $smcFunc['db_fetch_assoc']($query))
		{
			if (!isset($ticket_cache[$row['id_ticket']]))
				$ticket_cache[$row['id_ticket']] = array(
					'num_replies' => 0,
					'deleted_replies' => 0,
					'withdeleted' => 0,
				);

			if ($row['message_status'] == MSG_STATUS_NORMAL)
				$ticket_cache[$row['id_ticket']]['num_replies'] = $row['count'] - 1; // since we never want to count the first message (which can't ever be deleted on its own)
			elseif ($row['message_status'] == MSG_STATUS_DELETED)
			{
				$ticket_cache[$row['id_ticket']]['deleted_replies'] = $row['count'];
				$ticket_cache[$row['id_ticket']]['withdeleted'] = 1;
			}
		}
		$smcFunc['db_free_result']($query);

		// OK so we now have the ticket counts for normal/deleted posts. Are they right?
		foreach ($ticket_cache as $id_ticket => $ticket_details)
			if ($ticket_cache[$id_ticket]['num_replies'] != $tickets[$id_ticket]['num_replies'] || $ticket_cache[$id_ticket]['deleted_replies'] != $tickets[$id_ticket]['deleted_replies'] || $ticket_cache[$id_ticket]['withdeleted'] != $tickets[$id_ticket]['withdeleted'])
				$tickets_modify[$id_ticket] = $ticket_cache[$id_ticket];

		// Any to update?
		if (!empty($tickets_modify))
		{
			// Oh crap.
			foreach ($tickets_modify as $id_ticket => $columns)
			{
				$smcFunc['db_query']('', '
					UPDATE {db_prefix}helpdesk_tickets
					SET num_replies = {int:num_replies},
						deleted_replies = {int:deleted_replies},
						withdeleted = {int:withdeleted}
					WHERE id_ticket = {int:id_ticket}',
					array(
						'id_ticket' => $id_ticket,
						'num_replies' => $columns['num_replies'],
						'deleted_replies' => $columns['deleted_replies'],
						'withdeleted' => $columns['withdeleted'],
					)
				);
			}
			$_SESSION['shd_maint']['deleted'] = count($tickets_modify);
		}
	}

	// Another round?
	$_REQUEST['start'] += $step_size;
	if ($_REQUEST['start'] > $ticket_count)
	{
		// All done
		$context['continue_post_data'] .= '<input type="hidden" name="step" value="' . ($context['step'] + 1) . '" />';
	}
	else
	{
		// More to do, call back - and provide the subtitle
		$context['continue_post_data'] .= '<input type="hidden" name="step" value="' . $context['step'] . '" />
		<input type="hidden" name="start" value="' . $_REQUEST['start'] . '">';
		$context['substep_enabled'] = true;
		$context['substep_title'] = $txt['shd_admin_maint_findrepair_status'];
		$context['substep_continue_percent'] = round(100 * $_REQUEST['start'] / $ticket_count);
	}
}

// Make sure the first and last posters on a ticket are correct.
function shd_maint_first_last()
{
	global $context, $smcFunc;

	// First we need the number of tickets
	$query = $smcFunc['db_query']('', '
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_tickets');
	list($ticket_count) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	$_REQUEST['start'] = isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0;

	$step_size = 150;
	$tickets = array();
	$tickets_modify = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_ticket, id_first_msg, id_last_msg
		FROM {db_prefix}helpdesk_tickets
		ORDER BY id_ticket ASC
		LIMIT {int:start}, {int:limit}',
		array(
			'start' => $_REQUEST['start'],
			'limit' => $step_size,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$tickets[$row['id_ticket']] = $row;
	$smcFunc['db_free_result']($query);

	if (!empty($tickets))
	{
		// Firstly, let's get the first/last messages from the messages table.
		$query = $smcFunc['db_query']('', '
			SELECT id_ticket, MIN(id_msg) AS id_first_msg, MAX(id_msg) AS id_last_msg
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_ticket IN ({array_int:tickets})
				AND message_status = ({int:normal})
			GROUP BY id_ticket',
			array(
				'tickets' => array_keys($tickets),
				'normal' => MSG_STATUS_NORMAL,
			)
		);
		$ticket_cache = array();
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$ticket_cache[$row['id_ticket']] = $row;
		$smcFunc['db_free_result']($query);

		// OK so we now have the message ids for first/last message. Are they right?
		foreach ($ticket_cache as $id_ticket => $ticket_details)
			if ($ticket_cache[$id_ticket]['id_first_msg'] != $tickets[$id_ticket]['id_first_msg'] || $ticket_cache[$id_ticket]['id_last_msg'] != $tickets[$id_ticket]['id_last_msg'])
				$tickets_modify[$id_ticket] = $ticket_cache[$id_ticket];

		// Any to update?
		if (!empty($tickets_modify))
		{
			// Oh crap.
			foreach ($tickets_modify as $id_ticket => $columns)
			{
				$smcFunc['db_query']('', '
					UPDATE {db_prefix}helpdesk_tickets
					SET id_first_msg = {int:id_first_msg},
						id_last_msg = {int:id_last_msg}
					WHERE id_ticket = {int:id_ticket}',
					$columns
				);
			}
			$_SESSION['shd_maint']['first_last'] = count($tickets_modify);
		}
	}

	// Another round?
	$_REQUEST['start'] += $step_size;
	if ($_REQUEST['start'] > $ticket_count)
	{
		// All done
		$context['continue_post_data'] .= '<input type="hidden" name="step" value="' . ($context['step'] + 1) . '" />';
	}
	else
	{
		// More to do, call back - and provide the subtitle
		$context['continue_post_data'] .= '<input type="hidden" name="step" value="' . $context['step'] . '" />
		<input type="hidden" name="start" value="' . $_REQUEST['start'] . '">';
		$context['substep_enabled'] = true;
		$context['substep_title'] = $txt['shd_admin_maint_findrepair_firstlast'];
		$context['substep_continue_percent'] = round(100 * $_REQUEST['start'] / $ticket_count);
	}
}

// Make sure all open tickets have the right statuses.
function shd_maint_status()
{
	global $context, $smcFunc;

	$open = array(TICKET_STATUS_NEW, TICKET_STATUS_PENDING_STAFF, TICKET_STATUS_PENDING_USER);

	// First we need the number of tickets
	$query = $smcFunc['db_query']('', '
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_tickets
		WHERE status IN ({array_int:open})',
		array(
			'open' => $open,
		)
	);
	list($ticket_count) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	$_REQUEST['start'] = isset($_REQUEST['start']) ? (int) $_REQUEST['start'] : 0;

	$step_size = 100;
	$tickets = array();
	$tickets_modify = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_ticket, num_replies, id_member_started, id_member_updated, status
		FROM {db_prefix}helpdesk_tickets
		WHERE status IN ({array_int:open})
		ORDER BY id_ticket ASC
		LIMIT {int:start}, {int:limit}',
		array(
			'open' => $open,
			'start' => $_REQUEST['start'],
			'limit' => $step_size,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$tickets[$row['id_ticket']] = $row;
	$smcFunc['db_free_result']($query);

	if (!empty($tickets))
	{
		foreach ($tickets as $ticket)
		{
			$new_status = shd_determine_status('reply', $ticket['id_member_started'], $ticket['id_member_updated'], $ticket['num_replies']);
			if ($ticket['status'] != $new_status)
				$tickets_modify[$ticket['id_ticket']] = $new_status;
		}

		// Any to update?
		if (!empty($tickets_modify))
		{
			// Oh crap.
			foreach ($tickets_modify as $id_ticket => $status)
			{
				$smcFunc['db_query']('', '
					UPDATE {db_prefix}helpdesk_tickets
					SET status = {int:status}
					WHERE id_ticket = {int:id_ticket}',
					array(
						'id_ticket' => $id_ticket,
						'status' => $status,
					)
				);
			}
			$_SESSION['shd_maint']['status'] = count($tickets_modify);
		}
	}

	// Another round?
	$_REQUEST['start'] += $step_size;
	if ($_REQUEST['start'] > $ticket_count)
	{
		// All done
		$context['continue_post_data'] .= '<input type="hidden" name="step" value="' . ($context['step'] + 1) . '" />';
	}
	else
	{
		// More to do, call back - and provide the subtitle
		$context['continue_post_data'] .= '<input type="hidden" name="step" value="' . $context['step'] . '" />
		<input type="hidden" name="start" value="' . $_REQUEST['start'] . '">';
		$context['substep_enabled'] = true;
		$context['substep_title'] = $txt['shd_admin_maint_findrepair_firstlast'];
		$context['substep_continue_percent'] = round(100 * $_REQUEST['start'] / $ticket_count);
	}
}

// Make sure all SimpleDesk cache items are forcibly flushed.
function shd_maint_clean_cache()
{
	global $context;
	clean_cache('shd');

	// Normally, we'd update $context['continue_post_data'] to indicate our next port of call. But here, we don't have to.
	redirectexit('action=admin;area=helpdesk_maint;sa=findrepair;done;' . $context['session_var'] . '=' . $context['session_id']);
}

?>