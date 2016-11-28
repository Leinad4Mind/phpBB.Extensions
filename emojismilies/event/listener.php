<?php
/**
* This file is part of the Emoji Smilies package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\emojismilies\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* PHP events
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\language\language */
	protected $language;

	/**
	* Constructor
	*
	* @param \phpbb\config\config					$config			Config object
	* @param \phpbb\db\driver\driver_interface		$db				Database object
	* @param \phpbb\language\language				$language		Language object
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $language)
	{
		$this->config = $config;
		$this->db = $db;
		$this->language = $language;
	}

	/**
	* List of phpBB's PHP events to be used
	*
	* @return array
	*/
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'							=> 'user_setup',
			'core.text_formatter_s9e_configure_after'	=> 'text_formatter_s9e_configure_after'
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
			'ext_name' => 'vinabb/emojismilies',
			'lang_set' => 'common'
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* core.text_formatter_s9e_configure_after
	*
	* @param array $event Data from the PHP event
	*/
	public function text_formatter_s9e_configure_after($event)
	{
		$configurator = $event['configurator'];

		// Remove old smiley data
		unset($configurator->Emoticons);

		// Set new smiley data with emoticon based on user language
		foreach ($this->get_smilies() as $smiley_code => $smiley_data)
		{
			if ($this->language->is_set(['EMOTICON_TEXT', strtoupper($smiley_data['emotion'])]))
			{
				$emotion_text = '{$LE_' . strtoupper($smiley_data['emotion']) . '}';
			}
			else
			{
				$emotion_text = $smiley_data['emotion'];
			}

			$configurator->Emoticons->add($smiley_code, '<img class="smilies" src="{$T_SMILIES_PATH}/' . $smiley_data['url'] . '" width="' . $smiley_data['width'] . '" height="' . $smiley_data['height'] . '" alt="{.}" title="' . $emotion_text . '"/>');
		}

		if (isset($configurator->Emoticons))
		{
			// Force emoticons to be rendered as text if $S_VIEWSMILIES is not set
			$configurator->Emoticons->notIfCondition = 'not($S_VIEWSMILIES)';

			// Only parse emoticons at the beginning of the text or if they're preceded by any
			// one of: a new line, a space, a dot, or a right square bracket
			$configurator->Emoticons->notAfter = '[^\\n .\\]]';
		}

		// Use EmojiOne
		$configurator->Emoji->useEmojiOne();
		$configurator->Emoji->setImageSize(16);
	}

	protected function get_smilies()
	{
		$sql = 'SELECT *
			FROM ' . SMILIES_TABLE . '
			ORDER BY display_on_posting DESC';
		$result = $this->db->sql_query($sql);

		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[$row['code']] = [
				'emotion'	=> $row['emotion'],
				'url'		=> $row['smiley_url'],
				'width'		=> $row['smiley_width'],
				'height'	=> $row['smiley_height'],
				'display'	=> $row['display_on_posting']
			];
		}
		$this->db->sql_freeresult($result);

		return $rows;
	}
}
