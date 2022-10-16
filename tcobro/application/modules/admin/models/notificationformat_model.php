<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notificationformat_model extends \CI_Model {
    
    private function _get_filter( $filter = null ) {
        $this -> db -> where ('n_f.company_id', $this->user->company_id);
        $this -> db -> where ('n_f.status', '1');
            if($filter){
                foreach ($filter as $key => $value) {
                    if($key == 'format'){
                        $this -> db -> like ('UPPER(n_f.format)', strtoupper($value));
                    }if($key == 'description'){
                        $this -> db -> like ('UPPER(n_f.description)', strtoupper($value));
                    } else{
                        $this -> db -> where($key,$value);                        
                    }      
                }
            }
            $this->db->from('notification_format n_f');
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
                        'n_f.id, n_f.format, n_f.description,n_f.type'
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