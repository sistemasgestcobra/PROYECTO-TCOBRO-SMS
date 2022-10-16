<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Creditstatus_model extends \CI_Model {
    private function _get_filter( $filter = null ){
        $this -> db -> where ('c_s.company_id', $this->user->company_id);
        $this -> db -> from('credit_status c_s');
        $this->db->join('company c', 'c_s.company_id = c.id', 'left');
    }
    /**
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
    function get_data( $limit, $offset, $filter = null, $order_by = null ) {
        $this->_get_filter($filter);
        $this -> db -> select(
            'c_s.id, c_s.status_name, c_s.color,c_s.background,c_s.company_id,c.nombre_comercial'
        );
        if($order_by){
            foreach ($order_by as $order => $tipo) {
                $this -> db -> order_by($order, $tipo);        
            }
        }
        $this -> db -> limit($limit, $offset); 
        $query = $this->db->get();                  
        $result = $query->result();
        return $result;           
    } 

    public function get_count( $filter = null ) { 
        $this->_get_filter($filter);
        return $this->db->count_all_results();    
    }  
}