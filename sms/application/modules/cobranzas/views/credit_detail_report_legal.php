

    <div class="handsontable" id="example">
        <table id="table_juicios"
               data-side-pagination="server"
               data-toggle="table_juicios"
               data-height="<?php echo $data_height ?>"
               data-url="<?= base_url('cobranzas/credit/get_credit_detail_report_l/') ?>"
               data-sort-name="id"
               data-sort-order="desc"
               <?php
               if ($show_export == 1) {
                   ?>
                   data-detail-view="true"               
                   data-detail-formatter="moreActions"
                   data-pagination="true"               
                   data-show-refresh="true"
                   data-show-toggle="true"
                   data-show-columns="true"                 
                   data-show-export="true"
                   data-filter-control="true"                                                        
                   data-select-item-name="c_d_id[]"
                   data-id-field="id"
                   data-maintain-selected="true"
                   data-mobile-responsive="true"  
                   data-resizable="true"
                   <?php
               }
               ?>    

               >
            <thead>
                <tr>
                    <?php
                    if ($show_export == 1) {
                        ?>
                        <th data-field="id" data-visible="false">ID</th>
                        <th data-field="status_name" data-sortable="true" data-cell-style="cellStyle" data-filter-control="input">Estado</th>
                        <?php
                    } else {
                        ?>
                        <th data-field="id" data-visible="false" data-sortable="true">ID</th>
                        <?php
                    }
                    ?>                     
                    <th data-field="credit_type" data-visible="false" data-formatter="inputFormatterClientDir_oficial" data-sortable="true" data-filter-control="input">Juicio</th>
                    <th data-field="fecha_juicio" data-visible="false" data-sortable="true" data-filter-control="input">F. Juicio</th>
                    <th data-field="client_code" data-visible="false" data-filter-control="input">No Juicio</th>
                    <th data-field="nro_pagare" data-filter-control="input">No Operacion</th>
                    <?php
                    if ($show_export == 1) {
                        ?>
                        <th data-field="client_name" data-sortable="true" data-filter-control="input">Cliente</th>                        
                        <!--<th data-field="personal_address" data-filter-control="input">Direccion</th>-->
                        <th data-field="cedula_deudor" data-filter-control="input">Cedula</th>                             
                        <?php
                    } else {
                        ?>
                        <th data-field="client_name" data-sortable="true" data-filter-control="input">Cliente</th>
                        <th data-field="personal_address"  data-filter-control="input">Direccion</th>
                        <th data-field="cedula_deudor" data-filter-control="input">Cedula</th>
                        <?php
                    }
                    ?>     
                    <th data-field="deuda_inicial" data-sortable="true" data-filter-control="input">Deuda Inicial</th>  
                    <th data-field="plazo_original" data-visible="false" data-filter-control="input">Plazo original</th>
                    <th data-field="saldo_actual" data-sortable="true" data-filter-control="input">Saldo Deuda</th>
                    <th data-field="saldo_comision" data-sortable="true" data-filter-control="input">Saldo Más Gasto</th>
                    <th data-field="dias_mora" data-visible="true" data-sortable="true" data-filter-control="input">Dias mora</th>
					<th data-field="name" data-visible="true" data-sortable="true" data-filter-control="input">Oficina</th>
                    <th data-field="cuotas_pagadas" data-visible="false" data-filter-control="input">Cuotas pagadas</th>                  
                    <th data-field="adjudicacion_date" data-visible="false" data-filter-control="datepicker">F. Adjudicacion</th>
                    <th data-field="nro_cuotas" data-visible="true" data-filter-control="input">oficial</th>                  
                    <th data-field="last_pay_date" data-visible="false" data-filter-control="input">F. ultimo pago</th>                  
                </tr>
            </thead>
        </table>    
    </div>

<script>
    $(function () {
        $('input[rel="txtTooltip"]').tooltip();
    });

    $('[data-toggle="table_juicios"]').bootstrapTable();
    var $table = $('#table_juicios');
    


<?php
if ($show_export == 1) {
    ?>
        function moreActions(index, row) {
            var html = [];
            var id = row['nro_pagare'];
            var openDoc = '<a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/cobranzas__credit__open_credit_detaill__' + id + '/0/0">Ver Historial</a>';
            html.push(openDoc);
            return html.join('');
        }
    <?php
}
?>
    /**
     * Desactiva seleccion de comprobantes que no son ni seran documentos electronicos
     * @param {type} value
     * @param {type} row
     * @param {type} index
     * @returns {disabledAnulados.ml_sricomprob_reportAnonym$0}
     */
    function disabledNoElectronic(value, row, index) {
        if (row['status_name'] == 'CANCELADO') {
            return {
//                checked: true
                disabled: true
            };
        }
//        else{
//            return {
//                checked: false
//            };            
//        }
        return value;
    }

   

    
    function inputFormatterClientDir_oficial(index, row) {
        var credit_type = row['credit_type'];
        var client_id_oficial = row['client_id_oficial'];
        var inputClientIdOficial = "<input type='hidden'  rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + client_id_oficial + "' name='client_id_oficial[]' value='" + client_id_oficial + "'/> ";
        return inputClientIdOficial + credit_type;
    }


    function inputPersonId(index, row) {
        var person_id = row['person_id'];
        var credit_detail_id = row['credit_detail_id'];
        var client_name = row['client_name'];
        var deuda_inicial = row['deuda_inicial'];

        var inputPerson = "<input type='hidden' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + person_id + "' name='person_id[]' value='" + person_id + "'/> ";
        var credit_detail_id = "<input type='hidden' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + credit_detail_id + "' name='credit_detail_id[]' value='" + credit_detail_id + "'/> ";
        var inputClientName = "<input type='hidden' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + client_name + "' name='client_name_ofic[]' value='" + client_name + "'/> ";
        var inputDetail = "<input type='text' disabled style='background-color:ffffff' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + deuda_inicial + "' name='deuda_inicial' value='" + deuda_inicial + "'/> ";

        return inputPerson + credit_detail_id + inputClientName + inputDetail;
    }

    function inputFormatterStatusName(index, row) {
        var color = row['color'];
        var background = row['background'];
        var status_name = row['status_name'];
        var inputDetail = "<input style='background:" + background + "; color:" + color + "; width:100px ' name='status_name' value='" + status_name + "'/> ";
        return inputDetail;
    }
    function cellStyle(value, row, index) {
        var color = row['color'];
        var background = row['background'];
        return {
            //classes: classes[index / 2]
            css: {
                "background": background,
                "color": color,
            }
        };
    }

</script>