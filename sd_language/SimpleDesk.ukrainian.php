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
$txt['shd_helpdesk'] = 'Довідка';
$txt['shd_helpdesk_maintenance'] = 'Система підтримки працює на даний момент в режимі <strong>обслуговування</strong>. Це можуть бачити лише адміністратори форуму та служби підтримки.';
$txt['shd_open_ticket'] = 'відкрити тікет';
$txt['shd_open_tickets'] = 'відкриті Заявки';
$txt['shd_none'] = 'Без ефекту';

$txt['shd_display_nojs'] = 'У Вашому браузері не ввімкнено JavaScript. Деякі функції можуть не працювати коректно (або взагалі робити), або поводитись несподівано.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Ласкаво просимо до основного центру адміністрування служби підтримки!';
$txt['shd_admin_title'] = 'Центр адміністрування порталу допомоги';
$txt['shd_staff_list'] = 'Центр підтримки';
$txt['shd_update_available'] = 'Доступна нова версія!';
$txt['shd_update_message'] = 'Вийшла нова версія SimpleDesk. Рекомендуємо вам <a href="#" id="update-link">оновити останню версію</a> для того, щоб залишатися в безпеці і насолоджуватися всіма функціями, які можуть запропонувати наші зміни.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Для отримання додаткової інформації про новий у цьому релізі, будь ласка, відвідайте <a href="#" id="information-link" target="_blank">наш веб-сайт</a>.</span><br>' . "\n\n" . '<strong>Команда SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Низька';
$txt['shd_urgency_1'] = 'Медіум';
$txt['shd_urgency_2'] = 'Високий';
$txt['shd_urgency_3'] = 'Дуже високий';
$txt['shd_urgency_4'] = 'Високий';
$txt['shd_urgency_5'] = 'Критичний';
$txt['shd_urgency_increase'] = 'Збільшити';
$txt['shd_urgency_decrease'] = 'Зменшити';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Новий';
$txt['shd_status_1'] = 'Коментар співробітника';
$txt['shd_status_2'] = 'Коментар користувача';
$txt['shd_status_3'] = 'Вирішено/Закрито';
$txt['shd_status_4'] = 'Посилання на Супервізор';
$txt['shd_status_5'] = 'Ескалація - Терміновий';
$txt['shd_status_6'] = 'Видалено';
$txt['shd_status_7'] = 'Призупинено';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Нові Заявки';
$txt['shd_status_1_heading'] = 'Заявки на відповідь співробітника';
$txt['shd_status_2_heading'] = 'Заявки очікує на відповідь користувача';
$txt['shd_status_3_heading'] = 'Закриті Заявки';
$txt['shd_status_4_heading'] = 'Тікети, посилання до керівника';
$txt['shd_status_5_heading'] = 'Термінові заявки';
$txt['shd_status_6_heading'] = 'Запропоновані тікети';
$txt['shd_status_7_heading'] = 'Веб тікети';
$txt['shd_status_assigned_heading'] = 'Доручена мені';
$txt['shd_status_withdeleted_heading'] = 'Квитки з видаленими відповідями';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Відкриті заявки';
$txt['shd_tickets_closed'] = 'Закриті Заявки';
$txt['shd_tickets_recycled'] = 'Запропоновані тікети';

$txt['shd_assigned'] = 'Призначено';
$txt['shd_unassigned'] = 'Непризначений';

$txt['shd_read_ticket'] = 'Прочитати тікет';
$txt['shd_unread_ticket'] = 'Непрочитаний тікет';
$txt['shd_unread_tickets'] = 'Непрочитані заявки';

