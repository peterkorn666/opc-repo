<?php
session_start();
header("Content-Disposition: attachment; filename=Todos_los_Autores_".date("Ymd").".xls");
header('Content-Type: text/html; charset=utf-8');
require_once("../class/core.php");
require_once("../class/util.class.php");
$util = new util();
$core = new core();
$util->isLogged();
$config = $core->getConfig();

function echotd($contenido,$prop)
{
	if($contenido==""){
		$contenido="&nbsp;";
	}
	echo "<td $prop>$contenido</td>";
}


$sqlTOTAL = "SELECT DISTINCT(id_trabajo) FROM trabajos_libres ";
$rsTOTAL = $core->query($sqlTOTAL);
$totalTLS = count($rsTOTAL);

$sql = "SELECT DISTINCT ID_Personas FROM personas_trabajos_libres WHERE inscripto = 1";
$rs = $core->query($sql);
$total_inscriptos = count($rs);

$sql123 = "SELECT DISTINCT(ID_participante) FROM trabajos_libres_participantes WHERE lee = 1";
$rs123 = $core->query($sql123);
$total_leen = count($rs123);


$sqlparticipan = "SELECT DISTINCT (ID_Personas) FROM personas_trabajos_libres as ptl, trabajos_libres_participantes as tlp, trabajos_libres as tl WHERE ptl.ID_Personas  = tlp.ID_participante AND tl.estado = 2";
$rsparticipan = $core->query($sqlparticipan);
$total_participan = count($rsparticipan);
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
$rs = $core->query($sql);
foreach($rs as $row){
	if($row["estado"]==0){$NomEstado = "No Revisado";}
	elseif($row["estado"]==1){$NomEstado = "En Revisión";}
	elseif($row["estado"]==2){$NomEstado = "Aprobado";}
	elseif($row["estado"]==3){$NomEstado = "Rechazado";}

	$coautores ="";
	$autor1 = false;
	$sql3 = "SELECT * FROM trabajos_libres_participantes WHERE ID_Trabajos_libres = ".$row["id_trabajo"]." ORDER BY ID ASC";
	$rs3 = $core->query($sql3);
	foreach($rs3 as $row3){
$lee = "";
if($row3["lee"]==1){$lee = "Presentador";}	
		
		$sql2 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $row3["ID_participante"] . " LIMIT 1";

		$rs2 = $core->query($sql2);
		foreach($rs2 as $row2){
			//if($autor1 == false){
			$ins = "";
			if($row2["inscripto"]==1){$ins = "Inscripto";}
			else{$ins = "No inscripto";}
?>
<tr>
  				<td><?=$row["id_trabajo"]?></td>
				<td><?=$row["numero_tl"]?>&nbsp;</td>
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
				<td><?
					$pais = '';
                	if($row2["Pais"])
						$pais = $core->getPaisID($row2['Pais']);
					echo $pais;
				?></td>
				<td><?=$row2["Mail"]?></td>
				<td><?=$row2["ID_Personas"]?></td>
				<td><?=$row2["Apellidos"]?></td>
				<td><?=$row2["Nombre"]?></td>
				<td style="background-color:#F7F7F7"><?=$row2["Apellidos"]?></td>
				<td style="background-color:#F7F7F7"><?=$row2["Nombre"]?></td>
				<td><?
					$pais = '';
                	if($row2["Pais"])
						$pais = $core->getPaisID($row2['Pais']);
					echo $pais;
				?></td>
				<td><?php
					$inst = '';
                	if($row2["Institucion"])
						$inst = $core->getInstitution($row2["Institucion"]);
					echo $inst['Institucion'];
				?></td>
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

