<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mapa extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mapa_model');
                $this->load->library('googlemaps');
	}
	
	public function index($id=0)
	{
		$config = array();		
		$config['center'] = 'loja';		
		$config['zoom'] = '18';		
		$config['map_type'] = 'ROADMAP';		
		$config['map_width'] = '80%';		
		$config['map_height'] = '600px';	
		$config['apiKey'] = 'AIzaSyAx9BW7QqYVuCYUulPfnt2Xx-VLNq-iO3U ';
		//inicializamos la configuración del mapa	
		$this->googlemaps->initialize($config);	
		//hacemos la consulta al modelo para pedirle 
		//la posición de los markers y el infowindow
		$markers = $this->mapa_model->get_markers($id);
		foreach($markers as $info_marker)
		{
			$marker = array();
			$marker ['animation'] = 'DROP';
			$marker ['position'] = $info_marker->latitud.','.$info_marker->longitud;	
			$marker ['infowindow_content'] = $info_marker->firstname;
			//$marker['id'] = $info_marker->id; 
			$this->googlemaps->add_marker($marker);
			//$marker ['icon'] = base_url().'imagenes/'.$fila->imagen;
			//si queremos que se pueda arrastrar el marker
			//$marker['draggable'] = TRUE;
			//si queremos darle una id, muy útil
		}
		
		//creamos el mapa y lo asignamos a map que lo 
		//tendremos disponible en la vista mapa_view con el array data
		$data['datos'] = $this->mapa_model->get_markers($id);
		$data['map'] = $this->googlemaps->create_map();
        
        
        
        $this->load->view('mapa_view',$data);
	}
        
        
        
        function open_map($id = 0) {
        $res['id'] = $id;
        $this->load->view("map", $res);
    }
    
        public function save_coordenadas() {
        $person_id = set_post_value('person');

        $person = new gestcobra\person_model($person_id);
        $person->latitud = set_post_value('latitud');
        $person->longitud = set_post_value('longitud');
        $person->save();
        ?>
        <script>
            $("#table_credit_hist").bootstrapTable('refresh');
            $("#table_credits").bootstrapTable('refresh');

        </script>
        <?php

        successAlert(lang('ml_success_msg'), lang('ml_success'));
    }
}
