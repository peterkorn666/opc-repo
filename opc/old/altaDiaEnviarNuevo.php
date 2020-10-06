<?
include('inc/sesion.inc.php');
include('conexion.php');

$dia_ = $_POST["dia_"];
$dia_ing = $_POST["dia_ing"];
$orden_ = $_POST["orden_"];
$visible = $_POST["visible"];

$sql = "INSERT INTO dias (Dia, Dia_ing, Dia_orden,visible) VALUES ";
$sql .= "('" . $dia_ . "','" . $dia_ing . "','". $orden_ ."', '".$visible."');";

mysql_query($sql, $con);

if($_POST["sola"]==1){
	echo "<script>\n";
		echo "window.opener.updateDias('$dia_','$orden_');";
		echo "window.close();\n";
	echo "</script>\n";
}else{
	header ("Location:altaDia.php");
}

?>