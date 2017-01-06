<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\emojipicker\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* PHP events
*/
class listener implements EventSubscriberInterface
{
	/**
	* List of phpBB's PHP events to be used
	*
	* @return array
	*/
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'	=> 'user_setup'
		];
	}

	/**
	* core.user_setup
	*
	* @param array $event Data from the PHP event
	*/
	public function user_setup($event)
	{
		// Add our common language variables
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'vinabb/emojipicker',
			'lang_set' => 'common'
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}
}
