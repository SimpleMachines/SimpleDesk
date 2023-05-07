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
$txt['shd_helpdesk'] = 'Helpdesk';
$txt['shd_helpdesk_maintenance'] = 'Das Helpdesk befindet sich derzeit im <strong>-Wartungsmodus</strong>. Nur Foren- und Helpdesk-Administratoren können dies sehen.';
$txt['shd_open_ticket'] = 'öffne Ticket';
$txt['shd_open_tickets'] = 'offene Tickets';
$txt['shd_none'] = 'Keine';

$txt['shd_display_nojs'] = 'JavaScript ist in Ihrem Browser nicht aktiviert. Einige Funktionen funktionieren möglicherweise nicht richtig (oder überhaupt nicht) oder verhalten sich unerwartet verhalten.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Willkommen im Haupt-Helpdesk-Administrationszentrum!';
$txt['shd_admin_title'] = 'Helpdesk-Verwaltungszentrum';
$txt['shd_staff_list'] = 'Helpdesk-Mitarbeiter';
$txt['shd_update_available'] = 'Neue Version verfügbar!';
$txt['shd_update_message'] = 'Eine neue Version von SimpleDesk wurde veröffentlicht. Wir empfehlen Ihnen, <a href="#" id="update-link">auf die neueste Version</a> zu aktualisieren, um sicher zu bleiben und alle Funktionen zu nutzen, die unsere Modifikation bietet.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Für weitere Informationen zu dem, was in dieser Version neu ist, besuchen Sie bitte <a href="#" id="information-link" target="_blank">unsere Website</a>.</span><br>' . "\n\n" . '<strong>Das SimpleDesk Team</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Niedrig';
$txt['shd_urgency_1'] = 'Mittel';
$txt['shd_urgency_2'] = 'Hoch';
$txt['shd_urgency_3'] = 'Sehr hoch';
$txt['shd_urgency_4'] = 'Schwer';
$txt['shd_urgency_5'] = 'Kritisch';
$txt['shd_urgency_increase'] = 'Erhöhen';
$txt['shd_urgency_decrease'] = 'Verkleinern';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Neu';
$txt['shd_status_1'] = 'Ausstehender Personalkommentar';
$txt['shd_status_2'] = 'Ausstehender Benutzerkommentar';
$txt['shd_status_3'] = 'gelöst/Geschlossen';
$txt['shd_status_4'] = 'An den Supervisor verwiesen';
$txt['shd_status_5'] = 'Eskaliert - Dringend';
$txt['shd_status_6'] = 'Gelöscht';
$txt['shd_status_7'] = 'Halten';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Neue Tickets';
$txt['shd_status_1_heading'] = 'Tickets, die auf Personalantwort warten';
$txt['shd_status_2_heading'] = 'Tickets, die auf Antwort des Benutzers warten';
$txt['shd_status_3_heading'] = 'Geschlossene Tickets';
$txt['shd_status_4_heading'] = 'An Supervisor verwiesene Tickets';
$txt['shd_status_5_heading'] = 'Dringende Tickets';
$txt['shd_status_6_heading'] = 'Recycled Tickets';
$txt['shd_status_7_heading'] = 'Auf Halte Tickets';
$txt['shd_status_assigned_heading'] = 'Mir zugewiesen';
$txt['shd_status_withdeleted_heading'] = 'Tickets mit gelöschten Antworten';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Offene Tickets';
$txt['shd_tickets_closed'] = 'Geschlossene Tickets';
$txt['shd_tickets_recycled'] = 'Recycled Tickets';

$txt['shd_assigned'] = 'Zugewiesen';
$txt['shd_unassigned'] = 'Nicht zugeordnet';

$txt['shd_read_ticket'] = 'Ticket lesen';
$txt['shd_unread_ticket'] = 'Ungelesenes Ticket';
$txt['shd_unread_tickets'] = 'Ungelesene Tickets';

