<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Editprofile extends MX_Controller {
    private $res_message = '';
 function __construct()
 {
   parent::__construct();
 }
 public function edit()
 {
    $ids = set_post_value('id');
    $firstname = set_post_value('nombres');
    $lastname = set_post_value('apellidos');
    $telefono = set_post_value('telefono');
    $email = set_post_value('email');
    print_r($firstname);
    $this->db->where('id',$ids);
    $this->db->update('oficial_credito', array('firstname'=>$firstname,'lastname'=>$lastname,'telefono'=>$telefono,'email'=>$email));
    echo $this->db->last_query();
    successAlert(lang('ml_success_msg'),lang('ml_success'));
 }
 
 public function edit_pass(){
     $ids = set_post_value('id');
    $curren_pass = set_post_value('curren_pass');
    $new_pass = set_post_value('new_pass');
    $confirm_pass = set_post_value('confirm_pass');
    $pass_word = (new gestcobra\setup_model())->where('variable', 'PASSWORDSALTMAIN')->find_one()->valor;
    $encryptedPass = MD5($confirm_pass.$pass_word);
    
    $this->db->where('id',$ids);
    $this->db->update('oficial_credito', array('password'=>$encryptedPass));
    echo $this->db->last_query();
    successAlert(lang('ml_success_msg'),lang('ml_success'));
 }


	public function confirm_pass()
	{
            $new_pass = $this->input->post('new_pass');
            $confirm_pass = $this->input->post('confirm_pass');
		if ($new_pass != $confirm_pass) {
			toast('No coincide la confirmaci&oacute;n de la clave.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}        
        
        /**
         * 
         * @param type $clave
         * @return type
         */
        function encrypt_password_callback($clave)
        {
            $encryptedPass = MD5($clave.get_settings('PASSWORDSALTMAIN'));
            return $encryptedPass;
        }        
        
}