<?
session_start();
set_time_limit(3000000);
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=UTF-8');

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
	include "envioMail_Config.php";
	include("inc/validarVistas.inc.php");
	require ("clases/class.Traductor.php");
	require "clases/class.Cartas.php";
	$cartas = new cartas();
	require ("clases/trabajosLibres.php");
	$trabajos = new trabajosLibre;
	require "clases/class.smtp.php";
	require "clases/class.phpmailer.php";
	$mailOBJ = new phpmailer();
	$a_quien_se_le_envio = "";
	$imprimir = "";
	function FechaFormateada1($FechaStamp){
		$ano = date('Y',$FechaStamp);
		$mes = date('n',$FechaStamp);
		$dia = date('d',$FechaStamp);
		$diasemana = date('w',$FechaStamp);
		$diassemanaN= array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		$dayssemanaN= array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
		$mesesN=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$monthsN =array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "October", "November", "December");
		return "Montevideo,  ". $diassemanaN[$diasemana] ." $dia ". $mesesN[$mes] ." de $ano";
	}
	function FechaFormateada2($FechaStamp){
		$ano = date('Y',$FechaStamp);
		$mes = date('n',$FechaStamp);
		$dia = date('d',$FechaStamp);
		$diasemana = date('w',$FechaStamp);
		$diassemanaN= array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		$dayssemanaN= array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
		$mesesN=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$monthsN =array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "October", "November", "December");
		return "Montevideo,  ". $dayssemanaN[$diasemana] ." $dia ". $monthsN[$mes] ." of $ano";
	}

	$fecha = time();
	$fechaParaCarta =  FechaFormateada2($fecha);
	$fechaParaCartaEsp =  FechaFormateada1($fecha);
	
	function remplazarEspacios($cual){

		$valor = str_replace("\n", "<br>" , $cual);
		
		return  $valor;
	}
	
	function reemplazarTildes($cuerpo){
		$array_vocales_tilde = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "°");
		$array_vocales_acute = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&ordm;");
		$cuerpo = str_replace($array_vocales_tilde, $array_vocales_acute, $cuerpo);
		
		return $cuerpo;
	}
	
	function remplazar($cual, $RemitNombre, $RemitApelldio){
		$busco_y_remplazo = str_replace("$RemitNombre $RemitApelldio", "<span style='background-color:#FFFF00'>$RemitNombre $RemitApelldio</span>", $cual);
		return  $busco_y_remplazo ;
	}
	
	function remplazarTexto($cual){
		$valor = str_replace("\n", "<br>" , $cual);

		return  $valor;
	}
		require("../class/core.php");
		require("../class/templates.opc.php");
		$templates = new templateOPC();
        //$infoCrono = mysql_query("SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid JOIN crono_conferencistas as cc ON cc.id_crono=c.id_crono WHERE cc.id_conf='{$_SESSION["participante"][0]}' ORDER BY SUBSTRING(c.start_date,1,10),s.orden,c.start_date", $con) or die("ERROR CRONGORAMA");
		$infoCrono = $con->query("SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid JOIN crono_conferencistas as cc ON cc.id_crono=c.id_crono WHERE cc.id_conf='{$_SESSION["participante"][0]}' ORDER BY SUBSTRING(c.start_date,1,10),s.orden,c.start_date");
		if (!$infoCrono){
			die("ERROR CRONOGRAMA");
		}
		$helper = 0;
		$dia_ = "";
		$sala_ = "";
		$html = "";
		$html_trabajos  = "";
		while($crono = $infoCrono->fetch_array()):
			
			$html .= $templates->programaExtendidoMail($crono,$dia_, $sala_,$helper);
			$html_trabajos .= str_replace("<div class='trabajo'>", "<div style='border-bottom:1px dashed;margin-top:10px;margin-bottom:10px;margin-left:40px'></div><div class='trabajo' style='margin-left:40px'>", $templates->programaExtendidoMail($crono,$dia_, $sala_,$helper, true));
			
			$dia_ = substr($crono["start_date"],0,10);
			$sala_ = $crono['section_id'];
			$helper++;
			
		endwhile;
		$html .= '';
		$imprimir = reemplazarTildes($html);


	$sql = "SELECT * FROM conferencistas WHERE id_conf='" . $_SESSION["participante"][0] . "' Limit 1;";
	$rs = $con->query($sql);
	while ($row = $rs->fetch_array()){
		$RemitID = $row["id_conf"];
		$RemitProf =$row["profesion"];
		$RemitNombre = $row["nombre"];
		$RemitApelldio = $row["apellido"];
		$RemitMail = $row["email"];
		$RemitMail_array = explode( ";", $RemitMail);

	}
	//$remiteNombre_sin_tildes = reemplazarTildes($RemitNombre);
	//$remiteApellido_sin_tildes = reemplazarTildes($RemitApelldio);


	if ( ($_SESSION["rbCarta"]=="Manual") || ($_SESSION["rbCarta"]=="") ) {
		$cartaMail = $_SESSION["carta"].'<br>';
	} else {
		$rs = $cartas->cargarUna($_SESSION["rbCarta"]);
		if ($predefinida = $rs->fetch_array()){
			$cartaMail = $predefinida["cuerpo"];
			$cartaMail = $cartas->personificarPorPersona($cartaMail, $_SESSION["participante"][0]);
			$cartaMail = str_replace("<:fecha>", $fechaParaCarta , $cartaMail);
			$cartaMail = str_replace("<:nombre>", $RemitNombre , $cartaMail);
			$cartaMail = str_replace("<:apellido>", $RemitApelldio , $cartaMail);
			$cartaMail = str_replace("<:fecha2>", $fechaParaCartaEsp , $cartaMail);
			$cartaMail = str_replace("<:participaciones>", $imprimir , $cartaMail);
			$cartaMail = str_replace("<:participaciones_trabajos>", $html_trabajos, $cartaMail);
			$base64 = base64_encode($_SESSION["participante"][0]);
			$link_conf = "<a href='$paginaPrograma?page=conferencistasManager&key=$base64'>$paginaPrograma?page=conferencistasManager&key=$base64</a>";
			$cartaMail = str_replace("<:link_conferencista>", $link_conf , $cartaMail);
		}
	}


