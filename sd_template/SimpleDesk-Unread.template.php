<?php
// Version: 2.1; SimpleDesk unread posts layout

/**
 *	Displays the ticket information in the unread posts page
 *
 *	@package template
 *	@since 2.0
*/

/**
 *	Placeholder for the top part of the 'template layer' as required by SMF.
 *
 *	@see template_shd_unread_below()
 *	@since 2.0
*/
function template_shd_unread_above()
{

}

/**
 *	Displays the list of possible users a ticket can have assigned.
 *
 *	Will have been populated by shd_unread_posts() in SimpleDesk-Unread.php, adding into $context['shd_unread_info'].
 *
 *	@see shd_unread_posts()
 *	@since 2.0
*/
function template_shd_unread_below()
{
	global $context, $txt, $scripturl, $settings;

	echo '
					<div class="cat_bar">
						<h3 id="shd_block_assigned" class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/ticket.png" alt="*">
							', $context['block_title'], '
							<span class="smalltext">(', count($context['shd_unread_info']) == 1 ? '1 ' . $txt['shd_count_ticket_1'] : count($context['shd_unread_info']) . ' ' . $txt['shd_count_tickets'], ')</span>
						</h3>
					</div>
				<table class="table_grid">
					<tr class="title_bar">
						<td width="8%"><img src="', $settings['default_images_url'], '/simpledesk/ticket.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket'], '</td>
						<td width="15%">', $txt['shd_ticket_name'], '</td>
						<td width="12%"><img src="', $settings['default_images_url'], '/simpledesk/user.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_started_by'], '</td>
						<td width="7%">', $txt['shd_ticket_replies'], '</td>
						<td width="17%"><img src="', $settings['default_images_url'], '/simpledesk/status.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_status'], '</td>
						<td width="8%"><img src="', $settings['default_images_url'], '/simpledesk/urgency.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_urgency'], '</td>
						<td width="22%"><img src="', $settings['default_images_url'], '/simpledesk/time.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_updated'], '</td>
						</tr>';

	if (empty($context['shd_unread_info']))
		echo '
					<tr class="windowbg">
							<td colspan="7">', $txt['shd_error_no_tickets'], '</td>
						</tr>';
	else
		foreach ($context['shd_unread_info'] as $ticket)
			echo '
					<tr class="windowbg">
							<td width="4%" class="smalltext">', $ticket['id_ticket_display'], '</td>
							<td class="smalltext"><a href="', $scripturl, '?action=helpdesk;sa=ticket;ticket=', $ticket['id_ticket'], '">', $ticket['subject'], '</a></td>
							<td class="smalltext">', $ticket['ticket_starter'], '</td>
							<td class="smalltext">', $ticket['num_replies'], '</td>
							<td class="smalltext">', $txt['shd_status_' . $ticket['status']], '</td>
							<td class="smalltext">', $txt['shd_urgency_' . $ticket['urgency']], '</td>
							<td class="smalltext">', $ticket['updated'], '</td>
						</tr>';

	echo '
				</table>';
}