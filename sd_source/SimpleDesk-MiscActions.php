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
* File Info: SimpleDesk-MiscActions.php                       *
**************************************************************/

/**
 *	This file handles miscellaneous actions that aren't really tied to anything, that are mostly
 *	self-contained and aren't big enough to warrant their own file.
 *
 *	@package source
 *	@since 1.0
 */
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Marks a ticket unread.
 *
 *	There are no permission checks made; other than that the user is who they claim to be. If a ticket is marked unread
 *	but they can't see it anyway, the consequence is that the database gets lighter.
 *
 *	Invoked through ?action=helpdesk;sa=unreadticket;ticket=x;sessvar=sessid before redirecting back to the main helpdesk page.
 *
 *	@since 1.0
*/
function shd_ticket_unread()
{
	global $smcFunc, $user_info, $context;

	is_not_guest();
	checkSession('get');

	if (!empty($context['ticket_id']))
	{
		call_integration_hook('shd_hook_markunread');
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_log_read
			WHERE id_ticket = {int:current_ticket}
				AND id_member = {int:user}',
			array(
				'current_ticket' => $context['ticket_id'],
				'user' => $user_info['id'],
			)
		);
	}

	redirectexit($context['shd_home'] . $context['shd_dept_link']);
}

/**
 *	Marks a ticket resolved or unresolved.
 *
 *	This function identifies whether a given ticket is resolved or not, if not resolved, mark it resolved. If it was resolved
 *	reopen the ticket back to an appropriate status based on last respondent. In both cases, the action is logged in the action log.
 *	It is also unassigned from having a user on either closure or reopen.
 *
 *	Accessed through ?action=helpdesk;sa=resolve;ticket=x;sessvar=sessid before redirecting back to the ticket, or add ;home to the
 *	URL to have it redirect back to the home page.
 *
 *	@since 1.0
*/
function shd_ticket_resolve()
{
	global $smcFunc, $user_info, $context, $sourcedir, $modSettings;

	checkSession('get');

	// First, figure out the state of the ticket - is it resolved or not? Can we even see it?
	if (empty($context['ticket_id']))
		shd_fatal_lang_error('shd_no_ticket', false);

	$context['shd_return_to'] = isset($_REQUEST['home']) ? 'home' : 'ticket';

	$query = shd_db_query('', '
		SELECT id_member_started, id_member_updated, status, num_replies, subject, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:current_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_no_ticket', false);
	}			
	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	$action = ($row['status'] != TICKET_STATUS_CLOSED) ? 'resolve' : 'unresolve';
	call_integration_hook('shd_hook_mark' . $action);

	if (!shd_allowed_to('shd_' . $action . '_ticket_any', $row['id_dept']) && (!shd_allowed_to('shd_' . $action . '_ticket_own', $row['id_dept']) || $row['id_member_started'] != $user_info['id']))
		shd_fatal_lang_error('shd_cannot_' . $action, false);

	// OK, so what about any children related tickets that are still open? Eeek, could be awkward.
	if (empty($modSettings['shd_disable_relationships']))
	{
		$query = shd_db_query('', '
			SELECT COUNT(hdt.id_ticket)
			FROM {db_prefix}helpdesk_relationships AS rel
				INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (rel.secondary_ticket = hdt.id_ticket)
			WHERE rel.primary_ticket = {int:ticket}
				AND rel.rel_type = {int:parent}
				AND hdt.status NOT IN ({array_int:closed_status})',
			array(
				'ticket' => $context['ticket_id'],
				'parent' => RELATIONSHIP_ISPARENT,
				'closed_status' => array(TICKET_STATUS_CLOSED, TICKET_STATUS_DELETED),
			)
		);
		list($count_children) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);
		if (!empty($count_children))
			shd_fatal_lang_error('error_shd_cannot_resolve_children', false);
	}

	$new = shd_determine_status($action, $row['id_member_started'], $row['id_member_updated'], $row['num_replies'], $row['id_dept']);

	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_tickets
		SET status = {int:status}
		WHERE id_ticket = {int:ticket}',
		array(
			'status' => $new,
			'ticket' => $context['ticket_id'],
		)
	);

	shd_log_action($action, array(
		'ticket' => $context['ticket_id'],
		'subject' => $row['subject'],
	));
	shd_clear_active_tickets($row['id_dept']);

	if ($context['shd_return_to'] == 'home')
		redirectexit($context['shd_home'] . $context['shd_dept_link']);
	redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}

