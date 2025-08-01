<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2025 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* File Info: build.php                                        *
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

// Set our version file.
$updated_version = false;
if (empty($args['ignore-version']))
{
	$version_file = $args['src'] . '/sd_source/Subs-SimpleDesk.php';
	if (!file_exists($version_file) && empty($args['ignore-version']))
		die('Version file does not exist');
	$contents = file_get_contents($version_file);
	
	if (preg_match('~define\(\'SHD_VERSION\',\s+\'' . preg_quote($version) . '\'\);~i', $contents) == 1)
	{
		$new_contents = preg_replace('~define\(\'SHD_VERSION\',\s+\'([^\']+)\'\);~i', 'define(\'SHD_VERSION\', \'SimpleDesk ' . $version . '\');', $contents);
		if (is_null($new_contents) && empty($args['ignore-version']))
			die('Error occured changing the version');
		if (md5($contents) === md5($new_contents) && empty($args['ignore-version']))
			die('Replacement failed, no changes made');
		$updated_version = file_put_contents($version_file, $new_contents);
	}
	else
		$updated_version = true;
}

// Find all files modified since our last tag.
if (empty($args['skip-updates']))
{
	if (empty($args['tag']))
		$git_tag = trim(shell_exec($git_path . ' describe --abbrev=0 --tags'));
	else
		$git_tag = $args['tag'];
 
	if (empty($git_tag))
		die('Unable to locate a previous tag');
	
	$commits = shell_exec($git_path . ' rev-list HEAD..' . escapeshellcmd($git_tag) . ' --objects');

	if (empty($commits))
		die('No commits found');

	preg_match_all('~\w{40}\s([^\s]+)$~im', $commits, $matches);

	$files = array_filter(array_unique($matches[1]), function ($file) {
		return substr($file, -3) === 'php';
	});
	sort($files);

	if ($updated_version)
		$files[] = 'sd_source/Subs-SimpleDesk.php';

	foreach($files as $file)
	{
		// * SimpleDesk Version: 2.1.0                                   *
		$oc = file_get_contents($args['src'] . '/' . $file);
		$nc = preg_replace_callback('~\*\ SimpleDesk Version: ([^\*]+)\*~i', function($m) use ($version) {
			return '* SimpleDesk Version: ' . str_pad($version, 40) . '*';
		}, $oc);

		$nc = preg_replace('~Copyright (\d+) - SimpleDesk\.net~i', 'Copyright ' . date('Y') . ' - SimpleDesk.net', $nc);

		if (is_null($nc))
			die('Error Updating file');

		file_put_contents($args['src'] . '/' . $file, $nc);
	}
} 

// Build baby, build!

if (file_exists($args['dst'] . '/SimpleDesk_' . $version . '.tgz'))
	unlink($args['dst'] . '/SimpleDesk_' . $version . '.tgz');
shell_exec($tar_path . ' --no-xattrs --no-acls' . (PHP_OS_FAMILY === 'Darwin' ? ' --no-mac-metadata --no-fflags' : '') .' --exclude=\'.git\' --exclude=\'.*\'  --exclude=\'install-testdata.php\' --exclude=\'error_log\' --exclude=\'buildTools\' --exclude=\'node_modules\' -czf ' . $args['dst'] . '/' . $package_file_base . '.tgz *');

// Zip it, zip it good.
if (file_exists($args['dst'] . '/SimpleDesk_' . $version . '.zip'))
	unlink($args['dst'] . '/SimpleDesk_' . $version . '.zip');
shell_exec($zip_path . ' -x ".git" ".*/" "install-testdata.php" "error_log" "buildTools/*"  "node_modules.*"  -1 ' . $args['dst'] . '/' . $package_file_base . '.zip -r *');

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
		elseif (preg_match('~^--tag=(.+)$~', $arg, $match) != 0)
			$args['tag'] = substr($match[1], -1) == '/' ? substr($match[1], 0, -1) : $match[1];
		elseif (preg_match('~^--(debug|ignore-version|skip-updates)$~', $arg, $match) != 0)
			$args[$match[1]] = true;
		elseif ($arg == '--help')
		{
			echo 'Build Tool
Usage: /path/to/php ' . realpath(__FILE__) . ' -- [OPTION]...
    --src               	Path to SD (' . realpath($_SERVER['PWD']) . ').
    --dst            		Output directory for files (/tmp).
    --skip-pull				Does not force a pull.
    --ignore-version		Do not update version file.
    --debug                 Output debugging information.';
    		die;
		}

		if (empty($args['src']))
			$args['src'] = realpath($_SERVER['PWD']) . '/';
		if (empty($args['dst']))
			$args['dst'] = realpath('/tmp');

		// We have extra params.
		if (preg_match('~^--(.+)=(.+)$~', $arg, $match) != 0 && !array_key_exists($match[1], $_POST))
			$_POST[$match[1]] = $match[2];
	}
}
