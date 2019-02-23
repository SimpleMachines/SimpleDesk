<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2019 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1 Beta 1                              *
* File Info: SimpleDeskAdmin.english.php                      *
**************************************************************/
// Version: 2.1; SimpleDesk administration options

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
$txt['errortype_simpledesk_desc'] = 'Errors most likely related to SimpleDesk. Please report any such errors on www.simpledesk.net.';
$txt['errortype_sdplugin'] = 'SimpleDesk Plugin';
$txt['errortype_sdplugin_desc'] = 'Errors most likely related to a SimpleDesk plugin. The file name should generally indicate the plugin, so you can check to see who the author is.';
$txt['scheduled_task_simpledesk'] = 'SimpleDesk daily maintenance';
$txt['scheduled_task_desc_simpledesk'] = 'Maintenance tasks and internal processing to be run daily for SimpleDesk. It is strongly not advised to disable this task.';

$txt['lang_file_desc_SimpleDesk'] = 'Main helpdesk';
$txt['lang_file_desc_SimpleDeskAdmin'] = 'Helpdesk Administration';
$txt['lang_file_desc_SimpleDeskLogAction'] = 'Action Log Entries';
$txt['lang_file_desc_SimpleDeskNotifications'] = 'Email Notifications';
$txt['lang_file_desc_SimpleDeskPermissions'] = 'Permissions';
$txt['lang_file_desc_SimpleDeskProfile'] = 'Profile Area';
$txt['lang_file_desc_SimpleDeskWho'] = 'Who\'s Online';
//@}

//! @name Items for the administration menu structure
//@{
// Admin menu items, the ones that aren't in SimpleDesk.english.php anyway...
$txt['shd_admin_standalone_options'] = 'Standalone Mode';
$txt['shd_admin_actionlog'] = 'Action Log';
$txt['shd_admin_adminlog'] = 'Admin Log';
$txt['shd_admin_support'] = 'Support';
$txt['shd_admin_helpdesklog'] = 'Helpdesk Log';

$txt['shd_admin_options_display'] = 'Display Options';
$txt['shd_admin_options_posting'] = 'Posting Options';
$txt['shd_admin_options_admin'] = 'Administrative Options';
$txt['shd_admin_options_standalone'] = 'Standalone Options';
$txt['shd_admin_options_actionlog'] = 'Action Log Options';
$txt['shd_admin_options_notifications'] = 'Notifications Options';
//@}

//! @name Descriptions for the page items.
//@{
$txt['shd_admin_info_desc'] = 'This is the information center for the helpdesk, powered by SimpleDesk. Here you can get the latest news as well as version-specific support.';
$txt['shd_admin_options_desc'] = 'This is the general configuration area for the helpdesk, where some basic options can be configured.';
$txt['shd_admin_options_display_desc'] = 'In this area you can change some settings that will edit the display of your helpdesk.';
$txt['shd_admin_options_posting_desc'] = 'Here you can edit posting settings, such as BBC, smileys, and attachments.';
$txt['shd_admin_options_admin_desc'] = 'Here you can set some general administrative options for the helpdesk.';
$txt['shd_admin_options_standalone_desc'] = 'This area manages the standalone mode for the helpdesk, that effectively disables the forum part of an SMF installation.';
$txt['shd_admin_options_actionlog_desc'] = 'This area allows you to configure what items can be logged within the helpdesk action log.';
$txt['shd_admin_options_notifications_desc'] = 'This area allows you to configure email notifications being sent to users when their tickets change.';
$txt['shd_admin_actionlog_desc'] = 'This is a list of all actions, such as resolved tickets, edited tickets and more, carried out in the helpdesk.';
$txt['shd_admin_adminlog_desc'] = 'This is a list of all admin actions, such as changed options, canned replies, department changes.';
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
$txt['shd_need_support'] = 'Help with SimpleDesk?';
$txt['shd_support_start_here'] = 'See our <a href="%1$s">Support Page</a>';

$txt['shd_helpdesk_nojs'] = 'JavaScript is not enabled in your browser. Some functions may not work properly (or at all) in the administration area.';
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
$txt['shd_credits_globalizer_desc'] = 'The people who make SimpleDesk spread across the world.';
$txt['shd_credits_support'] = 'Support';
$txt['shd_credits_support_desc'] = 'The people providing all the helpless souls with the support they require.';
$txt['shd_credits_qualityassurance'] = 'Quality Assurance';
$txt['shd_credits_qualityassurance_desc'] = 'The leaders of the beta testing team.';
$txt['shd_credits_beta'] = 'Beta Testers';
$txt['shd_credits_beta_desc'] = 'These persons make sure SimpleDesk lives up to the expectations.';
$txt['shd_credits_alltherest'] = 'Anyone else we might\'ve missed...';
$txt['shd_credits_icons'] = '<a href="%1$s">Fugue</a>, <a href="%2$s">Function</a>, <a href="%3$s">FamFamFam Flags</a>, <a href="%4$s">Everaldo\'s "Crystal"</a> icon sets - the pretty icons used by SimpleDesk';
$txt['shd_credits_user'] = '<strong>YOU</strong>, the proud users of SimpleDesk. Thank you for choosing our software!';
$txt['shd_credits_translators'] = 'Our translators - Thanks to you, people all around the world can use SimpleDesk';
$txt['shd_former_contributors'] = 'Former contributors are highlighted with a <span class="shd_former_contributor">brighter color</span>.';
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
$txt['shd_theme'] = 'Use a specific theme in the forum?';
$txt['shd_theme_note'] = 'Normally the helpdesk will inherit the theme a user has picked, or failing that the forum default. This option allows you to pick a theme that will always be used in the helpdesk regardless of other settings.';
$txt['shd_theme_use_default'] = 'Use the forum default theme';
$txt['shd_hidemenuitem'] = 'Hide the Helpdesk menu item?';
$txt['shd_hidemenuitem_note'] = 'This is most useful if helpdesk departments are presented on the board index.';
$txt['shd_disable_unread'] = 'Disable integration with Unread Posts/Unread Replies';
$txt['shd_disable_unread_note'] = 'Normally, SimpleDesk adds a list of topics to the unread posts/unread replies page but sometimes (e.g. certain mobile themes) this does not always work so well.';
$txt['shd_zerofill'] = 'Smallest number of digits to use';
$txt['shd_zerofill_note'] = 'Ticket numbers are normally expressed like 00001, this would be 5 digits, and ticket 100000 would have no extra digits. You can use 0 to not have any leading zeroes if you like.';
$txt['shd_block_order_1'] = 'Tickets Block: 1st position';
$txt['shd_block_order_2'] = 'Tickets Block: 2nd position';
$txt['shd_block_order_3'] = 'Tickets Block: 3rd position';
$txt['shd_block_order_4'] = 'Tickets Block: 4th position';
$txt['shd_block_order_5'] = 'Tickets Block: 5th position';
$txt['shd_block_order_note'] = 'Specify the default order of blocks';
//@}

