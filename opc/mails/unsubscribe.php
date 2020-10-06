<?
require "inicializar.php";
$guid=leerParametro("guid");
$email=leerParametro("email","");
$idEnvioSubscripto=0;
$idSubscripto=0;

$ip=$_SERVER["REMOTE_ADDR"];
$browser=substr($_SERVER["HTTP_USER_AGENT"],0,255);
$referer=substr($_SERVER["HTTP_REFERER"],0,255);
$fechaHora=date("Y-m-d G:i:s");

if ($guid!="") { // solicitó la baja desde un mail recibido
	if (!(strlen($guid)<LARGO_GUID)) {
		$idEnvioSubscripto=substr($guid,-(strlen($guid)-LARGO_GUID),strlen($guid)-LARGO_GUID);
		$sql = "SELECT * FROM envios_subscriptos WHERE Guid='$guid' AND IdEnvioSubscripto=$idEnvioSubscripto";
	} else {
		$sql = "SELECT * FROM envios_subscriptos WHERE Guid='$guid'";
	}

	$rsDestinatarios = mysqli_query($conexion,$sql);
	
	if ($rsDestinatarios && mysqli_num_rows($rsDestinatarios)>0) {
		$row = mysqli_fetch_array($rsDestinatarios);
		$idSubscripto=$row["IdSubscripto"];
		
		$idEvento=4; // baja confirmada
		$detalles="confirmacion baja directa";
		
		$sql= "UPDATE subscriptos SET Activo=0,FechaHoraSolicitudBaja='$fechaHora',IPSolicitudBaja='$ip',FechaHoraConfirmacionBaja='$fechaHora',IPConfirmacionBaja='$ip',EnviosPendientes='' WHERE IdSubscripto=$idSubscripto";
		mysqli_query($conexion,$sql);
		
		$sql= "INSERT INTO envios_eventos (IdEnvioSubscripto,IdEvento,FechaHora,IP,Browser,Referer,Detalles) VALUES ('$idEnvioSubscripto','$idEvento','$fechaHora','$ip','$browser','$referer','$detalles')";
		mysqli_query($conexion,$sql);
		echo "Baja confirmada.";
		//echo "Si quiere volver a subscribirse haga click aqu&iacute;";
		//dar opción de volver a registrarse con un solo link
	} else {
			echo "Mail $email no encontrado.";
		}
} else {
	if ($email!="") { // solicitó la baja indicando solamente el email, hay que pedir confirmación
		$sql = "SELECT * FROM subscriptos WHERE Email='$email'";
		
		$rsDestinatarios = mysqli_query($conexion,$sql);
		
		if ($rsDestinatarios && mysqli_num_rows($rsDestinatarios)>0) {
			$row = mysqli_fetch_array($rsDestinatarios);
			$idSubscripto=$row["IdSubscripto"];
			
			$idEvento=3; // baja solicitada
			$detalles="solicitud de baja";
			
			//enviar mail de solicitud de baja con clave ** programar retorno de esta clave
			$claveConfirmacionBaja=random(16);
			$sql= "UPDATE subscriptos SET FechaHoraSolicitudBaja='$fechaHora',IPSolicitudBaja='$ip',ClaveConfirmacionBaja='$claveConfirmacionBaja' WHERE IdSubscripto=$idSubscripto";
			mysqli_query($conexion,$sql);
			
			$sql= "INSERT INTO envios_eventos (IdEnvioSubscripto,IdEvento,FechaHora,IP,Browser,Referer,Detalles) VALUES ('$idEnvioSubscripto','$idEvento','$fechaHora','$ip','$browser','$referer','$detalles')";
			mysqli_query($conexion,$sql);
			echo "Baja solicitada, se enviar&aacute; un email a la direccio&oacute;n $email solicitando que la confirme.";
		} else {
			echo "Mail $email no encontrado.";
		}
	} else {
		echo "datos no encontrados";
	}
}

function random($randlen = 16) {
   $randval = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $random = "";
   for ($i = 1; $i <= $randlen; $i++) {
       $random .= substr($randval, rand(0,(strlen($randval) - 1)), 1);
   }
   return $random;
}

?>