<?
include('inc/sesion.inc.php');
include('conexion.php');

$tematica_ = $_POST["tematica_"];

$sql = "INSERT INTO tematicas_trabajos_libres (Tematica) VALUES ";
$sql .= "('" . $tematica_ . "');";

mysql_query($sql, $con);

if($_POST["sola"]==1){
	
	echo "<script>\n";
		echo "window.opener.llenarArrayTematicasTL('$tematica_');\n";
		echo "window.opener.llenarTematicasTL();\n";
		echo "window.opener.seleccionarTematicasTL('$tematica_');\n";
		echo "window.close();\n";
	echo "</script>\n";

}else{

	header ("Location:altaTematicaTL.php");
	
}
?>