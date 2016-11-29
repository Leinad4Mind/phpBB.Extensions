<?php
/**
* This file is part of the Emoji Smilies package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\emojismilies\acp;

use vinabb\emojismilies\includes\constants;

class settings_module
{
	/** @var string */
	public $u_action;

	/** @var array */
	protected $errors;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->config = $phpbb_container->get('config');
		$this->log = $phpbb_container->get('log');
		$this->request = $phpbb_container->get('request');
		$this->template = $phpbb_container->get('template');
		$this->user = $phpbb_container->get('user');
		$this->language = $phpbb_container->get('language');

		$this->tpl_name = 'acp_emoji_smilies';
		$this->page_title = $this->language->lang('ACP_EMOJI_SMILIES');

		// Language files
		$this->language->add_lang('acp/board');
		$this->language->add_lang('acp_emoji_smilies', 'vinabb/emojismilies');

		add_form_key('vinabb/emojismilies');

		// Submit
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('vinabb/emojismilies'))
			{
				$this->errors[] = $this->language->lang('FORM_INVALID');
			}

			// Get from the form
			$smiley_path = $this->request->variable('smiley_path', '');
			$smiley_type = $this->request->variable('smiley_type', false);
			$emoji_type = $this->request->variable('emoji_type', constants::EMOJI_TYPE_RAW);

			if (!sizeof($this->errors))
			{
				$this->config->set('smilies_path', $smiley_path);
				$this->config->set('vinabb_emojismilies_smiley_type', $smiley_type);
				$this->config->set('vinabb_emojismilies_emoji_type', $emoji_type);

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_EMOJI_SMILIES_SETTINGS');

				trigger_error($this->language->lang('EMOJI_SMILIES_SETTINGS_UPDATED') . adm_back_link($this->u_action));
			}
			else
			{
				trigger_error(implode('<br>', $this->errors) . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		// Output
		$this->template->assign_vars([
			'SMILEY_PATH'	=> isset($smiley_path) ? $smiley_path : $this->config['smilies_path'],
			'SMILEY_TYPE'	=> isset($smiley_type) ? $smiley_type : $this->config['vinabb_emojismilies_smiley_type'],
			'EMOJI_TYPE'	=> isset($emoji_type) ? $emoji_type : $this->config['vinabb_emojismilies_emoji_type'],

			'EMOJI_TYPE_RAW'		=> constants::EMOJI_TYPE_RAW,
			'EMOJI_TYPE_TWITTER'	=> constants::EMOJI_TYPE_TWITTER,
			'EMOJI_TYPE_EMOJIONE'	=> constants::EMOJI_TYPE_EMOJIONE,

			'U_ACTION'	=> $this->u_action
		]);
	}
}
