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
$txt['shd_helpdesk'] = 'Brukerstøtte';
$txt['shd_helpdesk_maintenance'] = 'helpdesk er i <strong>vedlikeholdsmodus</strong>. Kun forum og administrator kan se dette.';
$txt['shd_open_ticket'] = 'åpne sak';
$txt['shd_open_tickets'] = 'åpne billetter';
$txt['shd_none'] = 'Ingen';

$txt['shd_display_nojs'] = 'JavaScript er ikke aktivert i nettleseren. Det kan hende at noen funksjoner ikke fungerer riktig (eller i det hele tatt), eller oppfører seg på en uventet måte.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Velkommen til administrasjonssenteret for hovedhjelpesenter!';
$txt['shd_admin_title'] = 'Helpdesk administrasjonssenter';
$txt['shd_staff_list'] = 'Helpdesk ansatte';
$txt['shd_update_available'] = 'Ny versjon tilgjengelig!';
$txt['shd_update_message'] = 'En ny versjon av SimpleDesk er løslatt. Vi anbefalte deg å <a href="#" id="update-link">oppdatere til den nyeste versjonen</a> for å holde deg sikker, og for alle funksjoner vår modifikasjon må vi ha tilbud.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>For mer informasjon om hva som er ny i denne utgivelsen, vennligst besøk <a href="#" id="information-link" target="_blank">vår nettside</a>.</span><br>' . "\n\n" . '<strong>The SimpleDesk Team</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Lav';
$txt['shd_urgency_1'] = 'Middels';
$txt['shd_urgency_2'] = 'Høy';
$txt['shd_urgency_3'] = 'Svært høy';
$txt['shd_urgency_4'] = 'Kraftig';
$txt['shd_urgency_5'] = 'Kritisk';
$txt['shd_urgency_increase'] = 'Øk';
$txt['shd_urgency_decrease'] = 'Reduser';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Ny';
$txt['shd_status_1'] = 'Ventende medarbeideres kommentar';
$txt['shd_status_2'] = 'Ventende kommentar';
$txt['shd_status_3'] = 'Løst/Lukket';
$txt['shd_status_4'] = 'Henvist til leder';
$txt['shd_status_5'] = 'Eskalert - Haster';
$txt['shd_status_6'] = 'Slettet';
$txt['shd_status_7'] = 'På vent';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Nye saker';
$txt['shd_status_1_heading'] = 'Saker ventende personalets svar';
$txt['shd_status_2_heading'] = 'Saker ventende brukerrespons';
$txt['shd_status_3_heading'] = 'Lukkede saker';
$txt['shd_status_4_heading'] = 'Saker Referert til Supervisor';
$txt['shd_status_5_heading'] = 'Haster billetter';
$txt['shd_status_6_heading'] = 'Gjenbrukt billetter';
$txt['shd_status_7_heading'] = 'På ventende saker';
$txt['shd_status_assigned_heading'] = 'Tilordne til meg';
$txt['shd_status_withdeleted_heading'] = 'Saker med slettede svar';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Åpne saker';
$txt['shd_tickets_closed'] = 'Lukkede saker';
$txt['shd_tickets_recycled'] = 'Gjenbrukt billetter';

$txt['shd_assigned'] = 'Tildelt';
$txt['shd_unassigned'] = 'Utilegnet';

$txt['shd_read_ticket'] = 'Lese sak';
$txt['shd_unread_ticket'] = 'Ulest sak';
$txt['shd_unread_tickets'] = 'Ulest saker';

