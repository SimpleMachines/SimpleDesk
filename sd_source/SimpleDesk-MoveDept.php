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
 *	This file handles moving tickets between departments.
 *
 *	@package source
 *	@since 1.1
*/

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Sets up the ticket-moving UI and invokes the template.
 *
 *	This validates that the user can see the ticket in question initially, and at least one other department.
 *
 *	@see shd_movedept2()
 *	@since 1.1
*/
function shd_movedept()
{
	global $smcFunc, $context, $user_info, $sourcedir, $txt, $scripturl;

	checkSession('get');

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket', false);

	if (empty($context['shd_multi_dept']))
		fatal_lang_error('shd_cannot_move_dept', false);

	$context['shd_return_to'] = isset($_REQUEST['home']) ? 'home' : 'ticket';

	// Get ticket details - and kick it out if they shouldn't be able to see it.
	$query = shd_db_query('', '
		SELECT id_member_started, subject, hdt.id_dept, dept_name
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_depts AS hdd ON (hdt.id_dept = hdd.id_dept)
		WHERE {query_see_ticket} AND id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);

	$log_params = array();
	if ($row = $smcFunc['db_fetch_row']($query))
		list($ticket_starter, $subject, $context['current_dept'], $context['current_dept_name']) = $row;
	else
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_ticket');
	}

	$smcFunc['db_free_result']($query);

	if (shd_allowed_to('shd_move_dept_any', $context['current_dept']) || (shd_allowed_to('shd_move_dept_own', $context['current_dept']) && $ticket_starter == $user_info['id']))
	{
		$visible_depts = shd_allowed_to('access_helpdesk', false);
		$context['dept_list'] = array();
		$query = $smcFunc['db_query']('', '
			SELECT id_dept, dept_name
			FROM {db_prefix}helpdesk_depts
			WHERE id_dept IN ({array_int:depts})
			ORDER BY dept_order',
			array(
				'depts' => $visible_depts,
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$context['dept_list'][$row['id_dept']] = $row['dept_name'];
		$smcFunc['db_free_result']($query);

		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=main',
			'name' => $txt['shd_linktree_tickets'],
		);
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=main;dept=' . $context['current_dept'],
			'name' => $context['current_dept_name'],
		);
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
			'name' => $subject,
		);
		$context['linktree'][] = array(
			'name' => $txt['shd_ticket_assign_ticket'],
		);

		$context['page_title'] = $txt['shd_ticket_move'];

		loadTemplate('sd_template/SimpleDesk-MoveDept');
		$context['sub_template'] = 'movedept';
	}
	else
		fatal_lang_error('shd_no_perm_move_dept', false);
}

/**
 *	Handles the actual assignment form, validates it and carries it out.
 *
 *	Primarily this is just about receiving the form, making the same checks that {@link shd_movedept()} does and then
 *	logging the action before updating the database.
 *
 *	@see shd_movedept()
 *	@since 1.1
*/
function shd_movedept2()
{
	global $context, $smcFunc, $user_info, $sourcedir;

	checkSession();
	checkSubmitOnce('check');

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket', false);

	// Just in case, are they cancelling?
	if (isset($_REQUEST['cancel']))
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);

	if (empty($context['shd_multi_dept']))
		fatal_lang_error('shd_cannot_move_dept', false);

	$dest = isset($_REQUEST['to_dept']) ? (int) $_REQUEST['to_dept'] : 0;
	if (empty($dest) || !shd_allowed_to('access_helpdesk', $dest))
		fatal_lang_error('shd_cannot_move_dept', false);

	$context['shd_return_to'] = isset($_REQUEST['home']) ? 'home' : 'ticket';

	// Get ticket details - and kick it out if they shouldn't be able to see it.
	$query = shd_db_query('', '
		SELECT id_member_started, subject, hdt.id_dept, dept_name
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_depts AS hdd ON (hdt.id_dept = hdd.id_dept)
		WHERE {query_see_ticket} AND id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);

	$log_params = array();
	if ($row = $smcFunc['db_fetch_row']($query))
		list($ticket_starter, $subject, $context['current_dept'], $context['current_dept_name']) = $row;
	else
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_ticket');
	}

	$smcFunc['db_free_result']($query);

	if (shd_allowed_to('shd_move_dept_any', $context['current_dept']) || (shd_allowed_to('shd_move_dept_own', $context['current_dept']) && $ticket_starter == $user_info['id']))
	{
		// Find the new department. We've already established the user can see it, but we need its name.
		$query = $smcFunc['db_query']('', '
			SELECT id_dept, dept_name
			FROM {db_prefix}helpdesk_depts
			WHERE id_dept IN ({int:dest})',
			array(
				'dest' => $dest,
			)
		);
		list($new_dept, $dept_name) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);
		
		$log_params = array(
			'subject' => $subject,
			'ticket' => $context['ticket_id'],
			'old_dept_id' => $context['current_dept'],
			'old_dept_name' => $context['current_dept_name'],
			'new_dept_id' => $new_dept,
			'new_dept_name' => $dept_name,
		);
		shd_log_action('move_dept', $log_params);

		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET id_dept = {int:new_dept}
			WHERE id_ticket = {int:ticket}',
			array(
				'new_dept' => $new_dept,
				'ticket' => $context['ticket_id'],
			)
		);

		if (!empty($context['shd_return_to']) && $context['shd_return_to'] == 'home')
			redirectexit($context['shd_home'] . ';dept=' . $new_dept);
		else
			redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
	}
	else
		fatal_lang_error('shd_no_perm_move_dept', false);
}

?>