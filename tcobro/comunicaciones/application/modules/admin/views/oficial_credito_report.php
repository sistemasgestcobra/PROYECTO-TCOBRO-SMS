<form method="post" action="<?= base_url('admin/oficialcredito/save')?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
        <div id="toolbar">
            <button type="button" id="button_insert" class="btn btn-default">Nuevo Usuario</button>
            <!--<button type="button" id="btn_method_table" data-method="remove" data-table-name="table_oficiales" class="btn btn-default ">Remover</button>-->
            <button type="button" id="btn_method_table" data-method="refresh" data-table-name="table_oficiales"  class="btn btn-default ">Reestablecer</button>
            <button class="btn btn-success" type="submit" id="autosubmit">Guardar Cambios</button>            
        </div>  
        <!--data-detail-formatter="detailFormatter"-->
        <!--<div class="handsontable" id="example">-->
        <table id="table_oficiales"
               
               data-side-pagination="server"
               data-pagination="true"
               data-toggle="table"
               data-height="460"
               data-detail-view="true"
               data-url="<?= base_url('admin/oficialcredito/get_oficial_credito_report') ?>"
               data-sort-name="id"
               data-sort-order="desc"
             
               data-detail-view="true"                      
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
                    <th data-field="id" data-visible="false" data-sortable="true">ID</th>
                    <th data-field="cedula" data-formatter="formatCedula" data-sortable="true" data-filter-control="input">Cédula</th>
                    <th data-field="firstname" data-formatter="formatFirstname" data-sortable="true" data-filter-control="input">Nombres</th>
                    <th data-field="email"  data-formatter="formatEmail" data-filter-control="input">Usuario / E-Mail</th>
                    <th data-field="role_name" data-formatter="formatRole" data-filter-control="input">Rol</th>
                    <!--<th data-field="status_ac" data-formatter="formatRole" data-filter-control="input">Rol</th>-->
                    <th data-field="oficina_name" data-formatter="formatOficina" data-filter-control="input">Oficina</th>
                    <th data-field="status_ac" data-formatter="formatStatus" data-filter-control="input">Estado</th>
                </tr>
            </thead>
        </table>    
        <!--</div>-->  
</form>

<script>
    var $table = $('#table_oficiales'),
        $button = $('#button_insert');
    $(function () {
        $button.click(function () {
            var randomId = 100 + ~~(Math.random() * 100);
            $table.bootstrapTable('prepend', {
                index: 1,
                row: {
//                    id: randomId,
//                    name: 'Item ' ,
//                    price: '$'
                }
            });
        });
    });    
    
    function moreActionsOficial( index, row ) {
        var html = [];
        var id = row['id'];
        var cambiarClave = '<a id="call-php" class="" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/admin__oficialcredito__open_view__'+id+'/0/0">Cambiar Clave</a>';
        var cambiarPrivilegios = '<a id="call-php" class="" href="#" data-target="messagesout" php-function="<?= base_url() ?>modal/admin__oficialcredito__open_view_privileges__'+id+'/0/0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cambiar Privilegios</a>';
        html.push(cambiarClave);
        html.push(cambiarPrivilegios);
        return html.join('');        
    }
    
    function formatCedula(index, row) {
           var firstname = row['cedula'];
           var inputDetail = "<input style='min-width:200px' class='' name='cedula[]' value='"+firstname+"'/> ";
           return inputDetail;
       }
        function formatFirstname(index, row) {
           var firstname = row['firstname'];
           var id = row['id'];
           var inputId = "<input type='hidden' class='' name='id[]' value='"+id+"'/> ";
           var inputDetail = "<input style='min-width:200px' class='' name='firstname[]' value='"+firstname+"'/> ";
           return inputDetail+inputId;
       }
       function formatLastname(index, row) {
           var lastname = row['lastname'];
           var inputDetail = "<input style='min-width:200px' class='' name='lastname[]' value='"+lastname+"'/> ";
           return inputDetail;
       }
       function formatEmail(index, row) {
           var email = row['email'];
           var inputDetail = "<input style='min-width:200px' class='' name='email[]' value='"+email+"'/> ";
           return inputDetail;
       }
       
       function formatRole(index, row) {
           var role_id = row['role_id'];
           var selected = '';
           var role = "<select class=' select2able' name='role_id[]'>";
           <?php
        $role = (new \gestcobra\role_model())->find();                       
        foreach ($role as $value) {
            ?>
                    if(role_id == <?= $value->id ?>){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    role += "<option "+selected+" value='<?= $value->id ?>'><?= $value->role_name ?></option>";
            <?php
        }
           ?>
           role += "<select>";                
           return role;
       }



        function formatOficina(index, row) {
           var oficina_company_id = row['oficina_company_id'];
           var selected = '';
           var role = "<select class='select2able' name='oficina_company_id[]'>";
           <?php
        $oficial = (new gestcobra\oficina_company_model)->where('company_id', $this->user->company_id)->find();                       
        foreach ($oficial as $value) {
            ?>
                    if(oficina_company_id == <?= $value->id ?>){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    role += "<option "+selected+" value='<?= $value->id ?>'><?= $value->name ?></option>";
            <?php
        }
           ?>
           role += "<select>";                
           return role;
       }   
       
       function formatStatus(index, row) {
          
           var status_ac = row['status_ac'];
           var selected = '';
           var status = "<select class='select2able' name='status_ac[]'>";
           
           <?php
           
           $estado = array(
    "Activo",
    "Inactivo"
);
      //  $role = (new \gestcobra\role_model())->find();                       
        foreach ($estado as $value) {
            ?>
                     if (status_ac == "<?= $value ?>") {
//                    if(role_id == <?= $value->id ?>){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
//                    role += "<option "+selected+" value='<?= $value->id ?>'><?= $value->role_name ?></option>";
                    status += "<option " + selected + " value='<?= $value ?>'><?= $value ?></option>";
            <?php
        }
           ?>
           status += "<select>";                
           return status;
       }

</script>