<?php
/**
* This file is part of the Time Stop package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* All language files should use UTF-8 as their encoding
* and the files must not contain a BOM.
*/
$lang = array_merge($lang, [
	'ACP_TIMESTOP'					=> 'Chế độ lưu trữ',
	'ARCHIVE_MODE_LOGIN_MESSAGE'	=> 'Chỉ người sáng lập mới có thể đăng nhập.',
	'ARCHIVE_MODE_MESSAGE'			=> 'Đây chỉ là nơi lưu dữ liệu cũ. Thao thác đăng nhập đã bị khóa.',
	'ARCHIVE_MODE_MESSAGE_EMAIL'	=> 'Vui lòng liên hệ <a href="mailto:%1$s">%1$s</a>.',
	'ARCHIVE_MODE_MESSAGE_URL'		=> 'Vui lòng truy cập trang mới tại địa chỉ <a href="%1$s">%1$s</a>.',

	'LIVE_SITE_URL'	=> 'Liên kết trang mới',
]);
