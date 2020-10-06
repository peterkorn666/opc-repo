<?
include('inc/sesion.inc.php');
include('conexion.php');

$sql = "UPDATE congreso SET seExpande = '1', sala_agrupada='0' WHERE sala_agrupada = '".$_GET["id_casillero"] . "'";
mysql_query($sql, $con);

$dia_= $_GET["dia_"];


if($_GET["crono"]==0){
	header ("Location:programaExtendido.php?dia_=" . $dia_);
}else{
	header ("Location:cronograma.php?dia_=" . $dia_);
}

?>



