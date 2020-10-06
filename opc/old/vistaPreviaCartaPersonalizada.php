<?
include "inc/sesion.inc.php";
include('conexion.php');
include('envioMail_Config.php');
require "clases/class.Cartas.php";
$cartas = new cartas();
$modify = $cartas->cargarUna(base64_decode($_GET["id"]));
if ($letter = mysql_fetch_array($modify)){
	$titulo = $letter["titulo"];
	$subtitulo = $letter["subtitulo"];
	$asunto = $letter["asunto"];
	$destinatarios = $letter["destinatarios"];
	$cuerpo = $letter["cuerpo"];
	$txt = "Modificar";
}

$cartaEstandar = str_replace("<:dirBanner>", $dirBanner , $cartaEstandar);
$cartaEstandar = str_replace("<:cuerpo>", $cuerpo , $cartaEstandar);
//$cartaEstandar = str_replace("<:participaciones>", $fechaParaCarta , $cartaEstandar);
echo $cartaEstandar;

?>