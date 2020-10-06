<?
header("Content-Disposition: attachment; filename=Evaluaciones.xls");

include "../conexion.php";
/*require "clases/inscripciones.php";
$inscripcion = new inscripciones;*/

?>
<table width="98%" height="39" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
<tr >
	<td width="8%" align="center"><strong>Trabajo</strong></td>
	<td width="10%" align="center"><strong>Promedio</strong></td>
  </tr>
<?
 	$sqlT = "SELECT * FROM evaluaciones as e JOIN trabajos_libres as t ON e.numero_tl=t.numero_tl ORDER BY t.area_tl,e.numero_tl;";
	$rsT = mysql_query($sqlT, $con);
	while ($row = mysql_fetch_object($rsT)){	
		$sqlEv = "SELECT * FROM evaluadores WHERE id='".$row->idEvaluador."';";
		$rsEv = mysql_query($sqlEv, $con);
		$rowEv = mysql_fetch_array($rsEv);
		
		$rem = array("<br>","<br />","<br >");
		$ram = array("","","");
		
		echo "<tr>\n";
		echo '<td align="center">'.$row->numero_tl.'&nbsp;</td>';
		echo '<td>'.$row->puntajeTotal.'&nbsp;</td>';
		echo "</tr>\n";
		
}

?>
</table>