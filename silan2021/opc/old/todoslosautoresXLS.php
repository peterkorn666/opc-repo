<?
header("Content-Disposition: attachment; filename=Todos_los_Autores.xls");
include('inc/sesion.inc.php');
require "conexion.php";
//require "clases/trabajoslibres.php";

function echotd($contenido,$prop)
{
	if($contenido==""){
		$contenido="&nbsp;";
	}
	echo "<td $prop>$contenido</td>";
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


$sqlparticipan = "SELECT DISTINCT (ID_Personas) FROM personas_trabajos_libres as ptl, trabajos_libres_participantes as tlp, trabajos_libres as tl WHERE ptl.ID_Personas  = tlp.ID_participante AND tl.estado = 2";
$rsparticipan = mysql_query($sqlparticipan, $con);
$total_participan = mysql_num_rows($rsparticipan);
?>
<meta charset="utf-8">
<table width="98%" height="39" border="1"  bordercolor="#000000" cellspacing="0">
	<tr>
	  <td>ID</td>	
	<td>C&oacute;digo Trabajo <?=$totalTLS?></td>
	<td>Titulo Trabajo</td>
	<td>Titulo Nuevo</td>
	<td>Idioma</td>
	<td>País</td>
	<td>Mail</td>
	<td>ID Autor</td>
	<td>Apellido Autor (<?=$total_participan?>)</td>
	<td>Nombre Autor</td>
	<td>Apellido Autor nuevo</td>
	<td>Nombre Autor Nuevo</td>
	<td>Pais Autor</td>
	<td>Institucion Autor</td>
	<td>Mail Autor</td>
	<td>Presentadores (<?=$total_leen?>)</td>
	<td>Inscriptos (<?=$total_inscriptos?>)</td>
	<td>Inscriptos nuevos</td>
	<td>Teléfono</td>
	<td>Estado</td>	
</tr>

<?php
$sql = "SELECT * FROM trabajos_libres ORDER BY estado, numero_tl ASC";
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){
	if($row["estado"]==0){$NomEstado = "No Revisado";}
	elseif($row["estado"]==1){$NomEstado = "En Revisión";}
	elseif($row["estado"]==2){$NomEstado = "Aprobado";}
	elseif($row["estado"]==3){$NomEstado = "Rechazado";}

	$coautores ="";
	$autor1 = false;
	$sql3 = "SELECT * FROM trabajos_libres_participantes WHERE ID_Trabajos_libres = ".$row["ID"]." ORDER BY ID ASC";
	$rs3 = mysql_query($sql3, $con);
	while($row3=mysql_fetch_array($rs3)){
$lee = "";
if($row3["lee"]==1){$lee = "Presentador";}	
		
		$sql2 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $row3["ID_participante"] . " LIMIT 1";

		$rs2 = mysql_query($sql2, $con);
		while($row2=mysql_fetch_array($rs2)){
			//if($autor1 == false){
			$ins = "";
			if($row2["inscripto"]==1){$ins = "Inscripto";}
			else{$ins = "No inscripto";}
?>
<tr>
  				<td><?=$row["ID"]?></td>
				<td><?=$row["numero_tl"]?></td>
				<td><?=$row["titulo_tl"]?></td>
				<td style="text-transform:capitalize">
					<?
						if($titulo_viejo!=$row["titulo_tl"]){
                			echo ucfirst(mb_strtolower($row["titulo_tl"],"UTF-8"));
						}
						$titulo_viejo = $row["titulo_tl"];
					?>
                </td>
				<td><?=$row["idioma"]?></td>
				<td><?=$row2["Pais"]?></td>
				<td><?=$row2["Mail"]?></td>
				<td><?=$row2["ID_Personas"]?></td>
				<td><?=$row2["Apellidos"]?></td>
				<td><?=$row2["Nombre"]?></td>
				<td style="background-color:#F7F7F7"><?=ucfirst(strtolower($row2["Apellidos"]))?></td>
				<td style="background-color:#F7F7F7"><?=ucfirst(strtolower($row2["Nombre"]))?></td>
				<td><?=$row2["Pais"]?></td>
				<td><?=$row2["Institucion"]?></td>
				<td><?=$row2["Mail"]?></td>
				<td><?=$lee?></td>				
				<td><?=$ins?></td>				
				<td><?=$vacio?></td>
				<td><?=$row["telefono"]?></td>
				<td><?=$NomEstado?></td>
<?php                
$vacio="";
		}

	}	
}
?>
</table>

