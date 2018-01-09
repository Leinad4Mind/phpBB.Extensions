<?php
/**
* This file is part of the Time Stop package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\timestop\events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* PHP events
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config $config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface $db */
	protected $db;

	/** @var \phpbb\language\language $language */
	protected $language;

	/** @var \phpbb\request\request $request */
	protected $request;

	/** @var \phpbb\template\template $template */
	protected $template;

	/** @var \phpbb\user $user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\config\config				$config		Config object
	* @param \phpbb\db\driver\driver_interface	$db			Database object
	* @param \phpbb\language\language			$language	Language object
	* @param \phpbb\request\request				$request	Request object
	* @param \phpbb\template\template			$template	Template object
	* @param \phpbb\user						$user		User object
	*/
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user
	)
	{
		$this->config = $config;
		$this->db = $db;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
	}

	/**
	* List of phpBB's PHP events to be used
	*
	* @return array
	*/
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'					=> 'user_setup',
			'core.page_header'					=> 'page_header',
			'core.login_box_before'				=> 'login_box_before',
			'core.acp_board_config_edit_add'	=> 'acp_board_config_edit_add'
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
			'ext_name' => 'vinabb/timestop',
			'lang_set' => 'common'
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* core.page_header_before
	*
	* @param array $event Data from the PHP event
	*/
	public function page_header($event)
	{
		$this->template->assign_vars([
			'ADMIN_CONTACT_EMAIL'	=> $this->config['board_contact'],
			'LIVE_SITE_URL'			=> $this->config['vinabb_timestop_live_url']
		]);
	}

	/**
	* core.page_header_after
	*
	* @param array $event Data from the PHP event
	*/
	public function login_box_before($event)
	{
		$username = $this->request->variable('username', '', true);

		if ($this->request->is_set_post('login') && $username !== '')
		{
			$sql = 'SELECT 1
				FROM ' . USERS_TABLE . "
				WHERE username = '" . $this->db->sql_escape($username) . "'
					AND user_type = " . USER_FOUNDER;
			$result = $this->db->sql_query($sql);
			$is_founder = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($is_founder === false)
			{
				trigger_error('ARCHIVE_MODE_LOGIN_MESSAGE', E_USER_WARNING);
			}
		}
	}

	/**
	* core.acp_board_config_edit_add
	*
	* @param array $event Data from the PHP event
	*/
	public function acp_board_config_edit_add($event)
	{
		if ($event['mode'] == 'settings')
		{
			$display_vars = $event['display_vars'];
			$display_vars['vars']['legend4'] = 'ACP_TIMESTOP';
			$display_vars['vars']['vinabb_timestop_live_url'] = ['lang' => 'LIVE_SITE_URL', 'validate' => 'string', 'type' => 'url:40:255', 'explain' => false];
			$display_vars['vars']['legend5'] = 'ACP_SUBMIT_CHANGES';
			$event['display_vars'] = $display_vars;
		}
	}
}
