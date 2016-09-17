<?php
/**
* This file is part of the Happy Anniversary package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\happyanniversary\notification\type;

class happy_anniversary extends \phpbb\notification\type\base
{
	/** @var \phpbb\controller\helper */
	protected $helper;

	/**
	* Set the controller helper
	*
	* @param \phpbb\controller\helper $helper
	* @return null
	*/
	public function set_controller_helper(\phpbb\controller\helper $helper)
	{
		$this->helper = $helper;
	}

	/**
	* Get notification type name
	*
	* @return string
	*/
	public function get_type()
	{
		return 'vinabb.happyanniversary.notification.type.happy_anniversary';
	}

	/**
	* {@inheritdoc}
	*/
	protected $language_key = 'NOTIFICATION_HAPPY_ANNIVERSARY';

	/**
	* Notification option data (for outputting to the user)
	*
	* @var bool|array False if the service should use it's default data
	* 					Array of data (including keys 'id', 'lang', and 'group')
	*/
	public static $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_HAPPY_ANNIVERSARY',
		'group'	=> 'NOTIFICATION_GROUP_MISCELLANEOUS',
	);

	/**
	* Is this type available to the current user (defines whether or not it will be shown in the UCP Edit notification options)
	*
	* @return bool True/False whether or not this is available to the user
	*/
	public function is_available()
	{
		return true;
	}

	/**
	* Get the id of the notification
	*
	* @param array $data The data for the updated rules
	* @return int Id of the notification
	*/
	public static function get_item_id($user)
	{
		return (int) $user['user_id'];
	}

	/**
	* Get the id of the parent
	*
	* @param array $data The data for the updated rules
	* @return int Id of the parent
	*/
	public static function get_item_parent_id($data)
	{
		// No parent
		return 0;
	}

	/**
	* Find the users who want to receive notifications
	*
	* @param array $data The type specific data
	* @param array $options Options for finding users for notification
	* 		ignore_users => array of users and user types that should not receive notifications from this type because they've already been notified
	* 						e.g.: array(2 => array(''), 3 => array('', 'email'), ...)
	*
	* @return array
	*/
	public function find_users_for_notification($data, $options = array())
	{
		// Return an array of users to be notified, storing the user_ids as the array keys
		return array();
	}

	/**
	* {@inheritdoc}
	*/
	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->item_id, false, true);
	}

	/**
	* Get the HTML formatted title of this notification
	*
	* @return string
	*/
	public function get_title()
	{
		$username = $this->user_loader->get_username($this->item_id, 'no_profile');

		return $this->user->lang($this->language_key, $username);
	}

	/**
	* Get email template
	*
	* @return string|bool
	*/
	public function get_email_template()
	{
		return 'happy_anniversary';
	}

	/**
	* {@inheritdoc}
	*/
	public function get_email_template_variables()
	{
		$board_url = generate_board_url();
		$username = $this->user_loader->get_username($this->item_id, 'username');

		return array(
			'USERNAME'	=> htmlspecialchars_decode($username),
			'U_BOARD'	=> $board_url,
			'YEARS'		=> $this->get_data('years'),
		);
	}

	/**
	* {@inheritdoc}
	*/
	public function get_url()
	{
		return $this->user_loader->get_username($this->item_id, 'profile');
	}

	/**
	* {@inheritdoc}
	*/
	public function users_to_query()
	{
		return array($this->item_id);
	}

	/**
	* Function for preparing the data for insertion in an SQL query
	* (The service handles insertion)
	*
	* @param array $data The data for the updated rules
	* @param array $pre_create_data Data from pre_create_insert_array()
	*
	* @return array Array of data ready to be inserted into the database
	*/
	public function create_insert_array($data, $pre_create_data)
	{
		$this->set_data('years', $data['years']);
		//$this->notification_time = $user['user_regdate'];

		return parent::create_insert_array($data, $pre_create_data);
	}
}
