<?
include('inc/sesion.inc.php');
include('conexion.php');

$tematica_ = $_POST["tematica_"];

$sql = "INSERT INTO tematicas (Tematica) VALUES ";
$sql .= "('" . $tematica_ . "');";

mysql_query($sql, $con);

if($_POST["sola"]==1){
	
	echo "<script>\n";
		echo "window.opener.llenarArrayTematicas('$tematica_');\n";
		echo "window.opener.llenarTematicas();\n";
		echo "window.opener.seleccionarTematicas('$tematica_');\n";
		echo "window.close();\n";
	echo "</script>\n";

}else{

	header ("Location:altaTematica.php");
	
}
?>