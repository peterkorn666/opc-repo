<?php
session_start();

if(!$_SESSION["abstract"]["paso1"]){
	if($_GET["t"]=='1')
		header("Location: trabajo.php");
	else
		header("Location: index.php");
	die();
}

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

	require("../../init.php");
	require("class/core.php");
	require("../configs/config.php");
	require("class/abstract.php");
	require("../class/class.smtp.php");
	require("../class/phpmailer.class.php");
	$db = \DB::getInstance();
	if ($_GET["t"]!=1){
		require("datos.post.php");
	}
	require("lang/".$_SESSION["abstract"]["lang"].".php");
	$pass_panel = array('area_tl', 'duracion_prevista');
	$ignore_fields = array("t", 'resumen_tl4');
	if($_SESSION["abstract"]["id_tl"]=='' && $_GET["t"]=='1'){
		\Redirect::to("index.php?error=empty&n=$name");
		die();
	}
	
    foreach($_POST as $name => $post){
        if(!is_array($post) && !in_array($name, $ignore_fields)) {
            if (empty(trim($post))) {
					\Redirect::to("index.php?error=empty&n=$name");
					die();
            }			
        }
    }
	
	foreach($_SESSION['abstract'] as $name => $session) {
        if(!is_array($session))
            $_SESSION['abstract'][$name] = trim($session);
    }

	$core = new core();
	$trabajos = new abstracts();
	$mailOBJ = new phpmailer();
    $getConfig = $core->getConfig();
    $result = $trabajos->todoTL($_GET["t"]);
	
