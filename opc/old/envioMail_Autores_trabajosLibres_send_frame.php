<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

function guardaMilog($que){
	$gestor = fopen("envioMasivoAutores.txt", 'a');
	fwrite($gestor, $que . "\n");    
	fclose($gestor);
}
//print_r($_SESSION["autor"]);

if($_SESSION["finalizo"]==0){

?>
<meta http-equiv="refresh" content="60">
<?

include('conexion.php');

require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;
require ("clases/personas.php");
$personas = new personas;
require "clases/class.smtp.php";
require "clases/class.phpmailer.php";
$mailOBJ = new phpmailer();
require "clases/class.Cartas.php";
$cartas = new cartas();

$a_quien_se_le_envio = "";

$imprimir = "";

function remplazar($cual){
	
	$valor = str_replace("\n", "<br>" , $cual);

	return  $valor;
}
$datosAutor = $personas->UNA_persona_TLS($_SESSION["autor"][0]);
//$TL_rs = $trabajos->selectTL_ID($_SESSION["autor"][0]);


/////VER ACA COMO SACAR SOLO EL MAIL
//$autorPrincipal = $trabajos->primer_autor($_SESSION["trabajo"][0]);

/*$RemitMail = "";
while ($row = $TL_rs->fetch_object()){

	//$Remit_TL_cod = $row->numero_tl;

	//$Remit_TL_titulo = $row->titulo_tl;

	$RemitMail .= $row->mailContacto_tl . ";";

	//$RemitClave = $row->clave;
	
	//$Casillero = $row->ID_casillero;

	
	//require("inc/trabajoLibre.inc.php");


}*/



while ($row = $datosAutor->fetch_object()){
	$Apellido = $row->Apellidos;
	$Nombre  = $row->Nombre;
	$Mail = $row->Mail;
}

if ( ($_SESSION["rbCarta"]=="Manual") || ($_SESSION["rbCarta"]=="") ) {
	$cartaMail = $_SESSION["carta"].'<br>';
} else {
	$rs = $cartas->cargarUna($_SESSION["rbCarta"]);
	if ($predefinida = $rs->fetch_array()){
		$cartaMail = $predefinida["cuerpo"];
		$cartaMail = $cartas->personificarPorPersonaTL($cartaMail, $_SESSION["autor"][0]);
		$cartaMail = str_replace("<:fecha>", $fechaParaCarta , $cartaMail);
		$cartaMail = str_replace("<:fecha2>", $fechaParaCartaEsp , $cartaMail);
	}
}

$trabajos_personas = $personas->trabajosPersona($_SESSION["autor"][0]);

//Autores tl
$autoresTL = "";
$sqlIdParticipantes = $con->query("SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres='".$trabajos_personas["id_trabajo"]."'");
while ($rowIdParticipantes = $sqlIdParticipantes->fetch_array()) {
	$sqlNombreParticipante = $con->query("SELECT * FROM personas_trabajos_libres WHERE ID_Personas='".$rowIdParticipantes["ID_participante"]."'");
	$rowNombreParticipante = $sqlNombreParticipante->fetch_array();
	if ($autoresTL == "") {
		$autoresTL = $rowNombreParticipante["Nombre"] . " " . $rowNombreParticipante["Apellidos"];
	}
	else {
		$autoresTL = $autoresTL . ", " . $rowNombreParticipante["Nombre"] . " " . $rowNombreParticipante["Apellidos"];
	}
}

$imagen_costos_inscripcion = "<img src='".$paginaINFOlink."imagenes/tabla_costos_inscripcion.png' width='750'>";

////////////////CONFIGURACION///////////////////
include "envioMail_Config.php";
$asunto = $_SESSION["asunto1"] . " [$Nombre $Apellido]";

//////////////////////////////////////////////

$cartaUsu = '<font size="2" face="Arial, Helvetica, sans-serif">'. remplazar($cartaMail) .'</font><br /><center>---------------------------------------------------------</center>';

$cuerpoMail = str_replace("<:dirBanner>", $dirBanner , $cartaEstandarAutores);
$cuerpoMail = str_replace("<:congreso>", $congreso , $cuerpoMail);
$cuerpoMail = str_replace("<:cuerpo>", $cartaUsu , $cuerpoMail);
$cuerpoMail = str_replace("<:numero_tl>", $trabajos_personas["numero_tl"] , $cuerpoMail);
$cuerpoMail = str_replace("<:titulo_tl>", $trabajos_personas["titulo_tl"] , $cuerpoMail);
$cuerpoMail = str_replace("<:autores_tl>", $autoresTL , $cuerpoMail);
$link_programa_completo = "<a href='".$paginaINFOlink."'>aquí</a>";
$cuerpoMail = str_replace("<:link_programa_completo>", $link_programa_completo, $cuerpoMail);
$cuerpoMail = str_replace("<:imagen_costos_inscripcion>", $imagen_costos_inscripcion, $cuerpoMail);
//$cuerpoMail = str_replace("<:nombreAutor>", $Nombre , $cuerpoMail);
//$cuerpoMail = str_replace("<:apellidoAutor>", $Apellido , $cuerpoMail);

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
//$mailOBJ->FromName= "CONFERENCIA ARROZ 2018";
$mailOBJ->addReplyTo($mail_congreso, "Contacto - ".$congreso);


//$mailOBJ->From    		= $mail_congreso;
$mailOBJ->FromName 		= $congreso;
$mailOBJ->Subject 		= $asunto;
$mailOBJ->IsHTML(true);

$mailOBJ->Timeout=120;
$mailOBJ->ClearAttachments();
$mailOBJ->ClearAddresses();
$mailOBJ->ClearBCCs();
/*if($tieneBanner==true){
	$mailOBJ->AddEmbeddedImage("arhivosMails/banner_mail.jpg",'banner');
}*/
//$mailOBJ->AddAttachment("arhivosMails/" . $_SESSION["arhchivoNombre"], $_SESSION["arhchivoNombre"]);


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

	$RemitMail = "";
	/*foreach($_SESSION["autor"] as $p){*/
		$autor = $personas->UNA_persona_TLS($_SESSION["autor"][0]);
		while($rowAutor = $autor->fetch_array()){
			$RemitMail .= $rowAutor["Mail"].";";
		}
	/*}*/
	
	$RemitMail = substr($RemitMail,0,-1);
	$RemitMail_array = explode( ";", $RemitMail);

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
			guardaMilog("[Autores][".$fecha."] - [".$numero_de_envio." de ".$total_de_envio."] Se ha enviado el mail a ".$Apellido ." ".$Nombre." (".$Mail.") a ".$a_quien_se_le_envio_PARA_LOG);
			///////////
		
		
			echo "<script>\n";
			echo "parent.document.getElementById('divEnvios').innerHTML += '[$numero_de_envio de $total_de_envio] Se ha enviado el mail a <b>$Apellido $Nombre</b> ($Mail) a $a_quien_se_le_envio<br>'\n;";
			echo "</script>\n";
		
			array_shift ($_SESSION["autor"]);
		
	}
	
	if(count($_SESSION["autor"])==0){
		echo "<script>\n";
			echo "parent.document.getElementById('divEnvios').innerHTML += '<center><br><font size=\'4\'>------------- El envio a finalizado correctamente -------------</font><br /><br /><a href=\'envioMail_Autores_trabajosLibres.php\'>[ Volver al envio de e-mail para autores y/o coautores de trabajos ]</a></center>';\n";
			
		echo "</script>\n";
		
		$_SESSION["finalizo"]=1;
		guardaMilog("[FIN][".$fecha."]");
	}else{
		
		echo "<script>\n";
		echo "document.location.href = 'envioMail_Autores_trabajosLibres_send_frame.php'\n;";
		echo "</script>\n";
		
	}
		
		
}
?>
