<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comision_model extends \CI_Model {
    
    private function _get_filter( $filter = null ) {
        $this -> db -> where ('c_c.company_id', $this->user->company_id);
        $this -> db -> where ('c_c.status', '1');
            if($filter){
                foreach ($filter as $key => $value) {
                    if($key == 'nombre_comision'){
                        $this -> db -> like ('UPPER(c_c.nombre_comision)', strtoupper($value));
                    }if($key == 'valor_comision'){
                        $this -> db -> like ('UPPER(c_c.valor_comision)', strtoupper($value));
                    } else{
                        $this -> db -> where($key,$value);                        
                    }      
                }
            }
            $this->db->from('comision_cobranzas c_c');
    }
    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
        function get_data( $limit, $offset, $filter = null, $order_by = null ) {

            $this->_get_filter($filter);
            $this -> db -> select(
                        'c_c.id, c_c.nombre_comision, c_c.valor_comision'
                    );
            
            if($order_by){
                foreach ($order_by as $order => $tipo) {
                    $this -> db -> order_by($order, $tipo);        
                }
            }
                $this -> db -> limit($limit, $offset); 
                $query = $this -> db -> get();                  
            $result = $query->result();
            return $result;           
        } 
        
        public function get_count( $filter = null ) {  
            $this->_get_filter($filter);
            return $this->db->count_all_results();    
        }        
        
}