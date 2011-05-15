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
	global $context, $txt, $settings, $scripturl;

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
				<form action="', $scripturl, '?action=profile;area=hd_prefs;u=', $context['member']['id'], ';save" method="post">';

	$display_save = false;

	foreach ($context['shd_preferences_options']['groups'] as $group => $details)
	{
		if (empty($details['groups']))
			continue;

		$display_save = true;

		echo '
						<br />
						<div class="tborder">
							<div class="cat_bar grid_header">
								<h3 class="catbg">
									<img src="', shd_image_url($details['icon']), '" class="icon" alt="*" />
									', $txt['shd_pref_group_' . $group], '
								</h3>
							</div>
							<div class="roundframe">
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

		if (!empty($details['check_all']))
		{
			echo '
									<div class="padding">
										<input type="checkbox" name="all" id="check_all" value="" onclick="invertAll(this, this.form, \'', $group, '\');" class="input_check floatleft">
										<label for="check_all" class="floatleft">', $txt['check_all'], '</label>
									</div>';
		}

		echo '
								</div>
							</div>
							<span class="lowerframe"><span></span></span>
						</div>';
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
					', !empty($options['use_sidebar_menu']) ? '<br />' : '', '
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

?>