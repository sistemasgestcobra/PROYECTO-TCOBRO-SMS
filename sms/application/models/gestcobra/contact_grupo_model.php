<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact_grupo_model extends \Orm_model {

	public static $table = 'contact_grupo';

	/**
	 * @property integer $id
	 * @property integer $numero
	 * @property string $nombre
	 * @property string $apellido
	 * @property string $variable1
	 * @property string $variable2
	 * @property string $variable3
	 * @property string $variable4
	 * @property integer $id_grupo
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'numero', 'type' => 'string'),
		array('name' => 'nombre', 'type' => 'string', 'allow_null' => true),
		array('name' => 'apellido', 'type' => 'string','allow_null' => true),
		array('name' => 'variable1', 'type' => 'string','allow_null' => true),
		array('name' => 'variable2', 'type' => 'string','allow_null' => true),
		array('name' => 'variable3', 'type' => 'string','allow_null' => true),
		array('name' => 'variable4', 'type' => 'string','allow_null' => true),
		array('name' => 'id_grupo', 'type' => 'int'),
		array('name' => 'numero_operacion', 'type' => 'string','allow_null' => true)
		
		
	);

	public static $primary_key = 'id';

	/**
	 * @method contact_type_model contact_type() has_one
	 * @method person_model person() has_one
	 
	 * @method grupo_model grupo() has_one
	 */
	public static $associations = array(
//		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'grupo', 'model' => 'grupo_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'id_grupo')
	);
}

