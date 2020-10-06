<?php

if(empty($_GET["key"])){
	header("Location: index.php");
	die();
}

require("../init.php");
$db = \DB::getInstance();
$key = base64_decode($_GET["key"]);
$row = $db->query("SELECT id, id_cuenta, nombre, apellido, email, costos_inscripcion, forma_pago, numero_comprobante, grupo_check_comprobante, grupo_numero_comprobante, key_cuenta, nombre_recibo FROM inscriptos WHERE id=? ORDER BY id DESC", array($key))->first();

unset($_SESSION["cliente"], $_SESSION["inscripcion"]);

$_SESSION["inscripcion"] = $row;

$_SESSION["cliente"] = $db->get("cuentas", ["id","=", $row["id_cuenta"]])->first();

$_SESSION["inscripcion"]["pago"] = true;
header("Location: index.php");
