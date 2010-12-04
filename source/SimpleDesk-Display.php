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
# File Info: SimpleDesk-Display.php / 1.0 Felidae             #
###############################################################

/**
 *	This file sets up the regular ticket view, including the menu of operations that can
 *	be applied to a ticket. It is also resposible for setting up the AJAX items for modifying privacy and urgency from
 *	the ticket view itself, as well as all the handling responsible for Quick Reply including the 'Go Advanced' mode.
 *
 *	@package source
 *	@since 1.0
*/

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Loads all the data and sets all the options for displaying a ticket.
 *
 *	This function does a lot of work in setting up a ticket to be displayed:
 *	<ul>
 *		<li>Invokes shd_load_ticket() to get the principle data</li>
 *		<li>Creates $context['ticket'] to hold the data block, some of which is derived from the return of shd_load_ticket():
 *			<ul>
 *				<li>id: regular numeric ticket id</li>
 *				<li>display_id: zero padded ticket id (e.g. 00001)</li>
 *				<li>subject: censored version of the subject</li>
 *				<li>first_msg: id of the opening post that forms the ticket body</li>
 *				<li>body: formatted (parsed for smileys and bbcode) version of the ticket post</li>
 *				<li>id_member: user id of the ticket's poster</li>
 *				<li>id_member_assigned: user id of the ticket's assigned user</li>
 *				<li>member: hash array of the ticket poster's details:
 *					<ul>
 *						<li>id: their user id</li>
 *						<li>name: the name stated in the ticket post for that use</li>
 *						<li>link: link to the profile of the user</li>
 *					</ul>
 *				</li>
 *				<li>assigned: hash array of the assignee of the ticket:
 *					<ul>
 *						<li>id: their user id</li>
 *						<li>name: name of the assignee, or 'Unassigned'</li>
 *						<li>link: a full HTML link to their profile, or 'Unassigned' in red text</li>
 *					</ul>
 *				</li>
 *				<li>assigned_self: boolean, whether the ticket is assigned to the current user or not</li>
 *				<li>ticket_opener: boolean, whether the current user is the user who opened this ticket</li>
 *				<li>urgency: hash array
 *					<ul>
 *						<li>level: numeric identifier of current ticket urgency</li>
 *						<li>label: the HTML label of the urgency, including being in red for "Very High" or above</li>
 *						<li>increase: Boolean, whether the current ticket urgency can be increased given the current ticket state and user permissions</li>
 *						<li>decrease: Boolean, whether the current ticket urgency can be increased given the current ticket state and user permissions</li>
 *					</ul>
 *				</li>
 *				<li>status: hash array
 *					<ul>
 *						<li>level: numeric, current status identifier</li>
 *						<li>label: string representing the current status</li>
 *					</ul>
 *				<li>num_replies: the number of replies to the ticket so far</li>
 *				<li>deleted_replies: how many deleted replies in this ticket</li>
 *				<li>poster_time: formatted string containing the time the ticket was opened</li>
 *				<li>privacy: hash array
 *					<ul>
 *						<li>label: current label to be used with the privacy item</li>
 *						<li>can_change: Boolean, whether the user's permission with this ticket allows us to edit the ticket privacy</li>
 *					</ul>
 *				</li>
 *				<li>closed: Boolean, represents whether this ticket is closed (used a lot with the navigation menu)</li>
 *				<li>deleted: Boolean, represents whether this ticket is deleted (used a lot with the navigation menu)</li>
 *				<li>ip_address: IP address logged at the time the ticket was opened; if moderate_forum_members permission is available, this will be a link to the track IP area</li>
 *				<li>modified: if the ticket has been modified, also get the modified details:
 *					<ul>
 *						<li>id: user id who edited the ticket (not always available)</li>
 *						<li>time: formatted string of the time the post was edited</li>
 *						<li>timestamp: raw timestamp of the time the post was edited</li>
 *						<li>name: user name of the editing user; if we have a definite user id, this should contain the current name, falling back to the previously stored name</li>
 *						<li>link: if we have a known, valid user id for the post's editor, this will contain a link to their profile, with the link text using their current display name; alternatively it will contain a regular string which is the username stored with the edit.</li>
 *					</ul>
 *				</li>
 *				<li>display_recycle: Either holds the $txt identifier of the message to apply as a warning, or false if displaying of recycling stuff in this ticket isn't appropriate (either for permissions or just because of no deleted replies, or we're just in regular ticket view)</li>
 *			</ul>
 *		</li>
 *		<li>define the page index with SMF's constructPageIndex</li>
 *		<li>query for all the ids of messages we might display, followed by querying for the message details themselves, pushing that query resource to $reply_request so we can use it in shd_view_replies() later</li>
 *		<li>load details of all the users applicable for posts in this page</li>
 *		<li>request all the visible attachments from {@link shd_display_load_attachments()}</li>
 *		<li>since we are viewing this ticket, mark it read</li>
 *		<li>set up the breadcrumb trail</li>
 *		<li>set up the ticket navigation menu</li>
 *		<li>call in the editor component from SimpleDesk-Post.php and friends, ready for Quick Reply</li>
 *		<li>invoke the different Javascript objects that are applicable on the page:
 *			<ul>
 *				<li>privacy changer</li>
 *				<li>urgency changer</li>
 *				<li>quick reply / quote / go advanced</li>
 *			</ul>
 *		</li>
 *	</ul>
 *
 *	@see shd_prepare_ticket_context()
 *	@since 1.0
