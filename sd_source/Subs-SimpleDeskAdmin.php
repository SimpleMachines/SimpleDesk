<?php
###############################################################
#          Simple Desk Project - www.simpledesk.net           #
###############################################################
#       An advanced help desk modification built on SMF       #
###############################################################
#                                                             #
#         * Copyright 2018 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 2.1 Beta 1                              #
# File Info: Subs-SimpleDeskAdmin.php                         #
###############################################################

/**
 *	This file deals with some of the items required by the helpdesk, but are primarily supporting
 *	functions; they're not the principle functions that drive the admin area.
 *
 *	@package subs
 *	@since 1.0
 */
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Load the items from the helpdesk action log
 *
 *	It is subject to given parameters (start, number of items, order/sorting), parses the language strings and adds the
 *	parameter information provided.
 *
 *	@param int $start Number of items into the log to start (for pagination). If -1, return everything. If nothing is given, fall back to 0, i.e the first log item.
 *	@param int $items_per_page How many items to load. Default to 10 items.
 *	@param string $sort SQL clause to state which column(s) to order the data by. By default it orders by log_time.
 *	@param string $order SQL clause to state whether the order is ascending or descending. Defaults to descending.
 *	@param string $clause An SQL fragment that forms a WHERE clause to limit log items, e.g. to load a specific ticket or specific member's log items.
 *
 *	@return array A hash array of the log items, with the auto-incremented id being the key:
 *	<ul>
 *	<li>id: Numeric identifier of the log item</li>
 *	<li>time: Formatted time of the event (as per usual for SMF, formatted for user's timezone)</li>
 *	<li>member: hash array:
 *		<ul>
 *			<li>id: Id of the user that committed the action</li>
 *			<li>name: Name of the user</li>
 *			<li>link: Link to the profile of the user that committed the action</li>
 *			<li>ip: User IP address recorded when the action was carried out</li>
 *			<li>group: Name of the group of the user (uses primary group, failing that post count group)</li>
 *		</ul>
 *	</li>
 *	<li>action: Raw name of the action (for use with collecting the image later)</li>
 *	<li>id_ticket: Numeric id of the ticket this action refers to</li>
 *	<li>id_msg: Numeric id of the individual reply this action refers to</li>
 *	<li>extra: Array of extra parameters for the log action</li>
 *	<li>action_text: Formatted text of the log item (parsed with parameters)</li>
 *	</ul>
 *
 *	@see shd_log_action()
 *	@see shd_count_action_log_entries()
 *	@since 1.0
*/
function shd_load_action_log_entries($start = 0, $items_per_page = 10, $sort = 'la.log_time', $order = 'DESC', $clause = '')
{
	global $smcFunc, $txt, $scripturl, $context, $user_info, $user_profile;

	// Load languages incase they aren't there (Read: ticket-specific logs)
	shd_load_language('sd_language/SimpleDeskAdmin');
	shd_load_language('sd_language/SimpleDeskLogAction');
	shd_load_language('sd_language/SimpleDeskNotifications');

	// We may have to exclude some items from this depending on who the user is or is not. Forum/HD admins can always see everything.
	$exclude = shd_action_log_exclusions();

	if (!empty($exclude))
	{
		if (empty($clause))
			$clause = 'la.action NOT IN ({array_string:exclude})';
		else
			$clause .= ' AND la.action NOT IN ({array_string:exclude})';
	}

	// Without further screaming and waving, fetch the actions.
	$request = shd_db_query('','
		SELECT la.id_action, la.log_time, la.ip, la.action, la.id_ticket, la.id_msg, la.extra,
		COALESCE(mem.id_member, 0) AS id_member, COALESCE(mem.real_name, {string:blank}) AS real_name, COALESCE(mg.group_name, {string:na}) AS group_name
		FROM {db_prefix}helpdesk_log_action AS la
			LEFT JOIN {db_prefix}members AS mem ON(mem.id_member = la.id_member)
			LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = CASE WHEN mem.id_group = {int:reg_group_id} THEN mem.id_post_group ELSE mem.id_group END)
		WHERE la.id_ticket != {int:no_ticket}' . (empty($clause) ? '' : '
			AND ' . $clause) . '
		ORDER BY ' . ($sort != '' ? '{raw:sort} {raw:order}' : 'la.log_time DESC') . '
		' . ($start != -1 ? 'LIMIT {int:start}, {int:items_per_page}' : ''),
		array(
			'no_ticket' => 0,
			'reg_group_id' => 0,
			'sort' => $sort,
			'start' => $start,
			'items_per_page' => $items_per_page,
			'order' => $order,
			'na' => $txt['not_applicable'],
			'blank' => '',
			'exclude' => $exclude,
		)
	);

	$actions = array();
	$notify_members = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		$row['extra'] = smf_json_decode($row['extra'], true);
		$row['extra'] = is_array($row['extra']) ? $row['extra'] : array();

		// Uhoh, we don't know who this is! Check it's not automatically by the system. If it is... mark it so.
		if (empty($row['id_member']))
		{
			if (isset($row['extra']['auto']) && $row['extra']['auto'] === true)
				$row['real_name'] = $txt['shd_helpdesk'];
			else
				$row['real_name'] = $txt['shd_admin_actionlog_unknown'];
		}

		$actions[$row['id_action']] = array(
			'id' => $row['id_action'],
			'time' => timeformat($row['log_time']),
			'member' => array(
				'id' => $row['id_member'],
				'name' => $row['real_name'],
				'link' => shd_profile_link($row['real_name'], $row['id_member']),
				'group' => $row['group_name'],
			),
			'action' => $row['action'],
			'id_ticket' => $row['id_ticket'],
			'id_msg' => $row['id_msg'],
			'extra' => $row['extra'],
			'action_text' => '',
			'action_icon' => 'log_' . $row['action'] . '.png',
			'can_remove' => empty($context['waittime']) ? false : ($row['log_time'] < $context['waittime']),
		);

		// We want to use a generic icon for custom fields changes.
		if (strpos($row['action'], 'cf_') === 0)
			$actions[$row['id_action']]['action_icon'] = 'log_cfchange.png';

		if (shd_allowed_to('shd_view_ip_any', 0) || ($row['id_member'] == $user_info['id'] && shd_allowed_to('shd_view_ip_own', 0)))
			$actions[$row['id_action']]['member']['ip'] = !empty($row['ip']) ? $row['ip'] : $txt['shd_admin_actionlog_unknown'];

		// Notifications require us to collate all the user ids as we go along.
		if ($row['action'] == 'notify' && !empty($row['extra']['emails']))
			foreach ($row['extra']['emails'] as $email_type => $recipients)
				if (!empty($recipients['u']))
					$notify_members = array_merge($notify_members, explode(',', $recipients['u']));
	}
	$smcFunc['db_free_result']($request);

	if (!empty($notify_members))
		loadMemberData(array_unique($notify_members));

	// Do some formatting of the action string.
	foreach ($actions as $k => $action)
	{
		if (empty($actions[$k]['action_text']))
			$actions[$k]['action_text'] = isset($txt['shd_log_' . $action['action']]) ? $txt['shd_log_' . $action['action']] : $action['action'];

		$actions[$k]['action_text'] = str_replace('{scripturl}', $scripturl, $actions[$k]['action_text']);
		$actions[$k]['action_text'] = str_replace('{shd_home}', $context['shd_home'], $actions[$k]['action_text']);

		if (isset($action['extra']['subject']))
		{
			$actions[$k]['action_text'] = str_replace('{ticket}', $actions[$k]['id_ticket'], $actions[$k]['action_text']);
			$actions[$k]['action_text'] = str_replace('{msg}', $actions[$k]['id_msg'], $actions[$k]['action_text']);

			if (isset($actions[$k]['extra']['subject']))
				$actions[$k]['action_text'] = str_replace('{subject}', $actions[$k]['extra']['subject'], $actions[$k]['action_text']);

			if (isset($actions[$k]['extra']['urgency']))
				$actions[$k]['action_text'] = str_replace('{urgency}', $txt['shd_urgency_' . $actions[$k]['extra']['urgency']], $actions[$k]['action_text']);
		}

		// Notifications are pretty tricky. So let's take care of all of it at once, and skip the rest if we're doing that.
		if ($action['action'] == 'notify' && isset($action['extra']['emails']))
		{
			// Because this could be a lot of people etc., we compact its storage heavily compared to a conventional smf_json_decode().
			// See shd_notify_users in SimpleDesk-Notifications.php for what this is.

			// Now we have all the usernames for this instance, let's go and build this entry.
			$content = '';
			foreach ($action['extra']['emails'] as $email_type => $recipients)
			{
				$this_content = '<br><a href="' . $scripturl . '?action=helpdesk;sa=emaillog;log=' . $action['id'] . ';template=' . $email_type . '" onclick="return reqWin(this.href);">' . $txt['template_log_notify_' . $email_type] . '</a> - ';

				$new_content = '';
				if (!empty($recipients['u']))
				{
					$first = true;
					$users = explode(',', $recipients['u']);
					$unknown_users = 0;
					foreach ($users as $user)
					{
						if (empty($user_profile[$user]))
						{
							$unknown_users++;
							continue;
						}

						$new_content .= ($first ? $txt['shd_log_notify_users'] . ': ' : ', ') . shd_profile_link($user_profile[$user]['real_name'], $user);
						$first = false;
					}
					if ($unknown_users > 0)
						$new_content .= ($first ? $txt['shd_log_notify_users'] . ': ' : ', ') . ($unknown_users == 1 ? $txt['shd_log_unknown_user_1'] : sprintf($txt['shd_log_unknown_user_n'], $unknown_users));
				}

				if (!empty($new_content))
					$content .= $this_content . $new_content;
			}
			if (!empty($content))
				$actions[$k]['action_text'] .= $txt['shd_log_notify_to'] . $content;
			continue;
		}

		if (isset($action['extra']['user_name']))
		{
			$actions[$k]['action_text'] = str_replace('{profile_link}', shd_profile_link($actions[$k]['extra']['user_name'], (isset($actions[$k]['extra']['user_id']) ? $actions[$k]['extra']['user_id'] : 0)), $actions[$k]['action_text']);
			$actions[$k]['action_text'] = str_replace('{user_name}', $actions[$k]['extra']['user_name'], $actions[$k]['action_text']);
		}
		if (isset($action['extra']['user_id']))
			$actions[$k]['action_text'] = str_replace('{user_id}', $actions[$k]['extra']['user_id'], $actions[$k]['action_text']);
		if (isset($actions[$k]['extra']['board_name']))
			$actions[$k]['action_text'] = str_replace('{board_name}', $actions[$k]['extra']['board_name'], $actions[$k]['action_text']);
		if (isset($actions[$k]['extra']['board_id']))
			$actions[$k]['action_text'] = str_replace('{board_id}', $actions[$k]['extra']['board_id'], $actions[$k]['action_text']);
		if (isset($action['extra']['othersubject']))
		{
			$actions[$k]['action_text'] = str_replace('{othersubject}', $actions[$k]['extra']['othersubject'], $actions[$k]['action_text']);
			$actions[$k]['action_text'] = str_replace('{otherticket}', $actions[$k]['extra']['otherticket'], $actions[$k]['action_text']);
		}

		if (isset($action['extra']['old_dept_id']))
		{
			$replace = array(
				'{old_dept_id}' => $action['extra']['old_dept_id'],
				'{old_dept_name}' => $action['extra']['old_dept_name'],
				'{new_dept_id}' => $action['extra']['new_dept_id'],
				'{new_dept_name}' => $action['extra']['new_dept_name'],
			);
			$actions[$k]['action_text'] = str_replace(array_keys($replace), array_values($replace), $actions[$k]['action_text']);
		}

		// Custom fields?
		if (isset($action['extra']['fieldname']))
		{
			if ($action['extra']['fieldtype'] == CFIELD_TYPE_CHECKBOX)
			{
				$action['extra']['oldvalue'] = !empty($action['extra']['oldvalue']) ? $txt['yes'] : $txt['no'];
				$action['extra']['newvalue'] = !empty($action['extra']['newvalue']) ? $txt['yes'] : $txt['no'];
			}
			elseif ($action['extra']['fieldtype'] == CFIELD_TYPE_RADIO || $action['extra']['fieldtype'] == CFIELD_TYPE_SELECT || $action['extra']['fieldtype'] == CFIELD_TYPE_MULTI)
			{
				if (empty($action['extra']['oldvalue']))
					$action['extra']['oldvalue'] = $txt['shd_none_selected'];
				if (empty($action['extra']['newvalue']))
					$action['extra']['newvalue'] = $txt['shd_none_selected'];
			}
			else
			{
				if (empty($action['extra']['oldvalue']))
					$action['extra']['oldvalue'] = $txt['shd_empty_item'];
				if (empty($action['extra']['newvalue']))
					$action['extra']['newvalue'] = $txt['shd_empty_item'];
			}
			$actions[$k]['action_text'] = str_replace('{fieldname}', $action['extra']['fieldname'], $actions[$k]['action_text']);
			$actions[$k]['action_text'] = str_replace('{oldvalue}', $action['extra']['oldvalue'], $actions[$k]['action_text']);
			$actions[$k]['action_text'] = str_replace('{newvalue}', $action['extra']['newvalue'], $actions[$k]['action_text']);
		}

		// This should be the last pair of ops - always.
		if (isset($action['extra']['att_added']))
			$actions[$k]['action_text'] .= ' ' . $txt['shd_logpart_att_added'] . ': ' . implode(', ', $action['extra']['att_added']);
		if (isset($action['extra']['att_removed']))
			$actions[$k]['action_text'] .= ' ' . $txt['shd_logpart_att_removed'] . ': ' . implode(', ', $action['extra']['att_removed']);

	}
	return $actions;
}

