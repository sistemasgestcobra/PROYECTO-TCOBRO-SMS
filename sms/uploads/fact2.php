    <div id='porq'>
        </div>
    <?php
function lol(){
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
    return $num;
 }

    ?>
<script>
    //alerta();
function alerta (){
    //var arr=<?php echo json_encode(lol())?>;
    //var sum = <?= $cre?>;
    <?
    $d = new DateTime();
    $d=$d->format('Y-m-d H:i:s');
    ?>
    document.write("<br>"+<?php echo json_encode($d)?>);
    <? $d=0; ?>
    document.write("<br>"+<?php echo $d?>);
    //alert ("TIENE: VOLVER A LLAMAR EN MENOS DE 5 MINUTOS          "+"Numero de credito: "+arr);
  };
  //setInterval(alerta, 500000);
  setInterval('alerta()', 6000);
</script>

