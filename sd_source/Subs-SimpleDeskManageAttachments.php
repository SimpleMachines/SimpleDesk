<?php
###############################################################
#          Simple Desk Project - www.simpledesk.net           #
###############################################################
#       An advanced help desk modification built on SMF       #
###############################################################
#                                                             #
#         * Copyright 2018 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 2.1 Beta 1                              #
# File Info: Subs-SimpleDeskManageAttachments.php             #
###############################################################

/**
 *	This file deals with some of the items required by the helpdesk, but are primarily supporting
 *	functions; they're not the principle functions that drive the admin attachments area.
 *
 *	@package subs
 *	@since 2.1
 */

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	SMF tells us which attachments with no messages that it wants to fix.
 *  We check to see if that is a helpdesk attachment, if it is, we remove it.
 *
 *	@param array &$ignore_ids The ids to ignore.
 *	@param array &$min_substep The miniumn id we are looking for.
 *	@param array &$max_substep The max id we are looking for.
 *	@since 2.1
*/
function shd_repair_attachments_nomsg(&$ignore_ids, $min_substep, $max_substep)
{
	global $smcFunc;

	$request = $smcFunc['db_query']('', '
		SELECT a.id_attach
		FROM {db_prefix}attachments AS a
			LEFT JOIN {db_prefix}helpdesk_attachments AS hda ON (hda.id_attach = a.id_attach)
			LEFT JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hdtr.id_msg = hda.id_msg)
		WHERE a.id_attach BETWEEN {int:substep} AND {int:max_substep} + 499
			AND a.id_member = {int:no_member}
			AND a.id_msg != {int:no_msg}
			AND hdtr.id_msg IS NOT NULL',
		array(
			'no_member' => 0,
			'no_msg' => 0,
			'substep' => $min_substep,
			'max_substep' => $min_substep >= $max_substep ? $min_substep + 499 : $max_substep,
			'ignore_ids' => $ignore_ids,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$ignore_ids[] = $row['id_attach'];
	$smcFunc['db_free_result']($request);
}

/**
 *	If we are deleting an attachment, check if we should handle this.
 *
 *	@since 2.1
 *	@param array &$filesRemoved The files we removed.
 *	@param array &$attachments Attachments we should check to see if we can remove them.
*/
function shd_attachment_remove(&$filesRemoved, $attachments)
{
	if (in_array($_REQUEST['type'], array('shd_attach', 'shd_thumb')) && !empty($attachments))
		$idsRemoved = removeAttachments(array('id_attach' => $attachments), '', true);
	$filesRemoved = array_merge($filesRemoved, $idsRemoved);
}

/**
 *	We check to see if we need to do anything to tell SMF about our attachments.
 *
 *	@since 2.1
 *	@param array &$listOptions The listOptions of attachments page.
 *	@param array &$titles All the sections we have.
 *	@param array &$list_title List title.
*/
function shd_attachments_browse(&$listOptions, &$titles, &$list_title)
{
	global $modSettings, $context, $txt, $settings, $scripturl;

	if (empty($modSettings['helpdesk_active']))
		return;
	elseif (isset($_REQUEST['shd_attach']) || isset($_REQUEST['shd_thumb']))
		$context['browse_type'] = isset($_REQUEST['shd_attach']) ? 'shd_attach' : 'shd_thumb';

	$titles += array(
		'shd_attach' => array('?action=admin;area=manageattachments;sa=browse;shd_attach', $txt['attachment_manager_shd_attach']),
		'shd_thumb' => array('?action=admin;area=manageattachments;sa=browse;shd_thumb', $txt['attachment_manager_shd_thumb']),
	);

	// We rebuild this as its easier to fix.
	$list_title = '';
	foreach ($titles as $browse_type => $details)
	{
		if ($browse_type != 'attachments')
			$list_title .= ' | ';

		if ($context['browse_type'] == $browse_type)
			$list_title .= '<img src="' . $settings['images_url'] . '/selected.png" alt="&gt;"> ';

		$list_title .= '<a href="' . $scripturl . $details[0] . '">' . $details[1] . '</a>';
	}

	// We're actually wanting helpdesk only stuff, so do it and bail
	if (isset($_REQUEST['shd_attach']) || isset($_REQUEST['shd_thumb']))
		$listOptions = shd_admin_browse_attachments($list_title);
}

/**
 *	Builds a SMF list of attachments.
 *
 *	@param string $list_title A list title, if none is specified we default to the either a generic title.
 *
 *	@return array List option data to be passed to createList.
 *	@since 2.1
*/
function shd_admin_browse_attachments($list_title = '')
{
	global $context, $txt, $scripturl, $options, $modSettings;
	global $smcFunc, $sourcedir;

	$context['browse_type'] = isset($_REQUEST['shd_attach']) ? 'shd_attach' : 'shd_thumb';

	// Set the options for the list component.
	$listOptions = array(
		'id' => 'file_list',
		'title' => !empty($list_title) ? $list_title : $txt['attachment_manager_' . $context['browse_type']],
		'items_per_page' => $modSettings['defaultMaxMessages'],
		'base_href' => $scripturl . '?action=admin;area=manageattachments;sa=browse;' . $context['browse_type'],
		'default_sort_col' => 'name',
		'no_items_label' => $txt['attachment_manager_' . $context['browse_type'] . '_no_entries'],
		'get_items' => array(
			'function' => 'shd_list_get_files',
			'params' => array(
				$context['browse_type'],
			),
		),
		'get_count' => array(
			'function' => 'shd_list_get_num_files',
			'params' => array(
				$context['browse_type'],
			),
		),
		'columns' => array(
			'name' => array(
				'header' => array(
					'value' => $txt['attachment_name'],
				),
				'data' => array(
					'function' => function($rowData)
					{
						global $modSettings, $context, $scripturl;

						$link = '<a href="';
						$link .= sprintf('%1$s?action=dlattach;ticket=%2$d.0;id=%3$d', $scripturl, $rowData['id_ticket'], $rowData['id_attach']);
						$link .= '"';

						// Show a popup on click if it\'s a picture and we know its dimensions.
						if (!empty($rowData['width']) && !empty($rowData['height']))
							$link .= sprintf(' onclick="return reqWin(this.href + \';image\', %1$d, %2$d, true);"', $rowData['width'] + 20, $rowData['height'] + 20);

						$link .= sprintf('>%1$s</a>', preg_replace('~&amp;#(\d{1,7}|x[0-9a-fA-F]{1,6});~', '&#\1;', htmlspecialchars($rowData['filename'])));

						// Show the dimensions.
						if (!empty($rowData['width']) && !empty($rowData['height']))
							$link .= sprintf(' <span class="smalltext">%1$dx%2$d</span>', $rowData['width'], $rowData['height']);

						return $link;
					},
				),
				'sort' => array(
					'default' => 'a.filename',
					'reverse' => 'a.filename DESC',
				),
			),
			'filesize' => array(
				'header' => array(
					'value' => $txt['attachment_file_size'],
				),
				'data' => array(
					'function' => function($rowData)
					{
						global $txt;
						return sprintf('%1$s%2$s', round($rowData['size'] / 1024, 2), $txt['kilobyte']);
					},
					'class' => 'windowbg',
				),
				'sort' => array(
					'default' => 'a.size',
					'reverse' => 'a.size DESC',
				),
			),
			'member' => array(
				'header' => array(
					'value' => $txt['posted_by'],
				),
				'data' => array(
					'function' => function($rowData)
					{
						return htmlspecialchars($rowData['poster_name']);
					},
				),
				'sort' => array(
					'default' => 'mem.real_name',
					'reverse' => 'mem.real_name DESC',
				),
			),
			'date' => array(
				'header' => array(
					'value' => $txt['date'],
				),
				'data' => array(
					'function' => function($rowData)
					{
						global $txt;
						return empty($rowData['poster_time']) ? $txt['never'] : timeformat($rowData['poster_time']);
					},
					'class' => 'windowbg',
				),
				'sort' => array(
					'default' => 'hdtr.id_msg',
					'reverse' => 'hdtr.id_msg DESC',
				),
			),
			'downloads' => array(
				'header' => array(
					'value' => $txt['downloads'],
				),
				'data' => array(
					'function' => function($rowData)
					{
						return comma_format($rowData['downloads']);
					},
					'class' => 'windowbg',
				),
				'sort' => array(
					'default' => 'a.downloads',
					'reverse' => 'a.downloads DESC',
				),
			),
			'check' => array(
				'header' => array(
					'value' => '<input type="checkbox" onclick="invertAll(this, this.form);" >',
				),
				'data' => array(
					'sprintf' => array(
						'format' => '<input type="checkbox" name="remove[%1$d]" >',
						'params' => array(
							'id_attach' => false,
						),
					),
					'style' => 'text-align: center',
				),
			),
		),
		'form' => array(
			'href' => $scripturl . '?action=admin;area=manageattachments;sa=remove;' . $context['browse_type'],
			'include_sort' => true,
			'include_start' => true,
			'hidden_fields' => array(
				'type' => $context['browse_type'],
			),
		),
		'additional_rows' => array(
			array(
				'position' => 'below_table_data',
				'value' => '<input type="submit" name="remove_submit" class="button" value="' . $txt['quickmod_delete_selected'] . '" onclick="return confirm(\'' . $txt['confirm_delete_attachments'] . '\');">',
				'class' => 'titlebg',
				'style' => 'text-align: right;',
			),
		),
	);

	return $listOptions;
}

/**
 *	Retrieves the total number of attachments.
 *
 *	@param int $start The starting position in the query.
 *	@param int $items_per_page The number of attachments per page to show.
 *	@param string $sort A valid sort action as determined by our main function
 *	@param string $browse_type shd_thumb if a thumbnail otherwise shd_attach.
 *
 *	@return array Attachment data.
 *	@since 2.1
 *	@see shd_admin_browse_attachments
*/
function shd_list_get_files($start, $items_per_page, $sort, $browse_type)
{
	global $smcFunc, $txt;

	$request = $smcFunc['db_query']('', '
		SELECT
			hdtr.id_msg, COALESCE(mem.real_name, hdtr.poster_name) AS poster_name, hdtr.poster_time, hdt.id_ticket, hdtr.id_member,
			a.id_attach, a.filename, a.file_hash, a.attachment_type, a.size, a.width, a.height, a.downloads, hdt.subject
		FROM {db_prefix}attachments AS a
			INNER JOIN {db_prefix}helpdesk_attachments AS hda ON (a.id_attach = hda.id_attach)
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hda.id_ticket = hdt.id_ticket)
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hda.id_msg = hdtr.id_msg)
			LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = hdtr.id_member)
		WHERE a.attachment_type = {int:attachment_type}
		ORDER BY {raw:sort}
		LIMIT {int:start}, {int:per_page}',
		array(
			'attachment_type' => $browse_type === 'shd_thumb' ? '3' : '0',
			'sort' => $sort,
			'start' => $start,
			'per_page' => $items_per_page,
		)
	);
	$files = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$files[] = $row;
	$smcFunc['db_free_result']($request);

	return $files;
}

/**
 *	Retrieves the total number of attachments.
 *
 *	@param string $browse_type shd_thumb if a thumbnail otherwise shd_attach.
 *
 *	@return int Number of attachments possible.
 *	@since 2.1
 *	@see shd_admin_browse_attachments
*/
function shd_list_get_num_files($browse_type)
{
	global $smcFunc;

	$request = $smcFunc['db_query']('', '
		SELECT COUNT(*) AS num_attach
		FROM {db_prefix}attachments AS a
			INNER JOIN {db_prefix}helpdesk_attachments AS hda ON (a.id_attach = hda.id_attach)
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hda.id_ticket = hdt.id_ticket)
			INNER JOIN {db_prefix}helpdesk_ticket_replies AS hdtr ON (hda.id_msg = hdtr.id_msg)
		WHERE a.attachment_type = {int:attachment_type}
			AND a.id_member = {int:guest_id_member}',
		array(
			'attachment_type' => $browse_type === 'shd_thumb' ? '3' : '0',
			'guest_id_member' => 0,
		)
	);
	list ($num_files) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	return $num_files;
}