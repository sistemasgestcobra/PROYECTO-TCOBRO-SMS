<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Oficialcharts extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    private $from_date;
    private $to_date;
    private $oficial_credito_id;

    /**
     * 
     */
    public function get_chart_by_oficial() {
        $this->load->library('highcharts');
        $this->from_date = set_post_value('from_date');
        $this->to_date = set_post_value('to_date');
        $type_group = set_post_value('type_group');
        $search_type = set_post_value('search_type');
        $comparar = set_post_value('comparar');
        $oficial_credito_id = set_post_value('oficial_credito_id');
        $this->oficial_credito_id = set_post_value('oficial_credito_id');
        $res['type_group'] = $type_group;
        $res['search_type'] = $search_type;
        $res['comparar'] = $comparar;
        $res['oficial_credito_id'] = $oficial_credito_id;
        $fecha = date("m/d/Y");
        $oficial_credito_data = new gestcobra\oficial_credito_model($oficial_credito_id);
        $company_data = new gestcobra\company_model($oficial_credito_data->company_id);
        $title_chart = $this->load->view('title_chart', $res, TRUE);
        $this->highcharts->set_title('<h4>' . $company_data->nombre_comercial . '</h4><br/><strong>Fecha actual: </strong>' . $fecha . '<br/><strong>REPORTE POR OFICIAL DE CREDITO: </strong><br/><strong>Oficial de Cred: </strong>' . $oficial_credito_data->firstname . ' ' . $oficial_credito_data->lastname . '<br/><br/><strong>Desde: </strong>' . $this->from_date . ' <br/><strong>Hasta: </strong>' . $this->to_date . ' <br/>');
        /*         * ******************************************************************************* */
        if ($this->oficial_credito_id > 0) {
            $this->_get_pie_date($this->from_date, $this->to_date);
        } elseif ($this->oficial_credito_id == -1) {
            $this->active_record();
        }
    }

    public function get_chart_by_oficial_hist() {
        $this->load->library('highcharts');
        $this->from_date = set_post_value('from_date');
        $this->to_date = set_post_value('to_date');
        $type_group = set_post_value('type_group');
        $search_type = set_post_value('search_type');
        $comparar = set_post_value('comparar');
        $oficial_credito_id = set_post_value('oficial_credito_id');
        $this->oficial_credito_id = set_post_value('oficial_credito_id');
        $res['type_group'] = $type_group;
        $res['search_type'] = $search_type;
        $res['comparar'] = $comparar;
        $res['oficial_credito_id'] = $oficial_credito_id;
        $fecha = date("m/d/Y");
        $oficial_credito_data = new gestcobra\oficial_credito_model($oficial_credito_id);
        $company_data = new gestcobra\company_model($oficial_credito_data->company_id);
        $title_chart = $this->load->view('title_chart', $res, TRUE);
        $this->highcharts->set_title('<h4>' . $company_data->nombre_comercial . '</h4><br/><strong>Fecha actual: </strong>' . $fecha . '<br/><strong>REPORTE POR OFICIAL DE CREDITO: </strong><br/><strong>Oficial de Cred: </strong>' . $oficial_credito_data->firstname . ' ' . $oficial_credito_data->lastname . '<br/><br/><strong>Desde: </strong>' . $this->from_date . ' <br/><strong>Hasta: </strong>' . $this->to_date . ' <br/>');
        if($this->oficial_credito_id > 0) {
            $this->_get_pie_date_hist($this->from_date, $this->to_date);
        }elseif ($this->oficial_credito_id == -1) {
            $this->active_record_hist();
        }
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
                    ->where('oficial_credito_id', $this->oficial_credito_id)
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
    
    private function _get_pie_date_hist($from_date, $to_date) {
        $serie['data'] = array();
        $credit_status = (new \gestcobra\credit_status_model())
                ->where('company_id', $this->user->company_id)
                ->find();
        foreach ($credit_status as $value) {
            
            $credit_detail_data = (new gestcobra\credit_detail_model())
                    ->where('curr_date >=', $from_date)
                    ->where('curr_date <=', $to_date)
                    ->where('oficial_credito_id', $this->oficial_credito_id)
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
    function _data($credit_status) {

//		$data['users']['data'] = array(500, 80, 20, 8, 250);
//		$data['users']['name'] = 'Users by Language';
//		$data['popul']['data'] = array(30, 15, 200, 300, 125);
//		$data['popul']['name'] = 'World Population';

        /**
         * Obtener los oficiales de credito
         */
        $oficiales = (new gestcobra\oficial_credito_model())
                ->where('company_id', $this->user->company_id)
                ->where('status', 1)
                ->find();

        $data['axis']['categories'] = array();
        foreach ($oficiales as $oficial) {
            array_push($data['axis']['categories'], $oficial->firstname);
        }
        foreach ($credit_status as $status) {
//                echo $value->status_name;

            $data_status = array();
            $cont = 0;
            foreach ($oficiales as $oficial) {
                $count_credit = (new gestcobra\credit_detail_model())
                        ->where('curr_date >=', $this->from_date)
                        ->where('curr_date <=', $this->to_date)
                        ->where('oficial_credito_id', $oficial->id)
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
    function _data_hist($credit_status) {

//		$data['users']['data'] = array(500, 80, 20, 8, 250);
//		$data['users']['name'] = 'Users by Language';
//		$data['popul']['data'] = array(30, 15, 200, 300, 125);
//		$data['popul']['name'] = 'World Population';

        /**
         * Obtener los oficiales de credito
         */
        $oficiales = (new gestcobra\oficial_credito_model())
                ->where('company_id', $this->user->company_id)
                ->where('status', 1)
                ->find();

        $data['axis']['categories'] = array();
        foreach ($oficiales as $oficial) {
            array_push($data['axis']['categories'], $oficial->firstname);
        }
        foreach ($credit_status as $status) {
//                echo $value->status_name;

            $data_status = array();
            $cont = 0;
            foreach ($oficiales as $oficial) {
                $credit_detail_data = (new gestcobra\credit_detail_model())
                        /*->where('curr_date >=', $this->from_date)
                        ->where('curr_date <=', $this->to_date)*/
                        ->where('company_id', $this->user->company_id)
                        ->where('oficial_credito_id', $oficial->id)
                        ->find();
                
                if ($this->user->role_id == 1){
                    $credit_detail_data->where('oficial_credito_id', $this->user->id)->find();
                }
                $credit_detail_id_array = array();
                foreach ($credit_detail_data as $value_credit_detail_data) {
                    array_push($credit_detail_id_array, $value_credit_detail_data->id);
                }
                
                /*$count_credit = (new gestcobra\credit_detail_model())
                        ->where('curr_date >=', $this->from_date)
                        ->where('curr_date <=', $this->to_date)
                        ->where('oficial_credito_id', $oficial->id)
                        ->where('credit_status_id', $status->id)
                        ->count();*/
                $count_credit=0;
                if ($credit_detail_id_array) {
                $count_credit=(new gestcobra\credit_hist_model())
                    ->where('hist_date >=', $this->from_date)
                    ->where('hist_date <=', $this->to_date)
                    ->where('credit_status_id', $status->id)
                    ->where_in('credit_detail_id', $credit_detail_id_array)
                    ->count();
                //if ($this->user->role_id == 1) {
                }
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
 public function open_view2(){  
        $this->load->view('view_graficos_preventivaciclo1/grafica_produccionGestiones.php');
    }
    
    public function open_view3(){  
        $this->load->view('view_graficos_preventivaciclo1/grafica_cumplimientoOficial.php');
    }
}



/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */