<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* Vietnamese Translation
*
* @author VinaBB
* @link https://vinabb.vn/
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
	'EMOJI_BUTTON_EXPLAIN'	=> 'Dùng phím Tab để chèn Emoji nhanh hơn.',
	'EMOJI_CATS'			=> [
		'ACTIVITIES'	=> 'Hoạt động',
		'FLAGS'			=> 'Cờ',
		'FOOD'			=> 'Ăn uống',
		'NATURE'		=> 'Thiên nhiên',
		'OBJECTS'		=> 'Đồ dùng',
		'RECENT'		=> 'Thường dùng',
		'SMILIES'		=> 'Cảm xúc',
		'SYMBOLS'		=> 'Ký hiệu',
		'TONES'			=> 'Màu da',
		'TRAVEL'		=> 'Du lịch'
	]
]);
