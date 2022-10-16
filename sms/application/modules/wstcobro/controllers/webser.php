<?php
ini_set('max_execution_time', 0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class webser extends REST_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('cobranzas/clientreferencias');
		$this->load->library('comunications/commws');
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

    public function disparo_get() {
  $this->db->query("delete from  contact");
        $primero=array(
            "usuario_sistema" => "subir",
            "clave_sistema" => "1234",
          );
    function llenado(array $datos){
    $array_1=array(
    "tipo_credito"=>"",
    "numero_socio"=>"",
    "nuemero_pagare" => "",
    "nombre_apellido_cliente" => "",
    "telefono_cliente" => "",
    "celular_cliente" => "",
    "direccion_domicilio_cliente" => "",
    "referencia_domicilio_cliente"=> "",
    "deuda_inicial" => "",
    "saldo_deuda_o_saldo_capital" => "",
    "plazo_original_credito" => "",
    "cuotas_pagadas_credito" => "",
    "cuotas_en_mora" => "",
    "dias_en_mora" => "",
    "comision_cobranza" => "",
    "total_cuotas_vencidas" => "",
    "fecha_ultimo_pago" => "",
    "nombre_apellido_garante" => "",
    "telefono_garante" => "", 
    "direccion_garante" => "",
    "nombre_apellido_referencia" => "",
    "telefono_referencia" => "",
    "fecha_adjudicacion" => "",
    "oficial_credito" => "",
    "oficial_credito_cedula" => "",
    "agencia" => "",
	"gestor" => "",
	"codigo" => "",
	"correo" => ""
);
    
$array_1["tipo_credito"]=$datos[0]; $array_1["numero_socio"]=$datos[1]; $array_1["nuemero_pagare"]=$datos[2];
$array_1["nombre_apellido_cliente"]=$datos[3]; $array_1["telefono_cliente"]=$datos[4];
$array_1["celular_cliente"]=$datos[5]; $array_1["direccion_domicilio_cliente"]=$datos[6];
$array_1["referencia_domicilio_cliente"]=$datos[7]; $array_1["deuda_inicial"]=$datos[8];
$array_1["saldo_deuda_o_saldo_capital"]=$datos[9]; $array_1["plazo_original_credito"]=$datos[10];
$array_1["cuotas_pagadas_credito"]=$datos[11]; $array_1["cuotas_en_mora"]=$datos[12];
$array_1["dias_en_mora"]=$datos[13]; $array_1["comision_cobranza"]=$datos[14];
$array_1["total_cuotas_vencidas"]=$datos[15]; $array_1["fecha_ultimo_pago"]=$datos[16];
$array_1["nombre_apellido_garante"]=$datos[17]; $array_1["telefono_garante"]=$datos[18];
$array_1["direccion_garante"]=$datos[19]; $array_1["nombre_apellido_referencia"]=$datos[20];
$array_1["telefono_referencia"]=$datos[21]; $array_1["fecha_adjudicacion"]=$datos[22];
$array_1["oficial_credito"]=$datos[23]; $array_1["oficial_credito_cedula"]=$datos[24];
$array_1["agencia"]=$datos[25]; $array_1["gestor"]="0"; $array_1["codigo"]="0"; $array_1["correo"]=$datos[26];
return $array_1;
}

$client = new SoapClient("http://192.168.187.152/FBSEventosBatch/ServicioGestCobra.asmx?WSDL");
  $xml = $client->ObtenerDatosModuloExtrajudicial();
  $xml2= $xml->ObtenerDatosModuloExtrajudicialResult;
  $xml3=$xml2->string;
  
    foreach ($xml3 as $linea) {
        $array = explode("|", $linea);
        $nuevo=llenado($array);
        $this->ingresarDatos2($nuevo);
        }
      }

    function ingresarDatos2($matriz_completa) {

      if ($matriz_completa) {
      
      $credit_status = $this->find_state("PENDIENTE", 18);
      $credit_status_cancelado = $this->find_state("CANCELADO", 18);
      $credit_status_compromiso_pago = $this->find_state("COMPROMISO PAGO", 18);

     
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
	  $correo = $matriz_completa["correo"];
	  $comision=$matriz_completa["comision_cobranza"];
      $dias_mora = $matriz_completa["dias_en_mora"];
      $total_cuotas_vencidas = $matriz_completa["total_cuotas_vencidas"];
      $last_pay_date = $matriz_completa["fecha_ultimo_pago"];
      $fecha_adjudicacion = $matriz_completa["fecha_adjudicacion"];
      $oficial_credito = $matriz_completa["oficial_credito"];
      $oficial_credito_cedula = $matriz_completa["oficial_credito_cedula"];
      $oficina = $matriz_completa["agencia"];
      $gestor=$matriz_completa["gestor"];
      $gestor_codigo=$matriz_completa["codigo"];
      
      
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
      ->where('company_id', 18)
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
      $credito_type_id = $this->_get_credit_type_id($tipo_credito);
      $credit_detail->credito_type_id = $credito_type_id;
      $credit_detail->load_date = date('Y-m-d', time());
      $credit_detail->deuda_inicial = $deuda_inicial;
      $credit_detail->nro_cuotas = $numero_cuotas;
      $credit_detail->nro_pagare = trim($numero_pagare) . "";
      $credit_detail->saldo_actual = $saldo_actual;
      $credit_detail->total_cuotas_vencidas = $total_cuotas_vencidas;
      $credit_detail->cuotas_pagadas = $cuotas_pagadas;
      $credit_detail->cuotas_mora = $cuotas_mora;
      $credit_detail->dias_mora = $dias_mora;
	  $credit_detail->comision_id = 7;
	  $credit_detail->total_comision = $comision;
	  if( $credit_detail->credit_status_id == $credit_status_cancelado->id){
	      $credit_detail->total_pagar = 0;
	  }
      $credit_detail->plazo_original = $plazo_original;
      $credit_detail->last_pay_date = $last_pay_date;
      $credit_detail->company_id = 18;
      
      if ($credit_detail->id > 0 AND ( $credit_detail->credit_status_id == $credit_status_cancelado->id)) {
                    $credit_detail->credit_status_id = $credit_status->id;
                }else if ($credit_detail->credit_status_id == NULL or $credit_detail->credit_status_id=='') {
                    $credit_detail->credit_status_id = $credit_status->id;
                }
      $credit_detail->oficial_credito_id = $oficial_credito_id;
      $credit_detail->oficina_company_id = $oficial_data->oficina_company_id;
      $credit_detail->gestor_id = $gestor_id;
	  
      $credit_detail->save();
      $this->save_client_references($matriz_completa, $credit_detail->id);
      
      
      if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      } else {
      $this->db->trans_commit();
      }

      } else {
      errorAlert('Error al cargar el archivo');
      
      }
    }
      
    function _get_credit_type_id($name) {
        $credit_type = (new \gestcobra\credito_type_model())
                ->where('company_id', 18)
                ->where('name', $name)
                ->find_one();
        $credit_type->name = $name;
        $credit_type->company_id = 18;
        $credit_type->save();
        return $credit_type->id;
    }

    
    function _cancelado() {
        $credit_type = (new \gestcobra\credito_type_model())
                ->where('company_id', 18)
                ->where('name', $name)
                ->find_one();
        $credit_type->name = $name;
        $credit_type->company_id = 18;
        $credit_type->save();
        return $credit_type->id;
    }
    
    /**
     * Almacena referencias del cliente
     * @param type $param
     */
    function save_client_references($matriz_completa, $client_id) {
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
                $array_phone = explode(';', $telefonos_deudor);                        //
                foreach ($array_phone as $phone_contact) {
					 if (strlen($phone_contact)>6 AND strlen($phone_contact)<9) {
                    $this->_save_contact($res_deudor->person_id, $phone_contact, 1);
                }}
            }
            $celular_deudor = $matriz_completa["celular_cliente"];
            if (!empty($celular_deudor)) {
                $array_phone = explode(';', $celular_deudor);
                foreach ($array_phone as $phone_contact) {
					 if (strlen($phone_contact)>9 ) {
                    $this->_save_contact($res_deudor->person_id, $phone_contact, 2);
                }}
            }
			$correo=$matriz_completa["correo"];
            if (strlen($correo)>8) {
                $this->_save_contact($res_deudor->person_id, $correo, 3);
            }
        }
        /**
         * Almacena garantes
         */
        $nombres_garante = $matriz_completa["nombre_apellido_garante"];
        
        $direccion_garante = $matriz_completa["direccion_garante"];

 //       $obj_ref_garante = new Clientreferencias();
 //       $obj_ref_garante->set_client_code('');
 //       $obj_ref_garante->set_credit_detail_id($client_id);
        //$obj_ref_garante->set_person_address($direccion_garante);
        //$obj_ref_garante->set_person_address_ref('');
        //$obj_ref_garante->set_person_name($nombres_garante);
        //$obj_ref_garante->set_reference_type_id(1);
        //$res_garante = $obj_ref_garante->save();

        //if ($res_garante){
            $telefonos_garante = $matriz_completa["telefono_garante"];
          //  if (strlen($telefonos_garante)>6) {
          //      $this->_save_contact($res_garante->person_id, $telefonos_garante, 2);
          //  }
        //}
		if(!empty($nombres_garante)){
            $array_nombre = explode(';', $nombres_garante);
            $array_direccion = explode(';', $direccion_garante);
            $array_telefonos = explode(';', $telefonos_garante);
            
            for($i=0; $i<=count($array_nombre); $i++){
                
                $nombre_contact=$array_nombre[$i];               
                $direccion_contact=$array_direccion[$i];
                $tetelefono_contact=$array_telefonos[$i];
                
                 if(strlen($nombre_contact)>5){  
                $obj_ref_garante = new Clientreferencias();
                $obj_ref_garante->set_client_code('');
                $obj_ref_garante->set_credit_detail_id($client_id);
                $obj_ref_garante->set_person_address($direccion_contact);
                $obj_ref_garante->set_person_address_ref('');
                $obj_ref_garante->set_person_name($nombre_contact);
                $obj_ref_garante->set_reference_type_id(1);
                $res_garante = $obj_ref_garante->save();
                              
                if ($res_garante) {
                   // if (strlen($tetelefono_contact)>6) {
                    //$this->_save_contact($res_garante->person_id, $tetelefono_contact, 2);
                    //}
					
					  if (strlen($tetelefono_contact)>6 AND strlen($tetelefono_contact)<9) {
                    $this->_save_contact($res_garante->person_id, $tetelefono_contact, 1);
                    }
					if (strlen($tetelefono_contact)>9) {
                    $this->_save_contact($res_garante->person_id, $tetelefono_contact, 2);
                    }
                }  
				 }				
            }
        }
        /**
         * Almacena referencias
         */
        $nombres_referencia = $matriz_completa["nombre_apellido_referencia"]; 
        $telefonos_referencia = $matriz_completa["telefono_referencia"];

		   if(!empty($nombres_referencia)){
            $array_nombre_referencia = explode(';', $nombres_referencia);
            $array_telefonos_referencia = explode(';', $telefonos_referencia);
            
            for($i=0; $i<=count($array_nombre_referencia); $i++){
                
                $nombre_referencia_contact=$array_nombre_referencia[$i];               
                $telefono_referencia_contact=$array_telefonos_referencia[$i];
                if(strlen($nombre_referencia_contact)>5){
					$obj_ref_2 = new Clientreferencias();
                $obj_ref_2->set_client_code('');
                $obj_ref_2->set_credit_detail_id($client_id);
                $obj_ref_2->set_person_address('');
                $obj_ref_2->set_person_address_ref('');
                $obj_ref_2->set_person_name($nombre_referencia_contact);
                $obj_ref_2->set_reference_type_id(2);
                $res_ref2 = $obj_ref_2->save();
                if ($res_ref2) {  
				
                    if (strlen($telefono_referencia_contact)>6 AND (strlen($telefono_referencia_contact)<9 ) ) {
                        $this->_save_contact($res_ref2->person_id, $telefono_referencia_contact, 1);       
                    }
					if (strlen($telefono_referencia_contact)>9  ) {
                        $this->_save_contact($res_ref2->person_id, $telefono_referencia_contact, 2);       
                    }
					
                }
				}
                
            }
        }
    }

    function _save_contact($person_id, $contact, $contact_type) {
        $contact_data = (new gestcobra\contact_model())
                ->where('person_id', $person_id)
				//->where('contact_type_id', $contact_type)
                ->where('contact_value', $contact)
				->find_one();

        $contact_data->person_id = $person_id;
        $contact_data->contact_type_id = $contact_type;
        $contact_data->contact_value = $contact;
        $contact_data->description = '';
        $contact_data->save();
		//		}
        return $contact;

    }
    
    
    private function _get_gestor_id($gestor, $gestor_codigo) {
        $firstname = strtoupper($gestor);
                $oficial_credito = (new \gestcobra\oficial_credito_model())
                ->where('cedula', $gestor_codigo)
                ->where('status', '1')
                ->find_one();
        if (!$oficial_credito->id > 0) {
            $oficial_credito->password = $this->encrypt_password_callback('1234');
            $oficial_credito->cedula = $gestor_codigo;
            $oficial_credito->email = $gestor_codigo . "@" . $gestor_codigo;
            $oficial_credito->firstname = $firstname;
			$oficial_credito->oficina_company_id = 100;
            $oficial_credito->company_id = 18;
            $oficial_credito->role_id = 4; /* Gestor */
            $oficial_credito->save();
        }
            
        return $oficial_credito->id;
    }
    

    function _get_oficial_credito_id($oficial_firstname, $oficial_credito_cedula, $oficina_id) {
        $firstname = strtoupper($oficial_firstname);
        $oficial_credito = (new \gestcobra\oficial_credito_model())
                ->where('oficina_company_id', $oficina_id)
                ->where('cedula', $oficial_credito_cedula)
                ->where('status', '1')
                ->find_one();
        if (!$oficial_credito->id > 0) {
            $oficial_credito->password = $this->encrypt_password_callback('1234');
            $oficial_credito->cedula = $oficial_credito_cedula;
            $oficial_credito->email = $oficial_credito_cedula;
            $oficial_credito->firstname = $firstname;
            $oficial_credito->oficina_company_id = $oficina_id;
            $oficial_credito->company_id = 18;
            $oficial_credito->role_id = 1; /* Oficial de credito */
            $oficial_credito->save();
        }
        
        return $oficial_credito->id;
    }

    function encrypt_password_callback($clave) {
        $pass_word = (new gestcobra\setup_model())->where('variable', 'PASSWORDSALTMAIN')->find_one()->valor;
        $encryptedPass = MD5($clave . $pass_word);
        return $encryptedPass;
    }

    function _get_oficina_id($oficina_name) {
        $oficina = (new gestcobra\oficina_company_model())
                ->where('company_id', 18)
                ->where('name', $oficina_name)
                ->where('status', '1')
                ->find_one();
        $oficina->company_id = 18;
        $oficina->name = $oficina_name;
        $oficina->save();
        return $oficina->id;
    }

    /**
     * Busca datos de oficial de crédito por usuario y contraseña
     * @param type $param
     */
