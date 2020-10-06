<?php
if($_POST["key"]=="")
{
	header("Location: http://www.cicat2016.org");
	die();
}
require("../../abstract/conexion.php");
$db = conectaDb();
$key = base64_decode($_POST["key"]);
//VERIFICAR QUE EL EVALUADOR EXISTE
$sqlV = $db->prepare("SELECT * FROM evaluadores WHERE id=?");
$sqlV->bindValue(1,$key);
$sqlV->execute();
if($sqlV->rowCount()>0)
{
	$sqlU = $db->prepare("UPDATE evaluadores SET acepta_evaluador=?, tematicas=? WHERE id=?");
	$sqlU->bindValue(1,$_POST["acepta_evaluador"]);
	$sqlU->bindValue(2,json_encode($_POST["tematicas"]));
	$sqlU->bindValue(3,$key);
	if($sqlU->execute())
	{
		header("Location: eval.php?status=1");
		die();
	}
	else
	{
		header("Location: eval.php?status=2");
		die();
	}
}
else
	header("Location: eval.php?status=3");

?>