$txt['shd_owned'] = 'Eigenes Ticket'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'ticket';
$txt['shd_count_tickets'] = 'tickets';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Sie sind nicht berechtigt, auf den Helpdesk zuzugreifen.';
$txt['shd_no_ticket'] = 'Das angeforderte Ticket scheint nicht zu existieren.';
$txt['shd_no_reply'] = 'Die Ticket-Antwort, die Sie angefordert haben, scheint nicht zu existieren oder ist nicht Teil dieses Tickets.';
$txt['shd_no_topic'] = 'Das angeforderte Thema scheint nicht zu existieren.';
$txt['shd_ticket_no_perms'] = 'Sie haben keine Berechtigung, dieses Ticket anzuzeigen.';
$txt['shd_error_no_tickets'] = 'Keine Tickets gefunden.';
$txt['shd_inactive'] = 'Das Helpdesk ist derzeit deaktiviert.';
$txt['shd_cannot_assign'] = 'Sie sind nicht berechtigt, Tickets zuzuweisen.';
$txt['shd_cannot_assign_other'] = 'Dieses Ticket ist bereits einem anderen Benutzer zugewiesen. Sie können es sich nicht selbst zuweisen - bitte kontaktieren Sie den Administrator.';
$txt['shd_no_staff_assign'] = 'Es sind keine Mitarbeiter konfiguriert; es ist nicht möglich, ein Ticket zuzuweisen. Bitte kontaktieren Sie Ihren Administrator.';
$txt['shd_assigned_not_permitted'] = 'Der Benutzer, dem Sie dieses Ticket zuweisen möchten, verfügt nicht über ausreichende Berechtigungen, um es zu sehen.';
$txt['shd_cannot_resolve'] = 'Ihnen fehlt die Berechtigung, dieses Ticket als erledigt zu markieren.';
$txt['shd_cannot_unresolve'] = 'Sie haben keine Berechtigung, ein gelöstes Ticket erneut zu öffnen.';
$txt['error_shd_cannot_resolve_children'] = 'Dieses Ticket kann derzeit nicht geschlossen werden. Dieses Ticket ist das Elternteil eines oder mehrerer Tickets, die derzeit geöffnet sind.';
$txt['error_shd_proxy_unknown'] = 'Der Benutzer, der dieses Ticket im Namen des Tickets gepostet hat, existiert nicht.';
$txt['shd_cannot_change_privacy'] = 'Sie haben keine Berechtigung, die Privatsphäre dieses Tickets zu ändern.';
$txt['shd_cannot_change_urgency'] = 'Sie haben keine Berechtigung, die Dringlichkeit auf diesem Ticket zu ändern.';
$txt['shd_ajax_problem'] = 'Beim Laden der Seite ist ein Fehler aufgetreten. Möchten Sie es erneut versuchen?';
$txt['shd_cannot_move_ticket'] = 'Ihnen fehlt die Berechtigung, dieses Ticket zu einem Thema zu verschieben.';
$txt['shd_cannot_move_topic'] = 'Ihnen fehlt die Berechtigung, dieses Thema auf ein Ticket zu verschieben.';
$txt['shd_moveticket_noboards'] = 'Es gibt keine Boards um dieses Ticket zu verschieben!';
$txt['shd_move_no_pm'] = 'Sie müssen einen Grund für die Verschiebung des Tickets angeben, um es an den Besitzer des Tickets zu senden oder deaktivieren Sie die Option \'eine PN an den Ticket-Besitzer senden\'.';
$txt['shd_move_no_pm_topic'] = 'Sie müssen einen Grund für die Verschiebung des Themas angeben, um es an den Anfang des Themas zu senden oder deaktivieren Sie die Option, \'eine PN an das Thema starter zu senden\'.';
$txt['shd_move_topic_not_created'] = 'Fehler beim Verschieben des Tickets auf das Board. Bitte versuchen Sie es erneut.';
$txt['shd_move_ticket_not_created'] = 'Das Thema konnte nicht zum Helpdesk verschoben werden. Bitte versuchen Sie es erneut.';
$txt['shd_no_replies'] = 'Dieses Ticket hat noch keine Antworten.';
$txt['cannot_shd_new_ticket'] = 'Ihnen fehlt die Berechtigung, ein neues Ticket zu erstellen.';
$txt['cannot_shd_edit_ticket'] = 'Ihnen fehlt die Berechtigung, dieses Ticket zu bearbeiten.';
$txt['shd_cannot_reply_any'] = 'Sie haben keine Berechtigung auf Tickets zu antworten.';
$txt['shd_cannot_reply_any_but_own'] = 'Sie haben keine Berechtigung, auf andere Tickets als Ihre eigenen zu antworten.';
$txt['shd_cannot_edit_reply_any'] = 'Sie haben keine Berechtigung, Antworten zu bearbeiten.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Sie haben keine Berechtigung, Antworten auf andere Tickets als Ihre eigenen Antworten zu bearbeiten.';
$txt['shd_cannot_edit_closed'] = 'Sie können aufgelöste Tickets nicht bearbeiten; Sie müssen sie zuerst als ungelöst markieren.';
$txt['shd_cannot_edit_deleted'] = 'Tickets können nicht im Papierkorb bearbeitet werden. Sie müssen zuerst wiederhergestellt werden.';
$txt['shd_cannot_reply_closed'] = 'Sie können nicht auf gelöste Tickets antworten; Sie müssen diese zuerst als ungelöst markieren.';
$txt['shd_cannot_reply_deleted'] = 'Sie können nicht auf Tickets im Papierkorb antworten. Sie müssen zuerst wiederhergestellt werden.';
$txt['shd_cannot_delete_ticket'] = 'Sie sind nicht berechtigt, dieses Ticket zu löschen.';
$txt['shd_cannot_delete_reply'] = 'Sie sind nicht berechtigt, diese Antwort zu löschen.';
$txt['shd_cannot_restore_ticket'] = 'Sie sind nicht berechtigt, dieses Ticket aus dem Papierkorb wiederherzustellen.';
$txt['shd_cannot_restore_reply'] = 'Sie sind nicht berechtigt, diese Antwort aus dem Papierkorb wiederherzustellen.';
$txt['shd_cannot_view_resolved'] = 'Sie sind nicht berechtigt, auf gelöste Tickets zuzugreifen.';
$txt['cannot_shd_access_recyclebin'] = 'Sie können nicht auf den Papierkorb zugreifen.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Sie können dieses Ticket nicht in das Forum verschieben. Es gibt eine oder mehrere gelöschte Antworten, auf die Ihre aktuellen Berechtigungen keinen Zugriff erlauben.';
$txt['shd_cannot_attach_ext'] = 'Der Dateityp, den Sie versucht haben anzuhängen ({ext}) ist hier nicht erlaubt. Die erlaubten Dateitypen sind: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Dieses Ticket ist zur Zeit nicht zur Bearbeitung verfügbar.';
$txt['shd_invalid_relation'] = 'Sie müssen einen gültigen Beziehungstyp für diese Tickets angeben.';
$txt['shd_no_relation_delete'] = 'Sie können keine Beziehung löschen, die nicht existiert.';
$txt['shd_cannot_relate_self'] = 'Sie können kein Ticket zu sich selbst machen.';
$txt['shd_relationships_are_disabled'] = 'Ticket-Beziehungen sind derzeit deaktiviert.';
$txt['error_invalid_fields'] = 'Die folgenden Felder haben Werte, die nicht verwendet werden können: %1$s';
$txt['error_missing_fields'] = 'Die folgenden Felder wurden nicht ausgefüllt und müssen sein: %1$s';
$txt['error_missing_multi'] = '%1$s (mindestens %2$d muss ausgewählt sein)';
$txt['error_no_dept'] = 'Sie haben keine Abteilung ausgewählt, in die dieses Ticket veröffentlicht werden soll.';
$txt['shd_cannot_move_dept'] = 'Sie können dieses Ticket nicht verschieben, es gibt nirgendwo zu verschieben.';
$txt['shd_no_perm_move_dept'] = 'Sie sind nicht berechtigt, dieses Ticket in eine andere Abteilung zu verschieben.';
$txt['cannot_shd_delete_attachment'] = 'Sie sind nicht berechtigt, Anhänge zu löschen.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Sie können dieses Ticket nicht zu einem Thema verschieben. Es sind benutzerdefinierte Felder angehängt, die einen Administrator erfordern, um den Umzug zu bestätigen.';
$txt['cannot_monitor_ticket'] = 'Sie dürfen die Überwachung für dieses Ticket nicht einschalten.';
$txt['cannot_unmonitor_ticket'] = 'Sie sind nicht berechtigt, die Überwachung für dieses Ticket abzuschalten.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Helpdesk'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Abteilungen'; // ditto
$txt['shd_new_ticket'] = 'Neues Ticket posten';
$txt['shd_new_ticket_proxy'] = 'Proxy-Ticket posten';
$txt['shd_helpdesk_profile'] = 'Helpdesk-Profil';
$txt['shd_welcome'] = 'Willkommen, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Gehe zu Ticket';
$txt['shd_options'] = 'Optionen';
$txt['shd_search_menu'] = 'Suchen';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Informationen';
$txt['shd_admin_options'] = 'Optionen';
$txt['shd_admin_custom_fields'] = 'Eigene Felder';
$txt['shd_admin_departments'] = 'Abteilungen';
$txt['shd_admin_permissions'] = 'Berechtigungen';
$txt['shd_admin_plugins'] = 'Plugins';
$txt['shd_admin_cannedreplies'] = 'Vordefinierte Antworten';
$txt['shd_admin_maint'] = 'Wartung';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Hier können Sie neue Tickets für das Website-Personal zu handeln, und überprüfen Sie die aktuellen Tickets bereits im Gange.';
$txt['shd_staff_greeting'] = 'Hier sind alle Tickets, die Aufmerksamkeit erfordern.';
$txt['shd_shd_greeting'] = 'Dies ist der Helpdesk. Hier verschwenden Sie Ihre Zeit, um Neulinge zu helfen. Viel Spaß! ;D';
$txt['shd_closed_user_greeting'] = 'Dies sind alles die geschlossenen/erledigten Tickets, die Sie an den Helpdesk geschrieben haben.';
$txt['shd_closed_staff_greeting'] = 'Dies sind alles geschlossene/gelöste Tickets, die an den Helpdesk geschickt werden.';
$txt['shd_category_filter'] = 'Kategorie-Filterung';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Ihr Ticket wurde erstellt!';
$txt['shd_ticket_posted_body'] = 'Vielen Dank für Ihr Ticket, {membername}!' . "\n\n" . 'Das Helpdesk-Personal wird es prüfen und sich so schnell wie möglich mit Ihnen in Verbindung setzen.' . "\n\n" . 'In der Zwischenzeit können Sie Ihr Ticket ansehen, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; unter folgender URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Öffnen Sie ein anderes Ticket[/iurl] | [iurl={helpdesklink}]Zurück zum Haupt-Helpdesk[/iurl] | [iurl={forumlink}]Zurück zum Forum[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Sie können E-Mail-Benachrichtigungen über Änderungen an Ihrem Ticket im Bereich [iurl={prefslink}]Helpdesk-Einstellungen[/iurl] aktivieren.';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Grüße,' . "\n" . 'Das {forum_name} Team.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Ticket-Details';
$txt['shd_ticket_updated'] = 'Aktualisiert';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Name';
$txt['shd_ticket_user'] = 'Benutzer';
$txt['shd_ticket_date'] = 'Gepostet';
$txt['shd_ticket_urgency'] = 'Dringlichkeit';
$txt['shd_ticket_assigned'] = 'Zugewiesen';
$txt['shd_ticket_assignedto'] = 'Zugewiesen an';
$txt['shd_ticket_started_by'] = 'Gestartet von';
$txt['shd_ticket_updated_by'] = 'Aktualisiert von';
$txt['shd_ticket_status'] = 'Status';
$txt['shd_ticket_num_replies'] = 'Antworten';
$txt['shd_ticket_replies'] = 'Antworten';
$txt['shd_ticket_staff'] = 'Mitarbeiter';
$txt['shd_ticket_attachments'] = 'Anhänge';
$txt['shd_ticket_reply_number'] = 'Antwort <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Ticket gewartet';
$txt['shd_ticket'] = 'Ticket';
$txt['shd_reply_written'] = 'Antwort geschrieben %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Nie';
$txt['shd_linktree_tickets'] = 'Tickets';
$txt['shd_ticket_privacy'] = 'Privatsphäre';
$txt['shd_ticket_notprivate'] = 'Nicht privat';
$txt['shd_ticket_private'] = 'Privat';
$txt['shd_ticket_change'] = 'Ändern';
$txt['shd_ticket_ip'] = 'IP-Adresse';
$txt['shd_back_to_hd'] = 'Zurück zum Helpdesk';
$txt['shd_go_to_replies'] = 'Gehe zu Antworten';
$txt['shd_go_to_action_log'] = 'Zum Aktionsprotokoll';
$txt['shd_go_to_replies_start'] = 'Gehe zur ersten Antwort';

