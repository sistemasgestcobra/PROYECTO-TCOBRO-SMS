<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Oficial_credito_model extends \CI_Model {
    private function _get_oficial_credito_filter( $filter = null ) {
        $this -> db -> where ('o_c.company_id', $this->user->company_id);
        $this -> db -> where ('o_cred.status','1');
            if($filter){
                foreach ($filter as $key => $value) {
                    
                    if($key == 'firstname'){
                        $this -> db -> like ('UPPER(o_cred.firstname)', strtoupper($value));
                    }elseif($key == 'lastname'){
                        $this -> db -> like ('UPPER(o_cred.lastname)', strtoupper($value));                        
                    }elseif($key == 'cedula'){
                        $this -> db -> like ('UPPER(o_cred.cedula)', strtoupper($value));                        
                    }elseif($key == 'email'){
                        $this -> db -> like ('UPPER(o_cred.email)', strtoupper($value));                        
                    }elseif($key == 'role_name'){
                        $this -> db -> like ('UPPER(r.role_name)', strtoupper($value));                        
                    }elseif($key == 'oficina_name'){
                        $this -> db -> like ('UPPER(o_c.name)', strtoupper($value));                        
                    }
                    else{
                        $this -> db -> where($key,$value);                        
                    }      
                }
            }
            $this -> db -> from('oficial_credito o_cred');
            $this -> db -> join('oficina_company o_c', 'o_c.id = o_cred.oficina_company_id', 'left');
            $this -> db -> join('role r', 'r.id = o_cred.role_id');
    }
    
    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
        function get_oficial_credito_data( $limit, $offset, $filter = null, $order_by = null ) {

            $this->_get_oficial_credito_filter($filter);
            $this -> db -> select(
                        'o_cred.id, o_cred.cedula, o_cred.firstname, o_cred.lastname, o_cred.email, o_cred.telefono, o_c.name oficina_name, r.role_name, o_cred.role_id, o_cred.oficina_company_id'
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
        
        public function get_oficial_credito_count( $filter = null ) {  
            $this->_get_oficial_credito_filter($filter);
            return $this->db->count_all_results();    
        }        
        
}