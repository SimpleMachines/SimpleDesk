<?php
// Version: 1.0

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

?>