<?php
// Version: 2.1; SimpleDesk searches.

/**
 *	Handles searching tickets.
 *
 *	@package template
 *	@since 1.0
*/

/**
 *	Displays the list of possible searching criteria.
 *
 *	@see shd_search()
 *	@since 2.0
*/
function template_search()
{
	global $context, $txt, $scripturl, $settings, $modSettings;

	// Back to the helpdesk.
	template_shd_button_strip(array($context['navigation']['back']));

	if (!empty($modSettings['shd_new_search_index']))
		echo '
	<div class="errorbox"><img src="', $settings['default_images_url'], '/simpledesk/warning.png" alt="*" class="shd_icon_minihead"> &nbsp;', shd_allowed_to('admin_helpdesk', 0) ? $txt['shd_search_warning_admin'] : $txt['shd_search_warning_nonadmin'], '</div>';

	echo '
	<div class="cat_bar">
		<h3 class="catbg">
			<img src="', $settings['default_images_url'], '/simpledesk/search.png" alt="*">
			', $txt['shd_search'], '
		</h3>
	</div>
	<div class="roundframe">
		<form action="', $scripturl, '?action=helpdesk;sa=search2" method="post">
			<div class="content">
				<br>
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_search_text'], '</strong>
					</dt>
					<dd>
						<input type="text" name="search" value="" size="40" maxlength="100">
					</dd>
					<dt>
						<strong>', $txt['shd_search_match'], '</strong>
					</dt>
					<dd>
						<select name="searchtype">
							<option value="all">', $txt['shd_search_match_all'], '</option>
							<option value="any">', $txt['shd_search_match_any'], '</option>
						</select>
					</dd>
				</dl>
				<br>
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_search_where'], '</strong>
					</dt>
					<dd>
						<input type="checkbox" checked="checked" name="search_subjects"> ', $txt['shd_search_where_subjects'], '<br>
						<input type="checkbox" checked="checked" name="search_tickets"> ', $txt['shd_search_where_tickets'], '<br>
						<input type="checkbox" checked="checked" name="search_replies"> ', $txt['shd_search_where_replies'], '<br>
					</dd>
				</dl>';

	if (count($context['dept_list']) == 1)
		echo '
					<input type="hidden" name="search_dept[]" value="', array_keys($context['dept_list'])[0], '">';
	else
	{
		echo '
				<hr>
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_search_dept'], '</strong>
					</dt>
					<dd>';

		foreach ($context['dept_list'] as $id => $name)
			echo '
							<input type="checkbox" checked="checked" name="search_dept[]" value="', $id, '"> &nbsp;', $name, '<br>';

		echo '
					</dd>
				</dl>';
	}

	echo '
				<hr>
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_search_scope'], '</strong>
					</dt>
					<dd>
						<input type="checkbox" checked="checked" name="scope_open"> &nbsp;', $txt['shd_search_scope_open'], '<br>
						<input type="checkbox" checked="checked" name="scope_closed"> &nbsp;', $txt['shd_search_scope_closed'], '<br>
						<input type="checkbox" checked="checked" name="scope_recycle"> &nbsp;', $txt['shd_search_scope_recycle'], '<br>
					</dd>
				</dl>
				<hr>
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_search_urgency'], '</strong>
					</dt>
					<dd>';

	// All the urgency levels, currently 0-5.
	for ($i = 0; $i <= 5; $i++)
		echo '
						<input type="checkbox" checked="checked" name="urgency[]" value="', $i, '"> &nbsp;', $txt['shd_urgency_' . $i], '<br>';

	echo '
					</dd>
				</dl>
				<hr>
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_search_ticket_starter'], '</strong>
						<div class="smalltext">', $txt['shd_search_ticket_named_person'], '</div>
					</dt>
					<dd>
						<input type="hidden" name="starter" value="">
						<input type="text" name="starter_name" id="starter_name" size="40" maxlength="100" value="">
						<div id="starter_name_container"></div>
					</dd>
				</dl>
				<br>
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_search_ticket_assignee'], '</strong>
						<div class="smalltext">', $txt['shd_search_ticket_named_person'], '</div>
					</dt>
					<dd>
						<input type="hidden" name="assignee" value="">
						<input type="text" name="assignee_name" id="assignee_name" size="40" maxlength="100" value="">
						<div id="assignee_name_container"></div>
					</dd>
				</dl>';

	template_shd_js_search();

	echo '
				<hr>
				<br>
				<input type="submit" value="', $txt['shd_search'], '" accesskey="s" class="button save">
			</div>
		</form>
	</div>';
}

