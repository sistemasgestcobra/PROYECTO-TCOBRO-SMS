<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class company_model extends \Orm_model {

	public static $table = 'company';

	/**
	 * @property integer $id
	 * @property string $nombre_comercial
	 * @property string $direccion
	 * @property string $email
	 * @property string $telefono
	 * @property string $logo
	 * @property integer $company_status_id
	 * @property date $curr_date
	 * @property string $ruc
	 * @property string $razon_social
	 * @property string $representante_legal
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'nombre_comercial', 'type' => 'string'),
		array('name' => 'direccion', 'type' => 'string', 'allow_null' => true),
		array('name' => 'email', 'type' => 'string', 'allow_null' => true),
		array('name' => 'telefono', 'type' => 'string', 'allow_null' => true),
		array('name' => 'logo', 'type' => 'string', 'allow_null' => true),
		array('name' => 'company_status_id', 'type' => 'int'),
		array('name' => 'curr_date', 'type' => 'date', 'date_format' => 'Y-m-d'),
		array('name' => 'ruc', 'type' => 'string', 'allow_null' => true),
		array('name' => 'razon_social', 'type' => 'string', 'allow_null' => true),
		array('name' => 'usuario', 'type' => 'string', 'allow_null' => true),
		array('name' => 'pass', 'type' => 'string', 'allow_null' => true),
		array('name' => 'representante_legal', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

	/**
	 * @method company_status_model company_status() has_one
	 * @method company_status_model company_status() has_one
	 */
	public static $associations = array(
		array('association_key' => 'company_status', 'model' => 'company_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_status_id'),
		array('association_key' => 'company_status', 'model' => 'company_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_status_id')
	);
}

