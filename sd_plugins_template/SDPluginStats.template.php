<?php
// Version: 2.1; SimpleDesk alternate front page template

/**
 *	This file handles the replacement front page.
 *
 *	@package plugin-frontpage
 *	@since 2.0
*/

/**
 *	Display the replacement front page.
 *
 *	@since 2.0
*/
function template_main()
{
	global $context, $txt, $settings, $scripturl;

$txt['general_stats'] = 'General Statistics';
$txt['new_tickets_today'] = 'New Tickets Today';
$txt['closed_tickets_today'] = 'Closed Tickets Today';
$txt['total_open_tickets'] = 'Total Open Tickets';
$txt['total_closed_tickets'] = 'Total Closed Tickets';
$txt['total_total_tickets'] = 'Total Tickets';
$txt['most_open_tickets'] = 'Most Tickets Created';
$txt['most_closed_tickets'] = 'Most Tickets Closed';
$txt['average_new_tickets'] = 'Average New Tickets';
$txt['average_closed_tickets'] = 'Average Closed Tickets';
$txt['average_assign_tickets'] = 'Average Assigned Tickets';
$txt['total_users'] = 'Total Users';
$txt['total_staff'] = 'Total Staff';
$txt['total_admins'] = 'Total Administrators';
$txt['open_closed_ratio'] = 'Open/Closed Ratio';

$txt['urgency_stats'] = 'Urgency Statistics';
$txt['urgency_open'] = 'Open';
$txt['urgency_closed'] = 'Closed';

$txt['urgency_type_0'] = 'Low Urgency Tickets';
$txt['urgency_type_1'] = 'Medium Urgency Tickets';
$txt['urgency_type_2'] = 'High Urgency Tickets';
$txt['urgency_type_3'] = 'Very High Urgency Tickets';
$txt['urgency_type_4'] = 'Severe Urgency Tickets';
$txt['urgency_type_5'] = 'Critical Urgency Tickets';

$txt['ticket_history'] = 'Ticket History';
$txt['yearly_summary'] = 'Yearly Summary';
$txt['new_tickets'] = 'New Tickets';
$txt['assigned_tickets'] = 'Assigned Tickets';
$txt['reopen_tickets'] = 'Re-opened Tickets';
$txt['closed_tickets'] = 'Closed Tickets';

	echo '
		<div class="title_bar">
			<h4 class="titlebg">
				<span class="ie6_header floatleft">
					<img src="', $settings['images_url'], '/stats_info.png" class="icon" alt=""> ', $txt['general_stats'], '
				</span>
			</h4>
		</div>
		<div class="flow_hidden">
			<div id="stats_left">
				<div class="windowbg">
					<span class="topslice"><span></span></span>
					<div class="content top_row">
						<dl class="stats">
							<dt>', $txt['new_tickets_today'], '</dt>
							<dd>', $context['shd_stats']['today'][TICKET_STATUS_NEW], '</dd>
							<dt>', $txt['closed_tickets_today'], '</dt>
							<dd>', $context['shd_stats']['today'][TICKET_STATUS_CLOSED], '</dd>
							<dt>', $txt['total_open_tickets'], '</dt>
							<dd>', $context['shd_stats']['status']['total_open'], '</dd>
							<dt>', $txt['total_closed_tickets'], '</dt>
							<dd>', $context['shd_stats']['status']['total_closed'], '</dd>
							<dt>', $txt['total_total_tickets'], '</dt>
							<dd>', $context['shd_stats']['status']['total_total'], '</dd>
							<dt>', $txt['most_open_tickets'], '</dt>
							<dd>', $context['shd_stats']['most'][TICKET_STATUS_NEW][0], ' &mdash; ', date('F d, Y', $context['shd_stats']['most'][TICKET_STATUS_NEW][1]), '</dd>
							<dt>', $txt['most_closed_tickets'], '</dt>
							<dd>', $context['shd_stats']['most'][TICKET_STATUS_CLOSED][0], ' &mdash; ', date('F d, Y', $context['shd_stats']['most'][TICKET_STATUS_CLOSED][1]), '</dd>
						</dl>
						<div class="clear"></div>
					</div>
					<span class="botslice"><span></span></span>
				</div>
			</div>
			<div id="stats_right">
				<div class="windowbg">
					<span class="topslice"><span></span></span>
					<div class="content top_row">
						<dl class="stats">
							<dt>', $txt['average_new_tickets'], ':</dt>
							<dd>', $context['shd_stats']['average'][TICKET_STATUS_NEW], '</dd>
							<dt>', $txt['average_closed_tickets'], ':</dt>
							<dd>', $context['shd_stats']['average'][TICKET_STATUS_CLOSED], '</dd>
							<dt>', $txt['average_assign_tickets'], ':</dt>
							<dd>', $context['shd_stats']['average'][TICKET_STATUS_PENDING_STAFF], '</dd>
							<dt>', $txt['total_users'], ':</dt>
							<dd>', $context['shd_stats']['totals'][ROLE_USER], '</dd>
							<dt>', $txt['total_staff'], ':</dt>
							<dd>', $context['shd_stats']['totals'][ROLE_STAFF], '</dd>
							<dt>', $txt['total_admins'], ':</dt>
							<dd>', $context['shd_stats']['totals'][ROLE_ADMIN], '</dd>
							<dt>', $txt['open_closed_ratio'], ':</dt>
							<dd>', $context['shd_stats']['status']['ratio'], '</dd>
						</dl>
						<div class="clear"></div>
					</div>
					<span class="botslice"><span></span></span>
				</div>
			</div>
		</div>

		<div class="title_bar">
			<h4 class="titlebg">
				<span class="ie6_header floatleft">
					<img src="', $settings['images_url'], '/stats_posters.png" class="icon" alt=""> ', $txt['urgency_stats'], '
				</span>
			</h4>
		</div>
		<div class="flow_hidden">
			<div id="stats_left">
				<div class="windowbg">
					<span class="topslice"><span></span></span>
					<div class="content top_row">
						<dl class="stats">';

	foreach ($context['shd_stats']['urgency']['open'] as $type => $count)
		echo '
							<dt>', $txt['urgency_type_' . $type], ' (', $txt['urgency_open'], ')</dt>
							<dd>', $count, '</dd>';

	echo '
						</dl>
						<div class="clear"></div>
					</div>
					<span class="botslice"><span></span></span>
				</div>
			</div>
			<div id="stats_right">
				<div class="windowbg">
					<span class="topslice"><span></span></span>
					<div class="content top_row">
						<dl class="stats">';

	foreach ($context['shd_stats']['urgency']['closed'] as $type => $count)
		echo '
							<dt>', $txt['urgency_type_' . $type], ' (', $txt['urgency_closed'], ')</dt>
							<dd>', $count, '</dd>';

	echo '
						</dl>
						<div class="clear"></div>
					</div>
					<span class="botslice"><span></span></span>
				</div>
			</div>
		</div>
		<div class="cat_bar">
			<h3 class="catbg">
				<span class="ie6_header floatleft">
					<img src="', $settings['images_url'], '/stats_history.png" class="icon" alt=""> ', $txt['ticket_history'], '
				</span>
			</h3>
		</div>
		<table border="0" width="100%" cellspacing="1" cellpadding="4" class="table_grid" id="stats">
			<thead>
				<tr class="titlebg" valign="middle" align="center">
					<th class="first_th lefttext" width="25%">', $txt['yearly_summary'], '</th>
					<th width="15%">', $txt['new_tickets'], '</th>
					<th width="15%">', $txt['assigned_tickets'], '</th>
					<th width="15%">', $txt['reopen_tickets'], '</th>
					<th class="last_th" width="15%">', $txt['closed_tickets'], '</th>
				</tr>
			</thead>
			<tbody>';

		foreach ($context['shd_stats']['history'] as $year_id => $year)
		{
			echo '
				<tr class="windowbg" valign="middle" align="center" id="year_', $year_id, '">
					<th class="lefttext" width="25%">', $year_id, '</th>
					<th width="15%">', $year['open'], '</th>
					<th width="15%">', $year['assigned'], '</th>
					<th width="15%">', $year['reopen'], '</th>
					<th width="15%">', $year['resolved'], '</th>
				</tr>';

			foreach ($year['child'] as $month_id => $month)
			{
				echo '
				<tr class="windowbg" valign="middle" align="center" id="tr_month_', $month_id, '">
					<th class="stats_month">', $txt['months_titles'][$month_id], ' ', $year_id, '</th>
					<th width="15%">', $month['open'], '</th>
					<th width="15%">', $month['assigned'], '</th>
					<th width="15%">', $month['reopen'], '</th>
					<th width="15%">', $month['resolved'], '</th>
				</tr>';

				foreach ($month['child'] as $day_id => $day)
					echo '
				<tr class="windowbg" valign="middle" align="center" id="tr_day_', $year_id, '-', $month_id, '-', $day_id, '">
					<td class="stats_day">', $year_id, '-', $month_id, '-', $day_id, '</td>
					<th width="15%">', $day['open'], '</th>
					<th width="15%">', $day['assigned'], '</th>
					<th width="15%">', $day['reopen'], '</th>
					<th width="15%">', $day['resolved'], '</th>
				</tr>';
			}
		}

		echo '
			</tbody>
		</table>';
}