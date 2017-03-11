<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* Czech Translation
*
* @author Zdeněk Švarc
* @link
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Use the Tab key to insert Emoji faster.',
	'EMOJI_CATS'			=> array(
		'ACTIVITIES'	=> 'Aktivity',
		'FLAGS'			=> 'Vlajky',
		'FOOD'			=> 'Jídlo a pití',
		'NATURE'		=> 'Zvířata a příroda',
		'OBJECTS'		=> 'Objekty',
		'RECENT'		=> 'Nedávné',
		'SMILIES'		=> 'Úsměvy a lidé',
		'SYMBOLS'		=> 'Symboly',
		'TONES'			=> 'Různé',
		'TRAVEL'		=> 'Cestování a místa'
	)
));
