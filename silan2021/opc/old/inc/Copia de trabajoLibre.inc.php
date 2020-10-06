<link href="../estilos.css" rel="stylesheet" type="text/css" />
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
                    <td><?
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
				  $imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #333300;margin:0px;margin-left:105px;'><b>" . $row->numero_tl . "</b>\n";
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
				  
                  if($row->tipo_tl!=""){
                  	echo $separador .  "<font color='#ff0000'>" .remplazar($row->tipo_tl) .  "</font>";
                  	$imprimir .= "<font color='#000000'> | " .$row->tipo_tl . "</font>";
                  }

 				 if($row->idioma!=""){
                  	echo $separador . "<font color='#ff6600'>" . remplazar($row->idioma) . "</font>";
                  	$imprimir .= "<font color='#000000'> | " .$row->idioma . "</font>";
                  }
                  if($row->area_tl!=""){
                  	echo $separador . "<font color='#003300'>" .remplazar($row->area_tl). "</font>";
                 // 	$imprimir .= "<font color='#cccccc'> | </font>" .$row->area_tl;
                  }


                  if($row->archivo_tl!=""){
                  	if($_SESSION["registrado"] == true || $verTL == true){

                  		echo "$separador<font color='#333333' size='1'><a href='#' onClick=\"bajarTL('". $row->archivo_tl. "')\"></font><img  align='absmiddle' src='img/filesave.png' align='absmiddle' border='0' alt='Descargar este documento' /></a>";

                  	}
                  }

                  if($row->mailContacto_tl!=""){
                  	if($_SESSION["registrado"] == true || $verMails== true){

                  		echo "$separador <a href='mailto:".$row->mailContacto_tl."'  class='crono_trab'><img align='absmiddle'  src='img/logo_mail.gif' align='absmiddle' border='0' alt='Mail de contacto de este Trabajo' /></a>";
                  	}
                  }
				
				if($row->telefono!=""){
                  	if($_SESSION["registrado"] == true){

                  		echo "$separador <a href='javascript:alert(\"Teléfono del trabajo " . $row->numero_tl . ": " .  $row->telefono . "\")'  class='crono_trab'><img align='absmiddle'  src='img/icon_telephone.gif' align='absmiddle' border='0' alt='Telefono del contacto de este Trabajo' /></a>";
                  	}
                  }

			?>
                    </span></td>
                    <td valign="top"><div align="right">
                        <?
				if($_SESSION["registrado"] == true  && $_SESSION["tipoUsu"]==1){

					echo "<div align='right'>";

					echo  "<input type='button' class='menuEdicion_editar' alt='Modificar este casillero' value='' onClick=\"modificar('" . $row->ID . "')\"  />";
					echo  "<input type='button' class='menuEdicion_eliminar'  alt='Eliminar este casillero' value='' onClick=\"eliminar(" . $row->ID . ", '" . $_GET["estado"] . "')\" />";

					echo "</div>";

				}
				?>
                    </div></td>
                  </tr>
              </table></td>
          </tr>
          <tr>
            <td height="20" class="tituloTL" style="text-transform:uppercase"><?=remplazar($row->titulo_tl);?></td>
            <?
			  $imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #003366;margin:0px;margin-left:105px;text-transform:uppercase;'><b>" . $row->titulo_tl . "</b></p>\n";

			  ?>
          </tr>
          <tr>
            <td height="20" class="autoresTL"><? 

              $imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 11px;color: #000000;margin:0px;margin-left:105px;'>";




              $arrayPersonas = array();
              $arrayInstituciones = array();


              $sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $row->ID ." ORDER BY ID ASC;";
              $rs2 = mysql_query($sql2,$con);
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
						array_push($arrayInstituciones , $row3["Institucion"]);
					}
				 ////NUEVO 06_08_07_///////////
              		array_push($arrayPersonas, array($row3["Institucion"], $row3["Apellidos"], $row3["Nombre"], $row3["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"], $row3["inscripto"]));
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

              		echo "</font></td><td align='right'>$masInfo</td></tr></table>";


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
              			   </font></td><td  align='right'>$masInfo</td></tr></table>";

              		$imprimir .= "<font color='#ff3300'>(*)</font> " . $arrayPersonas[0][3];


              	}else{

              			if($row->palabrasClave!="" || $row->resumen!=""){
              			echo  "<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr><td><font color='#ff0000' size='1'><tr><td>&nbsp;
              			</td><td  align='right'>$masInfo</td></tr></table>";

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
              if($row->resumen!=""){

              	echo 	'<table width="100%" border="0" cellspacing="0 " cellpadding="0">
						  <tr>
						    <td style="font-family:Arial, Helvetica, sans-serif; font-size:11; background-color: #FBFAEA;	margin: 10px;	border-top: 1px dotted #FF9966;border-left: 1px dotted #FF9966;padding-bottom:4;padding-top:4; padding-left:4; padding-right:4;">
							<b>Resumen:</b>						
							</td>
							<td style="font-family:Arial, Helvetica, sans-serif; font-size:11; background-color: #FBFAEA;	margin: 10px;border-right: 1px dotted #FF9966;border-top: 1px dotted #FF9966;padding-bottom:4;padding-top:4;padding-left:4; padding-right:4;"	 align="right"><!--<a href="javascript:ampliar('. $row->ID .')">ampliar</a>--></td>
							</tr>
							<tr ><td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:11; background-color: #FBFAEA;	margin: 10px;	border-bottom: 1px dotted #FF9966;border-left: 1px dotted #FF9966;border-right: 1px dotted #FF9966;padding-bottom:4;padding-left:4;padding-right:4;"> 
							<div style="height:75px; overflow-y:auto; ">
						' .str_replace(chr(13), "<br>", remplazar($row->resumen)) .'
						
						
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

              }

			   /*IMPRIMO las palabras claves DENTRO DEL DIV*/
              if($row->palabrasClave!=""){

              	echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr><td>
             		 		<tr><td><span style='font-family:Arial, Helvetica, sans-serif; font-size:11;'><i><b>Palabras clave:</b> " .remplazar($row->palabrasClave) . "</i></span></td></tr></table>";

             
			 if(remplazar($row->palabrasClave) != $row->palabrasClave && $yaAbierto == false){
					echo "<script>masInfoTL('infoTL_".$row->ID."', 'mas_menos_icon_".$row->ID."');</script>";
				}
			  }



              echo  $finDIv ;

                  ?></td>
          </tr>
      </table>
</div>
