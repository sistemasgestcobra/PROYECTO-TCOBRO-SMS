<?php

$q = $_GET['q'];

if ($q==2){
        $mysqli = new mysqli('localhost','tcobro3_usuario','@tcobro@1', 'tcobro3_base');
    $d = new DateTime();
    $d1=new DateTime();
    $d1->add(new DateInterval('PT5M'));
    $d=$d->format('Y-m-d H:i:s');
    $d1=$d1->format('Y-m-d H:i:s');
    $mysqli->multi_query("select * from alertas where fechahora>='$d' and fechahora<='$d1';");
    $res = $mysqli->store_result();
    $coco=$res->fetch_all();
    $num=array();
    foreach($coco as $value){
        array_push($num,$value[2]);
    }
    print ("<span style='border-image: initial; border: 5px solid red; color:red;'>ALERTA DE VOLVER A LLAMAR EN 5 min o MENOS, Numeros de operación: ".implode(" - ",$num)."</span>");
    if($num){
        print ("<span style='border-image: initial; border: 5px solid red; color:red;'>ALERTA DE VOLVER A LLAMAR EN 5 min o MENOS, Numeros de operación: ".implode(" - ",$num)."</span>");
    }
    //echo '<h1 style="color:red;">ALERTA DE VOLVER A LLAMAR</h1>';
    //print ("<span style='border-image: initial; border: 5px solid red; color:red;'>ALERTA DE VOLVER A LLAMAR</span>");
    //print_r($num);
}

?>