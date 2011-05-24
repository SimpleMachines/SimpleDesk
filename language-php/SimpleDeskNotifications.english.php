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
# SimpleDesk Version: 2.0 Anatidae                                #
# File Info: SimpleDeskNotifications.english.php / 2.0 Anatidae   #
###################################################################
// Version: 2.0 Anatidae; SimpleDesk main language file

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	This file contains all of the email notifications texts.
 *
 *	@package language
 *	@todo Document the text groups in this file.
 *	@since 2.0
*/

// Email subject and body contents
$txt['template_subject_notify_new_ticket'] = 'New helpdesk ticket: {subject}';
$txt['template_body_notify_new_ticket'] = 'A new helpdesk ticket, "{subject}", has been created.' . "\n\n" . 'You can access it here:' . "\n" . '{ticketlink}';
$txt['template_log_notify_new_ticket'] = 'New ticket';

$txt['template_subject_notify_new_reply_own'] = 'Your helpdesk ticket updated: {subject}';
$txt['template_body_notify_new_reply_own'] = 'Your ticket, "{subject}", has been replied to.' . "\n\n" . 'You can read the reply here:' . "\n" . '{ticketlink}';
$txt['template_log_notify_new_reply_own'] = 'User updated';

$txt['template_subject_notify_new_reply_assigned'] = 'Helpdesk - assigned ticket updated: {subject}';
$txt['template_body_notify_new_reply_assigned'] = 'A ticket assigned to you, "{subject}", has been replied to.' . "\n\n" . 'You can read the reply here:' . "\n" . '{ticketlink}';
$txt['template_log_notify_new_reply_assigned'] = 'Assigned ticket updated';

$txt['template_subject_notify_new_reply_previous'] = 'Helpdesk ticket updated: {subject}';
$txt['template_body_notify_new_reply_previous'] = 'A ticket you previously replied to, "{subject}", has been replied to again.' . "\n\n" . 'You can read the reply here:' . "\n" . '{ticketlink}';
$txt['template_log_notify_new_reply_previous'] = 'Another reply';

$txt['template_subject_notify_new_reply_any'] = 'Helpdesk ticket - new reply: {subject}';
$txt['template_body_notify_new_reply_any'] = 'A helpdesk ticket, "{subject}", has been replied to.' . "\n\n" . 'You can read the reply here:' . "\n" . '{ticketlink}';
$txt['template_log_notify_new_reply_any'] = 'New reply';

$txt['template_subject_notify_assign_me'] = 'Helpdesk ticket assigned: {subject}';
$txt['template_body_notify_assign_me'] = 'The helpdesk ticket, "{subject}", has been assigned to you.' . "\n\n" . 'You can access it here:' . "\n" . '{ticketlink}';
$txt['template_log_notify_assign_me'] = 'Assigned to';

$txt['template_subject_notify_assign_own'] = 'Helpdesk ticket assigned: {subject}';
$txt['template_body_notify_assign_own'] = 'Your helpdesk ticket, "{subject}", has been assigned to a member of staff to be dealt with.' . "\n\n" . 'You can access your ticket here:' . "\n" . '{ticketlink}';
$txt['template_log_notify_assign_own'] = 'Assigned to staff';

?>