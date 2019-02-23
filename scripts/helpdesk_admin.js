/* Javascript for the main Helpdesk Admin */

// Handle the JavaScript surrounding the admin center.
$(document).ready(function(){
	$('.shd_help').on('click', function(e) {
		e.preventDefault();
		return reqOverlayDiv(this.href);
	});

	/* If we have a submit with a save class, default the submitOnce check */
	$('input[type="submit"].save').parent('form').on('submit', function(){
		submitonce(this.currentTarget);
	});
	$('input[type="submit"].save').on('click', function(){
		submitThisOnce(this.currentTarget);
	});
});

function sd_AdminIndex(oOptions)
{
	this.opt = oOptions;

	$(document).ready(this.loadAdminIndex.bind(this));
}

sd_AdminIndex.prototype.loadAdminIndex = function ()
{
	// Load the text box containing the latest news items.
	if (this.opt.bLoadAnnouncements)
		this.setAnnouncements();

	// Load the current SMF and your SMF version numbers.
	if (this.opt.bLoadVersions)
		this.showCurrentVersion();

	// Load the text box that sais there's a new version available.
	if (this.opt.bLoadUpdateNotification)
		this.checkUpdateAvailable();

	// Totoal Tickets link.
	$('#' + this.opt.sTotalTicketsContainerId + ' a').on('click', this.TickekTotals.bind(this));
}

sd_AdminIndex.prototype.setAnnouncements = function ()
{
	if (!$('#sdAnnouncements').length)
		return;

	var sMessages = '';
	for (var i = 0; i < window.sdAnnouncements.length; i++)
		sMessages += this.opt.sAnnouncementMessageTemplate.replace('%href%', window.sdAnnouncements[i].href).replace('%subject%', window.sdAnnouncements[i].subject).replace('%time%', window.sdAnnouncements[i].time).replace('%message%', window.sdAnnouncements[i].message).replace('%author%', window.sdAnnouncements[i].author).replace('%readmore%', window.sdAnnouncements[i].href);

	$('#' + this.opt.sAnnouncementContainerId).html(this.opt.sAnnouncementTemplate.replace('%content%', sMessages));
}

sd_AdminIndex.prototype.showCurrentVersion = function ()
{
	if (!('sdVersion' in window))
		return;

	var oSdVersionContainer = $('#' + this.opt.sSdVersionContainerId);
	var oYourVersionContainer = $('#' + this.opt.sYourVersionContainerId);

	// Handle a developer version cleaner.
	oSdVersionContainer.html((this.opt.bDeveloperMode && 'sdDevVersion' in window) ? window.sdDevVersion : window.sdVersion)

	var sCurrentVersion = oYourVersionContainer.html();
	if (this.opt.bDeveloperMode && 'sdDevVersion' in window && sCurrentVersion != window.sdDevVersion)
		oYourVersionContainer.html(this.opt.sVersionOutdatedTemplate.replace('%currentVersion%', sCurrentVersion));
	else if (sCurrentVersion != window.sdVersion && !this.opt.bDeveloperMode)
		oYourVersionContainer.html(this.opt.sVersionOutdatedTemplate.replace('%currentVersion%', sCurrentVersion));
}

sd_AdminIndex.prototype.checkUpdateAvailable = function ()
{
	if (!('sdUpdatePackage' in window))
		return;

	// We don't handle developer mode stuff here, best to get any developer edition to a supported edition.
	var oContainer = $('#' + this.opt.sUpdateNotificationContainerId);

	// Are we setting a custom title and message?
	var sTitle = 'sdUpdateTitle' in window ? window.sdUpdateTitle : this.opt.sUpdateNotificationDefaultTitle;
	var sMessage = 'sdUpdateNotice' in window ? window.sdUpdateNotice : this.opt.sUpdateNotificationDefaultMessage;

	oContainer.html(this.opt.sUpdateNotificationTemplate.replace('%title%', sTitle).replace('%message%', sMessage).replace('%criticaltitle%', sTitle));

	// Parse in the package download URL if it exists in the string.
	$('#update-link').attr('href', this.opt.sUpdateNotificationLink.replace('%package%', window.sdUpdatePackage));

	if ('sdUpdateInformation' in window)
	{
		$('#information-link-span').css('display', 'block');
		$('#information-link').attr('href', this.opt.sUpdateInformationLink.replace('%information%', window.sdUpdateInformation));
	}

	// If we decide to override life into "red" mode, do it.
	if ('sdUpdateCritical' in window && window.sdUpdateCritical === true)
	{
		$('#update_container').removeClass().addClass('errorbox');
		$('#update_critical_title').show();
		$('#update_critical_alert').show();
		$('#update_title').hide();
	}

	$('#sd_update_section').show();
}

