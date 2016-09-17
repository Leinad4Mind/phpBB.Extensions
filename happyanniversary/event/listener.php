<?php
/**
* This file is part of the Happy Anniversary package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\happyanniversary\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\config\config */
    protected $config;

	/** @var \phpbb\user */
    protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\notification\manager */
	protected $notification;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface $db
	* @param \phpbb\cache\driver\driver_interface $cache
	* @param \phpbb\config\config $config
	* @param \phpbb\user $user
	* @param \phpbb\language\language $language
	* @param \phpbb\template\template $template
	* @param \phpbb\notification\manager $notification
	*/
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		\phpbb\user $user,
		\phpbb\language\language $language,
		\phpbb\template\template $template,
		\phpbb\notification\manager $notification
	)
	{
		$this->db = $db;
		$this->cache = $cache;
		$this->config = $config;
		$this->user = $user;
		$this->language = $language;
		$this->template = $template;
		$this->notification = $notification;
	}

	/**
	* Event list
	*
	* @return array
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'				=> 'user_setup',
			'core.index_modify_page_title'	=> 'index_modify_page_title',
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
			'ext_name' => 'vinabb/happyanniversary',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* core.index_modify_page_title
	*
	* @param $event
	*/
	public function index_modify_page_title($event)
	{
		$anniversary_data = $this->cache->get('_vinabb_happyanniversary_data');

		// When do need to refresh cache?
		$time = time();
		$next_time = strtotime('+1 day');
		$expired_year = date('Y', $next_time);
		$expired_month = date('m', $next_time);
		$expired_day = date('d', $next_time);
		$expired_time = strtotime("{$expired_day}-{$expired_month}-{$expired_year} 00:00:00");

		if ($anniversary_data === false || $time > $expired_time)
		{
			// Get the begin year
			$sql = 'SELECT MIN(user_regdate) as min_user_regdate
				FROM ' . USERS_TABLE;
			$result = $this->db->sql_query($sql);
			$min_user_regdate = $this->db->sql_fetchfield('min_user_regdate');
			$this->db->sql_freeresult($result);

			$min_year = date('Y', $min_user_regdate);
			$now_year = date('Y', $time);
			$now_month = date('m', $time);
			$now_day = date('d', $time);

			// Does Time Machine already exist?
			$sql_or = '';
			if ($now_year > $min_year)
			{
				$i = $now_year - 1;

				for ($i; $i >= $min_year; $i--)
				{
					$sql_or .= (empty($sql_or) ? '' : ' OR ');
					$sql_or .= '(u.user_regdate > ' . (strtotime("{$now_day}-{$now_month}-{$i} 00:00:00") - 1) . ' AND u.user_regdate < ' . (strtotime("{$now_day}-{$now_month}-{$i} 23:59:59") + 1) . ')';
				}

				// Display anniversary of 29th february on 28th february in non-leap-years
				if ($now_day == '28' && $now_day == '02' && !date('L', $time) && date('L', strtotime("01-01-{$i}")))
				{
					$sql_or .= (empty($sql_or) ? '' : ' OR ');
					$sql_or .= '(u.user_regdate > ' . (strtotime("29-02-{$i} 00:00:00") - 1) . ' AND u.user_regdate < ' . (strtotime("29-02-{$i} 23:59:59") + 1) . ')';
				}
			}
			$sql_and = empty($sql_or) ? '0' : "($sql_or)";

			// Build the query
			$sql_ary = array(
				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_regdate',
				'FROM' => array(
					USERS_TABLE => 'u',
				),
				'LEFT_JOIN' => array(
					array(
						'FROM' => array(BANLIST_TABLE => 'b'),
						'ON' => 'u.user_id = b.ban_userid',
					),
				),
				'WHERE' => '(b.ban_id IS NULL OR b.ban_exclude = 1)
					AND ' . $this->db->sql_in_set('u.user_type', array(USER_NORMAL, USER_FOUNDER)) . "
					AND $sql_and",
				'ORDER_BY'	=> 'u.user_regdate',
			);
			$sql = $this->db->sql_build_query('SELECT', $sql_ary);
			$result = $this->db->sql_query($sql);

			$anniversary_data = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$years = $now_year - date('Y', $row['user_regdate']);

				$anniversary_data[] = array(
					'user_id'		=> $row['user_id'],
					'username'		=> $row['username'],
					'user_colour'	=> $row['user_colour'],
					'years'			=> $years,
				);

				// Push a notification and/or send an email to the user
				$this->notification->add_notifications('vinabb.happyanniversary.notification.type.happy_anniversary', array(
					'user_id'	=> $row['user_id'],
					'username'	=> $row['username'],
					'years'		=> $years,
				));
			}
			$this->db->sql_freeresult($result);

			// THe next day, how many seconds left?
			$this->cache->put('_vinabb_happyanniversary_data', $anniversary_data, $expired_time - $time);
		}

		// Get the list of anniversary users
		$anniversary_users = '';
		foreach ($anniversary_data as $anniversary_user)
		{
			$anniversary_users .= (empty($anniversary_users) ? '' : ', ') . get_username_string('full', $anniversary_user['user_id'], $anniversary_user['username'], $anniversary_user['user_colour']) . ' (' . $anniversary_user['years'] . ')';
		}

		// Output
		$this->template->assign_vars(array(
			'HAPPY_ANNIVERSARY_TEXT'	=> !empty($anniversary_users) ? $this->language->lang('HAPPY_ANNIVERSARY_TEXT', $anniversary_users) : '',
		));
	}
}
