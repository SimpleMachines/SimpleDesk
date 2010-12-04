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

//! @name Permission groups
//@{
$txt['permissiongroup_helpdesk'] = 'Helpdesk permissions';
$txt['permissiongroup_simple_use_helpdesk'] = 'Permissions to use the helpdesk system';

$txt['permissiongroup_shd_staff'] = 'Helpdesk staff permissions';
$txt['permissiongroup_simple_shd_staff'] = 'Permissions for staff users of the helpdesk';

$txt['permissiongroup_shd_admin'] = 'Helpdesk administration';
$txt['permissiongroup_simple_shd_admin'] = 'Permissions for administrating the helpdesk';
//@}

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
$txt['permissionname_shd_view_ticket'] = 'View helpdesk tickets';
$txt['permissionhelp_shd_view_ticket'] = 'This permission controls whether users can see tickets at all, and more importantly whether they have access to the standard user view or the staff level view; users with the ability to view any are generally considered to be staff.';
$txt['permissionname_shd_view_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_view_ticket_any'] = 'Any tickets';
$txt['permissionname_simple_shd_view_ticket_own'] = 'Allow users to view their own public tickets';
$txt['permissionhelp_simple_shd_view_ticket_own'] = 'This permission allows regular users to see their own tickets, but only those not marked private.';
$txt['permissionname_simple_shd_view_ticket_any'] = 'Allow users to view all public helpdesk tickets';
$txt['permissionhelp_simple_shd_view_ticket_any'] = 'This permission allows users to see any normal ticket on the helpdesk.';
//@}

//! @name Ticket visibility: privacy
//@{
$txt['permissionname_shd_view_ticket_private'] = 'View private helpdesk tickets';
$txt['permissionhelp_shd_view_ticket_private'] = 'This permission controls whether tickets that are marked private can be seen by users, for example, you could use this permission for staff members who want to post a ticket that concerns them, without it being visible to all staff - only senior staff.';
$txt['permissionname_shd_view_ticket_private_own'] = 'Own private tickets';
$txt['permissionname_shd_view_ticket_private_any'] = 'Any users\' private tickets';
$txt['permissionname_simple_shd_view_ticket_private_own'] = 'Allow users to view their own private tickets';
$txt['permissionhelp_simple_shd_view_ticket_private_own'] = 'This permission allows users to see their own private tickets.';
$txt['permissionname_simple_shd_view_ticket_private_any'] = 'Allow users to view all private tickets';
$txt['permissionhelp_simple_shd_view_ticket_private_any'] = 'This permission allows users to see all of the private tickets, in addition to any other permissions they have. Recommended for senior staff.';
//@}

//! @name Ticket modifications: privacy
//@{
$txt['permissionname_shd_alter_privacy'] = 'Allow users to alter the privacy on a ticket';
$txt['permissionhelp_shd_alter_privacy'] = 'This permission allows a user to change the privacy on a ticket, from public to private and back. Actual ticket editing permission is not required to use this.';
$txt['permissionname_shd_alter_privacy_own'] = 'Own tickets';
$txt['permissionname_shd_alter_privacy_any'] = 'Any tickets';
$txt['permissionname_simple_shd_alter_privacy_own'] = 'Allow users to mark their own tickets as private/public';
$txt['permissionhelp_simple_shd_alter_privacy_own'] = 'This allows users to flag their own tickets as private or public, in line with the ability to view private tickets system. (This does not require the ability to edit ticket details.)';
$txt['permissionname_simple_shd_alter_privacy_any'] = 'Allow users to mark their any tickets as private/public';
$txt['permissionhelp_simple_shd_alter_privacy_any'] = 'This allows users to flag any users\' tickets as private or public, in line with the ability to view private tickets system. (This does not require the ability to edit ticket details.)';
//@}

