<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos_model extends \CI_Model {
    
    private function _get_oficina_company_filter( $filter = null ) {
        //$this -> db -> where ('b.estado',1);
            if($filter){
                foreach ($filter as $key => $value) {
                    if($key == 'nombre'){
                        $this -> db -> like ('UPPER(b.nombre)', strtoupper($value));
                    }
                    else{
                        $this -> db -> where($key,$value);                        
                    }      
                }
            }
            $this -> db -> from('grupo b');
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
     //   function get_oficina_company_data( $limit, $filter,$offset,  $order_by = null ) {
            $this->_get_oficina_company_filter($filter);
         //   $this -> db -> from('grupo b');
            $this -> db -> select(
                        'b.nombre, b.observaciones',FALSE
                    );
            if($order_by){
                foreach ($order_by as $order => $tipo){
                    $this -> db -> order_by($order, $tipo);        
                }
            }
            $this -> db -> limit($limit, $offset); 
            $query = $this -> db -> get();                  
            $result = $query->result();
//          echo $this->db->last_query();
            return $result;           
        } 
        
        public function get_oficina_company_count( $filter = null ) {  
            $this->_get_oficina_company_filter($filter);
            return $this->db->count_all_results();    
        }        
}