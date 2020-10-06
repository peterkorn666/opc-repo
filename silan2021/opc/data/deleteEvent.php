<?php
$id = $_POST["eventID"];
if($id=="")
	die();
	
require("../codebase/config.php");
$sql = $res->prepare("DELETE FROM crono_conferencistas WHERE id_crono=?");
$sql->bindValue(1,$id);
$sql->execute();

$sqlT = $res->prepare("UPDATE trabajos_libres SET id_crono=0 WHERE id_crono=?");
$sqlT->bindValue(1,$id);
$sqlT->execute();
echo $id;
?>