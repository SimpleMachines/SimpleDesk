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
$txt['shd_helpdesk_maintenance'] = 'De helpdesk bevindt zich momenteel in <strong>onderhoudsmodus</strong>. Alleen forumbeheerders en helpdeskbeheerders kunnen dit zien.';
$txt['shd_open_ticket'] = 'open ticket';
$txt['shd_open_tickets'] = 'open tickets';
$txt['shd_none'] = 'geen';

$txt['shd_display_nojs'] = 'JavaScript is niet ingeschakeld in uw browser. Sommige functies werken mogelijk niet goed (of helemaal niet), of gedrag op een onverwachte manier.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Welkom bij het hoofd helpdesk administratiecentrum!';
$txt['shd_admin_title'] = 'Helpdesk Administration Center';
$txt['shd_staff_list'] = 'Helpdesk personeel';
$txt['shd_update_available'] = 'Nieuwe versie beschikbaar!';
$txt['shd_update_message'] = 'Een nieuwe versie van SimpleDesk is vrijgegeven. We raden u aan om <a href="#" id="update-link">bij te werken naar de nieuwste versie</a> om veilig te blijven en gebruik te maken van alle functies die onze wijzigingen te bieden hebben.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Voor meer informatie over wat nieuw is in deze release, bezoek <a href="#" id="information-link" target="_blank">onze website</a>.</span><br>' . "\n\n" . '<strong>Het SimpleDesk Team</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'laag';
$txt['shd_urgency_1'] = 'Middelgroot';
$txt['shd_urgency_2'] = 'hoog';
$txt['shd_urgency_3'] = 'Zeer hoog';
$txt['shd_urgency_4'] = 'Ernstig';
$txt['shd_urgency_5'] = 'Kritiek';
$txt['shd_urgency_increase'] = 'Verhogen';
$txt['shd_urgency_decrease'] = 'Verlaag';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Nieuw';
$txt['shd_status_1'] = 'Commentaar in behandeling';
$txt['shd_status_2'] = 'Commentaar gebruiker in afwachting';
$txt['shd_status_3'] = 'Opgelost/Gesloten';
$txt['shd_status_4'] = 'Aanbevolen naar toezichthouder';
$txt['shd_status_5'] = 'Geëscaleerd - Urgent';
$txt['shd_status_6'] = 'Verwijderd';
$txt['shd_status_7'] = 'In de wacht';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Nieuwe tickets';
$txt['shd_status_1_heading'] = 'Tickets wachten op medewerkerreactie';
$txt['shd_status_2_heading'] = 'Tickets wachtend op gebruikersreactie';
$txt['shd_status_3_heading'] = 'Gesloten tickets';
$txt['shd_status_4_heading'] = 'Tickets verwezen naar de toezichthouder';
$txt['shd_status_5_heading'] = 'Dringende Tickets';
$txt['shd_status_6_heading'] = 'Gerecyclede tickets';
$txt['shd_status_7_heading'] = 'Tickets ingedrukt houden';
$txt['shd_status_assigned_heading'] = 'Toegewezen aan mij';
$txt['shd_status_withdeleted_heading'] = 'Tickets met verwijderde antwoorden';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Open tickets';
$txt['shd_tickets_closed'] = 'Gesloten tickets';
$txt['shd_tickets_recycled'] = 'Gerecyclede tickets';

$txt['shd_assigned'] = 'Toegewezen';
$txt['shd_unassigned'] = 'Niet-toegewezen';

$txt['shd_read_ticket'] = 'Ticket lezen';
$txt['shd_unread_ticket'] = 'Ongelezen ticket';
$txt['shd_unread_tickets'] = 'Ongelezen tickets';

