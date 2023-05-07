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
$txt['core_settings_item_shd'] = 'مكتب المساعدة';
$txt['core_settings_item_shd_desc'] = 'مكتب المساعدة يسمح لك بتوسيع المنتدى الخاص بك ليشمل صناعة الخدمات من خلال توفير مكتب مساعدة مخصص للمستخدم والموظفين.';
//@}

//! @name Items for general SMF/ACP integration
//@{
$txt['errortype_simpledesk'] = 'SimpleDesk';
$txt['errortype_simpledesk_desc'] = 'الأخطاء المرتبطة على الأرجح بـ SimpleDesk. يرجى الإبلاغ عن أي أخطاء من هذا القبيل على الموقع www.simpledesk.net.';
$txt['errortype_sdplugin'] = 'إضافة SimpleDesk';
$txt['errortype_sdplugin_desc'] = 'الأخطاء ذات الصلة على الأرجح بالبرنامج المساعد SimpleDesk. يجب أن يشير اسم الملف بشكل عام إلى الملحق، بحيث يمكنك التحقق لمعرفة من هو مقدم البلاغ.';
$txt['scheduled_task_simpledesk'] = 'الصيانة اليومية البسيطة';
$txt['scheduled_task_desc_simpledesk'] = 'مهام الصيانة والتجهيز الداخلي ليتم تشغيلهما يوميا لـ SimpleDesk. لا ينصح بشدة بتعطيل هذه المهمة.';

$txt['lang_file_desc_SimpleDesk'] = 'مكتب المساعدة الرئيسي';
$txt['lang_file_desc_SimpleDeskAdmin'] = 'إدارة مكتب المساعدة';
$txt['lang_file_desc_SimpleDeskLogAction'] = 'إدخالات سجل الإجراءات';
$txt['lang_file_desc_SimpleDeskNotifications'] = 'إشعارات البريد الإلكتروني';
$txt['lang_file_desc_SimpleDeskPermissions'] = 'الأذونات';
$txt['lang_file_desc_SimpleDeskProfile'] = 'منطقة الملف الشخصي';
$txt['lang_file_desc_SimpleDeskWho'] = 'من على الإنترنت';
//@}

//! @name Items for the administration menu structure
//@{
// Admin menu items, the ones that aren't in SimpleDesk.english.php anyway...
$txt['shd_admin_standalone_options'] = 'الوضع المستقل';
$txt['shd_admin_actionlog'] = 'سجل الإجراءات';
$txt['shd_admin_adminlog'] = 'سجل المشرف';
$txt['shd_admin_support'] = 'الدعم';
$txt['shd_admin_helpdesklog'] = 'سجل مكتب المساعدة';

$txt['shd_admin_options_display'] = 'خيارات العرض';
$txt['shd_admin_options_posting'] = 'خيارات النشر';
$txt['shd_admin_options_admin'] = 'الخيارات الإدارية';
$txt['shd_admin_options_standalone'] = 'خيارات مستقلة';
$txt['shd_admin_options_actionlog'] = 'خيارات سجل الإجراءات';
$txt['shd_admin_options_notifications'] = 'خيارات الإشعارات';
//@}

//! @name Descriptions for the page items.
//@{
$txt['shd_admin_info_desc'] = 'هذا هو مركز المعلومات لمكتب المساعدة، مدعوم من SimpleDesk. هنا يمكنك الحصول على أحدث الأخبار بالإضافة إلى الدعم الخاص بالإصدار.';
$txt['shd_admin_options_desc'] = 'هذا هو مجال التكوين العام لمكتب المساعدة، حيث يمكن تكوين بعض الخيارات الأساسية.';
$txt['shd_admin_options_display_desc'] = 'في هذا المجال يمكنك تغيير بعض الإعدادات التي ستعدل عرض مكتب المساعدة الخاص بك.';
$txt['shd_admin_options_posting_desc'] = 'هنا يمكنك تعديل إعدادات النشر، مثل BBC، الابتسامات، والمرفقات.';
$txt['shd_admin_options_admin_desc'] = 'هنا يمكنك تعيين بعض الخيارات الإدارية العامة لمكتب المساعدة.';
$txt['shd_admin_options_standalone_desc'] = 'هذه المنطقة تدير الوضع المستقل لمكتب المساعدة، الذي يعطل بشكل فعال جزء المنتدى من تثبيت SMF.';
$txt['shd_admin_options_actionlog_desc'] = 'هذه المنطقة تسمح لك بتهيئة العناصر التي يمكن تسجيلها داخل سجل عمل مكتب المساعدة.';
$txt['shd_admin_options_notifications_desc'] = 'هذا المجال يسمح لك بتهيئة إشعارات البريد الإلكتروني التي يتم إرسالها إلى المستخدمين عند تغيير تذاكرهم.';
$txt['shd_admin_actionlog_desc'] = 'وهذه قائمة بجميع الإجراءات، مثل التذاكر التي تم حلها، والتذاكر المحررة، وأكثر من ذلك، التي تنفذ في مكتب المساعدة.';
$txt['shd_admin_adminlog_desc'] = 'هذه قائمة بجميع إجراءات المديرين، مثل تغيير الخيارات، والردود المعلبة، وتغييرات الإدارة.';
$txt['shd_admin_support_desc'] = 'سوف تساعدك هذه المنطقة على الوصول إلى SimpleDesk. و بسرعة وفعالية - ستتضمن المشاركة بعض المعلومات المفيدة لفريق الدعم، حول التثبيت الخاص بك (مثل إصدار SMF و إصدار SimpleDesk).';
$txt['shd_admin_help'] = 'هذه هي لوحة الإدارة لمكتب المساعدة. هنا يمكنك إدارة الإعدادات، والحصول على الأخبار والتحديثات حول هذا التعديل، وعرض سجلات مكتب المساعدة.';
//@}

//! @name SimpleDesk info center
//@{
$txt['shd_live_from'] = 'حي من SimpleDesk.net';
$txt['shd_no_connect'] = 'تعذر استرداد ملف الأخبار من simpledesk.net';
$txt['shd_current_version'] = 'الإصدار الحالي';
$txt['shd_your_version'] = 'الإصدار الخاص بك';
$txt['shd_mod_information'] = 'Mod Information';
$txt['shd_admin_readmore'] = 'اقرأ المزيد';
$txt['shd_admin_help_live'] = 'يعرض هذا الصندوق أحدث الأخبار والتحديثات من www.simpledesk.net. حافظ على عيونك مفتوحة للإصدارات الجديدة وإصلاح الأخطاء. إذا تم إصدار نسخة جديدة من هذا التعديل، فستشاهد أيضا إشعارا في الجزء العلوي من صفحة إدارة مكتب المساعدة.';
$txt['shd_admin_help_modification'] = 'يحتوي هذا المربع على معلومات مختلفة حول تثبيت SimpleDesk.';
$txt['shd_admin_help_credits'] = 'هذا الصندوق يسرد جميع الناس الذين جعلوا SimpleDesk ممكنة، من مطوري التعليمات البرمجية الفعلية، إلى فريق الدعم ومختبري بيتا.';
$txt['shd_admin_help_update'] = 'إذا كنت تستطيع رؤية هذا المربع، فأنت على الأرجح تستخدم نسخة قديمة من SimpleDesk. اتبع المبادئ التوجيهية الواردة في الإخطار من أجل الترقية إلى الإصدار الجديد.';
$txt['shd_ticket_information'] = 'معلومات التذكرة';
$txt['shd_total_tickets'] = 'إجمالي عدد التذاكر';
$txt['shd_open_tickets'] = 'تذاكر مفتوحة';
$txt['shd_closed_tickets'] = 'تذاكر مغلقة';
$txt['shd_recycled_tickets'] = 'التذاكر المعاد تدويرها';
$txt['shd_need_support'] = 'المساعدة مع SimpleDesk؟';
$txt['shd_support_start_here'] = 'شاهد <a href="%1$s">صفحة الدعم</a>';

$txt['shd_helpdesk_nojs'] = 'لم يتم تمكين جافا سكريبت في المتصفح الخاص بك. قد لا تعمل بعض الوظائف بشكل صحيح (أو على الإطلاق) في منطقة الإدارة.';
//@}

