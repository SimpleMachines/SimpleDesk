<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2019 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1 Beta 1                              *
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
function shd_admin_departments()
{
	global $context, $scripturl, $sourcedir, $settings, $txt, $modSettings;

	loadTemplate('sd_template/SimpleDesk-AdminDepartments');

	$subactions = array(
		'main' => 'shd_admin_dept_list',
		'move' => 'shd_admin_dept_move',
		'createdept' => 'shd_admin_create_dept',
		'editdept' => 'shd_admin_edit_dept',
		'savedept' => 'shd_admin_save_dept',
	);

	$context['shd_current_subaction'] = isset($_REQUEST['sa']) && isset($subactions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'main';

	call_user_func($subactions[$context['shd_current_subaction']]);
}

/**
 *	Display a list of all the departments currently in the system, with appropriate navigation to edit or create more.
 *
 *	@since 2.0
 */
function shd_admin_dept_list()
{
	global $context, $txt, $smcFunc;

	$context['page_title'] = $txt['shd_admin_departments_home'];
	$context['sub_template'] = 'shd_departments_home';

	// 1. Get all the departments
	$query = $smcFunc['db_query']('', '
		SELECT hdd.id_dept, hdd.dept_name, hdd.description, hdd.board_cat, c.name AS cat_name, hdd.before_after
		FROM {db_prefix}helpdesk_depts AS hdd
			LEFT JOIN {db_prefix}categories AS c ON (hdd.board_cat = c.id_cat)
		ORDER BY dept_order'
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['shd_departments'][$row['id_dept']] = $row;
	$smcFunc['db_free_result']($query);

	if (empty($context['shd_departments']))
		return;

	// 1a. Make sure to log that a given row is first or last for the move wotsits.
	$context['shd_departments'][key($context['shd_departments'])]['is_first'] = true;
	$context['shd_departments'][end($context['shd_departments'])['id_dept']]['is_last'] = true;

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

function shd_admin_dept_move()
{
	global $context, $smcFunc, $modSettings;

	checkSession('get');

	$_REQUEST['dept'] = isset($_REQUEST['dept']) ? (int) $_REQUEST['dept'] : 0;
	$_REQUEST['direction'] = isset($_REQUEST['direction']) && in_array($_REQUEST['direction'], array('up', 'down')) ? $_REQUEST['direction'] : '';

	$query = shd_db_query('', '
		SELECT id_dept, dept_order
		FROM {db_prefix}helpdesk_depts',
		array()
	);

	if ($smcFunc['db_num_rows']($query) == 0 || empty($_REQUEST['direction']))
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_admin_cannot_move_dept', false);
	}

	$depts = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$depts[$row['dept_order']] = $row['id_dept'];
	ksort($depts);

	$depts_map = array_flip($depts);
	if (empty($depts_map[$_REQUEST['dept']]))
		shd_fatal_lang_error('shd_admin_cannot_move_dept', false);

	$current_pos = $depts_map[$_REQUEST['dept']];
	$destination = $current_pos + ($_REQUEST['direction'] == 'up' ? -1 : 1);

	if (empty($depts[$destination]))
		shd_fatal_lang_error('shd_admin_cannot_move_dept_' . $_REQUEST['direction'], false);

	$other_dept = $depts[$destination];

	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_depts
		SET dept_order = CASE WHEN id_dept = {int:dept} THEN {int:new_pos} ELSE {int:old_pos} END
		WHERE id_dept = {int:dept} OR id_dept = {int:other_dept}',
		array(
			'new_pos' => $destination,
			'dept' => $_REQUEST['dept'],
			'old_pos' => $current_pos,
			'other_dept' => $other_dept,
		)
	);

	// Log this.
	shd_admin_log('admin_dept', array(
		'action' => 'move',
		'id' => $_REQUEST['dept'],
		'direction' => $_REQUEST['direction']
	));

	redirectexit('action=admin;area=helpdesk_depts');
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
			shd_fatal_lang_error('shd_no_dept_name', false);
		else
			$_POST['dept_name'] = strtr($smcFunc['htmlspecialchars']($_POST['dept_name']), array("\r" => '', "\n" => '', "\t" => ''));

		// Now to check the category.
		if (!isset($_POST['dept_cat']) || !isset($context['shd_cat_list'][$_POST['dept_cat']]))
			shd_fatal_lang_error('shd_invalid_category', false);

		$_POST['dept_cat'] = (int) $_POST['dept_cat'];
		$_POST['dept_beforeafter'] = empty($_POST['dept_beforeafter']) || empty($_POST['dept_cat']) ? 0 : 1;
		// Change '1 & 2' to '1 &amp; 2', but not '&amp;' to '&amp;amp;'...
		$_POST['dept_desc'] = empty($_POST['dept_desc']) ? '' : preg_replace('~[&]([^;]{8}|[^;]{0,8}$)~', '&amp;$1', $_POST['dept_desc']);

		// Get the department's order position
		$query = $smcFunc['db_query']('', '
			SELECT MAX(dept_order)
			FROM {db_prefix}helpdesk_depts');
		list($maxdept) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);

		// Create the department
		$newdept = $smcFunc['db_insert']('insert',
			'{db_prefix}helpdesk_depts',
			array('dept_name' => 'string', 'description' => 'string', 'board_cat' => 'int', 'before_after' => 'int', 'dept_order' => 'int',),
			array($_POST['dept_name'], $_POST['dept_desc'], $_POST['dept_cat'], $_POST['dept_beforeafter'], $maxdept + 1,),
			array('id_dept',),
			1
		);

		if (empty($newdept))
			shd_fatal_lang_error('shd_could_not_create_dept', false);

		// Log this.
		shd_admin_log('admin_dept', array(
			'action' => 'add',
			'id' => $newdept,
		));

		// Take them to the edit screen!
		redirectexit('action=admin;area=helpdesk_depts;sa=editdept;dept=' . $newdept);
	}
}

