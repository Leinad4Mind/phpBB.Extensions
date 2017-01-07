<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* English Translation
*
* @author Your Name
* @link Your World
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* All language files should use UTF-8 as their encoding
* and the files must not contain a BOM.
*/
$lang = array_merge($lang, [
	'EMOJI_BUTTON_EXPLAIN'	=> 'Use the Tab key to insert Emoji faster.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Activities',
		'FLAGS'			=> 'Flags',
		'FOOD'			=> 'Food and Drink',
		'NATURE'		=> 'Animals and Nature',
		'OBJECTS'		=> 'Objects',
		'RECENT'		=> 'Recent',
		'SMILIES'		=> 'Smilies and People',
		'SYMBOLS'		=> 'Symbols',
		'TONES'			=> 'Diversity',
		'TRAVEL'		=> 'Travel and Places'
	]
]);
