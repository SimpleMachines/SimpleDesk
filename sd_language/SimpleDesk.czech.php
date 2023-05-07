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
$txt['shd_helpdesk_maintenance'] = 'helpdesk je v současné době v <strong>režimu údržby</strong>. Pouze správci fóra a helpdesk to mohou vidět.';
$txt['shd_open_ticket'] = 'otevřený tiket';
$txt['shd_open_tickets'] = 'otevřené tikety';
$txt['shd_none'] = 'Nic';

$txt['shd_display_nojs'] = 'JavaScript není ve vašem prohlížeči povolen. Některé funkce nemusí fungovat správně (nebo vůbec) nebo se chovat neočekávaně.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Vítejte v hlavním centru správy helpdesku!';
$txt['shd_admin_title'] = 'Centrum správy Helpdesk';
$txt['shd_staff_list'] = 'Personál Helpdesku';
$txt['shd_update_available'] = 'Nová verze je k dispozici!';
$txt['shd_update_message'] = 'Byla vydána nová verze SimpleDesk. Znovu vás znovu obnovili <a href="#" id="update-link">aktualizaci na nejnovější verzi</a> , abyste zůstali v bezpečí a využili všech funkcí, které naše modifikace musí nabídnout.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Další informace o tom, co je v této verzi nové, navštivte <a href="#" id="information-link" target="_blank">naši webovou stránku</a>.</span><br>' . "\n\n" . '<strong>Jednoduchý tým</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Nízká';
$txt['shd_urgency_1'] = 'Střední';
$txt['shd_urgency_2'] = 'Vysoká';
$txt['shd_urgency_3'] = 'Velmi vysoká';
$txt['shd_urgency_4'] = 'Těžká';
$txt['shd_urgency_5'] = 'Kritický';
$txt['shd_urgency_increase'] = 'Zvýšit';
$txt['shd_urgency_decrease'] = 'Snížit';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Nové';
$txt['shd_status_1'] = 'Komentář čekajících zaměstnanců';
$txt['shd_status_2'] = 'Čekající uživatelský komentář';
$txt['shd_status_3'] = 'Resolvedení/zavřeno';
$txt['shd_status_4'] = 'Předáno inspektorovi';
$txt['shd_status_5'] = 'Eskalované - Naléhavé';
$txt['shd_status_6'] = 'Odstraněno';
$txt['shd_status_7'] = 'Pozastavit';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Nové tikety';
$txt['shd_status_1_heading'] = 'Čeká se na odpověď zaměstnanců';
$txt['shd_status_2_heading'] = 'Tikety čekají na odpověď uživatele';
$txt['shd_status_3_heading'] = 'Uzavřené tikety';
$txt['shd_status_4_heading'] = 'Tikety odkazované na inspektora';
$txt['shd_status_5_heading'] = 'Naléhavé tikety';
$txt['shd_status_6_heading'] = 'Recyklované tikety';
$txt['shd_status_7_heading'] = 'Podržet tikety';
$txt['shd_status_assigned_heading'] = 'Přiřazeno mně';
$txt['shd_status_withdeleted_heading'] = 'Tikety s odstraněnými odpověďmi';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Otevřené tikety';
$txt['shd_tickets_closed'] = 'Uzavřené tikety';
$txt['shd_tickets_recycled'] = 'Recyklované tikety';

$txt['shd_assigned'] = 'Přiřazeno';
$txt['shd_unassigned'] = 'Nepřiřazeno';

$txt['shd_read_ticket'] = 'Číst tiket';
$txt['shd_unread_ticket'] = 'Nepřečtený tiket';
$txt['shd_unread_tickets'] = 'Nepřečtené tikety';

