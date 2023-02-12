<?php
// Version: 2.0 Anatidae; SimpleDesk profile page template

/**
 *	This file handles displaying the blocks of the profile area for SimpleDesk.
 *
 *	@package template
 *	@since 2.0
*/

/**
 *	Display the profile section.
 *
 *	@since 2.0
*/
function template_shd_profile_main()
{
	global $context, $txt, $settings, $scripturl, $modSettings;

	echo '
	<div class="tborder shd_profile_navigation">
		<div class="cat_bar grid_header">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/user.png" alt="" class="shd_icon_minihead" />
				', sprintf($txt['shd_profile_heading'], $context['member']['name']), '
			</h3>
		</div>
		<div class="windowbg">
			<div class="content">
			<img src="', $settings['default_images_url'], '/simpledesk/ticket.png" alt="" class="shd_icon_minihead" /> <strong>', $txt['shd_profile_tickets'], '</strong><hr />
				', $txt['shd_profile_tickets_created'], ': <a href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';area=hd_showtickets">', $context['shd_numtickets'], '</a>';
	if (!empty($context['shd_numopentickets']))
		echo ' <span class="smalltext">(', $context['shd_numopentickets'], ' ', $txt['shd_profile_currently_open'], ')</span>';

	echo '
				<br />
				', $txt['shd_profile_tickets_assigned'], ': <a href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';area=hd_showtickets">', $context['shd_numassigned'], '</a>
				<br /><br />

				<div class="description shd_showtickets floatright" id="shd_showtickets">
					<a href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';area=hd_showtickets">', $txt['shd_profile_view_tickets'], '</a><br />
				</div>';

	if (!empty($context['can_post_proxy']))
		echo '
				<div class="description shd_showtickets floatright" id="shd_post_proxy">
					<a href="', $scripturl, '?action=helpdesk;sa=newticket;proxy=', $context['member']['id'], '">', $txt['shd_profile_proxy'], '</a><br />
				</div>';

	if (!empty($context['can_post_ticket']))
		echo '
				<div class="description shd_showtickets floatright" id="shd_post_ticket">
					<a href="', $scripturl, '?action=helpdesk;sa=newticket">', $txt['shd_profile_newticket'], '</a><br />
				</div>';

	echo '
				<br /><br /><br />
			</div>
			<span class="botslice"><span></span></span>
		</div>
	</div>';

	// In helpdesk-only mode, we don't have the forum profile, so we need to display what's useful and relevant on here.
	if (!empty($modSettings['shd_helpdesk_only']))
	{
		echo '
	<br />
	<div class="tborder shd_profile_navigation" id="tracking">
		<div class="cat_bar grid_header">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/user.png" alt="" class="shd_icon_minihead" />
				', $txt['summary'], ' - ', $context['member']['name'], '
			</h3>
		</div>
		<div class="windowbg">
			<div class="content">
			<img src="', $settings['default_images_url'], '/simpledesk/user.png" alt="" class="shd_icon_minihead" /> <strong>', $txt['shd_acct_information'], '</strong><hr />
				<dl>';

		if ($context['user']['is_owner'] || $context['user']['is_admin'])
			echo '
					<dt>', $txt['username'], ': </dt>
					<dd>', $context['member']['username'], '</dd>';

		// Is this member requiring activation and/or banned?
		if (!empty($context['activate_message']) || !empty($context['member']['bans']))
		{

			// If the person looking at the summary has permission, and the account isn't activated, give the viewer the ability to do it themselves.
			if (!empty($context['activate_message']))
				echo '
					<dt class="clear"><span class="alert">', $context['activate_message'], '</span>&nbsp;(<a href="' . $scripturl . '?action=profile;save;area=activateaccount;u=' . $context['id_member'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '"', ($context['activate_type'] == 4 ? ' onclick="return confirm(\'' . $txt['profileConfirm'] . '\');"' : ''), '>', $context['activate_link_text'], '</a>)</dt>';

			// If the current member is banned, show a message and possibly a link to the ban.
			if (!empty($context['member']['bans']))
			{
				echo '
					<dt class="clear"><span class="alert">', $txt['user_is_banned'], '</span>&nbsp;[<a href="#" onclick="document.getElementById(\'ban_info\').style.display = document.getElementById(\'ban_info\').style.display == \'none\' ? \'\' : \'none\';return false;">' . $txt['view_ban'] . '</a>]</dt>
					<dt class="clear" id="ban_info" style="display: none;">
						<strong>', $txt['user_banned_by_following'], ':</strong>';

				foreach ($context['member']['bans'] as $ban)
					echo '
						<br /><span class="smalltext">', $ban['explanation'], '</span>';

				echo '
					</dt>';
			}
		}

		echo '
					<dt>', $txt['date_registered'], ': </dt>
					<dd>', $context['member']['registered'], '</dd>';

		echo '
					<dt>', $txt['lastLoggedIn'], ': </dt>
					<dd>', $context['member']['last_login'], '</dd>';

		echo '
					<dt>', $txt['local_time'], ':</dt>
					<dd>', $context['member']['local_time'], '</dd>';

		if (!empty($modSettings['userLanguage']) && !empty($context['member']['language']))
			echo '
					<dt>', $txt['language'], ':</dt>
					<dd>', $context['member']['language'], '</dd>';

		echo '
				</dl>
				<hr />
				<dl>';

		if ($context['member']['show_email'] == 'yes')
			echo '
					<dt>', $txt['email'], ': </dt>
					<dd><a href="', $scripturl, '?action=emailuser;sa=email;uid=', $context['member']['id'], '">', $context['member']['email'], '</a></dd>';
		// ... Or if the one looking at the profile is an admin they can see it anyway.
		elseif ($context['member']['show_email'] == 'yes_permission_override')
			echo '
					<dt>', $txt['email'], ': </dt>
					<dd><em><a href="', $scripturl, '?action=emailuser;sa=email;uid=', $context['member']['id'], '">', $context['member']['email'], '</a></em></dd>';

		// If the person looking is allowed, they can check the members IP address and hostname.
		if ($context['can_see_ip'])
		{
			if (!empty($context['member']['ip']))
			echo '
					<dt>', $txt['ip'], ': </dt>
					<dd><a href="', $scripturl, '?action=profile;area=tracking;sa=ip;searchip=', $context['member']['ip'], ';u=', $context['member']['id'], '">', $context['member']['ip'], '</a></dd>';

			if (empty($modSettings['disableHostnameLookup']) && !empty($context['member']['ip']))
				echo '
					<dt>', $txt['hostname'], ': </dt>
					<dd>', $context['member']['hostname'], '</dd>';
		}

		echo '
				</dl>';

		echo '
				<br />
			</div>
			<span class="botslice"><span></span></span>
		</div>
	</div>';
	}
}

