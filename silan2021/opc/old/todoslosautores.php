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


$sqlparticipan = "SELECT DISTINCT (ID_Personas) FROM personas_trabajos_libres as ptl, trabajos_libres_participantes as tlp, trabajos_libres as tl WHERE ptl.ID_Personas  = tlp.ID_participante AND tl.estado = 2";
$rsparticipan = mysql_query($sqlparticipan, $con);
$total_participan = mysql_num_rows($rsparticipan);


?>
<title>AUTORES - Presionar Ctrl + E (para seleccionar) y luego Ctrl + C (para Copiar). Luego pegarlo en un excel</title>
<table width="98%" height="39" border="1"  bordercolor="#000000" cellspacing="0">
<tr>	
	<td width="14%" align="center"><strong>Código Trabajo <?=$totalTLS;?></strong></td>
	<td width="11%" align="center"><strong>Titulo Trabajo</strong></td>	
	<td width="5%" align="center"><strong>Idioma</strong></td>	
	<td width="3%" align="center"><strong>País</strong></td>
	<td width="4%" align="center"><strong>Mail</strong></td>
	<td width="14%" align="center"><strong>Apellido Autor (<?=$total_participan?>)</strong></td>
	<td width="11%" align="center"><strong>Nombre Autor</strong></td>
	<td width="14%" align="center"><strong>Presentadores (<?=$total_leen;?>)</strong></td>
	<td width="11%" align="center"><strong>Inscriptos (<?=$total_inscriptos;?>)</strong></td>
	<td width="7%" align="center"><strong>Teléfono</strong></td>	
	<td width="6%" align="center"><strong>Estado</strong></td>	
	
</tr>
<?


$sql = "SELECT * FROM trabajos_libres ORDER BY estado, numero_tl ASC";
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){
	if($row["estado"]==0){$NomEstado = "No Revisado";}
	elseif($row["estado"]==1){$NomEstado = "En Revisión";}
	elseif($row["estado"]==2){$NomEstado = "Aprobado";}
	elseif($row["estado"]==3){$NomEstado = "Rechazado";}

//	echo "<tr><td>".$NomEstado."&nbsp;</td>";
	
	/*echo "<td>".$row["tipo_tl"]."&nbsp;</td>";
	echo "<td>".$row["area_tl"]."&nbsp;</td>";
	echo "<td>".$row["mailContacto_tl"]."&nbsp;</td>";*/
	$coautores ="";
	$autor1 = false;
	$sql3 = "SELECT * FROM trabajos_libres_participantes WHERE ID_Trabajos_libres = ". $row["ID"] .  " ORDER BY ID ASC";
	$rs3 = mysql_query($sql3, $con);
	while($row3=mysql_fetch_array($rs3)){
$lee = "";
if($row3["lee"]==1){$lee = "Presentador";}	
		
		$sql2 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $row3["ID_participante"] . " LIMIT 1";

		$rs2 = mysql_query($sql2, $con);
		while($row2=mysql_fetch_array($rs2)){
			//if($autor1 == false){
			$ins = "";
			
				echo "<tr>";
				echo "<td>".$row["numero_tl"]."&nbsp;</td>";
				/*if($row["ID"]<=9){
					$ID = "00" . $row["ID"];
				}
				elseif($row["ID"]<=99){
					$ID = "0" . $row["ID"];
				}
				else{
					$ID = $row["ID"];
				}
				echo "<td  align='center'>".$ID."&nbsp;</td>";*/
				echo "<td>".$row["titulo_tl"]."&nbsp;</td>";
				echo "<td>".$row["idioma"]."&nbsp;</td>";
				echo "<td>".$row2["Pais"]."&nbsp;</td>";
				echo "<td>".$row2["Mail"]."&nbsp;</td>";
				echo "<td>".$row2["Apellidos"]."</td>";
				echo "<td>".$row2["Nombre"]."</td>";
								
				echo "<td>".$lee."&nbsp;</td>";
				
				if($row2["inscripto"]==1){$ins = "Inscripto";}				
				echo "<td>".$ins."&nbsp;</td>";
				echo "<td>".$row["telefono"]."&nbsp;</td>";
				echo "<td>".$NomEstado."&nbsp;</td>";
				echo "</tr>";
			/*	$autor1 = true;
			}
			else{
				$coautores .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
			}*/

		}

	}
	/*echo "<td>".$coautores."&nbsp;</td>";
	echo "<td>".$row["archivo_tl"]."&nbsp;</td></tr>";*/
	
}
?>
</table>
