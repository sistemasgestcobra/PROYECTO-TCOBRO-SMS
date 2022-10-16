<?php
//$id;
// $datos= explode (".", $id);
// $mes=$datos[0];
// $agencia=$datos[1];
$agencia=set_post_value('oficina_company_id');
if ($agencia==-1) {
     $sql2="select ct.name,ROUND((count(cd.id)*100)/(select count(id) from credit_detail where credit_status_id!=22 and month(load_date)=MONTH(CURDATE())),2) 
	 from credit_detail cd, credito_type ct where cd.credito_type_id=ct.id and cd.credit_status_id!=22 and  month(cd.load_date)=MONTH(CURDATE())
	 GROUP by cd.credito_type_id;";
} else {
     $sql2="select ct.name,ROUND((count(cd.id)*100)/(select count(id) from credit_detail where credit_status_id!=22 and  month(load_date)=MONTH(CURDATE()) and oficina_company_id=$agencia ),2) 
	 from credit_detail cd, credito_type ct where cd.credito_type_id=ct.id and month(cd.load_date)=MONTH(CURDATE()) and cd.credit_status_id!=22 and cd.oficina_company_id=$agencia GROUP by cd.credito_type_id;";
}

?>

<!DOCTYPE HTML>

<html>
	<head>
                <?PHP include_once 'config.inc.php';?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>REPORTE TIPO PRODUCTO</title>

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
            text: 'Reporte Tipo de Producto'
        },
        subtitle: {
            text: 'Reporte Tipo de Producto'
        },
        xAxis: {
            type: 'category',
            text: 'Producto'
        },
        yAxis: {
            title: {
                text: 'Total Porcentaje de productos'
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
            name: 'Producto',
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
           