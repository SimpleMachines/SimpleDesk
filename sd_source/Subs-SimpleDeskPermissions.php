<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2019 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1 Beta 1                              *
* File Info: Subs-SimpleDeskPermissions.php                   *
**************************************************************/

/**
 *	This file handles the core permissions systems for SimpleDesk, including the permissions templates, loading and checking permissions.
 *
 *	@package subs
 *	@since 2.0
 */
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	This function stores the master list of permissions.
 *
 *	@since 2.0
*/
function shd_load_all_permission_sets()
{
	global $context, $modSettings;

	// We're actually going to display it in multiple columns, so break it down into groups
	$context['shd_permissions']['group_display'] = array(
		array(
			'general' => 'status.png',
			'posting' => 'log_newticket.png',
			'ticketactions' => 'assign.png',
			'deletion' => 'log_delete.png',
			'attachments' => 'attachments.png',
		),
		array(
			'email' => 'log_notify.png',
			'profile' => 'profile.png',
			'relationships' => 'relationships.png',
			'moderation' => 'modification.png',
		),
	);

	// Each item = array(bool has-own/any, permission category, image file in Themes/default/images/simpledesk/)
	$context['shd_permissions']['permission_list'] = array(
		'access_helpdesk' => array(false, 'general', ''), // These three won't have
		'shd_staff' => array(false, 'general', ''), // anything to display
		'admin_helpdesk' => array(false, 'general', ''), // because they'll be managed from parent roles instead
		'shd_view_ticket' => array(true, 'general', 'ticket.png'),
		'shd_view_ticket_private' => array(true, 'general', 'ticket_private.png'),
		'shd_view_closed' => array(true, 'general', 'log_resolve.png'),
		'shd_view_ip' => array(true, 'general', 'ip.png'),
		'shd_search' => array(false, 'general', 'search.png'),

		'shd_new_ticket' => array(false, 'posting', 'log_newticket.png'),
		'shd_edit_ticket' => array(true, 'posting', 'log_editticket.png'),
		'shd_reply_ticket' => array(true, 'posting', 'log_newreply.png'),
		'shd_edit_reply' => array(true, 'posting', 'log_editreply.png'),
		'shd_post_proxy' => array(false, 'posting', 'proxy.png'),
		'shd_override_cf' => array(false, 'posting', 'custom_fields.png'),

		'shd_resolve_ticket' => array(true, 'ticketactions', 'log_resolve.png'),
		'shd_unresolve_ticket' => array(true, 'ticketactions', 'log_unresolve.png'),
		'shd_view_ticket_logs' => array(true, 'ticketactions', 'log.png'),
		'shd_alter_urgency' => array(true, 'ticketactions', 'urgency.png'),
		'shd_alter_urgency_higher' => array(true, 'ticketactions', 'log_urgency_increase.png'),
		'shd_alter_privacy' => array(true, 'ticketactions', 'log_markprivate.png'),
		'shd_assign_ticket' => array(true, 'ticketactions', 'log_assign.png'),

		'shd_access_recyclebin' => array(false, 'deletion', 'access_recyclebin.png'),
		'shd_delete_ticket' => array(true, 'deletion', 'log_delete.png'),
		'shd_delete_reply' => array(true, 'deletion', 'log_delete_reply.png'),
		'shd_restore_ticket' => array(true, 'deletion', 'log_restore.png'),
		'shd_restore_reply' => array(true, 'deletion', 'log_restore_reply.png'),
		'shd_delete_recycling' => array(false, 'deletion', 'log_permadelete.png'),

		'shd_view_attachment' => array(false, 'attachments', 'attachments.png'),
		'shd_post_attachment' => array(false, 'attachments', 'attachments_add.png'),
		'shd_delete_attachment' => array(false, 'attachments', 'attachments_delete.png'),

		'shd_monitor_ticket' => array(true, 'email', 'log_notify.png'),
		'shd_ignore_ticket' => array(true, 'email', 'perm_deny.png'),
		'shd_singleton_email' => array(false, 'email', 'live.png'),
		'shd_silent_update' => array(false, 'email', 'silent_update.png'),

		'shd_view_profile' => array(true, 'profile', 'profile.png'),
		'shd_view_profile_log' => array(true, 'profile', 'log.png'),
		'shd_view_preferences' => array(true, 'profile', 'preferences.png'),

		'shd_view_relationships' => array(false, 'relationships', 'log_rel_linked.png'),
		'shd_create_relationships' => array(false, 'relationships', 'new_relationship.png'),
		'shd_delete_relationships' => array(false, 'relationships', 'log_rel_delete.png'),

		'shd_ticket_to_topic' => array(false, 'moderation', 'log_tickettotopic.png'),
		'shd_topic_to_ticket' => array(false, 'moderation', 'log_topictoticket.png'),
		'shd_move_dept' => array(true, 'moderation', 'log_move_dept.png'),
	);

	if (!empty($modSettings['shd_disable_tickettotopic']))
		unset($context['shd_permissions']['permission_list']['shd_ticket_to_topic'], $context['shd_permissions']['permission_list']['shd_topic_to_ticket']);

	// And go get the list of templates
	shd_load_role_templates();

	// Now engage any hooks.
	call_integration_hook('shd_hook_perms');
}

