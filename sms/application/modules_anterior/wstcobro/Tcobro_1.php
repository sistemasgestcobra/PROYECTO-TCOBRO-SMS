<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Books
 *
 * @author cecibel
 */
class Tcobro extends REST_Controller
	{
    public function __construct() {
        parent::__construct();
        ignore_user_abort(true);                
        $this->load->model('tcobro_model');
    }
		public function index_get()
		{
                    //$this->load->model('tcobro_model');
                    $bonos =$this->tcobro_model->get();
			// Display all books
                    if(!is_null($bonos)){
                        $this->response(array('response'=>$bonos),200);
                    }else{
                        $this->response(array('error'=>'No hay usuarios'),404);
                    }
		}
                /**
                 * Busca el detalle de crèdito por el nùmero de pagarè y crea un 
                 * nuevo abono a ese detalle de credito
                 * @param integer $numero_pagare
                 * @param integer $monto
                 * @param date $fecha    2016-07-03
                 */
                public function abono_get($numero_pagare=null,$monto=null,$fecha=null)
		{
                    //$this->load->model('tcobro_model');
                    print_r($numero_pagare);
                    $bonos =$this->tcobro_model->save_abono($numero_pagare,$monto,$fecha);
			// Display all books
                    if(!is_null($numero_pagare)){
                        $this->response(array('response'=>$bonos),200);
                    }else{
                        $this->response(array('error'=>'No hay usuarios'),404);
                    }
		}

		public function find_get($id=null)
		{
                    $bonos =$this->tcobro_model->get($id);
                        if(!is_null($bonos)){
                            $this->response(array('response'=>$bonos),200);
                        }else{
                            $this->response(array('error'=>'No hay usuarios'),404);
                        }
		}
                
                public function add_abono_get($id=null)
		{
                    $bonos =$this->tcobro_model->get($id);
                        if(!is_null($bonos)){
                            $this->response(array('response'=>$bonos),200);
                        }else{
                            $this->response(array('error'=>'No hay usuarios'),404);
                        }
		}     
                
                /**
                 * 
                 */
                public function index_post()
		{
                    /*if(!is_null($this-post('abonos'))){
                        $this->response(null,400);
                    }*/
                    $bonosId= $this->tcobro_model->save($this->post('abono'));
                    if(!is_null($bonosId)){
                        $this->response(array("response"=>$bonosId),200);
                    }else{
                        $this->response(array('error'=>'ha ocurrido un error'),400);
                    }
		}
                /**
                 * registra un abono al numero de pagare ingresado
                 * @param type $numero_pagare
                 * @param type $monto
                 * @param type $fecha
                 */
                public function abonos_post()
		{
                   // $params = json_decode ( file_get_contents ( 'php: // input' ), TRUE );
                    /*$usuario = array ( 
                        'numero_pagare'  => $params['numero_pagare'], 
                        'monto'  => $params['monto'], 
                        'fecha'  => $params['fecha'] 
                    );*/
                    $pagare=$this->input->post($params['numero_pagare']);
                    $monto=$this->input->post($params['monto']);
                    $fecha=$this->input->post($params['fecha']);
                    print_r($fecha);
                    $bonos =$this->tcobro_model->save_abono($pagare,$monto,$fecha);
                    // Display all books
                    if(!is_null($numero_pagare)){
                        $this->response(array('response'=>$bonos),200);
                    }else{
                        $this->response(array('error'=>'ingrese numero de pagare'),404);
                    }
		}
                
                public function index_put()
		{
                    if(!is_null($id)){
                        $this->response(null,400);
                    }
		 $bonos =$this->tcobro_model->get($id);
			// Display all books
                    if(!is_null($bonos)){
                        $this->response(array('response'=>$bonos),200);
                    }else{
                        $this->response(array('error'=>'No hay usuarios'),404);
                    }
// Create a new book
		}
                public function index_delete()
		{
                     if(! is_null($id)){
                        $this->response(null,400);
                    }
                    $delete= $this->tcobro_model->delete($id);
                    if(!is_null($delete)){
                        $this->response(array('bien'=>$bonos),200);
                    }else{
                        $this->response(array('error'=>'No hay usuarios'),404);
                    }
// Create a new book
		}
	}