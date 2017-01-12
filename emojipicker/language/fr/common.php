<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* French Translation
*
* @author Mathieu M.
* @link https://www.html-edition.com/
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Utiliser la touche Tab pour insérer un Emoji rapidement.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Activités',
		'FLAGS'			=> 'Drapeaux',
		'FOOD'			=> 'Nourritures et boissons',
		'NATURE'		=> 'Animaux et nature',
		'OBJECTS'		=> 'Objets',
		'RECENT'		=> 'Récents',
		'SMILIES'		=> 'Visages et personnes',
		'SYMBOLS'		=> 'Symboles',
		'TONES'			=> 'Diversité',
		'TRAVEL'		=> 'Voyages et endroits'
	]
]);
