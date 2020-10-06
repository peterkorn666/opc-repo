<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if(count($_SESSION["inscriptos"])>0){
?>
<meta http-equiv="refresh" content="60">
<?
function guardaMilog($que){
	$gestor = fopen("envioMasivoInscriptos.txt", 'a');
	fwrite($gestor, $que . "\n");    
	fclose($gestor);
}
function remplazar($cual){
	$valor = str_replace("\n", "<br>" , $cual);
	return  $valor;
}
function remplazarTitulo($cual) {
	$valor = str_replace("\n", " " , $cual);
	return  $valor;
}
include('conexion.php');

require "clases/class.Cartas.php";
$cartas = new cartas();

require "clases/class.smtp.php";
require "clases/class.phpmailer.php";
$mailOBJ = new phpmailer();

$a_quien_se_le_envio = "";

$imprimir = "";

$sqlInscripto = $con->query("SELECT * FROM inscriptos WHERE id=".$_SESSION["inscriptos"][0]);
$inscripto = $sqlInscripto->fetch_array();

///////////ARMO LA CARTA



////////////////CONFIGURACION///////////////////
include "envioMail_Config.php";
$asunto = $_SESSION["asunto0"]." [Inscripto ".$inscripto['id']."] [".$inscripto['apellido'].", ".$inscripto['nombre']."] ".$_SESSION["asunto1"];
//////////////////////////////////////////////


if ( ($_SESSION["rbCarta"]=="Manual") || ($_SESSION["rbCarta"]=="") ) {
	$cartaMail = $_SESSION["carta"].'<br>';
} else {
	$rs = $cartas->cargarUna($_SESSION["rbCarta"]);
	if ($predefinida = $rs->fetch_array()){
		$cartaMail = $predefinida["cuerpo"];
		$cartaMail = $cartas->personificarPorInscripto($cartaMail, $inscripto['id']);
		$cartaMail = str_replace("<:fecha>", $fechaParaCarta , $cartaMail);
	}
}


	$cartaUsu = '<font size="2" face="Arial, Helvetica, sans-serif">'. remplazar($cartaMail) .'</font><br /><center>---------------------------------------------------------</center>';
	
$link_perfil = '<a href="'.$paginaPrograma."inscripcion/perfil.php?key=".base64_encode($inscripto['id']).'">Perfil Inscripto</a>';

$cuerpoMail = str_replace("<:dirBanner>", $dirBanner , $cartaEstandarInscriptos);
$cuerpoMail = str_replace("<:congreso>", $congreso , $cuerpoMail);
$cuerpoMail = str_replace("<:cuerpo>", $cartaUsu , $cuerpoMail);
$cuerpoMail = str_replace("<:link_perfil>", $link_perfil, $cuerpoMail);

//
//

$mailOBJ->IsSMTP();
$mailOBJ->SMTPDebug  = 2;
$mailOBJ->SMTPAuth   = true;
$mailOBJ->SMTPAutoTLS = false;

$sqlDatosMail = "SELECT email_host, email_username, email_password FROM config WHERE id=1";
$rsDatosMail = $con->query($sqlDatosMail);
while($rowDatosMail = $rsDatosMail->fetch_array()){
	$email_host = $rowDatosMail['email_host'];
	$email_username = $rowDatosMail['email_username'];
	$email_password = $rowDatosMail['email_password'];
}

$mailOBJ->Host       = $email_host;
$mailOBJ->Username   = $email_username;
$mailOBJ->Password   = $email_password;
 
$mailOBJ->Port= 25;
$mailOBJ->From= $email_username;
$mailOBJ->addReplyTo($mail_congreso, "Contacto - ".$congreso);

//
$mailOBJ->FromName 		= $congreso;
$mailOBJ->Subject 		= $asunto;
$mailOBJ->IsHTML(true);

$mailOBJ->Timeout=120;
$mailOBJ->ClearAttachments();
$mailOBJ->ClearAddresses();
$mailOBJ->ClearBCCs();
$mailOBJ->CharSet = "utf8";


if($_SESSION['archivoNombre'] !== NULL && $_SESSION['archivoNombre'] !== ""){
	$mailOBJ->AddAttachment("../archivos_mails/".$_SESSION['archivoNombre'], $_SESSION["archivoNombre"]);
}

$mailOBJ->Body  = $cuerpoMail;

if($_SESSION["A_otro"]==1){
	$mailAotro_array = explode( ";", $_SESSION["mailAotro"]);
	
	foreach($mailAotro_array as $u){
		$a_quien_se_le_envio .=  "[<a href=\'mailto:$u\'>$u</a>]";
		$a_quien_se_le_envio_PARA_LOG .=  "[$u]";
		$mailOBJ->AddBCC(trim($u));
	}
}
if($_SESSION["A_contacto"]==1){
	
	$RemitMail_array = array($inscripto["email"]);
	
	foreach($RemitMail_array as $i){
		$a_quien_se_le_envio .= "[<a href=\'mailto:$i\'>$i</a>]";
		$a_quien_se_le_envio_PARA_LOG .=  "[$i]";
		$mailOBJ->AddAddress(trim($i));
	}
}

if(!$mailOBJ->Send()){
	echo "Ocurrio un error";
}else{
	$_SESSION["numero_de_envio"] = $_SESSION["numero_de_envio"] + 1;
	$numero_de_envio = $_SESSION["numero_de_envio"];
	$total_de_envio = $_SESSION["total_de_envio"];
	date_default_timezone_set('America/Montevideo');
	
	//**GUARDO EN LOG**/////
	$fecha = date("d/m/Y H:i");
	guardaMilog("[Inscriptos][".$fecha."] - [".$numero_de_envio." de ".$total_de_envio."] Se ha enviado el mail al inscripto con mail: ".$a_quien_se_le_envio_PARA_LOG);
	
	///////////
	/*$sql ="SELECT * FROM trabajos_libres WHERE numero_tl = '".$Remit_TL_cod."';";
	$que = "[$asunto] [Trabajos][".$fecha."] - [".$numero_de_envio." de ".$total_de_envio."] ".$a_quien_se_le_envio_PARA_LOG;
	$rs = $con->query($sql);
	if($row = $rs->fetch_array()){
		$update = "UPDATE trabajos_libres SET cartasEnviadas = '".$row["cartasEnviadas"]."<br />".$que."' WHERE numero_tl = '".$Remit_TL_cod."';";
		$rs = $con->query($update);
	}*/
			
	echo "<script>\n";
	echo "parent.document.getElementById('divEnvios').innerHTML += '[$numero_de_envio de $total_de_envio] Se ha enviado el mail al inscripto con email: $a_quien_se_le_envio<br>'\n;";
	echo "</script>\n";

	array_shift ($_SESSION["inscriptos"]);
	}
	
	if(count($_SESSION["inscriptos"])==0){
		echo "<script>\n";
			echo "parent.document.getElementById('divEnvios').innerHTML += '<center><br><font size=\'4\'>------------- El envio ha finalizado correctamente -------------</font><br /><br /><a href=\'envioMail_inscriptos.php\'>[ Volver al envio de e-mail de inscriptos ]</a></center>';\n";
			
		echo "</script>\n";
		
		$_SESSION["finalizo"]=1;
		guardaMilog("[FIN][".$fecha."]");
	}else{
		
		echo "<script>\n";
		echo "setTimeout(function(){document.location.href = 'envioMail_inscriptos_send_frame.php'\n;},10000)";
		echo "</script>\n";
		
	}	
}
?>
