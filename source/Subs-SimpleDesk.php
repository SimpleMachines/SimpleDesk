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

	if (!isset($user_info['query_see_ticket']))
		shd_load_user_perms();

	$replacements = array(
		'{query_see_ticket}' => $user_info['query_see_ticket'],
	);

	$db_string = str_replace(array_keys($replacements), array_values($replacements), $db_string);
	$db_values['user_info_id'] = $user_info['id'];

	return $smcFunc['db_query']($identifier, $db_string, $db_values, $connection);
}

/**
 *	Defines user permissions, most importantly concerning ticket visibility
 *
 *	Populates specific parameters in $user_info, mostly to add {} abstract variables in $smcFunc['db_query'] data calls.
 *	The foremost one of these is {query_see_ticket}, an SQL clause constructed to ensure ticket visibility is maintained given the
 *	active user's permission set.
 *
 *	@see shd_db_query()
 *	@since 1.0
*/
function shd_load_user_perms()
{
	global $user_info;
	if ($user_info['is_admin'])
		$user_info['query_see_ticket'] = '1=1';
	elseif (shd_allowed_to('shd_view_ticket_any'))
		$user_info['query_see_ticket'] = shd_allowed_to('shd_view_ticket_private_any') ? '1=1' : ('(hdt.private = 0' . (shd_allowed_to('shd_view_ticket_private_own') ? ' OR (hdt.private = 1 AND hdt.id_member_started = {int:user_info_id}))' : ')'));
	elseif (shd_allowed_to('shd_view_ticket_own'))
		$user_info['query_see_ticket'] = 'hdt.id_member_started = {int:user_info_id}' . (shd_allowed_to('shd_view_ticket_private_own') ? '' : ' AND hdt.private = 0');
	else
		$user_info['query_see_ticket'] = '1=0';

	if (!shd_allowed_to('shd_access_recyclebin'))
		$user_info['query_see_ticket'] .= ' AND hdt.status != 6';
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

	// Figure out the status(es) that the ticket could be. Note that we have to use numeric values rather than our proper constants
	// because they are not declared at this point (only in the main helpdesk itself)
	if (shd_allowed_to('shd_staff'))
		$status = array(0, 1); // TICKET_STATUS_NEW, TICKET_STATUS_PENDING_STAFF (i.e. staff actually need to deal with these)
	else
		$status = array(2); // TICKET_STATUS_PENDING_USER (i.e. user actually needs to deal with this)

	// Can we get it from the cache?
	$temp = cache_get_data('shd_active_tickets_' . $user_info['id'], 180);
	if ($temp !== null)
	{
		list($context['active_tickets'], $context['active_tickets_raw']) = $temp;
		$context['menu_buttons']['helpdesk']['alttitle'] = $txt['shd_helpdesk'] . !empty($context['active_tickets_raw']) ? (' [' . $context['active_tickets_raw'] . ']') : '';
		return $txt['shd_helpdesk'] . $context['active_tickets'];
	}

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
		cache_put_data('shd_active_tickets_' . $member, null, 0);
}

/**
 *	Adds an action to the helpdesk internal action log.
 *
 *	This function deals with adding items to the action log maintained by the helpdesk.
 *
 *	@param string $action Specifies the name of the action to log, which implies the image and language string (log_$action is
 *	the name of the image, and $txt['shd_log_$action'] is the string used to express the action, as listed in
 *	SimpleDesk-LogAction.english.php.
 *	@param array $params This is a list of named parameters in a hash array to be used in the language string later.
 *
 *	@see shd_load_action_log_entries()
 *	@since 1.0
*/
function shd_log_action($action, $params)
{
	global $smcFunc, $context, $user_info, $modSettings;

	if (!empty($modSettings['shd_disable_action_log']))
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
function shd_can_alter_urgency($urgency, $ticket_starter, $closed, $deleted)
{
	global $user_info;

	$can_urgency = array(
		'increase' => false,
		'decrease' => false,
	);

	if ($closed || $deleted)
		return $can_urgency;

	if (shd_allowed_to('shd_alter_urgency_any'))
	{
		if (shd_allowed_to('shd_alter_urgency_higher_any') || (shd_allowed_to('shd_alter_urgency_higher_own') && $ticket_starter == $user_info['id']))
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
	elseif (shd_allowed_to('shd_alter_urgency_own') && $ticket_starter == $user_info['id'])
		$can_urgency = array( // ok, so this is our ticket and we can change it
			'increase' => ($urgency < (shd_allowed_to('shd_alter_urgency_higher_own') ? TICKET_URGENCY_CRITICAL : TICKET_URGENCY_HIGH)),
			'decrease' => ($urgency > TICKET_URGENCY_LOW && $urgency <= (shd_allowed_to('shd_alter_urgency_higher_own') ? TICKET_URGENCY_CRITICAL : TICKET_URGENCY_VHIGH)),
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
	global $smcFunc, $context;

	if (empty($context['ticket_count']))
	{
		$context['ticket_count'] = array();
		for ($i = 0; $i <= 6; $i++)
			$context['ticket_count'][$i] = 0; // set the count to zero for all known states

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
		if (shd_allowed_to('shd_staff'))
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
				if (!in_array($row['status'], array(3, 6))) // not TICKET_STATUS_CLOSED or TICKET_STATUS_DELETE
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
					'has_deleted' => 1, // MSG_STATUS_DELETED
					'ticket_deleted' => 6, // TICKET_STATUS_DELETED; we want all non deleted tickets with deleted replies
				)
			);
			list($count) = $smcFunc['db_fetch_row']($query);
			$smcFunc['db_free_result']($query);

			$context['ticket_count']['withdeleted'] = $count;
		}
		else
			$context['ticket_count']['withdeleted'] = 0;
	}

	switch($status)
	{
		case 'open':
			return (
				$context['ticket_count'][0] + // _NEW
				$context['ticket_count'][1] + // _PENDING_STAFF
				$context['ticket_count'][2] + // _PENDING_USER
				$context['ticket_count'][4] + // _WITH_SUPERVISOR
				$context['ticket_count'][5]   // _ESCALATED
			);
		case 'assigned':
			return $context['ticket_count']['assigned'];
		case 'new':
			return $context['ticket_count'][0];
		case 'staff':
			return $is_staff ? $context['ticket_count'][1] : ($context['ticket_count'][0] + $context['ticket_count'][1]); // both "new" and "with staff" should appear as 'with staff' to non staff
		case 'with_user':
			return $context['ticket_count'][2];
		case 'closed':
			return $context['ticket_count'][3];
		case 'recycled':
			return $context['ticket_count'][6];
		case 'withdeleted':
			return $context['ticket_count']['withdeleted'];
		default:
			return array_sum($context['ticket_count']) - $context['ticket_count']['assigned'];
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
			hdtr.modified_time, hdtr.smileys_enabled,
			IFNULL(mem.real_name, hdtr.poster_name) AS starter_name, IFNULL(mem.id_member, 0) AS starter_id, hdtr.poster_ip AS starter_ip,
			IFNULL(ma.real_name, 0) AS assigned_name, IFNULL(ma.id_member, 0) AS assigned_id,
			IFNULL(mm.real_name, hdtr.modified_name) AS modified_name, IFNULL(mm.id_member, 0) AS modified_id
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdt.id_first_msg = hdtr.id_msg)
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

	$ticketinfo['link_ip'] = shd_allowed_to('moderate_forum');

	return $ticketinfo;
}

