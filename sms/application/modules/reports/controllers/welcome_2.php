<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_2 extends CI_Controller {

function __construct() {
        parent::__construct();
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
           
           
           $this->load->library('excel');
          //  $this->load->library('third_party/PHPExcel/Classes/PHPExcel.php');
            $this->setExcel();
            //$this->setReporte2();
        }
        
        public function setExcel () {

        $mysqli = new mysqli("localhost", $this->db->username, $this->db->password, $this->db->database);
        $fechacarga=set_post_value('from_date');
        $fechahasta= set_post_value('to_date');
        $oficina = set_post_value('oficina_company_id');
    
              
             //general
              $query = "select p.cedula_deudor,p.firstname, p.code, cd.nro_pagare, oc.firstname,GROUP_CONCAT(DATE_FORMAT(ch.hist_date, '%d/%m/%Y')  order by ch.hist_date SEPARATOR '//'),
GROUP_CONCAT(ch.hist_time order by ch.id SEPARATOR '//'), 'TELEFONICA', (SELECT SUBSTRING_INDEX(GROUP_CONCAT(cs.contacto order by ch.id desc), ',', 1)), (SELECT SUBSTRING_INDEX(GROUP_CONCAT(cs.respuesta order by ch.id desc), ',', 1)),  
(SELECT SUBSTRING_INDEX(GROUP_CONCAT(cs.status_name order by ch.id desc), ',', 1)), (SELECT SUBSTRING_INDEX(GROUP_CONCAT(DATE_FORMAT(ch.compromiso_pago_date, '%d/%m/%Y')order by ch.id desc), ',', 1)), count(ch.detail) ,GROUP_CONCAT(ch.detail order by ch.id SEPARATOR '//')
from  credit_detail cd 
left join credit_hist ch on ch.credit_detail_id=cd.id 
left join client_referencias cr on cr.credit_detail_id=cd.id 
left join person p on cr.person_id=p.id
left join credit_status cs on ch.credit_status_id=cs.id
left join oficial_credito oc on cd.oficial_credito_id=oc.id 
where cd.oficina_company_id=$oficina and (ch.hist_date>='$fechacarga' and ch.hist_date<='$fechahasta') 
and cd.credit_status_id!=1 and cr.person_id=p.id and cr.reference_type_id=3 
GROUP by cd.id;"; 
            
              
       
        
       
       // $oficina = 390;
        if (!$mysqli->multi_query($query)) 


           
            {
            echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
        }
         
        $res = $mysqli->store_result();
        $coco=$res->fetch_all();
        // configuramos las propiedades del documento
        $this->excel->getProperties()->setCreator("Gestcobra")
                                     ->setLastModifiedBy("Gestcobra.com")
                                     ->setTitle("Reporte de gestiones")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Test result file");
         
$objActSheet = $this->excel->getActiveSheet();
//$objActSheet->getColumnDimension('A')->setWidth(30);
$objActSheet->getColumnDimension('A')->setAutoSize(true);
$objActSheet->getColumnDimension('B')->setAutoSize(true); 
$objActSheet->getColumnDimension('C')->setAutoSize(true);
$objActSheet->getColumnDimension('D')->setAutoSize(true);
$objActSheet->getColumnDimension('E')->setAutoSize(true);
$objActSheet->getColumnDimension('F')->setAutoSize(true);
$objActSheet->getColumnDimension('G')->setAutoSize(true);
$objActSheet->getColumnDimension('H')->setAutoSize(true);
$objActSheet->getColumnDimension('I')->setAutoSize(true);
$objActSheet->getColumnDimension('J')->setAutoSize(true);
$objActSheet->getColumnDimension('K')->setAutoSize(true);
$objActSheet->getColumnDimension('L')->setAutoSize(true);
$objActSheet->getColumnDimension('M')->setAutoSize(true);
$objActSheet->getColumnDimension('N')->setAutoSize(true);


        // agregamos información a las celdas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id')
                ->setCellValue('B1', 'Nombre Deudor  ')
                ->setCellValue('C1', 'Cuenta  ')
                ->setCellValue('D1', 'Numero Operacion  ')
                ->setCellValue('E1', 'Gestor  ')
                ->setCellValue('F1', 'Fecha  ')
                ->setCellValue('G1', 'Hora  ')
                ->setCellValue('H1', 'Marcacion  ')
                ->setCellValue('I1', 'Contacto  ')
                ->setCellValue('J1', 'Respuesta  ')
                ->setCellValue('K1', 'Sub-Respuesta   ')
                ->setCellValue('L1', 'Fecha Compromiso de Pago     ')
                ->setCellValue('M1', 'Numero De Gestiones    ')
                ->setCellValue('N1', 'Detalle  ');
        
        

        
        //Según el contenido original apareció. 
        $objStyleA5 = $objActSheet->getStyle('A1');
        $objStyleA5->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $objStyleA5->getActiveSheet()->getColumnDimension()->setVisible(true);


        //Configuración de tipos de letra 
        $objFontA5 = $objStyleA5->getFont();
        $objFontA5->setName('Arial Black');
        $objFontA5->setSize(10);
        $objFontA5->setBold(true);
        //$objFontA5->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
        $objFontA5->getColor()->setARGB('FF0000FF');
        $objFontA5->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
        $objStyleA5->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('3399FF');
        
        //El establecimiento de marcos 
        $objBorderA5 = $objStyleA5->getBorders(); 
        $objBorderA5->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $objBorderA5->getTop()->getColor()->setARGB('FFFF0000') ; // Color del marco 
        $objBorderA5->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $objBorderA5->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $objBorderA5->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        
        //Especifica el estilo de celda copiar información. 
        $objActSheet->duplicateStyle($objStyleA5, 'A1:N1'); 


        $cont = 2;
        foreach($coco as $value){
        
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A'.$cont, $value[0])
                ->setCellValue('B'.$cont, utf8_encode($value[1]))
                ->setCellValue('C'.$cont, $value[2])
                ->setCellValue('D'.$cont, $value[3])
                ->setCellValue('E'.$cont, utf8_encode($value[4]))
                ->setCellValue('F'.$cont, $value[5])
                ->setCellValue('G'.$cont, $value[6])
                ->setCellValue('H'.$cont, utf8_encode($value[7]))
                ->setCellValue('I'.$cont, $value[8])
                ->setCellValue('J'.$cont, $value[9])
                ->setCellValue('K'.$cont, $value[10])
                ->setCellValue('L'.$cont, $value[11])
                ->setCellValue('M'.$cont, $value[12])
                ->setCellValue('N'.$cont, utf8_encode($value[13]));
                
        $cont++; 
        }
        
       
        // Renombramos la hoja de trabajo
        $this->excel->getActiveSheet()->setTitle('Reporte');
         
         
        // configuramos el documento para que la hoja
        // de trabajo número 0 sera la primera en mostrarse
        // al abrir el documento
        $this->excel->setActiveSheetIndex(0);
         
        $fecha=date('Y/M/d');
        $nombre='reporteGeneral-'."$fecha".'.xlsx';
      
          
        // redireccionamos la salida al navegador del cliente (Excel2007)
        
        //header('Content-Type: application/vnd.ms-excel');
        //header('Content-type: application/vnd.ms-excel;charset=utf-8');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$nombre);
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        //ob_end_clean();
        //ob_start();
        $objWriter->save('php://output');
        
        
    }
    
   

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
