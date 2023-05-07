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
$txt['shd_helpdesk_maintenance'] = 'Centrul de asistență este în prezent în modul <strong>de mentenanță</strong>. Numai administratorii forumului și cei de helpdesk pot vedea asta.';
$txt['shd_open_ticket'] = 'deschide bilet';
$txt['shd_open_tickets'] = 'bilete deschise';
$txt['shd_none'] = 'Niciunul';

$txt['shd_display_nojs'] = 'JavaScript nu este activat în browser-ul dvs. Este posibil ca unele funcții să nu funcționeze corect (sau deloc) sau să se comporte într-un mod neașteptat.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Bun venit la centrul principal de administrare helpdesk!';
$txt['shd_admin_title'] = 'Centrul de Administrare a Helpdesk';
$txt['shd_staff_list'] = 'Personalul birourilor de asistență';
$txt['shd_update_available'] = 'Versiune nouă disponibilă!';
$txt['shd_update_message'] = 'O nouă versiune a SimpleDesk a fost lansată. V-am revenit la <a href="#" id="update-link">actualizarea la cea mai recentă versiune</a> pentru a rămâne în siguranță și pentru a vă bucura de toate caracteristicile pe care le oferă modificarea noastră.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Pentru mai multe informaţii despre ce este nou în această versiune, vă rugăm să vizitaţi <a href="#" id="information-link" target="_blank">site-ul nostru</a>.</span><br>' . "\n\n" . '<strong>Echipa SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'scazut';
$txt['shd_urgency_1'] = 'Medie';
$txt['shd_urgency_2'] = 'Ridicat';
$txt['shd_urgency_3'] = 'Foarte Mare';
$txt['shd_urgency_4'] = 'Severă';
$txt['shd_urgency_5'] = 'Critice';
$txt['shd_urgency_increase'] = 'Creștere';
$txt['shd_urgency_decrease'] = 'Scade';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Nou';
$txt['shd_status_1'] = 'Comentariu în așteptare pentru personal';
$txt['shd_status_2'] = 'Comentariu utilizator în așteptare';
$txt['shd_status_3'] = 'Rezolvat/Închis';
$txt['shd_status_4'] = 'Referit la Supervizor';
$txt['shd_status_5'] = 'Escaladat - Urgent';
$txt['shd_status_6'] = 'Șters';
$txt['shd_status_7'] = 'În așteptare';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Bilete noi';
$txt['shd_status_1_heading'] = 'Bilete în așteptarea răspunsului personalului';
$txt['shd_status_2_heading'] = 'Bilete în așteptarea răspunsului utilizatorului';
$txt['shd_status_3_heading'] = 'Tichete închise';
$txt['shd_status_4_heading'] = 'Bilete referite la Supervizor';
$txt['shd_status_5_heading'] = 'Bilete urgente';
$txt['shd_status_6_heading'] = 'Tichete reciclate';
$txt['shd_status_7_heading'] = 'Pe Tichete';
$txt['shd_status_assigned_heading'] = 'Asignat la mine';
$txt['shd_status_withdeleted_heading'] = 'Bilete cu răspunsuri șterse';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Bilete deschise';
$txt['shd_tickets_closed'] = 'Tichete închise';
$txt['shd_tickets_recycled'] = 'Tichete reciclate';

$txt['shd_assigned'] = 'Atribuit';
$txt['shd_unassigned'] = 'Neatribuit';

$txt['shd_read_ticket'] = 'Bilet de citire';
$txt['shd_unread_ticket'] = 'Bilet necitit';
$txt['shd_unread_tickets'] = 'Tichete necitite';

