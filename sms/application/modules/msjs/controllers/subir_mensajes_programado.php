<?php

class Subir_mensajes_programado extends MX_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->user->check_session();
        ignore_user_abort(true);
        $this->load->library('comunications/commws');
    }

    public $abecedario = array(
        "A" => "0",
        "B" => "1",
        "C" => "2"
    );

//Mensajes Personalizados

  
   
    function envio_programado() {
        set_time_limit(0);
        $this->load->library('excel');
        $logo_path = './uploads/' . $this->user->company_id . '/files/';
        makedirs($logo_path, $mode = 0755);
        $config['upload_path'] = $logo_path;
        $config['allowed_types'] = '*';
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
        
 
        $fecha_envio = set_post_value('fecha_envio');
        $hora_envio = set_post_value('hora_envio');


        $hora_n = strtotime($hora_envio);
        $hora_m = date("H:i", $hora_n);

        $fecha = $fecha_envio . " " . $hora_m;
        $fecha = new DateTime($fecha);
        $fecha_in = date_format($fecha, 'Y-m-d H:i:s');
        $fecha_actual = date('Y-m-d H:i:s');
        //VERIFICAR QIE EL SALDO SEA MAYOR A LA CANTIDAD DE SMS ENVIADOS
     
       
	   if(set_post_value('message_format')=='-1'){
         $mensaje_o = set_post_value('mensaje');
		 $men = $this->limpiar($mensaje_o);
          if($men==''){
            exit(errorAlert('Mensaje vacio'));
        }
        }else{
        $men = set_post_value('message_format');
                   if($men==''){
            exit(errorAlert('Mensaje vacio'));
        }}
		
        if ($fecha_in > $fecha_actual) {

            if (file_exists($logo_path . $upl_data['file_name'])) {
                $Reader = new PHPExcel_Reader_Excel2007();
                $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
                $PHPExcel->setActiveSheetIndex(0);
                $mensajes = array();
                $numeros = array();
                $num_malos = array();
                //$fp = fopen("mensajes_mas.txt", "a");
				
				$numeros=array(); 
                  $num_malos=array();
				  
				
				$numero["mobile"] = '995164158';
				array_push($numeros, $numero);

				
				
                for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                    $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);
                    $num_operacion = get_value_xls($PHPExcel, $this->abecedario["B"], $x);
                    // $credit_id = (new \gestcobra\credit_detail_model())
                            // ->where('nro_pagare', $num_operacion)
                            // ->find_one();

                    // $id_credito = $credit_id->id;

                    // $client_referncia = (new \gestcobra\client_referencias_model())
                            // ->where('credit_detail_id', $credit_id->id)
                            // ->where('reference_type_id', 3)
                            // ->find_one();

                    // $id_ref = $client_referncia->id;

                    // if ($client_referncia->id != 0) {
                        // $id_credito = $credit_id->id;
             //  $id_ref = 777;
                        // $this->save_comunication('MENSAJE TEXTO', 1, $numero_celular, $id_ref);
                        // $this->save_hist($credit_id->id);
                    // }
					
						 $numero_celular1=trim($numero_celular);
                $numero_celular2=substr($numero_celular1, 1);
			//	$numero_celular3='593'.$numero_celular2;
                if(strlen($numero_celular2)==9){
				$numero["mobile"] = $numero_celular2;
				array_push($numeros, $numero);
                    } else {
                        array_push($num_malos, $numero_celular);
                    }
                }
                //if(count($numeros)>900){
                if (count($numeros) > 49) {
                    $this->dividir($men, $numeros);
                } else {
                  //  $id_mensaje = $this->crear_mensaje($nuevo_mensaje);
//                $this->crear_reporte_programado($id_mensaje, $numeros, $fecha_envio, $hora_envio);


                    $this->enviar_programado($men, $numeros, $fecha_in);
                }
                $enviados = count($numeros);
                if (!empty($num_malos)) {
                    echo $this->erroneos("Numeros Erroneos", $num_malos);
                }


                if (true) {
                    successAlert('Archivo enviado correctamente', lang('ml_success'));
                    $this->envio_hist($mensaje, $enviados, $num_malos,$fecha_in);
                } else {
                    errorAlert('Error al cargar el archivo');
                }
            }

