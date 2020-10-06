<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include('conexion.php');
require ("clases/class.Traductor.php");
$traductor = new traductor();
$dia_ = $_GET["dia_"];
$sala_ = $_GET["sala_"];


$sql_chico = "SELECT Dia_orden FROM congreso ORDER BY Dia_orden DESC";
$rs_chico = mysql_query($sql_chico, $con);
while($row_chico = mysql_fetch_array($rs_chico)){
	$primero = $row_chico["Dia_orden"];
}

if($dia_==""){
	$sql = "SELECT Dia,Dia_orden FROM congreso where Dia_orden = '$primero';" ;
	$rs = mysql_query($sql, $con) or die(mysql_error());
	while ($row = mysql_fetch_array($rs)){
		$dia_=$row["Dia_orden"];
	}
}

$sql = "SELECT * FROM dias WHERE Dia_orden = '".$dia_."';" ;
$rs = mysql_query($sql, $con);
if($row = mysql_fetch_array($rs)){
	$paraImprimi= "<center><div id='dia'><span class='CronoDia' style='text-align:center' align='center'>".$row["Dia"]."</span></div></center>";
}

$sqla = "SELECT AltoDeCrono, AltoDeCronoImp FROM config;";
$rsa = mysql_query($sqla, $con);
while ($rowa = mysql_fetch_array($rsa)){
	$alto_po_carga_horaria = $rowa["AltoDeCrono"];
	$alto_carga_horaria_Imprimir=$rowa["AltoDeCronoImp"];
}

		$sql = "SELECT DISTINCT Sala_orden FROM congreso WHERE Dia_orden='$dia_' ORDER BY Sala_orden;";
		$rs = mysql_query($sql, $con);
		while ($row = mysql_fetch_array($rs)){
			$cantidad_salas = $cantidad_salas + 1;
			$cualesSalas[] = $row["Sala_orden"];
		}

		$solo_primera = 1;

		if(count($cualesSalas)==0)
		{
			die();
		}
		
		//$tamano_columna_imp= 200;
		$tamano_columna = 100/$cantidad_salas;

		$desplasamientoDerecha = 1;
		
	
		
		foreach($cualesSalas as $i)
		{

			$sql = "SELECT DISTINCT Sala_orden FROM congreso where Sala_orden='" .  $i. "' and Dia_orden='" . $dia_ .  "';";
			$rs = mysql_query($sql, $con);
			while ($row = mysql_fetch_array($rs)){
				$salaFuente = $row["Sala_orden"];
			}


			$sql = "SELECT DISTINCT Sala FROM salas where Sala_orden='" .  $salaFuente . "';";
			$rs = mysql_query($sql, $con);
			while ($row = mysql_fetch_array($rs)){
			
				
				$nomSala = $traductor->nombreSala($salaFuente);
				
				//-------------Salas--------------------------------------

				$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
				//$posX_imp = (($tamano_columna_imp * $desplasamientoDerecha) - $tamano_columna_imp);
				echo "<div class='salas' style='position: absolute; ";
					$paraImprimi .= "<div style='position: absolute; ";
					//echo "top:$altoAbsoluto; ";
					$paraImprimi .= "top:33; ";
					echo "left:$posX"."%; ";
					
					$posX = (($tamano_columna) * $desplasamientoDerecha - $tamano_columna);
					$paraImprimi .= "left:".($posX)."%; ";
					
					$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
					echo "width:$tamano_columna"."%; ";
					$paraImprimi .= "width:".($tamano_columna)."%; padding:5px;";
					echo "height:20px; ";
					$paraImprimi .= "height:15px; ";
					echo "background-color:#333333; ";
					$paraImprimi .= "background-color:#333333; ";
					echo  "border:1px solid #000000;'>";
					$paraImprimi .= "overflow:hidden;";
					$paraImprimi .= "border:1px solid #000000;'>";
					echo "<div align='center'><font size='2' color='#ffffff'><b>" . $nomSala . "</b></font></div>";
					$paraImprimi .=  "<div align='center' valign='middle'><span class='CronoSala'>" . $nomSala . "</span></div>";
				
				$paraImprimi .=  "</div>";
				

				//--------------------------------------------------------------
				

				$sql = "SELECT * FROM congreso where Sala_orden='" . $i . "' and Dia_orden = '" . $dia_ . "' ORDER BY Casillero, Orden_aparicion;";
				$rs = mysql_query($sql, $con);

				while ($row = mysql_fetch_array($rs)){
					$traductor->cargarTraductor($row);
					$alto_f = strtotime($row["Hora_fin"]);
					$alto_i = strtotime($row["Hora_inicio"]);
					$alto = $alto_f - $alto_i;
					$alto = $alto / 900;
					$altoImprimir = $alto * $alto_carga_horaria_Imprimir;
					$alto = $alto * $alto_po_carga_horaria;


					$sql2 = "SELECT Hora_inicio FROM congreso where Dia_orden = '" . $dia_ . "' ORDER  BY Hora_inicio ASC ";
					$rs2 = mysql_query($sql2, $con);

					while ($row2 = mysql_fetch_array($rs2)){
						if($solo_primera == 1){
							$PrimeraHora = strtotime($row2["Hora_inicio"]);
							$solo_primera =0;
						}
					}

					$pos = $alto_i - $PrimeraHora;
					$pos = $pos / 900;
					$posImprimir = ($pos * $alto_carga_horaria_Imprimir) + (60);
					$pos = ($pos * $alto_po_carga_horaria) ;
					
					$pos = $pos +20;


					//recuadros****************************************************
					$sql3 = "SELECT * FROM recuadros where Sala_orden='" . $i . "' and Dia_orden = '" . $row["Dia_orden"] . "' ORDER  BY Hora_inicio ASC ";
					$rs3 = mysql_query($sql3, $con);

					while ($row3 = mysql_fetch_array($rs3)){

						$RRalto_f=strtotime($row3["Hora_fin"]);
						$RRalto_i = strtotime($row3["Hora_inicio"]);
						$RRalto = $RRalto_f - $RRalto_i;
						$RRalto = $RRalto / 900;
						$RRaltoImprimir =  $RRalto * $alto_carga_horaria_Imprimir;
						$RRalto = $RRalto * $alto_po_carga_horaria;
						$RRpos = $RRalto_i- $PrimeraHora;
						$RRpos = $RRpos / 900;
						$RRposImprimir = ($RRpos * $alto_carga_horaria_Imprimir) + (35);
						$RRpos = ($RRpos * $alto_po_carga_horaria) + ($altoAbsoluto+20);

						echo "<div id='div_".$row3["ID"]."' onmouseover='enabledMarco(this.id)' align='center' style='position: absolute; ";
						$paraImprimi .=  "<div align='center' style='position: absolute; ";
						echo "top:".$RRpos. "px; ";
						$paraImprimi .=  "top:" . $RRposImprimir . "px; ";
						echo "left:".$posX. "%; ";
						$paraImprimi .=  "left:".$posX. "%; ";
						echo "z-index: 1;";
						$paraImprimi .=  "z-index: 1; ";
						echo "width:".$tamano_columna * $row3["seExpande"] . "%; ";
						$paraImprimi .=  "width:".$tamano_columna * $row3["seExpande"] . "%; ";
						echo "height:" . $RRalto . "px; ";
						$paraImprimi .=   "height:" . $RRaltoImprimir . "px; ";
						echo  "border:3px solid #ff0000;filter:swap(enabled=false)'></div>  ";
						$paraImprimi .=  "border:3px solid #ff0000;'> </div>";
					}

					//*****************************************************************

					if($casillero_anterior != $row["Casillero"]){


						$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
						//$posX = (($tamano_columna_imp * $desplasamientoDerecha) - $tamano_columna_imp);

						echo "<div id='". $row["Casillero"] ."' class='div_casillero'  align='center' style=' position: absolute; ";
						$paraImprimi .=  	"<div  style='position: absolute; ";
						echo "top:".$pos. "px; ";
						$paraImprimi .= "top:" . $posImprimir . "px; ";
					//	echo "left:".$posX . "%; ";
						

						$paraImprimi .="left:".($posX)."%; ";

						//echo "width:".$tamano_columna * $row["seExpande"] . "%; ";
						echo "width:".(100 * $row["seExpande"]) . "%; ";
						$paraImprimi .="width:".($tamano_columna) . "%; ";
						echo "height:" . $alto . "px; ";
						if($row["seExpande"]>1)
							echo "z-index: 1;";
						$paraImprimi .="height:" . $altoImprimir . "px; ";

						////ACA TAMBIEN SE MODIFICAO PARA HACER TITULOS
						if($row['Tipo_de_actividad']!=$tit_act_sin_hora){

							if($row["seExpande"]!=0){

								echo  "border:1px solid #000000; ";
								$paraImprimi .= "border:1px solid #000000; ";

							}

						}else{

							echo  "border:0px solid #000000; ";
							$paraImprimi .= "border:0px solid #000000; ";
						}

						echo  "overflow:auto; ";
						echo "padding: 4px 10px;";
						$paraImprimi .= "overflow:hidden;";

						$sql_act = "SELECT * FROM tipo_de_actividad WHERE Tipo_de_actividad ='" . $row["Tipo_de_actividad"] . "';";
						$rs_act = mysql_query($sql_act,$con);												
						if($row["Tipo_de_actividad"]==""){
								$color_fondo = "background-color:#ffffff;";
								$color_java = "#ffffff";
								//$traductor->setTipo_de_actividad("");	
						}
						while ($row_act = mysql_fetch_array($rs_act)){
							//$traductor->setTipo_de_actividad($row_act);	
							if(substr($row_act["Color_de_actividad"], 0 , 1)=="#" && (!empty($row_act["Color_de_actividad"]))){
								$color_fondo = "background-color:". $row_act["Color_de_actividad"] . ";";
								$color_java = $row_act["Color_de_actividad"];
							}else if(!empty($row_act["Color_de_actividad"])){
								$color_fondo = "background:url(img/patrones/". $row_act["Color_de_actividad"] . ");";
								$color_java = $row_act["Color_de_actividad"];
							}else{
								$color_fondo = "";
								$color_java = "";
							}						
						}

				if($_SESSION["registrado"] == true && $_SESSION["tipoUsu"]==1){
						if($row["sala_agrupada"]!=0){		
							$queElimino = $row["sala_agrupada"];	
							$salaAgrupada = 1;	
						}else{
							$queElimino = $row["Casillero"];	
							$salaAgrupada = 0;		
						}
				}
				$onk = "";
				$pointer = "cursor:default !important;";
				if($row["Dia_orden"]!=3){
					$onk = "onClick=\"mClk('programaExtendido.php?casillero=" . $row["Casillero"] . "&idioma=" . $_GET["idioma"] . "&sala_=" . $row["Sala_orden"] . "&dia_=" . $row["Dia_orden"] . "')\"";
					$pointer = "cursor:pointer !important";
				}
				
						echo "$color_fondo $pointer ' onMouseOver=\"sobreCasillero('". $row["Casillero"] ."'); \" onMouseOut=\"fueraCasillero('". $row["Casillero"] ."','".$color_java ."')\" $onk>";
												
						$paraImprimi .= "$color_fondo;'>";
			//DROP
			echo '<div class="casillero-drop" data-id="'.$row["Casillero"].'" data-hora_inicio="'.$row["Hora_inicio"].'"><p>DROP HERE</p></div>';
			//Loading
			echo '<div class="cargando-ajax"><p>Cargando...</p></div>';

if($_SESSION["registrado"] == true && $_SESSION["tipoUsu"]==1){

		echo "<div align='right' style='position:absolute; left:0;width:100%;  margin-right:2px; margin-top:2px;text-align: right;'>";

		if($row["sala_agrupada"]!=0){
			echo  "<input type='submit' class='menuEdicion_desagruparSala'  onMouseOver='activ()' onMouseOut='desactiv()' alt='Desagrupar Sala' value='' onClick=\"desagrupar_salas('" . $row["Casillero"] . "','1' , '" .$row["Dia_orden"] . "')\"  />";
			$salaAgrupada = 1;			
		}else{			
			$salaAgrupada = 0;
		}
		
		if($_GET["dia_"]!="10"){
		echo  "<a href='altaCasillero.php?id_casillero=".$row["Casillero"]."' style='background-color: #e8e8e8;
    border: 1px solid #cfcfcf;
    padding: 2px 3px;'><img src='img/b_edit.png'></a>";
		
		echo  "<a href='javascript:void(0)' onclick=\"eliminar_casillero('" . $row["Casillero"] . "','1', '$salaAgrupada','" . $_GET["idioma"] . "')\" style='background-color: #e8e8e8;
    border: 1px solid #cfcfcf;
    padding: 2px 3px; margin-left:1px; margin-right:5px'><img src='img/eliminar.png'></a>";
		}	
		echo "</div>";

}

?>
<table border="0" width="100%" height="100%"  align="center">
<?

$paraImprimi .= "<table width='100%' height='100%'  border='0' cellpadding='0' cellspacing='0'><tr height='1'><td  height='1'>";
if(($row['Tipo_de_actividad']!="Registro sin hora")&&($row['Tipo_de_actividad']!="Posters")){
	echo "<tr><td class='crono_hora' height='1' valign='top'>" . substr($row["Hora_inicio"], 0, -3). " a " . substr($row["Hora_fin"],0 , -3) . " |" ;
}else{
	echo "<tr><td  height='1' valign='top'>";
}
if(($row['Tipo_de_actividad']!="Registro sin hora")&&($row['Tipo_de_actividad']!="Curso sin hora")){
	//echo  "  <span class='crono_tipo_act'>"  . $traductor->getTipo_de_actividad() . "</span>";
	echo  "  <span class='crono_tipo_act'>"  . $row["Tipo_de_actividad"] . "</span>";
	echo "</td>";
	$paraImprimi .= "<span class='CronoHora'>" . substr($row["Hora_inicio"], 0, -3). " a " . substr($row["Hora_fin"],0 , -3) . " | ";
	$paraImprimi .= "</span><span class='CronoTipoAct' style='color:#900'>"  . $row["Tipo_de_actividad"] . "</span><br>";

}else{
	$paraImprimi .= "</span>";
}

echo "</tr>";
$paraImprimi .="</td></tr><tr><td align='left' valign='top' style='padding:10px'>";

////ACA TAMBIEN SE MODIFICAO PARA HACER TITULOS
//if($row['Tipo_de_actividad']!=$tit_act_sin_hora){
	$act= $traductor->getTitulo_de_actividad();

//$act = $traductor->showTituloDeActividad();



//////////////PARA VER CUANTOS TRABAJOS LIBRES HAY EN EL CASILLERO
$cons = "SELECT Trabajo_libre FROM congreso WHERE Casillero ='".$row["Casillero"]."' and Trabajo_libre=1";
$exec = mysql_query($cons, $con);



if(mysql_num_rows($exec)>0){
$lineaNumTls = "<div class='trabajos_crono crono_trab' >";
$lineaNumTls2 = "<b class='crono_trab' >";
	//$cons = "SELECT * FROM trabajos_libres WHERE ID_casillero ='".$row["Casillero"]."' ORDER BY numero_tl;";
	if($row["orden_tl"]=="1"){
		$orden_tl = "orden ASC";
	}else{
		$orden_tl = "Hora_inicio,numero_tl";
	}
	$cons = "SELECT * FROM trabajos_libres WHERE ID_casillero ='".$row["Casillero"]."' ORDER BY $orden_tl;";
	$exec = mysql_query($cons, $con);
	while($rowTrabajos = mysql_fetch_array($exec)){
	
	$lineaNumTls .= "<div align='left'>";
	$lineaNumTls2 .= "<div align='left'>";
	
	$lineaNumTls .= '
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:11px;margin-top:5px">
	 <tr>';
	 $lineaNumTls2 .= '
	<table width="'.($tamano_columna-25) * $row["seExpande"] .'" border="0" cellspacing="0" cellpadding="0" style="font-size:11px;margin-top:5px">
	 <tr>';
	 $lineaNumTls .= "<td valign='top' width='62'><span style='color:gray'>";
	 $lineaNumTls2 .= "<td valign='top' width='62'>";
		
	$primerAutor = 0;
	$paisPrimerAutor = "";
	if($rowTrabajos["Hora_inicio"]!="00:00:00"){
		$lineaNumTls .= substr($rowTrabajos["Hora_inicio"],0,-3)." - ";
		$lineaNumTls2 .= substr($rowTrabajos["Hora_inicio"],0,-3)." - ";
	}
			
			
			$lineaNumTls .=  $rowTrabajos["numero_tl"]."</span></td></tr><tr> <td style='padding-left:5px;'>";
			$lineaNumTls2 .= "<span style='color:gray'>".$rowTrabajos["numero_tl"]."</span></td> <td style='padding-left:5px;'>";
			//$lineaNumTls .= "<span style='color:black;	font-family:Arial, Helvetica, sans-serif;text-transform:uppercase'>".substr($rowTrabajos["titulo_tl"],0,48)."..."."</span>"; 
			$tl_autores = "SELECT * FROM trabajos_libres_participantes as t JOIN personas_trabajos_libres as p ON t.ID_participante=p.ID_Personas WHERE t.ID_trabajos_libres='".$rowTrabajos["ID"]."' ORDER BY t.ID";
			$query_autores = mysql_query($tl_autores,$con); //or die(mysql_error());
			while($rowAutores = mysql_fetch_object($query_autores)){
				
				if($primerAutor==0 && $rowAutores->Pais!=""){
					
					$getPais = mysql_query("SELECT * FROM paises WHERE ID_Paises='".$rowAutores->Pais."'",$con);
					$rowPais = mysql_fetch_array($getPais);
					
					$paisPrimerAutor = " <i style='color:black;font-weight:bold'>(".$rowPais["Pais"].")</i>";
				}
				
				if($rowAutores->lee==1){
				//	$lineaNumTls .= "<br><span style='color:black;font-weight:bold'>".$rowAutores->Nombre." ".$rowAutores->Apellidos." $paisPrimerAutor</span>";
				//	$lineaNumTls2 .= "<br><span style='color:black;font-weight:bold'>".$rowAutores->Nombre." ".$rowAutores->Apellidos." $paisPrimerAutor</span>";
				}
				
				
				$primerAutor++;
				
			}
		$lineaNumTls .= "</td></tr></table></div>";
		$lineaNumTls2 .= "</td></tr></table></div>";
			
		
	}
	$lineaNumTls .= "</div>";
	$cant_trab = mysql_num_rows($exec);
	$numero_trabajos = " <b class='crono_trab' >(". $cant_trab .")</b>";
	$numero_trabajos .= $lineaNumTls;
	$numero_trabajos2 = " <b class='crono_trab' >(". $cant_trab .")</b>";
	$numero_trabajos2 .= $lineaNumTls2;
	/*$numero_trabajos2 = " - (". $cant_trab .")</span><br>";*/
}else{
	$numero_trabajos = "";
	$numero_trabajos2 = "";
	$lineaNumTls2 = "";
}

echo "<tr><td class='crono_trab' style='color:#000000' valign='top'><b>". $act."";
$paraImprimi .= "<span class='CronoTituloAct'><span style='font-size:11px;'><strong>" . $act ."</strong></span>". $numero_trabajos2;

$sql2 = "SELECT * FROM congreso where Casillero='"  . $row["Casillero"] . "' ORDER BY Casillero, Orden_aparicion;";
$rs2 = mysql_query($sql2, $con);
echo "<ul data-casillero='".$row["Casillero"]."' style='margin:5px 0px; padding:0px; list-style:none;' class='sort_conferencistas'>";
while ($row2 = mysql_fetch_array($rs2)){	
	if($row2["en_crono"]==1){
		//$pais = $traductor->getPais($row2['Pais']);
		$pais = ($row2['Pais']?"(".$row2['Pais'].")":"");
		$en_calidad  = $traductor->enCalidad($row2["En_calidad"]);

		echo "<li class='handle' data-id='".$row2["ID"]."' data-persona='".$row2["ID_persona"]."'>";
			echo "<div style='color=#000000; font-weight:normal;margin-top:8px; padding-left:5px'>";				
						if($row2["Titulo_de_trabajo"]!=""){
							echo "<div>".$row2["Titulo_de_trabajo"]."</div>";
						}
						//if(!empty($en_calidad))
							echo "<div style='float:left;width:32%;'><i>" .$en_calidad .  "&nbsp;</div>";
							echo "<div style='float:left;width:68%;'>
									<strong>" . $row2["Nombre"] . " " . $row2["Apellidos"] . "</strong> $pais</i></span>
								  </div>";
						echo '<div style="clear:both"></div>';
			echo "</div>";
		echo "</li>";
//			echo "'><i>" .$en_calidad . $row2["Profesion"] . " <strong>" . $row2["Nombre"] . " " . $row2["Apellidos"] . "</strong> $pais</i></span><br>";
		$paraImprimi .= "<br>".$row2["Titulo_de_trabajo"]."<br>";
		$paraImprimi .= "<span class='CronoAutor'><i>&nbsp;&nbsp;&nbsp;&nbsp;" . $en_calidad  . " <b><span style='font-size:11px'>" . $row2["Nombre"] . " " . $row2["Apellidos"] ."</span></b> $pais</i></span>";
//		$paraImprimi .= "<span class='CronoAutor'><i> - " . $en_calidad  . $row2["Profesion"] . " <b><span style='font-size:10px'>" . $row2["Nombre"] . " " . $row2["Apellidos"] ."</span></b> $pais</i></span>";
		

	}

}
echo "</ul>";

echo "<span class='crono_trab'>".$numero_trabajos."</span>";

echo "</td></tr></table>";
$paraImprimi .= "</td></tr></table>";
//-------------------------------

echo "</div>\n";
$paraImprimi .= "</div>\n";
$casillero_anterior = $row["Casillero"];
					}
				}
			}
			echo "</div>";
			$desplasamientoDerecha = $desplasamientoDerecha + 1;
		}
$_SESSION["paraImprimir"] = $paraImprimi;
?>