public function actualiza_get() {
		$client = new SoapClient("http://192.168.187.152/FBSEventosBatch/ServicioGestCobra.asmx?WSDL");
  $xml = $client->ObtenerDatosModuloExtrajudicialDia();
  $xml2= $xml->ObtenerDatosModuloExtrajudicialDiaResult;
  $xml3=$xml2->string;
  		if(count($xml3)==1){
			$xml3=array($xml3);
		}

		foreach ($xml3 as $linea) {
			$array = explode("|", $linea);	
			
			$credito=trim($array[0]);
			$pago=$array[1];
			$identificador = $array[2];
			
			$credit_detail = (new gestcobra\credit_detail_model())
                ->where('nro_pagare', $credito)
                ->find_one();
				
				
				if ($credit_detail->id != 0){
				
					$id_credito = $credit_detail->id;
                    $pago_minimo = $credit_detail->total_cuotas_vencidas;
					
					if($identificador == 1){
						$credit_detail->credit_status_id = 22;
						$total=$credit_detail->total_pagar+ $pago;
						$credit_detail->total_pagar=$total;
						$credit_detail->save();
					}
					
					if($identificador == 0){
						$total=$credit_detail->total_pagar+ $pago;
						$credit_detail->total_pagar=$total;
						$credit_detail->credit_status_id = 5;
						$credit_detail->save();
						
							$abono = (new gestcobra\abono_model());
							$abono->credit_detail_id = $id_credito;
							$abono->date_abono = date('Y-m-d', time());       
							$abono->amount = $pago;	
							$abono->save();
														        							
							
					}	
				}	
			
		}
}

	public function sms_get($clave,$num,$texto) {
		if($clave=="56432"){
			echo "ENVIANDO SMS";
		$texto1= str_replace("%20", " ", $texto);
		$obj_commws = new Commws();
		$obj_commws->http_conn_comunication_simple($num,$texto1);
		}else{
			echo "ERROR ACCESO DENEGADO";
		}
	}