$txt['shd_ticket_has_been_deleted'] = 'Dieses Ticket befindet sich derzeit im Papierkorb und kann ohne Rückgabe an den Helpdesk nicht geändert werden.';
$txt['shd_ticket_replies_deleted'] = 'Für dieses Ticket wurden Antworten zuvor gelöscht.';
$txt['shd_ticket_replies_deleted_view'] = 'Diese werden mit einem farbigen Hintergrund angezeigt. <a href="%1$s">Sehen Sie das Ticket ohne Löschungen</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Bitte <a href="%1$s">klicken Sie hier</a> um sie anzusehen.';

$txt['shd_ticket_notnew'] = 'Du hast dies bereits gesehen';
$txt['shd_ticket_new'] = 'Neu!';

$txt['shd_linktree_move_ticket'] = 'Ticket verschieben';
$txt['shd_linktree_move_topic'] = 'Thema in Helpdesk verschieben';

$txt['shd_cancel_ticket'] = 'Abbrechen und zurück zum Ticket';
$txt['shd_cancel_home'] = 'Abbrechen und zum Helpdesk-Haus zurückkehren';
$txt['shd_cancel_topic'] = 'Abbrechen und zum Thema zurückkehren';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Antwort auf Ticket';
$txt['shd_ticket_quote'] = 'Antwort mit Zitat';
$txt['shd_go_advanced'] = 'Los fortgeschritten!';
$txt['shd_ticket_edit_reply'] = 'Antwort bearbeiten';
$txt['shd_ticket_quote_short'] = 'Zitat';
$txt['shd_ticket_markunread'] = 'Ungelesene markieren';
$txt['shd_ticket_reply_short'] = 'Antwort';
$txt['shd_ticket_edit'] = 'Bearbeiten';
$txt['shd_ticket_resolved'] = 'Aufgelöst markieren';
$txt['shd_ticket_unresolved'] = 'Unerledigt markieren';
$txt['shd_ticket_assign'] = 'Zuweisen';
$txt['shd_ticket_assign_self'] = 'Mir zuweisen';
$txt['shd_ticket_reassign'] = 'Neu zuweisen';
$txt['shd_ticket_unassign'] = 'Nicht zuweisen';
$txt['shd_ticket_delete'] = 'Löschen';
$txt['shd_delete_confirm'] = 'Sind Sie sicher, dass Sie dieses Ticket löschen möchten? Wenn Sie es gelöscht haben, wird dieses Ticket in den Papierkorb verschoben.';
$txt['shd_delete_reply_confirm'] = 'Sind Sie sicher, dass Sie diese Antwort löschen möchten? Wenn Sie sie gelöscht haben, wird diese Antwort in den Papierkorb verschoben.';
$txt['shd_delete_attach_confirm'] = 'Sind Sie sicher, dass Sie diesen Anhang löschen möchten? (Dies kann nicht rückgängig gemacht werden!)';
$txt['shd_delete_attach'] = 'Diesen Anhang löschen';
$txt['shd_ticket_restore'] = 'Wiederherstellen';
$txt['shd_delete_permanently'] = 'Endgültig löschen';
$txt['shd_delete_permanently_confirm'] = 'Sind Sie sicher, dass Sie dieses Ticket dauerhaft löschen möchten? Dies kann NICHT rückgängig gemacht werden!';
$txt['shd_ticket_move_to_topic'] = 'In Thema verschieben';
$txt['shd_move_dept'] = 'Tiefe verschieben.';
$txt['shd_actions'] = 'Aktionen';
$txt['shd_back_to_ticket'] = 'Zurück zu diesem Ticket nach dem Schreiben';
$txt['shd_disable_smileys_post'] = 'Smileys in diesem Beitrag ausschalten';
$txt['shd_resolve_this_ticket'] = 'Dieses Ticket als erledigt markieren';
$txt['shd_override_cf'] = 'Benutzerdefinierte Felder überschreiben';
$txt['shd_silent_update'] = 'Stumme Aktualisierung (keine Benachrichtigungen senden)';
$txt['shd_select_notifications'] = 'Personen auswählen, die über diese Antwort benachrichtigt werden sollen...';