$txt['shd_owned'] = 'Eid sak'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'billett';
$txt['shd_count_tickets'] = 'saker';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Du har ikke tilgang til helpdesken.';
$txt['shd_no_ticket'] = 'Billetten du har bedt om, ser ikke ut til å eksistere.';
$txt['shd_no_reply'] = 'Sakssvaret du har forespørselen virker ikke å finne, eller er ikke en del av denne saken.';
$txt['shd_no_topic'] = 'Det emnet du har bedt om, ser ikke ut til å eksistere.';
$txt['shd_ticket_no_perms'] = 'Du har ikke tillatelse til å se den saken.';
$txt['shd_error_no_tickets'] = 'Ingen saker ble funnet.';
$txt['shd_inactive'] = 'helpdesk er for øyeblikket deaktivert.';
$txt['shd_cannot_assign'] = 'Du har ikke rettigheter til å tilknytte saker.';
$txt['shd_cannot_assign_other'] = 'Billetten er allerede tildelt en annen bruker. Du kan ikke tilordne den til deg selv - kontakt administrator.';
$txt['shd_no_staff_assign'] = 'Det er ingen ansatte konfigurert; det er ikke mulig å tilordne en sak. Kontakt systemansvarlig.';
$txt['shd_assigned_not_permitted'] = 'Brukeren du har bedt om å tildele denne billetten har ikke tilstrekkelige rettigheter til å se den.';
$txt['shd_cannot_resolve'] = 'Du har ikke tillatelse til å merke denne saken som løst.';
$txt['shd_cannot_unresolve'] = 'Du har ikke tillatelse til å gjenåpne en løst sak.';
$txt['error_shd_cannot_resolve_children'] = 'Denne billetten kan ikke lukkes. Denne billetten er foreldet til en eller flere saker som er åpne.';
$txt['error_shd_proxy_unknown'] = 'Brukeren denne billetten er postet på vegne av finnes ikke.';
$txt['shd_cannot_change_privacy'] = 'Du har ikke tillatelse til å endre personvernet i denne saken.';
$txt['shd_cannot_change_urgency'] = 'Du har ikke tillatelse til å endre prioriteten på denne saken.';
$txt['shd_ajax_problem'] = 'Det oppsto et problem med å laste siden. Ønsker du å prøve på nytt?';
$txt['shd_cannot_move_ticket'] = 'Du har ikke tillatelse til å flytte denne billetten til et emne.';
$txt['shd_cannot_move_topic'] = 'Du har ikke tillatelse til å flytte dette emnet til en sak.';
$txt['shd_moveticket_noboards'] = 'Det er ingen tavler å flytte denne saken til!';
$txt['shd_move_no_pm'] = 'Du må angi en grunn for å flytte saken for å sende til sakens eier, eller fjern markeringen for \'send en PM til sakens eier\'.';
$txt['shd_move_no_pm_topic'] = 'Du må angi en grunn til å flytte emnet til å sende til emnester, eller fjern haken for å \'sende en PM til emnet starter\'.';
$txt['shd_move_topic_not_created'] = 'Kan ikke flytte sak til tavlen. Vennligst prøv igjen.';
$txt['shd_move_ticket_not_created'] = 'Kunne ikke flytte emnet til helpdesk. Prøv på nytt.';
$txt['shd_no_replies'] = 'Denne billetten har ikke noen svar enda.';
$txt['cannot_shd_new_ticket'] = 'Du har ikke tillatelse til å opprette en ny sak.';
$txt['cannot_shd_edit_ticket'] = 'Du har ikke tillatelse til å redigere denne saken.';
$txt['shd_cannot_reply_any'] = 'Du har ikke tillatelse til å svare på noen saker.';
$txt['shd_cannot_reply_any_but_own'] = 'Du har ikke tillatelse til å svare på noen saker annet enn din egen.';
$txt['shd_cannot_edit_reply_any'] = 'Du har ikke tillatelse til å redigere noen svar.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Du har ikke tillatelse til å redigere svar til noen saker annet enn dine egne svar.';
$txt['shd_cannot_edit_closed'] = 'Du kan ikke redigere løste saker; du må merke den uløste først.';
$txt['shd_cannot_edit_deleted'] = 'Du kan ikke redigere saker i papirkurven. De må gjenopprettes først.';
$txt['shd_cannot_reply_closed'] = 'Du kan ikke svare på løste saker; du må merke dem som ikke er løst først.';
$txt['shd_cannot_reply_deleted'] = 'Du kan ikke svare på saker i papirkurven. De må gjenopprettes først.';
$txt['shd_cannot_delete_ticket'] = 'Du har ikke rettigheter til å slette denne saken.';
$txt['shd_cannot_delete_reply'] = 'Du har ikke rettigheter til å slette dette svaret.';
$txt['shd_cannot_restore_ticket'] = 'Du har ikke rettigheter til å gjenopprette denne billetten fra papirkurven.';
$txt['shd_cannot_restore_reply'] = 'Du har ikke rettigheter til å gjenopprette dette svaret fra papirkurven.';
$txt['shd_cannot_view_resolved'] = 'Du har ikke tilgang til å få tilgang til saker som er løst.';
$txt['cannot_shd_access_recyclebin'] = 'Du kan ikke bruke papirkurven.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Du kan ikke flytte denne billetten til forumet; ett eller flere slettede svar som ikke tillater tilgang til de gjeldende tillatelsene.';
$txt['shd_cannot_attach_ext'] = 'Typen fil du har prøvd å legge ved ({ext}) kan ikke tillates her. De tillatte filtypene er: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Denne billetten er for øyeblikket ikke tilgjengelig for endringer.';
$txt['shd_invalid_relation'] = 'Du må oppgi en gyldig type relasjon for disse sakene.';
$txt['shd_no_relation_delete'] = 'Du kan ikke slette et forhold som ikke finnes.';
$txt['shd_cannot_relate_self'] = 'Du kan ikke gjøre en sak relatert til seg selv.';
$txt['shd_relationships_are_disabled'] = 'Saks forhold er for øyeblikket deaktivert.';
$txt['error_invalid_fields'] = 'Følgende felt har verdier som ikke kan brukes: %1$s';
$txt['error_missing_fields'] = 'Følgende felt ble ikke fullført og må være: %1$s';
$txt['error_missing_multi'] = '%1$s (minst %2$d må velges';
$txt['error_no_dept'] = 'Du valgte ikke en avdeling å poste denne billetten i.';
$txt['shd_cannot_move_dept'] = 'Du kan ikke flytte denne billetten, det er ingen steder å flytte den til.';
$txt['shd_no_perm_move_dept'] = 'Du har ikke tillatelse til å flytte denne saken til en annen avdeling.';
$txt['cannot_shd_delete_attachment'] = 'Du har ikke rettigheter til å slette vedlegg.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Du kan ikke flytte denne billetten til et emne, egendefinerte felt som er vedlagte som krever en administrator for å bekrefte bevegelsen.';
$txt['cannot_monitor_ticket'] = 'Du har ikke rettigheter til å aktivere overvåking for denne saken.';
$txt['cannot_unmonitor_ticket'] = 'Du har ikke tillatelse til å slå av overvåking for denne saken.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Brukerstøtte'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Avdelinger'; // ditto
$txt['shd_new_ticket'] = 'Post ny sak';
$txt['shd_new_ticket_proxy'] = 'Postens mellomtjener sak';
$txt['shd_helpdesk_profile'] = 'Helpdesk Profil';
$txt['shd_welcome'] = 'Velkommen, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Gå til billett';
$txt['shd_options'] = 'Alternativer';
$txt['shd_search_menu'] = 'Søk';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Informasjon';
$txt['shd_admin_options'] = 'Alternativer';
$txt['shd_admin_custom_fields'] = 'Egendefinerte felt';
$txt['shd_admin_departments'] = 'Avdelinger';
$txt['shd_admin_permissions'] = 'Tillatelser';
$txt['shd_admin_plugins'] = 'Utvidelser';
$txt['shd_admin_cannedreplies'] = 'Standard svar';
$txt['shd_admin_maint'] = 'Vedlikehold';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Her kan du sende nye saker til nettstedets medarbeidere, og sjekke aktuelle saker allerede er i gang.';
$txt['shd_staff_greeting'] = 'Her er alle saker som krever oppmerksomhet.';
$txt['shd_shd_greeting'] = 'Dette er Helpdesk. Her kaster du bort tiden din for å hjelpe nyheter. Nyhet! ;D';
$txt['shd_closed_user_greeting'] = 'Dette er alle lukket/løste saker du har postet på helpdesk.';
$txt['shd_closed_staff_greeting'] = 'Disse er lukket/løst saker sendt inn til helpdesken.';
$txt['shd_category_filter'] = 'Kategori filtrering';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Billetten din er opprettet!';
$txt['shd_ticket_posted_body'] = 'Takk for at du postet din billett, {membername}!' . "\n\n" . 'helpdesk-ansatte vil gjennomgå det og komme tilbake til deg så snart som mulig.' . "\n\n" . 'I mellomtiden kan du vise din billett, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; på følgende URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Åpne en annen billett[/iurl] ause [iurl={helpdesklink}]Tilbake til hovedhelpdesk[/iurl] ε[iurl={forumlink}]Tilbake til forumet[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Du kan slå på e-postvarsler om endringer i billetten din, i [iurl={prefslink}]Helpdesk Preferences[/iurl] -området.';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Hilsen' . "\n" . '{forum_name} teamet.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Saks detaljer';
$txt['shd_ticket_updated'] = 'Oppdatert';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Navn';
$txt['shd_ticket_user'] = 'Bruker';
$txt['shd_ticket_date'] = 'Postet';
$txt['shd_ticket_urgency'] = 'Hastverk';
$txt['shd_ticket_assigned'] = 'Tildelt';
$txt['shd_ticket_assignedto'] = 'Tilordnet til';
$txt['shd_ticket_started_by'] = 'Startet av';
$txt['shd_ticket_updated_by'] = 'Oppdatert av';
$txt['shd_ticket_status'] = 'Status:';
$txt['shd_ticket_num_replies'] = 'Svar';
$txt['shd_ticket_replies'] = 'Svar';
$txt['shd_ticket_staff'] = 'Medarbeidermedlem';
$txt['shd_ticket_attachments'] = 'Vedlegg';
$txt['shd_ticket_reply_number'] = 'Svar <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Billett på-holde';
$txt['shd_ticket'] = 'Billett';
$txt['shd_reply_written'] = 'Svar skrevet %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Aldri';
$txt['shd_linktree_tickets'] = 'Saker';
$txt['shd_ticket_privacy'] = 'Personvern';
$txt['shd_ticket_notprivate'] = 'Ikke privat';
$txt['shd_ticket_private'] = 'Privat';
$txt['shd_ticket_change'] = 'Endre';
$txt['shd_ticket_ip'] = 'IP adresse';
$txt['shd_back_to_hd'] = 'Tilbake til helpdesk';
$txt['shd_go_to_replies'] = 'Gå til svar';
$txt['shd_go_to_action_log'] = 'Gå til handlingslogg';
$txt['shd_go_to_replies_start'] = 'Gå til første svar';

