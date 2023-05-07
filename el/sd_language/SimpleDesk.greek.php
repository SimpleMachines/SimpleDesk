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
* File Info: SimpleDesk.english.php                           *
**************************************************************/
// Version: 2.1; SimpleDesk main language file

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	This file contains all of the principle language strings used by SimpleDesk and are loaded on every page.
 *
 *	@package language
 *	@todo Document the text groups in this file.
 *	@since 1.0
 */

//! @name General Strings
//@{
$txt['shd_helpdesk'] = 'Γραφείο Βοήθειας';
$txt['shd_helpdesk_maintenance'] = 'Το helpdesk βρίσκεται σε <strong>λειτουργία συντήρησης</strong>. Μόνο το forum και οι διαχειριστές του helpdesk μπορούν να το δουν αυτό.';
$txt['shd_open_ticket'] = 'άνοιγμα παραγγελίας';
$txt['shd_open_tickets'] = 'άνοιγμα παραγγελιών';
$txt['shd_none'] = 'Κανένα';

$txt['shd_display_nojs'] = 'Η JavaScript δεν είναι ενεργοποιημένη στο πρόγραμμα περιήγησης. Ορισμένες λειτουργίες ενδέχεται να μην λειτουργούν σωστά (ή καθόλου) ή να συμπεριφέρονται με απροσδόκητο τρόπο.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Καλώς ήλθατε στο κύριο κέντρο διαχείρισης του helpdesk!';
$txt['shd_admin_title'] = 'Κέντρο Διαχείρισης Helpdesk';
$txt['shd_staff_list'] = 'Προσωπικό γραφείου βοήθειας';
$txt['shd_update_available'] = 'Νέα έκδοση διαθέσιμη!';
$txt['shd_update_message'] = 'Μια νέα έκδοση του SimpleDesk έχει κυκλοφορήσει. Σας συνιστούμε να <a href="#" id="update-link">αναβαθμίσετε στην τελευταία έκδοση</a> για να μείνετε ασφαλείς και να απολαύσετε όλες τις δυνατότητες που έχει να προσφέρει η τροποποίηση μας.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Για περισσότερες πληροφορίες σχετικά με το τι είναι νέο σε αυτήν την έκδοση, παρακαλώ επισκεφθείτε <a href="#" id="information-link" target="_blank">την ιστοσελίδα μας</a>.</span><br>' . "\n\n" . '<strong>Η ομάδα SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Χαμηλή';
$txt['shd_urgency_1'] = 'Μεσαίο';
$txt['shd_urgency_2'] = 'Υψηλή';
$txt['shd_urgency_3'] = 'Πολύ Υψηλή';
$txt['shd_urgency_4'] = 'Σοβαρή';
$txt['shd_urgency_5'] = 'Κρίσιμο';
$txt['shd_urgency_increase'] = 'Αύξηση';
$txt['shd_urgency_decrease'] = 'Μείωση';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Νέο';
$txt['shd_status_1'] = 'Σχόλιο Σε Εκκρεμότητα Προσωπικού';
$txt['shd_status_2'] = 'Σχόλιο Σε Εκκρεμότητα Χρήστη';
$txt['shd_status_3'] = 'Επιλυμένο/κλειστό';
$txt['shd_status_4'] = 'Αναφέρεται στον Επόπτη';
$txt['shd_status_5'] = 'Κλιμακωμένο - Επείγον';
$txt['shd_status_6'] = 'Διαγράφηκε';
$txt['shd_status_7'] = 'Σε Αναμονή';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Νέα Εισιτήρια';
$txt['shd_status_1_heading'] = 'Εισιτήρια Αναμονή Απόκρισης Προσωπικού';
$txt['shd_status_2_heading'] = 'Εισιτήρια Σε Αναμονή Απόκρισης Χρήστη';
$txt['shd_status_3_heading'] = 'Κλειστά Εισιτήρια';
$txt['shd_status_4_heading'] = 'Εισιτήρια Αναφέρονται σε Επόπτη';
$txt['shd_status_5_heading'] = 'Επείγοντα Εισιτήρια';
$txt['shd_status_6_heading'] = 'Ανακυκλωμένα Εισιτήρια';
$txt['shd_status_7_heading'] = 'Σε Αναμονή Εισιτήρια';
$txt['shd_status_assigned_heading'] = 'Ανατέθηκε σε εμένα';
$txt['shd_status_withdeleted_heading'] = 'Εισιτήρια με Διαγραμμένες Απαντήσεις';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Ανοιχτά Εισιτήρια';
$txt['shd_tickets_closed'] = 'Κλειστά Εισιτήρια';
$txt['shd_tickets_recycled'] = 'Ανακυκλωμένα Εισιτήρια';

$txt['shd_assigned'] = 'Ανατεθειμένο';
$txt['shd_unassigned'] = 'Ανεκχώρησε';

$txt['shd_read_ticket'] = 'Αίτημα Ανάγνωσης';
$txt['shd_unread_ticket'] = 'Μη Αναγνωσμένο Αίτημα Υποστήριξης';
$txt['shd_unread_tickets'] = 'Αδιάβαστα Εισιτήρια';

