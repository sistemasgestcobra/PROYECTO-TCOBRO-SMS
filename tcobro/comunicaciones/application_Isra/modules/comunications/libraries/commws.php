<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');


class Commws {
    private $CI;
     
    function __construct()
    {
      $this->CI =& get_instance();
    }

    
    //arr1 mensajes arr2 numeros
    
    function http_conn_comunication_1($sms_mas3) {
		//$fp = fopen("sms.txt", "a");
            $usuario="1BA8A01B563ABBC";
			$key="E70DB5A737";
//		define('TP_USER', '5A8B11CB5AB163F');//ID
//		define('TP_PASS', 'B7FD651D7A');//KEY

        $postDataJson = json_encode($sms_mas3);
        //fputs($fp,$postDataJson);
      		$curl = curl_init();
		curl_setopt_array($curl, array(
    		
			    CURLOPT_HTTPHEADER => array(
		              "Authorization: Basic " . base64_encode($usuario . ":" . $key),
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
}
