<?php
if(empty($_POST["id"]))
	die();
require("../codebase/config.php");
$sql = $res->prepare("SELECT * FROM conferencistas WHERE id_conf=?");
$sql->bindValue(1,$_POST["id"]);
$sql->execute();
$confs = array();
$i = 0;
$row = $sql->fetch();
	$confs["id_conf"] = $row["id_conf"];
	$confs["nombre"] = $row["nombre"];
	$confs["apellido"] = $row["apellido"];
	$confs["institucion"] = $row["institucion"];
	$confs["pais"] = $row["pais"];

echo json_encode($confs);
?>