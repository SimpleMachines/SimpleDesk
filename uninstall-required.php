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

// Unchecking the option in Core Features.
global $modSettings;
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
	// Plugin related: general
	'shd_enabled_plugins',
	// Plugin: source load hooks
	'shd_include_init',
	'shd_include_helpdesk',
	'shd_include_hdadmin',
	'shd_include_hdprofile',
	// Plugin: lang load hooks
	'shd_includelang_init',
	'shd_includelang_helpdesk',
	'shd_includelang_hdadmin',
	'shd_includelang_hdprofile',
	// Plugin: general hooks
	'shd_hook_actions',
	'shd_hook_perms',
	'shd_hook_permstemplate',
	'shd_hook_prefs',
	'shd_hook_newticket',
	'shd_hook_newreply',
	'shd_hook_modpost',
	'shd_hook_assign',
	'shd_hook_buffer',
	'shd_hook_after_main',
	// Plugin: menu hooks
	'shd_hook_mainmenu',
	'shd_hook_profilemenu',
	'shd_hook_adminmenu',
	// Plugin: area hooks
	'shd_hook_helpdesk',
	'shd_hook_hdadmin',
	'shd_hook_hdadminopts',
	'shd_hook_hdadminoptssrch',
	'shd_hook_hdprofile',
);

$new_hooks = array();
foreach ($shd_hooks as $hook)
{
	$new_hooks[$hook] = '';
}
updateSettings(
	$new_hooks,
	true
);
$smcFunc['db_query']('', '
	DELETE FROM {db_prefix}settings
	WHERE variable IN ({array_string:hooks})',
	array(
		'hooks' => $shd_hooks,
	)
);
?>