//! @name Configuration items on the Posting Options page
//@{
$txt['shd_thank_you_post'] = 'Display a message to users on posting a ticket';
$txt['shd_thank_you_nonstaff'] = 'Display the message only to non-staff members';
$txt['shd_allow_wikilinks'] = 'Allow use of [[ticket:123]] wiki-style links';
$txt['shd_allow_ticket_bbc'] = 'Allow tickets and replies to use bbcode';
$txt['shd_allow_ticket_smileys'] = 'Allow tickets and replies to use smileys';
$txt['shd_attachments_mode'] = 'How should attachments to tickets be treated?';
$txt['shd_attachments_mode_ticket'] = 'As attached to the ticket';
$txt['shd_attachments_mode_reply'] = 'As attached to individual replies';
$txt['shd_attachments_mode_note'] = 'If using "to ticket" mode, there is no limit on the number of attachments, while if using "to replies", the helpdesk will use the same settings as regular attachments, by default 4 to a post only. Both modes check the size per attachment and that it will not fill up your attachments folder based on the settings in your attachments panel.';
$txt['shd_bbc'] = 'Enabled BBC tags in the helpdesk';
$txt['shd_bbc_desc'] = 'What tags should be enabled for use in the helpdesk?';
//@}

//! @name Configuration items on the Admin Options page
//@{
$txt['shd_maintenance_mode'] = 'Put the helpdesk into maintenance mode';
$txt['shd_staff_ticket_self'] = 'For tickets opened by staff, should it be possible to assign them the ticket?';
$txt['shd_admins_not_assignable'] = 'Should admins be considered separate from staff?';
$txt['shd_admins_not_assignable_note'] = 'If selected, forums admins will not be able to be assigned tickets and will be excluded from being added sending one-off emails to them to notify of a new reply.';
$txt['shd_privacy_display'] = 'What method to use for displaying ticket privacy?';
$txt['shd_privacy_display_smart'] = 'Display a ticket\'s privacy setting when appropriate';
$txt['shd_privacy_display_always'] = 'Always display the ticket\'s privacy setting';
$txt['shd_privacy_display_note'] = 'Normally tickets are limited to user seeing their own and staff seeing all users. There are times you might want staff to be able to create tickets only for senior staff to see - this is a "private" ticket. Since "non-private" might be confusing for regular users, this option allows you to hide the display of "non private" or "private" to only when it is appropriate on a ticket.';
$txt['shd_disable_tickettotopic'] = 'Disable "ticket to topic" options';
$txt['shd_disable_tickettotopic_note'] = 'Normally, it is possible to move tickets to topics and back again (except in Standalone mode), this option denies it for all users regardless of any permissions for it.';
$txt['shd_disable_relationships'] = 'Disable relationships';
$txt['shd_disable_relationships_note'] = 'Disable tickets from having "relationships" with each other, regardless of any permissions for it.';
$txt['shd_disable_boardint'] = 'Disable BoardIndex Integration';
$txt['shd_disable_boardint_note'] = 'Disable helpdesk from loading on the boardIndex completely.';
//@}

//! @name Configuration items on the Standalone Options page
//@{
$txt['shd_helpdesk_only'] = 'Enable helpdesk only mode';
$txt['shd_helpdesk_only_note'] = 'This will disable access to topics and boards, as well as optionally the features below. Note that none of the data is lost, merely rendered inactive. The following options ONLY apply when this mode is active (when the forum is basically disabled outside the helpdesk)';
$txt['shd_disable_pm'] = 'Disable private messages entirely';
$txt['shd_disable_mlist'] = 'Disable the memberlist entirely';
//@}

//! @name Configuration items on the Action Log Options page
//@{
$txt['shd_disable_action_log'] = 'Disable logging of helpdesk actions?';
$txt['shd_display_ticket_logs'] = 'Display a mini action log in each ticket?';
$txt['shd_logopt_newposts'] = 'Log new tickets and their replies';
$txt['shd_logopt_editposts'] = 'Log edits to tickets and posts';
$txt['shd_logopt_resolve'] = 'Log tickets being resolved/unresolved';
$txt['shd_logopt_assign'] = 'Log tickets being assigned/reassigned/unassigned';
$txt['shd_logopt_privacy'] = 'Log ticket privacy being changed';
$txt['shd_logopt_urgency'] = 'Log ticket urgency being changed';
$txt['shd_logopt_tickettopicmove'] = 'Log tickets being moved to topics and back';
$txt['shd_logopt_cfchanges'] = 'Log changes to custom fields on tickets and replies';
$txt['shd_logopt_delete'] = 'Log tickets and replies being deleted';
$txt['shd_logopt_restore'] = 'Log tickets and replies being restored';
$txt['shd_logopt_permadelete'] = 'Log tickets and replies being permadeleted';
$txt['shd_logopt_relationships'] = 'Log any changes in ticket relationships';
$txt['shd_logopt_autoclose'] = 'Log tickets closed automatically by the helpdesk';
$txt['shd_logopt_move_dept'] = 'Log tickets being moved between two departments';
$txt['shd_logopt_monitor'] = 'Log tickets being added to their monitor/ignore lists';

