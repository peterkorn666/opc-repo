<?
include('inc/sesion.inc.php');
include('conexion.php');
require "clases/class.Cartas.php";

$cartas = new cartas();

$parametros = array (
		"titulo"=>$_POST["titulo"],
		"subtitulo"=>$_POST["subtitulo"],
		"asunto"=>$_POST["asunto"],
		"destinatarios"=>$_POST["destinatarios"],
		"cuerpo"=>$_POST["cuerpoCarta"]
);


		
if (base64_decode($_POST["action"])=="m"){		
	$cartas->editarCarta($parametros, base64_decode($_POST["id"]));	
}
else {
	$cartas->persistirCarta($parametros);	
}
	
	

header("Location: altaCartaPersonalizada.php");

?>