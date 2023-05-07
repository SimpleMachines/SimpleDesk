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
$txt['shd_helpdesk'] = '服务台';
$txt['shd_helpdesk_maintenance'] = '售后支持中心目前处于 <strong>维护模式</strong>。只有论坛和售后支持中心管理员才能看到这一点。';
$txt['shd_open_ticket'] = '打开服务单';
$txt['shd_open_tickets'] = '打开工单';
$txt['shd_none'] = '无';

$txt['shd_display_nojs'] = 'JavaScript 未在您的浏览器中启用。有些功能可能无法正常工作(或者根本无法正常工作)，或者行为方式异常。';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = '欢迎来到主要服务台管理中心！';
$txt['shd_admin_title'] = '服务台管理中心';
$txt['shd_staff_list'] = '服务台工作人员';
$txt['shd_update_available'] = '有新版本可用！';
$txt['shd_update_message'] = '新版本的SimpleDesk已经发行。 我们建议您将 <a href="#" id="update-link">更新到最新版本的</a> ，以便保持安全并享受我们的修改所提供的所有功能。' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>关于这次发布新内容的更多信息，请访问 <a href="#" id="information-link" target="_blank">我们的网站</a>。</span><br>' . "\n\n" . '<strong>SimpleDesk Team</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = '低';
$txt['shd_urgency_1'] = '中';
$txt['shd_urgency_2'] = '高';
$txt['shd_urgency_3'] = '非常高';
$txt['shd_urgency_4'] = '严重的';
$txt['shd_urgency_5'] = '关键的';
$txt['shd_urgency_increase'] = '增加';
$txt['shd_urgency_decrease'] = '减少';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = '新的';
$txt['shd_status_1'] = '待处理的员工评论';
$txt['shd_status_2'] = '待定用户评论';
$txt['shd_status_3'] = '已解决/关闭';
$txt['shd_status_4'] = '指向管理员';
$txt['shd_status_5'] = '升级 - Uruguay';
$txt['shd_status_6'] = '已删除';
$txt['shd_status_7'] = '按住时';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = '新建任务单';
$txt['shd_status_1_heading'] = '工单等待员工响应';
$txt['shd_status_2_heading'] = '工单等待用户响应';
$txt['shd_status_3_heading'] = '已关闭的工单';
$txt['shd_status_4_heading'] = '推荐给管理员的服务单';
$txt['shd_status_5_heading'] = '紧急工单';
$txt['shd_status_6_heading'] = '回收工单';
$txt['shd_status_7_heading'] = '在持有票证上';
$txt['shd_status_assigned_heading'] = '分配给我';
$txt['shd_status_withdeleted_heading'] = '带有已删除回复的工单';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = '打开工单';
$txt['shd_tickets_closed'] = '已关闭的工单';
$txt['shd_tickets_recycled'] = '回收工单';

$txt['shd_assigned'] = '已分配';
$txt['shd_unassigned'] = '未分配';

$txt['shd_read_ticket'] = '读取任务单';
$txt['shd_unread_ticket'] = '未读工单';
$txt['shd_unread_tickets'] = '未读工单';

