<?php
$agencia=set_post_value('oficina_company_id');
$mes=set_post_value('mes_id');

?>
<!DOCTYPE HTML>

<html>
	<head>
                <?PHP include_once 'config.inc.php';?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>RECUPERACION DE CARTERA </title>

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
                    $sql2="select r.oficial_name, IFNULL(round((r.cantidad_recuperada*100/(r.cantidad_creditos+r.aux_cant)),2),0)  as total
 from reporte1 r WHERE r.cantidad_creditos!=0;
";
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
	
	<script type="text/javascript">
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
            text: 'RECUPERACIÓN DE CAPITAL GENERAL'
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
                    $sql3="select IFNULL(round((SUM(r.capital_recuperado)*100)/(SUM(r.capital)),2),0) from reporte1 r where r.cantidad_creditos!=0;
";
                    $que1= $db2->execute($sql3);
                    while ($row4= $db1->fetch_row($que1)){ 
                    $dif=100-$row4[0];   
                        ?>
                                           
                                            {name:'CAPITAL RECUPERADO', 
                                                y: <?php echo $row4[0] ?>
                                            },
                                            {name:'CAPITAL NO RECUPERADO', 
                                                y: <?php echo$dif?>
                                            },        
                    <?Php }
                    
            ?>
            ]
        }]
    });
}

);              
                
</script>    
	
	
	
	</head>
	<body>
            
<script src="//code.highcharts.com/stock/highstock.js"></script> 
<script src="//code.highcharts.com/modules/exporting.js"></script> 

<div id="container" style="min-width: 150px; height: 300px; margin: 0 auto"></div>
<br>
<br>
<div id="container1" style="min-width: 150px; height: 300px; margin: 0 auto"></div>

	</body>
</html>
