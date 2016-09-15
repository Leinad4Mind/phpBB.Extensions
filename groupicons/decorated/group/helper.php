<?php
/**
 * This file is part of the Group Icons package.
 *
 * @copyright (c) VinaBB <vinabb.vn>
 * @license The MIT License (MIT)
 */

namespace vinabb\groupicons\decorated\group;

class helper extends \phpbb\group\helper
{
	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\extension\manager */
	protected $ext_manager;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var string */
	protected $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\cache\service $cache
	* @param \phpbb\user $user
	* @param \phpbb\language\language $language
	* @param \phpbb\extension\manager $ext_manager
	* @param \phpbb\path_helper $path_helper
	* @param string $php_ext
	*/
	public function __construct(
		\phpbb\cache\service $cache,
		\phpbb\user $user,
		\phpbb\language\language $language,
		\phpbb\extension\manager $ext_manager,
		\phpbb\path_helper $path_helper,
		$php_ext
	)
	{
		$this->cache = $cache;
		$this->user = $user;
		$this->language = $language;
		$this->ext_manager = $ext_manager;
		$this->path_helper = $path_helper;
		$this->php_ext = $php_ext;

		$this->ext_root_path = $this->ext_manager->get_extension_path('vinabb/groupicons', true);
		$this->ext_web_path = $this->path_helper->update_web_root_path($this->ext_root_path);
		$this->group_data_by_name = array();
	}

	/**
	* @param $group_name string	The stored group name
	* @param $only_name bool 	true: only display group name without the icon
	*
	* @return string		Group name or translated group name if it exists
	*/
	public function get_name($group_name, $only_name = false)
	{
		$group_name_display = $this->language->is_set('G_' . utf8_strtoupper($group_name)) ? $this->language->lang('G_' . utf8_strtoupper($group_name)) : $group_name;

		// Only display in group legend on the index page :p
		if (!defined('IN_ADMIN') && $this->user->page['page_name'] == "index.{$this->php_ext}")
		{
			if (!sizeof($this->group_data_by_name))
			{
				$this->group_data_by_name = $this->cache->get_group_data_by_name();
			}

			$group_icon = (isset($this->group_data_by_name[$group_name]['icon']) && !empty($this->group_data_by_name[$group_name]['icon'])) ? '<img src="' . $this->ext_web_path . 'images/' . $this->group_data_by_name[$group_name]['icon'] . '" alt="' . $group_name_display . '" title="' . $group_name_display . '">' : '';

			return ($only_name) ? $group_name_display : (($this->language->lang('DIRECTION') == 'ltr') ? $group_icon . $group_name_display : $group_name_display . $group_icon);
		}
		else
		{
			return $group_name_display;
		}
	}

	/**
	* @param $group_id
	*
	* @return string
	*/
	public function get_name_by_id($group_id)
	{
		$group_data = $this->cache->get_group_data();
		$group_name = $this->language->is_set('G_' . utf8_strtoupper($group_data[$group_id]['name'])) ? $this->language->lang('G_' . utf8_strtoupper($group_data[$group_id]['name'])) : $group_data[$group_id]['name'];
		$group_icon = (isset($group_data[$group_id]['icon']) && !empty($group_data[$group_id]['icon'])) ? '<img src="' . $this->ext_web_path . 'images/' . $group_data[$group_id]['icon'] . '" alt="' . $group_name . '" title="' . $group_name . '"> ' : '';

		return $group_icon . $group_name;
	}
}
