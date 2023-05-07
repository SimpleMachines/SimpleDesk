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
$txt['shd_helpdesk'] = 'Ohjepöytä';
$txt['shd_helpdesk_maintenance'] = 'helpdesk on tällä hetkellä <strong>huoltotilassa</strong>. Vain foorumi ja helpdesk järjestelmänvalvojat voivat nähdä tämän.';
$txt['shd_open_ticket'] = 'avaa lippu';
$txt['shd_open_tickets'] = 'avoimet liput';
$txt['shd_none'] = 'Ei Mitään';

$txt['shd_display_nojs'] = 'JavaScript ei ole käytössä selaimessasi. Jotkin toiminnot eivät välttämättä toimi oikein (tai lainkaan), tai käyttäytyvät odottamattomalla tavalla.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Tervetuloa suurimpaan helpdeskin hallintokeskukseen!';
$txt['shd_admin_title'] = 'Helpdeskin Ylläpitokeskus';
$txt['shd_staff_list'] = 'Helpdesk henkilökunta';
$txt['shd_update_available'] = 'Uusi versio saatavilla!';
$txt['shd_update_message'] = 'SimpleDeskin uusi versio on julkaistu. Suosittelemme sinua <a href="#" id="update-link">päivittämään viimeisimpään versioon</a> pysyäksesi turvallisena ja nauttiaksemme kaikista muutoksistamme on tarjottava.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Lisätietoja siitä, mitä tässä julkaisussa on uusi, ole hyvä ja vieraile <a href="#" id="information-link" target="_blank">verkkosivustollamme</a>.</span><br>' . "\n\n" . '<strong>SimpleDesk-tiimi</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Matala';
$txt['shd_urgency_1'] = 'Keskitaso';
$txt['shd_urgency_2'] = 'Korkea';
$txt['shd_urgency_3'] = 'Erittäin Korkea';
$txt['shd_urgency_4'] = 'Vaikea';
$txt['shd_urgency_5'] = 'Kriittinen';
$txt['shd_urgency_increase'] = 'Lisää';
$txt['shd_urgency_decrease'] = 'Vähennä';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Uusi';
$txt['shd_status_1'] = 'Odottava Henkilökunnan Kommentti';
$txt['shd_status_2'] = 'Odottava Käyttäjän Kommentti';
$txt['shd_status_3'] = 'Ratkaistu/Suljettu';
$txt['shd_status_4'] = 'Viittaus valvojaan';
$txt['shd_status_5'] = 'Estetty - Kiireellinen';
$txt['shd_status_6'] = 'Poistettu';
$txt['shd_status_7'] = 'Pitellä';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Uudet Tiketit';
$txt['shd_status_1_heading'] = 'Liput Odottavat Henkilökunnan Vastausta';
$txt['shd_status_2_heading'] = 'Liput Odottavat Käyttäjän Vastausta';
$txt['shd_status_3_heading'] = 'Suljetut Tiketit';
$txt['shd_status_4_heading'] = 'Valvojalle osoitetut liput';
$txt['shd_status_5_heading'] = 'Kiireelliset Tiketit';
$txt['shd_status_6_heading'] = 'Kierrätetyt Liput';
$txt['shd_status_7_heading'] = 'Pidä Tiketit';
$txt['shd_status_assigned_heading'] = 'Määritetty minulle';
$txt['shd_status_withdeleted_heading'] = 'Tukipyynnöt poistetuilla vastauksilla';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Avoimet Tiketit';
$txt['shd_tickets_closed'] = 'Suljetut Tiketit';
$txt['shd_tickets_recycled'] = 'Kierrätetyt Liput';

$txt['shd_assigned'] = 'Määritetty';
$txt['shd_unassigned'] = 'Määrittämätön';

$txt['shd_read_ticket'] = 'Lue Tukipyyntöä';
$txt['shd_unread_ticket'] = 'Lukematon Tiketti';
$txt['shd_unread_tickets'] = 'Lukemattomat Tiketit';

