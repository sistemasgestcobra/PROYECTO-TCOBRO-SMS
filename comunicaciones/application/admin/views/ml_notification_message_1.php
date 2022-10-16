<?php

// Change the css classes to suit your needs 
$ml_company = new \gestcobra\company_model($this->user->company_id);
$ml_comunication_model = (new \gestcobra\comunication_model($id));

$ml_client_referencia = new \gestcobra\client_referencias_model($ml_comunication_model->client_referencias_id);
$ml_credit_detail_model = new \gestcobra\credit_detail_model($ml_client_referencia->credit_detail_id);
$oficina= $ml_credit_detail_model->oficina_company_id;

$ml_client_referencia_deudor = (new \gestcobra\client_referencias_model($ml_comunication_model->client_referencias_id))
        ->where('reference_type_id', '3')
        ->where('credit_detail_id', $ml_credit_detail_model->id)
        ->find_one();

$ml_person_deudor = new gestcobra\person_model($ml_client_referencia_deudor->person_id);
$ml_person = new \gestcobra\person_model($ml_client_referencia->person_id);
$ml_notification_model = (new \gestcobra\notification_format_model($ml_comunication_model->notification_format_id));

$credit_status = (new \gestcobra\credit_status_model())
        ->where('company_id', $this->user->company_id)
        ->find();

$combo_credit_status = combobox(
        $credit_status, array('label' => 'status_name', 'value' => 'id'), array('name' => 'credit_status_id', 'class' => 'form-control'), false, $ml_comunication_model->credit_status_id
);

$tipo_gestion = (new \gestcobra\tipo_gestion_model())
        ->where('company_id', $this->user->company_id)
        ->find();

$combo_tipo_gestion = combobox(
        $tipo_gestion, array('label' => 'gestion_name', 'value' => 'id'), array('name' => 'tipo_gestion_id', 'class' => 'form-control'), false, $ml_comunication_model->tipo_gestion_id
);

$motivo_no_pago = (new \gestcobra\motivo_no_pago_model())
        ->where('company_id', $this->user->company_id)
        ->find();

$combo_motivo_no_pago = combobox(
        $motivo_no_pago, array('label' => 'motivo_name', 'value' => 'id'), array('name' => 'motivo_no_pago_id', 'class' => 'form-control'), false, $ml_comunication_model->motivo_no_pago_id
);


$res = array('company_id' => $ml_comunication_model->id);
$root_data_disabled = '';
if ($this->user->root == 0) {
    $root_data_disabled = 'disabled';
}
$btn_label = 'Registrar Entidad';
if ($ml_comunication_model->id > 0) {
    $btn_label = 'Actualizar Informacion';
}
?>
<form method="post" action="<?= base_url('admin/notificationformat/update_comunicacion_new') ?>" class="form-horizontal" name="crono">  
    <input type='hidden' name='id' value='<?= $ml_comunication_model->id ?>'/>
    <div class="form-group" class="col-md-10">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <button class="btn btn-primary pull-right" id="ajaxformbtn" data-target="messagesout_newcompany" reset-form="0" style="font-size: 15px"><i class="icon-ok"></i>&nbsp;Guardar Cambios</button>
    <style> 
    .reloj{
	/*float: ;*/
	font-size: 30px;
	font-family: Courier,sans-serif;
	color: white;
        background: #000;
        width: 150px;
        border-radius: 170px;
       /*color: #08F;*/
    }
    </style>
    <br>
    <br>
    <div class="col-xs-2 col-md-offset-5" >
    <input class="reloj" id="face" type="text" name="face" /> 
   </div>
    <br>
    <br>
    <div class="col-md-12" id="messagesout_newcompany"></div>
    <hr class="clr"/>
    </div>
    <div class="form-group">
        <strong class="col-md-1">Detalle Notificación:</strong>
        <div class="col-md-11"><input class="form-control" id="detalle_notificacion" type="text" required="" name="detalle_notificacion" maxlength="500" value=""  placeholder="Detalle Notificacion" /> </div>
    </div>
    <div class="form-group">
        <strong class="col-md-1">Nombre Notificador:</strong>
        <div class="col-md-3"><input class="form-control" id="notificador" type="text" name="notificador" maxlength="100" value=""  placeholder="Notificador" /> </div>
        <strong class="col-md-1">Fecha de Entrega:</strong>
        <div class="col-md-3"><input class="form-control datepicker" data-date-autoclose="true" id="fecha_entrega" type="text" name="fecha_entrega" maxlength="500" value=""  placeholder="Fecha Entrega" /> </div>
        <strong class="col-md-1">Hora de Entrega:</strong>
        <div class="col-md-3"><input class="form-control timepicker" data-date-autoclose="true" id="hora_entrega" type="text" name="hora_entrega" maxlength="500" value=""  placeholder="Hora Entrega" /> </div>
    </div>
    <div class="form-group">
        <strong class="col-md-1">Estado:</strong>
        <div class="col-md-3"> 
            <?php
            echo $combo_credit_status;
            ?>
        </div>
        <strong class="col-md-1">Tipo de Gestión:</strong>
        <div class="col-md-3"> 
            <?php
            echo $combo_tipo_gestion;
            ?>
        </div>
        <strong class="col-md-1">Motivo De No Pago:</strong>
        <div class="col-md-3"> 
            <?php
            echo $combo_motivo_no_pago;
            ?>
        </div>
    </div>
    
    <div class="form-group">
        <strong class="col-md-1">Compromiso Pago:</strong>
        <div class="col-md-3">
            <input class="form-control datepicker" data-date-autoclose="true" id="compromiso_pago_date" type="text" name="compromiso_pago_date" maxlength="500" value=""  placeholder="Compromiso Pago" /> 
        </div>
        <strong class="col-md-1">Valor de Promesa:</strong>
        <div class="col-md-3">
            <input class="form-control" id="valor_promesa" type="text" name="valor_promesa" maxlength="30" value=""  placeholder="Valor" /> 
        </div>
        <strong class="col-md-1">Teléfono de Contacto:</strong>
        <div class="col-md-3">
            <input class="form-control" id="contact_id" type="text" name="contact_id" maxlength="30" value=""  placeholder="Teléfono de Contacto" /> 
        </div>
    </div>
    <div class="form-group">
        <strong class="col-md-1">Dirección Actual:</strong>
        <div class="col-md-11">
            <input class="form-control" id="personal_address" type="text" name="personal_address" maxlength="500" value=""  placeholder="Dirección Actual del Cliente" /> 
        </div>
    </div>
</form>
<hr class="clr"/>
    <?php
        $this->load->view('credit_hist_notification_report', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '250', 'show_export' => '0'));
    ?>    

<script language="JavaScript">
<!--
var timeCrono;
var hor = 0;
var min = 0;
var seg = 0;
var startTime = new Date();
var start = startTime.getSeconds();
StartCrono();
function StartCrono() {
if (seg + 1 > 59) {
min+= 1 ;
}
if (min > 59) {
min = 0;
hor+= 1;
}
var time = new Date();
if (time.getSeconds() >= start) {
seg = time.getSeconds() - start;
}
else {
seg = 60 + (time.getSeconds() - start);
}
timeCrono= (hor < 10) ? "0" + hor : hor;
timeCrono+= ((min < 10) ? ":0" : ":") + min;
timeCrono+= ((seg < 10) ? ":0" : ":") + seg;
document.crono.face.value = timeCrono;
setTimeout("StartCrono()",1000);
} //-->
</script>
      