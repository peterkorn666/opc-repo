<?
session_start();
header("Content-Disposition: attachment; filename=Todos_los_Trabajos_".date("Y-m-d").".xls");
require_once("../class/core.php");
require_once("../class/util.class.php");
$util = new util();
$core = new core();
$util->isLogged();
$config = $core->getConfig();


function rem($stirng)
{
	$array = array("<br>","<br />","<br/>","&nbsp;","&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;");
	$por = array(" "," "," ");
	$string = str_replace($array,$por,$stirng);
	return $string;
}

$sqlTOTAL = "SELECT DISTINCT(id_trabajo) FROM trabajos_libres ";
$rsTOTAL = $core->query($sqlTOTAL);
$totalTLS = count($rsTOTAL);

/*$sql_trabajos_completos = "SELECT * FROM trabajos_libres where archivo_tl";
$trabajos_completos= $core->query($sql_trabajos_completos);*/


$sql = "SELECT ID_Personas FROM personas_trabajos_libres WHERE inscripto = 1";
$rs = $core->query($sql);
$total_inscriptos = count($rs);

$sql123 = "SELECT DISTINCT(ID_participante) FROM trabajos_libres_participantes WHERE lee = 1";
$rs123 = $core->query($sql123);
$total_leen = count($rs123);
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<table width="98%" height="94" border="1" cellspacing="0">

	<tr bgcolor="#ffff00" align="left" style="font-weight: bold; height: 60px;">
        <td style="vertical-align: middle;">ID</td>
        <td style="vertical-align: middle;">Código <?=$totalTLS?></td>
        <td style="vertical-align: middle;">Clave</td>	
        <td style="vertical-align: middle;">Trabajo Completo</td>	
        <td style="vertical-align: middle;">Dia</td>
        <td style="vertical-align: middle;">Orden Día</td>
        <td style="vertical-align: middle;">Sala</td>
        <td style="vertical-align: middle;">Orden Sala</td>
        <td style="vertical-align: middle;">Hora inicio</td>
        <td style="vertical-align: middle;">Hora fin</td>
        <td style="vertical-align: middle;">Tematica</td>
        <td style="vertical-align: middle;">Tipo de Actividad</td>
        <td style="vertical-align: middle;">Título de actividad</td>
        <td style="vertical-align: middle;">Título</td>
        <!--<td style="vertical-align: center;">Título Nuevo</td>-->
        <!--<td style="vertical-align: center;">Áreas</td>-->
        <!--<td style="vertical-align: middle;">Tipo TL</td>-->
        <td style="vertical-align: middle;">Modalidad</td>
        <td style="vertical-align: middle;">Individual o mesa</td>
        <td style="vertical-align: middle;">Apoyo audiovisual</td>
        <td style="vertical-align: middle;">Responsable de la Traducción</td>
        <td style="vertical-align: middle;">Mail de Contacto</td>
        <td style="vertical-align: middle;">Pertenencia</td>
        <td style="vertical-align: middle;">Institución</td>
        <td style="vertical-align: middle;">País</td>
        <td style="vertical-align: middle;">Apellido del 1er Autor</td>
        <td style="vertical-align: middle;">Nombre del 1er Autor</td>
        <td style="vertical-align: middle;">Apellido del 2ndo Autor</td>
        <td style="vertical-align: middle;">Nombre del 2ndo Autor</td>        
        <td style="vertical-align: middle;">Coautores</td>
        <td style="vertical-align: middle;">Diploma</td>
        <td style="vertical-align: middle;">Nombres Presentadores <?=$total_leen?></td>
        <td style="vertical-align: middle;">Apellidos Presentadores <?=$total_leen?></td>
        <td style="vertical-align: middle;">Presentador Inscripto <?=$total_inscriptos?></td>
        <td style="vertical-align: middle;">Estado</td>
        <td style="vertical-align: middle;">Cant Esp</td>
        <td style="vertical-align: middle;">Cant Port</td>
        <td style="vertical-align: middle;">Cant Bibliog</td>

	</tr>
<?php
$dias = array();
$sqlDias = "SELECT SUBSTRING(start_date,1,10) AS dia FROM cronograma GROUP BY SUBSTRING(start_date,1,10) ORDER BY SUBSTRING(start_date,1,10);";
$resultDias = $core->query($sqlDias);
$ord = 1;
foreach($resultDias as $rowDia){
	$dias[$rowDia["dia"]] = [
		"dia" => $rowDia["dia"],
		"orden" => $ord
	];
	$ord++;
}


