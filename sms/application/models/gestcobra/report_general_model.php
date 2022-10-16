<?php

namespace gestcobra;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_general_model extends \Orm_model {

    public static $table = 'reporte_general_mensual';

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
        array('name' => 'cantidad', 'type' => 'int'),
        array('name' => 'capital', 'type' => 'float'),
        array('name' => 'cantidad_recuperada', 'type' => 'int'),
        array('name' => 'capital_recuperada', 'type' => 'float'),
        array('name' => 'cantidad_x_recuperar', 'type' => 'int'),
        array('name' => 'capital_x_recuperar', 'type' => 'float'),
        array('name' => 'mes_id', 'type' => 'int', 'allow_null' => true),
		array('name' => 'oficina_company_id', 'type' => 'int', 'allow_null' => true)
    );
    public static $primary_key = 'id';

    /**
     * @method month_model month() has_one
     */
    public static $associations = array(
        array('association_key' => 'month', 'model' => 'month_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'mes_id'),
		array('association_key' => 'oficina_company', 'model' => 'oficina_company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'oficina_company_id')
        
    );

}
