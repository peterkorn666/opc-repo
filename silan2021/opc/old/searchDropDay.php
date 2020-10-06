<?php
require("conexion.php");

$search = $_POST["search"];
$opt = $_POST["opt"];
header('Content-Type: text/html; charset=UTF-8');

if($opt=="1")
{
	$sql = mysql_query("SELECT * FROM personas WHERE apellido LIKE '".safes($search)."%'",$con) or die(mysql_error());
	
	echo '<div style="height:25%;overflow:auto;">';
	
	echo '<table class="table" id="table-search-result" style="margin-top:20px; font-size:13px;border:1px solid #5C5C5C">';
	$i = 1;
	while($row = mysql_fetch_array($sql)){
		if($i%2==0)
			$bg = "bgcolor='#F5F5F5'";
		else
			$bg = "bgcolor='#E3E3E3'";
		echo '<tr '.$bg.' data-id="'.$row["ID_Personas"].'">';
				echo '<td>';
					echo $row["nombre"]." ".$row["apellido"];
				echo '</td>';
		echo "</tr>";
		$i++;
	}
	
	echo '</table>';
	
	echo '</div>';
	
}else if($opt=="2"){
	header('Content-Type: text/html; charset=iso-8859-1');
	$sql = mysql_query("SELECT * FROM trabajos_libres WHERE titulo_tl LIKE '%".safes($search)."%' or numero_tl LIKE '%".safes($search)."%'",$con) or die(mysql_error());
	
	echo '<table class="table" id="table-search-result" style="margin-top:20px; font-size:13px;border:1px solid #5C5C5C">';
	$i = 1;
	while($row = mysql_fetch_array($sql)){
		if($i%2==0)
			$bg = "bgcolor='#F5F5F5'";
		else
			$bg = "bgcolor='#E3E3E3'";
		echo '<tr '.$bg.' data-id="'.$row["ID"].'">';
				echo '<td>';
					echo '<div style="max-height:36px;overflow:hidden">'.$row["numero_tl"]." - ".utf8_decode($row["titulo_tl"]).'</div>';
				echo '</td>';
		echo "</tr>";
		$i++;
	}
	
	echo '</table>';
	
}
else{
	echo "No results";
}




?>