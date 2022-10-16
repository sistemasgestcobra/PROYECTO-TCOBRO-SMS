<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class oficial_credito_model extends \Orm_model {

	public static $table = 'oficial_credito';

	/**
	 * @property integer $id
	 * @property string $cedula
	 * @property string $firstname
	 * @property string $lastname
	 * @property string $email
	 * @property string $telefono
	 * @property integer $oficina_company_id
	 * @property string $password
	 * @property integer $root
	 * @property integer $company_id
	 * @property integer $role_id
	 * @property integer $status
	 * @property string $profile_image
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'cedula', 'type' => 'string', 'allow_null' => true),
		array('name' => 'firstname', 'type' => 'string'),
		array('name' => 'lastname', 'type' => 'string', 'allow_null' => true),
		array('name' => 'email', 'type' => 'string', 'allow_null' => true),
		array('name' => 'telefono', 'type' => 'string', 'allow_null' => true),
		array('name' => 'oficina_company_id', 'type' => 'int', 'allow_null' => true),
		array('name' => 'password', 'type' => 'string', 'allow_null' => true),
		array('name' => 'root', 'type' => 'int'),
		array('name' => 'company_id', 'type' => 'int', 'allow_null' => true),
		array('name' => 'role_id', 'type' => 'int'),
		array('name' => 'status', 'type' => 'int'),
		array('name' => 'profile_image', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

	/**
	 * @method oficina_company_model oficina_company() has_one
	 * @method company_model company() has_one
	 * @method role_model role() has_one
	 * @method company_model company() has_one
	 * @method oficina_company_model oficina_company() has_one
	 * @method role_model role() has_one
	 * @method company_model company() has_one
	 * @method oficina_company_model oficina_company() has_one
	 */
	public static $associations = array(
		array('association_key' => 'oficina_company', 'model' => 'oficina_company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'oficina_company_id'),
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'role', 'model' => 'role_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'role_id'),
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'oficina_company', 'model' => 'oficina_company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'oficina_company_id'),
		array('association_key' => 'role', 'model' => 'role_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'role_id'),
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'oficina_company', 'model' => 'oficina_company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'oficina_company_id')
	);
}