//! @name Translatable strings for the credits
//@{
$txt['shd_credits'] = 'رصيد المكتب البسيط';
$txt['shd_credits_and'] = 'و';
$txt['shd_credits_pretext'] = 'هؤلاء هم الأشخاص الذين جعلوا SimpleDesk ممكنًا. شكراً لك!';
$txt['shd_credits_devs'] = 'المطورين';
$txt['shd_credits_devs_desc'] = 'مطوري رمز SimpleDesk الفعلي.';
$txt['shd_credits_projectsupport'] = 'دعم المشاريع';
$txt['shd_credits_projectsupport_desc'] = 'ومن يديرون المشروع ويدعمونه بطرق مختلفة.';
$txt['shd_credits_marketing'] = 'التسويق';
$txt['shd_credits_marketing_desc'] = 'أولئك الذين ينشرون كلمة SimpleDesk.';
$txt['shd_credits_globalizer'] = 'العولمة';
$txt['shd_credits_globalizer_desc'] = 'الناس الذين يجعلون SimpleDesk ينتشرون في جميع أنحاء العالم.';
$txt['shd_credits_support'] = 'الدعم';
$txt['shd_credits_support_desc'] = 'فالناس الذين يقدمون كل الأرواح التي لا حول لهم ولا قوة ما يحتاجون إليه من دعم.';
$txt['shd_credits_qualityassurance'] = 'ضمان الجودة';
$txt['shd_credits_qualityassurance_desc'] = 'قادة فريق الاختبار التجريبي.';
$txt['shd_credits_beta'] = 'اختبار بيتا';
$txt['shd_credits_beta_desc'] = 'هؤلاء الأشخاص يتأكدون من أن SimpleDesk يرقى إلى مستوى التوقعات.';
$txt['shd_credits_alltherest'] = 'أي شخص آخر قد نفتقده...';
$txt['shd_credits_icons'] = '<a href="%1$s">فوغ</a>، <a href="%2$s">الدالة</a>، <a href="%3$s">أعلام مشاهدة الفم</a>، <a href="%4$s">مجموعات أيقونة "كريستال" Everaldo</a> - الأيقونات الجميلة المستخدمة من قبل SimpleDesk';
$txt['shd_credits_user'] = '<strong>أنت</strong>، المستخدمين الفخورين لـ SimpleDesk. شكرا لك على اختيار برنامجنا!';
$txt['shd_credits_translators'] = 'المترجمون لدينا - شكرا لك، الناس في جميع أنحاء العالم يمكنهم استخدام SimpleDesk';
$txt['shd_former_contributors'] = 'يتم تسليط الضوء على المساهمين السابقين مع <span class="shd_former_contributor">لون أكثر إشراقا</span>.';
//@}

//! @name Configuration items on the Display Options page
//@{
$txt['shd_staff_badge'] = 'ما هو نمط الشارات التي ستستخدم في عرض التذاكر؟';
$txt['shd_staff_badge_note'] = 'عند النظر إلى ردود مختلفة، قد يكون من المفيد عرض الشارات إذا كان لديك فرق مختلفة قد تستجيب في مكتب المساعدة. قد يكون من المفيد أيضا عرض شارات الأعضاء أو لا؛ هذا الخيار يتيح لك الاختيار.';
$txt['shd_staff_badge_nobadge'] = 'عرض لا شارة، مجرد أيقونة صغيرة للموظفين';
$txt['shd_staff_badge_staffbadge'] = 'عرض شارات الموظفين فقط';
$txt['shd_staff_badge_userbadge'] = 'عرض الشارات فقط من غير الموظفين/المستخدمين العاديين';
$txt['shd_staff_badge_bothbadge'] = 'عرض شارات المستخدمين والموظفين على السواء';
$txt['shd_display_avatar'] = 'عرض الصور الرمزية في الردود على التذكرة؟';
$txt['shd_ticketnav_style'] = 'ما نوع التنقل الذي سيتم استخدامه في عرض التذاكر؟';
$txt['shd_ticketnav_style_note'] = 'عند النظر إلى التذاكر، قد يكون هناك عدد من الخيارات المتاحة للمستخدمين، بما في ذلك التعديل والإغلاق والحذف. يحدد هذا الخيار الطرق المختلفة التي يمكن أن يبدو بها.';
$txt['shd_ticketnav_style_sd'] = 'نمط SimpleDesk (رمز مع ملاحظة نصية صغيرة)';
$txt['shd_ticketnav_style_sdcompact'] = 'نمط SimpleDesk (رمز فقط)';
$txt['shd_ticketnav_style_smf'] = 'نمط SMF (أزرار النص, فوق التذكرة)';
$txt['shd_theme'] = 'استخدام موضوع محدد في المنتدى؟';
$txt['shd_theme_note'] = 'عادة سيرث مكتب المساعدة السمة التي اختارها المستخدم، أو في حال فشل هذا المنتدى الافتراضي. هذا الخيار يسمح لك باختيار موضوع سيتم استخدامه دائماً في مكتب المساعدة بغض النظر عن الإعدادات الأخرى.';
$txt['shd_theme_use_default'] = 'استخدام السمة الافتراضية للمنتدى';
$txt['shd_hidemenuitem'] = 'إخفاء عنصر قائمة مكتب المساعدة؟';
$txt['shd_hidemenuitem_note'] = 'وهذا أمر مفيد للغاية إذا عرضت إدارات مكتب المساعدة في مؤشر المجلس.';
$txt['shd_hideprofilemenuitem'] = 'إخفاء عنصر قائمة الملف الشخصي لمكتب المساعدة؟';
$txt['shd_hideprofilemenuitem_note'] = 'إذا كنت تستخدم قائمة المستخدم، هذا مفيد للاختباء.';
$txt['shd_disable_unread'] = 'تعطيل التكامل مع المشاركات/الردود غير المقروءة';
$txt['shd_disable_unread_note'] = 'عادة ، يضيف SimpleDesk قائمة من المواضيع إلى صفحة الردود غير المقروءة ، ولكن في بعض الأحيان (e). . بعض المواضيع المحمولة) لا يعمل هذا دائما بشكل جيد.';
$txt['shd_zerofill'] = 'أصغر عدد من الأرقام لاستخدامها';
$txt['shd_zerofill_note'] = 'وعادة ما يتم التعبير عن أرقام التذاكر مثل 00001، وهذا سيكون 5 أرقام، ولن يكون للتذكرة 100000 أرقام إضافية. يمكنك استخدام 0 لعدم وجود أي صفر قيادي إذا أردت.';
$txt['shd_block_order_1'] = 'حظر التذاكر: الموضع الأول';
$txt['shd_block_order_2'] = 'كتلة التذاكر: الموضع الثاني';
$txt['shd_block_order_3'] = 'كتلة التذاكر: الموضع الثالث';
$txt['shd_block_order_4'] = 'كتلة التذاكر: الموضع الرابع';
$txt['shd_block_order_5'] = 'حظر التذاكر: الموضع الخامس';
$txt['shd_block_order_note'] = 'تحديد الترتيب الافتراضي للكتل';
//@}

//! @name Configuration items on the Posting Options page
//@{
$txt['shd_thank_you_post'] = 'عرض رسالة للمستخدمين عند نشر تذكرة';
$txt['shd_thank_you_nonstaff'] = 'عرض الرسالة فقط لغير الموظفين';
$txt['shd_allow_wikilinks'] = 'السماح باستخدام [[تذكرة:123]] روابط على نمط ويكي';
$txt['shd_allow_ticket_bbc'] = 'السماح للتذاكر والردود باستخدام bcode';
$txt['shd_allow_ticket_smileys'] = 'السماح للتذاكر والردود باستخدام الابتسامات';
$txt['shd_attachments_mode'] = 'كيف يجب معاملة المرفقات بالتذاكر؟';
$txt['shd_attachments_mode_ticket'] = 'كما أرفقت بالتذكرة';
$txt['shd_attachments_mode_reply'] = 'على النحو المرفق بالردود الفردية';
$txt['shd_attachments_mode_note'] = 'إذا كان استخدام وضع "للتذاكر"، فلا يوجد حد لعدد المرفقات، بينما إذا كان استخدام "للردود"، سيستخدم مكتب المساعدة نفس الإعدادات كالمرفقات العادية، بشكل افتراضي 4 إلى مشاركة فقط. كلاً من الموعدين يتحقق من حجم كل مرفق وأنه لن يملأ مجلد المرفقات الخاص بك استناداً إلى الإعدادات في لوحة المرفقات الخاصة بك.';
$txt['shd_bbc'] = 'تمكين وسوم BBC في مكتب المساعدة';
$txt['shd_bbc_desc'] = 'ما هي الوسوم التي ينبغي تفعيلها للاستخدام في مكتب المساعدة؟';
//@}

