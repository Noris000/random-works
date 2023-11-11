<?php
	
$data = file_get_contents('https://emo.lv/weather-api/forecast/?city=cesis,latvia');
$data = json_decode($data);

$days = [];
$temperatures = [];

//ja json_decode nepadod TRUE, tad tas nolas??s k?? Object, nevis k?? asociat?�vais mas?�vs. 
//p?�c j?�su izv?�les: $day['temp'] vai $day->temp, da?�??d?�bai
foreach($data->list as $day) {
	$days[] = date('Y-m-d', $day->dt);
	$temperatures[] = $day->temp->day;
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Mans Grafiks</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> <!--lai uz veciem browseriem garumz?�mes neizkrop?�o -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script> <!--chart library. Var ar?� to lejupl??d?�t local, tad ar Include uz folderi -->
</head>
<div id="mala">
	<body>
		
		<h1>Temperatūra</h1>
		Turpmākajās 14 dienās
		
		<!--neliels css style, grafika izmeram un location -->
		<div style="width: 800px;">
			<canvas id="myTemperatureChart"></canvas>
		</div>

		
		<script>
			var ctx = document.getElementById('myTemperatureChart').getContext('2d');
			new Chart(ctx, {
				type: 'line',
				data: {
					labels: <?=json_encode($days)?>,
					datasets: [{
						label: 'Temperatūra',
						data: <?=json_encode($temperatures)?>,
						backgroundColor: 'transparent',
						borderColor: 'blue'
					}]
				}
			});
		</script>
	</body>
</div>
</html>
<style>
#mala{
	display: flex;
  flex-direction: column;
  align-items:center;
  width:100%;
}
.fa-bars:before {
    content: "\f0c9  Weather";
}
</style>