<?php
// Version: 2.0 Anatidae; SimpleDesk's administration/canned replies area

/**
 *	Displays SimpleDesk's administration for canned replies, front page, creation and editing.
 *
 *	@package template
 *	@since 2.0
*/

/**
 *	Display the front page of the SimpleDesk departments.
 *
 *	@since 2.0
*/
function template_shd_cannedreplies_home()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar grid_header">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/cannedreplies.png" class="icon" alt="*">
							', $txt['shd_admin_cannedreplies_home'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_cannedreplies_homedesc'], '
					</p>
				</div>';

	if (empty($context['canned_replies']))
	{
		echo '
				<br />
				<div class="tborder">
					<div class="title_bar">
						<h3 class="titlebg">
							', $txt['shd_admin_cannedreplies_nocats'], '
						</h3>
					</div>
				</div>';
	}
	else
	{
		foreach ($context['canned_replies'] as $cat_id => $cat)
		{
			echo '
				<div class="tborder">
					<br />
					<div class="cat_bar grid_header">
						<h3 class="catbg">
							', $cat['name'], '
							', !empty($cat['move_up']) ? ('<a href="' . $scripturl . '?action=admin;area=helpdesk_cannedreplies;sa=movecat;cat=' . $cat_id . ';direction=up;' . $context['session_var'] . '=' . $context['session_id'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/move_up.png" alt="' . $txt['shd_admin_move_up'] . '" title="' . $txt['shd_admin_move_up'] . '" /></a>') : '', '
							', !empty($cat['move_down']) ? ('<a href="' . $scripturl . '?action=admin;area=helpdesk_cannedreplies;sa=movecat;cat=' . $cat_id . ';direction=down;' . $context['session_var'] . '=' . $context['session_id'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/move_down.png" alt="' . $txt['shd_admin_move_down'] . '" title="' . $txt['shd_admin_move_down'] . '" /></a>') : '', '
							<a href="', $scripturl, '?action=admin;area=helpdesk_cannedreplies;sa=editcat;cat=' . $cat_id . ';', $context['session_var'], '=', $context['session_id'], '"><img src="', $settings['default_images_url'], '/simpledesk/edit.png" class="icon" alt="', $txt['shd_ticket_edit'],'" title="', $txt['shd_ticket_edit'], '" /></a>
						</h3>
					</div>
					<table class="shd_ticketlist" cellspacing="0" width="100%">
						<tr class="titlebg">
							<td width="30%" class="shd_nowrap">', $txt['shd_admin_cannedreplies_replyname'], '</td>
							<td width="25%">', $txt['shd_departments'], '</td>
							<td>', $txt['shd_admin_cannedreplies_isactive'], '</td>
							<td>', $txt['shd_admin_cannedreplies_visibleto'], '</td>
							<td colspan="3" width="1%" class="shd_nowrap">', $txt['shd_admin_custom_fields_move'], '</td>
							<td colspan="2" width="1%" class="shd_nowrap">', $txt['shd_actions'], '</td>
						</tr>';

			if (empty($cat['replies']))
			{
				$use_bg2 = false;
				echo '
						<tr class="windowbg2">
							<td colspan="9" class="centertext">', $txt['shd_admin_cannedreplies_emptycat'], '</td>
						</tr>';
			}
			else
			{
				$use_bg2 = true;
				foreach ($cat['replies'] as $reply)
				{
					echo '
						<tr class="windowbg', $use_bg2 ? '2' : '', '">
							<td>', $reply['title'], '</td>
							<td>', $reply['depts'], '</td>
							<td><img src="', $settings['default_images_url'], '/simpledesk/cf_', $reply['active_string'], '.png" alt="', $txt['shd_admin_custom_fields_' . $reply['active_string']], '" title="', $txt['shd_admin_custom_fields_' . $reply['active_string']], '" /></td>
							<td>
								', !empty($reply['vis_user']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/user.png" class="icon" alt="*" />' : '', '
								', !empty($reply['vis_staff']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/staff.png" class="icon" alt="*" />' : '', '
								<img src="', $settings['default_images_url'], '/simpledesk/admin.png" class="icon" alt="" />
							</td>
							<td>', !empty($reply['move_up']) ? ('<a href="' . $scripturl . '?action=admin;area=helpdesk_cannedreplies;sa=movereply;reply=' . $reply['id_reply'] . ';direction=up;' . $context['session_var'] . '=' . $context['session_id'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/move_up.png" alt="' . $txt['shd_admin_move_up'] . '" title="' . $txt['shd_admin_move_up'] . '" /></a>') : '', '</td>
							<td>', !empty($reply['move_down']) ? ('<a href="' . $scripturl . '?action=admin;area=helpdesk_cannedreplies;sa=movereply;reply=' . $reply['id_reply'] . ';direction=down;' . $context['session_var'] . '=' . $context['session_id'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/move_down.png" alt="' . $txt['shd_admin_move_down'] . '" title="' . $txt['shd_admin_move_down'] . '" /></a>') : '', '</td>
							<td>', $context['move_between_cats'] ? ('<a href="' . $scripturl . '?action=admin;area=helpdesk_cannedreplies;sa=movereplycat;reply=' . $reply['id_reply'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/movedept.png" alt="' . $txt['shd_admin_cannedreplies_move_between_cat'] . '" title="' . $txt['shd_admin_cannedreplies_move_between_cat'] . '" /></a>') : '', '</td>
							<td><a href="', $scripturl, '?action=admin;area=helpdesk_cannedreplies;sa=editreply;reply=' . $reply['id_reply'] . ';', $context['session_var'], '=', $context['session_id'], '"><img src="', $settings['default_images_url'], '/simpledesk/edit.png" class="icon" alt="', $txt['shd_ticket_edit'],'" title="', $txt['shd_ticket_edit'], '" /></a></td>
							<td><a href="', $scripturl, '?action=admin;area=helpdesk_cannedreplies;sa=savereply;reply=' . $reply['id_reply'] . ';delete=yes;', $context['session_var'], '=', $context['session_id'], '" onclick="return confirm(' . JavaScriptEscape($txt['shd_admin_cannedreplies_deletereply_confirm']). ');"><img src="', $settings['default_images_url'], '/simpledesk/delete.png" class="icon" alt="', $txt['shd_ticket_delete'],'" title="', $txt['shd_ticket_delete'], '" /></a></td>
						</tr>';
					$use_bg2 = !$use_bg2;
				}
			}

			echo '
						<tr class="windowbg', $use_bg2 ? '2' : '', '">
							<td colspan="9" class="righttext">[<a href="', $scripturl, '?action=admin;area=helpdesk_cannedreplies;sa=createreply;cat=', $cat_id, '">', $txt['shd_admin_cannedreplies_addreply'], '</a>]</td>
						</tr>
					</table>
				</div>';
		}
	}

	echo '
				<div class="flow_auto">
					<div class="floatright">
						<div class="additional_row">[<a href="', $scripturl, '?action=admin;area=helpdesk_cannedreplies;sa=createcat">', $txt['shd_admin_cannedreplies_createcat'], '</a>]</div>
					</div>
				</div>';
}

