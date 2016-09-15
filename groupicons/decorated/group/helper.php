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
	/** @var  \phpbb\cache\service */
	protected $cache;

	/**
	* Constructor
	*
	* @param \phpbb\cache\service $cache
	* @param \phpbb\language\language $language
	*/
	public function __construct(
		\phpbb\cache\service $cache,
		\phpbb\language\language $language
	)
	{
		$this->cache = $cache;
		$this->language = $language;
	}

	/**
	* @param $group_name string	The stored group name
	*
	* @return string		Group name or translated group name if it exists
	*/
	public function get_name($group_name)
	{
		$group_data = $this->cache->get_group_data_by_name();
		$group_name = $this->language->is_set('G_' . utf8_strtoupper($group_name)) ? $this->language->lang('G_' . utf8_strtoupper($group_name)) : $group_name;
		$group_id = $group_data[$group_name]['id'];
		$group_icon = (isset($group_data[$group_name]['icon']) && !empty($group_data[$group_name]['icon'])) ? '<img src="' . $group_data[$group_name]['icon'] . '" alt="' . $group_name . '" title="' . $group_name . '"> ' : '';

		return $group_icon . $group_name;
	}

	/**
	* @param $group_id
	*
	* @return string
	*/
	public function get_name_by_id($group_id)
	{
		$group_data = $this->cache->get_group_data_by_name();
		$group_name = $this->language->is_set('G_' . utf8_strtoupper($group_data[$group_id]['name'])) ? $this->language->lang('G_' . utf8_strtoupper($group_data[$group_id]['name'])) : $group_data[$group_id]['name'];
		$group_icon = (isset($group_data[$group_id]['icon']) && !empty($group_data[$group_id]['icon'])) ? '<img src="' . $group_data[$group_id]['icon'] . '" alt="' . $group_name . '" title="' . $group_name . '"> ' : '';

		return $group_icon . $group_name;
	}
}
