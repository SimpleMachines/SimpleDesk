<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2023 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1.0                                   *
* File Info: SimpleDesk-AdminDepartments.php                  *
**************************************************************/

/**
 *	This file handles the core of SimpleDesk's departmental administration.
 *
 *	@package source
 *	@since 2.0
*/
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	The start point for all interaction with the SimpleDesk departments
 *
 *	@since 2.0
*/
function shd_admin_canned()
{
	global $context, $scripturl, $sourcedir, $settings, $txt, $modSettings;

	loadTemplate('sd_template/SimpleDesk-AdminCannedReplies');

	$subactions = array(
		'main' => 'shd_admin_canned_list',
		'createcat' => 'shd_admin_canned_createcat',
		'movecat' => 'shd_admin_canned_movecat',
		'editcat' => 'shd_admin_canned_editcat',
		'savecat' => 'shd_admin_canned_savecat',
		'createreply' => 'shd_admin_canned_createreply',
		'movereply' => 'shd_admin_canned_movereply',
		'movereplycat' => 'shd_admin_canned_movereplycat',
		'editreply' => 'shd_admin_canned_editreply',
		'savereply' => 'shd_admin_canned_savereply',
	);

	$context['shd_current_subaction'] = isset($_REQUEST['sa']) && isset($subactions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'main';

	call_user_func($subactions[$context['shd_current_subaction']]);
}

/**
 *	Set up displaying all of the canned replies in the main listing.
 *
 *	@since 2.0
*/
function shd_admin_canned_list()
{
	global $context, $smcFunc, $txt;

	$context['page_title'] = $txt['shd_admin_cannedreplies_home'];
	$context['sub_template'] = 'shd_cannedreplies_home';
	$context['canned_replies'] = array();

	// 1. Get all the item/department joins. This could be complicated, so do it this way.
	$reply_depts = array();
	$query = $smcFunc['db_query']('', '
		SELECT hdcrd.id_reply, hdd.dept_name
		FROM {db_prefix}helpdesk_cannedreplies_depts AS hdcrd
			INNER JOIN {db_prefix}helpdesk_depts AS hdd ON (hdcrd.id_dept = hdd.id_dept)
		ORDER BY hdcrd.id_reply, hdd.dept_order'
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$reply_depts[$row['id_reply']][] = $row['dept_name'];

	// 2. Get all the actual categories and all their items.
	$query = $smcFunc['db_query']('', '
		SELECT hdcr.id_reply, hdcr.title, hdcrc.id_cat, hdcrc.cat_name, hdcr.active, hdcr.vis_user, hdcr.vis_staff
		FROM {db_prefix}helpdesk_cannedreplies_cats AS hdcrc
			LEFT JOIN {db_prefix}helpdesk_cannedreplies AS hdcr ON (hdcr.id_cat = hdcrc.id_cat)
		ORDER BY hdcrc.cat_order, hdcr.reply_order'
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		if (!isset($context['canned_replies'][$row['id_cat']]))
			$context['canned_replies'][$row['id_cat']] = array(
				'name' => $row['cat_name'],
				'replies' => array(),
				'move_up' => true,
				'move_down' => true,
			);

		$row['active_string'] = empty($row['active']) ? 'inactive' : 'active';
		$row['move_up'] = true;
		$row['move_down'] = true;
		$row['depts'] = !empty($reply_depts[$row['id_reply']]) ? implode(', ', $reply_depts[$row['id_reply']]) : $txt['shd_none'];

		if (!empty($row['title']))
			$context['canned_replies'][$row['id_cat']]['replies'][] = $row;
	}

	$context['move_between_cats'] = count($context['canned_replies']) > 1;
	$last_cat_id = 0;
	foreach ($context['canned_replies'] as $cat_id => $cat)
	{
		if (!empty($cat['replies']))
		{
			$context['canned_replies'][$cat_id]['replies'][0]['move_up'] = false;
			$context['canned_replies'][$cat_id]['replies'][count($cat['replies']) - 1]['move_down'] = false;
		}
		$context['canned_replies'][$cat_id]['move_up'] &= $context['move_between_cats'];
		$context['canned_replies'][$cat_id]['move_down'] &= $context['move_between_cats'];

		$last_cat_id = $cat_id;
	}

	if (!isset($last_cat_id))
		return;

	$context['canned_replies'][key($context['canned_replies'])]['move_up'] = false;
	$context['canned_replies'][$last_cat_id]['move_down'] = false;
}

/**
 *	Handle moving a category of canned replied up and down.
 *
 *	@since 2.0
*/
function shd_admin_canned_movecat()
{
	global $context, $smcFunc, $modSettings;

	checkSession('get');

	$context['canned_category'] = isset($_REQUEST['cat']) ? (int) $_REQUEST['cat'] : 0;
	$_REQUEST['direction'] = isset($_REQUEST['direction']) && in_array($_REQUEST['direction'], array('up', 'down')) ? $_REQUEST['direction'] : '';

	$query = shd_db_query('', '
		SELECT id_cat, cat_order
		FROM {db_prefix}helpdesk_cannedreplies_cats',
		array()
	);

	if ($smcFunc['db_num_rows']($query) == 0 || empty($_REQUEST['direction']))
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_admin_cannedreplies_cannot_move_cat', false);
	}

	$cats = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$cats[$row['cat_order']] = $row['id_cat'];
	ksort($cats);

	$cats_map = array_flip($cats);
	if (empty($cats_map[$context['canned_category']]))
		shd_fatal_lang_error('shd_admin_cannedreplies_cannot_move_cat', false);

	$current_pos = $cats_map[$context['canned_category']];
	$destination = $current_pos + ($_REQUEST['direction'] == 'up' ? -1 : 1);

	if (empty($cats[$destination]))
		shd_fatal_lang_error('shd_admin_cannedreplies_cannot_move_cat_' . $_REQUEST['direction'], false);

	$other_cat = $cats[$destination];

	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_cannedreplies_cats
		SET
			cat_order = CASE WHEN (id_cat = {int:cat}) THEN {int:new_pos} ELSE {int:old_pos} END
		WHERE id_cat = {int:cat} OR id_cat = {int:other_cat}',
		array(
			'new_pos' => $destination,
			'cat' => $context['canned_category'],
			'other_cat' => $other_cat,
			'old_pos' => $current_pos,
		)
	);

	// Log this action.
	shd_admin_log('admin_canned', array(
		'action' => 'cat_move',
		'id' => $context['canned_category'],
		'direction' => $_REQUEST['direction'] == 'up' ? 'up' : 'down',
	));

	redirectexit('action=admin;area=helpdesk_cannedreplies');
}

