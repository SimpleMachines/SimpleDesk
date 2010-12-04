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
# File Info: SimpleDesk.english.php / 1.0 Felidae             #
###############################################################
// Version: 1.0 Felidae; SimpleDesk main language file

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	This file contains all of the principle language strings used by SimpleDesk and are loaded on every page.
 *
 *	@package language
 *	@todo Document the text groups in this file.
 *	@since 1.0
 */

$txt['shd_helpdesk'] = 'Helpdesk';

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Welcome to the main helpdesk administration center!';
$txt['shd_admin_title'] = 'Helpdesk Administration Center';
$txt['shd_staff_list'] = 'Helpdesk staff';
$txt['shd_update_available'] = 'New version available!';
$txt['shd_update_message'] = 'A new version of SimpleDesk has been released. We recommened you to <a href="#" id="update-link">update to the latest version</a> in order to stay secure and enjoy all features our modification have to offer.
<span style="display: none;" id="information-link-span"><br />For more information on what is new in this release, please visit <a href="#" id="information-link" target="_blank">our website</a>.</span><br />
<strong>The SimpleDesk Team</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Low';
$txt['shd_urgency_1'] = 'Medium';
$txt['shd_urgency_2'] = 'High';
$txt['shd_urgency_3'] = 'Very High';
$txt['shd_urgency_4'] = 'Severe';
$txt['shd_urgency_5'] = 'Critical';
$txt['shd_urgency_increase'] = 'Increase';
$txt['shd_urgency_decrease'] = 'Decrease';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'New';
$txt['shd_status_1'] = 'Pending Staff Comment';
$txt['shd_status_2'] = 'Pending User Comment';
$txt['shd_status_3'] = 'Resolved/Closed';
$txt['shd_status_4'] = 'Referred to Supervisor';
$txt['shd_status_5'] = 'Escalated - Urgent';
$txt['shd_status_6'] = 'Deleted';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'New Tickets';
$txt['shd_status_1_heading'] = 'Tickets Awaiting Staff Response';
$txt['shd_status_2_heading'] = 'Tickets Awaiting User Response';
$txt['shd_status_3_heading'] = 'Closed Tickets';
$txt['shd_status_4_heading'] = 'Tickets Referred to Supervisor';
$txt['shd_status_5_heading'] = 'Urgent Tickets';
$txt['shd_status_6_heading'] = 'Recycled Tickets';
$txt['shd_status_assigned_heading'] = 'Assigned to Me';
$txt['shd_status_withdeleted_heading'] = 'Tickets with Deleted Replies';
//@}

$txt['shd_tickets_open'] = 'Open Tickets';
$txt['shd_tickets_closed'] = 'Closed Tickets';
$txt['shd_tickets_recycled'] = 'Recycled Tickets';

$txt['shd_assigned'] = 'Assigned';
$txt['shd_unassigned'] = 'Unassigned';

$txt['shd_read_ticket'] = 'Read Ticket';
$txt['shd_unread_ticket'] = 'Unread Ticket';

$txt['shd_owned'] = 'Owned Ticket'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'ticket';
$txt['shd_count_tickets'] = 'tickets';

