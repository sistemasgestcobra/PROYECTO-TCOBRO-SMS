<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Credit extends CI_Controller {
	function __construct() {
 		parent::__construct();
                // Ignorar los abortos hechos por el usuario y permitir que el script
                // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
                ignore_user_abort(true);  
                $this->load->library('comunications/commws');
                set_time_limit(0);
	}
        
             public function get_credit_hist_report(){
            $this->load->model('credit_hist_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->credit_hist_model->get_hist_data( $limit, $offset,$order_by);
            $total = $this->credit_hist_model->get_hist_count();
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
}