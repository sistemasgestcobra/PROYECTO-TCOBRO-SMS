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
        //fputs($fp,$postDataJson);
      	$token = json_decode($this->obtenertoken(),true);
        $postUrl = "https://api.login-sms.com/messages/send-batch-list";
        $tok=$token['access_token'];

            $postDataJson = json_encode($sms_mas3);
            //print_r($postDataJson);          
            
            
                        $array=array("Content-type: application/json",
		              "Accept: application/json",
                "Authorization:"."Bearer ".$tok);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$array);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            print_r($response);
            //fputs($fp,$response."\r\n");
            curl_close($ch);
            //print_r($response);
            return $response;     
    }
    
    function http_conn_comunication_simple($num,$men) {
 $token = json_decode($this->obtenertoken(),true);
 $tok=$token['access_token'];
 $postUrl = "https://api.login-sms.com/messages/send";
            $message = array("to_number" => $num,
                "content" => $men);
            $postDataJson = json_encode($message);
    
    //$fp = fopen("sms.txt", "a");

            $array=array("Content-type: application/json",
		              "Accept: application/json",
                "Authorization:"."Bearer ".$tok);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$array);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
      //      fputs($fp,$response."\r\n");
      //      fclose($fp);
            curl_close($ch);
        
    }
    
    function obtenertoken(){
$user = 'DX2htYuRMIk9B/z';
$pass = 'tjZO9fVhusqPDtT';
        $postUrl = "https://api.login-sms.com/token";

            $message = array("client_id" => $user,
                "client_secret" => $pass,
                "grant_type"=>"client_credentials");
            $postDataJson = json_encode($message);

            $array=array("Content-type: application/json",
		              "Accept: application/json");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$array);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            
            
            curl_close($ch);
            return $response;
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
