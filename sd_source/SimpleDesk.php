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
# File Info: SimpleDesk.php / 2.0 Anatidae                    #
###############################################################

/**
 *	This file serves as the entry point for SimpleDesk generally, as well as the home of the ticket listing
 *	code, for open, closed and deleted tickets.
 *
 *	@package source
 *	@since 1.0
 */

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Begins SimpleDesk general processing.
 *
 *	Several things are done here, the results of which are unilaterally assumed by all other SimpleDesk functions.
 *	- load standard constants for ticket status and urgency<
 *	- set up general navigation
 *	- see if the URL or POST data contains a ticket, if so sanitise and store that value
 *	- see if a msg was specified in the URL, if so identify the relevant ticket
 *	- add in the helpdesk CSS file
 *	- identify the sub action to direct them to, then send them on their way.
 *
 *	@since 1.0
*/
function shd_main()
{
	global $context, $txt, $settings, $sourcedir, $modSettings, $scripturl, $user_profile, $user_info, $smcFunc;

	// Basic sanity stuff
	if (!$modSettings['helpdesk_active'])
		fatal_lang_error('shd_inactive', false);

	// Let's be sneaky. Can they only access one department? If they can only access one department, put them there and make a note of it for later.
	$depts = shd_allowed_to('access_helpdesk', false);
	$context['shd_multi_dept'] = true;
	if (count($depts) == 1)
	{
		$_REQUEST['dept'] = $depts[0];
		$context['shd_multi_dept'] = false;
	}
	elseif (empty($_REQUEST['dept']) && !empty($context['queried_dept']) && in_array($context['queried_dept'], $depts))
		$_REQUEST['dept'] = $context['queried_dept'];

	$context['shd_department'] = isset($_REQUEST['dept']) && in_array($_REQUEST['dept'], $depts) ? (int) $_REQUEST['dept'] : 0;
	$context['shd_dept_link'] = !empty($context['shd_department']) && $context['shd_multi_dept'] ? ';dept=' . $context['shd_department'] : '';
	shd_is_allowed_to('access_helpdesk', $context['shd_department']);

	// If we know the department up front, we probably should get it now. Tickets themselves will deal with this but most other places won't.
	// Note that we may already have loaded this if we went and got the department id earlier, but not always.
	if (!empty($context['shd_department']) && $context['shd_multi_dept'] && empty($context['shd_dept_name']))
	{
		$query = $smcFunc['db_query']('', '
			SELECT dept_name
			FROM {db_prefix}helpdesk_depts
			WHERE id_dept = {int:dept}',
			array(
				'dept' => $context['shd_department'],
			)
		);
		list($context['shd_dept_name']) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);
	}

	// Load stuff: preferences the core template - and any hook-required files
	$context['shd_preferences'] = shd_load_user_prefs();
	$context['shd_home'] = 'action=helpdesk;sa=main';
	loadTemplate('sd_template/SimpleDesk');
	shd_load_plugin_files('helpdesk');
	shd_load_plugin_langfiles('helpdesk');

	// List of sub actions.
	$subactions = array(
		'main' => array(null, 'shd_main_helpdesk'),
		'dept' => array(null, 'shd_main_dept'),
		'viewblock' => array(null, 'shd_view_block'),
		'ticket' => array('SimpleDesk-Display.php', 'shd_view_ticket'),
		'newticket' => array('SimpleDesk-Post.php', 'shd_post_ticket'),
		'editticket' => array('SimpleDesk-Post.php', 'shd_post_ticket'),
		'saveticket' => array('SimpleDesk-Post.php', 'shd_save_post'), // this is the equivalent of post2
		'reply' => array('SimpleDesk-Post.php', 'shd_post_reply'),
		'savereply' => array('SimpleDesk-Post.php', 'shd_save_post'),
		'editreply' => array('SimpleDesk-Post.php', 'shd_post_reply'),
		'markunread' => array('SimpleDesk-MiscActions.php', 'shd_ticket_unread'),
		'assign' => array('SimpleDesk-Assign.php', 'shd_assign'),
		'assign2' => array('SimpleDesk-Assign.php', 'shd_assign2'),
		'movedept' => array('SimpleDesk-MoveDept.php', 'shd_movedept'),
		'movedept2' => array('SimpleDesk-MoveDept.php', 'shd_movedept2'),
		'resolveticket' => array('SimpleDesk-MiscActions.php', 'shd_ticket_resolve'),
		'relation' => array('SimpleDesk-MiscActions.php', 'shd_ticket_relation'),
		'ajax' => array('SimpleDesk-AjaxHandler.php', 'shd_ajax'),
		'privacychange' => array('SimpleDesk-MiscActions.php', 'shd_privacy_change_noajax'),
		'urgencychange' => array('SimpleDesk-MiscActions.php', 'shd_urgency_change_noajax'),
		'closedtickets' => array(null, 'shd_closed_tickets'),
		'recyclebin' => array(null, 'shd_recycle_bin'),
		'tickettotopic' => array('SimpleDesk-TicketTopicMove.php', 'shd_tickettotopic'),
		'tickettotopic2' => array('SimpleDesk-TicketTopicMove.php', 'shd_tickettotopic2'),
		'topictoticket' => array('SimpleDesk-TicketTopicMove.php', 'shd_topictoticket'),
		'topictoticket2' => array('SimpleDesk-TicketTopicMove.php', 'shd_topictoticket2'),
		'permadelete' => array('SimpleDesk-Delete.php', 'shd_perma_delete'),
		'deleteticket' => array('SimpleDesk-Delete.php', 'shd_ticket_delete'),
		'deletereply' => array('SimpleDesk-Delete.php', 'shd_reply_delete'),
		'deleteattach' => array('SimpleDesk-Delete.php', 'shd_attach_delete'),
		'restoreticket' => array('SimpleDesk-Delete.php', 'shd_ticket_restore'),
		'restorereply' => array('SimpleDesk-Delete.php', 'shd_reply_restore'),
		'emaillog' => array('SimpleDesk-Notifications.php', 'shd_notify_popup'),
	);

	// Navigation menu
	$context['navigation'] = array(
		'main' => array(
			'text' => 'shd_home',
			'lang' => true,
			'url' => $scripturl . '?action=helpdesk;sa=main',
		),
		'dept' => array(
			'text' => 'shd_departments',
			'test' => 'shd_multi_dept',
			'lang' => true,
			'url' => $scripturl . '?action=helpdesk;sa=dept',
		),
		'newticket' => array(
			'text' => 'shd_new_ticket',
			'test' => 'can_new_ticket',
			'lang' => true,
			'url' => $scripturl . '?action=helpdesk;sa=newticket' . $context['shd_dept_link'],
		),
		'newticketproxy' => array(
			'text' => 'shd_new_ticket_proxy',
			'test' => 'can_proxy_ticket',
			'lang' => true,
			'url' => $scripturl . '?action=helpdesk;sa=newticket;proxy' . $context['shd_dept_link'],
		),
		'closedtickets' => array(
			'text' => 'shd_tickets_closed',
			'test' => 'can_view_closed',
			'lang' => true,
			'url' => $scripturl . '?action=helpdesk;sa=closedtickets' . $context['shd_dept_link'],
		),
		'recyclebin' => array(
			'text' => 'shd_recycle_bin',
			'test' => 'can_view_recycle',
			'lang' => true,
			'url' => $scripturl . '?action=helpdesk;sa=recyclebin' . $context['shd_dept_link'],
		),
		// Only for certain sub areas.
		'back' => array(
			'text' => 'shd_back_to_hd',
			'test' => 'display_back_to_hd',
			'lang' => true,
			'url' => $scripturl . '?' . $context['shd_home'] . $context['shd_dept_link'],
		),
		'options' => array(
			'text'=> 'shd_options',
			'test' => 'can_view_options',
			'lang' => true,
			'url' => $scripturl . '?action=profile;area=hd_prefs',
		),
	);

	// Build the link tree.
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=main',
		'name' => $txt['shd_helpdesk'],
	);

	if (!$context['shd_multi_dept'])
		$context['linktree'][] = array(
			'url' => $scripturl . '?' . $context['shd_home'],
			'name' => $txt['shd_linktree_tickets'],
		);

	// See if a ticket has been specified, like $topic can be.
	if (!empty($_REQUEST['ticket']))
	{
		if (strpos($_REQUEST['ticket'], '.') === false)
		{
			$context['ticket_id'] = (int) $_REQUEST['ticket'];
			$context['ticket_start'] = 0;
		}
		else
		{
			list ($context['ticket_id'], $context['ticket_start']) = explode('.', $_REQUEST['ticket']);
			$context['ticket_id'] = (int) $context['ticket_id'];
			if (!is_numeric($context['ticket_start']))
			{
				// Let's see if it's 'new' first. If it is, great, we'll figure out the new point then throw it at the next one.
				if (substr($context['ticket_start'], 0, 3) == 'new')
				{
					$query = shd_db_query('', '
						SELECT IFNULL(hdlr.id_msg, -1) + 1 AS new_from
						FROM {db_prefix}helpdesk_tickets AS hdt
							LEFT JOIN {db_prefix}helpdesk_log_read AS hdlr ON (hdlr.id_ticket = {int:ticket} AND hdlr.id_member = {int:member})
						WHERE {query_see_ticket}
							AND hdt.id_ticket = {int:ticket}
						LIMIT 1',
						array(
							'member' => $user_info['id'],
							'ticket' => $context['ticket_id'],
						)
					);
					list ($new_from) = $smcFunc['db_fetch_row']($query);
					$smcFunc['db_free_result']($query);
					$context['ticket_start'] = 'msg' . $new_from;
					$context['ticket_start_newfrom'] = $new_from;
				}

				if (substr($context['ticket_start'], 0, 3) == 'msg')
				{
					$virtual_msg = (int) substr($context['ticket_start'], 3);
					$query = shd_db_query('', '
						SELECT COUNT(hdtr.id_msg)
						FROM {db_prefix}helpdesk_ticket_replies AS hdtr
							INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdtr.id_ticket = hdt.id_ticket)
						WHERE {query_see_ticket}
							AND hdtr.id_ticket = {int:ticket}
							AND hdtr.id_msg > hdt.id_first_msg
							AND hdtr.id_msg < {int:virtual_msg}' . (!isset($_GET['recycle']) ? '
							AND hdtr.message_status = {int:message_notdel}' : ''),
						array(
							'ticket' => $context['ticket_id'],
							'virtual_msg' => $virtual_msg,
							'message_notdel' => MSG_STATUS_NORMAL,
						)
					);
					list ($context['ticket_start']) = $smcFunc['db_fetch_row']($query);
					$smcFunc['db_free_result']($query);
				}
			}
			else
			{
				$context['ticket_start'] = (int) $context['ticket_start']; // it IS numeric but let's make sure it's the right kind of number
				$context['ticket_start_natural'] = true;
			}
		}
	}
	if (empty($context['ticket_start_newfrom']))
		$context['ticket_start_newfrom'] = empty($context['ticket_start']) ? 0 : $context['ticket_start'];

	// Do we have just a message id? We can get the ticket from that - but only if we don't already have a ticket id!
	$_REQUEST['msg'] = !empty($_REQUEST['msg']) ? (int) $_REQUEST['msg'] : 0;
	if (!empty($_REQUEST['msg']) && empty($context['ticket_id']))
	{
		$query = shd_db_query('', '
			SELECT hdt.id_ticket, hdtr.id_msg
			FROM {db_prefix}helpdesk_ticket_replies AS hdtr
				INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdtr.id_ticket = hdt.id_ticket)
			WHERE {query_see_ticket}
				AND hdtr.id_msg = {int:msg}',
			array(
				'msg' => $_REQUEST['msg'],
			)
		);

		if ($row = $smcFunc['db_fetch_row']($query))
			$context['ticket_id'] = (int) $row[0];

		$smcFunc['db_free_result']($query);
	}

	$context['items_per_page'] = 10;
	$context['start'] = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;

	// Load the custom CSS.
	if (empty($context['html_headers']))
		$context['html_headers'] = '';

	$context['html_headers'] .= '
	<link rel="stylesheet" type="text/css" href="' . (file_exists($settings['theme_dir'] . '/css/helpdesk.css') ? $settings['theme_url'] . '/css/helpdesk.css' : $settings['default_theme_url'] . '/css/helpdesk.css') . '" />
	<script type="text/javascript" src="' . $settings['default_theme_url'] . '/scripts/helpdesk.js?rc2"></script>';

	// Darn IE6. Die, already :(
	if ($context['browser']['is_ie6'])
		$context['html_headers'] .= '
		<!-- Fall back, dark force, for we shall thy evil powers not endorse -->
		<link rel="stylesheet" type="text/css" href="' . $settings['default_theme_url'] . '/css/helpdesk_ie6.css" />';

	// Int hooks - after we basically set everything up (so it's manipulatable by the hook, but before we do the last bits of finalisation)
	call_integration_hook('shd_hook_helpdesk', array(&$subactions));

	// What are we doing?
	$_REQUEST['sa'] = (!empty($_REQUEST['sa']) && isset($subactions[$_REQUEST['sa']])) ? $_REQUEST['sa'] : 'main';
	$context['sub_action'] = $subactions[$_REQUEST['sa']];

	$context['can_new_ticket'] = shd_allowed_to('shd_new_ticket', $context['shd_department']);
	$context['can_proxy_ticket'] = $context['can_new_ticket'] && shd_allowed_to('shd_post_proxy', $context['shd_department']);
	$context['can_view_closed'] = shd_allowed_to(array('shd_view_closed_own', 'shd_view_closed_any'), $context['shd_department']);
	$context['can_view_recycle'] = shd_allowed_to('shd_access_recyclebin', $context['shd_department']);
	$context['display_back_to_hd'] = !in_array($_REQUEST['sa'], array('main', 'viewblock', 'recyclebin', 'closedtickets', 'dept'));
	$context['can_view_options'] = shd_allowed_to(array('shd_view_preferences_own', 'shd_view_preferences_any'), 0);

	// Highlight the correct button.
	if (isset($context['navigation'][$_REQUEST['sa']]))
		$context['navigation'][$_REQUEST['sa']]['active'] = true;

	// Send them away.
	if ($context['sub_action'][0] !== null)
		require ($sourcedir . '/sd_source/' . $context['sub_action'][0]);

	$context['sub_action'][1]();

	// Maintenance mode? If it were, the helpdesk is considered inactive for the purposes of everything to all but those without admin-helpdesk rights - but we must have them if we're here!
	if (!empty($modSettings['shd_maintenance_mode']) && $_REQUEST['sa'] != 'ajax')
		$context['template_layers'][] = 'shd_maintenance';

	call_integration_hook('shd_hook_after_main');
}

