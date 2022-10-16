<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class AdminWs1 extends REST_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('cobranzas/clientreferencias');
    }

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

    /**
     * 
     * @param type $array_para_recibir_via_url
     * /**
     * $datos_array = array(
      "login_oficial_credito" => $login_array,
      "creditos_array" => $creditos_excel_array,
      );
     * @param type $array_para_recibir_via_url
     * @example $parametrosEnviadosDesdeWS = array(
      "usuario_sistema" => $usuario,
      "clave_sistema" => $clave,
     * 
      "tipo_credito" => $tipo_credito,
      "numero_socio" => $numero_socio,
      "nuemero_pagare" => $nuemero_pagare,
      "nombre_apellido_cliente" => $nombre_apellido_cliente,
      "telefono_cliente" => $telefono_cliente,
      "celular_cliente" => $celular_cliente,
      "direccion_domicilio_cliente" => $direccion_domicilio_cliente,
      "referencia_domicilio_cliente"=>referencia_domicilio_cliente,
      "deuda_inicial" => $deuda_inicial,
      "saldo_deuda_o_saldo_capital" => $saldo_deuda_o_saldo_capital,
      "plazo_original_credito" => $plazo_original_credito,
      "cuotas_pagadas_credito" => $cuotas_pagadas_credito,
      "cuotas_en_mora" => $cuotas_en_mora,
      "dias_en_mora" => $dias_en_mora,
      "comision_cobranza" => $comision_cobranza,
      "total_cuotas_vencidas" => $total_cuotas_vencidas,
      "fecha_ultimo_pago" => $fecha_ultimo_pago,
      "nombre_apellido_garante" => $nombre_apellido_garante,
      "telefono_garante" => $telefono_garante,
      "direccion_garante" => $direccion_garante,
      "nombre_apellido_referencia" => $nombre_apellido_referencia,
      "telefono_referencia" => $telefono_referencia,
      "fecha_adjudicacion" => $fecha_adjudicacion,
      "oficial_credito" => $oficial_credito,
      "oficial_credito_cedula" => $oficial_credito_cedula,
      "agencia" => $agencia
      );
     */
