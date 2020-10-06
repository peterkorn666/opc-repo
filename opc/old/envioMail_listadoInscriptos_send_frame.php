<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
if(count($_SESSION["participante"])>0){
?>
<meta http-equiv="refresh" content="60">
<?
function guardaMilog($que){
	$gestor = fopen("envioMasivoInscriptos.txt", 'a');
	fwrite($gestor, $que . "\n");    
	fclose($gestor);
}
include('conexion.php');

require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;

require "clases/class.phpmailer.php";
$mailOBJ = new phpmailer();

$a_quien_se_le_envio = "";



function FechaFormateada2($FechaStamp)
{
  $ano = date('Y',$FechaStamp);
  $mes = date('n',$FechaStamp);
  $dia = date('d',$FechaStamp);
  $diasemana = date('w',$FechaStamp);

  $diassemanaN= array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"); 
  $mesesN=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
 // return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";
 return "Montevideo,  ". $mesesN[$mes] ." de $ano";
}

$fecha = time();
$fechaParaCarta =  FechaFormateada2($fecha);
 
$imprimir = "";

function remplazar($cual, $RemitNombre, $RemitApelldio){

	$busco_y_remplazo = str_replace("$RemitNombre $RemitApelldio", "<span style='background-color:#FFFF00'>$RemitNombre $RemitApelldio</span>", $cual);

	return  $busco_y_remplazo ;
}

function remplazarTexto($cual){
	
	$valor = str_replace("\n", "<br>" , $cual);

	return  $valor;
}

$sql0 = "SELECT DISTINCT Casillero FROM congreso WHERE ID_persona='" . $_SESSION["participante"][0] . "' ORDER by Casillero, Orden_aparicion ASC;";
$rs0 = mysql_query($sql0,$con);
while ($row0 = mysql_fetch_array($rs0)){

	$sql = "SELECT * FROM congreso WHERE Casillero='" . $row0["Casillero"] . "' ORDER by Casillero, Orden_aparicion ASC;";
	$rs= mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){

		require("inc/programaMail.inc.php") ;

	}
}





$sql = "SELECT * FROM inscripciones_congreso WHERE id='" . $_SESSION["participante"][0] . "' Limit 1;";
$rs = mysql_query($sql,$con);
while ($row = mysql_fetch_array($rs)){
	$RemitID = $row["id"];
	$RemitProf = $row["tituloAcademico"];
	$RemitNombre = $row["nombre"];
	$RemitApelldio = $row["apellido"];
	$RemitMail = $row["mail"];
	$RemitMail_array = split( ";", $RemitMail);
	$RemitUsuario = $row["usuario"];
	$RemitPass = $row["pass"];

}

////////////////CONFIGURACION///////////////////
include "envioMail_Config.php";
$asunto = $_SESSION["asunto0"] . " $RemitNombre $RemitApelldio " . $_SESSION["asunto1"];
//////////////////////////////////////////////


$cuerpoMail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>'.$congreso.'</title>

</head>

<body  bgcolor="#D7EEEB" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">';
if($tieneBanner==true){
$cuerpoMail .= '<div align="center"><img src="'.$rutaBanner.'" alt="'.$congreso.'"  style="border-top:1px  #000000 solid; border-right:1px  #000000 solid; border-left:1px  #000000 solid;"></div>';
}
$cuerpoMail .= '
<table width="750"  align="center" cellpadding="10" cellspacing="0" bordercolor="#000000"  style="border-bottom:1px  #000000 solid; border-right:1px  #000000 solid; border-left:1px  #000000 solid;">
  <tr bgcolor="#FFFFFF">
    <td bgcolor="#FFFFFF">
	
<div align="justify">
<br>'.remplazarTexto($_SESSION["carta"]).'<br></div>
	 <center>---------------------------------------------------------<br>
	  Por más información <a href="'.$paginaINFOlink.'">'.$paginaINFO.'</a>
     </center></td>
  </tr>
</table>
</body>
</html>';
/*
<div align="right">'.$fechaParaCarta.'</div>
<br />'. $cartaPre .'
'. $cartaPost .'*/
//

$mailOBJ->From    		= $mail_congreso;
$mailOBJ->FromName 		= $congreso;
$mailOBJ->Subject = $asunto;
$mailOBJ->IsHTML(true);
$mailOBJ->Body    = $cuerpoMail;
$mailOBJ->Timeout=120;
$mailOBJ->ClearAttachments();
$mailOBJ->ClearAddresses();
if($tieneBanner==true){
	$mailOBJ->AddEmbeddedImage("arhivosMails/banner_mail.jpg",'banner');
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
			guardaMilog("[Inscripto][".$fecha."] - [".$numero_de_envio." de ".$total_de_envio."] Se ha enviado el mail a ".$RemitNombre ." ".$RemitApelldio." (".$RemitMail.") a ".$a_quien_se_le_envio_PARA_LOG);
			///////////
			
	echo "<script>\n";
		echo "parent.document.getElementById('divEnvios').innerHTML += '[$numero_de_envio de $total_de_envio] Se ha enviado el mail de <b>$RemitNombre $RemitApelldio </b>a: $a_quien_se_le_envio<br>'\n;";
	echo "</script>\n";

	array_shift ($_SESSION["participante"]);
}
	
	if(count($_SESSION["participante"])==0){
		echo "<script>\n";
			echo "parent.document.getElementById('divEnvios').innerHTML += '<center><br><font size=\'4\'>------------- El envio a finalizado correctamente -------------</font><br /><br /><a href=\'envioMail_listadoInscriptos.php\'>[ Volver al envio de e-mail  de Inscriptos del congreso ]</a></center>';\n";
			
		echo "</script>\n";
		
		$_SESSION["finalizo"]=1;
		guardaMilog("[FIN][".$fecha."]");
	}else{
		
		echo "<script>\n";
		echo "document.location.href = 'envioMail_listadoInscriptos_send_frame.php'\n;";
		echo "</script>\n";
		
	}
		
		
}
?>
