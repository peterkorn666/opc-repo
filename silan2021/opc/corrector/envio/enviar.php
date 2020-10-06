<?php
session_start();
if(empty($_SESSION["envio_mail"]) || ($_SESSION["envio_mail"]["habilitado"] !== true)){
    header("Location: index.php");
    die();
}

header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include("../../../init.php");
include("../clases/Auxiliar.php");
include("clases/class.smtp.php");
include("clases/phpmailer.class.php");

$auxiliar_instancia = new Auxiliar();
$config = $auxiliar_instancia->getConfig();

$mailOBJ = new phpmailer();

$mailOBJ->From          = $config["email_username"];
$mailOBJ->FromName      = $config["nombre_congreso"];
$mailOBJ->Timeout       =120;
$mailOBJ->Port          = 25;
$mailOBJ->IsHTML(true);

$mailOBJ->IsSMTP();
$mailOBJ->SMTPDebug     = false;
$mailOBJ->SMTPAuth      = true;
$mailOBJ->SMTPAutoTLS   = false;

$mailOBJ->Host          = $config["email_host"];
$mailOBJ->Username      = $config["email_username"];
$mailOBJ->Password      = $config["email_password"];
$mailOBJ->addReplyTo($config["email_congreso"], 'Contacto - '.$config["nombre_congreso"]);

$status = true;
$mensaje_error = "";
foreach ($_SESSION["envio_mail"]["evaluadores"] as $evaluador){

    //Asunto
        $asunto = $_SESSION["envio_mail"]["asunto"];
        if($_SESSION["envio_mail"]["nombre_evaluador"] === true){
            $asunto .= " [".$evaluador['nombre']."]";
        }
        $mailOBJ->Subject = $asunto;

    //Cuerpo mail
        $mailOBJ->Body    = $evaluador['cuerpo_mail'];

    //Emails
        $arrayEmails = array();
        $arrayEmails[] = $config["email_respaldo"]; //Email respaldo

        //Le envio mail al evaluador
        if($_SESSION["envio_mail"]["enviar_a_seleccionados"] === true){
            $arrayEmails[] = $evaluador['email'];
        }
        //Les envio el mail a las copias
        if($_SESSION["envio_mail"]["enviar_a_email_copia"] === true){
            foreach($_SESSION["envio_mail"]["email_copia"] as $email_copia){
                $arrayEmails[] = $email_copia;
            }
        }
        $arrayEmails = array_unique($arrayEmails);

    foreach($arrayEmails as $cualMail){
        $mailOBJ->ClearAddresses();
        $mailOBJ->AddAddress($cualMail);
        //$mailOBJ->AddAttachment("adjuntos/Evaluadores.pdf");

        if(!$mailOBJ->Send()){
            var_dump($mailOBJ->ErrorInfo);
            $status = false;
            $mensaje_error .= $evaluador['id']."_";
        }
    }
}

if($status === true){
    header("Location: index.php?envio_exitoso=true");die();
} else {
    header("Location: index.php?envio_error=true&ids=".$mensaje_error);die();
}