<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller {

function __construct()
 {
   parent::__construct();
 }

 function index() {
        $res['view_name'] = 'login/home';
        $this->load->view('common/templates/dashboard',$res); 
 }

 function logout() {
   $this->session->sess_destroy();
   redirect('home.jsp', 'refresh');
 }

    public function open_ml_empresa_view2() {
        $this->load->library('common/company');
        $res['menu'] = array(
                array( 'Empresa', 'icon-home'),
            );
        $res['content_menu'] = array(
                array( 'admin/ml_company', 'Registrar Empresa', array('id'=>'0') ),
            );

        $res['view_name'] = 'common/templates/left_menu';
        echo $this->load->view('common/templates/dashboard',$res,TRUE);   
    }
 
    function edit_profile(){
        
           $res['view_name'] = 'login/edit_profile';
           
           echo $this->load->view('common/templates/dashboard',$res,TRUE);    
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */