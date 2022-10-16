<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of autosuggest
 *
 * @author estebanch
 */
class Printcomprob extends MX_Controller{
    
	function __construct()
	{
		parent::__construct();
                $this->load->library('comprobanteingreso');
	}
    
        function print_comprob_ingreso( $transaction_id, $doc_id ) {
            $this->comprobanteingreso->print_comprob_ingreso($transaction_id, $doc_id);
        }
        
        function print_ch_custodio( $transaction_id, $doc_id ) {
            $this->chequecustodio->print_ch_custodio_by_doc($transaction_id, $doc_id);
        }
        
        function print_voucher_custodio( $transaction_id, $doc_id ) {
            $this->tarjetacustodio->print_voucher_custodio_by_doc($transaction_id, $doc_id);
        }
    
}
