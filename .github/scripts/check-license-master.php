<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2023 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1.0                                   *
* File Info: check-license-master.php                         *
**************************************************************/

// Stuff we will ignore.
$ignoreFiles = array(
	'\.github/',
	'/buildTools/',
);

$curDir = '.';
if (isset($_SERVER['argv'], $_SERVER['argv'][1]))
	$curDir = $_SERVER['argv'][1];

$foundBad = false;
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($curDir, FilesystemIterator::UNIX_PATHS)) as $currentFile => $fileInfo)
{
	// Only check PHP
	if ($fileInfo->getExtension() !== 'php')
		continue;

	foreach ($ignoreFiles as $if)
		if (preg_match('~' . $if . '~i', $currentFile))
			continue 2;

	$result = trim(shell_exec('php .github/scripts/check-license.php ' . $currentFile . ' 2>&1'));

	if (!preg_match('~Error:([^$]+)~', $result))
		continue;

	$foundBad = true;
	fwrite(STDERR, $result . "\n");
}

if (!empty($foundBad))
	exit(1);