*/
function shd_view_ticket()
{
	global $context, $txt, $scripturl, $settings, $reply_request, $smcFunc, $modSettings, $memberContext, $sourcedir, $user_info, $options;

	loadTemplate('SimpleDesk-Display');

	$ticketinfo = shd_load_ticket();

	// How much are we sticking on each page?
	$context['messages_per_page'] = empty($modSettings['disableCustomPerPage']) && !empty($options['messages_per_page']) && !WIRELESS ? $options['messages_per_page'] : $modSettings['defaultMaxMessages'];

	censorText($ticketinfo['subject']);
	censorText($ticketinfo['body']);

	$context['user_list'] = array(); // as we go along, build a list of users who are relevant

	$context['ticket'] = array(
		'id' => $context['ticket_id'],
		'display_id' => str_pad($context['ticket_id'], 5, '0', STR_PAD_LEFT),
		'subject' => $ticketinfo['subject'],
		'first_msg' => $ticketinfo['id_first_msg'],
		'body' => shd_format_text($ticketinfo['body'], $ticketinfo['smileys_enabled'], 'shd_ticket_' . $context['ticket_id']),
		'id_member' => $ticketinfo['id_member'],
		'id_member_assigned' => $ticketinfo['assigned_id'],
		'member' => array(
			'id' => $ticketinfo['starter_id'],
			'name' => $ticketinfo['starter_name'],
			'link' => shd_profile_link($ticketinfo['starter_name'], $ticketinfo['starter_id']),
		),
		'assigned' => array(
			'id' => $ticketinfo['assigned_id'],
			'name' => ($ticketinfo['assigned_id'] > 0) ? $ticketinfo['assigned_name'] : $txt['shd_unassigned'],
			'link' => ($ticketinfo['assigned_id'] > 0) ? shd_profile_link($ticketinfo['assigned_name'], $ticketinfo['assigned_id']) : '<span class="error">' . $txt['shd_unassigned'] . '</span>',
		),
		'assigned_self' => $ticketinfo['assigned_id'] == $user_info['id'],
		'ticket_opener' => $ticketinfo['starter_id'] == $user_info['id'],
		'urgency' => array(
			'level' => $ticketinfo['urgency'],
			'label' => $ticketinfo['urgency'] > TICKET_URGENCY_HIGH ? '<span class="error">' . $txt['shd_urgency_' . $ticketinfo['urgency']] . '</span>' : $txt['shd_urgency_' . $ticketinfo['urgency']],
		),
		'status' => array(
			'level' => $ticketinfo['status'],
			'label' => $txt['shd_status_' . $ticketinfo['status']],
		),
		'num_replies' => $ticketinfo['num_replies'],
		'deleted_replies' => $ticketinfo['deleted_replies'],
		'poster_time' => timeformat($ticketinfo['poster_time']),
		'privacy' => array(
			'label' => $ticketinfo['private'] ? $txt['shd_ticket_private'] : $txt['shd_ticket_notprivate'],
			'can_change' => shd_allowed_to('shd_alter_privacy_any') || (shd_allowed_to('shd_alter_privacy_own') && $ticketinfo['id_member'] == $user_info['id']),
		),
		'closed' => $ticketinfo['closed'],
		'deleted' => $ticketinfo['deleted'],
		'ip_address' => $ticketinfo['link_ip'] ? ('<a href="' . $scripturl . '?action=trackip;searchip=' . $ticketinfo['starter_ip'] . '">' . $ticketinfo['starter_ip'] . '</a>') : $ticketinfo['starter_ip'],
	);

	// Stuff concerning whether the ticket is deleted or not
	// Display recycling stuff if: ticket is deleted (if we can see it, we can see the bin) OR ticket has deleted replies and we can see the bin and we requested to see them
	$context['ticket']['display_recycle_replies'] = true;
	if ($context['ticket']['deleted'])
		$context['ticket']['display_recycle'] = $txt['shd_ticket_has_been_deleted'];
	elseif ($context['ticket']['deleted_replies'] > 0)
	{
		if (shd_allowed_to('shd_access_recyclebin'))
		{
			$context['ticket']['display_recycle'] = $txt['shd_ticket_replies_deleted'];
			$ticketlink = $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . (isset($_REQUEST['recycle']) ? '' : ';recycle');
			$context['ticket']['display_recycle'] .= ' ' . sprintf((isset($_REQUEST['recycle']) ? $txt['shd_ticket_replies_deleted_view'] : $txt['shd_ticket_replies_deleted_link']), $ticketlink);
			$context['ticket']['display_recycle_replies'] = (isset($_REQUEST['recycle']));
		}
		else
			$context['ticket']['display_recycle_replies'] = false;
	}
	else
	{
		$context['ticket']['display_recycle'] = false;
		$context['ticket']['display_recycle_replies'] = false;
	}

	// Ticket privacy
	$context['ticket']['privacy']['can_change'] = $context['ticket']['privacy']['can_change'] && (!$context['ticket']['closed'] && !$context['ticket']['deleted']);
	if (empty($modSettings['shd_privacy_display']) || $modSettings['shd_privacy_display'] == 'smart')
		$context['display_private'] = shd_allowed_to('shd_view_ticket_private_any') || shd_allowed_to('shd_alter_privacy_own') || shd_allowed_to('shd_alter_privacy_any') || $ticketinfo['private'];
	else
		$context['display_private'] = true;

	$context['link_ip_address'] = $ticketinfo['link_ip'];

	if ($ticketinfo['modified_time'] > 0)
	{
		$context['ticket']['modified'] = array(
			'id' => $ticketinfo['modified_id'],
			'name' => $ticketinfo['modified_name'],
			'link' => shd_profile_link($ticketinfo['modified_name'], $ticketinfo['modified_id']),
			'timestamp' => $ticketinfo['modified_time'],
			'time' => timeformat($ticketinfo['modified_time']),
		);
	}

	$context['ticket']['urgency'] += shd_can_alter_urgency($ticketinfo['urgency'], $ticketinfo['starter_id'], $ticketinfo['closed'], $ticketinfo['deleted']);

	$context['page_index'] = shd_no_expand_pageindex($scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . '.%1$d' . (isset($_REQUEST['recycle']) ? ';recycle' : '') . '#replies', $context['ticket_start'], (empty($context['display_recycle']) ? $context['ticket']['num_replies'] : (int) $context['ticket']['num_replies'] + (int) $context['ticket']['deleted_replies']), $context['messages_per_page'], true);

	$context['get_replies'] = 'shd_prepare_ticket_context';

	$query = shd_db_query('', '
		SELECT id_msg, id_member, modified_member
		FROM {db_prefix}helpdesk_ticket_replies
		WHERE id_ticket = {int:ticket}
			AND id_msg > {int:first_msg}' . (!empty($context['ticket']['display_recycle_replies']) ? '' : '
			AND message_status = {int:msg_status}') . '
		ORDER BY id_msg ' . ($context['messages_per_page'] == -1 ? '' : '
		LIMIT ' . $context['ticket_start'] . ', ' . $context['messages_per_page']),
		array(
			'ticket' => $context['ticket_id'],
			'first_msg' => $ticketinfo['id_first_msg'],
			'msg_status' => MSG_STATUS_NORMAL,
		)
	);

	$context['ticket_messages'] = array();
	$posters = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		if (!empty($row['id_member']))
			$posters[] = $row['id_member'];

		if (!empty($row['modified_member']))
			$posters[] = $row['modified_member'];

		$context['ticket_messages'][] = $row['id_msg'];
	}
	$smcFunc['db_free_result']($query);

	// We might want the OP's avatar, add 'em to the list -- just in case.
	$posters[] = $context['ticket']['id_member'];

	$posters = array_unique($posters);

	$context['is_team'] = array();
	// Get the poster data
	if (!empty($posters))
	{
		loadMemberData($posters);

		// Are they current team members?
		$team = array_intersect($posters, shd_members_allowed_to('shd_staff'));

		foreach ($team as $member)
			$context['is_team'][$member] = true;
	}

	if (!empty($context['ticket_messages']))
	{
		$reply_request = shd_db_query('', '
			SELECT
				id_msg, poster_time, poster_ip, id_member, modified_time, modified_name, modified_member, body,
				smileys_enabled, poster_name, poster_email, message_status
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_msg IN ({array_int:message_list})' . (!empty($context['ticket']['display_recycle']) ? '' : '
				AND message_status IN ({array_int:msg_normal})') . '
			ORDER BY id_msg',
			array(
				'message_list' => $context['ticket_messages'],
				'msg_normal' => array(MSG_STATUS_NORMAL),
			)
		);
	}
	else
	{
		$reply_request = false;
		$context['first_message'] = 0;
		$context['first_new_message'] = false;
	}

	// Grab the avatar for the poster
	$context['ticket']['poster_avatar'] = empty($context['ticket']['member']['id']) ? array() : (loadMemberContext($context['ticket']['id_member']) ? $memberContext[$context['ticket']['id_member']]['avatar'] : array());

	// Before we grab attachments, also make sure we get any from the first msg (i.e. the ticket)
	$context['ticket_messages'][] = $context['ticket']['first_msg'];
	shd_display_load_attachments();

	// Mark read goes here
	if (!empty($user_info['id']))
	{
		$smcFunc['db_insert']('replace',
			'{db_prefix}helpdesk_log_read',
			array(
				'id_ticket' => 'int', 'id_member' => 'int', 'id_msg' => 'int',
			),
			array(
				$context['ticket_id'], $user_info['id'], $ticketinfo['id_last_msg'],
			),
			array('id_member', 'id_topic')
		);
	}

	// Build the link tree. If the ticket is recycled, display 'Recycle bin', else 'Tickets'.
	$context['linktree'][] = array(
		'url' => $context['ticket']['status']['level'] == TICKET_STATUS_DELETED ? $scripturl . '?action=helpdesk;sa=recyclebin' : $scripturl . '?action=helpdesk;sa=main',
		'name' => $context['ticket']['status']['level'] == TICKET_STATUS_DELETED ? $txt['shd_recycle_bin'] : $txt['shd_linktree_tickets'],
	);
	// If it's closed, add that to the linktree.
	if ($context['ticket']['status']['level'] == TICKET_STATUS_CLOSED)
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=closedtickets',
			'name' => $txt['shd_tickets_closed'],
		);
	// Lastly add the ticket name and link.
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
		'name' => $context['ticket']['subject'],
	);

	// Template stuff
	$context['sub_template'] = 'viewticket';
	$context['page_title'] = $txt['shd_helpdesk'] . ' [' . $context['ticket']['display_id'] . '] ' . $context['ticket']['subject'];

	// Ticket navigation
	$context['can_reply'] = !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_reply_ticket_any') || ($context['ticket']['ticket_opener'] && shd_allowed_to('shd_reply_ticket_own'))); // needs perms - calc'd here because we use it in display template too
	$context['can_quote'] = $context['can_reply'] && !empty($modSettings['shd_allow_ticket_bbc']);
	$context['can_go_advanced'] = !empty($modSettings['shd_allow_ticket_bbc']) || !empty($modSettings['allow_ticket_smileys']) || shd_allowed_to('shd_post_attachment');
	$context['can_see_ip'] = shd_allowed_to('shd_staff');

	$context['ticket_navigation'] = array();
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=editticket;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'edit',
		'alt' => '*',
		'display' => !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_edit_reply_any') || ($context['ticket']['ticket_opener'] && shd_allowed_to('shd_edit_reply_own'))),
		'text' => 'shd_ticket_edit',
	);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=markunread;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'unread',
		'alt' => '*',
		'display' => !$context['ticket']['closed'] && !$context['ticket']['deleted'],
		'text' => 'shd_ticket_markunread',
	);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=resolveticket;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => !$context['ticket']['closed'] ? 'resolved' : 'unresolved',
		'alt' => '*',
		'display' => !$context['ticket']['deleted'] && (shd_allowed_to('shd_resolve_ticket_any') || (shd_allowed_to('shd_resolve_ticket_own') && $context['ticket']['ticket_opener'])),
		'text' => !$context['ticket']['closed'] ? 'shd_ticket_resolved' : 'shd_ticket_unresolved',
	);

	// This is always going to be a pain. But it should be possible to contextualise it nicely.
	// And while this isn't quite as nicely formatted as a single nice array definition,
	// imagine trying to debug the display and text options later if it were done with nested ternaries... *shudder*
	$assign_nav = array(
		'url' => $scripturl . '?action=helpdesk;sa=assign;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'assign',
		'alt' => '*',
		'text' => '',
		'display' => false,
	);
	if (shd_allowed_to('shd_assign_ticket_any'))
	{
		$assign_nav['display'] = true && !$context['ticket']['closed'] && !$context['ticket']['deleted'];
		$assign_nav['text'] = empty($context['ticket']['id_member_assigned']) ? 'shd_ticket_assign' : 'shd_ticket_reassign';
	}
	elseif (shd_allowed_to('shd_assign_ticket_own'))
	{
		$assign_nav['display'] = !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (empty($context['ticket']['id_member_assigned']) || $context['ticket']['assigned_self']); // either not assigned or assigned to self
		$assign_nav['text'] = $context['ticket']['assigned_self'] ? 'shd_ticket_unassign' : 'shd_ticket_assign_self';
	}

	$context['ticket_navigation'][] = $assign_nav;

	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=deleteticket;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'delete',
		'alt' => '*',
		'display' => !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_delete_ticket_any') || (shd_allowed_to('shd_delete_ticket_own') && $context['ticket']['ticket_opener'])),
		'text' => 'shd_ticket_delete',
		'onclick' => 'return confirm(' . JavaScriptEscape($txt['shd_delete_confirm']) . ');',
	);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=restoreticket;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'restore',
		'alt' => '*',
		'display' => $context['ticket']['deleted'] && (shd_allowed_to('shd_restore_ticket_any') || (shd_allowed_to('shd_restore_ticket_own') && $context['ticket']['ticket_opener'])),
		'text' => 'shd_ticket_restore',
	);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=permadelete;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'delete',
		'alt' => '*',
		'display' => $context['ticket']['deleted'] && shd_allowed_to('shd_delete_recycling'),
		'text' => 'shd_delete_permanently',
		'onclick' => 'return confirm(' . JavaScriptEscape($txt['shd_delete_permanently_confirm']) . ');',
	);

	$context['shd_can_move_to_topic'] = shd_allowed_to('shd_ticket_to_topic') && empty($modSettings['shd_helpdesk_only']);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=tickettotopic;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'tickettotopic',
		'alt' => '*',
		'display' => $context['shd_can_move_to_topic'] && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && ($context['ticket']['deleted_replies'] == 0 || shd_allowed_to('shd_access_recyclebin')),
		'text' => 'shd_ticket_move_to_topic',
	);

	// If we are going SMF style with the navigation, we need to rework the structure a wee bit.
	// No sense making a new array, mind, just fix up the existing one a touch, and don't do this on the master as we don't always need it.
	if (empty($modSettings['shd_ticketnav_style']) || !in_array($modSettings['shd_ticketnav_style'], array('sd', 'sdcompact', 'smf')))
		$modSettings['shd_ticketnav_style'] = 'sd';

	if ($modSettings['shd_ticketnav_style'] == 'smf')
		foreach ($context['ticket_navigation'] as $key => $button)
		{
			$context['can_' . $button['text']] = $button['display'];
			$context['ticket_navigation'][$key] += array(
				'lang' => true,
				'test' => 'can_' . $button['text'],
				'image' => 'shd_ticket_' . $button['icon'] . '.png',
			);
		}

	if (empty($modSettings['shd_staff_badge']))
		$modSettings['shd_staff_badge'] = 'nobadge';

	// Quick reply stuffs
	require_once($sourcedir . '/SimpleDesk-Post.php');
	require_once($sourcedir . '/Subs-Editor.php');
	loadTemplate('SimpleDesk-Post');

	if (empty($modSettings['shd_attachments_mode']))
		$modSettings['shd_attachments_mode'] = 'ticket';

	$context['ticket_form']['ticket'] = $context['ticket_id'];
	$context['ticket_form']['num_allowed_attachments'] = empty($modSettings['attachmentNumPerPostLimit']) || $modSettings['shd_attachments_mode'] == 'ticket' ? -1 : $modSettings['attachmentNumPerPostLimit'];
	$context['ticket_form']['do_attach'] = shd_allowed_to('shd_post_attachment');
	$context['ticket_form']['num_replies'] = $context['ticket']['num_replies'];
	$context['ticket_form']['disable_smileys'] = empty($modSettings['shd_allow_ticket_smileys']);

	// Set up the fancy editor
	shd_postbox(
		'shd_message',
		'',
		array(
			'post_button' => $txt['shd_reply_ticket'],
		)
	);

	// Lastly, our magic AJAX stuff ;D and we know we already made html_headers exist in SimpleDesk.php, score!
	$context['html_headers'] .= '
	<script type="text/javascript"><!-- // --><![CDATA[
	var sSessI = "' . $context['session_id'] . '";
	var sSessV = "' . $context['session_var'] . '";';

	if ($context['ticket']['privacy']['can_change'])
		$context['html_headers'] .= '
	var shd_ajax_problem = ' . JavaScriptEscape($txt['shd_ajax_problem']) . ';
	var privacyCtl = new shd_privacyControl({
		ticket: ' . $context['ticket_id'] . ',
		sUrl: smf_scripturl + "?action=helpdesk;sa=ajax;op=privacy;ticket=' . $context['ticket_id'] . '",
		sSession: sSessV + "=" + sSessI,
		sSrcA: "privlink",
		sDestSpan: "privacy"
	});';

	if ($context['ticket']['urgency']['increase'] || $context['ticket']['urgency']['decrease'])
		$context['html_headers'] .= '
	var urgencyCtl = new shd_urgencyControl({
		ticket: ' . $context['ticket_id'] . ',
		sUrl: smf_scripturl + "?action=helpdesk;sa=ajax;op=urgency;ticket=' . $context['ticket_id'] . ';change=",
		sSession: sSessV + "=" + sSessI,
		sDestSpan: "urgency",
		aButtons: ["up", "down"],
		aButtonOps: { up: "increase", down: "decrease" }
	});';

	if (!empty($options['display_quick_reply']))
		$context['html_headers'] .= '
	var oQuickReply = new QuickReply({
		bDefaultCollapsed: ' . (!empty($options['display_quick_reply']) && $options['display_quick_reply'] == 2 ? 'false' : 'true') .  ',
		iTicketId: ' . $context['ticket_id'] . ',
		iStart: ' . $context['start'] . ',
		sScriptUrl: smf_scripturl,
		sImagesUrl: "' . $settings['images_url'] . '",
		sContainerId: "quickReplyOptions",
		sImageId: "quickReplyExpand",
		sImageCollapsed: "collapse.gif",
		sImageExpanded: "expand.gif",
		sJumpAnchor: "quickreply",
		sHeaderId: "quickreplyheader",
		sFooterId: "quickreplyfooter"
	});';

	if (!empty($options['display_quick_reply']) && $context['can_go_advanced'])
		$context['html_headers'] .= '
	function goAdvanced()
	{
		document.getElementById("shd_bbcbox").style.display = ' . (!empty($modSettings['shd_allow_ticket_bbc']) ? '""' : '"none"') . ';
		document.getElementById("shd_smileybox").style.display = ' . (!empty($modSettings['shd_allow_ticket_smileys']) ? '""' : '"none"') . ';
		document.getElementById("shd_attach_container").style.display = ' . (!empty($context['ticket_form']['do_attach']) ? '""' : '"none"') . ';
		document.getElementById("shd_goadvancedbutton").style.display = "none";' . (!empty($context['controls']['richedit']['shd_message']['rich_active']) ? '
		oEditorHandle_shd_message.toggleView(true);' : '') . '
	}
	';

	$context['html_headers'] .= '
	// ]' . ']></script>';

	$context['shd_display'] = true;
	$context['controls']['richedit']['shd_message']['rich_active'] = 0; // we don't want it by default!

	// Register this form in the session variables.
	checkSubmitOnce('register');
}

