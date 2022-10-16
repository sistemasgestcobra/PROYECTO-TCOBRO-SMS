<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agenciacomunicationscharts extends CI_Controller {
        function __construct()
	{
		parent::__construct();		
	}
        private $from_date;
        private $to_date;
        private $oficina_company_id;
	/**
         * 
         */
        public function get_chart_comunication_by_agencia() {
            $this->load->library('highcharts');            
            $this->load->model('comunication_model');
            $this->from_date = set_post_value('from_date');
            $this->to_date = set_post_value('to_date');
            $type_group = set_post_value('type_group');
            $search_type = set_post_value('search_type');
            $comparar = set_post_value('comparar');
            $oficial_id = set_post_value('oficial_id');
            $this->oficina_company_id = set_post_value('oficina_company_id');
//            $res['data'] = $this->credit_detail_model->get_report_by_day( $this->from_date,  $this->to_date, $type_group, $search_type, $oficial_id, $oficina_company_id, $comparar);
            $res['type_group'] = $type_group;
            $res['search_type'] = $search_type;
            $res['comparar'] = $comparar;
            $res['oficial_id'] = $oficial_id;
            $oficina_company= new gestcobra\oficina_company_model($this->oficina_company_id);
            $compania= new gestcobra\company_model($oficina_company->company_id);
            
            $fecha=date("m/d/Y");
            $title_chart = $this->load->view('title_chart', $res, TRUE); 

             $this->highcharts->set_title('<h4>'.$compania->nombre_comercial.'</h4><br/><strong>Fecha actual: </strong>'.$fecha.'<br/><strong>REPORTE POR AGENCIA: </strong><br/><strong>Agencia: </strong>'.$oficina_company->name.'<br/><br/><strong>Desde: </strong>'.$this->from_date.' <br/><strong>Hasta: </strong>'.$this->to_date.' <br/>');
             $oficial= (new gestcobra\oficial_credito_model()) 
                ->where('id', $this->user->id)
                ->where('oficina_company_id', $this->oficina_company_id)
                ->find();
        
        if (empty($oficial)) {
        
            successAlert(lang('ml_error_agencia'), lang('ml_error'));
          }  else {
            
            
           
        /**********************************************************************************/        
            if($this->oficina_company_id > 0){
                $this->_get_pie_date_comunication($this->from_date, $this->to_date);
            }elseif( $this->oficina_company_id == -1 ){
                //print_r($this->oficina_company_id);
                $this->active_record_comunication();
            }             
        }
        
        }
        
        private function _get_pie_date_comunication($from_date, $to_date) {
            $serie['data'] = array();            
            $credit_details= (new gestcobra\credit_detail_model())
                    ->where('company_id',  $this->user->company_id)
                    ->where('oficina_company_id',  $this->oficina_company_id)
                    ->find();
            if($credit_details){
            $credit_array= array();
            foreach ($credit_details as $credit){
                array_push($credit_array, $credit->id);
            }
            $clien_referencias = (new gestcobra\client_referencias_model())
                    ->where_in('credit_detail_id',$credit_array)->find();
            $creferencias_array = array();
            foreach ($clien_referencias as $referencia) {
                array_push($creferencias_array, $referencia->id);
            }
            $comunication_type = (new \gestcobra\comunication_type_model())
                    ->find();
            foreach ($comunication_type as $value){
                $tot_comunication = (new gestcobra\comunication_model())
                    ->where('curr_date >=', $from_date)
                    ->where('curr_date <=', $to_date)
                    ->where('status', '0')
                    ->where('comunication_type_id', $value->id)
                    ->where_in('client_referencias_id',$creferencias_array);
                
                    //->where('comunication_type_id', $value->id)
                       // ->join('credit_detail c_d')->find();
                //print_r($tot_comunication);
                
                        //->where('c_d.oficina_company_id ='.$this->oficina_company_id)
                        //->join('credit_detail c_d','credit_detail_id=c_d.id');
                /**
                 * Si es un oficial de credito, presenta solo los que le pertenecen
                 */
                if( $this->user->role_id == 1 ){
                   $tot_comunication = $tot_comunication ->where('c_d.oficial_credito_id', $this->user->id);
                }
                $tot_comunication = $tot_comunication->count();
                array_push($serie['data'], array($value->comunication_name, $tot_comunication));
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
        }
	
	public function active_record_comunication() {
                $credit_status = (new gestcobra\comunication_type_model())
                        ->find();            
		$result = $this->_ar_data($credit_status);
                
		// set data for conversion
		$dat1['x_labels'] 	= 'contries'; // optionnal, set axis categories from result row
//		$dat1['series'] 	= array('users', 'population'); // set values to create series, values are result rows
		$dat1['series'] 	= array(); // set values to create series, values are result rows
                foreach ($credit_status as $value) {
                    array_push($dat1['series'] , $value->comunication_name);
                }
		$dat1['data']		= $result;
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
	function _data($credit_status)
	{
            
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
                    $credit_detail_id_agencia = (new gestcobra\credit_detail_model())
                        ->where('oficina_company_id', $agencia->id)->find();
                $count_credit=0;
                if (count($credit_detail_id_agencia) > 0) {
                    $credit_detail_id_agencia_array = array();
                    foreach ($credit_detail_id_agencia as $credit_detail_agencia) {
                        array_push($credit_detail_id_agencia_array, $credit_detail_agencia->id);
                    }
                    $client_referencias = (new gestcobra\client_referencias_model())
                            ->where_in('credit_detail_id', $credit_detail_id_agencia_array)->find();
                    $client_referencias_id_array = array();
                    foreach ($client_referencias as $client_referencias_) {
                        array_push($client_referencias_id_array, $client_referencias_->id);
                    }
                    $count_credit = (new gestcobra\comunication_model())
                        ->where('curr_date >=', $this->from_date)
                        ->where('curr_date <=', $this->to_date)
                        ->where('comunication_type_id', $status->id)
                        ->where_in('client_referencias_id',$client_referencias_id_array)->count();
                }
                    /*$count_credit = (new gestcobra\comunication_model())
                            ->where('curr_date >=', $this->from_date)
                            ->where('curr_date <=', $this->to_date)
                            ->where('status', '0')
                            ->where('comunication_type_id', $status->id)
                           // ->join('credit_detail c_d','c_d.oficina_company_id='. $agencia->id)
                           ->count();*/
                    
//                    $cont++;
                    if($count_credit == 0){
                        $count_credit = 0.00000001;
                    }
                    array_push($data_status, $count_credit);
                }
                $data[$status->comunication_name]['data'] = $data_status;     
            }                                
		return $data;
	}
	
	/**
	 * _ar_data function.
	 * simulate Active Record result
	 */
	function _ar_data($credit_status)
	{
		$data = $this->_data($credit_status);
                
                $cont = 0;
//		foreach ($credit_status as $val)
//		{
                    
                for( $i = 0; $i < count($data['axis']['categories']); $i++ ){
			$output[] = (object)array();
                        $output[$cont]->contries = $data['axis']['categories'][$cont];
                        foreach ($credit_status as $status) {
                                $output[$cont]->{$status->comunication_name} = $data[$status->comunication_name]['data'][$cont];
                        }       
                        $cont++;
		}
                
                //print_r($output) ;
                
		return $output;
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */