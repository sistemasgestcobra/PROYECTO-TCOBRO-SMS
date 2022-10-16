<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Envio_hist_model extends \CI_Model {

        function get_hist_data( $limit, $offset, $order_by = null) {
            $this -> db -> from('envio_hist');
            $this -> db -> select(
            'envio_hist.id, envio_hist.detail, envio_hist.hist_date, envio_hist.hist_time, envio_hist.enviados, envio_hist.excluidos, envio_hist.usuario', FALSE
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
        
        public function get_hist_count() {
            $this -> db -> from('envio_hist');
            return $this->db->count_all_results();    
        } 
}