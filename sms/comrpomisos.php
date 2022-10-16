
		 <?php	
			
			 
		$mysqli = new mysqli("localhost", "root", "", "tcobro");
		//hacer para cada usuario de casa oficina obtenidos en esta consulta en heidi: select cd.oficial_credito_id, cd.oficina_company_id from credit_detail cd GROUP by cd.oficial_credito_id ,cd.oficina_company_id
if (!$mysqli->multi_query("select credit_detail_id, max(compromiso_pago_date), compromiso_max from credit_hist where compromiso_pago_date!='0000-00-00'
and credit_status_id=3 GROUP by credit_detail_id;")) {
            echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            //  print_r("Exito");
        }
       $res = $mysqli->store_result();
        $coco = $res->fetch_all();
      
        foreach ($coco as $value) {
             $credito = $value[0];
			$fecha = $value[1];
           $valor = $value[2];
 if (!$mysqli->query("UPDATE credit_hist SET compromiso_max=1 ")) {
               
			   echo "Falló la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
           
			
			
        }

		
            
			?>