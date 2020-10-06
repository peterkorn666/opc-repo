<?
include('inc/sesion.inc.php');
include('conexion.php');

$hora_ = $_POST["hora_"];
$min_ = $_POST["min_"];
$hora_viejo = $_POST["hora_viejo"];


$sql =  "UPDATE horas SET ";
$sql .= "Hora = '" . $hora_ . ":" . $min_;

$sql .= "' WHERE Hora = '" . $hora_viejo . "';";

mysql_query($sql, $con);

$sql2 =  "UPDATE congreso SET ";
$sql2 .= "Pais = '" . $pais_;

$sql2 .= "' WHERE Pais = '" . $pais_viejo . "';";

mysql_query($sql2, $con);

header ("Location:altaPais.php");
?>