$txt['shd_owned'] = 'Vlastněný tiket'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'tiket';
$txt['shd_count_tickets'] = 'tikety';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Nemáte oprávnění k přístupu na helpdesk.';
$txt['shd_no_ticket'] = 'Požadovaný tiket se nezdá, že by existoval.';
$txt['shd_no_reply'] = 'Odpověď tiketu, kterou máte, zřejmě neexistuje, nebo není součástí tohoto tiketu.';
$txt['shd_no_topic'] = 'Tématu, které jste požadovali, se nezdá existovat.';
$txt['shd_ticket_no_perms'] = 'Nemáte oprávnění k zobrazení tohoto tiketu.';
$txt['shd_error_no_tickets'] = 'Nebyly nalezeny žádné tikety.';
$txt['shd_inactive'] = 'helpdesk je v současné době deaktivován.';
$txt['shd_cannot_assign'] = 'Nemáte oprávnění přiřadit tikety.';
$txt['shd_cannot_assign_other'] = 'Tento tiket je již přiřazen jinému uživateli. Nemůžete jej přiřadit sám sobě - obraťte se na správce.';
$txt['shd_no_staff_assign'] = 'Nejsou nakonfigurováni žádní zaměstnanci, není možné přiřadit tiket. Obraťte se na správce.';
$txt['shd_assigned_not_permitted'] = 'Uživatel, který jste požádali o přiřazení tohoto tiketu, nemá dostatečná oprávnění k jeho zobrazení.';
$txt['shd_cannot_resolve'] = 'Nemáte oprávnění označit tento tiket jako vyřešený.';
$txt['shd_cannot_unresolve'] = 'Nemáte oprávnění k opětovnému otevření vyřešeného tiketu.';
$txt['error_shd_cannot_resolve_children'] = 'Tento tiket nemůže být v současné době uzavřen; tento tiket je nadřazen jednomu nebo více tiketům, které jsou v současné době otevřeny.';
$txt['error_shd_proxy_unknown'] = 'Uživatel, který tento tiket zveřejnil jménem neexistuje.';
$txt['shd_cannot_change_privacy'] = 'Nemáte oprávnění ke změně soukromí na tomto tiketu.';
$txt['shd_cannot_change_urgency'] = 'Nemáte oprávnění ke změně naléhavosti tohoto tiketu.';
$txt['shd_ajax_problem'] = 'Při pokusu o načtení stránky došlo k chybě. Chcete to zkusit znovu?';
$txt['shd_cannot_move_ticket'] = 'Nemáte oprávnění k přesunutí tohoto tiketu do tématu.';
$txt['shd_cannot_move_topic'] = 'Nemáte oprávnění k přesunutí tohoto tématu na tiket.';
$txt['shd_moveticket_noboards'] = 'Neexistují žádné tabule k přesunutí tohoto tiketu do!';
$txt['shd_move_no_pm'] = 'Musíte zadat důvod pro přesunutí tiketu k odeslání vlastníkovi tiketu, nebo zrušte zaškrtnutí možnosti \'Odeslat PM vlastníkovi tiketu\'.';
$txt['shd_move_no_pm_topic'] = 'Musíte zadat důvod pro přesunutí tématu, které chcete odeslat na začátek tématu, nebo zrušte zaškrtnutí možnosti \'Odeslat zprávu na začátek tématu\'.';
$txt['shd_move_topic_not_created'] = 'Nepodařilo se přesunout tiket na tabuli. Zkuste to prosím znovu.';
$txt['shd_move_ticket_not_created'] = 'Téma se nepodařilo přesunout na helpdesk. Zkuste to prosím znovu.';
$txt['shd_no_replies'] = 'Tento tiket zatím nemá žádné odpovědi.';
$txt['cannot_shd_new_ticket'] = 'Nemáte oprávnění k vytvoření nového tiketu.';
$txt['cannot_shd_edit_ticket'] = 'Nemáte oprávnění k úpravě tohoto tiketu.';
$txt['shd_cannot_reply_any'] = 'Nemáte oprávnění k odpovědi na žádné tikety.';
$txt['shd_cannot_reply_any_but_own'] = 'Nemáte oprávnění k odpovědi na jiné tikety než ty vlastní.';
$txt['shd_cannot_edit_reply_any'] = 'Nemáte oprávnění k úpravě žádných odpovědí.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Nemáte oprávnění k úpravám odpovědí na jiné tikety než vaše vlastní odpovědi.';
$txt['shd_cannot_edit_closed'] = 'Nemůžete upravovat vyřešené tikety; musíte je nejdříve označit jako nevyřešené.';
$txt['shd_cannot_edit_deleted'] = 'Nemůžete upravovat tikety v koši. Nejprve je třeba je obnovit.';
$txt['shd_cannot_reply_closed'] = 'Nemůžete odpovědět na vyřešené tikety; musíte je nejdříve označit jako nevyřešené.';
$txt['shd_cannot_reply_deleted'] = 'Nemůžete odpovědět na tikety v koši. Nejprve je třeba je obnovit.';
$txt['shd_cannot_delete_ticket'] = 'Nemáte oprávnění k odstranění tohoto tiketu.';
$txt['shd_cannot_delete_reply'] = 'Nemáte oprávnění tuto odpověď odstranit.';
$txt['shd_cannot_restore_ticket'] = 'Nemáte oprávnění obnovit tento tiket z koše.';
$txt['shd_cannot_restore_reply'] = 'Nemáte oprávnění obnovit tuto odpověď z koše.';
$txt['shd_cannot_view_resolved'] = 'Nemáte oprávnění k přístupu k vyřešeným tiketům.';
$txt['cannot_shd_access_recyclebin'] = 'Nemůžete vstoupit do koše.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Nemůžete přesunout tento tiket na fóru; existuje jedna nebo více smazaných odpovědí, ke kterým vaše současná oprávnění neumožňují přístup.';
$txt['shd_cannot_attach_ext'] = 'Typ souboru, který jste se pokusili připojit ({ext}), zde není povolen. Povolené typy souboru jsou: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Tento tiket není momentálně k dispozici ke změně.';
$txt['shd_invalid_relation'] = 'Musíte zadat platný typ vztahu pro tyto tikety.';
$txt['shd_no_relation_delete'] = 'Nelze odstranit vztah, který neexistuje.';
$txt['shd_cannot_relate_self'] = 'Nemůžete vytvořit tiket sám o sobě.';
$txt['shd_relationships_are_disabled'] = 'Vztahy s tiketem jsou momentálně zakázány.';
$txt['error_invalid_fields'] = 'Následující pole mají hodnoty, které nelze použít: %1$s';
$txt['error_missing_fields'] = 'Následující pole nebyla vyplněna a musí být: %1$s';
$txt['error_missing_multi'] = '%1$s (musí být vybráno alespoň %2$d)';
$txt['error_no_dept'] = 'Nevybrali jste oddělení, do kterého chcete vložit tento tiket.';
$txt['shd_cannot_move_dept'] = 'Nemůžete přesunout tento lístek, není tam kam ho přesunout.';
$txt['shd_no_perm_move_dept'] = 'Nemáte oprávnění přesunout tento tiket do jiného oddělení.';
$txt['cannot_shd_delete_attachment'] = 'Nemáte oprávnění odstraňovat přílohy.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Nemůžete přesunout tento tiket do tématu; jsou připojena vlastní pole, která vyžadují potvrzení pohybu správcem.';
$txt['cannot_monitor_ticket'] = 'Nemáte oprávnění zapnout sledování tohoto tiketu.';
$txt['cannot_unmonitor_ticket'] = 'Nemáte oprávnění vypnout monitorování tohoto tiketu.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Helpdesk'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Oddělení'; // ditto
$txt['shd_new_ticket'] = 'Poslat nový požadavek';
$txt['shd_new_ticket_proxy'] = 'Poslat proxy ticket';
$txt['shd_helpdesk_profile'] = 'Profil Helpdesku';
$txt['shd_welcome'] = 'Vítejte, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Přejít na tiket';
$txt['shd_options'] = 'Možnosti';
$txt['shd_search_menu'] = 'Hledat';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Informace';
$txt['shd_admin_options'] = 'Možnosti';
$txt['shd_admin_custom_fields'] = 'Vlastní pole';
$txt['shd_admin_departments'] = 'Oddělení';
$txt['shd_admin_permissions'] = 'Práva';
$txt['shd_admin_plugins'] = 'Pluginy';
$txt['shd_admin_cannedreplies'] = 'Odpověď v konzervě';
$txt['shd_admin_maint'] = 'Údržba';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Zde můžete nahrát nové tikety pro zaměstnance webu a zkontrolovat aktuální tikety, které již probíhají.';
$txt['shd_staff_greeting'] = 'Zde jsou všechny lístky, které vyžadují pozornost.';
$txt['shd_shd_greeting'] = 'Toto je Helpdesk. Zde ztrácíte čas na pomoc novinkám. Užívejte si! ;D';
$txt['shd_closed_user_greeting'] = 'Toto jsou všechny uzavřené nebo vyřešené tikety, které jste odeslali na helpdesk.';
$txt['shd_closed_staff_greeting'] = 'To vše jsou uzavřené / vyřešené tikety odeslané na helpdesk.';
$txt['shd_category_filter'] = 'Filtrování kategorií';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Váš tiket byl vytvořen!';
$txt['shd_ticket_posted_body'] = 'Děkujeme, že jste odeslali váš tiket, {membername}!' . "\n\n" . 'Pracovníci helpdesku ho zkontrolují a co nejdříve se k vám vrátí.' . "\n\n" . 'Mezitím si můžete prohlédnout svůj tiket, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; na následující adrese URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Otevřete další tiket[/iurl] | [iurl={helpdesklink}]Zpět na hlavní helpdesk[/iurl] | [iurl={forumlink}]Zpět do fóra[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Můžete zapnout e-mailová oznámení o změnách vašeho tiketu v oblasti [iurl={prefslink}]Nastavení Helpdesk[/iurl].';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'S pozdravem,' . "\n" . 'Tým {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Podrobnosti tiketu';
$txt['shd_ticket_updated'] = 'Aktualizováno';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Název';
$txt['shd_ticket_user'] = 'Uživatel';
$txt['shd_ticket_date'] = 'Odesláno';
$txt['shd_ticket_urgency'] = 'Naléhavost';
$txt['shd_ticket_assigned'] = 'Přiřazeno';
$txt['shd_ticket_assignedto'] = 'Přiřazeno k';
$txt['shd_ticket_started_by'] = 'Založil';
$txt['shd_ticket_updated_by'] = 'Aktualizoval(a)';
$txt['shd_ticket_status'] = 'Stav';
$txt['shd_ticket_num_replies'] = 'Odpovědi';
$txt['shd_ticket_replies'] = 'Odpovědi';
$txt['shd_ticket_staff'] = 'Zaměstnanec';
$txt['shd_ticket_attachments'] = 'Přílohy';
$txt['shd_ticket_reply_number'] = 'Odpověď <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Podržet ticket';
$txt['shd_ticket'] = 'Tiket';
$txt['shd_reply_written'] = 'Odpověď napsaná %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Nikdy';
$txt['shd_linktree_tickets'] = 'Vstupenky';
$txt['shd_ticket_privacy'] = 'Soukromí';
$txt['shd_ticket_notprivate'] = 'Není soukromá';
$txt['shd_ticket_private'] = 'Soukromé';
$txt['shd_ticket_change'] = 'Změnit';
$txt['shd_ticket_ip'] = 'IP adresa';
$txt['shd_back_to_hd'] = 'Zpět na helpdesk';
$txt['shd_go_to_replies'] = 'Přejít na odpovědi';
$txt['shd_go_to_action_log'] = 'Přejít na protokol akcí';
$txt['shd_go_to_replies_start'] = 'Přejít na první odpověď';