/**
 *	Formats a string for bbcode and/or smileys.
 *
 *	Formatting is done according to the supplied settings and the master administration settings.
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
	global $modSettings;
	if (empty($modSettings['shd_allow_ticket_bbc']))
	{
		if (!empty($modSettings['shd_allow_ticket_smileys']) && $smileys)
			parsesmileys($text);
	}
	else
	{
		// See what tagz we can haz.
		if (!empty($modSettings['shd_enabled_bbc']))
			$enabled_tags = explode(',', $modSettings['shd_enabled_bbc']);
		else
			$enabled_tags = array(false);

		// wecanhazbbc
		$text = parse_bbc($text, (!empty($modSettings['shd_allow_ticket_smileys']) ? $smileys : false), $cache, $enabled_tags);
	}

	return $text;
}

/**
 *	Determines if a user has a given permission within the system.
 *
 *	All SimpleDesk-specific permissions should be checked with this function. Any other permission check that is not specifically
 *	SimpleDesk-related should use allowedTo instead.
 *
 *	@param mixed $permission A string or array of strings naming a permission or permissions that wish to be examined
 *	@return bool True if any of the permission(s) outlined in $permission are true.
 *	@see shd_is_allowed_to
 *	@todo This function will likely be expanded to not use SMF's allowedTo function eventually, as its requirements will outgrow
 *	or replace conventional SMF permissions.
 *	@since 1.0
*/
function shd_allowed_to($permission)
{
	return allowedTo($permission);
}

/**
 *	Enforces a user having a given permission and returning to a fatal error message if not.
 *
 *	All fatal-level SimpleDesk-specific permissions should be checked with this function. Any other permission check that is
 *	not specifically SimpleDesk-related should use isAllowedTo instead. Note that this is a void function because should this
 *	fail, SMF execution will be halted.
 *
 *	@param mixed $permission A string or array of strings naming a permission or permissions that wish to be examined
 *	@see shd_allowed_to
 *	@todo This function will likely be expanded to not use SMF's allowedTo function eventually, as its requirements will outgrow
 *	or replace conventional SMF permissions.
 *	@since 1.0
*/
function shd_is_allowed_to($permission)
{
	isAllowedTo($permission);
}

/**
 *	Identifies all members who hold a given permission.
 *
 *	Currently lists of staff are generated by users who hold shd_staff permission. This function identifies those users through
 *	an internal lookup provided by SMF.
 *
 *	@param mixed $permission A string naming a permission that members should hold.
 *	@return array Array of zero or more user ids who hold the stated permission.
 *	@see shd_allowed_to
 *	@todo This function will likely be expanded to not use SMF's permissions eventually.
 *	@since 1.0
*/
function shd_members_allowed_to($permission)
{
	global $sourcedir;
	require_once($sourcedir . '/Subs-Members.php');
	return membersAllowedTo($permission);
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
		$any = allowedTo('profile_view_any'); // using allowedTo as it's an SMF permission, not an SD specific one
		$own = allowedTo('profile_view_own');
	}

	if (empty($id))
		return $name;
	elseif ($any || ($own && $id == $user_info['id']))
		return '<a href="' . $scripturl . '?action=profile;u=' . $id . '">' . $name . '</a>';
	else
		return $name;
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
		case 'merge': // used in handling deleted replies
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
				$staff = shd_members_allowed_to('shd_staff');
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
 *	@since 1.1
*/
function shd_load_language($langfile)
{
	global $modSettings, $user_info, $language;
	if (empty($modSettings['disable_language_fallback']))
	{
		$cur_language = isset($user_info['language']) ? $user_info['language'] : $language;
		if ($cur_language !== 'english')
			loadLanguage($langfile, 'english', false);
	}
	loadLanguage($langfile);
}

?>