/**
 *	Display the main front page, showing tickets waiting for staff, waiting for user feedback and so on.
 *
 *	This function sets up multiple blocks to be shown to users, defines what columns these blocks should have and states
 *	the rules to be used in getting the data.
 *
 *	Each block has multiple parameters, and is stated in $context['ticket_blocks']:
 *	<ul>
 *	<li>block_icon: which image to use in Themes/default/images/simpledesk for denoting the type of block; filename plus extension</li>
 *	<li>title: the text string to use as the block's heading</li>
 *	<li>where: an SQL clause denoting the rule for obtaining the items in this block</li>
 *	<li>display: whether the block should be processed and prepared for display</li>
 *	<li>count: the number of items in this block, for pagination; generally should be a call to {@link shd_count_helpdesk_tickets()}</li>
 *	<li>columns: an array of columns to display in this block, in the order they should be displayed, using the following options, derived from {@link shd_get_block_columns()}:
 *		<ul>
 *			<li>ticket_id: the ticket's read status, privacy icon, and id</li>
 *			<li>ticket_name: name/link to the ticket</li>
 *			<li>starting_user: profile link to the user who opened the ticket</li>
 *			<li>replies: number of (visible) replies in the ticket</li>
 *			<li>allreplies: number of (all) replies in the ticket (includes deleted replies, which 'replies' does not)</li>
 *			<li>last_reply: the user who last replied</li>
 *			<li>status: the current ticket's status</li>
 *			<li>assigned: link to the profile of the user the ticket is assigned to, or 'Unassigned' if not assigned</li>
 *			<li>urgency: the current ticket's urgency</li>
 *			<li>updated: time of the last reply in the ticket; states Never if no replies</li>
 *			<li>actions: icons that may or may not relate to a given ticket; buttons for recycle, delete, unresolve live in this column</li>
 *		</ul>
 *	<li>required: whether the block is required to be displayed even if empty</li>
 *	<li>collapsed: whether the block should be compressed to a header with count of tickets or not (mostly for {@link shd_view_block()}'s benefit)</li>
 *	</ul>
 *
 *	This function declares the following blocks:
 *	<ul>
 *	<li>Assigned to me (staff only)</li>
 *	<li>New tickets (staff only)</li>
 *	<li>Pending with staff (for staff, this is just tickets with that status, for regular users this is both pending staff and new unreplied to tickets)</li>
 *	<li>Pending with user (both)</li>
 *	</ul>
 *
 *	@see shd_count_helpdesk_tickets()
 *	@since 1.0
*/
function shd_main_helpdesk()
{
	global $context, $txt, $smcFunc, $user_profile, $scripturl, $user_info;

	$is_staff = shd_allowed_to('shd_staff', 0);
	// Stuff we need to add to $context, page title etc etc
	$context += array(
		'page_title' => $txt['shd_helpdesk'],
		'sub_template' => 'main',
		'ticket_blocks' => array( // the numbers tie back to the master status idents
			'assigned' => array(
				'block_icon' => 'assign.png',
				'title' => $txt['shd_status_assigned_heading'],
				'where' => 'hdt.id_member_assigned = ' . $user_info['id'] . ' AND hdt.status NOT IN (' . TICKET_STATUS_CLOSED . ',' . TICKET_STATUS_DELETED . ')',
				'display' => $is_staff,
				'count' => shd_count_helpdesk_tickets('assigned'),
				'columns' => shd_get_block_columns('assigned'),
				'required' => $is_staff,
				'collapsed' => false,
			),
			'new' => array(
				'block_icon' => 'status.png',
				'title' => $txt['shd_status_' . TICKET_STATUS_NEW . '_heading'],
				'where' => 'hdt.id_member_assigned != ' . $user_info['id'] . ' AND hdt.status = ' . TICKET_STATUS_NEW,
				'display' => $is_staff,
				'count' => shd_count_helpdesk_tickets('new'),
				'columns' => shd_get_block_columns('new'),
				'required' => false,
				'collapsed' => false,
			),
			'staff' => array(
				'block_icon' => 'staff.png',
				'title' => $txt['shd_status_' . TICKET_STATUS_PENDING_STAFF . '_heading'],
				'where' => $is_staff ? ('hdt.id_member_assigned != ' . $user_info['id'] . ' AND hdt.status = ' . TICKET_STATUS_PENDING_STAFF) : ('hdt.status IN (' . TICKET_STATUS_NEW . ',' . TICKET_STATUS_PENDING_STAFF . ')'), // put new and with staff together in 'waiting for staff' for end user
				'display' => true,
				'count' => shd_count_helpdesk_tickets('staff', $is_staff),
				'columns' => shd_get_block_columns('staff'),
				'required' => true,
				'collapsed' => false,
			),
			'user' => array(
				'block_icon' => 'user.png',
				'title' => $txt['shd_status_' . TICKET_STATUS_PENDING_USER . '_heading'],
				'where' => $is_staff ? ('hdt.id_member_assigned != ' . $user_info['id'] . ' AND hdt.status = ' . TICKET_STATUS_PENDING_USER) : ('hdt.status = ' . TICKET_STATUS_PENDING_USER),
				'display' => true,
				'count' => shd_count_helpdesk_tickets('with_user'),
				'columns' => shd_get_block_columns($is_staff ? 'user_staff' : 'user_user'),
				'required' => true,
				'collapsed' => false,
			),
		),
		'shd_home_view' => $is_staff ? 'staff' : 'user',
	);

	if (!empty($context['shd_dept_name']) && $context['shd_multi_dept'])
		$context['linktree'][] = array(
			'url' => $scripturl . '?' . $context['shd_home'] . $context['shd_dept_link'],
			'name' => $context['shd_dept_name'],
		);

	shd_helpdesk_listing();
}

