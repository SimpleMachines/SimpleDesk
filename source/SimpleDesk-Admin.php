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
# File Info: SimpleDesk-Admin.php / 1.0 Felidae               #
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
	global $context, $scripturl, $sourcedir, $settings, $txt, $modSettings;

	// Templates and stuff
	loadTemplate('SimpleDesk-Admin');
	shd_load_language('SimpleDeskAdmin');

	// Load some extra CSS
	$context['html_headers'] .= '
	<link rel="stylesheet" type="text/css" href="' . $settings['default_theme_url'] . '/css/helpdesk_admin.css" />
	<link rel="stylesheet" type="text/css" href="' . $settings['default_theme_url'] . '/css/helpdesk.css" />
	<script type="text/javascript" src="' . $settings['default_theme_url'] . '/scripts/helpdesk_admin.js?rc2"></script>';
	$context['page_title'] = $txt['shd_admin_title'];

	// Kick them in the kneecaps!
	shd_is_allowed_to(array('admin_forum', 'admin_helpdesk'));

	// We need this for later
	require_once($sourcedir . '/ManageServer.php');
	require_once($sourcedir . '/Subs-SimpleDeskAdmin.php');

	// Create some subactions
	$subActions = array(
		'helpdesk_info' => 'shd_admin_info',
		'helpdesk_options' => 'shd_admin_options',
		'helpdesk_actionlog' => 'shd_admin_action_log',
		'helpdesk_support' => 'shd_admin_support',
	);

	// Make sure we can find a subaction. If not set, default to info
	$_REQUEST['area'] = isset($_REQUEST['area']) && isset($subActions[$_REQUEST['area']]) ? $_REQUEST['area'] : 'helpdesk_info';
	$context['sub_action'] = $_REQUEST['area'];

	$context['shd_version'] = 'SimpleDesk 1.0.1';

	// Call our subaction
	if ($_REQUEST['area'] == 'helpdesk_options')
		$subActions[$_REQUEST['area']](false);
	else
		$subActions[$_REQUEST['area']]();

	// Important ACS666 check up.
	if (isset($_REQUEST['cookies']))
		shd_do_important();
}

