<?
include('inc/sesion.inc.php');
include "conexion.php";
require "clases/inscripciones.php";
$inscripcion = new inscripciones;

?>
<title>Inscriptos VIA WEB - Presionar Ctrl + E (para seleccionar) y luego Ctrl + C (para Copiar). Luego pegarlo en un excel</title>
<table width="98%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr >
	
	<td width="4%" align="center"><strong>ID</strong></td>
	<td width="5%" align="center"><strong>Titulo</strong></td>
	<td width="8%" align="center"><strong>Nombre</strong></td>
	<td width="10%" align="center"><strong>Apellido</strong></td>
	<td width="9%" align="center"><strong>Instituci&oacute;n</strong></td>
	<td width="6%" align="center"><strong>Ciudad</strong></td>
	<td width="5%" align="center"><strong>Pa&iacute;s</strong></td>
	<td width="4%" align="center"><strong>Mail</strong></td>
	<td width="8%" align="center"><strong>Telefono</strong></td>
	<td width="3%" align="center"><strong>Fax</strong></td>
	<td width="10%" align="center"><strong>Inscripcion</strong></td>
	<td width="7%" align="center"><strong>Hotel</strong></td>
	<td width="10%" align="center"><strong>Llegada</strong></td>
	<td width="11%" align="center"><strong>Partida</strong></td>
	
  </tr>
<?
 	$lista = $inscripcion->listadoparaExcel();
	while ($row = mysql_fetch_object($lista)){
	
	
	echo "<tr>\n";
	echo '<td align="center">'.$row->identificador.'&nbsp;</td>';
	echo '<td align="center">'.$row->tituloAcademico.'&nbsp;</td>';
	echo '<td align="center">'.$row->nombre.'&nbsp;</td>';
	echo '<td align="center">'.$row->apellido.'&nbsp;</td>';
	echo '<td align="center">'.$row->institucion.'&nbsp;</td>';
	echo '<td align="center">'.$row->ciudad.'&nbsp;</td>';
	echo '<td align="center">'.$row->pais.'&nbsp;</td>';
	echo '<td align="center">'.$row->mail.'&nbsp;</td>';
	echo '<td align="center">'.$row->telefono.'&nbsp;</td>';
	echo '<td align="center">'.$row->fax.'&nbsp;</td>';
	echo '<td align="center">'.$row->tipoInscripcion.'&nbsp;</td>';
	echo '<td align="center">'.$row->apellidoCompa1.'&nbsp;</td>';
	echo '<td align="center">'.$row->arrival_info.'&nbsp;</td>';
	echo '<td align="center">'.$row->departure_info.'&nbsp;</td>';
	echo "</tr>\n";
	
}

?>
</table>
