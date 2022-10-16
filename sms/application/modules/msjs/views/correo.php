<form method="post" action="<?= base_url('msjs/subir_mensajes/correo')?>" class="form-horizontal" enctype="multipart/form-data">

    
    
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>"> 
    <p>En esta sección puede subir un archivo de excel con la lista de CORREOS  a enviar el mensaje. <br/>
       En el cuadro de Mensaje ingrese el texto.</p>
    <p>Si desea ver como estructurar el excel dirijase a la pestaña EJEMPLO y seleccione correo masivo.</p>
    <br>
    <div class="form-group">
                    <strong class="col-md-2">Seleccionar Archivo de correos*</strong>
                    <div class="col-md-7">
                        <input class="form-control" id="userfile" type="file" name="userfile" maxlength="128" value=""  placeholder="Archivo .xlsx" /> 
                    </div>
    </div>
    <br>
	 <p>Seleccione Plantilla de Correo o digite el Mensaje a Enviar. <br/>
        <div class="form-group">
        <strong class="col-md-2">Mensaje:</strong>
      
    <div class=" col-md-3">
           <select class='form-control' name='message_format'>
                <option  value='-1'>Selec.Mensaje</option>
                <?php
                $notification_format = (new gestcobra\notification_format_model())
                        ->where('company_id',$this->user->company_id)
                        ->find();
                foreach ($notification_format as $not) {
                    if ($not->type == 'MENSAJE' AND $not->status==1) {
                        echo "<option value='$not->format' >$not->description</option>";
                    }
                }
                ?>
            </select>
       
  </div>
    <div class="col-md-5">
       <button class="btn btn-primary" reset-form="0" id="autosubmit_edit_template" data-target="#vercorreo" onclick="this.form.action='<?= base_url('msjs/subir_mensajes/leer')?>';">Visualizar mensaje</button>
  </div>
     </div>

		   <br> 
          <div id="vercorreo"></div>  
    <br>
        <div class="col-md-10 text-center">
                    <textarea name="mensaje"  maxlength="160" cols="85" placeholder="Mensaje debe tener una longitud máxima de 160 caracteres"  style=" height: 150px"></textarea>
        </div>
        
    <br>
    <br>
	<br>
	<br>
	<div class="form-group">
	<strong class="col-md-4">Seleccione el archivo para adjuntar en el correo*</strong>
	<div class="col-md-4">
		<input type="file" name="archivo" placeholder="Seleccione Archivo a Adjuntar"/> 
    </div>
	</div>
    <br>
     <div class="form-group">
              <div class="col-md-6 text-center">&nbsp;</div>
                    <div class="col-md-10 "> 
                        <button class="btn btn-primary" id="ajaxformbtn" onclick="this.form.action='<?= base_url('msjs/subir_mensajes/correo')?>';" data-target="messagesout_newcompany" ><i class="icon-ok"></i>Enviar Correos</button>                        
                    </div>
    </div>   
    <div class="col-md-12" id="messagesout_newcompany"></div>
</form>
