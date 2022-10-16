    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <input type="hidden" name="lote" value="1">
     <?php
      	$this->load->library('comunications/commws');
    
     $commws= new Commws();
     $rt= $commws->saldo_cd($this->user->company_id);
	
	$ft=  json_decode($rt);
			$rt=(array)$ft;
			$sms=$rt["result"];
			$lol=(array)$sms;
			$general=$lol[0];
			$ge=(array)$general;
			$saldo=$ge["available"];
			$enviados=$ge["totalSpent"];
			$compra=$ge["total"];
			
			
    $web="https://gestcobra.com/compras/datos.php?coop=utpl";
	$lines = file($web);
        $leersms=explode("-", $lines[0]);
        $tc=$leersms[0];
        $uc=$leersms[1];
		        $uc=$leersms[1];
$acreditados=1000000;
        $por_acreditar=0;
    ?>   
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
<?php

echo " 	<div class=datagrid> <center>
    <table border = 1 cellspacing = 1 cellpadding = 1 >
		
    <thead>
<tr>
<th >TOTAL SMS COMPRADOS</th>
<th >ULTIMA COMPRA</th>

<th >DISPONIBLES</th>
<th >UTILIZADOS</th>



	</tr></div>";

echo "
            <tr class=bg2>
            <td  >".$compra."</td>
            <td  >".$compra."</td>
           
            <td  >".$saldo."</td>
            <td  >".$enviados."</td>
			
			
                                
		</tr> ";

echo "</table> </center>";
              ?>


<hr>
