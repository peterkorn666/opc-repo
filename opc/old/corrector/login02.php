<?
//include "../inc/sesion.inc.php";
session_start();
if($_SESSION["pasos"]!=1){
	header("Location: login.php");
	die();
}

$_SESSION["pasos"]=2;
include('../conexion.php');
$pass =0;
$sql = "SELECT * FROM evaluadores WHERE mail = '".trim($_POST["txtUsuario"])."' AND clave = '".trim($_POST["txtPassword"])."';";
$rs = $con->query($sql);
//$rs = mysql_query($sql,$con);
if($row = $rs->fetch_array()){
	$pass=1;
	$_SESSION["registrado"] = true;
	$_SESSION["idEvaluador"] = $row["id"];
	$_SESSION["mailEvaluador"] = $row["mail"];
	$_SESSION["claveEvaluador"] = $row["clave"];
	$_SESSION["nombreEvaluador"] = $row["nombre"];
	$_SESSION["permisos"] = $row["permisos"];
	$_SESSION["nivel"] = $row["nivel"];
	$_SESSION["Login"] = "Logueado";
	header("Location:personal.php");
}
if($pass==0){	
	header ("Location:login.php?error=true");
}
?>