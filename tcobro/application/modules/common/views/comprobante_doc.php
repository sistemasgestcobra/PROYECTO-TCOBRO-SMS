<div class="col-xs-2">
        <div class="sparkline-dashboard" id="sparkline-1"></div>
        <div class="sparkline-dashboard-info">
                <i class="fa fa-print" style="font-size: 40px"></i>
                <span><a id="printbtn" data-target="comprobante_print" class="txt-primary" href="#">IMPRIMIR</a></span>
        </div>
</div>

<div class="col-md-12" id="comprobante_print" style="font-family: monospace">    
    <label style="font-size: 18px" class="page-header">
        COMPROBANTE No. <?= $comprobante_data->current_date.'-'.str_pad($comprobante_data->id, 11, '0', STR_PAD_LEFT) ?> | <?= $comprobante_data->current_date ?>
        <label class="col-md-12">Tipo: <?= $comprobante_data->transaction_name ?></label>                
    </label>    
    <br class="clr"/>
    <label class="col-md-6">Asiento. Nro.: <?= $asiento_data->anio.'-'.str_pad($asiento_data->id, 11, '0', STR_PAD_LEFT) ?></label>
    <div class="col-md-6">F/H Asiento: <?= $asiento_data->fecha.' / '.$asiento_data->hora ?></div>    
    
    <table class="table table-striped table-condensed">
        <tr>
            <th>Cod. Contable</th>
            <th>Debito</th>
            <th>Credito</th>
        </tr>
        <?php
            foreach ( $asiento_data->detail as $value ) {
                echo '<tr>';
                    echo '<td>'.$value->cuenta_cont_id.' '.$value->nombre.'</td>';
                    echo '<td>'.$value->debito.'</td>';
                    echo '<td>'.$value->credito.'</td>';
                echo '</tr>';
            }
        ?>
    </table>
    <div class="col-md-12">TOTAL: <?= number_decimal($comprobante_data->total_fact, 2) ?> (<?= $this->number_letter->convert_to_letter($comprobante_data->total_fact,'') ?>)</div>
    <div class="col-md-12">Observaciones: <?= $comprobante_data->observaciones ?></div>
    
    <hr class="clr"/>
    <div class="col-md-4">Usuario: <?= $this->user->nombres ?></div>
    <div class="col-md-4">Cliente: <?= $comprobante_data->nombres.' '.$comprobante_data->apellidos ?></div>
    <div class="col-md-4">F/H Imp.: <?= date('Y-m-d',time() ).'/'.date('H:i:s',time() ) ?></div>
</div>