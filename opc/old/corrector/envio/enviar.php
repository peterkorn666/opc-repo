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

$mailOBJ->From    		= $mail_congreso;
$mailOBJ->FromName 		= $congreso;
$mailOBJ->IsHTML(true);
$mailOBJ->Timeout=120;

//
$mailOBJ->IsSMTP();
$mailOBJ->SMTPDebug  = false;
$mailOBJ->SMTPAuth   = true;
$mailOBJ->SMTPAutoTLS = false;

$mailOBJ->Host       = "mail.pediatria2017.gegamultimedios.net";
$mailOBJ->Username   = "contacto@pediatria2017.gegamultimedios.net";
$mailOBJ->Password   = "vYjd8&36";
 
$mailOBJ->Port = 25;
$mailOBJ->From = "contacto@pediatria2017.gegamultimedios.net";
$mailOBJ->addReplyTo("pediatria2017sup@gmail.com", 'Contacto - Pediatria 2017');



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
	
$arrayMails[] = "pediatria2017sup@gmail.com";

$mailOBJ->Subject = $asunto;
$mailOBJ->Body    = $_SESSION["mail"]["cuerpo"][0];

$status = false;
foreach($arrayMails as $cualMail){
	$mailOBJ->ClearAddresses();
	$mailOBJ->AddAddress($cualMail);
	//$mailOBJ->AddAddress("2014ingenieria@gmail.com");
	
	//$cartas->guardarCopia($cualMail,$_SESSION["mail"]["ID_Personas"][0]);
	$mailOBJ->AddAttachment("adjuntos/Evaluadores.pdf");
	
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
	$sqlC = mysql_query("SELECT * FROM evaluadores WHERE id=".$_SESSION["mail"]["ID_Personas"][0],$con);
	$rowC = mysql_fetch_array($sqlC);
	if($rowC["fecha_mail"]==NULL)
		$sql = "UPDATE evaluadores SET fecha_mail='$time' WHERE id=".$_SESSION["mail"]["ID_Personas"][0];
	else
		$sql = "UPDATE evaluadores SET fecha_mail=CONCAT(fecha_mail,', $time') WHERE id=".$_SESSION["mail"]["ID_Personas"][0];
	mysql_query($sql,$con) or die(mysql_error());
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