$txt['shd_ticket_has_been_deleted'] = 'Tento tiket je v současné době v koši a nemůže být změněn, aniž by byl vrácen na helpdesk.';
$txt['shd_ticket_replies_deleted'] = 'Tento tiket byl předtím z něj odstraněn.';
$txt['shd_ticket_replies_deleted_view'] = 'Ty jsou zobrazeny na barevném pozadí. <a href="%1$s">Zobrazit tiket bez smazání</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Prosím <a href="%1$s">klikněte zde</a> pro jejich zobrazení.';

$txt['shd_ticket_notnew'] = 'Již jste toto viděli';
$txt['shd_ticket_new'] = 'Nový!';

$txt['shd_linktree_move_ticket'] = 'Přesunout tiket';
$txt['shd_linktree_move_topic'] = 'Přesunout téma do helpdesku';

$txt['shd_cancel_ticket'] = 'Zrušit a vrátit se k tiketu';
$txt['shd_cancel_home'] = 'Zrušit a vrátit se na helpdesk domov';
$txt['shd_cancel_topic'] = 'Zrušit a vrátit se k tématu';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Odpovědět na tiket';
$txt['shd_ticket_quote'] = 'Odpovědět s citací';
$txt['shd_go_advanced'] = 'Přejít do pokročilého stavu!';
$txt['shd_ticket_edit_reply'] = 'Upravit odpověď';
$txt['shd_ticket_quote_short'] = 'Cenová nabídka';
$txt['shd_ticket_markunread'] = 'Označit jako nepřečtené';
$txt['shd_ticket_reply_short'] = 'Odpověď';
$txt['shd_ticket_edit'] = 'Upravit';
$txt['shd_ticket_resolved'] = 'Označit jako vyřešené';
$txt['shd_ticket_unresolved'] = 'Označit nevyřešené';
$txt['shd_ticket_assign'] = 'Přiřadit';
$txt['shd_ticket_assign_self'] = 'Přiřadit mi';
$txt['shd_ticket_reassign'] = 'Znovu přiřadit';
$txt['shd_ticket_unassign'] = 'Zrušit přiřazení';
$txt['shd_ticket_delete'] = 'Vymazat';
$txt['shd_delete_confirm'] = 'Jste si jisti, že chcete odstranit tento tiket? Pokud bude tento tiket odstraněn, bude přesunut do koše.';
$txt['shd_delete_reply_confirm'] = 'Jste si jisti, že chcete odstranit tuto odpověď? Pokud bude tato odpověď odstraněna, bude přesunuta do recyklačního koše.';
$txt['shd_delete_attach_confirm'] = 'Opravdu chcete odstranit tuto přílohu? (Tuto akci nelze vrátit!)';
$txt['shd_delete_attach'] = 'Odstranit tuto přílohu';
$txt['shd_ticket_restore'] = 'Obnovit';
$txt['shd_delete_permanently'] = 'Trvale odstranit';
$txt['shd_delete_permanently_confirm'] = 'Jste si jisti, že chcete trvale odstranit tento tiket? Tento požadavek NENÍ vráceno zpět!';
$txt['shd_ticket_move_to_topic'] = 'Přesunout do tématu';
$txt['shd_move_dept'] = 'Přesunout dept.';
$txt['shd_actions'] = 'Akce';
$txt['shd_back_to_ticket'] = 'Návrat k tomuto tiketu po odeslání';
$txt['shd_disable_smileys_post'] = 'Vypnout smajlíky v tomto příspěvku';
$txt['shd_resolve_this_ticket'] = 'Označit tento tiket jako vyřešený';
$txt['shd_override_cf'] = 'Přepsat požadavky na vlastní pole';
$txt['shd_silent_update'] = 'Tichá aktualizace (bez upozornění)';
$txt['shd_select_notifications'] = 'Vyberte osoby, které chcete informovat o této odpovědi...';

