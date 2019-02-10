<?php
// Version: 2.1; SimpleDesk's administration/permissions area

/**
 *	Displays SimpleDesk's administration for permissions - front page, listing the templates and known defined roles.
 *
 *	@package template
 *	@since 2.0
*/

/**
 *	Display the front page of the SimpleDesk permissions area.
 *
 *	@since 2.0
*/
function template_shd_permissions_home()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/permissions.png" class="icon" alt="*">
				', $txt['shd_admin_permissions'], '
			</h3>
		</div>
		<div class="information">
			', $txt['shd_admin_permissions_homedesc'], '
		</div>
		<div class="title_bar">
			<h3 class="titlebg">
				<img src="', $settings['default_images_url'], '/simpledesk/position.png" alt="*">
				', $txt['shd_role_templates'], '
			</h3>
		</div>
		<div class="information">
			', $txt['shd_role_templates_desc'], '
		</div>
		<table class="table_grid">
			<tr class="title_bar">
				<td colspan="2" width="30%">', $txt['shd_role'], '</td>
				<td colspan="', count($context['shd_permissions']['group_display']), '">', $txt['shd_permissions'], '</td>
			</tr>';

	foreach ($context['shd_permissions']['roles'] as $role_id => $role_details)
		echo '
			<tr class="windowbg">
				<td>', !empty($role_details['icon']) ? ('<img src="' . $settings['default_images_url'] . '/simpledesk/' . $role_details['icon'] . '" alt="">') : '', '</td>
				<td>
					', $txt[$role_details['description']], '
					<div class="smalltext">[<a href="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=createrole;template=', $role_id, '">', $txt['shd_create_role'], '</a>]</div>
				</td>
				', template_shd_display_permission_list($role_details['permissions']), '
			</tr>';

	echo '
		</table>
		<div class="title_bar">
			<h3 class="titlebg">
				<img src="', $settings['default_images_url'], '/simpledesk/roles.png" alt="*">
				', $txt['shd_roles'], '
			</h3>
		</div>
		<div class="information">
			', $txt['shd_roles_desc'], '
		</div>
		<table class="table_grid">
			<tr class="title_bar">
				<td colspan="2" width="20%">', $txt['shd_role'], '</td>
				<td colspan="', count($context['shd_permissions']['group_display']), '">', $txt['shd_permissions'], '</td>
				<td width="15%">', $txt['shd_membergroups'], '</td>
				<td width="15%">', $txt['shd_departments'], '</td>
			</tr>';

	if (empty($context['shd_permissions']['user_defined_roles']))
		echo '
			<tr class="windowbg">
				<td colspan="', count($context['shd_permissions']['group_display']) + 4, '" class="centertext">', $txt['shd_no_defined_roles'], '</td>
			</tr>';
	else
	{
		foreach ($context['shd_permissions']['user_defined_roles'] as $role => $role_details)
		{
			echo '
			<tr class="windowbg">
				<td>', !empty($role_details['template_icon']) ? ('<img src="' . $settings['default_images_url'] . '/simpledesk/' . $role_details['template_icon'] . '" alt="" title="' . sprintf($txt['shd_based_on'], $role_details['template_name']) . '">') : '', '</td>
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
		}
	}

	echo '
		</table>';
}

/**
 *	Display the list of icons for a role's permissions.
 *
 *	@param array $permissions An array listing the permissions a given role has.
 *	@since 2.0
*/
function template_shd_display_permission_list($permissions)
{
	global $context, $txt, $settings;
	$permission_set = array();

	foreach ($context['shd_permissions']['permission_list'] as $permission => list($ownany, $group, $icon))
	{
		if (empty($icon))
			continue;
		elseif (empty($permission_set[$group]))
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
			if (!empty($permissions[$permission]) && $permissions[$permission] == ROLEPERM_ALLOW)
				$permtitle = empty($txt['permissionname_' . $permission]) ? '' : $txt['permissionname_' . $permission];

		if (!empty($permtitle))
			$permission_set[$group][] = '<img src="' . shd_image_url($icon) . '" alt="" title="' . $permtitle . '">';
	}

	foreach ($context['shd_permissions']['group_display'] as $cell => $rows)
	{
		echo '
							<td class="shd_valign_top">';

		foreach ($rows as $rowitem => $rowicon)
			if (!empty($permission_set[$rowitem]))
				echo $txt['shd_permgroup_short_' . $rowitem], ': ', implode(' ', $permission_set[$rowitem]), '<br>';

		echo '</td>';
	}
}