$txt['shd_owned'] = 'Omistettu Lippu'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'lippu';
$txt['shd_count_tickets'] = 'liput';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Sinulla ei ole oikeuksia käyttää neuvontapalvelua.';
$txt['shd_no_ticket'] = 'Pyytämäsi lippu ei näytä olevan olemassa.';
$txt['shd_no_reply'] = 'Pyytämäsi lipun vastaus ei näytä olevan olemassa tai se ei ole osa tätä lippua.';
$txt['shd_no_topic'] = 'Pyytämäsi aihe ei näytä olevan olemassa.';
$txt['shd_ticket_no_perms'] = 'Sinulla ei ole oikeutta tarkastella kyseistä lippua.';
$txt['shd_error_no_tickets'] = 'Lippuja ei löytynyt.';
$txt['shd_inactive'] = 'helpdesk on tällä hetkellä pois päältä.';
$txt['shd_cannot_assign'] = 'Sinulla ei ole oikeuksia määrittää lippuja.';
$txt['shd_cannot_assign_other'] = 'Tämä lippu on jo määritetty toiselle käyttäjälle. Et voi siirtää sitä itsellesi - ota yhteyttä järjestelmänvalvojaan.';
$txt['shd_no_staff_assign'] = 'Henkilökuntaa ei ole määritetty; lippua ei ole mahdollista määrittää. Ota yhteyttä järjestelmänvalvojaan.';
$txt['shd_assigned_not_permitted'] = 'Käyttäjällä, jota olet pyytänyt määrittämään tämän lipun, ei ole riittävästi oikeuksia nähdä sitä.';
$txt['shd_cannot_resolve'] = 'Sinulla ei ole oikeuksia merkitä tätä lippua ratkaistuksi.';
$txt['shd_cannot_unresolve'] = 'Sinulla ei ole oikeutta avata uudelleen ratkaistua lippua.';
$txt['error_shd_cannot_resolve_children'] = 'Tätä lippua ei voida tällä hetkellä sulkea; tämä lippu on yhden tai useamman tällä hetkellä avoinna olevan lipun vanhempi.';
$txt['error_shd_proxy_unknown'] = 'Käyttäjä tämä lippu on lähetetty puolesta ei ole olemassa.';
$txt['shd_cannot_change_privacy'] = 'Sinulla ei ole oikeutta muuttaa tämän lipun yksityisyyttä.';
$txt['shd_cannot_change_urgency'] = 'Sinulla ei ole oikeutta muuttaa tämän lipun kiireellisyyttä.';
$txt['shd_ajax_problem'] = 'Sivua yritettäessä ladata tapahtui virhe. Haluatko yrittää uudelleen?';
$txt['shd_cannot_move_ticket'] = 'Sinulla ei ole oikeutta siirtää tätä lippua aiheeseen.';
$txt['shd_cannot_move_topic'] = 'Sinulla ei ole oikeutta siirtää tätä aihetta lippuun.';
$txt['shd_moveticket_noboards'] = 'Tämän lipun siirtämiseen ei ole tauluja!';
$txt['shd_move_no_pm'] = 'Sinun täytyy syöttää syy liikuttaa lippua lähettääksesi lipun omistajalle, tai poista valinta \'lähetä PM lipun omistajalle\'.';
$txt['shd_move_no_pm_topic'] = 'Sinun täytyy syöttää syy siirtää aihe lähettää aiheeseen käynnistettäväksi, tai poista valitsin \'Lähetä viesti aiheeseen käynnistää\'.';
$txt['shd_move_topic_not_created'] = 'Lipun siirto alukselle epäonnistui. Ole hyvä ja yritä uudelleen.';
$txt['shd_move_ticket_not_created'] = 'Aiheen siirtäminen helpdeskiin epäonnistui. Ole hyvä ja yritä uudelleen.';
$txt['shd_no_replies'] = 'Tällä lipulla ei ole vielä vastauksia.';
$txt['cannot_shd_new_ticket'] = 'Sinulla ei ole oikeuksia luoda uutta lippua.';
$txt['cannot_shd_edit_ticket'] = 'Sinulla ei ole oikeuksia muokata tätä lippua.';
$txt['shd_cannot_reply_any'] = 'Sinulla ei ole oikeutta vastata mihinkään lippuihin.';
$txt['shd_cannot_reply_any_but_own'] = 'Sinulla ei ole oikeutta vastata mihinkään muuhun kuin omaasi.';
$txt['shd_cannot_edit_reply_any'] = 'Sinulla ei ole oikeuksia muokata mahdollisia vastauksia.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Sinulla ei ole oikeuksia muokata vastausta mihinkään muuhun kuin omiin vastauksiisi.';
$txt['shd_cannot_edit_closed'] = 'Et voi muokata ratkaistuja lippuja. Sinun täytyy merkitä se ratkaisemattomaksi ensin.';
$txt['shd_cannot_edit_deleted'] = 'Et voi muokata lippuja kierrätysroskassa. Ne on palautettava ensin.';
$txt['shd_cannot_reply_closed'] = 'Et voi vastata ratkaistuihin lippuihin; sinun täytyy merkitä ne ratkaisemattomiksi ensin.';
$txt['shd_cannot_reply_deleted'] = 'Et voi vastata roskakorissa oleviin lippuihin. Ne on palautettava ensin.';
$txt['shd_cannot_delete_ticket'] = 'Sinulla ei ole oikeuksia poistaa tätä lippua.';
$txt['shd_cannot_delete_reply'] = 'Sinulla ei ole oikeutta poistaa tätä vastausta.';
$txt['shd_cannot_restore_ticket'] = 'Sinun ei ole sallittua palauttaa tätä lippua kierrätysroskasta.';
$txt['shd_cannot_restore_reply'] = 'Teidän ei sallita palauttaa tätä vastausta roskakorista.';
$txt['shd_cannot_view_resolved'] = 'Sinulla ei ole oikeuksia käyttää ratkaistuja lippuja.';
$txt['cannot_shd_access_recyclebin'] = 'Et voi käyttää kierrätysbiniä.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Et voi siirtää tätä lippua foorumiin; on olemassa yksi tai useampi poistettu vastaus, johon nykyiset käyttöoikeudet eivät salli pääsyä.';
$txt['shd_cannot_attach_ext'] = 'Tiedostotyyppi, jonka olet yrittänyt liittää ({ext}) ei ole sallittu tässä. Sallitut tiedostotyypit ovat: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Tämä lippu ei ole tällä hetkellä saatavilla muokattavaksi.';
$txt['shd_invalid_relation'] = 'Sinun on annettava voimassa oleva suhde näille lipuille.';
$txt['shd_no_relation_delete'] = 'Et voi poistaa suhdetta, jota ei ole olemassa.';
$txt['shd_cannot_relate_self'] = 'Et voi saada lippua liittymään itseensä.';
$txt['shd_relationships_are_disabled'] = 'Lippujen suhteet on tällä hetkellä poistettu käytöstä.';
$txt['error_invalid_fields'] = 'Seuraavilla kentillä on arvoja, joita ei voi käyttää: %1$s';
$txt['error_missing_fields'] = 'Seuraavia kenttiä ei ole suoritettu ja niiden on oltava: %1$s';
$txt['error_missing_multi'] = '%1$s (vähintään %2$d on valittava)';
$txt['error_no_dept'] = 'Et ole valinnut osastoa lähettääksesi tämän lipun.';
$txt['shd_cannot_move_dept'] = 'Et voi siirtää tätä lippua, ei ole mihin sitä siirretään.';
$txt['shd_no_perm_move_dept'] = 'Sinulla ei ole oikeutta siirtää tätä lippua toiselle osastolle.';
$txt['cannot_shd_delete_attachment'] = 'Sinulla ei ole oikeuksia poistaa liitteitä.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Et voi siirtää lippua aiheeseen; on olemassa mukautettuja kenttiä, jotka edellyttävät järjestelmänvalvojan vahvistavan siirron.';
$txt['cannot_monitor_ticket'] = 'Sinun ei ole sallittua ottaa käyttöön tämän lipun seurantaa.';
$txt['cannot_unmonitor_ticket'] = 'Sinun ei ole sallittua kytkeä seuranta pois päältä tämän lipun osalta.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Ohjepöytä'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Osastot'; // ditto
$txt['shd_new_ticket'] = 'Lähetä Uusi Tiketti';
$txt['shd_new_ticket_proxy'] = 'Lähetä Välityspalvelimen Lippu';
$txt['shd_helpdesk_profile'] = 'Helpdesk Profiili';
$txt['shd_welcome'] = 'Tervetuloa, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Siirry lippuun';
$txt['shd_options'] = 'Valinnat';
$txt['shd_search_menu'] = 'Etsi';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Tiedot';
$txt['shd_admin_options'] = 'Valinnat';
$txt['shd_admin_custom_fields'] = 'Mukautetut Kentät';
$txt['shd_admin_departments'] = 'Osastot';
$txt['shd_admin_permissions'] = 'Käyttöoikeudet';
$txt['shd_admin_plugins'] = 'Liitännäiset';
$txt['shd_admin_cannedreplies'] = 'Peruutetut Vastaukset';
$txt['shd_admin_maint'] = 'Huolto';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Täällä voit syöttää uusia lippuja sivuston henkilökunnan toimia, ja tarkistaa nykyiset liput jo käynnissä.';
$txt['shd_staff_greeting'] = 'Tässä ovat kaikki liput, jotka vaativat huomiota.';
$txt['shd_shd_greeting'] = 'Tämä on Helpdesk. Täällä tuhlaat aikaa auttaa uutisia. Nauti! ;D';
$txt['shd_closed_user_greeting'] = 'Nämä ovat kaikki suljettuja / ratkaistuja lippuja olet lähettänyt helpdesk.';
$txt['shd_closed_staff_greeting'] = 'Kaikki nämä ovat suljettuja/ratkaistuja lippuja, jotka on lähetetty neuvontapalveluun.';
$txt['shd_category_filter'] = 'Kategorian suodatus';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Lippusi on luotu!';
$txt['shd_ticket_posted_body'] = 'Kiitos, että lähetit lippusi {membername}!' . "\n\n" . 'helpdeskin henkilökunta tarkistaa sen ja palaa sinuun mahdollisimman pian.' . "\n\n" . 'Sillä välin, voit katsella lippusi &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; seuraavassa osoitteessa:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Avaa toinen lippu[/iurl] ▲ [iurl={helpdesklink}]Back to the main helpdesk[/iurl] Explore [iurl={forumlink}]Takaisin foorumiin[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Voit ottaa käyttöön sähköpostiilmoitukset lippusi muutoksista [iurl={prefslink}]Helpdesk Asetukset[/iurl] alueella.';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Terveisin,' . "\n" . 'Joukkue {forum_name}';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Lipun tiedot';
$txt['shd_ticket_updated'] = 'Päivitetty';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Nimi';
$txt['shd_ticket_user'] = 'Käyttäjä';
$txt['shd_ticket_date'] = 'Julkaistu';
$txt['shd_ticket_urgency'] = 'Kiireellisyys';
$txt['shd_ticket_assigned'] = 'Määritetty';
$txt['shd_ticket_assignedto'] = 'Määritetty henkilölle';
$txt['shd_ticket_started_by'] = 'Aloittaja';
$txt['shd_ticket_updated_by'] = 'Päivitetty';
$txt['shd_ticket_status'] = 'Tila';
$txt['shd_ticket_num_replies'] = 'Vastaukset';
$txt['shd_ticket_replies'] = 'Vastaukset';
$txt['shd_ticket_staff'] = 'Henkilöstön jäsen';
$txt['shd_ticket_attachments'] = 'Liitteet';
$txt['shd_ticket_reply_number'] = 'Vastaus <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Lippu Pidossa';
$txt['shd_ticket'] = 'Tukipyyntö';
$txt['shd_reply_written'] = 'Vastaa kirjoitettu %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Ei Koskaan';
$txt['shd_linktree_tickets'] = 'Liput';
$txt['shd_ticket_privacy'] = 'Yksityisyys';
$txt['shd_ticket_notprivate'] = 'Ei Yksityinen';
$txt['shd_ticket_private'] = 'Yksityinen';
$txt['shd_ticket_change'] = 'Muuta';
$txt['shd_ticket_ip'] = 'IP-osoite';
$txt['shd_back_to_hd'] = 'Takaisin helpdeskiin';
$txt['shd_go_to_replies'] = 'Siirry vastauksiin';
$txt['shd_go_to_action_log'] = 'Siirry toimintolokiin';
$txt['shd_go_to_replies_start'] = 'Siirry ensimmäiseen vastaukseen';