/**
 *	Provides a list of the known role/permission templates for the system.
 *
 *	@since 2.0
*/
function shd_load_role_templates()
{
	global $context, $modSettings;

	// UNDER PAIN OF DEATH
	// Do not add anything other than ROLEPERM_ALLOW rules here.
	$context['shd_permissions']['roles'] = array(
		ROLE_USER => array(
			'description' => 'shd_permrole_user',
			'icon' => 'user.png',
			'permissions' => array(
				'access_helpdesk' => ROLEPERM_ALLOW,
				'shd_view_ticket_own' => ROLEPERM_ALLOW,
				'shd_view_ticket_private_own' => ROLEPERM_ALLOW,
				'shd_view_closed_own' => ROLEPERM_ALLOW,
				'shd_new_ticket' => ROLEPERM_ALLOW,
				'shd_edit_ticket_own' => ROLEPERM_ALLOW,
				'shd_reply_ticket_own' => ROLEPERM_ALLOW,
				'shd_edit_reply_own' => ROLEPERM_ALLOW,
				'shd_view_attachment' => ROLEPERM_ALLOW,
				'shd_post_attachment' => ROLEPERM_ALLOW,
				'shd_resolve_ticket_own' => ROLEPERM_ALLOW,
				'shd_unresolve_ticket_own' => ROLEPERM_ALLOW,
				'shd_view_ticket_logs_own' => ROLEPERM_ALLOW,
				'shd_view_profile_own' => ROLEPERM_ALLOW,
				'shd_view_profile_log_own' => ROLEPERM_ALLOW,
				'shd_view_preferences_own' => ROLEPERM_ALLOW,
				'shd_view_relationships' => ROLEPERM_ALLOW,
				'shd_delete_ticket_own' => ROLEPERM_ALLOW,
				'shd_delete_reply_own' => ROLEPERM_ALLOW,
			),
		),
		ROLE_STAFF => array(
			'description' => 'shd_permrole_staff',
			'icon' => 'staff.png',
			'permissions' => array(
				'access_helpdesk' => ROLEPERM_ALLOW,
				'shd_staff' => ROLEPERM_ALLOW,
				'shd_view_ticket_any' => ROLEPERM_ALLOW,
				'shd_view_ticket_private_any' => ROLEPERM_ALLOW,
				'shd_view_closed_any' => ROLEPERM_ALLOW,
				'shd_view_ip_own' => ROLEPERM_ALLOW,
				'shd_search' => ROLEPERM_ALLOW,
				'shd_new_ticket' => ROLEPERM_ALLOW,
				'shd_edit_ticket_any' => ROLEPERM_ALLOW,
				'shd_reply_ticket_any' => ROLEPERM_ALLOW,
				'shd_edit_reply_any' => ROLEPERM_ALLOW,
				'shd_post_proxy' => ROLEPERM_ALLOW,
				'shd_monitor_ticket_any' => ROLEPERM_ALLOW,
				'shd_singleton_email' => ROLEPERM_ALLOW,
				'shd_ignore_ticket_own' => ROLEPERM_ALLOW,
				'shd_silent_update' => ROLEPERM_ALLOW,
				'shd_view_attachment' => ROLEPERM_ALLOW,
				'shd_post_attachment' => ROLEPERM_ALLOW,
				'shd_resolve_ticket_any' => ROLEPERM_ALLOW,
				'shd_unresolve_ticket_any' => ROLEPERM_ALLOW,
				'shd_view_ticket_logs_any' => ROLEPERM_ALLOW,
				'shd_alter_urgency_any' => ROLEPERM_ALLOW,
				'shd_alter_privacy_any' => ROLEPERM_ALLOW,
				'shd_assign_ticket_own' => ROLEPERM_ALLOW,
				'shd_view_profile_any' => ROLEPERM_ALLOW,
				'shd_view_profile_log_any' => ROLEPERM_ALLOW,
				'shd_view_preferences_own' => ROLEPERM_ALLOW,
				'shd_view_relationships' => ROLEPERM_ALLOW,
				'shd_create_relationships' => ROLEPERM_ALLOW,
				'shd_delete_relationships' => ROLEPERM_ALLOW,
				'shd_access_recyclebin' => ROLEPERM_ALLOW,
				'shd_delete_ticket_any' => ROLEPERM_ALLOW,
				'shd_delete_reply_any' => ROLEPERM_ALLOW,
				'shd_restore_ticket_any' => ROLEPERM_ALLOW,
				'shd_restore_reply_any' => ROLEPERM_ALLOW,
				'shd_ticket_to_topic' => ROLEPERM_ALLOW,
				'shd_topic_to_ticket' => ROLEPERM_ALLOW,
				'shd_move_dept_own' => ROLEPERM_ALLOW,
			),
		),
		ROLE_ADMIN => array(
			'description' => 'shd_permrole_admin',
			'icon' => 'admin.png',
			'permissions' => array(
				'access_helpdesk' => ROLEPERM_ALLOW,
				'shd_staff' => ROLEPERM_ALLOW,
				'admin_helpdesk' => ROLEPERM_ALLOW,
				'shd_view_ticket_any' => ROLEPERM_ALLOW,
				'shd_view_ticket_private_any' => ROLEPERM_ALLOW,
				'shd_view_closed_any' => ROLEPERM_ALLOW,
				'shd_view_ip_any' => ROLEPERM_ALLOW,
				'shd_search' => ROLEPERM_ALLOW,
				'shd_new_ticket' => ROLEPERM_ALLOW,
				'shd_edit_ticket_any' => ROLEPERM_ALLOW,
				'shd_reply_ticket_any' => ROLEPERM_ALLOW,
				'shd_edit_reply_any' => ROLEPERM_ALLOW,
				'shd_post_proxy' => ROLEPERM_ALLOW,
				'shd_override_cf' => ROLEPERM_ALLOW,
				'shd_monitor_ticket_any' => ROLEPERM_ALLOW,
				'shd_singleton_email' => ROLEPERM_ALLOW,
				'shd_ignore_ticket_any' => ROLEPERM_ALLOW,
				'shd_silent_update' => ROLEPERM_ALLOW,
				'shd_view_attachment' => ROLEPERM_ALLOW,
				'shd_post_attachment' => ROLEPERM_ALLOW,
				'shd_delete_attachment' => ROLEPERM_ALLOW,
				'shd_resolve_ticket_any' => ROLEPERM_ALLOW,
				'shd_unresolve_ticket_any' => ROLEPERM_ALLOW,
				'shd_view_ticket_logs_any' => ROLEPERM_ALLOW,
				'shd_alter_urgency_any' => ROLEPERM_ALLOW,
				'shd_alter_urgency_higher_any' => ROLEPERM_ALLOW,
				'shd_alter_privacy_any' => ROLEPERM_ALLOW,
				'shd_assign_ticket_any' => ROLEPERM_ALLOW,
				'shd_view_profile_any' => ROLEPERM_ALLOW,
				'shd_view_profile_log_any' => ROLEPERM_ALLOW,
				'shd_view_preferences_any' => ROLEPERM_ALLOW,
				'shd_view_relationships' => ROLEPERM_ALLOW,
				'shd_create_relationships' => ROLEPERM_ALLOW,
				'shd_delete_relationships' => ROLEPERM_ALLOW,
				'shd_access_recyclebin' => ROLEPERM_ALLOW,
				'shd_delete_ticket_any' => ROLEPERM_ALLOW,
				'shd_delete_reply_any' => ROLEPERM_ALLOW,
				'shd_restore_ticket_any' => ROLEPERM_ALLOW,
				'shd_restore_reply_any' => ROLEPERM_ALLOW,
				'shd_ticket_to_topic' => ROLEPERM_ALLOW,
				'shd_topic_to_ticket' => ROLEPERM_ALLOW,
				'shd_move_dept_any' => ROLEPERM_ALLOW,
			),
		),
	);

	call_integration_hook('shd_hook_permstemplate');
}

