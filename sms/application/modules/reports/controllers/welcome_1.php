<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_1 extends CI_Controller {

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
            $this->setReporte2();
            //$this->setReporte2();
        }
        
       public function setReporte2() {
         
         $mysqli = new mysqli("localhost", $this->db->username, $this->db->password, $this->db->database);
//        $fechuno = '2016-11-11';
//        $fechahasta = set_post_value('to_date');
//        $oficina = set_post_value('oficina_company_id');
        $oficina = 390;
        if (!$mysqli->multi_query("select r.oficial_name, (r.cantidad_creditos+ r.aux_cant), (r.capital+r.aux_capit), r.cantidad_recuperada, r.capital_recuperado,
IfNULL(round((r.cantidad_recuperada*100/(r.cantidad_creditos)),2),0)
 from reporte1 r")) {
            echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        $res = $mysqli->store_result();
        $coco = $res->fetch_all();
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
        

        // agregamos información a las celdas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'OFICIAL')
                ->setCellValue('B1', 'CANTIDAD  ')
                ->setCellValue('C1', 'CAPITAL ')
                ->setCellValue('D1', 'CANTIDAD_RECUPERADA  ')
                ->setCellValue('E1', 'CAPITAL_RECUPERADO  ')
                ->setCellValue('F1', 'PORCENTAJE  ');




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
        $objBorderA5->getTop()->getColor()->setARGB('FFFF0000'); // Color del marco 
        $objBorderA5->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objBorderA5->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objBorderA5->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //Especifica el estilo de celda copiar información. 
        $objActSheet->duplicateStyle($objStyleA5, 'A1:F1');


        $cont = 2;
        foreach ($coco as $value) {

            $this->excel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $cont, $value[0])
                    ->setCellValue('B' . $cont, $value[1])
                    ->setCellValue('C' . $cont, $value[2])
                    ->setCellValue('D' . $cont, $value[3])
                    ->setCellValue('E' . $cont, $value[4])
                    ->setCellValue('F' . $cont, $value[5]);
                    

            $cont++;
        }


        // Renombramos la hoja de trabajo
        $this->excel->getActiveSheet()->setTitle('CumplimientoGeneralOficial');


        // configuramos el documento para que la hoja
        // de trabajo número 0 sera la primera en mostrarse
        // al abrir el documento
        $this->excel->setActiveSheetIndex(0);

        $fecha = date('Y/M/d');
        $nombre = 'CumplimientoGeneralOficial-' . "$fecha" . '.xlsx';


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