<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_referencias_model extends \CI_Model {
    private function _get_filter( $filter = null, $client_id ) {
            $this -> db -> where ('c_r.credit_detail_id', $client_id);
            $this -> db -> where ('c_r.status', 1);
            
            if($filter){
                foreach ($filter as $key => $value) {
                    if($key == 'firstname'){
                        $this -> db -> like ('UPPER(cl_p.firstname)', strtoupper($value));
                    }
                    elseif($key == 'lastname'){
                        $this -> db -> like ('UPPER(cl_p.lastname)', strtoupper($value));
                    }
                    else{
                        $this -> db -> where($key,$value);                        
                    }      
                }
            }
            $this -> db -> from('client_referencias c_r');
            $this -> db -> join('person p', 'p.id = c_r.person_id');
            $this -> db -> join('reference_type r_t', 'r_t.id = c_r.reference_type_id');
    }
    
    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
        function get_data( $limit, $offset, $filter = null, $order_by = null, $client_id ) {

            $this->_get_filter($filter, $client_id);
            $this -> db -> select(
                        'c_r.id, c_r.id ref_id, p.firstname, p.lastname, p.personal_address, p.address_ref, r_t.reference_name, r_t.id ref_type_id', FALSE
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
            
            if($result){
               return $result;            
            }else{
               return "";
            }           
        } 
        
        public function get_count( $filter = null, $client_id ) {  
            $this->_get_filter($filter, $client_id);
            return $this->db->count_all_results();    
        }      
        
        }