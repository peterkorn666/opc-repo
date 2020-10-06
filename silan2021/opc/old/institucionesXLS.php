<?
header("Content-Disposition: attachment; filename=instituciones.xls");
include('inc/sesion.inc.php');
require "conexion.php";
function echotd($contenido,$prop)
{
	if($contenido==""){
		$contenido="&nbsp;";
	}
	echo "<td $prop>$contenido</td>";
}
$sqlTOTAL = "SELECT Institucion FROM personas_trabajos_libres WHERE 1 ";
$rsTOTAL = mysql_query($sqlTOTAL, $con);

	echo '<table width="98%" height="39" border="1"  bordercolor="#000000" cellspacing="0">';
	echo '<tr>';
	echotd("INSTITUCION ","bgcolor=#CCCCCC");
	echo '</tr>';
	
while($totalTLS = mysql_fetch_array($rsTOTAL)){
	echo "<tr>";
	echo "<td>".$totalTLS["Institucion"]."</td>";
	echo "</tr>";
}
?>
</table>

