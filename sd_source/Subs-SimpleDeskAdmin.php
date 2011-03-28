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
# File Info: Subs-SimpleDeskAdmin.php / 1.0 Felidae           #
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
 *	@param int $start Number of items into the log to start (for pagination). If nothing is given, fall back to 0, i.e the first log item.
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
	shd_load_language('SimpleDeskAdmin');
	shd_load_language('SimpleDeskLogAction');
	shd_load_language('SimpleDeskNotifications');

	$loaded_users = array();

	// Without further screaming and waving, fetch the actions.
	$request = shd_db_query('','
		SELECT la.id_action, la.log_time, la.ip, la.action, la.id_ticket, la.id_msg, la.extra,
		IFNULL(mem.id_member, 0) AS id_member, IFNULL(mem.real_name, {string:blank}) AS real_name, IFNULL(mg.group_name, {string:na}) AS group_name
		FROM {db_prefix}helpdesk_log_action AS la
			LEFT JOIN {db_prefix}members AS mem ON(mem.id_member = la.id_member)
			LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = CASE WHEN mem.id_group = {int:reg_group_id} THEN mem.id_post_group ELSE mem.id_group END)
		{raw:clause}
		ORDER BY ' . ($sort != '' ? '{raw:sort} {raw:order}' : 'la.log_time DESC') . '
		' . ($start != 0 ? 'LIMIT {int:start}, {int:items_per_page})' : ''),
		array(
			'reg_group_id' => 0,
			'sort' => $sort,
			'start' => $start,
			'items_per_page' => $items_per_page,
			'order' => $order,
			'clause' => empty($clause) ? '' : 'WHERE ' . $clause,
			'na' => $txt['not_applicable'],
			'blank' => '',
		)
	);

	$actions = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		$row['extra'] = @unserialize($row['extra']);
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

		if (shd_allowed_to('shd_view_ip_any') || ($row['id_member'] == $user_info['id'] && shd_allowed_to('shd_view_ip_own')))
			$actions[$row['id_action']]['member']['ip'] = !empty($row['ip']) ? $row['ip'] : $txt['shd_admin_actionlog_unknown'];
	}

	$smcFunc['db_free_result']($request);

	// Do some formatting of the action string.
	foreach ($actions as $k => $action)
	{
		if (empty($actions[$k]['action_text']))
			$actions[$k]['action_text'] = isset($txt['shd_log_' . $action['action']]) ? $txt['shd_log_' . $action['action']] : $action['action'];

		$actions[$k]['action_text'] = str_replace('{scripturl}', $scripturl, $actions[$k]['action_text']);

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
			// Because this could be a lot of people etc., we compact its storage heavily compared to a conventional serialize().
			// See shd_notify_users in SimpleDesk-Notifications.php for what this is.
			$users = array();
			// First, get the list of users, and load their username etc if we haven't already attempted it before.
			foreach ($action['extra']['emails'] as $email_type => $recipients)
			{
				if (isset($recipients['u']))
					$users = array_merge($users, explode(',', $recipients['u']));
			}
			if (!empty($users))
			{
				$users = array_unique($users);
				$unloaded = array_diff($loaded_users, $users);
				if (!empty($unloaded))
					$unloaded = loadMemberData($unloaded, false, 'minimal');
				if (!empty($unloaded))
					$loaded_users = array_merge($loaded_users, $unloaded);
			}

			// Now we have all the usernames for this instance, let's go and build this entry.
			$content = '';
			foreach ($action['extra']['emails'] as $email_type => $recipients)
			{
				$this_content = '<br /><a href="' . $scripturl . '?action=helpdesk;sa=emaillog;log=' . $action['id'] . ';template=' . $email_type . '" onclick="return reqWin(this.href);">' . $txt['template_log_notify_' . $email_type] . '</a> - ';
				
				$new_content = '';
				if (!empty($users))
				{
					$first = true;
					foreach ($users as $user)
					{
						if (empty($user_profile[$user]))
							continue;

						$new_content .= ($first ? $txt['shd_log_notify_users'] . ': ' : ', ') . shd_profile_link($user_profile[$user]['real_name'], $user);
						$first = false;
					}
				}

				if (!empty($recipients['e']))
				{
					$emails = explode(',', $recipients['e']);
					// Admins can see the actual emails.
					if (shd_allowed_to('admin_helpdesk') || $user_info['is_admin'])
					{
						foreach ($emails as $key => $value)
							$emails[$key] = '<a href="mailto:' . $value . '">' . $value . '</a>';
						$new_content .= $txt['shd_log_notify_email'] . ': ' . implode(', ', $emails);
					}
					// No-one else can at the moment.
					else
						$new_content .= $txt['shd_log_notify_email'] . ': ' . (count($emails) == 1 ? $txt['shd_log_notify_hiddenemail_1'] : sprintf($txt['shd_log_notify_hiddenemail'], count($emails)));
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

	// Without further screaming and waving, fetch the actions.
	$request = shd_db_query('','
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_log_action AS la
		LEFT JOIN {db_prefix}members AS mem ON(mem.id_member = la.id_member)
		LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = CASE WHEN mem.id_group = {int:reg_group_id} THEN mem.id_post_group ELSE mem.id_group END)
		{raw:clause}',
		array(
			'reg_group_id' => 0,
			'clause' => empty($clause) ? '' : 'WHERE ' . $clause,
		)
	);

	list ($entry_count) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	return $entry_count;
}

/**
 *	Perform all the operations required for SimpleDesk to safely start operations inside the admin panel.
 *
 *	@param array &$admin_areas The full admin area array from SMF's Admin.php.
 *	@since 1.1
*/
function shd_admin_bootstrap(&$admin_areas)
{
	global $sourcedir, $modSettings, $txt, $context, $scripturl;

	// Load the main admin language files and any needed for SD plugins in the admin panel.
	require_once($sourcedir . '/sd_source/SimpleDesk-Admin.php');
	shd_load_language('SimpleDeskAdmin');
	shd_load_plugin_files('hdadmin');
	shd_load_plugin_langfiles('hdadmin');

	// Now add the main SimpleDesk menu
	if (!empty($modSettings['helpdesk_active']))
	{
		// The helpdesk action log
		if (empty($modSettings['shd_disable_action_log']))
			$admin_areas['maintenance']['areas']['logs']['subsections']['helpdesklog'] = array($txt['shd_admin_helpdesklog'], 'admin_forum', 'url' => $scripturl . '?action=admin;area=helpdesk_info;sa=actionlog');

		// The main menu
		$admin_areas['helpdesk_info'] = array(
			'title' => $txt['shd_helpdesk'],
			'enabled' => allowedTo('admin_forum') || shd_allowed_to('admin_helpdesk'),
			'areas' => array(
				'helpdesk_info' => array(
					'label' => $txt['shd_admin_info'],
					'file' => 'sd_source/SimpleDesk-Admin.php',
					'icon' => 'shd/simpledesk.png',
					'function' => 'shd_admin_main',
					'subsections' => array(
						'main' => array($txt['shd_admin_info']),
						'actionlog' => array($txt['shd_admin_actionlog'], 'enabled' => empty($modSettings['shd_disable_action_log'])),
						'support' => array($txt['shd_admin_support']),
					),
				),
				'helpdesk_options' => array(
					'label' => $txt['shd_admin_options'],
					'file' => 'sd_source/SimpleDesk-Admin.php',
					'icon' => 'shd/options.png',
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
				'helpdesk_customfield' => array(
					'label' => $txt['shd_admin_custom_fields'],
					'file' => 'sd_source/SimpleDesk-Admin.php',
					'icon' => 'shd/custom_fields.png',
					'function' => 'shd_admin_main',
					'subsections' => array(
					),
				),
				'helpdesk_permissions' => array(
					'label' => $txt['shd_admin_permissions'],
					'file' => 'sd_source/SimpleDesk-Admin.php',
					'icon' => 'shd/permissions.png',
					'function' => 'shd_admin_main',
					'subsections' => array(
					),
				),
				'helpdesk_plugins' => array(
					'label' => $txt['shd_admin_plugins'],
					'file' => 'sd_source/SimpleDesk-Admin.php',
					'icon' => 'shd/plugins.png',
					'function' => 'shd_admin_main',
					'subsections' => array(
					),
				),
				'helpdesk_maint' => array(
					'label' => $txt['shd_admin_maint'],
					'file' => 'sd_source/SimpleDesk-Admin.php',
					'icon' => 'shd/maintenance.png',
					'function' => 'shd_admin_main',
					'subsections' => array(
					),
				),
			),
		);

		// Now engage any hooks.
		call_integration_hook('shd_hook_adminmenu', array(&$admin_areas));
	}
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
 *	@since 1.1
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
?>