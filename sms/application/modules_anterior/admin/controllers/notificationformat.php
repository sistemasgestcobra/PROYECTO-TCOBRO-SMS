<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Notificationformat extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Ignorar los abortos hechos por el usuario y permitir que el script
        // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
        ignore_user_abort(true);
        set_time_limit(0);
        $this->load->library('comunications/commws');
    }

    public function get_report() {
        $this->load->model('notificationformat_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = 100;
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $this->notificationformat_model->get_data($limit, $offset, $filter, $order_by);
        $total = $this->notificationformat_model->get_count($filter);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }

    public function edit_template($id = 0) {
        $res['id'] = $id;
        $res['view_name'] = 'admin/ml_notification_format_template';
        $this->load->view('common/templates/dashboard', $res);
    }

    public function notification_print($id = 0, $credit_id = 0) {
        $notif_visita_id = set_post_value('notif_visita_id');
        $notification_id = set_post_value('notification_id');
        $notif_id = set_post_value('notif_id');
        $notificacion = new gestcobra\notification_format_model($notif_id[0]);
        
        if (($notification_id == 'com_masiva')AND ( ($notificacion->type != 'NOTIFICACION'))) {
            $mensaje_cliente = '';
            if ($notificacion->type == 'MENSAJE') {
                $mensaje_cliente = $notificacion->format;
            } elseif ($notif_id[0] == '-1') {
                $mensaje_cliente = set_post_value('mensaje_cliente');
            }
            $this->mensajes_masivos($mensaje_cliente);
        } else {
            $res['id'] = set_post_value('notification_id', $id);            
            $res['credit_id'] = $credit_id;
            /**
             * Cuando se selecciona varios creditos para generar notificacion
             */
            
            if ($credit_id == 0) {
                $res['credit_id'] = $credit_id;
                $res['c_d_id'] = set_post_value('c_d_id');
            }
            
            $this->load->helper(array('dompdf_helper', 'file'));               
            $html = $this->load->view('admin/ml_notification_print', $res, true);
            pdf_create($html, 'notificacion');
            $this->notifications_save();   
        }
    }

    /**
     * 
     * @param type $type
     * @param type $creditdetail_id
     * @param type $status
     * @param type $cost
     * @param type $contact
     * @param type $network
     * @return type
     */
    private function save_comunication($type, $creditdetail_id, $status, $cost, $contact, $network, $client_referencia, $notification_format_id) {
        $comunication_type = (new gestcobra\comunication_type_model())
                ->where('comunication_code', $type)
                ->find_one();
        $comunication = new gestcobra\comunication_model();
        $comunication->type = $type;
        $comunication->status = $status;
        $comunication->cost = $cost;
        $comunication->contact = $contact;
        $comunication->curr_date = date("Y-m-d", time());
        $comunication->curr_time = date("H:i:s", time());
        $comunication->network = $network;
        $comunication->user_id = $this->user->id;
        $comunication->comunication_type_id = $comunication_type->id;
        $comunication->client_referencias_id = $client_referencia->id;
        $comunication->notification_format_id = $notification_format_id;
        $comunication->save();
        return $comunication->id;
    }

    public function notifications_save() {
        $notification_id_notification = set_post_value('notification_id');
        $notif_id = set_post_value('notif_id');
        $message_format = $notif_id[0];
        $credit_detail_check = set_post_value('c_d_id');
        $reference_type_ids = set_post_value('reference_type_model');
        if($credit_detail_check){
            foreach ($credit_detail_check as $credit_det) {
                $credit_data = new \gestcobra\credit_detail_model($credit_det);
                $array_persons_id = array();
                $referencias = (new \gestcobra\client_referencias_model())
                        ->where('status', 1)
                        ->where('credit_detail_id', $credit_det)
                        ->where_in('reference_type_id', $reference_type_ids)
                        ->find();
                $referencia_deudor = (new \gestcobra\client_referencias_model())
                        ->where('status', 1)
                        ->where('credit_detail_id', $credit_data->id)
                        ->where_in('reference_type_id', '3')
                        ->find_one();
                $get_company = new gestcobra\company_model($this->user->company_id);
                foreach ($referencias as $ref) {
                    array_push($array_persons_id, $ref->person_id);
                }
                $this->save_comunication('visita', $credit_det, '-1', '', "visita", '', $referencia_deudor, $notification_id_notification);
            }
            successAlert(lang('ml_success_msg'), lang('ml_success'));
        }
    }

    public function notifications_update() {
        $c_id_notification = set_post_value('c_id_notification');
        $notification_id_notification = set_post_value('notif_visita_id');
        $status = '';
        if ($c_id_notification) {
            if ($notification_id_notification == 'notif_entregada') {
                $status = '0';
            } else {
                $status = '-1';
            }
            $this->db->where_in('id', $c_id_notification);
            $this->db->update('comunication', array('status' => $status));           
        }
        ?>
            <script>
                $("#table_notif").bootstrapTable('refresh');
            </script>
            <?php
            successAlert(lang('ml_success_msg'), lang('ml_success'));
    }

    public function update_comunicacion_new() {
        $id=set_post_value('id');
        $uno=set_post_value('detalle_notificacion');
        $dos=set_post_value('notificador');
        $tres=  set_post_value('fecha_entrega');
        $cuatro = set_post_value('hora_entrega');
        $cinco=set_post_value('credit_status_id');
        $seis=set_post_value('tipo_gestion_id');
        $siete=set_post_value('motivo_no_pago_id');
       

        if (set_post_value('compromiso_pago_date')=='' or set_post_value('compromiso_pago_date')==NULL) {
                $fecha=  date(0000-00-00);
                $ocho = $fecha;                               
            }else{
                $ocho = set_post_value('compromiso_pago_date');
            }
        
        $nueve=set_post_value('valor_promesa');
        $dies=set_post_value('contact_id');
        
        if($uno=="ac"||$uno=="AC"){
            $this->update_direccion();
        }elseif ($uno != "ac"||$uno!="AC"){
        $this->db->where_in('id', $id);
        $this->db->update('comunication', array('detalle_notificacion' => $uno,
        'notificador'=>$dos, 'fecha_entrega'=>$tres, 'hora_entrega'=>$cuatro,
        'credit_status_id'=>$cinco, 'tipo_gestion_id'=>$seis, 'motivo_no_pago_id'=>$siete,
        'compromiso_pago_date'=>$ocho, 'valor_promesa'=>$nueve, 'contact_id'=>$dies
             ));
            
            $this->save_contact();
            $this->update_direccion();
        }
        ?>
            <script>
                $("#table_clients_notification").bootstrapTable('refresh');
            </script>
            <?php
        
        successAlert(lang('ml_success_msg'), lang('ml_success'));
        
        
    }
    
    public function save_contact(){
            $contact = new gestcobra\contact_model();
            $id=set_post_value('id');
            $numero=set_post_value('contact_id');
            
            if(!empty($numero) AND $numero !=null){
            $contact->contact_value=set_post_value('contact_id');
            $contact->description='Número de Contacto Nuevo';            
            $comunication= (new gestcobra\comunication_model())
                ->where_in('id',$id)
                ->find_one();
            
            $ref=$comunication->client_referencias_id;           
            $cliente_ref=(new gestcobra\client_referencias_model())
                ->where('id',$ref)
                ->find_one();
                
            $person_id=$cliente_ref->person_id;           
            $contact->person_id=$person_id;
            
            if(strlen($numero)>0 && strlen($numero)<=7) {
                $contact->contact_type_id=1;             
            }  else 
                if(strlen($numero)==9 || strlen($numero)==10){
                $contact->contact_type_id=2;
            }
            
            $contact->contact_respuesta_id=2;
            $contact->save();
            }
        }
        
        public function update_direccion(){
            $id=set_post_value('id');
            $direccion=set_post_value('personal_address');
            
            if(!empty($direccion) AND $direccion !=null){
            $comunication= (new gestcobra\comunication_model())
                ->where_in('id',$id)
                ->find_one();           
            $ref=$comunication->client_referencias_id;
            
            $cliente_ref=(new gestcobra\client_referencias_model())
                ->where('id',$ref)
                ->find_one();             
            $person_id=$cliente_ref->person_id;
            
           
            $this->db->where_in('id', $person_id);
            $this->db->update('person', array('personal_address' => $direccion));
            }
        }
            
    public function mensajes_masivos($mensaje_cliente) {
        $notif_id = set_post_value('notif_id');
        $message_format = $notif_id[0];
        $obj_commws = new Commws();
        $from = 1234;
        $type_phone = 'voice';
        $notification_id_notification = set_post_value('notification_id');
        //=================================================================================
        $comunicacion_opt_client = set_post_value('comunicacion_opt_client');
        $credit_detail_check = set_post_value('c_d_id');  
        $mensaje_cliente = $mensaje_cliente;
        $reference_type_ids = set_post_value('reference_type_model');
        $mensajes= array();
        $numeros=array();
        if ($comunicacion_opt_client AND $credit_detail_check AND ! empty($mensaje_cliente)) {
            
            $i = 0;
            foreach ($credit_detail_check as $credit_det) {
                
                $credit_data = new \gestcobra\credit_detail_model($credit_det);
                
                $array_persons_id = array();
                $referencias = (new \gestcobra\client_referencias_model())
                        ->where('status', 1)
                        ->where('credit_detail_id', $credit_det)
                        ->where_in('reference_type_id', $reference_type_ids)
                        ->find();

                $referencia_deudor = (new \gestcobra\client_referencias_model())
                        ->where('status', 1)
                        ->where('credit_detail_id', $credit_data->id)
                        ->where_in('reference_type_id', '3')
                        ->find_one();

                $get_company = new gestcobra\company_model($this->user->company_id);

                foreach ($referencias as $ref) {
                    array_push($array_persons_id, $ref->person_id);
                }

                $person_data = new gestcobra\person_model($referencia_deudor->person_id);

                $COMPANY_NAME = '';
                $DEUDOR_NAME = '';
                $SOCIO_NUMERO = '';
                $PAGARE_NUEMERO = '';
                $DEUDA_INICIAL = '';
                $SALDO_ACTUAL = '';
                $FECHA_ADJUDICACION = '';
                $CUOTAS_PAGADAS = '';
                $CUOTAS_MORA = '';
                $DIAS_MORA = '';
                $TOTAL_CUOTAS_VENCIDAS = '';
                $PLAZO_ORIGINAL = '';
                $FECHA_ULTIMO_PAGO = '';

                $COMPANY_NAME = $get_company->nombre_comercial;
                $DEUDOR_NAME = $person_data->firstname;
                $SOCIO_NUMERO = $credit_data->nro_cuotas;
                $PAGARE_NUEMERO = $credit_data->nro_pagare;
                $DEUDA_INICIAL = $credit_data->deuda_inicial;
                $SALDO_ACTUAL = $credit_data->saldo_actual;
                $FECHA_ADJUDICACION = $credit_data->adjudicacion_date;
                $CUOTAS_PAGADAS = $credit_data->cuotas_pagadas;
                $CUOTAS_MORA = $credit_data->cuotas_mora;
                $DIAS_MORA = $credit_data->dias_mora;
                $TOTAL_CUOTAS_VENCIDAS = $credit_data->total_cuotas_vencidas;
                $PLAZO_ORIGINAL = $credit_data->plazo_original;
                $FECHA_ULTIMO_PAGO = $credit_data->last_pay_date;
                $mensaje='';
                $mensaje = $mensaje_cliente;
                $mensaje = str_replace('COMPANY_NAME', $COMPANY_NAME, $mensaje);
                $mensaje = str_replace('DEUDOR_NAME', $DEUDOR_NAME, $mensaje);
                $mensaje = str_replace('SOCIO_NUMERO', $SOCIO_NUMERO, $mensaje);
                $mensaje = str_replace('PAGARE_NUEMERO', $PAGARE_NUEMERO, $mensaje);
                $mensaje = str_replace('DEUDA_INICIAL', $DEUDA_INICIAL, $mensaje);
                $mensaje = str_replace('SALDO_ACTUAL', $SALDO_ACTUAL, $mensaje);
                $mensaje = str_replace('FECHA_ADJUDICACION', $FECHA_ADJUDICACION, $mensaje);
                $mensaje = str_replace('CUOTAS_PAGADAS', $CUOTAS_PAGADAS, $mensaje);
                $mensaje = str_replace('CUOTAS_MORA', $CUOTAS_MORA, $mensaje);
                $mensaje = str_replace('DIAS_MORA', $DIAS_MORA, $mensaje);
                $mensaje = str_replace('TOTAL_CUOTAS_VENCIDAS', $TOTAL_CUOTAS_VENCIDAS, $mensaje);
                $mensaje = str_replace('PLAZO_ORIGINAL', $PLAZO_ORIGINAL, $mensaje);
                $mensaje = str_replace('FECHA_ULTIMO_PAGO', $FECHA_ULTIMO_PAGO, $mensaje);
                $contact_model = false;
                if (count($array_persons_id) > 0) {
                    $contact_model = (new gestcobra\contact_model())
                            ->where_in('person_id', $array_persons_id)
                            ->find();
                }

                if ($contact_model) {
                    foreach ($contact_model as $value) {

                        $client_referencias = (new gestcobra\client_referencias_model())
                                ->where('person_id', $value->person_id)
                                ->where('credit_detail_id', $credit_det)
                                ->find_one();

                        $nombre_persona = new gestcobra\person_model($value->person_id);
                        $NOMBRE_PERSONA = '';
                        $NOMBRE_PERSONA = $nombre_persona->firstname;
                        
                        $mensaje = str_replace('NOMBRE_PERSONA', $NOMBRE_PERSONA, $mensaje);
                       
                        $mensaje_final = $mensaje;
                        foreach ($comunicacion_opt_client as $value_sms) {
                            $tipo_contacto_ofic = $value->contact_type_id;
                            $contacto_value = $value->contact_value;
                            
                            if ($contacto_value{0} == '0') {
                                $contacto_value_nuevo = substr($contacto_value, 1);
                            } else {
                                $contacto_value_nuevo = $contacto_value;
                            }
                            
                            //acciones
                            $value_type = '';
                            
                            if (($value_sms == 'com_sms' AND $tipo_contacto_ofic == 2) OR ( $value_sms == 'com_call' AND ( $tipo_contacto_ofic == 2 OR $tipo_contacto_ofic == 1))) {
                                $from = $i;
                                $obj_commws->set_url_ws('http://localhost/comunicaciones/ws_sms/examplews/send');
                                if ($value_sms == 'com_sms') {
                                    $type_phone = 'text';
                                    $value_type = $value_sms;
                                    echo $value_type;
                                } else {
                                    $type_phone = 'voice';
                                    $value_type = $value_sms;
                                }
                            } elseif ($value_sms == 'com_whatsapp' AND $tipo_contacto_ofic == 2) {
                                $obj_commws->set_url_ws('http://localhost/comunicaciones/ws_whatsapp/testWA/send');
                                $value_type = $value_sms;
                            } elseif ($value_sms == 'com_email' AND $tipo_contacto_ofic == 3) {
                                $obj_commws->set_url_ws('http://localhost/comunicaciones/ws_email/EmailSend/sendMailGmail');
                                $from = 'gestcobracom@gmail.com';
                                $value_type = $value_sms;
                            }
                            
                            
                            if (!$value_type == '') {
                            if ($value_sms == 'com_sms') {
                                  $status = 1;
                                    if ($message_format == -1) {$message_format = 1;}
                                    $contact_completo = '593' . $contacto_value_nuevo;
                                    array_push($mensajes, $mensaje_final);
                                    array_push($numeros, $contact_completo);
                                    
                                    $this->save_comunication_ac($value_sms, $referencia_deudor->id, $status, $contact_completo, $message_format);

									//$this->save_hist($credit_det);
                                }
                                if ($value_sms != 'com_sms') {
                                 $obj_commws->http_conn_comunication(
                                        $from, 
                                        $contacto_value_nuevo, 
                                        $mensaje_final, 
                                        $value_type, 
                                        $type_phone, 
                                        'AsDfG12345'
                                );
                                  }
                                
                                $notification_format_id = null;
                                if ($message_format != '-1') {
                                    $notification_format_id = $message_format;
                                }
                                
                            }
                        }
                    }
                    
                }
                
                $i ++;
            }
            
            if (!empty($mensajes)) {
			
                $message = array(
                    "Mensaje"=>"Hola",
                    "Mensajes"=>$mensajes,
                    "Destinatarios"=>$numeros,
                    "apiKey"=>" 3D78493FB7"
                );
           $var=   $obj_commws->http_conn_comunication_1($message);
			//var_dump($message);
		$num=count($numeros);
			  $this->envio_hist("MENSAJES MASIVO",$num,0);    
             }
			 
			 successAlert(lang('ml_success_msg'), lang('ml_success'));

			 
        }
    }
    //==========================================================================================
    public function respuesta_ws($sms_resp_json_masivos, $value_sms, $credit_detail_id, $contacto_value, $client_referencias, $notification_format_id) {
        
        if ($sms_resp_json_masivos != null) {
            $type = $value_sms;
            $cost = 0;
            $network = "";
            if (($value_sms == 'com_whatsapp' OR $value_sms == 'com_email')) {
                if (($sms_resp_json_masivos == 'true' OR $sms_resp_json_masivos == '1')AND $sms_resp_json_masivos != 'false') {
                    $status = '0';
                } else {
                    $status = '-1';
                }
            }
            if ($value_sms == 'com_call') {
                if ($sms_resp_json_masivos == 'false') {
                    $status = '-1';
                } else {
                    $sms_resp_json_masivos = json_decode($sms_resp_json_masivos, true);
                    $status = $sms_resp_json_masivos["status"];
                    $network = $sms_resp_json_masivos["error_text"];
                }
            }
            if ($value_sms == 'com_sms') {
                if ($sms_resp_json_masivos == 'false') {
                    $status = '-1';
                } else {
                    $sms_resp_json_masivos = json_decode($sms_resp_json_masivos, true);
                    $status = $sms_resp_json_masivos["messages"][0]["status"];
                    $cost = $sms_resp_json_masivos["messages"][0]["message-price"];
                    $network = $sms_resp_json_masivos["messages"][0]["network"];
                }
            }
            $this->save_comunication($type, $credit_detail_id, $status, $cost, $contacto_value, $network, $client_referencias, $notification_format_id);
        }
    }

    public function save(){
        $id = set_post_value('id');
        $lote = set_post_value('lote');
        if ($lote == 1) {
            $this->save_update();
        } else {
            $notification_format = new \gestcobra\notification_format_model($id);
            $notification_format->format = set_post_value('template_data');
            $notification_format->company_id = $this->user->company_id;
            $notification_format->save();
            successAlert(lang('ml_success_msg'), lang('ml_success'));
        }
    }

    public function save_update(){
        $ids = set_post_value('id');
        $description = set_post_value('description');
        $type = set_post_value('type');
        $activo = set_post_value('notification_format_status');
        $cont = 0;
        $this->db->where_not_in( 'id', $ids); 
        $this->db->where('company_id', $this->user->company_id);
        echo 'company_id';
        echo $this->user->company_id;
        $this->db->update('notification_format', array('status'=>'-1') );    
        foreach ($ids as $value){
            $notification = new gestcobra\notification_format_model($value);
            if (!empty($description[$cont]) AND $description[$cont] != 'undefined' AND $description[$cont] != 'null') {
                $notification->description = $description[$cont];
                $notification->type = $type[$cont];
                $notification->status = '1';
                $notification->company_id = $this->user->company_id;
//                $notification->format = $template_data[$cont];
                $notification->save();
                $cont++;
            }
        }
        //=========================================================================
                            
        echo $this->db->last_query();
        //=========================================================================
        successAlert(lang('ml_success_msg'), lang('ml_success'));
        ?>
        <script>
            $("#table_notif").bootstrapTable('refresh');
        </script>
        <?php
    }
    
    public function open_view($id){
        $res['id'] = $id;
        $this->load->view('ml_notification_message', $res);
    }
	public function open_view2($id){
        $res['id'] = $id;
        $this->load->view('ml_notification_message_1', $res);
    }
	private function save_comunication_ac($type, $referencia, $status, $contact, $notification_format_id) {

        $comunication_type = (new gestcobra\comunication_type_model())
                ->where('comunication_code', $type)
                ->find_one();

        $comunication = new gestcobra\comunication_model();
        $comunication->type = $comunication_type->comunication_name;
        $comunication->status = $status;
        $comunication->contact = $contact;
        $comunication->curr_date = date("Y-m-d", time());
        $comunication->curr_time = date("H:i:s", time());
        $comunication->user_id = $this->user->id;
        $comunication->comunication_type_id = $comunication_type->id;
        $comunication->client_referencias_id = $referencia;
        $comunication->notification_format_id = $notification_format_id;
        $comunication->save();
        return $comunication->id;

    }


private function save_hist($credit_detail_id) {      
        $credti_hist = new gestcobra\credit_hist_model();
        $credti_hist->credit_detail_id = $credit_detail_id;
        $credti_hist->detail = 'ENVIO DE MENSAJE DE TEXTO';
        $credti_hist->hist_date = date('Y-m-d', time());
        $credti_hist->hist_time = date('H:i:s', time());
        $credti_hist->credit_status_id = 8;
        $credti_hist->oficial_credito_id = $this->user->id;
        $credti_hist->comision_id = 7;
        $credti_hist->compromiso_max = 0;
        $credti_hist->compromiso_pago_date = date(0000 - 00 - 00);
        $credti_hist->save();      
    }
    
	//ENVIO hist
	
	function envio_hist($detail,$enviados,$num_malos) {
	
		
        $envio= new \gestcobra\envio_hist_model();
        $envio->hist_date = date('Y-m-d', time());
        $envio->hist_time = date('H:i:s', time());
        $envio->detail=$detail;
        $envio->enviados=$enviados;
        $envio->excluidos=count($num_malos);
		
		$oficial = (new gestcobra\oficial_credito_model())
			->where('id', $this->user->id)
			->find_one();
			
		$usuario= $oficial->firstname;
		
		$envio->usuario=$usuario;
		
        $envio->save();
    }
	
}