//! @name Configuration items on the Admin Options page
//@{
$txt['shd_maintenance_mode'] = 'ضع مكتب المساعدة في وضع الصيانة';
$txt['shd_staff_ticket_self'] = 'وفيما يتعلق بالتذاكر التي يفتحها الموظفون، هل يمكن إسناد التذكرة إليهم؟';
$txt['shd_admins_not_assignable'] = 'هل ينبغي اعتبار المشرفين منفصلين عن الموظفين؟';
$txt['shd_admins_not_assignable_note'] = 'إذا تم تحديده، لن يكون من الممكن تعيين مشرفي المنتديات التذاكر وسيتم استبعادهم من إضافة إرسال رسائل البريد الإلكتروني لمرة واحدة إليهم للإشعار بالرد الجديد.';
$txt['shd_privacy_display'] = 'ما هي الطريقة التي يمكن استخدامها لعرض خصوصية التذاكر؟';
$txt['shd_privacy_display_smart'] = 'عرض إعدادات الخصوصية للتذكرة عند الاقتضاء';
$txt['shd_privacy_display_always'] = 'عرض إعدادات خصوصية التذكرة دائمًا';
$txt['shd_privacy_display_note'] = 'عادة ما تقتصر التذاكر على أن يرى المستخدم نفسه ويشاهد الموظفون جميع المستخدمين. هناك مرات قد تريد من الموظفين أن يكونوا قادرين على إنشاء تذاكر فقط لكبار الموظفين لرؤيتها - هذه تذكرة "خاصة". بما أن "غير خاص" قد يكون مربكًا بالنسبة للمستخدمين العاديين، هذا الخيار يسمح لك بإخفاء عرض "غير خاص" أو "خاصة" فقط عندما يكون مناسباً على تذكرة.';
$txt['shd_disable_tickettotopic'] = 'تعطيل خيارات "التذكرة إلى الموضوع"';
$txt['shd_disable_tickettotopic_note'] = 'وعادة ما يكون من الممكن نقل التذاكر إلى المواضيع ومرة أخرى (باستثناء الوضع المستقل)، هذا الخيار يرفضه لجميع المستخدمين بغض النظر عن أي أذونات له.';
$txt['shd_disable_relationships'] = 'تعطيل العلاقات';
$txt['shd_disable_relationships_note'] = 'تعطيل التذاكر من وجود "علاقات" مع بعضها البعض، بغض النظر عن أي أذونات لها.';
$txt['shd_disable_boardint'] = 'تعطيل تكامل مؤشر البورصة';
$txt['shd_disable_boardint_note'] = 'قم بتعطيل مكتب المساعدة من التحميل على فهرس اللوحة بالكامل.';
//@}

//! @name Configuration items on the Standalone Options page
//@{
$txt['shd_helpdesk_only'] = 'تمكين وضع مكتب المساعدة فقط';
$txt['shd_helpdesk_only_note'] = 'سيؤدي هذا إلى تعطيل الوصول إلى المواضيع واللوحات، وكذلك اختياريا الميزات أدناه. لاحظ أنه لم يفقد أي من البيانات، بل أصبح مجرد خلل. الخيارات التالية تنطبق فقط عندما يكون هذا الوضع نشطاً (عندما يكون المنتدى معطلاً بشكل أساسي خارج مكتب المساعدة)';
$txt['shd_disable_pm'] = 'تعطيل الرسائل الخاصة بالكامل';
$txt['shd_disable_mlist'] = 'تعطيل قائمة الأعضاء بالكامل';
//@}

//! @name Configuration items on the Action Log Options page
//@{
$txt['shd_disable_action_log'] = 'تعطيل تسجيل إجراءات مكتب المساعدة؟';
$txt['shd_display_ticket_logs'] = 'عرض سجل عمل مصغر في كل تذكرة؟';
$txt['shd_logopt_newposts'] = 'سجل التذاكر الجديدة وردودها';
$txt['shd_logopt_editposts'] = 'سجل التعديلات على التذاكر والمشاركات';
$txt['shd_logopt_resolve'] = 'تسجيل تذاكر قيد الحل/لم يتم حلها';
$txt['shd_logopt_assign'] = 'سجل التذاكر التي يتم تعيينها/إعادة تعيينها/غير مسندة';
$txt['shd_logopt_privacy'] = 'تم تغيير خصوصية تذكرة السجل';
$txt['shd_logopt_urgency'] = 'تم تغيير الطابع الملح لتذكرة السجل';
$txt['shd_logopt_tickettopicmove'] = 'تسجيل تذاكر يتم نقلها إلى المواضيع والعودة';
$txt['shd_logopt_cfchanges'] = 'تسجيل التغييرات في الحقول المخصصة على التذاكر والردود';
$txt['shd_logopt_delete'] = 'سجل التذاكر والردود التي يتم حذفها';
$txt['shd_logopt_restore'] = 'سجل التذاكر والردود التي يتم استعادتها';
$txt['shd_logopt_permadelete'] = 'سجل التذاكر والردود التي يتم حذفها باستمرار';
$txt['shd_logopt_relationships'] = 'سجل أي تغييرات في علاقات التذاكر';
$txt['shd_logopt_autoclose'] = 'تسجيل تذاكر المغلقة تلقائياً من قبل مكتب المساعدة';
$txt['shd_logopt_move_dept'] = 'تسجيل تذاكر يتم نقلها بين قسمين';
$txt['shd_logopt_monitor'] = 'تسجيل التذاكر التي يتم إضافتها إلى قوائم الرصد / تجاهل';

$txt['shd_notify_send_to'] = 'سيتم إرسالها إلى';
$txt['shd_notify_ticket_starter'] = 'المستخدم الذي بدأ التذكرة (إذا تم تعيينه في التفضيلات)';
$txt['shd_notify_nobody'] = 'لا أحد';
//@}

//! @name Configuration items on the Notifications Options page
//@{
$txt['shd_notify_email'] = 'عنوان البريد الإلكتروني لاستخدامه في الإشعارات ، اتركه فارغا لاستخدام المنتدى الافتراضي (%1$s)';
$txt['shd_notify_log'] = 'تسجيل الإشعارات التي يتم إرسالها (ما هو الإشعار، عند الإرسال، المستخدم (المستخدمين) المعني)';
$txt['shd_notify_with_body'] = 'عند إرسال الإشعارات، إرسال تذكرة جديدة أو محتوى رد جديد في البريد الإلكتروني';
$txt['shd_notify_new_ticket'] = 'السماح للموظفين بتلقي إشعارات على التذاكر الجديدة';
$txt['shd_notify_new_reply_own'] = 'السماح للمستخدمين بتلقي إشعارات عند الرد على تذاكرهم';
$txt['shd_notify_new_reply_assigned'] = 'السماح للموظفين باستلام الإشعارات عندما يتم الرد على التذاكر المعينة لهم';
$txt['shd_notify_new_reply_previous'] = 'السماح للموظفين باستلام الإشعارات عندما يتم الرد على التذاكر مرة أخرى';
$txt['shd_notify_new_reply_any'] = 'السماح للموظفين بتلقي إشعارات عند الرد على أي تذاكر';
$txt['shd_notify_assign_me'] = 'السماح للموظفين باستلام إشعارات عند تعيين تذكرة لهم';
$txt['shd_notify_assign_own'] = 'السماح للمستخدمين بتلقي إشعارات عند تعيين تذاكرهم إلى الموظفين';
//@}