function template_shd_profile_preferences()
{
	global $context, $txt, $settings, $scripturl;

	if (isset($_GET['save']))
		echo '
				<div class="tborder">
					<div class="windowbg" id="profile_success">
						', $txt['shd_prefs_updated'], '
					</div>
				</div>';

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/preferences.png" class="icon" alt="*" />
							', sprintf($txt['shd_profile_preferences_header'], $context['member']['name']), '
						</h3>
					</div>
				</div>
				<script type="text/javascript"><!-- // --><![CDATA[
				function shd_toggleblock(block)
				{
					var collapsed = (document.getElementById("prefheader_" + block).getAttribute("class") == "cat_bar");
					if (collapsed)
					{
						document.getElementById("prefheader_" + block).setAttribute("class", "cat_bar grid_header");
						document.getElementById("prefgroup_" + block).style.display = "";
						document.getElementById("preffooter_" + block).style.display = "";
						document.getElementById("prefexpandicon_" + block).src = ', JavaScriptEscape($settings['images_url'] . '/collapse.gif'), ';
					}
					else
					{
						document.getElementById("prefheader_" + block).setAttribute("class", "cat_bar");
						document.getElementById("prefgroup_" + block).style.display = "none";
						document.getElementById("preffooter_" + block).style.display = "none";
						document.getElementById("prefexpandicon_" + block).src = ', JavaScriptEscape($settings['images_url'] . '/expand.gif'), ';
					}
					document.getElementById("prefexpandicon_" + block).style.display = "";
				}

				// ]', ']></script>
				<form action="', $scripturl, '?action=profile;area=hd_prefs;u=', $context['member']['id'], ';save" method="post">';

	$display_save = false;
	$displayed_groups = array();
	$checkall_items = array();

	foreach ($context['shd_preferences_options']['groups'] as $group => $details)
	{
		if (empty($details['groups']))
			continue;

		$display_save = true;
		$displayed_groups[] = $group;

		echo '
						<br />
						<div class="tborder">
							<div class="cat_bar grid_header" id="prefheader_', $group, '">
								<h3 class="catbg">
									<span class="floatright">
										<a class="permcollapse" href="#" onclick="shd_toggleblock(\'', $group, '\'); return false;">
											<img src="', $settings['images_url'], '/expand.gif" id="prefexpandicon_', $group, '" style="display:none;" />
										</a>
									</span>
									<img src="', shd_image_url($details['icon']), '" class="icon" alt="*" />
									<a class="prefcollapse" href="#prefheader_', $group, '" onclick="shd_toggleblock(\'', $group, '\'); return false;">', $txt['shd_pref_group_' . $group], '</a>
								</h3>
							</div>
							<div class="roundframe" id="prefgroup_', $group, '">
								<div class="content">
									<dl class="permsettings">';

		foreach ($details['groups'] as $pref)
		{
			$thispref = $context['shd_preferences_options']['prefs'][$pref];
			echo '
										<dt>
											', empty($thispref['icon']) ? '' : ('<img src="' . shd_image_url($thispref['icon']) . '" class="icon" alt="*" /> '), '
											', $txt['shd_pref_' . $pref], '
										</dt>
										<dd>';

			switch ($thispref['type'])
			{
				case 'check':
					echo '
										<input type="checkbox" value="1" name="', $pref, '"', (empty($context['member']['shd_preferences'][$pref]) ? '' : ' checked="checked"'), ' />';
					break;
				case 'int':
					echo '
										<input type="input" size="', isset($thispref['size']) ? $thispref['size'] : '5', '" value="', !isset($context['member']['shd_preferences'][$pref]) ? $thispref['default'] : $context['member']['shd_preferences'][$pref], '" name="', $pref, '" />';
					break;
				case 'select':
					echo '
										<select name="', $pref, '">';
					foreach ($thispref['options'] as $opt_value => $opt_desc)
						echo '
											<option value="', $opt_value, '"', isset($context['member']['shd_preferences'][$pref]) && $context['member']['shd_preferences'][$pref] == $opt_value ? ' selected="selected"' : '', '>', $txt[$opt_desc], '</option>';
					echo '
										</select>';
					break;
			}

			echo '
										</dd>';
		}

		echo '
									</dl>';

		// Only display if the preference group is set to actually have said option, and if 3+ were actually being displayed, otherwise it looks stupid.
		if (!empty($details['check_all']) && count($details['groups']) > 2)
		{
			echo '
									<div class="padding" id="checkall_div_', $group, '" style="display:none;">
										<input type="checkbox" name="all" id="check_all" value="" onclick="invertAll(this, this.form, \'', $group, '\');" class="input_check floatleft">
										<label for="check_all" class="floatleft">', $txt['check_all'], '</label>
									</div>';
			$checkall_items[] = $group;
		}

		echo '
								</div>
							</div>
							<span class="lowerframe" id="preffooter_', $group, '"><span></span></span>
						</div>';
	}

	// And the JS required to hide everything.
	if (!empty($displayed_groups) || !empty($checkall_items))
	{
		echo '
						<script type="text/javascript"><!-- // --><![CDATA[';

		if (!empty($displayed_groups))
			echo '
						var hidden_blocks = ["', implode('","', $displayed_groups), '"];
						for (i in hidden_blocks)
						{
							shd_toggleblock(hidden_blocks[i]);
						}';

		if (!empty($checkall_items))
			echo '
						var checkall_items = ["', implode('","', $checkall_items), '"];
						for (i in checkall_items)
						{
							document.getElementById("checkall_div_" + checkall_items[i]).style.display = "";
						}';

		echo '
						// ]', ']></script>';
	}

	if ($display_save)
		echo '
						<br />
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						<input type="submit" value="', $txt['shd_profile_save_prefs'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />';
	else
		echo '
						<br />
						<div class="tborder">
							<div class="cat_bar grid_header">
								<h3 class="catbg">
									', $txt['shd_profile_preferences_none_header'], '
								</h3>
							</div>
							<div class="roundframe">
								<div class="content">
								', $txt['shd_profile_preferences_none_desc'], '
								</div>
							</div>
							<span class="lowerframe"><span></span></span>
						</div>';

	echo '
				</form>';
}