$txt['shd_notify_send_to'] = 'Will be sent to';
$txt['shd_notify_ticket_starter'] = 'the user who started the ticket (if set in their preferences)';
$txt['shd_notify_nobody'] = 'nobody';
//@}

//! @name Configuration items on the Notifications Options page
//@{
$txt['shd_notify_email'] = 'Email address to use in the notifications, leave blank to use the forum default (%1$s)';
$txt['shd_notify_log'] = 'Log notifications being sent (what notification, when sent, user(s) involved)';
$txt['shd_notify_with_body'] = 'When sending notifications, send the new ticket or new reply content in the email';
$txt['shd_notify_new_ticket'] = 'Allow staff to receive notifications on new tickets';
$txt['shd_notify_new_reply_own'] = 'Allow users to receive notifications when their tickets are replied to';
$txt['shd_notify_new_reply_assigned'] = 'Allow staff to receive notifications when tickets assigned to them are replied to';
$txt['shd_notify_new_reply_previous'] = 'Allow staff to receive notifications when tickets they have replied to, are replied to again';
$txt['shd_notify_new_reply_any'] = 'Allow staff to receive notifications when any tickets are replied to';
$txt['shd_notify_assign_me'] = 'Allow staff to receive notifications when a ticket is assigned to them';
$txt['shd_notify_assign_own'] = 'Allow users to receive notifications when their tickets are assigned to staff';
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
$txt['shd_admin_actionlog_hidden'] = 'Hidden';
$txt['shd_admin_actionlog_removeall'] = 'Empty out the entire log';
$txt['shd_admin_actionlog_removeall_confirm'] = 'This will permanently delete all entries in the action log older than %s hours. Are you sure?';
//@}

//! @name General language strings for the admin log
//@{
$txt['shd_admin_adminlog_title'] = 'Helpdesk Admin log';
$txt['shd_admin_adminlog_action'] = 'Action';
$txt['shd_admin_adminlog_name'] = 'Name';
$txt['shd_admin_adminlog_to'] = 'To';
$txt['shd_admin_adminlog_from'] = 'From';
$txt['shd_admin_adminlog_setting'] = 'Setting';
$txt['shd_log_admin_canned'] = 'Canned Replies';
$txt['shd_log_admin_customfield'] = 'Custom Fields';
$txt['shd_log_admin_maint'] = 'Maintenance';
$txt['shd_log_admin_permissions'] = 'Permissions';
$txt['shd_log_admin_plugins'] = 'Plugins';
$txt['shd_log_admin_dept'] = 'Departments';
$txt['shd_log_admin_change_option'] = 'Options';
$txt['shd_log_admin_canned_cat_move'] = 'Sorted Category';
$txt['shd_log_admin_canned_cat_delete'] = 'Deleted Category';
$txt['shd_log_admin_canned_cat_add'] = 'Added Category';
$txt['shd_log_admin_canned_cat_update'] = 'Updated Category';
$txt['shd_log_admin_canned_reply_move'] = 'Sorted Reply';
$txt['shd_log_admin_canned_reply_delete'] = 'Deleted Reply';
$txt['shd_log_admin_canned_reply_add'] = 'Added Canned Reply';
$txt['shd_log_admin_canned_reply_update'] = 'Updated Reply';
$txt['shd_log_admin_dept_move'] = 'Sorted';
$txt['shd_log_admin_dept_delete'] = 'Deleted';
$txt['shd_log_admin_dept_add'] = 'Added';
$txt['shd_log_admin_dept_update'] = 'Update';
$txt['shd_log_admin_customfield_move'] = 'Sorted';
$txt['shd_log_admin_customfield_delete'] = 'Deleted';
$txt['shd_log_admin_customfield_add'] = 'Added';
$txt['shd_log_admin_customfield_update'] = 'Updated';
$txt['shd_log_admin_customfield_move'] = 'Sorted';
$txt['shd_log_admin_maint_reattribute'] = 'Reattributed Tickets';
$txt['shd_log_admin_maint_move_dept'] = 'Moved Tickets to Department';
$txt['shd_log_admin_maint_findrepair'] = 'Ran Find and Repair';
$txt['shd_log_admin_maint_clean_cache'] = 'Ran Clean Cache';
$txt['shd_log_admin_maint_search_rebuild'] = 'Rebuilt Search';
$txt['shd_log_admin_permissions_create_role'] = 'Added';
$txt['shd_log_admin_permissions_delete_role'] = 'Deleted';
$txt['shd_log_admin_permissions_change_role'] = 'Updated';
$txt['shd_log_admin_permissions_copy_role'] = 'Duplicated';
$txt['shd_log_admin_plugins_update'] = 'Updated';
$txt['shd_log_admin_plugins_remove'] = 'Removed';
//@}

//! @name Strings for the post-to-SimpleDesk.net support page
//@{
$txt['shd_admin_support_form_title'] = 'Support form';
$txt['shd_admin_support_what_is_this'] = 'What is this?';
$txt['shd_admin_support_explanation'] = 'This simple form will allow you to send a support request directly to the SimpleDesk website so that the support team there can help you solve any issue you run in to.<br><br>Please note that you will need an account on our website in order to post as well as replying to your topic in the future. This form will simply speed up the posting process.';
$txt['shd_admin_support_send'] = 'Send support request';
//@}

