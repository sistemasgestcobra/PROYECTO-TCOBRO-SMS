<form method="post" action="<?= base_url('admin/notificationformat/notifications_update') ?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">    
<?php
if( $show_export == 1 ){
    ?>
    <?php  
}
?>  
<div class="handsontable" id="example">
    <strong class="text-primary">Historial de Notificaciones de Campo:</strong>
    <table id="table_clients_notification"
               data-side-pagination="server"
               data-toggle="table_clients_notification"
               data-height="<?php echo $data_height ?>"
               data-url="<?= base_url('cobranzas/credit/get_credit_hist_notification/'.$client_id) ?>"
               data-sort-name="id"
               data-sort-order="desc"
               data-resizable="true"     
            <?php
                if($show_export == 1){
            ?>
                    data-detail-view="true" 
                    data-detail-formatter="editTemplateNotif"      
                    data-pagination="true"             
                    data-show-refresh="true"
                    data-show-toggle="true"
                    data-show-columns="true"               
                    data-show-export="true"
                    data-filter-control="true"
                    data-select-item-name="c_id_notification[]"
                    data-id-field="id"
                    data-maintain-selected="true"
                    data-mobile-responsive="true"
            <?php
                }
            ?>                     
        >
            <thead>
                <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
            <tr>
                <th data-field="id" data-visible="false" data-checkbox="true">ID</th>
                <th data-field="com_id" data-visible="false" data-sortable="true">ID</th>
                <th data-field="type" data-visible="false" data-filter-control="input">Tipo</th>
                <th data-field="person_name" data-filter-control="input">Cliente</th>
                <th data-field="nro_pagare" data-filter-control="input">Número Pagare</th>
                <th data-field="status" data-formatter="inputFormatStatus_notif"  data-filter-control="input">Estado</th>
                <th data-field="detalle_notificacion" data-filter-control="input">Detalle</th>
		<th data-field="notificador" data-filter-control="input">Notificador</th>
		<th data-field="fecha_entrega" data-filter-control="input">Fecha Entrega</th>
		<th data-field="hora_entrega" data-filter-control="input">Hora Entrega</th>
                <th data-field="contact_id" data-filter-control="input">Contacto</th>
		<th data-field="curr_date" data-visible="false" data-filter-control="input">Fecha Notificación</th>                        
                <th data-field="curr_time" data-visible="false" data-filter-control="input">Hora Notificación</th>
            </tr>
            </thead>
        </table>    
</div>
    <?php
if( $show_export == 1 ){
    ?>

    <?php
}
    ?>
     </form>
<script>
    $(function() {
        $('input[rel="txtTooltip"]').tooltip(); 
    });
    
    $('[data-toggle="table_clients_notification"]').bootstrapTable(); 
    var $table_clients_notification = $('#table_clients_notification');
    function setTotalSelecteds(){
        var data_clients_contact = $table_clients_notification.bootstrapTable('getData');            
        var sum_saldo_inicial = 0, num_cl_gestionados = 0;
        var cont = 0;
        $(data_clients_contact).each(function(e) {
            sum_saldo_inicial += parseFloat(data_clients_contact[cont].deuda_inicial);   
            if(data_clients_contact[cont].credit_status_id != '1'){
                num_cl_gestionados++;
            }
            cont++;
        });
        $("#sum_saldo_inicial").html("$ <span class='pull-right'>"+sum_saldo_inicial.toFixed(2)+"</span>");
        $("#num_cl_gestionados").html("$ <span class='pull-right'>"+num_cl_gestionados.toFixed(2)+"</span>");        
    }  
    $table_clients_notification.on('load-success.bs.table', function (es) {
        setTotalSelecteds();  
        $('input[rel="txtTooltip"]').tooltip();        
    });
    <?php
    if( $show_export == 1 ){
      ?>
        function editTemplateNotif(index, row) {
        var html = [];
        var id = row['com_id'];
        var verMensaje = '<a id="call-php" class="" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/admin__notificationformat__open_view__'+id+'/0/0">Ver Mensaje</a>';
        html.push(verMensaje);
		var verMensaje2 = '<a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/admin__notificationformat__open_view2__'+id+'/0/0">Gestionar Notificacion</a>';
        html.push(verMensaje2);
        return html.join('');
    }   
      <?php          
    }
    ?>
    function inputFormatStatus_notif(index, row) {
           var status = row['status'];
           if(status=='0'){
               status='Entregada';
           }else{
               status='No entregada'
           }
           var inputDetail = "<input type='text' disabled rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+status+"' style='min-width:170px' class='' name='status' value='"+status+"'/> ";
           return inputDetail;
       }
       function inputFormatterClientDir(index, row) {           
           var personal_address = row['personal_address'];
           var inputDetail = "<input type='text'   rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+personal_address+"' name='personal_address' value='"+personal_address+"'/> ";
           return inputDetail;
       }
       
       function inputPersonId(index, row){           
           var person_id = row['person_id'];
           var credit_detail_id = row['credit_detail_id'];
           var client_name= row['client_name'];
           var deuda_inicial= row['deuda_inicial'];
           var inputPerson = "<input type='hidden' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+person_id+"' name='person_id[]' value='"+person_id+"'/> ";
           var credit_detail_id = "<input type='hidden' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+credit_detail_id+"' name='credit_detail_id[]' value='"+credit_detail_id+"'/> ";
           var inputClientName =  "<input type='hidden' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+client_name+"' name='client_name_ofic[]' value='"+client_name+"'/> ";
           var inputDetail = "<input type='text' disabled   rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+deuda_inicial+"' name='deuda_inicial' value='"+deuda_inicial+"'/> ";
           return inputPerson+credit_detail_id+inputClientName+inputDetail;
       }
       function inputFormatterStatusName(index, row) {
           var color = row['color'];
           var background = row['background'];           
           var status_name = row['status_name'];
           var inputDetail = "<input style='background:"+background+"; color:"+color+"; width:100px ' name='status_name' value='"+status_name+"'/> ";
           return inputDetail;
       } 
        function cellStyle(value, row, index) {
            var color = row['color'];
            var background = row['background'];
                return {
                    css: {
                        "background": background,
                        "color": color,
                    }
                };
        }
</script>