////////////////CONFIGURACION///////////////////

	$asunto = $_SESSION["asunto0"] . ": ".$RemitProf." ".$RemitNombre." ".$RemitApelldio." " . $_SESSION["asunto1"];
	
	/*$cuerpoMail = '<div align="center"><span style="padding:0px"><img src="'.$rutaBanner.'" alt="'.$congreso.'"></span></div>
<table width="900px" cellpadding="10px" cellspacing="10px" align="center">
             		<tr>
                   		<td align="left" valign="top" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif;font-size: 12px;color:#000000;">'.nl2br($cartaMail).'</td>
		          </tr>
        </table>';*/
		
	$cartaMail = reemplazarTildes($cartaMail);
	$cartaUsu = '<font size="2" face="Arial, Helvetica, sans-serif">'. remplazarEspacios($cartaMail) .'</font><br /><center>---------------------------------------------------------</center>';

	$cuerpoMail = str_replace("<:dirBanner>", $dirBanner , $cartaEstandar);
	$cuerpoMail = str_replace("<:cuerpo>", $cartaUsu , $cuerpoMail);
	$cuerpoMail = reemplazarTildes($cuerpoMail);
	
//

	$sqlConfig = $con->query("SELECT email_host, email_username, email_password FROM config");
	$config = $sqlConfig->fetch_assoc();

	$mailOBJ->IsSMTP();
	$mailOBJ->SMTPDebug  = 2;
	$mailOBJ->SMTPAuth   = true;
	$mailOBJ->SMTPAutoTLS = false;
	
	$mailOBJ->Host       = $config["email_host"];
	$mailOBJ->Username   = $config["email_username"];
	$mailOBJ->Password   = $config["email_password"];
	 
	$mailOBJ->Port = 25;
	$mailOBJ->From = $config["email_username"];
	
	$mailOBJ->addReplyTo($mail_congreso, "Contacto - ".$congreso);
	

	//$mailOBJ->From    		= $mail_congreso;
	$mailOBJ->FromName = $congreso;
	$mailOBJ->Subject = utf8_decode($asunto);
	//$mailOBJ->Subject = $asunto;
	$mailOBJ->IsHTML(true);
	$mailOBJ->Body    = utf8_decode($cuerpoMail);
	$mailOBJ->Timeout=120;
	$mailOBJ->ClearAttachments();
	$mailOBJ->ClearAddresses();
	/*if($tieneBanner==false){
		$mailOBJ->AddEmbeddedImage("arhivosMails/img_top_mail_750ancho.jpg",'banner');
		$mailOBJ->AddEmbeddedImage("arhivosMails/img_bottom_mail_750ancho.jpg",'bannerBottom');
	}*/
	//$mailOBJ->AddAttachment("arhivosMails/" . $_SESSION["arhchivoNombre"], $_SESSION["arhchivoNombre"]);

	if($_SESSION["A_otro"]==1){
		$mailAotro_array = explode(";", $_SESSION["mailAotro"]);
		foreach($mailAotro_array as $u){
			$a_quien_se_le_envio .=  "[<a href=\'mailto:$u\'>$u</a>]";
			$a_quien_se_le_envio_PARA_LOG .=  "[$u]";
			$mailOBJ->AddAddress(trim($u));
			//$mailOBJ->AddAttachment("adjuntos/Como_crear_su_presentacion_interactiva_con_Poll_Everywhere.pdf");
		}
	}

	if($_SESSION["A_participante"]==1){
		foreach($RemitMail_array as $i){
			$a_quien_se_le_envio .= "[<a href=\'mailto:$i\'>$i</a>]";
			$a_quien_se_le_envio_PARA_LOG .=  "[$i]";
			$mailOBJ->AddAddress(trim($i));
			//$mailOBJ->AddAttachment("adjuntos/Como_crear_su_presentacion_interactiva_con_Poll_Everywhere.pdf");
		}
	}
//$mailOBJ->AddAddress("2014ingenieria@gmail.com");
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
		/*$sql ="SELECT * FROM personas WHERE	ID_Personas = '".$RemitID."';";
		$que = "[Participantes][".$fecha."] - [".$numero_de_envio." de ".$total_de_envio."] Se ha enviado el mail a ".$RemitNombre ." ".$RemitApelldio." (".$RemitMail.") a ".$a_quien_se_le_envio_PARA_LOG;
		$rs = mysql_query($sql, $con);
		if($row = mysql_fetch_array($rs)){
			$update = "UPDATE personas SET cartasEnviadas = '".$row["cartasEnviadas"]."<br />".$que."' WHERE ID_Personas = '".$RemitID."';";
			$rs = mysql_query($update, $con);
		}*/
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
		sleep(10);
		echo "<script>\n";
		echo "document.location.href = 'envioMail_listadoParticipantes_send_frame.php'\n;";
		echo "</script>\n";

	}


}
?>
