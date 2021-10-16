<?php
// Version: 2.1; SimpleDesk ticket display

/**
 *	This file handles just displaying a ticket, its replies and working with SimpleDesk-Post.template.php to arrange the quick reply area.
 *
 *	@package template
 *	@since 1.0
*/

/**
 *	Display the main view of a ticket.
 *
 *	It is responsible for all the processing and display of the data gathered in {@link shd_view_ticket()} to the user, and in fact there
 *	is little to discuss other than simply displaying the ticket in given HTML.
 *
 *	It is also responsible for displaying attachments either to the ticket (in attachments-in-ticket mode) or to the first post
 *	(in attachments-in-replies mode), and calling upon the posting routines to set up display of 'advanced' mode in quick reply.
 *
 *	@see shd_view_ticket()
 *	@see template_ticket_postbox()
 *	@see template_ticket_meta()
 *	@since 1.0
*/
function template_viewticket()
{
	global $context, $txt, $scripturl, $settings, $modSettings, $options;

	// SMF style icons go first.
	if ($modSettings['shd_ticketnav_style'] == 'smf')
		template_shd_button_strip($context['ticket_navigation'], 'right');

	// Back to the helpdesk.
	template_shd_button_strip(array($context['navigation']['back'], $context['navigation']['replies'], $context['navigation']['ticketlog']));

	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<span class="floatright smalltext shd_ticketlinks" id="ticket">';

	// SimpleDesk style Icons go here.
	if ($modSettings['shd_ticketnav_style'] == 'sd' || $modSettings['shd_ticketnav_style'] == 'sdcompact')
		foreach ($context['ticket_navigation'] as $act)
			if (!empty($act['display']))
				echo '
					<a href="', $act['url'], '"', (!empty($act['is_last']) ? ' id="last"' : ''), '', (!empty($act['onclick']) ? ' onclick="' . $act['onclick'] . '"' : ''), '><img src="', $settings['default_images_url'], '/simpledesk/', $act['icon'], '.png" alt="', $act['alt'], '" title="', $txt[$act['text']], '"> ', $modSettings['shd_ticketnav_style'] == 'sd' ? $txt[$act['text']] : '', '</a>';

	echo '
				</span>
				<img src="', $settings['default_images_url'], '/simpledesk/ticket.png" alt="x"> ', $txt['shd_ticket'], ' [', $context['ticket']['display_id'], ']
			</h3>
		</div>
		<div class="windowbg noup shd_ticket">
			<div class="shd_ticket_side_column">';

			// General ticket details
			echo '
				<div class="shd_ticketdetails">
					<img src="', $settings['default_images_url'], '/simpledesk/details.png" alt="" class="shd_smallicon shd_icon_minihead"> 
					<strong>', $txt['shd_ticket_details'], '</strong>
					<hr>
					<dl class="stats nobb">
						<dt><span class="main_icons inbox" title="', $txt['shd_ticket_id'], '"></span> ', $txt['shd_ticket_id'], ':</dt>
						<dd>', $context['ticket']['display_id'], '</dd>

						<dt><span class="main_icons members" title="', $txt['shd_ticket_user'], '"></span> ', $txt['shd_ticket_user'], ':</dt>
						<dd>', $context['ticket']['member']['link'], '</dd>

						<dt><span class="main_icons calendar" title="', $txt['shd_ticket_date'], '"></span> ', $txt['shd_ticket_date'], ':</dt>
						<dd>', $context['ticket']['poster_time'], '</dd>

						<dt><img src="', $settings['default_images_url'], '/simpledesk/urgency.png" alt="" class="shd_smallicon"> ', $txt['shd_ticket_urgency'], ':</dt>
						<dd id="item_urgency"><span id="urgency">', $context['ticket']['urgency']['label'], '</span>
							<span id="urgency_increase">', (!empty($context['ticket']['urgency']['increase']) ? '<a id="urglink_increase" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket']['id'] . ';change=increase;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_increase'] . '"><span class="generic_icons urgency_increase" title="' . $txt['shd_urgency_increase'] . '"></span></a>' : ''), '</span>
							<span id="urgency_decrease">', (!empty($context['ticket']['urgency']['decrease']) ? '<a id="urglink_decrease" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket']['id'] . ';change=decrease;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_decrease'] . '"><span class="generic_icons urgency_decrease" title="' . $txt['shd_urgency_decrease'] . '"></span></a>' : ''), '</span>
							<span id="urgency_button"></span>
						</dd>
						<dd class="shd_urgency_list">
							<select id="urgency_list" class="hidden"></select>
						</dd>

						<dt><img src="', $settings['default_images_url'], '/simpledesk/staff.png" alt="" class="shd_smallicon"> ', $txt['shd_ticket_assignedto'], ':</dt>
						<dd><span id="assigned_to">', $context['ticket']['assigned']['link'], '</span><span id="assigned_button"></span></dd>
						<dt class="shd_assignees_list">
							<ul id="assigned_list" class="hidden"></ul>
						</dt>

						<dt><img src="', $settings['default_images_url'], '/simpledesk/status.png" alt="" class="shd_smallicon"> ', $txt['shd_ticket_status'], ':</dt>
						<dd>', $context['ticket']['status']['label'], '</dd>

						<dt><img src="', $settings['default_images_url'], '/simpledesk/replies.png" alt="" class="shd_smallicon"> ', $txt['shd_ticket_num_replies'], ':</dt>
						<dd><a href="#replies">', (empty($context['ticket']['display_recycle']) ? $context['ticket']['num_replies'] : (int) $context['ticket']['num_replies'] + (int) $context['ticket']['deleted_replies']), '</a></dd>';

				if (!empty($context['display_private']))
					echo '
						<dt><img src="', $settings['default_images_url'], '/simpledesk/private.png" alt="" class="shd_smallicon"> ', $txt['shd_ticket_privacy'], ':</dt>
						<dd><span id="privacy">', $context['ticket']['privacy']['label'], '</span>', ($context['ticket']['privacy']['can_change'] ? ' (<a id="privlink" href="' . $scripturl . '?action=helpdesk;sa=privacychange;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '">' . $txt['shd_ticket_change'] . '</a>)' : ''), '</dd>';

				if (!empty($context['ticket']['ip_address']))
					echo '
						<dt><img src="', $settings['default_images_url'], '/simpledesk/ip.png" alt="" class="shd_smallicon"> ', $txt['shd_ticket_ip'], ':</dt>
						<dd>', $context['ticket']['ip_address'], '</dd>';

				echo '
					</dl>';

			// Display ticket custom fields/filters, if any
			if (!empty($context['ticket']['custom_fields']['prefixfilter']))
			{
				// No need to display anything if there isn't any content to display.
				$content = false;
				foreach ($context['ticket']['custom_fields']['prefixfilter'] as $field)
				{
					if (!empty($field['value']) || $field['display_empty'])
					{
						$content = true;
						break;
					}
				}

				if ($content)
				{
					echo '
							<hr>
							<ul>';

					foreach ($context['ticket']['custom_fields']['prefixfilter'] as $field)
					{
						if ($field['display_empty'] || !empty($field['value']))
						{
							echo '
								<li>
									<dl class="stats">
										<dt>', !empty($field['icon']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '" alt="" class="shd_smallicon">' : '', ' ', $field['name'], ':</dt>
										<dd>';

							if (empty($field['value']) && $field['display_empty'])
								echo $txt['shd_ticket_empty_field'];
							elseif (isset($field['value']))
								echo preg_replace('~<a (.*?)</a>~is', '', $field['options'][$field['value']]);

							echo '
										</dd>
									</dl>
								</li>';
						}
					}

					echo '
							</ul>';
				}
			}

			// Display ticket poster avatar?
			if (!empty($modSettings['shd_display_avatar']) && empty($options['show_no_avatars']) && !empty($context['ticket']['poster_avatar']['image']))
				echo '
						<div class="shd_ticket_avatar">
							', shd_profile_link($context['ticket']['poster_avatar']['image'], $context['ticket']['member']['id']), '
						</div>';

				echo '
					</div>';

			call_integration_hook('shd_hook_tpl_after_tkt_detail');

			// Custom fields :D
			if (!empty($context['ticket']['custom_fields']['details']))
			{
				// No need to display anything if there isn't any content to display.
				$content = false;
				foreach ($context['ticket']['custom_fields']['details'] as $field)
				{
					if (!empty($field['value']) || $field['display_empty'])
					{
						$content = true;
						break;
					}
				}

				if ($content)
				{
					echo '
					<div class="shd_additional_details">
						<strong><img src="', $settings['default_images_url'], '/simpledesk/additional_details.png" alt="" class="shd_smallicon shd_icon_minihead"> ', $txt['shd_ticket_additional_details'], '</strong>
						<hr>
							<ul>';

					foreach ($context['ticket']['custom_fields']['details'] as $field)
					{
						if ($field['display_empty'] || !empty($field['value']))
						{
							echo '
								<li>
									<dl>
										<dt>', !empty($field['icon']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '" alt="" class="shd_smallicon">' : '', ' ', $field['name'], ':</dt>
										<dd>';

							if ($field['type'] == CFIELD_TYPE_CHECKBOX)
								echo !empty($field['value']) ? $txt['yes'] : $txt['no'];
							elseif (empty($field['value']) && $field['display_empty'])
								echo $txt['shd_ticket_empty_field'];
							elseif (isset($field['value']))
							{
								if ($field['type'] == CFIELD_TYPE_SELECT || $field['type'] == CFIELD_TYPE_RADIO)
									echo $field['options'][$field['value']];
								elseif ($field['type'] == CFIELD_TYPE_MULTI)
								{
									$values = explode(',', $field['value']);
									$string = array();
									foreach ($values as $value)
										$string[] = $field['options'][$value];
									echo implode(', ', $string);
								}
								else
									echo $field['value'];
							}

							echo '
										</dd>
									</dl>
								</li>';
						}
					}

					echo '	
							</ul>
					</div>';
				}
			}

			call_integration_hook('shd_hook_tpl_after_add_detail');

			echo '
				</div>
				<div class="shd_ticket_description">';

			if (!empty($context['ticket']['display_recycle']))
				echo '
					<div class="errorbox" id="recycle_warning">
						<img src="', $settings['default_images_url'], '/simpledesk/delete.png" alt=""> ', $context['ticket']['display_recycle'], '
					</div>';

			echo '
					<img src="', $settings['default_images_url'], '/simpledesk/name.png" alt="" class="shd_smallicon shd_icon_minihead"><strong>';

			$output = '';
			foreach ($context['ticket']['custom_fields']['prefix'] as $field)
			{
				if (!isset($field['value']))
					continue;

				if ($field['type'] == CFIELD_TYPE_CHECKBOX)
					$output .= !empty($field['value']) ? ($txt['yes'] . ' ') : ($txt['no'] . ' ');
				elseif ($field['type'] == CFIELD_TYPE_SELECT || $field['type'] == CFIELD_TYPE_RADIO)
				{
					if (!empty($field['value']))
						$output .= $field['options'][$field['value']] . ' ';
				}
				elseif ($field['type'] == CFIELD_TYPE_MULTI)
				{
					$values = explode(',', $field['value']);
					$string = array();
					foreach ($values as $value)
						$string[] = $field['options'][$value];
					$output .= implode(', ', $string);
				}
				elseif (!empty($field['value']))
					$output .= $field['value'] . ' ';
			}
			if (!empty($output))
				echo '[', trim($output), '] ';

			echo $context['ticket']['subject'], '</strong><hr><br>
						<div id="shd_ticket_text">
							', $context['ticket']['body'];

			if (!empty($modSettings['show_modify']) && !empty($context['ticket']['modified']))
				echo '
						<div class="smalltext shd_modified">
							&#171; <em>', sprintf($txt['last_edit_by'], $context['ticket']['modified']['time'], $context['ticket']['modified']['link']), '</em> &#187;
						</div>';

			echo '
					</div>';

			if ($context['can_reply'])
				echo '
					<div class="information shd_replybutton floatright" id="shd_replybutton">
						<a href="', $scripturl, '?action=helpdesk;sa=reply;ticket=', $context['ticket_id'], ';num_replies=', $context['ticket']['num_replies'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_reply'], '</a><br>
					</div>';

			if ($context['can_quote'])
				echo '
					<div class="information shd_quotebutton floatright" id="shd_quotebutton">
						<a data-id="', $context['ticket']['first_msg'], '" href="', $scripturl, '?action=helpdesk;sa=reply;ticket=', $context['ticket_id'], ';quote=', $context['ticket']['first_msg'], ';num_replies=', $context['ticket']['num_replies'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_quote'], '</a><br>
					</div>';

			template_inline_attachments($context['ticket']['first_msg']);

			echo '
				</div>
			</div>';

	// Left column (ticket relationships, attachments)
	template_ticket_leftcolumn();

	echo '
		<div class="shd_ticket_rightcolumn floatleft"', empty($context['leftcolumndone']) ? ' style="width: 100%;"' : '', '>';

	// Additional information (custom fields)
	template_additional_fields();

	// The replies column
	template_viewreplies();

	// Our mighty quick reply box :D
	template_quickreply();

	echo '
		</div>';

	// The ticket action log, lastly.
	template_ticketactionlog();

	// Javascript?
	template_scripts_footer();
}

