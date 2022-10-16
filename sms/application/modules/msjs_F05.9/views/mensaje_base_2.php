<?php
$grupos = (new gestcobra\grupo_model())
        ->find();
$agencias_combo = combobox($grupos, array('value' => 'id', 'label' => 'nombre'), array('name' => 'id_grupo', 'class' => 'form-control select2able'), true);
?>
<div class="row">
    <div class="widget-container">

        <div class="widget-content padded">
            <form method="post" action="<?= base_url('msjs/subir_mensajes/load_mensajes_base_programado') ?>" class="form-horizontal">
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
                </div>
                <br>
                <hr>                
                <div class="form-group">
                    <label class="col-md-12">Formato de Mensaje</label>    

                    <?php
                    ?>
                    <div class="col-md-8">
                        <!--<textarea id="summernote_contract" class="form-control" name="mensaje" maxlength="160" style="height: 250px">-->
                        <textarea name="mensaje" required="" maxlength="160" cols="85" placeholder="Mensaje debe tener una longitud máxima de 160 caracteres"  style=" height: 150px"></textarea>
                    </div>
                    <?php
                    ?>
                    <div class="col-md-4">
                        <strong> NOMBRE: &nbsp; </strong>[NOMBRE]<br>
                        <strong> VARIABLE 1: &nbsp; </strong>[VAR1]<br>
                        <strong> VARIABLE 2: &nbsp; </strong>[VAR2]<br>
                        <strong> VARIABLE 3: &nbsp; </strong>[VAR3]<br>
                        <strong> VARIABLE 4: &nbsp; </strong>[VAR4]<br>
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
                
         <button class="btn btn-primary" reset-form="0" id="autosubmit_edit_template" data-target="#response_out_1" >Enviar</button>

            </form>        
        </div>
    </div>    
</div>

<div id="response_out_1"></div>
<script>

    $(document).on("click", "#autosubmit_edit_template", function(e) {
        $("#summernote_contract").val($('#summernote_contract').code());
    });
</script>