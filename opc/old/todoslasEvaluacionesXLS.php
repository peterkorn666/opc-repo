<?
header("Content-Disposition: attachment; filename=Evaluaciones_".date("Ymd").".xls");

include "conexion.php";
/*require "clases/inscripciones.php";
$inscripcion = new inscripciones;*/

?>
<meta charset="utf-8">
<table width="98%" height="39" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
<tr >
	<td width="10%" align="center"><strong>Nº trabajo</strong></td>
    <td width="10%" align="center"><strong>Nombre Evaluador</strong></td>
    <td width="10%" align="center"><strong>Idioma TL</strong></td>
    <td width="10%" align="center"><strong>Área TL</strong></td>
    <td width="10%" align="center"><strong>Evaluación</strong></td>
	<td width="10%" align="center"><strong>Comentarios</strong></td>
	<td width="10%" align="center"><strong>Resumen Revisado</strong></td>
	<td width="10%" align="center"><strong>Fecha asignado</strong></td>
    <td width="10%" align="center"><strong>Fecha evaluado</strong></td>
    
  </tr>
<?
 	$sqlT = "SELECT * FROM evaluaciones as e JOIN trabajos_libres as t ON e.numero_tl=t.numero_tl ORDER BY t.area_tl,e.numero_tl;";
	$rsT = $con->query($sqlT);
	while ($row = $rsT->fetch_object()){	
		$sqlEv = "SELECT * FROM evaluadores WHERE id='".$row->idEvaluador."';";
		$rsEv = $con->query($sqlEv);
		$rowEv = $rsEv->fetch_array();
		
		$rem = array("<br>","<br />","<br >");
		$ram = array("","","");
		
		if($row->archivo_tl!=""){
			$archivoCompleto = "Si";
		}else{
			$archivoCompleto = "No";
		}
		
		if($row->estadoEvaluacion!=""){
			$resumenRevisado = "Si";
		}else{
			$resumenRevisado = "No";
		}
		
		//idioma tl
		$id_idioma_tl = str_replace($rem,$ram,$row->idioma);
		$sqlIdiomaTL = "SELECT idioma, code_idioma FROM tl_idiomas WHERE id='".$id_idioma_tl."';";
		$resultIdiomaTL = $con->query($sqlIdiomaTL);
		$rowIdiomaTL = $resultIdiomaTL->fetch_array();

		//area tl
		$id_area_tl = str_replace($rem,$ram,$row->area_tl);
		$sqlAreaTL = "SELECT Area_es, Area_en FROM areas_trabjos_libres WHERE id='".$id_area_tl."';";
		$resultAreaTL = $con->query($sqlAreaTL);
		$rowAreaTL = $resultAreaTL->fetch_array();
		
?>		
		<tr>
			<td align="center" style="vertical-align:middle"><?=$row->numero_tl?></td>
            <td align="center" height="75" style="vertical-align:middle"><?=$rowEv["nombre"]?></td>
			<td align="center" style="vertical-align:middle"><?=$rowIdiomaTL["idioma"]?></td>
            <td align="center" style="vertical-align:middle"><?=$rowAreaTL["Area_es"];?></td>
            <td align="center" style="vertical-align:middle"><?=$row->estadoEvaluacion?></td>
			<td valign="top"><?=$row->comentarios?></td>
			<td align="center" style="vertical-align:middle"><?=$resumenRevisado?></td>
            <td align="center" style="vertical-align:middle"><?=$row->fecha_asignado?></td>
			<td align="center" style="vertical-align:middle">
			<?php 
			if ($row->fecha != "0000-00-00")
				echo $row->fecha;
			else
				echo "No Evaluado";
			?></td>
		</tr>
<?php		
}

?>
</table>