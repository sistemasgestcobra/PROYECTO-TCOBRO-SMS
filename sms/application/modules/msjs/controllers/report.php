<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Report extends CI_Controller {
	function __construct() { 		parent::__construct();                ignore_user_abort(true);                
	$this->load->library('comunications/commws');                set_time_limit(0);	}                   
	public function get_envio_report(){            $this->load->model('envio_report_model');        
    $sort = $this->input->get('sort');            $order = $this->input->get('order');        
    $limit = $this->input->get('limit');            $offset = $this->input->get('offset');     
	$filter = json_decode($this->input->get('filter'));            $order_by = array($sort=>$order);         
	$res = $this->envio_report_model->get_hist_data( $limit, $offset,$order_by);       
	$total = $this->envio_report_model->get_hist_count();     
	echo '{"total": '.$total.', "rows":'.json_encode($res).'}';        }        }