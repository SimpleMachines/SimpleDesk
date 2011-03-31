<?php
// Version: 1.0 Felidae; SimpleDesk's administration area

/**
 *	Displays SimpleDesk's administration panel, options pages, action log and the get-support page.
 *
 *	@package template
 *	@since 1.0
*/

/**
 *	Display the main information center for the administration panel.
 *
 *	This function handles output of data populated by {@link shd_admin_info()}:
 *	- upgraded SD version advisory
 *	- latest news from SimpleDesk.net
 *	- basic version check
 *	- count of open/closed/recycled tickets in the helpdesk in total
 *	- list of current helpdesk staff
 *	- credits
 *
 *	@see shd_admin_info()
 *	@since 1.0
*/
function template_shd_admin()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	// Make our admin feel welcome
	echo '
	<div id="admincenter">';

	// Update?
	echo '
			<div id="sd_update_section" class="tborder" style="display: none;"></div>';

	echo '
		<div id="admin_main_section">';

	// Display the "live news" from simpledesk.net
	echo '
			<div id="sd_live_news" class="floatleft">
				<div class="tborder">
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/live.png" alt="*" />
						', $txt['shd_live_from'], '
						<span class="righttext"><a href="', $scripturl, '?action=helpadmin;help=shd_admin_help_live" onclick="return reqWin(this.href);"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" /></a></span>
					</h3>
				</div>
				<div class="windowbg">
						<div class="content">
							<div id="sdAnnouncements">', $txt['shd_no_connect'], '</div>
						</div>
					<span class="botslice"><span></span></span>
				</div>
				</div>
			</div>';

	// Show the user version information from their server.
	echo '
			<div id="sd_supportVersionsTable" class="floatright">
				<div class="tborder">
				<div class="cat_bar grid_header">
					<h3 class="catbg">
						<img src="', $settings['default_images_url'], '/simpledesk/modification.png" alt="*" />
						', $txt['shd_mod_information'], '
						<span class="righttext"><a href="', $scripturl, '?action=helpadmin;help=shd_admin_help_modification" onclick="return reqWin(this.href);"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" /></a></span>
					</h3>
				</div>
				<div class="windowbg">
					<div class="content">
						<div id="sd_version_details">
							<img src="', $settings['default_images_url'], '/simpledesk/support.png" alt="*" class="shd_icon_minihead" /> <strong>', $txt['shd_need_support'], '</strong><br />
							', sprintf($txt['shd_support_start_here'], $scripturl . '?action=admin;area=helpdesk_info;sa=support'), '<br />
							<br />
							<img src="', $settings['default_images_url'], '/simpledesk/versions.png" alt="*" class="shd_icon_minihead" /> <strong>', $txt['support_versions'], ':</strong><br />
							', $txt['shd_your_version'], ':
							<em id="yourVersion" class="shd_nowrap">', SHD_VERSION, '</em><br />
							', $txt['shd_current_version'], ':
							<em id="sdVersion" class="shd_nowrap">??</em><br /><br />
							<img src="', $settings['default_images_url'], '/simpledesk/ticket.png" alt="*" class="shd_icon_minihead" /> <strong>', $txt['shd_ticket_information'], ':</strong><br />
							', $txt['shd_total_tickets'], ':
							<em id="totalTickets" class="shd_nowrap">
								<a href="javascript: shd_ticket_total_information();" >', $context['total_tickets'], '</a>
							</em>
							<div id="shd_ticket_total_information" style="display: none;">
								&nbsp;&nbsp;&nbsp;', $txt['shd_open_tickets'], ': <em>', $context['open_tickets'], '</em><br />
								&nbsp;&nbsp;&nbsp;', $txt['shd_closed_tickets'], ': <em>', $context['closed_tickets'], '</em><br />
								&nbsp;&nbsp;&nbsp;', $txt['shd_recycled_tickets'], ': <em>', $context['recycled_tickets'], '</em><br />
							</div>
							<br />';

	// Display all the members who can manage the helpdesk.
	// NOTE: This is currently (15/1/10) uncapped, meaning it's just the full list direct from SimpleDesk-Admin.php.
	// That gets the data. Up to here how it should be displayed.
	echo '
							<br />
							<img src="', $settings['default_images_url'], '/simpledesk/staff.png" alt="*" class="shd_icon_minihead" /> <strong>', $txt['shd_staff_list'], ':</strong>
							', implode(', ', $context['staff']);

	echo '
						</div>
					</div>
					<span class="botslice"><span></span></span>
				</div>
			</div>
			</div>
		</div>
		<div class="shd_credits_break">&nbsp;</div>';


	echo '
		<div id="sd_credits">
			<div class="tborder">
			<div class="title_bar grid_header">
				<h3 class="titlebg sd_no_margin">
					<img src="', $settings['default_images_url'], '/simpledesk/credits.png" alt="*" />
					', $txt['shd_credits'], '
					<span class="righttext"><a href="', $scripturl, '?action=helpadmin;help=shd_admin_help_credits" onclick="return reqWin(this.href);"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" /></a></span>
				</h3>
			</div>';

		foreach ($context['shd_credits'] as $section)
		{
			echo '
				<div class="roundframe">
					<div class="content">
						', $section['pretext'], '
						<hr />';

				foreach ($section['groups'] as $group)
				{
					echo '
						<div class="description">';

					// Pretty icons! :D
					if (isset($group['icon']))
					echo '
						<img src="', $settings['default_images_url'], '/simpledesk/credits/', $group['icon'], '" alt="" class="floatleft" />
						<div class="shd_credits_names">';

					if (isset($group['title']))
					echo '
								<strong>', $group['title'], '</strong>', !empty($group['desc']) ? ' - <em class="smalltext">' . $group['desc'] . '</em>' : '', '<hr />';

					/*// Try to make this read nicely.
					if (count($group['members']) <= 2)
						echo implode(' ' . $txt['shd_credits_and'] . ' ', $group['members']);
					else
					{
						$last_peep = array_pop($group['members']);
						echo implode(', ', $group['members']), ', ', $txt['shd_credits_and'], ' ', $last_peep;
					}*/

					$cur_member = 1;
					foreach ($group['members'] AS $member)
					{
						echo $member[1] == true ? '<span class="shd_former_contributor">' : '', '', $member[0], '',$member[1] == true ? '</span>' : '';

						if ($cur_member < count($group['members']))
							echo ', ';

						$cur_member++;
					}

					if (isset($group['icon']))
					echo '
						</div>';

					echo '
							</div>';
				}

					echo '
						<span class="smalltext">&nbsp;<img src="', $settings['default_images_url'], '/simpledesk/update.png" alt="*" class="shd_tinyicon" /> ', $txt['shd_former_contributors'], '</span>
					</div>
				</div>
				<span class="lowerframe"><span></span></span>
				</div>
			</div>';
		}

	echo '
		</div>
	<br class="clear" />';

	// The below functions include all the scripts needed from the simpledesk.net site. The language and format are passed for internationalization.
	if (empty($modSettings['disable_smf_js']))
		echo '
		<script type="text/javascript" src="http://www.simpledesk.net/sd/current-version.js"></script>
		<script type="text/javascript" src="http://www.simpledesk.net/sd/latest-news.js"></script>';

	// This sets the announcements and current versions themselves ;).
	echo '
		<script type="text/javascript"><!-- // --><![CDATA[

			var oAdminIndex = new sd_AdminIndex({
				sSelf: \'oAdminCenter\',

				bLoadAnnouncements: true,
				sAnnouncementTemplate: ', JavaScriptEscape('
					<dl>
						%content%
					</dl>
				'), ',
				sAnnouncementMessageTemplate: ', JavaScriptEscape('
					<dt><a href="%href%" target="_blank">%subject%</a> ' . $txt['on'] . ' %time% ' . $txt['by'] . ' %author%</dt>
					<dd>
						%message%<br />
						<a href="%readmore%" class="smalltext" target="_blank">' . $txt['shd_admin_readmore'] . '</a>
					</dd>
				'), ',
				sAnnouncementContainerId: \'sdAnnouncements\',

				bLoadVersions: true,
				sSdVersionContainerId: \'sdVersion\',
				sYourVersionContainerId: \'yourVersion\',
				sVersionOutdatedTemplate: ', JavaScriptEscape('
					<span class="alert">%currentVersion%</span>
				'), ',

				bLoadUpdateNotification: true,
				sUpdateNotificationContainerId: \'sd_update_section\',
				sUpdateNotificationDefaultTitle: ', JavaScriptEscape($txt['shd_update_available']), ',
				sUpdateNotificationDefaultMessage: ', JavaScriptEscape($txt['shd_update_message']), ',
				sUpdateNotificationTemplate: ', JavaScriptEscape('
					<div class="cat_bar grid_header" id="update_title">
						<h3 class="catbg">
							<img src="' . $settings['default_images_url'] . '/simpledesk/update.png" alt="" />
							%title%
							<span class="righttext"><a href="' . $scripturl . '?action=helpadmin;help=shd_admin_help_update" onclick="return reqWin(this.href);"><img src="'. $settings['images_url'] . '/helptopics.gif" alt="' . $txt['help'] . '" /></a></span>
						</h3>
					</div>
					<div class="windowbg" id="update_container">
						<div class="content" id="update_content">
							<p id="update_critical_alert" class="alert" style="display: none;">!!</p>
							<h3 id="update_critical_title" style="display: none;">%criticaltitle%</h3>
							<div id="update_message" class="smalltext">
								<p>
									%message%
								</p>
							</div>
						</div>
						<span class="botslice"><span></span></span>
					</div>
				'), ',
				sUpdateNotificationLink: ', JavaScriptEscape($scripturl . '?action=admin;area=packages;pgdownload;auto;package=%package%;' . $context['session_var'] . '=' . $context['session_id']), ',
				sUpdateInformationLink: \'%information%\',
			});
		// ]]></script>';
}

