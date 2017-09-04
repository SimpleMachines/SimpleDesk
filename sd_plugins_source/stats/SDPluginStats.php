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
# File Info: SDPluginFrontPage.php                            #
###############################################################

/**
 *	This file handles the replacement front page.
 *
 *	@package plugin-stats
 *	@since 2.0
 */

if (!defined('SMF'))
	die('Hacking attempt...');

/*
 * Called from the SMF admin menu hook
 */
function shd_stats_adminmenu(&$admin_areas)
{
	global $context, $modSettings, $txt;

	if (allowedTo('admin_forum') && !empty($modSettings['shdp_enable_stats']))
		$admin_areas['helpdesk_info']['areas']['helpdesk_info']['subsections']['stats'] = array($txt['shdp_stats']);
}

function shd_stats_hdadmininfo(&$subactions)
{
	global $context, $modSettings, $txt;

	if (!allowedTo('admin_forum') || empty($modSettings['shdp_enable_stats']))
		return;

	$subactions['stats'] = array(
		'function' => 'shd_stats_source',
		'icon' => '../reports.png',
		'title' => $txt['shdp_stats']
	);

	$context[$context['admin_menu_name']]['tab_data']['tabs']['stats'] = $subactions['stats'];
}

/*
 * The options screen for the stats
 */
function shd_stats_admin($config_vars)
{
	$config_vars[] = '';
	$config_vars[] = array('check', 'shdp_enable_stats');
}

/*
 * The source file for the actual stats page.
 */
function shd_stats_source()
{
	global $modSettings, $context;

	// All possible stat info.
	$stats = array(
		'status',
		'today',
		'most',
		'average',
		'totals',
		'urgency',
		'history',
	);

	// Loop out the stat info.
	$context['shd_stats'] = array();
	foreach ($stats as $function)
	{
		$func = 'shd_stats_' . $function;
		$context['shd_stats'][$function] = $func();

	}

	loadTemplate('sd_plugins_template/SDPluginStats');
}

// This gets our ticket status info.
function shd_stats_status()
{
	global $smcFunc;

	$status = array(
		TICKET_STATUS_NEW => 0,
		TICKET_STATUS_PENDING_STAFF => 0,
		TICKET_STATUS_PENDING_USER => 0,
		TICKET_STATUS_CLOSED => 0,
		TICKET_STATUS_WITH_SUPERVISOR => 0,
		TICKET_STATUS_ESCALATED => 0,
		TICKET_STATUS_DELETED => 0
	);

	// Collect up some numbers.
	$request = $smcFunc['db_query']('', '
		SELECT COUNT(id_ticket) AS count, status
		FROM {db_prefix}helpdesk_tickets
		WHERE status IN ({array_int:status})
		GROUP BY status',
		array(
			'status' => array_keys($status)
	));

	while ($row = $smcFunc['db_fetch_assoc']($request))
		$status[$row['status']] = $row['count'];
	$smcFunc['db_free_result']($request);

	$status['total_open'] = $status[TICKET_STATUS_NEW] + $status[TICKET_STATUS_PENDING_STAFF] + $status[TICKET_STATUS_PENDING_USER] + $status[TICKET_STATUS_WITH_SUPERVISOR] + $status[TICKET_STATUS_ESCALATED];
	$status['total_closed'] = $status[TICKET_STATUS_CLOSED] + $status[TICKET_STATUS_DELETED];

	$status['total_total'] = $status['total_open'] + $status['total_closed'];

	// We are fast.
	if ($status['total_open'] == $status['total_closed'])
		$status['ratio'] = '1:1';
	elseif ($status['total_open'] == 0)
		$status['ratio'] = '0:' . $status['total_closed'];
	elseif ($status['total_closed'] == 0)
		$status['ratio'] = $status['total_open'] . ':0';
	elseif ($status['total_open'] > $status['total_closed'])
		$status['ratio'] = round($status['total_open'] / $status['total_closed']) . ':1';
	elseif ($status['total_open'] < $status['total_closed'])
		$status['ratio'] = '1:' . round($status['total_closed'] / $status['total_open']);

	return $status;
}

