<div class="container-fluid main-nav clearfix">
    <div class="nav-collapse">
        <ul class="nav">
            <?php
//                      echo $this->user->id;
            ?>
            <a class="current"  href="<?= base_url('/uploads/20/ejemplos') ?>" target="blank"><span aria-hidden="true" class="glyphicon glyphicon-book"></span>EJEMPLOS</a><li>
                <a class="current" href="<?= base_url() ?>"><span aria-hidden="true" class="glyphicon glyphicon-upload"></span>Inicio</a>
            </li>
            <li class="dropdown"><a data-toggle="dropdown" href="#">
                              <span aria-hidden="true" class="glyphicon glyphicon-earphone"></span>Creditos</a>
                             <ul class="dropdown-menu">
                               
                                <li>
                                  <a href="<?= base_url('infor_mjs.jsp') ?>"><span aria-hidden="true" class="glyphicon glyphicon-envelope"></span>Infomaci&oacute;n Mensajes</a>
                                </li>
                                <li>
                                  <a href="<?= base_url('envio_report.jsp') ?>"><span aria-hidden="true" class="glyphicon glyphicon-envelope"></span>Historial de Mensajes</a>
                                </li>
                              
                             </ul>
                        </li>



            <li>              
                <a class="current" href="<?= base_url('subir_msjs.jsp') ?>"><span  class="glyphicon glyphicon-earphone"></span>Mensajes Masivos</a>
            </li>
<!--            <li>              
                <a class="current" href="<?= base_url('subir_msjs_mas.jsp') ?>"><span aria-hiddencredit_details.jsp="true" class="glyphicon glyphicon-earphone"></span>Mensajes Masivos Personalizados</a>
            </li>							-->
            <li>              
                <a class="current" href="<?= base_url('bases.jsp') ?>"><span class="glyphicon glyphicon-earphone"></span>Bases/Grupos</a>
            </li>


<?php
/**
 * Si es gerente o si es superusuario
 */
if ($this->user->role_id == 3 OR $this->user->role_id == 100) {
    ?>

                <?php
            }
            if ($this->user->role_id == 100) {
                ?>                        
                <li>
                    <a href="<?= base_url('admin.jsp') ?>"><span aria-hidden="true" class="glyphicon glyphicon-upload"></span>Empresas</a>
                </li>                        
    <?php
}
if ($this->user->role_id == 1) {
    ?> 
                <li class="dropdown"><a data-toggle="dropdown" href="#">
                        <span aria-hidden="true" class="glyphicon glyphicon-stats"></span>Reportes</a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= base_url('reports/report_agencia.jsp') ?>">Gesti&oacute;n Por Malla</a>
                        </li>
                        <li>
                            <a href="<?= base_url('reports/report_notificaciones.jsp') ?>">Reporte de Notificaciones de Campo</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="current" href="<?= base_url('companyadmin.jsp') ?>"><span aria-hidden="true" class="icon-gears"></span>Notificaciones</a>
                </li>
    <?php
}
?> 
        </ul>
    </div>
</div>