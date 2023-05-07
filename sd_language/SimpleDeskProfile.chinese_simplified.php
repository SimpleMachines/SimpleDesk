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
* File Info: SimpleDeskProfile.english.php                    *
**************************************************************/
// Version: 2.1; SimpleDesk Profile language file

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	This file contains all of the principle language strings used by the Profile page.
 *
 *	@package language
 *	@since 2.0
 */

//! @name Profile Menu Buttons
//@{
$txt['shd_profile_area'] = '服务台';
$txt['shd_profile_main'] = 'Profile';
$txt['shd_profile_home'] = 'Profile Home';
$txt['shd_profile_preferences'] = 'Preferences';
$txt['shd_profile_show_tickets'] = 'Show Tickets';
$txt['shd_profile_show_replies'] = 'Show Replies';
$txt['shd_profile_show_monitor'] = 'Monitored Tickets';
$txt['shd_profile_show_ignore'] = 'Ignored Tickets';
$txt['shd_profile_permissions'] = '权限';
$txt['shd_profile_actionlog'] = '操作日志';
$txt['shd_profile_go_to_helpdesk'] = 'Go to the helpdesk';
//@}

//! @name Profile General Strings
//@{
$txt['shd_profile_heading'] = 'Helpdesk Profile - %s';
$txt['shd_profile_edit_settings'] = 'Edit my settings';
$txt['shd_profile_view_tickets'] = 'View my tickets';
$txt['shd_profile_newticket'] = 'Post new ticket';
$txt['shd_profile_proxy'] = 'Post proxy ticket';
$txt['shd_profile_tickets'] = 'Ticket Information';
$txt['shd_profile_tickets_created'] = 'Tickets created by this user';
$txt['shd_profile_tickets_assigned'] = 'Tickets assigned to this user';

$txt['shd_profile_currently_open'] = 'currently open';
//@}

//! @name Profile Permissions
//@{
$txt['membergroups_members'] = 'Regular Members';
$txt['shd_profile_permissions_header'] = 'Helpdesk Permissions - %s';
$txt['shd_profile_permissions_description'] = 'This area displays all the permissions within the helpdesk for this user.';
$txt['shd_profile_permissions_all_admin'] = 'This user is a full administrator within the forum, and as they have full permissions within the forum, they also have every possible permission within the helpdesk.';
$txt['shd_profile_no_roles'] = 'No helpdesk roles are attached to this user, within this department.';
$txt['shd_profile_no_permissions'] = 'No permissions';
$txt['shd_profile_roles_assigned'] = 'These are the roles assigned to this user, within this department.';
$txt['shd_profile_role_membergroups'] = 'Associated Membergroups';
$txt['shd_profile_granted'] = 'Granted Permissions';
$txt['shd_profile_denied'] = 'Denied Permissions';
$txt['shd_profile_granted_desc'] = 'These are all the permissions this member has, and what role allows them to have that permission. Note that if one role would grant access to a user\'s own area but another role grants access to any area (e.g. a "users" role grants access to their own profile, but staff grants access to any profile), only the "any" one will be displayed because that takes priority over the "own" one.';
$txt['shd_profile_denied_desc'] = 'These are permissions denied to this member through one or more of the roles they have, and what role is preventing it.';
$txt['shd_profile_showdept'] = 'Show all the permissions that apply in which department';
$txt['shd_profile_selectdept'] = '[Select department]';
//@}

//! @name Profile logs
//@{
$txt['shd_profile_log'] = 'Profile action log - %s';
$txt['shd_profile_log_count_one'] = '1 篇文章';
$txt['shd_profile_log_count_more'] = '%s 个条目';
$txt['shd_profile_log_none'] = 'This member has not carried out any helpdesk activities.';
$txt['shd_profile_log_member'] = '成员';
$txt['shd_profile_log_ip'] = '会员 IP：';
$txt['shd_profile_log_date'] = '日期';
$txt['shd_profile_log_action'] = '行 动';
$txt['shd_profile_log_full'] = 'Go to the full action log (All members)';
//@}

