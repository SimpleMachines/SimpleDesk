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
$txt['shd_helpdesk'] = 'Служба поддержки';
$txt['shd_helpdesk_maintenance'] = 'В настоящее время служба поддержки <strong>в режиме обслуживания</strong>. Только администраторы форумов и службы поддержки могут видеть это.';
$txt['shd_open_ticket'] = 'открыть заявку';
$txt['shd_open_tickets'] = 'открытые заявки';
$txt['shd_none'] = 'Нет';

$txt['shd_display_nojs'] = 'JavaScript не включен в вашем браузере. Некоторые функции могут работать неправильно (или вообще), или вести себя непредвиденно.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Добро пожаловать в главный административный центр службы поддержки!';
$txt['shd_admin_title'] = 'Центр администрирования Helpdesk';
$txt['shd_staff_list'] = 'Сотрудники службы поддержки';
$txt['shd_update_available'] = 'Доступна новая версия!';
$txt['shd_update_message'] = 'Выпущена новая версия SimpleDesk. Мы рекомендовали вам <a href="#" id="update-link">обновить приложение до последней версии</a> , чтобы оставаться в безопасности и наслаждаться всеми возможностями, которые могут предложить наша модификация.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Для получения дополнительной информации о новом релизе посетите <a href="#" id="information-link" target="_blank">наш веб-сайт</a>.</span><br>' . "\n\n" . '<strong>Команда SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Низкий';
$txt['shd_urgency_1'] = 'Средний';
$txt['shd_urgency_2'] = 'Высокий';
$txt['shd_urgency_3'] = 'Очень высокий';
$txt['shd_urgency_4'] = 'Серьезный';
$txt['shd_urgency_5'] = 'Критический';
$txt['shd_urgency_increase'] = 'Увеличить';
$txt['shd_urgency_decrease'] = 'Уменьшить';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Новый';
$txt['shd_status_1'] = 'Комментарии персонала в ожидании';
$txt['shd_status_2'] = 'Комментарий пользователя в ожидании';
$txt['shd_status_3'] = 'Разрешено/Закрыто';
$txt['shd_status_4'] = 'Рекомендуется руководителю';
$txt['shd_status_5'] = 'Эскалация - Срочно';
$txt['shd_status_6'] = 'Удалено';
$txt['shd_status_7'] = 'На удержании';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Новые Заявки';
$txt['shd_status_1_heading'] = 'Заявки ожидающие ответа сотрудника';
$txt['shd_status_2_heading'] = 'Заявки, ожидающие ответа пользователя';
$txt['shd_status_3_heading'] = 'Закрытые Заявки';
$txt['shd_status_4_heading'] = 'Заявки, отобранные руководителю';
$txt['shd_status_5_heading'] = 'Срочные Заявки';
$txt['shd_status_6_heading'] = 'Переработанные билеты';
$txt['shd_status_7_heading'] = 'На удержании Заявок';
$txt['shd_status_assigned_heading'] = 'Назначено мне';
$txt['shd_status_withdeleted_heading'] = 'Заявки с удалёнными ответами';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Открытые Заявки';
$txt['shd_tickets_closed'] = 'Закрытые Заявки';
$txt['shd_tickets_recycled'] = 'Переработанные билеты';

$txt['shd_assigned'] = 'Назначено';
$txt['shd_unassigned'] = 'Не назначено';

$txt['shd_read_ticket'] = 'Читать тикет';
$txt['shd_unread_ticket'] = 'Непрочитанный тикет';
$txt['shd_unread_tickets'] = 'Непрочитанные Заявки';

