<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Credit_hist_contact_model extends \CI_Model {
    private function _get_credit_detail_filter( $filter = null, $client_id) {
            $this -> db -> where ('c_d.company_id', $this->user->company_id);
            $this -> db -> where ('com.type !=','visita');
            /**
             * Si el usuario identificado tiene rol de oficial de credito, entonces se
             * muestra solamente los creditos asignados a su persona
             */
            if($client_id > 0){
                $this -> db -> where ('c_r.credit_detail_id', $client_id);
                
             }  
			 
			 if( $this->user->role_id == 1 ){
                //$this -> db -> where ('com.user_id', $this->user->id);
				 $this -> db -> where ('com.user_id', $this->user->id);
            }
			 
            if($filter){
                foreach ($filter as $key => $value) {
                    if($key == 'type' ){
                        $this -> db -> like ('UPPER(com.type)', strtoupper($value));
                    }else if($key == 'person_name' ){
                        $this -> db -> like ('UPPER(p.firstname)', strtoupper($value));
                        //$this -> db -> or_like ('UPPER(p.lastname)', strtoupper($value));
                    }else if($key == 'status' ){
                        $this -> db -> like ('UPPER(com.status)', strtoupper($value));
                    }else if($key == 'curr_date' ){
                        $this -> db -> like ('UPPER(com.curr_date)', strtoupper($value));
                    }else if($key == 'curr_time' ){
                        $this -> db -> like ('UPPER(com.curr_time)', strtoupper($value));
                    }else if($key == 'contact' ){
                        $this -> db -> like ('UPPER(com.contact)', strtoupper($value));
                    }else{
                        $this -> db -> where($key,$value);
                    }       
                }
            }
            $this -> db -> from('comunication com');
            $this -> db -> join('client_referencias c_r', 'c_r.id = com.client_referencias_id');
            $this -> db -> join('credit_detail c_d', 'c_d.id =c_r.credit_detail_id');
            $this -> db -> join('person p', 'p.id = c_r.person_id');
            $this -> db -> join('oficial_credito o_c', 'o_c.id = com.user_id');
            $this -> db -> join('oficial_credito o_c_d', 'o_c_d.id = c_d.oficial_credito_id');
    }
    /**
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
        function credit_hist_contact_data($limit, $offset, $filter, $order_by, $client_id){
            $this->_get_credit_detail_filter($filter, $client_id);
            $this->db->select(
                        'com.id,com.id com_id,com.type,com.status, com.detalle_notificacion, com.contact, com.curr_date, com.curr_time, com.notificador,com.user_id, com.fecha_entrega, com.hora_entrega,c_r.id credit_detail_id,c_r.person_id, p.id person_id, CONCAT_WS("",p.firstname," ",p.lastname) person_name,', FALSE
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
        
       
        public function get_hist_contact_count($filter, $client_id) {  
            $this->_get_credit_detail_filter($filter, $client_id);
            return $this->db->count_all_results();    
        }   
}