/**
 *	Defines user permissions, most importantly concerning ticket visibility
 *
 *	Populates specific parameters in $user_info, mostly to add {} abstract variables in $smcFunc['db_query'] data calls.
 *	The foremost one of these is {query_see_ticket}, an SQL clause constructed to ensure ticket visibility is maintained given the
 *	active user's permission set.
 *
 *	Prior to 1.1 this was in Subs-SimpleDesk.php
 *
 *	@see shd_db_query()
 *	@since 1.0
*/
function shd_load_user_perms()
{
	global $user_info, $context, $smcFunc, $modSettings;

	// OK, have we been here before? If we have, we're done.
	if (!empty($user_info['query_see_ticket']))
		return;

	// Right, we're loading the current user.
	shd_load_role_templates();

	// If they're a guest, bail; if they're not a forum admin (who can do anything), figure out what permissions they have
	if (!empty($user_info['is_guest']))
	{
		$user_info['shd_permissions'] = array();
		$user_info['query_see_ticket'] = '1=0';
		return;
	}
	elseif (empty($user_info['is_admin']))
	{
		$permissions_cache = 'shd_permissions_' . implode('-', $user_info['groups']);
		$perm_cache_time = 300;
		$temp = cache_get_data($permissions_cache, $perm_cache_time);

		if ($temp === null || (time() - $perm_cache_time > $modSettings['settings_updated']))
		{
			$role_permissions = array();

			// 1. Get all the roles that conceivably apply to this user.
			$query = $smcFunc['db_query']('', '
				SELECT hdrg.id_role, hdr.template
				FROM {db_prefix}helpdesk_role_groups AS hdrg
					INNER JOIN {db_prefix}helpdesk_roles AS hdr ON (hdrg.id_role = hdr.id_role)
				WHERE hdrg.id_group IN ({array_int:groups})',
				array(
					'groups' => $user_info['groups'],
				)
			);
			$roles = array();
			while ($row = $smcFunc['db_fetch_assoc']($query))
			{
				$role_permissions[$row['id_role']] = $context['shd_permissions']['roles'][$row['template']]['permissions'];
				$roles[$row['id_role']] = true;
			}
			$smcFunc['db_free_result']($query);

			// 1a. Get all the departments these roles are in.
			$depts = array();
			if (!empty($roles))
			{
				$query = $smcFunc['db_query']('', '
					SELECT id_role, id_dept
					FROM {db_prefix}helpdesk_dept_roles
					WHERE id_role IN ({array_int:roles})',
					array(
						'roles' => array_keys($roles),
					)
				);
				while ($row = $smcFunc['db_fetch_assoc']($query))
					$depts[$row['id_role']][] = $row['id_dept'];
				$smcFunc['db_free_result']($query);
			}

			$denied = array();

			// 2.1. Apply role specific rules against their parent templates
			if (!empty($depts))
			{
				$query = $smcFunc['db_query']('', '
					SELECT id_role, permission, add_type
					FROM {db_prefix}helpdesk_role_permissions
					WHERE id_role IN ({array_int:roles})',
					array(
						'roles' => array_keys($roles),
					)
				);
				while ($row = $smcFunc['db_fetch_assoc']($query))
					if ($row['add_type'] == ROLEPERM_DENY)
						$denied[$row['permission']] = true;
					else
						$role_permissions[$row['id_role']][$row['permission']] = $row['add_type'];
				$smcFunc['db_free_result']($query);
			}

			// 2.2 Having loaded all the roles, and applied role specific changes, fuse them all together
			$user_info['shd_permissions'] = array();
			if (!empty($depts) && !empty($role_permissions))
				foreach ($role_permissions as $role => $perm_list)
				{
					if (empty($depts[$role]))
						continue;

					foreach ($perm_list as $perm => $value)
						if ($value == ROLEPERM_ALLOW)
							$user_info['shd_permissions'][$perm] = isset($user_info['shd_permissions'][$perm]) ? array_merge($user_info['shd_permissions'][$perm], $depts[$role]) : $depts[$role];
				}

			// 2.3 Apply any deny restrictions
			if (!empty($denied))
				foreach ($denied as $perm => $value)
					if (isset($user_info['shd_permissions'][$perm]))
						unset($user_info['shd_permissions'][$perm]);

			cache_put_data($permissions_cache, $user_info['shd_permissions'], $perm_cache_time);
		}
		else
			$user_info['shd_permissions'] = $temp;
	}
	elseif ($user_info['is_admin'])
	{
		// Figure out what departments there are, because these are the departments in which they have any given permission.
		$context['shd_depts_list'] = array();
		$query = $smcFunc['db_query']('', '
			SELECT id_dept
			FROM {db_prefix}helpdesk_depts'
		);
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$context['shd_depts_list'][] = (int) $row['id_dept'];
		$smcFunc['db_free_result']($query);
	}

	$tickets_any_dept = shd_allowed_to('shd_view_ticket_any', false);
	$tickets_own_dept = shd_allowed_to('shd_view_ticket_own', false);
	if (!empty($tickets_any_dept) && !empty($tickets_own_dept))
		$tickets_own_dept = array_diff($tickets_any_dept, $tickets_own_dept);

	if ($user_info['is_admin'])
		$user_info['query_see_ticket'] = '1=1';
	elseif (!shd_allowed_to('access_helpdesk', 0))
		$user_info['query_see_ticket'] = '1=0'; // no point going any further if they can't access the helpdesk
	else
	{
		// What departments can we see private tickets in?
		$tickets_private_any_dept = shd_allowed_to('shd_view_ticket_private_any', false);
		$tickets_private_own_dept = shd_allowed_to('shd_view_ticket_private_own', false);

		$clauses = array();
		$privacy_clauses = array();

		// Departments where we can see anything. Requires the ability to see any ticket, plus any private.
		$tickets_any_private = array_intersect($tickets_any_dept, $tickets_private_any_dept);
		// Departments where we can see our own private tickets. Requires the ability to see any/own ticket in that department, plus own private.
		$tickets_own_private = array_intersect(array_merge($tickets_any_dept, $tickets_own_dept), $tickets_private_own_dept);
		// Departments where we can see any private tickets. Requires ability to see any ticket, then excludes matching private rule.
		$tickets_any_nonprivate = array_diff($tickets_any_dept, $tickets_any_private);
		// Departments where we can see our own non private tickets. Requires ability to see own ticket, excludes matching private rule.
		$tickets_own_nonprivate = array_diff($tickets_own_dept, $tickets_own_private);

		if (!empty($tickets_any_private)) // Depts where we can see private tickets, thus we don't need to check anything else for this part.
			$privacy_clauses[] = '(hdt.id_dept IN (' . implode(',', $tickets_any_private) . '))';
		if (!empty($tickets_own_private)) // Depts where we can see our own private tickets, so need to validate id_dept and id_member_started, but we can discount checking private here.
			$privacy_clauses[] = '(hdt.id_dept IN (' . implode(',', $tickets_own_private) . ') AND hdt.id_member_started = {int:user_info_id})';
		if (!empty($tickets_any_nonprivate)) // Depts where we can see nonprivate tickets. We need to validate privacy on these but that's it.
			$privacy_clauses[] = '(hdt.id_dept IN (' . implode(',', $tickets_any_nonprivate) . ') AND hdt.private = 0)';
		if (!empty($tickets_own_nonprivate)) // Depts where we can see our own nonprivate tickets. Validate id_dept, id_member_started and private.
			$privacy_clauses[] = '(hdt.id_dept IN (' . implode(',', $tickets_own_nonprivate) . ') AND hdt.private = 0 AND hdt.id_member_started = {int:user_info_id})';

		if (!empty($privacy_clauses))
			$clauses[] = implode(' OR ', $privacy_clauses);
		else
			$clauses[] = '1=0'; // Cannot access anything!

		// That's the core stuff done. We also need to ensure that closed tickets aren't visible either.
		$depts_closed_any = shd_allowed_to('shd_view_closed_any', false);
		$depts_closed_own = shd_allowed_to('shd_view_closed_own', false);
		$depts_closed_own = array_diff($depts_closed_own, $depts_closed_any);

		if (empty($depts_closed_any) && empty($depts_closed_own)) // No access at all. Disable all access to closed tickets.
			$clauses[] = 'hdt.status != 3';
		elseif (!empty($depts_closed_any) && empty($depts_closed_own)) // Only where we can access 'all closed' but not 'any of our own closed', e.g. admins
			$clauses[] = 'hdt.status != 3 OR (hdt.status = 3 AND hdt.id_dept IN (' . implode(',', $depts_closed_any) . '))';
		elseif (!empty($depts_closed_any) && !empty($depts_closed_own)) // So we have a mixture
			$clauses[] = 'hdt.status != 3 OR (hdt.status = 3 AND (hdt.id_dept IN (' . implode(',', $depts_closed_any) . ') OR (hdt.id_member_started = {int:user_info_id} AND hdt.id_dept IN (' . implode(',', $depts_closed_own) . '))))';
		elseif (empty($depts_closed_any) && !empty($depts_closed_own)) // We can't ever see 'any', but we can see our own
			$clauses[] = 'hdt.status != 3 OR (hdt.status = 3 AND hdt.id_dept IN (' . implode(',', $depts_closed_own) . ') AND hdt.id_member_started = {int:user_info_id})';

		// And finally, deleted tickets.
		$depts_deleted = shd_allowed_to('shd_access_recyclebin', false);
		if (empty($depts_deleted))
			$clauses[] = 'hdt.status != 6';
		else
			$clauses[] = 'hdt.status != 6 OR (hdt.status = 6 AND hdt.id_dept IN (' . implode(',', $depts_deleted) . '))';

		// Finally, assemble into $user_info.
		if (empty($clauses))
			$user_info['query_see_ticket'] = '1=0';
		else
			$user_info['query_see_ticket'] = '((' . implode(') AND (', $clauses) . '))';
	}
}

