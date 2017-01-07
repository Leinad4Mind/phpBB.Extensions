<?php
/**
* This file is part of the Emoji Picker package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\emojipicker\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Emojione\Client;
use Emojione\Ruleset;

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
		return array(
			'core.user_setup'						=> 'user_setup',
			'core.modify_format_display_text_after'	=> 'convert_emoji_shortnames',
			'core.modify_text_for_display_after'	=> 'convert_emoji_shortnames'
		);
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
		$lang_set_ext[] = array(
			'ext_name' => 'vinabb/emojipicker',
			'lang_set' => 'common'
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* Convert Emoji shortnames to images
	*
	* @param array $event Data from the PHP event
	*/
	public function convert_emoji_shortnames($event)
	{
		$client = new Client(new Ruleset());
		$client->imageType = 'svg';

		$event['text'] = $client->shortnameToImage($event['text']);
	}
}
