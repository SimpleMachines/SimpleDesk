<?php
###############################################################
#          Simple Desk Project - www.simpledesk.net           #
###############################################################
#       An advanced help desk modification built on SMF       #
###############################################################
#                                                             #
#         * Copyright 2017 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 2.1 Beta 1                              #
# File Info: SimpleDesk-Profile.php                           #
###############################################################

/**
 *	This file handles all aspects of the SimpleDesk profile section. Everything from user preferences
 *	to personal stats as well as sensitive information (site URL, contact email, etc.).
 *
 *	@package source
 *	@since 2.0
 */

if (!defined('SMF'))
	die('If only you could draw like a drunken monkey...');

function shd_profile_main($memID)
{
	global $context, $txt, $scripturl, $sourcedir, $user_info, $settings, $user_profile, $modSettings;

	// Load the profile details
	loadTemplate('sd_template/SimpleDesk-Profile', array('helpdesk', 'helpdesk_admin'));
	shd_load_language('sd_language/SimpleDeskProfile');
	$context['shd_preferences'] = shd_load_user_prefs();
	shd_load_plugin_files('hdprofile');
	shd_load_plugin_langfiles('hdprofile');

	$context['page_title'] = $txt['shd_profile_area'] . ' - ' . $txt['shd_profile_main'];
	$context['sub_template'] = 'shd_profile_main';

	$subActions = array(
		'helpdesk' => 'shd_profile_frontpage',
		'hd_prefs' => 'shd_profile_preferences',
		'hd_showtickets' => 'shd_profile_show_tickets',
		'hd_permissions' => 'shd_profile_permissions',
		'hd_actionlog' => 'shd_profile_actionlog',
	);

	$context['shd_profile_menu'] = array(
		array(
			'image' => 'user.png',
			'link' => $scripturl . '?action=profile;u=' . $context['member']['id'] . ';area=hd_profile',
			'text' => $txt['shd_profile_home'],
			'show' => true,
		),
		array(
			'image' => 'preferences.png',
			'link' => $scripturl . '?action=profile;u=' . $context['member']['id'] . ';area=hd_prefs',
			'text' => $txt['shd_profile_preferences'],
			'show' => true,
		),
		array(
			'image' => 'ticket.png',
			'link' => $scripturl . '?action=profile;u=' . $context['member']['id'] . ';area=hd_showtickets',
			'text' => $txt['shd_profile_show_tickets'],
			'show' => true,
		),
		array(
			'image' => 'permissions.png',
			'link' => $scripturl . '?action=profile;u=' . $context['member']['id'] . ';area=hd_permissions',
			'text' => $txt['shd_profile_permissions'],
			'show' => !empty($context['helpdesk_menu']['areas']['hd_permissions']['enabled']), // we already figured this out once before
		),
		array(
			'image' => 'log.png',
			'link' => $scripturl . '?action=profile;u=' . $context['member']['id'] . ';area=hd_actionlog',
			'text' => $txt['shd_profile_actionlog'],
			'show' => !empty($context['helpdesk_menu']['areas']['hd_actionlog']['enabled']), // we figured this too
		),
		array(
			'image' => 'go_to_helpdesk.png',
			'link' => $scripturl . '?action=helpdesk;sa=main',
			'text' => $txt['shd_profile_go_to_helpdesk'],
			'show' => true,
		),
	);

	// Int hooks - after we basically set everything up (so it's manipulatable by the hook, but before we do the last bits of finalisation)
	call_integration_hook('shd_hook_hdprofile', array(&$subActions, &$memID));

	// Make sure the menu is configured appropriately
	$context['shd_profile_menu'][count($context['shd_profile_menu'])-1]['is_last'] = true;

	$_REQUEST['area'] = isset($_REQUEST['area']) && isset($subActions[$_REQUEST['area']]) ? $_REQUEST['area'] : 'helpdesk';
	$context['sub_action'] = $_REQUEST['area'];

	$subActions[$_REQUEST['area']]($memID);

	// Maintenance mode? If it were, the helpdesk is considered inactive for the purposes of everything to all but those without admin-helpdesk rights - but we must have them if we're here!
	if (!empty($modSettings['shd_maintenance_mode']))
	{
		loadTemplate('sd_template/SimpleDesk');
		$temp_layers = $context['template_layers'];
		$context['template_layers'] = array();
		$added = false;
		foreach ($temp_layers as $layer)
		{
			$context['template_layers'][] = $layer;
			if ($layer == 'body')
			{
				$context['template_layers'][] = 'shd_maintenance';
				$added = true;
			}
		}

		// Well, we tried to add it as near the top as possible, but not all themes use the standard body layer.
		if (!$added)
			$context['template_layers'][] = 'shd_maintenance';
	}

	$context['template_layers'][] = 'shd_profile_navigation';
}

