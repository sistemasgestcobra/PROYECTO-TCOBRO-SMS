<div class="handsontable" id="example">
        <!--data-detail-formatter="detailFormatter"-->
        <table id="table_sms"
               data-toolbar="#toolbar"
               data-side-pagination="server"
               data-pagination="true"
               data-toggle="table"
               data-height="460"
               data-detail-view="true"     
               data-url="<?= base_url('msjs/credit/get_credit_hist_report')?>"
               data-sort-name="id"
               data-sort-order="desc"
               data-show-refresh="true"
               data-show-toggle="true"
               data-show-columns="true"
               data-show-export="true"
               
        >
            <thead>
                <tr>
                    <th data-field="id" data-visible="false" >ID</th>
                    <th data-field="hist_date" data-sortable="true"><span>Fecha</span></th>
                    <th data-field="hist_time" >Hora</th>
                    <th data-field="detail" >Detalle</th>
                    <th data-field="enviados"  >SMS Enviados</th>
                    <th data-field="excluidos"  >SMS Excluidos</th>
					<th data-field="usuario"  >Remitente</th>
              
                </tr>
            </thead>
        </table>    
</div>