$txt['shd_owned'] = 'Власний тікет'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'квиток';
$txt['shd_count_tickets'] = 'квитки';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Вам не дозволено отримати доступ до служби підтримки.';
$txt['shd_no_ticket'] = 'Запитаний квиток не існує.';
$txt['shd_no_reply'] = 'Заявка не існує або не є частиною цього тікета.';
$txt['shd_no_topic'] = 'Тема, яку ви вказали, не існує.';
$txt['shd_ticket_no_perms'] = 'У вас немає дозволу на перегляд цього тікета.';
$txt['shd_error_no_tickets'] = 'Не знайдено тікетів.';
$txt['shd_inactive'] = 'Система підтримки наразі деактивована.';
$txt['shd_cannot_assign'] = 'Вам не дозволено призначати тікети.';
$txt['shd_cannot_assign_other'] = 'Цей тікет вже присвоєно іншому користувачу. Ви не можете перепризначити його собі - будь ласка, зверніться до адміністратора.';
$txt['shd_no_staff_assign'] = 'Немає налаштованих співробітників; неможливо призначити заявку. Будь ласка, зверніться до адміністратора.';
$txt['shd_assigned_not_permitted'] = 'Користувач, який ви просили призначити, не має достатнього дозволу, щоб побачити його.';
$txt['shd_cannot_resolve'] = 'Ви не маєте дозволу відзначити цей тікет як вирішений.';
$txt['shd_cannot_unresolve'] = 'У вас немає дозволу повторно відкрити вирішений тікет.';
$txt['error_shd_cannot_resolve_children'] = 'Цей тікет не може бути закритим; цей тікет є батьківським або кількома квитками, які на даний момент відкриті.';
$txt['error_shd_proxy_unknown'] = 'Користувач розміщений від імені тікета, не існує.';
$txt['shd_cannot_change_privacy'] = 'У вас немає дозволу на зміну приватності на цьому заявці.';
$txt['shd_cannot_change_urgency'] = 'У вас немає дозволу на зміну терміновості цього тікета.';
$txt['shd_ajax_problem'] = 'Сталася помилка при спробі завантажити сторінку. Бажаєте спробувати ще раз?';
$txt['shd_cannot_move_ticket'] = 'Ви не маєте дозволу перемістити цей тікет у тему.';
$txt['shd_cannot_move_topic'] = 'У вас немає дозволу на переміщення цієї теми в тікет.';
$txt['shd_moveticket_noboards'] = 'Немає дошок для переміщення цього квитка!';
$txt['shd_move_no_pm'] = 'Ви повинні вказати причину перенесення квитка на відправлення власнику тікета, або зніміть прапорець з опцією \'надіслати ПП користувачем\'.';
$txt['shd_move_no_pm_topic'] = 'Ви повинні ввести причину переміщення теми, щоб надіслати до початку теми, або зніміть відмітку з параметра, щоб \'відправити PM до початкової теми\'.';
$txt['shd_move_topic_not_created'] = 'Не вдалося перемістити квиток на дошку. Будь ласка, спробуйте ще раз.';
$txt['shd_move_ticket_not_created'] = 'Не вдалося перемістити тему до служби підтримки. Будь ласка, спробуйте ще раз.';
$txt['shd_no_replies'] = 'Цей тікет ще немає відповідей.';
$txt['cannot_shd_new_ticket'] = 'У вас немає дозволу створювати новий квиток.';
$txt['cannot_shd_edit_ticket'] = 'Ви не маєте дозволу редагувати цей тікет.';
$txt['shd_cannot_reply_any'] = 'Ви не маєте дозволу на відповідь на жодну з заявок.';
$txt['shd_cannot_reply_any_but_own'] = 'У вас немає дозволу відповідати на будь-які заявки, окрім власності.';
$txt['shd_cannot_edit_reply_any'] = 'Ви не маєте дозволу редагувати будь-які відповіді.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Ви не маєте дозволу змінювати відповіді на будь-які тікети, окрім ваших власних відповідей.';
$txt['shd_cannot_edit_closed'] = 'Ви не можете редагувати вирішені квитки; вам потрібно спочатку помітити його невирішеним.';
$txt['shd_cannot_edit_deleted'] = 'Неможливо редагувати квитки в кошику. Спочатку вони повинні бути відновлені.';
$txt['shd_cannot_reply_closed'] = 'Ви не можете відповісти на вирішені тікети; ви повинні вказати їх в першу чергу.';
$txt['shd_cannot_reply_deleted'] = 'У кошику не можна відповісти на квитки. Спочатку їх необхідно буде відновити.';
$txt['shd_cannot_delete_ticket'] = 'Вам не дозволено видаляти цю заявку.';
$txt['shd_cannot_delete_reply'] = 'Вам не дозволено видаляти цю відповідь.';
$txt['shd_cannot_restore_ticket'] = 'Вам не дозволено відновити цей тікет із смітника.';
$txt['shd_cannot_restore_reply'] = 'Вам не дозволено відновити цю відповідь з кошика.';
$txt['shd_cannot_view_resolved'] = 'Вам не дозволено доступ до вирішених заявок.';
$txt['cannot_shd_access_recyclebin'] = 'Ви не можете отримати доступ до кошика.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Ви не можете перемістити цей тікет у форум; є хоча б один або декілька видалених відповідей, до яких у вас поточні дозволи не надано доступ.';
$txt['shd_cannot_attach_ext'] = 'Тип файлу, який ви намагалися вкласти ({ext}) тут не допускається. Дозволені типи файлів: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Цей тікет недоступний для змін.';
$txt['shd_invalid_relation'] = 'Ви повинні вказати правильний тип зв\'язку для цих квитків.';
$txt['shd_no_relation_delete'] = 'Ви не можете видалити зв\'язки, які не існують.';
$txt['shd_cannot_relate_self'] = 'Ви не можете зробити квиток пов\'язаний з самим собою.';
$txt['shd_relationships_are_disabled'] = 'Сервіси квитків вимкнуті.';
$txt['error_invalid_fields'] = 'Наступні поля мають значення, які не можна використовувати: %1$s';
$txt['error_missing_fields'] = 'Наступні поля не були завершені і не повинні бути: %1$s';
$txt['error_missing_multi'] = '%1$s (принаймні %2$d повинен бути вибраний)';
$txt['error_no_dept'] = 'Ви не вибрали відділ, щоб опублікувати заявку.';
$txt['shd_cannot_move_dept'] = 'Ви не можете перемістити цей квиток, немає куди перемістити його.';
$txt['shd_no_perm_move_dept'] = 'Вам не дозволено перемістити цей квиток в інший відділ.';
$txt['cannot_shd_delete_attachment'] = 'Ви не маєте права видаляти вкладення.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Ви не можете перемістити цей тікет у тему; є спеціальні поля, які прикріплені адміністратором, щоб підтвердити цей рух.';
$txt['cannot_monitor_ticket'] = 'Вам не дозволено змінювати моніторинг за цим квитком.';
$txt['cannot_unmonitor_ticket'] = 'Вам не дозволено вимикати моніторинг за цим квитком.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Довідка'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Відділи'; // ditto
$txt['shd_new_ticket'] = 'Створити нову заявку';
$txt['shd_new_ticket_proxy'] = 'Проксі-запит на пост';
$txt['shd_helpdesk_profile'] = 'Профіль системи';
$txt['shd_welcome'] = 'Ласкаво просимо, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Перейти до тікету';
$txt['shd_options'] = 'Опції';
$txt['shd_search_menu'] = 'Пошук';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Інформація про нас';
$txt['shd_admin_options'] = 'Опції';
$txt['shd_admin_custom_fields'] = 'Індивідуальні поля';
$txt['shd_admin_departments'] = 'Відділи';
$txt['shd_admin_permissions'] = 'Дозволи';
$txt['shd_admin_plugins'] = 'Плагіни';
$txt['shd_admin_cannedreplies'] = 'Швидкі відповіді';
$txt['shd_admin_maint'] = 'Ремонт';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Тут ви можете створити нові квитки для співробітників сайту для дії, а також перевірити поточні тікети.';
$txt['shd_staff_greeting'] = 'Ось усі квитки, які потребують уваги.';
$txt['shd_shd_greeting'] = 'Це допоміжна система. Тут, ви витрачаєте час на допомогу новачків. Насолоджуйтесь! ;D';
$txt['shd_closed_user_greeting'] = 'Це всі закриті/вирішені заявки, що ви написали на Службі підтримки.';
$txt['shd_closed_staff_greeting'] = 'Це все закриті / вирішені заявки, подані на службу підтримки.';
$txt['shd_category_filter'] = 'Фільтрування категорії';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Ваш тікет був створений!';
$txt['shd_ticket_posted_body'] = 'Дякуємо за додання квитка, {membername}!' . "\n\n" . 'Співробітники служби підтримки переглянуть його і зв\'яжеться з вами якомога швидше.' . "\n\n" . 'Тим часом ви можете переглянути свій квиток, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; за наступним посиланням:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Відкрити іншу заявку[/iurl] | [iurl={helpdesklink}]Назад до основної служби підтримки[/iurl] | [iurl={forumlink}]Назад до форуму[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Ви можете увімкнути сповіщення по електронній пошті про зміни у вашому тікеті, в [iurl={prefslink}]Довідка налаштування[/iurl] області.';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'З повагою,' . "\n" . 'Команда {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Деталі заявки';
$txt['shd_ticket_updated'] = 'Оновлено';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Ім\'я';
$txt['shd_ticket_user'] = 'Користувач';
$txt['shd_ticket_date'] = 'Опубліковано';
$txt['shd_ticket_urgency'] = 'Настрій';
$txt['shd_ticket_assigned'] = 'Призначено';
$txt['shd_ticket_assignedto'] = 'Призначено';
$txt['shd_ticket_started_by'] = 'Розпочато';
$txt['shd_ticket_updated_by'] = 'Оновлено';
$txt['shd_ticket_status'] = 'Статус';
$txt['shd_ticket_num_replies'] = 'Відповіді';
$txt['shd_ticket_replies'] = 'Відповіді';
$txt['shd_ticket_staff'] = 'Співробітники';
$txt['shd_ticket_attachments'] = 'Вкладення';
$txt['shd_ticket_reply_number'] = 'Відповісти <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Утримування тікету';
$txt['shd_ticket'] = 'Квиток';
$txt['shd_reply_written'] = 'Відповідь написано %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Ніколи';
$txt['shd_linktree_tickets'] = 'Квитки';
$txt['shd_ticket_privacy'] = 'Конфіденційність';
$txt['shd_ticket_notprivate'] = 'Не приватно';
$txt['shd_ticket_private'] = 'Приватний';
$txt['shd_ticket_change'] = 'Змінити';
$txt['shd_ticket_ip'] = 'IP-адреса';
$txt['shd_back_to_hd'] = 'Повернутися до служби підтримки';
$txt['shd_go_to_replies'] = 'Перейти до відповідей';
$txt['shd_go_to_action_log'] = 'Перейти до журналу дій';
$txt['shd_go_to_replies_start'] = 'Перейти до першої відповіді';

