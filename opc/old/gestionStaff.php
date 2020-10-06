<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];
$staff = $_GET["staff"];
$modificar = $_GET["modificar"];
$staff_ = $_POST["nombre_"];
$descripcion_ = $_POST["descripcion_"];
$tel_ = $_POST["tel_"];
$email_ = $_POST["email_"];
$contacto_ = $_POST["contacto_"];

$esPersona = $_GET["esPersona"];
	
if ($esPersona=="SI"){
	$sql = "DELETE FROM personas_staff WHERE id_persona = " . $id;
	mysql_query($sql, $con);
	header ("Location:altaStaff.php?id=".$_GET["staff"]);
}else{
	$esPersona = "";
	if ($modificar==true){
		$sql = "UPDATE staff SET nombre = '".$staff_."', descripcion = '".$descripcion_."', telefono = '".$tel_."', email = '".$email_."', contacto = '".$contacto_."' WHERE id_staff = '" . $id."';";
	}else{
		$sql = "DELETE FROM staff WHERE id_staff = " . $id;
	}
	mysql_query($sql, $con);
	header ("Location:altaStaff.php");
}	



?>
