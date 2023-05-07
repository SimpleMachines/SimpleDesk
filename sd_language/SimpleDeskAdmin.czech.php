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
* File Info: SimpleDeskAdmin.english.php                      *
**************************************************************/
// Version: 2.1; SimpleDesk administration options

// Important! Before editing these language files please read the text at the top of index.english.php.

/**
 *	This file contains all of the language strings used in SimpleDesk's administration panel which is loaded throughout the SMF admin area.
 *
 *	@package language
 *	@todo Document the text groups in this file.
 *	@since 1.0
 */

//! @name The 'Core Features' page item
//@{
$txt['core_settings_item_shd'] = 'Helpdesk';
$txt['core_settings_item_shd_desc'] = 'helpdesk vám umožní rozšířit vaše fórum do odvětví služeb tím, že poskytnete pomoc pro zaměstnance uživatelů.';
//@}

//! @name Items for general SMF/ACP integration
//@{
$txt['errortype_simpledesk'] = 'SimpleDesk';
$txt['errortype_simpledesk_desc'] = 'Chyby se s největší pravděpodobností vztahují k SimpleDesku. Nahlaste prosím všechny takové chyby na www.simpledesk.net.';
$txt['errortype_sdplugin'] = 'Plugin SimpleDesk';
$txt['errortype_sdplugin_desc'] = 'Chyby s největší pravděpodobností souvisí s pluginem SimpleDesk. Název souboru by měl obecně označovat plugin, abyste mohli zkontrolovat, kdo je autor.';
$txt['scheduled_task_simpledesk'] = 'Denní údržba SimpleDesk';
$txt['scheduled_task_desc_simpledesk'] = 'Úkoly údržby a interní zpracování jsou spouštěny denně pro SimpleDesk. Není doporučeno tento úkol zakázat.';

$txt['lang_file_desc_SimpleDesk'] = 'Hlavní helpdesk';
$txt['lang_file_desc_SimpleDeskAdmin'] = 'Administrace Helpdesku';
$txt['lang_file_desc_SimpleDeskLogAction'] = 'Záznamy protokolu akcí';
$txt['lang_file_desc_SimpleDeskNotifications'] = 'E-mailová oznámení';
$txt['lang_file_desc_SimpleDeskPermissions'] = 'Práva';
$txt['lang_file_desc_SimpleDeskProfile'] = 'Profilová oblast';
$txt['lang_file_desc_SimpleDeskWho'] = 'Kdo je online';
//@}

//! @name Items for the administration menu structure
//@{
// Admin menu items, the ones that aren't in SimpleDesk.english.php anyway...
$txt['shd_admin_standalone_options'] = 'Samostatný režim';
$txt['shd_admin_actionlog'] = 'Záznam akcí';
$txt['shd_admin_adminlog'] = 'Protokol administrace';
$txt['shd_admin_support'] = 'Podpora';
$txt['shd_admin_helpdesklog'] = 'Protokol Helpdesku';

$txt['shd_admin_options_display'] = 'Možnosti zobrazení';
$txt['shd_admin_options_posting'] = 'Možnosti odesílání';
$txt['shd_admin_options_admin'] = 'Administrativní možnosti';
$txt['shd_admin_options_standalone'] = 'Samostatné možnosti';
$txt['shd_admin_options_actionlog'] = 'Možnosti protokolu akcí';
$txt['shd_admin_options_notifications'] = 'Možnosti oznámení';
//@}

//! @name Descriptions for the page items.
//@{
$txt['shd_admin_info_desc'] = 'Toto je informační centrum pro helpdesk, poháněné společností SimpleDesk. Zde můžete získat nejnovější zprávy i podporu pro konkrétní verzi.';
$txt['shd_admin_options_desc'] = 'Toto je obecný konfigurační prostor helpdesk, kde lze nastavit některé základní možnosti.';
$txt['shd_admin_options_display_desc'] = 'V této oblasti můžete změnit některá nastavení, která upravují zobrazení vašeho helpdesku.';
$txt['shd_admin_options_posting_desc'] = 'Zde můžete upravit nastavení příspěvků, jako je BBC, smajlíky a přílohy.';
$txt['shd_admin_options_admin_desc'] = 'Zde můžete nastavit některé obecné administrativní možnosti pro helpdesk.';
$txt['shd_admin_options_standalone_desc'] = 'Tato oblast spravuje samostatný režim helpdesku, který fakticky znemožňuje část instalace SMF.';
$txt['shd_admin_options_actionlog_desc'] = 'Tato oblast vám umožňuje nakonfigurovat položky v protokolu akce helpdesk.';
$txt['shd_admin_options_notifications_desc'] = 'Tato oblast vám umožňuje nakonfigurovat e-mailová oznámení, která budou zasílána uživatelům, když se jejich tikety změní.';
$txt['shd_admin_actionlog_desc'] = 'Toto je seznam všech akcí, jako jsou vyřešené tikety, upravované tikety a další akce prováděné v helpdesk.';
$txt['shd_admin_adminlog_desc'] = 'Toto je seznam všech správcovských akcí, jako jsou změněné možnosti, konzervované odpovědi, změny oddělení.';
$txt['shd_admin_support_desc'] = 'Tato oblast vám pomůže dostat se do SimpleDesk. et quickly and effective - post bude obsahovat informace užitečné pro náš tým podpory, o vaší instalaci (jako je SMF verze a verze SimpleDesku).';
$txt['shd_admin_help'] = 'Toto je panel administrace pro helpdesk. Zde můžete spravovat nastavení, získávat zprávy a aktualizovat o této úpravě a prohlížet helpdesk logy.';
//@}

//! @name SimpleDesk info center
//@{
$txt['shd_live_from'] = 'Živě z SimpleDesk.net';
$txt['shd_no_connect'] = 'Nelze načíst soubor zpráv z simpledesk.net';
$txt['shd_current_version'] = 'Aktuální verze';
$txt['shd_your_version'] = 'Vaše verze';
$txt['shd_mod_information'] = 'Mod Information';
$txt['shd_admin_readmore'] = 'Číst více';
$txt['shd_admin_help_live'] = 'Toto pole zobrazuje nejnovější zprávy a aktualizace z www.simpledesk.net. Nechte otevřené oči pro nové verze a opravy chyb. Pokud bude vydána nová verze této úpravy, uvidíte také oznámení v horní části stránky administrace helpdesk.';
$txt['shd_admin_help_modification'] = 'Toto pole obsahuje různé informace o instalaci SimpleDesk.';
$txt['shd_admin_help_credits'] = 'V tomto poli jsou uvedeni všichni lidé, kteří umožnili SimpleDesk od vývojářů skutečného kódu, na podporu týmu a beta testery.';
$txt['shd_admin_help_update'] = 'Pokud vidíte toto pole, pravděpodobně používáte zastaralou verzi SimpleDesk. Postupujte podle pokynů uvedených v oznámení, abyste mohli přejít na nové vydání.';
$txt['shd_ticket_information'] = 'Informace o tiketu';
$txt['shd_total_tickets'] = 'Celkový počet vstupenek';
$txt['shd_open_tickets'] = 'Otevřené tikety';
$txt['shd_closed_tickets'] = 'Uzavřené tikety';
$txt['shd_recycled_tickets'] = 'Recyklované vstupenky';
$txt['shd_need_support'] = 'Pomoc s SimpleDeskem?';
$txt['shd_support_start_here'] = 'Viz naše <a href="%1$s">Stránka podpory</a>';

$txt['shd_helpdesk_nojs'] = 'JavaScript není ve vašem prohlížeči povolen. Některé funkce nemusí fungovat správně (nebo vůbec) v oblasti správy.';
//@}