/**
 *	Display the form to create a new role.
 *
 *	@since 2.0
*/
function template_shd_create_role()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/permissions.png" class="icon" alt="*">
				', $txt['shd_admin_permissions'], '
			</h3>
		</div>
		<div class="information">
			', $txt['shd_admin_permissions_homedesc'], '
		</div>
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/position.png" alt="*">
				', $txt['shd_create_role'], '
			</h3>
		</div>
		<div class="roundframe">
			<form action="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=createrole;part=2" method="post">
				<dl class="settings">
					<dt><strong>', $txt['shd_create_based_on'], ':</strong></dt>
					<dd>
						<img alt="*" src="', $settings['default_images_url'], '/simpledesk/', $context['shd_permissions']['roles'][$context['role_template_id']]['icon'], '">
						', $txt[$context['shd_permissions']['roles'][$context['role_template_id']]['description']], '
					</dd>
					<dt><strong>', $txt['shd_create_name'], '</strong></dt>
					<dd><input type="text" name="rolename" id="rolename" value="" size="30"></dd>
				</dl>
				<input type="submit" value="', $txt['shd_create_role'], '" accesskey="s" class="button save">
				<input type="hidden" name="template" value="', $context['role_template_id'], '">
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
				<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '">
			</form>
		</div>';
}

/**
 *	Display the form to edit a role's permissions and settings.
 *
 *	@since 2.0
*/
function template_shd_edit_role()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	// This is to shortcut settings for the role we want.
	$role = &$context['shd_permissions']['user_defined_roles'][$context['shd_role_id']];

	// Start the page off, including the rename-role bit.
	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/permissions.png" class="icon" alt="*">
				', $txt['shd_admin_permissions'], '
			</h3>
		</div>
		<div class="information">
			', $txt['shd_admin_permissions_homedesc'], '
		</div>
		<script type="text/javascript"><!-- // --><![CDATA[



		// ]', ']></script>
		<form action="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=saverole" method="post">
			<div class="cat_bar cat_collapsed">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/position.png" alt="*">
					', $txt['shd_edit_role'], '
				</h3>
			</div>
			<div class="roundframe">
				<dl class="settings">
					<dt><strong>', $txt['shd_is_based_on'], ':</strong></dt>
					<dd>
						<img alt="*" src="', $settings['default_images_url'], '/simpledesk/', $role['template_icon'], '">
						', $role['template_name'], '
					</dd>
					<dt><strong>', $txt['shd_role_name'], ':</strong></dt>
					<dd><input type="text" name="rolename" id="rolename" value="', $role['name'], '" size="30"></dd>
				</dl>
			</div>
			<br class="clear">';

	// Get ready to display the actual permissions
	$permission_set = array();
	foreach ($context['shd_permissions']['permission_list'] as $permission => $details)
		if (!empty($details[2]))
			$permission_set[$details[1]][] = $permission;

	$displayed_sets = array();
	foreach ($context['shd_permissions']['group_display'] as $cell => $rows)
	{
		echo '
			<div class="', ($cell == 0 ? 'floatleft' : 'floatright'), '" style="width: 49%">';

		foreach ($rows as $rowitem => $rowicon)
		{
			if (empty($permission_set[$rowitem]))
				continue;
			$displayed_sets[] = $rowitem;

			echo '
				<div class="cat_bar" id="permheader_', $rowitem, '">
					<h3 class="catbg">
						<span class="floatright">
							<a class="permcollapse" href="#" data-block="', $rowitem, '">
								<img src="', $settings['images_url'], '/selected_open.png" id="permexpandicon_', $rowitem, '" style="display:none;">
							</a>
						</span>
						<img src="', $settings['default_images_url'], '/simpledesk/', $rowicon, '" alt="*">
						<a href="#" data-block="', $rowitem, '">', $txt['shd_permgroup_' . $rowitem], '</a>
					</h3>
				</div>
				<div class="roundframe" id="permcontent_', $rowitem, '">
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
						<dt', (empty($txt['permissionhelp_' . $permission]) ? '' : ' title="' . $txt['permissionhelp_' . $permission] . '"') . '><img src="', shd_image_url($icon), '" alt="*">', $txt['permissionname_' . $permission], '</dt>
						<dd>
							<span id="perm_', $permission, '_icon" class="', $perm_class, '"></span>
							<select name="perm_', $permission, '" id="perm_', $permission, '">
								<option value="disallow"', ($perm_value == 'disallow' ? ' selected="selected"' : ''), '>', (empty($txt['permissionname_' . $permission . '_no']) ? $txt['shd_roleperm_disallow'] : $txt['permissionname_' . $permission . '_no']), '&nbsp;</option>';

				if ($ownany)
					echo '
								<option value="allow_own"', ($perm_value == 'allow_own' ? ' selected="selected"' : ''), '>', $txt['permissionname_' . $permission . '_own'], '&nbsp;</option>
								<option value="allow_any"', ($perm_value == 'allow_any' ? ' selected="selected"' : ''), '>', $txt['permissionname_' . $permission . '_any'], '&nbsp;</option>';
				else
					echo '
								<option value="allow"', ($perm_value == 'allow' ? ' selected="selected"' : ''), '>', (empty($txt['permissionname_' . $permission . '_yes']) ? $txt['shd_roleperm_allow'] : $txt['permissionname_' . $permission . '_yes']), '&nbsp;</option>';

				echo '
							</select>
						</dd>';
			}

			echo '
					</dl>
				</div>
				<span id="permfooter_', $rowitem, '"></span>
				<br>';
		}

		echo '
			</div>';
	}

	echo '
		<div class="floatleft">
			<div class="cat_bar">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/roles.png" alt="*">
					', $txt['shd_role_membergroups'], '
				</h3>
			</div>
			<div class="information">
				', $txt['shd_role_membergroups_desc'], '
			</div>
			<table class="table_grid">
				<tr class="title_bar">
					<td class="shd_33">', $txt['shd_role'], '</td>
					<td class="shd_33">', $txt['shd_badge_stars'], '</td>
					<td class="shd_33">', $txt['shd_assign_group'], '</td>
				</tr>';

	foreach ($context['membergroups'] as $id_group => $group)
	{
		echo '
				<tr class="windowbg">
					<td>', $group['link'], '</td>
					<td>';

		if (!empty($group['icons']))
		{
			$icons = explode('#', $group['icons']);
			if (!empty($icons[0]) && !empty($icons[1]))
				echo str_repeat('<img src="' . $settings['images_url'] . '/membericons/' . $icons[1] . '" alt="">', (int) $icons[0]);
		}

		echo '
					</td>
					<td><input type="checkbox" name="group', $id_group, '"', (in_array($id_group, $context['role_groups']) ? ' checked="checked"' : ''), '></td>
				</tr>
			</div>';
	}

	echo '
			</table>
			<br class="clear">
			<div class="floatleft" style="width: 100%;">
				<div class="cat_bar">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/departments.png" alt="*">
						', $txt['shd_role_departments'], '
					</h3>
				</div>
				<div class="information">
					', $txt['shd_role_departments_desc'], '
				</div>
				<table class="table_grid">
					<tr class="title_bar">
						<td class="shd_50">', $txt['shd_department_name'], '</td>
						<td class="shd_50">', $txt['shd_assign_dept'], '</td>
					</tr>';

	foreach ($context['role_depts'] as $id_dept => $dept)
		echo '
					<tr class="windowbg">
						<td>', $dept['dept_name'], '</td>
						<td><input type="checkbox" name="dept', $id_dept, '"', !empty($dept['is_role']) ? ' checked="checked"' : '', '></td>
					</tr>';

	echo '
				</table>
			</div>
			<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
			<input type="hidden" name="role" value="', $context['shd_role_id'], '">
			<input type="submit" value="', $txt['shd_edit_role'], '" accesskey="s" class="button save">
			<input type="submit" value="', $txt['shd_delete_role'], '" name="delete" class="button" id="delete">
		</form>

		<script type="text/javascript"><!-- // --><![CDATA[
			var oRoles = new shd_role({
				sPermissionDisallowClass: "shd_no",
				sPermissionAllowClass: "shd_yes",
				sPermissionAllowOwnClass: "shd_own",
				sPermissionAllowAnyClass: "shd_any",

				oHiddenBlocks: [', !empty($displayed_sets) ? '"' . implode('","', $displayed_sets) . '"' : '', '],
				sBlockHeader: "permheader_%block%",
				sBlockContent: "permcontent_%block%",
				sBlockFooter: "permfooter_%block%",
				sBlockIcon: "permexpandicon_%block%",
				sBlockIconExpandedImg: ', JavaScriptEscape($settings['images_url'] . '/selected_open.png'), ',
				sBlockIconCollapsedImg: ', JavaScriptEscape($settings['images_url'] . '/selected.png'), ',

				sDeleteContainerId: "delete",
				sDeleteConfirmText: ', JavaScriptEscape($txt['shd_delete_role_confirm']), ',
			});
		// ]]></script>';
}

