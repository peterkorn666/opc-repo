<?php
require("conexion.php");
require("class/abstract.php");
$trabajos = new abstracts();

$apellido = $_GET["apellido"];

$autores = $trabajos->searchAutorByApellido($apellido);

while($row = $autores->fetch()){
	$autor[] = array(
					"id"=>$row["ID_Personas"],
					"nombre"=>utf8_encode($row["Nombre"]),
					"apellido"=>utf8_encode($row["Apellidos"]),
					"label"=>utf8_encode($row["Nombre"])." ".utf8_encode($row["Apellidos"]),
					"institucion"=>utf8_encode($row["Institucion"]),
					"email"=>utf8_encode($row["Mail"]),
					"pais"=>$row["Pais"]
			   );
}
	
echo json_encode($autor);
?>