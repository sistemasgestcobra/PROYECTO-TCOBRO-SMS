<form method="post" action="<?= base_url('msjs/subir_mensajes/load_mensajes')?>" class="form-horizontal">

    
    
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
    <p>En esta sección puede subir un archivo de excel con la lista de números  a enviar el mensaje. <br/>
       En el cuadro de Mensaje ingrese el texto con un tamaño de hasta 160 caracteres.</p>
    <p>Si desea ver como estructurar el excel dirijase a la pestaña EXCEL y seleccione mensajes masivos personalizados.</p>
    <br>
                <div class="form-group">
                    <div class="col-md-3">Seleccionar Archivo de Mensajes *</div>
                    
                    <div class="col-md-9">
                        <input class="form-control" id="userfile" type="file" name="userfile" maxlength="128" value=""  placeholder="Archivo.xlsx" /> 
                    </div>
                </div>
          <div class="form-group">
              <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-9"> 
                        <button class="btn btn-primary" id="ajaxformbtn" data-target="messagesout_newcompan" ><i class="icon-ok"></i>Enviar Mensajes</button>                        
                    </div>
                </div>           
    
    <div class="col-md-12" id="messagesout_newcompan"></div>
</form>
