<div class="row">
<?php
    if(ENVIRONMENT === 'development'){
    ?>
        <!--<link rel="stylesheet" type="text/css" href="<?= base_url('resources/FullscreenSlitSlider/css/style.css') ?>"/>-->
    <?php
    } else {
    ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url('resources/FullscreenSlitSlider/css/custom.css') ?>"/>
    <?php
    }
    ?>    

        <div class="hidden-xs">
            <!--<img style="width: 100%; height: 100%" src="<?= base_url('assets/images/slider/3.png')?>" />-->
            <?php
//                $this->load->view('slider');
            ?>            
        </div>
        <div class="hidden-lg hidden-sm">
            <?php
           //      $this->load->view('login_form');
            ?>            
        </div>
        

      <div class="col-md-12 hidden-xs">
          
          <div class="col-md-8">
            <img style="width: 100%; height:400px" src="<?= base_url('assets/images/slider/3.png')?>" />
          </div>      
        <div class="col-md-4">
        <?php
            if(empty($this->user->id)){
            ?>
            
                <!--<div class="col-sm-6 col-md-4 col-md-offset-4">-->
                          <?php
                          if(!empty($_GET['sess'])){
                              if( $_GET['sess'] == 'false'){
                                  echo '<h1 class="text-center login-title"><span class="btn btn-danger">Username/Password Incorrectos!</span></h1>';
                              }                                      
                          }else{
                          }
                          ?>
                    <div class="account-wall">
                        <img class="img-responsive" style="width: 100%" src="<?= base_url('/assets/images/tcobro1.png')  ?>" alt=""/>
                        <form class="form-signin" method="post" action="<?= base_url('checkuser.jsp') ?>">                            
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>"/>                                
                            <input type="text" class="form-control" placeholder="Username or Email" required autofocus name="username">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                            <button class="btn btn-lg btn-default btn-block" type="submit">
                                Acceder</button>
                            <label class="checkbox pull-left">
                                <input type="checkbox" value="remember-me">
                                Remember me
                            </label>
                            <!--<a href="#" class="pull-right need-help">Need help? </a>-->
                            <span class="clearfix"></span>
                        </form>
                    </div>
                <!--</div>-->                                

            <?php
            }else{
                ?>
                
                <div class="account-wall">
                    <img style="width: 100%; height: 148px; margin: 0 auto;" class="img-rounded" src="<?= base_url('uploads/'.$this->user->company_id.'/logo/'.$ml_company->logo) ?>" />            

                        <div class="padded">                     
               <?php
                                $path_profile_image = './uploads/user/'.$this->user->id.'/profile_image/'.$this->user->profile_image;
                                    if (file_exists($path_profile_image)) {
                                        ?>
                                        <img class="img-circle img-responsive center-block" style="width: 150px; height: 150px; margin: 0 auto" src="<?= base_url('uploads/user/'.$this->user->id.'/profile_image/'.$this->user->profile_image) ?>" />
                                        <?php
                                    }else{
                                        ?>
                                        <img class="img-circle img-responsive center-block" style="width: 150px; height: 150px; margin: 0 auto" src="<?= base_url('assets/images/profile_avatar.png') ?>" />
                                        <?php

                                    }
               ?>
                        </div>

                        <!--<div class="col-md-12 user-info" style="color: #333">-->
                            <!--<blockquote>-->
                              <!--<p>-->
                                 Nombre: <?= $this->user->firstname.' '.$this->user->lastname ?><br/>
                              <!--</p>-->
                                 E-mail: <?= $this->user->email ?> 
                            <!--</blockquote>-->
                            <hr class="clr"/>
                            <a class="btn btn-danger btn-block" href="<?= base_url('logout.jsp') ?>"><i class="icon-lock"></i>&nbsp;Cerrar Sesion</a>
                        <!--</div>-->   

                        <?php
                    }
                    ?>                     
                </div>      
    </div>   

    <style>
    #owl-demo .item{
        margin: 3px;
    }
    #owl-demo .item img{
        display: block;
        width: 100%;
        height: 150px;
    }
    </style>

  </div>
</div>    