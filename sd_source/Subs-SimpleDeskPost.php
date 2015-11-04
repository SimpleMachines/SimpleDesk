<?php
###############################################################
#         Simple Desk Project - www.simpledesk.net            #
###############################################################
#       An advanced help desk modification built on SMF       #
###############################################################
#                                                             #
#         * Copyright 2015 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 2.1                                     #
# File Info: Subs-SimpleDeskPost.php / 2.1                    #
###############################################################

/**
 *	This file handles probably the two most critical functions in SimpleDesk: the one that adds new posts to the database
 *	and one that saves updated posts; also contains miscellaneous code that applies generally in posting.
 *
 *	@package subs
 *	@since 1.0
 */

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Creates a new ticket or reply in the database.
 *
 *	This function handles all of the creation of posts and tickets within SimpleDesk, even with respect to managing tickets spawned
 *	from forum topics being moved. New tickets' contents as well as replies to tickets generally hold the same format.
 *
 *	All three parameters are by <b>reference</b> meaning they WILL be updated if things change. Note that this function
 *	is not validating that they are sensible values; it is up to the calling function to ascertain that.
 *
 *	@param array &$msgOptions A hash array by reference, containing details of the post you wish to add.
 *	<ul>
 *	<li>id: Not required on input (and is ignored) - and will be overwritten with the new message id when the function completes.</li>
 *	<li>body: Required string, the principle body content of the message to post. Assumed to have been cleaned already (with $smcFunc['htmlspecialchars'] and preparsecode)</li>
 *	<li>smileys_enabled: Optional, boolean denoting whether smileys should be active on this post; defaults to false</li>
 *	<li>time: Optional, timestamp of the post. If omitted, time() will be used instead (for "now" based on server clock)</li>
 *	<li>modified: Optional, hash array containing items relating to modification (if 'modified' key exists, all of these should be set)
 *		<ul>
 *			<li> time: Unsigned int timestamp of the change</li>
 *			<li> name: String; user name of the user making the change; if omitted, modified will be ignored</li>
 *			<li> id: Unsigned int user id of the user making the change; if not provided, id MUST be. If id isn't, or it doesn't exist, modified will be ignored entirely</li>
 *		</ul>
 *	</li>
 *	<li> attachments: Optional, array of attachment ids that need attaching to this message; if omitted no changes will occur
 *	</ul>
 *
 *	@param array &$ticketOptions A hash array by reference, containing details of the ticket as a whole.
 *	<ul>
 *	<li>id: Required if replying to a ticket, 0 if a new ticket (will default to 0 if not specified)</li>
 *	<li>mark_as_read: Optional boolean, whether to mark the ticket as read by the person posting it ($posterOptions['id'] is required to use this)</li>
 *	<li>mark_as_read_proxy: Optional integer for proxy tickets, if $ticketOptions['mark_as_read'] is true. Mark the ticket as read for the user with this id.</li>
 *	<li>subject: Semi-optional string with the new subject in; required for a new ticket, ignored if adding a reply. If set, assumed to have been cleaned already (with $smcFunc['htmlspecialchars'] and strtr)</li>
 *	<li>private: Semi-optional boolean with ticket privacy (true = private); required for a new ticket, ignored if adding a reply.</li>
 *	<li>status: Integer to denote new status of the ticket, defaults to TICKET_STATUS_NEW. Calling function to determine new status.</li>
 *	<li>urgency: Semi-optional integer with the ticket urgency; required for a new ticket, ignored if adding a reply. If not stated on a new ticket, TICKET_URGENCY_LOW will be used.</li>
 *	<li>assigned: Optional integer of user id, used to create a ticket with assignment, ignored if not a new ticket.</li>
 *	<li>dept: Required if creating a new ticket, to indicate which department the ticket should belong to.</li>
 *	</ul>
 *
 *	@param array &$posterOptions A hash array by reference, containing details of the person the reply is written by.
 *	<ul>
 *	<li>id: User id to credit the post to. Uses 0 if not specified.</li>
 *	<li>ip: IP address the post came from. Uses the current user's IP address if not specified.</li>
 *	<li>name: Name to credit against the post. If not specified, and a user id was supplied, look that up in the member table, otherwise just use 'Guest'.</li>
 *	<li>email: Email address to list against the post. If not specified, and a user id was supplied, look that up in the member table, otherwise just use ''.</li>
 *	</ul>
 *	@return bool True on success, false on failure.
 *	@since 1.0
 */
