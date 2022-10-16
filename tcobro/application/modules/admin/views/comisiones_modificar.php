<form method="post" action="<?= base_url('admin/comision/save_comi') ?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <input type="hidden" name="lote" value="1">
    <div id="toolbar">
        <button type="button" id="button_insert_comi" class="btn btn-default">Nuevo</button>
        <button type="button" id="btn_method_table" data-method="remove" data-table-name="table_comi" class="btn btn-default ">Remover</button>
        <button type="button" id="btn_method_table" data-method="refresh" data-table-name="table_comi"  class="btn btn-default ">Reestablecer</button>
        <button class="btn btn-success" type="submit" id="autosubmit">Guardar Cambios</button>            
    </div>      
    <table id="table_comi"
           data-pagination="true"
           data-side-pagination="server"                  
           data-toggle="table"
           data-height="460"
           data-detail-view="true"     
                           
           data-url="<?= base_url('admin/comision/get_report') ?>"
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
                <th data-field="nombre_comision" data-formatter="formatName1" >Nombre</th>
                <th data-field="valor_comision" data-formatter="formatDireccion1" >Costo</th>                
            </tr>
        </thead>
    </table>
</form>
<script>
    $('[data-toggle="table"]').bootstrapTable();

    var $table_notif = $('#table_comi'),
            $button_notif = $('#button_insert_comi');
    $(function () {
        $button_notif.click(function () {
            var randomId = 100 + ~~(Math.random() * 100);
            $table_comi.bootstrapTable('prepend', {
                index: 1,
                row: {
                }
            });
        });
    });

  
function inputFormatterCosto(index, row) {
        var id = row['id'];
        var description = row['valor_comision'];
        var inputId = "<input type='hidden' class='' name='id[]' value='" + id + "'/> ";
        var inputDescription = "<input required='' style='min-width:200px' class='' name='description[]' value='" + description + "'/> ";
        return inputId + inputDescription;
    }


    function inputFormatterFormato(index, row) {
        var format = row['format'];
        var inputDescription = "<textarea id='summernote_contract' class='form-control' name='template_data[]' style='height: 250px'>" + format + "</textarea>";
        return inputDescription;
    }
          
function formatName1(index, row) {
       var name = row['nombre_comision'];
       var id = row['id'];
       var inputId = "<input type='hidden' class='' name='id[]' value='"+id+"'/> ";
       var inputDetail = "<input style='min-width:200px' class='' name='name[]' value='"+name+"'/> ";
       return inputDetail+inputId;
    }
    function formatDireccion1(index, row) {
       var direccion = row['valor_comision'];
       var inputDetail = "<input style='min-width:200px' class='' name='direccion[]' value='"+direccion+"'/> ";
       return inputDetail;
    }

</script>