//! @name Translatable strings for the credits
//@{
$txt['shd_credits'] = 'Kredity SimpleDesk';
$txt['shd_credits_and'] = 'a';
$txt['shd_credits_pretext'] = 'To jsou osoby, které Jednoduchý desk umožnily. Děkujeme!';
$txt['shd_credits_devs'] = 'Vývojáři';
$txt['shd_credits_devs_desc'] = 'Vývojáři aktuálního SimpleDesk kódu.';
$txt['shd_credits_projectsupport'] = 'Projektová podpora';
$txt['shd_credits_projectsupport_desc'] = 'Správa a podpora projektu různými způsoby.';
$txt['shd_credits_marketing'] = 'Marketing';
$txt['shd_credits_marketing_desc'] = 'Ti, kteří šíří slovo SimpleDesk.';
$txt['shd_credits_globalizer'] = 'Globalizace';
$txt['shd_credits_globalizer_desc'] = 'Lidé, kteří činí SimpleDesk se šíří po celém světě.';
$txt['shd_credits_support'] = 'Podpora';
$txt['shd_credits_support_desc'] = 'Lidé, kteří poskytují všem bezmocným duším podporu, kterou potřebují.';
$txt['shd_credits_qualityassurance'] = 'Zajištění kvality';
$txt['shd_credits_qualityassurance_desc'] = 'Vedoucí představitelé testovacího týmu beta.';
$txt['shd_credits_beta'] = 'Beta testery';
$txt['shd_credits_beta_desc'] = 'Tito lidé zajistí, aby SimpleDesk žil v souladu s očekáváními.';
$txt['shd_credits_alltherest'] = 'Kdokoliv jiný, co jsme si mohli ujít...';
$txt['shd_credits_icons'] = '<a href="%1$s">Fugue</a>, <a href="%2$s">Funkce</a>, <a href="%3$s">FamFamFam Flags</a>, <a href="%4$s">sady ikon "Krystal"</a> Everaldo - hezké ikony používané SimpleDeskem';
$txt['shd_credits_user'] = '<strong>VAŠE</strong>, hrdí uživatelé SimpleDesk. Děkujeme, že jste si vybrali náš software!';
$txt['shd_credits_translators'] = 'Naši překladatelé - Díky vám, lidé po celém světě mohou používat SimpleDesk';
$txt['shd_former_contributors'] = 'Bývalí přispěvatelé jsou zvýrazněni <span class="shd_former_contributor">jasnější barvou</span>.';
//@}

//! @name Configuration items on the Display Options page
//@{
$txt['shd_staff_badge'] = 'Jaký styl odznaků, které mají být použity v zobrazení tiketu?';
$txt['shd_staff_badge_note'] = 'Při pohledu na různé odpovědi může být užitečné zobrazit odznaky, pokud máte různé týmy, které mohou reagovat v helpdesku. Může být také užitečné zobrazovat vlastní odznaky členů, nebo ne; tato volba vám umožní vybrat.';
$txt['shd_staff_badge_nobadge'] = 'Nezobrazovat žádný odznak, jen malá ikona pro zaměstnance';
$txt['shd_staff_badge_staffbadge'] = 'Zobrazit odznaky pouze zaměstnanců';
$txt['shd_staff_badge_userbadge'] = 'Zobrazit odznaky pouze pro nezaměstnané/běžné uživatele';
$txt['shd_staff_badge_bothbadge'] = 'Zobrazit odznaky uživatelů i zaměstnanců';
$txt['shd_display_avatar'] = 'Zobrazit avatary v odpovědích na tiket?';
$txt['shd_ticketnav_style'] = 'Jaký typ navigace má být použit v zobrazení tiketu?';
$txt['shd_ticketnav_style_note'] = 'Při pohledu na tikety může být k dispozici řada možností pro uživatele, včetně úprav, uzavření a odstranění. Tato možnost specifikuje různé způsoby, jak to může vypadat.';
$txt['shd_ticketnav_style_sd'] = 'Jednoduchý styl (ikona s malou textovou poznámkou)';
$txt['shd_ticketnav_style_sdcompact'] = 'Jednoduchý styl Desk (pouze ikona)';
$txt['shd_ticketnav_style_smf'] = 'SMF styl (textová tlačítka, nad požadavkem)';
$txt['shd_theme'] = 'Použít konkrétní téma ve fóru?';
$txt['shd_theme_note'] = 'Normálně helpdesk zdědí šablonu vybranou uživatelem, nebo selže, že výchozí je fórum. Tato volba vám umožní vybrat téma, které bude vždy použito v helpdesku bez ohledu na ostatní nastavení.';
$txt['shd_theme_use_default'] = 'Použít výchozí šablonu fóra';
$txt['shd_hidemenuitem'] = 'Skrýt položku nabídky Helpdesku?';
$txt['shd_hidemenuitem_note'] = 'To je nejužitečnější, pokud jsou na žebříčku prezentovány oddělení helpdesku.';
$txt['shd_hideprofilemenuitem'] = 'Skrýt položku nabídky Helpdesk profilu?';
$txt['shd_hideprofilemenuitem_note'] = 'Pokud používáte uživatelské menu, je užitečné skrýt.';
$txt['shd_disable_unread'] = 'Zakázat integraci s nepřečtenými příspěvky / nepřečtenými odpověďmi';
$txt['shd_disable_unread_note'] = 'Normálně SimpleDesk přidává seznam témat do nepřečtených příspěvků/nepřečtených odpovědí, ale někdy (např. . některé mobilní motivy) to ne vždy funguje tak dobře.';
$txt['shd_zerofill'] = 'Nejmenší počet použitých číslic';
$txt['shd_zerofill_note'] = 'Čísla vstupenek jsou obvykle vyjádřena jako 00001, to by bylo 5 číslic a letenka by neměla žádné další číslice. Můžete použít 0 aby jste neměli žádné výchozí nuly, pokud chcete.';
$txt['shd_block_order_1'] = 'Blok tiketů: 1. pozice';
$txt['shd_block_order_2'] = 'Blok tiketů: 2. pozice';
$txt['shd_block_order_3'] = 'Blok tiketů: 3. pozice';
$txt['shd_block_order_4'] = 'Blok tiketů: 4. pozice';
$txt['shd_block_order_5'] = 'Blok tiketů: 5. pozice';
$txt['shd_block_order_note'] = 'Zadejte výchozí pořadí bloků';
//@}

//! @name Configuration items on the Posting Options page
//@{
$txt['shd_thank_you_post'] = 'Zobrazit zprávu uživatelům při odeslání tiketu';
$txt['shd_thank_you_nonstaff'] = 'Zobrazit zprávu pouze těm, kteří nejsou zaměstnanci';
$txt['shd_allow_wikilinks'] = 'Povolit použití [[ticket:123]] odkazů ve stylu wiki';
$txt['shd_allow_ticket_bbc'] = 'Povolit tikety a odpovědi na použití bbcode';
$txt['shd_allow_ticket_smileys'] = 'Povolit tikety a odpovědi pro použití smajlíků';
$txt['shd_attachments_mode'] = 'Jak by se mělo zacházet s přílohami letenek?';
$txt['shd_attachments_mode_ticket'] = 'Jak je připojeno k letence';
$txt['shd_attachments_mode_reply'] = 'Jak je připojeno k jednotlivým odpovědím';
$txt['shd_attachments_mode_note'] = 'Pokud používáte režim "do tiketu", počet příloh není omezen, pokud používáte "k odpovědím", helpdesk bude používat stejná nastavení jako běžné přílohy pouze pro příspěvek. Oba režimy zkontrolují velikost přílohy a nevyplní složku příloh na základě nastavení v panelu příloh.';
$txt['shd_bbc'] = 'Povoleno BBC tagy v helpdesku';
$txt['shd_bbc_desc'] = 'Jaké značky by měly být povoleny pro použití v helpdesku?';
//@}