//! @name The browse-attachments integration strings
//@{
$txt['attachment_manager_shd_attach'] = 'Helpdesk attachments';
$txt['attachment_manager_shd_thumb'] = 'Helpdesk thumbnails';
$txt['attachment_manager_shd_attach_no_entries'] = 'There are currently no helpdesk attachments.';
$txt['attachment_manager_shd_thumb_no_entries'] = 'There are currently no helpdesk thumbnails.';
//@}

//! @name Custom fields stuff
//@{
$txt['shd_admin_custom_fields_long'] = 'Custom Fields for Tickets and Replies';
$txt['shd_admin_custom_fields_desc'] = 'This section allows you to create extra fields that can be added to tickets and/or their replies, to gather additional information about the ticket or to help you manage your helpdesk.';
$txt['shd_admin_custom_fields_general'] = 'General Details';

$txt['shd_admin_custom_fields_fieldname'] = 'Field Name';
$txt['shd_admin_custom_fields_fieldname_desc'] = 'The name displayed next to where the user will enter the information (required)';
$txt['shd_admin_custom_fields_description'] = 'Field Description';
$txt['shd_admin_custom_fields_description_desc'] = 'A description of the field, shown to the user when they enter the information.';
$txt['shd_admin_custom_fields_icon'] = 'Field Icon';
$txt['shd_admin_custom_fields_icon_desc'] = 'An optional icon displayed next to the field name. To add your own icon(s), simply place an image file in the ./Themes/default/images/simpledesk/cf/ folder. For best results, this should be a 13x13px png image.';
$txt['shd_admin_custom_fields_fieldtype'] = 'Field Type';
$txt['shd_admin_custom_fields_fieldtype_desc'] = 'The type of field the user will complete with requested information.';
$txt['shd_admin_custom_fields_active'] = 'Active';
$txt['shd_admin_custom_fields_inactive'] = 'Not active';
$txt['shd_admin_custom_fields_active_desc'] = 'This is a master toggle for this field; if it is not active, it will not be displayed or requested from the user when posting.';
$txt['shd_admin_custom_fields_fielddesc'] = 'Field Description';
$txt['shd_admin_custom_fields_fielddesc_desc'] = 'A short description of the field you are adding.';
$txt['shd_admin_custom_fields_visible'] = 'Visible';
$txt['shd_admin_custom_fields_visible_ticket'] = 'Visible/editable for a ticket';
$txt['shd_admin_custom_fields_visible_field'] = 'Visible/editable in replies';
$txt['shd_admin_custom_fields_visible_both'] = 'Visible/editable in both tickets and replies';
$txt['shd_admin_custom_fields_visible_desc'] = 'This controls whether a given field applies to just tickets as a whole, to replies individually or both a ticket and its replies.';
$txt['shd_admin_custom_fields_none'] = '(none)';
$txt['shd_admin_no_custom_fields'] = 'There are no custom fields currently set up.';
$txt['shd_admin_custom_fields_inticket'] = 'Visible on a ticket';
$txt['shd_admin_custom_fields_inreply'] = 'Visible on a reply';
$txt['shd_admin_custom_fields_move'] = 'Move';
$txt['shd_admin_move_up'] = 'Move up';
$txt['shd_admin_move_down'] = 'Move down';
$txt['shd_admin_custom_fields_ui_text'] = 'Textbox';
$txt['shd_admin_custom_fields_ui_largetext'] = 'Large textbox';
$txt['shd_admin_custom_fields_ui_int'] = 'Integer (whole numbers)';
$txt['shd_admin_custom_fields_ui_float'] = 'Floating (fractional) numbers';
$txt['shd_admin_custom_fields_ui_select'] = 'Select from a dropdown';
$txt['shd_admin_custom_fields_ui_checkbox'] = 'Tickbox (yes/no)';
$txt['shd_admin_custom_fields_ui_radio'] = 'Select from radio buttons';
$txt['shd_admin_custom_fields_ui_multi'] = 'Select multiple items';
$txt['shd_admin_cannot_edit_custom_field'] = 'You cannot edit that custom field.';
$txt['shd_admin_cannot_move_custom_field'] = 'You cannot move that custom field.';
$txt['shd_admin_cannot_move_custom_field_up'] = 'You cannot move that custom field up; it is the first item already.';
$txt['shd_admin_cannot_move_custom_field_down'] = 'You cannot move that custom field down; it is the last item already.';
$txt['shd_admin_new_custom_field'] = 'Add New Field';
$txt['shd_admin_new_custom_field_desc'] = 'From this panel you can add a new custom field for your tickets and/or their replies, and specify how these should function for you.';
$txt['shd_admin_edit_custom_field'] = 'Edit Existing Field';
$txt['shd_admin_edit_custom_field_desc'] = 'From this panel you can edit an existing custom field, as set out below.';
$txt['shd_admin_no_fieldname'] = 'You did not specify any name for your custom field.';
$txt['shd_admin_could_not_create_field'] = 'Failed to create the custom field. Please try again.';
$txt['shd_admin_default_state_on'] = 'Checked';
$txt['shd_admin_default_state_off'] = 'Not checked';
$txt['shd_admin_save_custom_field'] = 'Save field';
$txt['shd_admin_delete_custom_field'] = 'Delete field';
$txt['shd_admin_cancel_custom_field'] = 'Cancel';
$txt['shd_admin_delete_custom_field_confirm'] = 'Do you really want to delete this custom field? All values stored for this field will be removed, and there is NO undo function.';
$txt['shd_admin_custom_field_options'] = 'Options';
$txt['shd_admin_custom_field_options_desc'] = 'Leave option box blank to remove.';
$txt['shd_admin_custom_field_options_radio'] = 'Radio button selects default option.';
$txt['shd_admin_custom_field_options_multi'] = 'The checkboxes indicate which items are selected by default.';
$txt['shd_admin_custom_field_no_selected_default'] = 'No selected default';
$txt['shd_admin_custom_field_bbc'] = 'Allow BBC';
$txt['shd_admin_custom_field_bbc_note'] = 'BBC is not processed for fields used as ticket prefixes.';
$txt['shd_admin_custom_field_bbc_off'] = 'BBC is currently <a href="%s">disabled</a> throughout the helpdesk.';
$txt['shd_admin_custom_field_default_state'] = 'Default state';
$txt['shd_admin_custom_field_dimensions'] = 'Dimensions';
$txt['shd_admin_custom_field_dimensions_rows'] = 'Rows';
$txt['shd_admin_custom_field_dimensions_columns'] = 'Columns';
$txt['shd_admin_custom_field_maxlength'] = 'Maximum length';
$txt['shd_admin_custom_field_maxlength_desc'] = '(0 for no limit)';
$txt['shd_admin_custom_field_display_empty'] = 'Display even if empty';
$txt['shd_admin_custom_field_display_empty_desc'] = 'If the field is left empty by the user, should it still be displayed when reading the ticket?';
$txt['shd_admin_custom_field_required'] = 'Required field';
$txt['shd_admin_custom_field_required_desc'] = 'If checked, this field must be filled in by the user in order to post the ticket or reply.';
$txt['shd_admin_custom_field_view'] = 'View';
$txt['shd_admin_custom_field_edit'] = 'Edit';
$txt['shd_admin_custom_field_permissions'] = 'Permissions';
$txt['shd_admin_custom_field_can_see'] = 'Who can see this field';
$txt['shd_admin_custom_field_can_see_desc'] = 'Select who can see this field in tickets.';
$txt['shd_admin_custom_field_can_edit'] = 'Who can edit this field';
$txt['shd_admin_custom_field_can_edit_desc'] = 'Select who can edit/use this field when posting.';
$txt['shd_admin_custom_field_users'] = 'Users';
$txt['shd_admin_custom_field_staff'] = 'Staff';
$txt['shd_admin_custom_field_admins'] = 'Admins';
$txt['shd_admin_custom_field_placement'] = 'Placement inside ticket';
$txt['shd_admin_custom_field_placement_desc'] = 'Where in the ticket should this field be displayed? Please note that large fields may not fit very well in to the "additional details" box, and that only select dropdowns and radio buttons are available for use as categories.';
$txt['shd_admin_custom_field_placement_details'] = 'Additional details (Left side box)';
$txt['shd_admin_custom_field_placement_information'] = 'Additional information (Below ticket body)';
$txt['shd_admin_custom_field_placement_prefix'] = 'As a prefix to the ticket\'s title';
$txt['shd_admin_custom_field_placement_prefixfilter'] = 'As a Category (filterable)';
$txt['shd_admin_custom_field_department'] = 'Departments this field applies to';
$txt['shd_admin_custom_field_dept_applies'] = 'Applies';
$txt['shd_admin_custom_field_dept_required'] = 'Required';
$txt['shd_admin_custom_field_invalid'] = 'Invalid type of field selected.';
$txt['shd_admin_custom_field_reselect_invalid'] = 'You have tried to change this custom field, but to a type that is incompatible with the data already stored for this field, and to avoid damaging existing data, the change has been prevented.';
//@}

