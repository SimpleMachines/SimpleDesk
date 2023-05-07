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
$txt['shd_helpdesk'] = 'Helpdesk';
$txt['shd_helpdesk_maintenance'] = 'Le helpdesk est actuellement en mode de maintenance <strong></strong>. Seuls les administrateurs du forum et du helpdesk peuvent le voir.';
$txt['shd_open_ticket'] = 'ticket ouvert';
$txt['shd_open_tickets'] = 'tickets ouverts';
$txt['shd_none'] = 'Aucun';

$txt['shd_display_nojs'] = 'JavaScript n\'est pas activé dans votre navigateur. Certaines fonctions peuvent ne pas fonctionner correctement (ou du tout) ou se comporter de manière inattendue.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = 'Bienvenue dans le centre d\'administration du helpdesk principal!';
$txt['shd_admin_title'] = 'Centre d\'administration du Helpdesk';
$txt['shd_staff_list'] = 'Personnel du helpdesk';
$txt['shd_update_available'] = 'Nouvelle version disponible !';
$txt['shd_update_message'] = 'Une nouvelle version de SimpleDesk a été publiée. Nous vous recommandons de <a href="#" id="update-link">mettre à jour vers la dernière version</a> afin de rester en sécurité et de profiter de toutes les fonctionnalités que notre modification a à offrir.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Pour plus d\'informations sur ce qui est nouveau dans cette version, veuillez visiter <a href="#" id="information-link" target="_blank">notre site web</a>.</span><br>' . "\n\n" . '<strong>L\'équipe SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Bas';
$txt['shd_urgency_1'] = 'Moyenne';
$txt['shd_urgency_2'] = 'Élevé';
$txt['shd_urgency_3'] = 'Très haut';
$txt['shd_urgency_4'] = 'Sévère';
$txt['shd_urgency_5'] = 'Critique';
$txt['shd_urgency_increase'] = 'Agrandir';
$txt['shd_urgency_decrease'] = 'Diminuer';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Nouveau';
$txt['shd_status_1'] = 'Commentaire du personnel en attente';
$txt['shd_status_2'] = 'Commentaire de l\'utilisateur en attente';
$txt['shd_status_3'] = 'Résolu/Fermée';
$txt['shd_status_4'] = 'Référé au superviseur';
$txt['shd_status_5'] = 'Escalade - Urgent';
$txt['shd_status_6'] = 'Supprimé';
$txt['shd_status_7'] = 'En attente';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Nouveaux tickets';
$txt['shd_status_1_heading'] = 'Tickets en attente de réponse du personnel';
$txt['shd_status_2_heading'] = 'Tickets en attente de réponse de l\'utilisateur';
$txt['shd_status_3_heading'] = 'Billets fermés';
$txt['shd_status_4_heading'] = 'Billets référencés au superviseur';
$txt['shd_status_5_heading'] = 'Tickets urgents';
$txt['shd_status_6_heading'] = 'Billets recyclés';
$txt['shd_status_7_heading'] = 'Tickets en attente';
$txt['shd_status_assigned_heading'] = 'Assigné à moi';
$txt['shd_status_withdeleted_heading'] = 'Tickets avec réponses supprimées';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Tickets ouverts';
$txt['shd_tickets_closed'] = 'Billets fermés';
$txt['shd_tickets_recycled'] = 'Billets recyclés';

$txt['shd_assigned'] = 'Assigné';
$txt['shd_unassigned'] = 'Non assigné';

$txt['shd_read_ticket'] = 'Lire le ticket';
$txt['shd_unread_ticket'] = 'Ticket non lu';
$txt['shd_unread_tickets'] = 'Tickets non lus';

