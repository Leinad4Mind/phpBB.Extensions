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
		return [
			'core.user_setup'				=> 'user_setup',
			'core.index_modify_page_title'	=> 'index_modify_page_title'
		];
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
		$lang_set_ext[] = [
			'ext_name' => 'vinabb/happyanniversary',
			'lang_set' => 'common'
		];
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

		$time = time();
		$now_year = date('Y', $time);

		// When do need to refresh cache?
		$next_time = strtotime('+1 day');
		$expired_time = strtotime(date('d', $next_time) . '-' . date('m', $next_time) . '-'. date('Y', $next_time) . ' 00:00:00');

		if ($now_year > $this->config['vinabb_happyanniversary_begin_year'] && ($anniversary_data === false || $time > $expired_time))
		{
			$sql = $this->db->sql_build_query('SELECT', $this->build_sql($time));
			$result = $this->db->sql_query($sql);

			$anniversary_data = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$anniversary_data[$row['user_id']] = [
					'username'		=> $row['username'],
					'user_colour'	=> $row['user_colour'],
					'years'			=> $now_year - date('Y', $row['user_regdate'])
				];
			}
			$this->db->sql_freeresult($result);

			// Push a notification and/or send an email to the user
			if (sizeof($anniversary_data))
			{
				$this->notification->add_notifications('vinabb.happyanniversary.notification.type.happy_anniversary', $anniversary_data);
			}

			// The next day, how many seconds left?
			$this->cache->put('_vinabb_happyanniversary_data', $anniversary_data, $expired_time - $time);
		}

		// Get the list of anniversary users
		$anniversary_users = '';
		foreach ($anniversary_data as $user_id => $user_data)
		{
			$anniversary_users .= (($anniversary_users == '') ? '' : ', ') . get_username_string('full', $user_id, $user_data['username'], $user_data['user_colour']) . ' (' . $user_data['years'] . ')';
		}

		// Output
		$this->template->assign_var('HAPPY_ANNIVERSARY_TEXT', ($anniversary_users != '') ? $this->language->lang('HAPPY_ANNIVERSARY_TEXT', $anniversary_users) : '');
	}

	/**
	 * Build SQL query for anniversary users
	 *
	 * @param int $time Timestamp
	 * @return array
	 */
	protected function build_sql($time)
	{
		// Current date
		$now_year = date('Y', $time);
		$now_month = date('m', $time);
		$now_day = date('d', $time);

		// Does Time Machine already exist?
		$sql_or = '';
		$i = $now_year - 1;

		for ($i; $i >= $this->config['vinabb_happyanniversary_begin_year']; $i--)
		{
			$sql_or .= ($sql_or == '') ? '' : ' OR ';
			$sql_or .= '(u.user_regdate > ' . (strtotime("{$now_day}-{$now_month}-{$i} 00:00:00") - 1) . ' AND u.user_regdate < ' . (strtotime("{$now_day}-{$now_month}-{$i} 23:59:59") + 1) . ')';
		}

		// Display anniversary of 29th february on 28th february in non-leap-years
		if ($now_day == '28' && $now_day == '02' && !date('L', $time) && date('L', strtotime("01-01-{$i}")))
		{
			$sql_or .= ($sql_or == '') ? '' : ' OR ';
			$sql_or .= '(u.user_regdate > ' . (strtotime("29-02-{$i} 00:00:00") - 1) . ' AND u.user_regdate < ' . (strtotime("29-02-{$i} 23:59:59") + 1) . ')';
		}

		$sql_and = ($sql_or == '') ? '0' : "($sql_or)";

		// Build the query
		$sql_ary = [
			'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_regdate',
			'FROM' => [USERS_TABLE => 'u'],
			'LEFT_JOIN' => [
				[
					'FROM' => [BANLIST_TABLE => 'b'],
					'ON' => 'u.user_id = b.ban_userid'
				]
			],
			'WHERE' => '(b.ban_id IS NULL OR b.ban_exclude = 1)
					AND ' . $this->db->sql_in_set('u.user_type', [USER_NORMAL, USER_FOUNDER]) . "
					AND $sql_and",
			'ORDER_BY'	=> 'u.user_regdate',
		];

		return $sql_ary;
	}
}