//! @name Configuration items on the Admin Options page
//@{
$txt['shd_maintenance_mode'] = 'Vložte helpdesk do režimu údržby';
$txt['shd_staff_ticket_self'] = 'Pokud jde o vstupenky otevřené zaměstnanci, mělo by jim být možné přiřadit vstupenku?';
$txt['shd_admins_not_assignable'] = 'Měli by být správci považováni za odděleni od zaměstnanců?';
$txt['shd_admins_not_assignable_note'] = 'Pokud je vybráno, správci fór nebudou moci být přiřazeni tikety a budou vyloučeni z přidávání jednorázových e-mailů k upozornění na novou odpověď.';
$txt['shd_privacy_display'] = 'Jaký způsob zobrazení soukromí tiketů?';
$txt['shd_privacy_display_smart'] = 'Zobrazit nastavení soukromí tiketu, pokud je to vhodné';
$txt['shd_privacy_display_always'] = 'Vždy zobrazovat nastavení soukromí tiketu';
$txt['shd_privacy_display_note'] = 'Obvykle se letenky omezují na uživatele, kteří vidí své vlastní a personál vidí všechny uživatele. Možná budete chtít, aby zaměstnanci mohli vytvářet letenky pouze pro vedoucí pracovníky - je to "soukromá" letenka. Vzhledem k tomu, že „nesoukromé“ může být pro běžné uživatele matoucí, Tato volba vám umožňuje skrýt zobrazení "nesoukromého" nebo "soukromí" pouze v případě, že je to vhodné na letence.';
$txt['shd_disable_tickettotopic'] = 'Zakázat možnosti "tiket na téma"';
$txt['shd_disable_tickettotopic_note'] = 'Obvykle je možné přesunout tikety do témat a znovu (vyjma v samostatném režimu), Tato možnost to popírá všem uživatelům bez ohledu na jejich oprávnění.';
$txt['shd_disable_relationships'] = 'Zakázat vztahy';
$txt['shd_disable_relationships_note'] = 'Zakažte tikety mít mezi sebou "vztahy" bez ohledu na jejich oprávnění.';
$txt['shd_disable_boardint'] = 'Zakázat integraci BoardIndex';
$txt['shd_disable_boardint_note'] = 'Zakázat helpdesk zcela načítat na boardIndex.';
//@}

//! @name Configuration items on the Standalone Options page
//@{
$txt['shd_helpdesk_only'] = 'Povolit režim helpdesk';
$txt['shd_helpdesk_only_note'] = 'Tímto zakážete přístup k tématům a deskám a také volitelně funkcím níže. Všimněte si, že žádná z dat není ztracena, pouze neaktivní. Následující možnosti se použijí pouze v případě, že je tento režim aktivní (pokud je fórum mimo helpdesk)';
$txt['shd_disable_pm'] = 'Zakázat zcela soukromé zprávy';
$txt['shd_disable_mlist'] = 'Zakázat seznam členů zcela';
//@}

//! @name Configuration items on the Action Log Options page
//@{
$txt['shd_disable_action_log'] = 'Zakázat protokolování helpdesk akcí?';
$txt['shd_display_ticket_logs'] = 'Zobrazit mini přihlášení v každém tiketu?';
$txt['shd_logopt_newposts'] = 'Zaznamenávat nové tikety a jejich odpovědi';
$txt['shd_logopt_editposts'] = 'Zaznamenávat úpravy tiketů a příspěvků';
$txt['shd_logopt_resolve'] = 'Logování tiketů je vyřešeno/nevyřešeno';
$txt['shd_logopt_assign'] = 'Log tiketů, které jsou přiřazeny/přeřazeny/nepřiřazeny';
$txt['shd_logopt_privacy'] = 'Zaznamenat změnu soukromí tiketu';
$txt['shd_logopt_urgency'] = 'Zaznamenat změnu naléhavosti tiketu';
$txt['shd_logopt_tickettopicmove'] = 'Logovat tikety přesunuté do témat a zpět';
$txt['shd_logopt_cfchanges'] = 'Zaznamenávat změny do vlastních polí na tiketech a odpovědích';
$txt['shd_logopt_delete'] = 'Zaznamenávat tikety a odpovědi byly odstraněny';
$txt['shd_logopt_restore'] = 'Zaznamenávat tikety a odpovědi se obnovují';
$txt['shd_logopt_permadelete'] = 'Protokol tiketů a odpovědí je permadeleten';
$txt['shd_logopt_relationships'] = 'Zaznamenat všechny změny ve vztazích s tiketem';
$txt['shd_logopt_autoclose'] = 'Logovat tikety uzavřené automaticky pomocí helpdesku';
$txt['shd_logopt_move_dept'] = 'Logovat tikety přesunuté mezi dvěma odděleními';
$txt['shd_logopt_monitor'] = 'Logovat tikety přidávané do jejich seznamů sledování/ignorování';

$txt['shd_notify_send_to'] = 'Bude odesláno na';
$txt['shd_notify_ticket_starter'] = 'uživatel, který spustil tiket (pokud je nastaven v jejich předvolbách)';
$txt['shd_notify_nobody'] = 'Nikdo';
//@}

//! @name Configuration items on the Notifications Options page
//@{
$txt['shd_notify_email'] = 'E-mailová adresa, kterou chcete použít v oznámeních, nechte prázdné pro použití výchozího fóra (%1$s)';
$txt['shd_notify_log'] = 'Zaznamenávat zasílané oznámení (jaké oznámení, když je odeslán, zúčastněný uživatel (uživatelé)';
$txt['shd_notify_with_body'] = 'Při odesílání upozornění, pošlete nový tiket nebo nový obsah odpovědi do e-mailu';
$txt['shd_notify_new_ticket'] = 'Umožnit zaměstnancům přijímat oznámení o nových tiketech';
$txt['shd_notify_new_reply_own'] = 'Umožnit uživatelům dostávat upozornění, když jsou jejich tikety zodpovězeny';
$txt['shd_notify_new_reply_assigned'] = 'Umožnit zaměstnancům přijímat oznámení, když jim přiřazené tikety odpoví';
$txt['shd_notify_new_reply_previous'] = 'Umožnit zaměstnancům dostávat upozornění, když na tikety odpověděli znovu';
$txt['shd_notify_new_reply_any'] = 'Umožnit zaměstnancům přijímat oznámení, pokud jsou na tikety odpovězeny';
$txt['shd_notify_assign_me'] = 'Umožnit zaměstnancům přijímat oznámení, když je k nim přiřazen tiket';
$txt['shd_notify_assign_own'] = 'Povolit uživatelům přijímat oznámení, když jsou jejich tikety přiřazeny zaměstnancům';
//@}

//! @name General language strings for the action log (entries are contained in SimpleDesk-LogAction.english.php)
//@{
$txt['shd_delete_item'] = 'Odstranit tuto položku';
$txt['shd_admin_actionlog_title'] = 'Protokol akcí Helpdesku';
$txt['shd_admin_actionlog_action'] = 'Akce';
$txt['shd_admin_actionlog_date'] = 'Datum:';
$txt['shd_admin_actionlog_member'] = 'Člen';
$txt['shd_admin_actionlog_position'] = 'Pozice';
$txt['shd_admin_actionlog_ip'] = 'IP adresa';
$txt['shd_admin_actionlog_none'] = 'Nebyly nalezeny žádné záznamy.';
$txt['shd_admin_actionlog_unknown'] = 'Neznámý';
$txt['shd_admin_actionlog_hidden'] = 'Hidden';
$txt['shd_admin_actionlog_removeall'] = 'Vyprázdnit celý log';
$txt['shd_admin_actionlog_removeall_confirm'] = 'Toto trvale odstraní všechny položky v protokolu akce starší než %s hodin. Jste si jisti?';
//@}

