<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
if($_SESSION["pasos"]!=1){
	header("Location: login.php");
}
$_SESSION["pasos"]=2;
include('../conexion.php');
$pass =0;
$sql = "SELECT * FROM claves WHERE usuario = '".$_POST["txtUsuario"]."' AND clave = '".$_POST["txtPassword"]."';";
$rs = $con->query($sql);
if($row = $rs->fetch_array()){
	$pass=1;
	$_SESSION["LogIn"] = "ok";
	$_SESSION["usuario"] = $_POST["txtUsuario"];
	header("Location: listado.php");
}
if($pass==0){	
	header ("Location:login.php?error=true");
}
?>