$txt['shd_ticket_assign_ticket'] = 'Ticket zuweisen';
$txt['shd_ticket_assign_to'] = 'Ticket zuweisen an';

$txt['shd_ticket_move_dept'] = 'Ticket in eine andere Abteilung verschieben';
$txt['shd_ticket_move_to'] = 'Verschieben nach';
$txt['shd_current_dept'] = 'Derzeit in Abteilung';
$txt['shd_ticket_move'] = 'Ticket verschieben';
$txt['shd_unknown_dept'] = 'Die angegebene Abteilung existiert nicht.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Neuer Betreff';
$txt['shd_move_ticket_to_topic'] = 'Ticket zum Thema verschieben';
$txt['shd_move_ticket'] = 'Ticket verschieben';
$txt['shd_ticket_board'] = 'Brett';
$txt['shd_change_ticket_subject'] = 'Ticket-Betreff ändern';
$txt['shd_move_send_pm'] = 'Senden Sie eine PN an den Ticket-Besitzer';
$txt['shd_move_why'] = 'Bitte geben Sie eine kurze Beschreibung ein, warum dieses Ticket in ein Forenthema verschoben wird.';
$txt['shd_ticket_moved_subject'] = 'Ihr Ticket wurde verschoben.';
$txt['shd_move_default'] = 'Hallo {user},' . "\n\n" . 'Ihr Ticket, {subject}, wurde vom Helpdesk zu einem Thema im Forum verschoben.' . "\n" . 'Sie finden Ihr Ticket im Board {board} oder über diesen Link:' . "\n\n" . '{link}' . "\n\n" . 'Danke';