/**
 *	Handle moving a reply up and down within its category.
 *
 *	@since 2.0
*/
function shd_admin_canned_movereply()
{
	global $context, $smcFunc, $modSettings;

	checkSession('get');

	$context['canned_reply_id'] = isset($_REQUEST['reply']) ? (int) $_REQUEST['reply'] : 0;
	$_REQUEST['direction'] = isset($_REQUEST['direction']) && in_array($_REQUEST['direction'], array('up', 'down')) ? $_REQUEST['direction'] : '';

	$query = shd_db_query('', '
		SELECT id_reply, reply_order
		FROM {db_prefix}helpdesk_cannedreplies',
		array()
	);

	if ($smcFunc['db_num_rows']($query) == 0 || empty($_REQUEST['direction']))
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_admin_cannedreplies_cannot_move_reply', false);
	}

	$replies = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$replies[$row['reply_order']] = $row['id_reply'];
	ksort($replies);

	$replies_map = array_flip($replies);
	if (empty($replies_map[$context['canned_reply_id']]))
		shd_fatal_lang_error('shd_admin_cannedreplies_cannot_move_reply', false);

	$current_pos = $replies_map[$context['canned_reply_id']];
	$destination = $current_pos + ($_REQUEST['direction'] == 'up' ? -1 : 1);

	if (empty($replies[$destination]))
		shd_fatal_lang_error('shd_admin_cannedreplies_cannot_move_reply_' . $_REQUEST['direction'], false);

	$other_reply = $replies[$destination];

	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_cannedreplies
		SET reply_order = CASE WHEN id_reply = {int:reply} THEN {int:new_pos} ELSE {int:old_pos} END
		WHERE id_reply = {int:reply} OR id_reply = {int:other_reply}',
		array(
			'new_pos' => $destination,
			'reply' => $context['canned_reply_id'],
			'old_pos' => $current_pos,
			'other_reply' => $other_reply,
		)
	);

	// Log this action.
	shd_admin_log('admin_canned', array(
		'action' => 'reply_move',
		'id' => $context['canned_reply_id'],
		'direction' => $_REQUEST['direction'] == 'up' ? 'up' : 'down',
	));

	redirectexit('action=admin;area=helpdesk_cannedreplies');
}

