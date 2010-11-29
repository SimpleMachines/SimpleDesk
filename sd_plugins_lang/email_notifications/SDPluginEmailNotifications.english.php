<?php
###################################################################
#           Simple Desk Project - www.simpledesk.net              #
#                  Email Notifications Plugin                     #
###################################################################
#         An advanced help desk modifcation built on SMF          #
###################################################################
#                                                                 #
#           * Copyright 2010 - SimpleDesk.net                     #
#                                                                 #
#     This file and its contents are subject to the license       #
#     included with this distribution, license.txt, which         #
#     states that this software is New BSD Licensed.              #
#     Any questions, please contact SimpleDesk.net                #
#                                                                 #
###################################################################
# SimpleDesk Version: 1.0 Felidae                                 #
# File Info: SDPluginEmailNotifications.english.php / 1.0 Felidae #
###################################################################
// Version: 1.0 Felidae; SimpleDesk main language file

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	@package plugin-emailnotifications
 *	@since 1.1
*/

$txt['email_notifications'] = 'Email Notifications';
$txt['email_notifications_desc'] = 'This plugin allows the helpdesk to notify users when tickets are updated.';

$txt['shd_admin_options_notifications'] = 'Notifications';
$txt['shd_admin_options_notifications_desc'] = 'This area allows you to configure email notifications being sent to users when their tickets change.';

// Admin panel options
$txt['shd_notify_log'] = 'Log notifications being sent (what notification, when sent, user(s) involved)';
$txt['shd_notify_new_ticket'] = 'Allow staff to receive notifications on new tickets';
$txt['shd_notify_new_reply_own'] = 'Allow users to receive notifications when their tickets are replied to';
$txt['shd_notify_new_reply_assigned'] = 'Allow staff to receive notifications when tickets assigned to them are replied to';
$txt['shd_notify_new_reply_previous'] = 'Allow staff to receive notifications when tickets they have replied to, are replied to again';
$txt['shd_notify_new_reply_any'] = 'Allow staff to receive notifications when any tickets are replied to';
$txt['shd_notify_assign_me'] = 'Allow staff to receive notifications when a ticket is assigned to them';
$txt['shd_notify_assign_own'] = 'Allow users to receive notifications when their tickets are assigned to staff';

// User preferences
$txt['shd_pref_group_notify'] = 'Notifications By Email';
$txt['shd_pref_notify_new_ticket'] = 'Email me when a new ticket is posted';
$txt['shd_pref_notify_new_reply_own'] = 'Email me when one of my tickets is replied to';
$txt['shd_pref_notify_new_reply_assigned'] = 'Email me when a ticket assigned to me is replied to';
$txt['shd_pref_notify_new_reply_previous'] = 'Email me when a ticket I\'ve replied to before is replied to again';
$txt['shd_pref_notify_new_reply_any'] = 'Email me when any ticket is replied to';
$txt['shd_pref_notify_assign_me'] = 'Email me when a ticket is assigned to me';
$txt['shd_pref_notify_assign_own'] = 'Email me when one of my tickets is assigned to staff';

$txt['shd_notify_send_to'] = 'Will be sent to';
$txt['shd_notify_ticket_starter'] = 'the user who started the ticket (if set in their preferences)';
$txt['shd_notify_nobody'] = 'nobody';

// Email subject and body contents
$txt['template_subject_notify_new_ticket'] = 'New helpdesk ticket: {subject}';
$txt['template_body_notify_new_ticket'] = 'A new helpdesk ticket, "{subject}", has been created.' . "\n\n" . 'You can access it here:' . "\n" . '{ticketlink}';

$txt['template_subject_notify_new_reply_own'] = 'Your helpdesk ticket updated: {subject}';
$txt['template_body_notify_new_reply_own'] = 'Your ticket, "{subject}", has been replied to.' . "\n\n" . 'You can read the reply here:' . "\n" . '{ticketlink}';

$txt['template_subject_notify_new_reply_assigned'] = 'Helpdesk - assigned ticket updated: {subject}';
$txt['template_body_notify_new_reply_assigned'] = 'A ticket assigned to you, "{subject}", has been replied to.' . "\n\n" . 'You can read the reply here:' . "\n" . '{ticketlink}';

$txt['template_subject_notify_new_reply_previous'] = 'Helpdesk ticket updated: {subject}';
$txt['template_body_notify_new_reply_previous'] = 'A ticket you previously replied to, "{subject}", has been replied to again.' . "\n\n" . 'You can read the reply here:' . "\n" . '{ticketlink}';

$txt['template_subject_notify_new_reply_any'] = 'Helpdesk ticket - new reply: {subject}';
$txt['template_body_notify_new_reply_any'] = 'A helpdesk ticket, "{subject}", has been replied to.' . "\n\n" . 'You can read the reply here:' . "\n" . '{ticketlink}';

$txt['template_subject_notify_assign_me'] = 'Helpdesk ticket assigned: {subject}';
$txt['template_body_notify_assign_me'] = 'The helpdesk ticket, "{subject}", has been assigned to you.' . "\n\n" . 'You can access it here:' . "\n" . '{ticketlink}';

$txt['template_subject_notify_assign_own'] = 'Helpdesk ticket assigned: {subject}';
$txt['template_body_notify_assign_own'] = 'Your helpdesk ticket, "{subject}", has been assigned to a member of staff to be dealt with.' . "\n\n" . 'You can access your ticket here:' . "\n" . '{ticketlink}';

?>