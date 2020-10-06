<?
set_time_limit(300000);
session_start();
/*echo "<pre>";
var_dump($_SESSION["mail"]);
die();*/
if(empty($_SESSION["mail"]["ID_Personas"][0])){
	die();
}
require("../../conexion.php");
require("class.smtp.php");
require ("class.phpmailer.php");
require "../../clases/class.Cartas.php";
include "../../envioMail_Config.php";
$cartas = new cartas();
$err = 0;
$mailOBJ = new phpmailer();

$sqlConfig = $con->query("SELECT nombre_congreso, email_congreso, email_host, email_username, email_password FROM config");
$config = $sqlConfig->fetch_assoc();

$mailOBJ->From    		= $mail_congreso;
$mailOBJ->FromName 		= $congreso;
$mailOBJ->IsHTML(true);
$mailOBJ->Timeout=120;

//
$mailOBJ->IsSMTP();
$mailOBJ->SMTPDebug  = false;
$mailOBJ->SMTPAuth   = true;
$mailOBJ->SMTPAutoTLS = false;

$mailOBJ->Host       = $config["email_host"];
$mailOBJ->Username   = $config["email_username"];
$mailOBJ->Password   = $config["email_password"];
 
$mailOBJ->Port = 25;
$mailOBJ->From = $config["email_username"];
$mailOBJ->addReplyTo($config["email_congreso"], 'Contacto - '.$config["nombre_congreso"]);



$arrayMails = "";

$nombre_conferencista = $_SESSION["mail"]["nombre_conferencista"];
$asuntoPOST = $_SESSION["mail"]["asunto"][0];
$clave = $_SESSION["mail"]["clave"][0];

$diahora = date("Y-m-d");
$asunto = utf8_decode($asuntoPOST);

$limit = 0;
$arrayMails = array();
if(!empty($_SESSION["mail"]["arrayMails"][0]))
	$arrayMails[] = $_SESSION["mail"]["arrayMails"][0];
	
if(!empty($_SESSION["mail"]["email_copia"]))
	$arrayMails[] = $_SESSION["mail"]["email_copia"];
	
//$arrayMails[] = "2018autela@gmail.com";

$mailOBJ->Subject = utf8_decode($asunto);
$mailOBJ->Body    = utf8_decode($_SESSION["mail"]["cuerpo"][0]);

$status = false;
foreach($arrayMails as $cualMail){
	$mailOBJ->ClearAddresses();
	$mailOBJ->AddAddress($cualMail);
	//$mailOBJ->AddAddress("2014ingenieria@gmail.com");
	
	//$cartas->guardarCopia($cualMail,$_SESSION["mail"]["ID_Personas"][0]);
	$mailOBJ->AddAttachment("../../adjuntos/TUTORIAL_PARA_EVALUACION_DE_TRABAJOS.pdf");
	
	if($mailOBJ->Send())
		$status = true;
	else
		var_dump($mailOBJ->ErrorInfo);
}
?>
<script type="text/javascript">
<?
	if($status){
?>
		parent.box_mail('ID: <?=$_SESSION["mail"]["ID_Personas"][0]?> Nombre: <?=$_SESSION["mail"]["nombre_evaluador"][0]?> Mail: <?=implode(";",$arrayMails)?><br>');
<?
	}else
	{
?>
		parent.box_mail('Error: <?=$_SESSION["mail"]["ID_Personas"][0]?><br>');
<?
	}
?>
</script>
<?php
if($status){
	$time = date("Y-m-d H:i");
	$sqlC = $con->query("SELECT * FROM evaluadores WHERE id=".$_SESSION["mail"]["ID_Personas"][0]);
	$rowC = $sqlC->fetch_array();
	if($rowC["fecha_mail"]==NULL)
		$sql = "UPDATE evaluadores SET fecha_mail='$time' WHERE id=".$_SESSION["mail"]["ID_Personas"][0];
	else
		$sql = "UPDATE evaluadores SET fecha_mail=CONCAT(fecha_mail,', $time') WHERE id=".$_SESSION["mail"]["ID_Personas"][0];
	$con->query($sql);
}
array_shift($_SESSION["mail"]["cuerpo"]);
array_shift($_SESSION["mail"]["ID_Personas"]);
array_shift($_SESSION["mail"]["asunto"]);
array_shift($_SESSION["mail"]["nombre_evaluador"]);
if(count($_SESSION["mail"]["arrayMails"])>0)
	array_shift($_SESSION["mail"]["arrayMails"]);

if(count($_SESSION["mail"]["ID_Personas"])>0)
{
 echo '<meta http-equiv="refresh" content="5">';
}else{
	unset($_SESSION["mail"]);
?>
<script type="text/javascript">
	parent.box_mail('Envio finalizado.');
</script>	
<?
}
?>
