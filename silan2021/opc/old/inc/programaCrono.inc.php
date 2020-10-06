<?
//$tit_act_sin_hora = "Actividad sin horarios";
//if($row["seExpande"] > 2){
	if(($row["Casillero"] == $row["sala_agrupada"])||($row["sala_agrupada"] == '0')){
 
if($casillero_anterior != $row["Casillero"]){

	if($dia_anterior != $row["Dia"]){	
		echo "<div class='diaCronoExt'>".utf8_encode($row["Dia"]) . "</div>";
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
		
		echo "<div class='salaCronoExt'>".utf8_encode($row["Sala"])."</div>";
		/*
		if($_GET["casillero"]!=""){
			echo " <a href='?sala_=".$_GET["sala_"]."&dia_=".$_GET["dia_"]."'>[ Ver todos los horarios de esta sala en este día ]</a>";
		}
		
		echo "&nbsp;</span>";
		*/
		
		$sala_anterior =  $row["Sala"] ;
		$arrancaSala=0;
		
	}
	
	
if($hora_anterior != $row["Hora_inicio"]){ 

if($tit_act_sin_hora != $row["Tipo_de_actividad"]){

	echo "<div class='horaCronoExt' style='position:relative;  $color_fondo; border-top:#999999 solid 1px;'>" . remplazar(substr($row["Hora_inicio"], 0, -3)). " a " . remplazar(substr($row["Hora_fin"],0 , -3));
}else{
	echo "<div class='hora' style='position:relative;  $color_fondo; border-top:#999999 solid 1px;'>";
}
	

		echo "&nbsp;" .  remplazar($row["Tipo_de_actividad"]) . "</div>\n";
		$hora_anterior = $row["Hora_inicio"];
}
//
//
//


	////////////////////
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
		echo "<span>" . remplazar($area) . remplazar($tematica) . "</span>\n";
		//$imprimir .=  "<p style='font-family: Arial, Helvetica, sans-serif;font-size:10px;color: #666666;margin:0px;margin-left:105px;'>" . $area . $tematica . "</p>\n";
	}
///////////TITULO EN INGLES///////////////
//if($row["Titulo_de_actividad_Ing"]!=''){
//echo "<span class='titCasCronoExt'>" . remplazar($row["Titulo_de_actividad_Ing"]) . "</span>\n";
	
//	}
///////////TITULO EN INGLES///////////////	
if($_SESSION["TitulosIng"]!=1){
	echo "<div class='titCasCronoExt'>" . remplazar($row["Titulo_de_actividad"]) . "</div>\n";
	
}
	$casillero_anterior = $row["Casillero"];
}

//___________________________________________________________________________________________

if($trabajo_anterior != $row["Titulo_de_trabajo"] && $row["Titulo_de_trabajo"]!=""){
//
	//if($row["Titulo_de_trabajo_Ing"]!=''){
		echo "<div class='trabCronoExt'><em>" . remplazar($row["Titulo_de_trabajo"]) . "</em></div>";
		
	//}
//}
/*
if($_SESSION["TitulosIng"]!=1){
	echo "<br><span class='trabCronoExt'><em>" . remplazar($row["Titulo_de_trabajo_Ing"]) . "</em></span>";
	
}*/
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
	if($_SESSION["registrado"] == true || $verCurriculums == true){
		$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row["Curriculum"] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row["Nombre"]. " " . $row["Apellidos"]. "'></a>";
	}else{
		$curriculum = "";
	}
}else{
	$curriculum = "";
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

	echo "<span class='persCronoExt'>".remplazar($enCalidad)  . $Inscripto . remplazar($row["Profesion"]) . " <b>" . remplazar($row["Nombre"]) . " " . remplazar($row["Apellidos"]) . "</b>" . remplazar($institucion) . remplazar($pais) . $curriculum . $mail ."<br></span>";
	
}
/*
	if($row["Trabajo_libre"]==1){
	
		$IDS = $trabajos->selectTL_Casillero($row["Casillero"], $unicosArraysID_TL);
			 while ($row = mysql_fetch_object($IDS)){
				echo "<div id='divTL'>";
				 require "inc/trabajoLibre.inc.php";
				 echo "</div>";			 
			}
	}
*/

}
//}
?>