  <?php       $agencias_combo = combobox($agencias, array('value' => 'id', 'label' => 'name'), array('name' => 'oficina_company_id', 'class' => 'form-control select2able'), true);		 
  //$conn = mysqli_connect($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);               
  ?>  
  <form method="post" action="<?= base_url('reports/reportes/open_graf_producto')?>" class="form-horizontal">    
  
  <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
  
  <fieldset>              
  <div class="panel panel-primary">        

  <div class="panel-heading">           
  <h3 class="panel-title">Grafico Tipo de Producto </h3>
  </div>            <div class="panel-body">      
  <label class="col-md-1 control-label" for="agencia">AGENCIA</label>                 
  <div class="col-md-3">                 
  <?php                  
  echo $agencias_combo;                    ?>          
  </div>

  <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_producto" class="btn btn-primary">Graficar</button>       
  </div>        </div>   
  <br></fieldset></form>
  
    <?php

       $oficiales_combo = combobox($oficiales, array('value' => 'id', 'label' => 'firstname'), array('name' => 'oficial_credito_id', 'class' => 'form-control select2able'), true);

		

       //$conn = mysqli_connect($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);

     

       

       ?>   

<form method="post" action="<?= base_url('reports/reportes/open_graf_producto_oficial')?>" class="form-horizontal">



    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">            

    <fieldset>
<div class="panel panel-primary">

            <div class="panel-heading">

                <h3 class="panel-title">Grafico Tipo de Producto Por Oficial </h3>

            </div>



            <div class="panel-body">

                <label class="col-md-1 control-label" for="agencia">OFICIAL</label>  

                <div class="col-md-3">

                    <?php

                    echo $oficiales_combo;

                    ?>

                </div> 

                <!-- Text input-->
 <button reset-form="0" name="type_group" value="1" id="autosubmit" data-target="#chart_producto" class="btn btn-primary">Graficar</button>



            </div>

        </div>

        

<br></fieldset>



</form>

<div id="chart_producto">



</div>

