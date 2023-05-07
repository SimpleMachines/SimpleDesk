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
$txt['shd_helpdesk'] = 'Mesa de ayuda';
$txt['shd_helpdesk_maintenance'] = 'El helpdesk está actualmente en <strong>modo de mantenimiento</strong>. Solo los administradores del foro y del helpdesk pueden verlo.';
$txt['shd_open_ticket'] = 'ticket abierto';
$txt['shd_open_tickets'] = 'tickets abiertos';
$txt['shd_none'] = 'Ninguna';

$txt['shd_display_nojs'] = 'JavaScript no está activado en su navegador. Algunas funciones pueden no funcionar correctamente (o en absoluto), o comportarse de una manera inesperada.';
//@}

//! @name Admininstration panel strings
//@{
$txt['shd_admin_welcome'] = '¡Bienvenido al centro principal de administración del helpdes!';
$txt['shd_admin_title'] = 'Centro de administración del helpdesk';
$txt['shd_staff_list'] = 'Personal del helpdesk';
$txt['shd_update_available'] = '¡Nueva versión disponible!';
$txt['shd_update_message'] = 'Se ha lanzado una nueva versión de SimpleDesk. Te hemos ayudado a <a href="#" id="update-link">actualizar a la última versión</a> para mantenerte seguro y disfrutar de todas las características que nos ofrece nuestra modificación.' . "\n\n" . '<span style="display: none;" id="information-link-span"><br>Para más información sobre lo que es nuevo en esta versión, por favor visite <a href="#" id="information-link" target="_blank">nuestro sitio web</a>.</span><br>' . "\n\n" . '<strong>El equipo de SimpleDesk</strong>';
//@}

//! @name Urgency levels, ties to helpdesk_tickets.urgency
//@{
$txt['shd_urgency_0'] = 'Baja';
$txt['shd_urgency_1'] = 'Medio';
$txt['shd_urgency_2'] = 'Alta';
$txt['shd_urgency_3'] = 'Muy alta';
$txt['shd_urgency_4'] = 'Sábado';
$txt['shd_urgency_5'] = 'Crítico';
$txt['shd_urgency_increase'] = 'Aumentar';
$txt['shd_urgency_decrease'] = 'Reducir';
//@}

//! @name Status, ties to helpdesk_tickets.status
//@{
$txt['shd_status_0'] = 'Nuevo';
$txt['shd_status_1'] = 'Comentario del personal pendiente';
$txt['shd_status_2'] = 'Comentario de usuario pendiente';
$txt['shd_status_3'] = 'Resuelto/Cerrado';
$txt['shd_status_4'] = 'Referido al Supervisor';
$txt['shd_status_5'] = 'Escalado - Urgente';
$txt['shd_status_6'] = 'Eliminado';
$txt['shd_status_7'] = 'En espera';
//@}

//! @name Headings, for the helpdesk listing pages
//@{
$txt['shd_status_0_heading'] = 'Nuevos Tickets';
$txt['shd_status_1_heading'] = 'Tickets en espera de respuesta del personal';
$txt['shd_status_2_heading'] = 'Tickets en espera de respuesta del usuario';
$txt['shd_status_3_heading'] = 'Tickets cerrados';
$txt['shd_status_4_heading'] = 'Tickets recomendados al Supervisor';
$txt['shd_status_5_heading'] = 'Tickets urgentes';
$txt['shd_status_6_heading'] = 'Tickets reciclados';
$txt['shd_status_7_heading'] = 'En espera de tickets';
$txt['shd_status_assigned_heading'] = 'Asignado a mí';
$txt['shd_status_withdeleted_heading'] = 'Tickets con respuestas eliminadas';
//@}

//! @name Ticket Types, statues, etc
//@{
$txt['shd_tickets_open'] = 'Tickets abiertos';
$txt['shd_tickets_closed'] = 'Tickets cerrados';
$txt['shd_tickets_recycled'] = 'Tickets reciclados';

$txt['shd_assigned'] = 'Asignado';
$txt['shd_unassigned'] = 'Sin asignar';

$txt['shd_read_ticket'] = 'Leer Ticket';
$txt['shd_unread_ticket'] = 'Ticket no leído';
$txt['shd_unread_tickets'] = 'Tickets no leídos';

$txt['shd_owned'] = 'Ticket poseído'; // aka Assigned to Me

$txt['shd_count_ticket_1'] = 'ticket';
$txt['shd_count_tickets'] = 'tickets';
//@}

