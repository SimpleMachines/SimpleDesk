<?php
// Version: 2.1; SimpleDesk front page template

/**
 *	This file handles displaying the blocks of tickets for the front page, as well as the slightly
 *	customised views for the recycle bin and the list of resolved tickets.
 *
 *	@package template
 *	@since 1.0
*/

/**
 *	Display the main helpdesk view of active tickets.
 *
 *	This function steps through the blocks defined in SimpleDesk.php to display all the blocks that potentially would be visible, noting whether blocks have been collapsed or not, and calling to the sub-subtemplates to output collapsed and noncollapsed blocks.
 *
 *	All the blocks here are defined in {@link shd_main_helpdesk()} (or {@link shd_view_block()} if viewing a single block) and data gathered in {@link shd_helpdesk_listing()}.
 *
 *	@see template_collapsed_ticket_block()
 *	@see template_ticket_block()
 *	@since 1.0
*/
function template_main()
{
	global $context, $txt, $settings, $scripturl;

	template_shd_button_strip($context['navigation'], 'bottom');

	echo '
		<div class="title_bar">
			<h3 class="titlebg">
					', $txt['shd_helpdesk'], !empty($context['shd_dept_name']) && $context['shd_multi_dept'] ? ' - ' . $context['shd_dept_name'] : '', '
			</h3>
		</div>
		<div class="information">
			<div class="floatright smalltext">
				<form action="', $scripturl, '?action=helpdesk;sa=ticket" method="get">
					', $txt['shd_go_to_ticket'], ':
					<input type="hidden" name="action" value="helpdesk">
					<input type="hidden" name="sa" value="ticket">
					<input type="text" id="ticketJump" name="ticket" size="4">
					<input type="submit" class="button" value="', $txt['shd_go'], '" onclick="shd_quickTicketJump(this.parentNode.ticketJump.value);">
				</form>
			</div>
			<div class="floatleft">
			<span class="block">', sprintf($txt['shd_welcome'], $context['user']['name']), '</span>
				', $txt['shd_' . $context['shd_home_view'] . '_greeting'];

	if (!empty($context['shd_filter_fields']))
	{
		echo '
			<strong>', $txt['shd_category_filter'], ':</strong>';
		foreach ($context['shd_filter_fields'] as $id_field => $field)
		{
			echo '
				', $field['name'], ':';
			foreach ($field['options'] as $key => $opt)
			{
				if (!empty($context['filter_fragment']) && $_REQUEST['field'] == $id_field && $_REQUEST['filter'] == $key)
					echo ' [', $opt, ']';
				else
					echo ' [<a href="' . $context['filterbase'] . $context['shd_dept_link'] . ';field=' . $id_field . ';filter=' . $key . '">' . $opt . '</a>]';
			}
		}
	}

	echo '
			</div>
		</div>';

	// Start the ticket listing
	foreach ($context['ticket_block_order'] as $block)
	{
		// Nothing for this block.
		if (empty($context['ticket_blocks'][$block]))
			continue;

		$context['current_block'] = $block;
		if (!empty($context['ticket_blocks'][$block]['count']) && $context['ticket_blocks'][$block]['count'] > 10)
			$context['block_link'] = $context['shd_current_subaction'] == 'viewblock' ? $scripturl . '?' . $context['shd_home'] . $context['shd_dept_link'] : $scripturl . '?action=helpdesk;sa=viewblock;block=' . $block . $context['shd_dept_link'] . '#shd_block_' . $block;
		else
			$context['block_link'] = '';

		if ($context['ticket_blocks'][$block]['collapsed'])
			template_collapsed_ticket_block();
		else
			template_ticket_block();
	}

	//echo 'I\'m alive!!!!!!!!!!1111oneone'; 	- I had to save this :P
}

