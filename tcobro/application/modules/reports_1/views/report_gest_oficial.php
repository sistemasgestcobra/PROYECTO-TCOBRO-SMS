<!--<form method="post" action="<?= base_url('reports/oficialcharts/get_chart_by_oficial')?>" class="form-horizontal">-->
<form method="post" action="<?= base_url('reports/oficialcharts/get_chart_by_oficial_hist')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="oficial">
    <fieldset>

<!-- Form Name -->
<legend>Revisión de Gestiones</legend>
<?php
$oficiales_credito_combo = combobox($oficiales_credito, array('value'=>'id','label'=>'firstname'), array('name'=>'oficial_credito_id','class'=>'form-control select2able'), true);
?>
<!-- Combobox Oficiales de credito -->
<div class="form-group col-md-4">
  <label class="col-md-4 control-label" for="from_date">Oficial</label>  
  <div class="col-md-8">
      <?php
        echo $oficiales_credito_combo;      
      ?>
  </div>
</div>

<!-- Text input-->
<div class="form-group col-md-4">
  <label class="col-md-6 control-label" for="from_date">Fecha Desde</label>  
  <div class="col-md-6">
      <input id="from_date" name="from_date" placeholder="Fecha Desde" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="<?= date('Y-m-d', time()) ?>">
  </div>
</div>

<!-- Text input-->
<div class="form-group col-md-4">
  <label class="col-md-6 control-label" for="to_date">Fecha Hasta</label>  
  <div class="col-md-6">
  <input id="to_date" name="to_date" placeholder="Fecha Hasta" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="<?= date('Y-m-d', time()) ?>">
  </div>
</div>

<input type="hidden" name="comparar" value="<?= $comparar ?>"/>


<!-- Button -->
<div class="form-group col-md-20">
      <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_gestion_creditos_oficial" class="btn btn-primary">Graficar</button>
</div>

</fieldset>
</form>

<div id="chart_gestion_creditos_oficial">
    
</div>