/* Javascript for the main Helpdesk */

/* Implant a JSON handler for Ajax */
function shd_getJSONDocument(sUrl, funcCallback, sMethod)
{
	ajax_indicator(true);

	if (typeof(sMethod) == 'undefined')
		sMethod = 'GET';

	var oMyDoc = $.ajax({
		method: sMethod,
		url: sUrl,
		cache: false,
		dataType: 'json',
		success: function(responseJSON) {
			if (typeof(funcCallback) != 'undefined')
			{
				ajax_indicator(false);

				funcCallback.call(this, responseJSON);
			}
		},
	});

	return oMyDoc;
}

function shd_sendJSONDocument(sUrl, funcCallback)
{
	return shd_getJSONDocument(sUrl, funcCallback, 'POST');
}

/* The privacy toggle in AJAX */
function shd_privacyControl(oOpts)
{
	this.opt = oOpts; // attaches to the link, but it doesn't exist until after DOM is loaded!
	$(document).ready(this.init.bind(this));
}

shd_privacyControl.prototype.init = function ()
{
	$('#' + this.opt.sSrcA).on('click', this.action.bind(this));
}

shd_privacyControl.prototype.action = function (e)
{
	e.preventDefault();
	shd_getJSONDocument(this.opt.sUrl + ';' + this.opt.sSession, this.callback.bind(this));
	return false;
}

shd_privacyControl.prototype.callback = function (oRecvd)
{
	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.message)
		$('#' + this.opt.sDestSpan).html(oRecvd.message);
	else
		if (confirm(shd_ajax_problem))
			window.location = smf_scripturl + '?action=helpdesk;sa=privacychange;ticket=' + this.opt.ticket + ';' + this.opt.sSession;

	return false;
}

/* The urgency doodad */
function shd_urgencyControl(oOpts)
{
	this.opt = oOpts; // attaches to the link, but it doesn't exist until after DOM is loaded!
	$(document).ready(this.init.bind(this));
}

shd_urgencyControl.prototype.init = function ()
{
	for (var i in this.opt.aButtonOps)
	{
		if (!this.opt.aButtonOps.hasOwnProperty(i))
			continue;

		var oDiv = $('#urglink_' + this.opt.aButtonOps[i]);
		if (oDiv !== null && i == 'up')
			oDiv.on('click', this.actionUp.bind(this));
		else if (oDiv !== null && i == 'down')
			oDiv.on('click', this.actionDown.bind(this)); // I *did* try to make this a single parameterised function but it always fired when it wasn't supposed to
	}

	// Setup the assign by list option.
	this.bCollapsed = true;
	this.opt.sUrlExpand = smf_prepareScriptUrl(smf_scripturl) + 'action=helpdesk;sa=ajax;op=urgencylist;ticket=' + this.opt.iTicketId;
	this.opt.sUrlAssign = smf_prepareScriptUrl(smf_scripturl) + 'action=helpdesk;sa=ajax;op=urgency;assign;ticket=' + this.opt.iTicketId;
	$('#' + this.opt.sSelectButtonId).html('<img src="' + this.opt.sImageCollapsed + '" id="urgency_' + this.opt.sSelf + '" class="shd_urgency_button">');
	$('.shd_ticketdetails').on('click', '#urgency_' + this.opt.sSelf, this.clickList.bind(this));

}

shd_urgencyControl.prototype.actionUp = function (e)
{
	e.preventDefault();
	return this.action('up');
}

shd_urgencyControl.prototype.actionDown = function (e)
{
	e.preventDefault();
	return this.action('down');
}

shd_urgencyControl.prototype.action = function (direction)
{
	this.direction = direction;
	shd_getJSONDocument(this.opt.sUrl + this.opt.aButtonOps[direction] + ';' + this.opt.sSession, this.callback.bind(this));
	return false;
}

shd_urgencyControl.prototype.callback = function (oRecvd)
{
	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.message)
	{
		$('#' + this.opt.sDestSpan).html(oRecvd.message);

		var btn_set = ['increase', 'decrease'];
		for (var i in btn_set)
		{
			if (!btn_set.hasOwnProperty(i))
				continue;

			var oBtn = oRecvd[btn_set[i]];
			$('#urgency_' + btn_set[i]).html(oBtn ? oBtn : '');
		}

		// Attach JS events to new links
		this.init();
	}
	else
		if (confirm(shd_ajax_problem))
			window.location = smf_scripturl + '?action=helpdesk;sa=urgencychange;ticket=' + this.opt.iTicketId + ';change=' + this.opt.aButtonOps[this.direction] + ';' + this.opt.sSession;

	return false;
}

