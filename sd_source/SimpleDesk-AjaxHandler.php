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
# File Info: SimpleDesk-AjaxHandler.php / 1.0 Felidae         #
###############################################################

/**
 *	This file handles all the actions that can be carried out through AJAX methods, performing them and providing adequate feedback/information.
 *
 *	@package source
 *	@since 1.0
*/

if (!defined('SMF'))
	die('Hacking attempt...');

// This file handles AJAX actions. This file accepts params and only dumps XML out, much like News.php we do it all here.
// What happens is we expect $context['ajax_return'], an array of responses, to be populated.
// key => value for single XML tag, key => array (values) for multiple tags
// e.g. array('errors' => 'You do not have permission') => <errors><![CDATA[You do not have permission]]></errors>
// or array('data' => array('myval1', 'myval2')) => <data><![CDATA[myval1]]></data> <data><![CDATA[myval2]]></data>

/**
 *	Receives AJAX requests and facilitates replying to them.
 *
 *	This function sets up and calls the AJAX handlers; it is the primary receiver for action=helpdesk;sa=ajax.
 *
 *	Primarily, it expects $context['ajax_return'] to be populated as an array of tags to be returned as XML items to the user, with this element
 *	being a key-value pair (e.g. $context['ajax_return']['message'] = 'Success!') to be returned as a literal tag, element message, value of
 *	Success!, wrapped in the character data block.
 *
 *	An AJAX handler function may also return content in $context['ajax_raw'], this is when the function has prepared its own XML block to return.
 *	In such an instance, this function simply outputs the xml headers and assumes the return value is otherwise value.
 *
 *	For example, if the error subarray is populated (['error'] = 'Insufficient permission'), the XML block will contain a tag called error,
 *	with a CDATA block containing 'Insufficient permission'.
 *
 *	@since 1.0
*/
function shd_ajax()
{
	global $context;

	// Just in case
	loadLanguage('Errors');

	$subactions = array(
		'privacy' => 'shd_ajax_privacy',
		'urgency' => 'shd_ajax_urgency',
		'quote' => 'shd_ajax_quote',
		'assign' => 'shd_ajax_assign',
		'assign2' => 'shd_ajax_assign2',
	);

	$context['ajax_return'] = array();
	$context['ajax_raw'] = '';

	if (!empty($_REQUEST['op']) && !empty($subactions[$_REQUEST['op']]))
		$subactions[$_REQUEST['op']]();

	header('Content-Type: text/xml; charset=' . (empty($context['character_set']) ? 'ISO-8859-1' : $context['character_set']));
	echo '<?xml version="1.0" encoding="', $context['character_set'], '"?' . '>';

	if (empty($context['ajax_raw'])) // if something wants to do something funky, let it otherwise use the standard format
	{
		echo '<response>';

		if (!empty($context['ajax_return']))
		{
			foreach ($context['ajax_return'] as $key => $value)
			{
				if (empty($value)) // for <tag />
					echo '
	<', $key, ' />';
				else
				{
					$value = (array) $value;
					foreach ($value as $thisvalue)
						echo '
	<', $key, '><![CD', 'ATA[', $thisvalue, ']', ']></', $key, '>';
				}
			}
		}

		echo '
</response>';
	}
	else
	{
		echo $context['ajax_raw']; // assumed to be just well formed XML sans the header
	}
	obExit(false);
}

/**
 *	Handles AJAX updates to privacy.
 *
 *	Receives a request via ?action=helpdesk;sa=ajax;op=privacy to flip the privacy setting.
 *
 *	Operations:
 *	- silent session check; if fail, add to $context['ajax_return']['error']
 *	- ticket id check; if fail, add to $context['ajax_return']['error']
 *	- get enough ticket data to do this
 *	- check if the ticket is not able to be updated (either is closed/deleted, or insufficient permissions); if fail add to $context['ajax_return']['error']
 *	- switch privacy, update database
 *	- clear the cache of tickets for the Helpdesk menu item
 *	- return $context['ajax_return']['message'] as the new privacy item
*/
function shd_ajax_privacy()
{
	global $smcFunc, $user_info, $context, $txt, $sourcedir;

	$session_check = checkSession('get', '', false); // check the session but don't die fatally.
	if (!empty($session_check))
	{
		$context['ajax_return'] = array('error' => $txt[$session_check]);
		return;
	}

	// First, figure out the state of the ticket - is it private or not? Can we even see it?
	if (empty($context['ticket_id']))
	{
		$context['ajax_return'] = array('error' => $txt['shd_no_ticket']);
		return;
	}

	$query = shd_db_query('', '
		SELECT id_member_started, subject, private, status, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:current_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
		)
	);

	if ($row = $smcFunc['db_fetch_assoc']($query))
	{
		if (in_array($row['status'], array(TICKET_STATUS_CLOSED, TICKET_STATUS_DELETED)) || !shd_allowed_to('shd_alter_privacy_any', $row['id_dept']) && (!shd_allowed_to('shd_alter_privacy_own', $row['id_dept']) || $row['id_member_started'] != $user_info['id']))
		{
			$context['ajax_return'] = array('error' => $txt['shd_cannot_change_privacy']);
			return;
		}

		$smcFunc['db_free_result']($query);

		$new = empty($row['private']) ? 1 : 0;
		$action = empty($row['private']) ? 'markprivate' : 'marknotprivate';

		require_once($sourcedir . '/sd_source/Subs-SimpleDeskPost.php');
		$msgOptions = array();
		$posterOptions = array();
		$ticketOptions = array(
			'id' => $context['ticket_id'],
			'private' => empty($row['private']),
		);

		shd_modify_ticket_post($msgOptions, $ticketOptions, $posterOptions);

		shd_log_action($action,
			array(
				'ticket' => $context['ticket_id'],
				'subject' => $row['subject'],
			)
		);

		// Make sure we recalculate the number of tickets on next page load
		shd_clear_active_tickets($row['id_dept']);

		$context['ajax_return'] = array('message' => $new ? $txt['shd_ticket_private'] : $txt['shd_ticket_notprivate']);
	}
	else
	{
		$context['ajax_return'] = array('error' => $txt['shd_no_ticket']);
		return;
	}
}

