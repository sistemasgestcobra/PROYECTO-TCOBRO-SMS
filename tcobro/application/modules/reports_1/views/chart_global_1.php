<div id="head_report1" style="display:none">
    <h4>Gestcobra Cia Ltda</h4><br/>
    <strong>Oficial de Credito: </strong> <br/>
    <strong>Fecha: </strong> 25/02/2016<br/>
</div>

<?php
    if( $comparar == 0 AND $search_type == 'date' ){
            ?>
            <table data-head-text="#head_report1" data-graph-height="300" class="highchart" data-graph-container-before="1" data-graph-type="pie" style="display:none" data-graph-datalabels-enabled="1" data-graph-color-1="#999">
              <caption>Reporte de Gestion</caption>
                <thead>
                  <tr>
                      <th>A&ntilde;o-Mes-Dia</th>
                      <th>Totales</th>
                  </tr>
               </thead>
               <tbody>

                <?php
                    $credit_status = (new \gestcobra\credit_status_model())
                            ->where('company_id', $this->user->company_id)
                            ->find();

                    foreach ($credit_status as $value) {
                        $tot_status = new gestcobra\credit_detail_model();
                        $tot_status = $tot_status -> where('curr_date >=', $from_date);
                        $tot_status = $tot_status ->where('curr_date <=', $to_date);
                        $tot_status = $tot_status ->where('credit_status_id', $value->id);
                        /**
                         * Si es un oficial de credito, presenta solo los que le pertenecen
                         */
                        if( $this->user->role_id == 1 ){
                            $tot_status = $tot_status ->where('oficial_credito_id', $this->user->id);
                        }
                        $tot_status = $tot_status->count();
                        
                        echo '<tr>';
                            echo '<td >'.$value->status_name.'</td>';
                            echo '<td data-graph-name="'.$value->status_name.'">'.$tot_status.'</td>';
                        echo '</tr>';
                    }                
                ?>
               </tbody>
            </table>
            <?php
    }
    elseif( $comparar == 0 AND $search_type == 'oficial' ){
            ?>
            <table data-graph-height="300" class="highchart" data-graph-container-before="1" data-graph-type="pie" style="display:none" data-graph-datalabels-enabled="1" data-graph-color-1="#999">
            <caption>Reporte de Gestion</caption>              
                <thead>
                  <tr>
                      <th>A&ntilde;o-Mes-Dia</th>
                      <th>Totales</th>
                  </tr>
               </thead>
               <tbody>

                <?php
                    $credit_status = (new \gestcobra\credit_status_model())
                            ->where('company_id',$this->user->company_id)
                            ->find();
                    foreach ($credit_status as $value) {
                        $tot_status = (new gestcobra\credit_detail_model())
                                ->where('curr_date >=', $from_date)
                                ->where('curr_date <=', $to_date)
                                ->where('oficial_credito_id', $oficial_id)
                                ->where('credit_status_id', $value->id)
                                ->count();
                        
                        echo '<tr>';
                            echo '<td >'.$value->status_name.'</td>';
                            echo '<td data-graph-name="'.$value->status_name.'">'.$tot_status.'</td>';
                        echo '</tr>';
                    }                
                ?>
               </tbody>
            </table>
            <?php        
    }
    elseif( $comparar == 0 AND $search_type == 'agencia' ){
            ?>
            <table data-graph-height="300" class="highchart" data-graph-container-before="1" data-graph-type="pie" style="display:none" data-graph-datalabels-enabled="1" data-graph-color-1="#999">
            <caption>Reporte de Gestion</caption>              
                <thead>
                  <tr>
                      <th>A&ntilde;o-Mes-Dia</th>
                      <th>Totales</th>
                  </tr>
               </thead>
               <tbody>
               <?php
                    $credit_status = (new \gestcobra\credit_status_model())
                            ->where('company_id',$this->user->company_id)
                            ->find();
                    foreach ($credit_status as $value) {
                        $tot_status = (new gestcobra\credit_detail_model())
                                ->where('curr_date >=', $from_date)
                                ->where('curr_date <=', $to_date)
                                ->where('oficina_company_id', $oficina_company_id)
                                ->where('credit_status_id', $value->id)
                                ->count();
                        echo '<tr>';
                            echo '<td >'.$value->status_name.'</td>';
                            echo '<td data-graph-name="'.$value->status_name.'">'.$tot_status.'</td>';
                        echo '</tr>';
                    }                
                ?>
               </tbody>
            </table>
            <?php        
    }