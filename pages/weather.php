<html>
<body>
<?php
error_reporting(E_ALL);
Function myTime(){

return date('H:i:s');

}
 function sortByKey(&$array,$key,$descending = false){
        usort($array,function($a,$b)use ($key,$descending){
            if($a[$key]==$b[$key]){
            return 0;
            }
            if($descending){
                return($a[$key]<$b[$key] ? 1:-1);
            }else{
               return ($a[$key]> $b[$key] ? 1:-1);
            }
            });

  }

?>

<form method = 'POST' action=''>
<font style face="Ariel" size="5px" color="black">izvelne:</font>
<select name="dropdown" id="dropdown">
<option value="cesis">Cesis</option>
<option value="skujene">Skujene</option>
<option value="riga">Riga</option>
<option value="valmiera">Valmiera</option>
<option value="talsi">Talsi</option>
</select>
<input style="color: #e8e8e8; background-color: #525252 " type="submit">
</form>
</body>
</html>
<?php
$city = isset($_POST['dropdown']) ? $_POST['dropdown'] : '';

$forecast = json_decode(file_get_contents('https://emo.lv/weather-api/forecast/?city=' .$city .',latvia'), true);
$list = $forecast['list'];
?>

<h1 style ="color:#e8e8e8">
<h1><font face="Arial"Laika apstakli: <?=ucfirst($city)?></font><h1>
</h1>
<font face"Ariel">

<table>
	<style>

*{
      box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    }

    body{
      background-color: pink;
      font-family: Helvetica;
    -webkit-font-smoothing: antialiased;
    }

    .image img{
      width: 100px;
    }
    .image{
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .table-wrapper{
    margin: 10px 70px 70px;
    box-shadow: 0px 35px 50px rgba( 0, 0, 0, 0.2 );
    }

    .fl-table {
        border-radius: 5px;
        font-size: 12px;
        font-weight: normal;
        border: none;
        border-collapse: collapse;
        width: 100%;
        max-width: 100%;
        white-space: nowrap;
        background-color: white;
    }

    .fl-table td, .fl-table th {
        text-align: center;
        padding: 7px;
    }

    .fl-table td {
        border-right: 1px solid #f8f8f8;
        font-size: 16px;
    }

    .fl-table thead th {
        color: #ffffff;
        background: #4FC3A1;
    }


    .fl-table thead th:nth-child(odd) {
        color: #ffffff;
        background: #324960;
    }

    .fl-table tr:nth-child(even) {
        background: #F8F8F8;
    }

    /* Responsive */

    @media (max-width: 767px) {
        .fl-table {
            display: block;
            width: 100%;
        }
        .table-wrapper:before{
            content: "Scroll horizontally >";
            display: block;
            text-align: right;
            font-size: 11px;
            color: white;
            padding: 0 0 10px;
        }
        .fl-table thead, .fl-table tbody, .fl-table thead th {
            display: block;
        }
        .fl-table thead th:last-child{
            border-bottom: none;
        }
        .fl-table tbody {
            overflow-y: scroll;
            overflow-x: hidden;
            height: 300px;
        }
        .fl-table td, .fl-table th {
            text-align: center;
            width: 100%;
            border-bottom: 1px solid #f8f8f8;
        }
    }
</style>

<div class="table-wrapper">
    <table class="fl-table">

	<thead>
<tr>

<td>Date</td>
<td>Sunrise</td>
<td>Sunset</td>
<td>Moisture</td>
<td>Pressure</td>
<td>Forecast</td>
<td>Temp day</td>
<td>Day min</td>
<td>Day max</td>
<td>Temp night</td>
<td>Eve</td>
<td>Morn</td>



</tr>
</tableHead>



<?php foreach($list as $fc) {
$weather = $fc['weather'][0];
$temp = $fc['temp'];
?>

<tr>

<td><?=date('D, j.M',$fc['dt']);?></td>
<td><?=date('G:i:s',$fc['sunrise']);?></td>
<td><?=date('G:i:s',$fc['sunset']);?></td>
<td><?=$fc['humidity']?></td>
<td><?=$fc['pressure']?></td>
<td class="image"><img src= "pages/image/<?=$weather['main']?>.png"></td>
<td><?=$temp['day']?></td>
<td><?=$temp['min']?></td>
<td><?=$temp['max']?></td>
<td><?=$temp['night']?></td>
<td><?=$temp['eve']?></td>
<td><?=$temp['morn']?></td>


</tr>


<?php } ?>
</html>