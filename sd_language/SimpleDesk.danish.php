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
$txt['shd_helpdesk_maintenance'] = 'helpdesk er i øjeblikket i <strong>vedligeholdelsestilstand</strong>. Kun forum og helpdesk-administratorer kan se dette.';
$txt['shd_open_ticket'] = 'åbn regning';
$txt['shd_open_tickets'] = 'åbne bestillinger';
$txt['shd_none'] = 'Ingen';

$txt['shd_display_nojs'] = 'JavaScript er ikke aktiveret i din browser. Nogle funktioner fungerer måske ikke korrekt (eller overhovedet), eller opfører sig på en uventet måde.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Velkommen til det vigtigste helpdesk administrationscenter!';
$txt['shd_admin_title'] = 'Helpdesk Administration Center';
$txt['shd_staff_list'] = 'Helpdesk personale';
$txt['shd_update_available'] = 'Ny version tilgængelig!';
$txt['shd_update_message'] = 'En ny version af SimpleDesk er blevet frigivet. Vi anbefalede dig at <a href="#" id="update-link">opdatere til den nyeste version</a> for at forblive sikker og nyde alle funktioner, som vores modifikation har at tilbyde.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>For mere information om hvad der er nyt i denne udgivelse, besøg <a href="#" id="information-link" target="_blank">vores hjemmeside</a>.</span><br>' . "\n\n" . '<strong>SimpleDesk Team</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Lav';
$txt['shd_urgency_1'] = 'Mellem';
$txt['shd_urgency_2'] = 'Høj';
$txt['shd_urgency_3'] = 'Meget Høj';
$txt['shd_urgency_4'] = 'Alvorlig';
$txt['shd_urgency_5'] = 'Kritisk';
$txt['shd_urgency_increase'] = 'Forøg';
$txt['shd_urgency_decrease'] = 'Formindsk';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Ny';
$txt['shd_status_1'] = 'Afventende Personale Kommentar';
$txt['shd_status_2'] = 'Afventende Bruger Kommentar';
$txt['shd_status_3'] = 'Løst/Lukket';
$txt['shd_status_4'] = 'Henvist til tilsynsførende';
$txt['shd_status_5'] = 'Opskaleret - Hastende';
$txt['shd_status_6'] = 'Slettet';
$txt['shd_status_7'] = 'På Hold';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Nye Bestillinger';
$txt['shd_status_1_heading'] = 'Bestillinger Afventer Personale Svar';
$txt['shd_status_2_heading'] = 'Bestillinger Afventer Brugersvar';
$txt['shd_status_3_heading'] = 'Lukkede Billetter';
$txt['shd_status_4_heading'] = 'Billetter Henvist til Tilsynsførende';
$txt['shd_status_5_heading'] = 'Hastende Billetter';
$txt['shd_status_6_heading'] = 'Genbrugte Billetter';
$txt['shd_status_7_heading'] = 'På Hold Billetter';
$txt['shd_status_assigned_heading'] = 'Tildelt mig';
$txt['shd_status_withdeleted_heading'] = 'Bestillinger med slettede svar';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Åbne Bestillinger';
$txt['shd_tickets_closed'] = 'Lukkede Billetter';
$txt['shd_tickets_recycled'] = 'Genbrugte Billetter';

$txt['shd_assigned'] = 'Tildelt';
$txt['shd_unassigned'] = 'Utildelt';

$txt['shd_read_ticket'] = 'Læs Bestilling';
$txt['shd_unread_ticket'] = 'Ulæst Bestilling';
$txt['shd_unread_tickets'] = 'Ulæste Bestillinger';

