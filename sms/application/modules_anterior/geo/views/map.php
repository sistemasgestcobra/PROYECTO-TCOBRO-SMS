
<?php
$person = $this->db->query("select p.id, p.firstname from client_referencias cr, person p where cr.credit_detail_id=$id 
and cr.person_id=p.id ORDER By cr.reference_type_id DESC;");
$per = $person->result();
?>
<form method="post" action="<?= base_url('geo/mapa/save_coordenadas') ?>" class="form-horizontal">    
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 80%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 80%;
            margin: 0;
            padding: 0;
        }
    </style>
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <button class="btn btn-primary pull-right" id="ajaxformbtn" data-target="messagesout_newcompany" reset-form="0" style="font-size: 10px"><i class="icon-map-marker"></i>&nbsp;Guardar</button>   
    <div class="form-group col-md-10">
        <strong class="col-md-2">Deudor o Garante:</strong>

        <div class="col-md-6">
            <select class="form-control" id="person" name="person" placeholder="Deudor o Garante">
<?php
foreach ($per as $row) {
    echo "<option value= $row->id> $row->firstname</option>";
}
?>
            </select> 
        </div>

    </div>
    <br>
    <div class="form-group col-md-10">
        <strong class="col-md-2">Latitud</strong>
        <div class="col-md-2">
            <input type="text" id="latitud" name="latitud" />
        </div>
        <strong class="col-md-2">Longitud</strong>
        <div class="col-md-2">
            <input type="text" id="longitud" name="longitud" />
        </div>
    </div>

    <div class="col-md-10" id="map"></div>

</form>

<script>
var marker;
var latLng;
var map;

// INICiALIZACION DE MAPA
function initMap() {
        latLng=new google.maps.LatLng(-3.990966087100784, -79.20324169790035);
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            //center: {lat: -3.990966087100784, lng: -79.20324169790035}
            center: {lat: -1.4535764, lng: -78.3213046}
        }


        );
    marker = new google.maps.Marker({
    position: latLng,
    title: 'Arrastra el marcador si quieres moverlo',
    map: map,
    draggable: true
  });

  
     google.maps.event.addListener(map, 'click', function(event) {
     updateMarker(event.latLng);

   });
   

        marker.addListener('dragend', function(event)
        {
            //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
            document.getElementById("latitud").value = this.getPosition().lat();
            document.getElementById("longitud").value = this.getPosition().lng();
        });
        

    }


// RECUPERO LOS DATOS LON LAT Y DIRECCION Y LOS PONGO EN EL FORMULARIO
function updateMarkerPosition (latLng) {
    document.getElementById("latitud").value = latLng.lat();
    document.getElementById("longitud").value = latLng.lng();
}



// ACTUALIZO LA POSICION DEL MARCADOR
function updateMarker(location) {
        marker.setPosition(location);
        updateMarkerPosition(location);
      }


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBMaaGxrBOaH_gcKbYCD4JStgJDJ6emMI&callback=initMap&language=es&region=ES"
        async defer>
</script>

