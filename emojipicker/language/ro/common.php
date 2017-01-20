<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* Romanian Translation
*
* @author Oprea
* @link http://resursele.com
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Utilizați tasta Tab pentru a insera Emoji mai repede.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Activități',
		'FLAGS'			=> 'Steaguri',
		'FOOD'			=> 'Mâncare și băutură',
		'NATURE'		=> 'Animale și natură',
		'OBJECTS'		=> 'Obiecte',
		'RECENT'		=> 'Recente',
		'SMILIES'		=> 'Zâmbete și oameni',
		'SYMBOLS'		=> 'Simboluri',
		'TONES'			=> 'Diversitate',
		'TRAVEL'		=> 'Călătorie și locuri'
	]
]);
