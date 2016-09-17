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

	/** @var \phpbb\template\template */
    protected $template;

	/** @var \phpbb\user */
    protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface $db
	* @param \phpbb\cache\driver\driver_interface $cache
	* @param \phpbb\config\config $config
	* @param \phpbb\template\template $template
	* @param \phpbb\user $user
	*/
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user
	)
	{
		$this->db = $db;
		$this->cache = $cache;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
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
		echo $this->board_strtotime() . "<br>";
		echo time();
		$anniversary_data = $this->cache->get('_vinabb_happyanniversary_data');

		if ($anniversary_data === false)
		{
			$time = $this->board_strtotime();
			$now = phpbb_gmgetdate($time);

			// Get the begin year
			$sql = 'SELECT MIN(user_regdate) as min_user_regdate
				FROM ' . USERS_TABLE;
			$result = $this->db->sql_query($sql);
			$min_user_regdate = $this->db->sql_fetchfield('min_user_regdate');
			$this->db->sql_freeresult($result);

			$min_year = date('Y', $this->board_strtotime(date('d-m-Y', $min_user_regdate)));
			$now_year = date('Y', $time);
			$now_month = date('m', $time);
			$now_day = date('d', $time);

			$sql_or = '';
			if ($now_year > $min_year)
			{
				$i = $now_year - 1;

				for ($i; $i >= $min_year; $i--)
				{
					$sql_or .= (empty($sql_or) ? '' : ' OR ');
					$sql_or .= '(u.user_regdate > ' . ($this->board_strtotime("{$now_day}-{$now_month}-{$i} 00:00:00") - 1) . ' AND u.user_regdate < ' . ($this->board_strtotime("{$now_day}-{$now_month}-{$i} 23:59:59") + 1) . ')';
				}
			}
			$sql_and = empty($sql_or) ? '0' : "($sql_or)";

			// Array ( [seconds] => 24 [minutes] => 3 [hours] => 4 [mday] => 17 [wday] => 6 [mon] => 9 [year] => 2016 [yday] => 260 [weekday] => Saturday [month] => September [0] => 1474077804 ) 1
			// Display birthdays of 29th february on 28th february in non-leap-years
			$leap_year_birthdays = '';
			if ($now['mday'] == 29 && $now['mon'] == 2 && !$time->format('L'))
			{
				$leap_year_birthdays = " OR u.user_regdate LIKE '" . $this->db->sql_escape(sprintf('%2d-%2d-', 29, 2)) . "%'";
			}

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
				$anniversary_data[] = array(
					'user_id'		=> $row['user_id'],
					'username'		=> $row['username'],
					'user_colour'	=> $row['user_colour'],
					'years'			=> $now_year - date('Y', $this->board_strtotime(date('d-m-Y', $row['user_regdate']))),
				);
			}
			$this->db->sql_freeresult($result);

			// When do need to refresh cache?
			$next_time = $this->board_strtotime('+1 day');
			$expired_year = date('Y', $next_time);
			$expired_month = date('m', $next_time);
			$expired_day = date('d', $next_time);
			$expired_seconds = $this->board_strtotime("{$expired_day}-{$expired_month}-{$expired_year} 00:00:00") - $this->board_strtotime();

			$this->cache->put('_vinabb_happyanniversary_data', $anniversary_data, $expired_seconds);
		}

		$anniversary_users = '';
		foreach ($anniversary_data as $anniversary_user)
		{
			$anniversary_users .= (empty($anniversary_users) ? '' : ', ') . get_username_string('full', $anniversary_user['user_id'], $anniversary_user['username'], $anniversary_user['user_colour']) . ' (' . $anniversary_user['years'] . ')';
		}

		$this->template->assign_vars(array(
			'HAPPY_ANNIVERSARY_TEXT'	=> !empty($anniversary_users) ? $this->user->lang('HAPPY_ANNIVERSARY_TEXT', $this->user->lang('HAPPY_ANNIVERSARY_EXPLAIN'), $anniversary_users) : '',
		));
	}

	/**
	* Convert string to UNIX timestamp, but using the default timezone of board
	*
	* @param string $string
	* @return int
	*/
	protected function board_strtotime($string = 'now')
	{
		return $this->user->create_datetime($string, new \DateTimeZone($this->config['board_timezone']))->getTimestamp();
	}
}
