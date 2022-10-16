<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class comunication_model extends \Orm_model {

	public static $table = 'comunication';

	/**
	 * @property integer $id
	 * @property string $type
	 * @property integer $status
	 * @property float $cost
	 * @property string $contact
	 * @property date $curr_date
	 * @property string $curr_time
	 * @property integer $user_id
	 * @property string $network
	 * @property integer $comunication_type_id
	 * @property integer $client_referencias_id
	 * @property integer $notification_format_id
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'type', 'type' => 'string'),
		array('name' => 'status', 'type' => 'int'),
		array('name' => 'detalle_notificacion', 'type' => 'string', 'allow_null' => true),
		array('name' => 'contact', 'type' => 'string'),
		array('name' => 'curr_date', 'type' => 'date', 'date_format' => 'Y-m-d'),
		array('name' => 'curr_time', 'type' => 'string'),
		array('name' => 'user_id', 'type' => 'int'),
		array('name' => 'notificador', 'type' => 'string', 'allow_null' => true),
		array('name' => 'comunication_type_id', 'type' => 'int'),
		array('name' => 'client_referencias_id', 'type' => 'int'),
		array('name' => 'notification_format_id', 'type' => 'int', 'allow_null' => true),
		array('name' => 'fecha_entrega', 'type' => 'date', 'date_format' => 'Y-m-d', 'allow_null' => true),
		array('name' => 'hora_entrega', 'type' => 'string', 'allow_null' => true),
                array('name' => 'credit_status_id', 'type' => 'int', 'allow_null' => true),
                array('name' => 'tipo_gestion_id', 'type' => 'int', 'allow_null' => true),
                array('name' => 'motivo_no_pago_id', 'type' => 'int', 'allow_null' => true),
                array('name' => 'compromiso_pago_date', 'type' => 'date', 'date_format' => 'Y-m-d'),
                array('name' => 'valor_promesa', 'type' => 'string', 'allow_null' => true),
                array('name' => 'contact_id', 'type' => 'string', 'allow_null' => true)
	);

	public static $primary_key = 'id';

	/**
	 * @method credit_detail_model credit_detail() has_one
	 * @method oficial_credito_model oficial_credito() has_one
	 * @method client_referencias_model client_referencias() has_one
	 * @method comunication_type_model comunication_type() has_one
	 * @method oficial_credito_model oficial_credito() has_one
	 * @method notification_format_model notification_format() has_one
	 * @method comunication_type_model comunication_type() has_one
	 * @method client_referencias_model client_referencias() has_one
	 * @method notification_format_model notification_format() has_one
	 * @method oficial_credito_model oficial_credito() has_one
	 */
	public static $associations = array(
		array('association_key' => 'credit_detail', 'model' => 'credit_detail_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_detail_id'),
		array('association_key' => 'oficial_credito', 'model' => 'oficial_credito_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'user_id'),
		array('association_key' => 'client_referencias', 'model' => 'client_referencias_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'client_referencias_id'),
		array('association_key' => 'comunication_type', 'model' => 'comunication_type_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'comunication_type_id'),
		array('association_key' => 'oficial_credito', 'model' => 'oficial_credito_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'user_id'),
		array('association_key' => 'notification_format', 'model' => 'notification_format_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'notification_format_id'),
		array('association_key' => 'comunication_type', 'model' => 'comunication_type_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'comunication_type_id'),
		array('association_key' => 'client_referencias', 'model' => 'client_referencias_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'client_referencias_id'),
		array('association_key' => 'notification_format', 'model' => 'notification_format_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'notification_format_id'),
		array('association_key' => 'oficial_credito', 'model' => 'oficial_credito_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'user_id'),
                array('association_key' => 'credit_status', 'model' => 'credit_status_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'credit_status_id')
	);
}