$txt['shd_owned'] = 'Ejet Bestilling'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'billet';
$txt['shd_count_tickets'] = 'bestillinger';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Du har ikke tilladelse til at få adgang til helpdesk.';
$txt['shd_no_ticket'] = 'Den bestilling, du har anmodet om, ser ikke ud til at eksistere.';
$txt['shd_no_reply'] = 'Den bestillings svar, du har anmodet om, synes ikke at eksistere, eller er ikke en del af denne bestilling.';
$txt['shd_no_topic'] = 'Det emne, du har anmodet om, ser ikke ud til at eksistere.';
$txt['shd_ticket_no_perms'] = 'Du har ikke tilladelse til at se denne bestilling.';
$txt['shd_error_no_tickets'] = 'Ingen bestillinger blev fundet.';
$txt['shd_inactive'] = 'helpdesk er i øjeblikket deaktiveret.';
$txt['shd_cannot_assign'] = 'Du har ikke tilladelse til at tildele billetter.';
$txt['shd_cannot_assign_other'] = 'Denne bestilling er allerede tildelt en anden bruger. Du kan ikke tildele den til dig selv - kontakt venligst administratoren.';
$txt['shd_no_staff_assign'] = 'Der er ikke konfigureret noget personale. Det er ikke muligt at tildele en bestilling. Kontakt venligst din administrator.';
$txt['shd_assigned_not_permitted'] = 'Brugeren du har anmodet om at tildele denne bestilling, har ikke tilstrækkelige tilladelser til at se den.';
$txt['shd_cannot_resolve'] = 'Du har ikke tilladelse til at markere denne bestilling som løst.';
$txt['shd_cannot_unresolve'] = 'Du har ikke tilladelse til at genåbne en løst bestilling.';
$txt['error_shd_cannot_resolve_children'] = 'Denne billet kan ikke lukkes. Denne billet er forælder til en eller flere billetter, der er åbne i øjeblikket.';
$txt['error_shd_proxy_unknown'] = 'Brugeren denne bestilling er bogført på vegne af eksisterer ikke.';
$txt['shd_cannot_change_privacy'] = 'Du har ikke tilladelse til at ændre privatlivets fred på denne bestilling.';
$txt['shd_cannot_change_urgency'] = 'Du har ikke tilladelse til at ændre hastetidspunktet på denne bestilling.';
$txt['shd_ajax_problem'] = 'Der opstod et problem under forsøget på at indlæse siden. Vil du prøve igen?';
$txt['shd_cannot_move_ticket'] = 'Du har ikke tilladelse til at flytte denne bestilling til et emne.';
$txt['shd_cannot_move_topic'] = 'Du har ikke tilladelse til at flytte dette emne til en bestilling.';
$txt['shd_moveticket_noboards'] = 'Der er ingen tavler til at flytte denne billet til!';
$txt['shd_move_no_pm'] = 'Du skal angive en grund til at flytte billetten for at sende til bestillingsejeren, eller afmarkere muligheden for at \'sende en PM til bestillingsejeren\'.';
$txt['shd_move_no_pm_topic'] = 'Du skal angive en grund til at flytte emnet for at sende til emnestarteren, eller fjern markeringen af muligheden for at \'sende en PM til emnestarter\'.';
$txt['shd_move_topic_not_created'] = 'Kunne ikke flytte billet til tavlen. Prøv venligst igen.';
$txt['shd_move_ticket_not_created'] = 'Kunne ikke flytte emnet til helpdesk. Prøv venligst igen.';
$txt['shd_no_replies'] = 'Denne bestilling har endnu ikke nogen svar.';
$txt['cannot_shd_new_ticket'] = 'Du har ikke tilladelse til at oprette en ny bestilling.';
$txt['cannot_shd_edit_ticket'] = 'Du har ikke tilladelse til at redigere denne bestilling.';
$txt['shd_cannot_reply_any'] = 'Du har ikke tilladelse til at svare på nogen bestillinger.';
$txt['shd_cannot_reply_any_but_own'] = 'Du har ikke tilladelse til at svare på andre bestillinger end din egen.';
$txt['shd_cannot_edit_reply_any'] = 'Du har ikke tilladelse til at redigere nogen svar.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Du har ikke tilladelse til at redigere svar på andre bestillinger end dine egne svar.';
$txt['shd_cannot_edit_closed'] = 'Du kan ikke redigere løste bestillinger. Du skal markere det uløste først.';
$txt['shd_cannot_edit_deleted'] = 'Du kan ikke redigere billetter i papirkurven. De skal genoprettes først.';
$txt['shd_cannot_reply_closed'] = 'Du kan ikke besvare bestillinger, du skal markere dem uløste først.';
$txt['shd_cannot_reply_deleted'] = 'Du kan ikke svare på bestillinger i papirkurven. De skal genoprettes først.';
$txt['shd_cannot_delete_ticket'] = 'Du har ikke tilladelse til at slette denne bestilling.';
$txt['shd_cannot_delete_reply'] = 'Du har ikke tilladelse til at slette dette svar.';
$txt['shd_cannot_restore_ticket'] = 'Du har ikke tilladelse til at gendanne denne billet fra papirkurven.';
$txt['shd_cannot_restore_reply'] = 'Du har ikke tilladelse til at gendanne dette svar fra papirkurven.';
$txt['shd_cannot_view_resolved'] = 'Du har ikke tilladelse til at tilgå løste billetter.';
$txt['cannot_shd_access_recyclebin'] = 'Du kan ikke få adgang til papirkurven.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Du kan ikke flytte denne billet til forummet. Der er et eller flere slettede svar, som dine nuværende tilladelser ikke tillader adgang til.';
$txt['shd_cannot_attach_ext'] = 'Filtype du har forsøgt at vedhæfte ({ext}) er ikke tilladt her. De tilladte filtyper er: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Denne billet er i øjeblikket ikke tilgængelig for ændring.';
$txt['shd_invalid_relation'] = 'Du skal angive en gyldig type forhold for disse billetter.';
$txt['shd_no_relation_delete'] = 'Du kan ikke slette et forhold, der ikke findes.';
$txt['shd_cannot_relate_self'] = 'Du kan ikke lave en billet relateret til sig selv.';
$txt['shd_relationships_are_disabled'] = 'Billetrelationer er i øjeblikket deaktiveret.';
$txt['error_invalid_fields'] = 'Følgende felter har værdier, der ikke kan bruges: %1$s';
$txt['error_missing_fields'] = 'Følgende felter er ikke udfyldt og skal være: %1$s';
$txt['error_missing_multi'] = '%1$s (mindst %2$d skal vælges)';
$txt['error_no_dept'] = 'Du valgte ikke en afdeling for at sende denne billet til.';
$txt['shd_cannot_move_dept'] = 'Du kan ikke flytte denne billet, der er ingen steder at flytte den til.';
$txt['shd_no_perm_move_dept'] = 'Du har ikke tilladelse til at flytte denne billet til en anden afdeling.';
$txt['cannot_shd_delete_attachment'] = 'Du har ikke tilladelse til at slette vedhæftede filer.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Du kan ikke flytte denne bestilling til et emne; der er vedhæftede brugerdefinerede felter, der kræver en administrator for at bekræfte flytningen.';
$txt['cannot_monitor_ticket'] = 'Du har ikke tilladelse til at tænde for denne bestilling.';
$txt['cannot_unmonitor_ticket'] = 'Du har ikke tilladelse til at slå overvågning fra for denne bestilling.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Helpdesk'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Afdelinger'; // ditto
$txt['shd_new_ticket'] = 'Indlæg Ny Bestilling';
$txt['shd_new_ticket_proxy'] = 'Indlæg Proxy Bestilling';
$txt['shd_helpdesk_profile'] = 'Helpdesk Profil';
$txt['shd_welcome'] = 'Velkommen, %s)';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Gå til billet';
$txt['shd_options'] = 'Indstillinger';
$txt['shd_search_menu'] = 'Søg';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Information';
$txt['shd_admin_options'] = 'Indstillinger';
$txt['shd_admin_custom_fields'] = 'Brugerdefinerede Felter';
$txt['shd_admin_departments'] = 'Afdelinger';
$txt['shd_admin_permissions'] = 'Rettigheder';
$txt['shd_admin_plugins'] = 'Plugins';
$txt['shd_admin_cannedreplies'] = 'Canned Svar';
$txt['shd_admin_maint'] = 'Vedligeholdelse';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Her kan du indsende nye billetter til webstedet personale til at handle, og tjekke på nuværende billetter allerede undervejs.';
$txt['shd_staff_greeting'] = 'Her er alle de billetter, der kræver opmærksomhed.';
$txt['shd_shd_greeting'] = 'Dette er Helpdesk. Her spilder du din tid til at hjælpe nybegyndere. God fornøjelse! ;D';
$txt['shd_closed_user_greeting'] = 'Disse er alle de lukkede/løste billetter du har sendt til helpdesk.';
$txt['shd_closed_staff_greeting'] = 'Disse er alle lukkede/løst billetter sendt til helpdesk.';
$txt['shd_category_filter'] = 'Kategori filtrering';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Din billet er blevet oprettet!';
$txt['shd_ticket_posted_body'] = 'Tak for din opslag på din billet, {membername}!' . "\n\n" . 'helpdesk personalet vil gennemgå det og komme tilbage til dig så hurtigt som muligt.' . "\n\n" . 'I mellemtiden kan du se din billet, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; på følgende URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Åbn en anden billet[/iurl] - [iurl={helpdesklink}]Tilbage til hovedhelpdesk[/iurl] - [iurl={forumlink}]Tilbage til forummet[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Du kan aktivere e-mail notifikationer om ændringer af din billet i området [iurl={prefslink}]Helpdesk Preferences[/iurl].';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Hilsen' . "\n" . 'Teamet {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Billet detaljer';
$txt['shd_ticket_updated'] = 'Opdateret';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Navn';
$txt['shd_ticket_user'] = 'Bruger';
$txt['shd_ticket_date'] = 'Sendt';
$txt['shd_ticket_urgency'] = 'Nødsituation';
$txt['shd_ticket_assigned'] = 'Tildelt';
$txt['shd_ticket_assignedto'] = 'Tildelt til';
$txt['shd_ticket_started_by'] = 'Startet af';
$txt['shd_ticket_updated_by'] = 'Opdateret af';
$txt['shd_ticket_status'] = 'Status';
$txt['shd_ticket_num_replies'] = 'Svar';
$txt['shd_ticket_replies'] = 'Svar';
$txt['shd_ticket_staff'] = 'Personale medlem';
$txt['shd_ticket_attachments'] = 'Vedhæftninger';
$txt['shd_ticket_reply_number'] = 'Svar <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Bestilling På Hold';
$txt['shd_ticket'] = 'Bestilling';
$txt['shd_reply_written'] = 'Svar skrevet %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Aldrig';
$txt['shd_linktree_tickets'] = 'Bestillinger';
$txt['shd_ticket_privacy'] = 'Privatliv';
$txt['shd_ticket_notprivate'] = 'Ikke Privat';
$txt['shd_ticket_private'] = 'Privat';
$txt['shd_ticket_change'] = 'Skift';
$txt['shd_ticket_ip'] = 'IP adresse';
$txt['shd_back_to_hd'] = 'Tilbage til helpdesk';
$txt['shd_go_to_replies'] = 'Gå til svar';
$txt['shd_go_to_action_log'] = 'Gå til handlingslog';
$txt['shd_go_to_replies_start'] = 'Gå til det første svar';

$txt['shd_ticket_has_been_deleted'] = 'Denne billet er i øjeblikket i papirkurven og kan ikke ændres uden at blive returneret til helpdesk.';
$txt['shd_ticket_replies_deleted'] = 'Denne billet har fået svar slettet fra det tidligere.';
$txt['shd_ticket_replies_deleted_view'] = 'Disse vises med en farvet baggrund. <a href="%1$s">Se billetten uden sletninger</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Venligst <a href="%1$s">klik her</a> for at se dem.';

$txt['shd_ticket_notnew'] = 'Du har allerede set dette';
$txt['shd_ticket_new'] = 'Nyt!';

$txt['shd_linktree_move_ticket'] = 'Flyt regning';
$txt['shd_linktree_move_topic'] = 'Flyt emne til helpdesk';

$txt['shd_cancel_ticket'] = 'Annuller og returnér til bestillingen';
$txt['shd_cancel_home'] = 'Annuller og vend tilbage til helpdesk hjem';
$txt['shd_cancel_topic'] = 'Annuller og vend tilbage til emnet';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Svar på bestilling';
$txt['shd_ticket_quote'] = 'Svar med citat';
$txt['shd_go_advanced'] = 'Gå avanceret!';
$txt['shd_ticket_edit_reply'] = 'Rediger svar';
$txt['shd_ticket_quote_short'] = 'Tilbud';
$txt['shd_ticket_markunread'] = 'Markér som ulæst';
$txt['shd_ticket_reply_short'] = 'Svar';
$txt['shd_ticket_edit'] = 'Rediger';
$txt['shd_ticket_resolved'] = 'Markering løst';
$txt['shd_ticket_unresolved'] = 'Markér uløst';
$txt['shd_ticket_assign'] = 'Tildel';
$txt['shd_ticket_assign_self'] = 'Tildel mig';
$txt['shd_ticket_reassign'] = 'Gentildel';
$txt['shd_ticket_unassign'] = 'Un-Tildel';
$txt['shd_ticket_delete'] = 'Slet';
$txt['shd_delete_confirm'] = 'Er du sikker på, at du vil slette denne bestilling? Hvis slettet, vil denne bestilling blive flyttet til genbrugsbeholder.';
$txt['shd_delete_reply_confirm'] = 'Er du sikker på, at du vil slette dette svar? Hvis slettet, vil dette svar blive flyttet til genbrugsbeholderen.';
$txt['shd_delete_attach_confirm'] = 'Er du sikker på, at du vil slette denne vedhæftning? (Dette kan ikke fortrydes!)';
$txt['shd_delete_attach'] = 'Slet denne vedhæftning';
$txt['shd_ticket_restore'] = 'Gendan';
$txt['shd_delete_permanently'] = 'Slet permanent';
$txt['shd_delete_permanently_confirm'] = 'Er du sikker på, at du vil slette denne bestilling permanent? Dette kan ikke fortrydes!';
$txt['shd_ticket_move_to_topic'] = 'Flyt til emne';
$txt['shd_move_dept'] = 'Flyt dept.';
$txt['shd_actions'] = 'Handlinger';
$txt['shd_back_to_ticket'] = 'Vend tilbage til denne bestilling efter udstationering';
$txt['shd_disable_smileys_post'] = 'Slå smileys fra i dette indlæg';
$txt['shd_resolve_this_ticket'] = 'Marker denne sag som løst';
$txt['shd_override_cf'] = 'Tilsidesæt de brugerdefinerede felter krav';
$txt['shd_silent_update'] = 'Lydløs opdatering (send ingen notifikationer)';
$txt['shd_select_notifications'] = 'Vælg personer til at give besked om dette svar...';

$txt['shd_ticket_assign_ticket'] = 'Tildel Bestilling';
$txt['shd_ticket_assign_to'] = 'Tildel bestilling til';

$txt['shd_ticket_move_dept'] = 'Flyt billet til en anden afdeling';
$txt['shd_ticket_move_to'] = 'Flyt til';
$txt['shd_current_dept'] = 'I øjeblikket i afdelingen';
$txt['shd_ticket_move'] = 'Flyt Bestilling';
$txt['shd_unknown_dept'] = 'Den angivne afdeling findes ikke.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Nyt emne';
$txt['shd_move_ticket_to_topic'] = 'Flyt billet til emne';
$txt['shd_move_ticket'] = 'Flyt regning';
$txt['shd_ticket_board'] = 'Bræt';
$txt['shd_change_ticket_subject'] = 'Ændre billet emne';
$txt['shd_move_send_pm'] = 'Send en PM til bestillingsejeren';
$txt['shd_move_why'] = 'Angiv en kort beskrivelse af, hvorfor denne bestilling flyttes til et forum emne.';
$txt['shd_ticket_moved_subject'] = 'Din bestilling er blevet flyttet.';
$txt['shd_move_default'] = 'Hej {user},' . "\n\n" . 'Din billet, {subject}, er blevet flyttet fra helpdesk til et emne i forummet.' . "\n" . 'Du kan finde din billet i tavlen {board} eller via dette link:' . "\n\n" . '{link}' . "\n\n" . 'Tak';

$txt['shd_move_topic_to_ticket'] = 'Flyt emne til helpdesk';
$txt['shd_move_topic'] = 'Flyt emne';
$txt['shd_change_topic_subject'] = 'Ændre emne';
$txt['shd_move_send_pm_topic'] = 'Send en PM til emnet starter';
$txt['shd_move_why_topic'] = 'Angiv en kort beskrivelse af hvorfor dette emne bliver flyttet til helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Dit emne er blevet flyttet.';
$txt['shd_move_default_topic'] = 'Hej {user},' . "\n\n" . 'Dit emne, {subject}, er blevet flyttet fra forummet til sektionen Helpdesk.' . "\n" . 'Du kan finde dit emne via dette link:' . "\n\n" . '{link}' . "\n\n" . 'Tak';

$txt['shd_user_no_hd_access'] = 'Bemærk: Den person, der startede dette emne, kan ikke se helpdesk!';
$txt['shd_user_helpdesk_access'] = 'Personen der startede dette emne kan se helpdesk.';
$txt['shd_user_hd_access_dept_1'] = 'Den person, der startede dette emne, kan se følgende afdeling: ';
$txt['shd_user_hd_access_dept'] = 'Den person, der startede dette emne, kan se følgende afdelinger: ';
$txt['shd_move_ticket_department'] = 'Flyt billet til hvilken afdeling';
$txt['shd_move_dept_why'] = 'Angiv en kort beskrivelse af, hvorfor denne billet flyttes til en anden afdeling.';
$txt['shd_move_dept_default'] = 'Hej {user},' . "\n\n" . 'Din billet, {subject}, er blevet flyttet fra {current_dept} afdeling til {new_dept} afdelingen.' . "\n" . 'Du kan finde din billet via dette link:' . "\n\n" . '{link}' . "\n\n" . 'Tak';

$txt['shd_ticket_move_deleted'] = 'Denne billet har svar, der i øjeblikket er i papirkurven. Hvad ønsker du at gøre?';
$txt['shd_ticket_move_deleted_abort'] = 'Abort, tage mig til papirkurven';
$txt['shd_ticket_move_deleted_delete'] = 'Fortsæt, opgiv de slettede svar (flyt dem ikke ind i det nye emne)';
$txt['shd_ticket_move_deleted_undelete'] = 'Fortsæt, genopretter svarene (flyt dem ind i det nye emne)';

$txt['shd_ticket_move_cfs'] = 'Denne bestilling har brugerdefinerede felter, der muligvis skal flyttes.';
$txt['shd_ticket_move_cfs_warn'] = 'Nogle af disse felter er muligvis ikke synlige for andre brugere. Disse felter er angivet med et udråbstegn.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Du kan se dette felt, andre brugere kan ikke - men når det bliver en del af forummet, det vil blive synligt for alle, der kan få adgang til forummet.';
$txt['shd_ticket_move_cfs_purge'] = 'Slet feltets indhold';
$txt['shd_ticket_move_cfs_embed'] = 'Holde feltet og sætte det i det nye emne';
$txt['shd_ticket_move_cfs_user'] = 'I øjeblikket synlig for almindelige brugere';
$txt['shd_ticket_move_cfs_staff'] = 'I øjeblikket synlig for personalet';
$txt['shd_ticket_move_cfs_admin'] = 'I øjeblikket synlig for administratorer';
$txt['shd_ticket_move_accept'] = 'Jeg accepterer, at nogle af de felter, der manipuleres her, ikke er synlige for alle brugere og at dette emne skal flyttes til forummet, med ovenstående indstillinger.';
$txt['shd_ticket_move_reqd'] = 'Denne indstilling skal være valgt for at du kan flytte denne billet til forummet.';
$txt['shd_ticket_move_ok'] = 'Dette felt er sikkert at flytte, alle de brugere, der kan se billetten kan se dette felt, der er ingen oplysninger skjult for brugere eller personale.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Denne billet har felter, som brugere eller personale måske ikke kan se som sådan skal du specifikt bekræfte, at du er opmærksom på dette - gå tilbage til den forrige side, afkrydsningsfeltet for at bekræfte din bevidsthed om dette er i bunden af formularen.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Papirkurven';
$txt['shd_recycle_greeting'] = 'Dette er genbrugsskraldespanden. Alle slettede billetter går her, men medarbejdere med særlige tilladelser kan fjerne billetter permanent herfra.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Opret sag';
$txt['shd_edit_ticket'] = 'Rediger bestilling';
$txt['shd_edit_ticket_linktree'] = 'Rediger bestilling (%s)';
$txt['shd_ticket_subject'] = 'Sagens emne';
$txt['shd_ticket_proxy'] = 'Indlæg på vegne af';
$txt['shd_ticket_post_error'] = 'Følgende problem eller problemer opstod under forsøget på at skrive denne bestilling';
$txt['shd_reply_ticket'] = 'Svar på bestilling';
$txt['shd_reply_ticket_linktree'] = 'Svar på bestilling (%s)';
$txt['shd_edit_reply_linktree'] = 'Rediger svar (%s)';
$txt['shd_previewing_ticket'] = 'Forhåndsvisning af regning';
$txt['shd_previewing_reply'] = 'Forhåndsvisning af svar til';
$txt['shd_choose_one'] = '[Vælg en]';
$txt['shd_no_value'] = '[ingen værdi]';
$txt['shd_ticket_dept'] = 'Bestillings afdeling';
$txt['shd_select_dept'] = '-- Vælg en afdeling --';
$txt['canned_replies'] = 'Tilføj et foruddefineret svar:';
$txt['canned_replies_select'] = '-- Vælg et svar --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Helpdesk svar indsendt fra IP (interval)';
$txt['shd_no_replies_from_ip'] = 'Ingen helpdesk svar fra den angivne IP (interval) fundet';
$txt['shd_replies_from_ip_desc'] = 'Nedenfor er en liste over alle beskeder sendt til helpdesk fra denne IP (område).';
$txt['shd_is_ticket_opener'] = ' (billet starter)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2 arkiv';
$txt['shd_attachtype_gz'] = 'Gzip arkiv';
$txt['shd_attachtype_rar'] = 'Rar / WinRAR arkiv';
$txt['shd_attachtype_zip'] = 'Zip arkiv';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) lydfil';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windows Bitmap- billede';
$txt['shd_attachtype_gif'] = 'Grafisk ændringsformat (GIF)-billede';
$txt['shd_attachtype_jpeg'] = 'Billede fra Joint Photographic Experts Group (JPEG)';
$txt['shd_attachtype_jpg'] = 'Billede fra Joint Photographic Experts Group (JPEG)';
$txt['shd_attachtype_png'] = 'Portabelt billede af netværk Grafisk (PNG)';
$txt['shd_attachtype_svg'] = 'Grafisk (SVG) billede med skalerbar vektor';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Video film';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Word-dokument';
$txt['shd_attachtype_mdb'] = 'Microsoft Access database';
$txt['shd_attachtype_ppt'] = 'Microsoft Powerpoint præsentation';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ kildefil';
$txt['shd_attachtype_php'] = 'PHP script';
$txt['shd_attachtype_py'] = 'Python kildefil';
$txt['shd_attachtype_rb'] = 'Ruby kildefil';
$txt['shd_attachtype_sql'] = 'SQL script';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KML- arkiv)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Portable Document File';
$txt['shd_attachtype_psd'] = 'Adobe Photoshop dokument';
$txt['shd_attachtype_swf'] = 'Adobe Flash- fil';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Eksekverbar fil (Windows)';
$txt['shd_attachtype_htm'] = 'Hypertext Markup Document (HTML)';
$txt['shd_attachtype_html'] = 'Hypertext Markup Document (HTML)';
$txt['shd_attachtype_rtf'] = 'Rich Text Format (RTF)';
$txt['shd_attachtype_txt'] = 'Almindelig tekst';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Billet handling log';
$txt['shd_ticket_log_count_one'] = '1 post';
$txt['shd_ticket_log_count_more'] = '%s poster';
$txt['shd_ticket_log_none'] = 'Denne billet har ikke haft nogen ændringer.';
$txt['shd_ticket_log_member'] = 'Medlem';
$txt['shd_ticket_log_ip'] = 'Medlem Ip:';
$txt['shd_ticket_log_date'] = 'Dato';
$txt['shd_ticket_log_action'] = 'Handling';
$txt['shd_ticket_log_full'] = 'Gå til den fulde handlingslog (alle bestillinger)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Relaterede Bestillinger';
$txt['shd_ticket_create_relationship'] = 'Opret relation';
$txt['shd_ticket_delete_relationship'] = 'Slet forhold';
$txt['shd_ticket_reltype'] = 'vælg type';
$txt['shd_ticket_reltype_linked'] = 'Linket til';
$txt['shd_ticket_reltype_duplicated'] = 'Duplikeret af';
$txt['shd_ticket_reltype_parent'] = 'Forælder til';
$txt['shd_ticket_reltype_child'] = 'Barn af';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Yderligere information';
$txt['shd_ticket_additional_details'] = 'Yderligere oplysninger';
$txt['shd_ticket_empty_field'] = 'Dette felt er tomt.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Notifikationer';
$txt['shd_ticket_notify_noneprefs'] = 'Dine brugerpræferencer er ikke konto til underretning om denne bestilling.';
$txt['shd_ticket_notify_changeprefs'] = 'Skift dine præferencer';
$txt['shd_ticket_notify_because'] = 'Dine præferencer angiver at anmelde dig til svar på denne bestilling:';
$txt['shd_ticket_notify_because_yourticket'] = 'da det er din billet';
$txt['shd_ticket_notify_because_assignedyou'] = 'som det er tildelt dig';
$txt['shd_ticket_notify_because_priorreply'] = 'som du svarede på det før';
$txt['shd_ticket_notify_because_anyreply'] = 'for enhver billet';