//! @name General language strings for the action log (entries are contained in SimpleDesk-LogAction.english.php)
//@{
$txt['shd_delete_item'] = 'حذف عنصر السجل هذا';
$txt['shd_admin_actionlog_title'] = 'سجل إجراءات مكتب المساعدة';
$txt['shd_admin_actionlog_action'] = 'اجراء';
$txt['shd_admin_actionlog_date'] = 'التاريخ';
$txt['shd_admin_actionlog_member'] = 'عضو';
$txt['shd_admin_actionlog_position'] = 'الموضع';
$txt['shd_admin_actionlog_ip'] = 'IP';
$txt['shd_admin_actionlog_none'] = 'لم يتم العثور على أي إدخالات.';
$txt['shd_admin_actionlog_unknown'] = 'غير معروف';
$txt['shd_admin_actionlog_hidden'] = 'Hidden';
$txt['shd_admin_actionlog_removeall'] = 'إفراغ السجل بأكمله';
$txt['shd_admin_actionlog_removeall_confirm'] = 'سيؤدي هذا إلى حذف جميع الإدخالات في سجل الإجراءات الأقدم من %s ساعة. هل أنت متأكد؟';
//@}

//! @name General language strings for the admin log
//@{
$txt['shd_admin_adminlog_title'] = 'سجل مدير مكتب المساعدة';
$txt['shd_admin_adminlog_action'] = 'اجراء';
$txt['shd_admin_adminlog_name'] = 'الاسم';
$txt['shd_admin_adminlog_to'] = 'إلى';
$txt['shd_admin_adminlog_from'] = 'من';
$txt['shd_admin_adminlog_setting'] = 'الإعدادات';
$txt['shd_log_admin_canned'] = 'الردود المسبقة';
$txt['shd_log_admin_customfield'] = 'حقول مخصصة';
$txt['shd_log_admin_maint'] = 'صيانة';
$txt['shd_log_admin_permissions'] = 'الأذونات';
$txt['shd_log_admin_plugins'] = 'الإضافات';
$txt['shd_log_admin_dept'] = 'الأقسام';
$txt['shd_log_admin_change_option'] = 'خيارات';
$txt['shd_log_admin_canned_cat_move'] = 'تصنيف مرتب';
$txt['shd_log_admin_canned_cat_delete'] = 'تم حذف الفئة';
$txt['shd_log_admin_canned_cat_add'] = 'الفئة المضافة';
$txt['shd_log_admin_canned_cat_update'] = 'تم تحديث الفئة';
$txt['shd_log_admin_canned_reply_move'] = 'تم فرز الرد';
$txt['shd_log_admin_canned_reply_delete'] = 'الرد المحذوف';
$txt['shd_log_admin_canned_reply_add'] = 'تم إضافة رد مسبق';
$txt['shd_log_admin_canned_reply_update'] = 'تحديث الرد';
$txt['shd_log_admin_dept_move'] = 'فرز';
$txt['shd_log_admin_dept_delete'] = 'محذوف';
$txt['shd_log_admin_dept_add'] = 'أضيف';
$txt['shd_log_admin_dept_update'] = 'تحديث';
$txt['shd_log_admin_customfield_move'] = 'فرز';
$txt['shd_log_admin_customfield_delete'] = 'محذوف';
$txt['shd_log_admin_customfield_add'] = 'أضيف';
$txt['shd_log_admin_customfield_update'] = 'تم التحديث';
$txt['shd_log_admin_customfield_move'] = 'فرز';
$txt['shd_log_admin_maint_reattribute'] = 'تذاكر معدلة';
$txt['shd_log_admin_maint_move_dept'] = 'نقل التذاكر إلى القسم';
$txt['shd_log_admin_maint_findrepair'] = 'البحث والإصلاح';
$txt['shd_log_admin_maint_clean_cache'] = 'تنظيف ذاكرة التخزين المؤقت';
$txt['shd_log_admin_maint_search_rebuild'] = 'إعادة بناء البحث';
$txt['shd_log_admin_permissions_create_role'] = 'أضيف';
$txt['shd_log_admin_permissions_delete_role'] = 'محذوف';
$txt['shd_log_admin_permissions_change_role'] = 'تم التحديث';
$txt['shd_log_admin_permissions_copy_role'] = 'مكرر';
$txt['shd_log_admin_plugins_update'] = 'تم التحديث';
$txt['shd_log_admin_plugins_remove'] = 'تمت الإزالة';
//@}

//! @name Strings for the post-to-SimpleDesk.net support page
//@{
$txt['shd_admin_support_form_title'] = 'نموذج الدعم';
$txt['shd_admin_support_what_is_this'] = 'ما هذا؟';
$txt['shd_admin_support_explanation'] = 'هذا النموذج البسيط سيسمح لك بإرسال طلب دعم مباشرة إلى موقع SimpleDesk على شبكة الإنترنت حتى يتمكن فريق الدعم هناك من مساعدتك في حل أي مشكلة تقوم بتشغيلها.<br><br>يرجى ملاحظة أنك ستحتاج إلى حساب على موقعنا الإلكتروني من أجل النشر وكذلك الرد على الموضوع الخاص بك في المستقبل. وسيؤدي هذا الاستمارة ببساطة إلى تسريع عملية النشر.';
$txt['shd_admin_support_send'] = 'إرسال طلب دعم';
//@}

//! @name The browse-attachments integration strings
//@{
$txt['attachment_manager_shd_attach'] = 'مرفقات مكتب المساعدة';
$txt['attachment_manager_shd_thumb'] = 'مصغرات مكتب المساعدة';
$txt['attachment_manager_shd_attach_no_entries'] = 'لا يوجد حاليا مرفقات مكتب مساعدة.';
$txt['attachment_manager_shd_thumb_no_entries'] = 'لا توجد حاليا صور مصغرة لمكتب المساعدة.';
//@}

//! @name Custom fields stuff
//@{
$txt['shd_admin_custom_fields_long'] = 'حقول مخصصة للتذاكر والردود';
$txt['shd_admin_custom_fields_desc'] = 'هذا القسم يسمح لك بإنشاء حقول إضافية يمكن إضافتها إلى التذاكر و/أو ردودها، جمع معلومات إضافية عن التذكرة أو مساعدتك في إدارة مكتب المساعدة الخاص بك.';
$txt['shd_admin_custom_fields_general'] = 'تفاصيل عامة';