/**
 *	Sets up viewing the list of departments.
 *
 *	@since 2.0
*/
function shd_main_dept()
{
	global $context, $txt, $smcFunc, $scripturl, $user_info, $sourcedir;

	$dept_list = shd_allowed_to('access_helpdesk', false);

	$context += array(
		'page_title' => $txt['shd_helpdesk'] . ' - ' . $txt['shd_departments'],
		'sub_template' => 'shd_depts',
		'shd_home_view' => shd_allowed_to('shd_staff', 0) ? 'staff' : 'user',
	);

	// Get the departments and order them in the same order they would be on the board index.
	$context['dept_list'] = array();
	$query = $smcFunc['db_query']('', '
		SELECT hdd.id_dept, hdd.dept_name
		FROM {db_prefix}helpdesk_depts AS hdd
		WHERE hdd.id_dept IN ({array_int:depts})
		ORDER BY hdd.dept_order',
		array(
			'depts' => $dept_list,
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['dept_list'][$row['id_dept']] = array(
			'id_dept' => $row['id_dept'],
			'dept_name' => $row['dept_name'],
			'tickets' => array(
				'open' => 0,
				'closed' => 0,
				'assigned' => 0,
			),
			'new' => false,
		);
	$smcFunc['db_free_result']($query);

	require_once($sourcedir . '/sd_source/Subs-SimpleDeskBoardIndex.php');
	shd_get_ticket_counts();
	shd_get_unread_departments();

	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=dept',
		'name' => $txt['shd_departments'],
	);
}

/**
 *	Sets up viewing of a single block without any pagination.
 *
 *	This provides the ability to see all of a given type of ticket at once without paging through them, which are all sortable.
 *
 *	@see shd_main_helpdesk()
 *	@since 1.0
*/
function shd_view_block()
{
	global $context, $txt, $smcFunc, $user_profile, $scripturl, $user_info;

	$is_staff = shd_allowed_to('shd_staff', 0);
	// Stuff we need to add to $context, page title etc etc
	$context += array(
		'page_title' => $txt['shd_helpdesk'],
		'sub_template' => 'main',
		'ticket_blocks' => array( // the numbers tie back to the master status idents
			'assigned' => array(
				'block_icon' => 'assign.png',
				'title' => $txt['shd_status_assigned_heading'],
				'where' => 'hdt.id_member_assigned = ' . $user_info['id'] . ' AND hdt.status NOT IN (' . TICKET_STATUS_CLOSED . ',' . TICKET_STATUS_DELETED . ')',
				'display' => $is_staff,
				'count' => shd_count_helpdesk_tickets('assigned'),
				'columns' => shd_get_block_columns('assigned'),
				'required' => $is_staff,
				'collapsed' => false,
			),
			'new' => array(
				'block_icon' => 'status.png',
				'title' => $txt['shd_status_' . TICKET_STATUS_NEW . '_heading'],
				'where' => 'hdt.id_member_assigned != ' . $user_info['id'] . ' AND hdt.status = ' . TICKET_STATUS_NEW,
				'display' => $is_staff,
				'count' => shd_count_helpdesk_tickets('new'),
				'columns' => shd_get_block_columns('new'),
				'required' => false,
				'collapsed' => false,
			),
			'staff' => array(
				'block_icon' => 'staff.png',
				'title' => $txt['shd_status_' . TICKET_STATUS_PENDING_STAFF . '_heading'],
				'where' => $is_staff ? ('hdt.id_member_assigned != ' . $user_info['id'] . ' AND hdt.status = ' . TICKET_STATUS_PENDING_STAFF) : ('hdt.status IN (' . TICKET_STATUS_NEW . ',' . TICKET_STATUS_PENDING_STAFF . ')'), // put new and with staff together in 'waiting for staff' for end user
				'display' => true,
				'count' => shd_count_helpdesk_tickets('staff', $is_staff),
				'columns' => shd_get_block_columns('staff'),
				'required' => true,
				'collapsed' => false,
			),
			'user' => array(
				'block_icon' => 'user.png',
				'title' => $txt['shd_status_' . TICKET_STATUS_PENDING_USER . '_heading'],
				'where' => $is_staff ? ('hdt.id_member_assigned != ' . $user_info['id'] . ' AND hdt.status = ' . TICKET_STATUS_PENDING_USER) : ('hdt.status = ' . TICKET_STATUS_PENDING_USER),
				'display' => true,
				'count' => shd_count_helpdesk_tickets('with_user'),
				'columns' => shd_get_block_columns($is_staff ? 'user_staff' : 'user_user'),
				'required' => true,
				'collapsed' => false,
			),
		),
		'shd_home_view' => $is_staff ? 'staff' : 'user',
	);

	if (empty($_REQUEST['block']) || empty($context['ticket_blocks'][$_REQUEST['block']]) || empty($context['ticket_blocks'][$_REQUEST['block']]['count']))
		redirectexit($context['shd_home'] . $context['shd_dept_link']);

	$context['items_per_page'] = 10;
	foreach ($context['ticket_blocks'] as $block => $details)
	{
		if ($block == $_REQUEST['block'])
		{
			$context['items_per_page'] = $details['count'];
			$context['ticket_blocks'][$block]['viewing_as_block'] = true;
		}
		else
			$context['ticket_blocks'][$block]['collapsed'] = true;
	}

	if (!empty($context['shd_dept_name']) && $context['shd_multi_dept'])
		$context['linktree'][] = array(
			'url' => $scripturl . '?' . $context['shd_home'] . $context['shd_dept_link'],
			'name' => $context['shd_dept_name'],
		);

	shd_helpdesk_listing();
}

/**
 *	Set up the paginated lists of closed tickets.
 *
 *	Much like the main helpdesk, this function prepares a list of all the closed/resolved tickets, with a more specific
 *	list of columns that is better suited to resolved tickets.
 *
 *	@see shd_main_helpdesk()
 *	@since 1.0
*/
function shd_closed_tickets()
{
	global $context, $txt, $smcFunc, $user_profile, $scripturl, $settings, $user_info;

	if (!shd_allowed_to('shd_view_closed_own', $context['shd_department']) && !shd_allowed_to('shd_view_closed_any', $context['shd_department']))
		fatal_lang_error('shd_cannot_view_resolved', false);

	// Stuff we need to add to $context, the permission we want to use, page title etc etc
	$context += array(
		'page_title' => $txt['shd_helpdesk'],
		'sub_template' => 'closedtickets',
		'ticket_blocks' => array(
			'closed' => array(
				'block_icon' => 'resolved.png',
				'title' => $txt['shd_status_' . TICKET_STATUS_CLOSED . '_heading'],
				'where' => 'hdt.status = ' . TICKET_STATUS_CLOSED,
				'display' => true,
				'count' => shd_count_helpdesk_tickets('closed'),
				'columns' => shd_get_block_columns('closed'),
				'required' => true,
				'collapsed' => false,
			),
		),
		'shd_home_view' => shd_allowed_to('shd_staff', $context['shd_department']) ? 'staff' : 'user', // This might be removed in the future. We do this here to be able to re-use template_ticket_block() in the template.
	);

	// Build the link tree.
	if (!empty($context['shd_dept_name']) && $context['shd_multi_dept'])
		$context['linktree'][] = array(
			'url' => $scripturl . '?' . $context['shd_home'] . $context['shd_dept_link'],
			'name' => $context['shd_dept_name'],
		);
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=closedtickets' . $context['shd_dept_link'],
		'name' => $txt['shd_tickets_closed'],
	);

	shd_helpdesk_listing();
}

