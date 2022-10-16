<?php
date_default_timezone_set('America/Guayaquil');
$q = $_GET['q'];
    $mysqli = new mysqli('localhost','root','', 'tcobro1_base');
	
    $d = new DateTime();
    $d1=new DateTime();
    $d1->add(new DateInterval('PT5M'));
    $d=$d->format('Y-m-d H:i:s');
    $d1=$d1->format('Y-m-d H:i:s');
    $mysqli->multi_query("select * from alertas where usuario = $q and fechahora>='$d' and fechahora<='$d1';");
    $res = $mysqli->store_result();
    $coco=$res->fetch_all();
    $num=array();
    foreach($coco as $value){
        array_push($num,$value[2]);
    }
    if($num){
        //print ("<span style='border-image: initial; background-color:#33FFB2; font-size:25px;border: 5px solid red; color:red;'>ALERTA DE VOLVER A LLAMAR EN 5 min o MENOS, Numeros de operación: ".implode(" - ",$num)."</span>");
        print ("<div style='background: #889ccf; border: 5px; font-size: 18px; width: 500px; float:left; margin: 0 0 25px; -webkit-border-radius: 35px 0px 35px 0px; -moz-border-radius: 35px 0px 35px 0px; border-radius: 35px 0px 35px 0px; border: 2px solid #5878ca; padding: 5px; color: #ffffff; text-align: center'><b>ALERTA DE VOLVER A LLAMAR EN 5 min o MENOS, Numeros de operación: ".implode(" - ",$num)."</b></div>");
    }
	


?>