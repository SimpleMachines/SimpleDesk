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
$txt['core_settings_item_shd'] = '服务台';
$txt['core_settings_item_shd_desc'] = '售后支持中心提供用户服务台区域，从而将您的论坛扩展到服务业。';
//@}

//! @name Items for general SMF/ACP integration
//@{
$txt['errortype_simpledesk'] = 'SimpleDesk';
$txt['errortype_simpledesk_desc'] = '最可能与SimpleDesk有关的错误。请在www.simpledesk.net上报告任何此类错误。';
$txt['errortype_sdplugin'] = 'SimpleDesk 插件';
$txt['errortype_sdplugin_desc'] = '错误很可能与SimpleDesk插件有关。 文件名通常应指明插件，以便您可以检查作者是谁。';
$txt['scheduled_task_simpledesk'] = '简单桌面每日维修';
$txt['scheduled_task_desc_simpledesk'] = '为SimpleDesk每天运行的维护任务和内部处理。强烈建议不要禁用此任务。';

$txt['lang_file_desc_SimpleDesk'] = '主要售后支持中心';
$txt['lang_file_desc_SimpleDeskAdmin'] = '服务台管理';
$txt['lang_file_desc_SimpleDeskLogAction'] = '操作日志条目';
$txt['lang_file_desc_SimpleDeskNotifications'] = '电子邮件通知';
$txt['lang_file_desc_SimpleDeskPermissions'] = '权限';
$txt['lang_file_desc_SimpleDeskProfile'] = '配置文件区域';
$txt['lang_file_desc_SimpleDeskWho'] = '谁在线';
//@}

//! @name Items for the administration menu structure
//@{
// Admin menu items, the ones that aren't in SimpleDesk.english.php anyway...
$txt['shd_admin_standalone_options'] = '独立模式';
$txt['shd_admin_actionlog'] = '操作日志';
$txt['shd_admin_adminlog'] = '管理员日志';
$txt['shd_admin_support'] = '支持';
$txt['shd_admin_helpdesklog'] = '服务台日志';

$txt['shd_admin_options_display'] = '显示选项';
$txt['shd_admin_options_posting'] = '发布选项';
$txt['shd_admin_options_admin'] = '管理选项';
$txt['shd_admin_options_standalone'] = '独立选项';
$txt['shd_admin_options_actionlog'] = '操作日志选项';
$txt['shd_admin_options_notifications'] = '通知选项';
//@}

//! @name Descriptions for the page items.
//@{
$txt['shd_admin_info_desc'] = '这是由SimpleDesk驱动的服务台的信息中心。在这里您可以获得最新消息和特定版本的支持。';
$txt['shd_admin_options_desc'] = '这是服务台的一般配置区域，在这里可以配置一些基本选项。';
$txt['shd_admin_options_display_desc'] = '在这个领域，您可以更改一些设置来编辑您的服务台显示。';
$txt['shd_admin_options_posting_desc'] = '您可以在这里编辑发布设置，如BBC、笑脸和附件。';
$txt['shd_admin_options_admin_desc'] = '这里您可以设置一些一般的管理选项来管理服务台。';
$txt['shd_admin_options_standalone_desc'] = '此区域管理服务台的独立模式，有效地禁用SMF安装的论坛部分。';
$txt['shd_admin_options_actionlog_desc'] = '此区域允许您配置哪些项目可以在售后支持中心操作日志中登录。';
$txt['shd_admin_options_notifications_desc'] = '此区域允许您在用户工单更改时配置发送给他们的电子邮件通知。';
$txt['shd_admin_actionlog_desc'] = '这是在服务台进行的所有动作列表，如已解决的工单、已编辑工单和其他动作。';
$txt['shd_admin_adminlog_desc'] = '这是所有管理员操作的列表，如更改选项、预设回复、部门变更。';
$txt['shd_admin_support_desc'] = '这个领域将帮助你穿过SimpleDesk。 等快速有效的-该帖子将包含一些有助于我们的支持团队的关于您安装的信息(如SMF 版本和SimpleDesk版本)。';
$txt['shd_admin_help'] = '这是服务台的管理面板。在这里您可以管理设置，获取关于此修改的新闻和更新，以及查看服务台日志。';
//@}

//! @name SimpleDesk info center
//@{
$txt['shd_live_from'] = '从SimpleDesk.net 直播中';
$txt['shd_no_connect'] = '无法从simpledesk.net 获取新闻文件';
$txt['shd_current_version'] = '当前版本';
$txt['shd_your_version'] = '您的版本';
$txt['shd_mod_information'] = 'Mod Information';
$txt['shd_admin_readmore'] = '阅读更多';
$txt['shd_admin_help_live'] = '此框显示来自www.simpledesk.net的最新消息和更新。请打开您的眼睛以获取新版本和错误修复。 如果此修改的新版本被发布，您也会在售后支持中心管理页面顶部看到通知。';
$txt['shd_admin_help_modification'] = '此框包含关于您安装SimpleDesk的各种信息。';
$txt['shd_admin_help_credits'] = '这个方框列出了所有使简单台成为可能的人。 从实际代码的开发者到支持团队和测试员。';
$txt['shd_admin_help_update'] = '如果你可以看到这个框，你很可能使用过时的SimpleDesk版本。 遵循通知中的准则以便升级到新的版本。';
$txt['shd_ticket_information'] = '工单信息';
$txt['shd_total_tickets'] = '工单总数';
$txt['shd_open_tickets'] = '打开工单';
$txt['shd_closed_tickets'] = '已关闭的工单';
$txt['shd_recycled_tickets'] = '回收票';
$txt['shd_need_support'] = '帮助SimpleDesk？';
$txt['shd_support_start_here'] = '查看我们的 <a href="%1$s">支持页面</a>';

$txt['shd_helpdesk_nojs'] = 'JavaScript 未在您的浏览器中启用。有些功能可能无法正常工作(或根本无法正常工作)。';
//@}

