<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}

$_SESSION["registrado"] = false;
session_destroy();
header ("Location:login.php");
?>