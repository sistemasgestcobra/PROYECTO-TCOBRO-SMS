<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Credit extends CI_Controller {
	function __construct() {
 		parent::__construct();
                // Ignorar los abortos hechos por el usuario y permitir que el script
                // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
                ignore_user_abort(true);  
                $this->load->library('comunications/commws');
                set_time_limit(0);
	}
        
        public function get_credit_detail_report($client_id, $compromiso_pago_date = 0){
            $this->load->model('credit_detail_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->credit_detail_model->get_credit_detail_data( $limit, $offset, $filter, $order_by, $client_id, $compromiso_pago_date );
            $total = $this->credit_detail_model->get_credit_detail_count( $filter, $client_id, $compromiso_pago_date );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
		
	public function get_credit_detail_report_f($client_id,$max,$min){            
            $this->load->model('credit_detail_model_f');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->credit_detail_model_f->get_credit_detail_data( $limit, $offset, $filter, $order_by, $client_id, $max,$min);
            $total = $this->credit_detail_model_f->get_credit_detail_count( $filter, $client_id,$max,$min );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
        public function get_credit_hist_contact($client_id){
			
            $this->load->model('credit_hist_contact_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->credit_hist_contact_model->credit_hist_contact_data($limit, $offset, $filter, $order_by, $client_id);
            $total = $this->credit_hist_contact_model->get_hist_contact_count($filter, $client_id);
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
        public function get_credit_hist_notification($client_id){
            $this->load->model('credit_hist_contact_notification');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->credit_hist_contact_notification->credit_hist_notification_data($limit, $offset, $filter, $order_by,$client_id);
            $total = $this->credit_hist_contact_notification->get_hist_notification_count($filter,$client_id);
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
       
	   public function get_hist_report_a($client_id, $compromiso_pago_date = 0,$var){
            $this->load->model('credit_hist_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->credit_hist_model->get_hist_data_a( $limit, $offset, $filter, $order_by, $client_id, $compromiso_pago_date ,$var);
            $total = $this->credit_hist_model->get_hist_count_a( $filter, $client_id, $compromiso_pago_date,$var );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
	   
	   
        public function get_hist_report_legal($client_id, $compromiso_pago_date = 0){
            $this->load->model('credit_hist_model_legal');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->credit_hist_model_legal->get_hist_data( $limit, $offset, $filter, $order_by, $client_id, $compromiso_pago_date );
            $total = $this->credit_hist_model_legal->get_hist_count( $filter, $client_id, $compromiso_pago_date);
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
        
        public function get_hist_report($client_id, $compromiso_pago_date = 0){
            $this->load->model('credit_hist_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->credit_hist_model->get_hist_data( $limit, $offset, $filter, $order_by, $client_id, $compromiso_pago_date );
            $total = $this->credit_hist_model->get_hist_count( $filter, $client_id, $compromiso_pago_date );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
        /* Llamada al formulario 
        * enlace de llamada:
        * <a id="call-php" href="#" data-target="messagesout" php-function="common/index/viewScreen/module/controller/open_ml_empresa">Nuevo</a>
        */
        function open_credit_detail($id = 0) {
            $this->load->model('client_referencias_contact_model');
            $res['id'] = $id;
            $this->load->view("credit_detail", $res);
        }
        
        /**
         * Almacena o actualiza detalles del credito
         * @param type $param
         */
        public function save(){
            $id = set_post_value('id', 0);
           
            //====================================================================================
            $credit_detail = new \gestcobra\credit_detail_model($id);
            $credit_detail->credit_status_id = set_post_value('credit_status_id');
            $credit_detail->curr_date = date('Y-m-d', time());
            $credit_detail->comision_id = set_post_value('comision_id');
            $comision_id=set_post_value('comision_id');
            $valor = (new gestcobra\comision_cobranzas_model())
                        ->where('id',$comision_id)
                        ->find_one();
            $costo=$valor->valor_comision;
            
             $suma_comisiones = (new gestcobra\credit_detail_model())
                        ->where('id',$credit_detail->id)
                        ->find_one();
               
            $total_comision=$costo+$suma_comisiones->total_comision;
            
            $credit_detail->total_comision=$total_comision;
            $credit_detail->total_pagar=$suma_comisiones->total_cuotas_vencidas+$total_comision;
            
            
                if ( ! $credit_detail->is_valid() ){
                    $errors = $credit_detail->validate(); $str_errors = arraytostr($errors);
                    errorAlert($str_errors[2], lang('ml_error')); $this->db->trans_rollback();
                    return false;
                } else {
                    $this->ws_send_sms_call();
                    $credit_detail->save();
                    $this->_save_credit_hist($credit_detail->id);
                    //$this->_save_client($credit_detail->client_id);
                    /**
                     * Garantes y referencias
                     */
					 
					 
                    $this->_save_ref_client($credit_detail);
                    /**
                     * 2 = Referencias
                     */
//                    $this->_save_ref_client( $credit_detail->client_id, 2 );
                    $this->_save_abono($credit_detail->id);
                   //$this->ws_send_sms_call();
                    $this->_save_contact($credit_detail);
                    
                    ?>
                    <script>
                        $("#table_credit_hist").bootstrapTable('refresh');
                        $("#table_credits").bootstrapTable('refresh');
                        $("#table_credits_f").bootstrapTable('refresh');
    
                    </script>
                    <?php         

			 successAlert(lang('ml_success_msg'), lang('ml_success'));
					
              //      successAlert(lang('ml_success_msg'), lang('ml_success'));
                }
        }
        
        private function _save_abono($credit_detail_id){
            $ids = set_post_value('abono_id');
            $amount = set_post_value('amount');
            $date_abono = set_post_value('date_abono');
            //  $template_data = set_post_value('template_data');
            /**
             * Se eliminan abonos y para crearlos de nuevo a todos
             */
            $this->db->delete('abono', array('credit_detail_id' => $credit_detail_id));
            $cont = 0;
            if($ids){
                foreach ($ids as $value) {
                    $abono = new gestcobra\abono_model($value);
                    if(!empty($amount[$cont]) AND $amount[$cont] != 'undefined'  AND $amount[$cont] != 'null'){
                        $abono->amount = $amount[$cont];
                        $abono->date_abono = $date_abono[$cont];
                        $abono->credit_detail_id = $credit_detail_id;
                        $abono->save();
                        $cont++;
                    }
                }
            }
            successAlert(lang('ml_success_msg'), lang('ml_success'));
            ?>
                <script>
                    $("#table_notif").bootstrapTable('refresh');
                </script>
            <?php
        }
        /*
         * Almacena numeros de telefono individuales... 
         */
        private function _save_contact($credit_detail){
            $ids = set_post_value('ids_contact');
            $person_id = set_post_value('person_id');
            $contact_type_id = set_post_value('contact_type_id');
            $contact_value = set_post_value('contact_value');
            
            $clien_referencias = (new gestcobra\client_referencias_model())
                    ->where('credit_detail_id',$credit_detail->id)
                    ->find();
            $person_id_client_ref_array= array();
            foreach ($clien_referencias as $client_ref){
                array_push($person_id_client_ref_array, $client_ref->person_id);
            }
            
            if($person_id_client_ref_array){
                foreach ($person_id_client_ref_array as $value) {
                        /**
                         * Se eliminan contactos referentes a la persona
                         */
                        $this->db->delete('contact', array('person_id' => $value));
                }
            }
            $cont = 0;
            if($ids){
                foreach ($ids as $value){
                    $contact_new = new gestcobra\contact_model();
                    $contact_new->contact_type_id = $contact_type_id[$cont];
                    $contact_new->contact_value = $contact_value[$cont];
                    $contact_new->person_id = $person_id[$cont];
                    $contact_new->save();
                    $cont++;
                }
            }
            successAlert( lang('ml_success_msg'), lang('ml_success') );
            ?>
                <script>
                    $("#table_contact").bootstrapTable('refresh');
                </script>
            <?php
        }
        
        private function _save_credit_hist($credit_detail_id) {
            $credti_hist = new gestcobra\credit_hist_model();
            $credti_hist->credit_detail_id = $credit_detail_id;
            $credti_hist->detail = set_post_value('detail');
            $credti_hist->hist_date = date('Y-m-d', time());
            $credti_hist->hist_time = date('H:i:s', time());
            $credti_hist->credit_status_id = set_post_value('credit_status_id');
            $credti_hist->oficial_credito_id = $this->user->id;
            $credti_hist->comision_id = set_post_value('comision_id');
            
            $resul=$this->db->query("SELECT credit_detail_id FROM credit_hist WHERE credit_detail_id=$credit_detail_id and credit_status_id=3");
            $lol=$resul->num_rows();
       
            if (set_post_value('credit_status_id') == 23 && $lol!=0) {
                $this->actualizar_compromiso_max($credit_detail_id);
                $credti_hist->compromiso_max = 1;      
            }else if(set_post_value('credit_status_id') == 23 && $lol==0){
                    $credti_hist->compromiso_max = 1;
                }else{
                    $credti_hist->compromiso_max = 0;
                }
            
            if (set_post_value('compromiso_pago_date')=="" or set_post_value('compromiso_pago_date')==NULL) {
				
                $fecha = date(0000-00-00);
                $credti_hist->compromiso_pago_date = $fecha;
            }else{
                $credti_hist->compromiso_pago_date = set_post_value('compromiso_pago_date');
            }
            
            $credti_hist->save();
            
                
        ?>
        <script>
            $("#table_credit_hist").bootstrapTable('refresh');
            $("#table_credits").bootstrapTable('refresh');

        </script>
        <?php
        successAlert(lang('ml_success_msg'), lang('ml_success'));
            
        }
        /**
         * Informacion del cliente
         * @param type $param
         */
        
        private function actualizar_compromiso_max($credit_detail_id) {
        $hist_compromiso = (new gestcobra\credit_hist_model())
                ->where('credit_detail_id', $credit_detail_id)
                ->where('credit_status_id', 23)
                ->where('compromiso_max', 1)
                ->find_one();
        $hist_compromiso->compromiso_max = 0;
        $hist_compromiso->save();
        }
    
       
        
        
        /**
         * Informacion de la referencia del cliente
         * @param type $param
         */
        private function _save_ref_client( $credit_detail ){
            $ref_ids = set_post_value('ref_ids');
            $reference_type_id = set_post_value('reference_type_id');
            $firstname = set_post_value('ref_firstname');
            $lastname = set_post_value('ref_lastname');
            $personal_address = set_post_value('ref_personal_address');


          
            $array_referencias_ids = array();
            $cont = 0;
            if($ref_ids){
                foreach($ref_ids as $value) {                    
                    if(!empty($firstname[$cont]) AND $firstname[$cont] != 'undefined'  AND $firstname[$cont] != 'null'){
                        $reference_client = new gestcobra\client_referencias_model($value);
                        $persona = new gestcobra\person_model($reference_client->person_id);
                        $persona->firstname = $firstname[$cont];
                        //$persona->lastname = $lastname[$cont];
                        $persona->personal_address = $personal_address[$cont];
                        $persona->save();
                        $reference_client->credit_detail_id = $credit_detail->id;
                        $reference_client->person_id = $persona->id;            
                        $reference_client->reference_type_id = $reference_type_id[$cont];
                        $reference_client->status = 1;
                        $reference_client->save();
                        array_push($array_referencias_ids, $reference_client->id);                            
                        $cont++;     
                    }
                }
            }
            
            /**
             * Se desactivan todos
             */
            if($array_referencias_ids){
                $this->db->where_not_in('id', $array_referencias_ids);
            }
            $this->db->where('credit_detail_id', $credit_detail->id);
            $this->db->update('client_referencias', array('status'=>'-1'));                        
            ?>
                <script>
                    $("#table_referencias").bootstrapTable('refresh');
                    $("#table_contact").bootstrapTable('refresh');
                </script>
            <?php
        }
        
        public function ws_send_sms_call() {           
            
            $obj_commws = new Commws();
            $tipo_sms = set_post_value('comunicacion_opt');
            $contacto_seleccionado=set_post_value('chk_table_contact');
            
            $mensaje_format= set_post_value('message_format_id');
            $notificacion='';
            if($mensaje_format=='-1'){
                $message=set_post_value('client_message');
            }else{
                $notificacion = new gestcobra\notification_format_model($mensaje_format);
                $message = $notificacion->format;
            }
            $asunto=set_post_value('detail');
            $credit_detail_id=set_post_value('id');
            if($contacto_seleccionado && $message){
                $i=0;
                $company = new gestcobra\company_model($this->user->company_id);
                foreach ($contacto_seleccionado as $contactIs){
                    $contacts_ids=0;
                    $contacts_ids=$contactIs;
                    $contacts =new \gestcobra\contact_model($contactIs);
                    
                    $numero_telefono=''.$contacts->contact_value.'';
                    
                    $tipocontacto = ''.$contacts->contact_type_id.'';
                    $credit_detail= (new gestcobra\credit_detail_model($credit_detail_id));
                    $client_referencias = (new gestcobra\client_referencias_model())
                            ->where('person_id',$contacts->person_id)
                            ->where('credit_detail_id',$credit_detail_id)
                            ->find_one();
                    
                    $deudor_referencias = (new gestcobra\client_referencias_model())
                            ->where('credit_detail_id',$credit_detail_id)
                            ->where('reference_type_id','3')
                            ->find_one();
                    
                    $persona_datos = new gestcobra\person_model($client_referencias->person_id);
                    $deudor_datos = new gestcobra\person_model($deudor_referencias->person_id);
                    
                    $COMPANY_NAME='';
                    $DEUDOR_NAME='';
                    $SOCIO_NUMERO='';
                    $PAGARE_NUEMERO='';
                    $DEUDA_INICIAL='';
                    $SALDO_ACTUAL='';
                    $FECHA_ADJUDICACION='';
                    $CUOTAS_PAGADAS='';
                    $CUOTAS_MORA='';
                    $DIAS_MORA='';
                    $TOTAL_CUOTAS_VENCIDAS='';
                    $PLAZO_ORIGINAL='';
                    $FECHA_ULTIMO_PAGO='';
                    $NOMBRE_PERSONA='';
                    
                    $COMPANY_NAME=$company->nombre_comercial;
                    $DEUDOR_NAME=$deudor_datos->firstname;
                    $SOCIO_NUMERO=$credit_detail->nro_cuotas;
                    $PAGARE_NUEMERO=$credit_detail->nro_pagare;
                    $DEUDA_INICIAL=$credit_detail->deuda_inicial;
                    $SALDO_ACTUAL=$credit_detail->saldo_actual;
                    $FECHA_ADJUDICACION=$credit_detail->adjudicacion_date;
                    $CUOTAS_PAGADAS=$credit_detail->cuotas_pagadas;
                    $CUOTAS_MORA=$credit_detail->cuotas_mora;
                    $DIAS_MORA=$credit_detail->dias_mora;
                    $TOTAL_CUOTAS_VENCIDAS=$credit_detail->total_cuotas_vencidas;
                    $PLAZO_ORIGINAL=$credit_detail->plazo_original;
                    $FECHA_ULTIMO_PAGO=$credit_detail->last_pay_date;
                    $NOMBRE_PERSONA=$persona_datos->firstname;
                    
                    $mensaje_aux = '';
                    //$message = ''.$company->nombre_comercial.'Estimado '.$message.' tiene '.$credit_detail->cuotas_mora.'cuotas en mora, con un valor total de '.$credit_detail->total_cuotas_vencidas;
                    $mensaje_aux = str_replace('COMPANY_NAME', $COMPANY_NAME, $message);
                    $mensaje_aux = str_replace('DEUDOR_NAME', $DEUDOR_NAME, $mensaje_aux);
                    $mensaje_aux = str_replace('SOCIO_NUMERO', $SOCIO_NUMERO, $mensaje_aux);
                    $mensaje_aux = str_replace('PAGARE_NUEMERO', $PAGARE_NUEMERO, $mensaje_aux);
                    $mensaje_aux = str_replace('DEUDA_INICIAL', $DEUDA_INICIAL, $mensaje_aux);
                    $mensaje_aux = str_replace('SALDO_ACTUAL', $SALDO_ACTUAL, $mensaje_aux);
                    $mensaje_aux = str_replace('FECHA_ADJUDICACION', $FECHA_ADJUDICACION, $mensaje_aux);
                    $mensaje_aux = str_replace('CUOTAS_PAGADAS', $CUOTAS_PAGADAS, $mensaje_aux);
                    $mensaje_aux = str_replace('CUOTAS_MORA', $CUOTAS_MORA, $mensaje_aux);
                    $mensaje_aux = str_replace('DIAS_MORA', $DIAS_MORA, $mensaje_aux);
                    $mensaje_aux = str_replace('TOTAL_CUOTAS_VENCIDAS', $TOTAL_CUOTAS_VENCIDAS, $mensaje_aux);
                    $mensaje_aux = str_replace('PLAZO_ORIGINAL', $PLAZO_ORIGINAL, $mensaje_aux);
                    $mensaje_aux = str_replace('FECHA_ULTIMO_PAGO', $FECHA_ULTIMO_PAGO, $mensaje_aux);
                    $mensaje_aux = str_replace('NOMBRE_PERSONA', $NOMBRE_PERSONA, $mensaje_aux);
                    
                    if($numero_telefono{0}=='0'){
                        $nuevo_numero_telefono = substr($numero_telefono,1);
                    }else{
                        $nuevo_numero_telefono=$numero_telefono;
                    }
                    foreach($tipo_sms as $value_sms){
                        $from='';
                        $type_phone='';
                        $value_type='';
                        if(($value_sms == 'com_sms' AND $tipocontacto == 2) OR ($value_sms == 'com_call' AND ($tipocontacto == 2 OR $tipocontacto == 1)) ) {
                            $from = 12345;
                              $obj_commws->set_url_ws('http://localhost/comunicaciones/ws_sms/examplews/send');
							  
                            if($value_sms == 'com_sms'){
                               $type_phone = 'text';
                               $value_type=$value_sms;
							
							}else{
                               $type_phone = 'voice';
                               $value_type=$value_sms;
                            }
                        }
                        elseif($value_sms == 'com_whatsapp' AND $tipocontacto == 2){
                            $obj_commws->set_url_ws('http://localhost/comunicaciones/ws_whatsapp/testWA/send');
                            $value_type=$value_sms;
                        }
                        elseif($value_sms == 'com_email' AND $tipocontacto== 3){
                            $obj_commws->set_url_ws('http://comunicaciones.gestcobra.com/ws_email/EmailSend/sendMailGmail');
                            $from = 'gestcobracom@gmail.com';
                            
                            
                            $value_type=$value_sms;
                        }
                        $res='';
                        $mensajes=array();
                        $mensaj=array();
                        if (!$value_type == '') {
                        if ($value_sms = 'com_sms') {
                                $contact_completo='593'.$nuevo_numero_telefono;
                                array_push($mensajes, $mensaje_aux);
                                array_push($mensaj, $contact_completo);
                                if (!empty($mensajes)) {
                			$message = array(
                                        "Mensaje"=>"Hola",
                                        "Mensajes"=>$mensajes,
                                        "Destinatarios"=>$mensaj,
                                        "apiKey"=>"3D78493FB7"
                                        );
                                $obj_commws->http_conn_comunication_1($message);
//ENVIO_HIST
     $var=count($mensaj);
  $this->envio_hist("MENSAJES PERSONAL",$var,0); 
  //$this->envio_hist("MENSAJES PERSONALIZADOS",$enviados,$num_malos);  
							   
							   
							   }
                    }else{
                        $res = $obj_commws->http_conn_comunication(
                                $from,
                                $nuevo_numero_telefono, 
                                $mensaje_aux,                                         
                                $value_type,
                                $type_phone,
                                'AsDfG12345'
                            );
                    }
                        if(empty($res)){
                            $res='false';
                        }
							 $status = 1;
                        if ($mensaje_format == -1) {
                            $mensaje_format = 1;
                        }

                        $this->save_comunication_ac($value_sms, $deudor_referencias->id, $status,  $nuevo_numero_telefono, $mensaje_format);
						$this->save_hist($credit_detail_id);
							
                            if(empty($res)){
                                $res='false';
                            }
                            $notification_format_id=null;
                            if($mensaje_format!='-1'){
                                $notification_format_id=$mensaje_format;
                            }
                        }
                    }
                } 
            }
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


        //actualizar pagina
       

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
        $credti_hist->compromiso_pago_date =date(0000 - 00 - 00);
        $credti_hist->save();       
        }
		
		
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