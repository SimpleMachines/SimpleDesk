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
# File Info: SimpleDesk-AdminDepartments.php / 1.0 Felidae    #
###############################################################

/**
 *	This file handles the core of SimpleDesk's departmental administration.
 *
 *	@package source
 *	@since 1.1
*/
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	The start point for all interaction with the SimpleDesk departments
 *
 *	@since 1.1
*/
function shd_admin_departments()
{
	global $context, $scripturl, $sourcedir, $settings, $txt, $modSettings;

	loadTemplate('sd_template/SimpleDesk-AdminDepartments');

	$subactions = array(
		'main' => 'shd_admin_dept_list',
		'createdept' => 'shd_admin_create_dept',
		'editdept' => 'shd_admin_edit_dept',
		'savedept' => 'shd_admin_save_dept',
	);

	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subactions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'main';

	$subactions[$_REQUEST['sa']]();
}

/**
 *	Display a list of all the departments currently in the system, with appropriate navigation to edit or create more.
 *
 *	@since 1.1
 */
function shd_admin_dept_list()
{
	global $context, $txt, $smcFunc;

	$context['page_title'] = $txt['shd_admin_departments_home'];
	$context['sub_template'] = 'shd_departments_home';

	// 1. Get all the departments
	$query = $smcFunc['db_query']('', '
		SELECT hdd.id_dept, hdd.dept_name, hdd.board_cat, c.name AS cat_name, hdd.before_after
		FROM {db_prefix}helpdesk_depts AS hdd
			LEFT JOIN {db_prefix}categories AS c ON (hdd.board_cat = c.id_cat)
		ORDER BY id_dept'
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['shd_departments'][$row['id_dept']] = $row;
	$smcFunc['db_free_result']($query);

	// 2. Just for niceness, get all the helpdesk roles attached to each department.
	$query = $smcFunc['db_query']('', '
		SELECT hddr.id_dept, hddr.id_role, hdr.template, hdr.role_name
		FROM {db_prefix}helpdesk_dept_roles AS hddr
			INNER JOIN {db_prefix}helpdesk_roles AS hdr ON (hddr.id_role = hdr.id_role)
		ORDER BY hddr.id_dept, hddr.id_role'
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['shd_departments'][$row['id_dept']]['roles'][$row['id_role']] = $row;
	$smcFunc['db_free_result']($query);
}

function shd_admin_create_dept()
{
	global $context, $txt, $smcFunc;

	$context['shd_cat_list'] = array(
		0 => $txt['shd_boardindex_cat_none'],
	);
	$request = $smcFunc['db_query']('', '
		SELECT id_cat, name
		FROM {db_prefix}categories
		ORDER BY cat_order');
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$context['shd_cat_list'][$row['id_cat']] = $row['name'];
	$smcFunc['db_free_result']($request);

	if (empty($_REQUEST['part']))
	{
		$context['page_title'] = $txt['shd_create_dept'];
		$context['sub_template'] = 'shd_create_dept';
		checkSubmitOnce('register');
	}
	else
	{
		checkSubmitOnce('check');
		checkSession();

		// Boring stuff like session checks done. Were you a naughty admin and didn't set it properly?
		if (!isset($_POST['dept_name']) || $smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST['dept_name'])) === '')
			fatal_lang_error('shd_no_dept_name', false);
		else
			$_POST['dept_name'] = strtr($smcFunc['htmlspecialchars']($_POST['dept_name']), array("\r" => '', "\n" => '', "\t" => ''));

		// Now to check the category.
		if (!isset($_POST['dept_cat']) || !isset($context['shd_cat_list'][$_POST['dept_cat']]))
			fatal_lang_error('shd_invalid_category', false);
		else
			$_POST['dept_cat'] = (int) $_POST['dept_cat'];

		$_POST['dept_beforeafter'] = empty($_POST['dept_beforeafter']) || empty($_POST['dept_cat']) ? 0 : 1;

		// Create the department
		$smcFunc['db_insert']('insert',
			'{db_prefix}helpdesk_depts',
			array(
				'dept_name' => 'string', 'board_cat' => 'int', 'before_after' => 'int',
			),
			array(
				$_POST['dept_name'], $_POST['dept_cat'], $_POST['dept_beforeafter'],
			),
			array(
				'id_dept',
			)
		);

		$newdept = $smcFunc['db_insert_id']('{db_prefix}helpdesk_depts', 'id_dept');
		if (empty($newdept))
			fatal_lang_error('shd_could_not_create_dept', false);

		// Take them to the edit screen!
		redirectexit('action=admin;area=helpdesk_depts;sa=editdept;dept=' . $newdept);
	}
}

function shd_admin_edit_dept()
{
	global $context, $txt, $smcFunc, $scripturl;

	$_REQUEST['dept'] = isset($_REQUEST['dept']) ? (int) $_REQUEST['dept'] : 0;

	// Get the current department
	$query = $smcFunc['db_query']('', '
		SELECT id_dept, dept_name, board_cat, before_after
		FROM {db_prefix}helpdesk_depts
		WHERE id_dept = {int:dept}',
		array(
			'dept' => $_REQUEST['dept'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_unknown_dept', false);
	}
	$context['shd_dept'] = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	// Get the category list
	$context['shd_cat_list'] = array(
		0 => $txt['shd_boardindex_cat_none'],
	);
	$request = $smcFunc['db_query']('', '
		SELECT id_cat, name
		FROM {db_prefix}categories
		ORDER BY cat_order');
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$context['shd_cat_list'][$row['id_cat']] = $row['name'];
	$smcFunc['db_free_result']($request);

	$context['page_title'] = $txt['shd_edit_dept'];
	$context['sub_template'] = 'shd_edit_dept';
}

function shd_admin_save_dept()
{
	global $context, $txt, $smcFunc, $scripturl;

	// 1. Check they've come from this session
	checkSession();

	// 2. Check it's a valid department.
	$_REQUEST['dept'] = isset($_REQUEST['dept']) ? (int) $_REQUEST['dept'] : 0;
	$query = $smcFunc['db_query']('', '
		SELECT id_dept, dept_name, board_cat, before_after
		FROM {db_prefix}helpdesk_depts
		WHERE id_dept = {int:dept}',
		array(
			'dept' => $_REQUEST['dept'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_unknown_dept', false);
	}
	$context['shd_dept'] = $smcFunc['db_fetch_assoc']($query);
	$smcFunc['db_free_result']($query);

	// 3. We might be deleting. If so, do our business and exit stage left.
	if (isset($_POST['delete']))
	{
		// OK, so how many categories are there? If there's only one, we can't delete it.
		$query = $smcFunc['db_query']('', '
			SELECT COUNT(*)
			FROM {db_prefix}helpdesk_depts');
		list($count) = $smcFunc['db_fetch_row']($query);
		if ($count == 1)
			fatal_lang_error('shd_must_have_dept', false);

		// What about it having tickets in it?
		$query = $smcFunc['db_query']('', '
			SELECT COUNT(id_ticket)
			FROM {db_prefix}helpdesk_tickets
			WHERE id_dept = {int:dept}',
			array(
				'dept' => $_REQUEST['dept'],
			)
		);
		list($count) = $smcFunc['db_fetch_row']($query);
		if (!empty($count))
			fatal_lang_error('shd_dept_not_empty', false);

		// Oops, bang you're dead.
		$smcFunc['db_query']('', '
			DELETE FROM {db_prefix}helpdesk_depts
			WHERE id_dept = {int:dept}',
			array(
				'dept' => $_REQUEST['dept'],
			)
		);

		$smcFunc['db_query']('', '
			DELETE FROM {db_prefix}helpdesk_dept_roles
			WHERE id_dept = {int:dept}',
			array(
				'dept' => $_REQUEST['dept'],
			)
		);

		// Bat out of hell
		redirectexit('action=admin;area=helpdesk_depts');
	}

	// 4. Get the list of categories, so we can validate that in a moment.
	$context['shd_cat_list'] = array(
		0 => $txt['shd_boardindex_cat_none'],
	);
	$request = $smcFunc['db_query']('', '
		SELECT id_cat, name
		FROM {db_prefix}categories
		ORDER BY cat_order');
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$context['shd_cat_list'][$row['id_cat']] = $row['name'];
	$smcFunc['db_free_result']($request);

	// 5. Get the stuff in the form.
	// 5a. That there's something in the dept. name
	if (!isset($_POST['dept_name']) || $smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST['dept_name'])) === '')
		fatal_lang_error('shd_no_dept_name', false);
	else
		$_POST['dept_name'] = strtr($smcFunc['htmlspecialchars']($_POST['dept_name']), array("\r" => '', "\n" => '', "\t" => ''));

	// 5b. Now to check the category exists and where we're putting it in the category.
	if (!isset($_POST['dept_cat']) || !isset($context['shd_cat_list'][$_POST['dept_cat']]))
		fatal_lang_error('shd_invalid_category', false);
	else
		$_POST['dept_cat'] = (int) $_POST['dept_cat'];

	$_POST['dept_beforeafter'] = empty($_POST['dept_beforeafter']) || empty($_POST['dept_cat']) ? 0 : 1;

	// 6. Commit that to DB.
	$smcFunc['db_query']('', '
		UPDATE {db_prefix}helpdesk_depts
		SET dept_name = {string:dept_name},
			board_cat = {int:board_cat},
			before_after = {int:before_after}
		WHERE id_dept = {int:id_dept}',
		array(
			'id_dept' => $_REQUEST['dept'],
			'dept_name' => $_POST['dept_name'],
			'board_cat' => $_POST['dept_cat'],
			'before_after' => $_POST['dept_beforeafter'],
		)
	);

	// 7. Thank you and good night.
	redirectexit('action=admin;area=helpdesk_depts');
}
?>