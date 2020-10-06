<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$modificar = $_GET["modificar"];
$profesion_ = $_POST["profesion_"];
$profesion_viejo = $_POST["profesion_viejo"];

if ($modificar==true)
	{		
		$sql =  "UPDATE profesiones SET ";
		$sql .= "Profesion = '" . $profesion_;
		$sql .= "' WHERE Profesion = '" . $profesion_viejo . "';";
		mysql_query($sql, $con);
		
		
		$sql2 =  "UPDATE congreso SET ";
		$sql2 .= "Profesion = '" . $profesion_;
		$sql2 .= "' WHERE Profesion = '" . $profesion_viejo . "';";
		mysql_query($sql2, $con);
		
		$sql3 =  "UPDATE personas SET ";
		$sql3 .= "Profesion = '" . $profesion_;
		$sql3 .= "' WHERE Profesion = '" . $profesion_viejo . "';";
		mysql_query($sql3, $con);
		
		$sql4 =  "UPDATE personas_trabajos_libres SET ";
		$sql4 .= "Profesion = '" . $profesion_;
		$sql4 .= "' WHERE Profesion = '" . $profesion_viejo . "';";
		mysql_query($sql4, $con);
}
else
{
		$sql = "DELETE FROM profesiones WHERE ID_Profesiones = " . $id;
		mysql_query($sql, $con);
}
header ("Location: altaProfesion.php");
?>
