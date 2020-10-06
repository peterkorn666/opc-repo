<?
session_start();
header("Content-Disposition: attachment; filename=Todos_los_Trabajos_".date("Ymd").".xls");
require_once("../class/core.php");
require_once("../class/util.class.php");
$util = new util();
$core = new core();
$util->isLogged();
$config = $core->getConfig();


function rem($stirng)
{
	$array = array("<br>","<br />","<br/>");
	$por = array(" "," "," ");
	$string = str_replace($array,$por,$stirng);
	return $string;
}

$sqlTOTAL = "SELECT DISTINCT(id_trabajo) FROM trabajos_libres ";
$rsTOTAL = $core->query($sqlTOTAL);
$totalTLS = count($rsTOTAL);

$sql = "SELECT ID_Personas FROM personas_trabajos_libres WHERE inscripto = 1";
$rs = $core->query($sql);
$total_inscriptos = count($rs);

$sql123 = "SELECT DISTINCT(ID_participante) FROM trabajos_libres_participantes WHERE lee = 1";
$rs123 = $core->query($sql123);
$total_leen = count($rs123);
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<table width="98%" height="94" border="1" cellspacing="0">

	<tr>
        <td>ID</td>
        <td>Código <?=$totalTLS?></td>
        <td>Clave</td>	
        <td>Dia</td>
        <td>Sala</td>
        <td>Hora inicio</td>
        <td>Tematica</td>
        <td>Tipo de Actividad</td>
        <td>Título de actividad</td>
        <td>Postula a premio</td>
        <td>Título</td>
        <td>Título Nuevo</td>
        <td>Introducción</td>
        <td>Objetivo</td>
        <td>Material y Método</td>
        <td>Resultados</td>
        <td>Caso(s) clínico(s)</td>
        <td>Conclusiones</td>
        <td>Área</td>
        <td>Modalidades de Presentación</td>
        <td>Mail de Contacto</td>
        <td>Institución</td>
        <td>País</td>
        <td>Apellido del 1er Autor</td>
        <td>Nombre del 1er Autor</td>
        
        <td>Apellido del 2ndo Autor</td>
        <td>Nombre del 2ndo Autor</td>	
        
        <td>Coautores</td>
        <td>Diploma</td>
        <td>Nombres Presentadores <?=$total_leen?></td>
        <td>Apellidos Presentadores <?=$total_leen?></td>
        <td>Presentador Inscripto <?=$total_inscriptos?></td>
        <td>Estado</td>

	</tr>
