<?php
/**
* This file is part of the Happy Anniversary package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\happyanniversaryemail\migrations;

use \phpbb\db\migration\migration;

class release_100 extends migration
{
	/**
	* Add or update data
	*
	* @return array
	*/
	public function update_data()
	{
		return [
			['config.add', ['vinabb_happyanniversaryemail_begin_year', $this->get_begin_year()]],
			['config.add', ['vinabb_happyanniversaryemail_check_gc', 0, 1]]
		];
	}

	/**
	* Get the begin year
	*
	* @return int
	*/
	protected function get_begin_year()
	{
		$sql = 'SELECT MIN(user_regdate) AS min_user_regdate
			FROM ' . USERS_TABLE;
		$result = $this->db->sql_query($sql);
		$min_user_regdate = (int) $this->db->sql_fetchfield('min_user_regdate');
		$this->db->sql_freeresult($result);

		return (int) date('Y', $min_user_regdate);
	}
}
