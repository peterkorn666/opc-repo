<?
session_start();
$nombreEvaluador = $_SESSION["nombreEvaluador"];
header("Content-Disposition: attachment; filename=$nombreEvaluador.xls");
include "../conexion.php";
?>
<table width="98%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr>
	<td align="center"><strong>Nº trabajo</strong></td>
	<td width="10%" align="center"><strong>&iquest;Usted acepta evaluar este trabajo?</strong></td>
	<td width="10%" align="center"><strong>Recomendaci&oacute;n</strong></td>
	<td width="10%" align="center"><strong>El &aacute;rea tem&aacute;tica es adecuada</strong></td>
	<td width="10%" align="center"><strong>&iquest;El trabajo respeta el formato del template?</strong></td>
	<td width="10%" align="center"><strong>Forma de presentaci&oacute;n sugerida:</strong></td>
	<td width="10%" align="center"><strong>Comentarios, sugerencias y correcciones</strong></td>
	<td align="center"><strong>Fecha</strong></td>
  </tr>
<?
	$sqlT = "SELECT * FROM evaluaciones WHERE idEvaluador ='".$_SESSION["idEvaluador"]."' ORDER BY numero_tl;";
	$rsT = mysql_query($sqlT, $con);
	while ($row = mysql_fetch_object($rsT)){
		$sql = "SELECT * FROM trabajos_libres WHERE numero_tl='$row->numero_tl'";	
		$query = mysql_query($sql,$con);
		$rowL = mysql_fetch_object($query);
		if($rowL->estadoEvaluacion!=""){
			$estadoEvaluacion = "Si";
		}else{
			$estadoEvaluacion = "No";
		}
?>		
		<tr>
			<td><?=$row->numero_tl?></td>
			<td><?=$row->evaluar_trabajo?></td>
			<td><?=$row->estadoEvaluacion?></td>
			<td><?=$row->nota1?></td>
			<td><?=$row->nota2?></td>
			<td><?=$row->nota3?></td>
			<td><?=$row->comentarios?></td>
            <td><?=$row->fecha_asignado?></td>
		</tr>
<?php
}?>
</table>