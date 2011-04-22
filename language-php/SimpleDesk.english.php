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
$txt['shd_helpdesk_maintenance'] = 'The helpdesk is currently in <strong>maintenance mode</strong>. Only forum and helpdesk administrators can see this.';
$txt['shd_open_ticket'] = 'open ticket';
$txt['shd_open_tickets'] = 'open tickets';

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Welcome to the main helpdesk administration center!';
$txt['shd_admin_title'] = 'Helpdesk Administration Center';
$txt['shd_staff_list'] = 'Helpdesk staff';
$txt['shd_update_available'] = 'New version available!';
$txt['shd_update_message'] = 'A new version of SimpleDesk has been released. We recommened you to <a href="#" id="update-link">update to the latest version</a> in order to stay secure and enjoy all features our modification have to offer.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br />For more information on what is new in this release, please visit <a href="#" id="information-link" target="_blank">our website</a>.</span><br />' . "\n\n" . '<strong>The SimpleDesk Team</strong>';
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
$txt['shd_unread_tickets'] = 'Unread Tickets';

$txt['shd_owned'] = 'Owned Ticket'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'ticket';
$txt['shd_count_tickets'] = 'tickets';

// Errors
$txt['cannot_access_helpdesk'] = 'You are not permitted to access the helpdesk.';
$txt['shd_no_ticket'] = 'The ticket you have requested does not appear to exist.';
$txt['shd_no_reply'] = 'The ticket reply you have request does not appear to exist, or is not part of this ticket.';
$txt['shd_no_topic'] = 'The topic you have requested does not appear to exist.';
$txt['shd_ticket_no_perms'] = 'You do not have permission to view that ticket.';
$txt['shd_error_no_tickets'] = 'No tickets were found.';
$txt['shd_inactive'] = 'The helpdesk is currently deactivated.';
$txt['shd_cannot_assign'] = 'You are not permitted to assign tickets.';
$txt['shd_cannot_assign_other'] = 'This ticket is already assigned to another user. You cannot reassign it to yourself - please contact the administrator.';
$txt['shd_no_staff_assign'] = 'There are no staff configured; it is not possible to assign a ticket. Please contact your administrator.';
$txt['shd_assigned_not_permitted'] = 'The user you have requested to assign this ticket to does not have sufficient permissions to see it.';
$txt['shd_cannot_resolve'] = 'You do not have permission to mark this ticket as resolved.';
$txt['shd_cannot_unresolve'] = 'You do not have permission to reopen a resolved ticket.';
$txt['error_shd_cannot_resolve_children'] = 'This ticket cannot currently be closed; this ticket is the parent of one or more tickets that are currently open.';
$txt['error_shd_proxy_unknown'] = 'The user this ticket is posted on behalf of does not exist.';
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
$txt['shd_cannot_merge'] = 'You do not have permission to merge this ticket.';
$txt['shd_no_tickets_to_merge'] = 'There are no currently open tickets started by the same user; you cannot merge this ticket with any others at this time.';
$txt['cannot_shd_split_ticket_own'] = 'You are not permitted to split your own tickets.';
$txt['cannot_shd_split_ticket_any'] = 'You are not permitted to split any tickets.';
$txt['shd_split_no_title'] = 'You must specify a title for the newly split ticket.';
$txt['shd_split_invalid_type'] = 'That operation on splitting a ticket is not supported.';
$txt['shd_ticket_unavailable'] = 'This ticket is currently not available for modification.';
$txt['shd_invalid_relation'] = 'You must provide a valid type of relationship for these tickets.';
$txt['shd_no_relation_delete'] = 'You cannot delete a relationship that does not exist.';
$txt['shd_cannot_relate_self'] = 'You cannot make a ticket relate to itself.';
$txt['shd_split_no_pm'] = 'You must enter a reason for splitting the ticket to send to the ticket owner, or uncheck the option to \'send a PM to the ticket owner\'.';
$txt['shd_relationships_are_disabled'] = 'Ticket relationships are currently disabled.';
$txt['error_invalid_fields'] = 'The following fields have values that cannot be used: %1$s';
$txt['error_missing_fields'] = 'The following fields were not completed and need to be: %1$s';
$txt['shd_cannot_move_dept'] = 'You cannot move this ticket, there is nowhere to move it to.';
$txt['shd_no_perm_move_dept'] = 'You are not permitted to move this ticket to another department.';

