<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Index extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->user->check_session();
    }

    
    public function infor_mjs() {
        $res['menu'] = array(
            array('Informacion Mensajes', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('mensajes_report', 'Información de Mensajes', array('id' => $this->user->company_id)),
//            array('mensajes_report', 'Informacion de Mensajes', array('id' => $this->user->company_id)),
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
         array('Programar Envio', 'icon-envelope'),
         array('Envio de Correo Masivo', 'icon-envelope'),
     
            );
        $res['content_menu'] = array(
            array('mensajes', 'Enviar Mensajes Masivos', array('id' => $this->user->company_id)),
            array('envio_programado', 'Programa envio de mensajes', array('id' => $this->user->company_id)),
            array('correo', 'Enviar Correos Masivos', array('id' => $this->user->company_id)),
       
            );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
    }

    public function subir_msjs_mas() {
        $res['menu'] = array(
            array('Envio de Mensajes Personalizado', 'icon-envelope'),
              array('Programar Envio', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('mensajes_1', 'Enviar Mensajes Personalizados', array('id' => $this->user->company_id)),
         array('envio_programado', 'Programa envio de mensajes', array('id' => $this->user->company_id)),
        );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
    }

    public function bases() {
        $res['menu'] = array(
            array('Bases/Grupos', 'icon-envelope'),
            array('Administrar Bases', 'icon-envelope'),
            array('Envio de Mensajes a Bases', 'icon-envelope'),
            //array('Programar Envio', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('grupos', 'Crear Bases y Grupos', array('id' => $this->user->company_id)),
            array('bases_report', 'Administrar Bases', array('id' => $this->user->company_id)),
            array('mensaje_base', 'Enviar Mensajes Personalizados', array('id' => $this->user->company_id)),
            //array('mensaje_base_2', 'Programa envio de mensajes', array('id' => $this->user->company_id)),
        );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
    }

    public function bases_1() {
        $res['menu'] = array(
            array('Administrar Bases', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('bases_report', 'Administrar Bases', array('id' => $this->user->company_id)),
        );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
    }

    public function companyadmin() {
        if ($this->user->role_id == 1) {
            $res['menu'] = array(
                array('Notificaciones', 'icon-adjust'),
            );
            $res['content_menu'] = array(
                array('notification_format_report', 'Formato Notificación y Mensaje', array('id' => $this->user->company_id)),
            );
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard', $res, TRUE);
        } else {
            $res['menu'] = array(
                array('Usuarios', 'icon-adjust'),
                array('Estado de credito', 'icon-adjust'),
                array('Oficinas', 'icon-adjust'),
                array('Notificaciones', 'icon-adjust'),
                array('Compania', 'icon-adjust'),
            );
            $res['content_menu'] = array(
                array('oficial_credito_report', 'Oficiales de Credito', array('id' => $this->user->company_id)),
                array('status_format_report', 'Estado de Crédito', array('id' => $this->user->company_id)),
                array('oficina_company_report', 'Oficinas'),
                array('notification_format_report', 'Formato Notificación y Mensaje', array('id' => $this->user->company_id)),
                array('ml_company', 'Datos Registrados para la Compania', array('id' => $this->user->company_id)),
            );

            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard', $res, TRUE);
        }
    }
    
    
    public function tocken(){
            $user = 'DkVkEzqfdJ3nsPX';
            $pass = 'M6eQjmktOC8C9Nv';

        $postUrl = "http://api.login-sms.com/token";
            

            $message = array("client_id" => $user,
                "client_secret" => $pass,
                "grant_type"=>"client_credentials");
            $postDataJson = json_encode($message);
    
    

            $array=array("Content-type: application/json",
		              "Accept: application/json");
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$array);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);

            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
    }

}
