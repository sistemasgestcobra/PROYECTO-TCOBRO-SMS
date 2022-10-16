
<div class="handsontable" id="example">
    <strong class="">Contactos:</strong>
    <button type="button" id="btn_method_table" data-method="prepend" data-table-name="table_contact"  data-function="getRowNewRef" class="btn btn-default btn-xs">Nuevo</button>
    <button type="button" id="btn_method_table" data-method="remove" data-table-name="table_contact" class="btn btn-default btn-xs">Remover</button>
    <button type="button" id="btn_method_table" data-method="refresh" data-table-name="table_contact"  class="btn btn-default btn-xs">Reestablecer</button>

    <table id="table_contact"
               data-side-pagination="server"
               data-pagination="false"
               data-toggle="table_contact"
               data-height="<?php echo $data_height ?>"                    
               data-detail-formatter="editCompany"               
               data-url="<?= base_url('cobranzas/referencias/get_referencias_client_contact/'.$client_id) ?>"
               
               
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
                    data-resizable="true"    
                <?php
                }
               ?>
                       
                    data-select-item-name="chk_table_contact[]"
                    data-id-field="id"
                    data-maintain-selected="true"
        >   
            <thead>
                <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
            <tr>
                <th data-field="id" data-checkbox="true"></th>
                <th data-field="contact_name" data-sortable='true' data-formatter="formatContactType" data-filter-control="input">Tipo</th>
                <th data-field="firstname" data-sortable='true' data-formatter="formatName" >Nombres</th>
                <th data-field="contact_value" data-formatter="inputFormatterContactValue" data-filter-control="input">Telfono</th>
            </tr>
            </thead>
        </table>    
</div>

<script>
    $('[data-toggle="table_contact"]').bootstrapTable();
    
    function editCompany( index, row ) {
        var html = [];
        var id = row['id'];
        var openDoc = '<a id="call-php" class="btn btn-success btn-xs" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/cobranzas__credit__open_credit_detail__'+id+'/0/0">Actualizar Datos</a>';
        
        var notificationDocExtraJud = '<a id="call-php" class="btn btn-info btn-xs" href="<?= base_url() ?>admin/notificationformat/notification_print/1/'+id+'">Notificacion extra-judicial</a>';
        var notificationDocJud = '<a id="call-php" class="btn btn-warning btn-xs"  href="<?= base_url() ?>admin/notificationformat/notification_print/2/'+id+'">Notificacion judicial</a>';
        html.push( openDoc + notificationDocExtraJud + notificationDocJud );
        return html.join('');        
    }


       function inputFormatterContactValue(index, row) {
           var id = row['contact_id'];
           var contact_value = row['contact_value'];
           var inputId = "<input type='hidden' name='ids_contact[]' value='"+id+"'/> ";
           var inputDetail = "<input type='text' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+contact_value+"' style='width:100px ' name='contact_value[]' value='"+contact_value+"'/> ";
           return inputId+inputDetail;
       }
       
      
       
        function formatContactType(index, row) {
           var reference_type_id = row['contact_type_id'];
           var selected = '';
           var role = "<select class=' select2able'  name='contact_type_id[]'>";
        <?php
        $contact_type = (new \gestcobra\contact_type_model())->find();                       
        foreach ($contact_type as $value) {
            ?>
                    if(reference_type_id == <?= $value->id ?>){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    role += "<option "+selected+" value='<?= $value->id ?>'><?= $value->contact_name ?></option>";
            <?php
        }
           ?>
           role += "</select>";                
           return role;
       } 
       
       function formatName(index, row) {
           var person_id = row['person_id'];
           var selected = '';
           var role = "<select class=' select2able' name='person_id[]'>";
                      
        <?php
        $person = (new \gestcobra\person_model())
                    ->where_in('id',$persons_credit)
                    ->find();                       
        
        foreach ($person as $value) {
            ?>
                    if(person_id == <?= $value->id ?>){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    role += "<option "+selected+" value='<?= $value->id ?>'><?= $value->firstname ?></option>";
            <?php
        }
           ?>
           role += "<select>";                
           return role;
       } 
       
    function getRowNewRef() {
        var startId = ~~(Math.random() * 100),
                rows = [];
            rows.push({
                id: startId,
                firstname: '',
                lastname: '',
                personal_phone: '',
                personal_mobile: '',
                personal_address: '',
            });
        return rows;
    }       
                  
</script>