//! @name Ticket modifications: urgency
//@{
$txt['permissionname_shd_alter_urgency'] = 'Allow users to alter the urgency of tickets';
$txt['permissionhelp_shd_alter_urgency'] = 'Tickets are available in a range of "urgency" levels: Low, Medium, High, Very High, Severe, Critical. This permission allows users to raise and lower urgency up to the level of High (and lower from Very High back to High only)';
$txt['permissionname_shd_alter_urgency_own'] = 'Own tickets';
$txt['permissionname_shd_alter_urgency_any'] = 'Any tickets';
$txt['permissionname_simple_shd_alter_urgency_own'] = 'Allow users to raise or lower the urgency of their own tickets';
$txt['permissionhelp_simple_shd_alter_urgency_own'] = 'Tickets are available in a range of "urgency" levels: Low, Medium, High, Very High, Severe, Critical. This permission allows users to raise and lower urgency of their own tickets up to the level of High (and lower from Very High back to High only)';
$txt['permissionname_simple_shd_alter_urgency_any'] = 'Allow users to raise or lower the urgency of any tickets';
$txt['permissionhelp_simple_shd_alter_urgency_any'] = 'Tickets are available in a range of "urgency" levels: Low, Medium, High, Very High, Severe, Critical. This permission allows users to raise and lower urgency of any tickets in the helpdesk up to the level of High (and lower from Very High back to High only)';
$txt['permissionname_shd_alter_urgency_higher'] = 'Allow user to set urgency "Very High" or above';
$txt['permissionhelp_shd_alter_urgency_higher'] = 'This permission extends the above permission, and allows users to be able to select the highest levels of urgency for a ticket. Generally this would be assigned by staff only.';
$txt['permissionname_shd_alter_urgency_higher_own'] = 'Own tickets';
$txt['permissionname_shd_alter_urgency_higher_any'] = 'Any tickets';
$txt['permissionname_simple_shd_alter_urgency_higher_own'] = 'Allow users to set the urgency of their own tickets to "Very High" or above';
$txt['permissionhelp_simple_shd_alter_urgency_higher_any'] = 'Urgency of tickets is split into two tiers, Low/Medium/High, and Very High/Severe/Critical. This permission allows users to flag their own tickets higher than High.';
$txt['permissionname_simple_shd_alter_urgency_higher_any'] = 'Allow users to set the urgency of any tickets to "Very High" or above';
$txt['permissionhelp_simple_shd_alter_urgency_higher_any'] = 'Urgency of tickets is split into two tiers, Low/Medium/High, and Very High/Severe/Critical. This permission allows users to flag any tickets more urgent than High urgency.';
//@}

//! @name Ticket modification: assignment
//@{
$txt['permissionname_shd_assign_ticket'] = 'Allow users to assign a ticket';
$txt['permissionhelp_shd_assign_ticket'] = 'This permission allows users to assign tickets to staff to be dealt with; normally would be given to staff to assign tickets to themselves, or to managers to assign to other users';
$txt['permissionname_shd_assign_ticket_own'] = 'To themselves';
$txt['permissionname_shd_assign_ticket_any'] = 'Any staff member';
$txt['permissionname_simple_shd_assign_ticket_own'] = 'Allow users to assign tickets to themselves';
$txt['permissionhelp_simple_shd_assign_ticket_own'] = 'This permission allows a user to assign a ticket to themselves for resolution. Would be useful for lower-level staff.';
$txt['permissionname_simple_shd_assign_ticket_any'] = 'Allow users to assign tickets to any staff memmber';
$txt['permissionhelp_simple_shd_assign_ticket_any'] = 'This permission allows a user to assign a ticket to any staff member, including themselves. Certainly higher level staff would normally have access, but for smaller numbers of staff, all may be granted permission to use it.';
//@}

//! @name Ticket modification: resolution
//@{
$txt['permissionname_shd_resolve_ticket'] = 'Allow users to mark a ticket as resolved';
$txt['permissionhelp_shd_resolve_ticket'] = 'This permission allows users to mark tickets resolved, and mark completed tickets as unresolved if there is further business to attend to.';
$txt['permissionname_shd_resolve_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_resolve_ticket_any'] = 'Any tickets';
$txt['permissionname_simple_shd_resolve_ticket_own'] = 'Allow users to mark their own tickets as resolved';
$txt['permissionhelp_simple_shd_resolve_ticket_own'] = 'This permission allows a user to mark their own tickets as resolved, and additionally to mark any completed tickets as unresolved if further things need to be attended to.';
$txt['permissionname_simple_shd_resolve_ticket_any'] = 'Allow users to mark any ticket as resolved';
$txt['permissionhelp_simple_shd_resolve_ticket_any'] = 'This permission allows a user to mark any ticket as resolved, and additionally reopen any already-resolved ticket.';
//@}

//! @name Ticket posting: new ticket
//@{
$txt['permissionname_shd_new_ticket'] = 'Allow users to post a new ticket';
$txt['permissionhelp_shd_new_ticket'] = 'This permission allows users in this membergroup to file new tickets for themselves.';
//@}

