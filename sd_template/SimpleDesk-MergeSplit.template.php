<?php
// Version: 1.0 Felidae; SimpleDesk merge/split template

/**
 *	This file handles gathering information from users for splitting and merging topics.
 *
 *	@package template
 *	@since 1.1
*/

/**
 *	Display a list of requirements for merging tickets
 *
 *	@see shd_merge_ticket()
 *	@see shd_merge_ticket2()
 *
 *	@since 1.1
*/
function template_shd_merge_ticket()
{
	global $txt, $settings, $context, $scripturl, $modSettings;

	// Back to the helpdesk.
	echo '
		<div class="floatleft">
			', template_button_strip(array($context['navigation']['back']), 'bottom'), '
		</div><br class="clear" />';

	echo '
		<div class="cat_bar grid_header">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'] , '/simpledesk/merge.png" alt="*" />
				', $txt['shd_ticket_merge_tickets'], '
			</h3>
		</div>
		<div class="roundframe">
		<form action="', $scripturl, '?action=helpdesk;sa=mergeticket2;ticket=', $context['ticket_id'], '" method="post" onsubmit="submitonce(this);">
			<div class="content">
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_ticket_to_merge'], ':</strong>
					</dt>
					<dd>
						', $context['current_ticket']['subject'], '
					</dd>
					<dt>
						<strong>', $txt['shd_merge_send_pm'], ':</strong>
					</dt>
					<dd>
						<input type="checkbox" name="send_pm" id="send_pm" checked="checked" onclick="document.getElementById(\'pm_message\').style.display = this.checked ? \'block\' : \'none\';" class="input_check" />
					</dd>
				</dl>
				<fieldset id="pm_message">
					<dl class="settings">
						<dt>
							', $txt['shd_merge_why'], '
						</dt>
						<dd>
							<textarea name="pm_content" rows="9" cols="70">', $txt['shd_merge_default_msg'], '</textarea>
						</dd>
					</dl>
				</fieldset>';

	echo '
				<input type="submit" value="', $txt['shd_merge_ticket'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />
				<input type="submit" name="cancel" value="', $txt['shd_cancel_ticket'], '" accesskey="c" class="button_submit" />
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
				<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
			</div>
		</form>
		</div>
		<span class="lowerframe"><span></span></span>';
}

/**
 *	Display the information requirements for splitting tickets.
 *
 *	@see shd_split_ticket()
 *	@see shd_split_ticket2()
 *
 *	@since 1.1
*/
function template_shd_split_ticket()
{
	global $context, $txt, $scripturl, $settings;

	// Back to the helpdesk.
	echo '
		<div class="floatleft">
			', template_button_strip(array($context['navigation']['back']), 'bottom'), '
		</div><br class="clear" />';

	echo '
	<div class="cat_bar grid_header">
		<h3 class="catbg">
			<img src="', $settings['default_images_url'], '/simpledesk/split.png" alt="*" />
			', $txt['shd_split_ticket'], '
		</h3>
	</div>
	<div class="roundframe">
		<form action="', $scripturl, '?action=helpdesk;sa=splitticket2;ticket=', $context['ticket_id'], '" method="post" onsubmit="submitonce(this);">
			<div class="content">
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_split_new_subject'], ':</strong>
					</dt>
					<dd>
						<input type="text" size="50" name="new_subject" value="', $context['ticket_title'], '" />
					</dd>
					<dt>
						<strong>', $txt['shd_split_type'], '</strong>
					</dt>
					<dd>
						<input type="radio" name="split_type" id="onlythis" value="onlythis" checked="checked" class="input_radio" /><label for="onlythis">', $txt['shd_split_only_this'], '</label><br />
						<input type="radio" name="split_type" id="afterthis" value="afterthis" class="input_radio" /><label for="afterthis">', $txt['shd_split_after_this'], '</label>
					</dd>
					<dt>
						<strong>', $txt['shd_split_send_pm'], ':</strong>
						<div class="smalltext">', $txt['shd_split_why_note'], '</div>
					</dt>
					<dd>
						<input type="checkbox" name="send_pm" id="send_pm" checked="checked" onclick="document.getElementById(\'pm_message\').style.display = this.checked ? \'block\' : \'none\';" class="input_check" />
					</dd>
				</dl>
				<fieldset id="pm_message">
					<dl class="settings">
						<dt>
							', $txt['shd_split_why'], '
						</dt>
						<dd>
							<textarea name="pm_content" rows="9" cols="70">', $txt['shd_split_default_msg'], '</textarea>
						</dd>
					</dl>
				</fieldset>
				<div style="margin-top:5px;">
					<input type="submit" class="button_submit" value="', $txt['shd_split_ticket'], '" />
				</div>
			</div>
			<input type="hidden" name="at_msg" value="', $_REQUEST['at_msg'], '" />
			<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
		</form>
	</div>
	<span class="lowerframe"><span></span></span>';
}

/**
 *	Display a choice of options to the user of where to go once a ticket has been split.
 *
 *	@see shd_split_ticket2()
 *
 *	@since 1.1
*/
function template_shd_split_ticket2()
{
	global $context, $txt, $scripturl, $settings;

	// Back to the helpdesk.
	echo '
		<div class="floatleft">
			', template_button_strip(array($context['navigation']['back']), 'bottom'), '
		</div><br class="clear" />';

	echo '
	<div class="cat_bar grid_header">
		<h3 class="catbg">
			<img src="', $settings['default_images_url'], '/simpledesk/split.png" alt="*" />
			', $txt['shd_split_ticket'], '
		</h3>
	</div>
	<div class="roundframe">
		<div class="content">
			<p class="split_topics"><strong>', $txt['shd_split_done'], '</strong></p>
			<ul class="reset split_topics">
				<li><a href="', $scripturl, '?action=helpdesk;sa=main">', $txt['shd_home'], '</a></li>
				<li><a href="', $scripturl, '?action=helpdesk;sa=ticket;ticket=', $context['split_info']['ticket'], '">', $txt['shd_split_origin_ticket'], '</a> (', $context['split_info']['subject'], ')</li>
				<li><a href="', $scripturl, '?action=helpdesk;sa=ticket;ticket=', $context['split_info']['otherticket'], '">', $txt['shd_split_new_ticket'], '</a> (', $context['split_info']['othersubject'], ')</li>
			</ul>
		</div>
	</div>
	<span class="lowerframe"><span></span></span>';
}
?>