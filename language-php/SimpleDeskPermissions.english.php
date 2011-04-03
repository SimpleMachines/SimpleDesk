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
# File Info: SimpleDesk-Permissions.english.php / 1.0 Felidae #
###############################################################
// Version: 1.0 Felidae; SimpleDesk permissions

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	This file contains all of the language strings (both main description and help text) for all permissions that SimpleDesk adds to the
 *	permissions pages. Note that both classic and simple view are accounted for, explaining the large number of strings per permission.
 *
 *	@package language
 *	@todo Document the text groups in this file.
 *	@since 1.0
 */

global $modSettings;

//! @name General permissions
//@{
$txt['permissionname_access_helpdesk'] = 'Access the helpdesk';
$txt['permissionhelp_access_helpdesk'] = 'This permission allows users to even see the helpdesk, and is required to do anything within the helpdesk; is available in the event of banning someone from the helpdesk.';
$txt['permissionname_admin_helpdesk'] = 'Administrate the helpdesk (allows reconfiguration)';
$txt['permissionhelp_admin_helpdesk'] = 'This permission controls whether administrative functions of the helpdesk can be passed on to users who are not administrators of the forum; typically senior associates/helpdesk agents would have this.';
$txt['permissionname_shd_staff'] = 'Treat this user group as helpdesk staff';
$txt['permissionhelp_shd_staff'] = 'Users with this permission will be treated as staff. Amongst other things, this grants the ability to reply to any ticket that is not owned by the starter.';
//@}

//! @name Ticket visibility: general
//@{
$txt['permissionname_shd_view_ticket'] = 'What tickets can users see?';
$txt['permissionhelp_shd_view_ticket'] = 'This permission controls whether users can see tickets at all, and more importantly whether they have access to the standard user view or the staff level view; users with the ability to view any are generally considered to be staff.';
$txt['permissionname_shd_view_ticket_no'] = 'None';
$txt['permissionname_shd_view_ticket_own'] = 'Their own tickets';
$txt['permissionname_shd_view_ticket_any'] = 'Any tickets';
//@}

//! @name Ticket visibility: privacy
//@{
$txt['permissionname_shd_view_ticket_private'] = 'What private tickets can users see?';
$txt['permissionhelp_shd_view_ticket_private'] = 'This permission controls whether tickets that are marked private can be seen by users, for example, you could use this permission for staff members who want to post a ticket that concerns them, without it being visible to all staff - only senior staff.';
$txt['permissionname_shd_view_ticket_private_no'] = 'None';
$txt['permissionname_shd_view_ticket_private_own'] = 'Own private tickets';
$txt['permissionname_shd_view_ticket_private_any'] = 'Any private tickets';
//@}

//! @name Ticket visibility: closed
//@{
$txt['permissionname_shd_view_closed'] = 'Can users see closed tickets?';
$txt['permissionhelp_shd_view_closed'] = 'This permission controls whether users can see tickets previously marked closed; might be useful for staff to be able to see closed tickets. (Note that private tickets are still honoured as such.)';
$txt['permissionname_shd_view_closed_no'] = 'No';
$txt['permissionname_shd_view_closed_own'] = 'Own closed tickets';
$txt['permissionname_shd_view_closed_any'] = 'Any closed tickets';
//@}

//! @name Ticket modifications: privacy
//@{
$txt['permissionname_shd_alter_privacy'] = 'Change ticket privacy';
$txt['permissionhelp_shd_alter_privacy'] = 'This permission allows a user to change the privacy on a ticket, from public to private and back. Actual ticket editing permission is not required to use this.';
$txt['permissionname_shd_alter_privacy_own'] = 'Own tickets';
$txt['permissionname_shd_alter_privacy_any'] = 'Any tickets';
//@}

//! @name Ticket modifications: urgency
//@{
$txt['permissionname_shd_alter_urgency'] = 'Change ticket urgency';
$txt['permissionhelp_shd_alter_urgency'] = 'Tickets are available in a range of \'urgency\' levels: Low, Medium, High, Very High, Severe, Critical. This permission allows users to raise and lower urgency up to the level of High (and lower from Very High back to High only)';
$txt['permissionname_shd_alter_urgency_own'] = 'Own tickets';
$txt['permissionname_shd_alter_urgency_any'] = 'Any tickets';
$txt['permissionname_shd_alter_urgency_higher'] = 'Change to \'higher\' urgencies';
$txt['permissionhelp_shd_alter_urgency_higher'] = 'This permission extends the above permission, and allows users to be able to select the highest levels of urgency for a ticket. Generally this would be assigned by staff only.';
$txt['permissionname_shd_alter_urgency_higher_own'] = 'Own tickets';
$txt['permissionname_shd_alter_urgency_higher_any'] = 'Any tickets';
//@}

