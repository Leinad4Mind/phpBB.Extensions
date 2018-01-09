<?php
/**
* This file is part of the Time Stop package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\timestop;

/**
* Extension class for custom enable/disable/purge actions
*/
class ext extends \phpbb\extension\base
{
	/**
	* Check whether or not the extension can be enabled
	*
	* @return bool
	*/
	public function is_enableable()
	{
		$user = $this->container->get('user');

		return $user->data['user_type'] == USER_FOUNDER;
	}

	/**
	* Purge all user sessions once this extension is enabled, except the current founder user.
	* Other founders still can login again ;)
	*
	* @param	mixed	$old_state	The return value of the previous call
	*								of this method, or false on the first call
	*
	* @return	mixed				Returns false after last step, otherwise
	*								temporary state which is passed as an
	*								argument to the next step
	*/
	public function enable_step($old_state)
	{
		$db = $this->container->get('dbal.conn');
		$log = $this->container->get('log');
		$user = $this->container->get('user');

		if ($old_state === false)
		{
			$tables = [CONFIRM_TABLE, SESSIONS_TABLE];

			foreach ($tables as $table)
			{
				switch ($db->get_sql_layer())
				{
					case 'sqlite3':
						$db->sql_query("DELETE FROM $table");
					break;

					default:
						$db->sql_query("TRUNCATE TABLE $table");
					break;
				}
			}

			// Let's restore the admin session
			$reinsert_ary = [
				'session_id'			=> (string) $user->session_id,
				'session_page'			=> (string) substr($user->page['page'], 0, 199),
				'session_forum_id'		=> $user->page['forum'],
				'session_user_id'		=> (int) $user->data['user_id'],
				'session_start'			=> (int) $user->data['session_start'],
				'session_last_visit'	=> (int) $user->data['session_last_visit'],
				'session_time'			=> (int) $user->time_now,
				'session_browser'		=> (string) trim(substr($user->browser, 0, 149)),
				'session_forwarded_for'	=> (string) $user->forwarded_for,
				'session_ip'			=> (string) $user->ip,
				'session_autologin'		=> (int) $user->data['session_autologin'],
				'session_admin'			=> 1,
				'session_viewonline'	=> (int) $user->data['session_viewonline'],
			];

			$sql = 'INSERT INTO ' . SESSIONS_TABLE . ' ' . $db->sql_build_array('INSERT', $reinsert_ary);
			$db->sql_query($sql);

			$log->add('admin', $user->data['user_id'], $user->ip, 'LOG_PURGE_SESSIONS');

			return 'timestop';
		}

		return parent::enable_step($old_state);
	}
}
