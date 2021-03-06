<div class="row">
	<div class="col-md-12">
		<div class="alert alert-success">
			<h2>Selamat Datang kembali, <?php echo $this->session->userdata('username'); ?></h2>
		</div>
	</div>

</div>
<div class="row">
	<div class="col-md-12">
		<h2>Lokasi Driver</h2>
		<div style="height: 800px;" id="map"></div>
		<script>
      //global array to store our markers
    var markersArray = [];
    var map;
    function load() {
        map = new google.maps.Map(document.getElementById("map"), {
            center : new google.maps.LatLng(-8.785502, 115.199806),
            zoom : 11,
            mapTypeId : 'roadmap'
        });
        var infoWindow = new google.maps.InfoWindow;

        // your first call to get & process inital data

        downloadUrl("<?php echo base_url() ?>api_kurir/all_lokasi_driver", processXML);
    }

    function processXML(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        //clear markers before you start drawing new ones
        resetMarkers(markersArray)
        for(var i = 0; i < markers.length; i++) {
            var host = markers[i].getAttribute("no_plat");
            var type = markers[i].getAttribute("jenis_kendaraan");
            var bearing = markers[i].getAttribute("bearing");
            var lastupdate = "<?php echo get_waktu() ?>"; //markers[i].getAttribute("lastupdate");
            var point = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")), parseFloat(markers[i].getAttribute("lng")));
            var html = "<b>" + "Host: </b>" + host + "<br>" + "<b>Last Updated: </b>" + lastupdate + "<br>";
            console.log(point+" "+html);
            // var icon = customIcons[type] || {};
            var marker = new google.maps.Marker({
                map : map,
                position : point,
                // label: type,
                
                icon : {
                    path: "<?php echo base_url() ?>image/logo_motor.png",
                    rotation : bearing
                }
            });
            //store marker object in a new array
            markersArray.push(marker);
            // bindInfoWindow(marker, map, infoWindow, html);


        }
            // set timeout after you finished processing & displaying the first lot of markers. Rember that requests on the server can take some time to complete. SO you want to make another one
            // only when the first one is completed.
            setTimeout(function() {
                downloadUrl("<?php echo base_url() ?>api_kurir/all_lokasi_driver", processXML);
            }, 5000);
    }

//clear existing markers from the map
function resetMarkers(arr){
    for (var i=0;i<arr.length; i++){
        arr[i].setMap(null);
    }
    //reset the main marker array for the next call
    arr=[];
}
    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;

        request.onreadystatechange = function() {
            if(request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }
    function doNothing() {}

    </script>
    <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAyfmnFvhRQqjFSW7euy935Pm8gVq9GE0&callback=load">
    </script>
	</div>
</div>
