<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class role_model extends \Orm_model {

	public static $table = 'role';

	/**
	 * @property integer $id
	 * @property string $role_name
	 * @property string $role_desc
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'role_name', 'type' => 'string', 'allow_null' => true),
		array('name' => 'role_desc', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

}