shd_urgencyControl.prototype.clickList = function ()
{
	if (this.bCollapsed)
		this.expandList();
	else
		this.collapseList();
}

shd_urgencyControl.prototype.expandList = function ()
{
	this.bCollapsed = false;
console.log('shd_urgencyControl.prototype.expandList:', this.opt.sSelectButtonId, $('#' + this.opt.sSelectButtonId), this.opt.sImageExpanded);
	$('#urgency_' + this.opt.sSelf).attr('src', this.opt.sImageExpanded);

	// Fetch the list of items
	shd_getJSONDocument(this.opt.sUrlExpand + ';' + this.opt.sSession, this.expandList_callback.bind(this));
}

shd_urgencyControl.prototype.expandList_callback = function (oRecvd)
{
	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.urgencies)
	{
		$('#' + this.opt.sSelectListId).show();

		var newhtml = '';
		var cur = 0;
		for (var i in oRecvd.urgencies)
		{
			if (!oRecvd.urgencies.hasOwnProperty(i))
				continue;

			cur = oRecvd.urgencies[i];
			selected = cur.selected ? ' selected="selected"' : '';
			newhtml += '<option class="shd_urgencies" data-id="' + cur.id + '"' + selected + '>' + cur.name + '</option>';
		}

		$('#' + this.opt.sSelectListId).html(newhtml);
		$('#' + this.opt.sSelectListId).on('change', this.assignUrgency.bind(this));
	}
}

shd_urgencyControl.prototype.assignUrgency = function (e)
{
	// Click handler for the assignment list, to issue the assign
	ajax_indicator(true);

	var selectedIndex = e.currentTarget.selectedIndex;	
	shd_getJSONDocument(this.opt.sUrlAssign + ';urgency=' + e.currentTarget[selectedIndex].dataset.id + ';'+ this.opt.sSession, this.assignUrgencyCallback.bind(this));
}

shd_urgencyControl.prototype.assignUrgencyCallback = function(oRecvd)
{
	// Click handler callback for assignment, to handle once the request has been made
	this.collapseList();

	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.message)
		document.getElementById(this.opt.sDestSpan).innerHTML = oRecvd.message;
}

shd_urgencyControl.prototype.collapseList = function ()
{
	this.bCollapsed = true;
	$('#' + this.opt.sSelectListId).hide().html();
	$('#urgency_' + this.opt.sSelf).attr('src', this.opt.sImageCollapsed);
}


/* Attachment selector, based on http://the-stickman.com/web-development/javascript/upload-multiple-files-with-a-single-file-element/
* The code below is modified under the MIT licence, http://the-stickman.com/using-code-from-this-site-ie-licence/ not reproduced here for
* convenience of users using this software (as this is an active downloaded file) */
function shd_attach_select(oOptions)
{
	shd_attach_select.prototype.opts = oOptions;
	shd_attach_select.prototype.count = 0;
	shd_attach_select.prototype.id = 0;
	shd_attach_select.prototype.max = (oOptions.max) ? oOptions.max : -1;
	shd_attach_select.prototype.addElement(document.getElementById(shd_attach_select.prototype.opts.file_item));
};

shd_attach_select.prototype.addElement = function (element)
{
	// Make sure it's a file input element, ignore it if not
	if (element.tagName == 'INPUT' && element.type == 'file')
	{
		element.name = 'file_' + this.id++;
		element.multi_selector = this;
		element.onchange = function()
		{
			if (element.value == '')
				return;

			// Check if it's a valid extension (if we're checking such things)
			if (!shd_attach_select.prototype.checkExtension(element.value))
			{
				alert(shd_attach_select.prototype.opts.message_ext_error_final);
				element.value = '';
				return;
			}

			var new_element = document.createElement('input');
			new_element.type = 'file';
			new_element.className = 'input_file';
			new_element.setAttribute('size', '60');

			// Add new element, update everything
			this.parentNode.insertBefore(new_element, this);
			this.multi_selector.addElement(new_element);
			this.multi_selector.addListRow(this);

			// Hide this: we can't use display:none because Safari doesn't like it
			this.style.position = 'absolute';
			this.style.left = '-1000px';
		};

		this.count++;
		shd_attach_select.prototype.current_element = element;
		this.checkActive();
	}
};

