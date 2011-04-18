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
# File Info: Subs-SimpleDesk.php / 1.0 Felidae                #
###############################################################

/**
 *	This file handles key functions for SimpleDesk that can be called on every page load, such as the
 *	custom query function to handle ticket visibility, the counter for active tickets in the menu header, or the action log.
 *
 *	@package subs
 *	@since 1.0
 */

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Initialises key values for SimpleDesk.
 *
 *	This function initialises certain key constructs for SimpleDesk, such as constants, that are used throughout
 *	SimpleDesk. It should be called first right up in Load.php anyway.
 *
 *	Calling multiple times is not significantly detrimental to performance; the function is aware if it has been
 *	called previously.
 *
 *	@since 1.1
*/
function shd_init()
{
	global $modSettings, $sourcedir, $user_info, $context, $smcFunc;
	static $called = null;

	if (!empty($called))
		return;

	$called = true;

	// What SD version are we on? It's now here!
	define('SHD_VERSION', 'SimpleDesk 1.0 Felidae');

	// This isn't the SMF way. But for something like this, it's way way more logical and readable.
	define('TICKET_STATUS_NEW', 0);
	define('TICKET_STATUS_PENDING_STAFF', 1);
	define('TICKET_STATUS_PENDING_USER', 2);
	define('TICKET_STATUS_CLOSED', 3);
	define('TICKET_STATUS_WITH_SUPERVISOR', 4);
	define('TICKET_STATUS_ESCALATED', 5);
	define('TICKET_STATUS_DELETED', 6);

	define('TICKET_URGENCY_LOW', 0);
	define('TICKET_URGENCY_MEDIUM', 1);
	define('TICKET_URGENCY_HIGH', 2);
	define('TICKET_URGENCY_VHIGH', 3);
	define('TICKET_URGENCY_SEVERE', 4);
	define('TICKET_URGENCY_CRITICAL', 5);

	define('MSG_STATUS_NORMAL', 0);
	define('MSG_STATUS_DELETED', 1);

	define('RELATIONSHIP_LINKED', 0);
	define('RELATIONSHIP_DUPLICATED', 1);
	define('RELATIONSHIP_ISPARENT', 2);
	define('RELATIONSHIP_ISCHILD', 3);

	define('CFIELD_TICKET', 1);
	define('CFIELD_REPLY', 2);

	define('CFIELD_PLACE_DETAILS', 1);
	define('CFIELD_PLACE_INFO', 2);
	define('CFIELD_PLACE_PREFIX', 3);

	define('CFIELD_TYPE_TEXT', 1);
	define('CFIELD_TYPE_LARGETEXT', 2);
	define('CFIELD_TYPE_INT', 3);
	define('CFIELD_TYPE_FLOAT', 4);
	define('CFIELD_TYPE_SELECT', 5);
	define('CFIELD_TYPE_CHECKBOX', 6);
	define('CFIELD_TYPE_RADIO', 7);

	define('ROLE_USER', 1);
	define('ROLE_STAFF', 2);
	//define('ROLE_SUPERVISOR', 3);
	define('ROLE_ADMIN', 4);

	define('ROLEPERM_DISALLOW', 0);
	define('ROLEPERM_ALLOW', 1);
	define('ROLEPERM_DENY', 2);

	// Load some stuff
	shd_load_language('SimpleDesk');
	require($sourcedir . '/sd_source/Subs-SimpleDeskPermissions.php');

	// Set up defaults
	$defaults = array(
		'shd_attachments_mode' => 'ticket',
		'shd_ticketnav_style' => 'sd',
		'shd_staff_badge' => 'nobadge',
		'shd_privacy_display' => 'smart',
	);

	foreach ($defaults as $var => $val)
	{
		if (empty($modSettings[$var]))
			$modSettings[$var] = $val;
	}

	$modSettings['helpdesk_active'] = isset($modSettings['admin_features']) ? in_array('shd', explode(',', $modSettings['admin_features'])) : false;

	shd_load_user_perms();

	if (!empty($modSettings['shd_maintenance_mode']))
		$modSettings['helpdesk_active'] &= ($user_info['is_admin'] || shd_allowed_to('admin_helpdesk', 0));

	// Call for any init level hooks and last minute stuff
	if ($modSettings['helpdesk_active'])
	{
		shd_load_plugin_files('init');
		shd_load_plugin_langfiles('init');

		// Are they actually going into the helpdesk? If they are, do we need to deal with their theme?
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'helpdesk')
		{
			// First figure out what department they're in.
			$this_dept = 0;
			$depts = shd_allowed_to('access_helpdesk', false);
			// Do they only have one dept? If so, that's the one.
			if (count($depts) == 1)
				$this_dept = $depts[0];
			// They might explicitly say it on the request.
			elseif (isset($_REQUEST['dept']))
			{
				$_REQUEST['dept'] = (int) $_REQUEST['dept'];
				if (in_array($_REQUEST['dept'], $depts))
					$this_dept = $_REQUEST['dept'];
			}
			// They might explicitly be posting into a dept from nowhere-land
			elseif (isset($_REQUEST['newdept']))
			{
				$_REQUEST['newdept'] = (int) $_REQUEST['newdept'];
				if (in_array($_REQUEST['newdept'], $depts))
					$this_dept = $_REQUEST['newdept'];
			}
			// They might specify a ticket, see if we can get the dept from that. Validate we can see it and get the dept from there.
			elseif (isset($_REQUEST['ticket']))
			{
				$ticket = (int) $_REQUEST['ticket'];
				if (!empty($ticket))
				{
					$query = shd_db_query('', '
						SELECT id_dept
						FROM {db_prefix}helpdesk_tickets
						WHERE id_ticket = {int:ticket}
							AND {query_see_ticket}',
						array(
							'ticket' => $ticket,
						)
					);
					if ($row = $smcFunc['db_fetch_row']($query))
						if (in_array($row[0], $depts))
							$this_dept = $row[0];
					$smcFunc['db_free_result']($query);
				}
			}

			if (!empty($this_dept))
			{
				$query = $smcFunc['db_query']('', '
					SELECT dept_theme
					FROM {db_prefix}helpdesk_depts
					WHERE id_dept = {int:dept}',
					array(
						'dept' => $this_dept,
					)
				);
				if ($row = $smcFunc['db_fetch_row']($query))
					$theme = $row[0];
				$smcFunc['db_free_result']($query);
			}

			// If for whatever reason we didn't establish a theme, see if there's a forum default one.
			if (empty($theme) && !empty($modSettings['shd_theme']))
				$theme = $modSettings['shd_theme'];
			// Action.
			if (!empty($theme))
			{
				// This is ever so slightly hacky. But as this function is called sufficiently early we can get away with it.
				unset($_REQUEST['theme'], $modSettings['theme_allow']);
				$modSettings['theme_guests'] = $theme;
			}
		}
	}

	$context['shd_plugins'] = empty($modSettings['shd_enabled_plugins']) || empty($modSettings['helpdesk_active']) ? array() : explode(',', $modSettings['shd_enabled_plugins']);
}

/**
 *	Query wrapper around $smcFunc['db_query'] for helpdesk specific operations.
 *
 *	This function provides a basic wrapper around SMF's internal $smcFunc['db_query'] function, adding the parameter {query_see_ticket}
 *	to it, specifically so that ticket visibility can be enforced in a query without being aware of the specific rules for the user.
 *
 *	If not previously loaded, user permissions are loaded with {@link shd_load_user_perms()}.
 *
 *	@param string $identifier SMF-style query identifier for database backend-specific replacements
 *	@param string $db_string Standard SMF 2.0 style database query, including {query_see_ticket} if appropriate
 *	@param array $db_values Standard SMF 2.0 style hash map of parameters to inject into the query
 *	@param resource $connection A database connection variable, if supplied, to override the one used by SMF by default
 *	@return resource Standard database query resource, suitable for processing with other $smcFunc['db_*'] functions
 *
 *	@see shd_load_user_perms()
 *	@since 1.0
*/
function shd_db_query($identifier, $db_string, $db_values = array(), $connection = null)
{
	global $user_info, $smcFunc;

	$replacements = array(
		'{query_see_ticket}' => $user_info['query_see_ticket'],
	);

	$db_string = str_replace(array_keys($replacements), array_values($replacements), $db_string);
	$db_values['user_info_id'] = $user_info['id'];

	return $smcFunc['db_query']($identifier, $db_string, $db_values, $connection);
}