$txt['shd_owned'] = 'Собственный тикет'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'тикет';
$txt['shd_count_tickets'] = 'билеты';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'У вас нет доступа к службе поддержки.';
$txt['shd_no_ticket'] = 'Запрошенная заявка не существует.';
$txt['shd_no_reply'] = 'Ответ на запрос, который вы запрашиваете, не существует или не является частью этой заявки.';
$txt['shd_no_topic'] = 'Запрошенная вами тема не существует.';
$txt['shd_ticket_no_perms'] = 'У вас нет прав на просмотр этой заявки.';
$txt['shd_error_no_tickets'] = 'Заявки не найдены.';
$txt['shd_inactive'] = 'Система службы поддержки в настоящее время отключена.';
$txt['shd_cannot_assign'] = 'Вам не разрешается назначать тикеты.';
$txt['shd_cannot_assign_other'] = 'Эта заявка уже назначена другому пользователю. Вы не можете переназначить ее самому себе, обратитесь к администратору.';
$txt['shd_no_staff_assign'] = 'Нет настроенных сотрудников; невозможно назначить заявку. Обратитесь к администратору.';
$txt['shd_assigned_not_permitted'] = 'Пользователь, который вы запросили назначить эту заявку, не имеет достаточных прав для ее просмотра.';
$txt['shd_cannot_resolve'] = 'У вас нет прав отмечать эту заявку как решенную.';
$txt['shd_cannot_unresolve'] = 'У вас недостаточно прав для повторного открытия разрешенной заявки.';
$txt['error_shd_cannot_resolve_children'] = 'Эта заявка в настоящее время не может быть закрыта. Эта заявка является родителем одной или нескольких открытых заявок.';
$txt['error_shd_proxy_unknown'] = 'Пользователь этого тикета размещен от имени не существует.';
$txt['shd_cannot_change_privacy'] = 'У вас нет разрешения на изменение конфиденциальности этой Заявки.';
$txt['shd_cannot_change_urgency'] = 'У вас нет разрешения на изменение срочности этой заявки.';
$txt['shd_ajax_problem'] = 'Возникла проблема при загрузке страницы. Попробовать еще раз?';
$txt['shd_cannot_move_ticket'] = 'У вас нет прав на перемещение этой заявки в тему.';
$txt['shd_cannot_move_topic'] = 'У вас недостаточно прав для перемещения этой темы в Заявку.';
$txt['shd_moveticket_noboards'] = 'Нет досок для перемещения этой заявки!';
$txt['shd_move_no_pm'] = 'Вы должны ввести причину перемещения заявки для отправки владельцу заявки, или снимите флажок с опции \'Отправить сообщение владельцу заявки\'.';
$txt['shd_move_no_pm_topic'] = 'Вы должны ввести причину переноса темы для начала темы, или снимите флажок с опции \'Отправить сообщение началу темы\'.';
$txt['shd_move_topic_not_created'] = 'Не удалось переместить заявку на форум. Пожалуйста, попробуйте еще раз.';
$txt['shd_move_ticket_not_created'] = 'Не удалось переместить тему в службу поддержки. Пожалуйста, попробуйте еще раз.';
$txt['shd_no_replies'] = 'В этой заявке пока нет ответов.';
$txt['cannot_shd_new_ticket'] = 'У вас нет прав на создание новой Заявки.';
$txt['cannot_shd_edit_ticket'] = 'У вас недостаточно прав для редактирования этой заявки.';
$txt['shd_cannot_reply_any'] = 'У вас недостаточно прав для ответа на любые заявки.';
$txt['shd_cannot_reply_any_but_own'] = 'У вас нет прав отвечать на любые заявки, отличные от ваших.';
$txt['shd_cannot_edit_reply_any'] = 'У вас нет прав на редактирование ответов.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'У вас нет прав редактировать ответы на заявки, отличные от ваших собственных ответов.';
$txt['shd_cannot_edit_closed'] = 'Вы не можете редактировать разрешенные заявки. Сначала отметьте ее неразрешенной.';
$txt['shd_cannot_edit_deleted'] = 'Вы не можете редактировать заявки в корзине. Сначала они должны быть восстановлены.';
$txt['shd_cannot_reply_closed'] = 'Вы не можете ответить на решенные заявки, необходимо отметить их нерешенными сначала.';
$txt['shd_cannot_reply_deleted'] = 'Вы не можете ответить на заявки в корзине. Сначала они должны быть восстановлены.';
$txt['shd_cannot_delete_ticket'] = 'Вам не разрешено удалять заявку.';
$txt['shd_cannot_delete_reply'] = 'Вам не разрешено удалять этот ответ.';
$txt['shd_cannot_restore_ticket'] = 'Вы не можете восстановить эту заявку из корзины.';
$txt['shd_cannot_restore_reply'] = 'Вы не можете восстановить этот ответ из корзины.';
$txt['shd_cannot_view_resolved'] = 'У вас нет прав на доступ к разрешенным заявкам.';
$txt['cannot_shd_access_recyclebin'] = 'Вы не можете получить доступ к корзине.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Вы не можете переместить эту заявку на форум; есть один или несколько удаленных ответов, к которым ваши текущие права доступа не разрешены.';
$txt['shd_cannot_attach_ext'] = 'Тип файла, который вы пытаетесь прикрепить ({ext}) не допускается. Разрешенные типы файлов: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Эта заявка в настоящее время недоступна для изменения.';
$txt['shd_invalid_relation'] = 'Вы должны указать допустимый тип отношений для этих Заявок.';
$txt['shd_no_relation_delete'] = 'Нельзя удалить отношение, которое не существует.';
$txt['shd_cannot_relate_self'] = 'Вы не можете сделать тикет, связанный с самим собой.';
$txt['shd_relationships_are_disabled'] = 'Отношения с заявками в настоящее время отключены.';
$txt['error_invalid_fields'] = 'Следующие поля имеют значения, которые не могут быть использованы: %1$s';
$txt['error_missing_fields'] = 'Следующие поля не были заполнены и должны быть: %1$s';
$txt['error_missing_multi'] = '%1$s (по крайней мере %2$d должно быть выбрано)';
$txt['error_no_dept'] = 'Вы не выбрали департамент для публикации этой заявки.';
$txt['shd_cannot_move_dept'] = 'Вы не можете переместить эту заявку, нет места для ее перемещения.';
$txt['shd_no_perm_move_dept'] = 'Вы не можете переместить эту заявку в другой отдел.';
$txt['cannot_shd_delete_attachment'] = 'Вам не разрешено удалять вложения.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Вы не можете переместить Заявку в тему; есть настраиваемые поля, которые требуют от администратора подтверждения перемещения.';
$txt['cannot_monitor_ticket'] = 'Вам не разрешено включать мониторинг для этого тикета.';
$txt['cannot_unmonitor_ticket'] = 'Вам не разрешено отключать мониторинг для этой заявки.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Служба поддержки'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Отделы'; // ditto
$txt['shd_new_ticket'] = 'Отправить Новую Заявку';
$txt['shd_new_ticket_proxy'] = 'Заявка на пост прокси';
$txt['shd_helpdesk_profile'] = 'Профиль службы поддержки';
$txt['shd_welcome'] = 'Добро пожаловать, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Перейти к заявке';
$txt['shd_options'] = 'Варианты';
$txt['shd_search_menu'] = 'Искать';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Информация';
$txt['shd_admin_options'] = 'Варианты';
$txt['shd_admin_custom_fields'] = 'Пользовательские поля';
$txt['shd_admin_departments'] = 'Отделы';
$txt['shd_admin_permissions'] = 'Права доступа';
$txt['shd_admin_plugins'] = 'Плагины';
$txt['shd_admin_cannedreplies'] = 'Шаблонные ответы';
$txt['shd_admin_maint'] = 'Техническое обслуживание';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Здесь вы можете отправить новые билеты сотрудникам сайта на действие, а также проверить текущие билеты.';
$txt['shd_staff_greeting'] = 'Вот все заявки, которые требуют внимания.';
$txt['shd_shd_greeting'] = 'Это Helpdesk. Здесь вы тратите время на помощь новичкам. Наслаждайтесь! ;D';
$txt['shd_closed_user_greeting'] = 'Это все закрытые/решенные вами заявки, которые вы отправили в службу поддержки.';
$txt['shd_closed_staff_greeting'] = 'Все закрытые/закрытые заявки отправлены в службу поддержки.';
$txt['shd_category_filter'] = 'Фильтрация категорий';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Ваша заявка была создана!';
$txt['shd_ticket_posted_body'] = 'Благодарим вас за отправку билета, {membername}!' . "\n\n" . 'Сотрудники службы поддержки рассмотрят его и свяжутся с вами как можно скорее.' . "\n\n" . 'Между тем вы можете просмотреть вашу заявку, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; по следующему URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Открыть другую заявку[/iurl] | [iurl={helpdesklink}]Назад к основной службе поддержки[/iurl] | [iurl={forumlink}]Вернуться к форуму[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Вы можете включить уведомления об изменениях в заявке по электронной почте в разделе [iurl={prefslink}]Настройки Справочника[/iurl].';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'С уважением,' . "\n" . 'Команда {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Детали заявки';
$txt['shd_ticket_updated'] = 'Обновлено';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Наименование';
$txt['shd_ticket_user'] = 'Пользователь';
$txt['shd_ticket_date'] = 'Опубликовано';
$txt['shd_ticket_urgency'] = 'Срочность';
$txt['shd_ticket_assigned'] = 'Назначено';
$txt['shd_ticket_assignedto'] = 'Назначено';
$txt['shd_ticket_started_by'] = 'Запущено';
$txt['shd_ticket_updated_by'] = 'Обновлено';
$txt['shd_ticket_status'] = 'Статус';
$txt['shd_ticket_num_replies'] = 'Ответы';
$txt['shd_ticket_replies'] = 'Ответы';
$txt['shd_ticket_staff'] = 'Сотрудник сотрудника';
$txt['shd_ticket_attachments'] = 'Вложения';
$txt['shd_ticket_reply_number'] = 'Ответ <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Заявка на сайте';
$txt['shd_ticket'] = 'Билет';
$txt['shd_reply_written'] = 'Ответ записан %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Никогда';
$txt['shd_linktree_tickets'] = 'Заявки';
$txt['shd_ticket_privacy'] = 'Приватность';
$txt['shd_ticket_notprivate'] = 'Не приватный';
$txt['shd_ticket_private'] = 'Приватный';
$txt['shd_ticket_change'] = 'Изменить';
$txt['shd_ticket_ip'] = 'IP-адрес';
$txt['shd_back_to_hd'] = 'Вернуться в службу поддержки';
$txt['shd_go_to_replies'] = 'Перейти к ответам';
$txt['shd_go_to_action_log'] = 'Перейти к журналу действий';
$txt['shd_go_to_replies_start'] = 'Перейти к первому ответу';