/**
 *	Displays the left area next to replies in the ticket view.
 *
 *	We pull the content into a single column this way to ensure floatleft items are handled properly.
 *
 *	@since 2.0
*/
function template_ticket_leftcolumn()
{
	global $context;

	$context['leftcolumn_templates'] = array();
	if (!empty($context['display_relationships'])) // Related tickets
		$context['leftcolumn_templates'][] = 'viewrelationships';
	if (!empty($context['ticket_attach']['ticket'])) // The attachments column
		$context['leftcolumn_templates'][] = 'viewticketattach';
	if (!empty($context['display_notifications']['show'])) // The notifications columns
		$context['leftcolumn_templates'][] = 'viewnotifications';

	call_integration_hook('shd_hook_tpl_display_lcol');

	if (empty($context['leftcolumn_templates']))
		return; // nothing to do

	$context['leftcolumndone'] = true; // for the rest of the template later

	echo '
		<br class="clear">
		<div class="shd_ticket_leftcolumn floatleft">
			<div class="shd_attachmentcolumn">';

	foreach ($context['leftcolumn_templates'] as $template)
		call_user_func('template_' . $template);

	echo '
			</div>
		</div>';
}

/**
 *	Display all the attachments to a ticket (in ticket view)
 *
 *	This function displays all the attachments in the current ticket while in ticket view, rather than when in replies view (which is handled by {@link template_viewreplies()} instead; this function was previously was part of {@link template_viewticket()}.
 *
 *	@since 2.0
*/
function template_viewticketattach()
{
	global $context, $settings, $txt, $scripturl;

	if (!empty($context['ticket_attach']['ticket']))
	{
		echo '
			<div class="title_bar">
				<h3 class="titlebg">
					<img src="', $settings['default_images_url'], '/simpledesk/attachments.png" alt="">', $txt['shd_ticket_attachments'], ' (', count($context['ticket_attach']['ticket']), ')
				</h3>
			</div>
			<div class="windowbg">
				<div class="shd_attachmentbox">';

		foreach ($context['ticket_attach']['ticket'] as $attachment)
		{
			echo '
					<div class="information shd_attachment" id="attach', $attachment['id'], '">';

			if ($attachment['is_image'])
			{
				if ($attachment['thumbnail']['has_thumb'])
					echo '
								<a href="', $attachment['href'], ';image" id="link_', $attachment['id'], '" onclick="', $attachment['thumbnail']['javascript'], '"><img src="', $attachment['thumbnail']['href'], '" alt="" id="thumb_', $attachment['id'], '" class="shd_thumb"></a><br>';
				else
					echo '
								<img src="' . $attachment['href'] . ';image" alt="" width="' . $attachment['width'] . '" height="' . $attachment['height'] . '" class="shd_thumb"><br>';
			}

			echo '
						<strong>', $attachment['link'], '</strong>
						<span class="smalltext">
							(', $attachment['size'], ')';

			if (!empty($attachment['can_delete']))
				echo '
							<a href="', $scripturl, '?action=helpdesk;sa=deleteattach;ticket=', $context['ticket_id'], ';attach=', $attachment['id'], '" onclick="return confirm(', JavaScriptEscape($txt['shd_delete_attach_confirm']), ');"><img src="', $settings['default_images_url'], '/simpledesk/delete.png" title="', $txt['shd_delete_attach'], '" alt="', $txt['shd_delete_attach'], '"></a>';

			echo '
						</span>
					</div>';
		}

		echo '
				</div>
			</div>';
	}
}