public function notificacion_get() {
		$client = new SoapClient("http://192.168.187.152/FBSEventosBatch/ServicioGestCobra.asmx?WSDL");
		$xml = $client->ObtenerDatosModuloNotificaciones();
		$xml2= $xml->ObtenerDatosModuloNotificacionesResult;
		$xml3=$xml2->string;
		if(count($xml3)==1){
			$xml3=array($xml3);
		}

		foreach ($xml3 as $linea) {
			$array = explode("|", $linea);	
			
			$credito=trim($array[0]);
			$pago=$array[1];
			$notificacion_id = $array[2];
			
			$credit_detail = (new gestcobra\credit_detail_model())
                ->where('nro_pagare', $credito)
                ->find_one();
				
				
				if ($credit_detail->id != 0){
				
					$id_credito = $credit_detail->id;
					
					$client_referencia= (new gestcobra\client_referencias_model())
					->where('credit_detail_id', $id_credito)
					->where('reference_type_id', 3)
					->find_one();
                    
					
					$comunication = new gestcobra\comunication_model();
					$comunication->type = 'visita';
					$comunication->status = -1;
					$comunication->contact = 'visita';
					$comunication->curr_date = date("Y-m-d", time());
					$comunication->curr_time = date("H:i:s", time());
					$comunication->user_id = $this->user->id;
					$comunication->comunication_type_id = 5;
					$comunication->client_referencias_id = $client_referencia->id;
					$comunication->notification_format_id = $notificacion_id;
					$comunication->save();
					
					
					$credit_detail->total_cuotas_vencidas = $pago;
					$credit_detail->save();
	
				}	
			
		}
}

}
?>