//! @name Errors
//@{
$txt['cannot_access_helpdesk'] = 'No tiene permiso para acceder al helpdesk.';
$txt['shd_no_ticket'] = 'El ticket que has solicitado no existe.';
$txt['shd_no_reply'] = 'La respuesta al ticket que tiene no parece existir o no es parte de este ticket.';
$txt['shd_no_topic'] = 'El tema que has solicitado no parece existir.';
$txt['shd_ticket_no_perms'] = 'No tiene permiso para ver ese ticket.';
$txt['shd_error_no_tickets'] = 'No se encontraron tickets.';
$txt['shd_inactive'] = 'El helpdesk está desactivado actualmente.';
$txt['shd_cannot_assign'] = 'No tienes permiso para asignar Tickets.';
$txt['shd_cannot_assign_other'] = 'Este ticket ya está asignado a otro usuario. Usted no puede reasignarlo a sí mismo - póngase en contacto con el administrador.';
$txt['shd_no_staff_assign'] = 'No hay personal configurado; no es posible asignar un Ticket. Póngase en contacto con su administrador.';
$txt['shd_assigned_not_permitted'] = 'El usuario que ha solicitado asignar este ticket no tiene permisos suficientes para verlo.';
$txt['shd_cannot_resolve'] = 'No tiene permiso para marcar este ticket como resuelto.';
$txt['shd_cannot_unresolve'] = 'No tiene permiso para reabrir un ticket resuelto.';
$txt['error_shd_cannot_resolve_children'] = 'Este ticket no se puede cerrar actualmente; este ticket es el padre de uno o más tickets que están actualmente abiertos.';
$txt['error_shd_proxy_unknown'] = 'El usuario de este ticket es publicado en nombre de no existe.';
$txt['shd_cannot_change_privacy'] = 'No tiene permiso para alterar la privacidad de este ticket.';
$txt['shd_cannot_change_urgency'] = 'No tiene permiso para modificar la urgencia de este ticket.';
$txt['shd_ajax_problem'] = 'Hubo un problema al intentar cargar la página. ¿Quieres volver a intentarlo?';
$txt['shd_cannot_move_ticket'] = 'No tiene permiso para mover este ticket a un tema.';
$txt['shd_cannot_move_topic'] = 'No tiene permiso para mover este tema a un ticket.';
$txt['shd_moveticket_noboards'] = '¡No hay tableros para mover este ticket!';
$txt['shd_move_no_pm'] = 'Debe introducir una razón para mover el ticket para enviar al propietario del ticket, o desmarque la opción de "enviar un PM al propietario del ticket".';
$txt['shd_move_no_pm_topic'] = 'Debe introducir una razón para mover el tema para enviar al inicio del tema, o desmarque la opción de \'enviar un MP al inicio del tema\'.';
$txt['shd_move_topic_not_created'] = 'No se pudo mover el ticket al tablero. Inténtalo de nuevo.';
$txt['shd_move_ticket_not_created'] = 'Error al mover el tema al helpdesk. Por favor, inténtelo de nuevo.';
$txt['shd_no_replies'] = 'Este ticket no tiene ninguna respuesta todavía.';
$txt['cannot_shd_new_ticket'] = 'No tiene permiso para crear un nuevo Ticket.';
$txt['cannot_shd_edit_ticket'] = 'No tiene permiso para editar este ticket.';
$txt['shd_cannot_reply_any'] = 'No tiene permiso para responder a ningún Ticket.';
$txt['shd_cannot_reply_any_but_own'] = 'No tiene permiso para responder a ningún ticket que no sea el suyo propio.';
$txt['shd_cannot_edit_reply_any'] = 'No tiene permiso para editar ninguna respuesta.';
$txt['shd_cannot_edit_reply_any_but_own'] = 'No tiene permiso para editar respuestas a ningún ticket que no sea sus propias respuestas.';
$txt['shd_cannot_edit_closed'] = 'No puedes editar los Tickets resueltos; primero debes marcarlos sin resolver.';
$txt['shd_cannot_edit_deleted'] = 'No puedes editar los tickets en la papelera de reciclaje. Deben ser restaurados primero.';
$txt['shd_cannot_reply_closed'] = 'No puedes responder a los Tickets resueltos; primero debes marcarlos sin resolver.';
$txt['shd_cannot_reply_deleted'] = 'No puedes responder a los tickets en la papelera de reciclaje. Deben ser restaurados primero.';
$txt['shd_cannot_delete_ticket'] = 'No tienes permiso para eliminar este ticket.';
$txt['shd_cannot_delete_reply'] = 'No tienes permiso para eliminar esa respuesta.';
$txt['shd_cannot_restore_ticket'] = 'No está autorizado a restaurar este ticket desde la papelera de reciclaje.';
$txt['shd_cannot_restore_reply'] = 'No está autorizado a restaurar esa respuesta desde la papelera de reciclaje.';
$txt['shd_cannot_view_resolved'] = 'No tienes permiso para acceder a los Tickets resueltos.';
$txt['cannot_shd_access_recyclebin'] = 'No puede acceder a la papelera de reciclaje.';
$txt['shd_cannot_move_ticket_with_deleted'] = 'No puede mover este ticket al foro; hay una o más respuestas borradas, a las que sus permisos actuales no permiten el acceso.';
$txt['shd_cannot_attach_ext'] = 'El tipo de archivo que ha intentado adjuntar ({ext}) no está permitido aquí. Los tipos de archivo permitidos son: {attach_exts}';
$txt['shd_ticket_unavailable'] = 'Este ticket no está disponible para modificación.';
$txt['shd_invalid_relation'] = 'Debe proporcionar un tipo de relación válido para estos Tickets.';
$txt['shd_no_relation_delete'] = 'No se puede eliminar una relación que no existe.';
$txt['shd_cannot_relate_self'] = 'No puede hacer que un ticket se relacione con sí mismo.';
$txt['shd_relationships_are_disabled'] = 'Las relaciones de tickets están actualmente deshabilitadas.';
$txt['error_invalid_fields'] = 'Los siguientes campos tienen valores que no se pueden utilizar: %1$s';
$txt['error_missing_fields'] = 'Los siguientes campos no fueron completados y necesitan ser: %1$s';
$txt['error_missing_multi'] = '%1$s (al menos %2$d debe ser seleccionado)';
$txt['error_no_dept'] = 'No ha seleccionado un departamento en el que enviar este ticket.';
$txt['shd_cannot_move_dept'] = 'No puedes mover este ticket, no hay donde moverlo.';
$txt['shd_no_perm_move_dept'] = 'No tiene permiso para mover esta entrada a otro departamento.';
$txt['cannot_shd_delete_attachment'] = 'No tiene permiso para eliminar archivos adjuntos.';
$txt['cannot_shd_move_ticket_topic_hidden_cfs'] = 'No puede mover este ticket a un tema; hay campos personalizados adjuntos que requieren que un administrador confirme el movimiento.';
$txt['cannot_monitor_ticket'] = 'No se le permite activar el control de este ticket.';
$txt['cannot_unmonitor_ticket'] = 'No está autorizado a desactivar el control de este billete.';
//@}