/**
 *	Determines if a user has a given permission within the system.
 *
 *	All SimpleDesk-specific permissions should be checked with this function. Any other permission check that is not specifically
 *	SimpleDesk-related should use allowedTo instead.
 *
 *	Prior to 1.0, this function was in Subs-SimpleDesk.php
 *
 *	@param mixed $permission A string or array of strings naming a permission or permissions that wish to be examined. Array format is only supported if $dept is not identical to false.
 *	@param int|bool $dept Normally, the department number which the permission is considered for. Can also be 0 to indicate whether the user has that permission in any department, or false to indicate that it should return a list of all the departments where that permission is available.
 *	@return bool True if any of the permission(s) outlined in $permission are true in the department(s) identified, or an array indicating the departments applicable for that permission if $dept is true boolean 'false'.
 *	@see shd_is_allowed_to()
 *	@since 1.0
*/
function shd_allowed_to($permission, $dept = 0)
{
	global $user_info, $context;

	if ($dept === false)
	{
		if (!empty($user_info['is_admin']))
			return $context['shd_depts_list'];
		else
			return empty($user_info['shd_permissions'][$permission]) ? array() : $user_info['shd_permissions'][$permission];
	}
	elseif ($dept == 0)
	{
		if (!empty($user_info['is_admin']))
			return true;
		elseif (!is_array($permission) && !empty($user_info['shd_permissions'][$permission]))
			return true;
		elseif (is_array($permission))
		{
			foreach ($permission as $perm)
				if (!empty($user_info['shd_permissions'][$perm]))
					return true;
			return false;
		}
		else
			return false;
	}
	else
	{
		if (!empty($user_info['is_admin']))
			return in_array($dept, $context['shd_depts_list']);

		$permission = is_array($permission) ? $permission : (array) $permission;
		foreach ($permission as $perm)
			if (!empty($user_info['shd_permissions'][$perm]) && in_array($dept, $user_info['shd_permissions'][$perm]))
				return true;
		return false;
	}
}

