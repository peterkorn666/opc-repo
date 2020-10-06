<?
include('inc/sesion.inc.php');
include('conexion.php');

$orden_area = $_POST["orden_area"];
$area_ = $_POST["area_"];

$sqlOrden = "SELECT * FROM areas_trabjos_libres WHERE orden='$orden_area'";
$mysqlOrden = mysql_query($sqlOrden,$con);

if(mysql_num_rows($mysqlOrden)>0){
	header ("Location:altaAreaTL.php?orden=1");
	die();
}


$sql = "INSERT INTO areas_trabjos_libres (orden,Area) VALUES ";
$sql .= "('$orden_area','$area_');";
mysql_query($sql, $con);

if($_POST["sola"]==1){
	
	echo "<script>\n";
	
		echo "window.opener.llenarArrayAreas('$area_');\n";
		echo "window.opener.llenarAreas();\n";
		echo "window.opener.seleccionarAreas('$area_');\n";
		
		echo "window.close();\n";
	echo "</script>\n";

}else{
	header ("Location:altaAreaTL.php");
}
?>