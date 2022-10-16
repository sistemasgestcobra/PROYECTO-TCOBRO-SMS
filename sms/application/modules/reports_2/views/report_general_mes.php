<form method="post" action="<?= base_url('reports/reportes/open_view_reporte_mes') ?>" class="form-horizontal">

    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            
    <input type="hidden" name="oficina_company_id" value="390">
    <fieldset>

        <?php
        $mes_anio = (new gestcobra\month_model())
                ->find();
        $mes_combo = combobox($mes_anio, array('value' => 'id', 'label' => 'month_name'), array('name' => 'mes_id', 'class' => 'form-control select2able'), true);
        $agencias_combo = combobox($agencias, array('value' => 'id', 'label' => 'name'), array('name' => 'oficina_company_id', 'class' => 'form-control select2able'), true);
        ?>      
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Comparativo de Saldo Recuperado y Saldo por Recuperar </h3>
            </div>

            <div class="panel-body">
                <label class="col-md-1 control-label" for="agencia">AGENCIA</label>  
                <div class="col-md-3">
                    <?php
                    echo $agencias_combo;
                    ?>
                </div> 
                <!-- Text input-->
                <label class="col-md-1 control-label" for="mes">MES</label>  
                <div class="col-md-3">
                    <?php
                    echo $mes_combo;
                    ?>
                </div> 

            </div>


            <div class="panel-body">

                <!-- Text input-->

                <input type="hidden" name="comparar" value="<?= $comparar ?>"/>

                <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_recuperacion_mensual" class="btn btn-primary">Ver Tabla</button>

            </div>
            <div class="form-group col-md-1">
            </div>      
        </div>

    </fieldset>
</form>

<div id="chart_recuperacion_mensual">

</div>