/**
 *	Display user-specific notification information.
 *
 *	@since 2.0
*/
function template_viewnotifications()
{
	global $context, $settings, $txt, $scripturl;

	if (empty($context['display_notifications']['show']))
		return;

	echo '
		<div class="cat_bar">
			<h3 class="catbg">
				<img src="', $settings['default_images_url'], '/simpledesk/log_notify.png" alt="">', $txt['shd_ticket_notify'], '
			</h3>
		</div>
		<div class="information">';

	$displayed_something = false;

	if (!$context['display_notifications']['is_ignoring'])
	{
		if (!$context['display_notifications']['is_monitoring'])
		{
			$displayed_something = true;
			if (!empty($context['display_notifications']['preferences']))
			{
				echo '
					', $txt['shd_ticket_notify_because'], '
					<ul>';

				foreach ($context['display_notifications']['preferences'] as $pref)
					echo '
						<li>', $txt['shd_ticket_notify_because_' . $pref], '</li>';

				echo '
					</ul>';
			}
			else
				echo '
					', $txt['shd_ticket_notify_noneprefs'];

			if (!empty($context['display_notifications']['can_change']))
				echo '
					<form action="', $scripturl, '?action=profile;area=hd_prefs;u=', $context['user']['id'], '" method="post">
						<input type="submit" value="', $txt['shd_ticket_notify_changeprefs'], '" class="button">
					</form>';
		}

		if (!empty($context['display_notifications']['can_monitor']))
		{
			if ($displayed_something)
				echo '
					<hr>';

			echo '
					<form action="', $scripturl, '?action=helpdesk;sa=notify;ticket=', $context['ticket_id'], '" method="post">';

			if (!$context['display_notifications']['is_monitoring'])
				echo '
						<p>', $txt['shd_ticket_monitor_on_note'], '</p>
						<input type="hidden" name="notifyaction" value="monitor_on">
						<input type="submit" value="', $txt['shd_ticket_monitor_on'], '" class="button">';
			else
				echo '
						<p><img src="', $settings['default_images_url'], '/simpledesk/cf_active.png" alt=""> ', $txt['shd_ticket_notify_me_always'], '<br><br>', $txt['shd_ticket_monitor_off_note'], '</p>
						<input type="hidden" name="notifyaction" value="monitor_off">
						<input type="submit" value="', $txt['shd_ticket_monitor_off'], '" class="button">';

			echo '
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
					</form>';
			$displayed_something = true;
		}
	}

	if (!empty($context['display_notifications']['can_ignore']) && !$context['display_notifications']['is_monitoring'])
	{
		if ($displayed_something)
			echo '
					<hr>';

		echo '
					<form action="', $scripturl, '?action=helpdesk;sa=notify;ticket=', $context['ticket_id'], '" method="post">';

		if (!$context['display_notifications']['is_ignoring'])
			echo '
						<p>', $txt['shd_ticket_notify_me_never_note'], '</p>
						<input type="hidden" name="notifyaction" value="ignore_on">
						<input type="submit" value="', $txt['shd_ticket_notify_me_never_on'], '" class="button">';
		else
			echo '
						<p><img src="', $settings['default_images_url'], '/simpledesk/cf_inactive.png" alt=""> ', $txt['shd_ticket_notify_me_never'], '</p>
						<input type="hidden" name="notifyaction" value="ignore_off">
						<input type="submit" value="', $txt['shd_ticket_notify_me_never_off'], '" class="button">';

		echo '
						<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
					</form>';
	}

	echo '
		</div>';
}

