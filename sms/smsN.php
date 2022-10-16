<?php

define('TP_USER', 'DannyCalle');
define('TP_PASS', 'DannyC2018*');

  $credentials = "DannyCalle:DannyC2018*"; 
  
$mensajes="Cooperativa Santa Rosa Ltda. Informa que usted se encuentra en PROCESO JUDICIAL por su CREDITO VENCIDO, PAGUE o ARREGLE y evite la presunción de insolvencia.";
$numerosF=array(); 
//$numeros ["mobile"] ='995164158';
//$minum ["mobile"]   ='992556483';
$minum1 ["mobile"]  ='958878595';
$minum2 ["mobile"]  ='958767136';
		 
		//  array_push($numerosF, $numeros);
		//  array_push($numerosF, $minum);
		 array_push($numerosF, $minum1);
		  array_push($numerosF, $minum2);
		
		$message = array(
          "country"=>"593",
            "message"=>$mensajes,
             "addresseeList"=>$numerosF
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
    			CURLOPT_URL => 'https://apismsi.aldeamo.com/SmsiWS/smsSendPost/ ',
                    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
			    CURLOPT_POST => 1,    
		));
              
		$resp = curl_exec($curl);
echo "RESPUESTA".$resp;
		curl_close($curl);
		
			