$txt['shd_ticket_has_been_deleted'] = 'Эта заявка находится в корзине и не может быть изменена без возврата в службу поддержки.';
$txt['shd_ticket_replies_deleted'] = 'Ранее в этой заявке были удалены ответы.';
$txt['shd_ticket_replies_deleted_view'] = 'Они отображаются в цветном фоне. <a href="%1$s">Просмотр заявки без удаления</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Пожалуйста, <a href="%1$s">нажмите здесь</a> для их просмотра.';

$txt['shd_ticket_notnew'] = 'Вы уже видели это';
$txt['shd_ticket_new'] = 'Новый!';

$txt['shd_linktree_move_ticket'] = 'Переместить заявку';
$txt['shd_linktree_move_topic'] = 'Переместить тему в службу поддержки';

$txt['shd_cancel_ticket'] = 'Отменить и вернуться к заявке';
$txt['shd_cancel_home'] = 'Отменить и вернуться в службу поддержки';
$txt['shd_cancel_topic'] = 'Отменить и вернуться к теме';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Ответить на заявку';
$txt['shd_ticket_quote'] = 'Ответить с цитатой';
$txt['shd_go_advanced'] = 'Вперёд!';
$txt['shd_ticket_edit_reply'] = 'Изменить ответ';
$txt['shd_ticket_quote_short'] = 'Цитата';
$txt['shd_ticket_markunread'] = 'Пометить непрочитанным';
$txt['shd_ticket_reply_short'] = 'Ответ';
$txt['shd_ticket_edit'] = 'Редактирование';
$txt['shd_ticket_resolved'] = 'Отметка решена';
$txt['shd_ticket_unresolved'] = 'Отметить неразрешенным';
$txt['shd_ticket_assign'] = 'Назначить';
$txt['shd_ticket_assign_self'] = 'Назначить мне';
$txt['shd_ticket_reassign'] = 'Назначить повторно';
$txt['shd_ticket_unassign'] = 'Отменить назначение';
$txt['shd_ticket_delete'] = 'Удалить';
$txt['shd_delete_confirm'] = 'Вы уверены, что хотите удалить эту заявку? Если эта заявка будет удалена, она будет перемещена в корзину.';
$txt['shd_delete_reply_confirm'] = 'Вы уверены, что хотите удалить этот ответ? Если этот ответ будет удален, он будет перемещен в корзину для рециркуляции.';
$txt['shd_delete_attach_confirm'] = 'Вы уверены, что хотите удалить это вложение? (Это действие нельзя отменить!)';
$txt['shd_delete_attach'] = 'Удалить это вложение';
$txt['shd_ticket_restore'] = 'Восстановить';
$txt['shd_delete_permanently'] = 'Удалить навсегда';
$txt['shd_delete_permanently_confirm'] = 'Вы уверены, что хотите навсегда удалить эту заявку? Это НЕВОЗМОЖНО будет отменено!';
$txt['shd_ticket_move_to_topic'] = 'Переместить в тему';
$txt['shd_move_dept'] = 'Двигать глубину.';
$txt['shd_actions'] = 'Действия';
$txt['shd_back_to_ticket'] = 'Вернуться к этой заявке после публикации';
$txt['shd_disable_smileys_post'] = 'Выключить смайлы в этом сообщении';
$txt['shd_resolve_this_ticket'] = 'Отметить этот тикет как разрешенный';
$txt['shd_override_cf'] = 'Переопределить требования к пользовательским полям';
$txt['shd_silent_update'] = 'Бесшумное обновление (не отправлять уведомления)';
$txt['shd_select_notifications'] = 'Выберите людей для уведомления об этом ответе...';

