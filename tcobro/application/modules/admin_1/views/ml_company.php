<?php // Change the css classes to suit your needs 
    $ml_comunication_model = new \gestcobra\company_model($id);
    $res = array( 'company_id' => $ml_comunication_model->id );

    $root_data_disabled = ''; 
    if( $this->user->root == 0 ){
        $root_data_disabled = 'disabled';
    }
    
    $btn_label = 'Registrar Entidad';
    if($ml_comunication_model->id > 0){
        $btn_label = 'Actualizar Informacion';    
    }
?>   

<form method="post" action="<?= base_url('company.jsp/create')?>" class="form-horizontal">
    <div class="col-md-12" id="messagesout_newcompany"></div>
    
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
    <input type='hidden' name='id' value='<?= $ml_comunication_model->id ?>'/>

                <div class="form-group">
                    <div class="col-md-3">Nombre Entidad *</div>
                    <div class="col-md-9"><input class="form-control" id="nombre_comercial" type="text" name="nombre_comercial" maxlength="128" value="<?= $ml_comunication_model->nombre_comercial ?>"  placeholder="Nombre Comercial" /> </div>
                </div>

              <div class="form-group">
                  <div class="col-md-3">Direccion *</div>
                    <div class="col-md-9"><input class="form-control" id="direccion" type="text" name="direccion" maxlength="128" value="<?= $ml_comunication_model->direccion ?>"  placeholder="Direccion" /> </div>
                </div>

              <div class="form-group">
                  <div class="col-md-3">Telefono *</div>
                   <div class="col-md-9"> <input class="form-control" id="telefono" type="text" name="telefono" maxlength="128" value="<?= $ml_comunication_model->telefono ?>"  placeholder="Telefono" /> </div>
                </div>

                <div class="form-group">
                    <div class="col-md-3">E-mail *</div>
                    <div class="col-md-9"> <input class="form-control" id="email" type="text" name="email" maxlength="500" value="<?= $ml_comunication_model->email ?>"  placeholder="Correo Electr&oacute;nico"/> </div>
                </div>                      

                <div class="form-group">
                    <label class="col-md-3" for="logo">Logo</label>
                    <div class="col-md-9">
                        <input type="file" name="logo"/>
                    </div>            
                </div>               

          <div class="form-group">
              <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-9"> 
                        <button class="btn btn-primary" id="ajaxformbtn" data-target="messagesout_newcompany" ><i class="icon-ok"></i>&nbsp;<?= $btn_label ?></button>                        
                    </div>
                </div>                      
    
</form>