<?php
// Version: 1.0 Felidae; SimpleDesk posting and replying

/**
 *	This file handles everything concerning posting, including displaying the display of ticket facia
 *	around a post box, display of replies with insert-quote links, the postbox, attachments, errors etc.
 *
 *	@package template
 *	@todo Finish documenting this file.
 *	@since 1.0
*/

/**
 *	Entry point for displaying the post new ticket/edit ticket UI.
 *
 *	@since 1.0
*/

function template_ticket_post()
{
	global $context;

	// Back to the helpdesk.
	echo '
		<div class="floatleft">
			', template_button_strip(array($context['navigation']['back']), 'bottom'), '
		</div><br class="clear" /><br />';

	template_preview();
	template_ticket_info();
	template_ticket_subjectbox();
	template_ticket_meta();
	template_ticket_postbox();
	template_ticket_footer();
	if (!empty($context['ticket_form']['do_replies']))
	{
		template_ticket_begin_replies();
		template_ticket_do_replies();
		template_ticket_end_replies();
	}
	template_ticket_pageend();
	template_ticket_proxy_js();
}

function template_reply_post()
{
	global $context;

	template_ticket_info();
	template_ticket_content();
	template_ticket_meta();
	template_ticket_footer();
	template_preview();
	template_ticket_shd_replyarea();
	if (!empty($context['ticket_form']['do_replies']))
	{
		template_ticket_begin_replies();
		template_ticket_do_replies();
		template_ticket_end_replies();
	}
	template_ticket_pageend();
}

// yes, this isn't strictly conventional SMF style
function template_ticket_option($option)
{
	global $context, $txt;

	if (!empty($context['ticket_form'][$option]['can_change']))
	{
		echo '
								<select name="shd_' . $option . '">';
		foreach ($context['ticket_form'][$option]['options'] as $value => $caption)
		{
			echo '
									<option value="', $value, '"', ($value == $context['ticket_form'][$option]['setting'] ? ' selected="selected"' : ''), '>', $txt[$caption], '</option>';
		}
		echo '
								</select>';
	}
	else
		echo $txt[$context['ticket_form'][$option]['options'][$context['ticket_form'][$option]['setting']]];
}

function template_ticket_info()
{
	global $context, $txt, $scripturl, $settings, $modSettings, $options;

	echo '
			<form action="', $context['ticket_form']['form_action'], '" method="post" accept-charset="', $context['character_set'], '" name="postmodify" id="postmodify" onsubmit="', 'submitonce(this);smc_saveEntities(\'postmodify\', [\'subject\', \'', $context['post_box_name'], '\'], \'options\');" enctype="multipart/form-data" style="margin: 0;">
			<div class="cat_bar grid_header">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/ticket.png" alt="x" /> ', $context['ticket_form']['form_title'], '
				</h3>
			</div>
			<div class="windowbg">
				<div class="content shd_ticket">';

	// General ticket details
	echo '
					<div class="information shd_ticketdetails">
						<strong><img src="', $settings['default_images_url'], '/simpledesk/details.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_details'], '</strong>
						<hr />
						<ul class="reset">';

	if (!empty($context['ticket_form']['display_id']))
		echo '
							<li><img src="', $settings['default_images_url'], '/simpledesk/id.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_id'], ': ', $context['ticket_form']['display_id'], '</li>';

	if (!empty($context['ticket_form']['member']['link']))
		echo '
							<li><img src="', $settings['default_images_url'], '/simpledesk/user.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_user'], ': ', $context['ticket_form']['member']['link'], '</li>';

	echo '
							<li>
								<img src="', $settings['default_images_url'], '/simpledesk/urgency.png" alt="" class="shd_smallicon" />
								', $txt['shd_ticket_urgency'], ': ', template_ticket_option('urgency'), '
							</li>';

	// New tickets aren't assigned - ever - but existing ones might be
	if (!empty($context['ticket_form']['ticket']))
		echo '
							<li><img src="', $settings['default_images_url'], '/simpledesk/staff.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_assignedto'], ': ', !empty($context['ticket_form']['assigned']['link']) ? $context['ticket_form']['assigned']['link'] : '<span class="error">' . $txt['shd_unassigned'] . '</span>', '</li>';

	echo '
							<li><img src="', $settings['default_images_url'], '/simpledesk/status.png" alt="" class="shd_smallicon"/> ', $txt['shd_ticket_status'], ': ', $txt['shd_status_' . $context['ticket_form']['status']], '</li>';

	if (!empty($context['display_private']))
		echo '
							<li>
								<img src="', $settings['default_images_url'], '/simpledesk/private.png" alt="" class="shd_smallicon" />
								', $txt['shd_ticket_privacy'], ': ', template_ticket_option('private'), '
							</li>
						</ul>';

	// Display ticket poster avatar?
	if (!empty($modSettings['shd_display_avatar']) && empty($options['show_no_avatars']) && !empty($context['ticket_form']['member']['avatar']['image']))
		echo '
						<div class="shd_ticket_avatar">
							', shd_profile_link($context['ticket_form']['member']['avatar']['image'], $context['ticket_form']['member']['id']), '
						</div>';

	echo '
					</div>';
}

