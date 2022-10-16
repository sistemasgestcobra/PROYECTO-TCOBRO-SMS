<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');


class Commws {
    private $CI;
    private $user_ws = 'admin';
    private $pass_ws = '1234';
    private $url_ws;
     
    function __construct()
    {
      $this->CI =& get_instance();
    }

    function http_conn_comunication( $from, $to1, $mensaje1, $type, $type_phone = '', $pass = '' ) {
            
        $to = urlencode($to1);
        $mensaje = urlencode($mensaje1);
        
        $ch = curl_init();
        
        if($type == 'com_email'){
            $from = urlencode($from);
           curl_setopt($ch, CURLOPT_URL, "" . $this->get_url_ws() . "/" . $from . "/" . $pass . "/" . $to . "/" . $mensaje . "/" . $mensaje);  
        }  elseif ($type == 'com_whatsapp') {
            curl_setopt($ch, CURLOPT_URL, "" . $this->get_url_ws() . "/" . $to . "/" . $mensaje);            
        }  elseif ($type == 'com_sms' OR $type == 'com_call') {
            curl_setopt($ch, CURLOPT_URL, "" . $this->get_url_ws() . "/" . $type_phone . "/" . $from . "/" . $to . "/" . $mensaje);            
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        //curl_setopt($ch, CURLOPT_USERPWD, "" . $this->get_user_ws() . ":" . $this->get_pass_ws() . "");
        //$output = curl_exec($ch);
        curl_exec($ch);
        curl_close($ch);
        //return $output;
;
    }
    
function http_conn_comunication_1($sms_mas3) {
		//$fp = fopen("sms.txt", "a");
            

                define('TP_USER', 'AFCB916506B7DB8');
                define('TP_PASS', 'E68EFBA247');
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
}
