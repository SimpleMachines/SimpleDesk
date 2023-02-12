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
# SimpleDesk Version: 2.0 Anatidae                            #
# File Info: SimpleDesk-SSI.php / 2.0 Anatidae                #
###############################################################

/**
 *	This file handles data gathering primarily for SSI.php purposes. It expects Subs-SimpleDesk.php to have been required as this
 *	will still be needed for helpdesk permissions checks and base functions.
 *
 *	The function names imply who is expected to be the target, ssi_user functions are those intended for users, ssi_staff for staff
 *	members, such as ssi_userTickets() is primarily for displaying the tickets started by a given user, ssi_staffAssignedTickets()
 *	for all the tickets assigned to a given member of staff.
 *
 *	No support for displaying these through SHTML is provided, nor is any planned.
 *
 *	Unlike other SimpleDesk functions, these use a SSI style camel casing.
 *
 *	@package source
 *	@since 2.0
 */

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Gets a list of the tickets currently open that are a given user's (subject to ticket visibility).
 *
 *	@param int $started_by The user id whose tickets you want to examine, defaults to the current user.
 *	@param int $limit The number of tickets to limit to, default 10.
 *	@param string $output_method Set to 'echo' for displaying content, set to 'array' to simply return data.
 *	@return array An array of data, more details under the underlying function {@link ssi_getSDTickets()}
 *	@since 2.0
*/
function ssi_userTickets($started_by = 0, $limit = 10, $output_method = 'echo')
{
	global $user_info;
	if (empty($started_by))
		$started_by = $user_info['id'];

	$limit = (int) $limit;
	if (empty($limit))
		return;

	$query_where = 'hdt.id_member_started = {int:started}';

	$query_where_params = array(
		'started' => $started_by,
	);

	return ssi_getSDTickets($query_where, $query_where_params, $limit, 'hdt.id_ticket ASC', $output_method);
}

/**
 *	Gets a list of the tickets currently open that are assigned to the current user (presumably staff, subject to ticket visibility).
 *
 *	@param int $assignee The user id whose tickets whose assigned tickets you want to examine, defaults to the current user.
 *	@param int $limit The number of tickets to limit to, default 10.
 *	@param string $output_method Set to 'echo' for displaying content, set to 'array' to simply return data.
 *	@return array An array of data, more details under the underlying function {@link ssi_getSDTickets()}
 *	@since 2.0
*/
function ssi_staffAssignedTickets($assignee = 0, $limit = 10, $output_method = 'echo')
{
	global $user_info;
	if (empty($assignee))
		$assignee = $user_info['id'];

	$limit = (int) $limit;
	if (empty($limit))
		return;

	$query_where = 'hdt.id_member_assigned = {int:assigned}';

	$query_where_params = array(
		'assigned' => $assignee,
	);

	return ssi_getSDTickets($query_where, $query_where_params, '', 'hdt.id_ticket ASC', $output_method);
}

/**
 *	Gets a list of all tickets based on urgency criteria given (subject to ticket visibility)
 *
 *	@param int $urgency The urgency of tickets you want to get.
 *	@param int $limit The number of tickets to limit to, default 10.
 *	@param string $output_method Set to 'echo' for displaying content, set to 'array' to simply return data.
 *	@return array An array of data, more details under the underlying function {@link ssi_getSDTickets()}
 *	@since 2.0
*/
function ssi_staffTicketsUrgency($urgency, $limit = 10, $output_method = 'echo')
{
	$query_where = 'hdt.urgency = {int:urgency}';

	$query_where_params = array(
		'urgency' => $urgency,
	);

	return ssi_getSDTickets($query_where, $query_where_params, '', 'hdt.id_ticket ASC', $output_method);
}