/**
 *	Display the UI for creating a category of canned replies.
 *
 *	@since 2.0
*/
function shd_admin_canned_createcat()
{
	global $context, $smcFunc, $txt;

	$context['page_title'] = $txt['shd_admin_cannedreplies_createcat'];
	$context['sub_template'] = 'shd_edit_canned_category';

	// Setting up for the form. One form, two uses, sneaky, huh.
	$context['canned_category'] = 'new';
	$context['category_name'] = '';
	checkSubmitOnce('register');
}

function shd_admin_canned_editcat()
{
	global $context, $smcFunc, $txt;

	$context['page_title'] = $txt['shd_admin_cannedreplies_editcat'];
	$context['sub_template'] = 'shd_edit_canned_category';

	$context['canned_category'] = isset($_REQUEST['cat']) ? (int) $_REQUEST['cat'] : 0;
	$query = $smcFunc['db_query']('', '
		SELECT cat_name
		FROM {db_prefix}helpdesk_cannedreplies_cats
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $context['canned_category'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_admin_cannedreplies_thecatisalie', false);
	}

	list($context['category_name']) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);
	checkSubmitOnce('register');
}

function shd_admin_canned_savecat()
{
	global $context, $smcFunc, $txt;

	checkSession('request');

	// If we're deleting a category, do it first, get it out the way.
	if (!empty($_POST['delete']))
	{
		$context['canned_category'] = isset($_REQUEST['cat']) ? (int) $_REQUEST['cat'] : 0;
		if ($context['canned_category'] > 0)
		{
			// 1. Get the category's position.
			$query = $smcFunc['db_query']('', '
				SELECT cat_order
				FROM {db_prefix}helpdesk_cannedreplies_cats
				WHERE id_cat = {int:cat}',
				array(
					'cat' => $context['canned_category'],
				)
			);
			if ($smcFunc['db_num_rows']($query) == 0)
				redirectexit('action=admin;area=helpdesk_cannedreplies');

			list($old_pos) = $smcFunc['db_fetch_row']($query);

			// 2. Delete the old category.
			$smcFunc['db_query']('', '
				DELETE FROM {db_prefix}helpdesk_cannedreplies_cats
				WHERE id_cat = {int:cat}',
				array(
					'cat' => $context['canned_category'],
				)
			);
			// 3. Bump everything else up one.
			$smcFunc['db_query']('', '
				UPDATE {db_prefix}helpdesk_cannedreplies_cats
				SET cat_order = cat_order - 1
				WHERE cat_order > {int:old_pos}',
				array(
					'old_pos' => $old_pos,
				)
			);
			// 4. Get all the replies in this category, so we can purge related records.
			$query = $smcFunc['db_query']('', '
				SELECT id_reply
				FROM {db_prefix}helpdesk_cannedreplies
				WHERE id_cat = {int:cat}',
				array(
					'cat' => (int) $context['canned_category'],
				)
			);
			$replies = array();
			while ($row = $smcFunc['db_fetch_row']($query))
				$replies[] = $row[0];
			$smcFunc['db_free_result']($query);

			if (!empty($replies))
			{
				// 5. Remove the dept/reply relationships. (If we have any.)
				$smcFunc['db_query']('', '
					DELETE FROM {db_prefix}helpdesk_cannedreplies_depts
					WHERE id_reply IN ({array_int:replies})',
					array(
						'replies' => $replies,
					)
				);
				// 6. Remove the replies themselves.
				$smcFunc['db_query']('', '
					DELETE FROM {db_prefix}helpdesk_cannedreplies
					WHERE id_reply IN ({array_int:replies})',
					array(
						'replies' => $replies,
					)
				);
			}

			// Log this action.
			shd_admin_log('admin_canned', array(
				'action' => 'cat_delete',
				'id' => $context['canned_category'],
			));
		}

		redirectexit('action=admin;area=helpdesk_cannedreplies');
	}

	$_POST['catname'] = isset($_POST['catname']) ? strtr($smcFunc['htmlspecialchars']($_POST['catname']), array("\r" => '', "\n" => '', "\t" => '')) : '';

	// There are two things we could be doing here. $_POST['cat'] should be set, and it should be set to 'new' for new categories, or a number of an existing category otherwise.
	if (empty($_POST['cat']))
		shd_fatal_lang_error('shd_admin_cannedreplies_thecatisalie', false);
	elseif (empty($_POST['catname']))
		shd_fatal_lang_error('shd_admin_cannedreplies_nocatname', false);

	checkSubmitOnce('check');

	// Otherwise we're doing something with a category.
	if ($_POST['cat'] == 'new')
	{
		$query = $smcFunc['db_query']('', '
			SELECT MAX(cat_order)
			FROM {db_prefix}helpdesk_cannedreplies_cats');
		list($current_max) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);

		// Insert the category.
		$id_cat = $smcFunc['db_insert']('insert',
			'{db_prefix}helpdesk_cannedreplies_cats',
			array('cat_name' => 'string', 'cat_order' => 'int',),
			array($_POST['catname'], (int) $current_max + 1,),
			array('id_cat',),
			1
		);

		// Log this action.
		shd_admin_log('admin_canned', array(
			'action' => 'cat_add',
			'id' => $id_cat,
		));
	}
	else
	{
		// We're updating, apparently.
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_cannedreplies_cats
			SET cat_name = {string:name}
			WHERE id_cat = {int:cat}',
			array(
				'name' => $_POST['catname'],
				'cat' => (int) $_POST['cat'],
			)
		);

		if ($smcFunc['db_affected_rows']() == 0)
			shd_fatal_lang_error('shd_admin_cannedreplies_thecatisalie', false);

		// Log this action.
		shd_admin_log('admin_canned', array(
			'action' => 'cat_update',
			'id' => (int) $_POST['cat'],
		));
	}

	redirectexit('action=admin;area=helpdesk_cannedreplies');
}

