<?
$abre ="&lt;";
$cierra = "&gt;";

$espacio = "&nbsp;";
$normal =  $abre."P".$cierra;
$negrita = $abre."b".$cierra;
$cursiva = $abre ."i" . $cierra;
$subrayado = $abre ."u" . $cierra;

$negritaA = $abre . "negrita" . $cierra;
$negritaB = $abre . "/negrita" . $cierra;
$supA = $abre . "sup" . $cierra;
$supB= $abre . "/sup" . $cierra;

function nodo($cual){

	$abre ="&lt;";
	$cierra = "&gt;";

	$nodo = $abre . $cual . $cierra;

	return $nodo;

}

function remplazar($cual){

	$amperson = "&amp;";

	//borro todo lo feo
	$cual = str_replace("<p>", "" , $cual);
	$cual = str_replace("</p>", "<br>" , $cual);
	$cual = str_replace('<p class="MsoBodyText3">', "" , $cual);
	$cual = str_replace('<p class="MsoBodyText2">', "" , $cual);
	
	$cual = str_replace('<p class="MsoNormal">', "" , $cual);
	$cual = str_replace('<p class="MsoNormal">', "" , $cual);

	$cual = str_replace('<h2>', "" , $cual);
	$cual = str_replace('</h2>', "" , $cual);

	$cual = str_replace('<span>', "" , $cual);
	$cual = str_replace('</span>', "" , $cual);

	$cual = str_replace('<a name="OLE_LINK2">', "" , $cual);
	$cual = str_replace('<a>', "" , $cual);
	$cual = str_replace('</a>', "" , $cual);
	$cual = str_replace(' & ', " ".$amperson."amp; " , $cual);
	//
	//
	//modifico etiquetas buenas////////////////////////

/*	$cual = str_replace('<br />', "[[|br /|]]" , $cual);

	$cual = str_replace('<br>', "[[|br /|]]" , $cual);

	$cual = str_replace('<sup>', "[[|sup|]]" , $cual);
	$cual = str_replace('</sup>', "[[|/sup|]]" , $cual);

	$cual = str_replace('<sub>', "[[|sub|]]" , $cual);
	$cual = str_replace('</sub>', "[[|/sub|]]" , $cual);

	$cual = str_replace('<em>', "[[|em|]]" , $cual);
	$cual = str_replace('</em>', "[[|/em|]]" , $cual);

	$cual = str_replace('<strong>', "[[|strong|]]" , $cual);
	$cual = str_replace('</strong>', "[[|/strong|]]" , $cual);

	$cual = str_replace('<b>', "[[|b|]]" , $cual);
	$cual = str_replace('</b>', "[[|/b|]]" , $cual);

	$cual = str_replace('<table ', "[[|table|]]" , $cual);
	$cual = str_replace('<table', "[[|table|]]" , $cual);
	$cual = str_replace('</table>', "[[|/table|]]" , $cual);

	$cual = str_replace('<tr>', "[[|tr|]]" , $cual);
	$cual = str_replace('</tr>', "[[|/tr|]]" , $cual);

	$cual = str_replace('<td>', "[[|td|]]" , $cual);
	$cual = str_replace('</td>', "[[|/td|]]" , $cual);
	*/
	//
	
	

	//$cual = str_replace(" & ", (" " . $amperson . "amp; ") , $cual);
	//$cual = str_replace("&", ($amperson . "amp;") , $cual);
	
	//relpazo solo los cos coyetes: < y >
	$cual = str_replace('<', "&lt;" , $cual);
	$cual = str_replace('>',  "&gt;" , $cual);
	//
	//$cual = str_replace('&lt;', $amperson . "lt;" , $cual);
	//$cual = str_replace('&gt;', $amperson . "gt;" , $cual);
	// "
	$cual = str_replace("&ldquo;", ($amperson . "quot;"), $cual);
	$cual = str_replace("&rdquo;", ($amperson . "quot;"), $cual);
	//'
	$cual = str_replace("&lsquo;", ($amperson . "apos;"), $cual);
	$cual = str_replace("&rsquo;", ($amperson . "apos;"), $cual);
	// -
	$cual = str_replace("&ndash;", "-", $cual);
	//
	$cual = str_replace($amperson . "mu;", "&mu;", $cual);


	$cual = str_replace("'", ($amperson . "apos;") , $cual);
	$cual = str_replace('"', ($amperson . "quot;") , $cual);

	//$cual = str_replace('<', ($amperson . "lt;") , $cual);
	//$cual = str_replace('>', ($amperson . "gt;") , $cual);


	//desemplazo etiqueas html

	//modifico etiquetas buenas////////////////////////

/*	$cual = str_replace("[[|br /|]]" , '<br />', $cual);

	$cual = str_replace("[[|sup|]]" , '&lt;sup&gt;', $cual);
	$cual = str_replace("[[|/sup|]]" , '&lt;/sup&gt;', $cual);

	$cual = str_replace("[[|sub|]]" , '&lt;sub&gt;', $cual);
	$cual = str_replace("[[|/sub|]]" , '&lt;/sub&gt;', $cual);

	$cual = str_replace("[[|em|]]" , '&lt;em&gt;', $cual);
	$cual = str_replace("[[|/em|]]" , '&lt;/em&gt;', $cual);

	$cual = str_replace("[[|strong|]]" , '&lt;strong&gt;', $cual);
	$cual = str_replace("[[|/strong|]]" , '&lt;/strong&gt;', $cual);

	$cual = str_replace("[[|b|]]" , '&lt;strong&gt;', $cual);
	$cual = str_replace("[[|/b|]]" , '&lt;/strong&gt;', $cual);

	$cual = str_replace( "[[|table|]]" , "<br>" . nodo("TABLA"), $cual);
	$cual = str_replace( "[[|/table|]]" , nodo("/TABLA"), $cual);

	$cual = str_replace("[[|tr|]]" , '######', $cual);
	$cual = str_replace("[[|/tr|]]" , '#####', $cual);

	$cual = str_replace("[[|td|]]" ,  '#####', $cual);
	$cual = str_replace("[[|/td|]]" ,  '#####', $cual);*/


		//
	
	
	return $cual;

}

