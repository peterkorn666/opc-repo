<?php
require("conexion.php");
require("class/abstract.php");
$trabajos = new abstracts();

$ins = $_POST["id"];
echo $ins;
die();

$instituciones = $trabajos->getInstituciones($ins);
$institucion = "";
while($row = $instituciones->fetch()){
	$institucion .= $row["Institucion"].",";
}
	
echo trim($institucion,",");
?>