/**
 *	Defines the helpdesk menu item, including the number of active tickets to be displayed to the user.
 *
 *	Identifies the number of tickets that a user might be interested in, and generates the menu text for the main menu
 *	to include this; note that the value should be cached through SMF's functions. The cache is also clearable, through
 *	the {@link shd_clear_active_tickets()} function.
 *
 *	@return string A formatted string containing the language-specific version of "Helpdesk [x]" menu item with the x in bold
 *	@see shd_clear_active_tickets()
 *	@since 1.0
*/
function shd_get_active_tickets()
{
	global $modSettings, $user_info, $smcFunc, $context, $txt;

	if (empty($txt['shd_helpdesk'])) // provide a last-ditch fallback in the event we can't even find the file; SimpleDesk.{language}.php should be loaded by now (falling back to english if lang-specific doesn't exist)
		$txt['shd_helpdesk'] = 'Helpdesk';

	if (!$modSettings['helpdesk_active'] || $context['user']['is_guest'])
		return $txt['shd_helpdesk'];

	// Have we already run on this page? If so we already have the answer.
	if (!empty($context['active_tickets']))
		return $txt['shd_helpdesk'] . $context['active_tickets'];

	// Can we get it from the cache?
	$temp = cache_get_data('shd_active_tickets_' . $user_info['id'], 180);
	if ($temp !== null)
	{
		list($context['active_tickets'], $context['active_tickets_raw']) = $temp;
		$context['menu_buttons']['helpdesk']['alttitle'] = $txt['shd_helpdesk'] . !empty($context['active_tickets_raw']) ? (' [' . $context['active_tickets_raw'] . ']') : '';
		return $txt['shd_helpdesk'] . $context['active_tickets'];
	}

	shd_init();
	// Figure out the status(es) that the ticket could be.
	if (shd_allowed_to('shd_staff', 0))
		$status = array(TICKET_STATUS_NEW, TICKET_STATUS_PENDING_STAFF); // staff actually need to deal with these
	else
		$status = array(TICKET_STATUS_PENDING_USER); // user actually needs to deal with this

	$query = shd_db_query('', '
		SELECT COUNT(id_ticket)
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket} AND status IN ({array_int:status})',
		array(
			'status' => $status,
		)
	);

	$context['active_tickets_raw'] = 0;

	$row = $smcFunc['db_fetch_row']($query);
	if (!empty($row[0]))
	{
		$context['menu_buttons']['helpdesk']['alttitle'] = $txt['shd_helpdesk'] . ' [' . $row[0] . ']';
		$context['active_tickets'] = ' [<strong>' . $row[0] . '</strong>]';
		$context['active_tickets_raw'] = $row[0]; // in case you want to do something funky in the theme later?
	}
	else
		$context['active_tickets'] = '';

	cache_put_data('shd_active_tickets_' . $user_info['id'], array($context['active_tickets'], $context['active_tickets_raw']), 120);

	return $txt['shd_helpdesk'] . $context['active_tickets'];
}

/**
 *	Clears the cache of active tickets for the menu item.
 *
 *	{@link shd_get_active_tickets()} generates the number of active tickets for the user display, and caches it for 180 seconds
 *	normally. This function clears the cache and should be called whenever any operation modifies the state of a ticket.
 *
 *	@see shd_get_active_tickets()
 *	@since 1.0
*/
function shd_clear_active_tickets($id = 0)
{
	global $user_info;

	$members = shd_members_allowed_to('shd_staff');
	if ($id != 0)
		$members[] = $id;

	$members[] = $user_info['id'];

	$members = array_unique($members);

	foreach ($members as $member)
	{
		cache_put_data('shd_active_tickets_' . $member, null, 0);
		cache_put_data('shd_ticket_count_' . $member, null, 0);
	}
}

/**
 *	Adds an action to the helpdesk internal action log.
 *
 *	This function deals with adding items to the action log maintained by the helpdesk.
 *
 *	@param string $action Specifies the name of the action to log, which implies the image and language string (log_$action is the name of the image, and $txt['shd_log_$action'] is the string used to express the action, as listed in {@link SimpleDeskLogAction.english.php}.
 *	Note that since 1.1, the list of actions is looked up against the options in Admin / Helpdesk / Options / Action Log Options as to whether they should be logged or not
 *	@param array $params This is a list of named parameters in a hash array to be used in the language string later.
 *
 *	@see shd_load_action_log_entries()
 *	@since 1.0
*/
function shd_log_action($action, $params)
{
	global $smcFunc, $context, $user_info, $modSettings;
	static $last_cache;

	// Before we go any further, we use this function to globally update tickets' last updated time (since every ticket action should potentially
	// be logged) - but we don't do the query *every* time if we don't need to. Allows a two second leeway.

	if (isset($params['ticket']) && ((int) $params['ticket'] != 0) && (empty($last_cache[$params['ticket']]) || $last_cache[$params['ticket']] < time() - 2))
	{
		$last_cache[$params['ticket']] = time();
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET last_updated = {int:new_time}
			WHERE id_ticket = {int:ticket}',
			array(
				'new_time' => $last_cache[$params['ticket']],
				'ticket' => $params['ticket'],
			)
		);
	}

	if (!empty($modSettings['shd_disable_action_log']))
		return;

	// Check to see if we should actually log this action or not.
	$logopt = array(
		'newticket' => 'shd_logopt_newposts',
		'newticketproxy' => 'shd_logopt_newposts',
		'editticket' => 'shd_logopt_editposts',
		'newreply' => 'shd_logopt_newposts',
		'editreply' => 'shd_logopt_editposts',
		'resolve' => 'shd_logopt_resolve',
		'unresolve' => 'shd_logopt_resolve',
		'assign' => 'shd_logopt_assign',
		'unassign' => 'shd_logopt_assign',
		'markprivate' => 'shd_logopt_privacy',
		'marknotprivate' => 'shd_logopt_privacy',
		'urgency_increase' => 'shd_logopt_urgency',
		'urgency_decrease' => 'shd_logopt_urgency',
		'tickettotopic' => 'shd_logopt_tickettopicmove',
		'topictoticket' => 'shd_logopt_tickettopicmove',
		'delete' => 'shd_logopt_delete',
		'delete_reply' => 'shd_logopt_delete',
		'restore' => 'shd_logopt_restore',
		'restore_reply' => 'shd_logopt_restore',
		'permadelete' => 'shd_logopt_permadelete',
		'permadelete_reply' => 'shd_logopt_permadelete',
		'rel_linked' => 'shd_logopt_relationships',
		'rel_duplicated' => 'shd_logopt_relationships',
		'rel_parent' => 'shd_logopt_relationships',
		'rel_child' => 'shd_logopt_relationships',
		'rel_re_linked' => 'shd_logopt_relationships',
		'rel_re_duplicated' => 'shd_logopt_relationships',
		'rel_re_parent' => 'shd_logopt_relationships',
		'rel_re_child' => 'shd_logopt_relationships',
		'rel_delete' => 'shd_logopt_relationships',
		'cf_tktchange_admin' => 'shd_logopt_cfchanges',
		'cf_tktchange_staffadmin' => 'shd_logopt_cfchanges',
		'cf_tktchange_useradmin' => 'shd_logopt_cfchanges',
		'cf_tktchange_userstaffadmin' => 'shd_logopt_cfchanges',
		'cf_rplchange_admin' => 'shd_logopt_cfchanges',
		'cf_rplchange_staffadmin' => 'shd_logopt_cfchanges',
		'cf_rplchange_useradmin' => 'shd_logopt_cfchanges',
		'cf_rplchange_userstaffadmin' => 'shd_logopt_cfchanges',
		'cf_tktchgdef_admin' => 'shd_logopt_cfchanges',
		'cf_tktchgdef_staffadmin' => 'shd_logopt_cfchanges',
		'cf_tktchgdef_useradmin' => 'shd_logopt_cfchanges',
		'cf_tktchgdef_userstaffadmin' => 'shd_logopt_cfchanges',
		'cf_rplchgdef_admin' => 'shd_logopt_cfchanges',
		'cf_rplchgdef_staffadmin' => 'shd_logopt_cfchanges',
		'cf_rplchgdef_useradmin' => 'shd_logopt_cfchanges',
		'cf_rplchgdef_userstaffadmin' => 'shd_logopt_cfchanges',
		'move_dept' => 'shd_logopt_move_dept',
		//'split_origin' => 'shd_logopt_split',
		//'split_new' => 'shd_logopt_split',
	);

	if (empty($logopt[$action]) || empty($modSettings[$logopt[$action]]))
		return;

	// Some parts of $params we will want in the main row for sorting + lookups later. Let's see if they're here.
	if (!empty($params['ticket']))
	{
		$ticket_id = (int) $params['ticket'];
		if ($ticket_id == 0)
			trigger_error('log_action(): received data with non-numeric ticket', E_USER_NOTICE);
		else
			unset($params['ticket']);
	}
	else
		$ticket_id = 0;

	if (!empty($params['msg']))
	{
		$msg_id = (int) $params['msg'];
		if ($msg_id == 0)
			trigger_error('log_action(): received data with non-numeric msg', E_USER_NOTICE);
		else
			unset($params['msg']);
	}
	else
		$msg_id = 0;

	$smcFunc['db_insert']('',
		'{db_prefix}helpdesk_log_action',
		array(
			'log_time' => 'int', 'id_member' => 'int', 'ip' => 'string-16', 'action' => 'string', 'id_ticket' => 'int', 'id_msg' => 'int', 'extra' => 'string-65534',
		),
		array(
			time(), $user_info['id'], $user_info['ip'], $action, $ticket_id, $msg_id, serialize($params),
		),
		array('id_action')
	);
}

