<?php
	if($_GET["key"]!=""){
		$datos = explode("/",$_GET["key"]);
		$numero_tl = $datos[0];
		$evaluador = $datos[1];
		require("../conexion.php");
		$sql = "DELETE FROM evaluaciones WHERE numero_tl='$numero_tl' AND idEvaluador='$evaluador';";
		$query = $con->query($sql);
		if($query){
			echo "El trabajo $numero_tl fue eliminado para este evaluador.";
		}else{
			$con->error_info;
		}
	}
?>