function template_shd_profile_show_tickets()
{
	global $context, $txt, $settings, $scripturl, $options, $modSettings;

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/ticket.png" class="icon" alt="*" />
							', sprintf($txt['shd_profile_show_tickets_header'], $context['member']['name']), '
						</h3>
					</div>
					<p class="description">', $txt['shd_profile_show_tickets_description'], '</p>
				</div>';

	// The navigation.
	echo '<div class="shd_profile_show_tickets_nav">', template_button_strip($context['show_tickets_navigation']), '<br class="clear" /></div>';

	// Pagination
	echo '
	<div class="tborder">
		<div class="title_bar">
			<h3 class="titlebg">
				<img src="', $settings['default_images_url'], '/simpledesk/', $context['can_haz_replies'] ? 'replies' : 'ticket', '.png" class="floatright shd_icon_fullhead" alt=""/>
				<span class="smalltext">', $txt['pages'], ': ', $context['page_index'], '</span>
			</h3>
		</div>';

	// Loop through all the stuff
	foreach ($context['items'] as $item)
	{
		// Just so we won't have to write the same thing twice. We're lazy here, y'know?
		$item_link = '"<a href="' . $scripturl . '?action=helpdesk;sa=ticket;ticket=' . $item['ticket'] . '.' . ($item['is_ticket'] ? '0' : ($item['start'] . '#msg' . $item['msg'])) . '">' . $item['subject'] . '</a>"';

		echo '
		<div class="topic">
			<div class="', $item['alternate'] == 0 ? 'windowbg2' : 'windowbg', ' core_posts">
				<span class="topslice"><span></span></span>
				<div class="content">
					<div class="counter">', $item['counter'], '</div>
					<div class="topic_details">
						<h5><strong>', !$item['is_ticket'] ? sprintf($txt['shd_profile_reply_to_ticket'], $item_link) : sprintf($txt['shd_profile_a_ticket'], $item_link), '</strong></h5>
						<span class="smalltext">&#171;&nbsp;<strong>', $txt['on'], ':</strong> ', $item['time'], '&nbsp;&#187;</span>
					</div>
					<div class="list_posts">
						', $item['body'], '
						<div class="description shd_replybutton floatright" id="shd_replybutton">
							<a href="', $scripturl, '?action=helpdesk;sa=ticket;ticket=', $item['ticket'], '.0">', $txt['shd_profile_view_full_ticket'], '</a><br />
						</div>
					</div>
				</div>
				<br class="clear" />
				<span class="botslice"><span></span></span>
			</div>
		</div>';
	}

	// Some more pagination.
	echo '
		<div class="title_bar">
			<h3 class="titlebg">
				<img src="', $settings['default_images_url'], '/simpledesk/', $context['can_haz_replies'] ? 'replies' : 'ticket', '.png" class="floatright shd_icon_fullhead" alt=""/>
				<span class="smalltext">', $txt['pages'], ': ', $context['page_index'], '</span>
			</h3>
		</div>
	</div>';
}