$txt['shd_ticket_assign_ticket'] = 'Přiřadit tiket';
$txt['shd_ticket_assign_to'] = 'Přiřadit tiket k';

$txt['shd_ticket_move_dept'] = 'Přesunout tiket do jiného oddělení';
$txt['shd_ticket_move_to'] = 'Přesunout do';
$txt['shd_current_dept'] = 'Momentálně v oddělení';
$txt['shd_ticket_move'] = 'Přesunout tiket';
$txt['shd_unknown_dept'] = 'Zadané oddělení neexistuje.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Nový předmět';
$txt['shd_move_ticket_to_topic'] = 'Přesunout tiket do tématu';
$txt['shd_move_ticket'] = 'Přesunout tiket';
$txt['shd_ticket_board'] = 'Šachovnice';
$txt['shd_change_ticket_subject'] = 'Změnit předmět tiketu';
$txt['shd_move_send_pm'] = 'Poslat PM vlastníkovi tiketu';
$txt['shd_move_why'] = 'Zadejte prosím stručný popis toho, proč je tento tiket přesunut na téma fóra.';
$txt['shd_ticket_moved_subject'] = 'Váš tiket byl přesunut.';
$txt['shd_move_default'] = 'Dobrý den {user},' . "\n\n" . 'Tiket, {subject}, byl přesunut z helpdesku do tématu ve fóru.' . "\n" . 'Váš tiket můžete najít na šachovnici {board} nebo pomocí tohoto odkazu:' . "\n\n" . '{link}' . "\n\n" . 'Děkujeme';