function shd_create_ticket_post(&$msgOptions, &$ticketOptions, &$posterOptions)
{
	global $user_info, $txt, $modSettings, $smcFunc, $context, $user_profile;

	// Clean them incoming vars up good 'n' proper
	$msgOptions['smileys_enabled'] = !empty($msgOptions['smileys_enabled']);
	$msgOptions['attachments'] = empty($msgOptions['attachments']) ? array() : $msgOptions['attachments'];
	$msgOptions['time'] = empty($msgOptions['time']) ? time() : (int) $msgOptions['time'];
	$ticketOptions['id'] = empty($ticketOptions['id']) ? 0 : (int) $ticketOptions['id'];
	$ticketOptions['private'] = !empty($ticketOptions['private']);
	$ticketOptions['urgency'] = empty($ticketOptions['urgency']) ? TICKET_URGENCY_LOW : (int) $ticketOptions['urgency'];
	$ticketOptions['assigned'] = empty($ticketOptions['assigned']) ? 0 : (int) $ticketOptions['assigned'];
	$ticketOptions['status'] = empty($ticketOptions['status']) ? TICKET_STATUS_NEW : (int) $ticketOptions['status'];
	$posterOptions['id'] = empty($posterOptions['id']) ? 0 : (int) $posterOptions['id'];
	$posterOptions['ip'] = empty($posterOptions['ip']) ? $user_info['ip'] : $posterOptions['ip'];

	// If nothing was filled in as name/e-mail address, try the member table.
	if (!isset($posterOptions['name']) || $posterOptions['name'] == '' || (empty($posterOptions['email']) && !empty($posterOptions['id'])))
	{
		if (empty($posterOptions['id']))
		{
			$posterOptions['id'] = 0;
			$posterOptions['name'] = $txt['guest_title'];
			$posterOptions['email'] = '';
		}
		elseif ($posterOptions['id'] != $user_info['id'])
		{
			if (empty($user_profile[$posterOptions['id']]))
				loadMemberData($posterOptions['id'], false, 'minimal');

			// Couldn't find the current poster?
			if (empty($user_profile[$posterOptions['id']]))
			{
				trigger_error('shd_create_ticket_post(): Invalid member id ' . $posterOptions['id'], E_USER_NOTICE);
				$posterOptions['id'] = 0;
				$posterOptions['name'] = $txt['guest_title'];
				$posterOptions['email'] = '';
			}
			else
			{
				$posterOptions['name'] = $user_profile[$posterOptions['id']]['real_name'];
				$posterOptions['email'] = $user_profile[$posterOptions['id']]['email_address'];
			}
		}
		else
		{
			$posterOptions['name'] = $user_info['name'];
			$posterOptions['email'] = $user_info['email'];
		}
	}

	// Is there modified name data? (For topic->ticket)
	$modified = true;
	if (isset($msgOptions['modified']))
	{
		$msgOptions['modified']['time'] = empty($msgOptions['modified']['time']) ? 0 : (int) $msgOptions['modified']['time'];
		$msgOptions['modified']['id'] = empty($msgOptions['modified']['id']) ? 0 : (int) $msgOptions['modified']['id'];
		$msgOptions['modified']['name'] = empty($msgOptions['modified']['name']) ? '' : $msgOptions['modified']['name'];

		$cancel = false;
		if (empty($msgOptions['modified']['time']) || (empty($msgOptions['modified']['name']) && empty($msgOptions['modified']['id'])))
			$modified = false;

		if ($modified)
		{
			// So they have a time, and name or id (or even both). Let's see what we need.
			if (empty($msgOptions['modified']['name']))
			{
				loadMemberData($msgOptions['modified']['id'], false, 'minimal');
				if (empty($user_profile[$msgOptions['modified']['id']]))
					$modified = false; // oops, they gave us a user id that doesn't exist -- and we don't have a name
			}
			// Otherwise, we have a name and no id, which is fine. Can't be doing with trying to figure out usernames.
		}
	}
	else
		$modified = false;

	if (!$modified)
	$msgOptions['modified'] = array(
		'id' => 0,
		'name' => '',
		'time' => 0,
	);

	// It's do or die time: forget any user aborts!
	$previous_ignore_user_abort = ignore_user_abort(true);

	$new_ticket = empty($ticketOptions['id']);

	// OK, so let's add the reply. Even if it's a new ticket and stuff, let's still add the msg first so we have our friendly msg id
	$smcFunc['db_insert']('',
		'{db_prefix}helpdesk_ticket_replies',
		array(
			'id_ticket' => 'int', 'id_member' => 'int', 'body' => 'string-65534',
			'poster_name' => 'string-255', 'poster_email' => 'string-255', 'poster_time' => 'int', 'poster_ip' => 'string-255',
			'smileys_enabled' => 'int', 'modified_member' => 'int', 'modified_name' => 'string', 'modified_time' => 'int',
		),
		array(
			$ticketOptions['id'], $posterOptions['id'], $msgOptions['body'],
			$posterOptions['name'], $posterOptions['email'], $msgOptions['time'], $posterOptions['ip'],
			$msgOptions['smileys_enabled'] ? 1 : 0, $msgOptions['modified']['id'], $msgOptions['modified']['name'], $msgOptions['modified']['time'],
		),
		array('id_msg')
	);
	$msgOptions['id'] = $smcFunc['db_insert_id']('{db_prefix}messages', 'id_msg');

	// Something went wrong creating the message...
	if (empty($msgOptions['id']))
		return false;

	// Insert a new ticket (if the ID was left empty)
	if ($new_ticket)
	{
		$smcFunc['db_insert']('',
			'{db_prefix}helpdesk_tickets',
			array(
				'id_dept' => 'int', 'id_first_msg' => 'int', 'id_member_started' => 'int', 'id_last_msg' => 'int',
				'id_member_updated' => 'int', 'id_member_assigned' => 'int', 'subject' => 'string-100', 'urgency' => 'int',
				'status' => 'int', 'private' => 'int',
			),
			array(
				$ticketOptions['dept'], $msgOptions['id'], $posterOptions['id'], $msgOptions['id'], $posterOptions['id'],
				$ticketOptions['assigned'], $ticketOptions['subject'], $ticketOptions['urgency'], $ticketOptions['status'],
				$ticketOptions['private'] ? 1 : 0,
			),
			array('id_ticket')
		);
		$ticketOptions['id'] = $smcFunc['db_insert_id']('{db_prefix}helpdesk_tickets', 'id_ticket');

		// The ticket couldn't be created for some reason.
		if (empty($ticketOptions['id']))
		{
			// We should delete the post that did work, though...
			shd_db_query('', '
				DELETE FROM {db_prefix}helpdesk_ticket_replies
				WHERE id_msg = {int:id_msg}',
				array(
					'id_msg' => $msgOptions['id'],
				)
			);

			return false;
		}

		// Fix the message with the ticket.
		shd_db_query('', '
			UPDATE {db_prefix}helpdesk_ticket_replies
			SET id_ticket = {int:id_ticket}
			WHERE id_msg = {int:id_msg}',
			array(
				'id_ticket' => $ticketOptions['id'],
				'id_msg' => $msgOptions['id'],
			)
		);
	}
	// The ticket already exists, it only needs a little updating.
	else
	{
		shd_db_query('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET
				id_member_updated = {int:poster_id},
				id_last_msg = {int:id_msg},
				num_replies = num_replies + 1,
				status = {int:status}
			WHERE id_ticket = {int:id_ticket}',
			array(
				'poster_id' => $posterOptions['id'],
				'id_msg' => $msgOptions['id'],
				'status' => $ticketOptions['status'],
				'id_ticket' => $ticketOptions['id'],
			)
		);
	}

	// Fix the attachments.
	if (!empty($msgOptions['attachments']))
	{
		$array = array();
		foreach ($msgOptions['attachments'] as $attach)
			$array[] = array($attach, $msgOptions['id'], $ticketOptions['id']);

		$smcFunc['db_insert']('replace',
			'{db_prefix}helpdesk_attachments',
			array(
				'id_attach' => 'int', 'id_msg' => 'int', 'id_ticket' => 'int',
			),
			$array,
			array('id_attach')
		);
	}

	// Mark inserted ticket as read (only for the user listed as the author -- oftentimes will be the current user though)
	if (!empty($ticketOptions['mark_as_read']) && !empty($posterOptions['id']))
	{
		// Since it's likely they *read* it before replying, let's try an UPDATE first.
		if (!$new_ticket)
		{
			shd_db_query('', '
				UPDATE {db_prefix}helpdesk_log_read
				SET id_msg = {int:id_msg}
				WHERE id_member = {int:current_member}
					AND id_ticket = {int:id_ticket}',
				array(
					'current_member' => $posterOptions['id'],
					'id_msg' => $msgOptions['id'],
					'id_ticket' => $ticketOptions['id'],
				)
			);

			$flag = $smcFunc['db_affected_rows']() != 0;
		}

		if (empty($flag)) // such as, say, a new ticket?
		{
			// Hold on a second... If this is a proxy ticket... We'll want to mark it read for the staff member, not the member for whom it was posted.
			$mark_read_user = !empty($ticketOptions['mark_as_read_proxy']) ? $ticketOptions['mark_as_read_proxy'] : $posterOptions['id'];

			$smcFunc['db_insert']('replace',
				'{db_prefix}helpdesk_log_read',
				array('id_ticket' => 'int', 'id_member' => 'int', 'id_msg' => 'int'),
				array($ticketOptions['id'], $mark_read_user, $msgOptions['id']),
				array('id_ticket', 'id_member')
			);
		}
	}

	// Are we saving custom fields?
	$rows = array();
	if (!empty($ticketOptions['custom_fields']))
	{
		// We shouldn't need to be bothering with pre-existing ones. This is a new message in whatever form, after all.
		foreach ($ticketOptions['custom_fields'] as $field_id => $field)
		{
			if (isset($field['new_value']))
				$rows[] = array(
					'id_post' => $ticketOptions['id'], // since custom fields for tickets are attached to the ticket id, with post_type as CFIELD_TICKET
					'id_field' => $field_id,
					'value' => $field['new_value'],
					'post_type' => CFIELD_TICKET, // See, I said so!
				);
		}
	}
	// Same deal, just this time for message fields.
	if (!empty($msgOptions['custom_fields']))
	{
		foreach ($msgOptions['custom_fields'] as $field_id => $field)
		{
			if (isset($field['new_value']))
				$rows[] = array(
					'id_post' => $msgOptions['id'], // since custom fields for tickets are attached to the ticket id, with post_type as CFIELD_TICKET
					'id_field' => $field_id,
					'value' => $field['new_value'],
					'post_type' => CFIELD_REPLY, // See, I said so!
				);
		}
	}
	if (!empty($rows))
	{
		$smcFunc['db_insert']('replace',
			'{db_prefix}helpdesk_custom_fields_values',
			array('id_post' => 'int', 'id_field' => 'int', 'value' => 'string-65534', 'post_type' => 'int'),
			$rows,
			array('id_post', 'id_field')
		);
	}

	// Int hooks
	$hook = $new_ticket ? 'shd_hook_newticket' : 'shd_hook_newreply';
	call_integration_hook($hook, array(&$msgOptions, &$ticketOptions, &$posterOptions));

	ignore_user_abort($previous_ignore_user_abort);

	if (empty($ticketOptions['dept']) && !empty($ticketOptions['id']))
	{
		// So we're making a reply, we need the department id. The ticket will already exist - we just added to it!
		$query = $smcFunc['db_query']('', '
			SELECT id_dept
			FROM {db_prefix}helpdesk_tickets
			WHERE id_ticket = {int:id_ticket}',
			array(
				'id_ticket' => $ticketOptions['id'],
			)
		);
		list($ticketOptions['dept']) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);
	}

	if (!empty($ticketOptions['dept']))
		shd_clear_active_tickets($ticketOptions['dept']);

	// Success.
	return true;
}

