<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
	header("Location: login.php");
}
if ($_SESSION["registrado"]==false){
	header ("Location: login.php");
}
?>