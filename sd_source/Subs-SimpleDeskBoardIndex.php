<?php
###############################################################
#         Simple Desk Project - www.simpledesk.net            #
###############################################################
#       An advanced help desk modifcation built on SMF        #
###############################################################
#                                                             #
#         * Copyright 2010 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 1.0 Felidae                             #
# File Info: Subs-SimpleDeskBoardIndex.php / 1.0 Felidae      #
###############################################################

/**
 *	This file deals with changes for the board index for board integration.
 *
 *	@package subs
 *	@since 1.1
 */

if (!defined('SMF'))
	die('Hacking attempt...');

function shd_add_to_boardindex(&$boardIndexOptions, &$categories)
{
	global $context, $modSettings, $smcFunc, $board, $txt, $scripturl, $settings;

	// Does the category exist? If it has no boards, it actually might not exist, daft as it sounds.
	// But it's more tricky than that, too! We need to be at the board index, not in a child board.
	if (!empty($board))
		return;

	if (empty($categories[$modSettings['shd_boardindex_cat']]))
	{
		// OK, so the category is otherwise empty and devoid of boards (since the lookup gets boards first) - go get it.
		$request = $smcFunc['db_query']('', '
			SELECT c.id_cat, c.name, c.can_collapse, IFNULL(cc.id_member, 0) AS is_collapsed
			FROM {db_prefix}categories AS c
				LEFT JOIN {db_prefix}collapsed_categories AS cc ON (cc.id_cat = c.id_cat AND cc.id_member = {int:current_member})
			WHERE c.id_cat = {int:cat}',
			array(
				'cat' => $modSettings['shd_boardindex_cat'],
				'current_member' => $context['user']['id'],
			)
		);
		if ($smcFunc['db_num_rows']($request) == 0)
		{
			// Uh oh. We didn't find the category, bye then.
			$smcFunc['db_free_result']($request);
			return;
		}
		$this_cat = $smcFunc['db_fetch_assoc']($request);
		$smcFunc['db_free_result']($request);

		// OK, so let's create the category.
		$old_categories = $categories;
		$old_categories[$this_cat['id_cat']] = array(
			'id' => $this_cat['id_cat'],
			'name' => $this_cat['name'],
			'is_collapsed' => isset($this_cat['can_collapse']) && $this_cat['can_collapse'] == 1 && $this_cat['is_collapsed'] > 0,
			'can_collapse' => isset($this_cat['can_collapse']) && $this_cat['can_collapse'] == 1,
			'collapse_href' => isset($this_cat['can_collapse']) ? $scripturl . '?action=collapse;c=' . $this_cat['id_cat'] . ';sa=' . ($this_cat['is_collapsed'] > 0 ? 'expand;' : 'collapse;') . $context['session_var'] . '=' . $context['session_id'] . '#c' . $this_cat['id_cat'] : '',
			'collapse_image' => isset($this_cat['can_collapse']) ? '<img src="' . $settings['images_url'] . '/' . ($this_cat['is_collapsed'] > 0 ? 'expand.gif" alt="+"' : 'collapse.gif" alt="-"') . ' />' : '',
			'href' => $scripturl . '#c' . $this_cat['id_cat'],
			'boards' => array(),
			'new' => false
		);
		$old_categories[$this_cat['id_cat']]['link'] = '<a id="c' . $this_cat['id_cat'] . '" href="' . (isset($this_cat['can_collapse']) ? $old_categories[$this_cat['id_cat']]['collapse_href'] : $old_categories[$this_cat['id_cat']]['href']) . '">' . $this_cat['name'] . '</a>';
		$categories = array();

		// Now get the order of categories.
		$cat_order = array();
		$request = $smcFunc['db_query']('', '
			SELECT id_cat
			FROM {db_prefix}categories
			ORDER BY cat_order');
		while ($row = $smcFunc['db_fetch_assoc']($request))
			$cat_order[] = $row['id_cat'];
		$smcFunc['db_free_result']($request);

		foreach ($cat_order as $cat)
			if (isset($old_categories[$cat]))
				$categories[$cat] = $old_categories[$cat];
	}

	// So, OK, the category exists. Now we need to create our magic board, and implant it.
	$new_board = array(
		'id' => 'shd',
		'name' => $txt['shd_helpdesk'],
		'description' => '',
		'new' => false,
		'children_new' => false,
		'topics' => 0,
		'posts' => -1, // !!! This will later be the number of department
		'is_redirect' => true,
		'unapproved_topics' => 0,
		'unapproved_posts' => 0,
		'can_approve_posts' => false,
		'href' => $scripturl . '?action=helpdesk;sa=main',
		'link' => '<a href="' . $scripturl . '?action=helpdesk;sa=main">' . $txt['shd_helpdesk'] . '</a>',
	);

	if (empty($modSettings['shd_boardindex_cat_where']) || $modSettings['shd_boardindex_cat_where'] == 'before')
	{
		// Positioning it in the category before all the boards
		$categories[$modSettings['shd_boardindex_cat']]['boards'] = array_merge(
			array($new_board['id'] => $new_board),
			$categories[$modSettings['shd_boardindex_cat']]['boards']
		);
	}
	else
	{
		// Positioning it in the category after all the boards
		$categories[$modSettings['shd_boardindex_cat']]['boards'][$new_board['id']] = $new_board;
	}

	$open_tickets = shd_count_helpdesk_tickets('open');
	if (empty($context['shd_buffer_preg_replacements']))
		$context['shd_buffer_preg_replacements'] = array();
	$context['shd_buffer_preg_replacements'] += array(
		'~\-1\s+' . preg_quote($txt['redirects'], '~') . '~i' => $open_tickets . ' ' . ($open_tickets == 1 ? $txt['shd_open_ticket'] : $txt['shd_open_tickets']),
	);
}

?>