$txt['shd_ticket_has_been_deleted'] = 'Denne billetten er i papirkurven og kan ikke endres uten å bli returnert til helpdesken.';
$txt['shd_ticket_replies_deleted'] = 'Denne billetten har blitt slettet fra det tidligere.';
$txt['shd_ticket_replies_deleted_view'] = 'Disse vises med en farget bakgrunn. <a href="%1$s">Se saken uten slettinger</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Vennligst <a href="%1$s">klikk her</a> for å se dem.';

$txt['shd_ticket_notnew'] = 'Du har allerede sett dette';
$txt['shd_ticket_new'] = 'Ny!';

$txt['shd_linktree_move_ticket'] = 'Flytte billett';
$txt['shd_linktree_move_topic'] = 'Flytt emnet til helpdesk';

$txt['shd_cancel_ticket'] = 'Avbryt og gå tilbake til saken';
$txt['shd_cancel_home'] = 'Avbryt og gå tilbake til helpdesk hjem';
$txt['shd_cancel_topic'] = 'Avbryt og gå tilbake til emnet';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Svar på billetten';
$txt['shd_ticket_quote'] = 'Svar med sitat';
$txt['shd_go_advanced'] = 'Gå avansert!';
$txt['shd_ticket_edit_reply'] = 'Rediger svar';
$txt['shd_ticket_quote_short'] = 'Sitat';
$txt['shd_ticket_markunread'] = 'Merk som ulest';
$txt['shd_ticket_reply_short'] = 'Svar';
$txt['shd_ticket_edit'] = 'Rediger';
$txt['shd_ticket_resolved'] = 'Merk som løst';
$txt['shd_ticket_unresolved'] = 'Merk som ikke løst';
$txt['shd_ticket_assign'] = 'Tildel';
$txt['shd_ticket_assign_self'] = 'Tilordne til meg';
$txt['shd_ticket_reassign'] = 'Re-tilordne';
$txt['shd_ticket_unassign'] = 'Av-Tilordne';
$txt['shd_ticket_delete'] = 'Slett';
$txt['shd_delete_confirm'] = 'Er du sikker på at du vil slette denne billetten? Hvis slettet, vil denne billetten bli flyttet til resirkulering av bind.';
$txt['shd_delete_reply_confirm'] = 'Er du sikker på at du vil slette dette svaret? Hvis du er slettet, blir dette svaret flyttet til resirkuleringsbeholderen.';
$txt['shd_delete_attach_confirm'] = 'Er du sikker på at du vil slette dette vedlegget? (Dette kan ikke angres!)';
$txt['shd_delete_attach'] = 'Slett dette vedlegget';
$txt['shd_ticket_restore'] = 'Gjenopprett';
$txt['shd_delete_permanently'] = 'Slett permanent';
$txt['shd_delete_permanently_confirm'] = 'Er du sikker på at du vil slette denne billetten permanent? Dette kan IKKE gjøres om!';
$txt['shd_ticket_move_to_topic'] = 'Flytt til emne';
$txt['shd_move_dept'] = 'Flytt dybde.';
$txt['shd_actions'] = 'Handlinger';
$txt['shd_back_to_ticket'] = 'Returner til denne billetten etter posting';
$txt['shd_disable_smileys_post'] = 'Slå av smilefjes i dette innlegget';
$txt['shd_resolve_this_ticket'] = 'Marker denne saken som løst';
$txt['shd_override_cf'] = 'Overstyr de egendefinerte feltene kravene';
$txt['shd_silent_update'] = 'Stille oppdatert (send ingen varslinger)';
$txt['shd_select_notifications'] = 'Velg folk å varsle om dette svaret...';

