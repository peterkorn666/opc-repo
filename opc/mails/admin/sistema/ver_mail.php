<?
require "inicializar.php";
controlarAcceso($sistema,2);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?
$idMail=leerParametro("idMail","");
$idEnvio=leerParametro("idEnvio","");

$accion=leerParametro("accion","ver");

switch($accion) {

	case "ver":
		if ($idMail!="") {
			$sql = "SELECT mails.* FROM mails WHERE IdMail=$idMail;";
			$sistema->database->ejecutarSentenciaSQL($sql);
			$rsMail = $sistema->database->rs;
			if ($rsMail) {			
				// prepara el mail
				$row = mysqli_fetch_array($rsMail);
				echo $row["CuerpoHTML"];
            }
        }
		if ($idEnvio!="") {
			$sql = "SELECT mails.* FROM mails left join envios ON mails.IdMail=envios.IdMail WHERE IdEnvio=$idEnvio;";
			$sistema->database->ejecutarSentenciaSQL($sql);
			$rsMail = $sistema->database->rs;
			if ($rsMail) {			
				// prepara el mail
				$row = mysqli_fetch_array($rsMail);
				echo $row["CuerpoHTML"];
            }
        }
		break;
}

?>
</body>
</html>
