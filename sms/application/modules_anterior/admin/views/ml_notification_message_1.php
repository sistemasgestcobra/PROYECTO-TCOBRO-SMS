<?php

// Change the css classes to suit your needs 
$ml_company = new \gestcobra\company_model($this->user->company_id);
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
$mensaje_cliente = $ml_notification_model->format;
$COMPANY_NAME = '';
$DEUDOR_NAME = '';
$SOCIO_NUMERO = '';
$CUENTA = '';
$PAGO_MINIMO = '';
$SALDO_ACTUAL = '';
$FECHA_ADJUDICACION = '';
$SALDO_TOTAL = '';
$CUOTAS_MORA = '';
$DIAS_MORA = '';
$TOTAL_CUOTAS_VENCIDAS = '';
$PLAZO_ORIGINAL = '';
$FECHA_PROXIMO_PAGO = '';
$NOMBRE_PERSONA = '';
$CIUDAD = '';

$COMPANY_NAME = $ml_company->nombre_comercial;
$DEUDOR_NAME = $ml_person_deudor->firstname;
$SOCIO_NUMERO = $ml_credit_detail_model->nro_cuotas;
$CUENTA = $ml_credit_detail_model->nro_pagare;
$PAGO_MINIMO = $ml_credit_detail_model->deuda_inicial;
$SALDO_ACTUAL = $ml_credit_detail_model->saldo_actual;
$FECHA_ADJUDICACION = $ml_credit_detail_model->adjudicacion_date;
$SALDO_TOTAL = $ml_credit_detail_model->cuotas_pagadas;
$CUOTAS_MORA = $ml_credit_detail_model->cuotas_mora;
$DIAS_MORA = $ml_credit_detail_model->dias_mora;
$TOTAL_CUOTAS_VENCIDAS = $ml_credit_detail_model->total_cuotas_vencidas;
$PLAZO_ORIGINAL = $ml_credit_detail_model->plazo_original;
$FECHA_PROXIMO_PAGO = $ml_credit_detail_model->last_pay_date;
$NOMBRE_PERSONA = $ml_person->firstname;
$CIUDAD = $ml_person->address_ref;

$mensaje_cliente = str_replace('COMPANY_NAME', $COMPANY_NAME, $mensaje_cliente);
$mensaje_cliente = str_replace('DEUDOR_NAME', $DEUDOR_NAME, $mensaje_cliente);
$mensaje_cliente = str_replace('SOCIO_NUMERO', $SOCIO_NUMERO, $mensaje_cliente);
$mensaje_cliente = str_replace('CUENTA', $CUENTA, $mensaje_cliente);
$mensaje_cliente = str_replace('PAGO_MINIMO', $PAGO_MINIMO, $mensaje_cliente);
$mensaje_cliente = str_replace('SALDO_ACTUAL', $SALDO_ACTUAL, $mensaje_cliente);
$mensaje_cliente = str_replace('FECHA_ADJUDICACION', $FECHA_ADJUDICACION, $mensaje_cliente);
$mensaje_cliente = str_replace('SALDO_TOTAL', $SALDO_TOTAL, $mensaje_cliente);
$mensaje_cliente = str_replace('CUOTAS_MORA', $CUOTAS_MORA, $mensaje_cliente);
$mensaje_cliente = str_replace('DIAS_MORA', $DIAS_MORA, $mensaje_cliente);
$mensaje_cliente = str_replace('TOTAL_CUOTAS_VENCIDAS', $TOTAL_CUOTAS_VENCIDAS, $mensaje_cliente);
$mensaje_cliente = str_replace('PLAZO_ORIGINAL', $PLAZO_ORIGINAL, $mensaje_cliente);
$mensaje_cliente = str_replace('FECHA_PROXIMO_PAGO', $FECHA_PROXIMO_PAGO, $mensaje_cliente);
$mensaje_cliente = str_replace('NOMBRE_PERSONA', $NOMBRE_PERSONA, $mensaje_cliente);
$mensaje_cliente = str_replace('CIUDAD', $CIUDAD, $mensaje_cliente);

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
        $this->load->view('credit_hist_notification', array('client_id' => $ml_client_referencia_deudor->credit_detail_id, 'data_height' => '250', 'show_export' => '0'));
    ?>   
      
  
