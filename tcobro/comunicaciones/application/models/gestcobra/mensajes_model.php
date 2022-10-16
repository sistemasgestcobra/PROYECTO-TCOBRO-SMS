<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mensajes_model extends \Orm_model {

	public static $table = 'reporte_mensaje';

	/**
	 * @property integer $id
	 * @property string $detalle
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'detalle', 'type' => 'string')
	);

	public static $primary_key = 'id';

	
}

