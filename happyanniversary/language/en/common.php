<?php
/**
* This file is part of the Happy Anniversary package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
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
	'HAPPY_ANNIVERSARY'			=> 'Happy anniversary',
	'HAPPY_ANNIVERSARY_EXPLAIN'	=> 'On this day years ago, they found us on the Earth and love begins here.',
	'HAPPY_ANNIVERSARY_TEXT'	=> '<abbr title="%1$s">Congratulations to:</abbr> <strong>%2$s</strong>',
));