//! Canned Replies
//@{
$txt['shd_admin_cannedreplies_home'] = 'Helpdesk - Canned Replies';
$txt['shd_admin_cannedreplies_homedesc'] = 'This section allows you to create template answers, or snippets, or the answers to frequently asked questions, so that they are available from the posting interface.';
$txt['shd_admin_cannedreplies_nocats'] = 'There are no categories for canned replies, you will need to create one first.';
$txt['shd_admin_cannedreplies_createcat'] = 'Create New Category';
$txt['shd_admin_cannedreplies_editcat'] = 'Edit This Category';
$txt['shd_admin_cannedreplies_deletecat'] = 'Delete This Category';
$txt['shd_admin_cannedreplies_categoryname'] = 'Category Name';
$txt['shd_admin_cannedreplies_replyname'] = 'Reply Name';
$txt['shd_admin_cannedreplies_isactive'] = 'Active?';
$txt['shd_admin_cannedreplies_visibleto'] = 'Visible To';
$txt['shd_admin_cannedreplies_emptycat'] = 'There are no canned replies in this category.';
$txt['shd_admin_cannedreplies_addreply'] = 'Create New Reply';
$txt['shd_admin_cannedreplies_editreply'] = 'Edit This Reply';
$txt['shd_admin_cannedreplies_deletereply'] = 'Delete This Reply';
$txt['shd_admin_cannedreplies_delete_confirm'] = 'Are you sure you want to delete this category and all the replies in it?';
$txt['shd_admin_cannedreplies_deletereply_confirm'] = 'Are you sure you want to delete this reply?';
$txt['shd_admin_cannedreplies_move_between_cat'] = 'Move this canned reply to another category';
$txt['shd_admin_cannedreplies_cannot_move_reply'] = 'This reply cannot be moved.';
$txt['shd_admin_cannedreplies_cannot_move_reply_up'] = 'This reply cannot be moved up.';
$txt['shd_admin_cannedreplies_cannot_move_reply_down'] = 'This reply cannot be moved down.';
$txt['shd_admin_cannedreplies_cannot_move_cat'] = 'This category cannot be moved.';
$txt['shd_admin_cannedreplies_cannot_move_cat_up'] = 'This category cannot be moved up.';
$txt['shd_admin_cannedreplies_cannot_move_cat_down'] = 'This category cannot be moved down.';
$txt['shd_admin_cannedreplies_thecatisalie'] = 'This category does not exist, it cannot be edited.';
$txt['shd_admin_cannedreplies_thereplyisalie'] = 'This reply does not exist, it cannot be edited.';
$txt['shd_admin_cannedreplies_nocatname'] = 'No name was given for the category, one must be provided.';
$txt['shd_admin_cannedreplies_replytitle'] = 'Title of this canned reply';
$txt['shd_admin_cannedreplies_content'] = 'Content of the canned reply';
$txt['shd_admin_cannedreplies_active'] = 'Is this canned reply active?';
$txt['shd_admin_cannedreplies_selectvisible'] = 'Who is this canned reply available to?';
$txt['shd_admin_cannedreplies_departments'] = 'Departments this canned reply is accessible from';
$txt['shd_admin_cannedreplies_notitle'] = 'No title was given for this canned reply, one must be provided.';
$txt['shd_admin_cannedreplies_nobody'] = 'No body content was given for this canned reply, one must be provided.';
$txt['shd_admin_cannedreplies_notcreated'] = 'The new reply could not be created.';
$txt['shd_admin_cannedreplies_onlyonecat'] = 'You cannot move this reply to another category, there is only one category of replies.';
$txt['shd_admin_cannedreplies_newcategory'] = 'The new category this reply should belong to';
$txt['shd_admin_cannedreplies_selectcat'] = '-- Select a category --';
$txt['shd_admin_cannedreplies_movereply'] = 'Move This Reply';
$txt['shd_admin_cannedreplies_destnoexist'] = 'The category you are trying to move this reply to does not exist.';

