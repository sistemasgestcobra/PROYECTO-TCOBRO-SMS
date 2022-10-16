<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class client_referencias_model extends \Orm_model {

	public static $table = 'client_referencias';

	/**
	 * @property integer $id
	 * @property string $client_code
	 * @property integer $person_id
	 * @property integer $reference_type_id
	 * @property integer $status
	 * @property integer $credit_detail_id
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'client_code', 'type' => 'string', 'allow_null' => true),
		array('name' => 'person_id', 'type' => 'int'),
		array('name' => 'reference_type_id', 'type' => 'int'),
		array('name' => 'status', 'type' => 'int'),
		array('name' => 'credit_detail_id', 'type' => 'int')
	);

	public static $primary_key = 'id';

	/**
	 * @method client_model client() has_one
	 * @method person_model person() has_one
	 * @method reference_type_model reference_type() has_one
	 * @method client_model client() has_one
	 * @method person_model person() has_one
	 * @method reference_type_model reference_type() has_one
	 * @method credit_detail_model credit_detail() has_one
	 * @method credit_detail_model credit_detail() has_one
	 */
	public static $associations = array(
		array('association_key' => 'client', 'model' => 'client_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'client_id'),
		array('association_key' => 'person', 'model' => 'person_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'person_id'),
		array('association_key' => 'reference_type', 'model' => 'reference_type_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'reference_type_id'),
		array('association_key' => 'client', 'model' => 'client_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'client_id'),
		array('association_key' => 'person', 'model' => 'person_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'person_id'),
		array('association_key' => 'reference_type', 'model' => 'reference_type_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'reference_type_id'),
		array('association_key' => 'credit_detail', 'model' => 'credit_detail_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_detail_id'),
		array('association_key' => 'credit_detail', 'model' => 'credit_detail_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_detail_id')
	);
}

