<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Oficina_company_model extends \CI_Model {
    
    private function _get_oficina_company_filter( $filter = null ) {
        $this -> db -> where ('company_id', $this->user->company_id);
        $this -> db -> where ('status',1);
            if($filter){
                foreach ($filter as $key => $value) {
                    if($key == 'nombre_comercial'){
                        $this -> db -> like ('UPPER(c.nombre_comercial)', strtoupper($value));
                    }
                    else{
                        $this -> db -> where($key,$value);                        
                    }      
                }
            }
            $this -> db -> from('oficina_company o_c');
            $this -> db -> join('company c', 'c.id = o_c.company_id');            
    }
    
    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
        function get_oficina_company_data( $limit, $offset, $filter = null, $order_by = null ) {
            $this->_get_oficina_company_filter($filter);
            $this -> db -> select(
                        'o_c.id, o_c.name, o_c.direccion,o_c.company_id,o_c.status'
                    );
            if($order_by){
                foreach ($order_by as $order => $tipo){
                    $this -> db -> order_by($order, $tipo);        
                }
            }
            $this -> db -> limit($limit, $offset); 
            $query = $this -> db -> get();                  
            $result = $query->result();
            return $result;           
        } 
        
        public function get_oficina_company_count( $filter = null ) {  
            $this->_get_oficina_company_filter($filter);
            return $this->db->count_all_results();    
        }        
}