<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$modificar = $_GET["modificar"];
$institucion_ = $_POST["institucion_"];
$institucion_viejo = $_POST["institucion_viejo"];

if ($modificar==true)
	{	
	$sql =  "UPDATE instituciones SET ";
	$sql .= "Institucion = '" . $institucion_;
	$sql .= "' WHERE Institucion = '" . $institucion_viejo . "';";
	mysql_query($sql, $con);
	
	$sql2 =  "UPDATE congreso SET ";
	$sql2 .= "Institucion = '" . $institucion_;
	$sql2 .= "' WHERE Institucion = '" . $institucion_viejo . "';";
	mysql_query($sql2, $con);
	
	$sql3 =  "UPDATE personas SET ";
	$sql3 .= "Institucion = '" . $institucion_;
	$sql3 .= "' WHERE Institucion = '" . $institucion_viejo . "';";
	mysql_query($sql3, $con);
	
	$sql4 =  "UPDATE personas_trabajos_libres SET ";
	$sql4 .= "Institucion = '" . $institucion_;
	$sql4 .= "' WHERE Institucion = '" . $institucion_viejo . "';";
	mysql_query($sql4, $con);
	}
else{
	$sql = "DELETE FROM instituciones WHERE ID_Instituciones = " . $id;
	mysql_query($sql, $con);
	}
header ("Location: altaInstitucion.php");
?>
