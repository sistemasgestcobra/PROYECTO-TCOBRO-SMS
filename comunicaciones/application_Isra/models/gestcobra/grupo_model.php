<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class grupo_model extends \Orm_model {

	public static $table = 'grupo';

	/**
	 * @property integer $id
	 * @property string $nombre
	 * @property integer $estado
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'nombre', 'type' => 'string'),
		array('name' => 'observaciones', 'type' => 'string'),
		
	);

	public static $primary_key = 'id';

	
}