/**
 *	Additional information
 *
 *	This template displays the "Additional information" block below the ticket body. It contains any custom fields that the admin has set to display there.
 *
 *	@since 2.0
*/
function template_additional_fields()
{
	global $context, $scripturl, $options, $txt, $settings;

	if (!empty($context['ticket']['custom_fields']['information']))
	{
		// No need to display anything if there isn't any content to display.
		$content = false;
		foreach ($context['ticket']['custom_fields']['information'] as $field)
		{
			if (!empty($field['value']) || $field['display_empty'])
			{
				$content = true;
				break;
			}
		}

		if (!$content)
			return;

		echo '
			<div class="title_bar" id="additionalinfoheader">
				<h3 class="titlebg">
					<span class="toggle_up floatright" id="shd_custom_fields_swap"></span>
					<a href="#" id="shd_custom_fields_swap_link">', $txt['shd_ticket_additional_information'], '</a>
				</h3>
			</div>
			<div id="additional_info">';

			foreach ($context['ticket']['custom_fields']['information'] as $field)
			{
				if ($field['display_empty'] || !empty($field['value']) || $field['type'] == CFIELD_TYPE_CHECKBOX)
				{
					echo '
					<div class="roundframe">
						', !empty($field['icon']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '" alt="" class="shd_smallicon">' : '', '
						<strong>', $field['name'], ':</strong><hr>';

					if ($field['type'] == CFIELD_TYPE_CHECKBOX)
						echo !empty($field['value']) ? $txt['yes'] : $txt['no'];
					elseif (empty($field['value']) && $field['display_empty'])
						echo $txt['shd_ticket_empty_field'];
					else
					{
						if ($field['type'] == CFIELD_TYPE_SELECT || $field['type'] == CFIELD_TYPE_RADIO)
							echo $field['options'][$field['value']];
						elseif ($field['type'] == CFIELD_TYPE_MULTI)
						{
							$values = explode(',', $field['value']);
							$string = array();
							foreach ($values as $value)
								$string[] = $field['options'][$value];
							echo implode(', ', $string);
						}
						else
							echo $field['value'];
					}

					echo '
					</div>';
				}
			}

		echo '
			</div>
			<span id="additional_info_footer"></span>';
	}
}

/**
 *	Displays the quick reply/go advanced box
 *
 *	This function handles displaying of the templates that make up the Quick Reply / Go Advanced area, drawing on {@link SimpleDesk-Post.template.php} for core posting templates.
 *
 *	Prior to 1.1 this was part of {@link template_viewticket()}
 *
 *	@since 2.0
*/
function template_quickreply()
{
	global $context, $scripturl, $options, $txt, $settings;

	echo '
		<div class="title_bar" id="quickreplyheader">
			<h3 class="titlebg">
				<span class="floatright"><a href="#" onclick="oQuickReply.swap(); return false;"><img src="', $settings['images_url'], '/selected_open.png" alt="+" id="quickReplyExpand" class="icon" style="display:none;"></a></span>
				<img src="', $settings['default_images_url'], '/simpledesk/respond.png" alt="x">
				<a href="', $scripturl, '?action=helpdesk;sa=reply;ticket=', $context['ticket_id'], ';num_replies=', $context['ticket']['num_replies'], ';', $context['session_var'], '=', $context['session_id'], '" onclick="oQuickReply.swap(); return false;">', $txt['shd_reply_ticket'], '</a>
			</h3>
		</div>
		<div class="roundframe" id="quickReplyOptions">
			<div class="content">
				<form action="', $scripturl, '?action=helpdesk;sa=savereply" method="post" accept-charset="', $context['character_set'], '" name="postreply" id="postreply" onsubmit="smc_saveEntities(\'postreply\', [\'shd_reply\'], \'field\');" enctype="multipart/form-data" style="margin: 0;">';

	if ($context['can_go_advanced'])
		echo '
				<div class="information shd_advancedbutton floatright" id="shd_goadvancedbutton">
					<a href="', $scripturl, '?action=helpdesk;sa=reply;ticket=', $context['ticket_id'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_go_advanced'], '</a><br>
				</div>';

	template_ticket_postbox();
	template_ticket_meta();

	echo '
				</form>
			</div>
		</div>
		<span id="quickreplyfooter"></span>';
}