/**
 *	Determines if the current user can raise/lower the urgency of a ticket.
 *
 *	This function identifies whether the current user can raise or lower the urgency of a ticket based on the current urgency
 *	of the ticket and whether it is their ticket; this is used in the ticket display as well as the actions linked directly to
 *	modifying urgency (both AJAXively and non AJAXively)
 *
 *	@param int $urgency The current urgency of a ticket as an integer
 *	@param bool $ticket_starter Whether the user in question is the starter of the ticket (instead of querying to establish that,
 *	that detail should already be known to the calling function)
 *	@param bool $closed Whether the ticket is currently closed or not
 *	@param bool $deleted Whether the ticket is currently closed or not
 *
 *	@see shd_urgency_change_noajax()
 *	@since 1.0
*/
function shd_can_alter_urgency($urgency, $ticket_starter, $closed, $deleted, $dept)
{
	global $user_info;

	$can_urgency = array(
		'increase' => false,
		'decrease' => false,
	);

	if ($closed || $deleted)
		return $can_urgency;

	if (shd_allowed_to('shd_alter_urgency_any', $dept))
	{
		if (shd_allowed_to('shd_alter_urgency_higher_any', $dept) || (shd_allowed_to('shd_alter_urgency_higher_own', $dept) && $ticket_starter == $user_info['id']))
			$can_urgency = array( // can alter any urgency and can alter this one's higher urgency too
				'increase' => ($urgency < TICKET_URGENCY_CRITICAL),
				'decrease' => ($urgency > TICKET_URGENCY_LOW),
			);
		else
			$can_urgency = array( // can alter any base urgency - just not this one's higher urgency
				'increase' => ($urgency < TICKET_URGENCY_HIGH),
				'decrease' => ($urgency > TICKET_URGENCY_LOW && $urgency < TICKET_URGENCY_VHIGH),
			);
	}
	elseif (shd_allowed_to('shd_alter_urgency_own', $dept) && $ticket_starter == $user_info['id'])
		$can_urgency = array( // ok, so this is our ticket and we can change it
			'increase' => ($urgency < (shd_allowed_to('shd_alter_urgency_higher_own', $dept) ? TICKET_URGENCY_CRITICAL : TICKET_URGENCY_HIGH)),
			'decrease' => ($urgency > TICKET_URGENCY_LOW && $urgency <= (shd_allowed_to('shd_alter_urgency_higher_own', $dept) ? TICKET_URGENCY_CRITICAL : TICKET_URGENCY_VHIGH)),
		);

	return $can_urgency;
}

/**
 *	Queries the database to find the number of applicable tickets
 *
 *	This function collects counts for the different states of tickets (new, with staff, with user, etc) of all the tickets
 *	visible to the user, and returns a selection of that dataset based on the values provided to $status and $is_staff.
 *
 *	@param string $status The relevant count of tickets to return:
 *	<ul>
 *	<li>'open': All tickets currently open that the user can see</li>
 *	<li>'assigned': All tickets assigned to the current user</li>
 *	<li>'new': All the new tickets that the user can see</li>
 *	<li>'staff': All the tickets currently with staff (varies for staff vs user; user count here includes 'new' tickets)</li>
 *	<li>'with_user': All the tickets pending user comment</li>
 *	<li>'closed': All the tickets the user can see that are resolved</li>
 *	<li>'recycled': All the tickets the user can see that are currently in the recycle bin</li>
 *	<li>'withdeleted': All the tickets that have at least one deleted reply</li>
 *	<li>'' or unspecified: Return the total of all tickets in the helpdesk (subject to visibility)</li>
 *	</ul>
 *	@param bool $is_staff If the user in question is staff or not.
 *
 *	@return int Number of applicable tickets.
 *	@since 1.0
*/
function shd_count_helpdesk_tickets($status = '', $is_staff = false)
{
	global $smcFunc, $context, $user_info;

	if (empty($context['ticket_count']))
	{
		$context['ticket_count'] = array();
		for ($i = 0; $i <= 6; $i++)
			$context['ticket_count'][$i] = 0; // set the count to zero for all known states

		$temp = cache_get_data('shd_ticket_count_' . $user_info['id'], 180);
		if ($temp !== null)
		{
			$context['ticket_count'] = $temp;
		}
		else
		{
			$query = shd_db_query('', '
				SELECT status, COUNT(status) AS tickets
				FROM {db_prefix}helpdesk_tickets AS hdt
				WHERE {query_see_ticket}
				GROUP BY status
				ORDER BY null',
				array()
			);

			while ($row = $smcFunc['db_fetch_assoc']($query))
				$context['ticket_count'][$row['status']] = $row['tickets'];

			$smcFunc['db_free_result']($query);

			$context['ticket_count']['assigned'] = 0;
			if (shd_allowed_to('shd_staff', 0))
			{
				$query = shd_db_query('', '
					SELECT status, COUNT(status) AS tickets
					FROM {db_prefix}helpdesk_tickets AS hdt
					WHERE {query_see_ticket}
						AND id_member_assigned = {int:user}
					GROUP BY status
					ORDER BY null',
					array(
						'user' => $context['user']['id'],
					)
				);

				while ($row = $smcFunc['db_fetch_assoc']($query))
				{
					if (!in_array($row['status'], array(TICKET_STATUS_CLOSED, TICKET_STATUS_DELETED)))
					{
						$context['ticket_count']['assigned'] += $row['tickets'];
						$context['ticket_count'][$row['status']] -= $row['tickets'];
					}
				}

				$smcFunc['db_free_result']($query);
			}

			if (shd_allowed_to('shd_access_recyclebin'))
			{
				$query = shd_db_query('', '
					SELECT COUNT(id_ticket) AS tickets
					FROM {db_prefix}helpdesk_tickets AS hdt
					WHERE {query_see_ticket}
						AND hdt.withdeleted = {int:has_deleted}
						AND hdt.status != {int:ticket_deleted}',
					array(
						'has_deleted' => MSG_STATUS_DELETED,
						'ticket_deleted' => TICKET_STATUS_DELETED, // we want all non deleted tickets with deleted replies
					)
				);
				list($count) = $smcFunc['db_fetch_row']($query);
				$smcFunc['db_free_result']($query);

				$context['ticket_count']['withdeleted'] = $count;
			}
			else
				$context['ticket_count']['withdeleted'] = 0;

			cache_put_data('shd_ticket_count_' . $user_info['id'], $context['ticket_count'], 180);
		}
	}

	switch($status)
	{
		case 'open':
			return (
				$context['ticket_count'][TICKET_STATUS_NEW] +
				$context['ticket_count'][TICKET_STATUS_PENDING_STAFF] +
				$context['ticket_count'][TICKET_STATUS_PENDING_USER] +
				$context['ticket_count'][TICKET_STATUS_WITH_SUPERVISOR] +
				$context['ticket_count'][TICKET_STATUS_ESCALATED] +
				$context['ticket_count']['assigned']
			);
		case 'assigned':
			return $context['ticket_count']['assigned'];
		case 'new':
			return $context['ticket_count'][TICKET_STATUS_NEW];
		case 'staff':
			return $is_staff ? $context['ticket_count'][TICKET_STATUS_PENDING_STAFF] : ($context['ticket_count'][TICKET_STATUS_NEW] + $context['ticket_count'][TICKET_STATUS_PENDING_STAFF]); // both "new" and "with staff" should appear as 'with staff' to non staff
		case 'with_user':
			return $context['ticket_count'][TICKET_STATUS_PENDING_USER];
		case 'closed':
			return $context['ticket_count'][TICKET_STATUS_CLOSED];
		case 'recycled':
			return $context['ticket_count'][TICKET_STATUS_DELETED];
		case 'withdeleted':
			return $context['ticket_count']['withdeleted'];
		default:
			return array_sum($context['ticket_count']) - $context['ticket_count']['withdeleted']; // since withdeleted is the only duplicate information, all the rest is naturally self-exclusive
	}
}

