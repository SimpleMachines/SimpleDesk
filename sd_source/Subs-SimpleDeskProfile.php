<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2020 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1 Beta 1                              *
* File Info: Subs-SimpleDeskProfile.php                       *
**************************************************************/

/**
 *	This file handles integrations into SMF.
 *
 *	@package subs
 *	@since 2.1
 */
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Sets up the profile menu additions.
 *
 *	@param array $profile_areas Current profile_areas.
 *
 *	@since 2.0
*/
function shd_profile_areas(&$profile_areas)
{
	global $sourcedir, $modSettings, $context, $txt;
	static $called = false;

	if ($called)
		return;
	elseif (empty($called))
		$called = true;

	// SimpleDesk sections. Added here after the initial cleaning is done, so that we can do our own permission checks without arguing with SMF's system (so much)
	if (empty($modSettings['helpdesk_active']))
		return;

	shd_load_language('sd_language/SimpleDeskProfile');

	// Put it here so we can reuse it for the left menu a bit
	$context['helpdesk_menu'] = array(
		'title' => $txt['shd_profile_area'],
		'areas' => array(
			'hd_profile' => array(
				'label' => $txt['shd_profile_main'],
				'file' => 'sd_source/SimpleDesk-Profile.php',
				'function' => 'shd_profile_main',
				'enabled' => shd_allowed_to('shd_view_profile_any') || ($context['user']['is_owner'] && shd_allowed_to('shd_view_profile_own')),
				'permission' => array(
					'own' => array('is_not_guest'),
					'any' => array('is_not_guest'),
				),
			),
			'hd_prefs' => array(
				'label' => $txt['shd_profile_preferences'],
				'file' => 'sd_source/SimpleDesk-Profile.php',
				'function' => 'shd_profile_main',
				'enabled' => shd_allowed_to('shd_view_preferences_any') || ($context['user']['is_owner'] && shd_allowed_to('shd_view_preferences_own')),
				'permission' => array(
					'own' => array('shd_view_preferences_own'),
					'any' => array('shd_view_preferences_any'),
				),
			),
			'hd_showtickets' => array(
				'label' => $txt['shd_profile_show_tickets'],
				'file' => 'sd_source/SimpleDesk-Profile.php',
				'function' => 'shd_profile_main',
				'enabled' => ($context['user']['is_owner'] && shd_allowed_to('shd_view_ticket_own')) || shd_allowed_to('shd_view_ticket_any'),
				'permission' => array(
					'own' => array('shd_view_ticket_own'),
					'any' => array('shd_view_ticket_any'),
				),
			),
			'hd_permissions' => array(
				'label' => $txt['shd_profile_permissions'],
				'file' => 'sd_source/SimpleDesk-Profile.php',
				'function' => 'shd_profile_main',
				'enabled' => shd_allowed_to('admin_helpdesk'),
				'permission' => array(
					'own' => array('admin_helpdesk'),
					'any' => array('admin_helpdesk'),
				),
			),
			'hd_actionlog' => array(
				'label' => $txt['shd_profile_actionlog'],
				'file' => 'sd_source/SimpleDesk-Profile.php',
				'function' => 'shd_profile_main',
				'enabled' => empty($modSettings['shd_disable_action_log']) && (shd_allowed_to('shd_view_profile_log_any') || ($context['user']['is_owner'] && shd_allowed_to('shd_view_profile_log_own'))),
				'permission' => array(
					'own' => array('shd_view_profile_log_own'),
					'any' => array('shd_view_profile_log_any'),
				),
			),
		),
	);

	// Kill the existing profile menu but save it in a temporary place first.
	$old_profile_areas = $profile_areas;
	$profile_areas = array();

	// Now, where we add this depends very much on what mode we're in. In HD only mode, we want our menu first before anything else.
	if (!empty($modSettings['shd_helpdesk_only']))
	{
		require_once($sourcedir . '/Profile-Modify.php');

		// Move some stuff around.
		$context['helpdesk_menu']['areas']['permissions'] = array(
			'label' => $txt['shd_show_forum_permissions'],
			'file' => 'Profile-View.php',
			'function' => 'showPermissions',
			'enabled' => allowedTo('manage_permissions'),
		);
		$context['helpdesk_menu']['areas']['tracking'] = array(
			'label' => $txt['trackUser'],
			'file' => 'Profile-View.php',
			'function' => 'tracking',
			'subsections' => array(
				'activity' => array($txt['trackActivity'], 'moderate_forum'),
				'ip' => array($txt['trackIP'], 'moderate_forum'),
				'edits' => array($txt['trackEdits'], 'moderate_forum'),
			),
			'enabled' => allowedTo('moderate_forum'),
		);

		$profile_areas['helpdesk'] = $context['helpdesk_menu'];
		$profile_areas += $old_profile_areas;

		unset($profile_areas['info']['areas']['permissions'], $profile_areas['info']['areas']['tracking']);

		$remove = array(
			'info' => array(
				'summary',
				'statistics',
				'showposts',
				'viewwarning',
			),
			'edit_profile' => array(
				'forumprofile',
				'ignoreboards',
				'lists',
				'notification',
			),
			'profile_action' => array(
				'issuewarning',
			),
		);
		if (!empty($modSettings['shd_disable_pm']))
		{
			$remove['profile_action'][] = 'sendpm';
			$remove['edit_profile'][] = 'pmprefs';
		}

		foreach ($remove as $area => $items)
			foreach ($items as $item)
				if (!empty($profile_areas[$area]['areas'][$item]))
					$profile_areas[$area]['areas'][$item]['enabled'] = false;

		$profile_areas['edit_profile']['areas']['theme']['file'] = 'sd_source/SimpleDesk-Profile.php';
		$profile_areas['edit_profile']['areas']['theme']['function'] = 'shd_profile_theme_wrapper';
	}
	else
	// In non HD only, put it before the editing stuff menu
	{
		foreach ($old_profile_areas as $area => $details)
		{
			if ($area == 'edit_profile')
				$profile_areas['helpdesk'] = $context['helpdesk_menu'];
			$profile_areas[$area] = $details;
		}
	}

	// Now engage any hooks.
	call_integration_hook('shd_hook_profilemenu', array(&$profile_areas));
}

