<?php
if(empty($_POST["id"]))
	die();
require("../codebase/config.php");
$sql = $res->prepare("SELECT * FROM crono_conferencistas as cc JOIN conferencistas as c ON c.id_conf=cc.id_conf WHERE cc.id_crono=?");
$sql->bindValue(1,$_POST["id"]);
$sql->execute();
$confs = array();
$i = 0;
while($row = $sql->fetch())
{
	$confs[$i]["id_conf"] = $row["id_conf"];
	$confs[$i]["id_crono"] = $row["id_crono"];
	$confs[$i]["nombre"] = $row["nombre"];
	$confs[$i]["apellido"] = $row["apellido"];
	$confs[$i]["institucion"] = $row["institucion"];
	$confs[$i]["pais"] = $row["pais"];
	$i++;
}

echo json_encode($confs);
?>