//! @name General language strings for the admin log
//@{
$txt['shd_admin_adminlog_title'] = 'Protokol administrace Helpdesk';
$txt['shd_admin_adminlog_action'] = 'Akce';
$txt['shd_admin_adminlog_name'] = 'Název';
$txt['shd_admin_adminlog_to'] = 'Komu';
$txt['shd_admin_adminlog_from'] = 'Od';
$txt['shd_admin_adminlog_setting'] = 'Nastavení';
$txt['shd_log_admin_canned'] = 'Odpověď v konzervě';
$txt['shd_log_admin_customfield'] = 'Vlastní pole';
$txt['shd_log_admin_maint'] = 'Údržba';
$txt['shd_log_admin_permissions'] = 'Práva';
$txt['shd_log_admin_plugins'] = 'Pluginy';
$txt['shd_log_admin_dept'] = 'Oddělení';
$txt['shd_log_admin_change_option'] = 'Možnosti';
$txt['shd_log_admin_canned_cat_move'] = 'Tříděné kategorie';
$txt['shd_log_admin_canned_cat_delete'] = 'Kategorie byla smazána';
$txt['shd_log_admin_canned_cat_add'] = 'Přidaná kategorie';
$txt['shd_log_admin_canned_cat_update'] = 'Aktualizovaná kategorie';
$txt['shd_log_admin_canned_reply_move'] = 'Řazená odpověď';
$txt['shd_log_admin_canned_reply_delete'] = 'Smazaná odpověď';
$txt['shd_log_admin_canned_reply_add'] = 'Přidána konzervovaná odpověď';
$txt['shd_log_admin_canned_reply_update'] = 'Aktualizovaná odpověď';
$txt['shd_log_admin_dept_move'] = 'Tříděné';
$txt['shd_log_admin_dept_delete'] = 'Odstraněno';
$txt['shd_log_admin_dept_add'] = 'Přidáno';
$txt['shd_log_admin_dept_update'] = 'Aktualizovat';
$txt['shd_log_admin_customfield_move'] = 'Tříděné';
$txt['shd_log_admin_customfield_delete'] = 'Odstraněno';
$txt['shd_log_admin_customfield_add'] = 'Přidáno';
$txt['shd_log_admin_customfield_update'] = 'Aktualizováno';
$txt['shd_log_admin_customfield_move'] = 'Tříděné';
$txt['shd_log_admin_maint_reattribute'] = 'Přeřadit tikety';
$txt['shd_log_admin_maint_move_dept'] = 'Oddělení přesunuto tiketů';
$txt['shd_log_admin_maint_findrepair'] = 'Ran Najít a opravit';
$txt['shd_log_admin_maint_clean_cache'] = 'Vyčistit mezipaměť';
$txt['shd_log_admin_maint_search_rebuild'] = 'Přebudované hledání';
$txt['shd_log_admin_permissions_create_role'] = 'Přidáno';
$txt['shd_log_admin_permissions_delete_role'] = 'Odstraněno';
$txt['shd_log_admin_permissions_change_role'] = 'Aktualizováno';
$txt['shd_log_admin_permissions_copy_role'] = 'Duplikováno';
$txt['shd_log_admin_plugins_update'] = 'Aktualizováno';
$txt['shd_log_admin_plugins_remove'] = 'Odstraněno';
//@}

//! @name Strings for the post-to-SimpleDesk.net support page
//@{
$txt['shd_admin_support_form_title'] = 'Formulář podpory';
$txt['shd_admin_support_what_is_this'] = 'Co to je?';
$txt['shd_admin_support_explanation'] = 'Tento jednoduchý formulář vám umožní poslat žádost o podporu přímo na webové stránky SimpleDesk, aby vám mohl pomoci vyřešit jakýkoli problém, kterému běžíte.<br><br>Vezměte prosím na vědomí, že budete potřebovat účet na našich webových stránkách, abyste mohli v budoucnu psát a odpovědět na vaše téma. Tento formulář jednoduše urychlí proces vkládání.';
$txt['shd_admin_support_send'] = 'Odeslat žádost o podporu';
//@}

//! @name The browse-attachments integration strings
//@{
$txt['attachment_manager_shd_attach'] = 'Přílohy Helpdesku';
$txt['attachment_manager_shd_thumb'] = 'Helpdesk miniatury';
$txt['attachment_manager_shd_attach_no_entries'] = 'V současné době nejsou žádné přílohy helpdesku.';
$txt['attachment_manager_shd_thumb_no_entries'] = 'Momentálně nejsou žádné náhledy na helpdesku.';
//@}

//! @name Custom fields stuff
//@{
$txt['shd_admin_custom_fields_long'] = 'Vlastní pole pro tikety a odpovědi';
$txt['shd_admin_custom_fields_desc'] = 'Tato sekce vám umožňuje vytvořit další pole, která mohou být přidána do tiketů nebo jejich odpovědí, shromažďovat další informace o tiketu nebo vám pomoci se správou vašeho helpdesku.';
$txt['shd_admin_custom_fields_general'] = 'Obecné detaily';

