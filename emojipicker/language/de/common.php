<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* German Translation
*
* @author Saint_hh (Kevin)
* @link http://www.board3.de/
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Hiermit kannst Du Emoji einfügen.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Aktivität',
		'FLAGS'			=> 'Flaggen',
		'FOOD'			=> 'Essen und Trinken',
		'NATURE'		=> 'Tiere und Natur',
		'OBJECTS'		=> 'Objekte',
		'RECENT'		=> 'Zuletzt benutzt',
		'SMILIES'		=> 'Smileys und Personen',
		'SYMBOLS'		=> 'Symbole',
		'TONES'			=> 'Multikulturell',
		'TRAVEL'		=> 'Reisen und Orte'
	]
]);
