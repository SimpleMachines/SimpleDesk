<?php
###############################################################
#         Simple Desk Project - www.simpledesk.net            #
###############################################################
#       An advanced help desk modification built on SMF       #
###############################################################
#                                                             #
#         * Copyright 2017 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 2.1                                     #
# File Info: SimpleDesk-Admin.php / 2.1                       #
###############################################################

/**
 *	This file handles the core of SimpleDesk's administrative information and options from within SMF's own admin panel.
 *
 *	@package source
 *	@since 1.0
*/
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	The start point for all interaction with the SimpleDesk administration area.
 *
 *	Enforces that users attempting to access the area have either forum or helpdesk administrative privileges, loads the SimpleDesk
 *	administrative CSS and Javascript and promptly directs users to the specific function for the task they are performing.
 *
 *	@since 1.0
*/
function shd_admin_main()
{
	global $context, $scripturl, $sourcedir, $settings, $txt, $modSettings, $scripturl;

	shd_init();
	shd_load_language('sd_language/SimpleDeskAdmin');

	// Kick them in the kneecaps!
	if (!shd_allowed_to('admin_helpdesk', 0))
		isAllowedTo('admin_forum');

	// Templates and stuff (like hook files)
	loadTemplate('sd_template/SimpleDesk-Admin');
	$context['template_layers'][] = 'shd_nojs';
	$context['shd_preferences'] = shd_load_user_prefs();
	shd_load_plugin_files('hdadmin');
	shd_load_plugin_langfiles('hdadmin');

	// Load some extra CSS
	loadCSSFile('helpdesk_admin.css', array('minimize' => false, 'seed' => $context['shd_css_version']), 'helpdesk_admin');
	loadCSSFile('helpdesk.css', array('minimize' => false, 'seed' => $context['shd_css_version']), 'helpdesk');
	loadJavascriptFile('helpdesk_admin.js', array('defer' => false, 'minimize' => false), 'helpdesk_admin');

	$context['page_title'] = $txt['shd_admin_title'];

	// We need this for later
	require_once($sourcedir . '/ManageServer.php');

	// Create some subactions
	$subActions = array(
		'helpdesk_info' => array(null, 'shd_admin_info'),
		'helpdesk_options' => array(null, 'shd_admin_options'),
		'helpdesk_cannedreplies' => array('SimpleDesk-AdminCannedReplies.php', 'shd_admin_canned'),
		'helpdesk_customfield' => array('SimpleDesk-AdminCustomField.php', 'shd_admin_custom'),
		'helpdesk_depts' => array('SimpleDesk-AdminDepartments.php', 'shd_admin_departments'),
		'helpdesk_permissions' => array('SimpleDesk-AdminPermissions.php', 'shd_admin_permissions'),
		'helpdesk_plugins' => array('SimpleDesk-AdminPlugins.php', 'shd_admin_plugins'),
		'helpdesk_maint' => array('SimpleDesk-AdminMaint.php', 'shd_admin_maint'),
	);

	// Int hooks - after we basically set everything up (so it's manipulatable by the hook, but before we do the last bits of finalisation)
	call_integration_hook('shd_hook_hdadmin', array(&$subActions));

	// Make sure we can find a subaction. If not set, default to info
	$_REQUEST['area'] = isset($_REQUEST['area']) && isset($subActions[$_REQUEST['area']]) ? $_REQUEST['area'] : 'helpdesk_info';
	$context['sub_action'] = $_REQUEST['area'];

	if (!empty($subActions[$_REQUEST['area']][0]))
		require_once ($sourcedir . '/sd_source/' . $subActions[$_REQUEST['area']][0]);

	// Call our subaction
	if ($_REQUEST['area'] == 'helpdesk_options')
		$subActions[$_REQUEST['area']][1](false);
	else
		$subActions[$_REQUEST['area']][1]();

	// Important ACS666 check up.
	if (isset($_REQUEST['cookies']))
		shd_do_important();

	// Maintenance mode? If it were, the helpdesk is considered inactive for the purposes of everything to all but those without admin-helpdesk rights - but we must have them if we're here!
	if (!empty($modSettings['shd_maintenance_mode']))
	{
		loadTemplate('sd_template/SimpleDesk');
		$temp_layers = $context['template_layers'];
		$context['template_layers'] = array();
		$added = false;
		foreach ($temp_layers as $layer)
		{
			$context['template_layers'][] = $layer;
			if ($layer == 'body')
			{
				$context['template_layers'][] = 'shd_maintenance';
				$added = true;
			}
		}

		// Well, we tried to add it as near the top as possible, but not all themes use the standard body layer.
		if (!$added)
			$context['template_layers'][] = 'shd_maintenance';
	}

	// Also, fix up the link tree while we're here.
	$linktree = $context['linktree'];
	$context['linktree'] = array();
	foreach ($linktree as $linktreeitem)
	{
		$context['linktree'][] = $linktreeitem;
		if ($linktreeitem['url'] == $scripturl . '?action=admin')
		{
			$context['linktree'][] = array(
				'url' => $scripturl . '?action=admin;area=helpdesk_info',
				'name' => $txt['shd_helpdesk'],
			);
		}
	}
}

