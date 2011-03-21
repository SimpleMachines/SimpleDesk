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
	echo '<div class="floatleft">', template_button_strip(array($context['navigation']['back']), 'bottom'), '</div>', ($modSettings['shd_ticketnav_style'] != 'smf' ? '<br class="clear" /><br />' : ''), '';

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
					<img src="', $settings['default_images_url'], '/simpledesk/ticket.png" alt="x" /> ', $txt['shd_ticket'], ' [', $context['ticket']['display_id'], ']
				</h3>
			</div>
			<div class="windowbg">
				<div class="content shd_ticket">
					<div class="shd_ticket_side_column">';

			// General ticket details
			echo '
						<div class="information shd_ticketdetails">
							<strong><img src="', $settings['default_images_url'], '/simpledesk/details.png" alt="" class="shd_smallicon shd_icon_minihead" /> ', $txt['shd_ticket_details'], '</strong>
							<hr />
							<ul>
								<li id="item_id"><img src="', $settings['default_images_url'], '/simpledesk/id.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_id'], ': ', $context['ticket']['display_id'], '</li>
								<li id="item_userstarted"><img src="', $settings['default_images_url'], '/simpledesk/user.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_user'], ': ', $context['ticket']['member']['link'], '</li>
								<li id="item_whenstarted"><img src="', $settings['default_images_url'], '/simpledesk/time.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_date'], ': ', $context['ticket']['poster_time'], '</li>
								<li id="item_urgency">
									<img src="', $settings['default_images_url'], '/simpledesk/urgency.png" alt="" class="shd_smallicon" />
									', $txt['shd_ticket_urgency'], ': <span id="urgency">', $context['ticket']['urgency']['label'], '</span>
										<span id="urgency_increase">', (!empty($context['ticket']['urgency']['increase']) ? '<a id="urglink_increase" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket']['id'] . ';change=increase;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_increase'] . '"><img src="' . $settings['images_url'] . '/sort_up.gif" width="9px" alt="' . $txt['shd_urgency_increase'] . '" /></a>' : ''), '</span>
										<span id="urgency_decrease">', (!empty($context['ticket']['urgency']['decrease']) ? '<a id="urglink_decrease" href="' . $scripturl . '?action=helpdesk;sa=urgencychange;ticket=' . $context['ticket']['id'] . ';change=decrease;' . $context['session_var'] . '=' . $context['session_id'] . '" title="' . $txt['shd_urgency_decrease'] . '"><img src="' . $settings['images_url'] . '/sort_down.gif" width="9px" alt="' . $txt['shd_urgency_decrease'] . '" /></a>' : ''), '</span>
								</li>
								<li id="item_assigned">
									<img src="', $settings['default_images_url'], '/simpledesk/staff.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_assignedto'], ': <span id="assigned_to">', $context['ticket']['assigned']['link'], '</span>
									<ul id="assigned_list" style="display:none;">
									</ul>
								</li>
								<li id="item_status"><img src="', $settings['default_images_url'], '/simpledesk/status.png" alt="" class="shd_smallicon"/> ', $txt['shd_ticket_status'], ': ', $context['ticket']['status']['label'], '</li>
								<li id="item_replies"><img src="', $settings['default_images_url'], '/simpledesk/replies.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_num_replies'], ': <a href="#replies">', (empty($context['ticket']['display_recycle']) ? $context['ticket']['num_replies'] : (int) $context['ticket']['num_replies'] + (int) $context['ticket']['deleted_replies']), '</a></li>';

				if (!empty($context['display_private']))
					echo '
								<li><img src="', $settings['default_images_url'], '/simpledesk/private.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_privacy'], ': <span id="privacy">', $context['ticket']['privacy']['label'], '</span>', ($context['ticket']['privacy']['can_change'] ? ' (<a id="privlink" href="' . $scripturl . '?action=helpdesk;sa=privacychange;ticket=' . $context['ticket']['id'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '">' . $txt['shd_ticket_change'] . '</a>)' : ''), '</li>';

				if (!empty($context['ticket']['ip_address']))
					echo '
								<li><img src="', $settings['default_images_url'], '/simpledesk/ip.png" alt="" class="shd_smallicon" /> ', $txt['shd_ticket_ip'], ': ', $context['ticket']['ip_address'], '</li>';
			
				echo'
							</ul>';
							
			// Display ticket poster avatar?
			if (!empty($modSettings['shd_display_avatar']) && empty($options['show_no_avatars']) && !empty($context['ticket']['poster_avatar']['image']))
				echo '
						<div class="shd_ticket_avatar">
							', shd_profile_link($context['ticket']['poster_avatar']['image'], $context['ticket']['member']['id']), '
						</div>';
						
				echo'
						</div>';
				
			// Custom fields :D
			if(!empty($context['ticket']['custom_fields']['details']))
			{
				echo'
						<div class="information shd_additional_details">
							<ul>
							<strong><img src="', $settings['default_images_url'], '/simpledesk/additional_details.png" alt="" class="shd_smallicon shd_icon_minihead" /> ',$txt['shd_ticket_additional_details'],'</strong>
							<hr />';

				foreach($context['ticket']['custom_fields']['details'] AS $field)
				{
					if($field['display_empty'] || !empty($field['value']))
					{
						echo'	<li>
									', !empty($field['icon']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '" alt="" class="shd_smallicon" />' : '','
										', $field['name'],': ';
						
						if(empty($field['value']) && $field['display_empty'])
							echo $txt['shd_ticket_empty_field_short'];
						elseif(!empty($field['value']))
							echo $field['type'] == CFIELD_TYPE_CHECKBOX ? ($field['value'] == 1 ? $txt['yes'] : $txt['no']) : $field['value'];
							
						echo'
								</li>';
					}				
				}
			echo '		</ul>
					</div>';				
			}

			echo '
					</div>
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

			template_inline_attachments($context['ticket']['first_msg']);

			echo '
					</div>
				</div>
				<br class="clear" />
				<span class="botslice"><span></span></span>
			</div>
			</div>
			<br />';

	// Left column (ticket relationships, attachments)
	template_ticket_leftcolumn();
	
	echo'
		<div class="shd_ticket_rightcolumn floatleft"', empty($context['leftcolumndone']) ? ' style="width: 100%;"' : '', '>';
	
	// Additional information (custom fields)
	template_additional_fields();

	// The replies column
	template_viewreplies();
	
	// Our mighty quick reply box :D
	template_quickreply();

	// The ticket action log, lastly.
	template_ticketactionlog();	
	
	echo '
		</div><br class="clear" />';

	// And lastly, the Javascript for AJAX assignment. Since this is onload stuff, it needs to know the HTML already exists.
	if (!empty($context['ajax_assign']))
		echo '
	<script type="text/javascript"><!-- // --><![CDATA[
	var oAjaxAssign = new AjaxAssign({
		sSelf: "oAjaxAssign",
		sScriptUrl: smf_scripturl,
		iTicketId: ' . $context['ticket_id'] . ',
		sId: "item_assigned",
		sListId: "assigned_list",
		sAssignedSpan: "assigned_to",
		sImagesUrl: "' . $settings['default_images_url'] . '/simpledesk",
		sImageCollapsed: "ajax_assign.png",
		sImageExpanded: "ajax_assign_cancel.png"
	});
	// ]' . ']></script>';

}

