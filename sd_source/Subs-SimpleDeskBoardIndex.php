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
# File Info: Subs-SimpleDeskBoardIndex.php                    #
###############################################################

/**
 *	This file deals with changes for the board index for board integration.
 *
 *	@package subs
 *	@since 2.0
 */

if (!defined('SMF'))
	die('Hacking attempt...');

function shd_add_to_boardindex($boardIndexOptions, &$categories)
{
	global $context, $modSettings, $smcFunc, $board, $txt, $scripturl, $settings, $options;

	// Does the category exist? If it has no boards, it actually might not exist, daft as it sounds.
	// But it's more tricky than that, too! We need to be at the board index, not in a child board.
	if (!empty($board))
		return;

	// Is this active?
	if (empty($modSettings['helpdesk_active']) || !empty($modSettings['shd_disable_boardint']) || !shd_allowed_to('access_helpdesk'))
		return;

	call_integration_hook('shd_hook_boardindex_before', array(&$boardIndexOptions, &$categories));

	// OK, so what helpdesks are we displaying?
	$depts = shd_allowed_to('access_helpdesk', false);
	if (empty($depts))
		return;

	$cat_list = array();
	$query = $smcFunc['db_query']('', '
		SELECT id_dept, dept_name, description, board_cat, before_after
		FROM {db_prefix}helpdesk_depts
		WHERE id_dept IN ({array_int:depts})
		ORDER BY before_after DESC, dept_order',
		array(
			'depts' => $depts,
		)
	);
	$depts = array_flip($depts);
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		if ($row['board_cat'] == 0)
		{
			unset($depts[$row['id_dept']]);
			continue;
		}

		$depts[$row['id_dept']] = $row;
		$cat_list[] = $row['board_cat'];
		$context['dept_list'][$row['id_dept']] = array(
			'id_dept' => $row['id_dept'],
			'dept_name' => $row['dept_name'],
			'dept_desc' => $row['description'],
			'tickets' => array(
				'open' => 0,
				'closed' => 0,
				'assigned' => 0,
			),
			'new' => false,
		);
	}
	if (empty($context['dept_list']))
		return;

	$cat_list = array_unique($cat_list);

	// Do we have all these categories?
	foreach ($cat_list as $k => $v)
		if (!empty($categories[$v]))
			unset($cat_list[$k]);

	if (!empty($cat_list))
	{
		// Uh oh, we have to load a category or two.
		$new_cats = array();
		$request = $smcFunc['db_query']('', '
			SELECT c.id_cat, c.name, c.can_collapse
			FROM {db_prefix}categories AS c
			WHERE c.id_cat IN ({array_int:cat})',
			array(
				'cat' => $cat_list,
				'current_member' => $context['user']['id'],
			)
		);
		while ($this_cat = $smcFunc['db_fetch_assoc']($request))
		{
			$this_cat['is_collapsed'] = isset($this_cat['can_collapse']) && $this_cat['can_collapse'] == 1 && !empty($options['collapse_category_' . $this_cat['id_cat']]);

			$new_cats[$this_cat['id_cat']] = array(
				'id' => $this_cat['id_cat'],
				'name' => $this_cat['name'],
				'is_collapsed' => isset($this_cat['can_collapse']) && $this_cat['can_collapse'] == 1 && $this_cat['is_collapsed'] > 0,
				'can_collapse' => isset($this_cat['can_collapse']) && $this_cat['can_collapse'] == 1,
				'collapse_href' => isset($this_cat['can_collapse']) ? $scripturl . '?action=collapse;c=' . $this_cat['id_cat'] . ';sa=' . ($this_cat['is_collapsed'] > 0 ? 'expand;' : 'collapse;') . $context['session_var'] . '=' . $context['session_id'] . '#c' . $this_cat['id_cat'] : '',
				'collapse_image' => isset($this_cat['can_collapse']) ? '<img src="' . $settings['images_url'] . '/' . ($this_cat['is_collapsed'] > 0 ? 'expand.png" alt="+"' : 'collapse.png" alt="-"') . '>' : '',
				'href' => $scripturl . '#c' . $this_cat['id_cat'],
				'boards' => array(),
				'new' => false,
			);
			$new_cats[$this_cat['id_cat']]['link'] = '<a id="c' . $this_cat['id_cat'] . '" href="' . (isset($this_cat['can_collapse']) ? $new_cats[$this_cat['id_cat']]['collapse_href'] : $new_cats[$this_cat['id_cat']]['href']) . '">' . $this_cat['name'] . '</a>';
		}
		$smcFunc['db_free_result']($request);

		// So, did we add any new categories? If we didn't, something's wrong - abort safely NOW.
		if (empty($new_cats))
			return;

		// OK, so we have some categories to integrate.
		$old_cats = $categories;
		$categories = array();

		$request = $smcFunc['db_query']('', '
			SELECT id_cat
			FROM {db_prefix}categories
			ORDER BY cat_order');
		while ($row = $smcFunc['db_fetch_assoc']($request))
		{
			if (isset($old_cats[$row['id_cat']]))
				$categories[$row['id_cat']] = $old_cats[$row['id_cat']];
			elseif (isset($new_cats[$row['id_cat']]))
				$categories[$row['id_cat']] = $new_cats[$row['id_cat']];
		}
		$smcFunc['db_free_result']($request);
	}

	// So, OK, the categories exist. Now we need to create our magic boards, and integrate them.
	// First we do the after's, in order.
	foreach ($depts as $dept)
	{
		if (empty($dept['before_after']))
			continue;
		$dept['link'] = count($depts) != 0 ? ';dept=' . $dept['id_dept'] : '';
		$new_board = shd_dept_board($dept);

		$categories[$dept['board_cat']]['boards'][$new_board['id']] = $new_board;
	}

	// OK, now for the before's. Because we're merging, that means we're doing them last-first.
	$depts = array_reverse($depts);
	foreach ($depts as $dept)
	{
		if (!empty($dept['before_after']))
			continue;
		$dept['link'] = count($depts) != 0 ? ';dept=' . $dept['id_dept'] : '';
		$new_board = shd_dept_board($dept);

		$categories[$dept['board_cat']]['boards'] = array_merge(
			array($new_board['id'] => $new_board),
			$categories[$dept['board_cat']]['boards']
		);
	}

	// Last but not least, fix up the replacements and some figuring out.
	shd_get_ticket_counts();
	shd_get_unread_departments();

	if (empty($context['shd_buffer_preg_replacements']))
		$context['shd_buffer_preg_replacements'] = array();

	foreach ($context['dept_list'] as $dept => $dept_details)
	{
		// Inject the count of tickets.
		$dept_id = '~' . preg_quote(comma_format(-$dept), '~') . '\s+' . preg_quote($txt['redirects'], '~') . '~';
		$context['shd_buffer_preg_replacements'][$dept_id] = $dept_details['tickets']['open'] . ' ' . ($dept_details['tickets']['open'] == 1 ? $txt['shd_open_ticket'] : $txt['shd_open_tickets']);
	}

	// Call the relevant function via hook.
	add_integration_function('shd_hook_buffer', 'shd_buffer_boardindex', false);
	call_integration_hook('shd_hook_boardindex_after', array(&$categories));
}

