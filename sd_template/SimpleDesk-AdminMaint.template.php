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
					<input type="submit" value="', $txt['maintain_run_now'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit">
					<input type="hidden" name="template" value="1">
					<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
				</form>
			</div>
		</div>
		<span class="lowerframe"><span></span></span>';

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

?>