/**
 *	Callback function for the template to load messages.
 *
 *	The process set up by shd_view_ticket() and invoked within template_view_replies() is reasonably complex.
 *	{@link shd_view_ticket()} identifies what messages should be displayed on the current page of the ticket, and performs a query
 *	to load the ticket data. Instead, however, of retrieving every row directly into memory before passing to the template,
 *	it passes the query result, and the name of a handler function into $context, so the template can call to get an
 *	individual row at a time, which saves memory amongst other things.
 *
 *	With respect to {@link shd_view_ticket()}, the relevant items are $reply_request being defined and $context['get_replies']
 *	being defined as the name of this function, and in {@link template_view_replies()}, the reference is $reply = $context['get_replies']()
 *
 *	@return mixed The function returns the "next" message reply's details, or simply false if no replies were available, or no further replies are available. Assuming a reply can be returned, it will be a hash array in the following format:
 *	<ul>
 *		<li>id: numeric message id</li>
 *		<li>member: hash array containing details of the poster; normally the return value from SMF's loadMemberContext() function. A minimal set of details is prepared if the poster holds no current SMF account. Common values:
 *			<ul>
 *				<li>name: User's name (falls back to the poster name specified in the replies table)</li>
 *				<li>id: User's id</li>
 *				<li>group: Name of the assigned group/post count group of the user</li>
 *				<li>link: HTML for a hyperlink to their profile</li>
 *				<li>email: Email address of the poster</li>
 *				<li>ip: IP address of the poster</li>
 *			</ul>
 *		</li>
 *		<li>body: censored, parsed for smileys and bbcode (in {@link shd_format_text()})</li>
 *		<li>time: string of the time the reply was posted</li>
 *		<li>timestamp: internal stored timestamp attached to the reply</li>
 *		<li>is_team: boolean value of whether the posting member is currently helpdesk staff</li>
 *		<li>can_edit: boolean value reflecting if this reply can be edited</li>
 *		<li>can_delete: boolean value reflecting if this reply can be deleted</li>
 *		<li>can_restore: boolean value reflecting if this reply can be restored</li>
 *		<li>ip_address: IP address used to post the message (not necessarily the user's normal IP address); if the user has moderate_forum_members permission, this returns a link to the track IP area, with the IP address as the link text, alternatively simply the IP address if not (is only displayed to helpdesk staff)</li>
 *		<li>modified: may not be declared, if it is, the message was modified some time after posting, and the following data items are in the hash array within:
 *			<ul>
 *				<li>id: user id who edited the reply (not always available)</li>
 *				<li>time: formatted string of the time the post was edited</li>
 *				<li>timestamp: raw timestamp of the time the post was edited</li>
 *				<li>name: user name of the editing user; if we have a definite user id, this should contain the current name, falling back to the previously stored name</li>
 *				<li>link: if we have a known, valid user id for the post's editor, this will contain a link to their profile, with the link text using their current display name; alternatively it will contain a regular string which is the username stored with the edit.</li>
 *			</ul>
 *		</li>
 *	</ul>
 *
 *	@see shd_view_ticket()
 *	@since 1.0
*/
function shd_prepare_ticket_context()
{
	global $settings, $txt, $modSettings, $scripturl, $options, $user_info, $smcFunc;
	global $memberContext, $context, $reply_request, $user_profile;

	if (empty($reply_request))
		return false;

	$message = $smcFunc['db_fetch_assoc']($reply_request);
	if (!$message)
	{
		$smcFunc['db_free_result']($reply_request);
		return false;
	}

	if (!loadMemberContext($message['id_member'], true))
	{
		// Notice this information isn't used anywhere else....
		$memberContext[$message['id_member']]['name'] = $message['poster_name'];
		$memberContext[$message['id_member']]['id'] = 0;
		$memberContext[$message['id_member']]['group'] = $txt['guest_title'];
		$memberContext[$message['id_member']]['link'] = $message['poster_name'];
		$memberContext[$message['id_member']]['email'] = $message['poster_email'];
		$memberContext[$message['id_member']]['show_email'] = showEmailAddress(true, 0);
		$memberContext[$message['id_member']]['is_guest'] = true;
		$memberContext[$message['id_member']]['group_stars'] = '';
	}
	$memberContext[$message['id_member']]['ip'] = $message['poster_ip'];

	censorText($message['body']);
	$message['body'] = shd_format_text($message['body'], $message['smileys_enabled'], 'shd_reply_' . $message['id_msg']);

	$output = array(
		'id' => $message['id_msg'],
		'member' => &$memberContext[$message['id_member']],
		'time' => timeformat($message['poster_time']),
		'timestamp' => forum_time(true, $message['poster_time']),
		'body' => $message['body'],
		'is_team' => !empty($context['is_team'][$message['id_member']]),
		'can_edit' => $message['message_status'] != MSG_STATUS_DELETED && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_edit_reply_any') || ($message['id_member'] == $user_info['id'] && shd_allowed_to('shd_edit_reply_own'))),
		'can_delete' => $message['message_status'] != MSG_STATUS_DELETED && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_delete_reply_any') || ($message['id_member'] == $user_info['id'] && shd_allowed_to('shd_delete_reply_own'))),
		'can_restore' => $message['message_status'] == MSG_STATUS_DELETED && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_restore_reply_any') || ($message['id_member'] == $user_info['id'] && shd_allowed_to('shd_restore_reply_own'))),
		'can_permadelete' => $message['message_status'] == MSG_STATUS_DELETED && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && shd_allowed_to('shd_delete_recycling'),
		'ip_address' => $context['link_ip_address'] ? ('<a href="' . $scripturl . '?action=trackip;searchip=' . $message['poster_ip'] . '">' . $message['poster_ip'] . '</a>') : $message['poster_ip'],
		'message_status' => $message['message_status'],
	);

	if (!empty($message['modified_time']))
	{
		$output['modified'] = array(
			'time' => timeformat($message['modified_time']),
			'timestamp' => forum_time(true, $message['modified_time']),
			'id' => !empty($user_profile[$message['modified_member']]) ? $message['modified_member'] : 0,
			'name' => !empty($user_profile[$message['modified_member']]) ? $user_profile[$message['modified_member']]['real_name'] : $message['modified_name'],
		);
		$output['modified']['link'] = shd_profile_link($output['modified']['name'], $output['modified']['id']);
	}

	return $output;
}

