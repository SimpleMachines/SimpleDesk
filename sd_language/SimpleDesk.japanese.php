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
$txt['shd_helpdesk'] = 'ヘルプデスク';
$txt['shd_helpdesk_maintenance'] = 'ヘルプデスクは現在 <strong>メンテナンスモード</strong>にあります。フォーラム管理者とヘルプデスク管理者のみが閲覧できます。';
$txt['shd_open_ticket'] = 'チケットを開く';
$txt['shd_open_tickets'] = 'チケットを開く';
$txt['shd_none'] = 'なし';

$txt['shd_display_nojs'] = 'お使いのブラウザでJavaScriptが有効になっていません。一部の関数が正常に動作しない、または予期せぬ動作をすることがあります。';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'ヘルプデスク管理センターへようこそ！';
$txt['shd_admin_title'] = 'ヘルプデスク管理センター';
$txt['shd_staff_list'] = 'ヘルプデスク スタッフ';
$txt['shd_update_available'] = '新しいバージョンが利用可能です！';
$txt['shd_update_message'] = 'SimpleDeskの新しいバージョンがリリースされました。 安全を確保し、当社の修正が提供するすべての機能を楽しむために、 <a href="#" id="update-link">最新バージョン</a> にアップデートすることをお勧めします。' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>このリリースの新着情報については、 <a href="#" id="information-link" target="_blank">ウェブサイト</a>をご覧ください。</span><br>' . "\n\n" . '<strong>SimpleDeskチーム</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = '低い';
$txt['shd_urgency_1'] = 'ミディアム';
$txt['shd_urgency_2'] = '高い';
$txt['shd_urgency_3'] = '非常に高い';
$txt['shd_urgency_4'] = '深刻な';
$txt['shd_urgency_5'] = 'Critical';
$txt['shd_urgency_increase'] = '増加';
$txt['shd_urgency_decrease'] = '減らす';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = '新規作成';
$txt['shd_status_1'] = '保留中のスタッフコメント';
$txt['shd_status_2'] = '保留中のユーザーコメント';
$txt['shd_status_3'] = '解決済み/終了';
$txt['shd_status_4'] = 'スーパーバイザーへの参照';
$txt['shd_status_5'] = 'エスカレート - 緊急性';
$txt['shd_status_6'] = '削除しました';
$txt['shd_status_7'] = '保留中';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = '新規チケット';
$txt['shd_status_1_heading'] = 'スタッフ待機中のチケット';
$txt['shd_status_2_heading'] = 'ユーザーの応答を待っているチケット';
$txt['shd_status_3_heading'] = 'クローズされたチケット';
$txt['shd_status_4_heading'] = '管理者が参照するチケット';
$txt['shd_status_5_heading'] = '緊急チケット';
$txt['shd_status_6_heading'] = 'リサイクルチケット';
$txt['shd_status_7_heading'] = '保留中のチケット';
$txt['shd_status_assigned_heading'] = '自分にアサインしました';
$txt['shd_status_withdeleted_heading'] = '削除した返信のあるチケット';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'オープンチケット';
$txt['shd_tickets_closed'] = 'クローズされたチケット';
$txt['shd_tickets_recycled'] = 'リサイクルチケット';

$txt['shd_assigned'] = '割り当て';
$txt['shd_unassigned'] = '未割り当て';

$txt['shd_read_ticket'] = '既読のチケット';
$txt['shd_unread_ticket'] = '未読のチケット';
$txt['shd_unread_tickets'] = '未読のチケット';