//! @name Translatable strings for the credits
//@{
$txt['shd_credits'] = '简单桌面积分';
$txt['shd_credits_and'] = '和';
$txt['shd_credits_pretext'] = '这些人使简单的服务台成为可能。谢谢！';
$txt['shd_credits_devs'] = '开发者';
$txt['shd_credits_devs_desc'] = '实际的 SimpleDesk 代码的开发者。';
$txt['shd_credits_projectsupport'] = '项目支持';
$txt['shd_credits_projectsupport_desc'] = '那些以不同方式管理和支持项目的人。';
$txt['shd_credits_marketing'] = '营销活动';
$txt['shd_credits_marketing_desc'] = '那些散播SimpleDesk词的人。';
$txt['shd_credits_globalizer'] = '全球化';
$txt['shd_credits_globalizer_desc'] = '建立SimpleDesks的人遍布全世界。';
$txt['shd_credits_support'] = '支持';
$txt['shd_credits_support_desc'] = '向所有无助的人提供他们所需要的支持。';
$txt['shd_credits_qualityassurance'] = '质量保证';
$txt['shd_credits_qualityassurance_desc'] = 'Beta测试队的领导人。';
$txt['shd_credits_beta'] = '测试员';
$txt['shd_credits_beta_desc'] = '这些人确保SimpleDesks不辜负人们的期望。';
$txt['shd_credits_alltherest'] = '任何其他我们可能错过了...';
$txt['shd_credits_icons'] = '<a href="%1$s">Fangue</a>, <a href="%2$s">函数</a>, <a href="%3$s">FamFamFam 标志</a>, , , <a href="%4$s">Everaldo 的 "Crystal"</a> 图标集 - SimpleDesk 使用的精致图标';
$txt['shd_credits_user'] = '<strong>你的</strong>, SimpleDesk 的自豪用户。谢谢你选择我们的软件！';
$txt['shd_credits_translators'] = '我们的翻译者 - 感谢您，世界各地的人都可以使用 SimpleDesk';
$txt['shd_former_contributors'] = '先前的贡献者会以 <span class="shd_former_contributor">更亮的颜色</span> 突出显示。';
//@}

//! @name Configuration items on the Display Options page
//@{
$txt['shd_staff_badge'] = '在工单视图中使用哪种徽章风格？';
$txt['shd_staff_badge_note'] = '当查看不同的回复时，如果您有不同的团队可能在服务台上做出响应，则显示徽章可能会有帮助。 显示会员自己的徽章或许也是有用的；此选项允许您选择。';
$txt['shd_staff_badge_nobadge'] = '不显示徽章，只是工作人员的一个小图标';
$txt['shd_staff_badge_staffbadge'] = '仅显示员工徽章';
$txt['shd_staff_badge_userbadge'] = '仅显示非员工/普通用户的徽章';
$txt['shd_staff_badge_bothbadge'] = '显示用户和员工的徽章';
$txt['shd_display_avatar'] = '在回复工单时显示头像吗？';
$txt['shd_ticketnav_style'] = '在工单视图中使用哪种导航类型？';
$txt['shd_ticketnav_style_note'] = '当查看工单时，用户可能有若干选项，包括编辑、关闭和删除。 此选项指定了它可以看起来的不同方式。';
$txt['shd_ticketnav_style_sd'] = 'SimpleDesk样式(带小文本笔记的图标)';
$txt['shd_ticketnav_style_sdcompact'] = 'SimpleDesk样式(仅图标)';
$txt['shd_ticketnav_style_smf'] = 'SMF 样式 (工单上方的文本按钮)';
$txt['shd_theme'] = '在论坛中使用一个特定主题？';
$txt['shd_theme_note'] = '通常情况下，售后支持中心将继承用户选择的主题或论坛默认设置失败。 此选项允许您选择一个主题，无论其他设置如何，都会在售后支持中心使用。';
$txt['shd_theme_use_default'] = '使用论坛默认主题';
$txt['shd_hidemenuitem'] = '隐藏服务台菜单项？';
$txt['shd_hidemenuitem_note'] = '如果服务台各部门被列入委员会索引，这将是最有用的。';
$txt['shd_hideprofilemenuitem'] = '隐藏服务台配置文件菜单项？';
$txt['shd_hideprofilemenuitem_note'] = '如果您正在使用用户菜单，这将会被隐藏。';
$txt['shd_disable_unread'] = '禁用与未读帖子/未读回复的集成';
$txt['shd_disable_unread_note'] = '通常情况下，SimpleDesk 会在未读帖子/未读回复页面增加一个主题列表，但有时会增加(e)。 ……某些移动主题的效果并不总是那么好。';
$txt['shd_zerofill'] = '最少要使用的数字';
$txt['shd_zerofill_note'] = '工单编号通常表示为 00001, 这将是5位数字，工单100 000没有额外数字。 如果您喜欢，您可以使用 0 不拥有任何前导零。';
$txt['shd_block_order_1'] = '工单区块：第一个位置';
$txt['shd_block_order_2'] = '工单区块：第二个位置';
$txt['shd_block_order_3'] = '工单区块：第三个位置';
$txt['shd_block_order_4'] = '工单区块：第四个位置';
$txt['shd_block_order_5'] = '工单区块：第5个位置';
$txt['shd_block_order_note'] = '指定块的默认顺序';
//@}

//! @name Configuration items on the Posting Options page
//@{
$txt['shd_thank_you_post'] = '在发布工单时向用户显示一条消息';
$txt['shd_thank_you_nonstaff'] = '仅向非员工显示消息';
$txt['shd_allow_wikilinks'] = '允许使用 [[ticket:123]] 维基样式链接';
$txt['shd_allow_ticket_bbc'] = '允许工单和回复使用 bbcode';
$txt['shd_allow_ticket_smileys'] = '允许工单和回复使用表情符号';
$txt['shd_attachments_mode'] = '如何处理工单的附件？';
$txt['shd_attachments_mode_ticket'] = '作为工单的附件';
$txt['shd_attachments_mode_reply'] = '附于个人答复';
$txt['shd_attachments_mode_note'] = '如果使用 "to ticket" 模式, 附件的数量没有限制, 如果使用 "to replies", 售后支持中心将使用与普通附件相同的设置，默认情况下只有一个帖子。 这两种模式都检查每个附件的大小，并且不会根据附件面板中的设置填充您的附件文件夹。';
$txt['shd_bbc'] = '在售后支持中心启用BBC标签';
$txt['shd_bbc_desc'] = '在售后支持中心启用什么标签？';
//@}

