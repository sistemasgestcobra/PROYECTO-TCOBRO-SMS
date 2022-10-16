<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class comunication_type_model extends \Orm_model {

	public static $table = 'comunication_type';

	/**
	 * @property integer $id
	 * @property string $comunication_name
	 * @property string $comunication_code
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'comunication_name', 'type' => 'string', 'allow_null' => true),
		array('name' => 'comunication_code', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

}