$txt['shd_owned'] = '所有チケット'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'チケット';
$txt['shd_count_tickets'] = 'チケット';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'ヘルプデスクへのアクセスは許可されていません。';
$txt['shd_no_ticket'] = 'リクエストしたチケットは存在しません。';
$txt['shd_no_reply'] = 'リクエストしたチケットの返信が存在しないか、このチケットの一部ではありません。';
$txt['shd_no_topic'] = 'リクエストしたトピックは存在しません。';
$txt['shd_ticket_no_perms'] = 'チケットを表示する権限がありません。';
$txt['shd_error_no_tickets'] = 'チケットが見つかりません。';
$txt['shd_inactive'] = 'ヘルプデスクは現在非アクティブ化されています。';
$txt['shd_cannot_assign'] = 'チケットを割り当てることはできません。';
$txt['shd_cannot_assign_other'] = 'このチケットはすでに他のユーザーに割り当てられています。自分自身に割り当てることはできません - 管理者に連絡してください。';
$txt['shd_no_staff_assign'] = 'スタッフが設定されていません。チケットを割り当てることはできません。管理者に連絡してください。';
$txt['shd_assigned_not_permitted'] = 'このチケットの割り当てをリクエストしたユーザーには、それを見るための十分な権限がありません。';
$txt['shd_cannot_resolve'] = 'このチケットを解決済みとしてマークする権限がありません。';
$txt['shd_cannot_unresolve'] = '解決済みのチケットを再度開く権限がありません．';
$txt['error_shd_cannot_resolve_children'] = 'このチケットは現在クローズできません。このチケットは現在オープンしている1つまたは複数のチケットの親です。';
$txt['error_shd_proxy_unknown'] = 'このチケットが代わりに投稿されたユーザーは存在しません。';
$txt['shd_cannot_change_privacy'] = 'このチケットのプライバシーを変更する権限がありません。';
$txt['shd_cannot_change_urgency'] = 'このチケットの緊急性を変更する許可を持っていません。';
$txt['shd_ajax_problem'] = 'ページの読み込み中に問題が発生しました。もう一度やり直しますか？';
$txt['shd_cannot_move_ticket'] = 'このチケットをトピックに移動する権限がありません。';
$txt['shd_cannot_move_topic'] = 'このトピックをチケットに移動する権限がありません．';
$txt['shd_moveticket_noboards'] = 'このチケットを移動するボードがありません！';
$txt['shd_move_no_pm'] = 'チケット所有者に送信するためにチケットを移動する理由を入力する必要があります または、「チケット所有者にPMを送信する」オプションのチェックを外します。';
$txt['shd_move_no_pm_topic'] = 'トピックを移動する理由を入力する必要があります。 または、「トピックスターターにPMを送信する」オプションのチェックを外してください。';
$txt['shd_move_topic_not_created'] = 'チケットをボードに移動できませんでした。もう一度やり直してください。';
$txt['shd_move_ticket_not_created'] = 'トピックをヘルプデスクに移動できませんでした。もう一度やり直してください。';
$txt['shd_no_replies'] = 'このチケットにはまだ返信がありません。';
$txt['cannot_shd_new_ticket'] = '新しいチケットを作成する権限がありません。';
$txt['cannot_shd_edit_ticket'] = 'このチケットを編集する権限がありません。';
$txt['shd_cannot_reply_any'] = 'チケットに返信する権限がありません。';
$txt['shd_cannot_reply_any_but_own'] = '自分以外のチケットに返信する権限がありません。';
$txt['shd_cannot_edit_reply_any'] = '返信を編集する権限がありません。';
$txt['shd_cannot_edit_reply_any_but_own'] = '自分の返信以外のチケットへの返信を編集する権限がありません。';
$txt['shd_cannot_edit_closed'] = '解決済みのチケットを編集することはできません。最初に未解決のチケットをマークする必要があります。';
$txt['shd_cannot_edit_deleted'] = 'ごみ箱のチケットを編集することはできません。最初に復元する必要があります。';
$txt['shd_cannot_reply_closed'] = '解決済みのチケットに返信することはできません。最初に未解決のチケットにマークを付ける必要があります。';
$txt['shd_cannot_reply_deleted'] = 'ごみ箱のチケットに返信することはできません。最初に復元する必要があります。';
$txt['shd_cannot_delete_ticket'] = 'このチケットを削除することはできません。';
$txt['shd_cannot_delete_reply'] = 'その返信を削除することはできません。';
$txt['shd_cannot_restore_ticket'] = 'ごみ箱からこのチケットを復元することはできません。';
$txt['shd_cannot_restore_reply'] = 'ごみ箱から返信を復元することはできません。';
$txt['shd_cannot_view_resolved'] = '解決済みチケットへのアクセスは許可されていません。';
$txt['cannot_shd_access_recyclebin'] = 'ごみ箱にアクセスできません。';
$txt['shd_cannot_move_ticket_with_deleted'] = 'このチケットをフォーラムに移動することはできません。現在の権限ではアクセスが許可されていない、削除された返信があります。';
$txt['shd_cannot_attach_ext'] = '添付しようとしたファイルの種類（{ext}）はここでは許可されていません。許可されているファイルの種類は次のとおりです: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'このチケットは現在変更できません。';
$txt['shd_invalid_relation'] = 'これらのチケットに有効なリレーションタイプを指定する必要があります。';
$txt['shd_no_relation_delete'] = '存在しないリレーションシップは削除できません。';
$txt['shd_cannot_relate_self'] = 'チケットを自分自身に関連付けることはできません。';
$txt['shd_relationships_are_disabled'] = 'チケットのリレーションシップは現在無効です。';
$txt['error_invalid_fields'] = '次のフィールドには使用できない値があります: %1$s';
$txt['error_missing_fields'] = '次のフィールドは完了しておらず、必要があります: %1$s';
$txt['error_missing_multi'] = '%1$s (少なくとも %2$d を選択する必要があります)';
$txt['error_no_dept'] = 'このチケットを投稿する部署が選択されていません。';
$txt['shd_cannot_move_dept'] = 'このチケットを移動することはできません。移動する場所がありません。';
$txt['shd_no_perm_move_dept'] = 'このチケットを他の部署に移動することはできません。';
$txt['cannot_shd_delete_attachment'] = '添付ファイルを削除する権限がありません。';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'このチケットをトピックに移動することはできません。移動を確認するために管理者が必要なカスタムフィールドがあります。';
$txt['cannot_monitor_ticket'] = 'このチケットのモニタリングを有効にすることはできません。';
$txt['cannot_unmonitor_ticket'] = 'このチケットのモニタリングをオフにすることはできません。';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'ヘルプデスク'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = '部門'; // ditto
$txt['shd_new_ticket'] = '新しいチケットを投稿';
$txt['shd_new_ticket_proxy'] = 'プロキシチケットの投稿';
$txt['shd_helpdesk_profile'] = 'ヘルプデスクのプロフィール';
$txt['shd_welcome'] = 'ようこそ、 %sさん！';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = '伝票へ移動';
$txt['shd_options'] = 'オプション';
$txt['shd_search_menu'] = '検索';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = '情報';
$txt['shd_admin_options'] = 'オプション';
$txt['shd_admin_custom_fields'] = 'カスタムフィールド';
$txt['shd_admin_departments'] = '部門';
$txt['shd_admin_permissions'] = 'アクセス許可';
$txt['shd_admin_plugins'] = 'プラグイン';
$txt['shd_admin_cannedreplies'] = 'Canned Replies';
$txt['shd_admin_maint'] = 'メンテナンス';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'ここでは、サイトスタッフが行動するための新しいチケットを提出し、現在進行中のチケットを確認することができます。';
$txt['shd_staff_greeting'] = 'ここに注意が必要なすべてのチケットがあります。';
$txt['shd_shd_greeting'] = 'これはヘルプデスクです。初心者のために時間を無駄にしています。お楽しみください！;D';
$txt['shd_closed_user_greeting'] = 'これらは、ヘルプデスクに投稿したクローズ/解決済みチケットです。';
$txt['shd_closed_staff_greeting'] = 'これらはすべて、ヘルプデスクに提出されたクローズ/解決済みのチケットです。';
$txt['shd_category_filter'] = 'カテゴリのフィルタリング';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'チケットが作成されました！';
$txt['shd_ticket_posted_body'] = 'チケットを投稿していただきありがとうございます、 {membername}！' . "\n\n" . 'ヘルプデスクのスタッフがレビューを行い、できるだけ早くご連絡いたします。' . "\n\n" . 'その間、チケットを見ることができます。 &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; 次の URL で:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]別のチケットを開く[/iurl] | [iurl={helpdesklink}]メインヘルプデスクに戻る[/iurl] | [iurl={forumlink}]フォーラムに戻る[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'チケットの変更に関するメール通知は、[iurl={prefslink}]ヘルプデスク 環境設定[/iurl] で有効にできます。';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'よろしくお願いいたします。' . "\n" . '{forum_name} チーム';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'チケットの詳細';
$txt['shd_ticket_updated'] = '更新日時';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = '名前';
$txt['shd_ticket_user'] = 'ユーザー';
$txt['shd_ticket_date'] = '投稿済み';
$txt['shd_ticket_urgency'] = '<unk>';
$txt['shd_ticket_assigned'] = '割り当て';
$txt['shd_ticket_assignedto'] = '割り当て先';
$txt['shd_ticket_started_by'] = '起案者';
$txt['shd_ticket_updated_by'] = '更新者';
$txt['shd_ticket_status'] = 'ステータス';
$txt['shd_ticket_num_replies'] = '返信';
$txt['shd_ticket_replies'] = '返信';
$txt['shd_ticket_staff'] = 'スタッフメンバー';
$txt['shd_ticket_attachments'] = '添付ファイル';
$txt['shd_ticket_reply_number'] = '返信 <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = '保留中のチケット';
$txt['shd_ticket'] = 'チケット';
$txt['shd_reply_written'] = '%s に返信しました'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = '一切なし';
$txt['shd_linktree_tickets'] = 'チケット';
$txt['shd_ticket_privacy'] = 'プライバシー';
$txt['shd_ticket_notprivate'] = '非公開ではない';
$txt['shd_ticket_private'] = '非公開';
$txt['shd_ticket_change'] = '変更';
$txt['shd_ticket_ip'] = 'IP アドレス';
$txt['shd_back_to_hd'] = 'ヘルプデスクに戻る';
$txt['shd_go_to_replies'] = '返信に移動';
$txt['shd_go_to_action_log'] = 'アクションログへ移動';
$txt['shd_go_to_replies_start'] = '最初の返信に移動';