function shd_profile_frontpage($memID)
{
	global $context, $memberContext, $txt, $modSettings, $user_info, $user_profile, $sourcedir, $scripturl, $smcFunc;

	// Attempt to load the member's profile data.
	if (!loadMemberContext($memID) || !isset($memberContext[$memID]))
		fatal_lang_error('not_a_user', false);

	$context['page_title'] = $txt['shd_profile_area'] . ' - ' . $txt['shd_profile_main'];
	$context['sub_template'] = 'shd_profile_main';

	$query = shd_db_query('', '
		SELECT COUNT(id_ticket) AS count, status
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE id_member_started = {int:member}
		GROUP BY status',
		array(
			'member' => $memID,
		)
	);

	$context['shd_numtickets'] = 0;
	$context['shd_numopentickets'] = 0;
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$context['shd_numtickets'] += $row['count'];
		if ($row['status'] != TICKET_STATUS_CLOSED && $row['status'] != TICKET_STATUS_DELETED)
			$context['shd_numopentickets'] += $row['count'];
	}

	$context['shd_numtickets'] = comma_format($context['shd_numtickets']);
	$context['shd_numopentickets'] = comma_format($context['shd_numopentickets']);

	$smcFunc['db_free_result']($query);

	$query = shd_db_query('', '
		SELECT COUNT(id_ticket)
		FROM {db_prefix}helpdesk_tickets
		WHERE id_member_assigned = {int:member}',
		array(
			'member' => $memID,
		)
	);

	list($context['shd_numassigned']) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);
	$context['shd_numassigned'] = comma_format($context['shd_numassigned']);

	$context['can_post_ticket'] = shd_allowed_to('shd_new_ticket', 0) && $memID == $context['user']['id'];
	$context['can_post_proxy'] = shd_allowed_to('shd_new_ticket', 0) && shd_allowed_to('shd_post_proxy', 0) && $memID != $context['user']['id']; // since it's YOUR permissions, whether you can post on behalf of this user and this user isn't you!

	// Everything hereafter is HD only stuff.
	if (empty($modSettings['shd_helpdesk_only']))
		return;

	$context['can_send_pm'] = allowedTo('pm_send') && (empty($modSettings['shd_helpdesk_only']) || empty($modSettings['shd_disable_pm']));
	$context['member'] = &$memberContext[$memID];

	if (allowedTo('moderate_forum'))
	{
		// Make sure it's a valid ip address; otherwise, don't bother...
		if (preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $memberContext[$memID]['ip']) == 1 && empty($modSettings['disableHostnameLookup']))
			$context['member']['hostname'] = host_from_ip($memberContext[$memID]['ip']);
		else
			$context['member']['hostname'] = '';

		$context['can_see_ip'] = true;
	}
	else
		$context['can_see_ip'] = false;

	// If the user is awaiting activation, and the viewer has permission - setup some activation context messages.
	if ($context['member']['is_activated'] % 10 != 1 && allowedTo('moderate_forum'))
	{
		$context['activate_type'] = $context['member']['is_activated'];
		// What should the link text be?
		$context['activate_link_text'] = in_array($context['member']['is_activated'], array(3, 4, 5, 13, 14, 15)) ? $txt['account_approve'] : $txt['account_activate'];

		// Should we show a custom message?
		$context['activate_message'] = isset($txt['account_activate_method_' . $context['member']['is_activated'] % 10]) ? $txt['account_activate_method_' . $context['member']['is_activated'] % 10] : $txt['account_not_activated'];
	}

	// How about, are they banned?
	$context['member']['bans'] = array();
	if (allowedTo('moderate_forum'))
	{
		// Can they edit the ban?
		$context['can_edit_ban'] = allowedTo('manage_bans');

		$ban_query = array();
		$ban_query_vars = array(
			'time' => time(),
		);
		$ban_query[] = 'id_member = ' . $context['member']['id'];

		// Valid IP?
		if (preg_match('/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $memberContext[$memID]['ip'], $ip_parts) == 1)
		{
			$ban_query[] = '((' . $ip_parts[1] . ' BETWEEN bi.ip_low1 AND bi.ip_high1)
						AND (' . $ip_parts[2] . ' BETWEEN bi.ip_low2 AND bi.ip_high2)
						AND (' . $ip_parts[3] . ' BETWEEN bi.ip_low3 AND bi.ip_high3)
						AND (' . $ip_parts[4] . ' BETWEEN bi.ip_low4 AND bi.ip_high4))';

			// Do we have a hostname already?
			if (!empty($context['member']['hostname']))
			{
				$ban_query[] = '({string:hostname} LIKE hostname)';
				$ban_query_vars['hostname'] = $context['member']['hostname'];
			}
		}
		// Use '255.255.255.255' for 'unknown' - it's not valid anyway.
		elseif ($memberContext[$memID]['ip'] == 'unknown')
			$ban_query[] = '(bi.ip_low1 = 255 AND bi.ip_high1 = 255
						AND bi.ip_low2 = 255 AND bi.ip_high2 = 255
						AND bi.ip_low3 = 255 AND bi.ip_high3 = 255
						AND bi.ip_low4 = 255 AND bi.ip_high4 = 255)';

		// Check their email as well...
		if (strlen($context['member']['email']) != 0)
		{
			$ban_query[] = '({string:email} LIKE bi.email_address)';
			$ban_query_vars['email'] = $context['member']['email'];
		}

		// So... are they banned?  Dying to know!
		$request = $smcFunc['db_query']('', '
			SELECT bg.id_ban_group, bg.name, bg.cannot_access, bg.cannot_post, bg.cannot_register,
				bg.cannot_login, bg.reason
			FROM {db_prefix}ban_items AS bi
				INNER JOIN {db_prefix}ban_groups AS bg ON (bg.id_ban_group = bi.id_ban_group AND (bg.expire_time IS NULL OR bg.expire_time > {int:time}))
			WHERE (' . implode(' OR ', $ban_query) . ')',
			$ban_query_vars
		);
		while ($row = $smcFunc['db_fetch_assoc']($request))
		{
			// Work out what restrictions we actually have.
			$ban_restrictions = array();
			foreach (array('access', 'register', 'login', 'post') as $type)
				if ($row['cannot_' . $type])
					$ban_restrictions[] = $txt['ban_type_' . $type];

			// No actual ban in place?
			if (empty($ban_restrictions))
				continue;

			// Prepare the link for context.
			$ban_explanation = sprintf($txt['user_cannot_due_to'], implode(', ', $ban_restrictions), '<a href="' . $scripturl . '?action=admin;area=ban;sa=edit;bg=' . $row['id_ban_group'] . '">' . $row['name'] . '</a>');

			$context['member']['bans'][$row['id_ban_group']] = array(
				'reason' => empty($row['reason']) ? '' : '<br /><br /><strong>' . $txt['ban_reason'] . ':</strong> ' . $row['reason'],
				'cannot' => array(
					'access' => !empty($row['cannot_access']),
					'register' => !empty($row['cannot_register']),
					'post' => !empty($row['cannot_post']),
					'login' => !empty($row['cannot_login']),
				),
				'explanation' => $ban_explanation,
			);
		}
		$smcFunc['db_free_result']($request);
	}
}