function template_ticket_custom_fields()
{
	global $context, $settings;

	// No point showing the box if there's nothing to show in it
	if (empty($context['ticket_form']['custom_fields']))
		return;

	echo '
				<div class="information shd_customfields">';

		// Loop through each custom field
		foreach ($context['ticket_form']['custom_fields'] as $field)
		{
			echo '
					<dl class="settings">
						<dt id="field-' . $field['id'] . '">
							', !empty($field['icon']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '" alt="" />' : '', '
							<strong>' . $field['name'] . ': </strong><br />
							<span class="smalltext">' . $field['desc'] . '</span>
						</dt>';

			// Text
			if ($field['type'] == 1)
				echo '
						<dd><input type="text" name="field-' . $field['id'] . '" value="' . $field['default_value'] . '" size="50" /></dd>';
			// Textarea
			elseif ($field['type'] == 2)
				echo '
						<dd><textarea name="field-' . $field['id'] . '"', !empty($field['default_value']) ? ' rows="' . $field['default_value'][0] . '" cols="' . $field['default_value'][1] . '" ' : '', '> </textarea></dd>';
			// Integers only
			elseif ($field['type'] == 3)
				echo '
						<dd><input name="field-' . $field['id'] . '" value="' . $field['default_value'] . ' size="10 /></dd>';
			// Floating numbers
			elseif ($field['type'] == 4)
				echo '
						<dd><input name="field-' . $field['id'] . '" value="' . $field['default_value'] . ' size="10 /></dd>';
			// Select boxes
			elseif ($field['type'] == 5)
			{
				echo '
						<dd>
							<select name="field-' . $field['id'] . '">';

				foreach ($field['options'] as $option)
				{
					echo '
								<option value="' . $option . '">' . $option . '&nbsp;</option>';
				}

				echo '
							</select>
						</dd>';
			}
			// Checkboxes!
			elseif ($field['type'] == 6)
				echo '
						<dd><input name="field-' . $field['id'] . '" type="checkbox" ' . $field['default_value'] == 1 ? 'checked="checked"' : '' . '/></dd>';
			// Last one, radio buttons
			elseif ($field['type'] == 7)
			{
				foreach ($field['options'] as $option)
				{
					echo '
						<dd><input name="field-' . $field['id'] . '" type="radio" value="' . $option . '" /> <span>' . $option . '</span></dd>';
				}
			}
			// Default to a text input field
			else
				echo '
						<dd><input type="text" name="field-' . $field['id'] . '" value="' . $field['default_value'] . '" size="50" /></dd>';

			echo '
					</dl>
					<hr class="hrcolor" />';
		}

	echo '
				</div>';
}