function shd_dept_board($dept)
{
	global $txt, $scripturl, $context;

	// Templates we may need.
	loadTemplate('sd_template/SimpleDesk-BoardIndex');

	return array(
		'id' => 'shd' . $dept['id_dept'],
		'type' => 'shd',
		'shd' => true,
		'name' => $dept['dept_name'],
		'description' => $dept['description'],
		'new' => false, // Even if we actually have something new, for the purposes of things, this is a redirect board, which cannot have new things.
		'children_new' => false,
		'topics' => 0,
		'posts' => -$dept['id_dept'],
		'is_redirect' => true,
		'unapproved_topics' => 0,
		'unapproved_posts' => 0,
		'can_approve_posts' => false,
		'href' => $scripturl . '?' . $context['shd_home'] . $dept['link'],
		'link' => '<a href="' . $scripturl . '?' . $context['shd_home'] . $dept['link'] . '">' . $dept['dept_name'] . '</a>',
		'last_post' => array(
			'id' => 0,
			'time' => $txt['not_applicable'],
			'timestamp' => forum_time(true, 0),
			'subject' => '',
			'member' => array(
				'id' => 0,
				'username' => $txt['not_applicable'],
				'name' => '',
				'href' => '',
				'link' => $txt['not_applicable'],
			),
			'start' => 'msg0',
			'topic' => 0,
			'href' => '',
			'link' => $txt['not_applicable'],
		),
		'board_class' => 'helpdesk',
	);
}