/**
 *	Set up the paginated lists of deleted/recyclebin tickets.
 *
 *	Much like the main helpdesk, this function prepares a list of all the deleted tickets, with a more specific
 *	list of columns that is better suited to recyclable or permadeletable tickets.
 *
 *	@see shd_main_helpdesk()
 *	@since 1.0
*/
function shd_recycle_bin()
{
	global $context, $txt, $smcFunc, $user_profile, $scripturl, $settings, $user_info;

	// Stuff we need to add to $context, the permission we want to use, page title etc etc
	$context += array(
		'shd_permission' => 'shd_access_recyclebin',
		'page_title' => $txt['shd_helpdesk'],
		'sub_template' => 'recyclebin',
		'ticket_blocks' => array(
			'recycle' => array(
				'block_icon' => 'recycle.png',
				'title' => $txt['shd_status_' . TICKET_STATUS_DELETED . '_heading'],
				'tickets' => array(),
				'where' => 'hdt.status = ' . TICKET_STATUS_DELETED,
				'display' => true,
				'count' => shd_count_helpdesk_tickets('recycled'),
				'columns' => shd_get_block_columns('recycled'),
				'required' => true,
				'collapsed' => false,
			),
			'withdeleted' => array(
				'block_icon' => 'recycle.png',
				'title' => $txt['shd_status_withdeleted_heading'],
				'tickets' => array(),
				'where' => 'hdt.status != ' . TICKET_STATUS_DELETED . ' AND hdt.deleted_replies > 0',
				'display' => true,
				'count' => shd_count_helpdesk_tickets('withdeleted'),
				'columns' => shd_get_block_columns('withdeleted'),
				'required' => true,
				'collapsed' => false,
			),
		),
	);

	// Build the link tree.
	if (!empty($context['shd_dept_name']) && $context['shd_multi_dept'])
		$context['linktree'][] = array(
			'url' => $scripturl . '?' . $context['shd_home'] . $context['shd_dept_link'],
			'name' => $context['shd_dept_name'],
		);
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=recyclebin' . $context['shd_dept_link'],
		'name' => $txt['shd_recycle_bin'],
	);

	shd_helpdesk_listing();
}