$txt['shd_ticket_has_been_deleted'] = 'このチケットは現在ごみ箱にあり、ヘルプデスクに戻さずに変更することはできません。';
$txt['shd_ticket_replies_deleted'] = 'このチケットは以前に削除された返信がありました。';
$txt['shd_ticket_replies_deleted_view'] = 'これらは背景色で表示されます。 <a href="%1$s">削除せずにチケットを表示</a>.';
$txt['shd_ticket_replies_deleted_link'] = '<a href="%1$s">こちら</a> をクリックして表示してください。';

$txt['shd_ticket_notnew'] = 'あなたはすでにこれを見ています';
$txt['shd_ticket_new'] = '新規！';

$txt['shd_linktree_move_ticket'] = '伝票を移動';
$txt['shd_linktree_move_topic'] = 'トピックをヘルプデスクに移動';

$txt['shd_cancel_ticket'] = 'キャンセルしてチケットに戻る';
$txt['shd_cancel_home'] = 'キャンセルしてヘルプデスクの自宅に戻る';
$txt['shd_cancel_topic'] = 'キャンセルしてトピックに戻る';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'チケットに返信';
$txt['shd_ticket_quote'] = '見積もりで返信';
$txt['shd_go_advanced'] = '進めましょう！';
$txt['shd_ticket_edit_reply'] = '返信を編集';
$txt['shd_ticket_quote_short'] = '引用';
$txt['shd_ticket_markunread'] = '未読にする';
$txt['shd_ticket_reply_short'] = '返信';
$txt['shd_ticket_edit'] = '編集';
$txt['shd_ticket_resolved'] = '解決済みのマーク';
$txt['shd_ticket_unresolved'] = '未解決にする';
$txt['shd_ticket_assign'] = '割り当て';
$txt['shd_ticket_assign_self'] = '自分に割り当てる';
$txt['shd_ticket_reassign'] = '再割り当て';
$txt['shd_ticket_unassign'] = '未割り当て';
$txt['shd_ticket_delete'] = '削除';
$txt['shd_delete_confirm'] = 'このチケットを削除してもよろしいですか？削除した場合、このチケットはリサイクルボックスに移動されます。';
$txt['shd_delete_reply_confirm'] = 'この返信を削除してもよろしいですか？削除した場合、この返信はリサイクル箱に移動されます。';
$txt['shd_delete_attach_confirm'] = 'この添付ファイルを削除してもよろしいですか？（元に戻すことはできません）';
$txt['shd_delete_attach'] = 'この添付ファイルを削除';
$txt['shd_ticket_restore'] = '復元';
$txt['shd_delete_permanently'] = '完全に削除';
$txt['shd_delete_permanently_confirm'] = 'このチケットを完全に削除してもよろしいですか？この操作は元に戻すことはできません！';
$txt['shd_ticket_move_to_topic'] = 'トピックに移動';
$txt['shd_move_dept'] = '部分の移動';
$txt['shd_actions'] = 'アクション';
$txt['shd_back_to_ticket'] = '投稿後にこのチケットに戻る';
$txt['shd_disable_smileys_post'] = 'この投稿でスマイリーをオフにする';
$txt['shd_resolve_this_ticket'] = 'このチケットを解決済みにする';
$txt['shd_override_cf'] = 'カスタムフィールドの要件を上書きする';
$txt['shd_silent_update'] = 'サイレントアップデート（通知なし）';
$txt['shd_select_notifications'] = 'この返信を通知する人を選択してください...';