$txt['shd_owned'] = 'Ticket in bezit'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'ticket';
$txt['shd_count_tickets'] = 'betaalbewijzen';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Je hebt geen toegang tot de helpdesk.';
$txt['shd_no_ticket'] = 'De ticket die je hebt opgevraagd lijkt niet te bestaan.';
$txt['shd_no_reply'] = 'Het ticketantwoord dat je hebt lijkt niet te bestaan, of maakt geen deel uit van dit ticket.';
$txt['shd_no_topic'] = 'De topic die je hebt aangevraagd lijkt niet te bestaan.';
$txt['shd_ticket_no_perms'] = 'Je bent niet bevoegd om dat ticket te bekijken.';
$txt['shd_error_no_tickets'] = 'Er zijn geen tickets gevonden.';
$txt['shd_inactive'] = 'De helpdesk is momenteel gedeactiveerd.';
$txt['shd_cannot_assign'] = 'U heeft geen toestemming om tickets toe te wijzen.';
$txt['shd_cannot_assign_other'] = 'Deze ticket is al aan een andere gebruiker toegewezen. Je kunt deze niet opnieuw aan jezelf toewijzen - neem contact op met de beheerder.';
$txt['shd_no_staff_assign'] = 'Er is geen medewerker geconfigureerd; het is niet mogelijk om een ticket toe te wijzen. Neem contact op met uw beheerder.';
$txt['shd_assigned_not_permitted'] = 'De gebruiker die je hebt aangevraagd om deze ticket toe te wijzen heeft niet voldoende rechten om deze te bekijken.';
$txt['shd_cannot_resolve'] = 'Je hebt geen toestemming om deze ticket te markeren als afgehandeld.';
$txt['shd_cannot_unresolve'] = 'Je bent niet gemachtigd om een opgelost ticket te heropenen.';
$txt['error_shd_cannot_resolve_children'] = 'Dit ticket kan momenteel niet worden gesloten; dit ticket is de ouder van een of meer tickets die momenteel open zijn.';
$txt['error_shd_proxy_unknown'] = 'De gebruiker die deze ticket namens plaatst bestaat niet.';
$txt['shd_cannot_change_privacy'] = 'U bent niet gemachtigd om de privacy van dit ticket te wijzigen.';
$txt['shd_cannot_change_urgency'] = 'U hebt geen toestemming om de urgentie van dit ticket te wijzigen.';
$txt['shd_ajax_problem'] = 'Er is een fout opgetreden bij het laden van de pagina. Wilt u het opnieuw proberen?';
$txt['shd_cannot_move_ticket'] = 'Je hebt geen rechten om deze ticket te verplaatsen naar een topic.';
$txt['shd_cannot_move_topic'] = 'Je hebt geen rechten om dit onderwerp te verplaatsen naar een ticket.';
$txt['shd_moveticket_noboards'] = 'Er zijn geen borden om deze ticket naar te verplaatsen!';
$txt['shd_move_no_pm'] = 'Je moet een reden opgeven voor het verplaatsen van het ticket naar de eigenaar van het ticket of schakel de optie uit om een PM naar de eigenaar van een ticket te sturen.';
$txt['shd_move_no_pm_topic'] = 'Je moet een reden opgeven voor het verplaatsen van de topic naar de start van de topic of schakel de optie uit om een PM naar de topic te sturen.';
$txt['shd_move_topic_not_created'] = 'Ticket kon niet naar het bord worden verplaatst. Probeer het opnieuw.';
$txt['shd_move_ticket_not_created'] = 'Kon het onderwerp niet naar de helpdesk verplaatsen. Probeer het opnieuw.';
$txt['shd_no_replies'] = 'Deze ticket heeft nog geen reacties.';
$txt['cannot_shd_new_ticket'] = 'U bent niet gemachtigd om een nieuw ticket te maken.';
$txt['cannot_shd_edit_ticket'] = 'U bent niet gemachtigd om dit ticket te bewerken.';
$txt['shd_cannot_reply_any'] = 'U heeft geen toestemming om op tickets te reageren.';
$txt['shd_cannot_reply_any_but_own'] = 'Je hebt geen toestemming om op andere tickets dan je eigen tickets te reageren.';
$txt['shd_cannot_edit_reply_any'] = 'U heeft geen rechten om antwoorden te bewerken.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Je hebt geen toestemming om antwoorden op andere tickets dan je eigen antwoorden te bewerken.';
$txt['shd_cannot_edit_closed'] = 'U kunt afgehandelde tickets niet bewerken; u moet het eerst nog onopgelost markeren.';
$txt['shd_cannot_edit_deleted'] = 'U kunt tickets in de prullenbak niet bewerken. Ze moeten eerst worden hersteld.';
$txt['shd_cannot_reply_closed'] = 'U kunt niet antwoorden op afgehandelde tickets; u moet ze eerst nog onopgelost markeren.';
$txt['shd_cannot_reply_deleted'] = 'U kunt niet antwoorden op tickets in de prullenbak. Ze moeten eerst worden hersteld.';
$txt['shd_cannot_delete_ticket'] = 'Je hebt geen toestemming om dit ticket te verwijderen.';
$txt['shd_cannot_delete_reply'] = 'Je hebt geen toestemming om dat antwoord te verwijderen.';
$txt['shd_cannot_restore_ticket'] = 'Je hebt geen toestemming om dit ticket te herstellen vanuit de prullenbak.';
$txt['shd_cannot_restore_reply'] = 'Je hebt geen toestemming om dat antwoord terug te zetten vanuit de prullenbak.';
$txt['shd_cannot_view_resolved'] = 'U heeft geen toegang tot afgehandelde tickets.';
$txt['cannot_shd_access_recyclebin'] = 'U heeft geen toegang tot de prullenbak.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'U kunt dit ticket niet naar het forum verplaatsen; er zijn één of meer verwijderde antwoorden, waar uw huidige machtigingen geen toegang tot toestaan.';
$txt['shd_cannot_attach_ext'] = 'Het bestandstype dat je probeerde toe te voegen ({ext}) is hier niet toegestaan. De toegestane bestandstypen zijn: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Deze ticket is momenteel niet beschikbaar om te wijzigen.';
$txt['shd_invalid_relation'] = 'U moet een geldig type relatie opgeven voor deze tickets.';
$txt['shd_no_relation_delete'] = 'U kunt geen relatie verwijderen die niet bestaat.';
$txt['shd_cannot_relate_self'] = 'Je kunt geen ticket aan zichzelf koppelen.';
$txt['shd_relationships_are_disabled'] = 'Ticketrelaties zijn momenteel uitgeschakeld.';
$txt['error_invalid_fields'] = 'De volgende velden hebben waarden die niet kunnen worden gebruikt: %1$s';
$txt['error_missing_fields'] = 'De volgende velden zijn niet ingevuld en moeten zijn: %1$s';
$txt['error_missing_multi'] = '%1$s (minstens %2$d moet worden geselecteerd)';
$txt['error_no_dept'] = 'Je hebt geen afdeling geselecteerd om deze ticket te plaatsen.';
$txt['shd_cannot_move_dept'] = 'Je kunt dit ticket niet verplaatsen, er is nergens naar toe te verplaatsen.';
$txt['shd_no_perm_move_dept'] = 'Je hebt geen toestemming om deze ticket te verplaatsen naar een andere afdeling.';
$txt['cannot_shd_delete_attachment'] = 'Je hebt geen toestemming om bijlagen te verwijderen.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'U kunt deze ticket niet naar een topic verplaatsen; er zijn aangepaste velden die een beheerder vereisen om de verplaatsing te bevestigen.';
$txt['cannot_monitor_ticket'] = 'Je hebt geen toestemming om de monitoring aan te zetten voor dit ticket.';
$txt['cannot_unmonitor_ticket'] = 'Je hebt geen toestemming om de monitoring uit te zetten voor dit ticket.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Helpdesk'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Afdelingen'; // ditto
$txt['shd_new_ticket'] = 'Nieuw ticket plaatsen';
$txt['shd_new_ticket_proxy'] = 'Post Proxy Ticket';
$txt['shd_helpdesk_profile'] = 'Helpdesk profiel';
$txt['shd_welcome'] = 'Welkom, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Ga naar ticket';
$txt['shd_options'] = 'Instellingen';
$txt['shd_search_menu'] = 'Zoeken';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Informatie';
$txt['shd_admin_options'] = 'Instellingen';
$txt['shd_admin_custom_fields'] = 'Aangepaste velden';
$txt['shd_admin_departments'] = 'Afdelingen';
$txt['shd_admin_permissions'] = 'Machtigingen';
$txt['shd_admin_plugins'] = 'Plug-ins';
$txt['shd_admin_cannedreplies'] = 'Vaste antwoorden';
$txt['shd_admin_maint'] = 'Onderhoud';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Hier kun je nieuwe tickets indienen voor de site staf die actie moet ondernemen, en de huidige tickets bekijken.';
$txt['shd_staff_greeting'] = 'Hier zijn alle tickets die aandacht vereisen.';
$txt['shd_shd_greeting'] = 'Dit is de Helpdesk. Je verspilt hier je tijd aan om nieuwe klanten te helpen. Veel plezier!';
$txt['shd_closed_user_greeting'] = 'Dit zijn alle gesloten of afgehandelde tickets die je op de helpdesk hebt geplaatst.';
$txt['shd_closed_staff_greeting'] = 'Dit zijn allemaal gesloten of afgehandelde tickets die bij de helpdesk zijn ingediend.';
$txt['shd_category_filter'] = 'Categorie filtering';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Uw ticket is aangemaakt!';
$txt['shd_ticket_posted_body'] = 'Bedankt voor het plaatsen van je ticket, {membername}!' . "\n\n" . 'De helpdeskmedewerker bekijkt het en neemt zo snel mogelijk contact met je op.' . "\n\n" . 'In de tussentijd kunt u uw ticket bekijken &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; via de volgende URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Open een ander ticket[/iurl] ## [iurl={helpdesklink}]Terug naar de belangrijkste helpdesk[/iurl] ## [iurl={forumlink}]Terug naar het forum[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'U kunt e-mailnotificaties inschakelen voor wijzigingen van uw ticket, in het gebied [iurl={prefslink}]Helpdesk Voorkeuren[/iurl] gebied.';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Groeten,' . "\n" . 'Het {forum_name} Team.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Ticket Details';
$txt['shd_ticket_updated'] = 'Bijgewerkt';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'naam';
$txt['shd_ticket_user'] = 'Gebruiker';
$txt['shd_ticket_date'] = 'Geplaatst';
$txt['shd_ticket_urgency'] = 'Urgentie';
$txt['shd_ticket_assigned'] = 'Toegewezen';
$txt['shd_ticket_assignedto'] = 'Toegewezen aan';
$txt['shd_ticket_started_by'] = 'Gestart door';
$txt['shd_ticket_updated_by'] = 'Bijgewerkt door';
$txt['shd_ticket_status'] = 'status';
$txt['shd_ticket_num_replies'] = 'Antwoorden';
$txt['shd_ticket_replies'] = 'Antwoorden';
$txt['shd_ticket_staff'] = 'Medewerker lid';
$txt['shd_ticket_attachments'] = 'Bijlagen';
$txt['shd_ticket_reply_number'] = 'Antwoord <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Ticket On-Vasthouden';
$txt['shd_ticket'] = 'Ticketsysteem';
$txt['shd_reply_written'] = 'Antwoord geschreven %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Nooit';
$txt['shd_linktree_tickets'] = 'Tickets';
$txt['shd_ticket_privacy'] = 'Privacy';
$txt['shd_ticket_notprivate'] = 'Niet privé';
$txt['shd_ticket_private'] = 'Privé';
$txt['shd_ticket_change'] = 'Veranderen';
$txt['shd_ticket_ip'] = 'IP adres';
$txt['shd_back_to_hd'] = 'Terug naar de helpdesk';
$txt['shd_go_to_replies'] = 'Ga naar antwoorden';
$txt['shd_go_to_action_log'] = 'Ga naar actielogboek';
$txt['shd_go_to_replies_start'] = 'Ga naar het eerste antwoord';