/**
 *	Displays the left area next to replies in the ticket view.
 *
 *	We pull the content into a single column this way to ensure floatleft items are handled properly.
 *
 *	@since 1.1
*/
function template_ticket_leftcolumn()
{
	global $context;

	if (empty($context['ticket_attach']['ticket']) && empty($context['display_relationships']))
		return; // nothing to do

	$context['leftcolumndone'] = true; // for the rest of the template later

	echo '
				<div class="shd_ticket_leftcolumn floatleft">
					<div class="shd_attachmentcolumn">';

	// Related tickets
	template_viewrelationships();

	// The attachments column
	template_viewticketattach();

	echo '
					</div>
				</div>';
}

/**
 *	Display all the attachments to a ticket (in ticket view)
 *
 *	This function displays all the attachments in the current ticket while in ticket view, rather than when in replies view (which is handled by {@link template_viewreplies()} instead; this function was previously was part of {@link template_viewticket()}.
 *
 *	@since 1.1
*/
function template_viewticketattach()
{
	global $context, $settings, $txt;

	if (!empty($context['ticket_attach']['ticket']))
	{
		echo '	<div class="tborder">
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
							<div class="description shd_attachment" id="attach', $attachment['id'], '">';

			if ($attachment['is_image'])
			{
				if ($attachment['thumbnail']['has_thumb'])
					echo '
										<a href="', $attachment['href'], ';image" id="link_', $attachment['id'], '" onclick="', $attachment['thumbnail']['javascript'], '"><img src="', $attachment['thumbnail']['href'], '" alt="" id="thumb_', $attachment['id'], '" class="shd_thumb" /></a><br />';
				else
					echo '
										<img src="' . $attachment['href'] . ';image" alt="" width="' . $attachment['width'] . '" height="' . $attachment['height'] . '" class="shd_thumb" /><br />';
			}

			echo '
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
				</div>';
	}
}

