<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    function successAlert($message, $title = 'Gestocobra', $timer = '0'){
        if($timer == '0'){
            $timer = '9999999999999';
        }
        echo tagcontent(
            'script', 
            'swal({
                title: "'.$title.'",
                text: "'.$message.'",
                timer: '.$timer.',
                showConfirmButton: true,
                type: "success"
            })'
        );        
    }
    
    function errorAlert($message, $title = 'Alerta!', $timer = '0'){
        if($timer == '0'){
            $timer = '9999999999999';
        }        
        echo tagcontent(
            'script', 
            'swal({
                title: "'.$title.'",
                text: "'.$message.'",
                timer: '.$timer.',
                showConfirmButton: true,
                type: "error"
            })'
        );     
        
        if(ENVIRONMENT != 'production'){
            echo tagcontent('script', 'console.log("'.$message.'")');                       
        }
    }

    /*
        // able toasts
        var toasts = ["info", "error", "warning", "success", "facebook", "twitter", "skype", "android", "linkedIn", "windows", "googlePlus", "gitHub"];

        for(var i = 0, k = toasts.length; i < k; i++){
            toastr8[toasts[ i ] ]("message", "title");
        }
     * 
     * // Alternative display an info notification with title and custom icon and image from url
        toastr8.info({
            message:'This is your dog birthday!', 
            title:"Remember",
            iconClass: "fa fa-calendar",
            imgURI: ["http://domain/images/failoverDogFoto.jpg" "http://domain/images/niceFoto.png" ]
        });
    */
    function toast($message, $title = 'Gestocobra', $type = 'info'){
            echo tagcontent('script', 'toastr8["'.$type.'"]("'.$message.'", "'.$title.'")');
                    if(ENVIRONMENT != 'production'){
                        echo tagcontent('script', 'console.log("'.$message.'")');                           
                    }
    }
    
    /*
        http://saribe.github.io/eModal/#alert
     *      */
    function openModal($url, $title = 'Gestcobra | Software Integral de Cobranzas', $subtitle = '', $size='lg', $refresh_autosuggest = 0){
//        echo tagcontent('script', 'var');
        ?>
            <script>
                var url = "<?= $url ?>";
                var title = "<?= $title ?>";
                var subtitle = "<?= $subtitle ?>";
                var size = "<?= $size ?>";
                var refreshAutosuggest = "<?= $refresh_autosuggest ?>";
                var options = {
                        //message: $("#my-element-id"),
                        title: title,
                        size: size,
                        subtitle: subtitle,
                        useBin: true,
                        url: url,
                        async: false
                    };

                eModal.ajax(
                        options, 
                        title, 
                        function(e){
//                            if(refreshAutosuggest == 1){
                                setTimeout(
                                function() {
                                  $('input[id ^= autosuggest_]').focus();
                                          $('input[rel="txtTooltip"]').tooltip();
                                }, 1000);
//                            }
                            $('.datepicker').datepicker({format: "yyyy-mm-dd", language: "es"});
                            $( "select.select2able" ).select2();
//                            $('input[rel="txtTooltip"]').tooltip();
                            
//                                function() {
//                                  $('input[rel="txtTooltip"]').tooltip();
//                                }, 1000);                            
                        } 
                );
                // eModal.ajax(url, title);
            </script>
        <?php
    }
    
    function addComponent($component){
        echo $component;
    }