// This gets our ticket open/closed info.
function shd_stats_today()
{
	global $smcFunc;

	$actions = array(
		// These are open tickets.
		'newticket' => TICKET_STATUS_NEW,
		'unresolve' => TICKET_STATUS_NEW,

		// These are resolved tickets.
		'resolve' => TICKET_STATUS_CLOSED,
	);

	$totals = array(
		TICKET_STATUS_NEW => 0,
		TICKET_STATUS_CLOSED => 0,
	);

	$request = $smcFunc['db_query']('', '
		SELECT COUNT(la.id_ticket) AS count, t.status
		FROM {db_prefix}helpdesk_log_action AS la
			INNER JOIN {db_prefix}helpdesk_tickets AS t ON (la.id_ticket = t.id_ticket)
		WHERE la.action IN ({array_string:actions})
			AND la.log_time > {int:today}
		GROUP BY la.action, t.status',
		array(
			'actions' => array_keys($actions),
			// we could use strtotime from a date(n j Y), but this seems safer calculations
			'today' => mktime(0, 0, 0, date('n'), date('j'), date('Y'))
	));

	while ($row = $smcFunc['db_fetch_assoc']($request))
		$totals[$row['status']] = $row['count'];
	$smcFunc['db_free_result']($request);

	return $totals;
}

// This gets our ticket open/closed info.
function shd_stats_most()
{
	global $smcFunc;

	$actions = array(
		TICKET_STATUS_NEW => array('newticket'),
		TICKET_STATUS_CLOSED => array('resolve')
	);

	$most = array(
		TICKET_STATUS_NEW => array(0, 0),
		TICKET_STATUS_CLOSED => array(0, 0),
	);

	foreach ($actions as $action)
	{
		$request = $smcFunc['db_query']('', '
			SELECT COUNT(la.id_ticket) AS count, t.status, log_time
			FROM {db_prefix}helpdesk_log_action AS la
				INNER JOIN {db_prefix}helpdesk_tickets AS t ON (la.id_ticket = t.id_ticket)
			WHERE la.action IN ({array_string:actions})
			GROUP BY unix_timestamp() - log_time < {int:24hrs} AND unix_timestamp() - log_time + {int:24hrs} > 0
			ORDER BY count DESC
			LIMIT 1',
			array(
				'actions' => $action,
				'24hrs' => 86400,
		));

		while ($row = $smcFunc['db_fetch_assoc']($request))
			$most[$row['status']] = array($row['count'], $row['log_time']);
		$smcFunc['db_free_result']($request);
	}

	return $most;
}

// This gets our ticket open/closed info.
function shd_stats_average()
{
	global $smcFunc;

	$actions = array(
		TICKET_STATUS_NEW => array('newticket', 'unresolve'),
		TICKET_STATUS_CLOSED => array('resolve'),
		TICKET_STATUS_PENDING_STAFF => array('assign'),
	);

	$average = array(
		TICKET_STATUS_NEW => 0,
		TICKET_STATUS_CLOSED => 0,
		TICKET_STATUS_PENDING_STAFF => 0,
	);

	foreach ($actions as $action)
	{
		$request = $smcFunc['db_query']('', '
			SELECT AVG(la.id_ticket) AS count, t.status
			FROM {db_prefix}helpdesk_log_action AS la
				INNER JOIN {db_prefix}helpdesk_tickets AS t ON (la.id_ticket = t.id_ticket)
			WHERE la.action IN ({array_string:actions})
			GROUP BY t.status',
			array(
				'actions' => $action,
				'24hrs' => 86400,
		));

		while ($row = $smcFunc['db_fetch_assoc']($request))
			$average[$row['status']] = $row['count'];
		$smcFunc['db_free_result']($request);
	}

	return $average;
}

