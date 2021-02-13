<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2021 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1 RC1                                 *
* File Info: SimpleDesk-AjaxHandler.php                       *
**************************************************************/

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
	$context['is_ajax_resonse'] = true;
	loadLanguage('Errors');

	$subactions = array(
		'privacy' => 'shd_ajax_privacy',
		'urgency' => 'shd_ajax_urgency',
		'urgencylist' => 'shd_ajax_urgencylist',
		'quote' => 'shd_ajax_quote',
		'assign' => 'shd_ajax_assign',
		'assign2' => 'shd_ajax_assign2',
		'canned' => 'shd_ajax_canned',
		'notify' => 'shd_ajax_notify',
	);

	$context['ajax_return'] = array();
	$context['ajax_raw'] = '';

	if (!empty($_REQUEST['op']) && !empty($subactions[$_REQUEST['op']]))
		$result = $subactions[$_REQUEST['op']]();

	if (empty($context['ajax_return']) && empty($context['ajax_raw']) && !empty($result))
		$context['ajax_return'] = $result;

	return shd_ajax_json_response();
}

/**
 *	Handles returning a response in JSON format
 *
 *  @since 2.1
*/
function shd_ajax_json_response()
{
	global $context;

	header('Content-Type: application/json; charset=UTF8');

	if (empty($context['ajax_raw']) && is_array($context['ajax_return']) && isset($context['ajax_return']['success']))
		echo json_encode($context['ajax_return']);
	elseif (empty($context['ajax_raw']) && is_array($context['ajax_return']))
		echo json_encode(array_merge(array('success' => true), $context['ajax_return']));
	elseif (!empty($context['ajax_raw']) && is_array($context['ajax_raw']))
		echo json_encode($context['ajax_return']);
	elseif (!empty($context['ajax_raw']))
		echo $context['ajax_raw'];
	else
		echo json_encode(array('success' => false));

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
 *
 *	@return array Response data for Ajax.
 *  @since 1.0
*/
function shd_ajax_privacy()
{
	global $smcFunc, $user_info, $context, $txt, $sourcedir;

	$session_check = checkSession('get', '', false); // check the session but don't die fatally.
	if (!empty($session_check))
		return array('success' => false, 'error' => $txt[$session_check]);

	// First, figure out the state of the ticket - is it private or not? Can we even see it?
	if (empty($context['ticket_id']))
		return array('success' => false, 'error' => $txt['shd_no_ticket']);

	$query = shd_db_query('', '
		SELECT id_member_started, subject, private, status, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:current_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
		)
	);

	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	// No ticket, no luck.
	if (empty($row))
		return array('success' => false, 'error' => $txt['shd_no_ticket']);
		
	if (in_array($row['status'], array(TICKET_STATUS_CLOSED, TICKET_STATUS_DELETED)) || !shd_allowed_to('shd_alter_privacy_any', $row['id_dept']) && (!shd_allowed_to('shd_alter_privacy_own', $row['id_dept']) || $row['id_member_started'] != $user_info['id']))
		return array('success' => false, 'error' => $txt['shd_cannot_change_privacy']);

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

	shd_log_action($action, array(
		'ticket' => $context['ticket_id'],
		'subject' => $row['subject'],
	));

	// Make sure we recalculate the number of tickets on next page load
	shd_clear_active_tickets($row['id_dept']);

	return array('success' => true, 'message' => $new ? $txt['shd_ticket_private'] : $txt['shd_ticket_notprivate']);
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
 *
 *	@return array Response data for Ajax.
 *  @since 1.0
*/
function shd_ajax_urgency()
{
	global $smcFunc, $user_info, $context, $txt, $scripturl, $settings, $sourcedir;

	$session_check = checkSession('get', '', false); // check the session but don't die fatally.
	if (!empty($session_check))
		return array('success' => false, 'error' => $txt[$session_check]);

	// First, figure out the state of the ticket - is it private or not? Can we even see it?
	if (empty($context['ticket_id']))
		return array('success' => false, 'error' => $txt['shd_no_ticket']);

	$query = shd_db_query('', '
		SELECT id_member_started, subject, urgency, status, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:current_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
		)
	);

	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	// No ticket, no luck.
	if (empty($row))
		return array('error' => $txt['shd_no_ticket']);

	// We will need this later.
	require_once($sourcedir . '/sd_source/Subs-SimpleDeskPost.php');

	// If being assigned from the list, we do it differently.
	if (isset($_GET['assign']) && isset($_GET['urgency']) && ctype_digit($_GET['urgency']))
	{
		shd_get_urgency_options($row['id_member_started'] == $user_info['id'], $row['id_dept']);

		if (empty($context['ticket_form']['urgency']['options'][$_GET['urgency']]))
			return array('success' => false, 'error' => $txt['shd_cannot_change_urgency']);

		$new_urgency = (int) $_GET['urgency'];
		$action = 'urgency_change';
	}
	else
	{
		$can_urgency = shd_can_alter_urgency($row['urgency'], $row['id_member_started'], ($row['status'] == TICKET_STATUS_CLOSED), ($row['status'] == TICKET_STATUS_DELETED), $row['id_dept']);

		if (empty($_GET['change']) || empty($can_urgency[$_GET['change']]))
			return array('success' => false, 'error' => $txt['shd_cannot_change_urgency']);

		$new_urgency = $row['urgency'] + ($_GET['change'] == 'increase' ? 1 : -1);
		$action = 'urgency_' . $_GET['change'];
	}

	// Build the modify information.
	$msgOptions = array();
	$posterOptions = array();
	$ticketOptions = array(
		'id' => $context['ticket_id'],
		'urgency' => $new_urgency,
	);

	shd_modify_ticket_post($msgOptions, $ticketOptions, $posterOptions);

	shd_log_action($action, array(
		'ticket' => $context['ticket_id'],
		'subject' => $row['subject'],
		'urgency' => $new_urgency,
	));

	$new_options = shd_can_alter_urgency($new_urgency, $row['id_member_started'], ($row['status'] == TICKET_STATUS_CLOSED), ($row['status'] == TICKET_STATUS_DELETED), $row['id_dept']);

	$context['ajax_return'] = array(
		'success' => true,
		'message' => $new_urgency > TICKET_URGENCY_HIGH ? '<span class="error">' . $txt['shd_urgency_' . $new_urgency] . '</span>' : $txt['shd_urgency_' . $new_urgency],
	);

	$array = array(
		'increase' => '<a id="urglink_increase" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket_id'] . ';change=increase;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_increase'] . '"><span class="generic_icons urgency_increase" title="' . $txt['shd_urgency_increase'] . '"></span></a>',
		'decrease' => '<a id="urglink_decrease" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket_id'] . ';change=decrease;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_decrease'] . '"><span class="generic_icons urgency_decrease" title="' . $txt['shd_urgency_decrease'] . '"></span></a>',
	);

	foreach ($new_options as $button => $can)
		if ($can)
			$context['ajax_return'][$button] = $array[$button];

	return $context['ajax_return'];
}

