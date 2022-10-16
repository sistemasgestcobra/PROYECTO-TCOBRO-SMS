<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Credit_detail_model extends \CI_Model {
    private function _get_by_filter( $from_date, $to_date, $oficial_id, $oficina_company_id ) {
            $this->db->where('c_d.curr_date >=', $from_date);
            $this->db->where('c_d.curr_date <=', $to_date);
            $this->db->where('c_s.company_id',$this->user->company_id);
            /**
             * Si el usuario identificado tiene rol de oficial de credito, entonces se
             * muestra solamente los creditos asignados a su persona
             */
            if( $this->user->role_id == 1 ){
                $this -> db -> where ('c_d.oficial_credito_id', $this->user->id);
            }            
            if( $oficial_id > 0 ){
                $this -> db -> where ('c_d.oficial_credito_id', $oficial_id);
            }  
            elseif ( $oficina_company_id > 0 ) {
                $this -> db -> where ('c_d.oficina_company_id', $oficina_company_id);
            }
            $this -> db -> from('credit_detail c_d');
            $this -> db -> join('oficina_company o_comp', 'o_comp.id = c_d.oficina_company_id');
            $this -> db -> join('month m', 'm.id = c_d.updated_month_id');
            $this -> db -> join('client_referencias c_r', 'c_r.credit_detail_id = c_d.id and c_r.reference_type_id=3');
            $this -> db -> join('person cl_p', 'cl_p.id = c_r.person_id');
            $this -> db -> join('credit_status c_s', 'c_s.id = c_d.credit_status_id');
            $this -> db -> join('credito_type c_t', 'c_t.id = c_d.credito_type_id');            
            $this -> db -> join('oficial_credito o_c', 'o_c.id = c_d.oficial_credito_id');  
    }
    
        public function get_report_by_day( $from_date, $to_date, $type_group, $search_type, $oficial_id, $oficina_company_id, $comparar) {

            $this->_get_by_filter($from_date, $to_date, $oficial_id, $oficina_company_id);
            
//            $this -> db -> select(
//                        'c_d.id, c_d.nro_cuotas, c_d.nro_pagare, c_d.deuda_inicial, c_d.saldo_actual, c_d.curr_date, c_d.adjudicacion_date, c_d.total_cuotas, cl.code, cl_p.personal_phone, cl_p.personal_address, c_s.status_name, c_s.color, c_s.background, c_d.credit_status_id, CONCAT_WS("", cl_p.firstname, " ",cl_p.lastname) client_name, c_t.name credit_type', FALSE
//                    );
            $this -> db -> select(
                        'c_d.id, c_d.nro_cuotas, c_d.nro_pagare, c_d.deuda_inicial, c_d.saldo_actual, c_d.curr_date, c_d.adjudicacion_date, c_d.total_cuotas_vencidas, o_c.id oficial_credito_id, o_c.firstname oficial_credito, c_d.updated_month_id, c_d.updated_year, m.month_name, o_comp.name agencia_name, c_d.oficina_company_id'
                    );
            
            
            if($search_type == 'date'){
                if($type_group == 1){
                    $this -> db -> group_by('c_d.curr_date');
                }  
                elseif ($type_group == 2) {
                    $this -> db -> group_by('MONTH(c_d.curr_date)', FALSE);                
                }
                elseif ($type_group == 3) {
                    $this -> db -> group_by('YEAR(c_d.curr_date)', FALSE);                
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

            
            
//            echo $this->db->last_query();
            return $result;           
        } 
        
        
/**
 * 
 * @param type $from_date
 * @param type $to_date
 * @param type $type_group
 * @param type $credit_status
 * @param type $search_type
 * @param type $r
 * @return type
 */
     
}