<?php
session_start();

if($_SESSION["inscripcion"]["pasos"]!=2)
{
	header("Location: index.php");
	die();
}
$_SESSION["inscripcion"]["pasos"]=3;

if(isset($_FILES) && $_FILES["comprobante_archivo"]["error"] === 0){
	$formatosValidos = array("pdf", "jpg", "jpeg", "png");
	$it = current($formatosValidos);
	$esFormatoValido = false;
	while($it && !$esFormatoValido){
		$explode_name = explode(".", $_FILES["comprobante_archivo"]["name"]);
		if (strpos(end($explode_name), $it) !== false){
			$esFormatoValido = true;
		}//var_dump($esFormatoValido);
		$it = next($formatosValidos);//var_dump($it);
	}
	//var_dump("aca");die();
	if(!$esFormatoValido){
		header("Location: index.php?error=formatoInvalido");die();
	}
}

require("../init.php");
require("clases/Db.class.php");
require("clases/lang.php");
require("clases/class.smtp.php");
require("clases/class.phpmailer.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion("previa");
$mailOBJ = new phpmailer();
$lang = new Language("es");
$db = DB::getInstance();
$config = $db->query("SELECT * FROM config LIMIT 1")->first();

/*if($_SESSION["inscripcion"]["admin"]){
	var_dump($_POST);var_dump($_FILES);die();
}*/

if(!isset($_SESSION["inscripcion"]["pago"])) {
	$datos = array(
		"numero_pasaporte"=>$_SESSION["inscripcion"]["numero_pasaporte"],
		"nombre"=>$_SESSION["inscripcion"]["nombre"],
		"apellido"=>$_SESSION["inscripcion"]["apellido"],
		//"solapero"=>$_SESSION["inscripcion"]["solapero"],
		"institucion"=>$_SESSION["inscripcion"]["institucion"],
		"profesion"=>$_SESSION["inscripcion"]["profesion"],
		"ciudad"=>$_SESSION["inscripcion"]["ciudad"],
		"pais"=>(int)$_SESSION["inscripcion"]["pais"],
		"telefono"=> $_SESSION["inscripcion"]["telefono"],
		"email"=>$_SESSION["inscripcion"]["email"],
		
		"costos_inscripcion"=>(int)$_SESSION["inscripcion"]["costos_inscripcion"],
		"codigo" => $_SESSION["inscripcion"]["codigo"],
		//"grupo_check_comprobante" => $_SESSION["inscripcion"]["grupo_check_comprobante"],
		//"grupo_numero_comprobante" => $_SESSION["inscripcion"]["grupo_numero_comprobante"],
		//"key_inscripto" => (int)$_SESSION["inscripcion"]["key_inscripto"],
		//"nombre_inscripto_pagador" => $_SESSION["inscripcion"]["nombre_inscripto_pagador"],
		"browser"=>$_SESSION["inscripcion"]["browser"]
	);
	if($_SESSION["inscripcion"]["forma_pago"] != NULL){
		$datos["forma_pago"] = (int)$_SESSION["inscripcion"]["forma_pago"];
	}else{
		$datos["forma_pago"] = NULL;
	}
		
}else{
	$datos = array(
		"costos_inscripcion"=>(int)$_SESSION["inscripcion"]["costos_inscripcion"],
		"forma_pago"=>(int)$_SESSION["inscripcion"]["forma_pago"],
		//"grupo_check_comprobante" => $_SESSION["inscripcion"]["grupo_check_comprobante"],
		//"grupo_numero_comprobante" => $_SESSION["inscripcion"]["grupo_numero_comprobante"],
		//"nombre_recibo"=>$_SESSION["inscripcion"]["nombre_recibo"]
	);
}

/*if($_SESSION["inscripcion"]["comprobante_archivo"] !== NULL)
	$datos["comprobante_archivo"] = $_SESSION["inscripcion"]["comprobante_archivo"];*/

if($_SESSION["inscripcion"]["numero_comprobante"] !== NULL)
	$datos["numero_comprobante"] = $_SESSION["inscripcion"]["numero_comprobante"];
	
if($_SESSION["inscripcion"]["admin"]){
	$datos["comentarios"] = $_SESSION["inscripcion"]["comentarios"];
	$datos["fecha_pago"] = $_SESSION["inscripcion"]["fecha_pago"];
	$datos["descuento"] = $_SESSION["inscripcion"]["descuento"];
	$datos["estado"] = (int)$_SESSION["inscripcion"]["estado"];
}
$datos["fecha_actualizado"] = date("Y-m-d H:i:s");

$insert = false;
$update = false;
if(empty($_SESSION["inscripcion"]["id"])){
	$datos["fecha"] = $datos["fecha_actualizado"];
	$sql = $db->insert("inscriptos",$datos);//var_dump($datos);var_dump("aca");die();
	$insert = true;
	$id_inscripto = str_pad($db->lastID(),4,0,STR_PAD_LEFT);
}else{
	$sql = $db->update("inscriptos","id=".$_SESSION["inscripcion"]["id"],$datos);
	$id_inscripto = $_SESSION["inscripcion"]["id"];
	$update = true;
}

$enviar_archivo = false;
if(isset($_FILES) && $_FILES["comprobante_archivo"]["error"] === 0){
	$path = 'comprobantes/';
	$nombre_archivo = $id_inscripto."_".$_FILES["comprobante_archivo"]['name'];
	$ruta_archivo = $path.$nombre_archivo;
	copy($_FILES["comprobante_archivo"]['tmp_name'], $ruta_archivo);
	$enviar_archivo = true;
	
	$sqlArchivo = $db->update("inscriptos", "id=".$id_inscripto, ["comprobante_archivo" => $nombre_archivo]);
}

/*if(count($_SESSION["inscripcion"]["input_selected_autor"])>0){
	if($sql){
		$autores_sql = $db->get("cuenta_autores", ["id_inscripto", "=", $id_inscripto])->results();
		$autores_viejos = array();
		foreach($autores_sql as $s){
			if(!in_array($s["id_autor"], $_SESSION["inscripcion"]["input_selected_autor"])){
				$db->delete("cuenta_autores", ["id","=", $s["id"]]);
			}
			$autores_viejos[] = $s["id_autor"];
		}
		
		$i = 0;		
		foreach($_SESSION["inscripcion"]["input_selected_autor"] as $id_autor){
				if(!in_array($id_autor, $autores_viejos)){
					$db->insert("cuenta_autores", ["id_autor" => $id_autor, "id_cuenta" => $_SESSION['cliente']['id_cliente'], "id_inscripto"=>$id_inscripto, "revisar"=>$_SESSION["inscripcion"]["input_revisar_autor"][$i]]);			
				}
			++$i;
		}
	}
}*/

$_SESSION["inscripcion"]["id_inscripto"] = ($_SESSION["inscripcion"]["id"]?$_SESSION["inscripcion"]["id"]:$id_inscripto);

$end = true;
/*if ($_SESSION["inscripcion"]["forma_pago"]==1 && $_SESSION["inscripcion"]["grupo_check_comprobante"]=="") {
	header("Location: ../inscriptos/form_tarjeta.php?id=".$_SESSION["inscripcion"]["id"]);
}*/
if(!isset($_SESSION["inscripcion"]["pago"]))
	require("form_mail.php");
else
	require("form_mail_pago.php");


if(!$_SESSION["inscripcion"]["admin"]){
	$arrayMails =  array($_SESSION["inscripcion"]["email"]);	
}
//$arrayMails[] = $lang->set["TXT_EMAIL_CONGRESO"]; //email respaldo
$arrayMails[] = $config["email_inscripcion"]; //email inscripcion
$arrayMails[] = $config["email_respaldo"]; //email respaldo

$arrayMails = array_unique($arrayMails);

$mailOBJ->IsSMTP();
$mailOBJ->SMTPDebug  = false;
$mailOBJ->SMTPAuth   = true;
$mailOBJ->SMTPAutoTLS = false;

$mailOBJ->Host       = $config["email_host"];
$mailOBJ->Username   = $config["email_username"];
$mailOBJ->Password   = $config["email_password"];
 
$mailOBJ->Port = 25;
//$mailOBJ->From = "contacto@alasru2018.easyplanners.info";
$mailOBJ->From = $config["email_username"];
$mailOBJ->addReplyTo($config["email_inscripcion"],'Contacto - ' . $lang->set["TXT_TITULO_CONGRESO"]);



//$mailOBJ->From = "p.ferrari@easyplanners.com";
$mailOBJ->FromName = $lang->set["TXT_TITULO_CONGRESO"];

$mailOBJ->Subject = utf8_decode($lang->set["TXT_ASUNTO_EMAIL"]." [".str_pad($_SESSION["inscripcion"]["id_inscripto"], 4, 0, STR_PAD_LEFT)."] [".$_SESSION["inscripcion"]["nombre"]." ". $_SESSION["inscripcion"]["apellido"] ."]".($_SESSION["inscripcion"]["pago"]?" [MODIFICACIÓN FORMA DE PAGO]":"").($_SESSION["inscripcion"]["admin"]?" ADMIN":""));

/*  #".$_SESSION["inscripcion"]["id_inscripto"]." */

$mailOBJ->IsHTML(true);	
$mailOBJ->Timeout=120;
$mailOBJ->ClearAttachments();
$mailOBJ->ClearBCCs();
$mailOBJ->Body  = $html;


foreach($arrayMails as $cualMail){  
	$mailOBJ->ClearAddresses();
	$mailOBJ->AddAddress($cualMail);
	if($enviar_archivo === true){
		$mailOBJ->AddAttachment($ruta_archivo);
	}
	if(!$mailOBJ->Send()){	
		if($_SESSION["inscripcion"]["email"]==""){
			echo "Su email se encuentra vacio. Usted no recibira este formulario por correo";	
		}
	}
}

	$end = true;
	//$imp = true;
	echo '<html>';
	echo '<title>'.$lang->set["TXT_TITULO_CONGRESO"].'</title>';
	echo '</html>';
	echo '<body style="background-color:white;padding:0px">';
	echo '<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="estilos.css">
	<div align="center"><img src="/imagenes/banner.jpg" style="width:100%; max-width:440px"></div>
	<div class="container">
	';
	if(!isset($_SESSION["inscripcion"]["pago"]))
		require("form_previa.php");
	require("form_pago.php");
	echo $html;
	echo "</div>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-89204362-1', 'auto');
	  ga('send', 'pageview');

	</script>
	";
	
	if($_SESSION["inscripcion"]["id_inscripto"]>0)
		unset($_SESSION["inscripcion"]);
	else
		unset($_SESSION["inscripcion"]["id_inscripto"]);
		
	/*if(file_exists("comprobantes/".$nombre_archivo))
			@unlink("comprobantes/".$nombre_archivo);*/

?>