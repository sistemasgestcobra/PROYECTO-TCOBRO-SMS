<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Credit extends CI_Controller {
               
	function __construct() {
 		parent::__construct();
                // Ignorar los abortos hechos por el usuario y permitir que el script
                // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
                ignore_user_abort(true); 
                
	}
        public function get_credit_detail_report(){
            $this->load->model('credit_detail_model');
            
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            
            $order_by = array($sort=>$order);
            
            $res = $this->credit_detail_model->get_credit_detail_data( $limit, $offset, $filter, $order_by );
            $total = $this->credit_detail_model->get_credit_detail_count( $filter );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
                

        public function get_hist_report(){
            $this->load->model('credit_hist_model');
            
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            
            $order_by = array($sort=>$order);
            
            $res = $this->credit_hist_model->get_hist_data( $limit, $offset, $filter, $order_by );
            $total = $this->credit_hist_model->get_hist_count( $filter );
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
                if ( ! $credit_detail->is_valid() ) {
                    $errors = $credit_detail->validate(); $str_errors = arraytostr($errors);
                    errorAlert($str_errors[2], lang('ml_error')); $this->db->trans_rollback();
                    return false;
                } else {
                    $credit_detail->save();
                    $this->_save_credit_hist($credit_detail->id);
                    $this->_save_client( $credit_detail->client_id);
                    /**
                     * 1 = Garantes
                     */
                    $this->_save_ref_client( $credit_detail->client_id, 1);
                    /**
                     * 2 = Referencias
                     */
                    $this->_save_ref_client( $credit_detail->client_id, 2);
                    successAlert(lang('ml_success_msg'), lang('ml_success'));
                }
        }
        
        private function _save_credit_hist($credit_detail_id) {
            $credti_hist = new gestcobra\credit_hist_model();
            $credti_hist->credit_detail_id = $credit_detail_id;
            $credti_hist->detail = set_post_value('detail');
            $credti_hist->hist_date = date('Y-m-d', time());
            $credti_hist->hist_time = date('H:i:s', time());
            $credti_hist->credit_status_id = set_post_value('credit_status_id');
            $credti_hist->compromiso_pago_date = set_post_value('compromiso_pago_date');
            $credti_hist->user_id = $this->user->id;
            $credti_hist->save();
        }
        
        /**
         * Informacion del cliente
         * @param type $param
         */
        private function _save_client( $client_id ) {
            $client = new gestcobra\client_model($client_id);
            $persona = new gestcobra\person_model($client->person_id);
            $persona->firstname = set_post_value('firstname');
            $persona->lastname = set_post_value('lastname');
            $persona->personal_phone = set_post_value('personal_phone');
            $persona->personal_address = set_post_value('personal_address');
            $persona->address_ref = set_post_value('address_ref');
            $persona->save();
        }
        
        /**
         * Informacion de la referencia del cliente
         * @param type $param
         */
        private function _save_ref_client( $client_id, $reference_type_id ) {
            
            $reference_client = (new gestcobra\client_referencias_model())
                    ->where('client_id', $client_id)->where('reference_type_id', $reference_type_id)->find_one();
            
            $persona = new gestcobra\person_model($reference_client->person_id);
            $persona->firstname = set_post_value($reference_type_id.'_firstname');
            $persona->lastname = set_post_value($reference_type_id.'_lastname');
            $persona->personal_phone = set_post_value($reference_type_id.'_personal_phone');
            $persona->personal_address = set_post_value($reference_type_id.'_personal_address');
            $persona->address_ref = set_post_value($reference_type_id.'_address_ref');
            $persona->save();
            
            $reference_client->client_id = $client_id;
            $reference_client->person_id = $persona->id;            
            $reference_client->reference_type_id = $reference_type_id;            
            $reference_client->save();
        }

}

