<?
include('inc/sesion.inc.php');
include('conexion.php');

$verCurriculums = $_POST["verCurriculums"];
$verMails = $_POST["verMails"];
$altoCrono = $_POST["altoCrono"];
$altoCronoImp = $_POST["altoCronoImp"];
$verTL= $_POST["verTL"];
$nombre_congreso = $_POST["nombre_congreso"];
$mail_contacto = $_POST["mail_contacto"];

$orden_tl = $_POST["ordenTL_"];


if($verCurriculums!=1){
$verCurriculums=0;
}
if($verMails!=1){
$verMails=0;
}
if($verTL!=1){
$verTL=0;
}

//$sql = "UPDATE config SET VerCurriculums = '$verCurriculums', VerTL = '$verTL', VerMails = '$verMails', AltoDeCrono = '$altoCrono',  AltoDeCronoImp = '$altoCronoImp', nombre_congreso = '$nombre_congreso', mail_contacto = '$mail_contacto', ordenTL='$orden_tl';";
$sql = "UPDATE config SET AltoDeCrono = '$altoCrono',  AltoDeCronoImp = '$altoCronoImp';";
mysql_query($sql, $con) or die(mysql_error());
?>
<script>
	window.close()
</script>