/**
 *	Returns the total number of items in the helpdesk log.
 *
 *	This function gets the total number of items logged in the helpdesk log, for the purposes of establishing the number of
 *	pages there should be in the page-index.
 *
 *	@param string $clause An SQL fragment that forms a WHERE clause to limit log items, e.g. to load a specific ticket or specific member's log items.
 *
 *	@return int Number of entries in the helpdesk action log table.
 *	@see shd_load_action_log_entries()
 *	@since 1.0
*/
function shd_count_action_log_entries($clause = '')
{
	global $smcFunc;

	$exclude = shd_action_log_exclusions();

	if (!empty($exclude))
	{
		if (empty($clause))
			$clause = 'la.action NOT IN ({array_string:exclude})';
		else
			$clause .= ' AND la.action NOT IN ({array_string:exclude})';
	}

	// Without further screaming and waving, fetch the actions.
	$request = shd_db_query('','
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_log_action AS la
		LEFT JOIN {db_prefix}members AS mem ON(mem.id_member = la.id_member)
		LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = CASE WHEN mem.id_group = {int:reg_group_id} THEN mem.id_post_group ELSE mem.id_group END)
		WHERE la.id_ticket != {int:no_ticket}' . (empty($clause) ? '' : '
			AND ' . $clause),
		array(
			'no_ticket' => 0,
			'reg_group_id' => 0,
			'exclude' => $exclude,
		)
	);

	list ($entry_count) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	return $entry_count;
}

