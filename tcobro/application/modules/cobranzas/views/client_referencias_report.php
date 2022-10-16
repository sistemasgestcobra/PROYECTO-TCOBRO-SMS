
<div class="handsontable" id="example">
    <strong class="">Garantes:</strong>

    <table id="table_referencias"
               data-side-pagination="server"
               data-pagination="false"                  
               data-toggle="table_referencias"
               data-height="<?php echo $data_height ?>"
               data-url="<?= base_url('cobranzas/referencias/get_referencias_client/'.$client_id) ?>"
               data-sort-name="id"
               data-sort-order="desc"              
               <?php
                if( $show_export == 1 ){
                ?>
                    data-detail-view="true"               
                    data-show-refresh="true"
                    data-show-toggle="true"
                    data-show-columns="true"                 
                    data-show-export="true"
                    data-filter-control="true"              
                    data-resizable="true"                      
                <?php
                }
               ?>               
        >   
            <thead>
                <!--c.fecha, p.nombres, p.apellidos, p.direccion, p.email, p.telefonos, p.celular-->
            <tr>
                <th data-field="id" data-checkbox="true"></th>
                <th data-field="reference_name" data-formatter="formatReferenceType" data-filter-control="input" >Tipo</th>
                <th data-field="firstname" data-formatter="inputFormatterFirstname" data-filter-control="input">Nombres</th>
                <th data-field="personal_address" data-formatter="inputFormatterPersonalAddress" data-filter-control="input">Direccion</th>
            </tr>
            </thead>
        </table>    
</div>


<script>
    $('[data-toggle="table_referencias"]').bootstrapTable();   
    

       function inputFormatterFirstname(index, row) {
           var firstname = row['firstname'];
           var refId = row['ref_id'];
           var inputId = "<input type='hidden' name='ref_ids[]' value='"+refId+"'/> ";
           var inputDetail = "<input type='text' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+firstname+"' style='width:100px ' name='ref_firstname[]' value='"+firstname+"'/> ";
           return inputId+inputDetail;
       }
      
       function inputFormatterPersonalAddress(index, row) {
           var personal_address = row['personal_address'];
           var inputDetail = "<input type='text' rel='txtTooltip' data-toggle='tooltip' data-placement='bottom' title='"+personal_address+"' style='width:100px ' name='ref_personal_address[]' value='"+personal_address+"'/> ";
           return inputDetail;
       }
       
       function formatReferenceType(index, row) {
           var reference_type_id = row['ref_type_id'];
           var selected = '';
           var role = "<select class=' select2able' name='reference_type_id[]'>";
           <?php
        $reference_type = (new \gestcobra\reference_type_model())->find();                       
        foreach ($reference_type as $value) {
            ?>
                    if(reference_type_id == <?= $value->id ?>){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    role += "<option "+selected+" value='<?= $value->id ?>'><?= $value->reference_name ?></option>";
            <?php
        }
           ?>
           role += "<select>";                
           return role;
       }     
       
    function getRowNewRef() {
        var startId = ~~(Math.random() * 100),
                rows = [];
            rows.push({
                id: startId,
                firstname: '',
                lastname: '',
                personal_phone: '',
                personal_mobile: '',
                personal_address: '',
            });
        return rows;
    }       
                  
</script>