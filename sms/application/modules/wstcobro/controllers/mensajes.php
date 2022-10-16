<?php
ini_set('max_execution_time', 0);
if (!defined('BASEPATH'))exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class mensajes extends REST_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('comunications/commws');
    }
public function lol_get(){
    $var=$_GET['var'];
$mysqli = new mysqli("localhost", "tcobro3_usuario", "@tcobro@1", "tcobro3_base");
if (!$mysqli->multi_query("SELECT total_cuotas_vencidas, contact_value from credit_detail c INNER JOIN client_referencias cr ON c.id = cr.credit_detail_id
	INNER JOIN contact co ON cr.person_id = co.person_id WHERE dias_mora=$var and contact_type_id=2 and reference_type_id=3;")) {
    echo "Fall¨® la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
}
$res = $mysqli->store_result();
$coco=$res->fetch_all();
$this->envio($var,$coco);
//-------------MOSTRAR TODO LO DE LA MATRIZ------------------------------------------------------
//echo('<pre>');
//print_r($coco);
//echo('</pre>');
}


function envio($dia,$dato){
    if($dia==-3){
       $men="dia -3..$ ";
       $saje=" pues sale del 3";
    }else if($dia==5){
        $men="dia 5..$ ";
       $saje=" pues sale del 5";
    }else if($dia==15){
        $men="dia 15..$ ";
       $saje=" pues sale del 15";
    }else if($dia==25){
        $men="dia 25..$ ";
       $saje=" pues sale del 25";
    }

    $mensajes= array();
    $numeros=array();
    foreach($dato as $value){
        $mensaje=$men.$value[0].$saje;
        $numero_celular1=trim($value[1]);
        $numero_celular2=substr($numero_celular1, 1);
		$numero_celular3='593'.$numero_celular2;
        if(strlen($numero_celular3)==12){
                array_push($mensajes, $mensaje);
                array_push($numeros, $numero_celular3);
        }
    }
    echo('<pre>');
    print_r($mensajes);
    print_r($numeros);
    echo('</pre>');
    if(count($numeros)>900){
                $this->dividir($mensajes,$numeros);
            }else{
                $this->enviar($mensajes,$numeros);
            }
        
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
    
    
    function enviar($mensajes,$numeros) {
        $message = array(
            "Mensaje"=>"Hola",
            "Mensajes"=>$mensajes,
            "Destinatarios"=>$numeros,
            "apiKey"=>"3D78493FB7"
                );
                    $obj_commws = new Commws();
                  $var=  $obj_commws->http_conn_comunication_1($message);
					return $var;
			 	
    }
        public function enviar_sms_get($men, $num) {
            $numero=urldecode($num);
            //$text = urldecode($men);
            $text1=str_replace('%20', '+', $men);
            //echo $men;
            //echo $text1;
            //echo '</br>';
            //echo $numero;

        $imp=file("http://comtelesis.net/smspanel/API/?action=compose&username=maria&api_key=376a191583b904b352ae4fd6ed13b047:BbDgjoylEBxCgVfMaAw3OURqwsQPsvaO&sender=gestcobra&to=$numero&message=$text1&mms=0&unicode=0");
        print_r($imp);
    }

}

//----------------------IMPRIMIR FILA POR FILA---------------------------------------------
/*
$cont = 0;
foreach($coco as $value){
    print_r($coco[$cont]);
    //echo implode(" - ",$coco[$cont]);
    
    $fecha=$coco[$cont];
    echo $fecha[0]->format('Y-m-d H:i:s');
    if (!$mysqli->query("INSERT INTO fechas_nuevas VALUES ($fecha[0])")) {
    echo "FallÃ³ la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    printf("</br>");
    $cont++; 
}*/
