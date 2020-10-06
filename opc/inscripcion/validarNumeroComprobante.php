<?php
if(empty(trim($_POST["num"])))
{
	die(json_encode(array('code'=>'3')));
}
require("../init.php");
$db = \DB::getInstance();

//$cuenta = $db->get("cuentas", ["numero_comprobante", "=", $_POST["num"]])->first();
$inscripto = $db->get("inscriptos", array("numero_comprobante", "=", $_POST["num"]))->first();


if(count($inscripto)>0){
	//$inscripcion = $db->get("inscriptos", ["id_cuenta", "=", $cuenta["id"]])->first();
	echo json_encode(array('code'=>'1', 'key_inscripto' => $inscripto["id"], 'nombre_inscripto' => $inscripto["nombre"]." ".$inscripto["apellido"], 'fp' => $inscripto["forma_pago"]));
}else
{
	echo json_encode(array('code'=>'2'));
}

