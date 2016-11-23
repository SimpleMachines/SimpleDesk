<?php
###############################################################
#         Simple Desk Project - www.simpledesk.net            #
###############################################################
#       An advanced help desk modification built on SMF       #
###############################################################
#                                                             #
#         * Copyright 2016 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 2.1                                     #
# File Info: SimpleDesk-AdminPlugins.php / 2.1                #
###############################################################

/**
 *	This file handles the core of SimpleDesk's plugin system administration.
 *
 *	@package source
 *	@since 2.0
*/
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	The start point for all interaction with the SimpleDesk plugins.
 *
 *	Directed here from the main administration centre, after permission checks and a few dependencies loaded, this deals solely with managing custom fields.
 *
 *	@since 2.0
*/
function shd_admin_plugins()
{
	global $context, $scripturl, $sourcedir, $settings, $txt, $modSettings;

	loadTemplate('sd_template/SimpleDesk-AdminPlugins');
	shd_load_language('ManageSettings');
	loadTemplate(false, array('admin', 'helpdesk_admin'));

	$context['shd_enabled_plugins'] = !empty($modSettings['shd_enabled_plugins']) ? explode(',', $modSettings['shd_enabled_plugins']) : array();

	// 1. Look at the plugin directory and figure out whether or not there are some plugins.
	$plugins = array();
	$plugindir = $sourcedir . '/sd_plugins_source';
	$handle = @opendir($plugindir);
	while ($dir_entry = readdir($handle))
	{
		if (is_dir($plugindir . '/' . $dir_entry) && $dir_entry != '.' && $dir_entry != '..' && file_exists($plugindir . '/' . $dir_entry . '/index.php'))
		{
			include_once($plugindir . '/' . $dir_entry . '/index.php');
			$function = 'shdplugin_' . $dir_entry;
			if (function_exists($function))
			{
				$plugins[$dir_entry] = $function();
			}
		}
	}
	@closedir($handle);

	// 2. Figure out what language stuff is going on
	$master_langlist = array(
		'albanian',
		'arabic',
		'bangla',
		'bulgarian',
		'catalan',
		'chinese_simplified',
		'chinese_traditional',
		'croatian',
		'czech',
		'danish',
		'dutch',
		'english',
		'english_british',
		'finnish',
		'french',
		'galician',
		'german',
		'hebrew',
		'hindi',
		'hungarian',
		'indonesian',
		'italian',
		'japanese',
		'kurdish_kurmanji',
		'kurdish_sorani',
		'macedonian',
		'malay',
		'norwegian',
		'persian',
		'polish',
		'portuguese_brazilian',
		'portuguese_pt',
		'romanian',
		'russian',
		'serbian_cyrillic',
		'serbian_latin',
		'slovak',
		'spanish_es',
		'spanish_latin',
		'swedish',
		'thai',
		'turkish',
		'ukrainian',
		'urdu',
		'uzbek_latin',
		'vietnamese',
	);
	$langtemplates = array();
	$langfilelist = @opendir($settings['default_theme_dir'] . '/languages/sd_plugins_lang/');
	while ($langfile_entry = readdir($langfilelist))
	{
		if (preg_match('~([a-z0-9]+)\.([a-z\-\_]+)(-utf8)?\.php$~i', $langfile_entry, $matches))
			$langtemplates[$matches[1]][$matches[2]] = true;
	}
	@closedir($langfilelist);

	// 3. Figure out what shape the plugins are in
	foreach ($plugins as $id => $plugin)
	{
		// 3.1 Is installable?
		if (empty($plugins[$id]['details']['compatibility']))
			$plugins[$id]['details']['compatibility'] = array($txt['unknown']);
		$plugins[$id]['installable'] = in_array(SHD_VERSION, $plugin['details']['compatibility']);

		// 3.2 Admin language files? (That also means, let's get a list of known languages for this mod)
		$plugins[$id]['languages'] = array();
		if (!empty($plugin['includes']['language']['hdadmin']))
		{
			$include = is_array($plugin['includes']['language']['hdadmin']) ? $plugin['includes']['language']['hdadmin'] : array($plugin['includes']['language']['hdadmin']);
			if (!empty($include[0]))
				$plugins[$id]['languages'] = array_keys($langtemplates[$include[0]]);
			foreach ($include as $langfile)
				shd_load_language('sd_plugins_lang/' . $langfile);
		}

		// 3.3 Sort out some strings - now we've loaded the lang file
		if (!empty($txt[$plugin['details']['title']]))
			$plugins[$id]['details']['title'] = $txt[$plugin['details']['title']];
		if (!empty($plugin['details']['description']) && !empty($txt[$plugin['details']['description']]))
			$plugins[$id]['details']['description'] = $txt[$plugin['details']['description']];
		if (empty($plugin['details']['author']))
			$plugins[$id]['details']['author'] = $txt['unknown'];

		// 3.4 Is it enabled?
		$plugins[$id]['enabled'] = in_array($id, $context['shd_enabled_plugins']);
		$plugins[$id]['details']['acp_url'] = !empty($plugin['details']['acp_url']) && $plugins[$id]['enabled'] ? (strpos($plugin['details']['acp_url'], 'http') === false ? $scripturl . '?' . $plugin['details']['acp_url'] . ';' . $context['session_var'] . '=' . $context['session_id'] : $plugin['details']['acp_url']) : false;
	}

	// 3. Throw it at the template.
	$context['sub_template'] = 'shd_plugin_listing';
	$context['plugins'] = $plugins;
	$context['page_title'] = $txt['shd_admin_plugins'];

	// 4. Are we saving any changes?
	if (isset($_POST['save']))
	{
		checkSession();

		$list_of_settings = shd_list_hooks();
		$setting_changes = array();
		foreach ($list_of_settings as $item)
			$setting_changes[$item] = array();

		$post_var_prefix = empty($_POST['js_worked']) ? 'feature_plain_' : 'feature_';

		foreach ($plugins as $id => $plugin)
		{
			if (empty($plugin['installable']))
				continue; // GET OUT YE WRONGLY VERSIONED SHI--STUFF

			// Is it enabled, if so, go do the voodoo that you do so well!!!!
			if (!empty($_POST[$post_var_prefix . $id]))
			{
				$setting_changes['shd_enabled_plugins'][] = $id;
				foreach ($plugin['includes']['source'] as $include_point => $include_file)
				{
					if (isset($setting_changes['shd_include_' . $include_point]) && file_exists($sourcedir . '/sd_plugins_source/' . $id . '/' . $include_file))
						$setting_changes['shd_include_' . $include_point][] = $id . '/' . $include_file;
				}
				foreach ($plugin['includes']['language'] as $include_point => $include_file)
				{
					if (isset($setting_changes['shd_includelang_' . $include_point]))
						$setting_changes['shd_includelang_' . $include_point][] = $include_file;
				}
				foreach ($plugin['hooks'] as $include_point => $function)
				{
					if (isset($setting_changes['shd_hook_' . $include_point]))
						$setting_changes['shd_hook_' . $include_point][] = $function;
				}
			}

			// Is there a call back for settings?
			if (isset($plugin['setting_callback']))
			{
				$returned_settings = $plugin['setting_callback'](!empty($_POST[$post_var_prefix . $id]));
				if (!empty($returned_settings))
					$setting_changes = array_merge($setting_changes, $returned_settings);
			}

			// Standard save callback?
			if (isset($plugin['on_save']))
				$plugin['on_save']();
		}

		// OK, so whatever we have at this point, we know we're going to be implode'ing and saving.
		foreach ($setting_changes as $setting => $array)
			$setting_changes[$setting] = implode(',', $array);

		updateSettings($setting_changes);

		// Any post save things?
		foreach ($plugins as $id => $plugin)
		{
			// Standard save callback?
			if (isset($plugin['save_callback']))
				$plugin['save_callback'](!empty($_POST[$post_var_prefix . $id]));
		}

		// We know we did something.
		shd_admin_log('admin_plugins', array(
			'action' => 'update',
		));

		redirectexit('action=admin;area=helpdesk_plugins;' . $context['session_var'] . '=' . $context['session_id']);
	}
}