echo nodo('?xml version="1.0" encoding="utf-8"?');


echo "<br>" . nodo("root");

include("../conexion.php");
	//SUCS
	//$sql = "SELECT * FROM congreso WHERE Tipo_de_actividad<>'Posters' ORDER by Dia_orden,Sala_orden,Hora_inicio;";
	
	//Programa
	$sql = "SELECT * FROM congreso WHERE Dia_orden<>'5' ORDER by Dia_orden,Sala_orden,Hora_inicio,Orden_aparicion;";
	
	
/* Posters*/
	//$sql = "SELECT * FROM congreso WHERE Tipo_de_actividad='Posters' ORDER by Dia_orden;";

$rs = mysql_query($sql,$con);
$diaUp = 0;
while ($row = mysql_fetch_array($rs)){
if($row["Tipo_de_actividad"]==""){}else{
	
	if($dia_anterior != $row["Dia"]){
		$sqlDias = "SELECT * FROM dias WHERE Dia='".$row["Dia"]."'";
		$queryDias = mysql_query($sqlDias,$con) or die(mysql_error());
		$rowDias = mysql_fetch_array($queryDias);
		echo  "<br>" . nodo("dia") . $row["Dia"] . nodo("/dia") ;
		$dia_anterior = $row["Dia"];
		$diaUp = 0;
		
		if($diaUp==0){
			echo " " ;
		}else{
			echo "<br>" ;
		}
		$diaUp = $diaUp+1;
	}

	/**/
	/*if($hora_anterior != $row["Hora_inicio"]){
		/*if($casillero_anterior1 != $row["Casillero"]){	
			echo  "<br>" . nodo("dia") . $row["Dia"] . nodo("/dia") . "@@@" ;
		}
		
		
			echo "<br />".nodo("Hora"). substr($row["Hora_inicio"], 0, -3). " a " . substr($row["Hora_fin"],0 , -3). nodo("/Hora") ;
			
			$casillero_anterior1 = $row["Casillero"];
			$hora_anterior = $row["Hora_inicio"];
			
			if($row["Tipo_de_actividad"]!=""){
		/*	$sql_act = "SELECT * FROM tipo_de_actividad WHERE Tipo_de_actividad ='" . $row["Tipo_de_actividad"] . "';";
			$mysql_act = mysql_query($sql_act,$con);
			$row_act = mysql_fetch_array($mysql_act);
			echo   "@@@". nodo("tipo_actividad") . remplazar($row["Tipo_de_actividad"]) . nodo("/tipo_actividad");
		}
	}*/
		
/**/
	
	if($sala_anterior != $row["Sala"]){	
		//if($row["Hora_inicio"]=="14:00:00" or $row["Hora_inicio"]=="13:00:00"){
			echo  "**-***@" .  nodo("sala") . $row["Sala"] . nodo("/sala");
	//	}
		$sala_anterior = $row["Sala"];
	}

		
		
	//if($hora_anterior != $row["Hora_inicio"]){
		if($casillero_anterior1 != $row["Casillero"]){	
		//if($row["Hora_inicio"]=="14:00:00" or $row["Hora_inicio"]=="13:00:00"){
			//echo  "<br>" . nodo("dia") . $row["Dia"] . nodo("/dia") . "### " ;
			echo   "<br>".nodo("Hora") . substr($row["Hora_inicio"], 0, -3). " a " . substr($row["Hora_fin"],0 , -3) . nodo("/Hora");
			echo   "###".nodo("Titulo_de_actividad") . remplazar($row["Titulo_de_actividad"]). nodo("/Titulo_de_actividad");
	//	}
		
		
		$casillero_anterior1 = $row["Casillero"];
		$hora_anterior = $row["Hora_inicio"];
		
		}
	
	
	
	
	
	
	
	
	if($casillero_anterior != $row["Casillero"]){

	/*	
		$primerPalabra_de_la_actividad = split(" ", $row["Tipo_de_actividad"]);

		if($primerPalabra_de_la_actividad[0]==""){
			$primerPalabra = "vacia";
			
		}else{
			
			$primerPalabra = $primerPalabra_de_la_actividad[0];
			
		}
	*/	
		//echo  nodo("hora_tipo") . substr($row["Hora_inicio"], 0, -3). " a " . substr($row["Hora_fin"],0 , -3) .  nodo("/hora_tipo");
		//. "@@@" . $negritaA .  $row["Tipo_de_actividad"] . $negritaB .  nodo("/hora_tipo");


		if($row["Area"] == ""){
			$area= "";
		}else{
			$area = $row["Area"];
		}
		/*if($row["Tematicas"] == ""){
			$tematica  = "";
		}else{
			$tematica = $row["Tematicas"];
		}
		if($row["Area"] != "" && $row["Tematicas"] != ""){
			$tematica = " - " . $row["Tematicas"];
		}*/

		if($row["Area"] != "" /*|| $row["Tematicas"] != ""*/){
			$sqlArea = "SELECT * FROM area_trabjos_libres WHERE id='$area'";
			$queryArea = mysql_query($sqlArea,$con);
			$rowArea = mysql_fetch_object($queryArea);
			echo "###".nodo("area_tematica"). remplazar($rowArea->Area) /*. remplazar($tematica) */. nodo("/area_tematica");
		}

		
		
		if($row["Titulo_de_actividad"]!=""){
			//echo  "<br>" . nodo("titulo_actividad") . remplazar($row["Titulo_de_actividad"]) . nodo("/titulo_actividad");
		}

		$casillero_anterior = $row["Casillero"];
	}

	if($tit_trabajo_anterior != $row["Titulo_de_trabajo"] && $row["Titulo_de_trabajo"]!=""){
		echo  "<br>" .  nodo("titulo_trabajo") . remplazar($row["Titulo_de_trabajo"])  .  nodo("/titulo_trabajo");
		$tit_trabajo_anterior = $row["Titulo_de_trabajo"];
	}
	if($row["En_calidad"]!="")
		$calidad =  nodo("Calidad") . remplazar($row["En_calidad"]) . ":@@@" . nodo("/Calidad");
	else
		$calidad =  nodo("Calidad") ."@@@". nodo("/Calidad");	
		
	/*if ($row["En_calidad"]!=""){
		if ($row["En_calidad"]!="Participante"){
			$calidad =  nodo("Calidad") . $row["En_calidad"] . ":" . nodo("/Calidad");
		}else{
			$calidad =  nodo("CalidadParticipante") . $row["En_calidad"] . ":" . nodo("/CalidadParticipante");
		}
		$calidad =  nodo("Calidad") . remplazar($row["En_calidad"]) . ":@@@" . nodo("/Calidad");			
	}else{
		$calidad = "";
	}*/

	if ($row["Pais"]!=""){
		$pais = $row["Pais"] . "";
	}else{
		$pais = "";
	}
	
	if($row["Institucion"]!=""){
		$Institucion = " - ".$row["Institucion"];
	}else{
		$Institucion = "";
	}
	
	if(($pais!="") && ($Institucion!="")){
		$guion = " - ";
	}else{
		$guion = "";
	}
	if($row["Nombre"]!="" && $row["Apellidos"]!=""){
		echo  "<br>" .  nodo("persona") . $calidad .  "".  $row["Nombre"] . " " . $row["Apellidos"] ."".nodo("/persona")."".nodo("insP").$Institucion.$guion."#@#".$pais.nodo("/insP")."";
	}


	//***********************tl*****************************************************************************************************************

	if($row["Trabajo_libre"]==1){
		//
		//$pos = strpos ($row["Titulo_de_actividad"], "Poster");
		/*if ($pos === false) { 
		    $orden = "Hora_inicio";
		}else{
			 $orden = "numero_tl";
		}*/

		$arrayTrabajos = array();
		
		/*Posters*/ 
		//$sql_t ="SELECT * FROM trabajos_libres WHERE tipo_tl='Póster' AND estado<>'3' ORDER BY abr_tl,session_tl, orden_panel ASC;";
		//Orales
		//$sql_t ="SELECT * FROM trabajos_libres WHERE ID_casillero= '" . $row["Casillero"] . "' ORDER BY orden_tl ASC;";
		$rs_t = mysql_query($sql_t,$con);
		//Orales
		/*while ($row_t = mysql_fetch_array($rs_t)){
			echo "<br />". nodo("titulo_res").remplazar($row_t["titulo_tl"]). nodo("/titulo_res");
		
		$tl_autores = "SELECT * FROM trabajos_libres_participantes as t JOIN personas_trabajos_libres as p ON t.ID_participante=p.ID_Personas WHERE t.ID_trabajos_libres='".$row_t["ID"]."' AND t.lee=1";
			$query_autores = mysql_query($tl_autores,$con); //or die(mysql_error());
			while($rowAutores = mysql_fetch_object($query_autores)){
				echo "<br>".nodo("personaTL").$rowAutores->Nombre." ".$rowAutores->Apellidos.nodo("/personaTL");
			}
		}*/

		$sql_t ="SELECT * FROM trabajos_libres WHERE ID_casillero= '" . $row["Casillero"] . "' AND estado<>3  ORDER BY Hora_inicio,numero_tl ASC;";
		$rs_t = mysql_query($sql_t,$con);
	/*	$horav = "";
		if($row["Hora_inicio"]!=$horav){
			echo nodo("sala").remplazar($row["Sala"]). nodo("/sala")."<br />";
			echo nodo("dia").remplazar($row["Dia"]). nodo("/dia")."###".nodo("hora").remplazar(substr($row["Hora_inicio"], 0, -3))." a ".remplazar(substr($row["Hora_fin"], 0, -3)). nodo("/hora")."###";
		}*/
		while ($row_t = mysql_fetch_array($rs_t)){
		
		/*if($row["Hora_inicio"]!=$horav){
					$sqlArea = "SELECT * FROM areas_trabjos_libres WHERE id='".$row_t["area_tl"]."'";
					$queryArea = mysql_query($sqlArea,$con);
					$rowArea = mysql_fetch_array($queryArea);
			echo nodo("area_tl").$row_t["area_tl"]." - ".remplazar($rowArea["Area"]). nodo("/area_tl")."<br />";
			
		}
		$horav = $row["Hora_inicio"];*/
		
		echo  "<br>".nodo("TL")."<br />";
		/*if (($row_t["tipo_tl"]=="Póster")&&($row_t["area_tl"]!="")&&($area!=$row_t["area_tl"])){
			echo  nodo("area_TL")  .remplazar($row_t["area_tl"]) . nodo("/area_TL")."<br />";
			$area = remplazar($row_t["area_tl"]);
			
		}*/

		//para libro
	//Posters	
	//echo  nodo("area_abr").remplazar($row_t["abr_tl"])."_".remplazar($row_t["session_tl"])."_".remplazar($row_t["orden_panel"]).nodo("/area_abr")."@@@".nodo("numero_AreaP").remplazar($row_t["numero_tl"]). nodo("/numero_AreaP");
	
	//Orales
	if($row_t["archivo_tl"]!=""){
		$numeral = "";
	}else{
		$numeral = "";
	}
	
		
		
		//
		
		echo "<br>".nodo("numero_tl").remplazar($row_t["numero_tl"]). nodo("/numero_tl"). "@**@--".nodo("hora_tl").remplazar(substr($row_t["Hora_inicio"],0,-3)). nodo("/hora_tl")."<br>";
	//	echo nodo("hora_tl").remplazar($row_t["Hora_inicio"]). nodo("/hora_tl"). "<br>";
		echo nodo("titulo").remplazar($row_t["titulo_tl"]). nodo("/titulo");

		// autores
		
		
		

					echo "<br />". nodo("autores");
/*
					$arrayPersonas = array();
					$arrayID_participantes = array();


					$sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " .  $row_t["ID"] . " ORDER BY ID ASC;";
					$rs2 = mysql_query($sql2,$con);
					while ($row2 = mysql_fetch_array($rs2)){

						$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
						$rs3 = mysql_query($sql3,$con);
						while ($row3 = mysql_fetch_array($rs3)){

							array_push($arrayPersonas, array($row3["Institucion"], $row3["Apellidos"], $row3["Nombre"], $row3["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"]));

						}


					}


					for ($i=0; $i < count($arrayPersonas); $i++){

						if($i>0){
							echo "; ";

						}


						if($i==0){
							if($arrayPersonas[$i][3] != ""){
								$aster = $abre . "sup$cierra"  . " *" . $abre . "/sup$cierra" ;
							}
						}else{
							$aster = "";
						}


			

						if ($arrayPersonas[$i][6]=="1"){
							echo  $abre . "u" . $cierra;

						}



						echo $arrayPersonas[$i][1]. ", " . $arrayPersonas[$i][2] . " (". $arrayPersonas[$i][3] .")";


						if ($arrayPersonas[$i][6]=="1"){
							echo $abre . "/u" . $cierra;

						}
					//	echo $abre . "sup$cierra" . $claveIns . $aster  . "$abre/sup$cierra";


					}

					echo  nodo("/autores");
*/
	$arrayPersonas = array();
					$arrayInstituciones = array();
					$arrayID_participantes = array();

/*
$sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " .  $row_t["ID"] . " ORDER BY ID ASC;";
					$rs2 = mysql_query($sql2,$con);
					while ($row2 = mysql_fetch_array($rs2)){

						$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
						$rs3 = mysql_query($sql3,$con);
						while ($row3 = mysql_fetch_array($rs3)){

							array_push($arrayPersonas, array($row3["Institucion"], $row3["Apellidos"], $row3["Nombre"], $row3["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"]));
				*/			
							

					
				$sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " .  $row_t["ID"] . " ORDER BY ID ASC;";
					$rs2 = mysql_query($sql2,$con);
					while ($row2 = mysql_fetch_array($rs2)){

						array_push($arrayID_participantes , $row2["ID_participante"]);

						$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
						$rs3 = mysql_query($sql3,$con);
						while ($row3 = mysql_fetch_array($rs3)){
							
							
							if($row3["Institucion"]!="")
							{
								$getInstitucion = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row3["Institucion"]."'",$con);
								$rowIns = mysql_fetch_array($getInstitucion);
							}
							array_push($arrayInstituciones , $rowIns["Institucion"]);
							array_push($arrayPersonas, array($rowIns["Institucion"], $row3["Apellidos"], $row3["Nombre"], $row3["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"]));

						}


					}


					$arrayInstitucionesUnicas = array_unique($arrayInstituciones);
					$arrayInstitucionesUnicasNuevaClave = array();

					if(count($arrayInstitucionesUnicas)>0){
						foreach ($arrayInstitucionesUnicas as $u){
							if($u!=""){
								array_push($arrayInstitucionesUnicasNuevaClave, $u);
							}
						}
					}


					for ($i=0; $i < count($arrayPersonas); $i++){

						if($i>0){
							echo "; ";

						}


						if($i==0){
							if($arrayPersonas[$i][3] != ""){
								$aster = $abre . "sup$cierra"  . " *" . $abre . "/sup$cierra" ;
							}
						}else{
							$aster = "";
						}


						if($arrayPersonas[$i][0]!=""){
							$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicasNuevaClave))+1;

						}else{
							$claveIns = "";
						}


						if ($arrayPersonas[$i][6]==1){
							echo  $abre . "u" . $cierra;

						}


						echo $arrayPersonas[$i][1]. ", " . $arrayPersonas[$i][2];


						if ($arrayPersonas[$i][6]=="1"){
							echo $abre . "/u" . $cierra;

						}
						echo $abre . "sup$cierra" . $claveIns . $aster  . "$abre/sup$cierra";


					}

					echo  nodo("/autores");

					//********************


					//--------------------institucuiones


					echo "<br />". nodo("institucion");
					if(count($arrayInstitucionesUnicasNuevaClave)>0){

						$clave = 1;

						foreach ($arrayInstitucionesUnicasNuevaClave as $ins){

					

							if($arrayPersonas[0][3] != "" && $clave==1){

								
		
								echo  $abre . "sup$cierra" . "* " . $abre . "/sup$cierra" ;// $arrayPersonas[0][3] . " - ";

							

							}

								if($clave>1){
									echo "; " ;	
								}

							echo    $abre . "sup$cierra" . $clave  . $abre . "/sup$cierra" . " " . remplazar($ins);
							

						


							$clave = $clave + 1 ;
						}

					}

						echo  nodo("/institucion");
					//echo  "<br />".nodo("resumen").remplazar($row_t["resumen"]). nodo("/resumen");
					
					if($row_t["tabla_trabajo_comleto_ing"]!=""){
					echo "<br />";
				//	echo $abre."imgTL".$cierra.$row_t["tabla_trabajo_comleto_ing"].$abre."/imgTL".$cierra;
					}
					echo  "<br /><br />";
				//	echo nodo("titulo_tl_residente").remplazar($row_t["titulo_tl_residente"]). nodo("/titulo_tl_residente");
				
					if($row_t["resumen"]!=""){
	//					echo "<br /><br />".nodo("resumen_titulo")."Instroducci&oacute;n".nodo("/resumen_titulo")."<br>";
						//echo "".nodo("resumen").remplazar($row_t["resumen"]). nodo("/resumen");
					}
					
					/*if($row_t["resumen2"]!=""){						
						echo "<br /><br />".nodo("resumen_titulo")."Objetivos".nodo("/resumen_titulo")."<br>";
						echo "<br /><br />".nodo("resumen").remplazar($row_t["resumen2"]). nodo("/resumen");
					}
					
					if($row_t["resumen3"]!=""){						
						echo "<br /><br />".nodo("resumen_titulo")."Material".nodo("/resumen_titulo")."<br>";
						echo "<br /><br />".nodo("resumen").remplazar($row_t["resumen3"]). nodo("/resumen");
					}
					
					if($row_t["resumen4"]!=""){						
						echo "<br /><br />".nodo("resumen_titulo")."M&eacute;todos".nodo("/resumen_titulo")."<br>";
						echo "<br /><br />".nodo("resumen").remplazar($row_t["resumen4"]). nodo("/resumen");
					}
					
					if($row_t["resumen5"]!=""){						
						echo "<br /><br />".nodo("resumen_titulo")."Resultados y conclusiones".nodo("/resumen_titulo")."<br>";
						echo "<br /><br />".nodo("resumen").remplazar($row_t["resumen5"]). nodo("/resumen");
					}*/
					
					
					
					if($row_t["tabla_trabajo_comleto"]!=""){
					echo "<br />";
				//	echo $abre."imgTL_residente".$cierra.$row_t["tabla_trabajo_comleto"].$abre."/imgTL_residente".$cierra;
					}
					//********************


//	echo "<br />".nodo("area_abr1").remplazar($row_t["abr_tl"])."_".remplazar($row_t["session_tl"])."_".remplazar($row_t["orden_panel"]).nodo("/area_abr1");


		echo nodo("/TL");



		}



	}
	//***********************fin-tl*****************************************************************************************************************

		}
}

echo  "<br>" . nodo("/root");
?>