//! @name The main Helpdesk
//@{
$txt['shd_home'] = 'Mesa de ayuda'; // separate string in case someone wants to change it independently of the main/admin menu
$txt['shd_departments'] = 'Departamentos'; // ditto
$txt['shd_new_ticket'] = 'Publicar nuevo Ticket';
$txt['shd_new_ticket_proxy'] = 'Publicar ticket proxy';
$txt['shd_helpdesk_profile'] = 'Perfil de helpdesk';
$txt['shd_welcome'] = '¡Bienvenido, %s!';
$txt['shd_go'] = 'Go!';
$txt['shd_go_to_ticket'] = 'Ir al ticket';
$txt['shd_options'] = 'Opciones';
$txt['shd_search_menu'] = 'Buscar';
//@}

//! @name Admin center menu buttons
//@{
$txt['shd_admin_info'] = 'Información';
$txt['shd_admin_options'] = 'Opciones';
$txt['shd_admin_custom_fields'] = 'Campos personalizados';
$txt['shd_admin_departments'] = 'Departamentos';
$txt['shd_admin_permissions'] = 'Permisos';
$txt['shd_admin_plugins'] = 'Plugins';
$txt['shd_admin_cannedreplies'] = 'Respuestas predefinidas';
$txt['shd_admin_maint'] = 'Mantenimiento';
//@}

//! @name Greetings
//@{
$txt['shd_user_greeting'] = 'Aquí usted puede presentar nuevos tickets para que el personal del sitio actúe, y comprobar los tickets actuales ya en marcha.';
$txt['shd_staff_greeting'] = 'Aquí están todos los tickets que requieren atención.';
$txt['shd_shd_greeting'] = 'Este es el Escritorio de Ayuda. Aquí pierdes tu tiempo para ayudar a los novatos. ¡Disfrútalo! ;D';
$txt['shd_closed_user_greeting'] = 'Estos son todos los tickets cerrados/resueltos que ha enviado al helpdesk.';
$txt['shd_closed_staff_greeting'] = 'Todos ellos son tickets cerrados/resueltos enviados al helpdesk.';
$txt['shd_category_filter'] = 'Filtrado de categorías';
//@}

//! @name Messages
//@{
$txt['shd_ticket_posted_header'] = '¡Tu ticket ha sido creado!';
$txt['shd_ticket_posted_body'] = '¡Gracias por publicar tu ticket, {membername}!' . "\n\n" . 'El personal del helpdesk lo revisará y le responderá lo antes posible.' . "\n\n" . 'Mientras tanto, puedes ver tu ticket, &quot;[iurl={ticketurl}]{subject}[/iurl]&quot; en la siguiente URL:' . "\n" . '[iurl={ticketurl}]{ticketurl}[/iurl]' . "\n\n" . '[iurl={newticketlink}]Abrir otro ticket[/iurl] | [iurl={helpdesklink}]Volver al helpdesk principal[/iurl] | [iurl={forumlink}]Volver al foro[/iurl]';
$txt['shd_ticket_posted_prefs'] = "\n\n" . 'Puede activar las notificaciones por correo electrónico sobre los cambios en su ticket, en el área [iurl={prefslink}]Preferencias de helpdesk[/iurl].';
$txt['shd_ticket_posted_footer'] = "\n\n" . 'Saludos,' . "\n" . 'El equipo de {forum_name}.';
//@}

