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
# File Info: SimpleDesk-AdminCustomField.php / 1.0 Felidae    #
###############################################################

/**
 *	This file handles the core of SimpleDesk's custom ticket fields interface and code.
 *
 *	@package source
 *	@since 1.1
*/
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	The start point for all interaction with the SimpleDesk custom field administration.
 *
 *	Directed here from the main administration centre, after permission checks and a few dependencies loaded, this deals solely with managing custom fields.
 *
 *	@since 1.1
*/
function shd_admin_custom()
{
	global $context, $scripturl, $sourcedir, $settings, $txt, $modSettings;

	loadTemplate('sd_template/SimpleDesk-AdminCustomField');

	$subactions = array(
		'main' => 'shd_admin_custom_main',
		'new' => 'shd_admin_custom_new',
		'edit' => 'shd_admin_custom_edit',
		'move' => 'shd_admin_custom_move',
		'save' => 'shd_admin_custom_save',
	);

	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subactions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'main';

	$context['field_types'] = array(
		CFIELD_TYPE_TEXT => array($txt['shd_admin_custom_fields_ui_text'], 'text'),
		CFIELD_TYPE_LARGETEXT => array($txt['shd_admin_custom_fields_ui_largetext'], 'largetext'),
		CFIELD_TYPE_INT => array($txt['shd_admin_custom_fields_ui_int'], 'int'),
		CFIELD_TYPE_FLOAT => array($txt['shd_admin_custom_fields_ui_float'], 'float'),
		CFIELD_TYPE_SELECT => array($txt['shd_admin_custom_fields_ui_select'], 'select'),
		CFIELD_TYPE_CHECKBOX => array($txt['shd_admin_custom_fields_ui_checkbox'], 'checkbox'),
		CFIELD_TYPE_RADIO => array($txt['shd_admin_custom_fields_ui_radio'], 'radio'),
	);

	$subactions[$_REQUEST['sa']]();
}

/**
 *	Display all the custom fields, including new/edit/save/delete UI hooks
 *
 *	@since 1.1
*/
function shd_admin_custom_main()
{
	global $context, $smcFunc, $modSettings, $txt;

	$context['custom_fields'] = array();

	$query = shd_db_query('', '
		SELECT id_field, active, field_order, field_name, field_desc, field_loc, icon, field_type
		FROM {db_prefix}helpdesk_custom_fields',
		array()
	);

	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$row['active_string'] = empty($row['active']) ? 'inactive' : 'active';
		$row['field_type'] = $context['field_types'][$row['field_type']][1]; // convert the integer in the DB into the string for language + image uses
		$context['custom_fields'][$row['field_order']] = $row;
	}

	ksort($context['custom_fields']);

	if (!empty($context['custom_fields']) && count($context['custom_fields']) > 1)
	{
		$context['custom_fields'][0]['is_first'] = true;
		$context['custom_fields'][count($context['custom_fields']) - 1]['is_last'] = true;
	}
	// Final stuff before we go.
	$context['page_title'] = $txt['shd_admin_custom_fields'];
	$context['sub_template'] = 'shd_custom_field_home';
}

/**
 *	Display the new field UI
 *
 *	@since 1.1
*/
function shd_admin_custom_new()
{
	global $context, $smcFunc, $modSettings, $txt, $scripturl;

	$context = array_merge($context, array(
		'sub_template' => 'shd_custom_field_edit',
		'page_title' => $txt['shd_admin_new_custom_field'],
		'section_title' => $txt['shd_admin_new_custom_field'],
		'section_desc' => $txt['shd_admin_new_custom_field_desc'],
		'field_type_value' => CFIELD_TYPE_TEXT,
		'field_icons' => shd_admin_cf_icons(),
		'field_icon_value' => '',
		'new_field' => true,
		'field_loc' => CFIELD_TICKET,
	));

}

/**
 *	Display the edit field UI
 *
 *	@since 1.1
*/
function shd_admin_custom_edit()
{
	global $context, $smcFunc, $modSettings, $txt;

	$_REQUEST['field'] = isset($_REQUEST['field']) ? (int) $_REQUEST['field'] : 0;

	$query = shd_db_query('', '
		SELECT id_field, active, field_order, field_name, field_desc, field_loc, icon, field_type
		FROM {db_prefix}helpdesk_custom_fields
		WHERE id_field = {int:field}',
		array(
			'field' => $_REQUEST['field'],
		)
	);

	if ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$smcFunc['db_free_result']($query);
		$context['custom_field'] = $row;
		$context['section_title'] = $txt['shd_admin_edit_custom_field'];
		$context['section_desc'] = $txt['shd_admin_edit_custom_field_desc'];
		$context['page_title'] = $txt['shd_admin_edit_custom_field'];
		$context['sub_template'] = 'shd_custom_field_edit';
		
		$context = array_merge($context, array(
			'field_type_value' => $context['custom_field']['field_type'],
			'field_icons' => shd_admin_cf_icons(),
			'field_icon_value' => $context['custom_field']['icon'],
			'field_loc' => $context['custom_field']['field_loc'],
	));
	}
	else
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_admin_cannot_edit_custom_field', false);
	}
}

