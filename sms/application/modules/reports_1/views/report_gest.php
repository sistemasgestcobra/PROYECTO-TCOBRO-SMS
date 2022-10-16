<!--<form method="post" action="<?= base_url('reports/charts/get_credit_detail_chart1')?>" class="form-horizontal">-->
<form method="post" action="<?= base_url('reports/charts/get_credit_hist_chart1')?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="search_type" value="date">
    <fieldset>

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
<div class="form-group col-md-3">
    <div class="col-md-12">
        <button reset-form="0" name="type_group" value="1" id="autosubmit_diario" data-target="#chart_gestion_creditos" class="btn btn-primary">Graficar</button>
    </div>
</div>

</fieldset>
</form>

<div id="chart_gestion_creditos">
    
</div>
<script>
      $(function() {
            $( "#autosubmit_diario" ).trigger( "click" );          
      });
</script>