//! @name Configuration items on the Admin Options page
//@{
$txt['shd_maintenance_mode'] = '将服务台置于维护模式';
$txt['shd_staff_ticket_self'] = '对于工作人员开出的机票，是否有可能给他们分配机票？';
$txt['shd_admins_not_assignable'] = '是否应将管理员视为与工作人员分开？';
$txt['shd_admins_not_assignable_note'] = '如果选择， 论坛管理员将无法被分配到工单，并且将被排除在向他们发送一次性邮件以通知新回复。';
$txt['shd_privacy_display'] = '用什么方法显示工单隐私？';
$txt['shd_privacy_display_smart'] = '适当时显示工单的隐私设置';
$txt['shd_privacy_display_always'] = '总是显示工单的隐私设置';
$txt['shd_privacy_display_note'] = '通常，工单仅限于用户查看自己的用户和员工查看所有用户。 有时候你可能希望工作人员只能为高级工作人员创建工单——这是一个“私人”工单。 因为“非私人”可能对普通用户造成混淆， 此选项允许您隐藏“非私有”或“私有”显示仅在工单上适当时才显示。';
$txt['shd_disable_tickettotopic'] = '禁用“任务单到主题”选项';
$txt['shd_disable_tickettotopic_note'] = '通常情况下，可以将工单移动到主题上，然后再次返回(独立模式除外)， 此选项不允许所有用户使用它，无论它是否有任何权限。';
$txt['shd_disable_relationships'] = '禁用关系';
$txt['shd_disable_relationships_note'] = '禁用工单不具有彼此之间的“关系”，不管它是否有任何权限。';
$txt['shd_disable_boardint'] = '禁用板索引集成';
$txt['shd_disable_boardint_note'] = '完全禁用售后支持中心在板上加载。';
//@}

//! @name Configuration items on the Standalone Options page
//@{
$txt['shd_helpdesk_only'] = '仅启用售后支持中心模式';
$txt['shd_helpdesk_only_note'] = '这将禁用对主题和板的访问以及下面的可选功能。 请注意，没有任何数据丢失，只是变得不活跃。 以下选项仅适用于此模式激活时(当论坛基本禁用在服务台之外)';
$txt['shd_disable_pm'] = '完全禁用私信';
$txt['shd_disable_mlist'] = '完全禁用成员列表';
//@}

//! @name Configuration items on the Action Log Options page
//@{
$txt['shd_disable_action_log'] = '禁用记录服务台操作？';
$txt['shd_display_ticket_logs'] = '在每个工单中显示一个小操作日志？';
$txt['shd_logopt_newposts'] = '记录新工单和他们的回复';
$txt['shd_logopt_editposts'] = '登录到工单和帖子';
$txt['shd_logopt_resolve'] = '记录工单正在解决/未解决';
$txt['shd_logopt_assign'] = '记录工单分配/重新分配/未分配';
$txt['shd_logopt_privacy'] = '日志服务单隐私正在更改';
$txt['shd_logopt_urgency'] = '正在更改记录工单的紧急性';
$txt['shd_logopt_tickettopicmove'] = '记录正在移动到主题并返回的工单';
$txt['shd_logopt_cfchanges'] = '在工单和回复中记录对自定义字段的更改';
$txt['shd_logopt_delete'] = '记录工单和正在删除的回复';
$txt['shd_logopt_restore'] = '记录工单和回复正在恢复';
$txt['shd_logopt_permadelete'] = '记录工单和正在永久删除的回复';
$txt['shd_logopt_relationships'] = '记录工单关系中的任何更改';
$txt['shd_logopt_autoclose'] = '服务台自动关闭记录服务单';
$txt['shd_logopt_move_dept'] = '记录两个部门之间正在移动的工单';
$txt['shd_logopt_monitor'] = '记录正在添加到显示器/忽略列表中的工单';

$txt['shd_notify_send_to'] = '将被发送到';
$txt['shd_notify_ticket_starter'] = '启动工单的用户 (如果设置在其首选项中)';
$txt['shd_notify_nobody'] = '没有人';
//@}

//! @name Configuration items on the Notifications Options page
//@{
$txt['shd_notify_email'] = '在通知中使用的电子邮件地址，留空以使用论坛默认值(%1$s)';
$txt['shd_notify_log'] = '记录正在发送的通知 (发送的通知，用户参与)';
$txt['shd_notify_with_body'] = '发送通知时，在电子邮件中发送新工单或新回复内容';
$txt['shd_notify_new_ticket'] = '允许员工在新工单上接收通知';
$txt['shd_notify_new_reply_own'] = '允许用户在回复工单时接收通知';
$txt['shd_notify_new_reply_assigned'] = '当分配给员工的工单被回复时，允许员工接收通知';
$txt['shd_notify_new_reply_previous'] = '允许员工在回复工单时收到通知，然后再次回复';
$txt['shd_notify_new_reply_any'] = '允许工作人员在回复任何工单时接收通知';
$txt['shd_notify_assign_me'] = '当工单被分配给员工时，允许员工接收通知';
$txt['shd_notify_assign_own'] = '允许用户在他们的工单被分配给员工时接收通知';
//@}

//! @name General language strings for the action log (entries are contained in SimpleDesk-LogAction.english.php)
//@{
$txt['shd_delete_item'] = '删除此日志项';
$txt['shd_admin_actionlog_title'] = '服务台行动日志';
$txt['shd_admin_actionlog_action'] = '行 动';
$txt['shd_admin_actionlog_date'] = '日期';
$txt['shd_admin_actionlog_member'] = '成员';
$txt['shd_admin_actionlog_position'] = '位置';
$txt['shd_admin_actionlog_ip'] = 'IP';
$txt['shd_admin_actionlog_none'] = '没有找到条目。';
$txt['shd_admin_actionlog_unknown'] = '未知的';
$txt['shd_admin_actionlog_hidden'] = 'Hidden';
$txt['shd_admin_actionlog_removeall'] = '清空整个日志';
$txt['shd_admin_actionlog_removeall_confirm'] = '这将永久删除操作日志中超过 %s 小时的所有条目。您确定吗？';
//@}

