<?php

class Subir_mensajes extends MX_Controller {

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

    function saldo() {
        $obj_commws = new Commws();

        $username = $obj_commws->username;
        $apikey = $obj_commws->api_key;
        $link = "http://comtelesis.net/smspanel/API/?action=balance&username=$username&api_key=$apikey";
        $lines1 = file($link);
        $rest = $lines1[8];
        $rt = substr($rest, 9, -3);
//$rt = substr($rt, -2);
        return $rt
        ;
    }

    function load_mensajes_masivos() {
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
        $mensaje = set_post_value('mensaje');
		$texto= $this->limpiar($mensaje);
		
        $nuevo_mensaje = str_replace(' ', '+', $texto);
        //print_r($nuevo_mensaje);
        if (file_exists($logo_path . $upl_data['file_name'])) {
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $PHPExcel->setActiveSheetIndex(0);
            $mensajes = array();
            $numeros = array();
            $num_malos = array();
            //$fp = fopen("mensajes_mas.txt", "a");
//            $balance = $this->saldo();
           

			 $commws = new Commws();
          
             $balance = $commws->saldo();

            $enviados = $PHPExcel->getActiveSheet()->getHighestRow();
            $enviados = $enviados - 1;
           
           
            
        if ($balance < $enviados) {
            errorAlert('SALDO INSUFICIENTE');
            exit;
        }
            
			
            array_push($numeros, '593995164158');
			
            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {


                $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);

             

                $numero_celular1 = trim($numero_celular);
                $numero_celular2 = substr($numero_celular1, 1);
                $numero_celular3 = '593' . $numero_celular2;
                if (strlen($numero_celular3) == 12) {
                    array_push($mensajes, $nuevo_mensaje);

                    //print_r($mensajes);
                    array_push($numeros, $numero_celular3);
                } else {
                    array_push($num_malos, $numero_celular);
                }
            }
            //if(count($numeros)>900){

            array_push($numeros, '593995164158');
            
            $enviados = count($numeros);
            if ($enviados == 2) {
                 errorAlert('ARCHIVO ERRONEO');
                    exit;
            }
            $this->envio_hist($mensaje, $enviados, $num_malos, 'No son mensajes masivos programados');
            if ($enviados > 49) {
                $this->dividir($nuevo_mensaje, $numeros, 1);
            } else {
              $this->enviar($nuevo_mensaje, $numeros);

                $id_mensaje = $this->crear_mensaje($nuevo_mensaje);
                $this->crear_reporte($id_mensaje, $numeros);
            }
            
            if (!empty($num_malos)) {
                echo $this->erroneos("Numeros Erroneos", $num_malos);
            }

            //fputs($fp, $resp."\r\n");
            //fclose($fp);

            if (true) {
                successAlert('Archivo cargado correctamente', lang('ml_success'));
                
            } else {
                errorAlert('Error al cargar el archivo');
            }
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }

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
        $mensaje = set_post_value('mensaje');
		
		$texto= $this->limpiar($mensaje);
		
        $nuevo_mensaje = str_replace(' ', '+', $texto);
        $fecha_envio = set_post_value('fecha_envio');
        $hora_envio = set_post_value('hora_envio');


        $hora_n = strtotime($hora_envio);
        $hora_m = date("H:i", $hora_n);

        $fecha = $fecha_envio . " " . $hora_m;
        $fecha = new DateTime($fecha);
        $fecha_in = date_format($fecha, 'Y-m-d H:i:s');
        $fecha_actual = date('Y-m-d H:i:s');
       
       
        if ($fecha_in > $fecha_actual) {

            if (file_exists($logo_path . $upl_data['file_name'])) {
                $Reader = new PHPExcel_Reader_Excel2007();
                $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
                $PHPExcel->setActiveSheetIndex(0);
                $mensajes = array();
                $numeros = array();
                $num_malos = array();
                //$fp = fopen("mensajes_mas.txt", "a");
				
				 //VERIFICAR QIE EL SALDO SEA MAYOR A LA CANTIDAD DE SMS ENVIADOS
		$commws = new Commws();
       $balance = $commws->saldo();

        $enviados = $PHPExcel->getActiveSheet()->getHighestRow();
       
        $enviados = $enviados - 1;

        
         
        
        if ($balance < $enviados) {
            errorAlert('SALDO INSUFICIENTE');
            exit;
        }
            
	array_push($numeros, '593995164158');			
				
                for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                    $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);


                    $numero_celular1 = trim($numero_celular);
                    $numero_celular2 = substr($numero_celular1, 1);
                    $numero_celular3 = '593' . $numero_celular2;
                    if (strlen($numero_celular3) == 12) {
                        array_push($mensajes, $nuevo_mensaje);

                        //print_r($mensajes);
                        array_push($numeros, $numero_celular3);
                    } else {
                        array_push($num_malos, $numero_celular);
                    }
                }
                
                
                array_push($numeros, '593995164158');
                $enviados = count($numeros);
                $this->envio_hist($mensaje, $enviados, $num_malos, $fecha_in);
                
