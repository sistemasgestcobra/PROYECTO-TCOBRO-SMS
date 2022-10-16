<?php
$grupo = $id;
?>
<form method="post" action="<?= base_url('msjs/contactos/save') ?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <input type="hidden" name="lote" value="1">
    <input type='hidden' name='idg' value='<?= $id ?>'/>
    <div class="handsontable" id="example">
        <strong class="">Contactos:</strong>
        <!--<button type="button" id="button_insert_contact" class="btn btn-default">Nuevo </button>-->
        <button type="button" id="btn_method_table" data-method="prepend"  data-table-name="table_contact_grupo"  data-function="getRowNewRef1" class="btn btn-default btn-xs">Nuevo</button>
        <button type="button" id="btn_method_table" data-method="remove" data-table-name="table_contact_grupo" class="btn btn-default btn-xs">Remover</button>
        <button type="button" id="btn_method_table" data-method="refresh" data-table-name="table_contact_grupo"  class="btn btn-default btn-xs">Reestablecer</button>
        <button class="btn btn-default btn-xs" type="submit" id="autosubmit" data-table-name="table_contact_grupo">Guardar Cambios</button>  
        <!--    <button type="button" data-table-name="table_contact" onclick="rowStyle()"> No Contesta</button>-->
        <table id="table_contact_grupo"
               data-side-pagination="server"

               data-toggle="table_contact_grupo"
               data-url="<?= base_url('msjs/contactos/get_contactos/' . $id) ?>"
               data-sort-name="id"
               data-sort-order="desc"          
               <?php
//                if( $show_export == 1 ){
               ?>
               data-detail-view="true"
               data-pagination="true"
               data-show-refresh="true"
               data-show-toggle="true"

               data-show-columns="true"                 
               data-show-export="true"
               data-filter-control="true"  
               data-mobile-responsive="true" 
               data-resizable="true"    
               <?php
//                }
               ?>   
               data-select-item-name="chk_table_contact[]"
               data-id-field="id"
               data-maintain-selected="true"

               >   
            <thead>
                <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
                <tr>
                    <th data-field="ids" data-checkbox="true"></th>
                    <th data-field="id" data-visible="false" >Id</th>
                    <th data-field="id_grupo" data-visible="false" >grupo</th>
                    <th data-field="numero" data-sortable='true' data-formatter="formatNumero" data-filter-control="input"  >NUMERO</th>
                    <th data-field="nombre"  data-sortable='true' data-formatter="formatNombre" data-filter-control="input">NOMBRE</th>
                    <th data-field="variable1" data-sortable='true' data-formatter="formatv1" data-filter-control="input" >VARIABLE 1</th>
                    <th data-field="variable2" data-sortable='true' data-formatter="formatv2" data-filter-control="input" >VARIABLE 2</th>
                    <th data-field="variable3" data-sortable='true' data-formatter="formatv3" data-filter-control="input" >VARIABLE 3</th>
                    <th data-field="variable4" data-sortable='true' data-formatter="formatv4" data-filter-control="input" >VARIABLE 4</th>
                </tr>
            </thead>
        </table>    
    </div>
</form>



<script>
    $('[data-toggle="table_contact_grupo"]').bootstrapTable();



    function inputFormatterContactValue(index, row) {
        var id = row['contact_id'];
        var contact_value = row['contact_value'];
        var inputId = "<input type='hidden' name='ids_contact[]' value='" + id + "'/> ";
        var inputDetail = "<input type='text' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='" + contact_value + "' style='width:100px ' name='contact_value[]' value='" + contact_value + "'/> ";
        return inputId + inputDetail;
    }








    function getRowNewRef1() {
        var startId = ~~(Math.random() * 100),
                rows = [];
        rows.push({
            id: startId,
            nombre: '',
            variable1: '',
            variable2: '',
            variable3: '',
            variable4: '',
        });
        return rows;
    }


    function formatNumero(index, row) {
        var name = row['numero'];
        var id = row['id'];
        var inputId = "<input type='hidden' class='' name='id[]' value='" + id + "'/> ";
        var inputDetail = "<input style='min-width:200px' class='' name='numero[]' value='" + name + "'/> ";
        return inputDetail + inputId;
    }
    function formatNombre(index, row) {
        var name = row['nombre'];
        var inputDetail = "<input style='min-width:200px' class='' name='nombre[]' value='" + name + "'/> ";
        return inputDetail;
    }

    function formatApellido(index, row) {
        var name = row['apellido'];
        var inputDetail = "<input style='min-width:200px' class='' name='apellido[]' value='" + name + "'/> ";
        return inputDetail;
    }

    function formatv1(index, row) {
        var name = row['variable1'];
        var inputDetail = "<input style='min-width:200px' class='' name='variable1[]' value='" + name + "'/> ";
        return inputDetail;
    }
    function formatv2(index, row) {
        var name = row['variable2'];
        var inputDetail = "<input style='min-width:200px' class='' name='variable2[]' value='" + name + "'/> ";
        return inputDetail;
    }
    function formatv3(index, row) {
        var name = row['variable3'];
        var inputDetail = "<input style='min-width:200px' class='' name='variable3[]' value='" + name + "'/> ";
        return inputDetail;
    }
    function formatv4(index, row) {
        var name = row['variable4'];
        var inputDetail = "<input style='min-width:200px' class='' name='variable4[]' value='" + name + "'/> ";
        return inputDetail;
    }


</script>