$txt['shd_admin_custom_fields_fieldname'] = 'اسم الحقل';
$txt['shd_admin_custom_fields_fieldname_desc'] = 'الاسم المعروض بجوار المكان الذي سيدخل فيه المستخدم المعلومات (مطلوب)';
$txt['shd_admin_custom_fields_description'] = 'وصف الحقل';
$txt['shd_admin_custom_fields_description_desc'] = 'وصف للحقل يظهر للمستخدم عند إدخال المعلومات.';
$txt['shd_admin_custom_fields_icon'] = 'أيقونة الحقل';
$txt['shd_admin_custom_fields_icon_desc'] = 'أيقونة اختيارية معروضة بجانب اسم الحقل. لإضافة أيقونة (أيقونات خاصة)، ببساطة ضع ملف صورة في . ثيمات/افتراضي/صور/بسيط/cf/ مجلد. للحصول على أفضل النتائج، يجب أن تكون هذه صورة 13x13px png .';
$txt['shd_admin_custom_fields_fieldtype'] = 'نوع الحقل';
$txt['shd_admin_custom_fields_fieldtype_desc'] = 'نوع الحقل الذي سيكمله المستخدم بالمعلومات المطلوبة.';
$txt['shd_admin_custom_fields_active'] = 'نشط';
$txt['shd_admin_custom_fields_inactive'] = 'غير نشط';
$txt['shd_admin_custom_fields_active_desc'] = 'هذا هو تبديل رئيسي لهذا الحقل؛ إذا لم يكن نشطا، فلن يتم عرضه أو طلبه من المستخدم عند النشر.';
$txt['shd_admin_custom_fields_fielddesc'] = 'وصف الحقل';
$txt['shd_admin_custom_fields_fielddesc_desc'] = 'وصف موجز للحقل الذي تقوم بإضافته.';
$txt['shd_admin_custom_fields_visible'] = 'مرئي';
$txt['shd_admin_custom_fields_visible_ticket'] = 'مرئي/قابل للتحرير للتذكرة';
$txt['shd_admin_custom_fields_visible_field'] = 'مرئي/قابل للتحرير في الردود';
$txt['shd_admin_custom_fields_visible_both'] = 'مرئي/قابل للتحرير في كل من التذاكر والردود';
$txt['shd_admin_custom_fields_visible_desc'] = 'ويتحكم هذا فيما إذا كان مجال معين ينطبق على التذاكر فقط ككل، وعلى الردود الفردية أو كليهما وعلى التذكرة والردود عليها.';
$txt['shd_admin_custom_fields_none'] = '(لا شيء)';
$txt['shd_admin_no_custom_fields'] = 'لا توجد حقول مخصصة تم إعدادها حاليا.';
$txt['shd_admin_custom_fields_inticket'] = 'مرئي على تذكرة';
$txt['shd_admin_custom_fields_inreply'] = 'مرئي في الرد';
$txt['shd_admin_custom_fields_move'] = 'نقل';
$txt['shd_admin_move_up'] = 'تحريك للأعلى';
$txt['shd_admin_move_down'] = 'تحريك للأسفل';
$txt['shd_admin_custom_fields_ui_text'] = 'صندوق';
$txt['shd_admin_custom_fields_ui_largetext'] = 'صندوق نصي كبير';
$txt['shd_admin_custom_fields_ui_int'] = 'عدد صحيح (أعداد صحيحة)';
$txt['shd_admin_custom_fields_ui_float'] = 'أرقام عائمة (جزئية)';
$txt['shd_admin_custom_fields_ui_select'] = 'حدد من القائمة المنسدلة';
$txt['shd_admin_custom_fields_ui_checkbox'] = 'صندوق Tickbox (نعم/لا)';
$txt['shd_admin_custom_fields_ui_radio'] = 'حدد من أزرار الراديو';
$txt['shd_admin_custom_fields_ui_multi'] = 'حدد عناصر متعددة';
$txt['shd_admin_cannot_edit_custom_field'] = 'لا يمكنك تعديل هذا الحقل المخصص.';
$txt['shd_admin_cannot_move_custom_field'] = 'لا يمكنك نقل هذا الحقل المخصص.';
$txt['shd_admin_cannot_move_custom_field_up'] = 'لا يمكنك تحريك هذا الحقل المخصص إلى أعلى؛ إنه العنصر الأول بالفعل.';
$txt['shd_admin_cannot_move_custom_field_down'] = 'لا يمكنك تحريك هذا الحقل المخصص لأسفل؛ إنه العنصر الأخير بالفعل.';
$txt['shd_admin_new_custom_field'] = 'إضافة حقل جديد';
$txt['shd_admin_new_custom_field_desc'] = 'من هذا اللوحة، يمكنك إضافة حقل مخصص جديد للتذاكر الخاصة بك و/أو ردودها، وتحديد كيفية عمل هذه التذاكر لك.';
$txt['shd_admin_edit_custom_field'] = 'تعديل الحقل الموجود';
$txt['shd_admin_edit_custom_field_desc'] = 'يمكنك تعديل حقل مخصص موجود من هذا اللوحة، كما هو مبين أدناه.';
$txt['shd_admin_no_fieldname'] = 'لم تقم بتحديد أي اسم للحقل المخصص الخاص بك.';
$txt['shd_admin_could_not_create_field'] = 'فشل في إنشاء الحقل المخصص. الرجاء المحاولة مرة أخرى.';
$txt['shd_admin_default_state_on'] = 'تم التحقق';
$txt['shd_admin_default_state_off'] = 'لم يتم التحقق';
$txt['shd_admin_save_custom_field'] = 'حفظ الحقل';
$txt['shd_admin_delete_custom_field'] = 'حذف الحقل';
$txt['shd_admin_cancel_custom_field'] = 'إلغاء';
$txt['shd_admin_delete_custom_field_confirm'] = 'هل تريد حقاً حذف هذا الحقل المخصص؟ سيتم إزالة جميع القيم المخزنة لهذا الحقل، وهناك لا وظيفة التراجع.';
$txt['shd_admin_custom_field_options'] = 'خيارات';
$txt['shd_admin_custom_field_options_desc'] = 'اترك مربع الخيار فارغاً للإزالة.';
$txt['shd_admin_custom_field_options_radio'] = 'زر الراديو يحدد الخيار الافتراضي.';
$txt['shd_admin_custom_field_options_multi'] = 'مربعات الاختيار تشير إلى العناصر التي يتم تحديدها بشكل افتراضي.';
$txt['shd_admin_custom_field_no_selected_default'] = 'لا يوجد إفتراضي محدد';
$txt['shd_admin_custom_field_bbc'] = 'السماح BBC';
$txt['shd_admin_custom_field_bbc_note'] = 'لم تتم معالجة BBC للحقول المستخدمة كبادئات التذاكر.';
$txt['shd_admin_custom_field_bbc_off'] = 'BBC حاليا <a href="%s">معطل</a> في جميع أنحاء مكتب المساعدة.';
$txt['shd_admin_custom_field_default_state'] = 'الحالة الافتراضية';
$txt['shd_admin_custom_field_dimensions'] = 'الأبعاد';
$txt['shd_admin_custom_field_dimensions_rows'] = 'الصفوف';
$txt['shd_admin_custom_field_dimensions_columns'] = 'الأعمدة';
$txt['shd_admin_custom_field_maxlength'] = 'الحد الأقصى للطول';
$txt['shd_admin_custom_field_maxlength_desc'] = '(0 بدون حدود)';
$txt['shd_admin_custom_field_display_empty'] = 'عرض حتى إذا كان فارغاً';
$txt['shd_admin_custom_field_display_empty_desc'] = 'إذا تم ترك الحقل فارغاً من قبل المستخدم، هل يجب أن يستمر عرضه عند قراءة التذكرة؟';
$txt['shd_admin_custom_field_required'] = 'الحقل المطلوب';
$txt['shd_admin_custom_field_required_desc'] = 'إذا تم تحديده، يجب ملء هذا الحقل من قبل المستخدم من أجل نشر التذكرة أو الرد.';
$txt['shd_admin_custom_field_view'] = 'عرض';
$txt['shd_admin_custom_field_edit'] = 'تحرير';
$txt['shd_admin_custom_field_permissions'] = 'الأذونات';
$txt['shd_admin_custom_field_can_see'] = 'من يمكنه رؤية هذا الحقل';
$txt['shd_admin_custom_field_can_see_desc'] = 'حدد من يمكنه رؤية هذا الحقل في التذاكر.';
$txt['shd_admin_custom_field_can_edit'] = 'من يستطيع تعديل هذا الحقل';
$txt['shd_admin_custom_field_can_edit_desc'] = 'حدد من يمكنه تعديل/استخدام هذا الحقل عند النشر.';
$txt['shd_admin_custom_field_users'] = 'المستخدمون';
$txt['shd_admin_custom_field_staff'] = 'الموظفون';
$txt['shd_admin_custom_field_admins'] = 'المشرفين';
$txt['shd_admin_custom_field_placement'] = 'وضع داخل التذكرة';
$txt['shd_admin_custom_field_placement_desc'] = 'أين في التذكرة يجب عرض هذا الحقل؟ يرجى ملاحظة أن الحقول الكبيرة قد لا تتناسب بشكل جيد مع مربع "التفاصيل الإضافية"، وأن تحديد القائمة المنسدلة وأزرار الراديو فقط متاحة للاستخدام كفئات.';
$txt['shd_admin_custom_field_placement_details'] = 'تفاصيل إضافية (مربع الجانب الأيسر)';
$txt['shd_admin_custom_field_placement_information'] = 'معلومات إضافية (تحت جسم التذاكر)';
$txt['shd_admin_custom_field_placement_prefix'] = 'كبادئة إلى عنوان التذكرة';
$txt['shd_admin_custom_field_placement_prefixfilter'] = 'كفئة (قابلة للتصفية)';
$txt['shd_admin_custom_field_department'] = 'الإدارات ينطبق هذا الحقل على';
$txt['shd_admin_custom_field_dept_applies'] = 'ينطبق';
$txt['shd_admin_custom_field_dept_required'] = 'مطلوب';
$txt['shd_admin_custom_field_invalid'] = 'نوع الحقل المحدد غير صالح.';
$txt['shd_admin_custom_field_reselect_invalid'] = 'لقد حاولت تغيير هذا الحقل المخصص، ولكن إلى نوع غير متوافق مع البيانات المخزنة بالفعل لهذا الحقل، ولتفادي الإضرار بالبيانات الموجودة، تم منع هذا التغيير.';
//@}

