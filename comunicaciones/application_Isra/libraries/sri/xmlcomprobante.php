<?php
namespace sri;

if (!defined('BASEPATH')) exit('No esta permitido el acceso');

// include_once("soapclientauth.php");

//La primera línea impide el acceso directo a este script
class Xmlcomprobante {
    protected $xml = null;
    protected $path_xml_generado;
    protected $factura;
    protected $cliente;
    protected $detalles;
    protected $tipo_ident;    
    protected $ambiente = 1;
    protected $emision = 1;
    protected $ci;
    protected $empresa;
    protected $server;
    protected $contribuyente;
    protected $url_ws_recepcion;
    protected $url_ws_autorizacion;
    protected $fecha_emision;
    protected $secuencia;

    /* Parametros del constructor:
    Ambiente = 1 pruebas, 2 produccion
    Tipo de Emision = Normal 1, Emisión por Indisponibilidad del Sistema=2
    */

    function __construct(){
//        $this->url_ws_recepcion=$url_recepcion;
//        $this->url_ws_autorizacion=$url_autorizacion;
//        $this->server = get_settings('ELECTRONIC_WS_FACT');
        $this->path_xml_generado = './uploads/electronics_comprob/';
        $this->ci = & get_instance();
    }

    /*
     * Metodo que carga la informacion de la factura que fue generada y posteriormente inicia el proceso
     * de armado del archivo xml
     */

    public function generar( $id_factura ) {
        
        $this->factura = new \marilyndb\ml_sricomprob_model($id_factura);        
        
        /**
         * Crea el nodo inicial
         */
        $this->xml = new \SimpleXMLElement('<factura id="comprobante" version="1.0.0"></factura>');
        
        
        $this->generar_info_tributaria();

        $this->cliente = new \marilyndb\ml_persona_model($this->factura->client_id);
        
        $this->detalles = (new \marilyndb\ml_sricomprobdetail_model())->where('venta_id', $this->factura->id)->find() ;
//        print_r($this->detalles);
        
        $this->generar_info_factura();
        $this->generar_detalles();
        $this->guardar_xml();
        
//        return $this->send_file();
    }

    /*
     * Funcion genera la informacion para el nodo infoTributaria, esta informacion se refiera a datos relacionados
     * con datos de la empresa que emite la factura.
     */

    function generar_info_tributaria() {
        $this->company = (new \marilyndb\ml_company_model())->where('id',$this->ci->user->empresa_id)->find_one();        

        $info_tributaria = $this->xml->addChild("infoTributaria");
        
        $info_tributaria->addChild('ambiente', $this->ambiente);
        $info_tributaria->addChild('tipoEmision', $this->emision);
        
        if( $this->ambiente == 1 ){
            $info_tributaria->addChild('razonSocial', trim($this->company->razon_social));
        }else{
            /* Consultar .. */
        }
        
        $info_tributaria->addChild('nombreComercial', $this->company->nombre_comercial);
        $info_tributaria->addChild('ruc', (new \marilynlibs\Company())->get_clear_ruc($this->company->ruc) );
        
        /**
         * Este documento es enviado para recibir la autorizacion, por lo tanto no tiene aun clave de acceso
         */
        $info_tributaria->addChild( 'claveAcceso', "1111111111111111111111111111111111111111111111111");
        $info_tributaria->addChild( 'codDoc', $this->factura->comprobante_cod );
        $info_tributaria->addChild( 'estab', $this->factura->establecimiento);
        $info_tributaria->addChild( 'ptoEmi', $this->factura->pemision );
        $info_tributaria->addChild( 'secuencial', str_pad($this->factura->fact_nro, 9, "0", STR_PAD_LEFT));
        $info_tributaria->addChild( 'dirMatriz', $this->company->direccion);
    }

    /*
     * Metodo que genera la informacion para el nodo infoFactura, este informacion esta relacionada
     * al datos generales de la factura
     */