//! @name General language strings for the admin log
//@{
$txt['shd_admin_adminlog_title'] = '服务台管理日志';
$txt['shd_admin_adminlog_action'] = '行 动';
$txt['shd_admin_adminlog_name'] = '名称';
$txt['shd_admin_adminlog_to'] = '收件人';
$txt['shd_admin_adminlog_from'] = '来自';
$txt['shd_admin_adminlog_setting'] = '设置';
$txt['shd_log_admin_canned'] = '预设回复';
$txt['shd_log_admin_customfield'] = '自定义字段';
$txt['shd_log_admin_maint'] = '维护费';
$txt['shd_log_admin_permissions'] = '权限';
$txt['shd_log_admin_plugins'] = '插件';
$txt['shd_log_admin_dept'] = '部门';
$txt['shd_log_admin_change_option'] = '备选方案';
$txt['shd_log_admin_canned_cat_move'] = '分类排序';
$txt['shd_log_admin_canned_cat_delete'] = '已删除类别';
$txt['shd_log_admin_canned_cat_add'] = '已添加类别';
$txt['shd_log_admin_canned_cat_update'] = '更新类别';
$txt['shd_log_admin_canned_reply_move'] = '排序回复';
$txt['shd_log_admin_canned_reply_delete'] = '已删除回复';
$txt['shd_log_admin_canned_reply_add'] = '添加预设回复';
$txt['shd_log_admin_canned_reply_update'] = '更新回复';
$txt['shd_log_admin_dept_move'] = '排序方式';
$txt['shd_log_admin_dept_delete'] = '已删除';
$txt['shd_log_admin_dept_add'] = '已添加';
$txt['shd_log_admin_dept_update'] = '更新';
$txt['shd_log_admin_customfield_move'] = '排序方式';
$txt['shd_log_admin_customfield_delete'] = '已删除';
$txt['shd_log_admin_customfield_add'] = '已添加';
$txt['shd_log_admin_customfield_update'] = '已更新';
$txt['shd_log_admin_customfield_move'] = '排序方式';
$txt['shd_log_admin_maint_reattribute'] = '退款工单';
$txt['shd_log_admin_maint_move_dept'] = '已移动工单到部门';
$txt['shd_log_admin_maint_findrepair'] = '兰寻找和修复';
$txt['shd_log_admin_maint_clean_cache'] = '干净缓存';
$txt['shd_log_admin_maint_search_rebuild'] = '重建搜索';
$txt['shd_log_admin_permissions_create_role'] = '已添加';
$txt['shd_log_admin_permissions_delete_role'] = '已删除';
$txt['shd_log_admin_permissions_change_role'] = '已更新';
$txt['shd_log_admin_permissions_copy_role'] = '已复制';
$txt['shd_log_admin_plugins_update'] = '已更新';
$txt['shd_log_admin_plugins_remove'] = '已删除';
//@}

//! @name Strings for the post-to-SimpleDesk.net support page
//@{
$txt['shd_admin_support_form_title'] = '支持表单';
$txt['shd_admin_support_what_is_this'] = '这是什么？';
$txt['shd_admin_support_explanation'] = '这个简单的表单将允许您直接向SimpleDesk网站发送支持请求，以便那里的支持团队能够帮助您解决您遇到的任何问题。<br><br>请注意，您需要在我们的网站上登录才能发布并在今后回复您的主题。 这种表格只会加快发布过程。';
$txt['shd_admin_support_send'] = '发送支持请求';
//@}

//! @name The browse-attachments integration strings
//@{
$txt['attachment_manager_shd_attach'] = '服务台附件';
$txt['attachment_manager_shd_thumb'] = '服务台缩略图';
$txt['attachment_manager_shd_attach_no_entries'] = '目前没有售后支持中心附件。';
$txt['attachment_manager_shd_thumb_no_entries'] = '目前没有售后支持中心缩略图。';
//@}

//! @name Custom fields stuff
//@{
$txt['shd_admin_custom_fields_long'] = '自定义工单和回复字段';
$txt['shd_admin_custom_fields_desc'] = '此部分允许您创建额外的字段可以添加到工单和/或他们的回复 收集有关服务单的更多信息或帮助您管理您的服务台。';
$txt['shd_admin_custom_fields_general'] = '基本信息';

