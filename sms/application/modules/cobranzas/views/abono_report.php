
<div class="handsontable" id="example">
    <strong class="">Abonos:</strong>
    <!--<button type="button" id="btn_method_table" data-method="prepend" data-table-name="table_abono"  data-function="getRowNewAbono" class="btn btn-default btn-xs">Nuevo</button>-->    
    <button type="button" id="btn_method_table" data-method="remove" data-table-name="table_abono" class="btn btn-default btn-xs">Remover</button>
    <button type="button" id="btn_method_table" data-method="refresh" data-table-name="table_abono"  class="btn btn-default btn-xs">Reestablecer</button>
    
    <table id="table_abono"
               data-side-pagination="server"
               data-pagination="false"                  
               data-toggle="table_abono"
               data-height="<?php echo $data_height ?>"                                 
               data-url="<?= base_url('cobranzas/abono/get_abono_report/'.$credit_detail_id) ?>"
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
                <th data-field="amount" data-formatter="inputFormatterAmount" data-filter-control="input" >Cantidad</th>
                <th data-field="date_abono" data-formatter="inputFormatterDateAbono"  data-filter-control="input">Fecha Abono</th>
            </tr>
            </thead>
        </table>    
</div>


<script>
    $('[data-toggle="table_abono"]').bootstrapTable();
    
    function getRowNewAbono() {
        var d = new Date();
        var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();        
        var startId = ~~(Math.random() * 100),
                rows = [];
            rows.push({
                id: startId,
                amount: 0,
                date_abono: strDate
            });
        return rows;
    }

       function inputFormatterAmount(index, row) {
           var amount = row['amount'];
           var id = row['id'];
           var abonoId = "<input type='hidden' name='abono_id[]' value='"+id+"'/> ";
           var inputAmount = "<input style='width:100px ' class='positive' name='amount[]' value='"+amount+"'/> ";
           return abonoId+inputAmount;
       }
       function inputFormatterDateAbono(index, row) {
           $('.datepicker_abono').datepicker({format: "yyyy-mm-dd", language: "es"});
           var dateAbono = row['date_abono'];
           var inputAmount = "<input style='width:100px ' class='datepicker_abono' name='date_abono[]' value='"+dateAbono+"'/> ";
           return inputAmount;
       }       
                  
</script>