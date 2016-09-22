<?php
/**
* This file is part of the Location package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\location\migrations\converter;

/**
* Converter stage 2: Drop old tables and columns
*/
class c2_drop_schema extends \phpbb\db\migration\migration
{
	/**
	* Skip this migration if a previous pages table does not
	* exist, or our pages table is already installed
	*
	* @return bool True to skip this migration, false to run it
	* @access public
	*/
	public function effectively_installed()
	{
		return !$this->db_tools->sql_table_exists($this->table_prefix . 'flags');
	}

	/**
	* Assign migration file dependencies for this migration
	*
	* @return array Array of migration files
	* @static
	* @access public
	*/
	static public function depends_on()
	{
		return array(
			'\nedka\location\migrations\converter\c1_convert_data',
		);
	}

	/**
	* RIP to Country Flag MOD :(
	*
	* @return array Array of table schema
	* @access public
	*/
	public function update_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'flags',
			),
			'drop_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_flag',
				),
				$this->table_prefix . 'groups'	=> array(
					'group_flag',
				),
			),
		);
	}

	/**
	* Remove old config data
	*
	* @return array Array of table schema
	* @access public
	*/
	public function update_data()
	{
		return array(
			array('config.remove', array('flags_path')),
			array('config.remove', array('require_flag')),
			array('permission.remove', array('a_flags')),
		);
	}
}
