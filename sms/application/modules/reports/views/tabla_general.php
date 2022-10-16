<?php
$agencia=set_post_value('oficina_company_id');

?>
<form method="post" action="<?= base_url('reports/reportes/open_view3_general')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="oficina_company_id" value="<?= $agencia?>">
		 <input type="hidden" name="mes_id" value="<?= $mes ?>">
                    <fieldset>

<br>
 
 <p>(*) CREDITOS RECUPERADOS: Incluye créditos cancelados totalmente y los créditos que han sido cancelados parcialmente es decir mediante abonos.  </p>
<br>
<?php
$conn = mysqli_connect($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
if ($agencia==-1) {
$sql = "select r.oficial_name,r.cantidad_creditos,r.capital,(r.cantidad_creditos-r.cantidad_recuperada),
round((r.capital-r.capital_recuperado),2),r.cantidad_recuperada,r.capital_recuperado,ROUND((r.capital_recuperado *100)/r.capital,2)
 from reporte1 r ;
 ";
 } else {
   $sql = "select r.oficial_name,r.cantidad_creditos,r.capital,(r.cantidad_creditos-r.cantidad_recuperada),
round((r.capital-r.capital_recuperado),2),r.cantidad_recuperada,r.capital_recuperado,ROUND((r.capital_recuperado *100)/r.capital,2)
 from reporte1 r where r.oficina_id=$agencia
 ";  
}

$result1 = mysqli_query($conn,$sql);

echo " 	<div class=datagrid> <center>
    <table border = 1 cellspacing = 1 cellpadding = 1 >
		
    <thead>
<tr>

<th rowspan=2 >OFICIAL </th>
<th rowspan=2 >CREDITOS </th>
<th rowspan=2 >CAPITAL</th>
<th rowspan=2 >NUM. OPERACIONES POR RECUPERAR</th>
<th rowspan=2 >CAPITAL  POR RECUPERAR</th>
<th rowspan=2 >NUM. OPERACIONES RECUPERADA (*)</th>
<th rowspan=2 >CAPITAL     RECUPERADO</th>
<th rowspan=2 >PORCENTAJE  RECUPERADO %</th>


	</tr></div>";
echo "<tr > </tr> ";

while($row = mysqli_fetch_array($result1)){
    $t1=$t1+$row[1];
    $t2=$t2+$row[2];
    $t3=$t3+$row[3];
    $t4=$t4+$row[4];
    $t5=$t5+$row[5];
	$t6=$t6+$row[6];
echo "
		<tr class=bg2>
			<td  >".$row[0]."</td>
			<td>".$row[1]."</td>
			<td>".$row[2]."</td>
			<td>".$row[3]."</td>
			<td>".$row[4]."</td>
			<td>".$row[5]."</td>
			<td>".$row[6]."</td>
                          
                            <td>".$row[7]."%"."</td>
                                
		</tr> ";

}

echo "
		<tr  class=bg2 >
			<td class=negritas>TOTAL</td>
			<td class=negritas>".$t1."</td>
			<td class=negritas>".$t2."</td>
			<td class=negritas>".$t3."</td>
			<td class=negritas>".$t4."</td>
			<td class=negritas>".$t5."</td>
			<td class=negritas>".$t6."</td>
			<td class=negritas>".$t7."%"."</td>
			        
		</tr> ";

echo "</table> </center>";
//mysqli_close($conn);             
?>
<br>
<br>

<div class="col-md-15 text-center">
      <!--<a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/reports__reportes__open_view3__<?= $datos ?>/0/0">MOSTRAR GRAFICA</a>-->
    <input type="hidden" name="datos_grafico" value="<?= $datos_grafico?>">
	<button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_gestion_creditos_productividad_oficial" class="btn btn-primary">GRAFICO</button>
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
     <div class="col-md-15 text-center">      
            <button reset-form="0" class="btn btn-success btn-xs" name="type_group" value="1" onclick="setExcel()" class="btn btn-primary">EXPORTAR INFORME</button>
     </div>
</fieldset>

</form>