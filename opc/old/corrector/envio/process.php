<?php
if($_POST["box"]==""){
	header("Location: index.php");
}
session_start();
unset($_SESSION["mail"]);
require("../../conexion.php");
require ("../../clases/class.Traductor.php");
require "../../clases/class.Cartas.php";
include "../../envioMail_Config.php";
$cartas = new cartas();

$_SESSION["mail"]["nombre_conferencista"] = $_POST["nombre_conferencista"];
$asunto = $_POST["asunto"];
$_SESSION["mail"]["clave"] = $_POST["clave"];
$box = $_POST["box"];
for($i=0;$i<count($box);$i++){
	  if($i==0){
		  $filtro .=" ( id = '$box[$i]' "; 
	  }else{
		  $filtro .=" or id = '$box[$i]'"; 
	  }
	  
	  if($i==(count($box)-1)){
		  $filtro .=")"; 
	  }
}

$sql = "SELECT * FROM evaluadores WHERE $filtro AND mail<>'' ORDER BY id";
$query = mysql_query($sql,$con) or die(mysql_error());
$cant_pers = mysql_num_rows($query);

if(!$query){
	header("Location: index.php?q=1");
	die();
}

if($_POST["enviarA"]==1){
	$variosMails = explode(";",trim($_POST["mailA"]));
	if(count($variosMails)==1){
		if(trim($_POST["mailA"])==""){
			die("Debe indicar a que mail se enviara copia");
		}
		$_SESSION["mail"]["email_copia"] = trim($_POST["mailA"]);
	}else{
		for($i=0;$i<count($variosMails);$i++){
			if(trim($variosMails[$i])==""){
				die("Debe indicar a que mail se enviara copia");
			}
			$_SESSION["mail"]["email_copia"] = trim($variosMails[$i]);
		}
	}
//$arrayMails[] = $_POST["mailA"];
}


while($row = mysql_fetch_object($query))
{
	
	if($_POST["enviarEstablecimientos"]==1){
	$variosMails = explode(";",trim($row->mail));
	if(count($variosMails)==1){
		if($row->mail==""){
			die("Debe seleccionar el conferencista");
		}
		$_SESSION["mail"]["arrayMails"][] = $row->mail;
	}else{
		for($i=0;$i<count($variosMails);$i++){
			if($variosMails[$i]==""){
				die("Debe seleccionar los conferencistas");
			}
			$_SESSION["mail"]["arrayMails"][] = trim($variosMails[$i]);
		}
	}
	//$arrayMails[] = $row->Email;
}

	$_SESSION["mail"]["nombre_evaluador"][] = $row->nombre;

	if($_SESSION["mail"]["nombre_conferencista"]==1)
		$_SESSION["mail"]["asunto"][] = $asunto." - [".$row->id."] ".$row->nombre;
	else
		$_SESSION["mail"]["asunto"][] = $asunto;
			
	
	if($_POST["predefinido"]!=""){
		$rs = $cartas->cargarUna($_POST["predefinido"]);
		if ($predefinida = mysql_fetch_array($rs)){
			$cartaMail = $predefinida["cuerpo"];
			$tituloCarta = $predefinida["titulo"];
			$base64 = base64_encode($row->id);
			$cartaMail = str_replace("<:id>", $row->id , $cartaMail);
			$cartaMail = str_replace("<:nombre>",$row->nombre , $cartaMail);
			$cartaMail = str_replace("<:link>", "<a href='http://www.cicat2016.org/programa/corrector/eval.php?key=".base64_encode($cualMail[1])."'>HAGA CLICK AQU&Iacute; PARA RESPONDER<br>LA INVITACI&Oacute;N DE FORMA ONLINE</a>" , $cartaMail);
			$cartaMail = str_replace("<:mail>", $row->mail , $cartaMail);
			$cartaMail = str_replace("<:clave>", $row->clave , $cartaMail);
			$cartaMail = str_replace("<:fecha>", $fechaParaCarta , $cartaMail);
			$cartaMail = str_replace("<:fecha2>", $fechaParaCartaEsp , $cartaMail);
		}
	}else{
		$link_conf = "<a href='http://www.cicat2016.org/programa/corrector/eval.php?key=".base64_encode($cualMail[1])."'>HAGA CLICK AQU&Iacute; PARA RESPONDER<br>LA INVITACI&Oacute;N DE FORMA ONLINE</a>";
		$mensaje = str_replace("<:link>", $link_conf , $_POST["mensaje"]);
		$mensaje = nl2br($mensaje);
	}
	
	$cuerpo = '
		<table width="626" border="0" cellspacing="1" cellpadding="4" align="center">
		  <tr>
			<td colspan="2" align="center" style="font-size:16px"><img src="'.$dirBanner.'" width="900"></td>
		  </tr>
		  <tr>
			<td colspan="2" align="left" valign="top">'.($mensaje!=""?$mensaje:nl2br($cartaMail)).'</td>
		  </tr>
		</table>
	';
	
	$cuerpo .= ($_POST["ubicacion"]==1?"<div style='border-bottom:1px dashed;margin:10px;'></div>".$imprimir:"");
	
	$_SESSION["mail"]["ID_Personas"][] = $row->id;
	$_SESSION["mail"]["cuerpo"][] = $cuerpo;
	
	
}//end while

header("Location: enviar.php");


?>