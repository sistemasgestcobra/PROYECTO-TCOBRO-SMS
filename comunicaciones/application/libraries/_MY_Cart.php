<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _MY_Cart extends CI_Cart {

	function __construct()
    {
        parent::__construct();
        $this->product_name_rules = "\.\:\-_ a-z0-9#Ññ'+´áéíóúÁÉÍÓÚ(),\/";
    }
} 