$txt['shd_ticket_has_been_deleted'] = 'Цей тікет в даний час знаходиться в кошику і не може бути змінений без повернення на службу підтримки.';
$txt['shd_ticket_replies_deleted'] = 'Цей тікет був видалений з нього раніше.';
$txt['shd_ticket_replies_deleted_view'] = 'Ці результати відображаються кольоровим фоном. <a href="%1$s">Перегляньте квиток без видалення</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Будь ласка, <a href="%1$s">натисніть тут</a> , щоб переглянути їх.';

$txt['shd_ticket_notnew'] = 'Ви вже бачили це';
$txt['shd_ticket_new'] = 'Нове!';

$txt['shd_linktree_move_ticket'] = 'Перемістити квиток';
$txt['shd_linktree_move_topic'] = 'Перемістити тему в панель допомоги';

$txt['shd_cancel_ticket'] = 'Повернути та повернутися до тікету';
$txt['shd_cancel_home'] = 'Скасувати та повернутися до домашньої служби підтримки';
$txt['shd_cancel_topic'] = 'Відмінити й повернутися до теми';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Відповідь на квиток';
$txt['shd_ticket_quote'] = 'Відповісти з цитатою';
$txt['shd_go_advanced'] = 'Перейти вдосконалено!';
$txt['shd_ticket_edit_reply'] = 'Редагувати відповідь';
$txt['shd_ticket_quote_short'] = 'Цитувати';
$txt['shd_ticket_markunread'] = 'Позначити як непрочитане';
$txt['shd_ticket_reply_short'] = 'Відповідь';
$txt['shd_ticket_edit'] = 'Редагувати';
$txt['shd_ticket_resolved'] = 'Позначити вирішеним';
$txt['shd_ticket_unresolved'] = 'Позначити невирішеним';
$txt['shd_ticket_assign'] = 'Призначити';
$txt['shd_ticket_assign_self'] = 'Призначити мені';
$txt['shd_ticket_reassign'] = 'Повторне призначення';
$txt['shd_ticket_unassign'] = 'Скасувати призначення';
$txt['shd_ticket_delete'] = 'Видалити';
$txt['shd_delete_confirm'] = 'Ви впевнені, що хочете видалити цю заявку? У разі видалення, ця заявка буде переміщена до банка з переробки.';
$txt['shd_delete_reply_confirm'] = 'Ви впевнені, що хочете видалити цю відповідь? У разі видалення, ця відповідь буде перенесена в акаунт для переробки.';
$txt['shd_delete_attach_confirm'] = 'Ви впевнені, що хочете видалити це вкладення? (Це не можна скасувати!)';
$txt['shd_delete_attach'] = 'Видалити це вкладення';
$txt['shd_ticket_restore'] = 'Відновити';
$txt['shd_delete_permanently'] = 'Видалити назавжди';
$txt['shd_delete_permanently_confirm'] = 'Ви впевнені, що хочете остаточно видалити цей тікет? Це не можна скасувати!';
$txt['shd_ticket_move_to_topic'] = 'Перейти до теми';
$txt['shd_move_dept'] = 'Перемістити донизу.';
$txt['shd_actions'] = 'Дії';
$txt['shd_back_to_ticket'] = 'Повернутися до цього тікету після додавання';
$txt['shd_disable_smileys_post'] = 'Вимкнути смайли в цьому повідомленні';
$txt['shd_resolve_this_ticket'] = 'Позначити цей тікет як вирішений';
$txt['shd_override_cf'] = 'Перекриття вимог настроюваних полів';
$txt['shd_silent_update'] = 'Без звукового оновлення (немає сповіщень)';
$txt['shd_select_notifications'] = 'Виберіть людей, щоб повідомити про цю відповідь...';