/**
 *	Additional information
 *
 *	This template displays the "Additional information" block below the ticket body. It contains any custom fields that the admin has set to display there.
 *
 *	@since 1.1
*/
function template_additional_fields()
{
	global $context, $scripturl, $options, $txt, $settings;
	
	if(!empty($context['ticket']['custom_fields']['information']))
	{	
		echo'	<div class="tborder">
					<div class="title_bar grid_header" id="additionalinfoheader">
						<h3 class="titlebg">
							<span class="floatright"><a href="javascript:oCustomFields.infoswap();"><img src="', $settings['images_url'], '/collapse.gif" alt="+" id="shd_custom_fields_swap" class="icon" /></a></span>
							<img src="', $settings['default_images_url'], '/simpledesk/additional_information.png" alt="x" />
							<a href="javascript:oCustomFields.infoswap();">',$txt['shd_ticket_additional_information'],'</a>
						</h3>
					</div>
					<div class="roundframe" id="additional_info">
						<div class="content">';	

			foreach($context['ticket']['custom_fields']['information'] AS $field)
			{
				if($field['display_empty'] || !empty($field['value']))
				{
					echo'
							<div class="description">
							', !empty($field['icon']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '" alt="" class="shd_smallicon" />' : '','
							<strong>', $field['name'],':</strong><hr />';

					if(empty($field['value']) && $field['display_empty'])
						echo $txt['shd_ticket_empty_field'];
					elseif(!empty($field['value']))
						echo $field['value'];
						
						echo'</div>';
				}
			}
		
		echo'
			</div>
		</div>
		<span class="lowerframe" id="additional_info_footer"><span></span></span>
		</div>
		<br />';
	}
}

