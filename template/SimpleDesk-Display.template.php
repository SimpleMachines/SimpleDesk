<?php
// Version: 1.0 Felidae; SimpleDesk ticket display

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

	// Back to the helpdesk.
	echo'<div class="floatleft">', template_button_strip(array($context['navigation']['back']), 'bottom'), '</div>', ($modSettings['shd_ticketnav_style'] != 'smf' ? '<br class="clear" /><br />' : ''), '';

	if ($modSettings['shd_ticketnav_style'] == 'smf')
	{
		template_button_strip($context['ticket_navigation'], 'right');
		echo '<br class="clear" />';
	}

	echo '
			<div class="tborder">
			<div class="cat_bar grid_header">
				<h3 class="catbg ticketheader">
					<span class="floatright smalltext shd_ticketlinks" id="ticket">';

	if ($modSettings['shd_ticketnav_style'] == 'sd')
	{
		foreach ($context['ticket_navigation'] as $button)
			if (!empty($button['display']))
				echo '
						<a href="', $button['url'], '"', (!empty($button['is_last']) ? ' id="last"' : ''), '', (!empty($button['onclick']) ? ' onclick="' . $button['onclick'] . '"' : ''), '><img src="', $settings['default_images_url'], '/simpledesk/', $button['icon'], '.png" alt="', $button['alt'], '" title="', $txt[$button['text']], '" /> ', $txt[$button['text']], '</a>';
	}
	elseif ($modSettings['shd_ticketnav_style'] == 'sdcompact')
	{
		foreach ($context['ticket_navigation'] as $button)
			if (!empty($button['display']))
				echo '
						<a href="', $button['url'], '"', (!empty($button['is_last']) ? ' id="last"' : ''), '', (!empty($button['onclick']) ? ' onclick="' . $button['onclick'] . '"' : ''), '><img src="', $settings['default_images_url'], '/simpledesk/', $button['icon'], '.png" alt="', $button['alt'], '" title="', $txt[$button['text']], '" /></a>';
	}

	echo '
					</span>
					<img src="', $settings['default_images_url'], '/simpledesk/ticket.png" alt="x" /> ', $context['ticket']['subject'], ' [', $context['ticket']['display_id'], ']
				</h3>
			</div>
			<div class="windowbg">
				<div class="content shd_ticket">';

			// General ticket details
			echo '
					<div class="information shd_ticketdetails">
						<strong><img src="', $settings['default_images_url'], '/simpledesk/details.png" alt="" class="shd_smallicon shd_icon_minihead" /> ', $txt['shd_ticket_details'], '</strong>
						<hr />
						<ul>
							<li><img src="', $settings['default_images_url'], '/simpledesk/id.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_id'], ': ', $context['ticket']['display_id'], '</li>
							<li><img src="', $settings['default_images_url'], '/simpledesk/user.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_user'], ': ', $context['ticket']['member']['link'], '</li>
							<li><img src="', $settings['default_images_url'], '/simpledesk/time.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_date'], ': ', $context['ticket']['poster_time'], '</li>
							<li>
								<img src="', $settings['default_images_url'], '/simpledesk/urgency.png" alt="" class="shd_smallicon" />
								', $txt['shd_ticket_urgency'], ': <span id="urgency">', $context['ticket']['urgency']['label'], '</span>
									<span id="urgency_increase">', (!empty($context['ticket']['urgency']['increase']) ? '<a id="urglink_increase" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket']['id'] . ';change=increase;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_increase'] . '"><img src="' . $settings['images_url'] . '/sort_up.gif" width="9px" alt="' . $txt['shd_urgency_increase'] . '" /></a>' : ''), '</span>
									<span id="urgency_decrease">', (!empty($context['ticket']['urgency']['decrease']) ? '<a id="urglink_decrease" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket']['id'] . ';change=decrease;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_decrease'] . '"><img src="' . $settings['images_url'] . '/sort_down.gif" width="9px" alt="' . $txt['shd_urgency_decrease'] . '" /></a>' : ''), '</span>
							</li>
							<li><img src="', $settings['default_images_url'], '/simpledesk/staff.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_assignedto'], ': ', $context['ticket']['assigned']['link'], '</li>
							<li><img src="', $settings['default_images_url'], '/simpledesk/status.png" alt="" class="shd_smallicon"/> ', $txt['shd_ticket_status'], ': ', $context['ticket']['status']['label'], '</li>
							<li><img src="', $settings['default_images_url'], '/simpledesk/replies.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_num_replies'], ': <a href="#replies">', (empty($context['ticket']['display_recycle']) ? $context['ticket']['num_replies'] : (int) $context['ticket']['num_replies'] + (int) $context['ticket']['deleted_replies']), '</a></li>';

			if (!empty($context['display_private']))
				echo '
							<li><img src="', $settings['default_images_url'], '/simpledesk/private.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_privacy'], ': <span id="privacy">', $context['ticket']['privacy']['label'], '</span>', ($context['ticket']['privacy']['can_change'] ? ' (<a id="privlink" href="' . $scripturl . '?action=helpdesk;sa=privacychange;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '">' . $txt['shd_ticket_change'] . '</a>)' : ''), '</li>';

			if (!empty($context['can_see_ip']) && !empty($context['ticket']['ip_address']))
				echo '
							<li><img src="', $settings['default_images_url'], '/simpledesk/ip.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_ip'], ': ', $context['ticket']['ip_address'], '</li>';

			echo '
						</ul>';

			// Display ticket poster avatar?
			if (!empty($modSettings['shd_display_avatar']) && empty($options['show_no_avatars']) && !empty($context['ticket']['poster_avatar']['image']))
				echo '
						<div class="shd_ticket_avatar">
							', $context['ticket']['poster_avatar']['image'], '
						</div>';

			echo '
					</div>';

			echo '
					<div class="shd_ticket_description">';

			if (!empty($context['ticket']['display_recycle']))
				echo '
						<div class="errorbox" id="recycle_warning">
							<img src="', $settings['default_images_url'], '/simpledesk/delete.png" alt="" /> ', $context['ticket']['display_recycle'], '
						</div>';

			echo '
						<img src="', $settings['default_images_url'], '/simpledesk/name.png" alt="" class="shd_smallicon shd_icon_minihead" /> <strong>', $context['ticket']['subject'], '</strong><hr /><br />
							<div id="shd_ticket_text">
								', $context['ticket']['body'];

			if ($settings['show_modify'] && !empty($context['ticket']['modified']))
			{
				echo '
							<div class="smalltext shd_modified">
								&#171; <em>', $txt['last_edit'], ': ', $context['ticket']['modified']['time'], ' ', $txt['by'], ' ', $context['ticket']['modified']['link'], '</em> &#187;
							</div>';
			}

			echo'
						</div>';

			if ($context['can_reply'])
				echo '
						<br />
						<div class="description shd_replybutton floatright" id="shd_replybutton">
							<a href="', $scripturl, '?action=helpdesk;sa=reply;ticket=', $context['ticket_id'], ';num_replies=', $context['ticket']['num_replies'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_reply'], '</a><br />
						</div>';

			if ($context['can_quote'])
				echo '
						<div class="description shd_quotebutton floatright" id="shd_quotebutton">
							<a onclick="return oQuickReply.quote(', $context['ticket']['first_msg'], ', \'', $context['session_id'], '\', \'', $context['session_var'], '\', true);" href="', $scripturl, '?action=helpdesk;sa=reply;ticket=', $context['ticket_id'], ';quote=', $context['ticket']['first_msg'], ';num_replies=', $context['ticket']['num_replies'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_quote'], '</a><br />
						</div>';

			if (!empty($context['ticket_attach']['reply'][$context['ticket']['first_msg']]))
			{
				echo '
						<div class="information shd_reply_attachments">
							<dl id="postAttachment">
								<dt>
									', $txt['attached'], ':
								</dt>';
				foreach ($context['ticket_attach']['reply'][$context['ticket']['first_msg']] as $attachment)
					echo '
								<dd class="smalltext">
									', $attachment['link'], '
								</dd>';
				echo '
							</dl>
						</div>';
			}

			echo '
					</div>
				</div>
				<span class="botslice"><span></span></span>
			</div>
			</div>
			<br />';

		// The attachments column
		if (!empty($context['ticket_attach']['ticket']))
		{
			echo '
					<div class="shd_ticket_leftcolumn floatleft">
						<div class="tborder shd_attachmentcolumn">
						<div class="title_bar grid_header">
							<h3 class="titlebg">
								<img src="', $settings['default_images_url'], '/simpledesk/attachments.png" alt="x" />', $txt['shd_ticket_attachments'], ' (', count($context['ticket_attach']['ticket']), ')
							</h3>
						</div>
						<div class="windowbg2">
							<div class="shd_attachmentbox">';

			foreach ($context['ticket_attach']['ticket'] as $attachment)
			{
				echo '
								<div class="description shd_attachment" id="attach', $attachment['id'], '">
									<strong>', $attachment['link'], '</strong>
									<span class="smalltext">
										(', $attachment['size'], ')
									</span>
								</div>';
			}

			echo '
							</div>
							<span class="botslice"><span></span></span>
						</div>
						</div>
					</div>';
		}

		// The replies column
		echo '
					<div class="shd_ticket_rightcolumn floatleft"', empty($context['ticket_attach']['ticket']) ? ' style="width: 100%;"' : '', '>', template_viewreplies(), '</div><br class="clear" />';

		// Our mighty quick reply box :D
		if ($context['can_reply'] && !empty($options['display_quick_reply']))
		{
			echo '
			<br />
			<div class="tborder">
				<div class="title_bar', $options['display_quick_reply'] == 2 ? ' grid_header' : '', '" id="quickreplyheader" >
					<h3 class="titlebg">
						<span class="floatright"><a href="javascript:oQuickReply.swap();"><img src="', $settings['images_url'], '/', $options['display_quick_reply'] == 2 ? 'collapse' : 'expand', '.gif" alt="+" id="quickReplyExpand" class="icon" /></a></span>
						<img src="', $settings['default_images_url'], '/simpledesk/respond.png" alt="x" />
						<a href="javascript:oQuickReply.swap();">', $txt['shd_reply_ticket'], '</a>
					</h3>
				</div>
				<div class="roundframe" id="quickReplyOptions"', $options['display_quick_reply'] == 2 ? '' : ' style="display: none"', '>
					<div class="content">
						<form action="', $scripturl, '?action=helpdesk;sa=savereply" method="post" accept-charset="', $context['character_set'], '" name="postreply" id="postreply" onsubmit="submitonce(this);smc_saveEntities(\'postreply\', [\'shd_reply\'], \'options\');" enctype="multipart/form-data" style="margin: 0;">';

			if ($context['can_go_advanced'])
			{
				echo '
						<div class="description shd_advancedbutton floatright" id="shd_goadvancedbutton">
							<a onclick="goAdvanced(); return false;" href="', $scripturl, '?action=helpdesk;sa=reply;ticket=', $context['ticket_id'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_go_advanced'], '</a><br />
						</div>';
			}

			template_ticket_postbox();
			template_ticket_meta();

			echo '
						</form>
					</div>
				</div>
				<span id="quickreplyfooter" class="lowerframe"', $options['display_quick_reply'] == 2 ? '' : ' style="display: none"', '><span></span></span>
			</div>';
		}

}

