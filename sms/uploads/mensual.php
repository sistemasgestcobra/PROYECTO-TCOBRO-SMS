
            <?php


			$mysqli = new mysqli("localhost", "tcobro3_usuario", "@tcobro@1", "tcobro3_base");
            if (!$mysqli->multi_query("CREATE TEMPORARY TABLE tmp_reportem (select cd.id,credit_status_id, cd.oficina_company_id,cd.total_cuotas_vencidas, cd.total_pagar,
            cd.dias_mora from credit_detail cd where month(cd.load_date)=MONTH(CURDATE()) and year(cd.load_date)=year(CURDATE()));")){
                echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            if (!$mysqli->multi_query("select cd.oficina_company_id,
count(cd.id), round(sum(cd.total_cuotas_vencidas),2) as por_recuperar
from tmp_reportem cd GROUP by (cd.oficina_company_id);")){
                echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            $res = $mysqli->store_result();
        $coco=$res->fetch_all();
        $mes=date("m");
            foreach($coco as $value){
                $mysqli->query("insert into reporte_general_mensual (cantidad,capital,mes_id,oficina_company_id) values ($value[1],$value[2],$mes,$value[0]);");

            }
            
        /*$res = $mysqli->store_result();
        $coco=$res->fetch_all();
        print_r($coco);*/
            
        if (!$mysqli->multi_query("select cd.oficina_company_id,
count(cd.id), round(sum(cd.total_pagar),2) as recuperado
from tmp_reportem cd where cd.total_pagar!='Null'
GROUP by (cd.oficina_company_id);")){
                echo "Fallo la llamada: (" . $mysqli->errno . ") " . $mysqli->error;
            }
        $res1 = $mysqli->store_result();
        $coco1=$res1->fetch_all();
            foreach($coco1 as $value){
                $mysqli->query("update reporte_general_mensual set cantidad_recuperada = $value[1],capital_recuperada = $value[2] where oficina_company_id = $value[0] and mes_id=$mes;");
            }


//$mes=date("m");
         $mysqli1 = new mysqli("localhost", "tcobro3_usuario", "@tcobro@1", "tcobro3_base");
         
         $mysqli1->multi_query("select * from reporte_general_mensual where mes_id=$mes;");
         
         $tab = $mysqli1->store_result();
        $sum=$tab->fetch_all();
        foreach($sum as $value){
            $canxr=$value[1]-$value[3];
            $capxr=$value[2]-$value[4];
            $mysqli1->query("update reporte_general_mensual set cantidad_x_recuperar=$canxr, capital_x_recuperar=$capxr where oficina_company_id = $value[8] and mes_id=$mes;");
        }
            
			  ?>


