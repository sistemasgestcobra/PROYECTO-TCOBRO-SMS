<form method="post" action="<?= base_url('admin/notificationformat/save') ?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <input type="hidden" name="lote" value="1">
    <div id="toolbar">
        <button type="button" id="button_insert_notif" class="btn btn-default">Nuevo</button>
        <button type="button" id="btn_method_table" data-method="remove" data-table-name="table_notif" class="btn btn-default ">Remover</button>
        <button type="button" id="btn_method_table" data-method="refresh" data-table-name="table_notif"  class="btn btn-default ">Reestablecer</button>
        <button class="btn btn-success" type="submit" id="autosubmit">Guardar Cambios</button>            
    </div>      
    <table id="table_notif"
           data-pagination="true"
           data-side-pagination="server"                  
           data-toggle="table"
           data-height="460"
           data-detail-view="true"     
           data-detail-formatter="editTemplate"                   
           data-url="<?= base_url('admin/notificationformat/get_report') ?>"
           data-sort-name="id"
           data-sort-order="asc"
           data-show-refresh="true"
           data-show-toggle="true"
           data-show-columns="true"                 
           data-show-export="true"
           data-filter-control="true"
           >
        <thead>
            <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
            <tr>
                <th data-field="ids" data-checkbox="true"></th>
                <th data-field="id" data-visible="false" data-sortable="true">Id</th>
                <th data-field="description" data-formatter="inputFormatterDescription" >Descripcion</th>
                <th data-field="type" data-formatter="inputFormatterType" >Type</th>
                <th data-field="format" data-formatter="inputFormatterFormato" data-visible="false" >Formato</th>
                
            </tr>
        </thead>
    </table>
</form>
<script>
    $('[data-toggle="table"]').bootstrapTable();
    var table_notif = $('#table_notif'),
        $notif = $('#button_insert_notif');
    $(function () {
        $notif.click(function () {
            var randomId = 100 + ~~(Math.random() * 100);
            table_notif.bootstrapTable('prepend', {
                index: 1,
                row: {
                }
            });
        });
    });  


    function editTemplate(index, row) {
        var html = [];
        var id = row['id'];
        var type = row['type'];
        var openDoc = '<a class="" href="<?= base_url('admin/notificationformat/edit_template') ?>/' + id + '">Modificar</a>';
        html.push(openDoc);
        return html.join('');
    }

    function inputFormatterDescription(index, row) {
        var id = row['id'];
        var description = row['description'];
        var inputId = "<input type='hidden' class='' name='id[]' value='" + id + "'/> ";
        var inputDescription = "<input required='' style='min-width:200px' class='' name='description[]' value='" + description + "'/> ";
        return inputId + inputDescription;
    }

    function inputFormatterType(index, row) {
        var type = row['type'];
        var selected = '';
        var role = "<select class=' select2able' name='type[]'>";
<?php
$notification = array(
    "NOTIFICACION",
    "MENSAJE"
);
foreach ($notification as $value) {
    ?>
            if (type == "<?= $value ?>") {
                selected = 'selected';
            } else {
                selected = '';
            }
            role += "<option " + selected + " value='<?= $value ?>'><?= $value ?></option>";
    <?php
}
?>
        role += "<select>";
        return role;
    }

    function inputFormatterFormato(index, row) {
        var format = row['format'];
        var inputDescription = "<textarea id='summernote_contract' class='form-control' name='template_data[]' style='height: 250px'>" + format + "</textarea>";
        return inputDescription;
    }

//        $(document).on("click", "#autosubmit_edit_template", function(e) {
//            $("#summernote_contract2").val( $('#summernote_contract').code() );
//        });          
</script>