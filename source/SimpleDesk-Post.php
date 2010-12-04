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
# File Info: SimpleDesk-Post.php / 1.0 Felidae                #
###############################################################

/**
 *	This file is one of the cornerstones of SimpleDesk; it handles displaying the post form to users, both for tickets and replies,
 *	handles editing of tickets/replies, attachments to tickets/replies and actually saving all that into the database.
 *
 *	@package source
 *	@todo Finish documenting this file.
 *	@since 1.0
*/

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Create a new ticket
*/
function shd_post_ticket()
{
	global $context, $user_info, $sourcedir, $txt, $scripturl, $reply_request, $smcFunc, $options, $memberContext;
	$context['tabindex'] = 1;

	$new_ticket = $_REQUEST['sa'] == 'newticket';

	if ($new_ticket)
		shd_is_allowed_to('shd_new_ticket');
	else
	{
		checkSession('get');
		$ticketinfo = shd_load_ticket();
		if (!shd_allowed_to('shd_edit_ticket_any') && (!shd_allowed_to('shd_edit_ticket_own') || !$ticketinfo['is_own']))
			fatal_lang_error('cannot_shd_edit_ticket');
	}

	// Things we need
	loadTemplate('SimpleDesk-Post');
	require_once($sourcedir . '/Subs-SimpleDeskPost.php');
	require_once($sourcedir . '/Subs-Post.php');
	require_once($sourcedir . '/Subs-Editor.php');

	if (empty($modSettings['shd_attachments_mode']))
		$modSettings['shd_attachments_mode'] = 'ticket';

	$context['ticket_form'] = array( // yes, everything goes in here.
		'form_title' => $new_ticket ? $txt['shd_create_ticket'] : $txt['shd_edit_ticket'],
		'form_action' => $scripturl . '?action=helpdesk;sa=saveticket',
		'first_msg' => $new_ticket ? 0 : $ticketinfo['id_first_msg'],
		'message' => $new_ticket ? '' : $ticketinfo['body'],
		'subject' => $new_ticket ? '' : $ticketinfo['subject'],
		'ticket' => $new_ticket ? 0 : $context['ticket_id'],
		'link' => $new_ticket ? '' : '<a href="' . $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . '">' . $ticketinfo['subject'] . '</a>',
		'msg' => $new_ticket ? 0 : $ticketinfo['id_first_msg'],
		'display_id' => $new_ticket ? '' : str_pad($context['ticket_id'], 5, '0', STR_PAD_LEFT),
		'status' => $new_ticket ? TICKET_STATUS_NEW : $ticketinfo['status'],
		'urgency' => array(
			'setting' => $new_ticket ? TICKET_URGENCY_LOW : $ticketinfo['urgency'],
		),
		'private' => array(
			'setting' => $new_ticket ? false : ($ticketinfo['private'] == 1),
			'can_change' => shd_allowed_to('shd_alter_privacy_any') || (shd_allowed_to('shd_alter_privacy_own') && ($new_ticket || !empty($ticketinfo['is_own']))),
			'options' => array(
				0 => 'shd_ticket_notprivate',
				1 => 'shd_ticket_private',
			),
		),
		'errors' => array(),
		'num_replies' => $new_ticket ? 0 : $ticketinfo['num_replies'],
		'do_attach' => shd_allowed_to('shd_post_attachment'),
		'num_allowed_attachments' => empty($modSettings['attachmentNumPerPostLimit']) || $modSettings['shd_attachments_mode'] == 'ticket' ? -1 : $modSettings['attachmentNumPerPostLimit'],
		'return_to_ticket' => isset($_REQUEST['goback']),
		'disable_smileys' => $new_ticket ? !empty($_REQUEST['no_smileys']) : ($ticketinfo['smileys_enabled'] == 0),
	);

	// A few basic checks
	if ($context['ticket_form']['status'] == TICKET_STATUS_CLOSED)
		fatal_lang_error('shd_cannot_edit_closed', false);
	elseif ($context['ticket_form']['status'] == TICKET_STATUS_DELETED)
		fatal_lang_error('shd_cannon_edit_deleted', false);

	// Ticket privacy
	if (empty($modSettings['shd_privacy_display']) || $modSettings['shd_privacy_display'] == 'smart')
		$context['display_private'] = shd_allowed_to('shd_view_ticket_private_any') || shd_allowed_to('shd_alter_privacy_own') || shd_allowed_to('shd_alter_privacy_any') || $context['ticket_form']['private']['setting'];
	else
		$context['display_private'] = true;

	if ($new_ticket)
	{
		$context['ticket_form'] += array(
			'member' => array(
				'name' => $context['user']['name'],
				'id' => $context['user']['id'],
				'link' => shd_profile_link($context['user']['name'], $context['user']['id']),
			),
			'assigned' => array(
				'id' => 0,
				'name' => $txt['shd_unassigned'],
				'link' => '<span class="error">' . $txt['shd_unassigned'] . '</span>',
			),
		);
	}
	else
	{
		$context['ticket_form'] += array(
			'member' => array(
				'name' => $ticketinfo['starter_name'],
				'id' => $ticketinfo['starter_id'],
				'link' => shd_profile_link($ticketinfo['starter_name'], $ticketinfo['starter_id']),
			),
			'assigned' => array(
				'id' => $ticketinfo['assigned_id'],
				'name' => !empty($ticketinfo['assigned_id']) ? $ticketinfo['assigned_name'] : $txt['shd_unassigned'],
				'link' => !empty($ticketinfo['assigned_id']) ? shd_profile_link($ticketinfo['assigned_name'], $ticketinfo['assigned_id']) : '<span class="error">' . $txt['shd_unassigned'] . '</span>',
			),
		);

		loadMemberData($ticketinfo['starter_id']);
		if (loadMemberContext($ticketinfo['starter_id']))
			$context['ticket_form']['member']['avatar'] = $memberContext[$ticketinfo['starter_id']]['avatar'];

		if (!$new_ticket && !empty($ticketinfo['modified_time']))
		{
			$context['ticket_form'] += array(
				'modified' => array(
					'name' => $ticketinfo['modified_name'],
					'id' => $ticketinfo['modified_id'],
					'time' => timeformat($ticketinfo['modified_time']),
					'link' => shd_profile_link($ticketinfo['modified_name'], $ticketinfo['modified_id']),
				),
			);
		}

		// Some other setup stuff
		shd_load_attachments();

		$context['ticket_form']['message'] = un_preparsecode($context['ticket_form']['message']);
		censorText($context['ticket_form']['subject']);
		censorText($context['ticket_form']['message']);
	}

	shd_get_urgency_options($new_ticket || $ticketinfo['is_own']);

	if ($context['ticket_form']['num_replies'])
		shd_setup_replies($ticketinfo['id_first_msg']);

	shd_check_attachments();

	// Set up the fancy editor
	shd_postbox(
		'shd_message',
		$context['ticket_form']['message'],
		array(
			'post_button' => $context['ticket_form']['form_title'],
		)
	);

	// Build the link tree and navigation
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=main',
		'name' => $txt['shd_linktree_tickets'],
	);
	$context['linktree'][] = array(
		'name' => $new_ticket ? $txt['shd_create_ticket'] : sprintf($txt['shd_edit_ticket_linktree'], $context['ticket_form']['link']),
	);

	$context['page_title'] = $txt['shd_helpdesk'];
	$context['sub_template'] = 'ticket_post';

	// Register this form in the session variables.
	checkSubmitOnce('register');
}

