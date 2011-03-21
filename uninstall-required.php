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
# File Info: uninstall-required.php / 1.0 Felidae             #
###############################################################

/**
 *	This script removes all the extraneous data if the user requests it be removed on uninstall.
 *
 *	NOTE: This script is meant to run using the <samp><code></code></samp> elements of our package-info.xml file. This is because
 *	certain items in the database and within SMF will need to be removed regardless of whether the user wants to keep data or not,
 *	for example SimpleDesk needs to be deactivated in the Core Features panel, which must be done regardless of whether the user
 *	wanted to keep data or not during uninstallation. Future expansions may add items here, especially such as scheduled tasks.
 *
 *	@package installer
 *	@since 1.0
 */

/**
 *	Before attempting to execute, this file attempts to load SSI.php to enable access to the database functions.
*/

// If we have found SSI.php and we are outside of SMF, then we are running standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
{
	require_once(dirname(__FILE__) . '/SSI.php');
	db_extend('packages');
}
// If we are outside SMF and can't find SSI.php, then throw an error
elseif (!defined('SMF'))
{
	die('<b>Error:</b> Cannot uninstall - please verify you put this file in the same place as SMF\'s SSI.php.');
}

// Unchecking the option in Core Features, and deactivating all the hooks
global $modSettings;
$modSettings['helpdesk_active'] = false;
$features = implode(',', array_diff(explode(',', $modSettings['admin_features']), array('shd')));

updateSettings(
	array(
		'admin_features' => $features,
	),
	true
);

$hooks = array();
$hooks[] = array(
	'hook' => 'integrate_display_buttons',
	'function' => 'shd_display_btn_mvtopic',
);
$hooks[] = array(
	'hook' => 'integrate_pre_include',
	'function' => '$sourcedir/sd_source/Subs-SimpleDesk.php',
);
$hooks[] = array(
	'hook' => 'integrate_admin_include',
	'function' => '$sourcedir/sd_source/Subs-SimpleDeskAdmin.php',
);
$hooks[] = array(
	'hook' => 'integrate_admin_areas',
	'function' => 'shd_admin_bootstrap',
);
$hooks[] = array(
	'hook' => 'integrate_core_features',
	'function' => 'shd_admin_core_features',
);
$hooks[] = array(
	'hook' => 'integrate_actions',
	'function' => 'shd_init_actions',
);
$hooks[] = array(
	'hook' => 'integrate_buffer',
	'function' => 'shd_buffer_replace',
);
$hooks[] = array(
	'hook' => 'integrate_menu_buttons',
	'function' => 'shd_main_menu',
);
$hooks[] = array(
	'hook' => 'integrate_load_permissions',
	'function' => 'shd_admin_smf_perms',
);

foreach ($hooks as $hook)
	remove_integration_function($hook['hook'], $hook['function']);

?>