$txt['shd_owned'] = 'Tichet Deținut'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'bilet';
$txt['shd_count_tickets'] = 'bilete';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Nu aveţi permisiunea de a accesa serviciul de asistenţă.';
$txt['shd_no_ticket'] = 'Biletul solicitat nu pare să existe.';
$txt['shd_no_reply'] = 'Răspunsul la bilet pe care îl aveți nu pare să existe sau nu face parte din acest tichet.';
$txt['shd_no_topic'] = 'Subiectul pe care l-ați solicitat nu pare să existe.';
$txt['shd_ticket_no_perms'] = 'Nu aveţi permisiunea de a vizualiza acest tichet.';
$txt['shd_error_no_tickets'] = 'Nu au fost gasite tichete.';
$txt['shd_inactive'] = 'Centrul de asistență este dezactivat în prezent.';
$txt['shd_cannot_assign'] = 'Nu aveţi permisiunea de a atribui bilete.';
$txt['shd_cannot_assign_other'] = 'Acest bilet este deja atribuit unui alt utilizator. Nu îl puteți realoca pentru dvs. - contactați administratorul.';
$txt['shd_no_staff_assign'] = 'Nu există personal configurat; nu este posibilă atribuirea unui tichet. Vă rugăm să contactați administratorul.';
$txt['shd_assigned_not_permitted'] = 'Utilizatorul pe care l-ați solicitat pentru a atribui acest bilet nu are suficiente permisiuni pentru a-l vedea.';
$txt['shd_cannot_resolve'] = 'Nu aveţi permisiunea de a marca acest tichet ca fiind rezolvat.';
$txt['shd_cannot_unresolve'] = 'Nu aveţi permisiunea de a redeschide un tichet rezolvat.';
$txt['error_shd_cannot_resolve_children'] = 'Acest bilet nu poate fi închis momentan; acest bilet este părintele unuia sau mai multor bilete care sunt deschise în prezent.';
$txt['error_shd_proxy_unknown'] = 'Utilizatorul acest tichet este postat in numele lui nu exista.';
$txt['shd_cannot_change_privacy'] = 'Nu ai permisiunea să modifici intimitatea pe acest tichet.';
$txt['shd_cannot_change_urgency'] = 'Nu aveţi permisiunea de a modifica caracterul urgent al acestui bilet.';
$txt['shd_ajax_problem'] = 'A apărut o eroare la încărcarea paginii. Doriți să încercați din nou?';
$txt['shd_cannot_move_ticket'] = 'Nu aveţi permisiunea de a muta acest tichet într-un subiect.';
$txt['shd_cannot_move_topic'] = 'Nu aveţi permisiunea de a muta acest subiect într-un tichet.';
$txt['shd_moveticket_noboards'] = 'Nu există nicio secţiune pentru a muta acest bilet!';
$txt['shd_move_no_pm'] = 'Trebuie să introduceţi un motiv pentru a muta biletul pentru a trimite către proprietarul tichetului, sau debifați opțiunea pentru a "trimite un PM către proprietarul tichetului".';
$txt['shd_move_no_pm_topic'] = 'Trebuie să introduceţi un motiv pentru a muta subiectul pentru a trimite la începutul subiectului, sau debifați opțiunea pentru a „trimite un PM la începutul subiectului”.';
$txt['shd_move_topic_not_created'] = 'Nu s-a reușit mutarea biletului în tablă. Vă rugăm să încercați din nou.';
$txt['shd_move_ticket_not_created'] = 'Nu s-a reușit mutarea subiectului în helpdesk. Vă rugăm să încercați din nou.';
$txt['shd_no_replies'] = 'Acest bilet nu are încă niciun răspuns.';
$txt['cannot_shd_new_ticket'] = 'Nu ai permisiunea sa creezi un tichet nou.';
$txt['cannot_shd_edit_ticket'] = 'Nu aveţi permisiunea de a edita acest tichet.';
$txt['shd_cannot_reply_any'] = 'Nu aveţi permisiunea de a răspunde la nici un tichet.';
$txt['shd_cannot_reply_any_but_own'] = 'Nu aveti permisiunea de a raspunde la alte tichete decat al dumneavoastra.';
$txt['shd_cannot_edit_reply_any'] = 'Nu aveţi permisiunea de a edita niciun răspuns.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Nu aveţi permisiunea de a edita răspunsurile la alte bilete în afara propriilor răspunsuri.';
$txt['shd_cannot_edit_closed'] = 'Nu puteți edita biletele rezolvate; trebuie să marcați mai întâi nerezolvate.';
$txt['shd_cannot_edit_deleted'] = 'Nu puteți edita biletele în coșul de gunoi. Vor trebui să fie restaurate mai întâi.';
$txt['shd_cannot_reply_closed'] = 'Nu puteți răspunde la biletele rezolvate; mai întâi trebuie să le marcați nerezolvate.';
$txt['shd_cannot_reply_deleted'] = 'Nu puteți răspunde la tichete în coșul de gunoi. Vor trebui să fie restaurate mai întâi.';
$txt['shd_cannot_delete_ticket'] = 'Nu aveţi permisiunea să ştergeţi acest tichet.';
$txt['shd_cannot_delete_reply'] = 'Nu aveţi permisiunea să ştergeţi acest răspuns.';
$txt['shd_cannot_restore_ticket'] = 'Nu aveţi permisiunea să restauraţi acest bilet de la coşul de gunoi.';
$txt['shd_cannot_restore_reply'] = 'Nu ai permisiunea să restaurezi acel răspuns de la coşul de gunoi.';
$txt['shd_cannot_view_resolved'] = 'Nu aveţi permisiunea de a accesa biletele rezolvate.';
$txt['cannot_shd_access_recyclebin'] = 'Nu puteți accesa coșul de gunoi.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Nu puteți muta acest bilet la forum; există unul sau mai multe răspunsuri șterse, la care permisiunile curente nu permit accesul.';
$txt['shd_cannot_attach_ext'] = 'Tipul de fișier pe care ai încercat să-l atașezi ({ext}) nu este permis aici. Tipurile permise de fișier sunt: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Acest tichet nu este momentan disponibil pentru modificare.';
$txt['shd_invalid_relation'] = 'Trebuie să furnizați un tip valid de relație pentru aceste bilete.';
$txt['shd_no_relation_delete'] = 'Nu puteți șterge o relație care nu există.';
$txt['shd_cannot_relate_self'] = 'Nu se poate face un bilet corelat cu el.';
$txt['shd_relationships_are_disabled'] = 'Relatiile dintre tichete sunt momentan dezactivate.';
$txt['error_invalid_fields'] = 'Următoarele câmpuri au valori care nu pot fi utilizate: %1$s';
$txt['error_missing_fields'] = 'Următoarele câmpuri nu au fost completate și trebuie să fie: %1$s';
$txt['error_missing_multi'] = '%1$s (cel puțin %2$d trebuie selectat)';
$txt['error_no_dept'] = 'Nu ați selectat un departament în care să postați acest tichet.';
$txt['shd_cannot_move_dept'] = 'Nu puteți muta acest bilet, nu există unde să îl mutați.';
$txt['shd_no_perm_move_dept'] = 'Nu aveţi permisiunea să mutaţi acest bilet la un alt departament.';
$txt['cannot_shd_delete_attachment'] = 'Nu aveţi permisiunea de a şterge ataşamente.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Nu puteți muta acest bilet într-un subiect; există câmpuri personalizate atașate care necesită un administrator pentru a confirma mutarea.';
$txt['cannot_monitor_ticket'] = 'Nu aveţi permisiunea să activaţi monitorizarea pentru acest tichet.';
$txt['cannot_unmonitor_ticket'] = 'Nu aveţi permisiunea să opriţi monitorizarea pentru acest tichet.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Helpdesk'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Departamente'; // ditto
$txt['shd_new_ticket'] = 'Postează un bilet nou';
$txt['shd_new_ticket_proxy'] = 'Posteaza Bilet proxy';
$txt['shd_helpdesk_profile'] = 'Profil Helpdesk';
$txt['shd_welcome'] = 'Bun venit, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Du-te la bon';
$txt['shd_options'] = 'Opţiuni';
$txt['shd_search_menu'] = 'Caută';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Informare';
$txt['shd_admin_options'] = 'Opţiuni';
$txt['shd_admin_custom_fields'] = 'Câmpuri personalizate';
$txt['shd_admin_departments'] = 'Departamente';
$txt['shd_admin_permissions'] = 'Permisiuni';
$txt['shd_admin_plugins'] = 'Extensii';
$txt['shd_admin_cannedreplies'] = 'Răspunsuri ajustate';
$txt['shd_admin_maint'] = 'Mentenanţă';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Aici puteţi înregistra bilete noi pentru ca personalul site-ului să acţioneze, şi verificaţi tichetele curente deja în curs.';
$txt['shd_staff_greeting'] = 'Aici sunt toate biletele care necesită atenţie.';
$txt['shd_shd_greeting'] = 'Acesta este Helpdesk. Aici îți pierzi timpul pentru a ajuta începătorii. Bucură-te de noi! ;D';
$txt['shd_closed_user_greeting'] = 'Acestea sunt toate biletele închise/rezolvate pe care le-ați postat pe helpdesk.';
$txt['shd_closed_staff_greeting'] = 'Toate acestea sunt bilete închise/rezolvate trimise la helpdesk.';
$txt['shd_category_filter'] = 'Filtrare categorie';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Biletul tău a fost creat!';
$txt['shd_ticket_posted_body'] = 'Îți mulțumim că ai postat biletul, {membername}!' . "\n\n" . 'Personalul biroului de asistență îl va examina și vă va contacta cât mai curând posibil.' . "\n\n" . 'Între timp, îți poți vedea biletul, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; la următorul URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Deschideți un alt bilet[/iurl] format@@0 [iurl={helpdesklink}]Înapoi la centrul de asistență[/iurl] <unk> [iurl={forumlink}]Înapoi la forumul[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Puteți activa notificările prin e-mail cu privire la modificările aduse tichetului dvs., în zona [iurl={prefslink}]Preferințe Helpdesk[/iurl]';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Înscrieri,' . "\n" . 'Echipa {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Detalii tichet';
$txt['shd_ticket_updated'] = 'Actualizat';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Nume';
$txt['shd_ticket_user'] = 'Utilizator';
$txt['shd_ticket_date'] = 'Postat';
$txt['shd_ticket_urgency'] = 'Urgență';
$txt['shd_ticket_assigned'] = 'Atribuit';
$txt['shd_ticket_assignedto'] = 'Atribuit lui';
$txt['shd_ticket_started_by'] = 'Început de';
$txt['shd_ticket_updated_by'] = 'Actualizat de';
$txt['shd_ticket_status'] = 'Status';
$txt['shd_ticket_num_replies'] = 'Răspunsuri';
$txt['shd_ticket_replies'] = 'Răspunsuri';
$txt['shd_ticket_staff'] = 'Membru al personalului';
$txt['shd_ticket_attachments'] = 'Atașamente';
$txt['shd_ticket_reply_number'] = 'Răspuns <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Bilet în așteptare';
$txt['shd_ticket'] = 'Bilet';
$txt['shd_reply_written'] = 'Răspuns scris %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Niciodată';
$txt['shd_linktree_tickets'] = 'Bilete';
$txt['shd_ticket_privacy'] = 'Confidențialitate';
$txt['shd_ticket_notprivate'] = 'Nu e privat';
$txt['shd_ticket_private'] = 'Privat';
$txt['shd_ticket_change'] = 'Schimbă';
$txt['shd_ticket_ip'] = 'Adresa IP';
$txt['shd_back_to_hd'] = 'Înapoi la centrul de asistență';
$txt['shd_go_to_replies'] = 'Du-te la răspunsuri';
$txt['shd_go_to_action_log'] = 'Du-te la jurnalul de acțiuni';
$txt['shd_go_to_replies_start'] = 'Mergi la primul răspuns';

$txt['shd_ticket_has_been_deleted'] = 'Acest bilet este în prezent în recycle bin și nu poate fi modificat fără a fi returnat la helpdesk.';
$txt['shd_ticket_replies_deleted'] = 'Acest bilet a fost șters anterior.';
$txt['shd_ticket_replies_deleted_view'] = 'Acestea sunt afișate cu un fundal colorat. <a href="%1$s">Vizualizați biletul fără ștergeri</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Vă rugăm să <a href="%1$s">faceţi clic aici</a> pentru a le vedea.';

$txt['shd_ticket_notnew'] = 'Ați văzut deja acest lucru';
$txt['shd_ticket_new'] = 'Nou!';

$txt['shd_linktree_move_ticket'] = 'Mută biletul';
$txt['shd_linktree_move_topic'] = 'Mută subiectul în helpdesk';

$txt['shd_cancel_ticket'] = 'Anulează și întoarce-te la bon';
$txt['shd_cancel_home'] = 'Anulează și întoarce-te la centrul de asistență';
$txt['shd_cancel_topic'] = 'Anulează și reîntoarce-te la subiect';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Răspunde la bon';
$txt['shd_ticket_quote'] = 'Răspunde cu o ofertă';
$txt['shd_go_advanced'] = 'Mergi mai departe!';
$txt['shd_ticket_edit_reply'] = 'Editare răspuns';
$txt['shd_ticket_quote_short'] = 'Ofertă';
$txt['shd_ticket_markunread'] = 'Marchează necitit';
$txt['shd_ticket_reply_short'] = 'Răspuns';
$txt['shd_ticket_edit'] = 'Editare';
$txt['shd_ticket_resolved'] = 'Marcare rezolvată';
$txt['shd_ticket_unresolved'] = 'Marchează nerezolvat';
$txt['shd_ticket_assign'] = 'Atribuiți';
$txt['shd_ticket_assign_self'] = 'Atribuie mie';
$txt['shd_ticket_reassign'] = 'Re-atribuire';
$txt['shd_ticket_unassign'] = 'De-asignare';
$txt['shd_ticket_delete'] = 'Ștergere';
$txt['shd_delete_confirm'] = 'Sunteţi sigur că doriţi să ştergeţi acest bilet? Dacă ştergeţi, acest bilet va fi mutat la coşul de reciclare.';
$txt['shd_delete_reply_confirm'] = 'Sunteţi sigur că doriţi să ştergeţi acest răspuns? Dacă ştergeţi, acest răspuns va fi mutat la coşul de reciclare.';
$txt['shd_delete_attach_confirm'] = 'Sunteţi sigur că doriţi să ştergeţi acest ataşament? (Acest lucru nu poate fi anulat!)';
$txt['shd_delete_attach'] = 'Ștergeți acest atașament';
$txt['shd_ticket_restore'] = 'Restaurează';
$txt['shd_delete_permanently'] = 'Șterge permanent';
$txt['shd_delete_permanently_confirm'] = 'Sunteţi sigur că doriţi să ştergeţi definitiv acest tichet? Acest lucru NU POATE fi anulat!';
$txt['shd_ticket_move_to_topic'] = 'Mutare în subiect';
$txt['shd_move_dept'] = 'Mutați pasul.';
$txt['shd_actions'] = 'Acțiuni';
$txt['shd_back_to_ticket'] = 'Reveniți la acest tichet după postare';
$txt['shd_disable_smileys_post'] = 'Opriţi emoticoanele din acest post';
$txt['shd_resolve_this_ticket'] = 'Marchează acest tichet ca rezolvat';
$txt['shd_override_cf'] = 'Suprascrie cerinţele câmpurilor personalizate';
$txt['shd_silent_update'] = 'Actualizare silențioasă (fără notificări)';
$txt['shd_select_notifications'] = 'Selectează persoane de notificat despre acest răspuns...';

$txt['shd_ticket_assign_ticket'] = 'Atribuire bilet';
$txt['shd_ticket_assign_to'] = 'Atribuiți biletul la';

$txt['shd_ticket_move_dept'] = 'Mutați biletul la un alt departament';
$txt['shd_ticket_move_to'] = 'Mutare în';
$txt['shd_current_dept'] = 'În prezent în departament';
$txt['shd_ticket_move'] = 'Mută biletul';
$txt['shd_unknown_dept'] = 'Departamentul specificat nu există.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Subiect nou';
$txt['shd_move_ticket_to_topic'] = 'Mută biletul la subiect';
$txt['shd_move_ticket'] = 'Mută biletul';
$txt['shd_ticket_board'] = 'Secţiune';
$txt['shd_change_ticket_subject'] = 'Schimbă subiectul biletului';
$txt['shd_move_send_pm'] = 'Trimite un PM proprietarului biletului';
$txt['shd_move_why'] = 'Vă rugăm să introduceţi o scurtă descriere pentru care acest bilet este mutat într-un subiect de forum.';
$txt['shd_ticket_moved_subject'] = 'Biletul tău a fost mutat.';
$txt['shd_move_default'] = 'Bună ziua {user},' . "\n\n" . 'Biletul tău, {subject}, a fost mutat de la centrul de asistență la un subiect din forum.' . "\n" . 'Poți găsi biletul tău în secțiunea {board} sau prin intermediul acestui link:' . "\n\n" . '{link}' . "\n\n" . 'Mulțumim';

$txt['shd_move_topic_to_ticket'] = 'Mută subiectul în helpdesk';
$txt['shd_move_topic'] = 'Mută subiectul';
$txt['shd_change_topic_subject'] = 'Schimbă subiectul';
$txt['shd_move_send_pm_topic'] = 'Trimite un PM la începutul subiectului';
$txt['shd_move_why_topic'] = 'Vă rugăm să introduceţi o scurtă descriere de ce acest subiect este mutat în helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Subiectul dvs. a fost mutat.';
$txt['shd_move_default_topic'] = 'Bună ziua {user},' . "\n\n" . 'Subiectul dvs., {subject}, a fost mutat de pe forum în secțiunea Helpdesk.' . "\n" . 'Poți găsi subiectul tău prin intermediul acestui link:' . "\n\n" . '{link}' . "\n\n" . 'Mulțumim';

$txt['shd_user_no_hd_access'] = 'Notă: persoana care a început acest subiect nu poate vedea helpdesk!';
$txt['shd_user_helpdesk_access'] = 'Persoana care a început acest subiect poate vedea helpdesk-ul.';
$txt['shd_user_hd_access_dept_1'] = 'Persoana care a început acest subiect poate vedea următorul departament: ';
$txt['shd_user_hd_access_dept'] = 'Persoana care a început acest subiect poate vedea următoarele departamente: ';
$txt['shd_move_ticket_department'] = 'Mută biletul la care departament';
$txt['shd_move_dept_why'] = 'Vă rugăm să introduceţi o scurtă descriere cu privire la motivul pentru care acest bilet este mutat într-un alt departament.';
$txt['shd_move_dept_default'] = 'Bună ziua {user},' . "\n\n" . 'Biletul dvs., {subject}, a fost mutat din departamentul {current_dept} în departamentul {new_dept}.' . "\n" . 'Poti gasi biletul tau prin acest link:' . "\n\n" . '{link}' . "\n\n" . 'Mulțumim';

$txt['shd_ticket_move_deleted'] = 'Acest bilet are răspunsuri care sunt în prezent în coşul de gunoi. Ce doriţi să faceţi?';
$txt['shd_ticket_move_deleted_abort'] = 'Abandonează, du-mă la coşul de gunoi';
$txt['shd_ticket_move_deleted_delete'] = 'Continuați, abandonați răspunsurile șterse (nu le mutați în noul subiect)';
$txt['shd_ticket_move_deleted_undelete'] = 'Continuă, anulează răspunsurile (mută-le în noul subiect)';

$txt['shd_ticket_move_cfs'] = 'Acest bilet are câmpuri personalizate care pot necesita să fie mutate.';
$txt['shd_ticket_move_cfs_warn'] = 'Este posibil ca unele dintre aceste câmpuri să nu fie vizibile altor utilizatori. Aceste câmpuri sunt indicate cu un semn de exclamare.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Puteţi vedea acest câmp, alţi utilizatori nu pot - dar odată ce a devenit parte a forumului, va deveni vizibilă pentru toţi cei care pot accesa forumul.';
$txt['shd_ticket_move_cfs_purge'] = 'Ştergeţi conţinutul câmpului';
$txt['shd_ticket_move_cfs_embed'] = 'Păstrați câmpul și puneți-l în tema nouă';
$txt['shd_ticket_move_cfs_user'] = 'Vizibil în prezent pentru utilizatorii obișnuiți';
$txt['shd_ticket_move_cfs_staff'] = 'Vizibil în prezent pentru membrii personalului';
$txt['shd_ticket_move_cfs_admin'] = 'Vizibil în prezent pentru administratori';
$txt['shd_ticket_move_accept'] = 'Accept ca unele dintre campurile manipulate aici nu sunt vizibile pentru toti utilizatorii, şi că acest subiect trebuie mutat în forum, cu setările de mai sus.';
$txt['shd_ticket_move_reqd'] = 'Aceasta optiune trebuie selectata pentru a muta acest tichet pe forum.';
$txt['shd_ticket_move_ok'] = 'Acest câmp este sigur pentru mutare, toţi utilizatorii care pot vedea biletul pot vedea acest câmp, nu există informații ascunse de utilizatori sau de personal.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Acest bilet are câmpuri pe care utilizatorii sau personalul nu le pot vedea, ca atare, trebuie să confirmați că sunteți conștient de acest lucru - vă rugăm să reveniți la pagina anterioară, caseta de selectare pentru confirmarea conştientizării acestui lucru se află la baza formularului.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Coş de gunoi';
$txt['shd_recycle_greeting'] = 'Acesta este coșul de reciclare. Toate biletele șterse merg aici, dar membrii personalului cu permisiuni speciale pot elimina permanent tichetele de aici.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Creează tichet';
$txt['shd_edit_ticket'] = 'Editare bon';
$txt['shd_edit_ticket_linktree'] = 'Editare bon (%s)';
$txt['shd_ticket_subject'] = 'Subiect tichet';
$txt['shd_ticket_proxy'] = 'Postează în numele';
$txt['shd_ticket_post_error'] = 'Următoarea problemă, sau probleme, a apărut în timp ce se încerca postarea acestui bilet';
$txt['shd_reply_ticket'] = 'Răspunde la bon';
$txt['shd_reply_ticket_linktree'] = 'Răspunde la tichet (%s)';
$txt['shd_edit_reply_linktree'] = 'Editare răspuns (%s)';
$txt['shd_previewing_ticket'] = 'Previzualizare bon';
$txt['shd_previewing_reply'] = 'Previzualizare răspuns la';
$txt['shd_choose_one'] = '[Alege unul]';
$txt['shd_no_value'] = '[nici o valoare]';
$txt['shd_ticket_dept'] = 'Departament tichet';
$txt['shd_select_dept'] = '-- Selectați un departament --';
$txt['canned_replies'] = 'Se adaugă un răspuns predefinit:';
$txt['canned_replies_select'] = '-- Selectați un răspuns --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Răspunsuri la Helpdesk postate de la IP (clasă)';
$txt['shd_no_replies_from_ip'] = 'Nu s-au găsit răspunsuri helpdesk de la IP-ul (clasa) specificat';
$txt['shd_replies_from_ip_desc'] = 'Mai jos este o listă cu toate mesajele postate la centrul de asistență de la acest IP (clasă).';
$txt['shd_is_ticket_opener'] = ' (început bilet)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'Arhivă BZip2';
$txt['shd_attachtype_gz'] = 'Arhiva GZip';
$txt['shd_attachtype_rar'] = 'Arhivă Rar/WinRAR';
$txt['shd_attachtype_zip'] = 'Arhiva poștală';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'Fișier audio MP3 (MPEG Layer III)';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Imagine Bitmap Windows';
$txt['shd_attachtype_gif'] = 'Imaginea de conversie grafică (GIF)';
$txt['shd_attachtype_jpeg'] = 'Imaginea grupului comun de experți fotografici (JPEG)';
$txt['shd_attachtype_jpg'] = 'Imaginea grupului comun de experți fotografici (JPEG)';
$txt['shd_attachtype_png'] = 'Imaginea grafică a rețelei portabile (PNG)';
$txt['shd_attachtype_svg'] = 'Imaginea Scalable Vector Grafic (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Video film';
// Office formats
$txt['shd_attachtype_doc'] = 'Document Word Microsoft';
$txt['shd_attachtype_mdb'] = 'Baza de date cu acces Microsoft';
$txt['shd_attachtype_ppt'] = 'Prezentare Microsoft Powerpoint';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'Fișier sursă C++';
$txt['shd_attachtype_php'] = 'Script PHP';
$txt['shd_attachtype_py'] = 'Fișier sursă Python';
$txt['shd_attachtype_rb'] = 'Fișier sursă Ruby';
$txt['shd_attachtype_sql'] = 'Script SQL';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (arhiva KML)';
$txt['shd_attachtype_pdf'] = 'Fișier document portabil Adobe Acrobat';
$txt['shd_attachtype_psd'] = 'Document Photoshop Adobe';
$txt['shd_attachtype_swf'] = 'Fişier Adobe Flash';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Fișier executabil (Windows)';
$txt['shd_attachtype_htm'] = 'Document de Markup Hypertext (HTML)';
$txt['shd_attachtype_html'] = 'Document de Markup Hypertext (HTML)';
$txt['shd_attachtype_rtf'] = 'Format text îmbogățit (RTF)';
$txt['shd_attachtype_txt'] = 'Text simplu';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Jurnal actiuni tichet';
$txt['shd_ticket_log_count_one'] = '1 intrare';
$txt['shd_ticket_log_count_more'] = '%s intrări';
$txt['shd_ticket_log_none'] = 'Acest bilet nu a suferit nicio modificare.';
$txt['shd_ticket_log_member'] = 'Membru';
$txt['shd_ticket_log_ip'] = 'Membru IP:';
$txt['shd_ticket_log_date'] = 'Data';
$txt['shd_ticket_log_action'] = 'Acțiune';
$txt['shd_ticket_log_full'] = 'Mergeți la jurnalul complet de acțiuni (toate biletele)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Tichete asociate';
$txt['shd_ticket_create_relationship'] = 'Creaza relatie';
$txt['shd_ticket_delete_relationship'] = 'Șterge relația';
$txt['shd_ticket_reltype'] = 'selectează tip';
$txt['shd_ticket_reltype_linked'] = 'Legat de';
$txt['shd_ticket_reltype_duplicated'] = 'Duplicat al';
$txt['shd_ticket_reltype_parent'] = 'Părinte al';
$txt['shd_ticket_reltype_child'] = 'Copilul lui';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Informaţii suplimentare';
$txt['shd_ticket_additional_details'] = 'Detalii suplimentare';
$txt['shd_ticket_empty_field'] = 'Acest câmp este gol.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Notificări';
$txt['shd_ticket_notify_noneprefs'] = 'Preferințele dvs. de utilizare nu contează pentru notificarea acestui tichet.';
$txt['shd_ticket_notify_changeprefs'] = 'Modificați preferințele';
$txt['shd_ticket_notify_because'] = 'Preferințele dvs. indică notificarea răspunsurilor la acest tichet:';
$txt['shd_ticket_notify_because_yourticket'] = 'pentru că este biletul tău';
$txt['shd_ticket_notify_because_assignedyou'] = 'așa cum vă este atribuit';
$txt['shd_ticket_notify_because_priorreply'] = 'așa cum ați răspuns la el înainte';
$txt['shd_ticket_notify_because_anyreply'] = 'pentru orice bilet';

$txt['shd_ticket_notify_me_always'] = 'Urmăriți acest bilet (și veți primi o notificare cu privire la fiecare răspuns)';
$txt['shd_ticket_monitor_on_note'] = 'Puteți monitoriza toate răspunsurile la acest bilet prin e-mail, indiferent de preferințele dvs.:';
$txt['shd_ticket_monitor_off_note'] = 'Puteți dezactiva monitorizarea pentru acest tichet și să folosiți preferințele în schimb:';
$txt['shd_ticket_monitor_on'] = 'Activați monitorizarea';
$txt['shd_ticket_monitor_off'] = 'Opriți monitorizarea';
$txt['shd_ticket_notify_me_never_note'] = 'Puteți ignora actualizările prin e-mail pentru acest bilet, indiferent de preferințele dvs.:';
$txt['shd_ticket_notify_me_never'] = 'Ați oprit toate notificările pentru acest tichet.';
$txt['shd_ticket_notify_me_never_on'] = 'Dezactivați notificările';
$txt['shd_ticket_notify_me_never_off'] = 'Porniți notificările';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Este posibil ca centrul de căutare să nu afișeze toate biletele disponibile; acesta este în curs de investigare.';
$txt['shd_search_warning_admin'] = 'Facilitatea de căutare necesită ca indexul său să fie reconstruit. Puteţi realiza acest lucru din opţiunea de întreţinere, în zona de asistenţă, în panoul de administrare.';
$txt['shd_search'] = 'Cauta Bilete';
$txt['shd_search_results'] = 'Căutare Bilete - Rezultate';
$txt['shd_search_text'] = 'Cuvinte pe care le cauți:';
$txt['shd_search_match'] = 'Ce ar trebui să se potrivească?';
$txt['shd_search_match_all'] = 'Potrivește toate cuvintele furnizate';
$txt['shd_search_match_any'] = 'Potriviți orice cuvinte furnizate';
$txt['shd_search_scope'] = 'Include tipurile de bilete:';
$txt['shd_search_scope_open'] = 'Bilete deschise';
$txt['shd_search_scope_closed'] = 'Bilete închise';
$txt['shd_search_scope_recycle'] = 'Elemente în coşul de gunoi';
$txt['shd_search_result_ticket'] = 'Tichet %1$s';
$txt['shd_search_result_reply'] = 'Răspunde la tichet %1$s';
$txt['shd_search_last_updated'] = 'Ultima actualizare:';
$txt['shd_search_ticket_opened_by'] = 'Tichet deschis de:';
$txt['shd_search_ticket_replied_by'] = 'Tichetul a raspuns la:';
$txt['shd_search_dept'] = 'Caută în ce departament(e):';

$txt['shd_search_urgency'] = 'Se includ nivelurile de urgență:';

$txt['shd_search_where'] = 'Care elemente de căutat:';
$txt['shd_search_where_tickets'] = 'Corpurile biletelor';
$txt['shd_search_where_replies'] = 'Răspunsurile la bilete';
$txt['shd_search_where_subjects'] = 'Subiecţi tichet';

$txt['shd_search_ticket_starter'] = 'Bilete începute de:';
$txt['shd_search_ticket_assignee'] = 'Tichete atribuite pentru:';
$txt['shd_search_ticket_named_person'] = 'Scrieți numele persoanei (persoanelor) care vă interesează.';

$txt['shd_search_no_results'] = 'Nu au fost găsite rezultate cu criteriile date. S-ar putea să doriți să reveniți și să încercați să modificați criteriile de căutare.';
$txt['shd_search_criteria'] = 'Criteriu de căutare:';
$txt['shd_search_excluded'] = 'Dacă toate opțiunile posibile au fost selectate, acestea nu au fost incluse în cele de mai sus (de ex. dacă se bifează toate nivelurile de urgenţă posibile, aceasta nu este menţionată mai sus, astfel încât să vă puteţi concentra asupra a ceea ce este specific căutării dumneavoastră)';
//@}