<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];

$sql = "DELETE FROM recuadros WHERE ID = " . $id;
mysql_query($sql, $con);
header ("Location:altaRecuadro.php");
?>