// All the magically common posting stuff goes in here
function shd_save_post()
{
	global $txt, $modSettings, $sourcedir, $context, $scripturl;
	global $user_info, $options, $smcFunc;

	// Oh no, robots!
	$context['robot_no_index'] = true;

	$context['shd_errors'] = array();

	// We'll probably be needing these.
	require_once($sourcedir . '/Subs-Editor.php');
	require_once($sourcedir . '/Subs-Post.php');
	require_once($sourcedir . '/Subs-SimpleDeskPost.php');
	loadTemplate('SimpleDesk-Post');
	loadLanguage('Errors'); // for some of the errors we already have
	loadLanguage('Post'); // for some of the common post errors

	if (!empty($_REQUEST['shd_message_mode']) && isset($_REQUEST['shd_message']))
	{
		// If we came from WYSIWYG, we need to convert from HTML to bbc, then unhtml it; then push to $_POST for everything else
		$_REQUEST['shd_message'] = un_htmlspecialchars(html_to_bbc($_REQUEST['shd_message']));
		$_POST['shd_message'] = $_REQUEST['shd_message'];
	}

	// Check session and double-posting
	checkSubmitOnce('check');
	if (checkSession('post', '', false) != '')
		$context['shd_errors'][] = 'session_timeout';

	// Clean up the details
	if (!isset($_POST['shd_message']) || $smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST['shd_message']), ENT_QUOTES) === '')
	{
		$context['shd_errors'][] = 'no_message';
		$_POST['shd_message'] = '';
	}
	else
	{
		// Pfft.
		if (isset($_POST['shd_message']) && strtolower($_POST['shd_message']) == 'this is simpledesk!')
			fatal_error('You are not King Leonidas...', false);
		$_POST['shd_message'] = $smcFunc['htmlspecialchars']($_POST['shd_message'], ENT_QUOTES);
		preparsecode($_POST['shd_message']);

		// Make sure there's something underneath all the tags
		if ($smcFunc['htmltrim'](strip_tags(shd_format_text($_POST['shd_message'], false), '<img>')) === '' && (!shd_allowed_to('admin_forum') || strpos($_POST['shd_message'], '[html]') === false))
			$context['shd_errors'][] = 'no_message';
		elseif (!empty($modSettings['max_messageLength']) && $smcFunc['strlen']($_POST['shd_message']) > $modSettings['max_messageLength'])
		{
			$context['shd_errors'][] = 'long_message';
			$txt['error_long_message'] = sprintf($txt['error_long_message'], $modSettings['max_messageLength']);
		}
	}

	// Now send them off to the specific areas, whether that's saving a ticket or a reply

	$actions = array(
		'saveticket' => 'shd_save_ticket',
		'savereply' => 'shd_save_reply',
	);

	if (isset($actions[$_REQUEST['sa']]))
		$actions[$_REQUEST['sa']]();
}