$sql = "SELECT * FROM trabajos_libres WHERE estado <> 3 ORDER BY numero_tl ";
$rs = $core->query($sql);
foreach($rs as $row){
	
	$cantidadPalabras=sizeof(explode(" ",$row["resumen"]));
	$cantidadPalabras2=sizeof(explode(" ",$row["resumen2"]));
	$cantidadPalabras3=sizeof(explode(" ",$row["resumen3"]));
	
	if($row["estado"]==0){$NomEstado = "Recibidos";}
	elseif($row["estado"]==1){$NomEstado = "En Revisión";}
	elseif($row["estado"]==2){$NomEstado = "Aprobado";}
	elseif($row["estado"]==4){$NomEstado = "Notificados";}
	//elseif($row["estado"]==3){$NomEstado = "Rechazado";}

	/*echo "<tr><td>".$NomEstado."&nbsp;</td>";*/
	$UbicaDiaOrden = "";
	$UbicaDia = "";
	$UbicaSalaOrden = "";
	$UbicaSala = "";
	$UbicaHoraInicio = "";
	$Titulo_de_actividad = "";
	$tipo_actividad = "";
	$tematica = "";
	$dia_casillero = "";
	$sala_casillero = "";
	$hora_inicio_casillero = "";
	$hora_final_casillero = "";
	$orden_dia = "";
	$orden_sala = "";
	
	$sql4="SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid WHERE id_crono = ".$row['id_crono'];
	$rs4 = $core->query($sql4);
	
	if(count($rs4) > 0){
		$row4 = $rs4[0];
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
			
		if($row4["start_date"]){
			$dia_real = $core->helperDate($row4["start_date"],0,10);
			$dia_casillero = ucfirst(strftime($config["time_format"],strtotime($dia_real)));
			$dia_casillero = utf8_encode($dia_casillero);
			$orden_dia = $dias[$dia_real]["orden"];
			
			$hora_inicio_casillero = $core->helperDate($row4["start_date"],10,6);
		}
		if($row4["end_date"]){
			$hora_final_casillero = $core->helperDate($row4["end_date"],10,6);
		}
		if($row4["name"]){
			$sala_casillero = $row4["name"];
			$orden_sala = $row4["orden"];
		}
	}
	$coautores = "";
	$diploma = "";
	$autor1 = false;
	$inscript = "&nbsp;";
	$IDPresentador = 0;
	$sql3 = "SELECT * FROM trabajos_libres_participantes WHERE ID_Trabajos_libres = ". $row["id_trabajo"] .  " ORDER BY ID ASC";
	$rs3 = $core->query($sql3);
	$cantAutores = count($rs3);
	$ia = 0;
	$tieneCoautor = false;

    $txt_modalidad = "";
    $txt_tipo_conversatorio = "";
    if ($row["modalidad"]){
        $modalidad = $core->getModalidadByID($row["modalidad"]);
        $txt_modalidad = $modalidad["modalidad_es"];

        if ($row["modalidad"] == 1 && !empty($row["tipo_conversatorio"])){
            $tipo_conversatorio = $core->getTipoConversatorioByID($row["tipo_conversatorio"]);
            if (count($tipo_conversatorio) > 0) {
                $txt_tipo_conversatorio = $tipo_conversatorio["name_tipo_conversatorio_es"];
            }
        }
    }
?>
	<tr style="height: 60px;">
	<td align="left" style="vertical-align: middle;"><?=$row["id_trabajo"]?></td>
	<td align="left" style="vertical-align: middle;"><?=$row["numero_tl"]?>&nbsp;</td>
	<td align="left" style="vertical-align: middle;"><?=$row["clave"]?></td>
	<td align="left" style="vertical-align: middle;"><?=$row["archivo_tl"]?></td>
	<td align="left" style="vertical-align: middle;"><?=$dia_casillero?></td>
    <td align="left" style="vertical-align: middle;"><?=$orden_dia?></td>
	<td align="left" style="vertical-align: middle;"><?=$sala_casillero?></td>
    <td align="left" style="vertical-align: middle;"><?=$orden_sala?></td>
	<td align="left" style="vertical-align: middle;"><?=$hora_inicio_casillero?>&nbsp;</td>
    <td align="left" style="vertical-align: middle;"><?=$hora_final_casillero?>&nbsp;</td>
	<td align="left" style="vertical-align: middle;"><?=$tematica?></td>
	<td align="left" style="vertical-align: middle;"><?=$tipo_actividad?></td>
	<td align="left" style="vertical-align: middle;"><?=$Titulo_de_actividad?></td>
	<td align="left" style="vertical-align: middle;"><?=rem($row["titulo_tl"])?></td>
	<!--<td><?php //echo ucfirst(mb_strtolower(rem($row["titulo_tl"]),"utf-8"))?></td>-->
	<!--<td align="left" style="vertical-align: middle;"><?php //$core->getAreasTLID($row["area_tl"])?></td>-->
	<!--<td align="left" style="vertical-align: middle;">
	<?php
		/*if($row["tipo_tl"])
			echo $core->getTipoTLByID($row["tipo_tl"])["tipoTL_es"];*/
	?>
    </td>-->
    <td align="left" style="vertical-align: middle;"><?=$txt_modalidad?></td>
    <td align="left" style="vertical-align: middle;"><?=$txt_tipo_conversatorio?></td>
    <td align="left" style="vertical-align: middle;"><?=($row["apoyo_audiovisual"] == 1 ? 'Si' : 'No')?></td>
	<td align="left" style="vertical-align: middle;"><?=$row["contacto_ciudad"]?></td>
	<td align="left" style="vertical-align: middle;"><?=$row["contacto_mail"]?></td>
<?php	
	foreach($rs3 as $row3){
	    $pertenencia = "";
	    $inst = "";
        $inst_query = "";
	
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
            if(!empty($row2["pertenencia"])) {
                switch($row2["pertenencia"]) {
                    case 1:
                        $pertenencia = "Miembro FEPAL";
                        break;
                    case 2:
                        $pertenencia = "Analista en Formación";
                        break;
                    case 3:
                        $pertenencia = "Otro";
                        break;
                }
            }
            echo '<td align="left" style="vertical-align: middle;">'.$pertenencia.'</td>';

			if(!empty($row2["Institucion"])) {
			    if ($row2["Institucion"] == "Otra") {
                    $inst_query = $row2["Institucion_otro"];
                } else {
                    $inst_query = $row2["Institucion"];
                }
                $getInstitucion = $core->query("SELECT * FROM instituciones WHERE ID_Instituciones='".$inst_query."'");
                $inst = $getInstitucion[0]["Institucion"];
            }
				
			echo '<td align="left" style="vertical-align: middle;">'.$inst.'</td>';
			$pais = '';
			if($row2["Pais"])
				$pais = $core->getPaisID($row2["Pais"]);
			echo '<td align="left" style="vertical-align: middle;">'.$pais.'</td>';
			echo '<td align="left" style="vertical-align: middle;">'.$row2["Apellidos"].'</td>';
			echo '<td align="left" style="vertical-align: middle;">'.$row2["Nombre"].'</td>';
		}else{
			$coautores .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
		}
				
			
			if($ia==1)
			{
				echo '<td align="left" style="vertical-align: middle;">'.$row2["Apellidos"].'</td>';
				echo '<td align="left" style="vertical-align: middle;">'.$row2["Nombre"].'</td>';
				$tieneCoautor = true;
			}		
			
			$ia++;
			if($ia==$cantAutores && !$tieneCoautor)
			{
				echo '<td align="left" style="vertical-align: middle;">&nbsp;</td>';
				echo '<td align="left" style="vertical-align: middle;">&nbsp;</td>';
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
	<td align="left" style="vertical-align: middle;"><?=$coautores?></td>
	<td align="left" style="vertical-align: middle;"><?=$diploma?></td>	
		
	<td align="left" style="vertical-align: middle;"><?=$presentadorNombre?></td>	
	<td align="left" style="vertical-align: middle;"><?=$presentadorApellido?></td>	
	<td align="left" style="vertical-align: middle;"><?=$inscript?></td>	
	<td align="left" style="vertical-align: middle;"><?=$NomEstado?></td>
	<td align="left" style="vertical-align: middle;"><?=$cantidadPalabras?></td>
	<td align="left" style="vertical-align: middle;"><?=$cantidadPalabras2?></td>
	<td align="left" style="vertical-align: middle;"><?=$cantidadPalabras3?></td>
	
	</tr>
<?    

}
?>
</table>