// The main Helpdesk.
$txt['shd_home'] = 'Helpdesk'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Departments'; // ditto
$txt['shd_new_ticket'] = 'Post New Ticket';
$txt['shd_new_ticket_proxy'] = 'Post Proxy Ticket';
$txt['shd_helpdesk_profile'] = 'Helpdesk Profile';
$txt['shd_welcome'] = 'Welcome, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Go to ticket';
$txt['shd_options'] = 'Options';
// The strings that go into the menu...
$txt['shd_admin_info'] = 'Information';
$txt['shd_admin_options'] = 'Options';
$txt['shd_admin_custom_fields'] = 'Custom Fields';
$txt['shd_admin_departments'] = 'Departments';
$txt['shd_admin_permissions'] = 'Permissions';
$txt['shd_admin_plugins'] = 'Plugins';
$txt['shd_admin_maint'] = 'Maintenance';

$txt['shd_user_greeting'] = 'Here you can file new tickets for the site staff to action, and check on current tickets already underway.';
$txt['shd_staff_greeting'] = 'Here are all the tickets that require attention.';
$txt['shd_shd_greeting'] = 'This is the Helpdesk. Here you waste your time to help newbies. Enjoy! ;D';
$txt['shd_closed_user_greeting'] = 'These are all the closed/resolved tickets you have posted to the helpdesk.';
$txt['shd_closed_staff_greeting'] = 'These are all closed/resolved tickets submitted to the helpdesk.';

