<?php
// Version: 2.1; SimpleDesk's administration maintenance

/**
 *	Displays SimpleDesk's administration maintenance
 *
 *	@package template
 *	@since 2.0
*/

/**
 *	Display the front page of the SimpleDesk admin maintenance, including a list of all the tasks.
 *
 *	@since 2.0
*/
function template_shd_admin_maint_home()
{
	global $context, $settings, $txt, $modSettings, $scripturl;

	// OK, recount all the important figures.
	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/find_repair.png" alt="*">
				', $txt['shd_admin_maint_findrepair'], '
			</h3>
		</div>
		<div class="information">
			<form action="', $scripturl, '?action=admin;area=helpdesk_maint;sa=findrepair" method="post">
				<p>', $txt['shd_admin_maint_findrepair_desc'], '</p><br>
				<input type="submit" value="', $txt['maintain_run_now'], '" onclick="return submitThisOnce(this);" class="button">
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
			</form>
		</div>';

	// Reattribute guest posts
	echo '
		<script type="text/javascript"><!-- // --><![CDATA[
		var warningMessage = \'\';

		function checkAttributeValidity()
		{

		}
		/*setTimeout("checkAttributeValidity();", 500);*/
		// ]]></script>
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/user.png" alt="*">
				', $txt['shd_admin_maint_reattribute'], '
			</h3>
		</div>
		<div class="roundframe noup">
			<form action="', $scripturl, '?action=admin;area=helpdesk_maint;sa=reattribute" method="post">
				<p>', $txt['shd_admin_maint_reattribute_desc'], '</p>
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_admin_maint_reattribute_posts_made'], '</strong>
					</dt>

					<dt>
						<label for="type_email"><input type="radio" name="type" id="type_email" value="email" checked="checked">', $txt['shd_admin_maint_reattribute_posts_email'], '</label>
					</dt>
					<dd>
						<input type="text" name="from_email" id="from_email" value="">
					</dd>

					<dt>
						<label for="type_name"><input type="radio" name="type" id="type_name" value="name">', $txt['shd_admin_maint_reattribute_posts_user'], '</label>
					</dt>
					<dd>
						<input type="text" name="from_name" id="from_name" value="">
					</dd>

					<dt>
						<label for="type_name"><input type="radio" name="type" id="type_starter" value="starter">', $txt['shd_admin_maint_reattribute_posts_starter'], '</label>
					</dt>
					<dd>
						<input type="text" name="from_starter" id="from_starter" value="">
					</dd>
				</dl>
				<dl class="settings">
					<dt>
						<label for="to"><strong>', $txt['shd_admin_maint_reattribute_posts_to'], '</strong></label>
					</dt>
					<dd>
						<input type="text" name="to" id="to" value="">
					</dd>
				</dl>
				<input type="submit" id="do_attribute" value="', $txt['shd_admin_maint_reattribute_btn'], '" onclicks="if (!checkAttributeValidity()) return false; return confirm(warningMessage);" class="button">
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
			</form>
		</div>
		<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/suggest.js?rc5"></script>
		<script type="text/javascript"><!-- // --><![CDATA[
			var oAttributeMemberSuggest = new smc_AutoSuggest({
				sSelf: "oAttributeMemberSuggest",
				sSessionId: "', $context['session_id'], '",
				sSessionVar: "', $context['session_var'], '",
				sSuggestId: "attributeMember",
				sControlId: "to",
				sSearchType: "member",
				sTextDeleteItem: ', JavaScriptEscape($txt['autosuggest_delete_item']), ',
				bItemList: false
			});
			var oAttributeMemberSuggestStarter = new smc_AutoSuggest({
				sSelf: "oAttributeMemberSuggestStarter",
				sSessionId: "', $context['session_id'], '",
				sSessionVar: "', $context['session_var'], '",
				sSuggestId: "attributeStarter",
				sControlId: "from_starter",
				sSearchType: "member",
				sTextDeleteItem: ', JavaScriptEscape($txt['autosuggest_delete_item']), ',
				bItemList: false
			});

			var oAttributeValidator = new shd_AttributeValidate({
				sOrigText: ', JavaScriptEscape($txt['shd_reattribute_confirm']), ',
				sOrigTextStarter: ', JavaScriptEscape($txt['shd_reattribute_confirm_starter']), ',
				sDoAttributeContainerId: "do_attribute",
				sToContainerId: "to",
				sTypeEmailContainerId: "type_email",
				sEmailContainerId: "from_email",
				sEmailConfirmText: ', JavaScriptEscape($txt['shd_reattribute_confirm_email']), ',
				sTypeStarterContainerId: "type_starter",
				sStarterContainerId: "from_starter",
				sTypeFromContainerId: "type_name",
				sFromContainerId: "from_name",
				sFromConfirmText: ', JavaScriptEscape($txt['shd_reattribute_confirm_username']), ',
			});
		// ]]></script>';

	// Moving home?
	if (!empty($context['dept_list']))
	{
		echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/movedept.png" alt="*">
				', $txt['shd_admin_maint_massdeptmove'], '
			</h3>
		</div>
		<div class="roundframe">
			<form action="', $scripturl, '?action=admin;area=helpdesk_maint;sa=massdeptmove" method="post">
				<p>', $txt['shd_admin_maint_massdeptmove_desc'], '</p>
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
				<dl class="settings">
					<dt><input type="checkbox" checked="checked" id="moveopen" name="moveopen"><label for="moveopen">', $txt['shd_admin_maint_massdeptmove_open'], '</label></dt>
					<dt><input type="checkbox" checked="checked" id="moveclosed" name="moveclosed"><label for="moveclosed">', $txt['shd_admin_maint_massdeptmove_closed'], '</label></dt>
					<dt><input type="checkbox" checked="checked" id="movedeleted" name="movedeleted"><label for="movedeleted">', $txt['shd_admin_maint_massdeptmove_deleted'], '</label></dt>
				</dl>
				<br>
				<dl class="settings">
					<dt><input type="checkbox" id="movelast_less" name="movelast_less"> ', sprintf($txt['shd_admin_maint_massdeptmove_lastupd_less'], '<input type="text" name="movelast_less_days" value="30" size="3">'), '</dt>
					<dt><input type="checkbox" id="movelast_more" name="movelast_more"> ', sprintf($txt['shd_admin_maint_massdeptmove_lastupd_more'], '<input type="text" name="movelast_more_days" value="30" size="3">'), '</dt>
				</dl>
				<input type="submit" value="', $txt['shd_admin_maint_massdeptmove'], '" class="button save">
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
			</form>
		</div>';
	}
}

