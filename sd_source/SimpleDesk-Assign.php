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
 *	This file handles ticket assignments, both the user interface for the assignment page, plus
 *	actually assigning users to tickets. There are also helper functions here for that purpose.
 *
 *	@package source
 *	@since 1.0
*/

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Sets up the assignment UI and invokes the template.
 *
 *	This validates that the user can see the ticket in question initially, before determining the level of assignment that can be
 *	carried out.
 *
 *	Users who can assign any ticket cause a query to trigger to identify users who have shd_staff permission (and thus can be the
 *	target of assignment) and the template is loaded with a dropdown to provide this choice to the user.
 *
 *	Users who can only assign to themselves will at this point have the ticket assigned to them if it was unassigned before, or
 *	unassigned from them if they are able to assign tickets to themselves in the first place; if it was assigned to someone else,
 *	they will not have the option.
 *
 *	Access through action=helpdesk;sa=assign;ticket=x;sessvar=sessid before redirecting back to the ticket, or add ;home to the
 *	URL to have it redirect back to the home page (passed through to the form for {@link shd_assign2()}'s use too)
 *
 *	@see shd_assign2()
 *	@see shd_get_possible_assignees()
 *	@since 1.0
*/
function shd_assign()
{
	global $smcFunc, $context, $user_info, $sourcedir, $txt, $scripturl;

	checkSession('get');

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket');

	$context['shd_return_to'] = isset($_REQUEST['home']) ? 'home' : 'ticket';

	// Get ticket details - and kick it out if they shouldn't be able to see it.
	$query = shd_db_query('', '
		SELECT id_member_started, id_member_assigned, private, subject, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket} AND id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);

	$log_params = array();
	if ($row = $smcFunc['db_fetch_row']($query))
	{
		list($ticket_starter, $ticket_owner, $private, $subject, $dept) = $row;
		$log_params = array(
			'subject' => $subject,
			'ticket' => $context['ticket_id'],
		);
	}
	else
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_ticket');
	}

	if (shd_allowed_to('shd_assign_ticket_any', $dept)) // can regularly assign? If so, load up potential candidates and throw it at the template.
	{
		$members = shd_get_possible_assignees($private, $ticket_starter, $dept);

		if (!in_array($ticket_owner, $members)) // if for whatever reason the current assignee is not accessible staff, treat it as unassigned
			$ticket_owner = 0;

		if (!empty($members))
		{
			$query = shd_db_query('', '
				SELECT id_member, real_name
				FROM {db_prefix}members
				WHERE id_member IN ({array_int:members})
				ORDER BY real_name',
				array(
					'members' => $members,
				)
			);

			$members = array();

			while ($row = $smcFunc['db_fetch_assoc']($query))
				$members[$row['id_member']] = $row['real_name'];
		}

		if (empty($members))
			fatal_lang_error('shd_no_staff_assign');

		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
			'name' => $subject,
		);
		$context['linktree'][] = array(
			'name' => $txt['shd_ticket_assign_ticket'],
		);

		$context['member_list'] = array(0 => $txt['shd_unassigned']) + $members;
		$context['ticket_assigned'] = $ticket_owner;

		$context['page_title'] = $txt['shd_ticket_assign_ticket'];

		loadTemplate('sd_template/SimpleDesk-Assign');
		$context['sub_template'] = 'assign';
	}
	elseif (shd_allowed_to('shd_assign_ticket_own', $dept) && shd_allowed_to('shd_staff', $dept)) // can't just randomly assign (and must be staff), so look at if it's already assigned or not.
	{
		if ($ticket_owner == 0) // unassigned
		{
			$log_params += array(
				'user_id' => $user_info['id'],
				'user_name' => $user_info['name'],
			);
			shd_log_action('assign', $log_params);
			shd_commit_assignment($context['ticket_id'], $user_info['id']);
		}
		elseif ($ticket_owner == $user_info['id']) // assigned to self already, unassign it
		{
			shd_log_action('unassign', $log_params);
			shd_commit_assignment($context['ticket_id'], 0);
		}
		else // oops, assigned to somebody else
			fatal_lang_error('shd_cannot_assign_other', false);
	}
	else
		fatal_lang_error('shd_cannot_assign', false);
}