function shd_profile_preferences($memID)
{
	global $context, $txt, $scripturl, $sourcedir, $user_info, $smcFunc;

	$context['page_title'] = $txt['shd_profile_area'] . ' - ' . $txt['shd_profile_preferences'];
	$context['sub_template'] = 'shd_profile_preferences';

	// Load the list of options and the user's individual opts
	$context['shd_preferences_options'] = shd_load_user_prefs(false);
	$context['member']['shd_preferences'] = shd_load_user_prefs($memID);

	foreach ($context['member']['shd_preferences'] as $pref => $value)
	{
		if (isset($context['shd_preferences_options']['prefs'][$pref]))
		{
			$thisgroup = $context['shd_preferences_options']['prefs'][$pref]['group'];
			if (!isset($context['shd_preferences_options']['groups'][$thisgroup]))
				$context['shd_preferences_options']['groups'][$thisgroup] = array();

			$context['shd_preferences_options']['groups'][$thisgroup]['groups'][] = $pref;
		}
	}

	foreach ($context['shd_preferences_options']['groups'] as $group => $groupinfo)
	{
		if (empty($groupinfo))
			unset($context['shd_preferences_options']['groups'][$group]);
	}

	// Are we saving any options?
	if (isset($_GET['save']))
	{
		$changes = array(
			'add' => array(),
			'remove' => array(),
		);
		// Step through each of the options we know are ours and check if they're defined here
		foreach ($context['member']['shd_preferences'] as $pref => $current_value)
		{
			$master_opt = $context['shd_preferences_options']['prefs'][$pref];

			$new_value = $master_opt['default'];
			switch ($master_opt['type'])
			{
				case 'check':
					$new_value = !empty($_POST[$pref]) ? 1 : 0;
					break;
				case 'int':
					$new_value = isset($_POST[$pref]) ? (int) $_POST[$pref] : 0;
					break;
				case 'select':
					if (isset($_POST[$pref]) && isset($master_opt['options'][$_POST[$pref]]))
						$new_value = $_POST[$pref];
					break;
			}

			if ($master_opt['default'] == $new_value)
			{
				// The new value is the same as default. If we already had non-default, remove the non-default value.
				if ($new_value != $current_value)
					$changes['remove'][] = $pref;
			}
			else
			{
				if ($new_value != $current_value)
					$changes['add'][] = array($memID, $pref, (string) $new_value);
			}

			// Finally, make sure whatever's in the array is actually what we've asked for
			$context['member']['shd_preferences'][$pref] = $new_value;
		}

		// Clean up the database and apply all the changes
		if (!empty($changes['add']))
		{
			$smcFunc['db_insert']('replace',
				'{db_prefix}helpdesk_preferences',
				array(
					'id_member' => 'int', 'variable' => 'string', 'value' => 'string',
				),
				$changes['add'],
				array(
					'id_member', 'variable',
				)
			);
		}

		if (!empty($changes['remove']))
		{
			$smcFunc['db_query']('', '
				DELETE FROM {db_prefix}helpdesk_preferences
				WHERE id_member = {int:member}
					AND variable IN ({array_string:prefs})',
				array(
					'member' => $memID,
					'prefs' => $changes['remove'],
				)
			);
		}
	}
}