/**
 *	Display options as set up by the options functions.
 *
 *	This is a modified version of the standard SMF template for displaying settings, mostly so we have access to a custom BBC template.
 *
 *	In short, SMF's functions call the relevant function in {@link SimpleDesk-Admin.php} to gather which options should be displayed, store in $context, then pass it here.
 *
 *	The same template services all of the defined areas inside Admin: SimpleDesk: Options.
 *
 *	@see shd_admin_options()
 *	@since 1.0
*/
function template_shd_show_settings()
{
	global $context, $txt, $settings, $scripturl;

	echo '
	<script type="text/javascript"><!-- // --><![CDATA[
		function invertList(state, id_list)
		{
			for (i in id_list)
			{
				var chk = document.getElementById(id_list[i]);
				if (chk && chk.disabled == false)
					chk.checked = state;
			}
		}
';

	if (!empty($context['settings_pre_javascript']))
		echo $context['settings_pre_javascript'];

	// If we have BBC selection we have a bit of JS.
	if (!empty($context['bbc_sections']))
	{
		echo '
		function toggleBBCDisabled(section, disable)
		{
			for (var i = 0; i < document.forms.bbcForm.length; i++)
			{
				if (typeof(document.forms.bbcForm[i].name) == "undefined" || (document.forms.bbcForm[i].name.substr(0, 11) != "enabledTags") || (document.forms.bbcForm[i].name.indexOf(section) != 11))
					continue;

				document.forms.bbcForm[i].disabled = disable;
			}
			document.getElementById("bbc_" + section + "_select_all").disabled = disable;
		}';
	}
	echo '
	// ]]></script>';

	if (!empty($context['settings_insert_above']))
		echo $context['settings_insert_above'];

	echo '
	<div id="admincenter">
		<form name="adminform" action="', $context['post_url'], '" method="post" accept-charset="', $context['character_set'], '"', !empty($context['force_form_onsubmit']) ? ' onsubmit="' . $context['force_form_onsubmit'] . '"' : '', '>';

	// Is there a custom title?
	if (isset($context['settings_title']))
		echo '
		<div class="tborder">
			<div class="cat_bar grid_header">
				<h3 class="catbg">
					<img src="', shd_image_url($context['settings_icon']), '" class="icon" alt="*" /> ', $context['settings_title'], '
				</h3>
			</div>';

	// Have we got some custom code to insert?
	if (!empty($context['settings_message']))
		echo '
			<div class="information">', $context['settings_message'], '</div>';

	// Now actually loop through all the variables.
	$is_open = false;
	foreach ($context['config_vars'] as $config_var)
	{
		// Is it a title or a description?
		if (is_array($config_var) && ($config_var['type'] == 'title' || $config_var['type'] == 'desc'))
		{
			// Not a list yet?
			if ($is_open)
			{
				$is_open = false;
				echo '
					</dl>
				</div>
				<span class="botslice"><span></span></span>
			</div>
			</div>';
			}


			// A title?
			if ($config_var['type'] == 'title')
			{
				echo '
					<div class="cat_bar">
						<h3 class="', !empty($config_var['class']) ? $config_var['class'] : 'catbg', '"', !empty($config_var['force_div_id']) ? ' id="' . $config_var['force_div_id'] . '"' : '', '>
							', ($config_var['help'] ? '<a href="' . $scripturl . '?action=helpadmin;help=' . $config_var['help'] . '" onclick="return reqWin(this.href);" class="help"><img src="' . $settings['images_url'] . '/helptopics.gif" alt="' . $txt['help'] . '" /></a>' : ''), '
							', $config_var['label'], '
						</h3>
					</div>';
			}
			// A description?
			else
			{
				echo '
					<p class="description">
						', $config_var['label'], '
					</p>';
			}

			continue;
		}

		// Not a list yet?
		if (!$is_open)
		{
			$is_open = true;

			if (!isset($context['settings_title']))
				echo '<div class="tborder">';

			echo '
			<div class="windowbg2">
				<div class="content">
					<dl class="permsettings">';
		}

		// Hang about? Are you pulling my leg - a callback?!
		if (is_array($config_var) && $config_var['type'] == 'callback')
		{
			if (function_exists('template_callback_' . $config_var['name']))
				call_user_func('template_callback_' . $config_var['name']);

			continue;
		}

		if (is_array($config_var))
		{
			// Sometimes we just gotta have some hidden stuff passed back
			if ($config_var['type'] == 'hidden')
			{
				echo '
						<input type="hidden" name="', $config_var['name'], '" value="', $config_var['value'], '" />';
			}
			// A check-all option?
			elseif ($config_var['type'] == 'checkall')
			{
				$array = array();
				foreach ($config_var['data'] as $k => $v)
					$array[] = JavaScriptEscape($v[1]);

				echo '
					<dt></dt>
					<dd>
						<input type="checkbox" name="all" id="', $config_var['name'], '" value="" onclick="invert_', $config_var['name'], '(this);" class="input_check floatleft">
						<label for="check_all" class="floatleft">', $txt['check_all'], '</label>
					</dd>
					<script type="text/javascript"><!-- // --><![CDATA[
					function invert_', $config_var['name'], '(obj)
					{
						var checks = [' . implode(',', $array), '];
						invertList(obj.checked, checks);
					}
					// ]]></script>';
			}
			// Is this a span like a message?
			elseif (in_array($config_var['type'], array('message', 'warning')))
			{
				echo '
						<dd', $config_var['type'] == 'warning' ? ' class="alert"' : '', (!empty($config_var['force_div_id']) ? ' id="' . $config_var['force_div_id'] . '_dd"' : ''), '>
							', $config_var['label'], '
						</dd>';
			}
			// Otherwise it's an input box of some kind.
			else
			{
				echo '
						<dt', is_array($config_var) && !empty($config_var['force_div_id']) ? ' id="' . $config_var['force_div_id'] . '"' : '', is_array($config_var) && !empty($config_var['invisible']) ? ' style="display:none;"' : '', '>';

				// Some quick helpers...
				$javascript = $config_var['javascript'];
				$disabled = !empty($config_var['disabled']) ? ' disabled="disabled"' : '';
				$subtext = !empty($config_var['subtext']) ? '<br /><span class="smalltext"> ' . $config_var['subtext'] . '</span>' : '';

				// Show the [?] button.
				if ($config_var['help'])
					echo '
							<a id="setting_', $config_var['name'], '" href="', $scripturl, '?action=helpadmin;help=', $config_var['help'], '" onclick="return reqWin(this.href);" class="help"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" border="0" /></a><span', ($config_var['disabled'] ? ' class="disabled"' : ($config_var['invalid'] ? ' class="error"' : '')), '><label id="label_', $config_var['name'], '" for="', $config_var['name'], '">', $config_var['label'], '</label>', $subtext, ($config_var['type'] == 'password' ? '<br /><em>' . $txt['admin_confirm_password'] . '</em>' : ''), '</span>
						</dt>';
				else
					echo '
							<a id="setting_', $config_var['name'], '"></a> <span', ($config_var['disabled'] ? ' class="disabled"' : ($config_var['invalid'] ? ' class="error"' : '')), '><label id="label_', $config_var['name'], '" for="', $config_var['name'], '">', $config_var['label'], '</label>', $subtext, ($config_var['type'] == 'password' ? '<br /><em>' . $txt['admin_confirm_password'] . '</em>' : ''), '</span>
						</dt>';

				echo '
						<dd', (!empty($config_var['force_div_id']) ? ' id="' . $config_var['force_div_id'] . '_dd"' : ''), (is_array($config_var) && !empty($config_var['invisible']) ? ' style="display:none;"' : ''), '>',
							$config_var['preinput'];

				// Show a check box.
				if ($config_var['type'] == 'check')
					echo '
							<input type="checkbox"', $javascript, $disabled, ' name="', $config_var['name'], '" id="', $config_var['name'], '"', ($config_var['value'] ? ' checked="checked"' : ''), ' value="1" class="input_check" />';
				// Escape (via htmlspecialchars.) the text box.
				elseif ($config_var['type'] == 'password')
					echo '
							<input type="password"', $disabled, $javascript, ' name="', $config_var['name'], '[0]"', ($config_var['size'] ? ' size="' . $config_var['size'] . '"' : ''), ' value="*#fakepass#*" onfocus="this.value = \'\'; this.form.', $config_var['name'], '.disabled = false;" class="input_password" /><br />
							<input type="password" disabled="disabled" id="', $config_var['name'], '" name="', $config_var['name'], '[1]"', ($config_var['size'] ? ' size="' . $config_var['size'] . '"' : ''), ' class="input_password" />';
				// Show a selection box.
				elseif ($config_var['type'] == 'select')
				{
					echo '
							<select name="', $config_var['name'], '" id="', $config_var['name'], '" ', $javascript, $disabled, (!empty($config_var['multiple']) ? ' multiple="multiple"' : ''), '>';
					foreach ($config_var['data'] as $option)
						echo '
								<option value="', $option[0], '"', (($option[0] == $config_var['value'] || (!empty($config_var['multiple']) && in_array($option[0], $config_var['value']))) ? ' selected="selected"' : ''), '>', $option[1], '</option>';
					echo '
							</select>';
				}
				// Text area?
				elseif ($config_var['type'] == 'large_text')
				{
					echo '
							<textarea rows="', ($config_var['size'] ? $config_var['size'] : 4), '" cols="40" ', $javascript, $disabled, ' name="', $config_var['name'], '" id="', $config_var['name'], '">', $config_var['value'], '</textarea>';
				}
				// Permission group?
				elseif ($config_var['type'] == 'permissions')
				{
					theme_inline_permissions($config_var['name']);
				}
				// BBC selection?
				elseif ($config_var['type'] == 'bbc')
				{
					echo '
							<fieldset id="', $config_var['name'], '">
								<legend><strong>', $txt['bbcTagsToUse_select'], '</strong></legend>
									<ul class="reset">';

					foreach ($context['bbc_columns'] as $bbcColumn)
					{
						foreach ($bbcColumn as $bbcTag)
							echo '
										<li class="list_bbc align_left shd_bbc_list">
											<input type="checkbox" name="', $config_var['name'], '_enabledTags[]" id="tag_', $config_var['name'], '_', $bbcTag['tag'], '" value="', $bbcTag['tag'], '"', in_array($bbcTag['tag'], $context['enabled_tags'][$config_var['name']]) ? ' checked="checked"' : '', ' class="input_check" /> <label for="tag_', $config_var['name'], '_', $bbcTag['tag'], '">', $bbcTag['tag'], '</label>', $bbcTag['show_help'] ? ' (<a href="' . $scripturl . '?action=helpadmin;help=tag_' . $bbcTag['tag'] . '" onclick="return reqWin(this.href);">?</a>)' : '', '
										</li>';
					}
					echo '			</ul>
								<br class="clear" /><input type="checkbox" id="select_all" onclick="invertAll(this, this.form, \'', $config_var['name'], '_enabledTags\');"', $context['all_enabled'][$config_var['name']] ? ' checked="checked"' : '', ' class="input_check" /> <label for="select_all"><em>', $txt['bbcTagsToUse_select_all'], '</em></label>
							</fieldset>';
				}
				// A simple message?
				elseif ($config_var['type'] == 'var_message')
					echo '
							<div', !empty($config_var['name']) ? ' id="' . $config_var['name'] . '"' : '', '>', $config_var['var_message'], '</div>';
				// Assume it must be a text box.
				else
					echo '
							<input type="text"', $javascript, $disabled, ' name="', $config_var['name'], '" id="', $config_var['name'], '" value="', $config_var['value'], '"', ($config_var['size'] ? ' size="' . $config_var['size'] . '"' : ''), ' class="input_text" />';

				echo isset($config_var['postinput']) ? '
							' . $config_var['postinput'] : '',
					'</dd>';
			}
		}

		else
		{
			// Just show a separator.
			if ($config_var == '')
				echo '
					</dl>
					<hr class="hrcolor" />
					<dl class="permsettings">';
			else
				echo '
						<dd>
							<strong>' . $config_var . '</strong>
						</dd>';
		}
	}

	if ($is_open)
		echo '
						</dl>';

	if (empty($context['settings_save_dont_show']))
		echo '
						<hr class="hrcolor" />
						<div class="righttext">
							<input type="submit" value="', $txt['save'], '"', (!empty($context['save_disabled']) ? ' disabled="disabled"' : ''), (!empty($context['settings_save_onclick']) ? ' onclick="' . $context['settings_save_onclick'] . '"' : ''), ' class="button_submit" />
						</div>';

	if ($is_open)
		echo '
					</div>
				<span class="botslice"><span></span></span>
			</div>
			</div>';

	echo '
		<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
		</form>
	</div>
	<br class="clear" />';

	if (!empty($context['settings_post_javascript']))
		echo '
	<script type="text/javascript"><!-- // --><![CDATA[
	', $context['settings_post_javascript'], '
	// ]]></script>';

	if (!empty($context['settings_insert_below']))
		echo $context['settings_insert_below'];

}