//! @name Ticket posting: replies
//@{
$txt['permissionname_shd_reply_ticket'] = 'Allow users to reply to tickets';
$txt['permissionhelp_shd_reply_ticket'] = 'This permission allows users to reply to tickets, either to provide further details, or to provide an answer.';
$txt['permissionname_shd_reply_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_reply_ticket_any'] = 'Any tickets';
$txt['permissionname_simple_shd_reply_ticket_own'] = 'Allow users to reply to their own tickets';
$txt['permissionhelp_simple_shd_reply_ticket_own'] = 'This permission allows a user to reply to tickets that they have started. You would normally grant this to membergroups who can start tickets, as it allows them to reply to staff comments.';
$txt['permissionname_simple_shd_reply_ticket_any'] = 'Allow users to reply to any ticket';
$txt['permissionhelp_simple_shd_reply_ticket_any'] = 'This permission allows a user to reply to any ticket they have access to (see the permissions about being able to view tickets). This would normally be granted to membergroups that are considered staff.';
//@}

//! @name Ticket posting: editing a ticket
//@{
$txt['permissionname_shd_edit_ticket'] = 'Allow users to edit the ticket details';
$txt['permissionhelp_shd_edit_ticket'] = 'This permission allows a user to edit the core details of a ticket, such as the ticket\'s name and initial description.';
$txt['permissionname_shd_edit_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_edit_ticket_any'] = 'Any tickets';
$txt['permissionname_simple_shd_edit_ticket_own'] = 'Allow users to edit their own tickets\' details';
$txt['permissionhelp_simple_shd_edit_ticket_own'] = 'This permission allows a user to edit the basic ticket details of their own tickets, the title and body contents.';
$txt['permissionname_simple_shd_edit_ticket_any'] = 'Allow users to edit any ticket\'s details';
$txt['permissionhelp_simple_shd_edit_ticket_any'] = 'This permission allows a user to edit the basic ticket details (title and body contents) of any ticket.';
//@}

//! @name Ticket posting: editing replies
//@{
$txt['permissionname_shd_edit_reply'] = 'Allow users to edit replies in tickets';
$txt['permissionhelp_shd_edit_reply'] = 'This permission allows a user to edit replies in tickets, not the main ticket itself.';
$txt['permissionname_shd_edit_reply_own'] = 'Own replies';
$txt['permissionname_shd_edit_reply_any'] = 'Any replies';
$txt['permissionname_simple_shd_edit_reply_own'] = 'Allow users to edit their own replies to tickets';
$txt['permissionhelp_simple_shd_edit_reply_own'] = 'This permission allows users to update the contents of replies they make to tickets.';
$txt['permissionname_simple_shd_edit_reply_any'] = 'Allow users to edit any tickets and posts';
$txt['permissionhelp_simple_shd_edit_reply_any'] = 'This permission allows users to update the contents of any replies to any tickets they have access to.';
//@}

//! @name Ticket deletion: tickets
//@{
$txt['permissionname_shd_delete_ticket'] = 'Allow users to delete a ticket';
$txt['permissionhelp_shd_delete_ticket'] = 'This permission allows a user to delete a ticket.';
$txt['permissionname_shd_delete_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_delete_ticket_any'] = 'Any tickets';
$txt['permissionname_simple_shd_delete_ticket_own'] = 'Allow users to delete their own tickets';
$txt['permissionhelp_simple_shd_delete_ticket_own'] = 'This permission allows a user to delete their own tickets. Note that this is not a permanent deletion - all "deleted" tickets are moved to a recycle bin.';
$txt['permissionname_simple_shd_delete_ticket_any'] = 'Allow users to delete any tickets';
$txt['permissionhelp_simple_shd_delete_ticket_any'] = 'This permission allows a user to delete their own tickets. Note that this is not a permanent deletion - all "deleted" tickets are moved to a recycle bin.';
//@}

//! @name Ticket deletion: replies
//@{
$txt['permissionname_shd_delete_reply'] = 'Allow users to delete replies in tickets';
$txt['permissionhelp_shd_delete_reply'] = 'This permission allows a user to delete replies in tickets, not the main ticket itself.';
$txt['permissionname_shd_delete_reply_own'] = 'Own replies';
$txt['permissionname_shd_delete_reply_any'] = 'Any replies';
$txt['permissionname_simple_shd_delete_reply_own'] = 'Allow users to delete their own replies to tickets';
$txt['permissionhelp_simple_shd_delete_reply_own'] = 'This permission allows users to remove any replies they have made to a ticket. Note that this is not a permanent deletion - all "deleted" tickets are moved to a recycle bin.';
$txt['permissionname_simple_shd_delete_reply_any'] = 'Allow users to delete any replies to tickets';
$txt['permissionhelp_simple_shd_delete_reply_any'] = 'This permission allows users to the replies of any user to any ticket they can access. Note that this is not a permanent deletion - all "deleted" tickets are moved to a recycle bin.';
//@}

