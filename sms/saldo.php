<?php

define('TP_USER', 'DannyCalle');
define('TP_PASS', 'DannyC2018*');

  //$credentials = "DannyCalle:DannyC2018*"; 
  $credentials = "santa_rosa:santa_rosa2018*";
  

$tipo_pro=array(); 
		 array_push($tipo_pro, 'SMS');
		$message = array(
          "land" =>'593',	
		  "packageTypeList" =>$tipo_pro
	);
 
 
//print_r ($message);
$postDataJson = json_encode($message);
            print_r($postDataJson);
		$curl = curl_init();
		curl_setopt_array($curl, array(
    		
			    CURLOPT_HTTPHEADER => array(
		             // "Authorization: Basic " . base64_encode(TP_USER . ":" . TP_PASS),
					  "Authorization: Basic " . base64_encode($credentials) ,
		              "Content-type: application/json",
		              "Accept: application/json"
				),
				
				CURLOPT_POSTFIELDS => $postDataJson,
			    CURLOPT_RETURNTRANSFER => 1,
    			CURLOPT_URL => 'https://apismsi.aldeamo.com/SmsiWS/packageReportPost',
                    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
			    CURLOPT_POST => 1,    
		));
              
		$resp = curl_exec($curl);
$ft=  json_decode($resp);
			$rt=(array)$ft;
			$sms=$rt["result"];
			$lol=(array)$sms;
			$general=$lol[0];
			$saldo=(array)$general;
			$saldo=$saldo["available"];
			$enviados=$saldo["totalSpent"];
			$compra=$saldo["total"];
		echo "RESPUESTA".$resp;
		//var_dump($saldo);
		//echo "RESP".$lol['available'];
		
		curl_close($curl);
		return $resp;	





