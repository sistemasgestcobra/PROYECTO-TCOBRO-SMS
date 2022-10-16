<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reference_type_model extends \Orm_model {

	public static $table = 'reference_type';

	/**
	 * @property integer $id
	 * @property string $reference_name
	 * @property string $reference_desc
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'reference_name', 'type' => 'string'),
		array('name' => 'reference_desc', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

}