function template_ticket_posterrors()
{
	global $context, $txt;

	// Did anything go wrong?
	if (!empty($context['shd_errors']))
	{
		echo '
						<div class="errorbox" id="errors">
							<dl>
								<dt>
									<strong style="" id="error_serious">', $txt['shd_ticket_post_error'], ':</strong>
								</dt>
								<dt class="error" id="error_list">';

		foreach ($context['shd_errors'] as $error)
			echo '
									', $txt['error_' . $error], '<br />';

		echo '
								</dt>
							</dl>
						</div>';
	}
}

function template_ticket_subjectbox()
{
	global $context, $txt, $scripturl, $settings, $modSettings;

	echo '
					<div class="shd_ticket_description">';

	template_ticket_posterrors();
	echo '
						<img src="', $settings['default_images_url'], '/simpledesk/name.png" alt="" class="shd_smallicon" /> <strong>', $txt['shd_ticket_subject'], ':</strong>
						<input type="text" name="subject" size="50" maxlength="100" class="input_text" value="', $context['ticket_form']['subject'], '" tabindex="', $context['tabindex']++, '" />';

	// Are we dealing with proxy tickets?
	if (!empty($context['can_post_proxy']))
	{
		echo '
						<br />
						<input type="hidden" name="proxy" value="" />
						<img src="', $settings['default_images_url'], '/simpledesk/proxy.png" alt="" class="shd_smallicon" /> <strong>', $txt['shd_ticket_proxy'], ':</strong>
						<input type="text" name="proxy_author" id="proxy_author" size="50" maxlength="100" class="input_text" value="', (empty($context['ticket_form']['proxy']) ? '' : $context['ticket_form']['proxy']), '" tabindex="', $context['tabindex']++, '" />';
	}

	echo '
						<hr /><br />
							';
}

function template_ticket_proxy_js()
{
	global $context, $txt, $scripturl, $settings, $modSettings;
	if (empty($context['can_post_proxy']))
		return;

	echo '
		<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/suggest.js?rc3"></script>
		<script type="text/javascript"><!-- // --><![CDATA[
			var oProxyAutoSuggest = new smc_AutoSuggest({
				sSelf: \'oProxyAutoSuggest\',
				sSessionId: \'', $context['session_id'], '\',
				sSessionVar: \'', $context['session_var'], '\',
				sControlId: \'proxy_author\',
				sSearchType: \'member\',
				sPostName: \'proxy_author_form\',
				sURLMask: \'action=profile;u=%item_id%\',
				bItemList: false,
				iMaxDisplayQuantity: 1
			});
		// ]', ']></script>';
}

function template_ticket_content()
{
	global $context, $txt, $scripturl, $settings, $modSettings;

	echo '
					<div class="shd_ticket_description">';

	template_ticket_posterrors();
	echo '
						<img src="', $settings['default_images_url'], '/simpledesk/name.png" alt="" class="shd_smallicon" /> <strong>', $context['ticket_form']['subject'], '</strong>
						<hr /><br />
							', $context['ticket_form']['message'];

	if ($settings['show_modify'] && !empty($context['ticket']['modified']))
	{
		echo '
						<div class="smalltext shd_modified" style="margin-top:20px;">
							&#171; <em>', $txt['last_edit'], ': ', $context['ticket']['modified']['time'], ' ', $txt['by'], ' ', $context['ticket']['modified']['link'], '</em> &#187;
						</div>';
	}
}

function template_ticket_meta()
{
	global $context;

	// Management/meta information
	echo '
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
						<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />';

	if (!empty($context['ticket_form']['ticket']))
		echo '
						<input type="hidden" name="ticket" value="', $context['ticket_form']['ticket'], '" />';

	if (!empty($context['ticket_form']['msg']))
		echo '
						<input type="hidden" name="msg" value="', $context['ticket_form']['msg'], '" />';

	if (!empty($context['ticket_form']['num_replies']))
		echo '
						<input type="hidden" name="num_replies" value="', $context['ticket_form']['num_replies'], '" />';
}