$txt['shd_ticket_assign_ticket'] = 'Призначити тікет';
$txt['shd_ticket_assign_to'] = 'Призначити тікет';

$txt['shd_ticket_move_dept'] = 'Перемістити квиток до іншого відділу';
$txt['shd_ticket_move_to'] = 'Перейти до';
$txt['shd_current_dept'] = 'Зараз у відділі';
$txt['shd_ticket_move'] = 'Перемістити тікет';
$txt['shd_unknown_dept'] = 'Вказаний відділ не існує.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Нова тема';
$txt['shd_move_ticket_to_topic'] = 'Перемістити тікет у тему';
$txt['shd_move_ticket'] = 'Перемістити квиток';
$txt['shd_ticket_board'] = 'Дошка';
$txt['shd_change_ticket_subject'] = 'Змінити тему тікету';
$txt['shd_move_send_pm'] = 'Відправити ПП власнику квитка';
$txt['shd_move_why'] = 'Будь ласка, введіть короткий опис того, чому ця заявка переміщується в тему форуму.';
$txt['shd_ticket_moved_subject'] = 'Ваш тікет був переміщений.';
$txt['shd_move_default'] = 'Доброго дня, {user},' . "\n\n" . 'Ваш квиток {subject}було переміщено з столу допомоги до теми на форумі.' . "\n" . 'Ваш квиток ви можете знайти на платі {board} або за цим посиланням:' . "\n\n" . '{link}' . "\n\n" . 'Подяка';

