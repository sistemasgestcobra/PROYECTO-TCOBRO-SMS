<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class motivo_no_pago_model extends \Orm_model {

	public static $table = 'motivo_no_pago';

	/**
	 * @property integer $id
	 * @property string $gestion_name
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'motivo_name', 'type' => 'string'),
                array('name' => 'company_id', 'type' => 'int', 'allow_null' => true)
	);

	public static $primary_key = 'id';

	
	public static $associations = array(
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id')
	);
}

