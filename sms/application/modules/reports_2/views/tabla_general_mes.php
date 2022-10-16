<?php
$mes=set_post_value('mes_id');
$agencia=set_post_value('oficina_company_id');
?>
<form method="post" action="<?= base_url('reports/welcome_1/index')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="agencia">
        <input type="hidden" name="oficina_company_id" value="<?= $agencia?>">
		  
		    <input type="hidden" name="mes_id" value="<?= $mes ?>">
    <fieldset>

 
<br>
 
<br>
<?php
$conn = mysqli_connect('localhost',$this->db->username,$this->db->password,$this->db->database);
if ($agencia==-1) {
$sql = "select oc.name, rm.cantidad,rm.capital,rm.cantidad_recuperada, rm.`capital_recuperada`, rm.cantidad_x_recuperar,
 rm.capital_x_recuperar, ROUND((rm.capital_recuperada *100)/rm.capital,2)
from reporte_general_mensual rm ,oficina_company oc WHERE oc.id=rm.oficina_company_id
and rm.mes_id=$mes;
 ";
 }
else
    {
	$sql = "select oc.name,rm.cantidad,rm.capital,rm.cantidad_recuperada, rm.`capital_recuperada`, rm.cantidad_x_recuperar,
 rm.capital_x_recuperar, ROUND((rm.capital_recuperada *100)/rm.capital,2)
from reporte_general_mensual rm ,oficina_company oc WHERE oc.id=rm.oficina_company_id
and rm.mes_id=$mes and rm.oficina_company_id=$agencia;
 ";	
		
}
$result1 = mysqli_query($conn,$sql);

echo " 	<div class=datagrid> <center>
    <table border = 1 cellspacing = 1 cellpadding = 1 >
		
    <thead>
<tr>

<th rowspan=2 >AGENCIA </th>
<th rowspan=2 >CREDITOS </th>
<th rowspan=2 >CAPITAL</th>
<th rowspan=2 >NUM. OPERACIONES POR RECUPERAR</th>
<th rowspan=2 >CAPITAL  POR RECUPERAR</th>
<th rowspan=2 >NUM. OPERACIONES    RECUPERADA</th>
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
	$t6=$t5+$row[6];
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
              ?>
<br>
<br>
<!--si se muestra tabla completa no mostrar mensajes-->
<!--si se muestra tabla por agencia mostrar mensajes-->

<?php
if($agencia!=-1) {?>
<div class="col-md-15 text-center">
      <a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/reports__reportes__open_view4__/0/0">MOSTRAR GRAFICA</a>
</div>
<?php
}?>
    

<br>
</fieldset>

</form>