/**
 *	Display the action log.
 *
 *	Little real work is done in this template; mostly is just iterating through the already-processed contents of the action log as done by {@link shd_admin_action_log()}.
 *
 *	@see shd_admin_action_log()
 *	@since 1.0
*/
function template_shd_action_log()
{
	global $settings, $txt, $context, $scripturl, $sort_types, $modSettings;

	// The sort stuff here is huge.
	echo '
				<div class="tborder">
					<div class="cat_bar grid_header">
						<h3 class="catbg">
							<span class="floatright smalltext">', $txt['pages'], ': ', $context['page_index'], '</span>
							<img src="', $settings['default_images_url'], '/simpledesk/log.png" class="icon" alt="*" />
							', $txt['shd_admin_actionlog_title'], '
						</h3>
					</div>
					<table class="shd_ticketlist" cellspacing="0" width="100%">
						<tr class="titlebg">
							<td width="38%" colspan="2">
								<img src="', $settings['default_images_url'], '/simpledesk/action.png" class="shd_smallicon" alt="" />
								<a href="', $scripturl, '?action=admin;area=helpdesk_info;sa=actionlog', $context['sort'] == $sort_types['action'] && !isset($_REQUEST['asc']) ? ';sort=action;asc' : ';sort=action', '">
									', $txt['shd_admin_actionlog_action'], '
								</a>
								', ($context['sort'] == $sort_types['action'] ? '<img src="' . $settings['default_images_url'] . '/' . (isset($_REQUEST['asc']) ? 'sort_up.gif' : 'sort_down.gif' ). '" alt="" />' : ''), '
							</td>
							<td width="20%">
								<img src="', $settings['default_images_url'], '/simpledesk/time.png" class="shd_smallicon" alt="" />
								<a href="', $scripturl, '?action=admin;area=helpdesk_info;sa=actionlog', $context['sort'] == $sort_types['time'] && !isset($_REQUEST['asc']) ? ';sort=time;asc' : ';sort=time', '">
									', $txt['shd_admin_actionlog_date'], '
								</a>
								', ($context['sort'] == $sort_types['time'] ? '<img src="' . $settings['default_images_url'] . '/' . (isset($_REQUEST['asc']) ? 'sort_up.gif' : 'sort_down.gif' ). '" alt="" />' : ''), '
							</td>
							<td width="16%">
								<img src="', $settings['default_images_url'], '/simpledesk/user.png" class="shd_smallicon" alt="" />
								<a href="', $scripturl, '?action=admin;area=helpdesk_info;sa=actionlog', $context['sort'] == $sort_types['member'] && !isset($_REQUEST['asc']) ? ';sort=member;asc' : ';sort=member', '">
									', $txt['shd_admin_actionlog_member'], '
								</a>
								', ($context['sort'] == $sort_types['member'] ? '<img src="' . $settings['default_images_url'] . '/' . (isset($_REQUEST['asc']) ? 'sort_up.gif' : 'sort_down.gif' ). '" alt="" />' : ''), '
							</td>
							<td width="16%">
								<img src="', $settings['default_images_url'], '/simpledesk/position.png" class="shd_smallicon" alt="" />
								<a href="', $scripturl, '?action=admin;area=helpdesk_info;sa=actionlog', $context['sort'] == $sort_types['position'] && !isset($_REQUEST['asc']) ? ';sort=position;asc' : ';sort=position', '">
									', $txt['shd_admin_actionlog_position'], '
								</a>
								', ($context['sort'] == $sort_types['position'] ? '<img src="' . $settings['default_images_url'] . '/' . (isset($_REQUEST['asc']) ? 'sort_up.gif' : 'sort_down.gif' ). '" alt="" />' : ''), '
							</td>
							<td width="10%">
								<img src="', $settings['default_images_url'], '/simpledesk/ip.png" class="shd_smallicon" alt="" />
								<a href="', $scripturl, '?action=admin;area=helpdesk_info;sa=actionlog', $context['sort'] == $sort_types['ip'] && !isset($_REQUEST['asc']) ? ';sort=ip;asc' : ';sort=ip', '">
									', $txt['shd_admin_actionlog_ip'], '
								</a>
								', ($context['sort'] == $sort_types['ip'] ? '<img src="' . $settings['default_images_url'] . '/' . (isset($_REQUEST['asc']) ? 'sort_up.gif' : 'sort_down.gif' ). '" alt="" />' : ''), '
							</td>
							<td width="2%">&nbsp;</td>
						</tr>';

			if (empty($context['actions']))
				echo '
						<tr class="windowbg2">
							<td colspan="7" class="shd_noticket">', $txt['shd_admin_actionlog_none'], '</td>
						</tr>';
			else
			{
				$use_bg2 = true; // start with windowbg2 to differentiate between that and windowbg2
				foreach ($context['actions'] AS $action)
				{
					echo '
						<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
							<td width="1%" class="shd_nowrap">
								<img src="', shd_image_url($action['action_icon']), '" alt="" class="shd_smallicon" />
							</td>
							<td class="smalltext">', $action['action_text'], '</td>
							<td>', $action['time'], '</td>
							<td>', $action['member']['link'], '</td>
							<td>', $action['member']['group'], '</td>
							<td>', !empty($action['member']['ip']) ? $action['member']['ip'] : $txt['shd_admin_actionlog_hidden'], '</td>
							<td>', $action['can_remove'] && $context['can_delete'] ? '<a href="' . $scripturl . '?action=admin;area=helpdesk_info;sa=actionlog;remove='. $action['id'] . '"><img src="' . $settings['default_images_url'] . '/simpledesk/delete.png" alt="' . $txt['shd_delete_item'] . '" /></a>' : '', '</td>
						</tr>';

					$use_bg2 = !$use_bg2;
				}
			}

	echo '
					<tr class="titlebg">
						<td colspan="7">
							<span class="floatright smalltext">', $txt['pages'], ': ', $context['page_index'], '</span>
							<span class="smalltext shd_empty_log"><img src="', $settings['default_images_url'], '/simpledesk/delete.png" alt="X" /> <a href="', $scripturl, '?action=admin;area=helpdesk_info;sa=actionlog', $context['url_sort'], $context['url_order'], ';removeall" onclick="return confirm(', JavaScriptEscape(sprintf($txt['shd_admin_actionlog_removeall_confirm'],$context['hoursdisable'])), ');">', $txt['shd_admin_actionlog_removeall'], '</a></span>
						</td>
					</tr>
					</table>
				</div>';
}

