<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* Dutch Translation
*
* @author lifeguard81
* @link https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=369364
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Gebruik de TAB-toets om Emoji’s te kiezen.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Activiteiten',
		'FLAGS'			=> 'Vlaggen',
		'FOOD'			=> 'Eten en Drinken',
		'NATURE'		=> 'Dieren en Natuur',
		'OBJECTS'		=> 'Objecten',
		'RECENT'		=> 'Recent',
		'SMILIES'		=> 'Smilies en Mensen',
		'SYMBOLS'		=> 'Symbolen',
		'TONES'			=> 'Diversen',
		'TRAVEL'		=> 'Reizen en Plaatsen'
	]
]);
