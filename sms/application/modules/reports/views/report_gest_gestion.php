<?php
$oficina=set_post_value('oficina_company_id');
?>

<form method="post" action="<?= base_url('reports/welcome_2/index')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="oficina_company_id" value="<?= $oficina?>">
    <fieldset>

      
        <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Reporte General por Fechas</h3>
  </div>
  <div class="panel-body">
      <!--inicio-->
      
      <div class="form-group col-md-4">
       <label class="col-md-4 control-label" for="from_date">Fecha Desde:</label>  
    <div class="col-md-8">
         <div class='input-group date' id='divMiCalendario' >
         <input type='text' id="txtFecha" class="form-control" name="from_date" />
         <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
         </span>
          </div>
           </div>
  </div>
          <div class="form-group col-md-4">
       <label class="col-md-4 control-label" for="to_date">Fecha Hasta:</label>  
       <div class="col-md-8">
         <div class='input-group date' id='divMiCalendariom' >
         <input type='text' id="txtFecha" class="form-control" name="to_date" />
         <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
         </span>
           </div>
           </div>
  </div>


<div class="form-group col-md-3">
      <button reset-form="0" name="type_group" value="1" onclick="setExcel()" class="btn btn-primary">EXPORTAR INFORME</button>
</div>

  </div>
</div>
      

</fieldset>
</form>


 
     <script src="<?= base_url('js/moment.min.js') ?>"></script>
   <script src="<?= base_url('js/bootstrap-datetimepicker.min.js') ?>"></script>
   <script src="<?= base_url('js/bootstrap-datetimepicker.ES.js') ?>"></script>

  <script type="text/javascript">
     $('#divMiCalendario').datetimepicker({
          format: 'YYYY-MM-DD'       
      });
     
   </script>
   
   <script type="text/javascript">
     $('#divMiCalendariom').datetimepicker({
          format: 'YYYY-MM-DD'       
      });
     
   </script>
   
   <script type="text/javascript">
     $('#divMiCalendariosac').datetimepicker({
          format: 'YYYY-MM-DD'       
      });
     
   </script>