//! @name Ticket modification: assignment
//@{
$txt['permissionname_shd_assign_ticket'] = 'Assign a ticket';
$txt['permissionhelp_shd_assign_ticket'] = 'This permission allows users to assign tickets to staff to be dealt with; normally would be given to staff to assign tickets to themselves, or to managers to assign to other users';
$txt['permissionname_shd_assign_ticket_own'] = 'To themselves';
$txt['permissionname_shd_assign_ticket_any'] = 'Any staff member';
//@}

//! @name Ticket modification: resolution
//@{
$txt['permissionname_shd_resolve_ticket'] = 'Mark a ticket resolved';
$txt['permissionhelp_shd_resolve_ticket'] = 'This permission allows users to mark tickets resolved, and mark completed tickets as unresolved if there is further business to attend to.';
$txt['permissionname_shd_resolve_ticket_no'] = 'No tickets';
$txt['permissionname_shd_resolve_ticket_own'] = 'Their own tickets';
$txt['permissionname_shd_resolve_ticket_any'] = 'Any tickets';
//@}

//! @name Ticket posting: new ticket
//@{
$txt['permissionname_shd_new_ticket'] = 'Post new tickets';
$txt['permissionhelp_shd_new_ticket'] = 'This permission allows users in this membergroup to file new tickets for themselves.';
//@}

//! @name Ticket posting: replies
//@{
$txt['permissionname_shd_reply_ticket'] = 'Reply to tickets';
$txt['permissionhelp_shd_reply_ticket'] = 'This permission allows users to reply to tickets, either to provide further details, or to provide an answer.';
$txt['permissionname_shd_reply_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_reply_ticket_any'] = 'Any tickets';
//@}

//! @name Ticket posting: editing a ticket
//@{
$txt['permissionname_shd_edit_ticket'] = 'Edit ticket details';
$txt['permissionhelp_shd_edit_ticket'] = 'This permission allows a user to edit the core details of a ticket, such as the ticket\'s name and initial description.';
$txt['permissionname_shd_edit_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_edit_ticket_any'] = 'Any tickets';
//@}

//! @name Ticket posting: editing replies
//@{
$txt['permissionname_shd_edit_reply'] = 'Edit ticket replies';
$txt['permissionhelp_shd_edit_reply'] = 'This permission allows a user to edit replies in tickets, not the main ticket itself.';
$txt['permissionname_shd_edit_reply_own'] = 'Own replies';
$txt['permissionname_shd_edit_reply_any'] = 'Any replies';
//@}

//! @name Ticket deletion: tickets
//@{
$txt['permissionname_shd_delete_ticket'] = 'Delete a ticket';
$txt['permissionhelp_shd_delete_ticket'] = 'This permission allows a user to delete a ticket.';
$txt['permissionname_shd_delete_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_delete_ticket_any'] = 'Any tickets';
//@}

//! @name Ticket deletion: replies
//@{
$txt['permissionname_shd_delete_reply'] = 'Delete ticket replies';
$txt['permissionhelp_shd_delete_reply'] = 'This permission allows a user to delete replies in tickets, not the main ticket itself.';
$txt['permissionname_shd_delete_reply_own'] = 'Own replies';
$txt['permissionname_shd_delete_reply_any'] = 'Any replies';
//@}

//! @name Ticket deletion: permadelete
//@{
$txt['permissionname_shd_delete_recycling'] = '<strong>Permanently</strong> delete items';
$txt['permissionhelp_shd_delete_recycling'] = 'This permission allows users to remove tickets and posts from the recycling area. Note that once removed here, they are NOT recoverable, as such it is not recommended to grant this permission to all staff.';
//@}

//! @name Ticket deletion: accessing recycle bin
//@{
$txt['permissionname_shd_access_recyclebin'] = 'Access recycling bin';
$txt['permissionhelp_shd_access_recyclebin'] = 'Users with this permission will be able to access the list of recycled tickets and read the tickets.';
//@}

//! @name Ticket deletion: restoration of tickets
//@{
$txt['permissionname_shd_restore_ticket'] = 'Restore deleted tickets';
$txt['permissionhelp_shd_restore_ticket'] = 'This permission allows a user to restore deleted tickets from the recycling bin.';
$txt['permissionname_shd_restore_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_restore_ticket_any'] = 'Any tickets';
//@}

//! @name Ticket deletion: restoration of replies
//@{
$txt['permissionname_shd_restore_reply'] = 'Restore deleted replies';
$txt['permissionhelp_shd_restore_reply'] = 'This permission allows a user to restore deleted replies from the recycling bin.';
$txt['permissionname_shd_restore_reply_own'] = 'Own replies';
$txt['permissionname_shd_restore_reply_any'] = 'Any replies';
//@}

