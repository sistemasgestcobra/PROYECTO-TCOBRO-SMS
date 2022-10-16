    <div class="col-md-12">
        <a id="call-php" class="btn btn-primary pull-left" href="#" data-target="messagesout" php-function="<?= base_url()?>modal/admin__setup__open_ml_setup__0/0/0">Nueva Variable</a>
        <div id="toolbar">
        </div> 
        
        <!--data-detail-formatter="detailFormatter"-->
        <table id="table"
               data-toggle="table"
               data-height="460"
               data-pagination="true"
               data-side-pagination="server"
               data-detail-view="true"
               data-detail-formatter="editSettings"
               data-url="<?= base_url('admin/setup/get_setup_report') ?>"
               data-sort-name="id"
               data-sort-order="asc"
               data-show-refresh="true"
               data-show-toggle="true"
               data-show-columns="true"                 
               data-show-export="true"
               data-pagination="true"
               data-filter-control="true"
        >
            <thead>
                <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
            <tr>
                <th data-field="id" data-filter-control="input">ID</th>
                <th data-field="variable" data-filter-control="input">Variable</th>
                <th data-field="valor" data-filter-control="input">Valor</th>
                <th data-field="detalle" >Detalle</th>
            </tr>
            </thead>
        </table>
    </div>

<script>
    function editSettings(index, row) {
        var html = [];
        var id = row['id'];
        var openDoc = '<a id="call-php" class="" href="#" data-target="messagesout" php-function="<?= base_url()?>modal/admin__settings__open_ml_setup__'+id+'/0/0">Modificar Variable</a>';
                
        html.push(openDoc);

        return html.join('');        
    }
</script>