$txt['shd_ticket_has_been_deleted'] = 'Dit ticket is momenteel in de prullenbak en kan niet worden gewijzigd zonder terug te keren naar de helpdesk.';
$txt['shd_ticket_replies_deleted'] = 'Deze ticket heeft er eerder antwoorden van verwijderd.';
$txt['shd_ticket_replies_deleted_view'] = 'Deze worden weergegeven met een gekleurde achtergrond. <a href="%1$s">Bekijk de ticket zonder verwijderingen</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Klik <a href="%1$s">hier</a> om ze te bekijken.';

$txt['shd_ticket_notnew'] = 'U heeft dit al gezien';
$txt['shd_ticket_new'] = 'Nieuw';

$txt['shd_linktree_move_ticket'] = 'Ticket verplaatsen';
$txt['shd_linktree_move_topic'] = 'Topic verplaatsen naar helpdesk';

$txt['shd_cancel_ticket'] = 'Annuleer en keer terug naar het ticket';
$txt['shd_cancel_home'] = 'Annuleer en ga terug naar de helpdesk';
$txt['shd_cancel_topic'] = 'Annuleer en ga terug naar het onderwerp';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Antwoord op ticket';
$txt['shd_ticket_quote'] = 'Posten met citaat';
$txt['shd_go_advanced'] = 'Ga geavanceerd!';
$txt['shd_ticket_edit_reply'] = 'Antwoord bewerken';
$txt['shd_ticket_quote_short'] = 'Offerte';
$txt['shd_ticket_markunread'] = 'Markeren als ongelezen';
$txt['shd_ticket_reply_short'] = 'Beantwoorden';
$txt['shd_ticket_edit'] = 'Bewerken';
$txt['shd_ticket_resolved'] = 'Markeer afgehandeld';
$txt['shd_ticket_unresolved'] = 'Markeren als onopgelost';
$txt['shd_ticket_assign'] = 'Toewijzen';
$txt['shd_ticket_assign_self'] = 'Wijs mij toe';
$txt['shd_ticket_reassign'] = 'Opnieuw toewijzen';
$txt['shd_ticket_unassign'] = 'Niet-toewijzen';
$txt['shd_ticket_delete'] = 'Verwijderen';
$txt['shd_delete_confirm'] = 'Weet u zeker dat u dit ticket wilt verwijderen? Indien verwijderd, wordt deze ticket verplaatst naar de prullenbak.';
$txt['shd_delete_reply_confirm'] = 'Weet u zeker dat u dit antwoord wilt verwijderen? Indien verwijderd, wordt dit antwoord verplaatst naar de prullenbak.';
$txt['shd_delete_attach_confirm'] = 'Weet je zeker dat je deze bijlage wilt verwijderen? (Dit kan niet ongedaan worden gemaakt!)';
$txt['shd_delete_attach'] = 'Deze bijlage verwijderen';
$txt['shd_ticket_restore'] = 'Herstellen';
$txt['shd_delete_permanently'] = 'Permanent verwijderen';
$txt['shd_delete_permanently_confirm'] = 'Weet u zeker dat u dit ticket permanent wilt verwijderen? Dit kan NIET ongedaan worden gemaakt!';
$txt['shd_ticket_move_to_topic'] = 'Verplaats naar onderwerp';
$txt['shd_move_dept'] = 'Verplaats diepte.';
$txt['shd_actions'] = 'acties';
$txt['shd_back_to_ticket'] = 'Terug naar dit ticket na het plaatsen';
$txt['shd_disable_smileys_post'] = 'Smileys in dit bericht uitschakelen';
$txt['shd_resolve_this_ticket'] = 'Markeer deze ticket als afgehandeld';
$txt['shd_override_cf'] = 'Overschrijf de vereisten voor extra velden';
$txt['shd_silent_update'] = 'Stil met update (stuur geen meldingen)';
$txt['shd_select_notifications'] = 'Selecteer mensen om te informeren over dit antwoord...';