/**
 *	Handles AJAX updates to ticket urgency list.
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
 *
 *	@return array Response data for Ajax.
 *  @since 2.1
*/
function shd_ajax_urgencylist()
{
	global $smcFunc, $user_info, $context, $txt, $scripturl, $settings, $sourcedir;

	$session_check = checkSession('get', '', false); // check the session but don't die fatally.
	if (!empty($session_check))
		return array('success' => false, 'error' => $txt[$session_check]);

	// First, figure out the state of the ticket - is it private or not? Can we even see it?
	if (empty($context['ticket_id']))
		return array('success' => false, 'error' => $txt['shd_no_ticket']);

	$query = shd_db_query('', '
		SELECT id_member_started, subject, urgency, status, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:current_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
		)
	);

	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	// No ticket, no luck.
	if (empty($row))
		return array('error' => $txt['shd_no_ticket']);

	// Build the list.
	$context['ajax_return'] = array(
		'success' => true,
		'urgencies' => array(),
	);

	// Get the options.
	require_once($sourcedir . '/sd_source/Subs-SimpleDeskPost.php');
	shd_get_urgency_options($row['id_member_started'] == $user_info['id'], $row['id_dept']);

	foreach ($context['ticket_form']['urgency']['options'] as $urgency => $urgency_txt)
	{
		$can_urgency = shd_can_alter_urgency($urgency, $row['id_member_started'], ($row['status'] == TICKET_STATUS_CLOSED), ($row['status'] == TICKET_STATUS_DELETED), $row['id_dept']);

		// Can't do this either way? Don't show this as a option.
		if (empty($can_urgency['increase']) && empty($can_urgency['decrease']))
			continue;

		$context['ajax_return']['urgencies'][$urgency] = array(
			'id' => $urgency,
			'name' => $txt[$urgency_txt],
			'selected' => $row['urgency'] == $urgency,
		);
	}
	
	return $context['ajax_return'];
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
 *
 *	@return array Response data for Ajax.
 *  @since 1.0
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

	// Nothing to quote, blank message.
	if (empty($_REQUEST['quote']))
		return array('success' => true, 'message' => $message);

	$query = shd_db_query('', '
		SELECT hdtr.body, COALESCE(mem.real_name, hdtr.poster_name) AS poster_name, hdtr.poster_time, hdt.id_ticket, hdt.id_first_msg
		FROM {db_prefix}helpdesk_ticket_replies AS hdtr
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdtr.id_ticket = hdt.id_ticket)
			LEFT JOIN {db_prefix}members AS mem ON (hdtr.id_member = mem.id_member)
		WHERE {query_see_ticket}
			AND id_msg = {int:msg}',
		array(
			'msg' => $_REQUEST['quote'],
		)
	);

	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	// Can't find this, no quote.
	if (empty($row))
		return array('success' => true, 'message' => $message);
		
	// Censor the message!
	$row['body'] = un_preparsecode($row['body']);
	censorText($row['body']);
	$row['body'] = preg_replace('~<br ?/?' . '>~i', "\n", $row['body']);

	if (strpos($row['poster_name'], '[') !== false || strpos($row['poster_name'], ']') !== false)
		$row['poster_name'] = '"' . $row['poster_name'] . '"';

	$message = '[quote author=' . $row['poster_name'] . ' link=action=helpdesk;sa=ticket;ticket=' . $row['id_ticket'];

	// don't add the msg if we're quoting the ticket itself
	if ($row['id_first_msg'] != $_REQUEST['quote'])
		$message .= '.msg' . $_REQUEST['quote'] . '#msg' . $_REQUEST['quote'];

	$message .= ' date=' . $row['poster_time'] . ']' . "\n" . $row['body'] . "\n" . '[/quote]';
	return array('success' => true, 'message' => $message);
}

