<?php
require("../class/core.php");
$core = new Core();
$config = $core->getConfig();

if(isset($_POST['ins'])){
	$core->bind('ins', $_POST['ins']);
	$core->bind('id', $_POST['id']);
	$sql = $core->query("UPDATE personas_trabajos_libres SET inscripto=:ins WHERE ID_Personas=:id");
	if($sql)
		echo 'ok';
}else if($_POST["eliminar"]){
	$core->bind('id', $_POST['id']);
	$sql = $core->query("DELETE FROM personas_trabajos_libres WHERE ID_Personas=:id");
	if($sql)
		echo 'ok';
}else{
	$core->bind('nombre', $_POST['nombre']);
	$core->bind('profesion', $_POST['profesion']);
	$core->bind('apellidos', $_POST['apellidos']);
	$core->bind('cargo', $_POST['cargo']);
	$core->bind('institucion', $_POST['institucion']);
	$core->bind('pais', $_POST['pais']);
	$core->bind('mail', $_POST['mail']);
	
	if($_POST['id']!=''){
		$core->bind('id', $_POST['id']);	
		$sql = $core->query("UPDATE personas_trabajos_libres SET nombre=:nombre, profesion=:profesion, apellidos=:apellidos, cargos=:cargo, institucion=:institucion, pais=:pais, mail=:mail WHERE ID_Personas=:id");
		$id = $_POST['id'];
	}else
	{
		$sql = $core->query("INSERT INTO personas_trabajos_libres (nombre, profesion, apellidos, cargos, institucion, pais, mail) VALUES (:nombre, :profesion, :apellidos, :cargo, :institucion, :pais, :mail)");
		$id = $core->getLastID();
	}
	if($sql)
		header('Location: '.$config["url_opc"].'?page=personasTL&status=ok&id='.$id);
	else
		header('Location: '.$config["url_opc"].'?page=personasTL&status=error&id='.$id);
}
?>