/**
 *	Display the attachments for a given message.
 *
 *	This function outputs the HTML necessary to display attachments with thumbnails inline with each reply.
 *
 *	@param int $msg The message id to look in $context['ticket_attach']['reply'] for attachments.
 *
 *	@since 2.0
 *	@todo See if it's possible to do a sane CSS replacement instead of using tables.
*/
// Arantor: I swear I spent more time farting around with this trying to make it not look like crap than I did the rest of the thumbnail code.
function template_inline_attachments($msg)
{
	global $context, $txt, $scripturl, $settings;

	$remove_txt = JavaScriptEscape($txt['shd_delete_attach_confirm']);

	if (!empty($context['ticket_attach']['reply'][$msg]))
	{
		echo '
							<table width="90%">';

		$count = 0;
		$firstrow = true;
		foreach ($context['ticket_attach']['reply'][$msg] as $attachment)
		{
			if ($count == 0)
			{
				if (!$firstrow)
					echo '
								</tr>';

				echo '
								<tr>';
			}

			echo '
									<td class="information">';

			if ($attachment['is_image'])
			{
				if ($attachment['thumbnail']['has_thumb'])
					echo '
										<a href="', $attachment['href'], ';image" id="link_', $attachment['id'], '" onclick="', $attachment['thumbnail']['javascript'], '"><img src="', $attachment['thumbnail']['href'], '" alt="" id="thumb_', $attachment['id'], '" class="shd_thumb"></a><br>';
				else
					echo '
										<img src="' . $attachment['href'] . ';image" alt="" width="' . $attachment['width'] . '" height="' . $attachment['height'] . '" class="shd_thumb"><br>';
			}

			echo '
										', $attachment['link'];


			if (!empty($attachment['can_delete']))
				echo '
									<a href="', $scripturl, '?action=helpdesk;sa=deleteattach;ticket=', $context['ticket_id'], ';attach=', $attachment['id'], '" onclick="return confirm(', $remove_txt, ');"><img src="', $settings['default_images_url'], '/simpledesk/delete.png" title="', $txt['shd_delete_attach'], '" alt="', $txt['shd_delete_attach'], '"></a>';

			echo '
									</td>';

			$count++;
			if ($count == 3)
				$count = 0;

			$firstrow = false;
		}

		echo '
							</table>';
	}
}

