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
$txt['shd_helpdesk'] = 'Centrum pomocy technicznej';
$txt['shd_helpdesk_maintenance'] = 'helpdesk jest obecnie w <strong>trybie konserwacji</strong>. Tylko administratorzy forum i helpdesk mogą to zobaczyć.';
$txt['shd_open_ticket'] = 'otwórz bilet';
$txt['shd_open_tickets'] = 'otwarte bilety';
$txt['shd_none'] = 'Brak';

$txt['shd_display_nojs'] = 'JavaScript nie jest włączony w przeglądarce. Niektóre funkcje mogą nie działać poprawnie (lub w ogóle) lub zachowywać się w nieoczekiwany sposób.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Witaj w głównym centrum zarządzania helpdesk!';
$txt['shd_admin_title'] = 'Centrum Administracji Helpdesk';
$txt['shd_staff_list'] = 'Zespół Helpdesk';
$txt['shd_update_available'] = 'Dostępna jest nowa wersja!';
$txt['shd_update_message'] = 'Nowa wersja SimpleDesk została wydana. Zalecaliśmy <a href="#" id="update-link">aktualizację do najnowszej wersji</a> , aby zachować bezpieczeństwo i cieszyć się wszystkimi funkcjami, które oferują nasze modyfikacje.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Aby uzyskać więcej informacji na temat tego, co nowego w tej wersji, odwiedź <a href="#" id="information-link" target="_blank">naszą stronę</a>.</span><br>' . "\n\n" . '<strong>Zespół SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Niski';
$txt['shd_urgency_1'] = 'Średni';
$txt['shd_urgency_2'] = 'Wysoka';
$txt['shd_urgency_3'] = 'Bardzo wysoka';
$txt['shd_urgency_4'] = 'Ciężki';
$txt['shd_urgency_5'] = 'Krytyczne';
$txt['shd_urgency_increase'] = 'Zwiększ';
$txt['shd_urgency_decrease'] = 'Zmniejsz';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Nowy';
$txt['shd_status_1'] = 'Oczekujący komentarz dla personelu';
$txt['shd_status_2'] = 'Oczekujący komentarz użytkownika';
$txt['shd_status_3'] = 'Rozwiązane/zamknięte';
$txt['shd_status_4'] = 'Zwrócono się do inspektora';
$txt['shd_status_5'] = 'Eskalowany - pilny';
$txt['shd_status_6'] = 'Usunięto';
$txt['shd_status_7'] = 'Wstrzymaj';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Nowe zgłoszenia';
$txt['shd_status_1_heading'] = 'Bilety oczekujące na odpowiedź personelu';
$txt['shd_status_2_heading'] = 'Zgłoszenia oczekujące na odpowiedź użytkownika';
$txt['shd_status_3_heading'] = 'Zamknięte zgłoszenia';
$txt['shd_status_4_heading'] = 'Zgłoszenia zgłoszone przez inspektora';
$txt['shd_status_5_heading'] = 'Pilne zgłoszenia';
$txt['shd_status_6_heading'] = 'Bilety poddane recyklingowi';
$txt['shd_status_7_heading'] = 'Wstrzymaj zgłoszenia';
$txt['shd_status_assigned_heading'] = 'Przypisane do mnie';
$txt['shd_status_withdeleted_heading'] = 'Bilety z usuniętymi odpowiedziami';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Otwarte zgłoszenia';
$txt['shd_tickets_closed'] = 'Zamknięte zgłoszenia';
$txt['shd_tickets_recycled'] = 'Bilety poddane recyklingowi';

$txt['shd_assigned'] = 'Przypisane';
$txt['shd_unassigned'] = 'Nieprzypisane';

$txt['shd_read_ticket'] = 'Odczyt zgłoszenia';
$txt['shd_unread_ticket'] = 'Nieprzeczytane zgłoszenie';
$txt['shd_unread_tickets'] = 'Nieprzeczytane zgłoszenia';

