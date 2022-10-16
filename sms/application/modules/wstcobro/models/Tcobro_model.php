<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Tcobro_model
 *
 * @author cecibel
 */
class Tcobro_model extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    public function get($id=NULL) {
        if(!is_null($id)){
            $query= $this->db->select('id,credit_detail_id,amount,date_abono',false)
                    ->from('abono')
                    ->where('id',$id)
                    ->get();
            
            if($query->num_rows()>0){
                return $query->row_array();
            }
            return null;
        }
        $query= $this->db->select('credit_detail_id,amount,date_abono',false)
                ->from('abono')
                ->get();
                           
        if($query->num_rows()>0){
                return $query->result_array();
            }
            return null;
    }
    public function save($abono) {
        $this->db->set(
                $this->_setAbono($abono)
                )->insert("abono");
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return NULL;
    }
    
    public function save_abono($numero_pagare,$monto,$fecha){
        if(!is_null($numero_pagare)){
            $query= $this->db->select('id,nro_pagare,saldo_actual',false)
                    ->from('credit_detail')
                    ->where('nro_pagare',$numero_pagare)
                    ->get();
            
            $id_creditDetail;
            if($query->num_rows()==1){
                //return $query->result();
                foreach ($query->result() as $row){
                    $id_creditDetail=$row->id;          
                }
            }
            $data = array(
            'id' => 0,
            'credit_detail_id' => $id_creditDetail,
            'amount' => $monto,
            'date_abono' => $fecha
        );
            
            $this->db->insert("abono",$data);
                    
            if($this->db->affected_rows()==1){
                return $this->db->insert_id();
            }
            return null;
        }
    }
    
    public function save_abono_post($array){
        if(!is_null($numero_pagare)){
            $query= $this->db->select('id,nro_pagare,saldo_actual',false)
                    ->from('credit_detail')
                    ->where('nro_pagare',$numero_pagare)
                    ->get();
            
            $id_creditDetail;
            if($query->num_rows()==1){
                //return $query->result();
                foreach ($query->result() as $row){
                    $id_creditDetail=$row->id;          
                }
            }
            $data = array(
            'id' => 0,
            'credit_detail_id' => $id_creditDetail,
            'amount' => $monto,
            'date_abono' => $fecha
        );
            
            $this->db->insert("abono",$data);
                    
            if($this->db->affected_rows()==1){
                return $this->db->insert_id();
            }
            return null;
        }
    }
    
    public function update($id_abono,$abono) {
        $this->db->set(
                $this->_setAbono($abono)
                )
                ->where('id',$id)
                ->update("abono");
        if($this->db->affected_rows()==1){
            return TRUE;
        }
        return NULL;
    }
    private function _setAbono($abono) {
        return array(
            "id"=>$abono['id']
        );
    }
    
    public function delete($id_abono) {
        /*$this->db->set(
                $this->_setAbono($abono)
                )
                ->where('id',$id)
                ->update("abono");
        if($this->db->affected_rows()==1){
            return TRUE;
        }
        return NULL;*/
    }
}