$txt['shd_ticket_has_been_deleted'] = 'Tämä lippu on tällä hetkellä kierrätettävänä eikä sitä voi muuttaa palaamatta helpdesk-palveluun.';
$txt['shd_ticket_replies_deleted'] = 'Tämä lippu on ollut vastaus poistettu siitä aikaisemmin.';
$txt['shd_ticket_replies_deleted_view'] = 'Nämä näkyvät värillisellä taustalla. <a href="%1$s">Näytä lippu ilman poistoja</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Ole hyvä ja <a href="%1$s">klikkaa tästä</a> nähdäksesi ne.';

$txt['shd_ticket_notnew'] = 'Olet jo nähnyt tämän';
$txt['shd_ticket_new'] = 'Uusi!';

$txt['shd_linktree_move_ticket'] = 'Siirrä lippu';
$txt['shd_linktree_move_topic'] = 'Siirrä aihe helpdeskiin';

$txt['shd_cancel_ticket'] = 'Peruuta ja palaa lippuun';
$txt['shd_cancel_home'] = 'Peruuta ja palaa helpdeskin kotiin';
$txt['shd_cancel_topic'] = 'Peruuta ja palaa aiheeseen';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Vastaa lippuun';
$txt['shd_ticket_quote'] = 'Vastaa lainauksella';
$txt['shd_go_advanced'] = 'Mene eteenpäin!';
$txt['shd_ticket_edit_reply'] = 'Muokkaa vastausta';
$txt['shd_ticket_quote_short'] = 'Tarjous';
$txt['shd_ticket_markunread'] = 'Merkitse lukemattomaksi';
$txt['shd_ticket_reply_short'] = 'Vastaa';
$txt['shd_ticket_edit'] = 'Muokkaa';
$txt['shd_ticket_resolved'] = 'Merkitse selvitetyksi';
$txt['shd_ticket_unresolved'] = 'Merkitse ratkaisemattomaksi';
$txt['shd_ticket_assign'] = 'Määritä';
$txt['shd_ticket_assign_self'] = 'Liitä minulle';
$txt['shd_ticket_reassign'] = 'Määritä Uudelleen';
$txt['shd_ticket_unassign'] = 'Poista Määritä';
$txt['shd_ticket_delete'] = 'Poista';
$txt['shd_delete_confirm'] = 'Oletko varma, että haluat poistaa tämän lipun? Jos se on poistettu, tämä lippu siirretään kierrätysroskakoriin.';
$txt['shd_delete_reply_confirm'] = 'Oletko varma, että haluat poistaa tämän vastauksen? Jos se poistetaan, tämä vastaus siirretään kierrätysastiaan.';
$txt['shd_delete_attach_confirm'] = 'Oletko varma, että haluat poistaa tämän liitteen? (Tätä ei voi kumota!)';
$txt['shd_delete_attach'] = 'Poista tämä liite';
$txt['shd_ticket_restore'] = 'Palauta';
$txt['shd_delete_permanently'] = 'Poista pysyvästi';
$txt['shd_delete_permanently_confirm'] = 'Oletko varma, että haluat poistaa lipun pysyvästi? Tätä EI voi kumota!';
$txt['shd_ticket_move_to_topic'] = 'Siirrä aiheeseen';
$txt['shd_move_dept'] = 'Siirrä syvyyttä.';
$txt['shd_actions'] = 'Toiminnot';
$txt['shd_back_to_ticket'] = 'Palaa tähän lippuun lähettämisen jälkeen';
$txt['shd_disable_smileys_post'] = 'Poista hymiöt käytöstä tässä viestissä';
$txt['shd_resolve_this_ticket'] = 'Merkitse tämä lippu selvitetyksi';
$txt['shd_override_cf'] = 'Ohita mukautettujen kenttien vaatimukset';
$txt['shd_silent_update'] = 'Äänetön päivitys (lähetä ilmoituksia)';
$txt['shd_select_notifications'] = 'Valitse ihmiset ilmoittaaksesi tästä vastauksesta...';