/**
 *	Enforces a user having a given permission and returning to a fatal error message if not.
 *
 *	All fatal-level SimpleDesk-specific permissions should be checked with this function. Any other permission check that is
 *	not specifically SimpleDesk-related should use isAllowedTo instead. Note that this is a void function because should this
 *	fail, SMF execution will be halted.
 *
 *	Prior to 1.0, this function was in Subs-SimpleDesk.php
 *
 *	@param mixed $permission A string or array of strings naming a permission or permissions that wish to be examined.
 *	@param int $dept A number indicating a department that the user must the permission in, or 0 for not caring which department provided the user has that permission in at least one department.
 *	@see shd_allowed_to()
 *	@since 1.0
*/
function shd_is_allowed_to($permission, $dept = 0)
{
	global $user_info, $txt;

	$permission = is_array($permission) ? $permission : (array) $permission;

	if (!shd_allowed_to($permission, $dept))
	{
		// Pick the last array entry as the permission shown as the error.
		$error_permission = array_shift($permission);

		// If they are a guest, show a login. (because the error might be gone if they do!)
		if ($user_info['is_guest'])
		{
			loadLanguage('Errors');
			is_not_guest($txt['cannot_' . $error_permission]);
		}

		// Clear the action because they aren't really doing that!
		$_GET['action'] = '';
		$_GET['board'] = '';
		$_GET['topic'] = '';
		writeLog(true);

		fatal_lang_error('cannot_' . $error_permission, false);

		// Getting this far is a really big problem, but let's try our best to prevent any cases...
		trigger_error('Hacking attempt...', E_USER_ERROR);
	}
}

