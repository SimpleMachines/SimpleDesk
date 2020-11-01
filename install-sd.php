<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2020 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1 RC1                                 *
* File Info: install.php                                      *
**************************************************************/

/**
 *	This script prepares the database for all the tables and other database changes that SimpleDesk requires.
 *
 *	NOTE: This script is meant to run using the <samp><database></database></samp> elements of the package-info.xml file. This is so
 *	that admins have the choice to uninstall any database data installed with the mod. Also, since using the <samp><database></samp>
 *	elements automatically calls on db_extend('packages'), we will only be calling that if we are running this script standalone.
 *
 *	@package installer
 *	@since 1.0
 */

/**
 *	Before attempting to execute, this file attempts to load SSI.php to enable access to the database functions.
*/
global $modSettings, $smcFunc, $txt;
sd_initialize_install();

// Update mod settings if applicable
foreach (sd_get_install_modSettings() as $new_setting => $new_value)
{
	if (empty($modSettings[$new_setting]))
		updateSettings(array($new_setting => $new_value));
}

// Create new tables, if any
foreach (sd_get_install_tables() as $table)
{
	$smcFunc['db_create_table']($table['table_name'], $table['columns'], $table['indexes'], $table['parameters'], $table['if_exists'], $table['error']);

	// Because of issues with SMF at least in 2.0 RC5, users coming from older installs may not have all columns as if_exists => update doesn't appear to work.
	// So, for every column, add it to the columns addition - and let SMF deal with it that way.
	foreach ($table['columns'] as $table_info)
		$columns[] = array(
			'table_name' => $table['table_name'],
			'column_info' => $table_info,
			'parameters' => array(),
			'if_exists' => 'ignore',
			'error' => 'fatal',
		);
}

// Create new rows, if any
foreach (sd_get_install_rows() as $row)
	$smcFunc['db_insert']($row['method'], $row['table_name'], $row['columns'], $row['data'], $row['keys']);

// Create new columns, if any
foreach (sd_get_install_columns() as $column)
	$smcFunc['db_add_column']($column['table_name'], $column['column_info'], $column['parameters'], $column['if_exists'], $column['error']);

// SimpleDesk specific, after schema changes
sd_upgrade_create_depts();
sd_upgrade_recreate_search();
sd_upgrade_fix_last_updated();
sd_upgrade_convert_serialize();
sd_reconfigure_integrate();

// Are we done?
if (SMF == 'SSI')
	echo 'Database changes are complete!';

/*
 * Sets up the installer
 *
 * @since 1.0
*/
function sd_initialize_install()
{
	// If we have found SSI.php and we are outside of SMF, then we are running standalone.
	if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
		require_once(dirname(__FILE__) . '/SSI.php');
	elseif (file_exists(getcwd() . '/SSI.php') && !defined('SMF'))
		require_once(getcwd() . '/SSI.php');
	elseif (!defined('SMF')) // If we are outside SMF and can't find SSI.php, then throw an error
		die('<b>Error:</b> Cannot install - please verify you put this file in the same place as SMF\'s SSI.php.');
	elseif (@version_compare(PHP_VERSION, '5.3.8', '<'))
		die('<b>Error:</b> SimpleDesk 2.1 requires PHP 5.3.8 to be installed on your server.');

	if (SMF == 'SSI')
		db_extend('packages');

	// We have a lot to do. Make sure as best we can that we have the time to do so. But only if the function wasn't disabled.
	if (function_exists('set_time_limit'))
		set_time_limit(600);
}

/*
 * Gets a list of bbc tags, we will use this during the install
 *
 * @since 1.0
*/
function sd_get_bbc_tags()
{
	$bbc_tags = array();
	foreach (parse_bbc(false) as $tag)
		$bbc_tags[] = $tag['tag'];

	return $bbc_tags;
}

