<?php
$oficial=set_post_value('oficial_credito_id');
$fecha=set_post_value('from_date');

?>
<form method="post" action="<?= base_url('reports/reportes/open_view3_general')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="oficina_company_id" value="<?= $agencia?>">
		 <input type="hidden" name="mes_id" value="<?= $mes ?>">
                    <fieldset>

<br>
 
<br>

<style type="text/css" >
.negritas {font-weight: bold; }
.bg1 { background:#2E9AFE; color:#000; }
.bg2 { background:#E1EEF4; color:#000; font: normal 12px/150% Arial, Helvetica, sans-serif;}
.datagrid table { border: 5px solid #006699; border-collapse: collapse; text-align: center; width: 70%; } 
.datagrid {font: normal 12px/50% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden ;  border-radius: 20px ; }
.datagrid table td, 
.datagrid table th { padding: 3px 10px; }
.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 70% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; color:#FFFFFF; font-size: 15px; font-weight: bold; border-left: 1px solid #0070A8; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #00496B; border-left: 1px solid #E1EEF4;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #E1EEF4; color: #00496B; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #006699;background: #E1EEF4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #FFFFFF;border: 1px solid #006699;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #006699; color: #FFFFFF; background: none; background-color:#00557F;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }
</style>      


<?php

$conn = mysqli_connect($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
if ($oficial==-1) {
$sql = "SELECT cd.nro_pagare as Nro_PAGARE,ch.hist_date AS FECHA,
 ch.hist_time AS HORA,ch.detail AS DETALLE , ch.tiempo_gestion AS TIEMPO_GESTION, of.firstname 
 FROM credit_hist ch, oficial_credito of, credit_detail cd 
 where cd.id=ch.credit_detail_id
   AND of.id=ch.oficial_credito_id
 and ch.hist_date='$fecha' GROUP by ch.id ;
 ";
 } else {
   $sql = "SELECT cd.nro_pagare as Nro_PAGARE,ch.hist_date AS FECHA,
 ch.hist_time AS HORA,ch.detail AS DETALLE , ch.tiempo_gestion AS TIEMPO_GESTION, of.firstname 
 FROM credit_hist ch, oficial_credito of, credit_detail cd where ch.oficial_credito_id=$oficial
 and cd.id=ch.credit_detail_id
   AND of.id=ch.oficial_credito_id
 and ch.hist_date='$fecha' GROUP by ch.id
 ";  
}

$result1 = mysqli_query($conn,$sql);

echo " 	<div class=datagrid> <center>
    <table border = 1 cellspacing = 1 cellpadding = 1 >
		
    <thead>
<tr>

<th rowspan=2 >PAGARE</th>
<th rowspan=2 >FECHA</th>
<th rowspan=2 >HORA</th>
<th rowspan=2 >DETALLE</th>
<th >TIEMPO</th>
<th rowspan=2 >GESTOR</th>


	</tr></div>";
echo "<tr > 

			<th  >GESTION</th>
</tr> ";


while($row = mysqli_fetch_array($result1)){
    $t1=$t1+$row[1];
    $t2=$t2+$row[2];
    $t3=$t3+$row[3];
    $t4=$t4+$row[4];
    $t5=$t5+$row[5];
	$t6=$t6+$row[6];
echo "
		<tr class=bg2>
			<td>".$row[0]."</td>
			<td>".$row[1]."</td>
			<td>".$row[2]."</td>
			<td>".$row[3]."</td>
			<td>".$row[4]."</td>
			<td>".$row[5]."</td>
                          
                          
                                
		</tr> ";

}

echo "
		<tr  class=bg2 >
			
			
			        
		</tr> ";

echo "</table> </center>";
//mysqli_close($conn);             
?>
<br>
<br>

<div class="col-md-15 text-center">
      <!--<a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/reports__reportes__open_view3__<?= $datos ?>/0/0">MOSTRAR GRAFICA</a>-->
  <!--    <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_gestion_creditos_productividad_oficial" class="btn btn-primary">GRAFICO</button>-->
</div>

<br>
</fieldset>

</form>

<div id="chart_gestion_creditos_productividad_oficial">
    
</div>

<form method="post" action="<?= base_url('reports/reporte_general/index')?>" class="form-horizontal">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
        <input type="hidden" name="oficina_company_id" value="<?= $agencia?>">
	<input type="hidden" name="mes_id" value="<?= $mes ?>">
        
 <fieldset>
 <!--    <div class="col-md-15 text-center">      
            <button reset-form="0" class="btn btn-success btn-xs" name="type_group" value="1" onclick="setExcel()" class="btn btn-primary">EXPORTAR INFORME</button>
     </div>-->
</fieldset>

</form>