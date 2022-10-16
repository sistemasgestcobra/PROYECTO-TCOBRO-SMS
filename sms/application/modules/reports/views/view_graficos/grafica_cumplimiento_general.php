<?php
//$id;
// $datos= explode (".", $id);
// $mes=$datos[0];
// $agencia=$datos[1];
$agencia=set_post_value('oficina_company_id');
if ($agencia==-1) {
     $sql2="select rm.oficial_name,  IFNULL( ROUND((rm.capital_recuperado *100)/rm.capital,2),0) as recuperado
from reporte1 rm;
";
} else {
     $sql2="select rm.oficial_name,  IFNULL( ROUND((rm.capital_recuperado *100)/rm.capital,2),0) as recuperado
from reporte1 rm WHERE rm.oficina_id=$agencia;
";
}

?>

<!DOCTYPE HTML>

<html>
	<head>
                <?PHP include_once 'config.inc.php';?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>RECUPERACION DE CARTERA MENSUAL</title>

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
            text: 'Reporte de Recuperacion de Cartera'
        },
        subtitle: {
            text: 'Reporte Cumplimiento General por Oficial'
        },
        xAxis: {
            type: 'category',
            text: 'Gestores'
        },
        yAxis: {
            title: {
                text: 'Total Pocentaje de Cumplimiento'
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
	
                
                
                
	
	
	
	</head>
	<body>
            
<script src="//code.highcharts.com/stock/highstock.js"></script> 
<script src="//code.highcharts.com/modules/exporting.js"></script> 

<div id="container" style="min-width: 150px; height: 300px; margin: 0 auto"></div>
<br>
<br>
<?php
//            if ($agencias!=-1) {
//    
//}
?>

	</body>
</html>
           