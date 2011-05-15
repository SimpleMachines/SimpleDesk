<?php
// Version: 2.0 Anatidae; SimpleDesk alternate front page template

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

?>