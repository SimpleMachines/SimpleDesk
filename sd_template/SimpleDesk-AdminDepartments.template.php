<?php
// Version: 1.0 Felidae; SimpleDesk's administration/departments area

/**
 *	Displays SimpleDesk's administration for departments - front page, listing the departments, plus the create/edit dialogs.
 *
 *	@package template
 *	@since 1.1
*/

/**
 *	Display the front page of the SimpleDesk departments.
 *
 *	@since 1.1
*/
function template_shd_departments_home()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar grid_header">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/departments.png" class="icon" alt="*">
							', $txt['shd_admin_departments_home'], '
						</h3>
					</div>
					<p class="description shd_actionloginfo">
						', $txt['shd_admin_departments_homedesc'], '
					</p>
					<table class="shd_ticketlist" cellspacing="0" width="100%">
						<tbody><tr class="titlebg">
							<td width="2%"></td>
							<td width="25%" class="shd_nowrap">
								', $txt['shd_department'], '
							</td>
							<td>', $txt['shd_dept_boardindex'], '</td>
							<td width="40%" class="shd_nowrap">
								', $txt['shd_roles_in_dept'], '
							</td>
						</tr>';

	$use_bg2 = true;
	foreach ($context['shd_departments'] as $department)
	{
		echo '
						<tr class="windowbg', $use_bg2 ? '2' : '', '">
							<td></td>
							<td>
								', $department['dept_name'], '
								<div class="smalltext">[<a href="', $scripturl, '?action=admin;area=helpdesk_depts;sa=editdept;dept=', $role['id_dept'], '">', $txt['shd_edit_dept'], '</a>]</div></td>
							<td>';

		if (!empty($department['cat_name']))
			echo '
								', $txt['shd_dept_inside_category'], ': ', $department['cat_name'], '
								<div class="smalltext">', empty($department['before_after']) ? $txt['shd_dept_cat_before_boards'] : $txt['shd_dept_cat_after_boards'], '</div>';
		else
			echo '
								', $txt['shd_dept_no_boardindex'];

		echo '
							</td>
							<td>';

		if (!empty($department['roles']))
		{
			$first = true;
			foreach ($department['roles'] as $role)
			{
				if (!$first)
					echo ', ';
				else
					$first = false;

				echo '
								<span class="shd_nowrap"><img src="', $settings['default_images_url'], '/simpledesk/', $context['shd_permissions']['roles'][$role['template']]['icon'], '" class="icon" alt="*">
								<a href="', $scripturl, '?action=admin;area=helpdesk_permissions;sa=editrole;role=', $role['id_role'], '">', $role['role_name'], '</a></span>';
			}
		}
		else
			echo '
								', $txt['shd_no_roles_in_dept'];

		echo '
							</td>
						</tr>';
		$use_bg2 = !$use_bg2;
	}

	echo '
					</table>
					<div class="flow_auto">
						<div class="floatright">
							<div class="additional_row">[<a href="', $scripturl, '?action=admin;area=helpdesk_depts;sa=createdept">', $txt['shd_create_dept'], '</a>]</div>
						</div>
					</div>
				</div>';
}

function template_shd_create_dept()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/departments.png" class="icon" alt="*" />
							', $txt['shd_admin_departments_home'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_departments_homedesc'], '
					</p>
				</div>
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/position.png" alt="*" />
						', $txt['shd_create_dept'], '
					</h3>
				</div>
				<div class="roundframe">
					<form action="', $scripturl, '?action=admin;area=helpdesk_depts;sa=createdept;part=2" method="post">
						<div class="content">
							<dl class="settings">
								<dt><strong>', $txt['shd_new_dept_name'], '</strong></dt>
								<dd><input type="text" name="dept_name" id="dept_name" value="" class="input_text" size="30" /></dd>
								<dt><strong>', $txt['shd_dept_boardindex_cat'], '</strong></dt>
								<dd>
									<select name="dept_cat" id="dept_cat" onchange="document.getElementById(\'dept_beforeafter\').disabled = (this.value == 0);">';
	foreach ($context['shd_cat_list'] as $id_cat => $cat_name)
		echo '
										<option value="', $id_cat, '">', $cat_name, '</option>';

	echo '
									</select>
								</dd>
								<dt><strong>', $txt['shd_boardindex_cat_where'], '</strong></dt>
								<dd>
									<select name="dept_beforeafter" id="dept_beforeafter" disabled="disabled">
										<option value="0">', $txt['shd_boardindex_cat_before'], '</option>
										<option value="1">', $txt['shd_boardindex_cat_after'], '</option>
									</select>
								</dd>
							</dl>
						</div>
						<input type="submit" value="', $txt['shd_create_dept'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
					</form>
				</div>
				<span class="lowerframe"><span></span></span>';
}

?>