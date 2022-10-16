  <body class="fourofour">
    <!-- Login Screen -->
    <div class="fourofour-container">
      <h1>
        NO
      </h1>
      <h2>
        <?php 
        if(empty($message)){
            echo 'No tiene privilegios suficientes para acceder a esta seccion del sistem';
        }else{
            echo $message;
        }             
        ?>
      </h2>
        <a class="btn btn-lg btn-default-outline" href="<?= base_url() ?>"><i class="icon-home"></i>Volver a la Ventana Principal</a>
    </div>
    <!-- End Login Screen -->
  </body>