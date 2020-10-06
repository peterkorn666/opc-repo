<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}

include('conexion.php');

include("inc/validarVistas.inc.php");

$_SESSION["trabajo"] = $_POST["trabajo"];  //ARRAY benditosssssssssssssssssssssssssss............

$_SESSION["numero_de_envio"] = 0;

$_SESSION["total_de_envio"] = count($_POST["trabajo"]);

$_SESSION["asunto0"] = $_POST["asunto0"];

$_SESSION["asunto1"] = $_POST["asunto1"];

$_SESSION["carta"] = nl2br($_POST["carta"]);

$_SESSION["mailAotro"] = $_POST["mailAotro"];
/*if($_FILES["archivo"]["tmp_name"]!=""){
	copy($_FILES["archivo"]["tmp_name"], "/home/httpd/vhosts/slap2007.org.uy/httpdocs/programa/arhivosMails/" . $_FILES["archivo"]["name"]);
}*/
if($_FILES["archivo"]["tmp_name"]!=""){
	$path = "../archivos_mails/";
	$nombre_archivo = str_replace(" ", "_", $_FILES["archivo"]["name"]);
	if(file_exists($path.$nombre_archivo)){
		@unlink($path.$nombre_archivo);
	}
	copy($_FILES["archivo"]["tmp_name"], $path.$nombre_archivo);
}

$_SESSION["archivoNombre"] = $nombre_archivo;

$_SESSION["A_otro"] = $_POST["A_otro"];

$_SESSION["A_contacto"] = $_POST["A_contacto"];


$_SESSION["chkMostrarUbicacion"] = $_POST["chkMostrarUbicacion"];

$_SESSION["chkMostrarTrabajo"] = $_POST["chkMostrarTrabajo"];

///CARTA
$_SESSION["rbCarta"] =$_POST["rbCarta"];
/////


$_SESSION["INSTRUCCIONES"] = $_POST["INSTRUCCIONES"];
$_SESSION["TALLERES"] = $_POST["TALLERES"];
$_SESSION["DIAPOSITIVA"] = $_POST["DIAPOSITIVA"];
$_SESSION["HOTEL_IMG"] = $_POST["HOTEL_IMG"];
?>
<style>
#divEnvios{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	padding: 10px;

}

</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0E6F0">
	<div id="divEnvios"></div>
    <iframe name="frameEnvio" style="display:none;"></iframe>
  </tr>
</table>
<form action="envioMail_trabajosLibres_send_frame.php" method="post" enctype="multipart/form-data" name="form1" target="frameEnvio">
</form>
<script>
	form1.submit();
</script>