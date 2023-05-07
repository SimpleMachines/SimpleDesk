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
$txt['shd_helpdesk_maintenance'] = 'L\'helpdesk è attualmente in <strong>modalità di manutenzione</strong>. Solo gli amministratori del forum e dell\'helpdesk possono vederlo.';
$txt['shd_open_ticket'] = 'apri ticket';
$txt['shd_open_tickets'] = 'biglietti aperti';
$txt['shd_none'] = 'Nessuno';

$txt['shd_display_nojs'] = 'JavaScript non è abilitato nel tuo browser. Alcune funzioni potrebbero non funzionare correttamente (o del tutto) o comportarsi in modo inatteso.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Benvenuti nel principale centro di amministrazione dell\'helpdesk!';
$txt['shd_admin_title'] = 'Centro Di Amministrazione Helpdesk';
$txt['shd_staff_list'] = 'Personale dell\'Helpdesk';
$txt['shd_update_available'] = 'Nuova versione disponibile!';
$txt['shd_update_message'] = 'È stata rilasciata una nuova versione di SimpleDesk. Ti abbiamo raccomandato di <a href="#" id="update-link">aggiornare all\'ultima versione</a> per rimanere al sicuro e godere di tutte le funzionalità che la nostra modifica ha da offrire.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Per ulteriori informazioni su ciò che è nuovo in questa versione, visita <a href="#" id="information-link" target="_blank">il nostro sito</a>.</span><br>' . "\n\n" . '<strong>The SimpleDesk Team</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Basso';
$txt['shd_urgency_1'] = 'Medio';
$txt['shd_urgency_2'] = 'Alto';
$txt['shd_urgency_3'] = 'Molto Alto';
$txt['shd_urgency_4'] = 'Grave';
$txt['shd_urgency_5'] = 'Critico';
$txt['shd_urgency_increase'] = 'Aumenta';
$txt['shd_urgency_decrease'] = 'Diminuisci';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Nuovo';
$txt['shd_status_1'] = 'Commento Personale In Attesa';
$txt['shd_status_2'] = 'Commento Utente In Attesa';
$txt['shd_status_3'] = 'Risolto/Chiuso';
$txt['shd_status_4'] = 'Riferito al garante';
$txt['shd_status_5'] = 'Escalated - Urgent';
$txt['shd_status_6'] = 'Eliminato';
$txt['shd_status_7'] = 'In Attesa';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Nuovi Biglietti';
$txt['shd_status_1_heading'] = 'Biglietti In Attesa Risposta Dello Staff';
$txt['shd_status_2_heading'] = 'Biglietti In Attesa Risposta Utente';
$txt['shd_status_3_heading'] = 'Biglietti Chiusi';
$txt['shd_status_4_heading'] = 'Biglietti riferiti al supervisore';
$txt['shd_status_5_heading'] = 'Biglietti Urgenti';
$txt['shd_status_6_heading'] = 'Biglietti Riciclati';
$txt['shd_status_7_heading'] = 'Biglietti In Attesa';
$txt['shd_status_assigned_heading'] = 'Assegnato a me';
$txt['shd_status_withdeleted_heading'] = 'Biglietti con Risposte Eliminate';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Biglietti Aperti';
$txt['shd_tickets_closed'] = 'Biglietti Chiusi';
$txt['shd_tickets_recycled'] = 'Biglietti Riciclati';

$txt['shd_assigned'] = 'Assegnato';
$txt['shd_unassigned'] = 'Non Assegnato';

$txt['shd_read_ticket'] = 'Leggi Ticket';
$txt['shd_unread_ticket'] = 'Ticket Non Letto';
$txt['shd_unread_tickets'] = 'Biglietti Non Letti';