$txt['shd_ticket_assign_ticket'] = 'Tilordne sak';
$txt['shd_ticket_assign_to'] = 'Tilordne billett til';

$txt['shd_ticket_move_dept'] = 'Flytt sak til en annen avdeling';
$txt['shd_ticket_move_to'] = 'Flytt til';
$txt['shd_current_dept'] = 'For tiden på avdelingen';
$txt['shd_ticket_move'] = 'Flytt sak';
$txt['shd_unknown_dept'] = 'Den spesifiserte avdelingen eksisterer ikke.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Nytt emne';
$txt['shd_move_ticket_to_topic'] = 'Flytt billetten til emnet';
$txt['shd_move_ticket'] = 'Flytte billett';
$txt['shd_ticket_board'] = 'Brett';
$txt['shd_change_ticket_subject'] = 'Endre emne for sak';
$txt['shd_move_send_pm'] = 'Send en PM til eieren av saken';
$txt['shd_move_why'] = 'Vennligst angi en kort beskrivelse av hvorfor denne billetten flyttes til et forum emne.';
$txt['shd_ticket_moved_subject'] = 'Din sak har blitt flyttet.';
$txt['shd_move_default'] = 'Hei {user},' . "\n\n" . 'Din billett, {subject}, har blitt flyttet fra helpdesk til et emne i forumet.' . "\n" . 'Du kan finne din sak i tavlen {board} eller via denne lenken:' . "\n\n" . '{link}' . "\n\n" . 'Takk';