/**
 *	Attempts to load a given ticket's data.
 *
 *	This function permission-checks, and throws appropriate errors if no ticket is specified either directly or through URL,
 *	or if the ticket is not accessible either through deletion or lack of permissions.
 *
 *	@param int $ticket The ticket to use; if none is specified, use the one from $_REQUEST['ticket'], which will have been processed
 *	into $context['ticket_id'] if it is available.
 *
 *	@return array A large hash map stating many ticket details
 *	@since 1.0
*/
function shd_load_ticket($ticket = 0)
{
	global $context, $smcFunc, $scripturl;

	// Make sure they set a ticket ID.
	if ($ticket == 0 && empty($context['ticket_id']))
		fatal_lang_error('shd_no_ticket', false);

	// Get the ticket data. Note this implicitly checks perms too.
	$query = shd_db_query('', '
		SELECT hdt.id_first_msg, hdt.id_last_msg, hdt.id_member_started, hdt.subject, hdt.urgency, hdt.status,
			hdt.num_replies, hdt.deleted_replies, hdt.private, hdtr.body, hdtr.id_member, hdtr.poster_time,
			hdtr.modified_time, hdtr.smileys_enabled, hdt.id_dept AS dept, hdd.dept_name,
			IFNULL(mem.real_name, hdtr.poster_name) AS starter_name, IFNULL(mem.id_member, 0) AS starter_id, hdtr.poster_ip AS starter_ip,
			IFNULL(ma.real_name, 0) AS assigned_name, IFNULL(ma.id_member, 0) AS assigned_id,
			IFNULL(mm.real_name, hdtr.modified_name) AS modified_name, IFNULL(mm.id_member, 0) AS modified_id
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdt.id_first_msg = hdtr.id_msg)
			INNER JOIN {db_prefix}helpdesk_depts AS hdd ON (hdt.id_dept = hdd.id_dept)
			LEFT JOIN {db_prefix}members AS mem ON (hdt.id_member_started = mem.id_member)
			LEFT JOIN {db_prefix}members AS ma ON (hdt.id_member_assigned = ma.id_member)
			LEFT JOIN {db_prefix}members AS mm ON (hdtr.modified_member = mm.id_member)
		WHERE {query_see_ticket} AND hdt.id_ticket = {int:ticket}',
		array(
			'ticket' => $ticket == 0 ? $context['ticket_id'] : $ticket,
		)
	);

	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_no_ticket', false);
	}

	$ticketinfo = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	// Anything else we'll use a lot?
	$ticketinfo['is_own'] = ($context['user']['id'] == $ticketinfo['starter_id']);
	$ticketinfo['closed'] = $ticketinfo['status'] == TICKET_STATUS_CLOSED;
	$ticketinfo['deleted'] = $ticketinfo['status'] == TICKET_STATUS_DELETED;

	return $ticketinfo;
}

/**
 *	Formats a string for bbcode and/or smileys.
 *
 *	Formatting is done according to the supplied settings and the master administration settings. It also deals with conversion of wiki links to tickets.
 *
 *	@param string $text Raw text with optional bbcode formatting
 *	@param bool $smileys Whether smileys should be used; this is not an override to the master administration setting of
 *	whether to use smileys or not, and that takes precedence.
 *	@param string $cache If specified, this will provide the cache'd id that SMF should use to cache the output if it is suitably large.
 *
 *	@return string Will return $text as processed for bbcode (if $modSettings['shd_allow_ticket_bbc'] permits) and smileys (if
 *	$modSettings['shd_allow_ticket_smileys'] and $smileys permits)
 *	@since 1.0
*/
function shd_format_text($text, $smileys = true, $cache = '')
{
	global $modSettings, $scripturl, $smcFunc;
	static $wikilinks = array();
	static $smf_disabled = false, $shd_disabled = false;

	if (empty($modSettings['shd_allow_ticket_bbc']))
	{
		if (!empty($modSettings['shd_allow_ticket_smileys']) && $smileys)
			parsesmileys($text);
	}
	else
	{
		// Figure out what's disabled, if anything, and do a bait'n'switch
		if ($smf_disabled === false)
		{
			$original_tags = parse_bbc(false);
			$tags = array();
			foreach ($original_tags as $smf_tag)
			{
				if (!isset($tags[$smf_tag['tag']]))
					$tags[$smf_tag['tag']] = true;
			}

			// See what tagz we can haz.
			if (!empty($modSettings['shd_enabled_bbc']))
				$enabled_tags = explode(',', $modSettings['shd_enabled_bbc']);
			else
				$enabled_tags = array(false);

			$disabled_tags = array_diff(array_keys($tags), $enabled_tags); // this gets us what's present in SMF but not enabled by SD
			$disabled_tags[] = '_SHD_DUMMY_TAG';
			$smf_disabled = isset($modSettings['disabledBBC']) ? $modSettings['disabledBBC'] . ',_SHD_DUMMY_TAG' : '_SHD_DUMMY_TAG';
			$shd_disabled = implode(',', $disabled_tags);

		}

		// wecanhazbbc
		if ($shd_disabled == $smf_disabled)
		{
			// What SMF and SD have is the same, yay
			$text = parse_bbc($text, (!empty($modSettings['shd_allow_ticket_smileys']) ? $smileys : false), $cache);
		}
		else
		{
			// first override SMF's disabled set with ours
			$modSettings['disabledBBC'] = $shd_disabled;
			parse_bbc(false);

			$text = parse_bbc($text, (!empty($modSettings['shd_allow_ticket_smileys']) ? $smileys : false), $cache);
			// Now put it back
			$modSettings['disabledBBC'] = $smf_disabled;
			parse_bbc(false);
		}
	}

	if (!empty($modSettings['shd_allow_wikilinks']))
	{
		// Check for wiki syntax links - first figure out what links match in this text
		preg_match_all('~\[\[ticket\:([0-9]+)\]\]~iU', $text, $matches, PREG_SET_ORDER);

		// Step through the matches, check if it's one we already had in $wikilinks (where persists through the life of this page)
		$ticketlist = array();
		$ticketcount = count($matches);
		for ($i = 0; $i < $ticketcount; $i++)
		{
			$id = (int) $matches[$i][1];
			if (!isset($wikilinks[$id]))
				$ticketlist[$id] = false;
		}

		// Anything we didn't get from $wikilinks we now need to look up
		if (!empty($ticketlist))
		{
			$query = shd_db_query('', '
				SELECT id_ticket, subject
				FROM {db_prefix}helpdesk_tickets AS hdt
				WHERE {query_see_ticket}
					AND id_ticket IN ({array_int:tickets})',
				array(
					'tickets' => array_keys($ticketlist),
				)
			);
			while ($row = $smcFunc['db_fetch_assoc']($query))
			{
				$row['id_ticket'] = (int) $row['id_ticket'];
				$ticketlist[$row['id_ticket']] = $row['subject'];
			}

			// Attach the list we've just made to the master list.
			$wikilinks += $ticketlist;
		}

		// Now, go back through the list of matches again, this time we've got all the tickets we can actually display, so build the final replacement list
		$replacements = array();
		for ($i = 0; $i < $ticketcount; $i++)
		{
			$id = (int) $matches[$i][1];
			if (!empty($wikilinks[$id]))
				$replacements[$matches[$i][0]] = '<a href="' . $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $id . '.0">[' . str_pad($id, 5, '0', STR_PAD_LEFT) . '] ' . $wikilinks[$id] . '</a>';
		}

		$text = str_replace(array_keys($replacements), array_values($replacements), $text);
	}

	return $text;
}

/**
 *	Generates a profile link given user id and name.
 *
 *	SMF itself has loadMemberData() and loadMemberContext to perform this act, however those two functions are much larger and more
 *	complex than we need more often than not, especially when all we want/need is member name (and subsequently profile link)
 *
 *	Since profile links should be based on the view profile permission, we will need to establish that.
 *
 *	@param string $name The name to display. This should be a standard SMF type name, which means already sanitised for HTML.
 *	@param int $id The numeric id of the user we are linking to.
 *
 *	@return string Returns an HTML link to user profile if sufficient permission and both a name and id are supplied. Otherwise just the name is.
 *	@since 1.0
*/
function shd_profile_link($name, $id = 0)
{
	global $user_info, $scripturl;
	static $any = null;
	static $own = null;

	if ($any === null)
	{
		$any = allowedTo('profile_view_any') || shd_allowed_to('shd_view_profile_any', 0); // profile is visible either on SMF or SD permission.
		$own = allowedTo('profile_view_own') || shd_allowed_to('shd_view_profile_own', 0);
	}

	if (empty($id))
		return $name;
	elseif ($any || ($own && $id == $user_info['id']))
		return '<a href="' . $scripturl . '?action=profile;u=' . $id . '">' . $name . '</a>';
	else
		return $name;
}

