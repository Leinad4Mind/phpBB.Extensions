<?php
/**
* This file is part of the Location package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\location\migrations\v10x;

/**
* Migration stage 3: Initial permission
*/
class m3_initial_permission extends \phpbb\db\migration\migration
{
	/**
	* Add or update data in the database
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
	{
		return array(
			// Add permission
			array('permission.add', array('a_location', true)),

			// Set permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_location')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_location')),
		);
	}
}
