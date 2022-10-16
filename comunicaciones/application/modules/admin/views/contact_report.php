<?php
if ($show_export == 1) {
    ?>
    <form method="post" action="<?= base_url('admin/notificationformat/notification_print/0') ?>" class="form-horizontal">

       

        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">    
        <!--    <div class="col-md-4" style="font-size: 16px; background: #eee; padding: 5px ">
            <div class="col-md-8 col-xs-7">Nro. Clientes Gestionados:</div>
            <div class="col-md-4 col-xs-5" id="num_cl_gestionados">0</div>
            <div class="col-md-8 col-xs-7">Suma de Saldo Inicial:</div>
            <div class="col-md-4 col-xs-5" id="sum_saldo_inicial">0.00</div>
        </div>-->
   
        <div class="col-md-12" id="messagesout_newcompany"></div>    
            <!--<strong class="col-md-2">Mensaje Al Cliente:</strong>-->
        <div class="col-md-2">
            <select class=' select2able' name='notif_id[]'>
                <option  value='-1'>Selec.Mensaje</option>

                <?php
                foreach ($notification_format as $not) {
                    if ($not->type == 'MENSAJE') {
                        echo "<option  value='$not->id'> $not->description </option>";
                    }
                }
                ?>
            </select>
        </div>
       
                    <!--<button type="button" id="autosubmit" class="btn btn-primary pull-right" name="notification_id" value="com_masiva_garante" style="font-size: 15px"><i class="icon-ok"></i>&nbsp;NOTIFICAR OFICIAL Y GARANTES</button>-->


            <!--   <button class="btn btn-primary pull-right" id="ajaxformbtn" data-target="messagesout_newcompanys" style="font-size: 15px"><i class="icon-ok"></i>&nbsp;NOTIFICAR</button>
            <div class="col-md-12" id="messagesout_newcompanys"></div>    -->
        <?php
    }
    ?>  
    <div class="handsontable" id="example">
        <table id="table_contact"
               data-side-pagination="server"
               data-toggle="table_credits"
               data-height="<?php echo $data_height ?>"
               data-url="<?= base_url('admin/contactos/get_contact/' . $grupo_id) ?>"
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
                <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
                <tr>
                    <?php
                    if ($show_export == 1) {
                        ?>
                        <th data-field="id" data-checkbox="true" data-formatter="disabledNoElectronic">ID</th>
                        <th data-field="status_name" data-sortable="true" data-cell-style="cellStyle" data-filter-control="input">Estado</th>
                        <?php
                    } else {
                        ?>
                        <!--<th data-field="status_name" data-sortable="true" data-formatter="inputFormatterStatusName" data-filter-control="input">Estado</th>-->
                        <th data-field="id" data-visible="false" data-sortable="true">ID</th>
                        <?php
                    }
                    ?>                     
                    <th data-field="credit_type" data-formatter="inputFormatterClientDir_oficial" data-sortable="true" data-filter-control="input">Producto</th>
                    <th data-field="numero" data-filter-control="input">NUMERO</th>
                    <th data-field="nombre" data-filter-control="input">NOMBRE</th>
                    <th data-field="apellido" data-filter-control="input">APELLIDO</th>
                    <?php
                    if ($show_export == 1) {
                        ?>
                        <th data-field="numero" data-sortable="true"data-filter-control="input">NUMERO</th>
                    <th data-field="nombre" data-sortable="true" data-filter-control="input">NOMBRE</th>
                    <th data-field="apellido" data-sortable="true" data-filter-control="input">APELLIDO</th>
                   
                        <!--<th data-field="phones" data-filter-control="input">Telefonos</th>      -->                                 
                        <?php
                    } ?>   
                    
                </tr>
            </thead>
        </table>    
    </div>
    <?php
    if ($show_export == 1) {
        ?>
    </form>
    <?php
}
?>
<script>
    $(function () {
        $('input[rel="txtTooltip"]').tooltip();
    });

    $('[data-toggle="table_credits"]').bootstrapTable();
    var $table = $('#table_credits');
    function setTotalSelecteds() {
        var data = $table.bootstrapTable('getData');
//        console.log(data.toString());
        var sum_saldo_inicial = 0, num_cl_gestionados = 0;
        var cont = 0;
        $(data).each(function (e) {
            sum_saldo_inicial += parseFloat(data[cont].deuda_inicial);
            if (data[cont].credit_status_id != '1') {
                num_cl_gestionados++;
            }
            cont++;
        });

        $("#sum_saldo_inicial").html("$ <span class='pull-right'>" + sum_saldo_inicial.toFixed(2) + "</span>");
        $("#num_cl_gestionados").html("$ <span class='pull-right'>" + num_cl_gestionados.toFixed(2) + "</span>");
    }

    $table.on('load-success.bs.table', function (es) {
        setTotalSelecteds();
        $('input[rel="txtTooltip"]').tooltip();
    });
<?php
if ($show_export == 1) {
    ?>
        function moreActions(index, row) {
            var html = [];
            var id = row['credit_detail_id'];
            var openDoc = '<a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/admin__oficinacompany__open_lista_contactos__' + id + '/0/0">Realizar Gesti&oacute;n</a>';
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

    function inputFormatterClientName(index, row) {
        var client_name = row['client_name'];
        var inputDetail = "<input type='text' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + client_name + "' style='min-width:170px' class='' name='firstname' value='" + client_name + "'/> ";
        return inputDetail;
    }

    function inputFormatterClientDir(index, row) {
        var personal_address = row['personal_address'];
        var inputDetail = "<input type='text' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + personal_address + "' name='personal_address' value='" + personal_address + "'/> ";
        return inputDetail;
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