//! Canned Replies
//@{
$txt['shd_admin_cannedreplies_home'] = 'مكتب المساعدة - الردود المسبقة';
$txt['shd_admin_cannedreplies_homedesc'] = 'هذا القسم يسمح لك بإنشاء إجابات قالب، أو كتل كود، أو الأجوبة على الأسئلة المتكررة، بحيث تكون متاحة على واجهة النشر.';
$txt['shd_admin_cannedreplies_nocats'] = 'لا توجد فئات للردود المعلّبة، سوف تحتاج إلى إنشاء واحدة أولا.';
$txt['shd_admin_cannedreplies_createcat'] = 'إنشاء فئة جديدة';
$txt['shd_admin_cannedreplies_editcat'] = 'تحرير هذا التصنيف';
$txt['shd_admin_cannedreplies_deletecat'] = 'حذف هذا التصنيف';
$txt['shd_admin_cannedreplies_categoryname'] = 'اسم الفئة';
$txt['shd_admin_cannedreplies_replyname'] = 'اسم الرد';
$txt['shd_admin_cannedreplies_isactive'] = 'نشط؟';
$txt['shd_admin_cannedreplies_visibleto'] = 'مرئي إلى';
$txt['shd_admin_cannedreplies_emptycat'] = 'لا توجد ردود مسبقة في هذه الفئة.';
$txt['shd_admin_cannedreplies_addreply'] = 'إنشاء رد جديد';
$txt['shd_admin_cannedreplies_editreply'] = 'تعديل هذا الرد';
$txt['shd_admin_cannedreplies_deletereply'] = 'حذف هذا الرد';
$txt['shd_admin_cannedreplies_delete_confirm'] = 'هل أنت متأكد من أنك تريد حذف هذه الفئة وجميع الردود عليها؟';
$txt['shd_admin_cannedreplies_deletereply_confirm'] = 'هل أنت متأكد من أنك تريد حذف هذا الرد؟';
$txt['shd_admin_cannedreplies_move_between_cat'] = 'نقل هذا الرد المعلب إلى فئة أخرى';
$txt['shd_admin_cannedreplies_cannot_move_reply'] = 'لا يمكن نقل هذا الرد.';
$txt['shd_admin_cannedreplies_cannot_move_reply_up'] = 'لا يمكن نقل هذا الرد إلى أعلى.';
$txt['shd_admin_cannedreplies_cannot_move_reply_down'] = 'لا يمكن نقل هذا الرد للأسفل.';
$txt['shd_admin_cannedreplies_cannot_move_cat'] = 'لا يمكن نقل هذه الفئة.';
$txt['shd_admin_cannedreplies_cannot_move_cat_up'] = 'لا يمكن نقل هذه الفئة إلى أعلى.';
$txt['shd_admin_cannedreplies_cannot_move_cat_down'] = 'لا يمكن نقل هذه الفئة للأسفل.';
$txt['shd_admin_cannedreplies_thecatisalie'] = 'هذه الفئة غير موجودة، لا يمكن تعديلها.';
$txt['shd_admin_cannedreplies_thereplyisalie'] = 'هذا الرد غير موجود، ولا يمكن تعديله.';
$txt['shd_admin_cannedreplies_nocatname'] = 'ولم يعط أي اسم لهذه الفئة، ويجب تقديم اسم واحد.';
$txt['shd_admin_cannedreplies_replytitle'] = 'عنوان هذا الرد المعلب';
$txt['shd_admin_cannedreplies_content'] = 'محتوى الرد المسبق';
$txt['shd_admin_cannedreplies_active'] = 'هل هذا الرد المعلب نشط؟';
$txt['shd_admin_cannedreplies_selectvisible'] = 'من هو الرد المعلب المتوفر؟';
$txt['shd_admin_cannedreplies_departments'] = 'يمكن الاطلاع على هذا الرد المسبق من الأقسام';
$txt['shd_admin_cannedreplies_notitle'] = 'ولم يعط أي حق في الحصول على هذا الرد المسبق، ولا بد من تقديم أحد.';
$txt['shd_admin_cannedreplies_nobody'] = 'ولم يقدم أي محتوى من أي شخص لهذا الرد المعلن، ويجب تقديم رد واحد.';
$txt['shd_admin_cannedreplies_notcreated'] = 'لم يتسن إنشاء الرد الجديد.';
$txt['shd_admin_cannedreplies_onlyonecat'] = 'لا يمكنك نقل هذا الرد إلى فئة أخرى، هناك فئة واحدة فقط من الردود.';
$txt['shd_admin_cannedreplies_newcategory'] = 'الفئة الجديدة التي ينبغي أن ينتمي إليها هذا الرد';
$txt['shd_admin_cannedreplies_selectcat'] = '-- اختر فئة --';
$txt['shd_admin_cannedreplies_movereply'] = 'نقل هذا الرد';
$txt['shd_admin_cannedreplies_destnoexist'] = 'الفئة التي تحاول نقل هذا الرد غير موجودة.';

//! Departments
//@{
$txt['shd_admin_departments_home'] = 'إدارات مكتب المساعدة';
$txt['shd_admin_departments_homedesc'] = 'وفي إطار بيئة مكتب المساعدة، يتم إنشاء مجال أو أكثر من المجالات المختلفة - "الإدارات" - لتنظيم التذاكر والوصول إليها.';
$txt['shd_department_name'] = 'اسم القسم';
$txt['shd_dept_boardindex'] = 'عرض على فهرس المجلس؟';
$txt['shd_dept_no_boardindex'] = 'لا تظهر على فهرس اللوحة';
$txt['shd_dept_inside_category'] = 'في فهرس اللوحة، داخل الفئة';
$txt['shd_dept_cat_before_boards'] = 'قبل جميع اللوحات في هذه الفئة';
$txt['shd_dept_cat_after_boards'] = 'بعد جميع اللوحات في هذه الفئة';
$txt['shd_roles_in_dept'] = 'الأدوار في هذه الوزارة.';
$txt['shd_create_dept'] = 'إنشاء قسم جديد';
$txt['shd_edit_dept'] = 'تعديل القسم';
$txt['shd_delete_dept'] = 'حذف القسم';
$txt['shd_delete_dept_confirm'] = 'هل تريد حقاً حذف هذه القسم؟';
$txt['shd_no_roles_in_dept'] = 'لا توجد أدوار في هذه الإدارة.';
$txt['shd_new_dept_name'] = 'اسم القسم الجديد';
$txt['shd_dept_boardindex_cat'] = 'عرض هذا القسم في فهرس اللوحة في الفئة';
$txt['shd_no_dept_name'] = 'لم يتم تحديد أي اسم للقسم.';
$txt['shd_no_category'] = 'الفئة المحددة غير موجودة. الرجاء العودة وإعادة تحميل الصفحة.';
$txt['shd_could_not_create_dept'] = 'ولم يتسن إنشاء هذه الإدارة.';
$txt['shd_must_have_dept'] = 'لا يمكنك حذف القسم الوحيد؛ يجب أن يكون هناك دائما.';
$txt['shd_dept_not_empty'] = 'لا يمكنك حذف هذه الفئة، إنها تحتوي على تذكرة واحدة على الأقل.';
$txt['shd_roles_in_dept'] = 'الأدوار داخل هذه الإدارة';
$txt['shd_roles_in_dept_desc'] = 'وفي أماكن أخرى من فريق المسؤولين، يتم إنشاء الأدوار وإعطاء القدرات. ويتحكم هذا الفريق في الأدوار التي تنطبق على هذه الإدارة، على سبيل المثال، قد ترغب في إنشاء إدارات متعددة ذات دور مشترك واحد للموظفين.';
$txt['shd_no_defined_roles'] = 'لا توجد أدوار معرفة، يرجى تكوينها من منطقة الأذونات.';
$txt['shd_assign_dept'] = 'تعيين دور/قسم';
$txt['shd_boardindex_cat_none'] = 'لا توجد فئة (لا تظهر)';
$txt['shd_boardindex_cat_where'] = 'أين في هذه الفئة يجب أن تعرض؟';
$txt['shd_boardindex_cat_before'] = 'أمام أي مجالس';
$txt['shd_boardindex_cat_after'] = 'بعد أي لوحات';
$txt['shd_dept_description'] = 'الوصف';
$txt['shd_admin_cannot_move_dept'] = 'لا يمكنك نقل تلك القسم.';
$txt['shd_admin_cannot_move_dept_up'] = 'لا يمكنك نقل هذا القسم إلى أعلى؛ هذا هو العنصر الأول بالفعل.';
$txt['shd_admin_cannot_move_dept_down'] = 'لا يمكنك نقل هذا القسم إلى الأسفل؛ هذا هو العنصر الأخير بالفعل.';
$txt['shd_dept_theme'] = 'استخدام سمة محددة في هذه القسم؟';
$txt['shd_dept_theme_note'] = 'يمكنك تعيين موضوع لمكتب المساعدة يختلف عن الموضوع الرئيسي للمنتدى. يتيح لك هذا الإعداد تجاوز مكتب المساعدة أو موضوع المنتدى داخل هذه الإدارة فقط، ربما لعلامة تجارية خاصة بالإدارة.';
$txt['shd_dept_theme_use_default'] = 'استخدم السمة الافتراضية لمكتب المساعدة/المنتدى';
$txt['shd_dept_autoclose_days'] = 'عدد الأيام التي سيتم بعدها إغلاق تذكرة تلقائياً؟';
$txt['shd_dept_autoclose_days_note'] = 'استخدم 0 للإشارة إلى أن التذاكر في هذا القسم لا ينبغي أبداً أن تكون مغلقة تلقائياً، بغض النظر عن عمرها.';
//@}