//! @name Attachments
//@{
$txt['permissionname_shd_post_attachment'] = 'Post attachments';
$txt['permissionhelp_shd_post_attachment'] = 'This permission allows a user to post attachments to tickets.';
//@}

//! @name Posting proxy tickets (i.e. posting new ticket on behalf of someone else)
//@{
$txt['permissionname_shd_post_proxy'] = 'Post proxy tickets';
$txt['permissionhelp_shd_post_proxy'] = 'This permission allows a user, typically staff, to create a ticket on behalf of another user (e.g. from a telephone call)';

//! @name Ticket to topic, topic to ticket movement
//@{
$txt['permissionname_shd_ticket_to_topic'] = 'Move tickets to topics';
$txt['permissionhelp_shd_ticket_to_topic'] = 'This permission allows a user to transform tickets into topics in the forum. This should only be granted to staff members.';
$txt['permissionname_shd_topic_to_ticket'] = 'Move topics to tickets';
$txt['permissionhelp_shd_topic_to_ticket'] = 'This permission allows a user to transform topics in the forum into helpdesk tickets. This should only be granted to staff members.';
//@}

//! @name Ticket action logs.
//@{
$txt['permissionname_shd_view_ticket_logs'] = 'View ticket action logs';
$txt['permissionhelp_shd_view_ticket_logs'] = 'This permission allows the user to view a log over all actions taken in the current ticket, such as urgency changes, assigning, ticket resolving etc.';
$txt['permissionname_shd_view_ticket_logs_own'] = 'For own tickets';
$txt['permissionname_shd_view_ticket_logs_any'] = 'For any ticket';
//@}

//! @name Ticket merging
//@{
$txt['permissionname_shd_merge_ticket'] = 'Merge two tickets together';
$txt['permissionhelp_shd_merge_ticket'] = 'This allows a user to merge two tickets from the same creator together (to ensure the creator can still see the result ticket)';
$txt['permissionname_shd_merge_ticket_own'] = 'Two of their own';
$txt['permissionname_shd_merge_ticket_any'] = 'Two from any user';
//@}

//! @name Ticket splitting
//@{
$txt['permissionname_shd_split_ticket'] = 'Split a ticket into two';
$txt['permissionhelp_shd_split_ticket'] = 'This allows a user to split a ticket they can see into two tickets, maybe if the ticket has started discussing a separate issue.';
$txt['permissionname_shd_split_ticket_own'] = 'One of their own';
$txt['permissionname_shd_split_ticket_any'] = 'One from any user';
//@}

//! @name Ticket relationships
//@{
$txt['permissionname_shd_view_relationships'] = 'View relationships';
$txt['permissionhelp_shd_view_relationships'] = 'Tickets can be related to each other, as duplicates, linked together, or have dependencies (one requires another to be completed). Not all setups will want users to be able to see relationships, particularly if the relationships are between different users\'s tickets, so this permission blocks the links.';
$txt['permissionname_shd_create_relationships'] = 'Create relationships';
$txt['permissionhelp_shd_create_relationships'] = 'Tickets can have relationships, this permission allows a user the ability to mark a given ticket as having a given relationship between any two tickets they can see. This permission also gives the ability for a relationship to be changed, e.g. from parent/child to linked together.';
$txt['permissionname_shd_delete_relationships'] = 'Remove relationships';
$txt['permissionhelp_shd_delete_relationships'] = 'Sometimes a ticket relationship will no longer be appropriate; this allows the user to remove a relationship between two tickets (not the tickets themselves, note)';
//@}

//! @name Viewing IP addresses
//@{
$txt['permissionname_shd_view_ip'] = 'View IP addresses';
$txt['permissionhelp_shd_view_ip'] = 'IP addresses are recorded on every new post/reply made in the helpdesk. This permission controls whether users can see them or not. If \'anyone\' is selected, this includes administrators.';
$txt['permissionname_shd_view_ip_own'] = 'Only their own';
$txt['permissionname_shd_view_ip_any'] = 'Anyone\'s';
//@}

//! @name User profile access
//@{
$txt['permissionname_shd_view_profile'] = 'View helpdesk profiles';
$txt['permissionhelp_shd_view_profile'] = 'Users do have a profile within the helpdesk; it allows them to set user preferences, view their tickets, and stats.';
$txt['permissionname_shd_view_profile_no'] = 'None';
$txt['permissionname_shd_view_profile_own'] = 'Only their own';
$txt['permissionname_shd_view_profile_any'] = 'Anyone\'s';
//@}

//! @name User profile logs
//@{
$txt['permissionname_shd_view_profile_log'] = 'View profile action logs';
$txt['permissionhelp_shd_view_profile_log'] = 'Just as there is the master action log within the helpdesk, events made by a particular individual can be viewed from their profile.';
$txt['permissionname_shd_view_profile_log_no'] = 'None';
$txt['permissionname_shd_view_profile_log_own'] = 'Only their own';
$txt['permissionname_shd_view_profile_log_any'] = 'Anyone\'s';
//@}

