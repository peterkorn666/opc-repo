echo "<p class='tl_linea_hora'>" . substr($row0["Hora_inicio"], 0, -3) . " a " . substr($row0["Hora_fin"],0 , -3) . "<b><font size='2'>&nbsp;- Nº ". $row0["numero_tl"] . "&nbsp;</font></b></p>\n";
		$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;border-top-width: 1px;border-bottom-width: 1px;border-top-style: solid;border-top-color: #666666;margin:0px;margin-left:105px;margin-top:5px;'>" . substr($row0["Hora_inicio"], 0, -3) . " a " . substr($row0["Hora_fin"],0 , -3) . "<b><font size='2'>&nbsp;- Nº ". $row0["numero_tl"] . "&nbsp;</font></b></p>\n";


		if($_SESSION["registrado"] == true){
				?>
				<table>
					<tr>
	                    <td><a href="modificarTrabajosLibres.php?id=<?=$row0["ID"]?>"><img src="img/modificar.png" alt="Modificar este trabajo libre" width="12" height="13" border="0"></a></td>
	                    <td><a href="javascript:eliminar_tl(<?=$row0["ID"]?>)"><img src="img/eliminar.png" alt="Eliminar este trabajo libre" width="11" height="13" border="0"></a></td>
	                </tr>
                </table>
                <?
		}
		echo "<p class='tl_linea_titulo'>" .  $row0["titulo_tl"] . "</p>\n";
		$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 12spx;font-weight: bold;color: #333300;margin:0px;margin-left:182px;'>" .  $row0["titulo_tl"] . "</font></b></p>\n";

		$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;margin:0px;margin-left:182px;'>";

		$soloPuntoComa = 0;
		$primero = 0;
		$sql2 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres=".$row0["ID"]." ORDER BY ID ASC;";
		$rs2 = mysql_query($sql2,$con);
		while ($row2 = mysql_fetch_array($rs2)){

			$sql3 ="SELECT * FROM personas WHERE ID_Personas =".$row2["ID_participante"].";";
			$rs3 = mysql_query($sql3,$con);
			while ($row3 = mysql_fetch_array($rs3)){


				if ($row3["Curriculum"]!=""){
					if($_SESSION["registrado"] == true || $verCurriculums == true){
						$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row3["Curriculum"] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row3["Nombre"]. " " . $row3["Apellidos"]. "'></a>";
					}else{
						$curriculum = "";
					}
				}else{
					$curriculum = "";
				}

				if ($row3["Mail"]!=""){
					$mail = "&nbsp;<a href='mailto:" . $row3["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";

					if($_SESSION["registrado"] == true || $verMails== true){
						$mail = "&nbsp;<a href='mailto:" . $row3["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
					}else{
						$mail = "";
					}
				}else{
					$mail = "";
				}

				if($row2["lee"]==1){
					echo "<u>";
					$curA = "<u>";
					$curC = "</u>";

				}else{
					$curA = "";
					$curC = "";
				}


				if($soloPuntoComa == 1){
					echo "; ";
					$imprimir .="; ";
				}

				$soloPuntoComa = 1;


				if($primero == 0){

					if($row3["Institucion"]!=''){
						$aster = "(*) ";
						$inst_primero = "(*) " . $row3["Institucion"];
					}else{
						$inst_primero='';
						$aster = "";
					}
					if($inst_primero == ""  ){
						$pais_primero = $row3["Pais"];
					}else{
						if($row3["Pais"] == ""){
							$pais_primero = "";
						}else{
							$pais_primero =  " / " . $row3["Pais"]  ;
						}
					}
				}else{
					$aster = "";
				}
				$primero=1;

				//PARA QUE NO SALGA SI NO TIENE AUTORES
				//echo "<font size='2'>";
				if($row3["Apellidos"]!="" or $row3["Nombre"]!=""){
					echo  $row3["Apellidos"].", ".$row3["Nombre"] . $aster . $curriculum .$mail ;
				}else{

					echo  $row3["Apellidos"].", ".$row3["Nombre"] . $aster . $curriculum .$mail;
				}
				
				$imprimir .= $curA  .  $row3["Apellidos"] . ", " . $row3["Nombre"] . $aster . $curC ."";

				if($row2["lee"]==1){echo "</u>";}



			}
		}
		echo "<p class='pais'> " . $inst_primero . $pais_primero . "</p>\n";

		$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-weight: bold; font-size: 8px;margin:0px;color:#000066;margin-left:182px;'>" . $inst_primero . $pais_primero ;
		$imprimir .= "</p>\n";

		if($row0["archivo_tl"]!=""){
			if($_SESSION["registrado"] == true || $verTL == true){
			?>
       
         <div align="right"><a href="bajando_tl.php?id=<?=$row0["archivo_tl"]?>" target="_self"  class="link"><font size="2">Haga clic aquí para ver mas sobre este Trabajo Libre</font></a></div></td></tr>
          
			<?
			}

		}

	}