/**
 *	Gets tickets based on supplied criteria; this is a helper function not really intended to be called directly.
 *
 *	@todo Finish writing and documenting this function.
 *	@param string $query_where SQL clauses to be supplied to the query in addition to {query_see_ticket} - note 'AND' is not required at the start.
 *	@param array $query_where_params Key/value associative array to be injected into the query, related to $query_where.
 *	@param int $query_limit Number of items to limit the query to.
 *	@param string $query_order The clause to order tickets by, defaults to tickets by order of creation.
 *	@return array An array of arrays, each primary item containing the following:
 *	<ul>
 *	<li>id: Main ticket id</li>
 *	<li>display_id: Formatted ticket id in [0000x] format</li>
 *	<li>subject: Ticket subject</li>
 *	<li>short_subject: Shortened version of ticket subject</li>
 *	<li>href: Ticket href</li>
 *	<li>opener: array of details about the ticket starter:
 *		<ul>
 *			<li>id: user id of the person who opened the ticket</li>
 *			<li>name: username of the person who opened the ticket</li>
 *			<li>link: link to the profile of the person who opened the ticket</li>
 *		</ul>
 *	</li>
 *	<li>replier: array of details about the last person to reply to the ticket:
 *		<ul>
 *			<li>id: user id of the last person to reply to the ticket</li>
 *			<li>name: username of the last person to reply to the ticket</li>
 *			<li>link: link to the profile of the last person to reply to the ticket</li>
 *		</ul>
 *	</li>
 *	<li>opener: array of details about the person who the ticket is assigned to:
 *		<ul>
 *			<li>id: user id of the person who the ticket is assigned to</li>
 *			<li>name: username of the person who the ticket is assigned to or 'Unassigned' otherwise</li>
 *			<li>link: link to the profile of the person  who the ticket is assigned to or 'Unassigned' otherwise</li>
 *		</ul>
 *	</li>
 *	<li>num_replies: Number of replies in the ticket</li>
 *	<li>start_time: Formatted string of time the ticket was opened</li>
 *	<li>start_timestamp: Raw timestamp (adjusted for timezones) of ticket being opened</li>
 *	<li>last_time: Formatted string of time the ticket was last replied to</li>
 *	<li>last_timestamp: Raw timestamp (adjusted for timezones) of ticket's last reply</li>
 *	<li>private: Whether the ticket is private or not</li>
 *	<li>urgency_id: Number representing ticket urgency</li>
 *	<li>urgency_text: String representing ticket urgency</li>
 *	<li>status_id: Number representing ticket status</li>
 *	<li>status_text: String representing ticket status</li>
 *	</ul>
 *	@since 2.0
*/
function ssi_getSDTickets($query_where, $query_where_params = array(), $query_limit = 0, $query_order = 'hdt.id_ticket ASC', $output_method = 'echo')
{
	global $smcFunc, $scripturl, $txt, $modSettings;

	$query_limit = (int) $query_limit;

	$query = shd_db_query('', '
		SELECT hdt.id_ticket, hdt.subject, hdt.num_replies, hdt.private, hdt.urgency, hdt.status,
			hdtr_first.poster_time AS start_time, hdt.last_updated AS last_time,
			IFNULL(mem.real_name, hdtr_first.poster_name) AS starter_name, IFNULL(mem.id_member, 0) AS starter_id,
			IFNULL(ma.real_name, 0) AS assigned_name, IFNULL(ma.id_member, 0) AS assigned_id,
			IFNULL(mm.real_name, hdtr_last.modified_name) AS modified_name, IFNULL(mm.id_member, 0) AS modified_id
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_first ON (hdt.id_first_msg = hdtr_first.id_msg)
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_last ON (hdt.id_last_msg = hdtr_last.id_msg)
			LEFT JOIN {db_prefix}members AS mem ON (hdt.id_member_started = mem.id_member)
			LEFT JOIN {db_prefix}members AS ma ON (hdt.id_member_assigned = ma.id_member)
			LEFT JOIN {db_prefix}members AS mm ON (hdt.id_member_updated = mm.id_member)
		WHERE {query_see_ticket} AND ' . $query_where . '
		ORDER BY ' . $query_order . '
		' . ($query_limit == 0 ? '' : 'LIMIT ' . $query_limit),
		array_merge($query_where_params, array(
		))
	);

	$tickets = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		censorText($row['subject']);

		$tickets[] = array(
			'id' => $row['id_ticket'],
			'display_id' => str_pad($row['id_ticket'], $modSettings['shd_zerofill'], '0', STR_PAD_LEFT),
			'subject' => $row['subject'],
			'short_subject' => shorten_subject($row['subject'], 25),
			'href' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $row['id_ticket'],
			'opener' => array(
				'id' => $row['starter_id'],
				'name' => $row['starter_name'],
				'link' => shd_profile_link($row['starter_name'], $row['starter_id']),
			),
			'replier' => array(
				'id' => $row['modified_id'],
				'name' => $row['modified_name'],
				'link' => shd_profile_link($row['modified_name'], $row['modified_id']),
			),
			'assigned' => array(
				'id' => $row['assigned_id'],
				'name' => empty($row['assigned_name']) ? $txt['shd_unassigned'] : $row['assigned_name'],
				'link' => empty($row['assigned_name']) ? '<span class="error">' . $txt['shd_unassigned'] . '</span>' : shd_profile_link($row['assigned_name'], $row['assigned_id']),
			),
			'start_time' => timeformat($row['start_time']),
			'start_timestamp' => forum_time(true, $row['start_time']),
			'last_time' => timeformat($row['last_time']),
			'last_timestamp' => forum_time(true, $row['last_time']),
			'num_replies' => $row['num_replies'],
			'private' => !empty($row['private']),
			'urgency_id' => $row['urgency'],
			'urgency_string' => $txt['shd_urgency_' . $row['urgency']],
			'status_id' => $row['status'],
			'status_text' => $txt['shd_status_' . $row['status']],
		);
	}

	$smcFunc['db_free_result']($query);

	if (empty($tickets) || $output_method != 'echo')
		return $tickets;

	// output this stuff
	echo '
		<table border="0" class="ssi_table">';
	foreach ($tickets as $ticket)
		echo '
			<tr>
				<td align="right" valign="top" nowrap="nowrap">
					[', $ticket['status_text'], ']
				</td>
				<td valign="top">
					<a href="', $ticket['href'], '">', $ticket['subject'], '</a>
					', $txt['by'], ' ', $ticket['replier']['link'], '
				</td>
				<td align="right" nowrap="nowrap">
					', $ticket['last_time'], '
				</td>
			</tr>';
	echo '
		</table>';
}