function shd_action_log_exclusions()
{
	global $user_info;

	$exclude = array();

	if (!$user_info['is_admin'] && !shd_allowed_to('admin_helpdesk', 0))
	{
		// First, custom field changes only available to admins.
		$exclude = array('cf_tktchange_admin', 'cf_rplchange_admin', 'cf_tktchgdef_admin', 'cf_rplchgdef_admin');
		// Next, staff only things
		if (!shd_allowed_to('shd_staff', 0))
		{
			$exclude[] = 'cf_tktchange_staffadmin';
			$exclude[] = 'cf_rplchange_staffadmin';
			$exclude[] = 'cf_tktchgdef_staffadmin';
			$exclude[] = 'cf_rplchgdef_staffadmin';
		}
		else
		// Next, user only things (that staff can't see)
		{
			$exclude[] = 'cf_tktchange_useradmin';
			$exclude[] = 'cf_rplchange_useradmin';
			$exclude[] = 'cf_tktchgdef_useradmin';
			$exclude[] = 'cf_rplchgdef_useradmin';
		}

		// Can they see multiple departments? If not, exclude dept move notices too.
		$dept = shd_allowed_to('access_helpdesk', false);
		if (count($dept) == 1)
			$exclude[] = 'move_dept';
	}

	return $exclude;
}