$txt['shd_owned'] = '已拥有的工单'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = '服务单';
$txt['shd_count_tickets'] = '服务单';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = '您无权访问服务台。';
$txt['shd_no_ticket'] = '您请求的工单似乎不存在。';
$txt['shd_no_reply'] = '您请求的工单回复似乎不存在，或者不属于此工单的一部分。';
$txt['shd_no_topic'] = '您请求的主题似乎不存在。';
$txt['shd_ticket_no_perms'] = '您无权查看该工单。';
$txt['shd_error_no_tickets'] = '没有找到工单。';
$txt['shd_inactive'] = '售后支持中心目前已停用。';
$txt['shd_cannot_assign'] = '您无权分配工单。';
$txt['shd_cannot_assign_other'] = '此工单已分配给其他用户。您不能将其重新分配给自己——请与管理员联系。';
$txt['shd_no_staff_assign'] = '没有配置员工，无法分配工单。请联系您的管理员。';
$txt['shd_assigned_not_permitted'] = '您请求分配此工单的用户没有足够权限查看此工单。';
$txt['shd_cannot_resolve'] = '您没有权限将此工单标记为已解析。';
$txt['shd_cannot_unresolve'] = '您没有权限重新打开已解决的工单。';
$txt['error_shd_cannot_resolve_children'] = '此工单当前无法关闭；此工单是当前打开的一个或多个工单的父工单。';
$txt['error_shd_proxy_unknown'] = '此工单代表发帖的用户不存在。';
$txt['shd_cannot_change_privacy'] = '您没有权限更改此工单上的隐私。';
$txt['shd_cannot_change_urgency'] = '您没有权限更改此工单上的紧急性。';
$txt['shd_ajax_problem'] = '尝试加载页面时出错。您想重试吗？';
$txt['shd_cannot_move_ticket'] = '您没有权限将此工单移动到一个主题。';
$txt['shd_cannot_move_topic'] = '您无权将此主题移动到工单。';
$txt['shd_moveticket_noboards'] = '没有可以移动此工单的板！';
$txt['shd_move_no_pm'] = '您必须输入移动工单以发送给工单所有者的原因， 或取消选中“发送PM给工单所有者”的选项。';
$txt['shd_move_no_pm_topic'] = '您必须输入一个将主题移动到主题开始时的原因， 或者取消选中“发送PM到主题开始”选项。';
$txt['shd_move_topic_not_created'] = '无法将工单移动到看板。请再试一次。';
$txt['shd_move_ticket_not_created'] = '无法将主题移动到服务台。请重试。';
$txt['shd_no_replies'] = '此工单还没有任何回复。';
$txt['cannot_shd_new_ticket'] = '您没有创建新工单的权限。';
$txt['cannot_shd_edit_ticket'] = '您没有权限编辑此工单。';
$txt['shd_cannot_reply_any'] = '您没有回复任何工单的权限。';
$txt['shd_cannot_reply_any_but_own'] = '您没有权限回复您自己的工单。';
$txt['shd_cannot_edit_reply_any'] = '您没有权限编辑任何回复。';
$txt['shd_cannot_edit_reply_any_but_own'] = '除了您自己的回复外，您没有权限编辑对任何工单的回复。';
$txt['shd_cannot_edit_closed'] = '您不能编辑已解决的工单；您需要先标记它才能解决。';
$txt['shd_cannot_edit_deleted'] = '您不能在回收站编辑工单。它们将需要先恢复。';
$txt['shd_cannot_reply_closed'] = '您不能回复已解决的工单；您需要先标记未解决的工单。';
$txt['shd_cannot_reply_deleted'] = '您不能回复回收站中的工单。它们需要先恢复。';
$txt['shd_cannot_delete_ticket'] = '您无权删除此工单。';
$txt['shd_cannot_delete_reply'] = '您无权删除该回复。';
$txt['shd_cannot_restore_ticket'] = '您无权从回收站还原此服务单。';
$txt['shd_cannot_restore_reply'] = '您无权从回收站恢复该回复。';
$txt['shd_cannot_view_resolved'] = '您无权访问已解析的工单。';
$txt['cannot_shd_access_recyclebin'] = '您不能访问回收站bin。';
$txt['shd_cannot_move_ticket_with_deleted'] = '您不能将此工单移动到论坛；有一个或多个删除的回复，您当前的权限不允许访问。';
$txt['shd_cannot_attach_ext'] = '此处不允许您尝试附加的文件类型 ({ext}) 。允许的文件类型为： {attach_exts}';
$txt['shd_ticket_unavailable'] = '此工单目前不可修改。';
$txt['shd_invalid_relation'] = '您必须为这些工单提供有效的关系类型。';
$txt['shd_no_relation_delete'] = '您不能删除不存在的关系。';
$txt['shd_cannot_relate_self'] = '您不能提供与自己相关的工单。';
$txt['shd_relationships_are_disabled'] = '工单关系目前已禁用。';
$txt['error_invalid_fields'] = '以下字段有无法使用的值： %1$s';
$txt['error_missing_fields'] = '以下字段尚未完成，需要： %1$s';
$txt['error_missing_multi'] = '%1$s (至少 %2$d 必须被选择)';
$txt['error_no_dept'] = '您没有选择要发布此工单的部门。';
$txt['shd_cannot_move_dept'] = '您不能移动此工单，没有任何地方可以移动它。';
$txt['shd_no_perm_move_dept'] = '您无权将此工单移动到另一个部门。';
$txt['cannot_shd_delete_attachment'] = '您无权删除附件。';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = '您不能将此工单移动到主题上；有自定义字段需要管理员确认移动。';
$txt['cannot_monitor_ticket'] = '您无权对此工单进行监测。';
$txt['cannot_unmonitor_ticket'] = '您无权关闭此工单的监视。';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = '服务台'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = '部门'; // ditto
$txt['shd_new_ticket'] = '发布新工单';
$txt['shd_new_ticket_proxy'] = '发布代理服务单';
$txt['shd_helpdesk_profile'] = '服务台配置文件';
$txt['shd_welcome'] = '欢迎您， %s！';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = '转到服务单';
$txt['shd_options'] = '备选方案';
$txt['shd_search_menu'] = '搜索';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = '信息';
$txt['shd_admin_options'] = '备选方案';
$txt['shd_admin_custom_fields'] = '自定义字段';
$txt['shd_admin_departments'] = '部门';
$txt['shd_admin_permissions'] = '权限';
$txt['shd_admin_plugins'] = '插件';
$txt['shd_admin_cannedreplies'] = '预设回复';
$txt['shd_admin_maint'] = '维护费';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = '您可以在这里为站点工作人员提交新的工单以供采取行动，并检查当前工单已经在进行中。';
$txt['shd_staff_greeting'] = '这里是所有需要关注的工单。';
$txt['shd_shd_greeting'] = '这是帮助服务台。在这里你浪费时间来帮助新生物。享受享受！;D';
$txt['shd_closed_user_greeting'] = '这些都是您发布到售后支持中心的已关闭/解决的工单。';
$txt['shd_closed_staff_greeting'] = '这些都是提交给服务台的已关闭/解决的工单。';
$txt['shd_category_filter'] = '类别过滤';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = '您的工单已创建！';
$txt['shd_ticket_posted_body'] = '感谢您发布您的工单， {membername}！' . "\n\n" . '售后支持中心工作人员将审查并尽快与您联系。' . "\n\n" . '同时，您可以在以下网址查看您的工单， &quot;[iurl={ticketurl}]{subject}[/iurl]&quot;' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]打开另一张票[/iurl] | [iurl={helpdesklink}]返回主要售后支持中心[/iurl] | [iurl={forumlink}]返回到论坛[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . '您可以在 [iurl={prefslink}]Helpdesk 首选项[/iurl] 区域中打开电子邮件通知您的工单变更。';
$txt['shd_ticket_posted_footer'] = "\n\n" . '祝福，' . "\n" . '{forum_name} 团队';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = '工单详细信息';
$txt['shd_ticket_updated'] = '已更新';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = '名称';
$txt['shd_ticket_user'] = '用户';
$txt['shd_ticket_date'] = '已发布';
$txt['shd_ticket_urgency'] = '紧急度';
$txt['shd_ticket_assigned'] = '已分配';
$txt['shd_ticket_assignedto'] = '分配给';
$txt['shd_ticket_started_by'] = '开始于';
$txt['shd_ticket_updated_by'] = '更新者';
$txt['shd_ticket_status'] = '状态';
$txt['shd_ticket_num_replies'] = '回复';
$txt['shd_ticket_replies'] = '回复';
$txt['shd_ticket_staff'] = '工作人员';
$txt['shd_ticket_attachments'] = '附件';
$txt['shd_ticket_reply_number'] = '回复 <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = '工单按住';
$txt['shd_ticket'] = '服务单';
$txt['shd_reply_written'] = '回复已写入 %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = '从不使用';
$txt['shd_linktree_tickets'] = '服务单';
$txt['shd_ticket_privacy'] = '隐私';
$txt['shd_ticket_notprivate'] = '非私人的';
$txt['shd_ticket_private'] = '非公开的';
$txt['shd_ticket_change'] = '更改';
$txt['shd_ticket_ip'] = 'IP 地址';
$txt['shd_back_to_hd'] = '返回售后支持中心';
$txt['shd_go_to_replies'] = '转到回复';
$txt['shd_go_to_action_log'] = '转到操作日志';
$txt['shd_go_to_replies_start'] = '转到第一个回复';

$txt['shd_ticket_has_been_deleted'] = '此工单目前在回收站，不能在退回到服务台之前被更改。';
$txt['shd_ticket_replies_deleted'] = '此工单已删除之前的回复。';
$txt['shd_ticket_replies_deleted_view'] = '这些显示带有彩色背景。 <a href="%1$s">查看工单时不删除</a>。';
$txt['shd_ticket_replies_deleted_link'] = '请 <a href="%1$s">点击这里</a> 查看。';

$txt['shd_ticket_notnew'] = '您已经看到了这个';
$txt['shd_ticket_new'] = '新增！';

$txt['shd_linktree_move_ticket'] = '移动服务单';
$txt['shd_linktree_move_topic'] = '将主题移动到售后支持中心';

$txt['shd_cancel_ticket'] = '取消并返回到服务单';
$txt['shd_cancel_home'] = '取消并返回到售后支持中心主页';
$txt['shd_cancel_topic'] = '取消并返回主题';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = '回复服务单';
$txt['shd_ticket_quote'] = '引用回复';
$txt['shd_go_advanced'] = '升级！';
$txt['shd_ticket_edit_reply'] = '编辑回复';
$txt['shd_ticket_quote_short'] = '引用';
$txt['shd_ticket_markunread'] = '标记为未读';
$txt['shd_ticket_reply_short'] = '答复';
$txt['shd_ticket_edit'] = '编辑';
$txt['shd_ticket_resolved'] = '标记已解决';
$txt['shd_ticket_unresolved'] = '标记未解决的';
$txt['shd_ticket_assign'] = '分配';
$txt['shd_ticket_assign_self'] = '分配给我';
$txt['shd_ticket_reassign'] = '重新分配';
$txt['shd_ticket_unassign'] = '取消分配';
$txt['shd_ticket_delete'] = '删除';
$txt['shd_delete_confirm'] = '您确定要删除此工单吗？如果删除，此工单将被移动到回收站。';
$txt['shd_delete_reply_confirm'] = '您确定要删除此回复吗？如果已删除，此回复将被移动到回收站中。';
$txt['shd_delete_attach_confirm'] = '您确定要删除此附件吗？(此操作不能撤销！)';
$txt['shd_delete_attach'] = '删除这个附件';
$txt['shd_ticket_restore'] = '恢复';
$txt['shd_delete_permanently'] = '永久删除';
$txt['shd_delete_permanently_confirm'] = '您确定要永久删除此工单吗？此工单无法撤销！';
$txt['shd_ticket_move_to_topic'] = '移动到主题';
$txt['shd_move_dept'] = '移动深度。';
$txt['shd_actions'] = '行动';
$txt['shd_back_to_ticket'] = '发布后返回到此工单';
$txt['shd_disable_smileys_post'] = '关闭这个帖子中的表情';
$txt['shd_resolve_this_ticket'] = '标记此工单为已解决';
$txt['shd_override_cf'] = '覆盖自定义字段要求';
$txt['shd_silent_update'] = '静音更新 (不发送通知)';
$txt['shd_select_notifications'] = '选择要通知此回复的人...';

$txt['shd_ticket_assign_ticket'] = '分配任务单';
$txt['shd_ticket_assign_to'] = '分配工单到';

$txt['shd_ticket_move_dept'] = '移动工单到另一部门';
$txt['shd_ticket_move_to'] = '移动到';
$txt['shd_current_dept'] = '目前在部门';
$txt['shd_ticket_move'] = '移动工单';
$txt['shd_unknown_dept'] = '指定的部门不存在。';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = '新主题';
$txt['shd_move_ticket_to_topic'] = '移动工单到主题';
$txt['shd_move_ticket'] = '移动服务单';
$txt['shd_ticket_board'] = '棋盘';
$txt['shd_change_ticket_subject'] = '更改工单主题';
$txt['shd_move_send_pm'] = '向工单所有者发送私信';
$txt['shd_move_why'] = '请输入一个简短的描述，说明为什么这张工单被移动到论坛主题。';
$txt['shd_ticket_moved_subject'] = '您的工单已被移动。';
$txt['shd_move_default'] = '您好 {user}，' . "\n\n" . '您的工单， {subject}，已经从售后支持台转移到论坛的主题。' . "\n" . '您可以在棋盘 {board} 或通过此链接找到您的服务单：' . "\n\n" . '{link}' . "\n\n" . '谢谢！';

$txt['shd_move_topic_to_ticket'] = '将主题移动到售后支持中心';
$txt['shd_move_topic'] = '移动主题';
$txt['shd_change_topic_subject'] = '更改主题主题';
$txt['shd_move_send_pm_topic'] = '发送PM到主题启动器';
$txt['shd_move_why_topic'] = '请输入一个简短的描述，说明为什么这个主题被移动到服务台。 ';
$txt['shd_ticket_moved_subject_topic'] = '您的主题已被移动。';
$txt['shd_move_default_topic'] = '您好 {user}，' . "\n\n" . '您的主题 {subject}已经从论坛移动到服务台部分。' . "\n" . '您可以通过此链接找到您的主题：' . "\n\n" . '{link}' . "\n\n" . '谢谢！';

$txt['shd_user_no_hd_access'] = '注意：开始这个主题的人看不到帮助台！';
$txt['shd_user_helpdesk_access'] = '开始这个话题的人可以看到帮助台。';
$txt['shd_user_hd_access_dept_1'] = '开启此主题的人可以看到以下部门： ';
$txt['shd_user_hd_access_dept'] = '开启此主题的人可以看到以下部门： ';
$txt['shd_move_ticket_department'] = '移动工单到哪个部门';
$txt['shd_move_dept_why'] = '请输入一个简短的描述，说明为什么这张工单被移动到另一个部门。';
$txt['shd_move_dept_default'] = '您好 {user}，' . "\n\n" . '您的工单， {subject}，已经从 {current_dept} 部门移动到 {new_dept} 部门。' . "\n" . '您可以通过此链接找到您的服务单：' . "\n\n" . '{link}' . "\n\n" . '谢谢！';

$txt['shd_ticket_move_deleted'] = '此工单的回复当前在回收站。您想做什么？';
$txt['shd_ticket_move_deleted_abort'] = '中止，带我到回收站';
$txt['shd_ticket_move_deleted_delete'] = '继续，放弃已删除的回复 (不要将它们移动到新的主题)';
$txt['shd_ticket_move_deleted_undelete'] = '继续，取消删除回复(将它们移动到新的主题)';

$txt['shd_ticket_move_cfs'] = '此工单有可能需要移动的自定义字段。';
$txt['shd_ticket_move_cfs_warn'] = '其中有些字段可能对其他用户不可见。这些字段用一个挖掘标记标明。';
$txt['shd_ticket_move_cfs_warn_user'] = '您可以看到此字段，其他用户不能-但一旦它成为论坛的一部分。 每个能够进入论坛的人都能看到这种信息。';
$txt['shd_ticket_move_cfs_purge'] = '删除字段内容';
$txt['shd_ticket_move_cfs_embed'] = '保留字段并将其放在新的主题中';
$txt['shd_ticket_move_cfs_user'] = '当前对普通用户可见';
$txt['shd_ticket_move_cfs_staff'] = '当前工作人员可见';
$txt['shd_ticket_move_cfs_admin'] = '当前对管理员可见';
$txt['shd_ticket_move_accept'] = '我同意，在这里被操纵的一些字段并非所有用户都能看到。 本主题应移至论坛，并附有上述设置。';
$txt['shd_ticket_move_reqd'] = '必须选择此选项才能将工单移动到论坛。';
$txt['shd_ticket_move_ok'] = '此字段可以安全移动，所有可以看到工单的用户都可以看到此字段。 没有隐藏用户或员工的信息。';
$txt['shd_ticket_move_reqd_nonselected'] = '此工单有用户或员工可能无法查看的字段。 所以您需要特别确认您对此的认识 - 请回到前一页， 确认您对此的认识的复选框位于表单底部。';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = '回收站';
$txt['shd_recycle_greeting'] = '这是回收站。所有删除的工单都在这里，但具有特殊权限的工作人员可以永久从这里移除工单。';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = '创建任务单';
$txt['shd_edit_ticket'] = '编辑服务单';
$txt['shd_edit_ticket_linktree'] = '编辑工单(%s)';
$txt['shd_ticket_subject'] = '工单主题';
$txt['shd_ticket_proxy'] = '代表发帖';
$txt['shd_ticket_post_error'] = '下面的问题或问题发生在试图发布此票时';
$txt['shd_reply_ticket'] = '回复服务单';
$txt['shd_reply_ticket_linktree'] = '回复工单(%s)';
$txt['shd_edit_reply_linktree'] = '编辑回复 (%s)';
$txt['shd_previewing_ticket'] = '预览服务单';
$txt['shd_previewing_reply'] = '预览回复到';
$txt['shd_choose_one'] = '[选择一个]';
$txt['shd_no_value'] = '[无值]';
$txt['shd_ticket_dept'] = '工单部门';
$txt['shd_select_dept'] = '-- 选择部门 --';
$txt['canned_replies'] = '添加预定义的回复：';
$txt['canned_replies_select'] = '-- 选择回复 --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = '从IP发布的服务台回复 (范围)';
$txt['shd_no_replies_from_ip'] = '没有找到指定IP(范围)的售后支持中心回复';
$txt['shd_replies_from_ip_desc'] = '下面是此IP(范围)发布到售后支持中心的所有消息列表。';
$txt['shd_is_ticket_opener'] = ' (工单启动)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2 存档';
$txt['shd_attachtype_gz'] = 'GZip 存档';
$txt['shd_attachtype_rar'] = 'Rar/WinRAR 存档';
$txt['shd_attachtype_zip'] = 'Zip 存档';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) 音频文件';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windows 位图图像';
$txt['shd_attachtype_gif'] = '图形交换格式 (GIF) 图像';
$txt['shd_attachtype_jpeg'] = '联合摄影专家组(图片专家组)图像';
$txt['shd_attachtype_jpg'] = '联合摄影专家组(图片专家组)图像';
$txt['shd_attachtype_png'] = '便携式网络图形 (PNG) 图像';
$txt['shd_attachtype_svg'] = '可缩放矢量图形(SVG) 图像';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows 媒体视频电影';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Word文档';
$txt['shd_attachtype_mdb'] = 'Microsoft 访问数据库';
$txt['shd_attachtype_ppt'] = 'Microsoft Powerpoint 演示文稿';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ 源文件';
$txt['shd_attachtype_php'] = 'PHP 脚本';
$txt['shd_attachtype_py'] = 'Python 源文件';
$txt['shd_attachtype_rb'] = 'Ruby 源文件';
$txt['shd_attachtype_sql'] = 'SQL 脚本';
// Proprietory formats
$txt['shd_attachtype_kml'] = '谷歌地球(KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth(KML 归档)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Portable 文档文件';
$txt['shd_attachtype_psd'] = 'Adobe Photoshop 文档';
$txt['shd_attachtype_swf'] = 'Adobe Flash 文件';
// Miscellaneous
$txt['shd_attachtype_exe'] = '可执行文件 (Windows)';
$txt['shd_attachtype_htm'] = '超文本标记文档 (HTML)';
$txt['shd_attachtype_html'] = '超文本标记文档 (HTML)';
$txt['shd_attachtype_rtf'] = '富文本格式 (RTF)';
$txt['shd_attachtype_txt'] = '纯文本';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = '工单操作日志';
$txt['shd_ticket_log_count_one'] = '1 篇文章';
$txt['shd_ticket_log_count_more'] = '%s 个条目';
$txt['shd_ticket_log_none'] = '此工单没有任何更改。';
$txt['shd_ticket_log_member'] = '成员';
$txt['shd_ticket_log_ip'] = '会员 IP：';
$txt['shd_ticket_log_date'] = '日期';
$txt['shd_ticket_log_action'] = '行 动';
$txt['shd_ticket_log_full'] = '转到全部动作日志 (所有工单)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = '相关工单';
$txt['shd_ticket_create_relationship'] = '创建关系';
$txt['shd_ticket_delete_relationship'] = '删除关系';
$txt['shd_ticket_reltype'] = '选择类型';
$txt['shd_ticket_reltype_linked'] = '关联到';
$txt['shd_ticket_reltype_duplicated'] = '复制于';
$txt['shd_ticket_reltype_parent'] = '父级为';
$txt['shd_ticket_reltype_child'] = '子项';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = '补充资料';
$txt['shd_ticket_additional_details'] = '更多详细信息';
$txt['shd_ticket_empty_field'] = '此字段为空。';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = '通知';
$txt['shd_ticket_notify_noneprefs'] = '您的用户偏好设置不说明此工单的通知。';
$txt['shd_ticket_notify_changeprefs'] = '更改您的首选项';
$txt['shd_ticket_notify_because'] = '您的偏好通知您对此工单的答复：';
$txt['shd_ticket_notify_because_yourticket'] = '因为这是您的工单';
$txt['shd_ticket_notify_because_assignedyou'] = '它被分配给你';
$txt['shd_ticket_notify_because_priorreply'] = '您之前回复了它';
$txt['shd_ticket_notify_because_anyreply'] = '任何任务单';

