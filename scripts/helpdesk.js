/* Javascript for the main Helpdesk */

/* Implant a JSON handler for Ajax */
function shd_getJSONDocument(sUrl, funcCallback, sMethod)
{
	ajax_indicator(true);

	if (typeof(sMethod) == 'undefined')
		sMethod = 'GET';

	var oCaller = this;
	var oMyDoc = $.ajax({
		method: sMethod,
		url: sUrl,
		cache: false,
		dataType: 'json',
		success: function(responseJSON) {
			if (typeof(funcCallback) != 'undefined')
			{
				ajax_indicator(false);

				funcCallback.call(oCaller, responseJSON);
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
	shd_privacyControl.prototype.opts = oOpts; // attaches to the link, but it doesn't exist until after DOM is loaded!
	if (window.addEventListener)
		window.addEventListener('load', shd_privacyControl.prototype.init, false);
	else if (window.attachEvent)
		window.attachEvent('onload', shd_privacyControl.prototype.init);
}

shd_privacyControl.prototype.init = function ()
{
	var oDiv = document.getElementById(shd_privacyControl.prototype.opts.sSrcA);
	if (oDiv !== null)
		oDiv.onclick = shd_privacyControl.prototype.action;
}

shd_privacyControl.prototype.action = function ()
{
	shd_getJSONDocument(shd_privacyControl.prototype.opts.sUrl + ';' + shd_privacyControl.prototype.opts.sSession, shd_privacyControl.prototype.callback);
	return false;
}

shd_privacyControl.prototype.callback = function (oRecvd)
{
	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.message)
	{
		var oSpan = document.getElementById(shd_privacyControl.prototype.opts.sDestSpan);
		oSpan.firstChild.nodeValue = oRecvd.message;
	}
	else
		if (confirm(shd_ajax_problem))
			window.location = smf_scripturl + '?action=helpdesk;sa=privacychange;ticket=' + shd_privacyControl.prototype.opts.ticket + ';' + shd_privacyControl.prototype.opts.sSession;

	return false;
}

/* The urgency doodad */
function shd_urgencyControl(oOpts)
{
	shd_urgencyControl.prototype.opts = oOpts; // attaches to the link, but it doesn't exist until after DOM is loaded!
	if (window.addEventListener)
		window.addEventListener('load', shd_urgencyControl.prototype.init, false);
	else if (window.attachEvent)
		window.attachEvent('onload', shd_urgencyControl.prototype.init);
}

shd_urgencyControl.prototype.init = function ()
{
	for (var i in shd_urgencyControl.prototype.opts.aButtonOps)
	{
		if (!shd_urgencyControl.prototype.opts.aButtonOps.hasOwnProperty(i))
			continue;

		var oDiv = document.getElementById('urglink_' + shd_urgencyControl.prototype.opts.aButtonOps[i]);
		if (oDiv !== null && i == 'up')
			oDiv.onclick = shd_urgencyControl.prototype.actionUp;
		else if (oDiv !== null && i == 'down')
			oDiv.onclick = shd_urgencyControl.prototype.actionDown; // I *did* try to make this a single parameterised function but it always fired when it wasn't supposed to
	}
}

shd_urgencyControl.prototype.actionUp = function ()
{
	return shd_urgencyControl.prototype.action('up');
}

shd_urgencyControl.prototype.actionDown = function ()
{
	return shd_urgencyControl.prototype.action('down');
}

shd_urgencyControl.prototype.action = function (direction)
{
	shd_urgencyControl.prototype.opts.direction = direction;
	shd_getJSONDocument(shd_urgencyControl.prototype.opts.sUrl + shd_urgencyControl.prototype.opts.aButtonOps[direction] + ';' + shd_urgencyControl.prototype.opts.sSession, shd_urgencyControl.prototype.callback);
	return false;
}

shd_urgencyControl.prototype.callback = function (oRecvd)
{
	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.message)
	{
		setInnerHTML(document.getElementById(shd_urgencyControl.prototype.opts.sDestSpan), oRecvd.message);

		var btn_set = [ "increase", "decrease" ];
		for (var i in btn_set)
		{
			if (!btn_set.hasOwnProperty(i))
				continue;

			var oBtn = oRecvd[btn_set[i]];
			var oSpan = document.getElementById('urgency_' + btn_set[i]);
			setInnerHTML(oSpan, (oBtn ? oBtn : ''));
		}

		// Attach JS events to new links
		shd_urgencyControl.prototype.init();
	}
	else
		if (confirm(shd_ajax_problem))
			window.location = smf_scripturl + '?action=helpdesk;sa=urgencychange;ticket=' + shd_urgencyControl.prototype.opts.ticket + ';change=' + shd_urgencyControl.prototype.opts.aButtonOps[shd_urgencyControl.prototype.opts.direction] + ';' + shd_urgencyControl.prototype.opts.sSession;

	return false;
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
	new_row_button.value = this.opts.message_txt_delete;
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
	document.getElementById(this.opts.file_container).appendChild(new_row);
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
	this.bCollapsed = this.opt.bDefaultCollapsed;
}

// When a user presses quote, put it in the quick reply box (if expanded).
QuickReply.prototype.quote = function (iMessageId, sSessionId, sSessionVar)
{
	if (this.bCollapsed)
	{
		window.location.href = smf_prepareScriptUrl(this.opt.sScriptUrl) + 'action=helpdesk;sa=reply;quote=' + iMessageId + ';ticket=' + this.opt.iTicketId + '.' + this.opt.iStart + ';' + sSessionVar + '=' + sSessionId;
		return false;
	}

	shd_getJSONDocument(smf_prepareScriptUrl(this.opt.sScriptUrl) + 'action=helpdesk;sa=ajax;op=quote;quote=' + iMessageId + ';' + sSessionVar + '=' + sSessionId + ';json' + ';mode=' + (oEditorHandle_shd_message.bRichTextEnabled ? 1 : 0), this.onQuoteReceived);

	// Move the view to the quick reply box.
	if (navigator.appName == 'Microsoft Internet Explorer')
		window.location.hash = this.opt.sJumpAnchor;
	else
		window.location.hash = '#' + this.opt.sJumpAnchor;

	return false;
}

// This is the callback function used after the json request.
QuickReply.prototype.onQuoteReceived = function (oRecvd)
{
	if (oRecvd && oRecvd.success === true && oRecvd.message)
		oEditorHandle_shd_message.insertText(oRecvd.message, false, true);
}

// The function handling the swapping of the quick reply.
QuickReply.prototype.swap = function ()
{
	document.getElementById(this.opt.sImageId).src = this.opt.sImagesUrl + "/" + (this.bCollapsed ? this.opt.sImageCollapsed : this.opt.sImageExpanded);
	document.getElementById(this.opt.sContainerId).style.display = this.bCollapsed ? '' : 'none';
	document.getElementById(this.opt.sFooterId).style.display = this.bCollapsed ? '' : 'none';
	document.getElementById(this.opt.sHeaderId).setAttribute('class', (this.bCollapsed ? 'title_bar grid_header' : 'title_bar'));

	this.bCollapsed = !this.bCollapsed;
}

function CannedReply(oOptions)
{
	this.opt = oOptions;
	document.getElementById("canned_replies").style.display = "";
}

CannedReply.prototype.getReply = function ()
{
	var iReplyId = document.getElementById('canned_replies_select').value;
	if (!iReplyId || parseInt(iReplyId, 10) < 1)
		return false;

	shd_getJSONDocument(smf_prepareScriptUrl(this.opt.sScriptUrl) + 'action=helpdesk;sa=ajax;op=canned;ticket=' + this.opt.iTicketId + ';reply=' + iReplyId + ';' + this.opt.sSessionVar + '=' + this.opt.sSessionId + ';json' + ';mode=' + (oEditorHandle_shd_message.bRichTextEnabled ? 1 : 0), this.onReplyReceived);

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

/* The action log in tickets - Not much. */

function ActionLog(oOptions)
{
	this.opt = oOptions;
	this.bCollapsed = false;
	document.getElementById(this.opt.sImageId).style.display = '';
	return false;
}

// The function handling the swapping of the ticket log.
ActionLog.prototype.swap = function ()
{
	document.getElementById(this.opt.sImageId).src = this.opt.sImagesUrl + "/" + (this.bCollapsed ? this.opt.sImageCollapsed : this.opt.sImageExpanded);
	document.getElementById(this.opt.sContainerId).style.display = this.bCollapsed ? '' : 'none';
	document.getElementById(this.opt.sHeaderId).setAttribute('class', (this.bCollapsed ? 'title_bar grid_header' : 'title_bar'));

	this.bCollapsed = !this.bCollapsed;
}

function CustomFields(oOptions)
{
	this.opt = oOptions;
	this.bCollapsed = false;
}

// Expand and collapse the additional information block
CustomFields.prototype.infoswap = function ()
{
	document.getElementById(this.opt.sImageId).src = this.opt.sImagesUrl + "/" + (this.bCollapsed ? this.opt.sImageCollapsed : this.opt.sImageExpanded);
	document.getElementById(this.opt.sContainerId).style.display = this.bCollapsed ? '' : 'none';
	document.getElementById(this.opt.sFooterId).style.display = this.bCollapsed ? '' : 'none';
	document.getElementById(this.opt.sHeaderId).setAttribute('class', (this.bCollapsed ? 'title_bar grid_header' : 'title_bar'));

	this.bCollapsed = !this.bCollapsed;
}

/* AJAX assignment */
function AjaxAssign(oOptions)
{
	this.opt = oOptions;
	this.bCollapsed = true;

	// Insert the expand/collapse button
	document.getElementById(this.opt.sId).innerHTML = '<img src="' + this.opt.sImagesUrl + "/" + this.opt.sImageCollapsed + '" id="assign_' + this.opt.sSelf + '" class="shd_assign_button" onclick="' + this.opt.sSelf + '.click();">';
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
	var img = document.getElementById('assign_' + this.opt.sSelf);
	img.setAttribute('src', this.opt.sImagesUrl + "/" + this.opt.sImageExpanded);

	// Fetch the list of items
	shd_getJSONDocument.call(this, smf_prepareScriptUrl(this.opt.sScriptUrl) + 'action=helpdesk;sa=ajax;op=assign;ticket=' + this.opt.iTicketId + ';' + sSessV + '=' + sSessI, this.expand_callback);
}

AjaxAssign.prototype.expand_callback = function (oRecvd)
{
	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.members)
	{
		var assign_list = document.getElementById(this.opt.sListId);
		assign_list.innerHTML = '';
		assign_list.setAttribute('style', 'display:block');

		var newhtml = '';
		var cur = 0;
		for (var i in oRecvd.members)
		{
			if (!oRecvd.members.hasOwnProperty(i))
				continue;

			cur = oRecvd.members[i];
			newhtml += '<li class="shd_assignees" onclick="' + this.opt.sSelf + '.assign(' + cur.uid + ');">';

			if (cur.admin)
				newhtml += '<img src="' + smf_default_theme_url + '/images/simpledesk/' + (cur.admin == 'yes' ? 'admin' : 'staff') + '.png" alt="" class="shd_smallicon"> ';

			newhtml += cur.name + '</li>';
		}

		assign_list.innerHTML = newhtml;
	}
}

AjaxAssign.prototype.assign = function (uid)
{
	// Click handler for the assignment list, to issue the assign
	ajax_indicator(true);
	shd_getJSONDocument.call(this, smf_prepareScriptUrl(this.opt.sScriptUrl) + 'action=helpdesk;sa=ajax;op=assign2;ticket=' + this.opt.iTicketId + ';to_user=' + uid + ';' + sSessV + '=' + sSessI, this.assign_callback);
}

AjaxAssign.prototype.assign_callback = function(oRecvd)
{
	// Click handler callback for assignment, to handle once the request has been made
	this.collapse();

	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.assigned)
	{
		document.getElementById(this.opt.sAssignedSpan).innerHTML = oRecvd.assigned;
	}
}

AjaxAssign.prototype.collapse = function ()
{
	this.bCollapsed = true;
	var assign_list = document.getElementById(this.opt.sListId);
	assign_list.innerHTML = '';
	assign_list.setAttribute('style', 'display:none');

	var img = document.getElementById('assign_' + this.opt.sSelf);
	img.setAttribute('src', this.opt.sImagesUrl + "/" + this.opt.sImageCollapsed);
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
	var oLink = document.getElementById(this.opt.sLinkId);

	oLink.instanceRef = this;
	oLink.onclick = function (oEvent) {return this.instanceRef.receiveNotifications(oEvent);};

	document.getElementById(this.opt.sContainerId).style.display = "";
}

shd_notifications.prototype.receiveNotifications = function ()
{
	shd_getJSONDocument.call(this, smf_prepareScriptUrl(smf_scripturl) + "action=helpdesk;sa=ajax;op=notify;ticket=" + this.ticketId + ";" + this.opt.sSessionVar + '=' + this.opt.sSessionId + (this.opt.sPinglist ? ";" + this.opt.sPinglist : ''), this.onReceiveNotifications);
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

	document.getElementById("shd_notifications_div").innerHTML = newhtml;
}