function shd_save_ticket()
{
	global $txt, $modSettings, $sourcedir, $context, $scripturl;
	global $user_info, $options, $smcFunc, $memberContext;

	// Ticket's gotta have a subject
	if (!isset($_POST['subject']) || $smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST['subject'])) === '')
	{
		$context['shd_errors'][] = 'no_subject';
		$_POST['subject'] = '';
	}
	else
		$_POST['subject'] = strtr($smcFunc['htmlspecialchars']($_POST['subject']), array("\r" => '', "\n" => '', "\t" => ''));

	if (empty($context['ticket_id']))
	{
		shd_is_allowed_to('shd_new_ticket');

		// some healthy defaults
		$context['ticket_id'] = 0;
		$new_ticket = true;
		$msg = 0;
		$is_own = true;
		$new_status = TICKET_STATUS_NEW;
		$private = false;
		$urgency = TICKET_URGENCY_LOW;
		$assigned = array(
			'id' => 0,
			'name' => $txt['shd_unassigned'],
			'link' => '<span class="error">' . $txt['shd_unassigned'] . '</span>',
		);
		$num_replies = 0;
	}
	else
	{
		// hmm, we're saving an update, let's get the existing ticket details and we can check permissions and stuff
		$new_ticket = false;

		$ticketinfo = shd_load_ticket();

		// S'pose we'd better check the permissions here
		if (!shd_allowed_to('shd_edit_ticket_any') && (!shd_allowed_to('shd_edit_ticket_own') || !$ticketinfo['is_own']))
			fatal_lang_error('cannot_shd_edit_ticket', false);

		$msg = $ticketinfo['id_first_msg'];
		$is_own = $ticketinfo['is_own'];
		$private = $ticketinfo['private'];
		$urgency = $ticketinfo['urgency'];
		$new_status = $ticketinfo['status'];
		$assigned = array(
			'id' => $ticketinfo['assigned_id'],
			'name' => !empty($ticketinfo['assigned_id']) ? $ticketinfo['assigned_name'] : $txt['shd_unassigned'],
			'link' => !empty($ticketinfo['assigned_id']) ? shd_profile_link($ticketinfo['assigned_name'], $ticketinfo['assigned_id']) : '<span class="error">' . $txt['shd_unassigned'] . '</span>',
		);
		$num_replies = $ticketinfo['num_replies'];
	}

	$context['ticket_form'] = array(
		'form_title' => $new_ticket ? $txt['shd_create_ticket'] : $txt['shd_edit_ticket'],
		'form_action' => $scripturl . '?action=helpdesk;sa=saveticket',
		'first_msg' => $new_ticket ? 0 : $ticketinfo['id_first_msg'],
		'message' => $_POST['shd_message'],
		'subject' => $_POST['subject'],
		'ticket' => $context['ticket_id'],
		'link' => $new_ticket ? '' : '<a href="' . $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . '">' . $ticketinfo['subject'] . '</a>',
		'msg' => $msg,
		'display_id' => empty($context['ticket_id']) ? '' : str_pad($context['ticket_id'], 5, '0', STR_PAD_LEFT),
		'status' => $new_status,
		'private' => array(
			'setting' => $private,
			'can_change' => (shd_allowed_to('shd_alter_privacy_any') || ($is_own && shd_allowed_to('shd_alter_privacy_own'))),
			'options' => array(
				0 => 'shd_ticket_notprivate',
				1 => 'shd_ticket_private',
			),
		),
		'assigned' => $assigned,
		'num_replies' => $num_replies,
		'do_attach' => shd_allowed_to('shd_post_attachment'),
		'return_to_ticket' => isset($_REQUEST['goback']),
		'disable_smileys' => !empty($_REQUEST['no_smileys']),
	);

	// Ticket privacy
	if (empty($modSettings['shd_privacy_display']) || $modSettings['shd_privacy_display'] == 'smart')
		$context['display_private'] = shd_allowed_to('shd_view_ticket_private_any') || shd_allowed_to('shd_alter_privacy_own') || shd_allowed_to('shd_alter_privacy_any') || $context['ticket_form']['private']['setting'];
	else
		$context['display_private'] = true;	

	// Preview?
	if (isset($_REQUEST['preview']))
	{
		$context['ticket_form']['preview'] = array(
			'title' => $txt['shd_previewing_ticket'] . ': ' . (empty($_POST['subject']) ? '<em>' . $txt['no_subject'] . '</em>' : $_POST['subject']),
			'body' => shd_format_text($_POST['shd_message']),
		);
	}

	if (!$new_ticket && !empty($ticketinfo['modified_time']))
	{
		$context['ticket_form'] += array(
			'modified' => array(
				'name' => $ticketinfo['modified_name'],
				'id' => $ticketinfo['modified_id'],
				'time' => timeformat($ticketinfo['modified_time']),
				'link' => shd_profile_link($ticketinfo['modified_name'], $ticketinfo['modified_id']),
			),
		);
	}

	if (!$new_ticket)
	{
		loadMemberData($ticketinfo['starter_id']);
		if (loadMemberContext($ticketinfo['starter_id']))
			$context['ticket_form']['member']['avatar'] = $memberContext[$ticketinfo['starter_id']]['avatar'];
	}

	shd_load_attachments();

	// Ticket privacy, let's see if we can override our healthy default with the post value
	if ($context['ticket_form']['private']['can_change'])
	{
		$new_private = isset($_POST['shd_private']) ? (int) $_POST['shd_private'] : $private;
		$context['ticket_form']['private']['setting'] = isset($context['ticket_form']['private']['options'][$new_private]) ? (bool) $new_private : $private;
	}

	// Ticket urgency
	shd_get_urgency_options($is_own);
	if ($context['ticket_form']['urgency']['can_change'])
	{
		$new_urgency = isset($_POST['shd_urgency']) ? (int) $_POST['shd_urgency'] : $urgency;
		$context['ticket_form']['urgency']['setting'] = isset($context['ticket_form']['urgency']['options'][$new_urgency]) ? $new_urgency : $urgency;
	}
	else
		$context['ticket_form']['urgency']['setting'] = $urgency;

	// A few basic checks
	if ($context['ticket_form']['status'] == TICKET_STATUS_CLOSED)
		fatal_lang_error('shd_cannot_edit_closed', false);
	elseif ($context['ticket_form']['status'] == TICKET_STATUS_DELETED)
		fatal_lang_error('shd_cannon_edit_deleted', false);

	if (!empty($context['shd_errors']) || !empty($context['ticket_form']['preview'])) // Uh oh, something went wrong, or we're previewing
	{
		checkSubmitOnce('free');

		// Anything else for redisplaying the form
		$context['page_title'] = $txt['shd_helpdesk'];
		$context['sub_template'] = 'ticket_post';

		shd_check_attachments();

		// Set up the fancy editor
		shd_postbox(
			'shd_message',
			un_preparsecode($context['ticket_form']['message']),
			array(
				'post_button' => $context['ticket_form']['form_title'],
			)
		);

		// Build the link tree and navigation
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=main',
			'name' => $txt['shd_linktree_tickets'],
		);
		$context['linktree'][] = array(
			'name' => $new_ticket ? $txt['shd_create_ticket'] : sprintf($txt['shd_edit_ticket_linktree'], $context['ticket_form']['link']),
		);

		checkSubmitOnce('register');
	}
	else
	{
		// It all worked, w00t, so let's get ready to rumble
		$attachIDs = shd_handle_attachments();

		if ($new_ticket)
		{
			// Now to add the ticket details
			$posterOptions = array(
				'id' => $user_info['id'],
			);

			$msgOptions = array(
				'body' => $context['ticket_form']['message'],
				'id' => $context['ticket_form']['msg'],
				'smileys_enabled' => empty($context['ticket_form']['disable_smileys']),
				'attachments' => $attachIDs,
			);

			$ticketOptions = array(
				'id' => $context['ticket_form']['ticket'],
				'mark_as_read' => true,
				'subject' => $context['ticket_form']['subject'],
				'private' => $context['ticket_form']['private']['setting'],
				'status' => $context['ticket_form']['status'],
				'urgency' => $context['ticket_form']['urgency']['setting'],
				'assigned' => $context['ticket_form']['assigned']['id'],
			);
			shd_create_ticket_post($msgOptions, $ticketOptions, $posterOptions);
			shd_clear_active_tickets();

			// Update our nice ticket store with the ticket id
			$context['ticket_id'] = $ticketOptions['id'];
			$context['ticket_form']['ticket'] = $ticketOptions['id'];
		}
		else
		{
			// Only add what has actually changed
			// Now to add the ticket details
			$posterOptions = array();

			$msgOptions = array(
				'id' => $context['ticket_form']['msg'],
				'attachments' => $attachIDs,
			);

			$ticketOptions = array(
				'id' => $context['ticket_form']['ticket'],
			);

			if ((bool) $ticketinfo['smileys_enabled'] == $context['ticket_form']['disable_smileys']) // since one is enabled, one is 'now disable'...
				$msgOptions['smileys_enabled'] = !$context['ticket_form']['disable_smileys'];

			// This things don't trigger modified time
			if ($ticketinfo['private'] != $context['ticket_form']['private']['setting'])
			{
				$ticketOptions['private'] = $context['ticket_form']['private']['setting'];
				// log the change too
				$action = empty($context['ticket_form']['private']['setting']) ? 'marknotprivate' : 'markprivate'; // i.e. based on new setting
				shd_log_action($action,
					array(
						'ticket' => $context['ticket_form']['ticket'],
						'subject' => $context['ticket_form']['subject'],
					)
				);
			}
			if ($ticketinfo['urgency'] != $context['ticket_form']['urgency']['setting'])
			{
				$ticketOptions['urgency'] = $context['ticket_form']['urgency']['setting'];
				// log the change too
				$action = ($context['ticket_form']['urgency']['setting'] > $ticketinfo['urgency']) ? 'urgency_increase' : 'urgency_decrease';
				shd_log_action($action,
					array(
						'ticket' => $context['ticket_form']['ticket'],
						'subject' => $context['ticket_form']['subject'],
						'urgency' => $context['ticket_form']['urgency']['setting'],
					)
				);
			}

			// But these things do!
			if ($ticketinfo['subject'] != $context['ticket_form']['subject'])
				$ticketOptions['subject'] = $context['ticket_form']['subject'];
			if ($ticketinfo['body'] != $context['ticket_form']['message'])
				$msgOptions['body'] = $context['ticket_form']['message'];

			if (isset($ticketOptions['subject']) || isset($msgOptions['body']))
				$msgOptions['modified'] = array(
					'id' => $user_info['id'],
					'name' => $user_info['name'],
					'time' => time(),
				);

			// DOOOOOOOO EEEEEEEEEEET NAO!
			shd_modify_ticket_post($msgOptions, $ticketOptions, $posterOptions);
			shd_clear_active_tickets($ticketinfo['id_member_started']);
		}
		shd_done_posting();
	}
}

