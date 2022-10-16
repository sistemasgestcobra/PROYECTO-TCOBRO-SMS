<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Abono_model extends \CI_Model {
    private function _get_filter( $filter = null, $credit_detail_id ) {
        if($credit_detail_id > 0){
            $this -> db -> where ('ab.credit_detail_id', $credit_detail_id);
        }
            if($filter){
                foreach ($filter as $key => $value) {
                    if($key == 'firstname'){
                        $this -> db -> like ('UPPER(cl_p.firstname)', strtoupper($value));
                    }
                    else{
                        $this -> db -> where($key,$value);                        
                    }      
                }
            }            
            $this -> db -> from('abono ab');
            $this -> db -> join('credit_detail c_d', 'c_d.id = ab.credit_detail_id');
    }
    
    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
        function get_data( $limit, $offset, $filter = null, $order_by = null, $credit_detail_id ) {
            $this->_get_filter($filter, $credit_detail_id);
            $this -> db -> select(
                        'ab.id, ab.amount, ab.date_abono', FALSE
                    );
            if($order_by){
                foreach ($order_by as $order => $tipo) {
                    $this -> db -> order_by($order, $tipo);        
                }
            }
            if(!empty($limit)){
                $this -> db -> limit($limit, $offset);                 
            }
                $query = $this -> db -> get();                  
            $result = $query->result();
            return $result;           
        } 
        
        public function get_count( $filter = null, $credit_detail_id ) {  
            $this->_get_filter($filter, $credit_detail_id);
            return $this->db->count_all_results();    
        }        
}