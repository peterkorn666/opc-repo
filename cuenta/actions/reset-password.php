<?php
if(empty(trim($_POST["pswd-email"]))){
	header("Location: ../login.php?psw=3");
	die();
}
require("../../init.php");
require("../class/cuenta.class.php");
require("../../opc/class/class.smtp.php");
require("../../opc/class/phpmailer.class.php");
$cuenta = new Cuenta(true);
$config = $cuenta->getConfig();
$data = $cuenta->resetPassword();
if($data[2]){
	$mailOBJ = new phpmailer();
	$mailOBJ->Subject = "Nueva clave [{$data[1]['id']}] - ".$config["nombre_congreso"];	
	$body = <<<HTML
				<table width="900" border="0" align='center'>
				  <tr>
					<td align="center"><img src="{$config['banner_congreso']}" style="max-width:600px"></td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td align="center"><h2>Su nueva clave es: <b>{$data[0]}</b></h2></td>
				  </tr>
				</table>
HTML;
	$mailOBJ->Body = $body;
	$mailOBJ->CharSet = "utf-8";
	if($_SERVER["SERVER_NAME"] == "beta-alas2017.easyplanners.info"){
		$mails_congreso[] = "gegamultimedios@gmail.com";
	}else{
		$mails_congreso[] = "2017alas@gmail.com";
		$mails_congreso[] = trim($_POST["pswd-email"]);
	}
	//$mailOBJ->From    = $config['email_abstract'];
	$mailOBJ->FromName = $config["nombre_congreso"];
	$mailOBJ->IsHTML(true);
	
	$mailOBJ->Timeout=120;
	
	$mailOBJ->IsSMTP();
	$mailOBJ->SMTPDebug  = false;
	$mailOBJ->SMTPAuth   = true;
	$mailOBJ->SMTPAutoTLS = false;
	
	$mailOBJ->Host       = "mail.alas2017.easyplanners.info";
	$mailOBJ->Username   = "contacto@mail.alas2017.easyplanners.info";
	$mailOBJ->Password   = "Ujys5~61";
	 
	$mailOBJ->Port = 25;
	$mailOBJ->From = "contacto@mail.alas2017.easyplanners.info";
	$mailOBJ->addReplyTo("2017alas@gmail.com",'Contacto - ' . $config["nombre_congreso"]);
	
	foreach($mails_congreso as $cualMail){
		$mailOBJ->ClearAddresses();
		$mailOBJ->AddAddress($cualMail);
	
		if(!$mailOBJ->Send()){
			echo "<script>alert('Ocurrio un error al enviar');</script>";
		}
	}
	header("Location: ../login.php?psw=1");
	die();
}
header("Location: ../login.php?psw=3");
die();