$txt['shd_move_topic_to_ticket'] = 'Přesunout téma do helpdesku';
$txt['shd_move_topic'] = 'Přesunout téma';
$txt['shd_change_topic_subject'] = 'Změnit téma téma';
$txt['shd_move_send_pm_topic'] = 'Poslat PM na začátek tématu';
$txt['shd_move_why_topic'] = 'Zadejte prosím stručný popis toho, proč se toto téma přesouvá na helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Téma bylo přesunuto.';
$txt['shd_move_default_topic'] = 'Dobrý den {user},' . "\n\n" . 'Vaše téma, {subject}, bylo přesunuto z fóra do sekce Helpdesk.' . "\n" . 'Téma můžete najít pomocí tohoto odkazu:' . "\n\n" . '{link}' . "\n\n" . 'Děkujeme';

$txt['shd_user_no_hd_access'] = 'Poznámka: Osoba, která začala toto téma, nemůže vidět helpdesk!';
$txt['shd_user_helpdesk_access'] = 'Osoba, která začala toto téma, může vidět helpdesk.';
$txt['shd_user_hd_access_dept_1'] = 'Osoba, která začala toto téma, může vidět následující oddělení: ';
$txt['shd_user_hd_access_dept'] = 'Osoba, která začala toto téma, může vidět následující oddělení: ';
$txt['shd_move_ticket_department'] = 'Přesunout tiket do kterého oddělení';
$txt['shd_move_dept_why'] = 'Zadejte prosím stručný popis toho, proč je tento tiket přesunut do jiného oddělení.';
$txt['shd_move_dept_default'] = 'Dobrý den {user},' . "\n\n" . 'Tiket, {subject}, byl přesunut z oddělení {current_dept} do oddělení {new_dept}.' . "\n" . 'Pomocí tohoto odkazu můžete najít svůj tiket:' . "\n\n" . '{link}' . "\n\n" . 'Děkujeme';

