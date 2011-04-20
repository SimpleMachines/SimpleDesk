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

	$context['can_pm'] = empty($modSettings['shd_helpdesk_only']) || empty($modSettings['shd_disable_pm']);

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

		// We also want to be able to indicate whether the ticket starter will be able to see the message after.
		// Firstly, figure out what groups they're in, so we can establish that kind of thing.
		$groups = array();
		$depts = array();
		if (!empty($ticket_starter))
		{
			// Sadly, loadMemberData only fetches additional_groups in profile mode, which also triggers other queries. We're better just getting it ourselves.
			$query = $smcFunc['db_query']('', '
				SELECT id_group, additional_groups
				FROM {db_prefix}members
				WHERE id_member = {int:member}',
				array(
					'member' => $ticket_starter,
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
			$context['visible_move_dept'] = '<span class="error">' . $txt['shd_user_no_hd_access'] . '</span>'; // They can't see it.
		elseif (count($context['dept_list']) == 1)
			$context['visible_move_dept'] = $txt['shd_user_helpdesk_access']; // They can see in, as far as we know there's only one department, so even if it's not true, pretend it is.
		else
			$context['visible_move_dept'] = (count($depts) == 1 ? $txt['shd_user_hd_access_dept_1'] : $txt['shd_user_hd_access_dept']) . implode(', ', $depts);

		$context['linktree'][] = array(
			'url' => $scripturl . '?' . $context['shd_home'] . ';dept=' . $context['current_dept'],
			'name' => $context['current_dept_name'],
		);
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
			'name' => $subject,
		);
		$context['linktree'][] = array(
			'name' => $txt['shd_ticket_move'],
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
	global $context, $smcFunc, $user_info, $sourcedir, $txt, $scripturl;

	checkSession();
	checkSubmitOnce('check');

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket', false);

	if ((isset($_POST['send_pm']) && (!isset($_POST['pm_content']) || trim($_POST['pm_content']) == '')) && (empty($modSettings['shd_helpdesk_only']) || empty($modSettings['shd_disable_pm'])))
		fatal_lang_error('shd_move_no_pm', false);

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

		// Now, notify the ticket starter if that's what we wanted to do.
		if (isset($_POST['send_pm']))
		{
			require_once($sourcedir . '/Subs-Post.php');

			$request = shd_db_query('pm_find_username', '
				SELECT id_member, real_name
				FROM {db_prefix}members
				WHERE id_member = {int:user}
				LIMIT 1',
				array(
					'user' => $ticket_starter,
				)
			);
			list ($userid,$username) = $smcFunc['db_fetch_row']($request);
			$smcFunc['db_free_result']($request);

			// Fix the content
			$replacements = array(
				'{user}' => $username,
				'{subject}' => $subject,
				'{current_dept}' => $context['current_dept_name'],
				'{new_dept}' => $dept_name,
				'{link}' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
			);
			$message = str_replace(array_keys($replacements), array_values($replacements), $_POST['pm_content']);

			$recipients = array(
				'to' => array($ticket_starter),
				'bcc' => array()
			);

			sendpm($recipients, $txt['shd_ticket_moved_subject'], un_htmlspecialchars($message));
		}

		if (!empty($context['shd_return_to']) && $context['shd_return_to'] == 'home')
			redirectexit($context['shd_home'] . ';dept=' . $new_dept);
		else
			redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
	}
	else
		fatal_lang_error('shd_no_perm_move_dept', false);
}

?>