/**
 *	Unregister a plugin, to be called from plugin uninstallers.
 *
 *	Expects $context['uninstall_plugin'] to have been defined, as an array with up to four keys:
 *	- 'name' as a string of the plugin's name (required)
 *	- 'sources' as an array of files to be purged from source file loaders (e.g. SDPluginMymod.php)
 *	- 'languages' as an array of files to be purged from language loaders (e.g. SDPluginMymod)
 *	- 'functions' as an array of functions to be purged from function calls (e.g. shd_mymod_helpdesk, shd_mymod_adminopts)
 *
 *	@since 2.0
*/
function shd_unregister_plugin()
{
	global $context, $modSettings;

	// Make sure we're dealing with something sensible
	if (empty($context['uninstall_plugin']['sources']))
		$context['uninstall_plugin']['sources'] = array();

	foreach ($context['uninstall_plugin']['sources'] as $id => $file)
		$context['uninstall_plugin']['sources'][$id] = $context['uninstall_plugin']['name'] . '/' . $file;

	// Now language files
	if (empty($context['uninstall_plugin']['languages']))
		$context['uninstall_plugin']['languages'] = array();

	// Now functions
	if (empty($context['uninstall_plugin']['functions']))
		$context['uninstall_plugin']['functions'] = array();

	// Get all the hook points
	$hooks = shd_list_hooks();

	$changes = array();
	foreach ($hooks as $hookpoint)
	{
		$hook = explode('_', $hookpoint);
		if (empty($modSettings[$hookpoint]))
			continue;

		switch ($hook[1])
		{
			case 'include':
				$hooked = explode(',', $modSettings[$hookpoint]);
				$hooked = array_diff($hooked, $context['uninstall_plugin']['sources']);
				$changes[$hookpoint] = implode(',', $hooked);
				break;
			case 'includelang':
				$hooked = explode(',', $modSettings[$hookpoint]);
				$hooked = array_diff($hooked, $context['uninstall_plugin']['languages']);
				$changes[$hookpoint] = implode(',', $hooked);
				break;
			case 'hook':
				$hooked = explode(',', $modSettings[$hookpoint]);
				$hooked = array_diff($hooked, $context['uninstall_plugin']['functions']);
				$changes[$hookpoint] = implode(',', $hooked);
				break;
			case 'enabled':
				$hooked = explode(',', $modSettings[$hookpoint]);
				$hooked = array_diff($hooked, array($context['uninstall_plugin']['name']));
				$changes[$hookpoint] = implode(',', $hooked);
				break;
		}
	}

	// Keep track of this.
	shd_admin_log('admin_plugins', array(
		'action' => 'remove',
	));

	updateSettings($changes, true);
}

function shd_list_hooks()
{
	global $context;
	// This is our master set of hooks and stuff, so FOR THE LOVE OF DEITIES, GET IT RIGHT.
	$hooks = array(
		'shd_enabled_plugins', // for the list of plugins generally

		// File loading - sources
		'shd_include_init', // source files to include on SD init, i.e. every page load when the helpdesk is active
		'shd_include_helpdesk', // source files to include when going into the helpdesk (action=helpdesk)
		'shd_include_hdadmin', // source files to include when going into any part of the helpdesk admin
		'shd_include_hdprofile', // source files to include when going into any part of the helpdesk profile

		// File loading - lang files
		'shd_includelang_init', // language files to include on SD init, i.e. every page load when the helpdesk is active
		'shd_includelang_helpdesk', // language files to include when going into the helpdesk (action=helpdesk)
		'shd_includelang_hdadmin', // language files to include when going into any part of the helpdesk admin
		'shd_includelang_hdprofile', // language files to include when going into any part of the helpdesk profile
		'shd_includelang_who', // language files to include when going into Who's Online

		// General hooks
		'shd_hook_actions', // functions to run when looking at the action array (where action=x is evaluated)
		'shd_hook_perms', // functions to add permissions (relevant file probably should be included in the _include_init hook)
		'shd_hook_permstemplate', // functions to add permissions to any of the templates (relevant file probably should be included in the _include_init hook)
		'shd_hook_prefs', // functions to add preferences (relevant file probably should be included in the _include_init hook)
		'shd_hook_newticket', // functions to call when just a new ticket is made
		'shd_hook_newreply', // functions to call when a new reply is made
		'shd_hook_modpost', // functions to call when a ticket or reply is edited (since all kinds of things might be altered)
		'shd_hook_assign', // functions to call when a ticket is assigned to someone
		'shd_hook_buffer', // functions to call prior to the final page generation
		'shd_hook_after_main', // functions to call after action=helpdesk has been evaluated but before template calls are made
		'shd_hook_boardindex_before', // functions to call before setting up the injected boardindex
		'shd_hook_boardindex_after', // functions to call after setting up the injected boardindex
		'shd_hook_deleteticket', // functions to call just before actually deleting (softly) a ticket
		'shd_hook_deletereply', // functions to call just before actually deleting (softly) a reply
		'shd_hook_permadeleteticket', // functions to call just before truly deleting a ticket
		'shd_hook_permadeletereply', // functions to call just before truly deleting a reply
		'shd_hook_restoreticket', // functions to call just before restoring a previously deleted ticket
		'shd_hook_restorereply', // functions to call just before restoring a previously deleted reply
		'shd_hook_markunread', // functions to call just before marking a ticket unread
		'shd_hook_markresolve', // functions to call just before marking a ticket resolved
		'shd_hook_markunresolve', // functions to call just before marking a ticket unresolved
		'shd_hook_relations', // functions to call just before setting/removing ticket relationships
		'shd_hook_movedept', // functions to call just before moving a ticket between departments
		'shd_hook_tickettotopic', // functions to call just before moving a ticket into a forum topic
		'shd_hook_topictoticket', // functions to call just before moving a forum topic into a ticket

		// Admin hooks
		'shd_hook_admin_display', // to extend the SD Admin > Options > Display Options
		'shd_hook_admin_posting', // to extend the SD Admin > Options > Posting Options
		'shd_hook_admin_admin', // to extend the SD Admin > Options > Admin Options
		'shd_hook_admin_standalone', // to extend the SD Admin > Options > Standalone Options
		'shd_hook_admin_actionlog', // to extend the SD Admin > Options > Action Log Options
		'shd_hook_admin_notify', // to extend the SD Admin > Options > Notifications Options

		// Template hooks
		'shd_hook_tpl_after_tkt_detail', // functions to call after the ticket details (before additional details), in the ticket level left column
		'shd_hook_tpl_after_add_detail', // functions to call after the ticket details (after additional details), in the ticket level left column
		'shd_hook_tpl_display_lcol', // functions to call for adding into the reply-level left column in a ticket view (it should modify $context['leftcolumn_templates'] to add entries for template_*() to be called)

		// Menu hooks - called after the rest of menu configuration is done (meaning menu items may or may not exist depending on permissions)
		'shd_hook_mainmenu', // functions to call when looking at the main menu
		'shd_hook_profilemenu', // functions to call when specifically modifying the profile menu
		'shd_hook_adminmenu', // functions to call when specifically modifying the admin menu

		// Area level hooks
		'shd_hook_init', // functions to run as soon as main SD initialisation has completed (SD permissions are loaded by here)
		'shd_hook_helpdesk', // functions to run when starting the main helpdesk (before going off to subactions)
		'shd_hook_hdadmin', // functions to run when starting the main SimpleDesk admin area (probably should include via _include_hdadmin)
		'shd_hook_hdadminopts', // functions to run when working in the SimpleDesk options submenu structure (probably should include via _include_hdadmin)
		'shd_hook_hdadmininfo', // functions to run when working in the SimpleDesk info submenu structure (probably should include via _include_hdadmin)
		'shd_hook_hdadminoptssrch', // functions to run when setting up admin panel search for SimpleDesk options submenu structure (probably should include via _include_hdadmin)
		'shd_hook_hdprofile', // functions to call when going into the helpdesk profile area
	);

	if (!empty($context['master_action_list']))
	{
		foreach ($context['master_action_list'] as $action)
		{
			$hooks[] = 'shd_hook_action_' . $action;
			$hooks[] = 'shd_include_action_' . $action;
			$hooks[] = 'shd_includelang_action_' . $action;
		}
	}

	return $hooks;
}
