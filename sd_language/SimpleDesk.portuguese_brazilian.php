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
$txt['shd_helpdesk'] = 'Suporte';
$txt['shd_helpdesk_maintenance'] = 'O suporte técnico está atualmente em <strong>modo de manutenção</strong>. Somente administradores de fórum e suporte técnico podem ver isso.';
$txt['shd_open_ticket'] = 'abrir pedido';
$txt['shd_open_tickets'] = 'pedidos abertos';
$txt['shd_none'] = 'Nenhuma';

$txt['shd_display_nojs'] = 'O JavaScript não está habilitado no seu navegador. Algumas funções podem não funcionar corretamente (ou em tudo), ou se comportar de forma inesperada.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Bem-vindo ao centro de administração de suporte técnico!';
$txt['shd_admin_title'] = 'Centro de Administração Helpdesk';
$txt['shd_staff_list'] = 'Equipe de Helpdesk';
$txt['shd_update_available'] = 'Nova versão disponível!';
$txt['shd_update_message'] = 'Uma nova versão do SimpleDesk foi lançada. Recomendamos que você <a href="#" id="update-link">atualize para a versão mais recente</a> para ficar seguro e aproveitar todos os recursos que nossa modificação tem para oferecer.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Para obter mais informações sobre o que é novo nesta versão, por favor visite <a href="#" id="information-link" target="_blank">nosso site</a>.</span><br>' . "\n\n" . '<strong>A Equipe SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'baixa';
$txt['shd_urgency_1'] = 'Média';
$txt['shd_urgency_2'] = 'alta';
$txt['shd_urgency_3'] = 'Muito alto';
$txt['shd_urgency_4'] = 'Grave';
$txt['shd_urgency_5'] = 'Crítica';
$txt['shd_urgency_increase'] = 'Aumentar';
$txt['shd_urgency_decrease'] = 'Diminuir';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Novidades';
$txt['shd_status_1'] = 'Comentário de equipe pendente';
$txt['shd_status_2'] = 'Comentário de usuário pendente';
$txt['shd_status_3'] = 'Resolvido/Fechado';
$txt['shd_status_4'] = 'Indicado à Supervisor';
$txt['shd_status_5'] = 'Encaminhado - Urgente';
$txt['shd_status_6'] = 'Excluído';
$txt['shd_status_7'] = 'Em espera';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Novos Tickets';
$txt['shd_status_1_heading'] = 'Chamados Aguardando Resposta da Equipe';
$txt['shd_status_2_heading'] = 'Chamados Aguardando Resposta do Usuário';
$txt['shd_status_3_heading'] = 'Tickets Fechados';
$txt['shd_status_4_heading'] = 'Tickets indicados ao Supervisor';
$txt['shd_status_5_heading'] = 'Tickets urgentes';
$txt['shd_status_6_heading'] = 'Chamados Reciclados';
$txt['shd_status_7_heading'] = 'Em Chamados';
$txt['shd_status_assigned_heading'] = 'Atribuídas a Mim';
$txt['shd_status_withdeleted_heading'] = 'Tickets com Respostas Excluídas';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Chamados Abertos';
$txt['shd_tickets_closed'] = 'Tickets Fechados';
$txt['shd_tickets_recycled'] = 'Chamados Reciclados';

$txt['shd_assigned'] = 'Atribuído';
$txt['shd_unassigned'] = 'Não atribuído';

$txt['shd_read_ticket'] = 'Ler Ticket';
$txt['shd_unread_ticket'] = 'Ticket não lido';
$txt['shd_unread_tickets'] = 'Tickets Não Lidos';

