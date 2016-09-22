<?php
/**
* This file is part of the Location package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\location\migrations\v10x;

/**
* Migration stage 1: Initial schema
*/
class m1_initial_schema extends \phpbb\db\migration\migration
{
	/**
	* Add the pages table schema to the database:
	*
	* @return array Array of table schema
	* @access public
	*/
	public function update_schema()
	{
		// Geographic Decimal: decimal(10,6)
		switch($this->db->get_sql_layer())
		{
			case 'mysql':
			case 'mysql4':
			case 'mysqli':
			case 'postgres':
			case 'sqlite':
				define('GDECIMAL', 'decimal(10,6)');
			break;

			case 'sqlite3':
				define('GDECIMAL', 'DECIMAL(10,6)');
			break;

			case 'mssql':
			case 'mssql_odbc':
			case 'mssqlnative':
				define('GDECIMAL', '[float]');
			break;

			case 'oracle':
				define('GDECIMAL', 'number(10, 6)');
			break;
		}

		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'continents'	=> array(
					'COLUMNS'		=> array(
						'continent_id'		=> array('UINT', null, 'auto_increment'),
						'continent_code'	=> array('VCHAR:2', ''),
						'continent_name'	=> array('VCHAR_UNI', ''),
						'continent_person'	=> array('VCHAR_UNI', ''),
						'continent_people'	=> array('VCHAR_UNI', ''),
						'continent_adj'		=> array('VCHAR_UNI', ''),
						'continent_enabled'	=> array('BOOL', 1),
					),
					'PRIMARY_KEY'	=> 'continent_id',
					'KEYS'			=> array(
						'cn_code'	=> array('UNIQUE', 'continent_code'),
					),
				),
				$this->table_prefix . 'countries'	=> array(
					'COLUMNS'		=> array(
						'country_id'			=> array('UINT', null, 'auto_increment'),
						'continent_code'		=> array('VCHAR:2', ''),
						'country_code'			=> array('VCHAR:2', ''),
						'country_name'			=> array('VCHAR_UNI', ''),
						'country_lang'			=> array('VCHAR', ''),
						'country_localname'		=> array('VCHAR_UNI', ''),
						'country_fullname'		=> array('VCHAR_UNI', ''),
						'country_type'			=> array('VCHAR:1', ''),
						'country_person'		=> array('VCHAR_UNI', ''),
						'country_people'		=> array('VCHAR_UNI', ''),
						'country_adj'			=> array('VCHAR_UNI', ''),
						'country_parent'		=> array('VCHAR:2', ''),
						'country_unit'			=> array('VCHAR:2', ''),
						'country_capital'		=> array('VCHAR:6', ''),
						'country_iso_2'			=> array('VCHAR:2', ''),
						'country_iso_3'			=> array('VCHAR:3', ''),
						'country_currency'		=> array('VCHAR:3', ''),
						'country_phone_idd'		=> array('VCHAR:3', ''),
						'country_phone_code'	=> array('VCHAR', ''),
						'country_date'			=> array('VCHAR:12', ''),
						'country_flag'			=> array('VCHAR', ''),
						'country_timezone'		=> array('VCHAR', ''),
						'country_enabled'		=> array('BOOL', 1),
					),
					'PRIMARY_KEY'	=> 'country_id',
					'KEYS'			=> array(
						'ct_code'	=> array('UNIQUE', 'country_code'),
						'cn_code'	=> array('INDEX', 'continent_code'),
						'cu_code'	=> array('INDEX', 'country_unit'),
						'cr_code'	=> array('INDEX', 'country_currency'),
					),
				),
				$this->table_prefix . 'country_units'	=> array(
					'COLUMNS'		=> array(
						'unit_id'				=> array('UINT', null, 'auto_increment'),
						'country_code'			=> array('VCHAR:2', ''),
						'lv1_code'				=> array('VCHAR:2', ''),
						'lv2_code'				=> array('VCHAR:2', ''),
						'lv3_code'				=> array('VCHAR:2', ''),
						'unit_code'				=> array('VCHAR:2', ''),
						'unit_name'				=> array('VCHAR_UNI', ''),
						'unit_localname'		=> array('VCHAR_UNI', ''),
						'unit_othername'		=> array('VCHAR_UNI', ''),
						'unit_type'				=> array('VCHAR:2', ''),
						'unit_capital'			=> array('VCHAR:2', ''),
						'unit_lat ' . GDECIMAL	=> array('', 0),// Little hack to add new datatype :p
						'unit_lng ' . GDECIMAL	=> array('', 0),// Little hack to add new datatype :p
						'unit_currency'			=> array('VCHAR:3', ''),
						'unit_phone_code'		=> array('VCHAR', ''),
						'unit_date'				=> array('VCHAR:12', ''),
						'unit_flag'				=> array('VCHAR', ''),
						'unit_timezone'			=> array('VCHAR', ''),
						'unit_legend'			=> array('BOOL', 0),
						'unit_enabled'			=> array('BOOL', 1),
					),
					'PRIMARY_KEY'	=> 'unit_id',
					'KEYS'			=> array(
						'cu_code'	=> array('UNIQUE', 'unit_code'),
						'ct_code'	=> array('INDEX', 'country_code'),
						'l1_code'	=> array('INDEX', 'lv1_code'),
						'l2_code'	=> array('INDEX', 'lv2_code'),
						'l3_code'	=> array('INDEX', 'lv3_code'),
						'cr_code'	=> array('INDEX', 'unit_currency'),
					),
				),
				$this->table_prefix . 'languages'	=> array(
					'COLUMNS'		=> array(
						'lang_id'				=> array('UINT', null, 'auto_increment'),
						'lang_code'				=> array('VCHAR:3', ''),
						'script_code'			=> array('VCHAR:4', ''),
						'lang_name'				=> array('VCHAR_UNI', ''),
						'lang_localname'		=> array('VCHAR_UNI', ''),
						'lang_root'				=> array('VCHAR:3', ''),
						'lang_iso_1'			=> array('VCHAR:2', ''),
						'lang_iso_2t'			=> array('VCHAR:3', ''),
						'lang_iso_2b'			=> array('VCHAR:3', ''),
						'lang_iso_3'			=> array('VCHAR', ''),
						'lang_number_decimal'	=> array('VCHAR', ''),
						'lang_number_group'		=> array('VCHAR', ''),
						'lang_number_list'		=> array('VCHAR', ''),
						'lang_format_date'		=> array('VCHAR', ''),
						'lang_format_time'		=> array('VCHAR', ''),
						'lang_format_datetime'	=> array('VCHAR', ''),
						'lang_enabled'			=> array('BOOL', 1),
					),
					'PRIMARY_KEY'	=> 'lang_id',
					'KEYS'			=> array(
						'l_code'	=> array('UNIQUE', 'lang_code'),
						'ls_code'	=> array('INDEX', 'script_code'),
					),
				),
				$this->table_prefix . 'language_scripts'	=> array(
					'COLUMNS'		=> array(
						'script_id'			=> array('UINT', null, 'auto_increment'),
						'script_code'		=> array('VCHAR:4', ''),
						'script_name'		=> array('VCHAR_UNI', ''),
						'script_direction'	=> array('VCHAR:3', ''),
						'script_iso'		=> array('VCHAR:3', ''),
						'script_enabled'	=> array('BOOL', 1),
					),
					'PRIMARY_KEY'	=> 'script_id',
					'KEYS'			=> array(
						'ls_code'	=> array('UNIQUE', 'script_code'),
					),
				),
				$this->table_prefix . 'currencies'	=> array(
					'COLUMNS'		=> array(
						'currency_id'				=> array('UINT', null, 'auto_increment'),
						'currency_code'				=> array('VCHAR:3', ''),
						'currency_name'				=> array('VCHAR_UNI', ''),
						'currency_localname'		=> array('VCHAR_UNI', ''),
						'currency_fullname'			=> array('VCHAR_UNI', ''),
						'currency_local_fullname'	=> array('VCHAR_UNI', ''),
						'currency_iso'				=> array('VCHAR:3', ''),
						'currency_symbol'			=> array('VCHAR_UNI', ''),
						'currency_digits'			=> array('TINT:1', 0),
						'currency_enabled'			=> array('BOOL', 1),
					),
					'PRIMARY_KEY'	=> 'currency_id',
					'KEYS'			=> array(
						'cr_code'	=> array('UNIQUE', 'currency_code'),
					),
				),
			),
		);
	}

	/**
	* Drop the pages table schema from the database
	*
	* @return array Array of table schema
	* @access public
	*/
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'continents',
				$this->table_prefix . 'countries',
				$this->table_prefix . 'country_units',
				$this->table_prefix . 'languages',
				$this->table_prefix . 'language_scripts',
				$this->table_prefix . 'currencies',
			),
		);
	}
}
