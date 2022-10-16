        <div class="login1 widget-content padded" style="z-index: 9999999">
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
                            <button class="btn btn-lg btn-primary-outline btn-block" type="submit">
                                Acceder</button>
<!--                            <label class="checkbox pull-left">
                                <input type="checkbox" value="remember-me">
                                Remember me
                            </label>-->
                            <!--<a href="#" class="pull-right need-help">Need help? </a>-->
                            <span class="clearfix"></span>
                        </form>
                    </div>
                <!--</div>-->                                

            <?php
            }else{
                ?>
                    <img style="width: 100%; height: 148px; margin: 0 auto;" class="img-rounded" src="<?= base_url('uploads/'.$this->user->company_id.'/logo/'.$ml_company->logo) ?>" />            

                <div class="padded">                     
       <?php
                        $path_profile_image = './uploads/user/'.$this->user->id.'/profile_image/'.$this->user->profile_image;
                            if (file_exists($path_profile_image)) {
                                ?>
                                <img class="img-circle img-responsive center-block" style="width: 150px; height: 150px; float: left; margin-right: 5px" src="<?= base_url('uploads/user/'.$this->user->id.'/profile_image/'.$this->user->profile_image) ?>" /><?= $this->user->firstname ?><b class="caret"></b></a>
                                <?php
                            }else{
                                ?>
                                <img class="img-circle img-responsive center-block" style="width: 150px; height: 150px; float: left; margin-right: 5px" src="<?= base_url('assets/images/profile_avatar.png') ?>" /><?= $this->user->firstname ?><b class="caret"></b></a>
                                <?php
                                
                            }
       ?>
                </div>'
       
                <div class="col-md-12 user-info" style="color: #333">
                    <!--<blockquote>-->
                      <p>
                         <?= $this->user->firstname.' '.$this->user->lastname ?>
                      </p>
                      <small >E-mail: <?= $this->user->email ?></small>
                    <!--</blockquote>-->
                    <hr class="clr"/>
                    <a class="btn btn-danger btn-block" href="<?= base_url('logout.jsp') ?>"><i class="icon-lock"></i>&nbsp;Cerrar Sesion</a>
                </div>   

                <?php
            }
            ?>                                     
        </div>   