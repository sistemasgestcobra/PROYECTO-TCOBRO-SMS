<form method="post" action="<?= base_url('admin/oficialcredito/update_password')?>" class="form-horizontal">
    <div class="col-md-12" id="messagesout_newcompany"></div>
    
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
    <input type='hidden' name='id' value='<?= $oficial->id ?>'/>

            <div class="form-group col-md-8">
                <div class="col-md-3">Nueva Clave *</div>
                <div class="col-md-9">
                    <input class="form-control" id="password" type="text" name="password" maxlength="128" value=""  placeholder="Escriba aqu&iacute; la nueva clave" required=""/> 
                </div>
            </div>
    
            <div class="form-group">
              <div class="col-md-3">&nbsp;</div>
                <div class="col-md-9"> 
                    <button class="btn btn-primary" id="ajaxformbtn" data-target="messagesout_newcompany" ><i class="icon-ok"></i>&nbsp;Actualizar Clave</button>                        
                </div>
            </div>         
</form>
<form method="post" action="<?= base_url('admin/oficialcredito/save_profile_image')?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
    <input type='hidden' name='id' value='<?= $oficial->id ?>'/>
    
    <div class="form-group col-md-8">
        <div class="col-md-3">Imagen de Perfil</div>
            <div class="form-group col-md-4" style="margin: 0 auto">
                <input type="file" name="profile_image" placeholder="Imagen de Perfil">
            </div>
        </div>
    </div>
                <div class="form-group">
              <div class="col-md-3">&nbsp;</div>
                <div class="col-md-9"> 
                    <button class="btn btn-primary" id="ajaxformbtn" data-target="messagesout_newcompany" ><i class="icon-ok"></i>&nbsp;Subir Fotografia</button>                        
                </div>
            </div> 
    
</form> 