$txt['shd_ticket_assign_ticket'] = 'チケットの割り当て';
$txt['shd_ticket_assign_to'] = 'チケットを割り当てる';

$txt['shd_ticket_move_dept'] = 'チケットを別の部署に移動';
$txt['shd_ticket_move_to'] = '移動先:';
$txt['shd_current_dept'] = '現在部署にいます';
$txt['shd_ticket_move'] = 'チケットを移動';
$txt['shd_unknown_dept'] = '指定された部署は存在しません。';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = '新しい件名';
$txt['shd_move_ticket_to_topic'] = 'チケットをトピックに移動';
$txt['shd_move_ticket'] = '伝票を移動';
$txt['shd_ticket_board'] = 'ボード';
$txt['shd_change_ticket_subject'] = 'チケットのタイトルを変更する';
$txt['shd_move_send_pm'] = 'チケット所有者にPMを送信する';
$txt['shd_move_why'] = 'このチケットがフォーラムのトピックに移動される理由について簡単な説明を入力してください。';
$txt['shd_ticket_moved_subject'] = 'チケットが移動されました。';
$txt['shd_move_default'] = 'こんにちは、 {user} さん。' . "\n\n" . 'チケット「 {subject}」は、ヘルプデスクからフォーラム内のトピックに移動されました。' . "\n" . 'チケットは、ボード {board} またはこのリンクから見つけることができます：' . "\n\n" . '{link}' . "\n\n" . 'Thanks';

