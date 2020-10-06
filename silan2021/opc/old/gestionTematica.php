<?
include('inc/sesion.inc.php');
include('conexion.php');

$id = $_GET["id"];
$modificar = $_GET["modificar"];
$tematica_ = $_POST["tematica_"];
$tematica_viejo = $_POST["tematica_viejo"];

if ($modificar==true)
	{
	////ACTUALIZAR TABLA SALAS
	$sql =  "UPDATE tematicas SET ";
	$sql .= "Tematica = '" . $tematica_;
	$sql .= "' WHERE Tematica = '" . $tematica_viejo . "';";
	mysql_query($sql, $con);
	
	
	$sql2 =  "UPDATE congreso SET ";
	$sql2 .= "Tematicas = '" . $tematica_;
	$sql2 .= "' WHERE Tematicas = '" . $tematica_viejo . "';";
	mysql_query($sql2, $con);
	
	
	//******* tabla modificaciones*****************************************************************************
	
	$modificacion = "Se modifico el nombre de la temática $tematica_viejo y se la cambio por $tematica_";
	
	$sqlM = "INSERT INTO modificaciones (Tiempo,Cambio, Usuario) VALUES ";
	$sqlM .= "('" . date("d/m/Y  H:i")  . "','$modificacion' , '" .  $_SESSION["usuario"] . "')";
	mysql_query($sqlM, $con);
	//*********************************************************************************************************
	}
	else{
	$sql = "DELETE FROM tematicas WHERE ID_Tematicas = " . $id;
	}
	
mysql_query($sql, $con);

header ("Location:altaTematica.php");
?>
