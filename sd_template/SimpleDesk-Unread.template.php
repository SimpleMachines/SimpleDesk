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
		<div class="title_bar sd_unread_title">
			<span style="width: 8%;"><img src="', $settings['default_images_url'], '/simpledesk/ticket.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket'], '</span>
			<span style="width: 15%;">', $txt['shd_ticket_name'], '</span>
			<span style="width: 12%;"><img src="', $settings['default_images_url'], '/simpledesk/user.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_started_by'], '</span>
			<span style="width: 7%;">', $txt['shd_ticket_replies'], '</span>
			<span style="width: 17%;"><img src="', $settings['default_images_url'], '/simpledesk/status.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_status'], '</span>
			<span style="width: 8%;"><img src="', $settings['default_images_url'], '/simpledesk/urgency.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_urgency'], '</span>
			<span style="width: 22%;"><img src="', $settings['default_images_url'], '/simpledesk/time.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_updated'], '</span>
		</div>
		<div class="sd_unread_content">';

	if (empty($context['shd_unread_info']))
		echo '
			<div class="windowbg">
				<span>', $txt['shd_error_no_tickets'], '</span>
			</div>';
	else
		foreach ($context['shd_unread_info'] as $ticket)
			echo '
			<span style="width: 8%;">', $ticket['id_ticket_display'], '</span>
			<span class="smalltext" style="width: 15%;"><a href="', $scripturl, '?action=helpdesk;sa=ticket;ticket=', $ticket['id_ticket'], '">', $ticket['subject'], '</a></span>
			<span class="smalltext" style="width: 12%;">', $ticket['ticket_starter'], '</span>
			<span class="smalltext" style="width: 7%;">', $ticket['num_replies'], '</span>
			<span class="smalltext" style="width: 17%;">', $txt['shd_status_' . $ticket['status']], '</span>
			<span class="smalltext" style="width: 8%;">', $txt['shd_urgency_' . $ticket['urgency']], '</span>
			<span class="smalltext" style="width: 22%;">', $ticket['updated'], '</span>';

	echo '
		</div>';
}