function shd_post_reply()
{
	global $context, $user_info, $sourcedir, $txt, $scripturl, $smcFunc, $reply_request, $modSettings, $settings, $options, $memberContext;

	checkSession('get');

	$new_reply = $_REQUEST['sa'] == 'reply';

	// Things we need
	loadTemplate('SimpleDesk-Post');
	require_once($sourcedir . '/Subs-Post.php');
	require_once($sourcedir . '/Subs-SimpleDeskPost.php');
	require_once($sourcedir . '/Subs-Editor.php');

	$ticketinfo = shd_load_ticket();
	$reply = array();

	// So, at this point, we can see it, but no guarantee we can reply to it.
	// Can we reply to any? If so, just go right along. If not, we need to do more work.
	if ($new_reply)
	{
		if (!shd_allowed_to('shd_reply_ticket_any'))
		{
			if (shd_allowed_to('shd_reply_ticket_own'))
			{
				if (!$ticketinfo['is_own'])
					fatal_lang_error('shd_cannot_reply_any_but_own', false);
			}
			else
				fatal_lang_error('shd_cannot_reply_any', false); // can't do nuthin'
		}
	}
	else
	{
		$_REQUEST['msg'] = !empty($_REQUEST['msg']) ? (int) $_REQUEST['msg'] : 0;
		$query = shd_db_query('', '
			SELECT id_msg, id_member, body, modified_time, modified_member, modified_name
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_msg = {int:msg}
				AND id_ticket = {int:ticket}',
			array(
				'msg' => $_REQUEST['msg'],
				'ticket' => $context['ticket_id'],
			)
		);

		if ($smcFunc['db_num_rows']($query) == 0)
		{
			$smcFunc['db_free_result']($query);
			fatal_lang_error('shd_no_ticket', false);
		}

		$reply = $smcFunc['db_fetch_assoc']($query);

		if (!shd_allowed_to('shd_edit_reply_any'))
		{
			if (shd_allowed_to('shd_edit_reply_own'))
			{
				if ($reply['id_member'] != $user_info['id'])
					fatal_lang_error('shd_cannot_edit_reply_any_but_own', false);
			}
			else
				fatal_lang_error('shd_cannot_edit_reply_any', false);
		}

		// Fix the body up for later
		$reply['body'] = un_preparsecode($reply['body']);
		censorText($reply['body']);
	}

	// So it's either our ticket and we can reply to our own, or we can reply to any because we're awesome
	// or we're editing and we can haz such powarz
	$context['ticket_form'] = array( // yes, everything goes in here.
		'form_title' => !empty($reply['id_msg']) ? $txt['shd_ticket_edit_reply'] : $txt['shd_reply_ticket'],
		'form_action' => $scripturl . '?action=helpdesk;sa=savereply',
		'first_msg' => $new_reply ? 0 : $ticketinfo['id_first_msg'],
		'message' => shd_format_text($ticketinfo['body'], $ticketinfo['smileys_enabled'], 'shd_ticket_' . $context['ticket_id']),
		'subject' => $ticketinfo['subject'],
		'ticket' => $context['ticket_id'],
		'msg' => !empty($reply['id_msg']) ? $reply['id_msg'] : 0,
		'ticket_link' => '<a href="' . $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . '">' . $ticketinfo['subject'] . '</a>',
		'reply_link' => $new_reply ? 0 : '<a href="' . $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . '.msg' . $reply['id_msg'] . '#msg' . $reply['id_msg'] . '">' . $txt['response_prefix'] . ' ' . $ticketinfo['subject'] . '</a>',
		'display_id' => str_pad($context['ticket_id'], 5, '0', STR_PAD_LEFT),
		'status' => $ticketinfo['status'],
		'urgency' => array(
			'setting' => $ticketinfo['urgency'],
		),
		'private' => array(
			'setting' => $ticketinfo['private'],
			'can_change' => false,
			'options' => array(
				0 => 'shd_ticket_notprivate',
				1 => 'shd_ticket_private',
			),
		),
		'errors' => array(),
		'member' => array(
			'name' => $ticketinfo['starter_name'],
			'id' => $ticketinfo['starter_id'],
			'link' => shd_profile_link($ticketinfo['starter_name'], $ticketinfo['starter_id']),
		),
		'assigned' => array(
			'id' => $ticketinfo['assigned_id'],
			'name' => !empty($ticketinfo['assigned_id']) ? $ticketinfo['assigned_name'] : $txt['shd_unassigned'],
			'link' => !empty($ticketinfo['assigned_id']) ? shd_profile_link($ticketinfo['assigned_name'], $ticketinfo['assigned_id']) : '<span class="error">' . $txt['shd_unassigned'] . '</span>',
		),
		'num_replies' => !empty($ticketinfo['num_replies']) ? $ticketinfo['num_replies'] : 0,
		'do_attach' => shd_allowed_to('shd_post_attachment'),
		'reply' => !empty($reply['body']) ? $reply['body'] : '',
		'return_to_ticket' => isset($_REQUEST['goback']),
		'disable_smileys' => !$new_reply ? !empty($_REQUEST['no_smileys']) : ($ticketinfo['smileys_enabled'] == 0),
	);

	// Ticket privacy
	if (empty($modSettings['shd_privacy_display']) || $modSettings['shd_privacy_display'] == 'smart')
		$context['display_private'] = shd_allowed_to('shd_view_ticket_private_any') || shd_allowed_to('shd_alter_privacy_own') || shd_allowed_to('shd_alter_privacy_any') || $context['ticket_form']['private']['setting'];
	else
		$context['display_private'] = true;

	loadMemberData($ticketinfo['starter_id']);
	if (loadMemberContext($ticketinfo['starter_id']))
		$context['ticket_form']['member']['avatar'] = $memberContext[$ticketinfo['starter_id']]['avatar'];

	if (!empty($ticketinfo['modified_time']))
	{
		$context['ticket_form'] += array(
			'modified' => array(
				'name' => $ticketinfo['modified_name'],
				'id' => $ticketinfo['modified_id'],
				'time' => timeformat($ticketinfo['modified_time']),
				'link' => shd_profile_link($ticketinfo['modified_name'], $ticketinfo['modified_id']),
			),
		);
	}

	shd_get_urgency_options($ticketinfo['is_own']);
	$context['ticket_form']['urgency']['can_change'] = false;

	if (!empty($ticketinfo['num_replies']))
		shd_setup_replies($ticketinfo['id_first_msg']);

	// A few basic checks
	if ($context['ticket_form']['status'] == TICKET_STATUS_CLOSED)
		fatal_lang_error('shd_cannot_reply_closed', false);
	elseif ($context['ticket_form']['status'] == TICKET_STATUS_DELETED)
		fatal_lang_error('shd_cannon_reply_deleted', false);

	shd_load_attachments();
	shd_check_attachments();

	if (empty($options['no_new_reply_warning']) && isset($_REQUEST['num_replies']))
	{
		$_REQUEST['num_replies'] = (int) $_REQUEST['num_replies'];
		$newReplies = $context['ticket_form']['num_replies'] > $_REQUEST['num_replies'] ? $context['ticket_form']['num_replies'] - $_REQUEST['num_replies'] : 0;

		if (!empty($newReplies))
		{
			loadLanguage('Post');
			if ($newReplies > 1)
				$txt['error_new_replies_reading'] = sprintf($txt['error_new_replies_reading'], $newReplies);

			$context['shd_errors'][] = $newReplies == 1 ? 'new_reply_reading' : 'new_replies_reading';
		}
	}

	// Are we quoting something? Let's see if we do; we already know we can see the ticket
	$_REQUEST['quote'] = !empty($_REQUEST['quote']) ? (int) $_REQUEST['quote'] : 0;
	if (!empty($_REQUEST['quote']))
	{
		$query = shd_db_query('', '
			SELECT hdtr.body, IFNULL(mem.real_name, hdtr.poster_name) AS poster_name, hdtr.poster_time
			FROM {db_prefix}helpdesk_ticket_replies AS hdtr
				LEFT JOIN {db_prefix}members AS mem ON (hdtr.id_member = mem.id_member)
			WHERE id_msg = {int:msg}
				AND id_ticket = {int:ticket}',
			array(
				'msg' => $_REQUEST['quote'],
				'ticket' => $context['ticket_id'], // make sure it's actually in this ticket!
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

			$message = '[quote author=' . $row['poster_name'] . ' link=action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'];
			if ($ticketinfo['id_first_msg'] != $_REQUEST['quote']) // don't add the msg if we're quoting the ticket itself
				$message .= '.msg' . $_REQUEST['quote'] . '#msg' . $_REQUEST['quote'];

			$message .= ' date=' . $row['poster_time'] . ']' . $lb . $row['body'] . $lb . '[/quote]';
			$context['ticket_form']['reply'] = $message;
		}
	}

	// Set up the awesomeness that is the rich editor
	shd_postbox(
		'shd_message',
		$context['ticket_form']['reply'],
		array(
			'post_button' => !empty($reply['id_msg']) ? $txt['shd_ticket_edit_reply'] : $txt['shd_reply_ticket'],
		)
	);

	// Build the link tree and navigation
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=helpdesk;sa=main',
		'name' => $txt['shd_linktree_tickets'],
	);
	$context['linktree'][] = array(
		'name' => $new_reply ? sprintf($txt['shd_reply_ticket_linktree'], $context['ticket_form']['ticket_link']) : sprintf($txt['shd_edit_reply_linktree'], $context['ticket_form']['reply_link']),
	);

	$context['page_title'] = $txt['shd_helpdesk'];
	$context['sub_template'] = 'reply_post';

	// Register this form in the session variables.
	checkSubmitOnce('register');
}