/**
 *	Display the UI for creating a new reply.
 *
 *	@since 2.0
*/
function shd_admin_canned_createreply()
{
	global $context, $smcFunc, $txt, $sourcedir, $scripturl;

	$context['page_title'] = $txt['shd_admin_cannedreplies_addreply'];
	$context['sub_template'] = 'shd_edit_canned_reply';

	$context['canned_category'] = isset($_REQUEST['cat']) ? (int) $_REQUEST['cat'] : 0;
	$query = $smcFunc['db_query']('', '
		SELECT cat_name
		FROM {db_prefix}helpdesk_cannedreplies_cats
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $context['canned_category'],
		)
	);

	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_admin_cannedreplies_thecatisalie', false);
	}
	$smcFunc['db_free_result']($query);

	$context['canned_reply'] = array(
		'id' => 'new',
		'title' => '',
		'body' => '',
		'active' => 1,
		'vis_user' => '',
		'vis_staff' => '',
		'cat' => $context['canned_category'],
		'depts_selected' => array(),
		'depts_available' => array(),
	);
	// Now we need to get the possible departments.
	$query = $smcFunc['db_query']('', '
		SELECT id_dept, dept_name
		FROM {db_prefix}helpdesk_depts
		ORDER BY dept_order');
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['canned_reply']['depts_available'][$row['id_dept']] = $row['dept_name'];
	$smcFunc['db_free_result']($query);

	checkSubmitOnce('register');

	require_once($sourcedir . '/Subs-Editor.php');
	$editorOptions = array(
		'id' => 'shd_canned_reply',
		'value' => $context['canned_reply']['body'],
		'labels' => array(
			'post_button' => $txt['shd_admin_cannedreplies_addreply'],
		),
		'preview_type' => 0,
		'width' => '70%',
		'disable_smiley_box' => false,
		'form' => 'cannedreply',
	);
	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];
}

