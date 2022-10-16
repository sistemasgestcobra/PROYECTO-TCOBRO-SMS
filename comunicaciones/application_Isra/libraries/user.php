<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

/**
 * @author Esteban Chamba <estyom.1@gmail.com>
 * @access public
 */
class User {
    
    /**
     * @property integer $accounting_period_id
     */
    
   public $id; 
   public $firstname; 
   public $lastname;
   public $root; //un alias de essuperusuario 
   public $company_id; 
   public $email; 
   public $role_id; 
   public $profile_image;
   public $oficina_company_id;
   public $cedula; 
           
   function __construct()
    {
      $ci =& get_instance();
        $this->id = $ci->session->userdata('id');       
        $this->firstname = $ci->session->userdata('firstname');
        $this->lastname = $ci->session->userdata('lastname');
        $this->email = $ci->session->userdata('email');
        $this->company_id = $ci->session->userdata('company_id');
        $this->root = $ci->session->userdata('root');
        $this->role_id = $ci->session->userdata('role_id');
        $this->profile_image = $ci->session->userdata('profile_image');
        $this->oficina_company_id = $ci->session->userdata('oficina_company_id');
        $this->cedula = $ci->session->userdata('cedula');
    }
    function setOficina_company_id($oficina_company_id) {
        $this->oficina_company_id = $oficina_company_id;
    }
    function getOficina_company_id() {
        return $this->oficina_company_id;
    }

            /**
     * 
     * @param type $privilege_name_array
     * @param type $user_id
     * @return boolean
     * @description Verifica si el usuario tiene alguno de los privilegios pasados en $privilege_name_array
     */
    function check_permission( $privilege_name_array, $user_id ){
        /* si es superusuario, no comprueba nada mas */
        if($this->root == 1){
            return true;
        }
        
        $ml_person_privileges = new \marilyndb\ml_person_privileges_model();
        $ml_person_privileges = $ml_person_privileges->where('persona_id', $user_id)->where('company_id', $this->empresa_id)->where_in('privilege_name', $privilege_name_array )->find_one();        
        if($ml_person_privileges->id > 0){
            return true;
        }else{
//            errorAlert('No posee los permisos necesarios para ejecutar la transaccion requerida!',  lang('ml_error'));
            return false;
        }
    }
            
    public function check_session(){
        $ci =& get_instance();
        $user_id = $ci->user->id;
        if(empty($user_id)){
            $res['view_name'] = 'login/home';
            echo $ci->load->view('common/templates/dashboard',$res,TRUE);
            exit(0);
        }
    }
    
    
    public function compare_acl( $page ) {
        $ci =& get_instance();
        $ml_privilege_model = new \marilyndb\ml_privilege_model();
        $ml_privilege_model = $ml_privilege_model->where('ubicacion', $page)->find_one();

        $ml_person_privileges = new \marilyndb\ml_person_privileges_model();
        $ml_person_privileges = $ml_person_privileges->where('privilege_name', $ml_privilege_model->capacidad)->where('persona_id', $this->id)->where('company_id', $this->empresa_id)->find_one();
                

        if( empty($ml_person_privileges->id) AND $this->root != 1){
            $res['view_name'] = 'common/page_noauthorized';
            echo $ci->load->view('common/templates/dashboard',$res,TRUE);
            exit(0);
        }
    }
}
