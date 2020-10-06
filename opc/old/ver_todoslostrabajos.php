<?
include('inc/sesion.inc.php');
require "conexion.php";
function echotd($contenido,$bg,$prop="")
{
	echo "<td $bg $prop>$contenido</td>";
}
$sqlTOTAL = "SELECT DISTINCT(ID) FROM trabajos_libres ";
$rsTOTAL = mysql_query($sqlTOTAL, $con);
$totalTLS = mysql_num_rows($rsTOTAL);
$sql = "SELECT DISTINCT ID_Personas FROM personas_trabajos_libres WHERE inscripto = 1";
$rs = mysql_query($sql, $con);
$total_inscriptos = mysql_num_rows($rs);
$sql123 = "SELECT DISTINCT(ID_participante) FROM trabajos_libres_participantes WHERE lee = 1";
$rs123 = mysql_query($sql123, $con);
$total_leen = mysql_num_rows($rs123);
echo '<table width="98%" height="39" border="1" cellspacing="0" cellpadding="5">';
echo "<tr>";
	echotd("Código ".$totalTLS,"bgcolor=#CCCCCC","nowrap");
	echotd("Orden Día","bgcolor=#CCCCCC","nowrap");
	echotd("Dia","bgcolor=#CCCCCC","nowrap");
	echotd("Hora inicio","bgcolor=#CCCCCC","nowrap");
	echotd("Título","bgcolor=#CCCCCC","nowrap");
	echotd("Trabajo completo","bgcolor=#CCCCCC","nowrap");
	echotd("Eje temático","bgcolor=#CCCCCC","nowrap");
	echotd("Idioma","bgcolor=#CCCCCC","nowrap");
	echotd("Presentación","bgcolor=#CCCCCC","nowrap");
	echotd("Área","bgcolor=#CCCCCC","nowrap");
	echotd("Mail de Contacto","bgcolor=#CCCCCC","nowrap");
	echotd("Apellido de Autor","bgcolor=#CCCCCC","nowrap");
	echotd("Nombre de Autor","bgcolor=#CCCCCC","nowrap");
	echotd("Institución","bgcolor=#CCCCCC","nowrap");
	echotd("País","bgcolor=#CCCCCC","nowrap");
	echotd("Coautores","bgcolor=#CCCCCC","nowrap");
	echotd("Presentadores ". $total_leen,"bgcolor=#CCCCCC","nowrap");	
	echotd("Inscriptos ".$total_inscriptos,"bgcolor=#CCCCCC","nowrap");
	echotd("Teléfono", "bgcolor=#CCCCCC","nowrap");
	echotd("Estado", "bgcolor=#CCCCCC","nowrap");
	echotd("Envios Realizados", "bgcolor=#CCCCCC","nowrap");
echo "</tr>";

$sql = "SELECT * FROM trabajos_libres WHERE 1 ORDER BY numero_tl ";
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){
	if($row["estado"]==0){$NomEstado = "No Revisado";}
	elseif($row["estado"]==1){$NomEstado = "En Revisión";}
	elseif($row["estado"]==2){$NomEstado = "Aprobado";}
	elseif($row["estado"]==3){$NomEstado = "Rechazado";}
	$sql4="SELECT Dia, Dia_orden, Sala, Sala_orden, Hora_inicio, Hora_fin FROM congreso WHERE Casillero = ".$row['ID_casillero'];
$rs4 = mysql_query($sql4, $con);
while($row4=mysql_fetch_array($rs4)){
	$UbicaDiaOrden=$row4["Dia_orden"];
	$UbicaDia=$row4["Dia"];
	$UbicaSalaOrden=$row4["Sala_orden"];
	$UbicaSala=$row4["Sala"];
	$UbicaHoraInicio=$row4["Hora_inicio"];	
}
	echo "<tr>";
	if($row["ID"]<=9){
		$ID = "00" . $row["ID"];
	}
	else if($row["ID"]<=99){
		$ID = "0" . $row["ID"];
	}
	else{
		$ID = $row["ID"];
	}
	echotd($row["numero_tl"]."&nbsp;","bgcolor=#FFFFFF  align='center'");
	echotd($UbicaDiaOrden."&nbsp;","bgcolor=#FFFFFF");
	echotd($UbicaDia."&nbsp;","bgcolor=#FFFFFF");
	echotd($UbicaHoraInicio."&nbsp;","bgcolor=#FFFFFF");	
	echotd($row["titulo_tl"]."&nbsp;","bgcolor=#FFFFFF");
	if($row["archivo_trabajo_comleto"]!=""){
		echotd($row["archivo_trabajo_comleto"]."&nbsp;","bgcolor=#FFFFFF");
	}else{
		echotd("No tiene","bgcolor=#FFFFFF");
	}
	echotd($row["tematicaTL"]."&nbsp;","bgcolor=#FFFFFF");
	echotd($row["idioma"]."&nbsp;","bgcolor=#FFFFFF");
	echotd($row["tipo_tl"]."&nbsp;","bgcolor=#FFFFFF");
	echotd($row["area_tl"]."&nbsp;","bgcolor=#FFFFFF");
	echotd($row["mailContacto_tl"]."&nbsp;","bgcolor=#FFFFFF");
	$coautores ="";
	$autor1 = false;
	$inscript ="&nbsp;";
	$IDPresentador=0;
	$sql3 = "SELECT * FROM trabajos_libres_participantes WHERE ID_Trabajos_libres = ". $row["ID"] .  " ORDER BY ID ASC";
	$rs3 = mysql_query($sql3, $con);
	while($row3=mysql_fetch_array($rs3)){	
		if($row3["lee"]==1){$IDPresentador = $row3["ID_participante"];}
	
			$sql2 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $row3["ID_participante"] . " LIMIT 1";
			$rs2 = mysql_query($sql2, $con);
			while($row2=mysql_fetch_array($rs2)){			
				if($autor1 == false){
					echotd($row2["Apellidos"]."&nbsp;","bgcolor=#FFFFFF");
					echotd($row2["Nombre"]."&nbsp;","bgcolor=#FFFFFF");
					echotd($row2["Institucion"]."&nbsp;","bgcolor=#FFFFFF");
					echotd($row2["Pais"]."&nbsp;","bgcolor=#FFFFFF");
					$autor1 = true;
				}else{
					$coautores .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
				}			
				if($row2["inscripto"]==1){
					$inscript .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
				}	
			}
		}	
	echotd($coautores."&nbsp;","bgcolor=#FFFFFF");
	$presentador="";
	$sql22 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $IDPresentador . " LIMIT 1";
	$rs22 = mysql_query($sql22, $con);
	while($row22=mysql_fetch_array($rs22)){
		$presentador=$row22["Apellidos"];
	}
	echotd($presentador."&nbsp;","bgcolor=#FFFFFF");
	echotd($inscript."&nbsp;","bgcolor=#FFFFFF");
	echotd($row["telefono"]."&nbsp;","bgcolor=#FFFFFF");
	echotd($NomEstado."&nbsp;","bgcolor=#FFFFFF");
	echotd($row["enviosRealizados"]."&nbsp;","bgcolor=#FFFFFF");
	echo "</tr>";
}
echo "</table>";
?>