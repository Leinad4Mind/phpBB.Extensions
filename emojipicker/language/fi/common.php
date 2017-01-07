<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* Finnish Translation
*
* @author potku
* @link http://www.potku.net/
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Tabulaattorilla saat hymiön nopeammin viestiisi.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Harrastukset',
		'FLAGS'			=> 'Liput',
		'FOOD'			=> 'Ruoka ja juoma',
		'NATURE'		=> 'Eläimet ja luonto',
		'OBJECTS'		=> 'Esineet',
		'RECENT'		=> 'Viimeksi käytetyt',
		'SMILIES'		=> 'Ihmiset',
		'SYMBOLS'		=> 'Symbolit',
		'TONES'			=> 'Sävyt',
		'TRAVEL'		=> 'Matkailu'
	]
]);