$txt['shd_owned'] = 'Αίτημα Υποστήριξης'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'εισιτήριο';
$txt['shd_count_tickets'] = 'εισιτήρια';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Δεν σας επιτρέπεται να έχετε πρόσβαση στο helpdesk.';
$txt['shd_no_ticket'] = 'Το αίτημα που ζητήσατε δεν φαίνεται να υπάρχει.';
$txt['shd_no_reply'] = 'Η απάντηση του αιτήματος που έχετε δεν φαίνεται να υπάρχει, ή δεν αποτελεί μέρος αυτού του εισιτηρίου.';
$txt['shd_no_topic'] = 'Το θέμα που ζητήσατε δεν φαίνεται να υπάρχει.';
$txt['shd_ticket_no_perms'] = 'Δεν έχετε δικαίωμα να δείτε αυτό το εισιτήριο.';
$txt['shd_error_no_tickets'] = 'Δεν βρέθηκαν εισιτήρια.';
$txt['shd_inactive'] = 'Το helpdesk απενεργοποιείται αυτή τη στιγμή.';
$txt['shd_cannot_assign'] = 'Δεν επιτρέπεται να εκχωρήσετε εισιτήρια.';
$txt['shd_cannot_assign_other'] = 'Αυτό το αίτημα έχει ήδη ανατεθεί σε άλλο χρήστη. Δεν μπορείτε να το εκχωρήσετε ξανά στον εαυτό σας - παρακαλούμε επικοινωνήστε με το διαχειριστή.';
$txt['shd_no_staff_assign'] = 'Δεν υπάρχει καθορισμένο προσωπικό. Δεν είναι δυνατή η εκχώρηση μιας αίτησης. Παρακαλώ επικοινωνήστε με το διαχειριστή.';
$txt['shd_assigned_not_permitted'] = 'Ο χρήστης που ζητήσατε να εκχωρήσει αυτό το αίτημα δεν έχει επαρκή δικαιώματα για να το δει.';
$txt['shd_cannot_resolve'] = 'Δεν έχετε δικαίωμα να επισημάνετε αυτό το αίτημα ως επιλυμένο.';
$txt['shd_cannot_unresolve'] = 'Δεν έχετε άδεια να ανοίξετε εκ νέου ένα επιλυμένο εισιτήριο.';
$txt['error_shd_cannot_resolve_children'] = 'Αυτό το εισιτήριο δεν μπορεί να κλείσει αυτή τη στιγμή. Αυτό το εισιτήριο είναι ο γονέας ενός ή περισσότερων εισιτηρίων που είναι ανοικτά επί του παρόντος.';
$txt['error_shd_proxy_unknown'] = 'Ο χρήστης που αυτό το αίτημα δημοσιεύεται εκ μέρους του δεν υπάρχει.';
$txt['shd_cannot_change_privacy'] = 'Δεν έχετε άδεια να αλλάξετε το απόρρητο σε αυτό το εισιτήριο.';
$txt['shd_cannot_change_urgency'] = 'Δεν έχετε άδεια να αλλάξετε τον επείγοντα χαρακτήρα σε αυτό το εισιτήριο.';
$txt['shd_ajax_problem'] = 'Υπήρξε ένα πρόβλημα κατά την προσπάθεια φόρτωσης της σελίδας. Θα θέλατε να δοκιμάσετε ξανά?';
$txt['shd_cannot_move_ticket'] = 'Δεν έχετε άδεια να μετακινήσετε αυτό το αίτημα σε ένα θέμα.';
$txt['shd_cannot_move_topic'] = 'Δεν έχετε άδεια να μετακινήσετε αυτό το θέμα σε ένα εισιτήριο.';
$txt['shd_moveticket_noboards'] = 'Δεν υπάρχουν πίνακες για να μετακινήσετε αυτό το αίτημα στο!';
$txt['shd_move_no_pm'] = 'Θα πρέπει να εισάγετε έναν λόγο για να μετακινήσετε το εισιτήριο για να στείλετε στον ιδιοκτήτη του εισιτηρίου, ή αποεπιλέξτε την επιλογή να «στείλετε ένα PM στον ιδιοκτήτη του αιτήματος».';
$txt['shd_move_no_pm_topic'] = 'Πρέπει να εισάγετε έναν λόγο για να μετακινήσετε το θέμα για να στείλετε στο θέμα εκκίνησης, or uncheck the option to \'send a PM to the topic starter\'.';
$txt['shd_move_topic_not_created'] = 'Απέτυχε η μετακίνηση του αιτήματος υποστήριξης στο ταμπλό. Παρακαλώ δοκιμάστε ξανά.';
$txt['shd_move_ticket_not_created'] = 'Αποτυχία μετακίνησης του θέματος στο helpdesk. Παρακαλώ προσπαθήστε ξανά.';
$txt['shd_no_replies'] = 'Αυτό το αίτημα δεν έχει ακόμα απαντήσεις.';
$txt['cannot_shd_new_ticket'] = 'Δεν έχετε άδεια για να δημιουργήσετε ένα νέο εισιτήριο.';
$txt['cannot_shd_edit_ticket'] = 'Δεν έχετε δικαίωμα να επεξεργαστείτε αυτήν την αίτηση.';
$txt['shd_cannot_reply_any'] = 'Δεν έχετε άδεια να απαντήσετε σε οποιοδήποτε εισιτήριο.';
$txt['shd_cannot_reply_any_but_own'] = 'Δεν έχετε άδεια να απαντήσετε σε άλλα εισιτήρια εκτός από τα δικά σας.';
$txt['shd_cannot_edit_reply_any'] = 'Δεν έχετε δικαίωμα να επεξεργαστείτε καμία απάντηση.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Δεν έχετε άδεια να επεξεργαστείτε απαντήσεις σε άλλα αιτήματα εκτός από τις δικές σας απαντήσεις.';
$txt['shd_cannot_edit_closed'] = 'Δεν μπορείτε να επεξεργαστείτε διευθετημένα εισιτήρια. Πρέπει να τα επισημάνετε πρώτα ανεπίλυτα.';
$txt['shd_cannot_edit_deleted'] = 'Δεν μπορείτε να επεξεργαστείτε εισιτήρια στον κάδο ανακύκλωσης. Θα πρέπει πρώτα να αποκατασταθούν.';
$txt['shd_cannot_reply_closed'] = 'Δεν μπορείτε να απαντήσετε σε διευθετημένα εισιτήρια, πρέπει πρώτα να τα επισημάνετε άλυτα.';
$txt['shd_cannot_reply_deleted'] = 'Δεν μπορείτε να απαντήσετε σε εισιτήρια στον κάδο ανακύκλωσης. Θα πρέπει πρώτα να αποκατασταθούν.';
$txt['shd_cannot_delete_ticket'] = 'Δεν σας επιτρέπεται να διαγράψετε αυτό το αίτημα.';
$txt['shd_cannot_delete_reply'] = 'Δεν επιτρέπεται να διαγράψετε αυτήν την απάντηση.';
$txt['shd_cannot_restore_ticket'] = 'Δεν σας επιτρέπεται να επαναφέρετε αυτό το αίτημα από τον κάδο ανακύκλωσης.';
$txt['shd_cannot_restore_reply'] = 'Δεν σας επιτρέπεται να επαναφέρετε αυτή την απάντηση από τον κάδο ανακύκλωσης.';
$txt['shd_cannot_view_resolved'] = 'Δεν σας επιτρέπεται η πρόσβαση σε επιλυμένα εισιτήρια.';
$txt['cannot_shd_access_recyclebin'] = 'Δεν μπορείτε να αποκτήσετε πρόσβαση στον κάδο ανακύκλωσης.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Δεν μπορείτε να μετακινήσετε αυτό το αίτημα στο φόρουμ. Υπάρχουν μία ή περισσότερες διαγραμμένες απαντήσεις, στις οποίες τα τρέχοντα δικαιώματά σας δεν επιτρέπουν την πρόσβαση.';
$txt['shd_cannot_attach_ext'] = 'Ο τύπος αρχείου που προσπαθήσατε να επισυνάψετε ({ext}) δεν επιτρέπεται εδώ. Οι επιτρεπόμενοι τύποι αρχείων είναι: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Αυτό το εισιτήριο δεν είναι προς το παρόν διαθέσιμο για τροποποίηση.';
$txt['shd_invalid_relation'] = 'Πρέπει να δώσετε έναν έγκυρο τύπο σχέσης για αυτά τα εισιτήρια.';
$txt['shd_no_relation_delete'] = 'Δεν μπορείτε να διαγράψετε μια σχέση που δεν υπάρχει.';
$txt['shd_cannot_relate_self'] = 'Δεν μπορείτε να κάνετε εισιτήριο να σχετίζεται με τον εαυτό του.';
$txt['shd_relationships_are_disabled'] = 'Οι σχέσεις εισιτηρίων είναι προς το παρόν απενεργοποιημένες.';
$txt['error_invalid_fields'] = 'Τα ακόλουθα πεδία έχουν τιμές που δεν μπορούν να χρησιμοποιηθούν: %1$s';
$txt['error_missing_fields'] = 'Τα ακόλουθα πεδία δεν συμπληρώθηκαν και πρέπει να είναι: %1$s';
$txt['error_missing_multi'] = '%1$s (τουλάχιστον %2$d πρέπει να επιλεγεί)';
$txt['error_no_dept'] = 'Δεν επιλέξατε ένα τμήμα για να δημοσιεύσετε αυτό το αίτημα στο.';
$txt['shd_cannot_move_dept'] = 'Δεν μπορείτε να μετακινήσετε αυτό το εισιτήριο, δεν υπάρχει πουθενά για να το μετακινήσετε.';
$txt['shd_no_perm_move_dept'] = 'Δεν σας επιτρέπεται να μετακινήσετε αυτό το αίτημα σε άλλο τμήμα.';
$txt['cannot_shd_delete_attachment'] = 'Δεν σας επιτρέπεται να διαγράψετε συνημμένα.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Δεν μπορείτε να μετακινήσετε αυτό το αίτημα σε ένα θέμα. Υπάρχουν προσαρμοσμένα πεδία που απαιτούν από τον διαχειριστή να επιβεβαιώσει την κίνηση.';
$txt['cannot_monitor_ticket'] = 'Δεν σας επιτρέπεται να ενεργοποιήσετε την παρακολούθηση για αυτό το εισιτήριο.';
$txt['cannot_unmonitor_ticket'] = 'Δεν σας επιτρέπεται να απενεργοποιήσετε την παρακολούθηση για αυτό το εισιτήριο.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Γραφείο Βοήθειας'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Τμήματα'; // ditto
$txt['shd_new_ticket'] = 'Δημοσίευση Νέου Αιτήματος';
$txt['shd_new_ticket_proxy'] = 'Δημοσίευση Αιτήματος Διακομιστή Μεσολάβησης';
$txt['shd_helpdesk_profile'] = 'Προφίλ Helpdesk';
$txt['shd_welcome'] = 'Καλώς ήρθατε, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Πηγαίνετε στο εισιτήριο';
$txt['shd_options'] = 'Επιλογές';
$txt['shd_search_menu'] = 'Αναζήτηση';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Πληροφορίες';
$txt['shd_admin_options'] = 'Επιλογές';
$txt['shd_admin_custom_fields'] = 'Προσαρμοσμένα Πεδία';
$txt['shd_admin_departments'] = 'Τμήματα';
$txt['shd_admin_permissions'] = 'Δικαιώματα';
$txt['shd_admin_plugins'] = 'Πρόσθετα';
$txt['shd_admin_cannedreplies'] = 'Κονσερβοποιημένες Απαντήσεις';
$txt['shd_admin_maint'] = 'Συντήρηση';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Εδώ μπορείτε να υποβάλετε νέα εισιτήρια για το προσωπικό της ιστοσελίδας για δράση και να ελέγξετε τα τρέχοντα εισιτήρια που βρίσκονται ήδη σε εξέλιξη.';
$txt['shd_staff_greeting'] = 'Εδώ είναι όλα τα εισιτήρια που απαιτούν προσοχή.';
$txt['shd_shd_greeting'] = 'Αυτό είναι το Helpdesk. Εδώ σπαταλάτε το χρόνο σας για να βοηθήσετε αρχάριους. Απολαύστε! ;D';
$txt['shd_closed_user_greeting'] = 'Αυτά είναι όλα τα κλειστά/επιλυμένα εισιτήρια που έχετε δημοσιεύσει στο γραφείο βοήθειας.';
$txt['shd_closed_staff_greeting'] = 'Όλα αυτά είναι κλειστά/επιλυμένα εισιτήρια που υποβλήθηκαν στο γραφείο βοήθειας.';
$txt['shd_category_filter'] = 'Φιλτράρισμα κατηγοριών';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Το εισιτήριό σας έχει δημιουργηθεί!';
$txt['shd_ticket_posted_body'] = 'Σας ευχαριστούμε για την ανάρτηση του αιτήματός σας, {membername}!' . "\n\n" . 'Το προσωπικό του γραφείου υποστήριξης θα το επανεξετάσει και θα επικοινωνήσει μαζί σας το συντομότερο δυνατό.' . "\n\n" . 'In the meantime, you can view your ticket, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; at the following URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Ανοίξτε ένα άλλο αίτημα[/iurl] "[iurl={helpdesklink}]" Πίσω στο κύριο helpdesk[/iurl] "[iurl={forumlink}]Πίσω στο φόρουμ[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Μπορείτε να ενεργοποιήσετε τις ειδοποιήσεις email σχετικά με τις αλλαγές στο εισιτήριό σας, στην περιοχή [iurl={prefslink}]Προτιμήσεις στο Helpdesk[/iurl].';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Χαιρετισμοί,' . "\n" . 'Η ομάδα {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Λεπτομέρειες εισιτηρίου';
$txt['shd_ticket_updated'] = 'Ενημερώθηκε';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Όνομα';
$txt['shd_ticket_user'] = 'Χρήστης';
$txt['shd_ticket_date'] = 'Αναρτήθηκε';
$txt['shd_ticket_urgency'] = 'Επείγουσα';
$txt['shd_ticket_assigned'] = 'Ανατεθειμένο';
$txt['shd_ticket_assignedto'] = 'Ανατέθηκε σε';
$txt['shd_ticket_started_by'] = 'Ξεκίνησε από';
$txt['shd_ticket_updated_by'] = 'Ενημερώθηκε από';
$txt['shd_ticket_status'] = 'Κατάσταση';
$txt['shd_ticket_num_replies'] = 'Απαντήσεις';
$txt['shd_ticket_replies'] = 'Απαντήσεις';
$txt['shd_ticket_staff'] = 'Μέλος του προσωπικού';
$txt['shd_ticket_attachments'] = 'Συνημμένα';
$txt['shd_ticket_reply_number'] = 'Απάντηση <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Εισιτήριο Σε Αναμονή';
$txt['shd_ticket'] = 'Αίτημα';
$txt['shd_reply_written'] = 'Η απάντηση γράφτηκε %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Ποτέ';
$txt['shd_linktree_tickets'] = 'Εισιτήρια';
$txt['shd_ticket_privacy'] = 'Απόρρητο';
$txt['shd_ticket_notprivate'] = 'Μη Ιδιωτικό';
$txt['shd_ticket_private'] = 'Ιδιωτικό';
$txt['shd_ticket_change'] = 'Αλλαγή';
$txt['shd_ticket_ip'] = 'Διεύθυνση IP';
$txt['shd_back_to_hd'] = 'Επιστροφή στο helpdesk';
$txt['shd_go_to_replies'] = 'Πηγαίνετε στις Απαντήσεις';
$txt['shd_go_to_action_log'] = 'Μετάβαση στο αρχείο καταγραφής ενεργειών';
$txt['shd_go_to_replies_start'] = 'Μετάβαση στην πρώτη απάντηση';

$txt['shd_ticket_has_been_deleted'] = 'Αυτό το εισιτήριο βρίσκεται επί του παρόντος στον κάδο ανακύκλωσης και δεν μπορεί να τροποποιηθεί χωρίς να επιστραφεί στο γραφείο υποστήριξης.';
$txt['shd_ticket_replies_deleted'] = 'Αυτό το εισιτήριο είχε προηγουμένως διαγράψει τις απαντήσεις.';
$txt['shd_ticket_replies_deleted_view'] = 'Αυτά εμφανίζονται με έγχρωμο φόντο. <a href="%1$s">Δείτε το αίτημα χωρίς διαγραφές</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Παρακαλώ <a href="%1$s">κάντε κλικ εδώ</a> για να τα δείτε.';

$txt['shd_ticket_notnew'] = 'Έχετε ήδη δει αυτό';
$txt['shd_ticket_new'] = 'Νέο!';

$txt['shd_linktree_move_ticket'] = 'Μετακίνηση παραγγελίας';
$txt['shd_linktree_move_topic'] = 'Μετακινήστε το θέμα στο helpdesk';

$txt['shd_cancel_ticket'] = 'Ακύρωση και επιστροφή στο εισιτήριο';
$txt['shd_cancel_home'] = 'Ακύρωση και επιστροφή στο σπίτι του helpdesk';
$txt['shd_cancel_topic'] = 'Ακύρωση και επιστροφή στο θέμα';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Απάντηση στην παραγγελία';
$txt['shd_ticket_quote'] = 'Απάντηση με προσφορά';
$txt['shd_go_advanced'] = 'Πηγαίνετε προχωρημένους!';
$txt['shd_ticket_edit_reply'] = 'Επεξεργασία απάντησης';
$txt['shd_ticket_quote_short'] = 'Παράθεση';
$txt['shd_ticket_markunread'] = 'Επισήμανση μη αναγνωσμένων';
$txt['shd_ticket_reply_short'] = 'Απάντηση';
$txt['shd_ticket_edit'] = 'Επεξεργασία';
$txt['shd_ticket_resolved'] = 'Σημείωση επιλύθηκε';
$txt['shd_ticket_unresolved'] = 'Σημείωση ανεπίλυτων';
$txt['shd_ticket_assign'] = 'Ανάθεση';
$txt['shd_ticket_assign_self'] = 'Ανάθεση σε εμένα';
$txt['shd_ticket_reassign'] = 'Επανανάθεση';
$txt['shd_ticket_unassign'] = 'Μη Ανάθεση';
$txt['shd_ticket_delete'] = 'Διαγραφή';
$txt['shd_delete_confirm'] = 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτό το εισιτήριο? Αν διαγραφεί, αυτό το εισιτήριο θα μεταφερθεί στον κάδο ανακύκλωσης.';
$txt['shd_delete_reply_confirm'] = 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτήν την απάντηση? Αν διαγραφεί, αυτή η απάντηση θα μεταφερθεί στον κάδο ανακύκλωσης.';
$txt['shd_delete_attach_confirm'] = 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτό το συνημμένο? (Αυτό δεν μπορεί να αναιρεθεί!)';
$txt['shd_delete_attach'] = 'Διαγραφή αυτού του συνημμένου';
$txt['shd_ticket_restore'] = 'Επαναφορά';
$txt['shd_delete_permanently'] = 'Οριστική διαγραφή';
$txt['shd_delete_permanently_confirm'] = 'Είστε βέβαιοι ότι θέλετε να διαγράψετε οριστικά αυτό το εισιτήριο? Αυτό δεν μπορεί να αναιρεθεί!';
$txt['shd_ticket_move_to_topic'] = 'Μετακίνηση στο θέμα';
$txt['shd_move_dept'] = 'Μετακίνηση βάθους.';
$txt['shd_actions'] = 'Ενέργειες';
$txt['shd_back_to_ticket'] = 'Επιστροφή σε αυτό το αίτημα μετά την ανάρτηση';
$txt['shd_disable_smileys_post'] = 'Απενεργοποίηση smileys σε αυτήν την ανάρτηση';
$txt['shd_resolve_this_ticket'] = 'Σημειώστε αυτό το αίτημα ως επιλυμένο';
$txt['shd_override_cf'] = 'Παράκαμψη των προσαρμοσμένων πεδίων απαιτήσεων';
$txt['shd_silent_update'] = 'Αθόρυβη ενημέρωση (μη αποστολή ειδοποιήσεων)';
$txt['shd_select_notifications'] = 'Επιλέξτε άτομα για να ειδοποιήσετε σχετικά με αυτήν την απάντηση...';

$txt['shd_ticket_assign_ticket'] = 'Ανάθεση Αιτήματος';
$txt['shd_ticket_assign_to'] = 'Ανάθεση παραγγελίας σε';

$txt['shd_ticket_move_dept'] = 'Μετακίνηση Αιτήματος σε άλλο Τμήμα';
$txt['shd_ticket_move_to'] = 'Μετακίνηση σε';
$txt['shd_current_dept'] = 'Αυτή τη στιγμή στο τμήμα';
$txt['shd_ticket_move'] = 'Μετακίνηση Αιτήματος';
$txt['shd_unknown_dept'] = 'Το συγκεκριμένο τμήμα δεν υπάρχει.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Νέο θέμα';
$txt['shd_move_ticket_to_topic'] = 'Μετακίνηση αιτήματος στο θέμα';
$txt['shd_move_ticket'] = 'Μετακίνηση παραγγελίας';
$txt['shd_ticket_board'] = 'Σκακιέρα';
$txt['shd_change_ticket_subject'] = 'Αλλαγή του θέματος του εισιτηρίου';
$txt['shd_move_send_pm'] = 'Στείλτε ένα ΜΜ στον ιδιοκτήτη του εισιτηρίου';
$txt['shd_move_why'] = 'Παρακαλώ εισάγετε μια σύντομη περιγραφή για το γιατί αυτό το αίτημα μεταφέρεται σε ένα θέμα φόρουμ.';
$txt['shd_ticket_moved_subject'] = 'Το αίτημά σας έχει μετακινηθεί.';
$txt['shd_move_default'] = 'Γεια σας {user},' . "\n\n" . 'Το εισιτήριό σας, {subject}, έχει μετακινηθεί από το γραφείο υποστήριξης σε ένα θέμα στο φόρουμ.' . "\n" . 'Μπορείτε να βρείτε το εισιτήριό σας στον πίνακα {board} ή μέσω αυτού του συνδέσμου:' . "\n\n" . '{link}' . "\n\n" . 'Ευχαριστούμε';

$txt['shd_move_topic_to_ticket'] = 'Μετακινήστε το θέμα στο helpdesk';
$txt['shd_move_topic'] = 'Μετακίνηση θέματος';
$txt['shd_change_topic_subject'] = 'Αλλάξτε το θέμα θέματος';
$txt['shd_move_send_pm_topic'] = 'Στείλτε ένα ΜΜ στην εκκίνηση θεμάτων';
$txt['shd_move_why_topic'] = 'Παρακαλώ εισάγετε μια σύντομη περιγραφή για το γιατί αυτό το θέμα μεταφέρεται στο helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Το θέμα σας έχει μετακινηθεί.';
$txt['shd_move_default_topic'] = 'Γεια σας {user},' . "\n\n" . 'Το θέμα σας, {subject}, έχει μετακινηθεί από το φόρουμ στην ενότητα Helpdesk.' . "\n" . 'Μπορείτε να βρείτε το θέμα σας μέσω αυτού του συνδέσμου:' . "\n\n" . '{link}' . "\n\n" . 'Ευχαριστούμε';

$txt['shd_user_no_hd_access'] = 'Σημείωση: το άτομο που ξεκίνησε αυτό το θέμα δεν μπορεί να δει το helpdesk!';
$txt['shd_user_helpdesk_access'] = 'Το άτομο που ξεκίνησε αυτό το θέμα μπορεί να δει το helpdesk.';
$txt['shd_user_hd_access_dept_1'] = 'Το άτομο που ξεκίνησε αυτό το θέμα μπορεί να δει το ακόλουθο τμήμα: ';
$txt['shd_user_hd_access_dept'] = 'Το άτομο που ξεκίνησε αυτό το θέμα μπορεί να δει τα ακόλουθα τμήματα: ';
$txt['shd_move_ticket_department'] = 'Μετακίνηση εισιτηρίου σε ποιο τμήμα';
$txt['shd_move_dept_why'] = 'Παρακαλώ εισάγετε μια σύντομη περιγραφή για το γιατί αυτό το αίτημα μεταφέρεται σε ένα διαφορετικό τμήμα.';
$txt['shd_move_dept_default'] = 'Γεια σας {user},' . "\n\n" . 'Το εισιτήριό σας, {subject}, έχει μετακινηθεί από το {current_dept} τμήμα στο τμήμα {new_dept}.' . "\n" . 'Μπορείτε να βρείτε το αίτημά σας μέσω αυτού του συνδέσμου:' . "\n\n" . '{link}' . "\n\n" . 'Ευχαριστούμε';

$txt['shd_ticket_move_deleted'] = 'Αυτό το εισιτήριο έχει απαντήσεις που βρίσκονται στον κάδο ανακύκλωσης. Τι θέλετε να κάνετε?';
$txt['shd_ticket_move_deleted_abort'] = 'Abort, πάρτε με στον κάδο ανακύκλωσης';
$txt['shd_ticket_move_deleted_delete'] = 'Συνεχίστε, εγκαταλείψτε τις διαγραμμένες απαντήσεις (μην τις μετακινήσετε στο νέο θέμα)';
$txt['shd_ticket_move_deleted_undelete'] = 'Συνεχίζεται, αναιρέστε τις απαντήσεις (μετακινήστε τις στο νέο θέμα)';

$txt['shd_ticket_move_cfs'] = 'Αυτή η παραγγελία έχει προσαρμοσμένα πεδία που μπορεί να χρειαστεί να μετακινηθούν.';
$txt['shd_ticket_move_cfs_warn'] = 'Μερικά από αυτά τα πεδία μπορεί να μην είναι ορατά σε άλλους χρήστες. Αυτά τα πεδία υποδεικνύονται με ένα θαυμαστικό σήμα.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Μπορείτε να δείτε αυτό το πεδίο, άλλοι χρήστες δεν μπορούν - αλλά μόλις γίνει μέρος του φόρουμ, θα γίνει ορατό σε όλους όσους μπορούν να έχουν πρόσβαση στο φόρουμ.';
$txt['shd_ticket_move_cfs_purge'] = 'Διαγραφή των περιεχομένων του πεδίου';
$txt['shd_ticket_move_cfs_embed'] = 'Κρατήστε το πεδίο και βάλτε το στο νέο θέμα';
$txt['shd_ticket_move_cfs_user'] = 'Επί του παρόντος ορατό σε κανονικούς χρήστες';
$txt['shd_ticket_move_cfs_staff'] = 'Επί του παρόντος ορατό στα μέλη του προσωπικού';
$txt['shd_ticket_move_cfs_admin'] = 'Προς το παρόν ορατό στους διαχειριστές';
$txt['shd_ticket_move_accept'] = 'Δέχομαι ότι ορισμένα από τα πεδία που χειραγωγούνται εδώ δεν είναι ορατά σε όλους τους χρήστες. και ότι αυτό το θέμα θα πρέπει να μετακινηθεί στο φόρουμ, με τις παραπάνω ρυθμίσεις.';
$txt['shd_ticket_move_reqd'] = 'Αυτή η επιλογή πρέπει να επιλεγεί για να μετακινήσετε αυτό το αίτημα στο φόρουμ.';
$txt['shd_ticket_move_ok'] = 'Αυτό το πεδίο είναι ασφαλές να μετακινηθεί, όλοι οι χρήστες που μπορούν να δουν το εισιτήριο μπορούν να δουν αυτό το πεδίο, δεν υπάρχει καμία πληροφορία κρυμμένη από τους χρήστες ή το προσωπικό.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Αυτό το εισιτήριο έχει πεδία που οι χρήστες ή το προσωπικό μπορεί να μην είναι σε θέση να δει, as such you specifically need to confirm you are aware of this - παρακαλώ πηγαίνετε πίσω στην προηγούμενη σελίδα, το πλαίσιο ελέγχου για την επιβεβαίωση της επίγνωσής σας σχετικά με αυτό βρίσκεται στο κάτω μέρος της φόρμας.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Κάδος Ανακύκλωσης';
$txt['shd_recycle_greeting'] = 'Όλα τα διαγραμμένα εισιτήρια πηγαίνουν εδώ, αλλά τα μέλη του προσωπικού με ειδικά δικαιώματα μπορούν να αφαιρέσουν τα εισιτήρια μόνιμα από εδώ.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Δημιουργία παραγγελίας';
$txt['shd_edit_ticket'] = 'Επεξεργασία παραγγελίας';
$txt['shd_edit_ticket_linktree'] = 'Επεξεργασία παραγγελίας (%s)';
$txt['shd_ticket_subject'] = 'Θέμα εισιτηρίων';
$txt['shd_ticket_proxy'] = 'Δημοσίευση εξ ονόματος';
$txt['shd_ticket_post_error'] = 'The following issue or issues occurred while trying to post this ticket';
$txt['shd_reply_ticket'] = 'Απάντηση στην παραγγελία';
$txt['shd_reply_ticket_linktree'] = 'Απάντηση στο αίτημα (%s)';
$txt['shd_edit_reply_linktree'] = 'Επεξεργασία απάντησης (%s)';
$txt['shd_previewing_ticket'] = 'Προεπισκόπηση αιτήματος';
$txt['shd_previewing_reply'] = 'Προεπισκόπηση απάντησης σε';
$txt['shd_choose_one'] = '[Επιλέξτε ένα]';
$txt['shd_no_value'] = '[χωρίς τιμή]';
$txt['shd_ticket_dept'] = 'Τμήμα εισιτηρίων';
$txt['shd_select_dept'] = '-- Επιλέξτε ένα τμήμα --';
$txt['canned_replies'] = 'Προσθήκη προκαθορισμένης απάντησης:';
$txt['canned_replies_select'] = '-- Επιλέξτε μια απάντηση --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Οι απαντήσεις του Helpdesk αναρτήθηκαν από την IP (εύρος)';
$txt['shd_no_replies_from_ip'] = 'Δεν βρέθηκαν απαντήσεις στο helpdesk από την καθορισμένη IP (εύρος)';
$txt['shd_replies_from_ip_desc'] = 'Παρακάτω είναι μια λίστα με όλα τα μηνύματα που δημοσιεύονται στο helpdesk από αυτή την IP (εύρος).';
$txt['shd_is_ticket_opener'] = ' (εκκίνηση εισιτηρίου)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2 αρχειοθήκη';
$txt['shd_attachtype_gz'] = 'Αρχείο GZip';
$txt['shd_attachtype_rar'] = 'Rar/WinRAR αρχειοθήκη';
$txt['shd_attachtype_zip'] = 'Αρχείο zip';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'Αρχείο ήχου MP3 (MPEG Layer III)';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Εικόνα Bitmap των Windows';
$txt['shd_attachtype_gif'] = 'Μορφή ανταλλαγής γραφικών (GIF) εικόνας';
$txt['shd_attachtype_jpeg'] = 'Κοινή ομάδα φωτογραφικών εμπειρογνωμόνων (JPEG) εικόνα';
$txt['shd_attachtype_jpg'] = 'Κοινή ομάδα φωτογραφικών εμπειρογνωμόνων (JPEG) εικόνα';
$txt['shd_attachtype_png'] = 'Εικόνα φορητού δικτύου γραφικών (PNG)';
$txt['shd_attachtype_svg'] = 'Εικόνα γραφικών διάνυσμα (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Ταινία βίντεο Windows Media';
// Office formats
$txt['shd_attachtype_doc'] = 'Έγγραφο Microsoft Word';
$txt['shd_attachtype_mdb'] = 'Βάση δεδομένων Microsoft Access';
$txt['shd_attachtype_ppt'] = 'Microsoft Powerpoint παρουσίαση';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'Αρχείο πηγαίου κώδικα C++';
$txt['shd_attachtype_php'] = 'Σενάριο PHP';
$txt['shd_attachtype_py'] = 'Αρχείο πηγαίου κώδικα Python';
$txt['shd_attachtype_rb'] = 'Αρχείο πηγαίου κώδικα Ruby';
$txt['shd_attachtype_sql'] = 'Σενάριο SQL';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Αρχείο Google Earth (KML)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Φορητό Αρχείο Εγγράφου';
$txt['shd_attachtype_psd'] = 'Adobe Photoshop έγγραφο';
$txt['shd_attachtype_swf'] = 'Adobe Flash αρχείο';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Εκτελέσιμο αρχείο (Windows)';
$txt['shd_attachtype_htm'] = 'Έγγραφο Σημείωσης Υπερκειμένου (HTML)';
$txt['shd_attachtype_html'] = 'Έγγραφο Σημείωσης Υπερκειμένου (HTML)';
$txt['shd_attachtype_rtf'] = 'Μορφή Εμπλουτισμένου Κειμένου (RTF)';
$txt['shd_attachtype_txt'] = 'Απλό κείμενο';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Καταγραφή ενεργειών εισιτηρίων';
$txt['shd_ticket_log_count_one'] = '1 καταχώριση';
$txt['shd_ticket_log_count_more'] = '%s καταχωρήσεις';
$txt['shd_ticket_log_none'] = 'Αυτό το εισιτήριο δεν είχε καμία αλλαγή.';
$txt['shd_ticket_log_member'] = 'Κράτος';
$txt['shd_ticket_log_ip'] = 'Ip Μέλους:';
$txt['shd_ticket_log_date'] = 'Ημερομηνία';
$txt['shd_ticket_log_action'] = 'Ενέργεια';
$txt['shd_ticket_log_full'] = 'Μεταβείτε στο πλήρες αρχείο καταγραφής ενεργειών (Όλα τα εισιτήρια)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Σχετικά Εισιτήρια';
$txt['shd_ticket_create_relationship'] = 'Δημιουργία σχέσης';
$txt['shd_ticket_delete_relationship'] = 'Διαγραφή σχέσης';
$txt['shd_ticket_reltype'] = 'επιλογή τύπου';
$txt['shd_ticket_reltype_linked'] = 'Συνδεδεμένο με';
$txt['shd_ticket_reltype_duplicated'] = 'Αντίγραφο του';
$txt['shd_ticket_reltype_parent'] = 'Γονέας του';
$txt['shd_ticket_reltype_child'] = 'Παιδί του';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Πρόσθετες πληροφορίες';
$txt['shd_ticket_additional_details'] = 'Πρόσθετες λεπτομέρειες';
$txt['shd_ticket_empty_field'] = 'Αυτό το πεδίο είναι κενό.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Ειδοποιήσεις';
$txt['shd_ticket_notify_noneprefs'] = 'Οι προτιμήσεις χρήστη σας δεν λογοδοτούν για την ειδοποίηση αυτού του αιτήματος.';
$txt['shd_ticket_notify_changeprefs'] = 'Αλλάξτε τις προτιμήσεις σας';
$txt['shd_ticket_notify_because'] = 'Οι προτιμήσεις σας υποδεικνύουν την ειδοποίηση των απαντήσεων σε αυτό το εισιτήριο:';
$txt['shd_ticket_notify_because_yourticket'] = 'καθώς είναι το εισιτήριό σας';
$txt['shd_ticket_notify_because_assignedyou'] = 'καθώς έχει ανατεθεί σε εσάς';
$txt['shd_ticket_notify_because_priorreply'] = 'καθώς απαντήσατε σε αυτό πριν';
$txt['shd_ticket_notify_because_anyreply'] = 'για οποιοδήποτε εισιτήριο';

$txt['shd_ticket_notify_me_always'] = 'Παρακολουθείτε αυτό το εισιτήριο (και θα λάβετε ειδοποίηση σε κάθε απάντηση)';
$txt['shd_ticket_monitor_on_note'] = 'Μπορείτε να παρακολουθείτε όλες τις απαντήσεις σε αυτό το αίτημα μέσω ηλεκτρονικού ταχυδρομείου, ανεξάρτητα από τις προτιμήσεις σας:';
$txt['shd_ticket_monitor_off_note'] = 'Μπορείτε να απενεργοποιήσετε την παρακολούθηση για αυτό το αίτημα και να χρησιμοποιήσετε τις προτιμήσεις σας:';
$txt['shd_ticket_monitor_on'] = 'Ενεργοποίηση παρακολούθησης';
$txt['shd_ticket_monitor_off'] = 'Απενεργοποίηση παρακολούθησης';
$txt['shd_ticket_notify_me_never_note'] = 'Μπορείτε να αγνοήσετε τις ενημερώσεις ηλεκτρονικού ταχυδρομείου για αυτό το αίτημα, ανεξάρτητα από τις προτιμήσεις σας:';
$txt['shd_ticket_notify_me_never'] = 'Έχετε απενεργοποιήσει όλες τις ειδοποιήσεις για αυτό το αίτημα.';
$txt['shd_ticket_notify_me_never_on'] = 'Απενεργοποίηση ειδοποιήσεων';
$txt['shd_ticket_notify_me_never_off'] = 'Ενεργοποίηση ειδοποιήσεων';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Η εγκατάσταση αναζήτησης δεν μπορεί να απαριθμεί όλα τα διαθέσιμα εισιτήρια. Αυτή τη στιγμή διερευνάται.';
$txt['shd_search_warning_admin'] = 'Η εγκατάσταση αναζήτησης απαιτεί την ανακατασκευή του ευρετηρίου της. Μπορείτε να το επιτύχετε αυτό από την επιλογή Συντήρηση, στην περιοχή του Helpdesk, στον πίνακα διαχείρισης.';
$txt['shd_search'] = 'Αναζήτηση Αιτημάτων';
$txt['shd_search_results'] = 'Αναζήτηση Αιτημάτων - Αποτελέσματα';
$txt['shd_search_text'] = 'Λέξεις που ψάχνετε:';
$txt['shd_search_match'] = 'Τι πρέπει να ταιριάζει?';
$txt['shd_search_match_all'] = 'Ταίριασμα όλων των παρεχόμενων λέξεων';
$txt['shd_search_match_any'] = 'Ταίριαξε τις λέξεις που παρέχονται';
$txt['shd_search_scope'] = 'Συμπεριλάβετε ποιους τύπους εισιτηρίων,';
$txt['shd_search_scope_open'] = 'Ανοιχτές παραγγελίες';
$txt['shd_search_scope_closed'] = 'Κλειστά εισιτήρια';
$txt['shd_search_scope_recycle'] = 'Αντικείμενα στον κάδο ανακύκλωσης';
$txt['shd_search_result_ticket'] = 'Αίτημα %1$s';
$txt['shd_search_result_reply'] = 'Απάντηση στο αίτημα %1$s';
$txt['shd_search_last_updated'] = 'Τελευταία ενημέρωση:';
$txt['shd_search_ticket_opened_by'] = 'Το εισιτήριο άνοιξε από:';
$txt['shd_search_ticket_replied_by'] = 'Το εισιτήριο απάντησε από:';
$txt['shd_search_dept'] = 'Αναζήτηση σε ποιό τμήμα(-τα):';

$txt['shd_search_urgency'] = 'Συμπεριλάβετε ποια επίπεδα επείγοντος:';

$txt['shd_search_where'] = 'Ποια στοιχεία για αναζήτηση:';
$txt['shd_search_where_tickets'] = 'Τα σώματα των εισιτηρίων';
$txt['shd_search_where_replies'] = 'Οι απαντήσεις στα εισιτήρια';
$txt['shd_search_where_subjects'] = 'Θέματα εισιτηρίων';

$txt['shd_search_ticket_starter'] = 'Τα εισιτήρια ξεκίνησαν από:';
$txt['shd_search_ticket_assignee'] = 'Εισιτήρια που έχουν ανατεθεί σε:';
$txt['shd_search_ticket_named_person'] = 'Πληκτρολογήστε το όνομα του ατόμου που σας ενδιαφέρει.';

$txt['shd_search_no_results'] = 'Δεν βρέθηκαν αποτελέσματα με τα δοθέντα κριτήρια. Μπορεί να θέλετε να επιστρέψετε και να προσπαθήσετε να τροποποιήσετε τα κριτήρια αναζήτησης.';
$txt['shd_search_criteria'] = 'Κριτήρια Αναζήτησης:';
$txt['shd_search_excluded'] = 'Εάν έχει επιλεγεί κάθε πιθανή επιλογή, δεν έχει συμπεριληφθεί στα παραπάνω (π.χ. αν όλα τα πιθανά επίπεδα επείγοντος σημειώθηκαν, δεν αναφέρεται παραπάνω, ώστε να μπορείτε να επικεντρωθείτε σε ό, τι είναι συγκεκριμένο για την αναζήτησή σας)';
//@}