function shd_admin_canned_editreply()
{
	global $context, $smcFunc, $txt, $sourcedir, $scripturl;

	require_once($sourcedir . '/Subs-Editor.php');
	require_once($sourcedir . '/Subs-Post.php');

	$context['page_title'] = $txt['shd_admin_cannedreplies_editreply'];
	$context['sub_template'] = 'shd_edit_canned_reply';

	$context['canned_reply_id'] = isset($_REQUEST['reply']) ? (int) $_REQUEST['reply'] : 0;
	$query = $smcFunc['db_query']('', '
		SELECT hdcr.title, hdcr.body, hdcr.vis_user, hdcr.vis_staff, hdcr.active, hdcr.id_cat
		FROM {db_prefix}helpdesk_cannedreplies AS hdcr
		WHERE id_reply = {int:reply}',
		array(
			'reply' => $context['canned_reply_id'],
		)
	);

	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_admin_cannedreplies_thereplyisalie', false);
	}

	$row = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	$context['canned_reply'] = array(
		'id' => $context['canned_reply_id'],
		'title' => $row['title'],
		'body' => un_preparsecode($row['body']),
		'active' => !empty($row['active']),
		'vis_user' => !empty($row['vis_user']),
		'vis_staff' => !empty($row['vis_staff']),
		'cat' => $row['id_cat'],
		'depts_selected' => array(),
		'depts_available' => array(),
	);

	// Now we need to get the possible departments.
	$query = $smcFunc['db_query']('', '
		SELECT id_dept, dept_name
		FROM {db_prefix}helpdesk_depts
		ORDER BY dept_order');
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['canned_reply']['depts_available'][$row['id_dept']] = $row['dept_name'];
	$smcFunc['db_free_result']($query);

	// Now any departments this reply is attached to.
	$query = $smcFunc['db_query']('', '
		SELECT hdcrd.id_dept
		FROM {db_prefix}helpdesk_cannedreplies_depts AS hdcrd
		WHERE hdcrd.id_reply = {int:reply}',
		array(
			'reply' => $context['canned_reply_id'],
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['canned_reply']['depts_selected'][] = $row['id_dept'];
	$smcFunc['db_free_result']($query);

	checkSubmitOnce('register');

	$editorOptions = array(
		'id' => 'shd_canned_reply',
		'value' => $context['canned_reply']['body'],
		'labels' => array(
			'post_button' => $txt['shd_admin_cannedreplies_editreply'],
		),
		'preview_type' => 0,
		'width' => '70%',
		'disable_smiley_box' => false,
	);
	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];
}

function shd_admin_canned_savereply()
{
	global $context, $smcFunc, $sourcedir, $txt;

	checkSession('request');
	$context['is_ajax_resonse'] = isset($_REQUEST['preview']);

	require_once($sourcedir . '/Subs-Editor.php');
	require_once($sourcedir . '/Subs-Post.php');

	// If we're deleting this reply, do it first and get it out the way.
	$context['canned_reply_id'] = isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'new' ? 'new' : (isset($_REQUEST['reply']) ? (int) $_REQUEST['reply'] : 0);
	if (!empty($_REQUEST['delete']))
	{
		if ($context['canned_reply_id'] > 0)
		{
			// 1. Get the current position.
			$query = $smcFunc['db_query']('', '
				SELECT reply_order
				FROM {db_prefix}helpdesk_cannedreplies
				WHERE id_reply = {int:reply}',
				array(
					'reply' => $context['canned_reply_id'],
				)
			);
			if ($smcFunc['db_num_rows']($query) == 0)
				redirectexit('action=admin;area=helpdesk_cannedreplies');
			list($old_pos) = $smcFunc['db_fetch_row']($query);
			$smcFunc['db_free_result']($query);
			// 2. Delete the reply itself.
			$smcFunc['db_query']('', '
				DELETE FROM {db_prefix}helpdesk_cannedreplies
				WHERE id_reply = {int:reply}',
				array(
					'reply' => $context['canned_reply_id'],
				)
			);
			// 3. Shunt the rest up one.
			$smcFunc['db_query']('', '
				UPDATE {db_prefix}helpdesk_cannedreplies
				SET reply_order = reply_order - 1
				WHERE reply_order > {int:old_pos}',
				array(
					'old_pos' => $old_pos,
				)
			);
			// 4. Delete any attached departments.
			$smcFunc['db_query']('', '
				DELETE FROM {db_prefix}helpdesk_cannedreplies_depts
				WHERE id_reply = {int:reply}',
				array(
					'reply' => $context['canned_reply_id'],
				)
			);

			// Log this action.
			shd_admin_log('admin_canned', array(
					'action' => 'reply_delete',
					'id' => $context['canned_reply_id'],
			));
		}
		redirectexit('action=admin;area=helpdesk_cannedreplies');
	}

	if (empty($context['canned_reply_id']))
		shd_fatal_lang_error('shd_admin_cannedreplies_thereplyisalie', false);

	$_POST['title'] = isset($_POST['title']) ? strtr($smcFunc['htmlspecialchars']($_POST['title']), array("\r" => '', "\n" => '', "\t" => '')) : '';
	if (empty($_POST['title']))
		shd_fatal_lang_error('shd_admin_cannedreplies_notitle', false);

	$_REQUEST['shd_canned_reply'] = isset($_POST['shd_canned_reply']) ? $_POST['shd_canned_reply'] : '';

	// If we came from WYSIWYG, we need to convert from HTML to bbc, then unhtml it.
	if (!empty($_REQUEST['shd_canned_reply_mode']))
	{
		$_REQUEST['shd_canned_reply'] = un_htmlspecialchars(html_to_bbc($_REQUEST['shd_canned_reply']));
		$_POST['shd_canned_reply'] = $_REQUEST['shd_canned_reply'];
	}

	if ($smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST['shd_canned_reply']), ENT_QUOTES) === '')
		shd_fatal_lang_error('shd_admin_cannedreplies_nobody', false);

	$_POST['shd_canned_reply'] = $smcFunc['htmlspecialchars']($_POST['shd_canned_reply'], ENT_QUOTES);
	preparsecode($_POST['shd_canned_reply']);

	// Now clean up the rest of the stuff.
	$_POST['vis_user'] = !empty($_POST['vis_user']) ? 1 : 0;
	$_POST['vis_staff'] = !empty($_POST['vis_staff']) ? 1 : 0;
	$_POST['active'] = !empty($_POST['active']) ? 1 : 0;

	// Verify the destination category exists.
	if (!isset($_POST['cat']))
		shd_fatal_lang_error('shd_admin_cannedreplies_thecatisalie', false);

	$query = $smcFunc['db_query']('', '
		SELECT cat_name
		FROM {db_prefix}helpdesk_cannedreplies_cats
		WHERE id_cat = {int:cat}',
		array(
			'cat' => (int) $_REQUEST['cat'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_admin_cannedreplies_thecatisalie', false);
	}
	$smcFunc['db_free_result']($query);

	// Lastly, figure out what departments we're doing.
	$depts_insert = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_dept
		FROM {db_prefix}helpdesk_depts
		ORDER BY dept_order');
	while ($row = $smcFunc['db_fetch_assoc']($query))
		if (!empty($_POST['dept_' . $row['id_dept']]))
			$depts_insert[] = $row['id_dept'];
	$smcFunc['db_free_result']($query);

	checkSubmitOnce('check');

	// Preview?
	if (isset($_REQUEST['preview']))
	{
		require_once($sourcedir . '/sd_source/SimpleDesk-AjaxHandler.php');

		$context['ajax_return'] = array(
			'success' => true,
			'preview' => shd_format_text($_POST['shd_canned_reply']),
		);
		shd_ajax_json_response();
	}

	if ($context['canned_reply_id'] == 'new')
	{
		// 1. Get the next reply order
		$query = $smcFunc['db_query']('', '
			SELECT MAX(reply_order)
			FROM {db_prefix}helpdesk_cannedreplies');
		list($current_max) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);

		// 2. Insert the row.
		$reply_id = $smcFunc['db_insert']('insert',
			'{db_prefix}helpdesk_cannedreplies',
			array(
				'id_cat' => 'int', 'title' => 'string', 'body' => 'string',
				'vis_user' => 'int', 'vis_staff' => 'int', 'reply_order' => 'int', 'active' => 'int',
			),
			array(
				$_POST['cat'], $_POST['title'], $_POST['shd_canned_reply'],
				$_POST['vis_user'], $_POST['vis_staff'], (int) $current_max + 1, $_POST['active'],
			),
			array('id_cat',),
			1
		);

		// 3. Insert the departments.
		if (empty($reply_id))
			shd_fatal_lang_error('shd_admin_cannedreplies_notcreated', false);

		$inserts = array();
		foreach ($depts_insert as $dept)
			$inserts[] = array($dept, $reply_id);

		$smcFunc['db_insert']('insert',
			'{db_prefix}helpdesk_cannedreplies_depts',
			array('id_dept' => 'int', 'id_reply' => 'int',),
			$inserts,
			array('id_dept', 'id_reply',)
		);

		shd_admin_log('admin_canned', array(
			'action' => 'reply_add',
			'id' => $reply_id,
		));
	}
	else
	{
		// Verify it exists.
		$query = $smcFunc['db_query']('', '
			SELECT id_reply
			FROM {db_prefix}helpdesk_cannedreplies
			WHERE id_reply = {int:reply}',
			array(
				'reply' => $context['canned_reply_id'],
			)
		);
		if ($smcFunc['db_num_rows']($query) == 0)
			shd_fatal_lang_error('shd_admin_cannedreplies_thereplyisalie', false);
		$smcFunc['db_free_result']($query);

		// We're updating, apparently.
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_cannedreplies
			SET title = {string:title},
				body = {string:body},
				vis_user = {int:vis_user},
				vis_staff = {int:vis_staff},
				active = {int:active}
			WHERE id_reply = {int:reply}',
			array(
				'reply' => $context['canned_reply_id'],
				'title' => $_POST['title'],
				'body' => $_POST['shd_canned_reply'],
				'vis_user' => $_POST['vis_user'],
				'vis_staff' => $_POST['vis_staff'],
				'active' => $_POST['active'],
			)
		);

		// Sort out departments. Nuke the existing ones first.
		$smcFunc['db_query']('', '
			DELETE FROM {db_prefix}helpdesk_cannedreplies_depts
			WHERE id_reply = {int:reply}',
			array(
				'reply' => $context['canned_reply_id'],
			)
		);

		$inserts = array();
		foreach ($depts_insert as $dept)
			$inserts[] = array($dept, $context['canned_reply_id']);

		$smcFunc['db_insert']('insert',
			'{db_prefix}helpdesk_cannedreplies_depts',
			array('id_dept' => 'int', 'id_reply' => 'int',),
			$inserts,
			array('id_dept', 'id_reply',)
		);

		shd_admin_log('admin_canned', array(
			'action' => 'reply_update',
			'id' => $context['canned_reply_id'],
		));
	}

	redirectexit('action=admin;area=helpdesk_cannedreplies');
}