$txt['shd_admin_custom_fields_fieldname'] = 'Název pole';
$txt['shd_admin_custom_fields_fieldname_desc'] = 'Jméno zobrazené vedle místa, kde uživatel zadá informace (povinné)';
$txt['shd_admin_custom_fields_description'] = 'Popis pole';
$txt['shd_admin_custom_fields_description_desc'] = 'Popis pole, zobrazený uživateli, když zadává informace.';
$txt['shd_admin_custom_fields_icon'] = 'Ikona pole';
$txt['shd_admin_custom_fields_icon_desc'] = 'Volitelná ikona zobrazená vedle názvu pole. Chcete-li přidat vlastní ikonu (ikony), jednoduše vložte obrázek do . Tématy/výchozí/images/simpledesk/cf/ složka. Pro nejlepší výsledky by měl být obrázek 13x13png.';
$txt['shd_admin_custom_fields_fieldtype'] = 'Typ pole';
$txt['shd_admin_custom_fields_fieldtype_desc'] = 'Typ pole, které uživatel vyplní s požadovanými informacemi.';
$txt['shd_admin_custom_fields_active'] = 'Aktivní';
$txt['shd_admin_custom_fields_inactive'] = 'Neaktivní';
$txt['shd_admin_custom_fields_active_desc'] = 'Toto je hlavní přepínač pro toto pole. Pokud není aktivní, nebude zobrazen ani požadován od uživatele při vkládání.';
$txt['shd_admin_custom_fields_fielddesc'] = 'Popis pole';
$txt['shd_admin_custom_fields_fielddesc_desc'] = 'Stručný popis pole, které přidáváte.';
$txt['shd_admin_custom_fields_visible'] = 'Viditelné';
$txt['shd_admin_custom_fields_visible_ticket'] = 'Viditelný/upravitelný pro tiket';
$txt['shd_admin_custom_fields_visible_field'] = 'Viditelné/upravitelné v odpovědích';
$txt['shd_admin_custom_fields_visible_both'] = 'Viditelný/upravitelný v tiketech i odpovědích';
$txt['shd_admin_custom_fields_visible_desc'] = 'Toto určuje, zda se dané pole vztahuje na pouze tikety jako celek, na odpovědi jednotlivě nebo jak na tiket, tak na jeho odpovědi.';
$txt['shd_admin_custom_fields_none'] = '(žádný)';
$txt['shd_admin_no_custom_fields'] = 'V současné době nejsou žádná vlastní pole.';
$txt['shd_admin_custom_fields_inticket'] = 'Viditelné na tiketu';
$txt['shd_admin_custom_fields_inreply'] = 'Viditelné při odpovědi';
$txt['shd_admin_custom_fields_move'] = 'Přesunout';
$txt['shd_admin_move_up'] = 'Posunout nahoru';
$txt['shd_admin_move_down'] = 'Přesunout dolů';
$txt['shd_admin_custom_fields_ui_text'] = 'Textové pole';
$txt['shd_admin_custom_fields_ui_largetext'] = 'Velké textové pole';
$txt['shd_admin_custom_fields_ui_int'] = 'Celé číslo (celá čísla)';
$txt['shd_admin_custom_fields_ui_float'] = 'Plovoucí (frakcionační) čísla';
$txt['shd_admin_custom_fields_ui_select'] = 'Vybrat z rozbalovacího seznamu';
$txt['shd_admin_custom_fields_ui_checkbox'] = 'Zaškrtávací políčko (ano/ne)';
$txt['shd_admin_custom_fields_ui_radio'] = 'Vybrat z rádiových tlačítek';
$txt['shd_admin_custom_fields_ui_multi'] = 'Vybrat více položek';
$txt['shd_admin_cannot_edit_custom_field'] = 'Toto vlastní pole nelze upravovat.';
$txt['shd_admin_cannot_move_custom_field'] = 'Nemůžete přesunout toto vlastní pole.';
$txt['shd_admin_cannot_move_custom_field_up'] = 'Nemůžete přesunout toto vlastní pole nahoru, je to již první položka.';
$txt['shd_admin_cannot_move_custom_field_down'] = 'Nemůžete přesunout toto vlastní pole dolů; je to již poslední položka.';
$txt['shd_admin_new_custom_field'] = 'Přidat nové pole';
$txt['shd_admin_new_custom_field_desc'] = 'Z tohoto panelu můžete přidat nové vlastní pole pro Vaše tikety a/nebo jejich odpovědi a upřesnit, jak by pro vás měly fungovat.';
$txt['shd_admin_edit_custom_field'] = 'Upravit existující pole';
$txt['shd_admin_edit_custom_field_desc'] = 'Z tohoto panelu můžete upravit existující vlastní pole, jak je uvedeno níže.';
$txt['shd_admin_no_fieldname'] = 'Nezadali jste žádný název pro vaše vlastní pole.';
$txt['shd_admin_could_not_create_field'] = 'Nepodařilo se vytvořit vlastní pole. Zkuste to prosím znovu.';
$txt['shd_admin_default_state_on'] = 'Zkontrolováno';
$txt['shd_admin_default_state_off'] = 'Nezaškrtnuto';
$txt['shd_admin_save_custom_field'] = 'Uložit pole';
$txt['shd_admin_delete_custom_field'] = 'Odstranit pole';
$txt['shd_admin_cancel_custom_field'] = 'Zrušit';
$txt['shd_admin_delete_custom_field_confirm'] = 'Opravdu chcete smazat toto vlastní pole? Všechny hodnoty uložené pro toto pole budou odstraněny a funkce není obnovena.';
$txt['shd_admin_custom_field_options'] = 'Možnosti';
$txt['shd_admin_custom_field_options_desc'] = 'Ponechte prázdné pole pro odstranění.';
$txt['shd_admin_custom_field_options_radio'] = 'Přepínač vybere výchozí možnost.';
$txt['shd_admin_custom_field_options_multi'] = 'Zaškrtávací políčka označují, které položky jsou vybrány jako výchozí.';
$txt['shd_admin_custom_field_no_selected_default'] = 'Není vybrán žádný výchozí';
$txt['shd_admin_custom_field_bbc'] = 'Povolit BBC';
$txt['shd_admin_custom_field_bbc_note'] = 'BBC není zpracováno pro pole používaná jako předvolby tiketů.';
$txt['shd_admin_custom_field_bbc_off'] = 'BBC je v současné době <a href="%s">zakázán</a> v celém helpdesku.';
$txt['shd_admin_custom_field_default_state'] = 'Výchozí stav';
$txt['shd_admin_custom_field_dimensions'] = 'Rozměry';
$txt['shd_admin_custom_field_dimensions_rows'] = 'Řádky';
$txt['shd_admin_custom_field_dimensions_columns'] = 'Sloupce';
$txt['shd_admin_custom_field_maxlength'] = 'Maximální délka';
$txt['shd_admin_custom_field_maxlength_desc'] = '(0 bez omezení)';
$txt['shd_admin_custom_field_display_empty'] = 'Zobrazit i v případě, že je prázdné';
$txt['shd_admin_custom_field_display_empty_desc'] = 'Pokud je pole uživatelem ponecháno prázdné, mělo by být stále zobrazeno při čtení tiketu?';
$txt['shd_admin_custom_field_required'] = 'Povinné pole';
$txt['shd_admin_custom_field_required_desc'] = 'Je-li zaškrtnuto, musí být toto pole vyplněno uživatelem, aby bylo možné odeslat tiket nebo odpověď.';
$txt['shd_admin_custom_field_view'] = 'Zobrazit';
$txt['shd_admin_custom_field_edit'] = 'Upravit';
$txt['shd_admin_custom_field_permissions'] = 'Práva';
$txt['shd_admin_custom_field_can_see'] = 'Kdo může vidět toto pole';
$txt['shd_admin_custom_field_can_see_desc'] = 'Vyberte, kdo může vidět toto pole v tiketech.';
$txt['shd_admin_custom_field_can_edit'] = 'Kdo může toto pole upravovat.';
$txt['shd_admin_custom_field_can_edit_desc'] = 'Vyberte, kdo může toto pole upravovat/použít při odesílání.';
$txt['shd_admin_custom_field_users'] = 'Uživatelé';
$txt['shd_admin_custom_field_staff'] = 'Zaměstnanci';
$txt['shd_admin_custom_field_admins'] = 'Správci';
$txt['shd_admin_custom_field_placement'] = 'Umístění uvnitř tiketu';
$txt['shd_admin_custom_field_placement_desc'] = 'Kde v tiketu má být toto pole zobrazeno? Vezměte prosím na vědomí, že velká pole nemusí příliš dobře zapadat do pole "další podrobnosti", a že pro použití jako kategorie jsou k dispozici pouze rozbalovací a rádiová tlačítka.';
$txt['shd_admin_custom_field_placement_details'] = 'Další podrobnosti (levá boční krabice)';
$txt['shd_admin_custom_field_placement_information'] = 'Další informace (tělo lístku pod tělesa)';
$txt['shd_admin_custom_field_placement_prefix'] = 'Jako předponu k názvu tiketu';
$txt['shd_admin_custom_field_placement_prefixfilter'] = 'Jako kategorie (filtrovatelné)';
$txt['shd_admin_custom_field_department'] = 'Oddělení, na které se toto pole vztahuje';
$txt['shd_admin_custom_field_dept_applies'] = 'Platí';
$txt['shd_admin_custom_field_dept_required'] = 'Požadováno';
$txt['shd_admin_custom_field_invalid'] = 'Neplatný typ vybraného pole.';
$txt['shd_admin_custom_field_reselect_invalid'] = 'Pokusili jste se změnit toto vlastní pole, ale na typ, který není kompatibilní s daty, která jsou pro toto pole již uložena, a aby nedošlo k poškození stávajících dat, bylo změně zabráněno.';
//@}