function template_shd_profile_show_notify_override()
{
	global $context, $txt, $settings, $scripturl, $options, $modSettings;

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/log_', $context['notify_type'], '.png" class="icon" alt="*" />
							', $txt['shd_profile_show_' . $context['notify_type'] . '_header'], '
						</h3>
					</div>
					<p class="description">', $txt['shd_profile_show_' . $context['notify_type'] . '_description'], '</p>
				</div>';

	// The navigation.
	echo '
				<div class="shd_profile_show_tickets_nav">', template_button_strip($context['show_tickets_navigation']), '<br class="clear" /></div>';

	echo '
				<table class="shd_ticketlist" cellspacing="0" width="100%">
					<tr class="titlebg">
						<td width="8%" class="shd_nowrap"><img src="', $settings['default_images_url'], '/simpledesk/ticket.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket'], '</td>
						<td width="15%" class="shd_nowrap">', $txt['shd_ticket_name'], '</td>
						<td width="12%" class="shd_nowrap"><img src="', $settings['default_images_url'], '/simpledesk/user.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_started_by'], '</td>
						<td width="7%" class="shd_nowrap">', $txt['shd_ticket_replies'], '</td>
						<td width="17%" class="shd_nowrap"><img src="', $settings['default_images_url'], '/simpledesk/status.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_status'], '</td>
						<td width="8%" class="shd_nowrap"><img src="', $settings['default_images_url'], '/simpledesk/urgency.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_urgency'], '</td>
						<td width="22%" class="shd_nowrap"><img src="', $settings['default_images_url'], '/simpledesk/time.png" class="shd_smallicon" alt=""> ', $txt['shd_ticket_updated'], '</td>
					</tr>';

	if (empty($context['tickets']))
	{
		echo '
					<tr class="windowbg2">
						<td colspan="7">', $txt['shd_error_no_tickets'], '</td>
					</tr>';
	}
	else
	{
		$use_bg2 = true;
		foreach ($context['tickets'] as $ticket)
		{
			echo '
						<tr class="windowbg', $use_bg2 ? '2' : '', '">
							<td width="4%" class="smalltext">', $ticket['id_ticket_display'], '</td>
							<td class="smalltext"><a href="', $scripturl, '?action=helpdesk;sa=ticket;ticket=', $ticket['id_ticket'], '">', $ticket['subject'], '</a></td>
							<td class="smalltext">', $ticket['ticket_starter'], '</td>
							<td class="smalltext">', $ticket['num_replies'], '</td>
							<td class="smalltext">', $txt['shd_status_' . $ticket['status']], '</td>
							<td class="smalltext">', $txt['shd_urgency_' . $ticket['urgency']], '</td>
							<td class="smalltext">', $ticket['updated'], '</td>
						</tr>';

			$use_bg2 = !$use_bg2;
		}
	}

	echo '
					</table>';
}