//! Departments
//@{
$txt['shd_admin_departments_home'] = 'Helpdesk Departments';
$txt['shd_admin_departments_homedesc'] = 'Within the helpdesk environment, one or more different areas - "departments" - are created for organizing tickets and access.';
$txt['shd_department_name'] = 'Department Name';
$txt['shd_dept_boardindex'] = 'Display on Board Index?';
$txt['shd_dept_no_boardindex'] = 'Do not display on board index';
$txt['shd_dept_inside_category'] = 'On board index, inside category';
$txt['shd_dept_cat_before_boards'] = 'Before all the boards in this category';
$txt['shd_dept_cat_after_boards'] = 'After all the boards in this category';
$txt['shd_roles_in_dept'] = 'Roles in this Dept.';
$txt['shd_create_dept'] = 'Create New Department';
$txt['shd_edit_dept'] = 'Edit Department';
$txt['shd_delete_dept'] = 'Delete Department';
$txt['shd_delete_dept_confirm'] = 'Do you really want to delete this department?';
$txt['shd_no_roles_in_dept'] = 'There are no roles in this department.';
$txt['shd_new_dept_name'] = 'New Department Name';
$txt['shd_dept_boardindex_cat'] = 'Display this department in the board index in category';
$txt['shd_no_dept_name'] = 'No department name was specified.';
$txt['shd_no_category'] = 'The specified category does not exist. Please go back and reload the page.';
$txt['shd_could_not_create_dept'] = 'The department could not be created.';
$txt['shd_must_have_dept'] = 'You cannot delete the only department; one must always exist.';
$txt['shd_dept_not_empty'] = 'You cannot delete this category, it contains at least one ticket.';
$txt['shd_roles_in_dept'] = 'Roles Within This Department';
$txt['shd_roles_in_dept_desc'] = 'Elsewhere in the admin panel, roles are created and given abilities. This panel controls which roles are applicable to this department, for example you may wish to create multiple departments with a single shared staff role.';
$txt['shd_no_defined_roles'] = 'There are no roles defined, please configure them from the Permissions area.';
$txt['shd_assign_dept'] = 'Assign Role/Department';
$txt['shd_boardindex_cat_none'] = 'No category (do not show)';
$txt['shd_boardindex_cat_where'] = 'Where in the category should it show?';
$txt['shd_boardindex_cat_before'] = 'Before any boards';
$txt['shd_boardindex_cat_after'] = 'After any boards';
$txt['shd_dept_description'] = 'Description';
$txt['shd_admin_cannot_move_dept'] = 'You cannot move that department.';
$txt['shd_admin_cannot_move_dept_up'] = 'You cannot move that department up; it is the first item already.';
$txt['shd_admin_cannot_move_dept_down'] = 'You cannot move that department down; it is the last item already.';
$txt['shd_dept_theme'] = 'Use a specific theme in this department?';
$txt['shd_dept_theme_note'] = 'You can set a theme for the helpdesk that differs to the main forum theme. This setting lets you override either the helpdesk or forum theme just within this department, for perhaps department specific branding.';
$txt['shd_dept_theme_use_default'] = 'Use the helpdesk/forum default theme';
$txt['shd_dept_autoclose_days'] = 'Number of days after which to automatically close a ticket?';
$txt['shd_dept_autoclose_days_note'] = 'Use 0 to indicate that tickets in this department should never be automatically marked closed, no matter how old they are.';
//@}

//! Plugins
//@{
$txt['sdplugin_package'] = 'SimpleDesk Plugins';
$txt['shd_install_plugin'] = 'Install Plugin';
$txt['shd_admin_plugins_homedesc'] = 'This area allows you to manage any additional components for SimpleDesk. They are installed through the Package Manager as regular mods, and configured from here.';
$txt['shd_admin_plugins_none'] = 'No plugins are currently installed.';
$txt['shd_admin_plugins_writtenby'] = 'Written by';
$txt['shd_admin_plugins_website'] = 'Website';
$txt['shd_admin_plugins_wrong_version'] = 'Not supported by this version!';
$txt['shd_admin_plugins_versions_avail'] = 'Supported by the plugin';
$txt['shd_admin_plugins_on'] = 'On';
$txt['shd_admin_plugins_off'] = 'Off';
 $txt['shd_admin_plugins_enabled'] = 'Enabled';
