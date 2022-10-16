<form method="post" action="<?= base_url('msjs/reporte/index')?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
<div class="form-group col-md-3">
      <button name="type_group" value="1" onclick="reportediario()" class="btn btn-primary">EXPORTAR INFORME DIARIO</button>
</div>
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
               data-url="<?= base_url('msjs/report/get_envio_report')?>"
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
                    <th data-field="usuario"  >Usuario</th>
              
                </tr>
            </thead>
        </table>    
</div>