/**
 *	Loads the main SimpleDesk information page for forum administrators.
 *
 *	This function primarily collects information about SimpleDesk before handing over to the template:
 *	<ul>
 *	<li>list of helpdesk staff</li>
 *	<li>totals of tickets in the system (open/closed/deleted)</li>
 *	<li>credits</li>
 *	<li>also, in the template, whether this is a current or outdated version of SimpleDesk</li>
 *	</ul>
 *
 *	@since 1.0
*/
function shd_admin_info()
{
	global $context, $settings, $scripturl, $txt, $sourcedir, $smcFunc;

	// No little pixies allowed!
	shd_is_allowed_to(array('admin_forum', 'admin_helpdesk'));

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
 *	This function handles all the sub areas under General Options, and adds the options listed below in $modSettings.
 *
 *	<strong>Display options</strong>
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
 *
 *	<strong>Posting options</strong>
 *	<li>'shd_allow_ticket_bbc' (checkbox) - one-stop enable/disable of bbcode in tickets (see {@link shd_format_text()} for
 *	where this is used)</li>
 *	<li>'shd_allow_ticket_smileys' (checkbox) - one-stop enable/disable of smileys in tickets (see {@link shd_format_text()}
 *	for where this is used)</li>
 *	<li>'shd_attachments_mode' (dropdown) - selects the presentation of attachments to users:
 *		<ul>
 *			<li>ticket (default): treat attachments as if they are attached to the ticket overall; do not enforce max number per ticket</li>
 *			<li>reply: treat all attachments as attached to replies; enforce same limit per reply as with posts normally</li>
 *		</ul>
 *	</li>
 *	<li>'shd_bbc' (bbc) - enable/disable individual BBC tags around the helpdesk (see {@link shd_format_text()} for where this is used)</li>
 *	</ul>
 *
 *	<strong>Administrative options</strong>
 *	<ul>
 *	<li>'shd_disable_action_log' (checkbox) - if checked, no actions are added to the action log.</li>
 *	<li>'shd_staff_ticket_self' (checkbox) - if checked, a ticket opened by a staff member can be assigned to them to action.</li>
 *	<li>'shd_admins_not_assignable' (checkbox) - if checked, a ticket cannot be assigned to forum admins, only regular staff. (Since 1.1 only)</li>
 *	<li>'shd_privacy_display' (dropdown) - whether to display privacy or not:
 *		<ul>
 *			<li>smart (default): Display ticket privacy if it's likely to be relevant (if users can alter ticket privacy, and/or see private tickets AND the ticket is private, show it)</li>
 *			<li>always: Always display ticket privacy; likely to be confusing</li>
 *		</ul>
 *	</li>
 *	</ul>
 *
 *	<strong>Standalone options</strong>
 *	<ul>
 *	<li>'shd_helpdesk_only' (checkbox) - if checked, Standalone mode is active.</li>
 *	<li>'shd_disable_pm' (checkbox) - if checked, personal messages will not be available at all when SimpleDesk is in (active) Standalone mode</li>
 *	<li>'shd_disable_mlist' (checkbox) - if checked, the memberlist will not be available at all when SimpleDesk is in (active) Standalone mode</li>
 *	</ul>
 *
 *	@see shd_format_text()
 *	@since 1.0
*/
function shd_admin_options($return_config, $override = '')
{
	global $context, $scripturl, $sourcedir, $txt, $modSettings, $settings;

	$_REQUEST['sa'] = isset($_REQUEST['sa']) ? $_REQUEST['sa'] : 'display';
	if (!empty($override))
		$_REQUEST['sa'] = $override;

	// Set up defaults
	$defaults = array(
		'shd_attachments_mode' => 'ticket',
		'shd_ticketnav_style' => 'sd',
		'shd_staff_badge' => 'nobadge',
		'shd_privacy_display' => 'smart',
	);

	foreach ($defaults as $var => $val)
	{
		if (empty($modSettings[$var]))
			$modSettings[$var] = $val;
	}

	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => '<img src="' . $settings['default_images_url'] . '/simpledesk/status.png" class="icon" alt="*" />' . $txt['shd_admin_options'],
		'description' => $txt['shd_admin_options_desc'],
		'tabs' => array(
			'display' => array(
				'description' => $txt['shd_admin_options_display_desc'],
			),
			'posting' => array(
				'description' => $txt['shd_admin_options_posting_desc'],
			),
			'admin' => array(
				'description' => $txt['shd_admin_options_admin_desc'],
			),
			'standalone' => array(
				'description' => $txt['shd_admin_options_standalone_desc'],
			),
		),
	);

	switch ($_REQUEST['sa'])
	{
		case 'display':
		default:
			$_REQUEST['sa'] = 'display'; // just in case it wasn't valid before
			$config_vars = array(
				array('select', 'shd_staff_badge', array('nobadge' => $txt['shd_staff_badge_nobadge'], 'staffbadge' => $txt['shd_staff_badge_staffbadge'], 'userbadge' => $txt['shd_staff_badge_userbadge'], 'bothbadge' => $txt['shd_staff_badge_bothbadge']), 'subtext' => $txt['shd_staff_badge_note']),
				array('check', 'shd_display_avatar'),
				array('select', 'shd_ticketnav_style', array('sd' => $txt['shd_ticketnav_style_sd'], 'sdcompact' => $txt['shd_ticketnav_style_sdcompact'], 'smf' => $txt['shd_ticketnav_style_smf']), 'subtext' => $txt['shd_ticketnav_style_note']),
			);
			$context['settings_title'] = $txt['shd_admin_options_display'];
			$context['settings_icon'] = 'details.png';
			break;

		case 'posting':
			$config_vars = array(
				array('check', 'shd_allow_ticket_bbc'),
				array('check', 'shd_allow_ticket_smileys'),
				array('select', 'shd_attachments_mode', array('ticket' => $txt['shd_attachments_mode_ticket'], 'reply' => $txt['shd_attachments_mode_reply']), 'subtext' => $txt['shd_attachments_mode_note']),
				array('bbc', 'shd_bbc', 'subtext' => $txt['shd_bbc_desc']),
			);
			$context['settings_title'] = $txt['shd_admin_options_posting'];
			$context['settings_icon'] = 'smiley.png';
			$context['enabled_tags']['shd_bbc'] = !empty($modSettings['shd_enabled_bbc']) ? explode(',', $modSettings['shd_enabled_bbc']) : array();
			$context['available_tags'] = parse_bbc(false);
			$context['all_enabled']['shd_bbc'] = count($context['available_tags']) == count($context['enabled_tags']['shd_bbc']) ? 1 : 0;
			break;

		case 'admin':
			$config_vars = array(
				array('check', 'shd_disable_action_log'),
				array('check', 'shd_staff_ticket_self'),
				array('check', 'shd_admins_not_assignable'),
				array('select', 'shd_privacy_display', array('smart' => $txt['shd_privacy_display_smart'], 'always' => $txt['shd_privacy_display_always']), 'subtext' => $txt['shd_privacy_display_note']),
			);
			$context['settings_title'] = $txt['shd_admin_options_admin'];
			$context['settings_icon'] = 'admin.png';
			break;

		case 'standalone':
			$config_vars = array(
				array('check', 'shd_helpdesk_only', 'subtext' => $txt['shd_helpdesk_only_note']),
				array('check', 'shd_disable_pm'),
				array('check', 'shd_disable_mlist'),
			);
			$context['settings_title'] = $txt['shd_admin_options_standalone'];
			$context['settings_icon'] = 'standalone.png';
			break;
	}

	if ($return_config)
		return $config_vars;

	loadTemplate('SimpleDesk-Admin');
	$context['sub_template'] = 'shd_show_settings';

	$context['post_url'] = $scripturl . '?action=admin;area=helpdesk_options;save;sa=' . $_REQUEST['sa'];

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

		saveDBSettings($save_vars);
		redirectexit('action=admin;area=helpdesk_options;sa=' . $_REQUEST['sa']);
	}

	prepareDBSettingContext($config_vars);
}

