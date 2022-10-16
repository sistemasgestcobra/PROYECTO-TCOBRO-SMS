<form method="post" action="<?= base_url('msjs/subir_mensajes_programado/envio_programado')?>" class="form-horizontal">

     <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
   
  
     <br>
               <div class="form-group">
                    <strong class="col-md-2">Seleccionar Archivo de Mensajes*</strong>
                    <div class="col-md-5">
                        <input class="form-control" id="userfile" type="file" name="userfile" maxlength="128" value=""  placeholder="Archivo .xlsx" /> 
                    </div>
    </div>
   <br>
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
       <button class="btn btn-primary" reset-form="0" id="autosubmit_edit_template" data-target="#response_pro" onclick="this.form.action='<?= base_url('msjs/subir_mensajes/leer')?>';">Visualizar mensaje</button>
  </div>

		
          <div  class= "form-group col-md-8" id="response_pro"></div>  
		
		
		   <br> 
		   <hr> 
       <div class="col-md-5 text-center">
                    <textarea name="mensaje"  maxlength="160" cols="85" placeholder="Mensaje debe tener una longitud máxima de 160 caracteres"  style=" height: 150px"></textarea>
        </div>
         </div>
                    <div class="form-group">
        <strong class="col-md-1">FECHA DE ENVIO:</strong>
       
 <div class="col-md-2" >
    <style>.datepicker{z-index:1200 !important;}</style>
            <input id="datepicker" class="form-control datepicker" onkeydown="return false" data-date-autoclose="true" type="text" name="fecha_envio"  value=""  placeholder="Fecha Envio" />
            <script type="text/javascript">
            var myDate = new Date();
var dayOfMonth = myDate.getDate();
myDate.setDate(dayOfMonth - 1);
                $(function () {
                $('#datepicker').datepicker({
                clearBtn: true,
                todayBtn: true
              
                });
                $('#datepicker').datepicker('setStartDate', myDate);
                 });
            </script>
        </div>
        <hr
     <strong class="col-md-1">HORA DE ENVIO:</strong>
             <div class="col-md-3">
            <div class="input-group bootstrap-timepicker timepicker">
            <input class="form-control input-small" data-date-autoclose="true" onkeydown="return false" id="hora_entrega" type="text" name="hora_envio" maxlength="128" value=""  placeholder="Hora Entrega" /> 
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
        <script type="text/javascript">
            $('#hora_entrega').timepicker();
        </script>
        </div>
    </div>
      <div class="form-group">
              
              <div class="col-md-1">&nbsp;</div>
                    <div class="col-md-9"> 
                        <button class="btn btn-primary" reset-form="0" id="ajaxformbtn" data-target="messagesout_newcompan" onclick="this.form.action='<?= base_url('msjs/subir_mensajes_programado/envio_programado')?>';" ><i class="icon-ok"></i>Enviar</button>                        
                    </div>
                </div>           

</form>
 
<div class="col-md-12" id="messagesout_newcompan"></div>