$txt['shd_ticket_posted_header'] = 'Your ticket has been created!';
$txt['shd_ticket_posted_body'] = 'Thank you for posting your ticket, {membername}!' . "\n\n" . 'The helpdesk staff will review it and get back to you as soon as possible.' . "\n\n" . 'In the meantime, you can view your ticket, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; at the following URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" .'[iurl={newticketlink}]Open another ticket[/iurl] | [iurl={helpdesklink}]Back to the main helpdesk[/iurl] | [iurl={forumlink}]Back to the forum[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'You can turn on email notifications about changes to your ticket, in the [iurl={prefslink}]Helpdesk Preferences[/iurl] area.';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Regards,' . "\n" . 'The {forum_name} Team.';

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
$txt['shd_ticket_markunread'] = 'Mark unread';
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
$txt['shd_move_dept'] = 'Move dept.';
$txt['shd_actions'] = 'Actions';
$txt['shd_back_to_ticket'] = 'Return to this ticket after posting';
$txt['shd_disable_smileys_post'] = 'Turn off smileys in this post';
$txt['shd_resolve_this_ticket'] = 'Mark this ticket as resolved';
$txt['shd_override_cf'] = 'Override the custom fields requirements';

$txt['shd_ticket_assign_ticket'] = 'Assign Ticket';
$txt['shd_ticket_assign_to'] = 'Assign ticket to';

$txt['shd_ticket_move_dept'] = 'Move Ticket to another Department';
$txt['shd_ticket_move_to'] = 'Move to';
$txt['shd_current_dept'] = 'Currently in department';
$txt['shd_ticket_move'] = 'Move Ticket';
$txt['shd_unknown_dept'] = 'The specified department does not exist.';

// Ticket to topic and back
$txt['shd_new_subject'] = 'New subject';
$txt['shd_move_ticket_to_topic'] = 'Move ticket to topic';
$txt['shd_move_ticket'] = 'Move ticket';
$txt['shd_ticket_board'] = 'Board';
$txt['shd_change_ticket_subject'] = 'Change the ticket subject';
$txt['shd_move_send_pm'] = 'Send a PM to the ticket owner';
$txt['shd_move_why'] = 'Please enter a brief description as to why this ticket is being moved to a forum topic.';
$txt['shd_ticket_moved_subject'] = 'Your ticket has been moved.';
$txt['shd_move_default'] = 'Hello {user},' . "\n\n" . 'Your ticket, {subject}, has been moved from the helpdesk to a topic in the forum.' . "\n" . 'You can find your ticket in the board {board} or via this link:' . "\n\n" . '{link}' . "\n\n" . 'Thanks';

$txt['shd_move_topic_to_ticket'] = 'Move topic to helpdesk';
$txt['shd_move_topic'] = 'Move topic';
$txt['shd_change_topic_subject'] = 'Change the topic subject';
$txt['shd_move_send_pm_topic'] = 'Send a PM to the topic starter';
$txt['shd_move_why_topic'] = 'Please enter a brief description as to why this topic is being moved to the helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Your topic has been moved.';
$txt['shd_move_default_topic'] = 'Hello {user},' . "\n\n" . 'Your topic, {subject}, has been moved from the forum to the Helpdesk section.' . "\n" . 'You can find your topic via this link:' . "\n\n" . '{link}' . "\n\n" . 'Thanks';

$txt['shd_user_no_hd_access'] = 'Note: the person who started this topic cannot see the helpdesk!';
$txt['shd_user_helpdesk_access'] = 'The person who started this topic can see the helpdesk.';
$txt['shd_user_hd_access_dept_1'] = 'The person who started this topic can see the following department: ';
$txt['shd_user_hd_access_dept'] = 'The person who started this topic can see the following departments: ';
$txt['shd_move_ticket_department'] = 'Move ticket to which department';
$txt['shd_move_dept_why'] = 'Please enter a brief description as to why this ticket is being moved to a different department.';
$txt['shd_move_dept_default'] = 'Hello {user},' . "\n\n" . 'Your ticket, {subject}, has been moved from the {current_dept} department into the {new_dept} department.' . "\n" . 'You can find your ticket via this link:' . "\n\n" . '{link}' . "\n\n" . 'Thanks';

$txt['shd_ticket_move_deleted'] = 'This ticket has replies that are currently in the recycle bin. What do you wish to do?';
$txt['shd_ticket_move_deleted_abort'] = 'Abort, take me to the recycle bin';
$txt['shd_ticket_move_deleted_delete'] = 'Continue, abandon the deleted replies (do not move them into the new topic)';
$txt['shd_ticket_move_deleted_undelete'] = 'Continue, undelete the replies (move them into the new topic)';

// Merge ticket
$txt['shd_merge_ticket'] = 'Merge ticket';
$txt['shd_ticket_to_merge'] = 'Ticket to merge';
$txt['shd_ticket_merge_tickets'] = 'Merge Tickets';
$txt['shd_merge_send_pm'] = 'Send a PM to the ticket starter';
$txt['shd_merge_why'] = 'Please enter a brief description as to why this ticket has been merged with another.';
$txt['shd_merge_default_msg'] = 'Hello {user},' . "\n\n" . 'Your tickets, {source} and {destination}, have been merged together to form a single ticket.' . "\n\n" . 'You can find your ticket here:' . "\n" . '{link}' . "\n\n" . 'Thanks';

// Split ticket
$txt['shd_ticket_split_ticket'] = 'Split';
$txt['shd_split_ticket'] = 'Split Ticket';
$txt['shd_split_new_subject'] = 'Subject for newly split ticket';
$txt['shd_split_type'] = 'What replies should make up the new ticket?';
$txt['shd_split_only_this'] = 'The new ticket should only have this reply';
$txt['shd_split_after_this'] = 'The new ticket should contain all replies from this message forward';
$txt['shd_split_done'] = 'The ticket has been split into two tickets.';
$txt['shd_split_origin_ticket'] = 'Go back to the original ticket';
$txt['shd_split_new_ticket'] = 'Go to the new ticket';
$txt['shd_split_send_pm'] = 'Send a PM to the ticket starter';
$txt['shd_split_why'] = 'Please enter a brief description as to why this ticket has been split into two.';
$txt['shd_split_why_note'] = 'It is possible the ticket starter will not be able to see the split ticket, depending on how the split is done.';
$txt['shd_ticket_split_subject'] = 'Your ticket has been split.';
$txt['shd_split_default_msg'] = 'Hello {user},' . "\n\n" . 'Your ticket, {source}, has been split into another ticket.' . "\n" . 'You can find your original ticket here:' . "\n\n" . '{link}' . "\n\n" . 'The new ticket is:' . "\n" . '{splitlink}' . "\n\n" . 'Thanks';

// Recycling
$txt['shd_recycle_bin'] = 'Recycle Bin';
$txt['shd_recycle_greeting'] = 'This is the recycling bin. All deleted tickets go here, but staff members with special permissions can remove tickets permanently from here.';

// Posting
$txt['shd_create_ticket'] = 'Create ticket';
$txt['shd_edit_ticket'] = 'Edit ticket';
$txt['shd_edit_ticket_linktree'] = 'Edit ticket (%s)';
$txt['shd_ticket_subject'] = 'Ticket subject';
$txt['shd_ticket_proxy'] = 'Post on behalf of';
$txt['shd_ticket_post_error'] = 'The following issue, or issues, occurred while trying to post this ticket';
$txt['shd_reply_ticket'] = 'Reply to ticket';
$txt['shd_reply_ticket_linktree'] = 'Reply to ticket (%s)';
$txt['shd_edit_reply_linktree'] = 'Edit reply (%s)';
$txt['shd_previewing_ticket'] = 'Previewing ticket';
$txt['shd_previewing_reply'] = 'Previewing reply to';
$txt['shd_choose_one'] = '[Choose one]';
$txt['shd_no_value'] = '[no value]';
$txt['shd_ticket_dept'] = 'Ticket department';

// Profile / trackip
$txt['shd_replies_from_ip'] = 'Helpdesk replies posted from IP (range)';
$txt['shd_no_replies_from_ip'] = 'No helpdesk replies from the specified IP (range) found';
$txt['shd_replies_from_ip_desc'] = 'Below is a list of all messages posted to the helpdesk from this IP (range).';
$txt['shd_is_ticket_opener'] = ' (ticket starter)';


// Attachment types
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2 archive';
$txt['shd_attachtype_gz'] = 'GZip archive';
$txt['shd_attachtype_rar'] = 'Rar/WinRAR archive';
$txt['shd_attachtype_zip'] = 'Zip archive';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) audio file';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windows Bitmap image';
$txt['shd_attachtype_gif'] = 'Graphics Interchange Format (GIF) image';
$txt['shd_attachtype_jpeg'] = 'Joint Photographic Experts Group (JPEG) image';
$txt['shd_attachtype_jpg'] = 'Joint Photographic Experts Group (JPEG) image';
$txt['shd_attachtype_png'] = 'Portable Network Graphic (PNG) image';
$txt['shd_attachtype_svg'] = 'Scalable Vector Graphic (SVG) image';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Video movie';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Word document';
$txt['shd_attachtype_mdb'] = 'Microsoft Access database';
$txt['shd_attachtype_ppt'] = 'Microsoft Powerpoint presentation';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ source file';
$txt['shd_attachtype_php'] = 'PHP script';
$txt['shd_attachtype_py'] = 'Python source file';
$txt['shd_attachtype_rb'] = 'Ruby source file';
$txt['shd_attachtype_sql'] = 'SQL script';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KML archive)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Portable Document File';
$txt['shd_attachtype_psd'] = 'Adobe Photoshop document';
$txt['shd_attachtype_swf'] = 'Adobe Flash file';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Executable file (Windows)';
$txt['shd_attachtype_htm'] = 'Hypertext Markup Document (HTML)';
$txt['shd_attachtype_html'] = 'Hypertext Markup Document (HTML)';
$txt['shd_attachtype_rtf'] = 'Rich Text Format (RTF)';
$txt['shd_attachtype_txt'] = 'Plain text';