//comprobar las peticiones ajax para evitar accesos
    function peticion_ajax() {
        
        //si no es una petición ajax mostramos un error 404
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            echo 'hola';
            //en otro caso procesamos la petición
            
        }
        
    }    
        
    /* acortar frase o palabra*/
    function get_short_string($palabra , $cantidadDeseada , $porDelante = false)
    {
            $sufijo = "..";
            if(strlen($palabra)>$cantidadDeseada)
            {
                    if($porDelante)
                    {
                            return $sufijo.substr($palabra,strlen($palabra)-$cantidadDeseada,strlen($palabra)-1);
                    }
                    else
                    {
                            return substr($palabra,0,$cantidadDeseada-strlen($sufijo)).$sufijo;
                    }
            }
            else
            {
                $suf_complete = '';
                for ($i = 0; $i<($cantidadDeseada) - strlen($palabra); $i++) {
                    $suf_complete .= '.';
                }
                    return $palabra.$suf_complete;
            }
    }
    
    function get_relative_time($timestamp)
    {
            $diferencia = time() - $timestamp;
            if($diferencia > 0)
            {
                    $periodo = array("seg", "min", "hora", "dia", "semana", "mes" , "año", "decada");
                    $longitud = array(    "60" ,"60"  , "24" ,  "7"  , "4.35",   "12" , "10" );

                    for($j = 0; $diferencia >= $longitud[$j]; $j++)
                            $diferencia /= $longitud[$j];

                    $diferencia = round($diferencia);

                    if($diferencia != 1)
                    {
                            if($periodo[$j] == "mes")
                                    $periodo[$j].= "es";
                            else
                                    $periodo[$j].= "s";
                    }

                    return "Hace ".$diferencia." ".$periodo[$j];
            }
            else
            {
                    return "Ahora mismo";
            }
    }
    
    function count_words($string) 
    {
        $word_count = 0; 
        $string = eregi_replace(" +", " ", $string); 
        $string = eregi_replace("\n+", " ", $string); 
        $string = eregi_replace(" +", " ", $string); 
        $string = explode(" ", $string); 
     
        while (list(, $word) = each ($string)) { 
            if (eregi("[0-9A-Za-zÀ-ÖØ-öø-ÿ]", $word)) { 
                $word_count++; 
            } 
        } 
         
        return $word_count; 
         
    } // end func am_countWords   
    
    function redondear_hora($hora){
        $sep = explode(':', $hora);
        $minutos=$sep[1];
        $hora1=$sep[0];
        if($minutos>0){
            $hora = $hora1.':15:00';  // sin minutos
        }
        if($minutos>15){
            $hora = $hora1.':30:00';  // sin minutos
        }
        if($minutos>30){
            $hora = $hora1.':45:00';  // sin minutos
        }
        if($minutos > 45){
            $hora1 = $hora1+1;
            $hora = $hora1.':00:00';  // sin minutos
        }
        return $hora;  // sin minutos
    } 
    
    function get_parte_hora( $hora ){
        $horaSplit = explode(":", $hora);
            if( count($horaSplit) < 3 ){
                $horaSplit[2] = 0;
            }
        return $horaSplit;
    }


    function sumar_horas( $time1, $time2 ){
        list($hour1, $min1, $sec1) = parteHora($time1);
        list($hour2, $min2, $sec2) = parteHora($time2);
        return date('H:i:s', mktime( $hour1 + $hour2, $min1 + $min2, $sec1 + $sec2));
    }
    
    /* Formato de decimales a usar */
    function number_decimal($number, $dec = 0){
        $ci =& get_instance();
        $ci->load->model('settings_model');        
        $number = (double)$number;
        if($dec == 0){
            $dec = $ci->settings_model->getNumDecimales( 'NUM_DECIMALES' );
        }

        return number_format($number, $dec, '.', '');
    }
    
    /* Obtene el valor de una celda de excel */
    function get_value_xls( $PHPExcel,$col,$row, $default = null ){
        $res = $PHPExcel->getActiveSheet()->getCellByColumnAndRow($col,$row)->getCalculatedValue();
        return $res;
    }
    
    function sum_array($array_val) {
        $tot_sum = 0;
            if( $array_val ){
                foreach ( $array_val as $val ) {
                    if( $val <= 0 ){ continue; }
                    $tot_sum += $val;
                }            
            }
        return number_decimal($tot_sum);
    }    
    
    /* Se suma desde un objeto el atributo dado*/
    function sum_object($object, $attr){
        $tot_sum = 0;
        foreach ($object as $o) {
//            $tot_sum += $o->$attr;
        }
        return $tot_sum;
    }
    
    /* Reemplaza los caracteres no permitidos por un espacio */
    function clear_string($arreglo)
    {
        $caracteres_prohibidos = array("'","/","<",">",";",'\"');    
        return str_replace($caracteres_prohibidos," ",$arreglo);
    }      
    

    /**
     * 
     * @param double $value
     * @param double $porcent
     * @return double
     * @description Devuelve el valor del porcentaje de $value respecto a $porcent
     */
    function calc_porcent_value($value, $porcent) {
        /* calcula el valor dado un porcentaje */
        $porcent_value = ($value * $porcent)/100;
        return $porcent_value;
    }    
    
    function set_value_var( $value, $default_value = 0 ){
        if( !empty($value) ){
            return $value;
        }else{
            return $default_value;
        }
    }
    
/**
 * Form Value
 *
 * Grabs a value from the POST array for the specified field so you can
 * re-populate an input field or textarea.  If Form Validation
 * is active it retrieves the info from the validation class
 *
 * @access	public
 * @param	string
 * @return	mixed
 */