function shd_profile_show_tickets($memID)
{
	global $txt, $user_info, $scripturl, $modSettings, $smcFunc, $board, $user_profile, $context;

	// Navigation
	$context['show_tickets_navigation'] = array(
		'tickets' => array('text' => 'shd_profile_show_tickets', 'lang' => true, 'url' => $scripturl . '?action=profile;u=' . $memID . ';area=hd_showtickets;sa=tickets'),
		'replies' => array('text' => 'shd_profile_show_replies', 'lang' => true, 'url' => $scripturl . '?action=profile;u=' . $memID . ';area=hd_showtickets;sa=replies'),
	);
	// We might be adding the monitor/ignore lists, but we're only interested in those if we're actually on our own page.
	if ($memID == $user_info['id'])
	{
		if (shd_allowed_to('shd_monitor_ticket_any') || shd_allowed_to('shd_monitor_ticket_own'))
			$context['show_tickets_navigation']['monitor'] = array('text' => 'shd_profile_show_monitor', 'lang' => true, 'url' => $scripturl . '?action=profile;u=' . $memID . ';area=hd_showtickets;sa=monitor');
		if (shd_allowed_to('shd_ignore_ticket_any') || shd_allowed_to('shd_ignore_ticket_own'))
			$context['show_tickets_navigation']['ignore'] = array('text' => 'shd_profile_show_ignore', 'lang' => true, 'url' => $scripturl . '?action=profile;u=' . $memID . ';area=hd_showtickets;sa=ignore');
		// We have the monitor and ignore lists in this area but this code can't deal with it, so we need to go somewhere else with it.
		if (isset($_GET['sa']) && ($_GET['sa'] == 'monitor' || $_GET['sa'] == 'ignore'))
			return shd_profile_show_notify_override($memID);
	}

	$context['page_title'] = $txt['shd_profile_show_tickets'] . ' - ' . $user_profile[$memID]['real_name'];
	$context['sub_template'] = 'shd_profile_show_tickets';
	$context['start'] = (int) $_REQUEST['start'];

	// The time has come to choose: Tickets, or just replies?
	$context['can_haz_replies'] = isset($_GET['sa']) && $_GET['sa'] == 'replies' ? true : false;

	// The active button.
	$context['show_tickets_navigation'][$context['can_haz_replies'] ? 'replies' : 'tickets']['active'] = true;

	// "That still only counts as one!"
	if ($context['can_haz_replies'])
		$request = shd_db_query('', '
			SELECT COUNT(hdtr.id_msg)
			FROM {db_prefix}helpdesk_ticket_replies AS hdtr
				LEFT JOIN {db_prefix}helpdesk_tickets AS hdt ON(hdtr.id_ticket = hdt.id_ticket)
			WHERE hdtr.id_member = {int:user}
				AND {query_see_ticket}',
			array(
				'user' => $memID,
			)
		);
	else
		$request = shd_db_query('', '
			SELECT COUNT(hdt.id_ticket)
			FROM {db_prefix}helpdesk_tickets AS hdt
			WHERE hdt.id_member_started = {int:user}
				AND {query_see_ticket}',
			array(
				'user' => $memID,
			)
		);
	list ($item_count) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	$max_index = (int) $modSettings['defaultMaxMessages'];

	// A little page index to help us along the way!
	$context['page_index'] = shd_no_expand_pageindex($scripturl . '?action=profile;u=' . $memID . ';area=hd_showtickets' . ($context['can_haz_replies'] ? ';sa=replies' : ''), $context['start'], $item_count, $max_index);
	$context['current_page'] = $context['start'] / $max_index;

	// Reverse the query if we're past 50% of the pages for better performance.
	$start = $context['start'];
	$reverse = $_REQUEST['start'] > $item_count / 2;
	if ($reverse) // Turn it all around!
	{
		$max_index = $item_count < $context['start'] + $modSettings['defaultMaxMessages'] + 1 && $item_count > $context['start'] ? $item_count - $context['start'] : (int) $modSettings['defaultMaxMessages'];
		$start = $item_count < $context['start'] + $modSettings['defaultMaxMessages'] + 1 || $item_count < $context['start'] + $modSettings['defaultMaxMessages'] ? 0 : $item_count - $context['start'] - $modSettings['defaultMaxMessages'];
	}

	// Bring 'em to me!
	$looped = false;
	while (true)
	{
		if ($context['can_haz_replies'])
		{
			$request = shd_db_query('', '
				SELECT
					hdtr.id_member, hdt.subject, hdt.id_first_msg,
					hdtr.body, hdtr.smileys_enabled, hdtr.poster_time, hdtr.id_ticket, hdtr.id_msg
				FROM {db_prefix}helpdesk_ticket_replies AS hdtr
					INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdt.id_ticket = hdtr.id_ticket)
				WHERE hdtr.id_member = {int:user}
					AND {query_see_ticket}
				ORDER BY hdtr.id_msg ' . ($reverse ? 'ASC' : 'DESC') . '
				LIMIT ' . $start . ', ' . $max_index,
				array(
					'user' => $memID,
				)
			);
		}
		else
		{
			$request = shd_db_query('', '
				SELECT
					hdt.id_member_started, hdt.id_first_msg, hdt.id_last_msg, hdt.subject,
					hdtr.body, hdtr.smileys_enabled, hdtr.poster_time, hdtr.id_ticket, hdtr.id_msg
				FROM {db_prefix}helpdesk_tickets AS hdt
					INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdtr.id_msg = hdt.id_first_msg)
				WHERE hdt.id_member_started = {int:user}
					AND {query_see_ticket}
				ORDER BY hdt.id_first_msg ' . ($reverse ? 'ASC' : 'DESC') . '
				LIMIT ' . $start . ', ' . $max_index,
				array(
					'user' => $memID,
				)
			);
		}

		// Hold it!
		if ($smcFunc['db_num_rows']($request) === $max_index || $looped)
			break;
		$looped = true;
	}

	// Start counting at the number of the first message displayed.
	$counter = $reverse ? $context['start'] + $max_index + 1 : $context['start'];
	$context['items'] = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		// Censor the content
		censorText($row['body']);
		censorText($row['subject']);

		// Do the parsing dance! Eh...
		$row['body'] = shd_format_text($row['body'], $row['smileys_enabled'], 'shd_reply_' . $row['id_msg']);

		// And finally,  store the load of cr--... the results!
		$context['items'][$counter += $reverse ? -1 : 1] = array(
			'body' => $row['body'],
			'counter' => $counter,
			'alternate' => $counter % 2,
			'ticket' => $row['id_ticket'],
			'subject' => $row['subject'],
			'start' => 'msg' . $row['id_msg'],
			'time' => timeformat($row['poster_time']),
			'timestamp' => forum_time(true, $row['poster_time']),
			'msg' => $row['id_msg'],
			'is_ticket' => empty($context['can_haz_replies']) ? true : ($row['id_msg'] == $row['id_first_msg']),
		);
	}
	// Freedom.
	$smcFunc['db_free_result']($request);

	// Head's up, feet's down.
	if ($reverse)
		$context['items'] = array_reverse($context['items'], true);
}

