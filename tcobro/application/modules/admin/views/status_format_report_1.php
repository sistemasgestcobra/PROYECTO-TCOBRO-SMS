<form method="post" action="<?= base_url('admin/creditstatus/CambioPendiente')?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    
         <div class="form-group">
            <button type="button" reset-form="0" id="autosubmit" class="btn btn-primary pull-right" style="font-size: 15px"><i class="icon-ok"></i>&nbsp;CAMBIO PENDIENTE</button>            
        </div>
    
    <strong>ESTADOS DEL CREDITO: </strong>
    <br>
    <br>
       <?php
        $credit_status_model = (new \gestcobra\credit_status_model())->find();
        $combo_credit_status_model = combobox(
                $credit_status_model, 
                array('value' => 'id', 'label' => 'status_name'), 
                array('class' => 'form-control select2able', 'name' => 'credit_status_model[]', 'multiple' => ''),
                false, '3'
        );
        ?>       
        
        
        <div class="col-md-4">
            <?php echo $combo_credit_status_model ?>
        </div>        
</form>