$txt['shd_move_topic_to_ticket'] = 'Flytt emnet til helpdesk';
$txt['shd_move_topic'] = 'Flytt emne';
$txt['shd_change_topic_subject'] = 'Endre emnet';
$txt['shd_move_send_pm_topic'] = 'Send en PM til startpunktet for emnet';
$txt['shd_move_why_topic'] = 'Vennligst skriv en kort beskrivelse av hvorfor dette emnet er flyttet til helpdesken. ';
$txt['shd_ticket_moved_subject_topic'] = 'Emnet ditt er flyttet.';
$txt['shd_move_default_topic'] = 'Hei {user},' . "\n\n" . 'Ditt emne, {subject}, har blitt flyttet fra forumet til Helpdesk-delen.' . "\n" . 'Du kan finne emnet ditt via denne lenken:' . "\n\n" . '{link}' . "\n\n" . 'Takk';

$txt['shd_user_no_hd_access'] = 'Merk: personen som startet dette emnet kan ikke se helpdesken!';
$txt['shd_user_helpdesk_access'] = 'Personen som startet dette emnet kan se helpdesken.';
$txt['shd_user_hd_access_dept_1'] = 'Personen som startet dette emnet kan se følgende avdeling: ';
$txt['shd_user_hd_access_dept'] = 'Personen som startet dette emnet får se følgende avdelinger: ';
$txt['shd_move_ticket_department'] = 'Flytt billetten til hvilken avdeling';
$txt['shd_move_dept_why'] = 'Skriv inn en kort beskrivelse av hvorfor denne billetten flyttes til en annen avdeling.';
$txt['shd_move_dept_default'] = 'Hei {user},' . "\n\n" . 'Din billett, {subject}, har blitt flyttet fra {current_dept} avdeling til {new_dept} avdelingen.' . "\n" . 'Du kan finne din sak via denne lenken:' . "\n\n" . '{link}' . "\n\n" . 'Takk';

