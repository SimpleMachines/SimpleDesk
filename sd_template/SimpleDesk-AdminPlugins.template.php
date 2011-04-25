<?php
// Version: 1.0 Felidae; SimpleDesk's administration/plugins area

/**
 *	Displays SimpleDesk's administration for plugins.
 *
 *	@package template
 *	@since 1.1
*/

/**
 *	Display the front page of the SimpleDesk plugins area.
 *
 *	@since 1.1
*/
function template_shd_plugin_listing()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
	<script type="text/javascript"><!-- // --><![CDATA[
		function toggleItem(itemID)
		{
			// Toggle the hidden item.
			var itemValueHandle = document.getElementById("feature_" + itemID);
			itemValueHandle.value = itemValueHandle.value == 1 ? 0 : 1;

			// Change the image, alternative text and the title.
			document.getElementById("switch_" + itemID).src = \'', $settings['images_url'], '/admin/switch_\' + (itemValueHandle.value == 1 ? \'on\' : \'off\') + \'.png\';
			document.getElementById("switch_" + itemID).alt = itemValueHandle.value == 1 ? \'', $txt['core_settings_switch_off'], '\' : \'', $txt['core_settings_switch_on'], '\';
			document.getElementById("switch_" + itemID).title = itemValueHandle.value == 1 ? \'', $txt['core_settings_switch_off'], '\' : \'', $txt['core_settings_switch_on'], '\';

			// Don\'t reload.
			return false;
		}
	// ]]></script>';

	echo '
	<div id="admincenter">
		<form action="', $scripturl, '?action=admin;area=helpdesk_plugins;save;" method="post" accept-charset="', $context['character_set'], '">
			<div class="tborder">
				<div class="cat_bar">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/plugins.png" class="icon" alt="*" />
						', $txt['shd_admin_plugins'], '
					</h3>
				</div>
				<p class="description">
					', $txt['shd_admin_plugins_homedesc'], '
				</p>
			</div>';

	$use_bg2 = true;
	foreach ($context['plugins'] as $id => $plugin)
	{
		echo '
			<div class="windowbg', $use_bg2 ? '2' : '', '">
				<span class="topslice"><span></span></span>
				<div class="content features">';

		if (!empty($plugin['installable']))
			echo '
					<div class="features_switch" id="js_feature_', $id, '" style="display: none;">
						<a href="', $scripturl, '?action=admin;area=helpdesk_plugins;save;', $context['session_var'], '=', $context['session_id'], ';toggle=', $id, ';state=', $plugin['enabled'] ? 0 : 1, '" onclick="return toggleItem(\'', $id, '\');">
							<input type="hidden" name="feature_', $id, '" id="feature_', $id, '" value="', $plugin['enabled'] ? 1 : 0, '" /><img src="', $settings['images_url'], '/admin/switch_', $plugin['enabled'] ? 'on' : 'off', '.png" id="switch_', $id, '" style="margin-top: 1.3em;" alt="', $txt['core_settings_switch_' . ($plugin['enabled'] ? 'off' : 'on')], '" title="', $txt['core_settings_switch_' . ($plugin['enabled'] ? 'off' : 'on')], '" />
						</a>
					</div>';
		else
		{
			echo '
					<div class="features_switch" id="js_feature_', $id, '">
						<div class="error">', $txt['shd_admin_plugins_wrong_version'], '</div>
						<div>', $txt['shd_admin_plugins_versions_avail'], ':</div>
						<ul class="smalltext">
							<li>', implode('</li><li>', $plugin['details']['compatibility']), '</li>
						</ul>
					</div>';
		}

		if (!empty($plugin['languages']))
		{
			echo '
					<div class="langblock">', $txt['shd_admin_plugins_languages'], ':<br />';
			foreach ($plugin['languages'] as $language)
			{
				if (!empty($txt['shd_admin_plugins_lang_' . $language]))
					echo '
						<img src="', $settings['default_images_url'], '/simpledesk/flags/', $language, '.png" alt="', $txt['shd_admin_plugins_lang_' . $language], '" title="', $txt['shd_admin_plugins_lang_' . $language], '" />';
			}
			echo '
					</div>';
		}

		echo '
					<h4>', (!empty($plugin['details']['acp_url']) ? '<a href="' . $plugin['details']['acp_url'] . '">' . $plugin['details']['title'] . '</a>' : $plugin['details']['title']), '</h4>
					<p>';
		if (!empty($plugin['details']['description']))
			echo '
						', $plugin['details']['description'], '<br />';

		echo '			', $txt['shd_admin_plugins_writtenby'], ': ', (empty($plugin['details']['website']) ? $plugin['details']['author'] : '<a href="' . $plugin['details']['website'] . '" target="_blank" title="' . $txt['shd_admin_plugins_website'] . ' - ' . $plugin['details']['website'] . '">' . $plugin['details']['author'] . '</a>'), '
					</p>';

		if (!empty($plugin['installable']))
			echo '
					<div id="plain_feature_', $id, '">
						<label for="plain_feature_', $id, '_radio_on"><input type="radio" name="feature_plain_', $id, '" id="plain_feature_', $id, '_radio_on" value="1"', $plugin['enabled'] ? ' checked="checked"' : '', ' class="input_radio" />', $txt['core_settings_enabled'], '</label>
						<label for="plain_feature_', $id, '_radio_off"><input type="radio" name="feature_plain_', $id, '" id="plain_feature_', $id, '_radio_off" value="0"', !$plugin['enabled'] ? ' checked="checked"' : '', ' class="input_radio" />', $txt['core_settings_disabled'], '</label>
					</div>';

		echo '
				</div>
				<span class="botslice clear_right"><span></span></span>
			</div>';

		$use_bg2 = !$use_bg2;
	}

	echo '
			<div class="righttext">
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
				<input type="hidden" value="0" name="js_worked" id="js_worked" />
				<input type="submit" value="', $txt['save'], '" name="save" class="button_submit" />
			</div>
		</form>
	</div>
	<br class="clear" />
	<script type="text/javascript"><!-- // --><![CDATA[
		document.getElementById(\'js_worked\').value = "1";';
		foreach ($context['plugins'] as $id => $plugin)
		{
			if (!empty($plugin['installable']))
				echo '
		document.getElementById(\'js_feature_', $id, '\').style.display = "";
		document.getElementById(\'plain_feature_', $id, '\').style.display = "none";';
		}
	echo '
	// ]]></script>';
}

?>