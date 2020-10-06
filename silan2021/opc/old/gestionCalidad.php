<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$modificar = $_GET["modificar"];
$calidad_ = $_POST["calidad_"];
$calidad_ing = $_POST["calidad_ing"];
$calidad_viejo = $_POST["calidad_viejo"];

	if ($modificar==true)
	{
	
		$sql =  "UPDATE en_calidades SET ";
		$sql .= "En_calidad = '" . $calidad_;
		$sql .= "', En_calidad_ing = '" . $calidad_ing;
		$sql .= "' WHERE En_calidad = '" . $calidad_viejo . "';";
		
		mysql_query($sql, $con);
		
		
		$sql2 =  "UPDATE congreso SET ";
		$sql2 .= "En_calidad = '" . $calidad_;
		$sql2 .= "' WHERE En_calidad = '" . $calidad_viejo . "';";
		
		mysql_query($sql2, $con);
	}
	else
	{
		$sql = "DELETE FROM en_calidades WHERE ID_En_calidad = " . $id;
	}
	mysql_query($sql, $con);
	
header ("Location: altaCalidad.php");
?>
