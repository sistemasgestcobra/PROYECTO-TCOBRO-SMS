<?php

class Backup extends CI_Controller {
               
	function __construct()
	{
 		parent::__construct();
	}	
        
        /* respardo de la base de datos */
        public function download_all_backups_x() {
            $this->load->library('zip');
            $path='./uploads/downloads/database_backups/';
            $this->zip->read_dir($path); 
            $this->zip->download('all_dabatase_back.zip'); 
        }
        
        /* respardo de la base de datos */
        public function back_all_database_x() {
            // Carga la clase de utilidades de base de datos
           $this->load->dbutil();

           // Crea una copia de seguridad de toda la base de datos y la asigna a una variable
           $copia_de_seguridad =& $this->dbutil->backup();

           $file_name = date('Ymd_His',  time());
           // Carga el asistente de archivos y escribe el archivo en su servidor
           $this->load->helper('file');
           write_file('./uploads/downloads/database_backups/db_'.$file_name.'.gzip', $copia_de_seguridad);
           
                // Carga el asistente de descarga y envía el archivo a su escritorio
               $this->load->helper('download');
               force_download($file_name.'.gzip', $copia_de_seguridad);
        }
        
        
        /**  
         * respardo de parte de la base de datos, unicamente lo que podria ver el cliente 
         */
        public function back_client_database() {
            // Carga la clase de utilidades de base de datos
           $this->load->dbutil();

            $prefs = array(
                            'tables'      => array('ml_account','ml_account','ml_accountsplan','ml_sricomprob','ml_sricomprobdetail','ml_sricomprobdetail_tax','ml_sricomprob_descuento','ml_sricomprob_impuesto','ml_sricomprob_tipo'),  // Arreglo de tablas para respaldar.
                            'ignore'      => array(),           // Lista de tablas para omitir en la copia de seguridad
                            'format'      => 'txt',             // gzip, zip, txt
                            'filename'    => 'mybackup.sql',    // Nombre de archivo - NECESARIO SOLO CON ARCHIVOS ZIP
                            'add_drop'    => TRUE,              // Agregar o no la sentencia DROP TABLE al archivo de respaldo
                            'add_insert'  => TRUE,              // Agregar o no datos de INSERT al archivo de respaldo
                            'newline'     => "\n"               // Caracter de nueva línea usado en el archivo de respaldo
                          );
           
           // Crea una copia de seguridad de toda la base de datos y la asigna a una variable
           $copia_de_seguridad =& $this->dbutil->backup($prefs);

           $file_name = date('Ymd_His',  time());
           // Carga el asistente de archivos y escribe el archivo en su servidor
           $this->load->helper('file');
           write_file('./uploads/downloads/database_backups/db_'.$file_name.'.gzip', $copia_de_seguridad);
           
           // Carga el asistente de descarga y envía el archivo a su escritorio
            $this->load->helper('download');
            force_download($file_name.'.gzip', $copia_de_seguridad);                
        }

}