/**
 *	Display the form to clone an existing role.
 *
 *	@since 2.0
*/
function template_shd_copy_role()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/permissions.png" class="icon" alt="*">
				', $txt['shd_admin_permissions'], '
			</h3>
		</div>
		<div class="information">
			', $txt['shd_admin_permissions_homedesc'], '
		</div>
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/position.png" alt="*">
				', $txt['shd_copy_role'], '
			</h3>
		</div>
		<div class="roundframe">
			<form action="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=copyrole;part=2" method="post">
				<dl class="settings">
					<dt><strong>', $txt['shd_create_based_on'], ':</strong></dt>
					<dd>
						<img alt="*" src="', $settings['default_images_url'], '/simpledesk/', $context['shd_permissions']['user_defined_roles'][$context['shd_role_id']]['template_icon'], '">
						', $context['shd_permissions']['user_defined_roles'][$context['shd_role_id']]['name'], '
					</dd>
					<dt><strong>', $txt['shd_create_name'], '</strong></dt>
					<dd><input type="text" name="rolename" id="rolename" value="" size="30"></dd>
					<dt><strong>', $txt['shd_copy_role_groups'], '</strong></dt>
					<dd><input type="checkbox" name="copygroups" id="copygroups" value="1"></dd>
				</dl>
				<input type="submit" value="', $txt['shd_copy_role'], '" accesskey="s" class="button save">
				<input type="hidden" name="role" value="', $context['shd_role_id'], '">
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
				<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '">
			</form>
		</div>';
}