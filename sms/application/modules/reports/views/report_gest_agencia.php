<!--<form method="post" action="<?= base_url('reports/agenciacharts/get_chart_by_agencia')?>" class="form-horizontal">-->
<form method="post" action="<?= base_url('reports/agenciacharts/get_chart_by_agencia_hist')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="agencia">
    <fieldset>

<?php
$agencias_combo = combobox($agencias, array('value'=>'id','label'=>'name'), array('name'=>'oficina_company_id','class'=>'form-control select2able'), true);
?>
<!-- Combobox Oficiales de credito -->


<div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Revisión de Gestiones por Agencia</h3>
            </div>
            <div class="panel-body">

<div class="form-group col-md-4">
  <label class="col-md-4 control-label" for="from_date">Agencia</label>  
  <div class="col-md-8">
      <?php
        echo $agencias_combo;      
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

<div class="form-group col-md-1">
      <button reset-form="0" name="type_group" value="1" id="autosubmit_agencia" data-target="#chart_gestion_creditos_agencia" class="btn btn-primary">Graficar</button>

</div>
</div></div>
</fieldset>
</form>




<form method="post" action="<?= base_url('reports/agenciacomunicationscharts/get_chart_comunication_by_agencia')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="agencia">
    <fieldset>

<?php
$agencias_combo = combobox($agencias, array('value'=>'id','label'=>'name'), array('name'=>'oficina_company_id','class'=>'form-control select2able'), true);

?>
<!-- Combobox Oficiales de credito -->


<div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Revisión de Comunicaciones por Agencia</h3>
            </div>
            <div class="panel-body">

<div class="form-group col-md-4">
  <label class="col-md-4 control-label" for="from_date">Agencia</label>  
  <div class="col-md-8">
      <?php
        echo $agencias_combo;      
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
<div class="form-group col-md-1">
      <button reset-form="0" name="type_group" value="1" id="autosubmit_1" data-target="#chart_gestion_creditos_agencia" class="btn btn-primary">Graficar</button>
</div>
</div>
</div>
<div id="chart_gestion_creditos_agencia">
    
</div>
</fieldset>
</form>

<!--<div id="chart_comunicationes_agencia">  
</div>-->

<!--<script>
      $(function() {
            $( "#autosubmit_agencia" ).trigger( "click" );          
      });
</script>-->