function shd_admin_canned_movereplycat()
{
	global $context, $smcFunc, $txt, $sourcedir, $scripturl;

	// Before we go any further, establish that the user specified a reply to move and that there is at least one category not including the one the reply is in.
	$context['canned_reply_id'] = isset($_REQUEST['reply']) ? (int) $_REQUEST['reply'] : 0;
	if (empty($context['canned_reply_id']) || $context['canned_reply_id'] < 0)
		shd_fatal_lang_error('shd_admin_cannedreplies_thereplyisalie', false);

	$query = $smcFunc['db_query']('', '
		SELECT id_cat, reply_order
		FROM {db_prefix}helpdesk_cannedreplies
		WHERE id_reply = {int:reply}',
		array(
			'reply' => $context['canned_reply_id'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
		shd_fatal_lang_error('shd_admin_cannedreplies_thereplyisalie', false);

	list($current_cat, $current_reply_pos) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);

	// So, the reply exists. Now to check categories. We need to verify it regardless of calling context here, so might as well get the entire table.
	$context['cannedreply_cats'] = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_cat, cat_name
		FROM {db_prefix}helpdesk_cannedreplies_cats
		WHERE id_cat != {int:current_cat}
		ORDER BY cat_order',
		array(
			'current_cat' => $current_cat,
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
		shd_fatal_lang_error('shd_admin_cannedreplies_onlyonecat', false);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['cannedreply_cats'][$row['id_cat']] = $row['cat_name'];
	$smcFunc['db_free_result']($query);

	// So, either we're moving, or we're displaying the form. Either way, it's time to make that decision.
	if (empty($_GET['part']) || $_GET['part'] != '2')
	{
		$context['page_title'] = $txt['shd_admin_cannedreplies_move_between_cat'];
		$context['sub_template'] = 'shd_move_reply_cat';

		checkSubmitOnce('register');
	}
	else
	{
		// OK, so they're moving. We know the reply exists, we know the possible list of departments they can move to.
		// 1. Is the new department valid?
		$_REQUEST['newcat'] = isset($_REQUEST['newcat']) ? (int) $_REQUEST['newcat'] : 0;
		if (!isset($context['cannedreply_cats'][$_REQUEST['newcat']]))
			shd_fatal_lang_error('shd_admin_cannedreplies_destnoexist', false);

		// 1a. Everything is valid, just double check it's not a random double submission.
		checkSubmitOnce('check');

		// 2. Everything's OK. Figure out where the reply will move to in the new category.
		$query = $smcFunc['db_query']('', '
			SELECT MAX(reply_order)
			FROM {db_prefix}helpdesk_cannedreplies
			WHERE id_cat = {int:newcat}',
			array(
				'newcat' => $_REQUEST['newcat'],
			)
		);
		list($newpos) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);

		// 3. Move the reply.
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_cannedreplies
			SET id_cat = {int:newcat},
				reply_order = {int:newpos}
			WHERE id_reply = {int:reply}',
			array(
				'newcat' => $_REQUEST['newcat'],
				'newpos' => (int) $newpos + 1,
				'reply' => $context['canned_reply_id'],
			)
		);

		// 4. Shunt the rest back down.
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_cannedreplies
			SET reply_order = reply_order - 1
			WHERE id_cat = {int:current_cat}
				AND reply_order > {int:current_pos}',
			array(
				'current_cat' => $current_cat,
				'current_pos' => $current_reply_pos,
			)
		);

		// 5. Log this action.
		shd_admin_log('admin_canned', array(
			'action' => 'reply_move',
			'id' => $context['canned_reply_id'],
		));

		// 6. Scram.
		redirectexit('action=admin;area=helpdesk_cannedreplies');
	}
}