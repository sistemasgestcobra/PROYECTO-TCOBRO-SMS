<form method="post" action="<?= base_url('admin/creditstatus/save')?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <input type="hidden" name="lote" value="1">
        <div id="toolbar">
            <button type="button" id="button_credit_status" class="btn btn-default">Nuevo</button>
            <button type="button" id="btn_method_table" data-method="remove" data-table-name="table_credit_status" class="btn btn-default ">Remover</button>
            <button type="button" id="btn_method_table" data-method="refresh" data-table-name="table_credit_status"  class="btn btn-default ">Reestablecer</button>
            <button class="btn btn-success" type="submit" id="autosubmit">Guardar Cambios</button>            
        </div>      
        <table id="table_credit_status"
               
               data-side-pagination="server"                  
               data-toggle="table"
               data-height="460"
               data-detail-view="true"     
               data-url="<?= base_url('admin/creditstatus/get_report') ?>"
               data-sort-name="id"
               data-sort-order="asc"
               data-show-refresh="true"
               data-show-toggle="true"
               data-show-columns="true"                 
               data-show-export="true"
               data-filter-control="true"
        >
        <thead>
            <tr>
                <th data-field="ids" data-checkbox="true"></th>
                <th data-field="id" data-visible="false" data-sortable="true">Id</th>
                <th data-field="status_name" data-formatter="inputFormatterStatus">Estado</th>
                <th data-field="color" data-formatter="inputFormatterColor">Color letra</th>
                <th data-field="background" data-formatter="inputFormatterBackground" >Color de fondo</th>
                <th data-field="nombre_comercial"  data-visible="true" >Compañía</th>
            </tr>
        </thead>
        </table>
</form>
<script>
      
    $('[data-toggle="table"]').bootstrapTable();
    var table_credit_status = $('#table_credit_status'),
        $credit_status = $('#button_credit_status');
    $(function () {
        $credit_status.click(function () {
            var randomId = 100 + ~~(Math.random() * 100);
            table_credit_status.bootstrapTable('prepend', {
                index: 1,
                row: {
                }
            });
        });
    });    
    
    function inputFormatterStatus(index, row) {
       var id = row['id'];
       var status_name = row['status_name'];
       var inputId = "<input type='hidden' class='' name='id[]' value='"+id+"'/> ";           
       var inputDescription = "<input required='' style='min-width:200px' class='' name='status_name[]' value='"+status_name+"'/> ";
       return inputId+inputDescription;
    }
    
    function inputFormatterColor(index, row) {
       var description = row['color'];
       var inputDescription = "<input required='' style='min-width:200px' class='' name='color[]' value='"+description+"'/> ";
       return inputDescription;
    }
    
    function inputFormatterBackground(index, row) {
        var description = row['background'];
        var inputDescription = "<input required='' style='min-width:200px' class='' name='background[]' value='"+description+"'/> ";
        return inputDescription;
    }
                 
</script>