//! Canned Replies
//@{
$txt['shd_admin_cannedreplies_home'] = 'Helpdesk - Konzervované odpovědi';
$txt['shd_admin_cannedreplies_homedesc'] = 'Tato sekce vám umožňuje vytvářet šablony odpovědí nebo snippetů, nebo odpovědi na často kladené otázky, aby byly k dispozici z rozhraní pro vkládání.';
$txt['shd_admin_cannedreplies_nocats'] = 'Neexistují žádné kategorie pro konzervované odpovědi, musíte je nejdříve vytvořit.';
$txt['shd_admin_cannedreplies_createcat'] = 'Vytvořit novou kategorii';
$txt['shd_admin_cannedreplies_editcat'] = 'Upravit tuto kategorii';
$txt['shd_admin_cannedreplies_deletecat'] = 'Odstranit tuto kategorii';
$txt['shd_admin_cannedreplies_categoryname'] = 'Název kategorie';
$txt['shd_admin_cannedreplies_replyname'] = 'Jméno odpovědi';
$txt['shd_admin_cannedreplies_isactive'] = 'Aktivovat?';
$txt['shd_admin_cannedreplies_visibleto'] = 'Viditelné pro';
$txt['shd_admin_cannedreplies_emptycat'] = 'V této kategorii nejsou žádné uložené odpovědi.';
$txt['shd_admin_cannedreplies_addreply'] = 'Vytvořit novou odpověď';
$txt['shd_admin_cannedreplies_editreply'] = 'Upravit tuto odpověď';
$txt['shd_admin_cannedreplies_deletereply'] = 'Odstranit tuto odpověď';
$txt['shd_admin_cannedreplies_delete_confirm'] = 'Jste si jisti, že chcete odstranit tuto kategorii a všechny její odpovědi?';
$txt['shd_admin_cannedreplies_deletereply_confirm'] = 'Jste si jisti, že chcete odstranit tuto odpověď?';
$txt['shd_admin_cannedreplies_move_between_cat'] = 'Přesunout tuto konzervovanou odpověď do jiné kategorie';
$txt['shd_admin_cannedreplies_cannot_move_reply'] = 'Tuto odpověď nelze přesunout.';
$txt['shd_admin_cannedreplies_cannot_move_reply_up'] = 'Tuto odpověď nelze posunout nahoru.';
$txt['shd_admin_cannedreplies_cannot_move_reply_down'] = 'Tuto odpověď nelze posunout dolů.';
$txt['shd_admin_cannedreplies_cannot_move_cat'] = 'Tuto kategorii nelze přesunout.';
$txt['shd_admin_cannedreplies_cannot_move_cat_up'] = 'Tuto kategorii nelze přesunout nahoru.';
$txt['shd_admin_cannedreplies_cannot_move_cat_down'] = 'Tuto kategorii nelze přesunout dolů.';
$txt['shd_admin_cannedreplies_thecatisalie'] = 'Tato kategorie neexistuje, nelze ji upravovat.';
$txt['shd_admin_cannedreplies_thereplyisalie'] = 'Tato odpověď neexistuje, nelze ji upravovat.';
$txt['shd_admin_cannedreplies_nocatname'] = 'Nebyl uveden žádný název pro kategorii, musí být uveden.';
$txt['shd_admin_cannedreplies_replytitle'] = 'Název této konzervované odpovědi';
$txt['shd_admin_cannedreplies_content'] = 'Obsah konzervované odpovědi';
$txt['shd_admin_cannedreplies_active'] = 'Je tato konzervovaná odpověď aktivní?';
$txt['shd_admin_cannedreplies_selectvisible'] = 'Kdo je tato konzervovaná odpověď k dispozici?';
$txt['shd_admin_cannedreplies_departments'] = 'Oddělení této konzervované odpovědi je přístupné z';
$txt['shd_admin_cannedreplies_notitle'] = 'Pro tuto konzervovanou odpověď nebyl zadán žádný název, musí být zadán.';
$txt['shd_admin_cannedreplies_nobody'] = 'Pro tuto konzervovanou odpověď nebyl zadán žádný obsah těla, musí být zadán.';
$txt['shd_admin_cannedreplies_notcreated'] = 'Nová odpověď nemohla být vytvořena.';
$txt['shd_admin_cannedreplies_onlyonecat'] = 'Nemůžete přesunout tuto odpověď do jiné kategorie, existuje pouze jedna kategorie odpovědí.';
$txt['shd_admin_cannedreplies_newcategory'] = 'Nová kategorie, do které by tato odpověď měla patřit';
$txt['shd_admin_cannedreplies_selectcat'] = '-- Vyberte kategorii --';
$txt['shd_admin_cannedreplies_movereply'] = 'Přesunout tuto odpověď';
$txt['shd_admin_cannedreplies_destnoexist'] = 'Kategorie, do které se pokoušíte přesunout tuto odpověď, neexistuje.';

//! Departments
//@{
$txt['shd_admin_departments_home'] = 'Helpdesk oddělení';
$txt['shd_admin_departments_homedesc'] = 'V prostředí helpdesk je vytvořena jedna nebo více různých oblastí - "departementy" - pro organizaci tiketů a přístupu.';
$txt['shd_department_name'] = 'Název oddělení';
$txt['shd_dept_boardindex'] = 'Zobrazit v tabuli?';
$txt['shd_dept_no_boardindex'] = 'Nezobrazovat na tabuli';
$txt['shd_dept_inside_category'] = 'Palubní index, uvnitř kategorie';
$txt['shd_dept_cat_before_boards'] = 'Před všemi tabulemi v této kategorii';
$txt['shd_dept_cat_after_boards'] = 'Po všech tabulích v této kategorii';
$txt['shd_roles_in_dept'] = 'Role v této části.';
$txt['shd_create_dept'] = 'Vytvořit nové oddělení';
$txt['shd_edit_dept'] = 'Upravit oddělení';
$txt['shd_delete_dept'] = 'Odstranit oddělení';
$txt['shd_delete_dept_confirm'] = 'Opravdu chcete smazat toto oddělení?';
$txt['shd_no_roles_in_dept'] = 'V tomto oddělení nejsou žádné role.';
$txt['shd_new_dept_name'] = 'Název nového oddělení';
$txt['shd_dept_boardindex_cat'] = 'Zobrazit toto oddělení v tabuli v kategorii';
$txt['shd_no_dept_name'] = 'Nebyl zadán název oddělení.';
$txt['shd_no_category'] = 'Zadaná kategorie neexistuje. Vraťte se prosím zpět a obnovte stránku.';
$txt['shd_could_not_create_dept'] = 'Oddělení nelze vytvořit.';
$txt['shd_must_have_dept'] = 'Nemůžete odstranit jedinou oddělení; vždy musí existovat jedna oddělení.';
$txt['shd_dept_not_empty'] = 'Tuto kategorii nelze odstranit, obsahuje alespoň jeden tiket.';
$txt['shd_roles_in_dept'] = 'Role v tomto oddělení';
$txt['shd_roles_in_dept_desc'] = 'Jinde v admin panelu, role jsou vytvořeny a zadány schopnosti. Tento panel určuje, které role se vztahují na toto oddělení, například můžete si přát vytvořit více oddělení s jedinou společnou úlohou zaměstnanců.';
$txt['shd_no_defined_roles'] = 'Nejsou definovány žádné role, nakonfigurujte je z oblasti Oprávnění.';
$txt['shd_assign_dept'] = 'Přiřadit roli/oddělení';
$txt['shd_boardindex_cat_none'] = 'Žádná kategorie (nezobrazovat)';
$txt['shd_boardindex_cat_where'] = 'Kde by v kategorii měla být zobrazena?';
$txt['shd_boardindex_cat_before'] = 'Před jakoukoli tabulí';
$txt['shd_boardindex_cat_after'] = 'Po každé desce';
$txt['shd_dept_description'] = 'L 343, 22.12.2009, s. 1).';
$txt['shd_admin_cannot_move_dept'] = 'Nemůžete přesunout toto oddělení.';
$txt['shd_admin_cannot_move_dept_up'] = 'Nemůžete přesunout toto oddělení nahoru, je to již první položka.';
$txt['shd_admin_cannot_move_dept_down'] = 'Nemůžete přesunout toto oddělení dolů; je to již poslední položka.';
$txt['shd_dept_theme'] = 'Použít konkrétní téma v tomto oddělení?';
$txt['shd_dept_theme_note'] = 'Můžete nastavit šablonu pro helpdesk, která se liší od hlavního tématu fóra. Toto nastavení umožňuje přepsat helpdesk nebo šablonu fóra právě v rámci tohoto oddělení, pro možná konkrétní brandování v oddělení.';
$txt['shd_dept_theme_use_default'] = 'Použít výchozí motiv helpdesk/fóra';
$txt['shd_dept_autoclose_days'] = 'Počet dní, po kterých mají být letenka automaticky zavřena?';
$txt['shd_dept_autoclose_days_note'] = 'Pomocí 0 označte, že tikety v tomto oddělení by nikdy neměly být automaticky označeny zavřené, bez ohledu na jejich staré.';
//@}

