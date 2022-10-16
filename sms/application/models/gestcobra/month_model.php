<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class month_model extends \Orm_model {

	public static $table = 'month';

	/**
	 * @property integer $id
	 * @property string $month_name
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'month_name', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

}

