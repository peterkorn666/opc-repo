<?
//include ('inc/sesion.inc.php');
include('inc/sesion.inc.php');
include('conexion.php');
$sqlTOTAL = "SELECT DISTINCT(ID) FROM trabajos_libres ";
$rsTOTAL = mysql_query($sqlTOTAL, $con);
$totalTLS = mysql_num_rows($rsTOTAL);

$sql = "SELECT DISTINCT ID_Personas FROM personas_trabajos_libres WHERE inscripto = 1";
$rs = mysql_query($sql, $con);
$total_inscriptos = mysql_num_rows($rs);

$sql123 = "SELECT DISTINCT(ID_participante) FROM trabajos_libres_participantes WHERE lee = 1";
$rs123 = mysql_query($sql123, $con);
$total_leen = mysql_num_rows($rs123);

?>
<title>TRABAJOS - Presionar Ctrl + E (para seleccionar) y luego Ctrl + C (para Copiar). Luego pegarlo en un excel</title>
<table width="98%" height="39" border="1" cellspacing="0">
<tr >
	<td width="6%" align="center"><strong>Código <?=$totalTLS;?></strong></td>
	<td width="6%" align="center"><strong>Título</strong></strong></td>
	<td width="6%" align="center"><strong>Idioma</strong></strong></td>
	<td width="10%" align="center"><strong>Presentación</strong></td>
	<td width="4%" align="center"><strong>Área</strong></td>
	<td width="13%" align="center"><strong>Mail de Contacto</strong></td>
	<td width="13%" align="center"><strong>Apellido de Autor</strong></td>
	<td width="13%" align="center"><strong>Nombre de Autor</strong></td>
	<td width="8%" align="center"><strong>Institución</strong></td>
	<td width="4%" align="center"><strong>País</strong></td>
	<td width="8%" align="center"><strong>Coautores</strong></td>
	<td width="8%" align="center"><strong>Presentadores <?=$total_leen?></strong></td>	
	<td width="8%" align="center"><strong>Inscriptos <?=$total_inscriptos?></strong></td>
	<td width="8%" align="center"><strong>Teléfono</strong></td>
	<? //<td width="15%" align="center"><strong>Nombre de Archivo</strong></td>?>
	
</tr>
<?


$sql = "SELECT * FROM trabajos_libres";
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){
	if($row["estado"]==0){$NomEstado = "No Revisado";}
	elseif($row["estado"]==1){$NomEstado = "En Revisión";}
	elseif($row["estado"]==2){$NomEstado = "Aprobado";}
	elseif($row["estado"]==3){$NomEstado = "Rechazado";}

	/*echo "<tr><td>".$NomEstado."&nbsp;</td>";*/
	echo "<tr>";
	//echo "<td>".$row["numero_tl"]."&nbsp;</td>";
	if($row["ID"]<=9){
		$ID = "00" . $row["ID"];
	}
	elseif($row["ID"]<=99){
		$ID = "0" . $row["ID"];
	}
	else{
		$ID = $row["ID"];
	}
	echo "<td align='center'>".$row["numero_tl"]."&nbsp;</td>";
	echo "<td>".$row["titulo_tl"]."&nbsp;</td>";
	echo "<td>".$row["idioma"]."&nbsp;</td>";
	echo "<td>".$row["tipo_tl"]."&nbsp;</td>";
	echo "<td>".$row["area_tl"]."&nbsp;</td>";
	echo "<td>".$row["mailContacto_tl"]."&nbsp;</td>";
	$coautores ="";
	$autor1 = false;
	$inscript ="&nbsp";
	$IDPresentador=0;
	$sql3 = "SELECT * FROM trabajos_libres_participantes WHERE ID_Trabajos_libres = ". $row["ID"] .  " ORDER BY ID ASC";
	$rs3 = mysql_query($sql3, $con);
	while($row3=mysql_fetch_array($rs3)){
	
	if($row3["lee"]==1){$IDPresentador = $row3["ID_participante"];}

		$sql2 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $row3["ID_participante"] . " LIMIT 1";
		$rs2 = mysql_query($sql2, $con);
		while($row2=mysql_fetch_array($rs2)){
		
			if($autor1 == false){
				echo "<td>".$row2["Apellidos"]."</td>";
				echo "<td>".$row2["Nombre"]."</td>";
				echo "<td>".$row2["Institucion"]."&nbsp;</td>";
				echo "<td>".$row2["Pais"]."&nbsp;</td>";
				$autor1 = true;
			}
			else{
				$coautores .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
			}			
			if($row2["inscripto"]==1){
				$inscript .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
			}		
	
			/*if($presID == $row2["ID_Personas"]){
				$presentador = $row2["Apellidos"];
			}	*/
		}
	}	
	echo "<td>".$coautores."&nbsp;</td>";	
	$presentador="";
		$sql22 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $IDPresentador . " LIMIT 1";
		$rs22 = mysql_query($sql22, $con);
		while($row22=mysql_fetch_array($rs22)){
			$presentador=$row22["Apellidos"];
		}
	echo "<td>".$presentador."</td>";
	echo "<td>".$inscript."</td>";		
	echo "<td>".$row["telefono"]."&nbsp;</td>";
	//echo "<td>".$row["archivo_trabajo_comleto"]."&nbsp;</td></tr>";.
	echo "</tr>";
}
?>

</table>