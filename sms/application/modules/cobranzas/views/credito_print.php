
			<?php
			$ml_credit_detail_model = new \gestcobra\credit_detail_model($id);
                		
						?>
                        
    <style>
    table.1{
        position: relative;
  top: -35px;
  left: -35px;
  background-color: white;
  width: 500px;
    }
    td.2{
        font-family: Times New Roman, Times, serif;
        font-size: 14px;
    }
    th.3{
        font-size: 14px;
		background-color: #eee
    }
</style> 
<?php

$conn = mysqli_connect($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
	$id_re = set_post_value('credit_detail_id');
    $sql = "select ct.name, p.firstname, cd.nro_cuotas, cd.nro_pagare, cd.deuda_inicial, cd.dias_mora, cd.cuotas_mora, cd.total_cuotas_vencidas
from credit_detail cd, person p, client_referencias cr, credito_type ct where 
cd.id=$id_re and cr.reference_type_id=3  and cr.credit_detail_id=cd.id and cr.person_id=p.id and cd.credito_type_id=ct.id;";

$result1 = mysqli_query($conn,$sql);
$fecha =strftime('%d-%m-%Y');

echo " 	<p></p><div class=datagrid>
    <table class=1 table1 border = 1 cellspacing = 1 cellpadding = 1 align=center>
    
 <tr align=center valign=middle>
    <th class=3 colspan=8>FICHA INFORMATIVA DEUDOR</th>
  </tr>
  
  <tr align=center valign=middle>
    <th colspan=8>FECHA:$fecha</th>
  </tr>
<tr>

<th class=3 rowspan=2 >Producto</th>
<th class=3 rowspan=2 WIDTH=100>Nombre</th>
<th class=3 rowspan=2 WIDTH=30>Cuenta</th>
<th class=3 rowspan=2 WIDTH=80>Nro Operacion</th>
<th class=3 rowspan=2 WIDTH=80>Deuda Inicial</th>
<th class=3 rowspan=2 WIDTH=50>Dias Mora</th>
<th class=3 rowspan=2 WIDTH=70>Cuotas Mora</th>
<th class=3 rowspan=2 WIDTH=70>Tot. Cuotas Vencidas</th>


	</tr></div>";
echo "<tr > </tr> ";

while($row = mysqli_fetch_array($result1)){
echo "
		<tr class=bg2>
			<td class=2>".$row[0]."</td>
			<td class=2>".$row[1]."</td>
			<td class=2>".$row[2]."</td>
			<td class=2>".$row[3]."</td>
			<td class=2>".$row[4]."</td>
			<td class=2>".$row[5]."</td>
			<td class=2>".$row[6]."</td>
            <td class=2>".$row[7]."</td>
		</tr> ";

}

echo "</table>";      


$id_re = set_post_value('credit_detail_id');
    $sql = "select cs.status_name, p.firstname, ch.detail, ch.hist_date, ch.hist_time, ch.compromiso_pago_date, oc.firstname from credit_hist ch, credit_detail cd,
oficial_credito oc, person p, client_referencias cr, credit_status cs where ch.credit_detail_id=3414 and cd.id=ch.credit_detail_id and ch.oficial_credito_id=oc.id and
cd.id=cr.credit_detail_id and cr.reference_type_id=3 and p.id=cr.person_id and ch.credit_status_id=cs.id order by  ch.id desc;";

$result1 = mysqli_query($conn,$sql);
$fecha =strftime('%d-%m-%Y');

echo " 	<p></p><div class=datagrid>
    <table class=1 table1 border = 1 cellspacing = 1 cellpadding = 1 align=center>
    
 <tr align=center valign=middle>
    <th class=3 colspan=8>FICHA INFORMATIVA DEUDOR</th>
  </tr>
  
  <tr align=center valign=middle>
    <th colspan=8>FECHA:$fecha</th>
  </tr>
<tr>

<th class=3 rowspan=2 >Estado</th>
<th class=3 rowspan=2 WIDTH=100>Nombre</th>
<th class=3 rowspan=2 WIDTH=30>Cuenta</th>
<th class=3 rowspan=2 WIDTH=80>Nro Operacion</th>
<th class=3 rowspan=2 WIDTH=80>Deuda Inicial</th>
<th class=3 rowspan=2 WIDTH=50>Dias Mora</th>
<th class=3 rowspan=2 WIDTH=70>Cuotas Mora</th>
<th class=3 rowspan=2 WIDTH=70>Tot. Cuotas Vencidas</th>


	</tr></div>";
echo "<tr > </tr> ";

while($row = mysqli_fetch_array($result1)){
echo "
		<tr class=bg2>
			<td class=2>".$row[0]."</td>
			<td class=2>".$row[1]."</td>
			<td class=2>".$row[2]."</td>
			<td class=2>".$row[3]."</td>
			<td class=2>".$row[4]."</td>
			<td class=2>".$row[5]."</td>
			<td class=2>".$row[6]."</td>
            <td class=2>".$row[7]."</td>
		</tr> ";

}

echo "</table>"; 

$id_re = set_post_value('credit_detail_id');
$credit = (new \gestcobra\credit_detail_model())
                ->where('id', $id_re)
				->find_one();

 $DB = $this->load->database('gestcobral', TRUE);
 $id = $DB->query("select id from credit_detail where nro_pagare=$credit->nro_pagare");
 $lol = $id->result();
       
 if ($id->num_rows()==0) {
    $id_cre=0;
}  else {

    foreach ($lol as $row) {
            $id_cre = $row->id;
}   
}

$conn = mysqli_connect($DB->hostname,$DB->username,$DB->password,$DB ->database);
 $sql = "select cs.status_name, p.cedula_deudor,cd.nro_pagare, p.firstname ,ch.detail, ch.hist_date, ch.hist_time, ch.compromiso_pago_date, oc.firstname from credit_hist ch, credit_detail cd,
oficial_credito oc, person p, client_referencias cr, credit_status cs where ch.credit_detail_id=$id_cre and cd.id=ch.credit_detail_id and ch.oficial_credito_id=oc.id and
cd.id=cr.credit_detail_id and cr.reference_type_id=3 and p.id=cr.person_id and ch.credit_status_id=cs.id order by  ch.id desc;";

$result1 = mysqli_query($conn,$sql);
$fecha =strftime('%d-%m-%Y');

echo " 	<p></p><div class=datagrid>
    <table class=1 table1 border = 1 cellspacing = 1 cellpadding = 1 align=center>
    
 <tr align=center valign=middle>
    <th class=3 colspan=8>FICHA INFORMATIVA DEUDOR</th>
  </tr>
  
  <tr align=center valign=middle>
    <th colspan=8>FECHA:$fecha</th>
  </tr>
<tr>

<th class=3 rowspan=2 >Estado</th>
<th class=3 rowspan=2 WIDTH=100>Nombre</th>
<th class=3 rowspan=2 WIDTH=30>Cuenta</th>
<th class=3 rowspan=2 WIDTH=80>Nro Operacion</th>
<th class=3 rowspan=2 WIDTH=80>Deuda Inicial</th>
<th class=3 rowspan=2 WIDTH=50>Dias Mora</th>
<th class=3 rowspan=2 WIDTH=70>Cuotas Mora</th>
<th class=3 rowspan=2 WIDTH=70>Tot. Cuotas Vencidas</th>


	</tr></div>";
echo "<tr > </tr> ";

while($row = mysqli_fetch_array($result1)){
echo "
		<tr class=bg2>
			<td class=2>".$row[0]."</td>
			<td class=2>".$row[1]."</td>
			<td class=2>".$row[2]."</td>
			<td class=2>".$row[3]."</td>
			<td class=2>".$row[4]."</td>
			<td class=2>".$row[5]."</td>
			<td class=2>".$row[6]."</td>
            <td class=2>".$row[7]."</td>
		</tr> ";

}

echo "</table>"; 
     
?>