$txt['shd_ticket_move_deleted'] = 'Tento tiket má odpovědi, které jsou momentálně v koši. Co chcete udělat?';
$txt['shd_ticket_move_deleted_abort'] = 'Přerušit, přesunout mě do koše';
$txt['shd_ticket_move_deleted_delete'] = 'Pokračovat, opustit odstraněné odpovědi (nepřesuňte je do nového tématu)';
$txt['shd_ticket_move_deleted_undelete'] = 'Pokračovat, zrušit smazání odpovědí (přesunout je do nového tématu)';

$txt['shd_ticket_move_cfs'] = 'Tento tiket má vlastní pole, která mohou být přesunuta.';
$txt['shd_ticket_move_cfs_warn'] = 'Některá z těchto polí nemusí být viditelná pro ostatní uživatele. Tato pole jsou označena vykřičníkem.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Toto pole můžete vidět, ostatní uživatelé nemohou - ale jakmile se stane součástí fóra, bude viditelná pro každého, kdo bude mít přístup na toto fórum.';
$txt['shd_ticket_move_cfs_purge'] = 'Odstranit obsah pole';
$txt['shd_ticket_move_cfs_embed'] = 'Ponechat pole a vložit ho do nového tématu';
$txt['shd_ticket_move_cfs_user'] = 'Aktuálně viditelné pro běžné uživatele';
$txt['shd_ticket_move_cfs_staff'] = 'Momentálně viditelné pro zaměstnance';
$txt['shd_ticket_move_cfs_admin'] = 'Aktuálně viditelné administrátorům';
$txt['shd_ticket_move_accept'] = 'Uznávám, že některá z polí, která jsou zde manipulována, nejsou viditelná pro všechny uživatele, a že toto téma by mělo být přesunuto do fóra s výše uvedeným nastavením.';
$txt['shd_ticket_move_reqd'] = 'Tato možnost musí být vybrána, abyste mohli přesunout tento tiket do fóra.';
$txt['shd_ticket_move_ok'] = 'Toto pole je bezpečné k přesunu, všichni uživatelé, kteří mohou vidět tiket, mohou vidět toto pole, nejsou žádné informace skryté od uživatelů nebo zaměstnanců.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Tento tiket má pole, které uživatelé nebo zaměstnanci nemusí vidět, jako takové, musíte potvrdit, že jste si toho vědomi - vraťte se prosím na předchozí stránku, zaškrtávací políčko pro potvrzení Vaší informovanosti o tom je dole formuláře.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Koš';
$txt['shd_recycle_greeting'] = 'Toto je recyklační koš. Všechny odstraněné tikety jdou zde, ale zaměstnanci se zvláštními oprávněními mohou tikety trvale odebrat.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Vytvořit tiket';
$txt['shd_edit_ticket'] = 'Upravit tiket';
$txt['shd_edit_ticket_linktree'] = 'Upravit tiket (%s)';
$txt['shd_ticket_subject'] = 'Předmět tiketu';
$txt['shd_ticket_proxy'] = 'Post jménem';
$txt['shd_ticket_post_error'] = 'Při pokusu o odeslání tohoto tiketu došlo k následujícímu problému nebo problémům';
$txt['shd_reply_ticket'] = 'Odpovědět na tiket';
$txt['shd_reply_ticket_linktree'] = 'Odpovědět na tiket (%s)';
$txt['shd_edit_reply_linktree'] = 'Upravit odpověď (%s)';
$txt['shd_previewing_ticket'] = 'Náhled tiketu';
$txt['shd_previewing_reply'] = 'Náhled odpovědi na';
$txt['shd_choose_one'] = '[Vyberte]';
$txt['shd_no_value'] = '[žádná hodnota]';
$txt['shd_ticket_dept'] = 'Oddělení tiketů';
$txt['shd_select_dept'] = '-- Vyberte oddělení --';
$txt['canned_replies'] = 'Přidat předdefinovanou odpověď:';
$txt['canned_replies_select'] = '-- Vyberte odpověď --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Helpdesk odpovědi zveřejněné z IP (rozsah)';
$txt['shd_no_replies_from_ip'] = 'Na zadané IP (rozsah) nebyly nalezeny žádné odpovědi helpdesk';
$txt['shd_replies_from_ip_desc'] = 'Níže je seznam všech zpráv odeslaných na helpdesk z této IP (rozsah).';
$txt['shd_is_ticket_opener'] = ' (starší tiket)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2 archiv';
$txt['shd_attachtype_gz'] = 'GZip archiv';
$txt['shd_attachtype_rar'] = 'Archiv Rar/WinRAR';
$txt['shd_attachtype_zip'] = 'Archiv Zip';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) audio soubor';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windows Bitmap obrázek';
$txt['shd_attachtype_gif'] = 'Obrázek GIFu ve výměnném formátu (GIF)';
$txt['shd_attachtype_jpeg'] = 'Obrázek skupiny společných fotografických odborníků (JPEG)';
$txt['shd_attachtype_jpg'] = 'Obrázek skupiny společných fotografických odborníků (JPEG)';
$txt['shd_attachtype_png'] = 'Obrázek přenosného síťového grafu (PNG)';
$txt['shd_attachtype_svg'] = 'Škálovatelný obraz vektorové grafiky (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Video film';
// Office formats
$txt['shd_attachtype_doc'] = 'Dokument Microsoft Word';
$txt['shd_attachtype_mdb'] = 'Databáze přístupu Microsoft';
$txt['shd_attachtype_ppt'] = 'Prezentace Microsoft Powerpoint';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ zdrojový soubor';
$txt['shd_attachtype_php'] = 'PHP skript';
$txt['shd_attachtype_py'] = 'Zdrojový soubor Pythonu';
$txt['shd_attachtype_rb'] = 'Ruby zdrojový soubor';
$txt['shd_attachtype_sql'] = 'SQL skript';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KML archiv)';
$txt['shd_attachtype_pdf'] = 'Soubor přenosného dokumentu AHe Acrobat';
$txt['shd_attachtype_psd'] = 'Adobe Photoshop dokument';
$txt['shd_attachtype_swf'] = 'Adobe Flash soubor';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Spustitelný soubor (Windows)';
$txt['shd_attachtype_htm'] = 'Hypertextová značka dokumentu (HTML)';
$txt['shd_attachtype_html'] = 'Hypertextová značka dokumentu (HTML)';
$txt['shd_attachtype_rtf'] = 'Formát Rich Text (RTF)';
$txt['shd_attachtype_txt'] = 'Prostý text';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Protokol akce tiketu';
$txt['shd_ticket_log_count_one'] = '1 záznam';
$txt['shd_ticket_log_count_more'] = '%s položek';
$txt['shd_ticket_log_none'] = 'Tento tiket neprošel žádnou změnou.';
$txt['shd_ticket_log_member'] = 'Člen';
$txt['shd_ticket_log_ip'] = 'Člen IP:';
$txt['shd_ticket_log_date'] = 'Datum:';
$txt['shd_ticket_log_action'] = 'Akce';
$txt['shd_ticket_log_full'] = 'Přejít na celý protokol akcí (všechny tikety)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Související tikety';
$txt['shd_ticket_create_relationship'] = 'Vytvořit vztah';
$txt['shd_ticket_delete_relationship'] = 'Odstranit vztah';
$txt['shd_ticket_reltype'] = 'vyberte typ';
$txt['shd_ticket_reltype_linked'] = 'Propojeno s';
$txt['shd_ticket_reltype_duplicated'] = 'Duplikovat';
$txt['shd_ticket_reltype_parent'] = 'Nadřazený';
$txt['shd_ticket_reltype_child'] = 'Dítě z';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Další informace';
$txt['shd_ticket_additional_details'] = 'Další podrobnosti';
$txt['shd_ticket_empty_field'] = 'Toto pole je prázdné.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Oznámení';
$txt['shd_ticket_notify_noneprefs'] = 'Vaše uživatelské předvolby pro oznámení tohoto tiketu nemají.';
$txt['shd_ticket_notify_changeprefs'] = 'Změnit své předvolby';
$txt['shd_ticket_notify_because'] = 'Vaše předvolby vám oznamují odpovědi na tento tiket:';
$txt['shd_ticket_notify_because_yourticket'] = 'protože je to váš tiket';
$txt['shd_ticket_notify_because_assignedyou'] = 'jak je vám přiřazeno';
$txt['shd_ticket_notify_because_priorreply'] = 'jak jste na to odpověděli dříve';
$txt['shd_ticket_notify_because_anyreply'] = 'pro jakýkoli letenku';

