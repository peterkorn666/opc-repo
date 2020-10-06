<?php
if(!isset($_GET["key"]) || $_GET["key"]==''){
	header("Location: beta-alas2017.easyplanners.info/");
	die;
}
require("init.php");
require("clases/Config.class.php");
require("clases/DB.class.php");
require("clases/lang.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$config = $inscripcion->getConfig();
$db = \DB::getInstance();
$recibos = $inscripcion->getRecibos($_GET["key"]);

echo '<div align="center" class="col-xs-6 col-lg-offset-2 col-md-6 col-lg-7"><img src="logo.png"></div>';
echo '<div style="clear:both"></div><br><br>';



if ($recibos==array() || $recibos=="") {
	echo '<div align="center" class="col-xs-6 col-lg-offset-4 col-md-6 col-lg-7">';
	echo '<div class="col-xs-6 col-lg-offset-0 col-md-6 col-lg-6 alert-danger alert" style="max-width:530"><strong>Usted no tiene aún ningun recibo disponible.<br> Se le avisara a la brevedad via email cuando pueda verlos.</strong></div>';
	echo '</div>';
}
else {
	echo '<div align="center" class="col-xs-6 col-lg-offset-4 col-md-6 col-lg-3 alert-success" style="max-width:800;">';
	echo "<strong>Puede ver sus recibos a continuaci&oacute;n:</strong><br>";
	foreach($recibos as $recibo) {
?>
		<div><a href="recibo/recibo.php?k=<?php echo base64_encode($recibo["id"]); ?>" target="blank" style="color:black;">Recibo Nº <?php echo $recibo["numero_recibo"]; ?></a></div>
<?php
	}
	
	echo '</div>';
}


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Recibos</title>
<link type="text/css" href="css/boostrap.css" rel="stylesheet">
</head>
<body>
</body>
</html>