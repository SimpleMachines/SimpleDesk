<?php
// Version: 1.0 Felidae; SimpleDesk ticket <-> topic template

/**
 *	This file handles gathering user options when moving a ticket to/from the helpdesk, from/to
 *	a forum thread, specifically getting details like whether to send a PM to the user (including the PM contents), as well as if sending
 *	to a board, which board.
 *
 *	@package template
 *	@since 1.0
*/

/**
 *	Display a list of requirements for moving a ticket to a topic.
 *
 *	When moving a ticket to the forum, certain information is required: the board to move to, whether to send the ticket starter a
 *	personal message (and if so, the contents of the message) and what to do in the event there are deleted replies to deal with.
 *	This function handles showing the form to the user.
 *
 *	@see shd_tickettotopic()
 *	@see shd_tickettotopic2()
 *
 *	@since 1.0
*/
function template_shd_tickettotopic()
{
	global $txt, $settings, $context, $scripturl, $modSettings;

	// Back to the helpdesk.
	echo '
		<div class="floatleft">
			', template_button_strip(array($context['navigation']['back']), 'bottom'), '
		</div><br class="clear" /><br />';

	echo '
		<div class="cat_bar grid_header">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'] , '/simpledesk/tickettotopic.png" alt="*" />
				', $txt['shd_move_ticket_to_topic'], '
			</h3>
		</div>
		<div class="roundframe">
		<form action="', $scripturl, '?action=helpdesk;sa=tickettotopic2;ticket=', $context['ticket_id'], '" method="post" onsubmit="submitonce(this);">
			<div class="content">
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_ticket_board'], ':</strong>
					</dt>
					<dd>
						<select name="toboard">';

	foreach ($context['categories'] as $category)
	{
		echo '
							<optgroup label="', $category['name'], '">';

		foreach ($category['boards'] as $board)
			echo '
								<option value="', $board['id'], '"', $board['selected'] ? ' selected="selected"' : '', '>', $board['child_level'] > 0 ? str_repeat('==', $board['child_level']-1) . '=&gt; ' : '', $board['name'], '</option>';
		echo '
							</optgroup>';
	}

	echo '
						</select>
					</dd>
					<dt>
						<strong>', $txt['shd_move_send_pm'], ':</strong>
					</dt>
					<dd>
						<input type="checkbox" name="send_pm" id="send_pm" checked="checked" onclick="document.getElementById(\'pm_message\').style.display = this.checked ? \'block\' : \'none\';" class="input_check" />
					</dd>
				</dl>
				<fieldset id="pm_message">
					<dl class="settings">
						<dt>
							', $txt['shd_move_why'], '
						</dt>
						<dd>
							<textarea name="pm_content" rows="9" cols="70">', $txt['shd_move_default'], '</textarea>
						</dd>
					</dl>
				</fieldset>';

	if (!empty($context['deleted_prompt']))
	{
		echo '
				<br />
				<fieldset id="deleted_replies">
					<dl class="settings">
						<dt>
							', $txt['shd_ticket_move_deleted'], '
						</dt>
						<dd>
							<select name="deleted_replies">
								<option value="abort">', $txt['shd_ticket_move_deleted_abort'], '</option>
								<option value="delete">', $txt['shd_ticket_move_deleted_delete'], '</option>
								<option value="undelete">', $txt['shd_ticket_move_deleted_undelete'], '</option>
							</select>
						</dd>
					</dl>
				</fieldset>';
	}

	echo '
				<input type="submit" value="', $txt['shd_move_ticket'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />
				<input type="submit" name="cancel" value="', $txt['shd_cancel_ticket'], '" accesskey="c" class="button_submit" />
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
				<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
			</div>
		</form>
		</div>
		<span class="lowerframe"><span></span></span>';
}

/**
 *	Display a list of requirements for moving a topic to a ticket.
 *
 *	When moving a ticket from the forum, only a little information is required; basically, whether to send a personal message (and what message)
 *	to the topic/ticket starter or not.
 *
 *	@see shd_topictoticket()
 *	@see shd_topictoticket2()
 *
 *	@since 1.0
*/
function template_shd_topictoticket()
{
	global $txt, $settings, $context, $scripturl;
	echo '
		<div class="cat_bar grid_header">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'] , '/simpledesk/topictoticket.png" alt="*" />
				', $txt['shd_move_topic_to_ticket'], '
			</h3>
		</div>
		<div class="roundframe">
		<form action="', $scripturl, '?action=helpdesk;sa=topictoticket2;topic=', $context['topic_id'], '" method="post" onsubmit="submitonce(this);">
			<div class="content">
				<dl class="settings">
					<dt>
						<strong>', $txt['shd_move_send_pm_topic'], ':</strong>
					</dt>
					<dd>
						<input type="checkbox" name="send_pm" id="send_pm" checked="checked" onclick="document.getElementById(\'pm_message\').style.display = this.checked ? \'block\' : \'none\';" class="input_check" />
					</dd>
				</dl>
				<fieldset id="pm_message">
					<dl class="settings">
						<dt>
							', $txt['shd_move_why_topic'], '
						</dt>
						<dd>
							<textarea name="pm_content" rows="9" cols="70">', $txt['shd_move_default_topic'], '</textarea>
						</dd>
					</dl>
				</fieldset>
				<input type="submit" value="', $txt['shd_move_topic'], '" onclick="return submitThisOnce(this);" accesskey="s" class="button_submit" />
				<input type="submit" name="cancel" value="', $txt['shd_cancel_topic'], '" accesskey="c" class="button_submit" />
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
				<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
			</div>
		</form>
		</div>
		<span class="lowerframe"><span></span></span>';
}

?>