    <style>
      p { page-break-after: always; }
      .footer { position: fixed; bottom: 0px; font-size: 8px; }
      .pagenum:before { content: counter(page); }
    </style>
     <img width="40" height="40" src="C:\xampp\htdocs\tcobro\uploads\18\logo\logn.png">
			
			<?php
                $ml_template = new \gestcobra\notification_format_model($id);
                
                if( $credit_id > 0 ){
                    $credit_detail = new gestcobra\credit_detail_model($credit_id);
                    $client = (new gestcobra\client_referencias_model())
                            ->where('credit_detail_id',$credit_detail->id)
                            ->where('reference_type_id','3')->find();

							$garante_deudor = (new \gestcobra\client_referencias_model())
                        ->where('status', 1)
                        ->where('credit_detail_id', $credit_detail->id)
                        ->where_in('reference_type_id', '1')
                        ->find();
						
						$garante_array= array();
            foreach ($garante_deudor as $value){
                array_push($garante_array, $value->id);
						    
            }
			
			$garante_deudor = (new \gestcobra\person_model())
                        ->where_in('id', $garante_array)
                        ->find();
			$nombres_garantes=array();
			foreach($garante_deudor as $nombres){
				array_push($nombres_garantes, $nombre->firstname);
			}
					
                    $persona_client = new gestcobra\person_model($client->person_id);
                    $company = new gestcobra\company_model($this->user->company_id);
                    
                    $COMPANY_NAME = $company->nombre_comercial;
                    $DEUDOR_NAME = $persona_client->firstname;
                    $SOCIO_NUMERO = $credit_detail->nro_cuotas;
                    $PAGARE_NUEMERO = $credit_detail->nro_pagare;
                    $DEUDA_INICIAL = $credit_detail->deuda_inicial;
                    $SALDO_ACTUAL = $credit_detail->saldo_actual;
                    $FECHA_ADJUDICACION = $credit_detail->adjudicacion_date;
                    $CUOTAS_PAGADAS = $credit_detail->cuotas_pagadas;
                    $CUOTAS_MORA = $credit_detail->cuotas_mora;
                    $DIAS_MORA = $credit_detail->dias_mora;
                    $TOTAL_CUOTAS_VENCIDAS = $credit_detail->total_cuotas_vencidas;
                    $PLAZO_ORIGINAL = $credit_detail->plazo_original;
                    $FECHA_ULTIMO_PAGO = $credit_detail->last_pay_date;
					$DIRECCION= $persona_client->personal_address;
					
				    $AGENCIA= '';
				    $GARANTES= "GESTCOBRA";
					//$GARANTES= implode(";",$nombres_garantes);
				    $OFICIAL= '';
                    
                    $format = str_replace('COMPANY_NAME', $COMPANY_NAME, htmlspecialchars_decode($ml_template->format));
                        $format = str_replace('SOCIO_NUMERO',$SOCIO_NUMERO,$format);
                        $format = str_replace('DEUDOR_NAME',$DEUDOR_NAME,$format);
                        $format = str_replace('PAGARE_NUEMERO',$PAGARE_NUEMERO,$format);
                        $format = str_replace('DEUDA_INICIAL',$DEUDA_INICIAL,$format);
                        $format = str_replace('SALDO_ACTUAL',$SALDO_ACTUAL,$format);
                        $format = str_replace('FECHA_ADJUDICACION',$FECHA_ADJUDICACION,$format);
                        $format = str_replace('CUOTAS_PAGADAS',$CUOTAS_PAGADAS,$format);
                        $format = str_replace('CUOTAS_MORA',$CUOTAS_MORA,$format);
                        $format = str_replace('DIAS_MORA',$DIAS_MORA,$format);
                        $format = str_replace('TOTAL_CUOTAS_VENCIDAS',$TOTAL_CUOTAS_VENCIDAS,$format);
                        $format = str_replace('PLAZO_ORIGINAL',$PLAZO_ORIGINAL,$format);
                        $format = str_replace('FECHA_ULTIMO_PAGO',$FECHA_ULTIMO_PAGO,$format);
						$format = str_replace('DIRECCION',$DIRECCION,$format);
						$format = str_replace('GARANTES',$GARANTES,$format);
					 ?>
                        <h3 style="font-weight: bold; text-align: center"> </h3>
                        <p>
                            <?= htmlspecialchars_decode($format) ?>
                        </p>
                    <?php
                }else{
                    foreach($c_d_id as $value) {
                        $credit_detail = new gestcobra\credit_detail_model($value);
                        $referencia_deudor = (new gestcobra\client_referencias_model())
                                        ->where('credit_detail_id', $credit_detail->id)->where('reference_type_id', 3)->find_one();                        
                        
						$garante_deudor = (new \gestcobra\client_referencias_model())
                        ->where('status', 1)
                        ->where('credit_detail_id', $credit_detail->id)
                        ->where_in('reference_type_id', '1')
                        ->find();
						
						$garante_array= array();
            foreach ($garante_deudor as $value){
                array_push($garante_array, $value->person_id);
   
            }
			$nombres_garantes=array();
			foreach($garante_array as $nombres){
				$persona_client = new gestcobra\person_model($nombres);
				array_push($nombres_garantes, $persona_client->firstname);
				
			}
			//OFICIAL
			    $tabla='<img src="C:\xampp\htdocs\tcobro\uploads\18\logo\tabla.PNG">';
			//AGENCIA
			$oficina_company=new gestcobra\oficina_company_model($credit_detail->oficina_company_id);
						$persona_client = new gestcobra\person_model($referencia_deudor->person_id);
                        $company = new gestcobra\company_model($this->user->company_id);
                        
                        $COMPANY_NAME = $company->nombre_comercial;
                        $DEUDOR_NAME = $persona_client->firstname;
                        $SOCIO_NUMERO = $credit_detail->nro_cuotas;
                        $PAGARE_NUEMERO = $credit_detail->nro_pagare;
                        $DEUDA_INICIAL = $credit_detail->deuda_inicial;
                        $SALDO_ACTUAL = $credit_detail->saldo_actual;
                        $FECHA_ADJUDICACION = $credit_detail->adjudicacion_date;
                        $CUOTAS_PAGADAS = $credit_detail->cuotas_pagadas;
                        $CUOTAS_MORA = $credit_detail->cuotas_mora;
                        $DIAS_MORA = $credit_detail->dias_mora;
                        $TOTAL_CUOTAS_VENCIDAS = $credit_detail->total_cuotas_vencidas;
                        $PLAZO_ORIGINAL = $credit_detail->plazo_original;
                        $FECHA_ULTIMO_PAGO = $credit_detail->last_pay_date;
						$DIRECCION= $persona_client->personal_address;
						
				    $AGENCIA= strtoupper($oficina_company->name);
					$FECHA=date('d-m-Y');
				    //$GARANTES= $nombres_garantes;
					$GARANTES= implode(";",$nombres_garantes);
				    $OFICIAL= $this->user->firstname;
					
					   $format = str_replace('COMPANY_NAME', $COMPANY_NAME, htmlspecialchars_decode($ml_template->format));
                        $format = str_replace('SOCIO_NUMERO',$SOCIO_NUMERO,$format);
                        $format = str_replace('DEUDOR_NAME',$DEUDOR_NAME,$format);
                        $format = str_replace('PAGARE_NUEMERO',$PAGARE_NUEMERO,$format);
                        $format = str_replace('DEUDA_INICIAL',$DEUDA_INICIAL,$format);
                        $format = str_replace('SALDO_ACTUAL',$SALDO_ACTUAL,$format);
                        $format = str_replace('FECHA_ADJUDICACION',$FECHA_ADJUDICACION,$format);
                        $format = str_replace('CUOTAS_PAGADAS',$CUOTAS_PAGADAS,$format);
                        $format = str_replace('CUOTAS_MORA',$CUOTAS_MORA,$format);
                        $format = str_replace('DIAS_MORA',$DIAS_MORA,$format);
                        $format = str_replace('TOTAL_CUOTAS_VENCIDAS',$TOTAL_CUOTAS_VENCIDAS,$format);
                        $format = str_replace('PLAZO_ORIGINAL',$PLAZO_ORIGINAL,$format);
                        $format = str_replace('FECHA_ULTIMO_PAGO',$FECHA_ULTIMO_PAGO,$format);
						$format = str_replace('DIRECCION',$DIRECCION,$format);
						$format = str_replace('GARANTES',$GARANTES,$format);
						$format = str_replace('AGENCIA',$AGENCIA,$format);
						$format = str_replace('FECHA',$FECHA,$format);
						$format = str_replace('OFICIAL_CREDITO',$OFICIAL,$format);
						  $format = str_replace('TABLA_COMISION',$tabla,$format);
                        ?>
                            <h3 style="font-weight: bold; text-align: center"> </h3>
                            <br/>
                            <div style='page-break-after:always;'>
                                <?= htmlspecialchars_decode($format) ?>
                                <div class="footer">
                                    Page: <span class="pagenum"></span><br/>
                                    Desarrollado Por: <span>Gestcobra</span><br/>
                                    <span>www.gestcobra.com | gerencia@gestcobra.com | 0995164158
                                    </span>
                                </div>
                            </div>

                        <?php                        
                    }
                }
            ?>    
    