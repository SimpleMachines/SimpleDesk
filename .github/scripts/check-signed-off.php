<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2022 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1.0                                   *
* File Info: check-signed-off.php                             *
**************************************************************/

// Debug stuff.
global $debugMsgs, $debugMode;

// Debug?
if (isset($_SERVER['argv'], $_SERVER['argv'][2]) && $_SERVER['argv'][2] == 'debug')
	$debugMode = true;

// First, lets do a basic test.  This is non GPG signed commits.
$signedoff = find_signed_off();

// Now Try to test for the GPG if we don't have a message.
if (empty($signedoff))
	$signedoff = find_gpg();

// Nothing yet?  Lets ask your parents.
if (empty($signedoff) && isset($_SERVER['argv'], $_SERVER['argv'][1]) && ($_SERVER['argv'][1] == 'travis' || $_SERVER['argv'][1] == 'github'))
	$signedoff = find_signed_off_parents();

// Nothing?  Well darn.
if (empty($signedoff))
{
	// Debugging, eh?
	if ($debugMode)
	{
		echo "\n---DEBUG MSGS START ---\n";
		var_dump($debugMsgs);
		echo "\n---DEBUG MSGS END ---\n";
	}

	fatalError('Error: Signed-off-by not found in commit message' . "\n");
}
elseif ($debugMode)
	debugPrint('Valid signed off found' . "\n");

// Find a commit by Signed Off
function find_signed_off($commit = 'HEAD', $childs = array(), $level = 0)
{
	global $debugMsgs;

	$commit = trim($commit);

	// Where we are at.
	debugPrint('Attempting to Find signed off on commit [' . $commit . ']');

	// To many recrusions here.
	if ($level > 10)
	{
		$debugMsgs[$commit . ':' . time()] = array('error' => 'Recurision limit');
		debugPrint('Recusion limit exceeded on find_signed_off');
		return false;
	}

	// What string tests should we look for?
	$stringTests = array('Signed-off-by:', 'Signed by');

	// Get message data and clean it up, should only need the last line.
	$message = trim(shell_exec('git show -s --format=%B ' . $commit));
	$lines = explode("\n", trim(str_replace("\r", "\n", $message)));
	$lastLine = $lines[count($lines) - 1];

	// Debug info.
	debugPrint('Testing Line [' . $lastLine . ']');

	// loop through each test and find one.
	$testedString = $result = false;
	foreach ($stringTests as $testedString)
	{
		debugPrint('Testing [' . $testedString . ']');

		$result = stripos($lastLine, $testedString);

		// We got a result.
		if ($result !== false)
		{
			debugPrint('Found Result [' . $testedString . ']');
			break;
		}
	}

	// Debugger.
	$debugMsgs[$commit . ':' . time()] = array(
		// Raw body.
		'B' => shell_exec('git show -s --format=%B ' . $commit),
		// Body.
		'b2' => shell_exec('git show -s --format=%b ' . $commit),
		// Commit notes.
		'N' => shell_exec('git show -s --format=%N ' . $commit),
		// Ref names.
		'd' => shell_exec('git show -s --format=%d ' . $commit),
		// Commit hash.
		'H' => shell_exec('git show -s --format=%H ' . $commit),
		// Tree hash.
		'T' => shell_exec('git show -s --format=%T ' . $commit),
		// Parent hash.
		'P' => shell_exec('git show -s --format=%P ' . $commit),
		// Result.
		'result' => $result,
		// Last tested string, or the correct string.
		'testedString' => $testedString,
	);

	// No result and found a merge? Lets go deeper.
	if ($result === false && preg_match('~Merge ([A-Za-z0-9]{40}) into ([A-Za-z0-9]{40})~i', $lastLine, $merges))
	{
		debugPrint('Found Merge, attempting to get more parent commit: ' . $merges[1]);

		return find_signed_off($merges[1], array_merge(array($merges[1]), $childs), ++$level);
	}

	return $result !== false;
}

// Find a commit by GPG
function find_gpg($commit = 'HEAD')
{
	global $debugMsgs;

	$commit = trim($commit);

	debugPrint('Attempting to Find GPG on commit [' . $commit . ']');

	// Get verify commit data.
	$message = trim(shell_exec('git verify-commit ' . $commit . ' -v --raw'));

	// Should we actually test for gpg results?  Perhaps, but it seems doing that with travis may fail since it has no way to verify a GPG signature from GitHub.  GitHub should have prevented a bad GPG from making a commit to a authors repository and could be trusted in most cases it seems.
	$result = strlen($message) > 0;

	// Debugger.
	$debugMsgs[$commit . ':' . time()] = array(
		// Raw body.
		'verify-commit' => shell_exec('git verify-commit ' . $commit . ' -v --raw'),
		// Result.
		'result' => $result,
		// Last tested string, or the correct string.
		'message' => $message,
	);

	return $result;
}

// Looks at all the parents, and tries to find a signed off by somewhere.
function find_signed_off_parents($commit = 'HEAD')
{
	$commit = trim($commit);

	debugPrint('Attempting to find parents on commit [' . $commit . ']');

	$parentsRaw = shell_exec('git show -s --format=%P ' . $commit);
	$parents = explode(' ', $parentsRaw);

	// Test each one.
	foreach ($parents as $p)
	{
		$p = trim($p);
		debugPrint('Testing Parent for signed off [' . $commit . ']');

		// Basic tests.
		$test = find_signed_off($p);

		// No, maybe it has a GPG parent.
		if (empty($test))
			$test = find_gpg($p);

		if (!empty($test))
			return $test;
	}

	// Lucked out.
	return false;
}

// Print a debug line
function debugPrint($msg)
{
	global $debugMode;

	if ($debugMode)
		echo "\nDEBUG: ", $msg;
}

function fatalError($msg)
{
	fwrite(STDERR, $msg . "\n");
	die;
}