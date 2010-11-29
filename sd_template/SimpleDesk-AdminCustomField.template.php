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
								<img src="', $settings['default_images_url'], '/simpledesk/custom_fields.png" class="icon" alt="*" />
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
					document.getElementById("cf_fieldicon_icon").style.background = "url(" + ', JavaScriptEscape($settings['default_images_url'] . '/simpledesk/'), ' + filename + ") no-repeat left";
				}
				function set_fieldtype_icon(ftype)
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
				}
				// ]', ']></script>
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/custom_fields.png" class="icon" alt="*" />
							', $context['page_title'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_custom_fields_desc'], '
					</p>
				</div>
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/description.png" alt="*" />
						', $txt['shd_admin_custom_fields_general'], '
					</h3>
				</div>
				<div class="roundframe">
					<div class="content">
						<dl class="settings">
							<dt><strong>', $txt['shd_admin_custom_fields_fieldname'], ':</strong></dt>
							<dd><input type="text" name="fieldname" id="cf_fieldname" value="" class="input_text" size="30" /></dd>
							<dt><strong>', $txt['shd_admin_custom_fields_active'], ':</strong></dt>
							<dd><input type="checkbox" name="active" id="cf_active" value="1" class="input_check" /></dd>
							<dt><strong>', $txt['shd_admin_custom_fields_icon'], ':</strong></dt>
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
							<dt><strong>', $txt['shd_admin_custom_fields_visible'], ':</strong></dt>
							<dd>
								<span id="cf_fieldvisible_icon"></span>
								<select name="cf_fieldvisible" id="cf_fieldvisible">
									<option value="', CFIELD_TICKET, '">', $txt['shd_admin_custom_fields_visible_ticket'], '</option>
									<option value="', CFIELD_REPLY, '">', $txt['shd_admin_custom_fields_visible_field'], '</option>
									<option value="', (CFIELD_TICKET | CFIELD_REPLY), '">', $txt['shd_admin_custom_fields_visible_both'], '</option>
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
								<select name="cf_fieldtype" id="cf_fieldtype" onchange="javascript:set_fieldtype_icon(this.value);">';

	foreach ($context['field_types'] as $field => $details)
	{
		list($field_desc, $class) = $details;
		echo '
									<option value="', $field, '"', ($context['field_type_value'] == $field ? ' selected="selected"' : ''), '>', $field_desc, '</option>';
	}

	echo '
								</select>
							</dd>
						</dl>
					</div>
				</div>
				<span class="lowerframe"><span></span></span>';
}

?>