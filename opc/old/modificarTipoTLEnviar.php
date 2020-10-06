<?
include('inc/sesion.inc.php');
include('conexion.php');

$tipo_ = $_POST["tipo_"];

$tipo_viejo = $_POST["tipo_viejo"];

$sql2 = "SELECT tipoTL FROM tipo_de_trabajos_libres WHERE tipoTL ='". $tipo_viejo ."' LIMIT 1";
	$rs = mysql_query($sql2, $con);
	while($row=mysql_fetch_array($rs)){
		$sql3 = "UPDATE trabajos_libres SET tipo_tl = '$tipo_' WHERE tipo_tl = '". $row["tipoTL"];
		mysql_query($sql3, $con);
	}

$sql =  "UPDATE tipo_de_trabajos_libres SET ";
$sql .= "tipoTL = '" . $tipo_;

$sql .= "' WHERE tipoTL = '" . $tipo_viejo . "';";

mysql_query($sql, $con);

header("Location: altaTipoTL.php");
?>