$txt['shd_owned'] = 'Ticket possédé'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'ticket';
$txt['shd_count_tickets'] = 'billets';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'Vous n\'êtes pas autorisé à accéder au helpdesk.';
$txt['shd_no_ticket'] = 'Le ticket que vous avez demandé n\'existe pas.';
$txt['shd_no_reply'] = 'La réponse au ticket que vous avez demandée ne semble pas exister ou ne fait pas partie de ce ticket.';
$txt['shd_no_topic'] = 'Le sujet que vous avez demandé n\'existe pas.';
$txt['shd_ticket_no_perms'] = 'Vous n\'avez pas la permission de voir ce ticket.';
$txt['shd_error_no_tickets'] = 'Aucun ticket n\'a été trouvé.';
$txt['shd_inactive'] = 'Le helpdesk est actuellement désactivé.';
$txt['shd_cannot_assign'] = 'Vous n\'êtes pas autorisé à attribuer des billets.';
$txt['shd_cannot_assign_other'] = 'Ce ticket est déjà assigné à un autre utilisateur. Vous ne pouvez pas le réaffecter à vous-même - veuillez contacter l\'administrateur.';
$txt['shd_no_staff_assign'] = 'Il n\'y a pas de personnel configuré, il n\'est pas possible d\'affecter un ticket. Veuillez contacter votre administrateur.';
$txt['shd_assigned_not_permitted'] = 'L\'utilisateur auquel vous avez demandé d\'affecter ce ticket n\'a pas les permissions suffisantes pour le voir.';
$txt['shd_cannot_resolve'] = 'Vous n\'avez pas la permission de marquer ce ticket comme résolu.';
$txt['shd_cannot_unresolve'] = 'Vous n\'avez pas la permission de rouvrir un ticket résolu.';
$txt['error_shd_cannot_resolve_children'] = 'Ce ticket ne peut pas être fermé pour le moment ; ce ticket est le parent d\'un ou de plusieurs tickets qui sont actuellement ouverts.';
$txt['error_shd_proxy_unknown'] = 'L\'utilisateur dont ce ticket est posté au nom n\'existe pas.';
$txt['shd_cannot_change_privacy'] = 'Vous n\'avez pas la permission de modifier la confidentialité de ce billet.';
$txt['shd_cannot_change_urgency'] = 'Vous n\'avez pas la permission de modifier l\'urgence de ce ticket.';
$txt['shd_ajax_problem'] = 'Un problème est survenu lors du chargement de la page. Souhaitez-vous essayer à nouveau ?';
$txt['shd_cannot_move_ticket'] = 'Vous n\'avez pas la permission de déplacer ce ticket vers un sujet.';
$txt['shd_cannot_move_topic'] = 'Vous n\'avez pas la permission de déplacer ce sujet vers un ticket.';
$txt['shd_moveticket_noboards'] = 'Il n\'y a aucun tableau vers lequel déplacer ce ticket !';
$txt['shd_move_no_pm'] = 'Vous devez entrer une raison pour déplacer le ticket à envoyer au propriétaire du ticket, ou décochez l\'option \'envoyer un MP au propriétaire du billet\'.';
$txt['shd_move_no_pm_topic'] = 'Vous devez saisir une raison pour déplacer le sujet à envoyer au début du sujet, ou décochez l\'option "envoyer un MP au démarrage du sujet".';
$txt['shd_move_topic_not_created'] = 'Impossible de déplacer le ticket vers le tableau. Veuillez réessayer.';
$txt['shd_move_ticket_not_created'] = 'Impossible de déplacer le sujet vers le helpdesk. Veuillez réessayer.';
$txt['shd_no_replies'] = 'Ce ticket n\'a pas encore de réponse.';
$txt['cannot_shd_new_ticket'] = 'Vous n\'avez pas la permission de créer un nouveau ticket.';
$txt['cannot_shd_edit_ticket'] = 'Vous n\'êtes pas autorisé à modifier ce ticket.';
$txt['shd_cannot_reply_any'] = 'Vous n\'avez pas la permission de répondre à des tickets.';
$txt['shd_cannot_reply_any_but_own'] = 'Vous n\'avez pas la permission de répondre à des tickets autres que les vôtres.';
$txt['shd_cannot_edit_reply_any'] = 'Vous n\'avez pas la permission de modifier des réponses.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'Vous n\'avez pas la permission de modifier les réponses à des tickets autres que vos propres réponses.';
$txt['shd_cannot_edit_closed'] = 'Vous ne pouvez pas modifier les tickets résolus ; vous devez d\'abord le marquer comme non résolu.';
$txt['shd_cannot_edit_deleted'] = 'Vous ne pouvez pas modifier les tickets dans la corbeille. Ils devront être restaurés d\'abord.';
$txt['shd_cannot_reply_closed'] = 'Vous ne pouvez pas répondre aux tickets résolus ; vous devez d\'abord les marquer comme non résolus.';
$txt['shd_cannot_reply_deleted'] = 'Vous ne pouvez pas répondre aux tickets dans la corbeille. Ils devront être restaurés d\'abord.';
$txt['shd_cannot_delete_ticket'] = 'Vous n\'êtes pas autorisé à supprimer ce ticket.';
$txt['shd_cannot_delete_reply'] = 'Vous n\'êtes pas autorisé à supprimer cette réponse.';
$txt['shd_cannot_restore_ticket'] = 'Vous n\'êtes pas autorisé à restaurer ce ticket à partir de la corbeille.';
$txt['shd_cannot_restore_reply'] = 'Vous n\'êtes pas autorisé à restaurer cette réponse à partir de la corbeille.';
$txt['shd_cannot_view_resolved'] = 'Vous n\'êtes pas autorisé à accéder aux tickets résolus.';
$txt['cannot_shd_access_recyclebin'] = 'Vous ne pouvez pas accéder à la corbeille.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'Vous ne pouvez pas déplacer ce ticket vers le forum ; il y a une ou plusieurs réponses supprimées, auxquelles vos permissions actuelles ne permettent pas d\'accès.';
$txt['shd_cannot_attach_ext'] = 'Le type de fichier que vous avez essayé de joindre ({ext}) n\'est pas autorisé ici. Les types de fichier autorisés sont : {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Ce ticket n\'est actuellement pas disponible pour modification.';
$txt['shd_invalid_relation'] = 'Vous devez fournir un type de relation valide pour ces tickets.';
$txt['shd_no_relation_delete'] = 'Vous ne pouvez pas supprimer une relation qui n\'existe pas.';
$txt['shd_cannot_relate_self'] = 'Vous ne pouvez pas faire de lien entre un ticket et lui-même.';
$txt['shd_relationships_are_disabled'] = 'Les relations de tickets sont actuellement désactivées.';
$txt['error_invalid_fields'] = 'Les champs suivants ont des valeurs qui ne peuvent pas être utilisées: %1$s';
$txt['error_missing_fields'] = 'Les champs suivants n\'ont pas été remplis et doivent être : %1$s';
$txt['error_missing_multi'] = '%1$s (au moins %2$d doit être sélectionné)';
$txt['error_no_dept'] = 'Vous n\'avez pas sélectionné de service dans lequel poster ce ticket.';
$txt['shd_cannot_move_dept'] = 'Vous ne pouvez pas déplacer ce ticket, il n\'y a nulle part où le déplacer.';
$txt['shd_no_perm_move_dept'] = 'Vous n\'êtes pas autorisé à déplacer ce ticket vers un autre service.';
$txt['cannot_shd_delete_attachment'] = 'Vous n\'êtes pas autorisé à supprimer des pièces jointes.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'Vous ne pouvez pas déplacer ce ticket vers une discussion; il y a des champs personnalisés qui nécessitent un administrateur pour confirmer le déplacement.';
$txt['cannot_monitor_ticket'] = 'Vous n\'êtes pas autorisé à activer la surveillance pour ce ticket.';
$txt['cannot_unmonitor_ticket'] = 'Vous n\'êtes pas autorisé à désactiver la surveillance pour ce ticket.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Helpdesk'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Services'; // ditto
$txt['shd_new_ticket'] = 'Publier un nouveau ticket';
$txt['shd_new_ticket_proxy'] = 'Post Proxy Ticket';
$txt['shd_helpdesk_profile'] = 'Profil du helpdesk';
$txt['shd_welcome'] = 'Bienvenue, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Aller au ticket';
$txt['shd_options'] = 'Options';
$txt['shd_search_menu'] = 'Chercher';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Information';
$txt['shd_admin_options'] = 'Options';
$txt['shd_admin_custom_fields'] = 'Champs personnalisés';
$txt['shd_admin_departments'] = 'Services';
$txt['shd_admin_permissions'] = 'Permissions';
$txt['shd_admin_plugins'] = 'Plugins';
$txt['shd_admin_cannedreplies'] = 'Réponses en conserve';
$txt['shd_admin_maint'] = 'Entretien';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Ici, vous pouvez déposer de nouveaux tickets pour le personnel du site à l\'action, et vérifier les billets en cours déjà en cours.';
$txt['shd_staff_greeting'] = 'Voici tous les billets qui nécessitent de l\'attention.';
$txt['shd_shd_greeting'] = 'Ceci est le Helpdesk. Ici, vous perdez votre temps pour aider les débutants. Profitez-en! ;D';
$txt['shd_closed_user_greeting'] = 'Ce sont tous les tickets fermés/résolus que vous avez postés sur le helpdesk.';
$txt['shd_closed_staff_greeting'] = 'Tous ces tickets sont fermés/résolus soumis au helpdesk.';
$txt['shd_category_filter'] = 'Filtrage des catégories';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = 'Votre ticket a été créé !';
$txt['shd_ticket_posted_body'] = 'Merci d\'avoir posté votre billet, {membername}!' . "\n\n" . 'Le personnel du helpdesk le vérifiera et vous contactera dès que possible.' . "\n\n" . 'En attendant, vous pouvez voir votre billet, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; à l\'URL suivante :' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Ouvrir un autre ticket[/iurl] | [iurl={helpdesklink}]Retour au helpdesk principal[/iurl] | [iurl={forumlink}]Retour au forum[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'You can turn on email notifications about changes to your ticket, in the [iurl={prefslink}]Helpdesk Preferences[/iurl] area.';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Cordialement,' . "\n" . 'L\'équipe {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Détails du ticket';
$txt['shd_ticket_updated'] = 'Mis à jour';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Nom';
$txt['shd_ticket_user'] = 'Utilisateur';
$txt['shd_ticket_date'] = 'Publié';
$txt['shd_ticket_urgency'] = 'Urgence';
$txt['shd_ticket_assigned'] = 'Assigné';
$txt['shd_ticket_assignedto'] = 'Assigné à';
$txt['shd_ticket_started_by'] = 'Démarré par';
$txt['shd_ticket_updated_by'] = 'Mis à jour par';
$txt['shd_ticket_status'] = 'Statut';
$txt['shd_ticket_num_replies'] = 'Réponses';
$txt['shd_ticket_replies'] = 'Réponses';
$txt['shd_ticket_staff'] = 'Membre du personnel';
$txt['shd_ticket_attachments'] = 'Fichiers joints';
$txt['shd_ticket_reply_number'] = 'Répondre <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Billet en attente';
$txt['shd_ticket'] = 'Billet';
$txt['shd_reply_written'] = 'Réponse écrite %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Jamais';
$txt['shd_linktree_tickets'] = 'Billets';
$txt['shd_ticket_privacy'] = 'Confidentialité';
$txt['shd_ticket_notprivate'] = 'Non Privé';
$txt['shd_ticket_private'] = 'Privé';
$txt['shd_ticket_change'] = 'Changement';
$txt['shd_ticket_ip'] = 'Adresse IP';
$txt['shd_back_to_hd'] = 'Retour au helpdesk';
$txt['shd_go_to_replies'] = 'Aller aux Réponses';
$txt['shd_go_to_action_log'] = 'Aller au journal des actions';
$txt['shd_go_to_replies_start'] = 'Aller à la première réponse';

$txt['shd_ticket_has_been_deleted'] = 'Ce ticket est actuellement dans la corbeille et ne peut pas être modifié sans être renvoyé au helpdesk.';
$txt['shd_ticket_replies_deleted'] = 'Ce ticket a déjà été supprimé des réponses.';
$txt['shd_ticket_replies_deleted_view'] = 'Celles-ci sont affichées avec un fond de couleur. <a href="%1$s">Voir le ticket sans les suppressions</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Veuillez <a href="%1$s">cliquer ici</a> pour les voir.';

$txt['shd_ticket_notnew'] = 'Vous avez déjà vu ceci';
$txt['shd_ticket_new'] = 'Nouveau!';

$txt['shd_linktree_move_ticket'] = 'Déplacer le ticket';
$txt['shd_linktree_move_topic'] = 'Déplacer le sujet vers le helpdesk';

$txt['shd_cancel_ticket'] = 'Annuler et revenir au ticket';
$txt['shd_cancel_home'] = 'Annuler et retourner à la page d\'accueil du helpdesk';
$txt['shd_cancel_topic'] = 'Annuler et revenir au sujet';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Répondre au ticket';
$txt['shd_ticket_quote'] = 'Répondre avec un devis';
$txt['shd_go_advanced'] = 'Avancez !';
$txt['shd_ticket_edit_reply'] = 'Modifier la réponse';
$txt['shd_ticket_quote_short'] = 'Devis';
$txt['shd_ticket_markunread'] = 'Marquer comme non lu';
$txt['shd_ticket_reply_short'] = 'Répondre';
$txt['shd_ticket_edit'] = 'Editer';
$txt['shd_ticket_resolved'] = 'Marquer comme résolu';
$txt['shd_ticket_unresolved'] = 'Marquer comme non résolu';
$txt['shd_ticket_assign'] = 'Affecter';
$txt['shd_ticket_assign_self'] = 'Assigner à moi';
$txt['shd_ticket_reassign'] = 'Ré-assigner';
$txt['shd_ticket_unassign'] = 'Dé-assigner';
$txt['shd_ticket_delete'] = 'Supprimez';
$txt['shd_delete_confirm'] = 'Êtes-vous sûr de vouloir supprimer ce ticket ? Si supprimé, ce ticket sera déplacé dans la corbeille.';
$txt['shd_delete_reply_confirm'] = 'Êtes-vous sûr de vouloir supprimer cette réponse ? Si elle est supprimée, cette réponse sera déplacée dans la corbeille.';
$txt['shd_delete_attach_confirm'] = 'Êtes-vous sûr de vouloir supprimer cette pièce jointe ? (Cette opération ne peut pas être annulée !)';
$txt['shd_delete_attach'] = 'Supprimer cette pièce jointe';
$txt['shd_ticket_restore'] = 'Restaurer';
$txt['shd_delete_permanently'] = 'Supprimer définitivement';
$txt['shd_delete_permanently_confirm'] = 'Êtes-vous sûr de vouloir supprimer définitivement ce ticket ? Cette action est irréversible !';
$txt['shd_ticket_move_to_topic'] = 'Déplacer vers le sujet';
$txt['shd_move_dept'] = 'Déplacer.';
$txt['shd_actions'] = 'Actions';
$txt['shd_back_to_ticket'] = 'Revenir à ce ticket après la publication';
$txt['shd_disable_smileys_post'] = 'Désactiver les émoticônes dans ce message';
$txt['shd_resolve_this_ticket'] = 'Marquer ce ticket comme résolu';
$txt['shd_override_cf'] = 'Remplacer les exigences des champs personnalisés';
$txt['shd_silent_update'] = 'Mise à jour silencieuse (envoyer aucune notification)';
$txt['shd_select_notifications'] = 'Sélectionnez les personnes à informer de cette réponse...';

$txt['shd_ticket_assign_ticket'] = 'Assigner un ticket';
$txt['shd_ticket_assign_to'] = 'Assigner un ticket à';

$txt['shd_ticket_move_dept'] = 'Déplacer le ticket vers un autre service';
$txt['shd_ticket_move_to'] = 'Déplacer vers';
$txt['shd_current_dept'] = 'Actuellement dans le service';
$txt['shd_ticket_move'] = 'Déplacer le ticket';
$txt['shd_unknown_dept'] = 'Le service spécifié n\'existe pas.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Nouveau sujet';
$txt['shd_move_ticket_to_topic'] = 'Déplacer le ticket vers le sujet';
$txt['shd_move_ticket'] = 'Déplacer le ticket';
$txt['shd_ticket_board'] = 'Tableau';
$txt['shd_change_ticket_subject'] = 'Modifier le sujet du ticket';
$txt['shd_move_send_pm'] = 'Envoyer un MP au propriétaire du ticket';
$txt['shd_move_why'] = 'Veuillez entrer une brève description des raisons pour lesquelles ce ticket est déplacé vers un sujet du forum.';
$txt['shd_ticket_moved_subject'] = 'Votre ticket a été déplacé.';
$txt['shd_move_default'] = 'Bonjour {user},' . "\n\n" . 'Votre ticket, {subject}, a été déplacé du helpdesk vers un sujet du forum.' . "\n" . 'Vous pouvez trouver votre ticket dans le tableau {board} ou via ce lien :' . "\n\n" . '{link}' . "\n\n" . 'Remerciements';

$txt['shd_move_topic_to_ticket'] = 'Déplacer le sujet vers le helpdesk';
$txt['shd_move_topic'] = 'Déplacer le sujet';
$txt['shd_change_topic_subject'] = 'Changer le sujet du sujet';
$txt['shd_move_send_pm_topic'] = 'Envoyer un MP au début du sujet';
$txt['shd_move_why_topic'] = 'Veuillez entrer une brève description sur la raison pour laquelle ce sujet est déplacé vers le helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Votre sujet a été déplacé.';
$txt['shd_move_default_topic'] = 'Bonjour {user},' . "\n\n" . 'Votre sujet, {subject}, a été déplacé du forum vers la section Helpdesk.' . "\n" . 'Vous pouvez trouver votre sujet via ce lien :' . "\n\n" . '{link}' . "\n\n" . 'Remerciements';

$txt['shd_user_no_hd_access'] = 'Note : la personne qui a commencé ce sujet ne peut pas voir le helpdesk !';
$txt['shd_user_helpdesk_access'] = 'La personne qui a commencé ce sujet peut voir le helpdesk.';
$txt['shd_user_hd_access_dept_1'] = 'La personne qui a commencé ce sujet peut voir le service suivant : ';
$txt['shd_user_hd_access_dept'] = 'La personne qui a commencé ce sujet peut voir les services suivants : ';
$txt['shd_move_ticket_department'] = 'Déplacer le ticket vers quel service';
$txt['shd_move_dept_why'] = 'Veuillez entrer une brève description des raisons pour lesquelles ce ticket est déplacé vers un autre département.';
$txt['shd_move_dept_default'] = 'Bonjour {user},' . "\n\n" . 'Votre billet, {subject}, a été déplacé du service {current_dept} vers le service {new_dept}.' . "\n" . 'Vous pouvez trouver votre ticket via ce lien :' . "\n\n" . '{link}' . "\n\n" . 'Remerciements';

$txt['shd_ticket_move_deleted'] = 'Ce ticket a des réponses qui sont actuellement dans la corbeille. Que voulez-vous faire?';
$txt['shd_ticket_move_deleted_abort'] = 'Abandonner, emmener dans la corbeille';
$txt['shd_ticket_move_deleted_delete'] = 'Continuez, abandonnez les réponses supprimées (ne les déplacez pas dans le nouveau sujet)';
$txt['shd_ticket_move_deleted_undelete'] = 'Continuer, annuler la suppression des réponses (déplacez-les dans le nouveau sujet)';

$txt['shd_ticket_move_cfs'] = 'Ce ticket a des champs personnalisés qui peuvent avoir besoin d\'être déplacés.';
$txt['shd_ticket_move_cfs_warn'] = 'Certains de ces champs peuvent ne pas être visibles pour les autres utilisateurs. Ces champs sont indiqués avec un point d\'exclamation.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Vous pouvez voir ce champ, d\'autres utilisateurs ne peuvent pas - mais une fois qu\'il fait partie du forum, il deviendra visible pour tous ceux qui peuvent accéder au forum.';
$txt['shd_ticket_move_cfs_purge'] = 'Supprimer le contenu du champ';
$txt['shd_ticket_move_cfs_embed'] = 'Conserver le champ et le mettre dans le nouveau sujet';
$txt['shd_ticket_move_cfs_user'] = 'Actuellement visible par les utilisateurs réguliers';
$txt['shd_ticket_move_cfs_staff'] = 'Actuellement visible aux membres du personnel';
$txt['shd_ticket_move_cfs_admin'] = 'Actuellement visible par les administrateurs';
$txt['shd_ticket_move_accept'] = 'J\'accepte que certains des champs manipulés ici ne soient pas visibles par tous les utilisateurs, et que ce sujet doit être déplacé dans le forum, avec les paramètres ci-dessus.';
$txt['shd_ticket_move_reqd'] = 'Cette option doit être sélectionnée pour que vous puissiez déplacer ce ticket vers le forum.';
$txt['shd_ticket_move_ok'] = 'Ce champ peut être déplacé en toute sécurité, tous les utilisateurs qui peuvent voir le ticket peuvent voir ce champ, il n\'y a aucune information cachée aux utilisateurs ou au personnel.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Ce ticket contient des champs que les utilisateurs ou le personnel ne peuvent pas voir, pour cela, vous devez spécifiquement confirmer que vous en êtes conscient - veuillez retourner à la page précédente, la case à cocher pour confirmer que vous êtes conscient de cela se trouve au bas du formulaire.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Corbeille';
$txt['shd_recycle_greeting'] = 'Il s\'agit de la corbeille de recyclage. Tous les tickets supprimés vont ici, mais les membres du personnel ayant des autorisations spéciales peuvent retirer des tickets en permanence d\'ici.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Créer un ticket';
$txt['shd_edit_ticket'] = 'Modifier le ticket';
$txt['shd_edit_ticket_linktree'] = 'Modifier le ticket (%s)';
$txt['shd_ticket_subject'] = 'Sujet du ticket';
$txt['shd_ticket_proxy'] = 'Publier au nom de';
$txt['shd_ticket_post_error'] = 'Le problème ou les problèmes suivants sont survenus en essayant de publier ce ticket';
$txt['shd_reply_ticket'] = 'Répondre au ticket';
$txt['shd_reply_ticket_linktree'] = 'Répondre au ticket (%s)';
$txt['shd_edit_reply_linktree'] = 'Modifier la réponse (%s)';
$txt['shd_previewing_ticket'] = 'Aperçu du ticket';
$txt['shd_previewing_reply'] = 'Prévisualisation de la réponse à';
$txt['shd_choose_one'] = '[En choisir un]';
$txt['shd_no_value'] = '[aucune valeur]';
$txt['shd_ticket_dept'] = 'Service de ticket';
$txt['shd_select_dept'] = '-- Sélectionnez un service --';
$txt['canned_replies'] = 'Ajouter une réponse prédéfinie :';
$txt['canned_replies_select'] = '-- Sélectionnez une réponse --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Réponses du Helpdesk postées à partir de l\'IP (rangée)';
$txt['shd_no_replies_from_ip'] = 'Aucune réponse du helpdesk à partir de l\'IP spécifiée (intervalle) trouvée';
$txt['shd_replies_from_ip_desc'] = 'Voici une liste de tous les messages postés au helpdesk à partir de cette IP (rangée).';
$txt['shd_is_ticket_opener'] = ' (entrée de billet)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'Archive BZip2';
$txt['shd_attachtype_gz'] = 'Archive GZip';
$txt['shd_attachtype_rar'] = 'Archive Rar/WinRAR';
$txt['shd_attachtype_zip'] = 'Archive Zip';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'Fichier audio MP3 (MPEG Layer III)';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Image Bitmap Windows';
$txt['shd_attachtype_gif'] = 'Image du format d\'interchange graphique (GIF)';
$txt['shd_attachtype_jpeg'] = 'Image du groupe d\'experts photographiques conjoints (JPEG)';
$txt['shd_attachtype_jpg'] = 'Image du groupe d\'experts photographiques conjoints (JPEG)';
$txt['shd_attachtype_png'] = 'Image graphique réseau portable (PNG)';
$txt['shd_attachtype_svg'] = 'Image vectorielle évolutive (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Vidéo Windows Media';
// Office formats
$txt['shd_attachtype_doc'] = 'Document Microsoft Word';
$txt['shd_attachtype_mdb'] = 'Base de données Microsoft Access';
$txt['shd_attachtype_ppt'] = 'Présentation Microsoft Powerpoint';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'Fichier source C++';
$txt['shd_attachtype_php'] = 'Script PHP';
$txt['shd_attachtype_py'] = 'Fichier source Python';
$txt['shd_attachtype_rb'] = 'Fichier source Ruby';
$txt['shd_attachtype_sql'] = 'Script SQL';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (archive KML)';
$txt['shd_attachtype_pdf'] = 'Fichier de document portable Adobe Acrobat';
$txt['shd_attachtype_psd'] = 'Document Adobe Photoshop';
$txt['shd_attachtype_swf'] = 'Fichier Adobe Flash';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Fichier exécutable (Windows)';
$txt['shd_attachtype_htm'] = 'Document de balisage hypertexte (HTML)';
$txt['shd_attachtype_html'] = 'Document de balisage hypertexte (HTML)';
$txt['shd_attachtype_rtf'] = 'Format de texte enrichi (RTF)';
$txt['shd_attachtype_txt'] = 'Texte brut';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Journal des actions du ticket';
$txt['shd_ticket_log_count_one'] = '1 entrée';
$txt['shd_ticket_log_count_more'] = '%s entrées';
$txt['shd_ticket_log_none'] = 'Ce ticket n\'a pas été modifié.';
$txt['shd_ticket_log_member'] = 'Membre';
$txt['shd_ticket_log_ip'] = 'Adresse IP du membre :';
$txt['shd_ticket_log_date'] = 'Date';
$txt['shd_ticket_log_action'] = 'Action';
$txt['shd_ticket_log_full'] = 'Aller au journal complet des actions (Tous les tickets)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Tickets connexes';
$txt['shd_ticket_create_relationship'] = 'Créer une relation';
$txt['shd_ticket_delete_relationship'] = 'Supprimer la relation';
$txt['shd_ticket_reltype'] = 'sélectionner le type';
$txt['shd_ticket_reltype_linked'] = 'Lié à';
$txt['shd_ticket_reltype_duplicated'] = 'Doublon de';
$txt['shd_ticket_reltype_parent'] = 'Parent de';
$txt['shd_ticket_reltype_child'] = 'Enfant de';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Informations complémentaires';
$txt['shd_ticket_additional_details'] = 'Détails supplémentaires';
$txt['shd_ticket_empty_field'] = 'Ce champ est vide.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Notifications';
$txt['shd_ticket_notify_noneprefs'] = 'Vos préférences utilisateur ne prennent pas en compte la notification de ce ticket.';
$txt['shd_ticket_notify_changeprefs'] = 'Modifier vos préférences';
$txt['shd_ticket_notify_because'] = 'Vos préférences vous indiquent vous notifier des réponses à ce ticket :';
$txt['shd_ticket_notify_because_yourticket'] = 'comme c\'est votre ticket';
$txt['shd_ticket_notify_because_assignedyou'] = 'comme il vous est assigné';
$txt['shd_ticket_notify_because_priorreply'] = 'comme vous y avez répondu avant';
$txt['shd_ticket_notify_because_anyreply'] = 'pour tout ticket';

$txt['shd_ticket_notify_me_always'] = 'Vous surveillez ce ticket (et recevrez une notification à chaque réponse)';
$txt['shd_ticket_monitor_on_note'] = 'Vous pouvez surveiller toutes les réponses à ce ticket par e-mail, quelles que soient vos préférences :';
$txt['shd_ticket_monitor_off_note'] = 'Vous pouvez désactiver la surveillance pour ce ticket et utiliser vos préférences à la place:';
$txt['shd_ticket_monitor_on'] = 'Activer la surveillance';
$txt['shd_ticket_monitor_off'] = 'Désactiver la surveillance';
$txt['shd_ticket_notify_me_never_note'] = 'Vous pouvez ignorer les mises à jour par courriel pour ce ticket quelles que soient vos préférences :';
$txt['shd_ticket_notify_me_never'] = 'Vous avez désactivé toutes les notifications pour ce ticket.';
$txt['shd_ticket_notify_me_never_on'] = 'Désactiver les notifications';
$txt['shd_ticket_notify_me_never_off'] = 'Activer les notifications';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'Il se peut que le moteur de recherche ne répertorie pas tous les billets disponibles; il fait actuellement l\'objet d\'une enquête.';
$txt['shd_search_warning_admin'] = 'L\'outil de recherche nécessite que son index soit reconstruit. Vous pouvez l\'obtenir à partir de l\'option Maintenance, dans la zone Helpdesk, dans le panneau d\'administration.';
$txt['shd_search'] = 'Rechercher des tickets';
$txt['shd_search_results'] = 'Recherche de Tickets - Résultats';
$txt['shd_search_text'] = 'Mots que vous recherchez :';
$txt['shd_search_match'] = 'Qu\'est-ce qui doit être mis en correspondance ?';
$txt['shd_search_match_all'] = 'Correspond à tous les mots fournis';
$txt['shd_search_match_any'] = 'Faire correspondre tous les mots fournis';
$txt['shd_search_scope'] = 'Inclure les types de tickets :';
$txt['shd_search_scope_open'] = 'Tickets ouverts';
$txt['shd_search_scope_closed'] = 'Tickets fermés';
$txt['shd_search_scope_recycle'] = 'Objets dans la corbeille';
$txt['shd_search_result_ticket'] = 'Billet %1$s';
$txt['shd_search_result_reply'] = 'Répondre au ticket %1$s';
$txt['shd_search_last_updated'] = 'Dernière mise à jour :';
$txt['shd_search_ticket_opened_by'] = 'Ticket ouvert par:';
$txt['shd_search_ticket_replied_by'] = 'Ticket répondu par :';
$txt['shd_search_dept'] = 'Rechercher dans quel département(s) :';

$txt['shd_search_urgency'] = 'Inclure les niveaux d\'urgence :';

$txt['shd_search_where'] = 'Quels sont les éléments à rechercher :';
$txt['shd_search_where_tickets'] = 'Les corps des tickets';
$txt['shd_search_where_replies'] = 'Les réponses dans les tickets';
$txt['shd_search_where_subjects'] = 'Sujets du ticket';

$txt['shd_search_ticket_starter'] = 'Tickets commencés par:';
$txt['shd_search_ticket_assignee'] = 'Tickets assignés à:';
$txt['shd_search_ticket_named_person'] = 'Tapez le nom de la ou des personnes qui vous intéressent.';

$txt['shd_search_no_results'] = 'Aucun résultat n\'a été trouvé avec les critères donnés. Vous pouvez revenir en arrière et essayer de modifier vos critères de recherche.';
$txt['shd_search_criteria'] = 'Critères de recherche :';
$txt['shd_search_excluded'] = 'Si toutes les options possibles ont été sélectionnées, elles n\'ont pas été incluses dans ce qui précède (p. ex. si tous les niveaux d\'urgence possibles ont été cochés, il n\'est pas indiqué ci-dessus, donc vous pouvez vous concentrer sur ce qui est spécifique à votre recherche)';
//@}