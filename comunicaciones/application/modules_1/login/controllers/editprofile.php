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
    $curren_pass = set_post_value('curren_pass');
    $new_pass = set_post_value('new_pass');
    $confirm_pass = set_post_value('confirm_pass');
    $this->db->where('id',$ids);
    $this->db->update('oficial_credito', array('password'=>$confirm_pass));
    echo $this->db->last_query();
    successAlert(lang('ml_success_msg'),lang('ml_success'));
   /*$this->load->library('form_validation');
   $this->form_validation->set_rules( 'current_pass', 'Clave Actual', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'new_pass', 'Nueva Clave', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'confirm_pass', 'Confirme Nueva Clave', 'trim|required|xss_clean' );
   $this->form_validation->set_error_delimiters('<br /><span class="text-danger">', '</span>');
   $form_validation = $this->form_validation->run(); */
        /*if ($form_validation == FALSE) {
            errorAlert( trim(preg_replace("[\n|\r|\n\r]","|",strip_tags(validation_errors()))) , "Validacion de Datos" );
        } else {*/
            /**
             * Se comprueba la clave actual
             */
        /*    $current_pass = set_post_value('current_pass');
            $ml_persona_acceso = (new \marilyndb\ml_persona_acceso_model())->where('persona_id', $this->user->id)->where('company_id', $this->user->empresa_id)->find_one();
            if ($ml_persona_acceso->password != md5($current_pass.  get_settings('PASSWORDSALTMAIN'))) {
                errorAlert('La clave actual ingresada no coicide con la clave del usuario.',  lang('ml_error'));
                exit();
            }
            $form_validation = $this->confirm_pass();
            if($form_validation){
                $new_pass = $this->encrypt_password_callback(set_post_value('new_pass'));
                $ml_persona_acceso->password = $new_pass;
                $ml_persona_acceso->save();
                if( $ml_persona_acceso->id > 0 ){
                    successAlert('Clave actualizada correctamente!!', lang('ml_success'));
                }
            }
            else{
                 errorAlert('No se pudo actualizar clave!!', lang('ml_error'));
            }*/
        //}
        //echo $this->res_message;
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
        function encrypt_password_callback($clave)
        {
            $encryptedPass = MD5($clave.get_settings('PASSWORDSALTMAIN'));
            return $encryptedPass;
        }        
        
}