/**
 *	Sets up the profile tracking for helpdesk.
 *
 *	@since 2.1
*/
function shd_profile_trackip($ip_string, $ip_var)
{
	global $modSettings, $txt, $context, $scripturl;

	// Set the options for the helpdesk replies list.
	if (empty($modSettings['helpdesk_active']))
		return;

	$listOptions = array(
		'id' => 'track_helpdesk_list',
		'title' => $txt['shd_replies_from_ip'] . ' ' . $context['ip'],
		'start_var_name' => 'helpdeskStart',
		'items_per_page' => $modSettings['defaultMaxMessages'],
		'no_items_label' => $txt['shd_replies_from_ip'],
		'base_href' => $context['base_url'] . ';searchip=' . $context['ip'],
		'default_sort_col' => 'date2',
		'get_items' => array(
			'function' => 'shd_list_get_ip_messages',
			'params' => array(
				'hdtr.poster_ip ' . $ip_string,
				array('ip_address' => $ip_var),
			),
		),
		'get_count' => array(
			'function' => 'shd_list_get_ip_message_count',
			'params' => array(
				'hdtr.poster_ip ' . $ip_string,
				array('ip_address' => $ip_var),
			),
		),
		'columns' => array(
			'ip_address2' => array(
				'header' => array(
					'value' => $txt['ip_address'],
				),
				'data' => array(
					'sprintf' => array(
						'format' => '<a href="' . $context['base_url'] . ';searchip=%1$s">%1$s</a>',
						'params' => array(
							'ip' => false,
						),
					),
				),
				'sort' => array(
					'default' => 'INET_ATON(hdtr.poster_ip)',
					'reverse' => 'INET_ATON(hdtr.poster_ip) DESC',
				),
			),
			'display_name' => array(
				'header' => array(
					'value' => $txt['display_name'],
				),
				'data' => array(
					'db' => 'member_link',
				),
			),
			'subject' => array(
				'header' => array(
					'value' => $txt['subject'],
				),
				'data' => array(
					'sprintf' => array(
						'format' => '<a href="' . $scripturl . '?action=helpdesk;sa=ticket;ticket=%1$s.msg%2$s#msg%2$s" rel="nofollow">%3$s</a>%4$s',
						'params' => array(
							'ticket' => false,
							'id' => false,
							'subject' => false,
							'additional' => false,
						),
					),
				),
			),
			'date2' => array(
				'header' => array(
					'value' => $txt['date'],
				),
				'data' => array(
					'db' => 'time',
				),
				'sort' => array(
					'default' => 'hdtr.id_msg DESC',
					'reverse' => 'hdtr.id_msg',
				),
			),
		),
		'additional_rows' => array(
			array(
				'position' => 'after_title',
				'value' => $txt['shd_replies_from_ip_desc'],
				'class' => 'smalltext',
				'style' => 'padding: 2ex;',
			),
		),
	);

	// Create the helpdesk replies list.
	createList($listOptions);
	$context['additional_track_lists'][] = 'track_helpdesk_list';
}


function shd_list_get_ip_messages($start, $items_per_page, $sort, $where, $where_vars = array())
{
	global $smcFunc, $txt, $scripturl;
	$query = shd_db_query('', '
		SELECT
			hdtr.id_msg, hdtr.poster_ip, COALESCE(mem.real_name, hdtr.poster_name) AS display_name, mem.id_member,
			hdt.subject, hdtr.poster_time, hdt.id_ticket, hdt.id_first_msg
		FROM {db_prefix}helpdesk_ticket_replies AS hdtr
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdtr.id_ticket = hdt.id_ticket)
			LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = hdtr.id_member)
		WHERE {query_see_ticket} AND ' . $where . '
		ORDER BY ' . $sort . '
		LIMIT ' . $start . ', ' . $items_per_page,
		array_merge($where_vars, array(
		))
	);
	$messages = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$messages[] = array(
			'ip' => $row['poster_ip'],
			'member_link' => shd_profile_link($row['display_name'], $row['id_member']),
			'ticket' => $row['id_ticket'],
			'id' => $row['id_msg'],
			'subject' => $row['subject'],
			'time' => timeformat($row['poster_time']),
			'timestamp' => forum_time(true, $row['poster_time']),
			'additional' => $row['id_first_msg'] == $row['id_msg'] ? $txt['shd_is_ticket_opener'] : '',
		);
	$smcFunc['db_free_result']($query);

	return $messages;
}

/**
 *	Returns the number of helpdesk replies found for track ip.
 *
 *	@param string $where a valid SQL WHERE options for filtering data.
 *	@param array $where_vars Valid options to be passed to $smcFunc.
 *
 *	@since 2.0
 *	@return int A total count of helpdesk replies matching the WHERE filter.
*/
function shd_list_get_ip_message_count($where, $where_vars = array())
{
	global $smcFunc;

	$request = shd_db_query('', '
		SELECT COUNT(id_msg) AS message_count
		FROM {db_prefix}helpdesk_ticket_replies AS hdtr
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdtr.id_ticket = hdt.id_ticket)
		WHERE {query_see_ticket} AND ' . $where,
		$where_vars
	);
	list ($count) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	return $count;
}