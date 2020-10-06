<?
session_start();
$nombreEvaluador = $_SESSION["nombreEvaluador"];
header("Content-Disposition: attachment; filename=Estado Evaluadores.xls");
include "../conexion.php";
?>
<meta charset="utf-8">
<table width="98%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr>
	<td align="center"><strong>ID</strong></td>
    <td align="center"><strong>Evaluador</strong></td>
    <td align="center">País</td>
	<td align="center"><strong>Email</strong></td>
    <td align="center"><strong>Acepto</strong></td>
    <?php
	$sqlA = "SELECT * FROM areas_trabjos_libres";	
	$queryA = mysql_query($sqlA,$con);
	while($rowA = mysql_fetch_array($queryA)){
	?>
    <td align="center"><strong><?php echo $rowA['Area'] ?></strong></td>
    <?php } ?>
  </tr>
<?
	$sqlT = "SELECT * FROM evaluadores ORDER BY id";
	$rsT = mysql_query($sqlT, $con);
	while ($row = mysql_fetch_object($rsT)){
		$tematicas = json_decode($row->tematicas);
		if(count($tematicas)==0)
			$tematicas = array();
		echo "<tr>\n";
		echo '<td>'.$row->id.'&nbsp;</td>';
		echo '<td>'.$row->nombre.'&nbsp;</td>';
		echo '<td>'.$row->pais.'&nbsp;</td>';		
		echo '<td>'.$row->mail.'&nbsp;</td>';		
		echo '<td>'.$row->acepta_evaluador.'&nbsp;</td>';
		$sqlA = "SELECT * FROM areas_trabjos_libres";	
		$queryA = mysql_query($sqlA,$con);
		while($rowA = mysql_fetch_array($queryA)){
			$tem = 0;
			if(in_array($rowA['id'],$tematicas))
				$tem = 1;
			echo '<td>'.$tem.'&nbsp;</td>';
		}
		echo "</tr>\n";
}?>
</table>