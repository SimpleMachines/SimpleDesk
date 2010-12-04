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

// Now, we move on to adding new tables to the database.
$tables = array();
$tables[] = array(
	'table_name' => '{db_prefix}helpdesk_tickets',
	'columns' => array(
		array(
			'name' => 'id_ticket',
			'auto' => true,
			'type' => 'mediumint',
			'size' => 8,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'id_first_msg',
			'auto' => false,
			'type' => 'int',
			'size' => 10,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'id_member_started',
			'auto' => false,
			'type' => 'mediumint',
			'size' => 8,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'id_last_msg',
			'auto' => false,
			'type' => 'int',
			'size' => 10,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'id_member_updated',
			'auto' => false,
			'type' => 'mediumint',
			'size' => 8,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'id_member_assigned',
			'auto' => false,
			'type' => 'mediumint',
			'size' => 8,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'num_replies',
			'auto' => false,
			'type' => 'int',
			'size' => 10,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'deleted_replies',
			'auto' => false,
			'type' => 'int',
			'size' => 10,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'subject',
			'auto' => false,
			'type' => 'varchar',
			'size' => 100,
			'null' => false,
		),
		array(
			'name' => 'urgency',
			'auto' => false,
			'type' => 'tinyint',
			'size' => 3,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'status',
			'auto' => false,
			'type' => 'tinyint',
			'size' => 3,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'private',
			'auto' => false,
			'type' => 'tinyint',
			'size' => 3,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
		array(
			'name' => 'withdeleted',
			'auto' => false,
			'type' => 'tinyint',
			'size' => 3,
			'null' => false,
			'unsigned' => true,
			'default' => 0,
		),
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
		array(
			'name' => 'id_msg',
			'auto' => true,
			'type' => 'int',
			'size' => 10,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'id_ticket',
			'auto' => false,
			'type' => 'mediumint',
			'size' => 8,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'body',
			'auto' => false,
			'type' => $modSettings['max_messageLength'] > 65535 ? 'text' : 'mediumtext',
			'null' => false,
		),
		array(
			'name' => 'id_member',
			'auto' => false,
			'type' => 'mediumint',
			'size' => 8,
			'default' => 0,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'poster_time',
			'auto' => false,
			'type' => 'int',
			'size' => 10,
			'default' => 0,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'poster_name',
			'auto' => false,
			'type' => 'varchar',
			'size' => 255,
			'null' => false,
		),
		array(
			'name' => 'poster_email',
			'auto' => false,
			'type' => 'varchar',
			'size' => 255,
			'null' => false,
		),
		array(
			'name' => 'poster_ip',
			'auto' => false,
			'type' => 'varchar',
			'size' => 255,
			'null' => false,
		),
		array(
			'name' => 'modified_time',
			'auto' => false,
			'type' => 'int',
			'size' => 10,
			'default' => 0,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'modified_member',
			'auto' => false,
			'type' => 'mediumint',
			'size' => 8,
			'default' => 0,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'modified_name',
			'auto' => false,
			'type' => 'varchar',
			'size' => 255,
			'null' => false,
		),
		array(
			'name' => 'smileys_enabled',
			'auto' => false,
			'type' => 'tinyint',
			'size' => 3,
			'default' => 0,
			'null' => false,
		),
		array(
			'name' => 'message_status',
			'auto' => false,
			'type' => 'tinyint',
			'size' => 3,
			'default' => 0,
			'null' => false,
		),
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
		array(
			'name' => 'id_action',
			'auto' => true,
			'type' => 'int',
			'size' => 10,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'log_time', // when this happened
			'auto' => false,
			'type' => 'int',
			'size' => 10,
			'default' => 0,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'id_member', // person making the event
			'auto' => false,
			'type' => 'mediumint',
			'size' => 8,
			'default' => 0,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'ip', // member's IP
			'auto' => false,
			'type' => 'char',
			'size' => 16,
			'null' => false,
		),
		array(
			'name' => 'action', // defines the message to use
			'auto' => false,
			'type' => 'varchar',
			'size' => 30,
			'null' => false,
		),
		array(
			'name' => 'id_ticket', // ticket it applies to
			'auto' => false,
			'type' => 'mediumint',
			'size' => 8,
			'default' => 0,
			'null' => false,
		),
		array(
			'name' => 'id_msg', // msg it applies to
			'auto' => false,
			'type' => 'int',
			'size' => 10,
			'default' => 0,
			'null' => false,
		),
		array(
			'name' => 'extra', // serialised array of params for log message
			'auto' => false,
			'type' => 'mediumtext',
			'null' => false,
		),
	),
	'indexes' => array(
		array(
			'columns' => array('id_action'),
			'type' => 'primary',
		),
	),
	'if_exists' => 'update',
	'error' => 'fatal',
	'parameters' => array(),
);
$tables[] = array(
	'table_name' => '{db_prefix}helpdesk_log_read',
	'columns' => array(
		array(
			'name' => 'id_ticket',
			'auto' => false,
			'default' => 0,
			'type' => 'mediumint',
			'size' => 8,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'id_member',
			'auto' => false,
			'default' => 0,
			'type' => 'mediumint',
			'size' => 8,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'id_msg',
			'auto' => false,
			'default' => 0,
			'type' => 'int',
			'size' => 10,
			'null' => false,
			'unsigned' => true,
		),
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
		array(
			'name' => 'id_attach',
			'auto' => false,
			'default' => 0,
			'type' => 'int',
			'size' => 10,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'id_ticket',
			'auto' => false,
			'default' => 0,
			'type' => 'mediumint',
			'size' => 8,
			'null' => false,
			'unsigned' => true,
		),
		array(
			'name' => 'id_msg',
			'auto' => false,
			'default' => 0,
			'type' => 'int',
			'size' => 10,
			'null' => false,
			'unsigned' => true,
		),
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
?>