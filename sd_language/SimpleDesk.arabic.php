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
$txt['shd_helpdesk'] = 'مكتب المساعدة';
$txt['shd_helpdesk_maintenance'] = 'مكتب المساعدة حاليا في <strong>وضع الصيانة</strong>. فقط المنتدى ومسؤولو مكتب المساعدة يمكنهم رؤية هذا.';
$txt['shd_open_ticket'] = 'فتح تذكرة';
$txt['shd_open_tickets'] = 'تذاكر مفتوحة';
$txt['shd_none'] = 'لا';

$txt['shd_display_nojs'] = 'لم يتم تمكين جافا سكريبت في المتصفح الخاص بك. بعض الوظائف قد لا تعمل بشكل صحيح (أو على الإطلاق)، أو تتصرف بطريقة غير متوقعة.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'مرحبا بكم في مركز إدارة مكتب المساعدة الرئيسي!';
$txt['shd_admin_title'] = 'مركز إدارة مكتب المساعدة';
$txt['shd_staff_list'] = 'موظفو مكتب المساعدة';
$txt['shd_update_available'] = 'نسخة جديدة متوفرة!';
$txt['shd_update_message'] = 'تم إصدار نسخة جديدة من SimpleDesk. لقد أوصيك <a href="#" id="update-link">بالتحديث إلى الإصدار الأحدث</a> من أجل الحفاظ على الأمان والاستمتاع بجميع الميزات التي يجب أن يقدمها تعديلنا.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>لمزيد من المعلومات حول ما هو الجديد في هذا الإصدار، يرجى زيارة <a href="#" id="information-link" target="_blank">موقعنا على الإنترنت</a></span><br>' . "\n\n" . '<strong>فريق SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'منخفض';
$txt['shd_urgency_1'] = 'متوسط';
$txt['shd_urgency_2'] = 'مرتفع';
$txt['shd_urgency_3'] = 'عالية جدا';
$txt['shd_urgency_4'] = 'حاد';
$txt['shd_urgency_5'] = 'حرج';
$txt['shd_urgency_increase'] = 'زيادة';
$txt['shd_urgency_decrease'] = 'تقلص';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'جديد';
$txt['shd_status_1'] = 'في انتظار تعليق الموظفين';
$txt['shd_status_2'] = 'تعليق في انتظار المستخدم';
$txt['shd_status_3'] = 'محل/مغلق';
$txt['shd_status_4'] = 'الإحالة إلى المشرف';
$txt['shd_status_5'] = 'متدرج - ملح';
$txt['shd_status_6'] = 'محذوف';
$txt['shd_status_7'] = 'قيد الانتظار';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'تذاكر جديدة';
$txt['shd_status_1_heading'] = 'التذاكر في انتظار استجابة الموظفين';
$txt['shd_status_2_heading'] = 'التذاكر في انتظار استجابة المستخدم';
$txt['shd_status_3_heading'] = 'تذاكر مغلقة';
$txt['shd_status_4_heading'] = 'التذاكر المحالة إلى المشرف';
$txt['shd_status_5_heading'] = 'تذاكر عاجلة';
$txt['shd_status_6_heading'] = 'التذاكر المعاد تدويرها';
$txt['shd_status_7_heading'] = 'على حجز التذاكر';
$txt['shd_status_assigned_heading'] = 'تم تعيينه لي';
$txt['shd_status_withdeleted_heading'] = 'تذاكر مع الردود المحذوفة';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'تذاكر مفتوحة';
$txt['shd_tickets_closed'] = 'تذاكر مغلقة';
$txt['shd_tickets_recycled'] = 'التذاكر المعاد تدويرها';

$txt['shd_assigned'] = 'المعين';
$txt['shd_unassigned'] = 'غير مسند';

$txt['shd_read_ticket'] = 'قراءة التذكرة';
$txt['shd_unread_ticket'] = 'تذكرة غير مقروءة';
$txt['shd_unread_tickets'] = 'تذاكر غير مقروءة';

