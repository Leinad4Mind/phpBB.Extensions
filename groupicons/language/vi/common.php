<?php
/**
* This file is part of the Group Icons package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license The MIT License (MIT)
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
	'GROUP_ICON'		=> 'Biểu tượng nhóm',
	'SELECT_GROUP_ICON'	=> 'Chọn biểu tượng nhóm…',
));
