<?
//$tit_act_sin_hora = "Actividad sin horarios";
//if($row["seExpande"] > 2){
	if(($row["Casillero"] == $row["sala_agrupada"])||($row["sala_agrupada"] == '0')){
 
if($casillero_anterior != $row["Casillero"]){

	echo "<br>";	

	if($dia_anterior != $row["Dia"]){	
		$nomDia = $row["Dia"];
		if ($_GET["idioma"]=="ing"){
			$nomDia = $arrDias[$row["Dia_orden"]];
		}
		echo "</div><br><div id='contenidoDia'><div id='programaLineaDia'><span class='programaLineaDia'>&nbsp;" . remplazar($nomDia) . "&nbsp;</span></div>\n";
		$imprimir .= "<br><p style='background-color: #CCCCCC;font-family: Arial, Helvetica, sans-serif;font-size: 18px;font-weight: bold;color: #000000;text-align: center;margin:0px;' >" . remplazar($nomDia). "</p>\n";
		$dia_anterior = $row["Dia"];
		$arrancaSala=1;		
	}
	
/////////////
	$sql_act = "SELECT * FROM tipo_de_actividad WHERE Tipo_de_actividad ='" . $row["Tipo_de_actividad"] . "';";
	$rs_act = mysql_query($sql_act,$con);
	while ($row_act = mysql_fetch_array($rs_act)){

		if( substr($row_act["Color_de_actividad"], 0 , 1)=="#"){			
			$color_fondo = "background-color:". $row_act["Color_de_actividad"] . ";";		
		}else{		
			$color_fondo = "background:url(img/patrones/". $row_act["Color_de_actividad"] . ");";		
		}
	
	}

	/*No imprimir un <br> en la primera linea despues de la sala*/
	
	
		if($sala_anterior != $row["Sala"] || $arrancaSala==1){
			$nomSala = $row["Sala"];
			$txtTodaslasSalas = "Ver todos los horarios de esta sala en este día";
			if ($_GET["idioma"]=="ing") {
				$nomSala = $arrSalas[$row["Sala_orden"]];
				$txtTodaslasSalas = "View all schedules in this room on this day";
			}
		
		echo "<div id='contenidoSala' ></div><span class='programaLineaSala'>&nbsp;" . remplazar($nomSala);
		
		
		
		
		if($_GET["casillero"]!=""){
			echo "<br><a href='?sala_=".$_GET["sala_"]."&dia_=".$_GET["dia_"]."'>[ ".$txtTodaslasSalas."]</a>";
		}
		
		echo "&nbsp;</span>";
		///
		/***************************** ACA ESTA LO DE INFO SALA ***************************************/
		//if($_SESSION["registrado"] == true  && $_SESSION["tipoUsu"]==1 && $_SESSION["tipoUsu"]!=3){
			$sqlInfoSala = "SELECT * FROM salas WHERE Sala_orden='".$row["Sala_orden"]."';";		
			$rsInfoSala = mysql_query($sqlInfoSala,$con);
			$obsEsp = "";
			$obsIng = "";
			$obsIng2 ="";
			if  ($rowInfoSala = mysql_fetch_array($rsInfoSala)){		
					$laObservacionDeCabecera = $rowInfoSala["Sala_obs"];
					if (($_GET["idioma"]=="ing")&&($rowInfoSala["Sala_obs_ing"]!="")){
						$laObservacionDeCabecera = $rowInfoSala["Sala_obs_ing"];
					}
					
					echo "<div id='infoSala'><span class='programaLineaSala'>".$laObservacionDeCabecera."<br></span></div>";
					$obsIng2 = $rowInfoSala["Sala_obs2_ing"];
					$obsEsp = $rowInfoSala["Sala_obs"];
					$obsPrintIng = $rowInfoSala["Sala_obs_ing"];
				//}
				/*if ( ($rowInfoSala["Sala_obs2"]!="")&& ($_GET["idioma"]!='ing') ){
					echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:12px;margin-bottom:7px;margin-top:4px;text-decoration:none;'>".$rowInfoSala["Sala_obs2"]."<br></div>";
				}
				if ( ($rowInfoSala["Sala_obs2_ing"]!="")&& ($_GET["idioma"]=='ing') ){
					echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:12px;margin-bottom:7px;margin-top:4px;text-decoration:none;'>".$rowInfoSala["Sala_obs2_ing"]."<br></div>";
				}*/
				/**********************************************************************************************/
				/*if ( ($rowInfoSala["ID_Salas"]=="10")&& ($_GET["idioma"]!='ing') && ($_GET["dia_"]=='11') ){
					echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px;font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>El futuro de la ense&ntilde;anza de la Ingenier&iacute;a: Los grandes desaf&iacute;os y los desaf&iacute;os regionales, creatividad y emprendedorismo, aprendizaje por descubrimiento y pr&aacute;ctica, movilidad global y calidad<br></div>";//;Lunes español
				}
				if ( ($rowInfoSala["ID_Salas"]=="10")&& ($_GET["idioma"]=='ing') && ($_GET["dia_"]=='11') ){
					echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px;font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>The Future for Engineering Education: The Grand and Regional Challenges, Creativity and Entrepreneurship, Discovery and Practice Based Learning, and Global Mobility and Quality<br></div>";//lunes ingles
				}*/
				///////////////////////////////////////////////////////
				/*if ( ($rowInfoSala["ID_Salas"]=="10")&& ($_GET["idioma"]!='ing') && ($_GET["dia_"]=='12') ){
					echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px;font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>5.1.-Educaci&oacute;n Activa, Participativa, &eacute;tica y Creativa<br></div>";//martes esp
				}
				if ( ($rowInfoSala["ID_Salas"]=="10")&& ($_GET["idioma"]=='ing') && ($_GET["dia_"]=='12') ){
					echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px;font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>5.1.- Active, Participative, Ethical and Creative Education<br></div>";//martes ing
				}
				if ( ($rowInfoSala["ID_Salas"]=="10")&& ($_GET["idioma"]!='ing') && ($_GET["dia_"]=='13') ){
					echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px;font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>5.3.- Relaci&oacute;n del ingeniero con los sectores nacionales y locales<br></div>";//mie esp
				}
				if ( ($rowInfoSala["ID_Salas"]=="10")&& ($_GET["idioma"]=='ing') && ($_GET["dia_"]=='13') ){
					echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px; font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>5.3.- Link of the Engineer with National and Local Sectors<br></div>";//mie ing
				}	*/
				///////////////////////////////////////////////////////
				/**********************************************************************************************/
			}
		
		
		if ($_GET["idioma"]=="ing") {
			$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;color: #333333; margin:0px;margin-left:40px;'>" . remplazar($nomSala) . "&nbsp;&nbsp;" . $row["Tipo_de_actividad_ing"];
			$imprimir .= "<br>" . $obsPrintIng  . "&nbsp;&nbsp;</p>\n";
		} else {
			$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;color: #333333; margin:0px;margin-left:40px;'>" . remplazar($nomSala) . "&nbsp;&nbsp;" . $row["Tipo_de_actividad"];
			$imprimir .= "<br>" . $obsEsp . "&nbsp;&nbsp;</p>\n";
		}
		$sala_anterior =  $row["Sala"] ;
		$arrancaSala=0;
		
	}
	
	
//if($hora_anterior != $row["Hora_inicio"]){ 

//if($tit_act_sin_hora != $row["Tipo_de_actividad"]){
	if ( ($_GET["sala_"]=="15")&& ($_GET["idioma"]!='ing') && ($_GET["dia_"]=='11') ){
		if (substr($row["Hora_inicio"], 0, -3) == '16:00'){
			echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px;font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>El futuro de la ense&ntilde;anza de la Ingenier&iacute;a: Los grandes desaf&iacute;os y los desaf&iacute;os regionales, creatividad y emprendedorismo, aprendizaje por descubrimiento y pr&aacute;ctica, movilidad global y calidad<br></div>";//;Lunes español
			$imprimir .= "<div style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px;font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>El futuro de la ense&ntilde;anza de la Ingenier&iacute;a: Los grandes desaf&iacute;os y los desaf&iacute;os regionales, creatividad y emprendedorismo, aprendizaje por descubrimiento y pr&aacute;ctica, movilidad global y calidad<br></div>";
		}
	}
	if ( ($_GET["sala_"]=="15")&& ($_GET["idioma"]=='ing') && ($_GET["dia_"]=='11') ){
		if (substr($row["Hora_inicio"], 0, -3) == '16:00'){
			echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px;font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>The Future for Engineering Education: The Grand and Regional Challenges, Creativity and Entrepreneurship, Discovery and Practice Based Learning, and Global Mobility and Quality<br></div>";//lunes ingles
			$imprimir .= "<div style='font-family:Arial,Helvetica,sans-serif;font-size:13px;margin-bottom:7px;font-weight:bold; color:#003399;margin-top:4px;text-decoration:none;'>The Future for Engineering Education: The Grand and Regional Challenges, Creativity and Entrepreneurship, Discovery and Practice Based Learning, and Global Mobility and Quality<br></div>";
		}
	}
	
	if ( ($_GET["sala_"]=="4")&& ($_GET["idioma"]!='ing') && ($_GET["dia_"]=='10') ){
		if (substr($row["Hora_inicio"], 0, -3) == '10:30'){
			echo "<br><span class='programaLineaSala'>&nbsp;CEREMONIA DE APERTURA PROFESIONAL&nbsp;</span><br><br>";
			$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;color: #333333; margin:0px;margin-left:40px;'>&nbsp;CEREMONIA DE APERTURA PROFESIONAL&nbsp;</p><br>";
		}
	}
	if ( ($_GET["sala_"]=="4")&& ($_GET["idioma"]=='ing') && ($_GET["dia_"]=='10') ){
		if (substr($row["Hora_inicio"], 0, -3) == '10:30'){
			echo "<br><span class='programaLineaSala'>&nbsp;PROFESSIONAL OPENING CEREMONY&nbsp;</span><br><br>";
			$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;color: #333333; margin:0px;margin-left:40px;'>&nbsp;PROFESSIONAL OPENING CEREMONY&nbsp;</p><br><br>";
		}
	}


/*	if ( ($_GET["sala_"]=="15")&& ($_GET["idioma"]=='ing') && ($_GET["dia_"]=='12') ){
		if (substr($row["Hora_inicio"], 0, -3) == '15:00'){
			echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px; font-weight:bold; color:#003399; margin-bottom:7px;margin-top:4px;text-decoration:none;'>5.2.- Use of Information and Communication Technologies<br></div>";//martes ing tarde
		}
	}
	if ( ($_GET["sala_"]=="15")&& ($_GET["idioma"]!='ing') && ($_GET["dia_"]=='12') ){
		if (substr($row["Hora_inicio"], 0, -3) == '15:00'){
			echo "<div id='infoSala2' style='font-family:Arial,Helvetica,sans-serif;font-size:13px; font-weight:bold; color:#003399; margin-bottom:7px;margin-top:4px;text-decoration:none;'>5.2.- Uso de las Tecnolog&iacute;as de la Informaci&oacute;n y la Comunicaci&oacute;n<br></div>";//martes esp tarde
		}
	}*/
	

	echo "<div class='hora'  style='position:relative;  $color_fondo; border-top:#999999 solid 1px;'>" . remplazar(substr($row["Hora_inicio"], 0, -3)). " - " . remplazar(substr($row["Hora_fin"],0 , -3));
/*}else{
	echo "<div class='hora' style='position:relative;  $color_fondo; border-top:#999999 solid 1px;'>";
}*/
	if($_SESSION["registrado"] == true  && $_SESSION["tipoUsu"]==1 && $_SESSION["tipoUsu"]!=3){

		echo "<div  align='right' style='position:absolute;top:2px; display:inline;left:630px;  width:100px;'>&nbsp;";

		if($row["sala_agrupada"]!=0){
			echo  "<input type='submit' class='menuEdicion_desagruparSala' alt='Desagrupar Sala' value='' onClick=\"desagrupar_salas('" . $row["sala_agrupada"] . "','0' , '" .$row["Dia"] . "')\"  />";
			$salaAgrupada = 1;
			$queElimino = $row["sala_agrupada"];
		}else{
			$salaAgrupada = 0;
			$queElimino = $row["Casillero"];
		}
		
		echo  "<input type='submit' class='menuEdicion_editar' alt='Modificar este casillero' value='' onClick=\"modificar_casillero('" . $row["Casillero"] . "')\"  />";
		echo  "<input type='submit' class='menuEdicion_eliminar'  alt='Eliminar este casillero' value='' onClick=\"eliminar_casillero('" . $queElimino . "','0','$salaAgrupada')\" />";
		
		echo "</div>";
		
	}
if($tit_act_sin_hora != $row["Tipo_de_actividad"]){
		$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 13px;margin:0px;margin-left:20px;border-bottom:#999999 solid 1px;'>" . substr($row["Hora_inicio"], 0, -3) . " - " . substr($row["Hora_fin"],0 , -3) .  "&nbsp;&nbsp; ";
}else{
	/*$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;margin:0px;margin-left:20px;border-bottom:#999999 solid 1px;'> &nbsp;-&nbsp;";*/
}
		//echo "&nbsp;" .  remplazar($row["Tipo_de_actividad"]) ;
		//especial ing2010
		//$imprimir .=  "<strong>".$row["Tipo_de_actividad"]."</strong>" ;
		$hora_anterior = $row["Hora_inicio"];
//}
//
//
//


	////////////////////
	if($row["Area"] == ""){
		$area= "";
	}else{
		$area = " <strong> | " .$row["Area"] . "</strong>";
	}
	if($row["Tematicas"] == ""){
		$tematica  = "";
	}else{
		$tematica = $row["Tematicas"];
	}
	if($row["Area"] != "" && $row["Tematicas"] != ""){
		$tematica = " - " . $row["Tematicas"];
	}

	if($row["Area"] != "" || $row["Tematicas"] != ""){
		//echo "<span class='area_tematica' style='margin:0px'>" . remplazar($area) . remplazar($tematica) . "</span>\n";
		//especial ing2010
		echo "<span class='area_tematica' style='margin:0px'>" . remplazar($tematica) . "</span>\n";
		//$imprimir .=  "<span style='font-family: Arial, Helvetica, sans-serif;font-size:10px;color: #666666; text-decoration:underline'>" . $area . $tematica . "</span>\n";
		$imprimir .=  "<span style='font-family: Arial, Helvetica, sans-serif;font-size:10px;color: #666666; text-decoration:underline'>"  . $tematica . "</span>\n";
		
	}
	$imprimir .= "</p>\n";
	echo "&nbsp;&nbsp;<a href='programaExtendido.php?casillero=".$row["Casillero"]."&idioma=".$_GET["idioma"]."&sala_=".$row["Sala_orden"]."&dia_=".$row["Dia_orden"]."' >Ver actividad completa</a>";
	echo  "</div>\n";

/*********************************** ACA VA EL COMENTARIO DEL CASILLERO ***************************************/	
if($_SESSION["registrado"] == true  && $_SESSION["tipoUsu"]==1 && $_SESSION["tipoUsu"]!=3){
	echo $row["notaAdmin"];		
}
/**************************************************************************************************************/	


///////////TITULO EN INGLES///////////////
if($_GET["idioma"]=='ing'){
	echo "<p class='titulo_actividad'>" . remplazar($row["Titulo_de_actividad_ing"]) . "</p>\n";
	$imprimir .=  "<p style='font-family: Arial, Helvetica, sans-serif;font-size:16px;color: #660000;font-weight: bold;margin:0px;margin-left:105px;'>" . $row["Titulo_de_actividad_ing"] . "</p>\n";	
}
///////////TITULO EN INGLES///////////////	
if($_SESSION["TitulosIng"]!=1){
	if($_GET["idioma"]!='ing'){
		echo "<p class='titulo_actividad'><em>" . remplazar($row["Titulo_de_actividad"]) . "</em></p>\n";
		$imprimir .=  "<p style='font-family: Arial, Helvetica, sans-serif;font-size:16px;color: #660000;font-weight: bold;margin:0px;margin-left:105px;'><em>" . $row["Titulo_de_actividad"] . "</em></p>\n";
	}
}
	$casillero_anterior = $row["Casillero"];
}

//___________________________________________________________________________________________

if($trabajo_anterior != $row["Titulo_de_trabajo"] && $row["Titulo_de_trabajo"]!=""){
//
	/*if($_GET["idioma"]=='ing'){
		echo "<p class='linea_trabajos'>" . remplazar($row["Titulo_de_trabajo_ing"]) . "</p>\n";
		$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;color: #000066;font-weight: bold;margin:0px;margin-left:105px;'>" . $row["Titulo_de_trabajo_Ing"] . "</p>\n";
	}*/
//}
if($_SESSION["TitulosIng"]!=1){
	if($_GET["idioma"]!='ing'){
		echo "<p class='linea_trabajos'><em>" . remplazar($row["Titulo_de_trabajo"]) . "</em></p>\n";
		$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;color: #000066;font-weight: bold;margin:0px;margin-left:105px;'><em>" . $row["Titulo_de_trabajo"] . "</em></p>\n";
	} else {
		echo "<p class='linea_trabajos'><em>" . remplazar($row["Titulo_de_trabajo_ing"]) . "</em></p>\n";
		$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;color: #000066;font-weight: bold;margin:0px;margin-left:105px;'><em>" . $row["Titulo_de_trabajo_ing"] . "</em></p>\n";
	}	
}
	$trabajo_anterior = $row["Titulo_de_trabajo"];
}

if ($row["Institucion"]!="") {
	$institucion = " - "  . $row["Institucion"];
}else{
	$institucion = "";
}

if ( ($row["Institucion"]!="") && ($_GET["idioma"]=="ing") ){
	$sqlInst = "SELECT * FROM personas Where ID_Personas='".$row["ID_persona"]."';";
	$rsInst = mysql_query($sqlInst, $con);
	if ($rowInst = mysql_fetch_array($rsInst)){
		$institucion = " - "  . $rowInst["institucionIng"];
	}
}

	


if ($row["Pais"]!=""){
	$pais = " ("  . $row["Pais"] . ")";
}else{
	$pais = "";
}

if ($row["En_calidad"]!=""){
	if ($_GET["idioma"]=="ing") {
		$enCalidad = $arrCalidad[$row["En_calidad"]] . " ";
	} else {
		$enCalidad = $row["En_calidad"] . " ";
	}
}else{
	$enCalidad  = "";
}


?>

<script>
	function mostrarDiv(cual){
		if(document.getElementById(cual).style.display=="none"){
			document.getElementById(cual).style.display="block";
			document.getElementById("ver"+cual).innerHTML="<strong><?=$ocRes?></strong>";
			document.getElementById("ver"+cual).style.color="#990000";
		}else{
			document.getElementById(cual).style.display="none";
			document.getElementById("ver"+cual).innerHTML="<strong><?=$verRes?></strong>";
			document.getElementById("ver"+cual).style.color="#666666";
		}
	}
</script>

<?

/*if ($row["Curriculum"]!=""){
	if($_SESSION["registrado"] == true || $verCurriculums == true){
		$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row["Curriculum"] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row["Nombre"]. " " . $row["Apellidos"]. "'></a>";
	}else{
		$curriculum = "";
	}
}else{
	$curriculum = "";
}*/
?>

<?
if ($_GET["idioma"]=="ing") {
	$ocRes = "Hide Resume";
	$verRes = "See Resume";
	$ocCV = "Hide CV";
	$verCV = "See CV";
} else {
	$ocRes = "Ocultar Resumen";
	$verRes = "Ver Resumen";
	$ocCV = "Ocultar CV";
	$verCV = "Ver CV";
}

if( ($row["En_calidad "]!="Moderador")&&($row["En_calidad "]!="Responsable")){
	if ($row["observaciones"]!=""){
		$observaciones = "<span id='verobs".$row["ID_persona"].$row["ID"]."' onclick=\"mostrarDiv('obs".$row["ID_persona"].$row["ID"]."')\"  style='cursor:pointer; width:15%; color:#666666; text-align:right; font:Arial; font-size:10px; z-index:100;'><strong>".$verRes."</strong></span>";
		$observacionesDiv = "<span id='obs".$row["ID_persona"].$row["ID"]."' style='display:none; border:1px; border-color:#000000; border-style:solid; padding:8px; width:95%; margin:auto; text-align:left' class='linea_persona'>".$row["observaciones"]."</span>";
	}else{
		$observaciones  = "";
		$observacionesDiv = "";
	}
}


?>
<script>
	function mostrarDivCV(cual){
		if(document.getElementById(cual).style.display=="none"){
			document.getElementById(cual).style.display="block";
			document.getElementById("cv"+cual).innerHTML="<strong><?=$ocCV?></strong>";
			document.getElementById("cv"+cual).style.color="#990000";
		}else{
			document.getElementById(cual).style.display="none";
			document.getElementById("cv"+cual).innerHTML="<strong><?=$verCV?></strong>";
			document.getElementById("cv"+cual).style.color="#666666";
		}
	}
</script>
<?


$sqlCV = "SELECT * FROM personas WHERE ID_Personas = '".$row["ID_persona"]."';";
$rsCV = mysql_query($sqlCV, $con) or die(mysql_error());
$rowCV = mysql_fetch_array($rsCV);
if($rowCV["actividad_cv_extendido"]!=""){ 
	$curriculum = "<span align='right'  id='cvcurr".$rowCV["ID_Personas"].$row["ID"]."' onclick=\"mostrarDivCV('curr".$rowCV["ID_Personas"].$row["ID"]."')\"  style='cursor:pointer; width:15%; color:#666666; text-align:right; font:Arial; font-size:10px; z-index:100;'><strong>".$verCV."</strong></span>";
	$curriculumDiv = "<span id='curr".$rowCV["ID_Personas"].$row["ID"]."' style='display:none; border:1px; border-color:#000000; border-style:solid; padding:8px; width:95%; margin:auto; text-align:left' class='linea_persona'>".$rowCV["actividad_cv_extendido"]."</span>";
}else{
$curriculum = "";
$curriculumDiv = "";
}

if ($row["Mail"]!=""){
	$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";

	if($_SESSION["registrado"] == true || $verMails== true){
		$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
	}else{
		$mail = "";
	}
}else{
	$mail = "";
}

if($row["En_calidad"]=="" && $row["Profesion"]=="" && $row["Nombre"]=="" && $row["Apellidos"]=="" && $row["Institucion"]=="" && $row["Pais"]==""){
}else{
				
				$Inscripto = "";
				
				if($_SESSION["registrado"] == true){
				
					
					$sqlIns  = "SELECT inscripto FROM personas Where ID_Personas = ".$row["ID_persona"] . " Limit 1";
					$rs_Ins = mysql_query($sqlIns, $con);
					while ($row_Ins= mysql_fetch_array($rs_Ins)){
				
						if ($row_Ins["inscripto"]=="1"){
							$Inscripto = "<img src='img/puntoVerde.png' />&nbsp;";
						}
					}
				
				}
	
	//$country = remplazar($pais);
	$prof = remplazar($row["Profesion"]);
	$country = "(". $row["Pais"] .")";
	if ($_GET["idioma"]=="ing"){
		$prof = $arrProfesion[$row["Profesion"]];
		$country = "(" . $arrCountry[$row["Pais"]] .")";
	}
	
$sqlV = "SELECT * FROM personas WHERE ID_Personas='".$row["ID_persona"]."'";
	$queryV = mysql_query($sqlV,$con) or die(mysql_error());
	$rowV = mysql_fetch_object($queryV);
	$getViene = "";
	if($_SESSION["LogIn"]=="ok"){
		if($rowV->actividad_confirma_viene=="1"){
			$getViene = "<strong style='color:red'>Confirmado</strong>";
		}
	}
					

	echo "<span class='linea_persona' >" . remplazar($enCalidad)  . $Inscripto . $prof . " <b>" . remplazar($row["Nombre"]) . " " . remplazar($row["Apellidos"]) . "</b>" . remplazar($institucion) . "&nbsp;". $country." " .$getViene. $mail ."<div style='text-align:right'>".$observaciones.$curriculum . "</div><center>".$observacionesDiv.$curriculumDiv."</center></span>";


	$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;margin:0px;margin-left:105px;'>" ."<span style='font-size:14px'><strong>". $enCalidad ."</strong>". $prof ."</span>". " <b>" . $row["Nombre"] . " " . $row["Apellidos"] . "</b>" . $institucion ." <span style='font-size:11px'>". $country.  " </span>$getViene</p>\n";
}

	if($row["Trabajo_libre"]==1){
	
		$IDS = $trabajos->selectTL_Casillero($row["Casillero"], $unicosArraysID_TL);
			 while ($row = mysql_fetch_object($IDS)){
				echo "<div id='divTL'>";
				 require "inc/trabajoLibreNuevo.inc.php";
				 echo "</div>";			 
			}
	}
}
//}
?>