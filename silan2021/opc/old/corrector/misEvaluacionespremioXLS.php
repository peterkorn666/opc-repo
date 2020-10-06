<?
session_start();
$nombreEvaluador = explode("(",$_SESSION["nombreEvaluador"]);
$nombreEvaluador = $nombreEvaluador[0];
header("Content-Disposition: attachment; filename=$nombreEvaluador.xls");
include "../conexion.php";
?>
<table width="98%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr>
	<td align="center"><strong>Nº trabajo</strong></td>
	<td align="center"><strong>Trabajo Completo</strong></td>
    <td align="center"><strong>Se presento a Oral o Poster</strong></td>
    <td align="center"><strong>Se presento a premio</strong></td>
    <td align="center"><strong>Puntaje</strong></td>
	<td align="center"><strong>Fecha</strong></td>
  </tr>
<?
	$sqlT = "SELECT * FROM evaluaciones WHERE idEvaluador ='".$_SESSION["idEvaluador"]."' ORDER BY numero_tl;";
	$rsT = mysql_query($sqlT, $con);
	while ($row = mysql_fetch_object($rsT)){
		$sql = "SELECT * FROM trabajos_libres WHERE numero_tl='$row->numero_tl'";	
		$query = mysql_query($sql,$con);
		$rowL = mysql_fetch_object($query);
		echo "<tr>\n";
		echo '<td>'.$row->numero_tl.'&nbsp;</td>';
		if($rowL->archivo_tl!=""){
			$archivoCompleto = "Si";
		}else{
			$archivoCompleto = "No";
		}	
		echo '<td>'.$archivoCompleto.'&nbsp;</td>';	
		echo '<td>'.$rowL->tipo_tl.'&nbsp;</td>';	
		echo '<td>'.$rowL->premio.'&nbsp;</td>';
		echo '<td>'.$row->puntajeTotal.'&nbsp;</td>';
		echo '<td>'.$row->fecha.'&nbsp;</td>';
		echo "</tr>\n";
}?>
</table>