/**
 *	Display all the replies to a ticket.
 *
 *	This function deals simply with viewing of replies in a ticket, including deleted replies, which is initialised in {@link shd_view_ticket()}
 *	and data gathered through the {@link shd_prepare_ticket_context()} call back, which simply deals with a single reply at a time.
 *
 *	@see shd_view_ticket()
 *	@see template_viewticket()
 *	@since 1.0
*/
function template_viewreplies()
{
	global $context, $settings, $txt, $scripturl, $options, $modSettings, $reply_request;

	echo '
		<div class="title_bar">
			<h3 class="titlebg">
				<span class="floatright smalltext">', $context['page_index'], '</span>
				<img src="', $settings['default_images_url'], '/simpledesk/replies.png" alt="x"> ', $txt['shd_ticket_replies'], '
			</h3>
		</div>
		<div id="replies">';

	if (empty($reply_request))
		echo '
			<div class="roundframe">', $txt['shd_no_replies'], '</div>';
	else
	{
		while ($reply = $context['get_replies']())
		{
			if (!empty($reply['is_new']))
				echo '
					<a id="new"></a>';

			echo '
					<div class="ticket_replies_container', (!empty($context['ticket']['display_recycle']) && $reply['message_status'] == MSG_STATUS_DELETED ? ' errorbox' : ''), ' windowbg" id="msg', $reply['id'], '">
						<span class="shd_posterinfo">
							<strong class="shd_postername">
								', $reply['member']['link'], '
							</strong>
							<br>
							', $reply['member']['group'], '
							<br class="shd_groupmargin">';

			if (!empty($modSettings['shd_display_avatar']) && empty($options['show_no_avatars']) && !empty($reply['member']['avatar']['image']))
					echo '
							<span class="shd_posteravatar">
								', shd_profile_link($reply['member']['avatar']['image'], $reply['member']['id']), '
							</span>';

			if ($modSettings['shd_staff_badge'] == (!empty($reply['is_staff']) ? 'staffbadge' : 'userbadge') || $modSettings['shd_staff_badge'] == 'bothbadge')
				echo '
							', $reply['member']['group_icons'];
			elseif (!empty($reply['is_staff']) && $modSettings['shd_staff_badge'] == 'nobadge')
				echo '
							<img src="', $settings['default_images_url'] . '/simpledesk/staff.png" class="shd_smallicon" title="', $txt['shd_ticket_staff'], '" alt="', $txt['shd_ticket_staff'], '">';

			echo '
						</span>
						<div class="shd_replyarea">
							<div class="smalltext">
								<span class="floatright shd_ticketlinks">';

			if ($context['can_quote'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/quote.png" class="shd_smallicon" alt="*"><a class="quick_reply" data-id="', $reply['id'], '" href="', $scripturl, '?action=helpdesk;sa=reply;ticket=', $context['ticket_id'], ';quote=', $reply['id'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_quote_short'], '</a>';
			if ($reply['can_edit'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/edit.png" class="shd_smallicon" alt="*"><a href="', $scripturl, '?action=helpdesk;sa=editreply;ticket=', $context['ticket_id'], ';msg=', $reply['id'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_edit'], '</a>';
			if ($reply['can_delete'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/delete.png" class="shd_smallicon" alt="*"><a href="', $scripturl, '?action=helpdesk;sa=deletereply;reply=', $reply['id'], ';ticket=', $context['ticket']['id'], ';', $context['session_var'], '=', $context['session_id'], '" onclick="return confirm(', JavaScriptEscape($txt['shd_delete_reply_confirm']), ');">', $txt['shd_ticket_delete'], '</a>';
			if ($reply['can_restore'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/restore.png" class="shd_smallicon" alt="*"><a href="', $scripturl, '?action=helpdesk;sa=restorereply;reply=', $reply['id'], ';ticket=', $context['ticket']['id'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_restore'], '</a>';
			if ($reply['can_permadelete'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/delete.png" class="shd_smallicon" alt="*"><a href="', $scripturl, '?action=helpdesk;sa=permadelete;reply=', $reply['id'], ';ticket=', $context['ticket']['id'], ';', $context['session_var'], '=', $context['session_id'], '" onclick="return confirm(', JavaScriptEscape($txt['shd_delete_permanently_confirm']), ');">', $txt['shd_delete_permanently'], '</a>';

			echo '
								</span>
								<a href="', $reply['link'], '">', sprintf($txt['shd_reply_written'], $reply['time']), '</a>
							</div>
							<hr>
							', $reply['body'], '
							<br><br>';

		// Custom fields for replies!
		if (!empty($context['custom_fields_replies'][$reply['id']]))
		{
			echo '
							<hr>';

			foreach ($context['custom_fields_replies'][$reply['id']] as $field)
			{
				if ($field['display_empty'] || !empty($field['value']) || $field['type'] == CFIELD_TYPE_CHECKBOX)
				{
					echo '
							', !empty($field['icon']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '" alt="" class="shd_smallicon">' : '', '
							<strong>', $field['name'], ': </strong>';

					if ($field['type'] == CFIELD_TYPE_CHECKBOX)
						echo !empty($field['value']) ? $txt['yes'] : $txt['no'], '<br><br>';
					elseif (empty($field['value']) && $field['display_empty'])
						echo $txt['shd_ticket_empty_field'], '<br><br>';
					else
					{
						if ($field['type'] == CFIELD_TYPE_SELECT || $field['type'] == CFIELD_TYPE_RADIO)
							echo $field['options'][$field['value']], '<br><br>';
						elseif ($field['type'] == CFIELD_TYPE_MULTI)
						{
							$values = explode(',', $field['value']);
							$string = '';
							foreach ($values as $value)
								$string .= $field['options'][$value] . ' ';
							echo trim($string), '<br><br>';
						}
						else
							echo $field['value'], '<br><br>';
					}
				}
			}
		}

			if (!empty($settings['show_modify']) && !empty($reply['modified']))
				echo '
							<div class="smalltext shd_modified" style="margin-top:20px;">
								&#171; <em>', $txt['last_edit'], ': ', $reply['modified']['time'], ' ', $txt['by'], ' ', $reply['modified']['link'], '</em> &#187;
							</div>';

			template_inline_attachments($reply['id']);

			if (!empty($reply['ip_address']))
				echo '
							<span class="floatright">
								<img src="', $settings['default_images_url'], '/simpledesk/ip.png" alt="" class="shd_smallicon"> 
								', $txt['shd_ticket_ip'], ': ', $reply['ip_address'], '
							</span>';

			echo '
						</div>
					</div>';
		}
	}

	echo '
			<div class="information">
				<span class="floatleft">
					<a href="#replies" title="', $txt['shd_go_to_replies_start'], '">
						<img src="', $settings['default_images_url'], '/simpledesk/move_up.png" alt=""><img src="', $settings['default_images_url'], '/simpledesk/replies.png" alt="">
					</a>
				</span>
				<span class="floatright smalltext">', $context['page_index'], '</span>
			</div>
		</div>';
}

/**
 *	Display related tickets.
 *
 *	Displays the block of tickets that have a relationship to this one.
 *
 *	@since 2.0
*/
function template_viewrelationships()
{
	global $context, $settings, $txt, $scripturl;

	if (!empty($context['display_relationships']))
	{
		echo '
			<div class="cat_bar">
				<h3 class="catbg">
					<img src="', $settings['default_images_url'], '/simpledesk/relationships.png" alt="">', $txt['shd_ticket_relationships'], ' (', $context['relationships_count'], ')
				</h3>
			</div>
			<div class="information">
				<div class="shd_attachmentbox">';

		foreach ($context['ticket_relationships'] as $rel_type => $relationships)
		{
			if (empty($relationships))
				continue;

			echo '
					<img src="', $settings['default_images_url'], '/simpledesk/rel_', $rel_type, '.png" alt=""><strong>', $txt['shd_ticket_reltype_' . $rel_type], ':</strong><br>';

			foreach ($relationships as $rel)
			{
				if (!empty($context['delete_relationships']))
					echo '<a href="', $scripturl, '?action=helpdesk;sa=relation;ticket=', $context['ticket_id'], ';otherticket=', $rel['id'], ';relation=delete;', $context['session_var'], '=', $context['session_id'], '"><img class="shd_smallicon" src="', $settings['default_images_url'], '/simpledesk/delete.png" alt="', $txt['shd_ticket_delete_relationship'], '" title="', $txt['shd_ticket_delete_relationship'], '"></a>';

				echo '<span class="smalltext">[', $rel['display_id'], '] <a href="', $scripturl, '?action=helpdesk;sa=ticket;ticket=', $rel['id'], '">', $rel['subject'], '</a> (', $rel['status_txt'], ')</span><br>';
			}
		}

		if (!empty($context['create_relationships']))
		{
			if ($context['relationships_count'] > 0)
				echo '
						<hr>';

			echo '
				', $txt['shd_ticket_create_relationship'], ':
				<form action="', $scripturl, '?action=helpdesk;sa=relation" method="post">
					<select name="relation">
						<option value="">', $txt['shd_ticket_reltype'], '</option>';

			$rel_type_list = array('parent', 'child', 'linked', 'duplicated');
			foreach ($rel_type_list as $type)
				echo '
						<option value="', $type, '">', $txt['shd_ticket_reltype_' . $type], '</option>';

			echo '
					</select>
					<input type="text" name="otherticket" value="" size="5">
					<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '">
					<input type="hidden" name="ticket" value="', $context['ticket_id'], '">
					<input type="submit" class="button save" value="', $txt['shd_go'], '">
				</form>';
		}

		echo '
				</div>
			</div>';
	}
}

/**
 *	Display the events on a ticket.
 *
 *	Displays all the non-post type events that apply to the current ticket, as a subset of the master action log. Data is gathered from {@link shd_load_action_log_entries()}
 *
 *	@since 2.0
*/
function template_ticketactionlog()
{
	global $context, $settings, $txt, $scripturl;

	if (empty($context['display_ticket_log']))
		return;

	echo '
		<div class="title_bar" id="ticket_log_header">
			<h3 class="titlebg">
				<span class="toggle_up floatright" id="shd_ActionLogToggle"></span>
				<span id="shd_ActionLogLink"><img src="', $settings['default_images_url'], '/simpledesk/log.png" class="icon" alt="*"> ', $txt['shd_ticket_log'], '</span>
				<span class="smalltext">(', $context['ticket_log_count'] == 1 ? $txt['shd_ticket_log_count_one'] : sprintf($txt['shd_ticket_log_count_more'], $context['ticket_log_count']), ')</span>
			</h3>
		</div>
		<table class="table_grid" id="ticket_log">
			<tr class="title_bar">
				<td class="quarter_table">
					<img src="', $settings['default_images_url'], '/simpledesk/time.png" class="shd_smallicon" alt="">
					', $txt['shd_ticket_log_date'], '
				</td>
				<td class="quarter_table">
					<img src="', $settings['default_images_url'], '/simpledesk/user.png" class="shd_smallicon" alt="">
					', $txt['shd_ticket_log_member'], '
				</td>
				<td class="half_table">
					<img src="', $settings['default_images_url'], '/simpledesk/action.png" class="shd_smallicon" alt="">
					', $txt['shd_ticket_log_action'], '
				</td>
			</tr>';

	if (empty($context['ticket_log']))
		echo '
			<tr class="windowbg">
				<td colspan="3" class="shd_noticket">', $txt['shd_ticket_log_none'], '</td>
			</tr>';
	else
		foreach ($context['ticket_log'] as $action)
			echo '
			<tr class="windowbg">
				<td class="smalltext">', $action['time'], '</td>
				<td', !empty($action['member']['ip']) ? ' title="' . $txt['shd_ticket_log_ip'] . ' ' . $action['member']['ip'] . '"' : '', '>', $action['member']['link'], ' <span class="smalltext">(', $action['member']['group'], ')</span></td>
				<td class="smalltext">
					<img src="', $settings['default_images_url'], '/simpledesk/', $action['action_icon'], '" alt="" class="shd_smallicon">
					', $action['action_text'], '
				</td>
			</tr>';

	echo '
			<tr class="bot_page">
				<td colspan="3">
					<span class="floatright"><a href="#replies" title="', $txt['shd_go_to_replies_start'], '"><img src="', $settings['default_images_url'], '/simpledesk/move_up.png" alt=""><img src="', $settings['default_images_url'], '/simpledesk/replies.png" alt=""></a></span>
					', !empty($context['ticket_full_log']) ? '<span class="smalltext shd_main_log"><img src="' . $settings['default_images_url'] . '/simpledesk/browse.png" alt=""><a href="' . $scripturl . '?action=admin;area=helpdesk_info;sa=actionlog">' . $txt['shd_ticket_log_full'] . '</a></span>' : '', '
				</td>
			</tr>
		</table>';
}

/**
 *	Displays a header that Javascript should be enabled while in the administration panel area of SimpleDesk.
 *
 *	The helpdesk is disabled to non admins while in maintenance mode, but this template is added to the template layers if the user is an admin and it's in maintenance mode.
 *	@since 2.0
*/
function template_shd_display_nojs_above()
{
	global $txt, $settings;
	echo '<noscript><div class="errorbox"><img src="', $settings['default_images_url'], '/simpledesk/warning.png" alt="*" class="shd_icon_minihead"> &nbsp;', $txt['shd_display_nojs'], '</div></noscript>';
}

/**
 *	Displays a footer that Javascript should be enabled while in the administration panel area of SimpleDesk.
 *
 *	This template is added to the template layers, because SMF requires a layer have both a layer before and after the main content.
 *	@since 2.0
*/
function template_shd_display_nojs_below()
{
}

/**
 *	All of the Javascript we have.
 *
 *	@since 2.1
*/
function template_scripts_footer()
{
	global $context;

	$jsTemplates = array(
		'privacy' => !empty($context['ticket']['privacy']['can_change']),
		'urgency' => !empty($context['ticket']['urgency']['increase']) || !empty($context['ticket']['urgency']['decrease']),
		'ajax_assign' => !empty($context['ajax_assign']),
		'quickreply' => true,
		'custom_fields_display' => true,
		'action_log' => !empty($context['display_ticket_log']),
		'advanced_quickreply' => !empty($context['can_go_advanced']),
	);

	echo '
	<script type="text/javascript"><!-- // --><![CDATA[';

	foreach ($jsTemplates as $template => $enabled)
		if ($enabled)
			call_user_func('template_shd_js_' . $template);

	echo '
	// ]' . ']></script>';
}

/**
 *	Javascript for Privacy
 *
 *	@since 2.1
*/
function template_shd_js_privacy()
{
	global $context, $txt;

	echo '
		var shd_ajax_problem = ', JavaScriptEscape($txt['shd_ajax_problem']), ';
		var privacyCtl = new shd_privacyControl({
			ticket: ', $context['ticket_id'], ',
			sUrl: smf_scripturl + "?action=helpdesk;sa=ajax;op=privacy;ticket=', $context['ticket_id'], '",
			sSession: smf_session_var + "=" + smf_session_id,
			sSrcA: "privlink",
			sDestSpan: "privacy"
		});';
}

/**
 *	Javascript for Urgency
 *
 *	@since 2.1
*/
function template_shd_js_urgency()
{
	global $context, $settings;

	echo '
		var urgencyCtl = new shd_urgencyControl({
			sSelf: "urgencyCtl",
			iTicketId: ' . $context['ticket_id'] . ',
			sUrl: smf_scripturl + "?action=helpdesk;sa=ajax;op=urgency;ticket=', $context['ticket_id'], ';change=",
			sSession: smf_session_var + "=" + smf_session_id,
			sDestSpan: "urgency",
			aButtons: ["up", "down"],
			aButtonOps: {up:"increase", down:"decrease"},
			sSelectButtonId: "urgency_button",
			sSelectListId: "urgency_list",
			sImageCollapsed: ', JavaScriptEscape($settings['default_images_url'] . '/simpledesk/ajax_assign.png'), ',
			sImageExpanded: ', JavaScriptEscape($settings['default_images_url'] . '/simpledesk/ajax_assign_cancel.png'), ',
		});';
}

/**
 *	Javascript for Quick Reply
 *
 *	@since 2.1
*/
function template_shd_js_quickreply()
{
	global $context, $settings;

	echo '
		var oQuickReply = new QuickReply({
			iTicketId: ', $context['ticket_id'], ',
			sScriptUrl: smf_scripturl,
			sJumpAnchor: "quickReplyOptions",
			sSession: smf_session_var + "=" + smf_session_id,
			sRepliesSelector: "span.shd_ticketlinks a.quick_reply",
			sFirstPostSelector: "div#shd_quotebutton a"
		});';
}

/**
 *	Javascript for Ajax Assign
 *
 *	@since 2.1
*/
function template_shd_js_custom_fields_display()
{
	global $context, $options, $txt;

	echo '
		var oCustomFields = new smc_Toggle({
			bToggleEnabled: true,
			bCurrentlyCollapsed: ', empty($options['collapse_shd_customFields']) ? 'false' : 'true', ',
			aSwappableContainers: [
				\'additional_info\'
			],
			aSwapImages: [
				{
					sId: \'shd_custom_fields_swap\',
				}
			],
			aSwapLinks: [
				{
					sId: \'shd_custom_fields_swap_link\',
					msgCollapsed: ', JavaScriptEscape($txt['shd_ticket_additional_information']), ',
					msgExpanded: ', JavaScriptEscape($txt['shd_ticket_additional_information']), ',
				},
			],
			oThemeOptions: {
				bUseThemeSettings: ', $context['user']['is_guest'] ? 'false' : 'true', ',
				sOptionName: \'collapse_shd_customFields\',
				sSessionId: smf_session_id,
				sSessionVar: smf_session_var,
			},
			oCookieOptions: {
				bUseCookie: false,
				sCookieName: \'shd_customFields\'
			}
		});';
}

/**
 *	Javascript for Ajax Assign
 *
 *	@since 2.1
*/
function template_shd_js_ajax_assign()
{
	global $context, $settings;

	echo '
		var oAjaxAssign = new AjaxAssign({
			sSelf: "oAjaxAssign",
			sScriptUrl: smf_scripturl,
			iTicketId: ' . $context['ticket_id'] . ',
			sId: "assigned_button",
			sListId: "assigned_list",
			sAssignedSpan: "assigned_to",
			sImagesUrl: ', JavaScriptEscape($settings['default_images_url'] . '/simpledesk'), ',
			sImageCollapsed: ', JavaScriptEscape($settings['default_images_url'] . '/simpledesk/ajax_assign.png'), ',
			sImageExpanded: ', JavaScriptEscape($settings['default_images_url'] . '/simpledesk/ajax_assign_cancel.png'), ',
			sImageAdmin: ', JavaScriptEscape($settings['default_images_url'] . '/simpledesk/admin.png'), ',
			sImageStaff: ', JavaScriptEscape($settings['default_images_url'] . '/simpledesk/staff.png'), ',
			sSession: smf_session_var + "=" + smf_session_id,
		});';
}

/**
 *	Javascript for Action Log
 *
 *	@since 2.1
*/
function template_shd_js_action_log()
{
	global $context, $options, $settings, $txt;

	echo '
		var oActionLog = new smc_Toggle({
			bToggleEnabled: true,
			bCurrentlyCollapsed: ', empty($options['collapse_shd_actionLog']) ? 'false' : 'true', ',
			aSwappableContainers: [
				\'ticket_log\'
			],
			aSwapImages: [
				{ sId: \'shd_ActionLogToggle\',},
			],
			aSwapLinks: [
				{
					sId: \'shd_ActionLogLink\',
					msgCollapsed: ', JavaScriptEscape('<img src="' . $settings['default_images_url'] . '/simpledesk/log.png" class="icon" alt="*"> ' . $txt['shd_ticket_log']), ',
					msgExpanded: ', JavaScriptEscape('<img src="' . $settings['default_images_url'] . '/simpledesk/log.png" class="icon" alt="*"> ' . $txt['shd_ticket_log']), ',
				},
			],
			oThemeOptions: {
				bUseThemeSettings: ', $context['user']['is_guest'] ? 'false' : 'true', ',
				sOptionName: \'collapse_shd_actionLog\',
				sSessionId: smf_session_id,
				sSessionVar: smf_session_var,
			},
			oCookieOptions: {
				bUseCookie: false,
				sCookieName: \'shd_customFields\'
			}
		});';
}

/**
 *	Javascript for Advanced QuickRely
 *
 *	@since 2.1
*/
function template_shd_js_advanced_quickreply()
{
	global $context, $modSettings;

	echo '
		var oGoAdvanced = new goAdvanced({
			sBbcContainerId: "shd_bbcbox",
			sBbcContainerEditorClass: "sceditor-group",
			sSmileyContainerId: "shd_smileybox",
			sSmileyContainerEditorClass: "sceditor-insertemoticon",
			sAttachContainerId: "shd_attach_container",
			sAdvancedContainerId: "shd_goadvancedbutton",
			sAdditionalOptionsContainerId: "shd_additional_options_box",
			bAllowBBC: ', !empty($modSettings['shd_allow_ticket_bbc']) ? 'true' : 'false', ',
			bAllowSmileys: ', !empty($modSettings['shd_allow_ticket_smileys']) ? 'true' : 'false', ',
			bAllowAttach: ', !empty($context['ticket_form']['do_attach']) ? 'true' : 'false', ',
		});';
}