//    
//    public function ingresarDatos1_get($array_para_recibir_via_url) {
//        if ($array_para_recibir_via_url) {
//            $array_para_recibir_via_url = stripslashes($array_para_recibir_via_url);
//            $array_para_recibir_via_url = urldecode($array_para_recibir_via_url);
//            $matriz_completa_array = unserialize($array_para_recibir_via_url);
//            $login_oficial_credito = $matriz_completa_array["login_oficial_credito"];
//            $creditos_matriz_completa = $matriz_completa_array["creditos_array"];
//            $oficial_credito_datos = $this->get_oficial_credito($login_oficial_credito);
//            if ($oficial_credito_datos) {
//                // Crear nuevo status (PENDIENTE PARA LA EMPRESA)
//                $credit_status = $this->find_state("PENDIENTE", $oficial_credito_datos->company_id);
//                $credit_status_cancelado = $this->find_state("CANCELADO", $oficial_credito_datos->company_id);
//                $credit_status_compromiso_pago = $this->find_state("COMPROMISO PAGO", $oficial_credito_datos->company_id);
//
//                if (empty($credit_status->id)) {
//                    $credit_status = $this->create_state("PENDIENTE", "#ffffff", "#000000", $oficial_credito_datos->company_id);
//                }
//                if (empty($credit_status_cancelado->id)) {
//                    $credit_status_cancelado = $this->create_state("CANCELADO", "#fdfefe", "#7b241c", $oficial_credito_datos->company_id);
//                }
//                if (empty($credit_status_compromiso_pago->id)) {
//                    $credit_status_compromiso_pago = $this->create_state("COMPROMISO PAGO", "#17202a", "#eafaf1", $oficial_credito_datos->company_id);
//                }
//                for ($count_credit = 0; $count_credit < count($creditos_matriz_completa); $count_credit++) {
//                    $matriz_completa = 0;
//                    $matriz_completa = $creditos_matriz_completa[$count_credit];
//                    $nombres_deudor = $matriz_completa["nombre_apellido_cliente"];
//                    if (empty($nombres_deudor)) {
//                        $nombres_deudor = '';
//                    }
//                    $tipo_credito = $matriz_completa["tipo_credito"];
//                    $numero_cuotas = $matriz_completa["numero_socio"];
//                    $numero_pagare = $matriz_completa["nuemero_pagare"];
//                    $deuda_inicial = $matriz_completa["deuda_inicial"];
//                    $saldo_actual = $matriz_completa["saldo_deuda_o_saldo_capital"];
//                    $plazo_original = $matriz_completa["plazo_original_credito"];
//                    $cuotas_pagadas = $matriz_completa["cuotas_pagadas_credito"];
//                    $cuotas_mora = $matriz_completa["cuotas_en_mora"];
//                    $dias_mora = $matriz_completa["dias_en_mora"];
//                    $total_cuotas_vencidas = $matriz_completa["total_cuotas_vencidas"];
//                    $last_pay_date = $matriz_completa["fecha_ultimo_pago"];
//                    $fecha_adjudicacion = $matriz_completa["fecha_adjudicacion"];
//                    $oficial_credito = $matriz_completa["oficial_credito"];
//                    $oficial_credito_cedula = $matriz_completa["oficial_credito_cedula"];
//                    $oficina = $matriz_completa["agencia"];
//
//                    if (!empty($oficina)) {
//                        $oficina_id = $this->_get_oficina_id($oficina, $oficial_credito_datos);
//                        $oficial_credito_id = $this->_get_oficial_credito_id($oficial_credito, $oficial_credito_cedula, $oficina_id, $oficial_credito_datos);
//                        // $oficial_credito_id = $client_data->oficial_credito_id;
//                        $oficial_data = new \gestcobra\oficial_credito_model($oficial_credito_id);
//                        /**
//                         * $numero_pagare identifica al credito
//                         */
//                        $credit_detail = (new gestcobra\credit_detail_model())
//                                ->where('company_id', $oficial_credito_datos->company_id)
//                                ->where('nro_pagare', $numero_pagare)
//                                ->find_one();
//                        /**
//                         * Solo si es la primera vez que se sube ese credito se
//                         * actualiza curr_date
//                         */
//                        if (empty($credit_detail->id)) {
//                            $credit_detail->curr_date = date('Y-m-d', time());
//                            $credit_detail->updated_month_id = date('m', time());
//                            $credit_detail->updated_year = date('Y', time());
//                        }
//                        $credit_detail->adjudicacion_date = $fecha_adjudicacion;
//                        $credit_type_id = $this->_get_credit_type_id($tipo_credito, $oficial_credito_datos);
//                        $credit_detail->credito_type_id = $credit_type_id;
//                        $credit_detail->load_date = date('Y-m-d', time());
//                        $credit_detail->deuda_inicial = $deuda_inicial;
//                        $credit_detail->nro_cuotas = $numero_cuotas;
//                        $credit_detail->nro_pagare = trim($numero_pagare) . "";
//                        $credit_detail->saldo_actual = $saldo_actual;
//                        $credit_detail->total_cuotas_vencidas = $total_cuotas_vencidas;
//                        $credit_detail->cuotas_pagadas = $cuotas_pagadas;
//                        $credit_detail->cuotas_pagadas = $cuotas_pagadas;
//                        $credit_detail->cuotas_mora = $cuotas_mora;
//                        $credit_detail->dias_mora = $dias_mora;
//                        $credit_detail->plazo_original = $plazo_original;
//                        $credit_detail->last_pay_date = $last_pay_date;
//                        $credit_detail->company_id = $oficial_credito_datos->company_id;
//                        $credit_detail->credit_status_id = $credit_status->id;
//                        $credit_detail->oficial_credito_id = $oficial_credito_id;
//                        $credit_detail->oficina_company_id = $oficial_data->oficina_company_id;
//                        $credit_detail->save();
//                        $this->save_client_references($matriz_completa, $credit_detail->id);
//                        //}
//                    }
//                    if ($this->db->trans_status() === FALSE) {
//                        $this->db->trans_rollback();
//                    } else {
//                        $this->db->trans_commit();
//                    }
//                }
//            }
//            if (isset($credit_detail)) {
//                successAlert('Archivo cargado correctamente', lang('ml_success'));
//            } else {
//                errorAlert('Error al cargar el archivo');
//            }
//        } else {
//            errorAlert('Error al cargar el archivo');
//        }
//    }
//    
    
      public function ingresarDatos1_get($array_para_recibir_via_url) {
      if ($array_para_recibir_via_url) {
      $array_para_recibir_via_url = stripslashes($array_para_recibir_via_url);
      $array_para_recibir_via_url = urldecode($array_para_recibir_via_url);
      $matriz_completa = unserialize($array_para_recibir_via_url);
      $usuario = $matriz_completa["usuario_sistema"]; //get_value_xls($PHPExcel,$this->abecedario["D"],$x);
      $clave = $matriz_completa["clave_sistema"];
      // login y obtener el id->
      $oficial_credito_datos = $this->get_oficial_credito($matriz_completa);
      if ($oficial_credito_datos) {
      // Crear nuevo status (PENDIENTE PARA LA EMPRESA)
      $credit_status = $this->find_state("PENDIENTE", $oficial_credito_datos->company_id);
      $credit_status_cancelado = $this->find_state("CANCELADO", $oficial_credito_datos->company_id);
      $credit_status_compromiso_pago = $this->find_state("COMPROMISO PAGO", $oficial_credito_datos->company_id);

      if (empty($credit_status->id)) {
      $credit_status = $this->create_state("PENDIENTE", "#ffffff", "#000000", $oficial_credito_datos->company_id);
      }
      if (empty($credit_status_cancelado->id)) {
      $credit_status_cancelado = $this->create_state("CANCELADO", "#fdfefe", "#7b241c", $oficial_credito_datos->company_id);
      }
      if (empty($credit_status_compromiso_pago->id)) {
      $credit_status_compromiso_pago = $this->create_state("COMPROMISO PAGO", "#17202a", "#eafaf1", $oficial_credito_datos->company_id);
      }
      //for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
      $nombres_deudor = $matriz_completa["nombre_apellido_cliente"];
      if (empty($nombres_deudor)) {
      $nombres_deudor='';
      }
      $tipo_credito = $matriz_completa["tipo_credito"];
      $numero_cuotas = $matriz_completa["numero_socio"];
      $numero_pagare = $matriz_completa["nuemero_pagare"];
      $deuda_inicial = $matriz_completa["deuda_inicial"];
      $saldo_actual = $matriz_completa["saldo_deuda_o_saldo_capital"];
      $plazo_original = $matriz_completa["plazo_original_credito"];
      $cuotas_pagadas = $matriz_completa["cuotas_pagadas_credito"];
      $cuotas_mora = $matriz_completa["cuotas_en_mora"];
      $dias_mora = $matriz_completa["dias_en_mora"];
      $total_cuotas_vencidas = $matriz_completa["total_cuotas_vencidas"];
      $last_pay_date = $matriz_completa["fecha_ultimo_pago"];
      $fecha_adjudicacion = $matriz_completa["fecha_adjudicacion"];
      $oficial_credito = $matriz_completa["oficial_credito"];
      $oficial_credito_cedula = $matriz_completa["oficial_credito_cedula"];
      $oficina = $matriz_completa["agencia"];

      if (!empty($oficina)) {
      $oficina_id = $this->_get_oficina_id($oficina,$oficial_credito_datos);
      $oficial_credito_id = $this->_get_oficial_credito_id($oficial_credito, $oficial_credito_cedula, $oficina_id,$oficial_credito_datos);
      // $oficial_credito_id = $client_data->oficial_credito_id;
      $oficial_data = new \gestcobra\oficial_credito_model($oficial_credito_id);
      /**
     * $numero_pagare identifica al credito
     */
      $credit_detail = (new gestcobra\credit_detail_model())
      ->where('company_id', $oficial_credito_datos->company_id)
      ->where('nro_pagare', $numero_pagare)
      ->find_one();
      /**
     * Solo si es la primera vez que se sube ese credito se
     * actualiza curr_date
     */

      if (empty($credit_detail->id)) {
      $credit_detail->curr_date = date('Y-m-d', time());
      $credit_detail->updated_month_id = date('m', time());
      $credit_detail->updated_year = date('Y', time());
      }
      $credit_detail->adjudicacion_date = $fecha_adjudicacion;
      $credit_type_id = $this->_get_credit_type_id($tipo_credito,$oficial_credito_datos);
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
      $credit_detail->plazo_original = $plazo_original;
      $credit_detail->last_pay_date = $last_pay_date;
      $credit_detail->company_id = $oficial_credito_datos->company_id;
      //$credit_detail->credit_status_id = $credit_status->id;
      if ($credit_detail->id > 0 AND ( $credit_detail->credit_status_id == $credit_status_cancelado->id)) {
                    $credit_detail->credit_status_id = $credit_status->id;
      }
      $credit_detail->oficial_credito_id = $oficial_credito_id;
      $credit_detail->oficina_company_id = $oficial_data->oficina_company_id;
      $credit_detail->save();
      $this->save_client_references($matriz_completa, $credit_detail->id);
      //}
      }
      if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      } else {
      $this->db->trans_commit();
      }
      }
      if (isset($credit_detail)) {
      successAlert('Archivo cargado correctamente', lang('ml_success'));
      } else {
      errorAlert('Error al cargar el archivo');
      }
      } else {
      errorAlert('Error al cargar el archivo');
      }
      }
    private function _get_credit_type_id($name, $oficial_credito_datos) {
        $credit_type = (new \gestcobra\credito_type_model())
                ->where('company_id', $oficial_credito_datos->company_id)
                ->where('name', $name)
                ->find_one();
        $credit_type->name = $name;
        $credit_type->company_id = $oficial_credito_datos->company_id;
        $credit_type->save();
        return $credit_type->id;
    }

    /**
     * Almacena referencias del cliente
     * @param type $param
     */
    private function save_client_references($matriz_completa, $client_id) {
        /**
         * Almacena Deudor
         */
        $numero_cliente = $matriz_completa["numero_socio"];
        $nombres_deudor = $matriz_completa["nombre_apellido_cliente"];
        $direccion_deudor = $matriz_completa["direccion_domicilio_cliente"];
        $ref_direccion_deudor = $matriz_completa["referencia_domicilio_cliente"];

        $obj_ref_deudor = new Clientreferencias(); //$obj_commws = new Commws();
        $obj_ref_deudor->set_client_code($numero_cliente);
        $obj_ref_deudor->set_credit_detail_id($client_id);
        $obj_ref_deudor->set_person_address($direccion_deudor);
        $obj_ref_deudor->set_person_address_ref($ref_direccion_deudor);
        $obj_ref_deudor->set_person_name($nombres_deudor);
        $obj_ref_deudor->set_reference_type_id('3');
        $res_deudor = $obj_ref_deudor->save();

        if ($res_deudor) {
            $telefonos_deudor = $matriz_completa["telefono_cliente"];
            if (!empty($telefonos_deudor)) {
                $array_phone = explode(',', $telefonos_deudor);
                foreach ($array_phone as $phone_contact) {
                    $this->_save_contact($res_deudor->person_id, $phone_contact, 1);
                }
            }
            $celular_deudor = $matriz_completa["celular_cliente"];
            if (!empty($celular_deudor)) {
                $array_phone = explode(',', $celular_deudor);
                foreach ($array_phone as $phone_contact) {
                    $this->_save_contact($res_deudor->person_id, $phone_contact, 2);
                }
            }
        }
        /**
         * Almacena garantes
         */
        $nombres_garante = $matriz_completa["nombre_apellido_garante"];
        $direccion_garante = $matriz_completa["direccion_garante"];

        $obj_ref_garante = new Clientreferencias();
        $obj_ref_garante->set_client_code('');
        $obj_ref_garante->set_credit_detail_id($client_id);
        $obj_ref_garante->set_person_address($direccion_garante);
        $obj_ref_garante->set_person_address_ref('');
        $obj_ref_garante->set_person_name($nombres_garante);
        $obj_ref_garante->set_reference_type_id(1);
        $res_garante = $obj_ref_garante->save();

        if ($res_garante) {
            $telefonos_garante = $matriz_completa["telefono_garante"];
            if (!empty($telefonos_garante)) {
                $array_phone = explode(',', $telefonos_garante);
                foreach ($array_phone as $phone_contact) {
                    $this->_save_contact($res_garante->person_id, $phone_contact, 2);
                }
            }
        }
        /**
         * Almacena referencias
         */
        $nombres_referencia = $matriz_completa["nombre_apellido_referencia"];
        $obj_ref_2 = new Clientreferencias();
        $obj_ref_2->set_client_code('');
        $obj_ref_2->set_credit_detail_id($client_id);
        $obj_ref_2->set_person_address('');
        $obj_ref_deudor->set_person_address_ref('');
        $obj_ref_2->set_person_name($nombres_referencia);
        $obj_ref_2->set_reference_type_id(2);
        $res_ref2 = $obj_ref_2->save();
        if ($res_ref2) {
            $telefonos_referencia = $matriz_completa["telefono_referencia"];
            if (!empty($telefonos_referencia)) {
                $array_phone = explode(',', $telefonos_referencia);
                foreach ($array_phone as $phone_contact) {
                    $this->_save_contact($res_ref2->person_id, $phone_contact, 2);
                }
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
        $oficial_credito->password = $this->encrypt_password_callback('1234');
        $oficial_credito->firstname = $firstname;
        $oficial_credito->oficina_company_id = $oficina_id;
        $oficial_credito->company_id = $this->user->company_id;
        $oficial_credito->role_id = 1; /* Oficial de credito */
        $oficial_credito->save();
        return $oficial_credito->id;
    }

    function encrypt_password_callback($clave) {
        $pass_word = (new gestcobra\setup_model())->where('variable', 'PASSWORDSALTMAIN')->find_one()->valor;
        $encryptedPass = MD5($clave . $pass_word);
        return $encryptedPass;
    }

    private function _get_oficina_id($oficina_name, $oficial_credito_datos) {
        $oficina = (new gestcobra\oficina_company_model())
                ->where('company_id', $oficial_credito_datos->company_id)
                ->where('name', $oficina_name)
                ->where('status', '1')
                ->find_one();
        $oficina->company_id = $oficial_credito_datos->company_id;
        $oficina->name = $oficina_name;
        $oficina->save();
        return $oficina->id;
    }

    /**
     * Busca datos de oficial de crédito por usuario y contraseña
     * @param type $param
     */
    private function get_oficial_credito($matriz_completa) {
        $usuario = $matriz_completa["usuario_sistema"]; //get_value_xls($PHPExcel,$this->abecedario["R"],$x);
        $clave = $matriz_completa["clave_sistema"]; //get_value_xls($PHPExcel,$this->abecedario["S"],$x);
        $clave_encriptada = $this->encrypt_password_callback($clave);
        if (!empty($usuario) && !empty($clave)) {
            $oficial_credito = (new gestcobra\oficial_credito_model())
                    ->where('email', $usuario)
                    ->where('password', $clave_encriptada)
                    ->find_one();
            return $oficial_credito;
        }
        return null;
    }

}
