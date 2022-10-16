<?php
$grupos = (new gestcobra\grupo_model())
        ->find();
$agencias_combo = combobox($grupos, array('value' => 'id', 'label' => 'nombre'), array('name' => 'id_grupo', 'class' => 'form-control select2able'), true);
?>
<div class="row">
    <div class="widget-container">

        <div class="widget-content padded">
            <form method="post" action="<?= base_url('msjs/subir_mensajes/load_mensajes_base') ?>" class="form-horizontal">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
                <input type="hidden" name="id" id="id" value="<?= $id ?>"/>
                <input type="hidden" name="lote" id="lote" value="0"/>
                <div class="form-group col-md-4">

                    <label class="col-md-2 control-label" for="from_date">BASE</label>  
                    <div class="col-md-10">
                        <?php
                        echo $agencias_combo;
                        ?>
                    </div>
             
			 
			              <label class="col-md-3 control-label">MENSAJE</label>  
                    <!--<strong >Mensaje:</strong>-->
       <div class="form-group col-md-8">
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
			    <button class="btn btn-primary" reset-form="0" id="autosubmit_edit_template" data-target="#response" onclick="this.form.action='<?= base_url('msjs/subir_mensajes/leer')?>';">Visualizar mensaje</button>
              
			 
			 
			 
			 
				   </div>
                <div id="response"></div>
                <br>
                <hr>                
                <div class="form-group">
                    <label class="col-md-12">Formato de Mensaje</label>    

                    <?php
                    ?>
                    <div class="col-md-8">
                        <!--<textarea id="summernote_contract" class="form-control" name="mensaje" maxlength="160" style="height: 250px">-->
                        <textarea name="mensaje" required="" maxlength="160" cols="85" placeholder="Mensaje debe tener una longitud máxima de 160 caracteres"  style=" height: 150px"></textarea>

                        </textarea>
                    </div>
                    <?php
                    ?>
                    <div class="col-md-4">
                        <strong> NOMBRE: &nbsp; </strong>  NOMBRE <br>
                        <strong> VARIABLE 1: &nbsp; </strong>  VAR1 <br>
                        <strong> VARIABLE 2: &nbsp; </strong>  VAR2 <br>
                        <strong> VARIABLE 3: &nbsp; </strong>  VAR3 <br>
                        <strong> VARIABLE 4: &nbsp; </strong>  VAR4 <br>
                    </div>   
                </div>
                <button class="btn btn-primary" id="autosubmit_edit_template" data-target="#response_out" >Enviar</button>

            </form>        
        </div>
    </div>    
</div>

<div id="response_out"></div>

<script>
//    if ($('#summernote').length) {
//      $('#summernote_contract').summernote({
//        height: 250,
//        focus: true,
//        toolbar: [['style', ['style']], ['style', ['bold', 'italic', 'underline', 'clear']], ['fontsize', ['fontsize']], ['color', ['color']], ['para', ['ul', 'ol', 'paragraph']], ['height', ['height']], ['insert', ['picture', 'link']], ['table', ['table']], ['fullscreen', ['fullscreen']]]
//      });
//    }
    $(document).on("click", "#autosubmit_edit_template", function(e) {
        $("#summernote_contract").val($('#summernote_contract').code());
    });
</script>