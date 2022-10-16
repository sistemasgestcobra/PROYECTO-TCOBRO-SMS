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
        function reporte_cd($fecha_desde,$fecha_hasta) {
		
                        
$credentials = "sms:sms2018*";
  $usuario=array(); 
		 array_push($usuario, "sms");
		$message = array(
          "clickReport" =>false,	
		  "dateToSendFrom" =>$fecha_desde,
		  "dateToSendTo" =>$fecha_hasta,	
		  "land" =>'593',
		  "userNameList" =>$usuario
 );
 
 $re1 ["filters"] =$message;
 
$postDataJson = json_encode($re1);
		$curl = curl_init();
		curl_setopt_array($curl, array(
    		
			    CURLOPT_HTTPHEADER => array(
		             // "Authorization: Basic " . base64_encode(TP_USER . ":" . TP_PASS),
					  "Authorization: Basic " . base64_encode($credentials),
		              "Content-type: application/json",
		              "Accept: application/json"
				),
				
				CURLOPT_POSTFIELDS => $postDataJson,
			    CURLOPT_RETURNTRANSFER => 1,
    			CURLOPT_URL => 'https://apismsi.aldeamo.com/SmsiWS/smsReportPost',
                    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
			    CURLOPT_POST => 1,    
		));
              
		$resp = curl_exec($curl);
$lol=json_decode($resp, true);
$lol1=$lol["result"];
$lol2=$lol1["reportList"];
return $lol2;
		curl_close($curl);

    }

        public function reportediario_fechas() {


//********************se coje desde el primer segundo del primer dia hasta el ultimo segundo del dia final*******************************************************

$fecha_desde= set_post_value('from_date')." 00:00:01";
$fecha_hasta= set_post_value('to_date')." 23:59:59";

//**********se consulta el reporte y se guarda en un array*****************************
    $resp= $this->reporte_cd($fecha_desde,$fecha_hasta);

        // configuramos las propiedades del documento
        $this->excel->getProperties()->setCreator("Gestcobra")
                                     ->setLastModifiedBy("Gestcobra.com")
                                     ->setTitle("Reporte de mensajeria")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("result file");
         
$objActSheet = $this->excel->getActiveSheet();
//$objActSheet->getColumnDimension('A')->setWidth(30);
$objActSheet->getColumnDimension('A')->setAutoSize(true);
$objActSheet->getColumnDimension('B')->setWidth(110); 
$objActSheet->getColumnDimension('C')->setAutoSize(true);
$objActSheet->getColumnDimension('D')->setAutoSize(true);
$objActSheet->getColumnDimension('E')->setAutoSize(true);

        // agregamos información a las celdas
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'NUMERO   ')
                ->setCellValue('B1', 'MENSAJE  ')
                ->setCellValue('C1', 'FECHA y HORA')
                ->setCellValue('D1', 'ESTADO  ')
                ->setCellValue('E1', 'USUARIO  ');
        
        

        
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
        foreach($resp as $value){
        
        $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A'.$cont, "0".$value["gsm"])
                ->setCellValue('B'.$cont, utf8_encode($value["message"]))
                ->setCellValue('C'.$cont, $value["dateToSend"])
                ->setCellValue('D'.$cont, "ENTREGADO")
                ->setCellValue('E'.$cont, utf8_encode($value["userName"]));
                
                
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
    



        //fin metodo   
        }
        
    }