function template_shd_profile_permissions()
{
	global $context, $txt, $settings, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/permissions.png" class="icon" alt="*" />
							', sprintf($txt['shd_profile_permissions_header'], $context['member']['name']), '
						</h3>
					</div>';

	if (!empty($context['member']['has_all_permissions']))
	{
		// Whoa, this dude's special. Tidy up and BAIL!
		echo '
					<p class="description">
						', $txt['shd_profile_permissions_all_admin'], '
					</p>
				</div>';
		return;
	}

	// Regular user: carry on, sergeant.
	echo '
					<p class="description">
						', $txt['shd_profile_permissions_description'], '
					</p>
				</div>';

	// Now hang on a moment. We need to display the list of departments, and if that's all we have, stop there.
	echo '
				<span class="upperframe"><span></span></span>
				<div class="roundframe">
					<form action="', $scripturl, '?action=profile;u=', $context['member']['id'], ';area=hd_permissions" method="post">
						', $txt['shd_profile_showdept'], ':
						<select name="permdept">
							<option value="0">', $txt['shd_profile_selectdept'], '</option>';

	foreach ($context['depts_list'] as $id => $dept)
		echo '
							<option value="', $id, '"', $_REQUEST['permdept'] == $id ? ' selected="selected"' : '', '>', $dept, '</option>';

	echo '
						</select>
						<input type="submit" class="button_submit" value="', $txt['go'], '" />
					</form>
				</div>
				<span class="lowerframe"><span></span></span>
				<br />';
	// We're done?
	if (!empty($context['dept_list_only']))
		return;

	// Now, display the roles that are attached to this user, and display the groups that make that link.
	echo '
				<div class="tborder">
					<div class="cat_bar grid_header">
						<h3 class="catbg sd_no_margin">
							<img src="', $settings['default_images_url'], '/simpledesk/roles.png" alt="*" />
							', $txt['shd_roles'], '
						</h3>
					</div>
					<p class="description shd_actionloginfo">
						', $txt['shd_profile_roles_assigned'], '
					</p>
					<table class="shd_ticketlist" cellspacing="0" width="100%">
						<tr class="titlebg">
							<td colspan="2" width="30%">', $txt['shd_role'], '</td>
							<td>', $txt['shd_profile_role_membergroups'], '</td>
						</tr>';

	if (empty($context['member_roles']))
	{
		echo '
						<tr class="windowbg">
							<td colspan="3" class="centertext">', $txt['shd_profile_no_roles'], '</td>
						</tr>';
	}
	else
	{
		$use_bg2 = true;
		foreach ($context['member_roles'] as $role)
		{
			echo '
						<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
							<td>', !empty($context['shd_permissions']['roles'][$role['template']]['icon']) ? ('<img src="' . $settings['default_images_url'] . '/simpledesk/' . $context['shd_permissions']['roles'][$role['template']]['icon'] . '" alt="" />') : '', '</td>
							<td>', $role['name'], '</td>
							<td>';

			$done_group = false;
			foreach ($role['groups'] as $group)
			{
				if ($done_group)
					echo ', ';

				echo $context['membergroups'][$group]['link'];
				$done_group = true;
			}

			echo '</td>
						</tr>';
			$use_bg2 = !$use_bg2;
		}
	}

	echo '
					</table>
				</div>';

	// Now display their permissions!
	if (!empty($context['member_permissions']['allowed']))
	{
		echo '
				<br />
				<div class="tborder">
					<div class="cat_bar grid_header">
						<h3 class="catbg sd_no_margin">
							<img src="', $settings['default_images_url'], '/simpledesk/perm_yes.png" alt="*" />
							', $txt['shd_profile_granted'], '
						</h3>
					</div>
					<p class="description shd_actionloginfo">
						', $txt['shd_profile_granted_desc'], '
					</p>
					<table class="shd_ticketlist" cellspacing="0" width="100%">
						<tr class="titlebg">
							<td colspan="2" width="60%">', $txt['shd_permissions'], '</td>
							<td>', $txt['shd_roles'], '</td>
						</tr>';

		// Right, we're going to go by what's in the master list first.
		$use_bg2 = true;
		$last_permission_cat = '';

		foreach ($context['shd_permissions']['permission_list'] as $permission => $details)
		{
			list($ownany, $category, $icon) = $details;
			if (empty($icon))
				continue; // don't display it here at all if it's a denied permission or no icon (which means, access to helpdesk / is staff / admin helpdesk permissions are excluded here)

			// Well, are we displaying it?
			if ($ownany)
			{
				if (!empty($context['member_permissions']['denied'][$permission . '_any']) || (empty($context['member_permissions']['allowed'][$permission . '_any']) && empty($context['member_permissions']['allowed'][$permission . '_own'])))
					continue; // deny hits both _any and _own when being saved
			}
			else
			{
				if (!empty($context['member_permissions']['denied'][$permission]) || empty($context['member_permissions']['allowed'][$permission]))
					continue;
			}

			if ($category != $last_permission_cat)
			{
				$thisicon = '';
				foreach ($context['shd_permissions']['group_display'] as $group => $permgroups)
				{
					if (!isset($permgroups[$category]))
						continue;
					else
						$thisicon = $permgroups[$category];
				}
				echo '
						<tr class="catbg">
							<td colspan="3">', (empty($thisicon) ? '' : '<img src="' . shd_image_url($thisicon) . '" alt="" />'), ' ', $txt['shd_permgroup_' . $category], '</td>
						</tr>';
				$last_permission_cat = $category;
			}

			echo '
						<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
							<td><img src="', shd_image_url($icon), '" alt="" /></td>';

			if ($ownany)
			{
				echo '
							<td>', $txt['permissionname_' . $permission], ' - ';
				if (!empty($context['member_permissions']['allowed'][$permission . '_any']))
				{
					$roles = $context['member_permissions']['allowed'][$permission . '_any'];
					echo $txt['permissionname_' . $permission . '_any'];
				}
				elseif (!empty($context['member_permissions']['allowed'][$permission . '_own']))
				{
					$roles = $context['member_permissions']['allowed'][$permission . '_own'];
					echo $txt['permissionname_' . $permission . '_own'];
				}

				echo '</td>';
			}
			else
			{
				$roles = $context['member_permissions']['allowed'][$permission];
				echo '
							<td>', $txt['permissionname_' . $permission], '</td>';
			}

			echo '
							<td>';
			$done_first = false;
			foreach ($roles as $role)
			{
				if ($done_first)
					echo ', ';

				echo '<span class="shd_nowrap"><img src="', $settings['default_images_url'], '/simpledesk/', $context['shd_permissions']['roles'][$context['member_roles'][$role]['template']]['icon'], '" alt="" />&nbsp;', $context['member_roles'][$role]['name'], '</span>';
				$done_first = true;
			}

			echo '
							</td>
						</tr>';

			$use_bg2 = !$use_bg2;
		}

		echo '
					</table>
				</div>';
	}

	// Display of denied permissions goes here.
}

