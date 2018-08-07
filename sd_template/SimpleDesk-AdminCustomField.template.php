<?php
// Version: 2.1; SimpleDesk's administration/custom fields area

/**
 *	Displays SimpleDesk's administration for custom fields.
 *
 *	@package template
 *	@since 1.0
*/

function template_shd_custom_field_home()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/custom_fields.png" class="icon" alt="*">
				', $txt['shd_admin_custom_fields_long'], '
			</h3>
		</div>
		<div class="information">
			', $txt['shd_admin_custom_fields_desc'], '
		</div>
		<table class="table_grid">
			<tr class="title_bar">
				<td width="30%" colspan="2">
					<img src="', $settings['default_images_url'], '/simpledesk/name.png" class="icon" alt="*">
					', $txt['shd_admin_custom_fields_fieldname'], '
				</td>
				<td colspan="2">
					<img src="', $settings['default_images_url'], '/simpledesk/fieldtype.png" class="icon" alt="*">
					', $txt['shd_admin_custom_fields_fieldtype'], '
				</td>
				<td>', $txt['shd_admin_custom_fields_active'], '</td>
				<td>', $txt['shd_admin_custom_fields_visible'], '</td>
				<td>', $txt['shd_admin_custom_field_permissions'], '</td>
				<td colspan="2" width="1%">', $txt['shd_admin_custom_fields_move'], '</td>
				<td>', $txt['shd_actions'], '</td>
			</tr>';

	if (empty($context['custom_fields']))
		echo '
			<tr class="windowbg2">
				<td colspan="10">', $txt['shd_admin_no_custom_fields'], '</td>
			</tr>';
	else
	{
		foreach ($context['custom_fields'] as $field)
		{
			echo '
			<tr class="windowbg">
				<td width="2%">', empty($field['icon']) ? '' : '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '" class="icon" alt="*">', '</td>
				<td>', $field['field_name'], '<br><span class="smalltext">', $field['field_desc'], '</span></td>
				<td width="2%"><img src="' . $settings['default_images_url'] . '/simpledesk/cf_ui_' . $field['field_type'] . '.png" class="icon" alt="', $txt['shd_admin_custom_fields_ui_' . $field['field_type']], '"></td>
				<td>', $txt['shd_admin_custom_fields_ui_' . $field['field_type']], '</td>
				<td><img src="', $settings['default_images_url'], '/simpledesk/cf_', $field['active_string'], '.png" alt="', $txt['shd_admin_custom_fields_' . $field['active_string']], '" title="', $txt['shd_admin_custom_fields_' . $field['active_string']], '"></td>
				<td>
					', ($field['field_loc'] & CFIELD_TICKET) !== 0 ? ('<img src="' . $settings['default_images_url'] . '/simpledesk/ticket.png" alt="' . $txt['shd_admin_custom_fields_inticket'] . '" title="' . $txt['shd_admin_custom_fields_inticket'] . '">') : '', '
					', ($field['field_loc'] & CFIELD_REPLY) !== 0 ? ('<img src="' . $settings['default_images_url'] . '/simpledesk/replies.png" alt="' . $txt['shd_admin_custom_fields_inreply'] . '" title="' . $txt['shd_admin_custom_fields_inreply'] . '">') : '', '
				</td>
				<td>
					<strong>', $txt['shd_admin_custom_field_view'], ':</strong>
						', $field['can_see'][0] == 1 ? '<img src="' . $settings['default_images_url'] . '/simpledesk/user.png" class="icon" alt="*">' : '','
						', $field['can_see'][1] == 1 ? '<img src="' . $settings['default_images_url'] . '/simpledesk/staff.png" class="icon" alt="*">' : '','
						<img src="', $settings['default_images_url'], '/simpledesk/admin.png" class="icon" alt="*">
					&nbsp;&nbsp;&nbsp;
					<strong>', $txt['shd_admin_custom_field_edit'], ':</strong>
						', $field['can_edit'][0] == 1 ? '<img src="' . $settings['default_images_url'] . '/simpledesk/user.png" class="icon" alt="*">' : '','
						', $field['can_edit'][1] == 1 ? '<img src="' . $settings['default_images_url'] . '/simpledesk/staff.png" class="icon" alt="*">' : '','
						<img src="', $settings['default_images_url'], '/simpledesk/admin.png" class="icon" alt="*">
				</td>
				<td>', empty($field['is_first']) ? ('<a href="' . $scripturl . '?action=admin;area=helpdesk_customfield;sa=move;field=' . $field['id_field'] . ';direction=up;' . $context['session_var'] . '=' . $context['session_id'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/move_up.png" alt="' . $txt['shd_admin_move_up'] . '" title="' . $txt['shd_admin_move_up'] . '"></a>') : '', '</td>
				<td>', empty($field['is_last']) ? ('<a href="' . $scripturl . '?action=admin;area=helpdesk_customfield;sa=move;field=' . $field['id_field'] . ';direction=down;' . $context['session_var'] . '=' . $context['session_id'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/move_down.png" alt="' . $txt['shd_admin_move_down'] . '" title="' . $txt['shd_admin_move_down'] . '"></a>') : '', '</td>
				<td>
					<a href="', $scripturl, '?action=admin;area=helpdesk_customfield;sa=edit;field=', $field['id_field'], ';', $context['session_var'], '=', $context['session_id'], '"><img src="', $settings['default_images_url'], '/simpledesk/edit.png" class="icon" alt="', $txt['shd_ticket_edit'],'" title="', $txt['shd_ticket_edit'], '"></a>
					<a href="', $scripturl, '?action=admin;area=helpdesk_customfield;sa=save;field=', $field['id_field'], ';delete;', $context['session_var'], '=', $context['session_id'], '" onclick="return confirm(' . JavaScriptEscape($txt['shd_admin_delete_custom_field_confirm']). ');"><img src="', $settings['default_images_url'], '/simpledesk/delete.png" class="icon" alt="', $txt['shd_ticket_delete'],'" title="', $txt['shd_ticket_delete'], '"></a>
				</td>
			</tr>';
		}
	}

	echo '
		</table>
		<div class="flow_auto">
			<div class="floatright">
				<div class="additional_row">[<a href="', $scripturl, '?action=admin;area=helpdesk_customfield;sa=new">', $txt['shd_admin_new_custom_field'], '</a>]</div>
			</div>
		</div>';
}

