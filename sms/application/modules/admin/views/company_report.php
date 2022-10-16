
         <a id="call-php" class="btn btn-primary pull-left" href="#" data-target="messagesout" php-function="modal/admin__empresa__open_ml_empresa/0/0">Nueva Empresa</a>

        <table id="table"
               data-side-pagination="server"
               data-pagination="true"                  
               data-toggle="table"
               data-height="460"
               data-detail-view="true"     
               data-detail-formatter="editCompany"               
               data-url="<?= base_url('admin/empresa/get_company_report') ?>"
               data-sort-name="id"
               data-sort-order="desc"
               data-show-refresh="true"
               data-show-toggle="true"
               data-show-columns="true"                 
               data-show-export="true"
               data-filter-control="true"
        >
            <thead>
                <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
            <tr>
                <th data-field="id" data-filter-control="input">ID</th>
                <th data-field="nombre_comercial" data-sortable="true" data-filter-control="input">Nombre</th>
                <th data-field="email" data-filter-control="input">E-mail</th>
                <th data-field="telefono" data-filter-control="input">Telefono</th>
                <th data-field="direccion" data-filter-control="input">Direccion</th>
                <th data-field="company_status" data-cell-style="cellStyle" data-filter-control="select">Estado</th>
            </tr>
            </thead>
        </table>

<script>
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
                css: {
                    "background": "#4eb305",
                    "color": "#ffffff",
                }
            };
        }  else if( row['company_status_id'] == '2' ){
            return {
                css: {
                    "background": "#cd0a0a",
                    "color": "#fef1ec",
                }
            };
        }
        return {};
    }       
</script>