function template_shd_profile_actionlog()
{
	global $context, $settings, $txt, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar grid_header">
						<h3 class="catbg" id="ticket_log_header">
							<img src="', $settings['default_images_url'], '/simpledesk/log.png" class="icon" alt="*" />
							', sprintf($txt['shd_profile_log'], $context['member']['name']), '
							<span class="smalltext">(', $context['action_log_count'] == 1 ? $txt['shd_profile_log_count_one'] : sprintf($txt['shd_profile_log_count_more'], $context['action_log_count']) , ')</span>
						</h3>
					</div>
					<table class="shd_ticketlist" id="ticket_log" cellspacing="0" width="100%">
						<tr class="titlebg">
							<td width="15%">
								<img src="', $settings['default_images_url'], '/simpledesk/time.png" class="shd_smallicon" alt="" />
								', $txt['shd_ticket_log_date'], '
							</td>
							<td width="50%">
								<img src="', $settings['default_images_url'], '/simpledesk/action.png" class="shd_smallicon" alt="" />
								', $txt['shd_ticket_log_action'], '
							</td>
						</tr>';

	if (empty($context['action_log']))
		echo '
						<tr class="windowbg2">
							<td colspan="2" class="shd_noticket">', $txt['shd_profile_log_none'], '</td>
						</tr>';
	else
	{
		$use_bg2 = true; // start with windowbg2 to differentiate between that and windowbg2
		foreach ($context['action_log'] as $action)
		{
			echo '
						<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
							<td class="smalltext">', $action['time'], '</td>
							<td class="smalltext">
								<img src="', $settings['default_images_url'], '/simpledesk/', $action['action_icon'], '" alt="" class="shd_smallicon" />
								', $action['action_text'], '
							</td>
						</tr>';

			$use_bg2 = !$use_bg2;
		}
	}

	echo '
						<tr class="titlebg">
							<td colspan="2">
								', !empty($context['action_full_log']) ? '<span class="smalltext shd_main_log"><img src="' . $settings['default_images_url'] . '/simpledesk/browse.png" alt="" /> <a href="' . $scripturl . '?action=admin;area=helpdesk_info;sa=actionlog">' . $txt['shd_profile_log_full'] . '</a></span>' : '', '
							</td>
						</tr>
					</table>
				</div>';
}

