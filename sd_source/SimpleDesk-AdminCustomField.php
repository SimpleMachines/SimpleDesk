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

	if (!empty($context['custom_fields']))
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
		'field_type_value' => CFIELD_TYPE_TEXT,
		'field_icons' => shd_admin_cf_icons(),
		'field_icon_value' => '',
	));
/*
	$context += array(
		'sub_template' => 'shd_show_settings',
		'settings_title' => $txt['shd_admin_new_custom_field'],
		'settings_icon' => 'custom_fields.png',
		'config_vars' => array(
			array(
				'type' => 'text',
				'name' => 'field_name',
				'label' => $txt['shd_admin_custom_fields_fieldname'],
				'value' => '',
				'help' => 'shd_admin_custom_fields_fieldname_desc',
			),
			array(
				'type' => 'check',
				'name' => 'active',
				'label' => $txt['shd_admin_custom_fields_active'],
				'value' => true,
				'help' => 'shd_admin_custom_fields_active_desc',
			),
			array(
				'type' => 'large_text',
				'name' => 'field_desc',
				'label' => $txt['shd_admin_custom_fields_fielddesc'],
				'value' => '',
				'help' => 'shd_admin_custom_fields_fielddesc_desc',
				'size' => 4,
			),
			array(
				'type' => 'select',
				'name' => 'field_type',
				'label' => $txt['shd_admin_custom_fields_icon'],
				'value' => '',
				'data' => shd_admin_cf_icons(),
				'help' => 'shd_admin_custom_fields_icon_desc',
			),
			array(
				'type' => 'select',
				'name' => 'field_type',
				'label' => $txt['shd_admin_custom_fields_fieldtype'],
				'value' => 0,
				'data' => array(
					array(CFIELD_TYPE_TEXT, $txt['shd_admin_custom_fields_ui_text']),
					array(CFIELD_TYPE_LARGETEXT, $txt['shd_admin_custom_fields_ui_largetext']),
					array(CFIELD_TYPE_INT, $txt['shd_admin_custom_fields_ui_int']),
					array(CFIELD_TYPE_FLOAT, $txt['shd_admin_custom_fields_ui_float']),
					array(CFIELD_TYPE_SELECT, $txt['shd_admin_custom_fields_ui_select']),
					array(CFIELD_TYPE_CHECKBOX, $txt['shd_admin_custom_fields_ui_checkbox']),
					array(CFIELD_TYPE_RADIO, $txt['shd_admin_custom_fields_ui_radio']),
				),
				'help' => 'shd_admin_custom_fields_fieldtype_desc',
			),
			array(
				'type' => 'select',
				'name' => 'field_type',
				'label' => $txt['shd_admin_custom_fields_visible'],
				'value' => CFIELD_TICKET,
				'data' => array(
					array(CFIELD_TICKET, $txt['shd_admin_custom_fields_visible_ticket']),
					array(CFIELD_REPLY, $txt['shd_admin_custom_fields_visible_field']),
					array((CFIELD_TICKET | CFIELD_REPLY), $txt['shd_admin_custom_fields_visible_both']),
				),
				'help' => 'shd_admin_custom_fields_visible_desc',
			),
		),
		'post_url' => $scripturl . '?action=admin;area=helpdesk_customfield;sa=save',
	);

	foreach ($context['config_vars'] as $key => $item)
	{
		if (!isset($item['javascript']))
			$context['config_vars'][$key]['javascript'] = '';
		if (!isset($item['preinput']))
			$context['config_vars'][$key]['preinput'] = '';
		if (!isset($item['disabled']))
			$context['config_vars'][$key]['disabled'] = false;
		if (!isset($item['invalid']))
			$context['config_vars'][$key]['invalid'] = false;
	}*/
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
	}
	else
	{
		$smcFunc['db_free_result']($query);
		fatal_lang_error('shd_admin_cannot_edit_custom_field', false);
	}
}

/**
 *	Handle saving a new field
 *
 *	@since 1.1
*/
function shd_admin_custom_save()
{
	global $context, $smcFunc, $modSettings;

	checkSession();
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

	return $iconlist;
}

?>