//! @name User preferences
$txt['permissionname_shd_view_preferences'] = 'View user preferences';
$txt['permissionhelp_shd_view_preferences'] = 'Users have some configurable options, such as when to receive email notifications. This allows them access to change their preferences.';
$txt['permissionname_shd_view_preferences_no'] = 'None';
$txt['permissionname_shd_view_preferences_own'] = 'Only their own';
$txt['permissionname_shd_view_preferences_any'] = 'Anyone\'s';

////////////////////////////////

$txt['shd_admin_permissions'] = 'Helpdesk Permissions';
$txt['shd_admin_permissions_homedesc'] = 'This area allows you to configure the permissions for SimpleDesk - from here you can create roles for your users based on templates, and assign those roles to your membergroups.';

//! @name Permission categories
//@{
$txt['shd_permgroup_general'] = 'General helpdesk permissions';
$txt['shd_permgroup_posting'] = 'Ticket/reply posting';
$txt['shd_permgroup_ticketactions'] = 'Ticket actions';
$txt['shd_permgroup_relationships'] = 'Relationships between tickets';
$txt['shd_permgroup_deletion'] = 'The recycle bin and ticket/reply deletion';
$txt['shd_permgroup_moderation'] = 'Ticket moderation and management';
$txt['shd_permgroup_profile'] = 'User profiles and options';

$txt['shd_permgroup_short_general'] = 'General';
$txt['shd_permgroup_short_posting'] = 'Posting';
$txt['shd_permgroup_short_ticketactions'] = 'Actions';
$txt['shd_permgroup_short_relationships'] = 'Relationships';
$txt['shd_permgroup_short_deletion'] = 'Delete/Restore';
$txt['shd_permgroup_short_moderation'] = 'Moderation';
$txt['shd_permgroup_short_profile'] = 'Profile';

$txt['shd_permgroup_denied'] = 'Denied';
//@}

//! @name Permission roles
//@{
$txt['shd_role_templates'] = 'Templates';
$txt['shd_role_templates_desc'] = 'These are the templates for permissions, of the roles you may have in your helpdesk. You will use these as a base when creating your own roles.';
$txt['shd_roles'] = 'Roles';
$txt['shd_roles_desc'] = 'These are the roles in your helpdesk, listing what type of role (user/staff/admin) it is, what permissions the roles have and which roles are attached to which membergroups.';
$txt['shd_role'] = 'Role';
$txt['shd_permissions'] = 'Permissions';
$txt['shd_membergroups'] = 'Membergroups';
$txt['shd_permrole_user'] = 'Helpdesk Users';
$txt['shd_permrole_staff'] = 'Helpdesk Staff';
$txt['shd_permrole_admin'] = 'Helpdesk Administrators';
$txt['shd_create_role'] = 'Create new role based on this';
$txt['shd_no_defined_roles'] = 'You have not created any roles yet for your users!';
$txt['shd_based_on'] = 'Based on \'%1$s\' template';
$txt['shd_none'] = 'None';
$txt['shd_edit_role'] = 'Edit this role';
$txt['shd_create_role'] = 'Create New Role';
$txt['shd_edit_role'] = 'Edit Role';
$txt['shd_copy_role'] = 'Copy Role';
$txt['shd_copy_role_groups'] = 'Copy this role\'s groups as well?';
$txt['shd_delete_role'] = 'Delete Role';
$txt['shd_delete_role_confirm'] = 'Do you really want to delete this role?';
$txt['shd_create_based_on'] = 'The new role will be based on';
$txt['shd_is_based_on'] = 'This role is based on the template';
$txt['shd_create_name'] = 'What should the new role be called?';
$txt['shd_role_name'] = 'This role is called';
$txt['shd_role_membergroups'] = 'Membergroups This Role Applies To';
$txt['shd_role_membergroups_desc'] = 'Each role may well apply to multiple groups. Here is where you set what groups this role applies to; note that all the groups below may have roles already attached to them, and permissions can be duplicated that way.';
$txt['shd_badge_stars'] = 'Badge/Stars';
$txt['shd_assign_group'] = 'Assign Role/Group';
$txt['shd_roleperm_allow'] = 'Allowed';
$txt['shd_roleperm_disallow'] = 'Not allowed';
$txt['shd_roleperm_deny'] = 'Never allowed';

$txt['shd_unknown_template'] = 'The specified template does not exist.';
$txt['shd_no_role_name'] = 'You did not enter the name of your new role.';
$txt['shd_could_not_create_role'] = 'There was an error creating the role, please contact SimpleDesk.net for further support.';
$txt['shd_unknown_role'] = 'That role does not exist.';
//@}
?>