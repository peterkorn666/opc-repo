<?php
if(empty($_POST["doc"]))
	die();
	
require("conexion.php");

$sql = $db->prepare("SELECT numero_pasaporte FROM inscriptos WHERE numero_pasaporte=?") or die('Ha ocurrido un error al verificar los datos.');
$sql->bindValue(1, $_POST["doc"]);
$sql->execute();
if($sql->rowCount()>0){
	unset($_SESSION["inscripcion"]);
	echo 0;
}else{
	session_start();
	$_SESSION["inscripcion"]["numero_pasaporte"] = $_POST["doc"];
	echo 1;
}
?>