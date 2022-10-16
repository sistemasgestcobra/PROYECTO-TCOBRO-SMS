<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Index extends MX_Controller {
               
	function __construct()
	{
 		parent::__construct();
                $this->user->check_session(); 
	}	
        
        public function index() {
            $res['menu'] = array(
                    array( 'Empresas', 'icon-apple'),
                );
            $res['content_menu'] = array(
                    array( 'company_report', 'Empresas Registradas' ),
                );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }        
        public function infor_mjs() {
            $res['menu'] = array(
                 array( 'Informacion Mensajes', 'icon-envelope'),
                
                    
                );
            $res['content_menu'] = array(
                    array('mensajes_report', 'Información de Mensajes', array( 'id'=>$this->user->company_id )),                                                
                );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }
        public function envio_report() {
            $res['menu'] = array(
                 array( 'SMS Enviados', 'icon-envelope'),
                
                    
                );
            $res['content_menu'] = array(
                    array('envio_report', 'Historial de Envios', array( 'id'=>$this->user->company_id )),                                                
                );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }
		
        public function subir_msjs() {
            $res['menu'] = array(
                    array( 'Envio de Mensajes Masivo', 'icon-envelope'),
                    
                );
            $res['content_menu'] = array(                
                    array('mensajes', 'Enviar Mensajes Masivos', array( 'id'=>$this->user->company_id )),
                );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }
        public function subir_msjs_mas() {
            $res['menu'] = array(
                    array( 'Envio de Mensajes Personalizado', 'icon-envelope'),
                    
                );
            $res['content_menu'] = array(          
                    array('mensajes_1', 'Enviar Mensajes Personalizados', array( 'id'=>$this->user->company_id )),                              
                );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }
        public function companyadmin() {
            $res['menu'] = array(
                    array( 'Usuarios', 'icon-adjust'),
                    array( 'Estado de credito', 'icon-adjust') ,
                    array( 'Oficinas', 'icon-apple'),                
                    array( 'Notificaciones', 'icon-adjust'),
                    array( 'Compania', 'icon-adjust') ,
                    array( 'Comision Cobranzas', 'icon-adjust') ,
                    //array('Administración Estados del Crédito', 'icon-adjust'),
                );
            $res['content_menu'] = array(
                array('oficial_credito_report', 'Oficiales de Credito', array( 'id'=>$this->user->company_id )),
                array('status_format_report', 'Estado de Crédito', array( 'id'=>$this->user->company_id )) ,
                array('oficina_company_report', 'Oficinas' ),
                array('notification_format_report', 'Formato Notificación y Mensaje', array( 'id'=>$this->user->company_id )),                
                array('ml_company', 'Datos Registrados para la Compania', array( 'id'=>$this->user->company_id )) ,
                array('comisiones_modificar', 'Modificar Comisiones de Cobranzas ', array( 'id'=>$this->user->company_id )) ,
		        //array('status_format_report_1', 'Administración de Estados de Créditos', array('id' => $this->user->company_id))
            );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        } 
}
