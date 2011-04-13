<?php
// Version: 1.0 Felidae; SimpleDesk's administration/permissions area

/**
 *	Displays SimpleDesk's administration for permissions - front page, listing the templates and known defined roles.
 *
 *	@package template
 *	@since 1.1
*/

/**
 *	Display the front page of the SimpleDesk permissions area.
 *
 *	@since 1.1
*/
function template_shd_permissions_home()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/permissions.png" class="icon" alt="*" />
							', $txt['shd_admin_permissions'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_permissions_homedesc'], '
					</p>
				</div>
				<div class="tborder">
					<div class="title_bar grid_header">
						<h3 class="titlebg sd_no_margin">
							<img src="', $settings['default_images_url'], '/simpledesk/position.png" alt="*" />
							', $txt['shd_role_templates'], '
						</h3>
					</div>
					<p class="description shd_actionloginfo">
						', $txt['shd_role_templates_desc'], '
					</p>
					<table class="shd_ticketlist" cellspacing="0" width="100%">
						<tr class="titlebg">
							<td colspan="2" width="30%">', $txt['shd_role'], '</td>
							<td colspan="', count($context['shd_permissions']['group_display']), '">', $txt['shd_permissions'], '</td>
						</tr>';

	$use_bg2 = true;
	foreach ($context['shd_permissions']['roles'] as $role_id => $role_details)
	{
		echo '
						<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
							<td>', !empty($role_details['icon']) ? ('<img src="' . $settings['default_images_url'] . '/simpledesk/' . $role_details['icon'] . '" alt="" />') : '', '</td>
							<td>
								', $txt[$role_details['description']], '
								<div class="smalltext">[<a href="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=createrole;template=', $role_id, '">', $txt['shd_create_role'], '</a>]</div>
							</td>
							', template_shd_display_permission_list($role_details['permissions']), '
						</tr>';

		$use_bg2 = !$use_bg2;
	}

	echo '
					</table>
				</div>
				<br /><br />
				<div class="tborder">
					<div class="title_bar grid_header">
						<h3 class="titlebg sd_no_margin">
							<img src="', $settings['default_images_url'], '/simpledesk/roles.png" alt="*" />
							', $txt['shd_roles'], '
						</h3>
					</div>
					<p class="description shd_actionloginfo">
						', $txt['shd_roles_desc'], '
					</p>
					<table class="shd_ticketlist" cellspacing="0" width="100%">
						<tr class="titlebg">
							<td colspan="2" width="20%">', $txt['shd_role'], '</td>
							<td colspan="', count($context['shd_permissions']['group_display']), '">', $txt['shd_permissions'], '</td>
							<td width="15%">', $txt['shd_membergroups'], '</td>
							<td width="15%">', $txt['shd_departments'], '</td>
						</tr>';

	if (empty($context['shd_permissions']['user_defined_roles']))
	{
		echo '
						<tr class="windowbg">
							<td colspan="', count($context['shd_permissions']['group_display']) + 4, '" class="centertext">', $txt['shd_no_defined_roles'], '</td>
						</tr>';
	}
	else
	{
		$use_bg2 = true;
		foreach ($context['shd_permissions']['user_defined_roles'] as $role => $role_details)
		{
			echo '
						<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
							<td>', !empty($role_details['template_icon']) ? ('<img src="' . $settings['default_images_url'] . '/simpledesk/' . $role_details['template_icon'] . '" alt="" title="' . sprintf($txt['shd_based_on'], $role_details['template_name']) . '" />') : '', '</td>
							<td>
								', $role_details['name'], '
								<div class="smalltext">
									[<a href="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=editrole;role=', $role, '">', $txt['shd_edit_role'], '</a>]
									[<a href="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=copyrole;role=', $role, '">', $txt['shd_copy_role'], '</a>]
								</div>
							</td>
							', template_shd_display_permission_list($role_details['permissions']);
			if (empty($role_details['groups']))
				echo '
							<td>', $txt['shd_none'], '</td>';
			else
			{
				$array = array();
				foreach ($role_details['groups'] as $group => $group_details)
					$array[] = $group_details['link'];
				echo '
							<td>', implode(', ', $array), '</td>';
			}

			if (!empty($context['role_depts'][$role]))
				echo '
							<td>', implode(', ', $context['role_depts'][$role]), '</td>';
			else
				echo '
							<td>', $txt['shd_none'], '</td>';

			echo '
						</tr>';
			$use_bg2 = !$use_bg2;
		}
	}

	echo '
					</table>
				</div>';
}