// Ticket logs.
$txt['shd_ticket_log'] = 'Ticket action log';
$txt['shd_ticket_log_count_one'] = '1 entry';
$txt['shd_ticket_log_count_more'] = '%s entries';
$txt['shd_ticket_log_none'] = 'This ticket has not had any changes.';
$txt['shd_ticket_log_member'] = 'Member';
$txt['shd_ticket_log_ip'] = 'Member IP:';
$txt['shd_ticket_log_date'] = 'Date';
$txt['shd_ticket_log_action'] = 'Action';
$txt['shd_ticket_log_full'] = 'Go to the full action log (All tickets)';

// Ticket relationships
$txt['shd_ticket_relationships'] = 'Related Tickets';
$txt['shd_ticket_create_relationship'] = 'Create relationship';
$txt['shd_ticket_delete_relationship'] = 'Delete relationship';
$txt['shd_ticket_reltype'] = 'select type';
$txt['shd_ticket_reltype_linked'] = 'Linked to';
$txt['shd_ticket_reltype_duplicated'] = 'Duplicate of';
$txt['shd_ticket_reltype_parent'] = 'Parent of';
$txt['shd_ticket_reltype_child'] = 'Child of';

// Custom fields in ticket
$txt['shd_ticket_additional_information'] = 'Additional information';
$txt['shd_ticket_additional_details'] = 'Additional details';
$txt['shd_ticket_empty_field'] = 'This field is empty.';
$txt['shd_ticket_empty_field_short'] = '-';
?>