function template_shd_depts()
{
	global $context, $txt, $settings, $scripturl;

	template_shd_button_strip($context['navigation'], 'bottom');

	echo '
		<div class="title_bar">
			<h3 class="titlebg">
				', $txt['shd_helpdesk'], '
			</h3>
		</div>
		<div class="roundframe">
			<div class="shd_gototicket smalltext">
				<form action="', $scripturl, '?action=helpdesk;sa=ticket" method="get">
					', $txt['shd_go_to_ticket'], ':
					<input type="hidden" name="action" value="helpdesk">
					<input type="hidden" name="sa" value="ticket">
					<input type="text" id="ticketJump" name="ticket" size="4">
					<input type="submit" class="button" value="', $txt['shd_go'], '" onclick="shd_quickTicketJump(this.parentNode.ticketJump.value);">
				</form>
			</div>
			<div id="welcome">
				<strong>', sprintf($txt['shd_welcome'], $context['user']['name']), '</strong><br>
				', $txt['shd_' . $context['shd_home_view'] . '_greeting'], '
			</div>
			<div class="cat_bar">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/departments.png" alt="*">
					', $txt['shd_departments'], '
				</h3>
			</div>

			<div id="category_helpdesk" class="boardindex_table">';

	foreach ($context['dept_list'] as $dept)
	{
		$state = $context['dept_list'][$dept['id_dept']]['new'] ? 'on' : 'off';
		if (file_exists($settings['theme_dir'] . '/icons/shd' . $dept['id_dept'] . '/on.png'))
			$icon = $settings['theme_url'] . '/icons/shd' . $dept['id_dept'] . '/' . $state . '.png';
		else
			$icon = $settings['default_theme_url'] . '/images/simpledesk/helpdesk_' . $state . '.png';

		echo '
				<div id="board_shd', $dept['id_dept'], '" class="up_contain">
					<div class="board_icon">
						<img src="', $icon, '"/>
					</div>
					<div class="info">
						<a class="subject mobile_subject" href="', $scripturl, '?', $context['shd_home'], ';dept=', $dept['id_dept'], '">', $dept['dept_name'], '</a>
						<div class="board_description">', $dept['description'], '</div>
					</div>
					<div class="board_stats">
						<p>
							', $dept['tickets']['open'], ' ', $txt['shd_tickets_open'], '<br>
							', $dept['tickets']['closed'], ' ', $txt['shd_tickets_closed'], '
						</p>
					</div>
					<div class="lastpost hidden">
					</div>
				</div>';
	}

	echo '
			</div>
		</div>';
}

/**
 *	Display the helpdesk view of resolved tickets.
 *
 *	This function steps through the blocks defined in SimpleDesk.php to display all the block of closed items.
 *
 *	All the blocks here are defined in {@link shd_closed_tickets()} and data gathered in {@link shd_helpdesk_listing()}.
 *
 *	@see template_ticket_block()
 *	@since 1.0
*/
function template_closedtickets()
{
	global $context, $txt, $settings, $scripturl;

	template_shd_button_strip($context['navigation'], 'bottom');

	echo '
		<div class="title_bar">
			<h3 class="titlebg">
				', $txt['shd_helpdesk'], '
			</h3>
		</div>
		<div class="roundframe">
			<div class="shd_gototicket smalltext">
				<form action="', $scripturl, '?action=helpdesk" method="post">
					', $txt['shd_go_to_ticket'], ':
					<input type="text" name="ticket" size="4">
					<input type="submit" value="', $txt['shd_go'], '">
					<input type="hidden" name="sa" value="ticket">
				</form>
			</div>
			<div id="welcome">
				<strong>', sprintf($txt['shd_welcome'], $context['user']['name']), '</strong><br>
				', $txt['shd_closed_' . $context['shd_home_view'] . '_greeting'];

	if (!empty($context['shd_filter_fields']))
	{
		echo '
				<br><br><strong>', $txt['shd_category_filter'], ':</strong>';
		foreach ($context['shd_filter_fields'] as $id_field => $field)
		{
			echo '
				<br>', $field['name'], ':';
			foreach ($field['options'] as $key => $opt)
			{
				if (!empty($context['filter_fragment']) && $_REQUEST['field'] == $id_field && $_REQUEST['filter'] == $key)
					echo ' [', $opt, ']';
				else
					echo ' [<a href="' . $context['filterbase'] . $context['shd_dept_link'] . ';field=' . $id_field . ';filter=' . $key . '">' . $opt . '</a>]';
			}
		}
	}

	echo '
			</div>
		</div>';

	// Start the ticket listing
	$blocks = array_keys($context['ticket_blocks']);
	foreach ($blocks as $block)
	{
		$context['current_block'] = $block;
		template_ticket_block();
	}
}

