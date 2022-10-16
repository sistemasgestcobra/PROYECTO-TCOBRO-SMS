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
//Mensajes Masivos
    
     function load_mensajes_masivos() {

        set_time_limit(0);
        $this->load->library('excel');
        $logo_path = './uploads/' . $this->user->company_id . '/files/';
        makedirs($logo_path, $mode = 0755);
        $config['upload_path'] = $logo_path;   $config['allowed_types'] = '*'; $config['max_size'] = '0'; $config['max_width'] = '0';
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
        $mensaje=  set_post_value('mensaje');
		$men = $this->limpiar($mensaje);
		 
        if (file_exists($logo_path . $upl_data['file_name'])) {
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $PHPExcel->setActiveSheetIndex(0);
                  
                  $numeros=array(); 
                  $num_malos=array();
				  
				
			//	$numero["mobile"] = '995164158';
			
//array_push($numeros, $numero);
				
            //$fp = fopen("mensajes_mas.txt", "a");
            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);
                $num_operacion = get_value_xls($PHPExcel, $this->abecedario["B"], $x);
                
                $credit_id = (new \gestcobra\credit_detail_model())
                        ->where('nro_pagare', $num_operacion)
                        ->find_one();
                
                $id_credito= $credit_id->id;               
                
                $client_referncia = (new \gestcobra\client_referencias_model())
                        ->where('credit_detail_id', $credit_id->id)
                        ->where('reference_type_id', 3)
                        ->find_one();
                
                $id_ref= $client_referncia->id;
                
                if($client_referncia->id != 0 ){
                    $id_credito= $credit_id->id;
                    $id_ref= $client_referncia->id;
                    $this->save_comunication('MENSAJE TEXTO', 1, $numero_celular, $id_ref );
                    $this->save_hist($credit_id->id);
                }
                
                $numero_celular1=trim($numero_celular);
                $numero_celular2=substr($numero_celular1, 1);
			//	$numero_celular3='593'.$numero_celular2;
                if(strlen($numero_celular2)==9){
				$numero["mobile"] = $numero_celular2;
				array_push($numeros, $numero);
			
                
                }else{
                    array_push($num_malos, $numero_celular);
                }
            }
		
		// print_r($enviados);
            if(count($numeros)>49){
                
                $this->dividir($men,$numeros);
            }else{
          $var=  $this->enviar($men,$numeros);
                
            }
                $enviados = count($numeros);
                if(!empty($num_malos)){
                    echo $this->erroneos("Numeros Erroneos",$num_malos);
                }
            	
           if (true) {
                
                successAlert('Archivo cargado correctamente', lang('ml_success'));
                $this->envio_hist($mensaje,$enviados,$num_malos);   
                
                
            } else {
                errorAlert('Error al cargar el archivo');
            }
        } else {
            errorAlert('Error al cargar el archivo');
        }
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
    
	
    function dividir($mensajes,$numeros) {
       $numeros1=array_chunk($numeros, 49);
            $div= count($numeros1);
			
            for($x=0;$x<$div;$x++){
				
                  $n=$numeros1[$x];
			
               $this->enviar($mensajes, $n);
                
            }
         }
    
     function erroneos($men,$num_malos) {
         echo $men.": ".count($num_malos);
                    echo '<pre>';
                    foreach ($num_malos as $value) {
                        print $value.'<br>';
                    }
         echo  '</pre>';
    }
    
    function enviar($mensajes,$numeros) {
		
     $message = array(
          "country"=>"593",
            "message"=>$mensajes,
             "addresseeList"=>$numeros
               );
                    $obj_commws = new Commws();
              
				 $var=  $obj_commws->http_conn_comunication_cd($message);
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
    
	
	    function load_mensajes_base() { 
			 
        $nombre_base = set_post_value('id_grupo');
        if($nombre_base=='-1'){
            exit(errorAlert('No se selecciono Base'));
        }
        if(set_post_value('message_format')=='-1'){
         $mensaje_o = set_post_value('mensaje');
          if($mensaje_o==''){
            exit(errorAlert('Mensaje vacio'));
        }
        }else{
         $mensaje_o = set_post_value('message_format');
                   if($mensaje_o==''){
            exit(errorAlert('Mensaje vacio'));
        }
        }
       
        $contactos = (new gestcobra\contact_grupo_model())
                ->where('id_grupo', $nombre_base)
                ->find();
      //  $mensajes = array();
        
        $num_malos=array();
	//	$numero["mobile"] = '995164158';
		//array_push($numeros, $numero);
        
		if ($contactos) {
			 $nuevo_mensaje_dany = 'Envio de Base';
             
			 $numero["mobile"] = '995164158';
				$numero1["mobile"] = '992556483';//call center
				$numero2["mobile"] = '987536756'; // jefe cobranzas
array_push($numeros, $numero);
array_push($numeros, $numero1);
array_push($numeros, $numero2);
				
				
				      $this->enviar(  $nuevo_mensaje_dany, $numeros);
			
            foreach ($contactos as $contact) {
                $NUMERO = $contact->numero;
                $NUM_OPERACION= $contact->numero_operacion;
                //print_r($NUM_OPERACION);
                
                
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
                
                $numero_celular1=trim($NUMERO);
				$numero_celular2=substr($numero_celular1, 1);
                if(strlen($numero_celular2)==9){					
				$men = $this->limpiar($mensajeF);	
                //array_push($mensajes, $men);
             //   array_push($numeros, $numero_celular2);
			 $numeros = array();
				$numero["mobile"] = $numero_celular2;
				array_push($numeros, $numero);
				
                }else{
                    array_push($num_malos, $NUMERO);
                }
                
                $credit_id = (new \gestcobra\credit_detail_model())
                        ->where('nro_pagare', $NUM_OPERACION)
                        ->find_one();
                
                
                $client_referncia = (new \gestcobra\client_referencias_model())
                        ->where('credit_detail_id', $credit_id->id)
                        ->where('reference_type_id', 3)
                        ->find_one();
                
                $id_ref= $client_referncia->id;
                //print_r($id_ref); 
                
                
                if($client_referncia->id != 0 ){
                    //$id_credito= $credit_id->id;
                 //
                    $id_ref= $client_referncia->id;
                 
                    $this->save_comunication('MENSAJE TEXTO', 1, $NUMERO, $id_ref );
                    $this->save_hist($credit_id->id);
                     
				
                 $cont++;
				}
                 $this->enviar($men, $numeros);
               }
                if ($cont > 0) {
             
            }
        }

               // $this->enviar($men, $numeros);
                
           

        $enviados = count($numeros);

        if (true) {
            successAlert('Archivo cargado correctamente', lang('ml_success'));
            $this->envio_hist($mensaje_o, $enviados, $num_malos);
        } else {
            errorAlert('Error al cargar el archivo');
        }
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
        $credti_hist->compromiso_pago_date = date(0000-00-00);
        $credti_hist->save();
       
    }
function leer() {
            $mensaje_o = set_post_value('message_format');
            //leer($mensaje_o);
            echo 'MENSAJE A ENVIAR';
            echo '</br>';
            echo $mensaje_o;
            //break;
        }
		function leer1() {
            $notif_id = set_post_value('notif_id');
            //leer($mensaje_o);
            echo 'MENSAJE A ENVIAR';
            echo '</br>';
            $notificacion = new gestcobra\notification_format_model($notif_id[0]);
            echo $notificacion->format;
            //break;
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