$txt['shd_move_topic_to_ticket'] = 'Thema in Helpdesk verschieben';
$txt['shd_move_topic'] = 'Thema verschieben';
$txt['shd_change_topic_subject'] = 'Thema ändern';
$txt['shd_move_send_pm_topic'] = 'Sende eine PN zum Themen-Starter';
$txt['shd_move_why_topic'] = 'Bitte geben Sie eine kurze Beschreibung ein, warum dieses Thema in das Helpdesk verschoben wird. ';
$txt['shd_ticket_moved_subject_topic'] = 'Ihr Thema wurde verschoben.';
$txt['shd_move_default_topic'] = 'Hallo {user},' . "\n\n" . 'Ihr Thema, {subject}, wurde vom Forum in den Helpdesk Bereich verschoben.' . "\n" . 'Du findest dein Thema über diesen Link:' . "\n\n" . '{link}' . "\n\n" . 'Danke';

$txt['shd_user_no_hd_access'] = 'Hinweis: Die Person, die dieses Thema gestartet hat, kann den Helpdesk nicht sehen!';
$txt['shd_user_helpdesk_access'] = 'Die Person, die dieses Thema gestartet hat, kann den Helpdesk sehen.';
$txt['shd_user_hd_access_dept_1'] = 'Die Person, die dieses Thema begonnen hat, kann folgende Abteilung sehen: ';
$txt['shd_user_hd_access_dept'] = 'Die Person, die dieses Thema begonnen hat, kann folgende Abteilungen sehen: ';
$txt['shd_move_ticket_department'] = 'Ticket in die Abteilung verschieben';
$txt['shd_move_dept_why'] = 'Bitte geben Sie eine kurze Beschreibung ein, warum dieses Ticket in eine andere Abteilung verschoben wird.';
$txt['shd_move_dept_default'] = 'Hallo {user},' . "\n\n" . 'Ihr Ticket, {subject}, wurde aus der Abteilung {current_dept} in die Abteilung {new_dept} verschoben.' . "\n" . 'Du findest dein Ticket über diesen Link:' . "\n\n" . '{link}' . "\n\n" . 'Danke';

