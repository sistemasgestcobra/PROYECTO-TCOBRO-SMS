<?php
    $user = new gestcobra\oficial_credito_model($this->user->id);
    //print_r($user);
?>

<div class="container-fluid main-content">
<div class="page-title">
    <h1> Informaci&oacute;n Personal </h1>
</div>
    <div class="row">
      <div class="col-md-6">
        <div class="widget-container fluid-height clearfix">
            <div class="heading">
              <i class="icon-tags"></i>Datos Personales
            </div>
            <div class="widget-content padded">
                <form class="form-horizontal" action="<?php echo base_url('login/editprofile/edit') ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
                    <div class="form-group" style="visibility:hidden">
                        <label class="col-md-4" >CI/RUC<span class="required">*</span></label>
                        <label class="col-md-8"> <?php echo $this->user->id; ?><span class="required"></span></label>
                        <div class="col-md-8" hidden="true"><input class="form-control" id="ruc" type="text" name="id" maxlength="128" value="<?php echo $this->user->id; ?>"  hidden /> </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4" >Nombres<span class="required">*</span></label>
                        <div class="col-md-8" ><input id="nombres" class="form-control" name="nombres" type="text" value="<?php echo $user->firstname ?>"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4" >Apellidos<span class="required">*</span></label>
                        <div class="col-md-8" ><input id="apellidos" class="form-control" type="text" value="<?php echo $user->lastname ?>" name="apellidos"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4" >Teléfono<span class="required">*</span></label>
                        <div class="col-md-8" ><input id="telefono" class="form-control" type="text" value="<?php echo $user->telefono ?>" name="telefono"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4" >Usuario<span class="required">*</span></label>                                     
                        <div class="col-md-8" ><input id="email" class="form-control" type="text" value="<?php echo $user->email ?>" name="email"></div>
                    </div>
                    
                    <button id="ajaxformbtn" class="btn btn-primary" data-target="messagesout">Actualizar Informacion</button>
                </form>
            </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="widget-container fluid-height clearfix">
            <div class="heading">
                <i class="icon-tags"></i>Cambio de Contrase&ntilde;a
            </div>
            <div class="widget-content padded">
                <form class="form-horizontal" action=<?php echo base_url('login/editprofile/edit_pass')?> method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>"> 
                    <div class="form-group">
                        <label class="col-md-4" >Clave Actual<span class="required">*</span></label>
                        <div class="col-md-8" ><input id="curren_pass" class="form-control" type="password" value="" name="current_pass"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4" >Nueva Clave<span class="required">*</span></label>
                        <div class="col-md-8" ><input id="new_pass" class="form-control" type="password" value="" name="new_pass"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4" >Confirme Nueva Clave<span class="required">*</span></label>
                        <div class="col-md-8" ><input id="confirm_pass" class="form-control" type="password" value="" name="confirm_pass"></div>
                    </div>
                    <button id="ajaxformbtn" class="btn btn-primary" data-target="messagesout">Actualizar Contrase&ntilde;a</button>

               </form>
            </div>
        </div>
      </div>
    </div>    
</div>