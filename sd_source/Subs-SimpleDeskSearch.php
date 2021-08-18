<?php
/**************************************************************
*          Simple Desk Project - www.simpledesk.net           *
***************************************************************
*       An advanced help desk modification built on SMF       *
***************************************************************
*                                                             *
*         * Copyright 2021 - SimpleDesk.net                   *
*                                                             *
*   This file and its contents are subject to the license     *
*   included with this distribution, license.txt, which       *
*   states that this software is New BSD Licensed.            *
*   Any questions, please contact SimpleDesk.net              *
*                                                             *
***************************************************************
* SimpleDesk Version: 2.1 RC1                                 *
* File Info: Subs-SimpleDeskSearch.php                        *
**************************************************************/

/**
 *	This file handles the backbone of searches, such as the tokeniser and manages getting the tables actually maintained.
 *
 *	@package source
 *	@since 2.0
*/

if (!defined('SMF'))
	die('Hacking attempt...');

/**
 *	Identify and return the character set parameters for searching.
 *
 *	@return array An array of two items, the overall character set currently in use and the list of characters to be permitted in searches in the form of a regular expression character class.
 *	@see shd_return_exclude_regex()
*/
function shd_search_charset()
{
	global $context, $modSettings, $txt;

	$charset = !empty($txt['lang_character_set']) ? $txt['lang_character_set'] : 'UTF-8';

	if (empty($modSettings['shd_search_charset']))
		$modSettings['shd_search_charset'] = '0..9, A..Z, a..z, &, ~';

	$modSettings['shd_search_min_size'] = !empty($modSettings['shd_search_min_size']) ? $modSettings['shd_search_min_size'] : 3;
	$modSettings['shd_search_max_size'] = !empty($modSettings['shd_search_max_size']) ? $modSettings['shd_search_max_size'] : 8;
	$modSettings['shd_search_prefix_size'] = !empty($modSettings['shd_search_prefix_size']) ? $modSettings['shd_search_prefix_size'] : 0;

	$terms = explode(',', $modSettings['shd_search_charset']);
	$exclude_regex = '';
	foreach ($terms as $k => $v)
	{
		$v = trim($v);
		if (preg_match('~^(.)$~i' . ($context['utf8'] ? 'u' : ''), $v, $match)) // Single character
			$exclude_regex .= preg_quote($match[1], '~');
		elseif (preg_match('~^(.)\.\.(.)$~i' . ($context['utf8'] ? 'u' : ''), $v, $match)) // It's a ranged component.
			$exclude_regex .= preg_quote($match[1], '~') . '-' . preg_quote($match[2], '~');
	}
	if (empty($exclude_regex))
		$exclude_regex = '';
	else
		$exclude_regex = '~[^' . $exclude_regex . ']+~' . ($context['utf8'] ? 'u' : '');

	return array($charset, $exclude_regex);
}

/**
 *	Takes an input string and returns a large array of word and word position identifiers.
 *
 *	@param string $string A regular post's contents, or that of the subject of a post.
 *	@return array An array containing the word identifiers.
*/
function shd_tokeniser($string)
{
	global $smcFunc, $modSettings;
	static $charset = null, $exclude_regex = '';

	$result = array();

	if ($charset === null)
		list($charset, $exclude_regex) = shd_search_charset();

	// Step 1. Convert entities back to characters, regardless of what they are.
	$string = html_entity_decode($string, ENT_QUOTES, $charset);

	// Step 2. Strip wiki code then bbcode.
	$string = preg_replace('~\[\[[^\]]+\]\]~U', '', $string);
	$string = preg_replace('~\[[^\]]+\]~U', '', $string);

	// Step 3. Strip certain minimal HTML.
	$string = preg_replace('~</?(img|br|hr|b|i|u|strike|s|ins|del|ol|ul|li|p|div|span|table|tr|th|td|code|pre)[^>]+>~iU', ' ', $string);

	// Step 3. Strip characters we're not interested in.
	if ($exclude_regex === '') // If we have no character types, we can't match anything.
		return array();

	$string = preg_replace($exclude_regex, ' ', $string);
	$string = trim(preg_replace('~\s+~', ' ', $string));

	// Step 4. Break into an array and start tokenising.
	$array = explode(' ', $string);

	$i = 0;
	foreach ($array as $position => $word)
	{
		$len = $smcFunc['strlen']($word);
		if ($len >= $modSettings['shd_search_min_size'] && $len <= $modSettings['shd_search_max_size'])
		{
			$word = $smcFunc['strtolower']($word);
			$result[shd_hash($word)] = $i++;

			if (!empty($modSettings['shd_search_prefix_size']) && $len >= $modSettings['shd_search_prefix_size'])
			{
				for ($j = $modSettings['shd_search_prefix_size']; $j <= $len; $j++)
				{
					$prefixword = substr($word, 0, $j) . chr(7);
					$result[shd_hash($prefixword)] = $i++;
				}
			}
		}
	}

	return array_flip($result); // This gets us a unique array but done faster than $result[] = shd_hash($word); $result = array_unique($result);
}

/**
 *	Creates our hash. Due to the way floats can be used, we can safely store an integer equal to 2^52 in a float, so we'll use this. It should be relatively free from avalanching.
 *
 *	Theoretically, a 32 bit hash (a la CRC32) would be suitable if it didn't have the collision incidence factor it does, so we have to do it this way.
 *	If we didn't permit prefix matching it would probably be suitable, actually.
 *
 *	@param string $string The string to take the hash of.
 *	@return string $hash The 52 bit number as a string to prevent it being mashed by any more formatting.
*/
function shd_hash($string)
{
	return sprintf('%0.0f', hexdec(substr(sha1($string), -13)));
}