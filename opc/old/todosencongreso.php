<?
//include ('inc/sesion.inc.php');
include('inc/sesion.inc.php');
include('conexion.php');

?>
<title>Participantes del Congreso - Presionar Ctrl + E (para seleccionar) y luego Ctrl + C (para Copiar). Luego pegarlo en un excel</title>
<table width="98%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr >	
	<td width="7%" align="center"><strong>Dia</strong></td>
	<td width="10%" align="center"><strong>Sala</strong></td>
	<td width="6%" align="center"><strong>Hora</strong></td>
	<td width="8%" align="center"><strong>Actividad</strong></td>
	<td width="18%" align="center"><strong>TituloSession</strong></td>
	<td width="23%" align="center"><strong>TituloPresentacion</strong></td>
	<td width="6%" align="center"><strong>Calidad</strong></strong></td>
	<td width="10%" align="center"><strong>Apellido</strong></td>
	<td width="9%" align="center"><strong>Nombre</strong></td>
	<td width="9%" align="center"><strong>Pais</strong></td>

</tr>
<?
$sqlCDSH = "SELECT * FROM congreso WHERE Apellidos !='' or Nombre !='' ORDER BY Casillero, Orden_aparicion ASC" ; 
$rsCDSH = mysql_query($sqlCDSH, $con);
while($rowCDSH=mysql_fetch_array($rsCDSH)){

	if($rowCDSH["Dia_orden"]<=9){
		$diaOrden = "0" . $rowCDSH["Dia_orden"];
	}
	else{
		$diaOrden = $rowCDSH["Dia_orden"];
	}
	if($rowCDSH["Sala_orden"]<=9){
		$salaOrden = "0" . $rowCDSH["Sala_orden"];
	}
	else{
		$salaOrden = $rowCDSH["Sala_orden"];
	}
	
	$hora_ini = substr($rowCDSH["Hora_inicio"], 0, -3);
	
	echo "<tr>\n";
/*	echo "<td>".$diaOrden."&nbsp;</td>\n";
	echo "<td>".$salaOrden."&nbsp;</td>\n";*/
	echo "<td>".$rowCDSH["Dia"]."&nbsp;</td>\n";
	echo "<td>".$rowCDSH["Sala"]."&nbsp;</td>\n";
	echo "<td>".$hora_ini."&nbsp;</td>\n";
	echo "<td>".$rowCDSH["Tipo_de_actividad"]."&nbsp;</td>\n";
	echo "<td>".$rowCDSH["Titulo_de_actividad"]."&nbsp;</td>\n";
	echo "<td>".$rowCDSH["Titulo_de_trabajo"]."&nbsp;</td>\n";	
	echo "<td>".$rowCDSH["En_calidad"]."&nbsp;</td>\n";
	echo "<td>".$rowCDSH["Apellidos"]."&nbsp;</td>\n";
	echo "<td>".$rowCDSH["Nombre"]."&nbsp;</td>\n";
	echo "<td>".$rowCDSH["Pais"]."&nbsp;</td>\n";
	echo "</tr>\n";
	
}

?>

</table>