//! @name The main ticket view
//@{
$txt['shd_ticket_details'] = 'Detalles del ticket';
$txt['shd_ticket_updated'] = 'Actualizado';
$txt['shd_ticket_id'] = 'Id';
$txt['shd_ticket_name'] = 'Nombre';
$txt['shd_ticket_user'] = 'Usuario';
$txt['shd_ticket_date'] = 'Publicado';
$txt['shd_ticket_urgency'] = 'Urgencia';
$txt['shd_ticket_assigned'] = 'Asignado';
$txt['shd_ticket_assignedto'] = 'Asignado a';
$txt['shd_ticket_started_by'] = 'Iniciado por';
$txt['shd_ticket_updated_by'] = 'Actualizado por';
$txt['shd_ticket_status'] = 'Estado';
$txt['shd_ticket_num_replies'] = 'Respuestas';
$txt['shd_ticket_replies'] = 'Respuestas';
$txt['shd_ticket_staff'] = 'Miembro del personal';
$txt['shd_ticket_attachments'] = 'Adjuntos';
$txt['shd_ticket_reply_number'] = 'Responder <strong>#%s</strong>'; // 'Reply #34'
$txt['shd_ticket_hold'] = 'Ticket en espera';
$txt['shd_ticket'] = 'Ticket';
$txt['shd_reply_written'] = 'Respuesta escrita %s'; // 'Reply written Today at 04:12:29 pm',  'Reply written January 5 2009 04:12:29 pm'
$txt['shd_never'] = 'Nunca';
$txt['shd_linktree_tickets'] = 'Tickets';
$txt['shd_ticket_privacy'] = 'Privacidad';
$txt['shd_ticket_notprivate'] = 'No privado';
$txt['shd_ticket_private'] = 'Privado';
$txt['shd_ticket_change'] = 'Cambiar';
$txt['shd_ticket_ip'] = 'Dirección IP';
$txt['shd_back_to_hd'] = 'Volver al helpdesk';
$txt['shd_go_to_replies'] = 'Ir a Respuestas';
$txt['shd_go_to_action_log'] = 'Ir al registro de acciones';
$txt['shd_go_to_replies_start'] = 'Ir a la primera respuesta';

$txt['shd_ticket_has_been_deleted'] = 'Este ticket está actualmente en la papelera de reciclaje y no puede ser modificado sin ser devuelto al helpdesk.';
$txt['shd_ticket_replies_deleted'] = 'Este ticket ha sido borrado previamente.';
$txt['shd_ticket_replies_deleted_view'] = 'Estos se muestran con un fondo de color. <a href="%1$s">Ver el ticket sin borrarlo</a>.';
$txt['shd_ticket_replies_deleted_link'] = 'Por favor, <a href="%1$s">haz clic aquí</a> para verlos.';

$txt['shd_ticket_notnew'] = 'Ya has visto esto';
$txt['shd_ticket_new'] = '¡Nuevo!';

$txt['shd_linktree_move_ticket'] = 'Mover ticket';
$txt['shd_linktree_move_topic'] = 'Mover tema al helpdesk';

$txt['shd_cancel_ticket'] = 'Cancelar y volver al ticket';
$txt['shd_cancel_home'] = 'Cancelar y volver a la casa del helpdesk';
$txt['shd_cancel_topic'] = 'Cancelar y volver al tema';
//@}