/**
 *	Gets a list of all staff members within the helpdesk.
 *
 *	@param boolean $honour_admin_setting Within the administration panel is the option to exclude forum admins from being considered staff (so can't assign tickets to them). If true (default), assume the outcome of that should be applied here too.
 *	@param string $output_method Leave as default or explicitly set to 'echo' for this function to output a list of helpdesk staff members, set to 'array' to block output, and have the standard contents back.
 *	@return array The return is always an array of members that are staff; contains many details about members since SMF's member context is loaded (including avatar, personal text and so on)
 *	@since 2.0
*/
function ssi_staffMembers($honour_admin_setting = true, $output_method = 'echo')
{
	global $modSettings, $smcFunc, $memberContext;

	$staff = shd_members_allowed_to('shd_staff');

	if ($honour_admin_setting && !empty($modSettings['shd_admins_not_assignable']))
	{
		$admins = array();
		$query = $smcFunc['db_query']('', '
			SELECT id_member
			FROM {db_prefix}members
			WHERE id_group = {int:id_group}
				OR FIND_IN_SET({int:id_group}, additional_groups)',
			array(
				'id_group' => 1,
			)
		);
		while ($row = $smcFunc['db_fetch_row']($query))
			$admins[] = $row[0];

		$staff = array_diff($staff, $admins);
	}

	if (empty($staff))
		return array();

	loadMemberData($staff);

	if ($output_method == 'echo')
		echo '
		<table border="0" class="ssi_table">';

	$query_members = array();
	foreach ($staff as $member)
	{
		// Load their context data.
		if (!loadMemberContext($member))
			continue;

		// Store this member's information.
		$query_members[$member] = $memberContext[$member];

		// Only do something if we're echo'ing.
		if ($output_method == 'echo')
			echo '
			<tr>
				<td align="right" valign="top" nowrap="nowrap">
					', $query_members[$member]['link'], '
					<br />', $query_members[$member]['blurb'], '
					<br />', $query_members[$member]['avatar']['image'], '
				</td>
			</tr>';
	}

	// End the table if appropriate.
	if ($output_method == 'echo')
		echo '
		</table>';

	// Send back the data.
	return $query_members;
}

?>