function template_shd_edit_canned_category()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/cannedreplies.png" class="icon" alt="*" />
							', $txt['shd_admin_cannedreplies_home'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_cannedreplies_homedesc'], '
					</p>
				</div>
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/additional_information.png" alt="*" />
						', $context['page_title'], '
					</h3>
				</div>
				<div class="roundframe">
					<form action="', $scripturl, '?action=admin;area=helpdesk_cannedreplies;sa=savecat" method="post">
						<div class="content">
							<dl class="settings">
								<dt><strong>', $txt['shd_admin_cannedreplies_categoryname'], '</strong></dt>
								<dd><input type="text" name="catname" id="catname" class="input_text" size="30" value="', $context['category_name'], '" /></dd>
							</dl>
						</div>
						<input type="submit" value="', $context['page_title'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />';

	if ($_REQUEST['cat'] != 'new')
		echo '
						<input type="submit" name="delete" value="', $txt['shd_admin_cannedreplies_deletecat'], '" onclick="return confirm(', JavaScriptEscape($txt['shd_admin_cannedreplies_delete_confirm']), ') && submitThisOnce(this);" class="button_submit" />';

	echo '
						<input type="hidden" name="cat" value="', $_REQUEST['cat'], '" />
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
					</form>
				</div>
				<span class="lowerframe"><span></span></span>';
}

