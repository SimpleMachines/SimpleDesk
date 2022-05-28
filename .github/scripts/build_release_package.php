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
* File Info: build_release_package                            *
**************************************************************/

// The path such as /usr/bin/git
$git_path = '/usr/bin/git';

// The path to tar & zip
$tar_path = '/usr/bin/tar';
$zip_path = '/usr/bin/zip';

/***************************************/
/***** END OF CONFIGURATION CHANGES ****/

global $args;
parseArgs();

// Debugging?
if (isset($_SERVER['USER'], $args) && !empty($args['debug']))
	error_reporting(E_ALL);

if (empty($args) || empty($args['src']) || empty($args['dst']))
	die('missing critical settings');

// Get in the trunk.
chdir($args['src']);

if (!empty($args['skip-pull']))
{
	$out = shell_exec($git_path . ' pull');

	// No comprenda senior.
	if (strpos($out, 'From git://github.com') === false && strpos($out, 'Already up-to-date.') === false)
		die('GIT build returned an unexpected output: ' . $out);
}

// Try to find our version.
$pkg_file = file_get_contents('package-info.xml');
preg_match('~<version>([^<]+)</version>~i', $pkg_file, $v);

if (empty($v))
	die('Unknown Version');

$version = strtr(
	ucFirst(trim($v[1])),
	array(
		' ' => '-',
		'Rc' => 'RC',
	)
);

$package_file_base = 'SimpleDesk-' . $version;

// Build baby, build!

if (file_exists($args['dst'] . '/SimpleDesk_' . $version . '.tgz'))
	unlink($args['dst'] . '/SimpleDesk_' . $version . '.tgz');
shell_exec($tar_path . ' --no-xattrs --no-acls --no-mac-metadata --no-fflags --exclude=\'.git\' --exclude=\'install-testdata.php\' --exclude=\'error_log\' --exclude=\'.gitignore\' --exclude=\'.gitattributes\' --exclude=\'.travis.yml\' --exclude=\'buildTools\' --exclude=\'node_modules\' --exclude=\'.DS_Store\' -czf ' . $args['dst'] . '/' . $package_file_base . '.tgz *');

// Zip it, zip it good.
if (file_exists($args['dst'] . '/SimpleDesk_' . $version . '.zip'))
	unlink($args['dst'] . '/SimpleDesk_' . $version . '.zip');
shell_exec($zip_path . ' --exclude=\'.git\' --exclude=\'install-testdata.php\' --exclude=\'error_log\' --exclude=\'.gitignore\' --exclude=\'.gitattributes\' --exclude=\'.travis.yml\' --exclude=\'buildTools/*\' --exclude=\'node_modules/*\' --exclude=\'*' . '/.DS_Store\' -1 ' . $args['dst'] . '/' . $package_file_base . '.zip -r *');

// Undo the damage we did to the package file
shell_exec($git_path . ' checkout -- package-info.xml');

// FINALLY, we are done.
exit;

function parseArgs()
{
	global $args;

	if (!isset($_SERVER['argv']))
		$_SERVER['argv'] = array();

	// If its empty, force help.
	if (empty($_SERVER['argv'][1]))
		$_SERVER['argv'][1] = '--help';

	// Lets get the path_to and path_from
	foreach ($_SERVER['argv'] as $i => $arg)
	{
		// Trim spaces.
		$arg = trim($arg);

		if (preg_match('~^--src=(.+)$~', $arg, $match) != 0)
			$args['src'] = substr($match[1], -1) == '/' ? substr($match[1], 0, -1) : $match[1];
		elseif (preg_match('~^--dst=(.+)$~', $arg, $match) != 0)
			$args['dst'] = substr($match[1], -1) == '/' ? substr($match[1], 0, -1) : $match[1];
		elseif ($arg == '--debug')
			$args['debug'] = 1;
		elseif ($arg == '--help')
		{
			echo 'Build Tool
Usage: /path/to/php ' . realpath(__FILE__) . ' -- [OPTION]...

    --src               	Path to SD (' . realpath($_SERVER['PWD']) . ').
    --dst            		Output directory for files (' . realpath($_SERVER['PWD'] . '/..') . ')
    --debug                 Output debugging information.';
    		die;
		}

		if (empty($args['src']))
			$args['src'] = realpath($_SERVER['PWD']);
		if (empty($args['dst']))
			$args['dst'] = realpath($args['src'] . '/..');

		// We have extra params.
		if (preg_match('~^--(.+)=(.+)$~', $arg, $match) != 0 && !array_key_exists($match[1], $_POST))
			$_POST[$match[1]] = $match[2];
	}
}