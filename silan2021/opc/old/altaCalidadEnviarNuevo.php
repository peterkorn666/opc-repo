<?
include('inc/sesion.inc.php');
include('conexion.php');

$calidad_ = $_POST["calidad_"];
$calidad_ing = $_POST["calidad_ing"];


$sql = "INSERT INTO en_calidades (En_calidad, En_calidad_ing) VALUES ";
$sql .= "('" . $calidad_ . "', '" . $calidad_ing . "');";

mysql_query($sql, $con);

if($_POST["sola"]==1){
	
	echo "<script>\n";
		//echo "window.opener.tempSeleccionCalidades();\n";
		echo "window.opener.llenarArrayEnCalidadesNuevo('$calidad_');\n";
		echo "window.opener.updateEnCalidad('$calidad_',".$_POST["combo"].");\n";
		//echo "window.opener.llenarEnCalidades();\n";
		//echo "window.opener.seleccionarEnCalidades('$calidad_', '".$_POST["combo"]."');\n";
		echo "window.close();\n";
	echo "</script>\n";

}else{

header ("Location: altaCalidad.php");

}
?>