<!DOCTYPE html>
<html>
<head>
<title>Google Maps API: Cara Menampilkan Lokasi dengan PHP dan MySQL</title>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAyfmnFvhRQqjFSW7euy935Pm8gVq9GE0&callback=initialize" async defer></script>
<script type="text/javascript">   
    var marker;
    function initialize(){
        // Variabel untuk menyimpan informasi lokasi
        var infoWindow = new google.maps.InfoWindow;
        //  Variabel berisi properti tipe peta
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP
        } 
        // Pembuatan peta
        var peta = new google.maps.Map(document.getElementById('googleMap'), mapOptions);      
		// Variabel untuk menyimpan batas kordinat
        var bounds = new google.maps.LatLngBounds();
        // Pengambilan data dari database MySQL
        <?php
		// Sesuaikan dengan konfigurasi koneksi Anda
			// $this->db->where('status_online', $Value);
            $data = $this->db->get('data_driver');
            foreach ($data->result() as $rw) {
                $lat = $rw->lat;
                $lng = $rw->lng;
                $plat = $rw->no_plat;
                echo  "addMarker($lat, $lng, '$plat');\n";
            }
        ?> 
        // Proses membuat marker 
        function addMarker(lat, lng, info){
            var lokasi = new google.maps.LatLng(lat, lng);
            bounds.extend(lokasi);
            var marker = new google.maps.Marker({
                map: peta,
                position: lokasi
            });       
            peta.fitBounds(bounds);
            bindInfoWindow(marker, peta, infoWindow, info);
         }
        // Menampilkan informasi pada masing-masing marker yang diklik
        function bindInfoWindow(marker, peta, infoWindow, html){
            google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(peta, marker);
          });
        }
    }
</script>
</head>
<body>

  <div id="googleMap" style="width:1100px;height:500px;"></div>
  
</body>
</html>