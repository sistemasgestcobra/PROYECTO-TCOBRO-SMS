<?php

// Change the css classes to suit your needs 

$ml_comunication_model = (new \gestcobra\comunication_model($id));

$ml_client_referencia = new \gestcobra\client_referencias_model($ml_comunication_model->client_referencias_id);
$ml_credit_detail_model = new \gestcobra\credit_detail_model($ml_client_referencia->credit_detail_id);
$ml_client_referencia_deudor = (new \gestcobra\client_referencias_model($ml_comunication_model->client_referencias_id))
        ->where('reference_type_id', '3')
        ->where('credit_detail_id', $ml_credit_detail_model->id)
        ->find_one();

$ml_person_deudor = new gestcobra\person_model($ml_client_referencia_deudor->person_id);
$ml_person = new \gestcobra\person_model($ml_client_referencia->person_id);
$ml_notification_model = (new \gestcobra\notification_format_model($ml_comunication_model->notification_format_id));

$motivo_no_pago = (new \gestcobra\motivo_no_pago_model())
        ->where('company_id', $this->user->company_id)
        ->find();

$combo_motivo_no_pago = combobox(
        $motivo_no_pago, array('label' => 'motivo_name', 'value' => 'id'), array('name' => 'motivo_no_pago_id', 'class' => 'form-control'), false, $ml_comunication_model->motivo_no_pago_id
);
?>
<form method="post" action="<?= base_url('admin/notificationformat/update_comunicacion_new') ?>" class="form-horizontal">  
    <input type='hidden' name='id' value='<?= $ml_comunication_model->id ?>'/>
    <div class="form-group" class="col-md-12">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <button class="btn btn-primary pull-right" id="ajaxformbtn" data-target="messagesout_newcompany" reset-form="0" style="font-size: 15px"><i class="icon-ok"></i>&nbsp;Guardar Cambios</button>
    <div class="col-md-12" id="messagesout_newcompany"></div>
    </div>
    <div class="form-group">
        <strong class="col-md-1">Detalle Notificación:</strong>
        <div class="col-md-11"><input class="form-control" id="detalle_notificacion" type="text" name="detalle_notificacion" maxlength="500" value=""  placeholder="Detalle Notificacion" /> </div>
    </div>
    <div class="form-group">
        <strong class="col-md-1">Nombre Notificador:</strong>
        <div class="col-md-3"><input class="form-control" id="notificador" type="text" name="notificador" maxlength="100" value=""  placeholder="Notificador" /> </div>
        <strong class="col-md-1">Fecha de Entrega:</strong>
         <div class="col-md-3">
			<style>.datepicker{z-index:1200 !important;}</style>
            <input id="fecha_entrega" class="form-control datepicker" onkeydown="return false" data-date-autoclose="true" type="text" name="fecha_entrega"  value=""  placeholder="Fecha Entrega" /> 
             <script type="text/javascript">
                $(function () {                 
                $('#fecha_entrega').datepicker({
                clearBtn: true,
                todayBtn: true,
                format: 'yyyy-mm-dd'
                });
                $('#fecha_entrega').datepicker('setEndDate', new Date());
                 });
            </script>
        </div>
	   <strong class="col-md-1">Hora de Entrega:</strong>
 <div class="col-md-3">
            <div class="input-group bootstrap-timepicker timepicker">
            <input class="form-control input-small" data-date-autoclose="true" onkeydown="return false" id="hora_entrega" type="text" name="hora_entrega" maxlength="500" value=""  placeholder="Hora Entrega" /> 
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
 
        <script type="text/javascript">
            $('#hora_entrega').timepicker();
        </script>
        </div>       


	   </div>
        <strong class="col-md-1">Motivo De No Pago:</strong>
        <div class="col-md-3"> 
            <?php
            echo $combo_motivo_no_pago;
            ?>
        </div>
    </div>
    
</form>

<hr class="clr"/>
    <?php
        $this->load->view('credit_hist_notification', array('client_id' => $ml_client_referencia_deudor->credit_detail_id, 'data_height' => '250', 'show_export' => '0'));
    ?>   
      
  