//! @name Actions
//@{
$txt['shd_ticket_reply'] = 'Responder al ticket';
$txt['shd_ticket_quote'] = 'Responder con cita';
$txt['shd_go_advanced'] = '¡Avanzado!';
$txt['shd_ticket_edit_reply'] = 'Editar respuesta';
$txt['shd_ticket_quote_short'] = 'Cotización';
$txt['shd_ticket_markunread'] = 'Marcar no leídos';
$txt['shd_ticket_reply_short'] = 'Responder';
$txt['shd_ticket_edit'] = 'Editar';
$txt['shd_ticket_resolved'] = 'Marcar como resuelto';
$txt['shd_ticket_unresolved'] = 'Marcar sin resolver';
$txt['shd_ticket_assign'] = 'Asignar';
$txt['shd_ticket_assign_self'] = 'Asignar a mí';
$txt['shd_ticket_reassign'] = 'Reasignar';
$txt['shd_ticket_unassign'] = 'Des-asignar';
$txt['shd_ticket_delete'] = 'Eliminar';
$txt['shd_delete_confirm'] = '¿Está seguro que desea eliminar este ticket? Si se elimina, este ticket se moverá a la papelera de reciclaje.';
$txt['shd_delete_reply_confirm'] = '¿Está seguro que desea eliminar esta respuesta? Si se elimina, esta respuesta se moverá a la papelera de reciclaje.';
$txt['shd_delete_attach_confirm'] = '¿Está seguro que desea eliminar este archivo adjunto? (¡Esto no se puede deshacer!)';
$txt['shd_delete_attach'] = 'Eliminar este archivo adjunto';
$txt['shd_ticket_restore'] = 'Restaurar';
$txt['shd_delete_permanently'] = 'Eliminar permanentemente';
$txt['shd_delete_permanently_confirm'] = '¿Está seguro que desea eliminar permanentemente este ticket? ¡Esto NO se puede deshacer!';
$txt['shd_ticket_move_to_topic'] = 'Mover al tema';
$txt['shd_move_dept'] = 'Mover profundidad.';
$txt['shd_actions'] = 'Acciones';
$txt['shd_back_to_ticket'] = 'Volver a este ticket después de publicar';
$txt['shd_disable_smileys_post'] = 'Desactivar smileys en este post';
$txt['shd_resolve_this_ticket'] = 'Marcar este ticket como resuelto';
$txt['shd_override_cf'] = 'Reemplazar los requerimientos de campos personalizados';
$txt['shd_silent_update'] = 'Actualización silenciosa (no enviar notificaciones)';
$txt['shd_select_notifications'] = 'Seleccionar personas para notificar esta respuesta...';

$txt['shd_ticket_assign_ticket'] = 'Asignar Ticket';
$txt['shd_ticket_assign_to'] = 'Asignar ticket a';

$txt['shd_ticket_move_dept'] = 'Mover ticket a otro departamento';
$txt['shd_ticket_move_to'] = 'Mover a';
$txt['shd_current_dept'] = 'Actualmente en el departamento';
$txt['shd_ticket_move'] = 'Mover Ticket';
$txt['shd_unknown_dept'] = 'El departamento especificado no existe.';
//@}

//! @name Ticket to topic and back
//@{
$txt['shd_new_subject'] = 'Nuevo tema';
$txt['shd_move_ticket_to_topic'] = 'Mover ticket al tema';
$txt['shd_move_ticket'] = 'Mover ticket';
$txt['shd_ticket_board'] = 'Tablero';
$txt['shd_change_ticket_subject'] = 'Cambiar el asunto del ticket';
$txt['shd_move_send_pm'] = 'Enviar un MP al propietario del ticket';
$txt['shd_move_why'] = 'Por favor, introduzca una breve descripción de por qué este ticket se está moviendo a un tema del foro.';
$txt['shd_ticket_moved_subject'] = 'Su ticket ha sido movido.';
$txt['shd_move_default'] = 'Hola {user},' . "\n\n" . 'Su ticket, {subject}, se ha movido del helpdesk a un tema en el foro.' . "\n" . 'Puedes encontrar tu boleto en el tablero {board} o a través de este enlace:' . "\n\n" . '{link}' . "\n\n" . 'Gracias';

$txt['shd_move_topic_to_ticket'] = 'Mover tema al helpdesk';
$txt['shd_move_topic'] = 'Mover tema';
$txt['shd_change_topic_subject'] = 'Cambiar el tema';
$txt['shd_move_send_pm_topic'] = 'Enviar un MP al inicio del tema';
$txt['shd_move_why_topic'] = 'Por favor, introduzca una breve descripción de por qué este tema se está moviendo al helpdesk. ';
$txt['shd_ticket_moved_subject_topic'] = 'Tu tema ha sido movido.';
$txt['shd_move_default_topic'] = 'Hola {user},' . "\n\n" . 'Su tema, {subject}, se ha movido del foro a la sección de helpdesk.' . "\n" . 'Puedes encontrar tu tema a través de este enlace:' . "\n\n" . '{link}' . "\n\n" . 'Gracias';

$txt['shd_user_no_hd_access'] = 'Nota: la persona que inició este tema no puede ver el helpdesk!';
$txt['shd_user_helpdesk_access'] = 'La persona que inició este tema puede ver el helpdesk.';
$txt['shd_user_hd_access_dept_1'] = 'La persona que inició este tema puede ver el siguiente departamento: ';
$txt['shd_user_hd_access_dept'] = 'La persona que inició este tema puede ver los siguientes departamentos: ';
$txt['shd_move_ticket_department'] = 'Mover ticket a qué departamento';
$txt['shd_move_dept_why'] = 'Por favor, introduzca una breve descripción de por qué este ticket se está moviendo a un departamento diferente.';
$txt['shd_move_dept_default'] = 'Hola {user},' . "\n\n" . 'Tu ticket, {subject}, se ha movido del departamento {current_dept} al departamento {new_dept}.' . "\n" . 'Puedes encontrar tu boleto a través de este enlace:' . "\n\n" . '{link}' . "\n\n" . 'Gracias';

