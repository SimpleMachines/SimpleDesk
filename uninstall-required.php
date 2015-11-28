<?php
###############################################################
#         Simple Desk Project - www.simpledesk.net            #
###############################################################
#       An advanced help desk modification built on SMF       #
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
# SimpleDesk Version: 2.0 Anatidae                            #
# File Info: uninstall-required.php / 2.0 Anatidae            #
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

// Unchecking the option in Core Features.
global $modSettings, $sourcedir;
$modSettings['helpdesk_active'] = false;
$features = implode(',', array_diff(explode(',', $modSettings['admin_features']), array('shd')));

updateSettings(
	array(
		'admin_features' => $features,
	),
	true
);

// 2. Removing all the SMF hooks.
$hooks = array();
// SMF Core stuff
	$hooks[] = array(
		'hook' => 'integrate_pre_include',
		'function' => '$sourcedir/sd_source/Subs-SimpleDesk.php',
	);
	$hooks[] = array(
		'hook' => 'integrate_user_info',
		'function' => 'shd_init',
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
	$hooks[] = array(
		'hook' => 'integrate_error_types',
		'function' => 'shd_error_types',
	);
// Admin Section Stuff
	$hooks[] = array(
		'hook' => 'integrate_admin_include',
		'function' => '$sourcedir/sd_source/Subs-SimpleDeskAdmin.php',
	);
	$hooks[] = array(
		'hook' => 'integrate_admin_areas',
		'function' => 'shd_admin_bootstrap',
	);
	$hooks[] = array(
		'hook' => 'integrate_admin_search',
		'function' => 'shd_admin_search',
	);
	$hooks[] = array(
		'hook' => 'integrate_admin_search',
		'function' => 'shd_admin_search',
	);
	$hooks[] = array(
		'hook' => 'integrate_remove_attachments',
		'function' => 'shd_remove_attachments',
	);
	$hooks[] = array(
		'hook' => 'integrate_convert_msgbody',
		'function' => 'shd_convert_msgbody',
	);
	$hooks[] = array(
		'hook' => 'integrate_modifylanguages',
		'function' => 'shd_modifylanguages',
	);
// Display
	$hooks[] = array(
		'hook' => 'integrate_display_buttons',
		'function' => 'shd_display_btn_mvtopic',
	);
	$hooks[] = array(
		'hook' => 'integrate_download_request',
		'function' => 'shd_download_request',
		'file' => '$sourcedir/sd_source/Subs-SimpleDeskDisplay.php',
	);
// BoardIndex
	$hooks[] = array(
		'hook' => 'integrate_getboardtree',
		'function' => 'shd_add_to_boardindex',
		'file' => '$sourcedir/sd_source/Subs-SimpleDeskBoardIndex.php',
	);
// Profile
	$hooks[] = array(
		'hook' => 'integrate_profile_areas',
		'function' => 'shd_profile_areas',
		'file' => '$sourcedir/sd_source/Subs-SimpleDeskProfile.php',
	);
	$hooks[] = array(
		'hook' => 'integrate_profile_profileSaveGroups',
		'function' => 'shd_clear_active_tickets',
	);
// Other
	$hooks[] = array(
		'hook' => 'integrate_SSI',
		'function' => false,
		'file' => '$sourcedir/sd_source/SimpleDesk-SSI.php',
	);

foreach ($hooks as $hook)
	remove_integration_function($hook['hook'], $hook['function']);

// 3. Removing the scheduled task.
$smcFunc['db_query']('', '
	DELETE FROM {db_prefix}scheduled_tasks
	WHERE task = {string:simpledesk}',
	array(
		'simpledesk' => 'simpledesk',
	)
);

// 4. Forcing all SD plugin hooks to be disabled.
$shd_hooks = array(
	'shd_enabled_plugins',
);
foreach ($modSettings as $k => $v)
	if (strpos($k, 'shd_hook') === 0 || strpos($k, 'shd_include') === 0)
		$shd_hooks[] = $k;

$new_hooks = array();
foreach ($shd_hooks as $hook)
	$new_hooks[$hook] = '';

// Reset them locally.
updateSettings(
	$new_hooks,
	true
);

// Purge them finally.
$smcFunc['db_query']('', '
	DELETE FROM {db_prefix}settings
	WHERE variable IN ({array_string:hooks})',
	array(
		'hooks' => $shd_hooks,
	)
);

