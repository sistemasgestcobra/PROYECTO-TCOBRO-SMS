<?php
// Change the css classes to suit your needs 
$ml_credit_detail_model = new \gestcobra\credit_detail_model($id);

$client_referencias = (new \gestcobra\client_referencias_model())
                ->where('credit_detail_id', $ml_credit_detail_model->id)
                ->where('reference_type_id', 2)->find_one();

$person_ref_model = new gestcobra\person_model($client_referencias->person_id);
$client_garantes = (new \gestcobra\client_referencias_model())
                ->where('credit_detail_id', $ml_credit_detail_model->id)
                ->where('reference_type_id', 1)->find_one();
$person_garantes_model = new gestcobra\person_model($client_garantes->person_id);


$client_referencia = (new \gestcobra\client_referencias_model())
                ->where('credit_detail_id', $ml_credit_detail_model->id)
                ->where('reference_type_id', 3)->find_one();



$credit_status = (new \gestcobra\credit_status_model())
        ->where('company_id', $this->user->company_id)
        ->find();

$combo_credit_status = combobox(
        $credit_status, array('label' => 'status_name', 'value' => 'id'), array('name' => 'credit_status_id', 'class' => 'form-control'), false, $ml_credit_detail_model->credit_status_id
);

$comision = (new \gestcobra\comision_cobranzas_model())
        ->where('company_id', $this->user->company_id)
        ->find();

$combo_comision = combobox(
        $comision, array('label' => 'nombre_comision', 'value' => 'id'), array('name' => 'comision_id', 'class' => 'form-control'), false, $ml_credit_detail_model->comision_id
);


$persons_credit = $this->client_referencias_contact_model->get_person_id_client_reference($ml_credit_detail_model->id);
//  
 
$DB = $this->load->database('gestcobral', TRUE);
  $id = $DB->query("select id from credit_detail where nro_pagare=$ml_credit_detail_model->nro_pagare");
 $lol = $id->result();
       
 if ($id->num_rows()==0) {
    $id_cre=0;
}  else {

    foreach ($lol as $row) {
            $id_cre = $row->id;
}   
}
        ?>   
<form method="post" action="<?= base_url('cobranzas/credit/save') ?>" class="form-horizontal">    
    <div class="btn-group" data-toggle="buttons">
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
    <div class="col-md-12" id="messagesout_newcompany"></div>    
    <hr class="clr"/>
    <input type='hidden' name='id' value='<?= $ml_credit_detail_model->id ?>'/>
    <div class="form-group">
        <strong class="col-md-2">Detalle de Gesti&oacute;n:</strong>
        <div class="col-md-10">
            <input class="form-control" id="detail" required="" type="text" name="detail" maxlength="128" value=""  placeholder="Observaciones" /> 
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
                        ->where('status', 1)
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
         <div class="col-md-4" >
    <style>.datepicker{z-index:1200 !important;}</style>
            <input id="datepicker" class="form-control datepicker" onkeydown="return false" data-date-autoclose="true" type="text" name="compromiso_pago_date"  value=""  placeholder="Compromiso Pago" />
            <script type="text/javascript">
                $(function () {
                $('#datepicker').datepicker({
                clearBtn: true,
                todayBtn: true
                });
                $('#datepicker').datepicker('setStartDate', new Date());
                 });
            </script>
        </div>
        <div class="col-md-2">Estado *</div>
        <div class="col-md-4">
<?php
echo $combo_credit_status;
?>
        </div>
    </div>
    
 <div class="form-group">
       <strong class="col-md-2">Tipo de Comision:</strong>
        <div class="col-md-4">
<?php
echo $combo_comision;
?>
        </div>
    </div>    
    <br>    <br>
    <div class="col-md-12">
<?php
$this->load->view('credit_detail_report', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '80', 'show_export' => 0, 'compromiso_pago_date' => '0'));
?>
    </div>
    <hr>
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

<hr class="clr"/>
       <?php
     $this->load->view('credit_hist_report_legal', array('client_id' => $id_cre, 'data_height' => '250', 'show_export' => '0'));
        ?>

<hr class="clr"/>
    <?php
        $this->load->view('credit_hist_notification_creditos', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '250', 'show_export' => '0'));
    ?>  
<hr class="clr"/>
    <?php
        $this->load->view('credit_hist_contact', array('client_id' => $ml_credit_detail_model->id, 'data_height' => '250', 'show_export' => '0'));
    ?> 