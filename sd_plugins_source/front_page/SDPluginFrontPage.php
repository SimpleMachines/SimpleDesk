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
# File Info: SimpleDesk-Notifications.php / 1.0 Felidae       #
###############################################################

/**
 *	This file handles sending notifications to users when things happen in the helpdesk.
 *
 *	@package source
 *	@since 1.1
 */

if (!defined('SMF'))
	die('Hacking attempt...');

function shd_frontpage_helpdesk(&$subactions)
{
	global $context, $scripturl, $modSettings;

	// Enabled?
	if (empty($modSettings['shdp_frontpage_content']) || !in_array('front_page', $context['shd_plugins']))
		return;

	// Are we doing it this load or not?
	if (!empty($modSettings['shdp_frontpage_appear']) && $modSettings['shdp_frontpage_appear'] == 'firstload')
	{
		// So, check $_SESSION. If it's set (i.e. we've been here this session, leave; otherwise skip this section, we're coming here every time)
		if (isset($_SESSION['shdp_frontpage']))
			return;
		else
			$_SESSION['shdp_frontpage'] = 1;
	}

	// Fix the navigation to have a tickets button as well as the main button
	$navigation = $context['navigation'];
	$context['navigation'] = array();

	foreach ($navigation as $area => $details)
	{
		$context['navigation'][$area] = $details;
		if ($area == 'main')
		{
			$context['navigation']['tickets'] = array(
				'text' => 'shdp_tickets',
				'lang' => true,
				'url' => $scripturl . '?action=helpdesk;sa=tickets',
			);
		}
	}
	
	// Now, fix the actions
	$subactions['main'] = array(null, 'shd_frontpage_source');
	$subactions['tickets'] = array(null, 'shd_main_helpdesk');
	
	// Hide the 'back to helpdesk' button.
	if (isset($_REQUEST['sa']) && in_array($_REQUEST['sa'], array('main', 'tickets', 'viewblock', 'recyclebin', 'closedtickets')))
		unset($context['navigation']['back']);
}

function shd_frontpage_options($return_config)
{
	global $context, $modSettings, $txt;

	$config_vars = array(
		array('select', 'shdp_frontpage_appear', array('always' => $txt['shdp_frontpage_appear_always'], 'firstload' => $txt['shdp_frontpage_appear_firstload'])),
		'',
		array('select', 'shdp_frontpage_type', array('html' => $txt['shdp_frontpage_type_html'], 'php' => $txt['shdp_frontpage_type_php'], 'bbcode' => $txt['shdp_frontpage_type_bbcode'])),
		array('large_text', 'shdp_frontpage_content', 'size' => 30),
	);
	$context['settings_title'] = $txt['shdp_frontpage'];
	$context['settings_icon'] = 'frontpage.png';

	return $config_vars;
}

function shd_frontpage_adminmenu(&$admin_areas)
{
	global $context, $modSettings, $txt;

	// Enabled?
	if (!in_array('front_page', $context['shd_plugins']))
		return;

	$admin_areas['helpdesk_info']['areas']['helpdesk_options']['subsections']['frontpage'] = array($txt['shdp_frontpage']);
}

function shd_frontpage_hdadminopts()
{
	global $context, $modSettings, $txt;

	// Enabled?
	if (!in_array('front_page', $context['shd_plugins']))
		return;

	$context[$context['admin_menu_name']]['tab_data']['tabs']['frontpage'] = array(
		'description' => $txt['shdp_frontpage_main_desc'],
		'function' => 'shd_frontpage_options',
	);
}

function shd_frontpage_hdadminoptssrch(&$settings_search)
{
	global $context, $modSettings;

	// Enabled?
	if (!in_array('front_page', $context['shd_plugins']))
		return;

	$settings_search[] = array('shd_frontpage_options', 'area=helpdesk_options;sa=frontpage');
}

function shd_frontpage_source()
{
	global $context, $txt, $modSettings;

	loadTemplate('sd_plugins_template/SDPluginFrontPage');
	$context['sub_template'] = 'shd_frontpage';
	$context['page_title'] = $txt['shd_helpdesk'];

	$context['shdp_frontpage_content'] = '';

	if (empty($modSettings['shdp_frontpage_type']))
		$modSettings['shdp_frontpage_type'] = 'html';

	switch ($modSettings['shdp_frontpage_type'])
	{
		case 'html':
			$context['shdp_frontpage_content'] = $modSettings['shdp_frontpage_content'];
			break;
		case 'php':
			ob_start();
			eval($modSettings['shdp_frontpage_content']);
			$context['shdp_frontpage_content'] = ob_get_contents();
			ob_end_clean();
			break;
		case 'bbcode':
			$context['shdp_frontpage_content'] = shd_format_text($modSettings['shdp_frontpage_content'], true, 'shdp_frontpage');
			break;
	}
}

function shd_frontpage_aftermain()
{
	global $context, $scripturl, $txt;
	$dest = $scripturl . '?action=helpdesk;sa=main';

	// We have to fix linktrees.
	foreach ($context['linktree'] as $key => $treeitem)
	{
		if (empty($treeitem['url']))
			continue;

		if ($treeitem['url'] == $dest && $treeitem['name'] == $txt['shdp_tickets'])
			$context['linktree'][$key]['url'] = $scripturl . '?action=helpdesk;sa=tickets';
	}
}

?>