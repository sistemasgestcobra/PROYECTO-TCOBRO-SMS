<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Credit_hist_model extends \CI_Model {

        function get_hist_data( $limit, $offset, $order_by = null) {
            $this -> db -> from('credit_hist');
            $this -> db -> select(
                        'credit_hist.id, credit_hist.detail, credit_hist.hist_date, credit_hist.hist_time, credit_hist.enviados, credit_hist.excluidos', FALSE
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
        
        public function get_hist_count() {
            $this -> db -> from('credit_hist');
            return $this->db->count_all_results();    
        } 
}