$txt['shd_ticket_move_deleted'] = 'Saken har svar som er i papirkurven. Hva vil du gjøre?';
$txt['shd_ticket_move_deleted_abort'] = 'Abort, ta meg til papirkurven';
$txt['shd_ticket_move_deleted_delete'] = 'Fortsetter, men ikke la de slettede svarene gå dem inn i det nye emnet)';
$txt['shd_ticket_move_deleted_undelete'] = 'Fortsett å slette svarene (flytt dem inn i det nye emnet)';

$txt['shd_ticket_move_cfs'] = 'Denne saken har egendefinerte felter som kanskje må flyttes.';
$txt['shd_ticket_move_cfs_warn'] = 'Noen av disse feltene er kanskje ikke synlige for andre brukere. Disse feltene er merket med et utropstegn.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Du kan se dette feltet, andre brukere kan ikke - men når den blir en del av forumet, Det vil bli synlig for alle som kan få tilgang til forumet.';
$txt['shd_ticket_move_cfs_purge'] = 'Slett innhold i feltet';
$txt['shd_ticket_move_cfs_embed'] = 'Behold feltet og legg det i det nye emnet';
$txt['shd_ticket_move_cfs_user'] = 'For øyeblikket synlig for vanlige brukere';
$txt['shd_ticket_move_cfs_staff'] = 'Foreløpig synlig for ansatte';
$txt['shd_ticket_move_cfs_admin'] = 'Foreløpig synlig for administratorer';
$txt['shd_ticket_move_accept'] = 'Jeg aksepterer at noen av feltene som blir manipulert her ikke er synlige for alle brukere, og at dette emnet skal bli flyttet til forumet, med innstillingene over.';
$txt['shd_ticket_move_reqd'] = 'Dette alternativet må være valgt for at du skal flytte denne billetten til forumet.';
$txt['shd_ticket_move_ok'] = 'Dette feltet er trygt å flytte, alle brukere som kan se billetten kan se dette feltet, det er ingen informasjon skjult for brukere eller ansatte.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Denne billetten har felter som brukere eller ansatte kanskje ikke kan se, siden slike du spesifikt trenger å bekrefte deg at du er klar over dette. Vennligst gå tilbake til forrige side, avmerkingsboksen for å bekrefte bevisstheten om dette er nederst på skjemaet.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Resirkuler tkort';
$txt['shd_recycle_greeting'] = 'Dette er resirkuleringsbinden. Alle slettede billetter går her, men ansatte med spesielle tillatelser kan fjerne saker permanent herfra.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Opprett billett';
$txt['shd_edit_ticket'] = 'Rediger billett';
$txt['shd_edit_ticket_linktree'] = 'Rediger billett (%s)';
$txt['shd_ticket_subject'] = 'sak emne';
$txt['shd_ticket_proxy'] = 'Post på vegne av';
$txt['shd_ticket_post_error'] = 'Følgende sak, eller problemer, oppstod mens du forsøkte å poste denne saken';
$txt['shd_reply_ticket'] = 'Svar på billetten';
$txt['shd_reply_ticket_linktree'] = 'Svar på billett (%s)';
$txt['shd_edit_reply_linktree'] = 'Rediger svar (%s)';
$txt['shd_previewing_ticket'] = 'Forhåndsvis billett';
$txt['shd_previewing_reply'] = 'Forhåndsviser svar til';
$txt['shd_choose_one'] = '[Velg på]';
$txt['shd_no_value'] = '[ingen verdi]';
$txt['shd_ticket_dept'] = 'Saks avdeling';
$txt['shd_select_dept'] = '-- Velg en avdeling --';
$txt['canned_replies'] = 'Legge til et forhåndsdefinert svar:';
$txt['canned_replies_select'] = '-- Velg et svar --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Helpdesk svar postet fra IP (område)';
$txt['shd_no_replies_from_ip'] = 'Ingen helpdesk-svar fra den angitte IP (område) funnet';
$txt['shd_replies_from_ip_desc'] = 'Nedenfor finnes en liste over alle meldinger som er postet på helpdesk fra denne IP (område).';
$txt['shd_is_ticket_opener'] = ' (billett starter)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2-arkiv';
$txt['shd_attachtype_gz'] = 'GZip arkiv';
$txt['shd_attachtype_rar'] = 'Arr/WinRAR arkiv';
$txt['shd_attachtype_zip'] = 'Zip arkiv';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) lydfil';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windows Bitmap bilde';
$txt['shd_attachtype_gif'] = 'Grafisk endret format (GIF) bilde';
$txt['shd_attachtype_jpeg'] = 'Felles bilde av ekspertgruppe (JPEG)';
$txt['shd_attachtype_jpg'] = 'Felles bilde av ekspertgruppe (JPEG)';
$txt['shd_attachtype_png'] = 'Flyttbar nettverksgrafisk bilde (PNG)';
$txt['shd_attachtype_svg'] = 'skalerbart vektor grafisk (SVG) bilde';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Videofilm';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Word dokument';
$txt['shd_attachtype_mdb'] = 'Microsoft Access-databasen';
$txt['shd_attachtype_ppt'] = 'Microsoft PowerPoint presentasjon';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ kildefil';
$txt['shd_attachtype_php'] = 'PHP skript';
$txt['shd_attachtype_py'] = 'Python kildefil';
$txt['shd_attachtype_rb'] = 'Ruby kildefil';
$txt['shd_attachtype_sql'] = 'SQL skript';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KML arkiv)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Portable Dokumentfil';
$txt['shd_attachtype_psd'] = 'Bilderedokument av leire';
$txt['shd_attachtype_swf'] = 'Adobe Flash-fil';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Kjørbar fil (Windows)';
$txt['shd_attachtype_htm'] = 'Dokument for tekstMarkup (HTML)';
$txt['shd_attachtype_html'] = 'Dokument for tekstMarkup (HTML)';
$txt['shd_attachtype_rtf'] = 'Rik tekstformat (RTF)';
$txt['shd_attachtype_txt'] = 'Ren tekst';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Billett handlingslogg';
$txt['shd_ticket_log_count_one'] = '1 oppføring';
$txt['shd_ticket_log_count_more'] = '%s oppføringer';
$txt['shd_ticket_log_none'] = 'Denne billetten har ikke hatt noen endringer.';
$txt['shd_ticket_log_member'] = 'Medlem';
$txt['shd_ticket_log_ip'] = 'Medlem IP:';
$txt['shd_ticket_log_date'] = 'Dato';
$txt['shd_ticket_log_action'] = 'Handling';
$txt['shd_ticket_log_full'] = 'Gå til hele handlingsloggen (Alle saker)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Relaterte saker';
$txt['shd_ticket_create_relationship'] = 'Opprett relasjon';
$txt['shd_ticket_delete_relationship'] = 'Slett forhold';
$txt['shd_ticket_reltype'] = 'velg type';
$txt['shd_ticket_reltype_linked'] = 'Koblet til';
$txt['shd_ticket_reltype_duplicated'] = 'Duplikat av';
$txt['shd_ticket_reltype_parent'] = 'Forelder av';
$txt['shd_ticket_reltype_child'] = 'Barn av';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Ytterligere informasjon';
$txt['shd_ticket_additional_details'] = 'Ekstra detaljer';
$txt['shd_ticket_empty_field'] = 'Dette feltet er tomt.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Varsler';
$txt['shd_ticket_notify_noneprefs'] = 'Dine brukerinnstillinger står ikke ved varsling av denne saken.';
$txt['shd_ticket_notify_changeprefs'] = 'Endre innstillingene dine';
$txt['shd_ticket_notify_because'] = 'Dine innstillinger indikerer varsler deg om svar på denne saken:';
$txt['shd_ticket_notify_because_yourticket'] = 'som det er din billett';
$txt['shd_ticket_notify_because_assignedyou'] = 'som du er tildelt den';
$txt['shd_ticket_notify_because_priorreply'] = 'som du svarte på det før';
$txt['shd_ticket_notify_because_anyreply'] = 'for alle saker';

