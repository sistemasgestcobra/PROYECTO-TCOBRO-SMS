<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_general extends CI_Controller {

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
        $agencia=set_post_value('oficina_company_id');

        $mysqli = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
       
       // $oficina = 390;
        if ($agencia==-1) {
        if (!$mysqli->multi_query("select r.oficial_name,r.cantidad_creditos,r.capital,(r.cantidad_creditos-r.cantidad_recuperada),
(r.capital-r.capital_recuperado),r.cantidad_recuperada,r.capital_recuperado,ROUND((r.capital_recuperado *100)/r.capital,2)
 from reporte1 r")) 
           
            {
            echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        }else{
            if (!$mysqli->multi_query("select r.oficial_name,r.cantidad_creditos,r.capital,(r.cantidad_creditos-r.cantidad_recuperada),
(r.capital-r.capital_recuperado),r.cantidad_recuperada,r.capital_recuperado,ROUND((r.capital_recuperado *100)/r.capital,2)
 from reporte1 r where r.oficina_id=$agencia
 ")) 
           
            {
            echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
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


        // agregamos información a las celdas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Oficial ')
                ->setCellValue('B1', 'Creditos  ')
                ->setCellValue('C1', 'Capital  ')
                ->setCellValue('D1', 'Num. Operaciones por Recuperar    ')
                ->setCellValue('E1', 'Capital por Recuperar   ')
                ->setCellValue('F1', 'Num. Operaciones Recuperadas   ')
                ->setCellValue('G1', 'Capital Recuperado   ')
                ->setCellValue('H1', 'Porecentaje Recuperado %  ');
                
        
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
        $objStyleA5->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('88cc47');
        
        //El establecimiento de marcos 
        $objBorderA5 = $objStyleA5->getBorders(); 
        $objBorderA5->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $objBorderA5->getTop()->getColor()->setARGB('FFFF0000') ; // Color del marco 
        $objBorderA5->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $objBorderA5->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $objBorderA5->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        
        //Especifica el estilo de celda copiar información. 
        $objActSheet->duplicateStyle($objStyleA5, 'A1:H1'); 


        $cont = 2;
        foreach($coco as $value){
        
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A'.$cont, utf8_encode($value[0]))
                ->setCellValue('B'.$cont, $value[1])
                ->setCellValue('C'.$cont, $value[2])
                ->setCellValue('D'.$cont, $value[3])
                ->setCellValue('E'.$cont, $value[4])
                ->setCellValue('F'.$cont, $value[5])
                ->setCellValue('G'.$cont, $value[6])
                ->setCellValue('H'.$cont, $value[7]);
        
        $cont++; 
        
        
        }
		
		
		$t=$cont;
		$total= 'TOTAL';
		
		
		$count=2;
		foreach($coco as $row1){
			$t1=$t1+$row1[1];
			$t2=$t2+$row1[2];
			$t3=$t3+$row1[3];
			$t4=$t4+$row1[4];
			$t5=$t5+$row1[5];
			$t6=$t6+$row1[6];
			$t7=$t7+$row1[7];
			
			$count ++;
		}
		
		
		 $this->excel->setActiveSheetIndex(0)		
			->setCellValue('A'.$t,  $total)
			->setCellValue('B'.$t,  $t1)
			->setCellValue('C'.$t,  $t2)
			->setCellValue('D'.$t,  $t3)
			->setCellValue('E'.$t,  $t4)
			->setCellValue('F'.$t,  $t5)
			->setCellValue('G'.$t,  $t6)
			->setCellValue('H'.$t,  $t7);
		
		//Según el contenido original apareció. 
        $objStyleA5 = $objActSheet->getStyle('A'.$t);
        //$objStyleA5->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $objStyleA5->getActiveSheet()->getColumnDimension()->setVisible(true);


        //Configuración de tipos de letra 
        $objFontA5 = $objStyleA5->getFont();
        $objFontA5->setName('Arial Black');
        $objFontA5->setSize(9);
        $objFontA5->setBold(true);
        //$objFontA5->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
        $objFontA5->getColor()->setARGB('FF0000FF');
        $objFontA5->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
        $objStyleA5->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('A9D0F5');
		
		//El establecimiento de marcos 
        $objBorderA5 = $objStyleA5->getBorders(); 
        $objBorderA5->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $objBorderA5->getTop()->getColor()->setARGB('FFFF0000') ; // Color del marco 
        $objBorderA5->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $objBorderA5->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
        $objBorderA5->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
		
		
		//Especifica el estilo de celda copiar información. 
        $objActSheet->duplicateStyle($objStyleA5, 'A'.$t.':'.'H'.$t); 
        
       
        // Renombramos la hoja de trabajo
        $this->excel->getActiveSheet()->setTitle('Reporte');
         
         
        // configuramos el documento para que la hoja
        // de trabajo número 0 sera la primera en mostrarse
        // al abrir el documento
        $this->excel->setActiveSheetIndex(0);
         
        $fecha=date('Y/M/d');
        $nombre='CumplimientoOficial-'."$fecha".'.xlsx';
      
          
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