//! @name Ticket deletion: permadelete
//@{
$txt['permissionname_shd_delete_recycling'] = 'Delete tickets/posts from recycling';
$txt['permissionhelp_shd_delete_recycling'] = 'This permission allows users to remove tickets and posts from the recycling area. Note that once removed here, they are NOT recoverable, as such it is not recommended to grant this permission to all staff.';
//@}

//! @name Ticket deletion: accessing recycle bin
//@{
$txt['permissionname_shd_access_recyclebin'] = 'Access recycling bin';
$txt['permissionhelp_shd_access_recyclebin'] = 'Users with this permission will be able to access the list of recycled tickets and read the tickets.';
//@}

//! @name Ticket deletion: restoration of tickets
//@{
$txt['permissionname_shd_restore_ticket'] = 'Allow user to restore tickets from the recycling bin';
$txt['permissionhelp_shd_restore_ticket'] = 'This permission allows a user to restore deleted tickets from the recycling bin.';
$txt['permissionname_shd_restore_ticket_own'] = 'Own tickets';
$txt['permissionname_shd_restore_ticket_any'] = 'Any tickets';
$txt['permissionname_simple_shd_restore_ticket_own'] = 'Allow users to restore their own tickets from recycling';
$txt['permissionhelp_simple_shd_restore_ticket_own'] = 'When tickets are deleted, they are not normally deleted permanently, just saved in a recycling area, from which users can recover them until the administrator or suitably privileged user can delete them (see "permanently delete"). This permission allows users to recover their own tickets out of the recycling area.';
$txt['permissionname_simple_shd_restore_ticket_any'] = 'Allow users to restore any tickets from recycling';
$txt['permissionhelp_simple_shd_restore_ticket_any'] = 'When tickets are deleted, they are not normally deleted permanently, just saved in a recycling area, from which users can recover them until the administrator or suitably privileged user can delete them (see "permanently delete"). This permission allows users to recover any tickets they would have access to out of the recycling area.';
//@}

//! @name Ticket deletion: restoration of replies
//@{
$txt['permissionname_shd_restore_reply'] = 'Allow user to restore replies in deleted tickets from the recycling bin';
$txt['permissionhelp_shd_restore_reply'] = 'This permission allows a user to restore deleted replies from the recycling bin.';
$txt['permissionname_shd_restore_reply_own'] = 'Own replies';
$txt['permissionname_shd_restore_reply_any'] = 'Any replies';
$txt['permissionname_simple_shd_restore_reply_own'] = 'Allow users to restore their own replies in tickets from recycling';
$txt['permissionhelp_simple_shd_restore_reply_own'] = 'When tickets are deleted, they are not normally deleted permanently, just saved in a recycling area, from which users can recover them until the administrator or suitably privileged user can delete them (see "permanently delete"). This permission allows users to recover replies to tickets - their own replies, note, from tickets out of the recycling area.';
$txt['permissionname_simple_shd_restore_reply_any'] = 'Allow users to restore any replies from tickets in recycling';
$txt['permissionhelp_simple_shd_restore_reply_any'] = 'When tickets are deleted, they are not normally deleted permanently, just saved in a recycling area, from which users can recover them until the administrator or suitably privileged user can delete them (see "permanently delete"). This permission allows users to recover any replies back to regular tickets, from tickets they would have access to out of the recycling area.';
//@}

//! @name Attachments
//@{
$txt['permissionname_shd_post_attachment'] = 'Allow users to post attachments';
$txt['permissionhelp_shd_post_attachment'] = 'This permission allows a user to post attachments to tickets.';
$txt['permissionname_simple_shd_post_attachment'] = 'Allow users to attach their files to tickets';
$txt['permissionhelp_simple_shd_post_attachment'] = 'This permission allows users the ability to add files to tickets that you have, which might be screenshots of problems, or information that relates to their ticket, or other such information.';
//@}

//! @name Ticket to topic, topic to ticket movement
//@{
global $modSettings;
$txt['permissionname_shd_ticket_to_topic'] = 'Move tickets to topics';
$txt['permissionhelp_shd_ticket_to_topic'] = 'This permission allows a user to transform tickets into topics in the forum. This should only be granted to staff members.';
$txt['permissionname_shd_topic_to_ticket'] = 'Move topics to tickets';
$txt['permissionhelp_shd_topic_to_ticket'] = 'This permission allows a user to transform topics in the forum into helpdesk tickets. This should only be granted to staff members.';
//@}

?>