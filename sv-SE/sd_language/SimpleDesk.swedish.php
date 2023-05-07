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
$txt['shd_helpdesk_maintenance'] = 'Hjälpdisken är för närvarande i <strong>underhållsläge</strong>. Endast forum- och helpdesk-administratörer kan se detta.';
$txt['shd_open_ticket'] = 'öppna ärende';
$txt['shd_open_tickets'] = 'öppna biljetter';
$txt['shd_none'] = 'Ingen';

$txt['shd_display_nojs'] = 'JavaScript är inte aktiverat i din webbläsare. Vissa funktioner kanske inte fungerar korrekt (eller överhuvudtaget) eller beter sig på ett oväntat sätt.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Välkommen till det huvudsakliga helpdeskadministrationscentret!';
$txt['shd_admin_title'] = 'Helpdesk Administration Center';
$txt['shd_staff_list'] = 'Helpdesk-personal';
$txt['shd_update_available'] = 'Ny version tillgänglig!';
$txt['shd_update_message'] = 'En ny version av SimpleDesk har släppts. Vi rekommenderar dig att <a href="#" id="update-link">uppdatera till den senaste versionen</a> för att hålla dig säker och njuta av alla funktioner som vår ändring har att erbjuda.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>För mer information om vad som är nytt i denna utgåva, besök <a href="#" id="information-link" target="_blank">vår hemsida</a>.</span><br>' . "\n\n" . '<strong>Teamet för SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Låg';
$txt['shd_urgency_1'] = 'Medel';
$txt['shd_urgency_2'] = 'Hög';
$txt['shd_urgency_3'] = 'Mycket hög';
$txt['shd_urgency_4'] = 'Allvarlig';
$txt['shd_urgency_5'] = 'Kritisk';
$txt['shd_urgency_increase'] = 'Öka';
$txt['shd_urgency_decrease'] = 'Minska';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Ny';
$txt['shd_status_1'] = 'Väntande handläggare kommentar';
$txt['shd_status_2'] = 'Väntande användarkommentar';
$txt['shd_status_3'] = 'Löst/Stängd';
$txt['shd_status_4'] = 'Hänvisad till Handledare';
$txt['shd_status_5'] = 'Eskalerad - Brådskande';
$txt['shd_status_6'] = 'Borttagen';
$txt['shd_status_7'] = 'På håll';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Nya ärenden';
$txt['shd_status_1_heading'] = 'Ärenden väntar personal svar';
$txt['shd_status_2_heading'] = 'Ärenden väntar på användarsvar';
$txt['shd_status_3_heading'] = 'Stängda ärenden';
$txt['shd_status_4_heading'] = 'Ärenden som hänvisas till handläggaren';
$txt['shd_status_5_heading'] = 'Brådskande ärenden';
$txt['shd_status_6_heading'] = 'Återvunna ärenden';
$txt['shd_status_7_heading'] = 'På Hold Biljetter';
$txt['shd_status_assigned_heading'] = 'Tilldelad till mig';
$txt['shd_status_withdeleted_heading'] = 'Ärenden med borttagna svar';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Öppna ärenden';
$txt['shd_tickets_closed'] = 'Stängda ärenden';
$txt['shd_tickets_recycled'] = 'Återvunna ärenden';

$txt['shd_assigned'] = 'Tilldelad';
$txt['shd_unassigned'] = 'Otilldelad';

$txt['shd_read_ticket'] = 'Läs ärende';
$txt['shd_unread_ticket'] = 'Olästa ärende';
$txt['shd_unread_tickets'] = 'Olästa ärenden';