$txt['shd_ticket_notify_me_always'] = 'Sledujete tento tiket (a budete dostávat upozornění při každé odpovědi)';
$txt['shd_ticket_monitor_on_note'] = 'Všechny odpovědi na tento tiket můžete sledovat e-mailem bez ohledu na vaše předvolby:';
$txt['shd_ticket_monitor_off_note'] = 'Monitorování tohoto tiketu můžete vypnout a místo toho použít vaše nastavení:';
$txt['shd_ticket_monitor_on'] = 'Zapnout sledování';
$txt['shd_ticket_monitor_off'] = 'Vypnout sledování';
$txt['shd_ticket_notify_me_never_note'] = 'Aktualizaci tohoto tiketu můžete ignorovat bez ohledu na vaše předvolby:';
$txt['shd_ticket_notify_me_never'] = 'Zakázali jste všechna oznámení pro tento tiket.';
$txt['shd_ticket_notify_me_never_on'] = 'Vypnout oznámení';
$txt['shd_ticket_notify_me_never_off'] = 'Zapnout oznámení';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Vyhledávací zařízení nesmí uvádět všechny dostupné tikety; je v současné době vyšetřováno.';
$txt['shd_search_warning_admin'] = 'Vyhledávací zařízení vyžaduje, aby byl přebudován index. Toho můžete dosáhnout z volby údržby v oblasti Helpdesku v administraci.';
$txt['shd_search'] = 'Hledat tikety';
$txt['shd_search_results'] = 'Hledat tikety - výsledky';
$txt['shd_search_text'] = 'Slova, která hledáte:';
$txt['shd_search_match'] = 'Co by se mělo vyrovnat?';
$txt['shd_search_match_all'] = 'Porovnejte všechna dodaná slova';
$txt['shd_search_match_any'] = 'Porovnejte všechna zadaná slova';
$txt['shd_search_scope'] = 'Zahrnout typy přepravních dokladů:';
$txt['shd_search_scope_open'] = 'Otevřené tikety';
$txt['shd_search_scope_closed'] = 'Uzavřené tikety';
$txt['shd_search_scope_recycle'] = 'Předměty v koši na recyklaci';
$txt['shd_search_result_ticket'] = 'Tiket %1$s';
$txt['shd_search_result_reply'] = 'Odpovědět na tiket %1$s';
$txt['shd_search_last_updated'] = 'Naposledy aktualizováno:';
$txt['shd_search_ticket_opened_by'] = 'Tiket otevřen:';
$txt['shd_search_ticket_replied_by'] = 'Tiket odpověděl:';
$txt['shd_search_dept'] = 'Hledat oddělení/oddělení:';

$txt['shd_search_urgency'] = 'Zahrnout jaké úrovně naléhavosti:';

$txt['shd_search_where'] = 'Které položky chcete hledat:';
$txt['shd_search_where_tickets'] = 'Těla jízdenek';
$txt['shd_search_where_replies'] = 'Odpovědi v tiketech';
$txt['shd_search_where_subjects'] = 'Předměty ticketu';

$txt['shd_search_ticket_starter'] = 'Vstupenky začaly:';
$txt['shd_search_ticket_assignee'] = 'Tikety přiřazeny:';
$txt['shd_search_ticket_named_person'] = 'Zadejte jméno osoby, o kterou máte zájem.';

$txt['shd_search_no_results'] = 'Nebyly nalezeny žádné výsledky s zadanými kritérii. Možná se chcete vrátit a pokusit se změnit svá kritéria vyhledávání.';
$txt['shd_search_criteria'] = 'Vyhledávací kritéria:';
$txt['shd_search_excluded'] = 'Pokud byla vybrána každá z možných možností, nebyla zahrnuta do výše uvedeného (např. pokud byly zaškrtnuty všechny možné úrovně naléhavosti, není uvedeno výše, takže se můžete soustředit na to, co je specifické pro vaše vyhledávání)';
//@}