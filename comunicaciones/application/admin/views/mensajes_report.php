<form method="post" action="<?= base_url('admin/notificationformat/save') ?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <input type="hidden" name="lote" value="1">
     <?php
  //$fp = fopen("sms.txt", "a");
        define('TP_USER', '35AD86A1B2943BA');//ID
		define('TP_PASS', '8CC10AC182');//KEY
            $direc="http://envia-movil.com/Api/Saldos";
            $array=array("Authorization: Basic " . base64_encode(TP_USER . ":" . TP_PASS),
		              "Content-type: application/json",
		              "Accept: application/json");
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $direc);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$array);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);

            $response = curl_exec($ch);
			
            //fputs($fp,"--".$response);
            
            curl_close($ch);
            //fclose($fp);
            
           $ft=  json_decode($response);
			$rt=(array)$ft;
			$sms=$rt[0];
			$lol=(array)$sms;

    $var=$lol['Saldo'];
	$uc=5000;
	$ut=$uc-$var;
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

<th >ULTIMA COMPRA</th>
<th >DISPONIBLES</th>
<th >UTILIZADOS</th>


	</tr></div>";

echo "
		<tr class=bg2>
			<td  >".$uc."</td>
			<td  >".$var."</td>
			<td  >".$ut."</td>
			
			
                                
		</tr> ";

echo "</table> </center>";
              ?>

   

</form>
<script>
    $('[data-toggle="table"]').bootstrapTable();

    var $table_notif = $('#table_notif'),
            $button_notif = $('#button_insert_notif');
    $(function () {
        $button_notif.click(function () {
            var randomId = 100 + ~~(Math.random() * 100);
            $table_notif.bootstrapTable('prepend', {
                index: 1,
                row: {
//                    id: randomId,
//                    name: 'Item ' ,
//                    price: '$'
                }
            });
        });
    });

//    function editTemplate(index, row) {
//        var html = [];
//        var id = row['id'];
//        var type = row['type'];
//        var openDoc = '<a class="" href="<?= base_url('admin/notificationformat/edit_template') ?>/' + id + '">Modificar</a>';
//        html.push(openDoc);
//        return html.join('');
//    }

    function inputFormatterDescription(index, row) {
        var id = row['id'];
        var description = row['description'];
        var inputId = "<input type='hidden' class='' name='id[]' value='" + id + "'/> ";
        var inputDescription = "<input required='' style='min-width:200px' class='' name='description[]' value='" + description + "'/> ";
        return inputId + inputDescription;
    }

    function inputFormatterType(index, row) {
        var type = row['type'];
        var selected = '';
        var role = "<select class=' select2able' name='type[]'>";
<?php
$notification = array(
    "NOTIFICACION",
    "MENSAJE"
);
foreach ($notification as $value) {
    ?>
            if (type == "<?= $value ?>") {
                selected = 'selected';
            } else {
                selected = '';
            }
            role += "<option " + selected + " value='<?= $value ?>'><?= $value ?></option>";
    <?php
}
?>
        role += "<select>";
        return role;
    }

    function inputFormatterFormato(index, row) {
        var format = row['format'];
        var inputDescription = "<textarea id='summernote_contract' class='form-control' name='template_data[]' style='height: 250px'>" + format + "</textarea>";
        return inputDescription;
    }

//        $(document).on("click", "#autosubmit_edit_template", function(e) {
//            $("#summernote_contract2").val( $('#summernote_contract').code() );
//        });          
</script>