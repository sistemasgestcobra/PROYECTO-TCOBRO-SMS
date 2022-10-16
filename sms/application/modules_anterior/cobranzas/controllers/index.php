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
                    array( 'Subir Creditos', 'icon-apple')
                );
            $res['content_menu'] = array(
                    array( 'credit_detail_load', 'Subir de creditos vencidos' )
                );
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }        

        public function credit_details($compromiso_pago_date = '0') {
            $notification_format = (new gestcobra\notification_format_model())
                    ->where('company_id',  $this->user->company_id)
                    ->find();
            
            $res['menu'] = array(
                    array('Creditos', 'icon-apple'),    
                    array('Gestion', 'icon-apple'),    
                    array('Comunicaciones', 'icon-apple'),  
                    array('Notificaciones', 'icon-apple'),  
                    array('Historial', 'icon-apple'),
                );
            $res['content_menu'] = array(
                    array('credit_detail_report', 'Gestion de Creditos', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'notification_format'=>$notification_format, 'compromiso_pago_date'=>$compromiso_pago_date) ),
                    array('credit_hist_report', 'Detalle de Gestion de Creditos', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'compromiso_pago_date'=>$compromiso_pago_date )),
                    array('credit_hist_contact', 'Detalle de Clientes contactados', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'compromiso_pago_date'=>$compromiso_pago_date )),
                    array('credit_hist_notification', 'Detalle de Clientes contactados', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'compromiso_pago_date'=>$compromiso_pago_date )),
		    array('credit_hist_report_a', 'Detalle de Gestiones', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'compromiso_pago_date'=>$compromiso_pago_date, 'var'=>"todoHi")),
                );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }
        public function credit_details_filtro($max, $min) {
			$max=  set_post_value('max');
            $min=  set_post_value('min');
            $notification_format = (new gestcobra\notification_format_model())
                    ->where('company_id',  $this->user->company_id)
                    ->find();
            
            $res['menu'] = array(
                    array('Creditos', 'icon-apple'),    
                    array('Gestion', 'icon-apple'),    
                    array('Comunicaciones', 'icon-apple'),  
                    array('Notificaciones', 'icon-apple'),  
                    array('Historial', 'icon-apple'),
                );
            $res['content_menu'] = array(
                    array('credit_detail_report_f', 'Gestion de Creditos', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'notification_format'=>$notification_format,  'max'=>$max , 'min'=>$min) ),
                    array('credit_hist_report', 'Detalle de Gestion de Creditos', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'compromiso_pago_date'=>$compromiso_pago_date )),
                    array('credit_hist_contact', 'Detalle de Clientes contactados', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'compromiso_pago_date'=>$compromiso_pago_date )),
                    array('credit_hist_notification', 'Detalle de Clientes contactados', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'compromiso_pago_date'=>$compromiso_pago_date )),
                    array('credit_hist_report_a', 'Detalle de Gestiones', array('client_id'=>'0', 'data_height'=>'510', 'show_export'=>1, 'compromiso_pago_date'=>$compromiso_pago_date, 'var'=>"todoHi")),
                );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }        		
}
