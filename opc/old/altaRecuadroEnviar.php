<?
include('inc/sesion.inc.php');
include('conexion.php');

$dia_ = $_POST["dia_"];
$sala_ = $_POST["sala_"];
$hora_inicio_ = $_POST["hora_inicio_"];
$hora_fin_ = $_POST["hora_fin_"];
$seExpandira = $_POST["seExpandira"];

$sql = "INSERT INTO recuadros (Dia_orden, Sala_orden, Hora_inicio , Hora_fin, seExpande) VALUES ";
$sql .= "($dia_, $sala_, '$hora_inicio_', '$hora_fin_', $seExpandira);";
mysql_query($sql, $con);

header ("Location: altaRecuadro.php");

?>
