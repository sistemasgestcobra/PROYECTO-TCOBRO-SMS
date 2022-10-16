<?php
$agencia=set_post_value('oficina_company_id');

?>
<form method="post" action="<?= base_url('reports/reportes/open_graf_produccion')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="oficina_company_id" value="<?= $agencia?>">
                    <fieldset>

<br>
<?php
$conn = mysqli_connect($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
if ($agencia==-1) {
$sql = "select oficial_name,pendientes,compromiso,gestionados, IFNULL(round((gestionados*100/(pendientes+gestionados)),2),0)
from reporte2; 
 ";
 } else {
   $sql = "select oficial_name,pendientes,compromiso,gestionados, IFNULL(round((gestionados*100/(pendientes+gestionados)),2),0)
from reporte2 where oficina=$agencia;
 ";  
}

$result1 = mysqli_query($conn,$sql);
echo " 	<div class=datagrid> <center>
    <table  border = 1 cellspacing = 1 cellpadding = 1 >
		
    <thead>
<tr>
<th>OFICIAL</th>
<th>PENDIENTES</th>
<th>COMPROMISO DE PAGO</th>
<th>GESTIONADOS</th>
<th>PORCENTAJE %</th>

	</tr></div>";

$t6=0;
$t7=0;
$t8=0;
$t9=0;
$t10=0;

while($row1 = mysqli_fetch_array($result1)){
     
    $t7=$t7+$row1[1];
    $t8=$t8+$row1[2];
    $t9=$t9+$row1[3];
    $t10=$t10+$row1[4];
echo "
		<tr class=bg2>
			<td>".$row1[0]."</td>
			<td>".$row1[1]."</td>
                       <td>".$row1[2]."</td>
                           <td>".$row1[3]."</td>
                          <td>".$row1[4]."%"."</td>
		</tr> ";
}
echo "
		<tr  class=bg2 >
			<td class=negritas>TOTAL</td>
			
			<td class=negritas>".$t7."</td>
			<td class=negritas>".$t8."</td>
			<td class=negritas>".$t9."</td>
                        <td class=negritas>".$t10."%"."</td>
			
			        
		</tr> ";
echo "</table> </center>";

        ?>
    <br>
    <br>
    
 <div class="col-md-15 text-center">
      <!--<a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/reports__reportes__open_view3__<?= $datos ?>/0/0">MOSTRAR GRAFICA</a>-->
    <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_gestion_creditos_producciones" class="btn btn-primary">GRAFICO</button>
</div>
        </fieldset>
         
</form>

<div id="chart_gestion_creditos_producciones">
    
</div>

<form method="post" action="<?= base_url('reports/reporte_produccion/index')?>" class="form-horizontal">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
        <input type="hidden" name="oficina_company_id" value="<?= $agencia?>">
	<input type="hidden" name="mes_id" value="<?= $mes ?>">
        
 <fieldset>
     <div class="col-md-15 text-center">      
            <button reset-form="0" class="btn btn-success btn-xs" name="type_group" value="1" onclick="setExcel()" class="btn btn-primary">EXPORTAR INFORME</button>
     </div>
</fieldset>

</form>