/**
 *	Display the helpdesk view of recycled and partly recycled tickets.
 *
 *	This function steps through the blocks defined in SimpleDesk.php to display all the blocks that would be related; the list of deleted tickets, and the list of tickets with deleted replies in.
 *
 *	All the blocks here are defined in {@link shd_recycle_bin()} and data gathered in {@link shd_helpdesk_listing()}.
 *
 *	@see template_ticket_block()
 *	@since 1.0
*/
function template_recyclebin()
{
	global $context, $txt, $settings, $scripturl;

	template_shd_button_strip($context['navigation'], 'bottom');

	echo '
		<div class="title_bar">
			<h3 class="titlebg">
				', $txt['shd_helpdesk'], '
			</h3>
		</div>
		<div class="roundframe">
			<div class="shd_gototicket smalltext">
				<form action="', $scripturl, '?action=helpdesk" method="post">
					', $txt['shd_go_to_ticket'], ':
					<input type="text" name="ticket" size="4">
					<input type="submit" value="', $txt['shd_go'], '">
					<input type="hidden" name="sa" value="ticket">
				</form>
			</div>
			<div id="welcome">
				<strong>', sprintf($txt['shd_welcome'], $context['user']['name']), '</strong><br>
				', $txt['shd_recycle_greeting'];

	if (!empty($context['shd_filter_fields']))
	{
		echo '
				<br><br><strong>', $txt['shd_category_filter'], ':</strong>';
		foreach ($context['shd_filter_fields'] as $id_field => $field)
		{
			echo '
				<br>', $field['name'], ':';
			foreach ($field['options'] as $key => $opt)
			{
				if (!empty($context['filter_fragment']) && $_REQUEST['field'] == $id_field && $_REQUEST['filter'] == $key)
					echo ' [', $opt, ']';
				else
					echo ' [<a href="' . $context['filterbase'] . $context['shd_dept_link'] . ';field=' . $id_field . ';filter=' . $key . '">' . $opt . '</a>]';
			}
		}
	}

	echo '
			</div>
		</div>';

	// Loop through the crap... Uh, I mean the tickets! :)
	$blocks = array_keys($context['ticket_blocks']);
	foreach ($blocks as $block)
	{
		$context['current_block'] = $block;
		template_ticket_block();
	}
}

/**
 *	Display a collapsed block.
 *
 *	In the front page, you are able to force a given block to be displayed in its entirety. When that happens, the other blocks are collapsed, so that they are present but their principle content is not.
 *
 *	@see template_ticket_block()
 *	@since 1.0
*/
function template_collapsed_ticket_block()
{
	global $context, $txt, $settings, $scripturl;

	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/', $context['ticket_blocks'][$context['current_block']]['block_icon'], '" alt="*">
				', (empty($context['block_link']) ? '' : '<a href="' . $context['block_link'] . '">'), $context['ticket_blocks'][$context['current_block']]['title'], '
				<span class="smalltext">(', $context['ticket_blocks'][$context['current_block']]['count'], ' ', ($context['ticket_blocks'][$context['current_block']]['count'] == 1 ? $txt['shd_count_ticket_1'] : $txt['shd_count_tickets']), ')</span>', (empty($context['block_link']) ? '' : '</a>'), '
			</h3>
		</div>';
}