$txt['shd_move_topic_to_ticket'] = 'Перемістити тему в панель допомоги';
$txt['shd_move_topic'] = 'Перемістити топік';
$txt['shd_change_topic_subject'] = 'Змінити тему';
$txt['shd_move_send_pm_topic'] = 'Відправити ПП для початку теми';
$txt['shd_move_why_topic'] = 'Будь ласка, введіть короткий опис до того, чому ця тема буде перенесена в службу підтримки. ';
$txt['shd_ticket_moved_subject_topic'] = 'Ваша тема була переміщена.';
$txt['shd_move_default_topic'] = 'Доброго дня, {user},' . "\n\n" . 'Your topic, {subject}, has been moved from the forum to the Helpdesk section.' . "\n" . 'Ви можете знайти вашу тему за цим посиланням:' . "\n\n" . '{link}' . "\n\n" . 'Подяка';

$txt['shd_user_no_hd_access'] = 'Примітка: людина, яка запустила цю тему, не може побачити систему підтримки!';
$txt['shd_user_helpdesk_access'] = 'Той, хто створив цю тему, може побачити службу підтримки.';
$txt['shd_user_hd_access_dept_1'] = 'Той, хто розпочав цю тему, може побачити наступний відділ: ';
$txt['shd_user_hd_access_dept'] = 'Особа, яка розпочала цю тему, може побачити наступні відділи: ';
$txt['shd_move_ticket_department'] = 'Перемістити квиток в який відділ';
$txt['shd_move_dept_why'] = 'Будь ласка, введіть короткий опис того, як цей квиток буде перенесено в інший відділ.';
$txt['shd_move_dept_default'] = 'Доброго дня, {user},' . "\n\n" . 'Ваш квиток {subject}, перенесений з відділу {current_dept} в відділ {new_dept}.' . "\n" . 'Ви можете знайти ваш квиток за цим посиланням:' . "\n\n" . '{link}' . "\n\n" . 'Подяка';