// Ticket number information...
sd_AdminIndex.prototype.TickekTotals = function ()
{
	$('#' + this.opt.sTotalTicketsInfoContainerID).toggle();
}

// Modified, SMF 2.0 ToggleItem
function shd_plugins(oOptions)
{
	this.opt = oOptions;

	$('#' + this.opt.sJSworkedID).val(1);
	$('.' + this.opt.sFeaturesSwitchClass + ' a').on('click', this.togglePlugin.bind(this));
	$(this.opt.oJSInstallablePlugins).each(this.setupPlugins.bind(this));
}

shd_plugins.prototype.setupPlugins = function (index, itemID)
{
	$('#' + this.opt.sJSFeatureClass.replace('%itemid%', itemID)).css('display', '');
	$('#' + this.opt.sJSPlainFeatureClass.replace('%itemid%', itemID)).css('display', 'none');
}

shd_plugins.prototype.togglePlugin = function (e)
{
	e.preventDefault();
	this.itemID = e.currentTarget.dataset.plugin;

	// Toggle the hidden item.
	this.oItemValueHandle = $('#' + this.opt.sFeatureClass.replace('%itemid%', itemID));
	this.bItemValue = this.oItemValueHandle.val() == '0' ? 1 : 0;

	// Change the image, alternative text and the title.
	$('#' + this.opt.sSwitchClass.replace('%itemid%', this.itemID)).attr('src', this.bItemValue === 1 ? this.opt.sPluginOnImg : this.opt.sPluginOffImg);
	$('#' + this.opt.sSwitchClass.replace('%itemid%', this.itemID)).attr('alt', this.bItemValue === 1 ? this.opt.sPluginOnText : this.opt.sPluginOffText);
	$('#' + this.opt.sSwitchClass.replace('%itemid%', this.itemID)).attr('title', this.bItemValue === 1 ? this.opt.sPluginOnText : this.opt.sPluginOffText);
	$('#' + this.opt.sFeatureClass.replace('%itemid%', this.itemID)).val(this.bItemValue);

	// Don't reload.
	return false;
}


/* Sort Custom Fields */
function shd_custom_field_order(oOptions)
{
	this.opt = oOptions;

	if (!this.opt.sFieldsContainer)
		this.opt.sFieldsContainer = 'custom_fields_list';
	if (!this.opt.sOptionsOrderClass)
		this.opt.sOptionsOrderClass = 'custom_field_order';
	if (!this.opt.sOptionsMoveDownClass)
		this.opt.sOptionsMoveDownClass = 'custom_field_move_down';
	if (!this.opt.sOptionsMoveUpClass)
		this.opt.sOptionsMoveUpClass = 'custom_field_move_up';
	if (!this.opt.aCustHTMLFields)
		this.opt.aCustHTMLFields = ['break_{KEY}', 'radio_{KEY}', 'multi_{KEY}', 'option_{KEY}', 'order_{KEY}'];

	this.currentOrder = [];
	this.newOrder = [];

	this.init();
	return false;
}