$txt['shd_ticket_assign_ticket'] = 'Ticket toewijzen';
$txt['shd_ticket_assign_to'] = 'Ticket toewijzen aan';

$txt['shd_ticket_move_dept'] = 'Ticket verplaatsen naar een andere afdeling';
$txt['shd_ticket_move_to'] = 'Verplaats naar';
$txt['shd_current_dept'] = 'Momenteel in afdeling';
$txt['shd_ticket_move'] = 'Ticket verplaatsen';
$txt['shd_unknown_dept'] = 'De opgegeven afdeling bestaat niet.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Nieuw onderwerp';
$txt['shd_move_ticket_to_topic'] = 'Ticket verplaatsen naar onderwerp';
$txt['shd_move_ticket'] = 'Ticket verplaatsen';
$txt['shd_ticket_board'] = 'Bord';
$txt['shd_change_ticket_subject'] = 'Wijzig het ticketonderwerp';
$txt['shd_move_send_pm'] = 'Stuur een PM naar de ticketeigenaar';
$txt['shd_move_why'] = 'Voer een korte beschrijving in over waarom deze ticket wordt verplaatst naar een forumonderwerp.';
$txt['shd_ticket_moved_subject'] = 'Je ticket is verplaatst.';
$txt['shd_move_default'] = 'Hallo {user}' . "\n\n" . 'Je ticket, {subject}, is verplaatst van de helpdesk naar een topic op het forum.' . "\n" . 'Je kunt je ticket vinden op het bord {board} of via deze link:' . "\n\n" . '{link}' . "\n\n" . 'Bedankt';

