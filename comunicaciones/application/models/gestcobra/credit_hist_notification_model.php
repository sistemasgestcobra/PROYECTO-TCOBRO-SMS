<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class credit_hist_notification_model extends \Orm_model {

	public static $table = 'credit_hist_notification';

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
                array('name' => 'contact_id', 'type' => 'string', 'allow_null' => true),
                array('name' => 'oficial_credito_id', 'type' => 'int'),
                array('name' => 'tipo_gestion_id', 'type' => 'int', 'allow_null' => true),
                array('name' => 'motivo_no_pago_id', 'type' => 'int', 'allow_null' => true),
                array('name' => 'valor_promesa', 'type' => 'string', 'allow_null' => true),
                array('name' => 'tiempo_gestion', 'string' => 'string', 'allow_null' => true),
                array('name' => 'oficina_company_id', 'type' => 'int', 'allow_null' => true),
            );

	public static $primary_key = 'id';

	/**
	 * @method credit_detail_model credit_detail() has_one
	 * @method credit_status_model credit_status() has_one
	 */
	public static $associations = array(
		array('association_key' => 'credit_detail', 'model' => 'credit_detail_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_detail_id'),
		array('association_key' => 'credit_status', 'model' => 'credit_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_status_id'),
                array('association_key' => 'tipo_gestion', 'model' => 'tipo_gestion_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'tipo_gestion_id'),
                array('association_key' => 'motivo_no_pago', 'model' => 'motivo_no_pago_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'motivo_no_pago_id'),
		array('association_key' => 'oficina_company', 'model' => 'oficina_company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'oficina_company_id'),
                array('association_key' => 'credit_detail', 'model' => 'credit_detail_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_detail_id'),
		array('association_key' => 'credit_status', 'model' => 'credit_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_status_id'),
                array('association_key' => 'tipo_gestion', 'model' => 'tipo_gestion_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'tipo_gestion_id'),
                array('association_key' => 'motivo_no_pago', 'model' => 'motivo_no_pago_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'motivo_no_pago_id'),
                array('association_key' => 'oficina_company', 'model' => 'oficina_company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'oficina_company_id')
	);
}