/*
 * New modSettings
 *
 * @since 1.0
*/
function sd_get_install_modSettings($getAll = false)
{
	global $modSettings;

	// Here we will update the $modSettings variables.
	$mod_settings = array();
	$new_settings = array(
		'shd_attachments_mode' => 'ticket',
		'shd_staff_badge' => 'nobadge',
		'shd_ticketnav_style' => 'sd',
		'shd_enabled_bbc' => implode(',', sd_get_bbc_tags()), // By default, all available tags are enabled.
		'shd_privacy_display' => 'smart',
		'shd_allow_wikilinks' => 1,
		'shd_display_ticket_logs' => 1,
		'shd_logopt_resolve' => 1,
		'shd_logopt_autoclose' => 1,
		'shd_logopt_assign' => 1,
		'shd_logopt_privacy' => 1,
		'shd_logopt_urgency' => 1,
		'shd_logopt_tickettopicmove' => 1,
		'shd_logopt_cfchanges' => 1,
		'shd_logopt_delete' => 1,
		'shd_logopt_restore' => 1,
		'shd_logopt_permadelete' => 1,
		'shd_logopt_move_dept' => 1,
		'shd_logopt_relationships' => 1,
		'shd_logopt_newposts' => 1,
		'shd_logopt_editposts' => 1,
		'shd_thank_you_post' => 1,
		'shd_zerofill' => 5,
		'shd_notify_log' => 1,
		'shd_notify_with_body' => 1,
		'shd_notify_new_ticket' => 1,
		'shd_notify_new_reply_own' => 1,
		'shd_notify_new_reply_assigned' => 1,
		'shd_notify_new_reply_previous' => 1,
		'shd_notify_new_reply_any' => 1,
		'shd_notify_assign_me' => 1,
		'shd_notify_assign_own' => 1,
	);

	if ($getAll)
		return $new_settings;

	foreach ($new_settings as $k => $v)
		if (!isset($modSettings[$k]))
			$mod_settings[$k] = $v;

	return $mod_settings;
}

/*
 * All the rows we need to add.
 * Anything that shouldn't be set by default won't be in the list. Note that the check is made to isset not empty, because empty values are pre-existing off values, which are not purged from the DB.
 *
 * @since 1.0
*/
function sd_get_install_rows()
{
	global $smcFunc;
	static $current_package_server_url = 'https://www.simpledesk.net/download/plugins/2.0';

	$rows = array();
	$rows[] = array(
		'method' => 'replace',
		'table_name' => '{db_prefix}scheduled_tasks',
		'columns' => array(
			'next_time' => 'int',
			'time_offset' => 'int',
			'time_regularity' => 'int',
			'time_unit' => 'string',
			'disabled' => 'int',
			'task' => 'string',
		),
		'data' => array(
			strtotime('tomorrow'),
			0,
			1,
			'd',
			0,
			'simpledesk',
		),
		'keys' => array('task'),
	);


	// Another row we might want to add is package server. Except we may have to remove a pre-existing plugins one, because the version may be wrong.
	$query = $smcFunc['db_query']('', '
		DELETE FROM {db_prefix}package_servers
		WHERE
			(
				url LIKE {string:plugins_http_wild}
				OR url LIKE {string:plugins_https_wild}
			)
			AND URL != {string:plugins}',
		array(
			'plugins' => $current_package_server_url,
			'plugins_http_wild' => 'http://www.simpledesk.net/download%',
			'plugins_https_wild' => 'https://www.simpledesk.net/download%',
		)
	);

	// Do we have lots of extras?
	$request = $smcFunc['db_query']('', '
		SELECT
			COUNT(url) as total,
			MAX(id_server) AS lastID
		FROM {db_prefix}package_servers
		WHERE url LIKE {string:plugins}',
		array(
			'plugins' => $current_package_server_url,
		)
	);
	$results = $smcFunc['db_fetch_assoc']($request);
	$smcFunc['db_free_result']($request);

	// Get rid of any duplicates.
	if ($results['total'] > 1 && !empty($results['lastID']))
		$query = $smcFunc['db_query']('', '
			DELETE FROM {db_prefix}package_servers
			WHERE
				url LIKE {string:plugins_wild}
				OR url LIKE {string:plugins_https_wild}
				AND id_server != {int:current_server}',
			array(
				'current_server' => $results['lastID'],
				'plugins_wild' => 'http://www.simpledesk.net/download%',
				'plugins_https_wild' => 'https://www.simpledesk.net/download%',
			)
		);
	// No results, need to add a entry.
	elseif (empty($results) || empty($results['total']))
		$rows[] = array(
			'method' => 'insert',
			'table_name' => '{db_prefix}package_servers',
			'columns' => array(
				'name' => 'string',
				'url' => 'string',
			),
			'data' => array(
				'SimpleDesk Plugins',
				$current_package_server_url, // !!! This should be updated in later releases!
			),
			'keys' => array('id_server'),
		);

	return $rows;
}

