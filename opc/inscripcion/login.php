<?php

if(empty($_GET["key"])){
	header("Location: index.php");
	die();
}

require("../init.php");
require("clases/Db.class.php");
require("clases/lang.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$db = \DB::getInstance();
$key = base64_decode($_GET["key"]);
$row = $inscripcion->getInscripto($key);

unset($_SESSION["cliente"], $_SESSION["inscripcion"]);

$_SESSION["inscripcion"] = $row;
if($_SESSION["inscripcion"]["fecha_nacimiento"]){
	$fecha_explode = explode("/", $_SESSION["inscripcion"]["fecha_nacimiento"]);
	$_SESSION["inscripcion"]["day"] = $fecha_explode[0];
	$_SESSION["inscripcion"]["month"] = $fecha_explode[1];
	$_SESSION["inscripcion"]["year"] = $fecha_explode[2];
}

//$autores = $db->get("cuenta_autores", ["id_inscripto","=", $row["id"]])->results();
/*if(count($autores)>0){
	foreach($autores as $a){
		$_SESSION["inscripcion"]["input_selected_autor"][] = $a["id_autor"];
	}
}*/

//$_SESSION["cliente"] = $db->get("cuentas", ["id","=", $row["id_cuenta"]])->first();


$_SESSION["inscripcion"]["admin"] = true;
header("Location: index.php");
