<?php
// Change the css classes to suit your needs 
$ml_credit_detail_model = new \gestcobra\credit_detail_model($id);
$oficina= $ml_credit_detail_model->oficina_company_id;
//$ml_client_model = new \gestcobra\client_model( $ml_credit_detail_model->client_id );
//    $person_client_model = new \gestcobra\person_model( $ml_client_model->person_id );
$client_referencias = (new \gestcobra\client_referencias_model())
                ->where('credit_detail_id', $ml_credit_detail_model->id)
                ->where('reference_type_id', 2)->find_one();

$person_ref_model = new gestcobra\person_model($client_referencias->person_id);
$client_garantes = (new \gestcobra\client_referencias_model())
                ->where('credit_detail_id', $ml_credit_detail_model->id)
                ->where('reference_type_id', 1)->find_one();
$person_garantes_model = new gestcobra\person_model($client_garantes->person_id);

$credit_status = (new \gestcobra\credit_status_model())
        ->where('company_id', $this->user->company_id)
        ->find();

$combo_credit_status = combobox(
        $credit_status, array('label' => 'status_name', 'value' => 'id'), array('name' => 'credit_status_id', 'class' => 'form-control'), false, $ml_credit_detail_model->credit_status_id
);

$tipo_gestion = (new \gestcobra\tipo_gestion_model())
        ->where('company_id', $this->user->company_id)
        ->find();

$combo_tipo_gestion = combobox(
        $tipo_gestion, array('label' => 'gestion_name', 'value' => 'id'), array('name' => 'tipo_gestion_id', 'class' => 'form-control'), false, $ml_credit_detail_model->tipo_gestion_id
);

$motivo_no_pago = (new \gestcobra\motivo_no_pago_model())
        ->where('company_id', $this->user->company_id)
        ->find();

$combo_motivo_no_pago = combobox(
        $motivo_no_pago, array('label' => 'motivo_name', 'value' => 'id'), array('name' => 'motivo_no_pago_id', 'class' => 'form-control'), false, $ml_credit_detail_model->motivo_no_pago_id
);

$persons_credit = $this->client_referencias_contact_model->get_person_id_client_reference($ml_credit_detail_model->id);
?>   
<form method="post" action="<?= base_url('cobranzas/credit/save') ?>" class="form-horizontal" name="crono">    
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary">
            <input type="checkbox" name="comunicacion_opt[]" value="com_whatsapp" autocomplete="off"> <img src="<?= base_url('assets/images/social/whatsapp.png') ?>"/>
        </label>
        <label class="btn btn-primary">
            <input type="checkbox" name="comunicacion_opt[]" value="com_email" autocomplete="off"> <img src="<?= base_url('assets/images/social/email.png') ?>"/>
        </label>
        <label class="btn btn-primary">
            <input type="checkbox" name="comunicacion_opt[]" value="com_sms" autocomplete="off"> <img src="<?= base_url('assets/images/social/sms.png') ?>"/>
        </label>
        <label class="btn btn-primary">
            <input type="checkbox" name="comunicacion_opt[]" value="com_call" autocomplete="off"> <img src="<?= base_url('assets/images/social/call.png') ?>"/>
        </label>
    </div>    
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <button class="btn btn-primary pull-right" id="ajaxformbtn" data-target="messagesout_newcompany" reset-form="0" style="font-size: 25px"><i class="icon-ok"></i>&nbsp;Guardar Cambios</button>
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
    <input type='hidden' name='id' value='<?= $ml_credit_detail_model->id ?>'/>
    <div class="form-group">
        <strong class="col-md-2">Detalle de Gesti&oacute;n:</strong>
        <div class="col-md-10">
            <input class="form-control" id="detail" required="" type="text" name="detail" maxlength="500" value=""  placeholder="Observaciones" /> 
        </div>
    </div>
    <div class="form-group">
        <strong class="col-md-2">Mensaje Al Cliente:</strong>
        <div class="col-md-2">
            <select class=' select2able' name='message_format_id'>
                <option  value='-1'>Selec.Mensaje</option>
                <?php
                $notification_format = (new gestcobra\notification_format_model())
                        ->where('company_id',$this->user->company_id)
                        ->find();
                foreach ($notification_format as $not) {
                    if ($not->type == 'MENSAJE') {
                        echo "<option  value='$not->id'> $not->description </option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-8">
            <input class="form-control" id="client_message" type="text" name="client_message" maxlength="128" value=""  placeholder="Mensaje al Cliente" /> 
        </div>
    </div>
    <div class="form-group">
        <strong class="col-md-2">Compromiso Pago:</strong>
        <div class="col-md-4">
            <input class="form-control datepicker" data-date-autoclose="true" id="compromiso_pago_date" type="text" name="compromiso_pago_date" maxlength="500" value=""  placeholder="Compromiso Pago" /> 
        </div>
        <div class="col-md-2">Estado *</div>
        <div class="col-md-4">
<?php
echo $combo_credit_status;
?>
        </div>
    </div>
    
    
    <div class="form-group">
        <strong class="col-md-2">Valor de Promesa:</strong>
        <div class="col-md-4">
            <input class="form-control" id="valor_promesa" type="text" name="valor_promesa" maxlength="30" value=""  placeholder="Valor" /> 
        </div>
        <div class="col-md-2">Tipo de Gestion *</div>
        <div class="col-md-4">
<?php
echo $combo_tipo_gestion;
?>
        </div>
    </div>
    
    
    <div class="form-group">
         <strong class="col-md-2">Motivo De No Pago *</strong>
        <div class="col-md-4">
<?php
echo $combo_motivo_no_pago;
?>
        </div>
               
    </div>
    
    <div class="col-md-12">       
<?php

if($oficina == 390) {
    $this->load->view('credit_detail_report_preventiva_ciclo1', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
} else
if ($oficina == 391) {
    $this->load->view('credit_detail_report_preventiva_ciclo2', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
} else
if ($oficina == 392) {
    $this->load->view('credit_detail_report_mora_ciclo1', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
} else
if ($oficina == 393) {
    $this->load->view('credit_detail_report_mora_ciclo2', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
} else 
if ($oficina == 394) {   
    $this->load->view('credit_detail_report_mora_ciclo3', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
} else
if ($oficina == 395) {
    $this->load->view('credit_detail_report_vencida', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
} else
if ($oficina == 396) {
    $this->load->view('credit_detail_report_castigada', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
} else 
if ($oficina == 397) {
    $this->load->view('credit_detail_report_preventivabanco', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
} else
if ($oficina == 398) {
    $this->load->view('credit_detail_report_vencidabanco', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
}else 
if ($oficina == 399) {
    $this->load->view('credit_detail_report_vencidaquito', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
}else
if ($oficina == 400) {
    $this->load->view('credit_detail_report_vencidacuenca', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
}else{
    $this->load->view('credit_detail_report', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0, 'compromiso_pago_date' => '0'));
}
?>
    </div>
    <div class="col-md-6">
        <?= $this->load->view('client_referencias_report', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0)); ?>
        <?= $this->load->view('abono_report', array('credit_detail_id' => $ml_credit_detail_model->id, 'data_height' => '100', 'show_export' => 0)); ?>
    </div>
    <div class="col-md-6">
        <?= $this->load->view('contact_report', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '260', 'show_export' => 0, 'persons_credit' => $persons_credit)); ?>
    </div>
</form>
<hr class="clr"/>
        <?php
        $this->load->view('credit_hist_report', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '250', 'show_export' => '0'));

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
      