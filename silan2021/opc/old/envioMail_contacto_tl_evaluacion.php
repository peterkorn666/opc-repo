<?php
	$id = $_GET["id"];
	if($id==""){
		die();
	}
	require("conexion.php");
	require("clases/trabajosLibres.php");
	require("clases/class.phpmailer.php");
	require("clases/class.Cartas.php");
	require("envioMail_Config.php");
	$trabajos = new trabajosLibre();
	$mailOBJ = new phpmailer();
	$cartas = new cartas();
	$info = mysql_fetch_object($trabajos->getTLid($id));



$rs = $cartas->cargarUna(4);
if ($predefinida = mysql_fetch_array($rs)){
	$cartaMail = $predefinida["cuerpo"];
	
}

$cartaMail = str_replace("<:numero_tl>", $info->numero_tl, $cartaMail);
$cartaMail = str_replace("<:nombreContacto>", $info->nombreContacto, $cartaMail);
$cartaMail = str_replace("<:apellidoContacto>", $info->apellidoContacto , $cartaMail);


$arrayPersonas = array();
$arrayInstituciones = array();
$primero = true;
	  $sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $id ." ORDER BY ID ASC;";
	  $rs2 = mysql_query($sql2,$con);
	  while ($row2 = mysql_fetch_array($rs2)){

		$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
		$rs3 = mysql_query($sql3,$con);
		while ($row3 = mysql_fetch_array($rs3)){

			array_push($arrayInstituciones , $row3["Institucion"]);
			array_push($arrayPersonas, array($row3["Institucion"], $row3["Apellidos"], $row3["Nombre"], $row3["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"], $row3["inscripto"]));
		}

	  }
$imprimir .= "<span style='font-family:Times New Roman, Times, serif; font-size: 12px;color: #000000;margin:0px'>";
	  $arrayInstitucionesUnicas = array_unique($arrayInstituciones);
	  $arrayInstitucionesUnicasNuevaClave = array();
	  if(count($arrayInstitucionesUnicas)>0){
		foreach ($arrayInstitucionesUnicas as $u){
			if($u!=""){
				array_push($arrayInstitucionesUnicasNuevaClave, $u);
			}
		}
	  }
	  $autoreInscriptos = "";
	  for ($i=0; $i < count($arrayPersonas); $i++){

		if($i>0){
			$imprimir .= "; ";
		}
		if($i==0){
			if($arrayPersonas[$i][3] != ""){
				$aster = "(*)";
			}
		}else{
			$aster = "";
		}
		if($arrayPersonas[$i][0]!=""){
			$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicasNuevaClave))+1;
		}else{
			$claveIns = "";
		}
		
		if($arrayPersonas[$i][7]==1){
			$autoreInscriptos .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2] . "<br>";
		}
		
		if ($arrayPersonas[$i][6]=="1"){
			$imprimir .= "<u>";
			$presentador = $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
		}		
		$imprimir .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
		if($primero){
			$PrimerAutor = $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
			$PrimerPais = $arrayPersonas[$i][3];
			$primero = false;
		}
		
		if ($arrayPersonas[$i][6]=="1"){
			$imprimir .= "</u>";
		}
		$imprimir .= "<sup> " . $claveIns . $aster  . "</sup>" ;
	  }
	 
$imprimir .= "</span><br>";

$divRegistrad=false;
$primero = false;
	  /*imprimo institucion y claves*/
	  $imprimir .= "<span style='font-family:Times New Roman, Times, serif;font-size: 10px;color: #000000;margin:0px'>";
	  if(count($arrayInstitucionesUnicasNuevaClave)>0){
		$clave = 1;
		foreach ($arrayInstitucionesUnicasNuevaClave as $ins){
				$imprimir .= "<i> $clave - $ins</i>";

		if ($primero == false ){
				if($arrayPersonas[0][3] != ""){
				$primero = true;
					$imprimir .= " | (*) " . $arrayPersonas[0][3];
					}
				}				
				//$imprimir .= "</span>";
			$clave = $clave + 1 ;
		}
	  }

	  if(count($arrayInstitucionesUnicasNuevaClave)==0){

		if($arrayPersonas[0][3] != ""){
			$imprimir .= "(*) " . $arrayPersonas[0][3];
		}		
	}
$imprimir .= "</span>";
$autores = $imprimir;

if($_SESSION["chkMostrarUbicacion"]!="1"){
	$muestroUbicacion = '';
}else{
	$muestroUbicacion = '<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td bgcolor="#FFFF66" align="center" style="padding:10px"><font size="4" face="Arial, Helvetica, sans-serif"><strong>D&iacute;a: '.$dia.'<br />
Hora: '.$hora_inicio.'</strong><br />
<strong>Sala: '.$sala.' </strong></font></td>
  </tr>
</table>
<!--<em>'.$tipoAct .'</em> <strong>'.$titulo.'</strong>--><br /><br />';
}


	$muestroPantalla = '
	<center>
	<div style=" padding:4px; width:900px; background-color:#FFFFFF">
	  <center>
	 	<img src="'.$dirBanner.'"><br><br>
		<p align="left" style="margin-left:45px; margin-right:25px">'.($cartaMail!=""?nl2br($cartaMail)."<div style='border-bottom:1px dashed;margin-top:5px;margin-bottom:10px;width:90%'></div>":"").'</p>
		<div  style="width:90%;">
		  <div align="left"> <font size="4" face="Times New Roman, Times, serif">Trabajo N&ordm;: '.$info->numero_tl.'<br />';