/**
 *	Perform all the operations required for SimpleDesk to safely start operations inside the admin panel.
 *
 *	@param array &$admin_areas The full admin area array from SMF's Admin.php.
 *	@since 2.0
*/
function shd_admin_bootstrap(&$admin_areas)
{
	global $sourcedir, $modSettings, $txt, $context, $scripturl;

	// Load the main admin language files and any needed for SD plugins in the admin panel.
	require_once($sourcedir . '/sd_source/SimpleDesk-Admin.php');
	shd_load_language('sd_language/SimpleDeskAdmin');
	shd_load_plugin_files('hdadmin');
	shd_load_plugin_langfiles('hdadmin');

	// Now add the main SimpleDesk menu
	if (empty($modSettings['helpdesk_active']))
		return;

	// The helpdesk action log
	if (empty($modSettings['shd_disable_action_log']))
		$admin_areas['maintenance']['areas']['logs']['subsections']['helpdesklog'] = array($txt['shd_admin_helpdesklog'], 'admin_forum', 'url' => $scripturl . '?action=admin;area=helpdesk_info;sa=actionlog');

	// The main menu
	$admin_areas['helpdesk_info'] = array(
		'title' => $txt['shd_helpdesk'],
		'enabled' => allowedTo('admin_forum') || shd_allowed_to('admin_helpdesk', 0),
		'areas' => array(
			'helpdesk_info' => array(
				'label' => $txt['shd_admin_info'],
				'file' => 'sd_source/SimpleDesk-Admin.php',
				'icon' => 'shd_simpledesk',
				'function' => 'shd_admin_main',
				'subsections' => array(
					'main' => array($txt['shd_admin_info']),
					'actionlog' => array($txt['shd_admin_actionlog'], 'enabled' => empty($modSettings['shd_disable_action_log'])),
					'adminlog' => array($txt['shd_admin_adminlog'], 'enabled' => allowedTo('admin_forum')),
					'support' => array($txt['shd_admin_support']),
				),
			),
			'helpdesk_options' => array(
				'label' => $txt['shd_admin_options'],
				'file' => 'sd_source/SimpleDesk-Admin.php',
				'icon' => 'shd_options',
				'function' => 'shd_admin_main',
				'subsections' => array(
					'display' => array($txt['shd_admin_options_display']),
					'posting' => array($txt['shd_admin_options_posting']),
					'admin' => array($txt['shd_admin_options_admin']),
					'standalone' => array($txt['shd_admin_options_standalone']),
					'actionlog' => array($txt['shd_admin_options_actionlog']),
					'notifications' => array($txt['shd_admin_options_notifications']),
				),
			),
			'helpdesk_cannedreplies' => array(
				'label' => $txt['shd_admin_cannedreplies'],
				'file' => 'sd_source/SimpleDesk-Admin.php',
				'icon' => 'shd_cannedreplies',
				'function' => 'shd_admin_main',
				'subsections' => array(
				),
			),
			'helpdesk_customfield' => array(
				'label' => $txt['shd_admin_custom_fields'],
				'file' => 'sd_source/SimpleDesk-Admin.php',
				'icon' => 'shd_custom_fields',
				'function' => 'shd_admin_main',
				'subsections' => array(
				),
			),
			'helpdesk_depts' => array(
				'label' => $txt['shd_admin_departments'],
				'file' => 'sd_source/SimpleDesk-Admin.php',
				'icon' => 'shd_departments',
				'function' => 'shd_admin_main',
				'subsections' => array(
				),
			),
			'helpdesk_permissions' => array(
				'label' => $txt['shd_admin_permissions'],
				'file' => 'sd_source/SimpleDesk-Admin.php',
				'icon' => 'shd_permissions',
				'function' => 'shd_admin_main',
				'subsections' => array(
				),
			),
			'helpdesk_plugins' => array(
				'label' => $txt['shd_admin_plugins'],
				'file' => 'sd_source/SimpleDesk-Admin.php',
				'icon' => 'shd_plugins',
				'function' => 'shd_admin_main',
				'subsections' => array(
				),
			),
			'helpdesk_maint' => array(
				'label' => $txt['shd_admin_maint'],
				'file' => 'sd_source/SimpleDesk-Admin.php',
				'icon' => 'shd_maintenance',
				'function' => 'shd_admin_main',
				'subsections' => array(
					'main' => array($txt['shd_admin_maint']),
					'search' => array($txt['shd_maint_search_settings']),
				),
			),
		),
	);

	// Now engage any hooks.
	call_integration_hook('shd_hook_adminmenu', array(&$admin_areas));
}

/**
 *	Add the SimpleDesk option into the Core Features page inside the admin panel.
 *
 *	@param array &$core_features The array of Core Features as provided by ManageSettings.php
*/
function shd_admin_core_features(&$core_features)
{
	$temp = $core_features;
	$core_features = array();
	shd_load_language('sd_language/SimpleDeskAdmin');

	foreach ($temp as $k => $v)
	{
		// Insert it before the moderation log
		if ($k == 'ml')
			$core_features['shd'] = array('url' => 'action=admin;area=helpdesk_info');

		$core_features[$k] = $v;
	}
}

