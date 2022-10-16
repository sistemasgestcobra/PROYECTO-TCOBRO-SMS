<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class alertas_model extends \Orm_model {

	public static $table = 'alertas';

	/**
	 * @property integer $id
	 * @property integer $credit_detail_id
	 * @property float $amount
	 * @property date $date_abono
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'usuario', 'type' => 'int'),
		array('name' => 'numero_operacion', 'type' => 'int'),
		array('name' => 'fechahora', 'type' => 'date', 'date_format' => 'Y-m-d H:i:s')
	);

	public static $primary_key = 'id';

	/**
	 * @method credit_detail_model credit_detail() has_one
	 * @method credit_detail_model credit_detail() has_one
	 */
	public static $associations = array(
		array('association_key' => 'credit_detail', 'model' => 'credit_detail_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_detail_id'),
		array('association_key' => 'credit_detail', 'model' => 'credit_detail_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_detail_id')
	);
}

