<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 
include "conexion.php";
$f2 = date("Y-m-d");
//$_POST["id"] = $_POST["idInscripcion"];
//$_POST["fecha2"] = $f2;
//PASO VALORES A LAS VARIABLES

$_SESSION["id_staff"] = $_POST["id_staff"];
$_SESSION["nombre"] = $_POST["nombre"];
$_SESSION["apellido"] = $_POST["apellido"];
$_SESSION["telefono"] = $_POST["telefono"];
$_SESSION["email"] = $_POST["email"];
$_SESSION["pais"] = $_POST["pais"];
	
$sql = "Insert into personas_staff (nombre,apellido,telefono,email,pais,id_staff) values ('".$_SESSION["nombre"]."','".$_SESSION["apellido"]."','".$_SESSION["telefono"]."','".$_SESSION["email"]."','".$_SESSION["pais"]."','".$_SESSION["id_staff"]."')";

mysql_query($sql, $con);

echo "Se ha modificado el registro correctamente";	

?>