$txt['shd_admin_custom_fields_fieldname'] = '字段名称';
$txt['shd_admin_custom_fields_fieldname_desc'] = '用户输入信息的旁边显示的名称(必须)';
$txt['shd_admin_custom_fields_description'] = '字段描述';
$txt['shd_admin_custom_fields_description_desc'] = '输入信息时显示给用户的字段描述。';
$txt['shd_admin_custom_fields_icon'] = '字段图标';
$txt['shd_admin_custom_fields_icon_desc'] = '可选的图标显示在字段名称旁边。要添加您自己的图标，只需将图像文件放入. Themes/default/images/simpldesk/cf/文件夹。为了取得最佳效果，这应该是一个 13x13px png 图像。';
$txt['shd_admin_custom_fields_fieldtype'] = '字段类型';
$txt['shd_admin_custom_fields_fieldtype_desc'] = '用户填写请求信息的字段类型。';
$txt['shd_admin_custom_fields_active'] = '已启用';
$txt['shd_admin_custom_fields_inactive'] = '未激活';
$txt['shd_admin_custom_fields_active_desc'] = '这是此字段的主切换。如果它未激活，它将不会在发布时显示或要求用户显示。';
$txt['shd_admin_custom_fields_fielddesc'] = '字段描述';
$txt['shd_admin_custom_fields_fielddesc_desc'] = '您要添加的字段简短描述。';
$txt['shd_admin_custom_fields_visible'] = '可见';
$txt['shd_admin_custom_fields_visible_ticket'] = '工单可视性/可编辑';
$txt['shd_admin_custom_fields_visible_field'] = '在回复中可视/编辑';
$txt['shd_admin_custom_fields_visible_both'] = '在工单和回复中都可视化/编辑';
$txt['shd_admin_custom_fields_visible_desc'] = '此操作控制某个字段是否仅适用于整个工单、单独答复还是同时适用于工单及其答复。';
$txt['shd_admin_custom_fields_none'] = '(无)';
$txt['shd_admin_no_custom_fields'] = '当前没有设置自定义字段。';
$txt['shd_admin_custom_fields_inticket'] = '在工单上可见';
$txt['shd_admin_custom_fields_inreply'] = '在回复时可见';
$txt['shd_admin_custom_fields_move'] = '移动';
$txt['shd_admin_move_up'] = '上移';
$txt['shd_admin_move_down'] = '向下移动';
$txt['shd_admin_custom_fields_ui_text'] = '文本框';
$txt['shd_admin_custom_fields_ui_largetext'] = '大文本框';
$txt['shd_admin_custom_fields_ui_int'] = '整数(整数)';
$txt['shd_admin_custom_fields_ui_float'] = '浮动(浮点数)';
$txt['shd_admin_custom_fields_ui_select'] = '从下拉列表中选择';
$txt['shd_admin_custom_fields_ui_checkbox'] = 'Tickbox (是/否)';
$txt['shd_admin_custom_fields_ui_radio'] = '从无线电按钮中选择';
$txt['shd_admin_custom_fields_ui_multi'] = '选择多个项目';
$txt['shd_admin_cannot_edit_custom_field'] = '您不能编辑此自定义字段。';
$txt['shd_admin_cannot_move_custom_field'] = '您不能移动此自定义字段。';
$txt['shd_admin_cannot_move_custom_field_up'] = '您不能将此自定义字段向上移动；它已经是第一项。';
$txt['shd_admin_cannot_move_custom_field_down'] = '您不能将此自定义字段向下移动；它已经是最后一个项目。';
$txt['shd_admin_new_custom_field'] = '添加新字段';
$txt['shd_admin_new_custom_field_desc'] = '您可以在此面板中为您的工单和/或回复添加一个新的自定义字段，并指定这些工单应如何为您起作用。';
$txt['shd_admin_edit_custom_field'] = '编辑现有字段';
$txt['shd_admin_edit_custom_field_desc'] = '您可以在此面板上编辑一个现有的自定义字段，如下所示。';
$txt['shd_admin_no_fieldname'] = '您没有为您的自定义字段指定任何名称。';
$txt['shd_admin_could_not_create_field'] = '创建自定义字段失败。请重试。';
$txt['shd_admin_default_state_on'] = '已检查';
$txt['shd_admin_default_state_off'] = '未检查';
$txt['shd_admin_save_custom_field'] = '保存字段';
$txt['shd_admin_delete_custom_field'] = '删除字段';
$txt['shd_admin_cancel_custom_field'] = '取消';
$txt['shd_admin_delete_custom_field_confirm'] = '您真的想要删除此自定义字段吗？此字段中存储的所有值都将被删除，且没有撤消功能。';
$txt['shd_admin_custom_field_options'] = '备选方案';
$txt['shd_admin_custom_field_options_desc'] = '将选项框留空以移除。';
$txt['shd_admin_custom_field_options_radio'] = '单选按钮选择默认选项。';
$txt['shd_admin_custom_field_options_multi'] = '复选框表示默认选择哪些项目。';
$txt['shd_admin_custom_field_no_selected_default'] = '没有选中的默认值';
$txt['shd_admin_custom_field_bbc'] = '允许 BBC';
$txt['shd_admin_custom_field_bbc_note'] = 'BBC 未处理用作工单前缀的字段。';
$txt['shd_admin_custom_field_bbc_off'] = 'BBC is currently <a href="%s">disabled</a> throughout the helpdesk.';
$txt['shd_admin_custom_field_default_state'] = '默认状态';
$txt['shd_admin_custom_field_dimensions'] = '尺寸';
$txt['shd_admin_custom_field_dimensions_rows'] = '行';
$txt['shd_admin_custom_field_dimensions_columns'] = '列';
$txt['shd_admin_custom_field_maxlength'] = '最大长度';
$txt['shd_admin_custom_field_maxlength_desc'] = '(0表示无限制)';
$txt['shd_admin_custom_field_display_empty'] = '即使是空也显示';
$txt['shd_admin_custom_field_display_empty_desc'] = '如果用户留空字段，阅读工单时是否仍显示该字段？';
$txt['shd_admin_custom_field_required'] = '必填字段';
$txt['shd_admin_custom_field_required_desc'] = '如果选中此项，此字段必须由用户填写才能张贴工单或回复。';
$txt['shd_admin_custom_field_view'] = '查看';
$txt['shd_admin_custom_field_edit'] = '编辑';
$txt['shd_admin_custom_field_permissions'] = '权限';
$txt['shd_admin_custom_field_can_see'] = '谁可以看到此字段';
$txt['shd_admin_custom_field_can_see_desc'] = '选择谁可以在工单中看到此字段。';
$txt['shd_admin_custom_field_can_edit'] = '谁可以编辑此字段';
$txt['shd_admin_custom_field_can_edit_desc'] = '选择谁可以在发布时编辑/使用此字段。';
$txt['shd_admin_custom_field_users'] = '用户';
$txt['shd_admin_custom_field_staff'] = '工作人员';
$txt['shd_admin_custom_field_admins'] = '管理员';
$txt['shd_admin_custom_field_placement'] = '工单内放置位置';
$txt['shd_admin_custom_field_placement_desc'] = '在工单中显示此字段的位置？ 请注意大字段可能不适合于“额外细节”框， 并且只有选择下拉菜单和无线电按钮才可用作类别。';
$txt['shd_admin_custom_field_placement_details'] = '其他详细信息(左侧框)';
$txt['shd_admin_custom_field_placement_information'] = '附加信息(工单正文下方)';
$txt['shd_admin_custom_field_placement_prefix'] = '作为工单标题的前缀';
$txt['shd_admin_custom_field_placement_prefixfilter'] = '作为一个类别 (可过滤)';
$txt['shd_admin_custom_field_department'] = '此字段适用于的部门';
$txt['shd_admin_custom_field_dept_applies'] = '应用';
$txt['shd_admin_custom_field_dept_required'] = '必填';
$txt['shd_admin_custom_field_invalid'] = '选择的字段类型无效。';
$txt['shd_admin_custom_field_reselect_invalid'] = '您已尝试更改此自定义字段，但使用了与已经存储的此字段数据不兼容的类型。 而且为了避免破坏现有数据，已经避免了变化。';
//@}