$txt['shd_owned'] = 'Ägt ärende'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'Ärende';
$txt['shd_count_tickets'] = 'Biljetter';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Du har inte behörighet att komma åt helpdesken.';
$txt['shd_no_ticket'] = 'Ärendet du har begärt verkar inte existera.';
$txt['shd_no_reply'] = 'Ärendesvaret du har begäran verkar inte existera, eller är inte en del av detta ärende.';
$txt['shd_no_topic'] = 'Ämnet du har begärt verkar inte existera.';
$txt['shd_ticket_no_perms'] = 'Du har inte behörighet att se det ärendet.';
$txt['shd_error_no_tickets'] = 'Inga ärenden hittades.';
$txt['shd_inactive'] = 'Hjälpdisken är för närvarande inaktiverad.';
$txt['shd_cannot_assign'] = 'Du har inte tillåtelse att tilldela biljetter.';
$txt['shd_cannot_assign_other'] = 'Detta ärende är redan tilldelat en annan användare. Du kan inte tilldela det till dig själv - kontakta administratören.';
$txt['shd_no_staff_assign'] = 'Det finns ingen personal konfigurerad; det går inte att tilldela ett ärende. Kontakta administratören.';
$txt['shd_assigned_not_permitted'] = 'Användaren du har begärt att tilldela detta ärende till har inte tillräcklig behörighet för att se det.';
$txt['shd_cannot_resolve'] = 'Du har inte behörighet att markera detta ärende som löst.';
$txt['shd_cannot_unresolve'] = 'Du har inte behörighet att öppna ett ärende igen.';
$txt['error_shd_cannot_resolve_children'] = 'Detta ärende kan för närvarande inte stängas; detta ärende är förälder till ett eller flera ärenden som för närvarande är öppna.';
$txt['error_shd_proxy_unknown'] = 'Användaren detta ärende läggs upp på uppdrag av finns inte.';
$txt['shd_cannot_change_privacy'] = 'Du har inte behörighet att ändra sekretessen på detta ärende.';
$txt['shd_cannot_change_urgency'] = 'Du har inte behörighet att ändra brådskan på detta ärende.';
$txt['shd_ajax_problem'] = 'Det gick inte att ladda sidan. Vill du försöka igen?';
$txt['shd_cannot_move_ticket'] = 'Du har inte behörighet att flytta detta ärende till ett ämne.';
$txt['shd_cannot_move_topic'] = 'Du har inte behörighet att flytta detta ämne till ett ärende.';
$txt['shd_moveticket_noboards'] = 'Det finns inga tavlor att flytta detta ärende till!';
$txt['shd_move_no_pm'] = 'Du måste ange en anledning för att flytta biljetten för att skicka till ärendeägaren, eller avmarkera alternativet för att \'skicka ett PM till ärendeägaren\'.';
$txt['shd_move_no_pm_topic'] = 'Du måste ange en anledning för att flytta ämnet för att skicka till ämnet starter, eller avmarkera alternativet för att \'skicka ett PM till startmeddelande\'.';
$txt['shd_move_topic_not_created'] = 'Det gick inte att flytta ärendet till tavlan. Försök igen.';
$txt['shd_move_ticket_not_created'] = 'Det gick inte att flytta ämnet till helpdesk. Försök igen.';
$txt['shd_no_replies'] = 'Detta ärende har inga svar än.';
$txt['cannot_shd_new_ticket'] = 'Du har inte behörighet att skapa ett nytt ärende.';
$txt['cannot_shd_edit_ticket'] = 'Du har inte behörighet att redigera detta ärende.';
$txt['shd_cannot_reply_any'] = 'Du har inte behörighet att svara på några biljetter.';
$txt['shd_cannot_reply_any_but_own'] = 'Du har inte behörighet att svara på något annat än dina egna.';
$txt['shd_cannot_edit_reply_any'] = 'Du har inte behörighet att redigera några svar.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Du har inte behörighet att redigera svar på andra ärenden än dina egna svar.';
$txt['shd_cannot_edit_closed'] = 'Du kan inte redigera lösta ärenden, du måste markera det olöst först.';
$txt['shd_cannot_edit_deleted'] = 'Du kan inte redigera ärenden i papperskorgen. De måste återställas först.';
$txt['shd_cannot_reply_closed'] = 'Du kan inte svara på lösta ärenden; du måste markera dem olösta först.';
$txt['shd_cannot_reply_deleted'] = 'Du kan inte svara på ärenden i papperskorgen. De måste återställas först.';
$txt['shd_cannot_delete_ticket'] = 'Du har inte tillåtelse att ta bort detta ärende.';
$txt['shd_cannot_delete_reply'] = 'Det är inte tillåtet att ta bort det svaret.';
$txt['shd_cannot_restore_ticket'] = 'Du har inte tillåtelse att återställa detta ärende från papperskorgen.';
$txt['shd_cannot_restore_reply'] = 'Du har inte tillåtelse att återställa det svaret från papperskorgen.';
$txt['shd_cannot_view_resolved'] = 'Du har inte tillåtelse att komma åt lösta ärenden.';
$txt['cannot_shd_access_recyclebin'] = 'Du kan inte komma åt papperskorgen.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Du kan inte flytta detta ärende till forumet; det finns ett eller flera raderade svar, som dina nuvarande behörigheter inte tillåter åtkomst till.';
$txt['shd_cannot_attach_ext'] = 'Den typ av fil som du har försökt bifoga ({ext}) är inte tillåtet här. De tillåtna typerna av fil är: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Detta ärende är för närvarande inte tillgängligt för ändring.';
$txt['shd_invalid_relation'] = 'Du måste ange en giltig typ av relation för dessa biljetter.';
$txt['shd_no_relation_delete'] = 'Du kan inte ta bort en relation som inte finns.';
$txt['shd_cannot_relate_self'] = 'Du kan inte göra ett ärende relaterat till sig själv.';
$txt['shd_relationships_are_disabled'] = 'Ärenderelationer är för närvarande inaktiverade.';
$txt['error_invalid_fields'] = 'Följande fält har värden som inte kan användas: %1$s';
$txt['error_missing_fields'] = 'Följande fält har inte slutförts och måste vara: %1$s';
$txt['error_missing_multi'] = '%1$s (minst %2$d måste väljas)';
$txt['error_no_dept'] = 'Du valde inte en avdelning att lägga in detta ärende i.';
$txt['shd_cannot_move_dept'] = 'Du kan inte flytta detta ärende, det finns ingenstans att flytta det till.';
$txt['shd_no_perm_move_dept'] = 'Du har inte tillåtelse att flytta detta ärende till en annan avdelning.';
$txt['cannot_shd_delete_attachment'] = 'Du har inte behörighet att ta bort bilagor.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Du kan inte flytta detta ärende till ett ämne; det finns anpassade fält bifogade som kräver att en administratör bekräftar flytten.';
$txt['cannot_monitor_ticket'] = 'Du har inte tillåtelse att aktivera övervakning för detta ärende.';
$txt['cannot_unmonitor_ticket'] = 'Du har inte tillåtelse att stänga av övervakningen för detta ärende.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Helpdesk'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Avdelningar'; // ditto
$txt['shd_new_ticket'] = 'Posta nytt ärende';
$txt['shd_new_ticket_proxy'] = 'Skicka proxyärende';
$txt['shd_helpdesk_profile'] = 'Helpdesk-profil';
$txt['shd_welcome'] = 'Välkommen, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Gå till ärende';
$txt['shd_options'] = 'Alternativ';
$txt['shd_search_menu'] = 'Sök';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Information';
$txt['shd_admin_options'] = 'Alternativ';
$txt['shd_admin_custom_fields'] = 'Anpassade fält';
$txt['shd_admin_departments'] = 'Avdelningar';
$txt['shd_admin_permissions'] = 'Behörigheter';
$txt['shd_admin_plugins'] = 'Tillägg';
$txt['shd_admin_cannedreplies'] = 'Konserverade svar';
$txt['shd_admin_maint'] = 'Underhåll';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Här kan du skicka in nya ärenden till webbplatsens personal för att handla, och kolla på aktuella ärenden som redan är på gång.';
$txt['shd_staff_greeting'] = 'Här är alla biljetter som kräver uppmärksamhet.';
$txt['shd_shd_greeting'] = 'Detta är Helpdesk. Här slösar du din tid för att hjälpa nybörjare. Njut! ;D';
$txt['shd_closed_user_greeting'] = 'Dessa är alla stängda/lösta ärenden som du har lagt upp i helpdesken.';
$txt['shd_closed_staff_greeting'] = 'Dessa är alla stängda/lösta ärenden inskickade till helpdesken.';
$txt['shd_category_filter'] = 'Kategori filtrering';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Ditt ärende har skapats!';
$txt['shd_ticket_posted_body'] = 'Tack för att du postade din biljett, {membername}!' . "\n\n" . 'Personalen kommer att granska det och komma tillbaka till dig så snart som möjligt.' . "\n\n" . 'Under tiden kan du se ditt ärende, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; på följande URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Öppna ett annat ärende[/iurl] <unk> [iurl={helpdesklink}]Tillbaka till huvudsupporten[/iurl] <unk> [iurl={forumlink}]Tillbaka till forumet[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Du kan aktivera e-postmeddelanden om ändringar i ditt ärende, i området [iurl={prefslink}]Helpdesk Inställningar[/iurl].';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Hälsningar' . "\n" . 'Teamet {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Ärende detaljer';
$txt['shd_ticket_updated'] = 'Uppdaterad';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Namn';
$txt['shd_ticket_user'] = 'Användare';
$txt['shd_ticket_date'] = 'Inlagd';
$txt['shd_ticket_urgency'] = 'Nödvändig';
$txt['shd_ticket_assigned'] = 'Tilldelad';
$txt['shd_ticket_assignedto'] = 'Tilldelad till';
$txt['shd_ticket_started_by'] = 'Startad av';
$txt['shd_ticket_updated_by'] = 'Uppdaterad av';
$txt['shd_ticket_status'] = 'Status';
$txt['shd_ticket_num_replies'] = 'Svar';
$txt['shd_ticket_replies'] = 'Svar';
$txt['shd_ticket_staff'] = 'Medlem i personalen';
$txt['shd_ticket_attachments'] = 'Bilagor';
$txt['shd_ticket_reply_number'] = 'Svara <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Biljett Pågående';
$txt['shd_ticket'] = 'Ärende';
$txt['shd_reply_written'] = 'Svara skriven %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Aldrig';
$txt['shd_linktree_tickets'] = 'Ärenden';
$txt['shd_ticket_privacy'] = 'Sekretess';
$txt['shd_ticket_notprivate'] = 'Inte privat';
$txt['shd_ticket_private'] = 'Privat';
$txt['shd_ticket_change'] = 'Ändra';
$txt['shd_ticket_ip'] = 'IP-adress';
$txt['shd_back_to_hd'] = 'Tillbaka till helpdesk';
$txt['shd_go_to_replies'] = 'Gå till svar';
$txt['shd_go_to_action_log'] = 'Gå till åtgärdsloggen';
$txt['shd_go_to_replies_start'] = 'Gå till det första svaret';

$txt['shd_ticket_has_been_deleted'] = 'Detta ärende är för närvarande i papperskorgen och kan inte ändras utan att returneras till helpdesk.';
$txt['shd_ticket_replies_deleted'] = 'Detta ärende har tagits bort från det tidigare.';
$txt['shd_ticket_replies_deleted_view'] = 'Dessa visas med en färgad bakgrund. <a href="%1$s">Visa ärendet utan borttagningar</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Vänligen <a href="%1$s">klicka här</a> för att se dem.';

$txt['shd_ticket_notnew'] = 'Du har redan sett detta';
$txt['shd_ticket_new'] = 'Ny!';

$txt['shd_linktree_move_ticket'] = 'Flytta ärende';
$txt['shd_linktree_move_topic'] = 'Flytta ämnet till helpdesk';

$txt['shd_cancel_ticket'] = 'Avboka och återgå till biljetten';
$txt['shd_cancel_home'] = 'Avboka och återgå till helpdesk hem';
$txt['shd_cancel_topic'] = 'Avbryt och återgå till ämnet';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Svara på ärende';
$txt['shd_ticket_quote'] = 'Svara med offert';
$txt['shd_go_advanced'] = 'Gå avancerad!';
$txt['shd_ticket_edit_reply'] = 'Redigera svar';
$txt['shd_ticket_quote_short'] = 'Offert';
$txt['shd_ticket_markunread'] = 'Markera som oläst';
$txt['shd_ticket_reply_short'] = 'Svara';
$txt['shd_ticket_edit'] = 'Redigera';
$txt['shd_ticket_resolved'] = 'Markera som löst';
$txt['shd_ticket_unresolved'] = 'Markera som olöst';
$txt['shd_ticket_assign'] = 'Tilldela';
$txt['shd_ticket_assign_self'] = 'Tilldela mig';
$txt['shd_ticket_reassign'] = 'Omtilldela';
$txt['shd_ticket_unassign'] = 'Av-tilldela';
$txt['shd_ticket_delete'] = 'Radera';
$txt['shd_delete_confirm'] = 'Är du säker på att du vill ta bort detta ärende? Om detta tas bort kommer detta ärende att flyttas till återvinningsbehållaren.';
$txt['shd_delete_reply_confirm'] = 'Är du säker på att du vill ta bort detta svar? Om detta tas bort, kommer detta svar att flyttas till återvinningsbehållaren.';
$txt['shd_delete_attach_confirm'] = 'Är du säker på att du vill ta bort denna bilaga? (Detta kan inte ångras)';
$txt['shd_delete_attach'] = 'Ta bort denna bilaga';
$txt['shd_ticket_restore'] = 'Återställ';
$txt['shd_delete_permanently'] = 'Radera permanent';
$txt['shd_delete_permanently_confirm'] = 'Är du säker på att du vill ta bort detta ärende permanent? Detta kan INTE ångras!';
$txt['shd_ticket_move_to_topic'] = 'Flytta till ämne';
$txt['shd_move_dept'] = 'Flytta avbetalning.';
$txt['shd_actions'] = 'Åtgärder';
$txt['shd_back_to_ticket'] = 'Återgå till detta ärende efter inlägg';
$txt['shd_disable_smileys_post'] = 'Stäng av smileys i det här inlägget';
$txt['shd_resolve_this_ticket'] = 'Markera detta ärende som löst';
$txt['shd_override_cf'] = 'Åsidosätt kraven för anpassade fält';
$txt['shd_silent_update'] = 'Tyst uppdatering (skicka inga meddelanden)';
$txt['shd_select_notifications'] = 'Välj personer att meddela om detta svar...';

$txt['shd_ticket_assign_ticket'] = 'Tilldela ärende';
$txt['shd_ticket_assign_to'] = 'Tilldela biljett till';

$txt['shd_ticket_move_dept'] = 'Flytta ärendet till en annan avdelning';
$txt['shd_ticket_move_to'] = 'Flytta till';
$txt['shd_current_dept'] = 'För närvarande i avdelningen';
$txt['shd_ticket_move'] = 'Flytta ärende';
$txt['shd_unknown_dept'] = 'Den angivna avdelningen finns inte.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Nytt ämne';
$txt['shd_move_ticket_to_topic'] = 'Flytta ärende till ämne';
$txt['shd_move_ticket'] = 'Flytta ärende';
$txt['shd_ticket_board'] = 'Bräde';
$txt['shd_change_ticket_subject'] = 'Ändra ärendeämnet';
$txt['shd_move_send_pm'] = 'Skicka ett PM till ärendeägaren';
$txt['shd_move_why'] = 'Ange en kort beskrivning om varför ärendet flyttas till ett forum-ämne.';
$txt['shd_ticket_moved_subject'] = 'Ditt ärende har flyttats.';
$txt['shd_move_default'] = 'Hej {user},' . "\n\n" . 'Ditt ärende, {subject}, har flyttats från helpdesk till ett ämne i forumet.' . "\n" . 'Du kan hitta ditt ärende i tavlan {board} eller via denna länk:' . "\n\n" . '{link}' . "\n\n" . 'Tack';

$txt['shd_move_topic_to_ticket'] = 'Flytta ämnet till helpdesk';
$txt['shd_move_topic'] = 'Flytta ämne';
$txt['shd_change_topic_subject'] = 'Ändra ämne';
$txt['shd_move_send_pm_topic'] = 'Skicka ett PM till startsidan';
$txt['shd_move_why_topic'] = 'Ange en kort beskrivning om varför detta ämne flyttas till helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Ditt ämne har flyttats.';
$txt['shd_move_default_topic'] = 'Hej {user},' . "\n\n" . 'Ditt ämne, {subject}, har flyttats från forumet till avsnittet Helpdesk.' . "\n" . 'Du hittar ditt ämne via denna länk:' . "\n\n" . '{link}' . "\n\n" . 'Tack';

$txt['shd_user_no_hd_access'] = 'Obs: personen som startade detta ämne kan inte se helpdesk!';
$txt['shd_user_helpdesk_access'] = 'Den person som startade detta ämne kan se helpdesken.';
$txt['shd_user_hd_access_dept_1'] = 'Den person som startade detta ämne kan se följande avdelning: ';
$txt['shd_user_hd_access_dept'] = 'Den person som startade detta ämne kan se följande avdelningar: ';
$txt['shd_move_ticket_department'] = 'Flytta ärende till vilken avdelning';
$txt['shd_move_dept_why'] = 'Ange en kort beskrivning om varför ärendet flyttas till en annan avdelning.';
$txt['shd_move_dept_default'] = 'Hej {user},' . "\n\n" . 'Ditt ärende, {subject}, har flyttats från avdelningen {current_dept} till avdelningen {new_dept}.' . "\n" . 'Du kan hitta din biljett via denna länk:' . "\n\n" . '{link}' . "\n\n" . 'Tack';

$txt['shd_ticket_move_deleted'] = 'Detta ärende har svar som för närvarande finns i papperskorgen. Vad vill du göra?';
$txt['shd_ticket_move_deleted_abort'] = 'Abort, ta mig till papperskorgen';
$txt['shd_ticket_move_deleted_delete'] = 'Fortsätt, överge de raderade svaren (flytta dem inte in i det nya ämnet)';
$txt['shd_ticket_move_deleted_undelete'] = 'Fortsätt, ta bort svaren (flytta dem till det nya ämnet)';

$txt['shd_ticket_move_cfs'] = 'Detta ärende har anpassade fält som kan behöva flyttas.';
$txt['shd_ticket_move_cfs_warn'] = 'Vissa av dessa fält kanske inte är synliga för andra användare. Dessa fält är markerade med ett utropstecken.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Du kan se detta fält, andra användare kan inte - men när det blir en del av forumet, det kommer att bli synligt för alla som kan komma åt forumet.';
$txt['shd_ticket_move_cfs_purge'] = 'Ta bort innehållet i fältet';
$txt['shd_ticket_move_cfs_embed'] = 'Behåll fältet och lägg det i det nya ämnet';
$txt['shd_ticket_move_cfs_user'] = 'För närvarande synlig för vanliga användare';
$txt['shd_ticket_move_cfs_staff'] = 'För närvarande synlig för personal';
$txt['shd_ticket_move_cfs_admin'] = 'För närvarande synlig för administratörer';
$txt['shd_ticket_move_accept'] = 'Jag accepterar att vissa av de fält som manipuleras här inte är synliga för alla användare, och att detta ämne bör flyttas till forumet, med ovanstående inställningar.';
$txt['shd_ticket_move_reqd'] = 'Det här alternativet måste väljas för att du ska kunna flytta ärendet till forumet.';
$txt['shd_ticket_move_ok'] = 'Detta fält är säkert att flytta, alla användare som kan se ärendet kan se detta fält, det finns ingen information som är dold för användare eller personal.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Detta ärende har fält som användare eller personal kanske inte kan se, som sådan behöver du särskilt bekräfta att du är medveten om detta - gå tillbaka till föregående sida, kryssrutan för att bekräfta din medvetenhet om detta är längst ner i formuläret.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Papperskorgen';
$txt['shd_recycle_greeting'] = 'Detta är återvinningsbehållaren. Alla raderade biljetter går hit, men personal med särskilda tillstånd kan ta bort ärenden permanent härifrån.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Skapa ärende';
$txt['shd_edit_ticket'] = 'Redigera ärende';
$txt['shd_edit_ticket_linktree'] = 'Redigera ärende (%s)';
$txt['shd_ticket_subject'] = 'Ärende ämne';
$txt['shd_ticket_proxy'] = 'Posta på uppdrag av';
$txt['shd_ticket_post_error'] = 'Följande problem, eller problem, inträffade när ärendet skulle postas';
$txt['shd_reply_ticket'] = 'Svara på ärende';
$txt['shd_reply_ticket_linktree'] = 'Svara på ärende (%s)';
$txt['shd_edit_reply_linktree'] = 'Redigera svar (%s)';
$txt['shd_previewing_ticket'] = 'Förhandsgranskar ärende';
$txt['shd_previewing_reply'] = 'Förhandsgranskar svar på';
$txt['shd_choose_one'] = '[Välj en]';
$txt['shd_no_value'] = '[inget värde]';
$txt['shd_ticket_dept'] = 'Ärendeavdelning';
$txt['shd_select_dept'] = '-- Välj en avdelning --';
$txt['canned_replies'] = 'Lägg till ett fördefinierat svar:';
$txt['canned_replies_select'] = '-- Välj ett svar --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Helpdesk svar postat från IP (range)';
$txt['shd_no_replies_from_ip'] = 'Inga svar från den angivna IP (intervall) hittades';
$txt['shd_replies_from_ip_desc'] = 'Nedan följer en lista över alla meddelanden som postats till helpdesk från detta IP (sortiment).';
$txt['shd_is_ticket_opener'] = ' (ärendestart)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2 arkiv';
$txt['shd_attachtype_gz'] = 'GZip arkiv';
$txt['shd_attachtype_rar'] = 'Sällan/WinRAR arkiv';
$txt['shd_attachtype_zip'] = 'Postnummer arkiv';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) ljudfil';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windows Bitmap bild';
$txt['shd_attachtype_gif'] = 'Graphics Interchange Format (GIF) bild';
$txt['shd_attachtype_jpeg'] = 'Joint Photographic Experts Group (JPEG) bild';
$txt['shd_attachtype_jpg'] = 'Joint Photographic Experts Group (JPEG) bild';
$txt['shd_attachtype_png'] = 'Portabel nätverksgrafik (PNG) bild';
$txt['shd_attachtype_svg'] = 'Skalbar Vektorgrafik (SVG) bild';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Video film';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Word-dokument';
$txt['shd_attachtype_mdb'] = 'Microsoft Access-databas';
$txt['shd_attachtype_ppt'] = 'Microsoft Powerpoint-presentation';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ källfil';
$txt['shd_attachtype_php'] = 'PHP-skript';
$txt['shd_attachtype_py'] = 'Python källfil';
$txt['shd_attachtype_rb'] = 'Ruby källfil';
$txt['shd_attachtype_sql'] = 'SQL skript';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KML arkiv)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Portable Document File';
$txt['shd_attachtype_psd'] = 'Adobe Photoshop dokument';
$txt['shd_attachtype_swf'] = 'Adobe Flash-fil';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Körbar fil (Windows)';
$txt['shd_attachtype_htm'] = 'Hypertext markeringsdokument (HTML)';
$txt['shd_attachtype_html'] = 'Hypertext markeringsdokument (HTML)';
$txt['shd_attachtype_rtf'] = 'Rich Text Format (RTF)';
$txt['shd_attachtype_txt'] = 'Oformaterad text';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Ärendehanteringslogg';
$txt['shd_ticket_log_count_one'] = '1 post';
$txt['shd_ticket_log_count_more'] = '%s poster';
$txt['shd_ticket_log_none'] = 'Detta ärende har inte fått några ändringar.';
$txt['shd_ticket_log_member'] = 'Medlem';
$txt['shd_ticket_log_ip'] = 'Medlems IP:';
$txt['shd_ticket_log_date'] = 'Datum';
$txt['shd_ticket_log_action'] = 'Åtgärd';
$txt['shd_ticket_log_full'] = 'Gå till den fullständiga åtgärdsloggen (Alla ärenden)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Relaterade ärenden';
$txt['shd_ticket_create_relationship'] = 'Skapa relation';
$txt['shd_ticket_delete_relationship'] = 'Ta bort relation';
$txt['shd_ticket_reltype'] = 'välj typ';
$txt['shd_ticket_reltype_linked'] = 'Länkad till';
$txt['shd_ticket_reltype_duplicated'] = 'Duplicera av';
$txt['shd_ticket_reltype_parent'] = 'Förälder till';
$txt['shd_ticket_reltype_child'] = 'Barn till';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Ytterligare information';
$txt['shd_ticket_additional_details'] = 'Ytterligare detaljer';
$txt['shd_ticket_empty_field'] = 'Detta fält är tomt.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Aviseringar';
$txt['shd_ticket_notify_noneprefs'] = 'Dina användarinställningar konto inte för anmälan av detta ärende.';
$txt['shd_ticket_notify_changeprefs'] = 'Ändra dina inställningar';
$txt['shd_ticket_notify_because'] = 'Dina inställningar indikerar att du får svar på detta ärende:';
$txt['shd_ticket_notify_because_yourticket'] = 'eftersom det är din biljett';
$txt['shd_ticket_notify_because_assignedyou'] = 'som det är tilldelat till dig';
$txt['shd_ticket_notify_because_priorreply'] = 'som du svarade på det innan';
$txt['shd_ticket_notify_because_anyreply'] = 'för alla ärenden';