$txt['shd_move_topic_to_ticket'] = 'トピックをヘルプデスクに移動';
$txt['shd_move_topic'] = 'トピックを移動';
$txt['shd_change_topic_subject'] = 'トピックの件名を変更する';
$txt['shd_move_send_pm_topic'] = 'トピックスターターにPMを送信する';
$txt['shd_move_why_topic'] = 'このトピックがヘルプデスクに移動されている理由について簡単な説明を入力してください。 ';
$txt['shd_ticket_moved_subject_topic'] = 'トピックが移動されました。';
$txt['shd_move_default_topic'] = 'こんにちは、 {user} さん。' . "\n\n" . 'あなたのトピック、 {subject}はフォーラムからヘルプデスクに移動されました。' . "\n" . 'このリンクからトピックを見つけることができます:' . "\n\n" . '{link}' . "\n\n" . 'Thanks';

$txt['shd_user_no_hd_access'] = '注意: このトピックを開始した人はヘルプデスクを見ることができません!';
$txt['shd_user_helpdesk_access'] = 'このトピックを始めた人はヘルプデスクを見ることができます。';
$txt['shd_user_hd_access_dept_1'] = 'このトピックを開始した人は、次の部門を見ることができます: ';
$txt['shd_user_hd_access_dept'] = 'このトピックを開始した人は、次の部門を見ることができます: ';
$txt['shd_move_ticket_department'] = 'チケットをどの部署に移動する';
$txt['shd_move_dept_why'] = 'このチケットが別の部署に移動される理由について簡単な説明を入力してください。';
$txt['shd_move_dept_default'] = 'こんにちは、 {user} さん。' . "\n\n" . 'チケット {subject}は、 {current_dept} 部署から {new_dept} 部署に移動されました。' . "\n" . 'このリンクからチケットを見つけることができます:' . "\n\n" . '{link}' . "\n\n" . 'Thanks';

