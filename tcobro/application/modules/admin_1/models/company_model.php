<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company_model extends \CI_Model {
    private function _get_company_filter($filter = null) {
        if ($filter) {
            foreach ($filter as $key => $value) {
                if ($key == 'company_status') {
                    $this->db->where('UPPER(c_s.company_status)', strtoupper($value));
                } elseif ($key == 'nombre_comercial') {
                    $this->db->like('UPPER(c.nombre_comercial)', strtoupper($value));
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        $this->db->from('company c');
        $this->db->join('company_status c_s', 'c_s.id = c.company_status_id');
    }
    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
    function get_company_data($limit, $offset, $filter = null, $order_by = null) {
        $this->_get_company_filter($filter);
        $this->db->select(
                'c.id, c.nombre_comercial, c.email, c.telefono, c.company_status_id, c_s.company_status'
        );

        if ($order_by) {
            foreach ($order_by as $order => $tipo) {
                $this->db->order_by($order, $tipo);
            }
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function get_company_count($filter = null) {
        $this->_get_company_filter($filter);
        return $this->db->count_all_results();
    }

}
