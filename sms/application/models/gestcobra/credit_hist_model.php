<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class credit_hist_model extends \Orm_model {

	public static $table = 'credit_hist';

	/**
	 * @property integer $id
	 * @property integer $credit_detail_id
	 * @property date $hist_date
	 * @property string $hist_time
	 * @property string $detail
	 * @property integer $credit_status_id
	 * @property date $compromiso_pago_date
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'credit_detail_id', 'type' => 'int'),
		array('name' => 'hist_date', 'type' => 'date', 'date_format' => 'Y-m-d'),
		array('name' => 'hist_time', 'type' => 'string'),
		array('name' => 'detail', 'type' => 'string', 'allow_null' => true),
		array('name' => 'credit_status_id', 'type' => 'int'),
		array('name' => 'compromiso_pago_date', 'type' => 'date', 'date_format' => 'Y-m-d'),
        array('name' => 'compromiso_max', 'type' => 'int'),
                array('name' => 'comision_id', 'type' => 'int', 'allow_null' => true),
                array('name' => 'oficial_credito_id', 'type' => 'int', 'allow_null' => true)
	);

	public static $primary_key = 'id';

	/**
	 * @method credit_detail_model credit_detail() has_one
	 * @method credit_status_model credit_status() has_one
	 * @method credit_detail_model credit_detail() has_one
	 * @method credit_status_model credit_status() has_one
	 */
	public static $associations = array(
		array('association_key' => 'credit_detail', 'model' => 'credit_detail_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_detail_id'),
		array('association_key' => 'credit_status', 'model' => 'credit_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_status_id'),
		array('association_key' => 'credit_detail', 'model' => 'credit_detail_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_detail_id'),
		array('association_key' => 'credit_status', 'model' => 'credit_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_status_id'),
                array('association_key' => 'comision_cobranzas', 'model' => 'comision_cobranzas_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'comision_id'),
                array('association_key' => 'oficial_credito', 'model' => 'oficial_credito_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'oficial_credito_id')
	);
}