$txt['shd_ticket_assign_ticket'] = 'Määritä Tiketti';
$txt['shd_ticket_assign_to'] = 'Liitä lippu';

$txt['shd_ticket_move_dept'] = 'Siirrä tiketti toiseen osastoon';
$txt['shd_ticket_move_to'] = 'Siirrä kohteeseen';
$txt['shd_current_dept'] = 'Tällä hetkellä osastolla';
$txt['shd_ticket_move'] = 'Siirrä Tukipyyntöä';
$txt['shd_unknown_dept'] = 'Määritettyä osastoa ei ole olemassa.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Uusi aihe';
$txt['shd_move_ticket_to_topic'] = 'Siirrä lippu aiheeseen';
$txt['shd_move_ticket'] = 'Siirrä lippu';
$txt['shd_ticket_board'] = 'Lauta';
$txt['shd_change_ticket_subject'] = 'Muuta lipun otsikkoa';
$txt['shd_move_send_pm'] = 'Lähetä PM lipun omistajalle';
$txt['shd_move_why'] = 'Ole hyvä ja anna lyhyt kuvaus siitä, miksi tämä lippu on siirretty foorumin aiheeseen.';
$txt['shd_ticket_moved_subject'] = 'Lippusi on siirretty.';
$txt['shd_move_default'] = 'Hei {user},' . "\n\n" . 'Sinun lippusi {subject}, on siirretty helpdeskistä aiheeseen foorumilla. @ info' . "\n" . 'Voit löytää tilisi aluksella {board} tai tämän linkin kautta:' . "\n\n" . '{link}' . "\n\n" . 'Kiitos';