$txt['shd_owned'] = 'Bilhete Possuído'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'pedido';
$txt['shd_count_tickets'] = 'pedidos';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Você não tem permissão para acessar o suporte técnico.';
$txt['shd_no_ticket'] = 'O ticket que você solicitou não parece existir.';
$txt['shd_no_reply'] = 'A resposta do ticket que você tem solicitação parece não existir ou não faz parte deste ticket.';
$txt['shd_no_topic'] = 'O tópico que você solicitou não parece existir.';
$txt['shd_ticket_no_perms'] = 'Você não tem permissão para visualizar esse ticket.';
$txt['shd_error_no_tickets'] = 'Tickets não encontrados.';
$txt['shd_inactive'] = 'O suporte técnico está atualmente desativado.';
$txt['shd_cannot_assign'] = 'Você não tem permissão para atribuir tickets.';
$txt['shd_cannot_assign_other'] = 'Este ticket já está atribuído a outro usuário. Você não pode reatribui-lo a si mesmo - por favor, contate o administrador.';
$txt['shd_no_staff_assign'] = 'Não há pessoal configurado; não é possível atribuir um ticket. Por favor contate o administrador.';
$txt['shd_assigned_not_permitted'] = 'O usuário que você solicitou para atribuir esse ticket não tem permissões suficientes para vê-lo.';
$txt['shd_cannot_resolve'] = 'Você não tem permissão para marcar este ticket como resolvido.';
$txt['shd_cannot_unresolve'] = 'Você não tem permissão para reabrir um ticket resolvido.';
$txt['error_shd_cannot_resolve_children'] = 'Este ticket não pode ser fechado atualmente; este ticket é o pai de um ou mais tickets que estão atualmente abertos.';
$txt['error_shd_proxy_unknown'] = 'O usuário que este ticket foi postado em nome não existe.';
$txt['shd_cannot_change_privacy'] = 'Não tem permissão para alterar a privacidade deste bilhete.';
$txt['shd_cannot_change_urgency'] = 'Não tem permissão para alterar a urgência deste bilhete.';
$txt['shd_ajax_problem'] = 'Houve um problema ao tentar carregar a página. Gostaria de tentar novamente?';
$txt['shd_cannot_move_ticket'] = 'Você não tem permissão para mover este ticket para um tópico.';
$txt['shd_cannot_move_topic'] = 'Você não tem permissão para mover este tópico para um ticket.';
$txt['shd_moveticket_noboards'] = 'Não há nenhuma placa para mover este bilhete!';
$txt['shd_move_no_pm'] = 'Você deve informar uma razão para mover o bilhete para enviar para o proprietário do bilhete, ou desmarque a opção de \'enviar uma mensagem privada para o dono do ticket\'.';
$txt['shd_move_no_pm_topic'] = 'Você deve digitar uma razão para mover o tópico para o início do tópico, ou desmarque a opção \'enviar uma mensagem privada para o iniciante do tópico\'.';
$txt['shd_move_topic_not_created'] = 'Falha ao mover o ticket para a lousa. Tente novamente.';
$txt['shd_move_ticket_not_created'] = 'Falha ao mover o tópico para o helpdesk. Tente novamente.';
$txt['shd_no_replies'] = 'Este ticket ainda não tem respostas.';
$txt['cannot_shd_new_ticket'] = 'Você não tem permissão para criar um novo ticket.';
$txt['cannot_shd_edit_ticket'] = 'Você não tem permissão para editar este ticket.';
$txt['shd_cannot_reply_any'] = 'Você não tem permissão para responder a nenhum ticket.';
$txt['shd_cannot_reply_any_but_own'] = 'Você não tem permissão para responder a nenhum ticket que não seja o seu.';
$txt['shd_cannot_edit_reply_any'] = 'Você não tem permissão para editar quaisquer respostas.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Você não tem permissão para editar respostas para outros tickets além das suas próprias respostas.';
$txt['shd_cannot_edit_closed'] = 'Você não pode editar tickets resolvidos; você precisa marcá-lo como não resolvido primeiro.';
$txt['shd_cannot_edit_deleted'] = 'Não é possível editar tickets na lixeira. Eles terão de ser restaurados primeiro.';
$txt['shd_cannot_reply_closed'] = 'Você não pode responder a chamados resolvidos; precisa marcá-los como não resolvidos primeiro.';
$txt['shd_cannot_reply_deleted'] = 'Você não pode responder a tickets na lixeira. Eles precisarão ser restaurados primeiro.';
$txt['shd_cannot_delete_ticket'] = 'Você não tem permissão para excluir este bilhete.';
$txt['shd_cannot_delete_reply'] = 'Você não tem permissão para excluir essa resposta.';
$txt['shd_cannot_restore_ticket'] = 'Você não tem permissão para restaurar este ticket da lixeira.';
$txt['shd_cannot_restore_reply'] = 'Você não tem permissão para restaurar essa resposta da lixeira.';
$txt['shd_cannot_view_resolved'] = 'Você não tem permissão para acessar os pedidos resolvidos.';
$txt['cannot_shd_access_recyclebin'] = 'Não é possível acessar a lixeira.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Você não pode mover este ticket para o fórum; há uma ou mais respostas apagadas, às quais as suas permissões atuais não permitem acesso.';
$txt['shd_cannot_attach_ext'] = 'O tipo de arquivo que você tentou anexar ({ext}) não é permitido aqui. Os tipos permitidos de arquivo são: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Este ticket não está disponível para modificação.';
$txt['shd_invalid_relation'] = 'Você deve fornecer um tipo válido de relação para estes bilhetes.';
$txt['shd_no_relation_delete'] = 'Não é possível excluir uma relação que não existe.';
$txt['shd_cannot_relate_self'] = 'Você não pode fazer um ticket reportar a si mesmo.';
$txt['shd_relationships_are_disabled'] = 'Relações do Ticket estão desativadas atualmente.';
$txt['error_invalid_fields'] = 'Os seguintes campos têm valores que não podem ser usados: %1$s';
$txt['error_missing_fields'] = 'Os seguintes campos não foram concluídos e precisam ser: %1$s';
$txt['error_missing_multi'] = '%1$s (pelo menos %2$d deve ser selecionado)';
$txt['error_no_dept'] = 'Você não selecionou um departamento para publicar este ticket.';
$txt['shd_cannot_move_dept'] = 'Não se pode mover este bilhete, não há para onde movê-lo.';
$txt['shd_no_perm_move_dept'] = 'Você não tem permissão para mover este bilhete para outro departamento.';
$txt['cannot_shd_delete_attachment'] = 'Você não tem permissão para excluir anexos.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Você não pode mover este ticket para um tópico; existem campos personalizados anexados que requerem um administrador para confirmar o movimento.';
$txt['cannot_monitor_ticket'] = 'Você não tem permissão para ativar o monitoramento para este ticket.';
$txt['cannot_unmonitor_ticket'] = 'Você não tem permissão para desativar o monitoramento para este ticket.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Suporte'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Departamentos'; // ditto
$txt['shd_new_ticket'] = 'Postar Novo Ticket';
$txt['shd_new_ticket_proxy'] = 'Postar Ticket do Proxy';
$txt['shd_helpdesk_profile'] = 'Perfil do Helpdesk';
$txt['shd_welcome'] = 'Bem vindo(a), %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Ir para o pedido';
$txt['shd_options'] = 'Opções';
$txt['shd_search_menu'] = 'Pesquisa';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Informacao';
$txt['shd_admin_options'] = 'Opções';
$txt['shd_admin_custom_fields'] = 'Campos Personalizados';
$txt['shd_admin_departments'] = 'Departamentos';
$txt['shd_admin_permissions'] = 'Permissões';
$txt['shd_admin_plugins'] = 'Complementos';
$txt['shd_admin_cannedreplies'] = 'Respostas Prontas';
$txt['shd_admin_maint'] = 'Manutenção';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Aqui você pode arquivar novos tickets para ações da equipe do site, e verificar os tickets atuais já em curso.';
$txt['shd_staff_greeting'] = 'Aqui estão todos os bilhetes que requerem atenção.';
$txt['shd_shd_greeting'] = 'Este é o Helpdesk. Aqui você perde seu tempo para ajudar os novatos. Aproveite! ;D';
$txt['shd_closed_user_greeting'] = 'Estes são todos os tickets fechados/resolvidos que você postou no centro de ajuda.';
$txt['shd_closed_staff_greeting'] = 'Todos estes tickets são fechados/resolvidos enviados para o suporte.';
$txt['shd_category_filter'] = 'Filtragem de categoria';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Seu ticket foi criado!';
$txt['shd_ticket_posted_body'] = 'Obrigado por postar o seu ticket, {membername}!' . "\n\n" . 'A equipe de assistência irá revisá-lo e lhe responder o mais rápido possível.' . "\n\n" . 'Enquanto isso, você pode ver o seu bilhete, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; na seguinte URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Open another ticket[/iurl] | [iurl={helpdesklink}]Back to the main helpdesk[/iurl] | [iurl={forumlink}]Back to the forum[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Você pode ativar notificações por e-mail sobre alterações no seu ticket, na área [iurl={prefslink}]Preferências de Helpdesk[/iurl].';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Atenciosamente,' . "\n" . 'Equipe de {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Detalhes do Chamado';
$txt['shd_ticket_updated'] = 'Atualizado';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Nome:';
$txt['shd_ticket_user'] = 'Usuário';
$txt['shd_ticket_date'] = 'Postado';
$txt['shd_ticket_urgency'] = 'Urgência';
$txt['shd_ticket_assigned'] = 'Atribuído';
$txt['shd_ticket_assignedto'] = 'Atribuído a';
$txt['shd_ticket_started_by'] = 'Iniciado por';
$txt['shd_ticket_updated_by'] = 'Atualizado por';
$txt['shd_ticket_status'] = 'SItuação';
$txt['shd_ticket_num_replies'] = 'Respostas';
$txt['shd_ticket_replies'] = 'Respostas';
$txt['shd_ticket_staff'] = 'Membro da equipe';
$txt['shd_ticket_attachments'] = 'Anexos';
$txt['shd_ticket_reply_number'] = 'Responder <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Bilhete Em Espera';
$txt['shd_ticket'] = 'Chamado';
$txt['shd_reply_written'] = 'Resposta escrita %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'nunca';
$txt['shd_linktree_tickets'] = 'Tickets';
$txt['shd_ticket_privacy'] = 'Privacidade';
$txt['shd_ticket_notprivate'] = 'Não Privado';
$txt['shd_ticket_private'] = 'Privado';
$txt['shd_ticket_change'] = 'Troca';
$txt['shd_ticket_ip'] = 'Endereço IP';
$txt['shd_back_to_hd'] = 'Voltar para o suporte técnico';
$txt['shd_go_to_replies'] = 'Ir para respostas';
$txt['shd_go_to_action_log'] = 'Ir para o Log de Ações';
$txt['shd_go_to_replies_start'] = 'Ir para a primeira resposta';

$txt['shd_ticket_has_been_deleted'] = 'Este ticket está atualmente na lixeira e não pode ser alterado sem ser devolvido ao centro de ajuda.';
$txt['shd_ticket_replies_deleted'] = 'Este ticket teve respostas excluídas dele anteriormente.';
$txt['shd_ticket_replies_deleted_view'] = 'Estes são exibidos com um fundo colorido. <a href="%1$s">Veja o ticket sem exclusões</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Por favor <a href="%1$s">clique aqui</a> para visualizá-los.';

$txt['shd_ticket_notnew'] = 'Você já viu isto';
$txt['shd_ticket_new'] = 'Novo!';

$txt['shd_linktree_move_ticket'] = 'Mover pedido';
$txt['shd_linktree_move_topic'] = 'Mover tópico para helpdesk';

$txt['shd_cancel_ticket'] = 'Cancelar e retornar para o ticket';
$txt['shd_cancel_home'] = 'Cancelar e retornar para a casa do helpdesk';
$txt['shd_cancel_topic'] = 'Cancelar e retornar ao tópico';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Responder ao ticket';
$txt['shd_ticket_quote'] = 'Responder com citação';
$txt['shd_go_advanced'] = 'Avance!';
$txt['shd_ticket_edit_reply'] = 'Editar resposta';
$txt['shd_ticket_quote_short'] = 'Cotação';
$txt['shd_ticket_markunread'] = 'Marcar como não lido';
$txt['shd_ticket_reply_short'] = 'Responder';
$txt['shd_ticket_edit'] = 'Alterar';
$txt['shd_ticket_resolved'] = 'Marcar como resolvido';
$txt['shd_ticket_unresolved'] = 'Marcar como não resolvido';
$txt['shd_ticket_assign'] = 'Atribuir';
$txt['shd_ticket_assign_self'] = 'Atribuir-me a mim';
$txt['shd_ticket_reassign'] = 'Re-atribuir';
$txt['shd_ticket_unassign'] = 'Desatribuir';
$txt['shd_ticket_delete'] = 'excluir';
$txt['shd_delete_confirm'] = 'Tem certeza que deseja excluir este ticket? Se excluído, este ticket será movido para a caixa de reciclagem.';
$txt['shd_delete_reply_confirm'] = 'Tem certeza que deseja excluir esta resposta? Se excluída, esta resposta será movida para a caixa de reciclagem.';
$txt['shd_delete_attach_confirm'] = 'Tem certeza que deseja excluir este anexo? (Isto não pode ser desfeito!)';
$txt['shd_delete_attach'] = 'Excluir este anexo';
$txt['shd_ticket_restore'] = 'RESTAURAR';
$txt['shd_delete_permanently'] = 'Excluir permanentemente';
$txt['shd_delete_permanently_confirm'] = 'Tem certeza que deseja excluir permanentemente esse ticket? Isso NÃO PODERÁ ser desfeito!';
$txt['shd_ticket_move_to_topic'] = 'Mover para o tópico';
$txt['shd_move_dept'] = 'Mover dep.';
$txt['shd_actions'] = 'Ações.';
$txt['shd_back_to_ticket'] = 'Retornar para este ticket após postar';
$txt['shd_disable_smileys_post'] = 'Desativar smileys nesta postagem';
$txt['shd_resolve_this_ticket'] = 'Marcar este ticket como resolvido';
$txt['shd_override_cf'] = 'Substituir os requisitos dos campos personalizados';
$txt['shd_silent_update'] = 'Atualização silenciosa (não enviar notificações)';
$txt['shd_select_notifications'] = 'Selecione pessoas para notificar sobre esta resposta...';

$txt['shd_ticket_assign_ticket'] = 'Atribuir Ticket';
$txt['shd_ticket_assign_to'] = 'Atribuir o ticket para';

$txt['shd_ticket_move_dept'] = 'Mover Ticket para outro Departamento';
$txt['shd_ticket_move_to'] = 'Mover para';
$txt['shd_current_dept'] = 'Atualmente no departamento';
$txt['shd_ticket_move'] = 'Mover Ticket';
$txt['shd_unknown_dept'] = 'O departamento especificado não existe.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Novo assunto';
$txt['shd_move_ticket_to_topic'] = 'Mover ticket para o tópico';
$txt['shd_move_ticket'] = 'Mover pedido';
$txt['shd_ticket_board'] = 'Tabuleiro';
$txt['shd_change_ticket_subject'] = 'Alterar o assunto do ticket';
$txt['shd_move_send_pm'] = 'Enviar uma MP para o proprietário do ticket';
$txt['shd_move_why'] = 'Por favor, insira uma breve descrição sobre por que este ticket está sendo movido para um tópico do fórum.';
$txt['shd_ticket_moved_subject'] = 'Seu bilhete foi movido.';
$txt['shd_move_default'] = 'Olá, {user}.' . "\n\n" . 'O seu tíquete, {subject}, foi movido da central de ajuda para um tópico no fórum.' . "\n" . 'Você pode encontrar seu ticket no quadro {board} ou através deste link:' . "\n\n" . '{link}' . "\n\n" . 'Agradecimentos';

$txt['shd_move_topic_to_ticket'] = 'Mover tópico para helpdesk';
$txt['shd_move_topic'] = 'Mover tópico';
$txt['shd_change_topic_subject'] = 'Alterar assunto do tópico';
$txt['shd_move_send_pm_topic'] = 'Envie uma MP para o iniciante do tópico';
$txt['shd_move_why_topic'] = 'Por favor, digite uma breve descrição para saber por que esse tópico está sendo movido para o Centro de Ajuda. ';
$txt['shd_ticket_moved_subject_topic'] = 'Seu tópico foi movido.';
$txt['shd_move_default_topic'] = 'Olá, {user}.' . "\n\n" . 'Seu tópico, {subject}, foi movido do fórum para a seção HelpDesk.' . "\n" . 'Você pode encontrar seu tópico através deste link:' . "\n\n" . '{link}' . "\n\n" . 'Agradecimentos';

$txt['shd_user_no_hd_access'] = 'Nota: a pessoa que iniciou esse tópico não pode ver o helpdesk!';
$txt['shd_user_helpdesk_access'] = 'A pessoa que iniciou esse tópico pode ver o suporte.';
$txt['shd_user_hd_access_dept_1'] = 'A pessoa que iniciou este tópico pode ver o seguinte departamento: ';
$txt['shd_user_hd_access_dept'] = 'A pessoa que iniciou este tópico pode ver os seguintes departamentos: ';
$txt['shd_move_ticket_department'] = 'Mover ticket para qual departamento';
$txt['shd_move_dept_why'] = 'Por favor, insira uma breve descrição para o motivo pelo qual este ticket está sendo transferido para outro departamento.';
$txt['shd_move_dept_default'] = 'Olá, {user}.' . "\n\n" . 'O seu ticket, {subject}, foi movido do departamento {current_dept} para o departamento de {new_dept}.' . "\n" . 'Você pode encontrar seu ticket através deste link:' . "\n\n" . '{link}' . "\n\n" . 'Agradecimentos';

$txt['shd_ticket_move_deleted'] = 'Este ticket tem respostas que estão atualmente na lixeira. O que você deseja fazer?';
$txt['shd_ticket_move_deleted_abort'] = 'Abortar, leve-me para a lixeira';
$txt['shd_ticket_move_deleted_delete'] = 'Continue, abandone as respostas excluídas (não mova-as para o novo tópico)';
$txt['shd_ticket_move_deleted_undelete'] = 'Continue, recupere as respostas (mova-as para o novo tópico)';

$txt['shd_ticket_move_cfs'] = 'Este ticket possui campos personalizados que podem precisar ser movidos.';
$txt['shd_ticket_move_cfs_warn'] = 'Alguns destes campos podem não ser visíveis para outros usuários. Estes campos são indicados com um ponto de exclamação.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Você pode ver este campo, outros usuários não podem - mas uma vez que ele se torna parte do fórum, tornar-se-á visível para todos os que puderem acessar o fórum.';
$txt['shd_ticket_move_cfs_purge'] = 'Excluir conteúdo do campo';
$txt['shd_ticket_move_cfs_embed'] = 'Manter o campo e colocá-lo no novo tópico';
$txt['shd_ticket_move_cfs_user'] = 'Visível atualmente aos usuários normais';
$txt['shd_ticket_move_cfs_staff'] = 'Visível atualmente para membros da equipe';
$txt['shd_ticket_move_cfs_admin'] = 'Atualmente visível para administradores';
$txt['shd_ticket_move_accept'] = 'Aceito que alguns dos campos que estão a ser manipulados aqui não são visíveis para todos os usuários, e que este tópico deve ser movido para o fórum, com as configurações acima.';
$txt['shd_ticket_move_reqd'] = 'Esta opção deve ser selecionada para que você possa mover este ticket para o fórum.';
$txt['shd_ticket_move_ok'] = 'Este campo é seguro para se mover, todos os usuários que podem ver o ticket podem ver este campo, não há nenhuma informação oculta de usuários ou de funcionários.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Este ticket tem campos que usuários ou equipe podem não ser capazes de ver, como tal, você precisa confirmar que está ciente disso - por favor, volte para a página anterior, a caixa de seleção para confirmar que a consciência disto está no final do formulário.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Lixeira';
$txt['shd_recycle_greeting'] = 'Esta é a caixa de reciclagem. Todos os bilhetes apagados vão para aqui, mas membros da equipe com permissões especiais podem remover bilhetes permanentemente daqui.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Criar ticket';
$txt['shd_edit_ticket'] = 'Editar o pedido';
$txt['shd_edit_ticket_linktree'] = 'Editar ticket (%s)';
$txt['shd_ticket_subject'] = 'Assunto do Ticket';
$txt['shd_ticket_proxy'] = 'Postar em nome de';
$txt['shd_ticket_post_error'] = 'O problema a seguir, ou problemas ocorreram ao tentar postar este ticket';
$txt['shd_reply_ticket'] = 'Responder ao ticket';
$txt['shd_reply_ticket_linktree'] = 'Responder ao ticket (%s)';
$txt['shd_edit_reply_linktree'] = 'Editar resposta (%s)';
$txt['shd_previewing_ticket'] = 'Pré-visualizando ticket';
$txt['shd_previewing_reply'] = 'Pré-visualizando resposta para';
$txt['shd_choose_one'] = '[Escolher um]';
$txt['shd_no_value'] = '[nenhum valor]';
$txt['shd_ticket_dept'] = 'Departamento de Ticket';
$txt['shd_select_dept'] = '-- Selecione um departamento --';
$txt['canned_replies'] = 'Adicione uma resposta predefinida:';
$txt['canned_replies_select'] = '-- Selecione uma resposta --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Respostas do Helpdesk postadas de IP (intervalo)';
$txt['shd_no_replies_from_ip'] = 'Nenhuma resposta do helpdesk do IP especificado (intervalo) foi encontrada';
$txt['shd_replies_from_ip_desc'] = 'Abaixo está uma lista de todas as mensagens enviadas a partir deste IP (intervalo).';
$txt['shd_is_ticket_opener'] = ' (iniciante do ticket)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'Arquivo BZip2';
$txt['shd_attachtype_gz'] = 'Arquivo GZip';
$txt['shd_attachtype_rar'] = 'Arquivo Rar/WinRAR';
$txt['shd_attachtype_zip'] = 'Arquivo compactado';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'Arquivo de áudio MP3 (MPEG Layer III)';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Imagem Windows Bitmap';
$txt['shd_attachtype_gif'] = 'Imagem de Intercâmbio Gráficos (GIF)';
$txt['shd_attachtype_jpeg'] = 'Imagem do Grupo de Especialistas Fotográficos (JPEG)';
$txt['shd_attachtype_jpg'] = 'Imagem do Grupo de Especialistas Fotográficos (JPEG)';
$txt['shd_attachtype_png'] = 'Imagem do Gráfico de Rede Portátil (PNG)';
$txt['shd_attachtype_svg'] = 'Imagem gráfica vetorial escalável (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Vídeo de vídeo Windows Media';
// Office formats
$txt['shd_attachtype_doc'] = 'Documento do Microsoft Word';
$txt['shd_attachtype_mdb'] = 'Banco de dados Microsoft Access';
$txt['shd_attachtype_ppt'] = 'Apresentação do Microsoft Powerpoint';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'Arquivo fonte C++';
$txt['shd_attachtype_php'] = 'Script PHP';
$txt['shd_attachtype_py'] = 'Arquivo de origem Python';
$txt['shd_attachtype_rb'] = 'Arquivo fonte Ruby';
$txt['shd_attachtype_sql'] = 'Script SQL';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (arquivo KML)';
$txt['shd_attachtype_pdf'] = 'Arquivo de Documento Portátil Adobe Acrobat';
$txt['shd_attachtype_psd'] = 'Documento de Adobe Photoshop';
$txt['shd_attachtype_swf'] = 'Arquivo Adobe Flash';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Arquivo executável (Windows)';
$txt['shd_attachtype_htm'] = 'Documento Markup Hypertext (HTML)';
$txt['shd_attachtype_html'] = 'Documento Markup Hypertext (HTML)';
$txt['shd_attachtype_rtf'] = 'Formato de texto rico (RTF)';
$txt['shd_attachtype_txt'] = 'Texto sem formatação';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Log de ações de ticket';
$txt['shd_ticket_log_count_one'] = '1 entrada';
$txt['shd_ticket_log_count_more'] = '%s entradas';
$txt['shd_ticket_log_none'] = 'Este ticket não teve nenhuma alteração.';
$txt['shd_ticket_log_member'] = 'Membro';
$txt['shd_ticket_log_ip'] = 'IP de membro:';
$txt['shd_ticket_log_date'] = 'Encontro';
$txt['shd_ticket_log_action'] = 'Acão';
$txt['shd_ticket_log_full'] = 'Ir para o log completo de ação (Todos os tickets)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Tickets Relacionados';
$txt['shd_ticket_create_relationship'] = 'Criar relação';
$txt['shd_ticket_delete_relationship'] = 'Excluir relacionamento';
$txt['shd_ticket_reltype'] = 'selecionar tipo';
$txt['shd_ticket_reltype_linked'] = 'Relacionado a';
$txt['shd_ticket_reltype_duplicated'] = 'Duplicar de';
$txt['shd_ticket_reltype_parent'] = 'Pai de';
$txt['shd_ticket_reltype_child'] = 'Filho de';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Informação Adicional';
$txt['shd_ticket_additional_details'] = 'Detalhes adicionais';
$txt['shd_ticket_empty_field'] = 'Este campo está vazio.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'notificações';
$txt['shd_ticket_notify_noneprefs'] = 'Suas preferências do usuário não são uma conta para notificação deste ticket.';
$txt['shd_ticket_notify_changeprefs'] = 'Alterar suas preferências';
$txt['shd_ticket_notify_because'] = 'Suas preferências indicam notificá-lo das respostas a este ticket:';
$txt['shd_ticket_notify_because_yourticket'] = 'como é o seu bilhete';
$txt['shd_ticket_notify_because_assignedyou'] = 'como foi designado para você';
$txt['shd_ticket_notify_because_priorreply'] = 'como você respondeu antes';
$txt['shd_ticket_notify_because_anyreply'] = 'para qualquer ticket';

$txt['shd_ticket_notify_me_always'] = 'Você está monitorando este ticket (e receberá uma notificação a cada resposta)';
$txt['shd_ticket_monitor_on_note'] = 'Você pode monitorar todas as respostas deste ticket por e-mail, independentemente das suas preferências:';
$txt['shd_ticket_monitor_off_note'] = 'Você pode desativar o monitoramento deste ticket e, em vez disso, usar suas preferências:';
$txt['shd_ticket_monitor_on'] = 'Ativar monitoramento';
$txt['shd_ticket_monitor_off'] = 'Desativar monitoramento';
$txt['shd_ticket_notify_me_never_note'] = 'Você pode ignorar atualizações por e-mail para este ticket, independentemente de suas preferências:';
$txt['shd_ticket_notify_me_never'] = 'Você desligou todas as notificações deste ticket.';
$txt['shd_ticket_notify_me_never_on'] = 'Desativar notificações';
$txt['shd_ticket_notify_me_never_off'] = 'Ativar notificações';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'A facilidade de pesquisa não pode listar todos os tickets disponíveis; está actualmente a ser investigada.';
$txt['shd_search_warning_admin'] = 'A instalação de pesquisa requer que seu índice seja reconstruído. Você pode conseguir isso através da opção Manutenção, na área de Helpdesk, no painel de administração.';
$txt['shd_search'] = 'Pesquisar Tickets';
$txt['shd_search_results'] = 'Pesquisar Tickets - Resultados';
$txt['shd_search_text'] = 'Palavras que você está procurando:';
$txt['shd_search_match'] = 'O que deve ser correspondido?';
$txt['shd_search_match_all'] = 'Combinar todas as palavras fornecidas';
$txt['shd_search_match_any'] = 'Corresponde a qualquer palavra fornecida';
$txt['shd_search_scope'] = 'Incluir quais tipos de tickets:';
$txt['shd_search_scope_open'] = 'Pedidos abertos';
$txt['shd_search_scope_closed'] = 'Tickets fechados';
$txt['shd_search_scope_recycle'] = 'Itens na lixeira';
$txt['shd_search_result_ticket'] = 'Tíquete %1$s';
$txt['shd_search_result_reply'] = 'Responder ao ticket %1$s';
$txt['shd_search_last_updated'] = 'Última atualização:';
$txt['shd_search_ticket_opened_by'] = 'Ticket aberto por:';
$txt['shd_search_ticket_replied_by'] = 'Ticket respondeu para:';
$txt['shd_search_dept'] = 'Pesquisar em qual(is):';

$txt['shd_search_urgency'] = 'Inclua quais níveis de urgência:';

$txt['shd_search_where'] = 'Quais itens pesquisar:';
$txt['shd_search_where_tickets'] = 'Os corpos dos ingressos';
$txt['shd_search_where_replies'] = 'As respostas nos tickets';
$txt['shd_search_where_subjects'] = 'Tickets do ticket';

$txt['shd_search_ticket_starter'] = 'Tickets iniciados por:';
$txt['shd_search_ticket_assignee'] = 'Tickets atribuídos a:';
$txt['shd_search_ticket_named_person'] = 'Digite o nome da(s) pessoa(s) em que você está interessado.';

$txt['shd_search_no_results'] = 'Não foram encontrados resultados com os critérios indicados. Você pode voltar e tentar alterar seus critérios de pesquisa.';
$txt['shd_search_criteria'] = 'Critério de pesquisa:';
$txt['shd_search_excluded'] = 'Se cada opção possível foi selecionada, ela não foi incluída no arquivo acima (por exemplo, se todos os níveis possíveis de urgência forem selecionados, não é mencionado acima, então você pode se concentrar no que é específico para a sua pesquisa)';
//@}