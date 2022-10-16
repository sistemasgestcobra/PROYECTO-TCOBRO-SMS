<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class setup_model extends \Orm_model {

	public static $table = 'setup';

	/**
	 * @property integer $id
	 * @property string $variable
	 * @property string $valor
	 * @property string $detail
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'variable', 'type' => 'string', 'allow_null' => true),
		array('name' => 'valor', 'type' => 'string', 'allow_null' => true),
		array('name' => 'detail', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

}

