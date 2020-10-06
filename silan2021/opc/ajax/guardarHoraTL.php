<?php
if($_POST["hora_inicio"]!="" && $_POST["hora_fin"]!="" && $_POST["id_tl"]!=""){
	require_once("../class/core.php");
	$core = new Core();
	$sql = $res->prepare("UPDATE trabajos_libres SET Hora_inicio=?, Hora_fin=? WHERE id_trabajo=?");
	$sql->bindValue(1,$_POST["hora_inicio"].":00");
	$sql->bindValue(2,$_POST["hora_fin"].":00");
	$sql->bindValue(3,$_POST["id_tl"]);
	$sql->execute() or die(var_dump($db->errorInfo()));
	echo 1;
	die();
}
echo 0;
?>