<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact_model extends \Orm_model {

	public static $table = 'contact';

	/**
	 * @property integer $id
	 * @property string $contact_value
	 * @property string $description
	 * @property integer $person_id
	 * @property integer $contact_type_id
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'contact_value', 'type' => 'string'),
		array('name' => 'description', 'type' => 'string', 'allow_null' => true),
		array('name' => 'person_id', 'type' => 'int'),
		array('name' => 'contact_type_id', 'type' => 'int'),
		array('name' => 'contact_respuesta_id', 'type' => 'int')
	);

	public static $primary_key = 'id';

	/**
	 * @method contact_type_model contact_type() has_one
	 * @method person_model person() has_one
	 * @method contact_type_model contact_type() has_one
	 * @method person_model person() has_one
	 */
	public static $associations = array(
		array('association_key' => 'contact_type', 'model' => 'contact_type_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'contact_type_id'),
		array('association_key' => 'person', 'model' => 'person_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'person_id'),
		array('association_key' => 'contact_respuesta', 'model' => 'contact_respuesta_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'contact_respuesta_id'),
		array('association_key' => 'contact_type', 'model' => 'contact_type_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'contact_type_id'),
		array('association_key' => 'person', 'model' => 'person_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'person_id'),
		array('association_key' => 'contact_respuesta', 'model' => 'contact_respuesta_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'contact_respuesta_id')
	);
}