$txt['shd_move_topic_to_ticket'] = 'Topic verplaatsen naar helpdesk';
$txt['shd_move_topic'] = 'Topic verplaatsen';
$txt['shd_change_topic_subject'] = 'Verander het onderwerp';
$txt['shd_move_send_pm_topic'] = 'Stuur een PM naar de starter van het onderwerp';
$txt['shd_move_why_topic'] = 'Geef een korte beschrijving over waarom dit topic wordt verplaatst naar de helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Je topic is verplaatst.';
$txt['shd_move_default_topic'] = 'Hallo {user}' . "\n\n" . 'Uw onderwerp, {subject}, is verplaatst van het forum naar het Helpdesk gedeelte.' . "\n" . 'Je kunt je topic vinden via deze link:' . "\n\n" . '{link}' . "\n\n" . 'Bedankt';

$txt['shd_user_no_hd_access'] = 'Opmerking: de persoon die dit topic heeft gestart kan de helpdesk niet zien!';
$txt['shd_user_helpdesk_access'] = 'De persoon die dit topic heeft gestart kan de helpdesk zien.';
$txt['shd_user_hd_access_dept_1'] = 'De persoon die dit onderwerp is gestart kan de volgende afdeling bekijken: ';
$txt['shd_user_hd_access_dept'] = 'De persoon die dit onderwerp is gestart kan de volgende afdelingen zien: ';
$txt['shd_move_ticket_department'] = 'Ticket verplaatsen naar welke afdeling';
$txt['shd_move_dept_why'] = 'Voer een korte beschrijving in over waarom deze ticket wordt verplaatst naar een andere afdeling.';
$txt['shd_move_dept_default'] = 'Hallo {user}' . "\n\n" . 'Je ticket, {subject}, is verplaatst van de {current_dept} afdeling naar de {new_dept} afdeling.' . "\n" . 'Je kunt je ticket vinden via deze link:' . "\n\n" . '{link}' . "\n\n" . 'Bedankt';

