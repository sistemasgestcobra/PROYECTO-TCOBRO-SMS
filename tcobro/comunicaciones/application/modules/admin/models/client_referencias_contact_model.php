<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_referencias_contact_model extends \CI_Model {

    private function _get_filter($filter = null, $client_id) {

        //$this -> db -> where ('c_r.client_id', $client_id);
        //$this->_get_person_id_client_reference($client_id);
        $referencias_id = $this->get_person_id_client_reference($client_id);
        $this->db->where_in('c.person_id', $referencias_id);
        if ($filter) {
            foreach ($filter as $key => $value) {
                if ($key == 'contact_value') {
                    $this->db->like('UPPER(c.contact_value)', strtoupper($value));
                } elseif ($key == 'client_name') {
                    $this->db->like('UPPER(pr.firstname)', strtoupper($value));
                    $this->db->like('UPPER(pr.lastname)', strtoupper($value));
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        $this->db->from('contact c');
        $this->db->join('person pr', 'c.person_id = pr.id');
        $this->db->join('contact_type c_t', 'c.contact_type_id = c_t.id');
        $this->db->join('contact_respuesta c_re', 'c.contact_respuesta_id = c_re.id');
        //$this -> db -> join('client_referencias c_r', 'c_r.person_id = pr.id');
        //$this -> db -> join('reference_type r_t', 'r_t.id = c_r.reference_type_id');
    }

    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
    function get_data($limit, $offset, $filter = null, $order_by = null, $client_id) {

        $this->_get_filter($filter, $client_id);
        $this->db->select(
                'c.id, c.id contact_id, c.contact_value, c.description, c.person_id, c.contact_type_id, c.contact_respuesta_id, CONCAT_WS("", pr.firstname, " ",pr.lastname) client_name, c.person_id ,c_t.contact_name, c_re.respuesta_name', FALSE
        );

        if ($order_by AND ( !$order_by == '')) {
            foreach ($order_by as $order => $tipo) {
                $this->db->order_by($order, $tipo);
            }
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_person_id_client_reference($client_id) {

        $this->db->select('cr.person_id', FALSE);
        $this->db->from('client_referencias cr');
        $this->db->join('person p', 'p.id = cr.person_id');
        $this->db->where('cr.status', 1);
        $this->db->where('cr.credit_detail_id', $client_id);
        $query = $this->db->get();
        $result = $query->result();
        //if($query->num_rows()>0){
        // echo $query->result();
        $array_person_id = array();
        foreach ($result as $value) {
            array_push($array_person_id, $value->person_id);
        }
        //print_r($array_person_id);
        //print_r($query->result());
        //return $query->result();
        //}
        return $array_person_id;
    }

    public function get_datos_reference_id_client($client_id, $reference_type_id) {
        print_r('get_datos_reference_id_client');
        $this->db->select('cr.id,cr.person_id,reference_type_id,status', FALSE);
        $this->db->from('client_referencias cr');
        $this->db->join('person p', 'p.id = cr.person_id');
        $this->db->where('cr.status', 1);
        if ($reference_type_id && (!$reference_type_id = '')) {
            $this->db->where('cr.reference_type_id', $reference_type_id);
        }
        $this->db->where('cr.credit_detail_id', $client_id);
        $query = $this->db->get();
        $result = $query->result();
        $array_person_id = array();
        foreach ($result as $value) {
            array_push($array_person_id, $value->person_id);
        }
        //print_r($array_person_id);
        //print_r($query->result());
        //return $query->result();
        //}
        /* $client_model = new gestcobra\client_model($client_id);
          array_push ($array_person_id , $client_model->person_id); */
        return $array_person_id;
    }

    public function get_datos_reference_id_client_person_id($client_id, $reference_type_id) {
        print_r('get_datos_reference_id_client_person_id');
        $this->db->select('cr.person_id', FALSE);
        $this->db->from('client_referencias cr');
        $this->db->join('person p', 'p.id = cr.person_id');
        $this->db->where('cr.status', 1);
        $this->db->where('cr.reference_type_id', $reference_type_id);
        $this->db->where('cr.credit_detail_id', $client_id);
        $query = $this->db->get();
        $result = $query->result();
        $array_person_id = array();
        foreach ($result as $value) {
            array_push($array_person_id, $value->person_id);
        }
        //print_r($array_person_id);
        //print_r($query->result());
        //return $query->result();
        //}
        /* $client_model = new gestcobra\client_model($client_id);
          array_push ($array_person_id , $client_model->person_id); */
        //var_dump($array_person_id);
        return $array_person_id;
    }

    public function get_count($filter = null, $client_id) {
        $this->_get_filter($filter, $client_id);
        return $this->db->count_all_results();
    }

}