/**
 *	Handles the actual assignment form, validates it and carries it out.
 *
 *	Primarily this is just about receiving the form, making the same checks that {@link shd_assign()} does and then
 *	logging the action before passing over to {@link shd_commit_assignment()} to actually assign the ticket.
 *
 *	@see shd_assign()
 *	@see shd_commit_assignment()
 *	@since 1.0
*/
function shd_assign2()
{
	global $context, $smcFunc, $user_info, $sourcedir;

	checkSession();
	checkSubmitOnce('check');

	if (empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket');

	$context['shd_return_to'] = isset($_REQUEST['home']) ? 'home' : 'ticket';

	$assignee = isset($_REQUEST['to_user']) ? (int) $_REQUEST['to_user'] : 0;

	// Get ticket details - and kick it out if they shouldn't be able to see it.
	$query = shd_db_query('', '
		SELECT id_member_started, id_member_assigned, private, subject, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket} AND id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);

	$log_params = array();

	if ($row = $smcFunc['db_fetch_row']($query))
	{
		list($ticket_starter, $ticket_owner, $private, $subject, $dept) = $row;

		// The core details that we'll be logging
		$log_params = array(
			'subject' => $subject,
			'ticket' => $context['ticket_id'],
		);
	}
	else
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_ticket');
	}

	// Just in case, are they cancelling?
	if (isset($_REQUEST['cancel']))
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);

	if (shd_allowed_to('shd_assign_ticket_any', $dept)) // can regularly assign? If so, see if our requested member is staff and can see the ticket
	{
		if ($assignee == 0) // can always unassign a ticket
		{
			shd_log_action('unassign', $log_params);
			shd_commit_assignment($context['ticket_id'], 0);
		}
		else
		{
			$members = shd_get_possible_assignees($private, $ticket_starter, $dept);

			if (in_array($assignee, $members)) // can only assign a ticket to a member if they're on Santa's good list
			{
				global $user_profile;
				loadMemberData($assignee, false, 'minimal');
				$log_params += array(
					'user_id' => $assignee,
					'user_name' => $user_profile[$assignee]['real_name'],
				);
				shd_log_action('assign', $log_params);
				shd_commit_assignment($context['ticket_id'], $assignee);
			}
			else
				fatal_lang_error('shd_assigned_not_permitted', false);
		}
	}
	elseif (shd_allowed_to('shd_assign_ticket_own', $dept) && shd_allowed_to('shd_staff', $dept)) // can't just randomly assign (and must be staff), so look at if it's already assigned or not.
	{
		if ($ticket_owner == 0) // unassigned
		{
			$log_params += array(
				'user_id' => $user_info['id'],
				'user_name' => $user_info['name'],
			);
			shd_log_action('assign', $log_params);
			shd_commit_assignment($context['ticket_id'], $user_info['id']);
		}
		elseif ($ticket_starter == $user_info['id']) // assigned to self already, unassign it
		{
			shd_log_action('unassign', $log_params);
			shd_commit_assignment($context['ticket_id'], 0);
		}
		else // oops, assigned to somebody else
			fatal_lang_error('shd_cannot_assign_other', false);
	}
	else
		fatal_lang_error('shd_cannot_assign', false);
}

/**
 *	Actually commits a ticket assignment to the database.
 *
 *	This function sets up the relevant options before handing over to shd_modify_ticket_post() which is the preferred way to modify
 *	tickets generally. No permissions check is performed here.
 *
 *	Relies on $context['shd_return_to'] to have been set, defaults to 'ticket' to return to ticket, otherwise return to home page
 *	on value of 'home'.
 *
 *	@param int $ticket Ticket id number, assumed to exist.
 *	@param int $assignment User id of the user to which this ticket will be assigned; can be 0 to unassign a ticket
 *
 *	@see shd_assign()
 *	@see shd_assign2()
*/
function shd_commit_assignment($ticket, $assignment, $is_ajax = false)
{
	global $smcFunc, $sourcedir, $context, $modSettings;

	require($sourcedir . '/sd_source/Subs-SimpleDeskPost.php');

	$msgOptions = array();
	$posterOptions = array();
	$ticketOptions = array(
		'id' => $context['ticket_id'],
		'assigned' => $assignment,
	);

	// Int hooks - after we've set everything up but before we actually press the button
	call_integration_hook('shd_hook_assign', array(&$ticket, &$assignment));

	shd_modify_ticket_post($msgOptions, $ticketOptions, $posterOptions);

	// Handle notifications
	require_once($sourcedir . '/sd_source/SimpleDesk-Notifications.php');
	shd_notifications_notify_assign($ticket, $assignment);

	// If we're doing it AJAXively, we just want this to do the job and then go back to AJAX workflow.
	if ($is_ajax)
		return;

	if (!empty($context['shd_return_to']) && $context['shd_return_to'] == 'home')
		redirectexit($context['shd_home']);
	else
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $ticket);
}

/**
 *	Return a list of possible users that can be assigned a ticket.
 *
 *	This function centralises who a ticket can be assigned to. Currently this is:
 *	- user with shd_staff permission
 *	- can see "any" ticket (not just their own)
 *	- additionally, if the ticket is private, the user must also be able to see 'any' private ticket.
 *	- additionally, check whether user is staff + ticket starter, and then whether we should block them from being assigned
 *	- (since 1.1) additionally if we have set the option, which users are true admins, and if so, remove them from the list too
 *
 *	@param bool $private Whether the ticket in question is private or not.
 *	@param int $ticket_owner User id of the ticket owner
 *	@param int $dept The department of the ticket, used for establishing permissions.
 *
 *	@return array An indexed array of member ids that this ticket could be assigned to.
 *	@see shd_assign()
 *	@see shd_assign2()
 *	@since 1.0
*/
function shd_get_possible_assignees($private = false, $ticket_owner = 0, $dept = -1)
{
	global $context, $smcFunc, $modSettings;

	// people who can handle a ticket
	$staff = shd_members_allowed_to('shd_staff', $dept);

	// is it private, if so, remove that list
	if ((bool) $private == true)
	{
		$private = shd_members_allowed_to('shd_view_ticket_private_any', $dept);
		$staff = array_intersect($staff, $private);
	}

	// What about admins? We ignoring them? Note we're talking about *real* admins who implicitly have every permission, not any homebrew
	if (!empty($modSettings['shd_admins_not_assignable']))
	{
		$query = $smcFunc['db_query']('', '
			SELECT id_member
			FROM {db_prefix}members
			WHERE id_group = 1
				OR FIND_IN_SET(1, additional_groups)',
			array()
		);

		$admins = array();
		while ($row = $smcFunc['db_fetch_row']($query))
			$admins[] = $row[0];

		$smcFunc['db_free_result']($query);
		$staff = array_diff($staff, $admins);
	}

	// can they actually see said ticket
	$visible = shd_members_allowed_to('shd_view_ticket_any', $dept);

	if (empty($modSettings['shd_staff_ticket_self'])) // by default, staff members can't be assigned a ticket if they started it
		$staff = array_diff($staff, array($ticket_owner));

	// spit back the list of staff members who can see any ticket (+private if dealt with)
	return array_intersect($staff, $visible);
}
?>