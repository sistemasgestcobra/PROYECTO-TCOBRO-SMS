<form method="post" action="<?= base_url('admin/oficinacompany/save')?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
        
    <div id="toolbar">        
        <button type="button" id="button_insert_oficina" class="btn btn-default">Nueva Oficina</button>
        <button type="button" id="btn_method_table" data-method="remove" data-table-name="table_oficinas" class="btn btn-default ">Remover</button>
        <button type="button" id="btn_method_table" data-method="refresh" data-table-name="table_oficinas"  class="btn btn-default ">Reestablecer</button>
        <button class="btn btn-success" type="submit" id="autosubmit">Guardar Cambios</button>   
         </div>
        
        <table id="table_oficinas"
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
                <th data-field="name" data-sortable="true" data-formatter="formatName"  data-filter-control="input">Oficina</th>
                <th data-field="direccion" data-formatter="formatDireccion" data-filter-control="input">Direccion</th>
            </tr>
            </thead>
        </table>
</form>
<script>
   var $table_oficina = $('#table_oficinas'),
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
        var id = row['id'];
        var openDoc = '<a id="call-php" class="" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/admin__empresa__open_ml_empresa__'+id+'/0/0">Modificar Empresa</a>';
        var switchCompany = '<a id="call-php" class="" href="#" data-target="messagesout" php-function="<?= base_url() ?>admin/empresa/switch_company/'+id+'">Establecer Sesion</a>';
        html.push(openDoc+" - "+switchCompany);
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
       var name = row['name'];
       var id = row['id'];
       var inputId = "<input type='hidden' class='' name='id[]' value='"+id+"'/> ";
       var inputDetail = "<input style='min-width:200px' class='' name='name[]' value='"+name+"'/> ";
       return inputDetail+inputId;
    }
    function formatDireccion(index, row) {
       var direccion = row['direccion'];
       
       var inputDetail = "<input style='min-width:200px' class='' name='direccion[]' value='"+direccion+"'/> ";
       return inputDetail;
    }
    function formatJefeAgencia(index, row) {
       var jefe_ajencia = row['jefe_ajencia'];
       
       var inputDetail = "<input style='min-width:200px' class='' name='jefe_ajencia[]' value='"+jefe_ajencia+"'/> ";
       return inputDetail;
    }
</script>