/**
 *	Updates a ticket/reply item in the database.
 *
 *	This function allows modification of all post/ticket details - and can be used independently; it is possible (and even done
 *	in SimpleDesk) to update just a ticket or just a post from this function. All three parameters are by <b>reference</b>
 *	meaning they WILL be updated if things change. Note that this function is not validating that they are sensible values; it is
 *	up to the calling function to ascertain that.
 *
 *	@param array &$msgOptions - a hash array by reference, stating zero or more details to change on a message (if the change is strictly ticket-only, the entire $msgOptions array can be an empty array):
 *	<ul>
 *	<li>id: Required if changing a message; the principle numeric id of the message to modify</li>
 *	<li>body: Optional, the principle body content of the message to change; if omitted, no change will occur. If set, assumed to have been cleaned already (with $smcFunc['htmlspecialchars'] and preparsecode)</li>
 *	<li>modified: Optional, hash array containing items relating to modification (if 'modified' key exists, all of these should be set)
 *		<ul>
 *			<li>time: Unsigned int timestamp of the change</li>
 *			<li>name: String; user name of the user making the change</li>
 *			<li>id: Unsigned int user id of the user making the change</li>
 *		</ul>
 *	</li>
 *	<li>smileys_enabled: Optional, boolean denoting whether smileys should be active on this post; if omitted no change will occur</li>
 *	<li>attachments: Optional, array of attachment ids that need attaching to this message; if omitted no changes will occur</li>
 *	</ul>
 *
 *	@param array &$ticketOptions - a hash array by reference, stating one or more details necessary to change on a ticket:
 *	<ul>
 *	<li>id: Required in all cases, numeric ticket id that the edit relates to</li>
 *	<li>subject: Optional string with the new subject in; if omitted no change will occur. If set, assumed to have been cleaned already (with $smcFunc['htmlspecialchars'] and strtr)</li>
 *	<li>urgency: Optional integer with the new urgency in; if omitted no change will occur</li>
 *	<li>status: Optional integer with the new status in; if omitted no change will occur</li>
 *	<li>ssigned: Optional integer with the user id of assigned user; if omitted no change will occur (note, you would declare this as 0 to unassign a ticket - set to 0 is not omitted)</li>
 *	<li>private: Optional boolean as to privacy of ticket: true = private, false = not private (note, you still declare this to change it)</li>
 *	</ul>
 *
 *	@param array &$posterOptions - a hash array by reference of details to change on the poster of a message:
 *	<ul>
 *	<li>name: Optional string, name of credited poster (in absence of id, this will be used); if omitted no change will occur</li>
 *	<li>email: Optional string, email address of poster; if omitted no change will occur</li>
 *	</ul>
 *
 *	@return bool True on success, false on failure.
 *	@since 1.0
*/
function shd_modify_ticket_post(&$msgOptions, &$ticketOptions, &$posterOptions)
{
	global $user_info, $txt, $modSettings, $smcFunc, $context;

	$messages_columns = array();
	$ticket_columns = array();

	$ticketOptions['id'] = !empty($ticketOptions['id']) ? (int) $ticketOptions['id'] : 0;
	if ($ticketOptions['id'] == 0)
		return false;

	if (isset($posterOptions['name']))
		$messages_columns['poster_name'] = $posterOptions['name'];
	if (isset($posterOptions['email']))
		$messages_columns['poster_email'] = $posterOptions['email'];
	if (isset($msgOptions['body']))
		$messages_columns['body'] = $msgOptions['body'];
	if (!empty($msgOptions['modified']))
	{
		$messages_columns['modified_time'] = $msgOptions['modified']['time'];
		$messages_columns['modified_name'] = $msgOptions['modified']['name'];
		$messages_columns['modified_member'] = $msgOptions['modified']['id'];
	}
	if (isset($msgOptions['smileys_enabled']))
		$messages_columns['smileys_enabled'] = empty($msgOptions['smileys_enabled']) ? 0 : 1;
	if (isset($ticketOptions['subject']))
		$ticket_columns['subject'] = $ticketOptions['subject'];
	if (isset($ticketOptions['status']))
		$ticket_columns['status'] = $ticketOptions['status'];
	if (isset($ticketOptions['urgency']))
		$ticket_columns['urgency'] = $ticketOptions['urgency'];
	if (isset($ticketOptions['assigned']))
		$ticket_columns['id_member_assigned'] = $ticketOptions['assigned'];
	if (isset($ticketOptions['private']))
		$ticket_columns['private'] = empty($ticketOptions['private']) ? 0 : 1;

	// Fix the attachments.
	if (!empty($msgOptions['attachments']))
	{
		$array = array();
		foreach ($msgOptions['attachments'] as $attach)
			$array[] = array($attach, $msgOptions['id'], $ticketOptions['id']);

		$smcFunc['db_insert']('replace',
			'{db_prefix}helpdesk_attachments',
			array(
				'id_attach' => 'int', 'id_msg' => 'int', 'id_ticket' => 'int',
			),
			$array,
			array('id_attach')
		);
	}

	if (empty($messages_columns) && empty($ticket_columns) && empty($ticketOptions['custom_fields']) && empty($msgOptions['custom_fields']))
		return true;

	// It's do or die time: forget any user aborts!
	$previous_ignore_user_abort = ignore_user_abort(true);

	// OK, let's get all this set up ready for SQL magic
	// Which columns need to be ints?
	$messageInts = array('modified_time', 'modified_member', 'smileys_enabled');
	$msg_update_parameters = array(
		'id_msg' => empty($msgOptions['id']) ? 0 : (int) $msgOptions['id'],
	);

	foreach ($messages_columns as $var => $val)
	{
		$messages_columns[$var] = $var . ' = {' . (in_array($var, $messageInts) ? 'int' : 'string') . ':var_' . $var . '}';
		$msg_update_parameters['var_' . $var] = $val;
	}

	$ticketInts = array('status', 'urgency');
	$ticket_update_parameters = array(
		'id_ticket' => $ticketOptions['id'],
	);

	foreach ($ticket_columns as $var => $val)
	{
		$ticket_columns[$var] = $var . ' = {' . (in_array($var, $ticketInts) ? 'int' : 'string') . ':var_' . $var . '}';
		$ticket_update_parameters['var_' . $var] = $val;
	}

	// GO GO GO! (message first)
	if (!empty($messages_columns))
	{
		shd_db_query('', '
			UPDATE {db_prefix}helpdesk_ticket_replies
			SET ' . implode(', ', $messages_columns) . '
			WHERE id_msg = {int:id_msg}',
			$msg_update_parameters
		);
	}

	if (!empty($ticket_columns))
	{
		shd_db_query('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET ' . implode(', ', $ticket_columns) . '
			WHERE id_ticket = {int:id_ticket}',
			$ticket_update_parameters
		);
	}

	// And fix unread list
	if (!empty($msgOptions['modified']))
	{
		shd_db_query('', '
			UPDATE {db_prefix}helpdesk_log_read
			SET id_msg = {int:last_msg}
			WHERE id_member != {int:modified_member}
				AND id_ticket = {int:ticket}
				AND id_msg >= {int:edited_msg}',
			array(
				'last_msg' => $msg_update_parameters['id_msg'] - 1,
				'modified_member' => $msgOptions['modified']['id'],
				'ticket' => $ticketOptions['id'],
				'edited_msg' => $msg_update_parameters['id_msg'],
			)
		);
	}

	// Are we updating custom fields?
	$rows = array();
	$context['custom_fields_updated'] = array();
	if (!empty($ticketOptions['custom_fields']))
	{
		// Some may be pre-existing, some may need purging.
		foreach ($ticketOptions['custom_fields'] as $field_id => $field)
		{
			// No new value, or new value is the same as the old one.
			if (!isset($field['new_value']) || (isset($field['value']) && $field['value'] == $field['new_value']))
				continue;

			// So we have a new value, or a changed value. If it's changed, but changed to default, mark it as default
			$rows[] = array(
				'id_post' => $ticketOptions['id'], // since custom fields for tickets are attached to the ticket id, with post_type as CFIELD_TICKET
				'id_field' => $field_id,
				'value' => $field['new_value'],
				'post_type' => CFIELD_TICKET, // See, I said so!
			);
			if ($field['type'] == CFIELD_TYPE_MULTI)
			{
				$values = array();
				if (!empty($field['value']))
					foreach ($field['value'] as $value)
						if (!empty($value))
							$values[] = $field['options'][$value];
				$oldvalue = implode(', ', $values);

				$values = array();
				$newvalues = explode(',', $field['new_value']);
				foreach ($newvalues as $value)
					if (!empty($value))
						$values[] = $field['options'][$value];
				$newvalue = implode(', ', $values);
			}
			else
			{
				$oldvalue = !empty($field['value']) && ($field['type'] == CFIELD_TYPE_RADIO || $field['type'] == CFIELD_TYPE_SELECT) ? $field['options'][$field['value']] : (empty($field['value']) ? '' : $field['value']);
				$newvalue = !empty($field['new_value']) && ($field['type'] == CFIELD_TYPE_RADIO || $field['type'] == CFIELD_TYPE_SELECT) ? $field['options'][$field['new_value']] : $field['new_value'];
			}
			$context['custom_fields_updated'][] = array(
				'ticket' => $ticketOptions['id'],
				'fieldname' => $field['name'],
				'oldvalue' => $oldvalue,
				'newvalue' => $newvalue,
				'scope' => CFIELD_TICKET,
				'visible' => $field['visible'],
				'fieldtype' => $field['type'],
			);
			if ($field['new_value'] == $field['default_value'])
				$context['custom_fields_updated'][count($context['custom_fields_updated'])-1]['default'] = true;
		}
	}
	// Same deal, this time for message options. See above for comments.
	if (!empty($msgOptions['custom_fields']))
	{
		foreach ($msgOptions['custom_fields'] as $field_id => $field)
		{
			if (!isset($field['new_value']) || (isset($field['value']) && $field['value'] == $field['new_value']))
				continue;

			$rows[] = array(
				'id_post' => $msgOptions['id'],
				'id_field' => $field_id,
				'value' => $field['new_value'],
				'post_type' => CFIELD_REPLY,
			);
			if ($field['type'] == CFIELD_TYPE_MULTI)
			{
				$values = array();
				if (!empty($field['value']))
					foreach ($field['value'] as $value)
						if (!empty($value))
							$values[] = $field['options'][$value];
				$oldvalue = implode(', ', $values);

				$values = array();
				$newvalues = explode(',', $field['new_value']);
				foreach ($newvalues as $value)
					if (!empty($value))
						$values[] = $field['options'][$value];
				$newvalue = implode(', ', $values);
			}
			else
			{
				$oldvalue = !empty($field['value']) && ($field['type'] == CFIELD_TYPE_RADIO || $field['type'] == CFIELD_TYPE_SELECT) ? $field['options'][$field['value']] : (empty($field['value']) ? ($field['type'] != CFIELD_TYPE_LARGETEXT ? $field['default_value'] : '') : $field['value']);
				$newvalue = !empty($field['new_value']) && ($field['type'] == CFIELD_TYPE_RADIO || $field['type'] == CFIELD_TYPE_SELECT) ? $field['options'][$field['new_value']] : $field['new_value'];
			}

			if ($oldvalue != $newvalue)
			{
				$context['custom_fields_updated'][] = array(
					'ticket' => $ticketOptions['id'],
					'msg' => $msgOptions['id'],
					'fieldname' => $field['name'],
					'oldvalue' => $oldvalue,
					'newvalue' => $newvalue,
					'scope' => CFIELD_REPLY,
					'visible' => $field['visible'],
					'fieldtype' => $field['type'],
				);
				if ($field['new_value'] == $field['default_value'])
					$context['custom_fields_updated'][count($context['custom_fields_updated'])-1]['default'] = true;
			}
		}
	}
	// If there are rows to add or update, commence.
	if (!empty($rows))
	{
		$smcFunc['db_insert']('replace',
			'{db_prefix}helpdesk_custom_fields_values',
			array('id_post' => 'int', 'id_field' => 'int', 'value' => 'string-65534', 'post_type' => 'int'),
			$rows,
			array('id_post', 'id_field')
		);
	}

	// Int hook
	call_integration_hook('shd_hook_modpost', array(&$msgOptions, &$ticketOptions, &$posterOptions));

	ignore_user_abort($previous_ignore_user_abort);

	if (empty($ticketOptions['dept']) && !empty($ticketOptions['id']))
	{
		// So we're making a reply, we need the department id. The ticket will already exist - we just added to it!
		$query = $smcFunc['db_query']('', '
			SELECT id_dept
			FROM {db_prefix}helpdesk_tickets
			WHERE id_ticket = {int:id_ticket}',
			array(
				'id_ticket' => $ticketOptions['id'],
			)
		);
		list($ticketOptions['dept']) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);
	}

	if (!empty($ticketOptions['dept']))
		shd_clear_active_tickets($ticketOptions['dept']);

	// Success.
	return true;
}

