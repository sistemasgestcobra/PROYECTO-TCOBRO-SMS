<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');


class Commws {
    private $CI;
    private $user_ws = 'admin';
    private $pass_ws = '1234';
    private $url_ws;
    public $username = 'utpl';
    public $api_key = '375e0ac10fa1a5e257aa6b8444755808:HQAwX97ZhzDLPRXzDQYVH6MBWmmDdmmx';
    public $sender = 'utpl';

     
    function __construct()
    {
      $this->CI =& get_instance();
    }

  
function http_conn_comunication_1($sms_mas3) {
		//$fp = fopen("sms.txt", "a");
            

                //define('TP_USER', 'AFCB916506B7DB8');
                //define('TP_PASS', 'E68EFBA247');
        $postDataJson = json_encode($sms_mas3);
        //fputs($fp,$postDataJson);
      		$curl = curl_init();
		curl_setopt_array($curl, array(
    		
			    CURLOPT_HTTPHEADER => array(
		              "Authorization: Basic " . base64_encode(TP_USER . ":" . TP_PASS),
		              "Content-type: application/json",
		              "Accept: application/json"
				),
			    CURLOPT_POSTFIELDS => $postDataJson,
			    CURLOPT_RETURNTRANSFER => 1,
    			CURLOPT_URL => 'http://envia-movil.com/api/Envios',
                    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
			    CURLOPT_POST => 1,    
		));
              
		$resp = curl_exec($curl);
		curl_close($curl);
                //$result=json_decode($resp);
                //$t=(array)$result;
                //fputs($fp,$resp);
                //fclose($fp);
                
		return $resp;
    }
	
    public function get_user_ws() {
        return $this->user_ws;
    }
    public function set_user_ws($param) {
        $this->user_ws = $param;
    }
    
    public function get_pass_ws() {
        return $this->pass_ws;
    }
    public function set_pass_ws($param) {
        $this->pass_ws = $param;
    }
    
    public function get_url_ws() {
        return $this->url_ws;
    }
    public function set_url_ws($param) {
        $this->url_ws = $param;
    }
////////////////
    
    function save_comunication_ac($type, $referencia, $status, $contact, $notification_format_id,$user_id) {
      
        $comunication_type = (new gestcobra\comunication_type_model())
                ->where('comunication_code', $type)
                ->find_one();

        $comunication = new gestcobra\comunication_model();
        $comunication->type = $comunication_type->comunication_name;
        $comunication->status = $status;
        $comunication->contact = $contact;
        $comunication->curr_date = date("Y-m-d", time());
        $comunication->curr_time = date("H:i:s", time());
        $comunication->user_id = $user_id;
        $comunication->comunication_type_id = $comunication_type->id;
        $comunication->client_referencias_id = $referencia;
        $comunication->notification_format_id = $notification_format_id;
        $comunication->save();
        return $comunication->id;


        //actualizar pagina
    }

    function save_hist($credit_detail_id,$user_id) {
        
        $credti_hist = new gestcobra\credit_hist_model();
        $credti_hist->credit_detail_id = $credit_detail_id;
        $credti_hist->detail = 'ENVIO DE MENSAJE DE TEXTO';
        $credti_hist->hist_date = date('Y-m-d', time());
        $credti_hist->hist_time = date('H:i:s', time());
        $credti_hist->credit_status_id = 8;
        $credti_hist->oficial_credito_id = $user_id;
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
    
     function saldo() {
      
       $apikey= $this->api_key;
       $username= $this->username;
        $link = "http://comtelesis.net/smspanel/API/?action=balance&username=$username&api_key=$apikey";
//        $link="http://comtelesis.net/smspanel/API/?action=balance&username=santarosa&api_key=bf732225f25e2b0629d0b8033ce03a5c:6ofg289yJEzCGTMO4XSF51ZT9BrPH4KY";
         $lines1 = file($link);
        $rest = $lines1[8];
        $rt = substr($rest, 9, -3);
        return $rt
        ;
    } 
    }
