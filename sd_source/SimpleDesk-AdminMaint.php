<?php
###############################################################
#         Simple Desk Project - www.simpledesk.net            #
###############################################################
#       An advanced help desk modifcation built on SMF        #
###############################################################
#                                                             #
#         * Copyright 2010 - SimpleDesk.net                   #
#                                                             #
#   This file and its contents are subject to the license     #
#   included with this distribution, license.txt, which       #
#   states that this software is New BSD Licensed.            #
#   Any questions, please contact SimpleDesk.net              #
#                                                             #
###############################################################
# SimpleDesk Version: 1.0 Felidae                             #
# File Info: SimpleDesk-AdminMaint.php / 1.0 Felidae          #
###############################################################

/**
 *	This file handles the core of SimpleDesk's administrative maintenance.
 *
 *	@package source
 *	@since 1.1
*/
if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	The start point for maintenance.
 *
 *	We're directed here from the main administration centre, after permission checks and a few dependencies loaded.
 *
 *	@since 1.1
*/
function shd_admin_maint()
{
	global $context, $txt, $db_show_debug;

	// Right, if we're here, we really, really need to turn this off. Because anything we do from this page onwards hurts the log badly.
	$db_show_debug = false;

	loadTemplate('sd_template/SimpleDesk-AdminMaint');
	loadTemplate(false, array('admin', 'helpdesk_admin'));
	loadLanguage('ManageMaintenance');

	$subactions = array(
		'main' => 'shd_admin_maint_home',
		'findrepair' => 'shd_admin_maint_findrepair',
	);

	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subactions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'main';
	$subactions[$_REQUEST['sa']]();
}

function shd_admin_maint_home()
{
	global $context, $txt;

	$context['sub_template'] = 'shd_admin_maint_home';
	$context['page_title'] = $txt['shd_admin_maint'];
}

function shd_admin_maint_findrepair()
{
	global $context, $txt;
	checkSession('request');

	$context['page_title'] = $txt['shd_admin_maint_findrepair'];

	$context['maint_steps'] = array();
	$context['maint_steps'] = array(
		array(
			'name' => 'zero_entries',
			'pc' => 5,
		),
		array(
			'name' => 'clean_cache',
			'pc' => 10,
		),
	);

	if (isset($_GET['done']))
	{
		$context['sub_template'] = 'shd_admin_maint_findrepairdone';
		$context['maintenance_result'] = !empty($_SESSION['shd_maint']) ? $_SESSION['shd_maint'] : array();
		unset($_SESSION['shd_maint']);
		return;
	}

	$context['step'] = isset($_REQUEST['step']) ? (int) $_REQUEST['step'] : 0;
	if (!isset($context['maint_steps'][$context['step']]))
		$context['step'] = 0;

	$context['continue_countdown'] = 3;
	$context['continue_get_data'] = '?action=admin;area=helpdesk_maint;sa=findrepair;' . $context['session_var'] . '=' . $context['session_id'];
	$context['continue_post_data'] = '';
	$context['sub_template'] = 'not_done';

	$context['continue_percent'] = 0;
	for ($i = 0; $i <= $context['step']; $i++)
		$context['continue_percent'] += $context['maint_steps'][$i]['pc'];

	$function = 'shd_maint_' . $context['maint_steps'][$context['step']]['name'];
	$function();
}

function shd_maint_zero_entries()
{
	global $context, $smcFunc;

	// Check for tickets with id-ticket of 0.
	$query = $smcFunc['db_query']('', '
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_tickets
		WHERE id_ticket = 0');
	list($tickets) = $smcFunc['db_fetch_row']($query);
	if (!empty($tickets))
	{
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_tickets
			SET id_ticket = NULL
			WHERE id_ticket = 0');
		$_SESSION['shd_maint']['zero_tickets'] = $smcFunc['db_affected_rows']();
	}

	// And ticket replies with an id-msg 0
	$query = $smcFunc['db_query']('', '
		SELECT COUNT(*)
		FROM {db_prefix}helpdesk_ticket_replies
		WHERE id_msg = 0');
	list($msgs) = $smcFunc['db_fetch_row']($query);
	if (!empty($msgs))
	{
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}helpdesk_ticket_replies
			SET id_msg = NULL
			WHERE id_msg = 0');
		$_SESSION['shd_maint']['zero_msgs'] = $smcFunc['db_affected_rows']();
	}

	// This is a short operation, no suboperation, so just tell it to go onto the next step.
	$context['continue_post_data'] .= '<input type="hidden" name="step" value="' . ($context['step'] + 1) . '" />';
}

function shd_maint_clean_cache()
{
	global $context;

	// Make sure all SimpleDesk cache items are forcibly flushed.
	clean_cache('shd');

	// Normally, we'd update $context['continue_post_data'] to indicate our next port of call. But here, we don't have to.
	redirectexit('action=admin;area=helpdesk_maint;sa=findrepair;done;' . $context['session_var'] . '=' . $context['session_id']);
}

?>