//! Plugins
//@{
$txt['sdplugin_package'] = 'SimpleDesk Plugins';
$txt['shd_install_plugin'] = 'Instalovat plugin';
$txt['shd_admin_plugins_homedesc'] = 'Tato oblast umožňuje spravovat všechny další komponenty pro SimpleDesk. Jsou nainstalovány prostřednictvím Správce balíčků jako běžné mody a nakonfigurovány zde.';
$txt['shd_admin_plugins_none'] = 'V současné době nejsou nainstalovány žádné pluginy.';
$txt['shd_admin_plugins_writtenby'] = 'Napsal';
$txt['shd_admin_plugins_website'] = 'Webová stránka';
$txt['shd_admin_plugins_wrong_version'] = 'Tato verze není podporována!';
$txt['shd_admin_plugins_versions_avail'] = 'Podporováno pluginem';
$txt['shd_admin_plugins_on'] = 'Zapnuto';
$txt['shd_admin_plugins_off'] = 'Vypnuto';
 $txt['shd_admin_plugins_enabled'] = 'Povoleno';
$txt['shd_admin_plugins_disabled'] = 'Zakázáno';
$txt['shd_admin_plugins_languages'] = 'Dostupné jazyky';
$txt['shd_admin_plugins_lang_albanian'] = 'Albánština';
$txt['shd_admin_plugins_lang_arabic'] = 'Arabština';
$txt['shd_admin_plugins_lang_bangla'] = 'Bengálština';
$txt['shd_admin_plugins_lang_bulgarian'] = 'Bulharština';
$txt['shd_admin_plugins_lang_catalan'] = 'Katalánština';
$txt['shd_admin_plugins_lang_chinese_simplified'] = 'Čínština (zjednodušená)';
$txt['shd_admin_plugins_lang_chinese_traditional'] = 'Čínština (tradiční)';
$txt['shd_admin_plugins_lang_croatian'] = 'Chorvatština';
$txt['shd_admin_plugins_lang_czech'] = 'Čeština';
$txt['shd_admin_plugins_lang_danish'] = 'Dánština';
$txt['shd_admin_plugins_lang_dutch'] = 'Holandština';
$txt['shd_admin_plugins_lang_english'] = 'Čeština (USA)';
$txt['shd_admin_plugins_lang_english_british'] = 'Čeština (UK)';
$txt['shd_admin_plugins_lang_finnish'] = 'Finština';
$txt['shd_admin_plugins_lang_french'] = 'Francouzština';
$txt['shd_admin_plugins_lang_galician'] = 'Galicijština';
$txt['shd_admin_plugins_lang_german'] = 'Němčina';
$txt['shd_admin_plugins_lang_hebrew'] = 'Hebrejština';
$txt['shd_admin_plugins_lang_hindi'] = 'Hindština';
$txt['shd_admin_plugins_lang_hungarian'] = 'Maďarština';
$txt['shd_admin_plugins_lang_indonesian'] = 'Indonéština';
$txt['shd_admin_plugins_lang_italian'] = 'Italština';
$txt['shd_admin_plugins_lang_japanese'] = 'Japonština';
$txt['shd_admin_plugins_lang_kurdish_kurmanji'] = 'Kurdština (Kurmanji)';
$txt['shd_admin_plugins_lang_kurdish_sorani'] = 'Kurdština (Sorani)';
$txt['shd_admin_plugins_lang_macedonian'] = 'makedonština';
$txt['shd_admin_plugins_lang_malay'] = 'Malajština';
$txt['shd_admin_plugins_lang_norwegian'] = 'Norština';
$txt['shd_admin_plugins_lang_persian'] = 'Perština';
$txt['shd_admin_plugins_lang_polish'] = 'Polština';
$txt['shd_admin_plugins_lang_portuguese_brazilian'] = 'Portugalština (Brazílie)';
$txt['shd_admin_plugins_lang_portuguese_pt'] = 'Portugalština';
$txt['shd_admin_plugins_lang_romanian'] = 'Rumunština';
$txt['shd_admin_plugins_lang_russian'] = 'Ruština';
$txt['shd_admin_plugins_lang_serbian_cyrillic'] = 'Srbština (Cyrilice)';
$txt['shd_admin_plugins_lang_serbian_latin'] = 'Serbian (Latin)';
$txt['shd_admin_plugins_lang_slovak'] = 'Slovenština';
$txt['shd_admin_plugins_lang_spanish_es'] = 'Španělština (Španělsko)';
$txt['shd_admin_plugins_lang_spanish_latin'] = 'Španělština (Latinka)';
$txt['shd_admin_plugins_lang_swedish'] = 'Švédština';
$txt['shd_admin_plugins_lang_thai'] = 'Thajština';
$txt['shd_admin_plugins_lang_turkish'] = 'Turecký';
$txt['shd_admin_plugins_lang_ukrainian'] = 'Ukrajinština';
$txt['shd_admin_plugins_lang_urdu'] = 'Urdština';
$txt['shd_admin_plugins_lang_uzbek_latin'] = 'Uzbek (Latin)';
$txt['shd_admin_plugins_lang_vietnamese'] = 'Vietnamese';
//@}

//! Maintenance
//@{
$txt['shd_admin_maint_back'] = 'Zpět na údržbu Helpdesku';
$txt['shd_admin_maint_desc'] = 'Tato oblast umožňuje provádět některé běžné údržbové úkoly v rámci SimpleDesk.';

