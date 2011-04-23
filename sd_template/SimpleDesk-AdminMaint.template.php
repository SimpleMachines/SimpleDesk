<?php
// Version: 1.0 Felidae; SimpleDesk's administration maintenance

/**
 *	Displays SimpleDesk's administration maintenance
 *
 *	@package template
 *	@since 1.1
*/

/**
 *	Display the front page of the SimpleDesk admin maintenance, including a list of all the tasks.
 *
 *	@since 1.1
*/
function template_shd_admin_maint_home()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	echo '
	<div id="admincenter">
		<div class="tborder">
			<div class="cat_bar">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/maintenance.png" class="icon" alt="*" />
					', $txt['shd_admin_maint'], '
				</h3>
			</div>
			<p class="description">
				', $txt['shd_admin_maint_desc'], '
			</p>
		</div>';

	// OK, recount all the important figures.
	echo '
		<div class="cat_bar grid_header">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/find_repair.png" alt="*">
				', $txt['shd_admin_maint_findrepair'], '
			</h3>
		</div>
		<div class="roundframe">
			<div class="content">
				<p>', $txt['shd_admin_maint_findrepair_desc'], '</p>
				<form action="', $scripturl, '?action=admin;area=helpdesk_maint;sa=findrepair" method="post">
					<input type="submit" value="', $txt['maintain_run_now'], '" onclick="return submitThisOnce(this);" class="button_submit">
					<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
				</form>
			</div>
		</div>
		<span class="lowerframe"><span></span></span><br />';

	// Reattribute guest posts
	echo '
		<script type="text/javascript"><!-- // --><![CDATA[
		var warningMessage = \'\';

		function checkAttributeValidity()
		{
			origText = \'', $txt['shd_reattribute_confirm'], '\';
			valid = true;

			// Do all the fields!
			if (!document.getElementById(\'to\').value)
				valid = false;
			warningMessage = origText.replace(/%member_to%/, document.getElementById(\'to\').value);

			if (document.getElementById(\'type_email\').checked)
			{
				if (!document.getElementById(\'from_email\').value)
					valid = false;
				warningMessage = warningMessage.replace(/%type%/, \'', addcslashes($txt['shd_reattribute_confirm_email'], "'"), '\').replace(/%find%/, document.getElementById(\'from_email\').value);
			}
			else
			{
				if (!document.getElementById(\'from_name\').value)
					valid = false;
				warningMessage = warningMessage.replace(/%type%/, \'', addcslashes($txt['shd_reattribute_confirm_username'], "'"), '\').replace(/%find%/, document.getElementById(\'from_name\').value);
			}

			document.getElementById(\'do_attribute\').disabled = valid ? \'\' : \'disabled\';

			setTimeout("checkAttributeValidity();", 500);
			return valid;
		}
		setTimeout("checkAttributeValidity();", 500);
		// ]]></script>
		<div class="cat_bar grid_header">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/user.png" alt="*">
				', $txt['shd_admin_maint_reattribute'], '
			</h3>
		</div>
		<div class="roundframe">
			<div class="content">
				<p>', $txt['shd_admin_maint_reattribute_desc'], '</p>
				<form action="', $scripturl, '?action=admin;area=helpdesk_maint;sa=reattribute" method="post">
					<dl class="settings">
						<dt>
							<strong>', $txt['shd_admin_maint_reattribute_posts_made'], '</strong>
						</dt>
						<dt>
							<label for="type_email"><input type="radio" name="type" id="type_email" value="email" checked="checked" class="input_radio">', $txt['shd_admin_maint_reattribute_posts_email'], '</label>
						</dt>
						<dd>
							<input type="text" name="from_email" id="from_email" value="" onclick="document.getElementById(\'type_email\').checked = \'checked\'; document.getElementById(\'from_name\').value = \'\';">
						</dd>
						<dt>
							<label for="type_name"><input type="radio" name="type" id="type_name" value="name" class="input_radio">', $txt['shd_admin_maint_reattribute_posts_user'], '</label>
						</dt>
						<dd>
							<input type="text" name="from_name" id="from_name" value="" onclick="document.getElementById(\'type_name\').checked = \'checked\'; document.getElementById(\'from_email\').value = \'\';" class="input_text">
						</dd>
					</dl>
					<dl class="settings">
						<dt>
							<label for="to"><strong>', $txt['shd_admin_maint_reattribute_posts_to'], '</strong></label>
						</dt>
						<dd>
							<input type="text" name="to" id="to" value="" class="input_text">
						</dd>
					</dl>
					<span><input type="submit" id="do_attribute" value="', $txt['shd_admin_maint_reattribute_btn'], '" onclick="if (!checkAttributeValidity()) return false; return confirm(warningMessage);" class="button_submit" /></span>
					<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
				</form>
			</div>
		</div>
		<span class="lowerframe"><span></span></span><br />
		<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/suggest.js?rc5"></script>
		<script type="text/javascript"><!-- // --><![CDATA[
			var oAttributeMemberSuggest = new smc_AutoSuggest({
				sSelf: \'oAttributeMemberSuggest\',
				sSessionId: \'', $context['session_id'], '\',
				sSessionVar: \'', $context['session_var'], '\',
				sSuggestId: \'attributeMember\',
				sControlId: \'to\',
				sSearchType: \'member\',
				sTextDeleteItem: \'', $txt['autosuggest_delete_item'], '\',
				bItemList: false
			});
		// ]]></script>';

	// Moving home?
	if (!empty($context['dept_list']))
	{
		echo '
		<div class="cat_bar grid_header">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/movedept.png" alt="*">
				', $txt['shd_admin_maint_massdeptmove'], '
			</h3>
		</div>
		<div class="roundframe">
			<div class="content">
				<p>', $txt['shd_admin_maint_massdeptmove_desc'], '</p>
				<form action="', $scripturl, '?action=admin;area=helpdesk_maint;sa=massdeptmove" method="post">
					<p>
						<label for="id_dept_from">', $txt['shd_admin_maint_massdeptmove_from'], ' </label>
						<select name="id_dept_from" id="id_dept_from">';
		foreach ($context['dept_list'] as $id => $dept)
			echo '
							<option value="', $id, '"', $id == 0 ? ' disabled="disabled"' : '', '> =&gt;&nbsp;', $dept, '</option>';

		echo '
						</select>
						<label for="id_dept_to">', $txt['shd_admin_maint_massdeptmove_to'], '</label>
						<select name="id_dept_to" id="id_dept_to">';
		foreach ($context['dept_list'] as $id => $dept)
			echo '
							<option value="', $id, '"', $id == 0 ? ' disabled="disabled"' : '', '> =&gt;&nbsp;', $dept, '</option>';

		echo '
						</select>
					</p>
					<input type="submit" value="', $txt['shd_admin_maint_massdeptmove'], '" onclick="return submitThisOnce(this);" class="button_submit">
					<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
				</form>
			</div>
		</div>
		<span class="lowerframe"><span></span></span><br />';
	}

	// And we're done.
	echo '
	</div>';
}

function template_shd_admin_maint_findrepairdone()
{
	global $context, $settings, $txt, $scripturl;

	echo '
	<div id="admincenter">
		<div class="tborder">
			<div class="cat_bar">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/find_repair.png" class="icon" alt="*" />
					', $txt['shd_admin_maint_findrepair'], '
				</h3>
			</div>
			<p class="description">
				', $txt['shd_admin_maint_findrepair_desc'], '
			</p>
		</div>';

	if (empty($context['maintenance_result']))
	{
		// Yay everything was fine.
		echo '
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="content">
				<p>', $txt['maintain_no_errors'], '</p>
				<p class="padding">
					<a href="', $scripturl, '?action=admin;area=helpdesk_maint;', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_admin_maint_back'], '</a>
				</p>
			</div>
			<span class="botslice"><span></span></span>
		</div>';
	}
	else
	{
		echo '
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="content">
				<p>', $txt['errors_found'], '</p>';

		// Heh, super squeeky buns time!
		// Each test has potentially its own feedback to give. So we'll handle each one separately.
		if (!empty($context['maintenance_result']['zero_tickets']))
			echo '
				<p class="padding">', sprintf($txt['shd_maint_zero_tickets'], $context['maintenance_result']['zero_tickets']), '</p>';
		if (!empty($context['maintenance_result']['zero_msgs']))
			echo '
				<p class="padding">', sprintf($txt['shd_maint_zero_msgs'], $context['maintenance_result']['zero_msgs']), '</p>';
		if (!empty($context['maintenance_result']['deleted']))
			echo '
				<p class="padding">', sprintf($txt['shd_maint_deleted'], $context['maintenance_result']['deleted']), '</p>';
		if (!empty($context['maintenance_result']['first_last']))
			echo '
				<p class="padding">', sprintf($txt['shd_maint_first_last'], $context['maintenance_result']['first_last']), '</p>';
		if (!empty($context['maintenance_result']['status']))
			echo '
				<p class="padding">', sprintf($txt['shd_maint_status'], $context['maintenance_result']['status']), '</p>';
		if (!empty($context['maintenance_result']['starter_updater']))
			echo '
				<p class="padding">', sprintf($txt['shd_maint_starter_updater'], $context['maintenance_result']['starter_updater']), '</p>';
		if (!empty($context['maintenance_result']['invalid_dept']))
			echo '
				<p class="padding">', sprintf($txt['shd_maint_invalid_dept'], $context['maintenance_result']['invalid_dept']), '</p>';

		echo '
				<p class="padding">
					<a href="', $scripturl, '?action=admin;area=helpdesk_maint;', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_admin_maint_back'], '</a>
				</p>
			</div>
			<span class="botslice"><span></span></span>
		</div>';
	}

	// And we're done.
	echo '
	</div>';
}

function template_shd_admin_maint_reattributedone()
{
	global $context, $settings, $txt, $scripturl;

	echo '
	<div id="admincenter">
		<div class="tborder">
			<div class="cat_bar">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/user.png" class="icon" alt="*" />
					', $txt['shd_admin_maint_reattribute'], '
				</h3>
			</div>
			<p class="description">
				', $txt['shd_admin_maint_reattribute_desc'], '
			</p>
		</div>
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="content">
				<p>', $txt['shd_admin_maint_reattribute_success'], '</p>
				<p class="padding">
					<a href="', $scripturl, '?action=admin;area=helpdesk_maint;', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_admin_maint_back'], '</a>
				</p>
			</div>
			<span class="botslice"><span></span></span>
		</div>
	</div>';
}

function template_shd_admin_maint_massdeptmovedone()
{
	global $context, $settings, $txt, $scripturl;

	echo '
	<div id="admincenter">
		<div class="tborder">
			<div class="cat_bar">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/movedept.png" class="icon" alt="*" />
					', $txt['shd_admin_maint_massdeptmove'], '
				</h3>
			</div>
			<p class="description">
				', $txt['shd_admin_maint_massdeptmove_desc'], '
			</p>
		</div>
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="content">
				<p>', $txt['shd_admin_maint_massdeptmove_success'], '</p>
				<p class="padding">
					<a href="', $scripturl, '?action=admin;area=helpdesk_maint;', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_admin_maint_back'], '</a>
				</p>
			</div>
			<span class="botslice"><span></span></span>
		</div>
	</div>';
}

?>