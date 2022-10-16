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

                 $conn = mysqli_connect($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);

$sql1 = "select oficial_name,pendientes,compromiso,gestionados, IFNULL(round((gestionados*100/(pendientes+gestionados)),2),0)
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
			
			<td class=negritas>".$t7."</td>
			<td class=negritas>".$t8."</td>
			<td class=negritas>".$t9."</td>
			
			        
		</tr> ";
echo "</table> </center>";

        ?>
    <br>
    <br>
    
   <!--<div class="col-md-15 text-center">
      <a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/reports__oficialcharts__open_view2__/0/0">MOSTRAR GRAFICA</a>
   </div>-->
    
</div>
        </fieldset>
         
</form>



<?php

$mysqli = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
if (!$mysqli->multi_query("select IFNULL(ROUND((sum(r.gestionados)*100)/(select count(*) from 
credit_detail cd) ,2),0) as total from reporte2 r;")) {
    echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
}
$res = $mysqli->store_result();
$coco = $res->fetch_all();

foreach ($coco as $value) {
    $gest = $value[0];
    $pend = 100 - $value[0];
}
mysqli_close($mysqli);
?>
<hr>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript" src="js/exporting.js"></script>
<script type="text/javascript">
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'grafica_1',
                plotBackgroundColor: {
                    linearGradient: [0, 0, 500, 500],
                    stops: [
                        [0, 'rgb(255, 255, 255)'],
                        [1, 'rgb(200, 200, 255)']
                    ]
                }
            },
            title: {
                text: 'PRODUCCION DE GESTIONES GENERAL'
            },
            subtitle: {
                text: 'Gestcobra'
            },
            plotArea: {
                shadow: null,
                borderWidth: null,
                backgroundColor: null
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.point.name + '</b>: ' + this.y + ' %';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>' + this.point.name + '</b>: ' + this.y + ' %';
                        }
                    }
                }
            },
            series: [{
            name: 'Gestores',
            type: 'bar',
            colorByPoint: true,
            data: [
                 <?php include_once 'config.inc.php';?>
           <?php $db1= new Conect_MySql();
                    $sql2="select oficial_name, IFNULL(ROUND(((gestionados*100/(pendientes+gestionados))),2),0)
from reporte2 where gestionados!=0";
                    $que= $db1->execute($sql2);
                    while ($row4= $db1->fetch_row($que)){?>
                                            {name:'<?php echo $row4[0]?>', 
                                                y: <?php echo $row4[1] ?>
                                            },
                    <?Php }
                    
            ?>
            ]
        }]
        });
    });


</script>

<div id="grafica_1" style="width: 100%; height: 600px; margin: 0 auto"></div>
</div>

<hr>

<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript" src="js/exporting.js"></script>
<script type="text/javascript">
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'grafica',
                plotBackgroundColor: {
                    linearGradient: [0, 0, 500, 500],
                    stops: [
                        [0, 'rgb(255, 255, 255)'],
                        [1, 'rgb(200, 200, 255)']
                    ]
                }
            },
            title: {
                text: 'PRODUCCION DE GESTIONES GENERAL'
            },
            subtitle: {
                text: 'Gestcobra'
            },
            plotArea: {
                shadow: null,
                borderWidth: null,
                backgroundColor: null
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.point.name + '</b>: ' + this.y + ' %';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>' + this.point.name + '</b>: ' + this.y + ' %';
                        }
                    }
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data: [
                        ['GESTIONADOS',<?= $gest ?>],
                        ['PENDIENTES',<?= $pend ?>],
                    ]
                }]
        });
    });


</script>

<div id="grafica" style="width: 80%; height: 300px; margin: 0 auto">
</div>