// Since we only have one master function doing it all, not multiple normal functions... we have to do this to appease the God of Admin Search
/**
 *	Provide a helper callback for admin search area.
 *
 *	SMF 2.0 features an admin search area, and to identify what settings there are, it calls the function that will handle the searching,
 *	which is required to then return a list of possible options' language strings.
 *
 *	Since all of the SD options are currently handled in a single parameterised function, we have to provide a non-parameterised version
 *	that the ACP can call, which is this function.
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
 *	@since 1.0
 *	@see shd_admin_options()
*/
function shd_modify_display_options($return_config)
{
	return shd_admin_options($return_config, 'display');
}

/**
 *	Provide a helper callback for admin search area.
 *
 *	SMF 2.0 features an admin search area, and to identify what settings there are, it calls the function that will handle the searching,
 *	which is required to then return a list of possible options' language strings.
 *
 *	Since all of the SD options are currently handled in a single parameterised function, we have to provide a non-parameterised version
 *	that the ACP can call, which is this function.
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
 *	@since 1.0
 *	@see shd_admin_options()
*/
function shd_modify_posting_options($return_config)
{
	return shd_admin_options($return_config, 'posting');
}

/**
 *	Provide a helper callback for admin search area.
 *
 *	SMF 2.0 features an admin search area, and to identify what settings there are, it calls the function that will handle the searching,
 *	which is required to then return a list of possible options' language strings.
 *
 *	Since all of the SD options are currently handled in a single parameterised function, we have to provide a non-parameterised version
 *	that the ACP can call, which is this function.
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
 *	@since 1.0
 *	@see shd_admin_options()
*/
function shd_modify_admin_options($return_config)
{
	return shd_admin_options($return_config, 'admin');
}