$txt['shd_owned'] = 'التذكرة المملوكة'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'تذكرة';
$txt['shd_count_tickets'] = 'تذاكر';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'لا يسمح لك بالوصول إلى مكتب المساعدة.';
$txt['shd_no_ticket'] = 'التذكرة التي طلبتها غير موجودة فيما يبدو.';
$txt['shd_no_reply'] = 'يبدو أن الرد على التذكرة لديك طلب غير موجود، أو أنه ليس جزءا من هذه التذاكرة.';
$txt['shd_no_topic'] = 'الموضوع الذي طلبته غير موجود على ما يبدو.';
$txt['shd_ticket_no_perms'] = 'ليس لديك الصلاحيّات الكافية لعرض تلك التذكرة.';
$txt['shd_error_no_tickets'] = 'لم يتم العثور على أي تذكرة.';
$txt['shd_inactive'] = 'مكتب المساعدة غير نشط حاليا.';
$txt['shd_cannot_assign'] = 'غير مسموح لك بتعيين التذاكر.';
$txt['shd_cannot_assign_other'] = 'هذه التذكرة تم تعيينها مسبقا لمستخدم آخر. لا يمكنك إعادة تعيينها لنفسك - الرجاء الاتصال بالمسؤول.';
$txt['shd_no_staff_assign'] = 'لا يوجد موظف تم تكوينه؛ لا يمكن تعيين تذكرة. الرجاء الاتصال بالمسؤول.';
$txt['shd_assigned_not_permitted'] = 'المستخدم الذي طلبته لتعيين هذه التذكرة ليس لديه الصلاحيات الكافية لرؤيتها.';
$txt['shd_cannot_resolve'] = 'ليس لديك الصلاحية لوضع علامة على هذه التذكرة كما تم حسمها.';
$txt['shd_cannot_unresolve'] = 'ليس لديك الصلاحية لإعادة فتح تذكرة تم حلها.';
$txt['error_shd_cannot_resolve_children'] = 'لا يمكن إغلاق هذه التذكرة حالياً؛ هذه التذكرة هي الأصل لتذكرة واحدة أو أكثر مفتوحة حالياً.';
$txt['error_shd_proxy_unknown'] = 'المستخدم الذي تم نشر هذه التذكرة نيابة عن غير موجود.';
$txt['shd_cannot_change_privacy'] = 'ليس لديك الصلاحية لتغيير الخصوصية على هذه التذكرة.';
$txt['shd_cannot_change_urgency'] = 'ليس لديك إذن لتغيير الطابع الملح لهذه التذكرة.';
$txt['shd_ajax_problem'] = 'حدثت مشكلة أثناء محاولة تحميل الصفحة. هل ترغب في المحاولة مرة أخرى؟';
$txt['shd_cannot_move_ticket'] = 'ليس لديك الصلاحية لنقل هذه التذكرة إلى موضوع.';
$txt['shd_cannot_move_topic'] = 'ليس لديك الصلاحية لنقل هذا الموضوع إلى تذكرة.';
$txt['shd_moveticket_noboards'] = 'لا توجد لوحات لنقل هذه التذكرة إلى!';
$txt['shd_move_no_pm'] = 'يجب عليك إدخال سبب لنقل التذكرة لإرسالها إلى صاحب التذاكر، أو قم بإلغاء تحديد الخيار \'إرسال رسالة رسمية إلى مالك التذكرة\'.';
$txt['shd_move_no_pm_topic'] = 'يجب عليك إدخال سبب لنقل الموضوع لإرساله إلى بداية الموضوع، أو قم بإلغاء تحديد الخيار \'إرسال رسالة رسمية إلى الموضوع بدء\'.';
$txt['shd_move_topic_not_created'] = 'فشل نقل التذكرة إلى اللوحة. الرجاء المحاولة مرة أخرى.';
$txt['shd_move_ticket_not_created'] = 'فشل نقل الموضوع إلى مكتب المساعدة. الرجاء المحاولة مرة أخرى.';
$txt['shd_no_replies'] = 'هذه التذكرة ليس لديها أي ردود حتى الآن.';
$txt['cannot_shd_new_ticket'] = 'ليس لديك الصلاحية لإنشاء تذكرة جديدة.';
$txt['cannot_shd_edit_ticket'] = 'ليس لديك الصلاحية لتعديل هذه التذكرة.';
$txt['shd_cannot_reply_any'] = 'ليس لديك الصلاحية للرد على أي تذكرة.';
$txt['shd_cannot_reply_any_but_own'] = 'ليس لديك الصلاحية للرد على أي تذاكر غير التذاكر الخاصة بك.';
$txt['shd_cannot_edit_reply_any'] = 'ليس لديك الصلاحيّات الكافية لتعديل أي ردود.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'ليس لديك الصلاحية لتعديل الردود على أي تذاكر أخرى غير الردود الخاصة بك.';
$txt['shd_cannot_edit_closed'] = 'لا يمكنك تحرير التذاكر المحلى؛ تحتاج إلى وضع علامة عليها دون حل أولاً.';
$txt['shd_cannot_edit_deleted'] = 'لا يمكنك تعديل التذاكر في سلة إعادة التدوير. سوف تحتاج إلى استعادتها أولاً.';
$txt['shd_cannot_reply_closed'] = 'لا يمكنك الرد على التذاكر المحلى؛ تحتاج إلى وضع علامة عليها دون حل أولاً.';
$txt['shd_cannot_reply_deleted'] = 'لا يمكنك الرد على التذاكر في سلة إعادة التدوير. سوف تحتاج إلى استعادتها أولاً.';
$txt['shd_cannot_delete_ticket'] = 'غير مسموح لك بحذف هذه التذكرة.';
$txt['shd_cannot_delete_reply'] = 'غير مسموح لك بحذف هذا الرد.';
$txt['shd_cannot_restore_ticket'] = 'غير مسموح لك باستعادة هذه التذكرة من سلة إعادة التدوير.';
$txt['shd_cannot_restore_reply'] = 'غير مسموح لك باستعادة هذا الرد من سلة إعادة التدوير.';
$txt['shd_cannot_view_resolved'] = 'غير مسموح لك بالوصول إلى التذاكر التي تم حلها.';
$txt['cannot_shd_access_recyclebin'] = 'لا يمكنك الوصول إلى سلة إعادة التدوير.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'لا يمكنك نقل هذه التذكرة إلى المنتدى؛ هناك رد واحد أو أكثر محذوف، والتي لا تسمح أذوناتك الحالية بالوصول إليها.';
$txt['shd_cannot_attach_ext'] = 'نوع الملف الذي حاولت إرفاقه ({ext}) غير مسموح هنا. الأنواع المسموح بها من الملفات هي: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'هذه التذكرة غير متوفرة حاليا للتعديل.';
$txt['shd_invalid_relation'] = 'يجب عليك تقديم نوع صحيح من العلاقة لهذه التذاكر.';
$txt['shd_no_relation_delete'] = 'لا يمكنك حذف علاقة غير موجودة.';
$txt['shd_cannot_relate_self'] = 'لا يمكنك جعل التذكرة تتصل بنفسها.';
$txt['shd_relationships_are_disabled'] = 'علاقات التذكرة معطلة حاليا.';
$txt['error_invalid_fields'] = 'الحقول التالية لها قيم لا يمكن استخدامها: %1$s';
$txt['error_missing_fields'] = 'الحقول التالية لم تكتمل ويجب أن تكون: %1$s';
$txt['error_missing_multi'] = '%1$s (يجب تحديد %2$d على الأقل)';
$txt['error_no_dept'] = 'لم تقم باختيار قسم لنشر هذه التذكرة فيه.';
$txt['shd_cannot_move_dept'] = 'لا يمكنك تحريك هذه التذكرة ، لا يوجد مكان لنقلها إليه.';
$txt['shd_no_perm_move_dept'] = 'لا يسمح لك بنقل هذه التذكرة إلى قسم آخر.';
$txt['cannot_shd_delete_attachment'] = 'غير مسموح لك بحذف المرفقات.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'لا يمكنك نقل هذه التذكرة إلى موضوع؛ هناك حقول مخصصة ملحقة تتطلب من المسؤول تأكيد النقل.';
$txt['cannot_monitor_ticket'] = 'لا يسمح لك بتشغيل مراقبة هذه التذكرة.';
$txt['cannot_unmonitor_ticket'] = 'غير مسموح لك بإيقاف مراقبة هذه التذكرة.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'مكتب المساعدة'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'الأقسام'; // ditto
$txt['shd_new_ticket'] = 'نشر تذكرة جديدة';
$txt['shd_new_ticket_proxy'] = 'نشر تذكرة البروكسي';
$txt['shd_helpdesk_profile'] = 'الملف الشخصي لمكتب المساعدة';
$txt['shd_welcome'] = 'مرحبا، %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'الذهاب إلى التذكرة';
$txt['shd_options'] = 'خيارات';
$txt['shd_search_menu'] = 'البحث';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'معلومات';
$txt['shd_admin_options'] = 'خيارات';
$txt['shd_admin_custom_fields'] = 'حقول مخصصة';
$txt['shd_admin_departments'] = 'الأقسام';
$txt['shd_admin_permissions'] = 'الأذونات';
$txt['shd_admin_plugins'] = 'الإضافات';
$txt['shd_admin_cannedreplies'] = 'الردود المسبقة';
$txt['shd_admin_maint'] = 'صيانة';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'هنا يمكنك تقديم تذاكر جديدة لموظفي الموقع للعمل، والتحقق من التذاكر الحالية قيد التنفيذ بالفعل.';
$txt['shd_staff_greeting'] = 'إليك جميع التذاكر التي تتطلب الاهتمام.';
$txt['shd_shd_greeting'] = 'هذا هو مكتب المساعدة. هنا تضيع وقتك لمساعدة المبتدئين. استمتع! ;D';
$txt['shd_closed_user_greeting'] = 'هذه هي جميع التذاكر المغلقة/المحلولة التي قمت بنشرها على مكتب المساعدة.';
$txt['shd_closed_staff_greeting'] = 'هذه كلها تذاكر مغلقة/محسومة مقدمة إلى مكتب المساعدة.';
$txt['shd_category_filter'] = 'تصفية الفئات';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'تم إنشاء تذكرتك!';
$txt['shd_ticket_posted_body'] = 'شكرا لك على نشر تذكرتك، {membername}!' . "\n\n" . 'سوف يقوم موظفو مكتب المساعدة بمراجعتها وإعادتها إليك في أقرب وقت ممكن.' . "\n\n" . 'في غضون ذلك، يمكنك مشاهدة تذكرتك، &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; على العنوان التالي:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]فتح تذكرة أخرى[/iurl] <unk> [iurl={helpdesklink}]العودة إلى مكتب المساعدة الرئيسي[/iurl] <unk> [iurl={forumlink}]العودة إلى المنتدى[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'يمكنك تشغيل إشعارات البريد الإلكتروني حول التغييرات على تذكرتك، في منطقة [iurl={prefslink}]تفضيلات مكتب المساعدة[/iurl]';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'أطيب' . "\n" . 'فريق {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'تفاصيل التذكرة';
$txt['shd_ticket_updated'] = 'تم التحديث';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'الاسم';
$txt['shd_ticket_user'] = 'المستخدم';
$txt['shd_ticket_date'] = 'نشر';
$txt['shd_ticket_urgency'] = 'إلحاح';
$txt['shd_ticket_assigned'] = 'المعين';
$txt['shd_ticket_assignedto'] = 'تم تعيينه إلى';
$txt['shd_ticket_started_by'] = 'بدأ من قبل';
$txt['shd_ticket_updated_by'] = 'تم التحديث بواسطة';
$txt['shd_ticket_status'] = 'الحالة';
$txt['shd_ticket_num_replies'] = 'الردود';
$txt['shd_ticket_replies'] = 'الردود';
$txt['shd_ticket_staff'] = 'موظف';
$txt['shd_ticket_attachments'] = 'المرفقات';
$txt['shd_ticket_reply_number'] = 'الرد <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'قيد الانتظار للتذكرة';
$txt['shd_ticket'] = 'التذكرة';
$txt['shd_reply_written'] = 'الرد المكتوب %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'لا';
$txt['shd_linktree_tickets'] = 'تذاكر';
$txt['shd_ticket_privacy'] = 'الخصوصية';
$txt['shd_ticket_notprivate'] = 'غير خاص';
$txt['shd_ticket_private'] = 'خاص';
$txt['shd_ticket_change'] = 'تغيير';
$txt['shd_ticket_ip'] = 'عنوان IP';
$txt['shd_back_to_hd'] = 'العودة إلى مكتب المساعدة';
$txt['shd_go_to_replies'] = 'الذهاب إلى الردود';
$txt['shd_go_to_action_log'] = 'الذهاب إلى سجل الإجراءات';
$txt['shd_go_to_replies_start'] = 'انتقل إلى الرد الأول';

$txt['shd_ticket_has_been_deleted'] = 'هذه التذكرة موجودة حاليا في سلة إعادة التدوير ولا يمكن تغييرها بدون إعادتها إلى مكتب المساعدة.';
$txt['shd_ticket_replies_deleted'] = 'وقد حُذفت من قبل من هذه التذكرة ردود.';
$txt['shd_ticket_replies_deleted_view'] = 'يتم عرض هذه مع خلفية ملونة. <a href="%1$s">عرض التذكرة بدون حذف</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'الرجاء <a href="%1$s">انقر هنا</a> لمشاهدتها.';

$txt['shd_ticket_notnew'] = 'لقد رأيت هذا بالفعل';
$txt['shd_ticket_new'] = 'جديد!';

$txt['shd_linktree_move_ticket'] = 'نقل التذكرة';
$txt['shd_linktree_move_topic'] = 'نقل الموضوع إلى مكتب المساعدة';

$txt['shd_cancel_ticket'] = 'إلغاء وإعادة إلى التذكرة';
$txt['shd_cancel_home'] = 'إلغاء والعودة إلى منزل مكتب المساعدة';
$txt['shd_cancel_topic'] = 'إلغاء الموضوع والعودة إليه';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'الرد على التذكرة';
$txt['shd_ticket_quote'] = 'الرد مع الاقتباس';
$txt['shd_go_advanced'] = 'اذهب للتقدم!';
$txt['shd_ticket_edit_reply'] = 'تحرير الرد';
$txt['shd_ticket_quote_short'] = 'اقتباس';
$txt['shd_ticket_markunread'] = 'وضع علامة غير مقروء';
$txt['shd_ticket_reply_short'] = 'الرد';
$txt['shd_ticket_edit'] = 'تحرير';
$txt['shd_ticket_resolved'] = 'تم حل العلامة';
$txt['shd_ticket_unresolved'] = 'وضع علامة بدون حل';
$txt['shd_ticket_assign'] = 'تعيين';
$txt['shd_ticket_assign_self'] = 'تعيين لي';
$txt['shd_ticket_reassign'] = 'إعادة تعيين';
$txt['shd_ticket_unassign'] = 'إلغاء التعيين';
$txt['shd_ticket_delete'] = 'حذف';
$txt['shd_delete_confirm'] = 'هل أنت متأكد من أنك تريد حذف هذه التذكرة؟ إذا تم حذفها، سيتم نقل هذه التذكرة إلى سلة إعادة التدوير.';
$txt['shd_delete_reply_confirm'] = 'هل أنت متأكد من أنك تريد حذف هذا الرد؟ إذا تم حذفه، سيتم نقل هذا الرد إلى سلة إعادة التدوير.';
$txt['shd_delete_attach_confirm'] = 'هل أنت متأكد من أنك تريد حذف هذا المرفق؟ (هذا لا يمكن التراجع عنه!)';
$txt['shd_delete_attach'] = 'حذف هذا المرفق';
$txt['shd_ticket_restore'] = 'إستعادة';
$txt['shd_delete_permanently'] = 'حذف بشكل دائم';
$txt['shd_delete_permanently_confirm'] = 'هل أنت متأكد من أنك تريد حذف هذه التذكرة نهائيًا؟ لا يمكن التراجع عن هذا!';
$txt['shd_ticket_move_to_topic'] = 'نقل إلى الموضوع';
$txt['shd_move_dept'] = 'تحريك العمق.';
$txt['shd_actions'] = 'الإجراءات';
$txt['shd_back_to_ticket'] = 'العودة إلى هذه التذكرة بعد النشر';
$txt['shd_disable_smileys_post'] = 'إيقاف الابتسامات في هذا المنشور';
$txt['shd_resolve_this_ticket'] = 'وضع علامة على هذه التذكرة كمحلولة';
$txt['shd_override_cf'] = 'تجاوز متطلبات الحقول المخصصة';
$txt['shd_silent_update'] = 'تحديث صامت (لا إرسال إشعارات )';
$txt['shd_select_notifications'] = 'حدد الأشخاص للإشعار بهذا الرد...';

$txt['shd_ticket_assign_ticket'] = 'تعيين التذكرة';
$txt['shd_ticket_assign_to'] = 'تعيين التذكرة إلى';

$txt['shd_ticket_move_dept'] = 'نقل التذكرة إلى قسم آخر';
$txt['shd_ticket_move_to'] = 'نقل إلى';
$txt['shd_current_dept'] = 'حاليا في القسم';
$txt['shd_ticket_move'] = 'نقل التذكرة';
$txt['shd_unknown_dept'] = 'القسم المحدد غير موجود.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'موضوع جديد';
$txt['shd_move_ticket_to_topic'] = 'نقل التذكرة إلى الموضوع';
$txt['shd_move_ticket'] = 'نقل التذكرة';
$txt['shd_ticket_board'] = 'المجلس';
$txt['shd_change_ticket_subject'] = 'تغيير موضوع التذكرة';
$txt['shd_move_send_pm'] = 'إرسال رسالة رسمية إلى مالك التذكرة';
$txt['shd_move_why'] = 'الرجاء إدخال وصف موجز لسبب نقل هذه التذكرة إلى موضوع المنتدى.';
$txt['shd_ticket_moved_subject'] = 'تم نقل تذكرتك.';
$txt['shd_move_default'] = 'مرحبا {user}،' . "\n\n" . 'تم نقل تذكرتك، {subject}، من مكتب المساعدة إلى موضوع في المنتدى.' . "\n" . 'يمكنك العثور على تذكرتك في اللوحة {board} أو عبر هذا الرابط:' . "\n\n" . '{link}' . "\n\n" . 'شكراً';

$txt['shd_move_topic_to_ticket'] = 'نقل الموضوع إلى مكتب المساعدة';
$txt['shd_move_topic'] = 'نقل الموضوع';
$txt['shd_change_topic_subject'] = 'تغيير موضوع الموضوع';
$txt['shd_move_send_pm_topic'] = 'إرسال رسالة شخصية إلى بداية الموضوع';
$txt['shd_move_why_topic'] = 'الرجاء إدخال وصف موجز لسبب نقل هذا الموضوع إلى مكتب المساعدة. ';
$txt['shd_ticket_moved_subject_topic'] = 'تم نقل الموضوع الخاص بك.';
$txt['shd_move_default_topic'] = 'مرحبا {user}،' . "\n\n" . 'تم نقل الموضوع الخاص بك، {subject}، من المنتدى إلى قسم مكتب المساعدة.' . "\n" . 'يمكنك العثور على الموضوع الخاص بك عبر هذا الرابط:' . "\n\n" . '{link}' . "\n\n" . 'شكراً';

$txt['shd_user_no_hd_access'] = 'ملاحظة: الشخص الذي بدأ هذا الموضوع لا يستطيع رؤية مكتب المساعدة!';
$txt['shd_user_helpdesk_access'] = 'الشخص الذي بدأ هذا الموضوع بإمكانه أن يشاهد مكتب المساعدة.';
$txt['shd_user_hd_access_dept_1'] = 'يمكن للشخص الذي بدأ هذا الموضوع أن يرى القسم التالي: ';
$txt['shd_user_hd_access_dept'] = 'يمكن للشخص الذي بدأ هذا الموضوع أن يرى الأقسام التالية: ';
$txt['shd_move_ticket_department'] = 'نقل التذكرة إلى أي قسم';
$txt['shd_move_dept_why'] = 'الرجاء إدخال وصف موجز لسبب نقل هذه التذكرة إلى قسم مختلف.';
$txt['shd_move_dept_default'] = 'مرحبا {user}،' . "\n\n" . 'تم نقل تذكرتك، {subject}، من قسم {current_dept} إلى قسم {new_dept}.' . "\n" . 'يمكنك العثور على تذكرتك عبر هذا الرابط:' . "\n\n" . '{link}' . "\n\n" . 'شكراً';

$txt['shd_ticket_move_deleted'] = 'تحتوي هذه التذكرة على ردود موجودة حاليا في سلة إعادة التدوير. ماذا تريد أن تفعل؟';
$txt['shd_ticket_move_deleted_abort'] = 'أوقف ، خذني إلى سلة إعادة التدوير';
$txt['shd_ticket_move_deleted_delete'] = 'الاستمرار، التخلي عن الردود المحذوفة (لا تنقلها إلى الموضوع الجديد)';
$txt['shd_ticket_move_deleted_undelete'] = 'استمرار، إلغاء حذف الردود (انتقل إلى الموضوع الجديد)';

$txt['shd_ticket_move_cfs'] = 'تحتوي هذه التذكرة على حقول مخصصة قد تحتاج إلى نقل.';
$txt['shd_ticket_move_cfs_warn'] = 'وقد لا تكون بعض هذه الحقول مرئية لمستخدمين آخرين. وهذه الحقول مشار إليها بعلامة تعجب.';
$txt['shd_ticket_move_cfs_warn_user'] = 'يمكنك رؤية هذا الحقل، المستخدمين الآخرين لا يستطيعون - ولكن بمجرد أن يصبح جزءا من المنتدى، وسيصبح مرئيا لكل من يستطيع الوصول إلى المنتدى.';
$txt['shd_ticket_move_cfs_purge'] = 'حذف محتويات الحقل';
$txt['shd_ticket_move_cfs_embed'] = 'حافظ على الحقل ووضعه في الموضوع الجديد';
$txt['shd_ticket_move_cfs_user'] = 'مرئي حاليا للمستخدمين المنتظمين';
$txt['shd_ticket_move_cfs_staff'] = 'مرئي حاليا للموظفين';
$txt['shd_ticket_move_cfs_admin'] = 'مرئي حاليا للمسؤولين';
$txt['shd_ticket_move_accept'] = 'وأقبل أن بعض الحقول التي يجري التلاعب بها هنا ليست مرئية لجميع المستخدمين، وينبغي أن ينقل هذا الموضوع إلى المنتدى، مع مراعاة الأوضاع المذكورة أعلاه.';
$txt['shd_ticket_move_reqd'] = 'يجب تحديد هذا الخيار من أجل نقل هذه التذكرة إلى المنتدى.';
$txt['shd_ticket_move_ok'] = 'هذا الحقل آمن للنقل، جميع المستخدمين الذين يمكنهم رؤية التذكرة يمكنهم رؤية هذا الحقل، لا توجد معلومات مخفية عن المستخدمين أو الموظفين.';
$txt['shd_ticket_move_reqd_nonselected'] = 'تحتوي هذه التذكرة على حقول قد لا يتمكن المستخدمون أو الموظفون من رؤيتها، بهذه الصفة تحتاج بالتحديد إلى تأكيد أنك على علم بذلك - يرجى العودة إلى الصفحة السابقة، خانة الاختيار لتأكيد وعيك بهذا هو في الجزء السفلي من النموذج.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'سلة المحذوفات';
$txt['shd_recycle_greeting'] = 'هذا هو سلة إعادة التدوير. جميع التذاكر المحذوفة تذهب إلى هنا، ولكن الموظفين الذين لديهم أذونات خاصة يمكنهم إزالة التذاكر بشكل دائم من هنا.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'إنشاء تذكرة';
$txt['shd_edit_ticket'] = 'تعديل التذكرة';
$txt['shd_edit_ticket_linktree'] = 'تحرير التذكرة (%s)';
$txt['shd_ticket_subject'] = 'موضوع التذكرة';
$txt['shd_ticket_proxy'] = 'نشر نيابة عن';
$txt['shd_ticket_post_error'] = 'المشكلة أو المشكلات التالية، حدثت أثناء محاولة نشر هذه التذكرة';
$txt['shd_reply_ticket'] = 'الرد على التذكرة';
$txt['shd_reply_ticket_linktree'] = 'الرد على التذكرة (%s)';
$txt['shd_edit_reply_linktree'] = 'تحرير الرد (%s)';
$txt['shd_previewing_ticket'] = 'معاينة التذكرة';
$txt['shd_previewing_reply'] = 'معاينة الرد على';
$txt['shd_choose_one'] = '[اختر واحدة]';
$txt['shd_no_value'] = '[لا قيمة]';
$txt['shd_ticket_dept'] = 'قسم التذكرة';
$txt['shd_select_dept'] = '-- اختر قسم --';
$txt['canned_replies'] = 'إضافة رد محدد مسبقاً:';
$txt['canned_replies_select'] = '-- اختر رداً --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'ردود مكتب المساعدة المنشورة من IP (النطاق)';
$txt['shd_no_replies_from_ip'] = 'لم يتم العثور على ردود مكتب مساعدة من IP المحدد (النطاق)';
$txt['shd_replies_from_ip_desc'] = 'فيما يلي قائمة بجميع الرسائل المنشورة إلى مكتب المساعدة من هذا IP (النطاق).';
$txt['shd_is_ticket_opener'] = ' (بدء التذاكر)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'أرشيف BZip2';
$txt['shd_attachtype_gz'] = 'أرشيف GZip';
$txt['shd_attachtype_rar'] = 'أرشيف Rar/WinRAR';
$txt['shd_attachtype_zip'] = 'أرشيف Zip';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (الطبقة الثالثة) ملف صوتي';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'صورة Windows Bitmap';
$txt['shd_attachtype_gif'] = 'صورة تنسيق تبادل الرسوم البيانية (GIF)';
$txt['shd_attachtype_jpeg'] = 'صورة فريق الخبراء التصويري المشترك';
$txt['shd_attachtype_jpg'] = 'صورة فريق الخبراء التصويري المشترك';
$txt['shd_attachtype_png'] = 'صورة رسوم الشبكة المحمولة (PNG)';
$txt['shd_attachtype_svg'] = 'صورة مقياس Vector Graphic (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'فيلم ويندوز فيديو الوسائط';
// Office formats
$txt['shd_attachtype_doc'] = 'مستند مايكروسوفت وورد';
$txt['shd_attachtype_mdb'] = 'قاعدة بيانات ميكروسوفت';
$txt['shd_attachtype_ppt'] = 'عرض Microsoft Powerpoint';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'ملف مصدر C++';
$txt['shd_attachtype_php'] = 'سكريبت PHP';
$txt['shd_attachtype_py'] = 'ملف مصدر بايثون';
$txt['shd_attachtype_rb'] = 'ملف مصدر Ruby';
$txt['shd_attachtype_sql'] = 'سكريبت SQL';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'جوجل أرض (KML)';
$txt['shd_attachtype_kmz'] = 'أرشيف Google Earth (KML)';
$txt['shd_attachtype_pdf'] = 'ملف المستند المحمول من Adobe Acrobat';
$txt['shd_attachtype_psd'] = 'وثيقة Adobe Photoshop';
$txt['shd_attachtype_swf'] = 'ملف Adobe Flash';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'ملف قابل للتنفيذ (ويندوز)';
$txt['shd_attachtype_htm'] = 'وثيقة علامة النص الفائق (HTML)';
$txt['shd_attachtype_html'] = 'وثيقة علامة النص الفائق (HTML)';
$txt['shd_attachtype_rtf'] = 'تنسيق النص الغني (RTF)';
$txt['shd_attachtype_txt'] = 'نص عادي';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'سجل إجراءات التذاكر';
$txt['shd_ticket_log_count_one'] = '1 مدخل';
$txt['shd_ticket_log_count_more'] = '%s إدخالات';
$txt['shd_ticket_log_none'] = 'لم يكن لهذه التذكرة أي تغييرات.';
$txt['shd_ticket_log_member'] = 'عضو';
$txt['shd_ticket_log_ip'] = 'الIP:';
$txt['shd_ticket_log_date'] = 'التاريخ';
$txt['shd_ticket_log_action'] = 'اجراء';
$txt['shd_ticket_log_full'] = 'الذهاب إلى سجل الإجراءات الكامل (جميع التذاكر)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'تذاكر ذات صلة';
$txt['shd_ticket_create_relationship'] = 'إنشاء علاقة';
$txt['shd_ticket_delete_relationship'] = 'حذف العلاقة';
$txt['shd_ticket_reltype'] = 'تحديد نوع';
$txt['shd_ticket_reltype_linked'] = 'مرتبط بـ';
$txt['shd_ticket_reltype_duplicated'] = 'تكرار من';
$txt['shd_ticket_reltype_parent'] = 'الأصل من';
$txt['shd_ticket_reltype_child'] = 'طفل من';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'معلومات إضافية';
$txt['shd_ticket_additional_details'] = 'تفاصيل إضافية';
$txt['shd_ticket_empty_field'] = 'هذا الحقل فارغ.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'الإشعارات';
$txt['shd_ticket_notify_noneprefs'] = 'تفضيلات المستخدم الخاصة بك لا تأخذ في الحسبان هذه التذاكر.';
$txt['shd_ticket_notify_changeprefs'] = 'تغيير التفضيلات الخاصة بك';
$txt['shd_ticket_notify_because'] = 'التفضيلات الخاصة بك تشير إلى إعلامك بالردود على هذه التذكرة:';
$txt['shd_ticket_notify_because_yourticket'] = 'كما أنها تذكرتك';
$txt['shd_ticket_notify_because_assignedyou'] = 'كما يتم تعيينه إليك';
$txt['shd_ticket_notify_because_priorreply'] = 'كما ردت عليه من قبل';
$txt['shd_ticket_notify_because_anyreply'] = 'لأي تذكرة';

$txt['shd_ticket_notify_me_always'] = 'أنت تراقب هذه التذكرة (وسوف تتلقى إشعارا في كل رد)';
$txt['shd_ticket_monitor_on_note'] = 'يمكنك مراقبة جميع الردود على هذه التذكرة عبر البريد الإلكتروني بغض النظر عن التفضيلات الخاصة بك:';
$txt['shd_ticket_monitor_off_note'] = 'يمكنك إيقاف المراقبة لهذه التذكرة واستخدام التفضيلات الخاصة بك بدلاً من ذلك:';
$txt['shd_ticket_monitor_on'] = 'تشغيل الرصد';
$txt['shd_ticket_monitor_off'] = 'إيقاف المراقبة';
$txt['shd_ticket_notify_me_never_note'] = 'يمكنك تجاهل تحديثات البريد الإلكتروني لهذه التذكرة بغض النظر عن تفضيلاتك:';
$txt['shd_ticket_notify_me_never'] = 'لقد أغلقت جميع الإشعارات لهذه التذكرة.';
$txt['shd_ticket_notify_me_never_on'] = 'إيقاف الإشعارات';
$txt['shd_ticket_notify_me_never_off'] = 'تشغيل الإشعارات';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'ولا يجوز لمرفق التفتيش أن يسرد جميع التذاكر المتاحة؛ ويجري حاليا التحقيق فيها.';
$txt['shd_search_warning_admin'] = 'يتطلب مرفق البحث إعادة بناء فهرسه. يمكنك تحقيق ذلك من خيار الصيانة، في منطقة مكتب المساعدة، في لوحة الإدارة.';
$txt['shd_search'] = 'البحث عن تذاكر';
$txt['shd_search_results'] = 'تذاكر البحث - النتائج';
$txt['shd_search_text'] = 'الكلمات التي تبحث عنها:';
$txt['shd_search_match'] = 'ما الذي ينبغي تطابقه؟';
$txt['shd_search_match_all'] = 'مطابقة جميع الكلمات المقدمة';
$txt['shd_search_match_any'] = 'مطابقة أي كلمات مقدمة';
$txt['shd_search_scope'] = 'تضمين أنواع التذاكر:';
$txt['shd_search_scope_open'] = 'تذاكر مفتوحة';
$txt['shd_search_scope_closed'] = 'تذاكر مغلقة';
$txt['shd_search_scope_recycle'] = 'عناصر في سلة المهملات';
$txt['shd_search_result_ticket'] = 'تذكرة %1$s';
$txt['shd_search_result_reply'] = 'الرد على التذكرة %1$s';
$txt['shd_search_last_updated'] = 'آخر تحديث:';
$txt['shd_search_ticket_opened_by'] = 'التذكرة مفتوحة بواسطة:';
$txt['shd_search_ticket_replied_by'] = 'رد على التذكرة بواسطة:';
$txt['shd_search_dept'] = 'البحث في أي قسم (أقسام):';

$txt['shd_search_urgency'] = 'إدراج أي مستويات من الاستعجال:';

$txt['shd_search_where'] = 'ما هي العناصر المراد بحثها:';
$txt['shd_search_where_tickets'] = 'جثث التذاكر';
$txt['shd_search_where_replies'] = 'الردود في التذاكر';
$txt['shd_search_where_subjects'] = 'مواضيع التذكرة';

$txt['shd_search_ticket_starter'] = 'بدأت التذاكر بواسطة:';
$txt['shd_search_ticket_assignee'] = 'التذاكر المعينة إلى:';
$txt['shd_search_ticket_named_person'] = 'اكتب اسم الشخص (الأشخاص) الذي تهتم به.';

$txt['shd_search_no_results'] = 'لم يتم العثور على أي نتائج مع المعايير المحددة. قد ترغب في العودة ومحاولة تغيير معايير البحث الخاصة بك.';
$txt['shd_search_criteria'] = 'معايير البحث:';
$txt['shd_search_excluded'] = 'إذا تم اختيار كل خيار ممكن، فإنه لم يتم إدراجه في أعلاه (على سبيل المثال إذا تم تحديد جميع مستويات الاستعجال الممكنة، فإنه ليس مذكورا أعلاه، ولذلك يمكنكم التركيز على ما هو محدد في بحثكم عن ذلك).';
//@}