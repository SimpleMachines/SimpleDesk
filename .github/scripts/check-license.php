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
* SimpleDesk Version: 2.1 Beta 1                              *
* File Info: check-license.php                                *
**************************************************************/

// Stuff we will ignore.
$ignoreFiles = array(
	// Index files.
	'\./images/[A-Za-z0-9_]+/index\.php',
	'\./images/simpledesk/[A-Za-z0-9_]+/index\.php',
	'\./sd_language/index\.php',
	'\./sd_plugins_lang/index\.php',
	'\./sd_plugins_source/index\.php',
	'\./sd_plugins_source/[A-Za-z0-9]+/index\.php',
	'\./sd_plugins_template/index\.php',
	'\./sd_source/index\.php',
	'\./sd_template/index\.php',

	// Templates.
	'./sd_template/SimpleDesk\.template\.php',
	'./sd_template/SimpleDesk-[A-Za-z0-9]+\.template\.php',
	'./sd_plugins_template/[A-Za-z0-9]+\.template\.php',
);

$ignoreFilesVersion = array(
	'/.github/scripts/check-[A-Za-z0-9-_]+\.php',
);

// No file? Thats bad.
if (!isset($_SERVER['argv'], $_SERVER['argv'][1]))
	die('Error: No File specified' . "\n");

// The file has to exist.
$currentFile = $_SERVER['argv'][1];
if (!file_exists($currentFile))
	die('Error: File does not exist' . "\n");

// Is this ignored?
foreach ($ignoreFiles as $if)
	if (preg_match('~' . $if . '~i', $currentFile))
		die;

// Lets get the Subs-SimpleDesk.php for SHD_VERSION.
//define('SHD_VERSION', 'SimpleDesk 2.1 Beta 1');
$indexFile = fopen('./sd_source/Subs-SimpleDesk.php', 'r');

// Error?
if ($indexFile === false)
	die("Error: Unable to open file ./sd_source/Subs-SimpleDesk.php\n");

$indexContents = fread($indexFile, 3850);

if (!preg_match('~define\(\'SHD_VERSION\', \'SimpleDesk ([^\']+)\'\);~i', $indexContents, $versionResults))
	die('Error: Could not locate SHD_VERSION' . "\n");
$currentVersion = $versionResults[1];

$currentSoftwareYear = (int) date('Y', time());
$file = fopen($currentFile, 'r');

// Error?
if ($file === false)
	die('Error: Unable to open file ' . $currentFile . "\n");

$contents = fread($file, 1300);

// How the license file should look, in a regex type format.
$match = array(
	0 =>	'/\*{62}' . '[\r]?\n',
	1 =>	'\* {10}Simple Desk Project - www.simpledesk.net {11}\*' . '[\r]?\n',
	2 =>	'\*{63}' . '[\r]?\n',
	3 =>	'\* {7}An advanced help desk modification built on SMF {7}\*' . '[\r]?\n',
	4 =>	'\*{63}' . '[\r]?\n',
	5 =>	'\* {61}\*' . '[\r]?\n',
	6 =>	'\* {9}\* Copyright \d{4} - SimpleDesk.net {19}\*' . '[\r]?\n',
	7 =>	'\* {61}\*' . '[\r]?\n',
	8 =>	'\* {3}This file and its contents are subject to the license {5}\*' . '[\r]?\n',
	9 =>	'\* {3}included with this distribution, license.txt, which {7}\*' . '[\r]?\n',
	10 =>	'\* {3}states that this software is New BSD Licensed. {12}\*' . '[\r]?\n',
	11 =>	'\* {3}Any questions, please contact SimpleDesk.net {14}\*' . '[\r]?\n',
	12 =>	'\* {61}\*' . '[\r]?\n',
	13 =>	'\*{63}' . '[\r]?\n',
	14 =>	'\* SimpleDesk Version: [^\*]+\*' . '[\r]?\n',
//	14 =>	'# SimpleDesk Version: ' . $currentVersion . ' {' . ($sd_version_whitespace - strlen($currentVersion)) . '}#' . '[\r]?\n',
	15 =>	'\* File Info: [^\*]+\*' . '[\r]?\n',
//	15 =>	'# File Info: ' . $shortCurrentFile . ' {' . ($sd_file_whitespace - strlen($shortCurrentFile)) . '}#' . '[\r]?\n',
	16 =>	'\*{62}/' . '[\r]?\n',
);

// Just see if the license is there.
if (!preg_match('~' . implode('', $match) . '~i', $contents))
	die('Error: License File is invalid or not found in ' . $currentFile . "\n");

// Check the year is correct.
$yearMatch = $match;
$yearMatch[6] = '\* {9}\* Copyright ' . $currentSoftwareYear . ' - SimpleDesk.net {19}\*' . '[\r]?\n';
if (!preg_match('~' . implode('', $yearMatch) . '~i', $contents))
	die('Error: The software year is incorrect in ' . $currentFile . "\n");

// Check the version is correct.
$versionMatch = $match;
$sd_version_whitespace = 40;
$versionMatch[14] = '\* SimpleDesk Version: ' . $currentVersion . ' {' . ($sd_version_whitespace - strlen($currentVersion)) . '}\*' . '[\r]?\n';
if (!preg_match('~' . implode('', $versionMatch) . '~i', $contents))
{
	$badVersion = true;
	foreach ($ignoreFilesVersion as $if)
		if (preg_match('~' . $if . '~i', $currentFile))
			$badVersion = false;

	if ($badVersion)
		die('Error: The version is incorrect in ' . $currentFile . "\n");
}

die('Stop here' . "\n");

$fileinfoMatch = $match;
$shortCurrentFile = basename($currentFile);
$sd_file_whitespace = 49;
$fileinfoMatch[15] = '# File Info: ' . $shortCurrentFile . ' {' . ($sd_file_whitespace - strlen($shortCurrentFile)) . '}#' . '[\r]?\n';
if (!preg_match('~' . implode('', $fileinfoMatch) . '~i', $contents))
	die('Error: The file info is incorrect in ' . $currentFile . "\n");