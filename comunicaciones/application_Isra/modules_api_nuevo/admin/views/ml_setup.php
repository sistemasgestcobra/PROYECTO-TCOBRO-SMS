<?php // Change the css classes to suit your needs    
$attributes = array('class' => '', 'id' => '');
echo form_open(base_url('admin/setup/save'), $attributes); 
    
    if(!empty($info_data)){ 
        echo "<input type='hidden' name='id' value='$info_data->id'/>";                                
                    $variable = $info_data->variable;                                
                    $valor = $info_data->valor;                                
                    $detalle = $info_data->detalle;                                
                    $config_by_client = $info_data->config_by_client;
                }else{
                    $variable = '';                                
                    $valor = '';                                
                    $detalle = '';                                
                    $config_by_client = '';                    
                }  
                
                ?>        
<div class="form-group">
        <label class="col-md-3" for="variable">Varialbe <span class="required">*</span></label>
        <?php echo form_error('variable'); ?>
        <div class="col-md-9"><input class="form-control" id="variable" type="text" name="variable" maxlength="25" value="<?php echo set_value('variable',$variable); ?>"  /> </div>
</div>
       
<div class="form-group">
        <label class="col-md-3" for="valor">Valor <span class="required">*</span></label>
        <div class="col-md-9"><input class="form-control" id="valor" type="text" name="valor" maxlength="256" value="<?php echo set_value('valor',$valor); ?>"  /> </div>
</div>
       
<div class="form-group">
        <label class="col-md-3" for="detalle">Detalle</label>
        <div class="col-md-9"><input class="form-control" id="detalle" type="text" name="detalle" maxlength="255" value="<?php echo set_value('detalle',$detalle); ?>"  /> </div>
</div>       

<hr class="clr"/>                        
<p>
        <?php echo form_submit( 'submit', 'Submit', 'id="ajaxformbtn" data-target="messagesout"'); ?>
</p>

<?php echo form_close(); ?>