function template_ticket_shd_replyarea()
{
	global $context, $settings, $scripturl, $txt;
	echo '
			<div class="tborder">
				<div class="title_bar">
					<h3 class="titlebg grid_header">
						<img src="', $settings['default_images_url'], '/simpledesk/respond.png" alt="x" />
						', !empty($context['ticket_form']['form_title']) ? $context['ticket_form']['form_title'] : $txt['shd_reply_ticket'], '
					</h3>
				</div>
				<div class="roundframe">
					<div class="content">';

		template_ticket_postbox();

		echo '
					</div>
				</div>
				<span class="lowerframe"><span></span></span>
			</div>
			<br />';
}

function template_ticket_postbox()
{
	global $modSettings, $context, $txt;
	$editor_context = &$context['controls']['richedit'][$context['post_box_name']];

	// The postbox
	echo '
						<div id="shd_bbcbox"', ((empty($modSettings['shd_allow_ticket_bbc']) || !empty($context['shd_display'])) ? ' style="display:none;"' : ''), '></div>
						<div id="shd_smileybox"', ((empty($modSettings['shd_allow_ticket_smileys']) || !empty($context['shd_display'])) ? ' style="display:none;"' : ''), '></div>';

	echo template_control_richedit($context['post_box_name'], 'shd_smileybox', 'shd_bbcbox');

	// Custom fields
	template_ticket_custom_fields();

	// Additional ticket options (attachments, smileys, etc)
	template_ticket_additional_options();

	echo '
						<br class="clear" />
						<span class="smalltext"><br />', $context['browser']['is_firefox'] ? $txt['shortcuts_firefox'] : $txt['shortcuts'], '</span><br />
						<input type="submit" value="', isset($editor_context['labels']['post_button']) ? $editor_context['labels']['post_button'] : $txt['post'], '" tabindex="', $context['tabindex']++, '" accesskey="s" class="button_submit" />
						<input class="button_submit" type="submit" name="preview" value="', $txt['preview'], '" accesskey="p" tabindex="', $context['tabindex']++, '" />';

}

function template_ticket_footer()
{
	global $settings, $context, $txt;

	if ($settings['show_modify'] && !empty($context['ticket_form']['modified']))
	{
		echo '
						<div class="smalltext shd_modified" style="margin-top:20px;">
							&#171; <em>', $txt['last_edit'], ': ', $context['ticket_form']['modified']['time'], ' ', $txt['by'], ' ', $context['ticket_form']['modified']['link'], '</em> &#187;
						</div>';
	}

	echo '
					</div>
				</div>
				<br class="clear" />
				<span class="botslice"><span></span></span>
			</div>
			<br />';
}

function template_preview()
{
	global $context, $txt, $settings;

	if (!empty($context['ticket_form']['preview']))
	{
		echo '
			<div class="tborder">
			<div class="title_bar grid_header">
				<h3 class="titlebg">
					<img src="', $settings['default_images_url'], '/simpledesk/preview.png" alt="x" />
					', !empty($context['ticket_form']['preview']['title']) ? $context['ticket_form']['preview']['title'] : $txt['preview'], '
				</h3>
			</div>
			<div class="roundframe">
				<div class="content">
					', $context['ticket_form']['preview']['body'], '
				</div>
			</div>
			<span class="lowerframe"><span></span></span>
			</div>
			<br />';
	}
}

