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
# SimpleDesk Version: 2.0 Anatidae                            #
# File Info: SimpleDesk-AdminMaint.php / 2.0 Anatidae         #
###############################################################

/**
 *	This file handles the core of SimpleDesk's administrative maintenance.
 *
 *	@package source
 *	@since 2.0
*/
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	The start point for maintenance.
 *
 *	We're directed here from the main administration centre, after permission checks and a few dependencies loaded.
 *
 *	@since 2.0
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
		'reattribute' => 'shd_admin_maint_reattribute',
		'massdeptmove' => 'shd_admin_maint_massdeptmove',
		'findrepair' => 'shd_admin_maint_findrepair',
	);

	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subactions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'main';
	$subactions[$_REQUEST['sa']]();
}

function shd_admin_maint_home()
{
	global $context, $txt, $smcFunc;

	$depts = shd_allowed_to('access_helpdesk', false);
	if (count($depts) > 1)
	{
		$context['dept_list'] = array(
			0 => $txt['shd_admin_maint_massdeptmove_select'],
		);
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
	}

	$context['sub_template'] = 'shd_admin_maint_home';
	$context['page_title'] = $txt['shd_admin_maint'];
}

function shd_admin_maint_reattribute()
{
	global $context, $txt, $smcFunc, $sourcedir;
	checkSession('request');

	$context['page_title'] = $txt['shd_admin_maint_reattribute'];
	$context['sub_template'] = 'shd_admin_maint_reattributedone';

	// Find the member.
	require_once($sourcedir . '/Subs-Auth.php');
	$members = findMembers($_POST['to']);

	if (empty($members))
		fatal_lang_error('shd_reattribute_cannot_find_member');

	$memID = array_shift($members);
	$memID = $memID['id'];

	if ($_POST['type'] == 'email')
	{
		if (empty($_POST['from_email']))
			fatal_lang_error('shd_reattribute_no_email');
		$clause = 'poster_email = {string:attribute}';
		$attribute = $_POST['from_email'];
	}
	elseif ($_POST['type'] == 'name')
	{
		if (empty($_POST['from_name']))
			fatal_lang_error('shd_reattribute_no_user');
		$clause = 'poster_name = {string:attribute}';
		$attribute = $_POST['from_name'];
	}
	else
		fatal_lang_error('shd_reattribute_no_user');

	// Now, we don't delete the user id from posts on account deletion, never have.
	// So, get all the user ids attached to this user/email, make sure they're not in use, and then reattribute them.
	$members = array();
	$request = $smcFunc['db_query']('', '
		SELECT id_member
		FROM {db_prefix}helpdesk_ticket_replies
		WHERE ' . $clause,
		array(
			'attribute' => $attribute,
		)
	);
	while ($row = $smcFunc['db_fetch_row']($request))
		$members[] = $row[0];
	$smcFunc['db_free_result']($request);

	// Did we find any members? If not, bail.
	if (empty($members))
		fatal_lang_error('shd_reattribute_no_messages', false);

	// So we found some old member ids. Are any of them still in use?
	$temp_members = loadMemberData($members, false, 'minimal');
	if (empty($temp_members))
		$temp_members = array();
	$members = array_diff($members, $temp_members);

	if (empty($members))
		fatal_lang_error('shd_reattribute_in_use', false);

	// OK, let's go!
	$smcFunc['db_query']('', '
		UPDATE {db_prefix}helpdesk_ticket_replies
		SET id_member = {int:new_id}
		WHERE id_member IN ({array_int:old_ids})',
		array(
			'new_id' => $memID,
			'old_ids' => $members,
		)
	);
}