/**
 *	Generate an image URL given the base filename.
 *
 *	As of 1.1, images can live either in the main Themes/default/images/simpledesk folder, or additionally in Themes/default/images/sd_plugins,
 *	the latter of which is intended for plugins (the former is removed on SD uninstall, the latter is not)
 *
 *	It should only be used in cases where there is ambiguity over where the image may live, e.g. preferences, permissions UIs. If there is no
 *	ambiguity (e.g. SD core, or plugins themselves, where they know where the image will be referenced from), it is recommended to avoid this function.
 *
 *	@param string $filename An image filename, e.g. image.png
 *	@return string A full URL to the image in question, e.g. http://www.example.com/Themes/default/images/sd_plugins/image.png
*/
function shd_image_url($filename)
{
	global $settings;
	if (file_exists($settings['default_theme_dir'] . '/images/sd_plugins/' . $filename))
		return $settings['default_theme_url'] . '/images/sd_plugins/' . $filename;
	else
		return $settings['default_theme_url'] . '/images/simpledesk/' . $filename;
}

/**
 *	Establishes the next change of status of a ticket.
 *
 *	Tickets invariably have multiple changes of status during their life. All actions that could change
 *	a ticket's status should call here, even if it is a straight forward, one-route-only change of status
 *	since it is possible we could end up giving the user a choice one day over how statuses work, so
 *	we should route everything through here all the time.
 *
 *	@param string $action (required), represents the action carried out by the calling function
 *			Known values: new, resolve, unresolve, deleteticket, restoreticket, deletereply, restorereply, reply, merge, topictoticket (new is default)
 *	@param int $starter_id Numeric id of the ticket's starter (should be provided)
 *	@param int $replier_id Numeric id of the ticket's last reply author (should be provided)
 *	@param int $replies Number of replies in the ticket (should be provided)
 *
 *	@return int Returns an integer value that corresponds to the ticket's status, relating to one of the TICKET_STATUS states.
 *	@since 1.0
*/
function shd_determine_status($action, $starter_id = 0, $replier_id = 0, $replies = -1)
{
	static $staff = null;

	if ($staff === null)
		$staff = shd_members_allowed_to('shd_staff');

	$known_states = array(
		'new',
		'resolve',
		'unresolve',
		'deleteticket',
		'restoreticket',
		'deletereply',
		'restorereply',
		'reply',
		'topictoticket',
		'mergesplit',
	);

	if (!in_array($action, $known_states))
		$action = 'new';

	switch ($action)
	{
		case 'new':
			return TICKET_STATUS_NEW; // it's a new ticket, what more can I say?
		case 'resolve':
			return TICKET_STATUS_CLOSED; // yup, all done
		case 'deleteticket':
			return TICKET_STATUS_DELETED; // bye bye
		case 'mergesplit': // used in handling deleted replies
		case 'deletereply':
		case 'restorereply':
		case 'unresolve':
		case 'restoreticket':
		case 'reply':
		case 'topictoticket':
			if ($replies == 0)
				return TICKET_STATUS_NEW;
			else
			{
				if (in_array($replier_id, $staff))
					$new_status = $starter_id == $replier_id ? TICKET_STATUS_PENDING_STAFF : TICKET_STATUS_PENDING_USER; // i.e. if they're staff but it's their own ticket they're replying to, it's not with user.
				else
					$new_status = TICKET_STATUS_PENDING_STAFF;

				return $new_status;
			}
	}
}

/**
 *	Wrapper function for constructPageIndex to forcibly block the extensible ... item in page indexes
 *
 *	SimpleDesk uses SMF's core page index function in numerous places, but unlike SMF, it often places it in containers
 *	that have backgrounds driven by menu_block.png, meaning that they are often fixed in height. Under some circumstances
 *	layout can be broken, so this function forcibly ensures the block can never expand to force wrapping.
 *
 *	@param string $base_url Form of URL pageindex links should take, using $1%d to represent the start point identifier.
 *	@param int &$start Position to start. If not a multiple of the number per page, it will be forced to become a multiple.
 *	@param int $max_value Number of items in total to paginate for.
 *	@param int $num_per_page Number of items to be shown on a page.
 *	@param bool $flexible_start Whether a more flexible % option is to be used in the base URL.
 *
 *	@return string The constructed page index, without Javascript expander(s).
 *	@since 1.0
*/
function shd_no_expand_pageindex($base_url, &$start, $max_value, $num_per_page, $flexible_start = false)
{
	return preg_replace('~<span([^<]+)~i', '<span style="font-weight: bold;"> ... ', constructPageIndex($base_url, $start, $max_value, $num_per_page, $flexible_start));
}

/**
 *	Wrapper for loadLanguage to ensure English language files are always loaded regardless of user language settings as a fallback
 *
 *	As of 2.0 RC2, there is detection code in SMF to ensure the Modifications language file is always loaded, but the same detection is not applied to all language files. This ensures it will be for SD files.
 *
 *	@param string $langfile Name of a language file to load, typically SimpleDesk prefixed, though could be used for any SMF language file.
 *	@param string $override_lang Name of a language to load as an override, rather than just the user's default.
 *	@since 1.1
*/
function shd_load_language($langfile, $override_lang = '')
{
	global $modSettings, $user_info, $language;
	if (empty($modSettings['disable_language_fallback']))
	{
		$cur_language = isset($user_info['language']) ? $user_info['language'] : ($override_lang == '' ? $language : $override_lang);
		if ($cur_language !== 'english')
			loadLanguage($langfile, 'english', false);
	}
	loadLanguage($langfile, $cur_language, false);
}

/**
 *	Clean up tickets that have been modified by replies being altered through restore, delete, merge and split.
 *
 *	Operations:
 *	- Identify how many deleted and non deleted replies there are in the ticket.
 *	- Identify the last non deleted reply in the ticket (if there are no undeleted replies, use the ticket post itself for cohesion)
 *	- Update the ticket's record with the first and last posters, as well as the correct number of active and deleted replies, and whether there are any deleted replies on the ticket generally
 *
 *	Prior to SimpleDesk 1.1, this function was located in Sources/SimpleDesk-Delete.php.
 *
 *	@param int $ticket The ticket id to recalculate.
 *
 *	@return array An array detailing the user id of the starter, the last replier and the number of active replies in a ticket.
 *
 *	@since 1.0
*/
function shd_recalc_ids($ticket)
{
	global $smcFunc;

	$query = shd_db_query('', '
		SELECT hdt.id_first_msg
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE hdt.id_ticket = {int:ticket}',
		array(
			'ticket' => $ticket,
		)
	);
	list($first_msg) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	$query = shd_db_query('', '
		SELECT hdtr.message_status, COUNT(hdtr.message_status) AS messages, hdt.id_first_msg, MAX(hdtr.id_msg) AS id_last_msg
		FROM {db_prefix}helpdesk_ticket_replies AS hdtr
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdt.id_ticket = hdtr.id_ticket)
		WHERE hdtr.id_msg > hdt.id_first_msg
			AND hdt.id_ticket = {int:ticket}
		GROUP BY hdtr.message_status',
		array(
			'ticket' => $ticket,
		)
	);

	$messages = array(
		MSG_STATUS_NORMAL => 0, // message_status = 0
		MSG_STATUS_DELETED => 0, // message_status = 1
	);

	$last_msg = 0;
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$first_msg = $row['id_first_msg'];
		$messages[$row['message_status']] = $row['messages'];
		if ($row['message_status'] == MSG_STATUS_NORMAL)
			$last_msg = $row['id_last_msg'];
	}

	$smcFunc['db_free_result']($query);

	if (empty($last_msg))
		$last_msg = $first_msg;

	// OK, so we have the last message id and correct number of replies, which is awesome. Now we need to ensure user ids are right
	$query = shd_db_query('', '
		SELECT hdtr_first.id_member, hdtr_last.id_member
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_first ON (hdtr_first.id_msg = {int:first_msg})
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_last ON (hdtr_last.id_msg = {int:last_msg})
		WHERE hdt.id_ticket = {int:ticket}',
		array(
			'first_msg' => $first_msg,
			'last_msg' => $last_msg,
			'ticket' => $ticket,
		)
	);
	list($starter, $replier) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_tickets
		SET num_replies = {int:num_replies},
			deleted_replies = {int:deleted_replies},
			id_last_msg = {int:last_msg},
			id_member_started = {int:starter},
			id_member_updated = {int:replier},
			withdeleted = {int:has_deleted}
		WHERE id_ticket = {int:ticket}',
		array(
			'num_replies' => $messages[MSG_STATUS_NORMAL],
			'deleted_replies' => $messages[MSG_STATUS_DELETED],
			'last_msg' => $last_msg,
			'starter' => $starter,
			'replier' => $replier,
			'has_deleted' => ($messages[MSG_STATUS_DELETED] > 0) ? 1 : 0,
			'ticket' => $ticket,
		)
	);

	return array($starter, $replier, $messages[MSG_STATUS_NORMAL]);
}

