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
//     CAMBIAR DATOS DE CUENTA
        $link="http://comtelesis.net/smspanel/API/?action=balance&username=maria&api_key=376a191583b904b352ae4fd6ed13b047:BbDgjoylEBxCgVfMaAw3OURqwsQPsvaO";
$lines1 = file($link);
$rest=$lines1[8];
$rt = substr($rest, 9,-3);
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
        $nuevo_mensaje = str_replace(' ', '+', $mensaje);
        //print_r($nuevo_mensaje);
        if (file_exists($logo_path . $upl_data['file_name'])) {
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $PHPExcel->setActiveSheetIndex(0);
            $mensajes = array();
            $numeros = array();
            $num_malos = array();
            //$fp = fopen("mensajes_mas.txt", "a");
             $balance= $this->saldo();
                $enviados=$PHPExcel->getActiveSheet()->getHighestRow();
                $enviados=$enviados-1;
               
                 if ($balance<$enviados) {
                     errorAlert('SALDO INSUFICIENTE');
                    break;
                }
            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);

                if (strlen($numero_celular) == 12) {
                    array_push($mensajes, $nuevo_mensaje);

                    //print_r($mensajes);
                    array_push($numeros, $numero_celular);
                } else {
                    array_push($num_malos, $numero_celular);
                }
            }
            //if(count($numeros)>900){
            if (count($numeros) > 49) {
                $this->dividir($nuevo_mensaje, $numeros, 1);
            } else {
                $this->enviar($nuevo_mensaje, $numeros);
                $id_mensaje = $this->crear_mensaje($nuevo_mensaje);
                $this->crear_reporte($id_mensaje, $numeros);
            }
            $enviados = count($numeros);
            if (!empty($num_malos)) {
                echo $this->erroneos("Numeros Erroneos", $num_malos);
            }

            if (true) {
                successAlert('Archivo cargado correctamente', lang('ml_success'));
                $this->envio_hist($mensaje, $enviados, $num_malos);
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
        $nuevo_mensaje = str_replace(' ', '+', $mensaje);
        $fecha_envio = set_post_value('fecha_envio');
        $hora_envio = set_post_value('hora_envio');

        
        $hora_n = strtotime($hora_envio);
        $hora_m = date("H:i", $hora_n);
    
           $fecha = $fecha_envio . " " . $hora_m ;
           $fecha=new DateTime($fecha);
           $fecha_in= date_format($fecha, 'Y-m-d H:i:s');
          $fecha_actual= date('Y-m-d H:i:s');
          $balance= $this->saldo();
                $enviados=$PHPExcel->getActiveSheet()->getHighestRow();
                $enviados=$enviados-1;
               
                 if ($balance<$enviados) {
                     errorAlert('SALDO INSUFICIENTE');
                    break;
                }
          if ($fecha_in> $fecha_actual) {
         
        if (file_exists($logo_path . $upl_data['file_name'])) {
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $PHPExcel->setActiveSheetIndex(0);
            $mensajes = array();
            $numeros = array();
            $num_malos = array();
            //$fp = fopen("mensajes_mas.txt", "a");
            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);

           
                if (strlen($numero_celular) == 12) {
                    array_push($mensajes, $nuevo_mensaje);

                    //print_r($mensajes);
                    array_push($numeros, $numero_celular);
                } else {
                    array_push($num_malos, $numero_celular);
                }
            }
            //if(count($numeros)>900){
            if (count($numeros) > 49) {
                $this->dividir($nuevo_mensaje, $numeros, 2);
            } else {
                $id_mensaje = $this->crear_mensaje($nuevo_mensaje);
                $this->crear_reporte_programado($id_mensaje, $numeros, $fecha_envio, $hora_envio);
               
     
                     $this->enviar_programado($nuevo_mensaje, $numeros, $fecha_in);

           
            }
            $enviados = count($numeros);
            if (!empty($num_malos)) {
                echo $this->erroneos("Numeros Erroneos", $num_malos);
            }


            if (true) {
                successAlert('Archivo enviado correctamente', lang('ml_success'));
                $this->envio_hist($mensaje, $enviados, $num_malos);
           
                } else {
                errorAlert('Error al cargar el archivo');
            }
     }
        
        
                } else {
            errorAlert('Error al cargar el archivo');
        }
    }

    function load_mensajes_base() {
$nombre_base = set_post_value('id_grupo');
        if($nombre_base=='-1'){
            errorAlert('No se selecciono Base');
            break;
        }
        if(set_post_value('message_format')=='-1'){
         $mensaje_o = set_post_value('mensaje');
          if($mensaje_o==''){
            errorAlert('Mensaje vacio');
            break;
        }
        }else{
         $mensaje_o = set_post_value('message_format');
                   if($mensaje_o==''){
            errorAlert('Mensaje vacio');
            break;
        }
        }
//        $nombre_base = set_post_value('id_grupo');
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
                $this->enviar_base($nuevo_mensaje, $numero_celular1);

                $cont++;
            }

            //print_r($numeros_reporte);
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
            $this->envio_hist($mensaje_o, $cont, $num_malos);
        } else {
            errorAlert('Error al enviar el archivo');
        }
    }

    function load_mensajes_base_programado() {
$nombre_base = set_post_value('id_grupo');
        if($nombre_base=='-1'){
            errorAlert('No se selecciono Base');
            break;
        }
        if(set_post_value('message_format')=='-1'){
         $mensaje_o = set_post_value('mensaje');
          if($mensaje_o==''){
            errorAlert('Mensaje vacio');
            break;
        }
        }else{
         $mensaje_o = set_post_value('message_format');
                   if($mensaje_o==''){
            errorAlert('Mensaje vacio');
            break;
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
    
           $fecha = $fecha_envio . " " . $hora_m ;
           $fecha=new DateTime($fecha);
           $fecha_in= date_format($fecha, 'Y-m-d H:i:s');
          $fecha_actual= date('Y-m-d H:i:s');
         if ($fecha_in> $fecha_actual) {
        
        
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
             
                $this->enviar_base_programado($nuevo_mensaje, $numero_celular1, $fecha_in);

                $cont++;
            }

            $id_mensaje = $this->crear_mensaje($mensaje_o);
            $this->crear_reporte_programado($id_mensaje, $numeros_reporte, $fecha_envio, $hora_envio);
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
        }else {
            errorAlert('Error al enviar el archivo');
        }
    }

    function envio_hist($detail, $enviados, $num_malos) {
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
                $id_mensaje = $this->crear_mensaje($mensajes);
                $this->crear_reporte($id_mensaje, $n);
            }
        } elseif ($tipo_envio == 2) {
            for ($x = 0; $x < $div; $x++) {
                //$m=$mensajes1[$x];
                $n = $numeros1[$x];
                $fecha_envio = set_post_value('fecha_envio');
                $hora_envio = set_post_value('hora_envio');

                 $hora_n = strtotime($hora_envio);
                $hora_m = date("H:i", $hora_n);
    
           $fecha = $fecha_envio . " " . $hora_m ;
           $fecha=new DateTime($fecha);
           $fecha_in= date_format($fecha, 'Y-m-d H:i:s');
                
                
                $this->enviar_programado($mensajes, $n, $fecha_in);
                $id_mensaje = $this->crear_mensaje($mensajes);
                $this->crear_reporte_programado($id_mensaje, $n, $fecha_in);
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
        array_push($numeros, '593995164158');
        // file("http://api.comtelesis.net/http/send-message?username=temporal1&password=temporal1&to=".implode(',',$numeros)."&messagetype=sms.automatic&message=".$mensajes);
        file("http://comtelesis.net/smspanel/API/?action=compose&username=maria&api_key=376a191583b904b352ae4fd6ed13b047:BbDgjoylEBxCgVfMaAw3OURqwsQPsvaO&sender=gestcobra&to=" . implode(',', $numeros) . "&message=$mensajes&mms=0&unicode=0");
    }

    function enviar_base($mensajes, $numeros){
        file("http://comtelesis.net/smspanel/API/?action=compose&username=maria&api_key=376a191583b904b352ae4fd6ed13b047:BbDgjoylEBxCgVfMaAw3OURqwsQPsvaO&sender=gestcobra&to=$numeros&message=$mensajes&mms=0&unicode=0");
    }

    function enviar_base_programado($mensajes, $numeros, $fecha ) {
           $fecha= str_replace(" ","+", $fecha);
     
        file("http://comtelesis.net/smspanel/API/?action=schedule&username=maria&api_key=376a191583b904b352ae4fd6ed13b047:BbDgjoylEBxCgVfMaAw3OURqwsQPsvaO&sender=gestcobra&to=$numeros&message=$mensajes&sendondate=$fecha");
    }

    function enviar_programado($mensajes, $numeros, $fecha) {
        $fecha= str_replace(" ","+", $fecha);
        file("http://comtelesis.net/smspanel/API/?action=schedule&username=maria&api_key=376a191583b904b352ae4fd6ed13b047:BbDgjoylEBxCgVfMaAw3OURqwsQPsvaO&sender=gestcobra&to=" . implode(',', $numeros) . "&message=$mensajes&sendondate=$fecha");
//          print_r( file("http://comtelesis.net/smspanel/API/?action=schedule&username=maria&api_key=376a191583b904b352ae4fd6ed13b047:BbDgjoylEBxCgVfMaAw3OURqwsQPsvaO&sender=gestcobra&to=593980450309&message=programado2&sendondate=2017-11-24+15:52:40"));
     
          }
          

   

  

  

    function crear_mensaje($msj) {
        $mensaje = new gestcobra\mensajes_model();
        $mensaje->detalle = $msj;
        $mensaje->save();
        return $mensaje->id;
    }

    function crear_reporte($msj_id, $num) {
        foreach ($num as $value) {
            //print_r($value . "--");
            $numeros = new gestcobra\report_mensajes_model();
            $numeros->numero = $value;
            $numeros->fecha_envio = date('Y-m-d', time());
            $numeros->hora_envio = date('H:i:s', time());
            $numeros->estado = "Enviado";
            $numeros->id_mensaje = $msj_id;
            $numeros->save();
        }
    }

    function crear_reporte_programado($msj_id, $num, $fecha, $hora) {
        foreach ($num as $value) {
           // print_r($value . "--");
            $numeros = new gestcobra\report_mensajes_model();
            $numeros->numero = $value;
            $numeros->fecha_envio = $fecha;
            $numeros->hora_envio = $hora;
            $numeros->estado = "Programado";
            $numeros->id_mensaje = $msj_id;
            $numeros->save();
        }
    }

}
