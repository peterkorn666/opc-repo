<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$modificar = $_GET['modificar'];
$cargo_ = $_POST["cargo_"];
$cargo_viejo = $_POST["cargo_viejo"];


if ($modificar==true)
	{
	$sql =  "UPDATE cargos SET ";
	$sql .= "Cargos = '" . $cargo_;
	$sql .= "' WHERE Cargos = '" . $cargo_viejo . "';";
	mysql_query($sql, $con);
	
	$sql2 =  "UPDATE congreso SET ";
	$sql2 .= "Cargos = '" . $cargo_;
	$sql2 .= "' WHERE Cargos = '" . $cargo_viejo . "';";
	mysql_query($sql2, $con);
	}
else
	{
	$sql = "DELETE FROM cargos WHERE ID_Cargo = " . $id;
	}
mysql_query($sql, $con);
header ("Location: altaCargo.php");
?>
