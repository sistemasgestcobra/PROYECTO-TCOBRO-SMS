<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Credit_hist_model_legal extends \CI_Model {

    private function _get_hist_filter($filter = null, $client_id, $compromiso_pago_date) {

$this -> db = $this->load->database('gestcobral', TRUE);

        //$this->db->where('c_d.company_id', $this->user->company_id);
        if ($compromiso_pago_date != 0) {
            //$this -> db -> where ( 'c_h.gestionado =', 1 );
            $this->db->where('c_h.compromiso_pago_date', $compromiso_pago_date);
        }
        /**
         * Si el usuario identificado tiene rol de oficial de credito, entonces se
         * muestra solamente los creditos asignados a su persona
         */
        if ($this->user->role_id == 1) {
            $this->db->where('c_d.oficial_credito_id', $this->user->id);
          
        }
        
        
        if ($client_id >=0) {
            $this->db->where('c_r.credit_detail_id',$client_id);
           
        }
        
        if ($filter) {
            foreach ($filter as $key => $value) {
                if ($key == 'client_name') {
                    $this->db->like('UPPER(cl_p.firstname)', strtoupper($value));
                    $this->db->like('UPPER(cl_p.lastname)', strtoupper($value));
                } elseif ($key == 'status_name') {
                    $this->db->like('UPPER(c_s.status_name)', strtoupper($value));
                } elseif ($key == 'client_code') {
                    $this->db->like('UPPER(c_r.client_code)', strtoupper($value));
                } elseif ($key == 'nro_cuotas') {
                    $this->db->like('UPPER(c_d.nro_cuotas)', strtoupper($value));
                } elseif ($key == 'detail') {
                    $this->db->like('UPPER(c_h.detail)', strtoupper($value));
                } elseif ($key == 'hist_date') {
                    $this->db->like('UPPER(c_h.hist_date)', strtoupper($value));
                } elseif ($key == 'hist_time') {
                    $this->db->like('UPPER(c_h.hist_time)', strtoupper($value));
                } elseif ($key == 'compromiso_pago_date') {
                    $this->db->like('UPPER(c_h.compromiso_pago_date)', strtoupper($value));
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        $this->db->from('credit_hist c_h');
        $this->db->join('credit_detail c_d', 'c_d.id = c_h.credit_detail_id');
        $this->db->join('client_referencias c_r', 'c_r.credit_detail_id = c_d.id and c_r.reference_type_id=3');
        $this->db->join('person cl_p', 'cl_p.id = c_r.person_id');
        $this->db->join('credit_status c_s', 'c_s.id = c_h.credit_status_id');
    }

    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
    function get_hist_data($limit, $offset, $filter = null, $order_by = null, $client_id, $compromiso_pago_date) {

        $this -> db = $this->load->database('gestcobral', TRUE);
        
        $this->_get_hist_filter($filter, $client_id, $compromiso_pago_date);
        $this->db->select(
                'c_h.id,c_h.credit_detail_id ,c_h.detail, c_h.adjunto, c_h.gasto, c_h.hist_date, c_h.hist_time, c_h.compromiso_pago_date, cl_p.cedula_deudor,c_h.credit_status_id, c_d.nro_cuotas, c_d.nro_pagare, c_d.deuda_inicial, c_d.nro_pagare,c_d.saldo_actual, c_d.adjudicacion_date, c_d.total_cuotas_vencidas, c_r.client_code, CONCAT_WS("",cl_p.firstname," ",cl_p.lastname) client_name, c_s.status_name, c_s.color, c_s.background', FALSE
        );

        if ($order_by) {
            foreach ($order_by as $order => $tipo) {
                $this->db->order_by($order, $tipo);
            }
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $result = $query->result();

//            echo $this->db->last_query();

        return $result;
    }

    public function get_hist_count($filter = null, $client_id, $compromiso_pago_date) {
        $this -> db = $this->load->database('gestcobral', TRUE);
        $this->_get_hist_filter($filter, $client_id, $compromiso_pago_date);
        return $this->db->count_all_results();
    }

   
    }