function template_ticket_additional_options()
{
	global $context, $options, $txt, $modSettings;

	echo '
					<div class="information shd_reply_attachments" id="shd_attach_container"', !empty($context['shd_display']) ? ' style="display:none;"' : '', '>
						<ul class="post_options">';

	foreach ($context['ticket_form']['additional_opts'] as $key => $details)
	{
		if (!empty($details['show']))
			echo '
							<li><label for="', $key, '"><input type="checkbox" name="', $key, '" id="', $key, '"', (!empty($details['checked']) ? ' checked="checked"' : ''), ' value="1" class="input_check" /> ', $details['text'], '</label></li>';
	}

	echo '
						</ul>
						<hr />';

	if (empty($context['current_attachments']) && empty($context['ticket_form']['do_attach']))
		return;

	if (!empty($context['current_attachments']))
	{
		echo '
						<dl id="postAttachment">
							<dt>
								', $txt['attached'], ':
							</dt>
							<dd class="smalltext">
								<input type="hidden" name="attach_del[]" value="0" />
								', $txt['uncheck_unwatchd_attach'], ':
							</dd>';
		foreach ($context['current_attachments'] as $attachment)
			echo '
							<dd class="smalltext">
								<label for="attachment_', $attachment['id'], '"><input type="checkbox" id="attachment_', $attachment['id'], '" name="attach_del[]" value="', $attachment['id'], '"', empty($attachment['unchecked']) ? ' checked="checked"' : '', ' class="input_check" onclick="javascript:oAttach.checkActive();" /> ', $attachment['name'], '</label>
							</dd>';
		echo '
						</dl>';
	}

	if (!empty($context['ticket_form']['do_attach']))
	{
		// JS for our pretty widget
		echo '
						<dl id="postAttachment2">
							<dt>
								', $txt['attach'], ':
							</dt>
							<dd class="smalltext">
								<input type="file" size="60" name="attachment" id="shd_attach" class="input_file" />
								<div id="shd_attachlist_container"></div>
							</dd>';

		echo '
							<dd class="smalltext">';

		// Show some useful information such as allowed extensions, maximum size and amount of attachments allowed.
		if (!empty($modSettings['attachmentCheckExtensions']))
			echo '
								', $txt['allowed_types'], ': ', $context['allowed_extensions'], '<br />';

		if (!empty($context['attachment_restrictions']))
			echo '
								', $txt['attach_restrictions'], ' ', implode(', ', $context['attachment_restrictions']), '<br />';

		echo '
							</dd>
						</dl>
					</div>
					<script type="text/javascript"><!-- // --><![CDATA[
	var oAttach = new shd_attach_select({
		file_item: "shd_attach",
		file_container: "shd_attachlist_container",
		max: ', $context['ticket_form']['num_allowed_attachments'], ',
		message_txt_delete: ', JavaScriptEscape($txt['remove']);

		if (!empty($modSettings['attachmentExtensions']) && !empty($modSettings['attachmentCheckExtensions']))
		{
			$ext = explode(',', $modSettings['attachmentExtensions']);
			foreach ($ext as $k => $v)
				$ext[$k] = JavaScriptEscape($v);

			echo ',
		message_ext_error: ', JavaScriptEscape(str_replace('{attach_exts}', $context['allowed_extensions'], $txt['shd_cannot_attach_ext'])), ',
		attachment_ext: [', implode(',', $ext), ']';
		}

		echo '
	});
					// ]]></script>';
	}
}

function template_ticket_begin_replies()
{
	global $context, $settings, $txt, $modSettings;

	// The replies column
	echo '
					<div class="shd_ticket_rightcolumn floatleft" style="width: 100%;">';
}

