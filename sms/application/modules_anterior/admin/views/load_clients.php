<div>
    <div class="col-md-12" id="load_clients_out"></div>
    <form method="post" action="<?= base_url('admin/clients/loadfromfile') ?>" class="form-horizontal">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
        <div class="col-md-3">
            <input class="" type="file" required="" name="userfile">
        </div>
        
        <div class="col-md-3">
        <?php
             echo combobox($ml_client_category, array('label' => 'tipo', 'value' => 'id'), array('name' => 'client_category_id', 'class' => 'form-control select2able'));
         ?>
        </div>    
            
                  <div class="col-md-4">
                        <label class="radio-inline">
                            <input type="radio" name="es_pasaporte" value="0" checked="">
                                <span>CI/RUC</span>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="es_pasaporte" value="1">
                                <span>PASAPORTE</span>
                        </label>                      
                        <label class="radio-inline">
                            <input type="radio" name="es_pasaporte" value="2">
                                <span>TODOS</span>
                        </label>                      
                  </div>

        <button type="submit" data-target="load_clients_out" id="ajaxformbtn" class="btn btn-primary pull-right"><i class="icon-upload"></i></button>
    </form>
    <br class="clr"/>
    <h4 class="page-header">Arcvivo en excel</h4>
    <table class="table">
        <tr>
            <th>RUC</th> <th>NOMBRES</th> <th>APELLIDOS</th> <th>DIRECCION</th> <th>TELEFONOS</th> <th>EMAIL</th>
        </tr>
        <tr>
            <td></td> <td></td> <td></td> <td>LOJA, ...</td> <td>2577441</td>
        </tr>
    </table>
</div>