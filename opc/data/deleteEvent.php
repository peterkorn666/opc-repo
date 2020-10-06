<?php
$id = $_POST["eventID"];
if($id=="")
	die();
	
require("../codebase/config.php");
//Borro actividades
$sql = $res->prepare("DELETE FROM crono_conferencistas WHERE id_crono=?");
$sql->bindValue(1,$id);
$sql->execute();
//Borro el cronograma asociado a trabajos
$sqlTrabajos = $res->prepare("UPDATE trabajos_libres SET id_crono=0 WHERE id_crono=?");
$sqlTrabajos->bindValue(1, $id);
$sqlTrabajos->execute();

echo $id
?>