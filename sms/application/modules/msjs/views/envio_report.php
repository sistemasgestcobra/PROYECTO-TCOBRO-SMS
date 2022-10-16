<form method="post" action="<?= base_url('msjs/reporte/index2')?>" class="form-group">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <fieldset>
<div class="form-group col-md-3">
  <label class="col-md-6 control-label" for="from_date">Fecha Desde</label>  
  <div class="col-md-6">
      <input id="from_date" name="from_date" placeholder="Fecha Desde" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="">
  </div>
</div>

<!-- Text input-->
<div class="form-group col-md-3">
  <label class="col-md-6 control-label" for="to_date">Fecha Hasta</label>  
  <div class="col-md-6">
  <input id="to_date" name="to_date" placeholder="Fecha Hasta" class="form-control input-md datepicker" data-date-autoclose="true" type="text" value="">
  </div>
</div>
<div class="form-group col-md-3">
      <button name="type_group" value="1" class="btn btn-primary">EXPORTAR REPORTE POR FECHA</button>
</div>
</fieldset>
</form>

<div class="handsontable" id="example">
        <!--data-detail-formatter="detailFormatter"-->
        <table id="table_sms"
               data-toolbar="#toolbar"
               data-side-pagination="server"
               data-pagination="true"
               data-toggle="table"
               data-height="460"
               data-detail-view="true"     
               data-url="<?= base_url('msjs/credit/get_credit_hist_report')?>"
               data-sort-name="id"
               data-sort-order="desc"
               data-show-refresh="true"
               data-show-toggle="true"
               data-show-columns="true"
               data-show-export="true"
               
        >
            <thead>
                <tr>
                    <th data-field="id" data-visible="false" >ID</th>
                    <th data-field="hist_date" data-sortable="true"><span>Fecha</span></th>
                    <th data-field="hist_time" >Hora</th>
                    <th data-field="detail" >Detalle</th>
                    <th data-field="enviados"  >SMS Enviados</th>
                    <th data-field="excluidos"  >SMS Excluidos</th>
					<th data-field="usuario"  >Remitente</th>
					<th data-field="fecha_programado"  >Fecha Mensajes Programados</th>
              
                </tr>
            </thead>
        </table>    
</div>