$txt['shd_ticket_move_deleted'] = 'Цей тікет має відповіді, які знаходяться в даний час в кошику. Що ви хочете зробити?';
$txt['shd_ticket_move_deleted_abort'] = 'Аборт - візьміть мене в корзину для смітника';
$txt['shd_ticket_move_deleted_delete'] = 'Продовжуйте, відмовитись від видалених відповідей (не переміщуйте їх в нову тему)';
$txt['shd_ticket_move_deleted_undelete'] = 'Продовжувати скасування видалення відповідей (перемістити їх в нову тему)';

$txt['shd_ticket_move_cfs'] = 'Цей тікет має індивідуальні поля, які можуть бути переміщені.';
$txt['shd_ticket_move_cfs_warn'] = 'Деякі з цих полів можуть бути видимі іншим користувачам. Ці поля вказані за допомогою позначки оклику.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Ви можете побачити це поле, інші користувачі не зможуть - але як тільки воно стане частиною форуму, буде видимим для всіх, хто має доступ до форуму.';
$txt['shd_ticket_move_cfs_purge'] = 'Видалити вміст поля';
$txt['shd_ticket_move_cfs_embed'] = 'Тримайте поле і розмістіть його в новій темі';
$txt['shd_ticket_move_cfs_user'] = 'На даний момент видимі для звичайних користувачів';
$txt['shd_ticket_move_cfs_staff'] = 'На даний момент учасники співробітника бачать';
$txt['shd_ticket_move_cfs_admin'] = 'На даний момент відображається адміністраторам';
$txt['shd_ticket_move_accept'] = 'Я погоджуюсь, що деякі поля, якими маніпулюють тут, не відображаються для всіх користувачів, і щоб ця тема була переміщена в форум, з вищевказаними налаштуваннями.';
$txt['shd_ticket_move_reqd'] = 'Ця опція повинна бути обрана для того, щоб перемістити цей тікет у форум.';
$txt['shd_ticket_move_ok'] = 'Це поле безпечне для переміщення, всі користувачі, що бачать квиток можуть бачити це поле, немає ніякої інформації, прихованої від користувачів або співробітників.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Для цього тікету необхідно заповнити поля, які користувачі і співробітники не можуть бачити такі, як вам, спеціально потрібно підтвердити, що ви це знаєте - будь ласка, поверніться на попередню сторінку, чекбокс для підтвердження вашого усвідомлення цієї форми знаходиться в нижній частині форми.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Смітник';
$txt['shd_recycle_greeting'] = 'Це заборона на переробки. Усі видалені квитки заходять сюди, але співробітники з спеціальними правами можуть видаляти квитки назавжди.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Створити тікет';
$txt['shd_edit_ticket'] = 'Редагувати тікет';
$txt['shd_edit_ticket_linktree'] = 'Редагувати тікет (%s)';
$txt['shd_ticket_subject'] = 'Тема тікету';
$txt['shd_ticket_proxy'] = 'Повідомлення від імені';
$txt['shd_ticket_post_error'] = 'Наведена нижче проблема або проблеми при спробі опублікувати цей тікет';
$txt['shd_reply_ticket'] = 'Відповідь на квиток';
$txt['shd_reply_ticket_linktree'] = 'Відповісти на квиток (%s)';
$txt['shd_edit_reply_linktree'] = 'Редагувати відповідь (%s)';
$txt['shd_previewing_ticket'] = 'Попередній перегляд тікету';
$txt['shd_previewing_reply'] = 'Попередній перегляд відповіді до';
$txt['shd_choose_one'] = '[Оберіть один]';
$txt['shd_no_value'] = '[немає значення]';
$txt['shd_ticket_dept'] = 'Відділ тікету';
$txt['shd_select_dept'] = '-- Оберіть відділ --';
$txt['canned_replies'] = 'Додати попередньо визначену відповідь:';
$txt['canned_replies_select'] = '-- Виберіть відповідь --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Відповіді в Службі підтримки розміщені з IP (діапазон)';
$txt['shd_no_replies_from_ip'] = 'Не знайдено відповідей на служби підтримки із заданого IP (діапазон)';
$txt['shd_replies_from_ip_desc'] = 'Нижче наведено список всіх повідомлень, розміщених на дошці допомоги з цього IP (діапазон).';
$txt['shd_is_ticket_opener'] = ' (початковий квитк)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'Архів BZip2';
$txt['shd_attachtype_gz'] = 'Архів GZip';
$txt['shd_attachtype_rar'] = 'Архів WinRAR';
$txt['shd_attachtype_zip'] = 'Архів Zip';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) аудіо файл';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Растрове зображення Windows';
$txt['shd_attachtype_gif'] = 'Формат графіки Interchange (GIF) зображення';
$txt['shd_attachtype_jpeg'] = 'Спільна група фотоекспертів (JPEG)';
$txt['shd_attachtype_jpg'] = 'Спільна група фотоекспертів (JPEG)';
$txt['shd_attachtype_png'] = 'Портативний графік мережі (PNG) зображення';
$txt['shd_attachtype_svg'] = 'Масштабована векторна графіка (SVG) зображення';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Фільм для Windows Media відео';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Word документ';
$txt['shd_attachtype_mdb'] = 'Microsoft Access база даних';
$txt['shd_attachtype_ppt'] = 'Презентація Microsoft Powerpoint';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ вихідний файл';
$txt['shd_attachtype_php'] = 'Скрипт PHP';
$txt['shd_attachtype_py'] = 'Вихідний файл Python';
$txt['shd_attachtype_rb'] = 'Вихідний файл Ruby';
$txt['shd_attachtype_sql'] = 'Скрипт SQL';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KML архів)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat портативний файл документа';
$txt['shd_attachtype_psd'] = 'Саманний документ Photoshop';
$txt['shd_attachtype_swf'] = 'Adobe Flash файл';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Виконуваний файл (Windows)';
$txt['shd_attachtype_htm'] = 'Документ розмітки Hypertext (HTML)';
$txt['shd_attachtype_html'] = 'Документ розмітки Hypertext (HTML)';
$txt['shd_attachtype_rtf'] = 'Розширений текстовий формат (RTF)';
$txt['shd_attachtype_txt'] = 'Простий текст';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Журнал дій тікета';
$txt['shd_ticket_log_count_one'] = '1 запис';
$txt['shd_ticket_log_count_more'] = '%s записів';
$txt['shd_ticket_log_none'] = 'Цей тікет не мав жодних змін.';
$txt['shd_ticket_log_member'] = 'Гравець';
$txt['shd_ticket_log_ip'] = 'IP учасника:';
$txt['shd_ticket_log_date'] = 'Дата';
$txt['shd_ticket_log_action'] = 'Дія';
$txt['shd_ticket_log_full'] = 'Перейти до повного журналу дій (Усі квитки)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Пов\'язані Заявки';
$txt['shd_ticket_create_relationship'] = 'Створити зв\'язок';
$txt['shd_ticket_delete_relationship'] = 'Видалити зв’язок';
$txt['shd_ticket_reltype'] = 'вибрати тип';
$txt['shd_ticket_reltype_linked'] = 'Пов\'язано з';
$txt['shd_ticket_reltype_duplicated'] = 'Дублює';
$txt['shd_ticket_reltype_parent'] = 'Батько';
$txt['shd_ticket_reltype_child'] = 'Нащадок';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Додаткова інформація';
$txt['shd_ticket_additional_details'] = 'Додаткова інформація';
$txt['shd_ticket_empty_field'] = 'Дане поле пусте.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Сповіщення';
$txt['shd_ticket_notify_noneprefs'] = 'Ваші налаштування не зареєстровані для сповіщення про цей тікет.';
$txt['shd_ticket_notify_changeprefs'] = 'Змінити налаштування';
$txt['shd_ticket_notify_because'] = 'Ваші налаштування вказують на повідомлення про вас у цьому тікеті:';
$txt['shd_ticket_notify_because_yourticket'] = 'як це Ваш квиток';
$txt['shd_ticket_notify_because_assignedyou'] = 'як він призначений вам';
$txt['shd_ticket_notify_because_priorreply'] = 'як ви відповіли на це перед';
$txt['shd_ticket_notify_because_anyreply'] = 'для будь-якого тікету';