/**
 *	Provide a helper callback for admin search area.
 *
 *	SMF 2.0 features an admin search area, and to identify what settings there are, it calls the function that will handle the searching,
 *	which is required to then return a list of possible options' language strings.
 *
 *	Since all of the SD options are currently handled in a single parameterised function, we have to provide a non-parameterised version
 *	that the ACP can call, which is this function.
 *
 *	@param bool $return_config Whether to return configuration items or not; this is provided solely for SMF ACP compatibility (it expects to pass bool true in to get a list of options)
 *
 *	@return array An array of items that make up the search options on the given admin page, each item is itself an array of (type, option name/language string, [other related information])
 *	@since 1.0
 *	@see shd_admin_options()
*/
function shd_modify_standalone_options($return_config)
{
	return shd_admin_options($return_config, 'standalone');
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

	shd_load_language('SimpleDeskLogAction');

	// Top information stuff.
	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => $txt['shd_admin_options'],
		'help' => $txt['shd_admin_options_desc'],
		'description' => $txt['shd_admin_options_desc'],
		'tabs' => array(),
	);

	$context['can_delete'] = shd_allowed_to('admin_forum');

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

	$context['page_index'] = shd_no_expand_pageindex($scripturl . '?action=admin;area=helpdesk_actionlog' . $context['url_sort'] . $context['url_order'], $_REQUEST['start'], shd_count_action_log_entries(), $context['displaypage']);

	$context['sub_template'] = 'shd_action_log';
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
					'members' => array(
						'Peter &quot;Arantor&quot; Spicer',
						'Jason &quot;JBlaze&quot; Clemons',
						'Marcus &quot;Nas&quot; Forsberg',
					),
				),
				array(
					'title' => $txt['shd_credits_projectsupport'],
					'desc' => $txt['shd_credits_projectsupport_desc'],
					'members' => array(
						'Graeme &quot;Trekkie101&quot; Spence',
						'Jeremy &quot;SleePy&quot; Darwood',
					),
				),
				array(
					'title' => $txt['shd_credits_marketing'],
					'desc' => $txt['shd_credits_marketing_desc'],
					'members' => array(
						'Brannon &quot;B&ordf;&quot; Hall',
					),
				),
				array(
					'title' => $txt['shd_credits_globalizer'],
					'desc' => $txt['shd_credits_globalizer_desc'],
					'members' => array(
						'Jerry Osborne',
					),
				),
				array(
					'title' => $txt['shd_credits_support'],
					'desc' => $txt['shd_credits_support_desc'],
					'members' => array(
						'Tyrsson',
						'Ha2',
					),
				),
				array(
					'title' => $txt['shd_credits_qualityassurance'],
					'desc' => $txt['shd_credits_qualityassurance_desc'],
					'members' => array(
						'Sinan &quot;[SiNaN]&quot; &Ccedil;evik',
						'Alex &quot;Cleo&quot; Tokar',
					),
				),
				array(
					'title' => $txt['shd_credits_beta'],
					'desc' => $txt['shd_credits_beta_desc'],
					'members' => array(
						'Chris &quot;ccbtimewiz&quot; Batista',
						'Wade &quot;Acans&quot; Poulsen',
						'Aldo &quot;hadesflames&quot; Barreras',
						'tfs',
						'Edwin &quot;Dismal Shadow&quot; Mendez',
						'Treznax',
						'Mark &quot;KiLLuMiNaTi&minus;7&minus;&quot; Longworth',
						'NIBOGO',
						'Robert &quot;Robbo&quot; Clancy',
						'Ya&#x11F;izcan Arslan',
					),
				),
				array(
					'title' => $txt['shd_credits_alltherest'],
					'desc' => '', // This group has its description included in the title.
					'members' => array(
						'Fluffy - ' . sprintf($txt['shd_fluffy'],'onclick="window.location.href=\'' . $scripturl . '?action=admin;area=helpdesk_info;cookies\'"'),
						'<br /><a href="http://led24.de/iconset/">LED Icon Set</a> - ' . $txt['shd_credits_ledicons'],
						'<br />' . $txt['shd_credits_user'],
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

?>