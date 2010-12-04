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
# File Info: SimpleDesk-Admin.english.php / 1.0 Felidae       #
###############################################################
// Version: 1.0 Felidae; SimpleDesk administration options

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	This file contains all of the language strings used in SimpleDesk's administration panel which is loaded throughout the SMF admin area.
 *
 *	@package language
 *	@todo Document the text groups in this file.
 *	@since 1.0
 */

//! @name The 'Core Features' page item
//@{
$txt['core_settings_item_shd'] = 'Helpdesk';
$txt['core_settings_item_shd_desc'] = 'The helpdesk allows you to expand your forum into the service industry by providing a dedicated user-staff helpdesk area.';
//@}

//! @name Items for general SMF/ACP integration
//@{
$txt['errortype_simpledesk'] = 'SimpleDesk';
//@}

//! @name Items for the administration menu structure
//@{
// Admin menu items
$txt['shd_admin_info'] = 'Information';
$txt['shd_admin_options'] = 'Options';
$txt['shd_admin_standalone_options'] = 'Standalone Mode';
$txt['shd_admin_actionlog'] = 'Action Log';
$txt['shd_admin_support'] = 'Support';
$txt['shd_admin_helpdesklog'] = 'Helpdesk Log';

$txt['shd_admin_options_display'] = 'Display Options';
$txt['shd_admin_options_posting'] = 'Posting Options';
$txt['shd_admin_options_admin'] = 'Administrative Options';
$txt['shd_admin_options_standalone'] = 'Standalone Options';
//@}

//! @name Descriptions for the page items.
//@{
$txt['shd_admin_info_desc'] = 'This is the information center for the helpdesk, powered by SimpleDesk. Here you can get the latest news as well as version-specific support.';
$txt['shd_admin_options_desc'] = 'This is the general configuration area for the helpdesk, where some basic options can be configured.';
$txt['shd_admin_options_display_desc'] = 'In this area you can change some settings that will edit the display of your helpdesk.';
$txt['shd_admin_options_posting_desc'] = 'Here you can edit posting settings, such as BBC, smileys, and attachments.';
$txt['shd_admin_options_admin_desc'] = 'Here you can set some general administrative options for the helpdesk.';
$txt['shd_admin_options_standalone_desc'] = 'This area manages the standalone mode for the helpdesk, that effectively disables the forum part of an SMF installation.';
$txt['shd_admin_actionlog_desc'] = 'This is a list of all actions, such as resolved tickets, edited tickets and more, carried out in the helpdesk.';
$txt['shd_admin_support_desc'] = 'This area will help you get through to SimpleDesk.net quickly and effectively - the post will include some information helpful for our Support team, about your installation (like SMF version and SimpleDesk version).';
$txt['shd_admin_help'] = 'This is the administration panel for the helpdesk. Here you can manage settings, get news and updates on this modification, and view helpdesk logs.';
//@}

//! @name SimpleDesk info center
//@{
$txt['shd_live_from'] = 'Live from SimpleDesk.net';
$txt['shd_no_connect'] = 'Could not retrieve news file from simpledesk.net';
$txt['shd_current_version'] = 'Current Version';
$txt['shd_your_version'] = 'Your Version';
$txt['shd_mod_information'] = 'Mod Information';
$txt['shd_admin_readmore'] = 'Read more';
$txt['shd_admin_help_live'] = 'This box displays the latest news and updates from www.simpledesk.net. Keep your eyes open for new releases and bug fixes. If a new version of this modification is released, you will also see a notification at the top of the helpdesk administration page.';
$txt['shd_admin_help_modification'] = 'This box contains various information about your installation of SimpleDesk.';
$txt['shd_admin_help_credits'] = 'This box lists all of the people that made SimpleDesk possible, from the developers of the actual code, to the support team and the beta testers.';
$txt['shd_admin_help_update'] = 'If you can see this box, you are most likely using an outdated version of SimpleDesk. Follow the guidelines in the notification in order to upgrade to the new release.';
$txt['shd_ticket_information'] = 'Ticket information';
$txt['shd_total_tickets'] = 'Total number of tickets';
$txt['shd_open_tickets'] = 'Open tickets';
$txt['shd_closed_tickets'] = 'Closed tickets';
$txt['shd_recycled_tickets'] = 'Recycled tickets';
//@}

