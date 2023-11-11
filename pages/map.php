<?php
    $myLocations = [
        [ 'lat' => 57.31367497530677, 'lng' => 25.368687765774503 ],
        [ 'lat' => 57.31136526969803, 'lng' => 25.368243020462103]
    ];  
?>

<head>
    <title>Google Simple Markers</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
</head>

<div id="map"></div>
    <script>
        function initMap() {
            
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 16,
                center: { lat: 56.93475, lng: 24.14138 },
            });

            const myLocations = <?=json_encode($myLocations)?>;
            for(let location of myLocations) {
                new google.maps.Marker({ map, position: location });
            }
            
        }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXU_KVFaR4OBmH_zbz2_JyjlfyT1Em-VE&callback=initMap&v=weekly&channel=2" async></script>

<style>
#map {
	margin: auto;
    width: 70vw;
    height: 100vh;
}
.fa-bars:before {
    content: "\f0c9  Map";
}
</style>