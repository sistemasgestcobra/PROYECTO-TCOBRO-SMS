<?php

class Setup_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

        function get_setup_data( $limit, $offset, $whereData = null, $order_by = null ) {            
            if($whereData){
                foreach ($whereData as $key => $value) {
                    $this -> db -> where($key,$value);        
                }
            }

            $this -> db -> select(
                        's.id, s.variable, s.valor, s.detalle'
                    );

            $this -> db -> from('ml_setup s');            
            
            if($order_by){
                foreach ($order_by as $order => $tipo) {
                    $this -> db -> order_by($order, $tipo);        
                }
            }
                $this -> db -> limit($limit, $offset); 
                $query = $this -> db -> get();            
            return $query->result();           
        }
        
        
        function getPermissionsData( $limit, $offset, $whereData = null, $order_by = null ) {            
            if($whereData){
                foreach ($whereData as $key => $value) {
                    $this -> db -> where($key,$value);        
                }
            }

            $this -> db -> select(
                        'p.capacidad, p.descripcion, p.is_active, p.ubicacion, p.acceso'
                    );

            $this -> db -> from('ml_privilege p');            
            
            if($order_by){
                foreach ($order_by as $order => $tipo) {
                    $this -> db -> order_by($order, $tipo);        
                }
            }
                $this -> db -> limit($limit, $offset); 
                $query = $this -> db -> get();            
            return $query->result();           
        }        
        
}