function shd_profile_show_notify_override($memID)
{
	global $txt, $user_info, $scripturl, $modSettings, $smcFunc, $board, $user_profile, $context;

	$context['notify_type'] = $_GET['sa']; // We already checked it's monitor or ignore, if we didn't, we wouldn't be here!

	$context['page_title'] = $txt['shd_profile_show_' . $context['notify_type'] . '_title'] . ' - ' . $user_profile[$memID]['real_name'];
	$context['sub_template'] = 'shd_profile_show_notify_override';

	// The active button.
	$context['show_tickets_navigation'][$context['notify_type']]['active'] = true;

	// Having got the general stuff out the way, let's do the specifics.

	// Ticket, Name, Started By, Replies, Status, Urgency, Updated (+ Updated By?)
	$context['tickets'] = array();
	$query = shd_db_query('', '
		SELECT hdt.id_ticket, hdt.subject, IFNULL(mem.id_member, 0) AS starter_id, IFNULL(mem.real_name, hdtr.poster_name) AS starter_name,
			hdt.num_replies, hdt.status, hdt.urgency, hdt.last_updated
		FROM {db_prefix}helpdesk_notify_override AS hdno
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdno.id_ticket = hdt.id_ticket)
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdt.id_first_msg = hdtr.id_msg)
			LEFT JOIN {db_prefix}members AS mem ON (hdt.id_member_started = mem.id_member)
		WHERE {query_see_ticket}
			AND hdno.id_member = {int:user}
			AND hdno.notify_state = {int:notify}
		ORDER BY last_updated DESC',
		array(
			'user' => $memID,
			'notify' => $context['notify_type'] == 'monitor' ? NOTIFY_ALWAYS : NOTIFY_NEVER,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$row += array(
			'id_ticket_display' => str_pad($row['id_ticket'], $modSettings['shd_zerofill'], '0', STR_PAD_LEFT),
			'updated' => timeformat($row['last_updated']),
			'ticket_starter' => shd_profile_link($row['starter_name'], $row['starter_id']),
		);
		$context['tickets'][] = $row;
	}
}

