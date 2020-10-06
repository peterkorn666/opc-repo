<?php
if(!isset($_GET["key"]) || $_GET["key"]==''){
	header("Location: https://www.easyplanners.net/alas/2018/inscriptos/login.php");
	die;
}
require("../init.php");
require("clases/lang.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$lang = new Language("es");
$db = \DB::getInstance();
$inscripto = $inscripcion->getInscripto($_GET["id"]);
if(count($inscripto) == 0){
	header("Location: https://www.easyplanners.net/alas/2018/inscriptos/login.php?error=2");
	die;
}
$tl_id = $inscripcion->getTLID($inscripto["id"]);

if($_GET["estado"] == '1'){
	$db->update('inscriptos', 'id='.$_GET["id"], array("estado" => 1));
	$db->update('trabajos_libres', 'id_trabajo='.$tl_id["id_trabajo"], array("inscripto" => 1));
}else if($_GET["estado"] == '0'){
	$db->update('inscriptos', 'id='.$_GET["id"], array("estado" => 0));
	$db->update('trabajos_libres', 'id_trabajo='.$tl_id["id_trabajo"], array("inscripto" => 0));
}
header("Location: https://www.easyplanners.net/alas/2018/inscriptos/form_recibo.php?key=".$_GET["key"]);