$txt['shd_ticket_notify_me_always'] = 'Du övervakar detta ärende (och kommer att få ett meddelande om varje svar)';
$txt['shd_ticket_monitor_on_note'] = 'Du kan övervaka alla svar på detta ärende via e-post oavsett dina önskemål:';
$txt['shd_ticket_monitor_off_note'] = 'Du kan stänga av övervakning för detta ärende och använda dina inställningar istället:';
$txt['shd_ticket_monitor_on'] = 'Aktivera övervakning';
$txt['shd_ticket_monitor_off'] = 'Stäng av övervakning';
$txt['shd_ticket_notify_me_never_note'] = 'Du kan ignorera e-postuppdateringar för detta ärende oavsett dina preferenser:';
$txt['shd_ticket_notify_me_never'] = 'Du har inaktiverat alla aviseringar för detta ärende.';
$txt['shd_ticket_notify_me_never_on'] = 'Stäng av aviseringar';
$txt['shd_ticket_notify_me_never_off'] = 'Aktivera aviseringar';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Sökfunktionen kanske inte listar alla tillgängliga ärenden; den undersöks för närvarande.';
$txt['shd_search_warning_admin'] = 'Sökfunktionen kräver att indexet byggs om. Du kan göra detta genom att välja underhåll, i Helpdesk-området, i administrationspanelen.';
$txt['shd_search'] = 'Sök ärenden';
$txt['shd_search_results'] = 'Sök ärenden - Resultat';
$txt['shd_search_text'] = 'Ord du söker efter:';
$txt['shd_search_match'] = 'Vad ska matchas?';
$txt['shd_search_match_all'] = 'Matcha alla angivna ord';
$txt['shd_search_match_any'] = 'Matcha alla ord som anges';
$txt['shd_search_scope'] = 'Inkludera vilka typer av biljetter:';
$txt['shd_search_scope_open'] = 'Öppna biljetter';
$txt['shd_search_scope_closed'] = 'Stängda ärenden';
$txt['shd_search_scope_recycle'] = 'Objekt i papperskorgen';
$txt['shd_search_result_ticket'] = 'Ärende %1$s';
$txt['shd_search_result_reply'] = 'Svara på ärende %1$s';
$txt['shd_search_last_updated'] = 'Senast uppdaterad:';
$txt['shd_search_ticket_opened_by'] = 'Biljett öppnades av:';
$txt['shd_search_ticket_replied_by'] = 'Ärendet svarade på:';
$txt['shd_search_dept'] = 'Sök i vilken avdelning(er):';

$txt['shd_search_urgency'] = 'Inkludera vilka nivåer av brådskande:';

$txt['shd_search_where'] = 'Vilka objekt att söka:';
$txt['shd_search_where_tickets'] = 'De organ av biljetter';
$txt['shd_search_where_replies'] = 'Svaren i ärenden';
$txt['shd_search_where_subjects'] = 'Ärendeämnen';

$txt['shd_search_ticket_starter'] = 'Ärenden startades av:';
$txt['shd_search_ticket_assignee'] = 'Ärenden tilldelade till:';
$txt['shd_search_ticket_named_person'] = 'Skriv in namnet på den person du är intresserad av.';

$txt['shd_search_no_results'] = 'Inga resultat hittades med de angivna kriterierna. Du kanske vill gå tillbaka och försöka ändra dina sökkriterier.';
$txt['shd_search_criteria'] = 'Sökkriterier:';
$txt['shd_search_excluded'] = 'Om alla alternativ var valda, har det inte inkluderats i ovanstående (t.ex. om alla möjliga nivåer av brådska har markerats, det anges inte ovan, så du kan koncentrera dig på vad som är specifikt för din sökning)';
//@}