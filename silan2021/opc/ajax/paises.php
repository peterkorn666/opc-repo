<?php
require("../class/core.php");
$core = new Core();
$config = $core->getConfig();
if(isset($_POST['nombre']) && empty($_POST['id'])){
	$core->bind('pais', $_POST['nombre']);
	$sql = $core->query("INSERT INTO paises (Pais) VALUES (:pais)");
	if($sql){
		if(!isset($_POST['id']))
			echo json_encode(array("status"=>"ok", "id"=>$core->getLastID()));
		else
			header("Location: ".$config['url_opc']."?page=personasTL&status=ok");
	}
}else if(isset($_POST['id'])){
	$core->bind('id', $_POST['id']);
	$core->bind('pais', $_POST['nombre']);
	$sql = $core->query("UPDATE paises SET Pais=:pais WHERE ID_Paises=:id");
	if($sql)
		header("Location: ".$config['url_opc']."?page=personasTL&status=ok");
	else
		header("Location: ".$config['url_opc']."?page=personasTL&status=error");
}