shd_attach_select.prototype.checkExtension = function (filename)
{
	if (!shd_attach_select.prototype.opts.attachment_ext)
		return true; // we're not checking

	if (!filename || filename.length === 0)
	{
		shd_attach_select.prototype.opts.message_ext_error_final = shd_attach_select.prototype.opts.message_ext_error.replace(' ({ext})', '');
		return false; // pfft, didn't specify anything
	}

	var dot = filename.lastIndexOf(".");
	if (dot == -1)
	{
		shd_attach_select.prototype.opts.message_ext_error_final = shd_attach_select.prototype.opts.message_ext_error.replace(' ({ext})', '');
		return false; // no extension
	}

	var ext = (filename.substr(dot + 1, filename.length)).toLowerCase();
	var arr = shd_attach_select.prototype.opts.attachment_ext;
	var func = Array.prototype.indexOf ?
		function(arr, obj) { return arr.indexOf(obj) !== -1; } :
		function(arr, obj) {
			for (var i = -1, j = arr.length; ++i < j;)
				if (arr[i] === obj) return true;
			return false;
    };
	var value = func(arr, ext);
	if (!value)
		shd_attach_select.prototype.opts.message_ext_error_final = shd_attach_select.prototype.opts.message_ext_error.replace('{ext}', ext);

	return value;
}

shd_attach_select.prototype.addListRow = function (element)
{
	var new_row = document.createElement('div');
	var new_row_button = document.createElement('input');
	new_row_button.type = 'button';
	new_row_button.value = this.opt.message_txt_delete;
	new_row_button.className = 'button';
	new_row.element = element;

	new_row_button.onclick = function ()
	{
		// Remove element from form
		this.parentNode.element.parentNode.removeChild(this.parentNode.element);
		this.parentNode.parentNode.removeChild(this.parentNode);
		this.parentNode.element.multi_selector.count--;
		shd_attach_select.prototype.checkActive();
		return false;
	};

	new_row.innerHTML = element.value + '&nbsp; &nbsp;';
	new_row.appendChild(new_row_button);
	document.getElementById(this.opt.file_container).appendChild(new_row);
};

shd_attach_select.prototype.checkActive = function()
{
	var elements = document.getElementsByTagName('input');
	var session_attach = 0;
	for (var i in elements)
	{
		if (!elements.hasOwnProperty(i))
			continue;

		if (elements[i] && elements[i].type == 'checkbox' && elements[i].name == 'attach_del[]' && elements[i].checked === true)
			session_attach++;
	}

	var flag = !(shd_attach_select.prototype.max == -1 || (this.max >= (session_attach + shd_attach_select.prototype.count)));
	shd_attach_select.prototype.current_element.disabled = flag;
}

/* Quick reply stuff */
function QuickReply(oOptions)
{
	this.opt = oOptions;
	$(this.opt.sRepliesSelector + ', ' + this.opt.sFirstPostSelector).on('click', this.quote.bind(this));
}

// When a user presses quote, put it in the quick reply box (if expanded).
QuickReply.prototype.quote = function (e)
{
	e.preventDefault();
	this.iMessageId = e.currentTarget.dataset.id;

	shd_getJSONDocument(smf_prepareScriptUrl(this.opt.sScriptUrl) + 'action=helpdesk;sa=ajax;op=quote;quote=' + this.iMessageId + ';' + this.opt.sSession + ';json' + ';mode=' + (oEditorHandle_shd_message.bRichTextEnabled ? 1 : 0), this.onQuoteReceived.bind(this));

	// Move the view to the quick reply box.
	window.location.hash = navigator.appName == 'Microsoft Internet Explorer' ? this.opt.sJumpAnchor : '#' + this.opt.sJumpAnchor;
	return false;
}

// This is the callback function used after the json request.
QuickReply.prototype.onQuoteReceived = function (oRecvd)
{
	if (oRecvd && oRecvd.success === true && oRecvd.message)
		oEditorHandle_shd_message.insertText(oRecvd.message, false, true);
}


function CannedReply(oOptions)
{
	this.opt = oOptions;
	$('#' + this.opt.sCannedRepliesContainerId).show();
	$('#' + this.opt.sCannedRepliesContainerId + ' input.button').on('click', this.getReply.bind(this));
}

CannedReply.prototype.getReply = function ()
{
	var iReplyId = $('#' + this.opt.sSelectContainerId).val();
	if (!iReplyId || parseInt(iReplyId, 10) < 1)
		return false;

	shd_getJSONDocument(smf_prepareScriptUrl(this.opt.sScriptUrl) + 'action=helpdesk;sa=ajax;op=canned;ticket=' + this.opt.iTicketId + ';reply=' + iReplyId + ';' + this.opt.sSessionVar + '=' + this.opt.sSessionId + ';json' + ';mode=' + (oEditorHandle_shd_message.bRichTextEnabled ? 1 : 0), this.onReplyReceived.bind(this));

	return false;
}