//! @name Translatable strings for the credits
//@{
$txt['shd_credits'] = 'SimpleDesk Credits';
$txt['shd_credits_and'] = 'and';
$txt['shd_credits_pretext'] = 'These are the persons that made SimpleDesk possible. Thank you!';
$txt['shd_credits_devs'] = 'Developers';
$txt['shd_credits_devs_desc'] = 'The developers of the actual SimpleDesk code.';
$txt['shd_credits_projectsupport'] = 'Project Support';
$txt['shd_credits_projectsupport_desc'] = 'Those managing and supporting the project in different ways.';
$txt['shd_credits_marketing'] = 'Marketing';
$txt['shd_credits_marketing_desc'] = 'Those spreading the word of SimpleDesk.';
$txt['shd_credits_globalizer'] = 'Globalization';
$txt['shd_credits_globalizer_desc'] = 'The people who makes SimpleDesk spread across the world.';
$txt['shd_credits_support'] = 'Support';
$txt['shd_credits_support_desc'] = 'The people providing all the helpless souls with the support they require.';
$txt['shd_credits_qualityassurance'] = 'Quality Assurance';
$txt['shd_credits_qualityassurance_desc'] = 'The leaders of the beta testing team.';
$txt['shd_credits_beta'] = 'Beta Testers';
$txt['shd_credits_beta_desc'] = 'These persons make sure SimpleDesk lives up to the expectations.';
$txt['shd_credits_alltherest'] = 'Anyone else we might\'ve missed...';
$txt['shd_credits_ledicons'] = 'Creator of the icons used by SimpleDesk';
$txt['shd_credits_user'] = '<strong>YOU</strong>, the proud users of SimpleDesk. Thank you for choosing our software!';
//@}

//! @name Configuration items on the Display Options page
//@{
$txt['shd_staff_badge'] = 'What style of badges to use in ticket view?';
$txt['shd_staff_badge_note'] = 'When looking at different replies, it may be helpful to display badges if you have different teams who may respond in the helpdesk. It may also be useful to display members\' own badges, or not; this option lets you select.';
$txt['shd_staff_badge_nobadge'] = 'Display no badge, just a small icon for staff';
$txt['shd_staff_badge_staffbadge'] = 'Display badges only of staff members';
$txt['shd_staff_badge_userbadge'] = 'Display badges only of non-staff/regular users';
$txt['shd_staff_badge_bothbadge'] = 'Display badges of both users and staff';
$txt['shd_display_avatar'] = 'Display avatars in replies to a ticket?';
$txt['shd_ticketnav_style'] = 'What type of navigation to use in the ticket view?';
$txt['shd_ticketnav_style_note'] = 'When looking at tickets, there may be a number of options available to users, including edit, close, and delete. This option specifies the different ways this can look.';
$txt['shd_ticketnav_style_sd'] = 'SimpleDesk style (icon with small text note)';
$txt['shd_ticketnav_style_sdcompact'] = 'SimpleDesk style (icon only)';
$txt['shd_ticketnav_style_smf'] = 'SMF style (text buttons, above the ticket)';
//@}

//! @name Configuration items on the Posting Options page
//@{
$txt['shd_allow_ticket_bbc'] = 'Allow tickets and replies to use bbcode';
$txt['shd_allow_ticket_smileys'] = 'Allow tickets and replies to use smileys';
$txt['shd_attachments_mode'] = 'How should attachments to tickets be treated?';
$txt['shd_attachments_mode_ticket'] = 'As attached to the ticket';
$txt['shd_attachments_mode_reply'] = 'As attached to individual replies';
$txt['shd_attachments_mode_note'] = 'If using "to ticket" mode, there is no limit on the number of attachments, while if using "to replies", the helpdesk will use the same settings as regular attachments, by default 4 to a post only. Both modes check the size per attachment and that it will not fill up your attachments folder based on the settings in your attachments panel.';
$txt['shd_bbc'] = 'Enabled BBC tags in the helpdesk';
$txt['shd_bbc_desc'] = '<strong>If BBC is enabled above.</strong> What tags should be enabled for use in the helpdesk?';
//@}