$txt['shd_ticket_move_deleted'] = 'Este boleto contiene respuestas que están actualmente en la papelera de reciclaje. ¿Qué desea hacer?';
$txt['shd_ticket_move_deleted_abort'] = 'Abortar, llevarme a la papelera de reciclaje';
$txt['shd_ticket_move_deleted_delete'] = 'Continuar, abandonar las respuestas eliminadas (no moverlas al nuevo tema)';
$txt['shd_ticket_move_deleted_undelete'] = 'Continuar, recuperar las respuestas (muévelas en el nuevo tema)';

$txt['shd_ticket_move_cfs'] = 'Este ticket tiene campos personalizados que pueden necesitar ser movidos.';
$txt['shd_ticket_move_cfs_warn'] = 'Algunos de estos campos pueden no ser visibles para otros usuarios. Estos campos están indicados con una marca de exclusión.';
$txt['shd_ticket_move_cfs_warn_user'] = 'Puedes ver este campo, otros usuarios no pueden - pero una vez que se convierte en parte del foro, se hará visible para todos los que puedan acceder al foro.';
$txt['shd_ticket_move_cfs_purge'] = 'Eliminar el contenido del campo';
$txt['shd_ticket_move_cfs_embed'] = 'Mantener el campo y ponerlo en el nuevo tema';
$txt['shd_ticket_move_cfs_user'] = 'Actualmente visible para usuarios regulares';
$txt['shd_ticket_move_cfs_staff'] = 'Actualmente visible para los miembros del personal';
$txt['shd_ticket_move_cfs_admin'] = 'Actualmente visible para los administradores';
$txt['shd_ticket_move_accept'] = 'Acepto que algunos de los campos manipulados aquí no sean visibles para todos los usuarios. y que este tema debe ser movido al foro, con los ajustes anteriores.';
$txt['shd_ticket_move_reqd'] = 'Esta opción debe ser seleccionada para que puedas mover este ticket al foro.';
$txt['shd_ticket_move_ok'] = 'Este campo es seguro para mover, todos los usuarios que pueden ver el ticket pueden ver este campo, no hay información oculta para los usuarios o el personal.';
$txt['shd_ticket_move_reqd_nonselected'] = 'Este ticket tiene campos que los usuarios o el personal no pueden ver, como tal usted necesita confirmar que usted es consciente de esto - por favor vuelva a la página anterior, la casilla de verificación para confirmar su conocimiento de esto está en la parte inferior del formulario.';
//@}

//! @name Recycling
//@{
$txt['shd_recycle_bin'] = 'Papelera de reciclaje';
$txt['shd_recycle_greeting'] = 'Esta es la papelera de reciclaje. Todos los tickets eliminados van aquí, pero los miembros del personal con permisos especiales pueden eliminar permanentemente los tickets de aquí.';
//@}

//! @name Posting
//@{
$txt['shd_create_ticket'] = 'Crear ticket';
$txt['shd_edit_ticket'] = 'Editar ticket';
$txt['shd_edit_ticket_linktree'] = 'Editar ticket (%s)';
$txt['shd_ticket_subject'] = 'Asunto del ticket';
$txt['shd_ticket_proxy'] = 'Publicar en nombre de';
$txt['shd_ticket_post_error'] = 'El siguiente problema, o problemas, ocurrió mientras se trataba de publicar este ticket';
$txt['shd_reply_ticket'] = 'Responder al ticket';
$txt['shd_reply_ticket_linktree'] = 'Responder al ticket (%s)';
$txt['shd_edit_reply_linktree'] = 'Editar respuesta (%s)';
$txt['shd_previewing_ticket'] = 'Vista previa del ticket';
$txt['shd_previewing_reply'] = 'Vista previa de respuesta a';
$txt['shd_choose_one'] = '[Elija uno]';
$txt['shd_no_value'] = '[sin valor]';
$txt['shd_ticket_dept'] = 'Departamento de tickets';
$txt['shd_select_dept'] = '-- Seleccione un departamento --';
$txt['canned_replies'] = 'Añadir una respuesta predefinida:';
$txt['canned_replies_select'] = '-- Seleccione una respuesta --';
$txt['canned_replies_insert'] = 'Insert';
//@}