$txt['shd_ticket_move_deleted'] = 'Dit ticket bevat antwoorden die momenteel in de prullenbak zitten. Wat wilt u doen?';
$txt['shd_ticket_move_deleted_abort'] = 'Afbreken, breng me naar de prullenbak';
$txt['shd_ticket_move_deleted_delete'] = 'Ga door, laat de verwijderde reacties achter (verplaats ze niet in het nieuwe onderwerp)';
$txt['shd_ticket_move_deleted_undelete'] = 'Ga door, verwijder reacties (verplaats ze in het nieuwe onderwerp)';

$txt['shd_ticket_move_cfs'] = 'Deze ticket heeft aangepaste velden die mogelijk verplaatst moeten worden.';
$txt['shd_ticket_move_cfs_warn'] = 'Sommige van deze velden zijn mogelijk niet zichtbaar voor andere gebruikers. Deze velden worden aangegeven met een uitroepteken.';
$txt['shd_ticket_move_cfs_warn_user'] = 'U kunt dit veld zien, andere gebruikers kunnen niet - maar zodra het onderdeel wordt van het forum het zal zichtbaar worden voor iedereen die toegang heeft tot het forum.';
$txt['shd_ticket_move_cfs_purge'] = 'Verwijder de inhoud van het veld';
$txt['shd_ticket_move_cfs_embed'] = 'Houd het veld en plaats het in het nieuwe onderwerp';
$txt['shd_ticket_move_cfs_user'] = 'Momenteel zichtbaar voor reguliere gebruikers';
$txt['shd_ticket_move_cfs_staff'] = 'Momenteel zichtbaar voor medewerkers';
$txt['shd_ticket_move_cfs_admin'] = 'Momenteel zichtbaar voor beheerders';
$txt['shd_ticket_move_accept'] = 'Ik accepteer dat sommige van de gebieden die hier worden gemanipuleerd niet voor alle gebruikers zichtbaar zijn. en dat dit onderwerp moet worden verplaatst naar het forum, met bovenstaande instellingen.';
$txt['shd_ticket_move_reqd'] = 'Deze optie moet geselecteerd zijn om dit ticket naar het forum te verplaatsen.';
$txt['shd_ticket_move_ok'] = 'Dit veld is veilig om te verplaatsen, alle gebruikers die de ticket kunnen zien kunnen dit veld zien. er is geen informatie verborgen voor gebruikers of medewerkers.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Deze ticket heeft velden die gebruikers of medewerkers mogelijk niet kunnen zien. Als zodanig moet u bevestigen dat u zich hiervan bewust bent - ga terug naar de vorige pagina de checkbox voor het bevestigen van jouw gevoeligheid staat onderaan het formulier.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Prullenbak verwijderen';
$txt['shd_recycle_greeting'] = 'Dit is de recyclingbak. Alle verwijderde tickets gaan hier, maar personeelsleden met speciale machtigingen kunnen tickets van hier definitief verwijderen.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Ticket aanmaken';
$txt['shd_edit_ticket'] = 'Ticket bewerken';
$txt['shd_edit_ticket_linktree'] = 'Bewerk ticket (%s)';
$txt['shd_ticket_subject'] = 'Ticket onderwerp';
$txt['shd_ticket_proxy'] = 'Post namens';
$txt['shd_ticket_post_error'] = 'Het volgende probleem, of probleem, is opgetreden tijdens het verzenden van dit ticket';
$txt['shd_reply_ticket'] = 'Antwoord op ticket';
$txt['shd_reply_ticket_linktree'] = 'Antwoord op ticket (%s)';
$txt['shd_edit_reply_linktree'] = 'Antwoord bewerken (%s)';
$txt['shd_previewing_ticket'] = 'Voorbeeld van ticket';
$txt['shd_previewing_reply'] = 'Voorbeeld antwoord op';
$txt['shd_choose_one'] = '[Kies één]';
$txt['shd_no_value'] = '[geen waarde]';
$txt['shd_ticket_dept'] = 'Ticket afdeling';
$txt['shd_select_dept'] = '-- Selecteer een afdeling --';
$txt['canned_replies'] = 'Voeg een vooraf gedefinieerd antwoord toe:';
$txt['canned_replies_select'] = '-- Selecteer een antwoord --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Helpdesk reacties geplaatst vanuit IP (bereik)';
$txt['shd_no_replies_from_ip'] = 'Geen helpdesk antwoorden van opgegeven IP (bereik) gevonden';
$txt['shd_replies_from_ip_desc'] = 'Hieronder staat een lijst van alle berichten die op de helpdesk zijn geplaatst vanaf dit IP (bereik).';
$txt['shd_is_ticket_opener'] = ' (ticket starter)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2 archief';
$txt['shd_attachtype_gz'] = 'GZip archief';
$txt['shd_attachtype_rar'] = 'Rar/WinRAR archief';
$txt['shd_attachtype_zip'] = 'Zip archief';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) audiobestand';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windows Bitmap afbeelding';
$txt['shd_attachtype_gif'] = 'Grafische Interchange Format (GIF) afbeelding';
$txt['shd_attachtype_jpeg'] = 'Joint Photographic Experts Group (JPEG) image';
$txt['shd_attachtype_jpg'] = 'Joint Photographic Experts Group (JPEG) image';
$txt['shd_attachtype_png'] = 'Afbeelding draagbaar netwerk Grafisch (PNG)';
$txt['shd_attachtype_svg'] = 'Schaalbare vector Grafisch (SVG) afbeelding';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Video film';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Woord document';
$txt['shd_attachtype_mdb'] = 'Microsoft Access database';
$txt['shd_attachtype_ppt'] = 'Microsoft Powerpoint presentatie';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ bronbestand';
$txt['shd_attachtype_php'] = 'PHP script';
$txt['shd_attachtype_py'] = 'Python bronbestand';
$txt['shd_attachtype_rb'] = 'Ruby bronbestand';
$txt['shd_attachtype_sql'] = 'SQL script';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KML-archief)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Draagbaar Document Bestand';
$txt['shd_attachtype_psd'] = 'Adobe Fotoshop document';
$txt['shd_attachtype_swf'] = 'Adobe Flash bestand';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Uitvoerbaar bestand (Windows)';
$txt['shd_attachtype_htm'] = 'Hypertext Markup Document (HTML)';
$txt['shd_attachtype_html'] = 'Hypertext Markup Document (HTML)';
$txt['shd_attachtype_rtf'] = 'Rich tekstformaat (RTF)';
$txt['shd_attachtype_txt'] = 'Onopgemaakte tekst';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Ticket actie log';
$txt['shd_ticket_log_count_one'] = '1 invoer';
$txt['shd_ticket_log_count_more'] = '%s vermeldingen';
$txt['shd_ticket_log_none'] = 'Deze ticket heeft geen wijzigingen ondergaan.';
$txt['shd_ticket_log_member'] = 'Lid';
$txt['shd_ticket_log_ip'] = 'IP van lid:';
$txt['shd_ticket_log_date'] = 'Datum:';
$txt['shd_ticket_log_action'] = 'actie';
$txt['shd_ticket_log_full'] = 'Ga naar het volledige action log (alle tickets)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Gerelateerde tickets';
$txt['shd_ticket_create_relationship'] = 'Creëer relatie';
$txt['shd_ticket_delete_relationship'] = 'Relatie verwijderen';
$txt['shd_ticket_reltype'] = 'selecteer type';
$txt['shd_ticket_reltype_linked'] = 'Gekoppeld aan';
$txt['shd_ticket_reltype_duplicated'] = 'Duplicaat van';
$txt['shd_ticket_reltype_parent'] = 'Bovenliggend van';
$txt['shd_ticket_reltype_child'] = 'Kind van';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Extra informatie';
$txt['shd_ticket_additional_details'] = 'Aanvullende details';
$txt['shd_ticket_empty_field'] = 'Dit veld is leeg.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Notificaties';
$txt['shd_ticket_notify_noneprefs'] = 'Uw gebruikersvoorkeuren houden geen rekening voor melding van dit ticket.';
$txt['shd_ticket_notify_changeprefs'] = 'Voorkeuren wijzigen';
$txt['shd_ticket_notify_because'] = 'Je voorkeuren geven aan dat je meldingen ontvangt van reacties op dit ticket:';
$txt['shd_ticket_notify_because_yourticket'] = 'omdat het jouw ticket is';
$txt['shd_ticket_notify_because_assignedyou'] = 'omdat het aan u is toegewezen';
$txt['shd_ticket_notify_because_priorreply'] = 'zoals u heeft geantwoord voor';
$txt['shd_ticket_notify_because_anyreply'] = 'voor elk ticket';