function template_shd_edit_canned_reply()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	$editor_context = &$context['controls']['richedit'][$context['post_box_name']];

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/cannedreplies.png" class="icon" alt="*" />
							', $txt['shd_admin_cannedreplies_home'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_cannedreplies_homedesc'], '
					</p>
				</div>
				<form action="', $scripturl, '?action=admin;area=helpdesk_cannedreplies;sa=savereply" method="post" accept-charset="', $context['character_set'], '" name="cannedreply" id="cannedreply" onsubmit="', 'submitonce(this);smc_saveEntities(\'cannedreply\', [\'title\', \'', $context['post_box_name'], '\']);" enctype="multipart/form-data" style="margin: 0;">
					<div class="cat_bar grid_header">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/additional_information.png" alt="*" />
							', $context['page_title'], '
						</h3>
					</div>
					<div class="roundframe">
						<div class="content">
							<dl class="permsettings cannedsettings">
								<dt><strong>', $txt['shd_admin_cannedreplies_replytitle'], '</strong></dt>
								<dd><input type="text" class="input_text" value="', $context['canned_reply']['title'], '" name="title" /></dd>
								<dt><strong>', $txt['shd_admin_cannedreplies_content'], '</strong>
								<dd>
									<div id="bbcbox"></div>
									<div id="smileybox"></div>',
									template_control_richedit($context['post_box_name'], 'smileybox', 'bbcbox'), '
								</dd>
								<dt><strong>', $txt['shd_admin_cannedreplies_active'], '</strong></dt>
								<dd><input type="checkbox" name="active" class="input_check"', !empty($context['canned_reply']['active']) ? ' checked="checked"' : '', ' />
								<dt><strong>', $txt['shd_admin_cannedreplies_selectvisible'], '</strong></dt>
								<dd>
									<input type="checkbox" name="vis_user" class="input_check"', !empty($context['canned_reply']['vis_user']) ? ' checked="checked"' : '', ' /> <img src="', $settings['default_images_url'], '/simpledesk/user.png" class="icon" alt="', $txt['shd_admin_custom_field_users'], '" title="', $txt['shd_admin_custom_field_users'], '">
									<input type="checkbox" name="vis_staff" class="input_check"', !empty($context['canned_reply']['vis_staff']) ? ' checked="checked"' : '', ' /> <img src="', $settings['default_images_url'], '/simpledesk/staff.png" class="icon" alt="', $txt['shd_admin_custom_field_staff'], '" title="', $txt['shd_admin_custom_field_staff'], '">
									<input type="checkbox" name="vis_admin" class="input_check" checked="checked" disabled="disabled"> <img src="', $settings['default_images_url'], '/simpledesk/admin.png" class="icon" alt="', $txt['shd_admin_custom_field_admins'], '" title="', $txt['shd_admin_custom_field_admins'], '">
								</dd>
							</dl>
						</div>
					</div>
					<span class="lowerframe"><span></span></span>
					<br />
					<div class="cat_bar grid_header">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/departments.png" alt="*" />
							', $txt['shd_admin_cannedreplies_departments'], '
						</h3>
					</div>
					<div class="roundframe">
						<div class="content">
							<dl class="permsettings cannedsettings">';

	foreach ($context['canned_reply']['depts_available'] as $dept_id => $dept_name)
	{
		echo '
								<dt><strong>', $dept_name, '</strong></dt>
								<dd><input type="checkbox" name="dept_', $dept_id, '"', in_array($dept_id, $context['canned_reply']['depts_selected']) ? ' checked="checked"' : '', ' class="input_check" /></dd>';
	}

	echo '
							</dl>
						</div>
					</div>
					<span class="lowerframe"><span></span></span>
					<br />
					<input type="submit" value="', isset($editor_context['labels']['post_button']) ? $editor_context['labels']['post_button'] : $txt['save'], '" tabindex="', $context['tabindex']++, '" accesskey="s" class="button_submit" />';

	if ($context['canned_reply']['id'] != 'new')
		echo '
					<input type="submit" name="delete" value="', $txt['shd_admin_cannedreplies_deletereply'], '" onclick="return confirm(', JavaScriptEscape($txt['shd_admin_cannedreplies_deletereply_confirm']), ') && submitThisOnce(this);" class="button_submit" />';

	echo '
					<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
					<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
					<input type="hidden" name="reply" value="', $context['canned_reply']['id'], '" />
					<input type="hidden" name="cat" value="', $context['canned_reply']['cat'], '" />
				</form>
				<br />';
}

function template_shd_move_reply_cat()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
				<div class="tborder">
					<div class="cat_bar">
						<h3 class="catbg">
							<img src="', $settings['default_images_url'], '/simpledesk/cannedreplies.png" class="icon" alt="*" />
							', $txt['shd_admin_cannedreplies_home'], '
						</h3>
					</div>
					<p class="description">
						', $txt['shd_admin_cannedreplies_homedesc'], '
					</p>
				</div>
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/movedept.png" alt="*" />
						', $context['page_title'], '
					</h3>
				</div>
				<div class="roundframe">
					<form action="', $scripturl, '?action=admin;area=helpdesk_cannedreplies;sa=movereplycat;part=2" method="post">
						<div class="content">
							<dl class="settings">
								<dt><strong>', $txt['shd_admin_cannedreplies_newcategory'], '</strong></dt>
								<dd>
									<select name="newcat">
										<option value="0">', $txt['shd_admin_cannedreplies_selectcat'], '</option>';

	foreach ($context['cannedreply_cats'] as $cat_id => $cat_name)
		echo '
										<option value="', $cat_id, '">', $cat_name, '</option>';

	echo '
									</select>
								</dd>
							</dl>
						</div>
						<input type="submit" value="', $txt['shd_admin_cannedreplies_movereply'], '" onclick="return submitThisOnce(this);" class="button_submit" />';


	echo '
						<input type="hidden" name="reply" value="', $_REQUEST['reply'], '" />
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
					</form>
				</div>
				<span class="lowerframe"><span></span></span>';
}

?>