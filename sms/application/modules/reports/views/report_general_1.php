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
$agencias_combo = combobox($agencias, array('value' => 'id', 'label' => 'name'), array('name' => 'oficina_company_id', 'class' => 'form-control select2able'), true);

$mysqli = mysqli_connect($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
if (!$mysqli->multi_query("CREATE TEMPORARY TABLE tmp_producciones (select cd .id,cd.credit_status_id ,cd.oficina_company_id,
cd.oficial_credito_id from credit_detail cd where month(cd.load_date)=MONTH(CURDATE()) and year(cd.load_date)=year(CURDATE()));")) {
    echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
}
//pendientes
if (!$mysqli->multi_query("select cd.oficial_credito_id, count(cd.credit_status_id) as Pendientes, cd.oficina_company_id
                from tmp_producciones cd 
                 where cd.credit_status_id=21
                GROUP by (cd.oficial_credito_id);")) {
    echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
}
$res = $mysqli->store_result();
$coco = $res->fetch_all();
foreach ($coco as $value) {
    $mysqli->query("UPDATE reporte2 SET pendientes=$value1[1]  WHERE  id_oficial=$value1[0];");
}
//compromisos
if (!$mysqli->multi_query("select cd.oficial_credito_id, count(cd.credit_status_id) as Compromiso, cd.oficina_company_id
                from tmp_producciones cd 
                 where cd.credit_status_id=23
                GROUP by (cd.oficial_credito_id);")) {
    echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
}
$res = $mysqli->store_result();
$coco = $res->fetch_all();
foreach ($coco as $value) {
    
$mysqli->query("UPDATE reporte2 SET compromiso=$value1[1] WHERE  id_oficial=$value1[0];");
}
//gestionados
if (!$mysqli->multi_query("select cd.oficial_credito_id, count(cd.credit_status_id) as Gestionados, cd.oficina_company_id
                from tmp_producciones cd 
                 where cd.credit_status_id!=21
                GROUP by (cd.oficial_credito_id);")) {
    echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
}
$res = $mysqli->store_result();
$coco = $res->fetch_all();
foreach ($coco as $value) {
    $mysqli->query("UPDATE reporte2 SET gestionados=$value1[1] WHERE  id_oficial=$value1[0]") ;
       
}
?>  
<form method="post" action="<?= base_url('reports/reportes/open_view_produccion') ?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="agencia">
    <input type="hidden" name="oficina_company_id" value="390">
    <fieldset>

        <div class="panel panel-primary" >
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de Produccion de Gestion</h3>
            </div>
            <div class="panel-body">
                <label class="col-md-1 control-label" for="agencia">AGENCIA</label>  
                <div class="col-md-3">
<?php
echo $agencias_combo;
?>
                </div> 
                <!-- Text input-->
                <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_produccion" class="btn btn-primary">Ver Tabla</button>
            </div>
        </div>
    </fieldset>

</form>

<div id="chart_produccion">

</div>