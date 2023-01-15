<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2023 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1.0                                   *
* File Info: SDPluginFrontPage.php                            *
**************************************************************/

/**
 *	This file handles the replacement front page.
 *
 *	@package plugin-frontpage
 *	@since 2.0
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
	if (empty($modSettings['shdp_frontpage_appear']))
		$modSettings['shdp_frontpage_appear'] = 'firstdefault';

	if ($modSettings['shdp_frontpage_appear'] == 'firstload')
	{
		// So, check $_SESSION. If it's set (i.e. we've been here this session, leave; otherwise skip this section, we're coming here every time)
		if (isset($_SESSION['shdp_frontpage']))
			return;
		else
			$_SESSION['shdp_frontpage'] = 1;
	}
	elseif ($modSettings['shdp_frontpage_appear'] == 'firstdefault')
	{
		if (!isset($_SESSION['shdp_frontpage']))
			$_SESSION['shdp_frontpage'] = 1;
	}

	// Fix the navigation to have a tickets button as well as the main button
	$context['shd_home'] = 'action=helpdesk;sa=tickets';
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
				'url' => $scripturl . '?action=helpdesk;sa=tickets' . $context['shd_dept_link'],
			);
		}
	}
	$context['navigation']['back']['url'] = $scripturl . '?' . $context['shd_home'] . $context['shd_dept_link'];

	// Now, fix the actions
	$subactions['main'] = array(null, 'shd_frontpage_source');
	$subactions['tickets'] = array(null, 'shd_main_helpdesk');

	// Hide the 'back to helpdesk' button.
	if (isset($_REQUEST['sa']) && in_array($_REQUEST['sa'], array('main', 'tickets', 'viewblock', 'recyclebin', 'closedtickets')))
		unset($context['navigation']['back']);
}

function shd_frontpage_options($return_config)
{
	global $context, $modSettings, $txt, $sourcedir, $smcFunc;

	// Since this is potentially dangerous, real admins only, thanks.
	isAllowedTo('admin_forum');

	$config_vars = array(
		array('select', 'shdp_frontpage_appear', array('always' => $txt['shdp_frontpage_appear_always'], 'firstload' => $txt['shdp_frontpage_appear_firstload'], 'firstdefault' => $txt['shdp_frontpage_appear_firstdefault'])),
		'',
		array('select', 'shdp_frontpage_type', array('php' => $txt['shdp_frontpage_type_php'], 'bbcode' => $txt['shdp_frontpage_type_bbcode'])),
		array('large_text', 'shdp_frontpage_content', 'size' => 30),
	);
	$context['settings_title'] = $txt['shdp_frontpage'];
	$context['settings_icon'] = 'frontpage.png';

	// Are we actually going to display this, or bouncing it back just for admin search?
	if (!$return_config)
	{
		require_once($sourcedir . '/Subs-Post.php');
		require_once($sourcedir . '/Subs-Editor.php');
		loadTemplate('sd_plugins_template/SDPluginFrontPage');
		$context['sub_template'] = 'shd_frontpage_admin';

		$context['shdp_frontpage_content'] = !empty($modSettings['shdp_frontpage_content']) ? un_preparsecode($modSettings['shdp_frontpage_content']) : '';
		if (isset($_GET['save']))
		{
			$_POST['shdp_frontpage_content'] = isset($_POST['shdp_frontpage_content']) ? $_POST['shdp_frontpage_content'] : '';
			if (!empty($_POST['shdp_frontpage_type']) && $_POST['shdp_frontpage_type'] == 'php')
			{
				$context['shdp_frontpage_content'] = $smcFunc['htmlspecialchars']($_POST['shdp_frontpage_content'], ENT_QUOTES);
			}
			else
			{
				$_POST['shdp_frontpage_content'] = $smcFunc['htmlspecialchars']($_POST['shdp_frontpage_content'], ENT_QUOTES);
				preparsecode($_POST['shdp_frontpage_content']);
				$context['shdp_frontpage_content'] = un_preparsecode($_POST['shdp_frontpage_content']); // So it's a known safe version.
			}
		}

		$modSettings['disable_wysiwyg'] = true;
		$editorOptions = array(
			'id' => 'shdp_frontpage_content',
			'value' => $context['shdp_frontpage_content'],
			'labels' => array(
				'post_button' => $txt['save'],
			),
			'preview_type' => 0,
			'width' => '70%',
			'disable_smiley_box' => false,
		);
		create_control_richedit($editorOptions);
		$context['post_box_name'] = $editorOptions['id'];
	}

	return $config_vars;
}

function shd_frontpage_adminmenu(&$admin_areas)
{
	global $context, $modSettings, $txt;

	// Enabled?
	if (!in_array('front_page', $context['shd_plugins']))
		return;

	if (allowedTo('admin_forum'))
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

	if (!in_array('front_page', $context['shd_plugins']))
		return;

	loadTemplate('sd_plugins_template/SDPluginFrontPage');
	$context['sub_template'] = 'shd_frontpage';
	$context['page_title'] = $txt['shd_helpdesk'];

	$context['shdp_frontpage_content'] = '';

	if (empty($modSettings['shdp_frontpage_type']))
		$modSettings['shdp_frontpage_type'] = 'html';

	switch ($modSettings['shdp_frontpage_type'])
	{
		case 'php':
			ob_start();
			eval($modSettings['shdp_frontpage_content']);
			$context['shdp_frontpage_content'] = ob_get_contents();
			ob_end_clean();
			break;
		case 'bbcode':
			$context['shdp_frontpage_content'] = parse_bbc($modSettings['shdp_frontpage_content'], true, 'shdp_frontpage');
			break;
	}
}

function shd_frontpage_aftermain()
{
	global $context, $scripturl, $txt;

	// Enabled?
	if (!in_array('front_page', $context['shd_plugins']))
		return;

	$dest = $scripturl . '?action=helpdesk;sa=main';

	// We have to fix linktrees. Specifically, if the item says 'Tickets' it should really point there.
	foreach ($context['linktree'] as $key => $treeitem)
	{
		if (empty($treeitem['url']))
			continue;

		if ($treeitem['url'] == $dest && $treeitem['name'] == $txt['shdp_tickets'])
		{
			$context['linktree'][$key]['url'] = $scripturl . '?action=helpdesk;sa=tickets';
			break;
		}
	}

	// If we're actually on the tickets page on its own, we won't have the link tree item. Time to fix that.
	if (isset($_REQUEST['sa']) && $_REQUEST['sa'] == 'tickets')
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=helpdesk;sa=tickets',
			'name' => $txt['shdp_tickets'],
		);
}

function shd_frontpage_mainmenu(&$menu_buttons)
{
	global $context, $scripturl, $modSettings;

	// Enabled?
	if (empty($modSettings['shdp_frontpage_content']) || !in_array('front_page', $context['shd_plugins']))
		return;

	if (!empty($modSettings['shdp_frontpage_appear']) && $modSettings['shdp_frontpage_appear'] == 'firstdefault' && !empty($_SESSION['shdp_frontpage']))
	{
		if (empty($modSettings['shd_helpdesk_only']) && isset($menu_buttons['helpdesk']))
			$menu_buttons['helpdesk']['href'] = $scripturl . '?action=helpdesk;sa=tickets';
		elseif (!empty($modSettings['shd_helpdesk_only']))
			$menu_buttons['home']['href'] = $scripturl . '?action=helpdesk;sa=tickets';
	}
}

function shd_frontpage_boardindex()
{
	global $context, $modSettings;
	if (empty($modSettings['shdp_frontpage_content']) || !in_array('front_page', $context['shd_plugins']))
		return;

	if (!empty($modSettings['shdp_frontpage_appear']))
	{
		if (($modSettings['shdp_frontpage_appear'] == 'firstlogin' && empty($_SESSION['shdp_frontpage'])) || $modSettings['shdp_frontpage_appear'] != 'firstlogin')
			$context['shd_home'] = 'action=helpdesk;sa=tickets';
	}
}