// Errors
$txt['cannot_access_helpdesk'] = 'You are not permitted to access the helpdesk.';
$txt['shd_no_ticket'] = 'The ticket you have requested does not appear to exist.';
$txt['shd_no_topic'] = 'The topic you have requested does not appaear to exist.';
$txt['shd_ticket_no_perms'] = 'You do not have permission to view that ticket.';
$txt['shd_error_no_tickets'] = 'No tickets were found.';
$txt['shd_inactive'] = 'The helpdesk is currently deactivated.';
$txt['shd_cannot_assign'] = 'You are not permitted to assign tickets.';
$txt['shd_cannot_assign_other'] = 'This ticket is already assigned to another user. You cannot reassign it to yourself - please contact the administrator.';
$txt['shd_no_staff_assign'] = 'There are no staff configured; it is not possible to assign a ticket. Please contact your administrator.';
$txt['shd_assigned_not_permitted'] = 'The user you have requested to assign this ticket to does not have sufficient permissions to see it.';
$txt['shd_cannot_resolve'] = 'You do not have permission to mark this ticket as resolved.';
$txt['shd_cannot_change_privacy'] = 'You do not have permission to alter the privacy on this ticket.';
$txt['shd_cannot_change_urgency'] = 'You do not have permission to alter the urgency on this ticket.';
$txt['shd_ajax_problem'] = 'There was a problem attempting to load the page. Would you like to try again?';
$txt['shd_cannot_move_ticket'] = 'You do not have permission to move this ticket to a topic.';
$txt['shd_cannot_move_topic'] = 'You do not have permission to move this topic to a ticket.';
$txt['shd_moveticket_noboards'] = 'There are no boards to move this ticket to!';
$txt['shd_move_no_pm'] = 'You must enter a reason for moving the ticket to send to the ticket owner, or uncheck the option to \'send a PM to the ticket owner\'.';
$txt['shd_move_no_pm_topic'] = 'You must enter a reason for moving the topic to send to the topic starter, or uncheck the option to \'send a PM to the topic starter\'.';
$txt['shd_move_topic_not_created'] = 'Failed to move the ticket to the board. Please try again.';
$txt['shd_move_ticket_not_created'] = 'Failed to move the topic to the helpdesk. Please try again.';
$txt['shd_no_replies'] = 'This ticket does not have any replies yet.';
$txt['cannot_shd_new_ticket'] = 'You do not have permission to create a new ticket.';
$txt['cannot_shd_edit_ticket'] = 'You do not have permission to edit this ticket.';
$txt['shd_cannot_reply_any'] = 'You do not have permission to reply to any tickets.';
$txt['shd_cannot_reply_any_but_own'] = 'You do not have permission to reply to any tickets other than your own.';
$txt['shd_cannot_edit_reply_any'] = 'You do not have permission to edit any replies.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'You do not have permission to edit replies to any tickets other than your own replies.';
$txt['shd_cannot_edit_closed'] = 'You cannot edit resolved tickets; you need to mark it unresolved first.';
$txt['shd_cannot_edit_deleted'] = 'You cannot edit tickets in the recycle bin. They will need to be restored first.';
$txt['shd_cannot_reply_closed'] = 'You cannot reply to resolved tickets; you need to mark them unresolved first.';
$txt['shd_cannot_reply_deleted'] = 'You cannot reply to tickets in the recycle bin. They will need to be restored first.';
$txt['shd_cannot_delete_ticket'] = 'You are not permitted to delete this ticket.';
$txt['shd_cannot_delete_reply'] = 'You are not permitted to delete that reply.';
$txt['shd_cannot_restore_ticket'] = 'You are not permitted to restore this ticket from the recycle bin.';
$txt['shd_cannot_restore_reply'] = 'You are not permitted to restore that reply from the recycle bin.';
$txt['shd_cannot_view_resolved'] = 'You are not permitted to access resolved tickets.';
$txt['cannot_shd_access_recyclebin'] = 'You cannot access the recycle bin.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'You cannot move this ticket to the forum; there are one or more deleted replies, which your current permissions do not permit access to.';
$txt['shd_cannot_attach_ext'] = 'The type of file you have tried to attach ({ext}) is not allowed here. The allowed types of file are: {attach_exts}';

// The main Helpdesk.
$txt['shd_home'] = 'Home';
$txt['shd_new_ticket'] = 'Post New Ticket';
$txt['shd_welcome'] = 'Welcome, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Go to ticket';

