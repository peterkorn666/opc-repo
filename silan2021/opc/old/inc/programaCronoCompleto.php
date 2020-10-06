<?

if ($_GET["idioma"]=='ing'){
	$txtTodosLosIdiomas = "View All times in this room on this day";
} else {
	$txtTodosLosIdiomas = "Ver todos los horarios de esta sala en este d&iacute;a";
}


//$tit_act_sin_hora = "Actividad sin horarios";
//if($row["seExpande"] > 2){
	$seVe = true;
	if(!$_SESSION["registrado"]){
		if($row["Dia_orden"]==5){
			$seVe = false;
		}
	}else{
		$seVe = true;
	}
	if(($row["Casillero"] == $row["sala_agrupada"])||($row["sala_agrupada"] == '0') and $seVe){
 
if($casillero_anterior != $row["Casillero"]){

	echo "<br>";

	if($dia_anterior != $row["Dia"]){	
		echo "</div><br><div id='contenidoDia'>
		<div align='right' style='color:gray;font-size:13px'>&nbsp;" . $traductor->nombreDia($row["Dia_orden"]) . " - \n";
		$imprimir .= "<br><p style='background-color: #CCCCCC;font-family: Arial, Helvetica, sans-serif;font-size: 18px;font-weight: bold;color: #000000;text-align: center;margin:0px;' >" .  $traductor->nombreDia($row["Dia_orden"]). "</p>\n";
		$dia_anterior = $row["Dia"];
		$arrancaSala=1;		
	}
	
	$sql_act = "SELECT * FROM tipo_de_actividad WHERE Tipo_de_actividad ='" . $row["Tipo_de_actividad"] . "';";
	$rs_act = mysql_query($sql_act,$con);
	while ($row_act = mysql_fetch_array($rs_act)){
		$traductor->setTipo_de_actividad($row_act);
		if( substr($row_act["Color_de_actividad"], 0 , 1)=="#"){			
			$color_fondo = "background-color:". $row_act["Color_de_actividad"] . ";";		
		}else{		
			$color_fondo = "background:url(img/patrones/". $row_act["Color_de_actividad"] . ");";		
		}
	}

	/*No imprimir un <br> en la primera linea despues de la sala*/
	
		if($sala_anterior != $row["Sala"] || $arrancaSala==1){
		
		echo "<span class='programaLineaSala'>&nbsp;" . remplazar($traductor->nombreSala($row["Sala_orden"]));
		
		
		
		echo " - </span>";
		
		$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 14px;font-weight: bold;color: #333333; margin:0px;margin-left:40px;'>" . remplazar($traductor->nombreSala($row["Sala_orden"])). "</p>\n";
		$sala_anterior =  $row["Sala"] ;
		$arrancaSala=0;		
	}	
if(($traductor->getTipo_de_actividad()=="Curso sin hora")||($traductor->getTipo_de_actividad()=="Registro sin hora")){
		echo "<div class='hora' style='position:relative; border-top:#999999 solid 1px;'>&nbsp;";
	}else{
		echo  remplazar(substr($row["Hora_inicio"], 0, -3)). " a " . remplazar(substr($row["Hora_fin"],0 , -3));
	}


if($tipoActividad != $traductor->getTipo_de_actividad()){
	if(($traductor->getTipo_de_actividad()=="Curso sin hora")||($traductor->getTipo_de_actividad()=="Registro sin hora")){
		echo "&nbsp;";
		$imprimir .=  "&nbsp;" ;		
	}else{
		echo " / " .  remplazar($traductor->getTipo_de_actividad()) ;
		$imprimir .=  "<strong>".$traductor->getTipo_de_actividad()."</strong>" ;
	}
	
}
echo "</div>";
$hora_anterior = $row["Hora_inicio"];
$tipoActividad = $traductor->getTipo_de_actividad();

	if($row["Area"] == ""){
		$area= "";
	}else{
		$area = " <strong> | " .$row["Area"] . "</strong>";
	}
	if($row["Tematicas"] == ""){
		$tematica  = "";
	}else{
	//	$tematica = $row["Tematicas"];
	}
	if($row["Area"] != "" && $row["Tematicas"] != ""){
		//$tematica = " - " . $row["Tematicas"];
	}

	if($row["Area"] != "" || $row["Tematicas"] != ""){
		echo "<span class='area_tematica' style='margin:0px'>" . remplazar($trabajos->areaID($area)->Area) . remplazar($tematica) . "</span>\n";
		$imprimir .=  "<span style='font-family: Arial, Helvetica, sans-serif;font-size:10px;color: #666666; text-decoration:underline'>" . $trabajos->areaID($area)->Area . $tematica . "</span>\n";
		
	}
	$imprimir .= "</p>\n";
	if ($_SESSION["buscar"]){
	echo "&nbsp;&nbsp;<a href='programaExtendido.php?casillero=".$row["Casillero"]."&idioma=".$_GET["idioma"]."&sala_=".$row["Sala_orden"]."&dia_=".$row["Dia_orden"]."' >Ver actividad completa</a>";
	}



	echo "<em class='titulo_actividad'>" . $row["Titulo_de_actividad"] . "</em>\n";
	echo "<div style='color: gray;font-size: 12px;margin-left: 11px;'>".$row["resumen_actividad"]."</div>";
	$imprimir .=  "<p style='font-family: Arial, Helvetica, sans-serif;font-size:16px;color: #3F548B;font-weight: bold;margin:0px;margin-left:105px;'><em>" . $row["Titulo_de_actividad"] . "</em></p>\n";
	$casillero_anterior = $row["Casillero"];
}

//___________________________________________________________________________________________

//if(/*$trabajo_anterior != $row["Titulo_de_trabajo"] &&*/ $row["Titulo_de_trabajo"]!=""){
		
if($row["Titulo_de_trabajo"]!=""){

	if(substr($row["Titulo_de_trabajo"],0,3)=="@@@"){
		$margen="120";
		$margen_imp="145";
		$margen_persona="190";
	}else{

		$margen="35";
		$margen_imp="105";
		$margen_persona="80";
	}
	echo "<p class='linea_trabajos' style='margin-left:".$margen."px;'>" . str_replace("<br>","<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",str_replace("@@@","",$row["Titulo_de_trabajo"])) . "</p>\n";
	$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;color: #000066;font-weight: bold;margin-left:105px;margin-bottom:1px;'>" . str_replace("<br>","<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",str_replace("@@@","",$row["Titulo_de_trabajo"]))  . "</p>\n";
	$trabajo_anterior = $row["Titulo_de_trabajo"];
	
}

if ($row["Institucion"]!=""){
	$institucion = $row["Institucion"];
}else{
	$institucion = "";
}

/*if ($row["Pais"]!=""){
	$pais = " ("  . $row["Pais"] . ")";
}else{
	$pais = "";
}*/
//$pais = $traductor->getPais($row['Pais']);
$pais = ($row['Pais']!=""?"<i>(".$row["Pais"].")</i>":"");

/*if ($row["En_calidad"]!=""){
	$enCalidad = $row["En_calidad"] . ": ";
}else{
	$enCalidad  = "";
}*/

$enCalidad  = $traductor->enCalidad($row["En_calidad"]);
if ($_GET["idioma"]=="ing") {
	$ocRes = "Hide Resume";
	$verRes = "See Resume";
	$ocCV = "Hide CV";
	$verCV = "See CV";
} else {
	$ocRes = "Ocultar Resumen";
	$verRes = "Ver Resumen";
	$ocCV = " - Ocultar CV";
	$verCV = " - Ver CV";
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
if($row["En_calidad"]!=""){
	if (($row["observaciones"]!="")&&($row["observaciones"]!=" ")){
		//$observaciones = "<span id='verobs".$row["ID_persona"].$row["ID"]."' onclick=\"mostrarDiv('obs".$row["ID_persona"].$row["ID"]."')\"  style='cursor:pointer; width:15%; color:#003399; text-align:right; font:Arial; font-size:10px'><strong>".$verRes."</strong></span>";
		$observacionesDiv = "<span id='obs".$row["ID_persona"].$row["ID"]."' style='display:block; padding-bottom:5px; width:95%; margin:auto' class='linea_persona'>".$row["observaciones"]."</span>";
	}else{
		$observaciones  = "";
		$observacionesDiv = "";
	}
}else{
		$observaciones  = "";
		$observacionesDiv = "";
	
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
$rsCV = mysql_query($sqlCV, $con);
$rowCV = mysql_fetch_array($rsCV);
if($rowCV["actividad_cv_extendido"]!=""){
	$curriculum = "<span id='cvcurr".$rowCV["ID_Personas"].$row["ID"]."' onclick=\"mostrarDivCV('curr".$rowCV["ID_Personas"].$row["ID"]."')\"  style='cursor:pointer; width:15%; color:#003399; text-align:right; font:Arial; font-size:10px'><strong>".$verCV."</strong></span>";
	$curriculumDiv = "
		<span id='curr".$rowCV["ID_Personas"].$row["ID"]."' style='display:none; border:1px; border-color:#000000; border-style:solid; padding:8px; width:95%; margin:auto' class='linea_persona'>
			<div style='width:95%;float:left'>
				".$rowCV["actividad_cv_extendido"]."
			</div>";
			if(!empty($rowCV["archivo_cv"]))
			{
				$curriculumDiv .= "
				<div style='width:5%;float:left;text-align:right'>
					<a href='".$rowCV["archivo_cv"]."' target='_blank'><img src='img/logo_curriculum.gif'></a>
				</div>";
			}
			$curriculumDiv .= "
			<div style='clear:both'></div>
		</span>";
}else{
$curriculum = "";
$curriculumDiv = "";
}
/*
if ($row["Curriculum"]!=""){
	if($_SESSION["registrado"] == true || $verCurriculums == true){
		$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row["Curriculum"] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row["Nombre"]. " " . $row["Apellidos"]. "'></a>";
	}else{
		$curriculum = "";
	}
}else{
	$curriculum = "";
}*/

if ($row["Mail"]!=""){
	//$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";

	if($_SESSION["registrado"] == true || $verMails== true){
	//	$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
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
	//if($_SESSION["registrado"] == true){	

$sqlV = "SELECT * FROM actividades WHERE idPersonaNueva='".$row["ID_persona"] ."' AND Casillero='".$row["Casillero"]."'";
$queryV = mysql_query($sqlV,$con) or die(mysql_error());
$rowV = mysql_fetch_object($queryV);
$getViene = "";
if($_SESSION["LogIn"]=="ok"){
	if($rowV->confirmado=="1"){
		$getViene = "<strong style='color:red'>Confirmado</strong>";
	}
}


		echo "<div class='linea_persona' style='z-index:100;margin-left:70px'>" . 
		"<span style='font-size:11px; display:block; float:left; width:110px;'>".remplazar($enCalidad)."</span> "  . $Inscripto . 
		" <b style='font-size:14px'>" . remplazar($row["Nombre"]) . " " . remplazar($row["Apellidos"]) . "</b> " . remplazar($pais). " " .$curriculum." ".$observaciones;
		if(!empty($institucion))
		{
		echo "<div style='font-size:11px; margin-left:110px;'>".
				remplazar($institucion) .  "
		  	</div>";
		}
		echo "&nbsp;" ." ".$getViene . $mail ."&nbsp;&nbsp;&nbsp; " . "<br />".$observacionesDiv.$curriculumDiv."<div style='clear:both'></div></div>\n";
		
//		echo "<p class='linea_persona' style='z-index:100'>" . remplazar($enCalidad)  . $Inscripto . remplazar($row["Profesion"]) . " <b>" . remplazar($row["Nombre"]) . " " . remplazar($row["Apellidos"]) . "</b>" .  "&nbsp;" . remplazar($institucion) .  "&nbsp;" . remplazar($pais) . $mail ."&nbsp;&nbsp;&nbsp;".$observaciones." ".$curriculum . "<br />".$observacionesDiv.$curriculumDiv."</p>\n";
	//}
	$margenpersona = "";
	if($row["Titulo_de_trabajo"]){
		$margenpersona = "margin-top:1px;";
	}
	$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px; $margenpersona margin-left:105px;'>" . $enCalidad .  " <b>" . $row["Nombre"] . " " . $row["Apellidos"] . "</b>" ."&nbsp;" . $institucion ."&nbsp;" . $pais ." $getViene</p>\n";
//	$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;margin:0px;margin-left:105px;'>" . $enCalidad . $row["Profesion"] . " <b>" . $row["Nombre"] . " " . $row["Apellidos"] . "</b>" ."&nbsp;" . $institucion ."&nbsp;" . $pais .  "</p>\n";
}

	if($row["Trabajo_libre"]==1){
	
		$IDS = $trabajos->selectTL_Casillero($row["Casillero"], $unicosArraysID_TL,$row["orden_tl"]);
			 while ($row = mysql_fetch_object($IDS)){
				echo "<div id='divTL'>";
					$r = true;
				 require "inc/trabajoLibreNuevo.inc.php";
				 echo "</div>";			 
			}
	}
}
//}
//

if($cantidadPersonasCongreso==$pers || $row["Trabajo_libre"] && $casillero_anterior2 != $row["Casillero"]){
	echo "<div style='clear:both'></div>";
if($_GET["casillero"]!=""){
			//echo " <a href='programaExtendido.php?idioma=".$_GET["idioma"]."&sala_=".$_GET["sala_"]."&dia_=".$_GET["dia_"]."' target='_blank'>[ $txtTodosLosIdiomas ]</a>";
}

		echo "<div  align='right' style='float:right'>&nbsp;";
		echo "<div style='margin-right:60px; float:left'><a href='javascript:void(0)' class='cerrar_pop_ext'>cerrar</a></div>";
		echo "<div style='float:right'>";
			if($_SESSION["registrado"] == true  && $_SESSION["tipoUsu"]==1)
			{
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
			}
		echo "</div>";
		echo "<div style='clear:both'></div>";
		echo "</div>";

	
}

?>