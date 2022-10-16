<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bases extends CI_Controller {
               
	function __construct() {
 		parent::__construct();
                // Ignorar los abortos hechos por el usuario y permitir que el script
                // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
                ignore_user_abort(true);                
	}
        
        public function get_bases_report(){
            $this->load->model('bases_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = 3000;
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->bases_model->get_oficina_company_data( $limit, $offset, $filter, $order_by );
            $total = $this->bases_model->get_oficina_company_count( $filter );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        function open_contactos($id = 0) {
        $res['id'] = $id;
        $this->load->view("lista_contactos", $res);
    }
        public function save(){
            $ids = set_post_value('id');
            
            $nombre = set_post_value('nombre');
            $observaciones = set_post_value('observaciones');
            $cont = 0;
            
            $this->db->where_not_in( 'id', $ids); 
              $this->db->delete('grupo');
        
            if($ids){
                foreach($ids as $value) {
                    $grupo= new \gestcobra\grupo_model($value);
                    if(!empty($nombre[$cont]) AND $observaciones[$cont] != 'undefined'){
                        $grupo->nombre = $nombre[$cont];
                        $grupo->observaciones = $observaciones[$cont];
                        $grupo->save();
                        $cont++;     
//                        array_push($ids, $grupo->id);
                    }
                }
            }

            successAlert( lang('ml_success_msg'), lang('ml_success') );
            ?>
                <script>
                    $("#table_bases").bootstrapTable('refresh');
                </script>
            <?php
        }
        /* Llamada al formulario 
        * enlace de llamada:
        * <a id="call-php" href="#" data-target="messagesout" php-function="common/index/viewScreen/module/controller/open_ml_empresa">Nuevo</a>
        */
        function open_ml_empresa($id = 0) {
            $res['id'] = $id;
            $this->load->view("ml_company", $res);
        }
        
        
        
}