    function generar_info_factura() {
        $info_factura = $this->xml->addChild("infoFactura");
        $info_factura->addChild('fechaEmision', $this->factura->emision_date);
        $info_factura->addChild('dirEstablecimiento', $this->cliente->direccion);
//      Campo no obligatorio
        
        if( $this->company->clase_contribuyente == 'ESPECIAL' ){
            $info_factura->addChild('contribuyenteEspecial', $this->company->resolucion_nro);            
        }

//      Campo no obligatorio
        if($this->company->contabilidad=="SI"){
            $info_factura->addChild('obligadoContabilidad', $this->company->contabilidad);
        }
        
        $ml_personidtype_trans = new \marilyndb\ml_personidtype_trans_model();
        $ml_personidtype_trans = $ml_personidtype_trans -> where('transaction_id',$this->factura->transaction_id)->where('personidtype_id',$this->cliente->personidtype)->find_one();
        
        $info_factura->addChild('tipoIdentificacionComprador', $ml_personidtype_trans->cod);
//      Campo no obligatorio, se puede llenar
//      $info_factura->addChild('guiaRemision', '111-111-111111111');
        
        if($ml_personidtype_trans->cod=='07'){
            $info_factura->addChild('razonSocialComprador', 'CONSUMIDOR FINAL');
            $info_factura->addChild('identificacionComprador', str_pad(9,13,"9",STR_PAD_LEFT));
        }else{
            $client_name = $this->cliente->apellidos.' '.$this->cliente->nombres;
            if($ml_personidtype_trans->cod=='04'){
                $info_factura->addChild('razonSocialComprador',trim($client_name));                
            }else{
                $info_factura->addChild('razonSocialComprador',trim($client_name));
            }
            $info_factura->addChild('identificacionComprador', trim($this->cliente->dni));
        }

        $info_factura->addChild( 'totalSinImpuestos', number_decimal($this->factura->subtotal_neto, 2) );
        
        /**
         *  Se obtienen los descuentos 
         */
            $ml_sricomprob_descuento = (new \marilyndb\ml_sricomprob_descuento_model())->where('venta_id', $this->factura->id)->where( 'descuento_type_id',1 )->find_one();
        
            $info_factura->addChild('totalDescuento', number_decimal( $ml_sricomprob_descuento->desc_value, 2 ) );
            $this->armar_total_impuesto($info_factura);
            
            $info_factura->addChild('propina', '0.00');
            $info_factura->addChild( 'importeTotal', number_decimal($this->factura->total_fact, 2) );
            
//      Campo no obligatorio, se puede llenar
//        $info_factura->addChild('moneda', '');
    }

    /**
     * XML con el detalle del comprobante
     */
    function generar_detalles() {
        $detalles = $this->xml->addChild("detalles");

        foreach ($this->detalles as $item) {
            $detalle = $detalles->addChild('detalle');
            $ml_product = new \marilyndb\ml_product_model( $item->product_id );
            
            $detalle->addChild('codigoPrincipal', $ml_product->id);
            $detalle->addChild('descripcion', $item->detalle);

            $detalle->addChild('cantidad', $item->qty);
            $detalle->addChild('precioUnitario', number_decimal($item->price_neto, 2) );
            $detalle->addChild('descuento', number_decimal($item->desc_unit_val, 2));
            
            $precioTotalSinImpuesto = $item->qty * $item->price_neto;
            $detalle->addChild('precioTotalSinImpuesto', number_decimal($precioTotalSinImpuesto, 2) );
//            $this->armar_detalles_adicionales($detalle, $item);
            $this->armar_impuestos($detalle, $item);

        }
    }

    /**
     * Se obtiene datos de impuestos a cada producto del detalle de la factura
     * @param type $info_factura
     */
    function armar_total_impuesto($info_factura) {
        $total_con_impuestos = $info_factura->addChild("totalConImpuestos");
        $total_impuesto = $total_con_impuestos->addChild('totalImpuesto');
        
        $ml_sricomprob_impuesto = new \marilyndb\ml_sricomprob_impuesto_model();
        $ml_sricomprob_impuesto = $ml_sricomprob_impuesto->where('venta_id',$this->factura->id)->find();
        
        foreach ($ml_sricomprob_impuesto as $value) {
            $total_impuesto->addChild('codigo', $value->ml_tax_rate()->find_one()->cod_tarifa);
            $total_impuesto->addChild('codigoPorcentaje', $value->ml_tax_rate()->find_one()->tarporcent);        
            $total_impuesto->addChild('baseImponible', $value->base_imponible );
            $total_impuesto->addChild('valor', $value->total_imp);            
        }        
    }

