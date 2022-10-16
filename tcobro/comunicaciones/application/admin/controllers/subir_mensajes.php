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
     );
    
//Mensajes Personalizados
    function load_mensajes() {
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
        if (file_exists($logo_path . $upl_data['file_name'])) {            
            // Cargando la hoja de c�lculo
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $objFecha = new PHPExcel_Shared_Date();
            // Asignar hoja de excel activa
            $PHPExcel->setActiveSheetIndex(0);
                  $mensajes= array();
                  $numeros=array();
                  $num_malos=array();
            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);
                $mensaje = get_value_xls($PHPExcel, $this->abecedario["B"], $x);
                $numero_celular1=trim($numero_celular);
                if(strlen($numero_celular1)==12 && strlen($mensaje)>1){
                    array_push($mensajes, $mensaje);
                    array_push($numeros, $numero_celular1); 
                }else{
                    array_push($num_malos, $numero_celular1);
                }
            }
            if(count($numeros)>900){
                $this->dividir($mensajes,$numeros);
            }else{
                $this->enviar($mensajes,$numeros);
            }
                $enviados = count($numeros);
                if(!empty($num_malos)){
                    echo $this->erroneos("Numeros Erroneos o Con Mensaje Vacio",$num_malos);
                }
            if (true) {
                successAlert('Archivo cargado correctamente', lang('ml_success'));
                $this->envio_hist("MENSAJES PERSONALIZADOS",$enviados,$num_malos);
            } else {
                errorAlert('Error al cargar el archivo');
            }
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }

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
        if (file_exists($logo_path . $upl_data['file_name'])) {
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $PHPExcel->setActiveSheetIndex(0);
                  $mensajes= array();
                  $numeros=array(); 
                  $num_malos=array();
            //$fp = fopen("mensajes_mas.txt", "a");
            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);
                $numero_celular1=trim($numero_celular);
                if(strlen($numero_celular1)==12){
                array_push($mensajes, $mensaje);
                array_push($numeros, $numero_celular1);
                }else{
                    array_push($num_malos, $numero_celular1);
                }
            }
            if(count($numeros)>900){
                $this->dividir($mensajes,$numeros);
            }else{
                $this->enviar($mensajes,$numeros);
            }
                $enviados = count($numeros);
                if(!empty($num_malos)){
                    echo $this->erroneos("Numeros Erroneos",$num_malos);
                }
            	
                //fputs($fp, $resp."\r\n");
                //fclose($fp);
                
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
        $envio->save();
    }
    
    function dividir($mensajes,$numeros) {
        
        $mensajes1=array_chunk($mensajes, 900);
        $numeros1=array_chunk($numeros, 900);
            $div= count($numeros1);
            for($x=0;$x<$div;$x++){
                $m=$mensajes1[$x];
                $n=$numeros1[$x];
                $this->enviar($m, $n);
                
            }
            //fputs($fp, $resp."\r\n");
                
        
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
        $fp = fopen("mensajes_mas.txt", "a");
                    $message = array(
                    "Mensaje"=>"Hola",
                    "Mensajes"=>$mensajes,
                    "Destinatarios"=>$numeros,
                    "apiKey"=>"8CC10AC182"
                );
                    $obj_commws = new Commws();
                    $resp = $obj_commws->http_conn_comunication_1($message);
                    fputs($fp, $message."\r\n");
                    fputs($fp, $resp."\r\n");
                    fclose($fp);
    }

     function load_mensajes_base() {
        $nombre_base = set_post_value('id_grupo');
        $mensaje_o = set_post_value('mensaje');
        
       
        $contactos = (new gestcobra\contact_grupo_model())
                ->where('id_grupo', $nombre_base)
                ->find();
        $mensajes = array();
        $numeros = array();
        if ($contactos) {
            foreach ($contactos as $contact) {
                $NUMERO = $contact->numero;
                $NOMBRE = $contact->nombre;
                $APELLIDO = $contact->apellido;
                $VARIABLE_1 = $contact->variable1;
                $VARIABLE_2 = $contact->variable2;
                $VARIABLE_3 = $contact->variable3;
                $VARIABLE_4 = $contact->variable4;
                
                $mensaje = str_replace('NOMBRE', $NOMBRE, $mensaje_o);
                $mensaje = str_replace('APELLIDO', $APELLIDO, $mensaje);
                $mensaje = str_replace('VAR1', $VARIABLE_1, $mensaje);
                $mensaje = str_replace('VAR2', $VARIABLE_2, $mensaje);
                $mensaje = str_replace('VAR3', $VARIABLE_3, $mensaje);
                $mensajeF = str_replace('VAR4', $VARIABLE_4, $mensaje);
                
                array_push($numeros, $NUMERO);
                 array_push($mensajes, $mensajeF);
                
               }
               
        }
               print_r("MENSAJE");
               print_r($mensajes);
               print_r("---");
               print_r("NUMEROS");
               print_r($numeros);
                if (count($numeros) > 900) {
                $this->dividir($mensajes, $numeros);
            } else {
//                $this->enviar($mensajes, $numeros);
            }
        $this->enviar($mensajes, $numeros);

        $enviados = count($numeros);

        if (true) {
            successAlert('Archivo cargado correctamente', lang('ml_success'));
            $this->envio_hist("MENSAJES PERSONALIZADOS", $enviados, $num_malos);
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }
    
    }

