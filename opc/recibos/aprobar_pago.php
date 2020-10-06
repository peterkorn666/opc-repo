<?php
if(!isset($_GET["key"]) || $_GET["key"]==''){
	header("Location: login.php");
	die;
}
require("../init.php");
require("clases/Config.class.php");
require("clases/DB.class.php");
require("clases/lang.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$lang = new Language("es");
$config = $inscripcion->getConfig();
$db = \DB::getInstance();

$result = $db->query("SELECT id, email FROM inscriptos WHERE MD5(CONCAT(id, email)) = ?", $_GET["key"]);

if(count($result) > 0){
	if($result["id"]){
		if($_GET["estado"] === '1'){
			$db->insert("inscriptos_recibos_pagos", array("id_inscripto" => $result["id"]));
		}else if($_GET["estado"] === '0'){
			$db->delete("inscriptos_recibos_pagos", array("id_inscripto", '=', $result["id"]));
		}
	}
}

//header("Location: form_recibo.php?key=".$_GET["key"]);
header("Location: form_recibo.php?key=".$_GET["key"]."&pago=".$_GET["estado"]."");