<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class oficina_company_model extends \Orm_model {

	public static $table = 'oficina_company';

	/**
	 * @property integer $id
	 * @property string $name
	 * @property string $direccion
	 * @property integer $company_id
	 * @property integer $status
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'name', 'type' => 'string'),
		array('name' => 'direccion', 'type' => 'string', 'allow_null' => true),
		array('name' => 'company_id', 'type' => 'int'),
		array('name' => 'status', 'type' => 'int')
	);

	public static $primary_key = 'id';

	/**
	 * @method company_model company() has_one
	 * @method company_model company() has_one
	 */
	public static $associations = array(
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id')
	);
}

