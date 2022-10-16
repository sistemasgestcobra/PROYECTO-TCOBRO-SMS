<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agenciacharts extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    private $from_date;
    private $to_date;
    private $oficina_company_id;
    
    /**
     * 
     */
    
    public function get_chart_by_agencia_hist() {
        $this->load->library('highcharts');
       // $this->load->model('credit_detail_model');
        $this->from_date = set_post_value('from_date');
        $this->to_date = set_post_value('to_date');
        $type_group = set_post_value('type_group');
        $search_type = set_post_value('search_type');
        $comparar = set_post_value('comparar');
        $oficial_id = set_post_value('oficial_id');
        $this->oficina_company_id = set_post_value('oficina_company_id');
//      $res['data'] = $this->credit_detail_model->get_report_by_day( $this->from_date,$this->to_date, $type_group, $search_type, $oficial_id, $oficina_company_id, $comparar);
        $res['type_group'] = $type_group;
        $res['search_type'] = $search_type;
        $res['comparar'] = $comparar;
        $res['oficial_id'] = $oficial_id;
        $oficina_company = new gestcobra\oficina_company_model($this->oficina_company_id);
        $compania = new gestcobra\company_model($oficina_company->company_id);
        $fecha = date("m/d/Y");
        $title_chart = $this->load->view('title_chart', $res, TRUE);
        //$this->highcharts->set_title($title_chart, 'Oficial: Esteban Chamb');
        $this->highcharts->set_title('<h4>' . $compania->nombre_comercial . '</h4><br/><strong>Fecha actual: </strong>' . $fecha . '<br/><strong>REPORTE POR AGENCIA: </strong><br/><strong>Agencia: </strong>' . $oficina_company->name . '<br/><br/><strong>Desde: </strong>' . $this->from_date . ' <br/><strong>Hasta: </strong>' . $this->to_date . ' <br/>');
        
        $oficial= (new gestcobra\oficial_credito_model()) 
                ->where('id', $this->user->id)
                ->where('oficina_company_id', $this->oficina_company_id)
                ->find();
        
        if (empty($oficial)) {
        
            
            successAlert(lang('ml_error_agencia'), lang('ml_error'));
            
            
            
        }  else {
        
        
        if ($this->oficina_company_id > 0) {
            $this->_get_pie_date_hist($this->from_date, $this->to_date);
        } elseif ($this->oficina_company_id == -1) {
            $this->active_record_hist();
        }
        
        }
    }

    public function get_chart_by_agencia() {
        $this->load->library('highcharts');
        $this->load->model('credit_detail_model');
        $this->from_date = set_post_value('from_date');
        $this->to_date = set_post_value('to_date');
        $type_group = set_post_value('type_group');
        $search_type = set_post_value('search_type');
        $comparar = set_post_value('comparar');
        $oficial_id = set_post_value('oficial_id');
        $this->oficina_company_id = set_post_value('oficina_company_id');
//          $res['data'] = $this->credit_detail_model->get_report_by_day( $this->from_date,$this->to_date, $type_group, $search_type, $oficial_id, $oficina_company_id, $comparar);
        $res['type_group'] = $type_group;
        $res['search_type'] = $search_type;
        $res['comparar'] = $comparar;
        $res['oficial_id'] = $oficial_id;

        $oficina_company = new gestcobra\oficina_company_model($this->oficina_company_id);
        $compania = new gestcobra\company_model($oficina_company->company_id);
        $fecha = date("m/d/Y");
        $title_chart = $this->load->view('title_chart', $res, TRUE);

       
        /*         * ******************************************************************************* */
        
            $this->highcharts->set_title('<h4>' . $compania->nombre_comercial . '</h4><br/><strong>Fecha actual: </strong>' . $fecha . '<br/><strong>REPORTE POR AGENCIA: </strong><br/><strong>Agencia: </strong>' . $oficina_company->name . '<br/><br/><strong>Desde: </strong>' . $this->from_date . ' <br/><strong>Hasta: </strong>' . $this->to_date . ' <br/>');
        
        
        if ($this->oficina_company_id > 0) {
            $this->_get_pie_date($this->from_date, $this->to_date);
        } elseif ($this->oficina_company_id == -1) {
            $this->active_record();
        
        
        }
    }

    private function _get_pie_date_hist($from_date, $to_date) {
        $serie['data'] = array();
        $credit_status = (new \gestcobra\credit_status_model())
                ->where('company_id', $this->user->company_id)
                ->find();

        foreach ($credit_status as $value) {
            $credit_detail_data = (new gestcobra\credit_detail_model())
                    ->where('curr_date >=', $from_date)
                    ->where('curr_date <=', $to_date)
                    ->where('oficina_company_id', $this->oficina_company_id)
                    ->find();
            if ($this->user->role_id == 1) {
                $credit_detail_data->where('oficial_credito_id', $this->user->id);
            }
            $credit_detail_id_array = array();
            foreach ($credit_detail_data as $value_credit_detail_data) {
                array_push($credit_detail_id_array, $value_credit_detail_data->id);
            }

            $tot_status = (new gestcobra\credit_hist_model())
                    ->where('hist_date >=', $from_date)
                    ->where('hist_date <=', $to_date)
                    ->where('credit_status_id', $value->id);
            //->where_in('credit_detail_id', $credit_detail_id_array);
            //            /**
            //             * Si es un oficial de credito, presenta solo los que le pertenecen
            //             */
            if ($credit_detail_id_array) {
                //if ($this->user->role_id == 1) {
                $tot_status = $tot_status->where_in('credit_detail_id', $credit_detail_id_array);
                //}
            }

            $tot_status = $tot_status->count();
            array_push($serie['data'], array($value->status_name, $tot_status));
        }
        $callback = "function() { return '<b>'+ this.point.name +'</b>: '+ this.y}";
        @$tool->formatter = $callback;
        @$plot->pie->dataLabels->formatter = $callback;
        $this->highcharts
                ->set_type('pie')
                ->set_serie($serie)
                ->set_tooltip($tool)
                ->set_plotOptions($plot);
        $data['charts'] = $this->highcharts->render();
        $this->load->view('charts', $data);
    }

    private function _get_pie_date($from_date, $to_date) {
        $serie['data'] = array();
        $credit_status = (new \gestcobra\credit_status_model())
                ->where('company_id', $this->user->company_id)
                ->find();

        foreach ($credit_status as $value) {
            $tot_status = (new gestcobra\credit_detail_model())
                    ->where('curr_date >=', $from_date)
                    ->where('curr_date <=', $to_date)
                    ->where('oficina_company_id', $this->oficina_company_id)
                    ->where('credit_status_id', $value->id);

            //            /**
            //             * Si es un oficial de credito, presenta solo los que le pertenecen
            //             */
            if ($this->user->role_id == 1) {
                $tot_status = $tot_status->where('oficial_credito_id', $this->user->id);
            }
            $tot_status = $tot_status->count();

            array_push($serie['data'], array($value->status_name, $tot_status));
        }
        $callback = "function() { return '<b>'+ this.point.name +'</b>: '+ this.y}";
        @$tool->formatter = $callback;
        @$plot->pie->dataLabels->formatter = $callback;
        $this->highcharts
                ->set_type('pie')
                ->set_serie($serie)
                ->set_tooltip($tool)
                ->set_plotOptions($plot);

        $data['charts'] = $this->highcharts->render();
        $this->load->view('charts', $data);
    }

    public function active_record() {
        $credit_status = (new gestcobra\credit_status_model())
                ->where('company_id', $this->user->company_id)
                ->find();
        $result = $this->_ar_data($credit_status);

        // set data for conversion
        $dat1['x_labels'] = 'contries'; // optionnal, set axis categories from result row
//		$dat1['series'] 	= array('users', 'population'); // set values to create series, values are result rows
        $dat1['series'] = array(); // set values to create series, values are result rows

        foreach ($credit_status as $value) {
            array_push($dat1['series'], $value->status_name);
        }


        $dat1['data'] = $result;

        // just made some changes to display only one serie with custom name
//		$dat2 = $dat1;
//		$dat2['series'] = array('custom name' => 'users');

        $this->load->library('highcharts');

        // displaying muli graphs
        $this->highcharts->from_result($dat1)->add(); // first graph: add() register the graph
//		$this->highcharts
//			->initialize('chart_template')
//			->set_dimensions('', 200) // dimension: width, height
//			->from_result($dat2)
//			->add(); // second graph

        $data['charts'] = $this->highcharts->render();
        $this->load->view('charts', $data);
    }

    public function active_record_hist() {
        $credit_status = (new gestcobra\credit_status_model())
                ->where('company_id', $this->user->company_id)
                ->find();
        $result = $this->_ar_data_hist($credit_status);

        // set data for conversion
        $dat1['x_labels'] = 'contries'; // optionnal, set axis categories from result row
//		$dat1['series'] 	= array('users', 'population'); // set values to create series, values are result rows
        $dat1['series'] = array(); // set values to create series, values are result rows

        foreach ($credit_status as $value) {
            array_push($dat1['series'], $value->status_name);
        }

        $dat1['data'] = $result;
        // just made some changes to display only one serie with custom name
//		$dat2 = $dat1;
//		$dat2['series'] = array('custom name' => 'users');

        $this->load->library('highcharts');

        // displaying muli graphs
        $this->highcharts->from_result($dat1)->add(); // first graph: add() register the graph
//		$this->highcharts
//			->initialize('chart_template')
//			->set_dimensions('', 200) // dimension: width, height
//			->from_result($dat2)
//			->add(); // second graph

        $data['charts'] = $this->highcharts->render();
        $this->load->view('charts', $data);
    }

    // HELPERS FUNCTIONS
    /**
     * _data function.
     * data for examples
     */
    function _data_hist($credit_status) {

//		$data['users']['data'] = array(500, 80, 20, 8, 250);
//		$data['users']['name'] = 'Users by Language';
//		$data['popul']['data'] = array(30, 15, 200, 300, 125);
//		$data['popul']['name'] = 'World Population';

        /**
         * Obtener los oficiales de credito
         */
        $agencias = (new gestcobra\oficina_company_model())
                ->where('company_id', $this->user->company_id)
                ->where('status', 1)
                ->find();

        $data['axis']['categories'] = array();
        foreach ($agencias as $agencia) {
            array_push($data['axis']['categories'], $agencia->name);
        }



        foreach ($credit_status as $status) {
//                echo $value->status_name;

            $data_status = array();
            $cont = 0;
            
            foreach ($agencias as $agencia){
                $credit_detail_data = (new gestcobra\credit_detail_model())
                        /*->where('curr_date >=', $this->from_date)
                        ->where('curr_date <=', $this->to_date)*/
                        ->where('company_id', $this->user->company_id)
                        ->where('oficina_company_id', $agencia->id)
                        ->find();
            
                if ($this->user->role_id == 1){
                    $credit_detail_data->where('oficial_credito_id', $this->user->id)->find();
                }
                $credit_detail_id_array = array();
                foreach ($credit_detail_data as $value_credit_detail_data) {
                    array_push($credit_detail_id_array, $value_credit_detail_data->id);
                }
                
            //->where_in('credit_detail_id', $credit_detail_id_array);
            //            /**
            //             * Si es un oficial de credito, presenta solo los que le pertenecen
            //             */
            $count_credit=0;
            if ($credit_detail_id_array) {
                $count_credit=(new gestcobra\credit_hist_model())
                    ->where('hist_date >=', $this->from_date)
                    ->where('hist_date <=', $this->to_date)
                    ->where('credit_status_id', $status->id);
                //if ($this->user->role_id == 1) {
                $count_credit = $count_credit->where_in('credit_detail_id', $credit_detail_id_array)->count();
                //}
            }
                /*$count_credit = (new gestcobra\credit_detail_model())
                        ->where('curr_date >=', $this->from_date)
                        ->where('curr_date <=', $this->to_date)
                        ->where('oficina_company_id', $agencia->id)
                        ->where('credit_status_id', $status->id)
                        ->count();*/
//                    $cont++;
                if ($count_credit == 0) {
                    $count_credit = 0.00000001;
                }
                array_push($data_status, $count_credit);
            }

            $data[$status->status_name]['data'] = $data_status;
        }

        return $data;
    }

    function _data($credit_status) {

//		$data['users']['data'] = array(500, 80, 20, 8, 250);
//		$data['users']['name'] = 'Users by Language';
//		$data['popul']['data'] = array(30, 15, 200, 300, 125);
//		$data['popul']['name'] = 'World Population';

        /**
         * Obtener los oficiales de credito
         */
        $agencias = (new gestcobra\oficina_company_model())
                ->where('company_id', $this->user->company_id)
                ->where('status', 1)
                ->find();

        $data['axis']['categories'] = array();
        foreach ($agencias as $agencia) {
            array_push($data['axis']['categories'], $agencia->name);
        }



        foreach ($credit_status as $status) {
//                echo $value->status_name;

            $data_status = array();
            $cont = 0;
            foreach ($agencias as $agencia) {
                $count_credit = (new gestcobra\credit_detail_model())
                        ->where('curr_date >=', $this->from_date)
                        ->where('curr_date <=', $this->to_date)
                        ->where('oficina_company_id', $agencia->id)
                        ->where('credit_status_id', $status->id)
                        ->count();
//                    $cont++;
                if ($count_credit == 0) {
                    $count_credit = 0.00000001;
                }

                array_push($data_status, $count_credit);
            }

            $data[$status->status_name]['data'] = $data_status;
        }

        return $data;
    }

    /**
     * _ar_data function.
     * simulate Active Record result
     */
    function _ar_data($credit_status) {
        $data = $this->_data($credit_status);

        $cont = 0;
//		foreach ($credit_status as $val)
//		{

        for ($i = 0; $i < count($data['axis']['categories']); $i++) {
            $output[] = (object) array();
            $output[$cont]->contries = $data['axis']['categories'][$cont];
            foreach ($credit_status as $status) {
                $output[$cont]->{$status->status_name} = $data[$status->status_name]['data'][$cont];
            }

            $cont++;
        }

//                print_r($output) ;

        return $output;
    }

    function _ar_data_hist($credit_status) {
        $data = $this->_data_hist($credit_status);

        $cont = 0;
//		foreach ($credit_status as $val)
//		{

        for ($i = 0; $i < count($data['axis']['categories']); $i++) {
            $output[] = (object) array();
            $output[$cont]->contries = $data['axis']['categories'][$cont];
            foreach ($credit_status as $status) {
                $output[$cont]->{$status->status_name} = $data[$status->status_name]['data'][$cont];
            }

            $cont++;
        }

//                print_r($output) ;

        return $output;
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */