<?php
// Version: 1.0 Felidae; SimpleDesk department moving.

/**
 *	Handles moving a ticket between departments.
 *
 *	@package template
 *	@since 1.0
*/

/**
 *	Displays the list of possible users a ticket can have assigned.
 *
 *	Will have been populated by shd_movedept() in SimpleDesk-MoveDept.php, adding into $context['dept_list'].
 *
 *	@see shd_movedept()
 *	@since 1.1
*/
function template_movedept()
{
	global $context, $txt, $scripturl, $settings;

	if (empty($context['shd_return_to']))
		$context['shd_return_to'] = 'ticket';

	// Back to the helpdesk.
	echo '
		<div class="floatleft">
			', template_button_strip(array($context['navigation']['back']), 'bottom'), '
		</div><br class="clear" /><br />';

	echo '
	<div class="cat_bar grid_header">
		<h3 class="catbg">
			<img src="', $settings['default_images_url'], '/simpledesk/movedept.png" alt="*" />
			', $txt['shd_ticket_move_dept'], '
		</h3>
	</div>
	<div class="roundframe">
		<form action="', $scripturl, '?action=helpdesk;sa=movedept2;ticket=', $context['ticket_id'], '" method="post" onsubmit="submitonce(this);">
			<div class="content">
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_current_dept'], ':</strong>
					</dt>
					<dd>
						<a href="', $scripturl, '?action=helpdesk;sa=main;dept=', $context['current_dept'], '">', $context['current_dept_name'], '</a>
					</dd>
					<dt>
						<strong>', $txt['shd_ticket_move_to'], ':</strong>
						<div class="smalltext">', $context['visible_move_dept'], '</div>
					</dt>
					<dd>
						<select name="to_dept">';

	foreach ($context['dept_list'] as $id => $name)
		echo '
							<option value="', $id, '"', ($id == $context['current_dept'] ? ' selected="selected"' : ''), '>', $name, '</option>';

	echo '
						</select>
					</dd>
					<dt>
						<input type="submit" name="cancel" value="', ($context['shd_return_to'] == 'home' ? $txt['shd_cancel_home'] : $txt['shd_cancel_ticket']), '" accesskey="c" class="button_submit" />
					</dt>
					<dd>
						<input type="submit" value="', $txt['shd_ticket_move'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />
					</dd>
				</dl>
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />';

	if ($context['shd_return_to'] == 'home')
		echo '
				<input type="hidden" name="home" value="1" />';

	echo '
			</div>
		</form>
	</div>
	<span class="lowerframe"><span></span></span>';
}

?>