<?
include('inc/sesion.inc.php');
include('conexion.php');

$hora_ = $_POST["hora_"];
$min_ = $_POST["min_"];

$sql = "INSERT INTO horas (Hora) VALUES ";
$sql .= "('" . $hora_ . ":" . $min_ . "');";
mysql_query($sql, $con);


$sql0 = "Select Hora From horas Order by ID_Horas DESC LIMIT 1";
$rs0 = mysql_query($sql0,$con);
while ($row0 = mysql_fetch_array($rs0)){

$ultimoIngreso = substr($row0["Hora"],0,-3);

}


if($_POST["sola"]==1){
	echo "<script>\n";
		echo "window.opener.updateHoras('$ultimoIngreso');";
		echo "window.close();\n";
	echo "</script>\n";
}else{
	header ("Location: altaHora.php");
}
?>