/*
 * All the columns we need to add to any existing tables.
 *
 * @since 1.0
*/
function sd_get_install_columns()
{
	$columns = array();

	return $columns;
}

/*
 * Gets a list of all the tables we need to install SimpleDesk
 *
 * @since 1.0
*/
function sd_get_install_tables()
{
	global $modSettings;

	// Now, we move on to adding new tables to the database.
	$tables = array();
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_tickets',
		'columns' => array(
			db_field('id_ticket', 'mediumint', 0, true, true),
			db_field('id_dept', 'smallint'),
			db_field('id_first_msg', 'int'),
			db_field('id_member_started', 'mediumint'),
			db_field('id_last_msg', 'int'),
			db_field('id_member_updated', 'mediumint'),
			db_field('id_member_assigned', 'mediumint'),
			db_field('num_replies', 'int'),
			db_field('deleted_replies', 'int'),
			db_field('subject', 'varchar', 100),
			db_field('urgency', 'tinyint'),
			db_field('status', 'tinyint'),
			db_field('private', 'tinyint'),
			db_field('withdeleted', 'tinyint'),
			db_field('last_updated', 'int'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_ticket'),
				'type' => 'primary',
			),
			array(
				'columns' => array('status', 'id_member_assigned'),
				'type' => 'index',
			),
			array(
				'columns' => array('id_member_started', 'private'),
				'type' => 'index',
			),
			array(
				'columns' => array('status', 'withdeleted', 'deleted_replies'),
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_ticket_replies',
		'columns' => array(
			db_field('id_msg', 'int', 0, true, true),
			db_field('id_ticket', 'mediumint'),
			db_field('body', ($modSettings['max_messageLength'] > 65535 ? 'text' : 'mediumtext')),
			db_field('id_member', 'mediumint'),
			db_field('poster_time', 'int'),
			db_field('poster_name', 'varchar', 255),
			db_field('poster_email', 'varchar', 255),
			db_field('poster_ip', 'varchar', 255),
			db_field('modified_time', 'int'),
			db_field('modified_member', 'mediumint'),
			db_field('modified_name', 'varchar', 255),
			db_field('smileys_enabled', 'tinyint'),
			db_field('message_status', 'tinyint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_msg'),
				'type' => 'primary',
			),
			array(
				'columns' => array('id_ticket', 'id_msg', 'message_status'),
				'type' => 'index',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_log_action',
		'columns' => array(
			db_field('id_action', 'int', 0, true, true),
			db_field('log_time', 'int'), // when this happened
			db_field('id_member', 'mediumint'), // person making the event
			db_field('ip', 'varchar', 255), // member's IP
			db_field('action', 'varchar', 30), // defines the message to use
			db_field('id_ticket', 'mediumint'), // ticket it applies to
			db_field('id_msg', 'int'), // msg it applies to
			db_field('extra', 'mediumtext') // json array of params for log message
		),
		'indexes' => array(
			array(
				'columns' => array('id_action'),
				'type' => 'primary',
			),
			array(
				'columns' => array('id_ticket'),
				'type' => 'index',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_log_read',
		'columns' => array(
			db_field('id_ticket', 'mediumint'),
			db_field('id_member', 'mediumint'),
			db_field('id_msg', 'int'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_ticket', 'id_member'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_attachments',
		'columns' => array(
			db_field('id_attach', 'int'),
			db_field('id_ticket', 'mediumint'),
			db_field('id_msg', 'int'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_attach'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_relationships',
		'columns' => array(
			db_field('primary_ticket', 'mediumint'),
			db_field('secondary_ticket', 'mediumint'),
			db_field('rel_type', 'tinyint'),
		),
		'indexes' => array(
			array(
				'columns' => array('primary_ticket', 'secondary_ticket'),
				'type' => 'primary',
			),
			array(
				'columns' => array('primary_ticket', 'rel_type'),
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_custom_fields',
		'columns' => array(
			db_field('id_field', 'smallint', 0, true, true),
			db_field('active', 'tinyint'),
			db_field('field_order', 'smallint'),
			db_field('field_name', 'varchar', 40),
			db_field('field_desc', 'text'),
			db_field('field_loc', 'tinyint'),
			db_field('icon', 'varchar', 20),
			db_field('field_type', 'tinyint'),
			db_field('field_length', 'smallint', 5, true),
			db_field('field_options', 'text'),
			db_field('bbc', 'tinyint'),
			db_field('default_value', 'varchar', 255),
			db_field('can_see', 'varchar', 3),
			db_field('can_edit', 'varchar', 3),
			db_field('display_empty', 'tinyint'),
			db_field('placement', 'tinyint', 0, true),
		),
		'indexes' => array(
			array(
				'columns' => array('id_field', 'active'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_custom_fields_values',
		'columns' => array(
			db_field('id_post', 'int', 0, true, true),
			db_field('id_field', 'smallint'),
			db_field('value', 'text'),
			db_field('post_type', 'int'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_post', 'id_field'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_custom_fields_depts',
		'columns' => array(
			db_field('id_field', 'smallint'),
			db_field('id_dept', 'smallint'),
			db_field('required', 'tinyint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_field', 'id_dept'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_roles',
		'columns' => array(
			db_field('id_role', 'smallint', 0, true, true),
			db_field('template', 'tinyint'),
			db_field('role_name', 'varchar', 80),
		),
		'indexes' => array(
			array(
				'columns' => array('id_role'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_role_groups',
		'columns' => array(
			db_field('id_role', 'smallint'),
			db_field('id_group', 'smallint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_role', 'id_group'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_role_permissions',
		'columns' => array(
			db_field('id_role', 'smallint'),
			db_field('permission', 'varchar', 40),
			db_field('add_type', 'tinyint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_role', 'permission'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_preferences',
		'columns' => array(
			db_field('id_member', 'mediumint'),
			db_field('variable', 'varchar', 30),
			db_field('value', 'text'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_member', 'variable'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_depts',
		'columns' => array(
			db_field('id_dept', 'smallint', 0, true, true),
			db_field('dept_name', 'varchar', 50),
			db_field('description', 'text'),
			db_field('board_cat', 'smallint'),
			db_field('before_after', 'tinyint'),
			db_field('dept_order', 'smallint'),
			db_field('dept_theme', 'tinyint'),
			db_field('autoclose_days', 'smallint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_dept'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_dept_roles',
		'columns' => array(
			db_field('id_role', 'smallint'),
			db_field('id_dept', 'smallint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_role', 'id_dept'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_cannedreplies',
		'columns' => array(
			db_field('id_reply', 'smallint', 0, true, true),
			db_field('id_cat', 'smallint'),
			db_field('title', 'varchar', 80),
			db_field('body', 'text'),
			db_field('vis_user', 'tinyint'),
			db_field('vis_staff', 'tinyint'),
			db_field('reply_order', 'smallint'),
			db_field('active', 'tinyint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_reply'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_cannedreplies_cats',
		'columns' => array(
			db_field('id_cat', 'smallint', 0, true, true),
			db_field('cat_name', 'varchar', 80),
			db_field('cat_order', 'smallint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_cat'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_cannedreplies_depts',
		'columns' => array(
			db_field('id_dept', 'smallint'),
			db_field('id_reply', 'smallint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_dept', 'id_reply'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_notify_override',
		'columns' => array(
			db_field('id_member', 'mediumint'),
			db_field('id_ticket', 'mediumint'),
			db_field('notify_state', 'tinyint'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_member', 'id_ticket'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_search_ticket_words',
		'columns' => array(
			db_field('id_word', 'bigint'),
			db_field('id_msg', 'int'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_word', 'id_msg'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);
	$tables[] = array(
		'table_name' => '{db_prefix}helpdesk_search_subject_words',
		'columns' => array(
			db_field('id_word', 'bigint'),
			db_field('id_ticket', 'int'),
		),
		'indexes' => array(
			array(
				'columns' => array('id_word', 'id_ticket'),
				'type' => 'primary',
			),
		),
		'if_exists' => 'ignore',
		'error' => 'fatal',
		'parameters' => array(),
	);

	return $tables;
}

/*
 * If this is an upgraded 1.0 installation, we won't have any departments. Make sure we create one, if possible using the right language strings
 *
 * @since 2.0
*/
function sd_upgrade_create_depts()
{
	global $smcFunc, $txt;

	loadLanguage('SimpleDesk', 'english', false);
	loadLanguage('SimpleDesk', '', false);

	$query = $smcFunc['db_query']('', 'SELECT COUNT(*) FROM {db_prefix}helpdesk_depts');
	list($count) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);
	if (empty($count))
	{
		$smcFunc['db_insert']('insert',
			'{db_prefix}helpdesk_depts',
			array(
				'dept_name' => 'string', 'board_cat' => 'int', 'description' => 'string', 'before_after' => 'int', 'dept_order' => 'int', 'dept_theme' => 'int',
			),
			array(
				!empty($txt['shd_helpdesk']) ? $txt['shd_helpdesk'] : 'Helpdesk', 0, '', 0, 1, 0,
			),
			array('id_dept')
		);
	}

	// Move any outstanding tickets into the last department we had, which will be the last one we created.
	$query = $smcFunc['db_query']('', 'SELECT MAX(id_dept) FROM {db_prefix}helpdesk_depts');
	list($new_dept) = $smcFunc['db_fetch_row']($query);
	$smcFunc['db_free_result']($query);
	if (!empty($new_dept))
	{
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET id_dept = {int:new_dept}
			WHERE id_dept = {int:old_dept}',
			array(
				'new_dept' => $new_dept,
				'old_dept' => 0,
			)
		);
	}
}

/*
 * Recreate the search index
 *
 * @since 2.0
*/
function sd_upgrade_recreate_search()
{
	global $smcFunc;

	$query = $smcFunc['db_query']('', 'SELECT COUNT(*) FROM {db_prefix}helpdesk_tickets');
	list($count) = $smcFunc['db_fetch_row']($query);
	if (!empty($count))
		updateSettings(array('shd_new_search_index' => 1));
}

/*
 * If we're updating an existing install, we need to make sure there is a normalised value in the last_updated column.
 *
 * @since 2.0
*/
function sd_upgrade_fix_last_updated()
{
	global $smcFunc;

	if ($smcFunc['db_title'] == 'PostgreSQL')
		return;

	$smcFunc['db_query']('', '
	UPDATE {db_prefix}helpdesk_tickets AS hdt, {db_prefix}helpdesk_ticket_replies AS hdtr
	SET hdt.last_updated = hdtr.poster_time
	WHERE hdt.id_last_msg = hdtr.id_msg AND hdt.last_updated = 0');
}

/*
 * Calculates the proper settings to use in a column.
 *
 * @since 1.0
*/
function db_field($name, $type, $size = 0, $unsigned = true, $auto = false)
{
	$fields = array(
		'varchar' => array(
			'auto' => false,
			'type' => 'varchar',
			'size' => $size == 0 ? 50 : $size,
			'null' => false,
		),
		'text' => array(
			'auto' => false,
			'type' => 'text',
			'null' => false,
		),
		'mediumtext' => array(
			'auto' => false,
			'type' => 'mediumtext',
			'null' => false,
		),
		'tinyint' => array(
			'auto' => $auto,
			'type' => 'tinyint',
			'default' => 0,
			'size' => empty($unsigned) ? 4 : 3,
			'unsigned' => $unsigned,
			'null' => false,
		),
		'smallint' => array(
			'auto' => $auto,
			'type' => 'smallint',
			'default' => 0,
			'size' => empty($unsigned) ? 6 : 5,
			'unsigned' => $unsigned,
			'null' => false,
		),
		'mediumint' => array(
			'auto' => $auto,
			'type' => 'mediumint',
			'default' => 0,
			'size' => 8,
			'unsigned' => $unsigned,
			'null' => false,
		),
		'int' => array(
			'auto' => $auto,
			'type' => 'int',
			'default' => 0,
			'size' => empty($unsigned) ? 11 : 10,
			'unsigned' => $unsigned,
			'null' => false,
		),
		'bigint' => array(
			'auto' => $auto,
			'type' => 'bigint',
			'default' => 0,
			'size' => 21,
			'unsigned' => $unsigned,
			'null' => false,
		),
	);

	$field = $fields[$type];
	$field['name'] = $name;

	return $field;
}

/*
 * Converts Seralized to JSON
*/
function sd_upgrade_convert_serialize()
{
	global $smcFunc;

	$seralizeSettings = array();

	// The log actions.
	$seralizeSettings[] = array(
		'table' => 'helpdesk_log_action',
		'id' => 'id_action',
		'column' => 'extra',
	);

	// The log actions.
	$seralizeSettings[] = array(
		'table' => 'helpdesk_custom_fields',
		'id' => 'id_field',
		'column' => 'field_options',
	);


	// Run the upgrader.
	foreach ($seralizeSettings as $tempID => $data)
	{
		$request = $smcFunc['db_query']('', '
			SELECT {raw:idColumn} AS rowID, {raw:valueColumn} AS rowValue
			FROM {db_prefix}{raw:table}
			WHERE {raw:valueColumn} LIKE {string:findSerialize} AND {raw:valueColumn} NOT LIKE {string:findJSON}',
				array(
					'idColumn' => $data['id'],
					'valueColumn' => $data['column'],
					'table' => $data['table'],
					'findSerialize' => 'a:%',
					'findJSON' => '{%',
				)
		);
		while ($row = $smcFunc['db_fetch_assoc']($request))
		{
			$temp = @safe_unserialize($row['rowValue']);

			if ($temp !== false)
			{
				$newValue = json_encode($temp);

				$smcFunc['db_query']('', '
					UPDATE {db_prefix}{raw:table}
					SET {raw:valueColumn} = {string:rowValue}
					WHERE {raw:idColumn} = {int:rowID}',
					array(
						'table' => $data['table'],

						'valueColumn' => $data['column'],
						'rowValue' => $newValue,

						'idColumn' => $data['id'],
						'rowID' => $row['rowID'],
					)
				);
			}
		}
		$smcFunc['db_free_result']($request);

	}
}

// Reconfigure stuff that we disable during uninstall.
function sd_reconfigure_integrate()
{
	global $modSettings;

	// Add the integrate actions, if its still there.
	if (!empty($modSettings['shd_helpdesk_only']))
	{
		add_integration_function('integrate_default_action', 'shd_main', true, '$sourcedir/sd_source/SimpleDesk.php');		
		add_integration_function('integrate_fallback_action', 'shd_main', true, '$sourcedir/sd_source/SimpleDesk.php');		
	}
}