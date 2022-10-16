    <?Php
       setlocale(LC_TIME,'es_MX');                     
    ?>

    <style>
      p { page-break-after: always; }
      .footer { position: fixed; bottom: 0px; font-size: 8px; }
      .pagenum:before { content: counter(page); }
    </style>
            <?php
                $ml_template = new \gestcobra\notification_format_model($id);
                
                if( $credit_id > 0 ){
                    $credit_detail = new gestcobra\credit_detail_model($credit_id);
                    $client = (new gestcobra\client_referencias_model())
                            ->where('credit_detail_id',$credit_detail->id)
                            ->where('reference_type_id','3')->find();
                    
                    $persona_client = new gestcobra\person_model($client->person_id);
                    $company = new gestcobra\company_model($this->user->company_id);
                    
                    $COMPANY_NAME = $company->nombre_comercial;
                    $DEUDOR_NAME = $persona_client->firstname;
                    $SOCIO_NUMERO = $credit_detail->nro_cuotas;
                    $CUENTA = $credit_detail->nro_pagare;
                    $PAGO_MINIMO = $credit_detail->deuda_inicial;
                    $SALDO_ACTUAL = $credit_detail->saldo_actual;
                    $FECHA_ADJUDICACION = $credit_detail->adjudicacion_date;
                    $SALDO_TOTAL = $credit_detail->cuotas_pagadas;
                    $CUOTAS_MORA = $credit_detail->cuotas_mora;
                    $DIAS_MORA = $credit_detail->dias_mora;
                    $TOTAL_CUOTAS_VENCIDAS = $credit_detail->total_cuotas_vencidas;
                    $PLAZO_ORIGINAL = $credit_detail->plazo_original;
                    $FECHA_PROXIMO_PAGO = $credit_detail->last_pay_date;
                    $CIUDAD = $persona_client->address_ref;
                    
                    $format = str_replace('COMPANY_NAME', $COMPANY_NAME, htmlspecialchars_decode($ml_template->format));
                        $format = str_replace('SOCIO_NUMERO',$SOCIO_NUMERO,$format);
                        $format = str_replace('DEUDOR_NAME',$DEUDOR_NAME,$format);
                        $format = str_replace('CUENTA',$CUENTA,$format);
                        $format = str_replace('PAGO_MINIMO',$PAGO_MINIMO,$format);
                        $format = str_replace('SALDO_ACTUAL',$SALDO_ACTUAL,$format);
                        $format = str_replace('FECHA_ADJUDICACION',$FECHA_ADJUDICACION,$format);
                        $format = str_replace('SALDO_TOTAL',$SALDO_TOTAL,$format);
                        $format = str_replace('CUOTAS_MORA',$CUOTAS_MORA,$format);
                        $format = str_replace('DIAS_MORA',$DIAS_MORA,$format);
                        $format = str_replace('TOTAL_CUOTAS_VENCIDAS',$TOTAL_CUOTAS_VENCIDAS,$format);
                        $format = str_replace('PLAZO_ORIGINAL',$PLAZO_ORIGINAL,$format);
                        $format = str_replace('FECHA_PROXIMO_PAGO',$FECHA_PROXIMO_PAGO,$format);
                        $format = str_replace('CIUDAD',$CIUDAD,$format);
                    
                    ?>
                        <h3 style="font-weight: bold; text-align: center">Aviso de Cobranza</h3>
                        <span>Fecha: <?= date('Y-m-d', time()) ?></span><br/>
                        <span>Cliente: <?= $persona_client->firstname.' '.$persona_client->lastname ?></span><br/>
                        <span>Direccion: <?= $persona_client->personal_address ?></span><br/>
                        <span>No Pagare: <?= $credit_detail->nro_pagare ?></span><br/>
                        <p>
                            <?= htmlspecialchars_decode($format) ?>
                        </p>
                    <?php
                }else{
                    foreach($c_d_id as $value) {
                        $credit_detail = new gestcobra\credit_detail_model($value);
                        
                        
                        
                        $referencia_deudor = (new gestcobra\client_referencias_model())
                                        ->where('credit_detail_id', $credit_detail->id)->where('reference_type_id', 3)->find_one();                        
                        
                        $persona_client = new gestcobra\person_model($referencia_deudor->person_id);
                        $company = new gestcobra\company_model($this->user->company_id);
                        
                        $COMPANY_NAME = $company->nombre_comercial;
                        $DEUDOR_NAME = $persona_client->firstname;
                        $SOCIO_NUMERO = $credit_detail->nro_cuotas;
                        $CUENTA = $credit_detail->nro_pagare;
                        $PAGO_MINIMO = $credit_detail->deuda_inicial;
                        $SALDO_VENCIDO = $credit_detail->saldo_actual;
                        $FECHA_ADJUDICACION = $credit_detail->adjudicacion_date;
                        $SALDO_TOTAL = $credit_detail->cuotas_pagadas;
                        $CUOTAS_MORA = $credit_detail->cuotas_mora;
//                        $DIAS_MORA = $credit_detail->dias_mora;
                        $TOTAL_CUOTAS_VENCIDAS = $credit_detail->total_cuotas_vencidas;
                        $PLAZO_ORIGINAL = $credit_detail->plazo_original;
                        $FECHA_PROXIMO_PAGO = $credit_detail->last_pay_date;
                        $CIUDAD = $persona_client->address_ref;
                        $DIRECCION = $persona_client->personal_address;
                        $CEDULA_DEUDOR = $persona_client->cedula_deudor;
                        $DIAS_MORA = $credit_detail->mora_actual;
                        $NIVEL_CARTERA = $credit_detail->nivel_cartera;
                        $FECHA_ACTUAL = strftime('%A, %d de %B del %Y');
                        
                        
                        $format = str_replace('COMPANY_NAME', $COMPANY_NAME, htmlspecialchars_decode($ml_template->format));
                        $format = str_replace('SOCIO_NUMERO',$SOCIO_NUMERO,$format);
                        $format = str_replace('DEUDOR_NAME',$DEUDOR_NAME,$format);
                        $format = str_replace('CUENTA',$CUENTA,$format);
                        $format = str_replace('PAGO_MINIMO',$PAGO_MINIMO,$format);
                        $format = str_replace('SALDO_VENCIDO',$SALDO_VENCIDO,$format);
                        $format = str_replace('FECHA_ADJUDICACION',$FECHA_ADJUDICACION,$format);
                        $format = str_replace('SALDO_TOTAL',$SALDO_TOTAL,$format);
                        $format = str_replace('CUOTAS_MORA',$CUOTAS_MORA,$format);
                        $format = str_replace('DIAS_MORA',$DIAS_MORA,$format);
                        $format = str_replace('TOTAL_CUOTAS_VENCIDAS',$TOTAL_CUOTAS_VENCIDAS,$format);
                        $format = str_replace('PLAZO_ORIGINAL',$PLAZO_ORIGINAL,$format);
                        $format = str_replace('FECHA_PROXIMO_PAGO',$FECHA_PROXIMO_PAGO,$format);
                        $format = str_replace('CIUDAD',$CIUDAD,$format);
                        $format = str_replace('DIRECCION',$DIRECCION,$format);
                        $format = str_replace('CEDULA_DEUDOR',$CEDULA_DEUDOR,$format);
                        $format = str_replace('NIVEL_CARTERA',$NIVEL_CARTERA,$format);
                        $format = str_replace('FECHA_ACTUAL',$FECHA_ACTUAL,$format);
                        
                        
                        ?>
                            <h3 style="font-weight: bold; text-align: center">Aviso de Cobranza</h3><br/>
                       
                            
                            <h3 style="font-weight: normal; text-align: right"><?= strftime('%A, %d de %B del %Y') ?></h3><br/>
                           
<!--                            <span>Cliente: <?= $persona_client->firstname.' '.$persona_client->lastname ?></span><br/>
                            <span>Direccion: <?= $persona_client->personal_address ?></span><br/>
                            <span>No Pagare: <?= $credit_detail->nro_pagare ?></span><br/>-->
                            <br/>
                            
                            <div style='page-break-after:always;'>
                                <?= htmlspecialchars_decode($format) ?>
                                <div class="footer">
                                    <span class="pagenum"></span><br/>
                                </div>
                            </div>

                        <?php                        
                    }
                }
            ?>    
    