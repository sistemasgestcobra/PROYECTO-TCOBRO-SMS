<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Comision extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Ignorar los abortos hechos por el usuario y permitir que el script
        // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
        ignore_user_abort(true);
    }

    public function get_report() {
        $this->load->model('comision_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
         $limit = 100;
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $this->comision_model->get_data($limit, $offset, $filter, $order_by);
        $total = $this->comision_model->get_count($filter);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }

    public function edit_template($id = 0) {
        $res['id'] = $id;
        $res['view_name'] = 'admin/ml_notification_format_template';
        $this->load->view('common/templates/dashboard', $res);
    }

    
    public function notifications_save() {
        $notification_id_notification = set_post_value('notification_id');
        $notif_id = set_post_value('notif_id');
        $message_format = $notif_id[0];
        $credit_detail_check = set_post_value('c_d_id');
        $reference_type_ids = set_post_value('reference_type_model');
        if($credit_detail_check){
            foreach ($credit_detail_check as $credit_det) {
                $credit_data = new \gestcobra\credit_detail_model($credit_det);
                //print_r($client_data->id);
                $array_persons_id = array();
                $referencias = (new \gestcobra\client_referencias_model())
                        ->where('status', 1)
                        ->where('credit_detail_id', $credit_det)
                        ->where_in('reference_type_id', $reference_type_ids)
                        ->find();
                $referencia_deudor = (new \gestcobra\client_referencias_model())
                        ->where('status', 1)
                        ->where('credit_detail_id', $credit_data->id)
                        ->where_in('reference_type_id', '3')
                        ->find_one();
                $get_company = new gestcobra\company_model($this->user->company_id);
                foreach ($referencias as $ref) {
                    array_push($array_persons_id, $ref->person_id);
                }
                $this->save_comunication('visita', $credit_det, '-1', '', "visita", '', $referencia_deudor, $notification_id_notification);
            }
            successAlert(lang('ml_success_msg'), lang('ml_success'));
        }
    }


    public function save(){
        $id = set_post_value('id');
        $lote = set_post_value('lote');
        if ($lote == 1) {
            $this->save_update();
        } else {
            $notification_format = new \gestcobra\notification_format_model($id);
            $notification_format->format = set_post_value('template_data');
            $notification_format->company_id = $this->user->company_id;
            $notification_format->save();
            successAlert(lang('ml_success_msg'), lang('ml_success'));
        }
    }

    public function save_update(){
        $ids = set_post_value('id');
        $description = set_post_value('description');
        $type = set_post_value('type');
        $activo = set_post_value('notification_format_status');
        $cont = 0;
        $this->db->where_not_in( 'id', $ids); 
        $this->db->where('company_id', $this->user->company_id);
        echo 'company_id';
        echo $this->user->company_id;
        $this->db->update('notification_format', array('status'=>'-1') );    
        foreach ($ids as $value){
            $notification = new gestcobra\notification_format_model($value);
            if (!empty($description[$cont]) AND $description[$cont] != 'undefined' AND $description[$cont] != 'null') {
                $notification->description = $description[$cont];
                $notification->type = $type[$cont];
                $notification->status = '1';
                $notification->company_id = $this->user->company_id;
                $notification->save();
                $cont++;
            }
        }
        //=========================================================================
                            
        echo $this->db->last_query();
        //=========================================================================
        successAlert(lang('ml_success_msg'), lang('ml_success'));
        ?>
        <script>
            $("#table_notif").bootstrapTable('refresh');
        </script>
        <?php
    }
    public function save_comi() {
             $ids = set_post_value('id');
            $nombre = set_post_value('name');
            $valor = set_post_value('direccion');
            $cont = 0;
            if($ids){
                foreach($ids as $value) {
                    $oficial = new \gestcobra\comision_cobranzas_model($value);
                    if(!empty($nombre[$cont]) AND $valor[$cont] != 'undefined'){
                        $oficial->company_id = $this->user->company_id;
                        $oficial->nombre_comision = $nombre[$cont];
                        $oficial->valor_comision = $valor[$cont];
                        $oficial->save();
                        $cont++;     
                        array_push($ids, $oficial->id);
                    }
                }
            }
            $value_company_id=$this->user->company_id;
            $this->db->where_not_in( 'id', $ids); 
            $this->db->where('company_id', $value_company_id); 
           $this->db->update('comision_cobranzas', array('status'=>'-1') );  
            echo $this->db->last_query();
            successAlert( lang('ml_success_msg'), lang('ml_success') );
            ?>
                <script>
                    $("#table_comi").bootstrapTable('refresh');
                </script>
            <?php   
    }
    
    
    public function open_view($id){
        $res['id'] = $id;
        $this->load->view('ml_notification_message', $res);
    }
}
