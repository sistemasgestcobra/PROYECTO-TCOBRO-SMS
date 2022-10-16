<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <?php
        $ml_company = new \gestcobra\company_model($this->user->company_id);
    ?>     
    <title>
      TCobro - Sistema de Gestion de Cobranzas
    </title>
    
    <link href="//fonts.googleapis.com/css?family=Lato:100,300,400,700" media="all" rel="stylesheet" type="text/css" />    
    <?php

        if(ENVIRONMENT === 'development'){
            $this->assetic->writeCssLinks();            
        } else {
            $this->assetic->writeStaticCssLinks();
        }
?>
 
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
  </head>
  <body>
    <input type="hidden" id="sec_csrf_token" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <input type="hidden" name="main_path" id="main_path" value="<?= base_url() ?>"/>                  
    <span id="messagesout"></span>    
        <?php    
                if(ENVIRONMENT === 'development'){
                    $this->assetic->writeJsScripts();
                }else{
                    $this->assetic->writeStaticJsScripts();
                }                                
        ?>      
    
    <div class="modal-shiftfix">
        
        <?php
          if( $this->user->id > 0 ){
            ?>
                <!-- Navigation -->
                <div class="navbar navbar-fixed-top scroll-hide">
                  <div class="container-fluid top-bar">
          <!--          <div class="pull-left hidden-xs">
                        <a href="<?= base_url() ?>"><img width="332px" height="93px" src="<?= base_url('/uploads/logo/logo.png')  ?>" /></a>
                    </div>-->
                      <?php
                      if( $this->user->id > 0 ){
                          ?>
                              <div class="pull-right">                                  
                                <img width="150" height="60" src="<?= base_url('uploads/'.$this->user->company_id.'/logo/'.$ml_company->logo ) ?>" />
                                <ul class="nav navbar-nav pull-right">
                                  <!-- user o settings -->
<!--                                  <li class="dropdown user hidden-xs">
                                      <a data-toggle="dropdown" class="dropdown-toggle" href="#" id="company_label">
                                          <img width="100" height="100" src="<?= base_url('uploads/'.$this->user->company_id.'/logo/'.$ml_company->logo ) ?>" /><strong class="text-info"><?= $ml_company->nombre_comercial ?></strong>
                                      </a>
                                  </li>              -->
                                  <li class="dropdown user hidden-xs"><a data-toggle="dropdown" class="dropdown-toggle" href="#">

                                  <?php
                                  $path_profile_image = './uploads/user/'.$this->user->id.'/profile_image/'.$this->user->profile_image;
                                      if (file_exists($path_profile_image)) {
                                          ?>
                                          <img width="60" height="60" src="<?= base_url('uploads/user/'.$this->user->id.'/profile_image/'.$this->user->profile_image) ?>" /><?= $this->user->firstname ?><b class="caret"></b></a>
                                          <?php
                                      }else{
                                          ?>
                                          <img width="60" height="60" src="<?= base_url('assets/images/profile_avatar.png') ?>" /><?= $this->user->firstname ?><b class="caret"></b></a>
                                          <?php

                                      }                         
                                  ?>

                                    <ul class="dropdown-menu">
                                      <li><a href="<?= base_url('editprofile.jsp') ?>">
                                        <i class="icon-gear"></i>Configuracion</a>
                                      </li>
                                      <li><a href="<?= base_url('logout.jsp') ?>">
                                        <i class="icon-signout"></i>Salir</a>
                                      </li>
                                    </ul>
                                  </li>
                                </ul>
                              </div>            
                          <?php
                      }
                      ?>

                    <button class="navbar-toggle">
                        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button>

                      <!--<form class="navbar-form form-inline col-lg-2 hidden-xs">-->
                          <!--<i>Sistema De Administracion Empresarial</i>-->                                
                          <!--<img class="img-responsive"  style="height: 35px; " src="<?php //echo base_url('uploads/'.$this->user->company_id.'/logo/'.$ml_company->logo ) ?>"/>-->
                         <!--<label style="font-weight: bold"><?php // get_settings('SYSTEM_NAME')?></label>-->
                      <!--<input class="form-control" placeholder="Search" type="text">-->
                      <!--</form>--> 

                  </div>
                    <?php
                    if( $this->user->id > 0 ){
                      $this->load->view('main_nav');
                    }
                    ?>
                </div>
                <!-- End Navigation -->
            <?php                    
          }

//        echo $view_name;
        $res_tpl['ml_company'] = $ml_company;
        echo $this->load->view($view_name, $res_tpl, TRUE);
      ?>
    </div>
  </body>

</html>