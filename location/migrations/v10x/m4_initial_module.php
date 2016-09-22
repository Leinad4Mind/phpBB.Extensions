<?php
/**
* This file is part of the Location package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\location\migrations\v10x;

/**
* Migration stage 4: Initial module
*/
class m4_initial_module extends \phpbb\db\migration\migration
{
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
			'\nedka\location\migrations\converter\c3_convert_module',
			'\nedka\location\migrations\v10x\m3_initial_permission',
		);
	}

	/**
	* Add or update data in the database
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_CAT_LOCATION')),
			array('module.add', array(
				'acp', 'ACP_CAT_LOCATION', array(
					'module_basename'	=> '\nedka\location\acp\location_settings_module',
					'modes'				=> array('config'),
				),
			)),
			array('module.add', array(
				'acp', 'ACP_CAT_LOCATION', array(
					'module_basename'	=> '\nedka\location\acp\continents_module',
					'modes'				=> array('manage'),
				),
			)),
			array('module.add', array(
				'acp', 'ACP_CAT_LOCATION', array(
					'module_basename'	=> '\nedka\location\acp\countries_module',
					'modes'				=> array('manage'),
				),
			)),
			array('module.add', array(
				'acp', 'ACP_CAT_LOCATION', array(
					'module_basename'	=> '\nedka\location\acp\country_units_module',
					'modes'				=> array('manage'),
				),
			)),
			array('module.add', array(
				'acp', 'ACP_CAT_LOCATION', array(
					'module_basename'	=> '\nedka\location\acp\languages_module',
					'modes'				=> array('manage'),
				),
			)),
			array('module.add', array(
				'acp', 'ACP_CAT_LOCATION', array(
					'module_basename'	=> '\nedka\location\acp\language_scripts_module',
					'modes'				=> array('manage'),
				),
			)),
			array('module.add', array(
				'acp', 'ACP_CAT_LOCATION', array(
					'module_basename'	=> '\nedka\location\acp\currencies_module',
					'modes'				=> array('manage'),
				),
			)),
		);
	}
}