shd_custom_field_order.prototype.init = function ()
{
	var self = this;

	$(document).on('click', '#' + this.opt.sFieldsContainer + ' .' + this.opt.sOptionsMoveDownClass, function(e){
		e.preventDefault();
		var clickedKey = $(this).data('key');
		var clickedOrder = parseInt($('#order_' + clickedKey + ' input').val());
		self.move(clickedKey, clickedOrder, clickedOrder + 1);
	});
	$(document).on('click', '#' + this.opt.sFieldsContainer + ' .' + this.opt.sOptionsMoveUpClass, function(e){
		e.preventDefault();
		var clickedKey = $(this).data('key');
		var clickedOrder = parseInt($('#order_' + clickedKey + ' input').val());
		self.move(clickedKey, clickedOrder, clickedOrder - 1);
	});
}

shd_custom_field_order.prototype.cloneArray = function (arraySource)
{
	return arraySource.slice(0);
}

shd_custom_field_order.prototype.move = function (clickedKey, clickedOrder, movedOrder)
{
	var currentOrder = [];

	// Get our current Order items.
	var self = this;
	$('#' + this.opt.sFieldsContainer + ' .' + this.opt.sOptionsOrderClass + ' input').each(function() {
		currentOrder[$(this).val()] = $(this).data('key');

		// Capture the current input. attr is used here as data doesn't get retained.
		$('#option_' + $(this).data('key')).attr('data-value-input', $('#option_' + $(this).data('key')).val());
	});

	// Make sure it can go that way.
	if (
		(clickedOrder > movedOrder && movedOrder < 0) ||
		(clickedOrder < movedOrder && clickedOrder >= currentOrder.length - 1)
	)
		return;

	// Put this into the right place.
	newOrder = this.cloneArray(currentOrder);
	newOrder.splice(clickedOrder, 1);
	newOrder.splice(movedOrder, 0, clickedKey);

	// Build up the new HTML and move it.
	var newDiv = '';
	$(newOrder).each(function(order, key) {
		$(self.opt.aCustHTMLFields).each(function(order2, field) {
			newDiv += $('#' + field.replace('{KEY}', key)).prop('outerHTML');
		});
	});
	newDiv += '<span id="addopt"></span>';
	$('#' + this.opt.sFieldsContainer).html(newDiv);

	this.resort(newOrder);
}

shd_custom_field_order.prototype.resortNew = function ()
{
	var currentOrder = [];

	$('#' + this.opt.sFieldsContainer + ' .' + this.opt.sOptionsOrderClass + ' input').each(function() {
		currentOrder[$(this).val()] = $(this).data('key');

		// Capture the current input. attr is used here as data doesn't get retained.
		$('#option_' + $(this).data('key')).attr('data-value-input', $('#option_' + $(this).data('key')).val());
	});

	this.resort(currentOrder);
}

shd_custom_field_order.prototype.resort = function (currentOrder)
{
	// Find out the new orders.
	var firstField = typeof currentOrder[0] === 'undefined' ? 0 : currentOrder[0];
	var lastField = currentOrder[currentOrder.length - 1];

	// Go through each possible option and reorder it, you can't do this first since outerHTML doesn't contain the updated information.
	$(currentOrder).each(function(order, key) {
		$('#order_' + key + '_input').val(order);

		// First item, we hide the move up.
		if (firstField == key)
			$('#order_' + key + ' a.custom_field_move_up').hide();
		else
			$('#order_' + key + ' a.custom_field_move_up').show();

		// Last item we hide the move down.
		if (lastField == key)
			$('#order_' + key + ' a.custom_field_move_down').hide();
		else
			$('#order_' + key + ' a.custom_field_move_down').show();

		// Capture the current input.
		if ($('#option_' + key).data('value-input'))
			$('#option_' + key).val($('#option_' + key).attr('data-value-input'));
	});
}

/* Reattribute Posts */
function shd_AttributeValidate(oOptions)
{
	this.opt = oOptions;

	this.init();
}

