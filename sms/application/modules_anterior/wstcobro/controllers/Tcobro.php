<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

/**
 * @author cecibel
 */
class Tcobro extends REST_Controller
	{
    public function __construct() {
        parent::__construct();
        ignore_user_abort(true);
        $this->load->model('tcobro_model');
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
}