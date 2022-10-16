<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<style type="text/css">
		body{
			background: #888888
		}
		#sidebar{
			position: absolute;
			width: 18%;
			height: 590px;
			background: #222;
			color: #fff;
			margin-left: 80%;
			margin-top: -600px;
			border: 5px solid #fff;
		}
		ul{
			padding: 0;
			text-align: justify;		
		}

		 li{
			cursor: pointer;
			border-top: 1px solid #fff;
			background: #c3c3c3; 
			list-style: none;
			color: #111
		}
		li:hover{
			background: #fefefe;
		}
	</style>
	<script type="text/javascript">
	function datos_marker(lat, lng, marker){
     var mi_marker = new google.maps.LatLng(lat, lng);
     map.panTo(mi_marker);
     google.maps.event.trigger(marker, 'click');
    }
	</script>
	<?=$map['js']?>
	<title>Localizacion del cliente</title>
</head>
<body>
<?=$map['html']?>
<div id="sidebar">
	<ul>DEUDOR
		<?php

			?><li onclick="datos_marker(<?=$datos[0]->latitud?>,<?=$datos[0]->longitud?>)">
			<?=substr($datos[0]->firstname,0,14)?></li><?php
		
		?>
	</ul>
    <ul>
        </br>
        </ul>
    	<ul>REFERENCIA
		<?php

			?><li onclick="datos_marker(<?=$datos[1]->latitud?>,<?=$datos[1]->longitud?>)">
			<?=substr($datos[1]->firstname,0,14)?></li><?php
		?>
	</ul>
	<ul>
        </br>
        </ul>
    	<ul>GARANTE
		<?php

			?><li onclick="datos_marker(<?=$datos[2]->latitud?>,<?=$datos[2]->longitud?>)">
			<?=substr($datos[2]->firstname,0,14)?></li><?php
		?>
	</ul>
</div>
</body>
</html>