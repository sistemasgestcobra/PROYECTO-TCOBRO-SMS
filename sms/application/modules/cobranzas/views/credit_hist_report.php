
        <!--<a id="call-php" class="btn btn-primary pull-left" href="#" data-target="messagesout" php-function="modal/admin__empresa__open_ml_empresa/0/0">Nueva Empresa</a>-->

        <!--data-detail-formatter="detailFormatter"-->
        <div class="handsontable" id="example">
    <strong class="text-primary">Historial Extrajudicial:</strong>            
            <table id="table_credit_hist<?= $show_export ?>" class="table-condensed"
                   data-side-pagination="server"
                   data-pagination="true"                  
                   data-toggle="table_credits_hist"
                   data-height="<?php echo $data_height ?>"
                   data-url="<?= base_url('cobranzas/credit/get_hist_report/'.$client_id.'/'.$compromiso_pago_date) ?>"
                   data-sort-name="id"
                   data-sort-order="desc"
               <?php
                if( $show_export == 1 ){
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
                    <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
                <tr>
                    <th data-field="id" data-visible="false" data-filter-control="input">ID</th>
                <?php
                if( $show_export == 1 ){
                ?>
                    <th data-field="status_name" data-sortable="true" data-cell-style="cellStyle" data-filter-control="input">Estado</th>
                    <th data-field="client_code" data-filter-control="input">Cod. Cliente</th>
                    <th data-field="client_name" data-filter-control="input">Cliente</th>
                    <th data-field="detail" data-filter-control="input">Detalle</th>                    
                <?php
                }else{
                    ?>
                    <th data-field="status_name" data-formatter="inputFormatterStatusName"  data-filter-control="input">Estado</th>                    
                    <th data-field="client_name"  data-filter-control="input">Cliente</th>                    
                    <th data-field="detail" data-formatter="inputFormatterDetailHist" data-filter-control="input">Detalle</th>                    
                    <?php
                }
                ?>                                         
                    <th data-field="hist_date" data-filter-control="input">Fecha</th>
                    <th data-field="hist_time" data-filter-control="input">Hora</th>
                    <th data-field="compromiso_pago_date" data-filter-control="input">Comprom. Pago</th>
                    <th data-field="firstname" data-filter-control="input">Gestor</th>
					<th data-field="propietario" data-filter-control="input">Oficial</th>
                    <th data-field="nombre_comision" data-filter-control="input">Tipo Comision</th>
                    <th data-field="valor_comision" data-filter-control="input">Valor Comision</th>
                </tr>
                </thead>
            </table>            
        </div>        


<script>
        $('[data-toggle="table_credits_hist"]').bootstrapTable();
    
       function inputFormatterDetailHist(index, row) {
           var detail = row['detail'];
           var inputDetail = "<input type='text' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+detail+"' style='min-width:200px' class='' name='detail_hist' value='"+detail+"'/> ";
           return inputDetail;
       }
         
</script>