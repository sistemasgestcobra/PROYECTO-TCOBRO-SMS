<form method="post" action="<?= base_url('reports/welcome/index')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="oficina_company_id" value="390">
    <fieldset>

<?php
$agencias_combo = combobox($agencias, array('value'=>'id','label'=>'name'), array('name'=>'oficina_company_id','class'=>'form-control select2able'), true);

$fechas=$this->db->query("SELECT DISTINCT load_date FROM credit_detail WHERE  oficina_company_id=390 ORDER by load_date desc LIMIT 3");
$lol=$fechas->result();


?>      
        <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Reporte General</h3>
  </div>
  <div class="panel-body">
    <div class="form-group col-md-3">
  <label class="col-md-4 control-label" for="from_date">Fecha Carga:</label>  
  <div class="col-md-8">
      <select class="form-control" id="from_date" name="from_date" placeholder="Fecha Carga">
        <?php
                foreach ($lol as $row){
                    echo "<option value= $row->load_date > $row->load_date</option>";
                }  
        ?>
         </select> 
<!--  <input id="from_date" name="from_date" placeholder="Fecha Desde" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="<?= date('Y-m-d', time()) ?>">-->
  </div>
</div>

<!-- Text input-->
<div class="form-group col-md-3">
  <label class="col-md-4 control-label" for="to_date">Fecha Hasta:</label>  
  <div class="col-md-8">
  <input id="to_date" name="to_date" placeholder="Fecha Hasta" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="<?= date('Y-m-d', time()) ?>">
  </div>
</div>

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
<form method="post" action="<?= base_url('reports/welcome_1/index')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="agencia">
        <input type="hidden" name="oficina_company_id" value="390">
    <fieldset>

  
 <div class="panel panel-primary" >
  <div class="panel-heading">
    <h3 class="panel-title">Reporte Cumplimiento General por Oficial</h3>
  </div>
 
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

<br>
<?php
$conn = mysqli_connect('localhost',$this->db->username,$this->db->password,$this->db->database);

$sql = "select r.oficial_name, r.cantidad_creditos, r.capital, r.cantidad_recuperada, r.capital_recuperado,
round((r.cantidad_recuperada*100/(r.cantidad_creditos)),2)
 from reporte1 r where r.oficina_id=390";
 

$result1 = mysqli_query($conn,$sql);

echo " 	<div class=datagrid> <center>
    <table border = 1 cellspacing = 1 cellpadding = 1 >
		
    <thead>
<tr>
<th   rowspan=2>OFICIAL</th>
<th rowspan=2 >CREDITOS </th>
<th rowspan=2 >CAPITAL</th>
<th >CANTIDAD</th>
<th >CAPITAL</th>
<th >PORCENTAJE</th>

	</tr></div>";
echo "
		<tr >
			
			
			<th  >RECUPERADO</th>
			<th  >RECUPERADO</th>
                         <th  >RECUPERADO %</th>
                                
		</tr> ";
$t1=0;
$t2=0;
$t3=0;
$t4=0;
$t5=0;

while($row = mysqli_fetch_array($result1)){
    $t1=$t1+$row[1];
    $t2=$t2+$row[2];
    $t3=$t3+$row[3];
    $t4=$t4+$row[4];
    $t5=$t5+$row[5];
echo "
		<tr class=bg2>
			<td  >".$row[0]."</td>
			<td>".$row[1]."</td>
			<td>".$row[2]."</td>
			<td>".$row[3]."</td>
                            <td>".$row[4]."</td>
                            <td>".$row[5]."%"."</td>
                                
		</tr> ";

}
echo "
		<tr  class=bg2 >
			<td class=negritas>TOTAL</td>
			<td class=negritas>".$t1."</td>
			<td class=negritas>".$t2."</td>
			<td class=negritas>".$t3."</td>
			<td class=negritas>".$t4."</td>
			<td class=negritas>".$t5."%"."</td>
			        
		</tr> ";

echo "</table> </center>";
              ?>
<br>
<br>
 <div class="col-md-15 text-center">
      <a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/reports__oficialcharts__open_view3__/0/0">MOSTRAR GRAFICA</a>
</div>
    
</div>
<br>
</fieldset>

</form>


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

$sql1 = "select oficial_name,pendientes,compromiso,gestionados, round((gestionados*100/(pendientes+gestionados)),2)
from reports2 where oficina=390;
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
      <a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/reports__oficialcharts__open_view2__/0/0">MOSTRAR GRAFICA</a>
   </div>
    
</div>
        </fieldset>
         

</form>

