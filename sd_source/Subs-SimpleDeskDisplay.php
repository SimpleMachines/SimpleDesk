<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2021 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1 RC1                                 *
* File Info: Subs-SimpleDeskDisplay.php                       *
**************************************************************/

/**
 *	This file deals with changes for the display for integration.
 *
 *	@package subs
 *	@since 2.0
 */
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Looks to see if an attachment is from the helpdesk, if so we validate it and return a proper request. SMF will handle the rest.
 *
 *	@param string &$attachRequest A resource handle.
 *
 *	@since 2.0
*/
function shd_download_request(&$attachRequest)
{
	global $smcFunc;

	// Is this already a resource?  Then another hook has claimed the attachment as theirs.
	if (!empty($attachRequest) && is_resource($attachRequest) && empty($_REQUEST['ticket']))
		return;
	// If we don't have a ticket present, it is not our attachment.
	elseif (empty($_REQUEST['ticket']))
		return;

	$_REQUEST['ticket'] = (int) $_REQUEST['ticket'];
	// First we check that we can see said ticket and figure out what department we're in.
	$request = shd_db_query('', '
		SELECT hdt.id_dept
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE id_ticket = {int:ticket}
			AND {query_see_ticket}',
		array(
			'ticket' => $_REQUEST['ticket'],
		)
	);

	// If there's a row, we need to process it and then issue the follow on query. If not, fall through to the next cut-off point, outside of this edit.
	if ($smcFunc['db_num_rows']($request) != 0)
	{
		list($dept) = $smcFunc['db_fetch_row']($request);
		$smcFunc['db_free_result']($request);

		// Now check their permission. If they don't have permission to view in this department, bye.
		shd_is_allowed_to('shd_view_attachment', $dept);

		// Make sure the attachment is on this ticket, note right now we're forcing it to be "approved"
		$attachRequest = shd_db_query('', '
			SELECT a.id_folder, a.filename, a.file_hash, a.fileext, a.id_attach, a.attachment_type, a.mime_type, 1 AS approved, hdtr.id_member
			FROM {db_prefix}attachments AS a
				INNER JOIN {db_prefix}helpdesk_attachments AS hda ON (a.id_attach = hda.id_attach)
				INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hda.id_msg = hdtr.id_msg)
				INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdtr.id_ticket = hdt.id_ticket)
			WHERE a.id_attach = {int:attach}
				AND hdt.id_ticket = {int:ticket}
			LIMIT 1',
			array(
				'attach' => $_REQUEST['attach'],
				'ticket' => (int) $_REQUEST['ticket'],
			)
		);
	}
}