// This gets our user info.
function shd_stats_totals()
{
	global $smcFunc;

	// Count Admins separately for now.!
	$admins = array();
	$request = $smcFunc['db_query']('', '
		SELECT id_member
		FROM {db_prefix}members
		WHERE id_group = {int:admin} OR FIND_IN_SET({int:admin}, additional_groups)',
		array(
			'admin' => 1
	));

	while ($row = $smcFunc['db_fetch_assoc']($request))
		$admins[] = $row['id_member'];
	$smcFunc['db_free_result']($request);

	// @TODO: This most likely will filesort and be slow on large helpdesks.
	$request = $smcFunc['db_query']('', '
		SELECT COUNT(mem.id_member) AS count, hdr.template
		FROM {db_prefix}members AS mem
			INNER JOIN {db_prefix}helpdesk_role_groups AS hdrg ON (mem.id_group = hdrg.id_group OR FIND_IN_SET(hdrg.id_group, mem.additional_groups))
			INNER JOIN {db_prefix}helpdesk_roles AS hdr ON (hdrg.id_role = hdr.id_role)
		WHERE mem.id_member NOT IN ({array_int:admins})
		GROUP BY hdr.template',
		array(
			'admins' => $admins
	));

	$totals = array(
		ROLE_USER => 0,
		ROLE_STAFF => 0,
//		ROLE_SUPERVISOR => 0,
		ROLE_ADMIN => 0
	);

	while ($row = $smcFunc['db_fetch_assoc']($request))
		$totals[$row['template']] = $row['count'];
	$smcFunc['db_free_result']($request);

	// Add in the admins.
	if (empty($totals[ROLE_ADMIN]))
		$totals[ROLE_ADMIN] += count($admins);

	return $totals;
}

// This gets our urgency.
function shd_stats_urgency()
{
	global $smcFunc;

	$urgency = array(
		TICKET_URGENCY_LOW => 0,
		TICKET_URGENCY_MEDIUM => 0,
		TICKET_URGENCY_HIGH => 0,
		TICKET_URGENCY_VHIGH => 0,
		TICKET_URGENCY_SEVERE => 0,
		TICKET_URGENCY_CRITICAL => 0,
	);

	// We reformat it now.
	$urgency = array(
		'open' => $urgency,
		'closed' => $urgency
	);

	// Open or closed is all we need to know.
	$status = array(
		TICKET_STATUS_NEW => 'open',
		TICKET_STATUS_PENDING_STAFF => 'open',
		TICKET_STATUS_PENDING_USER => 'open',
		TICKET_STATUS_CLOSED => 'closed',
		TICKET_STATUS_WITH_SUPERVISOR => 'open',
		TICKET_STATUS_ESCALATED => 'open',
		TICKET_STATUS_DELETED => 'closed',
	);

	// Collect up some numbers.
	$request = $smcFunc['db_query']('', '
		SELECT COUNT(id_ticket) AS count, urgency, status
		FROM {db_prefix}helpdesk_tickets
		WHERE urgency IN ({array_string:urgency})
		GROUP BY urgency, status',
		array(
			'urgency' => array_keys($urgency)
	));

	while ($row = $smcFunc['db_fetch_assoc']($request))
		$urgency[$status[$row['status']]][$row['urgency']] = $row['count'];
	$smcFunc['db_free_result']($request);

	return $urgency;
}

// Time to become Archeologists.
function shd_stats_history()
{
	global $smcFunc;

	// What tasks we want to perform.
	$tasks = array(
		'open' => 0,
		'resolved' => 0,
		'assigned' => 0,
		'reopen' => 0,
		'child' => array(),
	);

	$conversion = array(
		'newticket' => 'open',
		'assign' => 'assigned',
		'resolve' => 'resolved',
	);

	// @TODO: In future, use ajax to support selecting years/months totals
	$request = $smcFunc['db_query']('', '
		SELECT log_time, action
		FROM {db_prefix}helpdesk_log_action');

	$history = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		list($year, $month, $day) = explode(' ', date('Y m d', $row['log_time']));

		// If only we had to do this once a year.
		if (!isset($history[$year]))
			$history[$year] = $tasks;
		$history[$year][$conversion[$row['action']]] += 1;

		// Now we do the monthly stats
		if (!isset($history[$year]['child'][$month]))
			$history[$year]['child'][$month] = $tasks;
		$history[$year]['child'][$month][$conversion[$row['action']]] += 1;

		// For day we just simply do it.
		if (!isset($history[$year]['child'][$month]['child'][$day]))
			$history[$year]['child'][$month]['child'][$day] = $tasks;
		$history[$year]['child'][$month]['child'][$day][$conversion[$row['action']]] += 1;
	}
	$smcFunc['db_free_result']($request);

	// We now return to the history channel.
	return $history;
}