//! Canned Replies
//@{
$txt['shd_admin_cannedreplies_home'] = '服务台-预设回复';
$txt['shd_admin_cannedreplies_homedesc'] = '本节允许您创建模板答案或代码片段 或常问问题的答案，这样它们就可以从张贴界面获得。';
$txt['shd_admin_cannedreplies_nocats'] = '没有预设回复的类别，您需要先创建一个。';
$txt['shd_admin_cannedreplies_createcat'] = '创建新类别';
$txt['shd_admin_cannedreplies_editcat'] = '编辑此类别';
$txt['shd_admin_cannedreplies_deletecat'] = '删除此类别';
$txt['shd_admin_cannedreplies_categoryname'] = '类别名称';
$txt['shd_admin_cannedreplies_replyname'] = '回复名称';
$txt['shd_admin_cannedreplies_isactive'] = '激活？';
$txt['shd_admin_cannedreplies_visibleto'] = '可见到';
$txt['shd_admin_cannedreplies_emptycat'] = '此类别中没有预设回复。';
$txt['shd_admin_cannedreplies_addreply'] = '创建新回复';
$txt['shd_admin_cannedreplies_editreply'] = '编辑此回复';
$txt['shd_admin_cannedreplies_deletereply'] = '删除此回复';
$txt['shd_admin_cannedreplies_delete_confirm'] = '您确定要删除此类别和所有回复？';
$txt['shd_admin_cannedreplies_deletereply_confirm'] = '您确定要删除此回复吗？';
$txt['shd_admin_cannedreplies_move_between_cat'] = '移动此预设回复到另一个类别';
$txt['shd_admin_cannedreplies_cannot_move_reply'] = '此回复不能被移动。';
$txt['shd_admin_cannedreplies_cannot_move_reply_up'] = '不能向上移动此回复。';
$txt['shd_admin_cannedreplies_cannot_move_reply_down'] = '此回复不能向下移动。';
$txt['shd_admin_cannedreplies_cannot_move_cat'] = '此类别不能被移动。';
$txt['shd_admin_cannedreplies_cannot_move_cat_up'] = '此类别不能上移。';
$txt['shd_admin_cannedreplies_cannot_move_cat_down'] = '此类别不能向下移动。';
$txt['shd_admin_cannedreplies_thecatisalie'] = '此类别不存在，无法编辑。';
$txt['shd_admin_cannedreplies_thereplyisalie'] = '此回复不存在，无法编辑。';
$txt['shd_admin_cannedreplies_nocatname'] = '没有给该类别命名，必须提供一个名称。';
$txt['shd_admin_cannedreplies_replytitle'] = '预设回复的标题';
$txt['shd_admin_cannedreplies_content'] = '预设回复的内容';
$txt['shd_admin_cannedreplies_active'] = '预设回复是否已激活？';
$txt['shd_admin_cannedreplies_selectvisible'] = '这个预设回复提供给谁？';
$txt['shd_admin_cannedreplies_departments'] = '预设回复可以访问的部门';
$txt['shd_admin_cannedreplies_notitle'] = '没有给这个预设的回复指定标题，必须提供。';
$txt['shd_admin_cannedreplies_nobody'] = '没有给出这个预设回复的身体内容，必须提供。';
$txt['shd_admin_cannedreplies_notcreated'] = '无法创建新回复。';
$txt['shd_admin_cannedreplies_onlyonecat'] = '您不能将此回复移动到另一个类别，只有一个类别的回复。';
$txt['shd_admin_cannedreplies_newcategory'] = '这个回复应该属于的新类别';
$txt['shd_admin_cannedreplies_selectcat'] = '-- 选择类别 --';
$txt['shd_admin_cannedreplies_movereply'] = '移动此回复';
$txt['shd_admin_cannedreplies_destnoexist'] = '您要移动此回复的类别不存在。';

//! Departments
//@{
$txt['shd_admin_departments_home'] = '服务台部门';
$txt['shd_admin_departments_homedesc'] = '在服务台环境中，为组织服务单和进入服务单创建了一个或多个不同的领域――“部门”。';
$txt['shd_department_name'] = '部门名称';
$txt['shd_dept_boardindex'] = '显示在棋盘索引上？';
$txt['shd_dept_no_boardindex'] = '不在棋盘索引中显示';
$txt['shd_dept_inside_category'] = '在板载索引中，类别内';
$txt['shd_dept_cat_before_boards'] = '在此类别中的所有看板';
$txt['shd_dept_cat_after_boards'] = '在此类别中的所有看板之后';
$txt['shd_roles_in_dept'] = '在本部门中的角色';
$txt['shd_create_dept'] = '创建新部门';
$txt['shd_edit_dept'] = '编辑部门';
$txt['shd_delete_dept'] = '删除部门';
$txt['shd_delete_dept_confirm'] = '您真的要删除这个部门吗？';
$txt['shd_no_roles_in_dept'] = '该部门没有角色。';
$txt['shd_new_dept_name'] = '新部门名称';
$txt['shd_dept_boardindex_cat'] = '在分类中显示此部门索引';
$txt['shd_no_dept_name'] = '没有指定部门名称。';
$txt['shd_no_category'] = '指定的类别不存在。请返回并重新加载页面。';
$txt['shd_could_not_create_dept'] = '无法创建此部门。';
$txt['shd_must_have_dept'] = '您不能删除唯一的部门；一个必须始终存在。';
$txt['shd_dept_not_empty'] = '您不能删除此分类，它包含至少一个工单。';
$txt['shd_roles_in_dept'] = '在此部门内的角色';
$txt['shd_roles_in_dept_desc'] = '在管理面板中的其他地方，角色被创建和授予能力。 此面板控制哪些角色适用于该部门，例如，您可能希望创建多个具有单独共享工作人员角色的部门。';
$txt['shd_no_defined_roles'] = '没有定义角色，请从权限区域配置它们。';
$txt['shd_assign_dept'] = '分配角色/部门';
$txt['shd_boardindex_cat_none'] = '没有类别 (不显示)';
$txt['shd_boardindex_cat_where'] = '该类别应显示在哪里？';
$txt['shd_boardindex_cat_before'] = '在任何看板';
$txt['shd_boardindex_cat_after'] = '在任何看板之后';
$txt['shd_dept_description'] = '描述';
$txt['shd_admin_cannot_move_dept'] = '您不能移动该部门。';
$txt['shd_admin_cannot_move_dept_up'] = '你不能移动该部门；它已经是第一个项目。';
$txt['shd_admin_cannot_move_dept_down'] = '你不能将该部门下移；它已经是最后一个项目。';
$txt['shd_dept_theme'] = '在这个部门使用一个特定主题？';
$txt['shd_dept_theme_note'] = '您可以设置与论坛主题不同的售后支持中心主题。 此设置允许您在这个部门内重置售后支持中心或论坛主题，也许是为了部门的特定品牌。';
$txt['shd_dept_theme_use_default'] = '使用帮助台/论坛默认主题';
$txt['shd_dept_autoclose_days'] = '自动关闭工单的天数？';
$txt['shd_dept_autoclose_days_note'] = '使用 0 表示此部门的工单不应自动被关闭，不管它们是多久的。';
//@}

