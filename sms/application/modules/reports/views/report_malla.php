
<form method="post" action="<?= base_url('reports/oficialcharts/open_view_report_malla')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="agencia">
    <fieldset>

<?php
$agencias_combo = combobox($agencias, array('value'=>'id','label'=>'name'), array('name'=>'oficina_company_id','class'=>'form-control select2able'), true);
?>
<!--$agencias_combo = combobox($agencias, array('value'=>'id','label'=>'name'), array('name'=>'oficina_company_id','class'=>'form-control select2able'), true);-->
<!-- Combobox Oficiales de credito -->
<div class="form-group col-md-4">
  <label class="col-md-4 control-label" for="from_date">Agencia</label>  
  <div class="col-md-8">
      <?php
        echo $agencias_combo;      
      ?>
  </div>
</div>

<!-- Text input-->

<input type="hidden" name="comparar" value="<?= $comparar ?>"/>

<br>
<br>

<div class="form-group col-md-1">
      <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_gestion_malla" class="btn btn-primary">VER REPORTE</button>
</div>

</fieldset>
</form>
<div id="chart_gestion_malla">
    
</div>