/**
 *	Loads data on all the attachments that will be displayed in a ticket's view.
 *
 *	Queries the {db_prefix}helpdesk_attachments table for the current ticket, or the messages that will be displayed
 *	(previously identified by {@link shd_view_ticket()}) and loads the id, name and size of them for display purposes. Differentiation
 *	between "attach to ticket" and "attach to reply" is made here; the data is loaded differently depending on the context;
 *	"attach to ticket" is simply loaded into an indexed array stored in $context['ticket_attach']['ticket'], while "attach
 *	to reply" is loaded into an indexed array subset in $context['ticket_attach']['reply'][msg_id] to retain the association.
 *
 *	@return array Builds an array within $contxt['ticket_attach'], as noted above. The individual data items per attachment are:
 *	- id: Numeric id for attachment itself
 *	- name: HTML sanitised name of the attachment's filename
 *	- size: string listing the size of the attachment, converted to kilobytes and rounded to two decimal places
 *	- byte_size: integer of raw size of attachment
 *	- href: the URL that would be used to access the attachment (required $context['ticket_id'] to be available, which it would anyway)
 *	- link: full HTML "a" element linking to the attachment, using the filename as the link text
 *	@since 1.0
*/
function shd_display_load_attachments()
{
	global $modSettings, $context, $smcFunc, $scripturl, $txt;

	if (empty($modSettings['shd_attachments_mode']))
		$modSettings['shd_attachments_mode'] = 'ticket'; // just in case we never actually go to the admin page!!

	$context['ticket_attach'][$modSettings['shd_attachments_mode']] = array();

	if ($modSettings['shd_attachments_mode'] == 'ticket')
	{
		$query = shd_db_query('', '
			SELECT hda.id_attach, a.filename, a.size
			FROM {db_prefix}helpdesk_attachments AS hda
				INNER JOIN {db_prefix}attachments AS a ON (hda.id_attach = a.id_attach)
			WHERE hda.id_ticket = {int:ticket}
				AND a.attachment_type != {int:thumb}
			ORDER BY hda.id_attach',
			array(
				'ticket' => $context['ticket_id'],
				'thumb' => 3,
			)
		);

		// Ticket ones can just be added on, they're nice and straightforward
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$context['ticket_attach'][$modSettings['shd_attachments_mode']][] = array(
				'id' => $row['id_attach'],
				'name' => preg_replace('~&amp;#(\\d{1,7}|x[0-9a-fA-F]{1,6});~', '&#\\1;', htmlspecialchars($row['filename'])),
				'size' => round($row['size'] / 1024, 2) . ' ' . $txt['kilobyte'],
				'byte_size' => $row['size'],
				'href' => $scripturl . '?action=dlattach;ticket=' . $context['ticket_id'] . '.0;attach=' . $row['id_attach'],
				'link' => '<a href="' . $scripturl . '?action=dlattach;ticket=' . $context['ticket_id'] . '.0;attach=' . $row['id_attach'] . '">' . htmlspecialchars($row['filename']) . '</a>',
			);
	}
	else
	{
		if (empty($context['ticket_messages']))
			return;

		$query = shd_db_query('', '
			SELECT hda.id_attach, hda.id_msg, a.filename, a.size
			FROM {db_prefix}helpdesk_attachments AS hda
				INNER JOIN {db_prefix}attachments AS a ON (hda.id_attach = a.id_attach)
			WHERE hda.id_msg IN ({array_int:msg})
				AND a.attachment_type != {int:thumb}
			ORDER BY hda.id_attach',
			array(
				'msg' => $context['ticket_messages'],
				'thumb' => 3,
			)
		);

		// Message ones are a little trickier since we actually need to tie them to msg ids
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$context['ticket_attach'][$modSettings['shd_attachments_mode']][$row['id_msg']][] = array(
				'id' => $row['id_attach'],
				'name' => preg_replace('~&amp;#(\\d{1,7}|x[0-9a-fA-F]{1,6});~', '&#\\1;', htmlspecialchars($row['filename'])),
				'size' => round($row['size'] / 1024, 2) . ' ' . $txt['kilobyte'],
				'byte_size' => $row['size'],
				'href' => $scripturl . '?action=dlattach;ticket=' . $context['ticket_id'] . '.0;attach=' . $row['id_attach'],
				'link' => '<a href="' . $scripturl . '?action=dlattach;ticket=' . $context['ticket_id'] . '.0;attach=' . $row['id_attach'] . '">' . htmlspecialchars($row['filename']) . '</a>',
			);
	}

	$smcFunc['db_free_result']($query);
}
?>