/**
 *	Loads the main SimpleDesk information page for forum administrators.
 *
 *	This function is the main focus point for information about SimpleDesk in the admin panel, primarily it collects the following for the template:
 *	<ul>
 *	<li>list of helpdesk staff</li>
 *	<li>totals of tickets in the system (open/closed/deleted)</li>
 *	<li>credits</li>
 *	<li>also, in the template, whether this is a current or outdated version of SimpleDesk</li>
 *	</ul>
 *
 *	Since 1.1, it also receives the requests for subactions for action log and support page (since these are sub menu items) but simply directs them onward.
 *
 *	@see shd_admin_action_log()
 *	@see shd_admin_support()
 *
 *	@since 1.0
*/
function shd_admin_info()
{
	global $context, $settings, $scripturl, $txt, $sourcedir, $smcFunc, $modSettings;

	$subactions = array(
		'main' => array(
			'function' => false,
			'icon' => 'simpledesk.png',
			'title' => $txt['shd_admin_info'],
		),
		'actionlog' => array(
			'function' => 'shd_admin_action_log',
			'icon' => 'log.png',
			'title' => $txt['shd_admin_actionlog_title'],
		),
		'adminlog' => array(
			'function' => 'shd_admin_admin_log',
			'icon' => 'log.png',
			'title' => $txt['shd_admin_adminlog_title'],
		),
		'support' => array(
			'function' => 'shd_admin_support',
			'icon' => 'support.png',
			'title' => $txt['shd_admin_support'],
		),
	);

	// Can't do this?
	if (!allowedTo('admin_forum'))
		unset($subactions['adminlog']);

	$context[$context['admin_menu_name']]['tab_data'] = array(
		'description' => $txt['shd_admin_options_desc'],
		'tabs' => array(
			'main' => array(
				'description' => '<strong>' . $txt['hello_guest'] . ' ' . $context['user']['name'] . '!</strong><br>' . $txt['shd_admin_info_desc'],
			),
			'actionlog' => array(
				'description' => $txt['shd_admin_actionlog_desc'] . '<br>' . (!empty($modSettings['shd_disable_action_log']) ? '<span class="smalltext">' . $txt['shd_action_log_disabled'] . '</span>' : ''),
			),
			'adminlog' => array(
				'description' => $txt['shd_admin_adminlog_desc'],
			),
			'support' => array(
				'description' => $txt['shd_admin_support_desc'],
			),
		),
	);

	call_integration_hook('shd_hook_hdadmininfo', array(&$subactions));
	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subactions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'main';

	// Now that we have validated the subaction.	
	$context[$context['admin_menu_name']]['tab_data']['title'] = '<img src="' . $settings['images_url'] . '/admin/shd/' . $subactions[$_REQUEST['sa']]['icon'] . '" class="icon" alt="*">' . $subactions[$_REQUEST['sa']]['title'];

	// Are we doing the main page, or leaving here?
	if (!empty($subactions[$_REQUEST['sa']]['function']))
	{
		$subactions[$_REQUEST['sa']]['function']();
		return;
	}

	// Get a list of the staff members of the helpdesk.
	$members = shd_members_allowed_to('shd_staff');
	$query = shd_db_query('', '
		SELECT id_member, real_name
		FROM {db_prefix}members
		WHERE id_member IN ({array_int:members})
		ORDER BY real_name',
		array(
			'members' => $members,
		)
	);

	// Note this just gets everyone, doesn't worry about limiting it - IMO that's something for the template to decide.
	$context['staff'] = array();
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['staff'][] = shd_profile_link($row['real_name'], $row['id_member']);

	$smcFunc['db_free_result']($query);

	// Make we sure give these slackers some credit. After all, they made sumfin fer ya!
	shd_credits();

	$context['total_tickets'] = shd_count_helpdesk_tickets();
	$context['open_tickets'] = shd_count_helpdesk_tickets('open');
	$context['closed_tickets'] = shd_count_helpdesk_tickets('closed');
	$context['recycled_tickets'] = shd_count_helpdesk_tickets('recycled');

	// Final stuff before we go.
	$context['page_title'] = $txt['shd_admin_title'];
	$context['sub_template'] = 'shd_admin';
}