//! @name Profile Preferences
//@{
$txt['shd_profile_preferences_header'] = 'Preferences - %s';
$txt['shd_profile_preferences_none_header'] = 'No Preferences';
$txt['shd_profile_preferences_none_desc'] = 'There are no available preferences that can be selected in this profile.';

$txt['shd_profile_save_prefs'] = 'Save Preferences';
$txt['shd_prefs_updated'] = 'Preferences have been updated.';
//@}

//! @name Profile Preferences: display
//@{
$txt['shd_pref_group_display'] = 'Look and Layout Preferences';
$txt['shd_pref_display_unread_type'] = 'When looking at Unread Posts, display:';
$txt['shd_pref_display_unread_none'] = 'Don\'t show me any tickets';
$txt['shd_pref_display_unread_unread'] = 'All tickets with new posts';
$txt['shd_pref_display_unread_outstanding'] = 'All outstanding tickets in the helpdesk';
$txt['shd_pref_display_order'] = 'Show ticket replies in what order?';
$txt['shd_pref_display_order_asc'] = 'Oldest reply first';
$txt['shd_pref_display_order_desc'] = 'Newest reply first';
//@}

//! @name Profile Preferences: block numbers
//@{
$txt['shd_pref_group_blocks'] = 'Blocks display';
$txt['shd_pref_blocks_assigned_count'] = 'Number of tickets per page in the "Assigned to Me" block';
$txt['shd_pref_blocks_new_count'] = 'Number of tickets per page in the "New Tickets" block';
$txt['shd_pref_blocks_staff_count'] = 'Number of tickets per page in the "Tickets Awaiting Staff Response" block';
$txt['shd_pref_blocks_user_count'] = 'Number of tickets per page in the "Tickets Awaiting User Response" block';
$txt['shd_pref_blocks_closed_count'] = 'Number of tickets per page in the "Closed Tickets" block';
$txt['shd_pref_blocks_recycle_count'] = 'Number of tickets per page in the "Recycled Tickets" block';
$txt['shd_pref_blocks_withdeleted_count'] = 'Number of tickets per page in the "Tickets with Deleted Replies" block';
//@}

//! @name Profile Preferences: block ordering
//@{
$txt['shd_pref_group_block_order'] = 'Ordering tickets within blocks';
$txt['shd_pref_block_order_assigned_block'] = 'Normal ordering in the "Assigned to Me" block';
$txt['shd_pref_block_order_new_block'] = 'Normal ordering of tickets in the "New Tickets" block';
$txt['shd_pref_block_order_staff_block'] = 'Normal ordering of tickets in the "Tickets Awaiting Staff Response" block';
$txt['shd_pref_block_order_user_block'] = 'Normal ordering of tickets in the "Tickets Awaiting User Response" block';
$txt['shd_pref_block_order_closed_block'] = 'Normal ordering of tickets in the "Closed Tickets" block';
$txt['shd_pref_block_order_recycle_block'] = 'Normal ordering of tickets in the "Recycled Tickets" block';
$txt['shd_pref_block_order_withdeleted_block'] = 'Normal ordering of tickets in the "Tickets with Deleted Replies" block';
$txt['shd_pref_block_order_hold_block'] = 'Normal ordering of tickets in the "Tickets On Hold" block';

