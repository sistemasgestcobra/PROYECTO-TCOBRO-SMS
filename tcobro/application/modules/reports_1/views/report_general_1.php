<form method="post" action="<?= base_url('reports/welcome_1/index')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="oficina_company_id" value="390">
    <fieldset>

<?php
$agencias_combo = combobox($agencias, array('value'=>'id','label'=>'name'), array('name'=>'oficina_company_id','class'=>'form-control select2able'), true);



?>      
        <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Reporte General</h3>
  </div>
  <div class="panel-body">


<input type="hidden" name="comparar" value="<?= $comparar ?>"/>

<div class="form-group col-md-3">
      <button reset-form="0" name="type_group" value="1" onclick="setExcel()" class="btn btn-primary">EXPORTAR INFORME</button>
</div>

  </div>
</div>
      

</fieldset>
</form>

<!--<div id="chart_gestion_creditos_agencia">
    
</div>-->
<form method="post" action="<?= base_url('reports/oficialcharts/open_view2')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="agencia">
        <input type="hidden" name="oficina_company_id" value="390">
    <fieldset>

     
 <div class="panel panel-primary" >
  <div class="panel-heading">
    <h3 class="panel-title">Reporte de Produccion de Gestion</h3>
  </div>


    <br>
     
    <?php
$pas=$this->db->password;
$db=$this->db->database;
$user=$this->db->username;

                $conn = mysqli_connect('localhost',$this->db->username,$this->db->password,$this->db->database);

$sql1 = "select oficial_name,pendientes,compromiso,gestionados, ROUND( IFNULL(((gestionados*100/(pendientes+gestionados))),0),2)
from reporte2;
";

$result1 = mysqli_query($conn,$sql1);


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
			
			<td class=negritas></td>
			<td class=negritas>".$t8."</td>
			<td class=negritas>".$t9."</td>
			<td class=negritas>".$t10."%"."</td>
			        
		</tr> ";
echo "</table> </center>";

        ?>
    <br>
    <br>
    
   <div class="col-md-15 text-center">
      <a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/reports__oficialcharts__open_view2__/0/0">MOSTRAR GRAFICA</a>
   </div>
    
</div>
        </fieldset>
         

</form>

