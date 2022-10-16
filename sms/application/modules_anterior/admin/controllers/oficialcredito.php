<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Oficialcredito extends CI_Controller {
               
	function __construct() {
 		parent::__construct();
                // Ignorar los abortos hechos por el usuario y permitir que el script
                // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
                ignore_user_abort(true);                
	}
        public function get_oficial_credito_report(){
            $this->load->model('oficial_credito_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
             $limit = 100;
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->oficial_credito_model->get_oficial_credito_data( $limit, $offset, $filter, $order_by );
            $total = $this->oficial_credito_model->get_oficial_credito_count( $filter );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
        /* Llamada al formulario 
        * enlace de llamada:
        * <a id="call-php" href="#" data-target="messagesout" php-function="common/index/viewScreen/module/controller/open_ml_empresa">Nuevo</a>
        */
        function open_ml_empresa($id = 0) {
            $res['id'] = $id;
            $this->load->view("ml_company", $res);
        }
        
        public function save(){
            $ids = set_post_value('id');
            $firstname = set_post_value('firstname');
            $lastname = set_post_value('lastname');
            $email = set_post_value('email');
            $role_id = set_post_value('role_id');
            $oficina_company_id = set_post_value('oficina_company_id');
            $oficial_credito_status = set_post_value('oficial_credito_status');            
            $cont = 0;
            foreach ($ids as $value) {
                $nuevo=1;
                $oficial = new \gestcobra\oficial_credito_model($value);
               if($value=='undefined'){
                   $nuevo=0;
               }
               
                if( !empty($firstname[$cont]) AND $firstname[$cont] != 'undefined'){
                    $oficial->company_id = $this->user->company_id;
                    $oficial->firstname = $firstname[$cont];
                    $oficial->lastname = $lastname[$cont];
                    if($nuevo==0){
                        $oficial->email = $email[$cont];
                        $oficial->password = $this->encrypt_password_callback('1234');
                    }else{
                        $oficial->email = $email[$cont];
                    }
                    $oficial->role_id = $role_id[$cont];
                    $oficial->oficina_company_id = $oficina_company_id[$cont];
                    $oficial->status = $oficial_credito_status[$cont];
                    $oficial->save();
                    $cont++;
                    array_push($ids, $oficial->id);
                }
            }
            $this->db->where_not_in( 'id', $ids); 
            $this->db->where('company_id', $this->user->company_id); 
            //$this->db->update('oficial_credito', array('status'=>'-1') );                        
            echo $this->db->last_query();
            successAlert(lang('ml_success_msg'),lang('ml_success'));
            ?>
                <script>
                    $("#table_oficiales").bootstrapTable('refresh');
                </script>
            <?php
        }
        
        public function open_view($id){
            $res['oficial'] = new \gestcobra\oficial_credito_model($id);
            $this->load->view('ml_oficial_credito', $res);
        }
        
      
        
        /**
         * En esta funcion se actualiza el password y la imagen de perfil
         */
        public function update_password() {
            $id = set_post_value('id');
            $oficial = new \gestcobra\oficial_credito_model($id);
            
            $oficial->password = $this->encrypt_password_callback(set_post_value('password'));
            
            
            $this->_save_profile_image( $id );
            
            $oficial->save(); 
            successAlert(lang('ml_success_msg'), lang('ml_success'));
        }

        function encrypt_password_callback($clave)
        {
            $pass_word = (new gestcobra\setup_model())->where('variable', 'PASSWORDSALTMAIN')->find_one()->valor;
            $encryptedPass = MD5($clave.$pass_word);   
            return $encryptedPass;
        }  
        
        /**
         * Guardar Imagen de Perfil
         * @param type $persona_id
         */
        private function _save_profile_image( $persona_id ) {
                foreach ($_FILES as $key => $value) {
                    if( $key == 'profile_image' ){
                        $logo_path = './uploads/user/'.$persona_id.'/profile_image/';
                            $this->load->helper('form');            
                            makedirs($logo_path, $mode=0755); 
                            $config['upload_path'] = $logo_path;
                            $config['allowed_types'] = 'gif|jpg|png';
                            $config['max_size']	= '1000';
                            $config['max_width']  = '1024';
                            $config['max_height']  = '768';
                            $this->load->library('upload', $config);            

                            if ( ! $this->upload->do_upload($key)) {
                                    $error = array('error' => $this->upload->display_errors());
                                    toast($this->upload->display_errors(), lang('ml_error'), 'warning');
                            } else {
                                $upl_data = $this->upload->data();
                                $ml_persona = new \gestcobra\oficial_credito_model($persona_id);
                                $ml_persona->profile_image = $upl_data['file_name'];
                                $ml_persona->save();
                        }  
                        break;
                    }
                }
        }        
}