$txt['shd_move_topic_to_ticket'] = 'Siirrä aihe helpdeskiin';
$txt['shd_move_topic'] = 'Siirrä aihe';
$txt['shd_change_topic_subject'] = 'Muuta aiheen aihetta';
$txt['shd_move_send_pm_topic'] = 'Lähetä viesti aiheeseen käynnistettäväksi';
$txt['shd_move_why_topic'] = 'Ole hyvä ja anna lyhyt kuvaus siitä, miksi tämä aihe on siirretty helpdeskiin. ';
$txt['shd_ticket_moved_subject_topic'] = 'Aihe on siirretty.';
$txt['shd_move_default_topic'] = 'Hei {user},' . "\n\n" . 'Aihe, {subject}, on siirretty foorumista Helpdesk osioon.' . "\n" . 'Voit löytää aiheen tämän linkin kautta:' . "\n\n" . '{link}' . "\n\n" . 'Kiitos';

$txt['shd_user_no_hd_access'] = 'Huomautus: henkilö, joka aloitti tämän aiheen, ei näe helpdesk!';
$txt['shd_user_helpdesk_access'] = 'Henkilö, joka aloitti tämän aiheen voi nähdä helpdesk.';
$txt['shd_user_hd_access_dept_1'] = 'Henkilö, joka aloitti tämän aiheen, voi nähdä seuraavat osastot: ';
$txt['shd_user_hd_access_dept'] = 'Henkilö, joka aloitti tämän aiheen, voi nähdä seuraavat osastot: ';
$txt['shd_move_ticket_department'] = 'Siirrä lippu mihin osastoon';
$txt['shd_move_dept_why'] = 'Ole hyvä ja anna lyhyt kuvaus siitä, miksi tämä lippu on siirretty eri osastolle.';
$txt['shd_move_dept_default'] = 'Hei {user},' . "\n\n" . 'Sinun lippusi {subject}, on siirretty {current_dept} osastolta {new_dept} osastolle.' . "\n" . 'Voit löytää lippusi tämän linkin kautta:' . "\n\n" . '{link}' . "\n\n" . 'Kiitos';

