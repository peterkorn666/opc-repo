<?php
header('Content-Type: text/html; charset=UTF-8');

if($_POST["str_persona"]!=""){
require("../codebase/config.php");
$db = conectaDb();
$sql = $db->prepare("SELECT * FROM conferencistas where apellido like ?  ORDER by apellido,nombre ASC");
$sql->bindValue(1,$_POST["str_persona"]."%");
$sql->execute();
	if($sql->rowCount()>0){
		$personas = array("cantidad"=>$sql->rowCount());
		while ($row = $sql->fetch()){
			$personas[] = array(
				"id_persona"=>$row["id_conf"],
				"nombre"=>$row["nombre"],
				"apellido"=>$row["apellido"],
				"pais"=>$row["pais"],
				"institucion"=>$row["institucion"]
			);
		}
		
		echo json_encode($personas);
	}else{
		//echo "sin persona";
	}
}else{
	//echo "vacio";
}
?>