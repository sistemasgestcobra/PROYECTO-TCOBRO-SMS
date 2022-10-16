<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Gproduct extends MX_Controller {
               
	function __construct()
	{
 		parent::__construct();
                $this->user->check_session();                                
                $this->load->model('gproduct_model');                
	}	
        
        /* Mostrar sugerencias al buscar producto por nombre o codigo */
        function autosuggest_product( $measure_id = 0) {
            $q = $this->input->get('q');            
            $res = $this->gproduct_model->autosuggest_product($q, $measure_id);
            if(!empty($res)) {
                echo json_encode($res);
            } else {
            }
        }

}