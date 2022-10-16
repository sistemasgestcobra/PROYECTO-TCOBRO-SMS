<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contactos_model extends \CI_Model {

    private function _get_oficina_company_filter($filter = null,$id_grupo) {
        //$this -> db -> where ('b.estado',1);
        //$this->db->where ('c.id_grupo',$id_grupo);
         $this->db->where ('c.id_grupo',$id_grupo);
         
            
            if($filter){
                foreach ($filter as $key => $value) {
                    
                    if($key == 'numero'){
                        $this -> db -> like ('UPPER(c.numero)', strtoupper($value));
                    }elseif($key == 'nombre'){
                        $this -> db -> like ('UPPER(c.nombre)', strtoupper($value));                        
                    
                    }elseif($key == 'variable1'){
                        $this -> db -> like ('UPPER(c.variable1)', strtoupper($value));                        
                    }elseif($key == 'variable2'){
                        $this -> db -> like ('UPPER(c.variable2)', strtoupper($value));                        
                    }elseif($key == 'variable3'){
                        $this -> db -> like ('UPPER(c.variable3)', strtoupper($value));                        
                    }elseif($key == 'variable4'){
                        $this -> db -> like ('UPPER(c.variable4)', strtoupper($value));                        
                    }
                    else{
                        $this -> db -> where($key,$value);                        
                    }      
                }
            }
         
           $this -> db -> from('contact_grupo c');
            
    }
    
    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $whereData
     * @param type $order_by
     * @return type
     */
    
        function get_oficina_company_data( $limit, $offset, $filter = null, $order_by = null ,$id_grupo) {

               
            $this->_get_oficina_company_filter($filter,$id_grupo);
     //   $this -> db -> from('contact_grupo c');
            
            //'c.id, c.numero, c.nombre, c.apellido,c.variable1,c.variable2,c.variable3,c.variable4',FALSE
            $this -> db -> select(
                        'c.id, c.id_grupo,c.numero, c.nombre,c.variable1,c.variable2,c.variable3,c.variable4',FALSE
                    );
            
         
            if($order_by){
                foreach ($order_by as $order => $tipo){
                    $this -> db -> order_by($order, $tipo);        
                }
            }
            
            
            $this -> db -> limit($limit, $offset); 
            $query = $this -> db -> get();                  
            $result = $query->result();
//          echo $this->db->last_query();
          
            return $result;   
             
        } 
        
        public function get_oficina_company_count($filter = null,$id_grupo) {  
            $this->_get_oficina_company_filter( $filter,$id_grupo);
            return $this->db->count_all_results();    
        }        
}