function template_search_no_results()
{
	global $context, $txt, $scripturl, $settings, $modSettings;

	// Back to the helpdesk.
	template_shd_button_strip(array($context['navigation']['back'], $context['navigation']['search']));

	echo '
	<div class="cat_bar">
		<h3 class="catbg">
			<img src="', $settings['default_images_url'], '/simpledesk/search.png" alt="*">
			', $txt['shd_search'], '
		</h3>
	</div>';

	// Search criteria
	template_search_criteria();

	echo '
	<div class="roundframe">
		<div class="content">', $txt['shd_search_no_results'], '</div>
	</div>';
}

function template_search_criteria()
{
	global $context, $txt, $scripturl, $settings, $modSettings, $smcFunc;

	if (!empty($context['search_params']))
	{
		echo '
	<div class="information">
		<strong>', $txt['shd_search_criteria'], '</strong>
		<ul>';

		// We go through the form step by step.
		if (!empty($context['search_terms']))
		{
			echo '
			<li>', $txt['shd_search_text'], ' ', $smcFunc['htmlspecialchars']($context['search_terms']), ' (', $context['match_all'] ? $txt['shd_search_match_all'] : $txt['shd_search_match_any'], ')</li>';

			// Since we're here, we also need to attend to which items we searched.
			$items = array();
			foreach ($context['search_params']['areas'] as $k => $v)
				$items[] = $txt['shd_search_where_' . $k];

			echo '
			<li>', $txt['shd_search_where'], ' ', implode(', ', $items), '</li>';
		}

		// Departments. Don't bother if the user can only see one department.
		if (!empty($context['search_dept_list']))
			echo '
			<li>', $txt['shd_search_dept'], ' ', implode(', ', $context['search_dept_list']), '</li>';

		// What type of tickets?
		if (!empty($context['search_params']['status']))
		{
			$status = array();
			if (!empty($_POST['scope_open']))
				$status[] = $txt['shd_search_scope_open'];
			if (!empty($_POST['scope_closed']))
				$status[] = $txt['shd_search_scope_closed'];
			if (!empty($_POST['scope_recycle']))
				$status[] = $txt['shd_search_scope_recycle'];

			echo '
			<li>', $txt['shd_search_scope'], ' ', implode(', ', $status), '</li>';
		}

		// Ticket urgency
		if (!empty($context['search_params']['urgency']))
		{
			$urgency = $context['search_params']['urgency'];
			sort($urgency);
			foreach ($urgency as $k => $v)
				$urgency[$k] = $txt['shd_urgency_' . $v];

			echo '
			<li>', $txt['shd_search_urgency'], ' ', implode(', ', $urgency), '</li>';
		}

		// Tickets started by
		if (!empty($context['search_params']['member_started']))
		{
			$members = $context['search_params']['member_started'];
			// This is a list of ids we pulled via findMember(). We should have their names having found their ids.
			foreach ($members as $k => $v)
				$members[$k] = shd_profile_link($context['named_people'][$v], $v);

			echo '
			<li>', $txt['shd_search_ticket_starter'], ' ', implode(', ', $members), '</li>';
		}

		// Tickets assigned
		if (!empty($context['search_params']['member_assigned']))
		{
			$members = $context['search_params']['member_assigned'];
			// This is a list of ids we pulled via findMember(). We should have their names having found their ids.
			foreach ($members as $k => $v)
				$members[$k] = shd_profile_link($context['named_people'][$v], $v);

			echo '
			<li>', $txt['shd_search_ticket_assignee'], ' ', implode(', ', $members), '</li>';
		}

		echo '
		</ul>
		<em>', $txt['shd_search_excluded'], '</em>
	</div>';
	}
}

function template_search_results()
{
	global $context, $txt, $scripturl, $settings, $modSettings, $smcFunc;

	// Back to the helpdesk.
	template_shd_button_strip(array($context['navigation']['back'], $context['navigation']['search']));

	echo '
	<div class="cat_bar">
		<h3 class="catbg">
			<img src="', $settings['default_images_url'], '/simpledesk/search.png" alt="*">
			', $txt['shd_search_results'], '
		</h3>
	</div>';


	// The rest of it would go here, in a nice form that carried everything through for next time, with a button named page whose value would be the page number for each page (plus prev/next) you wanted to display

	// Search criteria
	template_search_criteria();

	foreach ($context['search_results'] as $index => $result)
	{
				echo '
	<div class="search_results_posts">
		<div class="windowbg core_posts">
			<div class="content flow_auto">
				<div class="topic_details floatleft">
					<div class="counter">', $result['result'], '</div>
					<h5>', $result['dept_link'], '<a href="', $scripturl, '?action=helpdesk;sa=ticket;ticket=', $result['id_ticket'], '">', sprintf($result['is_ticket'] ? $txt['shd_search_result_ticket'] : $txt['shd_search_result_reply'], $result['display_id']), '</a> - ', $result['subject'], ' (', $txt['shd_search_last_updated'], ' ', timeformat($result['last_updated']), ')</h5>
					<span class="smalltext">&#171;&nbsp;<strong>', $result['is_ticket'] ? $txt['shd_search_ticket_opened_by'] : $txt['shd_search_ticket_replied_by'], ' ', shd_profile_link($result['poster_name'], $result['id_member']), '</strong>&nbsp;', $txt['on'], '&nbsp;<em>', timeformat($result['poster_time']), '</em>&nbsp;&#187;</span>
				</div>
				<br>
				<div class="list_posts double_height">', $result['body'], '</div>
			</div>
		</div>
	</div>';
	}

	// Some buttons.
	echo '
	<div class="search_results_posts">
		<div class="windowbg">';

	template_search_navigation('prev');

	echo '<div style="width: 50%; margin: 0 auto;">';

	// Page navigation. It's not your usual page index, and with good reason: we can't use regular links here without risking server hammering.
	for ($page = $context['current_page'] - 2; $page <= $context['current_page'] + 2; $page++)
		template_search_navigation($page);

	echo '</div>';

	template_search_navigation('next');

	echo '
		</div>
	</div>';
}