/**
 *	Handles AJAX updates to ticket urgency.
 *
 *	Receives request through ?action=helpdesk;sa=ajax;op=urgency;change=x where x is increase or decrease.
 *
 *	Operations:
 *	- silent session check; if fail, add to $context['ajax_return']['error']
 *	- ticket id check; if fail, add to $context['ajax_return']['error']
 *	- get enough ticket data to do this
 *	- check permissions with {@link shd_can_alter_urgency()} and permissions; if fail, add to $context['ajax_return']['error']
 *	- identify whether the new urgency needs 'urgent' styling or not and put the new urgency in $context['ajax_return']['message']
 *	- update the database with the new urgency
 *	- identify whether the new urgency continues to allow the current user to change urgency or not
 *	- put the button links if appropriate into $context['ajax_return']['increase'] and $context['ajax_return']['decrease'] and return
*/
function shd_ajax_urgency()
{
	global $smcFunc, $user_info, $context, $txt, $scripturl, $settings, $sourcedir;

	$session_check = checkSession('get', '', false); // check the session but don't die fatally.
	if (!empty($session_check))
	{
		$context['ajax_return'] = array('error' => $txt[$session_check]);
		return;
	}

	// First, figure out the state of the ticket - is it private or not? Can we even see it?
	if (empty($context['ticket_id']))
	{
		$context['ajax_return'] = array('error' => $txt['shd_no_ticket']);
		return;
	}

	$query = shd_db_query('', '
		SELECT id_member_started, subject, urgency, status, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:current_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
		)
	);

	if ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$can_urgency = shd_can_alter_urgency($row['urgency'], $row['id_member_started'], ($row['status'] == TICKET_STATUS_CLOSED), ($row['status'] == TICKET_STATUS_DELETED), $row['id_dept']);

		if (empty($_GET['change']) || empty($can_urgency[$_GET['change']]))
		{
			$context['ajax_return'] = array('error' => $txt['shd_cannot_change_urgency']);
			return;
		}

		$new_urgency = $row['urgency'] + ($_GET['change'] == 'increase' ? 1 : -1);
		$action = 'urgency_' . $_GET['change'];

		require_once($sourcedir . '/sd_source/Subs-SimpleDeskPost.php');
		$msgOptions = array();
		$posterOptions = array();
		$ticketOptions = array(
			'id' => $context['ticket_id'],
			'urgency' => $new_urgency,
		);

		shd_modify_ticket_post($msgOptions, $ticketOptions, $posterOptions);

		shd_log_action($action,
			array(
				'ticket' => $context['ticket_id'],
				'subject' => $row['subject'],
				'urgency' => $new_urgency,
			)
		);

		$new_options = shd_can_alter_urgency($new_urgency, $row['id_member_started'], ($row['status'] == TICKET_STATUS_CLOSED), ($row['status'] == TICKET_STATUS_DELETED), $row['id_dept']);

		$context['ajax_return'] = array(
			'message' => $new_urgency > TICKET_URGENCY_HIGH ? '<span class="error">' . $txt['shd_urgency_' . $new_urgency] . '</span>' : $txt['shd_urgency_' . $new_urgency],
		);

		$array = array(
			'increase' => '<a id="urglink_increase" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket_id'] . ';change=increase;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_increase'] . '"><img src="' . $settings['images_url'] . '/sort_up.gif" width="9px" alt="' . $txt['shd_urgency_increase'] . '" /></a>',
			'decrease' => '<a id="urglink_decrease" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket_id'] . ';change=decrease;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_decrease'] . '"><img src="' . $settings['images_url'] . '/sort_down.gif" width="9px" alt="' . $txt['shd_urgency_decrease'] . '" /></a>',
		);

		foreach ($new_options as $button => $can)
			if ($can)
				$context['ajax_return'][$button] = $array[$button];

		return;
	}
	else
	{
		$context['ajax_return'] = array('error' => $txt['shd_no_ticket']);
		return;
	}
}

