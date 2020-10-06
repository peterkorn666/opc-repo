<?
include('inc/sesion.inc.php');
include('conexion.php');

$rubro_ = $_POST["rubro_"];
$descripcion_ = $_POST["descripcion_"];


$sql = "INSERT INTO rubros (rubro, descripcion) VALUES ";
$sql .= "('" . $rubro_ . "','" . $descripcion_ . "');";


mysql_query($sql, $con);

if($_POST["sola"]==1){

	echo "<script>\n";
		echo "window.opener.llenarArrayRubros('$sala_');\n";
		echo "window.opener.llenarRubros();\n";
		echo "window.opener.seleccionarRubros('$rubro_');\n";
		echo "window.close();\n";
	echo "</script>\n";
	
}else{

	header ("Location:altaRubro.php");
	
}

?>