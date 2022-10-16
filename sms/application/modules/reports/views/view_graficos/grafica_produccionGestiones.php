<?php
//$id;
// $datos= explode (".", $id);
// $mes=$datos[0];
// $agencia=$datos[1];
$agencia=set_post_value('oficina_company_id');
if ($agencia==-1) {
     $sql2="select oficial_name, IFNULL(((gestionados*100/(pendientes+gestionados))),0)
from reporte2 WHERE r.cantidad_creditos!=0
";
} else {
     $sql2="select oficial_name, IFNULL(((gestionados*100/(pendientes+gestionados))),0)
from reporte2 WHERE r.cantidad_creditos!=0 and rm.oficina_id=$agencia;
";
}

?>

<!DOCTYPE HTML>

<html>
	<head>
                <?PHP include_once 'config.inc.php';?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>PRODUCCIÓN DE CUMPLIMIENTO POR OFICIAL</title>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
		</style>
		<script type="text/javascript">                   
$(function () {
    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Reporte de Producción'
        },
        subtitle: {
            text: 'PRODUCCIÓN DE GESTIONES POR CADA OFICIAL'
        },
        xAxis: {
            type: 'category',
            text: 'Gestores'
        },
        yAxis: {
            title: {
                text: 'Total Pocentaje de Producción'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [{
            name: 'Gestores',
            colorByPoint: true,
            data: [
           <?php $db1= new Conect_MySql();
                    $sql2=$sql2;
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
                
<script>
  $(function dos() {
    // Create the chart
    Highcharts.chart('container1', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Reporte de Producción'
        },
        subtitle: {
            text: 'PRODUCCIÓN DE GESTIONES GENERAL'
        },
        xAxis: {
            type: 'category',
            text: 'Gestores'
        },
        yAxis: {
            title: {
                text: 'Total Pocentaje de Producción'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [{
            name: 'Productividad',
            colorByPoint: true,
            data: [
           <?php $db2= new Conect_MySql();
                    $sql3="select IFNULL((sum(r.gestionados)*100)/(select count(*) from 
credit_detail cd
) ,0) as total from reporte2 r;
";
                    $que1= $db2->execute($sql3);
                    while ($row4= $db1->fetch_row($que1)){ 
                    $dif=100-$row4[0];   
                        ?>
                                           
                                            {name:'GESTIONADOS', 
                                                y: <?php echo $row4[0] ?>
                                            },
                                            {name:'PENDIENTES', 
                                                y: <?php echo$dif?>
                                            },        
                    <?Php }
                    
            ?>
            ]
        }]
    });
});              
                
</script>    
	</head>
	<body>
            
<script src="//code.highcharts.com/stock/highstock.js"></script> 
<script src="//code.highcharts.com/modules/exporting.js"></script> 

<div id="container" style="min-width: 100px; height: 200px; margin: 0 auto"></div>
<br>
<br>

	</body>
</html>