/**
 *	Collects a canned reply from the database and serves it via XML for insertion.
 *
 *	Operations:
 *	- Session check; failing in a regular fashion (as opposed to normal return since we're using ;xml in the URL; the SMF handler can deal with that)
 *	- Checks for a department number in the URL, validates access to that department then queries for the requested template.
 *	- Call un_preparsecode to remove extraneous sanity encoding.
 *	- Convert to SMF style BBC-to-HTML if using WYSIWYG
 *	- Do other XML sanitising
 *	- Return via $context['ajax_raw'] for {@link shd_ajax()} to output
 *
 *	@return array Response data for Ajax.
 *  @since 2.0
*/
function shd_ajax_canned()
{
	global $modSettings, $user_info, $txt, $settings, $context;
	global $sourcedir, $smcFunc;

	loadLanguage('Post');
	checkSession('get');

	include_once($sourcedir . '/Subs-Post.php');

	$_REQUEST['reply'] = !empty($_REQUEST['reply']) ? (int) $_REQUEST['reply'] : 0;
	$message = '';
	if (empty($_REQUEST['reply']) || empty($context['ticket_id']))
		return array('success' => true, 'message' => $message);

	$query = shd_db_query('', '
		SELECT hdt.id_member_started, hdt.id_dept, hdcr.body, hdcr.vis_user, hdcr.vis_staff
		FROM {db_prefix}helpdesk_tickets AS hdt
			INNER JOIN {db_prefix}helpdesk_cannedreplies_depts AS hdcrd ON (hdt.id_dept = hdcrd.id_dept)
			INNER JOIN {db_prefix}helpdesk_cannedreplies AS hdcr ON (hdcrd.id_reply = hdcr.id_reply)
		WHERE hdt.id_ticket = {int:ticket}
			AND hdcr.id_reply = {int:reply}
			AND hdcr.active = 1
			AND {query_see_ticket}',
		array(
			'ticket' => $context['ticket_id'],
			'reply' => $_REQUEST['reply'],
		)
	);

	if (empty($smcFunc['db_num_rows']($query)))
	{
		$smcFunc['db_free_result']($query);
		return array('success' => true, 'message' => $message);
	}

	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	// Check ability to reply to this ticket. No ability to reply at all, no canned reply.
	if (!shd_allowed_to('shd_reply_ticket_own', $row['id_dept']) && !shd_allowed_to('shd_reply_ticket_any', $row['id_dept']))
		return array('success' => true, 'message' => $message);

	// Now check for can-reply-to-own (reply to any will pass this check correctly anyway)
	if (!shd_allowed_to('shd_reply_ticket_any', $row['id_dept']) && shd_allowed_to('shd_reply_ticket_own', $row['id_dept']) && $row['id_member_started'] != $user_info['id'])
		return array('success' => true, 'message' => $message);

	// Now verify the per-reply visibility. Only applies to non admins anyway...
	if (!shd_allowed_to('admin_helpdesk', $row['id_dept']) && !$user_info['is_admin'])
		if (shd_allowed_to('shd_staff', $row['id_dept']) && empty($row['vis_staff']))
			return array('success' => true, 'message' => $message);
		elseif (!shd_allowed_to('shd_staff', $row['id_dept']) && empty($row['vis_user']))
			return array('success' => true, 'message' => $message);

	// Censor the message!
	$message = un_preparsecode($row['body']);
	censorText($message);
	$message = preg_replace('~<br ?/?' . '>~i', "\n", $row['body']);

	$message = strtr($message, array('&nbsp;' => '&#160;', '<' => '&lt;', '>' => '&gt;'));
	return array('success' => true, 'message' => $message);
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
 *
 *	@return array Response data for Ajax.
 *  @since 1.0
*/
function shd_ajax_assign()
{
	global $context, $smcFunc, $txt, $sourcedir, $user_profile;

	checkSession('get');

	if (empty($context['ticket_id']))
		return array('success' => false, 'error' => $txt['shd_no_ticket']);

	$query = shd_db_query('', '
		SELECT hdt.private, hdt.id_member_started, id_member_assigned, id_dept, hdt.status
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND hdt.id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);
	if (empty($smcFunc['db_num_rows']($query)))
		return array('success' => false, 'error' => $txt['shd_no_ticket']);

	list($private, $ticket_starter, $ticket_assigned, $dept, $status) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	require_once($sourcedir . '/sd_source/SimpleDesk-Assign.php');
	$assignees = shd_get_possible_assignees($private, $ticket_starter, $dept);
	array_unshift($assignees, 0); // add the unassigned option in at the start

	if (empty($assignees))
		return array('success' => false, 'error' => $txt['shd_no_staff_assign']);

	if (!shd_allowed_to('shd_assign_ticket_any', $dept) || $status == TICKET_STATUS_CLOSED || $status == TICKET_STATUS_DELETED)
		return array('success' => false, 'error' => $txt['shd_cannot_assign']);

	// OK, so we have the general values we need. Let's get user names, and get ready to kick this back to the user. We'll build the XML here though.
	loadMemberData($assignees);

	// Just out of interest, who's an admin?
	$admins = shd_members_allowed_to('admin_helpdesk', $dept);

	$context['ajax_return'] = array('success' => true, 'members' => array());
	foreach ($assignees as $assignee)
		$context['ajax_return']['members'][$assignee] = array(
			'uid' => $assignee,
			'admin' => in_array($assignee, $admins) ? 'yes' : 'no',
			'assigned' => $ticket_assigned == $assignee ? 'yes' : 'no',
			'name' => empty($assignee) ? '<span class="error">' . $txt['shd_unassigned'] . '</span>' : $user_profile[$assignee]['member_name'],
		);

	return $context['ajax_return'];
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
 *
 *	@return array Response data for Ajax.
 *  @since 1.0
 */
function shd_ajax_assign2()
{
	global $context, $smcFunc, $txt, $sourcedir, $user_profile;

	checkSession('get');

	if (empty($context['ticket_id']))
		return array('error' => $txt['shd_no_ticket']);

	$query = shd_db_query('', '
		SELECT hdt.private, hdt.id_member_started, id_member_assigned, subject, id_dept, hdt.status
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND hdt.id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);
	if (empty($smcFunc['db_num_rows']($query)))
		return array('error' => $txt['shd_no_ticket']);

	list($private, $ticket_starter, $ticket_assigned, $subject, $dept, $status) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	if (!isset($_GET['to_user']) || !is_numeric($_GET['to_user']))
		return array('success' => false, 'error' => $txt['shd_assigned_not_permitted']);

	if (!shd_allowed_to('shd_assign_ticket_any', $dept) || $status == TICKET_STATUS_CLOSED || $status == TICKET_STATUS_DELETED)
		return array('success' => false, 'error' => $txt['shd_cannot_assign']);

	$_GET['to_user'] = isset($_GET['to_user']) ? (int) $_GET['to_user'] : 0;

	require_once($sourcedir . '/sd_source/SimpleDesk-Assign.php');
	$assignees = shd_get_possible_assignees($private, $ticket_starter, $dept);
	array_unshift($assignees, 0); // add the unassigned option in at the start

	if (!in_array($_GET['to_user'], $assignees))
		return array('success' => false, 'error' => $txt['shd_assigned_not_permitted']);

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

	return array('success' => true, 'assigned' => $user_name);
}

/**
 *	Provide the list of possible notification recipients.
 *
 *	@return array Response data for Ajax.
 *	@since 2.0
*/
function shd_ajax_notify()
{
	global $txt, $context, $smcFunc, $user_profile, $modSettings, $sourcedir;

	$session_check = checkSession('get', '', false); // check the session but don't die fatally.
	if (!empty($session_check))
		return array('success' => false, 'error' => $txt[$session_check]);

	shd_load_language('sd_language/SimpleDeskNotifications');
	require_once($sourcedir . '/sd_source/SimpleDesk-Notifications.php');

	if (empty($context['ticket_id']))
		return array('error' => $txt['shd_no_ticket']);

	$query = shd_db_query('', '
		SELECT hdt.private, hdt.id_member_started, id_member_assigned, id_dept, status
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND hdt.id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);
	if (empty($smcFunc['db_num_rows']($query)))
	{
		$smcFunc['db_free_result']($query);
		return array('success' => false, 'error' => $txt['shd_no_ticket']);
	}

	$ticket = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	if (empty($ticket) || !shd_allowed_to('shd_singleton_email', $ticket['id_dept']) || $ticket['status'] == TICKET_STATUS_CLOSED || $ticket['status'] == TICKET_STATUS_DELETED)
		return array('success' => false, 'error' => $txt['shd_no_ticket']);

	// So, we need to start figuring out who's going to be notified, who won't be and who we might be interested in notifying.
	$notify_list = array(
		'being_notified' => array(),
		'optional' => array(),
		'optional_butoff' => array(),
	);

	// Let's get all the possible actual people. The possible people who can be notified... well, they're staff.
	$staff = shd_get_visible_list($ticket['id_dept'], $ticket['private'], $ticket['id_member_started'], empty($modSettings['shd_admins_not_assignable']), false);

	// Let's start figuring it out then! First, get the big ol' lists.
	$query = $smcFunc['db_query']('', '
		SELECT id_member, notify_state
		FROM {db_prefix}helpdesk_notify_override
		WHERE id_ticket = {int:ticket}',
		array(
			'ticket' => $context['ticket_id'],
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$notify_list[$row['notify_state'] == NOTIFY_NEVER ? 'optional_butoff' : 'being_notified'][$row['id_member']] = true;

	// Did we exclude admins? If we did, we would have scooped the list of admins. If they're in the 'not being notified but you can...' list, remove them.
	if (!empty($context['list_admin_exclude']) && is_array($context['list_admin_exclude']))
		foreach ($context['list_admin_exclude'] as $user_id)
			if (isset($notify_list['optional_butoff'][$user_id]))
				unset($notify_list['optional_butoff'][$user_id]);

	// Now we get the list by preferences. This is where it starts to get complicated.
	$possible_members = array();
	// People who want replies to their own ticket, without including the ticket starter because they'd know about it...
	if (!empty($modSettings['shd_notify_new_reply_own']) && $context['user']['id'] != $ticket['id_member_started'])
		$possible_members[$ticket['id_member_started']]['new_reply_own'] = true;
	// The ticket is assigned to someone and they want to be notified if it changes.
	if (!empty($modSettings['shd_notify_new_reply_assigned']) && !empty($ticket['id_member_assigned']) && $context['user']['id'] != $ticket['id_member_assigned'])
		$possible_members[$ticket['id_member_assigned']]['new_reply_assigned'] = true;
	// So, if you're staff, and you've replied to this ticket before, do you want to be notified this time?
	if (!empty($modSettings['shd_notify_new_reply_previous']))
	{
		$query = $smcFunc['db_query']('', '
			SELECT id_member
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_ticket = {int:ticket}
			GROUP BY id_member',
			array(
				'ticket' => $context['ticket_id'],
			)
		);
		$responders = array();
		while ($row = $smcFunc['db_fetch_row']($query))
			$responders[] = $row[0]; // this shouldn't be nil, ever, because we're replying, so the topic already exists so there's at least one name in there...
		$smcFunc['db_free_result']($query);

		$responders = array_intersect($responders, $staff);
		foreach ($responders as $id)
			$possible_members[$id]['new_reply_previous'] = true;
	}
	// If you're staff, did you have 'spam my inbox every single time' selected?
	if (!empty($modSettings['shd_notify_new_reply_any']))
		foreach ($staff as $id)
			$possible_members[$id]['new_reply_any'] = true;

	// Now we have the list of possibles, exclude everyone who is either set to on, or off, since we don't need to query those for preferences.
	foreach ($possible_members as $id => $type_list)
		if (isset($notify_list['being_notified'][$id]) || isset($notify_list['optional_butoff'][$id]))
			unset($possible_members[$id]);

	if (!empty($possible_members))
	{
		// Get the default preferences
		$prefs = shd_load_user_prefs(false);
		$base_prefs = $prefs['prefs'];

		// Build a list of users -> default prefs. We know this is for the list of possible contenders only.
		$member_prefs = array();
		$pref_list = array();
		foreach ($possible_members as $id => $type_list)
		{
			foreach ($type_list as $type => $value)
			{
				$member_prefs[$id][$type] = $base_prefs['notify_' . $type]['default'];
				$pref_list['notify_' . $type] = true;
			}
		}

		// Grab pref list from DB for these users and update
		$query = $smcFunc['db_query']('', '
			SELECT id_member, variable, value
			FROM {db_prefix}helpdesk_preferences
			WHERE id_member IN ({array_int:members})
				AND variable IN ({array_string:variables})',
			array(
				'members' => array_keys($possible_members),
				'variables' => array_keys($pref_list),
			)
		);

		while ($row = $smcFunc['db_fetch_assoc']($query))
		{
			$row['id_member'] = (int) $row['id_member'];
			$variable = substr($row['variable'], 7);
			if (isset($member_prefs[$row['id_member']][$variable]))
				$member_prefs[$row['id_member']][$variable] = $row['value'];
		}
		$smcFunc['db_free_result']($query);

		// unset $members where member pref doesn't indicate they want it on.
		foreach ($member_prefs as $id => $value)
			foreach ($value as $pref_id => $pref_item)
				if (empty($pref_item))
					unset($possible_members[$id][$pref_id]);

		// Now, it's possible that we have a ticket that the starter can't see, but that their preferences would indicate they'd like a reply.
		// What should be done here is to remove them from the automatic list, and make them part of the ping list instead.
		if (!empty($ticket['id_member_started']) && !in_array($ticket['id_member_started'], $staff))
			$possible_members[$ticket['id_member_started']] = array();

		// Now the clever bit, we've taken everyone who wasn't on the normal notify list, and figured out what their preferences are.
		// We now traverse $possible_members by id, if the array is empty, we know none of their preferences accounted for emails - so they're possible.
		// Otherwise we add them to the list of being notified.
		foreach ($possible_members as $id => $list)
			if (empty($list))
				$notify_list['optional'][$id] = true;
			else
				$notify_list['being_notified'][$id] = true;
	}

	// By now we have three lists that include people who will be notified, people who could be notified, and people who don't really want to be.
	// Let's translate that into a list of people that we can make use of.
	$members = array_merge(array_keys($notify_list['being_notified']), array_keys($notify_list['optional']), array_keys($notify_list['optional_butoff']));

	if (!empty($members))
	{
		// Get everyone's name.
		$loaded = loadMemberData($members);
		$people = array();
		foreach ($loaded as $user)
			if (!empty($user_profile[$user]) && $user_profile[$user]['is_activated'] > 0 && $user_profile[$user]['is_activated'] < 10) // active & not banned
				$people[$user] = array(
					'id' => $user,
					'name' => $user_profile[$user]['real_name'],
				);

		// Right, now let's step through and tidy up the three lists
		foreach ($notify_list as $list_type => $list_members)
		{
			foreach ($list_members as $id_member => $data)
				if (isset($people[$id_member]) && $id_member != $context['user']['id']) // We really shouldn't be in this list.
					$list_members[$id_member] = $people[$id_member]['name'];
				else
					unset($list_members[$id_member]);

			if (!empty($list_members))
			{
				asort($list_members);
				array_walk($list_members, 'shd_format_notify_name', $ticket['id_member_started']);
				$notify_list[$list_type] = $list_members;
			}
			else
				unset($notify_list[$list_type]);
		}
	}

	if (empty($notify_list) || empty($members))
		return $context['ajax_return'] = array('success' => false, 'error' => $txt['shd_ping_none']);
	else
	{
		$selected = array();
		if (!empty($_GET['list']))
		{
			$_GET['list'] = explode(',', $_GET['list']);
			foreach ($_GET['list'] as $id)
				if ((int) $id > 0)
					$selected[] = (int) $id;
		}

		return array(
			'success' => true,
			'being_notified_txt' => !empty($notify_list['being_notified']) ? $txt['shd_ping_already_' . (count($notify_list['being_notified']) == 1 ? '1' : 'n')] : '',
			'being_notified' => !empty($notify_list['being_notified']) ? $notify_list['being_notified'] : array(),
			'optional_txt' => !empty($notify_list['optional']) ? $txt['shd_ping_' . (count($notify_list['optional']) == 1 ? '1' : 'n')] : '',
			'optional' => !empty($notify_list['optional']) ? $notify_list['optional'] : array(),
			'optional_butoff_txt' => !empty($notify_list['optional_butoff']) ? $txt['shd_ping_none_' . (count($notify_list['optional_butoff']) == 1 ? '1' : 'n')] : '',
			'optional_butoff' => !empty($notify_list['optional_butoff']) ? $notify_list['optional_butoff'] : array(),
			'selected' => $selected,
		);
	}
}

/**
 *	Formats a user with a valid profile link.
 *
 *	@return null No output is generated, rather $user_name is updated to be a valid link.
 *  @since 2.0
*/
function shd_format_notify_name(&$user_name, $user_id, $ticket_starter)
{
	global $txt;
	$user_name = shd_profile_link($user_name, $user_id) . ($user_id == $ticket_starter ? $txt['shd_is_ticket_opener'] : '');
}