$txt['shd_ticket_notify_me_always'] = 'Je houdt deze ticket bij (en ontvangt een melding bij elk antwoord)';
$txt['shd_ticket_monitor_on_note'] = 'Je kunt alle antwoorden op deze ticket per e-mail controleren, ongeacht je voorkeuren:';
$txt['shd_ticket_monitor_off_note'] = 'Je kunt het monitoren voor dit ticket uitschakelen en in plaats daarvan je voorkeuren gebruiken:';
$txt['shd_ticket_monitor_on'] = 'Schakel monitoring in';
$txt['shd_ticket_monitor_off'] = 'Schakel monitoring uit';
$txt['shd_ticket_notify_me_never_note'] = 'Je kan e-mailupdates voor dit ticket negeren, ongeacht je voorkeuren:';
$txt['shd_ticket_notify_me_never'] = 'Je hebt alle meldingen voor deze ticket uitgeschakeld.';
$txt['shd_ticket_notify_me_never_on'] = 'Meldingen uitschakelen';
$txt['shd_ticket_notify_me_never_off'] = 'Meldingen inschakelen';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'De zoekfaciliteit vermeldt mogelijk niet alle beschikbare tickets; het wordt momenteel onderzocht.';
$txt['shd_search_warning_admin'] = 'De zoekfaciliteit vereist dat de index opnieuw wordt opgebouwd. Dit kan via de Onderhoudsoptie, in het Helpdes-gebied, in het administratiescherm.';
$txt['shd_search'] = 'Tickets zoeken';
$txt['shd_search_results'] = 'Tickets zoeken - Resultaten';
$txt['shd_search_text'] = 'Woorden die je zoekt:';
$txt['shd_search_match'] = 'Wat moet er op elkaar worden afgestemd?';
$txt['shd_search_match_all'] = 'Overeenkomen met alle gegeven woorden';
$txt['shd_search_match_any'] = 'Overeenkomen met alle gegeven woorden';
$txt['shd_search_scope'] = 'Voeg toe welke typen tickets:';
$txt['shd_search_scope_open'] = 'Open betaalbewijzen';
$txt['shd_search_scope_closed'] = 'Gesloten tickets';
$txt['shd_search_scope_recycle'] = 'Items in de prullenbak';
$txt['shd_search_result_ticket'] = 'Ticket %1$s';
$txt['shd_search_result_reply'] = 'Antwoord op ticket %1$s';
$txt['shd_search_last_updated'] = 'Laatst bijgewerkt:';
$txt['shd_search_ticket_opened_by'] = 'Ticket geopend door:';
$txt['shd_search_ticket_replied_by'] = 'Ticket geantwoord door:';
$txt['shd_search_dept'] = 'Zoeken in welke afdelingen:';

