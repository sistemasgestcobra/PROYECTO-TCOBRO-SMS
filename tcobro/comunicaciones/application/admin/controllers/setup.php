<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends MX_Controller {

	public function __construct()
	{
            parent::__construct();
            $this->user->check_session();
            $this->load->model('setup_model');
	}

        public function get_setup_report(){
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            
            $order_by = array($sort=>$order);
            
            $res = $this->setup_model->get_setup_data($limit, $offset, $filter, $order_by);
            $total = $this->generic_model->count_all_results('ml_setup', $filter );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }        
     
        
     /* Llamada al formulario 
        * enlace de llamada:
        * <a id="call-php" href="#" data-target="messagesout" php-function="common/index/viewScreen/module/controller/open_ml_setup">Nuevo</a>
        */
        function open_ml_setup($id = 0) {
            $res['info_data'] = new \marilyndb\ml_setup_model($id);
            $this->load->view("ml_setup", $res);
        }

	function save() {
            $id = set_post_value('id');
            $ml_setup = new \marilyndb\ml_setup_model($id);
            $ml_setup->variable = set_post_value('variable');
            $ml_setup->valor = set_post_value('valor');
            $ml_setup->detalle = set_post_value('detalle');
            $ml_setup->save();
            
            successAlert(lang('ml_success_msg'), lang('ml_success'));                
	}        
        
}