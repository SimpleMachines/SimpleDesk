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
# SimpleDesk Version: 1.1                                     #
# File Info: SimpleDesk-Profile.english.php / 1.1             #
###############################################################
// Version: 1.0; SimpleDesk Profile language file

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	This file contains all of the principle language strings used by the Profile page.
 *
 *	@package language
 *	@since 1.1
 */

$txt['shd_profile_area'] = 'Helpdesk';
$txt['shd_profile_main'] = 'Profile';
$txt['shd_profile_home'] = 'Profile Home';
$txt['shd_profile_preferences'] = 'Preferences';
$txt['shd_profile_show_tickets'] = 'Show Tickets';
$txt['shd_profile_show_replies'] = 'Show Replies';
$txt['shd_profile_permissions'] = 'Permissions';
$txt['shd_profile_actionlog'] = 'Action Log';
$txt['shd_profile_go_to_helpdesk'] = 'Go to the helpdesk';


$txt['shd_profile_heading'] = 'Helpdesk Profile - %s';
$txt['shd_profile_edit_settings'] = 'Edit my settings';
$txt['shd_profile_view_tickets'] = 'View my tickets';
$txt['shd_profile_proxy'] = 'Post proxy ticket';
$txt['shd_profile_tickets'] = 'Ticket Information';
$txt['shd_profile_tickets_created'] = 'Tickets created by this user';
$txt['shd_profile_tickets_assigned'] = 'Tickets assigned to this user';

$txt['shd_profile_currently_open'] = 'currently open';

// Permissions
$txt['membergroups_members'] = 'Regular Members';
$txt['shd_profile_permissions_header'] = 'Helpdesk Permissions - %s';
$txt['shd_profile_permissions_description'] = 'This area displays all the permissions within the helpdesk for this user.';
$txt['shd_profile_permissions_all_admin'] = 'This user is a full administrator within the forum, and as they have full permissions within the forum, they also have every possible permission within the helpdesk.';
$txt['shd_profile_no_roles'] = 'No helpdesk roles are attached to this user.';
$txt['shd_profile_no_permissions'] = 'No permissions';
$txt['shd_profile_roles_assigned'] = 'These are the roles assigned to this user.';
$txt['shd_profile_role_membergroups'] = 'Associated Membergroups';
$txt['shd_profile_granted'] = 'Granted Permissions';
$txt['shd_profile_denied'] = 'Denied Permissions';
$txt['shd_profile_granted_desc'] = 'These are all the permissions this member has, and what role allows them to have that permission. Note that if one role would grant access to a user\'s own area but another role grants access to any area (e.g. a "users" role grants access to their own profile, but staff grants access to any profile), only the "any" one will be displayed because that takes priority over the "own" one.';
$txt['shd_profile_denied_desc'] = 'These are permissions denied to this member through one or more of the roles they have, and what role is preventing it.';

// Profile logs
$txt['shd_profile_log'] = 'Profile action log - %s';
$txt['shd_profile_log_count_one'] = '1 entry';
$txt['shd_profile_log_count_more'] = '%s entries';
$txt['shd_profile_log_none'] = 'This member has not carried out any helpdesk activities.';
$txt['shd_profile_log_member'] = 'Member';
$txt['shd_profile_log_ip'] = 'Member IP:';
$txt['shd_profile_log_date'] = 'Date';
$txt['shd_profile_log_action'] = 'Action';
$txt['shd_profile_log_full'] = 'Go to the full action log (All members)';

// Preferences
$txt['shd_profile_preferences_header'] = 'Preferences - %s';
$txt['shd_profile_preferences_none_header'] = 'No Preferences';
$txt['shd_profile_preferences_none_desc'] = 'There are no available preferences that can be selected in this profile.';

$txt['shd_profile_save_prefs'] = 'Save Preferences';
$txt['shd_prefs_updated'] = 'Preferences have been updated.';

// Show tickets
$txt['shd_profile_show_tickets_header'] = 'Tickets and replies posted by %s';
$txt['shd_profile_show_tickets_description'] = 'This page displays all the tickets started by this user as well as all replies the user has posted to tickets.';
$txt['shd_profile_view_full_ticket'] = 'View the full ticket';
$txt['shd_profile_a_ticket'] = 'Ticket %s';
$txt['shd_profile_reply_to_ticket'] = 'Reply to ticket %s';

?>