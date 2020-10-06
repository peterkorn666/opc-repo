<?php
require("../class/core.php");
$core = new Core();

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
	if(empty($_POST["profesion"])){
		$prof = " ";
	}else
		$prof = $_POST["profesion"];
	$core->bind('nombre', $_POST['nombre']);
	$core->bind('profesion', $prof);
	$core->bind('apellidos', $_POST['apellidos']);
	$core->bind('cargo', $_POST['cargo']);
	$core->bind('institucion', $_POST['institucion']);
	$core->bind('pais', $_POST['pais']);
	$core->bind('mail', $_POST['mail']);
	$core->bind('pasaporte', $_POST['pasaporte']);
	
	if($_POST['id']!=''){
		$core->bind('id', $_POST['id']);	
		$sql = $core->query("UPDATE personas_trabajos_libres SET nombre=:nombre, profesion=:profesion, apellidos=:apellidos, cargos=:cargo, institucion=:institucion, pais=:pais, mail=:mail, pasaporte=:pasaporte WHERE ID_Personas=:id");
		$id = $_POST['id'];
	}else
	{
		$sql = $core->query("INSERT INTO personas_trabajos_libres (nombre, profesion, apellidos, cargos, institucion, pais, mail, pasaporte) VALUES (:nombre, :profesion, :apellidos, :cargo, :institucion, :pais, :mail, :pasaporte)");
		$id = $core->getLastID();
	}
	if($sql)
		header('Location: /?page=personasTL&status=ok');
	else
		header('Location: /?page=personasTL&status=error');
}
?>