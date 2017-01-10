<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* Russian Translation
*
* @author strelok-by
* @link https://golf2mania.ru/
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Используйте клавишу Tab для быстрой вставки эмодзи.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Деятельность',
		'FLAGS'			=> 'Флаги',
		'FOOD'			=> 'Еда и напитки',
		'NATURE'		=> 'Животные и Природа',
		'OBJECTS'		=> 'Объекты',
		'RECENT'		=> 'Последние',
		'SMILIES'		=> 'Смайлики и люди',
		'SYMBOLS'		=> 'Символы',
		'TONES'			=> 'Разнообразие',
		'TRAVEL'		=> 'Путешествия и Места'
	]
]);
