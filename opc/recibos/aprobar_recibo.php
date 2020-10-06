<?php
if(!isset($_GET["key"]) || $_GET["key"]=='' || !isset($_GET["rec"]) || $_GET["rec"]==''){
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
$db = \DB::getInstance();
$categorias = $lang->set["COSTOS_INSCRIPCION"]["array"];

$inscripto = $db->query("SELECT id, email, costos_inscripcion FROM inscriptos WHERE MD5(CONCAT(id, email)) = ?", [$_GET["key"]])->first();
if(count($inscripto) == 0){
	die("No se encuentra inscripto del recibo.");
}

$recibo = $inscripcion->getRecibo(base64_decode($_GET["rec"]));
//var_dump($inscripto, $recibo);
//die();
if($recibo && $inscripto){
	
	if($recibo["id_inscripto"] !== $inscripto["id"]){
		header("Location: login.php"); die();
	}
	
	if($_GET["estado"] === '1'){ //estado actual = 1 --> lo seteo a 0
		$db->update("inscriptos_recibo", "id=".$recibo["id"], array("pago" => 0));
		$estado_actual = 0;
	}else if($_GET["estado"] === '0'){ //estado actual = 0 --> lo seteo a 1
		$db->update("inscriptos_recibo", "id=".$recibo["id"], array("pago" => 1));
		$estado_actual = 1;
	}
	
	$monto_pago_inscripto = $inscripcion->getMontoInscripto($inscripto["id"]);
	$a_pagar_inscripto = $lang->getValue($categorias[$inscripto["costos_inscripcion"]], 1);
	
	if($monto_pago_inscripto >= $a_pagar_inscripto){
		$estado_pago = 1;
	}else{
		$estado_pago = 0;
	}
	$saldo_total = round($monto_pago_inscripto-$a_pagar_inscripto, 2);
	
	$result = $db->update("inscriptos", "id=".$inscripto["id"], array("estado" => $estado_pago));

	$esta_pago = $inscripcion->estaPago($inscripto["id"]);
	
	if(!$esta_pago && $estado_pago === 1){
		$db->insert("inscriptos_recibos_pagos", array("id_inscripto" => $inscripto["id"]));
	}else if($esta_pago && $estado_pago === 0){
		$db->delete("inscriptos_recibos_pagos", array("id_inscripto", '=', $inscripto["id"]));
	}
}

if($_GET["update"])
	header("Location: form_recibo.php?key=".$_GET["key"]."&success=1");
else
	header("Location: form_recibo.php?key=".$_GET["key"]."&pago=".$estado_actual."");