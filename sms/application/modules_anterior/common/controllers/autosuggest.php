<?php

class Autosuggest extends MX_Controller{
    
	function __construct(){
		parent::__construct();
	}
    
        /**
         * 
         * @description Obtiene autosugerencias de mes, por nombre o por codigo
         */
        function get_mes( $row_id = 0 ) {
            $param = $this->input->get('q');
            $this->load->model('mes_model');
            $res = $this->mes_model->get_mes_autosuggest($param, $row_id);
            if(!empty($res)) {
                    echo json_encode($res);
            } else {
            }
        }
        
        function get_plan_cuentas_by_name( $row_id, $start_with = '' ) {
            $param = $this->input->get('q');
            $this->load->model('accountsplan_model');
            $res = $this->accountsplan_model->get_plan_cuentas_by_name($param, $row_id, $start_with);
            if(!empty($res)) {
                    echo json_encode($res);
            } else {
            }
        }

        function get_plan_cuentas_like_right_cod( $param ) {            
            $this->load->model('accountsplan_model');
            $res = $this->accountsplan_model->get_plan_cuentas_like_right_cod($param);
            if(!empty($res)) {
                    echo json_encode($res);
            } else {
            }
        }
                
        function get_client_by_name() {
            $this->load->model('client_model');            
            $this->load->library('common/accountcompany');            
            $param = $this->input->get('q');
                $res = $this->client_model->autosugest_by_name($param);                
                
                if(!empty($res)) {
                        echo json_encode($res);
                } else {
                        echo '{"id":"--","name":"No hay resultados para '.$param.'"}';
                }                
//            } 
        }
               
}
