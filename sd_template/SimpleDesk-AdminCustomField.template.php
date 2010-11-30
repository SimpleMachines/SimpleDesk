<?php
// Version: 1.0 Felidae; SimpleDesk's administration/custom fields area

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
				<div class="tborder">
					<div class="cat_bar grid_header">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/custom_fields.png" class="icon" alt="*" />
							', $txt['shd_admin_custom_fields_long'], '
						</h3>
					</div>
					<p class="description shd_actionloginfo">
						', $txt['shd_admin_custom_fields_desc'], '
					</p>
					<table class="shd_ticketlist" cellspacing="0" width="100%">
						<tr class="titlebg">
							<td width="30%" colspan="2">
								<img src="', $settings['default_images_url'], '/simpledesk/name.png" class="icon" alt="*" />
								', $txt['shd_admin_custom_fields_fieldname'], '
							</td>
							<td colspan="2">
								<img src="', $settings['default_images_url'], '/simpledesk/fieldtype.png" class="icon" alt="*" />
								', $txt['shd_admin_custom_fields_fieldtype'], '
							</td>
							<td>', $txt['shd_admin_custom_fields_active'], '</td>
							<td>', $txt['shd_admin_custom_fields_visible'], '</td>
							<td colspan="2" width="1%" class="shd_nowrap">', $txt['shd_admin_custom_fields_move'], '</td>
							<td class="shd_nowrap">
								<img src="', $settings['default_images_url'], '/simpledesk/edit.png" class="icon" alt="*" />
								', $txt['shd_ticket_edit'], '
							</td>
						</tr>';

	if (empty($context['custom_fields']))
		echo '
						<tr class="windowbg2">
							<td colspan="9">', $txt['shd_admin_no_custom_fields'], '</td>
						</tr>';
	else
	{
		$use_bg2 = true;
		foreach ($context['custom_fields'] as $field)
		{
			echo '
						<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
							<td>', empty($field['icon']) ? '' : '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '.png" class="icon" alt="*" />', '</td>
							<td>', $field['field_name'], '</td>
							<td><img src="' . $settings['default_images_url'] . '/simpledesk/cf_ui_' . $field['field_type'] . '.png" class="icon" alt="', $txt['shd_admin_custom_fields_ui_' . $field['field_type']], '" /></td>
							<td>', $txt['shd_admin_custom_fields_ui_' . $field['field_type']], '</td>
							<td><img src="', $settings['default_images_url'], '/simpledesk/cf_', $field['active_string'], '.png" alt="', $txt['shd_admin_custom_fields_' . $field['active_string']], '" title="', $txt['shd_admin_custom_fields_' . $field['active_string']], '" /></td>
							<td class="shd_nowrap">
								', ($field['field_loc'] & CFIELD_TICKET) !== 0 ? ('<img src="' . $settings['default_images_url'] . '/simpledesk/ticket.png" alt="' . $txt['shd_admin_custom_fields_inticket'] . '" title="' . $txt['shd_admin_custom_fields_inticket'] . '" />') : '', '
								', ($field['field_loc'] & CFIELD_REPLY) !== 0 ? ('<img src="' . $settings['default_images_url'] . '/simpledesk/replies.png" alt="' . $txt['shd_admin_custom_fields_inreply'] . '" title="' . $txt['shd_admin_custom_fields_inreply'] . '" />') : '', '
							</td>
							<td>', empty($field['is_first']) ? ('<a href="' . $scripturl . '?action=admin;area=helpdesk_customfield;sa=move;field=' . $field['id_field'] . ';direction=up;' . $context['session_var'] . '=' . $context['session_id'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/move_up.png" alt="' . $txt['shd_admin_move_up'] . '" title="' . $txt['shd_admin_move_up'] . '" /></a>') : '', '</td>
							<td>', empty($field['is_last']) ? ('<a href="' . $scripturl . '?action=admin;area=helpdesk_customfield;sa=move;field=' . $field['id_field'] . ';direction=down;' . $context['session_var'] . '=' . $context['session_id'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/move_down.png" alt="' . $txt['shd_admin_move_down'] . '" title="' . $txt['shd_admin_move_down'] . '" /></a>') : '', '</td>
							<td><a href="', $scripturl, '?action=admin;area=helpdesk_customfield;sa=edit;field=', $field['id_field'], ';', $context['session_var'], ';', $context['session_id'], '">', $txt['shd_ticket_edit'], '</a></td>
						</tr>';

			$use_bg2 = !$use_bg2;
		}
	}

	echo '
					</table>
					<div class="flow_auto">
						<div class="floatright">
							<div class="additional_row">[<a href="', $scripturl, '?action=admin;area=helpdesk_customfield;sa=new">', $txt['shd_admin_new_custom_field'], '</a>]</div>
						</div>
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
					
					document.getElementById("max_length_dt").style.display = ftype == 1 || ftype == 2 || ftype == 3 || ftype == 4 ? "" : "none";
					document.getElementById("max_length_dd").style.display = ftype == 1 || ftype == 2 || ftype == 3 || ftype == 4 ? "" : "none";					
					document.getElementById("dimension_dt").style.display = ftype == 2 ? "" : "none";
					document.getElementById("dimension_dd").style.display = ftype == 2 ? "" : "none";
					document.getElementById("bbc_dt").style.display = ftype == 1 || ftype == 2 ? "" : "none";
					document.getElementById("bbc_dd").style.display = ftype == 1 || ftype == 2 ? "" : "none";
					document.getElementById("options_dt").style.display = ftype == 5 || ftype == 7 ? "" : "none";
					document.getElementById("options_dd").style.display = ftype == 5 || ftype == 7 ? "" : "none";
					document.getElementById("default_dt").style.display = ftype == 6 ? "" : "none";
					document.getElementById("default_dd").style.display = ftype == 6 ? "" : "none";
				}	
				var startOptID = 3;
				function add_option()
				{
					setOuterHTML(document.getElementById("addopt"), \'<br /><input type="radio" name="default_select" value="\' + startOptID + \'" id="\' + startOptID + \'" class="input_radio" /><input type="text" name="select_option[\' + startOptID + \']" value="" class="input_text" /><span id="addopt"></span>\');
					startOptID++;
				}
				function update_default_label(defstate)
				{
					if(defstate == "on")
						document.getElementById("default_label").innerHTML = "',$txt['shd_admin_default_state_on'],'";
					else
						document.getElementById("default_label").innerHTML = "',$txt['shd_admin_default_state_off'],'";
				}
				// ]', ']></script>
				<form action="', $scripturl, '?action=admin;area=helpdesk_customfield;sa=save',!empty($context['new_field']) ? ';new' : '','" method="post">
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/custom_fields.png" class="icon" alt="*" />
							', $context['section_title'], '
						</h3>
					</div>
					<p class="description">
						',$context['section_desc'],'
					</p>
				</div>
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/name.png" alt="*" />
						', $txt['shd_admin_custom_fields_general'], '
					</h3>
				</div>
				<div class="roundframe">
					<div class="content">
						<dl class="settings">
							<dt><strong>', $txt['shd_admin_custom_fields_fieldname'], ':</strong><br /><span class="smalltext">', $txt['shd_admin_custom_fields_fieldname_desc'], '</span></dt>
							<dd><input type="text" name="fieldname" id="cf_fieldname"',!empty($context['custom_field']['field_name']) ? ' value="' . $context['custom_field']['field_name'] . '"' : '',' class="input_text" size="30" /></dd>
							<dt><strong>', $txt['shd_admin_custom_fields_description'], ':</strong><br /><span class="smalltext">', $txt['shd_admin_custom_fields_description_desc'], '</span></dt>
							<dd><textarea name="description" id="cf_description" cols="40" rows="4">',!empty($context['custom_field']['field_desc']) ? $context['custom_field']['field_desc'] : '','</textarea></dd>							
							<dt><strong>', $txt['shd_admin_custom_fields_active'], ':</strong><br /><span class="smalltext">', $txt['shd_admin_custom_fields_active_desc'], '</span></dt>
							<dd><input type="checkbox" name="active" id="cf_active" checked="',(!empty($context['custom_field']['active']) ? ($context['custom_field']['active'] == 1 ? 'true' : 'false') : 'true'), '" class="input_check" /></dd>
							<dt><strong>', $txt['shd_admin_custom_fields_icon'], ':</strong><br /><span class="smalltext">', $txt['shd_admin_custom_fields_icon_desc'], '</span></dt>
							<dd class="nowrap">
								<span id="cf_fieldicon_icon"></span>
								<select name="cf_fieldicon" id="cf_fieldicon" onchange="javascript:set_fieldicon(this.value);">';

	foreach ($context['field_icons'] as $icon)
	{
		list($file, $desc) = $icon;
		$path = $settings['default_theme_dir'] . '/images/simpledesk/' . $file;
		echo '
									<option value="', $file, '">', $desc, '</option>';
	}

	echo '
								</select>
							</dd>
							<dt><strong>', $txt['shd_admin_custom_fields_visible'], ':</strong><br /><span class="smalltext">', $txt['shd_admin_custom_fields_visible_desc'], '</span></dt>
							<dd>
								<span id="cf_fieldvisible_icon"></span>
								<select name="cf_fieldvisible" id="cf_fieldvisible">
									<option value="', CFIELD_TICKET, '"',($context['field_loc'] == CFIELD_TICKET ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_fields_visible_ticket'], '</option>
									<option value="', CFIELD_REPLY, '"',($context['field_loc'] == CFIELD_REPLY ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_fields_visible_field'], '</option>
									<option value="', (CFIELD_TICKET | CFIELD_REPLY), '"',($context['field_loc'] == (CFIELD_TICKET | CFIELD_REPLY) ? ' selected="selected"' : ''), '>', $txt['shd_admin_custom_fields_visible_both'], '</option>
								</select>
							</dd>
						</dl>
					</div>
				</div>
				<span class="lowerframe"><span></span></span>
				<br />
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/fieldtype.png" alt="*" />
						', $txt['shd_admin_custom_fields_fieldtype'], '
					</h3>
				</div>
				<div class="roundframe">
					<div class="content">
						<dl class="settings">
							<dt><strong>', $txt['shd_admin_custom_fields_fieldtype'], ':</strong></dt>
							<dd class="shd_nowrap">
								<span id="cf_fieldtype_icon" class="cf_ui_', $context['field_types'][$context['field_type_value']][1], '"></span>
								<select name="cf_fieldtype" id="cf_fieldtype" onchange="javascript:update_field_type(this.value);">';

	foreach ($context['field_types'] as $field => $details)
	{
		list($field_desc, $class) = $details;
		echo '
									<option value="', $field, '"', ($context['field_type_value'] == $field ? ' selected="selected"' : ''), '>', $field_desc, '</option>';
	}

	echo '
								</select>
							</dd>
							<dt id="max_length_dt"',$context['field_type_value'] == 1 || $context['field_type_value'] == 2  || $context['field_type_value'] == 3 || $context['field_type_value'] == 4 ? '' : ' style="display: none;"','><strong>',$txt['shd_admin_custom_field_maxlength'],':</strong><br /><span class="smalltext">',$txt['shd_admin_custom_field_maxlength_desc'],'</span></dt>
							<dd id="max_length_dd"',$context['field_type_value'] == 1 || $context['field_type_value'] == 2  || $context['field_type_value'] == 3 || $context['field_type_value'] == 4 ? '' : ' style="display: none;"','>
								<input type="text" value="255" size="7" maxlength="6" name="field_length" id="cf_field_length" />
							</dd>
							<dt id="dimension_dt"',$context['field_type_value'] == 2 ? '' : ' style="display: none;"','> 
								<strong>',$txt['shd_admin_custom_field_dimensions'],':</strong> 
							</dt> 
							<dd id="dimension_dd"',$context['field_type_value'] == 2 ? '' : ' style="display: none;"','> 
								<strong>',$txt['shd_admin_custom_field_dimensions_rows'],':</strong> <input type="text" name="rows" value="4" size="5" maxlength="3" class="input_text" /> 
								<strong>',$txt['shd_admin_custom_field_dimensions_columns'],':</strong> <input type="text" name="cols" value="30" size="5" maxlength="3" class="input_text" /> 
							</dd>
							<dt id="bbc_dt"',$context['field_type_value'] == 1 || $context['field_type_value'] == 2 ? '' : ' style="display: none;"','><strong',empty($modSettings['shd_allow_ticket_bbc']) ? ' class="disabled"' : '', '>',$txt['shd_admin_custom_field_bbc'],':</strong><br />',empty($modSettings['shd_allow_ticket_bbc']) ? '<span class="smalltext error">' . sprintf($txt['shd_admin_custom_field_bbc_off'],$scripturl . '?action=admin;area=helpdesk_options;sa=posting'). '</span>' : '', '</dt>
							<dd id="bbc_dd"',$context['field_type_value'] == 1 || $context['field_type_value'] == 2 ? '' : ' style="display: none;"','>
								<input type="checkbox" name="bbc" id="cf_bbc"',empty($modSettings['shd_allow_ticket_bbc']) ? ' disabled="disabled"' : '', ' />
							</dd>
							<dt id="options_dt"',$context['field_type_value'] == 5 || $context['field_type_value'] == 7 ? '' : ' style="display: none;"','> 
								<strong>',$txt['shd_admin_custom_field_options'],':</strong><br /> 
								<span class="smalltext">',$txt['shd_admin_custom_field_options_desc'],'</span> 
							</dt> 
							<dd id="options_dd"',$context['field_type_value'] == 5 || $context['field_type_value'] == 7 ? '' : ' style="display: none;"','> 
								<div> 
								<input type="radio" name="default_select" value="0" checked="checked" class="input_radio" /><input type="text" name="select_option[0]" value="" class="input_text" /> 
								<br /><input type="radio" name="default_select" value="1" checked="checked" class="input_radio" /><input type="text" name="select_option[1]" value="" class="input_text" /> 
								<br /><input type="radio" name="default_select" value="2" checked="checked" class="input_radio" /><input type="text" name="select_option[2]" value="" class="input_text" /> 
								<span id="addopt"></span> 
								[<a href="" onclick="add_option(); return false;">',$txt['more'],'</a>]
								</div> 
							</dd> 
							<dt id="default_dt"',$context['field_type_value'] == 6 ? '' : ' style="display: none;"','> 
								<strong>',$txt['shd_admin_custom_field_default_state'],':</strong> 
							</dt> 
							<dd id="default_dd"',$context['field_type_value'] == 6 ? '' : ' style="display: none;"','> 
								<input type="checkbox" name="default_check" class="input_check" onchange="javascript:update_default_label(this.value);" /> 
								<span class="smalltext" id="default_label">',$txt['shd_admin_default_state_off'],'</span>
							</dd> 							
						</dl>
					</div>
				</div>
				<span class="lowerframe"><span></span></span>
				<br />
				<input type="submit" value="',$txt['shd_admin_save_custom_field'],'" accesskey="s" class="button_submit" /> 
				', !empty($context['new_field']) ? '' : '<input type="submit" value="' .$txt['shd_admin_delete_custom_field'] . '" onclick="return confirm(' . JavaScriptEscape($txt['shd_admin_delete_custom_field_confirm']). ');" name="delete" class="button_submit" />', '
				', empty($context['new_field']) ? '' : '<input type="submit" value="' . $txt['shd_admin_cancel_custom_field'] . '" name="cancel" class="button_submit" />', '
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
				<input type="hidden" name="field" value="', empty($context['custom_field']['id_field']) ? 0 : $context['custom_field']['id_field'], '" />
				</form>';			
}

?>