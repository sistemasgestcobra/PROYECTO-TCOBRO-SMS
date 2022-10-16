<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Index extends MX_Controller {
	function __construct()
	{
 		parent::__construct();
                $this->user->check_session(); 
	}	

        public function report_by_date() {
            $res['menu'] = array(
                array('Por Fechas', 'icon-apple'),
//                array('Comunicaciones', 'icon-apple'),
                );
            $res['content_menu'] = array(
                array( 'report_gest', 'Por Fechas', array('comparar'=>'0') ),
//                array( 'report_comunicaciones_fecha', 'Comunicaciones por fecha', array('comparar'=>'0') ),
                );

            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);  
        }
        
        /**
         * 
         */
      
	  public function report_by_oficial() {
if ($this->user->role_id == 2) {
            $oficiales_credito = (new \gestcobra\oficial_credito_model())
                    ->where('status', 1)
                    ->where('company_id', $this->user->company_id)
                    ->where('oficina_company_id', $this->user->oficina_company_id)
                    ->where('role_id', 1)
                    ->or_where('role_id', 2)
                    ->find();
			$oficiales_gestiones = $oficiales_credito;
        } else {

            $oficiales_credito = (new \gestcobra\oficial_credito_model())
                    ->where('status', 1)
                    ->where('company_id', $this->user->company_id)
                    ->where('role_id', 1)
                    ->or_where('role_id', 2)
                    ->find();
        }
        
                    $oficiales_gestiones = (new \gestcobra\oficial_credito_model())
                    ->where('status', 1)
                    ->where('company_id', $this->user->company_id)
                    ->where('role_id', 1)
                    ->or_where('role_id', 2)
                    ->or_where('role_id', 6)
                    ->find();
            
            $res['menu'] = array(
                    array( 'Comparativa Oficial', 'icon-apple'),
//                    array( 'Comparativa de Gestiones por Oficial', 'icon-apple')
                );
            
            $res['content_menu'] = array(
                    array('report_gest_oficial', 'Reporte Comparativo por Oficial', array('comparar' => '1', 'oficiales_credito' => $oficiales_credito,'oficiales_gestion' => $oficiales_gestiones)),
//                    array( 'report_gest_oficial_gestiones', 'Reporte Comparativo de Gestiones por Oficial', array('comparar'=>'1','oficiales_credito'=>$oficiales_credito) )
                );
            
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }
	  
        
        public function report_by_agencia() {
               if( $this->user->role_id == 2){
                   $agencias = (new gestcobra\oficina_company_model())
                    ->where('company_id', $this->user->company_id)
                    ->where('status', 1)
                    ->where('id', $this->user->oficina_company_id)
                    ->find();
               }else{
                   $agencias = (new gestcobra\oficina_company_model())
                    ->where('company_id', $this->user->company_id)
                    ->where('status', 1)
                    ->find();
               }
               
            $res['menu'] = array(
                    array( 'Comparativa Agencia', 'icon-apple'),
//                    array( 'Comunicaciones', 'icon-apple'),
                );
            $res['content_menu'] = array(
                    array( 'report_gest_agencia', 'Reporte Comparativo por Agencia', array('comparar'=>'1', 'agencias'=>$agencias) ),
//                    array( 'report_comunicaciones_agencia', 'Reporte Comunicaciones por Agencia', array('comparar'=>'1', 'agencias'=>$agencias) ),
                );
//            if( $this->user->role_id == 2 OR $this->user->role_id == 3 ){
//                array_push($res['menu'],  array( 'Por Agencia', 'icon-apple'));
//                array_push($res['content_menu'],  array( 'report_gest_agencia', 'icon-apple', array('agencias'=>$agencias)));
//                array_push($res['menu'],  array( 'Por Oficial', 'icon-apple'));
//                array_push($res['content_menu'],  array( 'report_gest_oficial', 'Por Oficial', array('oficiales_credito'=>$oficiales_credito)) );                
//            }
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }
        
        
         public function report_by_general() {
              $this->limpiar();
  $this->repor();
  
  $this->pendientes();
  $this->compromiso();
  $this->gestionados();
            $agencias = (new gestcobra\oficina_company_model())
                    ->where('company_id', $this->user->company_id)
                    ->where('status', 1)
                    ->find();
            $res['menu'] = array(
                    array( 'REPORTE GENERAL', 'icon-apple'),
                    array( 'REPORTE MENSUAL', 'icon-apple'),
                    array( 'REPORTE DE PRODUCCION POR GESTION', 'icon-apple'),
                );
            $res['content_menu'] = array(
                 array( 'report_general', 'REPORTE GENERAL', array('comparar'=>'1', 'agencias'=>$agencias) ),
                    array( 'report_general_mes', 'REPORTE MENSUAL', array('comparar'=>'1', 'agencias'=>$agencias) ),
                    array( 'report_general_1', 'REPORTE GENERAL', array('comparar'=>'1', 'agencias'=>$agencias) ),
                  
                );
            $res['view_name'] = 'common/templates/left_menu';
            echo $this->load->view('common/templates/dashboard',$res,TRUE);   
        }

        public function limpiar() {
  
 // $this->db->query("delete from  reporte1");
  $this->db->query("delete from  reporte2");
                }
                //REPORTE 2
                public function repor() {
   $mysqli = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
        if (!$mysqli->multi_query("select id, firstname, oficina_company_id from oficial_credito where role_id in(1,2,6) and status=1;")) {
            echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            //  print_r("Exito");
        }
        $res = $mysqli->store_result();
        $coco = $res->fetch_all();
        
        
         foreach ($coco as $value) {
            $oficial_id = $value[0];
            $firstname = $value[1];
            $oficina_company_id = $value[2];
         // probar las comillas del nombre
            if (!$mysqli->query("insert into reporte2 (id_oficial,oficial_name,oficina) values($oficial_id,'$firstname',$oficina_company_id);")) {
            //if (!$mysqli->query("UPDATE reports2 SET mora_actual=$resul WHERE  id=$id")) {
                echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
        }  mysqli_close($mysqli);
      }
                
               
    public function pendientes() {
   $mysqli = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
        if (!$mysqli->multi_query("select cd.oficial_credito_id, count(cd.credit_status_id) as Pendientes, cd.oficina_company_id
                from credit_detail cd 
                 where cd.credit_status_id=21
                GROUP by (cd.oficial_credito_id);")) {
            echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            
        }
        $res = $mysqli->store_result();
        $coco = $res->fetch_all();
        
        
         foreach ($coco as $value1) {
           $id_oficial= $value1[0];$pendientes = $value1[1];$oficina_company = $value1[2];
       
            if (!$mysqli->query("UPDATE reporte2 SET pendientes=$pendientes  WHERE  id_oficial=$id_oficial;")) {
                echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
           }  mysqli_close($mysqli);
          }
     public function compromiso() {
   $mysqli = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
        if (!$mysqli->multi_query("select cd.oficial_credito_id, count(cd.credit_status_id) as Pendientes, cd.oficina_company_id
                from credit_detail cd 
                 where cd.credit_status_id=23
                GROUP by (cd.oficial_credito_id);")) {
            echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
           
        }
        $res = $mysqli->store_result();
        $coco = $res->fetch_all();
        
        
         foreach ($coco as $value1) {
            $id_oficial= $value1[0];$compromiso = $value1[1];$oficina_company = $value1[2];
        
            if (!$mysqli->query("UPDATE reporte2 SET compromiso=$compromiso WHERE  id_oficial=$id_oficial;")) {
                echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
        }  
          
    
        
        }

        
        public function gestionados() {
   $mysqli = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
        if (!$mysqli->multi_query("select cd.oficial_credito_id, count(cd.credit_status_id) as Pendientes, cd.oficina_company_id
                from credit_detail cd 
                 where cd.credit_status_id!=21
                GROUP by (cd.oficial_credito_id);")) {
            echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
           }
        $res = $mysqli->store_result();
        $coco = $res->fetch_all();
        
        
         foreach ($coco as $value1) {
            $id_oficial= $value1[0];$gestionados= $value1[1];$oficina_company = $value1[2];
         // probar las comillas del nombre
            if (!$mysqli->query("UPDATE reporte2 SET gestionados=$gestionados WHERE  id_oficial=$id_oficial")) {
           echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
        }  
        
        }
    
                
          }