if($Hora_inicio_Trabajo=="00:00"){
	  //$muestroPantalla .= 'Su presentaci&oacute;n dar&aacute; comienzo a las '.$hora_inicio.' horas.<br>';
}else{
	  //$muestroPantalla .='Su presentaci&oacute;n dar&aacute; comienzo a las '.$Hora_inicio_Trabajo.' horas.<br>';
}
$muestroPantalla .= '<em>
			  '.$tipoTL.'
			</em></font> <br>
				<font size="3" face="Times New Roman, Times, serif"><em>
				 '.$trabajos->areaID($info->area_tl)->id.' - '.$trabajos->areaID($info->area_tl)->Area.'
				  </em><br>
				</font> 
                </div>
		</div>
		<div  style="width:90%; padding:5px;">
			<div style="border-bottom:1px dashed;margin-top:5px;margin-bottom:10px;"></div>
		</div>
		<div style="width:90%; padding:5px;"> <font style="font-family: Times New Roman, Times, serif; font-size: 16px;font-weight: bold;">
		 '.$info->titulo_tl.'
		  </font><br>
		  <br>
		  '.$autores.'
		  <br>
		  <br>
		  <div align="justify"> <font style="font-family: Times New Roman, Times, serif; font-size: 12px;">
				';
			if($resumen!=""){
				$muestroPantalla .= $resumen;
			}else{
				$rem = array("<br>","<br />","<br/>");
				$porrem = array("","","");
				$muestroPantalla .= '
					<strong>Introducci&oacute;n y Objetivos:</strong><br />
					'.str_replace($rem,$porrem,$info->antecedentes).'<br /><br />
					<strong>Material y M&eacute;todos</strong><br />
					'.str_replace($rem,$porrem,$info->material).'<br /><br />
					<strong>Conclusiones</strong><br />
					'.str_replace($rem,$porrem,$info->conclusiones).'<br /><br />
					<strong>Referencias bibliogr&aacute;ficas</strong><br />
					'.$info->referencias.'
				';
			}
			$muestroPantalla .='</font><br>
			</div>
		<br />
			<table width="50%" border="0" align="center" cellpadding="2" cellspacing="0"  style="font-size:12px; text-align:center">
			  <tr>
				<td colspan="2"><a href="http://www.ingenieria2014.com.ar/">http://www.ingenieria2014.com.ar/</a></td>
			  </tr>
			 </table>
		</div>
	  </center>
	<br>
	</div> 
	</center><br />';




$mailOBJ->From    		= $mail_congreso;
$mailOBJ->FromName 		= $congreso;
$mailOBJ->Subject 		= utf8_decode("Aceptación de trabajo");
$mailOBJ->IsHTML(true);
$mailOBJ->CharSet = 'iso-8859-1';

$mailOBJ->Timeout=120;

$mails = array($info->mailContacto_tl,"2014ingenieria@gmail.com");
/*if($tieneBanner==true){
	$mailOBJ->AddEmbeddedImage("arhivosMails/banner_mail.jpg",'banner');
}*/
//$mailOBJ->AddAttachment("arhivosMails/" . $_SESSION["arhchivoNombre"], $_SESSION["arhchivoNombre"]);
//$mailOBJ->AddAttachment("abstract/reglamento.pdf","Bases y Convocatorias.pdf");


$mailOBJ->Body  = $muestroPantalla;
date_default_timezone_set('America/Montevideo');

$numero_de_envio = 1;
$fecha = date("d/m/Y H:i");
foreach($mails as $mail){
	$mailOBJ->ClearAttachments();
	$mailOBJ->ClearAddresses();
	$mailOBJ->ClearBCCs();
	$mailOBJ->AddAddress($mail);
	
	$result[] = $mailOBJ->Send();
	
	$sql ="SELECT * FROM trabajos_libres WHERE ID = '".$id."';";
	$que = "[".$fecha."] - [".$numero_de_envio." de ".count($mails)."] ".$mail;
	$rs = mysql_query($sql, $con);
	if($row = mysql_fetch_array($rs)){
		$update = "UPDATE trabajos_libres SET  cartas_aceptacion = '".$row["cartas_aceptacion"]."<br />".$que."' WHERE ID = '".$id."';";
		$rs = mysql_query($update, $con);
	}
	$numero_de_envio++;
}
//echo $muestroPantalla;

if(in_array(1,$result)){
	header("Location: http://www.ingenieria2014.org/programa/altaTrabajosLibres.php?id=".$id);
}else{
	echo "Ocurrio un error.";
}
?>