/**
 *	Display an individual, non-collapsed block.
 *
 *	Each front-page template uses this function to display a given block of tickets. It handles displaying the menu header, including ticket count, followed by all the different column types as listed in {@link shd_main_helpdesk()}, then to iterate through the ticket details to display each row (provided by {@link shd_helpdesk_listing()}.
 *
 *	@see shd_main_helpdesk()
 *	@see shd_helpdesk_listing()
 *	@since 1.0
*/
function template_ticket_block()
{
	global $context, $txt, $settings;
	// $context['ticket_blocks'] = array of arrays of ticket data
	// $context['current_block'] = the block to display now

	echo '
		<div class="cat_bar">
			<h3 id="shd_block_', $context['current_block'], '" class="catbg">
				', !empty($context['ticket_blocks'][$context['current_block']]['page_index']) ? '<span class="floatright smalltext">' . $context['ticket_blocks'][$context['current_block']]['page_index'] . '</span>' : '', '
				<img src="', $settings['default_images_url'], '/simpledesk/', $context['ticket_blocks'][$context['current_block']]['block_icon'], '" alt="*">
				', (empty($context['block_link']) ? '' : '<a href="' . $context['block_link'] . '">'), $context['ticket_blocks'][$context['current_block']]['title'], '
				<span class="smalltext">(', $context['ticket_blocks'][$context['current_block']]['count'], ' ', ($context['ticket_blocks'][$context['current_block']]['count'] == 1 ? $txt['shd_count_ticket_1'] : $txt['shd_count_tickets']), ')</span>', (empty($context['block_link']) ? '' : '</a>'), '
			</h3>
		</div>
		<table class="table_grid">
			<tr class="title_bar">';

	$block_width = 0;
	foreach ($context['ticket_blocks'][$context['current_block']]['columns'] as $column => $width)
	{
		$block_width++;
		switch ($column)
		{
			case 'ticket_id':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', ' colspan="2"><img src="', $settings['default_images_url'], '/simpledesk/ticket.png" class="shd_smallicon" alt=""> ', template_shd_menu_header('ticketid', $txt['shd_ticket']), '</td>';
				$block_width++; // is 2 blocks wide
				break;
			case 'ticket_name':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '>', template_shd_menu_header('ticketname', $txt['shd_ticket_name']), '</td>';
				break;
			case 'starting_user':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '><img src="', $settings['default_images_url'], '/simpledesk/user.png" class="shd_smallicon" alt=""> ', template_shd_menu_header('starter', $txt['shd_ticket_started_by']), '</td>';
				break;
			case 'last_reply':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '><img src="', $settings['default_images_url'], '/simpledesk/staff.png" class="shd_smallicon" alt=""> ', template_shd_menu_header('lastreply', $txt['shd_ticket_updated_by']), '</td>';
				break;
			case 'assigned':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '><img src="', $settings['default_images_url'], '/simpledesk/staff.png" class="shd_smallicon" alt=""> ', template_shd_menu_header('assigned', $txt['shd_ticket_assigned']), '</td>';
				break;
			case 'status':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '><img src="', $settings['default_images_url'], '/simpledesk/status.png" class="shd_smallicon" alt=""> ', template_shd_menu_header('status', $txt['shd_ticket_status']), '</td>';
				break;
			case 'urgency':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '><img src="', $settings['default_images_url'], '/simpledesk/urgency.png" class="shd_smallicon" alt=""> ', template_shd_menu_header('urgency', $txt['shd_ticket_urgency']), '</td>';
				break;
			case 'updated':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '><img src="', $settings['default_images_url'], '/simpledesk/time.png" class="shd_smallicon" alt=""> ', template_shd_menu_header('updated', $txt['shd_ticket_updated']), '</td>';
				break;
			case 'replies':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '>', template_shd_menu_header('replies', $txt['shd_ticket_num_replies']), '</td>';
				break;
			case 'allreplies':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '>', template_shd_menu_header('allreplies', $txt['shd_ticket_num_replies']), '</td>';
				break;
			case 'actions':
				echo '
							<td', !empty($width) ? ' width="' . $width . '%"' : '', '>', $txt['shd_actions'], '</td>';
				break;
			default:
				echo '
							<td><td>';
				break;
		}
	}

	echo '
			</tr>';

	if (empty($context['ticket_blocks'][$context['current_block']]['tickets']))
	{
		echo '
			<tr class="windowbg">
				<td colspan="', $block_width, '" class="shd_noticket">', $txt['shd_error_no_tickets'], '</td>
			</tr>';
	}
	else
	{
		foreach ($context['ticket_blocks'][$context['current_block']]['tickets'] as $ticket)
		{
			echo '
			<tr class="windowbg">';

			foreach ($context['ticket_blocks'][$context['current_block']]['columns'] as $column => $width)
			{
				switch ($column)
				{
					case 'ticket_id':
						$private_image = $ticket['private'] ? 'private.png' : 'public.png';
						$private_txt = $ticket['private'] ? $txt['shd_ticket_private'] : $txt['shd_ticket_notprivate'];
						$unread_image = $ticket['is_unread'] ? 'unread.png' : 'read.png';
						$unread_txt = $ticket['is_unread'] ? $txt['shd_ticket_new'] : $txt['shd_ticket_notnew'];
						echo '
							<td width="3%">
								<img src="', $settings['default_images_url'], '/simpledesk/', $unread_image, '" alt="', $unread_txt, '" title="', $unread_txt, '">
								<img src="', $settings['default_images_url'], '/simpledesk/', $private_image, '" alt="', $private_txt, '" title="', $private_txt, '">
							</td>
							<td class="smalltext">', $ticket['display_id'], '</td>';
						break;
					case 'ticket_name':
						echo '
							<td class="smalltext">', $ticket['dept_link'], $ticket['link'];

						if ($ticket['is_unread'] && !empty($ticket['new_href']))
							echo ' <a href="', $ticket['new_href'], '"><span class="new_posts shd_new_tickets">', $txt['new'], '</span></a>';

						echo '</td>';
						break;
					case 'starting_user':
						echo '
							<td class="smalltext">', $ticket['starter']['link'], '</td>';
						break;
					case 'last_reply':
						echo '
							<td class="smalltext">', $ticket['respondent']['link'], '</td>';
						break;
					case 'assigned':
						echo '
							<td class="smalltext">' . $ticket['assigned']['link'] . '</td>';
						break;
					case 'status':
						echo '
							<td class="smalltext">', $ticket['status']['label'], '</td>';
						break;
					case 'urgency':
						echo '
							<td class="smalltext">' . $ticket['urgency']['label'] . '</td>';
						break;
					case 'updated':
						echo '
							<td class="smalltext">', $ticket['last_update'], '</td>';
						break;
					case 'replies':
						echo '
							<td class="smalltext"><a href="', $ticket['replies_href'], '">', $ticket['num_replies'], '</a></td>';
						break;
					case 'allreplies':
						echo '
							<td class="smalltext"><a href="', $ticket['replies_href'], '">', $ticket['all_replies'], '</a></td>';
						break;
					case 'actions':
						echo '
							<td>';

						foreach ($ticket['actions'] as $action)
							echo '
								', $action;

						echo '
							</td>';

						break;
					default:
						echo '
							<td><td>';
						break;
				}
			}

			echo '
			</tr>';
		}
	}

	if (!empty($context['ticket_blocks'][$context['current_block']]['page_index']))
		echo '
			<tr class="bot_page">
				<td colspan="', $block_width, '"><span class="floatright smalltext">', $context['ticket_blocks'][$context['current_block']]['page_index'], '</span></td>
			</tr>';

	echo '
		</table>';
}

