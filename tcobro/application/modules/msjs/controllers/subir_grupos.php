<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subir_grupos extends MX_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->user->check_session();


        // Ignorar los abortos hechos por el usuario y permitir que el script
        // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
        ignore_user_abort(true);
    }

    public $abecedario = array(
        "A" => "0",
        "B" => "1",
        "C" => "2",
        "D" => "3",
        "E" => "4",
        "F" => "5",
        "G" => "6",
        
    );
//CREAR BASE
    private function crear_base($name,$obser) {
        
        $grupo=(new gestcobra\grupo_model())
         ->where("nombre", $name)
                ->find_one();
        
        if (empty($grupo->id)) {
            $grupo->nombre=$name;
           
            $grupo->observaciones=$obser;
            $grupo->save();
        }
         //$grupo->estado=1;
           $grupo->save();
      //  return $grupo->id;
          
    }
     function find_base($name) {
         $grupo=(new gestcobra\grupo_model())
                ->where("nombre", $name)
                  
                ->find_one();
        return $grupo->id;
    }  
    
    
    function load_grupos() {
//        $base_nombre=  set_post_value('name');
        
        $base_nombre=  set_post_value('name');
        $obser=  set_post_value('obser');
        $this->crear_base($base_nombre,$obser);
        set_time_limit(0);
        $this->load->library('excel');
        $logo_path = './uploads/' . $this->user->company_id . '/refinanciamiento/';
        makedirs($logo_path, $mode = 0755);
        $config['upload_path'] = $logo_path;
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            toast($error);
            exit();
        } else {
            $upl_data = $this->upload->data();
        }
        $upl_data = $this->upload->data();
        if (file_exists($logo_path . $upl_data['file_name'])) {
            // Cargando la hoja de c�lculo
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $objFecha = new PHPExcel_Shared_Date();
            // Asignar hoja de excel activa
            $PHPExcel->setActiveSheetIndex(0);
            $this->db->trans_begin();
            // Crear nuevo status (PENDIENTE PARA LA EMPRESA)

            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
               
                $numero=get_value_xls($PHPExcel, $this->abecedario["A"], $x);
                $nombre=get_value_xls($PHPExcel, $this->abecedario["B"], $x);
                $variable1=get_value_xls($PHPExcel, $this->abecedario["C"], $x);
                $variable2=get_value_xls($PHPExcel, $this->abecedario["D"], $x);
                $variable3=get_value_xls($PHPExcel, $this->abecedario["E"], $x);
                $variable4=get_value_xls($PHPExcel, $this->abecedario["F"], $x);
                $num_operacion=get_value_xls($PHPExcel, $this->abecedario["G"], $x);
                
                
                $contact=(new gestcobra\contact_grupo_model());
              
                $contact->numero=$numero;
                $contact->nombre=$nombre;
//                $contact->apellido=$apellido;
                $contact->variable1=$variable1;
                $contact->variable2=$variable2;
                $contact->variable3=$variable3;
                $contact->variable4=$variable4;
                $contact->numero_operacion=$num_operacion;
                $contact->id_grupo=  $this->find_base($base_nombre);
                
                $contact->save();
                
            }
               
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
            if (isset($contact)) {
                successAlert('Archivo cargado correctamente', lang('ml_success'));
			         
                ?>   
                 <script> 
               document.location.reload();
            </script>"  

                <?php
				
            } else {
                errorAlert('Error al cargar el archivo');
            }
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }
    
    
}
