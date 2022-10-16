<form method="post" action="<?= base_url('msjs/subir_grupos/load_grupos')?>" class="form-horizontal">

    <div class="col-md-12" id="messagesout_newcompany"></div>
    
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
<p>En esta sección puede cargar listas a las cuales se enviara la mensajeria <br/>
<br/>

<div class="form-group">
        <strong class="col-md-2">Nombre:</strong>
        <div class="col-md-4">
            <input class="form-control" id="valor_promesa" required="" type="text" name="name" maxlength="30" value=""  /> 
        </div></div>

<div class="form-group">
        <strong class="col-md-2">Observaciones:</strong>
        <div class="col-md-4">
            <input class="form-control" id="obser" type="text" name="obser" maxlength="80" value=""  /> 
        </div></div>

    <div class="form-group">
                    <strong class="col-md-2">Seleccionar Archivo</strong>
                    <div class="col-md-7">
                        <input class="form-control" id="userfile" type="file" name="userfile" maxlength="128" value=""  placeholder="Archivo .xlsx" /> 
                    </div>
    </div>
	
          <div class="form-group">
              <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-10"> 
                        <button class="btn btn-primary" id="ajaxformbtn" data-target="messagesout_newcompany" ><i class="icon-ok"></i>Cargar Archivo</button>                        
                    </div>
                </div>        
 

<!--    <div class="col-md-9"> 
                        <button class="btn btn-primary" id="ajaxformbtn" data-target="messagesout_newcompany" ><i class="icon-ok"></i>Enviar</button>                        
                    </div>-->


</form>