function template_ticket_do_replies()
{
	global $context, $settings, $txt, $scripturl, $options, $modSettings, $reply_request;

	echo '
		<div class="tborder">
		<div class="title_bar grid_header">
			<h3 class="titlebg">
				<img src="', $settings['default_images_url'], '/simpledesk/replies.png" alt="x" /> ', $txt['shd_ticket_replies'], '
			</h3>
		</div>
		<div class="roundframe" id="replies">
			<div class="content">';

	if (!empty($reply_request))
	{
		while ($reply = $context['get_replies']())
		{
			echo '
					<div class="description shd_reply" id="reply', $reply['id'], '">
								<span class="floatleft shd_posterinfo">
									<strong class="shd_postername">
										', $reply['member']['link'], '
									</strong>
									<br />
									', $reply['member']['group'], '<br class="shd_groupmargin" />';

			if (!empty($modSettings['shd_display_avatar']) && empty($options['show_no_avatars']) && !empty($reply['member']['avatar']['image']))
					echo '
							', shd_profile_link($reply['member']['avatar']['image'], $reply['member']['id']);

			if ($modSettings['shd_staff_badge'] == (!empty($reply['is_team']) ? 'staffbadge' : 'userbadge') || $modSettings['shd_staff_badge'] == 'bothbadge')
				echo '<br />
							', $reply['member']['group_stars'];
			elseif (!empty($reply['is_team']) && $modSettings['shd_staff_badge'] == 'nobadge')
				echo '<br />
							<img src="', $settings['default_images_url'] . '/simpledesk/staff.png" class="shd_smallicon" title="', $txt['shd_ticket_staff'], '" alt="', $txt['shd_ticket_staff'], '" />';

			echo '
						</span>
						<div class="shd_replyarea">
							<div class="smalltext">
								<span class="floatright shd_ticketlinks">';

			if ($context['can_quote'])
				echo '
											<img src="', $settings['default_images_url'], '/simpledesk/quote.png" class="shd_smallicon" alt="*" /><a onclick="return oQuickReply.quote(', $reply['id'], ', \'', $context['session_id'], '\', \'', $context['session_var'], '\', true);" href="', $scripturl, '?action=helpdesk;sa=reply;ticket=', $context['ticket_id'], ';quote=', $reply['id'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_quote_short'], '</a>';

			echo '
								</span>
								', sprintf($txt['shd_reply_written'], $reply['time']), '
							</div>
							<hr class="clearfix" />
							', $reply['body'], '
							<br /><br />';

			if ($settings['show_modify'] && !empty($reply['modified']))
			{
				echo '
							<div class="smalltext shd_modified" style="margin-top:20px;">
								&#171; <em>', $txt['last_edit'], ': ', $reply['modified']['time'], ' ', $txt['by'], ' ', $reply['modified']['link'], '</em> &#187;
							</div>';
			}

			if (!empty($context['ticket_attach']['reply'][$reply['id']]))
			{
				echo '
							<div class="smalltext">
								<strong>', $txt['shd_ticket_attachments'], '</strong><br />
								<ul class="shd_replyattachments">';

				foreach ($context['ticket_attach']['reply'][$reply['id']] as $attach)
					echo '
									<li>', $attach['link'], '</li>';

				echo '
								</ul>
							</div>';
			}

			echo '
						</div>';

			if (!empty($context['can_see_ip']) && !empty($reply['ip_address']))
				echo '
						<span class="floatright"><img src="', $settings['default_images_url'], '/simpledesk/ip.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_ip'], ': ', $reply['ip_address'], '</span>';

			echo '
						<br class="clear" />
					</div>';
		}
	}

	echo '
				</div>
			</div>
			<span class="lowerframe"><span></span></span>
		</div>';
}

function template_ticket_end_replies()
{

	// Close the table
	echo '
		</div>
		<br class="clear" />';
}

function template_ticket_pageend()
{
	// And finally, good night, sweet form
	echo '
			</form>';
}

/**
 *	Display the message thanking the user for posting.
 *
 *	@see shd_done_posting()
 *	@since 1.1
*/
function template_shd_thank_posting()
{
	global $context, $settings, $options, $txt;

	echo '
	<div id="fatal_error">
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/', $context['page_icon'], '" alt="x" class="shd_icon_minihead" /> ', $context['page_title'], '
			</h3>
		</div>
		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="padding">', $context['page_body'], '</div>
			<span class="botslice"><span></span></span>
		</div>
	</div>
	<br class="clear" />';
}

?>