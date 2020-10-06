<?php
	require("conexion.php");
	$sql = "SELECT * FROM trabajos_libres WHERE beca<>''";
	$query = mysql_query($sql,$con);
	//header('Content-Type: text/html; charset=iso-8859-1');
	header("Content-Disposition: attachment; filename=TravelGrant.xls");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table width="98%" height="39" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
<tr >
	<td width="8%" align="center"><strong>Nro</strong></td>
	<td width="10%" align="center"><strong>Cod. nuevo</strong></td>
    <td width="10%" align="center"><strong>Tipo TL</strong></td>
    <td width="10%" align="center"><strong>Nombre</strong></td>
    <td width="10%" align="center"><strong>Apellido</strong></td>
  </tr>
<?php
	while($row = mysql_fetch_object($query)){
		$sqlTP = "SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres=".$row->ID;
	//	echo $sqlTP." ";
		$queryTP = mysql_query($sqlTP,$con) or die(mysql_error());
		while($rowTP = mysql_fetch_object($queryTP)){
			$sqlP = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas=".$rowTP->ID_participante;
		//	echo $sqlP." ";
			$queryP = mysql_query($sqlP,$con);
			$rowP = mysql_fetch_object($queryP);
			
			echo "<tr>";
				echo "<td>".$row->numero_tl."</td>";
				echo "<td>".$row->abr_tl." ".$row->numeracion."</td>";
				echo "<td>".utf8_encode($row->tipo_tl)."</td>";
				echo "<td>".utf8_encode($rowP->Nombre)."</td>";
				echo "<td>".utf8_encode($rowP->Apellidos)."</td>";
			echo "</tr>";
		}
	}
?>
</table>
</body>
</html>