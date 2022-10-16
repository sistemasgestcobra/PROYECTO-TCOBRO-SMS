<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class credit_detail_model extends \Orm_model {

	public static $table = 'credit_detail';

	/**
	 * @property integer $id
	 * @property integer $nro_cuotas
	 * @property string $nro_pagare
	 * @property float $deuda_inicial
	 * @property float $saldo_actual
	 * @property date $adjudicacion_date
	 * @property integer $credito_type_id
	 * @property date $curr_date
	 * @property string $cuotas_pagadas
	 * @property string $cuotas_mora
	 * @property integer $dias_mora
	 * @property float $total_cuotas_vencidas
	 * @property integer $company_id
	 * @property integer $credit_status_id
	 * @property string $plazo_original
	 * @property date $last_pay_date
	 * @property integer $updated_month_id
	 * @property string $updated_year
	 * @property integer $oficial_credito_id
	 * @property date $load_date
	 * @property integer $oficina_company_id
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'nro_cuotas', 'type' => 'int'),
		array('name' => 'nro_pagare', 'type' => 'string'),
		array('name' => 'deuda_inicial', 'type' => 'float'),
		array('name' => 'saldo_actual', 'type' => 'float'),
		array('name' => 'adjudicacion_date', 'type' => 'date', 'date_format' => 'Y-m-d'),
		array('name' => 'credito_type_id', 'type' => 'int'),
		array('name' => 'curr_date', 'type' => 'date', 'date_format' => 'Y-m-d'),
		array('name' => 'cuotas_pagadas', 'type' => 'string', 'allow_null' => true),
		array('name' => 'cuotas_mora', 'type' => 'string', 'allow_null' => true),
		array('name' => 'dias_mora', 'type' => 'int', 'allow_null' => true),
		array('name' => 'total_cuotas_vencidas', 'type' => 'float'),
		array('name' => 'company_id', 'type' => 'int'),
		array('name' => 'credit_status_id', 'type' => 'int', 'allow_null' => true),
		array('name' => 'plazo_original', 'type' => 'string', 'allow_null' => true),
		array('name' => 'last_pay_date', 'type' => 'date', 'date_format' => 'Y-m-d', 'allow_null' => true),
		array('name' => 'updated_month_id', 'type' => 'int', 'allow_null' => true),
		array('name' => 'updated_year', 'type' => 'string', 'allow_null' => true),
		array('name' => 'oficial_credito_id', 'type' => 'int'),
		array('name' => 'load_date', 'type' => 'date', 'date_format' => 'Y-m-d'),
		array('name' => 'oficina_company_id', 'type' => 'int'),
                array('name' => 'gestor_id', 'type' => 'int', 'allow_null' => true),
                array('name' => 'total_comision', 'type' => 'float'),
                array('name' => 'comision_id', 'type' => 'int'),
                array('name' => 'total_pagar', 'type' => 'float', 'allow_null' => true)
	);

	public static $primary_key = 'id';

	/**
	 * @method client_model client() has_one
	 * @method credito_type_model credito_type() has_one
	 * @method company_model company() has_one
	 * @method credit_status_model credit_status() has_one
	 * @method month_model month() has_one
	 * @method client_model client() has_one
	 * @method company_model company() has_one
	 * @method credit_status_model credit_status() has_one
	 * @method credito_type_model credito_type() has_one
	 * @method month_model month() has_one
	 * @method credit_status_model credit_status() has_one
	 * @method company_model company() has_one
	 * @method credito_type_model credito_type() has_one
	 * @method month_model month() has_one
	 */
	public static $associations = array(
		array('association_key' => 'client', 'model' => 'client_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'client_id'),
		array('association_key' => 'credito_type', 'model' => 'credito_type_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credito_type_id'),
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'credit_status', 'model' => 'credit_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_status_id'),
		array('association_key' => 'month', 'model' => 'month_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'updated_month_id'),
		array('association_key' => 'client', 'model' => 'client_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'client_id'),
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'credit_status', 'model' => 'credit_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_status_id'),
		array('association_key' => 'credito_type', 'model' => 'credito_type_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credito_type_id'),
		array('association_key' => 'month', 'model' => 'month_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'updated_month_id'),
		array('association_key' => 'credit_status', 'model' => 'credit_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_status_id'),
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'credito_type', 'model' => 'credito_type_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credito_type_id'),
		array('association_key' => 'month', 'model' => 'month_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'updated_month_id'),
                array('association_key' => 'comision_cobranzas', 'model' => 'comision_cobranzas_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'comision_id')
	);
}