$txt['shd_ticket_notify_me_always'] = '您正在监视此工单(每次回复都会收到通知)';
$txt['shd_ticket_monitor_on_note'] = '您可以通过电子邮件监视所有对此工单的回复，而不论您的偏好：';
$txt['shd_ticket_monitor_off_note'] = '您可以关闭对此工单的监控，改用您的偏好设置：';
$txt['shd_ticket_monitor_on'] = '打开监测';
$txt['shd_ticket_monitor_off'] = '关闭监测';
$txt['shd_ticket_notify_me_never_note'] = '您可以忽略此工单的电子邮件更新，不管您的偏好：';
$txt['shd_ticket_notify_me_never'] = '您已关闭此工单的所有通知。';
$txt['shd_ticket_notify_me_never_on'] = '关闭通知';
$txt['shd_ticket_notify_me_never_off'] = '打开通知';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = '搜索设施可能不会列出所有可用的工单；目前正在对其进行调查。';
$txt['shd_search_warning_admin'] = '搜索设施需要重建索引。您可以从服务台区域的维护选项，在管理面板上实现这一点。';
$txt['shd_search'] = '搜索工单';
$txt['shd_search_results'] = '搜索工单-结果';
$txt['shd_search_text'] = '您正在寻找的单词：';
$txt['shd_search_match'] = '什么应该匹配？';
$txt['shd_search_match_all'] = '匹配提供的所有单词';
$txt['shd_search_match_any'] = '匹配所提供的任何单词';
$txt['shd_search_scope'] = '包含哪种类型的工单：';
$txt['shd_search_scope_open'] = '打开工单';
$txt['shd_search_scope_closed'] = '已关闭的工单';
$txt['shd_search_scope_recycle'] = '回收站中的物品';
$txt['shd_search_result_ticket'] = '任务单 %1$s';
$txt['shd_search_result_reply'] = '回复任务单 %1$s';
$txt['shd_search_last_updated'] = '最后更新：';
$txt['shd_search_ticket_opened_by'] = '工单由：';
$txt['shd_search_ticket_replied_by'] = '工单回复：';
$txt['shd_search_dept'] = '搜索哪个部门:';

$txt['shd_search_urgency'] = '包含紧急程度：';

$txt['shd_search_where'] = '要搜索的项目：';
$txt['shd_search_where_tickets'] = '机票实体';
$txt['shd_search_where_replies'] = '在工单中的回复';
$txt['shd_search_where_subjects'] = '工单主题';

$txt['shd_search_ticket_starter'] = '工单开始于：';
$txt['shd_search_ticket_assignee'] = '工单分配给：';
$txt['shd_search_ticket_named_person'] = '输入您感兴趣的人的姓名。';

$txt['shd_search_no_results'] = '没有找到给定条件的结果。您可能希望返回并尝试更改您的搜索条件。';
$txt['shd_search_criteria'] = '搜索条件：';
$txt['shd_search_excluded'] = '如果选择了所有可能的选项，则未列入上述内容(例如： 如果所有可能的紧急程度都打勾，它就不会在上面说过，所以你可以集中精力于您搜索的特定内容)';
//@}