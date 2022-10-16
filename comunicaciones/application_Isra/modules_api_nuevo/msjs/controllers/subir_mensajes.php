<?php
class Subir_mensajes extends MX_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->user->check_session();
        ignore_user_abort(true);
        $this->load->library('comunications/commws');
    }

    public $abecedario = array(
        "A" => "0",
        "B" => "1",
     );
//Mensajes Personalizados
    
     function load_mensajes_masivos() {
        set_time_limit(0);
        $this->load->library('excel');
        $logo_path = './uploads/' . $this->user->company_id . '/files/';
        makedirs($logo_path, $mode = 0755);
        $config['upload_path'] = $logo_path;   $config['allowed_types'] = '*'; $config['max_size'] = '0'; $config['max_width'] = '0';
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
        $mensaje=  set_post_value('mensaje');
        if (file_exists($logo_path . $upl_data['file_name'])) {
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $PHPExcel->setActiveSheetIndex(0);
                  $numeros=array();
                  $num_malos=array();
            //$fp = fopen("mensajes_mas.txt", "a");
            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);
                   
                $numero_celular1=trim($numero_celular);
                if(strlen($numero_celular1)==12){
                $numero["number"]=$numero_celular;
                array_push($numeros, $numero);
                }else{
                array_push($num_malos, $numero_celular1);
                }
            }
            if(count($numeros)>450){
                $this->dividir($mensaje,$numeros);
            }else{
                $this->enviar($mensaje,$numeros);
            }
                $enviados = count($numeros);
                if(!empty($num_malos)){
                    echo $this->erroneos("Numeros Erroneos",$num_malos);
                }
                //fputs($fp, $resp."\r\n");
                //fclose($fp); 
            if (true) {
                successAlert('Archivo cargado correctamente', lang('ml_success'));
                $this->envio_hist($mensaje,$enviados,$num_malos);
            } else {
                errorAlert('Error al cargar el archivo');
            }
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }
    
    function envio_hist($detail,$enviados,$num_malos) {
        $envio= new \gestcobra\envio_hist_model();
        $envio->hist_date = date('Y-m-d', time());
        $envio->hist_time = date('H:i:s', time());
        $envio->detail=$detail;
        $envio->enviados=$enviados;
        $envio->excluidos=count($num_malos);
        $envio->usuario=  $this->user->firstname;
        $envio->save();
    }
    
    function dividir($mensaje,$numeros) {
        
//        $mensajes1=array_chunk($mensajes, 450);
      
        $numeros1=array_chunk($numeros, 450);
            $div= count($numeros1);
            for($x=0;$x<$div;$x++){
//                $m=$mensajes1[$x];
                $n=$numeros1[$x];
                $this->enviar($mensaje, $n);
                
            }
            //fputs($fp, $resp."\r\n");
                
        
    }
    
     function erroneos($men,$num_malos) {
         echo $men.": ".count($num_malos);
                    echo '<pre>';
                    foreach ($num_malos as $value) {
                        print $value.'<br>';
                    }
         echo  '</pre>';
    }
    
    function enviar($mensaje,$numeros) {
            $numero["number"]='593995164158';
      array_push($numeros, $numero);
  $message = array(
  "content" => $mensaje,
  "to_contacts" => $numeros
   );
    $obj_commws = new Commws();
    $obj_commws->http_conn_comunication_1($message);
                     
                     
    }
	
	
    function load_mensajes_base() {
        $nombre_base = set_post_value('id_grupo');
        $mensaje_o = set_post_value('mensaje');
        $contactos = (new gestcobra\contact_grupo_model())
                ->where('id_grupo', $nombre_base)
                ->find();
        
        $num_malos=array();
        $numeros=array();
        if ($contactos) {
            foreach ($contactos as $contact) {
                $numero_celular1=trim($contact->numero);
                if(strlen($numero_celular1)==12){
                $vars=array(
                    "var1"=>$contact->variable1,
                    "var2"=>$contact->variable2,
                    "var3"=>$contact->variable3,
                    "var4"=>$contact->variable4
                    );
                $numero = array(
                    "number" => $numero_celular1,
                    "name" => $contact->nombre,
                    "vars"=>$vars
                );
                array_push($numeros, $numero);
                }else{
                    array_push($num_malos, $contact->numero);
                }
               }  
        }

               if (count($numeros) > 450) {
                $this->dividir($mensaje_o, $numeros);
            } else {
                $this->enviar($mensaje_o, $numeros);
            }

        $enviados = count($numeros);
                if(!empty($num_malos)){
                    echo $this->erroneos("Numeros Erroneos",$num_malos);
                }

        if (true) {
            successAlert('Archivo cargado correctamente', lang('ml_success'));
            $this->envio_hist($mensaje_o, $enviados, $num_malos);
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }
    
}