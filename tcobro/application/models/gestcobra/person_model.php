<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class person_model extends \Orm_model {

	public static $table = 'person';

	/**
	 * @property integer $id
	 * @property string $code
	 * @property string $firstname
	 * @property string $lastname
	 * @property string $personal_address
	 * @property string $work_address
	 * @property string $address_ref
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'code', 'type' => 'string', 'allow_null' => true),
		array('name' => 'firstname', 'type' => 'string'),
		array('name' => 'lastname', 'type' => 'string', 'allow_null' => true),
		array('name' => 'personal_address', 'type' => 'string', 'allow_null' => true),
		array('name' => 'work_address', 'type' => 'string', 'allow_null' => true),
		array('name' => 'address_ref', 'type' => 'string', 'allow_null' => true),
		array('name' => 'latitud', 'type' => 'float'),
                array('name' => 'longitud', 'type' => 'float')
	);

	public static $primary_key = 'id';

}