//! Plugins
//@{
$txt['sdplugin_package'] = 'SimpleDesk Plugins';
$txt['shd_install_plugin'] = '安装插件';
$txt['shd_admin_plugins_homedesc'] = '这个区域允许您管理SimpleDesk的任何附加组件。它们是通过软件包管理器安装的，并从这里进行配置。';
$txt['shd_admin_plugins_none'] = '当前没有安装插件。';
$txt['shd_admin_plugins_writtenby'] = '撰写者';
$txt['shd_admin_plugins_website'] = '网址';
$txt['shd_admin_plugins_wrong_version'] = '此版本不支持！';
$txt['shd_admin_plugins_versions_avail'] = '由插件支持';
$txt['shd_admin_plugins_on'] = '开启';
$txt['shd_admin_plugins_off'] = '关闭';
 $txt['shd_admin_plugins_enabled'] = '已启用';
$txt['shd_admin_plugins_disabled'] = '已禁用';
$txt['shd_admin_plugins_languages'] = '可用语言';
$txt['shd_admin_plugins_lang_albanian'] = '阿尔巴尼亚语';
$txt['shd_admin_plugins_lang_arabic'] = '阿拉伯语';
$txt['shd_admin_plugins_lang_bangla'] = '孟加拉文';
$txt['shd_admin_plugins_lang_bulgarian'] = '保加利亚文';
$txt['shd_admin_plugins_lang_catalan'] = '加泰罗尼亚语';
$txt['shd_admin_plugins_lang_chinese_simplified'] = '中文(简化)';
$txt['shd_admin_plugins_lang_chinese_traditional'] = '中文(传统)';
$txt['shd_admin_plugins_lang_croatian'] = '克罗地亚语';
$txt['shd_admin_plugins_lang_czech'] = '捷克语';
$txt['shd_admin_plugins_lang_danish'] = '丹麦语';
$txt['shd_admin_plugins_lang_dutch'] = '荷兰语';
$txt['shd_admin_plugins_lang_english'] = '英语(美国)';
$txt['shd_admin_plugins_lang_english_british'] = '英语(英国)';
$txt['shd_admin_plugins_lang_finnish'] = '芬兰语';
$txt['shd_admin_plugins_lang_french'] = '法文';
$txt['shd_admin_plugins_lang_galician'] = '加利西亚文';
$txt['shd_admin_plugins_lang_german'] = '德文';
$txt['shd_admin_plugins_lang_hebrew'] = '希伯来语';
$txt['shd_admin_plugins_lang_hindi'] = '印地文';
$txt['shd_admin_plugins_lang_hungarian'] = '匈牙利';
$txt['shd_admin_plugins_lang_indonesian'] = '印尼语';
$txt['shd_admin_plugins_lang_italian'] = '意大利语';
$txt['shd_admin_plugins_lang_japanese'] = '日语';
$txt['shd_admin_plugins_lang_kurdish_kurmanji'] = '库尔德语(库尔曼吉)';
$txt['shd_admin_plugins_lang_kurdish_sorani'] = '库尔德语 (Sorani)';
$txt['shd_admin_plugins_lang_macedonian'] = '马其顿语';
$txt['shd_admin_plugins_lang_malay'] = '马来文';
$txt['shd_admin_plugins_lang_norwegian'] = '挪威语';
$txt['shd_admin_plugins_lang_persian'] = '波斯文';
$txt['shd_admin_plugins_lang_polish'] = '波兰语';
$txt['shd_admin_plugins_lang_portuguese_brazilian'] = '葡萄牙语(巴西语)';
$txt['shd_admin_plugins_lang_portuguese_pt'] = '葡萄牙文';
$txt['shd_admin_plugins_lang_romanian'] = '罗马尼亚语';
$txt['shd_admin_plugins_lang_russian'] = '俄文';
$txt['shd_admin_plugins_lang_serbian_cyrillic'] = '塞尔维亚语(西里尔语)';
$txt['shd_admin_plugins_lang_serbian_latin'] = 'Serbian (Latin)';
$txt['shd_admin_plugins_lang_slovak'] = '斯洛伐克语';
$txt['shd_admin_plugins_lang_spanish_es'] = '西班牙语(西班牙)';
$txt['shd_admin_plugins_lang_spanish_latin'] = '西班牙语(拉丁语)';
$txt['shd_admin_plugins_lang_swedish'] = '瑞典语';
$txt['shd_admin_plugins_lang_thai'] = '泰文';
$txt['shd_admin_plugins_lang_turkish'] = '土耳其语';
$txt['shd_admin_plugins_lang_ukrainian'] = '乌克兰语';
$txt['shd_admin_plugins_lang_urdu'] = '乌尔都文';
$txt['shd_admin_plugins_lang_uzbek_latin'] = 'Uzbek (Latin)';
$txt['shd_admin_plugins_lang_vietnamese'] = 'Vietnamese';
//@}

//! Maintenance
//@{
$txt['shd_admin_maint_back'] = '返回服务台维护';
$txt['shd_admin_maint_desc'] = '这个区域允许您在SimpleDesk中执行一些共同的维护任务。';

