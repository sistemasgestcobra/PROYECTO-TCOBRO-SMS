        <div class="container-fluid main-nav clearfix">
          <div class="nav-collapse">
            <ul class="nav">
                <?php
                // METODO PARA CONTAR DIAS DE MORA Y VENCIDA
            

//                      echo $this->user->id;
                        ?>
                 <a class="current"  href="<?= base_url('/uploads/20/ejemplos')?>" target="blank"><span aria-hidden="true" class="glyphicon glyphicon-book"></span>EJEMPLOS</a><li>
                              <a class="current" href="<?= base_url()?>"><span aria-hidden="true" class="glyphicon glyphicon-upload"></span>Inicio</a>
                            </li>
							<li>              
                               <a class="current" href="<?= base_url('subir_msjs.jsp')?>"><span aria-hiddencredit_details.jsp="true" class="glyphicon glyphicon-earphone"></span>Mensajes Masivos</a>
                            </li>
							<li>              
                               <a class="current" href="<?= base_url('subir_msjs_mas.jsp')?>"><span aria-hiddencredit_details.jsp="true" class="glyphicon glyphicon-earphone"></span>Mensajes Masivos Personalizados</a>
                            </li>
                            <li class="dropdown"><a data-toggle="dropdown" href="#">
                              <span aria-hidden="true" class="glyphicon glyphicon-stats"></span>Reportes</a>
                              <ul class="dropdown-menu">
                                  <li>
                                  <a href="<?= base_url('infor_mjs.jsp') ?>">Creditos Disponibles</a>
                                  </li>
                                  <li>
                                  <a href="<?= base_url('envio_report.jsp') ?>">SMS enviados</a>
                                  </li>
                              </ul>
                        </li>
                        <?php
                    
              /**
               * Si es gerente o si es superusuario
               */
              if( $this->user->role_id == 3 OR $this->user->role_id == 100 ){
                  ?>
                        
                  <?php                  
              }
              if( $this->user->role_id == 100 ){
                  ?>                        
                        <li>
                          <a href="<?= base_url('admin.jsp')?>"><span aria-hidden="true" class="glyphicon glyphicon-upload"></span>Empresas</a>
                        </li>                        
                  <?php
              }
              if( $this->user->role_id == 1 ){
                    ?> 
                        
                            
                        <li>
                            <a class="current" href="<?= base_url('companyadmin.jsp') ?>"><span aria-hidden="true" class="icon-gears"></span>Notificaciones</a>
                        </li>
                    <?php
                        }  
                    ?> 
            </ul>
          </div>
        </div>