/**
 *	Marks a ticket private/not private if the user isn't using Javascript.
 *
 *	Assuming the user can see the ticket and has suitable permissions, the privacy flag will be inverted for the ticket and
 *	updated, as well as updating the action log. If they cannot see the ticket, or do not have privacy-change permission, a fatal
 *	error will be generated.
 *
 *	Accessed through ?action=helpdesk;sa=privacychange;ticket=x;sessvar=sessid before directing back to the ticket page.
 *
 *	@since 1.0
*/
function shd_privacy_change_noajax()
{
	global $smcFunc, $user_info, $context, $sourcedir;

	checkSession('get');

	// First, figure out the state of the ticket - is it private or not? Can we even see it?
	if (empty($context['ticket_id']))
		shd_fatal_lang_error('shd_no_ticket', false);

	$query = shd_db_query('', '
		SELECT id_member_started, subject, private, status, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:current_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_no_ticket', false);
	}			
	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	if (in_array($row['status'], array(TICKET_STATUS_CLOSED, TICKET_STATUS_DELETED)) || !shd_allowed_to('shd_alter_privacy_any', $row['id_dept']) && (!shd_allowed_to('shd_alter_privacy_own', $row['id_dept']) || $row['id_member_started'] != $user_info['id']))
		shd_fatal_lang_error('shd_cannot_change_privacy', false);

	$smcFunc['db_free_result']($query);

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

	redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}

