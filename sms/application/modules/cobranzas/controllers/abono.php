<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Abono extends CI_Controller {
               
	function __construct(){
 		parent::__construct();
                // Ignorar los abortos hechos por el usuario y permitir que el script
                // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
                ignore_user_abort(true);                
	}
        /**
         * Obtiene las referencias que un cliente tiene asignnadas
         * @param type $client_id
         */
        public function get_abono_report($credit_detail_id){
            $this->load->model('abono_model');
            
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            
            $order_by = array($sort=>$order);
            
            $res = $this->abono_model->get_data( $limit, $offset, $filter, $order_by, $credit_detail_id );
            $total = $this->abono_model->get_count( $filter, $credit_detail_id );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
        
        /* Llamada al formulario 
        * enlace de llamada:
        * <a id="call-php" href="#" data-target="messagesout" php-function="common/index/viewScreen/module/controller/open_ml_empresa">Nuevo</a>
        */
        function open_credit_detail($id = 0) {
            $res['id'] = $id;
            $this->load->view("credit_detail", $res);
        }

        /**
         * Almacena o actualiza detalles del credito
         * @param type $param
         */
        public function save() {
            $id = set_post_value('id', 0);           
            $credit_detail = new \gestcobra\credit_detail_model($id);
            $credit_detail->credit_status_id = set_post_value('credit_status_id');
                if (!$credit_detail->is_valid()) {
                    $errors = $credit_detail->validate(); $str_errors = arraytostr($errors);
                    errorAlert($str_errors[2],lang('ml_error')); $this->db->trans_rollback(); 
                    return false;
                } else {
                    $credit_detail->save();
                    $this->_save_credit_hist($credit_detail->id);
                  
                    successAlert(lang('ml_success_msg'), lang('ml_success'));
                }
        }        

}