/**
 *	Load the user preferences for the given user.
 *
 *	@param mixed $user Normally, an int being the user id of the user whose preferences should be attempted to be loaded. If === false, return the list of default prefs (for the pref UI), or if 0 or omitted, load the current user.
 *
 *	@return array If $user === false, the list of options, their types and default values is returned. Otherwise, return an array of prefs (adjusted for this user)
 *	@since 1.1
*/
function shd_load_user_prefs($user = 0)
{
	global $modSettings, $smcFunc, $user_info, $txt;
	static $pref_groups = null, $base_prefs = null;

	if ($pref_groups === null)
	{
		$pref_groups = array(
			'display' => array(
				'icon' => 'preferences.png',
				'enabled' => true,
			),
			'notify' => array(
				'icon' => 'email.png',
				'enabled' => true,
				'check_all' => true,
			),
			'blocks' => array(
				'icon' => 'log.png',
				'enabled' => true,
			),
		);

		$base_prefs = array(
			'display_unread_type' => array(
				'options' => array(
					'none' => 'shd_pref_display_unread_none',
					'unread' => 'shd_pref_display_unread_unread',
					'outstanding' => 'shd_pref_display_unread_outstanding',
				),
				'default' => 'outstanding',
				'type' => 'select',
				'icon' => 'unread.png',
				'group' => 'display',
				'permission' => 'shd_staff',
				'show' => empty($modSettings['shd_helpdesk_only']) && empty($modSettings['shd_disable_unread']),
			),
			'display_order' => array(
				'options' => array(
					'asc' => 'shd_pref_display_order_asc',
					'desc' => 'shd_pref_display_order_desc',
				),
				'default' => 'asc',
				'type' => 'select',
				'icon' => 'move_down.png',
				'group' => 'display',
				'permission' => 'access_helpdesk',
				'show' => true,
			),
			'blocks_assigned_count' => array(
				'default' => 10,
				'type' => 'int',
				'icon' => 'assign.png',
				'group' => 'blocks',
				'permission' => 'shd_staff',
				'show' => true,
			),
			'blocks_new_count' => array(
				'default' => 10,
				'type' => 'int',
				'icon' => 'status.png',
				'group' => 'blocks',
				'permission' => 'access_helpdesk',
				'show' => true,
			),
			'blocks_staff_count' => array(
				'default' => 10,
				'type' => 'int',
				'icon' => 'staff.png',
				'group' => 'blocks',
				'permission' => 'access_helpdesk',
				'show' => true,
			),
			'blocks_user_count' => array(
				'default' => 10,
				'type' => 'int',
				'icon' => 'user.png',
				'group' => 'blocks',
				'permission' => 'access_helpdesk',
				'show' => true,
			),
			'blocks_closed_count' => array(
				'default' => 10,
				'type' => 'int',
				'icon' => 'resolved.png',
				'group' => 'blocks',
				'permission' => array('shd_view_closed_own', 'shd_view_closed_any'),
				'show' => true,
			),
			'blocks_recycle_count' => array(
				'default' => 10,
				'type' => 'int',
				'icon' => 'recycle.png',
				'group' => 'blocks',
				'permission' => 'shd_access_recyclebin',
				'show' => true,
			),
			'blocks_withdeleted_count' => array(
				'default' => 10,
				'type' => 'int',
				'icon' => 'recycle.png',
				'group' => 'blocks',
				'permission' => 'shd_access_recyclebin',
				'show' => true,
			),
			'notify_new_ticket' => array(
				'default' => 0,
				'type' => 'check',
				'icon' => 'log_newticket.png',
				'group' => 'notify',
				'permission' => 'shd_staff',
				'show' => !empty($modSettings['shd_notify_new_ticket']),
			),
			'notify_new_reply_own' => array(
				'default' => 1,
				'type' => 'check',
				'icon' => 'log_newreply.png',
				'group' => 'notify',
				'permission' => 'shd_new_ticket',
				'show' => !empty($modSettings['shd_notify_new_reply_own']),
			),
			'notify_new_reply_assigned' => array(
				'default' => 0,
				'type' => 'check',
				'icon' => 'log_assign.png',
				'group' => 'notify',
				'permission' => 'shd_staff',
				'show' => !empty($modSettings['shd_notify_new_reply_assigned']),
			),
			'notify_new_reply_previous' => array(
				'default' => 0,
				'type' => 'check',
				'icon' => 'log_newreply.png',
				'group' => 'notify',
				'permission' => 'shd_staff',
				'show' => !empty($modSettings['shd_notify_new_reply_previous']),
			),
			'notify_new_reply_any' => array(
				'default' => 0,
				'type' => 'check',
				'icon' => 'log_newreply.png',
				'group' => 'notify',
				'permission' => 'shd_staff',
				'show' => !empty($modSettings['shd_notify_new_reply_any']),
			),
			'notify_assign_me' => array(
				'default' => 0,
				'type' => 'check',
				'icon' => 'assign.png',
				'group' => 'notify',
				'permission' => 'shd_staff',
				'show' => !empty($modSettings['shd_notify_assign_me']),
			),
			'notify_assign_own' => array(
				'default' => 0,
				'type' => 'check',
				'icon' => 'assign.png',
				'group' => 'notify',
				'permission' => 'shd_new_ticket',
				'show' => !empty($modSettings['shd_notify_assign_own']),
			),
		);

		// Now engage any hooks.
		call_integration_hook('shd_hook_prefs', array(&$pref_groups, &$base_prefs));

		foreach ($base_prefs as $pref => $details)
		{
			if (empty($pref_groups[$details['group']]['enabled']) || empty($details['show']))
				unset($base_prefs[$pref]);
		}
	}

	// Do we just want the prefs list?
	if ($user === false)
		return array(
			'groups' => $pref_groups,
			'prefs' => $base_prefs,
		);

	$prefs = array();
	if ($user == 0 || $user == $user_info['id'])
	{
		$user = $user_info['id'];

		// Start with the defaults, but dealing with permissions as we go
		foreach ($base_prefs as $pref => $details)
		{
			if (empty($details['permission']) || shd_allowed_to($details['permission'], 0))
				$prefs[$pref] = $details['default'];
		}
	}
	else
	{
		foreach ($base_prefs as $pref => $details)
		{
			if (empty($details['permission']))
				continue;

			if (is_array($details['permission']))
			{
				foreach ($details['permission'] as $perm)
					if (in_array($user, shd_members_allowed_to($perm)))
					{
						$prefs[$pref] = $details['default'];
						break;
					}
			}
			else
			{
				if (in_array($user, shd_members_allowed_to($details['permission'])))
					$prefs[$pref] = $details['default'];
			}
		}
	}

	// Now, the database
	$query = $smcFunc['db_query']('', '
		SELECT variable, value
		FROM {db_prefix}helpdesk_preferences
		WHERE id_member = {int:user}',
		array(
			'user' => (int) $user,
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		if (isset($prefs[$row['variable']]))
			$prefs[$row['variable']] = $row['value'];
	}

	return $prefs;
}

/**
 *	Loads any source files directed by integration hooks.
 *
 *	@since 1.1
*/
function shd_load_plugin_files($hook = '')
{
	global $sourcedir, $modSettings;

	if (empty($hook) || empty($modSettings['shd_include_' . $hook]))
		return;

	$filelist = explode(',', $modSettings['shd_include_' . $hook]);
	foreach ($filelist as $file)
	{
		if (file_exists($sourcedir . '/sd_plugins_source/' . $file))
			require_once($sourcedir . '/sd_plugins_source/' . $file);
	}
}

/**
 *	Loads any language files directed by integration hooks.
 *
 *	@since 1.1
*/
function shd_load_plugin_langfiles($hook = '')
{
	global $modSettings;

	if (empty($hook) || empty($modSettings['shd_includelang_' . $hook]))
		return;

	$filelist = explode(',', $modSettings['shd_includelang_' . $hook]);
	foreach ($filelist as $file)
		shd_load_language($file);
}

/**
 *	Adds the button to the thread view for moving topics into the helpdesk, if appropriate.
 *
 *	This explicitly relies on the display template hook for such things. If the theme does not provide it, the theme author needs to update their theme.
 *
 *	@since 1.1
*/
function shd_display_btn_mvtopic(&$normal_buttons)
{
	global $context, $txt, $scripturl, $modSettings;

	$context['can_move_to_helpdesk'] = !empty($modSettings['helpdesk_active']) && empty($modSettings['shd_disable_tickettotopic']) && empty($modSettings['shd_helpdesk_only']) && shd_allowed_to('shd_topic_to_ticket', 0);
	$normal_buttons = array_merge($normal_buttons, array('topictoticket' => array('test' => 'can_move_to_helpdesk', 'text' => 'shd_move_topic_to_ticket', 'lang' => true, 'url' => $scripturl . '?action=helpdesk;sa=topictoticket;topic=' . $context['current_topic'] . ';' . $context['session_var'] . '=' . $context['session_id'])));
}

/**
 *	Placeholder for calling the scheduled maintenance functions.
 *
 *	All scheduled tasks have to have the name prefix scheduled_ and must be defined by the time we get to running AutoTask() in Scheduled.php. Short of modifying that file, we can define a placeholder here (which will exist for AutoTask) and have that be called.
 *
 *	@since 1.1
*/
function scheduled_simpledesk()
{
	global $sourcedir, $modSettings;

	if (empty($modSettings['helpdesk_active']))
		return;

	require($sourcedir . '/sd_source/SimpleDesk-Scheduled.php');
	return shd_scheduled();
}

/**
 *	Adds the SimpleDesk action to the action list, and also handles most of the shutting down of forum items in helpdesk-only mode.
 *
 *	@param string &$actionArray The master list of actions from index.php
 *
 *	@since 1.1
*/
function shd_init_actions(&$actionArray)
{
	global $modSettings, $context;

	if (empty($modSettings['helpdesk_active']))
		return;

	// Deal with SimpleDesk. If we're enabling HD only mode, rebuild everything, otherwise just add it to the array.
	$actionArray['helpdesk'] = array('sd_source/SimpleDesk.php', 'shd_main');

	// Rewrite the array for unread purposes.
	$context['shd_unread_actions'] = array(
		'unread' => $actionArray['unread'],
		'unreadreplies' => $actionArray['unreadreplies'],
	);
	$actionArray['unread'] = array('sd_source/SimpleDesk-Unread.php', 'shd_unread_posts');
	$actionArray['unreadreplies'] = array('sd_source/SimpleDesk-Unread.php', 'shd_unread_posts');

	// If we're going to a help page (for admin), make sure to load the relevant text.
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'helpadmin')
		shd_load_language('SimpleDeskAdmin');

	// Now engage any SD specific hooks.
	call_integration_hook('shd_hook_actions', array(&$actionArray));

	if (!empty($modSettings['shd_helpdesk_only']))
	{
		// Firstly, remove all the standard actions we neither want nor need.
		// Note we did this to prevent breakage of other mods that may be installed, e.g. gallery or portal or something.
		$unwanted_actions = array('announce', 'attachapprove', 'buddy', 'calendar', 'clock', 'collapse', 'deletemsg', 'display', 'editpoll', 'editpoll2',
			'emailuser', 'lock', 'lockvoting', 'markasread', 'mergetopics', 'moderate', 'modifycat', 'modifykarma', 'movetopic', 'movetopic2',
			'notify', 'notifyboard', 'post', 'post2', 'printpage', 'quotefast', 'quickmod', 'quickmod2', 'recent', 'reminder', 'removepoll', 'removetopic2',
			'reporttm', 'restoretopic', 'search', 'search2', 'sendtopic', 'smstats', 'splittopics', 'stats', 'sticky', 'trackip', 'about:mozilla', 'about:unknown',
			'unread', 'unreadreplies', 'vote', 'viewquery', 'who', '.xml', 'xmlhttp');

		// that's the generic stuff, now for specific options
		if (!empty($modSettings['shd_disable_pm']))
			$unwanted_actions[] = 'pm';

		if (!empty($modSettings['shd_disable_mlist']))
			$unwanted_actions[] = 'mlist';

		foreach ($unwanted_actions as $unwanted)
			if (isset($actionArray[$unwanted]))
				unset($actionArray[$unwanted]);

		// Secondly, rewrite the defaults to point to helpdesk, for unknown actions. I'm doing this rather than munging the main code - easier to unbreak stuff
		if (empty($actionArray[$_GET['action']]))
			$_GET['action'] = 'helpdesk';
	}
}

/**
 *	Last-minute buffer replacements to be made, e.g. removing unwanted content in helpdesk-only mode.
 *
 *	@since 1.1
*/
function shd_buffer_replace(&$buffer)
{
	global $modSettings, $context;

	if (!empty($modSettings['helpdesk_active']))
	{
		$shd_replacements = array();
		$shd_preg_replacements = array();

		// If we're in helpdesk standalone mode, purge unread type links
		if (!empty($modSettings['shd_helpdesk_only']))
		{
			$shd_preg_replacements += array(
				'~<a(.+)action=unread(.+)</a>~iuU' => '',
				'~<form([^<]+)action=search2(.+)</form>~iuUs' => '',
			);
		}

		if (!empty($context['shd_buffer_replacements']))
			$shd_replacements += $context['shd_buffer_replacements'];
		if (!empty($context['shd_buffer_preg_replacements']))
			$shd_preg_replacements += $context['shd_buffer_preg_replacements'];

		if (!empty($shd_replacements)) // no sense doing preg when regular will do
			$buffer = str_replace(array_keys($shd_replacements), array_values($shd_replacements), $buffer);
		if (!empty($shd_preg_replacements))
			$buffer = preg_replace(array_keys($shd_preg_replacements), array_values($shd_preg_replacements), $buffer);
	}

	// And any replacements a buffer might want to make...
	call_integration_hook('shd_hook_buffer', array(&$buffer));

	return $buffer;
}