if ( ! function_exists('set_post_value'))
{
	function set_post_value($field = '', $default = '')
	{
//            return $_POST[$field];
//		if (FALSE === ($OBJ =& _get_validation_object()))
//		{
			if ( empty($_POST[$field]))
			{
				return $default;
			}

			return form_prep($_POST[$field], $field);
//		}
//
//		return form_prep($OBJ->set_value($field, $default), $field);
	}
}

//array to string
function arraytostr ($array=array()) {

     $length = 0;
     $keystring = '';
     $valuestring = '';
     foreach ($array as $key => $value) {
          $keystring .= $key;
          $valuestring .= $value.'\n';
          $length++;
     }
		
     return array($length,$keystring,$valuestring);
}

//sting to array	
function strtoarray ($length="",$keystring="",$valuestring="") {
          $keys = explode(" ",$keystring);
          $values = explode(" ",$valuestring);
          for ($i=0; $i < $length; $i++) {
		$key = $keys[$i];
		$newarray[$key] = $values[$i];
          }
		
          return $newarray;
}

/**
 * Crea un directorio en caso de no existir
 * @param type $dirpath
 * @param type $mode
 * @return type
 */
function makedirs($dirpath, $mode=0755) {
    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
}


/**
 * Ejecuta sentencias SQL desde un archivo
 *  Assuming you have an SQL file (or string) you want to run as part of the migration, which has a number of statements...
 *  CI migration only allows you to run one statement at a time. If the SQL is generated, it's annoying to split it up and create separate statements.
 *  This small script splits the statements allowing you to run them all in one go.
 * @param type $file_path
 */
function exec_sql_from_file( $file_path ) {
    $sql = file_get_contents($file_path);

    $sqls = explode(';', $sql);
    array_pop($sqls);

    $CI = & get_instance();
    foreach($sqls as $statement){
        $statment = $statement . ";";
        $CI->db->query($statement);
//        echo 'POR AQUI..';
    }    
}

/**
 * Manejo de Strings
 */

/**
 * after ('@', 'biohazard@online.ge');
 * returns 'online.ge'
 * from the first occurrence of '@'
 * @param type $this
 * @param type $inthat
 * @return type
 */
    function after ($this, $inthat)
    {
        if (!is_bool(strpos($inthat, $this)))
        return substr($inthat, strpos($inthat,$this)+strlen($this));
    }

    /**
     * after_last ('[', 'sin[90]*cos[180]');
     * returns '180]'
     * from the last occurrence of '['
     * @param type $this
     * @param type $inthat
     * @return type
     */
    function after_last ($this, $inthat)
    {
        if (!is_bool(strrevpos($inthat, $this)))
        return substr($inthat, strrevpos($inthat, $this)+strlen($this));
    }

    /**
     * before ('@', 'biohazard@online.ge');
     * returns 'biohazard'
     * from the first occurrence of '@'
     * @param type $this
     * @param type $inthat
     * @return type
     */
    function before ($this, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $this));
    }

    /**
     * before_last ('[', 'sin[90]*cos[180]');
     * returns 'sin[90]*cos['
     * from the last occurrence of '['
     * @param type $this
     * @param type $inthat
     * @return type
     */
    function before_last ($this, $inthat)
    {
        return substr($inthat, 0, strrevpos($inthat, $this));
    }

    /**
     * between ('@', '.', 'biohazard@online.ge');
     * returns 'online'
     * from the first occurrence of '@'
     * @param type $this
     * @param type $that
     * @param type $inthat
     * @return type
     */
    function between ($this, $that, $inthat)
    {
        return before ($that, after($this, $inthat));
    }

    /**
     * between_last ('[', ']', 'sin[90]*cos[180]');
     * returns '180'
     * from the last occurrence of '['
     * @param type $this
     * @param type $that
     * @param type $inthat
     * @return type
     */
    function between_last ($this, $that, $inthat)
    {
     return after_last($this, before_last($that, $inthat));
    }

    // use strrevpos function in case your php version does not include it
    function strrevpos($instr, $needle)
    {
        $rev_pos = strpos (strrev($instr), strrev($needle));
        if ($rev_pos===false) return false;
        else return strlen($instr) - $rev_pos - strlen($needle);
    }
    
    /**
     * 
     * @param type $received_value
     * @param type $field_value
     */
    function set_checked( $received_value, $field_value ){
        if($received_value == $field_value){
            return 'value= "'.$field_value.'" checked';
        }else{
            return 'value= "'.$field_value.'"';
        }
    }
    
    /**
     * Elimina caracteres especiales de una cadena
     * @param type $string
     * @return type
     */
    function clean_string( $string ) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\- ]/', '', $string); // Removes special chars.
//       return $string;
       return preg_replace('/-+/', ' ', $string); // Replaces multiple hyphens with single one.
    }    