$txt['shd_user_greeting'] = 'Here you can file new tickets for the site staff to action, and check on current tickets already underway.';
$txt['shd_staff_greeting'] = 'Here are all the tickets that require attention.';
$txt['shd_shd_greeting'] = 'This is the Helpdesk. Here you waste your time to help newbies. Enjoy! ;D';
$txt['shd_closed_user_greeting'] = 'These are all the closed/resolved tickets you have posted to the helpdesk.';
$txt['shd_closed_staff_greeting'] = 'These are all closed/resolved tickets submitted to the helpdesk.';

// The main ticket view.
$txt['shd_ticket_details'] = 'Ticket details';
$txt['shd_ticket_updated'] = 'Updated';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Name';
$txt['shd_ticket_user'] = 'User';
$txt['shd_ticket_date'] = 'Posted';
$txt['shd_ticket_urgency'] = 'Urgency';
$txt['shd_ticket_assigned'] = 'Assigned';
$txt['shd_ticket_assignedto'] = 'Assigned to';
$txt['shd_ticket_started_by'] = 'Started by';
$txt['shd_ticket_updated_by'] = 'Updated by';
$txt['shd_ticket_status'] = 'Status';
$txt['shd_ticket_num_replies'] = 'Replies';
$txt['shd_ticket_replies'] = 'Replies';
$txt['shd_ticket_staff'] = 'Staff member';
$txt['shd_ticket_attachments'] = 'Attachments';
$txt['shd_ticket_reply_number'] = 'Reply <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket'] = 'Ticket';
$txt['shd_reply_written'] = 'Reply written %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Never';
$txt['shd_linktree_tickets'] = 'Tickets';
$txt['shd_ticket_privacy'] = 'Privacy';
$txt['shd_ticket_notprivate'] = 'Not Private';
$txt['shd_ticket_private'] = 'Private';
$txt['shd_ticket_change'] = 'Change';
$txt['shd_ticket_ip'] = 'IP address';
$txt['shd_back_to_hd'] = 'Back to the helpdesk';

$txt['shd_ticket_has_been_deleted'] = 'This ticket is currently in the recycle bin and cannot be altered without being returned to the helpdesk.';
$txt['shd_ticket_replies_deleted'] = 'This ticket has had replies deleted from it previously.';
$txt['shd_ticket_replies_deleted_view'] = 'These are displayed with a colored background. <a href="%1$s">View the ticket without deletions</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Please <a href="%1$s">click here</a> to view them.';

$txt['shd_ticket_notnew'] = 'You have already seen this';
$txt['shd_ticket_new'] = 'New!';

$txt['shd_linktree_move_ticket'] = 'Move ticket';
$txt['shd_linktree_move_topic'] = 'Move topic to helpdesk';

$txt['shd_cancel_ticket'] = 'Cancel and return to the ticket';
$txt['shd_cancel_home'] = 'Cancel and return to the helpdesk home';
$txt['shd_cancel_topic'] = 'Cancel and return to the topic';

// Actions
$txt['shd_ticket_reply'] = 'Reply to ticket';
$txt['shd_ticket_quote'] = 'Reply with quote';
$txt['shd_go_advanced'] = 'Go advanced!';
$txt['shd_ticket_edit_reply'] = 'Edit reply';
$txt['shd_ticket_quote_short'] = 'Quote';
$txt['shd_ticket_markunread'] = 'Mark as unread';
$txt['shd_ticket_reply_short'] = 'Reply';
$txt['shd_ticket_edit'] = 'Edit';
$txt['shd_ticket_resolved'] = 'Mark resolved';
$txt['shd_ticket_unresolved'] = 'Mark unresolved';
$txt['shd_ticket_assign'] = 'Assign';
$txt['shd_ticket_assign_self'] = 'Assign to me';
$txt['shd_ticket_reassign'] = 'Re-Assign';
$txt['shd_ticket_unassign'] = 'Un-Assign';
$txt['shd_ticket_delete'] = 'Delete';
$txt['shd_delete_confirm'] = 'Are you sure you want to delete this ticket? If deleted, this ticket will be moved to recycling bin.';
$txt['shd_delete_reply_confirm'] = 'Are you sure you want to delete this reply? If deleted, this reply will be moved to the recycling bin.';
$txt['shd_ticket_restore'] = 'Restore';
$txt['shd_delete_permanently'] = 'Delete permanently';
$txt['shd_delete_permanently_confirm'] = 'Are you sure you want to permanently delete this ticket? This CAN NOT be undone!';
$txt['shd_ticket_move_to_topic'] = 'Move to topic';
$txt['shd_actions'] = 'Actions';
$txt['shd_back_to_ticket'] = 'Return to this ticket after posting';
$txt['shd_disable_smileys_post'] = 'Turn off smileys in this post';

