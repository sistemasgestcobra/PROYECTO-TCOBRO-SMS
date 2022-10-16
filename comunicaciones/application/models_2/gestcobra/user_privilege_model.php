<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_privilege_model extends \Orm_model {

	public static $table = 'user_privilege';

	/**
	 * @property integer $id
	 * @property integer $privileges_id
	 * @property integer $oficial_credito_id
	 * @property date $from_date
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'privileges_id', 'type' => 'int'),
		array('name' => 'oficial_credito_id', 'type' => 'int'),
		array('name' => 'from_date', 'type' => 'date', 'date_format' => 'Y-m-d')
	);

	public static $primary_key = 'id';

	/**
	 * @method oficial_credito_model oficial_credito() has_one
	 * @method privileges_model privileges() has_one
	 */
	public static $associations = array(
		array('association_key' => 'oficial_credito', 'model' => 'oficial_credito_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'oficial_credito_id'),
		array('association_key' => 'privileges', 'model' => 'privileges_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'privileges_id')
	);
}