/**
 *	Identifies the range of options that a user could have for ticket urgency and updates $context['ticket_form'] accordingly.
 *
 *	Ticket urgency permissions are checked, and an array is built suitable for $context['ticket_form'], which is the principle
 *	format used in the ticket posting/reply posting functions in SimpleDesk-Post.php.
 *
 *	There is no return function; $context['ticket_form']['urgency'] is updated, both the ['options'] and ['can_change'] keys
 *	may be modified.
 *
 *	@param bool $self_ticket (default false) Permissions will be different for many users depending on whether it is one
 *	of their own tickets or not. This allows the code to state whether it is a ticket owned by the current user or not.
 *
 *	@see SimpleDesk-Display.php
 *	@since 1.0
*/
function shd_get_urgency_options($self_ticket = false, $dept = 0)
{
	global $context;
	$context['ticket_form']['urgency']['options'] = array(
		TICKET_URGENCY_LOW => 'shd_urgency_0',
		TICKET_URGENCY_MEDIUM => 'shd_urgency_1',
		TICKET_URGENCY_HIGH => 'shd_urgency_2',
		TICKET_URGENCY_VHIGH => 'shd_urgency_3',
		TICKET_URGENCY_SEVERE => 'shd_urgency_4',
		TICKET_URGENCY_CRITICAL => 'shd_urgency_5',
	);

	if (shd_allowed_to('shd_alter_urgency_higher_any', $dept) || ($self_ticket && shd_allowed_to('shd_alter_urgency_higher_own', $dept)))
	{
		$context['ticket_form']['urgency']['can_change'] = true;
	}
	elseif (shd_allowed_to('shd_alter_urgency_any', $dept) || ($self_ticket && shd_allowed_to('shd_alter_urgency_own', $dept)))
	{
		if (!empty($context['ticket_form']['urgency']['setting']) && $context['ticket_form']['urgency']['setting'] > TICKET_URGENCY_HIGH)
			$context['ticket_form']['urgency']['can_change'] = false;
		else
		{
			$context['ticket_form']['urgency']['can_change'] = true;
			unset(
				$context['ticket_form']['urgency']['options'][TICKET_URGENCY_VHIGH],
				$context['ticket_form']['urgency']['options'][TICKET_URGENCY_SEVERE],
				$context['ticket_form']['urgency']['options'][TICKET_URGENCY_CRITICAL]
			);
		}
	}
	else
		$context['ticket_form']['urgency']['can_change'] = false;
}