if($result["success"]){
    $numero_de_trabajo = ($result['numero_tl'] ? $result['numero_tl'] : $_SESSION["abstract"]["numero_tl"]);
	$area_tl = $core->getAreasIdTL($_SESSION["abstract"]["area_tl"]);
	$tipo_tl = $core->getTipoTLID($_SESSION["abstract"]["tipo_tl"]);
	/*$evaluadores = array(
						6,
						7,
						8,
						9,
						10,
						11,
						12,
						13,
						14
					);
	$sqlEv = "INSERT INTO evaluaciones (idEvaluador, numero_tl, fecha_asignado) VALUES ";
	$sqlE = "";
	foreach($evaluadores as $ev){
		$sqlE .= "($ev, '$numero_de_trabajo', '".date("Y-m-d")."'), ";
	}
	$sqlE = substr($sqlE,0,-2);
	$core->insertarEvaluaciones($sqlE);*/
	
	/*'.$lang['TXT_CLAVES'].'<br>
				<br>
				<table width="50%" border="0" align="center" cellpadding="2" cellspacing="0"  style="font-size:12px; text-align:center">
				  <tr>
					<td width="50%">'.$lang["CODIGO"].': <strong>'.$numero_de_trabajo.'</strong></td>
					  <td width="50%">'.$lang["CLAVE"].': <strong>'.$_SESSION["abstract"]["password"].'</strong></td>
				  </tr>
				  <tr>
					<td width="50%" colspan="2"><br><br>
						<a href="'.$getConfig["url_opc"].'abstract">'.$getConfig["url_opc"].'abstract</a>
					</td>
				  </tr>
				</table>
				<br>*/
	
	$cuerpo = '
	<table width="850px" align="center" cellpadding="0px" cellspacing="0" bgcolor="#FBF6F0">
		<tr><td align="center"><br>
		<table width="800px" border="0" cellspacing="1" cellpadding="0" style="font-size:13px; text-decoration:none">
			  <tr>
				   <td bgcolor="#FFFFFF" align="center"><img src="'.$getConfig["banner_congreso"].'" alt="'.$getConfig["nombre_congreso"].'" width="600" ></td>
			  </tr>
			  <tr>
				<td bgcolor="#FFFFFF" align="center">
				<span class="letrasMenu">
				<br>
				<strong>'.$getConfig["nombre_congreso"].'<br><br>
				'.$lang["PRESENTACION_RESUMEN"].'<br>';
                $cuerpo .='
				N&ordm;: <span style="font-size:28;color:red">'.$numero_de_trabajo.'</span></strong></span><br /><br />
				<div align="left" style="margin-left: 20px">
					'.$lang["CONGRESO"].': <strong>'.$core->getAreasIdTL($_SESSION["abstract"]["area_tl"]).'</strong><br>
					'.$lang["MODALIDAD"].': <strong>'.$tipo_tl.'</strong><!--<br>
					'.$lang["PREMIO"].': <strong>'.$_SESSION["abstract"]["premio"].'</strong>-->
				</div>
				<table width="95%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" class="letrasMenu"><br />
			 <strong> '.$_SESSION["abstract"]["titulo_tl"].'</strong></td>
			</tr>
		  <tr>
			<td align="center">'.$_SESSION["abstract"]["autores"].'</td>
		  </tr>
		  <tr>
			<td style="text-align:justify"><br>
				<div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				    <strong>'.$lang["RESUMEN"].'</strong><br />
					'.$_SESSION["abstract"]["resumen_tl"].'
				</div>
				
				<div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				    <strong>'.$lang["RESUMEN2"].'</strong><br />
					'.$_SESSION["abstract"]["resumen_tl2"].'
				</div>
				
				<div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				';
				if($_SESSION["abstract"]["tipo_tl"] == 1){
					$cuerpo .= '<strong>'.$lang["RESUMEN3"].'</strong><br />';
				}else{
					$cuerpo .= '<strong>'.$lang["RESUMEN3_CASO_CLINICO"].'</strong><br />';
				}
				
				$cuerpo .= '
					'.$_SESSION["abstract"]["resumen_tl3"].'
				</div>
		';
		if($_SESSION["abstract"]["tipo_tl"] == 1){
			$cuerpo .= '
				<div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				    <strong>'.$lang["RESUMEN4"].'</strong><br />
					'.$_SESSION["abstract"]["resumen_tl4"].'
				</div>
			';
		}
		
		//<p>'.$lang["PALABRAS_CLAVES"].': '.$_SESSION["abstract"]["palabras_claves"].'</p>
		$cuerpo .='
				<div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				    <strong>'.$lang["RESUMEN5"].'</strong><br />
					'.$_SESSION["abstract"]["resumen_tl5"].'
				</div>
			
			</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
		</table>
				<br />			
				<table style="font-size:13px">
				<tr>
					<td height="45" colspan="2" align="center" style="font-size:15px; font-family:\'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#333"><strong>'.$lang["DATOS_CONTACTO"].'</strong></td>
					</tr>
				  <tr>
					<td width="142" >'.$lang["NOMBRES"].':</td>
					<td width="407" valign="top" ><strong>'.$_SESSION["abstract"]["contacto_nombre"].'</strong></td>
					</tr>
				  <tr>
					<td >'.$lang["APELLIDO"].':</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_apellido"].'</strong></td>
					</tr>
				  <tr>
					<td >E-mail:</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_mail"].'</strong></td>
					</tr>
					<tr>
					<td >E-mail alternativo:</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_mail2"].'</strong></td>
					</tr>
				  <tr>
					<td>'.$lang["PAIS"].'</td>
					<td valign="top" ><strong>'.$core->getPaisID($_SESSION["abstract"]["contacto_pais"]).'</strong></td>
					</tr>
				  <tr>
					<td>'.$lang["INSTITUCION"].'</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_institucion"].'</strong></td>
					</tr>
				  <tr>
					<td>'.$lang["TELEFONO"].':</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_telefono"].'</strong></td>
					</tr>
				  <tr>
					<td>'.$lang["CIUDAD"].'</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_ciudad"].'</strong></td>
					</tr>
				  </table>
				<br>
				
				
				<br>
				';
        if($_SESSION["abstract"]["archivo_tl"]!="" || $_GET["t"]=='1'){
            $cuerpo .='<center>
            <a href="'.$getConfig["url_opc"].'tl/'.($result["archivo_tl"]!=""?$result["archivo_tl"]:$_SESSION["abstract"]["archivo_tl"]).'" style="font-size:13px;"> '.$lang["DESCARGAR_ARCHIVO"].'</a><br></center>';
       }

		$cuerpo .='
		<span style="color:white">'.str_pad($_SESSION["cliente"]["id_cliente"],4,0,STR_PAD_LEFT).'</span>
		</td>
			  </tr>
			</table>
		<br></td></tr>
		</table>';
//"Cuenta [".str_pad($_SESSION["cliente"]["id_cliente"],4,0,STR_PAD_LEFT)."]
$asunto = utf8_decode(" [".$_SESSION["abstract"]["nombre_0"]." " . $_SESSION["abstract"]["apellido_0"]." ".$_SESSION["abstract"]["apellido2_0"] . "] ");

if ($_SESSION["abstract"]["id_tl"] == "") {
	if($_SESSION["abstract"]["tipo_tl"] == 2){
		$asunto .= " Caso clínico [$numero_de_trabajo]";
	}else
		$asunto .= " Resumen [$numero_de_trabajo]";
} else {
	if ($_GET["t"] == 1) {
		$asunto .= " Carga de trabajo completo [$numero_de_trabajo]";
	}
	else {
		if($_SESSION["abstract"]["tipo_tl"] == 2){
			$asunto .= " Modificación de caso clínico [$numero_de_trabajo]";
		}else
			$asunto .= " Modificación de resumen [$numero_de_trabajo]";
	}
}

unset($mails_congreso);
$mails_congreso = array();

if(!$_SESSION["abstract"]["is_admin"]){
	if(!empty($_SESSION["abstract"]["contacto_mail"]))
		$mails_congreso[] = $_SESSION["abstract"]["contacto_mail"];
	if(!empty($_SESSION["abstract"]["contacto_mail2"]))
		$mails_congreso[] = $_SESSION["abstract"]["contacto_mail2"];
}

$mailOBJ->Body = $cuerpo;
$mailOBJ->Subject = $asunto.($_SESSION["abstract"]["is_admin"]?"[ADMIN]":"");

$mails_congreso[] = $getConfig['email_isel']; //email ISEL
$mails_congreso[] = $getConfig['email_abstract']; //email abstract
$mails_congreso[] = $getConfig['email_respaldo']; //email respaldo

$mails_congreso = array_unique($mails_congreso);

$mailOBJ->CharSet = "utf-8";
//$mailOBJ->From    = $getConfig['email_abstract'];
$mailOBJ->FromName = $getConfig['nombre_congreso'];
$mailOBJ->IsHTML(true);

$mailOBJ->Timeout=120;

$mailOBJ->IsSMTP();
$mailOBJ->SMTPDebug  = false;
$mailOBJ->SMTPAuth   = true;
$mailOBJ->SMTPAutoTLS = false;

$mailOBJ->Host       = $getConfig["email_host"];
$mailOBJ->Username   = $getConfig["email_username"];
$mailOBJ->Password   = $getConfig["email_password"];
 
$mailOBJ->Port= 25;
$mailOBJ->From= $getConfig["email_username"];
$mailOBJ->addReplyTo($getConfig["email_abstract"], $getConfig["nombre_congreso"]);

foreach($mails_congreso as $cualMail){
	$mailOBJ->ClearAddresses();
	$mailOBJ->AddAddress($cualMail);

	if(!$mailOBJ->Send()){
		echo "<script>alert('Ocurrio un error al enviar el abstract');</script>";
	}
}	
	/*$result["numero_tl"] = $_SESSION["abstract"]["numero_tl"];*/
	unset($_SESSION["abstract"]);
	//$numero_tl = "&key=".base64_encode($result["numero_tl"]);
	$numero_tl = "&key=".base64_encode($numero_de_trabajo);
}//endif success
	if ($_GET["t"] == 1) {
		header("Location: message.php?status=".$result["success"].$numero_tl."&t=".$_GET["t"]);
	}else
		header("Location: message.php?status=".$result["success"].$numero_tl);