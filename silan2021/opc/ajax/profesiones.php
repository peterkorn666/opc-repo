<?php
require("../class/core.php");
$core = new Core();
$config = $core->getConfig();
if(isset($_POST['nombre']) && empty($_POST['id'])){
	$core->bind('profesion', $_POST['nombre']);
	$sql = $core->query("INSERT INTO profesiones (Profesion) VALUES (:profesion)");
	if($sql){
		if(!isset($_POST['id']))
			echo json_encode(array("status"=>"ok", "id"=>$core->getLastID()));
		else
			header("Location: ".$config['url_opc']."?page=personasTL&status=ok");
	}
}else if(isset($_POST['id'])){
	$core->bind('id', $_POST['id']);
	$core->bind('profesion', $_POST['nombre']);
	$sql = $core->query("UPDATE profesiones SET Profesion=:profesion WHERE ID_Porfesiones=:id");
	if($sql)
		header("Location: ".$config['url_opc']."?page=personasTL&status=ok");
	else
		header("Location: ".$config['url_opc']."?page=personasTL&status=error");
}