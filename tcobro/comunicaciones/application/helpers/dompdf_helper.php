<?php 
//namespace Dompdf;
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @param type $html
 * @param type $filename
 * @param type $stream
 * @return type
 */
function pdf_create($html, $filename='', $stream=TRUE) 
{
//spl_autoload_register(function($className) {
////	if(strpos($className, 'Assetic') === 0)
//		require APPPATH .'helpers/dompdf/src/' . str_replace('\\', '/', $className.'.php');
//});
    
    require_once APPPATH."helpers/dompdf/autoload.inc.php"; 
//    namespace Dompdf;
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->output();
    file_put_contents("/var/www/html/archivo".$filename, $dompdf);
    if ($stream) {
        $dompdf->stream($filename);
    } else {
        return $dompdf->output();
    }
}