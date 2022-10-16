<form method="post" action="<?= base_url('admin/creditstatus/CambioPendiente')?>" class="form-horizontal">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    
         <div class="form-group">
            <button type="button" reset-form="0" id="autosubmit" class="btn btn-primary pull-right" style="font-size: 15px"><i class="icon-ok"></i>&nbsp;CAMBIO PENDIENTE</button>            
        </div>
    
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
<script>
    
    //data-detail-formatter="editTemplate"   
    $('[data-toggle="table"]').bootstrapTable();
    var table_credit_status = $('#table_credit_status'),
        $credit_status = $('#button_credit_status');
    $(function () {
        $credit_status.click(function () {
            var randomId = 100 + ~~(Math.random() * 100);
            table_credit_status.bootstrapTable('prepend', {
                index: 1,
                row: {
//                    id: randomId,
//                    name: 'Item ' ,
//                    price: '$'
                }
            });
        });
    });    
    
    function inputFormatterStatus(index, row) {
       var id = row['id'];
       var status_name = row['status_name'];
       var inputId = "<input type='hidden' class='' name='id[]' value='"+id+"'/> ";           
       var inputDescription = "<input required='' style='min-width:200px' class='' name='status_name[]' value='"+status_name+"'/> ";
       return inputId+inputDescription;
    }
    
    function inputFormatterColor(index, row) {
       var description = row['color'];
       var inputDescription = "<input required='' style='min-width:200px' class='' name='color[]' value='"+description+"'/> ";
       //alert(description);
       return inputDescription;
    }
    
    function inputFormatterBackground(index, row) {
        var description = row['background'];
        var inputDescription = "<input required='' style='min-width:200px' class='' name='background[]' value='"+description+"'/> ";
        return inputDescription;
    }
                 
</script>