<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sessions_model extends \Orm_model {

	public static $table = 'sessions';

	/**
	 * @property string $session_id
	 * @property string $ip_address
	 * @property string $user_agent
	 * @property integer $last_activity
	 * @property string $user_data
	 */
	public static $fields = array(
		array('name' => 'session_id', 'type' => 'string'),
		array('name' => 'ip_address', 'type' => 'string'),
		array('name' => 'user_agent', 'type' => 'string'),
		array('name' => 'last_activity', 'type' => 'int'),
		array('name' => 'user_data', 'type' => 'string')
	);

	public static $primary_key = 'session_id';

}