function shd_get_ticket_counts()
{
	global $txt, $context, $smcFunc;

	if (empty($context['dept_list']))
		return;

	$query = shd_db_query('', '
		SELECT id_dept, status, COUNT(status) AS tickets
		FROM {db_prefix}helpdesk_tickets AS hdt
		WHERE {query_see_ticket}
			AND id_dept IN ({array_int:depts})
			AND status != {int:deleted}
		GROUP BY id_dept, status',
		array(
			'depts' => array_keys($context['dept_list']),
			'deleted' => TICKET_STATUS_DELETED,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
		$context['dept_list'][$row['id_dept']]['tickets'][$row['status'] == TICKET_STATUS_CLOSED ? 'closed' : 'open'] += $row['tickets'];
}

function shd_buffer_boardindex(&$buffer)
{
	global $settings, $context;

	// Fix the icon. This is surprisingly complex: we have to find the link that links to this department, then find the image inside it and proceed to rewrite only that link.
	if (preg_match_all('~<a[^>]+href="[^"]+dept[=,](\d+)/?"[^>]*>\s+<img.+src="([^"]+redirect\.(png|gif|jpg|jpeg))".+>\s+</a>~isU', $buffer, $matches, PREG_SET_ORDER))
	{
		// So, $matches is an array of matches, and each item is an array of data:
		// [0] is the entire block of HTML in the source, which is useful in a minute.
		// [1] is the department number.
		// [2] is the image URL.
		// [3] is the image extension.
		$buffer_search = array();
		$buffer_replace = array();
		foreach ($matches as $dept_match)
		{
			$state = $context['dept_list'][$dept_match[1]]['new'] ? 'on' : 'off';
			if (file_exists($settings['theme_dir'] . '/icons/shd' . $dept_match[1] . '/on.png'))
				$icon = $settings['theme_url'] . '/icons/shd' . $dept_match[1] . '/' . $state . '.png';
			else
				$icon = $settings['default_theme_url'] . '/images/simpledesk/helpdesk_' . $state . '.png';
			$buffer_search[] = $dept_match[0];
			$buffer_replace[] = str_replace($dept_match[2], $icon, $dept_match[0]);
		}
		$buffer = str_replace($buffer_search, $buffer_replace, $buffer);
	}
}

function shd_get_unread_departments()
{
	global $context, $smcFunc;

	$query = shd_db_query('', '
		SELECT hdd.id_dept, MAX(hdt.id_last_msg) AS last_msg, MAX(hdlr.id_msg) AS last_read
		FROM {db_prefix}helpdesk_depts AS hdd
			INNER JOIN {db_prefix}helpdesk_tickets AS hdt ON (hdd.id_dept = hdt.id_dept)
			LEFT JOIN {db_prefix}helpdesk_log_read AS hdlr ON (hdt.id_ticket = hdlr.id_ticket AND hdlr.id_member = {int:user_id})
		WHERE hdd.id_dept IN ({array_int:dept_list})
			AND {query_see_ticket}
			AND hdt.last_updated > {int:the_last_week}
		GROUP BY hdd.id_dept',
		array(
			'dept_list' => array_keys($context['dept_list']),
			'the_last_week' => time() - (86400 * 7),
			'user_id' => $context['user']['id'],
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($query))
	{
		$row['last_read'] = (int) $row['last_read'];
		if ($row['last_msg'] > $row['last_read'])
			$context['dept_list'][$row['id_dept']]['new'] = true;
	}
}