//! @name Profile / trackip
//@{
$txt['shd_replies_from_ip'] = 'Respuestas de helpdesk publicadas desde IP (rango)';
$txt['shd_no_replies_from_ip'] = 'No se encontraron respuestas del helpdesk de la IP especificada (rango)';
$txt['shd_replies_from_ip_desc'] = 'A continuación se muestra una lista de todos los mensajes publicados en el helpdesk desde esta IP (rango).';
$txt['shd_is_ticket_opener'] = ' (entrada del ticket)';
//@}

//! @name Attachment types
//@{
// Archive formats
$txt['shd_attachtype_bz2'] = 'Archivo BZip2';
$txt['shd_attachtype_gz'] = 'Archivo GZip';
$txt['shd_attachtype_rar'] = 'Archivo Rar/WinRAR';
$txt['shd_attachtype_zip'] = 'Archivo Zip';
// Media: Audio formats
$txt['shd_attachtype_mp3'] = 'Archivo de audio MP3 (MPEG Layer III)';
// Media: Image formats
$txt['shd_attachtype_bmp'] = 'Imagen de mapa de bits de Windows';
$txt['shd_attachtype_gif'] = 'Imagen de Intercambio de Gráficos (GIF)';
$txt['shd_attachtype_jpeg'] = 'Imagen conjunta de grupo de expertos fotográficos (JPEG)';
$txt['shd_attachtype_jpg'] = 'Imagen conjunta de grupo de expertos fotográficos (JPEG)';
$txt['shd_attachtype_png'] = 'Imagen gráfica de red portátil (PNG)';
$txt['shd_attachtype_svg'] = 'Imagen gráfica vectorial escalable (SVG)';
// Media: Video formats
$txt['shd_attachtype_wmv'] = 'Película de vídeo de Windows Media';
// Office formats
$txt['shd_attachtype_doc'] = 'Documento Microsoft Word';
$txt['shd_attachtype_mdb'] = 'Base de datos de Microsoft Access';
$txt['shd_attachtype_ppt'] = 'Presentación de Microsoft Powerpoint';
$txt['shd_attachtype_xls'] = 'Microsoft Excel spreadsheet';
// Programming languages
$txt['shd_attachtype_cpp'] = 'Archivo fuente C++';
$txt['shd_attachtype_php'] = 'Script PHP';
$txt['shd_attachtype_py'] = 'Archivo fuente de Python';
$txt['shd_attachtype_rb'] = 'Archivo fuente Ruby';
$txt['shd_attachtype_sql'] = 'Script SQL';
// Proprietory formats
$txt['shd_attachtype_kml'] = 'Google Earth (KML)';
$txt['shd_attachtype_kmz'] = 'Google Earth (archivo KML)';
$txt['shd_attachtype_pdf'] = 'Archivo de documento portable Adobe Acrobat';
$txt['shd_attachtype_psd'] = 'Documento de Adobe Photoshop';
$txt['shd_attachtype_swf'] = 'Archivo Adobe Flash';
// Miscellaneous
$txt['shd_attachtype_exe'] = 'Archivo ejecutable (Windows)';
$txt['shd_attachtype_htm'] = 'Documento de marcado hipertexto (HTML)';
$txt['shd_attachtype_html'] = 'Documento de marcado hipertexto (HTML)';
$txt['shd_attachtype_rtf'] = 'Formato de texto rico (RTF)';
$txt['shd_attachtype_txt'] = 'Texto simple';
//@}

//! @name Ticket logs
//@{
$txt['shd_ticket_log'] = 'Registro de acción del ticket';
$txt['shd_ticket_log_count_one'] = '1 entrada';
$txt['shd_ticket_log_count_more'] = '%s entradas';
$txt['shd_ticket_log_none'] = 'Este ticket no ha sufrido ningún cambio.';
$txt['shd_ticket_log_member'] = 'Miembro';
$txt['shd_ticket_log_ip'] = 'IP del miembro:';
$txt['shd_ticket_log_date'] = 'Fecha';
$txt['shd_ticket_log_action'] = 'Accin';
$txt['shd_ticket_log_full'] = 'Ir al registro de acciones completo (todos los tickets)';
//@}

//! @name Ticket relationships
//@{
$txt['shd_ticket_relationships'] = 'Tickets relacionados';
$txt['shd_ticket_create_relationship'] = 'Crear relación';
$txt['shd_ticket_delete_relationship'] = 'Eliminar relación';
$txt['shd_ticket_reltype'] = 'seleccionar tipo';
$txt['shd_ticket_reltype_linked'] = 'Vinculado a';
$txt['shd_ticket_reltype_duplicated'] = 'Duplicado de';
$txt['shd_ticket_reltype_parent'] = 'Padre de';
$txt['shd_ticket_reltype_child'] = 'Hijo de';
//@}

//! @name Custom fields in ticket
//@{
$txt['shd_ticket_additional_information'] = 'Información adicional';
$txt['shd_ticket_additional_details'] = 'Detalles adicionales';
$txt['shd_ticket_empty_field'] = 'Este campo está vacío.';
$txt['shd_ticket_empty_field_short'] = '-';
//@}

