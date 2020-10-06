<?
if(($row["Casillero"] == $row["sala_agrupada"])||($row["sala_agrupada"] == '0')){
	if($casillero_anterior != $row["Casillero"]){
		if($dia_anterior != $row["Dia"]){
			$imprimir .= "<br><div style='background-color: #CCCCCC;font-family: Arial, Helvetica, sans-serif;font-size: 18px;font-weight: bold;color: #000000;text-align: center;margin:0px;' >" .  $traductor->nombreDia($row["Dia_orden"]) . "</div>\n";
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
	/*No imprimir un  en la primera linea despues de la sala*/	
		if($sala_anterior != $row["Sala"] || $arrancaSala==1){		
			if($_GET["casillero"]!=""){
			}
			$imprimir .= "<div style='font-family: Arial, Helvetica, sans-serif;font-size: 14px;font-weight: bold;color: #333333; margin:0px;margin-left:0px;'>Sala: " . $traductor->nombreSala($row["Sala_orden"]). "</div>";
			$sala_anterior =  $row["Sala"] ;
			$arrancaSala=0;
		}
		if($_SESSION["registrado"] == true  && $_SESSION["tipoUsu"]==1){
			if($row["sala_agrupada"]!=0){
				$salaAgrupada = 1;
				$queElimino = $row["sala_agrupada"];
			}else{
				$salaAgrupada = 0;
				$queElimino = $row["Casillero"];
			}
		}
		if($tit_act_sin_hora != $row["Tipo_de_actividad"]){
			if($_SESSION["incPrograma"]!="es"){
				$separador = "to";
			}else{
				$separador = "a";
			}
			$separador = "a";
			$imprimir .= "<br><div style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;margin:0px;margin-left:20px;border-bottom:#999999 solid 1px;'><strong>" . substr($row["Hora_inicio"], 0, -3) . " ".$separador." " . substr($row["Hora_fin"],0 , -3) .  "&nbsp;-&nbsp;</strong> ";
			
		}else{
			$imprimir .= "<div style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;margin:0px;margin-left:20px;border-bottom:#999999 solid 1px;'> &nbsp;-&nbsp;";
		}
		$imprimir .=  "<strong>".$traductor->getTipo_de_actividad()."</strong>" ;
		$hora_anterior = $row["Hora_inicio"];
		if($row["Area"] == ""){
			$area= "";
		}else{
			$area = " <strong> | " .$row["Area"] . "</strong>";
		}
		if($row["Tematicas"] == ""){
			$tematica  = "";
		}else{
			//$tematica = $row["Tematicas"];
		}
		if($row["Area"] != "" && $row["Tematicas"] != ""){
		//	$tematica = " - " . $row["Tematicas"];
		}
		if($row["Area"] != "" || $row["Tematicas"] != ""){
			$imprimir .=  "<span style='font-family: Arial, Helvetica, sans-serif;font-size:10px;color: #666666; text-decoration:underline'>" . $area . $tematica . "</span>\n";		
		}
		$imprimir .= "</div>";
		$imprimir .=  "<div style='font-family: Arial, Helvetica, sans-serif;font-size:16px;color: #660000;font-weight: bold;margin:0px;margin-left:105px;'><em>" . str_replace("<br>","",$traductor->getTitulo_de_actividad()) . "</em></div>\n";
		$casillero_anterior = $row["Casillero"];
	}
//___________________________________________________________________________________________
//$trabajo_anterior != $row["Titulo_de_trabajo"] && 
	if($row["Titulo_de_trabajo"]!=""){
		$imprimir .= "<div style='font-family: Arial, Helvetica, sans-serif;font-size:12px;color: #000066;font-weight: bold;margin:0px;margin-left:105px;margin-top:8px'>" . $traductor->getTitulo_de_trabajo()  . "</div>";
		$trabajo_anterior = $row["Titulo_de_trabajo"];
	}
	if ($row["Institucion"]!=""){
		$institucion = " - "  . $row["Institucion"];
	}else{
		$institucion = "";
	}
	$pais = $traductor->getPais($row['Pais']);
	$enCalidad  = $traductor->enCalidad($row["En_calidad"]);
	if ($row["Curriculum"]!=""){
		if($_SESSION["registrado"] == true || $verCurriculums == true){
			//$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row["Curriculum"] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row["Nombre"]. " " . $row["Apellidos"]. "'></a>";
		}else{
			$curriculum = "";
		}
	}else{
		$curriculum = "";
	}
	if ($row["Mail"]!=""){
		if($_SESSION["registrado"] == true && $verMails== true){
			$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='".$programaOnline."img/logo_mail.gif' border='0' title='Enivar mail a esta persona'></a>";
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
					//$Inscripto = "<img src='img/puntoVerde.png' />&nbsp;";
				}
			}
		}
		$imprimir .= '<div style="font-size:12px;margin:0px;margin-left:105px;">'.$enCalidad.'<b>'.$row["Nombre"].' '.$row["Apellidos"] . '</b>' . ' '.$institucion.' '.$pais.' '.$mail.'</div>';
	}
}
?>