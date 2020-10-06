<?
$box = $_POST["box"];

if($_POST["box"]==""){
	header("Location: index.php");
}
require ("../../conexion.php");
require ("class.phpmailer.php");
require ("../../clases/class.Traductor.php");
require ("../../clases/class.Cartas.php");

$cartas = new cartas();

$err = 0;
$mailOBJ = new phpmailer();

$mailOBJ->From    		= "pediatriasup2015@gmail.com";
$mailOBJ->FromName 		= "Pediatría 2015";
$mailOBJ->IsHTML(true);
$mailOBJ->Timeout=120;

$arrayMails = "";


$nombre_conferencista = $_POST["nombre_conferencista"];
$asuntoPOST = $_POST["asunto"];

$clave = $_POST["clave"];

for($i=0;$i<count($box);$i++){
	  if($i==0){
		  $filtro .=" ( ID_Personas = '$box[$i]' "; 
	  }else{
		  $filtro .=" or ID_Personas = '$box[$i]'"; 
	  }
	  
	  if($i==(count($box)-1)){
		  $filtro .=")"; 
	  }
}

$sql = "SELECT * FROM personas WHERE $filtro AND email<>'' ORDER BY ID_Personas";

/*echo "<scrip>alert('".$sql."');</script><br />";*/
$query = mysql_query($sql,$con) or die(mysql_error());
$cant_pers = mysql_num_rows($query);

if(!$query){
	header("Location: index.php?q=1");
	die();
}

$diahora = date("Y-m-d");

$asunto = utf8_decode($asuntoPOST);

$limit = 0;




