<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class privileges_model extends \Orm_model {

	public static $table = 'privileges';

	/**
	 * @property integer $id
	 * @property string $privilege_name
	 * @property string $privilege_desc
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'privilege_name', 'type' => 'string'),
		array('name' => 'privilege_desc', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

}