/**
 *	Configuration options and save functions generally for SimpleDesk.
 *
 *	This function handles all the sub areas under General Options, and adds the options listed in the relevant functions. In 1.0, all the options were stored in here, but in 1.1 they have been moved into their own functions.
 *
 *	@since 1.0
*/
function shd_admin_options($return_config)
{
	global $context, $scripturl, $sourcedir, $txt, $modSettings, $settings;

	$context['settings_pre_javascript'] = '
		function shd_switchable_item(item, state)
		{
			document.getElementById(item).disabled = state;
			document.getElementById("label_" + item).parentNode.className = state ? "disabled" : "";
		}
	';

	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => '<img src="' . $settings['default_images_url'] . '/simpledesk/status.png" class="icon" alt="*">' . $txt['shd_admin_options'],
		'description' => $txt['shd_admin_options_desc'],
		'tabs' => array(
			'display' => array(
				'description' => $txt['shd_admin_options_display_desc'],
				'function' => 'shd_modify_display_options',
			),
			'posting' => array(
				'description' => $txt['shd_admin_options_posting_desc'],
				'function' => 'shd_modify_posting_options',
			),
			'admin' => array(
				'description' => $txt['shd_admin_options_admin_desc'],
				'function' => 'shd_modify_admin_options',
			),
			'standalone' => array(
				'description' => $txt['shd_admin_options_standalone_desc'],
				'function' => 'shd_modify_standalone_options',
			),
			'actionlog' => array(
				'description' => $txt['shd_admin_options_actionlog_desc'],
				'function' => 'shd_modify_actionlog_options',
			),
			'notifications' => array(
				'description' => $txt['shd_admin_options_notifications_desc'],
				'function' => 'shd_modify_notifications_options',
			),
		),
	);

	loadTemplate('sd_template/SimpleDesk-Admin');
	$context['sub_template'] = 'shd_show_settings';

	// Int hooks - after we basically set everything up (so it's manipulatable by the hook, but before we do the last bits of finalisation)
	call_integration_hook('shd_hook_hdadminopts');

	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($context[$context['admin_menu_name']]['tab_data']['tabs'][$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'display';
	if (empty($context['post_url']))
		$context['post_url'] = $scripturl . '?action=admin;area=helpdesk_options;save;sa=' . $_REQUEST['sa'];

	$config_vars = $context[$context['admin_menu_name']]['tab_data']['tabs'][$_REQUEST['sa']]['function']($return_config);

	if ($return_config)
		return $config_vars;

	// Saving?
	if (isset($_GET['save']))
	{
		checkSession();
		$save_vars = $config_vars;

		// If we're saving the posting options, we need to process the BBC tags.
		if ($_REQUEST['sa'] == 'posting')
		{
			if (!isset($_POST['shd_bbc_enabledTags']))
				$_POST['shd_bbc_enabledTags'] = array();
			elseif (!is_array($_POST['shd_bbc_enabledTags']))
				$_POST['shd_bbc_enabledTags'] = array($_POST['shd_bbc_enabledTags']);

			$_POST['shd_enabled_bbc'] = implode(',', $_POST['shd_bbc_enabledTags']);

			if (empty($_POST['shd_enabled_bbc']))
				$_POST['shd_enabled_bbc'] = 'shd_all_tags_disabled';

			$save_vars[] = array('text', 'shd_enabled_bbc');
		}

		shd_admin_log_configvar($save_vars);
		saveDBSettings($save_vars);
		$_SESSION['adm-save'] = true;
		redirectexit('action=admin;area=helpdesk_options;sa=' . $_REQUEST['sa']);
	}

	createToken('admin-dbsc');
	prepareDBSettingContext($config_vars);
}

/**
 *	Sets up display options for SimpleDesk.
 *
 *	<ul>
 *	<li>'shd_staff_badge' (dropdown) - selects the type of badge(s) to display:
 *		<ul>
 *			<li>nobadge (default): Display no badges, just a small staff icon for staff members</li>
 *			<li>staffbadge: Display nothing for normal users, and badge/stars for staff</li>
 *			<li>userbadge: Display nothing for staff and normal badge/staff for regular users</li>
 *			<li>bothbadge: Display regular badges/stars for both staff and users</li>
 *		</ul>
 *	</li>
 *	<li>'shd_display_avatar' (checkbox) - whether to display avatars in the replies area or not</li>
 *	<li>'shd_ticketnav_style' (dropdown) - selects the type of navigation in the ticket area:
 *		<ul>
 *			<li>sd (default): use the original SimpleDesk style, icons+text in the bar just above the main ticket area</li>
 *			<li>sdcompact: use the SimpleDesk icons, in the bar just above the main ticket area, but no captions</li>
 *			<li>smf: use an SMF style button-strip above the ticket menu</li>
 *		</ul>
 *	</li>
 *	<li>'shd_theme' (dropdown) - selects the theme id to be used in the helpdesk, or 0 for the forum default</li>
 *	<li>'shd_hidemenuitem' (checkbox) - whether to show or hide the menu item, typically used with multiple departments</li>
 *	<li>'shd_disable_unread' (checkbox) - if checked, the integration of outstanding helpdesk tickets into the unread page is disabled</li>
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
 *	@since 1.0
 *	@see shd_admin_options()
*/
function shd_modify_display_options($return_config)
{
	global $context, $modSettings, $txt, $smcFunc;

	$theme_list = array(
		0 => $txt['shd_theme_use_default'],
	);
	$request = $smcFunc['db_query']('', '
		SELECT id_theme, value
		FROM {db_prefix}themes
		WHERE id_member = {int:member}
			AND id_theme > {int:theme}
			AND variable = {string:name}',
		array(
			'member' => 0,
			'theme' => 0,
			'name' => 'name',
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$theme_list[$row['id_theme']] = $row['value'];
	$smcFunc['db_free_result']($request);

	$config_vars = array(
		array('select', 'shd_staff_badge', array('nobadge' => $txt['shd_staff_badge_nobadge'], 'staffbadge' => $txt['shd_staff_badge_staffbadge'], 'userbadge' => $txt['shd_staff_badge_userbadge'], 'bothbadge' => $txt['shd_staff_badge_bothbadge']), 'subtext' => $txt['shd_staff_badge_note']),
		array('check', 'shd_display_avatar'),
		array('select', 'shd_ticketnav_style', array('sd' => $txt['shd_ticketnav_style_sd'], 'sdcompact' => $txt['shd_ticketnav_style_sdcompact'], 'smf' => $txt['shd_ticketnav_style_smf']), 'subtext' => $txt['shd_ticketnav_style_note']),
		array('select', 'shd_theme', $theme_list, 'subtext' => $txt['shd_theme_note']),
		array('int', 'shd_zerofill', 'subtext' => $txt['shd_zerofill_note']),
		'',
		array('check', 'shd_hidemenuitem', 'subtext' => $txt['shd_hidemenuitem_note']),
		'',
		array('check', 'shd_disable_unread', 'subtext' => $txt['shd_disable_unread_note']),
		array('check' , 'shd_disable_boardint', 'subtext' => $txt['shd_disable_boardint_note']),
		'',
		array('select', 'shd_block_order_1', array('assigned' => $txt['shd_status_assigned_heading'], 'new' => $txt['shd_status_' . TICKET_STATUS_NEW . '_heading'], 'staff' => $txt['shd_status_' . TICKET_STATUS_PENDING_STAFF . '_heading'], 'user' => $txt['shd_status_' . TICKET_STATUS_PENDING_USER . '_heading']), 'subtext' => $txt['shd_block_order_note']),
		array('select', 'shd_block_order_2', array('new' => $txt['shd_status_' . TICKET_STATUS_NEW . '_heading'], 'staff' => $txt['shd_status_' . TICKET_STATUS_PENDING_STAFF . '_heading'], 'user' => $txt['shd_status_' . TICKET_STATUS_PENDING_USER . '_heading'], 'assigned' => $txt['shd_status_assigned_heading']), 'subtext' => $txt['shd_block_order_note']),
		array('select', 'shd_block_order_3', array('staff' => $txt['shd_status_' . TICKET_STATUS_PENDING_STAFF . '_heading'], 'user' => $txt['shd_status_' . TICKET_STATUS_PENDING_USER . '_heading'], 'assigned' => $txt['shd_status_assigned_heading'], 'new' => $txt['shd_status_' . TICKET_STATUS_NEW . '_heading']), 'subtext' => $txt['shd_block_order_note']),
		array('select', 'shd_block_order_4', array('user' => $txt['shd_status_' . TICKET_STATUS_PENDING_USER . '_heading'], 'assigned' => $txt['shd_status_assigned_heading'], 'new' => $txt['shd_status_' . TICKET_STATUS_NEW . '_heading'], 'staff' => $txt['shd_status_' . TICKET_STATUS_PENDING_STAFF . '_heading']), 'subtext' => $txt['shd_block_order_note']),

	);
	$context['settings_title'] = $txt['shd_admin_options_display'];
	$context['settings_icon'] = 'details.png';

	call_integration_hook('shd_hook_admin_display', array(&$config_vars, &$return_config));
	return $config_vars;
}

/**
 *	General posting options for SimpleDesk.
 *
 *	<ul>
 *	<li>'shd_thank_you_post' (checkbox) - if checked, use $txt['shd_ticket_posted_body'] (in SimpleDesk.english.php) as a template of a message to display to the user thanking them for their ticket - and advising what's to come later.</li>
 *	<li>'shd_thank_you_nonstaff' (checkbox) - if checked, when the above option is invoked, only display the message to non staff members when they create their tickets.</li>
 *	<li>'shd_allow_wikilinks' (checkbox) - enable conversion of [[ticket:123]] into a regular link</li>
 *	<li>'shd_allow_ticket_bbc' (checkbox) - one-stop enable/disable of bbcode in tickets (see {@link shd_format_text()} for where this is used)</li>
 *	<li>'shd_allow_ticket_smileys' (checkbox) - one-stop enable/disable of smileys in tickets (see {@link shd_format_text()} for where this is used)</li>
 *	<li>'shd_attachments_mode' (dropdown) - selects the presentation of attachments to users:
 *		<ul>
 *			<li>ticket (default): treat attachments as if they are attached to the ticket overall; do not enforce max number per ticket</li>
 *			<li>reply: treat all attachments as attached to replies; enforce same limit per reply as with posts normally</li>
 *		</ul>
 *	</li>
 *	<li>'shd_bbc' (bbc) - enable/disable individual BBC tags around the helpdesk (see {@link shd_format_text()} for where this is used)</li>
 *	</ul>
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
 *	@since 1.0
 *	@see shd_admin_options()
 *	@see shd_format_text()
*/
function shd_modify_posting_options($return_config)
{
	global $context, $modSettings, $txt;

	$config_vars = array(
		array('check', 'shd_thank_you_post', 'javascript' => ' onchange="javascript:switchtyitems();"'),
		array('check', 'shd_thank_you_nonstaff', 'disabled' => empty($modSettings['shd_thank_you_post'])),
		'',
		array('check', 'shd_allow_wikilinks'),
		array('check', 'shd_allow_ticket_bbc', 'javascript' => ' onchange="javascript:switchitems();"'),
		array('check', 'shd_allow_ticket_smileys'),
		array('select', 'shd_attachments_mode', array('ticket' => $txt['shd_attachments_mode_ticket'], 'reply' => $txt['shd_attachments_mode_reply']), 'subtext' => $txt['shd_attachments_mode_note']),
		array('bbc', 'shd_bbc', 'subtext' => $txt['shd_bbc_desc'], 'invisible' => empty($modSettings['shd_allow_ticket_bbc']), 'force_div_id' => 'shd_bbc_dt'),
	);
	$context['settings_title'] = $txt['shd_admin_options_posting'];
	$context['settings_icon'] = 'smiley.png';
	$context['enabled_tags']['shd_bbc'] = !empty($modSettings['shd_enabled_bbc']) ? explode(',', $modSettings['shd_enabled_bbc']) : array();
	$context['available_tags'] = parse_bbc(false);
	$context['all_enabled']['shd_bbc'] = count($context['available_tags']) == count($context['enabled_tags']['shd_bbc']) ? 1 : 0;

	if (empty($context['settings_pre_javascript']))
		$context['settings_pre_javascript'] = '';

	$context['settings_pre_javascript'] .= '
		function switchtyitems()
		{
			var state = !document.getElementById("shd_thank_you_post").checked;
			shd_switchable_item("shd_thank_you_nonstaff", state);
		};
		function switchitems()
		{
			var state = document.getElementById("shd_allow_ticket_bbc").checked;
			document.getElementById("shd_bbc_dt").style.display = state ? "" : "none";
			document.getElementById("shd_bbc_dt_dd").style.display = state ? "" : "none";
		}';

	call_integration_hook('shd_hook_admin_posting', array(&$config_vars, &$return_config));
	return $config_vars;
}

/**
 *	General administrative options for SimpleDesk.
 *
 *	<ul>
 *	<li>'shd_maintenance_mode' (checkbox) - if checked, only forum adminstrators (group 1) and helpdesk admins can see the helpdesk</li>
 *	<li>'shd_staff_ticket_self' (checkbox) - if checked, a ticket opened by a staff member can be assigned to them to action.</li>
 *	<li>'shd_admins_not_assignable' (checkbox) - if checked, forum admins are not considered part of staff - a ticket cannot be assigned to them and they can't receive one-off notifications (since 2.0 only)</li>
 *	<li>'shd_privacy_display' (dropdown) - whether to display privacy or not:
 *		<ul>
 *			<li>smart (default): Display ticket privacy if it's likely to be relevant (if users can alter ticket privacy, and/or see private tickets AND the ticket is private, show it)</li>
 *			<li>always: Always display ticket privacy; likely to be confusing</li>
 *		</ul>
 *	</li>
 *	<li>'shd_disable_tickettotopic' (checkbox) - if checked, ticket to topic mode is entirely disabled.</li>
 *	<li>'shd_disable_relationships' (checkbox) - if checked, relationships are entirely disabled.</li>
 *	</ul>
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
 *	@since 1.0
 *	@see shd_admin_options()
*/
function shd_modify_admin_options($return_config)
{
	global $context, $modSettings, $txt;

	$config_vars = array(
		array('check', 'shd_maintenance_mode'),
		array('check', 'shd_staff_ticket_self'),
		array('check', 'shd_admins_not_assignable', 'subtext' => $txt['shd_admins_not_assignable_note']),
		array('select', 'shd_privacy_display', array('smart' => $txt['shd_privacy_display_smart'], 'always' => $txt['shd_privacy_display_always']), 'subtext' => $txt['shd_privacy_display_note']),
		array('check' , 'shd_disable_tickettotopic', 'subtext' => $txt['shd_disable_tickettotopic_note'], 'disabled' => !empty($modSettings['shd_helpdesk_only'])),
		array('check' , 'shd_disable_relationships', 'subtext' => $txt['shd_disable_relationships_note']),
	);
	$context['settings_title'] = $txt['shd_admin_options_admin'];
	$context['settings_icon'] = 'admin.png';

	call_integration_hook('shd_hook_admin_admin', array(&$config_vars, &$return_config));
	return $config_vars;
}

/**
 *	Configuration options for Standalone mode.
 *
 *	<ul>
 *	<li>'shd_helpdesk_only' (checkbox) - if checked, Standalone mode is active.</li>
 *	<li>'shd_disable_pm' (checkbox) - if checked, personal messages will not be available at all when SimpleDesk is in (active) Standalone mode</li>
 *	<li>'shd_disable_mlist' (checkbox) - if checked, the memberlist will not be available at all when SimpleDesk is in (active) Standalone mode</li>
 *	</ul>
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
 *	@since 1.0
 *	@see shd_admin_options()
*/
function shd_modify_standalone_options($return_config)
{
	global $context, $modSettings, $txt;

	$config_vars = array(
		array('check', 'shd_helpdesk_only', 'subtext' => $txt['shd_helpdesk_only_note'], 'javascript' => ' onchange="javascript:switchitems();"'),
		array('check', 'shd_disable_pm', 'disabled' => empty($modSettings['shd_helpdesk_only'])),
		array('check', 'shd_disable_mlist', 'disabled' => empty($modSettings['shd_helpdesk_only'])),
	);
	$context['settings_title'] = $txt['shd_admin_options_standalone'];
	$context['settings_icon'] = 'standalone.png';

	if (empty($context['settings_pre_javascript']))
		$context['settings_pre_javascript'] = '';

	$context['settings_pre_javascript'] .= '
		function switchitems()
		{
			var state = !document.getElementById("shd_helpdesk_only").checked;
			shd_switchable_item("shd_disable_pm", state);
			shd_switchable_item("shd_disable_mlist", state);
		}';

	if ($return_config)
	{
		call_integration_hook('shd_hook_admin_standalone', array(&$config_vars, &$return_config));
		return $config_vars;
	}

	// We saving?
	if (isset($_GET['save']))
	{
		// SMF 2.1 has a hook for the default action. Lets trigger it.
		if (isset($_POST['shd_helpdesk_only']))
		{
			add_integration_function('integrate_default_action', 'shd_main', true, '$sourcedir/sd_source/SimpleDesk.php');		
			add_integration_function('integrate_fallback_action', 'shd_main', true, '$sourcedir/sd_source/SimpleDesk.php');		
		}
	}

	return $config_vars;
}

/**
 *	Provides configuration options for the action log.
 *
 *	<ul>
 *	<li>'shd_disable_action_log' (checkbox) - if checked, no actions are added to the action log.</li>
 *	<li>'shd_display_ticket_logs' (checkbox) - if checked, a ticket's specific log is displayed at the foot of the ticket.</li>
 *	<li>'shd_logopt_newposts' (checkbox) - if checked, a ticket's being creation and subsequent replies will be logged.</li>
 *	<li>'shd_logopt_editposts' (checkbox) - if checked, a ticket or its replies being edited will be logged.</li>
 *	<li>'shd_logopt_resolve' (checkbox) - if checked, a ticket's being closed and/or reopened will be logged.</li>
 *	<li>'shd_logopt_autoclose' (checkbox) - if checked, tickets being closed by the helpdesk due to age will be logged.</li>
 *	<li>'shd_logopt_assign' (checkbox) - if checked, a ticket being assigned/reassigned/unassigned will be logged.</li>
 *	<li>'shd_logopt_privacy' (checkbox) - if checked, ticket privacy changes will be logged.</li>
 *	<li>'shd_logopt_urgency' (checkbox) - if checked, ticket urgency changes will be logged.</li>
 *	<li>'shd_logopt_tickettopicmove' (checkbox) - if checked, ticket to topic moves and back will be logged.</li>
 *	<li>'shd_logopt_cfchanges' (checkbox) - if checked, changes to custom fields will be logged.</li>
 *	<li>'shd_logopt_delete' (checkbox) - if checked, ticket/reply deletions (not permadelete) will be logged.</li>
 *	<li>'shd_logopt_restore' (checkbox) - if checked, ticket/reply restores will be logged.</li>
 *	<li>'shd_logopt_permadelete' (checkbox) - if checked, permadeletes will be logged.</li>
 *	<li>'shd_logopt_relationships' (checkbox) - if checked, ticket relationship changes will be logged.</li>
 *	<li>'shd_logopt_move_dept' (checkbox) - if checked, ticket moves between departments will be logged.</li>
 *	<li>'shd_logopt_monitor' (checkbox) - if checked, users adding/removing tickets to/from their monitor lists will be logged.</li>
 *	</ul>
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
 *	@since 1.0
 *	@see shd_admin_options()
*/
function shd_modify_actionlog_options($return_config)
{
	global $context, $modSettings, $txt;

	$multi_dept = shd_allowed_to('access_helpdesk', false);

	$config_vars = array(
		array('check', 'shd_disable_action_log', 'javascript' => ' onchange="javascript:switchitems();"'),
		array('check', 'shd_display_ticket_logs', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		'',
		array('check', 'shd_logopt_newposts', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_editposts', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_resolve', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_autoclose', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('checkall', 'shd_logopt_1', array('shd_logopt_newposts', 'shd_logopt_editposts', 'shd_logopt_resolve', 'shd_logopt_autoclose')),
		'',
		array('check', 'shd_logopt_assign', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_privacy', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_urgency', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_tickettopicmove', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_cfchanges', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('checkall', 'shd_logopt_2', array('shd_logopt_assign', 'shd_logopt_privacy', 'shd_logopt_urgency', 'shd_logopt_tickettopicmove', 'shd_logopt_cfchanges')),
		'',
		array('check', 'shd_logopt_delete', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_restore', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_permadelete', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('check', 'shd_logopt_relationships', 'disabled' => (!empty($modSettings['shd_disable_action_log']) || !empty($modSettings['shd_disable_relationships']))),
		array('checkall', 'shd_logopt_3', array('shd_logopt_delete', 'shd_logopt_restore', 'shd_logopt_permadelete', 'shd_logopt_relationships')),
		'',
		array('check', 'shd_logopt_move_dept', 'disabled' => !empty($modSettings['shd_disable_action_log']) && !empty($multi_dept)),
		array('check', 'shd_logopt_monitor', 'disabled' => !empty($modSettings['shd_disable_action_log'])),
		array('checkall', 'shd_logopt_4', array('shd_logopt_move_dept', 'shd_logopt_monitor')),
	);
	$context['settings_title'] = $txt['shd_admin_options_actionlog'];
	$context['settings_icon'] = 'log.png';

	if (empty($context['settings_pre_javascript']))
		$context['settings_pre_javascript'] = '';

	$context['settings_pre_javascript'] .= '
		function switchitems()
		{
			var state = document.getElementById("shd_disable_action_log").checked;
			shd_switchable_item("shd_display_ticket_logs", state);
			shd_switchable_item("shd_logopt_newposts", state);
			shd_switchable_item("shd_logopt_editposts", state);
			shd_switchable_item("shd_logopt_resolve", state);
			shd_switchable_item("shd_logopt_autoclose", state);
			shd_switchable_item("shd_logopt_assign", state);
			shd_switchable_item("shd_logopt_privacy", state);
			shd_switchable_item("shd_logopt_urgency", state);
			shd_switchable_item("shd_logopt_tickettopicmove", state);
			shd_switchable_item("shd_logopt_cfchanges", state);
			shd_switchable_item("shd_logopt_delete", state);
			shd_switchable_item("shd_logopt_restore", state);
			shd_switchable_item("shd_logopt_permadelete", state);
			shd_switchable_item("shd_logopt_relationships", state);
			shd_switchable_item("shd_logopt_move_dept", state);
			shd_switchable_item("shd_logopt_monitor", state);
		}';

	call_integration_hook('shd_hook_admin_actionlog', array(&$config_vars, &$return_config));
	return $config_vars;
}

/**
 *	Displays notifications options within SD ACP / Options / Notifications
 *
 *	<ul>
 *	<li>'shd_notify_email' (text) - if specified, an email address to set as the reply-to address on any email notifications</li>
 *	<li>'shd_notify_log' (checkbox) - if checked, a log will be kept of outgoing notification</li>
 *	<li>'shd_notify_with_body' (checkbox) - if checked, the outgoing emails will have the email body where appropriate</li>
 *	<li>'shd_notify_new_ticket' (checkbox) - if checked, staff have the option of being notified when a new ticket is posted</li>
 *	<li>'shd_notify_new_reply_own' (checkbox) - if checked, users have the option to have notifications upon reply to any ticket they started</li>
 *	<li>'shd_notify_new_reply_assigned' (checkbox) - if checked, staff have the option to select notifications upon reply to any ticket assigned to them</li>
 *	<li>'shd_notify_new_reply_previous' (checkbox) - if checked, staff have the option to select notifications upon reply to any ticket they already replied to</li>
 *	<li>'shd_notify_new_reply_any' (checkbox) - if checked, staff have the option to select notifications upon any reply to any ticket they can see</li>
 *	<li>'shd_notify_assign_me' (checkbox) - if checked, staff have the option to have notifications sent to them when tickets are assigned to them</li>
 *	<li>'shd_notify_assign_own' (checkbox) - if checked, users have the option to be notified when one of their tickets is assigned to a staff member</li>
 *	</ul>
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
*/
function shd_modify_notifications_options($return_config)
{
	global $context, $modSettings, $txt, $webmaster_email;

	$txt['shd_notify_email'] = sprintf($txt['shd_notify_email'], $webmaster_email);

	$config_vars = array(
		array('text', 'shd_notify_email'),
		array('check', 'shd_notify_log'),
		array('check', 'shd_notify_with_body'),
		array('check', 'shd_notify_new_ticket'),
		array('check', 'shd_notify_new_reply_own'),
		array('check', 'shd_notify_new_reply_assigned'),
		array('check', 'shd_notify_new_reply_previous'),
		array('check', 'shd_notify_new_reply_any'),
		array('check', 'shd_notify_assign_me'),
		array('check', 'shd_notify_assign_own'),
	);
	// Lazy way to build the master on/off switch
	$array = array();
	foreach ($config_vars as $var)
	{
		if ($var[0] == 'check')
			$array[] = $var[1];
	}
	$config_vars[] = array('checkall', 'shd_notify_checkall', $array);

	$context['settings_title'] = $txt['shd_admin_options_notifications'];
	$context['settings_icon'] = 'email.png';

	// If we're being called from admin search, just return stuff
	if ($return_config)
	{
		call_integration_hook('shd_hook_admin_notify', array(&$config_vars, &$return_config));
		return $config_vars;
	}

	// Otherwise... this is where things get... interesting.
	$subtext = array(
		'shd_notify_new_ticket' => '',
		'shd_notify_new_reply_own' => $txt['shd_notify_send_to'] . ': ' . $txt['shd_notify_ticket_starter'],
		'shd_notify_new_reply_assigned' => '',
		'shd_notify_new_reply_previous' => '',
		'shd_notify_new_reply_any' => '',
		'shd_notify_assign_me' => '',
		'shd_notify_assign_own' => $txt['shd_notify_send_to'] . ': ' . $txt['shd_notify_ticket_starter'],
	);

	foreach ($config_vars as $id => $item)
	{
		list(, $item_id) = $item;
		if (!empty($subtext[$item_id]))
			$config_vars[$id]['subtext'] = $subtext[$item_id];
	}

	call_integration_hook('shd_hook_admin_notify', array(&$config_vars, &$return_config));
	return $config_vars;
}

/**
 *	Initialises the helpdesk action log.
 *
 *	This function loads the language strings, and hands off to {@link shd_load_action_log_entries()} to perform the actual log
 *	generation.
 *
 *	Before doing so, however, this function will also prepare for deletion of old entries, as well as sorting out the columns and
 *	ordering rules before handing control to the other function.
 *
 *	@since 1.0
*/
function shd_admin_action_log()
{
	global $context, $settings, $scripturl, $txt, $sourcedir, $smcFunc, $sort_types;

	shd_load_language('sd_language/SimpleDeskLogAction');

	$context['can_delete'] = allowedTo('admin_forum');

	$context['displaypage'] = 30;
	$context['hoursdisable'] = 24;
	$context['waittime'] = time() - $context['hoursdisable'] * 3600;

	// Handle deletion...
	if (isset($_REQUEST['removeall']) && $context['can_delete'])
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_log_action
			WHERE log_time < {int:twenty_four_hours_wait}',
			array(
				'twenty_four_hours_wait' => $context['waittime'],
			)
		);
	elseif (!empty($_REQUEST['remove']) && $context['can_delete'])
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_log_action
			WHERE id_action = {int:gtfo}
			AND log_time < {int:twenty_four_hours_wait}',
			array(
				'twenty_four_hours_wait' => $context['waittime'],
				'gtfo' => (int) $_REQUEST['remove'],
			)
		);

	// Do the column stuff!
	$sort_types = array(
		'action' =>'la.action',
		'time' => 'la.log_time',
		'member' => 'mem.real_name',
		'position' => 'mg.group_name',
		'ip' => 'la.ip',
	);

	// Setup the direction stuff...
	$context['sort'] = isset($_REQUEST['sort']) && isset($sort_types[$_REQUEST['sort']]) ? $sort_types[$_REQUEST['sort']] : $sort_types['time'];
	$context['start'] = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
	$context['order'] = isset($_REQUEST['asc']) ? 'ASC' : 'DESC';
	$context['url_sort'] = isset($_REQUEST['sort']) ? ';sort=' . $_REQUEST['sort'] : '';
	$context['url_order'] =  isset($_REQUEST['asc']) ? ';asc' : '';

	// Get all action log entries
	$context['actions'] = shd_load_action_log_entries($context['start'], $context['displaypage'], $context['sort'], $context['order']);

	$context['page_index'] = shd_no_expand_pageindex($scripturl . '?action=admin;area=helpdesk_info;sa=actionlog' . $context['url_sort'] . $context['url_order'], $context['start'], shd_count_action_log_entries(), $context['displaypage']);

	$context['sub_template'] = 'shd_action_log';
}

/**
 *	Initialises the helpdesk admin log.
 *
 *	@since 2.1
*/
function shd_admin_admin_log()
{
	global $context, $settings, $scripturl, $txt, $sourcedir, $smcFunc, $sort_types;

	shd_load_language('sd_language/SimpleDeskLogAction');

	// This is for full admins only.
	isAllowedTo('admin_forum');
	$context['can_delete'] = true;

	$context['displaypage'] = 30;
	$context['daysdisable'] = 28;
	$context['waittime'] = time() - $context['daysdisable'] * 24 * 3600;

	// Handle deletion...
	if (isset($_REQUEST['removeall']))
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_log_action
			WHERE log_time < {int:twenty_four_hours_wait}',
			array(
				'twenty_four_hours_wait' => $context['waittime'],
			)
		);
	elseif (!empty($_REQUEST['remove']) && $context['can_delete'])
		shd_db_query('', '
			DELETE FROM {db_prefix}helpdesk_log_action
			WHERE id_action = {int:gtfo}
			AND log_time < {int:twenty_four_hours_wait}',
			array(
				'twenty_four_hours_wait' => $context['waittime'],
				'gtfo' => (int) $_REQUEST['remove'],
			)
		);

	// Do the column stuff!
	$sort_types = array(
		'action' =>'la.action',
		'time' => 'la.log_time',
		'member' => 'mem.real_name',
		'position' => 'mg.group_name',
		'ip' => 'la.ip',
	);

	// Setup the direction stuff...
	$context['sort'] = isset($_REQUEST['sort']) && isset($sort_types[$_REQUEST['sort']]) ? $sort_types[$_REQUEST['sort']] : $sort_types['time'];
	$context['start'] = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
	$context['order'] = isset($_REQUEST['asc']) ? 'ASC' : 'DESC';
	$context['url_sort'] = isset($_REQUEST['sort']) ? ';sort=' . $_REQUEST['sort'] : '';
	$context['url_order'] =  isset($_REQUEST['asc']) ? ';asc' : '';

	// Get all action log entries
	$context['actions'] = shd_load_admin_log_entries($context['start'], $context['displaypage'], $context['sort'], $context['order']);

	$context['page_index'] = shd_no_expand_pageindex($scripturl . '?action=admin;area=helpdesk_info;sa=adminlog' . $context['url_sort'] . $context['url_order'], $context['start'], shd_count_admin_log_entries(), $context['displaypage']);

	$context['sub_template'] = 'shd_admin_log';
}

/**
 *	Loads the support page for users to submit support requests directly to SimpleDesk.net
 *
 *	Very small function because essentially it just loads a template; there is no logic or processing to actually perform.
 *
 *	@since 1.0
*/
function shd_admin_support()
{
	global $context;

	$context['shd_support_url'] = 'http://www.simpledesk.net/support/post.php';
	$context['sub_template'] = 'shd_support';
}

/**
 *	Loads the list of credits of people who've worked on SimpleDesk.
 *
 *	This defines the list of peoples' names, and none of it will be in language strings; the actual category titles and positions
 *	will be, but the names themselves can live in this file normally.
 *
 *	@since 1.0
*/
function shd_credits()
{
	global $context, $txt, $scripturl;

	// Credits!
	$context['shd_credits'] = array(
		array(
			'pretext' => $txt['shd_credits_pretext'],
			'groups' => array(
				array(
					'title' => $txt['shd_credits_devs'],
					'desc' => $txt['shd_credits_devs_desc'],
					'icon' => 'devs.png',
					'members' => array(
						array('Peter &quot;Arantor&quot; Spicer', false),
						array('Jason &quot;JBlaze&quot; Clemons', true),
						array('Marcus &quot;c&#963;&#963;&#1082;&#953;&#1108; &#1084;&#963;&#951;&#1109;&#1090;&#1108;&#1103;&quot; Forsberg', true),
					),
				),
				array(
					'title' => $txt['shd_credits_projectsupport'],
					'desc' => $txt['shd_credits_projectsupport_desc'],
					'icon' => 'managers.png',
					'members' => array(
						array('Graeme &quot;Trekkie101&quot; Spence', false),
						array('Jeremy &quot;SleePy&quot; Darwood', false),
					),
				),
				array(
					'title' => $txt['shd_credits_marketing'],
					'desc' => $txt['shd_credits_marketing_desc'],
					'icon' => 'marketers.png',
					'members' => array(
						array('Brannon &quot;B&ordf;&quot; Hall', false),
					),
				),
				array(
					'title' => $txt['shd_credits_globalizer'],
					'desc' => $txt['shd_credits_globalizer_desc'],
					'icon' => 'globalizers.png',
					'members' => array(
						array('Jerry Osborne', true),
					),
				),
				array(
					'title' => $txt['shd_credits_support'],
					'desc' => $txt['shd_credits_support_desc'],
					'icon' => 'support.png',
					'members' => array(
						array('Tyrsson', true),
						array('Ha2', true),
						array('Aldo &quot;hadesflames&quot; Barreras', true),
					),
				),
				array(
					'title' => $txt['shd_credits_qualityassurance'],
					'desc' => $txt['shd_credits_qualityassurance_desc'],
					'icon' => 'qa.png',
					'members' => array(
						array('Sinan &quot;[SiNaN]&quot; &Ccedil;evik', false),
						array('Paul &quot;tfs&quot; Laufer', false),
						array('Shomari &quot;spoogs&quot; Scott', false),
						array('Alex &quot;Cleo&quot; Tokar', true),
					),
				),
				array(
					'title' => $txt['shd_credits_beta'],
					'desc' => $txt['shd_credits_beta_desc'],
					'icon' => 'testers.png',
					'members' => array(
						array('Chris &quot;ccbtimewiz&quot; Batista', false),
						array('Wade &quot;&#1109;&#951;&#963;&#969;&quot; Poulsen', false),
						array('Edwin &quot;Dismal Shadow&quot; Mendez', false),
						array('Treznax', false),
						array('Mark &quot;KiLLuMiNaTi&minus;7&minus;&quot; Longworth', false),
						array('NIBOGO', false),
						array('Robert &quot;Robbo&quot; Clancy', false),
						array('Ya&#x11F;izcan Arslan', false),
						array('MultiformeIngegno', false),
						array('flapjack', false),
						array('feline',	false),
						array('Sordell Media', false),
						array('[FailSafe]', false),
						array('chilly', false),
						array('Tah Zonemaster', false),
					),
				),
				array(
					'title' => $txt['shd_credits_alltherest'],
					'desc' => '', // This group has its description included in the title.
					'icon' => 'others.png',
					'members' => array(
						array('Fluffy - ' . sprintf($txt['shd_fluffy'],'onclick="window.location.href=\'' . $scripturl . '?action=admin;area=helpdesk_info;cookies\'"'),false),
						array('<br>' . $txt['shd_credits_translators'],false),
						array('<br>' . sprintf($txt['shd_credits_icons'], 'http://p.yusukekamiyamane.com/', 'http://wefunction.com/2008/07/function-free-icon-set/', 'http://www.famfamfam.com/lab/icons/flags/', 'http://www.everaldo.com/crystal/'),false),
						array('<br>' . $txt['shd_credits_user'],false),
					),
				),
			),
		),
	);
}

/**
 *	@ignore
 *	@since 1.0
*/
function shd_do_important()
{
	// Execute code number 66.
	die(base64_decode('PCFET0NUWVBFIGh0bWwgUFVCTElDICItLy9XM0MvL0RURCBYSFRNTCAxLjAgVHJhbnNpdGlvbmFsLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL1RSL3hodG1sMS9EVEQveGh0bWwxLXRyYW5zaXRpb25hbC5kdGQiPjxodG1sIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hodG1sIj48aGVhZD48dGl0bGU+Rmx1ZmZ5IC0gR3VhcmRpYW4gb2YgdGhlIGNvb2tpZXo8L3RpdGxlPjxtZXRhIGh0dHAtZXF1aXY9IkNvbnRlbnQtVHlwZSIgY29udGVudD0idGV4dC9odG1sOyBjaGFyc2V0PVVURi04IiAvPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+Ym9keXtiYWNrZ3JvdW5kOnB1cnBsZTtjb2xvcjp3aGl0ZTtmb250LXNpemU6MzBweDt0ZXh0LWFsaWduOmNlbnRlcjt9PC9zdHlsZT48L2hlYWQ+PGJvZHk+PGltZyBzcmM9Imh0dHA6Ly93d3cuc2ltcGxlZGVzay5uZXQvaW1hZ2VzL3NpdGUvZ3VhcmRkb2c0MDMuanBnIiBhbHQ9IiIgb25jbGljaz0iYWxlcnQoJ1dhcm5pbmc6IEhlIG1heSBiaXRlIScpIi8+PGJyIC8+PGJyIC8+PHN0cm9uZz5GbHVmZnk8L3N0cm9uZz4gc2VlcyB5b3UuIEZsdWZmeSB3aWxsIHByb3RlY3Qgb3VyIGNhbmR5IDxzdHJvbmc+Zm9yIGV2ZXI8L3N0cm9uZz4uIEZsdWZmeSBpcyB0aGUgPHN0cm9uZz5ndWFyZGlhbjwvc3Ryb25nPiBvZiB0aGUgPHN0cm9uZz5jb29raWVzPC9zdHJvbmc+LiBCZSBhd2FyZS48L2JvZHk+PC9odG1sPg==')); // It will be done, my lord.
}