$txt['shd_ticket_assign_ticket'] = 'Назначить заявку';
$txt['shd_ticket_assign_to'] = 'Назначить заявку на';

$txt['shd_ticket_move_dept'] = 'Переместить Заявку в другой отдел';
$txt['shd_ticket_move_to'] = 'Переместить в';
$txt['shd_current_dept'] = 'В настоящее время в отделе';
$txt['shd_ticket_move'] = 'Переместить тикет';
$txt['shd_unknown_dept'] = 'Указанный отдел не существует.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Новая тема';
$txt['shd_move_ticket_to_topic'] = 'Переместить заявку в тему';
$txt['shd_move_ticket'] = 'Переместить заявку';
$txt['shd_ticket_board'] = 'Доска';
$txt['shd_change_ticket_subject'] = 'Изменить тему заявки';
$txt['shd_move_send_pm'] = 'Отправить сообщение владельцу заявки';
$txt['shd_move_why'] = 'Пожалуйста, введите краткое описание того, почему эта заявка перемещается в тему форума.';
$txt['shd_ticket_moved_subject'] = 'Ваша заявка была перемещена.';
$txt['shd_move_default'] = 'Здравствуйте, {user},' . "\n\n" . 'Ваша заявка, {subject}, была перемещена из службы поддержки в тему на форуме.' . "\n" . 'Вы можете найти вашу заявку на форуме {board} или по этой ссылке:' . "\n\n" . '{link}' . "\n\n" . 'Спасибо';

