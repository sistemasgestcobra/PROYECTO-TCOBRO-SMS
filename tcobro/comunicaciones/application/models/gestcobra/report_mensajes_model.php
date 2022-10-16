<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report_mensajes_model extends \Orm_model {

	public static $table = 'reporte_envio';

	/**
	 * @property integer $id
	 * @property integer $numero
	 * @property float $fecha_envio
	 * @property string $hora_envio
	 * @property string $estado
	 * @property int $id_mensaje
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'numero', 'type' => 'string'),
		array('name' => 'fecha_envio', 'type' => 'date', 'date_format' => 'Y-m-d'),
		array('name' => 'hora_envio',  'type' => 'string'),
                array('name' => 'estado', 'type' => 'string'),
                array('name' => 'id_mensaje', 'type' => 'string'),
	);

	public static $primary_key = 'id';

	
	public static $associations = array(
		array('association_key' => 'reporte_mensaje', 'model' => 'report_mensaje_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'id_mensaje')
	);
}