$txt['shd_ticket_move_deleted'] = 'Dieses Ticket hat Antworten, die sich derzeit im Papierkorb befinden. Was möchtest du tun?';
$txt['shd_ticket_move_deleted_abort'] = 'Abbrechen, Bring mich in den Papierkorb';
$txt['shd_ticket_move_deleted_delete'] = 'Fortfahren, die gelöschten Antworten verlassen (verschieben Sie sie nicht in das neue Thema)';
$txt['shd_ticket_move_deleted_undelete'] = 'Fortfahren, die Antworten wiederherstellen (verschieben Sie sie in das neue Thema)';

$txt['shd_ticket_move_cfs'] = 'Dieses Ticket hat benutzerdefinierte Felder, die eventuell verschoben werden müssen.';
$txt['shd_ticket_move_cfs_warn'] = 'Einige dieser Felder sind möglicherweise für andere Benutzer nicht sichtbar. Diese Felder sind mit einem Ausrufezeichen gekennzeichnet.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Du kannst dieses Feld sehen, andere Benutzer können es nicht - aber sobald es Teil des Forums wird, es wird sichtbar für alle, die Zugang zum Forum haben.';
$txt['shd_ticket_move_cfs_purge'] = 'Inhalt des Feldes löschen';
$txt['shd_ticket_move_cfs_embed'] = 'Behalte das Feld und füge es in das neue Thema ein';
$txt['shd_ticket_move_cfs_user'] = 'Derzeit für normale Benutzer sichtbar';
$txt['shd_ticket_move_cfs_staff'] = 'Derzeit für Mitarbeiter sichtbar';
$txt['shd_ticket_move_cfs_admin'] = 'Derzeit für Administratoren sichtbar';
$txt['shd_ticket_move_accept'] = 'Ich akzeptiere, dass einige der Felder, die hier manipuliert werden, nicht für alle Benutzer sichtbar sind und dass dieses Thema in das Forum verschoben werden sollte, mit den obigen Einstellungen.';
$txt['shd_ticket_move_reqd'] = 'Diese Option muss ausgewählt sein, damit Sie dieses Ticket in das Forum verschieben können.';
$txt['shd_ticket_move_ok'] = 'Dieses Feld kann verschoben werden, alle Benutzer, die das Ticket sehen können, können dieses Feld sehen es gibt keine Informationen versteckt vor Benutzern oder Mitarbeitern.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Dieses Ticket hat Felder, die Benutzer oder Mitarbeiter nicht sehen können da Sie also ausdrücklich bestätigen müssen, dass Sie sich dessen bewusst sind - bitte gehen Sie zurück zur vorherigen Seite das Kontrollkästchen für die Bestätigung Ihres Bewusstseins befindet sich am unteren Rand des Formulars.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Papierkorb';
$txt['shd_recycle_greeting'] = 'Dies ist der Papierkorb. Alle gelöschten Tickets gehen hierher, aber Mitarbeiter mit besonderen Berechtigungen können Tickets dauerhaft von hier entfernen.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Ticket erstellen';
$txt['shd_edit_ticket'] = 'Ticket bearbeiten';
$txt['shd_edit_ticket_linktree'] = 'Ticket bearbeiten (%s)';
$txt['shd_ticket_subject'] = 'Ticket-Betreff';
$txt['shd_ticket_proxy'] = 'Beitrag im Namen von';
$txt['shd_ticket_post_error'] = 'Das folgende Problem oder Probleme sind aufgetreten beim Versuch, dieses Ticket zu posten';
$txt['shd_reply_ticket'] = 'Antwort auf Ticket';
$txt['shd_reply_ticket_linktree'] = 'Auf Ticket antworten (%s)';
$txt['shd_edit_reply_linktree'] = 'Antwort bearbeiten (%s)';
$txt['shd_previewing_ticket'] = 'Vorschau des Tickets';
$txt['shd_previewing_reply'] = 'Vorschau der Antwort auf';
$txt['shd_choose_one'] = '[Wählen Sie eine]';
$txt['shd_no_value'] = '[kein Wert]';
$txt['shd_ticket_dept'] = 'Ticket-Abteilung';
$txt['shd_select_dept'] = '-- Abteilung auswählen --';
$txt['canned_replies'] = 'Eine vordefinierte Antwort hinzufügen:';
$txt['canned_replies_select'] = '-- Antwort auswählen --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Helpdesk-Antworten aus IP (Bereich)';
$txt['shd_no_replies_from_ip'] = 'Keine Helpdesk-Antworten aus der angegebenen IP (Bereich) gefunden';
$txt['shd_replies_from_ip_desc'] = 'Unten ist eine Liste aller Nachrichten, die an das Helpdesk aus dieser IP (Bereich) geschickt werden.';
$txt['shd_is_ticket_opener'] = ' (Ticket-Start)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2-Archiv';
$txt['shd_attachtype_gz'] = 'GZip-Archiv';
$txt['shd_attachtype_rar'] = 'Selten/WinRAR-Archiv';
$txt['shd_attachtype_zip'] = 'Zip-Archiv';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) Audiodatei';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windows Bitmap-Bild';
$txt['shd_attachtype_gif'] = 'Grafik-Austauschformat (GIF) Bild';
$txt['shd_attachtype_jpeg'] = 'Gemeinsame Foto-Experten-Gruppe (JPEG) Bild';
$txt['shd_attachtype_jpg'] = 'Gemeinsame Foto-Experten-Gruppe (JPEG) Bild';
$txt['shd_attachtype_png'] = 'Portable Network Graphic (PNG) Bild';
$txt['shd_attachtype_svg'] = 'Skalierbare Vektorgrafik (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Video Film';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Word Dokument';
$txt['shd_attachtype_mdb'] = 'Microsoft Zugriffsdatenbank';
$txt['shd_attachtype_ppt'] = 'Microsoft-Powerpoint-Präsentation';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ Quelldatei';
$txt['shd_attachtype_php'] = 'PHP-Skript';
$txt['shd_attachtype_py'] = 'Python-Quelldatei';
$txt['shd_attachtype_rb'] = 'Ruby-Quelldatei';
$txt['shd_attachtype_sql'] = 'SQL-Skript';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KML-Archiv)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Portable Dokumentdatei';
$txt['shd_attachtype_psd'] = 'Adobe Photoshop Dokument';
$txt['shd_attachtype_swf'] = 'Adobe Flash-Datei';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Ausführbare Datei (Windows)';
$txt['shd_attachtype_htm'] = 'Hypertext Markup Dokument (HTML)';
$txt['shd_attachtype_html'] = 'Hypertext Markup Dokument (HTML)';
$txt['shd_attachtype_rtf'] = 'Rich-Text-Format (RTF)';
$txt['shd_attachtype_txt'] = 'Einfacher Text';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Ticket-Aktionsprotokoll';
$txt['shd_ticket_log_count_one'] = '1 Eintrag';
$txt['shd_ticket_log_count_more'] = '%s Einträge';
$txt['shd_ticket_log_none'] = 'Dieses Ticket hat sich nicht geändert.';
$txt['shd_ticket_log_member'] = 'Mitglied';
$txt['shd_ticket_log_ip'] = 'Mitglieder-IP:';
$txt['shd_ticket_log_date'] = 'Datum';
$txt['shd_ticket_log_action'] = 'Aktion';
$txt['shd_ticket_log_full'] = 'Zum kompletten Actionlog (Alle Tickets)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Ähnliche Tickets';
$txt['shd_ticket_create_relationship'] = 'Beziehung erstellen';
$txt['shd_ticket_delete_relationship'] = 'Beziehung löschen';
$txt['shd_ticket_reltype'] = 'wähle Typ';
$txt['shd_ticket_reltype_linked'] = 'Verbunden mit';
$txt['shd_ticket_reltype_duplicated'] = 'Duplikat von';
$txt['shd_ticket_reltype_parent'] = 'Elternteil von';
$txt['shd_ticket_reltype_child'] = 'Kind von';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Zusätzliche Informationen';
$txt['shd_ticket_additional_details'] = 'Zusätzliche Details';
$txt['shd_ticket_empty_field'] = 'Dieses Feld ist leer.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Benachrichtigungen';
$txt['shd_ticket_notify_noneprefs'] = 'Ihre Benutzereinstellungen haben kein Konto für die Benachrichtigung dieses Tickets.';
$txt['shd_ticket_notify_changeprefs'] = 'Einstellungen ändern';
$txt['shd_ticket_notify_because'] = 'Ihre Einstellungen zeigen an, dass Sie über Antworten auf dieses Ticket informieren:';
$txt['shd_ticket_notify_because_yourticket'] = 'da es Ihr Ticket ist';
$txt['shd_ticket_notify_because_assignedyou'] = 'da es Ihnen zugewiesen ist';
$txt['shd_ticket_notify_because_priorreply'] = 'wie du darauf geantwortet hast';
$txt['shd_ticket_notify_because_anyreply'] = 'für jedes Ticket';