<?php
	$sql = "SELECT * FROM trabajos_libres WHERE estado <> 3 ORDER BY numero_tl ";
	$rs = $core->query($sql);
	foreach($rs as $row){
	if($row["estado"]==0){$NomEstado = "Recibidos";}
	elseif($row["estado"]==1){$NomEstado = "En Revisión";}
	elseif($row["estado"]==2){$NomEstado = "Aprobado";}
	elseif($row["estado"]==4){$NomEstado = "Notificados";}
	//elseif($row["estado"]==3){$NomEstado = "Rechazado";}

	/*echo "<tr><td>".$NomEstado."&nbsp;</td>";*/
	$sql4="SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid WHERE id_crono = ".$row['id_crono'];
$rs4 = $core->query($sql4);
foreach($rs4 as $row4){
	$UbicaDiaOrden=$row4["start_date"];
	$UbicaDia=$row4["start_date"];
	$UbicaSalaOrden=$row4["orden"];
	$UbicaSala=$row4["name"];
	$UbicaHoraInicio=$row4["start_date"];
	$Titulo_de_actividad=$row4["titulo_actividad"];
	if($row4["tipo_actividad"])
		$tipo_actividad = $core->getNameTipoActividadID($row4["tipo_actividad"])["tipo_actividad"];
	else
		$tipo_actividad = "";
	if($row4["tematica"])
		$tematica = $core->getTematicaID($row4["tematica"])["Tematica"];
	else
		$tematica = "";
}
	$coautores ="";
	$diploma = "";
	$autor1 = false;
	$inscript ="&nbsp;";
	$IDPresentador=0;
	$sql3 = "SELECT * FROM trabajos_libres_participantes WHERE ID_Trabajos_libres = ". $row["id_trabajo"] .  " ORDER BY ID ASC";
	$rs3 = $core->query($sql3);
	$cantAutores = count($rs3);
	$ia = 0;
	$tieneCoautor = false;
?>
	<tr>
	<td height="22" align="center"><?=$row["id_trabajo"]?></td>
	<td align="center"><?=$row["numero_tl"]?>&nbsp;</td>
	<td align="center"><?=$row["clave"]?></td>
	<td><?php
		if($row4["start_date"])
	    	echo strftime($config["time_format"],strtotime($core->helperDate($row4["start_date"],0,10)));
		?>
    </td>
	<td><?=$row4["name"]?></td>
	<td><?=$core->helperDate($row4["start_date"],10,6)?>&nbsp;</td>
	<td><?=$tematica?></td>
	<td><?=$tipo_actividad?></td>
	<td><?=$Titulo_de_actividad?></td>
    <td align="center" valign="center"><?=$row["premio"]?></td>
	<td valign="top"><?=rem($row["titulo_tl"])?></td>
	<td valign="top"><?=ucfirst(mb_strtolower(rem($row["titulo_tl"]),"utf-8"))?></td>
	<td valign="top"><?=rem($row["resumen"])?></td>
	<td valign="top"><?=rem($row["resumen2"])?></td>
	<td valign="top">
    <?php
	if ($row["tipo_tl"]=="1")
    	echo rem($row["resumen3"]);
	else if ($row["tipo_tl"]=="2")
		echo "";
	?></td>
	<td valign="top"><?php
	if ($row["tipo_tl"]=="1")
    	echo rem($row["resumen4"]);
	else if ($row["tipo_tl"]=="2")
		echo "";
	?></td>
    <td valign="top">
	<?php
    if ($row["tipo_tl"]=="2")
		echo rem($row["resumen3"]);
	else if ($row["tipo_tl"]=="1")
		echo "";
	?></td>
	<td valign="top"><?=rem($row["resumen5"])?></td>
	<td valign="top"><?=$core->getAreasTLID($row["area_tl"])?></td>
	<td><?=$core->getTipoTLID($row["tipo_tl"])["tipoTL_es"]?></td>
	<td><?=$row["contacto_mail"]?></td>
<?php	
	foreach($rs3 as $row3){
	
	if($row3["lee"]==1){$IDPresentador = $row3["ID_participante"];}

		$sql2 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $row3["ID_participante"] . " LIMIT 1";
		$rs2 = $core->query($sql2);
		$row2 = $rs2[0];
		$inscriptoPresentador = $row2["inscripto"];	
		if($inscriptoPresentador==1){
			$inscriptoPresentador = "inscripto";
		}else{
			$inscriptoPresentador = "";
		}
			
		if($ia==0){		
			if(!empty($row2["Institucion"]))
				$getInstitucion = $core->query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row2["Institucion"]."'");		
				
			echo '<td>'.$getInstitucion[0]["Institucion"].'</td>';
			$pais = '';
			if($row2["Pais"])
				$pais = $core->getPaisID($row2["Pais"]);
			echo '<td>'.$pais.'</td>';
			echo '<td>'.$row2["Apellidos"].'</td>';
			echo '<td>'.$row2["Nombre"].'</td>';
		}else{
			$coautores .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
		}
				
			
			if($ia==1)
			{
				echo '<td>'.$row2["Apellidos"].'</td>';
				echo '<td>'.$row2["Nombre"].'</td>';
				$tieneCoautor = true;
			}		
			
			$ia++;
			if($ia==$cantAutores && !$tieneCoautor)
			{
				echo '<td>&nbsp;</td>';
				echo '<td>&nbsp;</td>';
			}
					
			if($row2["inscripto"]==1){
				$inscript .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
			}
			
			$diploma .=	$row2["Nombre"]." ".$row2["Apellidos"]."; ";
		}	
$presentador="";
$sql22 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $IDPresentador . " LIMIT 1";
$rs22 = $core->query($sql22);
$row22 = $rs22[0];
$presentadorNombre = $row22["Nombre"];
$presentadorApellido = $row22["Apellidos"];	

if($row["archivo_tl"]!=""){
	$archivotl = $row["archivo_tl"];
}else{
	$archivotl = "No";
}
?>
	<td><?=$coautores?></td>
	<td><?=$diploma?></td>	
		
	<td><?=$presentadorNombre?></td>	
	<td><?=$presentadorApellido?></td>	
	<td><?=$inscript?></td>	
	<td><?=$NomEstado?></td>
	
	
	</tr>
<?    
	$UbicaDiaOrden="";
	$UbicaDia="";
	$UbicaSalaOrden="";
	$UbicaSala="";
	$UbicaHoraInicio="";
}
?>
</table>