    /*
     * Funcion que genera detalles adicionales referentes a los productos, no es obligatorio
     */

//    function armar_detalles_adicionales($detalle,$item) {
//        $detalles_adicionales = $detalle->addChild("detallesAdicionales");
//        $det_adicional = $detalles_adicionales->addChild('detAdicional');
//        $det_adicional->addAttribute('nombre', 'garantia');
//        $det_adicional->addAttribute('valor', $item->meses_garantia);
//    }

    /*
     * Funcion que genera los valores de los impuestos por cada detalle del comprobante
     */

    function armar_impuestos($detalle, $item) {
        $impuestos = $detalle->addChild("impuestos");
        $this->armar_impuesto_iva($impuestos, $item);
    }

    /**
     * Obtiene los impuestos de cada producto en el detalle del comprobante
     * @param type $impuestos
     * @param type $item
     */
    function armar_impuesto_iva($impuestos, $item) {
        $impuesto = $impuestos->addChild('impuesto');
        
        $ml_sricomprobdetail_tax = new \marilyndb\ml_sricomprobdetail_tax_model();
        $ml_sricomprobdetail_tax = $ml_sricomprobdetail_tax->where('sricomprobdetail_id',$item->id)->find();
        
        foreach ($ml_sricomprobdetail_tax as $value) {
            $impuesto->addChild('codigo', $value->ml_tax_rate()->find_one()->cod_impuesto);
            $impuesto->addChild('codigoPorcentaje', $value->ml_tax_rate()->find_one()->cod_tarifa);
            $impuesto->addChild('tarifa', $value->ml_tax_rate()->find_one()->tarporcent);
            $impuesto->addChild('baseImponible', $value->base_imponible);
            $impuesto->addChild('valor', $value->total_imp);
        }          
    }

    /*
      Funcion que guarda el documento xml
     */

    function guardar_xml() {
        $dom_sxe = dom_import_simplexml($this->xml);
        if (!$dom_sxe) {
            echo 'Error al convertir a XML';
            exit;
        }

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom_sxe = $dom->importNode($dom_sxe, true);
        $dom_sxe = $dom->appendChild($dom_sxe);
        $dom->formatOutput = true;
        $el_xml = $dom->saveXML();
        $dom->save($this->path_xml_generado.'factura.xml');
    }

    /*
     * Funcion que permite enviar el archivo xml generado al WebService de facturacion, y este
     * posteriormente lo enviara el web service del sri
     */

    public function send_file() {
        return $this->webService($this->path_xml_generado.'factura.xml');
    }

    function webService($filename) {
//        Se inicia una clase SoapClientAuth, donde se fija la direccion del servicio web y crea un cliente soap
//        para el web service establecido
        

        $soapClient = new SoapClientAuth($this->server, array(
            'login' => 'username',
            'password' => 'password'
        ));

//        Se verifica que exita el archivo xml y posteriormente se lo transforma a un arreglo 
//        de bytes de base 64
        if (!($fp = fopen($filename, "r"))) {
            echo "Error opening file";
            exit;
        }
        $data = "";
        while (!feof($fp)) {
            $data .= fread($fp, 1024);
        }
        fclose($fp);
        $byteFile = base64_encode($data);
//        Se establecen los variables y sus valores para ser enviados al metodo recepcion 
//        expuesto en el web service, el mismo que nos devolvera un mensaje con informacion
//        referente al proceso de facturacion electronica
        //$message = array('buffer' => $byteFile, 'user' => 'admin','email'=>$this->cliente->email);
        $email='';
        if($this->ambiente==1){
            $email='estyom.1@gmail.com';
        }else{
            $email=$this->cliente->email;
        }

        $message = array(
                        'buffer' => $byteFile, 
                        'user' => 'admin',
                        'email'=>$email,
                        'direccion'=>$this->cliente->direccion,
                        'telefonos'=>$this->cliente->telefonos,
                        'url_recepcion'=>$this->url_ws_recepcion,
                        'url_autorizacion'=>$this->url_ws_autorizacion,
                        'razonsocial'=>$this->cliente->apellidos.' '.$this->cliente->nombres,
                        'codigo'=>$this->factura->codigofactventa
                        );
        $respuesta = $soapClient->recepcion_factura($message)->{"return"};
        return $respuesta;
    }
}