while($row = mysql_fetch_object($query)){

if($nombre_conferencista==1){
	$asunto .= " - ".$row->nombre." ".$row->apellido;
}


if($_POST["enviarA"]==1){
	$variosMails = explode(";",trim($_POST["mailA"]));
	if(count($variosMails)==1){
		if(trim($_POST["mailA"])==""){
			die("Debe indicar a que mail se enviara copia");
		}
		$arrayMails[] = trim($_POST["mailA"]);
	}else{
		for($i=0;$i<count($variosMails);$i++){
			if(trim($variosMails[$i])==""){
				die("Debe indicar a que mail se enviara copia");
			}
			$arrayMails[] = trim($variosMails[$i]);
		}
	}
//$arrayMails[] = $_POST["mailA"];
}





if($_POST["enviarEstablecimientos"]==1){
	$variosMails = explode(";",trim($row->email));
	if(count($variosMails)==1){
		if($row->email==""){
			die("Debe seleccionar el conferencista");
		}
		$arrayMails[] = $row->email;
	}else{
		for($i=0;$i<count($variosMails);$i++){
			if($variosMails[$i]==""){
				die("Debe seleccionar los conferencistas");
			}
			$arrayMails[] = trim($variosMails[$i]);
		}
	}
	//$arrayMails[] = $row->Email;
}



//Programa
if ($_POST["ubicacion"]!=""){
	$traductor = new traductor();
	if($row->actividad_idioma_hablado=="Ingles"){
		$idioma_hablado = "ing";
	}else{
		$idioma_hablado = "esp";
	}
	$traductor->setIdioma($idioma_hablado);
	$sql0 = "SELECT DISTINCT Casillero FROM congreso WHERE ID_persona='" . $row->ID_Personas . "' ORDER by Dia_orden,Hora_Inicio,Casillero, Orden_aparicion ASC;";
	/*$sql0 = "SELECT DISTINCT Casillero FROM congreso WHERE ID_persona='" . $_SESSION["participante"][0] . "' ORDER by Casillero, Orden_aparicion ASC;";*/
	$rs0 = mysql_query($sql0,$con) or die(mysql_error());
	
	
	//acts
	$idPersonaNueva = $row->ID_Personas;
	$sqlAct = "SELECT * FROM congreso WHERE ID_persona = '".$idPersonaNueva."' GROUP BY Dia_orden, Hora_inicio, Titulo_de_actividad ORDER BY Dia_orden, Sala, Hora_inicio;";
$rsAct = mysql_query($sqlAct,$con);
	
	$sqlActividad ="SELECT * FROM actividades WHERE idPersonaNueva = '".$idPersonaNueva."' ORDER BY id";
	$rsActividad = mysql_query($sqlActividad ,$con);
	while($RowA[] = mysql_fetch_array($rsActividad));
	
	$ra = 0;	
	//--Acts
	while ($row0 = mysql_fetch_array($rs0)){
		$sql = "SELECT * FROM congreso WHERE Casillero='" . $row0["Casillero"] . "' ORDER by Casillero, Orden_aparicion ASC;";
		$rs= mysql_query($sql,$con) or die(mysql_error());
$io = 0;		
while ($row = mysql_fetch_array($rs)){
			//$traductor->cargarTraductor($row);
			//require("../../inc/programaMail.inc.php") ;
if(($row["Casillero"] == $row["sala_agrupada"])||($row["sala_agrupada"] == '0')){			
			if($row["Titulo_de_actividad"]!=$Titulo){
				$imprimir .= "<br>";
				$io = 0;
			}
			$imprimir .='
	<table width="800" border="0" align="center" cellpadding="4" cellspacing="0">';
if($Titulo!=$row["Titulo_de_actividad"]){	
$imprimir .='
	<tr>
		<td width="473" bgcolor="#AEDCF7">
		<div align="left"><em><strong>Actividad 
		  '.$var;
		   
		   if($rowAct["Tematicas"]!=""){
				$imprimir .= " <span style='color:#990000'>".$row["Tematicas"]."</span>&nbsp;&nbsp; - &nbsp;&nbsp;";
		   } 
		   
		   if($rowAct["Titulo_de_trabajo"]!=""){
				$imprimir .= $row["Titulo_de_trabajo"];
		   }
	$imprimir .='   
		</strong></em></div></td>
		<td colspan="3" align="right" bgcolor="#AEDCF7">
	';
		
		if($row["En_calidad"]!=""){
		//	$imprimir .= "Rol:";
		 } 
	 $imprimir .='   
		<!--<strong>'.$row["En_calidad"].'</strong>-->
	   
		</td>
	  </tr>';

$imprimir .='
	  <tr>
		<td colspan="3" bgcolor="#E2F8FE">
		  <div align="left"><strong>
			
			
			D&iacute;a: '.$row["Dia"].'
	  &nbsp;&nbsp; </strong><strong>';

		
		$imprimir .= "Sala: ";

		$imprimir .= $row["Sala"];
		$imprimir .= "  ";
	$imprimir .= '
		</strong><strong>
		  &nbsp;&nbsp;&nbsp;
		  Hora: '.substr($row["Hora_inicio"],0,-3)." a ".substr($row["Hora_fin"],0,-3).'
		  </strong></div>
		  
		</td>
		</tr>';

$imprimir.='
		<tr bgcolor="#FDDBDB">
		  <td colspan="3" valign="top" bgcolor="#E2F8FE" style="color:#990000"><strong>
			'.str_replace("<br>", " ", $row["Titulo_de_actividad"]).'
		  </strong></td>
		</tr>';
}
$imprimir .='		
		<tr bgcolor="#FDDBDB">
		  <td colspan="3" valign="top" bgcolor="#E2F8FE">';
		   
				
				$sqlPers = "SELECT * FROM personas WHERE ID_Personas='".$row["ID_persona"]."'";
				$queryPers = mysql_query($sqlPers,$con) or die(mysql_error());
				$rowPers = mysql_fetch_object($queryPers);
				
				$imprimir .= "<div style='padding-left:20px;'>";
				$imprimir .= "<span style='color:#403E0B'><strong>".$row["Titulo_de_trabajo"]."</strong></span>";
				$imprimir .= "<div style='padding-left:20px'>";
						$imprimir .= $row["En_calidad"]." <strong>".$rowPers->profesion." ".$rowPers->nombre." ".$rowPers->apellido."</strong> <i>".$rowPers->pais." - $rowPers->institucion</i> <strong>- $rowPers->email</strong><br>";
					$imprimir .= "</div>";
				$imprimir .= "</div>";
			
	$imprimir .= '        
	</td>
	</tr>
		</table>';

			
	
		$Titulo = $row["Titulo_de_actividad"];
		
		
		}
	}
}
}
//--Programa

if($_POST["predefinido"]!=""){
	$rs = $cartas->cargarUna($_POST["predefinido"]);
	if ($predefinida = mysql_fetch_array($rs)){
		$cartaMail = $predefinida["cuerpo"];
		$tituloCarta = $predefinida["titulo"];
		$cartaMail = $cartas->personificarPorPersona($cartaMail, $row->ID_Personas);
		$base64 = base64_encode($row->ID_Personas);
		$cartaMail = str_replace("<:participaciones>", $imprimir , $cartaMail);
		$link_conf = "<a href='http://cau2014.personasuy.info/programa/actividades/ingresarActividad.php?idP=$base64'>http://cau2014.personasuy.info/programa/actividades/ingresarActividad.php?idP=$base64</a>";
		$cartaMail = str_replace("<:link_conferencista>", $link_conf , $cartaMail);
	}
}else{
	$mensaje = nl2br($_POST["mensaje"]);
}

$cuerpo = '
<table width="626" border="0" cellspacing="1" cellpadding="4" align="center">
  <tr>
    <td colspan="2" align="center" style="font-size:16px"><img src="http://pediatra2017.gegamultimedios.net/images/banner.jpg"></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top">'.($mensaje!=""?$mensaje:nl2br($cartaMail)).'</td>
  </tr>
</table>
';

$cuerpo .= ($_POST["ubicacion"]==1?"<div style='border-bottom:1px dashed;margin:10px;'></div>".$imprimir:"");

$mailOBJ->Subject = $asunto;
$mailOBJ->Body    = $cuerpo;

foreach($arrayMails as $cualMail){

	$mailOBJ->ClearAddresses();
	$mailOBJ->AddAddress($cualMail);
	//$mailOBJ->AddAddress("2014ingenieria@gmail.com");
	
	$cartas->guardarCopia($cualMail,$row->ID_Personas);
	
	if(!$mailOBJ->Send()){
		$estadosMailsError[] = $cualMail;
	}else{
		$estadosMailsOk[] = $cualMail;
	}
}
if($estadosMailsOk[0]!=""){
	foreach($estadosMailsOk as $estadosMailsOk){
		$mails_backOk .= $estadosMailsOk.", ";
	}
}

if($estadosMailsError[0]!=""){
	foreach($estadosMailsError as $estadosMailsError){
		$mails_backError .= $estadosMailsError.", ";
	}
}
?>
<script type="text/javascript">
<?
	if($mails_backOk!=""){
?>
		parent.box_mail('<?=trim(utf8_decode($row->nombre)." ".utf8_decode($row->apellido)." - ".$mails_backOk,", ")?>',1);
<?
	}
	if($mails_backError!=""){
?>
		parent.box_mail('<?=trim(utf8_decode($row->nombre)." ".utf8_decode($row->apellido)." - ".$mails_backError,", ")?>',0);
<?
	}
?>
</script>
<?php
$mails_backOk = "";
$mails_backError = "";
unset($estadosMailsOk);
unset($estadosMailsError);
unset($arrayMails);
$asunto = $asuntoPOST;
$cuerpo = "";
}
/*echo "<pre>";
var_dump($arrayMails);
echo "</pre>";*/
/*if($err==1){
	$back = "listado.php?mail=1";
}else{
	$back = "../listado.php";
}
header("Location: $back");*/

?>