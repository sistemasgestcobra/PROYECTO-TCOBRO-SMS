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
 
  public function edit_pass() {
        
        
        $this->confirm_pass();
        
        if ($this->confirm_pass()==TRUE) {
             $id = $this->user->id;
        $oficial = new \gestcobra\oficial_credito_model($id);
        $oficial->password = $this->encrypt_password_callback_1(set_post_value('new_pass'));
         $oficial->save();
        successAlert(lang('ml_success_msg'), lang('ml_success'));
        }
        
       
    }
 
 /**
  * Se comprueba que se haya escrito la misma clave en los dos cacilleros
  * en donde es solicitada
  * @return boolean
  */
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
        function encrypt_password_callback_1($clave) {
        $pass_word = (new gestcobra\setup_model())->where('variable', 'PASSWORDSALTMAIN')->find_one()->valor;
        $encryptedPass = MD5($clave . $pass_word);
        return $encryptedPass;
    }       
        
}