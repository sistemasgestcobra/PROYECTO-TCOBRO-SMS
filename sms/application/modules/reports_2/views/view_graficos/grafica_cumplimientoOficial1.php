<?php
$oficina=set_post_value('oficina_company_id');
$mes=set_post_value('mes_id');
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
            type: 'bar'
        },
        title: {
            text: 'Reporte de Recuperacion de Cartera'
        },
        subtitle: {
            text: 'Reporte Cumplimiento General por Agencia'
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
                    $sql2="select of.name, ROUND((rm.capital_recuperada *100)/rm.capital,2) from reporte_general_mensual rm, oficina_company of 
					where of.id=rm.oficina_company_id and rm.mes_id=$mes and rm.oficina_company_id=423;";
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


	</body>
</html>
