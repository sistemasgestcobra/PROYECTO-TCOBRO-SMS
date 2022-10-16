<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Creditstatus extends CI_Controller {
            
    function __construct() {
        parent::__construct();
        // Ignorar los abortos hechos por el usuario y permitir que el script
        // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
        ignore_user_abort(true);
        set_time_limit(0);
        
    }
    
    public function get_report() {
        $this->load->model('creditstatus_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $limit = 100;
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));

        $order_by = array($sort => $order);

        $res = $this->creditstatus_model->get_data($limit, $offset, $filter, $order_by);
        $total = $this->creditstatus_model->get_count($filter);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }
    
	public function get_envio_hist_report(){
        $this->load->model('envio_hist_model');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort=>$order);
        $res = $this->envio_hist_model->get_hist_data( $limit, $offset,$order_by);
        $total = $this->envio_hist_model->get_hist_count();
        echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
    }

    public function edit_template($id = 0) {
        $res['id'] = $id;
        $res['view_name'] = 'admin/ml_notification_format_template';
        $this->load->view('common/templates/dashboard', $res);
    }

    public function save() {
        $id = set_post_value('id');
        $lote = set_post_value('lote');
        if ($lote == 1) {
            $this->save_update();
        } else {
            $credit_status = new \gestcobra\notification_format_model($id);
            $credit_status->status_name = set_post_value('status_name');
            $credit_status->color = set_post_value('color');
            $credit_status->background = set_post_value('background');
            $credit_status->save();
            successAlert(lang('ml_success_msg'), lang('ml_success'));
        }
    }
	
	 public function CambioPendiente() {       
        $id = set_post_value('credit_status_model');       
        $credit_detail = (new \gestcobra\credit_detail_model())
                ->where_in('credit_status_id', $id)
                ->find();


        $credit_detail_array = array();
        foreach ($credit_detail as $credit) {
            array_push($credit_detail_array, $credit->id);
        }

        if ($credit_detail_array) {
            foreach ($credit_detail_array as $value) {
         $credit_detail_1 = (new \gestcobra\credit_detail_model())
                ->where('id', $value)
                ->find_one();
                $credit_detail_1->credit_status_id = 1;
                $credit_detail_1->save();
                successAlert(lang('ml_success_msg'), lang('ml_success'));
            }
        } 
    }
	
    public function save_update() {
        $ids = set_post_value('id');
        $status_name = set_post_value('status_name');
        $color = set_post_value('color');
        $background = set_post_value('background');
        $cont = 0;
        $this->db->where_not_in( 'id', $ids); 
        $this->db->where( 'company_id', $this->user->company_id); 
        $this->db->delete('credit_status');
        foreach ($ids as $value) {
            $credit_status = new gestcobra\credit_status_model($value);
            
            if (!empty($status_name[$cont]) AND $status_name[$cont] != 'undefined' AND $status_name[$cont] != 'null') {
                $credit_status->status_name = $status_name[$cont];
                $credit_status->color = $color[$cont];
                $credit_status->background = $background[$cont];
                $credit_status->company_id = $this->user->company_id;
                $credit_status->save();
                $cont++;
            }
        }
           
        successAlert(lang('ml_success_msg'), lang('ml_success'));
        ?>
        <script>
            $("#table_credit_status").bootstrapTable('refresh');
        </script>
        <?php

    }

}