function template_shd_profile_navigation_above()
{
	global $settings, $scripturl, $context, $txt, $options;

	echo '
		<div class="', empty($options['use_sidebar_menu']) ? 'shd_ticket_leftcolumn floatleft' : '', '">
			<div class="tborder shd_profile_navigation">
				<span class="upperframe"><span></span></span>
				<div class="roundframe">
					<ul class="', !empty($options['use_sidebar_menu']) ? 'shd_profile_nav_inline' : 'shd_profile_nav_list', '">';
	foreach ($context['shd_profile_menu'] as $menuitem)
	{
		if (!empty($menuitem['show']))
		{
			echo '
						<li', (!empty($menuitem['is_last']) ? ' class="shd_inline_last"' : ''), '>
							<img src="', $settings['default_images_url'], '/simpledesk/', $menuitem['image'], '" alt="x" class="floatright" />
							<a href="', $menuitem['link'], '"><strong>', $menuitem['text'], '</strong></a>
							', (empty($options['use_sidebar_menu']) && empty($menuitem['is_last'])) ? '<hr />' : '', '
						</li>';
		}
	}

	echo '
					</ul>
					', !empty($options['use_sidebar_menu']) ? '<br class="clear" />' : '', '
				</div>
				<span class="lowerframe"><span></span></span>
			</div>
		</div>
		', !empty($options['use_sidebar_menu']) ? '<br />' : '', '
		<div class="', empty($options['use_sidebar_menu']) ? 'shd_ticket_rightcolumn floatright' : '', '">';
}

function template_shd_profile_navigation_below()
{
	echo '
		</div>
		<br class="clear" />';
}

function template_shd_profile_summary_wrapper()
{
	template_summary();
}

