<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 
include "conexion.php";
include "campos_config.php";
$f2 = date("Y-m-d");
$_SESSION["id_staff"] = $_POST["id_staff"];
$_SESSION["nombre"] = $_POST["nombre"];
$_SESSION["apellido"] = $_POST["apellido"];
$_SESSION["telefono"] = $_POST["telefono"];
$_SESSION["email"] = $_POST["email"];
$_SESSION["pais"] = $_POST["pais"];
$_SESSION["cargo"] = $_POST["cargo"];

if($_GET["id"]!=""){
	
	$sql = "Update personas_staff set nombre='".$_SESSION["nombre"]."',apellido='".$_SESSION["apellido"]."',telefono='".$_SESSION["telefono"]."',email='".$_SESSION["email"]."',pais='".$_SESSION["pais"]."',cargo='".$_SESSION["cargo"]."' WHERE id_persona = '".$_GET["id"]."';";
	
	mysql_query($sql, $con);

}else{
	
	$sql = "Insert into personas_staff (nombre,apellido,telefono,email,pais,cargo,id_staff) values ('".$_SESSION["nombre"]."','".$_SESSION["apellido"]."','".$_SESSION["telefono"]."','".$_SESSION["email"]."','".$_SESSION["pais"]."','".$_SESSION["cargo"]."','".$_SESSION["id_staff"]."');";
	mysql_query($sql, $con);
	
}

echo "<script>alert('Se ha modificado el registro correctamente.');</script>";

//para q recargue la pagina de "atras"
echo "<script>parent.self.location.href='http://javier/_programacientifico.info/opc_prueba/programa/altaStaff.php?id=".$_SESSION["id_staff"]."';</script>";


?>