  <?php
       $agencias_combo = combobox($agencias, array('value' => 'id', 'label' => 'name'), array('name' => 'oficina_company_id', 'class' => 'form-control select2able'), true);
		
       //$conn = mysqli_connect($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
       $mysqli = new mysqli($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
            if (!$mysqli->multi_query("CREATE TEMPORARY TABLE tmp_reporte4 (select cd .id,credit_status_id, cd.oficina_company_id,
cd.oficial_credito_id,cd.total_cuotas_vencidas, cd.total_pagar, cd.dias_mora
from credit_detail cd where month(cd.load_date)=MONTH(CURDATE()) and cd.dias_mora>=0 and  year(cd.load_date)=year(CURDATE()));")){
                echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
     

            if (!$mysqli->multi_query("select cd.oficial_credito_id, credit_status_id, cd.oficina_company_id,
count(cd.id), round(sum(cd.total_cuotas_vencidas),2) as capital
from tmp_reporte4 cd 
GROUP by (cd.oficial_credito_id);")){
                echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            $res = $mysqli->store_result();
        $coco=$res->fetch_all();
            foreach($coco as $value){
                $mysqli->query("update reporte1 set cantidad_creditos = $value[3],capital= $value[4] where id_oficial = $value[0] and oficina_id = $value[2];");

            }
            
            
            if (!$mysqli->multi_query("select cd.oficial_credito_id,cd.oficina_company_id,
count(cd.id), round(sum(cd.total_pagar),2) as recuperado
from tmp_reporte4 cd where cd.total_pagar!='Null'
GROUP by (cd.oficial_credito_id);")){
                echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
			
			
        $res = $mysqli->store_result();
        $coco=$res->fetch_all();
            foreach($coco as $value){
                $mysqli->query("update reporte1 set cantidad_recuperada = $value[2],capital_recuperado = $value[3] where id_oficial = $value[0] and oficina_id = $value[1];");
            }
       
       ?>   
<form method="post" action="<?= base_url('reports/reportes/open_view_reporte')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <fieldset>

  
        
        
         <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Cumplimiento General por Oficial </h3>
            </div>

            <div class="panel-body">
                <label class="col-md-1 control-label" for="agencia">AGENCIA</label>  
                <div class="col-md-3">
                    <?php
                    echo $agencias_combo;
                    ?>
                </div> 
                <!-- Text input-->
                 
                <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_recuperacion" class="btn btn-primary">Ver Tabla</button>

            </div>



        </div>
        
<br></fieldset>

</form>
<div id="chart_recuperacion">

</div>
