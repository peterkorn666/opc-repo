<?php
	require("../conexion.php");
	require("../clases/class.baseController.php");
	$base = new baseController();
	
	$insert = array(
		"nombre"=>$_POST["nombre"],
		"pais"=>$_POST["pais"],
		"mail"=>$_POST["mail"],
		"clave"=>$_POST["clave"],
		"nivel"=>$_POST["nivel"]
	);
	if($_POST["key"]==""){
		$query = $base->insertarEnBase("evaluadores",$insert);
	}
	else
		$query = $base->updateEnBase("evaluadores",$insert, "id='{$_POST["key"]}'");
	if($query){
		header("Location: crearEvaluador.php?estado=1");
	}else{
		header("Location: crearEvaluador.php?estado=2");
	}
?>