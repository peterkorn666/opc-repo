<?php
require("../class/core.php");
$core = new Core();
$config = $core->getConfig();
if(isset($_POST['nombre']) && empty($_POST['id'])){
	$core->bind('ins', $_POST['nombre']);
	$sql = $core->query("INSERT INTO instituciones (Institucion) VALUES (:ins)");
	if($sql){
		if(!isset($_POST['id']))
			echo json_encode(array("status"=>"ok", "id"=>$core->getLastID()));
		else
			header("Location: ".$config['url_opc']."?page=instituciones&status=ok");
	}
}else if(isset($_POST['id'])){
	$core->bind('id', $_POST['id']);
	$core->bind('ins', $_POST['nombre']);
	$sql = $core->query("UPDATE instituciones SET Institucion=:ins WHERE ID_Instituciones=:id");
	if($sql)
		header("Location: ".$config['url_opc']."?page=instituciones&status=ok");
	else
		header("Location: ".$config['url_opc']."?page=instituciones&status=error");
}