<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];

$sql = "DELETE FROM personas_trabajos_libres WHERE ID_Personas = " . $id;
mysql_query($sql, $con);

header ("Location:listadoPersonasTL.php");
?>