/**
 *	Gather the data and prepare to display the ticket blocks.
 *
 *	Actually performs the queries to get data for each block, subject to the parameters specified by the calling functions.
 *
 *	It also sets up per-block pagination links, collects a variety of data (enough to populate all the columns as listed in shd_main_helpdesk,
 *	even if not entirely applicable, and populates it all into $context['ticket_blocks']['tickets'], extending the array that was
 *	already there.
 *
 *	@see shd_main_helpdesk()
 *	@see shd_closed_tickets()
 *	@see shd_recycle_bin()
 *	@since 1.0
*/
function shd_helpdesk_listing()
{
	global $context, $txt, $smcFunc, $user_profile, $scripturl, $settings, $user_info, $modSettings, $language;

	if (!empty($context['shd_permission']))
		shd_is_allowed_to($context['shd_permission']);

	// So, we want the [new] icon. Where is it?
	$newimgpaths = array(
		$settings['theme_dir'] . '/images/' . $language => $settings['lang_images_url'],
		$settings['theme_dir'] . '/images/english' => $settings['images_url'] . '/english',
		$settings['default_theme_dir'] . '/images/' . $language => $settings['default_images_url'] . '/' . $language,
	);
	$files = array('new.gif', 'new.png');
	$context['new_posts_image'] = $settings['default_images_url'] . '/english/new.gif'; // likely default, but we'll check the theme etc first just in case.
	foreach ($newimgpaths as $physicalpath => $urlpath)
	{
		foreach ($files as $file)
		{
			if (file_exists($physicalpath . '/' . $file))
			{
				$context['new_posts_image'] = $urlpath . '/' . $file;
				break 2;
			}
		}
	}

	$block_list = array_keys($context['ticket_blocks']);
	$primary_url = '?action=helpdesk;sa=' . $_REQUEST['sa'];

	// First figure out the start positions of each item and sanitise them
	foreach ($context['ticket_blocks'] as $block_key => $block)
	{
		if (empty($block['viewing_as_block']))
		{
			$num_per_page = !empty($context['shd_preferences']['blocks_' . $block_key . '_count']) ? $context['shd_preferences']['blocks_' . $block_key . '_count'] : $context['items_per_page'];
			$start = empty($_REQUEST['st_' . $block_key]) ? 0 : (int) $_REQUEST['st_' . $block_key];
			$max_value = $block['count']; // easier to read
		}
		else
		{
			$num_per_page = $context['items_per_page'];
			$max_value = $context['items_per_page'];
			$start = 0;
		}

		if ($start < 0)
			$start = 0;
		elseif ($start >= $max_value)
			$start = max(0, (int) $max_value - (((int) $max_value % (int) $num_per_page) == 0 ? $num_per_page : ((int) $max_value % (int) $num_per_page)));
		else
			$start = max(0, (int) $start - ((int) $start % (int) $num_per_page));

		$context['ticket_blocks'][$block_key]['start'] = $start;
		$context['ticket_blocks'][$block_key]['num_per_page'] = $num_per_page;

		if ($start != 0)
			$_REQUEST['st_' . $block_key] = $start; // sanitise!
		elseif (isset($_REQUEST['st_' . $block_key]))
			unset($_REQUEST['st_' . $block_key]);
	}

	// Now ordering the columns, separate loop for breaking the two processes apart
	$sort_methods = array(
		'ticketid' => array(
			'sql' => 'hdt.id_ticket',
		),
		'ticketname' => array(
			'sql' => 'hdt.subject',
		),
		'replies' => array(
			'sql' => 'hdt.num_replies',
		),
		'allreplies' => array(
			'sql' => '(hdt.num_replies + hdt.deleted_replies)',
		),
		'urgency' => array(
			'sql' => 'hdt.urgency',
		),
		'updated' => array(
			'sql' => 'hdt.last_updated',
		),
		'assigned' => array(
			'sql' => 'assigned_name',
			'sql_select' => 'IFNULL(mem.real_name, 0) AS assigned_name',
			'sql_join' => 'LEFT JOIN {db_prefix}members AS mem ON (hdt.id_member_assigned = mem.id_member)',
		),
		'status' => array(
			'sql' => 'hdt.status',
		),
		'starter' => array(
			'sql' => 'starter_name',
			'sql_select' => 'IFNULL(mem.real_name, 0) AS starter_name',
			'sql_join' => 'LEFT JOIN {db_prefix}members AS mem ON (hdt.id_member_started = mem.id_member)',
		),
		'lastreply' => array(
			'sql' => 'last_reply',
			'sql_select' => 'IFNULL(mem.real_name, 0) AS last_reply',
			'sql_join' => 'LEFT JOIN {db_prefix}members AS mem ON (hdtr_last.id_member = mem.id_member)',
		),
	);

	foreach ($context['ticket_blocks'] as $block_key => $block)
	{
		$sort = isset($_REQUEST['so_' . $block_key]) ? $_REQUEST['so_' . $block_key] : (!empty($context['shd_preferences']['block_order_' . $block_key . '_block']) ? $context['shd_preferences']['block_order_' . $block_key . '_block'] : '');

		if (strpos($sort, '_') > 0 && substr_count($sort, '_') == 1)
		{
			list($sort_item, $sort_dir) = explode('_', $sort);

			if (empty($sort_methods[$sort_item]))
			{
				$sort_item = 'updated';
				$sort = '';
			}

			if (!in_array($sort_dir, array('asc', 'desc')))
			{
				$sort = '';
				$sort_dir = 'asc';
			}
		}
		else
		{
			$sort = '';
			$sort_item = 'updated';
			$sort_dir = $_REQUEST['sa'] == 'closedtickets' || $_REQUEST['sa'] == 'recyclebin' ? 'desc' : 'asc'; // default to newest first if on recyclebin or closed tickets, otherwise oldest first
		}

		if ($sort != '')
			$_REQUEST['so_' . $block_key] = $sort; // sanitise!
		elseif (isset($_REQUEST['so_' . $block_key]))
			unset($_REQUEST['so_' . $block_key]);

		$context['ticket_blocks'][$block_key]['sort'] = array(
			'item' => $sort_item,
			'direction' => $sort_dir,
			'add_link' => ($sort != ''),
			'sql' => array(
				'select' => !empty($sort_methods[$sort_item]['sql_select']) ? $sort_methods[$sort_item]['sql_select'] : '',
				'join' => !empty($sort_methods[$sort_item]['sql_join']) ? $sort_methods[$sort_item]['sql_join'] : '',
				'sort' => $sort_methods[$sort_item]['sql'] . ' ' . strtoupper($sort_dir),
			),
			'link_bits' => array(),
		);
	}

	// Having got all that, step through the blocks again to determine the full URL fragments
	foreach ($context['ticket_blocks'] as $block_key => $block)
		foreach ($sort_methods as $method => $sort_details)
			$context['ticket_blocks'][$block_key]['sort']['link_bits'][$method] = ';so_' . $block_key . '=' . $method . '_' . $block['sort']['direction'];

	// Figure out if the user is filtering on anything, and if so, set up containers for the extra joins, selects, pagination link fragments, etc
	$_REQUEST['field'] = isset($_REQUEST['field']) ? (int) $_REQUEST['field'] : 0;
	$_REQUEST['filter'] = isset($_REQUEST['filter']) ? (int) $_REQUEST['filter'] : 0;
	if ($_REQUEST['field'] > 0 && $_REQUEST['filter'] > 0)
	{
		$context['filter_fragment'] = ';field=' . $_REQUEST['field'] . ';filter=' . $_REQUEST['filter'];
		$context['filter_join'] = '
				INNER JOIN {db_prefix}helpdesk_custom_fields_values AS hdcfv ON (hdcfv.id_post = hdt.id_ticket AND hdcfv.id_field = {int:field} AND hdcfv.post_type = {int:type_ticket})
				INNER JOIN {db_prefix}helpdesk_custom_fields AS hdcf ON (hdcf.id_field = hdcfv.id_field AND hdcf.active = {int:active})';
		$context['filter_where'] = '
				AND hdcfv.value = {string:filter}';
	}
	else
	{
		$context['filter_fragment'] = '';
		$context['filter_join'] = '';
		$context['filter_where'] = '';
	}

	// Now go actually do the whole block thang, setting up space for a list of users and tickets as we go along
	$users = array();
	$tickets = array();

	foreach ($context['ticket_blocks'] as $block_key => $block)
	{
		if (empty($block['display']) || !empty($block['collapsed']))
			continue;

		$context['ticket_blocks'][$block_key]['tickets'] = array();

		// If we're filtering, we have to query it first to figure out how many rows there are in this block. It's not pretty.
		if (!empty($context['filter_join']))
		{
			$query = shd_db_query('', '
				SELECT COUNT(hdt.id_ticket)
				FROM {db_prefix}helpdesk_tickets AS hdt
					INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_first ON (hdt.id_first_msg = hdtr_first.id_msg)
					INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_last ON (hdt.id_last_msg = hdtr_last.id_msg)
					INNER JOIN {db_prefix}helpdesk_depts AS hdd ON (hdt.id_dept = hdd.id_dept)
					' . (!empty($block['sort']['sql']['join']) ? $block['sort']['sql']['join'] : '') . $context['filter_join'] . '
				WHERE {query_see_ticket}' . (!empty($block['where']) ? ' AND ' . $block['where'] : '') . (!empty($context['shd_department']) ? ' AND hdt.id_dept = {int:dept}' : '') . $context['filter_where'],
				array(
					'dept' => $context['shd_department'],
					'user' => $context['user']['id'],
					'field' => $_REQUEST['field'],
					'filter' => $_REQUEST['filter'],
					'type_ticket' => CFIELD_TICKET,
					'active' => 1,
				)
			);
			list($context['ticket_blocks'][$block_key]['count']) = $smcFunc['db_fetch_row']($query);
			$block['count'] = $context['ticket_blocks'][$block_key]['count'];
			$smcFunc['db_free_result']($query);

			if ($block['start'] >= $block['count'])
			{
				$context['ticket_blocks'][$block_key]['start'] = max(0, (int) $block['count'] - (((int) $block['count'] % (int) $block['num_per_page']) == 0 ? $block['num_per_page'] : ((int) $block['count'] % (int) $block['num_per_page'])));
				$block['start'] = $context['ticket_blocks'][$block_key]['start'];
			}
		}

		$query = shd_db_query('', '
			SELECT hdt.id_ticket, hdt.id_dept, hdd.dept_name, hdt.id_last_msg, hdt.id_member_started, hdt.id_member_updated,
				hdt.id_member_assigned, hdt.subject, hdt.status, hdt.num_replies, hdt.deleted_replies, hdt.private, hdt.urgency,
				hdt.last_updated, hdtr_first.poster_name AS ticket_opener, hdtr_last.poster_name AS respondent, hdtr_last.poster_time,
				IFNULL(hdlr.id_msg, 0) AS log_read' . (!empty($block['sort']['sql']['select']) ? ', ' . $block['sort']['sql']['select'] : '') . '
			FROM {db_prefix}helpdesk_tickets AS hdt
				INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_first ON (hdt.id_first_msg = hdtr_first.id_msg)
				INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr_last ON (hdt.id_last_msg = hdtr_last.id_msg)
				INNER JOIN {db_prefix}helpdesk_depts AS hdd ON (hdt.id_dept = hdd.id_dept)
				LEFT JOIN {db_prefix}helpdesk_log_read AS hdlr ON (hdt.id_ticket = hdlr.id_ticket AND hdlr.id_member = {int:user})
				' . (!empty($block['sort']['sql']['join']) ? $block['sort']['sql']['join'] : '') . $context['filter_join'] . '
			WHERE {query_see_ticket}' . (!empty($block['where']) ? ' AND ' . $block['where'] : '') . (!empty($context['shd_department']) ? ' AND hdt.id_dept = {int:dept}' : '') . $context['filter_where'] . '
			ORDER BY ' . (!empty($block['sort']['sql']['sort']) ? $block['sort']['sql']['sort'] : 'hdt.id_last_msg ASC') . '
			LIMIT {int:start}, {int:items_per_page}',
			array(
				'dept' => $context['shd_department'],
				'user' => $context['user']['id'],
				'start' => $block['start'],
				'items_per_page' => $block['num_per_page'],
				'field' => $_REQUEST['field'],
				'filter' => $_REQUEST['filter'],
				'type_ticket' => CFIELD_TICKET,
				'active' => 1,
			)
		);

		while ($row = $smcFunc['db_fetch_assoc']($query))
		{
			$is_own = $user_info['id'] == $row['id_member_started'];
			censorText($row['subject']);

			$new_block = array(
				'id' => $row['id_ticket'],
				'display_id' => str_pad($row['id_ticket'], 5, '0', STR_PAD_LEFT),
				'dept_link' => empty($context['shd_department']) && $context['shd_multi_dept'] ? '[<a href="' . $scripturl . '?' . $context['shd_home'] . ';dept=' . $row['id_dept'] . '">' . $row['dept_name'] . '</a>] ' : '',
				'link' => '<a href="' . $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $row['id_ticket'] . ($_REQUEST['sa'] == 'recyclebin' ? ';recycle' : '') . '">' . $row['subject'] . '</a>',
				'subject' => $row['subject'],
				'status' => array(
					'level' => $row['status'],
					'label' => $txt['shd_status_' . $row['status']],
				),
				'starter' => array(
					'id' => $row['id_member_started'],
					'name' => $row['ticket_opener'],
				),
				'last_update' => timeformat($row['last_updated']),
				'assigned' => array(
					'id' => $row['id_member_assigned'],
				),
				'respondent' => array(
					'id' => $row['id_member_updated'],
					'name' => $row['respondent'],
				),
				'urgency' => array(
					'level' => $row['urgency'],
					'label' => $row['urgency'] > TICKET_URGENCY_HIGH ? '<span class="error">' . $txt['shd_urgency_' . $row['urgency']] . '</span>' : $txt['shd_urgency_' . $row['urgency']],
				),
				'is_unread' => ($row['id_last_msg'] > $row['log_read']),
				'new_href' => ($row['id_last_msg'] <= $row['log_read']) ? '' : ($scripturl . '?action=helpdesk;sa=ticket;ticket=' . $row['id_ticket'] . '.new' . ($_REQUEST['sa'] == 'recyclebin' ? ';recycle' : '') . '#new'),
				'private' => $row['private'],
				'actions' => array(
					'movedept' => !empty($context['shd_multi_dept']) && (shd_allowed_to('shd_move_dept_any', $context['shd_department']) || ($is_own && shd_allowed_to('shd_move_dept_own', $context['shd_department']))) ? '<a href="' . $scripturl . '?action=helpdesk;sa=movedept;ticket=' . $row['id_ticket'] . ';home;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_move_dept'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/movedept.png" alt="' . $txt['shd_move_dept'] . '" /></a>' : '',
				),
				'num_replies' => $row['num_replies'],
				'all_replies' => (int) $row['num_replies'] + (int) $row['deleted_replies'],
			);

			if ($row['status'] == TICKET_STATUS_CLOSED)
			{
				$new_block['actions'] += array(
					'resolve' => shd_allowed_to('shd_unresolve_ticket_any', $context['shd_department']) || ($is_own && shd_allowed_to('shd_unresolve_ticket_own', $context['shd_department'])) ? '<a href="' . $scripturl . '?action=helpdesk;sa=resolveticket;ticket=' . $row['id_ticket'] . ';home;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_ticket_unresolved'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/unresolved.png" alt="' . $txt['shd_ticket_unresolved'] . '" /></a>' : '',
				);
			}
			elseif ($row['status'] == TICKET_STATUS_DELETED) // and thus, we're in the recycle bin
			{
				$new_block['actions'] += array(
					'restore' => shd_allowed_to('shd_restore_ticket_any', $context['shd_department']) || ($is_own && shd_allowed_to('shd_restore_ticket_own', $context['shd_department'])) ? '<a href="' . $scripturl . '?action=helpdesk;sa=restoreticket;ticket=' . $row['id_ticket'] . ';home;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_ticket_restore'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/restore.png" alt="' . $txt['shd_ticket_restore'] . '" /></a>' : '',
					'permadelete' => shd_allowed_to('shd_delete_recycling', $context['shd_department']) ? '<a href="' . $scripturl . '?action=helpdesk;sa=permadelete;ticket=' . $row['id_ticket'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_delete_permanently'] . '" onclick="return confirm(' . JavaScriptEscape($txt['shd_delete_permanently_confirm']) . ');"><img src="' . $settings['default_images_url'] . '/simpledesk/delete.png" alt="' . $txt['shd_delete_permanently'] . '" /></a>' : '',
				);
			}
			else
			{
				$langstring = '';
				if (shd_allowed_to('shd_assign_ticket_any', $context['shd_department']))
					$langstring = empty($row['id_member_assigned']) ? $txt['shd_ticket_assign'] : $txt['shd_ticket_reassign'];
				elseif (shd_allowed_to('shd_assign_ticket_own', $context['shd_department']) && (empty($row['id_member_assigned']) || $row['id_member_assigned'] == $context['user']['id']))
					$langstring = $row['id_member_assigned'] == $context['user']['id'] ? $txt['shd_ticket_unassign'] : $txt['shd_ticket_assign_self'];

				if (!empty($langstring))
					$new_block['actions']['assign'] = '<a href="' . $scripturl . '?action=helpdesk;sa=assign;ticket=' . $row['id_ticket'] . ';home;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $langstring . '"><img src="' . $settings['default_images_url'] . '/simpledesk/assign.png" alt="' . $langstring . '" /></a>';

				$new_block['actions'] += array(
					'resolve' => shd_allowed_to('shd_resolve_ticket_any', $context['shd_department']) || ($is_own && shd_allowed_to('shd_resolve_ticket_own', $context['shd_department'])) ? '<a href="' . $scripturl . '?action=helpdesk;sa=resolveticket;ticket=' . $row['id_ticket'] . ';home;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_ticket_resolved'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/resolved.png" alt="' . $txt['shd_ticket_resolved'] . '" /></a>' : '',
					'tickettotopic' => empty($modSettings['shd_helpdesk_only']) && shd_allowed_to('shd_ticket_to_topic', $context['shd_department']) && ($row['deleted_replies'] == 0 || shd_allowed_to('shd_access_recyclebin')) ? '<a href="' . $scripturl . '?action=helpdesk;sa=tickettotopic;ticket=' . $row['id_ticket'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_ticket_move_to_topic'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/tickettotopic.png" alt="' . $txt['shd_ticket_move_to_topic'] . '" /></a>' : '',
					'delete' => shd_allowed_to('shd_delete_ticket_any', $context['shd_department']) || ($is_own && shd_allowed_to('shd_delete_ticket_own')) ? '<a href="' . $scripturl . '?action=helpdesk;sa=deleteticket;ticket=' . $row['id_ticket'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_ticket_delete'] . '" onclick="return confirm(' . JavaScriptEscape($txt['shd_delete_confirm']) . ');"><img src="' . $settings['default_images_url'] . '/simpledesk/delete.png" alt="' . $txt['shd_ticket_delete'] . '" /></a>' : '',
				);
			}

			$context['ticket_blocks'][$block_key]['tickets'][$row['id_ticket']] = $new_block;

			$users[] = $row['id_member_started'];
			$users[] = $row['id_member_updated'];
			$users[] = $row['id_member_assigned'];
			$tickets[$row['id_ticket']] = array();
		}
		$smcFunc['db_free_result']($query);
	}

	$users = array_unique($users);
	if (!empty($users))
		loadMemberData($users, false, 'minimal');

	foreach ($context['ticket_blocks'] as $block_id => $block)
	{
		if (empty($block['tickets']))
			continue;

		foreach ($block['tickets'] as $tid => $ticket)
		{
			// Set up names and profile links for topic starter
			if (!empty($user_profile[$ticket['starter']['id']]))
			{
				// We found the name, so let's use their current name and profile link
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['starter']['name'] = $user_profile[$ticket['starter']['id']]['real_name'];
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['starter']['link'] = shd_profile_link($user_profile[$ticket['starter']['id']]['real_name'], $ticket['starter']['id']);
			}
			else
				// We didn't, so keep using the name we found previously and don't make an actual link
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['starter']['link'] = $context['ticket_blocks'][$block_id]['tickets'][$tid]['starter']['name'];

			// Set up names and profile links for assigned user
			if ($ticket['assigned']['id'] == 0 || empty($user_profile[$ticket['assigned']['id']]))
			{
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['assigned']['name'] = $txt['shd_unassigned'];
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['assigned']['link'] = '<span class="error">' . $txt['shd_unassigned'] . '</span>';
			}
			else
			{
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['assigned']['name'] = $user_profile[$ticket['assigned']['id']]['real_name'];
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['assigned']['link'] = shd_profile_link($user_profile[$ticket['assigned']['id']]['real_name'], $ticket['assigned']['id']);
			}

			// And last respondent
			if ($ticket['respondent']['id'] == 0 || empty($user_profile[$ticket['respondent']['id']]))
			{
				// Didn't find the name, so reuse what we have
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['respondent']['link'] = $context['ticket_blocks'][$block_id]['tickets'][$tid]['respondent']['name'];
			}
			else
			{
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['respondent']['name'] = $user_profile[$ticket['respondent']['id']]['real_name'];
				$context['ticket_blocks'][$block_id]['tickets'][$tid]['respondent']['link'] = shd_profile_link($user_profile[$ticket['respondent']['id']]['real_name'], $ticket['respondent']['id']);
			}
		}
	}

	foreach ($context['ticket_blocks'] as $block_id => $block)
	{
		if (empty($block['display']) || (empty($block['count']) && !$block['required'] && empty($block['collapsed'])))
			unset($context['ticket_blocks'][$block_id]);
	}

	$base_url = '';
	foreach ($context['ticket_blocks'] as $block_id => $block)
	{
		if ($block['sort']['add_link'])
			$base_url .= $block['sort']['link_bits'][$block['sort']['item']];
	}

	if ($_REQUEST['sa'] != 'viewblock')
	{
		foreach ($context['ticket_blocks'] as $block_id => $block)
		{
			$num_per_page = !empty($context['shd_preferences']['blocks_' . $block_key . '_count']) ? $context['shd_preferences']['blocks_' . $block_key . '_count'] : $context['items_per_page'];
			$url_fragment = $base_url;

			foreach ($block_list as $block_item)
			{
				if ($block_item == $block_id)
					$url_fragment .= ';st_' . $block_item . '=%1$d';
				elseif (!empty($context['ticket_blocks'][$block_item]['start']))
					$url_fragment .= ';st_' . $block_item . '=' . $context['ticket_blocks'][$block_item]['start'];
			}

			$context['start'] = $context['ticket_blocks'][$block_id]['start'];
			$context['ticket_blocks'][$block_id]['page_index'] = shd_no_expand_pageindex($scripturl . $primary_url . $url_fragment . $context['shd_dept_link'] . $context['filter_fragment'] . '#shd_block_' . $block_id, $context['start'], $block['count'], $block['num_per_page'], true);
		}
	}

	// Just need to deal with those pesky prefix fields, if there are any.
	if (empty($tickets))
		return; // We're all done here.

	// 1. Figure out if there are any custom fields that apply to us or not.
	if ($context['shd_multi_dept'] && empty($context['shd_department']))
		$dept_list = shd_allowed_to('access_helpdesk', false);
	else
		$dept_list = array($context['shd_department']);

	$fields = array();
	$query = $smcFunc['db_query']('', '
		SELECT hdcf.id_field, can_see, field_type, field_options, placement, field_name
		FROM {db_prefix}helpdesk_custom_fields AS hdcf
			INNER JOIN {db_prefix}helpdesk_custom_fields_depts AS hdcfd ON (hdcfd.id_field = hdcf.id_field)
		WHERE placement IN ({array_int:placement_prefix})
			AND field_loc IN ({array_int:locations})
			AND hdcfd.id_dept IN ({array_int:dept_list})
			AND active = {int:active}
		GROUP BY hdcf.id_field
		ORDER BY field_order',
		array(
			'locations' => array(CFIELD_TICKET, CFIELD_TICKET | CFIELD_REPLY),
			'placement_prefix' => array(CFIELD_PLACE_PREFIX, CFIELD_PLACE_PREFIXFILTER),
			'active' => 1,
			'dept_list' => $dept_list,
		)
	);
	$is_staff = shd_allowed_to('shd_staff', $context['shd_department']);
	$is_admin = $context['user']['is_admin'] || shd_allowed_to('admin_helpdesk', $context['shd_department']);
	$context['shd_filter_fields'] = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		list($user_see, $staff_see) = explode(',', $row['can_see']);
		if ($is_admin || ($is_staff && $staff_see == '1') || (!$is_staff && $user_see == '1'))
		{
			if (!empty($row['field_options']))
			{
				$row['field_options'] = unserialize($row['field_options']);
				if (isset($row['field_options']['inactive']))
					unset($row['field_options']['inactive']);
				foreach ($row['field_options'] as $k => $v)
					if (strpos($v, '[') !== false)
						$row['field_options'][$k] = parse_bbc($v);
			}
			$fields[$row['id_field']] = $row;

			if ($row['placement'] == CFIELD_PLACE_PREFIXFILTER)
				$context['shd_filter_fields'][$row['id_field']] = array(
					'name' => $row['field_name'],
					'options' => $row['field_options'],
					'in_use' => array(),
				);
		}
	}
	$smcFunc['db_free_result']($query);

	if (empty($fields))
		return; // No fields to process, time to go.

	// 2. Get the relevant values.
	$query = $smcFunc['db_query']('', '
		SELECT id_post, id_field, value
		FROM {db_prefix}helpdesk_custom_fields_values
		WHERE id_post IN ({array_int:tickets})
			AND id_field IN ({array_int:fields})
			AND post_type = {int:ticket}',
		array(
			'tickets' => array_keys($tickets),
			'fields' => array_keys($fields),
			'ticket' => CFIELD_TICKET,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$tickets[$row['id_post']][$row['id_field']] = $row['value'];

	// 3. Apply the values into the tickets.
	if ($_REQUEST['sa'] == 'closedtickets')
		$context['filterbase'] = $scripturl . '?action=helpdesk;sa=closedtickets';
	elseif ($_REQUEST['sa'] == 'recyclebin')
		$context['filterbase'] = $scripturl . '?action=helpdesk;sa=recyclebin';
	else
		$context['filterbase'] = $scripturl . '?' . $context['shd_home'];

	foreach ($context['ticket_blocks'] as $block_id => $block)
	{
		if (empty($block['tickets']))
			continue;

		foreach ($block['tickets'] as $ticket_id => $ticket)
		{
			if (isset($tickets[$ticket_id]))
			{
				$prefix_filter = '';
				$prefix = '';
				
				foreach ($fields as $field_id => $field)
				{
					if (empty($tickets[$ticket_id][$field_id]))
						continue;

					if ($field['placement'] == CFIELD_PLACE_PREFIXFILTER)
					{
						if (!isset($field['field_options'][$tickets[$ticket_id][$field_id]]))
							continue;

						$prefix_filter .= '[<a href="' . $context['filterbase'] . $context['shd_dept_link'] . ';field=' . $field_id . ';filter=' . $tickets[$ticket_id][$field_id] . '">' . $field['field_options'][$tickets[$ticket_id][$field_id]] . '</a>] ';
					}
					else
					{
						if ($field['field_type'] == CFIELD_TYPE_CHECKBOX)
							$prefix .= !empty($tickets[$ticket_id][$field_id]) ? $txt['yes'] . ' ' : $txt['no'] . ' ';
						elseif ($field['field_type'] == CFIELD_TYPE_SELECT || $field['field_type'] == CFIELD_TYPE_RADIO)
							$prefix .= $field['field_options'][$tickets[$ticket_id][$field_id]] . ' ';
						elseif ($field['field_type'] == CFIELD_TYPE_MULTI)
						{
							$values = explode(',', $tickets[$ticket_id][$field_id]);
							foreach ($values as $value)
								$prefix .= $field['field_options'][$value] . ' ';
						}
						else
							$prefix .= $tickets[$ticket_id][$field_id] . ' ';
					}
				}

				// First, set aside the subject, and if there is a non category prefix, strip links from it.
				$subject = $ticket['subject'];
				if (!empty($prefix))
					$prefix = '[' . trim(preg_replace('~<a (.*?)</a>~is', '', $prefix)) . '] ';
				// Then, if we have a category prefix, prepend that to any other prefix we have.
				if (!empty($prefix_filter))
					$prefix = $prefix_filter . $prefix;
				// Lastly, if we have some kind of prefix to put in front of this ticket, do so.
				if (!empty($prefix))
				{
					$context['ticket_blocks'][$block_id]['tickets'][$ticket_id]['subject'] = $prefix . $subject;
					$context['ticket_blocks'][$block_id]['tickets'][$ticket_id]['link'] = $prefix . '<a href="' . $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $ticket_id . ($_REQUEST['sa'] == 'recyclebin' ? ';recycle' : '') . '">' . $subject . '</a>';
				}
			}
		}
	}

	// 4. We've collected the list of prefix-filter fields in use, now establish which values are actually in use.
	if (!empty($context['shd_filter_fields']))
	{
		$query = $smcFunc['db_query']('', '
			SELECT id_field, value
			FROM {db_prefix}helpdesk_custom_fields_values
			WHERE id_field IN ({array_int:fields})',
			array(
				'fields' => array_keys($context['shd_filter_fields']),
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$context['shd_filter_fields'][$row['id_field']]['in_use'][$row['value']] = true;
		$smcFunc['db_free_result']($query);

		foreach ($context['shd_filter_fields'] as $id_field => $field)
		{
			if (empty($field['in_use']))
				unset($context['shd_filter_fields'][$id_field]);
			else
			{
				foreach ($field['options'] as $k => $v)
					if (!isset($field['in_use'][$k]))
						unset($context['shd_filter_fields'][$id_field]['options'][$k]);

				if (empty($context['shd_filter_fields'][$id_field]['options']))
					unset($context['shd_filter_fields'][$id_field]);
			}
		}
	}
}

/**
 *	Return the list of columns that is applicable to a given block.
 *
 *	In order to centralise the list of actions to be displayed in a block, and in its counterpart that displays all the values,
 *	the lists of columns per block is kept here.
 *
 *	@param string $block The block we are calling from:
 *	- assigned: assigned to me
 *	- new: new tickets
 *	- staff: pending staff
 *	- user_staff: pending with user (staff view)
 *	- user_user: pending with user (user view)
 *	- closed: resolved tickets
 *	- recycled: deleted tickets
 *	- withdeleted: tickets with deleted replies
 *
 *	@return array An indexed array of the columns in the order they should be displayed.
 *	@see shd_main_helpdesk()
 *	@see shd_closed_tickets()
 *	@see shd_recycle_bin()
 *	@since 1.0
*/
function shd_get_block_columns($block)
{
	switch ($block)
	{
		case 'assigned':
			return array(
					'ticket_id',
					'ticket_name',
					'starting_user',
					'replies',
					'status',
					'urgency',
					'updated',
					'actions',
				);
		case 'new':
			return array(
				'ticket_id',
				'ticket_name',
				'starting_user',
				'assigned',
				'urgency',
				'updated',
				'actions',
			);
		case 'staff':
			return array(
				'ticket_id',
				'ticket_name',
				'starting_user',
				'replies',
				'assigned',
				'urgency',
				'updated',
				'actions',
			);
		case 'user_staff':
			return array(
				'ticket_id',
				'ticket_name',
				'starting_user',
				'last_reply',
				'replies',
				'urgency',
				'updated',
				'actions',
			);
		case 'user_user':
			return array(
				'ticket_id',
				'ticket_name',
				'last_reply',
				'replies',
				'urgency',
				'updated',
				'actions',
			);
		case 'closed':
			return array(
				'ticket_id',
				'ticket_name',
				'starting_user',
				'replies',
				'updated',
				'actions',
			);
		case 'recycled':
			return array(
				'ticket_id',
				'ticket_name',
				'starting_user',
				'allreplies',
				'assigned',
				'updated',
				'actions',
			);
		case 'withdeleted':
			return array(
				'ticket_id',
				'ticket_name',
				'starting_user',
				'allreplies',
				'assigned',
				'updated',
				'actions',
			);
		default:
			return array();
	}
}
?>