/**
 *	Displays the get-support form for posting directly to the SimpleDesk support board.
 *
 *	This is little more than a simple HTML form, most of the real work is hidden behind the scenes in SimpleDesk's own site.
 *
 *	@see shd_admin_support()
 *	@since 1.0
*/
function template_shd_support()
{
	global $context, $settings, $txt, $forum_version;

	echo '
	<div class="shd_admin_leftcolumn floatleft">
		<div class="tborder">
			<div class="cat_bar grid_header">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/edit.png" alt="*" /> ', $txt['shd_admin_support_form_title'], '
				</h3>
			</div>
				<div class="roundframe">
					<form action="', $context['shd_support_url'], '" method="post" class="content">
						<dl id="post_header">
							<dt><span id="caption_subject">', $txt['subject'], '</span></dt>
							<dd><input type="text" name="subject" tabindex="1" size="80" maxlength="80" class="input_text" /></dd>
						</dl>
						<textarea class="editor" name="message" rows="12" cols="60" tabindex="2" style="width: 90%; height: 150px;"></textarea>
						<br /><br />
						<input type="hidden" value="', $forum_version, '" name="smf_version" />
						<input type="hidden" value="', SHD_VERSION, '" name="shd_version" />
						<input type="submit" value="', $txt['shd_admin_support_send'], '" tabindex="3" accesskey="s" class="button_submit" />
					</form>
				</div>
			<span class="lowerframe"><span></span></span>
		</div>
	</div>
	<div class="shd_admin_rightcolumn floatleft">
		<div class="tborder">
			<div class="title_bar grid_header">
				<h3 class="titlebg sd_no_margin">
					<img src="', $settings['images_url'], '/helptopics.gif" alt="?" /> ', $txt['shd_admin_support_what_is_this'], '
				</h3>
			</div>
			<div class="windowbg2">
				<div class="content smalltext">
					', $txt['shd_admin_support_explanation'], '
				</div>
				<span class="botslice"><span></span></span>
			</div>
		</div>
	</div>
	<br class="clear" />';
}

?>