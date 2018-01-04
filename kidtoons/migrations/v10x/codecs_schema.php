<?php
/**
* This file is part of the KidToons package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\kidtoons\migrations\v10x;

use phpbb\db\migration\migration;

/**
* Database schema for video/audio codecs
*/
class codecs_schema extends migration
{
	/**
	* Update schema
	*
	* @return array
	*/
	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'kt_codecs' => [
					'COLUMNS' => [
						'codec'				=> ['VCHAR:3', ''],
						'codec_name'		=> ['VCHAR', ''],
						'codec_fullname'	=> ['VCHAR', ''],
						'codec_video'		=> ['BOOL', 0]
					],
					'KEYS' => [
						'cc'	=> ['INDEX', 'codec']
					]
				]
			]
		];
	}

	/**
	* Revert schema
	*
	* @return array
	*/
	public function revert_schema()
	{
		return [
			'drop_tables' => [$this->table_prefix . 'kt_codecs']
		];
	}
}