$txt['shd_ticket_notify_me_always'] = 'Du overvåger denne billet (og vil modtage en notifikation på hvert svar)';
$txt['shd_ticket_monitor_on_note'] = 'Du kan overvåge alle svar på denne billet via e-mail uanset dine indstillinger:';
$txt['shd_ticket_monitor_off_note'] = 'Du kan deaktivere overvågning for denne billet og bruge dine præferencer i stedet:';
$txt['shd_ticket_monitor_on'] = 'Slå overvågning til';
$txt['shd_ticket_monitor_off'] = 'Slå overvågning fra';
$txt['shd_ticket_notify_me_never_note'] = 'Du kan ignorere e-mail-opdateringer for denne billet uanset dine indstillinger:';
$txt['shd_ticket_notify_me_never'] = 'Du har slået alle meddelelser fra for denne bestilling.';
$txt['shd_ticket_notify_me_never_on'] = 'Slå notifikationer fra';
$txt['shd_ticket_notify_me_never_off'] = 'Slå notifikationer til';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Søgningen facilitet kan ikke liste alle tilgængelige billetter. Det er i øjeblikket ved at blive undersøgt.';
$txt['shd_search_warning_admin'] = 'Søgefaciliteten kræver, at dens indeks genopbygges. Du kan opnå dette fra vedligeholdelsesoptionen i Helpdesk-området i administrationspanelet.';
$txt['shd_search'] = 'Søg Efter Bestillinger';
$txt['shd_search_results'] = 'Søg Billetter - Resultater';
$txt['shd_search_text'] = 'Ord du leder efter:';
$txt['shd_search_match'] = 'Hvad skal der matches?';
$txt['shd_search_match_all'] = 'Match alle leverede ord';
$txt['shd_search_match_any'] = 'Match alle angivne ord';
$txt['shd_search_scope'] = 'Inkludér hvilke typer billetter:';
$txt['shd_search_scope_open'] = 'Åbne bestillinger';
$txt['shd_search_scope_closed'] = 'Lukkede billetter';
$txt['shd_search_scope_recycle'] = 'Elementer i papirkurven';
$txt['shd_search_result_ticket'] = 'Bestilling %1$s';
$txt['shd_search_result_reply'] = 'Svar på bestilling %1$s';
$txt['shd_search_last_updated'] = 'Sidst opdateret:';
$txt['shd_search_ticket_opened_by'] = 'Bestilling åbnet af:';
$txt['shd_search_ticket_replied_by'] = 'Bestilling svarede ved:';
$txt['shd_search_dept'] = 'Søg i hvilke afdelinger:';

$txt['shd_search_urgency'] = 'Inkludér hvilke niveauer af uopsættelighed:';

$txt['shd_search_where'] = 'Hvilke elementer der skal søges:';
$txt['shd_search_where_tickets'] = 'Billetternes kroppe';
$txt['shd_search_where_replies'] = 'Svarene på billetter';
$txt['shd_search_where_subjects'] = 'Sagens emner';

$txt['shd_search_ticket_starter'] = 'Bestillinger startet af:';
$txt['shd_search_ticket_assignee'] = 'Billetter tildelt til:';
$txt['shd_search_ticket_named_person'] = 'Skriv navnet på de(n) person(er), du er interesseret i.';

$txt['shd_search_no_results'] = 'Ingen resultater blev fundet med de givne kriterier. Du kan ønske at gå tilbage og prøve at ændre dine søgekriterier.';
$txt['shd_search_criteria'] = 'Søgekriterier:';
$txt['shd_search_excluded'] = 'Hvis alle mulige muligheder blev valgt, er det ikke blevet inkluderet i ovenstående (f.eks. hvis alle mulige niveauer af uopsættelighed blev afkrydset, er det ikke angivet ovenfor, så du kan koncentrere dig om, hvad der er specifikt for din søgning)';
//@}