function shd_admin_maint_massdeptmove()
{
	global $context, $txt, $smcFunc, $sourcedir;
	checkSession('request');

	$context['page_title'] = $txt['shd_admin_maint_massdeptmove'];
	$depts = shd_allowed_to('access_helpdesk', false);

	$_POST['id_dept_from'] = isset($_POST['id_dept_from']) ? (int) $_POST['id_dept_from'] : 0;
	$_POST['id_dept_to'] = isset($_POST['id_dept_to']) ? (int) $_POST['id_dept_to'] : 0;
	if ($_POST['id_dept_from'] == 0 || $_POST['id_dept_to'] == 0 || !in_array($_POST['id_dept_from'], $depts) || !in_array($_POST['id_dept_to'], $depts))
		fatal_lang_error('shd_unknown_dept', false);
	elseif ($_POST['id_dept_from'] == $_POST['id_dept_to'])
		fatal_lang_error('shd_admin_maint_massdeptmove_samedept', false);

	$clauses = array();
	if (empty($_POST['moveopen']))
		$clauses[] = 'AND status NOT IN (' . implode(',', array(TICKET_STATUS_NEW, TICKET_STATUS_PENDING_USER, TICKET_STATUS_PENDING_STAFF, TICKET_STATUS_WITH_SUPERVISOR, TICKET_STATUS_ESCALATED)) . ')';
	if (empty($_POST['moveclosed']))
		$clauses[] = 'AND status != ' . TICKET_STATUS_CLOSED;
	if (empty($_POST['movedeleted']))
		$clauses[] = 'AND status != ' . TICKET_STATUS_DELETED;

	$_POST['movelast_less_days'] = isset($_POST['movelast_less_days']) && !empty($_POST['movelast_less']) ? (int) $_POST['movelast_less_days'] : 0;
	if ($_POST['movelast_less_days'] > 0)
		$clauses[] = 'AND last_updated >= ' . (time() - ($_POST['movelast_less_days'] * 86400));

	$_POST['movelast_more_days'] = isset($_POST['movelast_more_days']) && !empty($_POST['movelast_more']) ? (int) $_POST['movelast_more_days'] : 0;
	if ($_POST['movelast_more_days'] > 0)
		$clauses[] = 'AND last_updated < ' . (time() - ($_POST['movelast_more_days'] * 86400));

	// OK, let's start. How many tickets are there to move?
	if (empty($_SESSION['massdeptmove']))
	{
		$query = $smcFunc['db_query']('', '
			SELECT COUNT(*)
			FROM {db_prefix}helpdesk_tickets
			WHERE id_dept = {int:dept_from} ' . implode(' ', $clauses),
			array(
				'dept_from' => $_POST['id_dept_from'],
			)
		);
		list($count) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);

		if (!empty($count))
			$_SESSION['massdeptmove'] = $count;
		else
			$_GET['done'] = true;
	}

	// OK, so we know we're going to be doing some tickets, or do we?
	$_POST['tickets_done'] = isset($_POST['tickets_done']) ? (int) $_POST['tickets_done'] : 0;

	if (isset($_GET['done']) || $_POST['tickets_done'] >= $_SESSION['massdeptmove'])
	{
		unset($_SESSION['massdeptmove']);
		$context['sub_template'] = 'shd_admin_maint_massdeptmovedone';
		return;
	}

	// So, do this batch.
	$step_count = 10;
	$tickets = array();

	// We don't need to get particularly clever; whatever tickets we did in any previous batch, well, they will be gone by now.
	$query = $smcFunc['db_query']('', '
		SELECT id_ticket, subject
		FROM {db_prefix}helpdesk_tickets
		WHERE id_dept = {int:dept_from} ' . implode(' ', $clauses) . '
		ORDER BY id_ticket
		LIMIT {int:step}',
		array(
			'dept_from' => $_POST['id_dept_from'],
			'step' => $step_count,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$tickets[$row['id_ticket']] = $row['subject'];
	$smcFunc['db_free_result']($query);

	if (!empty($tickets))
	{
		// Get department ids.
		$query = $smcFunc['db_query']('', '
			SELECT id_dept, dept_name
			FROM {db_prefix}helpdesk_depts
			WHERE id_dept IN ({array_int:depts})',
			array(
				'depts' => array($_POST['id_dept_from'], $_POST['id_dept_to']),
			)
		);
		$depts = array();
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$depts[$row['id_dept']] = $row['dept_name'];
		$smcFunc['db_free_result']($query);

		// OK, we have the ticket ids. Now we'll move the set and log each one moved.
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET id_dept = {int:dept_to}
			WHERE id_ticket IN ({array_int:ids})',
			array(
				'dept_to' => $_POST['id_dept_to'],
				'ids' => array_keys($tickets),
			)
		);

		// This is the same every time.
		$log_params = array(
			'old_dept_id' => $_POST['id_dept_from'],
			'old_dept_name' => $depts[$_POST['id_dept_from']],
			'new_dept_id' => $_POST['id_dept_to'],
			'new_dept_name' => $depts[$_POST['id_dept_to']],
		);
		foreach ($tickets as $id => $subject)
		{
			$log_params['subject'] = $subject;
			$log_params['ticket'] = $id;
			shd_log_action('move_dept', $log_params);
		}

		shd_clear_active_tickets($_POST['id_dept_from']);
		shd_clear_active_tickets($_POST['id_dept_to']);

		$_POST['tickets_done'] += $step_count;
	}

	// Prepare to shove everything we need into the form so we can go again.
	$context['continue_countdown'] = 3;
	$context['continue_get_data'] = '?action=admin;area=helpdesk_maint;sa=massdeptmove;' . $context['session_var'] . '=' . $context['session_id'];
	$context['continue_post_data'] = '
		<input type="hidden" name="id_dept_from" value="' . $_POST['id_dept_from'] . '" />
		<input type="hidden" name="id_dept_to" value="' . $_POST['id_dept_to'] . '" />
		<input type="hidden" name="tickets_done" value="' . $_POST['tickets_done'] . '" />';
	if (!empty($_POST['moveopen']))
		$context['continue_post_data'] .= '
		<input type="hidden" name="moveclosed" value="' . $_POST['moveopen'] . '" />';
	if (!empty($_POST['moveclosed']))
		$context['continue_post_data'] .= '
		<input type="hidden" name="moveclosed" value="' . $_POST['moveclosed'] . '" />';
	if (!empty($_POST['movedeleted']))
		$context['continue_post_data'] .= '
		<input type="hidden" name="movedeleted" value="' . $_POST['movedeleted'] . '" />';
	if ($_POST['movelast_less_days'] > 0)
		$context['continue_post_data'] .= '
		<input type="hidden" name="movelast_less" value="1" />
		<input type="hidden" name="movelast_less_days" value="' . $_POST['movelast_less_days'] . '" />';
	if ($_POST['movelast_more_days'] > 0)
		$context['continue_post_data'] .= '
		<input type="hidden" name="movelast_more" value="1" />
		<input type="hidden" name="movelast_more_days" value="' . $_POST['movelast_more_days'] . '" />';

	$context['sub_template'] = 'not_done';
	$context['continue_percent'] = $_POST['tickets_done'] > $_SESSION['massdeptmove'] ? 100 : floor($_POST['tickets_done'] / $_SESSION['massdeptmove'] * 100);
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
			'pc' => 15,
		),
		array(
			'name' => 'deleted',
			'pc' => 20,
		),
		array(
			'name' => 'first_last',
			'pc' => 20,
		),
		array(
			'name' => 'status',
			'pc' => 15,
		),
		array(
			'name' => 'starter_updater',
			'pc' => 15,
		),
		array(
			'name' => 'invalid_dept',
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
	global $context, $smcFunc, $txt;

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

// Make sure the first and last messages on a ticket are correct.
function shd_maint_first_last()
{
	global $context, $smcFunc, $txt;

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

// Make sure the first and last posters on a ticket are correct.
function shd_maint_starter_updater()
{
	global $context, $smcFunc, $txt;

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
		SELECT id_ticket, id_member_started, id_member_updated
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
			SELECT hdt.id_ticket, hdtr_first.id_member AS id_member_started, hdtr_last.id_member AS id_member_updated
			FROM {db_prefix}helpdesk_tickets AS hdt
				LEFT JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_first ON (hdt.id_first_msg = hdtr_first.id_msg)
				LEFT JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_last ON (hdt.id_last_msg = hdtr_last.id_msg)
			WHERE hdt.id_ticket IN ({array_int:tickets})
			GROUP BY hdt.id_ticket',
			array(
				'tickets' => array_keys($tickets),
			)
		);
		$ticket_cache = array();
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$ticket_cache[$row['id_ticket']] = $row;
		$smcFunc['db_free_result']($query);

		// OK so we now have the message ids for first/last message. Are they right?
		foreach ($ticket_cache as $id_ticket => $ticket_details)
			if ($ticket_cache[$id_ticket]['id_member_started'] != $tickets[$id_ticket]['id_member_started'] || $ticket_cache[$id_ticket]['id_member_updated'] != $tickets[$id_ticket]['id_member_updated'])
				$tickets_modify[$id_ticket] = $ticket_cache[$id_ticket];

		// Any to update?
		if (!empty($tickets_modify))
		{
			// Oh crap.
			foreach ($tickets_modify as $id_ticket => $columns)
			{
				$smcFunc['db_query']('', '
					UPDATE {db_prefix}helpdesk_tickets
					SET id_member_started = {int:id_member_started},
						id_member_updated = {int:id_member_updated}
					WHERE id_ticket = {int:id_ticket}',
					$columns
				);
			}
			$_SESSION['shd_maint']['starter_updater'] = count($tickets_modify);
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
		$context['substep_title'] = $txt['shd_admin_maint_findrepair_starterupdater'];
		$context['substep_continue_percent'] = round(100 * $_REQUEST['start'] / $ticket_count);
	}
}

// Make sure all open tickets have the right statuses.
function shd_maint_status()
{
	global $context, $smcFunc, $txt;

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

// Make sure all tickets are in a valid department, creating a new one if necessary.
function shd_maint_invalid_dept()
{
	global $context, $smcFunc, $txt;

	$tickets = array();
	$query = $smcFunc['db_query']('', '
		SELECT hdt.id_ticket
		FROM {db_prefix}helpdesk_tickets AS hdt
			LEFT JOIN {db_prefix}helpdesk_depts AS hdd ON (hdt.id_dept = hdd.id_dept)
		WHERE hdd.id_dept IS NULL');

	while ($row = $smcFunc['db_fetch_assoc']($query))
		$tickets[] = $row['id_ticket'];
	$smcFunc['db_free_result']($query);

	if (!empty($tickets))
	{
		// Uh-oh. OK, so let's make a new department.
		// First, we get the last dept_order.
		$query = $smcFunc['db_query']('', '
			SELECT MAX(dept_order)
			FROM {db_prefix}helpdesk_depts');
		list($dept_order) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);

		$dept_order++;

		$smcFunc['db_insert']('replace',
			'{db_prefix}helpdesk_depts',
			array(
				'dept_name' => 'string', 'description' => 'string', 'board_cat' => 'int', 'before_after' => 'int', 'dept_order' => 'int',
			),
			array(
				$txt['shd_admin_recovered_dept'], $txt['shd_admin_recovered_dept_desc'], 0, 0, $dept_order,
			),
			array('id_dept')
		);

		$last_dept = $smcFunc['db_insert_id']('{db_prefix}hepldesk_depts', 'id_dept');
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET id_dept = {int:new_dept}
			WHERE id_ticket IN ({array_int:tickets})',
			array(
				'new_dept' => $last_dept,
				'tickets' => $tickets,
			)
		);
		$_SESSION['shd_maint']['invalid_dept'] = count($tickets);
	}

	// This is a simple operation, no suboperation, so just tell it to go onto the next step.
	$context['continue_post_data'] .= '<input type="hidden" name="step" value="' . ($context['step'] + 1) . '" />';
}

// Make sure all SimpleDesk cache items are forcibly flushed.
function shd_maint_clean_cache()
{
	global $context;
	clean_cache();

	// Normally, we'd update $context['continue_post_data'] to indicate our next port of call. But here, we don't have to.
	redirectexit('action=admin;area=helpdesk_maint;sa=findrepair;done;' . $context['session_var'] . '=' . $context['session_id']);
}

?>