$txt['shd_ticket_notify_me_always'] = 'Du følger med på denne billetten (og vil motta en melding på hvert svar)';
$txt['shd_ticket_monitor_on_note'] = 'Du kan overvåke alle svar på denne billetten via e-post uavhengig av dine preferanser:';
$txt['shd_ticket_monitor_off_note'] = 'Du kan slå av overvåkning for denne saken og bruke dine preferanser i stedet:';
$txt['shd_ticket_monitor_on'] = 'Slå på overvåking';
$txt['shd_ticket_monitor_off'] = 'Slå av overvåking';
$txt['shd_ticket_notify_me_never_note'] = 'Du kan ignorere e-postoppdateringer for denne billetten uavhengig av dine innstillinger:';
$txt['shd_ticket_notify_me_never'] = 'Du har skrudd av alle varsler for denne saken.';
$txt['shd_ticket_notify_me_never_on'] = 'Slå av varsler';
$txt['shd_ticket_notify_me_never_off'] = 'Slå på varsler';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Søkesystemet vil kanskje ikke vise alle tilgjengelige saker; dette undersøkes for øyeblikket.';
$txt['shd_search_warning_admin'] = 'Søkeverket krever at indeksen bygges opp på nytt. Du kan oppnå dette fra vedlikeholdsalternativet, i Hjelpeanlegget, i administrasjonspanelet.';
$txt['shd_search'] = 'Søk saker';
$txt['shd_search_results'] = 'Søk saker - resultater';
$txt['shd_search_text'] = 'Ord du leter etter:';
$txt['shd_search_match'] = 'Hva skal være like?';
$txt['shd_search_match_all'] = 'Samsvar med alle levert ord';
$txt['shd_search_match_any'] = 'Samsvar med alle tilgjengelige ord';
$txt['shd_search_scope'] = 'Inkluder hvilke typer saker:';
$txt['shd_search_scope_open'] = 'Åpne billetter';
$txt['shd_search_scope_closed'] = 'Lukkede billetter';
$txt['shd_search_scope_recycle'] = 'Gjenstander i papirkurven';
$txt['shd_search_result_ticket'] = 'Sak %1$s';
$txt['shd_search_result_reply'] = 'Svar på billetten %1$s';
$txt['shd_search_last_updated'] = 'Sist oppdatert:';
$txt['shd_search_ticket_opened_by'] = 'sak åpnet av:';
$txt['shd_search_ticket_replied_by'] = 'sak svarte ved:';
$txt['shd_search_dept'] = 'Søk i de(n) avdeling(er):';

$txt['shd_search_urgency'] = 'Inkluder hvilke prioritetsnivåer:';

$txt['shd_search_where'] = 'Hvilke elementer å søke:';
$txt['shd_search_where_tickets'] = 'The bodies of tickets';
$txt['shd_search_where_replies'] = 'Svar i saker';
$txt['shd_search_where_subjects'] = 'sak emner';

$txt['shd_search_ticket_starter'] = 'Saker startet av:';
$txt['shd_search_ticket_assignee'] = 'Saker tildelt til:';
$txt['shd_search_ticket_named_person'] = 'Type navn på personen(e) du er interessert i.';

$txt['shd_search_no_results'] = 'Fant ingen resultater med de gitte kriteriene. Du vil kanskje gå tilbake og prøve å endre søkekriteriene.';
$txt['shd_search_criteria'] = 'Søkekriterier:';
$txt['shd_search_excluded'] = 'Hvis alle mulige alternativer er valgt, er det ikke tatt med i ovennevnte (f.eks. hvis alle mulige prioritetsnivåer ble avkrysset, er ikke det angitt ovenfor, slik at du kan konsentrere deg om hva som er spesifikk for søket)';
//@}