/**
 *	Perform any processing on SMF permissions subject to SimpleDesk options (namely removing permissions that make no sense in helpdesk-only mode)
 *
 *	All of the parameters are the normal variables provided by ManagePermissions.php to its integration hook.
 *	@since 2.0
 *	@param array &$permissionGroups The array of groups of permissions
 *	@param array &$permissionList The master list of permissions themselves
 *	@param array &$leftPermissionGroups The list of permission groups that are displayed on the left hand side of the screen in Classic Mode
 *	@param array &$hiddenPermissions A list of permissions to be hidden in the event of features being disabled
 *	@param array &$relabelPermissions A list of permissions to be renamed depending on features being active
*/
function shd_admin_smf_perms(&$permissionGroups, &$permissionList, &$leftPermissionGroups, &$hiddenPermissions, &$relabelPermissions)
{
	global $modSettings;

	if (!$modSettings['helpdesk_active'] || empty($modSettings['shd_helpdesk_only']))
		return;

	$perms_disable = array(
		'view_stats',
		'who_view',
		'search_posts',
		'karma_edit',
		'calendar_view',
		'calendar_post',
		'calendar_edit',
		'manage_boards',
		'manage_attachments',
		'manage_smileys',
		'edit_news',
		'access_mod_center',
		'moderate_forum',
		'send_mail',
		'issue_warning',
		'moderate_board',
		'approve_posts',
		'post_new',
		'post_unapproved_topics',
		'post_unapproved_replies',
		'post_reply',
		'merge_any',
		'split_any',
		'send_topic',
		'make_sticky',
		'move',
		'lock',
		'remove',
		'modify_replies',
		'delete_replies',
		'announce_topic',
		'delete',
		'modify',
		'report_any',
		'poll_view',
		'poll_vote',
		'poll_post',
		'poll_add',
		'poll_edit',
		'poll_lock',
		'poll_remove',
		'mark_any_notify',
		'mark_notify',
		'view_attachments',
		'post_unapproved_attachments',
		'post_attachment',
	);

	// that's the generic stuff, now for specific options
	if (!empty($modSettings['shd_disable_pm']))
	{
		$perms_disable[] = 'pm_read';
		$perms_disable[] = 'pm_send';
	}

	$hiddenPermissions = array_merge($hiddenPermissions, $perms_disable);
}

/**
 *	Intergrates into SMF's admin search.
 *
 *	@since 2.0
 *	@param array &$language_files language files to include.
 *	@param array &$include_files Files to load.
 *	@param array &$settings_search Settings to search.
*/
function shd_admin_search(&$language_files, &$include_files, &$settings_search)
{
	// Add in language files.
	shd_load_language('sd_language/SimpleDeskAdmin');

	$include_files = array_merge($include_files, array(
		'sd_source/SimpleDesk-Admin',
	));

	// Add SimpleDesk functions
	$settings_search = array_merge($settings_search, array(
		array('shd_modify_display_options', 'area=helpdesk_options;sa=display'),
		array('shd_modify_posting_options', 'area=helpdesk_options;sa=posting'),
		array('shd_modify_admin_options', 'area=helpdesk_options;sa=admin'),
		array('shd_modify_standalone_options', 'area=helpdesk_options;sa=standalone'),
		array('shd_modify_actionlog_options', 'area=helpdesk_options;sa=actionlog'),
		array('shd_modify_notifications_options', 'area=helpdesk_options;sa=notifications'),
	));

	// Our plugins may still use the old SHD hook.
	call_integration_hook('shd_hook_hdadminoptssrch', array(&$settings_search));
}

/**
 *	Removes an attachment when removed from SMF.
 *
 *	@since 2.1
 *	@param array &$attach All attachment IDs removed.
*/
function shd_remove_attachments($attach)
{
	global $smcFunc;

	// And now lastly to remove SimpleDesk attachments
	if (!empty($attach))
		$smcFunc['db_query']('', '
			DELETE FROM {db_prefix}helpdesk_attachments
			WHERE id_attach IN ({array_int:attachment_list})',
			array(
				'attachment_list' => $attach,
			)
		);
}

/**
 *	Converts helpdesk body length to match SMF's.
 *
 *	@since 2.1
 *	@param array &$body_type Either text or other.
*/
function shd_convert_msgbody($body_type)
{
	global $smcFunc;

	if ($body_type == 'text')
		$smcFunc['db_change_column']('{db_prefix}helpdesk_ticket_replies', 'body', array('type' => 'text'));
	else
		$smcFunc['db_change_column']('{db_prefix}helpdesk_ticket_replies', 'body', array('type' => 'mediumtext'));
}

/**
 *	Adds SimpleDesk language files into our search location.
 *
 *	@since 2.1
 *	@param array &$themes all the themes avaiable.
 *	@param array &$themes all the language directories avaiable.
*/
function shd_modifylanguages(&$themes, &$lang_dirs)
{
	global $settings;

	$themes['shd'] = array('name' => 'SimpleDesk', 'theme_dir' => $settings['default_theme_dir'] . '/languages/sd_language');
	$lang_dirs['shd'] = $settings['default_theme_dir'] . '/languages/sd_language';
	$themes['shd_plugins'] = array('name' => 'SimpleDesk Plugins', 'theme_dir' => $settings['default_theme_dir'] . '/languages/sd_plugins_lang');
	$lang_dirs['shd_plugins'] = $settings['default_theme_dir'] . '/languages/sd_plugins_lang';
}

/**
 *	Tracks a change to our options/configvars.
 *
 *	@since 2.1
 *	@param array $save_vars Passed before we do the updateDBSettings but after everything else is ready.
*/
function shd_admin_log_configvar($save_vars)
{
	global $smcFunc, $user_info, $modSettings;

	foreach ($save_vars as $var)
	{
		if (!isset($var[1]) || (!isset($_POST[$var[1]]) && $var[0] != 'check' && $var[0] != 'permissions' && ($var[0] != 'bbc' || !isset($_POST[$var[1] . '_enabledTags']))))
			continue;

		// Fix some data for proper testing.
		$newValue = isset($_POST[$var[1]]) ? $_POST[$var[1]] : null;
		// Checks are either on or off.
		if ($var[0] == 'check')
			$newValue = !empty($_POST[$var[1]]) ? '1' : '0';

		// Skip it if nothing was changed.
		if (isset($modSettings[$var[1]]) && $modSettings[$var[1]] == $newValue)
			continue;
		// Or if nothing exists.
		elseif (!isset($modSettings[$var[1]]) && empty($newValue))
			continue;

		// Log this.
		shd_admin_log('admin_change_option', array(
			'action' => 'update',
			'setting' => $var[1],
			'type' => $var[0],
			'from' => $modSettings[$var[1]],
			'to' => $newValue,
		));
	}
}