/* Reattribute Posts: Bind the events */
shd_AttributeValidate.prototype.init = function ()
{
	/* Changing the radio */
	$('#' + this.opt.sTypeEmailContainerId + ', #' + this.opt.sTypeStarterContainerId + ', #' + this.opt.sTypeFromContainerId).change(this.validator.bind(this));

	/* Clicking into a field, special as we update the radio */
	$('#' + this.opt.sEmailContainerId + ', #' + this.opt.sStarterContainerId + ', #' + this.opt.sFromContainerId + ', #' + this.opt.sToContainerId).focus(this.focusValidator.bind(this));

	/* After typing a key */
	$('#' + this.opt.sEmailContainerId + ', #' + this.opt.sStarterContainerId + ', #' + this.opt.sFromContainerId + ', #' + this.opt.sToContainerId).keyup(this.validator.bind(this));
}

/* Reattribute Posts: Does a radio change and processes the validator */
shd_AttributeValidate.prototype.focusValidator = function (e)
{
	if (e.currentTarget.id == this.opt.sEmailContainerId)
		$('#' + this.opt.sTypeEmailContainerId).prop('checked', true);
	else if (e.currentTarget.id == this.opt.sStarterContainerId)
		$('#' + this.opt.sTypeStarterContainerId).prop('checked', true);
	else if (e.currentTarget.id == this.opt.sFromContainerId)
		$('#' + this.opt.sTypeFromContainerId).prop('checked', true);

	this.validator();
}

/* Reattribute Posts: Validate if we can start the process to reattribute */
shd_AttributeValidate.prototype.validator = function ()
{
	this.origText = this.opt.sOrigText;
	this.origTextStarter = this.opt.sOrigTextStarter;
	this.valid = true;

	// Do all the fields!
	if (!$('#' + this.opt.sToContainerId).val())
		this.valid = false;

	warningMessage = this.origText.replace(/%member_to%/, $('#' + this.opt.sToContainerId).value);

	if ($('#' + this.opt.sTypeEmailContainerId).is(":checked"))
	{
		$('#' + this.opt.sStarterContainerId + ', #' + this.opt.sFromContainerId).val("");
			this.valid = $('#' + this.opt.sEmailContainerId).val() != '';
		warningMessage = warningMessage.replace(/%type%/, this.opt.sEmailConfirmText).replace(/%find%/, $('#' + this.opt.sEmailContainerId).val());
	}
	else if ($('#' + this.opt.sTypeStarterContainerId).is(":checked"))
	{
		$('#' + this.opt.sEmailContainerId + ' #' + this.opt.sFromContainerId).val("");

			this.valid = $('#' + this.opt.sStarterContainerId).val() != '';
		warningMessage = this.origTextStarter.replace(/%member_to%/, $('#' + this.opt.sToContainerId).val()).replace(/%find%/, $('#' + this.opt.sStarterContainerId).val());			
	}
	else
	{
		$('#' + this.opt.sEmailContainerId + ' #' + this.opt.sStarterContainerId).val("");

		this.valid = $('#' + this.opt.sFromContainerId).val() != '';
		warningMessage = warningMessage.replace(/%type%/, this.opt.sFromConfirmText).replace(/%find%/, $('#' + this.opt.sFromContainerId).val());
	}

	$('#' + this.opt.sDoAttributeContainerId).prop("disabled", this.valid ? false : true);
}

/* Roles Management */
function shd_role(oOptions)
{
	this.opt = oOptions;

	this.init();
}

/* Roles Management: Bind the events */
shd_role.prototype.init = function ()
{
	/* When they change a permission, change the icon */
	this.iconInit();

	this.toggleBlockInt();
}

/* Roles Management: Bind the events */
shd_role.prototype.iconInit = function ()
{
	this.iconSelector = {
		disallow: this.opt.sPermissionDisallowClass,
		allow: this.opt.sPermissionAllowClass,
		allow_own: this.opt.sPermissionAllowOwnClass,
		allow_any: this.opt.sPermissionAllowAnyClass
	};

	$('dl.permsettings dd select[id*="perm_"]').on('change', this.icon.bind(this));
}

