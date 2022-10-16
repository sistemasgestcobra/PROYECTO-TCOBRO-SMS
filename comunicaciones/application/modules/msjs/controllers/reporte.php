<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CI_Controller {

function __construct() {
        parent::__construct();
    }
	public function index()
	{
             $this->load->library('excel');
            $this->reportediario();
        }

        public function index2()
	{
             $this->load->library('excel');
            $this->reportediario_fechas();
        }
        public function reportediario() {     

        $mysqli = new mysqli("localhost", $this->db->username, $this->db->password, $this->db->database);
       
       // $oficina = 390;
        if (!$mysqli->multi_query("select re.numero,rm.detalle, re.fecha_envio,re.hora_envio, re.estado from reporte_envio re, reporte_mensaje rm 
where re.id_mensaje=rm.id and re.fecha_envio=CURDATE() ORDER by re.numero;")) 
           
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

        // agregamos información a las celdas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'NUMERO')
                ->setCellValue('B1', 'MENSAJE  ')
                ->setCellValue('C1', 'FECHA  ')
                ->setCellValue('D1', 'HORA  ')
                ->setCellValue('E1', 'ESTADO  ')
                
                
               ;
        
        

        
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
        $objActSheet->duplicateStyle($objStyleA5, 'A1:E1'); 


        $cont = 2;
        foreach($coco as $value){
        
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A'.$cont, $value[0])
                ->setCellValue('B'.$cont, utf8_encode($value[1]))
                ->setCellValue('C'.$cont, $value[2])
                ->setCellValue('D'.$cont, $value[3])
                ->setCellValue('E'.$cont, utf8_encode($value[4]));
                
                
        $cont++; 
        }
        
       
        // Renombramos la hoja de trabajo
        $this->excel->getActiveSheet()->setTitle('Reporte');
         
         
        // configuramos el documento para que la hoja
        // de trabajo número 0 sera la primera en mostrarse
        // al abrir el documento
        $this->excel->setActiveSheetIndex(0);
         
        $fecha=date('Y/M/d');
        $nombre='reporte-'."$fecha".'.xlsx';
      
          
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

        
        
         public function reportediario_fechas() {     
$fecha_desde= set_post_value('from_date');
$fecha_hasta= set_post_value('to_date');
             
        $mysqli = new mysqli("localhost", $this->db->username, $this->db->password, $this->db->database);
       
       // $oficina = 390;
        if (!$mysqli->multi_query("select re.numero, rm.detalle,re.fecha_envio,re.hora_envio, re.estado from reporte_envio re, reporte_mensaje rm 
where re.id_mensaje=rm.id and re.fecha_envio>='$fecha_desde' and re.fecha_envio<='$fecha_hasta'  ORDER by re.numero;")) 
           
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

        // agregamos información a las celdas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'NUMERO')
                ->setCellValue('B1', 'MENSAJE  ')
                ->setCellValue('C1', 'FECHA  ')
                ->setCellValue('D1', 'HORA  ')
                ->setCellValue('E1', 'ESTADO  ')
                
                
               ;
        
        

        
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
        $objActSheet->duplicateStyle($objStyleA5, 'A1:E1'); 


        $cont = 2;
        foreach($coco as $value){
        
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A'.$cont, $value[0])
                ->setCellValue('B'.$cont, utf8_encode($value[1]))
                ->setCellValue('C'.$cont, $value[2])
                ->setCellValue('D'.$cont, $value[3])
                ->setCellValue('E'.$cont, utf8_encode($value[4]));
                
                
        $cont++; 
        }
        
       
        // Renombramos la hoja de trabajo
        $this->excel->getActiveSheet()->setTitle('Reporte');
         
         
        // configuramos el documento para que la hoja
        // de trabajo número 0 sera la primera en mostrarse
        // al abrir el documento
        $this->excel->setActiveSheetIndex(0);
         
        $fecha=date('Y/M/d');
        $nombre='reporte-'."$fecha".'.xlsx';
      
          
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