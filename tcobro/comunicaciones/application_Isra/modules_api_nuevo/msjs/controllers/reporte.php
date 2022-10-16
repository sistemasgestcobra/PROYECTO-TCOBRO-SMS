<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CI_Controller {

function __construct() {
        parent::__construct();
    }
	public function index()
	{
            $this->reportediario();
        }
        
       public function reportediario() {     
$this->load->library('comunications/commws');
$obj_commws = new Commws();
      	$token = json_decode($obj_commws->obtenertoken(),true);
        $tok=$token['access_token'];
            $postUrl = "https://api.login-sms.com/messages/shipped-today";
            
            $array=array("Content-type: application/json",
		              "Accept: application/json",
                "Authorization:"."Bearer ".$tok);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            
            curl_setopt($ch, CURLOPT_HTTPHEADER,$array);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $responseBody = json_decode($response);
            //fputs($fp,$response."\r\n");
            curl_close($ch);
            //print_r($responseBody);
            

            require_once 'application/third_party/PHPExcel/Classes/PHPExcel.php';
            require_once 'application/third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
            //require_once 'libreria/PHPExcel/Classes/PHPExcel.php';
            //require_once 'libreria/PHPExcel/Classes/PHPExcel/IOFactory.php';

            $objPHPExcel = new PHPExcel();
            
$objPHPExcel->getProperties()->setCreator("Gestcobra") 
    ->setLastModifiedBy("callcenter") 
    ->setTitle("Reporte de Envios") 
    ->setSubject("Reporte de Envios") 
    ->setDescription("Reporte de Envios") 
    ->setKeywords("Reporte de Envios") 
    ->setCategory("Reporte de Envios"); 

$tituloReporte = "REPORTE DE ENVIOS";
$titulosColumnas = array('DETALLE', 'NUMERO', 'FECHA', 'ESTADO');

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:D1');
 
// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1',$tituloReporte) // Titulo del reporte
    ->setCellValue('A2',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B2',  $titulosColumnas[1])
    ->setCellValue('C2',  $titulosColumnas[2])
    ->setCellValue('D2',  $titulosColumnas[3]);

 $i = 3; //Numero de fila donde se va a comenzar a rellenar
 
 foreach($responseBody as $columns) {
     $array = (array)$columns;
         
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, $array['content'])
         ->setCellValue('B'.$i, $array['phone_number'])
         ->setCellValue('C'.$i, $array['shipping_date'])
         ->setCellValue('D'.$i, $array['state']);
     $i++;
 }
 

$estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Verdana',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16,
        'color'     => array(
        'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
      'type'  => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array(
            'argb' => 'FF8000')
  ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    )
);
 
$estiloTituloColumnas = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
  'rotation'   => 90,
        'startcolor' => array(
            'rgb' => 'f75431'
        ),
        'endcolor' => array(
            'argb' => 'de4b2c '
        )
    ),
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        )
    ),
    'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => TRUE
    )
);
 
$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray( array(
    'font' => array(
        'name'  => 'Arial',
        'color' => array(
            'rgb' => '000000'
        )
    ),
    'fill' => array(
  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
  'color' => array(
            'argb' => 'fdc741 ')
  ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => '3a2a47'
            )
        )
    )
));

//---------------------------
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($estiloTituloColumnas);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:D".($i-1));
//
for($i = 'A'; $i <= 'D'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
   // Se asigna el nombre a la hoja
$objPHPExcel->getActiveSheet()->setTitle('Reporte Diario SMS');
 
// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$objPHPExcel->setActiveSheetIndex(0);
 
// Inmovilizar paneles
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,3);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ReporteMensajeria.xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
        }
}