$txt['shd_search_urgency'] = 'Bevat welke niveaus van urgentie:';

$txt['shd_search_where'] = 'Welke items te zoeken:';
$txt['shd_search_where_tickets'] = 'De lichamen van kaartjes';
$txt['shd_search_where_replies'] = 'De antwoorden in tickets';
$txt['shd_search_where_subjects'] = 'Ticket onderwerpen';

$txt['shd_search_ticket_starter'] = 'Tickets gestart door:';
$txt['shd_search_ticket_assignee'] = 'Tickets toegewezen aan:';
$txt['shd_search_ticket_named_person'] = 'Typ de naam in van de geïnteresseerde persoon(en)';

$txt['shd_search_no_results'] = 'Er zijn geen resultaten gevonden met de opgegeven criteria. Misschien wilt u terug gaan en probeert u uw zoekcriteria te wijzigen.';
$txt['shd_search_criteria'] = 'Zoek criteria:';
$txt['shd_search_excluded'] = 'Als alle mogelijke opties zijn geselecteerd, is deze niet in het bovenstaande opgenomen (bijv. als alle mogelijke urgentieniveaus zijn aangevinkt, wordt dit niet hierboven vermeld, zodat u zich kunt concentreren op wat specifiek is voor uw zoekopdracht)';
//@}