// This is the callback function used after the json request.
CannedReply.prototype.onReplyReceived = function (oRecvd)
{
	if (oRecvd && oRecvd.success === true && oRecvd.message)
		oEditorHandle_shd_message.insertText(oRecvd.message, false, true);
}

// The quick jump function
function shd_quickTicketJump(id_ticket)
{
	window.location.href = smf_prepareScriptUrl(smf_scripturl) + '?action=helpdesk;sa=ticket;ticket=' + id_ticket;
	return false;
}

/* AJAX assignment */
function AjaxAssign(oOptions)
{
	this.opt = oOptions;
	this.bCollapsed = true;
	this.opt.sUrlExpand = smf_prepareScriptUrl(smf_scripturl) + 'action=helpdesk;sa=ajax;op=assign;ticket=' + this.opt.iTicketId;
	this.opt.sUrlAssign = smf_prepareScriptUrl(smf_scripturl) + 'action=helpdesk;sa=ajax;op=assign2;ticket=' + this.opt.iTicketId;

	// Insert the expand/collapse button
	$('#' + this.opt.sId).html('<img src="' + this.opt.sImageCollapsed + '" id="assign_' + this.opt.sSelf + '" class="shd_assign_button">');
	$('.shd_ticketdetails').on('click', '#assign_' + this.opt.sSelf, this.click.bind(this));
}

AjaxAssign.prototype.click = function ()
{
	if (this.bCollapsed)
		this.expand();
	else
		this.collapse();
}

AjaxAssign.prototype.expand = function ()
{
	this.bCollapsed = false;
	$('#assign_' + this.opt.sSelf).attr('src', this.opt.sImageExpanded);

	// Fetch the list of items
	shd_getJSONDocument(this.opt.sUrlExpand + ';' + this.opt.sSession, this.expand_callback.bind(this));
}

AjaxAssign.prototype.expand_callback = function (oRecvd)
{
	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.members)
	{
		$('#' + this.opt.sListId).show();

		var newhtml = '';
		var cur = 0;
		for (var i in oRecvd.members)
		{
			if (!oRecvd.members.hasOwnProperty(i))
				continue;

			cur = oRecvd.members[i];
			newhtml += '<li class="shd_assignees" data-uid="' + cur.uid + '"><img src="' + (cur.admin == 'yes' ? this.opt.sImageAdmin : this.opt.sImageStaff) + '" alt="" class="shd_smallicon">' + cur.name + '</li>';
		}

		$('#' + this.opt.sListId).html(newhtml);
		$('#' + this.opt.sListId).on('click', 'li.shd_assignees', this.assign.bind(this));
	}
}

AjaxAssign.prototype.assign = function (e)
{
	// Click handler for the assignment list, to issue the assign
	ajax_indicator(true);

	shd_getJSONDocument(this.opt.sUrlAssign + ';to_user=' + e.currentTarget.dataset.uid + ';'+ this.opt.sSession, this.assign_callback.bind(this));
}

AjaxAssign.prototype.assign_callback = function(oRecvd)
{
	// Click handler callback for assignment, to handle once the request has been made
	this.collapse();

	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.assigned)
		document.getElementById(this.opt.sAssignedSpan).innerHTML = oRecvd.assigned;
}

AjaxAssign.prototype.collapse = function ()
{
	this.bCollapsed = true;
	$('#' + this.opt.sListId).hide().html();
	$('#assign_' + this.opt.sSelf).attr('src', this.opt.sImageCollapsed);
}

/* Ajax Notifications List */
function shd_notifications(iTicketId, oOptions)
{
	this.ticketId = iTicketId;
	this.opt = oOptions;
	this.init();
	return false;
}

shd_notifications.prototype.init = function ()
{
	$('#' + this.opt.sLinkId).on('click', this.receiveNotifications.bind(this));
	$('#' + this.opt.sContainerId).show();
}

shd_notifications.prototype.receiveNotifications = function ()
{
	shd_getJSONDocument(smf_prepareScriptUrl(smf_scripturl) + "action=helpdesk;sa=ajax;op=notify;ticket=" + this.ticketId + ";" + this.opt.sSessionVar + '=' + this.opt.sSessionId + (this.opt.sPinglist ? ";" + this.opt.sPinglist : ''), this.onReceiveNotifications.bind(this));
	return false;
}