$txt['shd_ticket_notify_me_always'] = 'Sie überwachen dieses Ticket (und erhalten bei jeder Antwort eine Benachrichtigung)';
$txt['shd_ticket_monitor_on_note'] = 'Sie können alle Antworten auf dieses Ticket unabhängig von Ihren Präferenzen per E-Mail überwachen:';
$txt['shd_ticket_monitor_off_note'] = 'Sie können die Überwachung für dieses Ticket deaktivieren und stattdessen Ihre Einstellungen verwenden:';
$txt['shd_ticket_monitor_on'] = 'Überwachung einschalten';
$txt['shd_ticket_monitor_off'] = 'Überwachung ausschalten';
$txt['shd_ticket_notify_me_never_note'] = 'Sie können E-Mail-Updates für dieses Ticket ignorieren, unabhängig von Ihren Einstellungen:';
$txt['shd_ticket_notify_me_never'] = 'Du hast alle Benachrichtigungen für dieses Ticket deaktiviert.';
$txt['shd_ticket_notify_me_never_on'] = 'Benachrichtigungen ausschalten';
$txt['shd_ticket_notify_me_never_off'] = 'Benachrichtigungen einschalten';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Die Suchfunktion kann nicht alle verfügbaren Tickets auflisten; sie wird gerade untersucht.';
$txt['shd_search_warning_admin'] = 'Die Suchfunktion erfordert einen Neuaufbau des Indexes. Dies können Sie über die Wartungsoption im Helpdesk-Bereich im Administrationsbereich erreichen.';
$txt['shd_search'] = 'Tickets suchen';
$txt['shd_search_results'] = 'Tickets suchen - Ergebnisse';
$txt['shd_search_text'] = 'Wörter, die Sie suchen:';
$txt['shd_search_match'] = 'Was ist zu treffen?';
$txt['shd_search_match_all'] = 'Alle angegebenen Wörter übereinstimmen';
$txt['shd_search_match_any'] = 'Alle angegebenen Wörter abgleichen';
$txt['shd_search_scope'] = 'Beinhaltet die Art der Tickets:';
$txt['shd_search_scope_open'] = 'Offene Tickets';
$txt['shd_search_scope_closed'] = 'Geschlossene Tickets';
$txt['shd_search_scope_recycle'] = 'Gegenstände im Papierkorb';
$txt['shd_search_result_ticket'] = 'Ticket %1$s';
$txt['shd_search_result_reply'] = 'Auf Ticket %1$s antworten';
$txt['shd_search_last_updated'] = 'Zuletzt aktualisiert:';
$txt['shd_search_ticket_opened_by'] = 'Ticket geöffnet von:';
$txt['shd_search_ticket_replied_by'] = 'Ticket beantwortet von:';
$txt['shd_search_dept'] = 'Suche in welcher Abteilung(en):';