function shd_profile_permissions($memID)
{
	global $context, $txt, $scripturl, $sourcedir, $user_info, $smcFunc, $user_profile, $settings;

	shd_load_language('sd_language/SimpleDeskPermissions');

	$context['page_title'] = $txt['shd_profile_area'] . ' - ' . $txt['shd_profile_permissions'];
	$context['sub_template'] = 'shd_profile_permissions';

	// OK, start by figuring out what permissions are out there.
	shd_load_all_permission_sets();

	// 1. What groups is this user in? And we need all their groups, which in 'profile' mode, SMF helpfully puts into $user_profile[$memID] for us.
	$groups = empty($user_profile[$memID]['additional_groups']) ? array() :  explode(',', $user_profile[$memID]['additional_groups']);
	$groups[] = $user_profile[$memID]['id_group'];

	// Sanitise this little lot
	foreach ($groups as $key => $value)
		$groups[$key] = (int) $value;

	// 1b. Hang on, is this user special? Are they, dare I suggest it, a full blown forum admin?
	$context['member']['has_all_permissions'] = in_array(1, $groups);
	if ($context['member']['has_all_permissions'])
		return;

	// 2. Do we have a department?
	$_REQUEST['permdept'] = isset($_REQUEST['permdept']) ? (int) $_REQUEST['permdept'] : 0;
	$depts = shd_allowed_to('access_helpdesk', false);
	if (!in_array($_REQUEST['permdept'], $depts))
		$_REQUEST['permdept'] = 0; // this way we know that 0 = show list only, non-0 means to show a listing.

	// 2b. We still need to get the list of departments.
	$context['depts_list'] = array();
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
		$context['depts_list'][$row['id_dept']] = $row['dept_name'];

	if (empty($_REQUEST['permdept']))
		return $context['dept_list_only'] = true;

	// 2. Get group colours and names.
	$context['membergroups'][0] = array(
		'group_name' => $txt['membergroups_members'],
		'color' => '',
		'link' => $txt['membergroups_members'],
	);

	$query = $smcFunc['db_query']('', '
		SELECT mg.id_group, mg.group_name, mg.online_color
		FROM {db_prefix}membergroups AS mg
		WHERE mg.id_group IN ({array_int:groups})
		ORDER BY id_group',
		array(
			'groups' => $groups,
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$context['membergroups'][$row['id_group']] = array(
			'name' => $row['group_name'],
			'color' => $row['online_color'],
			'link' => '<a href="' . $scripturl . '?action=groups;sa=members;group=' . $row['id_group'] . '"' . (empty($row['online_color']) ? '' : ' style="color: ' . $row['online_color'] . ';"') . '>' . $row['group_name'] . '</a>',
		);
	}

	$smcFunc['db_free_result']($query);

	// 3. Get roles that apply to this user, and figure out their groups as we go.
	$query = $smcFunc['db_query']('', '
		SELECT hdrg.id_role, hdrg.id_group, hdr.template, hdr.role_name, hddr.id_dept
		FROM {db_prefix}helpdesk_role_groups AS hdrg
			INNER JOIN {db_prefix}helpdesk_roles AS hdr ON (hdrg.id_role = hdr.id_role)
			INNER JOIN {db_prefix}helpdesk_dept_roles AS hddr ON (hdr.id_role = hddr.id_role)
		WHERE hdrg.id_group IN ({array_int:groups})
			AND hddr.id_dept = {int:dept}
		ORDER BY hdrg.id_role, hdrg.id_group',
		array(
			'groups' => $groups,
			'dept' => $_REQUEST['permdept'],
		)
	);

	$role_permissions = array();
	$roles = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		if (empty($role_permissions[$row['id_role']]))
			$role_permissions[$row['id_role']] = $context['shd_permissions']['roles'][$row['template']]['permissions'];

		if (!empty($roles[$row['id_role']]))
			$roles[$row['id_role']]['groups'][] = $row['id_group'];
		else
			$roles[$row['id_role']] = array(
				'name' => $row['role_name'],
				'template' => $row['template'],
				'groups' => array($row['id_group']),
			);
	}

	$smcFunc['db_free_result']($query);

	$context['member_roles'] = $roles;

	// 4. Now the hard bit. Figure out what permissions they have.
	$context['member_permissions'] = array(
		'allowed' => array(),
		'denied' => array(),
	);

	if (!empty($roles))
	{
		$query = $smcFunc['db_query']('', '
			SELECT id_role, permission, add_type
			FROM {db_prefix}helpdesk_role_permissions
			WHERE id_role IN ({array_int:roles})',
			array(
				'roles' => array_keys($roles),
			)
		);

		while($row = $smcFunc['db_fetch_assoc']($query))
			$role_permissions[$row['id_role']][$row['permission']] = $row['add_type']; // if it's defined in the DB it's somehow different to what the template so replace the template
	}

	foreach ($role_permissions as $role_id => $permission_set)
	{
		foreach ($permission_set as $permission => $state)
		{
			if ($state == ROLEPERM_ALLOW)
				$context['member_permissions']['allowed'][$permission][] = $role_id;
			elseif ($state == ROLEPERM_DENY)
				$context['member_permissions']['denied'][$permission][] = $role_id;
		}
	}
}

