<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
if(count($_SESSION["participante"])>0){
?>
<meta http-equiv="refresh" content="60">
<?
function guardaMilog($que){
	$gestor = fopen("envioMasivoParticipantes.txt", 'a');
	fwrite($gestor, $que . "\n");    
	fclose($gestor);
}
include('conexion.php');

require "clases/class.Cartas.php";
require ("clases/trabajosLibres.php");
require ("clases/class.Traductor.php");
$trabajos = new trabajosLibre;
$cartas = new cartas();

require "clases/class.phpmailer.php";
$mailOBJ = new phpmailer();

$a_quien_se_le_envio = "";




$imprimir = "";

function remplazar($cual, $RemitNombre, $RemitApelldio){

	$busco_y_remplazo = str_replace("$RemitNombre $RemitApelldio", "<span style='background-color:#FFFF00'>$RemitNombre $RemitApelldio</span>", $cual);

	return  $busco_y_remplazo ;
}

function remplazarTexto($cual){
	
	$valor = str_replace("\n", "<br>" , $cual);

	return  $valor;
}

if ($_SESSION["incPrograma"]!=""){
	$traductor = new traductor();
	$traductor->setIdioma($_SESSION["incPrograma"]);
	$sql0 = "SELECT DISTINCT Casillero FROM congreso WHERE ID_persona='" . $_SESSION["participante"][0] . "' ORDER by Casillero, Orden_aparicion ASC;";
	$rs0 = mysql_query($sql0,$con);
	while ($row0 = mysql_fetch_array($rs0)){
		$sql = "SELECT * FROM congreso WHERE Casillero='" . $row0["Casillero"] . "' ORDER by Casillero, Orden_aparicion ASC;";
		$rs= mysql_query($sql,$con);
		while ($row = mysql_fetch_array($rs)){
			require("inc/programaMail.inc.php") ;
		}
	}
}




$sql = "SELECT * FROM personas WHERE ID_Personas='" . $_SESSION["participante"][0] . "' Limit 1;";
$rs = mysql_query($sql,$con);
while ($row = mysql_fetch_array($rs)){
	$RemitProf = $row["Profesion"];

	$RemitNombre = $row["Nombre"];
	$RemitApelldio = $row["Apellidos"];
	$RemitMail = $row["Mail"];
	$RemitMail_array = split( ";", $RemitMail);

}
////////////////CONFIGURACION///////////////////
include "envioMail_Config.php";
$asunto = $_SESSION["asunto0"] . " $RemitProf $RemitNombre $RemitApelldio " . $_SESSION["asunto1"];
//////////////////////////////////////////////

if ( ($_SESSION["rbCarta"]=="Manual") || ($_SESSION["rbCarta"]=="") ) {
	$cartaMail = $_SESSION["carta"].'<br>';
} else {
	$rs = $cartas->cargarUna($_SESSION["rbCarta"]);
	if ($predefinida = mysql_fetch_array($rs)){
		$cartaMail = $predefinida["cuerpo"];
		$cartaMail = $cartas->personificarPorPersona($cartaMail, $_SESSION["participante"][0]);
		$cartaMail = str_replace("<:fecha>", $fechaParaCarta , $cartaMail);
	}
}

$cuerpoMail = str_replace("<:dirBanner>", $dirBanner , $cartaEstandar);
$cuerpoMail = str_replace("<:cuerpo>", $cartaMail , $cuerpoMail);
$cuerpoMail = str_replace("<:participaciones>", $imprimir , $cuerpoMail);

$mailOBJ->From    		= $mail_congreso;
$mailOBJ->FromName 		= $congreso;
$mailOBJ->Subject = $asunto;
$mailOBJ->IsHTML(true);
$mailOBJ->Body    = $cuerpoMail;
$mailOBJ->Timeout=120;
$mailOBJ->ClearAttachments();
$mailOBJ->ClearAddresses();
if($tieneBanner==true){
	$mailOBJ->AddEmbeddedImage("arhivosMails/img_top_mail_750ancho.jpg",'banner');
}
$mailOBJ->AddAttachment("arhivosMails/" . $_SESSION["arhchivoNombre"], $_SESSION["arhchivoNombre"]);

if($_SESSION["A_otro"]==1){

	$mailAotro_array = split( ";", $_SESSION["mailAotro"]);
	
	
	
	foreach($mailAotro_array as $u){
		
		$a_quien_se_le_envio .=  "[<a href=\'mailto:$u\'>$u</a>]";	
		$a_quien_se_le_envio_PARA_LOG .=  "[$u]";
		$mailOBJ->AddAddress(trim($u));
	
	}
	

}

if($_SESSION["A_participante"]==1){


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
		
		//**GUARDO EN LOG**/////
			$fecha = date("d/m/Y H:i");
			guardaMilog("[Participantes][".$fecha."] - [".$numero_de_envio." de ".$total_de_envio."] Se ha enviado el mail a ".$RemitNombre ." ".$RemitApelldio." (".$RemitMail.") a ".$a_quien_se_le_envio_PARA_LOG);
			///////////
			
	echo "<script>\n";
		echo "parent.document.getElementById('divEnvios').innerHTML += '[$numero_de_envio de $total_de_envio] Se ha enviado el mail de <b>$RemitNombre $RemitApelldio </b>a: $a_quien_se_le_envio<br>'\n;";
	echo "</script>\n";

	array_shift ($_SESSION["participante"]);
}
	
	if(count($_SESSION["participante"])==0){
		echo "<script>\n";
			echo "parent.document.getElementById('divEnvios').innerHTML += '<center><br><font size=\'4\'>------------- El envio a finalizado correctamente -------------</font><br /><br /><a href=\'envioMail_listadoParticipantes.php\'>[ Volver al envio de e-mail  de participantes del congreso ]</a></center>';\n";
			
		echo "</script>\n";
		
		$_SESSION["finalizo"]=1;
		guardaMilog("[FIN][".$fecha."]");
	}else{
		
		echo "<script>\n";
		echo "document.location.href = 'envioMail_listadoParticipantes_send_frame.php'\n;";
		echo "</script>\n";
		
	}
		
		
}
?>