/**
 *	Add the SimpleDesk options to the main site menu.
 *
 *	@param array &$menu_buttons The main menu buttons as provided by Subs.php.
 *	@since 1.1
*/
function shd_main_menu(&$menu_buttons)
{
	global $context, $txt, $scripturl, $modSettings;

	if (!empty($modSettings['helpdesk_active']))
	{
		// Stuff we'll always do in SD if active
		$helpdesk_admin = $context['user']['is_admin'] || shd_allowed_to('admin_helpdesk', 0);

		// 1. Add the main menu if we can.
		if (shd_allowed_to(array('access_helpdesk', 'admin_helpdesk'), 0) && empty($modSettings['shd_hidemenuitem']))
		{
			// Because some items may have been removed at this point, let's try a list of possible places after which we can add the button.
			$order = array('search', 'profile', 'forum', 'pm', 'help', 'home');
			$pos = null;
			foreach ($order as $item)
				if (isset($menu_buttons[$item]))
				{
					$pos = $item;
					break;
				}

			if ($pos === null)
				$menu_buttons['helpdesk'] = array();
			else
			{
				// OK, we're adding it after something.
				$temp = $menu_buttons;
				$menu_buttons = array();
				foreach ($temp as $k => $v)
				{
					$menu_buttons[$k] = $v;
					if ($k == $pos)
						$menu_buttons['helpdesk'] = array();
				}
			}

			$menu_buttons['helpdesk'] += array(
				'title' => $modSettings['helpdesk_active'] && SMF != 'SSI' ? shd_get_active_tickets() : $txt['shd_helpdesk'],
				'href' => $scripturl . '?action=helpdesk;sa=main',
				'show' => true,
				'active_button' => false,
				'sub_buttons' => array(
					'newticket' => array(
						'title' => $txt['shd_new_ticket'],
						'href' => $scripturl . '?action=helpdesk;sa=newticket',
						'show' => SMF == 'SSI' ? false : shd_allowed_to('shd_new_ticket', 0),
					),
					'newproxyticket' => array(
						'title' => $txt['shd_new_ticket_proxy'],
						'href' => $scripturl . '?action=helpdesk;sa=newticket;proxy',
						'show' => SMF == 'SSI' ? false : shd_allowed_to('shd_new_ticket', 0) && shd_allowed_to('shd_post_proxy', 0),
					),
					'closedtickets' => array(
						'title' => $txt['shd_tickets_closed'],
						'href' => $scripturl . '?action=helpdesk;sa=closedtickets',
						'show' => SMF == 'SSI' ? false : shd_allowed_to(array('shd_view_closed_own', 'shd_view_closed_any'), 0),
					),
					'recyclebin' => array(
						'title' => $txt['shd_recycle_bin'],
						'href' => $scripturl . '?action=helpdesk;sa=recyclebin',
						'show' => SMF == 'SSI' ? false : shd_allowed_to('shd_access_recyclebin', 0),
					),
				),
			);

			if ($helpdesk_admin)
				$menu_buttons['helpdesk']['sub_buttons']['admin'] = array(
					'title' => $txt['admin'],
					'href' => $scripturl . '?action=admin;area=helpdesk_info',
					'show' => SMF == 'SSI' ? false : empty($modSettings['shd_hidemenuitem']) && $helpdesk_admin,
					'sub_buttons' => shd_main_menu_admin($helpdesk_admin),
				);

			$item = false;
			foreach ($menu_buttons['helpdesk']['sub_buttons'] as $key => $value)
				if (!empty($value['show']))
					$item = $key;
				else
					unset($menu_buttons['helpdesk']['sub_buttons'][$key]);

			if (!empty($item))
				$menu_buttons['helpdesk']['sub_buttons'][$item]['is_last'] = true;
		}

		// Add the helpdesk admin option to the admin menu, if board integration is disabled.
		if (!empty($modSettings['shd_hidemenuitem']) && $helpdesk_admin)
		{
			// It's possible the admin button got eaten already, so we may have to recreate it.
			if (empty($menu_buttons['admin']))
			{
				$admin_menu = array(
					'title' => $txt['admin'],
					'href' => $scripturl . '?action=admin',
					'show' => true,
					'active_button' => false,
					'sub_buttons' => array(
					),
				);

				// Trouble is, now we've done that, it's in the wrong damn place. So step through and insert our menu into just after the SD menu
				$old_menu_buttons = $menu_buttons;
				$menu_buttons = array();

				$added = false;
				foreach ($old_menu_buttons as $area => $detail)
				{
					if (!$added && ($area == 'moderate' || $area == 'profile'))
					{
						$menu_buttons['admin'] = $admin_menu;
						$added = true;
					}

					$menu_buttons[$area] = $detail;
				}
			}

			// Make sure the button is visible if you can admin forum
			$menu_buttons['admin']['show'] = true;

			// Remove the is_last item
			foreach ($menu_buttons['admin']['sub_buttons'] as $key => $value)
				if (!empty($value['is_last']))
					unset($menu_buttons['admin']['sub_buttons'][$key]['is_last']);

			// Add the new button
			$menu_buttons['admin']['sub_buttons']['helpdesk_admin'] = array(
				'title' => $txt['shd_helpdesk'],
				'href' => $scripturl . '?action=admin;area=helpdesk_info',
				'show' => true,
				'is_last' => true,
				'sub_buttons' => shd_main_menu_admin($helpdesk_admin),
			);
		}

		if (shd_allowed_to(array('shd_view_profile_own', 'shd_view_profile_any'), 0))
		{
			// Hmm, this could be tricky. It's possible the main menu has been eaten by permissions at this point, so just in case, reconstruct what's missing.
			if (empty($menu_buttons['profile']))
			{
				$profile_menu = array(
					'title' => $txt['profile'],
					'href' => $scripturl . '?action=profile',
					'active_button' => false,
					'sub_buttons' => array(
					),
				);

				// Trouble is, now we've done that, it's in the wrong damn place. So step through and insert our menu into just after the SD menu
				$old_menu_buttons = $menu_buttons;
				$menu_buttons = array();

				$added = false;
				foreach ($old_menu_buttons as $area => $detail)
				{
					$menu_buttons[$area] = $detail;

					if ($area == 'helpdesk')
					{
						$menu_buttons['profile'] = $profile_menu;
						$added = true;
					}
				}
				if (!$added)
					$menu_buttons['profile'] = $profile_menu;
			}

			// Remove the is_last item
			foreach ($menu_buttons['profile']['sub_buttons'] as $key => $value)
			{
				if (!empty($value['is_last']))
					unset($menu_buttons['profile']['sub_buttons'][$key]['is_last']);
			}

			// Add the helpdesk profile to the profile menu (either the original or our reconstituted one)
			$menu_buttons['profile']['show'] = true;
			$menu_buttons['profile']['sub_buttons']['hd_profile'] = array(
				'title' => $txt['shd_helpdesk_profile'],
				'href' => $scripturl . '?action=profile;area=helpdesk',
				'show' => true,
				'is_last' => true,
			);
		}

		// Stuff we'll only do if in standalone mode
		if (!empty($modSettings['shd_helpdesk_only']))
		{
			$menu_buttons['home'] = array(
				'title' => $modSettings['helpdesk_active'] && SMF != 'SSI' ? shd_get_active_tickets() : $txt['shd_helpdesk'],
				'href' => $scripturl . '?action=helpdesk;sa=main',
				'show' => $modSettings['helpdesk_active'],
				'sub_buttons' => array(
					'newticket' => array(
						'title' => $txt['shd_new_ticket'],
						'href' => $scripturl . '?action=helpdesk;sa=newticket',
						'show' => SMF == 'SSI' ? false : shd_allowed_to('shd_new_ticket', 0),
					),
					'newproxyticket' => array(
						'title' => $txt['shd_new_ticket_proxy'],
						'href' => $scripturl . '?action=helpdesk;sa=newticket;proxy',
						'show' => SMF == 'SSI' ? false : shd_allowed_to('shd_new_ticket', 0) && shd_allowed_to('shd_post_proxy', 0),
					),
					'closedtickets' => array(
						'title' => $txt['shd_tickets_closed'],
						'href' => $scripturl . '?action=helpdesk;sa=closedtickets',
						'show' => SMF == 'SSI' ? false : shd_allowed_to(array('shd_view_closed_own', 'shd_view_closed_any'), 0),
					),
					'recyclebin' => array(
						'title' => $txt['shd_recycle_bin'],
						'href' => $scripturl . '?action=helpdesk;sa=recyclebin',
						'show' => SMF == 'SSI' ? false : shd_allowed_to('shd_access_recyclebin', 0),
					),
				),
				'active_button' => false,
			);
			if ($helpdesk_admin)
				$menu_buttons['home']['sub_buttons']['admin'] = array(
					'title' => $txt['admin'],
					'href' => $scripturl . '?action=admin;area=helpdesk_info',
					'show' => SMF == 'SSI' ? false : empty($modSettings['shd_hidemenuitem']) && $helpdesk_admin,
					'is_last' => true,
					'sub_buttons' => shd_main_menu_admin($helpdesk_admin),
				);

			$item = false;
			foreach ($menu_buttons['home']['sub_buttons'] as $key => $value)
				if (!empty($value['show']))
					$item = $key;
				else
					unset($menu_buttons['home']['sub_buttons'][$key]);

			if (!empty($item))
				$menu_buttons['home']['sub_buttons'][$item]['is_last'] = true;

			unset($menu_buttons['helpdesk']);

			// Disable help, search, calendar, moderation center
			unset($menu_buttons['help'], $menu_buttons['search'], $menu_buttons['calendar'], $menu_buttons['moderate']);

			$context['allow_search'] = false;
			$context['allow_calendar'] = false;
			$context['allow_moderation_center'] = false;

			// Disable PMs
			if (!empty($modSettings['shd_disable_pm']))
			{
				$context['allow_pm'] = false;
				unset($menu_buttons['pm']);
				$context['user']['unread_messages'] = 0; // to disable it trying to add to the menu item
			}

			// Disable memberlist
			if (!empty($modSettings['shd_disable_mlist']))
			{
				$context['allow_memberlist'] = false;
				unset($menu_buttons['mlist']);
			}
		}

		// Now engage any hooks.
		call_integration_hook('shd_hook_mainmenu', array(&$menu_buttons));
	}
}

function shd_main_menu_admin($helpdesk_admin)
{
	global $txt, $scripturl;

	if (SMF == 'SSI' || !$helpdesk_admin)
		return array();

	return array(
		'information' => array(
			'title' => $txt['shd_admin_info'],
			'href' => $scripturl . '?action=admin;area=helpdesk_info',
			'show' => true,
		),
		'options' => array(
			'title' => $txt['shd_admin_options'],
			'href' => $scripturl . '?action=admin;area=helpdesk_options',
			'show' => true,
		),
		'custom_fields' => array(
			'title' => $txt['shd_admin_custom_fields'],
			'href' => $scripturl . '?action=admin;area=helpdesk_customfield',
			'show' => true,
		),
		'departments' => array(
			'title' => $txt['shd_admin_departments'],
			'href' => $scripturl . '?action=admin;area=helpdesk_depts',
			'show' => true,
		),
		'permissions' => array(
			'title' => $txt['shd_admin_permissions'],
			'href' => $scripturl . '?action=admin;area=helpdesk_permissions',
			'show' => true,
		),
		'plugins' => array(
			'title' => $txt['shd_admin_plugins'],
			'href' => $scripturl . '?action=admin;area=helpdesk_plugins',
			'show' => true,
		),
		'maintenance' => array(
			'title' => $txt['shd_admin_maint'],
			'href' => $scripturl . '?action=admin;area=helpdesk_maint',
			'show' => true,
			'is_last' => true,
		),
	);
}
// Cause IE is being mean to meeee again...!
?>