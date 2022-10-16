<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class comision_cobranzas_model extends \Orm_model {

	public static $table = 'comision_cobranzas';

	/**
	 * @property integer $id
	 * @property string $status_name
	 * @property string $color
	 * @property string $background
	 * @property integer $company_id
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'nombre_comision', 'type' => 'string'),
		array('name' => 'valor_comision', 'type' => 'float'),
		array('name' => 'company_id', 'type' => 'int')
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