shd_notifications.prototype.onReceiveNotifications = function (oRecvd)
{
	if (typeof(oRecvd) == 'undefined')
		return;

	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);

	var newhtml = ''; var temphtml = ''; var member = ''; var subtemplate = '';
	var cur = 0; var i = 0; var j = 0; var k = 0;
	var template = this.opt.oMainTemplate;

	if (oRecvd.being_notified)
	{
		subtemplate = this.opt.oNotifiedTemplate;

		temphtml = '';
		for (i in oRecvd.being_notified)
		{
			if (!oRecvd.being_notified.hasOwnProperty(i))
				continue;

			cur = oRecvd.being_notified[i];
			member = subtemplate.replace('%name%', cur);

			temphtml += member;
		}

		newhtml = template.replace('%title%', oRecvd.being_notified_txt).replace('%subtemplate%', temphtml);
	}

	if (oRecvd.optional)
	{
		subtemplate = this.opt.oOptionalTemplate;

		temphtml = '';
		for (var i in oRecvd.optional)
		{
			if (!oRecvd.optional.hasOwnProperty(i))
				continue;

			cur = oRecvd.optional[i];

			member = subtemplate.replace('%name%', cur);
			member = member.replace('%index%', i);
			member = member.replace('%index%', i);

			for (j in oRecvd.selected)
			{
				k = oRecvd.selected[j];
				member = member.replace('%checked%', i == k ? ' checked' : '');
			}

			temphtml += member;
		}

		newhtml += template.replace('%title%', oRecvd.optional_txt).replace('%subtemplate%', temphtml);
	}

	if (oRecvd.optional_butoff)
	{
		subtemplate = this.opt.oOptionalOffTemplate;

		temphtml = '';
		for (i in oRecvd.optional_butoff)
		{
			if (!oRecvd.optional_butoff.hasOwnProperty(i))
				continue;

			cur = oRecvd.optional_butoff[i];
			member = subtemplate.replace('%name%', cur);
			member = member.replace('%index%', i);
			member = member.replace('%index%', i);

			for (j in oRecvd.selected)
			{
				k = oRecvd.selected[j];
				member = member.replace('%checked%', i == k ? ' checked' : '');
			}

			temphtml += member;
		}

		newhtml += template.replace('%title%', oRecvd.optional_butoff_txt).replace('%subtemplate%', temphtml);
	}

	$('#' + this.opt.sContainerId).html(newhtml);
}

/* Go Advanced Handling */
function goAdvanced(oOptions)
{
	this.opt = oOptions;
	$('#' + this.opt.sAdvancedContainerId).on('click', this.click.bind(this));

	$(document).ready(this.init.bind(this));
}

goAdvanced.prototype.init = function()
{
	$('#' + this.opt.sBbcContainerId +
		', .' + this.opt.sBbcContainerEditorClass +
		', #' + this.opt.sSmileyContainerId +
		', .' + this.opt.sSmileyContainerEditorClass +
		', .' + this.opt.sAttachContainerId +
		', #' + this.opt.sAdditionalOptionsContainerId
		).hide();
}

goAdvanced.prototype.click = function(e)
{
	e.preventDefault();

	$('#' + this.opt.sBbcContainerId + ', .' + this.opt.sBbcContainerEditorClass).css('display', this.opt.bAllowBBC ? '' : 'none');
	$('#' + this.opt.sSmileyContainerId + ', .' + this.opt.sSmileyContainerEditorClass).css('display', this.opt.bAllowSmileys ? '' : 'none');
	$('#' + this.opt.sAttachContainerId).css('display', this.opt.bAllowAttach ? '' : 'none');
	$('#' + this.opt.sAdditionalOptionsContainerId).show();
	$('#' + this.opt.sAdvancedContainerId).hide();
}

/* Department Filters */
function shd_dept_filter(oOptions)
{
	this.opt = oOptions;
	$('#' + this.opt.sSelectContainerId).on('change', this.startFilter.bind(this));
}

shd_dept_filter.prototype.startFilter = function ()
{
	this.displayed = false;
	$(this.opt.oFields).each(this.filterDept.bind(this));
}

shd_dept_filter.prototype.filterDept = function (index)
{
	this.currentDept = $('#' + this.opt.sSelectContainerId).val();

	if (in_array(this.currentDept, this.opt.oFields[index]))
	{
		this.displayed = true;
		$('#field_' + index + '_container').show();
	}
	else
		$('#field_' + index + '_container').hide();

	$('#' + this.opt.sCustomFieldsContainerId + ', #' + this.opt.sCustomFieldsTitleContainerId).toggle(this.displayed)
}
