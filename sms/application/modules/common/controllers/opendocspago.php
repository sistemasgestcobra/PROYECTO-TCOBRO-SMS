<?php


class Opendocspago extends MX_Controller{
    
	function __construct()
	{
		parent::__construct();
                $this->load->library('asientocontable');
	}   
        
        public function add_cheque_pago($module,$view_cheque) {
          $res['bancos_list'] = (new \marilyndb\ml_bank_account_model())->find();
          $this->load->view($module.'/'.$view_cheque,$res);
        }
        
        public function add_deposito_pago($module,$view_deposito) {
          $res['bancos_list'] = (new \marilyndb\ml_bank_account_model())->find();
          $this->load->view($module.'/'.$view_deposito,$res);
        }
    
}
