<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* Spanish Translation
*
* @author ThE KuKa
* @link http://www.phpbb-es.com/
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Utilice la tecla Tab para insertar el Emoji más rápido.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Ocupaciones',
		'FLAGS'			=> 'Banderas',
		'FOOD'			=> 'Comida y bebida',
		'NATURE'		=> 'Animales y naturaleza',
		'OBJECTS'		=> 'Objetos',
		'RECENT'		=> 'Reciente',
		'SMILIES'		=> 'Smilies y personas',
		'SYMBOLS'		=> 'Símbolos',
		'TONES'			=> 'Diversidad',
		'TRAVEL'		=> 'Viajes y lugares'
	]
]);
