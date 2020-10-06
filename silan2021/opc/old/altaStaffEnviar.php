<?
include('inc/sesion.inc.php');
include('conexion.php');

$staff_ = $_POST["nombre_"];
$descripcion_ = $_POST["descripcion_"];
$tel_ = $_POST["tel_"];
$email_ = $_POST["email_"];
$contacto_ = $_POST["contacto_"];


$sql = "INSERT INTO staff (nombre,descripcion,telefono,email,contacto) VALUES ";
$sql .= "('" . $staff_ . "','" . $descripcion_ . "','" . $tel_ . "','" . $email_ . "','" . $contacto_ . "');";



mysql_query($sql, $con);

if($_POST["sola"]==1){

	echo "<script>\n";
		echo "window.opener.llenarArrayStaff('$staff_');\n";
		echo "window.opener.llenarStaff();\n";
		echo "window.opener.seleccionarStaff('$staff_');\n";
		echo "window.close();\n";
	echo "</script>\n";
	
}else{

	header ("Location:altaStaff.php");
	
}

?>