/**
 *	Handle saving a field
 *
 *	@since 1.1
*/
function shd_admin_custom_save()
{
	global $context, $smcFunc, $modSettings;

	checkSession();
	
	// Deletifyingistuffithingi?
	if (isset($_POST['delete']))
	{
		$smcFunc['db_query']('', '
			DELETE FROM {db_prefix}helpdesk_custom_fields
			WHERE id_field = {int:field}',
			array(
				'field' => $_REQUEST['field'],
			)
		);
		
		// End of the road
		redirectexit('action=admin;area=helpdesk_customfield;' . $context['session_var'] . '=' . $context['session_id']);
	}
	
	// Aborting mission!
	if (isset($_POST['cancel']))
	{
		redirectexit('action=admin;area=helpdesk_customfield;' . $context['session_var'] . '=' . $context['session_id']);
	}
	
	// Check all the input
	if (!isset($_POST['fieldname']) || $smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST['fieldname'])) === '')
		fatal_lang_error('shd_admin_no_fieldname', false);
	else
		$_POST['fieldname'] = strtr($smcFunc['htmlspecialchars']($_POST['fieldname']), array("\r" => '', "\n" => '', "\t" => ''));
		
	// Ohohoh, we needz to fixz the activenezz
	$_POST['active'] = ($_POST['active'] == 'on' ? '1' : '0');

	// Do I feel a new field being born?
	$smcFunc['db_insert']('insert',
		'{db_prefix}helpdesk_custom_fields',
		array(
			'active' => 'int', 'field_name' => 'string', 'field_desc' => 'string', 'field_loc' => 'int',
			'icon' => 'string', 'field_type' => 'int',
		),
		array(
			'1', $_POST['fieldname'], $_POST['description'], $_POST['cf_fieldvisible'], $_POST['cf_fieldvisible'], 
			$_POST['cf_fieldicon_icon'], $_POST['cf_fieldtype'],
		),
		array(
			'id_field',
		)
	);
	
	$new_field = $smcFunc['db_insert_id']('{db_prefix}helpdesk_custom_fields', 'id_field');
	if (empty($new_field))
		fatal_lang_error('shd_could_not_create_field', false);

	redirectexit('action=admin;area=helpdesk_customfield;' . $context['session_var'] . '=' . $context['session_id']);	
}

/**
 *	Handle moving a custom field up or down
 *
 *	@since 1.1
*/
function shd_admin_custom_move()
{
	global $context, $smcFunc, $modSettings;

	checkSession('get');

	$_REQUEST['field'] = isset($_REQUEST['field']) ? (int) $_REQUEST['field'] : 0;
	$_REQUEST['direction'] = isset($_REQUEST['direction']) && in_array($_REQUEST['direction'], array('up', 'down')) ? $_REQUEST['direction'] : '';

	$query = shd_db_query('', '
		SELECT id_field, field_order
		FROM {db_prefix}helpdesk_custom_fields',
		array()
	);

	if ($smcFunc['db_num_rows']($query) == 0 || empty($_REQUEST['direction']))
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_admin_cannot_move_custom_field', false);
	}

	$fields = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$fields[$row['field_order']] = $row['id_field'];

	ksort($fields);

	$fields_map = array_flip($fields);
	if (empty($fields_map[$_REQUEST['field']]))
		fatal_lang_error('shd_admin_cannot_move_custom_field', false);

	$current_pos = $fields_map[$_REQUEST['field']];
	$destination = $current_pos + ($_REQUEST['direction'] == 'up' ? -1 : 1);

	if (empty($fields[$destination]))
		fatal_lang_error('shd_admin_cannot_move_custom_field_' . $_REQUEST['direction'], false);

	$other_field = $fields[$destination];

	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_custom_fields
		SET field_order = {int:new_pos}
		WHERE id_field = {int:field}',
		array(
			'new_pos' => $destination,
			'field' => $_REQUEST['field'],
		)
	);

	shd_db_query('', '
		UPDATE {db_prefix}helpdesk_custom_fields
		SET field_order = {int:old_pos}
		WHERE id_field = {int:other_field}',
		array(
			'old_pos' => $current_pos,
			'other_field' => $other_field,
		)
	);

	redirectexit('action=admin;area=helpdesk_customfield;' . $context['session_var'] . '=' . $context['session_id']);
}

/**
 *	Get possible icons
 *
 *	@return array A list of possible images for the icon selector (everything in Themes/default/images/simpledesk/cf/ that's an image). Each item in the principle array is an array of value/caption pairs.
 *	@since 1.1
*/
function shd_admin_cf_icons()
{
	global $context, $settings, $txt;
	
	$iconlist = array(
		array('', $txt['shd_admin_custom_fields_none']),
	);

	// Open the directory..
	$dir = dir($settings['default_theme_dir'] . '/images/simpledesk/cf/');
	$files = array();

	if (!$dir)
		return $iconlist;

	while ($line = $dir->read())
		$files[] = $line;
	$dir->close();

	// Sort the results...
	natcasesort($files);

	foreach ($files as $line)
	{
		$filename = substr($line, 0, (strlen($line) - strlen(strrchr($line, '.'))));
		$extension = substr(strrchr($line, '.'), 1);

		// Make sure it is an image.
		if (strcasecmp($extension, 'gif') != 0 && strcasecmp($extension, 'jpg') != 0 && strcasecmp($extension, 'jpeg') != 0 && strcasecmp($extension, 'png') != 0 && strcasecmp($extension, 'bmp') != 0)
			continue;

		$iconlist[] = array(htmlspecialchars($filename. '.' .$extension),htmlspecialchars(str_replace('_', ' ', $filename)));
	}

	return $iconlist;
}

?>