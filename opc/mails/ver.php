<?
require "inicializar.php";
$guid=leerParametro("guid");
$m=leerParametro("m","");

$cuerpoHTML="";
if (is_numeric($m)) {
	$sql = "SELECT * FROM mails WHERE IdMail=$m";	
	$rsMails = mysqli_query($conexion,$sql);

	if ($rsMails && mysqli_num_rows($rsMails)>0) {
		$row = mysqli_fetch_array($rsMails);
		$cuerpoHTML=$row["CuerpoHTML"];
		$asunto=$row["Asunto"];
	}
	
	if ($guid!="") {
		if (!strlen($guid)<LARGO_GUID) {
			$idEnvioSubscripto=substr($guid,-(strlen($guid)-LARGO_GUID),strlen($guid)-LARGO_GUID);
			$sql = "SELECT * FROM envios_subscriptos WHERE Guid='$guid' AND IdEnvioSubscripto=$idEnvioSubscripto";
		} else {
			$sql = "SELECT * FROM envios_subscriptos WHERE Guid='$guid'";
		}
		$rsDestinatarios = mysqli_query($conexion,$sql);
		
		if ($rsDestinatarios && mysqli_num_rows($rsDestinatarios)>0) {
			$row = mysqli_fetch_array($rsDestinatarios);
			$idEnvioSubscripto=$row["IdEnvioSubscripto"];
			$idEvento=3; // ver mail
			$ip=$_SERVER["REMOTE_ADDR"];
			$browser=substr($_SERVER["HTTP_USER_AGENT"],0,255);
			$referer=substr($_SERVER["HTTP_REFERER"],0,255);
			$detalles=$m;
			$fechaHora=date("Y-m-d G:i:s");
			$sql= "INSERT INTO envios_eventos (IdEnvioSubscripto,IdEvento,FechaHora,IP,Browser,Referer,Detalles) VALUES ('$idEnvioSubscripto','$idEvento','$fechaHora','$ip','$browser','$referer','$detalles')";
			mysqli_query($conexion,$sql);
		}
		
		//personaliza links
		if ($cuerpoHTML!="") {		
			$sql = "SELECT * FROM mails_links WHERE IdMail=$m";
			$rsMailLinks = mysqli_query($conexion,$sql);
			if ($rsMailLinks) {	
				$cuerpoHTML=reemplazarLinks($cuerpoHTML,$rsMailLinks,$guid);
			}
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?echo $asunto;?></title>
</head>

<body style="margin: 0; padding: 0;">
<?

if ($cuerpoHTML=="") {
	echo "Mensaje no encontrado";
} else {
	echo $cuerpoHTML;
}

?>
</body>
</html>
<?

function reemplazarLinks($cuerpoHTML,$rsMailLinks,$guid){
	//personalizacion
	//links
	$linksReemplazar=-1;
	$linksOriginal=array();
	$linksNuevo=array();
	if ($rsMailLinks && mysqli_num_rows($rsMailLinks)>0 && mysqli_data_seek ($rsMailLinks,0)) {
		while ($row = mysqli_fetch_array($rsMailLinks)){
			//hay que terminar la url con una comilla o espacio para evitar que reemplace la url en imagenes
			//por ejemplo url=http://www.midominio.com e imagen=http://www.midominio.com/imagenes/img.gif
			$linksReemplazar++;
			$linksOriginal[$linksReemplazar]=$row["Url"] . "\"";
			$linksNuevo[$linksReemplazar]=URL_ABSOLUTA . "link.php?guid=3D" . $guid ."&l=3D" . $row["IdMailLink"] . "\"";

			$linksReemplazar++;
			$linksOriginal[$linksReemplazar]=$row["Url"] . "'";
			$linksNuevo[$linksReemplazar]=URL_ABSOLUTA . "link.php?guid=3D" . $guid ."&l=3D" . $row["IdMailLink"] . "'";

			$linksReemplazar++;
			$linksOriginal[$linksReemplazar]=$row["Url"] . " ";
			$linksNuevo[$linksReemplazar]=URL_ABSOLUTA . "link.php?guid=3D" . $guid ."&l=3D" . $row["IdMailLink"] . " ";
		}
		mysqli_data_seek($rsMailLinks, 0);
	}
	return str_replace($linksOriginal,$linksNuevo,$cuerpoHTML);
}

?>