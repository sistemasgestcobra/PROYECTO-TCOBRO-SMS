<script>
alerta();
function alerta() {

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("porq").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","fact.php?q=2",true);
        xmlhttp.send();
}
setInterval('alerta()', 300000);
</script>
<div id="porq">
    
</div>
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
    if($num){
        print ("<span style='border-image: initial; border: 5px solid red; color:red;'>ALERTA DE VOLVER A LLAMAR EN 5 min o MENOS, Numeros de operación: ".implode(" - ",$num)."</span>");
    }
    //echo '<h1 style="color:red;">ALERTA DE VOLVER A LLAMAR</h1>';
    //print ("<span style='border-image: initial; border: 5px solid red; color:red;'>ALERTA DE VOLVER A LLAMAR</span>");
    //print_r($num);
}

?>