/* Roles Management: Handle changing the icon */
shd_role.prototype.icon = function (e)
{
	$('#' + e.currentTarget.id + '_icon').attr('class', this.iconSelector[e.currentTarget.value] ? this.iconSelector[e.currentTarget.value] : '');
}

shd_role.prototype.toggleBlockInt = function ()
{
	$(this.opt.oHiddenBlocks).each(this.toggleBlock.bind(this));

	$('div.cat_bar h3.catbg a').on('click', this.toggleBlock.bind(this));
	$('input#' + this.opt.sDeleteContainerId).on('click', this.formConfirm.bind(this))
}

shd_role.prototype.toggleBlock = function (e, block)
{
	if (typeof e.currentTarget !== 'undefined')
	{
		e.preventDefault();
		block = e.currentTarget.dataset.block;
	}

	if ($('#' + this.opt.sBlockHeader.replace('%block%', block)).hasClass('cat_collapsed'))
	{
		$('#' + this.opt.sBlockHeader.replace('%block%', block)).attr('class', 'cat_bar');
		$('#' + this.opt.sBlockContent.replace('%block%', block)).css('display', '');
		$('#' + this.opt.sBlockFooter.replace('%block%', block)).css('display', '');
		$('#' + this.opt.sBlockIcon.replace('%block%', block)).attr('src', this.opt.sBlockIconExpandedImg);
	}
	else
	{
		$('#' + this.opt.sBlockHeader.replace('%block%', block)).attr('class', 'cat_bar cat_collapsed');
		$('#' + this.opt.sBlockContent.replace('%block%', block)).css('display', 'none');
		$('#' + this.opt.sBlockFooter.replace('%block%', block)).css('display', 'none');
		$('#' + this.opt.sBlockIcon.replace('%block%', block)).attr('src', this.opt.sBlockIconCollapsedImg);
	}

	$('#' + this.opt.sBlockIcon.replace('%block%', block)).css('display', '');
}

shd_role.prototype.formConfirm = function (e)
{
	return confirm(this.opt.sDeleteConfirmText);
}

/* The Canned Replies Admin Handler */
function shd_cannedReplies(oOpts)
{
	this.opt = oOpts; // attaches to the link, but it doesn't exist until after DOM is loaded!
	$(document).ready(this.init.bind(this));

	// Build our URL.
	this.opt.sUrl = this.opt.sUrlBase +
		';' + this.opt.sSessionVar + '=' + this.opt.sSessionId;

console.log('shd_cannedReplies:', this.opt.sUrl);
}

shd_cannedReplies.prototype.init = function ()
{
	$('#' + this.opt.sPreviewButtonID).on('click', this.action.bind(this));
}

shd_cannedReplies.prototype.action = function (e)
{
	e.preventDefault();

	// Get SC Editor stuff setup.
	var scEditorBox = $('#' + this.opt.sBodyID).get(0);

	// Find the body.
	var body = '';
	if (sceditor.instance(scEditorBox) != undefined && typeof sceditor.instance(scEditorBox).getText().html !== 'undefined')
		body = sceditor.instance(scEditorBox).getText().html();
	else if (sceditor.instance(scEditorBox) != undefined)
		body = sceditor.instance(scEditorBox).getText();
	else
		body = $('#' + this.opt.sBodyID).val();

	// Send this off.
	shd_sendJSONDocument(this.opt.sUrl, {
		reply: this.opt.sReply,
		cat: this.opt.iCat,
		title: $('#' + this.opt.sTitleID).val(),
		shd_canned_reply: body,
	}, this.callback.bind(this));
	return false;
}

shd_cannedReplies.prototype.callback = function (oRecvd)
{
	if (oRecvd && oRecvd.success === false)
		alert(oRecvd.error);
	else if (oRecvd && oRecvd.preview)
	{
		$('#' + this.opt.sPreviewBoxID).show();
		$('#' + this.opt.sPreviewResponseID).html(oRecvd.preview);
	}

	return false;
}
