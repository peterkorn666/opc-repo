<?php
require("../../init.php");
require("../class/login.class.php");
require("../../opc/class/phpmailer.class.php");
require("../../opc/class/class.smtp.php");
$login = new Login();
$mail = new PHPMailer();

if(empty($_POST["apellido"]) || empty($_POST["nombre"]) || empty($_POST["email"]) || empty($_POST["clave1"]) || empty($_POST["clave2"])){
	\Redirect::to('../login.php?crear=1');
	die();
}

if($_POST["clave1"]!=$_POST["clave2"]){
	\Redirect::to('../login.php?crear=2');
	die();
}

if($_POST["email"]!=$_POST["email2"]){
	\Redirect::to('../login.php?crear=4');
	die();
}
$cuenta = $login->crearCuenta();
if($cuenta)
{
	$mail->IsSMTP();
	$mail->SMTPDebug  = false;
	$mail->SMTPAuth   = true;
	$mail->SMTPAutoTLS = false;
	
	$mail->Host       = "mail.alas2017.easyplanners.info";
	$mail->Username   = "contacto@mail.alas2017.easyplanners.info";
	$mail->Password   = "Ujys5~61";
	 
	$mail->Port = 25;
	$mail->From = "contacto@mail.alas2017.easyplanners.info";
	$mail->addReplyTo("2017alas@gmail.com",'Contacto - ALAS 2017');
	
    //$mail->From = "secretaria.alas2017@cienciassociales.edu.uy";
    $mail->FromName = "ALAS 2017";

    $mail->Subject = "Nueva Cuenta - [$cuenta]".utf8_decode($_POST["nombre"]." ".$_POST["apellido"]);

    $html = "<p><img src='http://alas2017.easyplanners.info/imagenes/logo.png'></p><br>";
    $html .= "ID: <b>{$cuenta}</b><br>";
    $html .= "Apellido: <b>{$_POST["apellido"]}</b><br>";
    $html .= "Nombre: <b>{$_POST["nombre"]}</b><br>";
    $html .= "Email: <b>{$_POST["email"]}</b><br>";

    $mail->IsHTML(true);
    $mail->Timeout=120;
    $mail->ClearAttachments();
    $mail->ClearBCCs();
    $mail->Body  = $html;
	if($_SERVER["SERVER_NAME"] == "beta-alas2017.easyplanners.info"){
		$arrayMails = array("gegamultimedios@gmail.com");
	}else{
	    $arrayMails = array("2017alas@gmail.com");
	}
    foreach($arrayMails as $cualMail){
        $mail->ClearAddresses();
        $mail->AddAddress($cualMail);
        if(!$mail->Send()){
        }
    }
    \Redirect::to('../login.php?success=1');
    die();
}
\Redirect::to('../login.php?error=1');