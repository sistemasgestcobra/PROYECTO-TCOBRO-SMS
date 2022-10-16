<div class="row">
    <div class="widget-container">
        <div class="heading tabs">
            <i class="icon-table"></i>
            Registrar Plantilla
        </div>
        <div class="widget-content padded">
            <form method="post" action="<?= base_url('admin/notificationformat/save') ?>" class="form-horizontal">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
                <input type="hidden" name="id" id="id" value="<?= $id ?>"/>
                <input type="hidden" name="lote" id="lote" value="0"/>
                <?php
                $ml_template = new \gestcobra\notification_format_model($id);
                ?>
                <div class="form-group">
                    <label class="col-md-2">Description</label>
                    <div class="col-md-4">
                        <input type="text" name="template_desc" id="template_desc" value="<?= $ml_template->description ?>" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12">Formato de Notificacion</label>    

                    <?php
                    if ($ml_template->type == 'NOTIFICACION') {
                        ?>
                        <div class="col-md-8">
                            <textarea id="summernote_contract" class="form-control" name="template_data"  style="height: 250px"><?= $ml_template->format ?></textarea>
                        </div>
                        <?php
                    } else if ($ml_template->type == 'MENSAJE') {
                        ?>
                        <div class="col-md-8">
                            <textarea name="template_data" maxlength="400" cols="85" style=" height: 150px"><?= $ml_template->format ?></textarea>
                        </div>    

                        <?php
                    }
                    ?>
                    <div class="col-md-4">
                        <strong> Nombre empresa: &nbsp; </strong>  COMPANY_NAME <br>
                        <strong> Nombre deudor: &nbsp; </strong>  DEUDOR_NAME <br>
                        <?php
                        if ($ml_template->type == 'MENSAJE') {
                            ?>
                            <strong> Nombre de persona: &nbsp; </strong>  NOMBRE_PERSONA  <br>
                            <?php
                        }
                        ?>
                        <strong> Num. Socio: &nbsp; </strong>  SOCIO_NUMERO <br>
                        <strong> Num. Pagaré: &nbsp; </strong>  PAGARE_NUEMERO <br>
                        <strong> Deuda Inicial: &nbsp; </strong>  DEUDA_INICIAL <br>
                        <strong> Saldo actual: &nbsp; </strong>  SALDO_ACTUAL <br>
                        <strong> Fecha Adjudicación: &nbsp; </strong>  FECHA_ADJUDICACION <br>
                        <strong> Cuotas Pagadas: &nbsp; </strong>  CUOTAS_PAGADAS <br>
                        <strong> Cuotas en mora: &nbsp; </strong>  CUOTAS_MORA <br>
                        <strong> Días en mora: &nbsp; </strong>  DIAS_MORA <br>
                        <strong> Total cuotas vencidas: &nbsp; </strong>  TOTAL_CUOTAS_VENCIDAS <br>
                        <strong> Plazo Original: &nbsp; </strong>  PLAZO_ORIGINAL <br>
                        <strong> Fecha Último Pago: &nbsp; </strong>  FECHA_ULTIMO_PAGO <br>
                    </div>   
                </div>
                <button class="btn btn-primary" id="autosubmit_edit_template" data-target="#response_out" >Modificar Formato</button>
                <a class="" href="<?= base_url('admin/index/companyadmin') ?>">Regresar</a>
            </form>        
        </div>
    </div>    
</div>

<div id="response_out"></div>

<script>
    $(document).on("click", "#autosubmit_edit_template", function (e) {
        $("#summernote_contract").val($('#summernote_contract').code());
    });
</script>