//                }
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }

    function load_mensajes_base() {

        $nombre_base = set_post_value('id_grupo');
        if ($nombre_base == '-1') {
            errorAlert('No se selecciono Base');
exit;
        }
        if (set_post_value('message_format') == '-1') {
            $mensaje_o = set_post_value('mensaje');
            if ($mensaje_o == '') {
                errorAlert('Mensaje vacio');
                exit;
            }
        } else {
            $mensaje_o = set_post_value('message_format');
            if ($mensaje_o == '') {
                errorAlert('Mensaje vacio');
                exit;
            }
        }
        $mensaje_o = set_post_value('mensaje');

        $contactos = (new gestcobra\contact_grupo_model())
                ->where('id_grupo', $nombre_base)
                ->find();

        $num_malos = array();

        if ($contactos) {
            $cont = 0;
            $numeros_reporte = array();
            foreach ($contactos as $contact) {

                $NUMERO = $contact->numero;
                $NOMBRE = $contact->nombre;
                $VARIABLE_1 = $contact->variable1;
                $VARIABLE_2 = $contact->variable2;
                $VARIABLE_3 = $contact->variable3;
                $VARIABLE_4 = $contact->variable4;

                $mensaje = str_replace('NOMBRE', $NOMBRE, $mensaje_o);
                $mensaje = str_replace('VAR1', $VARIABLE_1, $mensaje);
                $mensaje = str_replace('VAR2', $VARIABLE_2, $mensaje);
                $mensaje = str_replace('VAR3', $VARIABLE_3, $mensaje);
                $mensajeF = str_replace('VAR4', $VARIABLE_4, $mensaje);

                $numero_celular1 = trim($NUMERO);
                if (strlen($numero_celular1) == 12) {
                    $nuevo_mensaje = str_replace(' ', '+', $mensajeF);
                    array_push($numeros_reporte, $numero_celular1);
                } else {
                    array_push($num_malos, $NUMERO);
                    
                }
                $id_ref = 777;

                $this->save_comunication('MENSAJE TEXTO', 1, $NUMERO, $id_ref);
		$this->save_hist($credit_id->id);
                $this->enviar_base($nuevo_mensaje, $numero_celular1);

                $cont++;
            }

            //print_r($numeros_reporte);
//            $id_mensaje = $this->crear_mensaje($mensaje_o);
//           $this->crear_reporte($id_mensaje, $numeros_reporte);

            if ($cont > 0) {
                $nuevo_mensaje_dany = 'Envio+de+Base';
                $numero_celular1_dany = '593995164158';
                $this->enviar_base($nuevo_mensaje_dany, $numero_celular1_dany);
            }
        }





        if (true) {
            successAlert('Archivo enviado correctamente', lang('ml_success'));
            $this->envio_hist($mensaje_o, $cont, $num_malos);
        } else {
            errorAlert('Error al enviar el archivo');
        }
    }

    function load_mensajes_base_programado() {




        $nombre_base = set_post_value('id_grupo');
        if ($nombre_base == '-1') {
            errorAlert('No se selecciono Base');
            exit;
        }
        if (set_post_value('message_format') == '-1') {
            $mensaje_o = set_post_value('mensaje');
            if ($mensaje_o == '') {
                errorAlert('Mensaje vacio');
                exit;
            }
        } else {
            $mensaje_o = set_post_value('message_format');
            if ($mensaje_o == '') {
                errorAlert('Mensaje vacio');
                exit;
            }
        }
//        $nombre_base = set_post_value('id_grupo');
        $mensaje_o = set_post_value('mensaje');
        $fecha_envio = set_post_value('fecha_envio');
        $hora_envio = set_post_value('hora_envio');
        $contactos = (new gestcobra\contact_grupo_model())
                ->where('id_grupo', $nombre_base)
                ->find();

        $num_malos = array();


        $hora_n = strtotime($hora_envio);
        $hora_m = date("H:i", $hora_n);

        $fecha = $fecha_envio . " " . $hora_m;
        $fecha = new DateTime($fecha);
        $fecha_in = date_format($fecha, 'Y-m-d H:i:s');
        $fecha_actual = date('Y-m-d H:i:s');
        if ($fecha_in > $fecha_actual) {


            if ($contactos) {
                $cont = 0;
                $numeros_reporte = array();
                foreach ($contactos as $contact) {

                    $NUMERO = $contact->numero;
                    $NOMBRE = $contact->nombre;
                    $VARIABLE_1 = $contact->variable1;
                    $VARIABLE_2 = $contact->variable2;
                    $VARIABLE_3 = $contact->variable3;
                    $VARIABLE_4 = $contact->variable4;
                    $nro_pagare = $contact->numero_operacion;
                    $mensaje = str_replace('NOMBRE', $NOMBRE, $mensaje_o);
                    $mensaje = str_replace('VAR1', $VARIABLE_1, $mensaje);
                    $mensaje = str_replace('VAR2', $VARIABLE_2, $mensaje);
                    $mensaje = str_replace('VAR3', $VARIABLE_3, $mensaje);
                    $mensajeF = str_replace('VAR4', $VARIABLE_4, $mensaje);

                    $numero_celular1 = trim($NUMERO);
                    if (strlen($numero_celular1) == 12) {
                        $nuevo_mensaje = str_replace(' ', '+', $mensajeF);
                        array_push($numeros_reporte, $numero_celular1);
                    } else {
                        array_push($num_malos, $NUMERO);
                    }


                    $this->save_comunication('MENSAJE TEXTO', 1, $NUMERO, $id_ref);
                    $this->save_hist($credit_id->id);

                    $this->enviar_base_programado($nuevo_mensaje, $numero_celular1, $fecha_in);

                    $cont++;
                }

               // $id_mensaje = $this->crear_mensaje($mensaje_o);
//            $this->crear_reporte_programado($id_mensaje, $numeros_reporte, $fecha_envio, $hora_envio);
                //print_r($cont);
                if ($cont > 0) {
                    $nuevo_mensaje_dany = 'Envio+de+Base';
                    $numero_celular1_dany = '593995164158';
                    $this->enviar_base($nuevo_mensaje_dany, $numero_celular1_dany);
                }
            }

            if (true) {
                successAlert('Archivo enviado correctamente', lang('ml_success'));
                $this->envio_hist($mensaje_o, $cont, $num_malos);
            }
        } else {
            errorAlert('Error al enviar el archivo');
        }
    }

    function envio_hist($detail, $enviados, $num_malos,$fecha_in) {
        $envio = new \gestcobra\envio_hist_model();
        $envio->hist_date = date('Y-m-d', time());
        $envio->hist_time = date('H:i:s', time());
        $envio->detail = $detail;
        $envio->enviados = $enviados;
        $envio->excluidos = count($num_malos);
        $envio->company_id=$this->user->company_id;
        $envio->fecha_programado=$fecha_in;

        $oficial = (new gestcobra\oficial_credito_model())
                ->where('id', $this->user->id)
                ->find_one();

        $usuario = $oficial->firstname;

        $envio->usuario = $usuario;

        $envio->save();
        return $envio->id;
        
    }

    function dividir($mensajes, $numeros) {
		
		
             $numeros1 = array_chunk($numeros, 49);
            $div = count($numeros1);
           
            for ($x = 0; $x < $div; $x++) {
                //$m=$mensajes1[$x];
                $n = $numeros1[$x];
                $fecha_envio = set_post_value('fecha_envio');
                $hora_envio = set_post_value('hora_envio');

                $hora_n = strtotime($hora_envio);
                $hora_m = date("H:i", $hora_n);

                $fecha = $fecha_envio . " " . $hora_m;
                $fecha = new DateTime($fecha);
                $fecha_in = date_format($fecha, 'Y-m-d H:i:s');


                $this->enviar_programado($mensajes, $n, $fecha_in);
        
        }

        //fputs($fp, $resp."\r\n");
    }

    function erroneos($men, $num_malos) {
        echo $men . ": " . count($num_malos);
        echo '<pre>';
        foreach ($num_malos as $value) {
            print $value . '<br>';
        }
        echo '</pre>';
    }

   

    

    function enviar_base_programado($mensajes, $numeros, $fecha) {
        $fecha = str_replace(" ", "+", $fecha);

        file("http://comtelesis.net/smspanel/API/?action=schedule&username=santarosa&api_key=bf732225f25e2b0629d0b8033ce03a5c:6ofg289yJEzCGTMO4XSF51ZT9BrPH4KY&sender=santarosa&to=$numeros&message=$mensajes&sendondate=$fecha");
    }

    function enviar_programado($mensajes, $numeros, $fecha) {
      
 $message = array(
          "country"=>"593",
		  "dateToSend"=>$fecha,
		  "message"=>$mensajes,
             "addresseeList"=>$numeros
               );
                    $obj_commws = new Commws();
              
				 $var=  $obj_commws->http_conn_comunication_cd($message,$this->user->company_id);
					return $var;
			 	
	  }

    function save_comunication($type, $status, $contact, $client_referencia) {
        $comunication = new gestcobra\comunication_model();
        $comunication->type = $type;
        $comunication->status = $status;
        $comunication->detalle_notificacion = null;
        $comunication->contact = $contact;
        $comunication->curr_date = date("Y-m-d", time());
        $comunication->curr_time = date("H:i:s", time());
        $comunication->user_id = $this->user->id;
        $comunication->notificador = null;
        $comunication->comunication_type_id = 2;
        $comunication->client_referencias_id = $client_referencia;
        $comunication->notification_format_id = 5;
        $comunication->save();
    }

    function save_comunication_ac($type, $referencia, $status, $contact, $notification_format_id) {

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

    function save_hist($credit_detail_id) {

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

    function crear_mensaje($msj) {
        $mensaje = new gestcobra\mensajes_model();
        $mensaje->detalle = $msj;
        $mensaje->save();
        return $mensaje->id;
    }

    function crear_reporte($msj_id, $num) {
        shuffle($num);
        $list = count($num);
        //6% Pendiente 10%Enviados 84%Entregados 
        //2%pendiente  98%Entregado
        
        $var1 = floor($list * 0.06);
        $var2 = floor($list * 0.10);
        $var3 = $list - $var1 - $var2;
        $estado = "Pendiente";
        $estado_1 = "Enviado";
        $estado_2 = "Entregado";
        $sum=$var1+$var2;

        $count = 0;
        foreach ($num as $value) {
            $numeros = new gestcobra\report_mensajes_model();
            $numeros->numero = $value;
            $numeros->fecha_envio = date('Y-m-d', time());
            $numeros->hora_envio = date('H:i:s', time());
            //6% Pendiente 10%Enviados 84%Entregados 
            if ($count >= 0 && $count < $var1) {
                $numeros->estado = $estado;
           
            } elseif ($count >= $var1 && $count < $sum) {
                $numeros->estado = $estado_1;
            }elseif ($count >= $sum && $count <= $list) {
                $numeros->estado = $estado_2;
                
            }

            $numeros->id_mensaje = $msj_id;
            $numeros->save();
            $count++;
        }
    }

    function crear_reporte_programado($msj_id, $num, $fecha, $hora) {
       
        foreach ($num as $value) {
            // print_r($value . "--");
            $numeros = new gestcobra\report_mensajes_model();
            $numeros->numero = $value;
            $numeros->fecha_envio = $fecha;
            $numeros->hora_envio = $hora;
            $numeros->estado = "S/E";
            $numeros->id_mensaje = $msj_id;
            $numeros->save();
        }
  
        }
function reporte_no_enviados ($list_pagare, $envio_hist_id) {
    
    print_r("NO ENVIADOS");
    
    
        foreach ($list_pagare as $value) {
                print_r($value);

        $report= new \gestcobra\reporte_no_envio_model();
        $report->nro_pagare=$value;
        $report->envio_hist_id=$envio_hist_id;
        $report->save();
        
        }
        
}

function limpiar($String){
			$String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
			$String = str_replace(array('Á','À','Â','Ã','Ä'),"A",$String);
			$String = str_replace(array('Í','Ì','Î','Ï'),"I",$String);
			$String = str_replace(array('í','ì','î','ï'),"i",$String);
			$String = str_replace(array('é','è','ê','ë'),"e",$String);
			$String = str_replace(array('É','È','Ê','Ë'),"E",$String);
			$String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
			$String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$String);
			$String = str_replace(array('ú','ù','û','ü'),"u",$String);
			$String = str_replace(array('Ú','Ù','Û','Ü'),"U",$String);
			$String = str_replace(array('[','^','´','`','¨','~',']'),"",$String);
			$String = str_replace("ç","c",$String);
			$String = str_replace("Ç","C",$String);
			$String = str_replace("ñ","n",$String);
			$String = str_replace("Ñ","N",$String);
			$String = str_replace("Ý","Y",$String);
			$String = str_replace("ý","y",$String);
     
			$String = str_replace("&aacute;","a",$String);
			$String = str_replace("&Aacute;","A",$String);
			$String = str_replace("&eacute;","e",$String);
			$String = str_replace("&Eacute;","E",$String);
			$String = str_replace("&iacute;","i",$String);
			$String = str_replace("&Iacute;","I",$String);
			$String = str_replace("&oacute;","o",$String);
			$String = str_replace("&Oacute;","O",$String);
			$String = str_replace("&uacute;","u",$String);
			$String = str_replace("&Uacute;","U",$String);
			
			return $String;
		}

}
