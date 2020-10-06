<?php
	session_start();
	$pasaporte = isset($_POST["pasaporte"]);
	//$tipo_inscripcion = isset($_POST["tipo_inscripcion"]);
	$session_pasaporte = isset($_SESSION["inscripcion"]["numero_pasaporte"]);
	//$session_tipo_inscripcion = isset($_SESSION["inscripcion"]["tipo_inscripcion"]);
	$post_vacio = !$pasaporte; //|| !$tipo_inscripcion;
	$session_vacia = !$session_pasaporte; //|| !$session_tipo_inscripcion;
	
	if($post_vacio && $session_vacia){
		header("Location: check.php");die();
	}
	
	require("../init.php");
	require("clases/Db.class.php");
	require("clases/lang.php");
	require("clases/inscripcion.class.php");//var_dump("aca");die();
	$inscripcion = new Inscripcion();
	//if($session_vacia){
		/*if($_POST["tipo_inscripcion"] !== $_SESSION["inscripcion"]["tipo_inscripcion"]){
			unset($_SESSION["inscripcion"]["costos_inscripcion"]);
		}*/
		$_SESSION["inscripcion"]["numero_pasaporte"] = $_POST["pasaporte"];
		//$_SESSION["inscripcion"]["tipo_inscripcion"] = $_POST["tipo_inscripcion"];
		$existeInscripcion = $inscripcion->existeInscripcion();
		if($existeInscripcion){
			header("Location: check.php?ae=1");die();
		}
	//}
	header("Location: index.php");die();
?>