$txt['shd_ticket_move_deleted'] = 'Tämä lippu on vastauksia, jotka ovat tällä hetkellä kierrätetään roskassa. Mitä haluat tehdä?';
$txt['shd_ticket_move_deleted_abort'] = 'Lopeta, vie minut kierrätysroskakoriin';
$txt['shd_ticket_move_deleted_delete'] = 'Jatka ja hylkää poistetut vastaukset (älä siirrä niitä uuteen aiheeseen)';
$txt['shd_ticket_move_deleted_undelete'] = 'Jatka ja poista vastaukset (siirrä ne uuteen aiheeseen)';

$txt['shd_ticket_move_cfs'] = 'Tällä lipulla on mukautettuja kenttiä, joita täytyy ehkä siirtää.';
$txt['shd_ticket_move_cfs_warn'] = 'Jotkin näistä kennoista eivät välttämättä näy muille käyttäjille. Nämä kentät on merkitty huutomerkillä.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Voit nähdä tämän kentän, muut käyttäjät eivät voi - mutta kun siitä tulee osa foorumia, se tulee näkyviin kaikille, jotka voivat käyttää foorumia.';
$txt['shd_ticket_move_cfs_purge'] = 'Poista kentän sisältö';
$txt['shd_ticket_move_cfs_embed'] = 'Pidä kenttä ja laita se uuteen aiheeseen';
$txt['shd_ticket_move_cfs_user'] = 'Tällä hetkellä näkyvissä tavallisille käyttäjille';
$txt['shd_ticket_move_cfs_staff'] = 'Tällä hetkellä näkyvissä henkilökunnan jäsenille';
$txt['shd_ticket_move_cfs_admin'] = 'Tällä hetkellä näkyvissä järjestelmänvalvojille';
$txt['shd_ticket_move_accept'] = 'Hyväksyn sen, että jotkin täällä käsiteltävistä aloista eivät näy kaikille käyttäjille, ja että tämä aihe olisi siirrettävä foorumille, jossa on yllä olevat asetukset.';
$txt['shd_ticket_move_reqd'] = 'Tämä valinta on valittava, jotta voit siirtää tämän lipun foorumille.';
$txt['shd_ticket_move_ok'] = 'Tämä kenttä on turvallista liikkua, kaikki käyttäjät, jotka näkevät lipun, voivat nähdä tämän kentän, käyttäjiltä tai henkilökunnalta ei ole piilotettuja tietoja.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Tällä lipulla on kenttiä, joita käyttäjät tai henkilökunta eivät ehkä pysty näkemään, sellaisinaan sinun täytyy erityisesti vahvistaa, että olet tietoinen tästä - mene takaisin edelliselle sivulle, valintaruutu jotta voit vahvistaa tietoisuutesi tästä on lomakkeen alareunassa.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Kierrätä BIN';
$txt['shd_recycle_greeting'] = 'Tämä on kierrätysbin. Kaikki poistetut liput menevät tänne, mutta henkilökunta, jolla on erityisoikeudet, voi poistaa liput pysyvästi täältä.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Luo lippu';
$txt['shd_edit_ticket'] = 'Muokkaa lippua';
$txt['shd_edit_ticket_linktree'] = 'Muokkaa lippua (%s)';
$txt['shd_ticket_subject'] = 'Tukipyynnön aihe';
$txt['shd_ticket_proxy'] = 'Postin puolesta';
$txt['shd_ticket_post_error'] = 'Seuraava kysymys, tai kysymyksiä, tapahtui yrittäessään lähettää tämän lipun';
$txt['shd_reply_ticket'] = 'Vastaa lippuun';
$txt['shd_reply_ticket_linktree'] = 'Vastaa lippuun (%s)';
$txt['shd_edit_reply_linktree'] = 'Muokkaa vastausta (%s)';
$txt['shd_previewing_ticket'] = 'Lipun esikatselu';
$txt['shd_previewing_reply'] = 'Esikatsele vastausta kohteeseen';
$txt['shd_choose_one'] = '[Valitse yksi]';
$txt['shd_no_value'] = '[ei arvoa]';
$txt['shd_ticket_dept'] = 'Tukipyynnön osasto';
$txt['shd_select_dept'] = '-- Valitse osasto --';
$txt['canned_replies'] = 'Lisää ennalta määritelty vastaus:';
$txt['canned_replies_select'] = '-- Valitse vastaus --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Ohjedesk vastaukset lähetetty IP (vaihteluväli)';
$txt['shd_no_replies_from_ip'] = 'helpdesk vastausta annetulta IP-osoitteelta (vaihteluväli) ei löytynyt';
$txt['shd_replies_from_ip_desc'] = 'Alla on luettelo kaikista viesteistä, jotka on lähetetty tämän IP-osoitteen (alue).';
$txt['shd_is_ticket_opener'] = ' (lipun käynnistäminen)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2-arkisto';
$txt['shd_attachtype_gz'] = 'GZip-arkisto';
$txt['shd_attachtype_rar'] = 'Karkaus/WinRAR arkisto';
$txt['shd_attachtype_zip'] = 'Postinumero arkisto';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) äänitiedosto';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windows Bitmap -kuva';
$txt['shd_attachtype_gif'] = 'Grafiikan vaihtomuoto (GIF) kuva';
$txt['shd_attachtype_jpeg'] = 'Joint Photographic Experts Group (JPEG) kuva';
$txt['shd_attachtype_jpg'] = 'Joint Photographic Experts Group (JPEG) kuva';
$txt['shd_attachtype_png'] = 'Kannettava verkon graafinen kuva (PNG)';
$txt['shd_attachtype_svg'] = 'Skaalautuva vektorigraafinen kuva (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Video -elokuva';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Word -asiakirja';
$txt['shd_attachtype_mdb'] = 'Microsoft Access -tietokanta';
$txt['shd_attachtype_ppt'] = 'Microsoft Powerpoint esitys';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++- lähdetiedosto';
$txt['shd_attachtype_php'] = 'PHP skripti';
$txt['shd_attachtype_py'] = 'Python lähdekooditiedosto';
$txt['shd_attachtype_rb'] = 'Ruby lähdetiedosto';
$txt['shd_attachtype_sql'] = 'SQL-skripti';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KML-arkisto)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Portable Document File';
$txt['shd_attachtype_psd'] = 'Adobe Photoshop -asiakirja';
$txt['shd_attachtype_swf'] = 'Adobe Flash tiedosto';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Suoritettava tiedosto (Windows)';
$txt['shd_attachtype_htm'] = 'Hypertekstin Markup Document (Html)';
$txt['shd_attachtype_html'] = 'Hypertekstin Markup Document (Html)';
$txt['shd_attachtype_rtf'] = 'Rich Text Format (Rtf)';
$txt['shd_attachtype_txt'] = 'Pelkkä teksti';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Tukipyynnön toimintaloki';
$txt['shd_ticket_log_count_one'] = '1 merkintä';
$txt['shd_ticket_log_count_more'] = '%s merkintää';
$txt['shd_ticket_log_none'] = 'Tämä lippu ei ole muuttunut lainkaan.';
$txt['shd_ticket_log_member'] = 'Jäsen';
$txt['shd_ticket_log_ip'] = 'Jäsen IP:';
$txt['shd_ticket_log_date'] = 'Päivämäärä';
$txt['shd_ticket_log_action'] = 'Toiminto';
$txt['shd_ticket_log_full'] = 'Siirry koko toimintolokiin (Kaikki tiketit)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Liittyvät Tiketit';
$txt['shd_ticket_create_relationship'] = 'Luo suhde';
$txt['shd_ticket_delete_relationship'] = 'Poista suhde';
$txt['shd_ticket_reltype'] = 'valitse tyyppi';
$txt['shd_ticket_reltype_linked'] = 'Linkitetty kohteeseen';
$txt['shd_ticket_reltype_duplicated'] = 'Monista kohteista';
$txt['shd_ticket_reltype_parent'] = 'Vanhemmat';
$txt['shd_ticket_reltype_child'] = 'Lapsi,';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'LisÃ¤tietoja';
$txt['shd_ticket_additional_details'] = 'Lisätiedot';
$txt['shd_ticket_empty_field'] = 'Tämä kenttä on tyhjä.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Ilmoitukset';
$txt['shd_ticket_notify_noneprefs'] = 'Käyttäjäasetuksesi eivät anna tiliä tämän lipun ilmoittamisesta.';
$txt['shd_ticket_notify_changeprefs'] = 'Muuta asetuksiasi';
$txt['shd_ticket_notify_because'] = 'Asetuksesi osoittavat, että sinulle ilmoitetaan tämän lipun vastauksista:';
$txt['shd_ticket_notify_because_yourticket'] = 'koska se on lippusi';
$txt['shd_ticket_notify_because_assignedyou'] = 'koska se on määritetty sinulle';
$txt['shd_ticket_notify_because_priorreply'] = 'kuten vastasit siihen ennen';
$txt['shd_ticket_notify_because_anyreply'] = 'mille tahansa lipulle';

