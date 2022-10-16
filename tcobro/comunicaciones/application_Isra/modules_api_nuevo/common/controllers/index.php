<?php
/**
 * Description of autosuggest
 *
 * @author estebanch
 */
class Index extends MX_Controller{
    
	function __construct()
	{
		parent::__construct();
	}
        
        public function not_found() {
            $res['view_name'] = 'page_404';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);               
        }
        
        public function loadNoAuthorized() {
            echo $this->load->view('page_noauthorized', '', TRUE);
        }
        
        /* Abrir modal */
        public function viewScreen( $module, $controller, $view, $param = 0, $title = 'Gestcobra', $desc ='', $size = 'lg' ) {
            openModal(base_url($module.'/'.$controller.'/'.$view.'/'.$param), $title, $desc, $size);
        }
        
       /**
        * 
        * @param type $view_path
        * @param type $modal_data
        * @param type $refresh_autosuggest
        */
        public function open_modal( $view_path, $modal_data, $refresh_autosuggest = 0 ) {
            $title = 'Gestcobra | Software Integral de Cobranzas';
            $desc = '';
            $size = 'lg';

            if( $modal_data != '0' ){
                $data_arr = explode('__', $modal_data);
                $title = $data_arr[0];
                $desc = $data_arr[1];
                $size = $data_arr[2];
            }
            
            $view_arr = explode('__', $view_path);
            
            $param = 0;
            $module = $view_arr[0];
            $controller = $view_arr[1];
            $view = $view_arr[2];
            if(!empty($view_arr[3])){
                $param = $view_arr[3];   
            }
            openModal(base_url($module.'/'.$controller.'/'.$view.'/'.$param), $title, $desc, $size, $refresh_autosuggest);
        }
        
        /**** Vista del Comprobante Ingreso/Egreso ****/
            public function open_comprobante( $id, $transaction_id ) {
                openModal(base_url('common/index/comprobante_view/'.$id.'/'.$transaction_id), 'Comprobante', 'Comprobante Ingreso/Egreso', 'lg');
            }
            public function comprobante_view( $id, $transaction_id ) {
                $this->load->library('number_letter');
                $this->load->model('comprobante_model');
                $this->load->model('asiento_model');

                $comprob_data = $this->comprobante_model->get_comprobante_by_id( $id ); 
                
                $res['comprobante_data'] = $comprob_data;
                $res['asiento_data'] = $this->asiento_model->get_by_id($comprob_data->asiento_id);
//                $res['asiento_data'] = new \marilyndb\ml_asiento_model();

                $this->load->view('comprobante_doc',$res);
            }
        /**** Fin Vista del Comprobante Ingreso/Egreso ****/
        
}