$txt['shd_move_topic_to_ticket'] = 'Переместить тему в службу поддержки';
$txt['shd_move_topic'] = 'Переместить тему';
$txt['shd_change_topic_subject'] = 'Изменить тему темы';
$txt['shd_move_send_pm_topic'] = 'Отправить ЛС к началу темы';
$txt['shd_move_why_topic'] = 'Пожалуйста, введите краткое описание того, почему эта тема перемещается в службу поддержки. ';
$txt['shd_ticket_moved_subject_topic'] = 'Ваша тема была перемещена.';
$txt['shd_move_default_topic'] = 'Здравствуйте, {user},' . "\n\n" . 'Ваша тема, {subject}, была перенесена из форума в раздел "Справка".' . "\n" . 'Вы можете найти свою тему по этой ссылке:' . "\n\n" . '{link}' . "\n\n" . 'Спасибо';

$txt['shd_user_no_hd_access'] = 'Примечание: человек, который начал эту тему, не может видеть службу поддержки!';
$txt['shd_user_helpdesk_access'] = 'Человек, который начал эту тему, может видеть службу поддержки.';
$txt['shd_user_hd_access_dept_1'] = 'Лицо, создавшее эту тему, может видеть следующий департамент: ';
$txt['shd_user_hd_access_dept'] = 'Лицо, создавшее эту тему, может видеть следующие отделы: ';
$txt['shd_move_ticket_department'] = 'Переместить в какой департамент';
$txt['shd_move_dept_why'] = 'Пожалуйста, введите краткое описание того, почему эта заявка перемещается в другой отдел.';
$txt['shd_move_dept_default'] = 'Здравствуйте, {user},' . "\n\n" . 'Ваша заявка, {subject}, была перемещена из отдела {current_dept} в отдел {new_dept}.' . "\n" . 'Вы можете найти вашу заявку по этой ссылке:' . "\n\n" . '{link}' . "\n\n" . 'Спасибо';

$txt['shd_ticket_move_deleted'] = 'В этой заявке есть ответы, которые в настоящее время находятся в корзине. Что вы хотите сделать?';
$txt['shd_ticket_move_deleted_abort'] = 'Прервать, перейти в корзину';
$txt['shd_ticket_move_deleted_delete'] = 'Продолжить, отказаться от удаленных ответов (не перемещать их в новую тему)';
$txt['shd_ticket_move_deleted_undelete'] = 'Продолжить, восстановить ответы (переместить их в новую тему)';

$txt['shd_ticket_move_cfs'] = 'Эта заявка содержит настраиваемые поля, которые могут быть перемещены.';
$txt['shd_ticket_move_cfs_warn'] = 'Некоторые из этих полей могут не быть видны другим пользователям. Эти поля обозначены восклицательным знаком.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Вы можете увидеть это поле, другие пользователи не могут - но после того, как они станут частью форума, он будет виден всем, кто может получить доступ к форуму.';
$txt['shd_ticket_move_cfs_purge'] = 'Удалить содержимое поля';
$txt['shd_ticket_move_cfs_embed'] = 'Сохранить поле и поместить его в новую тему';
$txt['shd_ticket_move_cfs_user'] = 'В настоящее время видны обычным пользователям';
$txt['shd_ticket_move_cfs_staff'] = 'В настоящее время видимо для сотрудников';
$txt['shd_ticket_move_cfs_admin'] = 'В настоящее время видны администраторам';
$txt['shd_ticket_move_accept'] = 'Я принимаю к сведению, что некоторые управляемые поля не видны всем пользователям, и что эта тема должна быть перемещена на форум, с указанными выше настройками.';
$txt['shd_ticket_move_reqd'] = 'Эта опция должна быть выбрана для того, чтобы вы могли переместить эту заявку на форум.';
$txt['shd_ticket_move_ok'] = 'Это поле безопасно для перемещения, все пользователи, которые могут видеть тикет могут видеть это поле нет никакой информации, скрытой от пользователей или персонала.';
$txt['shd_ticket_move_reqd_nonselected'] = 'В этой заявке есть поля, которые могут не увидеть пользователи или сотрудники, как таковые вам необходимо подтвердить, что вы знаете об этом - пожалуйста, вернитесь на предыдущую страницу. флажок для подтверждения вашей осведомленности об этом находится в нижней части формы.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Корзина';
$txt['shd_recycle_greeting'] = 'Это поле для переработки. Все удаленные Заявки идут здесь, но сотрудники с особыми правами могут удалять Заявки навсегда.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Создать заявку';
$txt['shd_edit_ticket'] = 'Редактировать заявку';
$txt['shd_edit_ticket_linktree'] = 'Редактировать заявку (%s)';
$txt['shd_ticket_subject'] = 'Тема заявки';
$txt['shd_ticket_proxy'] = 'Пост от имени';
$txt['shd_ticket_post_error'] = 'Следующие проблемы или проблемы произошли при попытке отправить эту заявку';
$txt['shd_reply_ticket'] = 'Ответить на заявку';
$txt['shd_reply_ticket_linktree'] = 'Ответить на заявку (%s)';
$txt['shd_edit_reply_linktree'] = 'Редактировать ответ (%s)';
$txt['shd_previewing_ticket'] = 'Предварительный просмотр заявки';
$txt['shd_previewing_reply'] = 'Предпросмотр ответа на';
$txt['shd_choose_one'] = '[Выберите один]';
$txt['shd_no_value'] = '[нет значения]';
$txt['shd_ticket_dept'] = 'Отдел заявки';
$txt['shd_select_dept'] = '-- Выберите департамент --';
$txt['canned_replies'] = 'Добавить предопределенный ответ:';
$txt['canned_replies_select'] = '-- Выберите ответ --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Ответы службы поддержки размещены с IP (диапазона)';
$txt['shd_no_replies_from_ip'] = 'Не найдено ответов службы поддержки с указанного IP (диапазона)';
$txt['shd_replies_from_ip_desc'] = 'Ниже приведен список всех сообщений, отправленных в службу поддержки с этого IP (диапазона).';
$txt['shd_is_ticket_opener'] = ' (начало заявки)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'Архив BZip2';
$txt['shd_attachtype_gz'] = 'Архив GZip';
$txt['shd_attachtype_rar'] = 'Rar/WinRAR архив';
$txt['shd_attachtype_zip'] = 'Zip архив';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) аудио файл';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Изображение растрового изображения Windows';
$txt['shd_attachtype_gif'] = 'Изображение графического обменного формата (GIF)';
$txt['shd_attachtype_jpeg'] = 'Изображение Объединенной группы экспертов по фотографиям (СКПЕГ)';
$txt['shd_attachtype_jpg'] = 'Изображение Объединенной группы экспертов по фотографиям (СКПЕГ)';
$txt['shd_attachtype_png'] = 'Изображение портативной сетевой графики (PNG)';
$txt['shd_attachtype_svg'] = 'Масштабируемое изображение Vector Graphic (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Видео';
// Office formats
$txt['shd_attachtype_doc'] = 'Документ Microsoft Word';
$txt['shd_attachtype_mdb'] = 'База данных Microsoft Access';
$txt['shd_attachtype_ppt'] = 'Презентация Microsoft Powerpoint';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ исходный файл';
$txt['shd_attachtype_php'] = 'PHP скрипт';
$txt['shd_attachtype_py'] = 'Исходный файл Python';
$txt['shd_attachtype_rb'] = 'Ruby исходный файл';
$txt['shd_attachtype_sql'] = 'SQL скрипт';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Планета Земля (KML)';
$txt['shd_attachtype_kmz'] = 'Google Планета Земля (KML архив)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Portable Document File';
$txt['shd_attachtype_psd'] = 'Документ Adobe Photoshop';
$txt['shd_attachtype_swf'] = 'Adobe Flash файл';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Исполняемый файл (Windows)';
$txt['shd_attachtype_htm'] = 'Документ гипертекста разметки (HTML)';
$txt['shd_attachtype_html'] = 'Документ гипертекста разметки (HTML)';
$txt['shd_attachtype_rtf'] = 'Rich Text Format (RTF)';
$txt['shd_attachtype_txt'] = 'Обычный текст';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Журнал действий по заявкам';
$txt['shd_ticket_log_count_one'] = '1 запись';
$txt['shd_ticket_log_count_more'] = '%s записей';
$txt['shd_ticket_log_none'] = 'Этот тикет не имеет никаких изменений.';
$txt['shd_ticket_log_member'] = 'Участник';
$txt['shd_ticket_log_ip'] = 'IP пользователя:';
$txt['shd_ticket_log_date'] = 'Дата';
$txt['shd_ticket_log_action'] = 'Действие';
$txt['shd_ticket_log_full'] = 'Перейти к полному журналу действий (все заявки)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Связанные Заявки';
$txt['shd_ticket_create_relationship'] = 'Создать связь';
$txt['shd_ticket_delete_relationship'] = 'Удалить связь';
$txt['shd_ticket_reltype'] = 'выбрать тип';
$txt['shd_ticket_reltype_linked'] = 'Связано с';
$txt['shd_ticket_reltype_duplicated'] = 'Дубликат';
$txt['shd_ticket_reltype_parent'] = 'Родитель';
$txt['shd_ticket_reltype_child'] = 'Ребенок';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Дополнительная информация';
$txt['shd_ticket_additional_details'] = 'Дополнительная информация';
$txt['shd_ticket_empty_field'] = 'Это поле не заполнено.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Уведомления';
$txt['shd_ticket_notify_noneprefs'] = 'Ваши предпочтения пользователя не являются уведомлением об этой заявке.';
$txt['shd_ticket_notify_changeprefs'] = 'Изменить ваши предпочтения';
$txt['shd_ticket_notify_because'] = 'Ваши предпочтения указывают на уведомление об ответах на заявку:';
$txt['shd_ticket_notify_because_yourticket'] = 'как это ваш билет';
$txt['shd_ticket_notify_because_assignedyou'] = 'как оно назначено вам';
$txt['shd_ticket_notify_because_priorreply'] = 'как вы ответили на это ранее';
$txt['shd_ticket_notify_because_anyreply'] = 'для любой заявки';

$txt['shd_ticket_notify_me_always'] = 'Вы наблюдаете за этой заявкой (и будете получать уведомления при каждом ответе)';
$txt['shd_ticket_monitor_on_note'] = 'Вы можете следить за ответами на эту заявку по электронной почте независимо от ваших предпочтений:';
$txt['shd_ticket_monitor_off_note'] = 'Вы можете отключить отслеживание для этой заявки и использовать ваши настройки:';
$txt['shd_ticket_monitor_on'] = 'Включить мониторинг';
$txt['shd_ticket_monitor_off'] = 'Выключить мониторинг';
$txt['shd_ticket_notify_me_never_note'] = 'Вы можете игнорировать обновления по электронной почте для этой заявки, независимо от ваших предпочтений:';
$txt['shd_ticket_notify_me_never'] = 'Вы отключили все уведомления для этой заявки.';
$txt['shd_ticket_notify_me_never_on'] = 'Отключить уведомления';
$txt['shd_ticket_notify_me_never_off'] = 'Включить уведомления';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'В системе поиска не могут быть перечислены все доступные заявки; в настоящее время она изучается.';
$txt['shd_search_warning_admin'] = 'Инструмент поиска требует, чтобы его индекс был перестроен. Вы можете его сделать из опции Техническое обслуживание, в области Helpdesk в панели администрации.';
$txt['shd_search'] = 'Поиск Заявок';
$txt['shd_search_results'] = 'Поиск Заявок - Результаты';
$txt['shd_search_text'] = 'Слова, которые вы ищете:';
$txt['shd_search_match'] = 'Что должно быть совпадать?';
$txt['shd_search_match_all'] = 'Совпадение со всеми словами';
$txt['shd_search_match_any'] = 'Совпадение с любыми словами';
$txt['shd_search_scope'] = 'Включить типы заявок:';
$txt['shd_search_scope_open'] = 'Открытые чеки';
$txt['shd_search_scope_closed'] = 'Закрытые заявки';
$txt['shd_search_scope_recycle'] = 'Элементы в корзине';
$txt['shd_search_result_ticket'] = 'Заявка %1$s';
$txt['shd_search_result_reply'] = 'Ответить на заявку %1$s';
$txt['shd_search_last_updated'] = 'Последнее обновление:';
$txt['shd_search_ticket_opened_by'] = 'Заявка открыта:';
$txt['shd_search_ticket_replied_by'] = 'Тикет ответил:';
$txt['shd_search_dept'] = 'Искать в каком отделе (подразделениях):';

$txt['shd_search_urgency'] = 'Учитывать, какие уровни срочности:';

$txt['shd_search_where'] = 'Какие элементы нужно искать:';
$txt['shd_search_where_tickets'] = 'Органы билетов';
$txt['shd_search_where_replies'] = 'Ответы в заявках';
$txt['shd_search_where_subjects'] = 'Темы заявки';

$txt['shd_search_ticket_starter'] = 'Заявка запущена:';
$txt['shd_search_ticket_assignee'] = 'Заявки, назначенные для:';
$txt['shd_search_ticket_named_person'] = 'Введите имя интересующего вас человека.';

$txt['shd_search_no_results'] = 'По заданным критериям результатов не найдено. Вы можете вернуться назад и изменить критерии поиска.';
$txt['shd_search_criteria'] = 'Критерии поиска:';
$txt['shd_search_excluded'] = 'Если выбран любой возможный вариант, то он не был включен в вышеуказанное (напр. если были отмечены все возможные уровни срочности, это не указано выше, так что вы можете сосредоточиться на том, что относится к вашему поиску)';
//@}