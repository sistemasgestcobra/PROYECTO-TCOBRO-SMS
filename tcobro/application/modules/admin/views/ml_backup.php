<div class="row">
    <div class="widget-container">
        <div class="widget-content padded text-center">
            <div class="col-md-4">
                <form action="<?= base_url('admin/backup/back_all_database') ?>" method="post" class="form-horizontal">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    <button class="btn btn-primary"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;Respaldar Base de datos Completa</button>
                </form>                
            </div>
            
            <div class="col-md-4">
                <form action="<?= base_url('admin/backup/back_client_database') ?>" method="post" class="form-horizontal">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    <button class="btn btn-primary"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;Respaldar Informacion Basica</button>
                </form>                
            </div>          

            <div class="col-md-4">
                <form action="<?= base_url('admin/backup/download_all_backups') ?>" method="post" class="form-horizontal">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    <button class="btn btn-primary"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;Descargar Todos los Respaldos</button>
                </form>                
            </div>          
            
        </div>
    </div>
   
</div>