$txt['shd_admin_maint_reattribute'] = '重新属性用户帖子';
$txt['shd_admin_maint_reattribute_desc'] = '如果用户的帐户已被删除，这将允许从他们的旧帐户重新加入他们的新帐户。';
$txt['shd_admin_maint_reattribute_posts_made'] = '重定性工单和回复：';
$txt['shd_admin_maint_reattribute_posts_user'] = '此用户名';
$txt['shd_admin_maint_reattribute_posts_email'] = '此电子邮件地址';
$txt['shd_admin_maint_reattribute_posts_starter'] = '工单启动器';
$txt['shd_admin_maint_reattribute_posts_to'] = '并将它们附加到此用户帐户：';
$txt['shd_admin_maint_reattribute_btn'] = '现在重设属性';
$txt['shd_admin_maint_reattribute_success'] = '所有可以找到的工单和帖子都已被处理。 您可能现在应该从服务台维护中运行"查找和修复错误"的维护选项。(如果是，某些工单可能不会正确显示。)';
$txt['shd_reattribute_confirm'] = 'Are you sure you want to attribute all tickets and replies (from the previously deleted account) with %type% of "%find%" to member "%member_to%"?';
$txt['shd_reattribute_confirm_starter'] = '您确定要将“%find%”的所有工单启动器赋予成员 "%member_to% "吗？';
$txt['shd_reattribute_confirm_username'] = '一个用户名';
$txt['shd_reattribute_confirm_email'] = '电子邮件地址';
$txt['shd_reattribute_cannot_find_member'] = '售后支持中心无法找到用户创建工单和回复。';
$txt[''] = '售后支持中心找不到受欢迎的用户来创建工单和回复。';
$txt['shd_reattribute_no_email'] = '未提供电子邮件地址。';
$txt['shd_reattribute_no_user'] = '未提供用户名。';
$txt['shd_reattribute_no_messages'] = '没有发现消息被重新归类。';
$txt['shd_reattribute_in_use'] = '唯一找到重归因的消息都是针对当前用户列出的，因此无法对这些消息进行更多的重归。';

$txt['shd_admin_maint_massdeptmove'] = '移动服务单';
$txt['shd_admin_maint_massdeptmove_desc'] = '此区域允许您在各部门之间大规模移动工单。';
$txt['shd_admin_maint_massdeptmove_select'] = '(选择部门)';
$txt['shd_admin_maint_massdeptmove_from'] = '移动工单从';
$txt['shd_admin_maint_massdeptmove_to'] = '到';
$txt['shd_admin_maint_massdeptmove_success'] = '所有匹配的工单已成功移动到他们的新部门。';
$txt['shd_admin_maint_massdeptmove_samedept'] = '您必须选择不同的起始部门和目标部门来移动工单。';
$txt['shd_admin_maint_massdeptmove_open'] = '从该部门移动打开/未处理的问题';
$txt['shd_admin_maint_massdeptmove_closed'] = '从这个部门移动已关闭的服务单';
$txt['shd_admin_maint_massdeptmove_deleted'] = '将已删除的工单从该部门移动';
$txt['shd_admin_maint_massdeptmove_lastupd_less'] = '工单必须是最近一次更新于 %1$s 天';
$txt['shd_admin_maint_massdeptmove_lastupd_more'] = '工单必须在 %1$s 天前最后一次更新';

$txt['shd_admin_maint_findrepair'] = '查找和修复错误';
$txt['shd_admin_maint_findrepair_desc'] = '有时候，尽管不可能做到这一点，但数据库中的事情有时稍有出入。 此操作对数据库进行完整性检查，并尝试修复它遇到的任何错误。';

$txt['shd_admin_maint_findrepair_status'] = '正在重新计算工单数量...';
$txt['shd_admin_maint_findrepair_firstlast'] = '重新计算工单的第一次/最后一次关联...';
$txt['shd_admin_maint_findrepair_starterupdater'] = '正在重新计算工单开始和最后一次更新由关联...';

$txt['shd_admin_recovered_dept'] = '已恢复的工单';
$txt['shd_admin_recovered_dept_desc'] = '这些是在现有部门之外的某种程度上属于其他部门的机票。 您可以将他们移动到真正的部门，当此部门为空时，您应该删除它。';

$txt['shd_maint_zero_tickets'] = '找到 %1$d 个ticket(s) 无效id，他们都获得了新的 id，下一个可用的 id。';
$txt['shd_maint_zero_msgs'] = '发现%1$d 张工单帖子有无效ID，他们都获得了新ID，下一个可用ID号。';
$txt['shd_maint_deleted'] = '%1$d ticket(s) 对帖子数量和/或删除的帖子进行了不正确的计数。所有的计数都已重新计算。';
$txt['shd_maint_first_last'] = '%1$d ticket(s) 标记了工单内容或最后回复的错误消息。所有这些都已纠正。';
$txt['shd_maint_status'] = '%1$d ticket(s) 设置了错误的状态。所有都已纠正。';
$txt['shd_maint_starter_updater'] = '%1$d ticket(s) 被错误的用户列为开启工单的人或最后一个更新工单的人。 所有这些都得到了纠正。';
$txt['shd_maint_invalid_dept'] = '%1$d ticket(s) 被列为在不存在的部门中，所有都被移动到一个新部门，名为“恢复工单”。';

$txt['shd_maint_search_settings'] = '搜索设置';
$txt['shd_maint_search_settings_desc'] = '此页面允许您配置如何进行服务单搜索，并在必要时重建用于搜索的索引。';
$txt['shd_maint_rebuild_index'] = '重建搜索索引';
$txt['shd_maint_rebuild_index_desc'] = 'If you have existing tickets that were around prior to the search facility being provided, or you alter the settings below, you will <strong>need</strong> to rebuild the index after. The index is what is physically used to search, and if the physical index setup is different to how searches are made, you will find searching very unrealiable.<br><strong>Important:</strong> Building the search index is a very intensive task. It will take a while to carry out, during which time please leave this window open.';
$txt['shd_maint_search_settings_warning'] = '如果您更改这些设置，您将需要重建搜索索引。';
$txt['shd_search_min_size'] = '要考虑一个词的最小字母数量 (3-15)';
$txt['shd_search_max_size'] = '要考虑一个词的最大字母数量 (3-15)';
$txt['shd_search_prefix_size'] = '用于前缀搜索的字母最小数量<div class="smalltext">(0=禁用)</div>';
$txt['shd_search_prefix_size_help'] = '前缀搜索是构建索引以进行部分字匹配的地方。 例如，搜索 &quot;步行&quot; 将返回结果，如 &quot;步行&quot; 或 &quot;步行&quot;。 默认情况下它会被禁用，因为它会使索引大得多，并且搜索速度减慢。';
$txt['shd_search_charset'] = '视为搜索字段的有效部分的字符。';
$txt['shd_search_rebuilt'] = '搜索索引已重建。';
//@}

/**
 *	@ignore
 *	Warning: He may bite.
*/
//! Ignore
//@{
$txt['shd_fluffy'] = '<span %s>cookie 守护者</span>';
//@}