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
# File Info: SimpleDesk-Display.php / 2.0 Anatidae            #
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

	loadTemplate('sd_template/SimpleDesk-Display');
	$context['template_layers'][] = 'shd_display_nojs';

	$ticketinfo = shd_load_ticket();

	// How much are we sticking on each page?
	$context['messages_per_page'] = empty($modSettings['disableCustomPerPage']) && !empty($options['messages_per_page']) && !WIRELESS ? $options['messages_per_page'] : $modSettings['defaultMaxMessages'];

	censorText($ticketinfo['subject']);
	censorText($ticketinfo['body']);

	$context['user_list'] = array(); // as we go along, build a list of users who are relevant

	$context['ticket'] = array(
		'id' => $context['ticket_id'],
		'dept' => $ticketinfo['dept'],
		'dept_name' => $ticketinfo['dept_name'],
		'display_id' => str_pad($context['ticket_id'], $modSettings['shd_zerofill'], '0', STR_PAD_LEFT),
		'subject' => $ticketinfo['subject'],
		'first_msg' => $ticketinfo['id_first_msg'],
		'body' => shd_format_text($ticketinfo['body'], $ticketinfo['smileys_enabled'], 'shd_reply_' . $ticketinfo['id_first_msg']),
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
			'can_change' => shd_allowed_to('shd_alter_privacy_any', $ticketinfo['dept']) || (shd_allowed_to('shd_alter_privacy_own', $ticketinfo['dept']) && $ticketinfo['id_member'] == $user_info['id']),
		),
		'closed' => $ticketinfo['closed'],
		'deleted' => $ticketinfo['deleted'],
	);

	// Fix the departmental link since we know we're inside a department now.
	if ($context['shd_multi_dept'])
	{
		$context['shd_department'] = $context['ticket']['dept'];
		$context['shd_dept_link'] = ';dept=' . $context['ticket']['dept'];
	}

	// IP address next
	$context['link_ip_address'] = allowedTo('moderate_forum'); // for trackip access
	if (shd_allowed_to('shd_view_ip_any', $context['ticket']['dept']) || ($context['ticket']['ticket_opener'] && shd_allowed_to('shd_view_ip_own', $context['ticket']['dept'])))
		$context['ticket']['ip_address'] = $context['link_ip_address'] ? ('<a href="' . $scripturl . '?action=trackip;searchip=' . $ticketinfo['starter_ip'] . '">' . $ticketinfo['starter_ip'] . '</a>') : $ticketinfo['starter_ip'];

	// Stuff concerning whether the ticket is deleted or not
	// Display recycling stuff if: ticket is deleted (if we can see it, we can see the bin) OR ticket has deleted replies and we can see the bin and we requested to see them
	$context['ticket']['display_recycle_replies'] = true;
	if ($context['ticket']['deleted'])
		$context['ticket']['display_recycle'] = $txt['shd_ticket_has_been_deleted'];
	elseif ($context['ticket']['deleted_replies'] > 0)
	{
		if (shd_allowed_to('shd_access_recyclebin', $context['ticket']['dept']))
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
		$context['display_private'] = shd_allowed_to('shd_view_ticket_private_any', $context['ticket']['dept']) || shd_allowed_to(array('shd_alter_privacy_own', 'shd_alter_privacy_any'), $context['ticket']['dept']) || $ticketinfo['private'];
	else
		$context['display_private'] = true;

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

	$context['ticket']['urgency'] += shd_can_alter_urgency($ticketinfo['urgency'], $ticketinfo['starter_id'], $ticketinfo['closed'], $ticketinfo['deleted'], $context['ticket']['dept']);
	$context['total_visible_posts'] = empty($context['display_recycle']) ? $context['ticket']['num_replies'] : (int) $context['ticket']['num_replies'] + (int) $context['ticket']['deleted_replies'];

	// OK, before we go crazy, we might need to alter the ticket start. If we're in descending order (non default), we need to reverse it.
	if (!empty($context['shd_preferences']['display_order']) && $context['shd_preferences']['display_order'] == 'desc')
	{
		if (empty($context['ticket_start_natural']))
			$context['ticket_start_from'] = $context['total_visible_posts'] - (empty($context['ticket_start']) ? $context['total_visible_posts'] : $context['ticket_start']);
		else
			$context['ticket_start_from'] = $context['ticket_start'];
		$context['ticket_sort'] = 'DESC';
	}
	else
	{
		$context['ticket_start_from'] = $context['ticket_start'];
		$context['ticket_sort'] = 'ASC';
	}

	$context['page_index'] = shd_no_expand_pageindex($scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . '.%1$d' . (isset($_REQUEST['recycle']) ? ';recycle' : '') . '#replies', $context['ticket_start_from'], $context['total_visible_posts'], $context['messages_per_page'], true);

	$context['get_replies'] = 'shd_prepare_ticket_context';

	$query = shd_db_query('', '
		SELECT id_msg, id_member, modified_member
		FROM {db_prefix}helpdesk_ticket_replies
		WHERE id_ticket = {int:ticket}
			AND id_msg > {int:first_msg}' . (!empty($context['ticket']['display_recycle_replies']) ? '' : '
			AND message_status = {int:msg_status}') . '
		ORDER BY id_msg {raw:sort}' . ($context['messages_per_page'] == -1 ? '' : '
		LIMIT ' . $context['ticket_start_from'] . ', ' . $context['messages_per_page']),
		array(
			'ticket' => $context['ticket_id'],
			'first_msg' => $ticketinfo['id_first_msg'],
			'msg_status' => MSG_STATUS_NORMAL,
			'sort' => $context['ticket_sort'],
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

	$context['shd_is_staff'] = array();
	// Get the poster data
	if (!empty($posters))
	{
		loadMemberData($posters);

		// Are they current team members?
		$team = array_intersect($posters, shd_members_allowed_to('shd_staff'));

		foreach ($team as $member)
			$context['shd_is_staff'][$member] = true;
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
			ORDER BY id_msg {raw:sort}',
			array(
				'message_list' => $context['ticket_messages'],
				'msg_normal' => array(MSG_STATUS_NORMAL),
				'sort' => $context['ticket_sort'],
			)
		);
	}
	else
	{
		$reply_request = false;
		$context['first_message'] = 0;
		$context['first_new_message'] = false;
	}

	// Load all the custom fields
	// First, get all the values that could apply to the current context. We'll deal with what's active/inactive and where it all goes shortly.
	$query = shd_db_query('', '
		SELECT cfv.id_post, cfv.id_field, cfv.value, cfv.post_type
		FROM {db_prefix}helpdesk_custom_fields_values AS cfv
		WHERE (cfv.id_post = {int:ticket} AND cfv.post_type = 1)' . (!empty($context['ticket_messages']) ? '
			OR (cfv.id_post IN ({array_int:msgs}) AND cfv.post_type = 2)' : ''),
		array(
			'ticket' => $context['ticket_id'],
			'msgs' => $context['ticket_messages'],
		)
	);
	$field_values = array();
	while($row = $smcFunc['db_fetch_assoc']($query))
		$field_values[$row['post_type'] == CFIELD_TICKET ? 'ticket' : $row['id_post']][$row['id_field']] = $row;
	$smcFunc['db_free_result']($query);

	// Set up the storage.
	$context['custom_fields_replies'] = array();
	$context['ticket']['custom_fields'] = array(
		'details' => array(),
		'information' => array(),
		'prefix' => array(),
		'prefixfilter' => array(),
	);
	$context['ticket_form']['custom_fields_context'] = 'reply';
	$context['ticket_form']['custom_fields'] = array();

	$query = shd_db_query('', '
		SELECT cf.id_field, cf.active, cf.field_order, cf.field_name, cf.field_desc, cf.field_loc, cf.icon,
			cf.field_type, cf.default_value, cf.bbc, cf.can_see, cf.can_edit, cf.field_length,
			cf.field_options, cf.display_empty, cfd.required, cf.placement
		FROM {db_prefix}helpdesk_custom_fields AS cf
			INNER JOIN {db_prefix}helpdesk_custom_fields_depts AS cfd ON (cf.id_field = cfd.id_field AND cfd.id_dept = {int:dept})
		WHERE cf.active = 1
		ORDER BY cf.field_order',
		array(
			'dept' => $context['ticket']['dept'],
		)
	);

	// Loop through all fields and figure out where they should be.
	$is_staff = shd_allowed_to('shd_staff', $context['ticket']['dept']);
	$is_admin = shd_allowed_to('admin_helpdesk', $context['ticket']['dept']); // this includes forum admins
	$placements = array(
		CFIELD_PLACE_DETAILS => 'details',
		CFIELD_PLACE_INFO => 'information',
		CFIELD_PLACE_PREFIX => 'prefix',
		CFIELD_PLACE_PREFIXFILTER => 'prefixfilter',
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		list($user_see, $staff_see) = explode(',', $row['can_see']);
		list($user_edit, $staff_edit) = explode(',', $row['can_edit']);
		if ($is_admin)
			$editable = true;
		elseif ($is_staff)
		{
			if ($staff_see == 0)
				continue;
			$editable = $staff_edit == 1;
		}
		elseif ($user_see == 1)
			$editable = $user_edit == 1;
		else
			continue;

		// If this is going to be displayed for the individual ticket, we need to figure out where it should go.
		if ($row['field_loc'] & CFIELD_TICKET)
			$pos = $placements[$row['placement']];

		$field = array(
			'id' => $row['id_field'],
			'name' => $row['field_name'],
			'desc' => parse_bbc($row['field_desc'], false),
			'icon' => $row['icon'],
			'type' => $row['field_type'],
			'default_value' => $row['field_type'] == CFIELD_TYPE_LARGETEXT ? explode(',', $row['default_value']) : $row['default_value'],
			'options' => !empty($row['field_options']) ? unserialize($row['field_options']) : array(),
			'display_empty' => !empty($row['required']) ? true : !empty($row['display_empty']), // Required and "selection" fields will always be displayed.
			'bbc' => !empty($row['bbc']) && ($row['field_type'] == CFIELD_TYPE_TEXT || $row['field_type'] == CFIELD_TYPE_LARGETEXT) && $row['placement'] != CFIELD_PLACE_PREFIX,
			'editable' => !empty($editable),
		);
		if (!empty($field['options']) && empty($field['options']['inactive']))
			$field['options']['inactive'] = array();

		if (in_array($field['type'], array(CFIELD_TYPE_RADIO, CFIELD_TYPE_SELECT, CFIELD_TYPE_MULTI)))
		{
			foreach ($field['options'] as $k => $v)
				if ($k != 'inactive' && strpos($v, '[') !== false)
					$field['options'][$k] = parse_bbc($v, false);
		}

		if (($row['field_loc'] & CFIELD_REPLY) && $field['editable'])
			$context['ticket_form']['custom_fields']['reply'][$field['id']] = $field;

		// Add fields to the master list, getting any values as we go.
		if (($row['field_loc'] & CFIELD_TICKET) && ((!empty($field_values['ticket'][$row['id_field']]['post_type']) && ($field_values['ticket'][$row['id_field']]['post_type'] == CFIELD_TICKET)) || $field['display_empty']))
		{
			if (isset($field_values['ticket'][$row['id_field']]))
				$field['value'] = $field['bbc'] ? shd_format_text($field_values['ticket'][$row['id_field']]['value']) : $field_values['ticket'][$row['id_field']]['value'];

			$context['ticket']['custom_fields'][$pos][$row['id_field']]	= $field;
		}

		if ($row['field_loc'] & CFIELD_REPLY)
		{
			foreach ($field_values as $dest => $field_details)
			{
				unset($field['value']);
				if ($dest == 'ticket' || !isset($field_details[$row['id_field']]) || $field_details[$row['id_field']]['post_type'] != CFIELD_REPLY)
					continue;
				$field['value'] = $field['bbc'] ? shd_format_text($field_details[$row['id_field']]['value']) : $field_details[$row['id_field']]['value'];

				$context['custom_fields_replies'][$dest][$row['id_field']] = $field;
			}

			// We also need to attach the field to replies didn't get the field added, in the event that the field should be displayed by default.
			if ($field['display_empty'])
			{
				foreach ($context['ticket_messages'] as $msg)
				{
					if (!isset($context['custom_fields_replies'][$msg][$row['id_field']]))
						$context['custom_fields_replies'][$msg][$row['id_field']] = $field;
				}
			}
		}
	}
	$smcFunc['db_free_result']($query);

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

	// Template stuff
	$context['sub_template'] = 'viewticket';
	$ticketname = '';
	if (!empty($context['ticket']['custom_fields']['prefix']))
	{
		$ticketname = '[' . $context['ticket']['display_id'] . '] ';
		$fields = '';
		foreach ($context['ticket']['custom_fields']['prefix'] AS $field)
		{
			if (empty($field['value']))
				continue;

			if ($field['type'] == CFIELD_TYPE_CHECKBOX)
				$fields .= !empty($field['value']) ? $txt['yes'] . ' ' : $txt['no'] . ' ';
			elseif ($field['type'] == CFIELD_TYPE_SELECT || $field['type'] == CFIELD_TYPE_RADIO)
				$fields .= trim(strip_tags($field['options'][$field['value']])) . ' ';
			elseif ($field['type'] == CFIELD_TYPE_MULTI)
			{
				$values = explode(',', $field['value']);
				foreach ($values as $value)
					$fields .= trim(strip_tags($field['options'][$value])) . ' ';
			}
			else
				$fields .= $field['value'] . ' ';
		}
		$fields = trim($fields);
		$ticketname .= (!empty($fields) ? '[' . trim($fields) . '] ' : '') . $context['ticket']['subject'];
	}
	else
		$ticketname = '[' . $context['ticket']['display_id'] . '] ' . $context['ticket']['subject'];

	$context['page_title'] = $txt['shd_helpdesk'] . ' ' . $ticketname;

	// If we're in a department, display that.
	if ($context['shd_multi_dept'])
		$context['linktree'][] = array(
			'url' => $scripturl . '?' . $context['shd_home'] . $context['shd_dept_link'],
			'name' => $context['ticket']['dept_name'],
		);

	// Build the link tree. If the ticket is recycled, display 'Recycle bin'.
	if ($context['ticket']['status']['level'] == TICKET_STATUS_DELETED)
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=recyclebin' . $context['shd_dept_link'],
			'name' => $txt['shd_recycle_bin'],
		);
	// If it's closed, add that to the linktree.
	elseif ($context['ticket']['status']['level'] == TICKET_STATUS_CLOSED)
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=closedtickets' . $context['shd_dept_link'],
			'name' => $txt['shd_tickets_closed'],
		);

	// Lastly add the ticket name and link to the linktree.
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'],
		'name' => $ticketname,
	);

	// Ticket navigation / permission
	$context['can_move_dept'] = !empty($context['shd_multi_dept']) && (shd_allowed_to('shd_move_dept_any', $context['ticket']['dept']) || ($context['ticket']['ticket_opener'] && shd_allowed_to('shd_move_dept_own', $context['ticket']['dept'])));
	$context['can_reply'] = !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_reply_ticket_any', $context['ticket']['dept']) || ($context['ticket']['ticket_opener'] && shd_allowed_to('shd_reply_ticket_own', $context['ticket']['dept']))); // needs perms - calc'd here because we use it in display template too
	$context['can_quote'] = $context['can_reply'] && !empty($modSettings['shd_allow_ticket_bbc']);
	$context['can_go_advanced'] = !empty($modSettings['shd_allow_ticket_bbc']) || !empty($modSettings['allow_ticket_smileys']) || shd_allowed_to('shd_post_attachment', $context['ticket']['dept']);
	$context['shd_can_move_to_topic'] = empty($modSettings['shd_disable_tickettotopic']) && shd_allowed_to('shd_ticket_to_topic', $context['ticket']['dept']) && empty($modSettings['shd_helpdesk_only']);
	$context['can_solve'] = !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_resolve_ticket_any', $context['ticket']['dept']) || (shd_allowed_to('shd_resolve_ticket_own', $context['ticket']['dept']) && $context['ticket']['ticket_opener']));
	$context['can_unsolve'] = $context['ticket']['closed'] && (shd_allowed_to('shd_unresolve_ticket_any', $context['ticket']['dept']) || (shd_allowed_to('shd_unresolve_ticket_own', $context['ticket']['dept']) && $context['ticket']['ticket_opener']));

	// And off we go
	$context['ticket_navigation'] = array();
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=editticket;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'edit',
		'alt' => '*',
		'display' => !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_edit_ticket_any', $context['ticket']['dept']) || ($context['ticket']['ticket_opener'] && shd_allowed_to('shd_edit_ticket_own', $context['ticket']['dept']))),
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
		'icon' => 'resolved',
		'alt' => '*',
		'display' => $context['can_solve'],
		'text' => 'shd_ticket_resolved',
	);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=resolveticket;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'unresolved',
		'alt' => '*',
		'display' => $context['can_unsolve'],
		'text' => 'shd_ticket_unresolved',
	);

	// This is always going to be a pain. But it should be possible to contextualise it nicely.
	// And while this isn't quite as nicely formatted as a single nice array definition,
	// imagine trying to debug the display and text options later if it were done with nested ternaries... *shudder*
	$context['ajax_assign'] = false;
	$assign_nav = array(
		'url' => $scripturl . '?action=helpdesk;sa=assign;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'assign',
		'alt' => '*',
		'text' => '',
		'display' => false,
	);
	if (shd_allowed_to('shd_assign_ticket_any', $context['ticket']['dept']))
	{
		$assign_nav['display'] = shd_allowed_to('shd_staff', $context['ticket']['dept']) && !$context['ticket']['closed'] && !$context['ticket']['deleted'];
		$assign_nav['text'] = empty($context['ticket']['id_member_assigned']) ? 'shd_ticket_assign' : 'shd_ticket_reassign';
		$context['ajax_assign'] = $assign_nav['display'];
	}
	elseif (shd_allowed_to('shd_assign_ticket_own', $context['ticket']['dept']))
	{
		$assign_nav['display'] = !$context['ticket']['closed'] && !$context['ticket']['deleted'] && shd_allowed_to('shd_staff', $context['ticket']['dept']) && (empty($context['ticket']['id_member_assigned']) || $context['ticket']['assigned_self']); // either not assigned or assigned to self
		$assign_nav['text'] = $context['ticket']['assigned_self'] ? 'shd_ticket_unassign' : 'shd_ticket_assign_self';
	}

	$context['ticket_navigation'][] = $assign_nav;

	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=deleteticket;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'delete',
		'alt' => '*',
		'display' => !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_delete_ticket_any', $context['ticket']['dept']) || (shd_allowed_to('shd_delete_ticket_own', $context['ticket']['dept']) && $context['ticket']['ticket_opener'])),
		'text' => 'shd_ticket_delete',
		'onclick' => 'return confirm(' . JavaScriptEscape($txt['shd_delete_confirm']) . ');',
	);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=restoreticket;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'restore',
		'alt' => '*',
		'display' => $context['ticket']['deleted'] && (shd_allowed_to('shd_restore_ticket_any', $context['ticket']['dept']) || (shd_allowed_to('shd_restore_ticket_own', $context['ticket']['dept']) && $context['ticket']['ticket_opener'])),
		'text' => 'shd_ticket_restore',
	);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=permadelete;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'delete',
		'alt' => '*',
		'display' => $context['ticket']['deleted'] && shd_allowed_to('shd_delete_recycling', $context['ticket']['dept']),
		'text' => 'shd_delete_permanently',
		'onclick' => 'return confirm(' . JavaScriptEscape($txt['shd_delete_permanently_confirm']) . ');',
	);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=movedept;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'movedept',
		'alt' => '*',
		'display' => $context['can_move_dept'],
		'text' => 'shd_move_dept',
	);
	$context['ticket_navigation'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=tickettotopic;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'],
		'icon' => 'tickettotopic',
		'alt' => '*',
		'display' => $context['shd_can_move_to_topic'] && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && ($context['ticket']['deleted_replies'] == 0 || shd_allowed_to('shd_access_recyclebin', $context['ticket']['dept'])),
		'text' => 'shd_ticket_move_to_topic',
	);

	// While we're at it, set up general navigation for this ticket. We'll sort out access to the action log later.
	$context['navigation']['replies'] = array(
		'text' => 'shd_go_to_replies',
		'lang' => true,
		'url' => '#replies',
	);
	$context['navigation']['ticketlog'] = array(
		'text' => 'shd_go_to_action_log',
		'test' => 'display_ticket_log',
		'lang' => true,
		'url' => '#ticket_log_header',
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

	// Quick reply stuffs
	require_once($sourcedir . '/sd_source/SimpleDesk-Post.php');
	require_once($sourcedir . '/Subs-Editor.php');
	loadTemplate('sd_template/SimpleDesk-Post');

	$context['ticket_form']['ticket'] = $context['ticket_id'];
	$context['ticket_form']['num_allowed_attachments'] = empty($modSettings['attachmentNumPerPostLimit']) || $modSettings['shd_attachments_mode'] == 'ticket' ? -1 : $modSettings['attachmentNumPerPostLimit'];
	$context['ticket_form']['do_attach'] = shd_allowed_to('shd_post_attachment', $context['ticket']['dept']);
	$context['ticket_form']['num_replies'] = $context['ticket']['num_replies'];
	$context['ticket_form']['disable_smileys'] = empty($modSettings['shd_allow_ticket_smileys']);
	shd_posting_additional_options();
	if ($context['can_reply'])
		shd_load_canned_replies();

	$context['can_ping'] = $context['can_reply'] && shd_allowed_to('shd_singleton_email', $context['ticket']['dept']);

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

	$context['html_headers'] .= '
	var oCustomFields = new CustomFields({
		sImagesUrl: "' . $settings['images_url'] . '",
		sContainerId: "additional_info",
		sImageId: "shd_custom_fields_swap",
		sImageCollapsed: "collapse.gif",
		sImageExpanded: "expand.gif",
		sHeaderId: "additionalinfoheader",
		sFooterId: "additional_info_footer",
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

	// Should we load and display this ticket's action log?
	$context['display_ticket_log'] = !empty($modSettings['shd_display_ticket_logs']) && (shd_allowed_to('shd_view_ticket_logs_any', $context['ticket']['dept']) || (shd_allowed_to('shd_view_ticket_logs_own', $context['ticket']['dept']) && $context['ticket']['ticket_opener']));

	// If yes, go ahead and load the log entries (Re-using a couple of functions from the ACP)
	if (!empty($context['display_ticket_log']))
	{
		require_once($sourcedir . '/sd_source/Subs-SimpleDeskAdmin.php');
		$context['ticket_log'] = shd_load_action_log_entries(0, 10, '', '', 'la.id_ticket = ' . $context['ticket_id']);
		$context['ticket_log_count'] = shd_count_action_log_entries('la.id_ticket = ' . $context['ticket_id']);
		$context['ticket_full_log'] = allowedTo('admin_forum') || shd_allowed_to('admin_helpdesk', 0);
	}

	// What about related tickets?
	$context['create_relationships'] = shd_allowed_to('shd_create_relationships', $context['ticket']['dept']);
	$context['display_relationships'] = ((shd_allowed_to('shd_view_relationships', $context['ticket']['dept']) || $context['create_relationships']) && empty($modSettings['shd_disable_relationships']));
	$context['delete_relationships'] = shd_allowed_to('shd_delete_relationships', $context['ticket']['dept']);
	if (!empty($context['display_relationships']))
	{
		shd_load_relationships($context['ticket_id']);
		if ($context['relationships_count'] == 0 && empty($context['create_relationships']))
			$context['display_relationships'] = false;
	}

	// And, of course, notifications. If we can see the ticket, we can do something with notifications.
	$context['display_notifications'] = array(
		'show' => false,
		'preferences' => array(),
		'can_change' => shd_allowed_to('shd_view_profile', 0) && shd_allowed_to('shd_view_preferences', 0), // not department related
		'can_monitor' => shd_allowed_to('shd_monitor_ticket_any', $context['ticket']['dept']) || ($context['ticket']['ticket_opener'] && shd_allowed_to('shd_monitor_ticket_own', $context['ticket']['dept'])),
		'is_monitoring' => false,
		'can_ignore' => shd_allowed_to('shd_ignore_ticket_any', $context['ticket']['dept']) || ($context['ticket']['ticket_opener'] && shd_allowed_to('shd_ignore_ticket_own', $context['ticket']['dept'])),
		'is_ignoring' => false,
	);
	$notify_state = NOTIFY_PREFS;
	$query = $smcFunc['db_query']('', '
		SELECT notify_state
		FROM {db_prefix}helpdesk_notify_override
		WHERE id_member = {int:user}
			AND id_ticket = {int:ticket}',
		array(
			'user' => $context['user']['id'],
			'ticket' => $context['ticket_id'],
		)
	);
	if ($smcFunc['db_num_rows']($query) != 0)
		list($notify_state) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	$context['display_notifications']['is_monitoring'] = $notify_state == NOTIFY_ALWAYS;
	$context['display_notifications']['is_ignoring'] = $notify_state == NOTIFY_NEVER;

	if ($notify_state != NOTIFY_NEVER)
	{
		if ($context['ticket']['ticket_opener'] && !empty($context['shd_preferences']['notify_new_reply_own']))
			$context['display_notifications']['preferences'][] = 'yourticket';
		if ($context['ticket']['assigned_self'] && !empty($context['shd_preferences']['notify_new_reply_assigned']))
			$context['display_notifications']['preferences'][] = 'assignedyou';
		if (!empty($context['shd_preferences']['notify_new_reply_previous']))
		{
			// We need to query to see if we've replied here before - but we don't need to check ticket access.
			$query = $smcFunc['db_query']('', '
				SELECT COUNT(hdtr.id_msg)
				FROM {db_prefix}helpdesk_tickets AS hdt
					INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdt.id_ticket = hdtr.id_ticket)
				WHERE hdt.id_ticket = {int:ticket}
					AND hdtr.id_member = {int:user}
					AND hdtr.id_msg != hdt.id_first_msg',
				array(
					'ticket' => $context['ticket_id'],
					'user' => $context['user']['id'],
				)
			);
			list($count) = $smcFunc['db_fetch_row']($query);
			$smcFunc['db_free_result']($query);
			if (!empty($count))
				$context['display_notifications']['preferences'][] = 'priorreply';
		}
		if (!empty($context['shd_preferences']['notify_new_reply_any']))
			$context['display_notifications']['preferences'][] = 'anyreply';
	}

	if (!empty($context['display_notifications']['preferences']) || $context['display_notifications']['can_monitor'] || $context['display_notifications']['can_ignore'])
		$context['display_notifications']['show'] = true;
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
 *		<li>is_staff: boolean value of whether the posting member is currently helpdesk staff</li>
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
		'is_staff' => !empty($context['shd_is_staff'][$message['id_member']]),
		'can_edit' => $message['message_status'] != MSG_STATUS_DELETED && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_edit_reply_any', $context['ticket']['dept']) || ($message['id_member'] == $user_info['id'] && shd_allowed_to('shd_edit_reply_own', $context['ticket']['dept']))),
		'can_delete' => $message['message_status'] != MSG_STATUS_DELETED && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_delete_reply_any', $context['ticket']['dept']) || ($message['id_member'] == $user_info['id'] && shd_allowed_to('shd_delete_reply_own', $context['ticket']['dept']))),
		'can_restore' => $message['message_status'] == MSG_STATUS_DELETED && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && (shd_allowed_to('shd_restore_reply_any', $context['ticket']['dept']) || ($message['id_member'] == $user_info['id'] && shd_allowed_to('shd_restore_reply_own', $context['ticket']['dept']))),
		'can_permadelete' => $message['message_status'] == MSG_STATUS_DELETED && !$context['ticket']['closed'] && !$context['ticket']['deleted'] && shd_allowed_to('shd_delete_recycling', $context['ticket']['dept']),
		'message_status' => $message['message_status'],
		'link' => $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . '.msg' . $message['id_msg'] . '#msg' . $message['id_msg'],
	);

	if (shd_allowed_to('shd_view_ip_any', $context['ticket']['dept']) || ($message['id_member'] == $user_info['id'] && shd_allowed_to('shd_view_ip_own', $context['ticket']['dept'])))
		$output['ip_address'] = $context['link_ip_address'] ? ('<a href="' . $scripturl . '?action=trackip;searchip=' . $message['poster_ip'] . '">' . $message['poster_ip'] . '</a>') : $message['poster_ip'];

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

	if (!empty($context['ticket_start_newfrom']) && $context['ticket_start_newfrom'] == $message['id_msg'])
		$output['is_new'] = true;

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
 *	- link: full HTML "a" element linking to the attachment, using the filename as the link text and (since 1.1) with icon img element
 *	@since 1.0
*/
function shd_display_load_attachments()
{
	global $modSettings, $context, $smcFunc, $scripturl, $txt;

	$context['ticket_attach'][$modSettings['shd_attachments_mode']] = array();

	if (!shd_allowed_to('shd_view_attachment', $context['ticket']['dept']))
		return;

	if ($modSettings['shd_attachments_mode'] == 'ticket')
	{
		$query = shd_db_query('', '
			SELECT hda.id_attach, hda.id_msg, hda.id_ticket, a.filename, a.id_folder, a.file_hash, IFNULL(a.size, 0) AS filesize,
				a.width, a.height' . (empty($modSettings['attachmentShowImages']) || empty($modSettings['attachmentThumbnails']) ? '' : ',
				IFNULL(thumb.id_attach, 0) AS id_thumb, thumb.width AS thumb_width, thumb.height AS thumb_height') . '
			FROM {db_prefix}helpdesk_attachments AS hda
				INNER JOIN {db_prefix}attachments AS a ON (hda.id_attach = a.id_attach)' . (empty($modSettings['attachmentShowImages']) || empty($modSettings['attachmentThumbnails']) ? '' : '
				LEFT JOIN {db_prefix}attachments AS thumb ON (thumb.id_attach = a.id_thumb)') . '
			WHERE hda.id_ticket = {int:ticket}
				AND a.attachment_type = {int:attachment_type}
			ORDER BY hda.id_attach',
			array(
				'ticket' => $context['ticket_id'],
				'attachment_type' => 0,
			)
		);

		// Ticket ones can just be added on, they're nice and straightforward
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$context['ticket_attach'][$modSettings['shd_attachments_mode']][$row['id_attach']] = shd_attachment_info($row);

		if (empty($context['ticket_attach'][$modSettings['shd_attachments_mode']]))
			$context['ticket_attach'][$modSettings['shd_attachments_mode']] = array();

		ksort($context['ticket_attach'][$modSettings['shd_attachments_mode']]);
	}
	else
	{
		if (empty($context['ticket_messages']))
			return;

		$query = shd_db_query('', '
			SELECT hda.id_attach, hda.id_msg, hda.id_ticket, a.filename, a.id_folder, a.file_hash, IFNULL(a.size, 0) AS filesize,
				a.width, a.height' . (empty($modSettings['attachmentShowImages']) || empty($modSettings['attachmentThumbnails']) ? '' : ',
				IFNULL(thumb.id_attach, 0) AS id_thumb, thumb.width AS thumb_width, thumb.height AS thumb_height') . '
			FROM {db_prefix}helpdesk_attachments AS hda
				INNER JOIN {db_prefix}attachments AS a ON (hda.id_attach = a.id_attach)' . (empty($modSettings['attachmentShowImages']) || empty($modSettings['attachmentThumbnails']) ? '' : '
				LEFT JOIN {db_prefix}attachments AS thumb ON (thumb.id_attach = a.id_thumb)') . '
			WHERE hda.id_msg IN ({array_int:msg})
				AND a.attachment_type = {int:attachment_type}
			ORDER BY hda.id_attach',
			array(
				'msg' => $context['ticket_messages'],
				'attachment_type' => 0,
			)
		);

		// Message ones are a little trickier since we actually need to tie them to msg ids
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$context['ticket_attach'][$modSettings['shd_attachments_mode']][$row['id_msg']][$row['id_attach']] = shd_attachment_info($row);

		foreach ($context['ticket_attach'][$modSettings['shd_attachments_mode']] as $msg => $attachments)
		{
			if (empty($context['ticket_attach'][$modSettings['shd_attachments_mode']][$msg]))
				$context['ticket_attach'][$modSettings['shd_attachments_mode']][$msg] = array();

			ksort($context['ticket_attach'][$modSettings['shd_attachments_mode']][$msg]);
		}
	}

	$smcFunc['db_free_result']($query);
}

function shd_attachment_info($attach_info)
{
	global $scripturl, $context, $modSettings, $txt, $sourcedir, $smcFunc;

	$filename = preg_replace('~&amp;#(\\d{1,7}|x[0-9a-fA-F]{1,6});~', '&#\\1;', htmlspecialchars($attach_info['filename']));
	$deleteable = shd_allowed_to('shd_delete_attachment', $context['ticket']['dept']);

	$attach = array(
		'id' => $attach_info['id_attach'],
		'name' => $filename,
		'size' => round($attach_info['filesize'] / 1024, 2) . ' ' . $txt['kilobyte'],
		'byte_size' => $attach_info['filesize'],
		'href' => $scripturl . '?action=dlattach;ticket=' . $context['ticket_id'] . '.0;attach=' . $attach_info['id_attach'],
		'link' => shd_attach_icon($filename) . '&nbsp;<a href="' . $scripturl . '?action=dlattach;ticket=' . $context['ticket_id'] . '.0;attach=' . $attach_info['id_attach'] . '">' . htmlspecialchars($attach_info['filename']) . '</a>',
		'is_image' => !empty($modSettings['attachmentShowImages']) && !empty($attach_info['width']) && !empty($attach_info['height']),
		'can_delete' => $deleteable,
	);

	if ($attach['is_image'])
	{
		$attach += array(
			'real_width' => $attach_info['width'],
			'width' => $attach_info['width'],
			'real_height' => $attach_info['height'],
			'height' => $attach_info['height'],
		);

		// Let's see, do we want thumbs?
		if (!empty($modSettings['attachmentThumbnails']) && !empty($modSettings['attachmentThumbWidth']) && !empty($modSettings['attachmentThumbHeight']) && ($attach_info['width'] > $modSettings['attachmentThumbWidth'] || $attach_info['height'] > $modSettings['attachmentThumbHeight']) && strlen($attach_info['filename']) < 249)
		{
			// A proper thumb doesn't exist yet? Create one!
			if (empty($attach_info['id_thumb']) || $attach_info['thumb_width'] > $modSettings['attachmentThumbWidth'] || $attach_info['thumb_height'] > $modSettings['attachmentThumbHeight'] || ($attach_info['thumb_width'] < $modSettings['attachmentThumbWidth'] && $attach_info['thumb_height'] < $modSettings['attachmentThumbHeight']))
			{
				$filename = getAttachmentFilename($attach_info['filename'], $attach_info['id_attach'], $attach_info['id_folder']);

				require_once($sourcedir . '/Subs-Graphics.php');
				if (createThumbnail($filename, $modSettings['attachmentThumbWidth'], $modSettings['attachmentThumbHeight']))
				{
					// So what folder are we putting this image in?
					if (!empty($modSettings['currentAttachmentUploadDir']))
					{
						if (!is_array($modSettings['attachmentUploadDir']))
							$modSettings['attachmentUploadDir'] = @unserialize($modSettings['attachmentUploadDir']);
						$path = $modSettings['attachmentUploadDir'][$modSettings['currentAttachmentUploadDir']];
						$id_folder_thumb = $modSettings['currentAttachmentUploadDir'];
					}
					else
					{
						$path = $modSettings['attachmentUploadDir'];
						$id_folder_thumb = 1;
					}

					// Calculate the size of the created thumbnail.
					$size = @getimagesize($filename . '_thumb');
					list ($attach_info['thumb_width'], $attach_info['thumb_height']) = $size;
					$thumb_size = filesize($filename . '_thumb');

					// These are the only valid image types for SMF.
					$validImageTypes = array(1 => 'gif', 2 => 'jpeg', 3 => 'png', 5 => 'psd', 6 => 'bmp', 7 => 'tiff', 8 => 'tiff', 9 => 'jpeg', 14 => 'iff');

					// What about the extension?
					$thumb_ext = isset($validImageTypes[$size[2]]) ? $validImageTypes[$size[2]] : '';

					// Figure out the mime type.
					if (!empty($size['mime']))
						$thumb_mime = $size['mime'];
					else
						$thumb_mime = 'image/' . $thumb_ext;

					$thumb_filename = $attach_info['filename'] . '_thumb';
					$thumb_hash = getAttachmentFilename($thumb_filename, false, null, true);

					// Add this beauty to the database.
					$smcFunc['db_insert']('',
						'{db_prefix}attachments',
						array('id_folder' => 'int', 'id_msg' => 'int', 'attachment_type' => 'int', 'filename' => 'string', 'file_hash' => 'string', 'size' => 'int', 'width' => 'int', 'height' => 'int', 'fileext' => 'string', 'mime_type' => 'string'),
						array($id_folder_thumb, 0, 3, $thumb_filename, $thumb_hash, (int) $thumb_size, (int) $attach_info['thumb_width'], (int) $attach_info['thumb_height'], $thumb_ext, $thumb_mime),
						array('id_attach')
					);
					$old_id_thumb = $attach_info['id_thumb'];
					$attach_info['id_thumb'] = $smcFunc['db_insert_id']('{db_prefix}attachments', 'id_attach');
					if (!empty($attach_info['id_thumb']))
					{
						// Update the tables to notify that we has us a thumbnail
						$smcFunc['db_query']('', '
							UPDATE {db_prefix}attachments
							SET id_thumb = {int:id_thumb}
							WHERE id_attach = {int:id_attach}',
							array(
								'id_thumb' => $attach_info['id_thumb'],
								'id_attach' => $attach_info['id_attach'],
							)
						);

						$smcFunc['db_insert']('replace',
							'{db_prefix}helpdesk_attachments',
							array('id_attach' => 'int', 'id_ticket' => 'int', 'id_msg' => 'int'),
							array($attach_info['id_thumb'], $attach_info['id_ticket'], $attach_info['id_msg']),
							array('id_attach')
						);

						$thumb_realname = getAttachmentFilename($thumb_filename, $attach_info['id_thumb'], $id_folder_thumb, false, $thumb_hash);
						rename($filename . '_thumb', $thumb_realname);

						// Do we need to remove an old thumbnail?
						if (!empty($old_id_thumb))
						{
							require_once($sourcedir . '/ManageAttachments.php');
							removeAttachments(array('id_attach' => $old_id_thumb), '', false, false);
						}
					}
				}
			}

			// Only adjust dimensions on successful thumbnail creation.
			if (!empty($attach_info['thumb_width']) && !empty($attach_info['thumb_height']))
			{
				$attach['width'] = $attach_info['thumb_width'];
				$attach['height'] = $attach_info['thumb_height'];
			}
		}

		if (!empty($attach_info['id_thumb']))
			$attach['thumbnail'] = array(
				'id' => $attach_info['id_thumb'],
				'href' => $scripturl . '?action=dlattach;ticket=' . $context['ticket_id'] . '.0;attach=' . $attach_info['id_thumb'] . ';image',
			);
		$attach['thumbnail']['has_thumb'] = !empty($attach_info['id_thumb']);

		// If thumbnails are disabled, check the maximum size of the image.
		if (!$attach['thumbnail']['has_thumb'] && ((!empty($modSettings['max_image_width']) && $attach_info['width'] > $modSettings['max_image_width']) || (!empty($modSettings['max_image_height']) && $attach_info['height'] > $modSettings['max_image_height'])))
		{
			if (!empty($modSettings['max_image_width']) && (empty($modSettings['max_image_height']) || $attach_info['height'] * $modSettings['max_image_width'] / $attach_info['width'] <= $modSettings['max_image_height']))
			{
				$attach['width'] = $modSettings['max_image_width'];
				$attach['height'] = floor($attach_info['height'] * $modSettings['max_image_width'] / $attach_info['width']);
			}
			elseif (!empty($modSettings['max_image_width']))
			{
				$attach['width'] = floor($attach['width'] * $modSettings['max_image_height'] / $attach['height']);
				$attach['height'] = $modSettings['max_image_height'];
			}
		}
		elseif ($attach['thumbnail']['has_thumb'])
			// Make it a popup (since invariably it'll break the layout otherwise)
			$attach['thumbnail']['javascript'] = 'return reqWin(\'' . $attach['href'] . ';image\', ' . ($attach_info['width'] + 20) . ', ' . ($attach_info['height'] + 20) . ', true);';
	}

	return $attach;
}

/**
 *	Returns the icon name to use given the filename, i.e. looks up icons from a list of known extensions.
 *
 *	@param string $filename The filename of an attachment.
 *
 *	@return string A full link to the image for this attachment.
 *	@see shd_display_load_attachments()
 *	@since 1.0
*/
function shd_attach_icon($filename)
{
	global $settings, $txt;
	static $extension_map = 0;

	// If adding to this list, please remember to update SimpleDesk.english.php with a description in $txt['shd_attachtype_' . $extension]
	if (empty($extension_map))
		$extension_map = array(
			// Archive formats
			'bz2' => 'zip.png',
			'gz' => 'zip.png',
			'rar' => 'zip.png',
			'zip' => 'zip.png',
			// Media: Audio formats
			'mp3' => 'audio.png',
			// Media: Image formats
			'bmp' => 'image.png',
			'gif' => 'image.png',
			'jpeg' => 'image.png',
			'jpg' => 'image.png',
			'png' => 'image.png',
			'svg' => 'vector.png',
			// Media: Video formats
			'wmv' => 'video.png',
			// Office formats
			'doc' => 'word.png',
			'mdb' => 'access.png',
			'ppt' => 'ppoint.png',
			'xls' => 'excel.png',
			// Programming languages
			'cpp' => 'cpp.png',
			'php' => 'php.png',
			'py' => 'python.png',
			'rb' => 'ruby.png',
			'sql' => 'sql.png',
			// Proprietory formats
			'kmz' => 'world.png',
			'pdf' => 'pdf.png',
			'psd' => 'psd.png',
			'swf' => 'flash.png',
			// Miscellaneous
			'exe' => 'app.png',
			'htm' => 'html.png',
			'html' => 'html.png',
			'rtf' => 'rtf.png',
			'txt' => 'text.png',
		);

	$filename = trim($filename);
	$extension = ($filename != '') ? strtolower(substr(strrchr($filename, '.'), 1)) : '';

	if (isset($extension_map[$extension]))
		$image = '<img src="' . $settings['default_images_url'] . '/simpledesk/attach/' . $extension_map[$extension] . '"' . (!empty($txt['shd_attachtype_' . $extension]) ? ' alt="' . $txt['shd_attachtype_' . $extension] . '" title="' . $txt['shd_attachtype_' . $extension] . '"' : ' alt=""') . ' />';
	else
		$image = '<img src="' . $settings['default_images_url'] . '/simpledesk/attach/blank.png" alt="" />';

	return $image;
}

/**
 *	Identifies the tickets related to a given ticket.
 *
 *	Queries the system for all tickets related to the specified (typically current) ticket, subject to current user's permissions, and populates $context.
 *
 *	The function populates $context['relationships_count'] with the number of relationships found, and $context['ticket_relationships'] contains an array of the following keys:
 *	- parent: Current ticket is the parent of the discovered ticket
 *	- child: Current ticket is a child of the discovered ticket
 *	- linked: Current ticket is related to discovered ticket
 *	- duplicated: Curent ticket is a duplicate of discovered ticket
 *
 *	Each of the keyed arrays is an indexed array (each index representing one ticket), of which those are hash arrays containing:
 *	- id: id of the ticket
 *	- display_id: zero padded display id of the ticket
 *	- subject: ticket's name
 *	- status: status of the discovered ticket (numeric)
 *	- status_txt: status of the discovered ticket (textual)
 *
 *	@since 2.0
*/
function shd_load_relationships($ticket = 0)
{
	global $context, $smcFunc, $txt, $modSettings;

	if ($ticket == 0)
		$ticket = $context['ticket_id'];

	$reltypes = array(
		RELATIONSHIP_ISPARENT => 'parent',
		RELATIONSHIP_ISCHILD => 'child',
		RELATIONSHIP_LINKED => 'linked',
		RELATIONSHIP_DUPLICATED => 'duplicated',
	);

	$context['relationships_count'] = 0;
	foreach ($reltypes as $type)
		$context['ticket_relationships'][$type] = array();

	$query = shd_db_query('', '
		SELECT hdt.id_ticket, hdt.subject, hdt.status, hdr.rel_type
		FROM {db_prefix}helpdesk_relationships AS hdr
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdr.secondary_ticket = hdt.id_ticket)
		WHERE hdr.primary_ticket = {int:ticket}
			AND {query_see_ticket}',
		array(
			'ticket' => $ticket,
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$context['relationships_count']++;
		$context['ticket_relationships'][$reltypes[$row['rel_type']]][] = array(
			'id' => $row['id_ticket'],
			'display_id' => str_pad($row['id_ticket'], $modSettings['shd_zerofill'], '0', STR_PAD_LEFT),
			'subject' => $row['subject'],
			'status' => $row['status'],
			'status_txt' => $txt['shd_status_' . $row['status']],
		);
	}

	$smcFunc['db_free_result']($query);
}

?>