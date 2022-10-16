<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contactos extends MX_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->user->check_session();


        // Ignorar los abortos hechos por el usuario y permitir que el script
        // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
        ignore_user_abort(true);
    }
public function get_contactos($id_grupo){
            $this->load->model('contactos_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
           // $limit = 2;
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->contactos_model->get_oficina_company_data( $limit, $offset,$filter, $order_by,$id_grupo );
            $total = $this->contactos_model->get_oficina_company_count( $filter,$id_grupo);
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
       
        public function save() {
        
          $ids = set_post_value('id');
          $idg = set_post_value('idg');
          
            $numero = set_post_value('numero');
            $nombre = set_post_value('nombre');
            
            $variable1 = set_post_value('variable1');
            $variable2 = set_post_value('variable2');
            $variable3 = set_post_value('variable3');
            $variable4 = set_post_value('variable4');
            $cont = 0;
            
             $contactos = (new gestcobra\contact_grupo_model())
                ->where('id_grupo', $idg)
                ->find();
        $contactos_array = array();
       
        foreach ($contactos as $contact) {
            array_push($contactos_array, $contact->id);
        }
        
if ($contactos_array) {
            foreach ($contactos_array as $value) {
                /**
                 * Se eliminan contactos referentes a la persona
                 */
                 
                $this->db->delete('contact_grupo', array('id' => $value));
            }
        }            
            
         if($ids){
                foreach($ids as $value) {
                    $contacto= new \gestcobra\contact_grupo_model($value);
                    if(!empty($numero[$cont]) AND $nombre[$cont] != 'undefined'){
                        $contacto->numero = $numero[$cont];
                        $contacto->nombre = $nombre[$cont];
                        
                        $contacto->variable1 = $variable1[$cont];
                        $contacto->variable2 = $variable2[$cont];
                        $contacto->variable3 = $variable3[$cont];
                        $contacto->variable4 = $variable4[$cont];
                        $contacto->id_grupo = $idg;
                        $contacto->save();
                        $cont++;     
//                        array_push($ids, $grupo->id);
                    }
                }
            }
    
         successAlert( lang('ml_success_msg'), lang('ml_success') );
            ?>
                <script>
                    $("#table_contact_grupo").bootstrapTable('refresh');
                </script>
            <?php
        }
    
        
        
        
}