/**
 *	Identifies all members who hold a given permission.
 *
 *	Currently lists of staff are generated by users who hold shd_staff permission. This function identifies those users through
 *	an internal lookup provided by SMF.
 *
 *	Prior to 1.0, this function was in Subs-SimpleDesk.php
 *
 *	@param mixed $permission A string naming a permission that members should hold.
 *	@param int $dept An integer indicating which department should be checked. If only confirmation that the user has the permission in at least one department without reference to any particular department, specify a department of 0.
 *	@return array Array of zero or more user ids who hold the stated permission.
 *	@since 1.0
*/
function shd_members_allowed_to($permission, $dept = 0)
{
	global $smcFunc;

	$member_groups = shd_groups_allowed_to($permission, $dept);

	$request = $smcFunc['db_query']('', '
		SELECT mem.id_member
		FROM {db_prefix}members AS mem
		WHERE (mem.id_group IN ({array_int:member_groups_allowed}) OR FIND_IN_SET({raw:member_group_allowed_implode}, mem.additional_groups) != 0)' . (empty($member_groups['denied']) ? '' : '
			AND NOT (mem.id_group IN ({array_int:member_groups_denied}) OR FIND_IN_SET({raw:member_group_denied_implode}, mem.additional_groups) != 0)'),
		array(
			'member_groups_allowed' => $member_groups['allowed'],
			'member_groups_denied' => $member_groups['denied'],
			'member_group_allowed_implode' => implode(', mem.additional_groups) != 0 OR FIND_IN_SET(', $member_groups['allowed']),
			'member_group_denied_implode' => implode(', mem.additional_groups) != 0 OR FIND_IN_SET(', $member_groups['denied']),
		)
	);
	$members = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$members[] = $row['id_member'];
	$smcFunc['db_free_result']($request);

	return $members;
}