$txt['shd_admin_maint_reattribute'] = 'Znovu přiřadit uživatelské příspěvky';
$txt['shd_admin_maint_reattribute_desc'] = 'Pokud byl uživatelský účet odstraněn, umožňuje to znovu připojit tikety ze starého účtu s novým.';
$txt['shd_admin_maint_reattribute_posts_made'] = 'Znovu přiřadit tikety a odpovědi:';
$txt['shd_admin_maint_reattribute_posts_user'] = 'Toto uživatelské jméno';
$txt['shd_admin_maint_reattribute_posts_email'] = 'Tato e-mailová adresa';
$txt['shd_admin_maint_reattribute_posts_starter'] = 'Startování tiketu';
$txt['shd_admin_maint_reattribute_posts_to'] = 'A připojte je k tomuto uživatelskému účtu:';
$txt['shd_admin_maint_reattribute_btn'] = 'Nyní znovu atribut';
$txt['shd_admin_maint_reattribute_success'] = 'Všechny vstupenky a pracovní místa, které bylo možné najít, byly oceněny. Pravděpodobně byste měli spustit možnost údržby "Najít a opravit chyby" z Helpdesku (Nějaké tikety nemusí být zobrazeny správně.)';
$txt['shd_reattribute_confirm'] = 'Jste si jisti, že chcete přiřadit všechny tikety a odpovědi (z dříve odstraněného účtu) členovi %type% z%find%"%member_to%"?';
$txt['shd_reattribute_confirm_starter'] = 'Jste si jisti, že chcete přiřadit všechny začátky tiketu "%find%" členovi "%member_to%"?';
$txt['shd_reattribute_confirm_username'] = 'uživatelské jméno';
$txt['shd_reattribute_confirm_email'] = 'e-mailová adresa';
$txt['shd_reattribute_cannot_find_member'] = 'helpdesk nenalezl uživatele pro vytvoření lístků a odpovědí.';
$txt[''] = 'helpdesk nemohl najít orignální uživatele pro reattributy tiketů a odpovědí.';
$txt['shd_reattribute_no_email'] = 'Nebyla zadána žádná e-mailová adresa.';
$txt['shd_reattribute_no_user'] = 'Nebylo zadáno žádné uživatelské jméno.';
$txt['shd_reattribute_no_messages'] = 'Nebylo zjištěno, že by byly znovu přiřazeny žádné zprávy.';
$txt['shd_reattribute_in_use'] = 'Jediné zprávy, u nichž bylo zjištěno, že mají být znovu přiřazeny, jsou uvedeny proti aktuálnímu uživateli, takže u těchto zpráv nelze provést žádné další přiřazení.';

$txt['shd_admin_maint_massdeptmove'] = 'Přesunout tikety';
$txt['shd_admin_maint_massdeptmove_desc'] = 'Tato oblast umožňuje masový pohyb lístků mezi departementy.';
$txt['shd_admin_maint_massdeptmove_select'] = '(Vybraný oddělení)';
$txt['shd_admin_maint_massdeptmove_from'] = 'Přesunout tikety z';
$txt['shd_admin_maint_massdeptmove_to'] = 'do';
$txt['shd_admin_maint_massdeptmove_success'] = 'Všechny odpovídající tikety byly úspěšně přesunuty do jejich nového oddělení.';
$txt['shd_admin_maint_massdeptmove_samedept'] = 'Musíte vybrat různé počáteční a cílové oddělení, do kterých chcete přesunout tikety.';
$txt['shd_admin_maint_massdeptmove_open'] = 'Přesunout otevřené/nevyřízené tikety z tohoto oddělení';
$txt['shd_admin_maint_massdeptmove_closed'] = 'Přesunout uzavřené tikety z tohoto oddělení';
$txt['shd_admin_maint_massdeptmove_deleted'] = 'Přesunout odstraněné tikety z tohoto oddělení';
$txt['shd_admin_maint_massdeptmove_lastupd_less'] = 'Vstupenky musí být naposledy aktualizovány za posledních %1$s dní';
$txt['shd_admin_maint_massdeptmove_lastupd_more'] = 'Tikety musí být naposledy aktualizovány před více než %1$s dny';

$txt['shd_admin_maint_findrepair'] = 'Najít a opravit chyby';
$txt['shd_admin_maint_findrepair_desc'] = 'Někdy se věci dostanou trochu z kroku v databázi. Tato operace provádí kontrolu integrity databáze a pokouší se opravit veškeré chyby, které se vyskytnou.';

$txt['shd_admin_maint_findrepair_status'] = 'Přepočítávání počtu tiketů...';
$txt['shd_admin_maint_findrepair_firstlast'] = 'Přepočítávám první/poslední sdružení tiketů...';
$txt['shd_admin_maint_findrepair_starterupdater'] = 'Přepočítávání startu tiketu a poslední aktualizace sdružením...';

$txt['shd_admin_recovered_dept'] = 'Obnovené tikety';
$txt['shd_admin_recovered_dept_desc'] = 'Jedná se o letenky, které byly nějakým způsobem mimo stávající departementy. Můžete je přesunout do reálných departementů a měli byste smazat toto oddělení, pokud je prázdné.';

$txt['shd_maint_zero_tickets'] = '%1$d tiketů bylo nalezeno s neplatnými ID, všechny byly obdrženy nové ID, další dostupná ID čísla.';
$txt['shd_maint_zero_msgs'] = '%1$d příspěvků tiketu bylo nalezeno s neplatnými ID, všechny byly obdrženy nové ID, další dostupná id čísla.';
$txt['shd_maint_deleted'] = '%1$d tiket(ů) má nesprávný počet příspěvků a/nebo smazaných příspěvků. Všechny byly přepočítány.';
$txt['shd_maint_first_last'] = '%1$d tiketů bylo označeno chybnými zprávami o obsahu tiketu nebo jeho poslední odpovědi. Všechny byly opraveny.';
$txt['shd_maint_status'] = '%1$d tiketů bylo nastaveno špatný stav. Všechny byly opraveny.';
$txt['shd_maint_starter_updater'] = '%1$d tiket(y) měl špatného uživatele na seznamu jako osoba, která otevřela tiket nebo poslední osoba pro aktualizaci tiketu. Všechno bylo napraveno.';
$txt['shd_maint_invalid_dept'] = '%1$d tiketů bylo uvedeno jako v odděleních, které neexistují, všechny byly přesunuty do nového oddělení s názvem "Obnovené tikety".';

$txt['shd_maint_search_settings'] = 'Nastavení hledání';
$txt['shd_maint_search_settings_desc'] = 'Tato stránka vám umožňuje nakonfigurovat způsob vyhledávání tiketů a v případě potřeby obnovit index použitý pro vyhledávání.';
$txt['shd_maint_rebuild_index'] = 'Znovu sestavit index hledání';
$txt['shd_maint_rebuild_index_desc'] = 'Pokud máte již existující letenky, které byly přibližně před poskytnutím vyhledávacího zařízení, nebo změníte níže uvedené nastavení, budete <strong>potřebovat</strong> k opětovnému sestavení indexu. Index je to, co se fyzicky používá k vyhledávání, a pokud se nastavení fyzického indexu liší od způsobu vyhledávání, hledání je velmi nerealizovatelné.<br><strong>Důležité:</strong> Vytvoření vyhledávacího indexu je velmi náročný úkol. Bude trvat nějakou dobu, než se provede, během které prosím nechejte toto okno otevřené.';
$txt['shd_maint_search_settings_warning'] = 'Pokud změníte tato nastavení, budete muset obnovit vyhledávací index.';
$txt['shd_search_min_size'] = 'Minimální počet písmen, která mají být považována za slovo (3-15)';
$txt['shd_search_max_size'] = 'Maximální počet písmen, která je třeba považovat za slovo (3-15)';
$txt['shd_search_prefix_size'] = 'Minimální počet písmen pro prefix vyhledávání<div class="smalltext">(0 = vypnuto)</div>';
$txt['shd_search_prefix_size_help'] = 'Předpona vyhledávání je místo, kde je index sestaven tak, aby umožňoval částečné slovní shody. Například, hledání &quot;chodeb&quot; vrátí výsledky jako &quot;walking&quot; nebo &quot;chůze&quot;. Ve výchozím nastavení je zakázáno, protože index výrazně zvětšuje a vyhledávání je následkem toho pomalejší.';
$txt['shd_search_charset'] = 'Znaky, které lze považovat za platné části slov k vyhledávání.';
$txt['shd_search_rebuilt'] = 'Index byl znovu sestaven.';
//@}

/**
 *	@ignore
 *	Warning: He may bite.
*/
//! Ignore
//@{
$txt['shd_fluffy'] = 'Strážce <span %s>cookies</span>';
//@}