<?php
require("conexion.php");
if($_POST["uni"][0]==""){
	header("Location: listadoPersonasTL.php?error=s");	
	die();
}
require("clases/personas.php");
$class = new personas(); 
$inscriptos = $_POST["uni"];

foreach($inscriptos as $insc){
	 if(!$class->marcarInscripto($insc)){
		 $estado[] = $insc;
	 }
}
if(is_array($estado)){
	foreach($estado as $estado){
		$numeros .= $estado.",";
	}
	header("Location: listadoPersonasTL.php?insc=$numeros");
}else{
	header("Location: listadoPersonasTL.php?estado=ok");
}


?>