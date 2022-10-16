<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verifylogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }
 
 function index() {
    $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
    if($this->form_validation->run() == FALSE) {
        echo tagcontent('script', "window.location.replace('".base_url( 'home.jsp?sess=false' )."')");
    }else{
        echo tagcontent('script', "window.location.replace('".base_url( 'home.jsp' )."')");
    }
 }

 function check_database( $password ) {
   //Field validation succeeded.  Validate against database
   $username = set_post_value('username');
   //$pass_word = (new gestcobra\setup_model())->where('variable', 'PASSWORDSALTMAIN')->find_one();
   $client=new SoapClient("http://srv-wscore-01.mutazuay.com/wcfADValidation/srvADValidation.svc?singleWsdl");
	$message['username']=set_post_value('username');
	$message['password']=set_post_value('password');
	$response=$client->ValidateUser($message);
	foreach($response as $value)
	$array=$value;
	
	if(strlen($array)<5){
		$user = new \gestcobra\oficial_credito_model();
		$user = $user->where('email',strtoupper($username))
           //->where('password', MD5($password.trim($pass_word->valor)))
           ->where('status','1')
           ->find_one();
	}
   
    if( $user->id > 0 ) {
        $USER = array(
          'id' => $user->id,
          'firstname' => $user->firstname,
          'lastname' => $user->lastname,
          'email' => $user->email,
          'root' => $user->root,
          'company_id' => $user->company_id,
          'role_id' => $user->role_id,
          'profile_image' => $user->profile_image,
          'oficina_company_id' => $user->oficina_company_id,  
        );
        $this->session->set_userdata('id', $user->id);
        $this->session->set_userdata($USER);

        return true;
   } else {       
       return false;
   }
 }
}