//! Plugins
//@{
$txt['sdplugin_package'] = 'SimpleDesk Plugins';
$txt['shd_install_plugin'] = 'تثبيت الإضافة';
$txt['shd_admin_plugins_homedesc'] = 'هذه المنطقة تسمح لك بإدارة أي مكونات إضافية لـ SimpleDesk. يتم تثبيتها من خلال مدير الحزمة كمورد عادي، ويتم تكوينها من هنا.';
$txt['shd_admin_plugins_none'] = 'لا توجد إضافات مثبتة حاليا.';
$txt['shd_admin_plugins_writtenby'] = 'كتب من قبل';
$txt['shd_admin_plugins_website'] = 'الموقع';
$txt['shd_admin_plugins_wrong_version'] = 'غير مدعوم بهذا الإصدار!';
$txt['shd_admin_plugins_versions_avail'] = 'مدعوم من البرنامج المساعد';
$txt['shd_admin_plugins_on'] = 'تشغيل';
$txt['shd_admin_plugins_off'] = 'متوقف';
 $txt['shd_admin_plugins_enabled'] = 'تمكين';
$txt['shd_admin_plugins_disabled'] = 'معطل';
$txt['shd_admin_plugins_languages'] = 'اللغات المتاحة';
$txt['shd_admin_plugins_lang_albanian'] = 'الألبانية';
$txt['shd_admin_plugins_lang_arabic'] = 'العربية';
$txt['shd_admin_plugins_lang_bangla'] = 'البنغالية';
$txt['shd_admin_plugins_lang_bulgarian'] = 'البلغاري';
$txt['shd_admin_plugins_lang_catalan'] = 'الكاتالونية';
$txt['shd_admin_plugins_lang_chinese_simplified'] = 'الصينية (مبسطة)';
$txt['shd_admin_plugins_lang_chinese_traditional'] = 'الصينية (التقليدية)';
$txt['shd_admin_plugins_lang_croatian'] = 'الكرواتية';
$txt['shd_admin_plugins_lang_czech'] = 'التشيكية';
$txt['shd_admin_plugins_lang_danish'] = 'الدانماركية';
$txt['shd_admin_plugins_lang_dutch'] = 'الهولندية';
$txt['shd_admin_plugins_lang_english'] = 'الإنكليزية (الولايات المتحدة)';
$txt['shd_admin_plugins_lang_english_british'] = 'الإنكليزية (المملكة المتحدة)';
$txt['shd_admin_plugins_lang_finnish'] = 'الفنلندية';
$txt['shd_admin_plugins_lang_french'] = 'الفرنسية';
$txt['shd_admin_plugins_lang_galician'] = 'غاليسيون';
$txt['shd_admin_plugins_lang_german'] = 'الألمانية';
$txt['shd_admin_plugins_lang_hebrew'] = 'العبرية';
$txt['shd_admin_plugins_lang_hindi'] = 'الهندية';
$txt['shd_admin_plugins_lang_hungarian'] = 'الهنغارية';
$txt['shd_admin_plugins_lang_indonesian'] = 'الإندونيسية';
$txt['shd_admin_plugins_lang_italian'] = 'الإيطالية';
$txt['shd_admin_plugins_lang_japanese'] = 'يابانية';
$txt['shd_admin_plugins_lang_kurdish_kurmanji'] = 'الكردية (كرمانجي)';
$txt['shd_admin_plugins_lang_kurdish_sorani'] = 'الكردية (سوراني)';
$txt['shd_admin_plugins_lang_macedonian'] = 'مقدونية';
$txt['shd_admin_plugins_lang_malay'] = 'الملايو';
$txt['shd_admin_plugins_lang_norwegian'] = 'النرويجية';
$txt['shd_admin_plugins_lang_persian'] = 'الفارسية';
$txt['shd_admin_plugins_lang_polish'] = 'البولندية';
$txt['shd_admin_plugins_lang_portuguese_brazilian'] = 'البرتغالية (البرازيلية)';
$txt['shd_admin_plugins_lang_portuguese_pt'] = 'البرتغالية';
$txt['shd_admin_plugins_lang_romanian'] = 'الرومانية';
$txt['shd_admin_plugins_lang_russian'] = 'الروسية';
$txt['shd_admin_plugins_lang_serbian_cyrillic'] = 'الصربية (السيريلية)';
$txt['shd_admin_plugins_lang_serbian_latin'] = 'Serbian (Latin)';
$txt['shd_admin_plugins_lang_slovak'] = 'السلوفاكية';
$txt['shd_admin_plugins_lang_spanish_es'] = 'الإسبانية (إسبانيا)';
$txt['shd_admin_plugins_lang_spanish_latin'] = 'الإسبانية (اللاتينية)';
$txt['shd_admin_plugins_lang_swedish'] = 'السويدية';
$txt['shd_admin_plugins_lang_thai'] = 'التايلندية';
$txt['shd_admin_plugins_lang_turkish'] = 'تركية';
$txt['shd_admin_plugins_lang_ukrainian'] = 'أوكراني';
$txt['shd_admin_plugins_lang_urdu'] = 'الأردو';
$txt['shd_admin_plugins_lang_uzbek_latin'] = 'Uzbek (Latin)';
$txt['shd_admin_plugins_lang_vietnamese'] = 'Vietnamese';
//@}

//! Maintenance
//@{
$txt['shd_admin_maint_back'] = 'العودة إلى صيانة مكتب المساعدة';
$txt['shd_admin_maint_desc'] = 'هذه المنطقة تسمح لك بأداء بعض مهام الصيانة العامة داخل SimpleDesk.';

$txt['shd_admin_maint_reattribute'] = 'إعادة تسمية مشاركات المستخدم';
$txt['shd_admin_maint_reattribute_desc'] = 'إذا تم إزالة حساب المستخدم، فهذا يسمح بإعادة الانضمام إلى التذاكر من حسابهم القديم مع حسابهم الجديد.';
$txt['shd_admin_maint_reattribute_posts_made'] = 'إعادة إسناد التذاكر والردود المقدمة من:';
$txt['shd_admin_maint_reattribute_posts_user'] = 'اسم المستخدم هذا';
$txt['shd_admin_maint_reattribute_posts_email'] = 'عنوان البريد الإلكتروني هذا';
$txt['shd_admin_maint_reattribute_posts_starter'] = 'مشغل التذاكر';
$txt['shd_admin_maint_reattribute_posts_to'] = 'وإرفاقهم بحساب المستخدم هذا:';
$txt['shd_admin_maint_reattribute_btn'] = 'إعادة إسناد الآن';
$txt['shd_admin_maint_reattribute_success'] = 'تمت إعادة تصنيف جميع التذاكر والمشاركات التي يمكن العثور عليها. ربما يجب عليك تشغيل خيار الصيانة "العثور على الأخطاء وإصلاحها" من داخل صيانة مكتب المساعدة الآن. (وإلا، قد لا تظهر بعض التذاكر بشكل صحيح.)';
$txt['shd_reattribute_confirm'] = 'هل أنت متأكد من أنك تريد أن تسند جميع التذاكر والردود (من الحساب المحذوف سابقاً) مع %type% من "%find%" إلى العضو"%member_to%"؟';
$txt['shd_reattribute_confirm_starter'] = 'هل أنت متأكد من أنك تريد أن تسند جميع بدء التذاكر من "%find%" إلى العضو "%member_to%"؟';
$txt['shd_reattribute_confirm_username'] = 'اسم مستخدم';
$txt['shd_reattribute_confirm_email'] = 'عنوان بريد إلكتروني';
$txt['shd_reattribute_cannot_find_member'] = 'لم يتمكن مكتب المساعدة من العثور على المستخدم لإعادة صياغة التذاكر والردود عليها.';
$txt[''] = 'لم يتمكن مكتب المساعدة من العثور على المستخدم الأصلي لإعادة سمات التذاكر والردود عليها.';
$txt['shd_reattribute_no_email'] = 'لم يتم توفير أي عنوان بريد إلكتروني.';
$txt['shd_reattribute_no_user'] = 'لم يتم توفير أي اسم مستخدم.';
$txt['shd_reattribute_no_messages'] = 'لم يتم العثور على أي رسائل تمت إعادة إسنادها.';
$txt['shd_reattribute_in_use'] = 'والرسائل الوحيدة التي تبيَّن إعادة إسنادها جميعها مدرجة ضد مستخدم حالي، وبالتالي لا يمكن إعادة إسناد المزيد من هذه الرسائل.';

