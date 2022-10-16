<?php

class Index extends MX_Controller {
               
    private $core;
    private $database;
	function __construct()
	{
            parent::__construct();
            $this->load->library('core_class');
            $this->load->library('database_class');

            $this->core = new Core_class();
            $this->database = new Database_class();  
            
                // Ignorar los abortos hechos por el usuario y permitir que el script
                // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
                ignore_user_abort(true);            
	}
        
        public function index() {
            $db_config_path = './resources/install/config/database.php';
            $message = '';
            // Only load the classes in case the user submitted the form
            if($_POST) {
                    // Validate the post data
                    if($this->core->validate_post($_POST) == true)
                    {

                            // First create the database, then create tables, then write config file
                            if($this->database->create_database($_POST) == false) {
                                    $message = $this->core->show_message('error',"The database could not be created, please verify your settings.");
                            } else if ($this->database->create_tables($_POST) == false) {
                                    $message = $this->core->show_message('error',"The database tables could not be created, please verify your settings.");
                            } else if ($this->core->write_config($_POST) == false) {
                                    $message = $this->core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
                            }

                            // If no errors, redirect to registration page
                            if(empty($message)) {
//                              $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
//                  $redir .= "://".$_SERVER['HTTP_HOST'];
//                  $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
//                  $redir = str_replace('install/','',$redir); 
                                sleep(60);
                                
                                header( 'Location: ' . base_url());
                            }
                    } else {
                        $message = $this->core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
                    }
            }
            
            $res['db_config_path'] = $db_config_path;
            $res['message'] = $message;
            
            $res['view_name'] = 'install/install';
            $this->load->view('common/templates/dashboard', $res);
        }
              
}

