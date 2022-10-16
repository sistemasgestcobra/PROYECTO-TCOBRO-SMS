<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class company_status_model extends \Orm_model {

	public static $table = 'company_status';

	/**
	 * @property integer $id
	 * @property string $company_status
	 * @property string $status_description
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'company_status', 'type' => 'string'),
		array('name' => 'status_description', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

}

