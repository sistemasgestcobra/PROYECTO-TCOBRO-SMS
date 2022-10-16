<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Referencias extends CI_Controller {
               
	function __construct() {
 		parent::__construct();
                // Ignorar los abortos hechos por el usuario y permitir que el script
                // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
                ignore_user_abort(true);                
	}
        /**
         * Obtiene las referencias que un cliente tiene asignnadas
         * @param type $client_id
         */
        public function get_referencias_client($client_id){
            $this->load->model('client_referencias_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);   
            $res = $this->client_referencias_model->get_data( $limit, $offset, $filter, $order_by, $client_id );
            $total = $this->client_referencias_model->get_count( $filter, $client_id );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
        public function get_referencias_client_contact($client_id){
            $this->load->model('client_referencias_contact_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->client_referencias_contact_model->get_data( $limit, $offset, $filter, '', $client_id );
            $total = $this->client_referencias_contact_model->get_count( $filter, $client_id );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
        /* Llamada al formulario 
        * enlace de llamada:
        * <a id="call-php" href="#" data-target="messagesout" php-function="common/index/viewScreen/module/controller/open_ml_empresa">Nuevo</a>
        */
      

        /**
         * Almacena o actualiza detalles del credito
         * @param type $param
         */
       

}