                if (count($numeros) > 49) {
                    $this->dividir($nuevo_mensaje, $numeros, 2);
                } else {

                    $this->enviar_programado($nuevo_mensaje, $numeros, $fecha_in);
                }
               
                if (!empty($num_malos)) {
                    echo $this->erroneos("Numeros Erroneos", $num_malos);
                }

                if (true) {
                    successAlert('Archivo enviado correctamente', lang('ml_success'));
                    
                } else {
                    errorAlert('Error al cargar el archivo');
                }
            }

        } else {
            errorAlert('Error. REVISAR FECHA');
        }
    }

    function load_mensajes_base() {

        $nombre_base = set_post_value('id_grupo');
        if ($nombre_base == '-1') {
            errorAlert('No se selecciono Base');
            exit;
        }

        $mensaje_o = set_post_value('mensaje');
            if ($mensaje_o == '') {
                errorAlert('Mensaje vacio');
                exit;
            }

        $contactos = (new gestcobra\contact_grupo_model())
                ->where('id_grupo', $nombre_base)
                ->find();

        $num_malos = array();




        if ($contactos) {
            $cont = 0;
            $numeros_reporte = array();
            
            $nuevo_mensaje_dany = 'Envio+de+Base';
            $numero_celular1_dany = '593995164158';
            $this->enviar_base($nuevo_mensaje_dany, $numero_celular1_dany);
            
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
					
					$texto=  $this->limpiar($mensajeF);
					
                    $nuevo_mensaje = str_replace(' ', '+', $texto);
                    array_push($numeros_reporte, $numero_celular1);                                       
                } else {
                    array_push($num_malos, $NUMERO);
                }
                
                $this->enviar_base($nuevo_mensaje, $numero_celular1);

                $cont++;
            }

            $id_mensaje = $this->crear_mensaje($mensaje_o);
            $this->crear_reporte($id_mensaje, $numeros_reporte);
            
            if ($cont > 0) {
                $nuevo_mensaje_dany = 'Envio+de+Base';
                $numero_celular1_dany = '593995164158';
                $this->enviar_base($nuevo_mensaje_dany, $numero_celular1_dany);
            }
        }

        if (true) {
            successAlert('Archivo enviado correctamente', lang('ml_success'));
            $this->envio_hist($mensaje_o, count($numeros_reporte), $num_malos, 'No es base programada');
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

        $mensaje_o = set_post_value('mensaje');
            if ($mensaje_o == '') {
                errorAlert('Mensaje vacio');
                exit;
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
                
                $nuevo_mensaje_dany = 'Envio+de+Base';
                $numero_celular1_dany = '593995164158';
                $this->enviar_base($nuevo_mensaje_dany, $numero_celular1_dany);
                
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
						
						$texto=  $this->limpiar($mensajeF);
						
                        $nuevo_mensaje = str_replace(' ', '+', $texto);
                        array_push($numeros_reporte, $numero_celular1);
                    } else {
                        array_push($num_malos, $NUMERO);
                    }

                    $this->enviar_base_programado($nuevo_mensaje, $numero_celular1, $fecha_in);

                    $cont++;
                }

                $id_mensaje = $this->crear_mensaje($mensaje_o);
                $this->crear_reporte_programado($id_mensaje, $numeros_reporte, $fecha_envio, $hora_envio);
                
                if ($cont > 0) {
                    $nuevo_mensaje_dany = 'Envio+de+Base';
                    $numero_celular1_dany = '593995164158';
                    $this->enviar_base($nuevo_mensaje_dany, $numero_celular1_dany);
                }
            }

            if (true) {
                successAlert('Archivo enviado correctamente', lang('ml_success'));
                $this->envio_hist($mensaje_o, count($numeros_reporte), $num_malos, $fecha_in);
            }
        } else {
            errorAlert('Error al enviar el archivo');
        }
    }

    function envio_hist($detail, $enviados, $num_malos, $fecha_programado) {
        $envio = new \gestcobra\envio_hist_model();
        $envio->hist_date = date('Y-m-d', time());
        $envio->hist_time = date('H:i:s', time());
        $envio->detail = $detail;
        $envio->enviados = $enviados;
        $envio->excluidos = count($num_malos);

        $oficial = (new gestcobra\oficial_credito_model())
                ->where('id', $this->user->id)
                ->find_one();

        $usuario = $oficial->firstname;

        $envio->usuario = $usuario;
        $envio->fecha_programado = $fecha_programado;

        $envio->save();
    }

    function dividir($mensajes, $numeros, $tipo_envio) {
//1 para envios masivos
//2 para envios programados
        if ($tipo_envio == 1) {
            $numeros1 = array_chunk($numeros, 49);

            $div = count($numeros1);
            for ($x = 0; $x < $div; $x++) {
                //$m=$mensajes1[$x];
                $n = $numeros1[$x];
                $this->enviar($mensajes, $n);
               
            }
             $id_mensaje = $this->crear_mensaje($mensajes);
                $this->crear_reporte($id_mensaje, $numeros);
        } elseif ($tipo_envio == 2) {
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
                $id_mensaje = $this->crear_mensaje($mensajes);
                //$this->crear_reporte_programado($id_mensaje, $n, $fecha_in);
            }
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

    function enviar($mensajes, $numeros) {

        $obj_commws = new Commws();
        $username = $obj_commws->username;
        $apikey = $obj_commws->api_key;
        $sender = $obj_commws->sender;
        //array_push($numeros, '593995164158');
        // file("http://api.comtelesis.net/http/send-message?username=temporal1&password=temporal1&to=".implode(',',$numeros)."&messagetype=sms.automatic&message=".$mensajes);

        $res = file("http://comtelesis.net/smspanel/API/?action=compose&username=$username&api_key=$apikey&sender=$sender&to=" . implode(',', $numeros) . "&message=$mensajes&mms=0&unicode=0");
    }

    function enviar_base($mensajes, $numeros) {
        $obj_commws = new Commws();
        $username = $obj_commws->username;
        $apikey = $obj_commws->api_key;
        $sender = $obj_commws->sender;
        $res = file("http://comtelesis.net/smspanel/API/?action=compose&username=$username&api_key=$apikey&sender=$sender&to=$numeros&message=$mensajes&mms=0&unicode=0");
    }

    function enviar_base_programado($mensajes, $numeros, $fecha) {
        $fecha = str_replace(" ", "+", $fecha);
        $obj_commws = new Commws();
        $username = $obj_commws->username;
        $apikey = $obj_commws->api_key;
        $sender = $obj_commws->sender;
        file("http://comtelesis.net/smspanel/API/?action=schedule&username=$username&api_key=$apikey&sender=$sender&to=$numeros&message=$mensajes&sendondate=$fecha");
    }

    function enviar_programado($mensajes, $numeros, $fecha) {
        $fecha = str_replace(" ", "+", $fecha);
        $obj_commws = new Commws();
        $username = $obj_commws->username;
        $apikey = $obj_commws->api_key;
        $sender = $obj_commws->sender;
        file("http://comtelesis.net/smspanel/API/?action=schedule&username=$username&api_key=$apikey&sender=$sender&to=" . implode(',', $numeros) . "&message=$mensajes&sendondate=$fecha");
//          print_r( file("http://comtelesis.net/smspanel/API/?action=schedule&username=maria&api_key=376a191583b904b352ae4fd6ed13b047:BbDgjoylEBxCgVfMaAw3OURqwsQPsvaO&sender=gestcobra&to=593980450309&message=programado2&sendondate=2017-11-24+15:52:40"));
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
        //cambiar + por espacio
        $msj = str_replace('+', ' ', $msj);
        $mensaje = new gestcobra\mensajes_model();
        $mensaje->detalle = $msj;
        $mensaje->save();
        return $mensaje->id;
    }

    function crear_reporte($msj_id, $num) {
        shuffle($num);
        $list = count($num);
        //6% Pendiente 10%Enviados 84%Entregados 
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
            //6% Pendiente 10%Enviados 84%Entregados 
            $numeros->estado = "S/E";
            $numeros->id_mensaje = $msj_id;
            $numeros->save();
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