/**
 *	Display all the replies to a ticket.
 *
 *	This function deals simply with viewing of replies in a ticket, including deleted replies, which is initialised in {@link shd_view_ticket()}
 *	and data gathered through the {@link shd_prepare_ticket_context()} call back, which simply deals with a single reply at a time.
 *
 *	@see shd_view_ticket()
 *	@see templaet_view_ticket()
 *	@since 1.0
*/
function template_viewreplies()
{
	global $context, $settings, $txt, $scripturl, $options, $modSettings, $reply_request;

	echo '
		<div class="tborder">
		<div class="title_bar grid_header">
			<h3 class="titlebg">
				<span class="floatright smalltext">', $txt['pages'], ': ', $context['page_index'], '</span>
				<img src="', $settings['default_images_url'], '/simpledesk/replies.png" alt="x" /> ', $txt['shd_ticket_replies'], '
			</h3>
		</div>
		<div class="roundframe" id="replies">
			<div class="content">';

	if (empty($reply_request))
	{
		echo $txt['shd_no_replies'];
	}
	else
	{
		while ($reply = $context['get_replies']())
		{
			echo '
					<div class="description shd_reply', (!empty($context['ticket']['display_recycle']) && $reply['message_status'] == MSG_STATUS_DELETED ? ' errorbox' : ''), '" id="msg', $reply['id'], '">
						<span class="floatleft shd_posterinfo">
							<strong class="shd_postername">
								', $reply['member']['link'], '
							</strong>
							<br />
							', $reply['member']['group'], '<br class="shd_groupmargin" />';

			if (!empty($modSettings['shd_display_avatar']) && empty($options['show_no_avatars']) && !empty($reply['member']['avatar']['image']))
					echo '
							', $reply['member']['avatar']['image'];

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
			if ($reply['can_edit'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/edit.png" class="shd_smallicon" alt="*" /><a href="', $scripturl, '?action=helpdesk;sa=editreply;ticket=', $context['ticket_id'], ';msg=', $reply['id'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_edit'], '</a>';
			if ($reply['can_delete'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/delete.png" class="shd_smallicon" alt="*" /><a href="', $scripturl, '?action=helpdesk;sa=deletereply;reply=', $reply['id'], ';ticket=', $context['ticket']['id'], ';', $context['session_var'], '=', $context['session_id'], '" onclick="return confirm(', JavaScriptEscape($txt['shd_delete_reply_confirm']), ');">', $txt['shd_ticket_delete'], '</a>';
			if ($reply['can_restore'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/restore.png" class="shd_smallicon" alt="*" /><a href="', $scripturl, '?action=helpdesk;sa=restorereply;reply=', $reply['id'], ';ticket=', $context['ticket']['id'], ';', $context['session_var'], '=', $context['session_id'], '">', $txt['shd_ticket_restore'], '</a>';
			if ($reply['can_permadelete'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/delete.png" class="shd_smallicon" alt="*" /><a href="', $scripturl, '?action=helpdesk;sa=permadelete;reply=', $reply['id'], ';ticket=', $context['ticket']['id'], ';', $context['session_var'], '=', $context['session_id'], '" onclick="return confirm(', JavaScriptEscape($txt['shd_delete_permanently_confirm']), ');">', $txt['shd_delete_permanently'], '</a>';

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
				<span class="floatright smalltext">', $txt['pages'], ': ', $context['page_index'], '</span>
				<br class="clear" />
			</div>
			<span class="lowerframe"><span></span></span>
		</div>';
}

?>