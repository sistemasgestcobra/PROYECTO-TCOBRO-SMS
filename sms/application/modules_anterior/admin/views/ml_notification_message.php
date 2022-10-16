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

$mensaje_cliente = $ml_notification_model->format;
$COMPANY_NAME = '';
$DEUDOR_NAME = '';
$SOCIO_NUMERO = '';
$PAGARE_NUEMERO = '';
$DEUDA_INICIAL = '';
$SALDO_ACTUAL = '';
$FECHA_ADJUDICACION = '';
$CUOTAS_PAGADAS = '';
$CUOTAS_MORA = '';
$DIAS_MORA = '';
$TOTAL_CUOTAS_VENCIDAS = '';
$PLAZO_ORIGINAL = '';
$FECHA_ULTIMO_PAGO = '';
$NOMBRE_PERSONA = '';

$COMPANY_NAME = $ml_company->nombre_comercial;
$DEUDOR_NAME = $ml_person_deudor->firstname;
$SOCIO_NUMERO = $ml_credit_detail_model->nro_cuotas;
$PAGARE_NUEMERO = $ml_credit_detail_model->nro_pagare;
$DEUDA_INICIAL = $ml_credit_detail_model->deuda_inicial;
$SALDO_ACTUAL = $ml_credit_detail_model->saldo_actual;
$FECHA_ADJUDICACION = $ml_credit_detail_model->adjudicacion_date;
$CUOTAS_PAGADAS = $ml_credit_detail_model->cuotas_pagadas;
$CUOTAS_MORA = $ml_credit_detail_model->cuotas_mora;
$DIAS_MORA = $ml_credit_detail_model->dias_mora;
$TOTAL_CUOTAS_VENCIDAS = $ml_credit_detail_model->total_cuotas_vencidas;
$PLAZO_ORIGINAL = $ml_credit_detail_model->plazo_original;
$FECHA_ULTIMO_PAGO = $ml_credit_detail_model->last_pay_date;
$NOMBRE_PERSONA = $ml_person->firstname;

$mensaje_cliente = str_replace('COMPANY_NAME', $COMPANY_NAME, $mensaje_cliente);
$mensaje_cliente = str_replace('DEUDOR_NAME', $DEUDOR_NAME, $mensaje_cliente);
$mensaje_cliente = str_replace('SOCIO_NUMERO', $SOCIO_NUMERO, $mensaje_cliente);
$mensaje_cliente = str_replace('PAGARE_NUEMERO', $PAGARE_NUEMERO, $mensaje_cliente);
$mensaje_cliente = str_replace('DEUDA_INICIAL', $DEUDA_INICIAL, $mensaje_cliente);
$mensaje_cliente = str_replace('SALDO_ACTUAL', $SALDO_ACTUAL, $mensaje_cliente);
$mensaje_cliente = str_replace('FECHA_ADJUDICACION', $FECHA_ADJUDICACION, $mensaje_cliente);
$mensaje_cliente = str_replace('CUOTAS_PAGADAS', $CUOTAS_PAGADAS, $mensaje_cliente);
$mensaje_cliente = str_replace('CUOTAS_MORA', $CUOTAS_MORA, $mensaje_cliente);
$mensaje_cliente = str_replace('DIAS_MORA', $DIAS_MORA, $mensaje_cliente);
$mensaje_cliente = str_replace('TOTAL_CUOTAS_VENCIDAS', $TOTAL_CUOTAS_VENCIDAS, $mensaje_cliente);
$mensaje_cliente = str_replace('PLAZO_ORIGINAL', $PLAZO_ORIGINAL, $mensaje_cliente);
$mensaje_cliente = str_replace('FECHA_ULTIMO_PAGO', $FECHA_ULTIMO_PAGO, $mensaje_cliente);
$mensaje_cliente = str_replace('NOMBRE_PERSONA', $NOMBRE_PERSONA, $mensaje_cliente);

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
<form method="post" action="<?= base_url('company.jsp/create') ?>" class="form-horizontal">
    <div class="col-md-12" id="messagesout_newcompany"></div>
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
    <input type='hidden' name='id' value='<?= $ml_comunication_model->id ?>'/>
    <div class="form-group">
        <div class="col-md-3">Tipo Comunicación *</div>
        <div class="col-md-9"><input class="form-control" id="nombre_comercial" type="text" name="tipo_mensaje" maxlength="128" value="<?= $ml_notification_model->type ?>"  placeholder="Tipo mensaje" /> </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">Descripción *</div>
        <div class="col-md-9"><input class="form-control" id="nombre_comercial" type="text" name="tipo_mensaje" maxlength="128" value="<?= $ml_notification_model->description ?>"  placeholder="Descripciòn" /> </div>
    </div>
    <div class="form-group">
        <label class="col-md-12"></label>    
        <div class="col-md-12">
            <textarea id="summernote_contract" class="form-control" name="template_data"  style="height: 250px"><?= $mensaje_cliente ?></textarea>
        </div>
    </div>             
</form>