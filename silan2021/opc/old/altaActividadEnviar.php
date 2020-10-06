<?
include('conexion.php');
include('inc/sesion.inc.php');

$actividad_ = utf8_decode($_POST["actividad_"]);
$actividad_ing = utf8_decode($_POST["actividad_ing"]);


$sql = "INSERT INTO tipo_de_actividad (Tipo_de_actividad,Tipo_de_actividad_ing, Color_de_actividad) VALUES ";
$sql .= "('" . safes($actividad_) . "','" . safes($actividad_ing) . "','" . $_POST["colorRGB"] . "');";

mysql_query($sql, $con);

if($_POST["sola"]==1){
	
	echo "<script>\n";
		echo "window.opener.llenarArrayTipo_de_actividades('$actividad_', '".$_POST["colorRGB"]."');\n";
		echo "window.opener.llenarTipo_de_actividades();\n";
		echo "window.opener.seleccionarTipo_de_actividades('$actividad_');\n";
		echo "window.opener.alterarColor_tipo_de_actividad(window.opener.document.form1.tipo_de_actividad_.selectedIndex);\n";
		echo "window.close();\n";
	echo "</script>\n";

}else{

	header ("Location: altaActividad.php");
	
}
?>