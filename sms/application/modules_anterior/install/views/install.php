
<div class="row">
    
    <div class="widget-container">
            <div class="heading tabs">
            <i class="icon-adjust"></i>
            INSTALACION DE GESINCOB
            </div>        
        <div class="widget-content padded">
            <?php if(is_writable($db_config_path)){?>

                          <?php if(isset($message)) {echo '<p class="error">' . $message . '</p>';}?>

            <form class="form-horizontal" id="install_form" method="post" action="<?php echo base_url('install.jsp') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">        
                <fieldset>
                  <legend>Configuracion de la Base de Datos</legend>
                  <div class="form-group">
                      <label for="hostname" class="col-md-2">Hostname</label>
                      <div class="col-md-10">
                        <input type="text" id="hostname" value="localhost" class="form-control" name="hostname" />                                
                      </div>
                  </div>
                  <div class="form-group" >
                    <label for="username" class="col-md-2">Username</label>
                    <div class="col-md-10">
                        <input type="text" id="username" class="form-control" name="username" />                              
                    </div>
                  </div>  
                  <div class="form-group">
                    <label for="password" class="col-md-2">Password</label>
                    <div class="col-md-10">
                        <input type="password" id="password" class="form-control" name="password" />                              
                    </div>            
                  </div>
                  <div class="form-group">
                    <label for="database" class="col-md-2">Database Name</label>
                    <div class="col-md-10">
                        <input type="text" id="database" class="form-control" name="database" />                              
                    </div>            
                  </div>          
                  <input type="submit" value="Crear Base de Datos" id="submit" class="btn btn-success pull-right"/>
                </fieldset>
            </form>

                  <?php } else { ?>
              <p class="error">Please make the application/config/database.php file writable. <strong>Example</strong>:<br /><br /><code>chmod 777 application/config/database.php</code></p>
                  <?php } 
                  ?>            
        </div>
    </div>
</div>