/**
 *	Display the list of icons for a role's permissions.
 *
 *	@param array $permissions An array listing the permissions a given role has.
 *	@since 1.1
*/
function template_shd_display_permission_list($permissions)
{
	global $context, $txt, $settings;
	$permission_set = array();

	foreach ($context['shd_permissions']['permission_list'] as $permission => $details)
	{
		list($ownany, $group, $icon) = $details;
		if (empty($icon))
			continue;

		if (empty($permission_set[$group]))
			$permission_set[$group] = array();

		$permtitle = '';

		if ($ownany)
		{
			if ((!empty($permissions[$permission . '_any']) && ($permissions[$permission . '_any'] == ROLEPERM_ALLOW)) || (!empty($permissions[$permission . '_own']) && ($permissions[$permission . '_own'] == ROLEPERM_ALLOW)))
			{
				$permtitle = empty($txt['permissionname_' . $permission]) ? '' : $txt['permissionname_' . $permission] . ' (';
				if (!empty($permissions[$permission . '_any']) && $permissions[$permission . '_any'] == ROLEPERM_ALLOW)
					$permtitle .= $txt['permissionname_' . $permission . '_any'];
				elseif (!empty($permissions[$permission . '_own']) && $permissions[$permission . '_own'] == ROLEPERM_ALLOW)
					$permtitle .= $txt['permissionname_' . $permission . '_own'];

				$permtitle .= ')';
			}
		}
		else
		{
			if (!empty($permissions[$permission]) && $permissions[$permission] == ROLEPERM_ALLOW)
				$permtitle = empty($txt['permissionname_' . $permission]) ? '' : $txt['permissionname_' . $permission];
		}

		if (!empty($permtitle))
			$permission_set[$group][] = '<img src="' . shd_image_url($icon) . '" alt="" title="' . $permtitle . '" />';
	}

	foreach ($context['shd_permissions']['group_display'] as $cell => $rows)
	{
		echo '
							<td class="shd_valign_top">';

		foreach ($rows as $rowitem => $rowicon)
		{
			if (!empty($permission_set[$rowitem]))
				echo $txt['shd_permgroup_short_' . $rowitem], ': ', implode(' ', $permission_set[$rowitem]), '<br />';
		}

		echo '</td>';
	}
}

/**
 *	Display the form to create a new role.
 *
 *	@since 1.1
*/
function template_shd_create_role()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/permissions.png" class="icon" alt="*" />
							', $txt['shd_admin_permissions'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_permissions_homedesc'], '
					</p>
				</div>
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/position.png" alt="*" />
						', $txt['shd_create_role'], '
					</h3>
				</div>
				<div class="roundframe">
					<form action="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=createrole;part=2" method="post">
						<div class="content">
							<dl class="settings">
								<dt><strong>', $txt['shd_create_based_on'], ':</strong></dt>
								<dd>
									<img alt="*" src="', $settings['default_images_url'], '/simpledesk/', $context['shd_permissions']['roles'][$_REQUEST['template']]['icon'], '" />
									', $txt[$context['shd_permissions']['roles'][$_REQUEST['template']]['description']], '
								</dd>
								<dt><strong>', $txt['shd_create_name'], '</strong></dt>
								<dd><input type="text" name="rolename" id="rolename" value="" class="input_text" size="30" /></dd>
							</dl>
						</div>
						<input type="submit" value="', $txt['shd_create_role'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />
						<input type="hidden" name="template" value="', $_REQUEST['template'], '" />
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
					</form>
				</div>
				<span class="lowerframe"><span></span></span>';
}