/**
 *	Logs a change in our admin area.
 *
 *	@since 2.1
 *	@param string $action The area this was from.
 *	@param array $extra An array of extra elements, in the following format.
 *		(required) string $action The action performed.
 *		(optional) string $setting During a setting update, this is the variable we changed.
 *		(optional) string $type The subaction peformed or during a setting update, int/string/etc.
 *		(optional) int $id The ID of the item we performed the action on.
 *		(optional) string $direction During a reorder up/down operation which way we moved.
 *		(optional) int $to The ID of the destination item used during copy/move operation.
 *		(optional) int $from The ID of the source item used during the copy/move operation
*/
function shd_admin_log($action, $extra)
{
	global $smcFunc, $user_info;

	$smcFunc['db_insert']('',
		'{db_prefix}helpdesk_log_action',
		array('log_time' => 'int', 'id_member' => 'int', 'ip' => 'string-16', 'action' => 'string', 'id_ticket' => 'int', 'id_msg' => 'int', 'extra' => 'string-65534',),
		array(time(), $user_info['id'], $user_info['ip'], $action, 0, 0, json_encode($extra)),
		array('id_action')
	);
}

/**
 *	Load the items from the helpdesk action log
 *
 *	It is subject to given parameters (start, number of items, order/sorting), parses the language strings and adds the
 *	parameter information provided.
 *
 *	@param int $start Number of items into the log to start (for pagination). If -1, return everything. If nothing is given, fall back to 0, i.e the first log item.
 *	@param int $items_per_page How many items to load. Default to 10 items.
 *	@param string $sort SQL clause to state which column(s) to order the data by. By default it orders by log_time.
 *	@param string $order SQL clause to state whether the order is ascending or descending. Defaults to descending.
 *	@param string $clause An SQL fragment that forms a WHERE clause to limit log items, e.g. to load a specific ticket or specific member's log items.
 *
 *	@return array A hash array of the log items, with the auto-incremented id being the key:
 *	<ul>
 *	<li>id: Numeric identifier of the log item</li>
 *	<li>time: Formatted time of the event (as per usual for SMF, formatted for user's timezone)</li>
 *	<li>member: hash array:
 *		<ul>
 *			<li>id: Id of the user that committed the action</li>
 *			<li>name: Name of the user</li>
 *			<li>link: Link to the profile of the user that committed the action</li>
 *			<li>ip: User IP address recorded when the action was carried out</li>
 *			<li>group: Name of the group of the user (uses primary group, failing that post count group)</li>
 *		</ul>
 *	</li>
 *	<li>action: Raw name of the action (for use with collecting the image later)</li>
 *	<li>id_ticket: Numeric id of the ticket this action refers to</li>
 *	<li>id_msg: Numeric id of the individual reply this action refers to</li>
 *	<li>extra: Array of extra parameters for the log action</li>
 *	<li>action_text: Formatted text of the log item (parsed with parameters)</li>
 *	</ul>
 *
 *	@see shd_log_action()
 *	@see shd_count_action_log_entries()
 *	@since 1.0
*/
function shd_load_admin_log_entries($start = 0, $items_per_page = 10, $sort = 'la.log_time', $order = 'DESC', $clause = '')
{
	global $smcFunc, $txt, $scripturl, $context, $user_info, $user_profile;

	// Load languages incase they aren't there (Read: ticket-specific logs)
	shd_load_language('sd_language/SimpleDeskAdmin');
	shd_load_language('sd_language/SimpleDeskLogAction');
	shd_load_language('sd_language/SimpleDeskNotifications');

	$request = shd_db_query('','
		SELECT la.id_action, la.log_time, la.ip, la.action, la.extra,
		COALESCE(mem.id_member, 0) AS id_member, COALESCE(mem.real_name, {string:blank}) AS real_name, COALESCE(mg.group_name, {string:na}) AS group_name
		FROM {db_prefix}helpdesk_log_action AS la
			LEFT JOIN {db_prefix}members AS mem ON(mem.id_member = la.id_member)
			LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = CASE WHEN mem.id_group = {int:reg_group_id} THEN mem.id_post_group ELSE mem.id_group END)
		WHERE la.id_ticket = {int:no_ticket}
		ORDER BY ' . ($sort != '' ? '{raw:sort} {raw:order}' : 'la.log_time DESC') . '
		' . ($start != -1 ? 'LIMIT {int:start}, {int:items_per_page}' : ''),
		array(
			'no_ticket' => 0,
			'reg_group_id' => 0,
			'sort' => $sort,
			'start' => $start,
			'items_per_page' => $items_per_page,
			'order' => $order,
			'na' => $txt['not_applicable'],
			'blank' => '',
		)
	);

	$actions = array();
	$ids = array(
		'canned_cat' => array(),
		'depts' => array(),
		'canned_reply' => array(),
		'custom_field' => array(),
		'members' => array(),
		'permissions' => array(),
	);
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		$row['extra'] = json_decode($row['extra'], true);
		$row['extra'] = is_array($row['extra']) ? $row['extra'] : array();

		// Uhoh, we don't know who this is! Check it's not automatically by the system. If it is... mark it so.
		if (empty($row['id_member']))
		{
			if (isset($row['extra']['auto']) && $row['extra']['auto'] === true)
				$row['real_name'] = $txt['shd_helpdesk'];
			else
				$row['real_name'] = $txt['shd_admin_actionlog_unknown'];
		}

		$actions[$row['id_action']] = array(
			'id' => $row['id_action'],
			'time' => timeformat($row['log_time']),
			'member' => array(
				'id' => $row['id_member'],
				'name' => $row['real_name'],
				'link' => shd_profile_link($row['real_name'], $row['id_member']),
				'group' => $row['group_name'],
				'ip' => !empty($row['ip']) ? $row['ip'] : $txt['shd_admin_actionlog_unknown'],
			),
			'action' => $row['action'],
			'type' => isset($row['extra']['type']) ? $row['extra']['type'] : '',
			'extra' => $row['extra'],
			'action_text' => '',
			'can_remove' => empty($context['waittime']) ? false : ($row['log_time'] < $context['waittime']),
		);

		// Load these up so we can find them later, it looks bad, but is actually simple.
		if ($row['action'] == 'admin_canned' && !empty($row['id']) && in_array($row['type'], array('cat_move', 'cat_delete', 'cat_add', 'cat_update')))
		{
			if (!isset($ids['canned_cat'][$row['extra']['id']]))
				$ids['canned_cat'][$row['extra']['id']] = array();
			$ids['canned_cat'][$row['extra']['id']][$row['id_action']] = 'id';
		}
		elseif ($row['action'] == 'admin_canned' && !empty($row['id']) && in_array($row['type'], array('reply_move', 'reply_delete', 'reply_add', 'reply_update')))
		{
			if (!isset($ids['canned_reply'][$row['extra']['id']]))
				$ids['canned_reply'][$row['extra']['id']] = array();
			$ids['canned_reply'][$row['extra']['id']][$row['id_action']] = 'id';
		}
		elseif ($row['action'] == 'admin_dept')
		{
			if (!isset($ids['depts'][$row['extra']['id']]))
				$ids['depts'][$row['extra']['id']] = array();
			$ids['depts'][$row['extra']['id']][$row['id_action']] = 'id';
		}
		elseif ($row['action'] == 'admin_customfield')
		{
			if (!isset($row['extra']['id']))
				continue;

			if (!isset($ids['custom_field'][$row['extra']['id']]))
				$ids['custom_field'][$row['extra']['id']] = array();
			$ids['custom_field'][$row['extra']['id']][$row['id_action']] = 'id';
		}
		elseif ($row['action'] == 'admin_maint')
		{
			if ($row['extra']['action'] == 'move_dept')
			{
				if (!isset($ids['depts'][$row['extra']['to']]))
					$ids['depts'][$row['extra']['to']] = array();
				$ids['depts'][$row['extra']['to']][$row['id_action']] = 'to';
				if (!isset($ids['depts'][$row['extra']['from']]))
					$ids['depts'][$row['extra']['from']] = array();
				$ids['depts'][$row['extra']['from']][$row['id_action']] = 'from';
			}
			else
			{
				if (!empty($row['extra']['to']))
				{
					if (!isset($ids['members'][$row['extra']['to']]))
						$ids['members'][$row['extra']['to']] = array();
					$ids['members'][$row['extra']['to']][$row['id_action']] = 'to';
				}
				if (!empty($row['extra']['from']))
				{
					if (!isset($ids['members'][$row['extra']['from']]))
						$ids['members'][$row['extra']['from']] = array();
					$ids['members'][$row['extra']['from']][$row['id_action']] = 'from';
				}
			}
		}
		elseif ($row['action'] == 'admin_permissions')
		{
			if (!empty($row['extra']['id']))
			{
				if (!isset($ids['permissions'][$row['extra']['id']]))
					$ids['permissions'][$row['extra']['id']] = array();
				$ids['permissions'][$row['extra']['id']][$row['id_action']] = 'id';
			}
			if (!empty($row['extra']['to']))
			{
				if (!isset($ids['permissions'][$row['extra']['to']]))
					$ids['permissions'][$row['extra']['to']] = array();
				$ids['permissions'][$row['extra']['to']][$row['id_action']] = 'to';
			}
			if (!empty($row['extra']['from']))
			{
				if (!isset($ids['permissions'][$row['extra']['from']]))
					$ids['permissions'][$row['extra']['from']] = array();
				$ids['permissions'][$row['extra']['from']][$row['id_action']] = 'from';
			}
		}
	}
	$smcFunc['db_free_result']($request);

	// Now lets try to find stuff.
	if (!empty($ids['canned_cat']))
	{
		$request = shd_db_query('','
			SELECT id_cat AS id, cat_name AS name
			FROM {db_prefix}helpdesk_cannedreplies_cats
			WHERE id_cat IN ({array_int:cats})',
			array(
				'cats' => array_keys($ids['canned_cat']),
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($request))
			foreach ($ids['canned_cat'][$row['id']] as $id_action => $type)
				if ($type == 'id')
					$actions[$id_action]['id_name'] = $row['name'];
		$smcFunc['db_free_result']($request);
	}
	if (!empty($ids['canned_reply']))
	{
		$request = shd_db_query('','
			SELECT id_reply AS id, title AS name
			FROM {db_prefix}helpdesk_cannedreplies
			WHERE id_reply IN ({array_int:replys})',
			array(
				'replys' => array_keys($ids['canned_reply']),
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($request))
			foreach ($ids['canned_reply'][$row['id']] as $id_action => $type)
				if ($type == 'id')
					$actions[$id_action]['id_name'] = $row['name'];
		$smcFunc['db_free_result']($request);
	}
	if (!empty($ids['custom_field']))
	{
		// We do this as we just want the name really.
		$request = shd_db_query('','
			SELECT id_field AS id, field_name AS name
			FROM {db_prefix}helpdesk_custom_fields
			WHERE id_field IN ({array_int:custom_fields})',
			array(
				'custom_fields' => array_keys($ids['custom_field']),
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($request))
			foreach ($ids['custom_field'][$row['id']] as $id_action => $type)
				if ($type == 'id')
					$actions[$id_action]['id_name'] = $row['name'];
		$smcFunc['db_free_result']($request);
	}
	if (!empty($ids['depts']))
	{
		// We do this as we just want the name really.
		$request = shd_db_query('','
			SELECT id_dept AS id, dept_name AS name
			FROM {db_prefix}helpdesk_depts
			WHERE id_dept IN ({array_int:depts})',
			array(
				'depts' => array_keys($ids['depts']),
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($request))
			foreach ($ids['depts'][$row['id']] as $id_action => $type)
				$actions[$id_action][$type == 'id' ? 'id_name' : ($type == 'to' ? 'to_name' : 'from_name')] = $row['name'];
		$smcFunc['db_free_result']($request);
	}
	if (!empty($ids['members']))
	{
		$request = shd_db_query('','
			SELECT id_member AS id, IFNULL(real_name, {string:blank}) AS name
			FROM {db_prefix}members
			WHERE id_member IN ({array_int:members})',
			array(
				'members' => array_keys($ids['members']),
				'blank' => '',
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($request))
			foreach ($ids['custom_field'][$row['id']] as $id_action => $type)
				$actions[$id_action][$type == 'to' ? 'to_name' : 'from_name'] = $row['name'];
		$smcFunc['db_free_result']($request);
	}
	if (!empty($ids['permissions']))
	{
		$request = shd_db_query('','
			SELECT id_role AS id, role_name AS name
			FROM {db_prefix}helpdesk_roles 
			WHERE id_role IN ({array_int:roles})',
			array(
				'roles' => array_keys($ids['permissions']),
				'blank' => '',
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($request))
			foreach ($ids['permissions'][$row['id']] as $id_action => $type)
				$actions[$id_action][$type == 'id' ? 'id_name' : ($type == 'to' ? 'to_name' : 'from_name')] = $row['name'];
		$smcFunc['db_free_result']($request);
	}


	// Do some formatting of the action string.
	foreach ($actions as $k => $action)
	{
		if (empty($actions[$k]['action_text']))
			$actions[$k]['action_text'] = isset($txt['shd_log_' . $action['action']]) ? $txt['shd_log_' . $action['action']] : $action['action'];

		if (!empty($action['extra']['setting']) && isset($txt[$action['extra']['setting']]))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_setting'] . ': <span title="' . $action['extra']['setting'] . '">' . $txt[$action['extra']['setting']] . '</span>';
		elseif (!empty($action['extra']['setting']))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_setting'] . ': ' . $action['extra']['setting'];
		elseif (!empty($action['type']) && isset($txt['shd_log_' . $action['action'] . '_' . $action['type']]))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_action'] . ': ' . $txt['shd_log_' . $action['action'] . '_' . $action['type']];
		elseif (!empty($action['type']))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_action'] . ': ' . $action['type'];
		elseif (!empty($action['extra']['action']) && isset($txt['shd_log_' . $action['action'] . '_' . $action['extra']['action']]))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_action'] . ': ' . $txt['shd_log_' . $action['action'] . '_' . $action['extra']['action']];
		elseif (!empty($action['extra']['action']))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_action'] . ': shd_log_' . $action['action'] . '_' . $action['extra']['action'];


		if (isset($action['id_name']))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_name'] . ': <span title="' . $action['extra']['id'] . '">' . $action['id_name'] . '</span>';
		elseif (isset($action['extra']['id']))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_name'] . ': ' . $action['extra']['id'];

		if (isset($action['from_name']))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_from'] . ': <span title="' . $action['extra']['from'] . '">' . $action['from_name'] . '</span>';
		elseif (isset($action['extra']['from']) && $action['type'] == 'check')
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_from'] . ': <span title="' . $action['extra']['from'] . '">' . (empty($action['extra']['from']) ? $txt['shd_admin_default_state_off'] : $txt['shd_admin_default_state_on']) . '</span>';
		elseif (isset($action['extra']['from']))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_from'] . ': ' . $action['extra']['from'];

		if (isset($action['to_name']))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_to'] . ': <span title="' . $action['extra']['to'] . '">' . $action['to_name'] . '</span>';
		elseif (isset($action['extra']['to']) && $action['type'] == 'check')
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_to'] . ': <span title="' . $action['extra']['to'] . '">' . (empty($action['extra']['to']) ? $txt['shd_admin_default_state_off'] : $txt['shd_admin_default_state_on']) . '</span>';
		elseif (isset($action['extra']['to']))
			$actions[$k]['action_text'] .= '<br>' . $txt['shd_admin_adminlog_to'] . ': ' . $action['extra']['to'];

		// Debug stuff.
		$actions[$k]['action_text'] .= '<!--' . print_r($actions[$k], true) . '-->';
	}

	return $actions;
}

/**
 *	Returns the total number of items in the helpdesk admin log.
 *
 *	This function gets the total number of items logged in the helpdesk admin log, for the purposes of establishing the 
 *  number of pages there should be in the page-index.
 *
 *	@return int Number of entries in the helpdesk action log table.
 *	@see shd_load_admin_log_entries()
 *	@since 2.1
*/
function shd_count_admin_log_entries()
{
	global $smcFunc;

	$request = shd_db_query('','
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_log_action AS la
		WHERE id_ticket = {int:no_ticket}',
		array(
			'no_ticket' => 0,
		)
	);

	list ($entry_count) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	return $entry_count;
}