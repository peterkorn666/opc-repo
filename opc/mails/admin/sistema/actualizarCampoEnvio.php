<?PHP
require "inicializar.php";
controlarAcceso($sistema,3);
echo "<br>comenzando";
//pone todos en :
$sql="UPDATE subscriptos SET EnviosPendientes=':',EnviosHechos=':',EnviosRebotados=':'";
$sistema->database->ejecutarSentenciaSQL($sql);

$sql="select IdSubscripto,IdEnvio,IdEstadoEnvio from envios_subscriptos order by IdSubscripto,IdEnvio,IdEstadoEnvio";
$sistema->database->obtenerRecordset($sql);
$rs=new RS($sistema->database->rs);

$idSubscripto=0;
$enviosPendientes=":";
$enviosHechos=":";
$enviosRebotados=":";

while ($row=$rs->darSiguienteFila()) {
	if ($idSubscripto!=$row["IdSubscripto"]) {
		if ($idSubscripto!=0) {
			$sistema->database->ejecutarSentenciaSQL(actualizar($enviosPendientes,$enviosHechos,$enviosRebotados,$idSubscripto));
			$enviosPendientes=":";
			$enviosHechos=":";
			$enviosRebotados=":";
		}
		$idSubscripto=$row["IdSubscripto"];
	}
	switch ($row["IdEstadoEnvio"]) {
		case 1:
			$enviosPendientes.=$row["IdEnvio"]. ":";
		break;
		case 2:
			$enviosHechos.=$row["IdEnvio"]. ":";
		break;
		case 3:
			$enviosRebotados.=$row["IdEnvio"]. ":";
		break;
	}
	
}
if ($idSubscripto!=0) {
	$sistema->database->ejecutarSentenciaSQL(actualizar($enviosPendientes,$enviosHechos,$enviosRebotados,$idSubscripto));
	$enviosHechos=":";
}

function actualizar($enviosPendientes,$enviosHechos,$enviosRebotados,$idSubscripto) {
	return "UPDATE subscriptos SET EnviosPendientes='" . $enviosPendientes . "',EnviosHechos='" . $enviosHechos . "',EnviosRebotados='" . $enviosRebotados . "' WHERE IdSubscripto=" . $idSubscripto;
}

echo "<br>listo";
?>