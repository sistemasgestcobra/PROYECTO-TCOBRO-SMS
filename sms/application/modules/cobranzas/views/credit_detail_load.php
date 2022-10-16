<form method="post" action="<?= base_url('cobranzas/admin/load_credits_data')?>" class="form-horizontal">
    <div class="col-md-12" id="messagesout_newcompany"></div>
    
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        

                <div class="form-group">
                    <div class="col-md-3">Seleccionar Archivo *</div>
                    <div class="col-md-9">
                        <input class="form-control" id="userfile" type="file" name="userfile" maxlength="128" value=""  placeholder="Archivo .xlsx" /> 
                    </div>
                </div>
          <div class="form-group">
              <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-9"> 
                        <button class="btn btn-primary" id="ajaxformbtn" data-target="messagesout_newcompany" ><i class="icon-ok"></i>Subir Creditos</button>                        
                    </div>
                </div>                      
          
    
</form>