/**
 *	Loads any custom fields that are active
 *
 *	@param bool $is_ticket (default true) Whether to load custom fields based on editing a ticket or a message.
 *	@param int $ticketContext The appropriate value to load for; if editing a ticket this represents the ticket id, if editing a reply this represents the message id, if empty this is a new instance of either so no need to attempt loading data.
 *
 *	@since 2.0
*/
function shd_load_custom_fields($is_ticket = true, $ticketContext = 0, $dept = 0)
{
	global $sourcedir, $context, $smcFunc;

	$field_values = array();
	if (!empty($ticketContext))
	{
		$query = shd_db_query('', '
			SELECT cfv.id_field, cfv.value
			FROM {db_prefix}helpdesk_custom_fields_values AS cfv
			WHERE cfv.id_post = {int:ticketContext}
				AND cfv.post_type = {int:field_type}',
			array(
				'ticketContext' => $ticketContext,
				'field_type' => $is_ticket ? CFIELD_TICKET : CFIELD_REPLY,
			)
		);
		while($row = $smcFunc['db_fetch_assoc']($query))
			$field_values[$row['id_field']] = $row['value'];
		$smcFunc['db_free_result']($query);
	}

	// Load up our custom field defintions from the database
	$custom_fields = shd_db_query('', '
		SELECT cf.id_field, cf.active, cf.field_order, cf.field_name, cf.field_desc, cf.field_loc, cf.icon,
			cf.field_type, cf.field_options, cf.default_value, cf.bbc, cf.can_see, cf.can_edit, cf.field_length,
			cf.display_empty, cfd.required, cf.placement, cfd.id_dept
		FROM {db_prefix}helpdesk_custom_fields AS cf
			INNER JOIN {db_prefix}helpdesk_custom_fields_depts AS cfd ON (cf.id_field = cfd.id_field' . (!empty($dept) ? ' AND cfd.id_dept = {int:dept}' : '') .')
		WHERE cf.active = 1
			AND cf.field_loc IN ({array_int:visibility})
		ORDER BY cf.field_order',
		array(
			'visibility' => $is_ticket ? array(CFIELD_TICKET, CFIELD_REPLY | CFIELD_TICKET) : array(CFIELD_REPLY, CFIELD_REPLY | CFIELD_TICKET),
			'dept' => $dept,
		)
	);

	$context['ticket_form']['custom_fields'] = array();

	$loc = $is_ticket ? 'ticket' : $ticketContext;

	$is_staff = shd_allowed_to('shd_staff', $dept);
	$is_admin = shd_allowed_to('admin_helpdesk', $dept); // this includes forum admins

	// Loop through all fields and figure out where they should be.
	while($row = $smcFunc['db_fetch_assoc']($custom_fields))
	{
		// Can the user even see this field? If we can't see the field, it doesn't exist to us for posting purposes.
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

		// Load up the fields and do some extra parsing
		if (!isset($context['ticket_form']['custom_fields'][$loc][$row['id_field']]))
		{
			$context['ticket_form']['custom_fields'][$loc][$row['id_field']] = array(
				'id' => $row['id_field'],
				'order' => $row['field_order'],
				'location' => $row['field_loc'],
				'length' => $row['field_length'],
				'name' => $row['field_name'],
				'desc' => parse_bbc($row['field_desc'], false),
				'icon' => $row['icon'],
				'options' => !empty($row['field_options']) ? unserialize($row['field_options']) : array(),
				'type' => $row['field_type'],
				'default_value' => $row['field_type'] == CFIELD_TYPE_LARGETEXT ? explode(',', $row['default_value']) : $row['default_value'],
				'display_empty' => !empty($row['required']) ? 1 : $row['display_empty'], // Required and "selection" fields will always be displayed.
				'bbc' => !empty($row['bbc']),
				'is_required' => $row['field_type'] == CFIELD_TYPE_MULTI ? (int) $row['required'] : !empty($row['required']),
				'visible' => array($user_see, $staff_see),
				'editable' => !empty($editable),
				'depts' => array(),
			);
			if ($row['field_type'] == CFIELD_TYPE_RADIO || $row['field_type'] == CFIELD_TYPE_MULTI)
			{
				foreach ($context['ticket_form']['custom_fields'][$loc][$row['id_field']]['options'] as $k => $v)
				{
					if ($k != 'inactive')
						$context['ticket_form']['custom_fields'][$loc][$row['id_field']]['options'][$k] = (strpos($v, '[') !== false) ? parse_bbc($v) : $v;
				}
			}
			elseif ($row['field_type'] == CFIELD_TYPE_SELECT)
			{
				foreach ($context['ticket_form']['custom_fields'][$loc][$row['id_field']]['options'] as $k => $v)
				{
					if ($k != 'inactive')
						$context['ticket_form']['custom_fields'][$loc][$row['id_field']]['options'][$k] = (strpos($v, '[') !== false) ? trim(strip_tags(parse_bbc($v))) : trim($v);
				}
			}
		}
		$context['ticket_form']['custom_fields'][$loc][$row['id_field']]['depts'][] = $row['id_dept'];
		if (!empty($context['ticket_form']['custom_fields'][$loc][$row['id_field']]['options']) && empty($context['ticket_form']['custom_fields'][$loc][$row['id_field']]['options']['inactive']))
			$context['ticket_form']['custom_fields'][$loc][$row['id_field']]['options']['inactive'] = array();

		if (isset($field_values[$row['id_field']]))
		{
			if ($context['ticket_form']['custom_fields'][$loc][$row['id_field']]['type'] == CFIELD_TYPE_MULTI)
				$field_values[$row['id_field']] = explode(',', $field_values[$row['id_field']]);

			// Large text boxes may need fixing.
			if ($context['ticket_form']['custom_fields'][$loc][$row['id_field']]['type'] == CFIELD_TYPE_LARGETEXT)
			{
				require_once($sourcedir . '/Subs-Editor.php');

				$field_values[$row['id_field']] = html_to_bbc($field_values[$row['id_field']]);
			}

			$context['ticket_form']['custom_fields'][$loc][$row['id_field']]['value'] = $field_values[$row['id_field']];
		}
	}

	$context['ticket_form']['custom_fields_context'] = $loc;
}

