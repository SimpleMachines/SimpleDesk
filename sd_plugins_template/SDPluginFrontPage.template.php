<?php
// Version: 2.1; SimpleDesk alternate front page template

/**
 *	This file handles the replacement front page.
 *
 *	@package plugin-frontpage
 *	@since 2.0
*/

/**
 *	Display the replacement front page.
 *
 *	@since 2.0
*/
function template_shd_frontpage()
{
	global $context, $txt, $settings, $scripturl;

	echo '
		<div class="modbuttons clearfix margintop">';

	template_button_strip($context['navigation'], 'bottom');

	echo '
		</div>
		<div id="admin_content">
			', $context['shdp_frontpage_content'], '
		</div>';
}

/**
 *	Display the admin page for this plugin, with a custom template.
 *
 *	@since 2.0
*/

function template_shd_frontpage_admin()
{
	global $context, $settings, $txt, $modSettings;

	if (empty($modSettings['shdp_frontpage_type']))
		$modSettings['shdp_frontpage_type'] = 'bbcode';
	if (empty($modSettings['shdp_frontpage_appear']))
		$modSettings['shdp_frontpage_appear'] = 'firstdefault';

	echo '
	<div id="admincenter">
		<form name="adminform" action="', $context['post_url'], '" method="post" accept-charset="', $context['character_set'], '"', !empty($context['force_form_onsubmit']) ? ' onsubmit="' . $context['force_form_onsubmit'] . '"' : '', '>
		<div class="tborder">
			<div class="cat_bar">
				<h3 class="catbg">
					<img src="', shd_image_url('frontpage.png'), '" class="icon" alt="*"/> ', $txt['shdp_frontpage'], '
				</h3>
			</div>
			<div class="windowbg2">
				<div class="content">
					<dl class="permsettings">
						<dt style="width: 30%;">
							<a id="setting_shdp_frontpage_appear"></a> <span><label id="label_shdp_frontpage_appear" for="shdp_frontpage_appear">', $txt['shdp_frontpage_appear'], '</label></span>
						</dt>
						<dd style="width: 68%;">
							<select name="shdp_frontpage_appear" id="shdp_frontpage_appear">
								<option value="always"', $modSettings['shdp_frontpage_appear'] == 'always' ? ' selected="selected"' : '', '>', $txt['shdp_frontpage_appear_always'], '</option>
								<option value="firstload"', $modSettings['shdp_frontpage_appear'] == 'firstload' ? ' selected="selected"' : '', '>', $txt['shdp_frontpage_appear_firstload'], '</option>
								<option value="firstdefault"', $modSettings['shdp_frontpage_appear'] == 'firstdefault' ? ' selected="selected"' : '', '>', $txt['shdp_frontpage_appear_firstdefault'], '</option>
							</select>
							</dd>
					</dl>
					<hr>
					<dl class="permsettings">
						<dt style="width: 30%;">
							<a id="setting_shdp_frontpage_type"></a> <span><label id="label_shdp_frontpage_type" for="shdp_frontpage_type">', $txt['shdp_frontpage_type'], '</label></span>
						</dt>
						<dd style="width: 68%;">
							<select name="shdp_frontpage_type" id="shdp_frontpage_type" onchange="invertBBC();">
								<option value="bbcode"', ($modSettings['shdp_frontpage_type'] == 'bbcode' ? ' selected="selected"' : ''), '>', $txt['shdp_frontpage_type_bbcode'], '</option>
								<option value="php"', ($modSettings['shdp_frontpage_type'] == 'php' ? ' selected="selected"' : ''), '>', $txt['shdp_frontpage_type_php'], '</option>
							</select>
							</dd>
						<dt style="width: 30%;">
							<a id="setting_shdp_frontpage_content"></a> <span><label id="label_shdp_frontpage_content" for="shdp_frontpage_content">Main content</label></span>
						</dt>
						<dd style="width: 68%;">';

	$editor_context = &$context['controls']['richedit'][$context['post_box_name']];

	// The postbox
	echo '
							<div id="shd_bbcbox"', ($modSettings['shdp_frontpage_type'] == 'php' ? ' style="display:none;"' : ''), '></div>
							<div id="shd_smileybox"', ($modSettings['shdp_frontpage_type'] == 'php' ? ' style="display:none;"' : ''), '></div>';

	echo template_control_richedit($context['post_box_name'], 'shd_smileybox', 'shd_bbcbox');

	echo '
							</dd>
						</dl>
						<hr>
						<div class="righttext">
							<input type="submit" value="', $txt['save'], '"', (!empty($context['save_disabled']) ? ' disabled="disabled"' : ''), (!empty($context['settings_save_onclick']) ? ' onclick="' . $context['settings_save_onclick'] . '"' : ''), ' class="button">
						</div>

					</div>
				<span class="botslice"><span></span></span>
			</div>
			</div>';
	if (isset($context['admin-dbsc_token']))
		echo '
		<input type="hidden" name="', $context['admin-dbsc_token_var'], '" value="', $context['admin-dbsc_token'], '">';
	echo '
		<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
		</form>
	</div>
	<br>';
	if (!empty($context['settings_post_javascript']))
		echo '
	<script type="text/javascript"><!-- // --><![CDATA[
	', $context['settings_post_javascript'], '
	// ]]></script>';
	if (!empty($context['settings_insert_below']))
		echo $context['settings_insert_below'];

	echo '
	<script type="text/javascript"><!-- // --><![CDATA[
	function invertBBC()
	{
		var state = document.getElementById("shdp_frontpage_type").value == "bbcode";
		document.getElementById("shd_bbcbox").style.display = state ? "" : "none";
		document.getElementById("shd_smileybox").style.display = state ? "" : "none";
	}
	// ]]></script>';
}