//! @name Notifications
//@{
$txt['shd_ticket_notify'] = 'Notificaciones';
$txt['shd_ticket_notify_noneprefs'] = 'Sus preferencias de usuario no cuentan para la notificación de este ticket.';
$txt['shd_ticket_notify_changeprefs'] = 'Cambiar tus preferencias';
$txt['shd_ticket_notify_because'] = 'Sus preferencias indican que se le notifican respuestas a este ticket:';
$txt['shd_ticket_notify_because_yourticket'] = 'ya que es tu ticket';
$txt['shd_ticket_notify_because_assignedyou'] = 'ya que se le ha asignado';
$txt['shd_ticket_notify_because_priorreply'] = 'como respondiste antes';
$txt['shd_ticket_notify_because_anyreply'] = 'para cualquier ticket';

$txt['shd_ticket_notify_me_always'] = 'Usted está monitoreando este ticket (y recibirá una notificación en cada respuesta)';
$txt['shd_ticket_monitor_on_note'] = 'Puede supervisar todas las respuestas a este ticket por correo electrónico independientemente de sus preferencias:';
$txt['shd_ticket_monitor_off_note'] = 'Puede desactivar el monitoreo de este ticket y utilizar sus preferencias en su lugar:';
$txt['shd_ticket_monitor_on'] = 'Activar el monitoreo';
$txt['shd_ticket_monitor_off'] = 'Desactivar el monitoreo';
$txt['shd_ticket_notify_me_never_note'] = 'Puede ignorar actualizaciones de correo electrónico para este ticket independientemente de sus preferencias:';
$txt['shd_ticket_notify_me_never'] = 'Has desactivado todas las notificaciones de este ticket.';
$txt['shd_ticket_notify_me_never_on'] = 'Desactivar notificaciones';
$txt['shd_ticket_notify_me_never_off'] = 'Activar notificaciones';
//@}

//! @name Searching
//@{
$txt['shd_search_warning_nonadmin'] = 'La herramienta de búsqueda puede no listar todos los Tickets disponibles; actualmente está siendo investigada.';
$txt['shd_search_warning_admin'] = 'La herramienta de búsqueda requiere que se reconstruya su índice. Puede lograrlo desde la opción Mantenimiento, en el área de Ayuda, en el panel de administración.';
$txt['shd_search'] = 'Buscar Tickets';
$txt['shd_search_results'] = 'Buscar Tickets - Resultados';
$txt['shd_search_text'] = 'Palabras que estás buscando:';
$txt['shd_search_match'] = '¿Qué debe coincidirse?';
$txt['shd_search_match_all'] = 'Coincidir todas las palabras suministradas';
$txt['shd_search_match_any'] = 'Coincide con cualquier palabra suministrada';
$txt['shd_search_scope'] = 'Incluye qué tipos de tickets:';
$txt['shd_search_scope_open'] = 'Tickets abiertos';
$txt['shd_search_scope_closed'] = 'Tickets cerrados';
$txt['shd_search_scope_recycle'] = 'Elementos en la papelera de reciclaje';
$txt['shd_search_result_ticket'] = 'Incidencia %1$s';
$txt['shd_search_result_reply'] = 'Responder al ticket %1$s';
$txt['shd_search_last_updated'] = 'Última actualización:';
$txt['shd_search_ticket_opened_by'] = 'Ticket abierto por:';
$txt['shd_search_ticket_replied_by'] = 'Ticket contestado por:';
$txt['shd_search_dept'] = 'Buscar en qué departamento(s)';

$txt['shd_search_urgency'] = 'Incluye qué niveles de urgencia:';

$txt['shd_search_where'] = 'Qué elementos buscar:';
$txt['shd_search_where_tickets'] = 'Los cuerpos de los tickets';
$txt['shd_search_where_replies'] = 'Las respuestas en tickets';
$txt['shd_search_where_subjects'] = 'Asunto del ticket';

$txt['shd_search_ticket_starter'] = 'Tickets iniciados por:';
$txt['shd_search_ticket_assignee'] = 'Tickets asignados a:';
$txt['shd_search_ticket_named_person'] = 'Escriba el nombre de la persona que le interesa.';

$txt['shd_search_no_results'] = 'No se han encontrado resultados con los criterios dados. Es posible que desee volver atrás e intentar modificar sus criterios de búsqueda.';
$txt['shd_search_criteria'] = 'Criterios de búsqueda:';
$txt['shd_search_excluded'] = 'Si todas las opciones posibles fueron seleccionadas, no se ha incluido en lo anterior (p. ej. si todos los posibles niveles de urgencia fueron marcados, no se indica arriba, así que puede concentrarse en lo que es específico para su búsqueda)';
//@}