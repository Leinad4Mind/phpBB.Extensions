<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
* @italian language By alex75 www.phpbb-store.it
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
	$lang = array();
}

/**
* All language files should use UTF-8 as their encoding
* and the files must not contain a BOM.
*/
$lang = array_merge($lang, array(
	'EMOJI_BUTTON_EXPLAIN'	=> 'Usa il tasto Tab per accedere rapidamente alle Emoji.',
	'EMOJI_CATS'			=> array(
		'ACTIVITIES'	=> 'Sport',
		'FLAGS'			=> 'Bandiere',
		'FOOD'			=> 'Cibo e Bevande',
		'NATURE'		=> 'Animali e Natura',
		'OBJECTS'		=> 'Oggetti',
		'RECENT'		=> 'Recenti',
		'SMILIES'		=> 'Faccine e Persone',
		'SYMBOLS'		=> 'Simboli',
		'TONES'			=> 'Colori',
		'TRAVEL'		=> 'Mezzi di Trasporto'
	)
));
