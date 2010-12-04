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
# File Info: SimpleDesk-LogAction.english.php / 1.0 Felidae   #
###############################################################
// Version: 1.0 Felidae; SimpleDesk action log

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	This file contains all of the base language strings used by the helpdesk action log.
 *	Unlike other language files, many of the strings here are parameterised, enabling them to be extended in the future.
 *	@see shd_log_action()
 *
 *	@package language
 *	@todo Document the text groups in this file.
 *	@since 1.0
 */

//! @name General strings
//@{
$txt['shd_action_log_disabled'] = '<strong>Note:</strong> Logging of actions is currently <strong>disabled</strong>, so no new log entries will be added.';
//@}

//! @name Ticket resolution
//@{
$txt['shd_log_resolve'] = '<a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a> marked as <strong>resolved</strong>.';
$txt['shd_log_unresolve'] = '<a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a> marked as <strong>not yet resolved</strong>.';
//@}

//! @name Ticket assignation
//@{
$txt['shd_log_assign'] = 'Assigned <a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a> to {profile_link}';
$txt['shd_log_unassign'] = 'Assigned <a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a> to no-one';
//@}

//! @name Ticket privacy
//@{
$txt['shd_log_markprivate'] = '<a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a> marked as <strong>private</strong>.';
$txt['shd_log_marknotprivate'] = '<a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a> marked as <strong>not private</strong>.';
//@}

//! @name Ticket urgency
//@{
$txt['shd_log_urgency_increase'] = '<a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a> increased to <strong>{urgency}</strong>.';
$txt['shd_log_urgency_decrease'] = '<a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a> decreased to <strong>{urgency}</strong>.';
//@}

//! @name Ticket/topic, topic/ticket moves
//@{
$txt['shd_log_tickettotopic'] = 'Moved <a href="{scripturl}?topic={ticket}.0">{subject}</a> to <strong><a href="{scripturl}?board={board_id}.0">{board_name}</a></strong> in the forum';
$txt['shd_log_topictoticket'] = 'Moved the topic <strong><a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a></strong> from the forum to the helpdesk.';
//@}

//! @name Ticket deletion, restoration, permadeletion
//@{
$txt['shd_log_delete'] = 'Deleted <a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}.0">{subject}</a> to recycle bin.';
$txt['shd_log_restore'] = 'Restored <a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}.0">{subject}</a> from recycle bin.';
$txt['shd_log_permadelete'] = '<strong>Permanently</strong> deleted "{subject}" (ticket {ticket}).';
$txt['shd_log_delete_reply'] = 'Deleted reply in <a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}.msg{msg}#msg{msg};recycle">{subject}</a> to recycle bin.';
$txt['shd_log_restore_reply'] = 'Restored reply in <a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}.msg{msg}#msg{msg}">{subject}</a> from recycle bin.';
$txt['shd_log_permadelete_reply'] = '<strong>Permanently</strong> deleted a reply from <a href="{scripturl}?action=helpdesk;sa=ticket;ticket={ticket}">{subject}</a>.';
//@}

?>