function template_shd_admin_maint_findrepairdone()
{
	global $context, $settings, $txt, $scripturl;

	// Yay everything was fine.
	if (empty($context['maintenance_result']))
		echo '
		<div class="windowbg">
			', $txt['maintain_no_errors'], '
			<br>
			<a href="', $scripturl, '?action=admin;area=helpdesk_maint;', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_admin_maint_back'], '</a>
		</div>';
	else
	{
		echo '
		<div class="windowbg">
			<div class="content">
				<p>', $txt['errors_found'], '</p>';

		// Heh, super squeeky buns time!
		// Each test has potentially its own feedback to give. So we'll handle each one separately.
		foreach (array('zero_tickets', 'zero_msgs', 'deleted', 'first_last', 'status', 'starter_updater', 'invalid_dept') as $maintResult)
			if (!empty($context['maintenance_result'][$maintResult]))
				echo '
				<p class="padding">', sprintf($txt['shd_maint_' . $maintTxt], $context['maintenance_result'][$maintResult]), '</p>';

		echo '
				<p class="padding">
					<a href="', $scripturl, '?action=admin;area=helpdesk_maint;', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_admin_maint_back'], '</a>
				</p>
			</div>
		</div>';
	}
}

function template_shd_admin_maint_reattributedone()
{
	global $context, $settings, $txt, $scripturl;

	echo '
		<div class="windowbg">
			', $txt['shd_admin_maint_reattribute_success'], '
			<br>
			<a href="', $scripturl, '?action=admin;area=helpdesk_maint;', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_admin_maint_back'], '</a>
		</div>';
}

function template_shd_admin_maint_massdeptmovedone()
{
	global $context, $settings, $txt, $scripturl;

	echo '
	<div id="admincenter">
		<div class="windowbg">
			', $txt['shd_admin_maint_massdeptmove_success'], '
			<br>
			<a href="', $scripturl, '?action=admin;area=helpdesk_maint;', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_admin_maint_back'], '</a>
		</div>
	</div>';
}

function template_shd_admin_maint_search()
{
	global $context, $settings, $txt, $scripturl, $modSettings;

	if (isset($_GET['rebuilddone']))
		echo '
		<div class="maintenance_finished">
			', $txt['shd_search_rebuilt'], '
		</div>';

	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/search.png" alt="*">
				', $txt['shd_maint_rebuild_index'], '
			</h3>
		</div>
		<div class="information">
			<form action="', $scripturl, '?action=admin;area=helpdesk_maint;sa=search" method="post">
				<p>', $txt['shd_maint_rebuild_index_desc'], '</p>
				<input type="submit" name="rebuild" value="', $txt['maintain_run_now'], '" onclick="return submitThisOnce(this);" class="button">
				<input type="hidden" name="start" value="0">
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
			</form>
		</div>
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/search.png" alt="*">
				', $txt['shd_maint_search_settings'], '
			</h3>
		</div>
		<div class="roundframe noup">
			<form action="', $scripturl, '?action=admin;area=helpdesk_maint;sa=search" method="post">
				<div class="errorbox">', $txt['shd_maint_search_settings_warning'], '</div>
				<dl class="settings">
					<dt>
						', $txt['shd_search_min_size'], '
					</dt>
					<dd>
						<input type="text" name="shd_search_min_size" size="4" value="', $modSettings['shd_search_min_size'], '">
					</dd>
					<dt>
						', $txt['shd_search_max_size'], '
					</dt>
					<dd>
						<input type="text" name="shd_search_max_size" size="4" value="', $modSettings['shd_search_max_size'], '">
					</dd>
					<dt>
						<a id="setting_shd_search_prefix_size" href="', $scripturl, '?action=helpadmin;help=shd_search_prefix_size_help" class="help shd_help"><img src="', $settings['images_url'], '/helptopics.png" class="icon" alt="?"></a>
						<span>', $txt['shd_search_prefix_size'], '</span>
					</dt>
					<dd>
						<input type="text" name="shd_search_prefix_size" size="4" value="', $modSettings['shd_search_prefix_size'], '">
					</dd>
					<dt>
						', $txt['shd_search_charset'], '
					</dt>
					<dd>
						<textarea name="shd_search_charset" rows="3" cols="35" style="width: 99%;">', htmlspecialchars($modSettings['shd_search_charset']), '</textarea>
					</dd>
				</dl>
				<input type="submit" name="save" value="', $txt['save'], '" class="button">
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
			</form>
		</div>';
}