/**
 *	Collects ticket post data for quoting posts through AJAX (i.e. inserting a quote live into the postbox)
 *
 *	Operations:
 *	- Session check; failing in a regular fashion (as opposed to normal return since we're using ;xml in the URL; the SMF handler can deal with that)
 *	- If a message id is provided, query for it. If not found (or not provided), die, otherwise continue.
 *	- Call un_preparsecode to remove extraneous sanity encoding.
 *	- Build the [quote] bbcode around the post body.
 *	- Convert to SMF style BBC-to-HTML if using WYSIWYG
 *	- Do other XML sanitising
 *	- Return via $context['ajax_raw'] for {@link shd_ajax()} to output
*/
function shd_ajax_quote()
{
	global $modSettings, $user_info, $txt, $settings, $context;
	global $sourcedir, $smcFunc;

	loadLanguage('Post');
	checkSession('get');

	include_once($sourcedir . '/Subs-Post.php');

	$_REQUEST['quote'] = !empty($_REQUEST['quote']) ? (int) $_REQUEST['quote'] : 0;
	$message = '';
	if (!empty($_REQUEST['quote']))
	{
		$query = shd_db_query('', '
			SELECT hdtr.body, IFNULL(mem.real_name, hdtr.poster_name) AS poster_name, hdtr.poster_time, hdt.id_ticket, hdt.id_first_msg
			FROM {db_prefix}helpdesk_ticket_replies AS hdtr
				INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdtr.id_ticket = hdt.id_ticket)
				LEFT JOIN {db_prefix}members AS mem ON (hdtr.id_member = mem.id_member)
			WHERE {query_see_ticket}
				AND id_msg = {int:msg}',
			array(
				'msg' => $_REQUEST['quote'],
			)
		);

		if ($row = $smcFunc['db_fetch_assoc']($query))
		{
			$smcFunc['db_free_result']($query);
			$row['body'] = un_preparsecode($row['body']);

			// Censor the message!
			censorText($row['body']);
			$row['body'] = preg_replace('~<br ?/?' . '>~i', "\n", $row['body']);

			if (strpos($row['poster_name'], '[') !== false || strpos($row['poster_name'], ']') !== false)
				$row['poster_name'] = '"' . $row['poster_name'] . '"';

			// Make the body HTML if need be.
			if (!empty($_REQUEST['mode']))
			{
				require_once($sourcedir . '/Subs-Editor.php');
				$row['body'] = strtr($row['body'], array('&lt;' => '#smlt#', '&gt;' => '#smgt#', '&amp;' => '#smamp#'));
				$row['body'] = bbc_to_html($row['body']);
				$lb = '<br />';
			}
			else
				$lb = "\n";

			$message = '[quote author=' . $row['poster_name'] . ' link=action=helpdesk;sa=ticket;ticket=' . $row['id_ticket'];
			if ($row['id_first_msg'] != $_REQUEST['quote']) // don't add the msg if we're quoting the ticket itself
				$message .= '.msg' . $_REQUEST['quote'] . '#msg' . $_REQUEST['quote'];

			$message .= ' date=' . $row['poster_time'] . ']' . $lb . $row['body'] . $lb . '[/quote]';
		}
	}

	$message = strtr($message, array('&nbsp;' => '&#160;', '<' => '&lt;', '>' => '&gt;'));

	$context['ajax_raw'] = '<quote>' . $message . '</quote>';
}

