<?
include('inc/sesion.inc.php');
include('conexion.php');


$sql = "DELETE FROM congreso WHERE sala_agrupada = '" . $_GET["id_casillero"] . "';";
mysql_query($sql, $con);

if($_GET["crono"]==0){
	header ("Location:programaExtendido.php?dia_=" . $dia_orden_ . "&sala_=" . $sala_orden_);
}else{
	header ("Location:cronograma.php?dia_=" . $dia_orden_);
}

?>