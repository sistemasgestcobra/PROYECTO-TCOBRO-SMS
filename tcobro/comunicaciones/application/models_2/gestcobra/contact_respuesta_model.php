<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact_respuesta_model extends \Orm_model {

	public static $table = 'contact_respuesta';

	/**
	 * @property integer $id
	 * @property string $contact_name
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'respuesta_name', 'type' => 'string')
                
	);

	public static $primary_key = 'id';

}

