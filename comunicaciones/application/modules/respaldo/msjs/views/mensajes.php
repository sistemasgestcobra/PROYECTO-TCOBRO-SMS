<form method="post" action="<?= base_url('msjs/subir_mensajes/load_mensajes_masivos')?>" class="form-horizontal">

    
    
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>"> 
    <p>En esta sección puede subir un archivo de excel con la lista de números  a enviar el mensaje. <br/>
       En el cuadro de Mensaje ingrese el texto con un tamaño de hasta 160 caracteres.</p>
    <p>Si desea ver como estructurar el excel dirijase a la pestaña EXCEL y seleccione mensajes masivos.</p>
    <br>
    <div class="form-group">
                    <strong class="col-md-2">Seleccionar Archivo de Mensajes*</strong>
                    <div class="col-md-7">
                        <input class="form-control" id="userfile" type="file" name="userfile" maxlength="128" value=""  placeholder="Archivo .xlsx" /> 
                    </div>
    </div>
    <br>
    <br>
                            
          <div class="form-group">
        <strong class="col-md-3">Mensaje:</strong>
       </div>
    
        <div class="col-md-10 text-center">
                    <textarea name="mensaje" required="" maxlength="160" cols="85" placeholder="Mensaje debe tener una longitud máxima de 160 caracteres"  style=" height: 150px"></textarea>
        </div>
        
    <br>
    <br>
    <br>
     <div class="form-group">
              <div class="col-md-6 text-center">&nbsp;</div>
                    <div class="col-md-10 "> 
                        <button class="btn btn-primary" id="ajaxformbtn" data-target="messagesout_newcompany" ><i class="icon-ok"></i>Enviar Mensajes</button>                        
                    </div>
    </div>   
    <div class="col-md-12" id="messagesout_newcompany"></div>
</form>