function template_shd_custom_field_edit()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
				<script type="text/javascript"><!-- // --><![CDATA[
				function set_fieldicon(filename)
				{
					document.getElementById("cf_fieldicon_icon").style.background = "url(" + ', JavaScriptEscape($settings['default_images_url'] . '/simpledesk/cf/'), ' + filename + ") no-repeat left";
				}
				function update_field_type(ftype)
				{
					var icons = new Array();';
	foreach ($context['field_types'] as $field => $details)
	{
		list($field_desc, $class) = $details;
		echo '
					icons[', $field, '] = ', JavaScriptEscape('cf_ui_' . $class), ';';
	}

	echo '
					document.getElementById("cf_fieldtype_icon").setAttribute("class", icons[ftype]);

					document.getElementById("max_length_dt").style.display = ftype == ', CFIELD_TYPE_TEXT, ' || ftype == ', CFIELD_TYPE_LARGETEXT, ' ? "" : "none";
					document.getElementById("max_length_dd").style.display = ftype == ', CFIELD_TYPE_TEXT, ' || ftype == ', CFIELD_TYPE_LARGETEXT, ' ? "" : "none";
					document.getElementById("dimension_dt").style.display = ftype == ', CFIELD_TYPE_LARGETEXT, ' ? "" : "none";
					document.getElementById("dimension_dd").style.display = ftype == ', CFIELD_TYPE_LARGETEXT, ' ? "" : "none";
					document.getElementById("bbc_dt").style.display = ftype == ', CFIELD_TYPE_TEXT, ' || ftype == ', CFIELD_TYPE_LARGETEXT, ' ? "" : "none";
					document.getElementById("bbc_dd").style.display = ftype == ', CFIELD_TYPE_TEXT, ' || ftype == ', CFIELD_TYPE_LARGETEXT, ' ? "" : "none";
					document.getElementById("options_dt").style.display = ftype == ', CFIELD_TYPE_SELECT, ' || ftype == ', CFIELD_TYPE_RADIO, ' || ftype == ', CFIELD_TYPE_MULTI, ' ? "" : "none";
					document.getElementById("options_dd").style.display = ftype == ', CFIELD_TYPE_SELECT, ' || ftype == ', CFIELD_TYPE_RADIO, ' || ftype == ', CFIELD_TYPE_MULTI, ' ? "" : "none";
					document.getElementById("default_dt").style.display = ftype == ', CFIELD_TYPE_CHECKBOX, ' ? "" : "none";
					document.getElementById("default_dd").style.display = ftype == ', CFIELD_TYPE_CHECKBOX, ' ? "" : "none";

					var disp_radio = ftype != ', CFIELD_TYPE_MULTI, ' ? "" : "none";
					var disp_multi = ftype == ', CFIELD_TYPE_MULTI, ' ? "" : "none";
					for (i = 1; i <= startOptID; i++)
					{
						if (d = document.getElementById("radio_" + i))
						{
							d.style.display = disp_radio;
							document.getElementById("multi_" + i).style.display = disp_multi;
						}
					}
					document.getElementById("radio_0").style.display = disp_radio;
					document.getElementById("radio_text_0").style.display = disp_radio;
					document.getElementById("cf_options_radio_default").style.display = disp_radio;
					document.getElementById("cf_options_multi_default").style.display = disp_multi;';
	if (!empty($context['dept_fields']))
	{
		echo '
					var field_list = [', implode(',', array_keys($context['dept_fields'])), '];
					var cbstyle = ftype != ', CFIELD_TYPE_CHECKBOX, ' ? "" : "none";
					for (i = 0, n = field_list.length; i < n; i++)
					{
						document.getElementById("required_dept" + field_list[i] + "_span").style.display = "";
						document.getElementById("required_dept" + field_list[i]).style.display = ftype == ', CFIELD_TYPE_MULTI, ' ? "none" : "";
						document.getElementById("required_dept_multi_" + field_list[i]).style.display = ftype != ', CFIELD_TYPE_MULTI, ' ? "none" : "";
					}';
	}
	echo '
				}
				function updateDeptHidden(id)
				{
					var state = !document.getElementById("present_dept" + id).checked;
					document.getElementById("required_dept" + id).disabled = state;
					document.getElementById("required_dept_multi_" + id).disabled = state;
				}
				var startOptID = ', !empty($context['custom_field']['options']['order']) ? count($context['custom_field']['options']['order']) + 1 : 1, ';
				function add_option()
				{
					var ftype = document.getElementById("cf_fieldtype").value;
					var newHTML = \'<br id="break_\' + startOptID + \'"><input type="radio" id="radio_\' + startOptID + \'" name="default_select" value="\' + startOptID + \'" id="\' + startOptID + \'"\';
					if (ftype == ', CFIELD_TYPE_MULTI, ')
						newHTML += \' style="display:none;"\';
					newHTML += \' >\' + "\n";
					newHTML += \'<input type="checkbox" id="multi_\' + startOptID + \'" name="default_select_multi[\' + startOptID + \']" value="\' + startOptID + \'"\';
					if (ftype != ', CFIELD_TYPE_MULTI, ')
						newHTML += \' style="display:none;"\';
					newHTML += \' ><input type="text" id="option_\' + startOptID + \'" name="select_option[\' + startOptID + \']" value="" >\' + "\n";
					newHTML += \'<span id="order_\' + startOptID + \'" class="custom_field_order"><input id="order_\' + startOptID + \'_input" type="hidden" name="order[\' + startOptID + \']" value="\' + (startOptID - 1) + \'" data-key="\' + startOptID + \'">\' + "\n";
					newHTML += \'<a href="#" class="custom_field_move_up" data-key="\' + startOptID + \'"><img src="', $settings['default_images_url'], '/simpledesk/move_up.png" class="icon" alt="', $txt['custom_edit_order_up'], '" title="', $txt['custom_edit_order_up'], '"/></a>\';
					newHTML += \'<a href="#" class="custom_field_move_down" data-key="\' + startOptID + \'"><img src="', $settings['default_images_url'], '/simpledesk/move_down.png" class="icon" alt="', $txt['custom_edit_order_down'], '" title="', $txt['custom_edit_order_down'], '"/></a>\';
					newHTML += \'</span>\' + "\n";

					newHTML += \'<span id="addopt"></span>\';

					setOuterHTML(document.getElementById("addopt"), newHTML);
					startOptID++;

					optionsOrder.resortNew();
				}
				function update_default_label(defstate)
				{
					if (defstate)
						document.getElementById("default_label").innerHTML = "', $txt['shd_admin_default_state_on'],'";
					else
						document.getElementById("default_label").innerHTML = "', $txt['shd_admin_default_state_off'],'";
				}
				function update_required(state)
				{
					if (state)
					{
						document.getElementById("cf_display_empty").disabled = "disabled";
						document.getElementById("cf_display_empty").checked = "";
						document.getElementById("display_empty_dt").className = "disabled";
					}
					else
					{
						document.getElementById("cf_display_empty").disabled = "";
						document.getElementById("display_empty_dt").className = "";
					}
				}
				function update_permissions(state,role)
				{
					document.getElementById("edit_" + role).disabled = state == "on" ? "" : "disabled";
					document.getElementById("edit_" + role).checked = state == "on" ? "" : "";
				}
				function update_field_location(loc)
				{
					document.getElementById("placement_dt").style.display = loc == ', CFIELD_TICKET, ' || loc == ', (CFIELD_TICKET | CFIELD_REPLY), ' ? "" : "none";
					document.getElementById("placement_dd").style.display = loc == ', CFIELD_TICKET, ' || loc == ', (CFIELD_TICKET | CFIELD_REPLY), ' ? "" : "none";
				}
				// ]', ']></script>
				<form action="', $scripturl, '?action=admin;area=helpdesk_customfield;sa=save', !empty($context['new_field']) ? ';new' : '', '" method="post">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/custom_fields.png" class="icon" alt="*">
							', $context['section_title'], '
						</h3>
					</div>
					<div class="information">
							', $context['section_desc'],'
					</div>
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/name.png" alt="*">
							', $txt['shd_admin_custom_fields_general'], '
						</h3>
					</div>
					<div class="roundframe">
						<dl class="settings">
							<dt><strong>', $txt['shd_admin_custom_fields_fieldname'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_fields_fieldname_desc'], '</span></dt>
							<dd><input type="text" name="field_name" id="cf_fieldname"', !empty($context['custom_field']['field_name']) ? ' value="' . $context['custom_field']['field_name'] . '"' : '', '  size="30"></dd>
							<dt><strong>', $txt['shd_admin_custom_fields_description'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_fields_description_desc'], '</span></dt>
							<dd><textarea name="description" id="cf_description" cols="40" rows="4">', !empty($context['custom_field']['field_desc']) ? $context['custom_field']['field_desc'] : '', '</textarea></dd>
							<dt><strong>', $txt['shd_admin_custom_fields_active'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_fields_active_desc'], '</span></dt>
							<dd><input type="checkbox" name="active" id="cf_active"', $context['field_active'],'></dd>
							<dt><strong>', $txt['shd_admin_custom_fields_icon'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_fields_icon_desc'], '</span></dt>
							<dd class="nowrap">
								<span id="cf_fieldicon_icon"', $context['field_icon_value'] != '' ? ' style="background: url(' . $settings['images_url'] . '/simpledesk/cf/' . $context['field_icon_value'] . ') no-repeat left;"' : '','></span>
								<select name="field_icon" id="cf_fieldicon" onchange="javascript:set_fieldicon(this.value);">';

	foreach ($context['field_icons'] as $icon)
	{
		list($file, $desc) = $icon;
		echo '
									<option value="', $file, '"', $context['field_icon_value'] == $file ? ' selected="selected"' : '','>', $desc, '</option>';
	}

	echo '
								</select>
							</dd>
							<dt><strong>', $txt['shd_admin_custom_fields_visible'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_fields_visible_desc'], '</span></dt>
							<dd>
								<span id="cf_fieldvisible_icon"></span>
								<select name="field_visible" id="cf_fieldvisible" onchange="javascript:update_field_location(this.value);">
									<option value="', CFIELD_TICKET, '"',($context['field_loc'] == CFIELD_TICKET ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_fields_visible_ticket'], '</option>
									<option value="', CFIELD_REPLY, '"',($context['field_loc'] == CFIELD_REPLY ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_fields_visible_field'], '</option>
									<option value="', (CFIELD_TICKET | CFIELD_REPLY), '"',($context['field_loc'] == (CFIELD_TICKET | CFIELD_REPLY) ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_fields_visible_both'], '</option>
								</select>
							</dd>
							<dt id="placement_dt"', (($context['field_loc'] == CFIELD_TICKET || $context['field_loc'] == (CFIELD_TICKET | CFIELD_REPLY)) ? '' : ' style="display: none;"'), '><strong>', $txt['shd_admin_custom_field_placement'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_field_placement_desc'], '</span></dt>
							<dd id="placement_dd"', (($context['field_loc'] == CFIELD_TICKET || $context['field_loc'] == (CFIELD_TICKET | CFIELD_REPLY)) ? '' : ' style="display: none;"'), '>
								<select name="placement" id="cf_placement">
									<option id="details" value="', CFIELD_PLACE_DETAILS, '"', ($context['placement'] == CFIELD_PLACE_DETAILS ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_field_placement_details'], '</option>
									<option id="place_info" value="', CFIELD_PLACE_INFO, '"', ($context['placement'] == CFIELD_PLACE_INFO ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_field_placement_information'], '</option>
									<option id="place_prefix" value="', CFIELD_PLACE_PREFIX, '"', ($context['placement'] == CFIELD_PLACE_PREFIX ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_field_placement_prefix'], '</option>
									<option id="place_prefixfilter" value="', CFIELD_PLACE_PREFIXFILTER, '"', ($context['placement'] == CFIELD_PLACE_PREFIXFILTER ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_field_placement_prefixfilter'], '</option>
								</select>
							</dd>
							<dt><strong>', $txt['shd_admin_custom_field_can_see'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_field_can_see_desc'], '</span></dt>
							<dd>
								<input type="checkbox" name="see_users"  ', !empty($context['custom_field']['can_see'][0]) && $context['custom_field']['can_see'][0] == 1 ? 'checked="checked"' : '' ,' onchange="javascript:update_permissions(this.value,\'users\');"/> <img src="', $settings['default_images_url'], '/simpledesk/user.png" class="icon" alt="', $txt['shd_admin_custom_field_users'], '" title="', $txt['shd_admin_custom_field_users'], '"/>
								<input type="checkbox" name="see_staff"  ', !empty($context['custom_field']['can_see'][1]) && $context['custom_field']['can_see'][1] == 1 ? 'checked="checked"' : '' ,' onchange="javascript:update_permissions(this.value,\'staff\');"/> <img src="', $settings['default_images_url'], '/simpledesk/staff.png" class="icon" alt="', $txt['shd_admin_custom_field_staff'], '" title="', $txt['shd_admin_custom_field_staff'], '"/>
								<input type="checkbox" name="see_admin"  checked="checked" disabled="disabled"> <img src="', $settings['default_images_url'], '/simpledesk/admin.png" class="icon" alt="', $txt['shd_admin_custom_field_admins'], '" title="', $txt['shd_admin_custom_field_admins'], '">
							</dd>
							<dt><strong>', $txt['shd_admin_custom_field_can_edit'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_field_can_edit_desc'], '</span></dt>
							<dd>
								<input type="checkbox" name="edit_users" id="edit_users"  ', !empty($context['custom_field']['can_edit'][0]) && $context['custom_field']['can_edit'][0] == 1 ? 'checked="checked"' : '', ' ', !empty($context['custom_field']['can_see'][0]) && $context['custom_field']['can_see'][0] == 1 ? '"' : 'disabled="disabled"', '/> <img src="', $settings['default_images_url'], '/simpledesk/user.png" class="icon" alt="', $txt['shd_admin_custom_field_users'], '" title="', $txt['shd_admin_custom_field_users'], '"/>
								<input type="checkbox" name="edit_staff" id="edit_staff"  ', !empty($context['custom_field']['can_edit'][1]) && $context['custom_field']['can_edit'][1] == 1 ? 'checked="checked"' : '', ' ', !empty($context['custom_field']['can_see'][1]) && $context['custom_field']['can_see'][1] == 1 ? '"' : 'disabled="disabled"', '/> <img src="', $settings['default_images_url'], '/simpledesk/staff.png" class="icon" alt="', $txt['shd_admin_custom_field_staff'], '" title="', $txt['shd_admin_custom_field_staff'], '"/>
								<input type="checkbox" name="edit_admin"  checked="checked" disabled="disabled"> <img src="', $settings['default_images_url'], '/simpledesk/admin.png" class="icon" alt="', $txt['shd_admin_custom_field_admins'], '" title="', $txt['shd_admin_custom_field_admins'], '"/>
							</dd>
						</dl>
					</div>
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/fieldtype.png" alt="*">
							', $txt['shd_admin_custom_fields_fieldtype'], '
						</h3>
					</div>
					<div class="roundframe">
						<dl class="settings">
							<dt><strong>', $txt['shd_admin_custom_fields_fieldtype'], ':</strong></dt>
							<dd>
								<span id="cf_fieldtype_icon" class="cf_ui_', $context['field_types'][$context['field_type_value']][1], '"></span>
								<select name="field_type" id="cf_fieldtype" onchange="javascript:update_field_type(this.value);">';

	foreach ($context['field_types'] as $field => $details)
	{
		list($field_desc,) = $details;
		echo '
									<option value="', $field, '"', ($context['field_type_value'] == $field ? ' selected="selected"' : ''), '>', $field_desc, '</option>';
	}

	echo '
								</select>
							</dd>
							<dt id="max_length_dt"', in_array($context['field_type_value'], array(CFIELD_TYPE_TEXT, CFIELD_TYPE_LARGETEXT)) ? '' : ' style="display: none;"','><strong>', $txt['shd_admin_custom_field_maxlength'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_field_maxlength_desc'], '</span></dt>
							<dd id="max_length_dd"', in_array($context['field_type_value'], array(CFIELD_TYPE_TEXT, CFIELD_TYPE_LARGETEXT)) ? '' : ' style="display: none;"','>
								<input type="text" value="', isset($context['custom_field']['field_length']) ? $context['custom_field']['field_length'] : 255, '" size="7" maxlength="6" name="field_length" id="cf_field_length">
							</dd>
							<dt id="dimension_dt"', $context['field_type_value'] == CFIELD_TYPE_LARGETEXT ? '' : ' style="display: none;"','>
								<strong>', $txt['shd_admin_custom_field_dimensions'], ':</strong>
							</dt>
							<dd id="dimension_dd"', $context['field_type_value'] == CFIELD_TYPE_LARGETEXT ? '' : ' style="display: none;"','>
								<strong>', $txt['shd_admin_custom_field_dimensions_rows'], ':</strong> <input type="text" name="rows" value="', !empty($context['custom_field']['dimensions'][0]) ? $context['custom_field']['dimensions'][0] : 4, '" size="5" maxlength="3" >
								<strong>', $txt['shd_admin_custom_field_dimensions_columns'], ':</strong> <input type="text" name="cols" value="', !empty($context['custom_field']['dimensions'][1]) ? $context['custom_field']['dimensions'][1] : 30, '" size="5" maxlength="3" >
							</dd>
							<dt id="bbc_dt"', $context['field_type_value'] == CFIELD_TYPE_TEXT || $context['field_type_value'] == CFIELD_TYPE_LARGETEXT ? '' : ' style="display: none;"','><strong',empty($modSettings['shd_allow_ticket_bbc']) ? ' class="disabled"' : '', '>', $txt['shd_admin_custom_field_bbc'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_field_bbc_note'], '</span><br>', empty($modSettings['shd_allow_ticket_bbc']) ? '<span class="smalltext error">' . sprintf($txt['shd_admin_custom_field_bbc_off'], $scripturl . '?action=admin;area=helpdesk_options;sa=posting'). '</span>' : '', '</dt>
							<dd id="bbc_dd"', $context['field_type_value'] == CFIELD_TYPE_TEXT || $context['field_type_value'] == CFIELD_TYPE_LARGETEXT ? '' : ' style="display: none;"','>
								<input type="checkbox" name="bbc" id="cf_bbc"',empty($modSettings['shd_allow_ticket_bbc']) ? ' disabled="disabled"' : (!empty($context['custom_field']['bbc']) ? ' checked="checked"' : ''), '>
							</dd>
							<dt id="options_dt"', in_array($context['field_type_value'], array(CFIELD_TYPE_SELECT, CFIELD_TYPE_RADIO, CFIELD_TYPE_MULTI)) ? '' : ' style="display: none;"','>
								<strong>', $txt['shd_admin_custom_field_options'], ':</strong>
								<div class="smalltext">
									', $txt['shd_admin_custom_field_options_desc'], '
									<span id="cf_options_radio_default"', $context['field_type_value'] == CFIELD_TYPE_SELECT || $context['field_type_value'] == CFIELD_TYPE_RADIO ? ' style=""' : ' style="display:none;"', '>', $txt['shd_admin_custom_field_options_radio'], '</span>
									<span id="cf_options_multi_default"', $context['field_type_value'] == CFIELD_TYPE_MULTI ? ' style=""' : ' style="display:none;"', '>', $txt['shd_admin_custom_field_options_multi'], '</span>
								</div>
							</dt>
							<dd id="options_dd"', in_array($context['field_type_value'], array(CFIELD_TYPE_SELECT, CFIELD_TYPE_RADIO, CFIELD_TYPE_MULTI)) ? '' : ' style="display: none;"','>								
								<input type="radio" id="radio_0" name="default_select" value="0"', $context['custom_field']['default_value'] == 0 ? ' checked="checked"' : '', $context['field_type_value'] != CFIELD_TYPE_MULTI ? '' : ' style="display:none;"', ' >
								<span id="radio_text_0"', $context['field_type_value'] != CFIELD_TYPE_MULTI ? '' : ' style="display:none;"', '>', $txt['shd_admin_custom_field_no_selected_default'], '</span>
								<div id="custom_fields_list">';

	// Convert it to an array for displaying the main doodah
	if ($context['field_type_value'] == CFIELD_TYPE_MULTI)
		$context['custom_field']['default_value'] = explode(',', $context['custom_field']['default_value']);

	foreach ($context['custom_field']['options']['order'] as $order => $k)
	{
		if ($k == 'order' || $k == 'inactive' || in_array($k, $context['custom_field']['options']['inactive']))
			continue;
		$option = $context['custom_field']['options'][$k];

		echo '
									<br id="break_', $k, '">
									<input type="radio" id="radio_', $k, '" name="default_select" value="', $k, '"', $context['field_type_value'] != CFIELD_TYPE_MULTI && $context['custom_field']['default_value'] == $k ? ' checked="checked"' : '', $context['field_type_value'] != CFIELD_TYPE_MULTI ? '' : ' style="display:none;"', ' >
									<input type="checkbox" id="multi_', $k, '" name="default_select_multi[', $k, ']" value="', $k, '"', $context['field_type_value'] == CFIELD_TYPE_MULTI && in_array($k, $context['custom_field']['default_value']) ? ' checked="checked"' : '', $context['field_type_value'] == CFIELD_TYPE_MULTI ? '' : ' style="display:none;"', ' >
									<input type="text" id="option_', $k, '" name="select_option[', $k, ']" value="', $option, '">
									<span id="order_', $k, '" class="custom_field_order"><input id="order_', $k, '_input" type="hidden" name="order[', $k, ']" value="', $order, '" data-key="', $k, '">';

			echo '<a href="#" class="custom_field_move_up" data-key="', $k, '"', $context['custom_field']['order_first'] == $k ? ' style="display:none;"' : '', '><img src="', $settings['default_images_url'], '/simpledesk/move_up.png" class="icon" alt="', $txt['custom_edit_order_up'], '" title="', $txt['custom_edit_order_up'], '"/></a>';
			echo '<a href="#" class="custom_field_move_down" data-key="', $k, '"', $context['custom_field']['order_last'] == $k ? ' style="display:none;"' : '', '><img src="', $settings['default_images_url'], '/simpledesk/move_down.png" class="icon" alt="', $txt['custom_edit_order_down'], '" title="', $txt['custom_edit_order_down'], '"/></a>';

		echo '</span>';

	}

	echo '
								<span id="addopt"></span>
								</div>
								<span id="addopt_link">[<a href="" onclick="add_option(); return false;">', $txt['more'], '</a>]</span>
							</dd>
							<dt id="default_dt"', $context['field_type_value'] == CFIELD_TYPE_CHECKBOX ? '' : ' style="display: none;"','>
								<strong>', $txt['shd_admin_custom_field_default_state'], ':</strong>
							</dt>
							<dd id="default_dd"', $context['field_type_value'] == CFIELD_TYPE_CHECKBOX ? '' : ' style="display: none;"', '>
								<input type="checkbox" name="default_check" ',($context['custom_field']['default_value'] == 1 ? ' checked="checked"' : ''), ' onclick="update_default_label(this.checked);">
								<span class="smalltext" id="default_label">', $txt['shd_admin_default_state_' . ($context['custom_field']['default_value'] == 1 ? 'on' : 'off')], '</span>
							</dd>
							<dt id="display_empty_dt"><strong>', $txt['shd_admin_custom_field_display_empty'], ':</strong><br><span class="smalltext">', $txt['shd_admin_custom_field_display_empty_desc'], '</span></dt>
							<dd id="display_empty_dd">
								<input type="checkbox" ', (!empty($context['custom_field']['display_empty']) && $context['custom_field']['display_empty'] == 1 ? ' checked="checked"' : ''), ' name="display_empty" id="cf_display_empty"', (!empty($context['custom_field']['required']) && $context['custom_field']['required'] == 1 ? ' disabled="disabled"' : ''), '/>
							</dd>
						</dl>
					</div>';

	if (!empty($context['dept_fields']))
	{
		echo '
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/departments.png" alt="*">
							', $txt['shd_admin_custom_field_department'], '
						</h3>
					</div>
					<div class="roundframe">
						<dl class="settings">';
		foreach ($context['dept_fields'] as $id => $row)
			echo '
							<dt id="required_dt', $id, '"><strong>', $row['dept_name'], '</strong></dt>
							<dd id="required_dd', $id, '">
								<span id="present_dept', $id, '_span">', $txt['shd_admin_custom_field_dept_applies'], ': <input type="checkbox" name="present_dept', $id, '" id="present_dept', $id, '" ', !empty($row['present']) ? ' checked="checked"' : '', ' onclick="updateDeptHidden(', $id, ');"></span>
								<span id="required_dept', $id, '_span">', $txt['shd_admin_custom_field_dept_required'], ':
									<input type="checkbox" name="required_dept', $id, '" id="required_dept', $id, '" ', !empty($row['required']) ? ' checked="checked"' : '', empty($row['present']) ? ' disabled="disabled"' : '', $context['field_type_value'] != CFIELD_TYPE_MULTI ? '' : ' style="display: none;"', '>
									<input type="text" name="required_dept_multi_', $id, '" id="required_dept_multi_', $id, '"  size="3" maxlength="3" value="', $row['required'], '"', empty($row['present']) ? ' disabled="disabled"' : '', $context['field_type_value'] == CFIELD_TYPE_MULTI ? '' : ' style="display: none;"', '>
								</span>
							</dd>';

		echo '
						</dl>
					</div>';
	}

	echo '
					<br>
					<input type="submit" value="', $txt['shd_admin_save_custom_field'], '" accesskey="s" class="button">
					', !empty($context['new_field']) ? '' : '<input type="submit" value="' .$txt['shd_admin_delete_custom_field'] . '" onclick="return confirm(' . JavaScriptEscape($txt['shd_admin_delete_custom_field_confirm']). ');" name="delete" class="button">', '
					<input type="submit" value="', $txt['shd_admin_cancel_custom_field'], '" name="cancel" class="button">
					<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
					<input type="hidden" name="field" value="', empty($context['custom_field']['id_field']) ? 0 : $context['custom_field']['id_field'], '">
				</form>

	<script type="text/javascript">
		var optionsOrder = new shd_custom_field_order({});
	</script>';
}