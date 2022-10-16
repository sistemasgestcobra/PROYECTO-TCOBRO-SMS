<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_1 extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Ignorar los abortos hechos por el usuario y permitir que el script
        // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
        ignore_user_abort(true);
        $this->load->library('comunications/commws');
        set_time_limit(0);
    }

    public function get_credit_detail_report($client_id, $compromiso_pago_date = 0, $agencia_name) {
        $this->load->model('credit_detail_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $this->credit_detail_model->get_credit_detail_data($limit, $offset, $filter, $order_by, $client_id, $compromiso_pago_date, $agencia_name);
        $total = $this->credit_detail_model->get_credit_detail_count($filter, $client_id, $compromiso_pago_date, $agencia_name);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }

    public function get_credit_detail_report_1($client_id, $compromiso_pago_date = 0) {
        $this->load->model('grupos_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $this->grupos_model->get_credit_detail_data_1($limit, $offset, $filter, $order_by, $client_id, $compromiso_pago_date);
        $total = $this->grupos_model->get_credit_detail_count_1($filter, $client_id, $compromiso_pago_date);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }

    public function get_credit_hist_contact() {
        $this->load->model('credit_hist_contact_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $this->credit_hist_contact_model->credit_hist_contact_data($limit, $offset, $filter, $order_by);
        $total = $this->credit_hist_contact_model->get_hist_contact_count($filter);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }

    public function get_credit_hist_notification() {
        $this->load->model('credit_hist_contact_notification');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $this->credit_hist_contact_notification->credit_hist_notification_data($limit, $offset, $filter, $order_by);
        $total = $this->credit_hist_contact_notification->get_hist_notification_count($filter);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }

    public function get_hist_notification_report($client_id, $compromiso_pago_date = 0) {
        $this->load->model('credit_hist_notification_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $this->credit_hist_notification_model->get_hist_data($limit, $offset, $filter, $order_by, $client_id, $compromiso_pago_date);
        $total = $this->credit_hist_notification_model->get_hist_count($filter, $client_id, $compromiso_pago_date);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }

    public function get_hist_report_a($client_id, $compromiso_pago_date = 0, $var) {
        $this->load->model('credit_hist_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $this->credit_hist_model->get_hist_data_a($limit, $offset, $filter, $order_by, $client_id, $compromiso_pago_date, $var);
        $total = $this->credit_hist_model->get_hist_count_a($filter, $client_id, $compromiso_pago_date, $var);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }

    public function get_hist_report($client_id, $compromiso_pago_date = 0) {
        $this->load->model('credit_hist_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $this->credit_hist_model->get_hist_data($limit, $offset, $filter, $order_by, $client_id, $compromiso_pago_date);
        $total = $this->credit_hist_model->get_hist_count($filter, $client_id, $compromiso_pago_date);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
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
    /*
     * Almacena numeros de telefono individuales... 
     */
    private function _save_contact($credit_detail) {
        $ids = set_post_value('ids_contact');
        $person_id = set_post_value('person_id');
        $contact_type_id = set_post_value('contact_type_id');
        $contact_respuesta_id = set_post_value('contact_respuesta_id');
        $contact_value = set_post_value('contact_value');
//          $template_data = set_post_value('template_data');
        //print_r($person_id);

        $clien_referencias = (new gestcobra\client_referencias_model())
                ->where('credit_detail_id', $credit_detail->id)
                ->find();
        $person_id_client_ref_array = array();
        foreach ($clien_referencias as $client_ref) {
            array_push($person_id_client_ref_array, $client_ref->person_id);
        }

        if ($person_id_client_ref_array) {
            foreach ($person_id_client_ref_array as $value) {
                /**
                 * Se eliminan contactos referentes a la persona
                 */
                $this->db->delete('contact', array('person_id' => $value));
            }
        }
        $cont = 0;
        if ($ids) {
            foreach ($ids as $value) {
                $contact_new = new gestcobra\contact_model();
                $contact_new->contact_type_id = $contact_type_id[$cont];
                $contact_new->contact_respuesta_id = $contact_respuesta_id[$cont];
                $contact_new->contact_value = $contact_value[$cont];
                $contact_new->person_id = $person_id[$cont];
                $contact_new->save();
                $cont++;
            }
        }
        successAlert(lang('ml_success_msg'), lang('ml_success'));
        ?>
        <script>
            $("#table_contact").bootstrapTable('refresh');
        </script>
        <?php
    }

    public function save() {
        $id = set_post_value('id', 0);
        $detalle = set_post_value('detail');
        
        //====================================================================================
        $credit_detail = new \gestcobra\credit_detail_model($id);

        $credit_detail->credit_status_id = set_post_value('credit_status_id');
        $credit_detail->curr_date = date('Y-m-d', time());
        $credit_detail->tipo_gestion_id = set_post_value('tipo_gestion_id');
        $credit_detail->motivo_no_pago_id = set_post_value('motivo_no_pago_id');
        $credit_detail->valor_promesa = set_post_value('valor_promesa');
        $estado = set_post_value('credit_status_id');

        $this->_save_ref_client($credit_detail);
        if (!$credit_detail->is_valid()) {
            $errors = $credit_detail->validate();
            $str_errors = arraytostr($errors);
            errorAlert($str_errors[2], lang('ml_error'));
            $this->db->trans_rollback();
            return false;
        } else {//ACTUALIZAR
            $this->_save_contact($credit_detail);
            if ($detalle == "ac" || $detalle == "AC" || $detalle =="undefined" || $detalle =="") {
//              
                $credit_detail->save();
                //$this->_save_client($credit_detail->client_id);
                /**
                 * Garantes y referencias
                 */
                /**
                 * 2 = Referencias
                 */
//                    $this->_save_ref_client( $credit_detail->client_id, 2 );
                $this->_save_abono($credit_detail->id);
                $this->ws_send_sms_call();
                $this->_save_contact($credit_detail);
                
            } elseif ($detalle != "ac" || $detalle != "AC" ) {
                if ($estado != 4) {
                    $this->_save_credit_hist($credit_detail->id);
                    $credit_detail->save();
                }

                //  window.close();
            }
            ?>
            <script>
                $("#table_credit_hist").bootstrapTable('refresh');
                $("#table_credits").bootstrapTable('refresh');

            </script>
            <?php
            successAlert(lang('ml_success_msg'), lang('ml_success'));
               }
            ?>
            <!--crear un scrip para cerrar modal -->
          
            <script>
   document.location.reload();
       
        </script>
           
        <?php

   
        }


    private function _save_abono($credit_detail_id) {
        $ids = set_post_value('abono_id');
        $amount = set_post_value('amount');
        $date_abono = set_post_value('date_abono');
        //  $template_data = set_post_value('template_data');
        /**
         * Se eliminan abonos y para crearlos de nuevo a todos
         */
        $this->db->delete('abono', array('credit_detail_id' => $credit_detail_id));
        $cont = 0;
        if ($ids) {
            foreach ($ids as $value) {
                $abono = new gestcobra\abono_model($value);
                if (!empty($amount[$cont]) AND $amount[$cont] != 'undefined' AND $amount[$cont] != 'null') {
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

    private function _save_credit_hist($credit_detail_id) {
        


        $credti_hist = new gestcobra\credit_hist_model();
        $credti_hist->credit_detail_id = $credit_detail_id;
        $credti_hist->detail = set_post_value('detail');
        
        
        $credti_hist->hist_date = date('Y-m-d', time());
        $credti_hist->hist_time = date('H:i:s', time());
        $credti_hist->credit_status_id = set_post_value('credit_status_id');
        $credti_hist->oficial_credito_id = $this->user->id;
        $credti_hist->tipo_gestion_id = set_post_value('tipo_gestion_id');
        $credti_hist->motivo_no_pago_id = set_post_value('motivo_no_pago_id');
        $credti_hist->valor_promesa = set_post_value('valor_promesa');
        $credti_hist->tiempo_gestion = set_post_value('face');
        
        if (set_post_value('credit_status_id') == 3) {
            $this->actualizar_compromiso_max($credit_detail_id);
            $credti_hist->compromiso_max = 1;
        }  else {
            $credti_hist->compromiso_max = 0;
        }




        $client_ref = (new gestcobra\client_referencias_model())
                ->where('credit_detail_id', $credit_detail_id)
                ->where('reference_type_id', 3)
                ->find_one();


        $contact = (new gestcobra\contact_model())
                ->where('person_id', $client_ref->person_id)
                ->where('contact_respuesta_id', 1)
                ->find_one();


        $oficina = (new gestcobra\credit_detail_model())
                ->where('id', $credit_detail_id)
                ->find_one();

        $credti_hist->oficina_id = $oficina->oficina_company_id;
        $credti_hist->oficial_cedula = $oficina->oficial_credito_id;

        if (!$contact->id > 0) {
            $credti_hist->contact_id = ' ';
        } else {
            $credti_hist->contact_id = $contact->contact_value;
        }
        if (set_post_value('compromiso_pago_date') == '' or set_post_value('compromiso_pago_date') == NULL) {
            $fecha = date(0000 - 00 - 00);
            $credti_hist->compromiso_pago_date = $fecha;
//$credti_hist->compromiso_pago_date = 'NULL';
        } else {
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

    private function actualizar_compromiso_max($credit_detail_id) {
        $hist_compromiso = (new gestcobra\credit_hist_model())
                ->where('credit_detail_id', $credit_detail_id)
                ->where('credit_status_id', 3)
                ->where('compromiso_max', 1)
                ->find_one();

        $hist_compromiso->compromiso_max = 0;
        $hist_compromiso->save();
    }

    /**
     * Informacion del cliente
     * @param type $param
     */
    private function _save_client($client_id) {
        $client = new gestcobra\client_model($client_id);
        $persona = new gestcobra\person_model($client->person_id);
        $persona->firstname = set_post_value('firstname');
        $persona->lastname = set_post_value('lastname');
        $persona->personal_phone = set_post_value('personal_phone');
        $persona->personal_address = set_post_value('personal_address');
        $persona->cedula_deudor = set_post_value('cedula_deudor');
        $persona->ciudad = set_post_value('ciudad');
        $persona->address_ref = set_post_value('address_ref');
        $persona->save();
    }

    private function save_comunication($type, $creditdetail_id, $status, $cost, $contact, $network, $client_referencia, $notification_format_id) {
        //var_dump($this->user);
        //print_r($status);
        $comunication_type = (new gestcobra\comunication_type_model())
                ->where('comunication_code', $type)
                ->find_one();

        $comunication = new gestcobra\comunication_model();
        $comunication->type = $type;
        //$comunication->credit_detail_id = $creditdetail_id;
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

    /**
     * Informacion de la referencia del cliente
     * @param type $param
     */
    private function _save_ref_client($credit_detail) {
        $ref_ids = set_post_value('ref_ids');
        $reference_type_id = set_post_value('reference_type_id');
        $firstname = set_post_value('ref_firstname');
        $lastname = set_post_value('ref_lastname');
        $personal_address = set_post_value('ref_personal_address');
        //$cedula_deudor = set_post_value('ref_cedula_deudor');
//            $address_ref = set_post_value('address_ref');
        /**
         * Se desactivan todos
         */
//            $this->db->where( 'client_id', $client_id );
//            $this->db->update( 'client_referencias', array('status'=>'-1') );            
        $array_referencias_ids = array();
        $cont = 0;
        if ($ref_ids) {
            foreach ($ref_ids as $value) {
                if (!empty($firstname[$cont]) AND $firstname[$cont] != 'undefined' AND $firstname[$cont] != 'null') {
                    $reference_client = new gestcobra\client_referencias_model($value);
                    $persona = new gestcobra\person_model($reference_client->person_id);
                    $persona->firstname = $firstname[$cont];
                    //$persona->lastname = $lastname[$cont];
                    $persona->personal_address = $personal_address[$cont];
                    //$persona->cedula_deudor = $cedula_deudor[$cont];
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
        //print_r($array_referencias_ids);
        /**
         * Se desactivan todos
         */
        if ($array_referencias_ids) {
            $this->db->where_not_in('id', $array_referencias_ids);
        }
        $this->db->where('credit_detail_id', $credit_detail->id);
        $this->db->update('client_referencias', array('status' => '-1'));
        //echo $this->db->last_query();
        ?>
        <script>
            $("#table_referencias").bootstrapTable('refresh');
            $("#table_contact").bootstrapTable('refresh');
        </script>
        <?php
    }

    public function ws_send_sms_call() {
        //$credit_detail_id = set_post_value('id', 0);
        $obj_commws = new Commws();
        $tipo_sms = set_post_value('comunicacion_opt');
        $contacto_seleccionado = set_post_value('chk_table_contact');

        $mensaje_format = set_post_value('message_format_id');
        $notificacion = '';
        if ($mensaje_format == '-1') {
            $message = set_post_value('client_message');
        } else {
            $notificacion = new gestcobra\notification_format_model($mensaje_format);
            $message = $notificacion->format;
        }
        $asunto = set_post_value('detail');
        $credit_detail_id = set_post_value('id');
        if ($contacto_seleccionado && $message) {
            $i = 0;
            $company = new gestcobra\company_model($this->user->company_id);
            //print_r($contacto_seleccionado);
            foreach ($contacto_seleccionado as $contactIs) {
                $contacts_ids = 0;
                $contacts_ids = $contactIs;
                $contacts = new \gestcobra\contact_model($contactIs);

                $numero_telefono = '' . $contacts->contact_value . '';

                $tipocontacto = '' . $contacts->contact_type_id . '';
                $credit_detail = (new gestcobra\credit_detail_model($credit_detail_id));
                $client_referencias = (new gestcobra\client_referencias_model())
                        ->where('person_id', $contacts->person_id)
                        ->where('credit_detail_id', $credit_detail_id)
                        ->find_one();

                $deudor_referencias = (new gestcobra\client_referencias_model())
                        ->where('credit_detail_id', $credit_detail_id)
                        ->where('reference_type_id', '3')
                        ->find_one();

                $persona_datos = new gestcobra\person_model($client_referencias->person_id);
                $deudor_datos = new gestcobra\person_model($deudor_referencias->person_id);

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
                $NOMBRE_PERSONA = '';

                $COMPANY_NAME = $company->nombre_comercial;
                $DEUDOR_NAME = $deudor_datos->firstname;
                $SOCIO_NUMERO = $credit_detail->nro_cuotas;
                $PAGARE_NUEMERO = $credit_detail->nro_pagare;
                $DEUDA_INICIAL = $credit_detail->deuda_inicial;
                $SALDO_ACTUAL = $credit_detail->saldo_actual;
                $FECHA_ADJUDICACION = $credit_detail->adjudicacion_date;
                $CUOTAS_PAGADAS = $credit_detail->cuotas_pagadas;
                $CUOTAS_MORA = $credit_detail->cuotas_mora;
                $DIAS_MORA = $credit_detail->dias_mora;
                $TOTAL_CUOTAS_VENCIDAS = $credit_detail->total_cuotas_vencidas;
                $PLAZO_ORIGINAL = $credit_detail->plazo_original;
                $FECHA_ULTIMO_PAGO = $credit_detail->last_pay_date;
                $NOMBRE_PERSONA = $persona_datos->firstname;

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

                if (strlen($numero_telefono) == 10 AND $numero_telefono{0} == '0') {

                    $nuevo_numero_telefono = substr($numero_telefono, 1);
                } else {
                    $nuevo_numero_telefono = $numero_telefono;
                }
                echo "$nuevo_numero_telefono";
                foreach ($tipo_sms as $value_sms) {
                    $from = '';
                    $type_phone = '';
                    $value_type = '';

                    if (($value_sms == 'com_sms' AND $tipo_contacto == 2) OR ( $value_sms == 'com_call' AND ( $tipo_contacto_ofic == 2 OR $tipo_contacto == 1))) {
                        $from = 1234;
                        $obj_commws->set_url_ws('http://localhost/comunicaciones/ws_sms/examplews/send');
                        if ($value_sms == 'com_sms') {
                            $type_phone = 'text';
                            $value_type = $value_sms;
                        } else {
                            $type_phone = 'voice';
                            $value_type = $value_sms;
                        }
                    } elseif ($value_sms == 'com_whatsapp' AND $tipocontacto == 2) {
                        $obj_commws->set_url_ws('http://localhost/comunicaciones/ws_whatsapp/testWA/send');
                        $value_type = $value_sms;
                    } elseif ($value_sms == 'com_email' AND $tipocontacto == 3) {
                        $obj_commws->set_url_ws('http://localhost/comunicaciones/ws_email/EmailSend/sendMailGmail');
                        $from = 'gestcobracom@gmail.com';


                        $value_type = $value_sms;
                    }
                    $res = '';
                    if (!$value_type == '') {
                        $res = $obj_commws->http_conn_comunication(
                                $from, $nuevo_numero_telefono, $mensaje_aux, $value_type, $type_phone, 'AsDfG12345'
                        );
                        if (empty($res)) {
                            $res = 'false';
                        }
                        $notification_format_id = null;
                        if ($mensaje_format != '-1') {
                            $notification_format_id = $mensaje_format;
                        }
                        $this->respuesta_ws($res, $value_type, $credit_detail_id, $nuevo_numero_telefono, $client_referencias, $notification_format_id);
                    }
                }
            }
        }
    }

    public function respuesta_ws($sms_resp_json_masivos, $value_sms, $credit_detail_id, $contacto_value, $client_referencia, $notification_format_id) {
        $status = null;
        if ($sms_resp_json_masivos != null) {
            $type = $value_sms;
            $cost = 0;
            $network = "";
            if ($value_sms == 'com_whatsapp' OR $value_sms == 'com_email') {
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
            $this->save_comunication($type, $credit_detail_id, $status, $cost, $contacto_value, $network, $client_referencia, $notification_format_id);
        }
    }

    public function borrar_ceroinicial_telf($numero_telefono) {
        if ($numero_telefono{0} == '0') {
            $nuevo_numero_telefono = substr($numero_telefono, 1);
        }
        return $nuevo_numero_telefono;
    }

}
