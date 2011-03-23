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
# File Info: uninstall-optional.php / 1.0 Felidae             #
###############################################################

/**
 *	This script removes all the extraneous data if the user requests it be removed on uninstall.
 *
 *	NOTE: This script is meant to run using the <samp><database></database></samp> elements of the package-info.xml file. The install
 *	script, run through <samp><database></samp> elements would have set up the tables and so on. This script runs from
 *	<samp><database></samp> during uninstallation only when the user requests that data should be cleared, so this script deals with it;
 *	note that table removal will be dealt with by SMF itself because of <samp><database></samp> handling, so this is for things like
 *	settings that are not covered in <samp><database></samp>.
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

$to_remove = array(
	'shd_staff_badge',
	'shd_display_avatar',
	'shd_disable_action_log',
	'shd_ticketnav_style',
	'shd_allow_ticket_bbc',
	'shd_allow_ticket_smileys',
	'shd_enabled_bbc',
	'shd_helpdesk_only',
	'shd_attachments_mode',
	'shd_disable_pm',
	'shd_disable_mlist',
	'shd_bbc',
	'shd_staff_ticket_self',
	'shd_admins_not_assignable',
	'shd_privacy_display',
	'shd_disable_tickettotopic',
	// Ticket logs
	'shd_display_ticket_logs',
	'shd_logopt_newposts',
	'shd_logopt_editposts',
	'shd_logopt_resolve',
	'shd_logopt_autoclose',
	'shd_logopt_assign',
	'shd_logopt_privacy',
	'shd_logopt_urgency',
	'shd_logopt_tickettopicmove',
	'shd_logopt_delete',
	'shd_logopt_restore',
	'shd_logopt_permadelete',
	'shd_logopt_relationships',
	'shd_logopt_split',
	// General options
	'shd_maintenance_mode',
	'shd_allow_wikilinks',
	'shd_thank_you_post',
	'shd_thank_you_nonstaff',
	'shd_theme',
	// Email notifications
	'shd_notify_new_ticket',
	'shd_notify_new_reply_own',
	'shd_notify_new_reply_assigned',
	'shd_notify_new_reply_previous',
	'shd_notify_new_reply_any',
	'shd_notify_assign_me',
	'shd_notify_assign_own',
	// Scheduled tasks
	'shd_autoclose_tickets',
	'shd_autoclose_tickets_days',
	'shd_autopurge_tickets',
	'shd_autopurge_tickets_days',
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

global $modSettings;

// Clear in-situ modsettings
foreach ($to_remove as $setting)
	if (isset($modSettings[$setting]))
		unset($modSettings[$setting]);

// Remove from the database; updateSettings can't actually remove them, it seems :(
$smcFunc['db_query']('', '
	DELETE FROM {db_prefix}settings
	WHERE variable IN ({array_string:settings})',
	array(
		'settings' => $to_remove,
	)
);

// Also remove the plugins package server.
$query = $smcFunc['db_query']('', '
	DELETE FROM {db_prefix}package_servers
	WHERE url LIKE {string:plugins}',
	array(
		'plugins' => 'http://www.simpledesk.net/downloads/plugins/%',
	)
);

// And tell SMF we've updated $modSettings
updateSettings(array(
	'settings_updated' => time(),
));

?>