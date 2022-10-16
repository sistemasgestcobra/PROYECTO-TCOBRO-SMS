<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mapa_model extends \CI_Model{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_markers($id)
	{
            
	$this->db->select('latitud,longitud,firstname,reference_type_id');
            $this->db->from('person p');
            $this -> db -> join('client_referencias c_r', 'c_r.person_id = p.id');
            $this->db->where('c_r.credit_detail_id',$id);
            $this -> db -> order_by('reference_type_id','DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}
