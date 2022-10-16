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

    public function index() {
        $res['menu'] = array(
            array('Empresas', 'icon-apple'),
        );
        $res['content_menu'] = array(
            array('company_report', 'Empresas Registradas'),
        );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
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

    public function subir_msjs() {
        $res['menu'] = array(
            array('Envio de Mensajes Masivo', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('mensajes', 'Enviar Mensajes Masivos', array('id' => $this->user->company_id)),
        );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
    }

    public function subir_msjs_mas() {
        $res['menu'] = array(
            array('Envio de Mensajes Personalizado', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('mensajes_1', 'Enviar Mensajes Personalizados', array('id' => $this->user->company_id)),
        );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard', $res, TRUE);
    }

    public function bases() {
        $res['menu'] = array(
            array('Bases/Grupos', 'icon-envelope'),
            array('Administrar Bases', 'icon-envelope'),
            array('Envio de Mensajes a Bases', 'icon-envelope'),
        );
        $res['content_menu'] = array(
            array('grupos', 'Crear Bases y Grupos', array('id' => $this->user->company_id)),
            array('bases_report', 'Administrar Bases', array('id' => $this->user->company_id)),
            array('mensaje_base', 'Enviar Mensajes Personalizados', array('id' => $this->user->company_id)),
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

}
