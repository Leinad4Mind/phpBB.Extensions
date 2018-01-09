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
	'ACP_TIMESTOP'					=> 'Archived mode',
	'ARCHIVE_MODE_LOGIN_MESSAGE'	=> 'Sorry, only founders are allowed to login.',
	'ARCHIVE_MODE_MESSAGE'			=> 'This is just an archived site. No logins are allowed.',
	'ARCHIVE_MODE_MESSAGE_EMAIL'	=> 'Please contact <a href="mailto:%1$s">%1$s</a> for details.',
	'ARCHIVE_MODE_MESSAGE_URL'		=> 'Please visit the live site at <a href="%1$s">%1$s</a>.',

	'LIVE_SITE_URL'	=> 'Live site URL',
]);
