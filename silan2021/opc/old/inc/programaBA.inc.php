<?
if(($row["Casillero"] == $row["sala_agrupada"])||($row["sala_agrupada"] == '0')){
	if($casillero_anterior != $row["Casillero"]){
		if($dia_anterior != $row["Dia"]){	
			echo "</div><br><div id='contenidoDia'><div id='programaLineaDia'><span class='programaLineaDia'>&nbsp;" . remplazar($row["Dia"]) . "&nbsp;</span></div>\n";
		$imprimir .= "<br><p style='background-color: #CCCCCC;font-family: Arial, Helvetica, sans-serif;font-size: 18px;font-weight: bold;color: #000000;text-align: center;margin:0px;' >" . ($row["Dia"]) . "</p>\n";
		$dia_anterior = $row["Dia"];
		$arrancaSala=1;		
		}
		if($row["Tipo_de_actividad"]==""){
			$sqlCas = "SELECT Tipo_de_actividad FROM congreso WHERE Casillero = " . $row["Casillero"]. " AND Tipo_de_actividad <> ''";		
			$rsCas = mysql_query($sqlCas, $con);
			while($rowCas = mysql_fetch_array($rsCas)){			
				$tipoActi = ($rowCas["Tipo_de_actividad"]);
				$tipoActParaImp = $rowCas["Tipo_de_actividad"];
			}
		}else{
			$tipoActi = ($row["Tipo_de_actividad"]);
			$tipoActParaImp = $row["Tipo_de_actividad"];
		}	
		if($row["Titulo_de_actividad"]==""){
			$sqlCas = "SELECT Titulo_de_actividad FROM congreso WHERE Casillero = " . $row["Casillero"]. " AND Titulo_de_actividad <> ''";
			$rsCas = mysql_query($sqlCas, $con);
			while($rowCas = mysql_fetch_array($rsCas)){
				$tituloActi = ($rowCas["Titulo_de_actividad"]);
				$tituloActiParaImp = $rowCas["Titulo_de_actividad"];
			}
		}else{
			$tituloActi = ($row["Titulo_de_actividad"]);
			$tituloActiParaImp = $row["Titulo_de_actividad"];
		}	
		$sql_act = "SELECT * FROM tipo_de_actividad WHERE Tipo_de_actividad ='" . $tipoActi . "';";
		$rs_act = mysql_query($sql_act,$con);
		while ($row_act = mysql_fetch_array($rs_act)){
			if( substr($row_act["Color_de_actividad"], 0 , 1)=="#"){			
				$color_fondo = "background-color:". $row_act["Color_de_actividad"] . ";";		
			}else{		
				$color_fondo = "background:url(img/patrones/". $row_act["Color_de_actividad"] . ");";		
			}		
		}	/*No imprimir un <br> en la primera linea despues de la sala*/	
		if($sala_anterior != $row["Sala"] || $arrancaSala==1){		
			echo "<div id='contenidoSala' style='margin-top:16px;'></div><span class='programaLineaSala' >&nbsp;" . remplazar($row["Sala"]);
			$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 14px;font-weight: bold;color: #333333; margin:0px;margin-left:40px;'>" . remplazar($row["Sala"]) . "&nbsp;-&nbsp;<span style='font-size: 12px;'>" . ($tipoActParaImp) . " ". ($row["Tematicas"]) .  "</span></p>\n";
			echo "&nbsp;</span>";		
			$sala_anterior =  $row["Sala"] ;
			$arrancaSala=0;
		}
		echo "<div class='hora' style='position:relative;  $color_fondo; border-top:#999999 solid 1px;'><label style='cursor:pointer' for='".$row["Casillero"]."'><input  type='checkbox' value='".$row["Casillero"]."' id='".$row["Casillero"]."' name='ID_Casilla[]'>" . remplazar(substr($row["Hora_inicio"], 0, -3)). " a " . remplazar(substr($row["Hora_fin"],0 , -3));
		echo "</label><div  align='right' style='top:2px; display:inline;position:absolute;left:485px;  width:100px;'>&nbsp;";
		if($row["sala_agrupada"]!=0){
			echo  "<input type='button' class='menuEdicion_desagruparSala' alt='Desagrupar Sala' value='' onClick=\"desagrupar_salas('" . $row["sala_agrupada"] . "','0' , '" .$row["Dia"] . "')\"  />";
			$salaAgrupada = 1;
			$queElimino = $row["sala_agrupada"];
		}else{
			$salaAgrupada = 0;
			$queElimino = $row["Casillero"];
		}
		echo  "<input type='button' class='menuEdicion_editar' alt='Modificar este casillero' value='' onClick=\"modificar_casillero('" . $row["Casillero"] . "')\"  />";
		echo  "<input type='button' class='menuEdicion_eliminar'  alt='Eliminar este casillero' value='' onClick=\"eliminar_casillero('" . $queElimino . "','0','$salaAgrupada')\" />";
		
		echo "</div>";
		$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;margin:0px;margin-left:20px;border-bottom:#999999 solid 1px;'>" . substr($row["Hora_inicio"], 0, -3) . " a " . substr($row["Hora_fin"],0 , -3) .  "&nbsp;-&nbsp; ";
		echo "&nbsp;<label style='cursor:pointer' for='".$row["Casillero"]."'>" .  remplazar($tipoActi) . "</label></div>\n";	
		$imprimir .=  ($tipoActParaImp) . "</p>\n";
		$hora_anterior = $row["Hora_inicio"];
		if($row["Area"] == ""){
			$area= "";
		}else{
			$area = $row["Area"];
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
			echo "<p class='area_tematica'>" . remplazar($area) . remplazar($tematica) . "</p>\n";
		}
		echo "<p class='titulo_actividad'>" . remplazar($row["Titulo_de_actividad_Ing"]) . "</p>\n";
		$imprimir .=  "<p style='font-family: Arial, Helvetica, sans-serif;font-size:16px;color: #660000;font-weight: bold;margin:0px;margin-left:105px;'>" . ($row["Titulo_de_actividad_Ing"]) . "</p>\n";
		if($_SESSION["TitulosIng"]!=1){
			echo "<p class='titulo_actividad' style='font-size:12px;'>" . remplazar($tituloActi) . "</p>\n";
			$imprimir .=  "<p style='font-family: Arial, Helvetica, sans-serif;font-size:14px;color: #660000;font-weight: bold;margin:0px;margin-left:105px;'><em>" . $tituloActiParaImp . "</em></p>\n";
		}
		$casillero_anterior = $row["Casillero"];
	}

//___________________________________________________________________________________________

if($trabajo_anterior != $row["Titulo_de_trabajo"] && $row["Titulo_de_trabajo"]!=""){
//
	//if($row["Titulo_de_trabajo_Ing"]!=''){
		echo "<p class='linea_trabajos'>" . remplazar($row["Titulo_de_trabajo_Ing"]) . "</p>\n";
		$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;color: #000066;font-weight: bold;margin:0px;margin-left:105px;'>" .($row["Titulo_de_trabajo_Ing"]) . "</p>\n";
	//}
//}
if($_SESSION["TitulosIng"]!=1){
	echo "<p class='linea_trabajos'><em>" . remplazar($row["Titulo_de_trabajo"]) . "</em></p>\n";
	$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;color: #000066;font-weight: bold;margin:0px;margin-left:105px;'><em>" . ($row["Titulo_de_trabajo"]) . "</em></p>\n";
}
	$trabajo_anterior = $row["Titulo_de_trabajo"];
}

if ($row["Institucion"]!=""){
	$institucion = " - "  . $row["Institucion"];
}else{
	$institucion = "";
}

if ($row["Pais"]!=""){
	$pais = " ("  . $row["Pais"] . ")";
}else{
	$pais = "";
}

if ($row["En_calidad"]!=""){
	$enCalidad = $row["En_calidad"] . ": ";
}else{
	$enCalidad  = "";
}

if ($row["Curriculum"]!=""){
	/*if($_SESSION["registrado"] == true || $verCurriculums == true){*/
		$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row["Curriculum"] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row["Nombre"]. " " . $row["Apellidos"]. "'></a>";
	/*}else{
		$curriculum = "";
	}*/
}else{
	$curriculum = "";
}

if ($row["Mail"]!=""){
	$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
/*
	if($_SESSION["registrado"] == true || $verMails== true){
		$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
	}else{
		$mail = "";
	}*/
}else{
	$mail = "";
}


if($row["En_calidad"]=="" && $row["Profesion"]=="" && $row["Nombre"]=="" && $row["Apellidos"]=="" && $row["Institucion"]=="" && $row["Pais"]==""){
}else{
				
				$Inscripto = "";
				
				
				
					
					$sqlIns  = "SELECT inscripto FROM personas Where ID_Personas = ".$row["ID_persona"] . " Limit 1";
					
					$rs_Ins = mysql_query($sqlIns, $con);
					while ($row_Ins= mysql_fetch_array($rs_Ins)){
				
						if ($row_Ins["inscripto"]=="1"){
							$Inscripto = "<img src='img/puntoVerde.png' />&nbsp;";
						}
					}


	echo "<p class='linea_persona'>" . remplazar($enCalidad)  . $Inscripto . remplazar($row["Profesion"]) . " <b>" . remplazar($row["Nombre"]) . " " . remplazar($row["Apellidos"]) . "</b>" . remplazar($institucion) . remplazar($pais) . $curriculum . $mail .  "</p>\n";
	$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;margin:0px;margin-left:105px;'>" . ($enCalidad)  . $Inscripto . ($row["Profesion"]) . " <b>" . ($row["Nombre"]) . " " . ($row["Apellidos"]) . "</b>" . ($institucion) . ($pais) . "</p>\n";
}

	if($row["Trabajo_libre"]==1){
	
		$IDS = $trabajos->selectTL_Casillero($row["Casillero"], $unicosArraysID_TL);
		 while ($row = mysql_fetch_object($IDS)){
				echo "<div id='divTLBA'>";
				 require "inc/trabajoLibreBA.inc.php";
				 echo "</div>";			 
			}
	}
}


//}
?>