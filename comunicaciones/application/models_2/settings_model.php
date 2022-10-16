<?php

class Settings_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
/******************************************************************************/
       
        /* Se obtienen el numero de decimales configurado para el sistema */
        function getNumDecimales( $var ) {
            $this -> db -> where('variable', $var);        
            $this -> db -> select(
                        'valor'
                    );
            $this -> db -> from('ml_setup');          
            $query = $this -> db -> get();            
            return $query->row()->valor;           
        }
        
}