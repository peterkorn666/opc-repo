<?php
require("init.php");
require("clases/Config.class.php");
require("clases/DB.class.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$config = $inscripcion->getConfig();
$db = \DB::getInstance();
if ($_SESSSION["recibo_inscripto"]!="") {
	var_dump($_SESSSION["recibo_inscripto"]);
	die();
	while($rec = current($_GET["key"])) {
		$indice = key($_GET["key"]); //indice del array, el cual es el id de recibo
		$id_recibo = str_pad($indice, 4, '0', STR_PAD_LEFT);
		$db->update("inscriptos_recibo", "id=".$id_recibo, array(
																"id_inscripto" => $rec["id"],
																"recibo_a" => $rec["nombre"] . " " . $rec["apellido"],
																"email" => $rec["email"],
																"pago" => $rec["estado"]
																));
		next($_GET["key"]);
		$indice = '';
		$id_recibo = '';
	}
	echo "Termino el proceso.";
}
else {
	$recibos = $inscripcion->obtenerDocRecibos();
	$_SESSION["recibos"] = $recibos;
	header('Location: http://alas2017.easyplanners.info/traer_inscripto.php');
	die();
}
?>