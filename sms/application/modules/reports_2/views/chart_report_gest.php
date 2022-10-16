<?php
    if( $comparar == 0 ){
       $this->load->view('chart_global');
    }
    elseif( $comparar == 1 ){
    if($data){
        ?>
        <table data-graph-height="300" class="table table-striped highchart" data-graph-container-before="1" data-graph-type="column">
            <caption>Reporte de Gestion</caption>
          <thead>
              <tr>
                  <th>A&ntilde;o-Mes-Dia</th>
                  <th>Pendiente</th>
                  <th>No Contactado</th>
                  <th>Contactado</th>
              </tr>
           </thead>
           <tbody>

            <?php
                    foreach ($data as $value) {
                        echo '<tr>';
                        if( $search_type == 'date' AND $type_group == 2 ){
                            echo '<td>'.$value->month_name.'</td>';
                        }elseif( $search_type == 'date' AND $type_group == 1 ){
                            echo '<td>'.$value->curr_date.'</td>';
                        }elseif( $search_type == 'date' AND $type_group == 3 ){
                            echo '<td>'.$value->updated_year.'</td>';
                        }
                        elseif($search_type == 'oficial'){
                            echo '<td>'.$value->oficial_credito.'</td>';
                        }
                        elseif($search_type == 'agencia'){
                            echo '<td>'.$value->agencia_name.'</td>';
                        }
                            echo '<td>'.$value->pendiente.'</td>';
                            echo '<td>'.$value->no_contactado.'</td>';
                            echo '<td>'.$value->contactado.'</td>';
                        echo '</tr>';
                    }
            ?>
               
           </tbody>
        </table>   
        <?php
    }else{
        ?>
<a class="btn btn-warning-outline btn-block" href="#">No se encontraron resultados</a>
        <?php        
    }
       
    }
?>

<script>
    $('table.highchart').highchartTable();   
</script>