/**
 *	Updates a ticket's urgency up or down one level, if the user isn't using Javascript
 *
 *	Assuming the user can see the ticket and has suitable permissions, the urgency of the ticket will be updated and an
 *	action log entry added. If they cannot see the ticket, or do not have urgency-change permission (including higher
 *	urgency permission if necessary), a fatal error will be generated.
 *
 *	Accessed through ?action=helpdesk;sa=urgencychange;ticket=x;change=(increase|decrease);sessvar=sessid before directing back to the main helpdesk page.
 *
 *	@see shd_can_alter_urgency()
 *
 *	@since 1.0
*/
function shd_urgency_change_noajax()
{
	global $smcFunc, $user_info, $context, $sourcedir;

	checkSession('get');

	// First, figure out the state of the ticket - is it private or not? Can we even see it? Current urgency?
	if (empty($context['ticket_id']))
		shd_fatal_lang_error('shd_no_ticket', false);

	$query = shd_db_query('', '
		SELECT id_member_started, subject, urgency, status, id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_ticket = {int:current_ticket}',
		array(
			'current_ticket' => $context['ticket_id'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_no_ticket', false);
	}			
	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	$can_urgency = shd_can_alter_urgency($row['urgency'], $row['id_member_started'], ($row['status'] == TICKET_STATUS_CLOSED), ($row['status'] == TICKET_STATUS_DELETED), $row['id_dept']);

	if (empty($_GET['change']) || empty($can_urgency[$_GET['change']]))
		shd_fatal_lang_error('shd_cannot_change_urgency');

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

	shd_log_action($action, array(
		'ticket' => $context['ticket_id'],
		'subject' => $row['subject'],
		'urgency' => $new_urgency,
	));

	redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}

/**
 *	Updates a ticket's relationships.
 *
 *	This function is responsible for adding, updating and removing relationships.
 *
 *	Accessed through ?action=helpdesk;sa=relation;ticket=x;linkticket=y;relation=[linked|duplicated|parent|child|delete];sessvar=sessid and will redirect back to the ticket once complete.
 *
 *	@since 2.0
*/
function shd_ticket_relation()
{
	global $context, $smcFunc, $modSettings;

	checkSession('request');

	if (!empty($modSettings['shd_disable_relationships']))
		shd_fatal_lang_error('shd_relationships_are_disabled', false);

	$otherticket = isset($_REQUEST['otherticket']) ? (int) $_REQUEST['otherticket'] : 0;

	if (empty($context['ticket_id']) || empty($otherticket))
		shd_fatal_lang_error('shd_no_ticket', false);
	elseif ($context['ticket_id'] == $otherticket)
		shd_fatal_lang_error('shd_cannot_relate_self', false);

	$actions = array(
		'linked',
		'duplicated',
		'parent',
		'child',
		'delete',
	);

	$rel_action = isset($_REQUEST['relation']) && in_array($_REQUEST['relation'], $actions) ? $_REQUEST['relation'] : '';
	if (empty($rel_action))
		shd_fatal_lang_error('shd_invalid_relation', false);

	// Quick/consistent way to ensure permissions are adhered to and that the ticket exists. Might as well get the subject while here too.
	$ticketinfo = shd_load_ticket($context['ticket_id']);
	$primary_subject = $ticketinfo['subject'];
	$dept = $ticketinfo['dept'];
	$ticketinfo = shd_load_ticket($otherticket);
	$secondary_subject = $ticketinfo['subject'];

	shd_is_allowed_to($rel_action == 'delete' ? 'shd_delete_relationships' : 'shd_create_relationships', $dept);

	// See if there's an existing relationship with these parameters
	$query = shd_db_query('', '
		SELECT rel_type
		FROM {db_prefix}helpdesk_relationships
		WHERE primary_ticket = {int:ticket}
			AND secondary_ticket = {int:otherticket}',
		array(
			'ticket' => $context['ticket_id'],
			'otherticket' => $otherticket,
		)
	);

	$new_relationship = ($smcFunc['db_num_rows']($query) == 0);
	list($existing_relation) = $new_relationship ? array(-1) : $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	if ($rel_action == 'delete' && $new_relationship)
		shd_fatal_lang_error('shd_no_relation_delete', false);

	$log_prefix = 'rel_' . ($new_relationship || $rel_action == 'delete' ? '' : 're_');
	$log_map = array(
		'delete' => 'delete',
		'linked' => 'linked',
		'duplicated' => 'duplicated',
		'parent' => 'child',
		'child' => 'parent',
	);

	$log_assoc_ids = array(
		'delete' => -1, // any value not below, really
		'linked' => RELATIONSHIP_LINKED,
		'duplicated' => RELATIONSHIP_DUPLICATED,
		'parent' => RELATIONSHIP_ISPARENT,
		'child' => RELATIONSHIP_ISCHILD,
	);

	$logaction_ticket = $log_prefix . $rel_action;
	$logaction_otherticket = $log_prefix . $log_map[$rel_action];

	// The "from" ticket is $context['ticket_id'], $otherticket is the ticket whose id the user gives, and $rel_action sets the relationship type.
	call_integration_hook('shd_hook_relations', array(&$rel_action, &$otherticket));

	// Delete the link
	if ($rel_action == 'delete')
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_relationships
			WHERE (primary_ticket = {int:ticket} AND secondary_ticket = {int:otherticket})
				OR (primary_ticket = {int:otherticket} AND secondary_ticket = {int:ticket})',
			array(
				'ticket' => $context['ticket_id'],
				'otherticket' => $otherticket,
			)
		);
	else
		$smcFunc['db_insert']('replace',
			'{db_prefix}helpdesk_relationships',
			array(
				'primary_ticket' => 'int', 'secondary_ticket' => 'int', 'rel_type' => 'int',
			),
			array(
				array($context['ticket_id'], $otherticket, $log_assoc_ids[$rel_action]),
				array($otherticket, $context['ticket_id'], $log_assoc_ids[$log_map[$rel_action]]),
			),
			array('primary_ticket', 'secondary_ticket')
		);

	// Now actually log it, main ticket first -- if it's different to the one we had before
	if ($log_assoc_ids[$rel_action] != $existing_relation)
	{
		shd_log_action($logaction_ticket, array(
			'ticket' => $context['ticket_id'],
			'otherticket' => $otherticket,
			'subject' => $primary_subject,
			'othersubject' => $secondary_subject,
		));

		shd_log_action($logaction_otherticket, array(
			'ticket' => $otherticket,
			'otherticket' => $context['ticket_id'],
			'subject' => $secondary_subject,
			'othersubject' => $primary_subject,
		));
	}

	// See yah
	redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}