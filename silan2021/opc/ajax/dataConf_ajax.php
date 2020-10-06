<?
header('Content-Type: text/html; charset=UTF-8');

if($_POST["id"]!=""){
require("../codebase/config.php");
$db = conectaDb();
$sql = $db->prepare("SELECT * FROM conferencistas where id_conf=?");
$sql->bindValue(1,$_POST["id"]);
$sql->execute();
	if($sql->rowCount()>0){
		$row = $sql->fetch();
		$personas = array(
			"id_persona"=>$row["id_conf"],
			"nombre"=>$row["nombre"],
			"apellido"=>$row["apellido"],
			"pais"=>$row["pais"],
			"institucion"=>$row["institucion"]
		);
		
		echo json_encode($personas);
	}else{
		//echo "sin persona";
	}
}else{
	//echo "vacio";
}
?>