function shd_save_reply()
{
	global $txt, $modSettings, $sourcedir, $context, $scripturl;
	global $user_info, $options, $smcFunc, $memberContext;

	$_REQUEST['msg'] = !empty($_REQUEST['msg']) ? (int) $_REQUEST['msg'] : 0;

	// We're replying so there must be an existing ticket or sumthin's WRONG.
	$ticketinfo = shd_load_ticket();
	$reply = array();
	$new_reply = $_REQUEST['msg'] == 0;

	// So, at this point, we can see it, but no guarantee we can reply to it.
	// Can we reply to any? If so, just go right along. If not, we need to do more work.
	if ($new_reply)
	{
		if (!shd_allowed_to('shd_reply_ticket_any'))
		{
			if (shd_allowed_to('shd_reply_ticket_own'))
			{
				if (!$ticketinfo['is_own'])
					fatal_lang_error('shd_cannot_reply_any_but_own', false);
			}
			else
				fatal_lang_error('shd_cannot_reply_any', false); // can't do nuthin'
		}
	}
	else
	{
		$query = shd_db_query('', '
			SELECT id_msg, id_member, body, modified_time, modified_member, modified_name
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_msg = {int:msg}
				AND id_ticket = {int:ticket}',
			array(
				'msg' => $_REQUEST['msg'],
				'ticket' => $context['ticket_id'],
			)
		);

		if ($smcFunc['db_num_rows']($query) == 0)
		{
			$smcFunc['db_free_result']($query);
			fatal_lang_error('shd_no_ticket', false);
		}

		$reply = $smcFunc['db_fetch_assoc']($query);

		if (!shd_allowed_to('shd_edit_reply_any'))
		{
			if (shd_allowed_to('shd_edit_reply_own'))
			{
				if ($reply['id_member'] != $user_info['id'])
					fatal_lang_error('shd_cannot_edit_reply_any_but_own', false);
			}
			else
				fatal_lang_error('shd_cannot_edit_reply_any', false);
		}
	}

	$context['ticket_form'] = array(
		'form_title' => $new_reply ? $txt['shd_reply_ticket'] : $txt['shd_ticket_edit_reply'],
		'form_action' => $scripturl . '?action=helpdesk;sa=savereply',
		'first_msg' => $new_reply ? 0 : $ticketinfo['id_first_msg'],
		'message' => shd_format_text($ticketinfo['body'], $ticketinfo['smileys_enabled'], 'shd_ticket_' . $context['ticket_id']),
		'subject' => $ticketinfo['subject'],
		'ticket' => $context['ticket_id'],
		'msg' => $_REQUEST['msg'],
		'display_id' => str_pad($context['ticket_id'], 5, '0', STR_PAD_LEFT),
		'urgency' => array(
			'setting' => $ticketinfo['urgency'],
		),
		'private' => array(
			'setting' => $ticketinfo['private'],
			'can_change' => false,
			'options' => array(
				0 => 'shd_ticket_notprivate',
				1 => 'shd_ticket_private',
			),
		),
		'status' => $ticketinfo['status'], // reuse existing status for now
		'assigned' => array(
			'id' => $ticketinfo['assigned_id'],
			'name' => !empty($ticketinfo['assigned_id']) ? $ticketinfo['assigned_name'] : $txt['shd_unassigned'],
			'link' => !empty($ticketinfo['assigned_id']) ? shd_profile_link($ticketinfo['assigned_name'], $ticketinfo['assigned_id']) : '<span class="error">' . $txt['shd_unassigned'] . '</span>',
		),
		'num_replies' => $ticketinfo['num_replies'],
		'do_attach' => shd_allowed_to('shd_post_attachment'),
		'reply' => $_POST['shd_message'],
		'return_to_ticket' => isset($_REQUEST['goback']),
		'disable_smileys' => !empty($_REQUEST['no_smileys']),
	);

	// Ticket privacy
	if (empty($modSettings['shd_privacy_display']) || $modSettings['shd_privacy_display'] == 'smart')
		$context['display_private'] = shd_allowed_to('shd_view_ticket_private_any') || shd_allowed_to('shd_alter_privacy_own') || shd_allowed_to('shd_alter_privacy_any') || $context['ticket_form']['private']['setting'];
	else
		$context['display_private'] = true;

	loadMemberData($ticketinfo['starter_id']);
	if (loadMemberContext($ticketinfo['starter_id']))
		$context['ticket_form']['member']['avatar'] = $memberContext[$ticketinfo['starter_id']]['avatar'];

	if (!empty($ticketinfo['modified_time']))
	{
		$context['ticket_form'] += array(
			'modified' => array(
				'name' => $ticketinfo['modified_name'],
				'id' => $ticketinfo['modified_id'],
				'time' => timeformat($ticketinfo['modified_time']),
				'link' => shd_profile_link($ticketinfo['modified_name'], $ticketinfo['modified_id']),
			),
		);
	}

	if (isset($_REQUEST['preview']))
	{
		$context['ticket_form']['preview'] = array(
			'title' => $txt['shd_previewing_reply'] . ': ' . (empty($context['ticket_form']['subject']) ? '<em>' . $txt['no_subject'] . '</em>' : $context['ticket_form']['subject']),
			'body' => shd_format_text($_POST['shd_message']),
		);
	}

	shd_load_attachments();

	shd_get_urgency_options($ticketinfo['is_own']);
	$context['ticket_form']['urgency']['can_change'] = false;

	if (!empty($ticketinfo['num_replies']))
		shd_setup_replies($ticketinfo['id_first_msg']);

	// A few basic checks
	if ($context['ticket_form']['status'] == TICKET_STATUS_CLOSED)
		fatal_lang_error('shd_cannot_edit_closed', false);
	elseif ($context['ticket_form']['status'] == TICKET_STATUS_DELETED)
		fatal_lang_error('shd_cannon_edit_deleted', false);

	// Have there been any new replies that we missed?
	if (empty($options['no_new_reply_warning']) && isset($_REQUEST['num_replies']))
	{
		$_REQUEST['num_replies'] = (int) $_REQUEST['num_replies'];
		$newReplies = $context['ticket_form']['num_replies'] > $_REQUEST['num_replies'] ? $context['ticket_form']['num_replies'] - $_REQUEST['num_replies'] : 0;

		if (!empty($newReplies))
		{
			loadLanguage('Post');
			if ($newReplies > 1)
				$txt['error_new_replies'] = sprintf($txt['error_new_replies'], $newReplies);

			$context['shd_errors'][] = $newReplies == 1 ? 'new_reply' : 'new_replies';
		}
	}

	if (!empty($context['shd_errors']) || !empty($context['ticket_form']['preview'])) // Uh oh, something went wrong, or we're previewing
	{
		checkSubmitOnce('free');

		// Anything else for redisplaying the form
		$context['page_title'] = $txt['shd_helpdesk'];
		$context['sub_template'] = 'reply_post';

		shd_check_attachments();

		// Set up the fancy editor
		shd_postbox(
			'shd_message',
			un_preparsecode($_POST['shd_message']),
			array(
				'post_button' => $new_reply ? $txt['shd_reply_ticket'] : $txt['shd_ticket_edit_reply'],
			)
		);

		// Build the link tree and navigation
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=main',
			'name' => $txt['shd_linktree_tickets'],
		);
		$context['linktree'][] = array(
			'name' => $txt['shd_reply_ticket'],
		);

		checkSubmitOnce('register');
	}
	else
	{
		// It all worked, w00t, so let's get ready to rumble
		$attachIDs = shd_handle_attachments();
		shd_clear_active_tickets($ticketinfo['id_member_started']);

		if ($new_reply)
		{
			// So... what is the new status?
			$new_status = shd_determine_status('reply', $ticketinfo['starter_id'], $user_info['id']);

			// Now to add the ticket details
			$posterOptions = array(
				'id' => $user_info['id'],
			);

			$msgOptions = array(
				'body' => $_POST['shd_message'],
				'id' => $context['ticket_form']['msg'],
				'smileys_enabled' => empty($context['ticket_form']['disable_smileys']),
				'attachments' => $attachIDs,
			);

			$ticketOptions = array(
				'id' => $context['ticket_form']['ticket'],
				'mark_as_read' => true,
				'status' => $new_status,
			);
			shd_create_ticket_post($msgOptions, $ticketOptions, $posterOptions);
		}
		else
		{
			// Only add what has actually changed
			// Now to add the ticket details
			$posterOptions = array();

			$msgOptions = array(
				'id' => $context['ticket_form']['msg'],
				'attachments' => $attachIDs,
			);

			$ticketOptions = array(
				'id' => $context['ticket_form']['ticket'],
			);

			if ((bool) $ticketinfo['smileys_enabled'] == $context['ticket_form']['disable_smileys']) // since one is enabled, one is 'now disable'...
				$msgOptions['smileys_enabled'] = !$context['ticket_form']['disable_smileys'];

			if ($reply['body'] != $context['ticket_form']['reply'])
				$msgOptions['body'] = $context['ticket_form']['reply'];

			if (isset($msgOptions['body']))
				$msgOptions['modified'] = array(
					'id' => $user_info['id'],
					'name' => $user_info['name'],
					'time' => time(),
				);

			// DOOOOOOOO EEEEEEEEEEET NAO!
			shd_modify_ticket_post($msgOptions, $ticketOptions, $posterOptions);
		}

		shd_done_posting();
	}
}

