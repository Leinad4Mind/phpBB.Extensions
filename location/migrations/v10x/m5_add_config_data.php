<?php
/**
* This file is part of the Location package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\location\migrations\v10x;

/**
* Migration stage 5: Additional config data
*/
class m5_add_config_data extends \phpbb\db\migration\migration
{
	/**
	* Add or update data in the database
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
	{
		$prefix = 'nedka_location_';

		return array(
			array('config.add', array($prefix . 'continent_name', 'TRANSLATION')),
			array('config.add', array($prefix . 'country_name', 'ENGLISH_OR_LOCAL')),
			array('config.add', array($prefix . 'unit_name', 'ENGLISH_OR_LOCAL')),
			array('config.add', array($prefix . 'nationality_name', 'ENGLISH_OR_LOCAL')),
			array('config.add', array($prefix . 'display_level', '3')),
			array('config.add', array($prefix . 'require_level', '0')),
			array('config.add', array($prefix . 'display_in_profile', '1')),
			array('config.add', array($prefix . 'display_in_post', '1')),
			array('config.add', array($prefix . 'display_in_pm', '1')),
			array('config.add', array($prefix . 'display_in_memberlist', '1')),
			array('config.add', array($prefix . 'display_in_group', '0')),
			array('config.add', array($prefix . 'display_in_teampage', '0')),
			array('config.add', array($prefix . 'enable_nationality', '0')),
			array('config.add', array($prefix . 'require_nationality', '0')),
			array('config.add', array($prefix . 'allow_change_nationality', '1')),
			array('config.add', array($prefix . 'change_nationality_times', '0')),
			array('config.add', array($prefix . 'display_nationality_in_profile', '1')),
			array('config.add', array($prefix . 'display_nationality_in_post', '0')),
			array('config.add', array($prefix . 'display_nationality_in_pm', '0')),
			array('config.add', array($prefix . 'display_nationality_in_memberlist', '0')),
			array('config.add', array($prefix . 'display_nationality_in_group', '0')),
			array('config.add', array($prefix . 'display_nationality_in_teampage', '0')),
		);
	}
}
