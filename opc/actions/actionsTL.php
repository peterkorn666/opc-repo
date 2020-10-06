<?php
session_start();
require("../class/core.php");
require("../class/util.class.php");
$util = new Util();
$util->isLogged();
if(!isset($_POST["asignar_estado"]) && !isset($_POST["asignar_tipotl"]) && !isset($_POST["asignar_area"]) && !isset($_POST["asignar_casillero"]) && !isset($_POST["id_trabajos"])){
	echo 0;
	die();
}
$core = new Core();
if(!$core->canEdit()){
	echo 0;
	die();
}


$_POST["id_trabajos"] = explode(",",$_POST["id_trabajos"]);
$where = "";
foreach($_POST["id_trabajos"] as $key => $id){
	$where .= "id_trabajo=:id_trabajo$key OR ";
	$core->bind("id_trabajo$key",$id);
}

$where = trim($where," OR ");
if($_POST["from"]=="estado"){
	$core->bind("to",$_POST["to"]);
	//echo "UPDATE trabajos_libres SET estado=:to WHERE $where";
	echo $core->query("UPDATE trabajos_libres SET estado=:to WHERE $where");
}

if($_POST["from"]=="area"){
	$core->bind("to",$_POST["to"]);
	//echo "UPDATE trabajos_libres SET estado=:to WHERE $where";
	echo $core->query("UPDATE trabajos_libres SET areas=:to WHERE $where");
}

if($_POST["from"]=="casillero"){
	$core->bind("to",$_POST["to"]);
	//echo "UPDATE trabajos_libres SET estado=:to WHERE $where";
	echo $core->query("UPDATE trabajos_libres SET id_crono=:to WHERE $where");
}

if($_POST["from"]=="modalidad"){
	$core->bind("to",$_POST["to"]);
	//echo "UPDATE trabajos_libres SET estado=:to WHERE $where";
	echo $core->query("UPDATE trabajos_libres SET tipo_tl=:to WHERE $where");
}
?>