/**
 *	Redirects the user once a ticket has been posted or replied to.
 *
 *	Directs the user based on where they were and what was selected:
 *	- if 'return to ticket' was not selected, return to the front page
 *	- if it was, and we edited a reply, return to the reply
 *	- if it was select, but it was a new topic/reply, return just to the topic itself
 *
 *	@since 1.0
*/
function shd_done_posting()
{
	global $context;
	if (empty($_REQUEST['goback']))
		redirectexit('action=helpdesk;sa=main');
	elseif (!empty($context['ticket_form']['msg']))
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id'] . '.msg' . $context['ticket_form']['msg'] . '#msg' . $context['ticket_form']['msg'], $context['browser']['is_ie']);
	else
		redirectexit('action=helpdesk;sa=ticket;ticket=' . $context['ticket_id']);
}

function shd_setup_replies($first_msg)
{
	global $reply_request, $context, $smcFunc, $sourcedir, $modSettings, $settings;

	$context['ticket_form']['do_replies'] = false;
	$context['can_quote'] = false;

	// OK, we're done with the ticket's own data. Now for replies.
	$context['get_replies'] = 'shd_prepare_reply_context';
	$query = shd_db_query('', '
		SELECT id_msg, id_member, modified_member
		FROM {db_prefix}helpdesk_ticket_replies
		WHERE id_ticket = {int:ticket}
			AND message_status = {int:msg_normal}
			AND id_msg > {int:first_msg}' . ((empty($context['ticket_form']['msg']) || $context['ticket_form']['msg'] == $context['ticket_form']['first_msg']) ? '' : '
			AND id_msg < {int:reply_msg}') . '
		ORDER BY id_msg DESC
		LIMIT 10',
		array(
			'ticket' => $context['ticket_id'],
			'msg_normal' => MSG_STATUS_NORMAL,
			'first_msg' => $first_msg,
			'reply_msg' => !empty($context['ticket_form']['msg']) ? $context['ticket_form']['msg'] : 0,
		)
	);

	$messages = array();
	$posters = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		if (!empty($row['id_member']))
			$posters[] = $row['id_member'];

		if (!empty($row['modified_member']))
			$posters[] = $row['modified_member'];

		$messages[] = $row['id_msg'];
	}
	$smcFunc['db_free_result']($query);

	$posters = array_unique($posters);

	$context['is_team'] = array();

	if (!empty($messages))
	{
		$context['ticket_form']['do_replies'] = true;

		// Get the poster data
		if (!empty($posters))
		{
			loadMemberData($posters);

			// Are they current team members?
			$team = array_intersect($posters, shd_members_allowed_to('shd_staff'));

			foreach ($team as $member)
				$context['is_team'][$member] = true;
		}

		$reply_request = shd_db_query('', '
			SELECT
				id_msg, poster_time, poster_ip, id_member, modified_time, modified_name, modified_member, body,
				smileys_enabled, poster_name, poster_email
			FROM {db_prefix}helpdesk_ticket_replies
			WHERE id_msg IN ({array_int:message_list})
			ORDER BY id_msg DESC',
			array(
				'message_list' => $messages,
			)
		);

		// Can we have a quote button in the replies? If so, we also need the relevant JS instantiation
		if (!empty($modSettings['shd_allow_ticket_bbc']))
		{
			$context['can_quote'] = true;
			$context['html_headers'] .= '
			<script type="text/javascript"><!-- // --><![CDATA[
			var oQuickReply = new QuickReply({
				bDefaultCollapsed: false,
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
			});
			// ]' . ']></script>';
		}
	}
	else
	{
		$reply_request = false;
		$context['first_message'] = 0;
		$context['first_new_message'] = false;
	}
}

function shd_postbox($id, $message, $buttons, $width = '70%')
{
	global $context, $txt, $modSettings;
	$editorOptions = array(
		'id' => $id,
		'value' => $message,
		'labels' => $buttons,
		'preview_type' => 0,
		'width' => $width,
		'disable_smiley_box' => empty($modSettings['shd_allow_ticket_bbc']) || $context['ticket_form']['disable_smileys'],
	);
	if (empty($modSettings['shd_allow_ticket_bbc']))
		$modSettings['disable_wysiwyg'] = 1;

	// Hide any disabled tags.
	if (!empty($modSettings['shd_enabled_bbc']))
	{
		$enabled_tags = explode(',', $modSettings['shd_enabled_bbc']);
		$disabled_tags = array();

		// Loop through all the tags there are in this forum, and and each disabled tag to our 'hide-list'.
		foreach (parse_bbc(false) AS $tag)
		{
			if (!in_array($tag['tag'], $enabled_tags) || $modSettings['shd_enabled_bbc'] == 'shd_all_tags_disabled')
				$disabled_tags[] = $tag['tag'];
		}

		// Add them to the editors hide var.
		$modSettings['disabledBBC'] = implode(',', $disabled_tags);
	}

	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];

	// Are there any restrictions on uploading attachments?
	if (empty($modSettings['shd_attachments_mode']))
		$modSettings['shd_attachments_mode'] = 'ticket'; // just in case we never actually go to the admin page!!

	$context['allowed_extensions'] = strtr($modSettings['attachmentExtensions'], array(',' => ', '));
	$context['attachment_restrictions'] = array();

	if (!empty($modSettings['attachmentNumPerPostLimit']) && $modSettings['shd_attachments_mode'] != 'ticket')
		$context['attachment_restrictions'][] = sprintf($txt['attach_restrict_attachmentNumPerPostLimit'], $modSettings['attachmentNumPerPostLimit']);

	if (!empty($modSettings['attachmentPostLimit']) && $modSettings['shd_attachments_mode'] != 'ticket')
		$context['attachment_restrictions'][] = sprintf($txt['attach_restrict_attachmentPostLimit'], $modSettings['attachmentPostLimit']);

	if (!empty($modSettings['attachmentSizeLimit']))
		$context['attachment_restrictions'][] = sprintf($txt['attach_restrict_attachmentSizeLimit'], $modSettings['attachmentSizeLimit']);
}

