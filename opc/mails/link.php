<?php
require "inicializar.php";
$guid=leerParametro("guid");
$link=leerParametro("l","");
$url="";
$nombre="";
$email="";

if ($guid!="" && is_numeric($link)) {
	if (!strlen($guid)<LARGO_GUID) {
		$idEnvioSubscripto=substr($guid,-(strlen($guid)-LARGO_GUID),strlen($guid)-LARGO_GUID);
		$sql = "SELECT * FROM envios_subscriptos WHERE Guid='$guid' AND IdEnvioSubscripto=$idEnvioSubscripto";
	} else {
		$sql = "SELECT * FROM envios_subscriptos WHERE Guid='$guid'";
	}
	$rsDestinatarios = mysqli_query($conexion, $sql) or die(mysqli_error());
	
	$sql = "SELECT * FROM mails_links WHERE IdMailLink=$link";	
	$rsLinks = mysqli_query($conexion,$sql) or die(mysqli_error());

	if ($rsLinks && mysqli_num_rows($rsLinks)>0) {
		$row = mysqli_fetch_array($rsLinks);
		$url=$row["Url"];
		$nombre=$row["Nombre"];
	}
	if ($rsDestinatarios && mysqli_num_rows($rsDestinatarios)>0) {
		$row = mysqli_fetch_array($rsDestinatarios);
		$email=$row["Email"];
		$idEnvioSubscripto=$row["IdEnvioSubscripto"];
		$idEvento=2; // link
		$ip=$_SERVER["REMOTE_ADDR"];
		$browser=substr($_SERVER["HTTP_USER_AGENT"],0,255);
		$referer=substr($_SERVER["HTTP_REFERER"],0,255);
		$detalles="$link";
		$fechaHora=date("Y-m-d G:i:s");
		$sql= "INSERT INTO envios_eventos (IdEnvioSubscripto,IdEvento,FechaHora,IP,Browser,Referer,Detalles) VALUES ('$idEnvioSubscripto','$idEvento','$fechaHora','$ip','$browser','$referer','$detalles')";
		mysqli_query($conexion,$sql) or die(mysqli_error());
	}	
	
		$arrBuscarTextos=array(REEMPLAZO_BUSCAR_PREFIJO . "REPLYTO" . REEMPLAZO_BUSCAR_SUFIJO,REEMPLAZO_BUSCAR_PREFIJO . "GUID" . REEMPLAZO_BUSCAR_SUFIJO,REEMPLAZO_BUSCAR_PREFIJO . "EMAIL" . REEMPLAZO_BUSCAR_SUFIJO);
		$arrReemplazarPor=array(REPLYTO_EMAIL,$guid,$email);

		$url=str_replace($arrBuscarTextos,$arrReemplazarPor,$url);
	
	
}
if ($url=="") {
	echo "URL de destino no encontrada.";
} else {
	header("Location: $url"); 
}
?>