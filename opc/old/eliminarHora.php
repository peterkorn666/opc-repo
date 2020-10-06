<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$sql = "DELETE FROM horas WHERE ID_Horas = " . $id;
mysql_query($sql, $con);
header ("Location:altaHora.php");
?>