/**
 *	Display the form to edit a role's permissions and settings.
 *
 *	@since 1.1
*/
function template_shd_edit_role()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	// This is to shortcut settings for the role we want.
	$role = &$context['shd_permissions']['user_defined_roles'][$_REQUEST['role']];

	// Start the page off, including the rename-role bit.
	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/permissions.png" class="icon" alt="*" />
							', $txt['shd_admin_permissions'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_permissions_homedesc'], '
					</p>
				</div>
				<script type="text/javascript"><!-- // --><![CDATA[
				function shd_chicon(obj)
				{
					var sSelect = document.getElementById(obj.id).value;
					var newClass = "";
					switch(sSelect)
					{
						case "disallow":
							newClass = "shd_no"; break;
						case "allow":
							newClass = "shd_yes"; break;
						case "allow_own":
							newClass = "shd_own"; break;
						case "allow_any":
							newClass = "shd_any"; break;
						default:
							newClass = ""; break;
					}
					document.getElementById(obj.id + "_icon").setAttribute("class", newClass);
				}

				function shd_toggleblock(block)
				{
					var collapsed = (document.getElementById("permheader_" + block).getAttribute("class") == "cat_bar");
					if (collapsed)
					{
						document.getElementById("permheader_" + block).setAttribute("class", "cat_bar grid_header");
						document.getElementById("permcontent_" + block).style.display = "";
						document.getElementById("permfooter_" + block).style.display = "";
						document.getElementById("permexpandicon_" + block).src = ', JavaScriptEscape($settings['images_url'] . '/collapse.gif'), ';
					}
					else
					{
						document.getElementById("permheader_" + block).setAttribute("class", "cat_bar");
						document.getElementById("permcontent_" + block).style.display = "none";
						document.getElementById("permfooter_" + block).style.display = "none";
						document.getElementById("permexpandicon_" + block).src = ', JavaScriptEscape($settings['images_url'] . '/expand.gif'), ';
					}
				}

				// ]', ']></script>
				<form action="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=saverole" method="post">
					<div class="cat_bar grid_header">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/position.png" alt="*" />
							', $txt['shd_edit_role'], '
						</h3>
					</div>
					<div class="roundframe">
						<div class="content">
							<dl class="settings">
								<dt><strong>', $txt['shd_is_based_on'], ':</strong></dt>
								<dd>
									<img alt="*" src="', $settings['default_images_url'], '/simpledesk/', $role['template_icon'], '" />
									', $role['template_name'], '
								</dd>
								<dt><strong>', $txt['shd_role_name'], ':</strong></dt>
								<dd><input type="text" name="rolename" id="rolename" value="', $role['name'], '" class="input_text" size="30" /></dd>
							</dl>
						</div>
					</div>
					<span class="lowerframe"><span></span></span>
					<br />';

	// Get ready to display the actual permissions
	$permission_set = array();
	foreach ($context['shd_permissions']['permission_list'] as $permission => $details)
	{
		if (!empty($details[2]))
			$permission_set[$details[1]][] = $permission;
	}

	foreach ($context['shd_permissions']['group_display'] as $cell => $rows)
	{
		echo '
					<div class="', ($cell == 0 ? 'floatleft' : 'floatright'), '" style="width: 49%">';

		foreach ($rows as $rowitem => $rowicon)
		{
			if (empty($permission_set[$rowitem]))
				continue;

			echo '
						<div class="cat_bar" id="permheader_', $rowitem, '">
							<h3 class="catbg">
								<span class="floatright">
									<a class="permcollapse" href="javascript:shd_toggleblock(\'', $rowitem, '\');">
										<img src="', $settings['images_url'], '/expand.gif" id="permexpandicon_', $rowitem, '" />
									</a>
								</span>
								<img src="', $settings['default_images_url'], '/simpledesk/', $rowicon, '" alt="*" />
								<a href="javascript:shd_toggleblock(\'', $rowitem, '\');">', $txt['shd_permgroup_' . $rowitem], '</a>
							</h3>
						</div>
						<div class="roundframe" id="permcontent_', $rowitem, '" style="display:none;">
							<div class="content">
								<dl class="permsettings">';

			foreach ($permission_set[$rowitem] as $permission)
			{
				list($ownany, $group, $icon) = $context['shd_permissions']['permission_list'][$permission];

				// And what exactly are we displaying as the current?
				if ($ownany)
				{
					if (!empty($role['permissions'][$permission . '_any']) && $role['permissions'][$permission . '_any'] == ROLEPERM_ALLOW)
						list($perm_class, $perm_value) = array('shd_any', 'allow_any');
					elseif (!empty($role['permissions'][$permission . '_own']) && $role['permissions'][$permission . '_own'] == ROLEPERM_ALLOW)
						list($perm_class, $perm_value) = array('shd_own', 'allow_own');
					else
						list($perm_class, $perm_value) = array('shd_no', 'disallow');
				}
				else
				{
					if (empty($role['permissions'][$permission]))
						list($perm_class, $perm_value) = array('shd_no', 'disallow');
					elseif ($role['permissions'][$permission] == ROLEPERM_ALLOW)
						list($perm_class, $perm_value) = array('shd_yes', 'allow');
				}

				echo '
									<dt', (empty($txt['permissionhelp_' . $permission]) ? '' : ' title="' . $txt['permissionhelp_' . $permission] . '"') . '><img src="', shd_image_url($icon), '" alt="*" />', $txt['permissionname_' . $permission], '</dt>
									<dd class="shd_nowrap">
										<span id="perm_', $permission, '_icon" class="', $perm_class, '"></span>
										<select name="perm_', $permission, '" id="perm_', $permission, '" onchange="javascript:shd_chicon(this);">
											<option value="disallow"', ($perm_value == 'disallow' ? ' selected="selected"' : ''), '>', (empty($txt['permissionname_' . $permission . '_no']) ? $txt['shd_roleperm_disallow'] : $txt['permissionname_' . $permission . '_no']), '&nbsp;</option>';

				if ($ownany)
				{
					echo '
											<option value="allow_own"', ($perm_value == 'allow_own' ? ' selected="selected"' : ''), '>', $txt['permissionname_' . $permission . '_own'], '&nbsp;</option>
											<option value="allow_any"', ($perm_value == 'allow_any' ? ' selected="selected"' : ''), '>', $txt['permissionname_' . $permission . '_any'], '&nbsp;</option>';
				}
				else
				{
					echo '
											<option value="allow"', ($perm_value == 'allow' ? ' selected="selected"' : ''), '>', (empty($txt['permissionname_' . $permission . '_yes']) ? $txt['shd_roleperm_allow'] : $txt['permissionname_' . $permission . '_yes']), '&nbsp;</option>';
				}

				echo '
										</select>
									</dd>';
			}

			echo '
								</dl>
							</div>
						</div>
						<span class="lowerframe" id="permfooter_', $rowitem, '" style="display:none;"><span></span></span>
						<br />';
		}

		echo '
					</div>';
	}

	echo '
					<div class="tborder floatleft" style="width: 100%;">
						<div class="cat_bar grid_header">
							<h3 class="catbg sd_no_margin">
								<img src="', $settings['default_images_url'], '/simpledesk/roles.png" alt="*" />
								', $txt['shd_role_membergroups'], '
							</h3>
						</div>
						<p class="description shd_actionloginfo">
							', $txt['shd_role_membergroups_desc'], '
						</p>
						<table class="shd_ticketlist" cellspacing="0" width="100%">
							<tr class="titlebg">
								<td width="30%">', $txt['shd_role'], '</td>
								<td width="30%">', $txt['shd_badge_stars'], '</td>
								<td>', $txt['shd_assign_group'], '</td>
							</tr>';

	$use_bg2 = true;
	foreach ($context['membergroups'] as $id_group => $group)
	{
		echo '
							<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
								<td>', $group['link'], '</td>
								<td>';

		if (!empty($group['stars']))
		{
			$stars = explode('#', $group['stars']);
			if (!empty($stars[0]) && !empty($stars[1]))
				echo str_repeat('<img src="' . $settings['images_url'] . '/' . $stars[1] . '" alt="" />', $stars[0]);
		}

		echo '</td>
								<td><input type="checkbox" class="input_check" name="group', $id_group, '"', (in_array($id_group, $context['role_groups']) ? ' checked="checked"' : ''), ' /></td>
							</tr>';

		$use_bg2 = !$use_bg2;
	}

	echo '
						</table>
						<br />
					</div>

					<div class="tborder floatleft" style="width: 100%;">
						<div class="cat_bar grid_header">
							<h3 class="catbg sd_no_margin">
								<img src="', $settings['default_images_url'], '/simpledesk/departments.png" alt="*" />
								', $txt['shd_role_departments'], '
							</h3>
						</div>
						<p class="description shd_actionloginfo">
							', $txt['shd_role_departments_desc'], '
						</p>
						<table class="shd_ticketlist" cellspacing="0" width="100%">
							<tr class="titlebg">
								<td width="50%">', $txt['shd_department_name'], '</td>
								<td width="50%">', $txt['shd_assign_dept'], '</td>
							</tr>';

	$use_bg2 = true;
	foreach ($context['role_depts'] as $id_dept => $dept)
	{
		echo '
							<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
								<td>', $dept['dept_name'], '</td>
								<td><input type="checkbox" class="input_check" name="dept', $id_dept, '"', !empty($dept['is_role']) ? ' checked="checked"' : '', ' /></td>
							</tr>';
		$use_bg2 = !$use_bg2;
	}

	echo '
						</table>
						<br />
					</div>

					<div class="floatleft">
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						<input type="hidden" name="role" value="', $_REQUEST['role'], '" />
						<input type="submit" value="', $txt['shd_edit_role'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />
						<input type="submit" value="', $txt['shd_delete_role'], '" onclick="return confirm(' . JavaScriptEscape($txt['shd_delete_role_confirm']) . ');" name="delete" class="button_submit" />
					</div>
				</form>
				<br class="clear" />';
}