$txt['shd_ticket_move_deleted'] = 'このチケットには現在ごみ箱にある返信があります。何をしたいですか？';
$txt['shd_ticket_move_deleted_abort'] = '中止、ごみ箱に連れて行ってください';
$txt['shd_ticket_move_deleted_delete'] = '続けて、削除された返信を放棄します（新しいトピックに移動しないでください）';
$txt['shd_ticket_move_deleted_undelete'] = '続けて返信を取り消します（新しいトピックに移動します）';

$txt['shd_ticket_move_cfs'] = 'このチケットには移動する必要があるカスタムフィールドがあります。';
$txt['shd_ticket_move_cfs_warn'] = 'これらのフィールドの一部は他のユーザーには表示されない場合があります。これらのフィールドは感嘆符で示されます。';
$txt['shd_ticket_move_cfs_warn_user'] = 'あなたはこのフィールドを見ることができますが、他のユーザーはできません - しかし、それはフォーラムの一部になったら。 フォーラムにアクセスできる全員に見られるようになります';
$txt['shd_ticket_move_cfs_purge'] = 'フィールドの内容を削除';
$txt['shd_ticket_move_cfs_embed'] = 'フィールドを保持し、新しいトピックに入れる';
$txt['shd_ticket_move_cfs_user'] = '現在通常のユーザーに表示されます';
$txt['shd_ticket_move_cfs_staff'] = '現在スタッフメンバーに表示されます';
$txt['shd_ticket_move_cfs_admin'] = '管理者に表示中';
$txt['shd_ticket_move_accept'] = 'ここで操作されているフィールドの一部は、すべてのユーザーに表示されていないことを受け入れます。 このトピックは、上記の設定でフォーラムに移動する必要があります。';
$txt['shd_ticket_move_reqd'] = 'このチケットをフォーラムに移動するには、このオプションを選択する必要があります。';
$txt['shd_ticket_move_ok'] = 'この項目は安全に移動でき、チケットを見ることができるすべてのユーザーはこの項目を見ることができます。 利用者やスタッフから隠された情報はありません';
$txt['shd_ticket_move_reqd_nonselected'] = 'このチケットには、ユーザーまたはスタッフが見ることができないフィールドがあります これに気づいていることを確認する必要がある場合は、前のページに戻ってください。 確認用のチェックボックスはフォームの下にあります';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'ごみ箱を再利用する';
$txt['shd_recycle_greeting'] = 'これはリサイクル用のビンです。削除されたすべてのチケットはここに移動しますが、特別な権限を持つスタッフはここから永久にチケットを削除できます。';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'チケットを作成';
$txt['shd_edit_ticket'] = '伝票の編集';
$txt['shd_edit_ticket_linktree'] = 'チケットの編集 (%s)';
$txt['shd_ticket_subject'] = 'チケットの件名';
$txt['shd_ticket_proxy'] = '次に代わって投稿する';
$txt['shd_ticket_post_error'] = 'このチケットの投稿中に、次の問題または問題が発生しました';
$txt['shd_reply_ticket'] = 'チケットに返信';
$txt['shd_reply_ticket_linktree'] = 'チケットに返信 (%s)';
$txt['shd_edit_reply_linktree'] = '返信を編集 (%s)';
$txt['shd_previewing_ticket'] = '伝票のプレビュー';
$txt['shd_previewing_reply'] = '返信をプレビュー中';
$txt['shd_choose_one'] = 'format@@0';
$txt['shd_no_value'] = '[価値なし]';
$txt['shd_ticket_dept'] = 'チケット部門';
$txt['shd_select_dept'] = '-- 部署を選択 --';
$txt['canned_replies'] = '事前定義された返信を追加:';
$txt['canned_replies_select'] = '-- 返信を選択 --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'ヘルプデスクからの返信 (範囲)';
$txt['shd_no_replies_from_ip'] = '指定されたIP（範囲）からのヘルプデスクの返信が見つかりませんでした';
$txt['shd_replies_from_ip_desc'] = '以下は、この IP (範囲) からヘルプデスクに投稿されたすべてのメッセージの一覧です。';
$txt['shd_is_ticket_opener'] = ' (チケットスターター)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'BZip2 アーカイブ';
$txt['shd_attachtype_gz'] = 'GZip アーカイブ';
$txt['shd_attachtype_rar'] = 'Rar/WinRARアーカイブ';
$txt['shd_attachtype_zip'] = 'Zipアーカイブ';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'MP3 (MPEG Layer III) オーディオ ファイル';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Windowsビットマップ画像';
$txt['shd_attachtype_gif'] = 'グラフィックインターチェンジフォーマット (GIF) イメージ';
$txt['shd_attachtype_jpeg'] = '共同写真専門家グループ(JPEG) 画像';
$txt['shd_attachtype_jpg'] = '共同写真専門家グループ(JPEG) 画像';
$txt['shd_attachtype_png'] = 'Portable Network Graphic (PNG) image';
$txt['shd_attachtype_svg'] = 'スケーラブルなベクトルグラフィック (SVG) 画像';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Windows Media Video movie';
// Office formats
$txt['shd_attachtype_doc'] = 'Microsoft Word ドキュメント';
$txt['shd_attachtype_mdb'] = 'Microsoft Access データベース';
$txt['shd_attachtype_ppt'] = 'Microsoft Powerpoint プレゼンテーション';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'C++ ソースファイル';
$txt['shd_attachtype_php'] = 'PHPスクリプト';
$txt['shd_attachtype_py'] = 'Python ソースファイル';
$txt['shd_attachtype_rb'] = 'Ruby ソースファイル';
$txt['shd_attachtype_sql'] = 'SQL スクリプト';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (KMLアーカイブ)';
$txt['shd_attachtype_pdf'] = 'Adobe Acrobat Portable Document File';
$txt['shd_attachtype_psd'] = 'Adobe Photoshopドキュメント';
$txt['shd_attachtype_swf'] = 'Adobe Flash ファイル';
// Miscellaneous
$txt['shd_attachtype_exe'] = '実行ファイル(Windows)';
$txt['shd_attachtype_htm'] = 'ハイパーテキストマークアップドキュメント（HTML）';
$txt['shd_attachtype_html'] = 'ハイパーテキストマークアップドキュメント（HTML）';
$txt['shd_attachtype_rtf'] = 'リッチテキスト形式 (RTF)';
$txt['shd_attachtype_txt'] = 'プレーンテキスト';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'チケットのアクションログ';
$txt['shd_ticket_log_count_one'] = '1 個の項目';
$txt['shd_ticket_log_count_more'] = '%s 項目';
$txt['shd_ticket_log_none'] = 'このチケットは変更されていません。';
$txt['shd_ticket_log_member'] = 'メンバー';
$txt['shd_ticket_log_ip'] = 'メンバー IP:';
$txt['shd_ticket_log_date'] = '日付';
$txt['shd_ticket_log_action'] = 'アクション';
$txt['shd_ticket_log_full'] = 'フルアクションログに移動します (すべてのチケット)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = '関連するチケット';
$txt['shd_ticket_create_relationship'] = '関連を作成';
$txt['shd_ticket_delete_relationship'] = '関連を削除';
$txt['shd_ticket_reltype'] = '種類を選択';
$txt['shd_ticket_reltype_linked'] = 'リンク先：';
$txt['shd_ticket_reltype_duplicated'] = '複製:';
$txt['shd_ticket_reltype_parent'] = '親の';
$txt['shd_ticket_reltype_child'] = '子要素:';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = '追加情報';
$txt['shd_ticket_additional_details'] = '追加情報';
$txt['shd_ticket_empty_field'] = 'このフィールドは空です。';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = '通知';
$txt['shd_ticket_notify_noneprefs'] = 'あなたのユーザー設定は、このチケットの通知には反映されません。';
$txt['shd_ticket_notify_changeprefs'] = '設定を変更する';
$txt['shd_ticket_notify_because'] = 'このチケットへの返信を通知する設定:';
$txt['shd_ticket_notify_because_yourticket'] = 'それがあなたの切符であるように';
$txt['shd_ticket_notify_because_assignedyou'] = 'あなたに割り当てられているので';
$txt['shd_ticket_notify_because_priorreply'] = '前に答えたように';
$txt['shd_ticket_notify_because_anyreply'] = 'どんなチケット';