$txt['shd_ticket_notify_me_always'] = 'Seuraat tätä lippua (ja saat ilmoituksen jokaisesta vastauksesta)';
$txt['shd_ticket_monitor_on_note'] = 'Voit seurata kaikkia tämän lipun vastauksia sähköpostitse riippumatta asetuksista:';
$txt['shd_ticket_monitor_off_note'] = 'Voit poistaa tämän lipun seurannan käytöstä ja käyttää asetuksiasi sen sijaan:';
$txt['shd_ticket_monitor_on'] = 'Ota seuranta käyttöön';
$txt['shd_ticket_monitor_off'] = 'Poista seuranta käytöstä';
$txt['shd_ticket_notify_me_never_note'] = 'Voit jättää tämän lipun sähköpostipäivitykset huomiotta riippumatta asetuksistasi:';
$txt['shd_ticket_notify_me_never'] = 'Olet poistanut kaikki tämän lipun ilmoitukset käytöstä.';
$txt['shd_ticket_notify_me_never_on'] = 'Poista ilmoitukset käytöstä';
$txt['shd_ticket_notify_me_never_off'] = 'Ota ilmoitukset käyttöön';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Hakulaitos ei saa luetella kaikkia saatavilla olevia lippuja; sitä tutkitaan parhaillaan.';
$txt['shd_search_warning_admin'] = 'Etsintäpalvelu edellyttää, että sen indeksi rakennetaan uudelleen. Voit saavuttaa tämän ylläpitopaikan ja Helpdeskin alueen ylläpitopaikan kautta.';
$txt['shd_search'] = 'Etsi Tiketit';
$txt['shd_search_results'] = 'Hae Lippuja - Tulokset';
$txt['shd_search_text'] = 'Sanat, joita etsit:';
$txt['shd_search_match'] = 'Mitä pitäisi sovittaa?';
$txt['shd_search_match_all'] = 'Täsmää kaikki käytetyt sanat';
$txt['shd_search_match_any'] = 'Täsmää mitä tahansa sanaa';
$txt['shd_search_scope'] = 'Sisällytä minkä tyyppisiä lippuja:';
$txt['shd_search_scope_open'] = 'Avoimet liput';
$txt['shd_search_scope_closed'] = 'Suljetut liput';
$txt['shd_search_scope_recycle'] = 'Kierrätetyn roskan esineet';
$txt['shd_search_result_ticket'] = 'Tukipyyntö %1$s';
$txt['shd_search_result_reply'] = 'Vastaa lippuun %1$s';
$txt['shd_search_last_updated'] = 'Viimeksi päivitetty:';
$txt['shd_search_ticket_opened_by'] = 'Lippu avattu:';
$txt['shd_search_ticket_replied_by'] = 'Tukipyyntö vastasi:';
$txt['shd_search_dept'] = 'Etsi missä osastossa (-yksiköissä):';

