<?php

if(empty(trim($_POST["apellido"])) || empty(trim($_POST["nombre"])) || empty(trim($_POST["email"])) || empty(trim($_POST["asunto"])) || empty(trim($_POST["mensaje"])))
{
	header("Location: ../contacto.php?empty=1");
	die();
}

require("../../init.php");
require("../class/login.class.php");
require("../../opc/class/phpmailer.class.php");
$login = new Login();
$mailOBJ = new PHPMailer();

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$email = $_POST["email"];
$asunto = $_POST["asunto"];
$mensaje = $_POST["mensaje"];

$login->guardarContacto();

$html = "
	Apellido: <strong>$apellido</strong><br>
	Nombre: <strong>$nombre</strong><br>
	Email: <strong>$email</strong><br>
	Asunto: <strong>$asunto</strong><br>
	Mensaje: <br><br>
	".nl2br($mensaje)."
	
<p style='color:white'>contactabstrct</p>
";
if($_SERVER["SERVER_NAME"] == "beta-alas2017.easyplanners.info"){
	$arrayMails[] = "gegamultimedios@gmail.com";
}else{
	$arrayMails[] = "2017alas@gmail.com";
}
	
//print_r($arrayMails);
$mailOBJ->From = "2017alas@gmail.com";
$mailOBJ->FromName = "Contacto - ALAS 2017";

$mailOBJ->Subject = $apellido." Contacto - ALAS 2017";

$mailOBJ->IsHTML(true);	
$mailOBJ->Timeout=120;
$mailOBJ->ClearAttachments();
$mailOBJ->ClearBCCs();
$mailOBJ->Body = $html;

if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
	$nombre_archivo = explode(".",$_FILES['archivo']['name']);
	$extension = end($nombre_archivo);
	$nombre_archivo = $nombre_archivo[0];
	if(file_exists("../contacto/".$nombre_archivo.".".$extension))
		$nombre_archivo .= rand(1000,5000);
	if (move_uploaded_file($_FILES['archivo']['tmp_name'], "../contacto/".$nombre_archivo.".".$extension)) {
		$mailOBJ->AddAttachment("../contacto/".$nombre_archivo.".".$extension, $_FILES['archivo']['name']);
	}    
}


foreach($arrayMails as $cualMail){  
	$mailOBJ->ClearAddresses();
	$mailOBJ->AddAddress($cualMail);
	$mailOBJ->Send();
}

header("Location: ../contacto.php?success=1");