/**
 *	Display the form to clone an existing role.
 *
 *	@since 1.1
*/
function template_shd_copy_role()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/permissions.png" class="icon" alt="*" />
							', $txt['shd_admin_permissions'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_permissions_homedesc'], '
					</p>
				</div>
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/position.png" alt="*" />
						', $txt['shd_copy_role'], '
					</h3>
				</div>
				<div class="roundframe">
					<form action="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=copyrole;part=2" method="post">
						<div class="content">
							<dl class="settings">
								<dt><strong>', $txt['shd_create_based_on'], ':</strong></dt>
								<dd>
									<img alt="*" src="', $settings['default_images_url'], '/simpledesk/', $context['shd_permissions']['user_defined_roles'][$_REQUEST['role']]['template_icon'], '" />
									', $context['shd_permissions']['user_defined_roles'][$_REQUEST['role']]['name'], '
								</dd>
								<dt><strong>', $txt['shd_create_name'], '</strong></dt>
								<dd><input type="text" name="rolename" id="rolename" value="" class="input_text" size="30" /></dd>
								<dt><strong>', $txt['shd_copy_role_groups'], '</strong></dt>
								<dd><input type="checkbox" name="copygroups" id="copygroups" value="1" class="input_check" /></dd>
							</dl>
						</div>
						<input type="submit" value="', $txt['shd_copy_role'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />
						<input type="hidden" name="role" value="', $_REQUEST['role'], '" />
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
					</form>
				</div>
				<span class="lowerframe"><span></span></span>';
}
?>
