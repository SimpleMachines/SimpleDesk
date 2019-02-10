<?php
###############################################################
#          Simple Desk Project - www.simpledesk.net           #
###############################################################
#       An advanced help desk modification built on SMF       #
###############################################################
#                                                             #
#         * Copyright 2019 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 2.1 Beta 1                              #
# File Info: Subs-SimpleDeskPackages.php                      #
###############################################################

/**
 *	This file handles integrations into SMF.
 *
 *	@package subs
 *	@since 2.1
 */
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Adds in the SD Plugins as a sort id for packages.
 *
 *	@param array $sort_id Sort options.
 *	@param array $packages Packages lsit.
 *
 *	@since 2.1
*/
function shd_packages_sort_id(&$sort_id, &$packages)
{
	global $context;

	$sort_id['sdplugin'] = 1;
	$packages['sdplugin'] = array();
	$context['available_sdplugin'] = array();
}

/**
 *	Adds in the SD Plugins install link from a download.
 *
 *	@since 2.1
*/
function shd_package_download()
{
	global $context, $scripturl, $txt;

	if ($context['package']['type'] == 'sdplugin')
		$context['package']['install']['link'] = '<a href="' . $scripturl . '?action=admin;area=packages;sa=install;package=' . $context['package']['filename'] . '">[ ' . $txt['shd_install_plugin'] . ' ]</a>';
}

/**
 *	Adds in the SD Plugins install link from a upload.
 *
 *	@since 2.1
*/
function shd_package_upload()
{
	global $context, $scripturl, $txt;

	if ($context['package']['type'] == 'sdplugin')
		$context['package']['install']['link'] = '<a href="' . $scripturl . '?action=admin;area=packages;sa=install;package=' . $context['package']['filename'] . '">[ ' . $txt['shd_install_plugin'] . ' ]</a>';
}

/**
 *	Sets up the browse section for plugins.
 *
 *	@since 2.1
*/
function shd_modification_types()
{
	global $context, $txt;

	$context['modification_types'][] = 'sdplugin';
}