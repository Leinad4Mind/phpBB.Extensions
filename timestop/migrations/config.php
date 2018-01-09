<?php
/**
* This file is part of the Time Stop package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\timestop\migrations;

/**
* Migration to install data
*/
class config extends \phpbb\db\migration\migration
{
	/**
	* Store the live site URL
	*
	* @return array
	*/
	public function update_data()
	{
		return [
			['config.add', ['vinabb_timestop_live_url', '']]
		];
	}
}
