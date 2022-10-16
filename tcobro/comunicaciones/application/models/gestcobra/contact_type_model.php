<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact_type_model extends \Orm_model {

	public static $table = 'contact_type';

	/**
	 * @property integer $id
	 * @property string $contact_name
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'contact_name', 'type' => 'string')
	);

	public static $primary_key = 'id';

}

