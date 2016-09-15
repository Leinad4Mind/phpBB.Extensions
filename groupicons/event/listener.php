<?php
/**
* This file is part of the Group Icons package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license The MIT License (MIT)
*/

namespace vinabb\groupicons\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\extension\manager */
	protected $ext_manager;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var string */
	protected $root_path;

	/**
	* Constructor
	*
	* @param \phpbb\cache\service $cache
	* @param \phpbb\template\template $template
	* @param \phpbb\request\request $request
	* @param \phpbb\extension\manager $ext_manager
	* @param \phpbb\path_helper $path_helper
	* @param string $root_path
	*/
	public function __construct(
		\vinabb\groupicons\decorated\cache\service $cache,
		\phpbb\template\template $template,
		\phpbb\request\request $request,
		\phpbb\extension\manager $ext_manager,
		\phpbb\path_helper $path_helper,
		$root_path
	)
	{
		$this->cache = $cache;
		$this->template = $template;
		$this->request = $request;
		$this->ext_manager = $ext_manager;
		$this->path_helper = $path_helper;
		$this->root_path = $root_path;

		$this->ext_root_path = $this->ext_manager->get_extension_path('vinabb/groupicons', true);
		$this->ext_web_path = $this->path_helper->update_web_root_path($this->ext_root_path);
	}

	/**
	* Event list
	*
	* @return array
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'user_setup',
			'core.modify_username_string'			=> 'modify_username_string',
			'core.acp_manage_group_request_data'	=> 'acp_manage_group_request_data',
			'core.acp_manage_group_initialise_data'	=> 'acp_manage_group_initialise_data',
			'core.acp_manage_group_display_form'	=> 'acp_manage_group_display_form',
			'core.add_log'							=> 'add_log'
		);
	}

	/**
	* core.user_setup
	*
	* @param $event
	*/
	public function user_setup($event)
	{
		// Add our common language variables
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'vinabb/groupicons',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* core.modify_username_string
	*
	* @param $event
	*/
	public function modify_username_string($event)
	{
		$group_data = $this->cache->get_group_data_by_color();
		$group_icon = !empty($group_data[$event['username_colour']]['icon']) ? 'img src="' . $group_data[$event['username_colour']]['icon'] . '">' : '';
		$event['username_string'] = $group_icon . $event['username_string'];
	}

	/**
	* core.acp_manage_group_request_data
	*
	* @param $event
	*/
	public function acp_manage_group_request_data($event)
	{
		$submit_ary = $event['submit_ary'];
		$submit_ary['icon'] = $this->request->variable('group_icon', '');
		$event['submit_ary'] = $submit_ary;

		$validation_checks = $event['validation_checks'];
		$validation_checks['icon'] = array('match', false, '#(\.gif|\.png|\.jpg|\.jpeg)$#i');
		$event['validation_checks'] = $validation_checks;
	}

	/**
	* core.acp_manage_group_initialise_data
	*
	* @param $event
	*/
	public function acp_manage_group_initialise_data($event)
	{
		$test_variables = $event['test_variables'];
		$test_variables['icon'] = 'string';
		$event['test_variables'] = $test_variables;
	}

	/**
	* core.acp_manage_group_display_form
	*
	* @param $event
	*/
	public function acp_manage_group_display_form($event)
	{
		// Current
		$group_data = $this->cache->get_group_data();
		$group_icon = $group_data[$event['group_id']]['icon'];

		//
		$img_list = filelist($this->ext_root_path . 'assets/images/group_icons', '', 'gif|png|jpg|jpeg');
		$edit_img = $filename_list = '';

		foreach ($img_list as $path => $img_ary)
		{
			sort($img_ary);

			foreach ($img_ary as $img)
			{
				$img = $path . $img;

				if ($img == $group_icon)
				{
					$selected = ' selected="selected"';
					$edit_img = $img;
				}
				else
				{
					$selected = '';
				}

				if (strlen($img) > 255)
				{
					continue;
				}

				$filename_list .= '<option value="' . $img . '"' . $selected . '>' . $img . '</option>';
			}
		}

		$filename_list = '<option value=""' . (($edit_img == '') ? ' selected="selected"' : '') . '>----------</option>' . $filename_list;

		$this->template->assign_vars(array(
			'ICONS_PATH'	=> $this->ext_web_path . 'assets/images/group_icons/',
			'ICON_OPTIONS'	=> $filename_list
		));
	}

	/**
	* core.add_log
	*
	* @param $event
	*/
	public function add_log($event)
	{
		if ($event['log_operation'] == 'LOG_GROUP_CREATED' || $event['log_operation'] == 'LOG_GROUP_DELETE' || $event['log_operation'] == 'LOG_GROUP_UPDATED')
		{
			$this->cache->clear_group_data();
		}
	}
}
