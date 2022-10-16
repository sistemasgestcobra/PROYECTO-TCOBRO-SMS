<form method="post" action="<?= base_url('admin/oficinacompany_1/save')?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
        
    <div id="toolbar">
         <!--<a id="call-php" class="btn btn-primary pull-left" href="#" data-target="messagesout" php-function="modal/admin__empresa__open_ml_empresa/0/0">Nueva Empresa</a>-->
        <button type="button" id="button_insert_oficina" class="btn btn-default">Nueva</button>
        <button type="button" id="btn_method_table" data-method="remove" data-table-name="table_bases" class="btn btn-default ">Remover</button>
        <button type="button" id="btn_method_table" data-method="refresh" data-table-name="table_bases"  class="btn btn-default ">Reestablecer</button>
        <button class="btn btn-success" type="submit" id="autosubmit">Guardar Cambios</button>   
        </div>
        <!--data-detail-formatter="detailFormatter"-->
        <table id="table_bases"
               data-side-pagination="server"
               data-pagination="true"                  
               data-toggle="table"
               data-height="460"
               data-detail-view="true"
               data-detail-formatter="editCompany"               
                    
               data-url="<?= base_url('admin/oficinacompany/get_oficina_company_report') ?>"
               data-sort-name="id"
               data-sort-order="desc"
               data-show-refresh="true"
               data-show-toggle="true"
               data-show-columns="true"                 
               data-show-export="true"
               data-filter-control="true"
               data-select-item-name="check_oficina_id[]"
               data-id-field="id"
               data-maintain-selected="true"               
        >
            <thead>
                <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
            <tr>
                <th data-field="ids" data-checkbox="true"></th>
                <th data-field="id" data-visible="false" data-filter-control="input">ID</th>
                <th data-field="nombre" data-sortable="true" data-formatter="formatName"  data-filter-control="input">BASE</th>
                <th data-field="observaciones" data-sortable="true" data-formatter="formatDireccion"  data-filter-control="input">OBSERVACIONES</th>
                <!--<th data-field="direccion" data-formatter="formatDireccion" data-filter-control="input">Direccion</th>-->
                <!--<th data-field="jefe_ajencia" data-sortable="true" data-formatter="formatJefeAgencia" data-filter-control="input">Jefe Agencia</th>-->
            </tr>
            </thead>
        </table>
</form>
<script>
   var $table_oficina = $('#table_bases'),
        $button_oficina = $('#button_insert_oficina');
    $(function () {
        $button_oficina.click(function () {
            var randomId = 100 + ~~(Math.random() * 100);
            $table_oficina.bootstrapTable('prepend', {
                index: 1,
                row: {
//                    id: randomId,
//                    name: 'Item ' ,
//                    price: '$'
                }
            });
        });
    }); 
    
    function editCompany( index, row ) {
        var html = [];
        var id1 = row['id'];
        var id = 4;
        var openDoc = '<a id="call-php" class="" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/admin__oficinacompany__open_lista_contactos__'+id+'/0/0">Ver Contactos</a>';
        html.push(openDoc);
        return html.join('');        
    }
    
    function cellStyle(value, row, index) {
        if( row['company_status_id'] == '1' ){
            return {
                //classes: classes[index / 2]
                css: {
                    "background": "#4eb305",
                    "color": "#ffffff",
                }
            };
        }  else if( row['company_status_id'] == '2' ){
            return {
                //classes: classes[index / 2]
                css: {
                    "background": "#cd0a0a",
                    "color": "#fef1ec",
                }
            };
        }
        return {};
    }
    
    
    function formatName(index, row) {
       var name = row['nombre'];
       var id = row['id'];
       var inputId = "<input type='hidden' class='' nombre='id[]' value='"+id+"'/> ";
       var inputDetail = "<input style='min-width:200px' class='' nombre='nombre[]' value='"+name+"'/> ";
       return inputDetail+inputId;
    }
    
    function formatDireccion(index, row) {
       var direccion = row['observaciones'];
       var inputDetail = "<input style='min-width:200px' class='' name='observaciones[]' value='"+direccion+"'/> ";
       return inputDetail;
    }
    
    
</script>