/**
 *	Returns the list of possible assignees for a ticket for AJAX assignment purposes.
 *
 *	Operations:
 *	- Session check
 * 	- Permissions check (that you can assign a ticket to someone else); if you can't assign a ticket to someone else, bail.
 *	- Get the list of information for a ticket (which implicitly checks ticket access); if you can't see the ticket, bail.
 *	- Get the list of who can be assigned a ticket.
 *	- Return that via AJAX.
*/
function shd_ajax_assign()
{
	global $context, $smcFunc, $txt, $sourcedir, $user_profile;

	checkSession('get');

	if (!empty($context['ticket_id']))
	{
		$query = shd_db_query('', '
			SELECT hdt.private, hdt.id_member_started, id_member_assigned, id_dept, 1 AS valid
			FROM {db_prefix}helpdesk_tickets AS hdt
			WHERE {query_see_ticket}
				AND hdt.id_ticket = {int:ticket}',
			array(
				'ticket' => $context['ticket_id'],
			)
		);
		if ($smcFunc['db_num_rows']($query) != 0)
			list($private, $ticket_starter, $ticket_assigned, $dept, $valid) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);
	}
	if (empty($valid))
		return $context['ajax_return'] = array('error' => $txt['shd_no_ticket']);

	require_once($sourcedir . '/sd_source/SimpleDesk-Assign.php');
	$assignees = shd_get_possible_assignees($private, $ticket_starter, $dept);
	array_unshift($assignees, 0); // add the unassigned option in at the start

	if (empty($assignees))
		return $context['ajax_return'] = array('error' => $txt['shd_no_staff_assign']);

	if (!shd_allowed_to('shd_assign_ticket_any', $dept))
		return $context['ajax_return'] = array('error' => $txt['shd_cannot_assign']);

	// OK, so we have the general values we need. Let's get user names, and get ready to kick this back to the user. We'll build the XML here though.
	loadMemberData($assignees);

	// Just out of interest, who's an admin?
	$admins = shd_members_allowed_to('admin_helpdesk', $dept);

	$context['ajax_raw'] = '<response>';
	foreach ($assignees as $assignee)
		$context['ajax_raw'] .= '
<member uid="' . $assignee . '"' . (!empty($assignee) ? (in_array($assignee, $admins) ? ' admin="yes"' : ' admin="no"') : '') . ($ticket_assigned == $assignee ? ' assigned="yes"' : '') . '><![CD' . 'ATA[' .(empty($assignee) ? '<span class="error">' . $txt['shd_unassigned'] . '</span>' : $user_profile[$assignee]['member_name']) . ']' . ']></member>';

	$context['ajax_raw'] .= '
</response>';
}

/**
 *	Action a new assignment via AJAX.
 *
 *	Operations:
 *	- Session check
 * 	- Permissions check (that you can assign a ticket to someone else); if you can't assign a ticket to someone else, bail.
 *	- Get the list of information for a ticket (which implicitly checks ticket access); if you can't see the ticket, bail.
 *	- Get the list of who can be assigned a ticket; if requested user not on that list, bail.
 *	- Update and build return status, and return via AJAX.
 */

function shd_ajax_assign2()
{
	global $context, $smcFunc, $txt, $sourcedir, $user_profile;

	checkSession('get');

	if (!empty($context['ticket_id']))
	{
		$query = shd_db_query('', '
			SELECT hdt.private, hdt.id_member_started, id_member_assigned, subject, id_dept, 1 AS valid
			FROM {db_prefix}helpdesk_tickets AS hdt
			WHERE {query_see_ticket}
				AND hdt.id_ticket = {int:ticket}',
			array(
				'ticket' => $context['ticket_id'],
			)
		);
		if ($smcFunc['db_num_rows']($query) != 0)
			list($private, $ticket_starter, $ticket_assigned, $subject, $dept, $valid) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);
	}
	if (empty($valid))
		return $context['ajax_return'] = array('error' => $txt['shd_no_ticket']);

	if (!isset($_GET['to_user']) || !is_numeric($_GET['to_user']))
		return $context['ajax_return'] = array('error' => $txt['shd_assigned_not_permitted'] . 'line459');

	if (!shd_allowed_to('shd_assign_ticket_any', $dept))
		return $context['ajax_return'] = array('error' => $txt['shd_cannot_assign']);

	$_GET['to_user'] = isset($_GET['to_user']) ? (int) $_GET['to_user'] : 0;

	require_once($sourcedir . '/sd_source/SimpleDesk-Assign.php');
	$assignees = shd_get_possible_assignees($private, $ticket_starter, $dept);
	array_unshift($assignees, 0); // add the unassigned option in at the start

	if (!in_array($_GET['to_user'], $assignees))
		return $context['ajax_return'] = array('error' => $txt['shd_assigned_not_permitted']);

	if (!empty($_GET['to_user']))
		loadMemberData($_GET['to_user']);

	$user_name = shd_profile_link(empty($_GET['to_user']) ? '<span class="error">' . $txt['shd_unassigned'] . '</span>' : $user_profile[$_GET['to_user']]['member_name'], $_GET['to_user']);

	// If it's being assigned to the current assignee, don't bother actually requesting the change.
	if ($_GET['to_user'] != $ticket_assigned)
	{
		$log_params = array(
			'subject' => $subject,
			'ticket' => $context['ticket_id'],
			'user_id' => $_GET['to_user'],
			'user_name' => $user_name,
		);
		shd_log_action('assign', $log_params);
		shd_commit_assignment($context['ticket_id'], $_GET['to_user'], true);
	}

	return $context['ajax_return'] = array('assigned' => $user_name);
}

?>