$txt['shd_search_urgency'] = 'Fügen Sie die Dringlichkeitsstufen ein:';

$txt['shd_search_where'] = 'Welche Elemente zu suchen:';
$txt['shd_search_where_tickets'] = 'Die Körper der Tickets';
$txt['shd_search_where_replies'] = 'Die Antworten in Tickets';
$txt['shd_search_where_subjects'] = 'Ticket-Themen';

$txt['shd_search_ticket_starter'] = 'Tickets gestartet von:';
$txt['shd_search_ticket_assignee'] = 'Tickets zugewiesen an:';
$txt['shd_search_ticket_named_person'] = 'Geben Sie den Namen der Person ein, die Sie interessiert.';

$txt['shd_search_no_results'] = 'Es wurden keine Ergebnisse mit den angegebenen Kriterien gefunden. Sie können zurückgehen und versuchen, Ihre Suchkriterien zu ändern.';
$txt['shd_search_criteria'] = 'Suchkriterien:';
$txt['shd_search_excluded'] = 'Wenn jede mögliche Option ausgewählt wurde, wurde sie nicht in die obige Option aufgenommen (z. wenn alle möglichen Dringlichkeitsstufen angekreuzt wurden, ist es nicht oben angegeben, so dass Sie sich darauf konzentrieren können, was spezifisch für Ihre Suche ist)';
//@}