function shd_admin_edit_dept()
{
	global $context, $txt, $smcFunc, $scripturl;

	shd_load_language('sd_language/SimpleDeskPermissions');

	$_REQUEST['dept'] = isset($_REQUEST['dept']) ? (int) $_REQUEST['dept'] : 0;

	// Get the current department
	$query = $smcFunc['db_query']('', '
		SELECT id_dept, dept_name, description, board_cat, before_after, dept_theme, autoclose_days
		FROM {db_prefix}helpdesk_depts
		WHERE id_dept = {int:dept}',
		array(
			'dept' => $_REQUEST['dept'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_unknown_dept', false);
	}
	$context['shd_dept'] = $smcFunc['db_fetch_assoc']($query);
	$context['shd_dept']['description'] = htmlspecialchars($context['shd_dept']['description']);
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

	// Now the role list
	$query = $smcFunc['db_query']('', '
		SELECT id_role, template, role_name
		FROM {db_prefix}helpdesk_roles
		ORDER BY id_role');
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['shd_roles'][$row['id_role']] = $row;
	$smcFunc['db_free_result']($query);

	$query = $smcFunc['db_query']('', '
		SELECT id_role
		FROM {db_prefix}helpdesk_dept_roles
		WHERE id_dept = {int:dept}',
		array(
			'dept' => $_REQUEST['dept'],
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['shd_roles'][$row['id_role']]['in_dept'] = true;
	$smcFunc['db_free_result']($query);

	// And the theme list
	shd_get_dept_theme_list();

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
		SELECT id_dept, dept_name, description, board_cat, before_after
		FROM {db_prefix}helpdesk_depts
		WHERE id_dept = {int:dept}',
		array(
			'dept' => $_REQUEST['dept'],
		)
	);
	if ($smcFunc['db_num_rows']($query) == 0)
	{
		$smcFunc['db_free_result']($query);
		shd_fatal_lang_error('shd_unknown_dept', false);
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
			shd_fatal_lang_error('shd_must_have_dept', false);

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
		$smcFunc['db_free_result']($query);
		if (!empty($count))
			shd_fatal_lang_error('shd_dept_not_empty', false);

		// Before we kill it, get its order position.
		$query = $smcFunc['db_query']('', '
			SELECT dept_order
			FROM {db_prefix}helpdesk_depts
			WHERE id_dept = {int:dept}',
			array(
				'dept' => $_REQUEST['dept'],
			)
		);
		if ($smcFunc['db_num_rows']($query) == 0)
		{
			$smcFunc['db_free_result']($query);
			shd_fatal_lang_error('shd_unknown_dept', false);
		}
		list($dept_order) = $smcFunc['db_fetch_row']($query);
		$smcFunc['db_free_result']($query);

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

		// Make sure to reset all the department orders from after this one.
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_depts
			SET dept_order = dept_order - 1
			WHERE dept_order > {int:old_order}',
			array(
				'old_order' => $dept_order,
			)
		);

		// Log this.
		shd_admin_log('admin_dept', array(
			'action' => 'delete',
			'id' => $_REQUEST['dept'],
		));

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
		shd_fatal_lang_error('shd_no_dept_name', false);
	// 5b. Now to check the category exists and where we're putting it in the category.
	elseif (!isset($_POST['dept_cat']) || !isset($context['shd_cat_list'][$_POST['dept_cat']]))
		shd_fatal_lang_error('shd_invalid_category', false);

	$_POST['dept_name'] = strtr($smcFunc['htmlspecialchars']($_POST['dept_name']), array("\r" => '', "\n" => '', "\t" => ''));
	$_POST['dept_cat'] = (int) $_POST['dept_cat'];
	$_POST['dept_beforeafter'] = empty($_POST['dept_beforeafter']) || empty($_POST['dept_cat']) ? 0 : 1;
	// Change '1 & 2' to '1 &amp; 2', but not '&amp;' to '&amp;amp;'...
	$_POST['dept_desc'] = empty($_POST['dept_desc']) ? '' : preg_replace('~[&]([^;]{8}|[^;]{0,8}$)~', '&amp;$1', $_POST['dept_desc']);

	// 5c. Check the specified theme exists and reset to default if it doesn't.
	shd_get_dept_theme_list();
	$_POST['dept_theme'] = isset($_POST['dept_theme']) && isset($context['dept_theme_list'][$_POST['dept_theme']]) ? (int) $_POST['dept_theme'] : 0;

	$_POST['autoclose_days'] = isset($_POST['autoclose_days']) ? (int) $_POST['autoclose_days'] : 0;
	$_POST['autoclose_days'] = $_POST['autoclose_days'] < 0 ? 0 : ($_POST['autoclose_days'] > 9999 ? 9999 : $_POST['autoclose_days']);

	// 6. Commit that to DB.
	$smcFunc['db_query']('', '
		UPDATE {db_prefix}helpdesk_depts
		SET dept_name = {string:dept_name},
			description = {string:description},
			board_cat = {int:board_cat},
			before_after = {int:before_after},
			dept_theme = {int:dept_theme},
			autoclose_days = {int:autoclose_days}
		WHERE id_dept = {int:id_dept}',
		array(
			'id_dept' => $_REQUEST['dept'],
			'dept_name' => $_POST['dept_name'],
			'description' => $_POST['dept_desc'],
			'board_cat' => $_POST['dept_cat'],
			'before_after' => $_POST['dept_beforeafter'],
			'dept_theme' => $_POST['dept_theme'],
			'autoclose_days' => $_POST['autoclose_days'],
		)
	);

	// 7. Now update the list of roles attached to this department.
	$add = $remove = array();

	// 7a. Get the list of roles and start from there.
	$query = $smcFunc['db_query']('', '
		SELECT id_role
		FROM {db_prefix}helpdesk_roles');
	while ($row = $smcFunc['db_fetch_assoc']($query))
		if (!empty($_POST['role' . $row['id_role']]))
			$add[] = $row['id_role'];
		else
			$remove[] = $row['id_role'];
	$smcFunc['db_free_result']($query);

	// 7b. Any to remove?
	if (!empty($remove))
		$smcFunc['db_query']('', '
			DELETE FROM {db_prefix}helpdesk_dept_roles
			WHERE id_role IN ({array_int:role})
				AND id_dept = {int:dept}',
			array(
				'dept' => $_REQUEST['dept'],
				'role' => $remove,
			)
		);

	// 7c. Any to add?
	if (!empty($add))
	{
		$inserts = array();
		foreach ($add as $add_role)
			$inserts[] = array($add_role, $_REQUEST['dept']);

		$smcFunc['db_insert']('replace',
			'{db_prefix}helpdesk_dept_roles',
			array('id_role' => 'int', 'id_dept' => 'int',),
			$inserts,
			array('id_role', 'id_dept',)
		);
	}

	// Log this.
	shd_admin_log('admin_dept', array(
		'action' => 'update',
		'id' => $_REQUEST['dept'],
	));

	// 8. Thank you and good night.
	redirectexit('action=admin;area=helpdesk_depts');
}

function shd_get_dept_theme_list()
{
	global $txt, $context, $smcFunc;

	$context['dept_theme_list'] = array(
		0 => $txt['shd_dept_theme_use_default'],
	);
	$request = $smcFunc['db_query']('', '
		SELECT id_theme, value
		FROM {db_prefix}themes
		WHERE id_member = {int:member}
			AND id_theme > {int:theme}
			AND variable = {string:name}',
		array(
			'member' => 0,
			'theme' => 0,
			'name' => 'name',
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$context['dept_theme_list'][$row['id_theme']] = $row['value'];
	$smcFunc['db_free_result']($request);
}