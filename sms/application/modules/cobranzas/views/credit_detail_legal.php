<?php
if ($show_export == 1) {
    ?>
    <form method="post" action="<?= base_url('cobranzas/index/legal') ?>" class="form-horizontal " name="pri">

       <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">    
  <div class="col-md-12" id="messagesout_newcompany"></div>    
  <hr class="clr"/>
        

        <?php
    }
    ?>
    

    <?php
    if ($show_export == 1) {
      
    ?>
        <div class="form-group" >
        <strong class="col-md-2">Ingrese Nro. Operaci&oacute;n:</strong>
        <div class="col-md-2">
        <input class="form-control" id="min" type="text" name="pagare" maxlength="10" value=""  placeholder="Pagare" /> 
        </div>
		       
        <div class="col-md-2">
            <button type="button" id="filtro" class="btn btn-primary pull-right" name="notification_id" value="filtrar" style="font-size: 15px" onclick="this.form.action='<?= base_url('credit_details_legal.jsp/') ?>';this.form.submit();">BUSCAR</button>
        </div> 
    </div>

	
    <?php
    }
     ?>               

    

<!--<a id="call-php" class="btn btn-primary pull-left" href="#" data-target="messagesout" php-function="modal/admin__empresa__open_ml_empresa/0/0">Nueva Empresa</a>-->

<!--data-detail-formatter="detailFormatter"-->
<div class="handsontable" id="example">
    <strong class="text-primary">Historial Legal:</strong>            
    <table id="table_credit_hist_2<?= $show_export ?>" class="table-condensed"
           data-side-pagination="server"
           data-pagination="true"                  
           data-toggle="table_credits_hist_2"
           data-height="<?php echo $data_height ?>"
           data-url="<?= base_url('cobranzas/credit/get_hist_report_legal/'. $client_id) ?>"
           data-sort-name="id"
           data-sort-order="desc"
           <?php
           if ($show_export == 1) {
               ?>
               data-detail-view="true"                      
               data-show-refresh="true"
               data-show-toggle="true"
               data-show-columns="true"                 
               data-show-export="true"
               data-filter-control="true"
               <?php
           }
           ?>                    
           >
        <thead>
            <tr>
                <th data-field="id" data-visible="false" data-filter-control="input">ID</th>
                <?php
                if ($show_export == 1) {
                    ?>
                    <th data-field="status_name" data-sortable="true" data-cell-style="cellStyle" data-filter-control="input">Estado</th>
                    <th data-field="cedula_deudor" data-filter-control="input">Cedula</th>   
                    <th data-field="nro_pagare" data-filter-control="input">Nro. Operaci&oacute;n</th>   
                    <th data-field="client_code" data-filter-control="input">Cod. Cliente</th>
                    <th data-field="client_name" data-filter-control="input">Cliente</th>
                    <th data-field="detail" data-filter-control="input">Detalle</th>                    
                    <?php
                } else {
                    ?>
                    <th data-field="status_name" data-formatter="inputFormatterStatusName"  data-filter-control="input">Estado</th>      
                    <th data-field="cedula_deudor" data-filter-control="input">Cedula</th>   
                    <th data-field="nro_pagare" data-filter-control="input">Nro. Operaci&oacute;n</th>   
                    <th data-field="client_name"  data-filter-control="input">Cliente</th>                    
                    <th data-field="detail"  data-filter-control="input">Detalle</th>
                    <th data-field="gasto" data-filter-control="input">Gasto Judicial</th>
                    <?php
                }
                ?>                                         
                <th data-field="hist_date" data-filter-control="input">Fecha</th>
                <th data-field="hist_time" data-filter-control="input">Hora</th>
                <th data-field="compromiso_pago_date" data-filter-control="input">Fecha Proxima</th>
                <th data-field="adjunto" data-formatter="inputFormatter" data-filter-control="input">Bajar archivo</th>
               
            </tr>
        </thead>
    </table>            
</div>        

</form>
<script>
    $('[data-toggle="table_credits_hist_2"]').bootstrapTable();

    function inputFormatterDetailHist(index, row) {
        var detail = row['detail'];
        var inputDetail = "<input type='text' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + detail + "' style='min-width:200px' class='' name='detail_hist' value='" + detail + "'/> ";
        return inputDetail;
    }


function inputFormatter(index, row) {  
       var html = [];
        var id = row['adjunto'];
        var msj="No hay Archivo";  
        if( id !== "vacio"){
        var openDoc = '<a class="" target="_blank" href="http://demolegal3.gestcobra.com/uploads/20/adjuntos/' + id + '">ver Adjunto</a>';
        html.push(openDoc);
        return html.join('');
    }else(id === "vacio")
        var inputDetail = "<input type='text' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + msj + "' style='min-width:200px' class='' name='detail_hist' value='" + msj + "'/> ";
        return inputDetail;
    }

</script>


