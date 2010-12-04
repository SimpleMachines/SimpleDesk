<?php
###########################################################
#       Simple Desk Project - www.simpledesk.net          #
###########################################################
#     An advanced help desk modifcation built on SMF      #
###########################################################
#                                                         #
#       * Copyright 2010 - SimpleDesk.net                 #
#                                                         #
# This file and its contents are subject to the license   #
# included with this distribution, license.txt, which     #
# states that this software is New BSD Licensed.          #
# Any questions, please contact SimpleDesk.net            #
#                                                         #
###########################################################
# SimpleDesk Version: 1.0 Felidae                         #
# File Info: install.php / 1.0 Felidae                    #
###########################################################

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

// If we have found SSI.php and we are outside of SMF, then we are running standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF')) // If we are outside SMF and can't find SSI.php, then throw an error
	die('<b>Error:</b> Cannot install - please verify you put this file in the same place as SMF\'s SSI.php.');

if (SMF == 'SSI')
	db_extend('packages');

global $modSettings, $smcFunc;

// For our BBC settings, we first fetch a list off all BBC tags there are.
$bbc_tags = array();
foreach (parse_bbc(false) AS $tag)
	$bbc_tags[] = $tag['tag'];

// Here we will update the $modSettings variables.
$mod_settings = array(
	'shd_attachments_mode' => 'ticket',
	'shd_staff_badge' => 'nobadge',
	'shd_ticketnav_style' => 'sd',
	'shd_enabled_bbc' => implode(',', $bbc_tags),	// By default, all available tags are enabled.
	'shd_privacy_display' => 'smart',
);

if (empty($modSettings['shd_attachments_mode']))
{
	// If this is set, SD has been installed before, so this shouldn't be run; this is only for new installs.
	$mod_settings += array(
		'shd_allow_wikilinks' => 1,
		'shd_display_ticket_logs' => 1,
		'shd_logopt_resolve' => 1,
		'shd_logopt_assign' => 1,
		'shd_logopt_privacy' => 1,
		'shd_logopt_urgency' => 1,
		'shd_logopt_tickettopicmove' => 1,
		'shd_logopt_delete' => 1,
		'shd_logopt_restore' => 1,
		'shd_logopt_permadelete' => 1,
		'shd_logopt_relationships' => 1,
		'shd_logopt_newposts' => 1,
		'shd_logopt_editposts' => 1,
		'shd_logopt_split' => 1,
		'shd_thank_you_post' => 1,
	);
}
// shd_disable_tickettotopic, shd_maintenance_mode should not be added because it's empty by default!

// Now, we move on to adding new tables to the database.
$tables = array();
$tables[] = array(
	'table_name' => '{db_prefix}helpdesk_tickets',
	'columns' => array(
		db_field('id_ticket', 'mediumint', 0, true, true),
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
	'if_exists' => 'update',
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
	'if_exists' => 'update',
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
		db_field('extra', 'mediumtext') // serialised array of params for log message
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
	'if_exists' => 'update',
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
	'if_exists' => 'update',
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
	'if_exists' => 'update',
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
	'if_exists' => 'update',
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
		db_field('field_desc', 'varchar', 255),
		db_field('field_loc', 'tinyint'),
		db_field('icon', 'varchar', 20),
		db_field('field_type', 'tinyint'),
		db_field('field_length', 'smallint', 5, 255),
		db_field('field_options', 'text'),
		db_field('bbc', 'tinyint'),
		db_field('default_value', 'varchar', 255),
		db_field('can_see', 'varchar', 3, '0,0'),
		db_field('can_edit', 'varchar', 3, '0,0'),
		db_field('display_empty', 'tinyint'),
		db_field('required', 'tinyint'),		
		db_field('placement', 'tinyint', 0, 1),			
	),
	'indexes' => array(
		array(
			'columns' => array('id_field', 'active'),
			'type' => 'primary',
		),
	),
	'if_exists' => 'update',
	'error' => 'fatal',
	'parameters' => array(),
);
$tables[] = array(
	'table_name' => '{db_prefix}helpdesk_custom_fields_values',
	'columns' => array(
		db_field('id_post', 'int', 0, true, true),
		db_field('id_field', 'int'),
		db_field('value', 'text'),
		db_field('post_type', 'int'),	
	),
	'indexes' => array(
		array(
			'columns' => array('id_post'),
			'type' => 'primary',
		),
	),
	'if_exists' => 'update',
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
	'if_exists' => 'update',
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
	'if_exists' => 'update',
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
	'if_exists' => 'update',
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
	'if_exists' => 'update',
	'error' => 'fatal',
	'parameters' => array(),
);

// Oh joy, we've now made it to extra rows... (testing data)
$rows = array();

// Now we can add a new column to an existing table
$columns = array();

// Update mod settings if applicable
foreach ($mod_settings as $new_setting => $new_value)
{
	if (empty($modSettings[$new_setting]))
		updateSettings(array($new_setting => $new_value));
}

// Create new tables, if any
foreach ($tables as $table)
	$smcFunc['db_create_table']($table['table_name'], $table['columns'], $table['indexes'], $table['parameters'], $table['if_exists'], $table['error']);

// Create new rows, if any
foreach ($rows as $row)
	$smcFunc['db_insert']($row['method'], $row['table_name'], $row['columns'], $row['data'], $row['keys']);

// Create new columns, if any
foreach ($columns as $column)
	$smcFunc['db_add_column']($column['table_name'], $column['column_info'], $column['parameters'], $column['if_exists'], $column['error']);

// Are we done?
if (SMF == 'SSI')
	echo 'Database changes are complete!';

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
	);

	$field = $fields[$type];
	$field['name'] = $name;

	return $field;
}
?>