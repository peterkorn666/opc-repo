<?
include('inc/sesion.inc.php');
include('conexion.php');
$id = $_GET["id"];

$sql2 = "SELECT tipoTL FROM tipo_de_trabajos_libres WHERE id =". $id ." LIMIT 1";
	$rs = mysql_query($sql2, $con);
	while($row=mysql_fetch_array($rs)){
		$sql3 = "UPDATE trabajos_libres SET tipo_tl = '$tipo_' WHERE tipo_tl = '". $row["tipoTL"];
		mysql_query($sql3, $con);
	}
	
$sql = "DELETE FROM tipo_de_trabajos_libres WHERE id = " . $id;
mysql_query($sql, $con);
header ("Location:altaTipoTL.php");
?>