// Template for showing theme settings. Note: template_options() actually adds the theme specific options.
function template_profile_shd_theme_settings()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;

	echo '
							<dd></dd>
						</dl>
						<ul id="theme_settings">
							<li>
								<input type="hidden" name="default_options[use_sidebar_menu]" value="0" />
								<label for="use_sidebar_menu"><input type="checkbox" name="default_options[use_sidebar_menu]" id="use_sidebar_menu" value="1"', !empty($context['member']['options']['use_sidebar_menu']) ? ' checked="checked"' : '', ' class="input_check" /> ', $txt['use_sidebar_menu'], '</label>
							</li>';

	if ($settings['allow_no_censored'])
		echo '
							<li>
								<input type="hidden" name="default_options[show_no_censored]" value="0" />
								<label for="show_no_censored"><input type="checkbox" name="default_options[show_no_censored]" id="show_no_censored" value="1"' . (!empty($context['member']['options']['show_no_censored']) ? ' checked="checked"' : '') . ' class="input_check" /> ' . $txt['show_no_censored'] . '</label>
							</li>';

	echo '
							<li>
								<input type="hidden" name="default_options[return_to_post]" value="0" />
								<label for="return_to_post"><input type="checkbox" name="default_options[return_to_post]" id="return_to_post" value="1"', !empty($context['member']['options']['return_to_post']) ? ' checked="checked"' : '', ' class="input_check" /> ', $txt['return_to_post'], '</label>
							</li>
							<li>
								<input type="hidden" name="default_options[no_new_reply_warning]" value="0" />
								<label for="no_new_reply_warning"><input type="checkbox" name="default_options[no_new_reply_warning]" id="no_new_reply_warning" value="1"', !empty($context['member']['options']['no_new_reply_warning']) ? ' checked="checked"' : '', ' class="input_check" /> ', $txt['no_new_reply_warning'], '</label>
							</li>';

	// Choose WYSIWYG settings?
	if (empty($modSettings['disable_wysiwyg']))
		echo '
							<li>
								<input type="hidden" name="default_options[wysiwyg_default]" value="0" />
								<label for="wysiwyg_default"><input type="checkbox" name="default_options[wysiwyg_default]" id="wysiwyg_default" value="1"', !empty($context['member']['options']['wysiwyg_default']) ? ' checked="checked"' : '', ' class="input_check" /> ', $txt['wysiwyg_default'], '</label>
							</li>';

	if (!empty($modSettings['cal_enabled']))
		echo '
							<li>
								<label for="calendar_start_day">', $txt['calendar_start_day'], ':</label>
								<select name="default_options[calendar_start_day]" id="calendar_start_day">
									<option value="0"', empty($context['member']['options']['calendar_start_day']) ? ' selected="selected"' : '', '>', $txt['days'][0], '</option>
									<option value="1"', !empty($context['member']['options']['calendar_start_day']) && $context['member']['options']['calendar_start_day'] == 1 ? ' selected="selected"' : '', '>', $txt['days'][1], '</option>
									<option value="6"', !empty($context['member']['options']['calendar_start_day']) && $context['member']['options']['calendar_start_day'] == 6 ? ' selected="selected"' : '', '>', $txt['days'][6], '</option>
								</select>
							</li>';

	if (empty($modSettings['disableCustomPerPage']))
		echo '
							<li>
								<label for="messages_per_page">', $txt['shd_replies_per_page'], '</label>
								<select name="default_options[messages_per_page]" id="messages_per_page">
									<option value="0"', empty($context['member']['options']['messages_per_page']) ? ' selected="selected"' : '', '>', $txt['shd_per_page_default'], ' (', $modSettings['defaultMaxMessages'], ')</option>
									<option value="5"', !empty($context['member']['options']['messages_per_page']) && $context['member']['options']['messages_per_page'] == 5 ? ' selected="selected"' : '', '>5</option>
									<option value="10"', !empty($context['member']['options']['messages_per_page']) && $context['member']['options']['messages_per_page'] == 10 ? ' selected="selected"' : '', '>10</option>
									<option value="25"', !empty($context['member']['options']['messages_per_page']) && $context['member']['options']['messages_per_page'] == 25 ? ' selected="selected"' : '', '>25</option>
									<option value="50"', !empty($context['member']['options']['messages_per_page']) && $context['member']['options']['messages_per_page'] == 50 ? ' selected="selected"' : '', '>50</option>
								</select>
							</li>';

	echo '
							<li>
								<label for="display_quick_reply">', $txt['display_quick_reply'], '</label>
								<select name="default_options[display_quick_reply]" id="display_quick_reply">
									<option value="0"', empty($context['member']['options']['display_quick_reply']) ? ' selected="selected"' : '', '>', $txt['display_quick_reply1'], '</option>
									<option value="1"', !empty($context['member']['options']['display_quick_reply']) && $context['member']['options']['display_quick_reply'] == 1 ? ' selected="selected"' : '', '>', $txt['display_quick_reply2'], '</option>
									<option value="2"', !empty($context['member']['options']['display_quick_reply']) && $context['member']['options']['display_quick_reply'] == 2 ? ' selected="selected"' : '', '>', $txt['display_quick_reply3'], '</option>
								</select>
							</li>
						</ul>
						<dl>
							<dd></dd>';
}

?>