/**
 *	Identifies which SMF membergroups hold a given permission.
 *
 *	@param string $permission A string naming a permission that members should hold.
 *	@param int $dept An integer indicating which department should be checked. If only confirmation that the user has the permission in at least one department without reference to any particular department, specify a department of 0.
 *	@return array Array of arrays containing 'allowed' and 'denied', each of which can contain ids for zero or more membergroups that hold the relevant permission.
 *	@since 2.0
*/
function shd_groups_allowed_to($permission, $dept = 0)
{
	global $smcFunc, $context;

	// Admins are allowed to do anything.
	$member_groups = array(
		'allowed' => array(1),
		'denied' => array(),
	);

	// 1. Figure out what templates contain this permission, if any
	$templates = array();
	$roles = array();
	foreach ($context['shd_permissions']['roles'] as $role => $role_details)
	{
		if (!empty($role_details['permissions'][$permission]))
			$templates[] = $role; // We don't have any ROLEPERM_DISALLOW or ROLEPERM_DENY in the templates, so simply checking presence is enough.
	}

	// 1a. Load any roles using these templates, gives us a foundation to work with.
	if (!empty($templates))
	{
		$query = $smcFunc['db_query']('', '
			SELECT hdr.id_role, hddr.id_dept
			FROM {db_prefix}helpdesk_roles AS hdr
				INNER JOIN {db_prefix}helpdesk_dept_roles AS hddr ON (hdr.id_role = hddr.id_role)
			WHERE template IN ({array_int:templates})' . (!empty($dept) ? '
				AND hddr.id_dept = {int:dept}' : ''),
			array(
				'templates' => $templates,
				'dept' => $dept,
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$roles[$row['id_role']] = ROLEPERM_ALLOW; // See above. We know we have the permission present if we find it here.
		$smcFunc['db_free_result']($query);
	}

	// 2. Figure out what roles add, remove or deny this permission, since they'll always override anything in the template
	$query = $smcFunc['db_query']('', '
		SELECT id_role, add_type
		FROM {db_prefix}helpdesk_role_permissions
		WHERE permission = {string:permission}',
		array(
			'permission' => $permission,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$roles[$row['id_role']] = $row['add_type'];
	$smcFunc['db_free_result']($query);

	// 3. Tie roles to groups
	if (!empty($roles))
	{
		$query = $smcFunc['db_query']('', '
			SELECT id_role, id_group
			FROM {db_prefix}helpdesk_role_groups
			WHERE id_role IN ({array_int:roles})',
			array(
				'roles' => array_keys($roles),
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($query))
			if ($roles[$row['id_role']] == ROLEPERM_ALLOW)
				$member_groups['allowed'][] = $row['id_group'];
			elseif ($roles[$row['id_role']] == ROLEPERM_DENY)
				$member_groups['denied'][] = $row['id_group'];
			// We don't have to do anything for ROLEPERM_DISALLOW
		$smcFunc['db_free_result']($query);
	}

	// 4. All done, just clear up groups and send 'em home
	$member_groups['allowed'] = array_diff($member_groups['allowed'], array_diff($member_groups['denied'], array(1)));

	return $member_groups;
}