function shd_prepare_reply_context()
{
	global $settings, $txt, $modSettings, $scripturl, $options, $user_info, $smcFunc;
	global $memberContext, $context, $reply_request;

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
		'can_edit' => shd_allowed_to('shd_edit_reply_any') || ($message['id_member'] == $user_info['id'] && shd_allowed_to('shd_edit_reply_own')),
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

function shd_load_attachments()
{
	global $smcFunc, $context, $modSettings;

	if (empty($context['current_attachments']))
		$context['current_attachments'] = array();

	if (empty($modSettings['shd_attachments_mode']))
		$modSettings['shd_attachments_mode'] = 'ticket'; // just in case we never actually go to the admin page!!

	$context['ticket_attach'][$modSettings['shd_attachments_mode']] = array();

	// Get existing attachments
	$query = shd_db_query('', '
		SELECT a.id_attach, a.filename
		FROM {db_prefix}attachments AS a
			INNER JOIN {db_prefix}helpdesk_attachments AS hda ON (a.id_attach = hda.id_attach)
		WHERE ' . ($modSettings['shd_attachments_mode'] == 'ticket' ? 'hda.id_ticket = {int:ticket}' : 'hda.id_msg = {int:msg}') . '
			AND a.attachment_type != {int:thumb}
		ORDER BY hda.id_attach',
		array(
			'msg' => $context['ticket_form']['msg'],
			'ticket' => $context['ticket_id'],
			'thumb' => 3,
		)
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['current_attachments'][] = array(
			'id' => $row['id_attach'],
			'name' => preg_replace('~&amp;#(\\d{1,7}|x[0-9a-fA-F]{1,6});~', '&#\\1;', htmlspecialchars($row['filename'])),
		);

	$smcFunc['db_free_result']($query);
}

function shd_check_attachments()
{
	global $modSettings, $smcFunc, $context, $user_info, $txt;

	if (empty($modSettings['shd_attachments_mode']))
		$modSettings['shd_attachments_mode'] = 'ticket'; // just in case we never actually go to the admin page!!

	if (empty($context['current_attachments']))
		$context['current_attachments'] = array();

	if (shd_allowed_to('shd_post_attachment'))
	{
		if (empty($_SESSION['temp_attachments']))
			$_SESSION['temp_attachments'] = array();

		if (!empty($modSettings['currentAttachmentUploadDir']))
		{
			if (!is_array($modSettings['attachmentUploadDir']))
				$modSettings['attachmentUploadDir'] = unserialize($modSettings['attachmentUploadDir']);

			// Just use the current path for temp files.
			$current_attach_dir = $modSettings['attachmentUploadDir'][$modSettings['currentAttachmentUploadDir']];
		}
		else
			$current_attach_dir = $modSettings['attachmentUploadDir'];

		// If this isn't a new post, check the current attachments.
		if (($modSettings['shd_attachments_mode'] == 'ticket' && !empty($context['ticket_id'])) || isset($context['ticket_form']['msg']))
		{
			$request = shd_db_query('', '
				SELECT COUNT(*), SUM(size)
				FROM {db_prefix}attachments AS a
					INNER JOIN {db_prefix}helpdesk_attachments AS hda ON (a.id_attach = hda.id_attach)
				WHERE ' . ($modSettings['shd_attachments_mode'] == 'ticket' ? 'hda.id_ticket = {int:ticket}' : 'hda.id_msg = {int:msg}') . '
					AND attachment_type = {int:attachment_type}',
				array(
					'msg' => $context['ticket_form']['msg'],
					'ticket' => empty($context['ticket_id']) ? 0 : $context['ticket_id'],
					'attachment_type' => 0,
				)
			);
			list ($quantity, $total_size) = $smcFunc['db_fetch_row']($request);
			$smcFunc['db_free_result']($request);
		}
		else
		{
			$quantity = 0;
			$total_size = 0;
		}

		$temp_start = 0;

		if (!empty($_SESSION['temp_attachments']))
			foreach ($_SESSION['temp_attachments'] as $attachID => $name)
			{
				$temp_start++;

				if (preg_match('~^post_tmp_' . $user_info['id'] . '_\d+$~', $attachID) == 0)
				{
					unset($_SESSION['temp_attachments'][$attachID]);
					continue;
				}

				if (!empty($_POST['attach_del']) && !in_array($attachID, $_POST['attach_del']))
				{
					$deleted_attachments = true;
					unset($_SESSION['temp_attachments'][$attachID]);
					@unlink($current_attach_dir . '/' . $attachID);
					continue;
				}

				$quantity++;
				$total_size += filesize($current_attach_dir . '/' . $attachID);

				$context['current_attachments'][] = array(
					'name' => $name,
					'id' => $attachID,
				);
			}

		if (!empty($_POST['attach_del']))
		{
			$del_temp = array();
			foreach ($_POST['attach_del'] as $i => $dummy)
				$del_temp[$i] = (int) $dummy;

			foreach ($context['current_attachments'] as $k => $dummy)
				if (!in_array($dummy['id'], $del_temp))
				{
					$context['current_attachments'][$k]['unchecked'] = true;
					$deleted_attachments = !isset($deleted_attachments) || is_bool($deleted_attachments) ? 1 : $deleted_attachments + 1;
					$quantity--;
				}
		}

		if (!empty($_FILES))
		{
			$_FILES = array_reverse($_FILES);
			foreach ($_FILES as $uplfile)
			{
				if ($uplfile['name'] == '')
					continue;

				if (!is_uploaded_file($uplfile['tmp_name']) || (@ini_get('open_basedir') == '' && !file_exists($uplfile['tmp_name'])))
				{
					checkSubmitOnce('free');
					fatal_lang_error('attach_timeout', 'critical');
				}

				if (!empty($modSettings['attachmentSizeLimit']) && $uplfile['size'] > $modSettings['attachmentSizeLimit'] * 1024)
				{
					checkSubmitOnce('free');
					fatal_lang_error('file_too_big', false, array($modSettings['attachmentSizeLimit']));
				}

				$quantity++;
				if (!empty($modSettings['attachmentNumPerPostLimit']) && $quantity > $modSettings['attachmentNumPerPostLimit'] && $modSettings['shd_attachments_mode'] != 'ticket')
				{
					checkSubmitOnce('free');
					fatal_lang_error('attachments_limit_per_post', false, array($modSettings['attachmentNumPerPostLimit']));
				}

				$total_size += $uplfile['size'];
				if (!empty($modSettings['attachmentPostLimit']) && $total_size > $modSettings['attachmentPostLimit'] * 1024)
				{
					checkSubmitOnce('free');
					fatal_lang_error('file_too_big', false, array($modSettings['attachmentPostLimit']));
				}

				if (!empty($modSettings['attachmentCheckExtensions']))
				{
					if (!in_array(strtolower(substr(strrchr($uplfile['name'], '.'), 1)), explode(',', strtolower($modSettings['attachmentExtensions']))))
					{
						checkSubmitOnce('free');
						fatal_error($uplfile['name'] . '.<br />' . $txt['cant_upload_type'] . ' ' . $modSettings['attachmentExtensions'] . '.', false);
					}
				}

				if (!empty($modSettings['attachmentDirSizeLimit']))
				{
					// Make sure the directory isn't full.
					$dirSize = 0;
					$dir = @opendir($current_attach_dir) or fatal_lang_error('cant_access_upload_path', 'critical');
					while ($file = readdir($dir))
					{
						if ($file == '.' || $file == '..')
							continue;

						if (preg_match('~^post_tmp_\d+_\d+$~', $file) != 0)
						{
							// Temp file is more than 5 hours old!
							if (filemtime($current_attach_dir . '/' . $file) < time() - 18000)
								@unlink($current_attach_dir . '/' . $file);
							continue;
						}

						$dirSize += filesize($current_attach_dir . '/' . $file);
					}
					closedir($dir);

					// Too big!  Maybe you could zip it or something...
					if ($uplfile['size'] + $dirSize > $modSettings['attachmentDirSizeLimit'] * 1024)
						fatal_lang_error('ran_out_of_space');
				}

				if (!is_writable($current_attach_dir))
					fatal_lang_error('attachments_no_write', 'critical');

				$attachID = 'post_tmp_' . $user_info['id'] . '_' . $temp_start++;
				$_SESSION['temp_attachments'][$attachID] = basename($uplfile['name']);
				$context['current_attachments'][] = array(
					'name' => basename($uplfile['name']),
					'id' => $attachID,
					'approved' => 1,
				);

				$destName = $current_attach_dir . '/' . $attachID;

				if (!move_uploaded_file($uplfile['tmp_name'], $destName))
					fatal_lang_error('attach_timeout', 'critical');
				@chmod($destName, 0644);
			}
		}
	}

	// So, while we're here, how many attachments can we have?
	$context['ticket_form']['num_allowed_attachments'] = empty($modSettings['attachmentNumPerPostLimit']) || $modSettings['shd_attachments_mode'] == 'ticket' ? -1 : $modSettings['attachmentNumPerPostLimit'];
}

function shd_handle_attachments()
{
	global $modSettings, $smcFunc, $context, $user_info, $sourcedir, $txt;

	if (!shd_allowed_to('shd_post_attachment'))
		return;

	if (empty($modSettings['shd_attachments_mode']))
		$modSettings['shd_attachments_mode'] = 'ticket'; // just in case we never actually go to the admin page!!

	$attachIDs = array();

	// Check if they are trying to delete any current attachments....
	if (isset($_POST['attach_del']))
	{
		$del_temp = array();
		foreach ($_POST['attach_del'] as $i => $dummy)
			$del_temp[$i] = (int) $dummy;

		// First, get them from the other table
		$query = shd_db_query('', '
			SELECT a.id_attach
			FROM {db_prefix}attachments AS a
				INNER JOIN {db_prefix}helpdesk_attachments AS hda ON (hda.id_attach = a.id_attach)
			WHERE ' . ($modSettings['shd_attachments_mode'] == 'ticket' ? 'hda.id_ticket = {int:ticket}' : 'hda.id_msg = {int:msg}'),
			array(
				'msg' => $context['ticket_form']['msg'],
				'ticket' => $context['ticket_id'],
			)
		);

		$attachments = array();
		while ($row = $smcFunc['db_fetch_assoc']($query))
			$attachments[] = $row['id_attach'];

		$smcFunc['db_free_result']($query);

		// OK, so attachments = full list of attachments on this post, del_temp is list of ones to keep, so look for the ones that aren't in both lists
		$del_temp = array_diff($attachments, $del_temp);

		if (!empty($del_temp))
		{
			require_once($sourcedir . '/ManageAttachments.php');
			$attachmentQuery = array(
				'attachment_type' => 0,
				'id_msg' => 0,
				'id_attach' => $del_temp,
			);
			removeAttachments($attachmentQuery);
		}
	}

	// ...or attach a new file...
	if (!empty($_FILES) || !empty($_SESSION['temp_attachments']))
	{
		if (!empty($FILES))
			$_FILES = array_reverse($_FILES);

		shd_is_allowed_to('shd_post_attachment');

		// Make sure we're uploading to the right place.
		if (!empty($modSettings['currentAttachmentUploadDir']))
		{
			if (!is_array($modSettings['attachmentUploadDir']))
				$modSettings['attachmentUploadDir'] = unserialize($modSettings['attachmentUploadDir']);

			// The current directory, of course!
			$current_attach_dir = $modSettings['attachmentUploadDir'][$modSettings['currentAttachmentUploadDir']];
		}
		else
			$current_attach_dir = $modSettings['attachmentUploadDir'];

		// If this isn't a new post, check the current attachments.
		if (isset($_REQUEST['msg']) || !empty($context['ticket_id']))
		{
			$request = shd_db_query('', '
				SELECT COUNT(*), SUM(size)
				FROM {db_prefix}attachments AS a
					INNER JOIN {db_prefix}helpdesk_attachments AS hda ON (a.id_attach = hda.id_attach)
				WHERE ' . ($modSettings['shd_attachments_mode'] == 'ticket' ? 'hda.id_ticket = {int:ticket}' : 'hda.id_msg = {int:msg}') . '
					AND attachment_type = {int:attachment_type}',
				array(
					'msg' => $context['ticket_form']['msg'],
					'ticket' => $context['ticket_id'],
					'attachment_type' => 0,
				)
			);
			list ($quantity, $total_size) = $smcFunc['db_fetch_row']($request);
			$smcFunc['db_free_result']($request);
		}
		else
		{
			$quantity = 0;
			$total_size = 0;
		}

		if (!empty($_SESSION['temp_attachments']))
			foreach ($_SESSION['temp_attachments'] as $attachID => $name)
			{
				if (preg_match('~^post_tmp_' . $user_info['id'] . '_\d+$~', $attachID) == 0)
					continue;

				if (!empty($_POST['attach_del']) && !in_array($attachID, $_POST['attach_del']))
				{
					unset($_SESSION['temp_attachments'][$attachID]);
					@unlink($current_attach_dir . '/' . $attachID);
					continue;
				}

				$_FILES['attachment' . $attachID]['tmp_name'] = $attachID;
				$_FILES['attachment' . $attachID]['name'] = $name;
				$_FILES['attachment' . $attachID]['size'] = filesize($current_attach_dir . '/' . $attachID);
				list ($_FILES['attachment' . $attachID]['width'], $_FILES['attachment' . $attachID]['height']) = @getimagesize($current_attach_dir . '/' . $attachID);

				unset($_SESSION['temp_attachments'][$attachID]);
			}

		foreach ($_FILES as $uplfile)
		{
			if ($uplfile['name'] == '')
				continue;

			// Have we reached the maximum number of files we are allowed?
			$quantity++;

			$file_limit = (!empty($modSettings['attachmentNumPerPostLimit']) && $modSettings['shd_attachments_mode'] != 'ticket') ? $modSettings['attachmentNumPerPostLimit'] : $quantity + 1;

			if ($quantity > $file_limit)
			{
				checkSubmitOnce('free');
				fatal_lang_error('attachments_limit_per_post', false, array($modSettings['attachmentNumPerPostLimit']));
			}

			// Check the total upload size for this post...
			$total_size += $uplfile['size'];
			$size_limit = (!empty($modSettings['attachmentPostLimit']) && $modSettings['shd_attachments_mode'] != 'ticket') ? $modSettings['attachmentPostLimit'] * 1024 : $total_size + 1024;

			if ($total_size > $size_limit)
			{
				checkSubmitOnce('free');
				fatal_lang_error('file_too_big', false, array($modSettings['attachmentPostLimit']));
			}

			$attachmentOptions = array(
				'post' => 0,
				'poster' => $user_info['id'],
				'name' => $uplfile['name'],
				'tmp_name' => $uplfile['tmp_name'],
				'size' => $uplfile['size'],
			);

			if (createAttachment($attachmentOptions))
			{
				$attachIDs[] = $attachmentOptions['id'];
				if (!empty($attachmentOptions['thumb']))
					$attachIDs[] = $attachmentOptions['thumb'];
			}
			else
			{
				if (in_array('could_not_upload', $attachmentOptions['errors']))
				{
					checkSubmitOnce('free');
					fatal_lang_error('attach_timeout', 'critical');
				}
				if (in_array('too_large', $attachmentOptions['errors']))
				{
					checkSubmitOnce('free');
					fatal_lang_error('file_too_big', false, array($modSettings['attachmentSizeLimit']));
				}
				if (in_array('bad_extension', $attachmentOptions['errors']))
				{
					checkSubmitOnce('free');
					fatal_error($attachmentOptions['name'] . '.<br />' . $txt['cant_upload_type'] . ' ' . strtr($modSettings['attachmentExtensions'], array(',' => ', ')) . '.', false);
				}
				if (in_array('directory_full', $attachmentOptions['errors']))
				{
					checkSubmitOnce('free');
					fatal_lang_error('ran_out_of_space', 'critical');
				}
				if (in_array('bad_filename', $attachmentOptions['errors']))
				{
					checkSubmitOnce('free');
					fatal_error(basename($attachmentOptions['name']) . '.<br />' . $txt['restricted_filename'] . '.', 'critical');
				}
				if (in_array('taken_filename', $attachmentOptions['errors']))
				{
					checkSubmitOnce('free');
					fatal_lang_error('filename_exists');
				}
			}
		}
	}

	return $attachIDs;
}

?>