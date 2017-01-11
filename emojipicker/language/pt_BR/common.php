<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* Portuguese Brazillian Translation
*
* @author GenesMan
* @link https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1621186
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Use a tecla Tab para inserir o Emoji mais rapidamente.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Atividades',
		'FLAGS'			=> 'Bandeiras',
		'FOOD'			=> 'Comida e Bebida',
		'NATURE'		=> 'Animais e Natureza',
		'OBJECTS'		=> 'Objetos',
		'RECENT'		=> 'Recente',
		'SMILIES'		=> 'Smilies e Pessoas',
		'SYMBOLS'		=> 'Símbolos',
		'TONES'			=> 'Diversidade',
		'TRAVEL'		=> 'Viagem e Lugares'
	]
]);
