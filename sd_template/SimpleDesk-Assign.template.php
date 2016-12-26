<?php
// Version: 2.1; SimpleDesk ticket assignment

/**
 *	Handles ticket assignment.
 *
 *	@package template
 *	@since 1.0
*/

/**
 *	Displays the list of possible users a ticket can have assigned.
 *
 *	Will have been populated by shd_assign() in SimpleDesk-Assign.php, adding into $context['member_list'].
 *
 *	This allows users to assign tickets to other users, or themselves, or to unassign a previously assigned ticket. Future versions will
 *	likely add further options here.
 *
 *	@see shd_assign()
 *	@since 1.0
*/
function template_assign()
{
	global $context, $txt, $scripturl, $settings;

	if (empty($context['shd_return_to']))
		$context['shd_return_to'] = 'ticket';

		template_button_strip(array($context['navigation']['back']));

	echo '
	<div class="cat_bar">
		<h3 class="catbg">
			<img src="', $settings['default_images_url'], '/simpledesk/assign.png" alt="*" />
			', $txt['shd_ticket_assign_ticket'], '
		</h3>
	</div>
	<div class="roundframe">
		<form action="', $scripturl, '?action=helpdesk;sa=assign2;ticket=', $context['ticket_id'], '" method="post" onsubmit="submitonce(this);">
			<dl class="settings">
				<dt>
					<strong>', $txt['shd_ticket_assignedto'], ':</strong>
				</dt>
				<dd>
					', $context['member_list'][$context['ticket_assigned']], '
				</dd>
				<dt>
					<strong>', $txt['shd_ticket_assign_to'], ':</strong>
				</dt>
				<dd>
					<select name="to_user">';

	foreach ($context['member_list'] as $id => $name)
		echo '
						<option value="', $id, '"', ($id == $context['ticket_assigned'] ? ' selected="selected"' : ''), '>', $name, '</option>';

	echo '
					</select>
				</dd>
			</dl>
			<input type="submit" name="cancel" value="', ($context['shd_return_to'] == 'home' ? $txt['shd_cancel_home'] : $txt['shd_cancel_ticket']), '" accesskey="c" class="button_submit" />
			<input type="submit" value="', $txt['shd_ticket_assign_ticket'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />
			<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />';

	if ($context['shd_return_to'] == 'home')
		echo '
			<input type="hidden" name="home" value="1" />';

	echo '
		</form>
	</div>';
}