$txt['shd_ticket_notify_me_always'] = 'このチケットを監視しています（返信ごとに通知が届きます）';
$txt['shd_ticket_monitor_on_note'] = '好みに関係なく、このチケットへのすべての返信を電子メールで監視できます:';
$txt['shd_ticket_monitor_off_note'] = 'このチケットのモニタリングをオフにして、代わりに以下の設定を使用してください:';
$txt['shd_ticket_monitor_on'] = 'モニタリングをONにする';
$txt['shd_ticket_monitor_off'] = 'モニタリングをオフにする';
$txt['shd_ticket_notify_me_never_note'] = '設定に関係なく、このチケットのメール更新を無視することができます。';
$txt['shd_ticket_notify_me_never'] = 'このチケットのすべての通知をオフにしました。';
$txt['shd_ticket_notify_me_never_on'] = '通知をオフにする';
$txt['shd_ticket_notify_me_never_off'] = '通知をオン';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = '検索機能は、利用可能なすべてのチケットを一覧表示するわけではありません。';
$txt['shd_search_warning_admin'] = '検索機能はインデックスを再構築する必要があります。管理パネルの「メンテナンス」オプションからこれを実現できます。';
$txt['shd_search'] = 'チケットを検索';
$txt['shd_search_results'] = 'チケットを検索 - 結果';
$txt['shd_search_text'] = 'お探しの単語:';
$txt['shd_search_match'] = '一致すべきことは何ですか?';
$txt['shd_search_match_all'] = '入力されたすべての単語に一致';
$txt['shd_search_match_any'] = '入力された単語に一致する';
$txt['shd_search_scope'] = 'チケットの種類を含める:';
$txt['shd_search_scope_open'] = 'チケットを開く';
$txt['shd_search_scope_closed'] = 'クローズされたチケット';
$txt['shd_search_scope_recycle'] = 'ごみ箱のアイテム';
$txt['shd_search_result_ticket'] = 'チケット %1$s';
$txt['shd_search_result_reply'] = 'チケット %1$s に返信';
$txt['shd_search_last_updated'] = '最終更新日:';
$txt['shd_search_ticket_opened_by'] = '公開済みのチケット:';
$txt['shd_search_ticket_replied_by'] = 'チケットの返信者：';
$txt['shd_search_dept'] = 'どの部署を検索しますか:';

$txt['shd_search_urgency'] = '緊急度のレベルを含めてください：';

$txt['shd_search_where'] = '検索するアイテム:';
$txt['shd_search_where_tickets'] = 'チケットの本文';
$txt['shd_search_where_replies'] = 'チケットの返信';
$txt['shd_search_where_subjects'] = 'チケットの件名';

$txt['shd_search_ticket_starter'] = 'チケットの開始者:';
$txt['shd_search_ticket_assignee'] = '割り当てられたチケット';
$txt['shd_search_ticket_named_person'] = '興味のある人の名前を入力します。';

$txt['shd_search_no_results'] = '指定された条件で結果が見つかりませんでした。戻って検索条件を変更してみてください。';
$txt['shd_search_criteria'] = '検索条件:';
$txt['shd_search_excluded'] = '可能なすべてのオプションが選択されている場合、上記には含まれていません (例: 緊急性のすべてのレベルがチェックされた場合、それは上記で述べられていないので、検索に固有のものに集中することができます)';
//@}