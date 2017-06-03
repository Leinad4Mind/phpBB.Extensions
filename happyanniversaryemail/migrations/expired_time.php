<?php
/**
* This file is part of the Happy Anniversary package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\happyanniversaryemail\migrations;

use phpbb\db\migration\migration;

/**
* Migration to install extention data
*/
class expired_time extends migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('vinabb_happyanniversaryemail_check_gc', 0, 1))
		);
	}
}