$txt['shd_admin_plugins_disabled'] = 'Disabled';
$txt['shd_admin_plugins_languages'] = 'Available languages';
$txt['shd_admin_plugins_lang_albanian'] = 'Albanian';
$txt['shd_admin_plugins_lang_arabic'] = 'Arabic';
$txt['shd_admin_plugins_lang_bangla'] = 'Bangla';
$txt['shd_admin_plugins_lang_bulgarian'] = 'Bulgarian';
$txt['shd_admin_plugins_lang_catalan'] = 'Catalan';
$txt['shd_admin_plugins_lang_chinese_simplified'] = 'Chinese (simplified)';
$txt['shd_admin_plugins_lang_chinese_traditional'] = 'Chinese (traditional)';
$txt['shd_admin_plugins_lang_croatian'] = 'Croatian';
$txt['shd_admin_plugins_lang_czech'] = 'Czech';
$txt['shd_admin_plugins_lang_danish'] = 'Danish';
$txt['shd_admin_plugins_lang_dutch'] = 'Dutch';
$txt['shd_admin_plugins_lang_english'] = 'English (US)';
$txt['shd_admin_plugins_lang_english_british'] = 'English (UK)';
$txt['shd_admin_plugins_lang_finnish'] = 'Finnish';
$txt['shd_admin_plugins_lang_french'] = 'French';
$txt['shd_admin_plugins_lang_galician'] = 'Galician';
$txt['shd_admin_plugins_lang_german'] = 'German';
$txt['shd_admin_plugins_lang_hebrew'] = 'Hebrew';
$txt['shd_admin_plugins_lang_hindi'] = 'Hindi';
$txt['shd_admin_plugins_lang_hungarian'] = 'Hungarian';
$txt['shd_admin_plugins_lang_indonesian'] = 'Indonesian';
$txt['shd_admin_plugins_lang_italian'] = 'Italian';
$txt['shd_admin_plugins_lang_japanese'] = 'Japanese';
$txt['shd_admin_plugins_lang_kurdish_kurmanji'] = 'Kurdish (Kurmanji)';
$txt['shd_admin_plugins_lang_kurdish_sorani'] = 'Kurdish (Sorani)';
$txt['shd_admin_plugins_lang_macedonian'] = 'Macedonian';
$txt['shd_admin_plugins_lang_malay'] = 'Malay';
$txt['shd_admin_plugins_lang_norwegian'] = 'Norwegian';
$txt['shd_admin_plugins_lang_persian'] = 'Persian';
$txt['shd_admin_plugins_lang_polish'] = 'Polish';
$txt['shd_admin_plugins_lang_portuguese_brazilian'] = 'Portuguese (Brazilian)';
$txt['shd_admin_plugins_lang_portuguese_pt'] = 'Portuguese';
$txt['shd_admin_plugins_lang_romanian'] = 'Romanian';
$txt['shd_admin_plugins_lang_russian'] = 'Russian';
$txt['shd_admin_plugins_lang_serbian_cyrillic'] = 'Serbian (Cyrillic)';
$txt['shd_admin_plugins_lang_serbian_latin'] = 'Serbian (Latin)';
$txt['shd_admin_plugins_lang_slovak'] = 'Slovak';
$txt['shd_admin_plugins_lang_spanish_es'] = 'Spanish (Spain)';
$txt['shd_admin_plugins_lang_spanish_latin'] = 'Spanish (Latin)';
$txt['shd_admin_plugins_lang_swedish'] = 'Swedish';
$txt['shd_admin_plugins_lang_thai'] = 'Thai';
$txt['shd_admin_plugins_lang_turkish'] = 'Turkish';
$txt['shd_admin_plugins_lang_ukrainian'] = 'Ukrainian';
$txt['shd_admin_plugins_lang_urdu'] = 'Urdu';
$txt['shd_admin_plugins_lang_uzbek_latin'] = 'Uzbek (Latin)';
$txt['shd_admin_plugins_lang_vietnamese'] = 'Vietnamese';
//@}

//! Maintenance
//@{
$txt['shd_admin_maint_back'] = 'Back to Helpdesk Maintenance';
$txt['shd_admin_maint_desc'] = 'This area allows you to perform some common maintenance tasks within SimpleDesk.';

$txt['shd_admin_maint_reattribute'] = 'Reattribute User Posts';
$txt['shd_admin_maint_reattribute_desc'] = 'If a user\'s account has been removed, this allows for rejoining tickets from their old account with their new one.';
$txt['shd_admin_maint_reattribute_posts_made'] = 'Reattribute tickets and replies made by:';
$txt['shd_admin_maint_reattribute_posts_user'] = 'This user name';
$txt['shd_admin_maint_reattribute_posts_email'] = 'This email address';
$txt['shd_admin_maint_reattribute_posts_starter'] = 'Ticket Starter';
$txt['shd_admin_maint_reattribute_posts_to'] = 'And attach them to this user account:';
$txt['shd_admin_maint_reattribute_btn'] = 'Reattribute now';
$txt['shd_admin_maint_reattribute_success'] = 'All tickets and posts that could be found were reattributed. You should probably run the "Find and Repair Errors" maintenance option from within Helpdesk Maintenance now. (Otherwise, some tickets may not show up correctly.)';
$txt['shd_reattribute_confirm'] = 'Are you sure you want to attribute all tickets and replies (from the previously deleted account) with %type% of "%find%" to member "%member_to%"?';
$txt['shd_reattribute_confirm_starter'] = 'Are you sure you want to attribute all ticket starters of "%find%" to member "%member_to%"?';
$txt['shd_reattribute_confirm_username'] = 'a username';
$txt['shd_reattribute_confirm_email'] = 'an email address';
$txt['shd_reattribute_cannot_find_member'] = 'The helpdesk could not find the user to reattribute tickets and replies to.';
$txt[''] = 'The helpdesk could not find the orignal user to reattribute tickets and replies to.';
$txt['shd_reattribute_no_email'] = 'No email address was supplied.';
$txt['shd_reattribute_no_user'] = 'No username was supplied.';
$txt['shd_reattribute_no_messages'] = 'No messages were found to be re-attributed.';
$txt['shd_reattribute_in_use'] = 'The only messages found to be re-attributed are all listed against a current user, and so no further re-attribution can be done on those messages.';

