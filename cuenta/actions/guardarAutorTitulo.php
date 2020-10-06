<?php
if($_POST["j"]!=1 || empty(trim($_POST["author_title"])) || empty(trim($_POST["id_trabajo"])) || empty(trim($_POST["id_coordinador"]))){
	die();
}
header('Content-Type: application/json');
require("../../opc/codebase/config.php");
require("../../init.php");
require("../class/cuenta.class.php");
$cuenta = new Cuenta();
if($cuenta->setAutorTitulo())
	echo json_encode("ok");
else
	echo json_encode("error");
