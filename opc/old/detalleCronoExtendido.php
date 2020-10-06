<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script src="js/menuEdicion.js"></script>
<script src="js/trabajos_libres.js"></script>
</head>

<body><?
include('inc/sesion.inc.php');
include('conexion.php');
include("inc/validarVistas.inc.php");

require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;

$sePuedeImprimir=true;
$imprimir = "";

$tit_act_sin_hora = "Actividad sin horarios";
 
function remplazar($cual){
		  	
	return  utf8_encode($cual);
	
}

if($_POST["casillero"]!=""){
	$sql = "SELECT * FROM congreso where Casillero='" . $_POST["casillero"] . "' ORDER by Casillero, Orden_aparicion ASC";
	//$sql = "SELECT * FROM congreso where Casillero='" . $_GET["casillero"] . "'and Dia='" . $dia_ . "' and Sala='" . $sala_ . "' ORDER by Casillero, Orden_aparicion ASC";
}
/*else{
	$sql = "SELECT * FROM congreso where Dia='" . $dia_ . "' and Sala='" . $sala_ . "' ORDER by Casillero, Orden_aparicion ASC";
}*/
$rs = mysql_query($sql,$con);


while ($row = mysql_fetch_array($rs)){

	
	require("inc/programaCrono.inc.php");
}


?>
</body>
</html>