$txt['shd_search_urgency'] = 'Mukaan luettuina kiireellisyysasteet:';

$txt['shd_search_where'] = 'Mitä kohteita etsit:';
$txt['shd_search_where_tickets'] = 'Lippujen hallintoelimet';
$txt['shd_search_where_replies'] = 'Vastaukset lipuissa';
$txt['shd_search_where_subjects'] = 'Tukipyynnön aiheet';

$txt['shd_search_ticket_starter'] = 'Liput aloitettu:';
$txt['shd_search_ticket_assignee'] = 'Liput liitetty osoitteeseen:';
$txt['shd_search_ticket_named_person'] = 'Kirjoita sen henkilön (henkilöiden) nimi, josta olet kiinnostunut.';

$txt['shd_search_no_results'] = 'Tuloksia ei löydy annetuilla kriteereillä. Voit halutessasi palata takaisin ja yrittää muuttaa hakuehtojasi.';
$txt['shd_search_criteria'] = 'Hakukriteeri:';
$txt['shd_search_excluded'] = 'Jos kaikki mahdolliset vaihtoehdot on valittu, se ei ole sisällytetty yllä (esim. jos kaikki mahdolliset tasot kiireellisyys merkittiin, se ei ole mainittu edellä, joten voit keskittyä mitä on erityinen haku)';
//@}