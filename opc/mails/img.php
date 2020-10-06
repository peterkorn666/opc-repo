<?
require "inicializar.php";
$guid=leerParametro("guid");
if ($guid!="") {
	if (!strlen($guid)<LARGO_GUID) {
		$idEnvioSubscripto=substr($guid,-(strlen($guid)-LARGO_GUID),strlen($guid)-LARGO_GUID);
		$sql = "SELECT * FROM envios_subscriptos WHERE Guid='$guid' AND IdEnvioSubscripto=$idEnvioSubscripto";
	} else {
		$sql = "SELECT * FROM envios_subscriptos WHERE Guid='$guid'";
	}
	$rsDestinatarios = mysqli_query($conexion, $sql);
	
	if ($rsDestinatarios && mysqli_num_rows($rsDestinatarios)>0) {
		$row = mysqli_fetch_array($rsDestinatarios);
		$idEnvioSubscripto=$row["IdEnvioSubscripto"];
		$idEvento=1; // abrir
		$ip=$_SERVER["REMOTE_ADDR"];
		$browser=substr($_SERVER["HTTP_USER_AGENT"],0,255);
		$referer=substr($_SERVER["HTTP_REFERER"],0,255);
		$detalles="";
		$fechaHora=date("Y-m-d G:i:s");
		$sql= "INSERT INTO envios_eventos (IdEnvioSubscripto,IdEvento,FechaHora,IP,Browser,Referer,Detalles) VALUES ('$idEnvioSubscripto','$idEvento','$fechaHora','$ip','$browser','$referer','$detalles')";
		mysqli_query($conexion, $sql);
	}
}
?>