<link href="../estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function calcWords(donde,numeros){

		var sTx = document.form1["resumen_cant"+numeros].value;
		sTxt = sTx.split("<br />").join(" ");
		var sTx2 = "";
		var sSep = " ";
		var iRes = 0;
		var bPalabra = false;
		for (var j = 0; j < sTxt.length; j++){
			if (sSep.indexOf(sTxt.charAt(j)) != -1){
				if (bPalabra) sTx2 += " ";
				bPalabra = false;
			} else {
				bPalabra = true;
				sTx2 += sTxt.charAt(j);
			}
		}
		if (sTx2.charAt(sTx2.length - 1) != " ") sTx2 += " ";
		for (var j = 0; j < sTx2.length; j++)
			if (sTx2.charAt(j) == " ") iRes++;
		if (sTx2.length == 1) iRes = 0;
		document.getElementById(donde+numeros).innerHTML = "<strong>" + String(iRes)+"</strong>";
	}
</script>
<?
$imprimir .='<script language="javascript">
function calcWords(donde,numeros){ 
	
	var sTx = document.getElementById("resumen_cant"+numeros).value;
		sTxt = sTx.split("<br />").join(" ");
	var sTx2 = ""; 
	var sSep = " "; 
	var iRes = 0; 
	var bPalabra = false; 
	for (var j = 0; j < sTxt.length; j++){ 
	 if (sSep.indexOf(sTxt.charAt(j)) != -1){ 
	  if (bPalabra) sTx2 += " "; 
	  bPalabra = false; 
	 } else { 
	  bPalabra = true; 
	  sTx2 += sTxt.charAt(j); 
	 } 
	} 
	if (sTx2.charAt(sTx2.length - 1) != " ") sTx2 += " "; 
	for (var j = 0; j < sTx2.length; j++) 
	 if (sTx2.charAt(j) == " ") iRes++; 
	if (sTx2.length == 1) iRes = 0; 
	document.getElementById(donde+numeros).innerHTML = "<strong>" + String(iRes)+"</strong>"; 
} 
</script>';
?>
<?
$separador = "<font size='3' color='#cccccc'> | </font>";
?>
<div id='divTL_Gral' align="center">

	<table width="100%" border="0" cellpadding="2" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td align="left" class="bordePunteadoAbajo"><?
				if($row->ID_casillero != 0 && $_SESSION["registrado"] == true && ($_GET["estado"]!="" || $row->estado!=2)){
					?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>-*-<?
								if($row->estado!=2){
									echo "<a href='javascript:noAprobado(1)'><img src='img/alert.png'  border='0' /></a>";
								}

								?>
								<font color='#666666' size="1">Ubicado en</font><font size="1">:</font><font color='#666666' size="1"><font color="#990000">
										<?
										$sql ="SELECT * FROM congreso WHERE Casillero  = '" . $row->ID_casillero  ."' limit 1;";
										$rs2 = mysql_query($sql,$con);
										while ($row2 = mysql_fetch_array($rs2)){

											echo $row2["Dia"] . " / " . $row2["Sala"] . " / "  . $row2["Hora_inicio"]  . " a " . $row2["Hora_fin"] . " / "  . $row2["Titulo_de_actividad"];

										}
										?>
									</font></font></td>
						</tr>
					</table>
					<?
				}
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<?
						if($_SESSION["registrado"] == true && $_GET["estado"]!=""){


							if($row->estado==2 && $row->ID_casillero==0){
								$anch = 35;
							}else{
								$anch = 10;
							}

							?>
							<td width="<?=$anch;?>" height="10" valign="top" class="tipo_y_areaTL"><?
								if($row->estado==2 && $row->ID_casillero==0){
									echo "<a href='javascript:noAprobado(2)'><img src='img/error.png'  border='0' /></a>";
								}


								switch ($row->estado) {

									case 0:
										$bgE = "#FFCACA";
										$brE = "#FF0000";
										break;
									case 1:
										$bgE = "#79DEFF";
										$brE = "#0099CC";
										break;

									case 2:
										$bgE = "#62FF62";
										$brE = "#006600";
										break;
									case 3:
										$bgE = "#999999";
										$brE = "#333333";
										break;
									case 4:
										$bgE = "#E074DD";
										$brE = "#E074DD";
										break;
								}
								?>
								<div style="width:20px; height:20px; background-color:<?=$bgE?>; border:1 solid <?=$brE?>;">
									<input name="tl[]" type="checkbox" id="tl[]" value="<?=$row->ID?>" />
								</div></td>
							<?
						}
						?>
						<td valign="top"><span class="tipo_y_areaTL">
					<span style=" font-family: Georgia, Times New Roman, Times, serif; color:#333300;  font-size:16px;  font-weight:bold; ">
                    <?=remplazar($row->numero_tl);?>
					</span>
								<?
								$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 2px;margin:5px;margin-left:105px;'>&nbsp;</p>\n";
								$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #333300;margin:0px;margin-left:105px;'><b>" . $row->numero_tl. "</b>\n";
								?>

								<?
								if($row->Hora_inicio!="00:00:00"){
									$hora_ini = substr($row->Hora_inicio, 0, -3) ." - ";
									$hora_fin = substr($row->Hora_fin, 0, -3);
									echo $separador;
								}
								else
								{
									$hora_ini = "";
									$hora_fin = "";
								}
								echo "<font color='#003333' >". $hora_ini . $hora_fin ."</font>";
								$imprimir .= "<font color='#000000' >". $hora_ini . $hora_fin ."</font>";

								// echo "$separador <span id='words$row->ID'></span>";

								if($row->tipo_tl!=""){
									echo $separador .  "<font color='#ff0000'>" .remplazar($row->tipo_tl) .  "</font>";
									//	$imprimir .= "<font color='#000000'> | " .$row->tipo_tl . "</font>";
								}

								if($row->premio!=""){
									switch($row->cual_premio){
										case "Premio Profesor Dr. Antonio Puigvert para el mejor trabajo de investigacion urologica (basica o clinica)":
											$prem = 1;
											break;
										case "Premio Frank A. Hughes para los mejores casos clinicos":
											$prem = 2;
											break;
										case "Premio Victor Politano imagenologia (poster)":
											$prem = 3;
											break;
										case "Premio Roberto Rocha Brito para el mejor video/DVD":
											$prem = 4;
											break;
										default:
											$prem = "";
											break;
									}
									echo $separador .  "<font color='#ff0000'>" .remplazar($row->premio). ($row->dropbox=="1"?" - Dropbox":"") .  "</font>";
									if($row->cual_premio!=""){
										echo $separador .  "<font color='#ff0000'>" .remplazar($prem) .  "</font>";
									}
									//    	$imprimir .= $separador ."<font color='#000000' style='font-size:10px'> " .$row->premio . "</font>".$separador;
								}


								/*if($row->idioma!=""){
                                   echo $separador . "<font color='#ff6600'>" . remplazar($row->idioma) . "</font>";
                                   $imprimir .= "<font color='#000000'> | " .$row->idioma . "</font>";
                                }*/
								if($row->area_tl!=""){
									echo $separador . "<font color='#003300'>" .$trabajos->areaID($row->area_tl)->id." - ".remplazar($trabajos->areaID($row->area_tl)->Area). "</font>";
									$imprimir .= "<font color='#cccccc'> | </font><span style='text-decoration:underline'>" .$trabajos->areaID($row->area_tl)->id." - ".remplazar($trabajos->areaID($row->area_tl)->Area)."</span>";
									//	$imprimir .= "<font color='#cccccc'> | </font>" .$row->area_tl;
								}


								if($row->archivo_tl!=""){
									if($_SESSION["registrado"] == true || $verTL == true and $_SESSION["tipoUsu"]!=4){

										echo "$separador<font color='#333333' size='1'><a href='javascript:void(0)' onClick=\"bajarTL('tl/". $row->archivo_tl. "')\"></font><img  align='absmiddle' src='img/filesave.png' align='absmiddle' border='0' alt='Descargar este documento' /></a>";

									}
								}

								if($row->poster_tl!=""){
									if($_SESSION["registrado"] == true || $verTL == true){

										echo "$separador<font color='#333333' size='1'><a href='#' onClick=\"bajarPosterTL('$row->poster_tl')\"></font><img  align='absmiddle' src='img/download_poster.png' align='absmiddle' border='0' alt='Descargar este poster' /></a>";

									}
								}

								if($row->oral_tl!=""){
									if($_SESSION["registrado"] == true || $verTL == true){

										echo "$separador<font color='#333333' size='1'><a href='#' onClick=bajarOralTL('$row->area_tl','$row->oral_tl')></font><img  align='absmiddle' src='img/ppt.png' align='absmiddle' border='0' alt='Descargar este oral' /></a>";

									}
								}

								/* if($row->premio=="Si"){
                                     if($_SESSION["registrado"] == true || $verTL == true){

                                         echo "$separador<img  align='absmiddle' src='img/award.png'  border='0' alt='Descargar este documento' />";

                                     }
                                 }*/
								if($row->contacto_mail!=""){
									if($_SESSION["registrado"] == true || $verMails== true){

										//echo "$separador <a href='mailto:".$row->mailContacto_tl."'  class='crono_trab'><img align='absmiddle'  src='img/logo_mail.gif' align='absmiddle' border='0' alt='Mail de contacto de este Trabajo' /></a>";
									}
								}

								if($row->telefono!=""){
									if($_SESSION["registrado"] == true){

										echo "$separador <a href='javascript:alert(\"Tel�fono del trabajo " . $row->numero_tl . ": " .  $row->telefono . "\")'  class='crono_trab'><img align='absmiddle'  src='img/icon_telephone.gif' align='absmiddle' border='0' alt='Telefono del contacto de este Trabajo' /></a>";
									}
								}

								?>
                    </span></td>
						<td valign="top"><div align="right">
								<?
								if($_SESSION["registrado"] == true  && $_SESSION["tipoUsu"]==1){

									echo "<div align='right'>";

									echo  "<input type='button' class='menuEdicion_editar' alt='Modificar este casillero' value='' onClick=\"modificar('" . base64_encode($row->id_trabajo) . "')\" />";
									echo  "<input type='button' class='menuEdicion_eliminar'  alt='Eliminar este casillero' value='' onClick=\"eliminar(" . $row->ID . ", '" . $_GET["estado"] . "')\" />";

									echo "</div>";

								}
								?>
							</div></td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<?
			$aux =remplazar($row->titulo_tl);
			$posicion = strrpos($aux, "&#946;");
			if($posicion<>0){
				$hayBeta =true;
				$parte1 = substr( $aux, 0, $posicion);
				$parte2 = substr( $aux,  $posicion +6);
			}else{
				$hayBeta=false;
			}
			?>
			<td height="20" class="tituloTL"><?
				if($hayBeta){
					$titulo = "<span style='text-transform:uppercase'>".$parte1."</span>&#946;<span style='text-transform:uppercase'>".$parte2."</span>";
					echo $titulo;
				}else{
					$titulo = "<span>".remplazar($row->titulo_tl)."</span>";
					echo $titulo;
				}
				//$imprimir .= '<span style="font-size:10px">'.$row->tipo_tl." / ".$trabajos->areaID($row->area_tl)->id." - ".$trabajos->areaID($row->area_tl)->Area."</span>";
				?></td>
			<?
			$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #003366;margin:0px;margin-left:105px;'><b>" . $titulo . "</b></p>\n";

			?>
		</tr>
		<tr>
			<td height="20" class="autoresTL"><?

				$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 11px;color: #000000;margin:0px;margin-left:105px;'>";




				$arrayPersonas = array();
				$arrayInstituciones = array();


				$sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $row->id_trabajo ." ORDER BY ID ASC;";
				//  echo $sql2;
				$rs2 = mysql_query($sql2,$con) or die(mysql_error());
				while ($row2 = mysql_fetch_array($rs2)){
					$existInst = false;
					$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
					$rs3 = mysql_query($sql3,$con);
					while ($row3 = mysql_fetch_array($rs3)){
						////NUEVO 06_08_07_///////////
						if(count($arrayInstituciones)>0){
							foreach ($arrayInstituciones as $u){
								if($row3["Institucion"] == $u){
									$existInst = true;
									break;
								}else{
									$existInst = false;
								}
							}
						}
						if($existInst == false){

							if(!empty($row3["Institucion"]))
							{
								$getInstitucion = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row3["Institucion"]."'",$con) or die(mysql_error());
								$rowInstitucion = mysql_fetch_array($getInstitucion);
							}
							//
							//COMENTE ESTO PARA SACAR INSTITUCIONES
							//
							array_push($arrayInstituciones , $rowInstitucion["Institucion"]);
						}

						if(!empty($row3["Pais"]))
						{
							$getPais = mysql_query("SELECT * FROM paises WHERE ID_Paises='".$row3["Pais"]."'",$con) or die(mysql_error());
							$rowPais = mysql_fetch_array($getPais);
						}

						array_push($arrayPersonas, array($rowInstitucion["Institucion"], $row3["Apellidos"], $row3["Nombre"], $rowPais["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"], $row3["inscripto"]));
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
						$imprimir .= "; ";
					}
					if($i==0){
						if($arrayPersonas[$i][3] != ""){
							$aster = "<font color='#ff3300'>(*)</font>";
						}
					}else{
						$aster = "";
					}
					if($arrayPersonas[$i][0]!=""){
						$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicasNuevaClave))+1;

					}else{
						$claveIns = "";
					}


					/*Mostrar curiculum si no es vacio y si es habilitado*/
					if ($arrayPersonas[$i][4]!=""){
						if($_SESSION["registrado"] == true || $verCurriculums == true){
							$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $arrayPersonas[$i][4] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " . $arrayPersonas[$i][2] . " " . $arrayPersonas[$i][1] . "'></a>";
						}else{
							$curriculum = "";
						}
					}else{
						$curriculum = "";
					}

					/*Mostrar mail si no es vacio y si es habilitado*/
					if ($arrayPersonas[$i][5]!=""){
						if($_SESSION["registrado"] == true || $verMails== true){
							$mail = "&nbsp;<a href='mailto:" . $arrayPersonas[$i][5]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
						}else{
							$mail = "";
						}
					}else{
						$mail = "";
					}



					if ($arrayPersonas[$i][6]=="1"){
						echo "<u>";
						$imprimir .= "<u>";
					}

					if($_SESSION["registrado"] == true){

						if ($arrayPersonas[$i][7]=="1"){
							echo "<img src='img/puntoVerde.png' alt='Esta persona esta inscripta al congreso' />&nbsp;";
						}

					}

					echo remplazar($arrayPersonas[$i][1]). ", " . remplazar($arrayPersonas[$i][2]);
					$imprimir .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];


					if ($arrayPersonas[$i][6]=="1"){
						echo "</u>";
						$imprimir .= "</u>";
					}
					echo "<sup><font color='#ff0000'> " . $claveIns . $aster  . "</font></sup>"  . $curriculum . $mail;
					$imprimir .= "<sup><font color='#ff0000'> " . $claveIns . $aster  . "</font></sup>" ;


				}
				$imprimir .= "</p>";

				?>            </td>
		</tr>
		<tr>
			<td height="20" ><?
				$divRegistrad=false;
				$primero = false;
				/*imprimo institucion y claves*/
				if(count($arrayInstitucionesUnicasNuevaClave)>0){

					$clave = 1;

					foreach ($arrayInstitucionesUnicasNuevaClave as $ins){


						echo   "<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr><td><font color='#ff0000' size='1'> $clave - <font color='#666666'>" . remplazar($ins) . "</font>";


						///	if($clave==1){

						$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;margin:0px;margin-left:105px;'><i> <font color='#ff0000'>$clave</font> - $ins</i>";

						if ($primero == false ){
							if($arrayPersonas[0][3] != ""){
								$primero = true;
								echo  "<font color='#cccccc'>  |  </font><font color='#ff3300'>(*) </font><font color='#666666'>" . remplazar($arrayPersonas[0][3]) . "</font>";

								$imprimir .= " | <font color='#ff3300'>(*)</font> " . $arrayPersonas[0][3];
							}

						}

						$imprimir .= "</p>";


						//	}






						if(count($arrayInstitucionesUnicasNuevaClave)>1 || $row->palabrasClave!=""  || $row->resumen!=""){

							if($clave==1){

								$masInfo = "<a href=\"javascript:masInfoTL('infoTL_".$row->ID."', 'mas_menos_icon_".$row->ID."')\"><div id='mas_menos_icon_".$row->ID."'>[+ Info]</div></a>";

							}else{
								$masInfo = "&nbsp;";
							}

						}else{
							$masInfo = "&nbsp;";
						}

						echo "</font></td>
<td align='right'>$masInfo</td></tr></table>";


						if(count($arrayInstitucionesUnicasNuevaClave)>1 || $row->palabrasClave!=""  || $row->resumen!=""){

							if($divRegistrad==false){
								echo "<div id='infoTL_".$row->ID."' style='Display:none'>";
								$finDIv = "</div>";
								$divRegistrad=true;
							}

						}


						$clave = $clave + 1 ;
					}



				}


				if(count($arrayInstitucionesUnicasNuevaClave)==0){

					$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;margin:0px;margin-left:105px;'>";


					if($row->palabrasClave!="" || $row->resumen!=""){
						$masInfo = "<a href=\"javascript:masInfoTL('infoTL_".$row->ID."', 'mas_menos_icon_".$row->ID."')\"><div id='mas_menos_icon_".$row->ID."'>[+ Info]</div></a>";
					}else{
						$masInfo = "&nbsp;";
					}




					if($arrayPersonas[0][3] != ""){

						echo  "<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr><td><font color='#ff0000' size='1'><tr><td>
              			   <font size='1'><font color='#ff3300'>(*) </font><font color='#666666'>" . remplazar($arrayPersonas[0][3]) . "</font>
              			   </font></td>
<td  align='right'>$masInfo</td></tr></table>";

						$imprimir .= "<font color='#ff3300'>(*)</font> " . $arrayPersonas[0][3];


					}else{

						if($row->palabrasClave!="" || $row->resumen!=""){
							echo  "<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr><td><font color='#ff0000' size='1'><tr><td>&nbsp;
              			</td>
<td  align='right'>$masInfo</td></tr></table>";

						}
					}


					if($row->palabrasClave!="" || $row->resumen!=""){

						if($divRegistrad==false){
							echo "<div id='infoTL_".$row->ID."' style='Display:none'>";
							$finDIv = "</div>";
							$divRegistrad=true;
						}

					}



					$imprimir .= "</p>";

				}



				/*IMPRIMO EL RESUMEN DENTRO DEL DIV*/
				// if($row->resumen!=""){

				$imprimir .="
					<p style='font-family: Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;margin:0px;margin-left:105px;'><br>
					<strong>Resumen:<br /></strong>
							 $row->resumen
						<br /><br />
					<strong>Abstract:<br /></strong>
							 $row->resumen_en
						 
							 
							 ";
				//<br /><br /><strong>Resumen 4:<br /></strong>
				//$row->resumen4

				if($row->tabla_trabajo_comleto_ing!=""){
					//$imprimir .='<br /><br /> <img src="tablas_ing/'.$row->tabla_trabajo_comleto_ing.'" style="max-width:600px;">';
				}
				$imprimir .= "<br />Contacto: $row->contacto_mail</span>";
				//$imprimir .= "<br /><br />Cantidad palabras: <span id='wordsImp$row->ID'></span>";
				$imprimit .= "</p>";
				$imprimir .= "<p class='tituloTL' style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #003366;margin:0px;margin-left:105px;'><br><strong>" . str_replace(chr(13), "<br>", remplazar($row->titulo_tl_residente))."</strong>";
				$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;margin:0px;margin-left:105px;'>";

				if($row->tabla_trabajo_comleto!=""){
					//	$imprimir .= '<br /><br /> <img src="tablas/'.$row->tabla_trabajo_comleto.'" style="max-width:600px;">';
				}
				$imprimir .="</p>";
				//Comentarios Evaluadores
				$sqlEval = "SELECT t.*,e.*,e.comentarios as ecomentarios,ev.* FROM trabajos_libres as t JOIN evaluaciones as e ON t.numero_tl=e.numero_tl JOIN  evaluadores as ev ON e.IdEvaluador=ev.id WHERE t.numero_tl='$row->numero_tl'";
				$queryEval = mysql_query($sqlEval,$con) or die(mysql_error());
				$evl = "";
				while($rowEval = mysql_fetch_object($queryEval)){
					$comments = preg_replace('[\n|\r|\n\r]', '', trim($rowEval->ecomentarios));

					if($evl!=$rowEval->nombre){
						$imprimir .= '';
						if($rowEval->nivel==2){
							//	$imprimir .= "<div id='cmt$rowEval->id' style='font-family: Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;margin:0px;margin-left:105px;'><strong>$rowEval->nombre</strong><br>$comments<br></div>";
						}
						$imprimir .= '';
					}
					$evl = $rowEval->nombre;
				}
				//Comentarios Evaluadores
				echo 	'<table width="100%" border="0" cellspacing="0 " cellpadding="0">
						  <tr>
						    <td style="font-family:Arial, Helvetica, sans-serif; font-size:11; background-color: #FBFAEA;	margin: 10px;	border-top: 1px dotted #FF9966;border-left: 1px dotted #FF9966;padding-bottom:4;padding-top:4; padding-left:4; padding-right:4;">
													
							</td>
							<td style="font-family:Arial, Helvetica, sans-serif; font-size:11; background-color: #FBFAEA;	margin: 10px;border-right: 1px dotted #FF9966;border-top: 1px dotted #FF9966;padding-bottom:4;padding-top:4;padding-left:4; padding-right:4;"	 align="right"><!--<a href="javascript:ampliar('. $row->ID .')">ampliar</a>--></td>
							</tr>
							<tr ><td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12; background-color: #FBFAEA;	margin: 10px;	border-bottom: 1px dotted #FF9966;border-left: 1px dotted #FF9966;border-right: 1px dotted #FF9966;padding-bottom:4;padding-left:4;padding-right:4;"> 
							<div style="max-height:265px; overflow-y:auto; ">
							<strong>Resumen:<br /></strong>
							 '.$row->resumen.'
							 <br /><br />
							 <strong>Abstract:<br /></strong>
							 '.$row->resumen_en.'
							 ';
				// '<br /><br /><strong>Resumen 4:<br /></strong>'
				//.$row->resumen4;


				if($row->tabla_trabajo_comleto_ing!=""){
					//echo '<br /><br /> <img src="tablas_ing/'.$row->tabla_trabajo_comleto_ing.'" style="max-width:600px;">';
				}
				echo '					
							</div>
							</td>
						  </tr>
						</table>
									';

				if(remplazar($row->resumen)!=$row->resumen){
					echo "<script>masInfoTL('infoTL_".$row->ID."', 'mas_menos_icon_".$row->ID."');</script>";
					$yaAbierto = true;
				}else{
					$yaAbierto = false;
				}

				//          }
				$imprimir .= '<textarea id="resumen_cant'.$row->ID.'" style="display:none">' .str_replace(chr(13), "<br>", remplazar($row->resumen)) .' ' .str_replace(chr(13), "<br>", remplazar($row->materialmetodos_resumen)) .' ' .str_replace(chr(13), "<br>", remplazar($row->resultados_resumen)) .' ' .str_replace(chr(13), "<br>", remplazar($row->conclusiones_resumen)).'</textarea>';

				echo '<textarea id="resumen_cant'.$row->ID.'" style="display:none">' .str_replace(chr(13), "<br>", remplazar($row->resumen)) .' ' .str_replace(chr(13), "<br>", remplazar($row->materialmetodos_resumen)) .' ' .str_replace(chr(13), "<br>", remplazar($row->resultados_resumen)) .' ' .str_replace(chr(13), "<br>", remplazar($row->conclusiones_resumen)) .'</textarea>';
				/*IMPRIMO las palabras claves DENTRO DEL DIV*/
				if($row->palabrasClave!=""){

					echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr><td>
             		 		<tr><td><span style='font-family:Arial, Helvetica, sans-serif; font-size:11;'><i><b>Palabras clave:</b> " .remplazar($row->palabrasClave) . "</i></span></td></tr></table>";


					if(remplazar($row->palabrasClave) != $row->palabrasClave && $yaAbierto == false){
						echo "<script>masInfoTL('infoTL_".$row->ID."', 'mas_menos_icon_".$row->ID."');</script>";
					}
				}

				/*echo "<script>calcWords('words',$row->ID);</script>";*/
				/*$imprimir .= "<script>calcWords('wordsImp',$row->ID);</script>";*/


				echo  $finDIv ;

				?></td>
		</tr>
	</table>
</div>