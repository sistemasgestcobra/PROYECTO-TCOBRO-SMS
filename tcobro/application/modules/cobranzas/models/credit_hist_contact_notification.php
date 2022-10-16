<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class credit_hist_contact_notification extends \CI_Model {
    private function _get_credit_detail_filter( $filter = null,$client_id) {
        
        
            $this -> db -> where ('c_d.company_id', $this->user->company_id);
            $this -> db -> where ('com.type','visita');
            /**
             * Si el usuario identificado tiene rol de oficial de credito, entonces se
             * muestra solamente los creditos asignados a su persona
             */
            
             if($client_id > 0){
                $this -> db -> where ('c_r.credit_detail_id', $client_id);
                
             }  else {
                 
             if( $this->user->role_id == 1 ){
                $this -> db -> where ('com.user_id', $this->user->id);
             }}
            if($filter){
                foreach ($filter as $key => $value) {
                    
                    if($key == 'type' ){
                        $this -> db -> like ('UPPER(com.type)', strtoupper($value));
                    }else if($key == 'person_name' ){
                        $this -> db -> like ('UPPER(p.firstname)', strtoupper($value));
                        $this -> db -> or_like ('UPPER(p.lastname)', strtoupper($value));
                        
                    }else if($key == 'status' ){
                        $this -> db -> like ('UPPER(com.status)', strtoupper($value));
                    }else if($key == 'curr_date' ){
                        $this -> db -> like ('UPPER(com.curr_date)', strtoupper($value));
                    }else if($key == 'curr_time' ){
                        $this -> db -> like ('UPPER(com.curr_time)', strtoupper($value));
                    }else{
                        $this -> db -> where($key,$value);
                    }      
                }
            }
            $this -> db -> from('comunication com');
            $this -> db -> join('client_referencias c_r', 'c_r.id = com.client_referencias_id');
            $this -> db -> join('credit_detail c_d', 'c_d.id =c_r.credit_detail_id');
            $this -> db -> join('person p', 'p.id = c_r.person_id');
            $this -> db -> join('contact cont', 'cont.person_id = p.id');
            $this->db->group_by('com.id');
    }
    
    /**
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
        function credit_hist_notification_data($limit, $offset, $filter, $order_by,$client_id){
            $this->_get_credit_detail_filter($filter,$client_id);
            $this->db->select(
                        'com.id,com.id com_id,com.type,com.status, com.detalle_notificacion, com.contact, com.contact_id ,com.curr_date, com.curr_time, com.notificador,com.user_id, com.fecha_entrega, com.hora_entrega,c_r.id credit_detail_id,c_r.person_id, p.id person_id, c_d.nro_pagare,CONCAT_WS("",p.firstname," ",p.lastname) person_name,', FALSE
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
        
        
        
        public function get_hist_notification_count($filter,$client_id) {  
            $this->_get_credit_detail_filter($client_id);
            return $this->db->count_all_results();    
        }   
}