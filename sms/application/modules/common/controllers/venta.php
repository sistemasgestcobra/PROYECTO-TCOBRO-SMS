<?php

class Venta extends MX_Controller{
    
	function __construct(){
		parent::__construct();
                $this->load->model('venta_model');
                $this->load->library('encript');
	}
    
        function autosuggest_by_nro_sri($transaction_id) {   
            $nro_sri = $this->input->get('q');            
            $res = $this->venta_model->autosuggest_by_nro_sri($nro_sri, $transaction_id);
            if(!empty($res)) {
                echo json_encode($res);
            } else {
            }
        }
     
    /**** Vista del Comprobante Ingreso/Egreso ****/
        public function open_fact( $venta_id, $print = 0 ) {
            openModal(base_url('common/venta/fact_view/'.$venta_id.'/'.$print), 'Factura', '', 'lg');
        }
        
    /* Abrir factura */
    public function fact_view($venta_id, $print = 0) {
        $this-> load->model('common/venta_model');
        $this-> load->library('common/company');
        
        $res['fact_info'] = $this-> venta_model->get_venta_info( $venta_id );
        
        $obj_company = new Company();        
        $res['empresa'] = new \marilyndb\ml_company_model($this-> user->empresa_id);
        $res['empresa']->ruc = $obj_company->get_clear_ruc($res['empresa']->ruc);
        
        $res['print'] = $print;        
        
        $this-> load->view('common/comprobantes/sricomprob_print', $res);        
    }        
}
