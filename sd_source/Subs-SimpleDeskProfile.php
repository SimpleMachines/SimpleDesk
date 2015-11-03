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
# SimpleDesk Version: 2.1                                     #
# File Info: Subs-SimpleDeskProfile.php / 2.1                 #
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
 *	Sets up the profile menu additions.
 *
 *	@param array $profile_areas Current profile_areas.
 *
 *	@since 2.0
*/
function shd_profile_areas($profile_areas)
{
	// SimpleDesk sections. Added here after the initial cleaning is done, so that we can do our own permission checks without arguing with SMF's system (so much)
	if (!empty($modSettings['helpdesk_active']))
	{
		shd_load_language('sd_language/SimpleDeskProfile');

		// Put it here so we can reuse it for the left menu a bit
		$context['helpdesk_menu'] = array(
			'title' => $txt['shd_profile_area'],
			'areas' => array(
				'helpdesk' => array(
					'label' => $txt['shd_profile_main'],
					'file' => 'sd_source/SimpleDesk-Profile.php',
					'function' => 'shd_profile_main',
					'enabled' => shd_allowed_to('shd_view_profile_any') || ($context['user']['is_owner'] && shd_allowed_to('shd_view_profile_own')),
				),
				'hd_prefs' => array(
					'label' => $txt['shd_profile_preferences'],
					'file' => 'sd_source/SimpleDesk-Profile.php',
					'function' => 'shd_profile_main',
					'enabled' => shd_allowed_to('shd_view_preferences_any') || ($context['user']['is_owner'] && shd_allowed_to('shd_view_preferences_own')),
				),
				'hd_showtickets' => array(
					'label' => $txt['shd_profile_show_tickets'],
					'file' => 'sd_source/SimpleDesk-Profile.php',
					'function' => 'shd_profile_main',
					'enabled' => ($context['user']['is_owner'] && shd_allowed_to('shd_view_ticket_own')) || shd_allowed_to('shd_view_ticket_any'),
				),
				'hd_permissions' => array(
					'label' => $txt['shd_profile_permissions'],
					'file' => 'sd_source/SimpleDesk-Profile.php',
					'function' => 'shd_profile_main',
					'enabled' => shd_allowed_to('admin_helpdesk'),
				),
				'hd_actionlog' => array(
					'label' => $txt['shd_profile_actionlog'],
					'file' => 'sd_source/SimpleDesk-Profile.php',
					'function' => 'shd_profile_main',
					'enabled' => empty($modSettings['shd_disable_action_log']) && (shd_allowed_to('shd_view_profile_log_any') || ($context['user']['is_owner'] && shd_allowed_to('shd_view_profile_log_own'))),
				),
			),
		);

		// Kill the existing profile menu but save it in a temporary place first.
		$old_profile_areas = $profile_areas;
		$profile_areas = array();

		// Now, where we add this depends very much on what mode we're in. In HD only mode, we want our menu first before anything else.
		if (!empty($modSettings['shd_helpdesk_only']))
		{
			require_once($sourcedir . '/Profile-Modify.php');

			// Move some stuff around.
			$context['helpdesk_menu']['areas']['permissions'] = array(
				'label' => $txt['shd_show_forum_permissions'],
				'file' => 'Profile-View.php',
				'function' => 'showPermissions',
				'enabled' => allowedTo('manage_permissions'),
			);
			$context['helpdesk_menu']['areas']['tracking'] = array(
				'label' => $txt['trackUser'],
				'file' => 'Profile-View.php',
				'function' => 'tracking',
				'subsections' => array(
					'activity' => array($txt['trackActivity'], 'moderate_forum'),
					'ip' => array($txt['trackIP'], 'moderate_forum'),
					'edits' => array($txt['trackEdits'], 'moderate_forum'),
				),
				'enabled' => allowedTo('moderate_forum'),
			);

			$profile_areas['helpdesk'] = $context['helpdesk_menu'];
			$profile_areas += $old_profile_areas;

			unset($profile_areas['info']['areas']['permissions'], $profile_areas['info']['areas']['tracking']);

			$remove = array(
				'info' => array(
					'summary',
					'statistics',
					'showposts',
					'viewwarning',
				),
				'edit_profile' => array(
					'forumprofile',
					'ignoreboards',
					'lists',
					'notification',
				),
				'profile_action' => array(
					'issuewarning',
				),
			);
			if (!empty($modSettings['shd_disable_pm']))
			{
				$remove['profile_action'][] = 'sendpm';
				$remove['edit_profile'][] = 'pmprefs';
			}

			foreach ($remove as $area => $items)
				foreach ($items as $item)
					if (!empty($profile_areas[$area]['areas'][$item]))
						$profile_areas[$area]['areas'][$item]['enabled'] = false;

			$profile_areas['edit_profile']['areas']['theme']['file'] = 'sd_source/SimpleDesk-Profile.php';
			$profile_areas['edit_profile']['areas']['theme']['function'] = 'shd_profile_theme_wrapper';
		}
		else
		// In non HD only, put it before the editing stuff menu
		{
			foreach ($old_profile_areas as $area => $details)
			{
				if ($area == 'edit_profile')
					$profile_areas['helpdesk'] = $context['helpdesk_menu'];
				$profile_areas[$area] = $details;
			}
		}

		// Now engage any hooks.
		call_integration_hook('shd_hook_profilemenu', array(&$profile_areas));
	}
}