$txt['shd_owned'] = 'Posiadane zgłoszenie'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'bilet';
$txt['shd_count_tickets'] = 'bilety';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Nie masz uprawnień do dostępu do pomocy technicznej.';
$txt['shd_no_ticket'] = 'Bilet, którego zażądałeś, nie istnieje.';
$txt['shd_no_reply'] = 'Odpowiedź na zgłoszenie, którą masz nie istnieje, lub nie jest częścią tego zgłoszenia.';
$txt['shd_no_topic'] = 'Temat, o który prosiłeś, nie istnieje.';
$txt['shd_ticket_no_perms'] = 'Nie masz uprawnień do przeglądania tego zgłoszenia.';
$txt['shd_error_no_tickets'] = 'Nie znaleziono zgłoszeń.';
$txt['shd_inactive'] = 'helpdesk jest obecnie dezaktywowany.';
$txt['shd_cannot_assign'] = 'Nie masz uprawnień do przypisywania paragonów.';
$txt['shd_cannot_assign_other'] = 'To zgłoszenie jest już przypisane do innego użytkownika. Nie możesz przypisać go do siebie - skontaktuj się z administratorem.';
$txt['shd_no_staff_assign'] = 'Nie ma skonfigurowanego personelu; przypisanie zgłoszenia nie jest możliwe. Skontaktuj się z administratorem.';
$txt['shd_assigned_not_permitted'] = 'Użytkownik, który poprosiłeś o przypisanie tego zgłoszenia, nie ma wystarczających uprawnień, aby go zobaczyć.';
$txt['shd_cannot_resolve'] = 'Nie masz uprawnień, aby oznaczyć to zgłoszenie jako rozwiązane.';
$txt['shd_cannot_unresolve'] = 'Nie masz uprawnień do ponownego otwarcia rozwiązanego zgłoszenia.';
$txt['error_shd_cannot_resolve_children'] = 'To zgłoszenie nie może być obecnie zamknięte; to zgłoszenie jest nadrzędnym elementem jednego lub więcej otwartych zgłoszeń.';
$txt['error_shd_proxy_unknown'] = 'Użytkownik ten zgłoszenie jest zamieszczany w imieniu nie istnieje.';
$txt['shd_cannot_change_privacy'] = 'Nie masz uprawnień do zmiany prywatności na tym zgłoszeniu.';
$txt['shd_cannot_change_urgency'] = 'Nie masz uprawnień do zmiany pilności tego zgłoszenia.';
$txt['shd_ajax_problem'] = 'Wystąpił problem podczas próby załadowania strony. Czy chcesz spróbować ponownie?';
$txt['shd_cannot_move_ticket'] = 'Nie masz uprawnień do przeniesienia tego zgłoszenia do wątku.';
$txt['shd_cannot_move_topic'] = 'Nie masz uprawnień do przeniesienia tego tematu do zgłoszenia.';
$txt['shd_moveticket_noboards'] = 'Nie ma działów do przeniesienia tego zgłoszenia!';
$txt['shd_move_no_pm'] = 'Musisz podać powód przeniesienia zgłoszenia do właściciela zgłoszenia, lub odznacz opcję "wyślij wiadomość prywatną do właściciela zgłoszenia".';
$txt['shd_move_no_pm_topic'] = 'Musisz podać powód przeniesienia tematu, aby wysłać go do początku tematu, lub odznacz opcję "wyślij wiadomość prywatną do tematu startowego".';
$txt['shd_move_topic_not_created'] = 'Nie udało się przenieść zgłoszenia do działu. Spróbuj ponownie.';
$txt['shd_move_ticket_not_created'] = 'Nie udało się przenieść tematu do działu pomocy technicznej. Spróbuj ponownie.';
$txt['shd_no_replies'] = 'To zgłoszenie nie ma jeszcze żadnych odpowiedzi.';
$txt['cannot_shd_new_ticket'] = 'Nie masz uprawnień do tworzenia nowego zgłoszenia.';
$txt['cannot_shd_edit_ticket'] = 'Nie masz uprawnień do edycji tego zgłoszenia.';
$txt['shd_cannot_reply_any'] = 'Nie masz uprawnień do odpowiedzi na żadne zgłoszenia.';
$txt['shd_cannot_reply_any_but_own'] = 'Nie masz uprawnień do odpowiadania na żadne zgłoszenia inne niż własne.';
$txt['shd_cannot_edit_reply_any'] = 'Nie masz uprawnień do edycji żadnych odpowiedzi.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Nie masz uprawnień do edycji odpowiedzi na żadne zgłoszenia inne niż Twoje własne odpowiedzi.';
$txt['shd_cannot_edit_closed'] = 'Nie możesz edytować rozwiązanych zgłoszeń; musisz najpierw oznaczyć je nierozwiązane.';
$txt['shd_cannot_edit_deleted'] = 'Nie możesz edytować biletów w koszu. Będą one musiały być najpierw przywrócone.';
$txt['shd_cannot_reply_closed'] = 'Nie możesz odpowiedzieć na rozwiązane zgłoszenia; musisz najpierw oznaczyć je nierozwiązane.';
$txt['shd_cannot_reply_deleted'] = 'Nie możesz odpowiedzieć na zgłoszenia w koszu. Trzeba je najpierw przywrócić.';
$txt['shd_cannot_delete_ticket'] = 'Nie masz uprawnień, aby usunąć to zgłoszenie.';
$txt['shd_cannot_delete_reply'] = 'Nie masz uprawnień do usunięcia tej odpowiedzi.';
$txt['shd_cannot_restore_ticket'] = 'Nie masz uprawnień do przywrócenia tego zgłoszenia z kosza.';
$txt['shd_cannot_restore_reply'] = 'Nie możesz przywrócić tej odpowiedzi z kosza.';
$txt['shd_cannot_view_resolved'] = 'Nie masz uprawnień do dostępu do rozwiązanych zgłoszeń.';
$txt['cannot_shd_access_recyclebin'] = 'Nie możesz uzyskać dostępu do kosza.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Nie możesz przenieść tego zgłoszenia do forum; jest jedna lub więcej usuniętych odpowiedzi, do których nie masz uprawnień dostępu.';
$txt['shd_cannot_attach_ext'] = 'Typ pliku, który próbujesz załączyć ({ext}) nie jest tutaj dozwolony. Dozwolone typy pliku: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'To zgłoszenie nie jest obecnie dostępne do modyfikacji.';
$txt['shd_invalid_relation'] = 'Musisz podać prawidłowy rodzaj relacji dla tych zgłoszeń.';
$txt['shd_no_relation_delete'] = 'Nie możesz usunąć relacji, która nie istnieje.';
$txt['shd_cannot_relate_self'] = 'Nie możesz zrobić biletu odnoszącego się do siebie.';
$txt['shd_relationships_are_disabled'] = 'Relacje zgłoszeń są obecnie wyłączone.';
$txt['error_invalid_fields'] = 'Następujące pola mają wartości, których nie można użyć: %1$s';
$txt['error_missing_fields'] = 'Następujące pola nie zostały wypełnione i muszą być: %1$s';
$txt['error_missing_multi'] = '%1$s (co najmniej %2$d musi być wybrane)';
$txt['error_no_dept'] = 'Nie wybrałeś działu, na który można wysłać to zgłoszenie.';
$txt['shd_cannot_move_dept'] = 'Nie możesz przenieść tego zgłoszenia, nie ma nigdzie by go przenieść.';
$txt['shd_no_perm_move_dept'] = 'Nie masz uprawnień, aby przenieść to zgłoszenie do innego działu.';
$txt['cannot_shd_delete_attachment'] = 'Nie masz uprawnień do usuwania załączników.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Nie można przenieść tego zgłoszenia do tematu; istnieją załączone pola niestandardowe, które wymagają potwierdzenia przez administratora ruchu.';
$txt['cannot_monitor_ticket'] = 'Nie masz uprawnień, aby włączyć monitorowanie tego zgłoszenia.';
$txt['cannot_unmonitor_ticket'] = 'Nie masz uprawnień, aby wyłączyć monitorowanie dla tego zgłoszenia.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Centrum pomocy technicznej'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Dział'; // ditto
$txt['shd_new_ticket'] = 'Opublikuj nowe zgłoszenie';
$txt['shd_new_ticket_proxy'] = 'Wyślij zgłoszenie proxy';
$txt['shd_helpdesk_profile'] = 'Profil helpdesk';
$txt['shd_welcome'] = 'Witaj, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Przejdź do zgłoszenia';
$txt['shd_options'] = 'Opcje';
$txt['shd_search_menu'] = 'Szukaj';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Informacje';
$txt['shd_admin_options'] = 'Opcje';
$txt['shd_admin_custom_fields'] = 'Pola niestandardowe';
$txt['shd_admin_departments'] = 'Dział';
$txt['shd_admin_permissions'] = 'Uprawnienia';
$txt['shd_admin_plugins'] = 'Wtyczki';
$txt['shd_admin_cannedreplies'] = 'Gotowe Odpowiedzi';
$txt['shd_admin_maint'] = 'Konserwacja';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Tutaj możesz przesłać nowe zgłoszenia dla personelu witryny do działania i sprawdzić bieżące zgłoszenia już w toku.';
$txt['shd_staff_greeting'] = 'Oto wszystkie zgłoszenia, które wymagają uwagi.';
$txt['shd_shd_greeting'] = 'To jest Helpdesk. Tu tracisz czas na pomoc nowicjuszom. Ciesz się! ;D';
$txt['shd_closed_user_greeting'] = 'Są to wszystkie zamknięte/rozwiązane zgłoszenia, które opublikowałeś na helpdesku.';
$txt['shd_closed_staff_greeting'] = 'Są to wszystkie zamknięte/rozwiązane zgłoszenia przesłane do punktu pomocy technicznej.';
$txt['shd_category_filter'] = 'Filtrowanie kategorii';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Twój bilet został utworzony!';
$txt['shd_ticket_posted_body'] = 'Dziękujemy za wysłanie zgłoszenia, {membername}!' . "\n\n" . 'Personel pomocy technicznej jak najszybciej przejrzy ją i wróci do Ciebie.' . "\n\n" . 'W międzyczasie możesz zobaczyć swoje zgłoszenie, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; pod następującym adresem:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Otwórz kolejny bilet[/iurl] | [iurl={helpdesklink}]Wróć do głównego punktu pomocy[/iurl] | [iurl={forumlink}]Wróć do forum[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Możesz włączyć powiadomienia e-mail o zmianach w zgłoszeniu, w obszarze [iurl={prefslink}]Preferencje działu pomocy[/iurl]';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Pozdrawiamy,' . "\n" . 'Zespół {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Szczegóły zgłoszenia';
$txt['shd_ticket_updated'] = 'Zaktualizowano';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Nazwisko';
$txt['shd_ticket_user'] = 'Użytkownik';
$txt['shd_ticket_date'] = 'Opublikowany';
$txt['shd_ticket_urgency'] = 'Pilność';
$txt['shd_ticket_assigned'] = 'Przypisane';
$txt['shd_ticket_assignedto'] = 'Przypisane do';
$txt['shd_ticket_started_by'] = 'Rozpoczęte przez';
$txt['shd_ticket_updated_by'] = 'Zaktualizowane przez';
$txt['shd_ticket_status'] = 'Status';
$txt['shd_ticket_num_replies'] = 'Odpowiedzi';
$txt['shd_ticket_replies'] = 'Odpowiedzi';
$txt['shd_ticket_staff'] = 'Pracownik';
$txt['shd_ticket_attachments'] = 'Załączniki';
$txt['shd_ticket_reply_number'] = 'Odpowiedź <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Wstrzymaj zgłoszenie';
$txt['shd_ticket'] = 'Zgłoszenie';
$txt['shd_reply_written'] = 'Odpowiedź napisana %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Nigdy';
$txt['shd_linktree_tickets'] = 'Bilety';
$txt['shd_ticket_privacy'] = 'Prywatność';
$txt['shd_ticket_notprivate'] = 'Nie prywatne';
$txt['shd_ticket_private'] = 'Prywatny';
$txt['shd_ticket_change'] = 'Zmiana';
$txt['shd_ticket_ip'] = 'Adres IP';
$txt['shd_back_to_hd'] = 'Wróć do działu pomocy technicznej';
$txt['shd_go_to_replies'] = 'Przejdź do odpowiedzi';
$txt['shd_go_to_action_log'] = 'Przejdź do dziennika akcji';
$txt['shd_go_to_replies_start'] = 'Przejdź do pierwszej odpowiedzi';

$txt['shd_ticket_has_been_deleted'] = 'Ten bilet jest obecnie w koszu i nie może zostać zmieniony bez zwrócenia go do punktu pomocy technicznej.';
$txt['shd_ticket_replies_deleted'] = 'To zgłoszenie zostało wcześniej usunięte z niego.';
$txt['shd_ticket_replies_deleted_view'] = 'Są one wyświetlane w kolorowym tle. <a href="%1$s">Zobacz zgłoszenie bez usuwania</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Proszę <a href="%1$s">kliknąć tutaj</a> , aby je zobaczyć.';

$txt['shd_ticket_notnew'] = 'Już to widziałeś';
$txt['shd_ticket_new'] = 'Nowość!';

$txt['shd_linktree_move_ticket'] = 'Przenieś paragon';
$txt['shd_linktree_move_topic'] = 'Przenieś temat do helpdesk';

$txt['shd_cancel_ticket'] = 'Anuluj i wróć do zgłoszenia';
$txt['shd_cancel_home'] = 'Anuluj i wróć do domu helpdesk';
$txt['shd_cancel_topic'] = 'Anuluj i wróć do tematu';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Odpowiedz na zgłoszenie';
$txt['shd_ticket_quote'] = 'Odpowiedz cytatem';
$txt['shd_go_advanced'] = 'Przejdź na zaawansowane!';
$txt['shd_ticket_edit_reply'] = 'Edytuj odpowiedź';
$txt['shd_ticket_quote_short'] = 'Oferta';
$txt['shd_ticket_markunread'] = 'Oznacz jako nieprzeczytane';
$txt['shd_ticket_reply_short'] = 'Odpowiedz';
$txt['shd_ticket_edit'] = 'Edytuj';
$txt['shd_ticket_resolved'] = 'Oznacz jako rozwiązane';
$txt['shd_ticket_unresolved'] = 'Oznacz jako nierozwiązane';
$txt['shd_ticket_assign'] = 'Przypisz';
$txt['shd_ticket_assign_self'] = 'Przypisz do mnie';
$txt['shd_ticket_reassign'] = 'Przypisz ponownie';
$txt['shd_ticket_unassign'] = 'Cofnij przypisanie';
$txt['shd_ticket_delete'] = 'Usuń';
$txt['shd_delete_confirm'] = 'Czy na pewno chcesz usunąć to zgłoszenie? Jeśli je usuniesz, to zgłoszenie zostanie przeniesione do kosza.';
$txt['shd_delete_reply_confirm'] = 'Czy na pewno chcesz usunąć tę odpowiedź? Jeśli ta odpowiedź zostanie usunięta, ta odpowiedź zostanie przeniesiona do kosza.';
$txt['shd_delete_attach_confirm'] = 'Czy na pewno chcesz usunąć ten załącznik? (nie można tego cofnąć!)';
$txt['shd_delete_attach'] = 'Usuń ten załącznik';
$txt['shd_ticket_restore'] = 'Przywróć';
$txt['shd_delete_permanently'] = 'Usuń trwale';
$txt['shd_delete_permanently_confirm'] = 'Czy na pewno chcesz trwale usunąć to zgłoszenie? Tego nie można cofnąć!';
$txt['shd_ticket_move_to_topic'] = 'Przenieś do tematu';
$txt['shd_move_dept'] = 'Przesuń głębię.';
$txt['shd_actions'] = 'Akcje';
$txt['shd_back_to_ticket'] = 'Wróć do tego zgłoszenia po wysłaniu';
$txt['shd_disable_smileys_post'] = 'Wyłącz emotikony w tym poście';
$txt['shd_resolve_this_ticket'] = 'Oznacz to zgłoszenie jako rozwiązane';
$txt['shd_override_cf'] = 'Zastąp wymagania pól niestandardowych';
$txt['shd_silent_update'] = 'Cicha aktualizacja (brak powiadomień)';
$txt['shd_select_notifications'] = 'Wybierz osoby do powiadomienia o tej odpowiedzi...';

$txt['shd_ticket_assign_ticket'] = 'Przypisz zgłoszenie';
$txt['shd_ticket_assign_to'] = 'Przypisz paragon do';

$txt['shd_ticket_move_dept'] = 'Przenieś zgłoszenie do innego departamentu';
$txt['shd_ticket_move_to'] = 'Przenieś do';
$txt['shd_current_dept'] = 'Obecnie w departamencie';
$txt['shd_ticket_move'] = 'Przenieś zgłoszenie';
$txt['shd_unknown_dept'] = 'Podany dział nie istnieje.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Nowy temat';
$txt['shd_move_ticket_to_topic'] = 'Przenieś paragon do tematu';
$txt['shd_move_ticket'] = 'Przenieś paragon';
$txt['shd_ticket_board'] = 'Tablica';
$txt['shd_change_ticket_subject'] = 'Zmień temat zgłoszenia';
$txt['shd_move_send_pm'] = 'Wyślij wiadomość prywatną do właściciela zgłoszenia';
$txt['shd_move_why'] = 'Proszę podać krótki opis powodów, dla których to zgłoszenie jest przenoszone do tematu forum.';
$txt['shd_ticket_moved_subject'] = 'Twoje zgłoszenie zostało przeniesione.';
$txt['shd_move_default'] = 'Witaj {user},' . "\n\n" . 'Twoje zgłoszenie, {subject}, zostało przeniesione z helpdesk na temat na forum.' . "\n" . 'Bilet można znaleźć w dziale {board} lub za pośrednictwem tego linku:' . "\n\n" . '{link}' . "\n\n" . 'Dziękujemy';

$txt['shd_move_topic_to_ticket'] = 'Przenieś temat do helpdesk';
$txt['shd_move_topic'] = 'Przenieś temat';
$txt['shd_change_topic_subject'] = 'Zmień temat';
$txt['shd_move_send_pm_topic'] = 'Wyślij wiadomość prywatną do startera tematu';
$txt['shd_move_why_topic'] = 'Wprowadź krótki opis dlaczego ten temat jest przenoszony do helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Twój temat został przeniesiony.';
$txt['shd_move_default_topic'] = 'Witaj {user},' . "\n\n" . 'Twój wątek, {subject}, został przeniesiony z forum do sekcji Helpdesk.' . "\n" . 'Temat można znaleźć za pomocą tego linku:' . "\n\n" . '{link}' . "\n\n" . 'Dziękujemy';

$txt['shd_user_no_hd_access'] = 'Uwaga: osoba, która rozpoczęła ten temat, nie może zobaczyć działu pomocy technicznej!';
$txt['shd_user_helpdesk_access'] = 'Osoba, która rozpoczęła ten temat, może zobaczyć helpdesk.';
$txt['shd_user_hd_access_dept_1'] = 'Osoba, która rozpoczęła ten temat, może zobaczyć następujący departament: ';
$txt['shd_user_hd_access_dept'] = 'Osoba, która rozpoczęła ten temat, może zobaczyć następujące działy: ';
$txt['shd_move_ticket_department'] = 'Przenieś bilet do którego działu';
$txt['shd_move_dept_why'] = 'Proszę podać krótki opis powodów, dla których to zgłoszenie jest przenoszone do innego departamentu.';
$txt['shd_move_dept_default'] = 'Witaj {user},' . "\n\n" . 'Twoje zgłoszenie, {subject}, zostało przeniesione z działu {current_dept} do działu {new_dept}.' . "\n" . 'Bilet można znaleźć za pomocą tego linku:' . "\n\n" . '{link}' . "\n\n" . 'Dziękujemy';

$txt['shd_ticket_move_deleted'] = 'Ten bilet zawiera odpowiedzi, które są obecnie w koszu. Co chcesz zrobić?';
$txt['shd_ticket_move_deleted_abort'] = 'Przerwij, zabierz mnie do kosza';
$txt['shd_ticket_move_deleted_delete'] = 'Kontynuuj, porzuć usunięte odpowiedzi (nie przenieś ich do nowego tematu)';
$txt['shd_ticket_move_deleted_undelete'] = 'Kontynuuj, cofnij usuwanie odpowiedzi (przenieś je do nowego tematu)';

$txt['shd_ticket_move_cfs'] = 'Ten paragon ma niestandardowe pola, które mogą wymagać przeniesienia.';
$txt['shd_ticket_move_cfs_warn'] = 'Niektóre z tych pól mogą nie być widoczne dla innych użytkowników. Te pola są oznaczone znakiem wykrzyknika.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Możesz zobaczyć to pole, inni użytkownicy nie mogą - ale gdy stanie się częścią forum, stanie się widoczny dla wszystkich, którzy mają dostęp do forum.';
$txt['shd_ticket_move_cfs_purge'] = 'Usuń zawartość pola';
$txt['shd_ticket_move_cfs_embed'] = 'Zachowaj pole i umieść je w nowym temacie';
$txt['shd_ticket_move_cfs_user'] = 'Obecnie widoczne dla zwykłych użytkowników';
$txt['shd_ticket_move_cfs_staff'] = 'Obecnie widoczne dla członków personelu';
$txt['shd_ticket_move_cfs_admin'] = 'Aktualnie widoczne dla administratorów';
$txt['shd_ticket_move_accept'] = 'Zgadzam się, że niektóre pola podlegające manipulacji nie są widoczne dla wszystkich użytkowników, i że ten temat powinien zostać przeniesiony na forum, z powyższymi ustawieniami.';
$txt['shd_ticket_move_reqd'] = 'Ta opcja musi być wybrana, aby przenieść to zgłoszenie na forum.';
$txt['shd_ticket_move_ok'] = 'To pole jest bezpieczne do przeniesienia, wszyscy użytkownicy, którzy mogą zobaczyć zgłoszenie mogą zobaczyć to pole, nie ma żadnych informacji ukrytych przed użytkownikami lub personelem.';
$txt['shd_ticket_move_reqd_nonselected'] = 'To zgłoszenie zawiera pola, których użytkownicy lub pracownicy mogą nie być w stanie zobaczyć, jako taki musisz potwierdzić, że jesteś tego świadomy - wróć na poprzednią stronę, pole wyboru dla potwierdzenia Twojej świadomości na ten temat znajduje się na dole formularza.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Kosz';
$txt['shd_recycle_greeting'] = 'To jest kosz. Wszystkie usunięte bilety trafiają tutaj, ale członkowie personelu ze specjalnymi uprawnieniami mogą z tego miejsca trwale usuwać bilety.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Utwórz paragon';
$txt['shd_edit_ticket'] = 'Edytuj paragon';
$txt['shd_edit_ticket_linktree'] = 'Edytuj zgłoszenie (%s)';
$txt['shd_ticket_subject'] = 'Temat zgłoszenia';
$txt['shd_ticket_proxy'] = 'Post w imieniu';
$txt['shd_ticket_post_error'] = 'Poniższy problem lub problemy pojawiły się podczas próby opublikowania tego zgłoszenia';
$txt['shd_reply_ticket'] = 'Odpowiedz na zgłoszenie';
$txt['shd_reply_ticket_linktree'] = 'Odpowiedz na zgłoszenie (%s)';
$txt['shd_edit_reply_linktree'] = 'Edytuj odpowiedź (%s)';
$txt['shd_previewing_ticket'] = 'Podgląd zgłoszenia';
$txt['shd_previewing_reply'] = 'Podgląd odpowiedzi na';
$txt['shd_choose_one'] = '[Wybierz jeden]';
$txt['shd_no_value'] = '[brak wartości]';
$txt['shd_ticket_dept'] = 'Dział zgłoszenia';
$txt['shd_select_dept'] = '-- Wybierz dział --';
$txt['canned_replies'] = 'Dodaj wstępnie zdefiniowaną odpowiedź:';
$txt['canned_replies_select'] = '-- Wybierz odpowiedź --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Odpowiedzi wysłane z adresu IP (zakres)';
$txt['shd_no_replies_from_ip'] = 'Nie znaleziono odpowiedzi helpdesk z podanego adresu IP (zakres)';
$txt['shd_replies_from_ip_desc'] = 'Poniżej znajduje się lista wszystkich wiadomości wysłanych do helpdesk z tego adresu IP (zakres).';
$txt['shd_is_ticket_opener'] = ' (bilet startowy)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'Archiwum BZip2';
$txt['shd_attachtype_gz'] = 'Archiwum GZP';
$txt['shd_attachtype_rar'] = 'Archiwum Rar/WinRAR';
$txt['shd_attachtype_zip'] = 'Archiwum ZIP';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'Plik audio MP3 (MPEG Layer III)';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Obraz bitmapy Windows';
$txt['shd_attachtype_gif'] = 'Obraz formatu wymiany graficznej (GIF)';
$txt['shd_attachtype_jpeg'] = 'Obraz wspólnej grupy ekspertów fotograficznych (JPEG)';
$txt['shd_attachtype_jpg'] = 'Obraz wspólnej grupy ekspertów fotograficznych (JPEG)';
$txt['shd_attachtype_png'] = 'Przenośny obraz sieciowy (PNG)';
$txt['shd_attachtype_svg'] = 'Skalowalna grafika wektorowa (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Film wideo Windows';
// Office formats
$txt['shd_attachtype_doc'] = 'Dokument Microsoft Word';
$txt['shd_attachtype_mdb'] = 'Baza danych Microsoft Access';
$txt['shd_attachtype_ppt'] = 'Prezentacja punktu zasilania Microsoft';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'Plik źródłowy C++';
$txt['shd_attachtype_php'] = 'Skrypt PHP';
$txt['shd_attachtype_py'] = 'Plik źródłowy Pythona';
$txt['shd_attachtype_rb'] = 'Plik źródłowy Ruby';
$txt['shd_attachtype_sql'] = 'Skrypt SQL';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (archiwum KML)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Przenośny Plik Dokumentu';
$txt['shd_attachtype_psd'] = 'Dokument Adobe Photoshop';
$txt['shd_attachtype_swf'] = 'Plik Adobe Flash';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Plik wykonywalny (Windows)';
$txt['shd_attachtype_htm'] = 'Dokument znaczników hipertekstowych (HTML)';
$txt['shd_attachtype_html'] = 'Dokument znaczników hipertekstowych (HTML)';
$txt['shd_attachtype_rtf'] = 'Format tekstu bogatego (RTF)';
$txt['shd_attachtype_txt'] = 'Zwykły tekst';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Dziennik akcji zgłoszenia';
$txt['shd_ticket_log_count_one'] = '1 wpis';
$txt['shd_ticket_log_count_more'] = '%s wpisów';
$txt['shd_ticket_log_none'] = 'To zgłoszenie nie miało żadnych zmian.';
$txt['shd_ticket_log_member'] = 'Członek';
$txt['shd_ticket_log_ip'] = 'IP użytkownika:';
$txt['shd_ticket_log_date'] = 'Data';
$txt['shd_ticket_log_action'] = 'Akcja';
$txt['shd_ticket_log_full'] = 'Przejdź do pełnego dziennika akcji (Wszystkie zgłoszenia)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Powiązane zgłoszenia';
$txt['shd_ticket_create_relationship'] = 'Utwórz relację';
$txt['shd_ticket_delete_relationship'] = 'Usuń związek';
$txt['shd_ticket_reltype'] = 'wybierz typ';
$txt['shd_ticket_reltype_linked'] = 'Połączono z';
$txt['shd_ticket_reltype_duplicated'] = 'Duplikat';
$txt['shd_ticket_reltype_parent'] = 'Rodzic';
$txt['shd_ticket_reltype_child'] = 'Dziecko';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Dodatkowe informacje';
$txt['shd_ticket_additional_details'] = 'Dodatkowe szczegóły';
$txt['shd_ticket_empty_field'] = 'To pole jest puste.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Powiadomienia';
$txt['shd_ticket_notify_noneprefs'] = 'Twoje preferencje użytkownika nie uwzględniają powiadomień o tym zgłoszeniu.';
$txt['shd_ticket_notify_changeprefs'] = 'Zmień swoje ustawienia';
$txt['shd_ticket_notify_because'] = 'Twoje preferencje wskazują na powiadamianie Cię o odpowiedziach na to zgłoszenie:';
$txt['shd_ticket_notify_because_yourticket'] = 'ponieważ jest to twój bilet';
$txt['shd_ticket_notify_because_assignedyou'] = 'ponieważ jest przypisany do Ciebie';
$txt['shd_ticket_notify_because_priorreply'] = 'tak jak na to odpowiedziałeś przed';
$txt['shd_ticket_notify_because_anyreply'] = 'dla każdego zgłoszenia';

$txt['shd_ticket_notify_me_always'] = 'Monitorujesz to zgłoszenie (i otrzymasz powiadomienie o każdej odpowiedzi)';
$txt['shd_ticket_monitor_on_note'] = 'Możesz monitorować wszystkie odpowiedzi na to zgłoszenie przez e-mail niezależnie od twoich preferencji:';
$txt['shd_ticket_monitor_off_note'] = 'Możesz wyłączyć monitorowanie tego zgłoszenia i zamiast tego użyć swoich preferencji:';
$txt['shd_ticket_monitor_on'] = 'Włącz monitorowanie';
$txt['shd_ticket_monitor_off'] = 'Wyłącz monitorowanie';
$txt['shd_ticket_notify_me_never_note'] = 'Możesz zignorować aktualizacje wiadomości e-mail dla tego zgłoszenia niezależnie od twoich preferencji:';
$txt['shd_ticket_notify_me_never'] = 'Wyłączyłeś wszystkie powiadomienia dla tego zgłoszenia.';
$txt['shd_ticket_notify_me_never_on'] = 'Wyłącz powiadomienia';
$txt['shd_ticket_notify_me_never_off'] = 'Włącz powiadomienia';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Funkcja wyszukiwania nie może wymieniać wszystkich dostępnych biletów; jest ona obecnie badana.';
$txt['shd_search_warning_admin'] = 'Wyszukiwarka wymaga przebudowy indeksu. Możesz to osiągnąć z opcji Konserwacji, w obszarze Helpdesk w panelu administracyjnym.';
$txt['shd_search'] = 'Szukaj zgłoszeń';
$txt['shd_search_results'] = 'Szukaj zgłoszeń - wyniki';
$txt['shd_search_text'] = 'Słowa, których szukasz:';
$txt['shd_search_match'] = 'Co powinno być dopasowane?';
$txt['shd_search_match_all'] = 'Dopasuj wszystkie dostarczone słowa';
$txt['shd_search_match_any'] = 'Dopasuj wszystkie dostarczone słowa';
$txt['shd_search_scope'] = 'Dołącz typy zgłoszeń:';
$txt['shd_search_scope_open'] = 'Otwarte bilety';
$txt['shd_search_scope_closed'] = 'Zamknięte bilety';
$txt['shd_search_scope_recycle'] = 'Przedmioty w koszu';
$txt['shd_search_result_ticket'] = 'Zgłoszenie %1$s';
$txt['shd_search_result_reply'] = 'Odpowiedz na zgłoszenie %1$s';
$txt['shd_search_last_updated'] = 'Ostatnia aktualizacja:';
$txt['shd_search_ticket_opened_by'] = 'Zgłoszenie otwarte przez:';
$txt['shd_search_ticket_replied_by'] = 'Zgłoszenie odpowiedziało:';
$txt['shd_search_dept'] = 'Szukaj, w którym(-ych) dział(-ach):';

$txt['shd_search_urgency'] = 'Uwzględnij poziom pilności:';

$txt['shd_search_where'] = 'Które elementy do wyszukania:';
$txt['shd_search_where_tickets'] = 'Treść biletów';
$txt['shd_search_where_replies'] = 'Odpowiedzi w zgłoszeniach';
$txt['shd_search_where_subjects'] = 'Tematy zgłoszenia';

$txt['shd_search_ticket_starter'] = 'Zgłoszenia rozpoczęte przez:';
$txt['shd_search_ticket_assignee'] = 'Zgłoszenia przypisane do:';
$txt['shd_search_ticket_named_person'] = 'Wpisz imię i nazwisko osoby, której jesteś zainteresowany.';

$txt['shd_search_no_results'] = 'Nie znaleziono wyników z podanymi kryteriami. Możesz wrócić i spróbować zmienić kryteria wyszukiwania.';
$txt['shd_search_criteria'] = 'Kryteria wyszukiwania:';
$txt['shd_search_excluded'] = 'Jeśli wybrano każdą możliwą opcję, nie została ona uwzględniona w powyższym (np. jeśli wszystkie możliwe poziomy pilności zostały zaznaczone, nie jest to podane powyżej, więc możesz skoncentrować się na tym, co jest specyficzne dla Twojego wyszukiwania).';
//@}