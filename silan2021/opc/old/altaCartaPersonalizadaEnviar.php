<?
include('inc/sesion.inc.php');
include('conexion.php');
require "clases/class.Cartas.php";

$cartas = new cartas();

$tildes = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "°");
$acutes = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&ordm;");

$carta_titulo = str_replace($tildes, $acutes, $_POST["titulo"]);
$carta_asunto = str_replace($tildes, $acutes, $_POST["asunto"]);
$carta_cuerpo = str_replace($tildes, $acutes, $_POST["cuerpoCarta"]);
//var_dump($carta_cuerpo);
//die();

$parametros = array (
		"titulo"=>$carta_titulo,
		"subtitulo"=>$_POST["subtitulo"],
		"asunto"=>$carta_asunto,
		"destinatarios"=>$_POST["destinatarios"],
		"cuerpo"=>$carta_cuerpo
);


		
if (base64_decode($_POST["action"])=="m"){		
	$cartas->editarCarta($parametros, base64_decode($_POST["id"]));	
}
else {
	$cartas->persistirCarta($parametros);	
}
	
	

header("Location: altaCartaPersonalizada.php");

?>