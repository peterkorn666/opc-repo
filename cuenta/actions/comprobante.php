<?php
if((empty(trim($_POST["numero_comprobante"])) && isset($_POST["numero_comprobante"])) || $_FILES["comprobante_pago"]==NULL)
{
	header("Location: ../cuenta.php?ce=1");
	die();
}

require("../../init.php");
require("../class/cuenta.class.php");
require("../../opc/class/class.smtp.php");
require("../../opc/class/phpmailer.class.php");
$cuenta = new Cuenta();
$datos = $cuenta->getCuenta();

if(!Cuenta::isLogged())
{
	header("Location: ../login.php");
	die();
}
$inscripto = $cuenta->getInscripto();
$config = $cuenta->getConfig();
$mailOBJ = new PHPMailer();

if(!isset($_POST["numero_comprobante"])){
	$_POST["numero_comprobante"] = ($inscripto["grupo_numero_comprobante"]?$inscripto["grupo_numero_comprobante"]:$datos["numero_comprobante"]);
}

//validar comprobante solo si lo paga la institucion u otra persona
if($inscripto["grupo_check_comprobante"]){
	$result_comprobante = $cuenta->validarComprobanteInsPersona($_POST["numero_comprobante"]);
	if(count($result_comprobante)==0){
		header("Location: ../cuenta.php?d=ne");
		die();
	}
}

$html = "
<div align='center'><img src='{$config['banner_congreso']}'></div>
<h2 align='center'>Su comprobante no se ha podido cargar correctamente intente nuevamente.</h2>";


if($_SERVER["SERVER_NAME"] == "beta-alas2017.easyplanners.info"){
	$arrayMails[] = "gegamultimedios@gmail.com";
}else{
	$arrayMails[] = "2017alas@gmail.com";
	$arrayMails[] = "register@easyplanners.com";
	if(!$_SESSION['admin'])
		$arrayMails[] = $datos['email'];
}
	
//print_r($arrayMails);
$mailOBJ->IsSMTP();
$mailOBJ->SMTPDebug  = false;
$mailOBJ->SMTPAuth   = true;
$mailOBJ->SMTPAutoTLS = false;

$mailOBJ->Host       = "mail.alas2017.easyplanners.info";
$mailOBJ->Username   = "contacto@mail.alas2017.easyplanners.info";
$mailOBJ->Password   = "Ujys5~61";
 
$mailOBJ->Port = 25;
$mailOBJ->From = "contacto@mail.alas2017.easyplanners.info";
$mailOBJ->addReplyTo("2017alas@gmail.com",'Contacto - ALAS 2017');

//$mailOBJ->From = "2017alas@gmail.com";
$mailOBJ->FromName = "ALAS 2017";

$mailOBJ->Subject = sprintf("Comprobante C_%s - ALAS 2017", str_pad($_SESSION['cliente']['id_cliente'], 4, 0, STR_PAD_LEFT));

$mailOBJ->IsHTML(true);	
$mailOBJ->Timeout=120;
$mailOBJ->ClearAttachments();
$mailOBJ->ClearBCCs();
if (isset($_FILES['comprobante_pago']) && $_FILES['comprobante_pago']['error'] == UPLOAD_ERR_OK) {
	if($datos['comprobante'])
		@unlink('../comprobantes/'.$datos['comprobante']);
	$nombre = $cuenta->guardarArchivo($_FILES['comprobante_pago'], '../comprobantes/', $datos["id"].'_'.urlencode($datos["nombre"]));
	if($nombre){
		$html = "
			<div align='center'><img src='{$config['banner_congreso']}'></div>
			<h2 align='center'>
			N&deg; comprobante: {$_POST["numero_comprobante"]}<br><br>
			<a href='{$config['url_base']}cuenta/comprobantes/index.php?file={$nombre}'>Verifique su comprobante haciendo click aqu&iacute;</a></h2>";
				try{
					$cuenta->setComprobante($_POST["numero_comprobante"], $nombre);
				}catch(Exception $e){
					if($e->errorInfo[0]==23000){
						header("location: ../cuenta.php?d=nc");
						die;
					}
				}
	}    
}

$mailOBJ->Body = $html;
foreach($arrayMails as $cualMail){  
	$mailOBJ->ClearAddresses();
	$mailOBJ->AddAddress($cualMail);
	$mailOBJ->Send();
}

header("Location: ../cuenta.php?ce=f");