$txt['shd_ticket_assign_ticket'] = 'Assign Ticket';
$txt['shd_ticket_assign_to'] = 'Assign ticket to';

// Ticket to topic and back
$txt['shd_move_ticket_to_topic'] = 'Move ticket to topic';
$txt['shd_move_ticket'] = 'Move ticket';
$txt['shd_ticket_board'] = 'Board';
$txt['shd_move_send_pm'] = 'Send a PM to the ticket owner';
$txt['shd_move_why'] = 'Please enter a brief description as to
why this ticket is being moved to a forum topic. ';
$txt['shd_ticket_moved_subject'] = 'Your ticket has been moved.';
$txt['shd_move_default'] = 'Hello {user},

Your ticket, {subject}, has been moved from the helpdesk to a topic in the forum.
You can find your ticket in the board {board} or via this link:

{link}

Thanks';

$txt['shd_move_topic_to_ticket'] = 'Move topic to helpdesk';
$txt['shd_move_topic'] = 'Move topic';
$txt['shd_move_send_pm_topic'] = 'Send a PM to the topic starter';
$txt['shd_move_why_topic'] = 'Please enter a brief description as to
why this topic is being moved to the helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Your topic has been moved.';
$txt['shd_move_default_topic'] = 'Hello {user},

Your topic, {subject}, has been moved from the forum to the Helpdesk section.
You can find your topic via this link:

{link}

Thanks';

$txt['shd_ticket_move_deleted'] = 'This ticket has replies that are currently in the recycle bin. What do you wish to do?';
$txt['shd_ticket_move_deleted_abort'] = 'Abort, take me to the recycle bin';
$txt['shd_ticket_move_deleted_delete'] = 'Continue, abandon the deleted replies (do not move them into the new topic)';
$txt['shd_ticket_move_deleted_undelete'] = 'Continue, undelete the replies (move them into the new topic)';

// Recycling
$txt['shd_recycle_bin'] = 'Recycle Bin';
$txt['shd_recycle_greeting'] = 'This is the recycling bin. All deleted tickets go here, but staff members with special permissions can remove tickets permanently from here.';

// Posting
$txt['shd_create_ticket'] = 'Create ticket';
$txt['shd_edit_ticket'] = 'Edit ticket';
$txt['shd_edit_ticket_linktree'] = 'Edit ticket (%s)';
$txt['shd_ticket_subject'] = 'Ticket subject';
$txt['shd_ticket_post_error'] = 'The following issue, or issues, occurred while trying to post this ticket';
$txt['shd_reply_ticket'] = 'Reply to ticket';
$txt['shd_reply_ticket_linktree'] = 'Reply to ticket (%s)';
$txt['shd_edit_reply_linktree'] = 'Edit reply (%s)';
$txt['shd_previewing_ticket'] = 'Previewing ticket';
$txt['shd_previewing_reply'] = 'Previewing reply to';

// Profile / trackip
$txt['shd_replies_from_ip'] = 'Helpdesk replies posted from IP (range)';
$txt['shd_no_replies_from_ip'] = 'No helpdesk replies from the specified IP (range) found';
$txt['shd_replies_from_ip_desc'] = 'Below is a list of all messages posted to the helpdesk from this IP (range).';
$txt['shd_is_ticket_opener'] = ' (ticket starter)';

?>