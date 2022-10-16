<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Comunication_model extends \CI_Model {
    private function _get_by_filter( $from_date, $to_date, $oficial_id, $oficina_company_id , $client_id) {
        
        $this->db->where('c_d.company_id',$this->user->company_id);
        $this->db->where('com.curr_date >=', $from_date);
        $this->db->where('com.curr_date <=', $to_date);
        /**
         * Si el usuario identificado tiene rol de oficial de credito, entonces se
         * muestra solamente los creditos asignados a su persona
         */
//        if($this->user->role_id == 1 ){
//            $this -> db -> where ('com.user_id', $this->user->id);
//            $this -> db -> where ('c_d.oficial_credito_id', $this->user->id);
//        }            
           if($client_id>0){
                $this -> db -> where ( 'c_r.credit_detail_id', $client_id );
            }
        if( $oficial_id > 0 ){
            $this -> db -> where ('c_d.oficial_credito_id', $oficial_id);
        }  
        elseif ($oficina_company_id > 0){
            $this -> db -> where ('c_d.oficina_company_id', $oficina_company_id);
        }
        $this -> db -> from('comunication com');
        $this -> db -> join('client_referencias c_r', 'c_r.id = com.client_referencias_id');
        $this -> db -> join('credit_detail c_d', 'c_r.credit_detail_id = c_d.id');
        $this -> db -> join('person cl_p', 'cl_p.id = c_r.person_id');
        $this -> db -> join('oficina_company o_comp', 'o_comp.id = c_d.oficina_company_id');
        $this -> db -> join('month m', 'm.id = c_d.updated_month_id');
        $this -> db -> join('credito_type c_t', 'c_t.id = c_d.credito_type_id');   
        $this -> db -> join('oficial_credito o_c', 'o_c.id = c_d.oficial_credito_id');            
    }
        public function get_report_by_day( $from_date, $to_date, $type_group, $search_type, $oficial_id, $oficina_company_id, $comparar) {
        
            $this->_get_by_filter($from_date, $to_date, $oficial_id, $oficina_company_id);
//            $this -> db -> select(
//                        'c_d.id, c_d.nro_cuotas, c_d.nro_pagare, c_d.deuda_inicial, c_d.saldo_actual, c_d.curr_date, c_d.adjudicacion_date, c_d.total_cuotas, cl.code, cl_p.personal_phone, cl_p.personal_address, c_s.status_name, c_s.color, c_s.background, c_d.credit_status_id, CONCAT_WS("", cl_p.firstname, " ",cl_p.lastname) client_name, c_t.name credit_type', FALSE
//                    );
            $this -> db -> select(
                        'c_d.id, c_d.nro_cuotas, c_d.nro_pagare, c_d.deuda_inicial, c_d.saldo_actual, c_d.curr_date, c_d.adjudicacion_date, c_d.total_cuotas_vencidas, o_c.id oficial_credito_id, o_c.firstname oficial_credito, c_d.updated_month_id, c_d.updated_year, m.month_name, o_comp.name agencia_name, c_d.oficina_company_id,com.id,com.type,c_r.credit_detail_id,com.status,com.contact,com.curr_date,com.curr_time,com.user_id,com.comunication_type_id,com.client_referencias_id'
                    );
            if($search_type == 'date'){
                if($type_group == 1){
                    $this -> db -> group_by('com.curr_date');
                }  
                elseif ($type_group == 2) {
                    $this -> db -> group_by('MONTH(com.curr_date)', FALSE);                
                }
                elseif ($type_group == 3) {
                    $this -> db -> group_by('YEAR(com.curr_date)', FALSE);                
                }                
            }
            elseif($search_type == 'oficial'){
                $this -> db -> group_by('c_d.oficial_credito_id');
            }
            elseif($search_type == 'agencia'){
                $this -> db -> group_by('c_d.oficina_company_id');
            }
            $query = $this -> db -> get();                  
            $result = $query->result();
//            foreach ($result as $r) {
//                $r -> pendiente = $this-> _get_num_by_status( $from_date, $to_date, $type_group, 1, $search_type, $r, $oficial_id, $oficina_company_id );
//                $r -> no_contactado = $this-> _get_num_by_status( $from_date, $to_date, $type_group, 2, $search_type, $r, $oficial_id, $oficina_company_id );
//                $r -> contactado = $this-> _get_num_by_status( $from_date, $to_date, $type_group, 3, $search_type, $r, $oficial_id, $oficina_company_id );
//            }
          // echo $this->db->last_query();
            return $result;           
        } 

        public function get_num_by_status( $from_date, $to_date, $type_group, $credit_status, $search_type, $r, $oficial_id, $oficina_company_id ) {
            $this->_get_by_filter($from_date, $to_date, $oficial_id, $oficina_company_id);
            $this->db->where('credit_status_id', $credit_status);
            if( $search_type == 'oficial' ) {
                $this->db->where('cl.oficial_credito_id', $r->oficial_credito_id);
            }elseif( $search_type == 'date' ){
                /**
                 * Si el reporte el DIARIO
                 */
                if($type_group == 1){
                    $this->db->where('c_d.curr_date', $r->curr_date);
                    /**
                     * Si solicita el reporte MENSUAL
                     */
                }  elseif ($type_group == 2) {
                    $this->db->where('MONTH(c_d.curr_date)', $r->updated_month_id);
                    /**
                     * Si solicita el reporte ANUAL
                     */
                } elseif($type_group == 3){
                    $this->db->where('YEAR(c_d.curr_date)', $r->updated_year);                
                }                
            }  elseif ($search_type == 'agencia') {
                $this->db->where('c_d.oficina_company_id', $r->oficina_company_id);
            }
            return $this->db->count_all_results();
        }
       
}