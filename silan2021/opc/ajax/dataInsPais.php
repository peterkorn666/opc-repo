<?
header('Content-Type: text/html; charset=UTF-8');

if($_POST["id"]!="" && $_POST["type"]!=""){
require("../codebase/config.php");
$db = conectaDb();
if($_POST["type"]=="pais")
	$sql = $db->prepare("SELECT * FROM paises WHERE ID_Paises=?");
	@$sql->bindValue(1,$_POST["id"]);
	$sql->execute();
	if($sql->rowCount()>0){
		$row = $sql->fetch();		
		echo $row["Pais"];
	}else{
		echo NULL;
	}
}else if($_POST["type"]=="institucion"){
	$sql = $db->prepare("SELECT * FROM instituciones WHERE ID_Instituciones=?");
	$sql->bindValue(1,$_POST["id"]);
	$sql->execute();
	if($sql->rowCount()>0){
		$row = $sql->fetch();		
		echo $row["Institucion"];
	}else{
		echo NULL;
	}
}else
	echo NULL;
?>