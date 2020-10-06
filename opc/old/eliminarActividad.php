<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$sql = "DELETE FROM tipo_de_actividad WHERE ID_Tipo_de_actividad = " . $id;
mysql_query($sql, $con);
header ("Location:altaActividad.php");
?>
