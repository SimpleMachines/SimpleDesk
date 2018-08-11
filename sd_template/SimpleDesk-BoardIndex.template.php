<?php
// Version: 2.1; SimpleDesk front page template

/**
 *	This file handles displaying the blocks of tickets for the front page, as well as the slightly
 *	customised views for the recycle bin and the list of resolved tickets.
 *
 *	@package template
 *	@since 2.1
*/

/**
 *	Board Index Integration for SimpleDesk Icons.
 *
 *	@param array $board Current board information.
 *	@since 2.1
*/
function template_bi_shd_icon($board)
{
	global $context, $scripturl;

	echo '
						<a href="', ($context['user']['is_guest'] ? $board['href'] : $board['href']), '" class="board_', $board['board_class'], '"', !empty($board['board_tooltip']) ? ' title="' . $board['board_tooltip'] . '"' : '', '></a>';
}

/**
 *	Board Index Integration for SimpleDesk Stats.
 *
 *	@param array $board Current board information.
 *	@since 2.1
 */
function template_bi_shd_stats($board)
{
}