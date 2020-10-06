<?
include('inc/sesion.inc.php');
include('conexion.php');
$sql2 = "SELECT Sala, Sala_orden, Dia, Dia_orden FROM congreso WHERE Casillero = '" . $_GET["id_casillero"] . "';";
$rs2 = mysql_query($sql2, $con);
while ($row2 = mysql_fetch_array($rs2)){
			$sala_= $row2["Sala"];
			$dia_= $row2["Dia"];
			$sala_orden_ = $row2["Sala_orden"];
			$dia_orden_ = $row2["Dia_orden"];

}

$sql = "DELETE FROM congreso WHERE Casillero = '" . $_GET["id_casillero"] . "';";
mysql_query($sql, $con);

$sql2 = "UPDATE trabajos_libres SET ID_casillero='0' WHERE ID_casillero='" . $_GET["id_casillero"] . "';";
mysql_query($sql2, $con);


if($_GET["crono"]==0){
	header ("Location:programaExtendido.php?dia_=" . $dia_orden_ . "&sala_=" . $sala_orden_);
}else{
	header ("Location:cronograma.php?dia_=" . $dia_orden_);
}

?>