function shd_profile_actionlog($memID)
{
	global $context, $txt, $scripturl, $sourcedir, $user_info, $settings;

	loadTemplate('sd_template/SimpleDesk-Profile');
	shd_load_language('sd_language/SimpleDeskProfile');

	require_once($sourcedir . '/sd_source/Subs-SimpleDeskAdmin.php');
	$context['action_log'] = shd_load_action_log_entries(-1, 10, '', '', 'la.id_member = ' . $memID);
	$context['action_log_count'] = shd_count_action_log_entries('la.id_member = ' . $memID);
	$context['action_full_log'] = allowedTo('admin_forum') || shd_allowed_to('admin_helpdesk', 0);

	$context['page_title'] = $txt['shd_profile_area'] . ' - ' . $txt['shd_profile_actionlog'];
	$context['sub_template'] = 'shd_profile_actionlog';

}

function shd_profile_theme_wrapper($memID)
{
	global $txt, $context, $user_profile, $modSettings, $settings, $user_info, $smcFunc, $sourcedir, $profile_fields;

	loadTemplate('Profile');
	loadTemplate('sd_template/SimpleDesk-Profile');

	$lang_strings = array(
		'current_time', 'theme_info', 'date_format', 'return_to_post', 'timeformat_default', 'theme_forum_default', 'theme_forum_default_desc',
	);

	// Replace the standard profile strings with SD specific ones.
	foreach ($lang_strings as $str)
		$txt[$str] = $txt['shd_' . $str];

	loadThemeOptions($memID);
	if (allowedTo(array('profile_extra_own', 'profile_extra_any')))
		loadCustomFields($memID, 'theme');

	$context['sub_template'] = 'edit_options';
	$context['page_desc'] = $txt['theme_info'];

	$opts = array(
		'id_theme', 'smiley_set', 'hr',
		'time_format', 'time_offset', 'hr',
		'theme_settings',
	);

	if (!empty($modSettings['shd_display_avatar']))
		$opts = array_merge(array('avatar_choice', 'hr'), $opts);

	setupProfileContext($opts);

	$context['profile_fields']['theme_settings']['callback_func'] = 'shd_theme_settings';
}