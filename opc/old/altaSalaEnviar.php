<?
include('inc/sesion.inc.php');
include('conexion.php');

$sala_ = $_POST["sala_"];
$sala_ing = $_POST["sala_ing"];
$obssala_ = $_POST["obssala_"];
$orden_ = $_POST["orden_"];

//$sql = "INSERT INTO salas (Sala, Sala_orden) VALUES ";
//$sql .= "('" . $sala_ . "','" . $orden_ ."');";

$sql = "INSERT INTO salas (Sala, Sala_ing, Sala_orden, Sala_obs) VALUES ";
$sql .= "('" . $sala_ . "','" . $sala_ing . "','" . $orden_ ."','" . $obssala_ ."');";

mysql_query($sql, $con);

if($_POST["sola"]==1){

	echo "<script>\n";
		echo "window.opener.llenarArraySalas('$orden_','$sala_');\n";
		echo "window.opener.llenarSalas();\n";
		echo "window.opener.seleccionarSalas('$sala_');\n";
		echo "window.close();\n";
	echo "</script>\n";
	
}else{

	header ("Location:altaSala.php");
	
}

?>