$txt['shd_admin_maint_massdeptmove'] = 'نقل التذاكر';
$txt['shd_admin_maint_massdeptmove_desc'] = 'هذه المنطقة تسمح لك بنقل التذاكر بين الأقسام.';
$txt['shd_admin_maint_massdeptmove_select'] = '(اختر القسم)';
$txt['shd_admin_maint_massdeptmove_from'] = 'نقل التذاكر من';
$txt['shd_admin_maint_massdeptmove_to'] = 'إلى';
$txt['shd_admin_maint_massdeptmove_success'] = 'تم نقل جميع التذاكر المطابقة بنجاح إلى القسم الجديد الخاص بها.';
$txt['shd_admin_maint_massdeptmove_samedept'] = 'يجب عليك تحديد أقسام مختلفة للبدء والمقصد لنقل التذاكر إلى.';
$txt['shd_admin_maint_massdeptmove_open'] = 'نقل التذاكر المفتوحة/المعلقة من هذا القسم';
$txt['shd_admin_maint_massdeptmove_closed'] = 'نقل التذاكر المغلقة من هذا القسم';
$txt['shd_admin_maint_massdeptmove_deleted'] = 'نقل التذاكر المحذوفة من هذا القسم';
$txt['shd_admin_maint_massdeptmove_lastupd_less'] = 'يجب أن تكون التذاكر قد تم تحديثها آخر مرة في الأيام %1$s الأخيرة';
$txt['shd_admin_maint_massdeptmove_lastupd_more'] = 'التذاكر يجب أن تكون آخر تحديث منذ أكثر من %1$s أيام';

$txt['shd_admin_maint_findrepair'] = 'العثور على الأخطاء وإصلاحها';
$txt['shd_admin_maint_findrepair_desc'] = 'في بعض الأحيان، مهما كان ذلك غير محتمل، تصبح الأشياء خارج نطاق قاعدة البيانات. وتقوم هذه العملية بالتحقق من سلامة قاعدة البيانات وتحاول إصلاح أي أخطاء تواجهها.';

$txt['shd_admin_maint_findrepair_status'] = 'إعادة حساب عدد التذاكر...';
$txt['shd_admin_maint_findrepair_firstlast'] = 'إعادة حساب التذكرة أولاً/آخر جمعيات...';
$txt['shd_admin_maint_findrepair_starterupdater'] = 'إعادة حساب بدء التذكرة وتحديث آخر مرة بواسطة الجمعيات...';

$txt['shd_admin_recovered_dept'] = 'التذاكر المستردة';
$txt['shd_admin_recovered_dept_desc'] = 'هذه تذاكر كانت بشكل ما خارج الإدارات الموجودة. يمكنك نقلهم إلى أقسام حقيقية، ويجب عليك حذف هذا القسم عندما يكون فارغاً.';

$txt['shd_maint_zero_tickets'] = 'تم العثور على %1$d تذكرة (تذكرات) بمعرفات غير صالحة، تم إعطاؤها جميعها معارف جديدة، أرقام المعرف التالية.';
$txt['shd_maint_zero_msgs'] = 'تم العثور على %1$d مشاركات التذاكر بمعرفات غير صالحة، تم منحها جميعها معارف جديدة، أرقام المعرف التالية المتاحة.';
$txt['shd_maint_deleted'] = '%1$d تذكرة (تذكرات) لها عددٌ غير صحيح لعدد المشاركات و/أو الوظائف المحذوفة. تم إعادة حسابها.';
$txt['shd_maint_first_last'] = '%1$d تذكرة (تذكرات) لها رسائل غير صحيحة تم تعليمها لمحتوى التذكرة، أو ردها الأخير. تم تصحيح كل ذلك.';
$txt['shd_maint_status'] = '%1$d تذكرة (تذكرات) لديها حالة خاطئة تم تصحيحها.';
$txt['shd_maint_starter_updater'] = '%1$d تذكرة (تذكرات) كان المستخدم الخاطئ مدرجا كشخص قام بفتح التذكرة أو آخر شخص لتحديث التذكرة. وقد تم تصحيح جميع هذه الأمور.';
$txt['shd_maint_invalid_dept'] = '%1$d تذكرة (تذكرات) مدرجة على أنها موجودة في أقسام غير موجودة، تم نقلها جميعها إلى قسم جديد بعنوان "تذاكر استرداد".';

$txt['shd_maint_search_settings'] = 'إعدادات البحث';
$txt['shd_maint_search_settings_desc'] = 'هذه الصفحة تسمح لك بتهيئة كيفية إجراء البحث عن التذاكر، وإذا لزم الأمر، إعادة بناء الفهرس المستخدم لإجراء البحث.';
$txt['shd_maint_rebuild_index'] = 'إعادة إنشاء فهرس البحث';
$txt['shd_maint_rebuild_index_desc'] = 'إذا كان لديك تذاكر موجودة في مكان قريب قبل تقديم مرفق البحث. أو تقوم بتغيير الإعدادات أدناه، ستحتاج <strong>إلى</strong> لإعادة بناء الفهرس بعد ذلك. والفهرس هو ما يستخدم ماديا للبحث، وإذا كان إعداد الفهرس المادي مختلفا عن كيفية إجراء البحوث، ستجد البحث غير قابل للبقاء تماما.<br><strong>هام:</strong> بناء فهرس البحث مهمة مكثفة جدا. سوف يستغرق تنفيذها بعض الوقت، ومن فضلك اترك هذه النافذة مفتوحة.';
$txt['shd_maint_search_settings_warning'] = 'إذا قمت بتغيير هذه الإعدادات، سوف تحتاج إلى إعادة بناء فهرس البحث.';
$txt['shd_search_min_size'] = 'الحد الأدنى لعدد الحروف التي تعتبر كلمة (3-15)';
$txt['shd_search_max_size'] = 'الحد الأقصى لعدد الحروف التي تعتبر كلمة (3-15)';
$txt['shd_search_prefix_size'] = 'الحد الأدنى لعدد الحروف لاستخدامها في البادئة البحث<div class="smalltext">(0 = معطل)</div>';
$txt['shd_search_prefix_size_help'] = 'البحث عن البادئة هو المكان الذي يتم فيه بناء الفهرس للسماح بمطابقة الكلمات الجزئية. على سبيل المثال، البحث عن &quot;المشي&quot; سوف يعيد النتائج مثل &quot;المشي&quot; أو &quot;المشي&quot;. يتم تعطيله بشكل افتراضي لأنه يجعل الفهرس أكبر بكثير، ويصبح البحث أبطأ نتيجة لذلك.';
$txt['shd_search_charset'] = 'الأحرف التي تعتبر أجزاء صحيحة من الكلمات للبحث عنها.';
$txt['shd_search_rebuilt'] = 'تم إعادة بناء فهرس البحث.';
//@}

/**
 *	@ignore
 *	Warning: He may bite.
*/
//! Ignore
//@{
$txt['shd_fluffy'] = 'الحارس على <span %s>ملفات تعريف الارتباط</span>';
//@}