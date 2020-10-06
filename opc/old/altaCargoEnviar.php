<?
include('inc/sesion.inc.php');
include('conexion.php');

$cargo_ = $_POST["cargo_"];

$sql = "INSERT INTO cargos (Cargos) VALUES ";
$sql .= "('" . $cargo_ . "');";

mysql_query($sql, $con);

if($_POST["sola"]==1){
	
	echo "<script>\n";
		echo "window.opener.llenarArrayCargos('$cargo_');\n";
		echo "window.opener.llenarCargos();\n";
		echo "window.opener.seleccionarCargos('$cargo_');\n";
		echo "window.close();\n";
	echo "</script>\n";

}else{

	header ("Location: altaCargo.php");

}
?>