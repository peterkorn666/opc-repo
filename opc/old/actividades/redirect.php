<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
$_SESSION["LogIn"] = "ok";
header("Location: listado.php");
?>