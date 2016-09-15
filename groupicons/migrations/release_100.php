<?php
/**
* This file is part of the Group Icons package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license The MIT License (MIT)
*/

namespace vinabb\groupicons\migrations;

class release_100 extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'groups'	=> array(
					'group_icon'	=> array('VCHAR', ''),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'groups'	=> array(
					'style_version',
				),
			),
		);
	}
}