$txt['shd_owned'] = 'Biglietto Di Proprietà'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'ticket';
$txt['shd_count_tickets'] = 'ticket';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Non ti è permesso accedere all\'helpdesk.';
$txt['shd_no_ticket'] = 'Il biglietto richiesto non sembra esistere.';
$txt['shd_no_reply'] = 'La risposta al biglietto che hai richiesto non sembra esistere, o non fa parte di questo biglietto.';
$txt['shd_no_topic'] = 'L\'argomento richiesto non sembra esistere.';
$txt['shd_ticket_no_perms'] = 'Non hai il permesso di visualizzare quel biglietto.';
$txt['shd_error_no_tickets'] = 'Nessun ticket trovato.';
$txt['shd_inactive'] = 'L\'helpdesk è attualmente disattivato.';
$txt['shd_cannot_assign'] = 'Non è consentito assegnare i biglietti.';
$txt['shd_cannot_assign_other'] = 'Questo ticket è già assegnato ad un altro utente. Non puoi riassegnarlo a te stesso - contatta l\'amministratore.';
$txt['shd_no_staff_assign'] = 'Non ci sono personale configurato; non è possibile assegnare un ticket. Si prega di contattare l\'amministratore.';
$txt['shd_assigned_not_permitted'] = 'L\'utente che hai richiesto di assegnare questo ticket per non avere permessi sufficienti per vederlo.';
$txt['shd_cannot_resolve'] = 'Non hai il permesso di contrassegnare questo ticket come risolto.';
$txt['shd_cannot_unresolve'] = 'Non hai il permesso di riaprire un ticket risolto.';
$txt['error_shd_cannot_resolve_children'] = 'Questo biglietto al momento non può essere chiuso; questo biglietto è il genitore di uno o più biglietti che sono attualmente aperti.';
$txt['error_shd_proxy_unknown'] = 'L\'utente che questo ticket è pubblicato per conto di non esiste.';
$txt['shd_cannot_change_privacy'] = 'Non hai il permesso di modificare la privacy su questo ticket.';
$txt['shd_cannot_change_urgency'] = 'Non hai il permesso di modificare l\'urgenza di questo biglietto.';
$txt['shd_ajax_problem'] = 'Si è verificato un problema durante il caricamento della pagina. Vuoi riprovare?';
$txt['shd_cannot_move_ticket'] = 'Non hai il permesso di spostare questo ticket in un argomento.';
$txt['shd_cannot_move_topic'] = 'Non hai il permesso di spostare questo topic su un ticket.';
$txt['shd_moveticket_noboards'] = 'Non ci sono schede su cui spostare questo biglietto!';
$txt['shd_move_no_pm'] = 'È necessario inserire un motivo per spostare il biglietto per inviare al proprietario del biglietto, o deseleziona l\'opzione per \'inviare un PM al proprietario del biglietto\'.';
$txt['shd_move_no_pm_topic'] = 'È necessario inserire un motivo per spostare l\'argomento per inviare al topic starter, o deseleziona l\'opzione per \'inviare un PM al topic starter\'.';
$txt['shd_move_topic_not_created'] = 'Impossibile spostare il ticket nella scheda. Per favore riprova.';
$txt['shd_move_ticket_not_created'] = 'Spostamento dell\'argomento nell\'helpdesk non riuscito. Riprova.';
$txt['shd_no_replies'] = 'Questo ticket non ha ancora risposte.';
$txt['cannot_shd_new_ticket'] = 'Non hai il permesso di creare un nuovo ticket.';
$txt['cannot_shd_edit_ticket'] = 'Non hai i permessi per modificare questo ticket.';
$txt['shd_cannot_reply_any'] = 'Non hai il permesso di rispondere a nessun ticket.';
$txt['shd_cannot_reply_any_but_own'] = 'Non hai il permesso di rispondere a nessun biglietto diverso dal tuo.';
$txt['shd_cannot_edit_reply_any'] = 'Non hai il permesso di modificare nessuna risposta.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Non hai il permesso di modificare le risposte a nessun ticket diverso dalle tue risposte.';
$txt['shd_cannot_edit_closed'] = 'Non è possibile modificare i ticket risolti; è necessario contrassegnarli prima irrisolti.';
$txt['shd_cannot_edit_deleted'] = 'Non puoi modificare i ticket nel cestino. Essi dovranno essere ripristinati prima.';
$txt['shd_cannot_reply_closed'] = 'Non puoi rispondere ai ticket risolti; devi prima contrassegnarli irrisolti.';
$txt['shd_cannot_reply_deleted'] = 'Non puoi rispondere ai biglietti nel cestino. Dovranno essere ripristinati per prima.';
$txt['shd_cannot_delete_ticket'] = 'Non è consentito eliminare questo ticket.';
$txt['shd_cannot_delete_reply'] = 'Non ti è permesso cancellare quella risposta.';
$txt['shd_cannot_restore_ticket'] = 'Non è consentito ripristinare questo ticket dal cestino.';
$txt['shd_cannot_restore_reply'] = 'Non è consentito ripristinare quella risposta dal cestino.';
$txt['shd_cannot_view_resolved'] = 'Non ti è consentito accedere ai ticket risolti.';
$txt['cannot_shd_access_recyclebin'] = 'Non puoi accedere al cestino.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Non puoi spostare questo ticket nel forum; ci sono una o più risposte cancellate, alle quali i tuoi permessi attuali non consentono di accedere.';
$txt['shd_cannot_attach_ext'] = 'Il tipo di file che hai cercato di allegare ({ext}) non è consentito qui. I tipi di file consentiti sono: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Questo ticket non è attualmente disponibile per la modifica.';
$txt['shd_invalid_relation'] = 'È necessario fornire un tipo di rapporto valido per questi biglietti.';
$txt['shd_no_relation_delete'] = 'Non puoi eliminare una relazione che non esiste.';
$txt['shd_cannot_relate_self'] = 'Non è possibile che un biglietto si riferisca a se stesso.';
$txt['shd_relationships_are_disabled'] = 'Le relazioni dei ticket sono attualmente disabilitate.';
$txt['error_invalid_fields'] = 'I seguenti campi hanno valori che non possono essere utilizzati: %1$s';
$txt['error_missing_fields'] = 'I seguenti campi non sono stati completati e devono essere: %1$s';
$txt['error_missing_multi'] = '%1$s (almeno %2$d deve essere selezionato)';
$txt['error_no_dept'] = 'Non hai selezionato un dipartimento in cui inviare questo biglietto.';
$txt['shd_cannot_move_dept'] = 'Non puoi spostare questo biglietto, non c\'è nessun posto in cui spostarlo.';
$txt['shd_no_perm_move_dept'] = 'Non è consentito spostare questo biglietto in un altro dipartimento.';
$txt['cannot_shd_delete_attachment'] = 'Non è consentito eliminare allegati.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Non puoi spostare questo ticket in un topic; ci sono campi personalizzati allegati che richiedono un amministratore per confermare la mossa.';
$txt['cannot_monitor_ticket'] = 'Non ti è permesso attivare il monitoraggio per questo biglietto.';
$txt['cannot_unmonitor_ticket'] = 'Non ti è permesso disattivare il monitoraggio per questo biglietto.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Helpdesk'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Dipartimenti'; // ditto
$txt['shd_new_ticket'] = 'Pubblica Nuovo Ticket';
$txt['shd_new_ticket_proxy'] = 'Pubblica Biglietto Proxy';
$txt['shd_helpdesk_profile'] = 'Profilo Helpdesk';
$txt['shd_welcome'] = 'Benvenuto, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Vai al ticket';
$txt['shd_options'] = 'Opzioni';
$txt['shd_search_menu'] = 'Cerca';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Informazioni';
$txt['shd_admin_options'] = 'Opzioni';
$txt['shd_admin_custom_fields'] = 'Campi Personalizzati';
$txt['shd_admin_departments'] = 'Dipartimenti';
$txt['shd_admin_permissions'] = 'Permessi';
$txt['shd_admin_plugins'] = 'Plugin';
$txt['shd_admin_cannedreplies'] = 'Risposte In Canned';
$txt['shd_admin_maint'] = 'Manutenzione';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Qui è possibile presentare nuovi biglietti per il personale del sito per agire, e controllare i biglietti attuali già in corso.';
$txt['shd_staff_greeting'] = 'Ecco tutti i biglietti che richiedono attenzione.';
$txt['shd_shd_greeting'] = 'Questo è l\'Helpdesk. Qui sprechi il tuo tempo per aiutare i principianti. Divertiti! ;D';
$txt['shd_closed_user_greeting'] = 'Questi sono tutti i biglietti chiusi/risolti che hai inviato all\'helpdesk.';
$txt['shd_closed_staff_greeting'] = 'Questi sono tutti i ticket chiusi/risolti inviati all\'helpdesk.';
$txt['shd_category_filter'] = 'Filtro categoria';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Il tuo biglietto è stato creato!';
$txt['shd_ticket_posted_body'] = 'Grazie per aver pubblicato il tuo biglietto, {membername}!' . "\n\n" . 'Il personale dell\'helpdesk lo riesaminerà e ti risponderà il prima possibile.' . "\n\n" . 'Nel frattempo, puoi vedere il tuo biglietto, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; al seguente URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Apri un altro ticket[/iurl] <unk> [iurl={helpdesklink}]Torna all\'helpdesk principale[/iurl] <unk> [iurl={forumlink}]Torna al forum[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Puoi attivare le notifiche via email sulle modifiche al tuo ticket, nell\'area [iurl={prefslink}]Preferenze dell\'Helpdesk[/iurl].';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Saluti;' . "\n" . 'La Squadra {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Dettagli del ticket';
$txt['shd_ticket_updated'] = 'Aggiornato';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Nome';
$txt['shd_ticket_user'] = 'Utente';
$txt['shd_ticket_date'] = 'Pubblicato';
$txt['shd_ticket_urgency'] = 'Urgenza';
$txt['shd_ticket_assigned'] = 'Assegnato';
$txt['shd_ticket_assignedto'] = 'Assegnato a';
$txt['shd_ticket_started_by'] = 'Iniziato da';
$txt['shd_ticket_updated_by'] = 'Aggiornato da';
$txt['shd_ticket_status'] = 'Stato';
$txt['shd_ticket_num_replies'] = 'Risposte';
$txt['shd_ticket_replies'] = 'Risposte';
$txt['shd_ticket_staff'] = 'Membro del personale';
$txt['shd_ticket_attachments'] = 'Allegati';
$txt['shd_ticket_reply_number'] = 'Rispondi <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Ticket On-Hold';
$txt['shd_ticket'] = 'Ticket';
$txt['shd_reply_written'] = 'Risposta scritta %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Mai';
$txt['shd_linktree_tickets'] = 'Biglietti';
$txt['shd_ticket_privacy'] = 'Privacy';
$txt['shd_ticket_notprivate'] = 'Non Privato';
$txt['shd_ticket_private'] = 'Privato';
$txt['shd_ticket_change'] = 'Cambia';
$txt['shd_ticket_ip'] = 'Indirizzo IP';
$txt['shd_back_to_hd'] = 'Torna all\'helpdesk';
$txt['shd_go_to_replies'] = 'Vai alle risposte';
$txt['shd_go_to_action_log'] = 'Vai al Registro delle Azioni';
$txt['shd_go_to_replies_start'] = 'Vai alla prima risposta';

$txt['shd_ticket_has_been_deleted'] = 'Questo biglietto è attualmente nel cestino e non può essere modificato senza essere restituito all\'helpdesk.';
$txt['shd_ticket_replies_deleted'] = 'Questo ticket ha avuto risposte cancellate da esso in precedenza.';
$txt['shd_ticket_replies_deleted_view'] = 'Questi vengono visualizzati con uno sfondo colorato. <a href="%1$s">Visualizza il ticket senza cancellazioni</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Per favore <a href="%1$s">clicca qui</a> per vederli.';

$txt['shd_ticket_notnew'] = 'Hai già visto questo';
$txt['shd_ticket_new'] = 'Nuovo!';

$txt['shd_linktree_move_ticket'] = 'Sposta ticket';
$txt['shd_linktree_move_topic'] = 'Sposta l\'argomento nell\'helpdesk';

$txt['shd_cancel_ticket'] = 'Annulla e torna al ticket';
$txt['shd_cancel_home'] = 'Annullare e tornare all\'helpdesk a casa';
$txt['shd_cancel_topic'] = 'Annulla e torna all\'argomento';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Rispondi al ticket';
$txt['shd_ticket_quote'] = 'Rispondi con preventivo';
$txt['shd_go_advanced'] = 'Vai avanzato!';
$txt['shd_ticket_edit_reply'] = 'Modifica risposta';
$txt['shd_ticket_quote_short'] = 'Preventivo';
$txt['shd_ticket_markunread'] = 'Segna non letto';
$txt['shd_ticket_reply_short'] = 'Rispondi';
$txt['shd_ticket_edit'] = 'Modifica';
$txt['shd_ticket_resolved'] = 'Segna risolto';
$txt['shd_ticket_unresolved'] = 'Segna irrisolto';
$txt['shd_ticket_assign'] = 'Assegna';
$txt['shd_ticket_assign_self'] = 'Assegna a me';
$txt['shd_ticket_reassign'] = 'Riassegna';
$txt['shd_ticket_unassign'] = 'Annulla-Assegna';
$txt['shd_ticket_delete'] = 'Elimina';
$txt['shd_delete_confirm'] = 'Sei sicuro di voler eliminare questo ticket? Se eliminato, questo ticket verrà spostato nel contenitore di riciclaggio.';
$txt['shd_delete_reply_confirm'] = 'Sei sicuro di voler eliminare questa risposta? Se eliminata, questa risposta verrà spostata nel contenitore di riciclaggio.';
$txt['shd_delete_attach_confirm'] = 'Sei sicuro di voler eliminare questo allegato? (Questo non può essere annullato!)';
$txt['shd_delete_attach'] = 'Elimina questo allegato';
$txt['shd_ticket_restore'] = 'Ripristina';
$txt['shd_delete_permanently'] = 'Elimina permanentemente';
$txt['shd_delete_permanently_confirm'] = 'Sei sicuro di voler eliminare definitivamente questo ticket? Questo non può essere annullato!';
$txt['shd_ticket_move_to_topic'] = 'Sposta nell\'argomento';
$txt['shd_move_dept'] = 'Sposta il dept.';
$txt['shd_actions'] = 'Azioni';
$txt['shd_back_to_ticket'] = 'Ritorna a questo ticket dopo la pubblicazione';
$txt['shd_disable_smileys_post'] = 'Spegni le faccine in questo post';
$txt['shd_resolve_this_ticket'] = 'Segna questo ticket come risolto';
$txt['shd_override_cf'] = 'Sovrascrivi i requisiti dei campi personalizzati';
$txt['shd_silent_update'] = 'Aggiornamento silenzioso (non inviare notifiche)';
$txt['shd_select_notifications'] = 'Seleziona le persone da notificare su questa risposta...';

$txt['shd_ticket_assign_ticket'] = 'Assegna Ticket';
$txt['shd_ticket_assign_to'] = 'Assegna ticket a';

$txt['shd_ticket_move_dept'] = 'Sposta il ticket in un altro dipartimento';
$txt['shd_ticket_move_to'] = 'Sposta in';
$txt['shd_current_dept'] = 'Attualmente in reparto';
$txt['shd_ticket_move'] = 'Sposta Ticket';
$txt['shd_unknown_dept'] = 'Il reparto specificato non esiste.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Nuovo oggetto';
$txt['shd_move_ticket_to_topic'] = 'Sposta il ticket nell\'argomento';
$txt['shd_move_ticket'] = 'Sposta ticket';
$txt['shd_ticket_board'] = 'Tavola';
$txt['shd_change_ticket_subject'] = 'Cambia l\'oggetto del ticket';
$txt['shd_move_send_pm'] = 'Invia un PM al proprietario del ticket';
$txt['shd_move_why'] = 'Inserisci una breve descrizione del motivo per cui questo ticket viene spostato in un argomento del forum.';
$txt['shd_ticket_moved_subject'] = 'Il tuo biglietto è stato spostato.';
$txt['shd_move_default'] = 'Ciao {user},' . "\n\n" . 'Il tuo biglietto, {subject}, è stato spostato dall\'helpdesk a un argomento nel forum.' . "\n" . 'Puoi trovare il tuo biglietto nella scheda {board} o tramite questo link:' . "\n\n" . '{link}' . "\n\n" . 'Grazie';

$txt['shd_move_topic_to_ticket'] = 'Sposta l\'argomento nell\'helpdesk';
$txt['shd_move_topic'] = 'Sposta argomento';
$txt['shd_change_topic_subject'] = 'Cambia l\'argomento dell\'argomento';
$txt['shd_move_send_pm_topic'] = 'Invia un PM all\'avvio dell\'argomento';
$txt['shd_move_why_topic'] = 'Inserisci una breve descrizione del motivo per cui questo argomento viene spostato nell\'helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Il tuo argomento è stato spostato.';
$txt['shd_move_default_topic'] = 'Ciao {user},' . "\n\n" . 'Il tuo argomento, {subject}, è stato spostato dal forum alla sezione Helpdesk.' . "\n" . 'Puoi trovare il tuo argomento tramite questo link:' . "\n\n" . '{link}' . "\n\n" . 'Grazie';

$txt['shd_user_no_hd_access'] = 'Nota: la persona che ha iniziato questo argomento non può vedere l\'helpdesk!';
$txt['shd_user_helpdesk_access'] = 'La persona che ha iniziato questo argomento può vedere l\'helpdesk.';
$txt['shd_user_hd_access_dept_1'] = 'La persona che ha iniziato questo argomento può vedere il seguente reparto: ';
$txt['shd_user_hd_access_dept'] = 'La persona che ha iniziato questo argomento può vedere i seguenti reparti: ';
$txt['shd_move_ticket_department'] = 'Sposta il ticket in quale dipartimento';
$txt['shd_move_dept_why'] = 'Inserisci una breve descrizione del motivo per cui questo biglietto viene spostato in un altro dipartimento.';
$txt['shd_move_dept_default'] = 'Ciao {user},' . "\n\n" . 'Il tuo biglietto, {subject}, è stato spostato dal dipartimento {current_dept} al dipartimento {new_dept}.' . "\n" . 'Puoi trovare il tuo biglietto tramite questo link:' . "\n\n" . '{link}' . "\n\n" . 'Grazie';

$txt['shd_ticket_move_deleted'] = 'Questo ticket ha risposte che sono attualmente nel cestino. Cosa vuoi fare?';
$txt['shd_ticket_move_deleted_abort'] = 'Aborto, portami al cestino';
$txt['shd_ticket_move_deleted_delete'] = 'Continua, abbandona le risposte eliminate (non spostarle nel nuovo argomento)';
$txt['shd_ticket_move_deleted_undelete'] = 'Continua, ripristina le risposte (spostali nel nuovo argomento)';

$txt['shd_ticket_move_cfs'] = 'Questo ticket ha campi personalizzati che potrebbero dover essere spostati.';
$txt['shd_ticket_move_cfs_warn'] = 'Alcuni di questi campi potrebbero non essere visibili ad altri utenti. Questi campi sono indicati con un segno esclamativo.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Puoi vedere questo campo, altri utenti non possono - ma una volta che diventa parte del forum, diventerà visibile a tutti coloro che possono accedere al forum.';
$txt['shd_ticket_move_cfs_purge'] = 'Elimina il contenuto del campo';
$txt['shd_ticket_move_cfs_embed'] = 'Mantieni il campo e mettilo nel nuovo argomento';
$txt['shd_ticket_move_cfs_user'] = 'Attualmente visibile agli utenti normali';
$txt['shd_ticket_move_cfs_staff'] = 'Attualmente visibile ai membri del personale';
$txt['shd_ticket_move_cfs_admin'] = 'Attualmente visibile agli amministratori';
$txt['shd_ticket_move_accept'] = 'Accetto che alcuni dei campi manipolati qui non siano visibili a tutti gli utenti, e che questo argomento dovrebbe essere spostato nel forum, con le impostazioni di cui sopra.';
$txt['shd_ticket_move_reqd'] = 'Questa opzione deve essere selezionata per poter spostare questo ticket nel forum.';
$txt['shd_ticket_move_ok'] = 'Questo campo è sicuro da spostare, tutti gli utenti che possono vedere il ticket possono vedere questo campo, non ci sono informazioni nascoste agli utenti o al personale.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Questo ticket ha campi che gli utenti o il personale potrebbero non essere in grado di vedere, come tale è specificamente necessario confermare che siete consapevoli di questo - si prega di tornare alla pagina precedente, la casella di controllo per confermare la tua consapevolezza di questo è in fondo al modulo.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Cestino';
$txt['shd_recycle_greeting'] = 'Questo è il contenitore di riciclaggio. Tutti i biglietti cancellati vanno qui, ma i membri del personale con permessi speciali possono rimuovere definitivamente i biglietti da qui.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Crea ticket';
$txt['shd_edit_ticket'] = 'Modifica ticket';
$txt['shd_edit_ticket_linktree'] = 'Modifica biglietto (%s)';
$txt['shd_ticket_subject'] = 'Oggetto del ticket';
$txt['shd_ticket_proxy'] = 'Posta per conto di';
$txt['shd_ticket_post_error'] = 'Il seguente problema, o problemi, si è verificato durante il tentativo di pubblicare questo ticket';
$txt['shd_reply_ticket'] = 'Rispondi al ticket';
$txt['shd_reply_ticket_linktree'] = 'Rispondi al biglietto (%s)';
$txt['shd_edit_reply_linktree'] = 'Modifica risposta (%s)';
$txt['shd_previewing_ticket'] = 'Anteprima ticket';
$txt['shd_previewing_reply'] = 'Anteprima risposta a';
$txt['shd_choose_one'] = '[Sceglierne uno]';
$txt['shd_no_value'] = '[nessun valore]';
$txt['shd_ticket_dept'] = 'Servizio biglietteria';
$txt['shd_select_dept'] = '-- Seleziona un dipartimento --';
$txt['canned_replies'] = 'Aggiungere una risposta predefinita:';
$txt['canned_replies_select'] = '-- Seleziona una risposta --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Risposte all\'Helpdesk pubblicate da IP (intervallo)';
$txt['shd_no_replies_from_ip'] = 'Non sono state trovate risposte all\'helpdesk dall\'IP specificato (intervallo)';
$txt['shd_replies_from_ip_desc'] = 'Di seguito è riportato un elenco di tutti i messaggi inviati all\'helpdesk da questo IP (intervallo).';
$txt['shd_is_ticket_opener'] = ' (inizio biglietto)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'Archivio BZip2';
$txt['shd_attachtype_gz'] = 'Archivio GZip';
$txt['shd_attachtype_rar'] = 'Archivio Rar/WinRAR';
$txt['shd_attachtype_zip'] = 'Archivio zip';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'File audio MP3 (MPEG Layer III)';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Immagine Bitmap di Windows';
$txt['shd_attachtype_gif'] = 'Grafica Interchange Format (GIF) immagine';
$txt['shd_attachtype_jpeg'] = 'Joint Photographic Experts Group (JPEG) image';
$txt['shd_attachtype_jpg'] = 'Joint Photographic Experts Group (JPEG) image';
$txt['shd_attachtype_png'] = 'Immagine grafica di rete portatile (PNG)';
$txt['shd_attachtype_svg'] = 'Immagine grafica vettoriale scalabile (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Film video Windows Media';
// Office formats
$txt['shd_attachtype_doc'] = 'Documento Microsoft Word';
$txt['shd_attachtype_mdb'] = 'Banca dati Microsoft Access';
$txt['shd_attachtype_ppt'] = 'Presentazione di Microsoft Powerpoint';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'File sorgente C++';
$txt['shd_attachtype_php'] = 'Script PHP';
$txt['shd_attachtype_py'] = 'File sorgente Python';
$txt['shd_attachtype_rb'] = 'File sorgente Ruby';
$txt['shd_attachtype_sql'] = 'Script SQL';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (archivio KML)';
$txt['shd_attachtype_pdf'] = 'File Di Documento Portatile Di Adobe Acrobat';
$txt['shd_attachtype_psd'] = 'Documento Adobe Photoshop';
$txt['shd_attachtype_swf'] = 'File Flash in Adobe';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'File eseguibile (Windows)';
$txt['shd_attachtype_htm'] = 'Documento Di Marcatura Dell\'Ipertesto (Html)';
$txt['shd_attachtype_html'] = 'Documento Di Marcatura Dell\'Ipertesto (Html)';
$txt['shd_attachtype_rtf'] = 'Formato Rich Text (RTF)';
$txt['shd_attachtype_txt'] = 'Testo semplice';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Registro azioni Ticket';
$txt['shd_ticket_log_count_one'] = '1 voce';
$txt['shd_ticket_log_count_more'] = '%s voci';
$txt['shd_ticket_log_none'] = 'Questo ticket non ha avuto alcuna modifica.';
$txt['shd_ticket_log_member'] = 'Membro';
$txt['shd_ticket_log_ip'] = 'Ip Membro:';
$txt['shd_ticket_log_date'] = 'Data';
$txt['shd_ticket_log_action'] = 'Azione';
$txt['shd_ticket_log_full'] = 'Vai al registro delle azioni completo (tutti i ticket)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Biglietti Correlati';
$txt['shd_ticket_create_relationship'] = 'Crea relazione';
$txt['shd_ticket_delete_relationship'] = 'Elimina rapporto';
$txt['shd_ticket_reltype'] = 'seleziona tipo';
$txt['shd_ticket_reltype_linked'] = 'Collegato a';
$txt['shd_ticket_reltype_duplicated'] = 'Duplica di';
$txt['shd_ticket_reltype_parent'] = 'Genitore di';
$txt['shd_ticket_reltype_child'] = 'Figlio di';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Informazioni supplementari';
$txt['shd_ticket_additional_details'] = 'Ulteriori dettagli';
$txt['shd_ticket_empty_field'] = 'Questo campo è vuoto.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Notifiche';
$txt['shd_ticket_notify_noneprefs'] = 'Le tue preferenze utente non account per la notifica di questo ticket.';
$txt['shd_ticket_notify_changeprefs'] = 'Cambia le tue preferenze';
$txt['shd_ticket_notify_because'] = 'Le tue preferenze indicano di ricevere le risposte a questo biglietto:';
$txt['shd_ticket_notify_because_yourticket'] = 'siccome è il tuo biglietto';
$txt['shd_ticket_notify_because_assignedyou'] = 'come è assegnato a te';
$txt['shd_ticket_notify_because_priorreply'] = 'come avete risposto prima';
$txt['shd_ticket_notify_because_anyreply'] = 'per qualsiasi biglietto';

$txt['shd_ticket_notify_me_always'] = 'Stai monitorando questo ticket (e riceverai una notifica su ogni risposta)';
$txt['shd_ticket_monitor_on_note'] = 'Puoi monitorare tutte le risposte a questo ticket via email indipendentemente dalle tue preferenze:';
$txt['shd_ticket_monitor_off_note'] = 'È possibile disattivare il monitoraggio per questo ticket e utilizzare le preferenze invece:';
$txt['shd_ticket_monitor_on'] = 'Attiva monitoraggio';
$txt['shd_ticket_monitor_off'] = 'Disattiva monitoraggio';
$txt['shd_ticket_notify_me_never_note'] = 'Puoi ignorare gli aggiornamenti delle email per questo ticket indipendentemente dalle tue preferenze:';
$txt['shd_ticket_notify_me_never'] = 'Hai disattivato tutte le notifiche per questo ticket.';
$txt['shd_ticket_notify_me_never_on'] = 'Disattiva le notifiche';
$txt['shd_ticket_notify_me_never_off'] = 'Attiva notifiche';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'La struttura di ricerca potrebbe non elencare tutti i biglietti disponibili; è attualmente in fase di indagine.';
$txt['shd_search_warning_admin'] = 'La funzione di ricerca richiede che il suo indice sia ricostruito. È possibile ottenere questo risultato dall\'opzione Manutenzione, nell\'area Helpdesk, nel pannello di amministrazione.';
$txt['shd_search'] = 'Cerca Biglietti';
$txt['shd_search_results'] = 'Biglietti Di Ricerca - Risultati';
$txt['shd_search_text'] = 'Parole che stai cercando:';
$txt['shd_search_match'] = 'Cosa dovrebbe essere abbinato?';
$txt['shd_search_match_all'] = 'Corrisponde a tutte le parole fornite';
$txt['shd_search_match_any'] = 'Corrisponde a tutte le parole fornite';
$txt['shd_search_scope'] = 'Includi quali tipi di biglietti:';
$txt['shd_search_scope_open'] = 'Biglietti aperti';
$txt['shd_search_scope_closed'] = 'Biglietti chiusi';
$txt['shd_search_scope_recycle'] = 'Oggetti nel cestino';
$txt['shd_search_result_ticket'] = 'Ticket %1$s';
$txt['shd_search_result_reply'] = 'Rispondi al ticket %1$s';
$txt['shd_search_last_updated'] = 'Ultimo aggiornamento:';
$txt['shd_search_ticket_opened_by'] = 'Biglietto aperto da:';
$txt['shd_search_ticket_replied_by'] = 'Il biglietto ha risposto a:';
$txt['shd_search_dept'] = 'Cerca in quali reparti:';

$txt['shd_search_urgency'] = 'Includere i livelli di urgenza:';

$txt['shd_search_where'] = 'Quali elementi cercare:';
$txt['shd_search_where_tickets'] = 'I corpi dei biglietti';
$txt['shd_search_where_replies'] = 'Le risposte nei ticket';
$txt['shd_search_where_subjects'] = 'Argomenti del ticket';

$txt['shd_search_ticket_starter'] = 'Biglietti iniziati da:';
$txt['shd_search_ticket_assignee'] = 'Biglietti assegnati a:';
$txt['shd_search_ticket_named_person'] = 'Digita il nome della persona o delle persone a cui sei interessato.';

$txt['shd_search_no_results'] = 'Nessun risultato è stato trovato con i criteri indicati. Potresti voler tornare indietro e provare a modificare i criteri di ricerca.';
$txt['shd_search_criteria'] = 'Criteri Di Ricerca:';
$txt['shd_search_excluded'] = 'Se è stata selezionata ogni opzione possibile, questa non è stata inclusa nel precedente (es. se tutti i possibili livelli di urgenza sono stati selezionati, non è indicato sopra, in modo da poter concentrarsi su ciò che è specifico per la tua ricerca)';
//@}