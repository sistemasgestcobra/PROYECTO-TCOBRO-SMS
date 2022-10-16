    <style>
      p { page-break-after: always; }
      .footer { position: fixed; bottom: 0px; font-size: 8px; }
      .pagenum:before { content: counter(page); }
    </style>
     
			
			<?php
                $ml_template = new \gestcobra\notification_format_model($id);
                
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
			    //$tabla='<img src="C:\xampp\htdocs\tcobro\uploads\18\logo\tabla.PNG">';
				$tabla='<img src="uploads/18/logo/tabla.PNG">';
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
                        <img width="80" height="60" src="uploads/18/logo/logn.png">
                            <div style='page-break-after:always;'>
                                <?= htmlspecialchars_decode($format) ?>
                            </div>
                        <?php                        
                    }
            ?>    
    <style>
    p { page-break-after: always; }
      .pagenum:before { content: counter(page); }
    table.1{
        position: relative;
  top: -35px;
  left: -35px;
  background-color: white;
  width: 500px;
    }
    td.2{
        font-family: Times New Roman, Times, serif;
        font-size: 10px;
    }
    th.3{
        font-size: 10px;
    }
</style> 
<?php

$conn = mysqli_connect($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
$uno=implode(',', $c_d_id);
    $sql = "Select IF(cr.reference_type_id = 3, 'Deudor', 'Garante') as IDENTIFICADOR,p.code, p.firstname, ' ' as Direccion, ' 'as Telefono, ' 'as Observacion, ' 'as Hora, ' 'as Firma 
FROM client_referencias cr, person p, credit_detail cd where cr.credit_detail_id in ($uno) and p.id=cr.person_id and (cr.reference_type_id=3 or cr.reference_type_id=1) 
GROUP BY cr.person_id";

$result1 = mysqli_query($conn,$sql);
$fecha =strftime('%d-%m-%Y');

echo " 	<p></p><div class=datagrid>
    <table class=1 table1 border = 1 cellspacing = 1 cellpadding = 1 >
    
 <tr align=center valign=middle>
    <th class=3 colspan=8>HOJA DE RUTA NOTIFICACIONES DE CAMPO</th>
  </tr>
  <tr align=center valign=middle>
    <th colspan=8>FECHA:$fecha</th>
  </tr>
<tr>

<th class=3 rowspan=2 >Id</th>
<th class=3 rowspan=2 >Cuenta</th>
<th class=3 rowspan=2 WIDTH=20>Nombres</th>
<th class=3 rowspan=2 WIDTH=140>Direcci贸n</th>
<th class=3 rowspan=2 WIDTH=50>Tel茅fono</th>
<th class=3 rowspan=2 WIDTH=180>Observaci贸n </th>
<th class=3 rowspan=2 WIDTH=30>Hora</th>
<th class=3 rowspan=2 WIDTH=70>Firma</th>


	</tr></div>";
echo "<tr > </tr> ";

while($row = mysqli_fetch_array($result1)){
echo "
		<tr class=bg2>
			<td class=2>".$row[0]."</td>
			<td class=2>".$row[1]."</td>
			<td class=2>".$row[2]."</td>
			<td class=2 HEIGHT=30>".$row[3]."--------------------------------------------------------"."</td>
			<td class=2>".$row[4]."</td>
			<td class=2>".$row[5]."-------------------------------------------------------------------------"."</td>
			<td class=2>".$row[6]."</td>
                        <td class=2>".$row[7]."----------------------------"."</td>
		</tr> ";

}

echo "</table>";          
?>