<?php

session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");


include "../conexion.php";
require "../clases/class.phpmailer.php";
function remplazarArch($cual){
	$cual = utf8_decode($cual);
	$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ ";
	$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn_";
		
	$string = strtr($cual,$tofind,$replac);
		
	return $string;	
}

function sacarComillas($txt){
	$aux = str_replace('"', '´´',$txt);
	$aux = str_replace("'", "´",$aux);
	return $aux;	
}

$mailOBJ = new phpmailer();
$fecha = date("Y-m-d");
if($_POST["email"]!=""){

if ($_FILES['dirFoto']['name']!=""){
	//."_". $_FILES['dirFoto']['name']
	$ext = explode(".",$_FILES['dirFoto']['name']);
	if(strtolower(end($ext))!="jpg" && strtolower(end($ext))!="png" && strtolower(end($ext))!="jpeg" && strtolower(end($ext))!="gif" && strtolower(end($ext))!="tif" && strtolower(end($ext))!="bmp"){
		echo "Solo se admiten archivo en formato: jpg, jpeg, png, gif, tif, bmp.";
		die();
	}
	$nombreArch = $_POST["idPersonaNueva"]."_".$_POST["apellido"]."_foto.".end($ext);
	move_uploaded_file ( $_FILES['dirFoto']['tmp_name'], 'fotos/'.remplazarArch($nombreArch));
	$dirArchFoto='fotos/'.remplazarArch($nombreArch);
}else{
	$dirArchFoto = $_POST["dirFoto_vieja"];
}

if ($_FILES['archivo_cv']['name']!=""){
	//."_". $_FILES['dirFoto']['name']
	$ext = explode(".",$_FILES['archivo_cv']['name']);
	if(strtolower(end($ext))!="pdf"){
		echo "Solo se admiten archivo en formato: pdf.";
		die();
	}
	$nombre_cv = $_POST["idPersonaNueva"]."_".$_POST["apellido"]."_cv.".end($ext);
	move_uploaded_file ( $_FILES['archivo_cv']['tmp_name'], '../cv/'.remplazarArch($nombre_cv));
	$dirArchCv ='cv/'.remplazarArch($nombre_cv);
}else{
	$dirArchCv = $_POST["dirCv_vieja"];
}

if($_POST["compa"]=="No"){
	$nombre_acompa = "";
}else{
	$nombre_acompa = sacarComillas($_POST["nombre_acompa"]);
}


	$sqlInsPers ="UPDATE personas SET 
		profesion = '".safes($_POST["profesion"])."', 
		dirFoto = '".safes($dirArchFoto)."', 
		nombre = '".safes($_POST["nombre"])."', 
		apellido = '".safes($_POST["apellido"])."',  
		email = '".$_POST["email"]."', 
		institucion = '".safes($_POST["institucion"])."', 
		cv = '".safes($_POST["cvAbreviado"])."', 
		actividad_archivo_cv = '".safes($dirArchCv)."', 
		actividad_cv_extendido = '".safes($_POST["curriculum"])."', 
		pais = '".$_POST["pais"]."', 
		ciudad = '".safes($_POST["ciudad"])."', 	
		tel = '".safes($_POST["telefono"])."', 
		actividad_comentarios = '".safes($_POST["comentarios2"])."', 
		actividad_hotel = '".safes($_POST["hotel"])."', 
		actividad_confirma_viene = '".safes($_POST["actividad_confirma_viene"])."', 
		actividad_hotel_in = '".safes($_POST["hotel_in"])."', 
		actividad_hotel_out = '".safes($_POST["hotel_out"])."', 
		actividad_hotel_tiene_acomp = '".safes($_POST["compa"])."', 
		nombre_acompa = '".safes($nombre_acompa)."', 
		actividad_hotel_tiene_portatil = '".safes($_POST["notebook"])."',
		actividad_hotel_compania = '".safes($_POST["comp_ll"])."', 
		actividad_hotel_vuelo = '".safes($_POST["vuelo_ll"])."', 
		actividad_hotel_fecha_llegada = '".safes($_POST["fecha_ll"])."', 
		actividad_hotel_hora = '".safes($_POST["hora_ll"])."', 
		actividad_hotel_partida_compania = '".safes($_POST["comp_sal"])."', 
		actividad_hotel_vuelo_salida = '".safes($_POST["vuelo_sal"])."', 
		actividad_hotel_fecha_salida = '".safes($_POST["fecha_sal"])."', 
		actividad_hotel_hora_salida = '".safes($_POST["hora_sal"])."',
		
		actividad_internacional = '".safes($_POST["actividad_internacional"])."',
		actividad_tienePonenecia = '".safes($_POST["actividad_tienePonenecia"])."',
		actividad_financiado = '".safes($_POST["actividad_financiado"])."',
		confirmacionEncargado = '".safes($_POST["confirmacionEncargado"])."',
		actividad_areas = '".safes($_POST["actividad_areas"])."',
		actividad_categoriaAna = '".safes($_POST["actividad_categoriaAna"])."',
		actividad_idioma_hablado = '".safes($_POST["actividad_idioma_hablado"])."',
		conferencista_invitado = '".safes($_POST["conferencista_invitado"])."'
		
		WHERE ID_Personas = '".safes($_POST["idPersonaNueva"])."';";
		mysql_query($sqlInsPers, $con) or die(mysql_error());
/*ACTUALIZO CONGRESO*/
	$sqlActualizoCongreso = "UPDATE congreso SET 
		Profesion  = '".safes($_POST["profesion"])."', 
		Nombre = '".safes($_POST["nombre"])."', 
		Apellidos = '".safes($_POST["apellido"])."',  
		Institucion = '".safes($_POST["institucion"])."',  
		Pais = '".safes($_POST["pais"])."', 
		Mail = '".safes($_POST["email"])."', 
		Curriculum = '".safes($_POST["curriculum"])."'	
		WHERE ID_persona = '". safes($_POST["idPersonaNueva"])."';";

	mysql_query($sqlActualizoCongreso, $con) or die(mysql_error());
/*ACTUALIZO CONGRESO*/
	
	$pos = safes($_POST["institucion"]);	
	$posIng = safes($_POST["InstitucionIng"]);	
	$prof = safes($_POST["profesion"]);	
	$carg = safes($_POST["cargos"]);	
	
	$sql = "Select Institucion From instituciones Where Institucion = '" . $pos . "';";
	$rs = mysql_query($sql, $con) or die(mysql_error());
	$existeInstitucion = mysql_num_rows($rs);
	if( ($existeInstitucion==0) && ($pos!="") ){	
		$sqlInstitucion = "INSERT INTO instituciones (Institucion) VALUES ('".$pos."');";	
		//echo $sqlInstitucion;
		mysql_query($sqlInstitucion, $con) or die(mysql_error());
	}
	
	$sql = "Select Institucion From instituciones Where Institucion = '" . $posIng . "';";
	$rs = mysql_query($sql, $con) or die(mysql_error());
	$existeInstitucion = mysql_num_rows($rs);
	if( ($existeInstitucion==0) && ($pos!="") ){	
		$sqlInstitucion = "INSERT INTO instituciones (Institucion) VALUES ('".$posIng."');";	
		//echo $sqlInstitucion;
		mysql_query($sqlInstitucion, $con) or die(mysql_error());
	}
	
	

	//$sql = "Select Profesion From profesiones Where Profesion = '" . $prof . "';";
	$sql = "Select Profesion From profesiones Where Profesion = '" . $prof . "';";
	$rs = mysql_query($sql, $con) or die(mysql_error());
	$existeProfesion = mysql_num_rows($rs); 
	if($existeProfesion==0 && $prof!=""){
		$sqlProfesion = "INSERT INTO profesiones (Profesion, Profesion_ing) VALUES ('".$prof."','".$prof."');";	
		mysql_query($sqlProfesion, $con) or die(mysql_error());
	}
	
	$sql = "Select Cargos From cargos Where Cargos = '" . $carg . "';";
	$rs = mysql_query($sql, $con) or die(mysql_error());
	$existeCargos = mysql_num_rows($rs); 
	if($existeCargos==0 && $carg!=""){
		$sqlCargos = "INSERT INTO cargos (Cargos) VALUES ('".$carg."');";	
		mysql_query($sqlCargos, $con) or die(mysql_error());
	}
	
	/*if($_SESSION["LogIn"]=="ok"){
		$sqlDatos ="UPDATE personas SET 
		comentarios = '".sacarComillas($_POST["comentarios"])."', 
		tipoConf = '".$_POST["tipoConf"]."', 
		categoriaAna = '".$_POST["categoriaAna"]."', 
		internacional = '".$_POST["internacional"]."', 
		inscripto = '".$_POST["inscripto"]."', 
		idioma = '".$_POST["idioma"]."',		
		diaHora = '".$_POST["diaHora"]."', 
		tienePonenecia = '".$_POST["tienePonenecia"]."', 
		timePonenecia = '".$_POST["timePonenecia"]."', 
		ponencia = '".$_POST["ponencia"]."', 
		foto = '".$_POST["foto"]."', 
		financiado = '".$_POST["financiado"]."', 
		confirmacionEncargado = '".$_POST["confirmacionEncargado"]."' 
		WHERE ID_Personas = '". $_POST["idPersonaNueva"]."';";
		mysql_query($sqlDatos, $con);
	}*/
	/*if($_POST["vaInter"]=="1"){
		$sqlDates ="UPDATE personas SET 
		comp_ll = '".$_POST["comp_ll"]."', 
		vuelo_ll = '".$_POST["vuelo_ll"]."', 
		fecha_ll = '".$_POST["fecha_ll"]."', 
		hora_ll = '".$_POST["hora_ll"]."', 
		comp_sal = '".$_POST["comp_sal"]."', 
		vuelo_sal = '".$_POST["vuelo_sal"]."', 
		fecha_sal = '".$_POST["fecha_sal"]."', 
		hora_sal = '".$_POST["hora_sal"]."' 
		WHERE ID_Personas = '". $_POST["idPersonaNueva"]."';";		
		mysql_query($sqlDates, $con);
	}*/
		
	
	$idPersonaNueva = $_POST["idPersonaNueva"];
	
	for ($v=1; $v<=$_POST["variable"]; $v++){
		
		//Ponencia
		if ($_FILES['ponencia_file'.$v]['name']!=""){
			//."_". $_FILES['dirFoto']['name']
			$ext = explode(".",$_FILES['ponencia_file'.$v]['name']);
			if(strtolower(end($ext))!="pdf"){
				echo "Solo se admiten archivo en formato: pdf.";
				die();
			}
			$nombrePonencia = $_POST["idPersonaNueva"]."_".$v."_".$_POST["apellido"]."_ponencia.".end($ext);
			move_uploaded_file ( $_FILES['ponencia_file'.$v]['tmp_name'], 'ponencias/'.remplazarArch($nombrePonencia));
			$dirArchPonencia='ponencias/'.remplazarArch($nombreArch);
		}else{
			$nombrePonencia = $_POST["ponencia_vieja".$v];
		}
		
		
			if($_POST["idActiv".$v]!=""){
				$sqlInsTrabajo = "UPDATE actividades SET Titulo = '".str_replace("<br>","",$_POST["Tituloactividad".$v])."' , coment ='".$_POST["coment".$v]."' , confirmado = '".$_POST["confirmado".$v]."',ubicado = '".$_POST["ubicado".$v]."', fecha  = '".$fecha."', Casillero='".$_POST["casilero_".$v]."', archivoPonencia='".$nombrePonencia."' WHERE id = " . $_POST["idActiv".$v];
			}else{
				$sqlInsTrabajo = "INSERT INTO actividades (Titulo ,Casillero, idPersonaNueva, confirmado, ubicado, fecha,coment, 	archivoPonencia )
				VALUES ('".$_POST["Tituloactividad".$v]."', '".$_POST["casilero_".$v]."','".$idPersonaNueva."', '".$_POST["confirmado".$v]."', '".$_POST["ubicado".$v]."', '".$fecha."', '".$_POST["coment".$v]."', '$nombrePonencia');";
			}
			$nombrePonencia = "";
		$consultas .= $sqlInsTrabajo;
		
		mysql_query($sqlInsTrabajo, $con) or die(mysql_error());
	}	


if($_SESSION["LogIn"]=="ok"){	
	header("Location: listado.php");
	die();
}

		$updEntradas = "UPDATE personas SET entradas = ". ($_POST["entradas"] + 1) ." WHERE ID_Personas = " . $idPersonaNueva;
	mysql_query($updEntradas, $con) or die(mysql_error());
$mandarEn = "Espanol";
$qih = "SELECT idioma_hablado FROM personas WHERE ID_Personas = " . $_POST["idPersonaNueva"];
$rqih = mysql_query($qih, $con) or die(mysql_error());
if ($rwqih = mysql_fetch_array($rqih)){
	if ($rwqih["idioma_hablado"] == "Ingles" ){
		$mandarEn = "Ingles";
	}
}
	
if ($mandarEn=='Espanol'){
	$cuerpoMail ='<center>
  <table border="0" cellpadding="0" cellspacing="0">
  <tr><td align="center">
    <table width="800px" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td><img src="http://congresoapu2018.gegamultimedios.net/images/banner.jpg" alt=""></td>
</tr>
<tr><td>
<p align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif"><strong><br>
  SUP 2015 - DATOS PERSONALES</strong></p>
	<table width="800" border="0" align="center" cellpadding="4" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">
	  <tr>
	    <td colspan="4" bgcolor="#AEDCF7" align="center"><em><strong>Datos personales</strong></em></td>
	    </tr>
	  <tr>
		<td bgcolor="#E2F8FE">Profesi&oacute;n: </td>
		<td width="226" bgcolor="#E2F8FE"><strong>'.$_POST["profesion"].'</strong></td>
		<td width="173" bgcolor="#E2F8FE">Mail:</td>
	    <td width="282" bgcolor="#E2F8FE"><strong>'.$_POST["email"].'</strong></td>
	  </tr>
	  <tr>
		<td width="87" bgcolor="#E2F8FE">Nombre:</td>
		<td bgcolor="#E2F8FE"><strong>'.$_POST["nombre"].'</strong></td>
		<td bgcolor="#E2F8FE">Tel&eacute;fono:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["telefono"].'</strong></td>
	  </tr>
	  <tr>
	    <td bgcolor="#E2F8FE">Apellido:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["apellido"].'</strong></td>
	    <td bgcolor="#E2F8FE">Cargo / Instituci&oacute;n Español:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["institucion"].'</strong></td>
	  </tr>
	  <tr>
	    <td bgcolor="#E2F8FE">Pais:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["pais"].'</strong></td>
	    <td bgcolor="#E2F8FE">Ciudad:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["ciudad"].'</strong></td>
	  </tr>
	  <tr>
	    <td bgcolor="#E2F8FE">Comentarios:</td>
	    <td colspan="3" bgcolor="#E2F8FE"><strong>'.$_POST["comentarios2"].'</strong></td>
	    </tr>';
	if ($dirArchFoto != ""){
	  $cuerpoMail .='';
		}
      $cuerpoMail .='</table>
	<br>
<br>

      <table width="800" border="0" align="center" cellpadding="2" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">
	  <tr bgcolor="#FDE1E1">
		<td height="10" colspan="3" bgcolor="#AEDCF7">Curriculum abreviado que se utilizar&aacute; en el momento de su disertaci&oacute;n (80 palabras) </td>
	  </tr>
	  <tr>
		<td height="10" colspan="3" bgcolor="#E2F8FE"><strong>'.$_POST["cvAbreviado"].'</strong></td>
	  </tr>
	  <tr bgcolor="#FDE1E1">
		<td height="10" colspan="3" bgcolor="#AEDCF7">Curriculum extendido</td>
	  </tr>
	  <tr>
		<td height="10" colspan="3" bgcolor="#E2F8FE"><strong>'.$_POST["curriculum"].'</strong></td>
	  </tr>
	  <tr>
		<td colspan="3" height="10"></td>
	  </tr>
      </table>';

$var = 1;
$sqlAct = "SELECT * FROM congreso WHERE ID_persona = '".$idPersonaNueva."' GROUP BY Dia_orden, Hora_inicio, Titulo_de_actividad ORDER BY Dia_orden, Sala, Hora_inicio;";
$rsAct = mysql_query($sqlAct,$con);

$sqlActividad ="SELECT * FROM actividades WHERE idPersonaNueva = '".$idPersonaNueva."' ORDER BY id";
$rsActividad = mysql_query($sqlActividad ,$con);
while($RowA[] = mysql_fetch_array($rsActividad));

$ra = 0;
while($rowAct = mysql_fetch_array($rsAct)){ 
$sqlConf = "SELECT * FROM congreso WHERE Casillero = '".$rowAct["Casillero"]."' ORDER BY Orden_aparicion";
$queryConf = mysql_query($sqlConf,$con);

if($_SESSION["LogIn"]=="ok"){
	header("Location: listado.php");
	die();
}


$cuerpoMail .='

	<table width="800" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td bgcolor="#AEDCF7">&nbsp;</td>
    <td width="473" bgcolor="#AEDCF7">
    <div align="left"><em><strong>Actividad 
      '.$var;
       
       if($rowAct["Tematicas"]!=""){
       		$cuerpoMail .= " <span style='color:#990000'>".$rowAct["Tematicas"]."</span>&nbsp;&nbsp; - &nbsp;&nbsp;";
       } 
       
       if($rowAct["Titulo_de_trabajo"]!=""){
       		$cuerpoMail .= $rowAct["Titulo_de_trabajo"];
       }
$cuerpoMail .='   
    </strong></em></div></td>
    <td colspan="3" align="right" bgcolor="#AEDCF7">
';
    
    if($rowAct["En_calidad"]!=""){
    	$cuerpoMail .= "Rol:";
     } 
 $cuerpoMail .='   
    <strong>'.$rowAct["En_calidad"].'</strong>
   
	</td>
  </tr>
  <tr>
    <td bgcolor="#E2F8FE">&nbsp;</td>
    <td colspan="2" bgcolor="#E2F8FE">
      <div align="left"><strong>
        
        
        D&iacute;a: '.$rowAct["Dia"].'
  &nbsp;&nbsp; </strong><strong>';

	 $sqlVarSal = "SELECT DISTINCT c.Sala, s.Sala_ing FROM congreso c, salas s  WHERE c.ID_persona = '".$idPersonaNueva."' AND c.Dia_orden = '".$rowAct["Dia_orden"]."' AND c.Hora_inicio = '".$rowAct["Hora_inicio"]."' AND c.Titulo_de_actividad = '".$rowAct["Titulo_de_actividad"]."' AND c.Sala_orden = s.Sala_orden ORDER BY c.Sala_orden;";

	$rsVarSal = mysql_query($sqlVarSal ,$con) or die(mysql_error());
	
	$cuerpoMail .= "Sala: ";
	while($rowVarSal = mysql_fetch_array($rsVarSal)){ 
		$cuerpoMail .= $rowVarSal["Sala"];
		$cuerpoMail .= "  ";
	}
$cuerpoMail .= '
    </strong><strong>
      &nbsp;&nbsp;&nbsp;
      Hora: '.substr($rowAct["Hora_inicio"],0,-3)." a ".substr($rowAct["Hora_fin"],0,-3).'
      </strong></div>
      
    </td>
    <td bgcolor="#E2F8FE">&nbsp;</td>
    </tr>
    <tr bgcolor="#FDDBDB">
      <td valign="top" bgcolor="#E2F8FE">&nbsp;</td>
      <td colspan="3" valign="top" bgcolor="#E2F8FE" style="color:#990000"><strong>
        '.str_replace("<br>", " ", $rowAct["Titulo_de_actividad"]).'
      </strong></td>
    </tr>
    <tr bgcolor="#FDDBDB">
      <td valign="top" bgcolor="#E2F8FE">&nbsp;</td>
      <td colspan="3" valign="top" bgcolor="#E2F8FE">';
	  	while($row = mysql_fetch_object($queryConf)){
			$sqlPers = "SELECT * FROM personas WHERE ID_Personas='$row->ID_persona'";
			$queryPers = mysql_query($sqlPers,$con) or die(mysql_error());
			$rowPers = mysql_fetch_object($queryPers);
			
			$cuerpoMail .= "<div style='padding-left:20px;'>";
			$cuerpoMail .= "<span style='color:#403E0B'><strong>".$row->Titulo_de_trabajo."</strong></span>";
			$cuerpoMail .= "<div style='padding-left:20px'>";
					$cuerpoMail .= "$row->En_calidad <strong>".$rowPers->profesion." ".$row->Nombre." ".$row->Apellidos."</strong> <i>$rowPers->pais - $rowPers->institucion</i> <strong>- $rowPers->email</strong>";
				$cuerpoMail .= "</div>";
			$cuerpoMail .= "</div>";
		}
$cuerpoMail .= '        
</td>
      </tr>
    <tr bgcolor="#FDDBDB">
    <td valign="top" bgcolor="#E2F8FE">&nbsp;</td>
    <td colspan="3" valign="top" bgcolor="#E2F8FE">Comentarios:
      '.$RowA[$ra]["coment"].'</td>
    </tr>
  <tr>
    <td width="10" valign="top" bgcolor="#E2F8FE">&nbsp;</td>
    <td colspan="2" valign="top" bgcolor="#E2F8FE">&nbsp;</td>
    <td width="108" colspan="-1" valign="top" bgcolor="#E2F8FE">';
	$Titulo = $rowAct["Titulo_de_actividad"];
$cuerpoMail .= '    
</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E2F8FE">&nbsp;</td>
    <td colspan="3" valign="top" bgcolor="#E2F8FE">';
	
	if($RowA[$ra]["archivoPonencia"]!=""){
		$cuerpoMail .="Ponencia: <strong><a href='ponencias/".$RowA[$ra]["archivoPonencia"]."' target='_blank'>(Ya tiene una ponencia)</a></strong>";
		}
$cuerpoMail .=    "     
    </td>
    </tr>
    </table>
<br />";

$ra++;
$var = $var+1;
}

			$cuerpoMail .='
				</td>
		</tr></table><br><br>
			<br>
	</td></tr></table>
	</center>';
}


if ($mandarEn=='Ingles'){	
	$cuerpoMail ='<center>
  <table width="1000px" border="0" cellpadding="0" cellspacing="0" bgcolor="#005395">
  <tr><td align="center">
    <table width="800px" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td><img src="http://congresoapu2018.gegamultimedios.net/images/banner.jpg" alt=""></td>
</tr>
<tr><td bgcolor="#005395">
<p align="center" style="color:#FFFFFF; font-size:16px; font-family:Arial, Helvetica, sans-serif"><strong>PEDIATRIA 2015 - INGRESO DE ACTIVIDADES </strong></p>
	<table width="800" border="0" align="center" cellpadding="4" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">
	  <tr>
	    <td colspan="4" bgcolor="#AEDCF7" align="center"><em><strong>Personal data</strong></em></td>
	    </tr>
	  <tr>
		<td bgcolor="#E2F8FE">Profession:</td>
		<td width="237" bgcolor="#E2F8FE"><strong>'.$_POST["Profesion"].'</strong></td>
		<td width="177" bgcolor="#E2F8FE">E-Mail:</td>
	    <td width="267" bgcolor="#E2F8FE"><strong>'.$_POST["Mail"].'</strong></td>
	  </tr>
	  <tr>
		<td width="87" bgcolor="#E2F8FE">Names:</td>
		<td bgcolor="#E2F8FE"><strong>'.$_POST["Nombre"].'</strong></td>
		<td bgcolor="#E2F8FE">Phone:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["telefono"].'</strong></td>
	  </tr>
	  <tr>
	    <td bgcolor="#E2F8FE">Surname:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["Apellido"].'</strong></td>
	    <td bgcolor="#E2F8FE">Position / Institution:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["Institucion"].'</strong></td>
	  </tr>
	  <tr>
	    <td bgcolor="#E2F8FE">Country:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["pais"].'</strong></td>
	    <td bgcolor="#E2F8FE">City:</td>
	    <td bgcolor="#E2F8FE"><strong>'.$_POST["Ciudad"].'</strong></td>
	  </tr>
	  <tr>
	    <td bgcolor="#E2F8FE">Comments:</td>
	    <td colspan="3" bgcolor="#E2F8FE"><strong>'.$_POST["comentarios"].'</strong></td>
	    </tr>';
	if ($dirArchFoto != ""){
	  $cuerpoMail .='';
		}
      $cuerpoMail .='</table>
      <br>
      <table width="800" border="0" align="center" cellpadding="3" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif; display:none">
            <tr>
              <td colspan="8" align="center" valign="top" bgcolor="#AEDCF7"><em><strong>Accommodation and transfers</strong></em></td>
            </tr>
            <tr>
              <td width="9%" valign="top" bgcolor="#E2F8FE">HOTEL:</td>
              <td colspan="2" valign="top" bgcolor="#E2F8FE"><strong>'.$_POST["confirmado"].'</strong></td>
              <td colspan="5" valign="top" bgcolor="#E2F8FE">In:<strong> '.$_POST["hotel_in"].'
              </strong>&nbsp;&nbsp;
              Out: <strong>'.$_POST["hotel_out"].'</strong></td>
            </tr>
            <tr>
            <td colspan="5" bgcolor="#E2F8FE"><hr  style="color:#333;"/></td>
      </tr>         
            <tr>
              <td rowspan="2" valign="top" bgcolor="#E2F8FE"><span style="color:#C30; font-weight:bold">ARRIVAL</span></td>
              <td width="13%" valign="top" bgcolor="#E2F8FE">Airline Company:</td>
              <td width="29%" valign="top" bgcolor="#E2F8FE"><strong>'.$_POST["comp_ll"].'</strong></td>
              <td width="12%" valign="top" bgcolor="#E2F8FE">Flight number: </td>
              <td width="37%" valign="top" bgcolor="#E2F8FE"><strong>'.$_POST["vuelo_ll"].'</strong></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#E2F8FE">Date:</td>
              <td valign="top" bgcolor="#E2F8FE"><strong>'.$_POST["fecha_ll"].'</strong></td>
              <td valign="top" bgcolor="#E2F8FE">Time:</td>
              <td valign="top" bgcolor="#E2F8FE"><strong>'.$_POST["hora_ll"].'</strong></td>
            </tr>
            <tr>
              <td colspan="4" align="right" valign="top" bgcolor="#E2F8FE">Need transportation from Ezeiza airport to your HOTEL?</td>
              <td valign="top" bgcolor="#E2F8FE"><strong>';
              if($_POST["transporte"]=="Si"){
              	$cuerpoMail .='Yes';
              }else{
              	$cuerpoMail .='No';
              }
              $cuerpoMail .='</strong></td>
</tr>
</table> ';
 if($traslado_comentario!=""){
$cuerpoMail .='<table width="800" border="0" align="center" cellpadding="3" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">
    <tr>
        <td width="297" valign="top" bgcolor="#E2F8FE">Specify who will be taking care of your transportation:</td>
        <td width="491" bgcolor="#E2F8FE">'.$_POST["traslado_comentario"].'</td>
    </tr>
</table>';
}
$cuerpoMail .='<table width="800" border="0" align="center" cellpadding="3" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif; display:none">
            <tr>
            <td colspan="5" bgcolor="#E2F8FE"><hr  style="color:#333;"/></td>
      </tr>
            <tr>
              <td width="9%" rowspan="2" valign="top" bgcolor="#E2F8FE"><span style="color:#C30; font-weight:bold">DEPARTURE</span></td>
              <td width="13%" valign="top" bgcolor="#E2F8FE">Airline Company:</td>
              <td width="29%" valign="top" bgcolor="#E2F8FE"><strong>'.$_POST["comp_sal"].'</strong></td>
              <td width="12%" valign="top" bgcolor="#E2F8FE">Flight number: </td>
              <td width="37%" valign="top" bgcolor="#E2F8FE"><strong>'.$_POST["vuelo_sal"].'</strong></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#E2F8FE">Date:</td>
              <td valign="top" bgcolor="#E2F8FE"><strong>'.$_POST["fecha_sal"].'</strong></td>
              <td valign="top" bgcolor="#E2F8FE">Time:</td>
              <td valign="top" bgcolor="#E2F8FE"><strong>'.$_POST["hora_sal"].'</strong></td>
            </tr>
            <tr>
              <td colspan="4" align="right" valign="top" bgcolor="#E2F8FE">Need transportation from the HOTEL to Ezeiza airport?
	</td>
              <td valign="top" bgcolor="#E2F8FE"><strong>';
              if($_POST["transporte2"]=="Si"){
              	$cuerpoMail .='Yes';
              }else{
              	$cuerpoMail .='No';
              }
              $cuerpoMail .='</strong></td>
      </tr>
    </table>';
 if($traslado_comentario2!=""){       
$cuerpoMail .='<table width="800" border="0" align="center" cellpadding="3" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">
            <tr>
              <td width="296" valign="top" bgcolor="#E2F8FE">Specify who will be taking care of your transportation:</td>
              <td width="492" bgcolor="#E2F8FE"><strong>'.$_POST["traslado_comentario2"].'</strong></td>
            </tr>
    </table>';
}
$cuerpoMail .='<table width="800" border="0" align="center" cellpadding="3" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif; display:none">
            <tr>
              <td colspan="5" valign="top" bgcolor="#E2F8FE"><hr  style="color:#333;"/></td>
            </tr>
            <tr>
              <td colspan="2" valign="top" bgcolor="#E2F8FE">Traveling with someone?</td>
              <td width="626" colspan="2" valign="top" bgcolor="#E2F8FE"><strong>';
              if($_POST["compa"]=="Si"){
              	$cuerpoMail .='Yes';
              }else{
              	$cuerpoMail .='No';
              }
              $cuerpoMail .='</strong></td>
            </tr>
            </table>';
if($nombre_acompa!=""){
$cuerpoMail .='<table width="800" border="0" align="center" cellpadding="3" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">
    <tr>
        <td width="350" valign="top" bgcolor="#E2F8FE">Provide name and last name of the person you are traveling with
	</td>
        <td width="438" colspan="2" bgcolor="#E2F8FE"><strong>'.$_POST["nombre_acompa"].'</strong></td>
    </tr>
</table>';
}
$cuerpoMail .='<table width="800" border="0" align="center" cellpadding="3" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif; display:none">
            <tr>
              <td width="21%" valign="middle" bgcolor="#E2F8FE">Bringing your own Notebook?</td>
              <td width="79%" colspan="2" valign="middle" bgcolor="#E2F8FE"><strong>'.$_POST["notebook"].'</strong></td>
      </tr>
            <tr>
              <td colspan="3" align="center" valign="middle" bgcolor="#E2F8FE">If you make your presentation using your own <strong>MAC Notebook</strong> please remember to <strong>bring suitable adaptors</strong>.</td>
      </tr>
    </table>
    <br>
      <table width="800" border="0" align="center" cellpadding="2" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">
	  <tr bgcolor="#FDE1E1">
		<td height="10" colspan="3" bgcolor="#AEDCF7">Brief Curriculum</td>
	  </tr>
	  <tr>
		<td height="10" colspan="3" bgcolor="#E2F8FE"><strong>'.$_POST["cvAbreviado"].'</strong></td>
	  </tr>
	  <tr bgcolor="#FDE1E1">
		<td height="10" colspan="3" bgcolor="#AEDCF7">Extended Curriculum</td>
	  </tr>
	  <tr>
		<td height="10" colspan="3" bgcolor="#E2F8FE"><strong>'.$_POST["curriculum"].'</strong></td>
	  </tr>
	  <tr>
		<td colspan="3" height="10"></td>
	  </tr>
      </table>';
		 for ($v=1; $v<=$_POST["variable"]; $v++){
			$cuerpoMail .='
		 <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">
	  <tr>
		<td colspan="3" bgcolor="#E2F8FE"><strong>Activity '.$v.'  - '.str_replace("<br />", " ", $_POST["Tituloactividad".$v]).'</strong></td>
	  </tr></table>';
					if($_POST["Titulotrabajo".$v]!=""){
					$cuerpoMail .='<table width="800" border="0" align="center" cellpadding="4" cellspacing="0" style="color:#000000; font-size:12px; font-family:Arial, Helvetica, sans-serif">
					<tr>
							<td width="70" valign="top" bgcolor="#E2F8FE">Title:</td>
			    <td width="714" colspan="2" bgcolor="#E2F8FE"><strong>'.$_POST["Titulotrabajo".$v].'</strong></td>
							</tr></table>';
					}
					}
			$cuerpoMail .='
				</td>
		</tr></table><br><br>
			<br>
	</td></tr></table>
	</center>';
}

if($_SESSION["LogIn"]=="ok"){
	$arrayMails =  array();
}else{
//	"academica@ingenieria2014.com.ar",
	$arrayMails =  array($_POST["email"]);		
}	
	$mailOBJ->From = "gegamultimedios@gmail.com";
	$mailOBJ->FromName = "SUP 2015";
	$mailOBJ->Subject = "Datos Personales SUP 2015 [".$_POST["idPersonaSistema"]."] ". $_POST["nombre"] ." ".$_POST["apellido"];	
	
	$mailOBJ->IsHTML(true);
	
	$mailOBJ->Timeout=120;
	$mailOBJ->ClearAttachments();
	$mailOBJ->ClearBCCs();
	$mailOBJ->CharSet = "utf8";
	$mailOBJ->Body  = $cuerpoMail;
	
	foreach($arrayMails as $cualMail){  
		//echo "ENTRE AL FOR<br>";
		$mailOBJ->ClearAddresses();
		$mailOBJ->AddAddress($cualMail);
		if(!$mailOBJ->Send()){	
				//echo "No envie<br>";
				echo "Ocurrio un error al enviar el mail";	
		} else {
				//echo "Envie<br>";
				$envioCorrecto = "Se envio mail";	
		}
	}
}
?>
<table align="center" width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#FFFFFF">
  <div style="width:700px; margin:0px auto 0px auto; background-color:#005395" align="center"><img src="../../images/banner.jpg" width="900"/></div>
<h2 style="color:#005395" align="center"> INGRESO DE ACTIVIDADES</h2>
<p style="color:#005395" align="center">Los datos han sido guardados con éxito </p>
  <p align="center"><a href="" target="_self" style="text-decoration:none; color:#005395; font-size:14px"><strong>Volver a la WEB</strong></a></p>
  <? if($_SESSION["LogIn"]=="ok"){?>
	<p align="center"><a href="listado.php" target="_self" style="text-decoration:none; color:#900; font-size:14px"><strong>Volver al listado de conferencistas</strong></a></p>
    <br />&nbsp;
<? }?></td>
  </tr>
</table>

</body>
</html>
<?
if($_SESSION["LogIn"]!="ok"){
	session_destroy();
	session_unset();
}
?>