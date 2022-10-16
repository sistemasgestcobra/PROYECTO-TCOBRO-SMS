<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends \CI_Model {
    
    private function _get_user_filter( $filter = null, $all_companies = 0 ) {
        if($all_companies != 1 ){
            $this -> db -> where ('u.company_id', $this->user->company_id);            
        }

            if($filter){
                foreach ($filter as $key => $value) {
                    if($key == 'firstname'){
                        $this -> db -> where ('UPPER(u.firstname)', strtoupper($value));
                    }
                    elseif($key == 'lastname'){
                        $this -> db -> like ('UPPER(c.lastname)', strtoupper($value));
                    }
                    else{
                        $this -> db -> where($key,$value);                        
                    }      
                }
            }
            
            $this -> db -> from('user u');
            $this -> db -> join('person p', 'p.id = u.person_id');
    }
    
    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
        function get_user_data( $limit, $offset, $filter = null, $order_by = null, $all_companies = 0 ) {

            $this->_get_user_filter($filter, $all_companies);
            $this -> db -> select(
                        'u.id, u.email, p.firstname, p.lastname, u.company_id'
                    );
            
            if($order_by){
                foreach ($order_by as $order => $tipo) {
                    $this -> db -> order_by($order, $tipo);        
                }
            }
                $this -> db -> limit($limit, $offset); 
                $query = $this -> db -> get();                  
            $result = $query->result();
            
//            echo $this->db->last_query();
            return $result;           
        } 
        
        public function get_user_count( $filter = null, $all_companies = 0 ) {  
            $this->_get_user_filter($filter, $all_companies);
            return $this->db->count_all_results();    
        }        
        
}