function template_search_navigation($page = 'next')
{
	global $scripturl, $context, $txt, $smcFunc;

	// Handle the page check.
	if ($page == 'prev' && empty($context['prev_page']))
		return;
	elseif ($page == 'next' && $context['current_page'] >= $context['num_pages'])
		return;
	elseif (is_int($page) && ($page < 1 || $page >= $context['num_pages']))
		return;

	echo '
	<form method="post" action="', $scripturl, '?action=helpdesk;sa=search2">';

	// Departments.
	if (count($context['dept_list']) == 1)
		echo '
		<input type="hidden" name="search_dept[]" value="', array_keys($context['dept_list'])[0], '">';
	elseif (isset($context['search_params']['visible_depts']))
		foreach ($context['search_params']['visible_depts'] as $dept)
		echo '
		<input type="hidden" name="search_dept[]" value="', $dept, '">';

	// Some search areas.
	if (isset($context['search_params']['areas']))
		foreach ($context['search_params']['areas'] as $area => $dummy)
		echo '
		<input type="hidden" name="search_', $area, '" value="1">';

	// Standard search params arrays.
	foreach (array('urgency', 'starter_name_form', 'assigned_name_form') as $param)
		if (isset($context['search_params'][$param]))
			foreach ($context['search_params'][$param] as $value)
				echo '
		<input type="hidden" name="', $param, '[]" value="', $value, '">';
	
	// Standard search params bools.
	foreach (array('scope_open', 'scope_closed', 'scope_recycle') as $param)
		if (!empty($context['search_params'][$param]))
			echo '
		<input type="hidden" name="', $param, '" value="1">';

	// Standard search params strings.
	foreach (array('searchtype') as $param)
		if (!empty($context['search_params'][$param]))
			echo '
		<input type="hidden" name="', $param, '" value="', $context['search_params'][$param], '">';

	// Search terms.
	echo '
		<input type="hidden" name="search" value="', $smcFunc['htmlspecialchars']($context['search_terms']), '">';

	if ($page === 'prev')
		echo '
		<input type="hidden" name="page" value="', $context['prev_page'], '">
		<input type="submit" value="Previous" class="button save floatleft">';
	elseif (is_int($page) && $page > 0)
		echo '
		<input type="hidden" name="page" value="', $page, '">
		<input type="submit" value="Page ', $page, '" class="button save floatleft', $context['current_page'] == $page ? ' active' : '', '">';
	else
		echo '
		<input type="hidden" name="page" value="', $context['next_page'], '">
		<input type="submit" value="Next" class="button save">';

	echo '</form>';
}

/**
 *	Javascript for Search
 *
 *	@since 2.1
*/
function template_shd_js_search()
{
	global $context, $settings;

	echo '
				<script type="text/javascript"><!-- // --><![CDATA[
					var oTicketStarter = new smc_AutoSuggest({
						sSelf: \'oTicketStarter\',
						sSessionId: \'', $context['session_id'], '\',
						sSessionVar: \'', $context['session_var'], '\',
						sControlId: \'starter_name\',
						sSuggestId: \'starter\',
						sSearchType: \'member\',
						sPostName: \'starter_name_form\',
						sURLMask: \'action=profile;u=%item_id%\',
						bItemList: true,
						sItemListContainerId: \'starter_name_container\',
						aListItems: []
					});
					var oTicketAssignee = new smc_AutoSuggest({
						sSelf: \'oTicketAssignee\',
						sSessionId: \'', $context['session_id'], '\',
						sSessionVar: \'', $context['session_var'], '\',
						sControlId: \'assignee_name\',
						sSuggestId: \'assignee\',
						sSearchType: \'member\',
						sPostName: \'assigned_name_form\',
						sURLMask: \'action=profile;u=%item_id%\',
						bItemList: true,
						sItemListContainerId: \'assignee_name_container\',
						aListItems: []
					});
				// ]', ']></script>';
}