/**
 *	Makes a menu header clickable/sortable.
 *
 *	Within the ticket blocks, it is possible to sort the blocks by column, and do so in a way that is retained as you manipulate individual blocks. Since this is transient (not pushed to the database) it needs to be recorded in the URL over time.
 *
 *	@param string $header The identifier of the header to use here; related to {@link shd_helpdesk_listing()}
 *	@param string $string The text string to use as the header text
 *
 *	@return string The fully formed HTML fragment for the link, text and hint image
 *	@see template_ticket_block()
 *	@since 1.0
*/
function template_shd_menu_header($header, $string)
{
	global $context, $scripturl, $settings;

	if (empty($context['ticket_blocks'][$context['current_block']]['tickets']))
		return $string; // no sense doing any work if it's an empty block and thus not sortable!

	$link = '';
	// Get the pages of existing items first
	foreach ($context['ticket_blocks'] as $block_key => $block)
		if (isset($_REQUEST['st_' . $block_key]))
			$link .= ';st_' . $block_key . '=' . $block['start'];

	// Now for sorting direction per block
	foreach ($context['ticket_blocks'] as $block_key => $block)
	{
		if (!$block['sort']['add_link'] && $block_key != $context['current_block'])
			continue;

		$link_direction = ($block_key == $context['current_block']) ? ($block['sort']['direction'] == 'asc' ? 'desc' : 'asc') : $block['sort']['direction'];

		$link .= ';so_' . $block_key . '=' . ($block_key != $context['current_block'] ? $block['sort']['item'] : $header) . '_' . $link_direction;
	}

	$html = '<a href="' . $scripturl . '?action=helpdesk;sa=' . $context['shd_current_subaction'] . ($context['shd_current_subaction'] == 'viewblock' ? ';block=' . $context['shd_current_block'] : '') . $link . $context['shd_dept_link'] . '">' . $string . '</a> ';

	if ($context['ticket_blocks'][$context['current_block']]['sort']['item'] == $header)
		$html .= '<img src="' . $settings['images_url'] . '/simpledesk/move_' . ($context['ticket_blocks'][$context['current_block']]['sort']['direction'] == 'asc' ? 'down' : 'up') . '.png" alt="">';

	return $html;
}

/**
 *	Displays a header to admins while the helpdesk is in maintenance mode.
 *
 *	The helpdesk is disabled to non admins while in maintenance mode, but this template is added to the template layers if the user is an admin and it's in maintenance mode.
 *	@since 2.0
*/
function template_shd_maintenance_above()
{
	global $txt, $settings;
	echo '
		<div class="errorbox">
			<img src="', $settings['default_images_url'], '/simpledesk/update.png" alt="*" class="shd_icon_minihead"> &nbsp;', $txt['shd_helpdesk_maintenance'], '
		</div>';
}

/**
 *	Displays a footer to admins while the helpdesk is in maintenance mode.
 *
 *	The helpdesk is disabled to non admins while in maintenance mode, but this template is added to the template layers if the user is an admin and it's in maintenance mode.
 *	@since 2.0
*/
function template_shd_maintenance_below()
{
}

/**
 *	Wrapper for the button_strip.
 *
 *	@since 2.1
*/
function template_shd_button_strip($button_strip, $direction = '', $strip_options = array())
{
	// If SMF version exists, use it.
	if (function_exists('template_button_strip'))
		template_button_strip($button_strip, $direction, $strip_options);
}