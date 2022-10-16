<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

/**
 * @author Esteban Chamba <estyom.1@gmail.com>
 * @access public
 */
class Clientreferencias {
        
   public $CI; 
   private $reference_type_id;   
   private $person_name;      
   private $person_address;      
   private $person_address_ref;      
   private $credit_detail_id;    
   private $client_code;
           
   function __construct()
    {
       $this->CI =& get_instance();
    }
    
    public function save() {
        if( !empty($this->person_name) ){
            $client_referencias = (new gestcobra\client_referencias_model())
                    ->where('reference_type_id', $this->get_reference_type_id())
                    ->where('credit_detail_id', $this->get_credit_detail_id())
                    ->find_one();

            $person = new gestcobra\person_model($client_referencias->person_id);
            $person->firstname = $this->get_person_name();
            $person->personal_address = $this->get_person_address();
            $person->address_ref = $this->get_person_address_ref();
            $person->code = $this->get_client_code();
            $person->save();
                    
            
            $client_referencias->person_id = $person->id;
            $client_referencias->reference_type_id = $this->get_reference_type_id(); /* 1 = garante */
            $client_referencias->status = 1;
            $client_referencias->credit_detail_id = $this->get_credit_detail_id();
            $client_referencias->client_code = $this->get_client_code();
            
//            print_r($client_referencias);
            
            $client_referencias->save();
//            $this->CI->output->enable_profiler(true);
            return $client_referencias;
        }else{
            return false;
        }    
    }
    
    public function get_reference_type_id() {
        return $this->reference_type_id;
    }

    public function get_person_name() {
        return $this->person_name;
    }

    public function set_reference_type_id($reference_type_id) {
        $this->reference_type_id = $reference_type_id;
    }

    public function set_person_name($person_name) {
        $this->person_name = $person_name;
    }

    public function get_credit_detail_id() {
        return $this->credit_detail_id;
    }

    public function set_credit_detail_id($credit_detail_id) {
        $this->credit_detail_id = $credit_detail_id;
    }
    
    public function get_person_address() {
        return $this->person_address;
    }

    public function set_person_address($person_address) {
        $this->person_address = $person_address;
    }

    public function get_client_code() {
        return $this->client_code;
    }

    public function set_client_code($client_code) {
        $this->client_code = $client_code;
    }

    public function get_person_address_ref() {
        return $this->person_address_ref;
    }

    public function set_person_address_ref($person_address_ref) {
        $this->person_address_ref = $person_address_ref;
    }
}