$txt['shd_admin_maint_massdeptmove'] = 'Move Tickets';
$txt['shd_admin_maint_massdeptmove_desc'] = 'This area allows you to mass-move tickets between departments.';
$txt['shd_admin_maint_massdeptmove_select'] = '(Select department)';
$txt['shd_admin_maint_massdeptmove_from'] = 'Move tickets from';
$txt['shd_admin_maint_massdeptmove_to'] = 'to';
$txt['shd_admin_maint_massdeptmove_success'] = 'All matching tickets were moved successfully to their new department.';
$txt['shd_admin_maint_massdeptmove_samedept'] = 'You must select different start and destination departments to move tickets to.';
$txt['shd_admin_maint_massdeptmove_open'] = 'Move open/outstanding tickets from this department';
$txt['shd_admin_maint_massdeptmove_closed'] = 'Move closed tickets from this department';
$txt['shd_admin_maint_massdeptmove_deleted'] = 'Move deleted tickets from this department';
$txt['shd_admin_maint_massdeptmove_lastupd_less'] = 'Tickets must have been last updated in the last %1$s days';
$txt['shd_admin_maint_massdeptmove_lastupd_more'] = 'Tickets must have been last updated more than %1$s days ago';

$txt['shd_admin_maint_findrepair'] = 'Find and Repair Errors';
$txt['shd_admin_maint_findrepair_desc'] = 'Sometimes, however unlikely, things get a little out of step inside the database. This operation performs an integrity check on the database and attempts to repair any errors it encounters.';

$txt['shd_admin_maint_findrepair_status'] = 'Recalculating ticket counts...';
$txt['shd_admin_maint_findrepair_firstlast'] = 'Recalculating ticket first/last associations...';
$txt['shd_admin_maint_findrepair_starterupdater'] = 'Recalculating the ticket starter and last updated by associations...';

$txt['shd_admin_recovered_dept'] = 'Recovered Tickets';
$txt['shd_admin_recovered_dept_desc'] = 'These are tickets that were somehow outside of existing departments. You can move them to real departments, and you should delete this department when it is empty.';

$txt['shd_maint_zero_tickets'] = '%1$d ticket(s) were found with invalid ids, they have all been given new ids, the next available id numbers.';
$txt['shd_maint_zero_msgs'] = '%1$d ticket posts(s) were found with invalid ids, they have all been given new ids, the next available id numbers.';
$txt['shd_maint_deleted'] = '%1$d ticket(s) had incorrect counts of the number of posts and/or deleted posts. All have been recalculated.';
$txt['shd_maint_first_last'] = '%1$d ticket(s) had incorrect messages flagged for the ticket content, or its last reply. All have been rectified.';
$txt['shd_maint_status'] = '%1$d ticket(s) had the wrong status set for them. All have been rectified.';
$txt['shd_maint_starter_updater'] = '%1$d ticket(s) had the wrong user listed as the person who opened the ticket or the last person to update the ticket. All have been rectified.';
$txt['shd_maint_invalid_dept'] = '%1$d ticket(s) were listed as being in departments that do not exist, all were moved to a new department entitled "Recovered Tickets".';

$txt['shd_maint_search_settings'] = 'Search Settings';
$txt['shd_maint_search_settings_desc'] = 'This page allows you to configure how ticket searching may be performed, and if necessary, rebuild the index used to perform searching.';
$txt['shd_maint_rebuild_index'] = 'Rebuild the Search Index';
$txt['shd_maint_rebuild_index_desc'] = 'If you have existing tickets that were around prior to the search facility being provided, or you alter the settings below, you will <strong>need</strong> to rebuild the index after. The index is what is physically used to search, and if the physical index setup is different to how searches are made, you will find searching very unrealiable.<br><strong>Important:</strong> Building the search index is a very intensive task. It will take a while to carry out, during which time please leave this window open.';
$txt['shd_maint_search_settings_warning'] = 'If you alter these settings, you will need to rebuild the search index.';
$txt['shd_search_min_size'] = 'Minimum number of letters to be considered a word (3-15)';
$txt['shd_search_max_size'] = 'Maximum number of letters to be considered a word (3-15)';
$txt['shd_search_prefix_size'] = 'Minimum number of letters to use for prefix searching<div class="smalltext">(0 = disabled)</div>';
$txt['shd_search_prefix_size_help'] = 'Prefix searching is where the index is built to allow for partial word matches. For example, searching for &quot;walk&quot; will return results such as &quot;walking&quot; or &quot;walked&quot;. It is disabled by default because it makes the index significantly bigger and searches do get slower as a consequence.';
$txt['shd_search_charset'] = 'Characters to consider as valid parts of words to search.';
$txt['shd_search_rebuilt'] = 'The search index has been rebuilt.';
//@}

/**
 *	@ignore
 *	Warning: He may bite.
*/
//! Ignore
//@{
$txt['shd_fluffy'] = 'Guardian of the <span %s>cookies</span>';
//@}