$txt['shd_pref_block_order_ticketid_asc'] = 'Ticket number - lowest first';
$txt['shd_pref_block_order_ticketid_desc'] = 'Ticket number - highest first';
$txt['shd_pref_block_order_ticketname_asc'] = 'Ticket name - alphabetic A-Z';
$txt['shd_pref_block_order_ticketname_desc'] = 'Ticket name - alphabetic Z-A';
$txt['shd_pref_block_order_replies_asc'] = 'Replies - least first';
$txt['shd_pref_block_order_replies_desc'] = 'Replies - most first';
$txt['shd_pref_block_order_allreplies_asc'] = 'Replies (incl. deleted) - least first';
$txt['shd_pref_block_order_allreplies_desc'] = 'Replies (incl. deleted) - most first';
$txt['shd_pref_block_order_urgency_asc'] = 'Urgency - lowest first';
$txt['shd_pref_block_order_urgency_desc'] = 'Urgency - highest first';
$txt['shd_pref_block_order_updated_asc'] = 'Last updated - earliest first';
$txt['shd_pref_block_order_updated_desc'] = 'Last updated - latest first';
$txt['shd_pref_block_order_assigned_asc'] = 'Assigned - by name, unassigned then A-Z';
$txt['shd_pref_block_order_assigned_desc'] = 'Assigned - by name, Z-A then unassigned';
$txt['shd_pref_block_order_status_asc'] = 'Ticket status - new first';
$txt['shd_pref_block_order_status_desc'] = 'Ticket status - pending first';
$txt['shd_pref_block_order_starter_asc'] = 'Ticket starter - alphabetic A-Z';
$txt['shd_pref_block_order_starter_desc'] = 'Ticket starter - alphabetic Z-A';
$txt['shd_pref_block_order_lastreply_asc'] = 'Last reply - earliest first';
$txt['shd_pref_block_order_lastreply_desc'] = 'Last reply - latest first';
//@}

//! @name Profile Preferences: email notifications
//@{
$txt['shd_pref_group_notify'] = 'Notifications By Email';
$txt['shd_pref_notify_new_ticket'] = 'Email me when a new ticket is posted';
$txt['shd_pref_notify_new_reply_own'] = 'Email me when one of my tickets is replied to';
$txt['shd_pref_notify_new_reply_assigned'] = 'Email me when a ticket assigned to me is replied to';
$txt['shd_pref_notify_new_reply_previous'] = 'Email me when a ticket I\'ve replied to before is replied to again';
$txt['shd_pref_notify_new_reply_any'] = 'Email me when any ticket is replied to';
$txt['shd_pref_notify_assign_me'] = 'Email me when a ticket is assigned to me';
$txt['shd_pref_notify_assign_own'] = 'Email me when one of my tickets is assigned to staff';
//@}

//! @name Profile Show tickets
//@{
$txt['shd_profile_show_tickets_header'] = 'Tickets and replies posted by %s';
$txt['shd_profile_show_tickets_description'] = 'This page displays all the tickets started by this user as well as all replies the user has posted to tickets.';
$txt['shd_profile_view_full_ticket'] = 'View the full ticket';
$txt['shd_profile_a_ticket'] = 'Ticket %s';
$txt['shd_profile_reply_to_ticket'] = 'Reply to ticket %s';
//@}

//! @name Profile Show monitor/ignore
//@{
$txt['shd_profile_show_monitor_title'] = 'Monitored Tickets';
$txt['shd_profile_show_monitor_header'] = 'Tickets you are monitoring';
$txt['shd_profile_show_monitor_description'] = 'This page displays all of the tickets which you have flagged to monitor via email, regardless of your other email options.';
$txt['shd_profile_show_ignore_title'] = 'Ignored Tickets';
$txt['shd_profile_show_ignore_header'] = 'Tickets you have disabled notifications for';
$txt['shd_profile_show_ignore_description'] = 'This page displays all of the tickets on which you have chosen to disable notifications.';
//@}

//! @name Profile HD only mode
//@{
// When in HD only mode, we need to remove hints of 'forum' from the language strings. These essentially replace the non shd_ prefixed ones in Profile.language.php.
$txt['shd_current_time'] = 'Current helpdesk time';
$txt['shd_theme_info'] = 'This section allows you to customize the more general look and layout options of the helpdesk.';
$txt['shd_date_format'] = 'The format here will be used to show dates throughout the helpdesk.';
$txt['shd_return_to_post'] = 'Return to tickets after posting by default.';
$txt['shd_timeformat_default'] = '(Helpdesk Default)';
$txt['shd_theme_forum_default'] = '(Helpdesk Default)';
$txt['shd_theme_forum_default_desc'] = 'This is the default theme, which means your theme will change along with the administrator\'s settings.';
$txt['shd_show_forum_permissions'] = 'Show Forum Permissions';
$txt['shd_acct_information'] = 'Account Information';
$txt['shd_replies_per_page'] = 'Replies to display per page';
$txt['shd_per_page_default'] = 'Helpdesk default';
//@}