$txt['shd_ticket_notify_me_always'] = 'Ви відстежуєте цей тікет (і ви отримаєте повідомлення про кожну відповідь)';
$txt['shd_ticket_monitor_on_note'] = 'Ви можете відслідковувати всі відповіді на цей запит електронною поштою незалежно від ваших налаштувань:';
$txt['shd_ticket_monitor_off_note'] = 'Ви можете вимкнути моніторинг для цієї заявки та використовувати всі ваші налаштування:';
$txt['shd_ticket_monitor_on'] = 'Увімкнути моніторинг';
$txt['shd_ticket_monitor_off'] = 'Вимкнути моніторинг';
$txt['shd_ticket_notify_me_never_note'] = 'Ви можете ігнорувати оновлення електронної пошти цього тікета, незалежно від ваших налаштувань:';
$txt['shd_ticket_notify_me_never'] = 'Ви вимкнули всі сповіщення для цього тікета.';
$txt['shd_ticket_notify_me_never_on'] = 'Вимкнути сповіщення';
$txt['shd_ticket_notify_me_never_off'] = 'Увімкнути сповіщення';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Пошукова станція може не перераховувати всі доступні заявки; її зараз досліджують.';
$txt['shd_search_warning_admin'] = 'Пошукова служба вимагає перебудовування його індексу. Ви можете досягти цього за допомогою функції обслуговування, в області служби підтримки, на панелі адміністратора.';
$txt['shd_search'] = 'Пошук завданнь';
$txt['shd_search_results'] = 'Заявки для пошуку - Результати';
$txt['shd_search_text'] = 'Слова, що ви шукаєте:';
$txt['shd_search_match'] = 'Що слід збігати?';
$txt['shd_search_match_all'] = 'Встановлений відповідність між усіма словами';
$txt['shd_search_match_any'] = 'Встановлений збіг будь-яких слів';
$txt['shd_search_scope'] = 'Включає які типи заявок:';
$txt['shd_search_scope_open'] = 'Відкриті Заявки';
$txt['shd_search_scope_closed'] = 'Закриті тікети';
$txt['shd_search_scope_recycle'] = 'Речі в Кошику';
$txt['shd_search_result_ticket'] = 'Заявка %1$s';
$txt['shd_search_result_reply'] = 'Відповісти на заявку %1$s';
$txt['shd_search_last_updated'] = 'Останнє оновлення:';
$txt['shd_search_ticket_opened_by'] = 'Тікет відкрито:';
$txt['shd_search_ticket_replied_by'] = 'Тікет відповів на відповідь:';
$txt['shd_search_dept'] = 'Пошук в яких відділах:';

$txt['shd_search_urgency'] = 'Включає, які рівні актуальності:';

$txt['shd_search_where'] = 'Які елементи для пошуку:';
$txt['shd_search_where_tickets'] = 'Тіла квитків';
$txt['shd_search_where_replies'] = 'Відповіді у квитках';
$txt['shd_search_where_subjects'] = 'Тема тікету';

$txt['shd_search_ticket_starter'] = 'Квитки почали:';
$txt['shd_search_ticket_assignee'] = 'Заявки призначені до:';
$txt['shd_search_ticket_named_person'] = 'Введіть ім\'я користувача(ів), що вас цікавлять.';

$txt['shd_search_no_results'] = 'Нічого не знайдено за вказаними критеріями. Можна змінити критерії пошуку.';
$txt['shd_search_criteria'] = 'Шукати Критерію:';
$txt['shd_search_excluded'] = 'Якщо було обрано кожен можливий варіант, то він не був включений в вищезгаданий (напр. якщо всі можливі рівні терміновості були відмічені, вона не зазначається вище, так що ви можете сконцентруватися на тому, що характерно для вашого пошуку)';
//@}