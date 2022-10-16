<!--<form method="post" action="<?= base_url('reports/oficialcharts/get_chart_by_oficial')?>" class="form-horizontal">-->
<form method="post" action="<?= base_url('reports/oficialcharts/get_chart_by_oficial_hist')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="oficial">
    <fieldset>

<!-- Form Name -->
<!--<legend>Revisión de Gestiones por Asignacion de Oficial</legend>-->
<?php
$oficiales_credito_combo = combobox($oficiales_credito, array('value'=>'id','label'=>'firstname'), array('name'=>'oficial_credito_id','class'=>'form-control select2able'), true);
?>
<!-- Combobox Oficiales de credito -->

 <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Revisión de Gestiones por Asignacion de Oficial</h3>
  </div>
      <div class="panel-body">
<div class="form-group col-md-3">
  <label class="col-md-4 control-label" for="from_date">Oficial</label>  
  <div class="col-md-8">
      <?php
        echo $oficiales_credito_combo;      
      ?>
  </div>
</div>

<!-- Text input-->
<div class="form-group col-md-4">
  <label class="col-md-4 control-label" for="from_date">Fecha Desde</label>  
  <div class="col-md-8">
      <input id="from_date" name="from_date" placeholder="Fecha Desde" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="<?= date('Y-m-d', time()) ?>">
  </div>
</div>

<!-- Text input-->
<div class="form-group col-md-4">
  <label class="col-md-4 control-label" for="to_date">Fecha Hasta</label>  
  <div class="col-md-8">
  <input id="to_date" name="to_date" placeholder="Fecha Hasta" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="<?= date('Y-m-d', time()) ?>">
  </div>
</div>

<input type="hidden" name="comparar" value="<?= $comparar ?>"/>

<!--<div class="form-group col-md-2">
    <div class="col-md-12">
        <label class="radio-inline">
            <input id="comparar" type="radio" name="comparar" value="0" checked="">
        <span>Global</span>
        </label>
        
        <label class="radio-inline">
            <input id="comparar" type="radio" name="comparar" value="1">
        <span>Comparativa</span>
        </label>
    </div>
</div>-->

<!-- Button -->
<div class="form-group col-md-2">
      <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_gestiones_creditos_oficial" class="btn btn-primary">Graficar</button>
</div>
<!-- <div id="chart_gestion_creditos_oficial">
    
</div>-->

     </div>
  </div>

</fieldset>
   
</form>



<form method="post" action="<?= base_url('reports/oficialcharts/get_chart_by_oficial_hist_gestiones')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="oficial">
    <fieldset>

<!-- Form Name -->
<!--<legend>Revisión de Gestiones por Oficial</legend>-->
<?php
$oficiales_gestion = combobox($oficiales_gestion, array('value'=>'id','label'=>'firstname'), array('name'=>'oficial_credito_id','class'=>'form-control select2able'), true);
?>
<!-- Combobox Oficiales de credito -->



<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Revisión de Gestiones por Oficial</h3>
  </div>
      <div class="panel-body">
<div class="form-group col-md-3">
  <label class="col-md-4 control-label" for="from_date">Oficial</label>  
  <div class="col-md-8">
      <?php
        echo $oficiales_gestion;      
      ?>
  </div>
</div>

<!-- Text input-->
<div class="form-group col-md-4">
  <label class="col-md-4 control-label" for="from_date">Fecha Desde</label>  
  <div class="col-md-8">
      <input id="from_date" name="from_date" placeholder="Fecha Desde" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="<?= date('Y-m-d', time()) ?>">
  </div>
</div>

<!-- Text input-->
<div class="form-group col-md-4">
  <label class="col-md-4 control-label" for="to_date">Fecha Hasta</label>  
  <div class="col-md-8">
  <input id="to_date" name="to_date" placeholder="Fecha Hasta" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="<?= date('Y-m-d', time()) ?>">
  </div>
</div>

<input type="hidden" name="comparar" value="<?= $comparar ?>"/>

<!--<div class="form-group col-md-2">
    <div class="col-md-12">
        <label class="radio-inline">
            <input id="comparar" type="radio" name="comparar" value="0" checked="">
        <span>Global</span>
        </label>
        
        <label class="radio-inline">
            <input id="comparar" type="radio" name="comparar" value="1">
        <span>Comparativa</span>
        </label>
    </div>
</div>-->

<!-- Button -->
<div class="form-group col-md-2">
      <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_gestiones_creditos_oficial" class="btn btn-primary">Graficar</button>
</div>

    </div></div>
 
<div id="chart_gestiones_creditos_oficial">
    
</div>
</fieldset>


</form>
