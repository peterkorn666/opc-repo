<?
include('inc/sesion.inc.php');
include('conexion.php');

$tipo_ = $_POST["tipo_"];

$sql = "INSERT INTO tipo_de_trabajos_libres (tipoTL) VALUES ";
$sql .= "('$tipo_');";
mysql_query($sql, $con);

if($_POST["sola"]==1){
	
	echo "<script>\n";
		echo "window.opener.llenarArrayTipoTL('$tipo_');\n";
		echo "window.opener.llenarTipoTL();\n";
		echo "window.opener.seleccionarTipoTL('$tipo_');\n";
		
		echo "window.close();\n";
	echo "</script>\n";

}else{
	header ("Location:altaTipoTL.php");
}
?>