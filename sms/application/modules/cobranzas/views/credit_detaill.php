<?php
// Change the css classes to suit your needs 

$DB = $this->load->database('gestcobral', TRUE);
  $id = $DB->query("select id from credit_detail where nro_pagare=$id");
 $lol = $id->result();
       
 if ($id->num_rows()==0) {
    $id_cre=0;
}  else {

    foreach ($lol as $row) {
            $id_cre = $row->id;
}   
}
?>

<div>
       <?php
     $this->load->view('credit_hist_report_legal', array('client_id' => "$id_cre", 'data_height' => '250', 'show_export' => '0'));
        ?>
</div>