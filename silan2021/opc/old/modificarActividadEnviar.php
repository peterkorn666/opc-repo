<?
include('inc/sesion.inc.php');
include('conexion.php');

$actividad_ = $_POST["actividad_"];
$actividad_ing = $_POST["actividad_ing"];

$actividad_viejo = $_POST["actividad_viejo"];
$actividad_ing_viejo = $_POST["actividad_ing_viejo"];


$sql =  "UPDATE tipo_de_actividad SET ";
$sql .= "Tipo_de_actividad = '" . $actividad_;
$sql .= "', Tipo_de_actividad_ing = '" . $actividad_ing. "',  Color_de_actividad = '" . $_POST["colorRGB"];

$sql .= "' WHERE Tipo_de_actividad = '" . $actividad_viejo . "';";

mysql_query($sql, $con);


$sql2 =  "UPDATE congreso SET ";
$sql2 .= "Tipo_de_actividad = '" . $actividad_;
$sql2 .= "' WHERE Tipo_de_actividad = '" . $actividad_viejo . "';";

mysql_query($sql2, $con);

header ("Location:altaActividad.php");
?>