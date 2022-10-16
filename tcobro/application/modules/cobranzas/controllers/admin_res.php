<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MX_Controller {
    public function __construct() {
        parent::__construct();
        $this->user->check_session();
        $this->load->library('clientreferencias');

        // Ignorar los abortos hechos por el usuario y permitir que el script
        // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
        ignore_user_abort(true);
    }
    public $abecedario = array(
        "A" => "0",
        "B" => "1",
        "C" => "2",
        "D" => "3",
        "E" => "4",
        "F" => "5",
        "G" => "6",
        "H" => "7",
        "I" => "8",
        "J" => "9",
        "K" => "10",
        "L" => "11",
        "M" => "12",
        "N" => "13",
        "O" => "14",
        "P" => "15",
        "Q" => "16",
        "R" => "17",
        "S" => "18",
        "T" => "19",
        "U" => "20",
        "V" => "21",
        "W" => "22",
        "X" => "23",
        "Y" => "24",
        "Z" => "25",
        "AA" => "26",
        "AB" => "27"
    );

    /*
     *  Cargamos varios clientes desde un archivo..
     */
    function find_state($status_name, $company_id) {
        $credit_status = (new gestcobra\credit_status_model())
                ->where("status_name", $status_name)
                ->where("company_id", $company_id)
                ->find_one();
        return $credit_status;
    }

    function create_state($status_name, $status_color, $status_background, $company_id) {
        $credit_status = (new gestcobra\credit_status_model())
                ->where("status_name", $status_name)
                ->where("company_id", $company_id)
                ->find_one();
        if (empty($credit_status->id)) {
            $credit_status->status_name = $status_name;
            $credit_status->color = $status_color;
            $credit_status->background = $status_background;
            $credit_status->company_id = $company_id;
            $credit_status->save();
        }
        return $credit_status;
    }

    function load_credits_data() {
        set_time_limit(0);
        $this->load->library('excel');
        $logo_path = './uploads/' . $this->user->company_id . '/files/';
        makedirs($logo_path, $mode = 0755);
        $config['upload_path'] = $logo_path;
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            toast($error);
            exit();
        } else {
            $upl_data = $this->upload->data();
        }
        $upl_data = $this->upload->data();
        if (file_exists($logo_path . $upl_data['file_name'])) {
            // Cargando la hoja de c�lculo
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $objFecha = new PHPExcel_Shared_Date();
            // Asignar hoja de excel activa
            $PHPExcel->setActiveSheetIndex(0);
            $this->db->trans_begin();
            // Crear nuevo status (PENDIENTE PARA LA EMPRESA)
            $credit_status = $this->find_state("PENDIENTE", $this->user->company_id);
            $credit_status_cancelado = $this->find_state("CANCELADO", $this->user->company_id);
            $credit_status_compromiso_pago = $this->find_state("COMPROMISO PAGO", $this->user->company_id);

            if (empty($credit_status->id)) {
                $credit_status = $this->create_state("PENDIENTE", "#ffffff", "#000000", $this->user->company_id);
            }
            if (empty($credit_status_cancelado->id)) {
                $credit_status_cancelado = $this->create_state("CANCELADO", "#fdfefe", "#7b241c", $this->user->company_id);
            }
            if (empty($credit_status_compromiso_pago->id)) {
                $credit_status_compromiso_pago = $this->create_state("COMPROMISO PAGO", "#17202a", "#eafaf1", $this->user->company_id);
            }
            
            for($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                $nombres_deudor = get_value_xls($PHPExcel, $this->abecedario["D"], $x);
                if(empty($nombres_deudor)) {
                    continue;
                }
                $tipo_credito = get_value_xls($PHPExcel, $this->abecedario["A"], $x);
                $numero_cuotas = get_value_xls($PHPExcel, $this->abecedario["B"], $x);
                $numero_pagare = get_value_xls($PHPExcel, $this->abecedario["C"], $x);
                $deuda_inicial = get_value_xls($PHPExcel, $this->abecedario["I"], $x);
                $saldo_actual = get_value_xls($PHPExcel, $this->abecedario["J"], $x);
                $plazo_original = get_value_xls($PHPExcel, $this->abecedario["K"], $x);
                $cuotas_pagadas = get_value_xls($PHPExcel, $this->abecedario["L"], $x);
                $cuotas_mora = get_value_xls($PHPExcel, $this->abecedario["M"], $x);
                $dias_mora = get_value_xls($PHPExcel, $this->abecedario["N"], $x);
                $total_cuotas_vencidas = get_value_xls($PHPExcel, $this->abecedario["P"], $x);
                $last_pay_date = get_value_xls($PHPExcel, $this->abecedario["Q"], $x);
                $timestamp=PHPExcel_Shared_Date::ExcelToPHP( $last_pay_date);
                $timestamp = strtotime("+1 day",$timestamp);
                $last_pay_date=date("d-m-Y H:i:s",$timestamp);
                $fecha_adjudicacion = get_value_xls($PHPExcel, $this->abecedario["W"], $x);
                $timestamp=PHPExcel_Shared_Date::ExcelToPHP($fecha_adjudicacion);
                $timestamp = strtotime("+1 day",$timestamp);
                $fecha_adjudicacion=date("d-m-Y H:i:s",$timestamp);
                $oficial_credito = get_value_xls($PHPExcel, $this->abecedario["X"], $x);
                $oficial_credito_cedula = get_value_xls($PHPExcel, $this->abecedario["Y"], $x);
                $oficina = get_value_xls($PHPExcel, $this->abecedario["Z"], $x);
                $gestor=get_value_xls($PHPExcel, $this->abecedario["AA"], $x);
                $gestor_codigo=get_value_xls($PHPExcel, $this->abecedario["AB"], $x);
                if(empty($oficina)){
                    break;
                }
                $oficina_id = $this->_get_oficina_id($oficina);
                $oficial_credito_id = $this->_get_oficial_credito_id($oficial_credito, $oficial_credito_cedula, $oficina_id);
                
                    if (strlen($gestor_codigo)>2 && strlen($gestor)>2) {
		  $gestor_id = $this->_get_gestor_id($gestor, $gestor_codigo);
                }else{
                    $gestor_id=null;
                    $gestor=null;
                }
                
                $oficial_data = new \gestcobra\oficial_credito_model($oficial_credito_id);
                /**
                 * $numero_pagare identifica al credito
                */
                $credit_detail = (new gestcobra\credit_detail_model())
                        ->where('company_id', $this->user->company_id)
                        ->where('nro_pagare', $numero_pagare)
                        ->find_one();
                /**
                 * Solo si es la primera vez que se sube ese credito se
                 * actualiza curr_date
                */
                
                if(empty($credit_detail->id)) {
                    $credit_detail->curr_date = date('Y-m-d', time());
                    $credit_detail->updated_month_id = date('m', time());
                    $credit_detail->updated_year = date('Y', time());
                }
                $credit_detail->adjudicacion_date = $fecha_adjudicacion;
                $credit_type_id = $this->_get_credit_type_id($tipo_credito);
                $credit_detail->credito_type_id = $credit_type_id;
                $credit_detail->load_date = date('Y-m-d', time());
                $credit_detail->deuda_inicial = $deuda_inicial;
                $credit_detail->nro_cuotas = $numero_cuotas;
                $credit_detail->nro_pagare = trim($numero_pagare) . "";
                $credit_detail->saldo_actual = $saldo_actual;
                $credit_detail->total_cuotas_vencidas = $total_cuotas_vencidas;
                $credit_detail->cuotas_pagadas = $cuotas_pagadas;
                $credit_detail->cuotas_pagadas = $cuotas_pagadas;
                $credit_detail->cuotas_mora = $cuotas_mora;
                $credit_detail->dias_mora = $dias_mora;
                $credit_detail->comision_id = 7;
                $credit_detail->plazo_original = $plazo_original;
                $credit_detail->last_pay_date = $last_pay_date;
                $credit_detail->company_id = $this->user->company_id;
				
                if ($credit_detail->id > 0 AND ( $credit_detail->credit_status_id == $credit_status_cancelado->id)) {
                    $credit_detail->credit_status_id = $credit_status->id;
                }else if ($credit_detail->credit_status_id == NULL) {
                    $credit_detail->credit_status_id = $credit_status->id;
                }
                $credit_detail->oficial_credito_id = $oficial_credito_id;
                $credit_detail->oficina_company_id = $oficial_data->oficina_company_id;
                $credit_detail->gestor_id = $gestor_id;
				
                $credit_detail->save();
                $this->save_client_references($PHPExcel, $x, $credit_detail->id);
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
            if( isset($credit_detail)){
                successAlert('Archivo cargado correctamente', lang('ml_success'));
            }else{
                errorAlert('Error al cargar el archivo');
            }
            //successAlert('Archivo cargado correctamente', lang('ml_success'));
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }

    private function _get_credit_type_id($name) {
        $credit_type = (new \gestcobra\credito_type_model())
                ->where('company_id', $this->user->company_id)
                ->where('name', $name)
                ->find_one();
        $credit_type->name = $name;
        $credit_type->company_id = $this->user->company_id;
        $credit_type->save();
        return $credit_type->id;
    }

    /**
     * Almacena referencias del cliente
     * @param type $param
     */
    private function save_client_references($PHPExcel, $x, $credit_detail_id) {

        /**
         * Almacena Deudor
         */
        $numero_cliente = get_value_xls($PHPExcel, $this->abecedario["B"], $x);
        $nombres_deudor = get_value_xls($PHPExcel, $this->abecedario["D"], $x);
        $direccion_deudor = get_value_xls($PHPExcel, $this->abecedario["G"], $x);
        $ref_direccion_deudor = get_value_xls($PHPExcel, $this->abecedario["H"], $x);
        $obj_ref_deudor = new Clientreferencias();
        $obj_ref_deudor->set_client_code($numero_cliente);
        $obj_ref_deudor->set_credit_detail_id($credit_detail_id);
        $obj_ref_deudor->set_person_address($direccion_deudor);
        $obj_ref_deudor->set_person_address_ref($ref_direccion_deudor);
        $obj_ref_deudor->set_person_name($nombres_deudor);
        $obj_ref_deudor->set_reference_type_id(3);
        $res_deudor = $obj_ref_deudor->save();
        
        if ($res_deudor) {
            $telefonos_deudor = get_value_xls($PHPExcel, $this->abecedario["E"], $x);
            if (strlen($telefonos_deudor)>6) {
                    $this->_save_contact($res_deudor->person_id, $telefonos_deudor, 1);
            }
            $celular_deudor = get_value_xls($PHPExcel, $this->abecedario["F"], $x);
            if (strlen($celular_deudor)>7) {
                
                    $this->_save_contact($res_deudor->person_id, $celular_deudor, 2);
                
            }
        }
        
        /**
         * Almacena garantes
         */
        $nombres_garante = get_value_xls($PHPExcel, $this->abecedario["R"], $x);
        $direccion_garante = get_value_xls($PHPExcel, $this->abecedario["T"], $x);

        $obj_ref_garante = new Clientreferencias();
        $obj_ref_garante->set_client_code('');
        $obj_ref_garante->set_credit_detail_id($credit_detail_id);
        $obj_ref_garante->set_person_address($direccion_garante);
        $obj_ref_garante->set_person_address_ref('');
        $obj_ref_garante->set_person_name($nombres_garante);
        $obj_ref_garante->set_reference_type_id(1);
        $res_garante = $obj_ref_garante->save();

        if ($res_garante) {
            $telefonos_garante = get_value_xls($PHPExcel, $this->abecedario["S"], $x);
            if (strlen($telefonos_garante)>6) {
                
                    $this->_save_contact($res_garante->person_id, $telefonos_garante, 2);
                
            }
        }
        /**
         * Almacena referencias
         */
        $nombres_referencia = get_value_xls($PHPExcel, $this->abecedario["U"], $x);
        $obj_ref_2 = new Clientreferencias();
        $obj_ref_2->set_client_code('');
        $obj_ref_2->set_credit_detail_id($credit_detail_id);
        $obj_ref_2->set_person_address('');
        $obj_ref_deudor->set_person_address_ref('');
        $obj_ref_2->set_person_name($nombres_referencia);
        $obj_ref_2->set_reference_type_id(2);
        $res_ref2 = $obj_ref_2->save();
        if ($res_ref2) {
            $telefonos_referencia = get_value_xls($PHPExcel, $this->abecedario["V"], $x);
            if (strlen($telefonos_referencia)>6) {
                
                    $this->_save_contact($res_ref2->person_id, $telefonos_referencia, 2);
                
            }
        }
    }

    private function _save_contact($person_id, $contact, $contact_type) {
        $contact_data = (new gestcobra\contact_model())
                ->where('person_id', $person_id)
                ->find_one();
        $contact_data->person_id = $person_id;
        $contact_data->contact_type_id = $contact_type; /* Telefono de casa */
        $contact_data->contact_value = $contact;
        $contact_data->description = '';
        $contact_data->save();

        return $contact;
    }

    private function _get_oficial_credito_id($oficial_firstname, $oficial_credito_cedula, $oficina_id) {
        $firstname = strtoupper($oficial_firstname);
        $oficial_credito = (new \gestcobra\oficial_credito_model())
                ->where('oficina_company_id', $oficina_id)
                ->where('cedula', $oficial_credito_cedula)
                ->where('status', '1')
                ->find_one();
        $oficial_credito->cedula = $oficial_credito_cedula;
        $oficial_credito->email = $oficial_credito_cedula . "_" . $oficina_id;
        if (!$oficial_credito->id > 0) {
            $oficial_credito->password = $this->encrypt_password_callback('1234');
        }
        $oficial_credito->firstname = $firstname;
        $oficial_credito->oficina_company_id = $oficina_id;
        $oficial_credito->company_id = $this->user->company_id;
        $oficial_credito->role_id = 1; /* Oficial de credito */
        $oficial_credito->save();
        return $oficial_credito->id;
    }

    private function _get_gestor_id($gestor, $gestor_codigo) {
        $firstname = strtoupper($gestor);
        $oficial_credito = (new \gestcobra\oficial_credito_model())
                ->where('cedula', $gestor_codigo)
                ->where('status', '1')
                ->find_one();
        $oficial_credito->cedula = $gestor_codigo;
        $oficial_credito->email = $gestor_codigo . "@" . $gestor_codigo;
        if (!$oficial_credito->id > 0) {
            $oficial_credito->password = $this->encrypt_password_callback('1234');
        }
        $oficial_credito->firstname = $firstname;
        $oficial_credito->oficina_company_id = $this->user->oficina_company_id;
        $oficial_credito->company_id = $this->user->company_id;
        $oficial_credito->role_id = 4; /* Gestor */
        $oficial_credito->save();
        return $oficial_credito->id;
    }
    function encrypt_password_callback($clave) {
        $pass_word = (new gestcobra\setup_model())->where('variable', 'PASSWORDSALTMAIN')->find_one()->valor;
        $encryptedPass = MD5($clave . $pass_word);
        return $encryptedPass;
    }

    private function _get_oficina_id($oficina_name) {
        $oficina = (new gestcobra\oficina_company_model())
                ->where('company_id', $this->user->company_id)
                ->where('name', $oficina_name)
                ->where('status', '1')
                ->find_one();
        $oficina->company_id = $this->user->company_id;
        $oficina->name = $oficina_name;
        $oficina->save();
        return $oficina->id;
    }
    
}