<html>
<body>
<?php
$students = json_decode(file_get_contents('https://lax.lv/skola/studentsList.json'),true);
?>

<table border="1">

<tr>
<th style="background-color;Black; Color;White">No.</th>
<th style="background-color;Black; Color;White; width:200px;">Vards</th>
<th style="background-color;Black; Color;White; width:100px;">Gadi</th>
<th style="background-color;Black; Color;White; width:100px;">Garums</th>
<th style="background-color;Black; Color;White; width:100px;">Pilseta</th>
<th style="background-color;Black; Color;White; width:100px;">Vid. atz.</th>
</tr>


<?php
$i=1;  
foreach($students as $student){
$student['age'] = round(time() - strtotime($student['dob']) / (3600*24*365),1);
$student['averageGrade']= round( array_sum($student['grades']) / count($student['grades']),1);
?>


<tr>
	<td class="bold"><?=$i?></td>
	<td style="Color:Red; "><?=$student["name"] ?></td>
	<td><?=$student["age"] ?></td>
	<td><?=$student['height'] ?></td>
	<td><?=$student['hometown'] ?></td>
	<td><?=$student['averageGrade'] ?></td>
</tr>
<?php $i++; } ?>

</table>
</body>
</html>

<style>
table {
	margin: auto;
}
.fa-bars:before {
    content: "\f0c9  Skolēni";
}
</style>