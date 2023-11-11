<div class="container">
<?php

$climate = json_decode(file_get_contents('http://lax.lv/skola/climate.json'),true);


$co2 = $climate['capabilitiesObj']['measure_co2']['value'];


$temperature = $climate['capabilitiesObj']['measure_temperature']['value'];


$humidity = $climate['capabilitiesObj']['measure_humidity']['value'];

$noise = $climate['capabilitiesObj']['measure_noise']['value'];

$pressure = $climate['capabilitiesObj']['measure_pressure']['value'];


$timestamp = $climate['capabilitiesObj']['measure_co2']['lastUpdated'];

$mysql = new mysqli('127.0.0.1', 'dbman', 'w3Xp7Ug7ZtNQAT5h', 'IP20_Normunds');
$insert = "INSERT INTO climate (temperature, co2, humidity, noise, pressure, timestamp) VALUES ('$temperature','$co2','$humidity','$noise','$pressure', now())";

	/*if ($mysql -> query($insert) === TRUE){
	echo "\nDati pieglabati";
}else{
	echo "\nError:". $insert . "<br>" .$mysql->error;
}*/

$mysql->query("DELETE FROM `climate` ORDER BY `id` LIMIT 1");


$sql1 = $mysql->query("SELECT `temperature` FROM `climate` ORDER BY `timestamp` DESC LIMIT 1440");
$tempp = [];
while($row = $sql1->fetch_assoc()) {
  $tempp[] = $row['temperature'];
}

$sql1 = $mysql->query("SELECT `humidity` FROM `climate` ORDER BY `timestamp` DESC LIMIT 1440");
$hum = [];
while($row = $sql1->fetch_assoc()) {
  $hum[] = $row['humidity'];
}

$sql1 = $mysql->query("SELECT `co2` FROM `climate` ORDER BY `timestamp` DESC LIMIT 1440");
$co = [];
while($row = $sql1->fetch_assoc()) {
  $co[] = $row['co2']/30;
}

$sql1 = $mysql->query("SELECT `noise` FROM `climate` ORDER BY `timestamp` DESC LIMIT 1440");
$noi = [];
while($row = $sql1->fetch_assoc()) {
  $noi[] = $row['noise']/3;
}

$sql1 = $mysql->query("SELECT `pressure` FROM `climate` ORDER BY `timestamp` DESC LIMIT 1440");
$pre = [];
while($row = $sql1->fetch_assoc()) {
  $pre[] = $row['pressure']/40;
}

$sql2 = $mysql->query("SELECT `timestamp` FROM `climate` ORDER BY `timestamp` DESC LIMIT 1440");
$time = [];
while($row = $sql2->fetch_assoc()) {
  $time[] = $row['timestamp'];
}

?>
<!DOCTYPE html>
<html>
<style>
table, td, th {  
  border: 1px solid #ddd;
  text-align: left;
}

table {
  border-collapse: collapse;
  width: 50%;

}

th, td {
  padding: 15px;
}
.container {
    display: grid;
    grid-template-columns: 100px 100px; 
    grid-template-rows: 100px;
    grid-column-gap: 100px;
    display: flex;
    align-items: center;
    justify-content: center;

  }
  .t{
  <?php if($temperature >25 ){ ?>
    background-color:red;
  <?php }else if($temperature <20 ){ ?>
    background-color:green;
  <?php }else{ ?>
    background-color:yellow;
  <?php } ?>
}
.h{
  <?php if($humidity > 50 or $humidity <30 ){ ?>
    background-color:red;
  <?php }else{ ?>
    background-color:green;
  <?php } ?>
}
.c{
  <?php if($co2 >800 ){ ?>
    background-color:red;
  <?php }else if($co2 <600 ){ ?>
    background-color:green;
  <?php }else{ ?>
    background-color:yellow;
  <?php } ?>
}
.n{
  <?php if($noise >70 ){ ?>
    background-color:red;
  <?php }else if($noise <30 ){ ?>
    background-color:green;
  <?php }else{ ?>
    background-color:yellow;
  <?php } ?>
}
.p{
  <?php if($pressure >1100 or $pressure <900 ){ ?>
    background-color:red;
  <?php }else{ ?>
    background-color:green;
  <?php } ?>
}
 /* .item {
  background: #ce8888;
  }*/
</style>
<body>


<div class="item">
<table style="width:100%">
  <tr>



    <table class="rwd-table">
    <tr>
    <th>Climate</th>
    <td>Temperature</td>
    <td>Humidity</td>
    <td>Co2</td>
    <td>Noise</td>
    <td>Pressure</td>

  </tr>
  <tr>
    <th>Values</th>
    <td><?=$temperature?></td>
    <td><?=$humidity?></td>
    <td><?=$co2?></td>
    <td><?=$noise?></td>
    <td><?=$pressure?></td>

  </tr>
  <tr>
    <th>Description</th>
    <td class= "t"></td>
    <td class= "h"></td>
    <td class= "c"></td>
    <td class= "n"></td>
    <td class= "p"></td>

  </tr>
</table>
</div>
<div class="item">
  <title>Mans Grafiks</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
</head>


<h1>Temperatura</h1>


<div style="width: 800px; height: 410px;">
  <canvas id="myTemperatureChart"></canvas>
</div>

<script>
  var ctx = document.getElementById('myTemperatureChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      
      labels: <?=json_encode($time)?>,
      datasets: [{
        label: 'Temperatura C',
        data: <?=json_encode($tempp)?>,
        backgroundColor: 'transparent',
        borderColor: 'darkgreen',
        pointRadius: 0,
      pointHoverRadius: 0,
      lineTension: 0.5,
      borderColor: 'green',
      }, {
        label: 'Humidity',
        data: <?=json_encode($hum)?>,
        backgroundColor: 'transparent',
        borderColor: 'darkyellow',
        pointRadius: 0,
      pointHoverRadius: 0,
      lineTension: 0.5,
      borderColor: 'yellow',
    }, {
        label: 'Co2',
        data: <?=json_encode($co)?>,
        backgroundColor: 'transparent',
        borderColor: 'darkred',
        pointRadius: 0,
      pointHoverRadius: 0,
      lineTension: 0.5,
      borderColor: 'red',
    }, {
        label: 'Noise',
        data: <?=json_encode($noi)?>,
        backgroundColor: 'transparent',
        borderColor: 'darkblue',
        pointRadius: 0,
      pointHoverRadius: 0,
      lineTension: 0.5,
      borderColor: 'blue',
    }, {
        label: 'Pressure',
        data: <?=json_encode($pre)?>,
        backgroundColor: 'transparent',
        borderColor: 'darkorange',
        pointRadius: 0,
      pointHoverRadius: 0,
      lineTension: 0.5,
      borderColor: 'orange',
      }]
    }
  });
</script>
</div>
</div>
</body>
</html>
<style>
.fa-bars:before {
    content: "\f0c9  Datalogger";
}
</style>