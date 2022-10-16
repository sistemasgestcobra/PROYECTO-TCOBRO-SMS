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
   
        
        public function infor_mjs() {
        $res['menu'] = array(
            array('Informacion Mensajes', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('mensajes_report', 'Información de Mensajes', array('id' => $this->user->company_id)),
        );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
    }

    public function envio_report() {
        $res['menu'] = array(
            array('SMS Enviados', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('envio_report', 'Historial de Envios', array('id' => $this->user->company_id)),
        );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
    }
           public function subir_msjs() {
        $res['menu'] = array(
            array('Envio de Mensajes Masivo', 'icon-envelope'),
            array('Envio de Mensajes Personalizado', 'icon-envelope'),
            array('Envio de Mensajes a Bases', 'icon-envelope'),
            array('Cargar Bases/Grupos', 'icon-envelope'),
            array('Administrar Bases', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('mensajes', 'Enviar Mensajes Masivos', array('id' => $this->user->company_id)),
            array('mensajes_1', 'Enviar Mensajes Personalizados', array('id' => $this->user->company_id)),
            array('mensaje_base', 'Enviar Mensajes Personalizados', array('id' => $this->user->company_id)),
            array('grupos', 'Crear Bases y Grupos', array('id' => $this->user->company_id)),
            array('bases_report', 'Administrar Bases', array('id' => $this->user->company_id)),
        );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
    }
        
        
}
