<?
include('inc/sesion.inc.php');
include('conexion.php');

$institucion_ = $_POST["institucion_"];

$sql = "INSERT INTO instituciones (Institucion) VALUES ";
$sql .= "('" . $institucion_ . "');";

mysql_query($sql, $con);
if($_POST["sola"]==1){
	
	echo "<script>\n";
		echo "window.opener.llenarArrayInstituciones('$institucion_');\n";
		echo "window.opener.llenarInstituciones();\n";
		echo "window.opener.seleccionarInstituciones('$institucion_');\n";
		echo "window.close();\n";
	echo "</script>\n";

}else{
	header ("Location: altaInstitucion.php");
}
?>