//! @name Configuration items on the Admin Options page
//@{
$txt['shd_disable_action_log'] = 'Disable logging of helpdesk actions?';
$txt['shd_staff_ticket_self'] = 'For tickets opened by staff, should it be possible to assign them the ticket?';
$txt['shd_admins_not_assignable'] = 'Should admins be excluded from having tickets assigned to them?';
$txt['shd_privacy_display'] = 'What method to use for displaying ticket privacy?';
$txt['shd_privacy_display_smart'] = 'Display a ticket\'s privacy setting when appropriate';
$txt['shd_privacy_display_always'] = 'Always display the ticket\'s privacy setting';
$txt['shd_privacy_display_note'] = 'Normally tickets are limited to user seeing their own and staff seeing all users. There are times you might want staff to be able to create tickets only for senior staff to see - this is a "private" ticket. Since "non-private" might be confusing for regular users, this option allows you to hide the display of "non private" or "private" to only when it is appropriate on a ticket.';
//@}

//! @name Configuration items on the Standalone Options page
//@{
$txt['shd_helpdesk_only'] = 'Enable helpdesk only mode';
$txt['shd_helpdesk_only_note'] = 'This will disable access to topics and boards, as well as optionally the features below. Note that none of the data is lost, merely rendered inactive. The following options ONLY apply when this mode is active (when the forum is basically disabled outside the helpdesk)';
$txt['shd_disable_pm'] = 'Disable private messages entirely';
$txt['shd_disable_mlist'] = 'Disable the memberlist entirely';
//@}

//! @name General language strings for the action log (entries are contained in SimpleDesk-LogAction.english.php)
//@{
$txt['shd_delete_item'] = 'Delete this log item';
$txt['shd_admin_actionlog_title'] = 'Helpdesk action log';
$txt['shd_admin_actionlog_action'] = 'Action';
$txt['shd_admin_actionlog_date'] = 'Date';
$txt['shd_admin_actionlog_member'] = 'Member';
$txt['shd_admin_actionlog_position'] = 'Position';
$txt['shd_admin_actionlog_ip'] = 'IP';
$txt['shd_admin_actionlog_none'] = 'No entries were found.';
$txt['shd_admin_actionlog_unknown'] = 'Unknown';
$txt['shd_admin_actionlog_removeall'] = 'Empty out the entire log';
$txt['shd_admin_actionlog_removeall_confirm'] = 'This will permanently delete all entries in the action log older than %s hours. Are you sure?';
//@}

//! @name Strings for the post-to-SimpleDesk.net support page
//@{
$txt['shd_admin_support_form_title'] = 'Support form';
$txt['shd_admin_support_what_is_this'] = 'What is this?';
$txt['shd_admin_support_explanation'] = 'This simple form will allow you to send a support request directly to the SimpleDesk website so that the support team there can help you solve any issue you run in to.<br /><br />Please note that you will need an account on our website in order to post as well as replying to your topic in the future. This form will simply speed up the posting process.';
$txt['shd_admin_support_send'] = 'Send support request';
//@}

//! @name The browse-attachments integration strings
//@{
$txt['attachment_manager_shd_attach'] = 'Helpdesk attachments';
$txt['attachment_manager_shd_thumb'] = 'Helpdesk thumbnails';
$txt['attachment_manager_shd_attach_no_entries'] = 'There are currently no helpdesk attachments.';
$txt['attachment_manager_shd_thumb_no_entries'] = 'There are currently no helpdesk thumbnails.';
//@}

/**
 *	@ignore
 *	Warning: He may bite.
*/
$txt['shd_fluffy'] = 'Guardian of the <span %s>cookies</span>';

?>