/**
 *	Displays the quick reply/go advanced box
 *
 *	This function handles displaying of the templates that make up the Quick Reply / Go Advanced area, drawing on {@link SimpleDesk-Post.template.php} for core posting templates.
 *
 *	Prior to 1.1 this was part of {@link template_viewticket()}
 *
 *	@since 1.1
*/
function template_quickreply()
{
	global $context, $scripturl, $options, $txt, $settings;

	if ($context['can_reply'] && !empty($options['display_quick_reply']))
	{
		echo '
		<br />
		<div class="tborder">
			<div class="title_bar', $options['display_quick_reply'] == 2 ? ' grid_header' : '', '" id="quickreplyheader">
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
 *	Display the attachments for a given message.
 *
 *	This function outputs the HTML necessary to display attachments with thumbnails inline with each reply.
 *
 *	@param int $msg The message id to look in $context['ticket_attach']['reply'] for attachments.
 *
 *	@since 1.1
 *	@todo See if it's possible to do a sane CSS replacement instead of using tables.
*/
// Arantor: I swear I spent more time farting around with this trying to make it not look like crap than I did the rest of the thumbnail code.
function template_inline_attachments($msg)
{
	global $context, $txt;

	if (!empty($context['ticket_attach']['reply'][$msg]))
	{
		echo '
							<table width="90%">';
		/*echo '
							<div class="smalltext">
								<strong>', $txt['shd_ticket_attachments'], '</strong><br />
								<ul class="shd_replyattachments">';*/

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
									<td class="description">';

			if ($attachment['is_image'])
			{
				if ($attachment['thumbnail']['has_thumb'])
					echo '
										<a href="', $attachment['href'], ';image" id="link_', $attachment['id'], '" onclick="', $attachment['thumbnail']['javascript'], '"><img src="', $attachment['thumbnail']['href'], '" alt="" id="thumb_', $attachment['id'], '" class="shd_thumb" /></a><br />';
				else
					echo '
										<img src="' . $attachment['href'] . ';image" alt="" width="' . $attachment['width'] . '" height="' . $attachment['height'] . '" class="shd_thumb" /><br />';
			}

			echo '
										', $attachment['link'], '
									</td>';

			$count++;
			if ($count == 3)
				$count = 0;

			$firstrow = false;
		}

		/*echo '
								</ul>
							</div>';*/
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
			if (!empty($reply['is_new']))
				echo '
					<a id="new"></a>';

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
							<span class="shd_posteravatar">
								', shd_profile_link($reply['member']['avatar']['image'], $reply['member']['id']), '
							</span>';

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
			/*if ($reply['can_split'])
				echo '
									<img src="', $settings['default_images_url'], '/simpledesk/split.png" class="shd_smallicon" alt="*" /><a href="', $scripturl, '?action=helpdesk;sa=splitticket;at_msg=', $reply['id'], ';ticket=', $context['ticket']['id'], '">', $txt['shd_ticket_split_ticket'], '</a>';*/

			echo '
								</span>
								<a href="', $reply['link'], '">', sprintf($txt['shd_reply_written'], $reply['time']), '</a>
							</div>
							<hr class="clearfix" />
							', $reply['body'], '
							<br /><br />';
							
		// Custom fields for replies!
		if(!empty($context['custom_fields_replies']))
		{
			echo'
				<hr/>';

			foreach($context['custom_fields_replies'] AS $field)
			{
				if($field['display_empty'] || !empty($message['custom_field'][$field['id']]['value']))
				{
					echo'	
							', !empty($field['icon']) ? '<img src="' . $settings['default_images_url'] . '/simpledesk/cf/' . $field['icon'] . '" alt="" class="shd_smallicon" />' : '','
							<strong>', $field['name'],':</strong>';

					if(empty($message['custom_field'][$field['id']]['value']) && $field['display_empty'])
						echo $txt['shd_ticket_empty_field'], '<br /><br />';
					elseif(!empty($message['custom_field'][$field['id']]['value']))
						echo $message['custom_field'][$field['id']]['value'], '<br /><br />';
				}
			}
		}							

			if ($settings['show_modify'] && !empty($reply['modified']))
			{
				echo '
							<div class="smalltext shd_modified" style="margin-top:20px;">
								&#171; <em>', $txt['last_edit'], ': ', $reply['modified']['time'], ' ', $txt['by'], ' ', $reply['modified']['link'], '</em> &#187;
							</div>';
			}

			template_inline_attachments($reply['id']);

			echo '
						</div>';

			if (!empty($reply['ip_address']))
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

/**
 *	Display related tickets.
 *
 *	Displays the block of tickets that have a relationship to this one.
 *
 *	@since 1.1
*/
function template_viewrelationships()
{
	global $context, $settings, $txt, $scripturl;

	if (!empty($context['display_relationships']))
	{
		echo '	<div class="tborder">
					<div class="title_bar grid_header">
						<h3 class="titlebg">
							<img src="', $settings['default_images_url'], '/simpledesk/relationships.png" alt="x" />', $txt['shd_ticket_relationships'], ' (', $context['relationships_count'], ')
						</h3>
					</div>
					<div class="windowbg2">
						<div class="shd_attachmentbox">';

		foreach ($context['ticket_relationships'] as $rel_type => $relationships)
		{
			if (empty($relationships))
				continue;

			echo '
							<img src="', $settings['default_images_url'], '/simpledesk/rel_', $rel_type, '.png" alt="" /> <strong>', $txt['shd_ticket_reltype_' . $rel_type], ':</strong><br />';

			foreach ($relationships as $rel)
			{
				echo '
							';

				if (!empty($context['delete_relationships']))
					echo '<a href="', $scripturl, '?action=helpdesk;sa=relation;ticket=', $context['ticket_id'], ';otherticket=', $rel['id'], ';relation=delete;', $context['session_var'], '=', $context['session_id'], '"><img class="shd_smallicon" src="', $settings['default_images_url'], '/simpledesk/delete.png" alt="', $txt['shd_ticket_delete_relationship'], '" title="', $txt['shd_ticket_delete_relationship'], '" /></a>';

				echo '<span class="smalltext">[', $rel['display_id'], '] <a href="', $scripturl, '?action=helpdesk;sa=ticket;ticket=', $rel['id'], '">', $rel['subject'], '</a> (', $rel['status_txt'], ')</span><br />';
			}
		}

		if (!empty($context['create_relationships']))
		{
			if ($context['relationships_count'] > 0)
				echo '
						<hr />';

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
							<input type="text" class="input_text" name="otherticket" value="" size="5" />
							<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
							<input type="hidden" name="ticket" value="', $context['ticket_id'], '" />
							<input type="submit" class="button_submit" value="', $txt['shd_go'], '" />
						</form>';
		}

		echo '
						</div>
						<span class="botslice"><span></span></span>
					</div>
				</div>
					<br />';
	}
}

/**
 *	Display the events on a ticket.
 *
 *	Displays all the non-post type events that apply to the current ticket, as a subset of the master action log. Data is gathered from {@link shd_load_action_log_entries()}
 *
 *	@since 1.1
*/
function template_ticketactionlog()
{
	global $context, $settings, $txt, $scripturl;
	if (!empty($context['display_ticket_log']))
	{
		echo '
				<br />
				<div class="tborder">
					<div class="title_bar" id="ticket_log_header">
						<h3 class="titlebg">
							<span class="floatright shd_ticket_log_expand_container"> <a href="javascript:ActionLog.swap();"><img src="', $settings['images_url'], '/expand.gif" alt="+" id="shd_ticket_log_expand" class="icon" /></a></span>
							<img src="', $settings['default_images_url'], '/simpledesk/log.png" class="icon" alt="*" />
							<a href="javascript:ActionLog.swap();">', $txt['shd_ticket_log'], '</a>
							<span class="smalltext">(', $context['ticket_log_count'] == 1 ? $txt['shd_ticket_log_count_one'] : sprintf($txt['shd_ticket_log_count_more'],$context['ticket_log_count']) , ')</span>
						</h3>
					</div>
					<table class="shd_ticketlist" id="ticket_log" cellspacing="0" width="100%" style="display: none;">
						<tr class="titlebg">
							<td width="15%">
								<img src="', $settings['default_images_url'], '/simpledesk/time.png" class="shd_smallicon" alt="" />
								', $txt['shd_ticket_log_date'], '
							</td>
							<td width="15%">
								<img src="', $settings['default_images_url'], '/simpledesk/user.png" class="shd_smallicon" alt="" />
								', $txt['shd_ticket_log_member'], '
							</td>
							<td width="50%">
								<img src="', $settings['default_images_url'], '/simpledesk/action.png" class="shd_smallicon" alt="" />
								', $txt['shd_ticket_log_action'], '
							</td>
						</tr>';

		if (empty($context['ticket_log']))
			echo '
						<tr class="windowbg2">
							<td colspan="3" class="shd_noticket">', $txt['shd_ticket_log_none'], '</td>
						</tr>';
		else
		{
			$use_bg2 = true; // start with windowbg2 to differentiate between that and windowbg2
			foreach ($context['ticket_log'] as $action)
			{
				echo '
						<tr class="', ($use_bg2 ? 'windowbg2' : 'windowbg'), '">
							<td class="smalltext">', $action['time'], '</td>
							<td', !empty($action['member']['ip']) ? ' title="' . $txt['shd_ticket_log_ip'] . ' ' . $action['member']['ip'] . '"' : '', '>', $action['member']['link'], ' <span class="smalltext">(', $action['member']['group'], ')</span></td>
							<td class="smalltext">
								<img src="', $settings['default_images_url'], '/simpledesk/', $action['action_icon'], '" alt="" class="shd_smallicon" />
								', $action['action_text'], '
							</td>
						</tr>';

				$use_bg2 = !$use_bg2;
			}
		}

		echo '
						<tr class="titlebg">
							<td colspan="3">
								', !empty($context['ticket_full_log']) ? '<span class="smalltext shd_main_log"><img src="' . $settings['default_images_url'] . '/simpledesk/browse.png" alt="" /> <a href="' . $scripturl . '?action=admin;area=helpdesk_info;sa=actionlog">' . $txt['shd_ticket_log_full'] . '</a></span>' : '', '
							</td>
						</tr>
					</table>
				</div>';
	}
}
?>