<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body >
<?
//include('inc/sesion.inc.php');
include("conexion.php");

echo '<div id="divDiasCronoListos" >';
$sql = "SELECT DISTINCT Dia_orden, Dia FROM congreso ORDER BY dia_orden";
$rs = mysql_query($sql, $con);
while($row = mysql_fetch_array($rs)){
	$dia = utf8_encode($row["Dia"]);
	$dia_ = $row["Dia_orden"];
	echo "<a href='cronograma.php?dia_=$dia_' >$dia</a><br>";
}
echo "</div>"
?>

</body>
</html>
