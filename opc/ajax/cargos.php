<?php
require("../class/core.php");
$core = new Core();
$config = $core->getConfig();
if(isset($_POST['nombre']) && empty($_POST['id'])){
	$core->bind('cargo', $_POST['nombre']);
	$sql = $core->query("INSERT INTO cargos (Cargos) VALUES (:cargo)");
	if($sql){
		if(!isset($_POST['id']))
			echo json_encode(array("status"=>"ok", "id"=>$core->getLastID()));
		else
			header("Location: ".$config['url_opc']."?page=personasTL&status=ok");
	}
}else if(isset($_POST['id'])){
	$core->bind('id', $_POST['id']);
	$core->bind('cargo', $_POST['nombre']);
	$sql = $core->query("UPDATE cargos SET Cargos=:cargo WHERE ID_Cargos=:id");
	if($sql)
		header("Location: ".$config['url_opc']."?page=personasTL&status=ok");
	else
		header("Location: ".$config['url_opc']."?page=personasTL&status=error");
}