function shd_validate_custom_fields($scope, $dept)
{
	global $context, $smcFunc, $txt, $sourcedir;

	require_once($sourcedir . '/Subs-Post.php');

	if (empty($context['ticket_form']['custom_fields'][$scope]))
		return array(array(), array());

	$missing_fields = array();
	$invalid_fields = array();

	foreach ($context['ticket_form']['custom_fields'][$scope] as $field_id => $field)
	{
		if (!$field['editable'] || !in_array($dept, $field['depts']))
			continue;

		if (empty($field['options']['inactive']))
			$field['options']['inactive'] = array();

		// Multi-selects are special. Deal with them first.
		if ($field['type'] == CFIELD_TYPE_MULTI)
		{
			$newvalues = array();
			foreach ($field['options'] as $k => $v)
				if (!empty($_POST['field-' . $field_id . '-' . $k]))
				{
					if (!in_array($k, $field['options']['inactive']) || empty($field['is_required']))
						$newvalues[] = $k;
				}

			$value = !empty($newvalues) ? implode(',', $newvalues) : '';
			if (!empty($field['is_required']) && count($newvalues) < $field['is_required'])
				$missing_fields[$field_id] = sprintf($txt['error_missing_multi'], $field['name'], $field['is_required']);
		}
		// Otherwise, for each field, check it was sent in the form.
		elseif (isset($_POST['field-' . $field_id]))
		{
			if ($field['type'] != CFIELD_TYPE_MULTI)
				$value = trim($_POST['field-' . $field_id]);

			// Now to sanitise the individual value.
			switch ($field['type'])
			{
				case CFIELD_TYPE_TEXT:
				case CFIELD_TYPE_LARGETEXT:
					if ($field['is_required'] && empty($value))
						$missing_fields[$field_id] = $field['name'];
					else
					{
						if (!empty($field['length']))
							$value = $smcFunc['substr']($value, 0, $field['length']);
						$value = $smcFunc['htmlspecialchars']($value, ENT_QUOTES);
						preparsecode($value);
					}
					break;
				case CFIELD_TYPE_INT:
					// Well, check it was provided with a non empty value and check that that was a number and a whole one at that...
					if (empty($value) && $field['is_required'])
						$missing_fields[$field_id] = $field['name'];
					elseif (!empty($value) && (!is_numeric($value) || $value != (string) (int) $value))
						$invalid_fields[$field_id] = $field['name'];
					break;
				case CFIELD_TYPE_FLOAT:
					// Ordinarily we'd use PHP internally to do this and just cast it. But prior to 5.2.17 / 5.3.5 on x86 builds... it can hang PHP.
					if (empty($value) && $field['is_required'])
						$missing_fields[$field_id] = $field['name'];
					elseif (!empty($value) && !preg_match('~^[-+]?\d*(\.\d{0,10}([eE][-+]?\d{1,2})?)?$~', $value))
						$invalid_fields[$field_id] = $field['name'];
					// If we're here, it's valid. But we need to make sure there's a leading zero because we're nice like that. Or one after a leading -, that's cool too.
					elseif (strpos($value, '.') === 0)
						$value = '0' . $value;
					elseif (strpos($value, '-.') === 0)
						$value = str_replace('-.', '-0.', $value);
					break;
				case CFIELD_TYPE_SELECT:
				case CFIELD_TYPE_RADIO:
					// It's set but is it a number and a number that represents a key in the array? Same principle for select and radio.
					if ($field['is_required'] && (empty($value) || in_array($value, $field['options']['inactive'])))
						$missing_fields[$field_id] = $field['name'];
					elseif (!empty($value) && (!is_numeric($value) || !isset($field['options'][(int) $value])))
						$invalid_fields[$field_id] = $field['name'];
					break;
				case CFIELD_TYPE_CHECKBOX:
					// If there's something in it, it's on, simple as that.
					$value = 1;
					break;
			}
		}
		// Oops, wasn't sent in the form. Was it required? If it was, add it to the error list.
		elseif ($field['is_required'])
			$missing_fields[$field_id] = $field['name'];
		// Well, it wasn't set, wasn't required, but it might be a checkbox that needs to go off now...?
		elseif ($field['type'] == CFIELD_TYPE_CHECKBOX)
			$value = 0;

		// Did we actually come up with a value in the end?
		if (isset($value))
		{
			// OK... well, if it's a new ticket, we're saving the value. Even if it's default, so that we're clear that there is a value for it.
			$context['ticket_form']['custom_fields'][$scope][$field_id]['new_value'] = $value;
			unset($value); // for next time
		}
	}

	return array($missing_fields, $invalid_fields);
}

function shd_get_postable_depts()
{
	global $context, $smcFunc;
	$depts = shd_allowed_to('shd_new_ticket', false);
	$context['postable_dept_list'] = array();
	$context['ticket_form']['custom_field_dept'] = 0;
	if (!empty($depts))
	{
		$query = $smcFunc['db_query']('', '
			SELECT id_dept, dept_name
			FROM {db_prefix}helpdesk_depts
			WHERE id_dept IN ({array_int:depts})
			ORDER BY dept_order',
			array(
				'depts' => $depts,
			)
		);
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$context['postable_dept_list'][$row['id_dept']] = $row['dept_name'];
		$smcFunc['db_free_result']($query);

		// We do actually need to get the first one for the purposes of custom fields. But only the first one.
		foreach ($context['postable_dept_list'] as $id => $dept)
		{
			$context['ticket_form']['custom_field_dept'] = $id;
			break;
		}
	}
}
