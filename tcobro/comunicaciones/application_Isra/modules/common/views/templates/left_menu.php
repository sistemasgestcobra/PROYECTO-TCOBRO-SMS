<?php
/**
 * Example: Call from controller
 *  
 *         public function index() {
            $res['menu'] = array( 
                    array( 'icon-adjust', 'Configuracion') ,
                    array( 'icon-apple', 'Privilegios') ,
                    array( 'icon-apple', 'Database') 
                );
            $res['content_menu'] = array(
                    array( 'Configuracion', 'settingsreport') ,
                    array( 'Privilegios', 'user_permissions') ,
                    array( 'Database', 'ml_backup')
                );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }
 */
?>

        <!--<div class="col-md-12   bhoechie-tab-container-fluid">-->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 bhoechie-tab-menu">
                <div class="list-group" >
                  <?php
                  $active = 'active';
                  foreach ($menu as $value) {
                        $icon = $value[1];
                        ?>
                            <a href="#" class="list-group-item <?= $active ?> text-center" style="border-bottom: solid 1px #ded">
                                <br/>
                              <h4 class="<?= $icon ?>"></h4><br/><?= $value[0] ?>
                            </a>                  
                        <?php
                        $active = '';
                    }
                  ?>
              </div>
            </div>
            <div class="col-lg-11 col-md-11 col-sm-10 col-xs-12 bhoechie-tab">
                  <?php
                  $active = 'active';
                  //print_r($content_menu);
                  foreach ($content_menu as $key => $value) {
                        ?>
                            <div class="bhoechie-tab-content <?= $active ?>">
                                <div class="widget-container">
                                    <div class="heading tabs">
                                    <i class="icon-table"></i>
                                    <?= $value[1] ?>
                                    </div>                                        
                                    <div class="widget-content padded">
                                        <?php 
                                        $view_params = '';
                                        if(!empty($value[2])){
                                            $view_params = $value[2];
                                        }
                                            $this->load->view( $value[0], $view_params );
                                        ?>                                            
                                    </div>
                                </div>
                           </div>
                        <?php
                        $active = '';
                    }
                  ?>
            </div>
        </div>